<?php

namespace app\controllers;

use Yii;
use app\models\Keterangan;
use app\models\KeteranganSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;

/**
 * KeteranganController implements the CRUD actions for Keterangan model.
 */
class KeteranganController extends Controller
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
     * Lists all Keterangan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KeteranganSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cari'=>'',
        ]);
    }

    /**
     * Displays a single Keterangan model.
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
     * Creates a new Keterangan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Keterangan();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Keterangan model.
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
     * Deletes an existing Keterangan model.
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
     * Finds the Keterangan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Keterangan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSearchketerangan($cari)
    {
      
      $searchModel = new KeteranganSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('
      mitra.nama like "%'.$cari.'%"
      
      ');
      $cari='';
      return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>$cari,
      ]);
    }
    public function actionPrint($id)
    {
      $person = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      $config=$helper->config();
      
   
      //$day=$helper->hitungHari($surat->date_start,$surat->date_end);
      
     $content = $this->renderPartial('print',[
        'satker' => $config->satker,
        'tglenglish'=> $person->tgl,
        'tgl'=>$helper->indonesian_date($person->tgl),
        'no'=>$person->no,
        //'kodesurat'=>$helper->seksiById(pegawaiById($person->nama)->idJabatan->jabatan)->kode,
        'ket'=>$person->ket,
        'nama'=> $helper->pegawaiById($person->nama)->nama,
        'nip'=>$helper->pegawaiById($person->nama)->nip,
        'jabatan'=>$helper->pegawaiById($person->nama)->idJabatan->jabatan,
        'ttd'=> $helper->pegawaiById($person->ttd)->nama,
        'nipttd'=>$helper->pegawaiById($person->ttd)->nip,
        'jabatanttd'=>$helper->pegawaiById($person->ttd)->idJabatan->jabatan,
        'golongan'=>$helper->pegawaiById($person->nama)->golongan,
        'pangkat'=>$helper->pegawaiById($person->nama)->pangkat,
        'alamatkantor'=>$config->alamat,
        'kabupaten'=>$config->kabupaten,
        'tahun'=>$helper->config()->tahun,
        

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
        if (($model = Keterangan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
