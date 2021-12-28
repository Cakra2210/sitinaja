<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Memo */

$this->title = 'Detail Memo '.$model->idPegawai->nama;
$this->params['breadcrumbs'][] = ['label' => 'Memos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memo-view">
    <div class="box box-solid box-info">
      <div class="box-header">
        <h3 class="box-title">Memo</h3>
      </div>
      <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                //'id',
                //'id_pegawai',
                [
                  'attribute' => 'Keperluan',
                  'value' => $model->keperluan,
                ],
                [
                  'attribute' => 'Seksi',
                  'value' => $model->idSeksi->seksi,
                ],
                [
                  'attribute' => 'Jam Keluar',
                  'value' => $model->jam_keluar,
                ],
                [
                  'attribute' => 'Jam Pulang',
                  'value' => $model->jam_pulang,
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
