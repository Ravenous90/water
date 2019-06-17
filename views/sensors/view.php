<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Sensors */
/* @var $isUsersSensor app\controllers\SensorsController */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sensors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sensors-view">

    <h1><?= Html::encode($this->title) ?></h1>
<?php if ($isUsersSensor): ?>
    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
<?php endif; ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'floor_id',
        ],
    ]) ?>
</div>
