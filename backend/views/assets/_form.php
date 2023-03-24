<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Categories;

/* @var $this yii\web\View */
/* @var $model backend\models\Assets */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="assets-form">

<?php $form = ActiveForm::begin(); ?>
        <div class="row mb-2">
            <div class="col-md-4 mb-2">
            <?= $form->field($model, 'barcode')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-4 mb-2">
            <?= $form->field($model, 'category')->dropDownList(ArrayHelper::map(Categories::find()->all(),'id','category_name'), ['prompt' => 'Category','class' => 'form-control select2', 'data-toggle' => 'select2']) ?>       
            </div>
            <div class="col-md-4 mb-2">
            <?php
                $conditions = ['Good'=>'Good','Average'=>'Average','Bad'=>'Bad'];
            
                echo $form->field($model, 'condition')->dropDownList($conditions, ['prompt' => 'Asset Condition','class' => 'form-control select2', 'data-toggle' => 'select2']);

            ?>
        </div>
        </div>
        <div class="row mb-2">
            <div class="col-md-6">
            <?= $form->field($model, 'Asset_Particular')->textarea(['rows' => '6']) ?>
            </div>
            <div class="col-md-6">
            <?= $form->field($model, 'Extra_note')->textarea(['rows' => '6']) ?>     
            </div>
        </div>
                
    <div class="form-group mt-2">
        <a href="<?= Url::to(['index']) ?>" class="btn btn-sm btn-primary float-start"><i class="mdi mdi-arrow-left-circle-outline text-light"></i> Back</a>
        <?= Html::submitButton('<i class="mdi mdi-check-all text-light"></i> Save', ['class' => 'btn btn-success btn-sm float-end']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
