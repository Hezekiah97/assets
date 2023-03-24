<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\grid\ActionColumn;
use backend\models\Disposal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DisposalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Disposals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disposal-index">

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
        <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index'])  ?>">Home</a></li>
            <li class="breadcrumb-item active">Assets Disposal</li>
        </ol>
        </div>
            <h4 class="page-title">Assets Disposal</h4>
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

                    </div>
                    <div class="col-sm-4">
                    <div class="text-sm-end mb-2">
                    <a href="" class="btn btn-sm btn-success"><i class="mdi mdi-file-download-outline me-1"></i> Disposal Report</a>
                </div>
                    </div>
                </div>
    <?= GridView::widget([
                'pager' => [
                    'class' => 'yii\bootstrap4\LinkPager'
                ],
                'options' => [
                    'class' => 'table-responsive',
                    'id' => 'assets-disposal-table'
                ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'asset_id',
            [
                'attribute' => 'asset_id',
                'format' => ['html'],
                'value' => function ($data) {
                    return Html::encode($data->asset->barcode);
                },
            ],
            // 'disposed_by',
            [
                'attribute' => 'disposed_by',
                'format' => ['html'],
                'value' => function ($data) {
                    return Html::encode(User::getUsername($data->disposed_by));

                },
            ],
            // 'dispose_date',
            [
                'attribute' => 'dispose_date',
                'format' => ['html'],
                'value' => function ($data) {
                    return Html::encode(User::getTime($data->dispose_date));
                },
            ],
            'comment:ntext',
            // [
            //     'class' => ActionColumn::className(),
            //     'urlCreator' => function ($action, Disposal $model, $key, $index, $column) {
            //         return Url::toRoute([$action, 'id' => $model->id]);
            //      }
            // ],
        ],
    ]); ?>


</div>
