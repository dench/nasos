<?php

return [
    'adminEmail' => '',
    'supportEmail' => '',

	'fileExtensions' => 'png, jpg, doc, txt',
	'fileMaxSize' => 10*1024*1024,
	'fileMaxFiles' => 50,
	'filePath' => dirname(__DIR__) . '/files',

    'imagesDir' => 'images',
    'imageCache' => [
        'big' => [
            'dir' => 'big',
            'width' => 1024,
            'height' => 768,
        ],
        'normal' => [
            'dir' => 'normal',
            'width' => 600,
            'height' => 450,
        ],
        'small' => [
            'dir' => 'small',
            'width' => 260,
            'height' => 195,
        ],
        'cover' => [
            'dir' => 'cover',
            'width' => 600,
            'height' => 600,
        ],
    ],
    'imageNone' => [
        'small' => '/img/none_small.jpg',
    ],

    'watermark' => [
        'file' => dirname(__DIR__) . '/web/img/watermark.png',
        'x' => 20,
        'y' => 15
    ],
    'watermarkThumb' => [
        'file' => dirname(__DIR__) . '/web/img/watermark_thumb.png',
        'x' => 20,
        'y' => 15
    ],

];
