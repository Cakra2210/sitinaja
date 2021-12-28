<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tugas */

$this->title = 'Detail Tugas';
$this->params['breadcrumbs'][] = ['label' => 'Tugas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tugas-view">
    <div class="box box-solid box-info">
      <div class="box-header">
        <h3 class="box-title"><?= $model->kegiatan ?></h3>
      </div>
      <div class="box-body">
      <?= DetailView::widget([
          'model' => $model,
          'attributes' => [
              //'id',
              [
                'attribute' => 'Pegawai',
                'value' => $model->idPegawai->nama,
              ],
              [
                'attribute' => 'Surat Dasar',
                'value' => $model->suratdasar,
              ],
              [
                'attribute' => 'Nomor Surat',
                'value' => $model->nosurat,
              ],
              [
                'attribute' => 'Tanggal Surat Tugas',
                'value' => $model->created_date,
              ],
              [
                'attribute' => 'Tanggal Mulai',
                'value' => $model->date_start,
              ],
              [
                'attribute' => 'Tanggal Selesai',
                'value' => $model->date_end,
              ],
              [
                'attribute' => 'Tujuan',
                'value' => $model->destinasi,
              ],
              [
                'attribute' => 'Tugas Seksi',
                'value' => $model->idAssignee->seksi,
              ],
              [
                'attribute' => 'SPPD',
                'value' => $model->sppd == 1 ? 'Ya' : 'Tidak',
              ],
          ],
      ]) ?>
      <br>
      <p style="float:right">
          <?= Html::a('<span class="fa fa-print"></span> Cetak', ['report', 'id_tugas' => $model->id,'id_pegawai'=>$model->idPegawai->id,'kolektif'=>'0'], ['class' => 'btn btn-success']) ?>
          <?php
          if(Yii::$app->myHelper->isKepalaseksi(Yii::$app->user->identity->id_jabatan)||Yii::$app->user->identity->id_jabatan==1)
          {
            echo Html::a('<span class="fa fa-pencil"></span> Ubah Detail', ['update', 'id' => $model->id], ['class' => 'btn btn-info']);
            echo Html::a('<span class="fa fa-trash"></span> Hapus', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Apakah anda yakin akan menghapus tugas ini?',
                    'method' => 'post',
                ],
            ]);
          }
           ?>
      </p>
    </div>
  </div>

</div>
