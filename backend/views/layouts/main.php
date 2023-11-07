<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use backend\models\Categories;
use common\models\User;
use common\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="loading" data-layout="topnav" data-layout-config='{"layoutBoxed":false,"darkMode":false}'>
<?php $this->beginBody() ?>
        <!-- Begin page -->
        <div class="wrapper">

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                    <div class="navbar-custom topnav-navbar">
                        <div class="container-fluid">

                            <!-- LOGO -->
                            <a href="<?= Url::to(['/site/index']) ?>" class="topnav-logo">
                                <span class="topnav-logo-lg">
                                    <!-- <img src="assets_ui/images/uongozi_logo.png" alt="" height="60" width="100"> -->
                                </span>
                            </a>

                            <ul class="list-unstyled topbar-menu float-end mb-0">   
                                <li class="dropdown notification-list">
                                    <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" id="topbar-userdrop" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="account-user-avatar"> 
                                            <img src="assets_ui/images/users/avatar.jpg" alt="user-image" class="rounded-circle">
                                        </span>
                                        <span>
                                            <span class="account-user-name">
                                                <?= Html::encode(User::getUsername(Yii::$app->user->identity->id)) ?>
                                            </span>
                                            <span class="account-position">
                                            <?= Html::encode(User::getRole(Yii::$app->user->identity->id)) ?>
                                            </span>
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown" aria-labelledby="topbar-userdrop">
                                        <!-- item-->
                                        <!-- <div class=" dropdown-header noti-title">
                                            <h6 class="text-overflow m-0">Welcome !</h6>
                                        </div>
     -->
                                        <!-- item-->
                                        <a href="<?= Url::to(['/user/update','id'=>Yii::$app->user->identity->id]) ?>" class="dropdown-item notify-item">
                                            <i class="mdi mdi-account-circle me-1"></i>
                                            <span>Edit Account</span>
                                        </a>
    
                                        <!-- item-->
                                        <a data-method="post" href="<?= Url::to(['/site/logout']) ?>" class="dropdown-item notify-item">
                                            <i class="mdi mdi-logout me-1"></i>
                                            <span>Logout</span>
                                        </a>
    
                                    </div>
                                </li>

                            </ul>
                            <a class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- end Topbar -->

                    <div class="topnav">
                        <div class="container-fluid">
                            <nav class="navbar navbar-dark navbar-expand-lg topnav-menu">     
                                <div class="collapse navbar-collapse push-right" id="topnav-menu-content">
                                    <ul class="navbar-nav">
                                    <?php
                                        if (User::getRole(Yii::$app->user->identity->id) == 'Admin' || User::getRole(Yii::$app->user->identity->id) == 'HR') {
                                    ?>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layouts" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="uil-window me-1"></i>Manage Assets <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layouts">
                                                <a href="<?= Url::to(['/categories/index']) ?>" class="dropdown-item">Categories</a>
                                                <a href="<?= Url::to(['/assets/index']) ?>" class="dropdown-item">Assets</a>
                                                <a href="<?= Url::to(['/owners/index']) ?>" class="dropdown-item">Owners</a>
                                                <a href="<?= Url::to(['/disposal/index']) ?>" class="dropdown-item">Disposal</a>
                                            </div>
                                        </li>

                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layouts" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class=" uil-file-blank me-1"></i>Quick Reports <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layouts">
                                                <a href="<?= Url::to(['/assets/assets-report']) ?>" class="dropdown-item">All assets</a>
                                                <div class="dropdown">
                                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-ecommerce" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        By Category <div class="arrow-down"></div>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="topnav-ecommerce">
                                                        <?php
                                                        $categories = Categories::find()->all();
                                                        foreach ($categories as $category) {
                                                         ?>
                                                         <a href="<?= Url::to(['/assets/assets-report-by-category','id'=>$category->id]) ?>" class="dropdown-item"><?= $category->category_name ?></a>
                                                        <?php
                                                        }

                                                        ?>
                                                    </div>
                                                </div>
                                               <div class="dropdown">
                                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-ecommerce" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        By Condition <div class="arrow-down"></div>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="topnav-ecommerce">
                                                         <a href="<?= Url::to(['/assets/assets-report-by-condition','condition'=>'New']) ?>" class="dropdown-item">New</a>
                                                         <a href="<?= Url::to(['/assets/assets-report-by-condition','condition'=>'Good']) ?>" class="dropdown-item">Good</a>
                                                    </div>
                                                </div>
                                                <div class="dropdown">
                                                    <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-ecommerce" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        By Availability <div class="arrow-down"></div>
                                                    </a>
                                                    <div class="dropdown-menu" aria-labelledby="topnav-ecommerce">
                                                         <a href="<?= Url::to(['/assets/assets-report-by-availability','condition'=>1]) ?>" class="dropdown-item">Available</a>
                                                         <a href="<?= Url::to(['/assets/assets-report-by-availability','condition'=>0]) ?>" class="dropdown-item">Not Available</a>
                                                    </div>
                                                </div>
                                                <a href="<?= Url::to(['/assets/reports']) ?>" class="dropdown-item">Reports page</a>
                                            </div>
                                        </li>
                                        <?php
                                        }
                                        ?>


                                        <?php
                                        if (User::getRole(Yii::$app->user->identity->id) == 'Admin') {
                                        ?>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layouts" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="uil-users-alt me-1"></i>Users Management <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layouts">
                                                <a href="<?= Url::to(['/user/index']) ?>" class="dropdown-item">Manage Users</a>
                                                <a href="<?= Url::to(['/auth-item/index'])  ?>" class="dropdown-item">Manage Permissions</a>
                                                <a href="<?= Url::to(['/auth-assignment/index'])  ?>" class="dropdown-item">Manage Assignments</a>

                                            </div>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layouts" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="uil-book-open me-1"></i>Manage Books  <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layouts">
                                                <a href="<?= Url::to(['/book/index']) ?>" class="dropdown-item">All books</a>
                                                <a href="<?= Url::to(['/book-stock/index']) ?>" class="dropdown-item">Stock Taking</a>
                                            </div>
                                        </li>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (User::getRole(Yii::$app->user->identity->id) == 'PRO') {
                                        ?>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layouts" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="uil-book-open me-1"></i>Manage Books  <div class="arrow-down"></div>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="topnav-layouts">
                                                <a href="<?= Url::to(['/book/index']) ?>" class="dropdown-item">All books</a>
                                                <a href="<?= Url::to(['/book-stock/index']) ?>" class="dropdown-item">Stock Taking</a>
                                            </div>
                                        </li>
                                        <?php
                                        }
                                        ?>

                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>

                    
                    <!-- Start Content-->
                    <div class="container-fluid">

                            <?=  $content ?>

                    </div>
                    <!-- container -->

                </div>
                <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <center>
                                <!-- <script>document.write(new Date().getFullYear())</script> © Uongozi Institute -->
                                </center>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
