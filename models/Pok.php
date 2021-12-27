<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pok".
 *
 * @property int $id
 * @property string $prog
 * @property string $kode_keg
 * @property string $keg
 * @property string $kode_komponen
 * @property string $komponen
 * @property string $kode_output
 * @property string $output
 * @property string $jml_ok
 * @property string $assignee
 */
class Pok extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pok';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prog', 'keg', 'kode_komponen', 'komponen', 'kode_output', 'output', 'jml_ok', 'assignee'], 'required'],
            [['prog', 'kode_keg', 'keg', 'kode_komponen', 'komponen', 'kode_output', 'output', 'jml_ok', 'assignee'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prog' => 'Prog',
            'kode_keg' => 'Kode Keg',
            'keg' => 'Keg',
            'kode_komponen' => 'Kode Komponen',
            'komponen' => 'Komponen',
            'kode_output' => 'Kode Output',
            'output' => 'Output',
            'jml_ok' => 'Jml Ok',
            'assignee' => 'Assignee',
        ];
    }
}
