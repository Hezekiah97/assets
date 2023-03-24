<?php

use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthItem */

$this->title = 'Update Auth Item: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Auth Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'name' => $model->name]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="auth-item-update">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index'])  ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= Url::to(['/auth-item/index'])  ?>">Permissions</a></li>
                    <li class="breadcrumb-item active">Update permission</li>
                </ol>
            </div>
                    <h4 class="page-title">Update permission - (<?= $model->name ?>)</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
