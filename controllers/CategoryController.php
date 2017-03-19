<?php

namespace app\controllers;

use app\models\Category;
use app\models\Page;
use yii\web\Controller;

class CategoryController extends Controller
{
    public function actionIndex()
    {
        $page = Page::viewPage(2);

        $categories = Category::getMain();

        return $this->render('index', [
            'page' => $page,
            'categories' => $categories,
        ]);
    }

    public function actionView($slug)
    {
        $page = Category::viewPage($slug);

        $this->view->params['category_ids'] = [$page->id];

        return $this->render('view', [
            'page' => $page,
            'categories' => $page->categories,
            'products' => $page->products,
        ]);
    }

}
