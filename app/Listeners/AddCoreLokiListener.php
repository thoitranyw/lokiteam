<?php 
namespace App\Listeners;
use App\Repository\ShopRepository; 
use App\ShopifyApi\ShopsApi; 
class AddCoreLokiListener
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
            $lokiFile =  'snippets/loki_core.liquid' ;
            $resultLayout = $shopifyApi->updateAssetValue($shopDomain, $accessToken, "2019-07",  $lokiFile, $themeId,  "Hoang");
        }
    }
}