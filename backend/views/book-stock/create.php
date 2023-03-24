<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\BookStock */

$this->title = 'Create Book Stock';
$this->params['breadcrumbs'][] = ['label' => 'Book Stocks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-stock-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
