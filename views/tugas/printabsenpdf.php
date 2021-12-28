<?php

use yii\helpers\Html;
  $data=json_decode($data);
  $workingday=0;
  $nonworkingday=0;
  $holiday=0;
  $workday=0;
  $absencestatus=0;
  $absent=0;
  $totalalpa=0;
  $latein=0;
 ?>
 <h3><p class="text-center"> Attendance Report</p></h3>
 <table class="table">
   <tr>
     <th>
       Name : <?= $name?>
     </th>
     <th style="padding-left:80px;">
       Organization : <?= $organization?>
     </th>
   </tr>
 </table>
 <table class="table table-bordered">
   <thead>
      <tr>
        <th><p style="font-size:80%">Day</p></th>
        <th><p style="font-size:80%">Date</p></th>
        <th><p style="font-size:80%">Working Hour</p></th>
        <th><p style="font-size:80%">Activity</p></th>
        <th><p style="font-size:80%">Duty On</p></th>
        <th><p style="font-size:80%">Break Out</p></th>
        <th><p style="font-size:80%">Break In</p></th>
        <th><p style="font-size:80%">Duty Off</p></th>
        <th><p style="font-size:80%">Late In</p></th>
        <th><p style="font-size:80%">Early Dept</p></th>
        <th><p style="font-size:80%">OT Before</p></th>
        <th><p style="font-size:80%">OT After</p></th>
        <th><p style="font-size:80%">Total Hour</p></th>
        <th><p style="font-size:80%">Notes</p></th>
      </tr>
    </thead>
    <tbody>
      <?php
        foreach($data as $dat)
        {
          if(strpos( $dat[2], 'Off' ) !== false)
          {
            $nonworkingday++;
          }
          else if(strpos( $dat[2], 'holiday' ) !== false){
            $holiday++;
          }
          else {
            $workingday++;
          }
          if(strpos($dat[3],'Work') !== false)
          {
            $workday++;
          }
          else if(strpos($dat[3],'Absent') !== false)
          {
            $absent++;
          }
          if(strlen($dat[6])>0)
          {
            $latein++;
          }
          echo '
          <tr>
          <td><p style="font-size:80%">'.$dat[0].'</p></td>
          <td><p style="font-size:80%">'.$dat[1].'</p></td>
          <td><p style="font-size:80%">'.$dat[2].'</p></td>
          <td><p style="font-size:80%">'.$dat[3].'</p></td>
          <td><p style="font-size:80%">'.$dat[4].'</p></td>
          <td></td>
          <td></td>
          <td><p style="font-size:80%">'.$dat[5].'</p></td>
          <td><p style="font-size:80%">'.$dat[6].'</p></td>
          <td></td>
          <td></td>
          <td></td>
          <td><p style="font-size:80%">'.$dat[7].'</p></td>
          <td><p style="font-size:80%">'.$dat[8].'</p></td>
          </tr>';
        }
      ?>
    </tbody>
</table>
<div id="keterangan">
  <div style="float:left;  width: 20%;">
    <p style="font-size:80%">
    Working Day <br>
    Non Working Day <br>
    Holiday <br>
    Attendance<br>
        Work Day<br>
        Non Work Day<br>
    Absence Status + Absent <br>
    Absent <br>
    Late <br>
    Early Departure <br>
    Over Time <br>
    Lupa Absen Datang <br>
    Lupa Absen Pulang <br>
    Total Alpa <br>
  </p>
  </div>
  <div style="float:right;  width: 80%;">
    <p style="font-size:80%">
      : <?= $workingday ?><br>
      : <?= $nonworkingday ?><br>
      : <?= $holiday ?><br>
      : <br>
      : <?= $workday ?><br>
      : <br>
      : <?= $absent ?><br>
      : <?= $absent ?><br>
      : <?= $latein ?><br>
      : <br>
      : <br>
      : <br>
      : <br>
      : <?= $absent ?><br>
    </p>
  </div>
</div>
