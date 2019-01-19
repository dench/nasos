<?php
/**
 * Created by PhpStorm.
 * User: dench
 * Date: 25.03.17
 * Time: 13:27
 */

namespace app\widgets;

use dench\products\models\Product;
use yii\base\Widget;
use yii\helpers\Url;

class ProductCard extends Widget
{
    /**
     * @var $model Product
     */
    public $model;

    public $link;

    public function init()
    {
        $this->link = Url::to($this->link);
    }

    public function run()
    {
        return $this->render('productCard', [
            'model' => $this->model,
            'link' => $this->link,
        ]);
    }
}