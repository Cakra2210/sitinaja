<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pok21".
 *
 * @property int $id
 * @property string $kode_prog
 * @property string $prog
 * @property string $kode_keg
 * @property string $keg
 * @property string $kode_output
 * @property string $kode_so
 * @property string $so
 * @property string $output
 * @property string $kode_komponen
 * @property string $komponen
 * @property string $jml_ok
 * @property string $assignee
 */
class Pok21 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pok21';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kode_prog', 'prog', 'kode_keg', 'keg', 'kode_output', 'kode_so', 'so', 'output', 'kode_komponen', 'komponen', 'jml_ok', 'assignee'], 'required'],
            [['kode_prog', 'prog', 'kode_keg', 'keg', 'kode_output', 'kode_so', 'so', 'output', 'kode_komponen', 'komponen', 'jml_ok', 'assignee'], 'string'],
            [['pok'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kode_prog' => 'Kode Prog',
            'prog' => 'Prog',
            'kode_keg' => 'Kode Keg',
            'keg' => 'Keg',
            'kode_output' => 'Kode Output',
            'kode_so' => 'Kode So',
            'so' => 'So',
            'output' => 'Output',
            'kode_komponen' => 'Kode Komponen',
            'komponen' => 'Komponen',
            'jml_ok' => 'Jumlah Pagu',
            'assignee' => 'Assignee',
        ];
    }
    public function getIdSeksi()
    {
        return $this->hasOne(Seksi::className(), ['id' => 'assignee']);
    }
}
