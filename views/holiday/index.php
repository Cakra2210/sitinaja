<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\HolidaySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hari Libur';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="holiday-index">

    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      //'filterModel' => $searchModel,
      'bordered'=>true,
      'striped'=>true,
      'condensed'=>true,
      'responsive'=>true,
      'hover'=>true,
      'panel'=>[
          'type'=>GridView::TYPE_SUCCESS,
          'heading'=>'<i class="glyphicon glyphicon-book"></i>',
      ],
      'toolbar' => [
        ['content'=>
          Html::a('Tambah Hari Libur', ['create'], ['class' => 'btn btn-success'])
        ],
      ],
      'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
      'headerRowOptions'=>['class'=>'default'],
      'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'tanggal',
            'keterangan:ntext',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
