<?php

namespace App\Http\Controllers;

use App\Models\ShopModel;
use App\Models\ProductModel;
use App\Services\SpfService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\ShopifyApi\ShopsApi;
use App\Repository\ShopRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;
use App\ShopifyApi\ProductsApi;
use App\Events\AddCoreLokiEvent;


class AppsController extends Controller
{
	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function installApp()
    {
        session(['shopDomain' => null]);
		return view( 'apps.install_app');
	}

	/**
	 * @param InstallAppsRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function installAppHandle(Request $request)
    {
        $spfService = new SpfService();
		$urlStore   = $request->input('shop', null);
		return response()->json([
            'url' => $spfService->installURL($urlStore)
        ]);
    }

	public function storeError($shopDomain)
    {
        return view('errors.store_error', compact('shopDomain'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
	public function auth(Request $request)
	{
		$request = $request->all();
		return $this->authWithRequest($request, 'auth');
    }

    public function removeOwnStore(Request $request) {
        $shopId = $request->input('shop_id', null);
        if($shopId) {
            $shopUser = UserShopModel::where(['user_id' => session('user_id'), 'shop_id' => $shopId])->first();
            if($shopUser) {
                $shopUser->forceDelete();
                $userShop = session('user_shop', []);
                $userShop = array_filter($userShop, function ($shop) use ($shopId) {
                    return $shop['shop']['id'] != $shopId;
                });
                session(['user_shop' => $userShop]);
                return response()->json(['status'=> true]);
            }
        }
        return response()->json(['status'=> false]);
    }

    public function saveAffiliate()
    {

        $data = [
            'partner_id' => empty($_COOKIE['partner_id']) ? '' : $_COOKIE['partner_id'],
            'campaign'   => empty($_COOKIE['utm_campaign']) ? '' : $_COOKIE['utm_campaign'],
            'source'     => empty($_COOKIE['utm_source']) ? '' : $_COOKIE['utm_source'],
            'medium'     => empty($_COOKIE['utm_medium']) ? '' : $_COOKIE['utm_medium'],
            'store_name' => session('shopDomain'),
            'accessToken'=> session('accessToken'),
            'app'        => 'aliorders',
            'status'     => 'free',
            'price'      => 0
        ];

        AffiliateJob::dispatch($data)->allOnQueue('affiliate');
    }

    public function checkShop($shopDomain)
    {
        $shopRepo = new ShopRepository();
        $shopStatus = $shopRepo->checkShopStatus($shopDomain);
        return response()->json(['data' => $shopStatus]);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function errors()
    {
        $shopId = session('shopId');
        return view('errors.404', compact('shopId'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect(route('dashboard.index'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function installData()
    {
        $shopId = session('shopId');
        return view('apps.install_data', compact('shopId'));
    }

    public function authWithRequest($request, $type = 'auth') {
        $spfService = new SpfService($request['shop']);
		$accessData = $spfService->authApp($request);
		if (!isset($accessData->access_token) )
		{
            if ($type == 'auth') {
                return redirect(route( 'apps.installApp'))->with('error', 'Not verify request, contact Support FireApps- support@fireapps.io');
            } else {
                return redirect(route('dashboard.index'))->with('error', 'Not verify request, contact Support FireApps- support@fireapps.io');
            }
        }

        $accessToken = $accessData->access_token;

        // $accessToken = $accessData->access_token;
        // $associatedUser = $accessData->associated_user;
        $shopDomain  = $request['shop'];
        $shopApi = new ShopsApi($shopDomain, $accessToken);
        $shopRepo = new ShopRepository();
        $shopInfoApi = $shopApi->get();
        if( ! $shopInfoApi['status']) {
            if($type == 'auth') {
                return redirect(route('apps.installApp'))->with('error', 'Error request');
            } else {
                return redirect(route('dashboard.index'))->with('error', 'Error request');
            }
        }
        $shopInfoApi = (array) $shopInfoApi['data']->shop;
        $shopInfoApi['access_token'] = $accessToken;
        $shopInfoApi['status'] = config('common.status.publish');
		//Check shop database
        $shopInfo = $shopRepo->detail($shopInfoApi['id']);
        //Update access token
        
        if(in_array($type, ['auth', 'switch'])) {
            //Save session accessToken and shopDomain
            session(['accessToken' => $accessToken, 'shopDomain'  => $shopDomain, 'shopId' => $shopInfoApi['id'],
            'shopOwner' => $shopInfoApi['shop_owner'], 'shopEmail' => $shopInfoApi['email'],
            'created_at' => strtotime($shopInfoApi['created_at']), 'goodToken' => 1]);

        }
        if( ! $shopInfo || (isset($shopInfo->status) && ! $shopInfo->status))
        {
            if($shopRepo->createOrUpdate($shopInfoApi['id'], $shopInfoApi))
            {   
                $shopId = $shopInfoApi['id'];
                if(!empty($shopId)) {
                    event( new AddCoreLokiEvent($shopId)) ;
                }
                return redirect('/');
            }
        } else {
            $shopRepo->createOrUpdate($shopInfoApi['id'], ['access_token' => $accessToken]);
            $shopId = $shopInfoApi['id'];
            if(!empty($shopId)) {
                event( new AddCoreLokiEvent($shopId)) ;
            }
        }
        return redirect('/');
    }

    public function SyncProduct(Request $request, $shopId) {
        // $shopId = session('shopId');
        // $shopId = 7112032315;
        $shop = ShopModel::find($shopId);
        $productApi = new ProductsApi($shop->myshopify_domain, $shop->access_token);


        $count = $productApi->count([], 'any');
        if ($count['status']) {
            $count = $count['data']->count;

            $page = ceil($count / 250);
            for($i = 1; $i <= $page; $i++)
            {
                $products = $productApi->all([], [], $i, 250, 'any');
                //Convert object to array
                $products = $products['data']->products;
                $products = json_decode(json_encode($products), true);

                foreach ($products as $productData)
                {
                    $data = $productData;
                    $productModel = new ProductModel();
                    $filterData = Arr::only($data, $productModel->getFillable());
                    $filterData['shop_id'] = $shopId;
                    $filterData['image'] = isset($data['image']['src']) ? $data['image']['src'] : null;
                    
                    if($product = $productModel->find($data['id'])) {
                        $product->update($filterData);
                    } else {
                        $productModel->firstOrCreate($filterData);
                    }
                }
            }
        }
        return true;
    }
}
