<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use backend\models\Assets;
use common\models\User;

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
                            <div class="col-xl-12 col-lg-12">                                
                                <div class="card">
                                    <div class="card-body">
                                     <i class='mdi mdi-bookshelf mdi-36px float-end text-primary'></i>
                                        <h6 class="text-uppercase mt-0">Total Books</h6>
                                        <h2 class="my-2" id="active-users-count"><?= Html::encode($bookTotal) ?></h2>
                                        <a href="<?= Url::to(['/book/index'])  ?>" class="mb-0 text-muted" style="text-decoration: none;">
                                            <span class="text-primary me-2"><span class="mdi mdi-arrow-right-bold"></span></span>
                                            <span class="text-nowrap">See all books</span>  
                                        </a>
                                    </div> <!-- end card-body-->
                                </div>
                                <!--end card-->
                            </div>
                            

                        </div>
                        <!-- <!-- <div class="row"> -->
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                            <h4 class="header-title mb-3">Latest registered books</h4>
                                            </div>
                                            <div class="col-md-6">
                                            <button type="button" value="<?= Url::to(['/book/import']) ?>" class="btn btn-sm btn-success mb-2 me-1 importBtn float-end" data-bs-toggle="modal" data-bs-target="#importModal" id=""><i class='uil-upload me-1'></i> Import</button>
                                            </div>
                                            
                                        </div>
                                        <div id="importModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <div class="modal-body">
                                                            <div class="text-center mb-2">
                                                            <i class="uil-file-upload-alt text-success" style="font-size: 60px;"></i>
                                                            <h4>Upload excel file</h4>
                                                            </div>
                                                            <div id="importModalContent">

                                                            </div>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        <div class="table-responsive">
                                            <table class="table table-centered table-nowrap table-hover mb-0">
                                                <tbody>
                                                    <?php
                                                    foreach ($recentBooks as $recentBook) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <span class="text-muted font-13">Book Code</span>
                                                            <h5 class="font-14 mt-1 fw-normal"><?= Html::encode($recentBook->barcode) ?></h5>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted font-13">Title</span>
                                                            <h5 class="font-14 mt-1 fw-normal"><?= Html::encode($recentBook->title) ?></h5>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted font-13">Author</span>
                                                            <h5 class="font-14 mt-1 fw-normal"><?= Html::encode($recentBook->author) ?></h5>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted font-13">Condition</span> <br>
                                                            <?= ($recentBook->condition == 'Good') ? '<span class="badge badge-success-lighten">Good</span>':'<span class="badge badge-danger-lighten">Bad</span>'  ?>
                                                        </td>

                                                        <td>
                                                            <span class="text-muted font-13">Registered on</span>
                                                            <h5 class="font-14 mt-1 fw-normal"><?= Html::encode(User::getTime($recentBook->regDate)) ?></h5>
                                                        </td>
                                                        <td class="table-action" style="width: 90px;">
                                                            <a href="<?= Url::to(['/book/view','id'=>$recentBook->id]) ?>" class="action-icon"> <i class="mdi mdi-eye-outline text-success"></i></a>
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
