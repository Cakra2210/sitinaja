<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "room".
 *
 * @property integer $id
 * @property integer $house_id
 * @property string $kode
 * @property string $uraian
 *
 * @property House $house
 */
class Room extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'room';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['house_id'], 'integer'],
            [['kode', 'uraian', 'assignee'], 'required'],
            [['kode', 'uraian'], 'string'],
            [['house_id'], 'exist', 'skipOnError' => true, 'targetClass' => House::className(), 'targetAttribute' => ['house_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'house_id' => 'House ID',
            'kode' => 'Kode',
            'uraian' => 'Uraian',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHouse()
    {
        return $this->hasOne(House::className(), ['id' => 'house_id']);
    }
    public function getTugas()
    {
        return $this->hasMany(Room::className(), ['id' => 'id']);
    }
    public function getIdAssignee()
    {
        return $this->hasOne(Seksi::className(), ['id' => 'assignee']);
    }
    public function getId()
    {
      return $this->getPrimaryKey();
    }
}
