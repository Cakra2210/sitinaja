<?php
use yii\helpers\Html;
?>
<div>
  <h4><p class="text-center">TARGET KINERJA PEGAWAI TAHUN <?= $tahun ?></p></h4>
  <div>
    <div style="float:left; width: 50%;">
  		Satuan Organisasi : <?= $satker?><br>
  		Nama &#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;: <?= $nama ?><br>
  		Jabatan &#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;: <?= $jabatan ?><br>
      Periode &#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;: <?= $start ?> - <?= $end ?><br>
  	</div>
    <div style="float:right; width: 10%;">
      <table class="table table-bordered">
        <tr>
          <td style="padding-left:10px; padding-bottom: 10px; padding-top: 10px; border-color:#000000">
            <h4><p class="text-center">CKP-T</p></h4>
          </td>
        </tr>
      </table>
    </div>
  </div>
  <table class="table table-bordered">
    <tr>
      <td style="padding-left:5px; padding-bottom: 20px; padding-top: 20px; border-color:#000000">
  			<center><strong>No</strong></center>
  		</td>
      <td style="padding-left:20px; padding-bottom: 20px; padding-top: 20px; border-color:#000000">
  			<strong>Uraian Kegiatan</strong>
  		</td>
      <td style="padding-left:20px; padding-bottom: 20px; padding-top: 20px; border-color:#000000">
  			<strong>Satuan</strong>
  		</td>
      <td style="padding-left:2px;padding-right:2px; padding-bottom: 20px; padding-top: 20px; border-color:#000000">
  			<center><strong>Target<br>Kuantitas</strong></center>
  		</td>
      <td style="padding-left:20px;padding-right:20px;  padding-bottom: 20px; padding-top: 20px; border-color:#000000">
  			<strong>Kode Butir<br>Kegiatan</strong>
  		</td>
      <td style="padding-left:20px;padding-right:20px; padding-bottom: 20px; padding-top: 20px; border-color:#000000">
  			<strong>Angka<br>Kredit</strong>
  		</td>
      <td style="padding-left:20px; padding-bottom: 20px; padding-top: 20px; border-color:#000000">
  			<strong>Keterangan</strong>
  		</td>
    </tr>
    <tr>
      <td style="padding-left:5px; padding-bottom: 10px; border-color:#000000">
  			<center>(1)</center>
  		</td>
      <td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
  			<center>(2)</center>
  		</td>
      <td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
  			<center>(3)</center>
  		</td>
      <td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
  			<center>(4)</center>
  		</td>
      <td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
  			<center>(5)</center>
  		</td>
      <td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
  			<center>(6)</center>
  		</td>
      <td style="padding-left:10px; padding-bottom: 10px; border-color:#000000">
  			<center>(7)</center>
  		</td>
    </tr>
    <tr>
      <td style="padding-left:10px;  border-color:#000000">

  		</td>
      <td style="padding-left:10px; border-color:#000000">
  			<strong>UTAMA</strong>
  		</td>
      <td style="padding-left:10px; border-color:#000000">

  		</td>
      <td style="padding-left:10px;  border-color:#000000">

  		</td>
      <td style="padding-left:10px;  border-color:#000000">

  		</td>
      <td style="padding-left:10px;  border-color:#000000">

  		</td>
      <td style="padding-left:10px;  border-color:#000000">

  		</td>
    </tr>
      <?php
          $no=1;
          foreach($model as $models)
          {
            $persentase=0;
            if($models['target']!=0 && $models['realisasi']!=0)
            {
              $persentase = 100*($models['realisasi']/$models['target']);
            }
            if($models['assignee']==$idseksi)
            {
              echo '<tr>
              <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
              '.$no.'
              </td>
              <td style="padding-left:10px; padding-bottom:10px;padding-top:10px; border-color:#000000">
                '.$models['kegiatan'].'
              </td>
              <td style="padding-left:10px; padding-bottom:10px;padding-top:10px; border-color:#000000">
                '.$models['satuan'].'
              </td>
              <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                <center>'.$models['target'].'</center>
              </td>
              <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                '.$models['kd_butir'].'
              </td>
              <td style="padding-left:10px; padding-bottom:10px;padding-top:10px;  border-color:#000000">
                '.$models['angka_kredit'].'
              </td>
              <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                '.$models['keterangan'].'
              </td>
              </tr>'
              ;
              $no++;
            }
          }

       ?>
       <tr>
         <td style="padding-left:10px;  border-color:#000000">

     		</td>
         <td style="padding-left:10px; border-color:#000000">
     			<strong>TAMBAHAN</strong>
     		</td>
         <td style="padding-left:10px; border-color:#000000">

     		</td>
         <td style="padding-left:10px;  border-color:#000000">

     		</td>
         <td style="padding-left:10px;  border-color:#000000">

     		</td>
         <td style="padding-left:10px;  border-color:#000000">

     		</td>
         <td style="padding-left:10px;  border-color:#000000">

     		</td>
       </tr>
       <?php
           $no=1;
           foreach($model as $models)
           {
             $persentase=0;
             if($models['target']!=0 && $models['realisasi']!=0)
             {
               $persentase = 100*($models['realisasi']/$models['target']);
             }
             if($models['assignee']!=$idseksi)
             {
               echo '<tr>
               <td style="padding-left:10px; padding-bottom:10px; padding-top:10px;  border-color:#000000">
               '.$no.'
               </td>
               <td style="padding-left:10px; padding-bottom:10px; padding-top:10px;border-color:#000000">
                 '.$models['kegiatan'].'
               </td>
               <td style="padding-left:10px; padding-bottom:10px; padding-top:10px;border-color:#000000">
                 '.$models['satuan'].'
               </td>
               <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                 <center>'.$models['target'].'</center>
               </td>
               <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                 '.$models['kd_butir'].'
               </td>
               <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                 '.$models['angka_kredit'].'
               </td>
               <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                 '.$models['keterangan'].'
               </td>
               </tr>'
               ;
               $no++;
             }
           }

        ?>
  </table>

  <p class="text-center">Pegawai yang dinilai</p>
  <br>
  <br>
  <p class="text-center">(<?= $nama ?>)
  <br>NIP. <?= $nip ?></p>
</div>
<pagebreak>
  <div>
    <h4><p class="text-center">TARGET KINERJA PEGAWAI TAHUN <?= $tahun ?></p></h4>
    <div>
      <div style="float:left; width: 50%;">
    		Satuan Organisasi : <?= $satker?><br>
    		Nama &#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;: <?= $nama ?><br>
    		Jabatan &#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;: <?= $jabatan ?><br>
        Periode &#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;&#9;: <?= $start ?> - <?= $end ?><br>
    	</div>
      <div style="float:right; width: 10%;">
        <table class="table table-bordered">
          <tr>
            <td style="padding-left:10px; padding-bottom: 10px; padding-top: 10px; border-color:#000000">
              <h4><p class="text-center">CKP-R</p></h4>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <table class="table table-bordered">
      <tr>
        <td style="padding-left:5px; padding-top: 20px; border-color:#000000; border-bottom-color:#ffffff;">
    			<center><strong>No</strong></center>
    		</td>
        <td style="padding-left:20px; padding-top: 20px; border-color:#000000;border-bottom-color:#ffffff;">
    			<strong>Uraian Kegiatan</strong>
    		</td>
        <td style="padding-left:20px; padding-top: 20px; border-color:#000000;border-bottom-color:#ffffff;">
    			<strong>Satuan</strong>
    		</td>
        <td colspan="3" style="padding-left:2px;padding-right:2px;padding-top: 20px; border-color:#000000">
    			<center><strong>Target Kuantitas</strong></center>
    		</td>
        <td style="padding-left:20px;  padding-top: 20px; border-color:#000000;border-bottom-color:#ffffff;">
    			<strong>Target<br>Kualitas</strong>
    		</td>
        <td style="padding-left:20px; padding-top: 20px; border-color:#000000;border-bottom-color:#ffffff;">
    			<strong>Kode Butir Kegiatan</strong>
    		</td>
        <td style="padding-left:20px; padding-right:20px; padding-top: 20px; border-color:#000000;border-bottom-color:#ffffff;">
    			<strong>Angka<br>Kredit</strong>
    		</td>
        <td style="padding-left:20px; padding-top: 20px; border-color:#000000;border-bottom-color:#ffffff;">
    			<strong>Keterangan</strong>
    		</td>
      </tr>
      <tr>
        <td style="padding-left:5px; padding-bottom: 20px; padding-top: 20px; border-color:#000000">

    		</td>
        <td style="padding-left:20px; padding-bottom: 20px; padding-top: 20px; border-color:#000000">

    		</td>
        <td style="padding-left:20px; padding-bottom: 20px; padding-top: 20px; border-color:#000000">

    		</td>
        <td style="padding-left:2px;padding-right:2px; padding-bottom: 20px; padding-top: 20px; border-color:#000000">
    			<center><strong>Target</strong></center>
    		</td>
        <td style="padding-left:2px;padding-right:2px; padding-bottom: 20px; padding-top: 20px; border-color:#000000">
    			<center><strong>Realisasi</strong></center>
    		</td>
        <td style="padding-left:2px;padding-right:2px; padding-bottom: 20px; padding-top: 20px; border-color:#000000">
    			<center><strong>%</strong></center>
    		</td>
        <td style="padding-left:20px; padding-bottom: 20px; padding-top: 20px; border-color:#000000">

    		</td>
        <td style="padding-left:20px; padding-bottom: 20px; padding-top: 20px; border-color:#000000">

    		</td>
        <td style="padding-left:20px; padding-bottom: 20px; padding-top: 20px; border-color:#000000">

    		</td>
        <td style="padding-left:20px; padding-bottom: 20px; padding-top: 20px; border-color:#000000">

    		</td>
      </tr>
      <tr>
        <td style="padding-left:5px; padding-bottom: 2px; padding-top: 2px; border-color:#000000">
          (1)
    		</td>
        <td style="padding-left:5px; padding-bottom: 2px; padding-top: 2px; border-color:#000000">
          (2)
    		</td>
        <td style="padding-left:5px; padding-bottom: 2px; padding-top: 2px; border-color:#000000">
          (3)
    		</td>
        <td style="padding-left:5px;padding-right:2px; padding-bottom: 2px; padding-top: 2px; border-color:#000000">
    			(4)
    		</td>
        <td style="padding-left:5px;padding-right:2px; padding-bottom: 2px; padding-top: 2px; border-color:#000000">
    			(5)
    		</td>
        <td style="padding-left:5px;padding-right:2px; padding-bottom: 2px; padding-top: 2px; border-color:#000000">
    			(6)
    		</td>
        <td style="padding-left:5px; padding-bottom: 2px; padding-top: 2px; border-color:#000000">
          (7)
    		</td>
        <td style="padding-left:5px; padding-bottom: 2px; padding-top: 2px; border-color:#000000">
          (8)
    		</td>
        <td style="padding-left:5px; padding-bottom: 2px; padding-top: 2px; border-color:#000000">
          (9)
    		</td>
        <td style="padding-left:5px; padding-bottom: 2px; padding-top: 2px; border-color:#000000">
          (10)
    		</td>
      </tr>

      <?php
          $temppersentase=0;
          $tempkualitas=0;
          $tempno=0;
          $no=1;
          foreach($model as $models)
          {
            $persentase=0;
            if($models['target']!=0 && $models['realisasi']!=0)
            {
              $persentase = 100*($models['realisasi']/$models['target']);
            }

            if($models['assignee']==$idseksi)
            {
              $temppersentase+=$persentase;
              $tempkualitas+=$models['kualitas'];
              $tempno++;
              echo '<tr>
              <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
              '.$no.'
              </td>
              <td style="padding-left:10px; padding-bottom:10px;padding-top:10px; border-color:#000000">
                '.$models['kegiatan'].'
              </td>
              <td style="padding-left:10px; padding-bottom:10px;padding-top:10px; border-color:#000000">
                '.$models['satuan'].'
              </td>
              <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                <center>'.$models['target'].'</center>
              </td>
              <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                <center>'.$models['realisasi'].'</center>
              </td>
              <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                <center>'.$persentase.'</center>
              </td>
              <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                '.$models['kualitas'].'
              </td>
              <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                '.$models['kd_butir'].'
              </td>
              <td style="padding-left:10px; padding-bottom:10px;padding-top:10px;  border-color:#000000">
                '.$models['angka_kredit'].'
              </td>
              <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                '.$models['keterangan'].'
              </td>
              </tr>'
              ;
              $no++;
            }
          }

       ?>
       <tr>
         <td style="padding-left:10px;  border-color:#000000">

     		</td>
         <td style="padding-left:10px; border-color:#000000">
     			<strong>TAMBAHAN</strong>
     		</td>
         <td style="padding-left:10px; border-color:#000000">

     		</td>
         <td style="padding-left:10px;  border-color:#000000">

     		</td>
         <td style="padding-left:10px;  border-color:#000000">

     		</td>
         <td style="padding-left:10px;  border-color:#000000">

     		</td>
         <td style="padding-left:10px;  border-color:#000000">

     		</td>
        <td style="padding-left:10px;  border-color:#000000">

       </td>
       <td style="padding-left:10px;  border-color:#000000">

      </td>
      <td style="padding-left:10px;  border-color:#000000">

     </td>
       </tr>
       <?php
           $no=1;
           foreach($model as $models)
           {
             $persentase=0;
             if($models['target']!=0 && $models['realisasi']!=0)
             {
               $persentase = 100*($models['realisasi']/$models['target']);
             }

             if($models['assignee']!=$idseksi)
             {
               $temppersentase+=$persentase;
               $tempkualitas+=$models['kualitas'];
               $tempno++;
               echo '<tr>
               <td style="padding-left:10px; padding-bottom:10px; padding-top:10px;  border-color:#000000">
               '.$no.'
               </td>
               <td style="padding-left:10px; padding-bottom:10px; padding-top:10px;border-color:#000000">
                 '.$models['kegiatan'].'
               </td>
               <td style="padding-left:10px; padding-bottom:10px; padding-top:10px;border-color:#000000">
                 '.$models['satuan'].'
               </td>
               <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                 <center>'.$models['target'].'</center>
               </td>
               <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                 <center>'.$models['realisasi'].'</center>
               </td>
               <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                 <center>'.(100*($models['realisasi']/$models['target'])).'</center>
               </td>
               <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                 '.$models['kualitas'].'
               </td>
               <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                 '.$models['kd_butir'].'
               </td>
               <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                 '.$models['angka_kredit'].'
               </td>
               <td style="padding-left:10px; padding-bottom:10px; padding-top:10px; border-color:#000000">
                 '.$models['keterangan'].'
               </td>
               </tr>'
               ;
               $no++;
             }
           }
          $meanpersentase=$temppersentase/$tempno;
          $meankualitas=$tempkualitas/$tempno;
          $meankegiatan=($meanpersentase+$meankualitas)/2;
        ?>
        <tr>
          <td colspan=5 style="padding-left:10px;  border-color:#000000">
            <strong>RATA-RATA</strong>
      		</td>
          <td style="padding-left:10px;  border-color:#000000">
            <strong><?= $meanpersentase ?></strong>
      		</td>
             <td style="padding-left:10px;  border-color:#000000">
              <strong><?= $meankualitas ?></strong>
            </td>
            <td style="padding-left:10px;  border-color:#000000; background-color:#080808">

           </td>
           <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
           </td>
           <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
           </td>
        </tr>
        <tr>
          <td colspan=5 style="padding-left:10px;  border-color:#000000">
            <strong>RATA-RATA KEGIATAN TUGAS JABATAN</strong>
          </td>
          <td colspan=2 style="padding-left:10px;  border-color:#000000">
            <strong><?= $meankegiatan ?></strong>
          </td>
          <td style="padding-left:10px;  border-color:#000000; background-color:#080808">

         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
        </tr>
        <tr>
          <td colspan=7 style="padding-left:10px;  border-color:#000000">
            <strong>PERILAKU</strong>
          </td>
          <td style="padding-left:10px;  border-color:#000000; background-color:#080808">

         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
        </tr>
        <?php
          $orientasi=100;
          $integritas=100;
          $komitmen=100;
          $disiplin=100;
          $kerjasama=100;
          $kepemimpinan='-';
          $rataperilaku=$orientasi+$integritas+$komitmen+$disiplin+$kerjasama;
          $rataperilaku=$rataperilaku/5;
          $ckp=(0.6*$meankegiatan)+(0.4*$rataperilaku);
         ?>
        <tr>
          <td style="padding-left:10px;  border-color:#000000;">
            1
         </td>
          <td colspan=4 style="padding-left:10px;  border-color:#000000">
            Orientasi Pelayanan
          </td>
          <td colspan=2 style="padding-left:10px;  border-color:#000000">
            <strong><?= $orientasi ?></strong>
          </td>
          <td style="padding-left:10px;  border-color:#000000; background-color:#080808">

         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
        </tr>

        <tr>
          <td style="padding-left:10px;  border-color:#000000;">
            2
         </td>
          <td colspan=4 style="padding-left:10px;  border-color:#000000">
            Integritas
          </td>
          <td colspan=2 style="padding-left:10px;  border-color:#000000">
            <strong><?= $integritas ?></strong>
          </td>
          <td style="padding-left:10px;  border-color:#000000; background-color:#080808">

         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
        </tr>

        <tr>
          <td style="padding-left:10px;  border-color:#000000;">
            3
         </td>
          <td colspan=4 style="padding-left:10px;  border-color:#000000">
            Komitmen
          </td>
          <td colspan=2 style="padding-left:10px;  border-color:#000000">
            <strong><?= $komitmen ?></strong>
          </td>
          <td style="padding-left:10px;  border-color:#000000; background-color:#080808">

         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
        </tr>

        <tr>
          <td style="padding-left:10px;  border-color:#000000;">
            4
         </td>
          <td colspan=4 style="padding-left:10px;  border-color:#000000">
            Disiplin
          </td>
          <td colspan=2 style="padding-left:10px;  border-color:#000000">
            <strong><?= $disiplin ?></strong>
          </td>
          <td style="padding-left:10px;  border-color:#000000; background-color:#080808">

         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
        </tr>

        <tr>
          <td style="padding-left:10px;  border-color:#000000;">
            5
         </td>
          <td colspan=4 style="padding-left:10px;  border-color:#000000">
            Kerjasama
          </td>
          <td colspan=2 style="padding-left:10px;  border-color:#000000">
            <strong><?= $kerjasama ?></strong>
          </td>
          <td style="padding-left:10px;  border-color:#000000; background-color:#080808">

         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
        </tr>

        <tr>
          <td style="padding-left:10px;  border-color:#000000;">
            6
         </td>
          <td colspan=4 style="padding-left:10px;  border-color:#000000">
            Kepemimpinan
          </td>
          <td colspan=2 style="padding-left:10px;  border-color:#000000">
            <strong><?= $kepemimpinan ?></strong>
          </td>
          <td style="padding-left:10px;  border-color:#000000; background-color:#080808">

         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
        </tr>

        <tr>
          <td colspan=5 style="padding-left:10px;  border-color:#000000">
            <strong>RATA-RATA PERILAKU</strong>
          </td>
          <td colspan=2 style="padding-left:10px;  border-color:#000000">
            <strong><?= $rataperilaku ?></strong>
          </td>
          <td style="padding-left:10px;  border-color:#000000; background-color:#080808">

         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
        </tr>

        <tr>
          <td colspan=5 style="padding-left:10px;  border-color:#000000">
            <strong>CAPAIAN KINERJA PEGAWAI</strong>
          </td>
          <td colspan=2 style="padding-left:10px;  border-color:#000000">
            <strong><?= $ckp ?></strong>
          </td>
          <td style="padding-left:10px;  border-color:#000000; background-color:#080808">

         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
         <td style="padding-left:10px;  border-color:#000000; background-color:#080808">
         </td>
        </tr>
    </table>
    <br>
    <br>
    <div style="padding-left:30px">
      <strong>Penilaian Kinerja</strong><br>
      Tanggal : <?= $end ?>
    </div><br>
    <div style="padding-left:200px">
      <div style="float:left; width: 50%;">
        Pegawai yang Dinilai
        <br><br><br><br><br><br>
        (<?= $nama ?>)<br>
        NIP. <?= $nip ?>
      </div>
      <div style="float:right; width: 50%;">
        Pegawai Penilai
        <br><br><br><br><br><br>
        (<?= $namaatasan ?>)<br>
        NIP. <?= $nipatasan ?>
      </div>
    </div>
  </div>
