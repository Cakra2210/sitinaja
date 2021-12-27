<?php

namespace app\controllers;

use Yii;
use app\models\Organik;
use app\models\OrganikSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * OrganikController implements the CRUD actions for Organik model.
 */
class OrganikController extends Controller
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
     * Lists all Organik models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrganikSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Organik model.
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
    public function actionDaftar($id)
    {
        return $this->render('daftar', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Organik model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Organik();

        if ($model->load(Yii::$app->request->post()) ) {
            $foto = UploadedFile::getInstance($model,'foto');

            if(!is_null($foto)){
                $nama = $model->id;
                $fileName=$nama.'.'.$foto->extension;
                Yii::$app->params['uploadPath'] = Yii::$app->basePath.'/web/uploads/fotoorganik/';
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

    /**
     * Updates an existing Organik model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $temp_foto = $model->foto;
         if ($model->load(Yii::$app->request->post())) {

            $foto = UploadedFile::getInstance($model,'foto');
            
            if(!is_null($foto)){
                $nama = $model->id;
                $fileName=$nama.'.'.$foto->extension;
                Yii::$app->params['uploadPath'] = Yii::$app->basePath.'/web/uploads/fotoorganik/';
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
     * Deletes an existing Organik model.
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
     * Finds the Organik model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Organik the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Organik::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionQr($id)
    {
    $qr = Yii::$app->get('qr');

Yii::$app->response->format = Response::FORMAT_RAW;
Yii::$app->response->headers->add('Content-Type', $qr->getContentType());

return $qr
    ->setText('https://2amigos.us')
    ->setLabel('2amigos consulting group llc')
    ->writeString();


    }
}
