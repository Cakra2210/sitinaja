<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Memo;

/**
 * MemoSearch represents the model behind the search form about `app\models\Memo`.
 */
class MemoSearch extends Memo
{
    public $pegawai;
    public $seksi;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_pegawai'], 'integer'],
            [['keperluan', 'jam_keluar', 'jam_pulang'], 'safe'],
            [['pegawai','seksi'],'safe'],            
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
        $query = Memo::find();

        // add conditions that should always apply here
        $query->joinWith(['idPegawai','idSeksi']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);
        $dataProvider->sort->attributes['pegawai'] = [
         'asc' => ['nama' => SORT_ASC],
         'desc' => ['nama' => SORT_DESC],
         ];
         $dataProvider->sort->attributes['seksi'] = [
          'asc' => ['nama' => SORT_ASC],
          'desc' => ['nama' => SORT_DESC],
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
            'id_pegawai' => $this->id_pegawai,
            'jam_keluar' => $this->jam_keluar,
            'jam_pulang' => $this->jam_pulang,
        ]);

        $query->andFilterWhere(['like', 'keperluan', $this->keperluan])
              ->andFilterWhere(['like', 'nama', $this->pegawai])
              ->andFilterWhere(['like', 'seksi', $this->seksi]);

        return $dataProvider;
    }
}
