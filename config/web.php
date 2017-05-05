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
            'defaultLanguage' => 'uk',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '<action:(about|contacts)>' => 'site/<action>',
                'image/<size:[0-9a-z\-]+>/<name>.<extension:[a-z]+>' => 'image/default/index',
                'products' => 'category/index',
                'products/<slug:[0-9a-z\-]+>' => 'category/view',
                'product/<slug:[0-9a-z\-]+>' => 'product/index',
                'sitemap.xml' => 'sitemap/index'
            ],
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => $params['recaptchaSiteKey'],
            'secret' => $params['recaptchaSecretKey'],
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
