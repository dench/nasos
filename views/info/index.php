<?php

use yii\widgets\ListView;

/** @var $this yii\web\View */
/** @var $page dench\page\models\Page */
/** @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $page->name;
?>
<div class="container page">

    <h1 class="page-title"><?= $page->h1 ?></h1>

    <div class="news">
    <?php
    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'layout' => "<div class=\"row cards\">{items}</div>\n<div class=\"clear-pager text-center\">{pager}</div>",
        'emptyTextOptions' => [
            'class' => 'alert alert-danger',
        ],
    ]);
    ?>
    </div>

    <div class="page-text">
        <?= $page->text ?>
    </div>
</div>