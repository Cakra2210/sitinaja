<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sk".
 *
 * @property int $id
 * @property string $nosk
 * @property string $jenis
 * @property string $tentang
 * @property string $hal
 * @property string $tglsk
 *
 * @property Skitem[] $skitems
 */
class Sk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nosk', 'jenis', 'tentang', 'hal', 'tglsk'], 'required'],
            [['nosk', 'jenis', 'tentang', 'hal'], 'string'],
            [['tglsk','namafile'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nosk' => 'Nosk',
            'jenis' => 'Jenis',
            'tentang' => 'Tentang',
            'hal' => 'Hal',
            'tglsk' => 'Tglsk',
            'namafile' => 'File'
        ];
    }

    /**
     * Gets query for [[Skitems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkitems()
    {
        return $this->hasMany(Skitem::className(), ['person_id' => 'id']);
    }
    public function getIdPegawai()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'id_pegawai']);
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
        return $this->hasOne(Room::className(), ['id' => 'program']);
    }
     public function getNip()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'nip']);
    }

}
