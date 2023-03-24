<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Owners */

$this->title = 'Create Owners';
$this->params['breadcrumbs'][] = ['label' => 'Owners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="owners-create">
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
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
