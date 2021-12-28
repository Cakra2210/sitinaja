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
<pagebreak>
<div>
	<div style="float:left; width: 65%;">
		BADAN PUSAT STATISTIK<br>
		<?= strtoupper($kabupaten)?><br>
		<?= $alamatlengkap ?>
	</div>
	<div style="float:right; width: 33%;">
		Lembar :<br>
		Kode No : <br>
		Nomor : <?= $nomor ?>/SPD/<?= date("m",strtotime($tglenglish));?>/<?= date('Y')?>
	</div>
</div>
<br><br>
<p class="text-center"><strong>SURAT PERJALANAN DINAS</strong></p>
<br><br>
<table class="table table-bordered">
	<tr>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			1.
		</td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			Pejabat Pembuat Komitmen<br>
		</td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			<?= $ppk ?><br>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			2.
		</td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			Nama/NIP Pegawai yang melaksanakan<br>
			perjalanan dinas<br>
		</td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			<strong><?= $nama ?></strong><p style="padding-left:30px; border-color:#000000">NIP : <?=$nip?></p><br>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			3.
		</td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			a. Pangkat dan golongan<br>
			b. Jabatan/Instansi<br>
			c. Tingkat Biaya Perjalanan Dinas<br>
			<br>
		</td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			a. <?= $pangkat ?>(<?= $golongan ?>)<br>
			b. <?= $jabatan ?><br>
			c. C<br>
			<br>
		</td>
	</tr>
	<tr>
		<td  style="padding-left:10px; padding-bottom:30px; border-color:#000000">4.</td>
		<td style="padding-left:10px; padding-bottom:30px; border-color:#000000">Maksud Perjalanan Dinas</td>
		<td style="padding-left:10px; padding-bottom:30px; border-color:#000000"><?= $hal ?></td>
	</tr>
	<tr>
		<td  style="padding-left:10px; padding-bottom:10px; border-color:#000000">5.</td>
		<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">Alat angkutan yang dipergunakan</td>
		<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
			<?=
				$angkutan;
			 ?>
		</td>
	</tr>
	<tr>
		<td  style="padding-left:10px; padding-bottom:10px; border-color:#000000">
			6.
		</td>
		<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
			a. Tempat Berangkat<br>
			b. Tempat Tujuan<br>
		</td>
		<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
			a. Kecamatan <?= ucwords($alamatkantor)?> <?= ucwords($kabupaten)?><br>
			b. <?= $destinasi ?>
		</td>
	</tr>
	<tr>
		<td  style="padding-left:10px; padding-bottom:10px; border-color:#000000">
			7.
		</td>
		<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
			a. Lamanya Perjalanan Dinas<br>
			b. Tanggal berangkat<br>
			c. Tanggal harus kembali*)<br>
		</td>
		<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
			a. <?= ($day) ?> hari<br>
			b. <?= $tglberangkat ?><br>
			c. <?= $tglkembali ?><br>
		</td>
	</tr>
	<tr>
		<td  style="padding-left:10px; border-color:#000000">8.</td>
		<td style="padding-left:10px; border-color:#000000">Pengikut:     Nama</td>
		<td style="padding-left:10px; border-color:#000000">Tanggal Lahir/Keterangan</td>
	</tr>
	<tr>
		<td style="padding-left:10px; border-color:#000000"></td>
		<td style="padding-left:10px; border-color:#000000">
			1.<br>
			2.<br>
			3.<br>
			4.<br>
			5.<br>
		</td>
		<td style="padding-left:10px; border-color:#000000"></td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">9.</td>
		<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
			Pembebanan Anggaran<br>
			a. Instansi<br>
			b. Akun<br>
		</td>
		<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
			<br>
			a. Badan Pusat Statistik <?= ucwords($kabupaten)?><br>
			b.
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">10.</td>
		<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">Keterangan lain-lain</td>
		<td style="padding-left:10px; padding-bottom:10px; border-color:#000000" ></td>
	</tr>
</table>
<br>
<div>
	<div style="float:right;  width: 40%;">
		<p class="text-left">
			Dikeluarkan di : Kecamatan <?= $alamatkantor ?><br>
			Pada tanggal : <?= $tanggal ?><br><br>
			Pejabat Pembuat Komitmen<br/>
			<br/>
			<br/><br/><br/>
			<u><?= $ppk ?></u><br/>
			NIP. <?= $nipppk ?>
		</p>
	</div>
</div>
<pagebreak>
<?php
$an='';
if($is_plh==1)
{
	$Kepala=$namaplh;
	$nipKepala=$nipplh;
	$an='a.n ';
}
if($day<4 )
{		echo '<table class="table table-bordered">
			<tr>
				<td style="padding-left:10px; padding-bottom:10px; border-color:#000000"></td>
				<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
					I. Berangkat dari: Kecamatan '.$alamatkantor.'<br>
					(Tempat Kedudukan)<br>
					Ke : <br>
					Pada Tanggal : <br>
					'.$an.'Kepala '.$satker.'<br>
					<br>
					<br>
					<br>
					<u>'.$Kepala.'</u><br>
					NIP. '.$nipKepala.'<br>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
					II. Tiba di : <br>
					Pada Tanggal : <br><br>
					Kepala<br>
					<br>
					<br>
					<br>
					___________________<br>
					NIP.<br>
				</td>
				<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
					Berangkat dari: <br>
					Ke : <br>
					Pada Tanggal : <br>
					Kepala<br>
					<br>
					<br>
					<br>
					___________________<br>
					NIP. <br>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
					III. Tiba di : <br>
					Pada Tanggal : <br><br>
					Kepala<br>
					<br>
					<br>
					<br>
					___________________<br>
					NIP.<br>
				</td>
				<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
					Berangkat dari: <br>
					Ke : <br>
					Pada Tanggal : <br>
					Kepala<br>
					<br>
					<br>
					<br>
					___________________<br>
					NIP. <br>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
					IV. Tiba di : <br>
					Pada Tanggal : <br><br>
					Kepala<br>
					<br>
					<br>
					<br>
					___________________<br>
					NIP.<br>
				</td>
				<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
					Berangkat dari: <br>
					Ke : <br>
					Pada Tanggal : <br>
					Kepala<br>
					<br>
					<br>
					<br>
					___________________<br>
					NIP. <br>
				</td>

			</tr>
			<tr>
				<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
					Tiba di:<br>
					 <br>
					Pada Tanggal : <br><br><br>
					Pejabat Pembuat Komitmen<br>
					<br>
					<br>
					<br>
					<u>'.$ppk.'</u><br>
					NIP. '.$nipppk.'<br>
				</td>
				<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
					Telah diperiksa dengan keterangan bahwa<br>perjalanan tersebut atas perintahnya<br>dan semata-mata untuk kepentingan jabatan<br>
					dalam waktu yang sesingkat-singkatnya.<br><br>
					Pejabat Pembuat Komitmen<br>
					<br>
					<br>
					<br>
					<u>'.$ppk.'</u><br>
					NIP. '.$nipppk.'<br>
				</td>
			</tr>
			<tr>
				<td style="padding-left:10px; padding-bottom:10px; border-color:#000000; border-right-color:#ffffff">
					VI. Catatan  Lain-lain:
				</td>
				<td style="padding-left:10px; padding-bottom:10px; border-color:#000000;  border-left-color:#ffffff">
				</td>
			</tr>
		</table>
		VII. PERHATIAN :
		<div style="padding left 10px">
		PPK yang menerbitkan SPD, pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan tanggal berangkat/tiba, serta bendahara pengeluaran bertanggunng jawab berdasarkan peraturan-peraturan Keuangan Negara apabila negara menderita rugi akibat kesalahan, kelalaian dan kealpaannya.
		</div>';
	}
	else{
		echo '<table class="table table-bordered">
					<tr>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000"></td>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							I. Berangkat dari: Kecamatan '.$alamatkantor.'<br>
							(Tempat Kedudukan)<br>
							Ke : <br>
							Pada Tanggal : <br>
							Kepala '.$satker.'<br>
							<br><br>
							<br>
							<br>
							<u>'.$Kepala.'</u><br>
							NIP. '.$nipKepala.'<br>
						</td>
					</tr>
					<tr>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							II. Tiba di : <br>
							Pada Tanggal : <br><br>
							Kepala<br>
							<br><br>
							<br>
							<br>
							___________________<br>
							NIP.<br>
						</td>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							Berangkat dari: <br>
							Ke : <br>
							Pada Tanggal : <br>
							Kepala<br>
							<br>
							<br>
							<br>
							___________________<br>
							NIP. <br>
						</td>
					</tr>
					<tr>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							III. Tiba di : <br>
							Pada Tanggal : <br><br>
							Kepala<br>
							<br>
							<br>
							<br>
							___________________<br>
							NIP.<br>
						</td>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							Berangkat dari: <br>
							Ke : <br>
							Pada Tanggal : <br>
							Kepala<br>
							<br>
							<br>
							<br>
							___________________<br>
							NIP. <br>
						</td>
					</tr>
					<tr>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							IV. Tiba di : <br>
							Pada Tanggal : <br><br>
							Kepala<br>
							<br>
							<br>
							<br>
							___________________<br>
							NIP.<br>
						</td>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							Berangkat dari: <br>
							Ke : <br>
							Pada Tanggal : <br>
							Kepala<br>
							<br>
							<br>
							<br>
							___________________<br>
							NIP. <br>
						</td>

					</tr>
					<tr>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							V. Tiba di : <br>
							Pada Tanggal : <br><br>
							Kepala<br>
							<br>
							<br>
							<br>
							___________________<br>
							NIP.<br>
						</td>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							Berangkat dari: <br>
							Ke : <br>
							Pada Tanggal : <br>
							Kepala<br>
							<br>
							<br>
							<br>
							___________________<br>
							NIP. <br>
						</td>

					</tr>

					<tr>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							VI. Tiba di : <br>
							Pada Tanggal : <br><br>
							Kepala<br>
							<br>
							<br>
							<br>
							___________________<br>
							NIP.<br>
						</td>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							Berangkat dari: <br>
							Ke : <br>
							Pada Tanggal : <br>
							Kepala<br>
							<br>
							<br>
							<br>
							___________________<br>
							NIP. <br>
						</td>

					</tr>

					<tr>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							VII. Tiba di : <br>
							Pada Tanggal : <br><br>
							Kepala<br>
							<br>
							<br>
							<br>
							___________________<br>
							NIP.<br>
						</td>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							Berangkat dari: <br>
							Ke : <br>
							Pada Tanggal : <br>
							Kepala<br>
							<br>
							<br>
							<br>
							___________________<br>
							NIP. <br>
						</td>

					</tr>
					<tr>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							VIII. Tiba di : <br>
							Pada Tanggal : <br><br>
							Kepala<br>
							<br>
							<br>
							<br>
							___________________<br>
							NIP.<br>
						</td>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							Berangkat dari: <br>
							Ke : <br>
							Pada Tanggal : <br>
							Kepala<br>
							<br>
							<br>
							<br>
							___________________<br>
							NIP. <br>
						</td>

					</tr>

					<tr>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							IX. Tiba di : <br>
							Pada Tanggal : <br><br>
							Kepala<br>
							<br>
							<br>
							<br>
							___________________<br>
							NIP.<br>
						</td>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							Berangkat dari: <br>
							Ke : <br>
							Pada Tanggal : <br>
							Kepala<br>
							<br>
							<br>
							<br>
							___________________<br>
							NIP. <br>
						</td>
					</tr>
					<tr>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							Tiba di: <br>
							<br>
							Pada Tanggal : <br><br><br>
							Pejabat Pembuat Komitmen<br>
							<br>
							<br>
							<br>
							<br>
							<u>'.$ppk.'</u><br>
							NIP. '.$nipppk.'<br>
						</td>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
							Telah diperiksa dengan keterangan bahwa<br>perjalanan tersebut atas perintahnya<br>dan semata-mata untuk kepentingan jabatan<br>
							dalam waktu yang sesingkat-singkatnya.<br><br>
							Pejabat Pembuat Komitmen<br>
							<br>
							<br>
							<br>
							<br>
							<u>'.$ppk.'</u><br>
							NIP. '.$nipppk.'<br>
						</td>
					</tr>
					<tr>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000; border-right-color:#ffffff">
							VI. Catatan  Lain-lain:
						</td>
						<td style="padding-left:10px; padding-bottom:10px; border-color:#000000;  border-left-color:#ffffff">
						</td>
					</tr>
				</table>
				XI. PERHATIAN :
				<div style="padding left 10px">
				PPK yang menerbitkan SPD, pegawai yang melakukan perjalanan dinas, para pejabat yang mengesahkan tanggal berangkat/tiba, serta bendahara pengeluaran bertanggunng jawab berdasarkan peraturan-peraturan Keuangan Negara apabila negara menderita rugi akibat kesalahan, kelalaian dan kealpaannya.
				</div>';
	}
	?>
<pagebreak>
	<p class="text-center"><strong style="font-size:16px;">Laporan Perjalanan Dinas</strong></p>
<table class="table table-bordered">
	<tr>
		<td style="padding-left:10px; padding-bottom:10px; border-color:#000000">
			Tujuan : <?= $destinasi ?>
		</td>
		<td style="padding-left:30px;padding-right:30px; padding-bottom:10px; border-color:#000000">
			Nama : <?= $nama ?><br>
			NIP : <?= $nip ?>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; border-color:#000000">
			Tanggal Tugas :
			<?php
				if($tglberangkat==$tglkembali)
				{
					echo $tglberangkat;
				}
				else {
					echo $tglberangkat .' - '. $tglkembali;
				}
			?>
		</td>
		<td style="padding-left:30px;padding-right:30px; padding-bottom:10px; border-color:#000000; border-bottom-color:#ffffff">
			Tanda Tangan :
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom:30px; border-color:#000000">
			Perihal :<br>
			<?= $hal ?>
		</td>
		<td style="padding-left:10px; padding-bottom:10px; border-color:#000000; border-top-color:#ffffff">
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom:20px; border-color:#000000; border-right-color:#ffffff">
		</td>
		<td style="padding-left:10px; padding-bottom:20px; border-color:#000000; border-left-color:#ffffff">
		</td>
	</tr>
	<tr>
		<td class="text-left" style="padding-left:10px; padding-bottom:10px; border-color:#000000; border-right-color:#ffffff">
			<strong>Uraian Kegiatan</strong>
		</td>
		<td style="padding-bottom:10px; border-color:#000000; border-left-color:#ffffff">
		</td>
	</tr>
	<tr>
		<td class="text-right" style="padding-left:10px; padding-bottom:300px; border-color:#000000; border-right-color:#ffffff">
		</td>
		<td style="padding-bottom:300px; border-color:#000000; border-left-color:#ffffff">
		</td>
	</tr>
</table>
<table class="table table-bordered">
	<tr>
		<td class="text-left" style="padding-left:10px; padding-bottom:10px; border-color:#000000;">
			<strong>Permasalahan</strong>
		</td>
		<td style="padding-bottom:10px;padding-right:50px; border-color:#000000;">
			<strong>Solusi</strong>
		</td>
	</tr>
	<tr>
		<td class="text-right" style="padding-left:10px; padding-bottom:200px; border-color:#000000;">

		</td>
		<td style="padding-bottom:200px;padding-right:50px; border-color:#000000;">

		</td>
	</tr>

</table>
<div style="float:right; width: 30%;">
	Pejabat yang ditemui
	<br><br><br><br><br>
	<u>.....................................</u><br>
	NIP.
</div>
<pagebreak>
<!-- RINCIAN PERJALANAN DINAS -->
<p class="text-center">RINCIAN PERJALANAN DINAS</p>
<br>
<br>
<div style="float:right; width:98%">
	<div style="float:left; width:30%";>
		Lampiran SPD Nomor<br>
		Tanggal<br>
	</div>
	<div style="float:right; width:70%;">
		: <?= $nomor ?>/SPD/<?= date("m",strtotime($tglenglish));?>/<?= date('Y')?><br>
		: <?= $tanggal ?>
	</div>
</div>
<br>
<br>
<table class="table table-bordered">
	<tr>
		<td style="padding-bottom: 10px; border-color:#000000">
			No.
		</td>
		<td class="text-center" style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			PERINCIAN BIAYA
		</td>
		<td class="text-center" style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			JUMLAH
		</td>
		<td class="text-center" style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			KETERANGAN
		</td>
	</tr>
	<tr>
		<td style="padding-bottom: 10px; border-color:#000000;border-bottom-color:#ffffff">
			1.
		</td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000;border-bottom-color:#ffffff">
			Transport
		</td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000;border-bottom-color:#ffffff">
			Rp. <?= $isluarkota==2 ? $transport:0 ?>
		</td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000;border-bottom-color:#ffffff">

		</td>
	</tr>
		echo'
		<tr>
			<td style="padding-bottom: 100px; border-color:#000000; border-top-color:#ffffff;border-bottom-color:#ffffff">
				2.
			</td>
			<td style="padding-left:10px; padding-bottom: 100px; border-color:#000000; border-top-color:#ffffff;border-bottom-color:#ffffff">
				<?php

					echo 'Uang Harian ('.$day.' O-H)';

				?>
			</td>
			<td style="padding-left:10px; padding-bottom: 100px; border-color:#000000; border-top-color:#ffffff;border-bottom-color:#ffffff">
				<?php

					echo 'Rp. '.$uangharian.'';

				?>
			</td>
			<td style="padding-left:10px; padding-bottom: 100px; border-color:#000000; border-top-color:#ffffff;border-bottom-color:#ffffff">

			</td>
		</tr>
		<tr>
			<td style="padding-bottom: 10px; border-color:#000000; border-top-color:#ffffff; border-bottom-color:#ffffff">

			</td>
			<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000; border-top-color:#ffffff; border-bottom-color:#ffffff">

			</td>
			<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000; border-top-color:#ffffff; border-bottom-color:#ffffff">
				Rp.
			</td>
			<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000; border-top-color:#ffffff; border-bottom-color:#ffffff">

			</td>
		</tr>
	<tr>
		<td style="padding-bottom: 10px; border-color:#000000; border-top-color:#ffffff">

		</td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000; border-top-color:#ffffff">
			<strong>JUMLAH</strong>
		</td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000; border-top-color:#ffffff">
			Rp. <strong><?= $jumlah ?></strong>
		</td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000; border-top-color:#ffffff">

		</td>
	</tr>
	<tr>
		<td style="padding-bottom: 10px; border-color:#000000;border-right-color:#ffffff; ">

		</td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000;border-right-color:#ffffff;border-left-color:#ffffff">
			Terbilang:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong><i><?= $terbilang ?> Rupiah</i></strong>
		</td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000; border-right-color:#ffffff;border-left-color:#ffffff">
		</td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000; border-left-color:#ffffff">

		</td>
	</tr>
</table>
<br>
<br>
<div style="float:right; width: 40%;">
<?= $alamatkantor ?>,&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?= date('Y'); ?>
</div>
<br>
<div>
	<div style="float:left; width: 40%;">
	Telah dibayar sejumlah<br>
	Rp. <?= $jumlah ?>,-<br>
	Bendahara Pengeluaran<br>
	<br>
	<br>
	<br>
	<u><strong><?= $bendahara?></strong></u><br>
	NIP. <?= $nipbendahara ?>
	</div>
	<div style="float:right; width: 40%;">
	Telah menerima jumlah uang sebesar<br>
	Rp. <?= $jumlah ?>,-<br>
	Yang Menerima<br>
	<br>
	<br>
	<br>
	<u><strong><?= $nama?></strong></u><br>
	NIP. <?= $nip ?>
	</div>
</div>
<br>
<br>
<br>
<p class="text-center">PERHITUNGAN SPD RAMPUNG</p>
<br>
<div>
	<div style="float:left; width: 50%">
		Ditetapkan sejumlah<br>
		Yang telah dibayar semula<br>
		Sisa kurang lebih<br>
	</div>
	<div style="float:right; width: 50%">
		: Rp. <?= $jumlah ?><br>
		: Rp. 0<br>
		: Rp. <?= $jumlah ?><br>
	</div>
</div>
<br>
<div style="float:right; width: 40%">
	Pejabat Pembuat Komitmen<br>
	<?= $satker ?>
	<br><br><br><br>
	<strong><u><?= $ppk ?></u></strong><br>
	NIP. <?= $nipppk ?>
</div>
<pagebreak>
<p class="text-center"><u><strong>DAFTAR PENGELUARAN RIIL</strong></u></p>
<br>
<div style="float:right; width: 90%">
	<p>Yang bertanda tangan di bawah ini:<p>
	<div style="float:left; width:20%">
		Nama<br>
		NIP<br>
	</div>
	<div style="float:right; width:80%">
		: <strong><?= $nama ?></strong><br>
		: <strong><?= $nip ?></strong><br>
	</div>
</div>
<div style="float:right; width: 90%"><br>
	Berdasarkan Surat Perjalanan Dinas (SPD) <?= $tanggal ?> Nomor : <?= $nomor ?>/SPD/<?= date("m",strtotime($tglenglish));?>/<?= date('Y')?> dengan ini kami menyatakan sesungguhnya bahwa:
</div>
<br><br><br><br>
<ol>
	<li style="padding-left:30px">Biaya transport pegawai dan/atau biaya penginapan dibawah ini yang tidak dapat diperoleh bukti-bukti pengeluaran meliputi:</li>
</ol>
<br>
<div style="float:left; width:100%;margin-left:30px">
<table class="table table-bordered">
	<tr>
		<td class="text-center" style="padding-left:10px; padding-bottom: 10px; border-color:#000000">No</td>
		<td class="text-center" style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			Uraian
		</td>
		<td class="text-center" style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			Jumlah(Rp)
		</td>
		<td class="text-center" style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			Keterangan
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000"><i>(1)</i></td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			<i>(2)</i>
		</td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			<i>(3)</i>
		</td>
		<td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
			<i>(4)</i>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom: 50px; border-color:#000000;border-bottom-color:#ffffff">1</td>
		<td style="padding-left:10px; padding-bottom: 50px; border-color:#000000;border-bottom-color:#ffffff">
			Biaya transport angkutan umum dari <?= $satker?> ke <?= $destinasi ?> (PP)
		</td>
		<td style="padding-left:10px; padding-bottom: 50px; border-color:#000000;border-bottom-color:#ffffff">
			<?= $transport?>,-
		</td>
		<td style="padding-left:10px; padding-bottom: 50px; border-color:#000000;border-bottom-color:#ffffff">

		</td>
	</tr>
	<tr>
		<td style="padding-left:10px;border-color:#000000;border-top-color:#ffffff"></td>
		<td style="padding-left:10px;border-color:#000000;border-top-color:#ffffff">
			<strong> Jumlah </strong>
		</td>
		<td style="padding-left:10px;border-color:#000000;border-top-color:#ffffff">
			<strong><?= $transport?>,-</strong>
		</td>
		<td style="padding-left:10px;border-color:#000000;border-top-color:#ffffff">

		</td>
	</tr>
	<tr>
		<td style="padding-left:10px;border-color:#000000;border-right-color:#ffffff"></td>
		<td style="padding-left:10px;border-color:#000000;border-right-color:#ffffff;border-left-color:#ffffff">
			Terbilang : <i><?= $terbilangtransport ?> rupiah
		</td>
		<td style="padding-left:10px;border-color:#000000;border-right-color:#ffffff;border-left-color:#ffffff">
		</td>
		<td style="padding-left:10px;border-color:#000000;border-left-color:#ffffff">

		</td>
	</tr>
</table>
<div>
<ol start="2">
	<li>
		Jumlah uang tersebut pada angka 1 di atas benar-benar dikeluarkan untuk pelaksanaan perjalanan dinas dan apabila di kemudia terdapat kelebihan atas pembayaran, kami bersedia untuk menyetorkan kelebihan tersebut ke Kas Negara.
	</li>
</ol>
<div>
Demikian pernyataan ini kami buat dengan sebenarnya, untuk dipergunakan sebagaimana mestinya.
</div>
<br>
<div>

</div>
<div>
	<div style="float:left;  width: 40%;">
		<p class="text-center">
			Mengetahui/Menyetujui<br>
			Pejabat Pembuat Komitmen<br>
			<?= $satker?><br>
			<br><br><br>
			<u><?= $ppk ?></u><br>
			NIP. <?= $nipppk ?>
		</p>
	</div>
	<div style="float:right;  width: 40%;">
		<p class="text-center">
			<?= $alamatkantor?>, &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= date('Y'); ?><br/>
			Pejabat Negara/Pegawai Negeri<br>
			yang melakukan perjalanan dinas<br>
			<br/><br/><br/>
			<u><?= $nama ?></u><br/>
			NIP. <?= $nip ?>
		</p>
	</div>
</div>
<pagebreak>
<p class="text-center" style="font-size:16px"><strong>K U I T A N S I</strong></p>
<table class="table">
	<tr>
		<td style="padding-left:10px; padding-bottom:10px;">
			Sudah terima dari
		</td>
		<td style="padding-left:10px; padding-bottom:10px;">
			: Kuasa Pengguna Anggaran<br>&nbsp;&nbsp;<?= $satker?>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom:10px;">
			Uang Sebanyak
		</td>
		<td style="padding-left:10px; padding-bottom:10px;">
			: <strong><i>Rp.&nbsp;&nbsp;&nbsp;&nbsp;<?= $jumlah ?></i></strong>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom:10px;">
			Untuk Pembayaran
		</td>
		<td style="padding-left:10px; padding-bottom:10px;">
			: Biaya Perjalanan Dinas <?= $hal ?> di Kecamatan <?= $destinasi ?>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom:10px;">
			Berdasarkan SPD No.
		</td>
		<td style="padding-left:10px; padding-bottom:10px;">
			: <?= $nomor ?>/SPD/<?= date("m",strtotime($tglenglish));?>/<?= date('Y')?>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom:10px;">
			Tanggal
		</td>
		<td style="padding-left:10px; padding-bottom:10px;">
			: <?= $tanggal ?>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom:10px;">
			Terbilang
		</td>
		<td style="padding-left:10px; padding-bottom:10px;">
			: <strong><i><?= $terbilang ?> Rupiah</i></strong>
		</td>
	</tr>
</table>
<br>
<div style="float:right; width:30%">
	<?= $alamatkantor ?>,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= date('Y'); ?>
</div>
<br>
<table class="table" style="padding-left:-20px">
	<tr>
		<td class="text-center" style="padding-left:10px; padding-bottom:10px;">
			Setuju Dibayar<br>
			A.n Kuasa Pengguna Anggaran<br>
			Pejabat Pembuat Komitmen<br>
			<?= $satker ?><br>
			<br><br><br><br>
			<u><?= $ppk ?></u><br>
			NIP. <?= $nipppk ?>
		</td>
		<td class="text-center" style="padding-left:10px; padding-bottom:10px;">
			Lunas Dibayar<br>
			Bendahara Pengeluaran<br>
			<br><br>
			<br><br><br><br>
			<u><?= $bendahara ?></u><br>
			NIP. <?= $nipbendahara ?>
		</td>
		<td class="text-center" style="padding-left:10px; padding-bottom:10px;">
			Yang Menerima,<br><br>
			<br><br>
			<br><br><br><br>
			<u><?= $nama ?></u><br>
			NIP. <?= $nip ?>
		</td>
	</tr>
</table>

<p class="text-center" style="font-size:16px"><strong>K U I T A N S I</strong></p>
<table class="table">
	<tr>
		<td style="padding-left:10px; padding-bottom:10px;">
			Sudah terima dari
		</td>
		<td style="padding-left:10px; padding-bottom:10px;">
			: Kuasa Pengguna Anggaran<br>&nbsp;&nbsp;<?= $satker?>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom:10px;">
			Uang Sebanyak
		</td>
		<td style="padding-left:10px; padding-bottom:10px;">
			: <strong><i>Rp.&nbsp;&nbsp;&nbsp;&nbsp;<?= $jumlah ?></i></strong>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom:10px;">
			Untuk Pembayaran
		</td>
		<td style="padding-left:10px; padding-bottom:10px;">
			: Biaya Perjalanan Dinas <?= $hal ?> di Kecamatan <?= $destinasi ?>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom:10px;">
			Berdasarkan SPD No.
		</td>
		<td style="padding-left:10px; padding-bottom:10px;">
			: <?= $nomor ?>/SPD/<?= date("m",strtotime($tglenglish));?>/<?= date('Y')?>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom:10px;">
			Tanggal
		</td>
		<td style="padding-left:10px; padding-bottom:10px;">
			: <?= $tanggal ?>
		</td>
	</tr>
	<tr>
		<td style="padding-left:10px; padding-bottom:10px;">
			Terbilang
		</td>
		<td style="padding-left:10px; padding-bottom:10px;">
			: <strong><i><?= $terbilang ?> Rupiah</i></strong>
		</td>
	</tr>
</table>
<br>
<div style="float:right; width:30%">
	<?= $alamatkantor ?>,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= date('Y'); ?>
</div>
<br>
<table class="table" style="padding-left:-20px">
	<tr>
		<td class="text-center" style="padding-left:10px; padding-bottom:10px;">
			Setuju Dibayar<br>
			A.n Kuasa Pengguna Anggaran<br>
			Pejabat Pembuat Komitmen<br>
			<?= $satker ?><br>
			<br><br><br><br>
			<u><?= $ppk ?></u><br>
			NIP. <?= $nipppk ?>
		</td>
		<td class="text-center" style="padding-left:10px; padding-bottom:10px;">
			Lunas Dibayar<br>
			Bendahara Pengeluaran<br>
			<br><br>
			<br><br><br><br>
			<u><?= $bendahara ?></u><br>
			NIP. <?= $nipbendahara ?>
		</td>
		<td class="text-center" style="padding-left:10px; padding-bottom:10px;">
			Yang Menerima,<br><br>
			<br><br>
			<br><br><br><br>
			<u><?= $nama ?></u><br>
			NIP. <?= $nip ?>
		</td>
	</tr>
</table>
