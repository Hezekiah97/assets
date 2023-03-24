<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \backend\models\PasswordResetRequestForm */

use yii\helpers\Url;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-request-password-reset">
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-lg-5">
                        <div class="card">                            
                            <div class="card-body p-4">                                
                                <div class="text-center w-100 m-auto">
                                    <h4 class="text-dark-50 text-center mt-0 fw-bold">
                                    <i class="mdi mdi-lock-reset text-success"></i>
                                        Reset Password</h4>
                                    <p class="text-muted mb-4">Enter your email address and we'll send you an email with link and instructions to reset your password.</p>
                                </div>
                                <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                                    <div class="mb-3">
                                        <?= $form->field($model, 'email')->textInput(['autofocus' => true,'placeholder'=>'Enter your email']) ?>
                                    </div>
                                    <div class="mb-0 text-center">
                                        <?= Html::submitButton('Send link', ['class' => 'btn btn-sm btn-primary btn-block']) ?>
                                    </div>
                                <?php ActiveForm::end(); ?>
                            </div> <!-- end card-body-->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <?php
                                if (Yii::$app->user->identity) {
                                   ?>
                                <p class="text-muted">Back to <a href="<?=  Url::to(['/user/profile','id'=>Yii::$app->user->identity->id])  ?>" class="text-muted ms-1"><b>Profile</b></a></p>
                                   <?php
                                }else {
                                    ?>
                                   <p class="text-muted">Back to <a href="<?=  Url::to(['/site/login'])  ?>" class="text-muted ms-1"><b>Login</b></a></p>
                    
                                    <?php
                                }
                                ?>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
</div>
