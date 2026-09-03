<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
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
            10,
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

        $outfit = $this->ollamaService->composeOutfit(
            $prompt,
            $products
        );

        // ==========================================
        // 6. MAP PRODUCT ID
        // ==========================================

        $productMap = collect($products)
            ->keyBy('product_id');

        $outfit['products'] = collect(
            $outfit['products'] ?? []
        )
            ->map(function ($item) use ($productMap) {
                $productId = $item['product_id'] ?? null;

                if (!$productId || !$productMap->has($productId)) {
                    return null;
                }

                return [
                    ...$productMap->get($productId),
                    'role' => $item['role'] ?? null,
                    'reason' => $item['reason'] ?? null,
                ];
            })
            ->filter()
            ->values()
            ->all();

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
}
