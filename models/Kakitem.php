<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "kakitem".
 *
 * @property int $id
 * @property int $kak_id
 * @property string $nama
 * @property int $jabatan
 * @property int $sebagai
 * @property int $beban
 * @property string $satuan
 *
 * @property Kak $kak
 */
class Kakitem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kakitem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'sebagai','beban' ], 'required'],
            [['nama','sebagai','sat', 'pot','harsat','tempat','tambahan'], 'safe'],
            [['kak_id'], 'exist', 'skipOnError' => true, 'targetClass' => Kak::className(), 'targetAttribute' => ['kak_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kak_id' => 'Kak ID',
            'nama' => 'Nama',
            'jabatan' => 'Jabatan',
            'sebagai' => 'Sebagai',
            'beban' => 'Beban',
            'satuan' => 'Satuan',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKak()
    {
        return $this->hasOne(Kak::className(), ['id' => 'kak_id']);
    }
    public function getIdJabatan()
    {
        {
        if($this->nama=='Ir. Muhammad Kamil'){
            return 'Kapala';
        }elseif ($this->nama=='Andi Cakra Atmajaya S.Pt') {
            return 'Kasubag Umum';
        }elseif ($this->nama=='Rahmi Hijriati Ashri, S.Si,M.Si') {
            return 'Kordinator Fungsi IPDS';
        }elseif ($this->nama=='Laila Mustika Daeng Karra A.md') {
            return 'Staf Subbag Umum';
        }elseif ($this->nama=='Yudianto') {
            return 'KSK Tamalatea';
        }elseif ($this->nama=='Oktavanyta Ariani S.Tr.Stat.') {
            return 'Staf Fungsi IPDS';
        }elseif ($this->nama=='Mardiah S.Si') {
            return 'Staf Sub Bagian Umum';
        }elseif ($this->nama=='Baharudding S.E') {
            return 'Kordinator Fungsi Statistik Produksi';
        }elseif ($this->nama=='Kasmawati Saleng S.E') {
            return 'Kordinator Fungsi Statistik Distribusi';
        }elseif ($this->nama=='Nurjaona S.E') {
            return 'Kordinator Fungsi Statistik Sosial';
        }elseif ($this->nama=='ST Syamriani S, S.Kom') {
            return 'Kordinator Fungsi Neraca Wilayah dan Analisis Statistik';
        }elseif ($this->nama=='Ruslan') {
            return 'Staf Sub Bagian Umum';
        }elseif ($this->nama=='Saharuddin') {
            return 'KSK Tamalatea';
        }elseif ($this->nama=='Novi Fahdilla S.Tr.Stat') {
            return 'Staf Fungsi Statistik Sosial';
        }elseif ($this->nama=='Rizki Nur Eka Pratiwi S.Tr.Stat') {
            return 'Staf Fungsi Statistik Produksi';
        }elseif ($this->nama=='Sabiludyn Raka Pradikta S.ST') {
            return 'Staf Fungsi Statistik Sosial';
        }elseif ($this->nama=='Ikhsan Margo Pangestu S.Tr.Stat') {
            return 'Staf Fungsi Statistik Distribusi';
        }elseif ($this->nama=='Isna Muflichatul Fadhilah, S.ST') {
            return 'Staf Fungsi Neraca Wilayah dan Analisis Statistik';
        }elseif ($this->nama=='Mardiah S.Si') {
            return 'Staf Sub Bagian Umum';
        }elseif ($this->nama=='Sudarnati M') {
            return 'KSK Bangkala Barat';
        }elseif ($this->nama=='Abd Halim Hakim') {
            return 'KSK Kelara';
        }elseif ($this->nama=='Ammas Pualam Islamy S.Tr.Stat.') {
            return 'Staf Fungsi Statistik Sosial';
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
            return ' NIP.196306261992031002';
        }elseif ($this->nama=='Andi Cakra Atmajaya S.Pt') {
            return ' NIP.197810222006041003';
        }elseif ($this->nama=='Rahmi Hijriati Ashri, S.Si,M.Si') {
            return ' NIP.197706112006042001';
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
            return 'Non Organik';
        }
    }
}
public function getGolongan()
    {
        {
        if($this->nama=='Mukrabin S.E, M.M'){
            return 'Golongan : IV/b';
        }elseif ($this->nama=='Andi Cakra Atmajaya S.Pt') {
            return 'Golongan : III/c';
        }elseif ($this->nama=='Rahmi Hijriati Ashri, S.Si,M.Si') {
            return 'Golongan : III/c';
        }elseif ($this->nama=='Laila Mustika Daeng Karra A.md') {
            return 'Golongan : II/d';
        }elseif ($this->nama=='Yudianto') {
            return 'Golongan : II/b';
        }elseif ($this->nama=='Oktavanyta Ariani S.Tr.Stat.') {
            return 'Golongan : III/a';
        }elseif ($this->nama=='Mardiah S.Si') {
            return 'Golongan : III/a';
        }elseif ($this->nama=='Baharudding S.E') {
            return 'Golongan : III/d';
        }elseif ($this->nama=='Kasmawati Saleng S.E') {
            return 'Golongan : III/d';
        }elseif ($this->nama=='Nurjaona S.E') {
            return 'Golongan : III/d';
        }elseif ($this->nama=='ST Syamriani S, S.Kom') {
            return 'Golongan : III/d';
        }elseif ($this->nama=='Ruslan') {
            return 'Golongan : I/d';
        }elseif ($this->nama=='Saharuddin') {
            return 'Golongan : II/d';
        }elseif ($this->nama=='Novi Fahdilla S.Tr.Stat') {
            return 'Golongan : III/a';
        }elseif ($this->nama=='Rizki Nur Eka Pratiwi S.Tr.Stat') {
            return 'Golongan : III/a';
        }elseif ($this->nama=='Sabiludyn Raka Pradikta S.ST') {
            return 'Golongan : III/a';
        }elseif ($this->nama=='Ikhsan Margo Pangestu S.Tr.Stat') {
            return 'Golongan : III/a';
        }elseif ($this->nama=='Isna Muflichatul Fadhilah, S.ST') {
            return 'Golongan : III/a';
        }elseif ($this->nama=='Sudarnati M') {
            return 'Golongan : III/a';
        }elseif ($this->nama=='Abd Halim Hakim') {
            return 'Golongan : III/a';
        }elseif ($this->nama=='Ammas Pualam Islamy S.Tr.Stat') {
            return 'Golongan : III/a';
        }else{
            return '';
        }
    }
}
public function getGol()
    {
        {
        if($this->nama=='Ir. Muhammad Kamil'){
            return 'IV';
        }elseif ($this->nama=='Andi Cakra Atmajaya S.Pt') {
            return 'III';
        }elseif ($this->nama=='Rahmi Hijriati Ashri, S.Si,M.Si') {
            return 'III';
        }elseif ($this->nama=='Laila Mustika Daeng Karra A.md') {
            return 'II';
        }elseif ($this->nama=='Oktavanyta Ariani S.Tr.Stat.') {
            return 'III';
        }elseif ($this->nama=='Mardiah S.Si') {
            return 'III';
        }elseif ($this->nama=='Baharudding S.E') {
            return 'III';
        }elseif ($this->nama=='Kasmawati Saleng S.E') {
            return 'III';
        }elseif ($this->nama=='Nurjaona S.E') {
            return 'III';
        }elseif ($this->nama=='ST Syamriani S, S.Kom') {
            return 'III';
        }elseif ($this->nama=='Ruslan') {
            return 'I';
        }elseif ($this->nama=='Saharuddin') {
            return 'II';
        }elseif ($this->nama=='Novi Fahdilla S.Tr.Stat') {
            return 'III';
        }elseif ($this->nama=='Rizki Nur Eka Pratiwi S.Tr.Stat') {
            return 'III';
        }elseif ($this->nama=='Sabiludyn Raka Pradikta S.ST') {
            return 'III';
        }elseif ($this->nama=='Ikhsan Margo Pangestu S.Tr.Stat') {
            return 'III';
        }elseif ($this->nama=='Isna Muflichatul Fadhilah, S.ST') {
            return 'III';
        }elseif ($this->nama=='Sudarnati M') {
            return 'III';
        }elseif ($this->nama=='Abd Halim Hakim') {
            return 'III';
        }elseif ($this->nama=='Ammas Pualam Islamy S.Tr.Stat') {
            return 'III';
        }else{
            return '-';
        }
    }
}
public function getIdNama()
    {
        return $this->hasOne(Pegawai::className(), ['id' => 'nama']);
    }
}
