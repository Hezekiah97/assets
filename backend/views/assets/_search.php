<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AssetsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="assets-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'barcode') ?>

    <?= $form->field($model, 'category') ?>

    <?= $form->field($model, 'condition') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'Asset_Particular') ?>

    <?php // echo $form->field($model, 'Extra_note') ?>

    <?php // echo $form->field($model, 'RegDate') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
