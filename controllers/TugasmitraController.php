<?php

namespace app\controllers;

use Yii;
use app\models\Tugasmitra;
use app\models\TugasmitraSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
/**
 * IjincutiController implements the CRUD actions for Ijincuti model.
 */
class TugasmitraController extends Controller
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
        $searchModel = new TugasmitraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $helper=Yii::$app->myHelper;
        $config=$helper->config();
        $tahun=$helper->config()->tahun;    
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cari'=>'',
        ]);
    }
    public function actionSearchtugasmitra($cari)
    {
      
      $searchModel = new SuratmasukSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('
      tugasmitra.kegiatan like "%'.$cari.'%"
      
      ');
      $cari='';
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
        $model = new Tugasmitra();
        $message='';
        if ($model->load(Yii::$app->request->post())) {
            $postval=Yii::$app->request->post('Tugasmitra');
            $start_date=$postval['date_start'];
            $end_date=$postval['date_end'];
            $tanggal_surat=$postval['created_date'];
            $program=$postval['program'];
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
            $postval=Yii::$app->request->post('Tugasmitra');
            $start_date=$postval['date_start'];
          $end_date=$postval['date_end'];
          $tanggal_surat=$postval['created_date'];
          $program=$postval['program'];
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
      $tanggalpelaksanaan=$helper->indonesian_date($surat->date_start).' - '.$helper->indonesian_date($surat->date_end);
      $config=$helper->config();
      $getnamaKepala = $helper->pegawaiByJabatan('2')->nama;
      $getnipKepala = $helper->pegawaiByJabatan('2')->nip;
      //$day=$helper->hitungHari($surat->date_start,$surat->date_end);
      
      $content = $this->renderPartial('print',[
        'satker' => $config->satker,
        'nama'=>$helper->mitraById($surat->nama)->nama,
        'tglenglish'=>$surat->created_date,
        'created_date'=> $helper->indonesian_date($surat->created_date),
        'date_start'=>$helper->indonesian_date($surat->date_start),
        'date_end'=>$helper->indonesian_date($surat->date_end),
        'suratdasar'=>$surat->suratdasar,
        'program'=>$surat->program,
        'nomor'=>$surat->nosurat,
        'kodesurat'=>$helper->seksiById($surat->assignee)->kode,
        'kegiatan'=>$surat->kegiatan,
        'destinasi'=>$surat->destinasi,
        'waktu'=>$tanggalpelaksanaan,
        'Kepala'=>$getnamaKepala,
        'nipKepala'=>$getnipKepala,
        'alamatkantor'=>$config->alamat,
        'is_plh'=>$helper->config()->is_plh,
        'namaplh'=>$helper->pegawaiById($helper->config()->plh_kepala)->nama,
        'nipplh'=>$helper->pegawaiById($helper->config()->plh_kepala)->nip,
        'kabupaten'=>$config->kabupaten,
      
      ]);
      $pdf = new Pdf([
        'mode' => Pdf::MODE_CORE, 
        'format' => Pdf::FORMAT_A4, 
        'orientation' => Pdf::ORIENT_PORTRAIT, 
        'destination' => Pdf::DEST_BROWSER, 
        'content' => $content,  
        'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
        'cssInline' => '.kv-heading-1{font-size:14px}', 
        'options' => ['title' => 'Krajee Report Title'],
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
        if (($model = Tugasmitra::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
