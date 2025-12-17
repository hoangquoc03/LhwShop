<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopProduct;

class SalesAIController extends Controller
{
    private array $stopWords = [
        'tôi','muốn','mua','cần','cho','xin','là','có','không',
        'giá','bao','nhiêu','một','cái','loại'
    ];

    private function extractKeywords(string $text): array
    {
        $text = mb_strtolower($text);
        $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $text);
        $words = array_filter(explode(' ', $text));

        return array_values(array_diff($words, $this->stopWords));
    }

    private function detectIntent(string $text): string
    {
        $text = mb_strtolower($text);

        if (str_contains($text, 'so sánh')) return 'compare';
        if (str_contains($text, 'giá')) return 'price';
        if (str_contains($text, 'pin')) return 'battery';
        if (str_contains($text, 'camera')) return 'camera';
        if (str_contains($text, 'mua')) return 'buy';

        return 'list';
    }

    public function chat(Request $request)
    {
        $question = trim($request->message);

        if (!$question) {
            return response()->json(['reply' => 'Anh/chị vui lòng nhập câu hỏi nhé 😊']);
        }

        $keywords = $this->extractKeywords($question);
        $intent   = $this->detectIntent($question);

        /* =====================
           1️⃣ HỎI CHUNG CHUNG
        ======================*/
        if (count($keywords) <= 1) {
            return response()->json([
                'reply' => nl2br(
                    "Shop hiện có nhiều dòng iPhone 📱\n\n".
                    "👉 Anh/chị quan tâm:\n".
                    "1️⃣ iPhone mới nhất\n".
                    "2️⃣ iPhone giá tốt\n".
                    "3️⃣ Pin khỏe – camera đẹp\n\n".
                    "Anh/chị chọn giúp em để em tư vấn đúng hơn ạ."
                )
            ]);
        }

        $mainKeyword = $keywords[0]; // iphone

        /* =====================
           2️⃣ TÌM ĐÚNG MODEL
        ======================*/
        $products = ShopProduct::where('discontinued', false)
            ->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->where('product_name', 'like', "%{$word}%");
                }
            })
            ->limit(5)
            ->get();

        /* =====================
           3️⃣ FALLBACK – KHÔNG CÓ → GỢI Ý ĐỜI MỚI
        ======================*/
        if ($products->isEmpty()) {
            $products = ShopProduct::where('discontinued', false)
                ->where('product_name', 'like', "%{$mainKeyword}%")
                ->orderByDesc('id')
                ->limit(3)
                ->get();

            if ($products->isNotEmpty()) {
                $reply  = "⚠️ <b>Mẫu anh/chị tìm hiện đã hết hàng</b>\n\n";
                $reply .= "📱 Em xin gợi ý các mẫu iPhone mới hơn:\n\n";

                foreach ($products as $p) {
                    $reply .= "📱 <b>{$p->product_name}</b>\n";
                    $reply .= "💰 Giá: " . number_format($p->list_price, 0, ',', '.') . "đ\n";
                    $reply .= "📝 {$p->short_description}\n";
                    $reply .= "👉 <a href='".route('product.show', $p->id)."' target='_blank'>Xem chi tiết</a>\n\n";
                }

                $reply .= "👉 Anh/chị muốn em tư vấn mẫu nào kỹ hơn không ạ?";

                return response()->json(['reply' => nl2br($reply)]);
            }

            return response()->json([
                'reply' => 'Hiện shop chưa có sản phẩm phù hợp 😢'
            ]);
        }

        /* =====================
           4️⃣ CÓ SẢN PHẨM → SALES
        ======================*/
        $reply = "📦 Shop gợi ý cho anh/chị:\n\n";

        foreach ($products as $p) {
            $reply .= "📱 <b>{$p->product_name}</b>\n";
            $reply .= "💰 Giá: " . number_format($p->list_price, 0, ',', '.') . "đ\n";
            $reply .= "📝 {$p->short_description}\n";
            $reply .= "👉 <a href='".route('product.show', $p->id)."' target='_blank'>Xem chi tiết</a>\n\n";
        }

        $reply .= "🛒 Anh/chị muốn em hỗ trợ chọn mẫu phù hợp nhất không ạ?";

        return response()->json(['reply' => nl2br($reply)]);
    }
}