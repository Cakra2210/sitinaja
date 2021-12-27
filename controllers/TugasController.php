<?php

namespace app\controllers;

use Yii;
use app\models\Tugas;
use app\models\TugasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use app\models\Pegawai;
use app\models\Memo;
use app\models\Ijincuti;
use app\models\Holiday;
use app\models\Ckp;
use app\models\CkpSearc;
use yii\web\UploadedFile;
/**
 * TugasController implements the CRUD actions for Tugas model.
 */
class TugasController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access'=>[
              'class'=> AccessControl::className(),
              'only'=>['index','create','view','printrekap','rekapabsen','createkolektif','editkolektif','update','delete','deletekolektif','rekap','report','listtugas', 'listsppd', 'savekolektif','viewkolektif','printkolektif','listtugaskolektif','getidpegawai','getidkegiatan'],
              'rules'=>[
                [
                  'allow'=>true,
                  'actions'=>['index','create','printrekap','rekapabsen', 'view','createkolektif','rekap','report','listtugas','listsppd','savekolektif','viewkolektif','printkolektif','listtugaskolektif','getidpegawai','getidkegiatan'],
                  'roles'=>['@']
                ],
                [
                  'allow'=>true,
                  'actions'=>['update','delete'],
                  'matchCallback'=>function(){
                    $id_jabatan=Yii::$app->user->identity->id_jabatan;
                    return
                    (
                      $id_jabatan =='1'||
                      //kasubag dan staf TU boleh delete
                      $id_jabatan =='3'||
                      $id_jabatan =='21'||
                      //seksi bersangkutan boleh edit
                      (Yii::$app->myHelper->getJabatanbyid($id_jabatan)->kode_seksi==Yii::$app->myHelper->getSeksibyidtugas(Yii::$app->request->get('id'))->kode&&Yii::$app->myHelper->isKepalaseksi(Yii::$app->user->identity->id_jabatan))
                    );
                  }
                ],
                [
                  'allow'=>true,
                  'actions'=>['editkolektif','deletekolektif'],
                  'matchCallback'=>function(){
                    $id_jabatan=Yii::$app->user->identity->id_jabatan;
                    return
                    (
                      $id_jabatan =='1'||
                      //kasubag dan staf TU boleh delete
                      $id_jabatan =='3'||
                      $id_jabatan =='21'||
                      //seksi bersangkutan boleh edit
                      (Yii::$app->myHelper->getJabatanbyid($id_jabatan)->kode_seksi==Yii::$app->myHelper->getSeksibyidgroup(Yii::$app->request->get('groupid'))->kode&&Yii::$app->myHelper->isKepalaseksi(Yii::$app->user->identity->id_jabatan))
                    );
                  }
                ],
              ],
            ],
        ];
    }

    /**
     * Lists all Tugas models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect(['/']);
    }

    /**
     * Displays a single Tugas model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Tugas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreatejurnal($iduser)
    {
      $model=new Tugas();
      $searchModel = new CkpSearc();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('id_pegawai = '.$iduser);
      return $this->render('createjurnal', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'model'=>$model,
      ]);

    }
    public function actionSavejurnal($kegiatan,$satuan,$jumlah,$iduser, $assignee)
    {

      $model = new Tugas();
      $model->id_pegawai = $iduser;
      $model->suratdasar = 'x';
      $model->program = 'x';
      $model->nosurat = 'x';
      $model->date_start = date('Y-m-d');
      $model->date_end = date('Y-m-d');
      $model->kegiatan = $kegiatan;
      $model->program = $program;
      $model->destinasi = 'x';
      $model->assignee = $assignee;
      $model->created_date = date('Y-m-d');
      $model->sppd = 0;
      $model->is_luar_kota = 0;
      $model->id_group = 0;
      $model->ckp = 1;
      $model->save();

      $modelckp = new \app\models\Ckp();
      $modelckp->date = date('m');
      $modelckp->id_pegawai = $iduser;
      $modelckp->id_tugas = $model->id;
      $modelckp->satuan = $satuan;
      $modelckp->realisasi = $jumlah;
      $modelckp->save();

      $searchModel = new CkpSearc();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('createjurnal', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
      ]);
    }
    public function actionCreate()
    {
        $model = new Tugas();
        $message='';
        if ($model->load(Yii::$app->request->post())) {
            $postval=Yii::$app->request->post('Tugas');
            $start_date=$postval['date_start'];
            $end_date=$postval['date_end'];
            $tanggal_surat=$postval['created_date'];
            $userid=$postval['id_pegawai'];
            $program=$postval['program'];
            $sppd=$postval['sppd'];
            $model->thn = date("Y-m-d H:i:s");
            if(strlen($start_date)==0||strlen($end_date==0)||strlen($tanggal_surat==0))
            {
              $message = 'Tanggal Harus Terisi Semua';
              $title='Kesalahan';
              return $this->render('create', [
                  'model' => $model,
                  'errorstatus' => true,
                  'message'=>$message,
                  'title'=>$title,
              ]);
            }else if($start_date>$end_date)
            {
              $message = 'Tanggal Mulai Harus Lebih Awal Dari Tanggal Selesai';
              $title='Kesalahan';
              return $this->render('create', [
                  'model' => $model,
                  'errorstatus' => true,
                  'message'=>$message,
                  'title'=>$title,
              ]);
            }else if($tanggal_surat>$end_date||$tanggal_surat>$start_date)
            {
              $message = 'Tanggal Surat Harus Lebih Awal Dari Tanggal Mulai dan Tanggal Selesai';
              $title='Kesalahan';
              return $this->render('create', [
                  'model' => $model,
                  'errorstatus' => true,
                  'message'=>$message,
                  'title'=>$title,
              ]);
            }
            $helper = Yii::$app->myHelper;
            $isoverlap=false;
            if($sppd==1)
            {
              $isoverlap = $helper->cekTanggal($start_date,$end_date,$userid,0,0);
            }

            if($isoverlap)
            {
              $message = 'Pada Tanggal '.$start_date.' - '.$end_date.' pegawai sudah melakukan kegiatan lain';
              $title='Overlapping Tanggal';
              return $this->render('create', [
                  'model' => $model,
                  'errorstatus' => true,
                  'message'=>$message,
                  'title'=>$title,
              ]);
            }
            else {
              $model->save();
              return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'errorstatus' => false,
                'message'=>$message,
                'title'=>''
            ]);
        }
    }
    public function actionCreatekolektif()
    {
      $model = new Tugas();
      return $this->render('createkolektif',[
        'model' => $model,
        'errorstatus' => false,
        'message'=>'',
        'title'=>'',
      ]);
    }

    /**
     * Updates an existing Tugas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $message='';

        if ($model->load(Yii::$app->request->post())) {
          $postval=Yii::$app->request->post('Tugas');
          $start_date=$postval['date_start'];
          $end_date=$postval['date_end'];
          $tanggal_surat=$postval['created_date'];
          $userid=$postval['id_pegawai'];
          $program=$postval['program'];
          $sppd=$postval['sppd'];
          if(strlen($start_date)==0||strlen($end_date==0)||strlen($tanggal_surat==0))
          {
            $message = 'Tanggal Harus Terisi Semua';
            $title='Kesalahan';
            return $this->render('update', [
                'model' => $model,
                'errorstatus' => true,
                'message'=>$message,
                'title'=>$title,
            ]);
          }else if($start_date>$end_date)
          {
            $message = 'Tanggal Mulai Harus Lebih Awal Dari Tanggal Selesai';
            $title='Kesalahan';
            return $this->render('update', [
                'model' => $model,
                'errorstatus' => true,
                'message'=>$message,
                'title'=>$title,
            ]);
          }else if($tanggal_surat>$end_date||$tanggal_surat>$start_date)
          {
            $message = 'Tanggal Surat Harus Lebih Awal Dari Tanggal Mulai dan Tanggal Selesai';
            $title='Kesalahan';
            return $this->render('update', [
                'model' => $model,
                'errorstatus' => true,
                'message'=>$message,
                'title'=>$title,
            ]);
          }
          
          $scan = UploadedFile::getInstance($model,'scan');

            if(!is_null($scan)){
                $nosurat = $model->nosurat;
                $fileName='SPD NO '.$nosurat.'.'.$scan->extension;
                Yii::$app->params['uploadPath'] = Yii::$app->basePath.'/public_html/uploads/scan/';
                $pathUpload = Yii::$app->params['uploadPath'].$fileName;
                $scan->saveAs($pathUpload);
                $model->scan = $fileName;
            }else{
                $model->scan = $temp_scan;
            }


          $helper = Yii::$app->myHelper;
          $isoverlap=false;
          if($sppd==1)
          {
              $isoverlap = $helper->cekTanggal($start_date,$end_date,$userid,1,$id);
          }
          if($isoverlap)
          {
            $message = 'Pada Tanggal '.$start_date.' - '.$end_date.' pegawai sudah melakukan kegiatan lain';
            $title='Overlapping Tanggal';
            return $this->render('update', [
                'model' => $model,
                'errorstatus' => true,
                'message'=>$message,
                'title'=>$title,
            ]);
          }
          else {
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
          }
        } else {
            return $this->render('update', [
                'model' => $model,
                'errorstatus' => false,
                'message'=>$message,
                'title'=>'',
            ]);
        }
    }

    /**
     * Deletes an existing Tugas model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['listtugas']);
    }

    public function actionDeletekolektif($groupid)
    {
      Tugas::deleteAll(['id_group' => $groupid]);
      return $this->redirect(['listtugaskolektif']);
    }

    public function actionEditkolektif($groupid)
    {
      $arrayidpegawai = [];

      $idpegawai = Tugas::find()
      ->where(['id_group' => $groupid])
      ->asArray()
      ->all();

      foreach($idpegawai as $ids)
      {
        array_push($arrayidpegawai,$ids['id_pegawai']);
      }
      $arrayidpegawai = array_values($arrayidpegawai);


      $pegawai= \app\models\Pegawai::find()
      ->select(['nama','nip'])
      ->where(['IN','id',$arrayidpegawai])
      ->asArray()
      ->all();


      $namaseksi = \app\models\Seksi::findOne([
      'id' => $idpegawai[0]['assignee'],
      ]);

      $model = Tugas::findOne([
          'id_group' => $groupid,
      ]);

      $pegawaicheck = \app\models\Tugas::find()
      ->select(['id_pegawai'])
      ->where(['id_group'=>$groupid])
      ->asArray()
      ->all();

      return $this->render('editkolektif',[
        'group'=>$groupid,
        'tugas'=>$idpegawai,
        'model'=>$model,
        'pegawai'=>$pegawai,
        'pegawaicheck'=>$pegawaicheck,
        'seksi'=>$namaseksi,
        'errorstatus' => false,
        'message'=>'',
        'title'=>'',
      ]);
    }
    public function actionUpdatedatakolektif($group_id)
    {
      $tableName='tugas';
      $data=Yii::$app->request->post();
      $getidadd=Yii::$app->request->get('idadd');
      $idpegawai=$data['Tugas']['id_pegawai'];
      $data=$data['Tugas'];
      $suratdasar=$data['suratdasar'];
      $program=$data['program'];
      $nosurat=$data['nosurat'];
      $date_start=$data['date_start'];
      $date_end=$data['date_end'];
      $kegiatan=$data['kegiatan'];
      $program=$data['program'];
      $destinasi=$data['destinasi'];
      $assignee=$data['assignee'];
      $created_date=$data['created_date'];
      $sppd=$data['sppd'];
      $isluarkota=$data['is_luar_kota'];
      $model = new Tugas();
      $message='';
      $userid = implode (", ", $idpegawai);

      $pegawaicheck = \app\models\Tugas::find()
      ->select(['id_pegawai'])
      ->where(['id_group'=>$group_id])
      ->asArray()
      ->all();

      $model->suratdasar=$suratdasar;
      $model->program=$program;
      $model->nosurat=$nosurat;
      $model->date_start=$date_start;
      $model->date_end=$date_end;
      $model->kegiatan=$kegiatan;
      $model->program=$program;
      $model->destinasi=$destinasi;
      $model->assignee=$assignee;
      $model->created_date=$created_date;
      $model->sppd=$sppd;
      $model->is_luar_kota=$isluarkota;


      if(strlen($date_start)==0||strlen($date_end==0)||strlen($created_date==0))
      {
        $message = 'Tanggal Harus Terisi Semua';
        $title='Kesalahan';
        return $this->render('editkolektif', [
            'model' => $model,
            'errorstatus' => true,
            'message'=>$message,
            'title'=>$title,
            'group'=>$group_id,
            'pegawaicheck'=>$pegawaicheck,
        ]);
      }else if($date_start>$date_end)
      {
        $message = 'Tanggal Mulai Harus Lebih Awal Dari Tanggal Selesai';
        $title='Kesalahan';
        return $this->render('editkolektif', [
            'model' => $model,
            'errorstatus' => true,
            'message'=>$message,
            'title'=>$title,
            'group'=>$group_id,
            'pegawaicheck'=>$pegawaicheck,
        ]);
      }else if($created_date>$date_end||$created_date>$date_start)
      {
        $message = 'Tanggal Surat Harus Lebih Awal Dari Tanggal Mulai dan Tanggal Selesai';
        $title='Kesalahan';
        return $this->render('editkolektif', [
            'model' => $model,
            'errorstatus' => true,
            'message'=>$message,
            'title'=>$title,
            'group'=>$group_id,
            'pegawaicheck'=>$pegawaicheck,
        ]);
      }

      $arrtugasid = \app\models\Tugas::find()
      ->select(['id'])
      ->where(['id_group'=>$group_id])
      ->asArray()
      ->all();
      $temparraytugas = [];
      foreach($arrtugasid as $arr)
      {
        array_push($temparraytugas,$arr['id']);
      }
      $id = implode (", ", $temparraytugas);


      $helper = Yii::$app->myHelper;
      $isoverlap = $helper->cekTanggal($date_start,$date_end,$userid,1,$id);

      if($isoverlap)
      {
        $message = 'Pada Tanggal '.$date_start.' - '.$date_end.' pegawai sudah melakukan kegiatan lain';
        $title='Overlapping Tanggal';
        return $this->render('editkolektif', [
            'model' => $model,
            'errorstatus' => true,
            'message'=>$message,
            'title'=>$title,
            'group'=>$group_id,
            'pegawaicheck'=>$pegawaicheck,
        ]);
      }

    $connection = Yii::$app->getDb();
    $command = $connection->createCommand("
      UPDATE tugas
      SET suratdasar = '".$suratdasar."',
      program = '".$program."',
      nosurat = '".$nosurat."',
      date_start = '".$date_start."',
      date_end = '".$date_end."',
      kegiatan = '".$kegiatan."',
      destinasi = '".$destinasi."',
      assignee = '".$assignee."',
      created_date = '".$created_date."',
      sppd = '".$sppd."',
      is_luar_kota = '".$isluarkota."',
      WHERE id_group = '".$group_id."'
      ");

    $result = $command->execute();
    $arridadd=[];
    if(strlen($getidadd)>0)
    {
      $arridadd=explode(",",$getidadd);
    }
    if(count($arridadd)!=0)
    {
      $bulkInsertArray = array();
      foreach($arridadd as $id){
         $bulkInsertArray[]=[
             'id_pegawai'=>$id,
             'suratdasar'=>$suratdasar,
             'program'=>$program,
             'nosurat'=>$nosurat,
             'date_start'=>$date_start,
             'date_end'=>$date_end,
             'kegiatan'=>$kegiatan,
             'destinasi'=>$destinasi,
             'assignee'=>$assignee,
             'created_date'=>$created_date,
             'sppd'=>$sppd,
             'is_luar_kota'=>$isluarkota,
             'id_group'=>$group_id,
             
         ];
      }
      if(count($bulkInsertArray)>0){
          $columnNameArray=['id_pegawai','suratdasar', 'program', 'nosurat','date_start','date_end','kegiatan','destinasi','assignee','created_date','sppd','is_luar_kota','id_group','blok_absen'];
          // below line insert all your record and return number of rows inserted
          $insertCount = Yii::$app->db->createCommand()
                         ->batchInsert(
                               $tableName, $columnNameArray, $bulkInsertArray
                           )
                         ->execute();
      }
    }

    return $this->redirect(['tugas/viewkolektif?groupid='.$group_id]);

    }
    public function actionRekap($id_pegawai,$date)
    {
      $helper=Yii::$app->myHelper;
      $ipmesin = $helper->config()->ip_mesinabsen;
      $nip = $helper->pegawaiById($id_pegawai)->nip_lama;
      $lastdate=date('Y-12-t', strtotime($date));
      $firstdate=date('Y-01-01', strtotime($date));

      //model tugas

      $model = Tugas::findAll([
          'id_pegawai' => $id_pegawai,
      ]);

      //model memo
      $modelmemo = Memo::findAll([
        'id_pegawai'=>$id_pegawai,
      ]);

      //model ijincuti
      $modelijincuti = Ijincuti::findAll([
        'id_pegawai'=>$id_pegawai,
      ]);

      $modelHoliday = Holiday::find()
      ->where(['between', 'tanggal', $firstdate, $lastdate ])->all();

      $pegawai =  $helper->pegawaiById($id_pegawai);

      $url='http://localhost/tad_absensi/index.php?nip='.$nip.'&start_date='.$firstdate.'&end_date='.$lastdate.'&ip_mesin='.$ipmesin.'';
      $ch = curl_init();
      // Disable SSL verification
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      // Will return the response, if false it print the response
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // Set the url
      curl_setopt($ch, CURLOPT_URL,$url);
      // Execute
      $result=curl_exec($ch);

      $result = json_decode($result);
      // Closing
      curl_close($ch);

      return $this->render('rekap',[
        'model'=>$model,
        'modelmemo'=>$modelmemo,
        'modelijincuti'=>$modelijincuti,
        'modelholiday'=>$modelHoliday,
        'pegawai'=>$pegawai,
        'dataabsen'=>$result,
      ]);
    }
    public function actionRekapcustomdate($id_pegawai,$date_start,$date_end,$autoclickprintpdf)
    {
      $helper=Yii::$app->myHelper;
      $ipmesin = $helper->config()->ip_mesinabsen;
      $nip = $helper->pegawaiById($id_pegawai)->nip_lama;
      $lastdate=date('Y-m-d', strtotime($date_end));
      $firstdate=date('Y-m-d', strtotime($date_start));

      $harilibur = Holiday::find()
      ->where(['between','tanggal',$firstdate,$lastdate])->all();
      //model tugas
      $modelTugas = Tugas::findAll([
          'id_pegawai' => $id_pegawai,
      ]);

      $pegawai =  $helper->pegawaiById($id_pegawai);

      $url='http://localhost/tad_absensi/index.php?nip='.$nip.'&start_date='.$firstdate.'&end_date='.$lastdate.'&ip_mesin='.$ipmesin.'';
      $ch = curl_init();
      // Disable SSL verification
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      // Will return the response, if false it print the response
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // Set the url
      curl_setopt($ch, CURLOPT_URL,$url);
      // Execute
      $result=curl_exec($ch);

      // Closing
      curl_close($ch);
      $dataabsen=json_decode($result);
      $tanggal=$firstdate;
      $pegawai = $helper->pegawaiById($id_pegawai);
      $config = $helper->config();
      $shift = $helper->getShift(1);
      $myYearMonth=$dataabsen->Row[0]->DateTime;
      $start = new \DateTime(date('Y-m-01', strtotime($tanggal)), new \DateTimeZone('Asia/Jakarta'));
      $end = new \DateTime(date('Y-m-t', strtotime($tanggal)), new \DateTimeZone('Asia/Jakarta'));
      $end=$end->modify('+1 day');
      $diff = \DateInterval::createFromDateString('1 day');
      $periodStart = new \DatePeriod($start, $diff, $end);

      return $this->render('rekapabsen',[
        'pegawai'=>$pegawai,
        'config'=>$config,
        'dataabsen'=>$dataabsen,
        'periodStart'=>$periodStart,
        'tanggal'=>$tanggal,
        'modelTugas'=>$modelTugas,
        'shift'=>$shift,
        'harilibur'=>$harilibur,
        'autoclickprintpdf'=>$autoclickprintpdf,
      ]);
    }


    public function actionGetidpegawai($nama,$date)
    {
      $model = Pegawai::find()
        ->select('id')
        ->where('nama LIKE :query')
        ->addParams([':query'=>'%'.$nama.'%'])
        ->asArray()
        ->one();
      return $this->redirect(['rekap','id_pegawai'=>$model['id'],'date'=>$date]);
    }

    public function actionGetidkegiatan($kegiatan)
    {
      $model = Tugas::find()
        ->select('id')
        ->where('kegiatan LIKE :query')
        ->addParams([':query'=>'%'.$kegiatan.'%'])
        ->asArray()
        ->one();
      return $this->redirect(['view','id'=>$model['id']]);
    }

     public function actionReport($id_tugas,$id_pegawai,$kolektif) {
      $helper=Yii::$app->myHelper;
      $tugas = Tugas::findOne($id_tugas);
      $isluarkota=$tugas->is_luar_kota;
      $pegawai = Tugas::findOne([
          'id_pegawai' => $id_pegawai,
      ])->idPegawai;
      $iskepala = $tugas->id_pegawai;
      $tanggalpelaksanaan='';
      $tanggalsurat = $helper->indonesian_date($tugas->created_date);
      if($tugas->date_start!=$tugas->date_end)
      {
        $tanggalpelaksanaan=$helper->indonesian_date($tugas->date_start).' - '.$helper->indonesian_date($tugas->date_end);
      }else {
        $tanggalpelaksanaan=$helper->indonesian_date($tugas->date_start);
      }

      $isprintsppd = $tugas->sppd == 2 ? 'printsurattugas' : 'printsurattugassppd' ;
      if($tugas->sppd == 3)
      {
          $isprintsppd = 'printsuratugascovid';
      }
      if($kolektif == 1&&$tugas->sppd == 1)
      {
          $isprintsppd = 'printlampirankolektif';
      }
      if($isluarkota == 2&&$tugas->sppd == 1)
      {
          $isprintsppd = 'printsppdluar';
      }
      $day=$helper->hitungHari($tugas->date_start,$tugas->date_end);

      $penyebut = $helper->penyebut($day);
      $penyebut=ucwords($penyebut);
      $penyebut = $helper->penyebut($day);

      $hotel = 0;
      $uh = $helper->config()->hotel;
      $uh = explode(',', $uh);
      
      if($iskepala==3)
      {
        $hotel = ($uh[1])*($day-1);
      }else {
        $hotel = ($uh[0])*($day-1);
      }
      

      $transport = 0;

      if($iskepala==3)
      {
        $transport = 0;
      }else {
        $transport = $helper->config()->transport;
      }
      $rill= $transport+$hotel;
      $terbilangrill = $helper->terbilang($rill);
      $terbilangrill=ucwords($terbilangrill);

      $uangharian=0;
      $oh = $helper->config()->uangharian;
      $oh = explode(',', $oh);

      if($isluarkota==2)
      {
        $uangharian = ($oh[1])*($day);
       
      }else {
        $uangharian = ($oh[0])*($day);
       
      }

      $jumlah= $rill+$uangharian;

      $terbilang = $helper->terbilang($jumlah);
      $terbilang=ucwords($terbilang);
      $terbilangtransport = $helper->terbilang($transport);

      $alamatkantor=$helper->config()->alamat;
      $alamatlengkap=$helper->config()->alamatlengkap;
      $kodepos=$helper->config()->kodepos;
      $web=$helper->config()->web;
      $email=$helper->config()->email;
      $telepon=$helper->config()->telepon;
      $satker=$helper->config()->satker;
      $kabupaten=$helper->config()->kabupaten;

      $bendahara = $helper->pegawaiByJabatan('8')->nama;
      $nipbendahara = $helper->pegawaiByJabatan('8')->nip;

      $tempppk=$helper->config()->ppk;
      $ppk=$helper->pegawaiById($tempppk)->nama;
      $nipppk=$helper->pegawaiByid($tempppk)->nip;

      $Kepala=$helper->pegawaiByJabatan('2')->nama;
      $nipKepala=$helper->pegawaiByJabatan('2')->nip;

      $angkutan = $pegawai->is_motordinas == 1 ? 'Kendaraan Dinas':'Angkutan Umum';
      $kend = $tugas->kend == 1 ? 'Kendaraan Dinas':'Angkutan Umum';

      $content = $this->renderPartial($isprintsppd,[
        'nama'=>$pegawai->nama,
        'nip'=>$pegawai->nip,
        'tglenglish'=>$tugas->created_date,
        'pangkat'=>$pegawai->pangkat,
        'golongan'=>$pegawai->golongan,
        'jabatan'=>$pegawai->idJabatan->jabatan,
        'tanggal'=>$tanggalsurat,
        'nomor'=>$tugas->nosurat,
        'kodesurat'=>$helper->seksiById($tugas->assignee)->kode,
        'hal'=>$tugas->kegiatan,
        'alamatkantor'=>$alamatkantor,
        'alamatlengkap'=>$alamatlengkap,
        'kodepos'=>$kodepos,
        'web'=>$web,
        'email'=>$email,
        'telepon'=>$telepon,
        'kabupaten'=>$kabupaten,
        'provinsi'=>$helper->config()->provinsi,
        'destinasi'=>$tugas->destinasi,
        'day'=>$day,
        'waktu'=>$tanggalpelaksanaan,
        'tglberangkat'=>$helper->indonesian_date($tugas->date_start),
        'tglkembali'=>$helper->indonesian_date($tugas->date_end),
        'surat'=>$tugas->suratdasar,
        'program'=>$tugas->program,
        'transport'=>$helper->formatRupiah($transport),
        'uangharian'=>$helper->formatRupiah($uangharian),
        'hotel'=>$helper->formatRupiah($hotel),
        'isluarkota'=>$isluarkota,
        'jumlah'=>$helper->formatRupiah($jumlah),
        'terbilang'=>$terbilang,
        'terbilangrill'=>$terbilangrill,
        'terbilangtransport'=>$terbilangtransport,
        'rill'=>$helper->formatRupiah($rill),
        'penyebut' =>$penyebut,
        'Kepala'=>$Kepala,
        'nipKepala'=>$nipKepala,
        'ppk'=>$ppk,
        'nipppk'=>$nipppk,
        'bendahara'=>$bendahara,
        'nipbendahara'=>$nipbendahara,
        'satker'=>$satker,
        'is_motordinas'=>$pegawai->is_motordinas,
        'angkutan'=>$angkutan,
        'kend'=>$kend,
        'is_plh'=>$helper->config()->is_plh,
        'namaplh'=>$helper->pegawaiById($helper->config()->plh_kepala)->nama,
        'nipplh'=>$helper->pegawaiById($helper->config()->plh_kepala)->nip,
      ]);
      $pdf = new Pdf([
        // set to use core fonts only
        'mode' => Pdf::MODE_CORE, 
        // A4 paper format
        'format' => Pdf::FORMAT_A4, 
        // portrait orientation
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        // stream to browser inline
        'destination' => Pdf::DEST_BROWSER, 
        // your html content input
        'content' => $content,  
        // format content from your own css file if needed or use the
        // enhanced bootstrap css built by Krajee for mPDF formatting 
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
        // any css to be embedded if required
        'cssInline' => '.kv-heading-1{font-size:14px}', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Krajee Report Title'],
         // call mPDF methods on the fly
        
    ]);

      $response = Yii::$app->response;
      $response->format = \yii\web\Response::FORMAT_RAW;
      $headers = Yii::$app->response->headers;
      $headers->add('Content-Type', 'application/pdf');

      // return the pdf output as per the destination setting
      return $pdf->render();

    }
    public function actionListtugas()
    {
      $searchModel = new TugasSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('tugas.id_group = \'0\' and tugas.nosurat!="x"');
      return $this->render('listtugas', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>'',
      ]);
    }

    public function actionListsppd()
    {
      $searchModel = new TugasSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $helper=Yii::$app->myHelper;
        $config=$helper->config();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tahun=$helper->config()->tahun;              
        $dataProvider->query->where("tugas.thn =  ".$tahun." ");
        //$dataProvider->query->where('tugas.sppd = \'1\'');
      return $this->render('listsppd', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>'',
      ]);
    }
    public function actionListupload()
    {
      $searchModel = new TugasSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $helper=Yii::$app->myHelper;
        $config=$helper->config();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tahun=$helper->config()->tahun;              
        $dataProvider->query->where("tugas.thn =  ".$tahun." ");
        //$dataProvider->query->where('tugas.sppd = \'1\'');
      return $this->render('listupload', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>'',
      ]);
    }
    public function actionSearchtugaspribadi($cari)
    {
      $searchModel = new TugasSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('tugas.id_group = \'0\'
      and (
      kegiatan like "%'.$cari.'%"
      or destinasi like "%'.$cari.'%"
      or pegawai.nama like "%'.$cari.'%"
      or seksi.seksi like "%'.$cari.'%"
      )'
    );


      //$dataProvider->query->where(['like', 'pegawai.nama', $cari]);
      return $this->render('listsppd', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>$cari,
      ]);
    }
    public function actionSavekolektif()
    {
      $tableName='tugas';
      $data=Yii::$app->request->post();
      $idpegawai=$data['Tugas']['id_pegawai'];
      $data=$data['Tugas'];
      $suratdasar=$data['suratdasar'];
      $program=$data['program'];
      $nosurat=$data['nosurat'];
      $date_start=$data['date_start'];
      $date_end=$data['date_end'];
      $kegiatan=$data['kegiatan'];
      $destinasi=$data['destinasi'];
      $assignee=$data['assignee'];
      $created_date=$data['created_date'];
      $sppd=$data['sppd'];
      $isluarkota=$data['is_luar_kota'];
      $blokabsen=$data['blok_absen'];
      $model = new Tugas();
      $message='';
      $userid = implode (", ", $idpegawai);


      if(strlen($date_start)==0||strlen($date_end==0)||strlen($created_date==0))
      {
        $message = 'Tanggal Harus Terisi Semua';
        $title='Kesalahan';
        return $this->render('createkolektif', [
            'model' => $model,
            'errorstatus' => true,
            'message'=>$message,
            'title'=>$title,
        ]);
      }else if($date_start>$date_end)
      {
        $message = 'Tanggal Mulai Harus Lebih Awal Dari Tanggal Selesai';
        $title='Kesalahan';
        return $this->render('createkolektif', [
            'model' => $model,
            'errorstatus' => true,
            'message'=>$message,
            'title'=>$title,
        ]);
      }else if($created_date>$date_end||$created_date>$date_start)
      {
        $message = 'Tanggal Surat Harus Lebih Awal Dari Tanggal Mulai dan Tanggal Selesai';
        $title='Kesalahan';
        return $this->render('createkolektif', [
            'model' => $model,
            'errorstatus' => true,
            'message'=>$message,
            'title'=>$title,
        ]);
      }
      $helper = Yii::$app->myHelper;
      $isoverlap = $helper->cekTanggal($date_start,$date_end,$userid,4,0);

      if($isoverlap)
      {
        $message = 'Pada Tanggal '.$date_start.' - '.$date_end.' pegawai sudah melakukan kegiatan lain';
        $title='Overlapping Tanggal';
        return $this->render('createkolektif', [
            'model' => $model,
            'errorstatus' => true,
            'message'=>$message,
            'title'=>$title,
        ]);
      }

      $connection = Yii::$app->getDb();
      $command = $connection->createCommand("
          SELECT MAX(`id_group`)+1 AS `id_group` FROM `tugas`
      ");
      $result = $command->queryAll();
      $groupid = $result[0]['id_group'];

      $bulkInsertArray = array();
      foreach($idpegawai as $id){
         $bulkInsertArray[]=[
             'id_pegawai'=>$id,
             'suratdasar'=>$suratdasar,
             'program'=>$program,
             'nosurat'=>$nosurat,
             'date_start'=>$date_start,
             'date_end'=>$date_end,
             'kegiatan'=>$kegiatan,
             'destinasi'=>$destinasi,
             'assignee'=>$assignee,
             'created_date'=>$created_date,
             'sppd'=>$sppd,
             'is_luar_kota'=>$isluarkota,
             'id_group'=>$groupid,
  
         ];
      }
      if(count($bulkInsertArray)>0){
          $columnNameArray=['id_pegawai','suratdasar', 'program','nosurat','date_start','date_end','kegiatan','destinasi','assignee','created_date','sppd','is_luar_kota','id_group'];
          // below line insert all your record and return number of rows inserted
          $insertCount = Yii::$app->db->createCommand()
                         ->batchInsert(
                               $tableName, $columnNameArray, $bulkInsertArray
                           )
                         ->execute();
      }
      $namapegawai = \app\models\Pegawai::find()
      ->select('nama')
      ->where(['IN','id',$idpegawai])
      ->asArray()
      ->all();

      $namaseksi = \app\models\Seksi::find([
        'id' => $assignee,
        ])->asArray()->one();

      $model = Tugas::find([
          'id_group' => $groupid,
      ])->asArray()->one();

      $tugas = Tugas::find()
        ->where(['id_group' => $groupid])
        ->asArray()
        ->all();
      //masih error di cetak langsung
      /*
      return $this->render('viewkolektif', [
          'model' => $model,
          'tugas'=> $tugas,
          'pegawai' => $namapegawai,
          'seksi'=>$namaseksi,
      ]);*/

      return $this->redirect(['tugas/listtugaskolektif']);

    }
    public function actionViewkolektif($groupid)
    {
      $arrayidpegawai = [];

      $idpegawai = Tugas::find()
      ->where(['id_group' => $groupid])
      ->asArray()
      ->all();

      foreach($idpegawai as $ids)
      {
        array_push($arrayidpegawai,$ids['id_pegawai']);
      }
      $arrayidpegawai = array_values($arrayidpegawai);


      $pegawai= \app\models\Pegawai::find()
      ->select(['nama','nip'])
      ->where(['IN','id',$arrayidpegawai])
      ->asArray()
      ->all();


        $namaseksi = \app\models\Seksi::findOne([
        'id' => $idpegawai[0]['assignee'],
        ]);

        $model = Tugas::findOne([
            'id_group' => $groupid,
        ]);


      return $this->render('viewkolektif', [
          'group' =>$groupid,
          'tugas' =>$idpegawai,
          'model' => $model,
          'pegawai' => $pegawai,
          'seksi'=>$namaseksi,
      ]);
    }

    public function actionPrintkolektif(){
      $data=Yii::$app->request;
      $helper=Yii::$app->myHelper;
      $pegawai = $data->get('pegawai');
      $seksi = $data->get('seksi');

      $kegiatan = $data->get('kegiatan');
      $destinasi = $data->get('destinasi');
      $date_start = $data->get('date_start');
      $date_end = $data->get('date_end');
      $created_date = $data->get('created_date');
      $suratdasar = $data->get('suratdasar');
      $program = $data->get('program');
      $nosurat = $data->get('nosurat');

      $provinsi = $helper->config()->provinsi;
      $kabupaten = $helper->config()->kabupaten;
      $alamatkantor = $helper->config()->alamat;
      $Kepala = $helper->pegawaiByJabatan('2')->nama;
      $nipKepala = $helper->pegawaiByJabatan('2')->nip;

      $tanggalpelaksanaan='';
      $tanggalsurat = $helper->indonesian_date($created_date);
      if($date_start!=$date_end)
      {
        $tanggalpelaksanaan=$helper->indonesian_date($date_start).' - '.$helper->indonesian_date($date_end);
      }else {
        $tanggalpelaksanaan=$helper->indonesian_date($date_start);
      }

      $content = $this->renderPartial('printkolektif',[
        'pegawai'=>$pegawai,
        'tanggal'=>$tanggalsurat,
        'tglenglish'=>$created_date,
        'nomor'=>$nosurat,
        'hal'=>$kegiatan,
        'waktu'=>$tanggalpelaksanaan,
        'surat'=>$suratdasar,
        'program'=>$program,
        'kabupaten'=>$kabupaten,
        'provinsi'=>$provinsi,
        'alamatkantor'=>$alamatkantor,
        'kepala'=>$Kepala,
        'nipKepala'=>$nipKepala,
        'destinasi'=>$destinasi,
        'is_plh'=>$helper->config()->is_plh,
        'namaplh'=>$helper->pegawaiById($helper->config()->plh_kepala)->nama,
        'nipplh'=>$helper->pegawaiById($helper->config()->plh_kepala)->nip,
      ]);

      $pdf = new Pdf([
          'mode' => Pdf::MODE_CORE,
          'format' => Pdf::FORMAT_A4,
          'orientation' => Pdf::ORIENT_PORTRAIT,
          'destination' => Pdf::DEST_BROWSER,
          'content' => $content,
          'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
          'cssInline' => '.kv-heading-1{font-size:18px};',
          'methods' => [
              //'SetFooter'=>['<p class="text-center text-primary"><i>Jl.Kusnodanupojo, Desa Mootinelo, Kec. Kwandang, Kab Gorontalo Utara<br/>Homepage:http://www.gorontaloutarakab.bps.go.id, email:bps7505@bps.go.id</i><p>'],
          ]
      ]);
      $response = Yii::$app->response;
      $response->format = \yii\web\Response::FORMAT_RAW;
      $headers = Yii::$app->response->headers;
      $headers->add('Content-Type', 'application/pdf');
      return $pdf->render();

    }

    public function actionListtugaskolektif()
    {
      $searchModel = new TugasSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('tugas.id_group <> \'0\'');
      $dataProvider->query->groupby('tugas.id_group');
      return $this->render('listtugaskolektif', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>''
      ]);
    }

    public function actionListsppdkolektif()
    {
      $searchModel = new TugasSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('tugas.id_group <> \'0\'');
      $dataProvider->query->groupby('tugas.id_group');
      return $this->render('listtugaskolektif', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>''
      ]);
    }
    public function actionSearchtugaskolektif($cari)
    {
      $searchModel = new TugasSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('tugas.id_group <> \'0\'
      and (
      kegiatan like "%'.$cari.'%"
      or destinasi like "%'.$cari.'%"
      or pegawai.nama like "%'.$cari.'%"
      or seksi.seksi like "%'.$cari.'%"
      )'
      );
      $dataProvider->query->groupby('tugas.id_group');
      return $this->render('listtugaskolektif', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>$cari,
      ]);
    }

    public function actionRekapabsen()
    {
      $request = Yii::$app->request;
      $helper=Yii::$app->myHelper;
      $id_pegawai=$request->post('id_pegawai',null);
      $dataabsen=$request->post('dataabsen',null);
      $tanggal=$request->post('tanggal',null);
      $dataabsen=json_decode($dataabsen);
      $lastdate=date('Y-12-t', strtotime($tanggal));
      $firstdate=date('Y-01-01', strtotime($tanggal));
      if($dataabsen==null)
      {
        return $this->render('//site/error');
      }
      $pegawai = $helper->pegawaiById($id_pegawai);
      $config = $helper->config();
      $shift = $helper->getShift(1);
      $myYearMonth=$dataabsen->Row[0]->DateTime;
      $start = new \DateTime(date('Y-m-01', strtotime($tanggal)), new \DateTimeZone('Asia/Jakarta'));
      $end = new \DateTime(date('Y-m-t', strtotime($tanggal)), new \DateTimeZone('Asia/Jakarta'));
      $end=$end->modify('+1 day');
      $diff = \DateInterval::createFromDateString('1 day');
      $periodStart = new \DatePeriod($start, $diff, $end);

      $modelTugas=Tugas::findAll([
        'id_pegawai'=>$id_pegawai,
      ]);

      $harilibur = Holiday::find()
      ->where(['between', 'tanggal', $firstdate, $lastdate ])->all();


      return $this->render('rekapabsen',[
        'pegawai'=>$pegawai,
        'config'=>$config,
        'dataabsen'=>$dataabsen,
        'periodStart'=>$periodStart,
        'tanggal'=>$tanggal,
        'modelTugas'=>$modelTugas,
        'shift'=>$shift,
        'harilibur'=>$harilibur,
        'autoclickprintpdf'=>'0',
      ]);

    }
    public function actionPrintrekap()
    {
      $request = Yii::$app->request;
      $data=$request->post('data',null);
      $name=$request->post('name',null);
      $organization=$request->post('organization',null);

      $content=$this->renderPartial('printabsenpdf',[
        'data'=>$data,
        'name'=>$name,
        'organization'=>$organization,
      ]);

      $pdf = new Pdf([
        'mode' => Pdf::MODE_CORE,
        'format' => Pdf::FORMAT_A4,
        'orientation' => Pdf::ORIENT_LANDSCAPE,
        'destination' => Pdf::DEST_BROWSER,
        'content' => $content,
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
        'cssInline' => '.kv-heading-1{font-size:10px}',
        'methods' => [
            //'SetFooter'=>['<p class="text-center text-primary"><i>Jl.Kusnodanupojo, Desa Mootinelo, Kec. Kwandang, Kab Gorontalo Utara<br/>Homepage:http://www.gorontaloutarakab.bps.go.id, email:bps7505@bps.go.id</i><p>'],
        ]
      ]);

      $response = Yii::$app->response;
      $response->format = \yii\web\Response::FORMAT_RAW;
      $headers = Yii::$app->response->headers;
      $headers->add('Content-Type', 'application/pdf');

      // return the pdf output as per the destination setting
      return $pdf->render();
    }
    /**
     * Finds the Tugas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Tugas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tugas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

     public function actionPdf($id)
    {
        $model = $this->findModel($id);
        return $this->render('pdf', [
            'model' => $model,
        ]);
    }
    public function actionUpload($id)
    {
       $model = $this->findModel($id);

         if ($model->load(Yii::$app->request->post())) {
            
            $model->thn = date("Y-m-d H:i:s");
            $scan = UploadedFile::getInstance($model,'scan');

            if(!is_null($scan)){
                $nosurat = $model->id;
                $fileName='SPPD_'.$nosurat.'.'.$scan->extension;
                Yii::$app->params['uploadPath'] = '@webroot/uploads/sppd/';
                $pathUpload = Yii::$app->params['uploadPath'].$fileName;
                $scan->saveAs($pathUpload);
                $model->scan = $fileName;
            }
            
            $model->save();
            return $this->redirect(['listupload', 'id' => $model->id]);
        }

        return $this->render('upload', [
            'model' => $model,
            
        ]);
    }
    public function actionMonevsppd()
    {
      $searchModel = new TugasSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $helper=Yii::$app->myHelper;
        $config=$helper->config();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tahun=$helper->config()->tahun;              
        $dataProvider->query->where("tugas.thn =  ".$tahun." and tugas.sppd = \"1\"");
      return $this->render('monevsppd', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>'',
      ]);
    }
    
    public function actionCek($id)
    
    {
         $model = $this->findModel($id);
         

        if ($model->load(Yii::$app->request->post())) {

          $scan = UploadedFile::getInstance($model,'scan');

            if(!is_null($scan)){
               $nosurat = $model->nosurat;
                $fileName='SPD NO '.$nosurat.'.'.$scan->extension;
                Yii::$app->params['uploadPath'] = Yii::$app->basePath.'/web/uploads/scan/';
                $pathUpload = Yii::$app->params['uploadPath'].$fileName;
                $scan->saveAs($pathUpload);
                $model->scan = $fileName;
            }
          
          {
            $model->save();
            return $this->redirect(['monevsppd', 'id' => $model->id]);
          }
        } else {
            return $this->render('cek', [
                'model' => $model,
               
            ]);
        }
    }

}
