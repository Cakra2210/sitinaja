<?php

namespace app\controllers;

use Yii;
use app\models\Ijincuti;
use app\models\IjincutiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
/**
 * IjincutiController implements the CRUD actions for Ijincuti model.
 */
class IjincutiController extends Controller
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
              'only'=>['index','view','create','update','delete','print'],
              'rules'=>[
                [
                  'allow'=>true,
                  'actions'=>['index','view','create','update','delete','print'],
                  'roles'=>['@']
                ]
              ],
            ],
        ];
    }

    /**
     * Lists all Ijincuti models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IjincutiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cari'=>'',
        ]);
    }
    public function actionSearchijincuti($cari)
    {
      if($cari=='cuti')
      {
        $cari=1;
      }
      $searchModel = new IjincutiSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('
      pegawai.nama like "%'.$cari.'%"
      or iscuti = "'.$cari.'"
      ');
      $cari='cuti';
      return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>$cari,
      ]);
    }

    /**
     * Displays a single Ijincuti model.
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
     * Creates a new Ijincuti model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ijincuti();
        $message='';
        if ($model->load(Yii::$app->request->post())) {
            $postval=Yii::$app->request->post('Ijincuti');
            $start_date=$postval['date_start'];
            $end_date=$postval['date_end'];
            $tanggal_surat=$postval['tanggal_surat'];
            $userid=$postval['id_pegawai'];

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
            $isoverlap = $helper->cekTanggal($start_date,$end_date,$userid,0,0);

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
              'title'=>'',
          ]);
        }
    }

    /**
     * Updates an existing Ijincuti model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $message='';
        if ($model->load(Yii::$app->request->post())) {
          $postval=Yii::$app->request->post('Ijincuti');
          $start_date=$postval['date_start'];
          $end_date=$postval['date_end'];
          $tanggal_surat=$postval['tanggal_surat'];
          $userid=$postval['id_pegawai'];

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
          $isoverlap = $helper->cekTanggal($start_date,$end_date,$userid,3,$id);

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
            return $this->render('update', [
              'model' => $model,
              'errorstatus' => false,
              'message'=>$message,
              'title'=>'',
            ]);
        }
    }

    /**
     * Deletes an existing Ijincuti model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionPrint($id)
    {
      $surat = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      $gettmt = $surat->idPegawai->tmtmasuk;
      $kini= $surat->tanggal_surat; 
      $pegawai = $surat->idPegawai->nama;
      $nip = $surat->idPegawai->nip;
      $config=$helper->config();
      $iscuti = $surat->iscuti == 1 ? 'print' : 'print1' ;
      $getnamaKepala = $helper->pegawaiByJabatan('2')->nama;
      $getnipKepala = $helper->pegawaiByJabatan('2')->nip;
      $idProp= $surat->id_pegawai;
      //$day=$helper->hitungHari($surat->date_start,$surat->date_end);
      $day=$helper->number_of_working_days($surat->date_start,$surat->date_end);
      $interval = $helper->dateDifference($gettmt,$kini);
      $penyebut = $helper->penyebut($day);
      $penyebut=ucwords($penyebut);
      $penyebut = $helper->penyebut($day);
      $content = $this->renderPartial($iscuti,[
        'nama'=>$pegawai,
        'nip'=>$nip,
        'iscuti'=>$surat->iscuti,
        'pangkat' => $surat->idPegawai->pangkat,
        'jabatan'=>$helper->pegawaiById($surat->id_pegawai)->idJabatan->jabatan,
        'golongan' => $surat->idPegawai->golongan,
        'satker' => $config->satker,
        'date_start'=> $helper->indonesian_date($surat->date_start),
        'date_end'=>$helper->indonesian_date($surat->date_end),
        'tanggal_surat'=>$helper->indonesian_date($surat->tanggal_surat),
        'alamatijin'=>$surat->alamat,
        'Kepala'=>$getnamaKepala,
        'nipKepala'=>$getnipKepala,
        'day'=>$day,
        'tmt' =>$interval,
        'tlp'=>$surat->idPegawai->tlp,
        'penyebut' =>$penyebut,
        'keperluan'=>$surat->keperluan,
        'alamatkantor'=>$config->alamat,
        'kabupaten'=>$config->kabupaten,
        'tglenglish'=>$surat->tanggal_surat,
        'id'=>$surat->id,
        'thn'=>$config->tahun,
        'id'=>$idProp,
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
     * Finds the Ijincuti model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ijincuti the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ijincuti::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
