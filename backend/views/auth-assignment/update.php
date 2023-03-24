<?php

use backend\models\User;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthAssignment */

$this->title = 'Update Auth Assignment: ' . $model->item_name;
$this->params['breadcrumbs'][] = ['label' => 'Auth Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->item_name, 'url' => ['view', 'item_name' => $model->item_name, 'user_id' => $model->user_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="auth-assignment-update">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">Update - <?= Html::encode(User::getUsername($model->user_id)) . ' (' .(Html::encode($model->item_name)) .')' ?></h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
