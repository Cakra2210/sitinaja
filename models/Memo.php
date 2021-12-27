<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "memo".
 *
 * @property integer $id
 * @property integer $id_pegawai
 * @property string $keperluan
 * @property integer $id_seksi
 * @property string $jam_keluar
 * @property string $jam_pulang
 *
 * @property Pegawai $idPegawai
 * @property Seksi $idSeksi
 */
class Memo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'memo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pegawai', 'keperluan', 'id_seksi'], 'required'],
            [['id_pegawai', 'id_seksi'], 'integer'],
            [['keperluan'], 'string'],
            [['jam_keluar', 'jam_pulang'], 'safe'],
            [['id_pegawai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_pegawai' => 'id']],
            [['id_seksi'], 'exist', 'skipOnError' => true, 'targetClass' => Seksi::className(), 'targetAttribute' => ['id_seksi' => 'id']],
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
            'keperluan' => 'Keperluan',
            'id_seksi' => 'Id Seksi',
            'jam_keluar' => 'Jam Keluar',
            'jam_pulang' => 'Jam Pulang',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'id_pegawai']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdSeksi()
    {
        return $this->hasOne(Seksi::className(), ['id' => 'id_seksi']);
    }
}
