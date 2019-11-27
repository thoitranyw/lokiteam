<?php
return [
    'scopes' => [
        'read_products',
        'read_orders',
        'read_themes',
        'write_themes',
//        'write_fulfillments'
    ],
    'redirect_before_install' => env('APP_URL').'/auth/auth',
    'mail_from' => env('MAIL_FROM')
];