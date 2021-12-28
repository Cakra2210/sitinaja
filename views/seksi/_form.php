<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Seksi */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="seksi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'seksi')->textInput() ?>

    <?= $form->field($model, 'kode')->textInput(['maxlength' => true]) ?>

    <div class="form-group" style="float:right">
        <?= Html::submitButton($model->isNewRecord ? 'Buat Seksi' : 'Ubah Seksi', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
