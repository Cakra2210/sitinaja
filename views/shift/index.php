<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Shift */
/* @var $form ActiveForm */

$this->title = 'Shift';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jabatan-index">

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
            Html::a('Tambah Shift', ['create'], ['class' => 'btn btn-success'])
          ],
        ],
        'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
        'headerRowOptions'=>['class'=>'default'],
        'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nama_shift:ntext',
            'hari1',
            'hari2',
            'hari3',
            'hari4',
            'hari5',
            'hari6',
            'hari0',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
