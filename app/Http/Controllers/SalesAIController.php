<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopProduct;
use App\Models\ShopCategory;

class SalesAIController extends Controller
{
    /* =====================
        TIỆN ÍCH XỬ LÝ TEXT
    ======================*/

    private function normalize(string $text): string
    {
        $text = mb_strtolower(trim($text));

        $map = [
            'à'=>'a','á'=>'a','ạ'=>'a','ả'=>'a','ã'=>'a',
            'è'=>'e','é'=>'e','ẹ'=>'e','ẻ'=>'e','ẽ'=>'e',
            'ì'=>'i','í'=>'i','ị'=>'i','ỉ'=>'i','ĩ'=>'i',
            'ò'=>'o','ó'=>'o','ọ'=>'o','ỏ'=>'o','õ'=>'o',
            'ù'=>'u','ú'=>'u','ụ'=>'u','ủ'=>'u','ũ'=>'u',
            'ỳ'=>'y','ý'=>'y','ỵ'=>'y','ỷ'=>'y','ỹ'=>'y',
            'đ'=>'d'
        ];

        return strtr($text, $map);
    }

    private function extractKeywords(string $text): array
    {
        $stopWords = [
            'toi','muon','mua','can','cho','xin','la','co','khong',
            'gia','bao','nhieu','mot','cai','loai'
        ];

        $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $text);
        $words = array_filter(explode(' ', $this->normalize($text)));

        return array_values(array_diff($words, $stopWords));
    }

    /* =====================
        MATCH THÔNG MINH (AI)
    ======================*/

    private function matchSmart(string $input, string $productName): int
    {
        $inputWords   = $this->extractKeywords($input);
        $productWords = explode(' ', $this->normalize($productName));

        $score = 0;

        foreach ($inputWords as $i => $word) {
            foreach ($productWords as $j => $pw) {

                // Khớp từ đầu
                if (str_starts_with($pw, $word)) {
                    $score += ($i === $j) ? 5 : 3;
                    break;
                }

                // Sai chính tả nhẹ
                if (levenshtein($word, $pw) <= 1) {
                    $score += 1;
                    break;
                }
            }
        }

        return $score;
    }

    /* =====================
        CHAT CONTROLLER
    ======================*/

    public function chat(Request $request)
    {
        $message = trim($request->message ?? '');

        /* 1️⃣ START CHAT */
        if ($message === '__start__') {

            $categories = ShopCategory::where('active', true)->get();

            $reply  = "👋 <b>Chào mừng bạn đến với LHW Shop</b>\n\n";
            $reply .= "🤖 Em là trợ lý bán hàng 24/7\n\n";
            $reply .= "👉 Anh/chị có thể:\n";
            $reply .= "🔍 <b>Gõ tên sản phẩm</b> (VD: iPhone 15)\n";
            $reply .= "📂 <b>Hoặc chọn danh mục bên dưới:</b>\n\n";

            foreach ($categories as $c) {
                $reply .= "👉 <button class='chat-category' data-id='{$c->id}'>📂 {$c->categories_text}</button>\n";
            }

            return response()->json(['reply' => nl2br($reply)]);
        }

        if (!$message) {
            return response()->json(['reply' => 'Anh/chị vui lòng nhập nội dung nhé 😊']);
        }

        /* 2️⃣ USER CLICK CATEGORY */
        if (str_starts_with($message, '__category__:')) {

            $categoryId = (int) str_replace('__category__:', '', $message);
            $category = ShopCategory::find($categoryId);

            if (!$category) {
                return response()->json(['reply' => '❌ Danh mục không tồn tại']);
            }

            $products = $category->products()
                ->where('discontinued', false)
                ->limit(5)
                ->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'reply' => "📂 <b>{$category->categories_text}</b> hiện chưa có sản phẩm 😢"
                ]);
            }

            $reply = "📂 <b>{$category->categories_text}</b> – sản phẩm nổi bật:\n\n";

            foreach ($products as $p) {
                $reply .= "📱 <b>{$p->product_name}</b>\n";
                $reply .= "💰 ".number_format($p->list_price,0,',','.')."đ\n";
                $reply .= "👉 <a href='".route('product.show',$p->id)."' target='_blank'>Xem chi tiết</a>\n\n";
            }

            return response()->json(['reply' => nl2br($reply)]);
        }

        /* 3️⃣ TEXT SEARCH (AI PHÂN TÍCH) */
        $text = $this->normalize($message);

        $products = ShopProduct::where('discontinued', false)->get();

        $matched = $products
            ->map(fn($p) => [
                'product' => $p,
                'score'   => $this->matchSmart($text, $p->product_name)
            ])
            ->filter(fn($x) => $x['score'] > 0)
            ->sortByDesc('score')
            ->take(5);

        if ($matched->isNotEmpty()) {

            $reply = "🎯 <b>Sản phẩm phù hợp với anh/chị:</b>\n\n";

            foreach ($matched as $item) {
                $p = $item['product'];
                $reply .= "📱 <b>{$p->product_name}</b>\n";
                $reply .= "💰 ".number_format($p->list_price,0,',','.')."đ\n";
                $reply .= "👉 <a href='".route('product.show',$p->id)."' target='_blank'>Xem chi tiết</a>\n\n";
            }

            return response()->json(['reply' => nl2br($reply)]);
        }

        /* 4️⃣ KHÔNG HIỂU */
        return response()->json([
            'reply' => '🤔 Em chưa hiểu rõ. Anh/chị có thể gõ <b>iPhone</b>, <b>Laptop</b>, <b>MacBook</b> hoặc chọn <b>danh mục</b> để em hỗ trợ tốt hơn ạ.'
        ]);
    }
}