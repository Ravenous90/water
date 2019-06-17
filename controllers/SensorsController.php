<?php

namespace app\controllers;

use Yii;
use app\models\Sensors;
use app\models\SensorsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\UsersToSensors;

class SensorsController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new SensorsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $isUsersSensor = $this->isUsersSensor($id, Yii::$app->user->id);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'isUsersSensor' => $isUsersSensor,
        ]);
    }

    public function actionCreate()
    {
        $model = new Sensors();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUsersSensors()
    {
        $searchModel = new UsersToSensorsSearch();
        $dataProvider = $searchModel
                        ->search(Yii::$app->request->queryParams)
                        ->query
                        ->where(['user_id' => Yii::$app->user->id]);

        return $this->render('users_sensors', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function isUsersSensor($sensor_id, $user_id)
    {
        $result = UsersToSensors::findAll([
            'user_id' => $user_id,
            'sensor_id' => $sensor_id]);
        return empty($result) ? false : true;
    }

    protected function findModel($id)
    {
        if (($model = Sensors::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
