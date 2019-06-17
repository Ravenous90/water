<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Floors;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Sensors */
/* @var $form yii\widgets\ActiveForm */

$floors = Floors::find()->all();
$floorsList = ArrayHelper::map($floors,'name', 'name');

?>

<div class="sensors-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'floor_id')->dropDownList($floorsList) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
