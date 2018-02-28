<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Bid;

/**
 * BidSearch represents the model behind the search form about `backend\models\Bid`.
 */
class BidSearch extends Bid
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'biduserid', 'requirementuserid', 'requirementid', 'bidstatus', 'bidtype', 'houseid'], 'integer'],
            [['biddate', 'validflag'], 'safe'],
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
        $query = Bid::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
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
            'biduserid' => $this->biduserid,
            'requirementuserid' => $this->requirementuserid,
            'requirementid' => $this->requirementid,
            'bidstatus' => $this->bidstatus,
            'bidtype' => $this->bidtype,
            'biddate' => $this->biddate,
            'houseid' => $this->houseid,
        ]);

        $query->andFilterWhere(['like', 'validflag', $this->validflag]);

        return $dataProvider;
    }
}
