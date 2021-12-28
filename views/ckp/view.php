<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ckp */

$this->title = $model->id_ckp;
$this->params['breadcrumbs'][] = ['label' => 'Ckps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ckp-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_ckp], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_ckp], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_ckp',
            'date',
            'id_pegawai',
            'id_tugas',
            'satuan:ntext',
            'target',
            'realisasi',
            'kualitas',
            'kd_butir',
            'angka_kredit',
            'keterangan:ntext',
        ],
    ]) ?>

</div>
