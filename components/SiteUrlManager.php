<?php

namespace app\components;

use Yii;
use yii\web\UrlManager;

class SiteUrlManager extends UrlManager
{
    public function parseRequest($request)
    {
        if (strpos($request->url, 'index.php') || strpos($request->url, 'index.html')) {
            Yii::$app->response->redirect('/', 301);
        }

        return parent::parseRequest($request);
    }

    public function createUrl($params)
    {
        $url = parent::createUrl($params);

        $lang = null;

        if (isset($params['lang'])) {
            $lang = $params['lang'] === 'uk' ? '/ua' : '';
            unset($params['lang']);
            $url = $lang . str_replace('/ua/', '/', parent::createUrl($params));
        }

        if ($lang === null &&
            empty($params['lang']) &&
            Yii::$app->language === 'uk' &&
            strpos($params[0], 'image/') !== 0 &&
            strpos($url, '/ua/') !== 0) {
            $url = '/ua' . $url;
        }

        return $url;
    }
}