<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'test/activecharge',
        'products/delete',
        'order/update_ali_order_no',
        'test/send_customer',
        'importHandle',
        'webhook/app_uninstalled',
        'webhook/shop_update',
        'webhook/orders_paid',
        'webhook/refunds_create',
        'webhook/orders_updated',
        'webhook/created_product',
        'webhook/updated_product',
        'webhook/delete_product',
        'webhook/update_fulfillments',
        'webhook/create_fulfillments',
        'webhook/customers_redact',
        'webhook/shop_redact',
        'extension/track_install',
        'extension/track_uninstall',
        'maintenance',
        'admin-api/sliders/set_position',
        'admin-api/sliders/unset_position'
//        'webhook/orders_fulfilled',
//        'webhook/orders_partially_fulfilled'
    ];
}
