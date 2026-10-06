<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VirtualTryOnService
{
    private string $baseUrl;
    private ?string $token;

    public function __construct()
    {
        $this->baseUrl = 'https://yisol-idm-vton.hf.space';
        $this->token = env('HF_TOKEN');
    }

    /**
     * Tạo ảnh mặc thử
     *
     * @param string $personPath  Đường dẫn file local
     * @param string $garmentUrl  URL ảnh sản phẩm
     *
     * @return string URL ảnh kết quả
     */
    public function generate(
        string $personPath,
        string $garmentUrl
    ): string {
        /*
         * 1. Upload ảnh người lên Hugging Face
         */
        $personUpload = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])
            ->timeout(60)
            ->attach(
                'files',
                fopen($personPath, 'r'),
                basename($personPath)
            )
            ->post($this->baseUrl . '/gradio_api/upload');

        if ($personUpload->failed()) {
            throw new \Exception(
                'Upload ảnh người lên Hugging Face thất bại: ' .
                    $personUpload->body()
            );
        }

        $personFiles = $personUpload->json();

        if (!is_array($personFiles) || empty($personFiles[0])) {
            throw new \Exception(
                'Hugging Face không trả về path ảnh người.'
            );
        }

        $personFilePath = $personFiles[0];

        /*
         * 2. Download ảnh sản phẩm về Laravel
         */
        $garmentResponse = Http::timeout(60)->get($garmentUrl);

        if ($garmentResponse->failed()) {
            throw new \Exception(
                'Không tải được ảnh sản phẩm: HTTP ' .
                    $garmentResponse->status()
            );
        }

        $tempGarmentPath =
            storage_path('app/temp-garment-' . Str::uuid() . '.png');

        file_put_contents(
            $tempGarmentPath,
            $garmentResponse->body()
        );

        /*
         * 3. Upload ảnh sản phẩm lên Hugging Face
         */
        $garmentUpload = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])
            ->timeout(60)
            ->attach(
                'files',
                fopen($tempGarmentPath, 'r'),
                'garment.png'
            )
            ->post($this->baseUrl . '/gradio_api/upload');

        /*
         * Xóa file tạm
         */
        @unlink($tempGarmentPath);

        if ($garmentUpload->failed()) {
            throw new \Exception(
                'Upload ảnh sản phẩm lên Hugging Face thất bại: ' .
                    $garmentUpload->body()
            );
        }

        $garmentFiles = $garmentUpload->json();

        if (!is_array($garmentFiles) || empty($garmentFiles[0])) {
            throw new \Exception(
                'Hugging Face không trả về path ảnh sản phẩm.'
            );
        }

        $garmentFilePath = $garmentFiles[0];

        /*
         * 4. Gửi request tới IDM-VTON
         */
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
        ])
            ->timeout(60)
            ->post(
                $this->baseUrl . '/gradio_api/call/tryon',
                [
                    'data' => [
                        [
                            'background' => [
                                'path' => $personFilePath,
                                'meta' => [
                                    '_type' => 'gradio.FileData',
                                ],
                            ],
                            'layers' => [],
                            'composite' => null,
                        ],

                        [
                            'path' => $garmentFilePath,
                            'meta' => [
                                '_type' => 'gradio.FileData',
                            ],
                        ],

                        'Áo thời trang',

                        true,

                        false,

                        30,

                        rand(1, 999999),
                    ],
                ]
            );

        if ($response->failed()) {
            throw new \Exception(
                'IDM-VTON request thất bại: HTTP ' .
                    $response->status() .
                    ' - ' .
                    $response->body()
            );
        }

        $eventId = $response->json('event_id');

        if (!$eventId) {
            throw new \Exception(
                'Không lấy được event_id từ IDM-VTON: ' .
                    $response->body()
            );
        }

        /*
         * 5. Chờ IDM-VTON xử lý
         */
        $result = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'text/event-stream',
        ])
            ->timeout(300)
            ->get(
                $this->baseUrl .
                    '/gradio_api/call/tryon/' .
                    $eventId
            );

        if ($result->failed()) {
            throw new \Exception(
                'Không lấy được kết quả IDM-VTON: HTTP ' .
                    $result->status() .
                    ' - ' .
                    $result->body()
            );
        }

        $body = $result->body();

        /*
         * 6. Parse SSE
         */
        preg_match_all(
            '/event:\s*complete\s*[\r\n]+data:\s*(.+)/',
            $body,
            $matches
        );

        if (empty($matches[1])) {
            throw new \Exception(
                'IDM-VTON chưa trả về event complete. Response: ' .
                    $body
            );
        }

        $data = json_decode(
            end($matches[1]),
            true
        );

        if (
            !is_array($data) ||
            empty($data[0])
        ) {
            throw new \Exception(
                'IDM-VTON trả về dữ liệu không hợp lệ.'
            );
        }

        $image = $data[0];

        /*
         * 7. Lấy URL ảnh kết quả
         */
        if (is_array($image) && isset($image['url'])) {
            $imageUrl = $image['url'];
        } elseif (is_string($image)) {
            $imageUrl = $image;
        } else {
            throw new \Exception(
                'Không tìm thấy URL ảnh kết quả IDM-VTON.'
            );
        }

        /*
         * 8. Download ảnh kết quả về Laravel
         */
        $imageResponse = Http::timeout(60)->get($imageUrl);

        if ($imageResponse->failed()) {
            throw new \Exception(
                'Không tải được ảnh kết quả IDM-VTON.'
            );
        }

        $filename =
            'tryon/result/' .
            Str::uuid() .
            '.png';

        Storage::disk('public')->put(
            $filename,
            $imageResponse->body()
        );

        return asset('storage/' . $filename);
    }
}
