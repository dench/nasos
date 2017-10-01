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
        'jpeg_quality' => 85,
        'convert' => true,
        'watermark' => [
            'enabled' => true,
            'absolute' => false,
            'file' => '@webroot/img/watermark.png',
            'x' => 50,
            'y' => 70,
        ],
        'none' => '/img/photo-default.png?1',
        'size' => [
            'page' => [
                'width' => 600,
                'height' => 450,
                'method' => 'clip',
            ],
            'cover' => [
                'width' => 200,
                'height' => 200,
                'method' => 'crop',
                'watermark' => [
                    'enabled' => false,
                ],
            ],
            'fill' => [
                'width' => 400,
                'height' => 400,
                'method' => 'fill',
                'watermark' => [
                    'enabled' => false,
                ],
            ],
            'category' => [
                'width' => 340,
                'height' => 340,
                'method' => 'fill',
                'bg' => '#FFFFFF',
                'watermark' => [
                    'width' => 102,
                ],
            ],
            'big' => [
                'width' => 1000,
                'height' => 1000,
                'method' => 'fill',
                'bg' => '#FFFFFF',
            ],
            'normal' => [
                'width' => 450,
                'height' => 450,
                'method' => 'fill',
                'bg' => '#FFFFFF',
                'watermark' => [
                    'width' => 130,
                ],
            ],
            'small' => [
                'width' => 240,
                'height' => 240,
                'method' => 'fill',
                'bg' => '#FFFFFF',
                'watermark' => [
                    'width' => 72,
                ],
            ],
            'micro' => [
                'width' => 135,
                'height' => 135,
                'method' => 'fill',
                'bg' => '#FFFFFF',
                'watermark' => [
                    'width' => 35,
                ],
            ],
        ],
    ],
];
