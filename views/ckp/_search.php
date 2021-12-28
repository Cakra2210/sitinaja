<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CkpSearc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ckp-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_ckp') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'id_pegawai') ?>

    <?= $form->field($model, 'id_tugas') ?>

    <?= $form->field($model, 'satuan') ?>

    <?php // echo $form->field($model, 'target') ?>

    <?php // echo $form->field($model, 'realisasi') ?>

    <?php // echo $form->field($model, 'kualitas') ?>

    <?php // echo $form->field($model, 'kd_butir') ?>

    <?php // echo $form->field($model, 'angka_kredit') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
