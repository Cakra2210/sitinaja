<?php

/* @var $this yii\web\View */

$this->title = 'Dashboard Kegiatan';
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\web\JSExpression;
  $pegawai=ArrayHelper::map(\app\models\Pegawai::find()->where(['!=', 'id', 1])->all(), 'id', 'nama');
?>
<script>
  var arraykegiatan=[];
  var arraycolor=[];
  var arraypegawai=[];
  var arrayidpegawai=[];
</script>
<div class="site-index">
<div class="row">
  <div class="col-md-3">
    <div class="box box-solid">
      <div class="box-header with-border">
        <h4 class="box-title">Rekap Kegiatan Pegawai</h4>
      </div>
      <div class="box-body">
        <div id="rekappegawai">
           <?php
            echo Html::dropDownList('droppegawai', null,$pegawai,['class'=>'form-control','prompt'=>'Pilih Pegawai','id'=>'droppegawai']) ;
            echo Html::submitButton('OK', ['class' => 'button btn-success form-control','id'=>'okdroppegawai']) ;
            ?>
        </div>
      </div>
    </div>
    <div class="box box-solid" >
      <div class="box-header with-border">
        <h4 class="box-title">Detail Kegiatan</h4>
      </div>
      <div class="box-body">
        <p id="ketdetailkosong">Letakkan Cursor mouse di kalender kegiatan untuk melihat kegiatan</p>
        <p class="hide"  id="detailcalendar"></p>
      </div>
    </div>
    <div class="box box-solid">
      <div class="box-header with-border">
        <h4 class="box-title">Kegiatan</h4>
      </div>
      <div class="box-body">
        <div id="kegiatan">
        </div>
      </div>
    </div>
    <div class="box box-solid">
      <div class="box-header with-border">
        <h4 class="box-title">Pegawai</h4>
      </div>
      <div class="box-body">
        <div id="pegawai">
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="box box-primary">
      <div class="box-body">
        <?php
          $arraycolor=['#1abc9c','#2ecc71','#3498db','#9b59b6','#34495e',
          '#16a085','#27ae60','#2980b9','#8e44ad','#2c3e50',
          '#f1c40f','#e67e22','#e74c3c','#f39c12','#d35400','#c0392b'
        ];
          $events = array();
          $arraykegiatan= array();
          $arraytglmulai= array();
          foreach($model as $models)
          {
            $col=$arraycolor[array_rand($arraycolor)];
            $pegawai=$models->idPegawai->nama;
            $id_pegawai=$models->id_pegawai;
              $Event = new \yii2fullcalendar\models\Event();
              $Event->id = $models->id;
              $Event->title = '('.$pegawai.') '.$models->kegiatan;
              $Event->start = date('Y-m-d\TH:i:s\Z',strtotime($models->date_start.'T07:00:00Z'));
              $Event->end =  date('Y-m-d\TH:i:s\Z',strtotime($models->date_end.'T23:50:00Z'));
              $Event->color = $col;
              $Event->allDay = true;
              array_push($events,$Event);
              echo "
              <script>
                arraykegiatan.push('".$models->kegiatan."');
                arraycolor.push('".$col."');
              </script>
              ";
            array_push($arraykegiatan,$models->kegiatan);
            array_push($arraytglmulai,$models->date_start);
            echo "
              <script>
                arraypegawai.push('".$pegawai."');
              </script>
            ";
          }
          foreach($harilibur as $libur)
          {
            $Event=new \yii2fullcalendar\models\Event();
            $Event->title = $libur->keterangan;
            $Event->start = date('Y-m-d\TH:i:s\Z',strtotime($libur->tanggal.'T07:00:00Z'));
            $Event->end =  date('Y-m-d\TH:i:s\Z',strtotime($libur->tanggal.'T23:50:00Z'));
            $Event->color = '#c0392b';
            $Event->allDay = true;
            array_push($events,$Event);
          }
        ?>
        <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
          'options' => [
               'lang'=>'id',
             ],
             'clientOptions' => [
                'selectable' => true,
                'eventMouseover'=>new JSExpression("function(calEvent, jsEvent, view) {
                    $(this).css( 'cursor', 'pointer' );
                    $('#detailcalendar').text(calEvent.title);
                    $('#ketdetailkosong').addClass('hide');
                    $('#detailcalendar').removeClass('hide');
                }"),
                'eventMouseout'=>new JSExpression("function(calEvent, jsEvent, view) {
                    $('#detailcalendar').addClass('hide');
                    $('#ketdetailkosong').removeClass('hide');
                }"),
              ],
              'events'=> $events,
              'id'=> 'calendar',
            ));
        ?>
        <?php echo '
          <script>
          var firstdate="'.$firstdate.'";
          </script>
        '?>
      </div>
    </div>
  </div>
</div>
<?php
$this->registerCssFile('@web/css/custom.css');
$this->registerJs(
    '$("document").ready(function(){
      $("#calendar").fullCalendar( "gotoDate", moment(firstdate) );
      arraypegawai.sort();
      arraykegiatan.sort();
      var current = null;
      var currentid = null;
      var current2 = null;
      var currentid2 = null;
      var cnt=0;
      var cnt2=0;
      var currentmonth = $("#calendar").fullCalendar("getDate");
      currentmonth=moment(currentmonth).format("YYYY-MM-DD");
      var lastmonth=moment(currentmonth).subtract(1, "months").endOf("month").format("YYYY-MM-DD");
      var nextmonth=moment(currentmonth).add(1, "months").endOf("month").format("YYYY-MM-DD");
      for(var i=0;i<arraypegawai.length;i++)
      {
        if(arraypegawai[i]!=current){
          if(cnt>0){
              $("#pegawai").append("<div class=\"external-event buttonpegawai\" namapegawai=\""+current+"\" style=\"position:relative;background:#2ecc71;color:#ffffff;cursor:pointer;\">"+current+" ("+cnt+" tugas)</div>");
          }
          current = arraypegawai[i];
          cnt=1;
        }
        else{
          cnt++;
        }
      }
      if(cnt>0){
          $("#pegawai").append("<div class=\"external-event buttonpegawai\"  namapegawai=\""+current+"\" style=\"position:relative;background:#2ecc71;color:#ffffff; cursor:pointer;\">"+current+" ("+cnt+" tugas)</div>");
      }
      for(var i=0;i<arraykegiatan.length;i++)
      {
        if(arraykegiatan[i]!=current2){
          if(cnt2>0){
              $("#kegiatan").append("<div class=\"external-event buttonkegiatan\" style=\"position:relative;background:#d35400;color:#ffffff;cursor:pointer;\">"+current2+"</div>");
          }
          current2 = arraykegiatan[i];
          cnt2=1;
        }
        else{
          cnt2++;
        }
      }
      if(cnt2>0){
          $("#kegiatan").append("<div class=\"external-event buttonkegiatan\" style=\"position:relative;background:#d35400;color:#ffffff;cursor:pointer;\">"+current2+"</div>");
      }
      $(".buttonpegawai").on("click",function(){
        var pegawai=$(this).attr("namapegawai");
        var pathname=window.location.pathname;
        if(pathname.includes("index.php")){
          if(pathname.includes("site")){
            window.location = "../tugas/getidpegawai?nama="+pegawai+"&date="+currentmonth+"";
          }
          if(pathname.includes("index.php/"))
          {
            window.location = "tugas/getidpegawai?nama="+pegawai+"&date="+currentmonth+"";
          }
          else{
            window.location = "index.php/tugas/getidpegawai?nama="+pegawai+"&date="+currentmonth+"";
          }
        }else{
          window.location = "index.php/tugas/getidpegawai?nama="+pegawai+"&date="+currentmonth+"";
        }
      });
      $(".buttonkegiatan").on("click",function(){
        /*
        var kegiatan=$(this).text();
        var pathname=window.location.pathname;
        if(pathname.includes("index.php")){
          if(pathname.includes("site")){
            window.location = "../tugas/searchtugaspribadi?cari="+kegiatan+"";
          }
          else{
            window.location = "tugas/searchtugaspribadi?cari="+kegiatan+"";
          }
        }else{
          window.location = "index.php/tugas/searchtugaspribadi?cari="+kegiatan+"";
        }*/
      });
      $("#okdroppegawai").on("click",function(){
        var pegawai=$("#droppegawai option:selected").text();
        if(pegawai!="Pilih Pegawai")
        {
          var pathname=window.location.pathname;
          if(pathname.includes("index.php")){
            if(pathname.includes("site")){
              window.location = "../tugas/getidpegawai?nama="+pegawai+"&date="+currentmonth+"";
            }
            if(pathname.includes("index.php/"))
            {
              window.location = "tugas/getidpegawai?nama="+pegawai+"&date="+currentmonth+"";
            }
            else{
              window.location = "index.php/tugas/getidpegawai?nama="+pegawai+"&date="+currentmonth+"";
            }
          }else{
            window.location = "index.php/tugas/getidpegawai?nama="+pegawai+"&date="+currentmonth+"";
          }
        }
      });
      $(".fc-prev-button").unbind("click").on("click",function(){
        console.log("prev");
        var pathname=window.location.pathname;
        if(pathname.includes("index.php")){
          if(pathname.includes("site"))
          {
            window.location="changedate?nav=prev&date="+lastmonth+"";
          }
          else if(pathname.includes("index.php/"))
          {
            window.location = "site/changedate?nav=prev&date="+lastmonth+"";
          }
          else{
            window.location="index.php/site/changedate?nav=prev&date="+lastmonth+"";
          }
        }
        else{
          window.location="index.php/site/changedate?nav=prev&date="+lastmonth+"";
        }
        return false;
      });
      $(".fc-next-button").unbind("click").on("click",function(){
        var pathname=window.location.pathname;
        if(pathname.includes("index.php")){
          if(pathname.includes("site"))
          {
            window.location="changedate?nav=next&date="+nextmonth+"";
          }
          else if(pathname.includes("index.php/"))
          {
            window.location = "site/changedate?nav=next&date="+nextmonth+"";
          }
          else{
            window.location="index.php/site/changedate?nav=next&date="+nextmonth+"";
          }
        }
        else{
          window.location="index.php/site/changedate?nav=next&date="+nextmonth+"";
        }
      });
      $(".fc-today-button").unbind("click").on("click",function(){
        window.location="../";
      });
    });'
);
?>
