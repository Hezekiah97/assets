<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Disposal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="disposal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'asset_id')->textInput() ?>

    <?= $form->field($model, 'disposed_by')->textInput() ?>

    <?= $form->field($model, 'dispose_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
