<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Expert;

/**
 * ExpertSearch represents the model behind the search form about `backend\models\Expert`.
 */
class ExpertSearch extends Expert
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'praisecnt', 'status'], 'integer'],
            [['name', 'organization', 'workperiod', 'position', 'email', 'activeregion', 'domain', 'businesscard', 'headpicture', 'introduction', 'expertisen'], 'safe'],
            [['onlinecharge', 'offlinetime', 'offlinecharge'], 'number'],
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
        $query = Expert::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'priority' =>SORT_DESC,
                    'status' => SORT_ASC,
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
            'userid' => $this->userid,
            'onlinecharge' => $this->onlinecharge,
            'offlinetime' => $this->offlinetime,
            'offlinecharge' => $this->offlinecharge,
            'praisecnt' => $this->praisecnt,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'organization', $this->organization])
            ->andFilterWhere(['like', 'workperiod', $this->workperiod])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'activeregion', $this->activeregion])
            ->andFilterWhere(['like', 'domain', $this->domain])
            ->andFilterWhere(['like', 'businesscard', $this->businesscard])
            ->andFilterWhere(['like', 'headpicture', $this->headpicture])
            ->andFilterWhere(['like', 'introduction', $this->introduction])
            ->andFilterWhere(['like', 'expertisen', $this->expertisen]);

        return $dataProvider;
    }
}
