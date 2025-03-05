<?php

return [

    'defaults' => [
        'guard' => 'web', // Default remains web, which will be used for customers.
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [ // Web guard for customers
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin' => [  // Admin guard
            'driver' => 'session',
            'provider' => 'admins', // Change this to the correct provider name for admins
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
    ],

    'providers' => [
        'users' => [ //Customer User Provider
            'driver' => 'eloquent',
            'model' => App\Models\User::class, // Assuming you renamed the default user model to Customer
        ],

        'admins' => [ // Admin User Provider
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class, // Assuming you have an Admin model
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'admins' => [ // Add a password reset configuration for Admins
            'provider' => 'admins',
            'table' => 'password_reset_tokens', // You might want separate tables for each.
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];