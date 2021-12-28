<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Shift */

$this->title = $model->nama_shift;
$this->params['breadcrumbs'][] = ['label' => 'Shifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shift-view">
  <div class="box box-solid box-info">
    <div class="box-header">
      <h3 class="box-title">Shift</h3>
    </div>
    <div class="box-body">
      <?= DetailView::widget([
          'model' => $model,
          'attributes' => [
              'id',
              'nama_shift:ntext',
              'hari0',
              'hari1',
              'hari2',
              'hari3',
              'hari4',
              'hari5',
              'hari0',
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
