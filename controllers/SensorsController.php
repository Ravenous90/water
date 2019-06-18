<?php

namespace app\controllers;

use app\models\Buildings;
use app\models\Floors;
use app\models\User;
use Yii;
use app\models\Sensors;
use app\models\SensorsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SensorsController extends Controller
{
    public function behaviors()
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
                        'denyCallback'  => function ($rule, $action) {
                            Yii::$app->session->setFlash('error', 'This section is only for registered users.');
                            return $action->controller->redirect(['user/signin']);
                        },
                    ],
                    [
                        'allow' => false,
                        'actions' => ['update', 'delete'],
                        'matchCallback' => function ($rule, $action) {
                            return !$this->isUsersSensor(Yii::$app->request->get('id'));
                        },
                        'denyCallback'  => function ($rule, $action) {
                            Yii::$app->session->setFlash('error', 'You have not permission');
                            return $action->controller->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
                        },
                    ],
                    [
                        'allow' => false,
                        'actions' => ['create', 'update', 'delete'],
                        'matchCallback' => function ($rule, $action) {
                            return User::isUserAdmin(Yii::$app->user->identity->getId());
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
        $floor_id = Sensors::findOne($id)->floor_id;
        $floor_obj = Floors::findOne($floor_id);
        $building_id = $floor_obj->building_id;
        $building_obj = Buildings::findOne($building_id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'floor_obj' => $floor_obj,
            'building_obj' => $building_obj,
        ]);
    }

    public function actionCreate()
    {
        $model = new Sensors();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['floors/view', 'id' => Yii::$app->request->get('id')]);
        }

        return $this->render('create', [
            'model' => $model,
            'id' => Yii::$app->request->get('id'),
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

        return $this->redirect(['sensors/my_sensors']);
    }

    public function actionMy_sensors()
    {
        $searchModel = new SensorsSearch();
        $searchModel->user_id = Yii::$app->user->getId();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('my_sensors', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function isUsersSensor($id)
    {
        $result = Sensors::findOne($id);
        return $result['user_id'] == Yii::$app->user->id ? true : false;
    }

    protected function findModel($id)
    {
        if (($model = Sensors::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
