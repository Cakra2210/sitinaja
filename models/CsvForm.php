<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "test".
 *
 * @property integer $id
 * @property string $nama
 * @property string $ttl
 * @property string $alamat
 */
class CsvForm extends Model
{
    public $file;

    public function rules()
    {
        return [
            [['file'],'required'],
            [['file'],'file','extensions'=>'csv','maxSize'=>1024 * 1024 * 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file'=>'Select File',
        ];
    }
}
