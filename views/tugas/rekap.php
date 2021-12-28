<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TugasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekap Pekerjaan';
$this->params['breadcrumbs'][] = $this->title;
?>
<script>
  var arraykegiatan=[];
  var arraycolor=[];
  var arraymemo=[];
  var arrayijincuti=[];

</script>
<?php

?>
<div class="rekap-index">
  <div class="row">
    <div class="col-md-3">
      <div class="box box-solid  box-info">
        <div class="box-header with-border">
          <h4 class="box-title"><?= $pegawai->nama ?></h4>
        </div>
        <div class="box-body">
            <?php echo Html::a('<span class="fa fa-magic"> Rekap Absen</span>',
            ['tugas/rekapabsen'],
            [
              'class' => 'button btn-success form-control',
              'id'=>'okdroppegawai',
              'data-method'=>'POST',
              'data-params'=>[
                'dx1'=>'dx2',
                'id_pegawai'=>$pegawai->id,
                'dataabsen'=>json_encode($dataabsen),                
              ],
            ]);?>
            <div class="box-header with-border">
              <h4 class="box-title">Tugas</h4>
            </div>
            <div class="box-body">
              <div id="kegiatan">
              </div>
            </div>
            <div class="box-header with-border">
              <h4 class="box-title">Memo</h4>
            </div>
            <div class="box-body">
              <div id="memo">
              </div>
            </div>
            <div class="box-header with-border">
              <h4 class="box-title">Ijin/Cuti</h4>
            </div>
            <div class="box-body">
              <div id="ijincuti">
              </div>
            </div>

        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="box box-primary">
        <div class="box-body">
    <?php
      $events = array();
      $arrayhari = array();
      try
      {
        foreach($dataabsen->Row as $data)
        {
          $Event = new \yii2fullcalendar\models\Event();
          $Event->title = 'Absen';
          $Event->start = date('Y-m-d\TH:i:s\Z',strtotime($data->DateTime));
          $Event->end =  date('Y-m-d\TH:i:s\Z',strtotime($data->DateTime));
          $Event->color = '#27ae60';

          array_push($events,$Event);
        }
      }
      catch(Exception $e)
      {
        //print_r('error');
      }
      foreach($modelholiday as $models)
      {
        $Event = new \yii2fullcalendar\models\Event();
        $Event->id = $models->id;
        $Event->title = $models->keterangan;
        $Event->start = date('Y-m-d\TH:i:s\Z',strtotime($models->tanggal.'T07:00:00Z'));
        $Event->end =  date('Y-m-d\TH:i:s\Z',strtotime($models->tanggal.'T23:50:00Z'));
        $Event->color = '#c0392b';
        $Event->allDay = true;
        array_push($events,$Event);
      }

      foreach($model as $models)
      {
        $Event = new \yii2fullcalendar\models\Event();
        $Event->id = $models->id;
        $Event->title = $models->kegiatan;
        $Event->start = date('Y-m-d\TH:i:s\Z',strtotime($models->date_start.'T07:00:00Z'));
        $Event->end =  date('Y-m-d\TH:i:s\Z',strtotime($models->date_end.'T23:50:00Z'));
        $Event->color = '#9b59b6';
        $Event->allDay = true;
        array_push($events,$Event);
        echo "
        <script>
          arraykegiatan.push('".$models->kegiatan."');
        </script>
        ";
      }

      foreach($modelijincuti as $models)
      {
        $Event = new \yii2fullcalendar\models\Event();
        $Event->id = $models->id;
        if($models->iscuti==1)
        {
          $Event->title='Cuti';
        }else{
          $Event->title='Ijin';
        }
        $Event->start = date('Y-m-d\TH:i:s\Z',strtotime($models->date_start.'T07:00:00Z'));
        $Event->end =  date('Y-m-d\TH:i:s\Z',strtotime($models->date_end.'T15:00:00Z'));
        $Event->color = '#c0392b';
        $Event->allDay = true;
        array_push($events,$Event);
        $keperluan=$models->keperluan;
        if(strlen($models->keperluan)==0)
        {
          $keperluan='Cuti';
        }
        echo "
        <script>
          arrayijincuti.push('".$keperluan."');
        </script>
        ";
      }

      foreach($modelmemo as $models)
      {
        $Event = new \yii2fullcalendar\models\Event();
        $Event->id = $models->id;
        $Event->title='Memo';
        $date_start=$models->jam_keluar;
        $date_end=$models->jam_pulang;
        if(strlen($date_end)==0)
        {
          $date_end=$date_start;
        }

        if(strlen($date_start=NULL)==0)
        {
          $date_start=$date_end;
        }
        $Event->start = date('Y-m-d\TH:i:s\Z',strtotime($date_start));
        $Event->end =  date('Y-m-d\TH:i:s\Z',strtotime($date_end));
        $Event->color = '#9b59b6';
        array_push($events,$Event);
        echo "
        <script>
          arraymemo.push('".$models->keperluan."');
        </script>
        ";
      }

    ?>
    <?= \yii2fullcalendar\yii2fullcalendar::widget(array(

          'events'=> $events,
          'id'=>'calendar',
          'options'=>[
              'lang'=>'id',
            ],
        ));
    ?>
  </div>
</div>
</div>
</div>

<?php
  $this->registerCssFile('@web/css/custom.css');
  $this->registerJs(
    '
    for(var i=0;i<arraykegiatan.length;i++)
    {
      $("#kegiatan").append("<div class=\"external-event\" style=\"position:relative;background:#9b59b6;color:#ffffff;cursor:pointer;\">"+arraykegiatan[i]+"</div>");
    }
    for(var i=0;i<arrayijincuti.length;i++)
    {
      $("#ijincuti").append("<div class=\"external-event\" style=\"position:relative;background:#c0392b;color:#ffffff;cursor:pointer;\">"+arrayijincuti[i]+"</div>");
    }
    for(var i=0;i<arraymemo.length;i++)
    {
      $("#memo").append("<div class=\"external-event\" style=\"position:relative;background:#9b59b6;color:#ffffff;cursor:pointer;\">"+arraymemo[i]+"</div>");
    }
    var tempActiveDate;
    var today=$("#calendar").fullCalendar("getDate");
    today=moment(today).format("YYYY-MM-DD");
    $("#okdroppegawai").attr("data-params", function(i, origValue){
      var activeDate = $("#calendar").fullCalendar("getDate");
      activeDate = moment(activeDate).format("YYYY-MM-DD");
       var temp=origValue.replace("dx1","tanggal");
       temp=temp.replace("dx2",activeDate);
       tempActiveDate=activeDate;
       return temp;
    });

    $(".fc-prev-button").on("click",function(){
      var activeDate = $("#calendar").fullCalendar("getDate");
      activeDate = moment(activeDate).format("YYYY-MM-DD");
      $("#okdroppegawai").attr("data-params", function(i, origValue){
         var temp=origValue.replace(tempActiveDate,activeDate);
         tempActiveDate=activeDate;
         return temp;
      });
    });

    $(".fc-next-button").on("click",function(){
      var activeDate = $("#calendar").fullCalendar("getDate");
      activeDate = moment(activeDate).format("YYYY-MM-DD");
      $("#okdroppegawai").attr("data-params", function(i, origValue){
         var temp=origValue.replace(tempActiveDate,activeDate);
         tempActiveDate=activeDate;
         return temp;
      });
    });

    $(".fc-today-button").on("click",function(){
      $("#okdroppegawai").attr("data-params", function(i, origValue){
         var temp=origValue.replace(tempActiveDate,today);
         tempActiveDate=today;
         return temp;
      });
    });
    '
  );
 ?>
