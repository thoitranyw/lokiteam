<?php

namespace App\ShopifyApi;


use Exception;

class AssetsApi
{
   
 

    /**
     * @param $currentTheme
     * @param $fileAsset
     * @return array
     */
    public function getAssetValue($shopDmain ,$accessToken,$appVs = "2019-07",  $currentTheme, $fileAsset, $url)
    {
        try {
            $client = new Client();
            $response = $client->request(
                'GET',
                "https://$this->_shopDomain/admin/api/"$$appVs'/'$currentTheme"/$url",
                [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-Shopify-Access-Token' =>$accessToken
                ],
                'query' =>[
                        'asset' => [
                            'key' => $fileAsset,
                        ]
                    ]
                ]
            );
            if($responseType == 'content'){
                return json_decode($response->getBody()->getContents());
            }
        }catch{
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }

    /**
     * @param $currentTheme
     * @param $fileAsset
     * @param $newAssetValue
     * @return array
     */
//     public function updateAssetValue($currentTheme = '',$fileAsset = '', $newAssetValue = '')
//     {
//         try {
// //            $this->_shopify->call([
// //                'URL' => 'themes/'.$currentTheme.'/assets.json',
// //                'METHOD' => 'PUT',
// //                'DATA' => [
// //                    'asset' => [
// //                        'key' => $fileAsset,
// //                        'value' => $newAssetValue
// //                    ]
// //                ]
// //            ]);
//             $this->put(
//                 'themes/' . $currentTheme . '/assets.json',
//                 [
//                     'asset' => [
//                         'key' => $fileAsset,
//                         'value' => $newAssetValue
//                     ]
//                 ]
//             );
//             return ['status' => true];

//         } catch (Exception $exception)
//         {
//             $this->sentry->captureException($exception);
//             return ['status' => false, 'message' => $exception->getMessage()];
//         }
//     }
}