<?php
use yii\helpers\Html;
$helper=Yii::$app->myHelper;
?>
<div style="float:left; width: 15%;">
    <p class="text-left"><?= Html::img('@web/image/logobps.png', ['width' => '100%']) ?></p>
</div>
<div style="float:right; width: 80%;">
  <h2><p class="text-muted text-left"><em><strong>BADAN PUSAT STATISTIK<br><?= strtoupper($kabupaten)?></strong></em></p></h2>
</div>
<br><br><br><br><br>
<hr>
<div>
<h4 class="text-center"><strong>LAPORAN PEGAWAI KELUAR</strong></h4>
</div><br>
<table class="table table-bordered">
  <tr>
    <td style="padding-left:10px; padding-bottom: 10px; border-color:#ffffff">
			Hari/Tanggal :
		</td>
    <td style="padding-left:10px; padding-bottom: 10px; border-color:#ffffff;">
			<?= $helper->hariIndonesia(date("Y-m-d")).','.$helper->indonesian_date(date("Y-m-d")) ?>
		</td>
  </tr>
  <tr>
    <td style="padding-left:10px; padding-bottom: 10px; border-color:#ffffff">
			Nama :
		</td>
    <td style="padding-left:10px; padding-bottom: 10px; border-color:#ffffff;">
			<?= $nama ?> <br>
		</td>
  </tr>
  <tr>
    <td style="padding-left:10px; padding-bottom: 10px; border-color:#ffffff">
			NIP :
		</td>
    <td style="padding-left:10px; padding-bottom: 10px; border-color:#ffffff;">
			<?= $nip ?> <br>
		</td>
  </tr>
  <tr>
    <td style="padding-left:10px; padding-bottom: 10px; border-color:#ffffff">
			Keperluan :
		</td>
    <td style="padding-left:10px; padding-bottom: 10px; border-color:#ffffff;">
			<?= $keperluan ?> <br>
		</td>
  </tr>
  <tr>
    <td style="padding-left:10px; padding-bottom: 10px; border-color:#ffffff">
			Jam Keluar :
		</td>
    <td style="padding-left:10px; padding-bottom: 10px; border-color:#ffffff;">
			<?php
        if(strlen($jam_keluar)>2)
        {
          $comp = preg_split('/ +/', $jam_keluar );
          echo $comp[1];
        }
        else{
          echo '-';
        }
      ?> <br>
		</td>
  </tr>
  <tr>
    <td style="padding-left:10px; padding-bottom: 10px; border-color:#ffffff">
			Jam Pulang :
		</td>
    <td style="padding-left:10px; padding-bottom: 10px; border-color:#ffffff;">
			<?php
      if(strlen($jam_pulang)>2)
      {
        $comp = preg_split('/ +/', $jam_pulang );
        echo $comp[1];
      }else{
        echo '-';
      }

      ?> <br>
		</td>
  </tr>
</table>
<br><br>
<br><br>
<div style="float:left; width: 50%;">
  <div class="text-center">Mengetahui,
  <br><br>
  <br><br>
  <br>
  (<?= $kepala ?>)</div>
</div>
<div style="float:right; width: 50%;">
  <div class="text-center">Yang Bersangkutan,
  <br><br>
  <br><br>
  <br>
  (<?= $nama ?>)</div>
</div>
