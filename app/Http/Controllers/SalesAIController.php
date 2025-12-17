<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopProduct;

class SalesAIController extends Controller
{
    /* =====================
        CONFIG
    ======================*/
    private array $stopWords = [
        'tôi','muốn','mua','cần','cho','xin','là','có','không',
        'giá','bao','nhiêu','một','cái','loại'
    ];

    private array $categories = [
        'iphone'  => 'iPhone',
        'laptop'  => 'Laptop',
        'macbook' => 'MacBook'
    ];

    /* =====================
        UTILS
    ======================*/
    private function normalize(string $text): string
    {
        return trim(mb_strtolower($text));
    }

    private function extractKeywords(string $text): array
    {
        $text = $this->normalize($text);
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $text);
        $words = array_filter(explode(' ', $text));

        return array_values(array_diff($words, $this->stopWords));
    }

    /**
     * So khớp từ đầu:
     * iphone 14  -> iphone 14 pro max ✅
     * iphone 14  -> macbook pro 14 ❌
     */
    private function matchFromStart(string $input, string $productName): bool
    {
        $inputWords   = explode(' ', $this->normalize($input));
        $productWords = explode(' ', $this->normalize($productName));

        foreach ($inputWords as $index => $word) {
            if (!isset($productWords[$index]) || $productWords[$index] !== $word) {
                return false;
            }
        }
        return true;
    }

    /* =====================
        MAIN CHAT
    ======================*/
    public function chat(Request $request)
    {
        $message = trim($request->message);

        /* =====================
           1️⃣ MỞ CHAT – CHÀO
        ======================*/
        if ($message === '__start__') {
            return response()->json([
                'reply' => nl2br(
                    "👋 <b>Xin chào! Chào mừng bạn đến với LHWShop</b>\n\n".
                    "Em có thể hỗ trợ anh/chị mua sắm 24/7 😊\n\n".
                    "👉 Anh/chị quan tâm danh mục nào?\n".
                    "🔹 iPhone\n".
                    "🔹 Laptop\n".
                    "🔹 MacBook"
                )
            ]);
        }

        if (!$message) {
            return response()->json(['reply' => 'Anh/chị vui lòng nhập nội dung nhé 😊']);
        }

        $text     = $this->normalize($message);
        $keywords = $this->extractKeywords($text);

        /* =====================
           2️⃣ CLICK CATEGORY
        ======================*/
        if (isset($this->categories[$text])) {
            $products = ShopProduct::where('discontinued', false)
                ->where('product_name', 'like', '%'.$this->categories[$text].'%')
                ->orderByDesc('id')
                ->limit(3)
                ->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'reply' => 'Danh mục này hiện chưa có sản phẩm 😢'
                ]);
            }

            $reply = "🔥 <b>Sản phẩm {$this->categories[$text]} nổi bật:</b>\n\n";

            foreach ($products as $p) {
                $reply .= "📱 <b>{$p->product_name}</b>\n";
                $reply .= "💰 ".number_format($p->list_price,0,',','.')."đ\n";
                $reply .= "👉 <a href='".route('product.show',$p->id)."' target='_blank'>Xem chi tiết</a>\n\n";
            }

            $reply .= "👉 Anh/chị có thể gõ <b>tên sản phẩm</b> để em tư vấn kỹ hơn.";

            return response()->json(['reply' => nl2br($reply)]);
        }

        /* =====================
           3️⃣ MATCH CHÍNH XÁC
        ======================*/
        $allProducts = ShopProduct::where('discontinued', false)->get();

        $matched = $allProducts->filter(function ($p) use ($text) {
            return $this->matchFromStart($text, $p->product_name);
        });

        if ($matched->isNotEmpty()) {
            $reply = "🎯 <b>Em tìm thấy sản phẩm phù hợp:</b>\n\n";

            foreach ($matched as $p) {
                $reply .= "📱 <b>{$p->product_name}</b>\n";
                $reply .= "💰 ".number_format($p->list_price,0,',','.')."đ\n";
                $reply .= "📝 {$p->short_description}\n";
                $reply .= "👉 <a href='".route('product.show',$p->id)."' target='_blank'>Xem chi tiết</a>\n\n";
            }

            $reply .= "🛒 Anh/chị muốn em hỗ trợ đặt hàng hoặc so sánh mẫu khác không ạ?";

            return response()->json(['reply' => nl2br($reply)]);
        }

        /* =====================
           4️⃣ FALLBACK – GỢI Ý CÙNG DÒNG
        ======================*/
        $mainKeyword = $keywords[0] ?? '';

        $products = ShopProduct::where('discontinued', false)
            ->where('product_name', 'like', "%{$mainKeyword}%")
            ->limit(3)
            ->get();

        if ($products->isNotEmpty()) {
            $reply = "⚠️ <b>Mẫu anh/chị tìm hiện không có sẵn</b>\n\n";
            $reply .= "📦 Em gợi ý các mẫu tương đương:\n\n";

            foreach ($products as $p) {
                $reply .= "📱 <b>{$p->product_name}</b>\n";
                $reply .= "💰 ".number_format($p->list_price,0,',','.')."đ\n";
                $reply .= "👉 <a href='".route('product.show',$p->id)."' target='_blank'>Xem chi tiết</a>\n\n";
            }

            return response()->json(['reply' => nl2br($reply)]);
        }

        /* =====================
           5️⃣ KHÔNG HIỂU
        ======================*/
        return response()->json([
            'reply' => '🤔 Em chưa hiểu rõ nhu cầu. Anh/chị có thể gõ <b>iPhone</b>, <b>Laptop</b> hoặc <b>MacBook</b> để em hỗ trợ nhanh hơn ạ.'
        ]);
    }
}