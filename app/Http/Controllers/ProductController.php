<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;

class ProductController extends Controller
{
    public function getProduct(Request $request) {
        $shopId = session('shopId');
        $productModel = new ProductModel();
        $productModel->where('shop_id', $shopId);
        if(!empty($request->get('title'))) {
            $productModel = $productModel->where('title', 'LIKE', '%'. $request->get('title') .'%');
        }
        if(!empty($request->get('sortby'))) {
            $orderBy = $request->get('sortby');
            if(in_array($orderBy, ['view', 'add_to_cart', 'checkout'])) {
                $productModel = $productModel->orderBy($orderBy, 'desc');
            }
        }

        $products = $productModel->paginate(20);
        return response()->json([
            'result' => $products
        ], 200);
    }
}
