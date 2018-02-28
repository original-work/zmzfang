<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\District0020;

/**
 * District0010Search represents the model behind the search form about `backend\models\District0010`.
 */
class District0020Search extends District0020
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['districtid'], 'integer'],
            [['districtname', 'address', 'completedtime', 'region', 'plate'], 'safe'],
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
        $query = District0020::find();

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
            'districtid' => $this->districtid,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
        ]);

        $query->andFilterWhere(['like', 'districtname', $this->districtname])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'completedtime', $this->completedtime])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'plate', $this->plate]);

        return $dataProvider;
    }
}
