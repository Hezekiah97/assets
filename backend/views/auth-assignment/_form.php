<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\User;
use yii\widgets\ActiveForm;
use backend\models\AuthItem;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-assignment-form">

<div class="row">
    <div class="col-md-6 offset-md-4">
    <div class="card shadow-lg">
    <div class="p-4"> 
    <?php $form = ActiveForm::begin(); ?>
    <div class="mb-2">
    <?php
    $users = User::find()->all();
    foreach ($users as $user) {
      $user->firstname = $user->firstname. ' ' .$user->surname;
    }  
    echo $form->field($model, 'user_id')->dropDownList(ArrayHelper::map($users,'id','firstname'), ['prompt' => 'Select user','class' => 'form-control select2', 'data-toggle' => 'select2']) ?>
    </div>
    <div class="mb-2">
      <?= $form->field($model, 'item_name')->dropDownList(ArrayHelper::map(AuthItem::find()->all(),'name','name'), ['prompt' => 'Select role','class' => 'form-control select2', 'data-toggle' => 'select2']) ?>
    </div>
    <div class="form-group mt-2">
        <a href="<?= Url::to(['index']) ?>" class="btn btn-sm btn-primary float-start"><i class="mdi mdi-arrow-left-circle-outline text-light"></i> Back</a>
        <?= Html::submitButton('<i class="mdi mdi-check-all text-light"></i> Save', ['class' => 'btn btn-success btn-sm float-end']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div></div></div></div>
</div>
