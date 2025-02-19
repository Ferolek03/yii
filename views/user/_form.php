<?php

use app\models\Gender;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$items = Gender::find()
    ->select(['name'])
    ->indexBy('id')
    ->column();
/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'full_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '7-999-999-9999',
    ]) ?>

    <?= $form->field($model, 'id_gender')->dropDownList($items) ?>

    <?= $form->field($model, 'happy')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '9999-99-99',
    ]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password2')->passwordInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
