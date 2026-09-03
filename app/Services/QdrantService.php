<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class QdrantService
{
    protected string $url;
    protected string $collection;

    public function __construct()
    {
        $this->url = rtrim(config('services.qdrant.url'), '/');
        $this->collection = config('services.qdrant.collection');
    }

    /**
     * Thêm hoặc cập nhật product vào Qdrant.
     */
    public function upsert(
        int $id,
        array $vector,
        array $payload = []
    ): array {
        $response = Http::timeout(30)
            ->put(
                "{$this->url}/collections/{$this->collection}/points?wait=true",
                [
                    'points' => [
                        [
                            'id' => $id,
                            'vector' => $vector,
                            'payload' => $payload,
                        ],
                    ],
                ]
            );

        if ($response->failed()) {
            throw new \RuntimeException(
                'Qdrant upsert HTTP ' .
                    $response->status() .
                    ': ' .
                    $response->body()
            );
        }

        return $response->json();
    }

    /**
     * Tìm sản phẩm gần nhất theo vector.
     */
    public function search(
        array $vector,
        int $limit = 5,
        ?array $filter = null
    ): array {
        $body = [
            'vector' => $vector,
            'limit' => $limit,
            'with_payload' => true,
        ];

        if ($filter !== null) {
            $body['filter'] = $filter;
        }

        $response = Http::timeout(30)
            ->post(
                "{$this->url}/collections/{$this->collection}/points/search",
                $body
            );

        if ($response->failed()) {
            throw new \RuntimeException(
                'Qdrant search HTTP ' .
                    $response->status() .
                    ': ' .
                    $response->body()
            );
        }

        return $response->json('result', []);
    }

    /**
     * Xóa một product khỏi Qdrant.
     */
    public function delete(int $id): array
    {
        $response = Http::timeout(30)
            ->post(
                "{$this->url}/collections/{$this->collection}/points/delete?wait=true",
                [
                    'points' => [$id],
                ]
            );

        if ($response->failed()) {
            throw new \RuntimeException(
                'Qdrant delete HTTP ' .
                    $response->status() .
                    ': ' .
                    $response->body()
            );
        }

        return $response->json();
    }
    public function searchByIntent(
        array $vector,
        int $limit = 10,
        ?string $gender = null
    ): array {
        $filter = null;

        if ($gender === 'nữ') {
            $filter = [
                'must' => [
                    [
                        'key' => 'category',
                        'match' => [
                            'value' => 'Đồ Nữ',
                        ],
                    ],
                ],
            ];
        }

        if ($gender === 'nam') {
            $filter = [
                'must' => [
                    [
                        'key' => 'category',
                        'match' => [
                            'value' => 'Đồ Nam',
                        ],
                    ],
                ],
            ];
        }

        return $this->search(
            $vector,
            $limit,
            $filter
        );
    }
}
