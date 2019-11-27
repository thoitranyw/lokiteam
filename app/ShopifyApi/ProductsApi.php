<?php

namespace App\ShopifyApi;

use App\Services\SpfService;

/**
 * Class ProductsApi
 *
 * @package App\ShopifyApi
 */
class ProductsApi extends SpfService 
{
	/**
	 * @param array  $field
	 * @param int    $page
	 * @param int    $limit
	 * @param string $status
	 * @param array  $filters
	 *
	 * @return mixed
	 */
	public function all( array $field = [], array $filters = [], int $page = 1, int $limit = 250, $status = 'any' )
	{
        $field = implode( ',', $field );
        $data  = [
            'limit'            => $limit,
            'page'             => $page,
            'fields'           => $field,
            'published_status' => $status
        ];


        if ( ! empty( $filters['title'] ) ) {
            $data['title'] = $filters['title'];
        }

        if ( ! empty( $filters['collection_id'] ) ) {
            $data['collection_id'] = $filters['collection_id'];
        }

        $products = $this->getRequest('products.json',  $data);
        return $products;
	}
	
	/**
	 * @param array  $field
	 * @param string $product
	 *
	 * @return mixed
	 */
	public function detail( array $field = [], string $product )
	{
        $field   = implode( ',', $field );
        $product = $this->getRequest( 'products/' . $product . '.json', ['fields' => $field]);
        return $product;
	}
	
	/**
	 * @param string $status
	 * @param array  $filters
	 *
	 * @return mixed
	 */
	public function count( array $filters = [], string $status = 'any' )
	{
        $data['published_status'] = $status;
        if ( ! empty( $filters['collection_id'] ) ) {
            $data['collection_id'] = $filters['collection_id'];
        }

        if ( ! empty( $filters['title'] ) ) {
            $data['title'] = $filters['title'];
        }

        return $this->getRequest( 'products/count.json', $data );
	}
	
	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public function create( array $data ): array
	{
        $product = $this->postRequest( 'products.json',
            [
                'product' => $data
            ]
        );
        return $product;
	}
	
	/**
	 * @param string $product
	 * @param array  $data
	 *
	 * @return array
	 */
	public function update( string $product, array $data ): array
	{
        $product = $this->putRequest( 'products/'.$product.'.json',
            [
                'product' => $data
            ]
        );
        return $product;
	}
	
	/**
	 * @param string $product
	 *
	 * @return array
	 */
	public function delete( string $product ): array
	{
		return $this->deleteRequest('products/'.$product.'.json');
	}
}