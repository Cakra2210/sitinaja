<?php
use yii\helpers\Html;
?>
<p class="text-center"><?= Html::img('@web/image/logobps.png', ['width' => '15%']) ?></p>
<h4><p class="text-muted text-center"><em><strong>BADAN PUSAT STATISTIK <?= strtoupper($kabupaten)?></strong></em></p></h4>
<br><br>
<p class="text-center"><strong>SURAT TUGAS<br/>NOMOR  <?= $nomor ?>/BPS/<?= date("m",strtotime($tglenglish));?>/<?= date('Y',strtotime($tglenglish))?></strong></p>
<br>
<div>
	<div style="float:left; width: 20%;">
		Menimbang :
	</div>
	<div style="float:right; width: 80%;">
		<ol>
			<li>Bahwa dalam rangka pelaksanaan kegiatan <?= $hal?>, perlu menugaskan petugas pelaksana <?= $hal ?>.</li>
			<!-- <li>Bahwa dalam rangka penyusunan laporan keuangan tahunan 2015, perlu menugaskan petugas pelaksana penyusunan laporan keuangan tahunan 2015.</li>-->
		</ol>
	</div>
</div>
<br/>
<div>
	<div style="float:left;  width: 20%;">
		Mengingat :
	</div>
	<div style="float:right;  width: 80%;">
		<ol>
			<li>Undang-Undang Nomor 16 Tahun 1997 Tentang Statistik;</li>
			<li>Peraturan Pemerintah Nomor 51 Tahun 1999 Tentang Penyelenggaraan Statistik;</li>
			<li>Peraturan Presiden Nomor 86 Tahun 2007 Tentang Badan Pusat Statistik;</li>
			<li>Keputusan Kepala BPS Nomor 121 Tahun 2001 Tentang Organisasi dan Tata Kerja Badan Pusat Statistik di Daerah;</li>
			<li>Peraturan Kepala BPS Nomor 7 Tahun 2008 Tentang Organisasi dan Tata Kerja Badan Pusat Statistik;</li>
			<li><?= $surat ?>;</li>
		</ol>
	</div>
</div>
<br/><br/>
<p class="text-center">Menugaskan:</p>
<div>
	<div style="float:left;  width: 20%;">
		Kepada :
	</div>
	<div style="float:right;  width: 77%;">
		<table class='table'>
			<tr>
				<td>
					<strong><?= $nama ?></strong>
				</td>
				<td>
					NIP.<?= $nip?>
				</td>
			</tr>
		</table>
	</div>
</div>
<div>
	<div style="float:left;  width: 20%;">
		Untuk :
	</div>
	<div style="float:right;  width: 77%;">
		<?= $hal .' di '.$destinasi ?>.
	</div>
</div>
<div>
	<div style="float:left;  width: 20%;">
		Waktu :
	</div>
	<div style="float:right;  width: 77%;">
		<?= $waktu ?>
	</div>
</div>
<br/><br/>
<div>
	<div style="float:right;  width: 30%;">
		<p class="text-center">
			<?= $alamatkantor?>, <?= $tanggal;?><br/>
			<?php if($is_plh==1){echo 'a.n ';}?>Kepala Badan Pusat Statistik<br/>
			<?= ucwords($kabupaten) ?><br/>
			<br/><br/><br/>
			<u><?php
			 	if($is_plh!=1)
				{
					echo $Kepala;
				}else{
					echo $namaplh;
				}
			?></u><br/>
			NIP. <?php if($is_plh==0){
					echo $nipKepala;
			}else{
				echo $nipplh;
			} ?>
		</p>
	</div>
</div>
