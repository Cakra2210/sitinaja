<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Ijincuti */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ijincuti-form">
    <?php
      if($errorstatus)
      {
        echo \yii2mod\alert\Alert::widget([
            'useSessionFlash' => false,
            'options' => [
                'timer' => null,
                'type' => \yii2mod\alert\Alert::TYPE_ERROR,
                'title' => $title,
                'text' => $message,
                'confirmButtonText' => "OK",
                'confirmButtonColor' => "#F27474",
                'closeOnConfirm' => true,
                'animation' => "slide-from-top",
                'inputPlaceholder' => "Write something"
            ],
        ]);
      }
      $pegawai = ArrayHelper::map(\app\models\Pegawai::find()->where(['!=', 'id', 1])->all(), 'id', 'nama');
    ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_pegawai')->dropDownList($pegawai, ['prompt' => '---- Pilih Pegawai yang membuat surat ijin/cuti ----'])->label('Pegawai') ?>

    <?= $form->field($model, 'iscuti')->dropDownList(['0' => '1. Ijin', '1' => '2. Cuti'],['disabled'=>!$model->isNewRecord,'prompt'=>'Apakah Ijin atau Cuti?'])->label('Ijin/Cuti') ?>

    <?= $form->field($model, 'keperluan')->textInput(['disabled'=>$model->iscuti==2])->label('Jika Ijin untuk keperluan apa? kosongi jika cuti') ?>

    <?= $form->field($model, 'alamat')->textarea(['rows' => 2])->label('Selama Ijin/Cuti Pegawai Berada dimana?') ?>

    <?php
      echo '<label for="datestart">Tanggal Mulai Ijin/Cuti</label>';
      echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'date_start',
        'dateFormat' => 'yyyy-MM-dd',
        'name'=> 'datestart',
        'options' => [
          'class' => 'form-control',
        ]
      ]);
      echo '<label for="dateend">Tanggal Selesai Ijin/Cuti</label>';
      echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'date_end',
        'dateFormat' => 'yyyy-MM-dd',
        'name'=> 'dateend',
        'options' => [
          'class' => 'form-control',
        ]
      ]);
      echo '<label for="tanggalsurat">Tanggal Surat Ijin/Cuti</label>';
      echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'tanggal_surat',
        'dateFormat' => 'yyyy-MM-dd',
        'name'=> 'tanggalsurat',
        'options' => [
          'class' => 'form-control',
        ]
      ]);
    ?>
    <br>
    <div class="form-group" style="float:right">
        <?= Html::submitButton($model->isNewRecord ? 'Buat Surat Ijin/Cuti' : 'Ubah Detail Ijin/Cuti', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
