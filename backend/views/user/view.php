<?php

use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->firstname.' '.$model->surname;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

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
        <h4><?= Html::encode($model->firstname.' '.$model->surname) ?></h4>
    </div><hr>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'firstname',
            'surname',
            'email:email',
            [
                'label' => 'Role',
                'format' => ['html'],
                'value' => $model->getAuthAssignments()
            ],
            [
                'attribute' => 'created_at',
                'value' => Html::encode(User::getTime($model->created_at))
            ],
            [
                'attribute' => 'last_login',
                'format' => ['html'],
                'value' => ($model->last_login > 0) ? Html::encode(User::getTime($model->last_login)) : '<span class="badge badge-warning-lighten">New</span>'
            ],
        ],
    ]) ?>

</div>
