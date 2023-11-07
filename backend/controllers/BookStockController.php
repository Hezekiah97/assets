<?php

namespace backend\controllers;

use Yii;
use Mpdf\Mpdf;
use common\models\User;
use yii\web\Controller;
use backend\models\Book;
use backend\models\BookSearch;
use yii\filters\VerbFilter;
use backend\models\BookStock;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use backend\models\BookStockSearch;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;


/**
 * BookStockController implements the CRUD actions for BookStock model.
 */
class BookStockController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access' => [
                  'class' => AccessControl::className(),
                  'rules' => [
                      [
                          'actions' => ['index','export-all','report','set-page-size','delete-stock-books','create'],
                          'roles'=>['Admin'],
                          'allow' => true,
                      ],
                  ],
              ],
            ]
        );
    }

    /**
     * Lists all BookStock models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BookStockSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single BookStock model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BookStock model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new BookStock();

        if ($this->request->isPost) {
            $model->item_type = 'Book';
            // $model->stock_date = 
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BookStock model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BookStock model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BookStock model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return BookStock the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BookStock::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDeleteStockBooks(){
        if (Yii::$app->request->isAjax) {
             $selected = Yii::$app->request->getBodyParam('selected');
             BookStock::deleteAll(['id' => $selected]);
             Yii::$app->session->setFlash('success', 'Conglatulation,book(s) removed successfully!');        
        }
    }

    public function actionExportAll($from_date,$to_date,$status){
        $from_date = strtotime(User::setDate($from_date));
        $to_date = strtotime(User::setDate($to_date));

        $spreadsheet = new Spreadsheet();
        
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        // $sheet->getHeaderFooter()->setOddHeader('&CBOOK LIST');
        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', 'TYPE #');
        $sheet->setCellValue('B1', 'ISBN #');
        $sheet->setCellValue('C1', 'BARCODE');
        $sheet->setCellValue('D1', 'AUTHOR');
        $sheet->setCellValue('E1', 'TITLE');
        $sheet->setCellValue('F1', 'YOP');
        $sheet->setCellValue('G1', 'QTY');
        $sheet->setCellValue('H1', 'PRICE');
        $sheet->setCellValue('I1', 'CONDITION');
        // $sheet->setCellValue('I1', 'STATUS');
        $sheet->setCellValue('J1', 'LOCATION');
        $sheet->setCellValue('K1', 'ID');
        
    
        // $stmt = Yii::$app->db->createCommand('SELECT b.isbn,b.author,b.title,b.yop,b.qty,b.item_type,b.condition,b.price,b.barcode,bs.status,b.location,bs.book_id FROM `book` b LEFT JOIN book_stock bs ON b.id = bs.book_id WHERE bs.status =:status AND bs.stock_date=:stock_date GROUP BY b.barcode')
        $stmt = Yii::$app->db->createCommand('SELECT b.isbn,b.author,b.title,b.yop,b.qty,b.item_type,b.condition,b.price,b.barcode,bs.status,b.location,bs.book_id FROM `book` b LEFT JOIN book_stock bs ON b.id = bs.book_id WHERE bs.stock_date BETWEEN :from_date AND :to_date AND bs.status =:status GROUP BY b.barcode')
        ->bindValue(':status',$status)
        ->bindValue(':from_date',$from_date)
        ->bindValue(':to_date',$to_date)
        ->queryAll();
    
    
        // var_dump($stmt);
        // exit;
          $i = 2;
    
          foreach ($stmt as $row) {
          $sheet->setCellValue("A".$i, $row["item_type"]);
          $sheet->setCellValueExplicit("B".$i, $row["isbn"], DataType::TYPE_STRING);
          $sheet->setCellValue("C".$i, $row["barcode"]);
          $sheet->setCellValue("D".$i, $row["author"]);
          $sheet->setCellValue("E".$i, $row["title"]);
          $sheet->setCellValue("F".$i, $row["yop"]);
          $sheet->setCellValue("G".$i, $row["qty"]);
          $sheet->setCellValue("H".$i, $row["price"]);
          $sheet->setCellValue("I".$i, $row["condition"]);
        //   $sheet->setCellValue("I".$i, ($row["status"]) ? 'Available' : 'Not Available');
          $sheet->setCellValue("J".$i, $row["location"]);
          $sheet->setCellValue("K".$i, $row["book_id"]);
          $i++;
        }
    
        $sheet->getHeaderFooter()->setOddHeader('&C&BBOOK STOCK TAKING');
    
        // (E) SAVE FILE
        $writer = new Xlsx($spreadsheet);
        $filename = 'BOOK STOCK REPORT.xlsx';
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='. $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    
    }

    public function actionExport($status,$location){
        $spreadsheet = new Spreadsheet();
        
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        // $sheet->getHeaderFooter()->setOddHeader('&CBOOK LIST');
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', 'TYPE #');
        $sheet->setCellValue('B1', 'ISBN #');
        $sheet->setCellValue('C1', 'BARCODE');
        $sheet->setCellValue('D1', 'AUTHOR');
        $sheet->setCellValue('E1', 'TITLE');
        $sheet->setCellValue('F1', 'YOP');
        $sheet->setCellValue('G1', 'CONDITION');
        $sheet->setCellValue('H1', 'PRICE');
        // $sheet->setCellValue('I1', 'STATUS');
        $sheet->setCellValue('I1', 'LOCATION');
        
    

        if ($status == 'NULL') {
            $stmt = Yii::$app->db->createCommand('SELECT b.isbn,b.author,b.title,b.yop,b.item_type,b.condition,b.price,b.barcode,bs.status,b.location FROM `book` b LEFT JOIN book_stock bs ON b.id = bs.book_id WHERE bs.status IS NULL AND b.location =:location GROUP BY b.barcode')
            ->bindValue(':location',$location)
            ->queryAll();
        }else {
            $stmt = Yii::$app->db->createCommand('SELECT b.isbn,b.author,b.title,b.yop,b.item_type,b.condition,b.price,b.barcode,bs.status,b.location FROM `book` b LEFT JOIN book_stock bs ON b.id = bs.book_id WHERE bs.status =:status AND b.location =:location GROUP BY b.barcode')
            ->bindValue(':status',$status)
            ->bindValue(':location',$location)
            ->queryAll();
        }

        // $stmt = Yii::$app->db->createCommand('SELECT b.isbn,b.author,b.title,b.yop,b.item_type,b.condition,b.price,b.barcode,bs.status,b.location FROM `book` b LEFT JOIN book_stock bs ON b.id = bs.book_id WHERE bs.status =:status AND b.location =:location GROUP BY b.barcode')
        // ->bindValue(':status',$status)
        // ->bindValue(':location',$location)
        // ->queryAll();
    
    
 
          $i = 2;
    
          foreach ($stmt as $row) {
          $sheet->setCellValue("A".$i, $row["item_type"]);
          $sheet->setCellValueExplicit("B".$i, $row["isbn"], DataType::TYPE_STRING);
          $sheet->setCellValue("C".$i, $row["barcode"]);
          $sheet->setCellValue("D".$i, $row["author"]);
          $sheet->setCellValue("E".$i, $row["title"]);
          $sheet->setCellValue("F".$i, $row["yop"]);
          $sheet->setCellValue("G".$i, $row["condition"]);
          $sheet->setCellValue("H".$i, $row["price"]);
        //   $sheet->setCellValue("I".$i, ($row["status"]) ? 'Available' : 'Not Available');
          $sheet->setCellValue("I".$i, $row["location"]);
          $i++;
        }
    
        $sheet->getHeaderFooter()->setOddHeader('&C&BBOOK STOCK TAKING');
    
        // (E) SAVE FILE
        $writer = new Xlsx($spreadsheet);
        $filename = 'books-stock.xlsx';
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='. $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    
    }

    public function actionExportAvailableDodoma(){
        $spreadsheet = new Spreadsheet();
        
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        // $sheet->getHeaderFooter()->setOddHeader('&CBOOK LIST');
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', 'TYPE #');
        $sheet->setCellValue('B1', 'ISBN #');
        $sheet->setCellValue('C1', 'BARCODE');
        $sheet->setCellValue('D1', 'AUTHOR');
        $sheet->setCellValue('E1', 'TITLE');
        $sheet->setCellValue('F1', 'YOP');
        $sheet->setCellValue('G1', 'CONDITION');
        $sheet->setCellValue('H1', 'PRICE');
        // $sheet->setCellValue('I1', 'STATUS');
        $sheet->setCellValue('I1', 'LOCATION');
        
    
        $stmt = Yii::$app->db->createCommand('SELECT b.isbn,b.author,b.title,b.yop,b.item_type,b.condition,b.price,b.barcode,bs.status,b.location FROM `book` b LEFT JOIN book_stock bs ON b.id = bs.book_id WHERE bs.status = 1 AND b.location = "Dodoma" GROUP BY b.barcode')
        ->queryAll();
    
    
 
          $i = 2;
    
          foreach ($stmt as $row) {
          $sheet->setCellValue("A".$i, $row["item_type"]);
          $sheet->setCellValueExplicit("B".$i, $row["isbn"], DataType::TYPE_STRING);
          $sheet->setCellValue("C".$i, $row["barcode"]);
          $sheet->setCellValue("D".$i, $row["author"]);
          $sheet->setCellValue("E".$i, $row["title"]);
          $sheet->setCellValue("F".$i, $row["yop"]);
          $sheet->setCellValue("G".$i, $row["condition"]);
          $sheet->setCellValue("H".$i, $row["price"]);
        //   $sheet->setCellValue("I".$i, ($row["status"]) ? 'Available' : 'Not Available');
          $sheet->setCellValue("J".$i, $row["location"]);
          $i++;
        }
    
        $sheet->getHeaderFooter()->setOddHeader('&C&BBOOK STOCK TAKING');
    
        // (E) SAVE FILE
        $writer = new Xlsx($spreadsheet);
        $filename = 'books-stock.xlsx';
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='. $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    
    }


    public function actionExportNotAvailable(){
        $spreadsheet = new Spreadsheet();
        
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        // $sheet->getHeaderFooter()->setOddHeader('&CBOOK LIST');
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', 'TYPE #');
        $sheet->setCellValue('B1', 'ISBN #');
        $sheet->setCellValue('C1', 'BARCODE');
        $sheet->setCellValue('D1', 'AUTHOR');
        $sheet->setCellValue('E1', 'TITLE');
        $sheet->setCellValue('F1', 'YOP');
        $sheet->setCellValue('G1', 'CONDITION');
        $sheet->setCellValue('H1', 'PRICE');
        // $sheet->setCellValue('I1', 'STATUS');
        $sheet->setCellValue('I1', 'LOCATION');
        
    
        $stmt = Yii::$app->db->createCommand('SELECT b.isbn,b.author,b.title,b.yop,b.item_type,b.condition,b.price,b.barcode,bs.status,b.location FROM `book` b LEFT JOIN book_stock bs ON b.id = bs.book_id WHERE bs.status IS NULL GROUP BY b.barcode')
        ->queryAll();
    
    
 
          $i = 2;
    
          foreach ($stmt as $row) {
          $sheet->setCellValue("A".$i, $row["item_type"]);
          $sheet->setCellValueExplicit("B".$i, $row["isbn"], DataType::TYPE_STRING);
          $sheet->setCellValue("C".$i, $row["barcode"]);
          $sheet->setCellValue("D".$i, $row["author"]);
          $sheet->setCellValue("E".$i, $row["title"]);
          $sheet->setCellValue("F".$i, $row["yop"]);
          $sheet->setCellValue("G".$i, $row["condition"]);
          $sheet->setCellValue("H".$i, $row["price"]);
        //   $sheet->setCellValue("I".$i, ($row["status"]) ? 'Available' : 'Not Available');
          $sheet->setCellValue("I".$i, $row["location"]);
          $i++;
        }
    
        $sheet->getHeaderFooter()->setOddHeader('&C&BBOOK STOCK TAKING');
    
        // (E) SAVE FILE
        $writer = new Xlsx($spreadsheet);
        $filename = 'books-stock.xlsx';
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='. $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    
    }


    public function actionReport(){
      if (Yii::$app->request->isAjax) {

            $fromDate = strtotime(User::setDate(Yii::$app->request->getBodyParam('fromDate')));
            $toDate = strtotime(User::setDate(Yii::$app->request->getBodyParam('toDate')));
            $condition = Yii::$app->request->getBodyParam('condition');

            // if ($condition == 'all-available') {
            //    return $this->actionExportAll($fromDate);
            //    exit;
            // } else {
            //   # code...
            // }
            
      }
    }


    public function actionSetPageSize(){
      if (Yii::$app->request->isAjax) {
        $size = Yii::$app->request->getBodyParam('pageSize');
        $model = new BookStockSearch();
        $model->myPageSize = $size;
      }
    }

}
