<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Url;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

$this->title = 'Login';
?>
<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-lg-5">
                        <div class="card">
                            <div class="card-body p-4">
                             <!-- // display success message -->
                            <?php if (Yii::$app->session->hasFlash('success')): ?>
                                <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                <strong><i class='mdi mdi-check-all'></i> </strong> <?= Yii::$app->session->getFlash('success') ?>
                                </div>
                            <?php endif; ?>
                                <div class="text-center w-75 m-auto">
                                    <!-- <h5>UI-OPS</h5> -->
                                    <h4 class="text-dark-50 text-center pb-0 fw-bold"><i class="mdi mdi-lock-reset text-success"></i> Sign In</h4>
                                </div>

                       
                                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                                    <div class="form-floating mb-3">                                      
                                    <?= $form->field($model, 'email')->textInput(['autofocus' => true,'id'=>'emailaddress','placeholder'=>'Enter your email']) ?>
                                    </div>
 
                                    <div class="mb-3">
                                    <?= $form->field($model, 'password')->passwordInput(['id'=>'password','placeholder'=>'Enter your password']) ?>                                           
                                    </div>

                                    <div class="mb-3 mb-3">
                                        <div class="form-check">
                                          <?= $form->field($model, 'rememberMe')->checkbox(['class'=>'form-check-input','id'=>'checkbox-signin']) ?>
                                        </div>
                                    </div>

                                    <div class="mb-3 text-center d-grid">
                                        <?= Html::submitButton('<i class="mdi mdi-arrow-right-circle-outline text-light"></i> Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                                    </div>
                                    <div class="col">
                                    Forgot password? <a href="<?= Url::to(['site/request-password-reset'])  ?>" class="">Click here to reset.</a><br>
                                    <!-- No account? <a href="< ?= Url::to(['/user/signup'])  ?>" class="">REGISTER HERE.</a> -->
                                    </div>
                             
                                <?php ActiveForm::end(); ?>
                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->
                        <!-- end row -->
                            <!-- Logo -->
                            <div class="text-center">
                                    <!-- <span><img src="< ?= Url::base(true)."/assets_ui/images/logo.png"; ?>" alt="" height="150" width="150"></span> -->
                            </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <div class="text-center">
        <!-- <script>document.write(new Date().getFullYear())</script> @ UONGOZI INSTITUTE -->
        </div>
