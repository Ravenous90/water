<?php
/**
 * Created by PhpStorm.
 * User: askolotii
 * Date: 18.09.2018
 * Time: 10:00
 */

namespace app\controllers;

use app\models\Signin;
use app\models\Signup;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\User;

class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['signin', 'logout', 'signup'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['signin', 'signup'],
                        'roles' => ['?'],
                        'denyCallback'  => function ($rule, $action) {
                            Yii::$app->session->setFlash('error', 'This section is for unauthorized users.');
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout'],
                        'roles' => ['@'],
                        'denyCallback'  => function ($rule, $action) {
                            Yii::$app->session->setFlash('error', 'This section is only for registered users.');
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionSignup()
    {
        $model = new Signup();

        if (isset($_POST['Signup'])) {
            $model->attributes = Yii::$app->request->post('Signup');

            if ($model->validate() && $model->signup()) {
                return $this->redirect('signin');
            }
        }
        return $this->render('signup',['model' => $model]);
    }

    public function actionSignin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new Signin();

        if ( Yii::$app->request->post('Signin')) {
            $model->attributes = Yii::$app->request->post('Signin');

            if ($model->validate()) {
                Yii::$app->user->login($model->getUser());
                return $this->goHome();
            }
        }
        return $this->render('signin',['model' => $model]);
    }

    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
            return $this->redirect(['signin']);
        }
    }
}