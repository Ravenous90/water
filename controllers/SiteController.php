<?php

namespace app\controllers;

use app\models\User;
use yii\web\Controller;
use yii\filters\AccessControl;
use Yii;

class SiteController extends Controller
{
    public function actionLogin()
    {
        return $this->redirect(['user/signin']);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionError()
    {
        return $this->render('error');
    }

    public static function mainBehavior()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => false,
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => ['?'],
                        'denyCallback' => function ($rule, $action) {
                            Yii::$app->session->setFlash('error', 'This section is only for registered users.');
                            return $action->controller->redirect(['user/signin']);
                        },
                    ],
                    [
                        'allow' => false,
                        'actions' => ['create', 'update', 'delete'],
                        'matchCallback' => function ($rule, $action) {
                            return !User::isUserAdmin(Yii::$app->user->identity->getId());
                        },
                        'denyCallback' => function ($rule, $action) {
                            Yii::$app->session->setFlash('error', 'You have not permission');
                            return $action->controller->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
}
