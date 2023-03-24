<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \backend\models\SignupForm */

use yii\helpers\Url;
use yii\bootstrap4\Html;
use backend\models\Group;
use kartik\select2\Select2;
use backend\models\Category;
use yii\helpers\ArrayHelper;
use yii\bootstrap4\ActiveForm;

$this->title = 'Add new user';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <div class="row">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                                <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index'])  ?>">Home</a></li>
                                    <li class="breadcrumb-item"><a href="<?= Url::to(['/user/index'])  ?>">Users</a></li>
                                    <li class="breadcrumb-item active">Add new user</li>
                                </ol>
                                </div>
                    <h4 class="page-title">

                        Add new user</h4>
                </div>

            </div>
        </div>
        <!-- end page title -->
        <div class="col-md-6 offset-md-4">
            <div class="card shadow-lg">
                <div class="p-4">
                    <h4 class="mb-2 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Personal Info</h4>
                    <hr>
                    <?php $form = ActiveForm::begin(['id' => 'form-signup','options' => ['enctype' => 'multipart/form-data']]); ?>
                    <div class="row">
                        <div class="mb-2">
                            <?= $form->field($model, 'firstname')->textInput(['autofocus' => true]) ?>
                        </div>
                        <div class="mb-2">
                            <?= $form->field($model, 'surname')->textInput(['autofocus' => true]) ?>
                        </div>
                        <div class="mb-2">
                            <?= $form->field($model, 'email') ?>
                        </div>
                    </div>
                 
    <div class="form-group mt-2">
        <a href="<?= Url::to(['index']) ?>" class="btn btn-sm btn-primary float-start"><i class="mdi mdi-arrow-left-circle-outline text-light"></i> Back</a>
        <?= Html::submitButton('<i class="mdi mdi-check-all text-light"></i> Save', ['class' => 'btn btn-success btn-sm float-end', 'name' => 'signup-button']) ?>
    </div>

                    <?php ActiveForm::end(); ?>
                    <br>

                </div>
            </div>

        </div>
    </div>
</div>