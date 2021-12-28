<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ijincuti */
$kp='';
if($model->iscuti==1)
{
  $kp='Cuti';
}
else {
  $kp='Ijin';
}
$this->title = 'Ubah Detail ' . $kp;
$this->params['breadcrumbs'][] = ['label' => 'Ijincutis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ijincuti-update">
  <div class="box box-solid box-info">
    <div class="box-header">
      <h3 class="box-title"><?= $model->idPegawai->nama ?> </h3>
    </div>
    <div class="box-body">
      <?= $this->render('_form', [
        'model' => $model,
        'errorstatus'=> $errorstatus,
        'message' => $message,
        'title'=> $title,
        ]) ?>
    </div>
  </div>
</div>
