<?php

return [
    'store_id' => env('AAMARPAY_STORE_ID','bjsexam'),
    'signature_key' => env('AAMARPAY_KEY','24b07a0a021706e13b79880bcf7c4033'),
    'sandbox' => env('AAMARPAY_SANDBOX', false),
    'redirect_url' => [
        'success' => [
            'url' => env('AAMARPAY_SUCCESS_URL','index.payment.success') // payment.success
        ],
        'cancel' => [
            'url' => env('AAMARPAY_CANCEL_URL','index.payment.cancel') // payment/cancel or you can use route also
        ],
        'failed' => [
            'url' => env('AAMARPAY_CANCEL_URL','index.payment.failed') // payment/cancel or you can use route also
        ]
    ]
];
