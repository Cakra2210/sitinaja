<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Seksi */

$this->title = $model->seksi;
$this->params['breadcrumbs'][] = ['label' => 'Seksi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seksi-view">

    <div class="box box-solid box-info">
      <div class="box-header">
        <h3 class="box-title">Jabatan</h3>
      </div>
      <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'seksi:ntext',
                'kode',
            ],
        ]) ?>
        <br>
        <p>
          <?= Html::a('<span class="fa fa-pencil"></span> Ubah Detail', ['update', 'id' => $model->id], ['class' => 'btn btn-info']) ?>
          <?= Html::a('<span class="fa fa-trash"></span> Hapus', ['delete', 'id' => $model->id], [
              'class' => 'btn btn-danger',
              'data' => [
                  'confirm' => 'Apakah anda yakin akan menghapus tugas ini?',
                  'method' => 'post',
              ],
          ]) ?>
        </p>

        <br>
      </div>
    </div>
</div>
