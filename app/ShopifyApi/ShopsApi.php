<?php

namespace App\ShopifyApi;

use App\Services\SpfService;
use Exception;

class ShopsApi extends SpfService
{
    /**
     * @return bool
     */
	public function get()
	{
	    return $this->getRequest( 'shop.json' );
	}
}