<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Categories */

$this->title = 'Add new category';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categories-create">
    <h4 class="header-title mb-4"><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
