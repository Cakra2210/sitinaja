<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SeksiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Seksi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="seksi-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    </p>
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
          Html::a('Tambah Seksi', ['create'], ['class' => 'btn btn-success'])
        ],
      ],
      'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
      'headerRowOptions'=>['class'=>'default'],
      'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'seksi:ntext',
            'kode',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
