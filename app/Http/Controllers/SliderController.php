<?php 


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\SliderModel;

class SliderController extends Controller {
    
    public function index (){

        return view('slider.index');
    }

    public function getSliderAdmin(Request $request) {
        $shopId = session('shopId');
        $sliders = SliderModel::where('shop_id', $shopId)->with(['product'])->get();
        return response()->json([
            'result' => $sliders
        ], 200);
    }

    public function getSliderTheme(Request $request, $shopId) {
        $sliders = SliderModel::where('shop_id', $shopId)->with(['product'])->get();
        return response()->json([
            'result' => $sliders
        ], 200);
    }

    public function setProductPosition(Request $request) {
        $shopId = session('shopId');
        
        $productId = $request->input('product_id');
        $position = $request->input('position');

        $slider = SliderModel::where('shop_id', $shopId)
                        ->where('position', $position)
                        ->where('product_id', '<>', $productId)
                        ->first();
            
        if($slider) {
            $slider->product_id = $productId;
            $slider->save();
        } else {
            SliderModel::create([
                'shop_id' => $shopId,
                'product_id' => $productId,
                'position' => $position
            ]);
        }

        SliderModel::where('shop_id', $shopId)
                        ->where('product_id', $productId)
                        ->where('position', '<>', $position)
                        ->delete();
                        
        $sliderCheck = SliderModel::where('shop_id', $shopId)->where('product_id', $productId)->first();
        if($sliderCheck) { 
            return response()->json([
                'status' => true,
                'result' => $sliderCheck
            ], 200); 
        }
        return response()->json([
            'status' => false,
        ], 200);
    }

    public function unsetPosition(Request $request) {
        $shopId = session('shopId');
        $productId = $request->input('product_id');
        SliderModel::where('shop_id', $shopId)
                        ->where('product_id', $productId)
                        ->delete();

        $sliderCheck = SliderModel::where('shop_id', $shopId)->where('product_id', $productId)->first();
        if($sliderCheck) { 
            return response()->json([
                'status' => false
            ], 200); 
        }
        return response()->json([
            'status' => true,
        ], 200);
    }
    
}