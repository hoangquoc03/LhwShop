<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ShopProduct;
use App\Services\EmbeddingService;
use App\Services\OllamaService;
use App\Services\QdrantService;
use Illuminate\Http\Request;

class OutfitController extends Controller
{
    public function __construct(
        protected OllamaService $ollamaService,
        protected EmbeddingService $embeddingService,
        protected QdrantService $qdrantService
    ) {}

    /**
     * Gợi ý outfit từ yêu cầu người dùng.
     *
     * Flow:
     * 1. Qwen phân tích intent
     * 2. Chuẩn hóa intent
     * 3. Embedding
     * 4. Qdrant tìm candidate
     * 5. PHP scoring + chọn sản phẩm
     * 6. Trả về outfit
     */
    public function recommend(Request $request)
    {
        $validated = $request->validate([
            'prompt' => ['required', 'string', 'max:2000'],
        ]);

        $prompt = trim($validated['prompt']);

        // =========================================================
        // 1. QWEN PHÂN TÍCH INTENT
        // =========================================================

        $intent = $this->ollamaService->analyzeIntent($prompt);

        $gender = mb_strtolower(
            trim((string) ($intent['gender'] ?? 'unisex'))
        );

        $style = mb_strtolower(
            trim((string) ($intent['style'] ?? ''))
        );

        $occasion = mb_strtolower(
            trim((string) ($intent['occasion'] ?? ''))
        );

        $items = $intent['items'] ?? [];
        $colors = $intent['colors'] ?? [];

        // =========================================================
        // 2. CHUẨN HÓA INTENT
        // =========================================================

        if (!in_array($gender, ['nam', 'nữ', 'unisex'], true)) {
            $gender = 'unisex';
        }

        if (!is_array($items)) {
            $items = [];
        }

        if (!is_array($colors)) {
            $colors = [];
        }

        $items = $this->normalizeItems($items);
        $colors = $this->normalizeColors($colors);

        // =========================================================
        // 3. TẠO TEXT CHO EMBEDDING
        // =========================================================

        $searchText = implode(' ', array_filter([
            $gender,
            $style,
            $occasion,
            implode(' ', $items),
            implode(' ', $colors),
        ]));

        $embedding = $this->embeddingService->embed($searchText);

        // =========================================================
        // 4. QDRANT SEARCH
        // =========================================================

        $results = $this->qdrantService->searchByIntent(
            $embedding,
            50,
            $gender
        );

        $products = collect($results)
            ->map(function ($result) {
                $payload = $result['payload'] ?? [];

                if (isset($result['score'])) {
                    $payload['_qdrant_score'] = (float) $result['score'];
                }

                return $payload;
            })
            ->filter(function ($product) {
                return !empty($product['product_id']);
            })
            ->values()
            ->all();

        // =========================================================
        // 5. KHÔNG CÓ PRODUCT TỪ QDRANT
        // =========================================================

        if (empty($products)) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm phù hợp.',
                'query' => $prompt,

                'intent' => [
                    'gender' => $gender,
                    'style' => $style,
                    'occasion' => $occasion,
                    'items' => $items,
                    'colors' => $colors,
                ],

                'outfit' => [
                    'outfit_name' => $this->buildOutfitName(
                        $style,
                        $occasion
                    ),

                    'style' => $style,
                    'occasion' => $occasion,

                    'explanation' => $this->buildExplanation(
                        $style,
                        $occasion
                    ),

                    'products' => [],
                ],
            ], 404);
        }

        // =========================================================
        // 6. PHP SCORING + BUILD OUTFIT
        // =========================================================

        $outfitProducts = $this->buildOutfitProducts(
            products: $products,
            items: $items,
            colors: $colors,
            gender: $gender,
            style: $style,
            occasion: $occasion
        );

        // =========================================================
        // 7. RESPONSE
        // =========================================================

        $outfit = [
            'outfit_name' => $this->buildOutfitName(
                $style,
                $occasion
            ),

            'style' => $style,
            'occasion' => $occasion,

            'explanation' => $this->buildExplanation(
                $style,
                $occasion
            ),

            'products' => $outfitProducts,
        ];

        return response()->json([
            'success' => true,

            'query' => $prompt,

            'intent' => [
                'gender' => $gender,
                'style' => $style,
                'occasion' => $occasion,
                'items' => $items,
                'colors' => $colors,
            ],

            'outfit' => $outfit,
        ]);
    }

    /**
     * Chọn sản phẩm tốt nhất cho từng item.
     */
    private function buildOutfitProducts(
        array $products,
        array $items,
        array $colors,
        string $gender,
        string $style,
        string $occasion
    ): array {
        $selected = [];
        $usedProductIds = [];

        // Nếu Qwen không xác định item cụ thể
        // thì tạo outfit cơ bản.
        if (empty($items)) {
            $items = [
                'áo',
                'quần',
                'giày',
            ];
        }

        // Chuẩn hóa item.
        $items = $this->normalizeItems($items);

        // =========================================================
        // LOAD SHOP PRODUCT
        // =========================================================

        $productIds = collect($products)
            ->pluck('product_id')
            ->filter()
            ->map(fn($id) => (int) $id)
            ->unique()
            ->values();

        $productModels = ShopProduct::whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        // =========================================================
        // CHỌN TỪNG ITEM
        // =========================================================

        foreach ($items as $item) {
            $item = mb_strtolower(
                trim((string) $item)
            );

            if ($item === '') {
                continue;
            }

            // =====================================================
            // 1. LỌC ĐÚNG LOẠI SẢN PHẨM
            // =====================================================

            $matchedProducts = collect($products)
                ->filter(function ($product) use (
                    $usedProductIds,
                    $item
                ) {
                    $productId = $product['product_id'] ?? null;

                    if (!$productId) {
                        return false;
                    }

                    // Không dùng cùng một sản phẩm 2 lần.
                    if (in_array(
                        (int) $productId,
                        $usedProductIds,
                        true
                    )) {
                        return false;
                    }

                    $text = $this->getProductMatchText($product);

                    // Bắt buộc đúng loại item.
                    // Chỉ kiểm tra tên + category + short_description,
                    // không dùng description để tránh các câu như
                    // "phối cùng quần jean" làm sản phẩm bị nhận nhầm là quần.
                    return $this->itemMatchScore(
                        text: $text,
                        item: $item
                    ) > 0;
                })
                ->map(function ($product) use (
                    $item,
                    $colors,
                    $gender,
                    $style,
                    $occasion
                ) {
                    $product['_match_score'] = $this->scoreProduct(
                        product: $product,
                        item: $item,
                        colors: $colors,
                        gender: $gender,
                        style: $style,
                        occasion: $occasion
                    );

                    return $product;
                })
                ->filter(function ($product) {
                    return ($product['_match_score'] ?? 0) > 0;
                })
                ->sortByDesc('_match_score')
                ->values();

            // Không có sản phẩm đúng loại => bỏ qua slot.
            if ($matchedProducts->isEmpty()) {
                continue;
            }

            // =====================================================
            // 2. LẤY PRODUCT TỐT NHẤT
            // =====================================================

            $product = $matchedProducts->first();

            $productId = (int) $product['product_id'];

            $usedProductIds[] = $productId;

            $productModel = $productModels->get($productId);

            unset($product['_match_score']);

            // =====================================================
            // 3. ROLE
            // =====================================================

            $role = $this->normalizeRole($item);

            $selected[] = [
                ...$product,

                'role' => $role,

                'reason' => $this->buildProductReason(
                    item: $item,
                    colors: $colors,
                    style: $style,
                    occasion: $occasion
                ),

                'model_3d' => $productModel?->model_3d_url,
            ];
        }

        return $selected;
    }

    /**
     * Lấy toàn bộ text của product để matching.
     */
    private function getProductText(array $product): string
    {
        return mb_strtolower(
            implode(' ', [
                $product['product_name'] ?? '',
                $product['category'] ?? '',
                $product['short_description'] ?? '',
                $product['description'] ?? '',
            ])
        );
    }
    private function getProductMatchText(array $product): string
    {
        return mb_strtolower(
            implode(' ', [
                $product['product_name'] ?? $product['name'] ?? '',
                $product['category'] ?? '',
                $product['short_description'] ?? '',
            ])
        );
    }

    /**
     * Scoring sản phẩm.
     */
    private function scoreProduct(
        array $product,
        string $item,
        array $colors,
        string $gender,
        string $style,
        string $occasion
    ): int {
        $name = mb_strtolower(
            (string) ($product['product_name'] ?? '')
        );

        $category = mb_strtolower(
            (string) ($product['category'] ?? '')
        );

        $shortDescription = mb_strtolower(
            (string) ($product['short_description'] ?? '')
        );

        $description = mb_strtolower(
            (string) ($product['description'] ?? '')
        );

        $text = implode(' ', [
            $name,
            $category,
            $shortDescription,
            $description,
        ]);

        // =========================================================
        // 1. ITEM MATCH BẮT BUỘC
        // =========================================================

        $itemScore = $this->itemMatchScore(
            text: $text,
            item: $item
        );

        if ($itemScore <= 0) {
            return 0;
        }

        $score = $itemScore;

        // =========================================================
        // 2. GENDER
        // =========================================================

        $genderScore = $this->genderMatchScore(
            category: $category,
            name: $name,
            gender: $gender
        );

        // Sai giới tính => loại.
        if ($genderScore < 0) {
            return 0;
        }

        $score += $genderScore;

        // =========================================================
        // 3. COLOR
        // =========================================================

        foreach ($colors as $color) {
            $color = mb_strtolower(
                trim((string) $color)
            );

            if ($color === '') {
                continue;
            }

            $productColors = $product['colors']
                ?? $product['color']
                ?? $product['color_name']
                ?? '';

            if (is_array($productColors)) {
                $productColors = implode(
                    ' ',
                    $productColors
                );
            }

            $productColors = mb_strtolower(
                (string) $productColors
            );

            $colorText = $productColors . ' ' . $text;

            if ($this->textContainsColor(
                $colorText,
                $color
            )) {
                $score += 25;
            }
        }

        // =========================================================
        // 4. STYLE
        // =========================================================

        if ($style !== '') {
            if (mb_stripos(
                $text,
                $style
            ) !== false) {
                $score += 10;
            }

            foreach (
                $this->styleKeywords($style)
                as $keyword
            ) {
                if (mb_stripos(
                    $text,
                    $keyword
                ) !== false) {
                    $score += 5;
                }
            }
        }

        // =========================================================
        // 5. OCCASION
        // =========================================================

        if ($occasion !== '') {
            if (mb_stripos(
                $text,
                $occasion
            ) !== false) {
                $score += 5;
            }
        }

        // =========================================================
        // 6. QDRANT SCORE
        // =========================================================

        $qdrantScore = (float) (
            $product['_qdrant_score'] ?? 0
        );

        if ($qdrantScore > 0) {
            $score += (int) round(
                min($qdrantScore, 1) * 10
            );
        }

        return $score;
    }

    /**
     * Điểm match loại sản phẩm.
     *
     * Đây là lớp bảo vệ quan trọng:
     *
     * item = quần
     * candidate = giày
     *
     * => score = 0
     */
    private function itemMatchScore(
        string $text,
        string $item
    ): int {
        $text = mb_strtolower(trim($text));
        $item = mb_strtolower(trim($item));

        $keywords = [
            'áo' => [
                'áo',
                'shirt',
                't-shirt',
                'sơ mi',
                'polo',
                'hoodie',
                'jacket',
                'khoác',
                'top',
                'bomber',
            ],

            'áo sơ mi' => [
                'áo sơ mi',
                'sơ mi',
                'dress shirt',
            ],

            'áo thun' => [
                'áo thun',
                'áo phông',
                't-shirt',
                'tee',
            ],

            'áo polo' => [
                'áo polo',
                'polo',
            ],

            'áo khoác' => [
                'áo khoác',
                'jacket',
                'windbreaker',
                'bomber',
                'khoác',
            ],

            'quần' => [
                'quần',
                'pants',
                'trousers',
                'shorts',
            ],

            'quần jean' => [
                'quần jean',
                'jean',
                'denim',
            ],

            'quần short' => [
                'quần short',
                'shorts',
            ],

            'váy' => [
                'váy',
                'skirt',
            ],

            'đầm' => [
                'đầm',
                'dress',
            ],

            'giày' => [
                'giày',
                'sneaker',
                'shoe',
                'boot',
                'loafer',
                'heel',
                'cao gót',
            ],

            'túi' => [
                'túi',
                'bag',
                'handbag',
                'backpack',
                'tote',
            ],

            'phụ kiện' => [
                'phụ kiện',
                'belt',
                'thắt lưng',
                'ví',
                'mũ',
                'nón',
                'kính',
            ],
        ];

        // Item không có trong mapping.
        if (!isset($keywords[$item])) {
            return mb_stripos(
                $text,
                $item
            ) !== false
                ? 40
                : 0;
        }

        foreach ($keywords[$item] as $keyword) {
            if (mb_stripos(
                $text,
                $keyword
            ) !== false) {
                return 50;
            }
        }

        return 0;
    }

    /**
     * Kiểm tra gender.
     */
    private function genderMatchScore(
        string $category,
        string $name,
        string $gender
    ): int {
        $text = mb_strtolower(
            $category . ' ' . $name
        );

        $isMale = str_contains(
            $text,
            'nam'
        );

        $isFemale = str_contains(
            $text,
            'nữ'
        );

        $isUnisex = str_contains(
            $text,
            'unisex'
        );

        // =========================================================
        // NAM
        // =========================================================

        if ($gender === 'nam') {
            if (
                $isFemale &&
                !$isMale &&
                !$isUnisex
            ) {
                return -100;
            }

            if (
                $isMale ||
                $isUnisex
            ) {
                return 20;
            }

            return 0;
        }

        // =========================================================
        // NỮ
        // =========================================================

        if ($gender === 'nữ') {
            if (
                $isMale &&
                !$isFemale &&
                !$isUnisex
            ) {
                return -100;
            }

            if (
                $isFemale ||
                $isUnisex
            ) {
                return 20;
            }

            return 0;
        }

        // =========================================================
        // UNISEX
        // =========================================================

        if ($gender === 'unisex') {
            if ($isUnisex) {
                return 30;
            }

            return 0;
        }

        return 0;
    }

    /**
     * Keyword bổ trợ cho style.
     */
    private function styleKeywords(
        string $style
    ): array {
        return match ($style) {
            'casual' => [
                'casual',
                'basic',
                'denim',
                'sneaker',
                'năng động',
            ],

            'streetwear' => [
                'streetwear',
                'oversize',
                'hoodie',
                'bomber',
                'cargo',
                'sneaker',
            ],

            'tối giản' => [
                'minimal',
                'minimalist',
                'basic',
                'tối giản',
            ],

            'thanh lịch' => [
                'thanh lịch',
                'elegant',
                'formal',
                'blazer',
                'sơ mi',
            ],

            'sang trọng' => [
                'sang trọng',
                'luxury',
                'elegant',
                'formal',
                'dress',
            ],

            'basic' => [
                'basic',
                'minimal',
                'tối giản',
            ],

            default => [
                $style,
            ],
        };
    }

    /**
     * Kiểm tra màu.
     */
    private function textContainsColor(
        string $text,
        string $color
    ): bool {
        $colorMap = [
            'đen' => [
                'đen',
                'black',
            ],

            'trắng' => [
                'trắng',
                'white',
            ],

            'đỏ' => [
                'đỏ',
                'red',
            ],

            'xanh' => [
                'xanh',
                'blue',
            ],

            'xanh dương' => [
                'xanh dương',
                'blue',
            ],

            'xanh navy' => [
                'xanh navy',
                'navy',
            ],

            'xanh lá' => [
                'xanh lá',
                'green',
            ],

            'vàng' => [
                'vàng',
                'yellow',
            ],

            'hồng' => [
                'hồng',
                'pink',
            ],

            'tím' => [
                'tím',
                'purple',
            ],

            'nâu' => [
                'nâu',
                'brown',
            ],

            'xám' => [
                'xám',
                'grey',
                'gray',
            ],
        ];

        $keywords = $colorMap[$color] ?? [
            $color,
        ];

        foreach ($keywords as $keyword) {
            if (mb_stripos(
                $text,
                $keyword
            ) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Chuẩn hóa màu.
     */
    private function normalizeColors(
        array $colors
    ): array {
        $normalized = [];

        foreach ($colors as $color) {
            $color = mb_strtolower(
                trim((string) $color)
            );

            if ($color === '') {
                continue;
            }

            $normalized[] = $color;
        }

        return array_values(
            array_unique($normalized)
        );
    }

    /**
     * Chuẩn hóa items nhưng không làm mất thông tin chi tiết.
     *
     * Ví dụ:
     * áo sơ mi  -> áo sơ mi
     * áo phông  -> áo thun
     * áo polo   -> áo polo
     * quần jean -> quần jean
     * quần short -> quần short
     * giày sneaker -> giày
     */
    private function normalizeItems(
        array $items
    ): array {
        $normalized = [];

        foreach ($items as $item) {
            $item = mb_strtolower(
                trim((string) $item)
            );

            if ($item === '') {
                continue;
            }

            // =====================================================
            // ÁO CỤ THỂ
            // =====================================================

            if (
                str_contains($item, 'áo sơ mi') ||
                str_contains($item, 'sơ mi')
            ) {
                $normalized[] = 'áo sơ mi';
                continue;
            }

            if (
                str_contains($item, 'áo thun') ||
                str_contains($item, 'áo phông') ||
                str_contains($item, 't-shirt') ||
                str_contains($item, 'tee')
            ) {
                $normalized[] = 'áo thun';
                continue;
            }

            if (
                str_contains($item, 'áo polo') ||
                $item === 'polo'
            ) {
                $normalized[] = 'áo polo';
                continue;
            }

            if (
                str_contains($item, 'áo khoác') ||
                str_contains($item, 'jacket') ||
                str_contains($item, 'bomber')
            ) {
                $normalized[] = 'áo khoác';
                continue;
            }

            // =====================================================
            // QUẦN CỤ THỂ
            // =====================================================

            if (
                str_contains($item, 'quần jean') ||
                str_contains($item, 'jean') ||
                str_contains($item, 'denim')
            ) {
                $normalized[] = 'quần jean';
                continue;
            }

            if (
                str_contains($item, 'quần short') ||
                str_contains($item, 'shorts')
            ) {
                $normalized[] = 'quần short';
                continue;
            }

            if (str_contains($item, 'quần')) {
                $normalized[] = 'quần';
                continue;
            }

            // =====================================================
            // VÁY
            // =====================================================

            if (str_contains($item, 'váy')) {
                $normalized[] = 'váy';
                continue;
            }

            // =====================================================
            // ĐẦM
            // =====================================================

            if (str_contains($item, 'đầm')) {
                $normalized[] = 'đầm';
                continue;
            }

            // =====================================================
            // GIÀY
            // =====================================================

            if (
                str_contains($item, 'giày') ||
                str_contains($item, 'sneaker') ||
                str_contains($item, 'shoe') ||
                str_contains($item, 'boot')
            ) {
                $normalized[] = 'giày';
                continue;
            }

            // =====================================================
            // TÚI
            // =====================================================

            if (
                str_contains($item, 'túi') ||
                str_contains($item, 'bag')
            ) {
                $normalized[] = 'túi';
                continue;
            }

            // =====================================================
            // PHỤ KIỆN
            // =====================================================

            if (
                str_contains($item, 'phụ kiện')
            ) {
                $normalized[] = 'phụ kiện';
                continue;
            }

            // =====================================================
            // ÁO CHUNG
            // =====================================================

            if (str_contains($item, 'áo')) {
                $normalized[] = 'áo';
                continue;
            }

            // =====================================================
            // FALLBACK
            // =====================================================

            $normalized[] = $item;
        }

        return array_values(
            array_unique($normalized)
        );
    }

    /**
     * Role hiển thị.
     */
    private function normalizeRole(
        string $item
    ): string {
        return match ($item) {
            'áo',
            'áo thun',
            'áo polo',
            'áo sơ mi',
            'áo khoác' => 'Áo',

            'quần',
            'quần jean',
            'quần short' => 'Quần',

            'váy' => 'Váy',

            'đầm' => 'Đầm',

            'giày' => 'Giày',

            'túi' => 'Túi',

            'phụ kiện' => 'Phụ kiện',

            default => ucfirst($item),
        };
    }

    /**
     * Lý do chọn sản phẩm.
     */
    private function buildProductReason(
        string $item,
        array $colors,
        string $style,
        string $occasion
    ): string {
        $role = $this->normalizeRole($item);

        $parts = [];

        $parts[] = "{$role} phù hợp";

        if ($style !== '') {
            $parts[] = "phong cách {$style}";
        }

        if ($occasion !== '') {
            $parts[] = "hoàn cảnh {$occasion}";
        }

        if (!empty($colors)) {
            $parts[] = 'màu ' . implode(
                ', ',
                $colors
            );
        }

        if (count($parts) === 1) {
            return $parts[0] . '.';
        }

        return $parts[0]
            . ' với '
            . implode(
                ' và ',
                array_slice($parts, 1)
            )
            . '.';
    }

    /**
     * Tên outfit.
     */
    private function buildOutfitName(
        string $style,
        string $occasion
    ): string {
        if ($style && $occasion) {
            return 'Outfit '
                . ucfirst($style)
                . ' - '
                . ucfirst($occasion);
        }

        if ($style) {
            return 'Outfit ' . ucfirst($style);
        }

        if ($occasion) {
            return 'Outfit - ' . ucfirst($occasion);
        }

        return 'Outfit gợi ý';
    }

    /**
     * Explanation.
     */
    private function buildExplanation(
        string $style,
        string $occasion
    ): string {
        if ($style && $occasion) {
            return "Outfit được lựa chọn theo phong cách {$style}, "
                . "phù hợp với hoàn cảnh {$occasion}.";
        }

        if ($style) {
            return "Outfit được lựa chọn theo phong cách {$style}.";
        }

        if ($occasion) {
            return "Outfit được lựa chọn phù hợp với {$occasion}.";
        }

        return 'Outfit được lựa chọn dựa trên yêu cầu của bạn.';
    }
}
