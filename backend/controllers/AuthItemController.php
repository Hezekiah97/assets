<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\User;
use yii\filters\VerbFilter;
use backend\models\AuthItem;
use yii\filters\AccessControl;
use backend\models\AuthItemSearch;
use yii\web\NotFoundHttpException;

/**
 * AuthItemController implements the CRUD actions for AuthItem model.
 */
class AuthItemController extends Controller
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
                            'actions' => ['index','create','update','delete','delete-items','view'],
                            'roles' => ['Admin'],
                        ],
                        ]
                ] 
            ]
        );
    }

    /**
     * Lists all AuthItem models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
     * @param string $name Name
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($name)
    {
        return $this->render('view', [
            'model' => $this->findModel($name),
        ]);
    }

 /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItem();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->validate()) {
                // $model = new AuthItem();
                $model->name = $model->name;
                $model->description = $model->description;
                $model->created_at = User::setTime();
                $model->created_by = Yii::$app->user->identity->id;
                $model->save();
                Yii::$app->session->setFlash('success', "Permission added successfully.");               
                return $this->redirect(['view', 'id' => $model->name]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Permission updated successfully.");
            return $this->redirect(['view', 'id' => $model->name]);

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $name Name
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($name)
    {
        $this->findModel($name)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $name Name
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($name)
    {
        if (($model = AuthItem::findOne(['name' => $name])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }



    //delete multiple items
    public function actionDeleteItems(){
        if (Yii::$app->request->isAjax) {
             $selected = Yii::$app->request->getBodyParam('selected');
             AuthItem::deleteAll(['name' => $selected]);
             Yii::$app->session->setFlash('success', 'Conglatulation,item(s) removed successfully!');        
        }
    }
}
