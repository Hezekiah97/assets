<?php

namespace backend\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use backend\models\Book;
use backend\models\Assets;
use backend\models\Owners;
use yii\filters\VerbFilter;
use common\models\LoginForm;
use InvalidArgumentException;
use yii\filters\AccessControl;
use backend\models\VerifyEmailForm;
use yii\web\BadRequestHttpException;
use backend\models\ResetPasswordForm;
use backend\models\PasswordResetRequestForm;
use backend\models\ResendVerificationEmailForm;
use common\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','request-password-reset','verify-email','reset-password'],
                        'roles'=>['?'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'reports','forbidden'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
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

    // public function actionForbidden(){
    //     return $this->render('forbidden');
    // }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $assets = Assets::find()->limit(5)->all();
        $assetTotal = Assets::find()->count();
        $usersTotal = User::find()->count();
        $bookTotal = Book::find()->count();
        $recentBooks = Book::find()->limit(5)->orderBy('regDate')->all();
        $recentUsers = User::find()->limit(5)->orderBy('created_at')->all();
        $activeOnwersTotal = Owners::find()->where(['returned_status'=>0])->count();


        if (User::getRole(Yii::$app->user->identity->id) == 'PRO') {

            return $this->render('pro-dashboard',['recentBooks'=>$recentBooks,'bookTotal'=>$bookTotal]);

        }

        if (User::getRole(Yii::$app->user->identity->id) == 'HR') {

            return $this->render('hr-dashboard',['assets'=>$assets,'assetTotal'=>$assetTotal,'activeOnwersTotal'=>$activeOnwersTotal]);

        }


        return $this->render(
        'index',
        [
            'recentUsers'=>$recentUsers,'usersTotal'=>$usersTotal,
            'assetTotal'=>$assetTotal,
            'bookTotal'=>$bookTotal,'activeOnwersTotal'=>$activeOnwersTotal
        ]
        );

    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
         
                return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'blank';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Reset link sent,check your email.');

                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        $this->layout = 'blank';
        try {
        $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved, please login');
            return $this->redirect(['/site/login']);
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }


}
