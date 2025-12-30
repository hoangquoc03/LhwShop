<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\ShopProduct;
use App\Models\ShopCategory;
use App\Models\ShopSupplier;
use Google\Cloud\Dialogflow\V2\SessionsClient;
use App\Http\Controllers\Controller;

class ChatBotController extends Controller
{
    private function handleIdle($text)
    {
        if ($this->isBuyIntent($text)) {
            session()->put('chat_context.state', 'choose_category');

            return response()->json([
                'reply' => $this->replyCategoryList()
            ]);
        }

        return response()->json([
            'reply' => "👋 Em có thể giúp anh/chị tìm sản phẩm phù hợp ạ!"
        ]);
    }
    private function handleChooseCategory($text)
    {
        $category = $this->matchCategory($this->extractKeywords($text));

        if (!$category) {
            return response()->json([
                'reply' => "👉 Anh/chị cho em biết <b>loại sản phẩm</b> muốn mua nhé!"
            ]);
        }

        session()->put('chat_context', [
            'state'    => 'choose_supplier',
            'category' => $category->id,
            'supplier' => null,
            'priceRange' => null,
        ]);

        return $this->replySupplierList($category);
    }
    private function handleChooseSupplier($text)
    {
        if ($this->isChangeSupplierIntent($text)) {
            return $this->replySupplierList(
                ShopCategory::find(session('chat_context.category'))
            );
        }

        $supplier = $this->matchSupplier($text);

        if (!$supplier) {
            return response()->json([
                'reply' => "👉 Anh/chị gõ <b>tên dòng</b> muốn xem nhé!"
            ]);
        }

        session()->put('chat_context.state', 'choose_price');
        session()->put('chat_context.supplier', $supplier);

        return response()->json([
            'reply' => "💰 Anh/chị cho em xin <b>tầm giá</b> mong muốn nhé!"
        ]);
    }
    private function handleChoosePrice($text)
    {
        if ($this->isChangeSupplierIntent($text)) {
            session()->put('chat_context.state', 'choose_supplier');
            session()->put('chat_context.supplier', null);

            return $this->replySupplierList(
                ShopCategory::find(session('chat_context.category'))
            );
        }

        $price = $this->detectPriceRange($text);

        if (!$price) {
            return response()->json([
                'reply' => "👉 Anh/chị chọn giúp em <b>tầm giá</b> nhé!"
            ]);
        }

        session()->put('chat_context.state', 'show_products');
        session()->put('chat_context.priceRange', $price);

        return $this->replyProductList();
    }
    private function handleShowProducts($text)
    {
        if ($this->isOrderIntent($text)) {
            session()->put('chat_context.state', 'ready_to_order');
            return $this->replyOrderLinks();
        }

        if ($this->isChangeSupplierIntent($text)) {
            session()->put('chat_context.state', 'choose_supplier');
            session()->put('chat_context.supplier', null);

            return $this->replySupplierList(
                ShopCategory::find(session('chat_context.category'))
            );
        }

        return response()->json([
            'reply' => "👉 Anh/chị có thể <b>xem sản phẩm</b> hoặc <b>đặt mua</b> nhé!"
        ]);
    }




    public function chat(Request $request)
    {
        $text = trim($request->input('message'));
        if (!session()->has('chat_context')) {
            session()->put('chat_context', [
                'state'      => 'idle',
                'category'   => null,
                'supplier'   => null,
                'priceRange' => null,
            ]);
        }

        $state = session('chat_context.state');
        switch ($state) {

            case 'idle':
                return $this->handleIdle($text);

            case 'choose_category':
                return $this->handleChooseCategory($text);

            case 'choose_supplier':
                return $this->handleChooseSupplier($text);

            case 'choose_price':
                return $this->handleChoosePrice($text);

            case 'show_products':
                return $this->handleShowProducts($text);

            default:
                session()->forget('chat_context');
                return response()->json([
                    'reply' => "🔄 Em đã làm mới phiên tư vấn, mình bắt đầu lại nhé ạ 😊"
                ]);
        }
    }
}
