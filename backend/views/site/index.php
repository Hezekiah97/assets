<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\User;
use yii\bootstrap4\Modal;
use backend\models\Assets;

/** @var yii\web\View $this */

$this->title = 'AMS';
?>
<div class="">
                        
                    

                                                 <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                      <!-- < ?= Html::button('Create New Company', ['value' => Url::to(['/categories/create']), 'title' => 'Creating New Company','class' => 'showModalButton btn btn-success btn-md']); ?> -->
                                    </div>
                                    <h4 class="page-title">Home</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-xl-3 col-lg-3">
                                <div class="card">
                                    <div class="card-body">
                                        <i class='mdi mdi-widgets mdi-36px float-end text-success'></i>
                                        <h6 class="text-uppercase mt-0">Assets</h6>
                                        <h2 class="my-2" id="active-users-count"><?= Html::encode($assetTotal) ?></h2>
                                        <a href="<?= Url::to(['/assets/index'])  ?>" class="mb-0 text-muted" style="text-decoration: none;">
                                            <span class="text-success me-2"><span class="mdi mdi-arrow-right-bold"></span></span>
                                            <span class="text-nowrap">See all assets</span>  
                                        </a>
                                    </div> <!-- end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                            <div class="col-xl-3 col-lg-3">                                
                                <div class="card">
                                    <div class="card-body">
                                     <i class='mdi mdi-account-group mdi-36px float-end text-warning'></i>
                                        <h6 class="text-uppercase mt-0">Users</h6>
                                        <h2 class="my-2" id="active-users-count"><?= Html::encode($usersTotal) ?></h2>
                                        <a href="<?= Url::to(['/user/index'])  ?>" class="mb-0 text-muted" style="text-decoration: none;">
                                            <span class="text-warning me-2"><span class="mdi mdi-arrow-right-bold"></span></span>
                                            <span class="text-nowrap">See all users</span>  
                                        </a>
                                    </div> <!-- end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                            <div class="col-xl-3 col-lg-3">                                
                                <div class="card">
                                    <div class="card-body">
                                     <i class='mdi mdi-bookshelf mdi-36px float-end text-primary'></i>
                                        <h6 class="text-uppercase mt-0">Books</h6>
                                        <h2 class="my-2" id="active-users-count"><?= Html::encode($bookTotal) ?></h2>
                                        <a href="<?= Url::to(['/book/index'])  ?>" class="mb-0 text-muted" style="text-decoration: none;">
                                            <span class="text-primary me-2"><span class="mdi mdi-arrow-right-bold"></span></span>
                                            <span class="text-nowrap">See all books</span>  
                                        </a>
                                    </div> <!-- end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                            <div class="col-xl-3 col-lg-3">                                
                                <div class="card">
                                    <div class="card-body">
                                     <i class='mdi mdi-account-group mdi-36px float-end text-danger'></i>
                                        <h6 class="text-uppercase mt-0">Active owners</h6>
                                        <h2 class="my-2" id="active-users-count"><?= Html::encode($activeOnwersTotal) ?></h2>
                                        <a href="<?= Url::to(['/owners/index'])  ?>" class="mb-0 text-muted" style="text-decoration: none;">
                                            <span class="text-danger me-2"><span class="mdi mdi-arrow-right-bold"></span></span>
                                            <span class="text-nowrap">See all onwers</span>  
                                        </a>
                                    </div> <!-- end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                            

                        </div>
                        
                        <!-- <div class="row"> -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title mb-3">Latest registered users</h4>
                                        <div class="table-responsive">
                                            <table class="table table-centered table-nowrap table-hover mb-0">
                                                <tbody>
                                                    <?php
                                                    foreach ($recentUsers as $recentUser) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <span class="text-muted font-13">Full Name</span>
                                                            <h5 class="font-14 mt-1 fw-normal"><?= Html::encode(User::getUsername($recentUser->id)) ?></h5>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted font-13">Status</span> <br>
                                                            <?= ($recentUser->status == 10) ? '<span class="badge badge-success-lighten">Verified</span>':'<span class="badge badge-danger-lighten">Not verifies</span>'  ?>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted font-13">Role</span>
                                                            <h5 class="font-14 mt-1 fw-normal"><?= Html::encode(User::getRole($recentUser->id)) ?></h5>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted font-13">Registered on</span>
                                                            <h5 class="font-14 mt-1 fw-normal"><?= Html::encode(User::getTime($recentUser->created_at)) ?></h5>
                                                        </td>
                                                        <td class="table-action" style="width: 90px;">
                                                            <a href="<?= Url::to(['/user/view','id'=>$recentUser->id]) ?>" class="action-icon"> <i class="mdi mdi-eye-outline text-success"></i></a>
                                                        </td>
                                                    </tr>
                                                    
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div> 

                                    </div> 
                                </div> 
                            </div>
                        </div>
                        <!-- end row-->
</div>
