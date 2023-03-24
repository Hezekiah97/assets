<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">
<?php $form = ActiveForm::begin(); ?>
    <div class="row">
    <div class="col-md-4">
    <div class="mb-2">
    <?php
        $item_types = ['Book'=>'Book','Audio'=>'Audio'];
        echo $form->field($model, 'item_type')->dropDownList($item_types, ['prompt' => 'Itme type','class' => 'form-control select2', 'data-toggle' => 'select2']);
    ?>
    </div>
    </div>
    <div class="col-md-4">
    <div class="mb-2">
    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>
    </div>
    </div>
    <div class="col-md-4">
    <div class="mb-2">
    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>
    </div>
    </div>
    </div>
<div class="row">
<div class="col-md-4">
    <div class="mb-2">
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    </div>
    </div>
    <div class="col-md-4">
        <div class="mb-2">
        <?= $form->field($model, 'yop')->textInput() ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-2">
        <?= $form->field($model, 'barcode')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
</div>

<div class="row">
<div class="col-md-4">
        <div class="mb-2">
        <?= $form->field($model, 'qty')->textInput() ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-2">
         <?= $form->field($model, 'price')->textInput() ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="mb-2">
        <?php
        $conditions = ['Good'=>'Good','Average'=>'Average','Bad'=>'Bad'];
        echo $form->field($model, 'condition')->dropDownList($conditions, ['prompt' => 'Please select condition','class' => 'form-control select2', 'data-toggle' => 'select2']);
        ?>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-4">
        <div class="mb-2">
        <?php
        $location = ['Dar-es-salaam'=>'Dar-es-salaam','Dodoma'=>'Dodoma'];
        echo $form->field($model, 'location')->dropDownList($location, ['prompt' => 'Please select location','class' => 'form-control select2', 'data-toggle' => 'select2']);
        ?>
        </div>
    </div>
</div>



    <div class="form-group">
    <a href="<?= Url::to(['index']) ?>" class="btn btn-sm btn-primary float-start"><i class="mdi mdi-arrow-left-circle-outline text-light"></i> Back</a>
    <?= Html::submitButton('<i class="mdi mdi-check-all text-light"></i> Save', ['class' => 'btn btn-success btn-sm float-end']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
