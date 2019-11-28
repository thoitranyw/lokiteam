<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function getProduct(Request $request) {
        $shopId = session('shopId');
        $productModel = new ProductModel();
        $productModel = $productModel->where('shop_id', $shopId)->with(['slider']);
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

    public function incrementView(Request $request, $shopId) {
        $productId = $request->input('product_id');
        if($product = ProductModel::find($productId)) {
            $product->increment('view');
            $product->save();
            return response()->json([
                'status' => true
            ]);
        }
        return response()->json([
            'status' => false
        ]);
    }

    public function incrementAddToCart(Request $request, $shopId) {
        $productId = $request->input('product_id');
        // dd($productId);
        if($product = ProductModel::find($productId)) {
            $product->increment('add_to_cart');
            $product->save();
            return response()->json([
                'status' => true
            ]);
        }
        return response()->json([
            'status' => false
        ]);
    }

    public function funnel(Request $request) {
        $shopId = session('shopId');
        $funnel = DB::table('product')
            ->select(DB::raw('shop_id, sum(view) as total_view, sum(add_to_cart) as total_add_to_cart, sum(checkout) as total_checkout'))
            ->where('shop_id', $shopId)
            ->whereNull('deleted_at')
            ->groupBy('shop_id')
            ->get();
        return response()->json([
            'result' => $funnel
        ], 200);
    }

    public function topProduct(Request $request) {
        $shopId = session('shopId');
        $topView = ProductModel::where('shop_id', $shopId)->orderBy('view', 'desc')->first();
        $topAddToCart = ProductModel::where('shop_id', $shopId)->orderBy('add_to_cart', 'desc')->first();
        $topCheckout = ProductModel::where('shop_id', $shopId)->orderBy('checkout', 'desc')->first();
        return response()->json([
            'result' => [
                'top_view' => $topView,
                'top_add_to_cart' => $topAddToCart,
                'top_checkout' => $topCheckout,
            ]
        ], 200);
    }
}
