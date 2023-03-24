<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Book */

$this->title = 'Create Book';
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-create">


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
</div></div></div></div>