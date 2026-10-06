<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EmbeddingService
{
    public function embed(string $text): array
    {
        $response = Http::timeout(120)
            ->connectTimeout(10)
            ->post(
                rtrim(config('services.ollama.url'), '/') . '/api/embed',
                [
                    'model' => 'nomic-embed-text:latest',
                    'input' => $text,
                    'keep_alive' => '30m',
                ]
            );

        if ($response->failed()) {
            throw new \RuntimeException(
                'Embedding HTTP ' .
                    $response->status() .
                    ': ' .
                    $response->body()
            );
        }

        $embedding = $response->json('embeddings.0');

        if (!is_array($embedding) || count($embedding) !== 768) {
            throw new \RuntimeException(
                'Embedding không hợp lệ. Dimension nhận được: ' .
                    (is_array($embedding) ? count($embedding) : 0)
            );
        }

        return $embedding;
    }
}
