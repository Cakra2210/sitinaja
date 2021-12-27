<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pengantar".
 *
 * @property int $id
 * @property string $no
 * @property string $kepada
 * @property string $di
 * @property string $pengirim
 * @property string $tgl
 *
 * @property Pengantaritem[] $pengantaritems
 */
class Pengantar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengantar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no', 'kepada', 'di', 'pengirim', 'tgl'], 'required'],
            [['no', 'kepada', 'di', 'pengirim'], 'string'],
            [['tgl','cq'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no' => 'No Surat',
            'kepada' => 'Kepada',
            'di' => 'Tujuan',
            'pengirim' => 'Pengirim',
            'tgl' => 'Tgl Surat Pengantar',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'pengirim']);

    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPengantaritems()
    {
        return $this->hasMany(Pengantaritem::className(), ['person_id' => 'id']);
    }
}
