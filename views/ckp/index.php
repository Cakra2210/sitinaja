<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use yii\web\View;
use yii\web\JSExpression;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CkpSearc */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cetak CKP';
$this->params['breadcrumbs'][] = $this->title;
$pegawai = ArrayHelper::map(\app\models\Pegawai::find()->where(['!=', 'id', 1])->all(), 'id', 'nama');
$seksi=ArrayHelper::map(\app\models\Seksi::find()->all(), 'id', 'seksi');
$artahun = ArrayHelper::map($tahun,'year','year');
$idpegawai= $cek=="1" ? $id_pegawai : "0";

  $bl;
  if(isset($bulan)){
    $bl=$bulan;
  }else{
    $bl=1;
  }

?>
<div class="ckp-index">
  <div class="box box-solid box-success">
    <div class="box-header with-border">
      <h4 class="box-title">Pilih Pegawai dan Bulan</h4>
    </div>
    <div class="box-body">

      <div class="row">
        <div class="col-lg-3">
          <label for="pegawai" class="control-label">Pegawai</label>
          <?= Html::dropDownList('pegawai', null, $pegawai, ['class' => 'form-control', 'id' => 'droppegawai','prompt'=>'--Pilih Pegawai--']) ?>
        </div>
        <div class="col-lg-3">
          <label for="bulan" class="control-label">Bulan</label>
          <?= Html::dropDownList('bulan', null,
          ['1'=>'Januari',
          '2'=>'Februari',
          '3'=>'Maret',
          '4'=>'April',
          '5'=>'Mei',
          '6'=>'Juni',
          '7'=>'Juli',
          '8'=>'Agustus',
          '9'=>'September',
          '10'=>'Oktober',
          '11'=>'November',
          '12'=>'Desember'
        ]
          , ['class' => 'form-control', 'id' => 'dropbulan','prompt'=>'--Pilih Bulan--']) ?>
        </div>
        <div class="col-lg-3">
          <label for="tahun" class="control-label">Tahun</label>
          <?= Html::dropDownList('year', null, $artahun
          , ['class' => 'form-control', 'id' => 'droptahun']) ?>
        </div>
        <div class="col-lg-3">
          <label for="Ok" class="control-label"> </label>
          <?= Html::submitButton('Ok', ['class' => 'button btn-success form-control','id'=>'okckp']) ; ?>
        </div>
      </div>

    </div>
  </div>
  <div class="box box-solid" >
    <div class="box-body">
      <table class="table table-striped" id="tabelckp">
        <thead>
          <tr>
          <th rowspan="2">No</th>
          <th rowspan="2">Uraian Kegiatan</th>
          <th rowspan="2">Satuan</th>
          <th colspan="3">Target Kuantitas</th>
          <th rowspan="2">Tingkat Kualitas(%)</th>
          <th rowspan="2">Kode Butir Kegiatan</th>
          <th rowspan="2">Angka Kredit</th>
          <th rowspan="2">Keterangan</th>
          </tr>
          <tr>
          <td>Target</td>
          <td>Realisasi</td>
          <td>(%)</td>
          </tr>
        </thead>
        <tbody>
          <?php if($cek=='1'){
            $no=1;

            foreach($model as $models)
            {
              $persentase=0;
              if($models['target']!=0 && $models['realisasi']!=0)
              {
                $persentase = 100*($models['realisasi']/$models['target']);
              }
              echo '<tr>';
              echo '<td name="idkegiatan" hidden>'.$models['id_tugas'].'</td>';
              echo '<td name="idckp" hidden>'.$models['id_ckp'].'</td>';
              echo '<td>'.$no.'</td>';
              echo '<td>'.$models['kegiatan'].'</td>';
              echo '<td><input name="satuan" type="text" style="width:100%" value='.$models['satuan'].'></input></td>';
              echo '<td><input name="target" type="text" style="width:100%" value='.$models['target'].'></input></td>';
              echo '<td><input name="realisasi" type="text" style="width:100%" value='.$models['realisasi'].'></input></td>';
              echo '<td name="persen"><p style="width:100%">'.$persentase.'</p></td>';
              echo '<td><input name="tingkatkualitas" type="text" style="width:100%" value='.$models['kualitas'].'></input></td>';
              echo '<td><input name="kodebutirkegiatan" type="text" style="width:100%" value='.$models['kd_butir'].'></input></td>';
              echo '<td><input name="angkakredit" type="text" style="width:100%" value='.$models['angka_kredit'].'></input></td>';
              echo '<td><input name="keterangan" type="text" style="width:100%" value='.$models['keterangan'].'></input></td>';
              echo '<td><button name="buttonhapus" style="width:100%" class="buttonhapus button btn-danger" value='.$models['id_tugas'].'>X</button></td>';
              echo '</tr>';
              $no++;
            }
          }
          ?>
        </tbody>
      </table>
      <div class="row">
        <div class="col-lg-6"></div>
        <div class="col-lg-2">
        <?= Html::submitButton('<i class="fa fa-plus-circle"></i>  Input Kegiatan',
        [
          'class' => 'button btn-info form-control',
          'id'=>'inputkegiatan',
          'style'=>[
            'float'=>'right'
            ]
        ]) ; ?>
        </div>
        <div class="col-lg-2">
        <?= Html::submitButton('<i class="fa fa-save"></i>  Simpan',
        [
          'class' => 'button btn-success form-control',
          'id'=>'simpankegiatan',
          'style'=>[
            'float'=>'right'
            ]
        ]) ; ?>
          </div>

          <div class="col-lg-2">
          <?= Html::a('<p class="text-center"><i class="fa fa-print "></i>  Cetak</p>',
                  [
                    'ckp/cetak',
                    'bulan' => $bl,
                    'pegawai'=> $idpegawai,
                    'tahun'=> $th,
                  ],
                  [
                    'class' => 'button btn-primary form-control',
                    'target'=>'_blank',
                  ]) ?>
          </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="modalinput">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Input Kegiatan</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-lg-2">
              <p class="text-center"><strong>Kegiatan</strong></p>
            </div>
            <div class="col-lg-10">
              <input type="text" class="form-control" name="kegiatan" id="mkegiatan"></input>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-2">
              <p class="text-center"><strong>Pelaksanaan</strong></p>
            </div>
            <div class="col-lg-5">
              <?php
              echo DatePicker::widget([
                'model' => null,
                'attribute' => 'date_start',
                'dateFormat' => 'yyyy-MM-dd',
                'name'=> 'date_start',
                'value'=>date('Y-m-d'),
                'options' => [
                  'class' => 'form-control',
                  'id'=>'mdatestart',
                  ]
                ]);?>
            </div>
            <div class="col-lg-5">
              <?php
              echo DatePicker::widget([
                'model' => null,
                'attribute' => 'date_end',
                'dateFormat' => 'yyyy-MM-dd',
                'name'=> 'date_end',
                'value'=>date('Y-m-d'),
                'options' => [
                  'class' => 'form-control',
                  'id'=>'mdateend',
                  ]
                ]);?>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-2">
              <p class="text-center"><strong>Satuan</strong></p>
            </div>
            <div class="col-lg-10">
              <input type="text" class="form-control" name="satuan" id="msatuan"></input>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-2">
              <p class="text-center"><strong>Target</strong></p>
            </div>
            <div class="col-lg-10">
              <input type="text" class="form-control" name="target" id="mtarget"></input>
            </div>
          </div>
            <br><div class="row">
            <div class="col-lg-2">
              <p class="text-center"><strong>Realisasi</strong></p>
            </div>
            <div class="col-lg-10">
              <input type="text" class="form-control" name="realisasi" id="mrealisasi"></input>
            </div>
          </div>
            <br><div class="row">
            <div class="col-lg-2">
              <p class="text-center"><strong>Tingkat Kualitas</strong></p>
            </div>
            <div class="col-lg-10">
              <input type="text" class="form-control" name="tingkatkualitas" id="mtingkatkualitas"></input>
            </div>
          </div>
            <br><div class="row">
        </div>
          <div class="row">
            <div class="col-lg-2">
              <p class="text-center"><strong>Kode</strong></p>
            </div>
            <div class="col-lg-10">
              <input type="text" class="form-control" name="kodebutirkegiatan" id="mkodebutirkegiatan"></input>
            </div></div>
            <br><div class="row">
            <div class="col-lg-2">
              <p class="text-center"><strong>AK</strong></p>
            </div>
            <div class="col-lg-10">
              <input type="text" class="form-control" name="angkakredit" id="mangkakredit"></input>
            </div></div>
            <br><div class="row">
            <div class="col-lg-2">
              <p class="text-center"><strong>Keterangan</strong></p>
            </div>
            <div class="col-lg-10">
              <input type="text" class="form-control" name="keterangan" id="mketerangan"></input>
            </div></div>
            <br><div class="row">
            <div class="col-lg-2">
              <p class="text-center"><strong>Seksi</strong></p>
            </div>
            <div class="col-lg-10">
              <?= Html::dropDownList('seksi', null, $seksi, ['class' => 'form-control', 'id' => 'mdropseksi']) ?>
            </div>
            <br><br>
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary"  id="msimpan">Simpan</button>
      </div>
    </div>
  </div>
</div>

<input id="idp" value="<?= $idpegawai ?>" hidden></input>
<input id="hiddenbulan" value="<?= $bl ?>" hidden></input>
<?php
  $this->registerJsFile(
    '@web/sweetalert.js',
    [
      'depends'=>[\yii\web\JqueryAsset::className()]
    ]
  );
  $this->registerJs(
    '$("document").ready(function(){
      $("#mdatestart").datepicker();
      var pegawai;
      var idp = $("#idp").val();
      var hiddenbulan = $("#hiddenbulan").val();
      if(idp!="0")
      {
          $("#droppegawai").val(idp);
          $("#dropbulan").val(hiddenbulan);
      }
      $("#simpankegiatan").on("click",function(){
        swal({
          title: "Are yakin?",
          text: "Anda Akan Menyimpan Data Ini",
          icon: "info",
          buttons: true,
          dangerMode: false,
        })
        .then((willDelete) => {
          if (willDelete) {
            swal("Tersimpan", {
              icon: "success",
            });
            pegawai=$("#droppegawai option:selected").val();
            var bulan=$("#dropbulan option:selected").val();
            var aidkegiatan=[];
            var aidckp=[];
            var asatuan=[];
            var atarget=[];
            var arealisasi=[];
            var atingkatkualitas=[];
            var akodebutirkegiatan=[];
            var aangkakredit=[];
            var aketerangan=[];
            $("#tabelckp tbody tr").each(function(){
              var idkegiatan=$(this).find("td[name=\"idkegiatan\"]").html();
              var idckp=$(this).find("td[name=\"idckp\"]").html();
              var satuan=$(this).find("input[name=\"satuan\"]").val();
              var target=$(this).find("input[name=\"target\"]").val();
              var realisasi=$(this).find("input[name=\"realisasi\"]").val();
              var tingkatkualitas=$(this).find("input[name=\"tingkatkualitas\"]").val();
              var kodebutirkegiatan=$(this).find("input[name=\"kodebutirkegiatan\"]").val();
              var angkakredit=$(this).find("input[name=\"angkakredit\"]").val();
              var keterangan=$(this).find("input[name=\"keterangan\"]").val();
              aidkegiatan.push(idkegiatan);
              aidckp.push(idckp);
              asatuan.push(satuan);
              atarget.push(target);
              arealisasi.push(realisasi);
              atingkatkualitas.push(tingkatkualitas);
              akodebutirkegiatan.push(kodebutirkegiatan);
              aangkakredit.push(angkakredit);
              aketerangan.push(keterangan);
            });

            $.ajax({
              url:"simpan",
              type:"get",
              data:{
                idkegiatan: JSON.stringify(aidkegiatan),
                idckp : JSON.stringify(aidckp),
                satuan: JSON.stringify(asatuan),
                target: JSON.stringify(atarget),
                realisasi: JSON.stringify(arealisasi),
                tingkatkualitas : JSON.stringify(atingkatkualitas),
                kodebutirkegiatan: JSON.stringify(akodebutirkegiatan),
                angkakredit: JSON.stringify(aangkakredit),
                keterangan: JSON.stringify(aketerangan),
                pegawai: pegawai,
                bulan: bulan,
              },
              success: function(response)
              {
                  console.log(response);
              }
            });
          } else {
            swal("Your imaginary file is safe!");
          }
        });

      });

      $("#tabelckp").on("change", "input[name=\"target\"]", function(){
          var target=$(this).val();
          var realisasihtml=$(this).parent().next("td").find("input");
          rval=realisasihtml.val();
          if(rval.length==0){rval=0;}
          var persen=rval/target*100;
          var htmlpersen=realisasihtml.parent().next("td");
          htmlpersen.html(persen.toFixed(2)+"%");
      });

      $("#tabelckp").on("change", "input[name=\"realisasi\"]", function(){
          var realisasi=$(this).val();
          var targethtml=$(this).parent().prev("td").find("input");
          tval=targethtml.val();
          var htmlpersen=$(this).parent().next("td");
          if(tval.length!=0){
            var persen=realisasi/tval*100;
            htmlpersen.html(persen.toFixed(2)+"%");
          }else{
            htmlpersen.html("-");
          }

      });

      $("#msimpan").on("click",function(){
        pegawai=$("#droppegawai option:selected").val();
        var bulan=$("#dropbulan option:selected").val();
        var kegiatan = $("#mkegiatan").val();
        var satuan = $("#msatuan").val();
        var target = $("#mtarget").val();
        var realisasi = $("#mrealisasi").val();
        var tingkatkualitas = $("#mtingkatkualitas").val();
        var kodebutirkegiatan = $("#mkodebutirkegiatan").val();
        var angkakredit = $("#mangkakredit").val();
        var keterangan = $("#mketerangan").val();
        var assignee = $("#mdropseksi").val();
        var date_start = $("#mdatestart").val();
        var date_end = $("#mdateend").val();
        var persen=0;

        $("#modalinput").modal("hide");
        $.ajax({
          url:"simpantugasckp",
          type:"get",
          data:{
            kegiatan: kegiatan,
            satuan: satuan,
            target: target,
            realisasi: realisasi,
            tingkatkualitas : tingkatkualitas,
            kodebutirkegiatan: kodebutirkegiatan,
            angkakredit: angkakredit,
            keterangan:keterangan,
            pegawai: pegawai,
            assignee: assignee,
            bulan: bulan,
            date_start: date_start,
            date_end: date_end,
          },
          success: function(response)
          {
            var lastnumber=$("#tabelckp tr:last").find("td[name=\"idckp\"]").next().html();
            lastnumber=parseInt(lastnumber)+1;
            var x=JSON.parse(response);
            $("#tabelckp > tbody:last-child").append("<tr><td name=\"idkegiatan\" hidden>"+x["id_tugas"]+"</td><td name=\"idckp\" hidden>"+x["id_ckp"]+"</td><td>"+lastnumber+"</td><td>"+kegiatan+"</td><td><input name=\"satuan\" type=\"text\" style=\"width:100%\" value="+satuan+"></input></td><td><input name=\"target\" type=\"text\" style=\"width:100%\" value="+target+"></input></td><td><input name=\"realisasi\" type=\"text\" style=\"width:100%\" value="+realisasi+"></input></td><td>"+persen+"</td><td><input name=\"tingkatkualitas\" type=\"text\" style=\"width:100%\" value="+tingkatkualitas+"></input></td><td><input name=\"kodebutirkegiatan\" type=\"text\" style=\"width:100%\" value="+kodebutirkegiatan+"></input></td><td><input name=\"angkakredit\" type=\"text\" style=\"width:100%\" value="+angkakredit+"></input></td><td><input name=\"keterangan\" type=\"text\" style=\"width:100%\" value="+keterangan+"></input></td><td><button name=\"buttonhapus\" style=\"width:100%\" class=\"buttonhapus button btn-danger\">X</button></td></tr>");
            $("#mkegiatan").val("");
            $("#msatuan").val("");
            $("#mtarget").val("");
            $("#mrealisasi").val("");
            $("#mtingkatkualitas").val("");
            $("#mkodebutirkegiatan").val("");
            $("#mangkakredit").val("");
            $("#mketerangan").val("");
          }
        });
        return false;
      });

      $("#inputkegiatan").on("click",function(){
        $("#modalinput").modal("show");
      });
      $("#okckp").on("click",function(){
        pegawai=$("#droppegawai option:selected").val();
        var bulan=$("#dropbulan option:selected").val();
        var tahun=$("#droptahun option:selected").val()
        var pathname=window.location.pathname;
        window.location="/sims/web/index.php/ckp/tampilckp?id="+pegawai+"&bulan="+bulan+"&tahun="+tahun+"";

      });

      $(".buttonhapus").on("click",function(){
        var id_tugas=$(this).val();
        var rows=$(this).parent().parent();
        swal({
          title: "Anda Yakin?",
          text: "Anda Akan Menghapus Kegiatan Ini",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          $.ajax({
            url:"hapusitemckp",
            type:"get",
            data:{
              id_tugas : id_tugas,
            },
            success: function(response)
            {
              console.log(response);

              if (willDelete) {
                rows.remove();
                swal("Kegiatan Dihapus", {
                  icon: "success",
                });
              } else {

              }
            }
          });

        });


      })
    });'
    )
 ?>
