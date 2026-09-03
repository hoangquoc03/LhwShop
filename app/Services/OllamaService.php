<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OllamaService
{
    /**
     * Phân tích yêu cầu người dùng.
     */
    public function analyzeOutfit(string $prompt): array
    {
        $response = Http::timeout(300)
            ->post(config('services.ollama.url') . '/api/chat', [
                'model' => config('services.ollama.model'),
                'stream' => false,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Bạn là stylist thời trang chuyên nghiệp.
Luôn trả lời bằng tiếng Việt.
Không sử dụng tiếng Trung, tiếng Anh hoặc ngôn ngữ khác.
Phân tích rõ nhu cầu về giới tính, hoàn cảnh, phong cách, màu sắc và loại trang phục nếu có.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
            ]);

        if ($response->failed()) {
            throw new \RuntimeException(
                'Ollama HTTP ' .
                    $response->status() .
                    ': ' .
                    $response->body()
            );
        }

        return $response->json();
    }

    /**
     * Qwen chọn và phối outfit từ danh sách sản phẩm thật.
     */
    public function composeOutfit(
        string $userPrompt,
        array $products
    ): array {
        $compactProducts = collect($products)
            ->map(fn($product) => [
                'product_id' => $product['product_id'] ?? null,
                'name' => $product['name'] ?? null,
                'category' => $product['category'] ?? null,
                'price' => $product['price'] ?? null,
            ])
            ->values()
            ->all();
        $productJson = json_encode(
            $compactProducts,
            JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );

        $systemPrompt = <<<'PROMPT'
Bạn là stylist thời trang chuyên nghiệp.

Nhiệm vụ:
- Hiểu yêu cầu của khách hàng.
- Chọn sản phẩm phù hợp từ DANH SÁCH SẢN PHẨM được cung cấp.
- Phối chúng thành một outfit hợp lý.
- TUYỆT ĐỐI không được tự tạo sản phẩm không có trong danh sách.
- Chỉ sử dụng product_id tồn tại trong danh sách.
- Nếu không đủ sản phẩm phù hợp, hãy trả về những sản phẩm phù hợp nhất.

Luôn trả về JSON hợp lệ.
Không thêm markdown.
Không thêm ```json.
Không giải thích bên ngoài JSON.

Format bắt buộc:

{
  "outfit_name": "Tên outfit",
  "style": "Phong cách",
  "occasion": "Hoàn cảnh",
  "explanation": "Giải thích ngắn gọn",
  "products": [
    {
      "product_id": 123,
      "role": "Áo",
      "reason": "Lý do chọn sản phẩm"
    }
  ]
}
PROMPT;

        $userMessage = <<<PROMPT
Yêu cầu của khách hàng:

{$userPrompt}

DANH SÁCH SẢN PHẨM CÓ THỂ SỬ DỤNG:

{$productJson}

Hãy chọn và phối outfit từ danh sách trên.
PROMPT;

        $response = Http::timeout(300)
            ->post(config('services.ollama.url') . '/api/chat', [
                'model' => config('services.ollama.model'),
                'stream' => false,
                'format' => 'json',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt,
                    ],
                    [
                        'role' => 'user',
                        'content' => $userMessage,
                    ],
                ],
            ]);

        if ($response->failed()) {
            throw new \RuntimeException(
                'Ollama compose HTTP ' .
                    $response->status() .
                    ': ' .
                    $response->body()
            );
        }

        $content = $response->json('message.content');

        if (!$content) {
            throw new \RuntimeException(
                'Ollama không trả về nội dung.'
            );
        }

        $result = json_decode($content, true);

        if (!is_array($result)) {
            throw new \RuntimeException(
                'Ollama trả về JSON không hợp lệ: ' . $content
            );
        }

        return $result;
    }
    public function analyzeIntent(string $userPrompt): array
    {
        $prompt = <<<PROMPT
Phân tích yêu cầu thời trang của khách hàng dưới đây.

Yêu cầu:
{$userPrompt}

Hãy trả về JSON theo đúng cấu trúc:

{
    "gender": "nữ",
    "style": "sang trọng",
    "occasion": "đi cafe",
    "items": ["áo", "váy", "giày", "túi"],
    "colors": []
}

Quy tắc:

- gender chỉ được là: "nam", "nữ", hoặc "unisex".
- style là phong cách khách hàng mong muốn.
- occasion là hoàn cảnh sử dụng.
- items là danh sách loại sản phẩm cần thiết.
- colors là danh sách màu khách hàng yêu cầu.
- Nếu khách hàng không nói màu thì để [].
- Không tự thêm yêu cầu không có trong câu hỏi.
- Luôn trả về JSON hợp lệ.
- Không giải thích bên ngoài JSON.
PROMPT;

        $response = Http::timeout(300)
            ->post(config('services.ollama.url') . '/api/chat', [
                'model' => config('services.ollama.model'),
                'stream' => false,
                'format' => 'json',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Bạn là AI chuyên phân tích nhu cầu thời trang. Luôn trả về JSON hợp lệ bằng tiếng Việt.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ]
            ]);

        if ($response->failed()) {
            throw new \RuntimeException(
                'Ollama Intent HTTP ' .
                    $response->status() .
                    ': ' .
                    $response->body()
            );
        }

        $content = $response->json('message.content');

        $intent = json_decode($content, true);

        if (!is_array($intent)) {
            throw new \RuntimeException(
                'Ollama trả về Intent JSON không hợp lệ.'
            );
        }

        return $intent;
    }
}
