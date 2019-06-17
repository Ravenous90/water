<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SensorsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My sensors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sensors-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a('Create Sensors', ['buildings/index'], ['class' => 'btn btn-success']) ?>
        <?= Yii::$app->session->setFlash('info', 'Choose building') ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'floor_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
