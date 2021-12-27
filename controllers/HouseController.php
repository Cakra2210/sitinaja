<?php

namespace app\controllers;

use Yii;
use app\models\House;
use app\models\HouseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HouseController implements the CRUD actions for House model.
 */
class HouseController extends Controller
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
     * Lists all House models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HouseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single House model.
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
     * Creates a new House model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new House();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing House model.
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
     * Deletes an existing House model.
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
     * Finds the House model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return House the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPrint($id)
    {
      $person = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      $config=$helper->config();
      $getnamaKepala = $helper->pegawaiByJabatan('2')->nama;
      $getnipKepala = $helper->pegawaiByJabatan('2')->nip;
      
   
      //$day=$helper->hitungHari($surat->date_start,$surat->date_end);
      
      $content = $this->renderPartial('print',[
        'satker' => $config->satker,
        'nama'=> $person->nama,
        'sebagai'=> $person->sebagai,
        'nip'=>$helper->pegawaiById($helper->houseByPerson($id)->nama)->nip,
        'jabatan'=>$helper->pegawaiById($helper->houseByPerson($id)->nama)->idJabatan->jabatan,
        'golongan'=>$helper->pegawaiById($helper->houseByPerson($id)->nama)->golongan,
        'keterangan'=> $helper->houseByPerson($id)->keterangan,
        'Kepala'=>$getnamaKepala,
        'nipKepala'=>$getnipKepala,
        'alamatkantor'=>$config->alamat,
        'kabupaten'=>$config->kabupaten,
        'is_plh'=>$helper->config()->is_plh,
        'tahun'=>$helper->config()->tahun,
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
          'cssInline' => '.kv-heading-1{font-size:14px}',
      ]);

      $response = Yii::$app->response;
      $response->format = \yii\web\Response::FORMAT_RAW;
      $headers = Yii::$app->response->headers;
      $headers->add('Content-Type', 'application/pdf');

      // return the pdf output as per the destination setting
      return $pdf->render();

    }

    protected function findModel($id)
    {
        if (($model = House::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
