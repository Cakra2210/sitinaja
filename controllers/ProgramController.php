<?php

namespace app\controllers;

use Yii;
use app\models\Person;
use app\models\PersonSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\House;
use app\models\Room;
use app\models\Model;
use app\models\Pegawai;
use yii\helpers\ArrayHelper;
use kartik\mpdf\Pdf;
use yii\filters\AccessControl;

/**
 * PersonController implements the CRUD actions for Person model.
 */
class PersonController extends Controller
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
    public function actionIndex()
    {
        $searchModel = new PersonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
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
    public function actionSearchperson($cari)
    {
      
      $searchModel = new personSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $dataProvider->query->where('
      person.tentang like "%'.$cari.'%"
      
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
    $modelPerson = new Person;
    $modelsHouse = [new House];
    $modelsRoom = [[new Room]];
 
    if ($modelPerson->load(Yii::$app->request->post())) {
 
        $modelsHouse = Model::createMultiple(House::classname());
        Model::loadMultiple($modelsHouse, Yii::$app->request->post());
 
        // validate person and houses models
        $valid = $modelPerson->validate();
        $valid = Model::validateMultiple($modelsHouse) && $valid;
 
        if (isset($_POST['Room'][0][0])) {
            foreach ($_POST['Room'] as $indexHouse => $rooms) {
                foreach ($rooms as $indexRoom => $room) {
                    $data['Room'] = $room;
                    $modelRoom = new Room;
                    $modelRoom->load($data);
                    $modelsRoom[$indexHouse][$indexRoom] = $modelRoom;
                    $valid = $modelRoom->validate();
                    //die(var_dump($modelRoom->errors));
                }
            }
        }
        if ($valid) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($flag = $modelPerson->save(false)) {
                    foreach ($modelsHouse as $indexHouse => $modelHouse) {
 
                        if ($flag === false) {
                            break;
                        }
 
                        $modelHouse->person_id = $modelPerson->id;
 
                        if (!($flag = $modelHouse->save(false))) {
                            break;
                        }
 
                        if (isset($modelsRoom[$indexHouse]) && is_array($modelsRoom[$indexHouse])) {
                            foreach ($modelsRoom[$indexHouse] as $indexRoom => $modelRoom) {
                                $modelRoom->house_id = $modelHouse->id;
                                if (!($flag = $modelRoom->save(false))) {
                                    break;
                                }
                            }
                        }
                    }
                }
 
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $modelPerson->id]);
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
    }
 
    return $this->render('create', [
        'modelPerson' => $modelPerson,
        'modelsHouse' => (empty($modelsHouse)) ? [new House] : $modelsHouse,
        'modelsRoom' => (empty($modelsRoom)) ? [[new Room]] : $modelsRoom,
    ]);
}

    /**
     * Updates an existing Person model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
{
    $modelPerson = $this->findModel($id);
    $modelsHouse = $modelPerson->house;
    $modelsRoom = [];
    $oldRooms = [];
 
    if (!empty($modelsHouse)) {
        foreach ($modelsHouse as $indexHouse => $modelHouse) {
            $rooms = $modelHouse->rooms;
            $modelsRoom[$indexHouse] = $rooms;
            $oldRooms = ArrayHelper::merge(ArrayHelper::index($rooms, 'id'), $oldRooms);
        }
    }
 
    if ($modelPerson->load(Yii::$app->request->post())) {
 
        // reset
        $modelsRoom = [];
 
        $oldHouseIDs = ArrayHelper::map($modelsHouse, 'id', 'id');
        $modelsHouse = Model::createMultiple(House::classname(), $modelsHouse);
        Model::loadMultiple($modelsHouse, Yii::$app->request->post());
        $deletedHouseIDs = array_diff($oldHouseIDs, array_filter(ArrayHelper::map($modelsHouse, 'id', 'id')));
 
        // validate person and houses models
        $valid = $modelPerson->validate();
        $valid = Model::validateMultiple($modelsHouse) && $valid;
 
        $roomsIDs = [];
        if (isset($_POST['Room'][0][0])) {
            foreach ($_POST['Room'] as $indexHouse => $rooms) {
                $roomsIDs = ArrayHelper::merge($roomsIDs, array_filter(ArrayHelper::getColumn($rooms, 'id')));
                foreach ($rooms as $indexRoom => $room) {
                    $data['Room'] = $room;
                    $modelRoom = (isset($room['id']) && isset($oldRooms[$room['id']])) ? $oldRooms[$room['id']] : new Room;
                    $modelRoom->load($data);
                    $modelsRoom[$indexHouse][$indexRoom] = $modelRoom;
                    $valid = $modelRoom->validate();
                }
            }
        }
 
        $oldRoomsIDs = ArrayHelper::getColumn($oldRooms, 'id');
        $deletedRoomsIDs = array_diff($oldRoomsIDs, $roomsIDs);
 
        if ($valid) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($flag = $modelPerson->save(false)) {
 
                    if (! empty($deletedRoomsIDs)) {
                        Room::deleteAll(['id' => $deletedRoomsIDs]);
                    }
 
                    if (! empty($deletedHouseIDs)) {
                        House::deleteAll(['id' => $deletedHouseIDs]);
                    }
 
                    foreach ($modelsHouse as $indexHouse => $modelHouse) {
 
                        if ($flag === false) {
                            break;
                        }
 
                        $modelHouse->person_id = $modelPerson->id;
 
                        if (!($flag = $modelHouse->save(false))) {
                            break;
                        }
 
                        if (isset($modelsRoom[$indexHouse]) && is_array($modelsRoom[$indexHouse])) {
                            foreach ($modelsRoom[$indexHouse] as $indexRoom => $modelRoom) {
                                $modelRoom->house_id = $modelHouse->id;
                                if (!($flag = $modelRoom->save(false))) {
                                    break;
                                }
                            }
                        }
                    }
                }
 
                if ($flag) {
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $modelPerson->id]);
                } else {
                    $transaction->rollBack();
                }
            } catch (Exception $e) {
                $transaction->rollBack();
            }
        }
    }
 
    return $this->render('update', [
        'modelPerson' => $modelPerson,
        'modelsHouse' => (empty($modelsHouse)) ? [new House] : $modelsHouse,
        'modelsRoom' => (empty($modelsRoom)) ? [[new Room]] : $modelsRoom
    ]);
}
    

    /**
     * Deletes an existing Person model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionPrint($id)
    {
      $person = $this->findModel($id);
      $helper=Yii::$app->myHelper;
      $config=$helper->config();
      $lampiran = new House();
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
        'id'=> $helper->houseById($id)->id,
        'nama'=> $helper->pegawaiById($helper->houseByPerson($id)->nama)->nama,
        'sebagai'=> $helper->houseByPerson($id)->sebagai,
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
        'data'=>$lampiran,

      ]);

      $pdf = new Pdf([
        'mode' => Pdf::MODE_CORE, 
        'format' => Pdf::FORMAT_A4, 
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

    /**
     * Finds the Ijincuti model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ijincuti the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
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
        if (($model = Person::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
