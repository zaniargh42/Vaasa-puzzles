<?php

return [

    'default' => env('APP_LOCALE', 'fa'),

    'fallback' => env('APP_FALLBACK_LOCALE', 'en'),

    'supported' => [
        'fa' => [
            'name' => 'Persian',
            'native' => 'فارسی',
            'dir' => 'rtl',
        ],
        'en' => [
            'name' => 'English',
            'native' => 'English',
            'dir' => 'ltr',
        ],
        'fi' => [
            'name' => 'Finnish',
            'native' => 'Suomi',
            'dir' => 'ltr',
        ],
    ],

];
