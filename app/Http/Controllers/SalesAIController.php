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

        // 1️⃣ ƯU TIÊN MATCH CHUỖI ĐẦY ĐỦ
        $fullText = implode(' ', $keywords);

        foreach ($categories as $cat) {
            $name = $this->normalize($cat->categories_text);

            if ($name === $fullText) {
                return $cat;
            }
        }

        // 2️⃣ MATCH TỪ KHÓA QUAN TRỌNG (BỎ TỪ CHUNG)
        $stopWords = ['do', 'ao', 'quan', 'vay'];

        foreach ($categories as $cat) {
            $name = $this->normalize($cat->categories_text);

            foreach ($keywords as $kw) {
                if (in_array($kw, $stopWords)) {
                    continue;
                }

                if (str_contains($name, $kw)) {
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
    private function normalizeText(string $text): string
    {
        $text = mb_strtolower($text, 'UTF-8');

        // chuẩn hoá các cách viết khoảng giá → "-"
        $text = preg_replace(
            '/\b(đến|den|tới|toi|~|–|—|−)\b/u',
            '-',
            $text
        );

        // chuẩn hoá "dưới / trên"
        $text = preg_replace('/\bdưới\b|\bduoi\b/u', 'duoi', $text);
        $text = preg_replace('/\btrên\b|\btren\b/u', 'tren', $text);

        // bỏ chữ đơn vị
        $text = preg_replace('/(triệu|tr|vnd)/u', '', $text);

        // chỉ giữ số + chữ + - + space
        $text = preg_replace('/[^0-9a-z\- ]/u', '', $text);

        // gộp khoảng trắng
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
    }



    /* =====================
        PRICE PARSER
    ======================*/
    private function detectPriceRange(string $text): ?array
    {
        $text = $this->normalizeText($text);

        // 50-80
        if (preg_match('/(\d+)\s*-\s*(\d+)/', $text, $m)) {
            return [
                'min' => (int)$m[1] * 1000000,
                'max' => (int)$m[2] * 1000000,
            ];
        }

        // dưới 50
        if (preg_match('/duoi\s*(\d+)/', $text, $m)) {
            return [
                'min' => 0,
                'max' => (int)$m[1] * 1000000,
            ];
        }

        // trên 80
        if (preg_match('/tren\s*(\d+)/', $text, $m)) {
            return [
                'min' => (int)$m[1] * 1000000,
                'max' => 999000000,
            ];
        }

        // chỉ gõ 1 số: "80"
        if (preg_match('/\b(\d+)\b/', $text, $m)) {
            $price = (int)$m[1] * 1000000;
            return [
                'min' => $price - 10000000,
                'max' => $price + 10000000,
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

    private function isViewOtherIntent($text): bool  // kiem tra y dinh xem mau khac
    {
        return preg_match('/mẫu khác|xem khác|đổi kiểu/i', $text);
    }

    private function isOrderIntent($text): bool // kiem tra y dinh dat hang 
    {
        return preg_match('/đặt mua|mua ngay|chốt đơn|mua luôn/i', $text);
    }

    private function isLoadMoreIntent($text): bool // kiem tra y dinh xem them mau
    {
        return preg_match('/xem thêm|còn nữa|thêm mẫu/i', $text);
    }

    private function detectViewDetailIndex(string $text): ?int
    {
        // xem 2 | xem chi tiết 3 | mẫu 1 | chi tiết mẫu 4 | chỉ gõ số 1
        if (preg_match('/(?:xem|chi tiết|mẫu)?\s*(\d+)/u', $text, $m)) {
            return (int) $m[1];
        }
        return null;
    }




    public function chat(Request $request)
    {
        $message = trim($request->message ?? ''); // trim dung de loai bo khoang trang thua
        $text = $this->normalize($message); // normalize dung de chuan hoa van ban thanh chu thuong khong dau
        /* RESET */
        // thử match danh mục luôn
        $keywords = $this->extractKeywords($message); // tu khoa

        $category = $this->matchCategory($keywords); // tim danh muc
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

        // if ($context && $context['category'] && !$context['supplier']) {
        if (
            isset($context['category']) &&
            empty($context['supplier'])
        ) { // xu ly chon kieu giay voi isset de tranh loi khi chua co category voi isset chi kiem tra ton tai key va empty de kiem tra gia tri null hoac rong
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

                $ids = [];
                $index = 1;
                foreach ($products as $p) {
                    $ids[$index] = $p->id;
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
                    $index++;
                }
                $total = $index - 1; // số mẫu thực tế
                session()->put('chat_context.last_products', $ids); // luu id san pham vua hien thi de dat hang
                $numbersText = implode(', ', range(1, $total));
                $reply .= "
                    ✨ <b>Anh/chị muốn tiếp theo:</b><br>
                    • Gõ <b>số mẫu</b> (<b>{$numbersText}</b>) để <b>xem chi tiết</b><br>
                    • Gõ <b>xem thêm</b> hoặc <b>xem mẫu khác</b> để xem thêm sản phẩm<br>
                    • Gõ <b>đặt mua</b> kèm <b>số mẫu</b> (ví dụ: <b>đặt mua {$numbersText}</b>) để đặt hàng ngay ạ 💎
                    ";

                return response()->json(['reply' => $reply]);
            }
        }
        $index = $this->detectViewDetailIndex($text);

        if ($index) {

            $ids = session('chat_context.last_products', []);

            // ❌ Không có danh sách trước đó
            if (!isset($ids[$index])) {
                return response()->json([
                    'reply' => "⚠️ Em không tìm thấy mẫu <b>{$index}</b> ạ.<br>
            👉 Anh/chị chọn số trong danh sách em vừa gửi nhé!"
                ]);
            }

            $productId = $ids[$index];
            $product = ShopProduct::find($productId);

            if (!$product) {
                return response()->json([
                    'reply' => "❌ Sản phẩm hiện không còn tồn tại ạ."
                ]);
            }

            // 👉 TRẢ VỀ CHI TIẾT SÂU
            $reply = "
🧐 <b>Chi tiết sản phẩm mẫu {$index}:</b><br><br>

<div style='
    border:1px solid #e5e7eb;
    border-radius:12px;
    padding:12px;
    background:#ffffff;
'>
    <img src='{$product->image}'
         alt='{$product->product_name}'
         style='width:100%;max-width:260px;border-radius:10px;margin-bottom:10px;'>

    👟 <b>{$product->product_name}</b><br>
    💰 <b style='color:#1e40af'>" . number_format($product->list_price, 0, ',', '.') . "đ</b><br><br>

    📄 {$product->short_description}<br><br>

    👉 <a href='" . route('product.show', $product->id) . "' target='_blank'
       style='color:#2563eb;font-weight:600;text-decoration:none'>
       Xem trang sản phẩm đầy đủ
    </a><br><br>
    <button class='btn btn-light rounded-circle shadow-sm add-to-cart'
            data-id='{$product->id}'
            title='Thêm vào giỏ hàng'>
        <i class='ti-shopping-cart'></i>
    </button>
    
</div>

<br>🔎 <b>Anh/chị muốn biết thêm về mẫu này không ạ?</b><br>
• Chất liệu / form dáng 👕<br>
• Size & cách chọn size 📏<br>
• Bảo hành / đổi trả 🔁<br>
• Còn màu khác không 🎨<br>
• So sánh với mẫu khác ⚖️<br><br>

👉 Anh/chị chỉ cần gõ ví dụ:
<b>“chất liệu”</b>, <b>“còn màu gì”</b>, <b>“size L bao nhiêu kg”</b> hoặc <b>“đặt mua”</b> ạ 💬

";

            return response()->json(['reply' => $reply]);
        }


        if ($this->isViewOtherIntent($text)) { // kiem tra y dinh xem mau khac

            session()->forget(['chat_context.supplier', 'chat_context.supplier_text', 'chat_context.priceRange', 'chat_context.offset', 'chat_context.last_products']); // offset de lay them san pham va last_products de luu id san pham vua hien thi

            $suppliers = ShopProduct::where('category_id', session('chat_context.category'))
                ->with('supplier')
                ->get()
                ->pluck('supplier.supplier_text')
                ->unique()
                ->filter()
                ->values();

            $reply = "👞 <b>Dạ vâng ạ!</b><br>
            Anh/chị chọn lại <b>kiểu giày</b> nhé:<br><br>";

            foreach ($suppliers as $sup) {
                $reply .= "• {$sup}<br>";
            }

            return response()->json(['reply' => $reply]);
        }
        if ($this->isLoadMoreIntent($text)) { // kiem tra y dinh xem them mau
            $offset = session('chat_context.offset', 0);
            $ctx = session('chat_context');
            $total = ShopProduct::where('category_id', $ctx['category'])
                ->where('supplier_id', $ctx['supplier'])
                ->whereBetween('list_price', [$ctx['priceRange']['min'], $ctx['priceRange']['max']])
                ->count();
            if ($offset + 5 >= $total) {
                return response()->json([
                    'reply' => "📦 <b>Em đã gửi hết các mẫu phù hợp rồi ạ.</b><br>
            👉 Anh/chị muốn <b>xem mẫu khác</b> hay <b>đặt mua</b> ngay ạ?"
                ]);
            }
            $offset += 5;
            session()->put('chat_context.offset', $offset);

            $products = ShopProduct::where('category_id', $ctx['category'])
                ->where('supplier_id', $ctx['supplier'])
                ->whereBetween('list_price', [$ctx['priceRange']['min'], $ctx['priceRange']['max']])
                ->skip($offset)
                ->take(5)
                ->get();

            $reply = "✨ <b>Các mẫu tiếp theo:</b><br><br>";
            $ids = [];
            foreach ($products as $p) {
                $ids[] = $p->id;
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
             style='width:100%;max-width:220px;border-radius:10px;margin-bottom:8px;'>

        👟 <b>{$p->product_name}</b><br>
        💰 <b style='color:#1e40af'>" . number_format($p->list_price, 0, ',', '.') . "đ</b><br>

        <a href='" . route('product.show', $p->id) . "' target='_blank'
           style='color:#2563eb;font-weight:600;text-decoration:none'>
           Xem chi tiết
        </a><br><br>

        <button class='btn btn-light rounded-circle shadow-sm add-to-cart'
            data-id='{$p->id}'
            title='Thêm vào giỏ hàng'>
        <i class='ti-shopping-cart'></i>
    </button>

    </div>
    ";
            }
            session()->put('chat_context.last_products', $ids);
            $reply .= "
                    ✨ Anh/chị muốn:
                    <b>xem thêm</b> • <b>xem mẫu khác</b> • hay <b>đặt mua</b> ngay ạ?
                    ";
            return response()->json(['reply' => $reply]);
        }

        if ($this->isOrderIntent($text)) {

            $productIds = session('chat_context.last_products', []);

            if (empty($productIds)) {
                return response()->json([
                    'reply' => "⚠️ Em chưa thấy sản phẩm nào để đặt mua ạ.<br>
                       Anh/chị thử <b>xem sản phẩm</b> trước nhé!"
                ]);
            }

            $reply = "🛒 <b>Dạ vâng ạ!</b><br>
    Anh/chị vui lòng chọn 1 sản phẩm để xem chi tiết và thêm vào giỏ:<br><br>";

            foreach ($productIds as $id) {
                $reply .= "👉 <a href='" . route('product.show', $id) . "' target='_blank'>
                    Xem sản phẩm #" . $id . "
                   </a><br>";
            }

            return response()->json(['reply' => $reply]);
        }


        if ($this->isBuyIntent($text) || $category) { // tin nhan co y dinh mua hang
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
                'intent'     => 'buy',
                'step'       => 'choose_supplier'
            ]);

            $suppliers = ShopProduct::where('category_id', $category->id)
                ->whereHas('supplier')
                ->with('supplier')
                ->get()
                ->pluck('supplier.supplier_text')
                ->unique()
                ->filter()
                ->values();
            $suppliers = $suppliers->reject(
                fn($s) =>
                $this->normalize($s) === $this->normalize($category->categories_text)
            );

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
    }
}
