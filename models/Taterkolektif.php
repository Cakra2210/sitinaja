<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "taterkolektif".
 *
 * @property int $id
 * @property int $tgl
 * @property int $jenis
 * @property int $pemberi
 *
 * @property Kolitem[] $kolitems
 */
class Taterkolektif extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'taterkolektif';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tgl', 'jenis', 'pemberi', 'jenis'], 'required'],
            [['no'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tgl' => 'Tgl',
            'jenis' => 'Jenis',
            'pemberi' => 'Pemberi',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKolitems()
    {
        return $this->hasMany(Kolitem::className(), ['kol_id' => 'id']);
    }
    public function getIdPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'pemberi']);

    }
    public function getTateritems()
    {
        return $this->hasMany(Tateritem::className(), ['person_id' => 'id']);
    }
}
