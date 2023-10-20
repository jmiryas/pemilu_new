<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Kandidat;
use Yii;

/**
 * KandidatSearch represents the model behind the search form of `app\models\Kandidat`.
 */
class KandidatSearch extends Kandidat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_kandidat', 'id_setting'], 'integer'],
            [['nama_kandidat', 'foto'], 'safe'],
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
        $query = Kandidat::find();

        // add conditions that should always apply here

        // var_dump(User::hasRole("kandidat", false));
        // die;

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
            'id_kandidat' => $this->id_kandidat,
            'id_setting' => $this->id_setting,
        ]);

        $query->andFilterWhere(['like', 'nama_kandidat', $this->nama_kandidat])
            ->andFilterWhere(['like', 'foto', $this->foto]);

        return $dataProvider;
    }
}
