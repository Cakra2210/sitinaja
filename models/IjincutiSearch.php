<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ijincuti;

/**
 * IjincutiSearch represents the model behind the search form about `app\models\Ijincuti`.
 */
class IjincutiSearch extends Ijincuti
{
  public $pegawai;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_pegawai', 'iscuti', 'keperluan'], 'integer'],
            [['alamat', 'date_start', 'date_end', 'tanggal_surat'], 'safe'],
            [['pegawai'],'safe'],
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
        $query = Ijincuti::find();

        // add conditions that should always apply here
        $query->joinWith(['idPegawai']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['id'=>SORT_DESC]]
        ]);
        $dataProvider->sort->attributes['pegawai'] = [
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
            'iscuti' => $this->iscuti,
            'keperluan' => $this->keperluan,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'tanggal_surat' => $this->tanggal_surat,
        ]);

        $query->andFilterWhere(['like', 'alamat', $this->alamat])
              ->andFilterWhere(['like','nama',$this->pegawai]);

        return $dataProvider;
    }
}
