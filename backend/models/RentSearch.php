<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Rent;

/**
 * RentSearch represents the model behind the search form about `backend\models\Rent`.
 */
class RentSearch extends Rent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'publishuserid', 'publishusertype', 'requirementtype'], 'integer'],
            [['region1', 'region2', 'region3', 'regions', 'districtid', 'districtname', 'budget', 'housetype', 'storey', 'buildingtype', 'detail', 'updatetime', 'createtime', 'subject', 'validflag'], 'safe'],
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
        $query = Rent::find();

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
            'publishuserid' => $this->publishuserid,
            'publishusertype' => $this->publishusertype,
            'requirementtype' => $this->requirementtype,
            'updatetime' => $this->updatetime,
            'createtime' => $this->createtime,
        ]);

        $query->andFilterWhere(['like', 'region1', $this->region1])
            ->andFilterWhere(['like', 'region2', $this->region2])
            ->andFilterWhere(['like', 'region3', $this->region3])
            ->andFilterWhere(['like', 'regions', $this->regions])
            ->andFilterWhere(['like', 'districtid', $this->districtid])
            ->andFilterWhere(['like', 'districtname', $this->districtname])
            ->andFilterWhere(['like', 'budget', $this->budget])
            ->andFilterWhere(['like', 'housetype', $this->housetype])
            ->andFilterWhere(['like', 'storey', $this->storey])
            ->andFilterWhere(['like', 'buildingtype', $this->buildingtype])
            ->andFilterWhere(['like', 'detail', $this->detail])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'validflag', $this->validflag]);

        return $dataProvider;
    }
}
