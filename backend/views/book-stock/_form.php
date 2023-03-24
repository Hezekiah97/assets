<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BookStock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-stock-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'barcode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'inspector')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'count')->textInput() ?>

    <?= $form->field($model, 'book_id')->textInput() ?>

    <?= $form->field($model, 'stock_date')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
