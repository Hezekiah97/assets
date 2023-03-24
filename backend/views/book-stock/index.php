<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\grid\ActionColumn;
use backend\models\BookStock;
use yii\bootstrap4\ActiveForm;
use backend\models\BookStockSearch;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BookStockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Book Stocks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-stock-index">
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
        <div class="page-title-right">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="<?= Url::to(['/site/index'])  ?>">Home</a></li>
            <li class="breadcrumb-item active">Books Stock</li>
        </ol>
        </div>
            <h4 class="page-title">Books Stock</h4>
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

    <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm-4">                      
                        <!-- <a href="< ?= Url::to(['/book-stock/export']) ?>" class="btn btn-sm btn-warning me-1 text-light" id=""><i class='uil-upload me-1'></i> Export</a> -->
                        <!-- <div class="dropdown btn-group">
                            <button class="btn btn-sm btn-primary me-1 text-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Export Report
                            </button>
                            <div class="dropdown-menu dropdown-menu-animated">
                                <a class="dropdown-item text-primary" href="<?= Url::to(['/book-stock/export-all']) ?>">All (AVAILABLE)</a>
                                <a class="dropdown-item text-primary" href="<?= Url::to(['/book-stock/export','status'=>1,'location'=>'Dar-es-salaam']) ?>">Available (DAR)</a>
                                <a class="dropdown-item text-primary" href="<?= Url::to(['/book-stock/export','status'=>1,'location'=>'Dodoma']) ?>">Available (DODOMA)</a>
                                <a class="dropdown-item text-danger" href="<?= Url::to(['/book-stock/export','status'=>'NULL','location'=>'Dar-es-salaam']) ?>">Not Available (DAR)</a>
                                <a class="dropdown-item text-danger" href="<?= Url::to(['/book-stock/export','status'=>'NULL','location'=>'Dodoma']) ?>">Not Available (DODOMA)</a>
                            </div>
                        </div> -->
                          <button id="show-book-stock-report-div" class="btn btn-sm btn-primary"><i class="uil-file-blank me-1"></i> Fetch Reports</button>
                          <div id="book-stock-report-div" class="">
                          <div class="mb-2">
                          <label for="">From</label>
                          <input type="date" class="form-control" id="stock-report-from-date">
                          </div>
                          <div class="mb-2">
                          <label for="">To</label>
                          <input type="date" class="form-control" id="stock-report-to-date">
                          </div>
                          <div class="mb-2">
                          <label for="">Condition</label>
                          <select class="form-control select2" data-toggle="select2" id="stock-report-condition">
                              <option>Select</option>
                              <option value="all-available">All (AVAILABLE)</option>
                              <option value="available-dar">Available (DAR)</option>
                              <option value="available-dodoma">Available (DODOMA)</option>
                              <option value="not-available-dar">Not Available (DAR)</option>
                              <option value="not-available-dodoma">Not Available (DODOMA)</option>
                          </select>
                          </div>
                          <div class="">
                          <button class="btn btn-sm btn-primary" id="stock-report-button">Get Report</button>
                          </div>
                          </div>
                    </div>
                    <div class="col-sm-8">
                    <div class="float-end mb-2"><button onclick="deleteBook('book-stock-table')" class="btn btn-sm btn-danger"><i class="mdi mdi-delete text-light me-1"></i> Multiple Delete</button>
                    </div>
                    </div>
                </div>
                <?= GridView::widget([
                    // 'model' => $model,
                    'pager' => [
                        'class' => 'yii\bootstrap4\LinkPager'
                    ],
                    'options' => [
                        'class' => 'table-responsive',
                        'id' => 'book-stock-table',
                    ],
                    'dataProvider' => $dataProvider,
                    'layout'=>'{summary}'.Html::activeDropDownList($searchModel, 'myPageSize', [1=>1,3=>3,10 => 10, 20 => 20, 50 => 50, 100 => 100],['id'=>'myPageSize',
                    'type'=>"button", 'class'=>"btn btn-light btn-sm dropdown-toggle mb-3", 'data-bs-toggle'=>"dropdown" ,'aria-haspopup'=>"true", 'aria-expanded'=>"false"
                    ])."{items}<br/>{pager}",
                    'filterModel' => $searchModel,
                    'filterSelector' => '#myPageSize',
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function($data) {
                                return ['value' => $data->id];
                            }
                        ],
                        // 'id',
                        'barcode',
                        'isbn',
                        'inspector',
                        // 'status',
                        [
                            'attribute' => 'status',
                            'format' => ['html'],
                            'value' => function ($data) {
                                return ($data->status == 1) ? '<span class="badge badge-success-lighten">Available</span>' : '<span class="badge badge-danger-lighten">Not available</span>'; // $data['name'] for array data, e.g. using SqlDataProvider.
                            },
                        ],
                        //'count',
                        //'book_id',
                        [
                          'attribute' => 'stock_date',
                          'value' => function($data) {
                            return Html::encode(User::getTime($data->stock_date));
                            // return Html::encode(date('d-m-Y',$data->stock_date));
                          }
                        ],
                        [
                            'class' => ActionColumn::className(),
                            'urlCreator' => function ($action, BookStock $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            },
                            'template' => '{view} {delete}',
                        ],
                    ],
                ]); ?>

</div></div></div></div>
</div>
