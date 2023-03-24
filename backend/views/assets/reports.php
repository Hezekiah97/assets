<?php

use yii\helpers\Url;
?>
                    <!-- Start Content-->
                    <div class="container">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index']) ?>">Home</a></li>
                                            <li class="breadcrumb-item active">Reports page</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Reports page</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-xl-8">
                                                <div class="row gy-2 gx-2 align-items-center justify-content-xl-start justify-content-between">
                                                    <div class="col-auto">
                                                        <div class="d-flex align-items-center">
                                                            <select class="form-control select2" id="reportSelect">
                                                                <option selected="">Search by...</option>
                                                                <option value="1">Asset code</option>
                                                                <option value="2">Owner</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <label for="inputPassword2" class="visually-hidden">Search</label>
                                                        <input type="search" class="form-control" id="inputSearch" placeholder="Search...">
                                                    </div>
                                                    <div class="col-auto">
                                                    <button type="button" class="btn btn-primary"><i class="uil uil-search"></i> Search</button>
                                                    </div>
                                                </div>                            
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="text-xl-end mt-xl-0 mt-2">
                                                    <button type="button" class="btn btn-success mb-2 me-2"><i class='uil-export me-1'></i> Export to pdf</button>
                                                </div>
                                            </div><!-- end col-->
                                        </div>
                                        <hr>
                                        <div class="reportView">

                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row --> 
                        
                    </div> <!-- container -->


                    