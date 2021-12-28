<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Memo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="memo-form">
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
        $seksi = ArrayHelper::map(\app\models\Seksi::find()->all(), 'id', 'seksi');
     ?>
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_pegawai')->dropDownList($pegawai, ['prompt' => '---- Pegawai yang Membuat Memo ----'])->label('Pegawai') ?>

    <?= $form->field($model, 'id_seksi')->dropDownList($seksi, ['prompt' => '---- Seksi yang Memberi Tugas ----'])->label('Seksi') ?>

    <?= $form->field($model, 'keperluan')->textarea(['rows' => 6]) ?>

    <?php
      echo $form->field($model, 'jam_keluar')->widget(DateTimePicker::classname(), [
      	'options' => ['placeholder' => 'Jam Keluar Kantor'],
      	'pluginOptions' => [
      		'autoclose' => true,
          'todayHighlight' => true,
  		    'todayBtn' => true,
      	]
      ]);

      echo $form->field($model, 'jam_pulang')->widget(DateTimePicker::classname(), [
        'options' => ['placeholder' => 'Jam Kembali Ke Kantor'],
        'pluginOptions' => [
          'autoclose' => true,
          'todayHighlight' => true,
          'todayBtn' => true,
        ]
      ]);
     ?>
     <br>
    <div class="form-group" style="float:right">
        <?= Html::submitButton($model->isNewRecord ? 'Buat Memo' : 'Ubah Detail Memo', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
