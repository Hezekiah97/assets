<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\models\User;
use yii\filters\VerbFilter;
use backend\models\SignupForm;
use backend\models\UserSearch;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\models\User as ModelsUser;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                            'actions' => ['create','index','signup','delete','profile','view'],
                            'roles' => ['Admin'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['update','user-update'],
                            'roles' => ['@'],
                        ],
                    ]
                ]
            ]
        );
    }

        /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();

        if ($this->request->isPost) {
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

    public function actionSignup()
    {
        $this->layout = 'main';

        $model = new SignupForm();
        $model->scenario = 'create';

        if ($model->load(Yii::$app->request->post())) {        
            if ($model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
             return $this->redirect(['index']);
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }



    
    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
 
    public function actionUpdate($id)
    {
        $this->layout = 'main';

        $model = $this->findModel($id);
        // $model->scenario = 'create';


        if ($model->load(Yii::$app->request->post())) {
            // $model->scenario = 'create';

            if ($model->validate()) {
            $update = User::findOne($id);
            $update->firstname = $model->firstname;
            $update->surname = $model->surname;
            $update->email = $model->email;
            $update->updated_at = User::setTime();
            $update->save(false);
            Yii::$app->session->setFlash('success', 'Congratulation,user details updated successfully!');
            return $this->redirect(['index']);
            }
        }

        return $this->render('userUpdate', [
            'model' => $model,
        ]);
    }
    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Conglatulation,user(s) removed successfully!');        
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDeleteUsers(){
        if (Yii::$app->request->isAjax) {
             $selected = Yii::$app->request->getBodyParam('selected');
             User::deleteAll(['id' => $selected]);
             Yii::$app->session->setFlash('success', 'Conglatulation,user(s) removed successfully!');        
        }
    }
}
