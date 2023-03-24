<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\OwnersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="owners-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'asset_id') ?>

    <?= $form->field($model, 'issued_by') ?>

    <?= $form->field($model, 'issued_date') ?>

    <?php // echo $form->field($model, 'returned_status') ?>

    <?php // echo $form->field($model, 'returned_date') ?>

    <?php // echo $form->field($model, 'received_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
