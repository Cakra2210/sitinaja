<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tugas */

$this->title = 'Buat Surat Tugas Pribadi';
$this->params['breadcrumbs'][] = ['label' => 'Buat Surat Tugas Pribadi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tugas-create">
  <div class="box box-solid box-info">
    <div class="box-header">
      <h3 class="box-title">Input Data</h3>
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
