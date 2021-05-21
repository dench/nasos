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
use yii\web\NotFoundHttpException;

class CategoryController extends Controller
{
    public function actionIndex()
    {
        if (!$page = Page::findOne(2)) {
            throw new NotFoundHttpException(Yii::t('yii', 'The requested page does not exist.'));
        }

        $categories = !Yii::$app->cache->exists('_categories-' . Yii::$app->language) ? Category::getMain() : [];

        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->where(['enabled' => true]),
            'sort'=> [
                'defaultOrder' => [
                    'position' => SORT_ASC,
                ],
            ],
            'pagination' => [
                'defaultPageSize' => 8,
                'forcePageParam' => false,
            ],
        ]);

        if (($p = Yii::$app->request->get('page')) > 1) {
            $page->title = Yii::t('app', '{0} - page № {1}', [$page->title, $p]);
            $page->description = Yii::t('app', '{0} - page № {1}', [$page->description, $p]);
        }

        $this->view->params['page'] = $page;
        $this->view->title = $page->title;

        if ($page->description) {
            $this->view->registerMetaTag([
                'name' => 'description',
                'content' => $page->description
            ]);
        }

        if ($page->keywords) {
            $this->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $page->keywords
            ]);
        }

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
