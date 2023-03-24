<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BookStockSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-stock-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'barcode') ?>

    <?= $form->field($model, 'isbn') ?>

    <?= $form->field($model, 'inspector') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'count') ?>

    <?php // echo $form->field($model, 'book_id') ?>

    <?php // echo $form->field($model, 'stock_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
