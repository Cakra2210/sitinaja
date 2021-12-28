<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ckp */

$this->title = 'Create Ckp';
$this->params['breadcrumbs'][] = ['label' => 'Ckps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ckp-create">
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
