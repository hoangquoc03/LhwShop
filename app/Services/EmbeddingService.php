<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EmbeddingService
{
    public function embed(string $text): array
    {
        $response = Http::timeout(30)
            ->post(config('services.ollama.url') . '/api/embed', [
                'model' => 'nomic-embed-text',
                'input' => $text,
            ]);

        if ($response->failed()) {
            throw new \RuntimeException(
                'Embedding HTTP ' . $response->status() . ': ' . $response->body()
            );
        }

        return $response->json('embeddings.0');
    }
}
