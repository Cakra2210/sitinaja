<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Seksi */

$this->title = 'Tambah Seksi';
$this->params['breadcrumbs'][] = ['label' => 'Seksi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seksi-create">
  <div class="box box-solid box-info">
    <div class="box-header">
      <h3 class="box-title">Input Seksi</h3>
    </div>
    <div class="box-body">
      <?= $this->render('_form', [
          'model' => $model,
      ]) ?>
    </div>
    </div>
</div>
