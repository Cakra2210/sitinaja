<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "holiday".
 *
 * @property integer $id
 * @property string $tanggal
 * @property string $keterangan
 */
class Tugasmitra extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tugasmitra';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'suratdasar', 'program', 'nosurat', 'date_start', 'date_end', 'created_date', 'kegiatan', 'destinasi', 'assignee'], 'required'],
            [['nama', 'assignee'], 'integer'],
            [['suratdasar', 'program','nosurat', 'kegiatan', 'destinasi'], 'string'],
            [['date_start', 'date_end','created_date'], 'safe'],
            ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'suratdasar' => 'Surat Dasar',
            'program' => 'Program Kegiatan',
            'nosurat' => 'No Surat',
            'date_start' => 'Tanggal Mulai',
            'date_end' => 'Tanggal Selesai',
            'created_date'=> 'Create date',
            'kegiatan' => 'Kegiatan',
            'destinasi' => 'Destinasi',
            'assignee' => 'Assignee',
            
        ];
    }
   
    public function getIdAssignee()
    {
        return $this->hasOne(Seksi::className(), ['id' => 'assignee']);
    }
    
    public function getIdMitra()
    {
        return $this->hasOne(Mitra::className(), ['id' => 'nama']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getIdRoom()
    {
        return $this->hasOne(Kak::className(), ['id' => 'program']);
    }
    
    }
