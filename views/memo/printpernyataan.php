<?php
use yii\helpers\Html;
$helper=Yii::$app->myHelper;
?>
<div style="float:left; width: 15%;">
    <p class="text-right"><?= Html::img('@web/image/logobps.png', ['width' => '80%']) ?></p>
</div>
<div style="float:right; width: 80%;">
  <h3><p class="text-muted text-left" style="color:#2980b9"><em><strong>BADAN PUSAT STATISTIK<br><?= strtoupper($kabupaten)?></strong></em></p></h3>
</div>
<br><br><br><br>
<div>
<h4 class="text-center"><strong>FORM PERNYATAAN TIDAK BISA ABSEN</strong></h4>
</div><br>
Saya yang bertanda tangan dibawah ini:<br><br>
<table class="table table-bordered">
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
			Jabatan :
		</td>
    <td style="padding-left:10px; padding-bottom: 10px; border-color:#ffffff;">
			<?= $jabatan ?> <br>
		</td>
  </tr>
</table>
Menyatakan bahwa saya tidak bisa absen <?= $jam_pulang!=null? 'pulang': 'datang'?> pada mesin absen :
<br><br>
<table class="table table-bordered">
  <tr>
    <td style="padding-left:10px; padding-bottom: 10px; border-color:#ffffff">
			Tanggal :
		</td>
    <td style="padding-left:10px; padding-bottom: 10px; border-color:#ffffff;">
			<?= $tanggal ?> <br>
		</td>
  </tr>
  <tr>
    <td style="padding-left:10px; padding-bottom: 10px; border-color:#ffffff">
			Alasan :
		</td>
    <td style="padding-left:10px; padding-bottom: 10px; border-color:#ffffff;">
			<?= $keperluan ?> <br>
		</td>
  </tr>
</table>
Demikian surat pernyataan ini dibuat dengan sungguh-sungguh dan untuk digunakan sebagaimana mestinya.
<br><br><br><br>
<div style="float:left; width: 30%;"><br>
  <div class="text-center">Mengetahui,<br>Kepala
  <br><br>
  <br><br>
  <br>
  <?= $kepala ?></div>
</div>
<div style="float:right; width: 40%;"><div class="text-center"><?= ucwords($helper->config()->alamat) ?>,<?= $tanggal ?><br><br>
  Yang Bersangkutan,
  <br><br>
  <br><br>
  <br>
  <?= $nama ?></div>
</div>
<div style="float:right; width: 30%;"><br><br>
  <div class="text-center"><?= $jabatankepalaseksi ?>,
  <br><br>
  <br><br>
  <br>
  <?= $namakepalaseksi ?></div>
</div>
