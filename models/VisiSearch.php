<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Visi;
use Yii;

/**
 * VisiSearch represents the model behind the search form of `app\models\Visi`.
 */
class VisiSearch extends Visi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_visi', 'id_kandidat'], 'integer'],
            [['nama_visi'], 'safe'],
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
        $query = Visi::find();

        // add conditions that should always apply here

        if (User::hasRole("kandidat", false)) {
            $username = Yii::$app->user->identity->username;

            $query->andFilterWhere(["id_kandidat" => $username]);
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
            'id_visi' => $this->id_visi,
            'id_kandidat' => $this->id_kandidat,
        ]);

        $query->andFilterWhere(['like', 'nama_visi', $this->nama_visi]);

        return $dataProvider;
    }
}
