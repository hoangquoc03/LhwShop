<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class QdrantService
{
    protected string $url;
    protected string $collection;

    public function __construct()
    {
        $this->url = rtrim(
            (string) config('services.qdrant.url'),
            '/'
        );

        $this->collection = (string) config(
            'services.qdrant.collection'
        );
    }

    /**
     * Thêm hoặc cập nhật một product vào Qdrant.
     */
    public function upsert(
        int $id,
        array $vector,
        array $payload = []
    ): array {
        if (empty($vector)) {
            throw new \InvalidArgumentException(
                'Qdrant vector không được rỗng.'
            );
        }

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
        if (empty($vector)) {
            throw new \InvalidArgumentException(
                'Qdrant search vector không được rỗng.'
            );
        }

        $limit = max(1, min($limit, 100));

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

    /**
     * Tìm product theo intent.
     *
     * Nam  -> chỉ lấy Đồ Nam
     * Nữ   -> chỉ lấy Đồ Nữ
     * Unisex -> lấy tất cả
     */
    public function searchByIntent(
        array $vector,
        int $limit = 50,
        ?string $gender = null
    ): array {
        $gender = mb_strtolower(
            trim((string) $gender)
        );

        $filter = null;

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

        return $this->search(
            vector: $vector,
            limit: $limit,
            filter: $filter
        );
    }
}
