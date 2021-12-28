<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ijincuti */
$iscuti = $model->iscuti;
$textiscuti = $iscuti==1?'Cuti':'Ijin';
$this->title = $textiscuti.' '.$model->idPegawai->nama;
$this->params['breadcrumbs'][] = ['label' => 'Surat Ijin/Cuti', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="ijincuti-view">
    <div class="box box-solid box-info">
      <div class="box-header">
        <h3 class="box-title"><?= $textiscuti ?></h3>
      </div>
      <div class="box-body">
        <?php
          $kp='';
          if($model->iscuti==1)
          {
            $kp = 'cuti';
          }else {
            $kp=$model->keperluan;
          }
        ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                //'id_pegawai',
                [
                  'attribute' => 'Keperluan',
                  'value' => $kp,
                ],
                [
                  'attribute' => 'tujuan',
                  'value' => $model->alamat,
                ],
                [
                  'attribute' => 'Tanggal Mulai',
                  'value' => $model->date_start,
                ],
                [
                  'attribute' => 'Tanggal Selesai',
                  'value' => $model->date_end,
                ],
            ],
        ]) ?>
        <br>
        <p style="float:right">
            <?= Html::a('<span class="fa fa-print"></span> Cetak', ['print', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
            <?= Html::a('<span class="fa fa-pencil"></span> Ubah Detail', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
            <?= Html::a('<span class="fa fa-trash"></span> Hapus', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Apakah anda yakin akan menghapus tugas ini?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>
      </div>
    </div>

</div>
