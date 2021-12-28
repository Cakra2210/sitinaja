<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TugasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Tugas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tugas-index">
  <div class="box box-solid box-success">
    <div class="box-header with-border">
      <h4 class="box-title">Cari <?= $cari?></h4>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-lg-11">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Kata Kunci" id="inputcari" value="<?=$cari?>">
            <span class="input-group-btn">
              <?= Html::a('Cari', ['/tugas/searchtugaskolektif'],
              [
                'id'=>'buttoncari',
                'class'=>'btn btn-success',
                'data-method'=>'GET',
                'data-params'=>[
                  'cari'=>$cari,
                ],
              ]) ?>
            </span>
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-1">
          <?= Html::a('Clear', ['/tugas/listtugaskolektif'], ['class'=>'btn btn-warning']) ?>
        </div><!-- /.col-lg-6 -->
      </div><!-- /.row -->
  </div>
  <?php
    $tekscari='';
    if(strlen($cari)>0){$tekscari="Hasil Pencarian Untuk Kata Kunci ".$cari;}
  ?>
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
            'heading'=>'<i class="glyphicon glyphicon-book"></i>  '.$tekscari,
        ],
        'toolbar' => [''],
        'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
        'headerRowOptions'=>['class'=>'default'],
        'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        'persistResize'=>false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
              'label'=>'Kegiatan',
              'format'=>'raw',
              'attribute' => 'kegiatan',
              'value' => function($dataProvider){
                return Html::a($dataProvider->kegiatan, ['/tugas/viewkolektif', 'groupid' => $dataProvider->id_group]);
              }
            ],
            'destinasi:ntext',
            [
              'attribute' => 'seksi',
              'value' => 'idAssignee.seksi'
            ],
            'date_start',
            'date_end',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => ' {delete} {update}',
                'buttons' => [
                    'view' => function($url,$model){
                      return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                        ['viewkolektif','groupid' => $model->id_group]
                      );
                    },
                    'delete' => function($url,$model){
                      return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                        ['deletekolektif','groupid' => $model->id_group]
                      );
                    },

                    'update' => function($url,$model){
                      return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                        ['editkolektif','groupid' => $model->id_group]
                      );
                    },
                ],
                'visibleButtons'=>[
                  'update'=>function ($model, $key, $index) {
                    if(Yii::$app->user->id!=1)
                    {
                      return Yii::$app->myHelper->isKepalaseksi(Yii::$app->user->identity->id_jabatan);
                    }
                    else {
                      return true;
                    }
                  },
                  'delete'=>function ($model, $key, $index) {
                    if(Yii::$app->user->id!=1)
                    {
                      return Yii::$app->myHelper->isKepalaseksi(Yii::$app->user->identity->id_jabatan);
                    }
                    else {
                      return true;
                    }
                  },
                ],
            ],
        ],
    ]); ?>
</div>
<?php
$this->registerJs('
$("#inputcari").on("input",function(e){
  if($(this).data("lastval")!= $(this).val()){
    $(this).data("lastval",$(this).val());
    //change action
    $("#buttoncari").attr("data-params","{\"cari\":\""+$(this).val()+"\"}");
  };
});
$("#inputcari").keypress(function (e) {
 var key = e.which;
 if(key == 13)
  {
    $("#buttoncari").click();
    return false;
  }
});
'
)
?>
