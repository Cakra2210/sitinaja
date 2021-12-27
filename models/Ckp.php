<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ckp".
 *
 * @property integer $id_ckp
 * @property integer $date
 * @property integer $id_pegawai
 * @property integer $id_tugas
 * @property string $satuan
 * @property integer $target
 * @property integer $realisasi
 * @property string $kualitas
 * @property string $kd_butir
 * @property string $angka_kredit
 * @property string $keterangan
 *
 * @property Tugas $idTugas
 * @property Pegawai $idPegawai
 */
class Ckp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ckp';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date', 'id_pegawai', 'id_tugas', 'target', 'realisasi'], 'integer'],
            [['id_pegawai'], 'required'],
            [['satuan', 'keterangan'], 'string'],
            [['kualitas'], 'number'],
            [['kd_butir', 'angka_kredit'], 'string', 'max' => 5],
            [['id_tugas'], 'exist', 'skipOnError' => true, 'targetClass' => Tugas::className(), 'targetAttribute' => ['id_tugas' => 'id']],
            [['id_pegawai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_pegawai' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_ckp' => 'Id Ckp',
            'date' => 'Date',
            'id_pegawai' => 'Id Pegawai',
            'id_tugas' => 'Id Tugas',
            'satuan' => 'Satuan',
            'target' => 'Target',
            'realisasi' => 'Realisasi',
            'kualitas' => 'Kualitas',
            'kd_butir' => 'Kd Butir',
            'angka_kredit' => 'Angka Kredit',
            'keterangan' => 'Keterangan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdTugas()
    {
        return $this->hasOne(Tugas::className(), ['id' => 'id_tugas']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'id_pegawai']);
    }
}
