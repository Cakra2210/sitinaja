<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Organik;

/**
 * OrganikSearch represents the model behind the search form of `app\models\Organik`.
 */
class OrganikSearch extends Organik
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'nama', 'nip', 'id_jabatan', 'pangkat', 'golongan', 'tempat', 'tgllahir', 'agama', 'alamat', 'tlp', 'email', 'pddk', 'bank', 'kawin', 'tmtmasuk'], 'integer'],
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
        $query = Organik::find();

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
            'status' => $this->status,
            'nama' => $this->nama,
            'nip' => $this->nip,
            'jabatan' => $this->id_jabatan,
            'pangkat' => $this->pangkat,
            'golongan' => $this->golongan,
            'tempat' => $this->tempat,
            'tgllahir' => $this->tgllahir,
            'agama' => $this->agama,
            'alamat' => $this->alamat,
            'nohp' => $this->tlp,
            'email' => $this->email,
            'pddk' => $this->pddk,
            'bank' => $this->bank,
            'kawin' => $this->kawin,
            'tmt' => $this->tmtmasuk,
        ]);

        return $dataProvider;
    }
}
