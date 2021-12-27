<?php

namespace app\controllers;

use Yii;
use app\models\Tater;
use app\models\Tateritem;
use app\models\TaterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Model;
use app\models\Pegawai;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;

/**
 * TaterController implements the CRUD actions for Tater model.
 */
class TaterController extends Controller
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
     * Lists all Tater models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $helper=Yii::$app->myHelper;
        $config=$helper->config();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tahun=$helper->config()->tahun; 
        $dataProvider->query->where("tater.thn =  ".$tahun."");

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tater model.
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
     * Creates a new Tater model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    
    public function actionSearchtater($cari)
    {
      
      $searchModel = new TaterSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('
      tater.jenis like "%'.$cari.'%"
      
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
    
    public function actionCreate()
    {
        $modelTater = new Tater;
        $dataTater = Tater::find()
                  ->all();
                $modelsTateritem = [new Tateritem];
        if ($modelTater->load(Yii::$app->request->post())) {
            
            $modelTater->thn = date("Y-m-d H:i:s");
            $modelsTateritem = Model::createMultiple(Tateritem::classname());
            Model::loadMultiple($modelsTateritem, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsTateritem),
                    ActiveForm::validate($modelTater)
                );
            }

            // validate all models
            $valid = $modelTater->validate();
            $valid = Model::validateMultiple($modelsTateritem) && $valid;
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelTater->save(false)) {
                        foreach ($modelsTateritem as $modelTateritem) {
                            $modelTateritem->person_id = $modelTater->id;
                            if (! ($flag = $modelTateritem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelTater->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'modelTater' => $modelTater,
            'dataTater' => $dataTater,
            'modelsTateritem' => (empty($modelsTateritem)) ? [new Tateritem] : $modelsTateritem
        ]);
    }
    public function actionUpdate($id)
    {
        $modelTater = $this->findModel($id);
        $modelsTateritem = $modelTater->tateritems;
        $dataTater = Tater::find()
                  ->all();

        if ($modelTater->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsTateritem, 'id', 'id');
            $modelsTateritem = Model::createMultiple(Tateritem::classname(), $modelsTateritem);
            Model::loadMultiple($modelsTateritem, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsTateritem, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsTateritem),
                    ActiveForm::validate($modelTater)
                );
            }
            $valid = $modelTater->validate();
            $valid = Model::validateMultiple($modelsTateritem) && $valid;
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelTater->save(false)) {
                        if (! empty($deletedIDs)) {
                            Address::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsTateritem as $modelTateritem) {
                            $modelTateritem->person_id = $modelTater->id;
                            if (! ($flag = $modelTateritem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelTater->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'modelTater' => $modelTater,
            'dataTater' => $dataTater,
            'modelsTateritem' => (empty($modelsTateritem)) ? [new Tateritem] : $modelsTateritem
        ]);
    }

   
    public function actionPrint($id)
    {
      $person = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      $config=$helper->config();
      $data = Tateritem::find()
              ->where(['person_id' =>$id] )
              ->all(); 
      $tu=$helper->pegawaiByJabatan('3')->nama;
      $niptu=$helper->pegawaiByJabatan('3')->nip;           
      $content = $this->renderPartial('print',[
        'satker' => $config->satker,
        'tglenglish'=>$person->tgl,
        'tgl'=> $helper->indonesian_date($person->tgl),
        'no'=>$person->no,
        'jenis'=>$person->jenis,
        'pengirim'=>$helper->pegawaiById($person->pemberi)->nama,
        'penerima'=>$helper->pegawaiById($person->penerima)->nama,
        'nip'=>$helper->pegawaiById($person->pemberi)->nip,
        'jabatan'=>$helper->pegawaiById($person->pemberi)->idJabatan->jabatan,
        'nipterima'=>$helper->pegawaiById($person->penerima)->nip,
        'nipKepala'=>$getnipKepala,
        'alamatkantor'=>$config->alamat,
        'perihal'=>$surat->perihal,
        'alamatkantor'=>$config->alamat,
        'kabupaten'=>$config->kabupaten,
        'data'=> $data,
        'niptu' =>$niptu,
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
      return $pdf->render();

    }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Tater::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
  