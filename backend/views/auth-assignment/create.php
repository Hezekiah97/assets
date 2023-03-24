<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthAssignment */

$this->title = 'Create Auth Assignment';
$this->params['breadcrumbs'][] = ['label' => 'Auth Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-assignment-create">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">               
                    Add new assignment</h4>
                </div>
            </div>
        </div>     
    <!-- end page title -->
    <!-- // display success message -->
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong><i class='mdi mdi-check-all'></i> </strong> <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <!-- // display error message -->
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger alert-dismissible bg-success text-white border-0 fade show" role="alert">
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        <strong><i class='mdi mdi-alert-outline'></i>Error! - </strong> <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>
    <!-- end of messages display -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
