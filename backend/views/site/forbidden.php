<?php

use yii\helpers\Url;

?>
<!-- Start Content-->
<div class="container-fluid">
    <div class="row justify-content-center mt-5">
        <div class="col-lg-4">
            <div class="text-center">
                <img src="assets_ui/images/file-searching.svg" height="90" alt="File not found Image">
                <h1 class="text-error mt-4">403</h1>
                <h4 class="text-uppercase text-danger mt-3">Forbidden</h4>
                <p class="text-muted mt-3">Sorry....You are not allowed to perfom this action!.</p>

                <a class="btn btn-info mt-3" href="<?=  Url::to(['/site/index'])  ?>"><i class="mdi mdi-reply"></i> Return</a>
            </div> <!-- end /.text-center-->
        </div> <!-- end col-->
    </div>
    <!-- end row -->
    
</div> <!-- container -->