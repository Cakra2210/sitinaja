<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "holiday".
 *
 * @property integer $id
 * @property string $tanggal
 * @property string $keterangan
 */
class Holiday extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'holiday';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tanggal', 'keterangan'], 'required'],
            [['tanggal'], 'safe'],
            [['keterangan'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tanggal' => 'Tanggal',
            'keterangan' => 'Keterangan',
        ];
    }
}
