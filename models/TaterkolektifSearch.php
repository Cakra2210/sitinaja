<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Taterkolektif;

/**
 * TaterkolektifSearch represents the model behind the search form of `app\models\Taterkolektif`.
 */
class TaterkolektifSearch extends Taterkolektif
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'no'], 'integer'],
            [['tgl', 'jenis', 'pemberi'], 'safe'],
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
        $query = Taterkolektif::find();

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
            'no' => $this->no,
            'tgl' => $this->tgl,
        ]);

        $query->andFilterWhere(['like', 'jenis', $this->jenis])
            ->andFilterWhere(['like', 'pemberi', $this->pemberi]);

        return $dataProvider;
    }
}
