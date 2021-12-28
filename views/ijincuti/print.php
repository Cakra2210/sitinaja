<?php
use yii\helpers\Html;
$teksiscuti='ijin';
if($iscuti!='0')
{
  $teksiscuti='cuti';
}
?>
<div style="float:right; width:30%;">
<?= $alamatkantor ?>,<?= $tanggal_surat ?> <br><br>
Kepada Yang Terhormat,<br>
Kepala Badan Pusat Statistik<br>
<?= ucwords($kabupaten)?><br>
Di -<br>
&nbsp;&nbsp;&nbsp;&nbsp;<?= $alamatkantor ?>
</div>
<br><br><br><br><br><br><br><br><br>
Yang bertanda tangan di bawah ini:<br><br>
<table class='table' style="width:80%;">
  <tr>
    <td style='padding-left:30px'>Nama</td>
    <td>: <?= $nama ?></td>
  </tr>
  <tr>
    <td style='padding-left:30px'>Nip</td>
    <td>: <?= $nip ?></td>
  </tr>
  <tr>
    <td style='padding-left:30px'>Pangkat/Golongan Ruang</td>
    <td>: <?= $pangkat ?> (<?= $golongan ?>)</td>
  </tr>
  <tr>
    <td style='padding-left:30px'>Satuan Organisasi</td>
    <td>: <?= ucwords($satker) ?></td>
  </tr>
</table>
&nbsp;&nbsp;&nbsp;&nbsp;Dengan ini mengajukan <?= $teksiscuti ?>
<?php
  if($iscuti==2)
  {
    echo 'untuk tahun '.date("Y").' ';
  }
 ?>
 selama <?= $day ?> hari kerja terhitung mulai tanggal <?= $date_start ?> sampai dengan tanggal <?= $date_end ?>.<br>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php
  if($iscuti==1)
  {
    echo 'Selama menjalankan  cuti alamat saya di '.$alamatijin.'.';
  }
  else {
    echo 'Untuk Keperluan '.$keperluan.'.';
  }
?>
<br>
&nbsp;&nbsp;&nbsp;&nbsp;Demikian permintaan ini saya buat untuk dapat dipertimbangkan sebagaimana mestinya.<br>
<br><br><br>
<div style="float:right; width:30%" class="text-center">
  Hormat Saya,<br>
  <br><br><br>
  <strong><u><?= $nama ?></u></strong><br>
  NIP.<?= $nip ?>
</div>
<br><br><br><br><br><br><br><br>
<?php
  if($iscuti==1)
  {
    echo'
    <table class="table table-bordered">
      <tr>
        <td style="padding-left:10px;border-color:#000000;border-bottom-color:#ffffff">
          <strong>CATATAN PEJABAT KEPEGAWAIAN</strong><br>
          Cuti yang telah diambil dalam tahun bersangkutan
        </td>
        <td class="text-center" style="padding-left:10px;border-color:#000000;">
          <strong>CATATAN PERTIMBANGAN ATASAN LANGSUNG</strong>
          <br><br><br><br><br><br>
        </td>
      </tr>
      <tr>
        <td style="padding-left:10px;border-color:#000000;border-top-color:#ffffff">
          <ol>
            <li>Cuti Tahunan</li>
            <li>Cuti Besar</li>
            <li>Cuti Sakit</li>
            <li>Cuti Bersalin</li>
            <li>Cuti karena Alasan Penting</li>
            <li>Keterangan lain-lain</li>
          </ol>
        </td>
        <td class="text-center" style="padding-left:10px;border-color:#000000;">
          <strong>KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI</strong>
          <br><br><br><br><br>
          <strong>'.$Kepala.'</strong><br>
          <strong>NIP. '. $nipKepala .'</strong>
        </td>
      </tr>
    </table>
    ';
  }

?>
