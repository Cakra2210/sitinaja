<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Tugas */
$this->title = 'Jurnal';
$this->params['breadcrumbs'][] = ['label' => 'Jurnal', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tugas-create">
  <div class="box box-solid box-info">
    <div class="box-header">
      <h3 class="box-title">Input Jurnal Kegiatan Harian</h3>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <form action="savejurnal" style="padding-left:20px;padding-right:20px;padding-top:20px;">
      <div class="form-group field-tugas-kegiatan required">
        <label class="control-label" for="tugas-kegiatan">Kegiatan</label>
        <textarea rows=3 id="tugas-kegiatan" class="form-control" name="kegiatan" placeholder="Input Kegiatan" ></textarea>
        <div class="help-block"></div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="form-group field-tugas-satuan required">
            <label class="control-label" for="tugas-satuan">Satuan</label>
            <input type="text" id="tugas-satuan" class="form-control" name="satuan" placeholder="Input Satuan Kegiatan">
            <div class="help-block"></div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group field-tugas-jumlah required">
            <label class="control-label" for="tugas-jumlah">Jumlah</label>
            <input type="text" id="tugas-satuan" class="form-control" name="jumlah" placeholder="Input Jumlah">
            <div class="help-block"></div>
          </div>
        </div>
      </div>
      <div class="form-group field-tugas-assignee required">
      <label class="control-label" for="tugas-assignee">Seksi</label>
      <select id="tugas-assignee" class="form-control" name="assignee">
      <option value="">---- Pilih Seksi yang Memberi Tugas ----</option>
      <option value="1">Integrasi Pengolahan dan Diseminasi Statistik (IPDS)</option>
      <option value="2">Neraca Wilayah dan Analisis Statistik</option>
      <option value="3">Statistik Produksi</option>
      <option value="4">Tata Usaha</option>
      <option value="5">Statistik Sosial</option>
      <option value="6">Statistik Distribusi</option>
      <option value="8">Umum</option>
      </select>

      <div class="help-block"></div>
      </div>
        <input type="text" hidden value=<?= Yii::$app->user->identity->id ?> name="iduser"></input>
        <p class="text-right"><button type="submit" class="btn btn-success">Simpan</button></p>

    </form>
      </div>
      <div class="col-lg-6">
        <div style="padding:10px">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'bordered'=>true,
            'striped'=>true,
            'condensed'=>true,
            'responsive'=>true,
            'hover'=>true,
            'panel'=>[
                'type'=>GridView::TYPE_SUCCESS,
                'heading'=>'<i class="glyphicon glyphicon-book"></i>',
            ],
            'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
            'headerRowOptions'=>['class'=>'default'],
            'filterRowOptions'=>['class'=>'kartik-sheet-style'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'idTugas.kegiatan',
                'idTugas.created_date'
            ],
        ]); ?>
        <div>
      </div>
    </div>
  </div>
</div>
</div>
