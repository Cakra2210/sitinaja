<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tugas */

$this->title = 'Detail Tugas Kolektif';
$this->params['breadcrumbs'][] = ['label' => 'Tugas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kolektif-view">
<div class="box box-solid box-info">
  <div class="box-header">
    <h3 class="box-title"><?= $model['kegiatan'] ?></h3>
  </div>
  <div class="box-body">
  <table class="table">
    <thead>
      <tr>
        <th>Pegawai</th>
        <th>Kegiatan</th>
        <th>Destinasi</th>
        <th>Seksi</th>
        <th>Tanggal Mulai</th>
        <th>Tanggal Selesai</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <ul>
          <?php
            foreach($pegawai as $nama)
            {
              echo '<li>'.$nama['nama'].'</li>';
            }
          ?>
          </ul>
        </td>
        <td>
          <?= $model['kegiatan'] ?>
        </td>
        <td>
          <?= $model['destinasi'] ?>
        </td>
        <td>
          <?= $seksi['seksi'] ?>
        </td>
        <td>
          <?= $model['date_start'] ?>
        </td>
        <td>
          <?= $model['date_end'] ?>
        </td>
      </tr>
    </tbody>
  </table>
  <br>
  <p style="float:right">
  <?= Html::a('Cetak Surat Tugas', ['printkolektif',
    'pegawai' => $pegawai,
    'seksi' => $seksi['seksi'],
    'kegiatan' => $model['kegiatan'],
    'destinasi' => $model['destinasi'],
    'date_start'=>$model['date_start'],
    'date_end'=>$model['date_end'],
    'created_date'=>$model['created_date'],
    'suratdasar'=>$model['suratdasar'],
    'nosurat'=>$model['nosurat'],
  ], ['class' => 'btn btn-success']) ?>
  <?php
    if(Yii::$app->myHelper->isKepalaseksi(Yii::$app->user->identity->id_jabatan)||Yii::$app->user->identity->id_jabatan==1){
      echo Html::a('Ubah Surat Tugas', ['editkolektif',
        'groupid'=>$group
      ],['class' => 'btn btn-success']);
    }
     ?>
    <br>
  </p>
  <h3>Cetak Lampiran</h3>
  <?php
    $helper=Yii::$app->myHelper;
    if($tugas[0]['sppd']==1)
    {
      echo '<ol>';
      foreach($tugas as $t)
      {
        $x = $helper->pegawaiById($t['id_pegawai']);
        $nama = $x->nama;
        echo '<li>';
        echo Html::a('Cetak Lampiran '.$nama,
            [
              'report',
              'id_tugas'=>$t['id'],
              'id_pegawai'=>$t['id_pegawai'],
              'kolektif'=>'1'
            ]);
        echo '</li>';
      }
      echo '</ol>';
    }
   ?>
 </div>
</div>
</div>
