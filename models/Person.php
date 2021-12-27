<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "person".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $kode
 * @property integer $uraian
 *
 * @property House[] $houses
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['kode', 'uraian',], 'required'],
            [['kode'], 'string'],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'kode' => 'Kode',
            'assignee' => 'POK Seksi',
            'uraian' => 'Uraian',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdAssignee()
    {
        return $this->hasOne(Seksi::className(), ['id' => 'assignee']);
    }
    public function getHouses()
    {
        return $this->hasMany(House::className(), ['id' => 'id']);
    }
}
