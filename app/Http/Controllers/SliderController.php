<?php 
namespace App\Http\Controllers;
use App\Repository\ShopRepository; 
use App\ShopifyApi\ShopsApi;
use App\Events\AddCoreLokiEvent;

class SliderController extends Controller {
    
    public function index (){
        return view('slider.index');
    }
}