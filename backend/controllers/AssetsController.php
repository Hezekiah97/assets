<?php

namespace backend\controllers;

use Yii;
use Mpdf\Mpdf;
use yii\helpers\Html;
use yii\web\Controller;
use backend\models\User;
use yii\web\UploadedFile;
use backend\models\Assets;
use backend\models\Owners;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\AssetsSearch;
use backend\models\Disposal;
use yii\web\NotFoundHttpException;


/**
 * AssetsController implements the CRUD actions for Assets model.
 */
class AssetsController extends Controller
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
                          'actions' => ['index','create','dispose','update','delete','delete-items','view','assets-report','assets-report-by-condition','assets-report-by-availability','assets-report-by-category'],
                          'roles' => ['Admin','HR'],
                      ],
                      ]
              ] 
            ]
        );
    }

    /**
     * Lists all Assets models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AssetsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Assets model.
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
     * Creates a new Assets model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Assets();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

              if ($model->validate()) {
                # code...
                $asset = new Assets();
                $asset->barcode = $model->barcode;
                $asset->category = $model->category;
                $asset->condition = $model->condition;
                $asset->Extra_note = $model->Extra_note;
                $asset->Asset_Particular = $model->Asset_Particular;
                // $asset->RegBy = Yii::$app->user->identity->id;
                $asset->RegDate = User::setTime();
                $asset->save(false);
              }
              Yii::$app->session->setFlash('success','Conglatulation,asset added successfully!');
              
              return $this->redirect(['index']);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Assets model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $msg = '')
    {
        $model = $this->findModel($id);

        if ($msg) {
          Yii::$app->session->setFlash('error',$msg);
          return $this->render('update', [
            'model' => $model,
          ]);
        }
        
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

           Yii::$app->session->setFlash('success','Conglatulation,asset changed successfully!');

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Assets model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        Owners::deleteAll(['asset_id'=>$id]);
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success','Conglatulation,asset removed successfully!');
        return $this->redirect(['index']);
    }


    public function actionDispose()
    {
        if (Yii::$app->request->isAjax) {
                $id = Html::encode(Yii::$app->request->getBodyParam('id'));
                $comment = Html::encode(Yii::$app->request->getBodyParam('comment'));

                $old_asset = $this->findModel($id);
                $old_asset->status = 2;
                $old_asset->condition = 'Disposed';
                $old_asset->save();


                $disposal = new Disposal();
                $disposal->asset_id = intval($id);
                $disposal->dispose_date = User::setTime();
                $disposal->disposed_by = Yii::$app->user->identity->id;
                $disposal->comment = ($comment) ? $comment : 'No comment';
                $disposal->save(false);


                Yii::$app->session->setFlash('success','Conglatulation,asset disposed successfully!');

        }
    }

    /**
     * Finds the Assets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Assets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Assets::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionDeleteAssets(){
      if (Yii::$app->request->isAjax) {
           $selected = Yii::$app->request->getBodyParam('selected');
           Owners::deleteAll(['asset_id' => $selected]);
           Assets::deleteAll(['id' => $selected]);
           Yii::$app->session->setFlash('success', 'Conglatulation,asset(s) removed successfully!');        
      }
    }
    
    public function actionImport(){

        $model = new Assets();
    
        if (Yii::$app->request->isPost) {
    
          $model->file = UploadedFile::getInstance($model,'file');
          if (!$model->upload()) {
            Yii::$app->session->setFlash('error','Something happened, contact your admin!');
            return $this->redirect(['index']);
          }
        }
    
        $ok = 0;
        if ($model->load(Yii::$app->request->post())) {
          $file = UploadedFile::getInstance($model,'file');
    
          if ($file) {
            $filename = 'upload/Files/Assets/' . $file->name;
            $file->saveAs($filename);
    
            if (in_array($file->extension,array('xls','xlsx','csv'))) {
              $fileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($filename); // the file name automatically determines the type
              $excelReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($fileType);
    
              $phpexcel = $excelReader->Load($filename)->getsheet(0); // load the file and get the first sheet
              $total_Line = $phpexcel->gethighestrow(); // total number of rows
              $total_Column = $phpexcel->gethighestcolumn(); // total number of columns
    
              if (1 < $total_Line) {
                for ($row = 2;$row <= $total_Line;$row++) {
                  $data = [];
                  for ($column = 'A';$column <= $total_Column;$column++) {
                    $data[] = trim($phpexcel->getCell($column.$row));
                  }
    
                  $info = Yii::$app->db->createCommand()->insert('{{%assets}}',
                  [
                    'barcode' => $data[0],
                    'category' => $data[1],
                    'condition' => $data[2],
                    'status' => $data[3],
                    'Asset_Particular' => $data[4],
                    'Extra_note' => $data[5],
                    'RegBy' => $data[6],
                    'RegDate' => $data[7],
    
                  ])->execute();
    
                  if ($info) {
                    $ok = 1;
                  }
                }
              }
    
              if ($ok == 1) {
                Yii::$app->session->setFlash('success','Conglatulation,assets added successfully!');
                return $this->redirect(['index']);
              } else {
                Yii::$app->session->setFlash('error','Something happened, contact your admin!');
                return $this->redirect(['index']);
              }
            }
          }
        } else {
          return $this->renderAjax('import',['model' => $model]);
        }
      }


      
    public function actionAssetsReport(){
      $assets = Assets::find()->all();
      $mpdf = new mPDF();
      $mpdf->WriteHTML($this->renderPartial('assetsReport',['assets'=>$assets]));
      $mpdf->setFooter('{PAGENO}');
      $mpdf->Output('Assets Report.pdf', 'D');
      exit;
  }

  public function actionAssetsReportByCategory($id){
      $assets = Assets::find()->where(['category'=>$id])->all();
      $mpdf = new mPDF();
      $mpdf->WriteHTML($this->renderPartial('assetsReportByCategory',['assets'=>$assets]));
      $mpdf->setFooter('{PAGENO}');
      $mpdf->Output('Assets Report.pdf', 'D');
      exit;
  }

  public function actionAssetsReportByCondition($condition){
      $assets = Assets::find()->where(['condition'=>$condition])->all();
      $mpdf = new mPDF();
      $mpdf->WriteHTML($this->renderPartial('assetsReportByCondition',['assets'=>$assets]));
      $mpdf->setFooter('{PAGENO}');
      $mpdf->Output('Assets Report.pdf', 'D');
      exit;
  }

  public function actionAssetsReportByAvailability($condition){
      $assets = Assets::find()->where(['status'=>$condition])->all();
      $mpdf = new mPDF();
      $mpdf->WriteHTML($this->renderPartial('assetsReportByAvailability',['assets'=>$assets]));
      $mpdf->setFooter('{PAGENO}');
      $mpdf->Output('Assets Report.pdf', 'D');
      exit;
  }

  public function actionAssetsReportByAsset($condition){
      $assets = Assets::find()->where(['condition'=>$condition])->all();
      $mpdf = new mPDF();
      $mpdf->WriteHTML($this->renderPartial('assetsReportByCondition',['assets'=>$assets]));
      $mpdf->setFooter('{PAGENO}');
      $mpdf->Output('Assets Report.pdf', 'D');
      exit;
  }

}
