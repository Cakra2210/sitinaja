<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pok21;

/**
 * Pok21Search represents the model behind the search form of `app\models\Pok21`.
 */
class Pok21Search extends Pok21
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['kode_prog', 'prog', 'kode_keg', 'keg', 'kode_output', 'kode_so', 'so', 'output', 'kode_komponen', 'komponen', 'jml_ok', 'assignee'], 'safe'],
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
        $query = Pok21::find();

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
        ]);

        $query->andFilterWhere(['like', 'kode_prog', $this->kode_prog])
            ->andFilterWhere(['like', 'prog', $this->prog])
            ->andFilterWhere(['like', 'kode_keg', $this->kode_keg])
            ->andFilterWhere(['like', 'keg', $this->keg])
            ->andFilterWhere(['like', 'kode_output', $this->kode_output])
            ->andFilterWhere(['like', 'kode_so', $this->kode_so])
            ->andFilterWhere(['like', 'so', $this->so])
            ->andFilterWhere(['like', 'output', $this->output])
            ->andFilterWhere(['like', 'kode_komponen', $this->kode_komponen])
            ->andFilterWhere(['like', 'komponen', $this->komponen])
            ->andFilterWhere(['like', 'jml_ok', $this->jml_ok])
            ->andFilterWhere(['like', 'assignee', $this->assignee]);

        return $dataProvider;
    }
}
