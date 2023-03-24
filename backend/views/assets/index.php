<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Assets;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AssetsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Assets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assets-index">

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
        <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index'])  ?>">Home</a></li>
            <li class="breadcrumb-item active">Assets</li>
        </ol>
        </div>
            <h4 class="page-title">Assets</h4>
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
                    <a href="<?=  Url::to(['/assets/create']) ?>" class="btn btn-sm btn-primary"><i class="mdi mdi-plus-circle-outline me-1"></i> Register asset</a>
                    </div>
                    <div class="col-sm-4">
                    <div class="text-sm-end mb-2">
                        <button onclick="deleteAssets()" class="btn btn-sm btn-danger"><i class="mdi mdi-delete text-light me-1"></i> Multiple Delete</button>
                    </div>
                    </div>
                </div>

    <?= GridView::widget([
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager'
        ],
        'options' => [
            'class' => 'table-responsive',
            'id' => 'assets-table'
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($data) {
                    return ['value' => $data->id];
                }
            ],
            // 'id',
            'barcode',
            [
                'attribute' => 'category',
                'format' => ['html'],
                'value' => function($data){
                   return Html::encode($data->category0->category_name);
                }
            ],
            'condition',
            [
                'attribute' => 'status',
                'format' => ['html'],
                'value' => function($data){
                    if ($data->status == 1) {
                       return '<span class="badge badge-success-lighten">Available</span>';
                    }
                    elseif ($data->status == 2) {
                       return '<span class="badge badge-danger-lighten">Disposed</span>';
                    }
                    else{
                        return '<span class="badge badge-warning-lighten">Assigned</span>';
                    }
                //    return ($data->status == 1) ? '<span class="badge badge-success-lighten">Available</span>' : '<span class="badge badge-danger-lighten">Not Availabe</span>';
                }
            ],
            'Asset_Particular:ntext',
            'Extra_note:ntext',
            //'RegDate',
            [
                'class' => ActionColumn::className(),
                'template' => '{update} {delete} {view}',
                // 'urlCreator' => function ($action, Assets $model, $key, $index, $column) {
                //     return Url::toRoute([$action, 'id' => $model->id]);
                //  },
                 'buttons' => [
                    'delete' => function($url, $model){
                        return Html::a('<i class="mdi mdi-delete text-danger"></i>', ['delete', 'id' => $model->id], [
                            'class' => '',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this asset, this will also erase all owners for this particular asset, are you sure?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>


</div>
        </div></div></div></div>