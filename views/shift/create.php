<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Shift */

$this->title = 'Buat Shift';
$this->params['breadcrumbs'][] = ['label' => 'Shifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shift-create">
  <div class="box box-solid box-info">
    <div class="box-header">
      <h3 class="box-title">Input Shift</h3>
    </div>
    <div class="box-body">
      <?= $this->render('_form', [
          'model' => $model,
      ]) ?>
    </div>
  </div>
</div>
