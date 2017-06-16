<?php

return [
    'adminEmail' => '',
    'supportEmail' => '',
    'phone' => '',
    'googleMapsApiKey' => '',
    'recaptchaSiteKey' => '',
    'recaptchaSecretKey' => '',

    'file' => [
        'extensions' => 'png, jpg',
        'maxSize' => 10*1024*1024,
        'maxFiles' => 50,
        'path' => dirname(__DIR__) . '/files',
    ],

    'image' => [
        'path' => 'image',
        'jpeg_quality' => 90,
        'watermark' => [
            'enabled' => true,
            'absolute' => false,
            'file' => '@webroot/img/watermark.png',
            'x' => 50,
            'y' => 70,
        ],
        'none' => '/img/photo-default.png?1',
        'size' => [
            'big' => [
                'width' => 1024,
                'height' => 768,
            ],
            'small' => [
                'width' => 600,
                'height' => 600,
            ],
            'cover' => [
                'width' => 600,
                'height' => 600,
                'method' => 'fill',
                'bg' => '#FFFFFF',
            ],
        ],
    ],
];
