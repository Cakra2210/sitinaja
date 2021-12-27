<?php

namespace app\controllers;

use Yii;
use app\models\Suratmasuk;
use app\models\SuratmasukSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
/**
 * IjincutiController implements the CRUD actions for Ijincuti model.
 */
class SuratmasukController extends Controller
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
        $searchModel = new SuratmasukSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $helper=Yii::$app->myHelper;
        $config=$helper->config();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tahun=$helper->config()->tahun; 
        $dataProvider->query->where("suratmasuk.thn =  ".$tahun."");

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cari'=>'',
        ]);
    }
    public function actionPdf($id)
    {
        $model = $this->findModel($id);
        return $this->render('pdf', [
            'model' => $model,
        ]);
    }
    public function actionSearchsuratmasuk($cari)
    {
      
      $searchModel = new SuratmasukSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('
      suratmasuk.instansi like "%'.$cari.'%"
      
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
         $model = new Suratmasuk();
         
          if ($model->load(Yii::$app->request->post())) {
            
            $model->thn = date("Y-m-d H:i:s");
            $scan = UploadedFile::getInstance($model,'scan');

            if(!is_null($scan)){
                $nosurat = $model->agenda;
                $fileName=$nosurat.'.'.$scan->extension;
                Yii::$app->params['uploadPath'] = '@webroot/uploads/suratmasuk/';
                $pathUpload = Yii::$app->params['uploadPath'].$fileName;
                $scan->saveAs($pathUpload);
                $model->scan = $fileName;
            }
            
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            
        ]);
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
        
        $temp_scan = $model->scan;

        if ($model->load(Yii::$app->request->post())) {

            $scan = UploadedFile::getInstance($model,'scan');

            if(!is_null($scan)){
               $nosurat = $model->agenda;
                $fileName='Agenda no_'.$nosurat.'.'.$scan->extension;
                Yii::$app->params['uploadPath'] = Yii::$app->basePath.'/web/uploads/suratmasuk/';
                $pathUpload = Yii::$app->params['uploadPath'].$fileName;
                $scan->saveAs($pathUpload);
                $model->scan = $fileName;
            }else{
                $model->scan = $temp_scan;
            }            
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionPrint($id)
    {
      $surat = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      
      $config=$helper->config();
      $getnamaKepala = $helper->pegawaiByJabatan('2')->nama;
      $getnipKepala = $helper->pegawaiByJabatan('2')->nip;
      //$day=$helper->hitungHari($surat->date_start,$surat->date_end);
      
      $content = $this->renderPartial('print',[
        'satker' => $config->satker,
        'agenda' => $surat->agenda,
        'tglcatat' =>$surat->tglcatat,
        'tglsurat' =>$surat->tglsurat,
        'nosurat'=>$surat->nosurat,
        'sifat'=>$surat->sifat,
        'instansi'=>$surat->instansi,
        'lampiran'=>$surat->lampiran,
        'Kepala'=>$getnamaKepala,
        'nipKepala'=>$getnipKepala,
        'alamatkantor'=>$config->alamat,
        'perihal'=>$surat->perihal,
        'alamatkantor'=>$config->alamat,
        'kabupaten'=>$config->kabupaten,
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
        'cssInline' => '.kv-heading-1{font-size:18px}', 
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

    


    /**
     * Finds the Ijincuti model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ijincuti the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Suratmasuk::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
