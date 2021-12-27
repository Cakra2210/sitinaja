<?php

namespace app\controllers;

use Yii;
use app\models\Taterkolektif;
use app\models\TaterkolektifSearch;
use app\models\Kolitem;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Model;
use app\models\Pegawai;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;

/**
 * TaterkolektifController implements the CRUD actions for Taterkolektif model.
 */
class TaterkolektifController extends Controller
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
     * Lists all Taterkolektif models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaterkolektifSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $helper=Yii::$app->myHelper;
        $config=$helper->config();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tahun=$helper->config()->tahun; 
        $dataProvider->query->where("taterkolektif.thn =  ".$tahun."");

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Taterkolektif model.
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
     * Creates a new Taterkolektif model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelTaterkolektif = new Taterkolektif;
        $dataTaterkolektif = Taterkolektif::find()
                  ->all();
                $modelsKolitem = [new Kolitem];
        if ($modelTaterkolektif->load(Yii::$app->request->post())) {

            $modelTaterkolektif->thn = date("Y-m-d H:i:s");
            $modelsKolitem = Model::createMultiple(Kolitem::classname());
            Model::loadMultiple($modelsKolitem, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsKolitem),
                    ActiveForm::validate($modelTaterkolektif)
                );
            }

            // validate all models
            $valid = $modelTaterkolektif->validate();
            $valid = Model::validateMultiple($modelsKolitem) && $valid;
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelTaterkolektif->save(false)) {
                        foreach ($modelsKolitem as $modelKolitem) {
                            $modelKolitem->kol_id = $modelTaterkolektif->id;
                            if (! ($flag = $modelKolitem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelTaterkolektif->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'modelTaterkolektif' => $modelTaterkolektif,
            'dataTaterkolektif' => $dataTaterkolektif,
            'modelsKolitem' => (empty($modelsKolitem)) ? [new Kolitem] : $modelsKolitem
        ]);
    }

    /**
     * Updates an existing Taterkolektif model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $modelTaterkolektif = $this->findModel($id);
        $modelsKolitem = $modelTaterkolektif->kolitems;
        $dataTaterkolektif = Taterkolektif::find()
                  ->all();

        if ($modelTaterkolektif->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsKolitem, 'id', 'id');
            $modelsKolitem = Model::createMultiple(Kolitem::classname(), $modelsKolitem);
            Model::loadMultiple($modelsKolitem, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsKolitem, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsKolitem),
                    ActiveForm::validate($modelTaterkolektif)
                );
            }

            // validate all models
            $valid = $modelTaterkolektif->validate();
            $valid = Model::validateMultiple($modelsKolitem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelTaterkolektif->save(false)) {
                        if (! empty($deletedIDs)) {
                            Address::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsKolitem as $modelKolitem) {
                            $modelKolitem->kol_id = $modelTaterkolektif->id;
                            if (! ($flag = $modelKolitem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelTaterkolektif->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'modelTaterkolektif' => $modelTaterkolektif,
            'dataTaterkolektif' => $dataTaterkolektif,
            'modelsKolitem' => (empty($modelsKolitem)) ? [new Kolitem] : $modelsKolitem
        ]);
    }
    public function actionPrint($id)
    {
      $person = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      $config=$helper->config();
      $data = Kolitem::find()
              ->where(['kol_id' =>$id] )
              ->all(); 
      $tu=$helper->pegawaiByJabatan('3')->nama;
      $niptu=$helper->pegawaiByJabatan('3')->nip;
      $content = $this->renderPartial('print',[
        'satker' => $config->satker,
        'tglenglish'=>$person->tgl,
        'tgl'=> $helper->indonesian_date($person->tgl),
        'no'=>$person->no,
        'jenis'=>$person->jenis,
        
        'nip'=>$helper->pegawaiById($person->pemberi)->nip,
        'jabatan'=>$helper->pegawaiById($person->pemberi)->idJabatan->jabatan,
        'alamatkantor'=>$config->alamat,
        'perihal'=>$surat->perihal,
        'alamatkantor'=>$config->alamat,
        'kabupaten'=>$config->kabupaten,
        'data'=> $data,
        
        'tu' =>$tu,
        'niptu' =>$niptu,
      ]);

      $pdf = new Pdf([
        'mode' => Pdf::MODE_CORE, 
        'format' => Pdf::FORMAT_LEGAL, 
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
        if (($model = Taterkolektif::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
