<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Hspk;

/**
 * HspkSearch represents the model behind the search form of `app\models\Hspk`.
 */
class HspkSearch extends Hspk
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kode'], 'integer'],
            [['seksi', 'kegiatan', 'jabatan', 'satuan', 'organik', 'non'], 'safe'],
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
        $query = Hspk::find();

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
            'kode' => $this->kode,
        ]);

        $query->andFilterWhere(['like', 'seksi', $this->seksi])
            ->andFilterWhere(['like', 'kegiatan', $this->kegiatan])
            ->andFilterWhere(['like', 'jabatan', $this->jabatan])
            ->andFilterWhere(['like', 'satuan', $this->satuan])
            ->andFilterWhere(['like', 'organik', $this->organik])
            ->andFilterWhere(['like', 'non', $this->non]);

        return $dataProvider;
    }
}
