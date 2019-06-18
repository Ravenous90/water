<?php

namespace app\controllers;

use Yii;
use app\models\Buildings;
use app\models\BuildingsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\FloorsSearch;

class BuildingsController extends Controller
{

    public function behaviors()
    {
        return SiteController::mainBehavior();
    }

    public function actionIndex()
    {
        $searchModel = new BuildingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $searchFloorModel = new FloorsSearch();
        $dataProvider = $searchFloorModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['building_id' => $id]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchFloorModel' => $searchFloorModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Buildings();

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

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Buildings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
