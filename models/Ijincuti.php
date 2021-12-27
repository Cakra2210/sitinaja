<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ijincuti".
 *
 * @property integer $id
 * @property integer $id_pegawai
 * @property integer $iscuti
 * @property integer $keperluan
 * @property string $alamat
 * @property string $date_start
 * @property string $date_end
 * @property string $tanggal_surat
 *
 * @property Pegawai $idPegawai
 */
class Ijincuti extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ijincuti';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pegawai', 'iscuti', 'alamat', 'date_start', 'date_end', 'tanggal_surat'], 'required'],
            [['id_pegawai', 'iscuti'], 'integer'],
            [['alamat','keperluan'], 'string'],            
            [['id_pegawai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_pegawai' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_pegawai' => 'Id Pegawai',
            'iscuti' => 'Iscuti',
            'keperluan' => 'Keperluan',
            'alamat' => 'Tujuan',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'tanggal_surat' => 'Tanggal Surat',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'id_pegawai']);
    }
}
