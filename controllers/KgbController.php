<?php

namespace app\controllers;

use Yii;
use app\models\Kgb;
use app\models\KgbSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;

/**
 * KgbController implements the CRUD actions for Kgb model.
 */
class KgbController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Kgb models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KgbSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Kgb model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Kgb model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Kgb();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Kgb model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Kgb model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Kgb model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kgb the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPrint($id)
    {
      $kgb = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      $gettmt = $helper->pegawaiById($kgb->nama)->tmtmasuk;
      $kini= $kgb->tgllama; 
      $now= $kgb->tmtbaru; 
      $pegawai = $kgb->nama;
      $config=$helper->config();
      
      $getnamaKepala = $helper->pegawaiByJabatan('2')->nama;
      $getnipKepala = $helper->pegawaiByJabatan('2')->nip;
      $interval = $helper->dateDifference($gettmt,$kini);
      $inter = $helper->dateDifference($gettmt,$now);
      $blnpk=date("M",strtotime($kgb->tmtbaru));
      $thn=date("Y",strtotime($kgb->tmtbaru)); 
            
      $content = $this->renderPartial('print',[
        'nomor'=>$kgb->nomor,
        'nama'=>$helper->pegawaiById($kgb->nama)->nama,
        'nip'=>$helper->pegawaiById($kgb->nama)->nip,
        'pangkat' => $helper->pegawaiById($kgb->nama)->pangkat,    
        'golongan' =>$helper->pegawaiById($kgb->nama)->golongan,
        'satker' => $config->satker,
        'gapoklama'=>$helper->formatRupiah($kgb->gapoklama),
        'gapokbaru'=>$helper->formatRupiah($kgb->gapokbaru),
        'tanggal_surat'=>$helper->indonesian_date($kgb->tglbuat),
        'Kepala'=>$getnamaKepala,
        'nipKepala'=>$getnipKepala,
        'day'=>$day,
        'tmt' =>$interval,
        'inter'=>$inter,
        'pejabat'=> $kgb->pejabat,
        'tgllama'=> $helper->indonesian_date($kgb->tgllama),
        'tmtlama'=> $helper->indonesian_date($kgb->tmtlama),
        'tmtbaru'=> $helper->indonesian_date($kgb->tmtbaru),
        'nolama'=> $kgb->nolama,
        'penyebut' =>$helper->terbilang($kgb->gapoklama),
        'penye'=> $helper->terbilang($kgb->gapokbaru), 
        'alamatkantor'=>$config->alamat,
        'alamatkppn'=>$config->alamatkppn,
        'kppn'=>$config->kppn,
        'kabupaten'=>$config->kabupaten,
        'kerjabaru'=>$kgb->kerjabaru,
        'bln'=>$helper->bulanIndonesia($blnpk),
        'thn'=>($thn),
      ]);

      $pdf = new Pdf([
        'mode' => Pdf::MODE_CORE, 
        'format' => Pdf::FORMAT_LEGAL, 
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
    protected function findModel($id)
    {
        if (($model = Kgb::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
