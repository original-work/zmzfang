<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Metro;

/**
 * MetroSearch represents the model behind the search form about `backend\models\Metro`.
 */
class MetroSearch extends Metro
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['metroline', 'text', 'value', 'region','regioname','longitude', 'latitude'], 'safe'],
            [['longitude', 'latitude'], 'number'],
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
        $query = Metro::find();

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
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
        ]);

        $query->andFilterWhere(['like', 'metroline', $this->metroline])
            ->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'regioname', $this->regioname]);

        return $dataProvider;
    }
}
