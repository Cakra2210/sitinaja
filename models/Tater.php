<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tater".
 *
 * @property int $id
 * @property string $no
 * @property string $jenis
 * @property string $pemberi
 * @property string $penerima
 * @property string $tgl
 *
 * @property Tateritem[] $tateritems
 */
class Tater extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tater';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jenis', 'tgl'], 'required'],
            [['jenis','penerima','pemberi'], 'string'],
            [['tgl'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no' => 'No',
            'jenis' => 'Jenis',
            'pemberi' => 'Pemberi',
            'penerima' => 'Penerima',
            'tgl' => 'Tgl',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'penerima']);

    }
    public function getTateritems()
    {
        return $this->hasMany(Tateritem::className(), ['person_id' => 'id']);
    }
    public function getPenerima()
    {
        if($this->penerima==29){
            return 'Nurjaona';
        }elseif ($this->penerima==27) {
            return 'Baharudding';
        }else{
            return 'Unknown';
        }

    }
}
