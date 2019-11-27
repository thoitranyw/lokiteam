<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\ShopRepository;
use App\Models\ProductModel;
use App\Models\ShopModel;
use App\Models\OrderModel;
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
        $order = OrderModel::find($data['id']);
        $shop_name = $request->server('HTTP_X_SHOPIFY_SHOP_DOMAIN');
        $objectShop = ShopModel::where('myshopify_domain', $shop_name)->first();
        $data['order_name'] = $data['name'];
        $orderModel = new OrderModel();
        $filterData = Arr::only($data, $orderModel->getFillable());
        $filterData['shop_id'] = $objectShop->id;
        if($order = $orderModel->find($data['id'])) {
            if(json_decode($order->product_ids)) {
                $product_ids = json_decode($order->product_ids);
            } else {
                $product_ids = [];
            }
            $productIds = $this->incrementCheckoutOrder($data['line_items'], $product_ids);
            $filterData['product_ids'] = json_encode($productIds);
            if($order->update($filterData)) {
                return response()->json(['status' => true]);
            }
            return response()->json(['status' => false]);
        }
        $productIds = $this->incrementCheckoutOrder($data['line_items'], []);
        $filterData['product_ids'] = json_encode($productIds);
        if($orderModel->firstOrCreate($filterData)) {
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
        
    }

    public function incrementCheckoutOrder($newLineItems, $oldLineItems) {
        $lineItems = $newLineItems;
        foreach($lineItems as $lineItem) {
            if(!in_array($lineItem['product_id'], $oldLineItems)) {
                ProductModel::where('id', $lineItem['product_id'])->increment('checkout');
                $oldLineItems[] = $lineItem['product_id'];
            }
        }
        return $oldLineItems;
    }
}
