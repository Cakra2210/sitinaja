<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
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
                <?= Html::a('Cari', ['/tugas/searchtugaspribadi'],
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
            <?= Html::a('Clear', ['/tugas/listtugas'], ['class'=>'btn btn-warning']) ?>
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
            'heading'=>'<i class="glyphicon glyphicon-book"></i>  '.$tekscari
        ],
        'toolbar' =>[''],
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
                return Html::a($dataProvider->kegiatan, ['/tugas/view', 'id' => $dataProvider->id]);
              }
            ],
            [
              'label'=>'Pegawai',
              'format'=>'raw',
              'attribute' => 'pegawai',
              'value' => function($dataProvider){
                return Html::a($dataProvider->idPegawai->nama, ['/pegawai/view', 'id' => $dataProvider->idPegawai->id]);
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
                'template' => '{print} {update} {delete}',
                'buttons' => [
                    'print' => function ($url,$model) {
                      return Html::a('<span class="glyphicon glyphicon-print"></span>', ['report','id_tugas' => $model->id,'id_pegawai'=>$model->idPegawai->id,'kolektif'=>'0']);
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
                ]
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
