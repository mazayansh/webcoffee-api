<?php

return [
    'cookie_name' => [
        'cart' => 'KOPISLUR-CART-ID'
    ],
    'shipping' => [
        'origin' => 'Sragen',
        'origin_code' => 427,
        'courier' => 'jne'
    ],
    'rajaongkir' => [
        'api_url' => env('RAJAONGKIR_API_URL'),
        'api_key' => env('RAJAONGKIR_API_KEY')
    ],
    'midtrans' => [
        'client_key' => env('MIDTRANS_CLIENTKEY'),
        'server_key' => env('MIDTRANS_SERVERKEY')
    ]
];
