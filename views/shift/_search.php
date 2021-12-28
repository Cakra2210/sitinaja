<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ShiftSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shift-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nama_shift') ?>

    <?= $form->field($model, 'senin') ?>

    <?= $form->field($model, 'selasa') ?>

    <?= $form->field($model, 'rabu') ?>

    <?php // echo $form->field($model, 'kamis') ?>

    <?php // echo $form->field($model, 'jumat') ?>

    <?php // echo $form->field($model, 'sabtu') ?>

    <?php // echo $form->field($model, 'minggu') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
