<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Marketplace Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for the Education Marketplace Service
    |
    */

    'platform' => [
        'name' => env('APP_NAME', 'Education Marketplace'),
        'commission_rate' => env('PLATFORM_COMMISSION_RATE', 0.15), // 15% of transaction
        'min_instructor_payout' => env('MIN_INSTRUCTOR_PAYOUT', 50), // Minimum payout amount
    ],

    'kyc' => [
        'enabled' => true,
        'require_for_booking' => true,
        'require_for_teaching' => true,
        'document_types' => ['passport', 'national_id', 'driver_license'],
        'max_document_age_years' => 10,
    ],

    'booking' => [
        'enabled' => true,
        'cancellation_window_hours' => 24,
        'min_course_duration_hours' => 1,
    ],

    'settlement' => [
        'period' => env('SETTLEMENT_PERIOD', 'monthly'), // weekly, biweekly, monthly
        'processing_days' => 7,
    ],

    'payment' => [
        'methods' => ['credit_card', 'debit_card', 'bank_transfer', 'e_wallet'],
        'providers' => [
            'stripe' => [
                'enabled' => env('STRIPE_ENABLED', false),
                'key' => env('STRIPE_PUBLIC_KEY'),
                'secret' => env('STRIPE_SECRET_KEY'),
            ],
            'paypal' => [
                'enabled' => env('PAYPAL_ENABLED', false),
                'client_id' => env('PAYPAL_CLIENT_ID'),
                'secret' => env('PAYPAL_SECRET'),
            ],
        ],
    ],

    'notifications' => [
        'email' => true,
        'sms' => true,
        'push' => true,
    ],
];
