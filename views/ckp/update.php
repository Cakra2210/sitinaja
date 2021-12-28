<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ckp */

$this->title = 'Update Ckp: ' . $model->id_ckp;
$this->params['breadcrumbs'][] = ['label' => 'Ckps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_ckp, 'url' => ['view', 'id' => $model->id_ckp]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ckp-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
