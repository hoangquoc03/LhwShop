<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ShopCategory;
use App\Models\ShopProduct;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class OutfitController extends Controller
{
    public function __construct(
        protected OpenAIService $openAIService
    ) {}

    /**
     * POST /outfit/recommend
     */
    public function recommend(Request $request)
    {
        $validated = $request->validate([
            'prompt' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);

        try {

            /*
             * ==================================================
             * 1. AI phân tích yêu cầu
             * ==================================================
             */

            $requirements = $this->openAIService
                ->analyzeOutfitRequest(
                    $validated['prompt']
                );


            /*
             * ==================================================
             * 2. Tìm sản phẩm thật trong database
             * ==================================================
             */

            $outfitItems = [];

            foreach ($requirements['items'] ?? [] as $item) {

                $products = $this->findProducts(
                    $item,
                    $requirements
                );

                $outfitItems[] = [
                    'type' => $item['type'],

                    'requirements' => [
                        'keywords' => $item['keywords'] ?? [],
                        'colors' => $item['colors'] ?? [],
                    ],

                    'products' => $products->values(),
                ];
            }


            /*
             * ==================================================
             * 3. Tính tổng tiền
             * ==================================================
             *
             * Dùng final_price thay vì list_price
             * để tính đúng giá sau giảm.
             */

            $totalPrice = 0;

            foreach ($outfitItems as $item) {

                if (!empty($item['products'])) {

                    $totalPrice += (float) (
                        $item['products'][0]['final_price']
                        ?? $item['products'][0]['price']
                        ?? 0
                    );
                }
            }


            /*
             * ==================================================
             * 4. Response JSON
             * ==================================================
             */

            return response()->json([
                'success' => true,

                'message' => 'Đã tạo gợi ý outfit.',

                'data' => [
                    'requirements' => $requirements,

                    'outfit' => [
                        'items' => $outfitItems,

                        'total_price' => $totalPrice,

                        'budget' => (float) (
                            $requirements['budget'] ?? 0
                        ),
                    ],
                ],
            ]);
        } catch (\Throwable $e) {

            Log::error(
                'Outfit recommendation error',
                [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'request' => $request->all(),
                ]
            );

            return response()->json([
                'success' => false,

                'message' => 'Không thể tạo outfit lúc này.',

                'error' => config('app.debug')
                    ? $e->getMessage()
                    : null,

            ], 500);
        }
    }


    /**
     * Tìm sản phẩm phù hợp với item AI trả về.
     */
    protected function findProducts(
        array $item,
        array $requirements
    ): Collection {

        /*
         * ==================================================
         * 1. Category
         * ==================================================
         */

        $categoryIds = $this->findCategoryIds(
            $item['type']
        );


        /*
         * ==================================================
         * 2. Query chính
         * ==================================================
         */

        $query = ShopProduct::query()
            ->with([
                'images',
                'category',
                'discount',
                'variants',
            ])
            ->where(function ($q) {

                $q->whereNull('discontinued')
                    ->orWhere('discontinued', 0);
            });


        /*
         * Category
         */

        if (!empty($categoryIds)) {

            $query->whereIn(
                'category_id',
                $categoryIds
            );
        }


        /*
         * ==================================================
         * 3. Keywords
         * ==================================================
         */

        $keywords = $item['keywords'] ?? [];

        if (!empty($keywords)) {

            $query->where(function ($q) use ($keywords) {

                foreach ($keywords as $keyword) {

                    $keyword = trim($keyword);

                    if ($keyword === '') {
                        continue;
                    }

                    $q->orWhere(
                        'product_name',
                        'LIKE',
                        '%' . $keyword . '%'
                    );

                    $q->orWhere(
                        'short_description',
                        'LIKE',
                        '%' . $keyword . '%'
                    );

                    $q->orWhere(
                        'description',
                        'LIKE',
                        '%' . $keyword . '%'
                    );
                }
            });
        }


        /*
         * ==================================================
         * 4. Budget
         * ==================================================
         *
         * Lưu ý:
         * budget là tổng outfit.
         *
         * Ở đây chỉ dùng budget làm giới hạn
         * cho từng sản phẩm.
         */

        $budget = (float) (
            $requirements['budget'] ?? 0
        );

        if ($budget > 0) {

            $query->where(
                'list_price',
                '<=',
                $budget
            );
        }


        /*
         * ==================================================
         * 5. Lấy products
         * ==================================================
         */

        $products = $query
            ->orderByDesc('is_featured')
            ->orderByDesc('is_new')
            ->orderByDesc('id')
            ->limit(10)
            ->get();


        /*
         * ==================================================
         * 6. Fallback
         * ==================================================
         */

        if ($products->isEmpty()) {

            $fallbackQuery = ShopProduct::query()
                ->with([
                    'images',
                    'category',
                    'discount',
                    'variants',
                ])
                ->where(function ($q) {

                    $q->whereNull('discontinued')
                        ->orWhere('discontinued', 0);
                });

            if (!empty($categoryIds)) {

                $fallbackQuery->whereIn(
                    'category_id',
                    $categoryIds
                );
            }

            if ($budget > 0) {

                $fallbackQuery->where(
                    'list_price',
                    '<=',
                    $budget
                );
            }

            $products = $fallbackQuery
                ->orderByDesc('is_featured')
                ->orderByDesc('is_new')
                ->orderByDesc('id')
                ->limit(10)
                ->get();
        }


        /*
         * ==================================================
         * 7. Format
         * ==================================================
         */

        return $products->map(
            function ($product) {

                $discountPercent = (float) (
                    $product->discount_percent ?? 0
                );

                $finalPrice = (float) (
                    $product->list_price ?? 0
                );

                if (
                    $product->discount &&
                    $discountPercent > 0
                ) {

                    if (!$product->discount->is_fixed) {

                        $finalPrice =
                            $product->list_price
                            * (1 - $discountPercent / 100);
                    } else {

                        $finalPrice =
                            $product->list_price
                            - (
                                $product->discount
                                ->discount_amount
                                ?? 0
                            );
                    }
                }


                return [
                    'id' => $product->id,

                    'product_code' =>
                    $product->product_code,

                    'name' =>
                    $product->product_name,

                    'price' =>
                    (float) $product->list_price,

                    'final_price' =>
                    max(
                        0,
                        (float) $finalPrice
                    ),

                    'discount_percent' =>
                    $discountPercent,

                    'image' =>
                    $product->image,

                    'images' =>
                    $product->images
                        ->map(function ($image) {

                            return [
                                'id' => $image->id,
                                'image' => $image->image,
                            ];
                        })
                        ->values(),

                    'category' =>
                    $product->category
                        ? [
                            'id' =>
                            $product->category->id,

                            'name' =>
                            $product->category
                                ->categories_text,
                        ]
                        : null,

                    'short_description' =>
                    $product->short_description,

                    'is_featured' =>
                    (bool) $product->is_featured,

                    'is_new' =>
                    (bool) $product->is_new,
                ];
            }
        )->values();
    }


    /**
     * Tìm category ID.
     */
    protected function findCategoryIds(
        string $itemType
    ): array {

        $mapping = [

            'top' => [
                'áo',
                'shirt',
                'top',
                't-shirt',
                'thun',
            ],

            'bottom' => [
                'quần',
                'pants',
                'short',
                'jeans',
                'chân váy',
                'váy',
            ],

            'dress' => [
                'váy',
                'dress',
            ],

            'shoes' => [
                'giày',
                'sneaker',
                'shoe',
                'dép',
                'sandal',
            ],

            'bag' => [
                'túi',
                'bag',
                'handbag',
                'backpack',
            ],

            'accessory' => [
                'phụ kiện',
                'accessory',
                'mũ',
                'nón',
                'thắt lưng',
            ],

            'outerwear' => [
                'khoác',
                'áo khoác',
                'jacket',
                'blazer',
                'cardigan',
            ],
        ];

        $keywords =
            $mapping[$itemType] ?? [];

        if (empty($keywords)) {
            return [];
        }

        $query = ShopCategory::query();

        $query->where(function ($q) use ($keywords) {

            foreach ($keywords as $keyword) {

                $q->orWhere(
                    'categories_text',
                    'LIKE',
                    '%' . $keyword . '%'
                );

                $q->orWhere(
                    'description',
                    'LIKE',
                    '%' . $keyword . '%'
                );
            }
        });

        return $query
            ->pluck('id')
            ->toArray();
    }
}
