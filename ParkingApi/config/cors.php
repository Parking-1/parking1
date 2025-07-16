<?php

return [

    'paths' => ['api/*', 'login', 'logout', 'user/me', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:5173',
        'http://parking.local:5173', // 👈 Añadido si usas Vite con ese dominio
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // 👈 Necesario para cookies
];

