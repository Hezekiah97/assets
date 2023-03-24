<?php


use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Book;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;

// Yii::$app->assetManager->bundles['yii\web\YiiAsset'] = false;

?>
<div class="book-index">

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
                                            <div class="col-md-8 mt-2"> 
                                            <button type="button" value="<?= Url::to(['/book/import']) ?>" class="btn btn-sm btn-success me-1 importBtn" data-bs-toggle="modal" data-bs-target="#importModal" id=""><i class='uil-down-arrow me-1'></i> Import</button>
                                            <a href="<?= Url::to(['/book/export']) ?>" class="btn btn-sm btn-warning me-1 text-light" id=""><i class='uil-upload me-1'></i> Excel</a>
                                            <a href="<?= Url::to(['/book/export-pdf']) ?>" class="btn btn-sm btn-secondary me-1 text-light" id=""><i class='uil-upload me-1'></i> Pdf</a>
                                            </div>
                                            <div class="col-md-4 mt-2">
                                            <div class="text-sm-end mb-2">
                                            <a href="<?=  Url::to(['/book/create']) ?>" class="btn btn-sm btn-primary"><i class="mdi mdi-plus-circle-outline me-1"></i> Add Book</a>
                                            <button onclick="deleteBook('book-table')" class="btn btn-sm btn-danger"><i class="mdi mdi-delete text-light me-1"></i> Multiple Delete</button>
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
                                                            </div>
                                                            <div id="importModalContent">

                                                            </div>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        </div>



    <?= GridView::widget([
        'pager' => [
            'class' => 'yii\bootstrap4\LinkPager'
        ],
        'options' => [
            'class' => 'table-responsive',
            'id' => 'book-table',

        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                // 'class' => 'yii\grid\SerialColumn',
                'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($data) {
                    return ['value' => $data->id];
                }
            ],
            // 'id',
            'item_type',
            'isbn',
            'barcode',           
            'author',
            'title',
            'yop',
            'qty',
            'price',
            'condition',
            //'regDate',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Book $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

</div></div></div></div>
</div>


