<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Sensors;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SensorsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My sensors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sensors-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'floor.name',
            [
                'attribute' => 'Building',
                'value' => function ($sensor) {
                    return Sensors::getBuildingBySensorId($sensor->id)->name;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
