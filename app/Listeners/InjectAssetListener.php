<?php 
namespace App\Listeners;
use App\Repository\ShopRepository; 
use App\ShopifyApi\ShopsApi; 


class InjectAssetListener  {
    const LAYOUT_THEME = 'layout/theme.liquid';
    const ASSET_CORE = "{% include 'loki_core' %}";


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
         // filter main theme
         $theme = array_filter($listTheme, function($item) {
            return $item->role === 'main';
        });

        if (!empty($theme)) {
            $themeId = array_values($theme)[0]->id;
          
            $lokiFile =  self::LAYOUT_THEME ;
            $script = '<script src="' . env('APP_URL') . '/js/frontend.min.js"></script>';
            $resultLayout = $shopifyApi->getAssetValue($shopDomain, $accessToken, "2019-07",  $lokiFile, $themeId, $script);
             
            if ($resultLayout['status']) {
                $assetValue = $resultLayout['assetValue'];
                $value = $assetValue->value;

                if (!strpos($value, self::ASSET_CORE)) {
                    $assetCore = self::ASSET_CORE;
                    $newValue = "{$assetCore} \n </head>";
                    $pattern = '/<\/head>/';
                    $replace = preg_replace($pattern, $newValue, $value);

                    $shopifyApi->updateAssetValue($shopDomain, $accessToken, "2019-07",  $lokiFile, $themeId,   $replace);
                }
            }
        }

    }
}

