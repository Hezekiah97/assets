<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Assets */

$this->title = 'Update Assets: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Assets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="assets-update">

<div class="col-md-12">
            <div class="card shadow-lg mt-3">

                <div class="card-body">
                                        <!-- // display success message -->
    <?php if (Yii::$app->session->hasFlash('error')) : ?>
        <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong><i class='mdi mdi-check-all'></i> </strong> <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>
                    <div class="mb-3">
                    <h4>
                        <i class="mdi mdi-pencil-plus text-primary"></i> <?= Html::encode($this->title) ?>
                        <button id="dispose-asset" value="<?= Html::encode($model->id)  ?>" class="btn btn-danger btn-sm float-end"><i class="mdi mdi-delete text-light me-1"></i> Dispose</button>
                    </h4>
                    
                    </div>
                    <hr>  
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
            </div></div></div>
