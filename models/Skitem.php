<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "house".
 *
 * @property integer $id
 * @property integer $person_id
 * @property string $description
 *
 * @property Person $person
 * @property Room[] $rooms
 */
class Skitem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'skitem';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['person_id'], 'integer'],
            [['sebagai','nama'], 'required'],
            [['keterangan'], 'string', 'max' => 255],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sk::className(), 'targetAttribute' => ['person_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'person_id' => 'Person ID',
            'keterangan' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getSk()
    {
        return $this->hasMany(Sk::className(), ['id' => 'person_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRooms()
    {
        return $this->hasMany(Room1::className(), ['house_id' => 'id']);
    }
    public function getIdJabatan()
    {
        {
        if($this->nama=='Mukrabin S.E, M.M'){
            return 'Kapala';
        }elseif ($this->nama=='Andi Cakra Atmajaya S.Pt') {
            return 'Kasubag Umum';
        }elseif ($this->nama=='Rahmi Hijriati Ashri, S.Si,M.Si') {
            return 'Kepala Seksi IPDS';
        }elseif ($this->nama=='Laila Mustika Daeng Karra A.md') {
            return 'Staf Tata Usaha';
        }elseif ($this->nama=='Yudianto') {
            return 'KSK Tamalatea';
        }elseif ($this->nama=='Oktavanyta Ariani S.Tr.Stat.') {
            return 'Staf Seksi IPDS';
        }elseif ($this->nama=='Mardiah S.Si') {
            return 'Staf Sub Bagian Tata Usaha';
        }elseif ($this->nama=='Baharudding S.E') {
            return 'Kepala Seksi Statistik Produksi';
        }elseif ($this->nama=='Kasmawati Saleng S.E') {
            return 'Kepala Seksi Statistik Distribusi';
        }elseif ($this->nama=='Nurjaona S.E') {
            return 'Kepala Seksi Statistik Sosial';
        }elseif ($this->nama=='ST Syamriani S, S.Kom') {
            return 'Kepala Seksi Neraca Wilayah dan Analisis Statistik';
        }elseif ($this->nama=='Ruslan') {
            return 'Staf Sub Bagian Tata Usaha';
        }elseif ($this->nama=='Saharuddin') {
            return 'KSK Tamalatea';
        }elseif ($this->nama=='Novi Fahdilla S.Tr.Stat') {
            return 'Staf Seksi Statistik Sosial';
        }elseif ($this->nama=='Rizki Nur Eka Pratiwi S.Tr.Stat') {
            return 'Staf Seksi Statistik Produksi';
        }elseif ($this->nama=='Sabiludyn Raka Pradikta S.ST') {
            return 'Staf Seksi Statistik Sosial';
        }elseif ($this->nama=='Ikhsan Margo Pangestu S.Tr.Stat') {
            return 'Staf Seksi Statistik Distribusi';
        }elseif ($this->nama=='Isna Muflichatul Fadhilah, S.ST') {
            return 'Staf Seksi Neraca Wilayah dan Analisis Statistik';
        }elseif ($this->nama=='Mardiah S.Si') {
            return 'Staf Sub Bagian Tata Usaha';
        }elseif ($this->nama=='Sudarnati M') {
            return 'KSK Bangkala Barat';
        }elseif ($this->nama=='Abd Halim Hakim') {
            return 'KSK Kelara';
        }elseif ($this->nama=='Ammas Pualam Islamy S.Tr.Stat') {
            return 'Staf Seksi Statistik Sosial';
        }else{
            return 'Mitra';
        }

    }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    
    public function getNip()
    {
        {
        if($this->nama=='Mukrabin S.E, M.M'){
            return '196306261992031002';
        }elseif ($this->nama=='Andi Cakra Atmajaya S.Pt') {
            return '197810222006041003';
        }elseif ($this->nama=='Rahmi Hijriati Ashri, S.Si,M.Si') {
            return '197706112006042001';
        }elseif ($this->nama=='Laila Mustika Daeng Karra A.md') {
            return '198301192011012007';
        }elseif ($this->nama=='Yudianto') {
            return '198407052012121001';
        }elseif ($this->nama=='Oktavanyta Ariani S.Tr.Stat.') {
            return '199610272019012001';
        }elseif ($this->nama=='Mardiah S.Si') {
            return '199406242019032001';
        }elseif ($this->nama=='Baharudding S.E') {
            return '196703151989021001';
        }elseif ($this->nama=='Kasmawati Saleng S.E') {
            return '197207201994012001';
        }elseif ($this->nama=='Nurjaona S.E') {
            return '196505171986032004';
        }elseif ($this->nama=='ST Syamriani S, S.Kom') {
            return '197904222002122003';
        }elseif ($this->nama=='Ruslan') {
            return '197606062007011003';
        }elseif ($this->nama=='Saharuddin') {
            return '197105152006041038';
        }elseif ($this->nama=='Novi Fahdilla S.Tr.Stat') {
            return '199602262019012001';
        }elseif ($this->nama=='Rizki Nur Eka Pratiwi S.Tr.Stat') {
            return '199603192019012001';
        }elseif ($this->nama=='Sabiludyn Raka Pradikta S.ST') {
            return '199509192018021001';
        }elseif ($this->nama=='Ikhsan Margo Pangestu S.Tr.Stat') {
            return '199607052019011001';
        }elseif ($this->nama=='Isna Muflichatul Fadhilah, S.ST') {
            return '199311082016022002';
        }elseif ($this->nama=='Sudarnati M') {
            return '198105132006042024';
        }elseif ($this->nama=='Abd Halim Hakim') {
            return '196702172007011003';
        }elseif ($this->nama=='Ammas Pualam Islamy S.Tr.Stat') {
            return '199608032019121001';
        }else{
            return '';
        }
    }
}
public function getGolongan()
    {
        {
        if($this->nama=='Mukrabin S.E, M.M'){
            return 'IV/b';
        }elseif ($this->nama=='Andi Cakra Atmajaya S.Pt') {
            return 'III/c';
        }elseif ($this->nama=='Rahmi Hijriati Ashri, S.Si,M.Si') {
            return 'III/c';
        }elseif ($this->nama=='Laila Mustika Daeng Karra A.md') {
            return 'II/d';
        }elseif ($this->nama=='Yudianto') {
            return 'II/b';
        }elseif ($this->nama=='Oktavanyta Ariani S.Tr.Stat.') {
            return 'III/a';
        }elseif ($this->nama=='Mardiah S.Si') {
            return 'III/a';
        }elseif ($this->nama=='Baharudding S.E') {
            return 'III/d';
        }elseif ($this->nama=='Kasmawati Saleng S.E') {
            return 'III/d';
        }elseif ($this->nama=='Nurjaona S.E') {
            return 'III/d';
        }elseif ($this->nama=='ST Syamriani S, S.Kom') {
            return 'III/d';
        }elseif ($this->nama=='Ruslan') {
            return 'I/d';
        }elseif ($this->nama=='Saharuddin') {
            return 'II/d';
        }elseif ($this->nama=='Novi Fahdilla S.Tr.Stat') {
            return 'III/a';
        }elseif ($this->nama=='Rizki Nur Eka Pratiwi S.Tr.Stat') {
            return 'III/a';
        }elseif ($this->nama=='Sabiludyn Raka Pradikta S.ST') {
            return 'III/a';
        }elseif ($this->nama=='Ikhsan Margo Pangestu S.Tr.Stat') {
            return 'III/a';
        }elseif ($this->nama=='Isna Muflichatul Fadhilah, S.ST') {
            return 'III/a';
        }elseif ($this->nama=='Sudarnati M') {
            return 'III/a';
        }elseif ($this->nama=='Abd Halim Hakim') {
            return 'III/a';
        }elseif ($this->nama=='Ammas Pualam Islamy S.Tr.Stat') {
            return 'III/a';
        }else{
            return '';
        }
    }
}
    public function getIdRoom()
    {
        return $this->hasOne(Room::className(), ['id' => 'program']);
    }
}
