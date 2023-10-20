<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Misi;
use Yii;

/**
 * MisiSearch represents the model behind the search form of `app\models\Misi`.
 */
class MisiSearch extends Misi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_misi', 'id_visi'], 'integer'],
            [['nama_misi'], 'safe'],
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
        // Jika visi belum dibuat, otomatis tidak ada misi
        // Sehingga, menimbulkan error
        // Jadi, cek dulu apakah visi ada atau tidak
        // Jika tidak, return array empty

        $query = Misi::find();
        $is_visi_exists = false;

        // add conditions that should always apply here

        if (User::hasRole("kandidat", false)) {
            $username = Yii::$app->user->identity->username;

            $selectedVisi = Visi::find()
                ->where(["id_kandidat" => $username])
                ->asArray()
                ->one();

            // var_dump($selectedVisi);
            // die;

            if ($selectedVisi != null) {
                $query->andFilterWhere(["id_visi" => $selectedVisi["id_visi"]]);
                $is_visi_exists = true;
            }

            if ($is_visi_exists == true) {
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
                    'id_misi' => $this->id_misi,
                    'id_visi' => $this->id_visi,
                ]);

                $query->andFilterWhere(['like', 'nama_misi', $this->nama_misi]);

                return $dataProvider;
            } else {
                return [];
            }
        }

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
            'id_misi' => $this->id_misi,
            'id_visi' => $this->id_visi,
        ]);

        $query->andFilterWhere(['like', 'nama_misi', $this->nama_misi]);

        return $dataProvider;
    }
}
