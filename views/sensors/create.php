<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Sensors */

$this->title = 'Create Sensors';
$this->params['breadcrumbs'][] = ['label' => 'Sensors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sensors-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
