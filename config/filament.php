<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Auth Guard
    |--------------------------------------------------------------------------
    |
    | Specify which auth guard Filament should use for admin authentication.
    | We'll set this to the `admin` guard so Filament users authenticate against
    | the `admins` table and `App\Models\Admin` model.
    |
    */
    'auth' => [
        'guard' => env('FILAMENT_AUTH_GUARD', 'admin'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Home URL
    |--------------------------------------------------------------------------
    |
    */
    'home_url' => env('FILAMENT_HOME_URL', '/admin'),
];
