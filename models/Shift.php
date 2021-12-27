<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shift".
 *
 * @property integer $id
 * @property string $nama_shift
 * @property string $senin
 * @property string $selasa
 * @property string $rabu
 * @property string $kamis
 * @property string $jumat
 * @property string $sabtu
 * @property string $minggu
 */
class Shift extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shift';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_shift', 'hari1', 'hari2', 'hari3', 'hari4', 'hari5'], 'required'],
            [['nama_shift'], 'string'],
            [['hari1', 'hari2', 'hari3', 'hari4', 'hari5', 'hari6', 'hari0'], 'string', 'max' => 12],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_shift' => 'Nama Shift',
            'hari1' => 'Senin',
            'hari2' => 'Selasa',
            'hari3' => 'Rabu',
            'hari4' => 'Kamis',
            'hari5' => 'Jumat',
            'hari6' => 'Sabtu',
            'hari0' => 'Minggu',
        ];
    }
}
