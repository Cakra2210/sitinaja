<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tugas */

$this->title = '';

?>

<div class="tugas-view">

    <div class="box box-solid box-info">
      <div class="box-header">
        <h3 class="box-title">Rekap Absen</h3>

      </div>
      <div class="box-body" id="attendancereport">
        <h4 class="text-center">Attendance Report</h4>
        <div class="row">
          <div class="col-md-6">
            Name : <?= $pegawai->nama?>
          </div>
          <div class="col-md-6">
            Organization : <?= $config->satker?>
          </div>
        </div>
        <br>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Day</th>
              <th>Date</th>
              <th>Working Hour</th>
              <th>Activity</th>
              <th>Duty On</th>
              <th>Break Out</th>
              <th>Break In</th>
              <th>Duty Off</th>
              <th>Late In</th>
              <th>Early Dept</th>
              <th>OT Before</th>
              <th>OT After</th>
              <th>Total Hour</th>
              <th>Notes</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $arraykirimcontroller=array();
            $arraytanggal=array();
            $arrayjam=array();
            $arraytanggalkeluar=array();
            $arrayjamkeluar=array();
            $arraytanggalkegiatan=array();
            $arraykegiatan=array();
            $arraytanggallibur=array();
            $arrayketeranganlibur=array();
            foreach($dataabsen->Row as $data)
            {
              $date=date('d-m-Y',strtotime($data->DateTime));
              $clock=date('H:i:s',strtotime($data->DateTime));
              $arraycount=count(array_keys($arraytanggalkeluar, $date));
              if($arraycount>0)
              {
                $key=array_search($date,$arraytanggalkeluar);
                $arrayjamkeluar[$key]=$clock;
              }
              else{
                array_push($arrayjamkeluar,$clock);
                array_push($arraytanggalkeluar,$date);
              }
              array_push($arraytanggal,$date);
              array_push($arrayjam,$clock);
            }
            foreach($modelTugas as $data)
            {
              if($data->blok_absen==1)
              {
                if($data->date_start==$data->date_end)
                {
                    array_push($arraytanggalkegiatan,date('d-m-Y', strtotime($data->date_start)));
                    array_push($arraykegiatan,$data->kegiatan);
                }
                else{
                  $start = new \DateTime(date('Y-m-d', strtotime($data->date_start)));
                  $end = new \DateTime(date('Y-m-d', strtotime($data->date_end. "+1 days")));
                  $diff = \DateInterval::createFromDateString('1 day');
                  $period = new \DatePeriod($start, $diff, $end);
                  foreach($period as $d)
                  {
                    array_push($arraytanggalkegiatan,$d->format('d-m-Y'));
                    array_push($arraykegiatan,$data->kegiatan);
                  }
                }
              }
            }


            foreach ( $harilibur as $data )
            {
              array_push($arraytanggallibur,date('d-m-Y', strtotime($data->tanggal)));
              array_push($arrayketeranganlibur,$data->keterangan);
            }
            $hitung=0;
            foreach ( $periodStart as $dayDate ){
              $activity='Work';
              if($dayDate->format( "D" )=='Sat'||$dayDate->format( "D" )=='Sun')
              {
                $activity='<p class="text-danger">Off</p>';
              }
              $key=array_search($dayDate->format( "d-m-Y" ),$arraytanggal);
              $keyoff=array_search($dayDate->format( "d-m-Y" ),$arraytanggalkeluar);
              $keykegiatan=array_search($dayDate->format( "d-m-Y"),$arraytanggalkegiatan);
              $keylibur=array_search($dayDate->format("d-m-Y"),$arraytanggallibur);
              $dutyon='';
              $dutyoff='';
              $notes='';
              if($key!==false)
              {
                $dutyon=$arrayjam[$key];
              }
              if($keyoff!==false)
              {
                $dutyoff=$arrayjamkeluar[$keyoff];
              }
              if($keykegiatan!==false)
              {
                $notes=$arraykegiatan[$keykegiatan];
                $activity='Perjalanan Dinas';
              }
              if($keylibur!==false)
              {
                $notes=$arrayketeranganlibur[$keylibur];
                $activity='<p class="text-danger">Hari Libur</p>';
              }
              $total      = strtotime($dutyoff) - strtotime($dutyon);
              $hours      = floor($total / 60 / 60);
              $minutes    = round(($total - ($hours * 60 * 60)) / 60);
              $minutes=strlen($minutes)==1?'0'.$minutes:$minutes;
              $hours=strlen($hours)==1?'0'.$hours:$hours;
              $totalhour=$hours.':'.$minutes;
              if($minutes=='00'&&$hours=='00'&&strlen($dutyon)==0)
              {
                $minutes='';
                $hours='';
                $totalhour='';
              }
              if($totalhour==''&&$activity=='Work'&&strlen($dutyon)==0)
              {
                $activity='<p class="text-danger">Absent</p>';
              }
              $shifthour=$shift['hari'.date('w',strtotime($dayDate->format( "D" )))];
              $late='';
              if(!strlen($shifthour>0)||$keylibur!==false)
              {
                $shifthour='<p class="text-danger">Off</p>';
              }else{
                $shifthoursplit=explode('-',$shifthour);
                if(strtotime($dutyon) - strtotime($shifthoursplit[0])>=0)
                {
                  $t      = strtotime($dutyon) - strtotime($shifthoursplit[0]);
                  $h      = floor($t / 60 / 60);
                  $m    = round(($t - ($h * 60 * 60)) / 60);
                  $m=strlen($m)==1?'0'.$m:$m;
                  $h=strlen($h)==1?'0'.$h:$h;
                  $thour=$h.':'.$m;
                  $late=$thour;
                  $late='<p class="text-danger">'.$late.'</p>';
                  $dutyon='<p class="text-danger">'.$dutyon.'</p>';
                }
              }
              if(strlen($notes)>0)
              {
                $dutyon='';
                $dutyoff='';
                $late='';
                $totalhour='';
              }
              echo '
              <tr>
              <td>'.$dayDate->format( "l\n" ).'</td>
              <td>'.$dayDate->format( "d-m-Y\n" ).'</td>
              <td>
              '.$shifthour.'
              </td>
              <td>'.$activity.'</td>';

              echo'
              <td>'.$dutyon.'</td>
              <td></td>
              <td></td>
              <td>'.$dutyoff.'</td>
              <td>'.$late.'</td>
              <td></td>
              <td></td>
              <td></td>
              <td>'.$totalhour.'</td>
              <td>'.$notes.'</td>
              </tr>';

              array_push($arraykirimcontroller,
                array(
                  $dayDate->format( "l\n" ),//hari
                  $dayDate->format( "d-m-Y\n" ),//tanggal
                  $shifthour,
                  $activity,
                  $dutyon,
                  $dutyoff,
                  $late,
                  $totalhour,
                  $notes
                ));

              $hitung++;
            }
            ?>
          </tbody>
        </table>

      </div>
      <div style="padding:20px; width:20%;">
      <?php
        echo Html::a('<span class="fa fa-print"> Print PDF</span>',
        ['tugas/printrekap'],
        [
          'class' => 'btn btn-success form-control',
          'id'=>'okdroppegawai',
          'data-method'=>'POST',
          'target'=>'_blank',
          'data-params'=>[
            'data'=>json_encode($arraykirimcontroller),
            'name'=>$pegawai->nama,
            'organization'=> $config->satker,
          ],
        ]);?>
      </div>
  </div>

</div>
<?php
$this->registerJs(
  '
  var isi='.$autoclickprintpdf.';
  $("document").ready(function(){
    if(isi==1)
    {
      $("#okdroppegawai").attr("target","");
      $("#okdroppegawai").click();
    }
  });
  '
);
?>
