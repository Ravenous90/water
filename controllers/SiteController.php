<?php

namespace app\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

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
}
