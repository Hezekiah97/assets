<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-form">

<div class="row">
    <div class="col-md-6 offset-md-4">
    <div class="alert alert-info" role="alert">
        <i class="dripicons-information me-2"></i> <strong>NOTE!</strong> Permissions can be in a state of role i.e. Admin,Sectretariat...
        </div>
    <div class="card shadow-lg">
    <div class="p-4"> 
    <?php $form = ActiveForm::begin(); ?>
    <div class="mb-2">
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="mb-2">
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>
    </div>
    <div class="form-group mt-2">
        <a href="<?= Url::to(['index']) ?>" class="btn btn-sm btn-primary float-start"><i class="mdi mdi-arrow-left-circle-outline text-light"></i> Back</a>
        <?= Html::submitButton('<i class="mdi mdi-check-all text-light"></i> Save', ['class' => 'btn btn-success btn-sm float-end']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div></div></div>
</div>
