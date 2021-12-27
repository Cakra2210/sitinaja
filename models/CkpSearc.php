<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Ckp;

/**
 * CkpSearc represents the model behind the search form about `app\models\Ckp`.
 */
class CkpSearc extends Ckp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_ckp', 'id_pegawai', 'id_tugas', 'target', 'realisasi'], 'integer'],
            [['date', 'satuan', 'kd_butir', 'angka_kredit', 'keterangan'], 'safe'],
            [['kualitas'], 'number'],
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
        $query = Ckp::find();

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
            'id_ckp' => $this->id_ckp,
            'date' => $this->date,
            'id_pegawai' => $this->id_pegawai,
            'id_tugas' => $this->id_tugas,
            'target' => $this->target,
            'realisasi' => $this->realisasi,
            'kualitas' => $this->kualitas,
        ]);

        $query->andFilterWhere(['like', 'satuan', $this->satuan])
            ->andFilterWhere(['like', 'kd_butir', $this->kd_butir])
            ->andFilterWhere(['like', 'angka_kredit', $this->angka_kredit])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan])
            ->orderBy('id_ckp DESC');

        return $dataProvider;
    }
}
