<?php
/** @var $this yii\web\View */
/** @var $page dench\page\models\Page */
/** @var $categories app\models\Category[] */

$this->params['breadcrumbs'][] = $page->name;
?>
<div class="container page">

    <h1 class="page-title"><?= $page->h1 ?></h1>

    <div class="page-text">
        <?= $page->text ?>
    </div>

    <?= Yii::$app->cache->getOrSet('_categories-' . Yii::$app->language, function () use ($categories) {
            return $this->render('_categories', [
                'categories' => $categories,
            ]);
        });
    ?>
</div>
