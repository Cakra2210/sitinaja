<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "seksi".
 *
 * @property integer $id
 * @property string $seksi
 * @property string $kode
 *
 * @property Jabatan[] $jabatans
 * @property Tugas[] $tugas
 */
class Seksi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'seksi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['seksi'], 'required'],
            [['seksi'], 'string'],
            [['kode'], 'string', 'max' => 5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'seksi' => 'Seksi',
            'kode' => 'Kode',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJabatans()
    {
        return $this->hasMany(Jabatan::className(), ['kode_seksi' => 'kode']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTugas()
    {
        return $this->hasMany(Tugas::className(), ['assignee' => 'id']);
    }
}
