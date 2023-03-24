<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Book */

$this->title = 'Update Book: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="book-update">
<div class="container">
    <div class="row">
        <div class="col">
            <div class="card shadow-lg mt-3">
                <div class="card-body">
                    <div class="">
                    <h4><i class="mdi mdi-plus-circle text-primary"></i><?= $this->title ?></h4>
                    </div>
                    <hr> 
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div></div></div></div></div>