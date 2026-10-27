@php
    /**
     * LHW 3D Mix Studio catalog
     * - Reads product names/images from App\Models\ShopProduct (not hard-coded `products` table).
     * - Scans public/models for GLB/GLTF files.
     * - Pairs left/right shoe files into one catalog card.
     */
    $lhw3dCatalog = [];
    $lhwModelsRoot = public_path('models');
    $lhwPublicRoot = rtrim(str_replace('\\', '/', public_path()), '/') . '/';
    $lhwImageExtensions = ['webp', 'avif', 'png', 'jpg', 'jpeg'];

    $lhwEncodePath = static function (string $path): string {
        return '/' . implode('/', array_map('rawurlencode', explode('/', ltrim(str_replace('\\', '/', $path), '/'))));
    };

    $lhwNormalizeImagePath = static function ($value) use ($lhwEncodePath) {
        if (!is_string($value)) {
            return null;
        }
        $value = trim(str_replace('\\', '/', $value));
        if ($value === '') {
            return null;
        }
        if (preg_match('#^(https?:)?//#i', $value) || str_starts_with($value, 'data:image/')) {
            return str_starts_with($value, '//') ? request()->getScheme() . ':' . $value : $value;
        }

        $relative = preg_replace('#^\./+#', '', ltrim($value, '/'));
        if (str_starts_with(strtolower($relative), 'public/')) {
            $relative = substr($relative, 7);
        }

        // A DB value may already be a browser URL path.
        if (str_starts_with(strtolower($relative), 'storage/')) {
            $storageRelative = substr($relative, 8);
            if (
                is_file(public_path($relative)) ||
                is_file(storage_path('app/public/' . $storageRelative)) ||
                preg_match('#^storage/(uploads|products|images)/#i', $relative)
            ) {
                return $lhwEncodePath($relative);
            }
        }

        // Resolve paths that are physically under public/.
        if ($relative !== '' && is_file(public_path($relative))) {
            return $lhwEncodePath($relative);
        }

        // Resolve paths stored on Laravel's public disk.
    if ($relative !== '' && is_file(storage_path('app/public/' . $relative))) {
        return $lhwEncodePath('storage/' . $relative);
    }

    // This project stores product photos at storage/uploads/products/{image}.
    if (!str_contains($relative, '/')) {
        foreach (
            [
                'storage/uploads/products/' . $relative,
                'storage/products/' . $relative,
                'storage/images/products/' . $relative,
                'images/products/' . $relative,
                'images/' . $relative,
                'uploads/products/' . $relative,
            ]
            as $candidate
        ) {
            if (is_file(public_path($candidate))) {
                return $lhwEncodePath($candidate);
            }
            if (
                str_starts_with($candidate, 'storage/') &&
                is_file(storage_path('app/public/' . substr($candidate, 8)))
            ) {
                return $lhwEncodePath($candidate);
            }
        }
        // Keep the known project convention as a useful fallback for a symlinked storage disk.
        return $lhwEncodePath('storage/uploads/products/' . $relative);
    }

    if (preg_match('#^(uploads/products|products|product-images)/#i', $relative)) {
        return $lhwEncodePath('storage/' . $relative);
    }
    if (preg_match('#^(images|image|assets)/#i', $relative)) {
        return $lhwEncodePath($relative);
    }

    return null;
};

$lhwResolveImageValue = null;
$lhwResolveImageValue = static function ($value) use (&$lhwResolveImageValue, $lhwNormalizeImagePath) {
    if (is_array($value)) {
        foreach (['url', 'src', 'path', 'image', 'image_url', 'thumbnail', 'thumb', 'original'] as $key) {
            if (array_key_exists($key, $value)) {
                $resolved = $lhwResolveImageValue($value[$key]);
                if ($resolved) {
                    return $resolved;
                }
            }
        }
        foreach ($value as $part) {
            $resolved = $lhwResolveImageValue($part);
            if ($resolved) {
                return $resolved;
            }
        }
        return null;
    }
    if (!is_string($value)) {
        return null;
    }
    $value = trim($value);
    if ($value === '') {
        return null;
    }
    $decoded = json_decode($value, true);
    if (is_array($decoded)) {
        return $lhwResolveImageValue($decoded);
    }
    return $lhwNormalizeImagePath($value);
};

$lhwFindLocalProductImage = static function ($productId, $modelRelativePath) use (
    $lhwImageExtensions,
    $lhwNormalizeImagePath,
) {
    $id = $productId !== null ? (string) $productId : null;
    $modelDirectoryRelative = dirname(str_replace('\\', '/', $modelRelativePath));
    $modelDirectoryAbsolute = public_path($modelDirectoryRelative);
    $modelBasename = pathinfo($modelRelativePath, PATHINFO_FILENAME);
    $candidateRelativePaths = [];

    foreach (
        array_unique([
            $modelBasename,
            'thumbnail',
            'thumb',
            'preview',
            'cover',
            'main',
            'front',
            'image',
            'photo',
            'product',
        ])
        as $name
    ) {
        foreach ($lhwImageExtensions as $extension) {
            $candidateRelativePaths[] = $modelDirectoryRelative . '/' . $name . '.' . $extension;
        }
    }
    if ($id !== null && $id !== '') {
        foreach (
            [
                'images/products',
                'image/products',
                'storage/products',
                'storage/images/products',
                'storage/uploads/products',
                'uploads/products',
                'product-images',
                'images',
            ]
            as $directory
        ) {
            foreach ([$id, 'product-' . $id, 'product_' . $id, 'product' . $id, 'item-' . $id] as $name) {
                foreach ($lhwImageExtensions as $extension) {
                    $candidateRelativePaths[] = $directory . '/' . $name . '.' . $extension;
                }
            }
            foreach (['products/' . $id, 'products/product-' . $id, 'products/product_' . $id] as $nested) {
                foreach (['thumbnail', 'thumb', 'preview', 'cover', 'main', 'front', 'image', 'product'] as $name) {
                    foreach ($lhwImageExtensions as $extension) {
                        $candidateRelativePaths[] = $directory . '/' . $nested . '/' . $name . '.' . $extension;
                    }
                }
            }
        }
    }

    foreach (array_unique($candidateRelativePaths) as $candidate) {
        $resolved = $lhwNormalizeImagePath($candidate);
        if ($resolved && (is_file(public_path(ltrim($resolved, '/'))) || str_contains($resolved, '/storage/'))) {
            return $resolved;
        }
    }

    if (is_dir($modelDirectoryAbsolute)) {
        try {
            $nearby = [];
            foreach (new \FilesystemIterator($modelDirectoryAbsolute, \FilesystemIterator::SKIP_DOTS) as $file) {
                if (!$file->isFile() || !in_array(strtolower($file->getExtension()), $lhwImageExtensions, true)) {
                    continue;
                }
                $base = strtolower(pathinfo($file->getFilename(), PATHINFO_FILENAME));
                $score = 0;
                if (preg_match('/thumbnail|preview|cover|main|front|product|image|photo/', $base)) {
                    $score += 10;
                }
                if ($id && preg_match('/(^|[^0-9])' . preg_quote($id, '/') . '([^0-9]|$)/', $base)) {
                    $score += 4;
                }
                $nearby[] = [
                    'path' => str_replace(
                        '\\',
                        '/',
                        substr(
                            $file->getPathname(),
                            strlen(rtrim(str_replace('\\', '/', public_path()), '/') . '/'),
                        ),
                    ),
                    'score' => $score,
                ];
            }
            usort($nearby, static fn($a, $b) => $b['score'] <=> $a['score']);
            if (!empty($nearby[0]['path'])) {
                return $lhwNormalizeImagePath($nearby[0]['path']);
            }
        } catch (\Throwable $e) {
            // Optional preview images must never stop the catalog from rendering.
        }
    }
    return null;
};

if (is_dir($lhwModelsRoot)) {
    $lhwIterator = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($lhwModelsRoot, \FilesystemIterator::SKIP_DOTS),
    );
    foreach ($lhwIterator as $lhwFile) {
        if (!$lhwFile->isFile()) {
            continue;
        }
        $lhwExtension = strtolower($lhwFile->getExtension());
        if (!in_array($lhwExtension, ['glb', 'gltf'], true)) {
            continue;
        }

        $lhwAbsolutePath = str_replace('\\', '/', $lhwFile->getPathname());
        $lhwRelativePath = ltrim(substr($lhwAbsolutePath, strlen($lhwPublicRoot)), '/');
        $lhwBaseName = basename($lhwRelativePath);
        if (preg_match('#(^|/)models/avatar(s)?/#i', $lhwRelativePath)) {
            continue;
        }
        if (preg_match('/landmarked|backup|\.bak\.|test-export|debug-export/i', $lhwBaseName)) {
            continue;
        }

        $lhwProductId = null;
        if (preg_match('#^models/products/(\d+)/#i', $lhwRelativePath, $lhwMatches)) {
            $lhwProductId = $lhwMatches[1];
        }

        $lhwPathLower = strtolower($lhwRelativePath);
        $lhwCategory = '';
        if ($lhwProductId === '13') {
            $lhwCategory = 'top';
        } elseif ($lhwProductId === '17') {
            $lhwCategory = 'bottom';
        } elseif ($lhwProductId === '22') {
            $lhwCategory = 'shoes';
        } elseif (preg_match('/(glasses|eyeglass|sunglass|spectacle|kinh)/i', $lhwPathLower)) {
            $lhwCategory = 'glasses';
        } elseif (preg_match('/(hat|cap|beanie|helmet|headwear|mu-non)/i', $lhwPathLower)) {
            $lhwCategory = 'hat';
        } elseif (preg_match('/(necklace|pendant|day-chuyen|vong-co)/i', $lhwPathLower)) {
            $lhwCategory = 'necklace';
        } elseif (preg_match('/(scarf|tie|khan|caravat|cravat)/i', $lhwPathLower)) {
            $lhwCategory = 'scarf';
        } elseif (preg_match('/(bag|backpack|handbag|tote|purse|balo|tui)/i', $lhwPathLower)) {
            $lhwCategory = 'bag';
        } elseif (preg_match('/(watch|bracelet|wrist|dong-ho|vong-tay)/i', $lhwPathLower)) {
            $lhwCategory = 'wrist';
        } elseif (
            preg_match('/(left[-_ ]shoe|right[-_ ]shoe|shoe|sneaker|boot|sandal|loafer|giay)/i', $lhwPathLower)
        ) {
            $lhwCategory = 'shoes';
        } elseif (preg_match('/(pant|trouser|jean|shorts|skirt|bottom|quan|vay)/i', $lhwPathLower)) {
            $lhwCategory = 'bottom';
        } elseif (
            preg_match('/(shirt|t-shirt|tee|top|blouse|hoodie|jacket|coat|sweater|polo|ao-)/i', $lhwPathLower)
        ) {
            $lhwCategory = 'top';
        }

        $lhwLabel = pathinfo($lhwBaseName, PATHINFO_FILENAME);
        if (in_array(strtolower($lhwBaseName), ['product.glb', 'product.gltf'], true)) {
            $lhwLabel = $lhwProductId ? 'Sản phẩm #' . $lhwProductId : 'Mô hình 3D · ' . dirname($lhwRelativePath);
        }
        $lhw3dCatalog[] = [
            'id' => $lhwRelativePath,
            'productId' => $lhwProductId,
            'label' => $lhwLabel,
            'path' => $lhwRelativePath,
            'url' => $lhwEncodePath($lhwRelativePath),
            'category' => $lhwCategory,
            'imageUrl' => null,
        ];
    }
}

// Use the actual ShopProduct Eloquent model. This avoids assuming the table is named `products`.
$lhwProductIds = array_values(
    array_unique(array_filter(array_map(static fn($item) => $item['productId'] ?? null, $lhw3dCatalog))),
);
$lhwProductInfo = [];
if ($lhwProductIds) {
    try {
        $lhwShopProducts = \App\Models\ShopProduct::query()->whereIn('id', $lhwProductIds)->get();
        foreach ($lhwShopProducts as $lhwProduct) {
            $lhwId = (string) $lhwProduct->getKey();
            $lhwImageRaw = $lhwProduct->getAttribute('image');
            $lhwInfo = [
                'name' => trim((string) ($lhwProduct->getAttribute('product_name') ?? '')) ?: null,
                'imageUrl' => $lhwResolveImageValue($lhwImageRaw),
                'categoryText' => '',
                'supplierCode' => '',
                'supplierText' => '',
            ];
            try {
                $lhwInfo['categoryText'] = (string) ($lhwProduct->category?->categories_text ?? '');
            } catch (\Throwable $e) {
            }
            try {
                $lhwInfo['supplierCode'] = strtoupper((string) ($lhwProduct->supplier?->supplier_code ?? ''));
                $lhwInfo['supplierText'] = (string) ($lhwProduct->supplier?->supplier_text ?? '');
            } catch (\Throwable $e) {
            }
            $lhwProductInfo[$lhwId] = $lhwInfo;
        }
    } catch (\Throwable $e) {
        // Keep the local filesystem catalog available if the product schema differs.
    }
}

$lhwGuessCategory = static function (string $text, string $supplierCode = ''): string {
    $text = mb_strtolower($text);
    if (preg_match('/(glasses|eyeglass|sunglass|spectacle|kính mắt|kính râm|kinh)/u', $text)) {
        return 'glasses';
    }
    if (preg_match('/(hat|cap|beanie|headwear|mũ|nón|mu-non)/u', $text)) {
        return 'hat';
    }
    if (preg_match('/(necklace|pendant|chain|dây chuyền|vòng cổ|trang sức cổ|day-chuyen|vong-co)/u', $text)) {
        return 'necklace';
    }
    if (preg_match('/(scarf|tie|cravat|khăn|cà vạt|caravat)/u', $text)) {
        return 'scarf';
    }
    if (preg_match('/(bag|backpack|handbag|tote|purse|balo|túi|tui)/u', $text)) {
        return 'bag';
    }
    if (preg_match('/(watch|bracelet|wrist|đồng hồ|vòng tay|dong-ho|vong-tay)/u', $text)) {
        return 'wrist';
    }
    if (
        preg_match('/(left[-_ ]shoe|right[-_ ]shoe|sneaker|shoe|boot|sandal|loafer|giày|giay|cao gót)/u', $text) ||
        $supplierCode === 'NCC4'
    ) {
        return 'shoes';
    }
    if (
        preg_match('/(quần|pants|trousers|jean|denim|shorts|skirt|váy|vay|bottom)/u', $text) ||
        $supplierCode === 'NCC1'
    ) {
        return 'bottom';
    }
    if (
        preg_match('/(áo|shirt|t-shirt|tee|blouse|hoodie|jacket|coat|sweater|polo|sơ mi|somi|ao khoac)/u', $text) ||
        in_array($supplierCode, ['NCC2', 'NCC3', 'NCC6'], true)
    ) {
        return 'top';
    }
    if (preg_match('/(đồng hồ|watch)/u', $text) || $supplierCode === 'DHTM') {
        return 'wrist';
    }
    if (preg_match('/(trang sức|jewelry|jewellery)/u', $text) || $supplierCode === 'DDD') {
        return 'necklace';
    }
    if (preg_match('/(đồ nam|đồ nữ|menswear|womenswear)/u', $text)) {
        return 'generic';
    }
    return 'generic';
};

foreach ($lhw3dCatalog as &$lhwItem) {
    $lhwId = isset($lhwItem['productId']) ? (string) $lhwItem['productId'] : null;
    $lhwRecord = $lhwId !== null ? $lhwProductInfo[$lhwId] ?? null : null;
    if ($lhwRecord) {
        if (!empty($lhwRecord['name']) && preg_match('/^Sản phẩm #\d+$/u', $lhwItem['label'])) {
            $lhwItem['label'] = $lhwRecord['name'];
        }
        if (empty($lhwItem['category'])) {
            $lhwItem['category'] = $lhwGuessCategory(
                ($lhwRecord['name'] ?? '') .
                    ' ' .
                    ($lhwRecord['categoryText'] ?? '') .
                    ' ' .
                    ($lhwRecord['supplierText'] ?? ''),
                $lhwRecord['supplierCode'] ?? '',
            );
        }
    }
    if (empty($lhwItem['category'])) {
        $lhwItem['category'] = 'generic';
    }
    $lhwItem['imageUrl'] = $lhwRecord['imageUrl'] ?? null ?: $lhwFindLocalProductImage($lhwId, $lhwItem['path']);
}
unset($lhwItem);

// Pair left/right shoe GLBs into one choice and do not list them individually.
$lhwShoeParts = [];
foreach ($lhw3dCatalog as $lhwItem) {
    if (
        preg_match(
            '#^models/products/(\d+)/(?:.*/)?(left|right)[-_ ]shoe\.(glb|gltf)$#i',
            $lhwItem['path'],
            $lhwMatch,
        )
    ) {
        $lhwShoeParts[$lhwMatch[1]][strtolower($lhwMatch[2])] = $lhwItem;
    }
}
$lhwCompleteShoePairs = [];
foreach ($lhwShoeParts as $lhwId => $lhwParts) {
    if (!empty($lhwParts['left']) && !empty($lhwParts['right'])) {
        $lhwCompleteShoePairs[$lhwId] = $lhwParts;
    }
}
if ($lhwCompleteShoePairs) {
    $lhw3dCatalog = array_values(
        array_filter($lhw3dCatalog, static function ($lhwItem) use ($lhwCompleteShoePairs) {
            $path = $lhwItem['path'];
            foreach ($lhwCompleteShoePairs as $lhwId => $parts) {
                if ($path === $parts['left']['path'] || $path === $parts['right']['path']) {
                    return false;
                }
                if (
                    ($lhwItem['productId'] ?? null) === (string) $lhwId &&
                    preg_match('#/product\.(glb|gltf)$#i', $path)
                ) {
                    return false;
                }
            }
            return true;
        }),
    );
    foreach ($lhwCompleteShoePairs as $lhwId => $lhwParts) {
        $lhwImage = $lhwProductInfo[(string) $lhwId]['imageUrl'] ?? null;
        if (!$lhwImage) {
            $lhwImage = $lhwFindLocalProductImage((string) $lhwId, $lhwParts['left']['path']);
        }
        $lhw3dCatalog[] = [
            'id' => 'shoe-pair-' . $lhwId,
            'productId' => (string) $lhwId,
            'label' => ($lhwProductInfo[(string) $lhwId]['name'] ?? null ?: 'Giày') . ' · cả đôi',
            'path' => $lhwParts['left']['path'] . ' + ' . $lhwParts['right']['path'],
            'url' => 'pair:shoes:' . $lhwId,
            'category' => 'shoes',
            'imageUrl' => $lhwImage,
            'leftShoeUrl' => $lhwParts['left']['url'],
            'rightShoeUrl' => $lhwParts['right']['url'],
        ];
    }
}

usort($lhw3dCatalog, static fn($a, $b) => strnatcasecmp($a['label'], $b['label']));
@endphp
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#171713" />
    <title>LHW Studio — 3D Mix Studio</title>
    <style>
        :root {
            color-scheme: light;
            --ink: #24251f;
            --muted: #797a70;
            --line: #e7e5dc;
            --paper: #f6f5f0;
            --panel: #fffefa;
            --accent: #c18b58;
            --accent-dark: #8d5b32;
            --olive: #66705a;
            --dark: #171713;
            --radius: 18px;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--paper);
            color: var(--ink);
        }

        button,
        input,
        select {
            font: inherit;
        }

        button,
        select {
            cursor: pointer;
        }

        button:focus-visible,
        input:focus-visible,
        select:focus-visible,
        a:focus-visible {
            outline: 3px solid #c59a70;
            outline-offset: 2px;
        }

        .app-shell {
            max-width: 1780px;
            margin: 0 auto;
            padding: 22px clamp(12px, 2vw, 30px) 32px;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 22px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 13px;
            min-width: 0;
        }

        .brand-mark {
            display: grid;
            place-items: center;
            width: 48px;
            height: 48px;
            flex: 0 0 auto;
            border-radius: 15px;
            background: var(--dark);
            color: #f0d6b8;
            font-family: Georgia, serif;
            font-size: 19px;
            letter-spacing: -.08em;
        }

        .brand-name {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(22px, 3vw, 31px);
            font-weight: 500;
            letter-spacing: -.04em;
        }

        .brand-subtitle {
            margin: 4px 0 0;
            color: var(--muted);
            font-size: 12px;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 12px;
            border: 1px solid #dedbd0;
            border-radius: 999px;
            background: #fffefa;
            color: #515348;
            font-size: 12px;
            white-space: nowrap;
        }

        .status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #758565;
            box-shadow: 0 0 0 3px #e6eadf;
        }

        .hero-strip {
            position: relative;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 20px;
            min-height: 142px;
            overflow: hidden;
            margin-bottom: 18px;
            padding: clamp(20px, 3vw, 34px);
            border-radius: 22px;
            background: radial-gradient(ellipse at 85% 5%, rgba(180, 123, 72, .42), transparent 34%), linear-gradient(115deg, #262720, #171713 72%);
            color: #fffdf7;
        }

        .hero-strip:after {
            content: "LHW";
            position: absolute;
            right: 24px;
            bottom: -38px;
            color: rgba(255, 255, 255, .045);
            font-family: Georgia, serif;
            font-size: clamp(100px, 18vw, 230px);
            line-height: 1;
            letter-spacing: -.09em;
            pointer-events: none;
        }

        .hero-copy {
            position: relative;
            z-index: 1;
            max-width: 680px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #e7c8a8;
            font-size: 10px;
            font-weight: 750;
            letter-spacing: .19em;
            text-transform: uppercase;
        }

        .eyebrow:before {
            content: "";
            display: inline-block;
            width: 24px;
            height: 1px;
            background: #c58d5b;
        }

        .hero-strip h2 {
            margin: 11px 0 7px;
            font-family: Georgia, "Times New Roman", serif;
            font-size: clamp(25px, 3.1vw, 39px);
            font-weight: 500;
            letter-spacing: -.04em;
        }

        .hero-strip p {
            max-width: 580px;
            margin: 0;
            color: #c8c8bd;
            font-size: 13px;
            line-height: 1.65;
        }

        .hero-side {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #e0ded3;
            font-size: 11px;
            letter-spacing: .07em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .hero-side-line {
            width: 38px;
            height: 1px;
            background: #97704b;
        }

        .studio-layout {
            display: grid;
            grid-template-columns: minmax(340px, 430px) minmax(0, 1fr);
            align-items: start;
            gap: 18px;
        }

        .product-catalog {
            min-width: 0;
            padding: 17px;
            border: 1px solid var(--line);
            border-radius: var(--radius);
            background: var(--panel);
            box-shadow: 0 10px 34px rgba(34, 35, 27, .045);
        }

        .catalog-heading {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 16px;
        }

        .catalog-heading h2 {
            margin: 0 0 6px;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 23px;
            font-weight: 500;
            letter-spacing: -.025em;
        }

        .catalog-heading p {
            margin: 0;
            max-width: 320px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.55;
        }

        .catalog-count {
            display: inline-grid;
            place-items: center;
            min-width: 34px;
            height: 34px;
            padding: 0 8px;
            border-radius: 11px;
            background: #eeece2;
            color: #58594f;
            font-size: 12px;
            font-weight: 750;
        }

        .catalog-search-wrap {
            position: relative;
            margin-bottom: 9px;
        }

        .search-glyph {
            position: absolute;
            top: 50%;
            left: 13px;
            transform: translateY(-50%);
            color: #8b8a7f;
            font-size: 17px;
            pointer-events: none;
        }

        .catalog-search,
        .catalog-filter,
        .catalog-item-type {
            width: 100%;
            min-width: 0;
            min-height: 42px;
            padding: 10px 11px;
            border: 1px solid #e1dfd5;
            border-radius: 10px;
            background: #fff;
            color: var(--ink);
            font-size: 13px;
        }

        .catalog-search {
            padding-left: 38px;
        }

        .catalog-search::placeholder {
            color: #9b9a8e;
        }

        .catalog-filter {
            margin-bottom: 13px;
        }

        .catalog-filter:focus,
        .catalog-search:focus,
        .catalog-item-type:focus {
            border-color: #b99470;
        }

        .catalog-section-label {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin: 0 0 9px;
            color: #77786d;
            font-size: 10px;
            font-weight: 750;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        #catalogItems {
            display: grid;
            grid-template-columns: minmax(0, 1fr);
            gap: 10px;
            max-height: 52vh;
            min-height: 160px;
            overflow: auto;
            padding: 1px 4px 3px 1px;
            scrollbar-color: #d4cfc2 transparent;
            scrollbar-width: thin;
        }

        .catalog-item {
            display: grid;
            grid-template-columns: 106px minmax(0, 1fr);
            align-items: stretch;
            gap: 12px;
            min-width: 0;
            padding: 10px;
            border: 1px solid #e9e6dc;
            border-radius: 14px;
            background: #fff;
            transition: border-color .18s ease, transform .18s ease, box-shadow .18s ease;
        }

        .catalog-item:hover {
            transform: translateY(-1px);
            border-color: #c7b69e;
            box-shadow: 0 6px 18px rgba(39, 37, 28, .07);
        }

        .catalog-item-media {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 106px;
            min-height: 120px;
            max-height: 142px;
            overflow: hidden;
            border: 1px solid #eeeae0;
            border-radius: 10px;
            background: radial-gradient(ellipse at 50% 30%, #fff 0, #f2efe7 72%, #e9e5d9 100%);
        }

        .catalog-item-media:after {
            position: absolute;
            right: 8px;
            bottom: 6px;
            content: "3D";
            color: rgba(80, 78, 66, .45);
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .15em;
        }

        .catalog-item-media img {
            display: block;
            width: 100%;
            height: 100%;
            min-height: 120px;
            object-fit: contain;
            padding: 5px;
        }

        .catalog-item-media--empty {
            flex-direction: column;
            gap: 6px;
            color: #79796e;
            text-align: center;
        }

        .catalog-item-media--empty strong {
            color: #b1a58f;
            font-family: Georgia, serif;
            font-size: 28px;
            font-weight: 400;
        }

        .catalog-item-media--empty span {
            max-width: 84px;
            padding: 0 5px;
            font-size: 10px;
            line-height: 1.35;
        }

        .catalog-item-content {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 7px;
            min-width: 0;
        }

        .catalog-item-topline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
        }

        .catalog-item-kicker {
            color: #939184;
            font-size: 9px;
            font-weight: 750;
            letter-spacing: .1em;
            text-transform: uppercase;
        }

        .catalog-item-title {
            display: -webkit-box;
            overflow: hidden;
            overflow-wrap: anywhere;
            color: #292a24;
            font-size: 13px;
            font-weight: 750;
            line-height: 1.4;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .catalog-item-path {
            display: -webkit-box;
            overflow: hidden;
            color: #959387;
            font-size: 10px;
            line-height: 1.4;
            overflow-wrap: anywhere;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .catalog-item-type-label {
            display: grid;
            gap: 4px;
            margin-top: auto;
            color: #77786c;
            font-size: 10px;
        }

        .catalog-item-type {
            min-height: 34px;
            padding: 6px 8px;
            font-size: 11px;
        }

        .catalog-add-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 36px;
            padding: 7px 9px;
            border-color: #282921;
            border-radius: 9px;
            background: #282921;
            color: #fffdf7;
            font-size: 11px;
            font-weight: 700;
        }

        .catalog-add-button:hover:not(:disabled) {
            background: #4b4b3e;
        }

        .catalog-add-button:before {
            content: "+";
            font-size: 17px;
            font-weight: 400;
            line-height: 1;
        }

        button {
            min-height: 38px;
            padding: 9px 12px;
            border: 1px solid #dcd9cf;
            border-radius: 10px;
            background: #fffefa;
            color: var(--ink);
            cursor: pointer;
            font-size: 12px;
            font-weight: 650;
            transition: background .15s ease, border-color .15s ease;
        }

        button:hover:not(:disabled) {
            background: #f2f0e8;
            border-color: #c7c2b4;
        }

        button:disabled {
            cursor: not-allowed;
            opacity: .55;
        }

        .catalog-mix {
            margin-top: 18px;
            padding-top: 16px;
            border-top: 1px solid var(--line);
        }

        .catalog-mix-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .catalog-mix-heading h3 {
            margin: 0;
            font-family: Georgia, serif;
            font-size: 21px;
            font-weight: 500;
        }

        .mix-counter {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 25px;
            height: 25px;
            padding: 0 7px;
            border-radius: 99px;
            background: #e9ecdf;
            color: #58614d;
            font-size: 11px;
            font-weight: 800;
        }

        #catalogSceneItems {
            display: grid;
            gap: 8px;
            margin-top: 11px;
        }

        .scene-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 10px;
            border: 1px solid #ebe8df;
            border-radius: 11px;
            background: #fbfaf5;
        }

        .scene-item-info {
            display: grid;
            gap: 4px;
            min-width: 0;
        }

        .scene-item-title {
            overflow-wrap: anywhere;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.4;
        }

        .scene-item-meta {
            color: #858477;
            font-size: 10px;
        }

        .scene-item-remove {
            flex: 0 0 auto;
            min-height: 31px;
            padding: 5px 9px;
            border-color: #e5d8cf;
            color: #895944;
            font-size: 11px;
        }

        #clearCatalogItems {
            width: 100%;
            margin-top: 10px;
        }

        .catalog-empty {
            margin: 8px 2px;
            color: #858477;
            font-size: 12px;
            line-height: 1.55;
        }

        .catalog-footnote {
            margin: 12px 0 0;
            color: #979589;
            font-size: 10px;
            line-height: 1.5;
        }

        .studio-main {
            min-width: 0;
        }

        .viewer-shell {
            overflow: hidden;
            border: 1px solid #32332d;
            border-radius: 20px;
            background: var(--dark);
            box-shadow: 0 16px 42px rgba(28, 28, 20, .14);
        }

        .viewer-topline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 15px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, .09);
            color: #f7f4eb;
        }

        .viewer-title-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .viewer-symbol {
            display: grid;
            place-items: center;
            width: 31px;
            height: 31px;
            border: 1px solid rgba(225, 193, 155, .38);
            border-radius: 10px;
            color: #d6b38c;
            font-size: 15px;
        }

        .viewer-title {
            margin: 0;
            font-size: 12px;
            font-weight: 750;
            letter-spacing: .11em;
            text-transform: uppercase;
        }

        .viewer-caption {
            margin: 4px 0 0;
            color: #96968b;
            font-size: 10px;
        }

        .viewer-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #cbc7ba;
            font-size: 10px;
            white-space: nowrap;
        }

        .viewer-badge:before {
            content: "";
            width: 6px;
            height: 6px;
            border-radius: 99px;
            background: #a4b58f;
        }

        #fittingViewer {
            position: relative;
            isolation: isolate;
            height: min(78vh, 920px);
            min-height: 520px;
            overflow: hidden;
            background: radial-gradient(ellipse at 50% 28%, #505047 0%, #2b2c25 48%, #171813 100%);
        }

        #fittingViewer:before {
            position: absolute;
            z-index: -1;
            inset: 0;
            content: "";
            pointer-events: none;
            opacity: .18;
            background-image: linear-gradient(rgba(255, 255, 255, .07) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, .07) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: linear-gradient(to bottom, #000, transparent 88%);
        }

        #fittingViewer canvas {
            position: relative;
            z-index: 1;
            display: block;
            width: 100%;
            height: 100%;
        }

        .viewer-bottomline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
            padding: 12px 16px;
            border-top: 1px solid rgba(255, 255, 255, .08);
            background: #1c1d18;
            color: #9d9d90;
            font-size: 10px;
        }

        .viewer-hint {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        .viewer-hint span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .viewer-hint b {
            color: #ded7c7;
            font-weight: 600;
        }

        .toolbar {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 12px 0 14px;
        }

        .toolbar button {
            min-height: 40px;
            padding: 9px 13px;
        }

        .toolbar .toolbar-primary {
            border-color: var(--dark);
            background: var(--dark);
            color: #fffdf7;
        }

        .toolbar .toolbar-primary:hover:not(:disabled) {
            background: #3b3c32;
        }

        .toolbar a {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            min-height: 40px;
            padding: 9px 13px;
            border: 1px solid #dcd9cf;
            border-radius: 10px;
            color: #4b4b42;
            background: #fffefa;
            font-size: 12px;
            font-weight: 650;
            text-decoration: none;
        }

        .toolbar a:hover {
            background: #f2f0e8;
        }

        #fittingStatus {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 0 0 14px;
            padding: 12px 14px;
            border: 1px solid #e5e2d8;
            border-radius: 12px;
            background: #fffefa;
            color: #66675c;
            font-size: 12px;
            line-height: 1.55;
        }

        #fittingStatus:before {
            content: "i";
            display: grid;
            place-items: center;
            width: 19px;
            height: 19px;
            flex: 0 0 auto;
            border-radius: 50%;
            background: #eeece3;
            color: #6a6a5d;
            font-family: Georgia, serif;
            font-size: 12px;
            font-weight: 700;
        }

        .debug-panel {
            display: grid;
            gap: 9px;
            margin: 0;
            padding: 16px;
            border: 1px solid var(--line);
            border-radius: 15px;
            background: var(--panel);
            font-size: 12px;
            box-shadow: 0 6px 22px rgba(34, 35, 27, .035);
        }

        .debug-panel h2 {
            margin: 0;
            font-family: Georgia, serif;
            font-size: 21px;
            font-weight: 500;
        }

        .debug-panel:empty {
            display: none;
        }

        .page-footer {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-top: 20px;
            padding: 13px 2px 0;
            border-top: 1px solid #e5e2d8;
            color: #99978a;
            font-size: 10px;
            letter-spacing: .035em;
        }

        .noscript-note {
            margin: 12px 0;
            padding: 12px;
            border-radius: 10px;
            background: #fff4e8;
            color: #774b2a;
            font-size: 13px;
        }

        @media (max-width: 1100px) {
            .studio-layout {
                grid-template-columns: minmax(300px, 370px) minmax(0, 1fr);
                gap: 12px;
            }

            .product-catalog {
                padding: 13px;
            }

            .catalog-item {
                grid-template-columns: 88px minmax(0, 1fr);
                gap: 9px;
            }

            .catalog-item-media {
                width: 88px;
                min-height: 112px;
            }

            .catalog-item-media img {
                min-height: 112px;
            }

            #fittingViewer {
                min-height: 400px;
            }
        }

        @media (max-width: 850px) {
            .app-shell {
                padding: 14px 12px 24px;
            }

            .topbar {
                align-items: flex-start;
            }

            .hero-side {
                display: none;
            }

            .studio-layout {
                grid-template-columns: minmax(0, 1fr);
            }

            .product-catalog {
                order: 2;
            }

            .studio-main {
                order: 1;
            }

            #fittingViewer {
                height: 68vh;
                min-height: 420px;
            }

            #catalogItems {
                max-height: 440px;
            }
        }

        @media (max-width: 520px) {
            .topbar {
                flex-direction: column;
                gap: 12px;
            }

            .topbar-right {
                justify-content: flex-start;
            }

            .brand-mark {
                width: 42px;
                height: 42px;
            }

            .brand-subtitle {
                font-size: 10px;
            }

            .hero-strip {
                min-height: 150px;
                padding: 20px;
                border-radius: 17px;
            }

            .hero-strip p {
                font-size: 12px;
            }

            #fittingViewer {
                min-height: 360px;
                height: 60vh;
            }

            .viewer-topline {
                padding: 12px;
            }

            .viewer-caption {
                max-width: 200px;
                line-height: 1.4;
            }

            .viewer-badge {
                display: none;
            }

            .catalog-heading h2 {
                font-size: 21px;
            }

            .catalog-item {
                grid-template-columns: 88px minmax(0, 1fr);
            }

            .catalog-item-media {
                width: 88px;
                min-height: 112px;
            }

            .page-footer {
                flex-direction: column;
            }
        }

        .product-catalog,
        .viewer-shell {
            transition: box-shadow .22s ease, transform .22s ease;
        }

        .product-catalog:hover {
            box-shadow: 0 16px 42px rgba(34, 35, 27, .075);
        }

        .toolbar button,
        .toolbar a,
        #clearCatalogItems {
            transition: transform .18s ease, background-color .18s ease, border-color .18s ease;
        }

        .toolbar button:hover,
        .toolbar a:hover,
        #clearCatalogItems:hover {
            transform: translateY(-1px);
        }

        #fittingViewer canvas {
            touch-action: pan-y;
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *:before,
            *:after {
                scroll-behavior: auto !important;
                transition: none !important;
            }
        }

        /* LHW Studio premium refresh: clearer hierarchy, depth and responsive controls. */
        :root {
            --ink: #20211d;
            --muted: #74766d;
            --line: #e6e0d6;
            --paper: #f4f1eb;
            --panel: rgba(255, 254, 250, .94);
            --accent: #c18b58;
            --accent-dark: #875a35;
            --dark: #171713;
            --radius: 20px;
        }
        body {
            background:
                radial-gradient(ellipse at 8% 0%, rgba(193,139,88,.10), transparent 28rem),
                linear-gradient(180deg, #f8f6f1 0%, #efede7 100%);
        }
        .app-shell { max-width: 1900px; padding-top: 26px; }
        .topbar { margin-bottom: 26px; }
        .brand-mark {
            box-shadow: 0 10px 24px rgba(23,23,19,.18);
            border: 1px solid rgba(255,255,255,.12);
        }
        .hero-strip {
            border: 1px solid rgba(255,255,255,.08);
            box-shadow: 0 22px 60px rgba(29,28,22,.16);
            background:
                radial-gradient(ellipse at 82% 12%, rgba(208,158,105,.42), transparent 32%),
                radial-gradient(ellipse at 15% 100%, rgba(111,119,91,.24), transparent 40%),
                linear-gradient(118deg, #292a23, #171813 70%);
        }
        .studio-layout { grid-template-columns: minmax(320px, 410px) minmax(0, 1fr); gap: 22px; }
        .product-catalog, .studio-main, .catalog-scene-panel {
            border-color: rgba(142,126,103,.20);
            box-shadow: 0 16px 44px rgba(48,43,32,.07);
        }
        .product-catalog { padding: 20px; background: rgba(255,254,250,.88); backdrop-filter: blur(16px); }
        .studio-main { overflow: hidden; border-radius: 22px; }
        #fittingViewer {
            height: min(82vh, 1040px);
            min-height: 600px;
            background:
                radial-gradient(ellipse at 50% 22%, rgba(255,255,255,.16), transparent 42%),
                linear-gradient(145deg, #3b3c34 0%, #24251f 58%, #171813 100%);
        }
        #fittingViewer:before {
            opacity: .25;
            background-size: 42px 42px;
        }
        .catalog-item {
            border: 1px solid rgba(125,111,89,.16);
            border-radius: 16px;
            overflow: hidden;
            background: linear-gradient(145deg, #fffefa, #f8f5ef);
            box-shadow: 0 4px 14px rgba(34,35,27,.035);
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }
        .catalog-item:hover {
            transform: translateY(-3px);
            border-color: rgba(193,139,88,.55);
            box-shadow: 0 14px 30px rgba(48,43,32,.10);
        }
        .catalog-item-media { background: linear-gradient(145deg, #f0ede5, #e3dfd4); }
        .catalog-add-button, button {
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
        }
        .catalog-add-button:hover, button:hover:not(:disabled) {
            box-shadow: 0 7px 18px rgba(33,32,26,.10);
        }
        .catalog-add-button:active, button:active:not(:disabled) { transform: translateY(1px); }
        input, select {
            border-color: #ded7ca;
            border-radius: 11px;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #bd8957;
            box-shadow: 0 0 0 3px rgba(193,139,88,.15);
        }
        .status-pill { box-shadow: 0 3px 12px rgba(33,32,26,.04); }
        .page-footer { padding-top: 22px; }
        @media (max-width: 980px) {
            .studio-layout { grid-template-columns: minmax(0, 1fr); }
            .product-catalog { order: 2; }
            .studio-main { order: 1; }
            #fittingViewer { height: min(72vh, 820px); min-height: 480px; }
        }
        @media (max-width: 600px) {
            .app-shell { padding: 14px 12px 22px; }
            .hero-strip { border-radius: 18px; }
            .studio-layout { gap: 14px; }
            .product-catalog { padding: 13px; }
            #fittingViewer { min-height: 420px; height: 62vh; }
        }
    </style>
</head>

<body>
    <div class="app-shell">
        <header class="topbar">
            <div class="brand">
                <div class="brand-mark" aria-hidden="true">LHW</div>
                <div>
                    <h1 class="brand-name">LHW Fashion Studio</h1>
                    <p class="brand-subtitle">Virtual styling · 3D product lab</p>
                </div>
            </div>
            <div class="topbar-right">
                <span class="status-pill"><span class="status-dot"></span> 3D workspace</span>
                <span class="status-pill">{{ count($lhw3dCatalog) }} model 3D</span>
            </div>
        </header>

        <section class="hero-strip" aria-labelledby="heroTitle">
            <div class="hero-copy">
                <span class="eyebrow">Digital wardrobe / 01</span>
                <h2 id="heroTitle">Phối phong cách của riêng bạn.</h2>
                <p>Chọn từng thiết kế từ thư viện, kết hợp quần áo và phụ kiện trong cùng không gian 3D. Ảnh sản phẩm
                    giúp nhận diện nhanh; khung bên phải hiển thị model thực tế.</p>
            </div>
            <div class="hero-side"><span>Curated in 3D</span><span class="hero-side-line"></span><span>Studio
                    edition</span></div>
        </section>

        <div class="studio-layout">
            <aside id="productCatalog" class="product-catalog" aria-label="Kho sản phẩm 3D">
                <div class="catalog-heading">
                    <div>
                        <h2>Thư viện thiết kế</h2>
                        <p>Tên và ảnh lấy từ dữ liệu sản phẩm khi có. Model GLB/GLTF được ghép theo từng lựa chọn; giày
                            trái/phải thành một đôi nếu có đủ hai file.</p>
                    </div>
                    <span class="catalog-count" aria-label="Số model 3D">{{ count($lhw3dCatalog) }}</span>
                </div>

                <div class="catalog-search-wrap">
                    <span class="search-glyph" aria-hidden="true">⌕</span>
                    <input id="catalogSearch" class="catalog-search" type="search"
                        placeholder="Tìm tên sản phẩm, mã hoặc model…" aria-label="Tìm model 3D" />
                </div>
                <select id="catalogCategoryFilter" class="catalog-filter" aria-label="Lọc model theo loại">
                    <option value="all">Tất cả danh mục</option>
                    <option value="top">Áo / áo khoác</option>
                    <option value="bottom">Quần / váy</option>
                    <option value="shoes">Giày</option>
                    <option value="hat">Mũ / nón</option>
                    <option value="glasses">Kính</option>
                    <option value="necklace">Vòng cổ / dây chuyền</option>
                    <option value="scarf">Khăn / phụ kiện cổ</option>
                    <option value="bag">Túi / balo</option>
                    <option value="wrist">Đồng hồ / vòng tay</option>
                    <option value="accessory">Phụ kiện khác</option>
                    <option value="generic">Mô hình rời / chưa phân loại</option>
                </select>

                <div class="catalog-section-label"><span>Sản phẩm 3D</span><span>Chọn để thêm vào phối đồ</span></div>
                <div id="catalogItems" aria-live="polite">
                    @if (empty($lhw3dCatalog))
                        <p class="catalog-empty">Chưa tìm thấy model GLB/GLTF trong <code>public/models</code>. Hãy kiểm
                            tra thư mục model và quyền đọc file.</p>
                    @endif
                </div>
                <p class="catalog-footnote">Ảnh không có sẵn sẽ dùng ô giữ chỗ trung tính. Túi và mô hình chưa phân loại
                    được đặt cạnh bộ đồ để không che áo/quần; mũ, kính và phụ kiện cổ vẫn căn theo vùng đeo tương ứng.
                    Có thể gỡ từng món hoặc xóa toàn bộ phối đồ.</p>

                <section class="catalog-mix">
                    <div class="catalog-mix-heading">
                        <h3>Đang phối</h3>
                        <span class="mix-counter" id="mixCount">0</span>
                    </div>
                    <div id="catalogSceneItems" aria-live="polite">
                        <p class="catalog-empty">Chưa có sản phẩm nào. Chọn một món từ thư viện để bắt đầu.</p>
                    </div>
                    <button id="clearCatalogItems" type="button">Xóa toàn bộ phối đồ</button>
                </section>
            </aside>

            <main class="studio-main">
                <section class="viewer-shell" aria-label="Studio xem sản phẩm 3D">
                    <div class="viewer-topline">
                        <div class="viewer-title-wrap">
                            <span class="viewer-symbol" aria-hidden="true">◈</span>
                            <div>
                                <h2 class="viewer-title">3D Look Builder</h2>
                                <p class="viewer-caption">Không gian phối đồ · kéo để xoay · cuộn để zoom · phụ kiện
                                    được bố trí riêng khi cần</p>
                            </div>
                        </div>
                        <span class="viewer-badge">Interactive viewport</span>
                    </div>
                    <div id="fittingViewer" aria-label="Khung xem phối đồ 3D"></div>
                    <div class="viewer-bottomline">
                        <div class="viewer-hint"><span><b>Drag</b> xoay</span><span><b>Scroll</b> phóng
                                to</span><span><b>Right drag</b> di chuyển</span></div>
                        <span>Preview quality depends on each 3D asset</span>
                    </div>
                </section>

                <div class="toolbar">
                    <button id="rotateAvatar" class="toolbar-primary" type="button">◌ &nbsp;Bật / tắt xoay</button>
                    <button id="reloadOutfit" type="button">Làm mới phối đồ</button>
                    <button id="resetCamera" type="button">Đặt lại góc nhìn</button>
                    <a href="{{ route('glb-inspector') }}">↗ &nbsp;GLB Landmark Inspector</a>
                </div>
                <div id="fittingStatus" aria-live="polite">Đang khởi tạo studio 3D…</div>
                <section id="fittingDebug" class="debug-panel" aria-live="polite"
                    aria-label="Thông tin debug căn chỉnh"></section>
            </main>
        </div>
        <footer class="page-footer"><span>LHW FASHION STUDIO · 3D PRODUCT WORKSPACE</span><span>Product metadata from
                Laravel · 3D assets from public/models</span></footer>
    </div>

    <script>
        window.LHW_FITTING_CONFIG = {
            viewer: {
                catalogMode: true,
                showAvatar: false
            },
            productCatalog: @json($lhw3dCatalog),
            avatarUrl: '/models/avatar/avatar.glb',
            features: {
                renderShoes3D: true
            },
            autoFit: {
                enabled: true,
                strategy: 'landmarks-first',
                fallback: 'legacy',
                verifiedProductIds: [],
                categories: {
                    top: {
                        requiredLandmarks: @json(config('lhw_fitting.landmarks.top'))
                    },
                    bottom: {
                        requiredLandmarks: @json(config('lhw_fitting.landmarks.bottom'))
                    },
                },
                validation: {
                    minimumScale: 0.02,
                    maximumScale: 50,
                    maximumRmsRelativeToAvatarHeight: 0.08,
                },
            },
            outfit: {
                top: 13,
                bottom: 17,
                shoes: 22
            },
            productAssets: {
                13: {
                    modelUrl: '/models/products/13/product.glb',
                    landmarkedModelUrl: '/models/products/13/product.landmarked-v2.glb',
                    render3D: true,
                    qualityStatus: 'known-incomplete-geometry',
                    warnings: ['Sản phẩm cần được kiểm tra hình học và cách hiển thị trên web.'],
                },
                17: {
                    modelUrl: '/models/products/17/product.glb',
                    render3D: true,
                    qualityStatus: 'known-incomplete-geometry',
                    warnings: ['Sản phẩm cần được kiểm tra hình học và cách hiển thị trên web.'],
                },
                22: {
                    modelUrl: '/models/products/22/product.glb',
                    render3D: false,
                    qualityStatus: 'pending-review',
                    leftShoeUrl: null,
                    rightShoeUrl: null,
                },
            },
            productFit: {
                // Cấu hình mặc định dùng cho MỌI sản phẩm theo loại, không phụ thuộc ID.
                defaults: {
                    top: {
                        positionOffset: [0, 0, 0],
                        rotationOffset: [0, 0, 0],
                        scaleMultiplier: [1, 1, 1],
                        normalization: { pivot: 'bounds-center', scale: 'axis' },
                    },
                    bottom: {
                        positionOffset: [0, 0, 0],
                        rotationOffset: [0, 0, 0],
                        scaleMultiplier: [1, 1, 1],
                        normalization: { pivot: 'bounds-center', scale: 'axis' },
                    },
                    shoes: {
                        positionOffset: [0, 0, 0],
                        rotationOffset: [0, 0, 0],
                        scaleMultiplier: [1, 1, 1],
                        normalization: { pivot: 'bounds-center', scale: 'uniform-contain' },
                        parts: {
                            left: { positionOffset: [0, 0, 0], rotationOffset: [0, 0, 0], scaleMultiplier: [1, 1, 1] },
                            right: { positionOffset: [0, 0, 0], rotationOffset: [0, 0, 0], scaleMultiplier: [1, 1, 1] },
                        },
                    },
                    bag: {
                        positionOffset: [0, 0, 0], rotationOffset: [0, 0, 0],
                        scaleMultiplier: [1, 1, 1],
                        normalization: { pivot: 'bounds-center', scale: 'uniform-contain' },
                    },
                    hat: {
                        positionOffset: [0, 0, 0], rotationOffset: [0, 0, 0],
                        scaleMultiplier: [1, 1, 1],
                        normalization: { pivot: 'bounds-center', scale: 'uniform-contain' },
                    },
                    glasses: {
                        positionOffset: [0, 0, 0], rotationOffset: [0, 0, 0],
                        scaleMultiplier: [1, 1, 1],
                        normalization: { pivot: 'bounds-center', scale: 'uniform-contain' },
                    },
                    necklace: {
                        positionOffset: [0, 0, 0], rotationOffset: [0, 0, 0],
                        scaleMultiplier: [1, 1, 1],
                        normalization: { pivot: 'bounds-center', scale: 'uniform-contain' },
                    },
                    scarf: {
                        positionOffset: [0, 0, 0], rotationOffset: [0, 0, 0],
                        scaleMultiplier: [1, 1, 1],
                        normalization: { pivot: 'bounds-center', scale: 'uniform-contain' },
                    },
                    wrist: {
                        positionOffset: [0, 0, 0], rotationOffset: [0, 0, 0],
                        scaleMultiplier: [1, 1, 1],
                        normalization: { pivot: 'bounds-center', scale: 'uniform-contain' },
                    },
                    accessory: {
                        positionOffset: [0, 0, 0], rotationOffset: [0, 0, 0],
                        scaleMultiplier: [1, 1, 1],
                        normalization: { pivot: 'bounds-center', scale: 'uniform-contain' },
                    },
                    generic: {
                        positionOffset: [0, 0, 0], rotationOffset: [0, 0, 0],
                        scaleMultiplier: [1, 1, 1],
                        normalization: { pivot: 'bounds-center', scale: 'uniform-contain' },
                    },
                },
                // Chỉ thêm ID tại đây nếu muốn hiệu chỉnh riêng một sản phẩm cụ thể.
                overrides: {
                    // '45': { scaleMultiplier: [1.05, 1, 1.05], positionOffset: [0, 0.01, 0] },
                },
            },
        };
    </script>
    <script type="importmap">
        {"imports":{"three":"https://cdn.jsdelivr.net/npm/three@0.180.0/build/three.module.js","three/addons/":"https://cdn.jsdelivr.net/npm/three@0.180.0/examples/jsm/"}}
    </script>
    <script type="module" src="/js/lhw-fitting-room.js"></script>
    <script>
        // Small, optional enhancement that does not replace the fitting engine's own behavior.
        document.addEventListener('DOMContentLoaded', () => {
            const catalog = document.getElementById('catalogItems');
            const sceneItems = document.getElementById('catalogSceneItems');
            const count = document.getElementById('mixCount');
            const syncCount = () => {
                if (!count || !sceneItems) return;
                const items = sceneItems.querySelectorAll('.scene-item');
                count.textContent = String(items.length);
            };
            if (catalog && window.MutationObserver) {
                new MutationObserver(syncCount).observe(catalog, {
                    childList: true,
                    subtree: true
                });
            }
            if (sceneItems && window.MutationObserver) {
                new MutationObserver(syncCount).observe(sceneItems, {
                    childList: true,
                    subtree: true
                });
            }
            syncCount();
        });
    </script>
</body>

</html>
