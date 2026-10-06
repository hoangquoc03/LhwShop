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

    public function recommend(Request $request)
    {
        $validated = $request->validate([
            'prompt' => ['required', 'string', 'max:2000'],
        ]);

        $prompt = $validated['prompt'];

        // ==========================================
        // 1. QWEN PHÂN TÍCH INTENT
        // ==========================================

        $intent = $this->ollamaService->analyzeIntent($prompt);

        // Chuẩn hóa dữ liệu
        $gender = $intent['gender'] ?? 'unisex';
        $style = $intent['style'] ?? '';
        $occasion = $intent['occasion'] ?? '';
        $items = $intent['items'] ?? [];
        $colors = $intent['colors'] ?? [];

        // Chỉ cho phép các giá trị hợp lệ
        if (!in_array($gender, ['nam', 'nữ', 'unisex'])) {
            $gender = 'unisex';
        }

        if (!is_array($items)) {
            $items = [];
        }
        $items = $this->normalizeItems($items);

        if (!is_array($colors)) {
            $colors = [];
        }

        // ==========================================
        // 2. TẠO QUERY CHO QDRANT
        // ==========================================

        $searchText = implode(' ', array_filter([
            $gender,
            $style,
            $occasion,
            implode(' ', $items),
            implode(' ', $colors),
        ]));

        $embedding = $this->embeddingService->embed($searchText);

        // ==========================================
        // 3. QDRANT TÌM SẢN PHẨM
        // ==========================================

        $results = $this->qdrantService->searchByIntent(
            $embedding,
            20,
            $gender
        );

        $products = collect($results)
            ->map(function ($result) {
                return $result['payload'] ?? [];
            })
            ->filter(function ($product) {
                return !empty($product['product_id']);
            })
            ->values()
            ->all();

        // ==========================================
        // 4. KHÔNG CÓ SẢN PHẨM
        // ==========================================

        if (empty($products)) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm phù hợp.',
                'intent' => $intent,
                'products' => [],
            ], 404);
        }

        // ==========================================
        // 5. QWEN CHỌN + GHÉP OUTFIT
        // ==========================================

        // ==========================================
        // 5. PHP TỰ GHÉP OUTFIT
        // Không gọi Qwen lần thứ 2
        // ==========================================

        $outfitProducts = $this->buildOutfitProducts(
            $products,
            $items,
            $style,
            $occasion
        );

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

        // ==========================================
        // 7. RESPONSE
        // ==========================================

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
     * Ghép sản phẩm thành outfit bằng PHP.
     *
     * Không gọi AI lần thứ 2.
     */

    private function buildOutfitProducts(
        array $products,
        array $items,
        string $style,
        string $occasion
    ): array {
        $selected = [];
        $usedProductIds = [];

        foreach ($items as $item) {
            $item = mb_strtolower(trim((string) $item));

            $product = collect($products)
                ->first(function ($product) use (
                    $item,
                    $usedProductIds
                ) {
                    $productId = $product['product_id'] ?? null;

                    if (!$productId) {
                        return false;
                    }

                    if (in_array($productId, $usedProductIds)) {
                        return false;
                    }

                    return $this->productMatchesItem(
                        $product,
                        $item
                    );
                });

            if (!$product) {
                continue;
            }

            $productId = $product['product_id'];

            $usedProductIds[] = $productId;
            $productModel = ShopProduct::find($productId);
            $selected[] = [
                ...$product,
                'role' => $this->normalizeRole($item),
                'reason' => $this->buildProductReason(
                    $item,
                    $style,
                    $occasion
                ),
                'model_3d' => $productModel?->model_3d_url,
            ];
        }

        return $selected;
    }
    /**
     * Kiểm tra sản phẩm có phù hợp với loại item hay không.
     */
    private function productMatchesItem(
        array $product,
        string $item
    ): bool {
        $name = mb_strtolower(
            (string) ($product['name'] ?? '')
        );

        $category = mb_strtolower(
            (string) ($product['category'] ?? '')
        );

        $text = $name . ' ' . $category;

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
            ],

            'quần' => [
                'quần',
                'jean',
                'pants',
                'trousers',
                'shorts',
            ],

            'váy' => [
                'váy',
                'dress',
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
            ],

            'túi' => [
                'túi',
                'bag',
                'handbag',
                'backpack',
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

        $itemKeywords = $keywords[$item] ?? [$item];

        foreach ($itemKeywords as $keyword) {
            if (mb_stripos($text, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }
    private function normalizeRole(string $item): string
    {
        return match ($item) {
            'áo' => 'Áo',
            'quần' => 'Quần',
            'váy' => 'Váy',
            'đầm' => 'Đầm',
            'giày' => 'Giày',
            'túi' => 'Túi',
            'phụ kiện' => 'Phụ kiện',
            default => ucfirst($item),
        };
    }
    private function buildProductReason(
        string $item,
        string $style,
        string $occasion
    ): string {
        $role = $this->normalizeRole($item);

        return "{$role} phù hợp với phong cách {$style}" .
            ($occasion
                ? " và hoàn cảnh {$occasion}."
                : '.');
    }
    private function buildOutfitName(
        string $style,
        string $occasion
    ): string {
        if ($style && $occasion) {
            return 'Outfit ' .
                ucfirst($style) .
                ' - ' .
                ucfirst($occasion);
        }

        if ($style) {
            return 'Outfit ' . ucfirst($style);
        }

        return 'Outfit gợi ý';
    }
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
    private function normalizeItems(array $items): array
    {
        $normalized = [];

        foreach ($items as $item) {
            $item = mb_strtolower(trim((string) $item));

            if ($item === '') {
                continue;
            }

            // Qwen có thể trả "áo quần" thay vì ["áo", "quần"]
            if (str_contains($item, 'áo')) {
                $normalized[] = 'áo';
            }

            if (str_contains($item, 'quần')) {
                $normalized[] = 'quần';
            }

            if (str_contains($item, 'váy')) {
                $normalized[] = 'váy';
            }

            if (str_contains($item, 'đầm')) {
                $normalized[] = 'đầm';
            }

            if (str_contains($item, 'giày')) {
                $normalized[] = 'giày';
            }

            if (str_contains($item, 'túi')) {
                $normalized[] = 'túi';
            }

            if (str_contains($item, 'phụ kiện')) {
                $normalized[] = 'phụ kiện';
            }

            // Nếu không thuộc nhóm nào thì giữ nguyên
            if (
                !str_contains($item, 'áo') &&
                !str_contains($item, 'quần') &&
                !str_contains($item, 'váy') &&
                !str_contains($item, 'đầm') &&
                !str_contains($item, 'giày') &&
                !str_contains($item, 'túi') &&
                !str_contains($item, 'phụ kiện')
            ) {
                $normalized[] = $item;
            }
        }

        return array_values(array_unique($normalized));
    }
}