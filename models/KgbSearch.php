<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kgb;

/**
 * KgbSearch represents the model behind the search form of `app\models\Kgb`.
 */
class KgbSearch extends Kgb
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nomor', 'nama', 'gapoklama', 'pejabat', 'tgllama', 'nolama', 'gapokbaru', 'kerjabaru'], 'integer'],
            [['tmtlama', 'tmtbaru', 'tglbuat'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Kgb::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'nomor' => $this->nomor,
            'nama' => $this->nama,
            'gapoklama' => $this->gapoklama,
            'pejabat' => $this->pejabat,
            'tgllama' => $this->tgllama,
            'nolama' => $this->nolama,
            'tmtlama' => $this->tmtlama,
            'gapokbaru' => $this->gapokbaru,
            'kerjabaru' => $this->kerjabaru,
            'tmtbaru' => $this->tmtbaru,
            'tglbuat' => $this->tglbuat,
        ]);

        return $dataProvider;
    }
}
