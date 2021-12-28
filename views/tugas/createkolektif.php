<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\Tugas */

$this->title = 'Buat Surat Tugas Kolektif';
$this->params['breadcrumbs'][] = ['label' => 'Buat Surat Tugas Kolektif', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tugas-create">
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
  <div class="box box-solid box-info">
    <div class="box-header">
      <h3 class="box-title">Input Data</h3>
    </div>
    <div class="box-body">
      <?php $form = ActiveForm::begin([
        'action' =>
        [
          'tugas/savekolektif'
        ],
        'id' => 'kolektif_post',
        'method' => 'post',
      ]); ?>
      <div class="box box-solid box-primary">
        <div class="box-header">
          Pilih Pegawai
        </div>
        <div class="box-body">
          <?= $form->field($model, 'id_pegawai')->checkboxList($pegawai,['separator'=>'<br/>'])->label('') ?>
        </div>
      </div>
      <?= $form->field($model, 'suratdasar')->textarea(['rows' => 2])->label('Surat Dasar')->input('text',['placeholder'=>'Surat Dari Provinsi/Pusat yang Menjadi Dasar Penugasan']) ?>

      <?= $form->field($model, 'nosurat')->textInput()->label('Nomor Surat Tugas')->input('text',['placeholder'=>'Nomor Surat Tugas yang diambil dari buku Kuning TU']) ?>

      <?php
      echo '<label for="datestart">Tanggal Mulai</label>';
      echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'date_start',
        'dateFormat' => 'yyyy-MM-dd',
        'name'=> 'datestart',
        'options' => [
          'class' => 'form-control',
        ]
      ]);
      echo '<label for="dateend">Tanggal Selesai</label>';
      echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'date_end',
        'dateFormat' => 'yyyy-MM-dd',
        'name'=> 'dateend',
        'options' => [
          'class' => 'form-control',
        ]
      ]);
      echo '<label for="tanggalsurat">Tanggal Surat Tugas</label>';
      echo DatePicker::widget([
        'model' => $model,
        'attribute' => 'created_date',
        'dateFormat' => 'yyyy-MM-dd',
        'name'=> 'tanggalsurat',
        'options' => [
          'class' => 'form-control',
        ]
      ]);
      ?>

      <?= $form->field($model, 'kegiatan')->textarea(['rows' => 3])->label('Kegiatan')->input('text',['placeholder'=>'Kegiatan yang dilakukan dalam tugas']) ?>

      <?= $form->field($model, 'destinasi')->textInput()->label('Kota/Kabupaten/Kecamatan Tujuan')->input('text',['placeholder'=>'Tempat Pelaksanaan Tugas'])?>

      <?= $form->field($model, 'assignee')->dropDownList($seksi, ['prompt' => '---- Pilih Seksi yang Memberi Tugas ----'])->label('Seksi') ?>

      <?= $form->field($model, 'sppd')->dropDownList(['1' => '1. Ya', '2' => '2. Tidak'],['prompt'=>'Apakah Menggunakan SPPD?']) ?>

      <?= $form->field($model, 'is_luar_kota')->dropDownList(['1' => '1. Dalam Kota', '2' => '2. Luar Kota'],['prompt'=>'Apakah Tujuan Dalam Kota / Luar Kota']) ?>

      <?= $form->field($model,'blok_absen')->dropDownList(['1' => 'Ya', '0' => 'Tidak'],['prompt'=>'Apakah Blok Absen?']); ?>

      <div class="form-group">
        <?= Html::submitButton('Buat Surat Tugas',['class' => 'btn btn-success']) ?>
      </div>
      <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>
<?php
$this->registerJs('
      blokabsenshow();

      $("#tugas-sppd").change(function () {
        blokabsenshow();
      });
      function blokabsenshow(){
        if ($("#tugas-sppd").val() == 2)
        {
          $(".field-tugas-blok_absen").removeClass("hide");
        }else {
          $(".field-tugas-blok_absen").addClass("hide");
        }
      }
'
);
?>
