<?php

namespace App\Console\Commands;

use App\Models\ShopProduct;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class ExportProduct3DImages extends Command
{
    protected $signature = 'products:export-3d-images
                            {productId? : ID sản phẩm, bỏ trống để export tất cả}
                            {--force : Tải lại toàn bộ ảnh}';

    protected $description = 'Export ảnh sản phẩm bằng Playwright và chuẩn hóa thành PNG';

    public function handle(): int
    {
        $productId = $this->argument('productId');

        /*
         * Nếu có productId → export 1 sản phẩm.
         * Nếu không có → export tất cả sản phẩm.
         */
        if ($productId !== null) {
            $product = ShopProduct::with('images')->find((int) $productId);

            if (!$product) {
                $this->error("Không tìm thấy sản phẩm ID {$productId}.");

                return self::FAILURE;
            }

            return $this->exportProduct($product);
        }

        /*
         * Export toàn bộ sản phẩm.
         */
        $products = ShopProduct::with('images')
            ->orderBy('id')
            ->get();

        if ($products->isEmpty()) {
            $this->warn('Không có sản phẩm nào.');

            return self::SUCCESS;
        }

        $this->info("Tìm thấy {$products->count()} sản phẩm.");
        $this->newLine();

        $success = 0;
        $failed = 0;
        $skipped = 0;

        foreach ($products as $product) {
            $this->newLine();
            $this->line(str_repeat('=', 60));
            $this->info(
                "Đang xử lý Product #{$product->id}: {$product->product_name}"
            );
            $this->line(str_repeat('=', 60));

            /*
             * Không có ảnh → bỏ qua.
             */
            if ($product->images->isEmpty()) {
                $this->warn(
                    "Bỏ qua Product #{$product->id}: không có ảnh."
                );

                $skipped++;

                continue;
            }

            $result = $this->exportProduct($product);

            if ($result === self::SUCCESS) {
                $success++;
            } else {
                $failed++;
            }
        }

        $this->newLine();
        $this->line(str_repeat('=', 60));
        $this->info('TỔNG KẾT EXPORT');
        $this->line(str_repeat('=', 60));

        $this->info("Thành công : {$success}");
        $this->warn("Thất bại   : {$failed}");
        $this->line("Bỏ qua     : {$skipped}");
        $this->line("Tổng       : {$products->count()}");

        return $failed > 0
            ? self::FAILURE
            : self::SUCCESS;
    }

    /**
     * Export ảnh của một sản phẩm.
     */
    private function exportProduct(ShopProduct $product): int
    {
        $productId = $product->id;
        $images = $product->images;

        if ($images->isEmpty()) {
            $this->warn(
                "Sản phẩm {$productId} không có ảnh trong shop_product_images."
            );

            return self::FAILURE;
        }

        $this->info("Sản phẩm: {$product->product_name}");
        $this->info("Product ID: {$productId}");
        $this->info("Số ảnh: {$images->count()}");
        $this->newLine();

        /*
         * storage/app/3d-source/products/{id}
         */
        $outputDir = storage_path(
            "app/3d-source/products/{$productId}"
        );

        /*
         * --force:
         * xóa source cũ để export lại sạch.
         */
        if ($this->option('force') && File::exists($outputDir)) {
            $this->warn('Đang xóa dữ liệu export cũ...');

            File::deleteDirectory($outputDir);
        }

        File::ensureDirectoryExists($outputDir);

        /*
         * Lấy URL ảnh từ shop_product_images.
         */
        $urls = $images
            ->pluck('image')
            ->filter()
            ->values()
            ->toArray();

        if (empty($urls)) {
            $this->error('Không tìm thấy URL ảnh hợp lệ.');

            return self::FAILURE;
        }

        /*
         * Chuyển URLs sang JSON.
         */
        $urlsJson = json_encode(
            $urls,
            JSON_UNESCAPED_UNICODE |
                JSON_UNESCAPED_SLASHES
        );

        if ($urlsJson === false) {
            $this->error(
                'Không thể encode danh sách URL: ' .
                    json_last_error_msg()
            );

            return self::FAILURE;
        }

        /*
         * Node script.
         */
        $script = base_path(
            'scripts/export-product-3d-images.cjs'
        );

        if (!File::exists($script)) {
            $this->error(
                "Không tìm thấy script:\n{$script}"
            );

            return self::FAILURE;
        }

        /*
         * Kiểm tra Node.
         */
        $nodeCheck = new Process([
            'node',
            '--version',
        ]);

        $nodeCheck->run();

        if (!$nodeCheck->isSuccessful()) {
            $this->error(
                'Không tìm thấy Node.js trong PATH.'
            );

            return self::FAILURE;
        }

        $this->line(
            'Node: ' . trim($nodeCheck->getOutput())
        );

        $this->newLine();

        /*
         * Chạy Playwright.
         */
        $process = new Process([
            'node',
            $script,
            (string) $productId,
            $outputDir,
            $urlsJson,
        ]);

        /*
         * Không giới hạn thời gian.
         */
        $process->setTimeout(null);

        /*
         * Hiển thị output realtime.
         */
        $process->run(function (
            string $type,
            string $buffer
        ) {
            echo $buffer;
        });

        $this->newLine();

        /*
         * Exit code 0:
         * tất cả ảnh thành công.
         */
        if ($process->getExitCode() === 0) {
            $this->info('Export thành công.');

            return self::SUCCESS;
        }

        /*
         * Exit code 2:
         * có ít nhất một ảnh thất bại.
         */
        if ($process->getExitCode() === 2) {
            $this->warn(
                'Export hoàn tất nhưng có ảnh thất bại.'
            );

            return self::FAILURE;
        }

        $this->error(
            'Playwright process thất bại.'
        );

        return self::FAILURE;
    }
}