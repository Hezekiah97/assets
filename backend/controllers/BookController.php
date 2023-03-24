<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\Book;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use backend\models\BookStock;
use backend\models\BookSearch;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Mpdf\Mpdf;


/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
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
                          'allow' => true,
                          'actions' => ['create','index','update','delete','view','import','export','delete-books','export-pdf'],
                          'roles' => ['Admin','PRO'],
                      ],
                  ]
              ]
            ]
        );
    }

    /**
     * Lists all Book models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

  
  /**
   * Displays a single Book model.
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
   * Creates a new Book model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return string|\yii\web\Response
   */
  public function actionCreate()
  {
    $model = new Book();

    if ($this->request->isPost) {
      if ($model->load($this->request->post()) && $model->save()) {
        Yii::$app->session->setFlash('success', 'Conglatulation,book added successfully!');
        return $this->redirect(['index']);
      } else {
        var_dump($model->errors);
        exit;
      }
    } else {
      $model->loadDefaultValues();
    }

    return $this->render('create', [
      'model' => $model,
    ]);
  }

  /**
   * Updates an existing Book model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param int $id ID
   * @return string|\yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
      Yii::$app->session->setFlash('success', 'Conglatulation,book info updated successfully!');
      return $this->redirect(['index']);
    }

    return $this->render('update', [
      'model' => $model,
    ]);
  }

  /**
   * Deletes an existing Book model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param int $id ID
   * @return \yii\web\Response
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    BookStock::deleteAll(['book_id' => $id]);
    $this->findModel($id)->delete();
    Yii::$app->session->setFlash('success', 'Conglatulation,book removed successfully!');
    return $this->redirect(['index']);
  }

  /**
   * Finds the Book model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param int $id ID
   * @return Book the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Book::findOne(['id' => $id])) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }



  public function actionImport()
  {

    $model = new Book();
    $books = Book::find()->all();
    $searchModel = new BookSearch();
    $dataProvider = $searchModel->search($this->request->queryParams);

    if (Yii::$app->request->isPost) {

      $model->file = UploadedFile::getInstance($model, 'file');
      if (!$model->upload()) {
        Yii::$app->session->setFlash('error', 'Something happened, contact your admin!');
        return $this->redirect(['index']);
      }
    }

    $ok = 0;
    if ($model->load(Yii::$app->request->post())) {
      $file = UploadedFile::getInstance($model, 'file');

      if ($file) {
        $filename = 'upload/Files/' . $file->name;
        $file->saveAs($filename);

        if (in_array($file->extension, array('xls', 'xlsx', 'csv'))) {
          $fileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename); // the file name automatically determines the type
          $excelReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($fileType);

          $phpexcel = $excelReader->Load($filename)->getsheet(0); // load the file and get the first sheet
          $total_Line = $phpexcel->gethighestrow(); // total number of rows
          $total_Column = $phpexcel->gethighestcolumn(); // total number of columns

          if (1 < $total_Line) {
            $duplicates = [];
            for ($row = 2; $row <= $total_Line; $row++) {
              $data = [];
              for ($column = 'A'; $column <= $total_Column; $column++) {
                $data[] = trim($phpexcel->getCell($column . $row));
              }
              
              $check_duplicate = Book::findOne(['barcode' => $data[2]]);

              if (!$check_duplicate) {
                $info = Yii::$app->db->createCommand()->insert(
                  '{{%book}}',
                  [
                    'item_type' => $data[0],
                    'isbn' => $data[1],
                    'barcode' => $data[2],
                    'author' => $data[3],
                    'title' => $data[4],
                    'yop' => $data[5],
                    'qty' => $data[6],
                    'price' => $data[7],
                    'condition' => $data[8],
                    'location' => $data[9],
                    // 'id' => $data[10],
                    // 'regDate' => strtotime($data[9]),

                  ]
                )->execute();
              } else {
                array_push($duplicates, $check_duplicate->barcode);
                $info = '';
              }


              if ($info) {
                $ok = 1;
              }
            }
          }

          if ($ok == 1) {
            Yii::$app->session->setFlash('success', 'Conglatulation,books added successfully!');
            return $this->redirect(['index']);
          } else {
            Yii::$app->session->setFlash('error', 'DUPLICATES!, the barcodes from the list below already exists in the database');
            return $this->render('/book/index', ['dataProvider'=>$dataProvider,'searchModel'=>$searchModel,'duplicates' => $duplicates]);
          }
        }
      }
    } else {
      return $this->renderAjax('import', ['model' => $model]);
    }
  }

  public function actionExport(){

    $spreadsheet = new Spreadsheet();
    $spreadsheet->setActiveSheetIndex(0);
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->mergeCells('A1:I1');
    $sheet->mergeCells('A2:I2');
    $style = array(
        'alignment' => array(
            'horizontal' => Alignment::HORIZONTAL_CENTER,
        )
    );
    $sheet->getStyle("A1:I1")->applyFromArray($style);
    $sheet->getStyle("A2:I2")->applyFromArray($style);
    $sheet->getStyle('A1:I1')->getFont()->setBold(true)->setSize(16);
    $sheet->getStyle('A2:I2')->getFont()->setBold(true)->setSize(16);
    $sheet->getStyle('A3:J3')->getFont()->setBold(true);
    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, 1, 'UONGOZI INSTITUTE');
    $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, 2, 'BOOKS COUNT SHEET FOR FY 2021/22');
    $sheet->setCellValue('A3', 'ITEM TYPE');
    $sheet->setCellValue('B3', 'ISBN #');
    $sheet->setCellValue('C3', 'BARCODE');
    $sheet->setCellValue('D3', 'AUTHOR');
    $sheet->setCellValue('E3', 'TITLE');
    $sheet->setCellValue('F3', 'YOP');
    $sheet->setCellValue('G3', 'QTY');
    $sheet->setCellValue('H3', 'PRICE');
    $sheet->setCellValue('I3', 'CONDITION');
    $sheet->setCellValue('J3', 'LOCATION');
    

    $stmt = Yii::$app->db->createCommand('SELECT * FROM book')
    ->queryAll();


      $i = 4;

      foreach ($stmt as $row) {
      $sheet->setCellValue("A".$i, $row["item_type"]);
      $sheet->setCellValueExplicit("B".$i, $row["isbn"], DataType::TYPE_STRING);
      $sheet->setCellValue("C".$i, $row["barcode"]);
      $sheet->setCellValue("D".$i, $row["author"]);
      $sheet->setCellValue("E".$i, $row["title"]);
      $sheet->setCellValue("F".$i, $row["yop"]);
      $sheet->setCellValue("G".$i, $row["qty"]);
      $sheet->setCellValue("H".$i, number_format($row["price"]));
      $sheet->setCellValue("I".$i, $row["condition"]);
      $sheet->setCellValue("J".$i, $row["location"]);
      $i++;
    }

//  // Create a new worksheet called "My Data"
// $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'My Data');

// // Attach the "My Data" worksheet as the first worksheet in the Spreadsheet object
// $spreadsheet->addSheet($myWorkSheet, 0);

    // (E) SAVE FILE
    $writer = new Xlsx($spreadsheet);
    echo "OK";
    $filename = 'books.xlsx';
    ob_end_clean();
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename='. $filename);
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
exit;
  }

  public function actionExportPdf(){
    $books = Book::find()->all();
    $totalPrice = Book::find()->sum('price');
    $mpdf = new mPDF();
    $chunks = explode("chunk", $this->renderPartial('exportPdf',['books'=>$books,'totalPrice'=>$totalPrice]));
    foreach($chunks as $key => $val) {
        $mpdf->WriteHTML($val);
    }
    // $mpdf->WriteHTML($this->renderPartial('exportPdf',['books'=>$books,'totalPrice'=>$totalPrice]));
    $mpdf->setFooter('{PAGENO}');
    $mpdf->Output('Books Report.pdf', 'I');
    exit;
}

  public function actionDeleteBooks(){
    if (Yii::$app->request->isAjax) {
         $selected = Yii::$app->request->getBodyParam('selected');
         BookStock::deleteAll(['book_id' => $selected]);
         Book::deleteAll(['id' => $selected]);
         Yii::$app->session->setFlash('success', 'Conglatulation,book(s) removed successfully!');        
    }
  }
}
