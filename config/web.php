<?php

/** @var array $params */

$config = [
    'id' => 'app',
    'defaultRoute' => 'site/index',
    'components' => [
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['admin/default/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
        ],
        'request' => [
            'class' => 'dench\language\LangRequest'
        ],
        'urlManager' => [
            'class' => 'dench\language\LangUrlManager',
            'defaultLanguage' => 'ru',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '<action:(about|contacts)>' => 'site/<action>',
                'image/<size:[0-9a-z\-]+>/<name>.<extension:[a-z]+>' => 'image/default/index',
                'products' => 'category/index',
                'products/<slug:[0-9a-z\-]+>' => 'category/view',
                'product/<slug:[0-9a-z\-]+>' => 'product/index',
                'info' => 'info/index',
                'info/<slug:[0-9a-z\-]+>' => 'info/view',
                'sitemap.xml' => 'sitemap/index'
            ],
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => $params['recaptchaSiteKey'],
            'secret' => $params['recaptchaSecretKey'],
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        'jquery.min.js'
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        'js/bootstrap.min.js',
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => '@webroot/bootstrap',
                ],
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;