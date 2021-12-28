<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * <?php $form->field($model=new Test(),'file')->fileInput() ?>
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Import Data';
?>

<?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
    <?= $form->field($model,'file')->fileInput() ?>
    <?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>
    <?php echo "<br/>"; ?>
    <?php echo Yii::$app->getHomeUrl(); ?>
    <div class="form-group">
        <?= Html::submitButton('Simpan',['class'=>'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>