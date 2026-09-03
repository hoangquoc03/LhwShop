<?php

namespace App\Console\Commands;

use App\Models\ShopProduct;
use App\Services\EmbeddingService;
use App\Services\QdrantService;
use Illuminate\Console\Command;

class IndexProductsToQdrant extends Command
{
    protected $signature = 'qdrant:index-products';

    protected $description = 'Embedding products và index vào Qdrant';

    public function __construct(
        protected EmbeddingService $embeddingService,
        protected QdrantService $qdrantService
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $products = ShopProduct::with('category')->get();

        if ($products->isEmpty()) {
            $this->warn('Không có sản phẩm nào trong database.');

            return self::SUCCESS;
        }

        $this->info("Tìm thấy {$products->count()} sản phẩm.");

        $bar = $this->output->createProgressBar($products->count());
        $bar->start();

        foreach ($products as $product) {
            try {
                // Text dùng để embedding.
                $text = implode("\n", array_filter(["Tên sản phẩm: {$product->product_name}", "Mã sản phẩm: {$product->product_code}", "Danh mục: " . optional($product->category)->categories_text, "Mô tả ngắn: {$product->short_description}", "Mô tả chi tiết: {$product->description}",]));

                // Tạo vector 768 chiều.
                $embedding = $this->embeddingService->embed($text);

                // Lưu vector + thông tin sản phẩm vào Qdrant.
                $this->qdrantService->upsert((int) $product->id, $embedding, ['product_id' => (int) $product->id, 'product_code' => $product->product_code, 'name' => $product->product_name, 'category_id' => (int) $product->category_id, 'category' => optional($product->category)->categories_text, 'image' => $product->image, 'short_description' => $product->short_description, 'description' => $product->description, 'price' => (float) $product->list_price, 'stock' => (int) $product->quantity_per_unit, 'is_featured' => (bool) $product->is_featured, 'is_new' => (bool) $product->is_new,]);
            } catch (\Throwable $e) {
                $this->newLine();

                $this->error(
                    "Product #{$product->id}: {$e->getMessage()}"
                );
            }

            $bar->advance();
        }

        $bar->finish();

        $this->newLine(2);
        $this->info('Hoàn thành index products vào Qdrant.');

        return self::SUCCESS;
    }
}
