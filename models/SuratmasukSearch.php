<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Suratmasuk;

/**
 * SuratmasukSearch represents the model behind the search form of `app\models\Suratmasuk`.
 */
class SuratmasukSearch extends Suratmasuk
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['instansi', 'nosurat', 'perihal', 'tglsurat', 'tglcatat', 'agenda', 'sifat', 'lampiran'], 'safe'],
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
        $query = Suratmasuk::find();

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
            'tglsurat' => $this->tglsurat,
            'tglcatat' => $this->tglcatat,
        ]);

        $query->andFilterWhere(['like', 'instansi', $this->instansi])
            ->andFilterWhere(['like', 'nosurat', $this->nosurat])
            ->andFilterWhere(['like', 'perihal', $this->perihal])
            ->andFilterWhere(['like', 'agenda', $this->agenda])
            ->andFilterWhere(['like', 'sifat', $this->sifat])
            ->andFilterWhere(['like', 'lampiran', $this->lampiran]);

        return $dataProvider;
    }
}
