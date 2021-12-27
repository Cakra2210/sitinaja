<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "house".
 *
 * @property integer $id
 * @property integer $person_id
 * @property integer $kode
 * @property string $uraian
 *
 * @property Person $person
 * @property Room[] $rooms
 */
class House extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'house';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['person_id', 'kode'], 'integer'],
            [['kode', 'uraian'], 'required'],
            [['uraian'], 'string', 'max' => 255],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['person_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'person_id' => 'Person ID',
            'kode' => 'Kode',
            'uraian' => 'Uraian',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRooms()
    {
        return $this->hasMany(Room::className(), ['house_id' => 'id']);
    }
}
