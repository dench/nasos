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
            'class' => 'app\components\SiteRequest'
        ],
        'urlManager' => [
            'class' => 'app\components\SiteUrlManager',
            //'defaultLanguage' => 'ru',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                '<controller:cart>' => '<controller>/index',
                '<action:(about|contacts)>' => 'site/<action>',
                'image/<size:[0-9a-z\-]+>/<name>.<extension:[a-z]+>' => 'image/default/index',
                'products' => 'category/index',
                'products/<slug:[0-9a-z\-]+>' => 'category/view',
                'product/<slug:[0-9a-z\-]+>' => 'product/index',
                'info' => 'info/index',
                'info/<slug:[0-9a-z\-]+>' => 'info/view',
                'sitemap.xml' => 'sitemap/index',
                'sitemap_ua.xml' => 'sitemap/ua',
                'sitemap_ru.xml' => 'sitemap/ru',
                'configurator' => 'configurator/index',
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
                    'sourcePath' => null,
                    'js' => ['https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js'],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'sourcePath' => null,
                    'js' => ['https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'],
                    'jsOptions' => [
                        'integrity' => 'sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa',
                        'crossorigin' => 'anonymous',
                    ],
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => '@webroot/bootstrap',
                    'css' => [],
                ],
                // java -jar compiler.jar --js vendor/yiisoft/yii2/assets/yii.js --js_output_file web/js/yii/yii.min.js
                // java -jar compiler.jar --js vendor/yiisoft/yii2/assets/yii.activeForm.js --js_output_file web/js/yii/yii.activeForm.min.js
                // java -jar compiler.jar --js vendor/yiisoft/yii2/assets/yii.captcha.js --js_output_file web/js/yii/yii.captcha.min.js
                // java -jar compiler.jar --js vendor/yiisoft/yii2/assets/yii.gridView.js --js_output_file web/js/yii/yii.gridView.min.js
                // java -jar compiler.jar --js vendor/yiisoft/yii2/assets/yii.validation.js --js_output_file web/js/yii/yii.validation.min.js
                // java -jar compiler.jar --js vendor/bower/yii2-pjax/jquery.pjax.js --js_output_file web/js/yii/jquery.pjax.min.js
                // java -jar compiler.jar --js web/js/photoswipe.js --js_output_file web/js/photoswipe.min.js
                // java -jar yuicompressor.jar --type css vendor/bower/photoswipe/dist/photoswipe.css -o web/css/photoswipe/photoswipe.min.css
                // java -jar yuicompressor.jar --type css vendor/bower/photoswipe/dist/default-skin/default-skin.css -o web/css/photoswipe/default-skin.min.css
                'yii\web\YiiAsset' => [
                    'sourcePath' => '@webroot/js/yii',
                    'js' => ['yii.min.js'],
                ],
                'yii\validators\ValidationAsset' => [
                    'sourcePath' => '@webroot/js/yii',
                    'js' => ['yii.validation.min.js'],
                ],
                'yii\widgets\ActiveFormAsset' => [
                    'sourcePath' => '@webroot/js/yii',
                    'js' => ['yii.activeForm.min.js'],
                ],
                'yii\widgets\PjaxAsset' => [
                    'sourcePath' => '@webroot/js/yii',
                    'js' => ['jquery.pjax.min.js'],
                ],
                /*'GridViewAsset' => [
                    'sourcePath' => '@webroot/js/yii',
                    'js' => ['yii.gridView.min.js'],
                ],*/
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

Yii::$classMap['dench\products\models\Product'] = '@app/models/Product.php';

return $config;