<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "organik".
 *
 * @property int $id
 * @property int $status
 * @property int $nama
 * @property int $nip
 * @property int $jabatan
 * @property int $pangkat
 * @property int $golongan
 * @property int $tempat
 * @property int $tgllahir
 * @property int $agama
 * @property int $alamat
 * @property int $nohp
 * @property int $email
 * @property int $pddk
 * @property int $bank
 * @property int $kawin
 * @property int $tmt
 */
class Organik extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organik';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'nama', 'nip','niplama', 'id_jabatan', 'pangkat', 'golongan', 'tempat', 'tgllahir', 'agama', 'alamat', 'tlp', 'email', 'pddk', 'bank', 'kawin', 'tmtmasuk'], 'required'],
            [['nama','foto','id_jabatan', 'pangkat', 'golongan','pddk','alamat', 'email','tmtmasuk'], 'string'],
            [['status', 'nip', 'agama', 'tlp', 'bank', 'kawin'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'nama' => 'Nama',
            'niplama' => 'Nip',
            'jabatan' => 'Jabatan',
            'pangkat' => 'Pangkat',
            'golongan' => 'Golongan',
            'tempat' => 'Tempat',
            'tgllahir' => 'Tgllahir',
            'agama' => 'Agama',
            'alamat' => 'Alamat',
            'tlp' => 'Nohp',
            'email' => 'Email',
            'pddk' => 'Pddk',
            'bank' => 'Bank',
            'kawin' => 'Kawin',
            'tmtmasuk' => 'Tmt',
        ];
    }
    public function getTugas()
    {
        return $this->hasMany(Tugas::className(), ['id_pegawai' => 'id']);
    }

    public function getIdJabatan()
      {
          return $this->hasOne(Jabatan::className(), ['id_jabatan' => 'id_jabatan']);
      }

      public function getIjincutis()
   {
       return $this->hasMany(Ijincuti::className(), ['id_pegawai' => 'id']);
   }

   /**
    * @return \yii\db\ActiveQuery
    */
   public function getMemos()
   {
       return $this->hasMany(Memo::className(), ['id_pegawai' => 'id']);
   }
}
