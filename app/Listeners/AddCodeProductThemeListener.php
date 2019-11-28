<?php 
namespace App\Listeners;
use App\Repository\ShopRepository; 
use App\ShopifyApi\ShopsApi; 
class AddCodeProductThemeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */

  


    public function __construct()
    {
        //
    }
    /**
     * Handle the event.
     *
     * @param  ShopInstall  $event
     * @return void
     */
    public function handle($event)
    {
        $shopRepo = new ShopRepository() ; 
        $shopId = $event->shopId;
        $info = $shopRepo->detail($shopId);
        $accessToken  = $info->access_token ; 
        $shopDomain  = $info->domain;
        $shopifyApi = new ShopsApi(); 
        $info = $shopifyApi->getRequestApi($shopDomain, $accessToken);
        $listTheme = $info['data']->themes;
        $theme = array_filter($listTheme, function($item) {
            return $item->role === 'main';
        });
        if (!empty($theme)) {
            $themeId = array_values($theme)[0]->id;
            $lokiFile =  'sections/product-template.liquid' ;
            $script = '<input id="loki-shopid-app" type="hidden" value="'. $shopId .'" />
            <link rel="stylesheet" href="'. env('APP_URL')  .'/css/frontend.min.css" />
            <link rel="stylesheet" href="' . env('APP_URL') . '/css/uikit.min.css" />
            <script src="' . env('APP_URL') . '/js/uikit.min.js"></script>
            <script src="' . env('APP_URL') . '/js/uikit-icons.min.js"></script>
            <script src="' . env('APP_URL') . '/js/frontend.min.js"></script>';
            $resultLayout = $shopifyApi->updateAssetValue($shopDomain, $accessToken, "2019-07",  $lokiFile, $themeId,  $script);
        }
    }
}