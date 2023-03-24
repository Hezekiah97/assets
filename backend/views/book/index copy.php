<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Start Content-->
<div class="">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index'])  ?>">Home</a></li>
                        <li class="breadcrumb-item active">Books</li>
                    </ol>
                </div>
                <h4 class="page-title">Books</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <!-- // display success message -->
    <?php if (Yii::$app->session->hasFlash('success')) : ?>
        <div class="alert alert-success alert-dismissible bg-success text-white border-0 fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong><i class='mdi mdi-check-all'></i> </strong> <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>

    <!-- // display error message -->
    <?php if (Yii::$app->session->hasFlash('error')) : ?>
        <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <strong><i class='mdi mdi-alert-outline'></i>Error! - </strong> <?= Yii::$app->session->getFlash('error') ?>
            <hr>
            <?php
            if ($duplicates) {
            ?>
                <ul>
                    <?php
                    foreach ($duplicates as $duplicate) {
                    ?>
                        <li><?= Html::encode($duplicate) ?></li>
                    <?php
                    } ?>
                </ul>
            <?php
            }
            ?>
        </div>
    <?php endif; ?>
    <!-- end of messages display -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-8">
                            <button type="button" value="<?= Url::to(['/book/import']) ?>" class="btn btn-sm btn-success mb-2 me-1 importBtn" data-bs-toggle="modal" data-bs-target="#importModal" id=""><i class='uil-upload me-1'></i> Import</button>
                        </div>
                        <div class="col-sm-4">
                            <div class="text-sm-end">
                                <a href="<?= Url::to(['/book/create']) ?>" class="btn btn-sm btn-primary mb-2"><i class="mdi mdi-plus-circle-outline me-1"></i> Add Book</a>
                            </div>
                        </div><!-- end col-->
                        <!-- File Import modal-->
                        <div id="importModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <div class="modal-body">
                                        <div class="text-center mb-2">
                                            <i class="uil-file-upload-alt text-success" style="font-size: 60px;"></i>
                                            <h4>Upload excel file</h4>
                                            <div class="mt-2 mb-2">
                                                <i class="uil-sync-exclamation text-warning"></i> Yop & Reg Date must be in text format. <i class="uil-sync-exclamation text-warning"></i>
                                            </div>
                                        </div>
                                        <div id="importModalContent">

                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    </div>

                    <div class="table-responsive">
                        <table id="book-excel-table" class="table table-centered table-striped dt-responsive nowrap w-100">

                            <button class="btn btn-danger btn-sm deleteBooksBtn mb-3" onclick="deleteBook()"><i class="mdi mdi-delete text-light"></i> Delete selected books</button>

                            <thead>
                                <tr>
                                    <th style="width: 20px;">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="customCheckAllBooks">
                                            <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th>Item Type</th>
                                    <th>ISBN</th>
                                    <th>Barcode</th>
                                    <th>Author</th>
                                    <th>Tittle</th>
                                    <th>Yop</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Condition</th>
                                    <th>Reg Date</th>
                                    <th style="width: 75px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($books as $book) {
                                ?>
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td class="table-user">
                                            <input type="checkbox" class="form-check-input" id="customCheckBook" value="<?= Html::encode($book->id) ?>">
                                            <?= Html::encode($book->item_type) ?>
                                        </td>
                                        <td>
                                            <?= Html::encode($book->isbn) ?>
                                        </td>
                                        <td>
                                            <?= Html::encode($book->barcode) ?>
                                        </td>
                                        <td>
                                            <?= Html::encode($book->author) ?>
                                        </td>
                                        <td>
                                            <?= Html::encode($book->title) ?>
                                        </td>
                                        <td>
                                            <?= Html::encode($book->yop) ?>
                                        </td>
                                        <td>
                                            <?= Html::encode($book->qty) ?>
                                        </td>
                                        <td>
                                            <?= Html::encode($book->price) ?>
                                        </td>
                                        <td>
                                            <?= Html::encode($book->condition) ?>
                                        </td>
                                        <td>
                                            <?= Html::encode(User::getTime($book->regDate)) ?>
                                        </td>
                                        <!-- <td>
                                                            < ?=                                                           
                                                              ($book->status == 1) ? '<span class="badge badge-success-lighten">Availabe</span>' : '<span class="badge badge-danger-lighten">Not available</span>';
                                                            ?>
                                                        </td>                  -->
                                        <td>
                                            <?= Html::a('<i class="mdi mdi-square-edit-outline text-primary"></i>', ['update', 'id' => $book->id]) ?>
                                            <?= Html::a('<i class="mdi mdi-eye-outline text-success"></i>', ['view', 'id' => $book->id]) ?>
                                            <?= Html::a('<i class="mdi mdi-delete text-danger"></i>', ['delete', 'id' => $book->id], [
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to delete this book?',
                                                    'method' => 'post',
                                                ],
                                            ]) ?>
                                        </td>
                                    </tr>



                                <?php
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div> <!-- container -->


<?php

$script = <<< JS

$(document).ready(function () {
$('#book-excel-table').DataTable( 
    {
    serverSide: true,
    ajax: {
        url: 'index.php?r=book/books',
        type: 'POST'
    },
    dom: 'Bfrtip',
    // "bLengthChange": true,
    buttons: [
       {
            text:'<i class="uil-down-arrow me-1"></i> Export',
            extend: 'excelHtml5',
            className:'btn btn-info btn-sm',
            title: 'UI Book List'
        },
        // {
        //     text:'Export to CSV',
        //     extend: 'csvHtml5',
        //     className:'btn btn-primary btn-sm',
        //     title: 'UONGOZI Executive Education Call for Experts'
        // }
    ]
} );
});




JS;

$this->registerJs($script);




?>