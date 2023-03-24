<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Categories */

$this->title = 'Update Category: ' . $model->category_name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="categories-update">

    <h4 class="header-title mb-4"><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
