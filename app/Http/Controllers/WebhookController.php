<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ShopRepository;
use App\Models\ProductModel;
use App\Models\ShopModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

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
        $shop_name = $request->server('HTTP_X_SHOPIFY_SHOP_DOMAIN');
        $objectShop = ShopModel::where('myshopify_domain', $shop_name)->first();
        $productModel = new ProductModel();
        $filterData = Arr::only($data, $productModel->getFillable());
        $filterData['shop_id'] = $objectShop->id;
        if($product = $productModel->find($data['id'])) {
            if($product->update($filterData)) {
                return response()->json(['status' => true]);
            }
            return response()->json(['status' => false]);
        }

        if($productModel->firstOrCreate($filterData)) {
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    public function updatedProduct(Request $request)
    {
        $data = $request->all();
        $product = ProductModel::find($data['id']);
        $shop_name = $request->server('HTTP_X_SHOPIFY_SHOP_DOMAIN');
        $objectShop = ShopModel::where('myshopify_domain', $shop_name)->first();
        $productModel = new ProductModel();
        $filterData = Arr::only($data, $productModel->getFillable());
        $filterData['shop_id'] = $objectShop->id;
        if($product = $productModel->find($data['id'])) {
            if($product->update($filterData)) {
                return response()->json(['status' => true]);
            }
            return response()->json(['status' => false]);
        }

        if($productModel->firstOrCreate($filterData)) {
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    public function ordersUpdated(Request $request)
    {
        $data = $request->all();
        $lineItems = $data['line_items'];
        foreach($lineItems as $lineItem) {
            ProductModel::where('id', $lineItem['product_id'])->increment('checkout');
        }
        return response()->json(['status' => true]);
    }
}
