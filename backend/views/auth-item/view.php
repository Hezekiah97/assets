<?php

use yii\helpers\Html;
use backend\models\User;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthItem */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="auth-item-view">


        <!-- // display success message -->
        <?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show mt-3" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <strong><i class='mdi mdi-check-all'></i> </strong> <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<!-- // display error message -->
<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show mt-3" role="alert">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <strong><i class='mdi mdi-alert-outline'></i>Error! - </strong> <?= Yii::$app->session->getFlash('error') ?>
</div>
<?php endif; ?>
    <div class="mt-3">
        <h4><?= Html::encode($model->name) ?></h4>
    </div><hr>
    <p>
        <?= Html::a('Update', ['update', 'name' => $model->name], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('Delete', ['delete', 'name' => $model->name], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-sm btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:ntext',
            [
                'attribute' => 'created_at',
                'value' => Html::encode(User::getTime($model->created_at))
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
        ],
    ]) ?>

</div>
