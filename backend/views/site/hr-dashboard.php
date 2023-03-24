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
                            <div class="col-xl-6 col-lg-6">
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
                            <div class="col-xl-6 col-lg-6">                                
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
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                    <div class="row">
                                            <div class="col-md-6">
                                            <h4 class="header-title mb-3">Latest registered assets</h4>
                                            </div>
                                            <div class="col-md-6">
                                            <a href="<?= Url::to(['/assets/index']) ?>" class="btn btn-sm btn-success mb-2 me-1 float-end" id=""><i class='mdi mdi-logout me-1'></i> All assets</a>
                                            </div>
                                            
                                        </div>
                                        <!-- File Import modal-->
                                        <div id="assetsImportModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <div class="modal-body">
                                                            <div class="text-center mb-2">
                                                            <i class="uil-file-upload-alt text-success" style="font-size: 60px;"></i>
                                                            <h4>Upload excel file</h4>
                                                            </div>
                                                            <div id="assetsImportModalContent">

                                                            </div>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        <div class="table-responsive">
                                            <table class="table table-centered table-nowrap table-hover mb-0">
                                                <tbody>
                                                    <?php
                                                    foreach ($assets as $asset) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <span class="text-muted font-13">Asset Code</span>
                                                            <h5 class="font-14 mt-1 fw-normal"><?= Html::encode($asset->barcode) ?></h5>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted font-13">Category</span> <br>
                                                            <?= Html::encode($asset->category0->category_name) ?>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted font-13">Condition</span>
                                                            <h5 class="font-14 mt-1 fw-normal"><?= 
                                                            (Html::encode($asset->condition) == 'Good') ? '<span class="badge badge-success-lighten">Good</span>' : '<span class="badge badge-danger-lighten">Bad</span>';
                                                            ?>
                                                            </h5>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted font-13">Registered on</span>
                                                            <h5 class="font-14 mt-1 fw-normal"><?= Html::encode(User::getTime($asset->RegDate)) ?></h5>
                                                        </td>
                                                        <td class="table-action" style="width: 90px;">
                                                            <a href="<?= Url::to(['assets/view','id'=>$asset->id]) ?>" class="action-icon"> <i class="mdi mdi-eye-outline text-success"></i></a>
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
                        </div> -->
                        <!-- end row

</div>
