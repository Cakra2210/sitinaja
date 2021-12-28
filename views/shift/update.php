<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Shift */

$this->title = 'Update Shift: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Shifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shift-update">

  <div class="box box-solid box-info">
    <div class="box-header">
      <h3 class="box-title">Ubah Detail Shift</h3>
    </div>
    <div class="box-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
  </div>
  </div>

</div>
