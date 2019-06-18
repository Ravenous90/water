<?php

namespace app\controllers;

use app\models\Buildings;
use app\models\SensorsSearch;
use Yii;
use app\models\Floors;
use app\models\FloorsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class FloorsController extends Controller
{

    public function behaviors()
    {
        return SiteController::mainBehavior();
    }

    public function actionIndex()
    {
        $searchModel = new FloorsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $searchSensorModel = new SensorsSearch();
        $dataProvider = $searchSensorModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['floor_id' => $id]);

        $building_id = Floors::findOne($id)->building_id;
        $building_obj = Buildings::findOne($building_id);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchFloorModel' => $searchSensorModel,
            'dataProvider' => $dataProvider,
            'building_obj' => $building_obj,
        ]);
    }

    public function actionCreate()
    {
        $model = new Floors();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['buildings/view', 'id' => Yii::$app->request->get('id')]);
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

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['buildings/view', 'id' => Yii::$app->request->get('id')]);
    }

    protected function findModel($id)
    {
        if (($model = Floors::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
