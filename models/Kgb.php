<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kgb".
 *
 * @property int $id
 * @property int $nomor
 * @property int $nama
 * @property int $gapoklama
 * @property int $pejabat
 * @property int $tgllama
 * @property int $nolama
 * @property string $tmtlama
 * @property int $gapokbaru
 * @property int $kerjabaru
 * @property string $tmtbaru
 * @property string $tglbuat
 */
class Kgb extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kgb';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomor', 'nama', 'gapoklama', 'pejabat', 'tgllama', 'nolama', 'tmtlama', 'gapokbaru', 'kerjabaru', 'tmtbaru', 'tglbuat'], 'required'],
            [['nomor', 'nama', 'nolama', 'kerjabaru'], 'integer'],
            [['tmtlama', 'pejabat','tmtbaru', 'tglbuat'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomor' => 'Nomor',
            'nama' => 'Nama',
            'gapoklama' => 'Gapoklama',
            'pejabat' => 'Pejabat',
            'tgllama' => 'Tgllama',
            'nolama' => 'Nolama',
            'tmtlama' => 'Tmtlama',
            'gapokbaru' => 'Gapokbaru',
            'kerjabaru' => 'Kerjabaru',
            'tmtbaru' => 'Tmtbaru',
            'tglbuat' => 'Tglbuat',
        ];
    }
}
