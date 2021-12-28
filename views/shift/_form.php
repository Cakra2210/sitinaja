<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Shift */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shift-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_shift')->textInput(['maxlength' => 15]) ?>

    <?= $form->field($model, 'senin')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'selasa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rabu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kamis')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jumat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sabtu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'minggu')->textInput(['maxlength' => true]) ?>

    <div class="form-group" style="float:right">
        <?= Html::submitButton($model->isNewRecord ? 'Buat Shift' : 'Ubah Detail Shift', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
