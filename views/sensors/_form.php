<?php

use app\models\Sensors;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sensors */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="sensors-form">
    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?php if (Yii::$app->controller->action->id == 'create') : ?>
        <?= $form->field($model, 'floor_id')->hiddenInput(['value' => Yii::$app->request->get('id')])->label(false) ?>
        <?= $form->field($model, 'building_id')
            ->hiddenInput(['value' => Sensors::getBuildingByFloorId(Yii::$app->request->get('id'))->id])
            ->label(false)
        ?>
    <?php else: ?>
        <?= $form->field($model, 'floor_id')->hiddenInput(['value' => Sensors::findOne(Yii::$app->request->get('id'))->floor_id])->label(false) ?>
        <?= $form->field($model, 'building_id')
            ->hiddenInput(['value' => Sensors::getBuildingBySensorId(Yii::$app->request->get('id'))->id])
            ->label(false)
        ?>
    <?php endif; ?>

    <?= $form->field($model, 'user_id')->hiddenInput(['value' => Yii::$app->user->identity->getId()])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
