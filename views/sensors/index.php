<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\User;
use app\models\Sensors;
/* @var $this yii\web\View */
/* @var $searchModel app\models\SensorsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Sensors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sensors-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php if (User::isUserAdmin(Yii::$app->user->identity->getId())) : ?>
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
                'user.username',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php endif; ?>
    <?php Pjax::end(); ?>
</div>
