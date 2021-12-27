<?php

namespace app\controllers;

use Yii;
use app\models\Pengantar;
use app\models\Pengantaritem;
use app\models\PengantarSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Model;
use app\models\Pegawai;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;

/**
 * PengantarController implements the CRUD actions for Pengantar model.
 */
class PengantarController extends Controller
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
     * Lists all Pengantar models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PengantarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $helper=Yii::$app->myHelper;
        $config=$helper->config();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tahun=$helper->config()->tahun; 
        $dataProvider->query->where("pengantar.thn =  ".$tahun."");

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cari'=>'',
        ]);
    }

    /**
     * Displays a single Pengantar model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
      $person = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      $config=$helper->config();
      $data = Pengantaritem::find()
              ->where(['person_id' =>$id] )
              ->all();  
        return $this->render('view', [
        'satker' => $config->satker,
        'tglenglish'=>$person->tgl,
        'tgl'=> $helper->indonesian_date($person->tgl),
        'no'=>$person->no,
        'di'=>$person->di,
        'pengirim'=>$helper->pegawaiById($person->pengirim)->nama,
        'kepada'=>$person->kepada,
        'nip'=>$helper->pegawaiById($person->pengirim)->nip,
        'jabatan'=>$helper->pegawaiById($person->pengirim)->idJabatan->jabatan,
        'nipKepala'=>$getnipKepala,
        'alamatkantor'=>$config->alamat,
        'perihal'=>$surat->perihal,
        'alamatkantor'=>$config->alamat,
        'kabupaten'=>$config->kabupaten,
        'data'=> $data,
        'cq'=> $person->cq,
        'model' => $this->findModel($id),
            
        ]);
    }

    /**
     * Creates a new Pengantar model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSearchPengantar($cari)
    {
      
      $searchModel = new pengantarSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('
      pengantar.tgl like "%'.$cari.'%"
      
      ');
      $cari='';
      return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>$cari,
      ]);
    }
    public function actionCreate()
    {
        $modelPengantar = new Pengantar;
        $modelsPengantaritem = [new Pengantaritem];
        if ($modelPengantar->load(Yii::$app->request->post())) {
             $modelPengantar->thn = date("Y-m-d H:i:s");
            $modelsPengantaritem = Model::createMultiple(Pengantaritem::classname());
            Model::loadMultiple($modelsPengantaritem, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsPengantaritem),
                    ActiveForm::validate($modelPengantar)
                );
            }

            // validate all models
            $valid = $modelPengantar->validate();
            $valid = Model::validateMultiple($modelsPengantaritem) && $valid;
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelPengantar->save(false)) {
                        foreach ($modelsPengantaritem as $modelPengantaritem) {
                            $modelPengantaritem->person_id = $modelPengantar->id;
                            if (! ($flag = $modelPengantaritem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelPengantar->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'modelPengantar' => $modelPengantar,
            'modelsPengantaritem' => (empty($modelsPengantaritem)) ? [new Pengantaritem] : $modelsPengantaritem
        ]);
    }
    public function actionUpdate($id)
    {
        $modelPengantar = $this->findModel($id);
        $modelsPengantaritem = $modelPengantar->pengantaritems;

        if ($modelPengantar->load(Yii::$app->request->post())) {
            

            $oldIDs = ArrayHelper::map($modelsPengantaritem, 'id', 'id');
            $modelsPengantaritem = Model::createMultiple(Pengantaritem::classname(), $modelsPengantaritem);
            Model::loadMultiple($modelsPengantaritem, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsPengantaritem, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsPengantaritem),
                    ActiveForm::validate($modelPengantar)
                );
            }

            // validate all models
            $valid = $modelPengantar->validate();
            $valid = Model::validateMultiple($modelsPengantaritem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelPengantar->save(false)) {
                        if (! empty($deletedIDs)) {
                            Address::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsPengantaritem as $modelPengantaritem) {
                            $modelPengantaritem->person_id = $modelPengantar->id;
                            if (! ($flag = $modelPengantaritem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelPengantar->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'modelPengantar' => $modelPengantar,
            'modelsPengantaritem' => (empty($modelsPengantaritem)) ? [new Pengantaritem] : $modelsPengantaritem
        ]);
    }
    public function actionPrint($id)
    {
      $person = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      $config=$helper->config();
      $data = Pengantaritem::find()
              ->where(['person_id' =>$id] )
              ->all();   
      
    
   
      //$day=$helper->hitungHari($surat->date_start,$surat->date_end);
      
      $content = $this->renderPartial('print',[
        'satker' => $config->satker,
        'tglenglish'=>$person->tgl,
        'tgl'=> $helper->indonesian_date($person->tgl),
        'no'=>$person->no,
        'di'=>$person->di,
        'pengirim'=>$helper->pegawaiById($person->pengirim)->nama,
        'kepada'=>$person->kepada,
        'nip'=>$helper->pegawaiById($person->pengirim)->nip,
        'jabatan'=>$helper->pegawaiById($person->pengirim)->idJabatan->jabatan,
        'nipKepala'=>$getnipKepala,
        'alamatkantor'=>$config->alamat,
        'perihal'=>$surat->perihal,
        'alamatkantor'=>$config->alamat,
        'kabupaten'=>$config->kabupaten,
         'cq'=> $person->cq,
        'data'=> $data,
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
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pengantar model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pengantar the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pengantar::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
