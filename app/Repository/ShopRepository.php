<?php
declare(strict_types=1);
namespace App\Repository;

use App\Models\ShopModel;
use App\Models\ProductModel;
use Illuminate\Support\Arr;
/**
 * Class ShopsRepository
 * @package App\Repository
 */
class ShopRepository 
{
    /**
     *
     */
    public function all()
    {

    }
    
    /**
     * @return bool
     */
    public function delete(): bool
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param string $shopId
     * @return mixed
     */
    public function detail(string $shopId)
    {
        if($shopInfo = ShopModel::find($shopId))
            return $shopInfo;

        return false;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
	public function getAttributes( array $data = [])
	{
		$shopInfo = ShopModel::where( $data )->first();
		if($shopInfo)
			return $shopInfo;
		return false;
	}

    /**
     * @param string $shopId
     * @param array $data
     *
     * @return mixed
     */
    public function createOrUpdate(string $shopId, array $data = [])
    {
        $shopModel = new ShopModel();

        $filterData = Arr::only($data, $shopModel->getFillable());
        if($shop = $shopModel->find($shopId))
            return $shop->update($filterData);

        $filterData['id'] = $shopId;

        return $shopModel->firstOrCreate($filterData);
    }

    /**
     * @param string $public_token
     * 
     * @return mixed
     */
    public function getShopId($public_token)
    {
        $shopId = ShopModel::where('public_token',$public_token)->select('id')->first();
        if($shopId)
            return $shopId;

        return false;
        
    }

    public function updateSingleTotalQuantityProduct($productId) {
        try {
            $product = ProductModel::find($productId);
            if(! $product) 
                return false;
            $product->total_quantity = $product->productVariant()->sum('source_quantity');
            return $product->save();
        } catch (\Exception $e) {
            return false;
        }
        
    }

}