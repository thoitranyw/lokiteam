<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ShopRepository;
use App\Models\ProductModel;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function shopUpdate(Request $request)
    {
        $data = $request->all();
        $shopId = $request->input('id', '');
        unset($data['id']);
        $shopRepo = app(ShopRepository::class);
        if($shopRepo->createOrUpdate($shopId, $data))
            return response()->json(['status' => true]);

        return response()->json(['status' => false]);
    }

    public function createdProduct(Request $request)
    {
	    $data = $request->all();
        $product = ProductModel::find($data['id']);
        if(!$product) {
            $product = new ProductModel();
            if($product->save($data)) {
                return response()->json(['status' => true]);
            }
            return response()->json(['status' => false]);
        }
        if($product::update($data))
            return response()->json(['status' => true]);

        return response()->json(['status' => false]);
    }

    public function updatedProduct(Request $request)
    {
        $data = $request->all();
        $product = ProductModel::find($data['id']);
        if(!$product) {
            if(ProductModel::create($data)) {
                return response()->json(['status' => true]);
            }
            return response()->json(['status' => false]);
        }
        if($product->update($data))
            return response()->json(['status' => true]);

        return response()->json(['status' => false]);
    }
}
