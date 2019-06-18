<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Floors */

$this->title = 'Floor №' . $model->name;
$this->params['breadcrumbs'][] = ['label' => $building_obj->name, 'url' => ['buildings/' . $building_obj->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="floors-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update floor', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete floor', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn'],
                'name',
            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'sensors'
            ],
        ],
    ]); ?>

    <p>
        <?= Html::a('Create Sensor', ['sensors/create', 'id' => Yii::$app->request->get('id')], ['class' => 'btn btn-success']) ?>
    </p>

</div>
