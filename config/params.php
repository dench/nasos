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
        'watermark' => [
            'enabled' => true,
            'absolute' => false,
            'file' => '@webroot/img/watermark.png',
            'x' => 50,
            'y' => 70,
        ],
        'none' => '/img/photo-default.png?1',
        'size' => [
            'small' => [
                'width' => 600,
                'height' => 600,
                'method' => 'clip',
            ],
            'big' => [
                'width' => 1024,
                'height' => 1024,
                'method' => 'fill',
                'bg' => '#FFFFFF',
            ],
            'cover' => [
                'width' => 600,
                'height' => 600,
                'method' => 'fill',
                'bg' => '#FFFFFF',
            ],
            'fill' => [
                'width' => 400,
                'height' => 400,
                'method' => 'fill',
                'watermark' => [
                    'enabled' => false,
                ],
            ],
        ],
    ],
];
