<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kolitem".
 *
 * @property int $id
 * @property int $kol_id
 * @property int $nama
 * @property int $jumlah
 * @property int $ket
 *
 * @property Taterkolektif $kol
 */
class Kolitem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kolitem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kol_id'], 'integer'],
            [['nama', 'jumlah', 'ket'], 'required'],
            [['kol_id'], 'exist', 'skipOnError' => true, 'targetClass' => Taterkolektif::className(), 'targetAttribute' => ['kol_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kol_id' => 'Kol ID',
            'nama' => 'Nama',
            'jumlah' => 'Jumlah',
            'ket' => 'Ket',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKol()
    {
        return $this->hasOne(Taterkolektif::className(), ['id' => 'kol_id']);
    }
}
