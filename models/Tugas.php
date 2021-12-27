<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tugas".
 *
 * @property integer $id
 * @property integer $id_pegawai
 * @property string $suratdasar
 * @property string $nosurat
 * @property string $date_start
 * @property string $date_end
 * @property string $kegiatan
 * @property string $destinasi
 * @property integer $assignee
 *
 * @property Pegawai $idPegawai
 * @property Seksi $assignee
 */
class Tugas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tugas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pegawai', 'suratdasar', 'program', 'nosurat', 'date_start', 'date_end', 'kegiatan', 'destinasi', 'assignee','sppd','is_luar_kota'], 'required'],
            [['id_pegawai', 'assignee','sppd','is_luar_kota','blok_absen','ckp','kend', 'cair'], 'integer'],
            [['suratdasar', 'program','nosurat', 'kegiatan', 'destinasi'], 'string'],
            [['date_start', 'date_end','created_date','cair','scan'], 'safe'],
            [['id_pegawai'], 'exist', 'skipOnError' => true, 'targetClass' => Pegawai::className(), 'targetAttribute' => ['id_pegawai' => 'id']],
            [['assignee'], 'exist', 'skipOnError' => true, 'targetClass' => Seksi::className(), 'targetAttribute' => ['assignee' => 'id']],
            [['cair','scan'], 'default', 'value' => '2'],
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
            'suratdasar' => 'Surat Dasar',
            'program' => 'Program Kegiatan',
            'nosurat' => 'No Surat',
            'date_start' => 'Tanggal Mulai',
            'date_end' => 'Tanggal Selesai',
            'created_date'=> 'Create date',
            'kegiatan' => 'Kegiatan',
            'destinasi' => 'Destinasi',
            'assignee' => 'Assignee',
            'sppd' => 'Sppd',
            'is_luar_kota'=>'Luar Kota',
            'blok_absen'=>'Blok Absen',
            'ckp'=>'ckp',
            'kend'=>'Kendaraan',
            'cair'=>'cair',
            'Scan'=>'Upload'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'id_pegawai']);
    }

    public function getIdJabatan()
    {
        return $this->hasOne(Jabatan::className(), ['id' => 'id_jabatan']);
    }

    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAssignee()
    {
        return $this->hasOne(Seksi::className(), ['id' => 'assignee']);
    }
    public function getIdRoom()
    {
        return $this->hasOne(Pok21::className(), ['id' => 'program']);
    }
    public function getCair()
    {
        {
        if($this->cair=='1'){
            return 'Sudah';
        
        }else{
            return 'Belum';
            }
        }
    }
    public function getKumpul()
    {
        {
        if($this->scan=='2'){
            return 'Belum';

        }elseif ($this->scan=='0'){
            return 'Belum';

        }elseif ($this->scan=='1'){
            return 'Belum';
        
        }else{
            return 'Sudah Upload';
        }
    }
    }

}

