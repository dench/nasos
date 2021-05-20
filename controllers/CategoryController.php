<?php

namespace app\controllers;

use dench\products\models\Category;
use dench\products\models\Feature;
use app\models\ProductSearch;
use dench\page\models\Page;
use dench\products\models\Product;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class CategoryController extends Controller
{
    public function actionIndex()
    {
        $page = Page::viewPage(2);

        $categories = !Yii::$app->cache->exists('_categories-' . Yii::$app->language) ? Category::getMain() : [];

        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->where(['enabled' => true])->limit(8),
            'sort'=> [
                'defaultOrder' => [
                    'position' => SORT_ASC,
                ],
            ],
        ]);

        return $this->render('index', [
            'page' => $page,
            'categories' => $categories,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($slug)
    {
        $page = Category::viewPage($slug);

        $this->view->params['category_ids'] = [$page->id];

        $searchModel = new ProductSearch(['category_id' => $page->id, 'enabled' => true]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $features = Feature::getFilterList(true, [$searchModel->category_id]);

        return $this->render('view', [
            'page' => $page,
            'categories' => $page->categories,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'features' => $features,
        ]);
    }

}
