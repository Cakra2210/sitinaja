<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Shift;

/**
 * ShiftSearch represents the model behind the search form about `app\models\Shift`.
 */
class ShiftSearch extends Shift
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nama_shift', 'hari1', 'hari2', 'hari3', 'hari4', 'hari5', 'hari6', 'hari0'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Shift::find();

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

        $query->andFilterWhere(['like', 'nama_shift', $this->nama_shift])
            ->andFilterWhere(['like', 'hari1', $this->hari1])
            ->andFilterWhere(['like', 'hari2', $this->hari2])
            ->andFilterWhere(['like', 'hari3', $this->hari3])
            ->andFilterWhere(['like', 'hari4', $this->hari4])
            ->andFilterWhere(['like', 'hari5', $this->hari5])
            ->andFilterWhere(['like', 'hari6', $this->hari6])
            ->andFilterWhere(['like', 'hari0', $this->hari0]);

        return $dataProvider;
    }
}
