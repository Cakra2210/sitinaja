<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Pegawai;
use app\models\CsvForm;
use yii\web\UploadedFile;
use app\models\Tugas;
use app\models\Holiday;
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','index','changedate'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index','changedate'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $lastdate=date('Y-m-t');
        $firstdate = date('Y-m-01');
        $model = Tugas::find()
                ->andWhere(['<=', 'date_end', $lastdate])
                ->andWhere(['>=', 'date_start', $firstdate])
                ->andWhere(['not',['nosurat'=>'']])
                ->andWhere(['not',['nosurat'=>'x']])
                ->andWhere(['not',['tugas.sppd'=>'2']])
                ->all();
        $harilibur = Holiday::find()
                ->andWhere(['<=', 'tanggal', $lastdate])
                ->andWhere(['>=', 'tanggal', $firstdate])
                ->all();
        return $this->render('index',[
          'model'=>$model,
          'firstdate'=>$firstdate,
          'harilibur'=>$harilibur,
        ]);
    }

    public function actionChangedate($nav,$date)
    {
      $lastdate=date('Y-m-t', strtotime($date));
      $firstdate=date('Y-m-01', strtotime($date));
      $model = Tugas::find()
              ->andWhere(['<=', 'date_end', $lastdate])
              ->andWhere(['>=', 'date_start', $firstdate])
              ->andWhere(['not',['nosurat'=>'']])
              ->andWhere(['not',['nosurat'=>'x']])
              ->andWhere(['not',['tugas.sppd'=>'2']])
              ->all();
      $harilibur = Holiday::find()
              ->andWhere(['<=', 'tanggal', $lastdate])
              ->andWhere(['>=', 'tanggal', $firstdate])
              ->all();
      return $this->render('index',[
        'model'=>$model,
        'firstdate'=>$firstdate,
        'harilibur'=>$harilibur,
      ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    public function actionUpload()
    {
      $model = new CsvForm();
      if($model->load(Yii::$app->request->post())){
          $file = UploadedFile::getInstance($model,'file');
          $filename = 'Data.'.$file->extension;
          $upload = $file->saveAs('uploads/'.$filename);
          if($upload){
              define('CSV_PATH','uploads/');
              $csv_file = CSV_PATH . $filename;
              $filecsv = file($csv_file);
              //print_r($filecsv);
              foreach($filecsv as $data){
                  //$modelnew = new Test();
                  $hasil = explode(",",$data);
                  $nama = $hasil[0];
                  $ttl = $hasil[1];
                  $alamat = $hasil[2];
                  echo($nama);
                  //$modelnew->nama = $nama;
                  //$modelnew->ttl = $ttl;
                  //$modelnew->alamat = $alamat;
                  //$modelnew->save();
              }
              echo $hasil[0];
              //unlink('uploads/'.$filename);
              //return $this->redirect(['test/index']);
          }
      }else{
          return $this->render('upload',['model'=>$model]);
      }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
