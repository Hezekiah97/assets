<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Categories */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="categories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group d-grid">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success btn-sm mt-2']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
