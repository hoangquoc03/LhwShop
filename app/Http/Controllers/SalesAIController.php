<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopProduct;
use App\Models\ShopCategory;
use App\Models\ShopSupplier;
use Google\Cloud\Dialogflow\V2\SessionsClient;

class SalesAIController extends Controller
{
    private function normalize(string $text): string
    {
        $text = mb_strtolower(trim($text));

        $map = [
            'à' => 'a',
            'á' => 'a',
            'ạ' => 'a',
            'ả' => 'a',
            'ã' => 'a',
            'è' => 'e',
            'é' => 'e',
            'ẹ' => 'e',
            'ẻ' => 'e',
            'ẽ' => 'e',
            'ì' => 'i',
            'í' => 'i',
            'ị' => 'i',
            'ỉ' => 'i',
            'ĩ' => 'i',
            'ò' => 'o',
            'ó' => 'o',
            'ọ' => 'o',
            'ỏ' => 'o',
            'õ' => 'o',
            'ù' => 'u',
            'ú' => 'u',
            'ụ' => 'u',
            'ủ' => 'u',
            'ũ' => 'u',
            'ỳ' => 'y',
            'ý' => 'y',
            'ỵ' => 'y',
            'ỷ' => 'y',
            'ỹ' => 'y',
            'đ' => 'd'
        ];

        return strtr($text, $map);
    }

    private function extractKeywords(string $text): array
    { // ham nay dung de lay tu khoa loai bo stopword
        $stopWords = [
            'toi',
            'muon',
            'mua',
            'can',
            'tim',
            'gia',
            'bao',
            'nhieu',
            'loai',
            'co',
            'khong',
            'duoi',
            'tren',
            'tu',
            'den',
            'va',
            'dang',
            'sale',
            'giam',
            'khuyen',
            'mai',
            'hang',
            'san',
            'pham',
            'xem',
            'cho',
            'tu van',
            'tu van mua hang',
            'dat',
            'hang',
            'shop',
            'cua',
            'toi',
            'em',
            'ban',
            'day',
            'nhe',
            'a',
            'chi',
            'anh',
            'co',
            'khong',
            'nha',
            'nhe',
            'ak',
            'ok',
            'vay',
            'duoc',
            'roi',
            'nhan',
            'hieu',
            'thuong',
        ];

        $text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $text); // loai bo ky tu dac biet
        $words = explode(' ', $this->normalize($text)); // tach van ban thanh mang

        return array_values(array_diff(array_filter($words), $stopWords)); // loai bo stopword va tra ve mang tu khoa
    }

    /* =====================
        MATCH CATEGORY
    ======================*/
    private function matchCategory(array $keywords)
    {
        $categories = ShopCategory::all();

        foreach ($categories as $cat) {
            $name = $this->normalize($cat->categories_text); // normalize de chuan hoa ten danh muc thanh chu thuong khong dau

            foreach ($keywords as $kw) {
                if (str_contains($name, $kw)) { // str_contains de tim kiem tu khoa trong ten danh muc
                    return $cat;
                }
            }
        }

        return null;
    }

    /* =====================
        MATCH SUPPLIER
    ======================*/
    private function matchSupplierFromText($text, $categoryId)
    {
        return ShopProduct::where('category_id', $categoryId) // tim san pham theo danh muc
            ->whereHas('supplier', function ($q) use ($text) { // kiem tra danh muc nho
                $q->where('supplier_text', 'like', "%$text%"); // tim kiem theo ten danh muc
            })
            ->with('supplier') // load quan he danh muc nho
            ->first()?->supplier; // tra ve danh muc nho dau tien tim thay
    }


    /* =====================
        PRICE PARSER
    ======================*/
    private function detectPriceRange(string $text): ?array
    {
        if (preg_match('/dưới\s*(\d+)/u', $text, $m)) {
            return [
                'min' => 0,
                'max' => $m[1] * 1000000
            ];
        }

        if (preg_match('/trên\s*(\d+)/u', $text, $m)) {
            return [
                'min' => $m[1] * 1000000,
                'max' => 999999999
            ];
        }

        if (preg_match('/(\d+)\s*[-–]\s*(\d+)/u', $text, $m)) {
            return [
                'min' => $m[1] * 1000000,
                'max' => $m[2] * 1000000
            ];
        }

        return null;
    }




    private function isBuyIntent(string $text): bool
    {
        $buyWords = [
            'mua',
            'xem',
            'tu van',
            'tim',
            'chon',
            'dat',
            'dat hang',
            'mua hang',
            'can mua',
            'muon mua',
            'mua sam'
        ];

        foreach ($buyWords as $w) {
            if (str_contains($text, $w)) { //str_contains dung de kiem tra tu khoa trong van ban
                return true;
            }
        }

        return false;
    }
    private function replyCategoryList(): string
    {
        $categories = ShopCategory::pluck('categories_text');

        $reply = "👋 <b>Dạ vâng ạ!</b><br><br>";
        $reply .= "Anh/chị đang quan tâm đến <b>danh mục nào</b> ạ?<br><br>";

        foreach ($categories as $cat) {
            $reply .= "• {$cat}<br>";
        }

        $reply .= "<br>👉 Anh/chị chỉ cần <b>gõ tên danh mục</b> nhé!";

        return $reply;
    }
    /* =====================
        CHAT ENTRY
    ======================*/
    public function chat(Request $request)
    {
        $message = trim($request->message ?? ''); // trim dung de loai bo khoang trang thua
        $text = $this->normalize($message); // normalize dung de chuan hoa van ban thanh chu thuong khong dau
        /* RESET */
        if ($message === '__start__') {
            session()->forget('chat_context');

            return response()->json([
                'reply' => "
    👋 <b>Chào mừng anh/chị đến với <span style='color:#1e40af'>LW SHOP</span></b> ✨<br><br>

    Em là <b>trợ lý tư vấn mua sắm cao cấp</b> của LW Shop 👔👟<br>
    Chuyên các dòng <b>thời trang luxury & lifestyle</b> chính hãng.<br><br>

    🔹 <b>Em có thể hỗ trợ anh/chị:</b><br>
    • 👟 Trang phục nam / nữ cao cấp theo nhu cầu & ngân sách<br>
    • 👔 Thời trang luxury – local brand – hàng tuyển chọn<br>
    • 👜 Túi xách, phụ kiện, đồng hồ chính hãng<br>
    • 🎁 Ưu đãi – voucher – sản phẩm đang sale<br><br>

    👉 Anh/chị chỉ cần <b>gõ nhu cầu</b> hoặc <b>tên danh mục</b> để em tư vấn chi tiết ạ 💎
    "
            ]);
        }

        if (!$message) {
            return response()->json(['reply' => '🤖 Anh/chị nhập giúp em nội dung nhé!']);
        }




        // kiem tra nguoi dung da chon kieu gi
        $context = session('chat_context');

        if ($context && $context['category'] && !$context['supplier']) {

            $supplier = $this->matchSupplierFromText($text, $context['category']);

            if ($supplier) {

                // ✅ LƯU ID KIỂU VÀO SESSION
                session()->put('chat_context.supplier', $supplier->id);
                session()->put('chat_context.supplier_text', $supplier->supplier_text);

                return response()->json([
                    'reply' => "👞 <b>Dạ vâng ạ!</b><br>
            Anh/chị đã chọn kiểu <b>{$supplier->supplier_text}</b>.<br><br>
            💰 Anh/chị cho em xin <b>tầm giá</b> mong muốn nhé:<br>
            • Dưới 50 triệu<br>
            • 50 – 80 triệu<br>
            • Trên 80 triệu"
                ]);
            }
        }
        // xu ly chon gia tien
        if (
            $context &&
            $context['category'] &&
            $context['supplier'] &&
            !$context['priceRange']
        ) {

            $range = $this->detectPriceRange($text);

            if ($range) {

                // ✅ LƯU PRICE RANGE
                session()->put('chat_context.priceRange', $range);

                // 👉 QUERY SẢN PHẨM
                $products = ShopProduct::where('category_id', $context['category'])
                    ->where('supplier_id', $context['supplier'])
                    ->whereBetween('list_price', [$range['min'], $range['max']])
                    ->orderBy('list_price')
                    ->limit(5)
                    ->get();

                if ($products->isEmpty()) {
                    return response()->json([
                        'reply' => "😢 <b>Rất tiếc ạ!</b><br>
                Hiện chưa có sản phẩm phù hợp tầm giá này.<br>
                👉 Anh/chị thử <b>tầm giá khác</b> giúp em nhé!"
                    ]);
                }

                // 👉 BUILD REPLY
                $reply = "🎯 <b>Sản phẩm phù hợp cho anh/chị:</b><br><br>";

                foreach ($products as $p) {

                    $reply .= "
    <div style='
        border:1px solid #e5e7eb;
        border-radius:12px;
        padding:10px;
        margin-bottom:12px;
        background:#ffffff;
    '>
        <img src='{$p->image}'
             alt='{$p->product_name}'
             style='
                width:100%;
                max-width:220px;
                border-radius:10px;
                display:block;
                margin-bottom:8px;
             '>

        👟 <b>{$p->product_name}</b><br>
        💰 <b style='color:#1e40af'>" . number_format($p->list_price, 0, ',', '.') . "đ</b><br>

        👉 <a href='" . route('product.show', $p->id) . "' 
              target='_blank'
              style='
                display:inline-block;
                margin-top:6px;
                color:#2563eb;
                font-weight:600;
                text-decoration:none;
              '>
              Xem chi tiết
            </a>
    </div>
    ";
                }


                $reply .= "✨ Anh/chị muốn xem <b>mẫu khác</b> hay <b>đặt mua</b> ngay ạ?";

                return response()->json(['reply' => $reply]);
            }
        }


        if ($this->isBuyIntent($text)) { // tin nhan co y dinh mua hang

            // thử match danh mục luôn
            $keywords = $this->extractKeywords($message); // tu khoa

            $category = $this->matchCategory($keywords); // tim danh muc

            // Nếu user chỉ nói "mua hàng"
            if (!$category) {
                return response()->json([
                    'reply' => $this->replyCategoryList()
                ]);
            }

            // Nếu user nói rõ: mua giày / xem áo
            session()->put('chat_context', [
                'category'   => $category->id,
                'supplier'   => null,
                'priceRange' => null,
                'intent'     => 'buy'
            ]);

            $suppliers = ShopProduct::where('category_id', session('chat_context.category'))
                ->with('supplier')
                ->get()
                ->pluck('supplier.supplier_text')
                ->unique()
                ->filter()
                ->values(); // lay danh sach cac danh muc nho khac nhau

            $reply  = "👟 <b>Dạ vâng ạ!</b><br>";
            $reply .= "Anh/chị đang quan tâm <b>{$category->categories_text}</b>.<br><br>";

            if ($suppliers->isEmpty()) {
                $reply .= "👉 Hiện chưa phân loại kiểu chi tiết.<br>";
                $reply .= "Anh/chị cho em xin <b>tầm giá</b> để em tư vấn nhé!";
            } else {
                $reply .= "Trong đó em có các <b>kiểu</b> sau:<br><br>";
                foreach ($suppliers as $sup) {
                    $reply .= "• {$sup}<br>";
                }
                $reply .= "<br>👉 Anh/chị gõ <b>tên kiểu</b> mình thích nhé!";
            }
            logger(session('chat_context'));
            return response()->json(['reply' => $reply]);
        }


        // /* LOAD CONTEXT */
        // $context = session()->get('chat_context', [
        //     'category'   => null,
        //     'supplier'   => null,
        //     'priceRange' => null,
        //     'intent'     => null,
        // ]);

        // /* ===== ANALYZE ===== */
        // $text     = $this->normalize($message);
        // $keywords = $this->extractKeywords($message);
        // $context['intent'] = $this->detectIntent($text);

        // /* 1️⃣ CATEGORY – BẮT BUỘC & LOCK */
        // if ($category = $this->matchCategory($keywords)) {
        //     if ($context['category'] && $context['category'] !== $category->id) {
        //         $context['supplier'] = null; // đổi loại → reset hãng
        //     }
        //     $context['category'] = $category->id;
        // }

        // if (!$context['category']) {
        //     return response()->json([
        //         'reply' => '👕 Anh/chị muốn mua <b>giày, áo hay quần</b> để em tư vấn chính xác hơn ạ?'
        //     ]);
        // }

        // /* 2️⃣ PRICE */
        // if ($range = $this->detectPriceRange($text)) {
        //     $context['priceRange'] = $range;
        // }

        // if (!$context['priceRange']) {
        //     return response()->json([
        //         'reply' => '💰 Anh/chị cho em biết <b>tầm giá mong muốn</b> để em tư vấn chính xác hơn ạ?'
        //     ]);
        // }

        // /* 3️⃣ SUPPLIER – CHỈ SAU KHI CÓ CATEGORY */
        // $supplier = ShopSupplier::where('category_id', $context['category'])
        //     ->where(function ($q) use ($keywords) {
        //         foreach ($keywords as $kw) {
        //             $q->orWhere('supplier_text', 'like', "%$kw%");
        //         }
        //     })
        //     ->first();

        // if ($supplier) {
        //     $context['supplier'] = $supplier->id;
        // }

        // session()->put('chat_context', $context);

        // /* ===== QUERY PRODUCTS ===== */
        // $query = ShopProduct::with(['category', 'supplier', 'discount', 'vouchers'])
        //     ->where('discontinued', false)
        //     ->where('category_id', $context['category']);

        // if ($context['supplier']) {
        //     $query->where('supplier_id', $context['supplier']);
        // }

        // $query->whereBetween('list_price', [
        //     $context['priceRange']['min'],
        //     $context['priceRange']['max']
        // ]);

        // if ($context['intent'] === 'promotion') {
        //     $query->where(function ($q) {
        //         $q->whereHas('discount')
        //             ->orWhereHas('vouchers');
        //     });
        // }

        // $products = $query->orderBy('list_price')->limit(5)->get();

        // /* FALLBACK – NỚI GIÁ */
        // if ($products->isEmpty()) {
        //     $products = ShopProduct::with(['category', 'supplier', 'discount', 'vouchers'])
        //         ->where('discontinued', false)
        //         ->where('category_id', $context['category'])
        //         ->when(
        //             $context['supplier'],
        //             fn($q) =>
        //             $q->where('supplier_id', $context['supplier'])
        //         )
        //         ->whereBetween('list_price', [
        //             $context['priceRange']['min'],
        //             $context['priceRange']['max'] * 1.2
        //         ])
        //         ->orderBy('list_price')
        //         ->limit(3)
        //         ->get();
        // }

        // /* ===== BUILD RESPONSE ===== */
        // if ($context['intent'] === 'compare' && $products->count() >= 2) {
        //     $p1 = $products[0];
        //     $p2 = $products[1];

        //     return response()->json([
        //         'reply' =>
        //         "📊 <b>So sánh nhanh:</b><br><br>
        //     <b>{$p1->product_name}</b><br>
        //     💰 " . number_format($p1->list_price) . "đ<br>
        //     🏷 {$p1->supplier->supplier_text}<br><br>

        //     <b>{$p2->product_name}</b><br>
        //     💰 " . number_format($p2->list_price) . "đ<br>
        //     🏷 {$p2->supplier->supplier_text}<br><br>

        //     👉 Anh/chị muốn em chốt mẫu nào ạ?"
        //     ]);
        // }

        // $reply = "🎯 <b>Em gợi ý cho anh/chị:</b><br><br>";

        // foreach ($products as $p) {
        //     $price = $p->list_price;

        //     if ($p->discount_percent > 0) {
        //         $price = round($price * (100 - $p->discount_percent) / 100);
        //         $reply .= "🔥 ";
        //     }

        //     $reply .= "<b>{$p->product_name}</b><br>";
        //     $reply .= "💰 " . number_format($price, 0, ',', '.') . "đ<br>";

        //     if ($p->vouchers->count()) {
        //         $reply .= "🎁 Có voucher áp dụng<br>";
        //     }

        //     $reply .= "👉 <a href='" . route('product.show', $p->id) . "' target='_blank'>Xem chi tiết</a><br><br>";
        // }

        // $reply .= "✨ Anh/chị muốn lọc thêm theo <b>thương hiệu</b> hay <b>sale</b> không ạ?";

        // return response()->json(['reply' => $reply]);
    }
}
