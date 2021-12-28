<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TugasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tugas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tugas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tugas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
      <?php
        $pegawai = ArrayHelper::map(\app\models\Pegawai::find()->all(), 'id', 'nama');
      ?>

     <?php $form = ActiveForm::begin(['action'=>'tugas/rekap','method'=>'post']); ?>

     <?= $form->field($model, 'id_pegawai')->dropDownList($pegawai, ['prompt' => '---- Pilih Pegawai yang diberi tugas ----'])->label('Pegawai') ?>

     <div class="form-group">
         <?= Html::submitButton('Rekap Tugas', ['class' =>'btn btn-primary']) ?>
     </div>

     <?php ActiveForm::end(); ?>

</div>
