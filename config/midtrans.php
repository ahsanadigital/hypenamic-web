<?php

return (array) [

    /*
    |--------------------------------------------------------------------------
    | Setup The Midtrans API
    |--------------------------------------------------------------------------
    |
    | Midtrans Payment Gateway memerlukan data API keyserver yang nantinya digunakan
    | untuk membuat tagihan dan membayar tagihan secara realtime dari Midtrans
    |
    */
    'payment' => [
        'prod_url'   => 'https://app.midtrans.com/snap/snap.js',
        'sand_url'   => 'https://app.sandbox.midtrans.com/snap/snap.js',
        'production' => env('MIDTRANS_PRODUCTION', false),
        'merchant'   => env('MIDTRANS_MERCHANT', null),
        'client_key' => env('MIDTRANS_CLIENT_KEY', null),
        'server_key' => env('MIDTRANS_SERVER_KEY', null),
    ]
];
