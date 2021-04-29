<?php

namespace app\controllers;

use dench\page\models\Page;
use dench\products\models\Category;
use dench\products\models\Product;
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

        $site = Url::to(['/'], 'https');

        return '<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<sitemap><loc>' . $site . 'sitemap_ru.xml</loc></sitemap>
<sitemap><loc>' . $site . 'sitemap_ua.xml</loc></sitemap>
</sitemapindex>';
    }

    public function actionUa()
    {
        return $this->actionLang('uk');
    }

    public function actionRu()
    {
        return $this->actionLang('ru');
    }

    public function actionLang($lang)
    {
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/xml');

        Yii::$app->language = $lang;

        $urls = [];

        $urls[] = [
            'loc' => Url::to(['/'],'https'),
        ];

        $site = [
            'about',
            'contacts',
        ];

        foreach ($site as $s) {
            $urls[] = [
                'loc' => Url::to(['site/' . $s], 'https'),
            ];
        }

        $urls[] = [
            'loc' => Url::to(['info/index'], 'https'),
        ];

        $info = Page::find()
            ->select(['slug', 'updated_at'])
            ->leftJoin('page_parent','page.id = page_parent.page_id')
            ->andWhere(['parent_id' => 6])
            ->andWhere(['enabled' => Page::ENABLED])
            ->all();

        foreach ($info as $page) {
            $urls[] = [
                'loc' => Url::to(['info/view', 'slug' => $page->slug], 'https'),
                'lastmod' => date('Y-m-d', $page->updated_at),
            ];
        }

        $urls[] = [
            'loc' => Url::to(['category/index'], 'https'),
        ];

        $categories = Category::findAll(['enabled' => true]);

        foreach ($categories as $category) {
            $url = Url::to((count($category->categories)) ? ['category/pod', 'slug' => $category->slug] : ['category/view', 'slug' => $category->slug], 'https');
            $urls[] = [
                'loc' => $url,
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
