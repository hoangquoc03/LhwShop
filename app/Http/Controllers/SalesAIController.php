<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopProduct;
use App\Models\ShopCategory;
use App\Models\ShopSupplier;

class SalesAIController extends Controller
{
    private function normalize(string $text): string
    {
        $text = mb_strtolower(trim($text));

        $map = [
            'à' => 'a',
            'á' => 'a',
            'ạ' => 'a',
            'ả' => 'a',
            'ã' => 'a',
            'è' => 'e',
            'é' => 'e',
            'ẹ' => 'e',
            'ẻ' => 'e',
            'ẽ' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'ị' => 'i',
            'ỉ' => 'i',
            'ĩ' => 'i',
            'ò' => 'o',
            'ó' => 'o',
            'ọ' => 'o',
            'ỏ' => 'o',
            'õ' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'ụ' => 'u',
            'ủ' => 'u',
            'ũ' => 'u',
            'ỳ' => 'y',
            'ý' => 'y',
            'ỵ' => 'y',
            'ỷ' => 'y',
            'ỹ' => 'y',
            'đ' => 'd'
        ];

        return strtr($text, $map);
    }

    private function extractKeywords(string $text): array
    {
        $stopWords = [
            'toi',
            'muon',
            'mua',
            'can',
            'tim',
            'gia',
            'bao',
            'nhieu',
            'loai',
            'co',
            'khong',
            'duoi',
            'tren',
            'tu',
            'den'
        ];

        $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $text);
        $words = explode(' ', $this->normalize($text));

        return array_values(array_diff(array_filter($words), $stopWords));
    }

    /* =====================
        MATCH CATEGORY
    ======================*/
    private function matchCategory(array $keywords)
    {
        $categories = ShopCategory::all();

        foreach ($categories as $cat) {
            $name = $this->normalize($cat->categories_text);

            foreach ($keywords as $kw) {
                if (str_contains($name, $kw)) {
                    return $cat;
                }
            }
        }

        return null;
    }

    /* =====================
        MATCH SUPPLIER
    ======================*/
    private function matchSupplier(array $keywords)
    {
        $suppliers = ShopSupplier::all();

        foreach ($suppliers as $sup) {
            $name = $this->normalize($sup->categories_text ?? '');

            foreach ($keywords as $kw) {
                if (str_contains($name, $kw)) {
                    return $sup;
                }
            }
        }

        return null;
    }

    /* =====================
        PRICE PARSER
    ======================*/
    private function detectPriceRange(string $text): ?array
    {
        if (preg_match('/dưới\s*(\d+)\s*(tr|triệu)/u', $text, $m)) {
            return ['min' => 0, 'max' => $m[1] * 1000000];
        }

        if (preg_match('/tầm\s*(\d+)\s*(tr|triệu)/u', $text, $m)) {
            $p = $m[1] * 1000000;
            return ['min' => $p * 0.8, 'max' => $p * 1.2];
        }

        if (preg_match('/(\d+)\s*(tr|triệu)/u', $text, $m)) {
            return ['min' => $m[1] * 1000000 * 0.9, 'max' => $m[1] * 1000000 * 1.1];
        }

        return null;
    }


    private function detectIntent(string $text): string
    {
        if (str_contains($text, 'so sánh')) return 'compare';
        if (str_contains($text, 'rẻ') || str_contains($text, 'dưới')) return 'filter_price';
        if (str_contains($text, 'sale') || str_contains($text, 'voucher')) return 'promotion';
        if (str_contains($text, 'mua')) return 'buy';
        return 'browse';
    }




    /* =====================
        CHAT ENTRY
    ======================*/
    public function chat(Request $request)
    {
        $message = trim($request->message ?? '');

        /* RESET */
        if ($message === '__start__') {
            session()->forget('chat_context');

            return response()->json([
                'reply' =>
                "👋 <b>Chào anh/chị!</b><br>
            Em là trợ lý tư vấn mua sắm 👕👟<br><br>
            👉 Anh/chị có thể hỏi:<br>
            • Giày nam dưới 50 triệu<br>
            • Áo local brand đang sale<br>
            • Sản phẩm có voucher"
            ]);
        }

        if (!$message) {
            return response()->json(['reply' => '🤖 Anh/chị nhập giúp em nội dung nhé!']);
        }

        /* LOAD CONTEXT */
        $context = session()->get('chat_context', [
            'category'   => null,
            'supplier'   => null,
            'gender'     => null,
            'priceRange' => null,
            'intent'     => null,
        ]);


        /* ANALYZE */
        $text     = $this->normalize($message);
        $keywords = $this->extractKeywords($message);
        $context['intent'] = $this->detectIntent($text);


        if ($supplier = $this->matchSupplier($keywords)) {
            $context['supplier'] = $supplier->id;
        }

        if ($range = $this->detectPriceRange($text)) {
            $context['priceRange'] = $range;
        }
        if ($category = $this->matchCategory($keywords)) {
            $context['category'] = $category->id;
        }
        if (preg_match('/\b(nam|nữ|nu)\b/u', $text, $m)) {
            $context['gender'] = $m[1];
        }


        if (!$context['category'] && str_contains($text, 'giày')) {
            $context['category'] = ShopCategory::where('categories_text', 'like', '%giày%')->value('id');
        }
        if (!$context['priceRange']) {
            return response()->json([
                'reply' => '💰 Anh/chị cho em biết <b>tầm giá mong muốn</b> để em tư vấn chính xác hơn ạ?'
            ]);
        }





        session()->put('chat_context', $context);

        /* QUERY */
        $products = ShopProduct::with(['category', 'supplier', 'discount', 'vouchers'])
            ->where('discontinued', false);


        if ($context['category']) {
            $products->where('category_id', $context['category']);
        }

        if ($context['supplier']) {
            $products->where('supplier_id', $context['supplier']);
        }

        if ($context['priceRange']) {
            $products->whereBetween(
                'list_price',
                [$context['priceRange']['min'], $context['priceRange']['max']]
            );
        }


        if (str_contains($text, 'sale') || str_contains($text, 'voucher')) {
            $products->where(function ($q) {
                $q->whereHas('discount')
                    ->orWhereHas('vouchers');
            });
        }
        if ($context['gender']) {
            $products->whereHas('category', function ($q) use ($context) {
                $q->where('categories_text', 'like', '%' . $context['gender'] . '%');
            });
        }


        $products = $products->limit(5)->get();

        /* FALLBACK CHỈ KHI KHÔNG CÓ KẾT QUẢ */
        if ($products->isEmpty() && $context['priceRange']) {
            $fallback = ShopProduct::with(['category', 'supplier'])
                ->where('list_price', '>=', $context['priceRange']['min']);

            if ($context['category']) {
                $fallback->where('category_id', $context['category']);
            }

            if ($context['supplier']) {
                $fallback->where('supplier_id', $context['supplier']);
            }

            $products = $fallback
                ->orderBy('list_price', 'asc')
                ->limit(3)
                ->get();
        }



        /* BUILD RESPONSE */
        $reply = "🎯 <b>Em gợi ý cho anh/chị:</b><br><br>";
        if ($products->isEmpty() && $context['priceRange']) {
            $upsell = ShopProduct::where('list_price', '>=', $context['priceRange']['max'])
                ->where('list_price', '<=', $context['priceRange']['max'] * 1.3)
                ->limit(3)
                ->get();

            if ($upsell->isNotEmpty()) {
                $reply = "💎 <b>Dòng cao cấp gần mức anh/chị chọn:</b><br><br>";
                foreach ($upsell as $p) {
                    $reply .= "👟 {$p->product_name}<br>";
                    $reply .= "💰 " . number_format($p->list_price) . "đ<br><br>";
                }
                return response()->json(['reply' => $reply]);
            }
        }
        if ($context['intent'] === 'compare' && $products->count() >= 2) {
            $p1 = $products[0];
            $p2 = $products[1];

            return response()->json([
                'reply' =>
                "📊 <b>So sánh nhanh:</b><br><br>
        <b>{$p1->product_name}</b><br>
        💰 " . number_format($p1->list_price) . "đ<br>
        🏷 {$p1->supplier->categories_text}<br><br>

        <b>{$p2->product_name}</b><br>
        💰 " . number_format($p2->list_price) . "đ<br>
        🏷 {$p2->supplier->categories_text}<br><br>

        👉 Anh/chị muốn em chốt mẫu nào ạ?"
            ]);
        }



        foreach ($products as $p) {
            $price = $p->list_price;

            if ($p->discount) {
                $price -= ($price * $p->discount_percent / 100);
                $reply .= "🔥 ";
            }

            $reply .= "<b>{$p->product_name}</b><br>";
            $reply .= "💰 " . number_format($price, 0, ',', '.') . "đ<br>";

            if ($p->vouchers->count()) {
                $reply .= "🎁 Có voucher áp dụng<br>";
            }

            $reply .= "👉 <a href='" . route('product.show', $p->id) . "' target='_blank'>Xem chi tiết</a><br><br>";
        }

        $reply .= "✨ Anh/chị muốn lọc thêm theo <b>thương hiệu</b> hay <b>sale</b> không ạ?";

        return response()->json(['reply' => $reply]);
    }
}