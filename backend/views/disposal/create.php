<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Disposal */

$this->title = 'Create Disposal';
$this->params['breadcrumbs'][] = ['label' => 'Disposals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="disposal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
