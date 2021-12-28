<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Holiday */

$this->title = $model->keterangan;
$this->params['breadcrumbs'][] = ['label' => 'Holidays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holiday-view">
    <div class="box box-solid box-info">
      <div class="box-header">
        <h3 class="box-title">Hari Libur</h3>
      </div>
      <div class="box-body">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [            
            'tanggal',
            'keterangan:ntext',
        ],
    ]) ?>
    <br>
    <p>
      <?= Html::a('<span class="fa fa-pencil"></span> Ubah Detail', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
      <?= Html::a('<span class="fa fa-trash"></span> Hapus', ['delete', 'id' => $model->id], [
          'class' => 'btn btn-danger',
          'data' => [
              'confirm' => 'Apakah anda yakin akan menghapus shift ini?',
              'method' => 'post',
          ],
      ]) ?>
    </p>
  </div>
</div>
</div>
