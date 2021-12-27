<?php

namespace app\controllers;

use Yii;
use app\models\Mitra;
use app\models\MitraSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
/**
 * MitraController implements the CRUD actions for Mitra model.
 */
class MitraController extends Controller
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
     * Lists all Mitra models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MitraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cari'=>'',
        ]);
    }

    /**
     * Displays a single Mitra model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionSearchmitra($cari)
    {
      
      $searchModel = new MitraSearch();
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
    
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Mitra model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Mitra();

        if ($model->load(Yii::$app->request->post()) ) {
            $foto = UploadedFile::getInstance($model,'foto');

            if(!is_null($foto)){
                $date = date("YmdHis");
                $fileName=Yii::$date.'.'.$foto->extension;
                Yii::$app->params['uploadPath'] = Yii::$app->basePath.'/web/uploads/fotomitra/';
                $pathUpload = Yii::$app->params['uploadPath'].$fileName;
                $foto->saveAs($pathUpload);
                $model->foto = $fileName;
            }
          
            $model->save();
            
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $temp_foto = $model->foto;
         if ($model->load(Yii::$app->request->post())) {

            $foto = UploadedFile::getInstance($model,'foto');
            
            if(!is_null($foto)){
                $date = date("YmdHis");
                $fileName=Yii::$app->user->identity->nip.$date.'.'.$foto->extension;
                Yii::$app->params['uploadPath'] = Yii::$app->basePath.'/web/uploads/fotomitra/';
                $pathUpload = Yii::$app->params['uploadPath'].$fileName;
                $foto->saveAs($pathUpload);
                $model->foto = $fileName;
            }else{
                $model->foto = $temp_foto;
            }


           
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Mitra model.
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
     * Finds the Mitra model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Mitra the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Mitra::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
