<?php

namespace App\Http\Controllers;

use App\Models\ShopProduct as Product;
use App\Models\VirtualTryOn;
use App\Services\VirtualTryOnService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VirtualTryOnController extends Controller
{
    public function generate(Request $request, VirtualTryOnService $service)
    {
        $request->validate([
            'person' => 'required|image|max:5120',
            'product_id' => 'required|exists:shop_products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        $personPath = $request->file('person')
            ->store('tryon/person', 'public');

        $resultImage = $service->generate(
            storage_path('app/public/' . $personPath),
            $product->image
        );

        VirtualTryOn::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'person_image' => $personPath,
            'result_image' => $resultImage
        ]);

        return response()->json([
            'result' => $resultImage
        ]);
    }
}
