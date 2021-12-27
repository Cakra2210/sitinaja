<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hspk".
 *
 * @property int $id
 * @property string $seksi
 * @property int $kode
 * @property string $kegiatan
 * @property string $jabatan
 * @property string $satuan
 * @property string $organik
 * @property string $non
 */
class Hspk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hspk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['seksi', 'kode', 'kegiatan', 'jabatan', 'satuan', 'organik', 'non'], 'required'],
            [['seksi', 'kegiatan', 'jabatan', 'satuan', 'organik', 'non'], 'string'],
            [['kode'], 'integer'],
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
            'kode' => 'Kode',
            'kegiatan' => 'Kegiatan',
            'jabatan' => 'Jabatan',
            'satuan' => 'Satuan',
            'organik' => 'Organik',
            'non' => 'Non',
        ];
    }
    public function getIdAssignee()
    {
        return $this->hasOne(Seksi::className(), ['id' => 'seksi']);
    }
    
    
}
