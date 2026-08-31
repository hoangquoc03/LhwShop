<?php

namespace App\Services;

use Exception;
use OpenAI;

class OpenAIService
{
    protected $client;
    protected string $model;

    public function __construct()
    {
        $apiKey = config('services.openai.api_key');

        if (empty($apiKey)) {
            throw new Exception('OPENAI_API_KEY chưa được cấu hình.');
        }

        $this->client = OpenAI::client($apiKey);

        $this->model = config(
            'services.openai.model',
            'gpt-5.6-luna'
        );
    }

    /**
     * Phân tích yêu cầu outfit của user.
     */
    public function analyzeOutfitRequest(string $userRequest): array
    {
        $systemPrompt = <<<'PROMPT'
Bạn là AI stylist cho một website bán thời trang.

Nhiệm vụ:
- Phân tích yêu cầu outfit của người dùng.
- Xác định giới tính nếu có.
- Xác định phong cách.
- Xác định dịp sử dụng.
- Xác định thời tiết nếu có.
- Xác định ngân sách nếu có.
- Chia outfit thành các item cần thiết.
- Đưa ra keywords bằng tiếng Việt để backend Laravel tìm sản phẩm trong database.

QUAN TRỌNG:
- Không được tạo product ID.
- Không được tạo tên sản phẩm cụ thể nếu không cần thiết.
- Không được giả định sản phẩm đang tồn tại.
- Chỉ trả về yêu cầu/đặc điểm cần tìm.
- Backend sẽ tự tìm sản phẩm thật trong database.

Các loại item:
top, bottom, dress, shoes, bag, accessory, outerwear.

Ngân sách là tổng ngân sách cho toàn bộ outfit.

Nếu user không nói ngân sách thì budget = 0.

Nếu user không nói màu sắc thì colors có thể là [].

Ưu tiên outfit thực tế, dễ tìm sản phẩm.
PROMPT;

        try {
            $response = $this->client->responses()->create([
                'model' => $this->model,

                'input' => [
                    [
                        'role' => 'system',
                        'content' => $systemPrompt,
                    ],
                    [
                        'role' => 'user',
                        'content' => $userRequest,
                    ],
                ],

                'text' => [
                    'format' => [
                        'type' => 'json_schema',
                        'name' => 'outfit_requirements',
                        'strict' => true,
                        'schema' => [
                            'type' => 'object',
                            'additionalProperties' => false,

                            'properties' => [
                                'gender' => [
                                    'type' => 'string',
                                ],

                                'style' => [
                                    'type' => 'string',
                                ],

                                'occasion' => [
                                    'type' => 'string',
                                ],

                                'weather' => [
                                    'type' => 'string',
                                ],

                                'budget' => [
                                    'type' => 'number',
                                ],

                                'items' => [
                                    'type' => 'array',

                                    'items' => [
                                        'type' => 'object',
                                        'additionalProperties' => false,

                                        'properties' => [
                                            'type' => [
                                                'type' => 'string',
                                                'enum' => [
                                                    'top',
                                                    'bottom',
                                                    'dress',
                                                    'shoes',
                                                    'bag',
                                                    'accessory',
                                                    'outerwear',
                                                ],
                                            ],

                                            'keywords' => [
                                                'type' => 'array',
                                                'items' => [
                                                    'type' => 'string',
                                                ],
                                            ],

                                            'colors' => [
                                                'type' => 'array',
                                                'items' => [
                                                    'type' => 'string',
                                                ],
                                            ],
                                        ],

                                        'required' => [
                                            'type',
                                            'keywords',
                                            'colors',
                                        ],
                                    ],
                                ],
                            ],

                            'required' => [
                                'gender',
                                'style',
                                'occasion',
                                'weather',
                                'budget',
                                'items',
                            ],
                        ],
                    ],
                ],
            ]);

            /*
             * openai-php/client Responses API:
             * $response->outputText
             *
             * KHÔNG dùng:
             * $response->outputChoiceText()
             */
            $text = $response->outputText;

            if (empty($text)) {
                throw new Exception(
                    'OpenAI không trả về nội dung.'
                );
            }

            $result = json_decode(
                $text,
                true
            );

            if (!is_array($result)) {
                throw new Exception(
                    'OpenAI trả về JSON không hợp lệ: ' . $text
                );
            }

            return $result;
        } catch (\Throwable $e) {

            throw new Exception(
                'Không thể phân tích outfit: '
                    . $e->getMessage(),
                0,
                $e
            );
        }
    }
}
