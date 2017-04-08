<?php

use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $page \dench\page\models\Page */

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container page">
    <h1 class="page-title"><?= $page->h1 ?></h1>
    <div class="page-text">
        <?= $page->text ?>
    </div>
    <a href="#" class="btn btn-primary modal-open" data-modal-id="hello" data-modal-url="<?= Url::to(['site/modal', 'dench' => 'hello2']) ?>" data-modal-size="">Open</a>
</div>