<?php

/* @var $this yii\web\View */
/* @var $page \dench\page\models\Page */

$this->params['breadcrumbs'][] = $page->name;
?>
<div class="container page">
    <h1 class="page-title"><?= $page->h1 ?></h1>
    <div class="page-text">
        <?= $page->text ?>
    </div>
</div>