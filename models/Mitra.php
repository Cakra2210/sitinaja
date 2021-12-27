<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mitra".
 *
 * @property int $id
 * @property string $nomit
 * @property string $nama
 * @property string $bank
 * @property string $norek
 * @property string $npwp
 * @property int $nonpwp
 */
class Mitra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mitra';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomit', 'nama', 'bank', 'norek'], 'required'],
            [['nomit', 'nama', 'alamat','tempat','tgllahir','pekerjaan','bank', 'norek', 'npwp','nonpwp','foto'], 'string'],
            [['norek','pddk'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomit' => 'Nomit',
            'nama' => 'Nama',
            'bank' => 'Bank',
            'norek' => 'Norek',
            'npwp' => 'Npwp',
            'nonpwp' => 'Nonpwp',
        ];
    }
    public function getTugas()
    {
        return $this->hasMany(Mitra::className(), ['id_mitra' => 'id']);
    }
    public function getId()
    {
      return $this->getPrimaryKey();
    }
}
