<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $satker
 * @property string $alamat
 * @property string $alamatlengkap
 * @property integer $transport
 * @property integer $uangharian
 * @property string $ppk
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'satker', 'alamat', 'alamatlengkap', 'transport', 'uangharian', 'nodipa', 'ppk','kodesatker','ip_mesinabsen','is_plh','email', 'web','kodepos','kppn', 'alamatkppn'], 'required'],
            [['id', 'transport','plh_kepala','is_plh'], 'integer'],
            [['satker', 'alamat', 'alamatlengkap','kabupaten','provinsi' ,'ppk','uangharian','hotel', 'nodipa','tgldipa','kodesatker', 'tahun','ip_mesinabsen','kodepos','telepon'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'satker' => 'Satker',
            'kodesatker'=>'Kode Satker',
            'alamat' => 'Alamat',
            'alamatlengkap' => 'Alamat Lengkap',
            'transport' => 'Transport',
            'uangharian' => 'Uang Harian',
            'nodipa' => 'Nomor DIPA',
            'ppk' => 'PPK',
            'kabupaten' => 'Kabupaten',
            'provinsi' => 'Provinsi',
            'ip_mesinabsen' => 'IP Mesin Absen',
            'plh_kepala' => 'Kepala Kantor',
            'is_plh'=> 'Apakah ada PLH Kepala',
            'tahun' => 'Tahun Anggaran',
            'tgldipa' => 'Tanggal DIPA'
        ];
    }
    public function getIdPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'ppk']);
    }
    public function getPlhkepala()
    {
      return $this->hasOne(Pegawai::className(),['id'=>'plh_kepala']);
    }
}
