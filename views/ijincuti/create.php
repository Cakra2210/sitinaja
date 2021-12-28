<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ijincuti */

$this->title = 'Buat Surat Ijin/Cuti';
$this->params['breadcrumbs'][] = ['label' => 'Surat Ijin/Cuti', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ijincuti-create">
  <div class="box box-solid box-info">
    <div class="box-header">
      <h3 class="box-title">Input Seksi</h3>
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
