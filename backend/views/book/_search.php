<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\BookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-search">


    <div class="row">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
        <div class="col-md-6">
            <?php echo $form->field($model, 'barcode') ?>
        </div>
        <div class="col-md-6">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary btn-sm float-end']) ?>
        </div>
    <?php ActiveForm::end(); ?>

    </div>


</div>