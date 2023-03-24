<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthAssignment */

$this->title = $model->item_name;
$this->params['breadcrumbs'][] = ['label' => 'Auth Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="auth-assignment-view">
    <div class="mt-3">
        <h4><?= Html::encode(User::getUsername($model->user_id)). ' - ' .(Html::encode($this->title)) ?></h4>
    </div><hr>
    <p>
        <?= Html::a('Update', ['update', 'item_name' => $model->item_name, 'user_id' => $model->user_id], ['class' => 'btn btn-sm btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'item_name' => $model->item_name, 'user_id' => $model->user_id], [
            'class' => 'btn btn-sm btn-danger',
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
            [
                'attribute' => 'user_id',
                'format' => ['html'],
                'value' => function ($data) {
                    return Html::encode(User::getUsername($data->user_id));
                },
            ],
            'item_name',
            [
                'attribute' => 'created_at',
                'format' => ['html'],
                'value' => function ($data) {
                    return (User::getTime($data->created_at)) ? Html::encode(User::getTime($data->created_at)) : '<span class="badge badge-danger-lighten">No update</span>'; // $data['name'] for array data, e.g. using SqlDataProvider.
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
