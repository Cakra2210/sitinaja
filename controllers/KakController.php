<?php

namespace app\controllers;

use Yii;
use app\models\Kak;
use app\models\Kakitem;
use app\models\Model;
use app\models\Pegawai;
use app\models\Jabatan;
use app\models\KakSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use kartik\mpdf\Pdf;
use kartik\file\FileInput;
use Mpdf\QrCode\QrCode;

/**
 * KakController implements the CRUD actions for Kak model.
 */
class KakController extends Controller
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
     * Lists all Kak models.
     * @return mixed
     */
    public function Output()
    {
        $code = new QrCode('LOREM IPSUM 2019');

        $mpdf = Mockery::mock('Mpdf\Mpdf');

        $mpdf->shouldReceive('SetDrawColor')->once();
        $mpdf->shouldReceive('SetFillColor')->twice();
        $mpdf->shouldReceive('Rect')->times(233);

        $output = new Mpdf();

        $output->output($code, $mpdf, 0, 0, 0);
    }


    public function actionIndex()
    {

        $searchModel = new KakSearch();
        $helper=Yii::$app->myHelper;
        $config=$helper->config();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tahun=$helper->config()->tahun;
        $dataProvider->query->where("kak.thn =  ".$tahun."");
        $events = \app\models\Kak::find()->all();
       
    
    $tasks = [];
 
    foreach ($events as $eve) {
        $arraycolor=['#1abc9c','#2ecc71','#3498db','#9b59b6','#34495e',
          '#16a085','#27ae60','#2980b9','#8e44ad','#2c3e50',
          '#f1c40f','#e67e22','#e74c3c','#f39c12','#d35400','#c0392b'];
        $col=$arraycolor[array_rand($arraycolor)];
        $event = new \yii2fullcalendar\models\Event();
        $event->id = $eve->id;
        $event->backgroundColor = $col;
        $event->title = $eve->kegiatan.' '.$eve->kegiatan ;
        $event->start =  $eve->start;
        $event->end =  $eve->end;
        $tasks[] = $event;
    }
 
    return $this->render('index', [
        'events' => $tasks,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'cari'=>'',

    ]);
    }

    public function actionRealisasi()
    {
        $lastdate=date('Y-m-t');
        $firstdate = date('Y-m-01');
        $model =Kak::find()
                ->all();
        $modelkak = Kakitem::find()
              ->where(['kak_id' =>$id] )
              ->all();       
        
        return $this->render('realisasi',[
          'model'=>$model,
          'modelkak'=>$modelkak,
          'firstdate'=>$firstdate,

        ]);
    }
    /**
     * Displays a single Kak model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionPenarikan()
    {
        $lastdate=date('Y-m-t');
        $firstdate = date('Y-m-01');
        $model =Kak::find()
                ->all();
        $modelkak = Kakitem::find()
              ->where(['kak_id' =>$id] )
              ->all();       
        
        return $this->render('penarikan',[
          'model'=>$model,
          'modelkak'=>$modelkak,
          'firstdate'=>$firstdate,

        ]);
    }
    public function actionJadwal()
    {
        $searchModel = new KakSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $events = \app\models\Kak::find()->all();
    
    $tasks = [];
    $kegiatan = ArrayHelper::map(\app\models\Pok21::find()->all(), 'id', 'pok');
    foreach ($events as $eve) {
        $arraycolor=['#1abc9c','#2ecc71','#3498db','#9b59b6','#34495e',
          '#16a085','#27ae60','#2980b9','#8e44ad','#2c3e50',
          '#f1c40f','#e67e22','#e74c3c','#f39c12','#d35400','#c0392b'];
        $col=$arraycolor[array_rand($arraycolor)];
        $kegiatan=$eve->uraian;
        $event = new \yii2fullcalendar\models\Event();
        $event->id = $eve->id;
        $event->backgroundColor = $col;
        $event->title = $kegiatan;
        $event->start =  $eve->start;
        $event->end =  $eve->end;
        $tasks[] = $event;
    }
 
    return $this->render('jadwal', [
        'events' => $tasks,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'cari'=>'',

    ]);
    }
    public function actionSearchkegiatan($cari)
    {
      
      $searchModel = new KakSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('
      kak.uraian like "%'.$cari.'%"
      
      ');
      $cari='';
      return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>$cari,
      ]);
    }
    
    public function actionSearchsk($cari)
    {
      
      $searchModel = new KakSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('
      kak.uraian like "%'.$cari.'%"
      
      ');
      $cari='';
      return $this->render('listsk', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>$cari,
      ]);
    }
    
    public function actionSearchpk($cari)
    {
      
      $searchModel = new KakSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('
      kak.uraian like "%'.$cari.'%"
      
      ');
      $cari='';
      return $this->render('listpk', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>$cari,
      ]);
    }
    public function actionSearchsurtu($cari)
    {
      
      $searchModel = new KakSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('
      kak.uraian like "%'.$cari.'%"
      
      ');
      $cari='';
      return $this->render('listsurtu', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>$cari,
      ]);
    }
     public function actionSearchspj($cari)
    {
      
      $searchModel = new KakSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('
      kak.uraian like "%'.$cari.'%"
      
      ');
      $cari='';
      return $this->render('listspj', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>$cari,
      ]);
    }
    public function actionSearchbast($cari)
    {
      
      $searchModel = new KakSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('
      kak.uraian like "%'.$cari.'%"
      
      ');
      $cari='';
      return $this->render('listbast', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>$cari,
      ]);
    }
    public function actionSearchbayar($cari)
    {
      
      $searchModel = new KakSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('
      kak.uraian like "%'.$cari.'%"
      
      ');
      $cari='';
      return $this->render('monevbayar', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'cari'=>$cari,
      ]);
    }
    /**
     * Displays a single Kak model.
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
     * Creates a new Kak model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionListsk()
     {
        $searchModel = new KakSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $events = \app\models\Kak::find()->all();
    
    $tasks = [];
 
    foreach ($events as $eve) {
        $arraycolor=['#1abc9c','#2ecc71','#3498db','#9b59b6','#34495e',
          '#16a085','#27ae60','#2980b9','#8e44ad','#2c3e50',
          '#f1c40f','#e67e22','#e74c3c','#f39c12','#d35400','#c0392b'];
        $col=$arraycolor[array_rand($arraycolor)];
        $event = new \yii2fullcalendar\models\Event();
        $event->id = $eve->id;
        $event->backgroundColor = $col;
        $event->title = $eve->kegiatan.' '.$eve->kegiatan ;
        $event->start =  $eve->start;
        $event->end =  $eve->end;
        $tasks[] = $event;
    }
 
    return $this->render('listsk', [
        'events' => $tasks,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'cari'=>'',

    ]);
    }
    
    public function actionListpk()
     {
        $searchModel = new KakSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $events = \app\models\Kak::find()->all();
    
    $tasks = [];
 
    foreach ($events as $eve) {
        $arraycolor=['#1abc9c','#2ecc71','#3498db','#9b59b6','#34495e',
          '#16a085','#27ae60','#2980b9','#8e44ad','#2c3e50',
          '#f1c40f','#e67e22','#e74c3c','#f39c12','#d35400','#c0392b'];
        $col=$arraycolor[array_rand($arraycolor)];
        $event = new \yii2fullcalendar\models\Event();
        $event->id = $eve->id;
        $event->backgroundColor = $col;
        $event->title = $eve->kegiatan.' '.$eve->kegiatan ;
        $event->start =  $eve->start;
        $event->end =  $eve->end;
        $tasks[] = $event;
    }
 
    return $this->render('listpk', [
        'events' => $tasks,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'cari'=>'',

    ]);
    }
    
    public function actionListsurtu()
     {
        $searchModel = new KakSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $events = \app\models\Kak::find()->all();
    
    $tasks = [];
 
    foreach ($events as $eve) {
        $arraycolor=['#1abc9c','#2ecc71','#3498db','#9b59b6','#34495e',
          '#16a085','#27ae60','#2980b9','#8e44ad','#2c3e50',
          '#f1c40f','#e67e22','#e74c3c','#f39c12','#d35400','#c0392b'];
        $col=$arraycolor[array_rand($arraycolor)];
        $event = new \yii2fullcalendar\models\Event();
        $event->id = $eve->id;
        $event->backgroundColor = $col;
        $event->title = $eve->kegiatan.' '.$eve->kegiatan ;
        $event->start =  $eve->start;
        $event->end =  $eve->end;
        $tasks[] = $event;
    }
 
    return $this->render('listsurtu', [
        'events' => $tasks,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'cari'=>'',

    ]);
    }
    public function actionListbast()
     {
        $searchModel = new KakSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
    
 
    return $this->render('listbast', [
        'events' => $tasks,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'cari'=>'',

    ]);
    }

    public function actionCreate()
    {
        $modelKak = new Kak ();
        
        $modelsKakitem = [new Kakitem];
        $kegiatan = ArrayHelper::map(\app\models\Pok21::find()->all(), 'so', 'so');
        
        
        if ($modelKak->load(Yii::$app->request->post())) {
           
            $modelKak->create_by = Yii::$app->user->identity->id;
            $modelKak->create_date = date("Y-m-d H:i:s");
            $modelKak->thn = date("Y-m-d H:i:s");
            $modelKak->save();

            $modelsKakitem = Model::createMultiple(Kakitem::classname());
            Model::loadMultiple($modelsKakitem, Yii::$app->request->post());

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsKakitem),
                    ActiveForm::validate($modelKak)
                );
            }

            // validate all models
            $valid = $modelKak->validate();
            $valid = Model::validateMultiple($modelsKakitem) && $valid;
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelKak->save(false)) {
                        foreach ($modelsKakitem as $modelKakitem) {
                            $modelKakitem->kak_id = $modelKak->id;
                            if (! ($flag = $modelKakitem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['index', 'id' => $modelKak->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'modelKak' => $modelKak,
            'dataKak' => $dataKak,
            'modelsKakitem' => (empty($modelsKakitem)) ? [new Kakitem] : $modelsKakitem
        ]);
    }
    public function actionUpdate($id)
    {
        $modelKak = $this->findModel($id);
        $modelsKakitem = $modelKak->kakitems;
        $dataKak = Kak::find()
                  ->all();
        $temp_scan = $model->scan;

        if ($modelKak->load(Yii::$app->request->post())) {

            $kegiatan = ArrayHelper::map(\app\models\Pok21::find()->all(), 'so', 'so');
            
            $modelKak->ubah_by = Yii::$app->user->identity->id;
            $modelKak->ubah = date("Y-m-d H:i:s");      
            $modelKak->save();

            $oldIDs = ArrayHelper::map($modelsKakitem, 'id', 'id');
            $modelsKakitem = Model::createMultiple(Kakitem::classname(), $modelsKakitem);
            Model::loadMultiple($modelsKakitem, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsKakitem, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsKakitem),
                    ActiveForm::validate($modelKak)
                );
            }

            // validate all models
            $valid = $modelKak->validate();
            $valid = Model::validateMultiple($modelsKakitem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelKak->save(false)) {
                        if (! empty($deletedIDs)) {
                            Address::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsKakitem as $modelKakitem) {
                            $modelKakitem->kak_id = $modelKak->id;
                            if (! ($flag = $modelKakitem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['index', 'id' => $modelKak->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('update', [
            'modelKak' => $modelKak,
            'dataKak' => $dataKak,
            'modelsKakitem' => (empty($modelsKakitem)) ? [new Kakitem] : $modelsKakitem
        ]);
    }

    /**
     * Deletes an existing Kak model.
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
     * Finds the Kak model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Kak the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Kak::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionPrintsk($id)
    {
      $data=Yii::$app->request;
      $person = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      $config=$helper->config();
      $models = Kakitem::find()
              ->where(['kak_id' =>$id] )
              ->all();
      $getnamaKepala = $helper->pegawaiByJabatan('2')->nama;

      $getnipKepala = $helper->pegawaiByJabatan('2')->nip; 
      $kegiatan = ArrayHelper::map(\app\models\Pok21::find()->all(), 'id', 'pok');
      
      $nama = ArrayHelper::map(\app\models\Pegawai::find()->all(), 'id', 'nama');
      
    
        
      //$day=$helper->hitungHari($surat->date_start,$surat->date_end);
      
      $content = $this->renderPartial('printsk',[
      
        'satker' => $config->satker,
        'tglsk'=> $helper->indonesian_date($person->tglsk),
        'nosk'=>$person->nosk,
        'nodipa'=>$helper->config()->nodipa,
        'tgldipa'=>$helper->indonesian_date($helper->config()->tgldipa),
        'hal'=>$person->hal,
        'nama' => $nama,
        'tentang'=> $person->uraian,        
        'sebagai'=> $pegawai->sebagai,
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

      // return the pdf output as per the destination setting
      return $pdf->render();

    }
    public function actionPrintminta($id)
    {
      $data=Yii::$app->request;
      $person = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      $config=$helper->config();
      $models = Kakitem::find()
              ->where(['kak_id' =>$id] )
              ->all();       
      $getnamaKepala = $helper->pegawaiByJabatan('2')->nama;

      $getnipKepala = $helper->pegawaiByJabatan('2')->nip; 
      
      //$day=$helper->hitungHari($surat->date_start,$surat->date_end);
      
      $content = $this->renderPartial('printminta',[
      
        'satker' => $config->satker,
        'seksi'=>$helper->seksiById($person->seksi)->seksi,
        'awal'=>$helper->indonesian_date($person->start),
        'ahir'=>$helper->indonesian_date($person->end),
        'uraian'=>$person->uraian,
        'nosk'=>$person->nosk,
        'tglsk'=> $helper->indonesian_date($person->tglsk),
        'tentang'=> $person->kegiatan,        
        'sebagai'=> $pegawai->sebagai,
        'ttd'=>$helper->pegawaiByJabatan($helper->seksiById($person->seksi)->jab)->nama,
        'nip'=>$helper->pegawaiByJabatan($helper->seksiById($person->seksi)->jab)->nip,
        'alamatkantor'=>$config->alamat,
        'kabupaten'=>$config->kabupaten,
        'tahun'=>$helper->config()->tahun,
        'nipplh'=>$helper->pegawaiById($helper->config()->plh_kepala)->nip,
        'data'=>$models,
        'sat'=>$item->sat,
        'tglbayar'=> $helper->indonesian_date($person->tglbayar),
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

      // return the pdf output as per the destination setting
      return $pdf->render();

    }
    public function actionPrintspj($id)
    {
      $data=Yii::$app->request;
      $person = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      $config=$helper->config();
      $models = Kakitem::find()
              ->where(['kak_id' =>$id] )
              ->all(); 
      $getkepala = $helper->pegawaiByJabatan('2')->nama;  
      $getnipkepala = $helper->pegawaiByJabatan('2')->nip;
      $getnamabendahara = $helper->pegawaiByJabatan('8')->nama;
      $getnipbendahara = $helper->pegawaiByJabatan('8')->nip; 
      $tgl= $helper->indonesian_date($person->tglbuat);
      $tempppk=$helper->config()->ppk;
      $ppk=$helper->pegawaiById($tempppk)->nama;
      $nipppk=$helper->pegawaiByid($tempppk)->nip;
      $getbuat = $helper->pegawaiById($person->pembuat)->nama;
      $getnipbuat =$helper->pegawaiById($person->pembuat)->nip;
      
      //$day=$helper->hitungHari($surat->date_start,$surat->date_end);
      
      $content = $this->renderPartial('printspj',[
      
        'satker' => $config->satker,
        'program'=>$helper->pok21ById($person->kegiatan)->prog,
        'akunprog'=>$helper->pok21ById($person->kegiatan)->kode_prog,
        'keg'=>$helper->pok21Byid($person->kegiatan)->keg,
        'akunkeg'=>$helper->pok21Byid($person->kegiatan)->kode_keg,
        'output'=>$helper->pok21Byid($person->kegiatan)->output,
        'akunoutput'=>$helper->pok21Byid($person->kegiatan)->kode_output,
        'so'=>$helper->pok21Byid($person->kegiatan)->so,
        'akunso'=>$helper->pok21Byid($person->kegiatan)->kode_so,
        'komponen'=>$helper->pok21Byid($person->kegiatan)->komponen,
        'akunkomponen'=>$helper->pok21Byid($person->kegiatan)->kode_komponen,
        'uraian'=>$person->uraian,
        'tentang'=> $person->kegiatan,        
        'sebagai'=> $pegawai->sebagai,
        'bendahara'=>$getnamabendahara,
        'nipbendahara'=>$getnipbendahara,
        'alamatkantor'=>$config->alamat,
        'kabupaten'=>$config->kabupaten,
        'is_plh'=>$helper->config()->is_plh,
        'tahun'=>$helper->config()->tahun,
        'namaplh'=>$helper->pegawaiById($helper->config()->plh_kepala)->nama,
        'nipplh'=>$helper->pegawaiById($helper->config()->plh_kepala)->nip,
        'data'=>$models,
        'sat'=>$item->sat,
        'tgl'=>$tgl,
        'ppk'=>$ppk,
        'nipppk'=>$nipppk,
        'buat'=> $getbuat,
        'nipbuat'=> $getnipbuat,
        'kepala' => $getkepala,
        'nipkepala'=>$getnipkepala,
        
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

      // return the pdf output as per the destination setting
      return $pdf->render();

    }
    public function actionPrintbast($id,$nama)
      {
      $data=Yii::$app->request;
      $person = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      $tanggalpelaksanaan=$helper->indonesian_date($person->start).' - '.$helper->indonesian_date($person->end);
      $config=$helper->config();
      $getnamaKepala = $helper->pegawaiByJabatan('2')->nama;
      $getnipKepala = $helper->pegawaiByJabatan('2')->nip;
      $pegawai = Kakitem::findOne([
          'id' => $nama,
      ]);
      $models = Kakitem::find()
              ->where(['kak_id' =>$id] )
              ->all(); 
      $tempppk=$helper->config()->ppk;
      $ppk=$helper->pegawaiById($tempppk)->nama;
      $sebagai = $pegawai->sebagai == 'PCL' ? 'Pencacah Lapangan':'Pengawas Lapangan';
      //$day=$helper->hitungHari($surat->date_start,$surat->date_end);
      $harga=$pegawai->harsat;
      $beb=$pegawai->beban;
      $tambah=$pegawai->tambahan;
      $denda=($harga*$beb)+$tambah;
      $thn=date("Y",strtotime($person->end));       
      $tglpk=date("j",strtotime($person->end));
      $haripk=date("l",strtotime($person->end));
      $blnpk=date("M",strtotime($person->end));
      $content = $this->renderPartial('printbast',[
        'satker' => $config->satker,
        'seksi'=>$helper->seksiById($person->seksi)->seksi,
        'nama'=>$pegawai->nama,
        'sebagai'=>$sebagai,
        'nosk'=>$person->nosk,
        'tglenglish'=>$person->end,
        'created_date'=> $helper->indonesian_date($person->tglsk),
        'date_start'=>$helper->indonesian_date($person->start),
        'date_end'=>$helper->indonesian_date($person->end),
        'suratdasar'=>$surat->suratdasar,
        'nomor'=>$pegawai->id,
        'kodesurat'=>$helper->seksiById($surat->assignee)->kode,
        'kegiatan'=>$person->uraian,
        'uraian' =>$helper->pok21ById($person->kegiatan)->keg,
        'destinasi'=>$pegawai->tempat,
        'waktu'=>$tanggalpelaksanaan,
        'Kepala'=>$getnamaKepala,
        'nipKepala'=>$getnipKepala,
        'alamatkantor'=>$config->alamatlengkap,
        'kabupaten'=>$config->kabupaten,
        'ppk'=>$ppk,
        'harsat'=>$helper->formatRupiah($harga),
        'tot'=>$helper->terbilang($harga),
        'thn'=>$helper->terbilang($thn),
        'hari'=>$helper->hariIndonesia($haripk),
        'bln'=>$helper->bulanIndonesia($blnpk),
        'tgl'=>$helper->penyebut($tglpk),
        'jenis'=>$pegawai->sat,
        'denda'=>$helper->formatRupiah($denda),
        'den'=>$helper->terbilang($denda),
        'alamat'=> $helper->mitraByNama($pegawai->nama)->alamat,
        'pekerjaan'=> $helper->mitraByNama($pegawai->nama)->pekerjaan,
        'beban'=>$beb,
        'dok'=>$helper->terbilang($beb),
        'ttd'=>$helper->pegawaiByJabatan($helper->seksiById($person->seksi)->jab)->nama,

      
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
        'cssInline' => '.kv-heading-1{font-size:14px}', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Krajee Report Title'],
         // call mPDF methods on the fly
      ]);
      $response = Yii::$app->response;
      $response->format = \yii\web\Response::FORMAT_RAW;
      $headers = Yii::$app->response->headers;
      $headers->add('Content-Type', 'application/pdf');
      return $pdf->render();

    }
    
    public function actionMonevbayar()
    {

        $searchModel = new KakSearch();
        $helper=Yii::$app->myHelper;
        $config=$helper->config();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tahun=$helper->config()->tahun;
        $dataProvider->query->where("kak.thn =  ".$tahun."");
        $events = \app\models\Kak::find()->all();
       
    
    $tasks = [];
 
    foreach ($events as $eve) {
        $arraycolor=['#1abc9c','#2ecc71','#3498db','#9b59b6','#34495e',
          '#16a085','#27ae60','#2980b9','#8e44ad','#2c3e50',
          '#f1c40f','#e67e22','#e74c3c','#f39c12','#d35400','#c0392b'];
        $col=$arraycolor[array_rand($arraycolor)];
        $event = new \yii2fullcalendar\models\Event();
        $event->id = $eve->id;
        $event->backgroundColor = $col;
        $event->title = $eve->kegiatan.' '.$eve->kegiatan ;
        $event->start =  $eve->start;
        $event->end =  $eve->end;
        $tasks[] = $event;
    }
 
    return $this->render('monevbayar', [
        'events' => $tasks,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'cari'=>'',

    ]);
    }
    public function actionBayar($id)
    {
        $modelKak = $this->findModel($id);
        $modelsKakitem = $modelKak->kakitems;
        $dataKak = Kak::find()
                  ->all();
       

        if ($modelKak->load(Yii::$app->request->post())) {

            $kegiatan = ArrayHelper::map(\app\models\Pok21::find()->all(), 'so', 'so');
            
            $modelKak->ubah_by = Yii::$app->user->identity->id;
            $modelKak->ubah = date("Y-m-d H:i:s");      
            $modelKak->save();

            $oldIDs = ArrayHelper::map($modelsKakitem, 'id', 'id');
            $modelsKakitem = Model::createMultiple(Kakitem::classname(), $modelsKakitem);
            Model::loadMultiple($modelsKakitem, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsKakitem, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsKakitem),
                    ActiveForm::validate($modelKak)
                );
            }

            // validate all models
            $valid = $modelKak->validate();
            $valid = Model::validateMultiple($modelsKakitem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelKak->save(false)) {
                        if (! empty($deletedIDs)) {
                            Model::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsKakitem as $modelKakitem) {
                            $modelKakitem->kak_id = $modelKak->id;
                            if (! ($flag = $modelKakitem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['monevbayar', 'id' => $modelKak->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('bayar', [
            'modelKak' => $modelKak,
            'dataKak' => $dataKak,
            'dataProvider' => $dataProvider,
            'modelsKakitem' => (empty($modelsKakitem)) ? [new Kakitem] : $modelsKakitem
        ]);
    }
    public function actionSk($id)
    {
        $modelKak = $this->findModel($id);

        if ($modelKak->load(Yii::$app->request->post()) && $modelKak->save()) {
            return $this->redirect(['listsk', 'id' => $modelKak->id]);
        } else {
            return $this->render('sk', [
                 'modelKak' => $modelKak,
            ]);
        }
    }
    public function actionPkkolektif($kak_id)
    {
      $arraynama = [];

      $nama = Kakitem::find()
      ->where(['kak_id' => $kak_id])
      ->asArray()
      ->all();

      foreach($nama as $ids)
      {
        array_push($arraynama,$ids['nama']);
      }
      $arraynama = array_values($arraynama);


      $pegawai= \app\models\Kakitem::find()
      ->select(['sebagai'])
      ->where(['IN','id',$nama])
      ->asArray()
      ->all();

      $peg= \app\models\Kakitem::find()
      ->select(['nama'])
      ->where(['IN','id',$nama])
      ->asArray()
      ->all();

      $beb= \app\models\Kakitem::find()
      ->select(['beban'])
      ->where(['IN','id',$nama])
      ->asArray()
      ->all();



      $model = Kakitem::findOne([
            'kak_id' => $kak_id,
        ]);


      return $this->render('pkkolektif', [
          'id' =>$kak_id,
          'tugas' =>$nama,
          'model' => $model,
          'pegawai' => $pegawai,
          'peg'=>$peg,
          'beb' => $beb,
          
      ]);
    }
    public function actionSurtukolektif($kak_id)
    {
      $arraynama = [];

      $nama = Kakitem::find()
      ->where(['kak_id' => $kak_id])
      ->asArray()
      ->all();

      foreach($nama as $ids)
      {
        array_push($arraynama,$ids['nama']);
      }
      $arraynama = array_values($arraynama);


      $pegawai= \app\models\Kakitem::find()
      ->select(['sebagai'])
      ->where(['IN','id',$nama])
      ->asArray()
      ->all();

      $peg= \app\models\Kakitem::find()
      ->select(['nama'])
      ->where(['IN','id',$nama])
      ->asArray()
      ->all();

      $beb= \app\models\Kakitem::find()
      ->select(['beban'])
      ->where(['IN','id',$nama])
      ->asArray()
      ->all();



      $model = Kakitem::findOne([
            'kak_id' => $kak_id,
        ]);


      return $this->render('surtukolektif', [
          'id' =>$kak_id,
          'tugas' =>$nama,
          'model' => $model,
          'pegawai' => $pegawai,
          'peg'=>$peg,
          'beb' => $beb,
          
      ]);
    }
    
    public function actionBastkolektif($kak_id)
    {
      $arraynama = [];

      $nama = Kakitem::find()
      ->where(['kak_id' => $kak_id])
      ->asArray()
      ->all();

      foreach($nama as $ids)
      {
        array_push($arraynama,$ids['nama']);
      }
      $arraynama = array_values($arraynama);


      $pegawai= \app\models\Kakitem::find()
      ->select(['sebagai'])
      ->where(['IN','id',$nama])
      ->asArray()
      ->all();

      $peg= \app\models\Kakitem::find()
      ->select(['nama'])
      ->where(['IN','id',$nama])
      ->asArray()
      ->all();

      $beb= \app\models\Kakitem::find()
      ->select(['beban'])
      ->where(['IN','id',$nama])
      ->asArray()
      ->all();



      $model = Kakitem::findOne([
            'kak_id' => $kak_id,
        ]);


      return $this->render('bastkolektif', [
          'id' =>$kak_id,
          'tugas' =>$nama,
          'model' => $model,
          'pegawai' => $pegawai,
          'peg'=>$peg,
          'beb' => $beb,
          
      ]);
    }
    
    public function actionPrintkolektif($id,$nama)
      {
      $data=Yii::$app->request;
      $person = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      $tanggalpelaksanaan=$helper->indonesian_date($person->start).' - '.$helper->indonesian_date($person->end);
      $config=$helper->config();
      $getnamaKepala = $helper->pegawaiByJabatan('2')->nama;
      $getnipKepala = $helper->pegawaiByJabatan('2')->nip;
      $pegawai = Kakitem::findOne([
          'id' => $nama,
      ]);
      //$day=$helper->hitungHari($surat->date_start,$surat->date_end);
      
      $content = $this->renderPartial('printkolektif',[
        'satker' => $config->satker,
        'nama'=>$pegawai->nama,
        'sebagai'=>$pegawai->sebagai,
        'nosk'=>$person->nosk,
        'tglenglish'=>$person->tglsk,
        'created_date'=> $helper->indonesian_date($person->tglsk),
        'date_start'=>$helper->indonesian_date($person->start),
        'date_end'=>$helper->indonesian_date($person->end),
        'suratdasar'=>$surat->suratdasar,
        'nomor'=>$pegawai->id,
        'kodesurat'=>$helper->seksiById($surat->assignee)->kode,
        'kegiatan'=>$person->uraian,
        'uraian' =>$helper->pok21ById($person->kegiatan)->keg,
        'destinasi'=>$pegawai->tempat,
        'waktu'=>$tanggalpelaksanaan,
        'Kepala'=>$getnamaKepala,
        'nipKepala'=>$getnipKepala,
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
        'cssInline' => '.kv-heading-1{font-size:14px}', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Krajee Report Title'],
         // call mPDF methods on the fly
      ]);
      $response = Yii::$app->response;
      $response->format = \yii\web\Response::FORMAT_RAW;
      $headers = Yii::$app->response->headers;
      $headers->add('Content-Type', 'application/pdf');
      return $pdf->render();

    }
    public function actionListspj()
    {

        $searchModel = new KakSearch();
        $helper=Yii::$app->myHelper;
        $config=$helper->config();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tahun=$helper->config()->tahun;
        $dataProvider->query->where("kak.thn =  ".$tahun."");
        $events = \app\models\Kak::find()->all();
       
    
    $tasks = [];
 
   
 
    return $this->render('listspj', [
        'events' => $tasks,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'cari'=>'',

    ]);
    }
    public function actionPrintpk($id,$nama)
      {
      $data=Yii::$app->request;
      $person = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      $tanggalpelaksanaan=$helper->indonesian_date($person->start).' - '.$helper->indonesian_date($person->end);
      $config=$helper->config();
      $getnamaKepala = $helper->pegawaiByJabatan('2')->nama;
      $getnipKepala = $helper->pegawaiByJabatan('2')->nip;
      $pegawai = Kakitem::findOne([
          'id' => $nama,
      ]);
      $models = Kakitem::find()
              ->where(['kak_id' =>$id] )
              ->all(); 
      $tempppk=$helper->config()->ppk;
      $ppk=$helper->pegawaiById($tempppk)->nama;
      $sebagai = $pegawai->sebagai == 'PCL' ? 'Pencacah Lapangan':'Pengawas Lapangan';
      //$day=$helper->hitungHari($surat->date_start,$surat->date_end);
      $harga=$pegawai->harsat;
      $beb=$pegawai->beban;
      $tambah=$pegawai->tambahan;
      $denda=($harga*$beb)+$tambah;
      $thn=date("Y",strtotime($person->tglsk));       
      $tglpk=date("j",strtotime($person->tglsk));
      $haripk=date("l",strtotime($person->tglsk));
      $blnpk=date("M",strtotime($person->tglsk));
      $content = $this->renderPartial('printpk',[
        'satker' => $config->satker,
        'nama'=>$pegawai->nama,
        'sebagai'=>$sebagai,
        'nosk'=>$person->nosk,
        'tglenglish'=>$person->tglsk,
        'created_date'=> $helper->indonesian_date($person->tglsk),
        'date_start'=>$helper->indonesian_date($person->start),
        'date_end'=>$helper->indonesian_date($person->end),
        'suratdasar'=>$surat->suratdasar,
        'nomor'=>$pegawai->id,
        'kodesurat'=>$helper->seksiById($surat->assignee)->kode,
        'kegiatan'=>$person->uraian,
        'uraian' =>$helper->pok21ById($person->kegiatan)->keg,
        'destinasi'=>$pegawai->tempat,
        'waktu'=>$tanggalpelaksanaan,
        'Kepala'=>$getnamaKepala,
        'nipKepala'=>$getnipKepala,
        'alamatkantor'=>$config->alamatlengkap,
        'kabupaten'=>$config->kabupaten,
        'ppk'=>$ppk,
        'harsat'=>$helper->formatRupiah($harga),
        'tot'=>$helper->terbilang($harga),
        'thn'=>$helper->terbilang($thn),
        'hari'=>$helper->hariIndonesia($haripk),
        'bln'=>$helper->bulanIndonesia($blnpk),
        'tgl'=>$helper->terbilang($tglpk),
        'jenis'=>$pegawai->sat,
        'denda'=>$helper->formatRupiah($denda),
        'den'=>$helper->terbilang($denda),
        'alamat'=> $helper->mitraByNama($pegawai->nama)->alamat,
        'pekerjaan'=> $helper->mitraByNama($pegawai->nama)->pekerjaan,

      
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
        'cssInline' => '.kv-heading-1{font-size:14px}', 
         // set mPDF properties on the fly
        'options' => ['title' => 'Krajee Report Title'],
         // call mPDF methods on the fly
      ]);
      $response = Yii::$app->response;
      $response->format = \yii\web\Response::FORMAT_RAW;
      $headers = Yii::$app->response->headers;
      $headers->add('Content-Type', 'application/pdf');
      return $pdf->render();

    }
    public function actionListupload()
    {

        $searchModel = new KakSearch();
        $helper=Yii::$app->myHelper;
        $config=$helper->config();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tahun=$helper->config()->tahun;
        $dataProvider->query->where("kak.thn =  ".$tahun."");
        $events = \app\models\Kak::find()->all();
       
    
    $tasks = [];
 
   
 
    return $this->render('listupload', [
        'events' => $tasks,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'cari'=>'',

    ]);
    }
    public function actionListdownload()
    {

        $searchModel = new KakSearch();
        $helper=Yii::$app->myHelper;
        $config=$helper->config();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tahun=$helper->config()->tahun;
        $dataProvider->query->where("kak.thn =  ".$tahun."");
        $events = \app\models\Kak::find()->all();
       
    
    $tasks = [];
 
   
 
    return $this->render('listdownload', [
        'events' => $tasks,
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
        'cari'=>'',

    ]);
    }
    public function actionPdf($id)
    {
        $modelKak = $this->findModel($id);
        return $this->render('pdf', [
            'modelKak' => $modelKak,
        ]);
    }
    public function actionUpload($id)
    {
       $modelKak = $this->findModel($id);

         if ($modelKak->load(Yii::$app->request->post())) {
            
            $modelKak->thn = date("Y-m-d H:i:s");
            $scan = UploadedFile::getInstance($modelKak,'scan');

            if(!is_null($scan)){
                $nosurat = $modelKak->id;
                $fileName='Kegiatan_'.$nosurat.'.'.$scan->extension;
                Yii::$app->params['uploadPath'] = '@webroot/uploads/kegiatan/';
                $pathUpload = Yii::$app->params['uploadPath'].$fileName;
                $scan->saveAs($pathUpload);
                $modelKak->scan = $fileName;
            }
            
            $modelKak->save();
            return $this->redirect(['listupload', 'id' => $modelKak->id]);
        }

        return $this->render('upload', [
            'modelKak' => $modelKak,
            
        ]);
    }
    
   
    public function actionSpj($id)
    {
        $modelKak = $this->findModel($id);
        $modelsKakitem = $modelKak->kakitems;
        $dataKak = Kak::find()
                  ->all();
       

        if ($modelKak->load(Yii::$app->request->post())) {

            $kegiatan = ArrayHelper::map(\app\models\Pok21::find()->all(), 'so', 'so');
            
            $modelKak->ubah_by = Yii::$app->user->identity->id;
            $modelKak->ubah = date("Y-m-d H:i:s");      
            $modelKak->save();

            $oldIDs = ArrayHelper::map($modelsKakitem, 'id', 'id');
            $modelsKakitem = Model::createMultiple(Kakitem::classname(), $modelsKakitem);
            Model::loadMultiple($modelsKakitem, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsKakitem, 'id', 'id')));

            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsKakitem),
                    ActiveForm::validate($modelKak)
                );
            }

            // validate all models
            $valid = $modelKak->validate();
            $valid = Model::validateMultiple($modelsKakitem) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelKak->save(false)) {
                        if (! empty($deletedIDs)) {
                            Model::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsKakitem as $modelKakitem) {
                            $modelKakitem->kak_id = $modelKak->id;
                            if (! ($flag = $modelKakitem->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['listspj', 'id' => $modelKak->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('spj', [
            'modelKak' => $modelKak,
            'dataKak' => $dataKak,
            'dataProvider' => $dataProvider,
            'modelsKakitem' => (empty($modelsKakitem)) ? [new Kakitem] : $modelsKakitem
        ]);
    }
    
}
