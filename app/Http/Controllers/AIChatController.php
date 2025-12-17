<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopProduct;
use OpenAI\Laravel\Facades\OpenAI;
class AIChatController extends Controller
{
    private function extractKeywords($text)
    {
        $stopWords = ['tôi', 'muốn', 'mua', 'cần', 'cho', 'xin', 'là', 'có', 'không'];

        $words = explode(' ', strtolower($text));
        return array_values(array_diff($words, $stopWords));
    }

     public function chat(Request $request)
    {
        $question = trim($request->message);

        if (!$question) {
            return response()->json([
                'reply' => 'Bạn vui lòng nhập câu hỏi nhé.'
            ]);
        }

        // 1. Tìm sản phẩm liên quan
        $keywords = $this->extractKeywords($question);

        $products = ShopProduct::where('discontinued', false)
            ->where(function ($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->orWhere('product_name', 'like', "%{$word}%")
                    ->orWhere('short_description', 'like', "%{$word}%")
                    ->orWhere('description', 'like', "%{$word}%");
                }
            })
            ->limit(5)
            ->get();


        // Không có sản phẩm phù hợp
        if ($products->isEmpty()) {
            return response()->json([
                'reply' => 'Hiện tại shop chưa có sản phẩm phù hợp. Bạn có thể cho mình biết rõ hơn nhu cầu không?'
            ]);
        }

        // 2. Chuẩn bị dữ liệu cho AI
        $productText = '';
        foreach ($products as $p) {
            $productText .= "
            - Tên sản phẩm: {$p->product_name}
            - Giá bán: " . number_format($p->standard_cost, 0, ',', '.') . " VND
            - Mô tả ngắn: {$p->short_description}
            - Tình trạng: " . ($p->quantity_per_unit > 0 ? 'Còn hàng' : 'Hết hàng') . "
            - Link sản phẩm: " . route('product.show', ['id' => $p->id]) . "
            ";
        }

        // 3. Prompt cho AI
        $prompt = "
        Bạn là nhân viên tư vấn bán hàng điện tử chuyên nghiệp.

        CHỈ được tư vấn dựa trên danh sách sản phẩm bên dưới.
        KHÔNG được bịa thêm sản phẩm không có.
        Luôn kèm link sản phẩm để khách click xem chi tiết.

        Danh sách sản phẩm:
        $productText

        Câu hỏi khách hàng: {$question}
        ";

        // 4. Gọi AI
        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Bạn là chatbot bán hàng điện tử'],
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        return response()->json([
            'reply' => $response->choices[0]->message->content
        ]);
    }
}