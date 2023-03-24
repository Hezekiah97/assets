<?php

namespace backend\controllers;

use Yii;
use Mpdf\Mpdf;
use yii\helpers\Html;
use yii\web\Controller;
use backend\models\User;
use backend\models\Assets;
use backend\models\Owners;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\OwnersSearch;
use yii\web\NotFoundHttpException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;


/**
 * OwnersController implements the CRUD actions for Owners model.
 */
class OwnersController extends Controller
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
                // 'access' => [
                //     'class' => AccessControl::className(),
                //     'rules' => [
                //         [
                //             'allow' => true,
                //             'actions' => ['index','create','update','delete','delete-items','view','return-asset'],
                //             'roles' => ['Admin','HR'],
                //         ],
                //         ]
                //   ] 
            ]
        );
        
    }

    /**
     * Lists all Owners models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OwnersSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Owners model.
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
     * Creates a new Owners model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Owners();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {              
                $owner = new Owners();
                $owner->name = $model->name;
                $owner->asset_id = $model->asset_id;
                $owner->issued_by = Yii::$app->user->identity->id;
                $owner->issued_date = User::setTime();
                $owner->save();
                $asset = Assets::findOne($model->asset_id);
                $asset->status = 0;
                $asset->save();
                Yii::$app->session->setFlash('success','Conglatulation,owner added successfully!');
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
     * Updates an existing Owners model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            
            $old_owner = $this->findModel($id);
            $old_owner->returned_status = 1;
            $old_owner->returned_date = User::setTime();
            $old_owner->received_by = Yii::$app->user->identity->id;
            $old_owner->save();
            
            //register new owner
            $owner = new Owners();
            $owner->name = $model->name;
            $owner->asset_id = $model->asset_id;
            $owner->issued_by = Yii::$app->user->identity->id;
            $owner->issued_date = User::setTime();
            $owner->save();
            $asset = Assets::findOne($owner->asset_id);
            $asset->status = 0;
            $asset->save();

            Yii::$app->session->setFlash('success','Conglatulation,owner updated successfully!');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Owners model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        // $this->findModel($id)->delete();
        $old_owner = $this->findModel($id);
        $old_owner->returned_status = 1;
        $old_owner->returned_date = User::setTime();
        $old_owner->received_by = Yii::$app->user->identity->id;
        $old_owner->save();

        $asset = Assets::findOne($old_owner->asset_id);
        $asset->status = 1;
        $asset->save();
        Yii::$app->session->setFlash('success','Conglatulation,asset returned successfully!');
        return $this->redirect(['index']);
    }

    public function actionReturnAsset()
    {
        if (Yii::$app->request->isAjax) {
                $id = Html::encode(Yii::$app->request->getBodyParam('id'));
                $comment = Html::encode(Yii::$app->request->getBodyParam('comment'));

                $old_owner = $this->findModel($id);
                $old_owner->returned_status = 1;
                $old_owner->returned_date = User::setTime();
                $old_owner->received_by = Yii::$app->user->identity->id;
                $old_owner->comment = ($comment) ? $comment : 'No comment';
                $old_owner->save();
        
                $asset = Assets::findOne($old_owner->asset_id);
                $asset->status = 1;
                $asset->save();
                Yii::$app->session->setFlash('success','Conglatulation,asset returned successfully!');

        }
    }
    /**
     * Finds the Owners model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Owners the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Owners::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    //REPORTS

    public function actionReport($barcode){

        // if (Yii::$app->request->isAjax) {

        //     $barcode = Html::encode(Yii::$app->request->getBodyParam('barcode')); 
            $asset_id = Assets::findOne(['barcode'=>$barcode])->id;
            $assets = Owners::find()->where(['asset_id'=>$asset_id])->all();
            $mpdf = new mPDF();
            $mpdf->WriteHTML($this->renderPartial('report',['assets'=>$assets,'barcode'=>$barcode]));
            $mpdf->setFooter('{PAGENO}');
            $mpdf->Output($barcode.' Report.pdf', 'D');
            exit;

        // }
    }


    public function actionExport($barcode){

        $spreadsheet = new Spreadsheet();
        
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        // $sheet->getHeaderFooter()->setOddHeader('&CBOOK LIST');
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->setCellValue('A1', 'Asset code');
        $sheet->setCellValue('B1', 'Owner\'s Name');
        $sheet->setCellValue('C1', 'Issued By');
        $sheet->setCellValue('D1', 'Issued Date');
        $sheet->setCellValue('E1', 'Returned Status');
        $sheet->setCellValue('F1', 'Returned Date');
        $sheet->setCellValue('G1', 'Received By');
        $sheet->setCellValue('H1', 'Comment');
        

        $asset_id = Assets::findOne(['barcode'=>$barcode])->id;

        // $assets = Owners::find()->where(['asset_id'=>$asset_id])->all();
    
        $stmt = Yii::$app->db->createCommand('SELECT * FROM owners WHERE asset_id =:asset_id')
        ->bindValue(':asset_id', $asset_id)
        ->queryAll();
    
    
          $i = 2;
    
          foreach ($stmt as $row) {
          $sheet->setCellValueExplicit("A".$i, $barcode, DataType::TYPE_STRING);
          $sheet->setCellValue("B".$i, $row["name"]);
          $sheet->setCellValue("C".$i, User::getUsername($row["issued_by"]));
          $sheet->setCellValue("D".$i, User::getTime($row["issued_date"]));
          $sheet->setCellValue("E".$i, ($row["returned_status"] == 1) ? 'Returned' : 'Not returned');
          $sheet->setCellValue("F".$i, User::getTime($row["returned_date"]));
          $sheet->setCellValue("G".$i, User::getUsername($row["received_by"]));
          $sheet->setCellValue("H".$i, $row["comment"]);
          $i++;
        }
    
        $sheet->getHeaderFooter()->setOddHeader('&C&BOWNERS');
    
        // (E) SAVE FILE
        $writer = new Xlsx($spreadsheet);
        echo "OK";
        $filename = $barcode.' report.xlsx';
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='. $filename);
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    
      }

}
