<?php

use yii\helpers\Html;
use backend\models\User;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\BookStock */

$this->title = $model->barcode;
$this->params['breadcrumbs'][] = ['label' => 'Book Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-stock-view">


     <!-- // display success message -->
     <?php if (Yii::$app->session->hasFlash('success')) : ?>
        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show mt-3" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong><i class='mdi mdi-check-all'></i> </strong> <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <div class="mt-3">
        <h4><i class="mdi mdi-check-all text-success"></i> <?= Html::encode($model->barcode) ?></h4>
    </div>
    <hr>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to delete this info?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-sm btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'barcode',
            'isbn',
            'inspector',
            [
                'label' => 'Status',
                'format' => ['html'],
                'value' => ($model->status == 1) ? '<span class="badge badge-success-lighten">Available</span>' : '<span class="badge badge-danger-lighten">Not Availabe</span>'
            ],
            [
                'attribute' => 'stock_date',
                'value' => Html::encode(User::getTime($model->stock_date))
            ],
        ],
    ]) ?>

</div>
