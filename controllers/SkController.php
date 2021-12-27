<?php

namespace app\controllers;

use Yii;
use app\models\Sk;
use app\models\SkSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Skitem;
use app\models\Model;
use app\models\Pegawai;
use app\models\Jabatan;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * PersonController implements the CRUD actions for Person model.
 */
class SkController extends Controller
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
     * Lists all Person models.
     * @return mixed
     */

    public function actionIndex(){
        $searchModel = new SkSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $files = Sk::find()->all();
        return $this->render('index',[
                'files' => $files,
                'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cari'=>'',
            ]);
    }
   

    /**
     * Displays a single Person model.
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
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSearchsk($cari)
    {
      
      $searchModel = new skSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('
      sk.tentang like "%'.$cari.'%"
      
      ');
      $cari='';
      return $this->render('index', [
          'files' => $files,
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
        $modelSk = new Sk;
        $modelsSkitem = [new Skitem];
        if ($modelSk->load(Yii::$app->request->post())) {
            $modelSk->thn = date("Y-m-d H:i:s");
            $modelsSkitem = Model::createMultiple(Skitem::classname());
            Model::loadMultiple($modelsSkitem, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsSkitem),
                    ActiveForm::validate($modelSk)
                );
            }

            // validate all models
            $valid = $modelSk->validate();
            $valid = Model::validateMultiple($modelsSkitem) && $valid;
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelSk->save(false)) {
                        foreach ($modelsSkitem as $modelSkitem) {
                            $modelSkitem->person_id = $modelSk->id;
                            if (! ($flag = $modelSkitem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelSk->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'modelSk' => $modelSk,
            'modelsSkitem' => (empty($modelsSkitem)) ? [new Skitem] : $modelsSkitem
        ]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $modelSk = $this->findModel($id);
        $modelsSkitem = $modelSk->skitems;

        if ($modelSk->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsSkitem, 'id', 'id');
            $modelsSkitem = Model::createMultiple(Skitem::classname(), $modelsSkitem);
            Model::loadMultiple($modelsSkitem, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsSkitem, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsSkitem),
                    ActiveForm::validate($modelSk)
                );
            }

            // validate all models
            $valid = $modelSk->validate();
            $valid = Model::validateMultiple($modelsSkitem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelSk->save(false)) {
                        if (! empty($deletedIDs)) {
                            Address::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsSkitem as $modelSkitem) {
                            $modelSkitem->person_id = $modelSk->id;
                            if (! ($flag = $modelSkitem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelSk->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'modelSk' => $modelSk,
            'modelsSkitem' => (empty($modelsSkitem)) ? [new Skitem] : $modelsSkitem
        ]);
    }
    public function actionPrint($id)
    {
      $data=Yii::$app->request;
      $person = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      $config=$helper->config();
      $models = Skitem::find()
              ->where(['person_id' =>$id] )
              ->all();
           
      $getnamaKepala = $helper->pegawaiByJabatan('2')->nama;

      $getnipKepala = $helper->pegawaiByJabatan('2')->nip;
      $isprintkpa = $person->jenis == 2 ? 'printkpa' : 'print';
   
      //$day=$helper->hitungHari($surat->date_start,$surat->date_end);
      
      $content = $this->renderPartial($isprintkpa,[
        'satker' => $config->satker,
        'tglsk'=> $helper->indonesian_date($person->tglsk),
        'nosk'=>$person->nosk,
        'nodipa'=>$helper->config()->nodipa,
        'tgldipa'=>$helper->indonesian_date($helper->config()->tgldipa),
        'hal'=>$person->hal,
        'jenis'=>$person->jenis,
        'tentang'=> $person->tentang,        
        'sebagai'=> $pegawai->sebagai,
        'keterangan'=> $helper->skitemByPerson($id)->keterangan,
        'Kepala'=>$getnamaKepala,
        'nipKepala'=>$getnipKepala,
        'alamatkantor'=>$config->alamat,
        'kabupaten'=>$config->kabupaten,
        'is_plh'=>$helper->config()->is_plh,
        'tahun'=>$helper->config()->tahun,
        'namaplh'=>$helper->pegawaiById($helper->config()->plh_kepala)->nama,
        'nipplh'=>$helper->pegawaiById($helper->config()->plh_kepala)->nip,
        'data'=>$models,
        

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
     * Finds the Person model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sk::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionUp($id)
    {
        $model = $this->findModel($id);
        $old_file = $model->namafile;
 
        if ($model->load(Yii::$app->request->post())) {
 
                $model->namafile = UploadedFile::getInstance($model, 'namafile');
                if($model->namafile){
                    //$file = $model->namafile->name;
                    $file = 'SK_'.$model->tentang.'.'.$model->namafile->extension;
                    if ($model->namafile->saveAs(Yii::getAlias('@app').'/web/file/'.$file)){
                        $model->namafile = $file;           
                    }
                }
                if (empty($model->namafile)){
                     $model->namafile = $old_file;
                }
 
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('up', [
           'model' => $model,
            ]);
        }
    }
    public function actionDeleteUpload() {
            
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $keys = Yii::$app->request->post('key');
        $key = explode(' ', $keys);
 
        $model = Upload::find()->where([
                    'id' => $key[1],
                    //'create_id' => Yii::$app->user->id
                ])->one();
 
        if ($key[0] == 'namafile') {
            @unlink(Yii::getAlias('app') . '/web/file/' . $model->namafile);
            $model->namafile = NULL;
            $model->save(false);
        }
 
        return [];
    }
    public function actionDownload1()
    {
      $path = Yii::getAlias('@webroot') . '/web/file/' ;
      if (file_exists($path)) {
          return Yii::$app->response->sendFile($path);
      }

    }

   public function actionDownload($id) {
   $path = Yii::getAlias('@webroot') . '/file/';

   $file = $path . $model->id;

   if (file_exists($file)) {

   Yii::$app->response->sendFile($file);
  } 
  }
  public function actionPrivacy() {
    Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
    $pdf = new Pdf([
        'mode' => Pdf::MODE_CORE, // leaner size using standard fonts
        'destination' => Pdf::DEST_BROWSER,
        'content' => $this->renderPartial('namafile'),
        'options' => [
            // any mpdf options you wish to set
        ],
        'methods' => [
            'SetTitle' => 'Privacy Policy - Krajee.com',
            'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
            'SetHeader' => ['Krajee Privacy Policy||Generated On: ' . date("r")],
            'SetFooter' => ['|Page {PAGENO}|'],
            'SetAuthor' => 'Kartik Visweswaran',
            'SetCreator' => 'Kartik Visweswaran',
            'SetKeywords' => 'Krajee, Yii2, Export, PDF, MPDF, Output, Privacy, Policy, yii2-mpdf',
        ]
    ]);
    return $pdf->render();
}
public function actionPdf($id)
    {
        $model = $this->findModel($id);
        return $this->render('pdf', [
            'model' => $model,
        ]);
    }
    public function actionUpload($id)
    {
       $model = $this->findModel($id);

         if ($model->load(Yii::$app->request->post())) {
            
            $model->thn = date("Y-m-d H:i:s");
            $scan = UploadedFile::getInstance($model,'scan');

            if(!is_null($scan)){
                $nosurat = $model->id;
                $fileName='Kegiatan_'.$nosurat.'.'.$scan->extension;
                Yii::$app->params['uploadPath'] = '@webroot/uploads/sk/';
                $pathUpload = Yii::$app->params['uploadPath'].$fileName;
                $scan->saveAs($pathUpload);
                $model->scan = $fileName;
            }
            
            $model->save();
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('upload', [
            'model' => $model,
            
        ]);
    }
}
