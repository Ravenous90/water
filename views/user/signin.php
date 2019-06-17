<h1>Sign in page</h1>
<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php
$form = ActiveForm::begin(['options' => ['class' => 'signin_form']]);
?>

<?= $form->field($model, 'username')->textInput(['autofocus' => false]) ?>
<?= $form->field($model, 'password')->passwordInput() ?>

<div class="form_btns">
    <button type="submit" class="btn btn-success action-btn">Sign in</button>
    <?= Html::a('Sign up', ['user/signup'], ['class' => 'second_btn']) ?>
</div>

<?php
ActiveForm::end()
?>
