<?php

namespace app\controllers;

use Yii;
use app\models\Memo;
use app\models\MemoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
/**
 * MemoController implements the CRUD actions for Memo model.
 */
class MemoController extends Controller
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
     * Lists all Memo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MemoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cari'=>'',
        ]);
    }
    public function actionSearchmemo($cari)
    {
      $searchModel = new MemoSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('
      pegawai.nama like "%'.$cari.'%"
      or keperluan like "%'.$cari.'%"
      ');
      return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>$cari,
      ]);
    }

    /**
     * Displays a single Memo model.
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
     * Creates a new Memo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Memo();
        $message='';
        if ($model->load(Yii::$app->request->post())) {
            $postval=Yii::$app->request->post('Memo');
            $start_date=$postval['jam_keluar'];
            $end_date=$postval['jam_pulang'];
            if(strlen($start_date)==0&&strlen($end_date)==0)
            {
              $message = 'Jam Keluar dan Jam Pulang Salah satu Harus Terisi';
              $title='Kesalahan';
              return $this->render('create', [
                  'model' => $model,
                  'errorstatus' => true,
                  'message'=>$message,
                  'title'=>$title,
              ]);
            }
            if($start_date!=NULL)
            {
              $getdate=explode(' ',$start_date);
              $start_date=$getdate[0];
            }
            else {
              $start_date=$end_date;
            }
            if($end_date!=NULL)
            {
              $getdate=explode(' ',$end_date);
              $end_date=$getdate[0];
            }
            else {
              $end_date=$start_date;
            }
            $userid=$postval['id_pegawai'];
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
            else{
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
     * Updates an existing Memo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $message='';
        if ($model->load(Yii::$app->request->post()) ) {
          $postval=Yii::$app->request->post('Memo');
          $start_date=$postval['jam_keluar'];
          $end_date=$postval['jam_pulang'];
          if(strlen($start_date)==0&&strlen($end_date)==0)
          {
            $message = 'Jam Keluar dan Jam Pulang Salah satu Harus Terisi';
            $title='Kesalahan';
            return $this->render('update', [
                'model' => $model,
                'errorstatus' => true,
                'message'=>$message,
                'title'=>$title,
            ]);
          }

          if($start_date!=NULL)
          {
            $getdate=explode(' ',$start_date);
            $start_date=$getdate[0];
          }else {
            $start_date=$end_date;
          }
          if($end_date!=NULL)
          {
            $getdate=explode(' ',$end_date);
            $end_date=$getdate[0];
          }
          else {
            $end_date=$start_date;
          }
          $userid=$postval['id_pegawai']          ;
          $helper = Yii::$app->myHelper;
          $isoverlap = $helper->cekTanggal($start_date,$end_date,$userid,2,$id);
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
          else{
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
     * Deletes an existing Memo model.
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
        $helper=Yii::$app->myHelper;
        $memo = $this->findModel($id);
        $getpegawai=$memo->idPegawai;
        $pegawai = $getpegawai->nama;
        $nip = $getpegawai->nip;
        $jabatan = $helper->getJabatanbyid($getpegawai->id_jabatan)->jabatan;

        $jam_keluar = $memo->jam_keluar!=null ? $memo->jam_keluar : '-';
        $jam_pulang = $memo->jam_pulang!=null ? $memo->jam_pulang : '-';

        $Kepala = $helper->pegawaiByJabatan('2')->nama;

        //$kepalaseksi = $helper->getKepalaseksibykode($memo->idSeksi->idJabatan->id_jabatan);
        $kodeseksi=$memo->idSeksi->kode;
        $getkepalaseksibykode=$helper->getKepalaseksibykode($kodeseksi);
        $jabatankepalaseksi=$getkepalaseksibykode->jabatan;
        $kode=$getkepalaseksibykode->id_jabatan;
        $namakepalaseksi=$helper->pegawaiByJabatan($kode)->nama;
        $gettanggal = $jam_keluar==null?$jam_pulang:$jam_keluar;
        $tanggal= date('Y-m-d',strtotime($gettanggal));
        $tanggal= $helper->indonesian_date($tanggal);

        $content = $this->renderPartial('printpernyataan',[
          'nama'=>$pegawai,
          'nip'=>$nip,
          'jam_keluar'=>$jam_keluar,
          'jam_pulang'=>$jam_pulang,
          'keperluan'=>$memo->keperluan,
          'kabupaten'=>$helper->config()->kabupaten,
          'kepala'=>$Kepala,
          'jabatankepalaseksi'=>$jabatankepalaseksi,
          'namakepalaseksi'=>$namakepalaseksi,
          'jabatan'=>$jabatan,
          'tanggal'=>$tanggal,
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
     * Finds the Memo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Memo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Memo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
