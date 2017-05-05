<?php

namespace app\controllers;

use app\models\Category;
use app\models\Product;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class SitemapController extends Controller
{
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/xml');

        $urls = [];

        $urls[] = [
            'loc' => Url::home('https'),
        ];

        $urls[] = [
            'loc' => Url::to(['site/about'], 'https'),
        ];

        $urls[] = [
            'loc' => Url::to(['site/contacts'], 'https'),
        ];

        $urls[] = [
            'loc' => Url::to(['category/index'], 'https'),
        ];

        $categories = Category::findAll(['enabled' => true]);

        foreach ($categories as $category) {
            $urls[] = [
                'loc' => Url::to(['category/view', 'slug' => $category->slug], 'https'),
                'lastmod' => date('Y-m-d', $category->updated_at),
            ];
        }

        $products = Product::findAll(['enabled' => true]);

        foreach ($products as $product) {
            $urls[] = [
                'loc' => Url::to(['product/index', 'slug' => $product->slug], 'https'),
                'lastmod' => date('Y-m-d', $product->updated_at),
            ];
        }

        return $this->renderPartial('index', [
            'urls' => $urls,
        ]);
    }

}
