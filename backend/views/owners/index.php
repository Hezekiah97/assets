<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\User;
use backend\models\Owners;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\OwnersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Owners';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="owners-index">

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
        <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index'])  ?>">Home</a></li>
            <li class="breadcrumb-item active">Owners</li>
        </ol>
        </div>
            <h4 class="page-title">Owners</h4>
        </div>
    </div>
</div> 
    <!-- // display success message -->
    <?php if (Yii::$app->session->hasFlash('success')) : ?>
        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong><i class='mdi mdi-check-all'></i> </strong> <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-8">
                    <a href="<?=  Url::to(['/owners/create']) ?>" class="btn btn-sm btn-primary"><i class="mdi mdi-plus-circle-outline me-1"></i> Register Owner</a>
                    </div>
                    <div class="col-sm-4">
                    <div class="text-sm-end mb-2">
                    <div class="input-group">
                        <input type="text" id="ownership-report-input" class="form-control" placeholder="Enter asset barcode" aria-label="Barcode">
                        <button class="btn btn-success bt-sm" id="ownership-report-btn" type="button"><i class="mdi mdi-file-download-outline me-1"></i> Get Report</button>
                    </div>
                    </div>
                    </div>
                </div>

    <?= GridView::widget([
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager'
        ],
        'options' => [
            'class' => 'table-responsive',
            'id' => 'owners-table'
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                // 'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($data) {
                //     return ['value' => $data->id];
                // }
            ],
            'name',
            [
                'attribute' => 'asset_id',
                'format' => ['html'],
                'value' => function($data){
                   return Html::encode($data->asset->barcode);
                }
            ],
            [
                'attribute' => 'issued_by',
                'format' => ['html'],
                'value' => function($data){
                   return Html::encode(User::getUsername($data->issuedBy));
                }
            ],
            [
                'attribute' => 'issued_date',
                'format' => ['html'],
                'value' => function ($data) {
                    return Html::encode(User::getTime($data->issued_date));
                },
            ],
            [
                'attribute' => 'returned_status',
                'format' => ['html'],
                'value' => function ($data) {
                    return ($data->returned_status == 0) ? '<span class="badge badge-danger-lighten">Not Returned</span>' :'<span class="badge badge-primary-lighten">Returned</span>';
                },
            ],
            [
                'attribute' => 'returned_date',
                'format' => ['html'],
                'value' => function ($data) {
                    return ($data->returned_status != NULL) ? Html::encode(User::getTime($data->returned_date)) :  '<span class="badge badge-danger-lighten">Not Returned</span>';
                },
            ],
            [
                'attribute' => 'received_by',
                'format' => ['html'],
                'value' => function($data){
                   return ($data->returned_status != NULL) ? Html::encode(User::getUsername($data->receivedBy)) :  '<span class="badge badge-danger-lighten">Not Returned</span>';
                }
            ],
            [
                 'class' => ActionColumn::className(),
                 'template' => '{return}',
                  'buttons' => [
                     'return' => function($url, $model){
                        if($model->returned_status == 0){
                            return Html::a('<i class="mdi mdi-checkbox-marked-circle-outline text-warning mdi-18px"></i>', ['delete', 'id' => $model->id], [
                                
                                'class' => 'owner-confirm',
                                'value' => $model->id
                            ]);
                        }
                     }
                    ],
            ],
        ],
    ]); ?>


</div>
        </div></div></div></div>