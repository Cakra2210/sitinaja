<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tugas */

$this->title = 'Ubah Detail Tugas';
$this->params['breadcrumbs'][] = ['label' => 'Tugas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idPegawai->nama, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="tugas-update">
  <div class="box box-solid box-info">
    <div class="box-header">
      <h3 class="box-title"><?= $model->kegiatan ?></h3>
    </div>
    <div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
        'errorstatus'=> $errorstatus,
        'message' => $message,
        'title'=>$title,
    ]) ?>
  </div>
</div>

</div>
