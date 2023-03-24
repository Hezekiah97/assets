<?php

use yii\helpers\Url;
use yii\helpers\Html;
use backend\models\Assets;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\Owners */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="owners-form">
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => true,'class' => 'form-control mb-4']) ?>
<?=$form->field($model, 'asset_id')->dropDownList(ArrayHelper::map(Assets::find()->where(['status'=>1])->all(),'id','barcode'), ['prompt' => 'Please select asset','class' => 'form-control select2', 'data-toggle' => 'select2']) ?>

<div class="form-group mt-4">
    <a href="<?= Url::to(['index']) ?>" class="btn btn-sm btn-primary float-start"><i class="mdi mdi-arrow-left-circle-outline text-light"></i> Back</a>
    <?= Html::submitButton('<i class="mdi mdi-check-all text-light"></i> Save', ['class' => 'btn btn-success btn-sm float-end']) ?>   
</div>

<?php ActiveForm::end(); ?>
</div>
