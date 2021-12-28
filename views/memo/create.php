<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Memo */

$this->title = 'Buat Memo';
$this->params['breadcrumbs'][] = ['label' => 'Memos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memo-create">
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
