<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Holiday */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="holiday-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    echo '<label for="tanggal">Tanggal Mulai</label>';
    echo DatePicker::widget([
      'model' => $model,
      'attribute' => 'tanggal',
      'dateFormat' => 'yyyy-MM-dd',
      'name'=> 'tanggal',
      'options' => [
        'class' => 'form-control',
        'style'=>['cursor'=>'pointer'],
        ]
      ]);
     ?>

    <?= $form->field($model, 'keterangan')->textarea(['rows' => 6]) ?>

    <div class="form-group" style="float:right">
        <?= Html::submitButton($model->isNewRecord ? 'Tambah Hari Libur' : 'Ubah Hari Libur', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
