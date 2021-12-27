<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kak".
 *
 * @property int $id
 * @property string $seksi
 * @property string $kegiatan
 * @property string $id_keg
 * @property string $start
 * @property string $end
 * @property string $scan
 * @property string $create_date
 * @property string $ubah
 * @property string $create_by
 * @property string $ubah_by
 *
 * @property Kakitem[] $kakitems
 */
class Kak extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kak';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['seksi', 'kegiatan', 'uraian', 'start', 'end','tglsk'], 'required'],
            [['start', 'end', 'create_date', 'thn','ubah','nosk','nosurtu','tglbayar','harsat','spj','scan','tempat','tglbuat','pembuat'], 'safe'],
            [['seksi'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'seksi' => 'Seksi',
            'kegiatan' => 'Kegiatan',
            'id_keg' => 'Id Keg',
            'start' => 'Start',
            'end' => 'End',
            'scan' => 'Scan',
            'create_date' => 'Create Date',
            'ubah' => 'Ubah',
            'create_by' => 'Create By',
            'ubah_by' => 'Ubah By',
            'nosk' => 'Nomor SK',
            'thn' => 'Tahun',
            'tglbayar' => 'Tgl Pembayaran',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKakitems()
    {
        return $this->hasMany(Kakitem::className(), ['kak_id' => 'id']);
    }
    public function getIdAssignee()
    {
        return $this->hasOne(Seksi::className(), ['id' => 'seksi']);
    }
    public function getIdKegiatan()
    {
        return $this->hasOne(Pok21::className(), ['id' => 'kegiatan']);
    }
    public function getIdPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'create_by']);
    }
    public function getIdNama()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'nama']);
    }
    public function getIdPeg()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'ubah_by']);
    }
    public function getIdTahun()
    {
        return $this->hasOne(Config::className(), ['id' => 'create_tahun']);
    }

}
