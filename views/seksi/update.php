<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Seksi */

$this->title = 'Ubah Data Seksi';
$this->params['breadcrumbs'][] = ['label' => 'Seksi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->seksi, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="seksi-update">

  <div class="box box-solid box-info">
    <div class="box-header">
      <h3 class="box-title">Update Seksi</h3>
    </div>
    <div class="box-body">
      <?= $this->render('_form', [
          'model' => $model,
      ]) ?>
    </div>
  </div>

</div>
