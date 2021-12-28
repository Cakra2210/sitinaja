<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Holiday */

$this->title = 'Tambah Hari Libur';
$this->params['breadcrumbs'][] = ['label' => 'Hari Libur', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holiday-create">
  <div class="box box-solid box-info">
    <div class="box-header">
      <h3 class="box-title">Input</h3>
    </div>
    <div class="box-body">
      <?= $this->render('_form', [
          'model' => $model,
      ]) ?>
    </div>
  </div>
</div>
