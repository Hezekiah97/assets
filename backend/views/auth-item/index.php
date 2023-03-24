<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\User;
use yii\grid\ActionColumn;
use backend\models\AuthItem;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auth Items';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index">
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
        <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index'])  ?>">Home</a></li>
            <li class="breadcrumb-item active">User Permisssion</li>
        </ol>
        </div>
            <h4 class="page-title">User Permisssion</h4>
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
                    <a href="<?=  Url::to(['/auth-item/create']) ?>" class="btn btn-sm btn-primary"><i class="mdi mdi-plus-circle-outline me-1"></i> Create permission</a>
                    </div>
                    <div class="col-sm-4">
                    <div class="text-sm-end mb-2">
                        <button onclick="deleteAuthItem()" class="btn btn-sm btn-danger"><i class="mdi mdi-delete text-light me-1"></i> Multiple Delete</button>
                    </div>
                    </div>
                </div>

    <?= GridView::widget([
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager'
        ],
        'options' => [
            'class' => 'table-responsive',
            'id' => 'auth-item-table',
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($data) {
                    return ['value' => $data->name];
                }
            ],
            'name',
            'description:ntext',
            [
                'attribute' => 'created_at',
                'format' => ['html'],
                'value' => function ($data) {
                    return Html::encode(User::getTime($data->created_at));
                },
            ],
            [
                'attribute' => 'updated_at',
                'format' => ['html'],
                'value' => function ($data) {
                    return (User::getTime($data->updated_at)) ? Html::encode(User::getTime($data->updated_at)) : '<span class="badge badge-danger-lighten">No update</span>'; // $data['name'] for array data, e.g. using SqlDataProvider.
                },
            ],
            [
                'attribute' => 'created_by',
                'format' => ['html'],
                'value' => function ($data) {
                    return Html::encode(User::getUsername($data->created_by));

                },
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, AuthItem $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'name' => $model->name]);
                 }
            ],
        ],
    ]); ?>


</div>
        </div></div></div></div>