<?php 
	use yii\bootstrap4\ActiveForm;
	use yii\helpers\Html;
?>

<?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data'],'id'=>'upload','class' => 'ps-3 pe-3']);?>

<div class="mb-3">
<?= $form->field($model,'file')->fileInput(['class'=>'form-control']) ?>
</div>

<div class="mb-3 mt-3 text-center">
<button type="button" class="btn btn-danger btn-sm float-start" data-bs-dismiss="modal"><i class="uil-times text-light"></i> Close</button>
<?= Html::submitButton('<i class="mdi mdi-check-all text-light"></i> Import',['class'=>'btn btn-success btn-sm float-end']);?>
</div>

<?php ActiveForm::end();?>