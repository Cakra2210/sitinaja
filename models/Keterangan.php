<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "keterangan".
 *
 * @property integer $id
 * @property integer $no
 * @property integer $ket
 * @property integer $ttd
 * @property string $nama
 */
class Keterangan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'keterangan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['no', 'ket', 'hal', 'ttd', 'nama', 'tgl'], 'required'],
            [['nama','ttd'], 'integer'],
            [['nama', 'ttd','ket', 'hal', 'tgl'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'no' => 'No Surat',
            'ket' => 'Keterangan',
            'ttd' => 'Yang Memberi Keterangan',
            'nama' => 'Yang Diberi Keterangan',
            'tgl' => 'Tanggal',
        ];
    }
    public function getIdPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'nama']);
    }

}
