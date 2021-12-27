<?php

namespace app\controllers;

use Yii;
use app\models\Undangan;
use app\models\UndanganSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;

/**
 * UndanganController implements the CRUD actions for Undangan model.
 */
class UndanganController extends Controller
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
     * Lists all Undangan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UndanganSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $helper=Yii::$app->myHelper;
        $config=$helper->config();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tahun=$helper->config()->tahun; 
        $dataProvider->query->where("undangan.thn =  ".$tahun."");

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cari'=>'',
        ]);
    }

    /**
     * Displays a single Undangan model.
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
     * Creates a new Undangan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Undangan();

        if ($model->load(Yii::$app->request->post()) ) {
             $model->thn = date("Y-m-d H:i:s");
            $check_duplicate=Undangan::find()
            ->where(['no_undangan'=>Yii::$app->request->post('Undangan')['no_undangan']])
            ->one();
            if (!$check_duplicate && $model->save()){
                \Yii::$app->session->setFlash('succes','Data Berhasil Disimpan');
                return $this->redirect(['index','id'=>$model->id]);
            }
            else 
            \Yii::$app->session->setFlash('danger','Nomor Undangan Sudah Ada Harap Cek Kembali');
    
        } 
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    

    /**
     * Updates an existing Undangan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Undangan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionPrint($id)
    {
      $surat = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      $tanggalsurat = $helper->indonesian_date($surat->tgl_undangan);
      $hari = $helper->indonesian_date($surat->hari);
      $day = $helper->hariIndonesia($surat->hari);
      $config=$helper->config();
      $getnamaKepala = $helper->pegawaiByJabatan('2')->nama;
      $getnipKepala = $helper->pegawaiByJabatan('2')->nip;
      //$day=$helper->hitungHari($surat->date_start,$surat->date_end);
      
      $content = $this->renderPartial('print',[
        'satker' => $config->satker,
        'tglenglish'=>$surat->tgl_undangan,
        'tgl_undangan' =>$tanggalsurat,
        'no_undangan' =>$surat->no_undangan,
        'kodesurat'=>$helper->seksiById($surat->seksi)->kode,
        'sifat' =>$surat->sifat,
        'hal'=>$surat->hal,
        'lampiran'=>$surat->lampiran,
        'nama'=>$surat->nama,
        'di'=>$surat->di,
        'hari'=>$hari,
        'day'=>$day,
        'waktu'=>$surat->waktu,
        'acara'=>$surat->acara,
        'tempat'=>$surat->tempat,
        'Kepala'=>$getnamaKepala,
        'is_plh'=>$helper->config()->is_plh,
        'nipKepala'=>$getnipKepala,
        'alamatkantor'=>$config->alamat,
        'kabupaten'=>$config->kabupaten,
        'alamatlengkap'=>$helper->config()->alamatlengkap,
        'kodepos'=>$helper->config()->kodepos,
        'web'=>$helper->config()->web,
        'email'=>$helper->config()->email,
        'telepon'=>$helper->config()->telepon,
        'kabupaten'=>$helper->config()->kabupaten,
        'provinsi'=>$helper->config()->provinsi,
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
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Undangan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Undangan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Undangan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
