<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kak;

/**
 * KakSearch represents the model behind the search form of `app\models\Kak`.
 */
class KakSearch extends Kak
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['seksi', 'kegiatan', 'id_keg', 'start', 'end', 'scan', 'create_date', 'ubah', 'create_by', 'ubah_by'], 'safe'],
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
        $query = Kak::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
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
            'start' => $this->start,
            'end' => $this->end,
            'create_date' => $this->create_date,
            'ubah' => $this->ubah,
        ]);

        $query->andFilterWhere(['like', 'seksi', $this->seksi])
            ->andFilterWhere(['like', 'kegiatan', $this->kegiatan])
            ->andFilterWhere(['like', 'uraian', $this->uraian])
            ->andFilterWhere(['like', 'scan', $this->scan])
            ->andFilterWhere(['like', 'create_by', $this->create_by])
            ->andFilterWhere(['like', 'ubah_by', $this->ubah_by]);

        return $dataProvider;
    }
}
