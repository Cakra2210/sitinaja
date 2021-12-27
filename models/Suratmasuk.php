<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "suratmasuk".
 *
 * @property int $id
 * @property string|null $instansi
 * @property string $nosurat
 * @property string $perihal
 * @property string $tglsurat
 * @property string $tglcatat
 * @property string $agenda
 * @property string $sifat
 * @property string $lampiran
 */
class Suratmasuk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'suratmasuk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['instansi', 'nosurat', 'perihal', 'agenda', 'sifat', 'lampiran'], 'string'],
            [['nosurat', 'perihal', 'tglsurat', 'tglcatat', 'agenda', 'sifat', 'lampiran'], 'required'],
            [['tglsurat', 'tglcatat','scan'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'instansi' => 'Instansi',
            'nosurat' => 'Nosurat',
            'perihal' => 'Perihal',
            'tglsurat' => 'Tglsurat',
            'tglcatat' => 'Tglcatat',
            'agenda' => 'Agenda',
            'sifat' => 'Sifat',
            'lampiran' => 'Lampiran',
        ];
    }
}
