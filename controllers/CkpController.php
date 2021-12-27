<?php

namespace app\controllers;

use Yii;
use app\models\Ckp;
use app\models\CkpSearc;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;

/**
 * CkpController implements the CRUD actions for Ckp model.
 */
class CkpController extends Controller
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
        ];
    }

    /**
     * Lists all Ckp models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query="SELECT DISTINCT(YEAR(created_date)) AS year FROM `tugas` ORDER BY year DESC";
        $querytahun=Yii::$app->db->createCommand($query)->queryAll();
        return $this->render('index',
        [
          'cek'=>'0',
          'tahun'=>$querytahun,
          'th'=>'2020',
        ]);
    }

    public function actionTampilckp($id,$bulan,$tahun){
      $query="SELECT DISTINCT(YEAR(created_date)) AS year FROM `tugas` ORDER BY year DESC";
      $querytahun=Yii::$app->db->createCommand($query)->queryAll();
      $tanggal = ''.$tahun.'-'.$bulan.'-01';
      $end = date('Y-m-t', strtotime($tanggal));
      $start = date('Y-m-01', strtotime($tanggal));


      $query="SELECT c.id_ckp as id_ckp, t.id as id_tugas,t.kegiatan , c.satuan, c.id_ckp, c.date, c.satuan, c.target, c.realisasi, c.kualitas, c.kd_butir, c.angka_kredit, c.keterangan FROM tugas t LEFT JOIN ckp c ON t.id = c.id_tugas WHERE t.id_pegawai=:id_pegawai AND t.ckp=1 AND t.date_start BETWEEN :start AND :ends";
      $select=Yii::$app->db->createCommand($query)
      ->bindValue(':id_pegawai',$id)
      ->bindValue(':start',$start)
      ->bindValue(':ends',$end)
      ->queryAll();


      return $this->render('index',[
        'cek'=>'1',
        'id_pegawai'=>$id,
        'bulan'=>$bulan,
        'th'=>$tahun,
        'model'=>$select,
        'tahun'=>$querytahun,
      ]);
    }
    public function actionSimpan($idkegiatan,$idckp,$satuan,$target,$realisasi,$tingkatkualitas,$kodebutirkegiatan,$angkakredit,$keterangan,$pegawai,$bulan)
    {
      $idkegiatan= json_decode ($idkegiatan);
      $satuan= json_decode ($satuan);
      $target= json_decode ($target);
      $realisasi =json_decode ($realisasi);
      $tingkatkualitas =json_decode ($tingkatkualitas);
      $kodebutirkegiatan= json_decode ($kodebutirkegiatan);
      $angkakredit= json_decode ($angkakredit);
      $keterangan =json_decode ($keterangan);
      $idckp = json_decode($idckp);
      $i=0;
      $bulkInsertArray = array();
      print_r($idckp);
      echo(count($idckp));
      $arrayidckp= implode(",",array_filter($idckp));
      echo $arrayidckp;


      for($i=0;$i<count($idckp);$i++)
      {
        if(strlen($idckp[$i])>0)
        {
          $model = Ckp::findOne($idckp[$i]);
          echo $idckp[$i];
          $model->date = $bulan;
          $model->id_tugas = $idkegiatan[$i];
          $model->satuan = $satuan[$i];
          $model->target = $target[$i];
          $model->realisasi = $realisasi[$i];
          $model->kualitas = $tingkatkualitas[$i];
          $model->kd_butir = $kodebutirkegiatan[$i];
          $model->angka_kredit = $angkakredit[$i];
          $model->keterangan = $keterangan[$i];
          $model->save();
        }else{
          $bulkInsertArray[]=[
            'date'=>$bulan,
            'id_pegawai'=>$pegawai,
            'id_tugas'=>$idkegiatan[$i],
            'satuan'=>$satuan[$i],
            'target'=>$target[$i],
            'realisasi'=>$realisasi[$i],
            'kualitas'=>$tingkatkualitas[$i],
            'kd_butir'=>$kodebutirkegiatan[$i],
            'angka_kredit'=>$angkakredit[$i],
            'keterangan'=>$keterangan[$i]
          ];
        }

      }
      $tableName='ckp';

      if(count($bulkInsertArray)>0){
        echo 'jalan';
          $columnNameArray=['date','id_pegawai','id_tugas','satuan','target','realisasi','kualitas','kd_butir','angka_kredit','keterangan'];
          $insertCount = Yii::$app->db->createCommand()
                         ->batchInsert(
                               $tableName, $columnNameArray, $bulkInsertArray
                           )
                         ->execute();
      }

    }
    public function actionHapusitemckp($id_tugas)
    {
      $tugas= \app\models\Tugas::findOne($id_tugas);
      $tugas->ckp = 0;
      $tugas->save();
      return '1';
    }

    public function actionSimpantugasckp($kegiatan,$satuan,$target,$realisasi,$tingkatkualitas,$kodebutirkegiatan,$angkakredit,$keterangan,$pegawai,$assignee,$bulan,$date_start,$date_end){
      $date_start=strtotime($date_start);
      $date_end=strtotime($date_end);
      $date_start=date("Y-m-d",$date_start);
      $date_end=date("Y-m-d",$date_end);
      $query="INSERT INTO tugas (id_pegawai,kegiatan, assignee, created_date,blok_absen,date_start,date_end,suratdasar,nosurat,destinasi) VALUES (:id_pegawai,:kegiatan,:assignee,:created_date,:blok_absen,:date_start,:date_end,'x','x','x')";
      $insert=Yii::$app->db->createCommand($query)
      ->bindValue(':id_pegawai',$pegawai)
      ->bindValue(':kegiatan',$kegiatan)
      ->bindValue(':assignee',$assignee)
      ->bindValue(':created_date',date("Y-m-d"))
      ->bindValue(':blok_absen',0)
      ->bindValue(':date_start',$date_start)
      ->bindValue(':date_end',$date_end)
      ->execute();
      //echo 'insert 1 berhasil';
      $query2="SELECT id from tugas WHERE id_pegawai=:id_pegawai AND kegiatan=:kegiatan";
      $select=Yii::$app->db->createCommand($query2)
      ->bindValue(':id_pegawai',$pegawai)
      ->bindValue(':kegiatan',$kegiatan)
      ->queryScalar();

      //echo $select;
      $query3="INSERT INTO ckp(date,id_pegawai,id_tugas,satuan,target,realisasi,kualitas,kd_butir,angka_kredit,keterangan) VALUES (:dates,:id_pegawai,:id_tugas,:satuan,:target,:realisasi,:kualitas,:kd_butir,:angka_kredit,:keterangan)";
      $insertckp = Yii::$app->db->createCommand($query3)
      ->bindValue(':dates',$bulan)
      ->bindValue(':id_pegawai',$pegawai)
      ->bindValue(':id_tugas',$select)
      ->bindValue(':satuan',$satuan)
      ->bindValue(':target',$target)
      ->bindValue(':realisasi',$realisasi)
      ->bindValue(':kualitas',$tingkatkualitas)
      ->bindValue(':kd_butir',$kodebutirkegiatan)
      ->bindValue(':angka_kredit',$angkakredit)
      ->bindValue(':keterangan',$keterangan)
      ->execute();

      $query4="SELECT id_ckp from ckp WHERE id_tugas=:id_tugas";
      $selectckp=Yii::$app->db->createCommand($query4)
      ->bindValue(':id_tugas',$select)
      ->queryScalar();



      $data = array();
      $data['id_tugas'] = $select;
      $data['id_ckp'] = $selectckp;
      echo json_encode($data);

    }

    public function actionCetak($bulan,$pegawai,$tahun)
    {
      $tanggal = ''.$tahun.'-'.$bulan.'-01';
      $end = date('Y-m-t', strtotime($tanggal));
      $start = date('Y-m-01', strtotime($tanggal));

      $query="SELECT c.id_ckp as id_ckp, t.id as id_tugas,t.kegiatan,t.assignee , c.satuan, c.id_ckp, c.date, c.satuan, c.target, c.realisasi, c.kualitas, c.kd_butir, c.angka_kredit, c.keterangan FROM tugas t LEFT JOIN ckp c ON t.id = c.id_tugas WHERE t.id_pegawai=:id_pegawai AND t.ckp=1 AND t.date_start BETWEEN :start AND :ends";
      $select=Yii::$app->db->createCommand($query)
      ->bindValue(':id_pegawai',$pegawai)
      ->bindValue(':start',$start)
      ->bindValue(':ends',$end)
      ->queryAll();

      $helper=Yii::$app->myHelper;
      $pegawai = $helper->pegawaiById($pegawai);
      $content = $this->renderPartial('printckp',[
        'nama'=>$pegawai->nama,
        'idseksi'=>$pegawai->idJabatan->kodeSeksi->id,
        'nip'=>$pegawai->nip,
        'jabatan'=>$pegawai->idJabatan->jabatan,
        'satker'=>$helper->config()->satker,
        'model'=>$select,
        'tahun'=>$tahun,
        'end'=>$helper->indonesian_date($end),
        'start'=>$helper->indonesian_date($start),
        'namaatasan'=>$helper->pegawaiByJabatan(2)->nama,
        'nipatasan'=>$helper->pegawaiByJabatan(2)->nip,
      ]);
      $pdf = new Pdf([
        'mode' => Pdf::MODE_CORE, 
        'format' => Pdf::FORMAT_A4, 
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        'destination' => Pdf::DEST_BROWSER, 
        'content' => $content,  
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
        'cssInline' => '.kv-heading-1{font-size:14px}', 
      ]);

      $response = Yii::$app->response;
      $response->format = \yii\web\Response::FORMAT_RAW;
      $headers = Yii::$app->response->headers;
      $headers->add('Content-Type', 'application/pdf');

      // return the pdf output as per the destination setting
      return $pdf->render();
    }
    /**
     * Displays a single Ckp model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new Ckp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ckp();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_ckp]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Ckp model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_ckp]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Ckp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }



    /**
     * Finds the Ckp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ckp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ckp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
