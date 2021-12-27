<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pengantaritem".
 *
 * @property int $id
 * @property int $person_id
 * @property string $brg
 * @property string $banyak
 * @property string $ket
 *
 * @property Pengantar $person
 */
class Pengantaritem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pengantaritem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['person_id'], 'integer'],
            [['brg', 'banyak', 'ket'], 'required'],
            [['brg', 'ket'], 'string', 'max' => 225],
            [['banyak'], 'string', 'max' => 255],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pengantar::className(), 'targetAttribute' => ['person_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'person_id' => 'Person ID',
            'brg' => 'Brg',
            'banyak' => 'Banyak',
            'ket' => 'Ket',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Pengantar::className(), ['id' => 'person_id']);
    }
}
