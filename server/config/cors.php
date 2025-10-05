<?php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // áp dụng cho api
    'allowed_methods' => ['*'],                  // cho phép tất cả method: GET, POST...
    'allowed_origins' => ['*'],                  // cho phép tất cả domain
    'allowed_headers' => ['*'],                  // cho phép tất cả header
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
