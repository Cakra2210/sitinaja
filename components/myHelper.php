<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use \Datetime;
use \DateInterval;
use \DatePeriod;
class myHelper extends Component
{
  private $statusKomponen = [
        'Persiapan' => 'Persiapan',
        'Pengumpulan Data' => 'Pengumpulan Data',
        'Pengolahan Dan Analisis' => 'Pengolahan Dan Analisis',
        'Diseminasi Dan Evaluasi' => 'Diseminasi Dan Evaluasi',
        'Pelaksanaan Sensus Sampel' => 'Pelaksanaan Sensus Sampel',
        'Pengolahan SP2020 Lanjutan' => 'Pengolahan SP2020 Lanjutan',
        'Perhitungan Parameter Demografi' => 'Perhitungan Parameter Demografi',
        'Penyusunan Integrasi Data Spasial Wilkerstat dan Muatan Hasil SP2020' => 'Penyusunan Integrasi Data Spasial Wilkerstat dan Muatan Hasil SP2020',
        'Pengolahan Longform SP2020' => 'Pengolahan Longform SP2020',
        ' '=> ' '
    ];
  private $agama = [
        '1' => 'Islam',
        '2' => 'Kristen Protestan',
        '3' => 'Kristen Katolik',
        '4' => 'Hindu',
        '5' => 'Budha',
        '6' => 'Konghucu'
    ];
    
    private $pendidikan = [
        '1' => 'SMA',
        '2' => 'D3',
        '3' => 'D4',
        '4' => 'S1',
        '5' => 'S2',
        '6' => 'S3'
        
    ];
    private $jenisKelamin = [
        '1' => 'Laki-Laki',
        '2' => 'Perempuan'
    ];
    private $statusPegawai = [
        '1' => 'PNS',
        '2' => 'Kontrak'
    ];
    private $statusNikah = [
        '1' => 'Belum Menikah',
        '2' => 'Menikah',
        '3' => 'Cerai Hidup',
        '4' => 'Cerai Mati'
    ];
    private $jabatan = [
        'PCL' => 'PCL',
        'PML' => 'PML',
        'Supervisi' => 'Suvervisi',
        'Editing/Coding' => 'Editing/Coding',
        'Petugas Pengolahan' => 'Petugas Pengolahan',
        'Petugas Digitalisasi' => 'Petugas Digitalisasi',
        'Koseka' => 'Koseka',
        'Kortim' => 'Kortim',
        'Instruktur Nasional' => 'Instruktur Nasional',
        'Instruktur Daerah' => 'Instruktur Daerah'
    ];

   private $satuan = [
        'Blok Sensus' => 'Blok Sensus',
        'Dokumen' => 'Dokumen',
        'Kunjungan' => 'Kunjungan',
        'Responden' => 'Responden',
        'Rumah Tangga' => 'Rumah Tangga',
        'Perusahaan' => 'Perusahaan',
        'O-H' => 'O-H',
        'O-J' => 'O-J',
        'O-K' => 'O-K',
        'Ubinan' => 'Ubinan',
    ];

    private $bank = [
        '1' => 'Bank Rakyat Indonesia',
        '2' => 'Bank Syariah Indonesia'
        
    ];

  public function listStatusKomponen()
    {
        return $this->statusKomponen;
    }

  public function getStatusKoponen($id)
    {
        return $this->statusKomponen[$id];
    }
    public function listAgama()
    {
        return $this->agama;
    }
    public function listPendidikan()
    {
        return $this->pendidikan;
    }
    public function listJenisKelamin()
    {
        return $this->jenisKelamin;
    }
    public function listStatusPegawai()
    {
        return $this->statusPegawai;
    }
    public function listStatusNikah()
    {
        return $this->statusNikah;
    }
    public function listJabatan()
    {
        return $this->jabatan;
    }
    public function listSatuan()
    {
        return $this->satuan;
    }
     public function listbank()
    {
        return $this->bank;
    }

    public function getAgama($id)
    {
        return $this->agama[$id];
    }

    public function getPendidikan($id)
    {
        return $this->pendidikan[$id];
    }

    public function getJenisKelamin($id)
    {
        return $this->jenisKelamin[$id];
    }

    public function getStatusPegawai($id)
    {
        return $this->statusPegawai[$id];
    }

    public function getStatusNikah($id)
    {
        return $this->statusNikah[$id];
    }
     public function getJabatan($id)
    {
        return $this->jabatan[$id];
    }
     public function getSatuan($id)
    {
        return $this->satuan[$id];
    }
    public function getBank($id)
    {
        return $this->bank[$id];
    }

  public function indonesian_date ($timestamp = '', $date_format = 'j F Y ', $suffix = 'WIB') {
    if (trim ($timestamp) == '')
    {
        $timestamp = time ();
    }
    elseif (!ctype_digit ($timestamp))
    {
      $timestamp = strtotime ($timestamp);
    }
    # remove S (st,nd,rd,th) there are no such things in indonesia :p
    $date_format = preg_replace ("/S/", "", $date_format);
    $pattern = array (
      '/Mon[^day]/','/Tue[^sday]/','/Wed[^nesday]/','/Thu[^rsday]/',
      '/Fri[^day]/','/Sat[^urday]/','/Sun[^day]/','/Monday/','/Tuesday/',
      '/Wednesday/','/Thursday/','/Friday/','/Saturday/','/Sunday/',
      '/Jan[^uary]/','/Feb[^ruary]/','/Mar[^ch]/','/Apr[^il]/','/May/',
      '/Jun[^e]/','/Jul[^y]/','/Aug[^ust]/','/Sep[^tember]/','/Oct[^ober]/',
      '/Nov[^ember]/','/Dec[^ember]/','/January/','/February/','/March/',
      '/April/','/June/','/July/','/August/','/September/','/October/',
      '/November/','/December/',
    );
    $replace = array ( 'Sen','Sel','Rab','Kam','Jum','Sab','Min',
      'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu',
      'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des',
      'Januari','Februari','Maret','April','Juni','Juli','Agustus','September',
      'Oktober','November','Desember',
    );
    $date = date ($date_format, $timestamp);
    $date = preg_replace ($pattern, $replace, $date);
    $date = "{$date} ";
    return $date;
  }
  public function config()
  {
    $c=\app\models\Config::findOne([
      'id'=>'1'
    ]);
    return $c;
  }
  
  public function skitemById($id)
  {
    $p=\app\models\Skitem::findOne([
      'id'=>$id
    ]);
    return $p;
  }
  
  public function roomById($id)
  {
    $p=\app\models\Kak::findOne([
      'id'=>$id
    ]);
    return $p;
  }
  public function seksiById($id)
  {
    $p=\app\models\Seksi::findOne([
      'id'=>$id
    ]);
    return $p;
  }
  public function seksiByJab($jab)
  {
    $p=\app\models\Seksi::findOne([
      'jab'=>$jab
    ]);
    return $p;
  }
  public function jabatanById($id)
  {
    $p=\app\models\Jabatan::findOne([
      'assignee'=>$assignee
    ]);
    return $p;
  }
  
  public function pok21ById($id)
  {
    $p=\app\models\Pok21::findOne([
      'id'=>$id
    ]);
    return $p;
  }
  public function pok21Nama($id)
  {
    $p=\app\models\Pok21::findOne([
      'id'=>$so
    ]);
    return $p;
  }
  public function skitemByperson($person_id)
  {
    $p=\app\models\Skitem::findOne([
      'person_id'=>$person_id
    ]);
    return $p;
  }
  public function roomByperson($house_id)
  {
    $p=\app\models\Room::findOne([
      'house_id'=>$house_id
    ]);
    return $p;
  }
  public function hitungHari($date1,$date2)
  {
    $date1 = strtotime($date1);
    $date2 = strtotime($date2);

    $difference = $date2 - $date1;
    $day=floor($difference / 86400);
    return $day+1;
    /*
    if($day==0)
    {
      return ($day+1);
    }
    else if($day==1)
    {
      return($day+1);
    }
    else {
      return $day;
    }*/
  }
  public function pegawaiByJabatan($id_jabatan)
  {
    $p=\app\models\Pegawai::findOne([
            'id_jabatan'=>$id_jabatan
          ]);
    return $p;
  }
  public function pegawaiById($id)
  {
    $p=\app\models\Pegawai::findOne([
            'id'=>$id
          ]);
    return $p;
  }
  public function mitraById($id)
  {
    $p=\app\models\Mitra::findOne([
            'id'=>$id
          ]);
    return $p;
  }
  public function pegawaiByNama($nama)
  {
    $p=\app\models\Pegawai::findOne([
            'nama'=>$nama
          ]);
    return $p;
  }
  public function mitraByNama($nama)
  {
    $p=\app\models\Mitra::findOne([
            'nama'=>$nama
          ]);
    return $p;
  }

  function penyebut($day) {
    $nilai = abs($day);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) 
    return " " . $huruf[$day];
    elseif ($day < 20)
    return $this->penyebut($day - 10) . "belas";
    elseif ($day < 100)
    return $this->penyebut($day / 10) . " puluh" . $this->penyebut($day % 10);

    //}  
    //return $temp;
  }
  public function terbilang($x)
  {
    $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    if ($x < 12)
    return " " . $abil[$x];
    elseif ($x < 20)
    return $this->terbilang($x - 10) . "belas";
    elseif ($x < 100)
    return $this->terbilang($x / 10) . " puluh" . $this->terbilang($x % 10);
    elseif ($x < 200)
    return " seratus" . $this->terbilang($x - 100);
    elseif ($x < 1000)
    return $this->terbilang($x / 100) . " ratus" . $this->terbilang($x % 100);
    elseif ($x < 2000)
    return " seribu" . $this->terbilang($x - 1000);
    elseif ($x < 1000000)
    return $this->terbilang($x / 1000) . " ribu" . $this->terbilang($x % 1000);
    elseif ($x < 1000000000)
    return $this->terbilang($x / 1000000) . " juta" . $this->terbilang($x % 1000000);


  }
  public function formatRupiah($rp)
  {
    return number_format( $rp ,0, '' , '.' );
  }
  public function hariIndonesia($tanggal)
  {
    $day = date('D', strtotime($tanggal));
    $dayList = array(
      'Sun' => 'Minggu',
      'Mon' => 'Senin',
      'Tue' => 'Selasa',
      'Wed' => 'Rabu',
      'Thu' => 'Kamis',
      'Fri' => 'Jumat',
      'Sat' => 'Sabtu'
    );
    return $dayList[$day];
  }
  public function bulanIndonesia($bulan)
  {
    $month = date('M', strtotime($bulan));
    $monthList = array(
      'Jan' => 'Januari',
      'Feb' => 'Februari',
      'Mar' => 'Maret',
      'Apr' => 'April',
      'May' => 'Mei',
      'Jun' => 'Juni',
      'Jul' => 'Juli',
      'Aug' => 'Agustus',
      'Sep' => 'September',
      'Oct' => 'Oktober',
      'Nov' => 'November',
      'Des' => 'Desember',

    );
    return $monthList[$month];
  }
  public function cekTanggal($start_date,$end_date,$userid,$par,$id){
    $queryiftugas='';
    $queryifmemo='';
    $queryifijincuti='';
    $queryand=' AND `id` NOT IN('.$id.')';
    //0 create, 1 tugas, 2 memo, 3 ijincuti, 4 tugaskolektif, 5 Editkolektif
    if($par==1)
    {
      $queryiftugas=$queryand;
    }else if($par==2)
    {
      $queryifmemo=$queryand;
    }
    else if($par==3)
    {
      $queryifijincuti=$queryand;
    }

    $checkdate=false;
    $connection = Yii::$app->getDb();
    $commandtugas='';

    if($par==4)
    {
      $commandtugas = $connection->createCommand("
        SELECT COUNT(id) AS cnt FROM `tugas` WHERE
        '".$start_date."' <= `date_end` AND '".$end_date."' >= `date_start`
        AND `id_pegawai`IN(".$userid.") ".$queryiftugas." AND blok_absen=1
      ");
    }else {
      $commandtugas = $connection->createCommand("
        SELECT COUNT(id) AS cnt FROM `tugas` WHERE
        '".$start_date."' <= `date_end` AND '".$end_date."' >= `date_start`
        AND `id_pegawai` IN(".$userid.") ".$queryiftugas." AND blok_absen=1
      ");
    }

    $result = $commandtugas->queryAll();

    if($result[0]['cnt']>0)
    {
      $checkdate = true;
    }

    $commandmemo='';
    if($par==4)
    {
      $commandmemo = $connection->createCommand("
        SELECT COUNT(id) AS cnt FROM `memo` WHERE
        (`jam_keluar` LIKE '".$start_date."%' OR `jam_pulang` LIKE '".$end_date."%')
        AND `id_pegawai` IN(".$userid.") ".$queryifmemo."
      ");
    }else {
      $commandmemo = $connection->createCommand("
        SELECT COUNT(id) AS cnt FROM `memo` WHERE
        (`jam_keluar` LIKE '".$start_date."%' OR `jam_pulang` LIKE '".$end_date."%')
        AND `id_pegawai`IN(".$userid.") ".$queryifmemo."
      ");
    }


    $result2 = $commandmemo->queryAll();
    if($result2[0]['cnt']>0)
    {
      $checkdate = true;
    }

    $commandijincuti='';
    if($par==4)
    {
      $commandijincuti = $connection->createCommand("
        SELECT COUNT(id) AS cnt FROM `ijincuti` WHERE
        '".$start_date."' <= `date_end` AND '".$end_date."' >= `date_start`
        AND `id_pegawai` IN(".$userid.") ".$queryifijincuti."
      ");
    }
    else{
      $commandijincuti = $connection->createCommand("
        SELECT COUNT(id) AS cnt FROM `ijincuti` WHERE
        '".$start_date."' <= `date_end` AND '".$end_date."' >= `date_start`
        AND `id_pegawai` IN(".$userid.") ".$queryifijincuti."
      ");
    }

    $result3 = $commandijincuti->queryAll();
    if($result3[0]['cnt']>0)
    {
      $checkdate = true;
    }

    return $checkdate;

  }
  public function isWeekend($date)
  {
    $weekDay = date('w', strtotime($date));
    return ($weekDay == 0 || $weekDay == 6);
  }
 function number_of_working_days($from, $to) {
    $workingDays = [1, 2, 3, 4, 5]; # date format = N (1 = Monday, ...)
    $holidayDays = ['*-12-25', '*-01-01','*-06-01','*-05-01','*-08-17','2021-05-26','2021-07-20','2021-08-10']; # variable and fixed holidays

    $from = new DateTime($from);
    $to = new DateTime($to);
    $to->modify('+1 day');
    $interval = new DateInterval('P1D');
    $periods = new DatePeriod($from, $interval, $to);

    $days = 0;
    foreach ($periods as $period) {
        if (!in_array($period->format('N'), $workingDays)) continue;
        if (in_array($period->format('Y-m-d'), $holidayDays)) continue;
        if (in_array($period->format('*-m-d'), $holidayDays)) continue;
        $days++;
    }
    return $days;
  }
  function dateDifference($date_1 , $date_2 , $differenceFormat = '%y Tahun %m Bulan' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);

}
  public function getMitrabyid($id)
  {
    $mitra=\app\models\Mitra::findOne([
            'id'=>$id
          ]);
    return $mitra;
  }
  public function getRoombyid($id)
  {
    $room=\app\models\Room::findOne([
            'id'=>$id
          ]);
    return $room;
  }
  public function getHousebyid($id)
  {
    $house=\app\models\House::findOne([
            'id'=>$id
          ]);
    return $house;
  }
  public function getShift($id)
  {
    $shift=\app\models\Shift::findOne([
            'id'=>$id
          ]);
    return $shift;
  }
  public function getTugasbyid($id)
  {
    $tugas=\app\models\Tugas::findOne([
      'id'=>$id
    ]);
    return $tugas;
  }
  public function getJabatanbyid($id)
  {
    $jabatan=\app\models\Jabatan::findOne([
      'id_jabatan'=>$id
    ]);
    return $jabatan;
  }
  public function getSkitemByNama($id)
  {
    $skitem=\app\modelsSkitem::findOne([
      'id'=>$person_id
    ]);
    return $skitem;
  }
  public function getRoomByNama($id)
  {
    $room=\app\modelsRoom::findOne([
      'id'=>$house_id
    ]);
    return $room;
  }
  public function getSeksibyidtugas($id)
  {
    $assignee_id=$this->getTugasById($id)->assignee;
    $seksi=\app\models\Seksi::findOne([
      'id'=>$assignee_id
    ]);
    return $seksi;
  }
  public function getSeksibyidgroup($id)
  {
    $tugas=\app\models\Tugas::find()
    ->select('assignee')
    ->where(['id_group'=>$id])
    ->one();
    $seksi=\app\models\Seksi::findOne([
      'id'=>$tugas->assignee
    ]);
    return $seksi;
  }
  public function getKepalaseksibykode($id)
  {
    $jabatan=\app\models\Jabatan::find()
    ->where(['kode_seksi'=>$id])
    ->andWhere(['like', 'jabatan', 'kepala'])
    ->one();
    return $jabatan;
  }
  public function isKepalaseksi($id_jabatan)
  {
    $jabatan=\app\models\Jabatan::find()
    ->select(['jabatan'])
    ->where(['id_jabatan'=>$id_jabatan])
    ->one();
    $jabatan=$jabatan->jabatan;
    if(strpos($jabatan,'Koordinator')!==false||strpos($jabatan,'Kepala Sub Bagian Umum')!==false||strpos($jabatan,'Sub Koordinator Fungsi ')!==false)
    {
      return true;
    }else {
      return false;
    }
  }

}
?>
