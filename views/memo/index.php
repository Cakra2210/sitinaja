<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MemoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List Memo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="memo-index">
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
              <?= Html::a('Cari', ['/memo/searchmemo'],
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
          <?= Html::a('Clear', ['/memo/index'], ['class'=>'btn btn-warning']) ?>
        </div><!-- /.col-lg-6 -->
      </div><!-- /.row -->
  </div>
  <?php
    $tekscari='';
    if(strlen($cari)>0){$tekscari="Hasil Pencarian Untuk Kata Kunci ".$cari;}
  ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //.'filterModel' => $searchModel,
        'bordered'=>true,
        'striped'=>true,
        'condensed'=>true,
        'responsive'=>true,
        'hover'=>true,
        'panel'=>[
            'type'=>GridView::TYPE_SUCCESS,
            'heading'=>'<i class="glyphicon glyphicon-book"></i>  '.$tekscari
        ],
        'toolbar' => [''],
        'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
        'headerRowOptions'=>['class'=>'default'],
        'filterRowOptions'=>['class'=>'kartik-sheet-style'],
        'persistResize'=>false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
              'label'=>'Pegawai',
              'format'=>'raw',
              'attribute' => 'pegawai',
              'value' => function($dataProvider){
                return Html::a($dataProvider->idPegawai->nama, ['/tugas/rekap', 'id_pegawai' => $dataProvider->idPegawai->id]);
              }
            ],
            [
              'label'=>'Keperluan',
              'format'=>'raw',
              'attribute' => 'keperluan',
              'value' => function($dataProvider){
                return Html::a($dataProvider->keperluan, ['/memo/view', 'id' => $dataProvider->id]);
              }
            ],
            [
              'attribute' => 'jam_keluar',
              'format'=>'raw',
              'label'=>'Jam Keluar',
              'value' => function($dataProvider){
                return $dataProvider->jam_keluar!=null?$dataProvider->jam_keluar:'-';
              }
            ],
            [
              'attribute' => 'jam_pulang',
              'format'=>'raw',
              'label'=>'Jam Pulang',
              'value' => function($dataProvider){
                return $dataProvider->jam_pulang!=null?$dataProvider->jam_pulang:'-';
              }
            ],            
            [
              'attribute' => 'seksi',
              'value' => 'idSeksi.seksi'
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
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
