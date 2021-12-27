<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Pok;

/**
 * HolidaySearch represents the model behind the search form about `app\models\Holiday`.
 */
class PokSearch extends Pok
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['output', 'keg'], 'safe'],
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
        $query = Program::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['kode'=>SORT_DESC]]
        ]);

        $dataProvider->sort->attributes['kode'] = [
         'asc' => ['kode' => SORT_ASC],
         'desc' => ['kode' => SORT_DESC],
         ];
         $dataProvider->sort->attributes['uraian'] = [
          'asc' => ['uraian' => SORT_ASC],
          'desc' => ['uraian' => SORT_DESC],
      ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'output' => $this->output,
        ]);

        $query->andFilterWhere(['like', 'keg', $this->keg]);

        return $dataProvider;
    }
}
