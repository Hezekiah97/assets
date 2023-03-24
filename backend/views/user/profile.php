<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */

$this->title = 'Profile';
?>
                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index'])  ?>">Home</a></li>
                                    <li class="breadcrumb-item"><a href="<?= Url::to(['/user/index'])  ?>">Users</a></li>
                                    <li class="breadcrumb-item active"><?= Html::encode(Yii::$app->user->identity->firstname.' '.Yii::$app->user->identity->surname)  ?></li>
                                </ol>
                                </div>
                                    <h4 class="page-title">My Profile</h4>
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

                        <div class="row">
                            <div class="col-xl-4 col-lg-5">
                                <div class="card">
                                     <div class="card-body">
                                     <h4><i class="mdi mdi-account-edit-outline me-1 text-success"></i> Profile Details</h4><hr>
                                        <center>
                                        <div class="avatar-md">
                                        <span class="avatar-title bg-success rounded-circle">
                                            <?= Html::encode(substr(Yii::$app->user->identity->firstname,0,1).' '.substr(Yii::$app->user->identity->surname,0,1))  ?>
                                        </span>
                                        </div>
                                        <h4 class="mb-0 mt-2">
                                        <?= Html::encode(Yii::$app->user->identity->firstname.' '.Yii::$app->user->identity->surname)  ?>
                                        </h4>
                                        </center>
                                        <!-- <p class="text-muted font-14">Founder</p> -->

                                        <div class="text-start mt-3">
                                            <h4 class="font-13 text-uppercase">About Me :</h4>
                                            <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span class="ms-2">
                                            <?= Html::encode(Yii::$app->user->identity->firstname.' '.Yii::$app->user->identity->surname)  ?>
                                            </span></p>

                                            <p class="text-muted mb-2 font-13"><strong>Mobile :</strong><span class="ms-2">(123)
                                                    123 1234</span></p>

                                            <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span class="ms-2 "> <?= Html::encode(Yii::$app->user->identity->email)  ?></span></p>
                                        </div>
                                    </div> <!-- end card-body -->
                                </div> <!-- end card -->


                            </div> <!-- end col-->

                            <div class="col-xl-8 col-lg-7">
                                <div class="card">
                                    <div class="card-body">
            <h4><i class="mdi mdi-account-circle me-1 text-success"></i> Edit Profile Details</h4><hr>
            <form action="" method="POST">
            <!-- <input type="hidden" name="_csrf-backend" value="< ?=Yii::$app->request->getCsrfToken()?>" /> -->
            <div class="row g-3">
                <div class="mb-2 col-md-4">
                <label for="simpleinput" class="form-label">Firstname</label>
                <input type="text" id="user-firstname" class="form-control" value="<?=  $model->firstname ?>">
                </div>
                <div class="mb-2 col-md-4">
                <label for="simpleinput" class="form-label">Surname</label>
                <input type="text" id="user-surname" class="form-control" value="<?=  $model->surname ?>">
                </div>
                <div class="mb-2 col-md-4">
                <label for="simpleinput" class="form-label">Email</label>
                <input type="text" id="user-othername" class="form-control" value="<?=  $model->email ?>">
                </div>
            </div>
            <div class="row mt-3">
            <div class="mb-2 col-md-6">
                <a href="<?= Url::to(['site/request-password-reset'])  ?>" class="btn btn-sm btn-primary btn-block">Click here to change your password.</a>
            </div>
            </div>
            <div class="row g-3">
                <input type="hidden" id="update-user-id" value="<?= $model->id ?>">
            </div>
                <div class="form-group mt-5">
                    <button class="btn btn-sm btn-primary user-profile-update-btn">Save</button>
                    <a style="text-decoration: none;" href="<?= Url::to(['/site/index']) ?>" class="btn btn-sm btn-success">Back</a>
                </div>
            </form>
            <!-- end settings content-->
            </div> <!-- end card body -->
            </div> <!-- end card -->
            </div> <!-- end col -->
            </div>
                <!-- end row-->

            </div>
            <!-- container -->



<?php

$script = <<< JS

$(document).ready(function () {
    $('.user-profile-update-btn').click(function (e) {
        e.preventDefault();
        var firstname = $('#user-firstname').val();
        var surname = $('#user-surname').val();
        var othername = $('#user-othername').val();
        var tittle = $('#user-tittle').val();
        var email = $('#user-email').val();
        var bio =$('#user-bio').val();
        var id = $('#update-user-id').val();
        // alert(id)
        $.ajax({
            type: "POST",
            url: "index.php?r=user/update",
            data: {
                '_csrf-backend':yii.getCsrfToken(),
                firstname:firstname,surname:surname,othername:othername,tittle:tittle,email:email,bio:bio,id:id},
            success: function (response) {
               window.location = 'index.php?r=user/profile&id='+id; 
            }
        });
        
    });
});




JS;

$this->registerJs($script);




?>