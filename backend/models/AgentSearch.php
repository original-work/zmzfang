<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Agent;

/**
 * AgentSearch represents the model behind the search form about `backend\models\Agent`.
 */
class AgentSearch extends Agent
{
    public $organizationlogo;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'certificateflag', 'praisecnt', 'validflag', 'datacompleterate'], 'integer'],
            [['organization', 'storeinfo', 'workperiod', 'position', 'education', 'schoolinfo', 'nativeplace', 'zmcredit', 'certificateno', 'skill', 'addedservice', 'pushcity', 'majordistrict', 'createtime', 'updatetime', 'businesscard','organizationlogo'], 'safe'],
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
        $query = Agent::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'validflag' => SORT_DESC,
                    'id' => SORT_DESC,
                ]
            ],
        ]);
        $sort = $dataProvider->getSort();
        $sort->attributes['organizationlogo']['asc'] = ['organizationlogo'=>SORT_ASC];
        $sort->attributes['organizationlogo']['desc'] = ['organizationlogo'=>SORT_DESC];
        $dataProvider->setSort($sort);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('logo');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'userid' => $this->userid,
            'certificateflag' => $this->certificateflag,
            'praisecnt' => $this->praisecnt,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
            'validflag' => $this->validflag,
            'datacompleterate' => $this->datacompleterate,
        ]);

        $query->andFilterWhere(['like', 'organization', $this->organization])
            ->andFilterWhere(['like', 'storeinfo', $this->storeinfo])
            ->andFilterWhere(['like', 'workperiod', $this->workperiod])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'education', $this->education])
            ->andFilterWhere(['like', 'schoolinfo', $this->schoolinfo])
            ->andFilterWhere(['like', 'nativeplace', $this->nativeplace])
            ->andFilterWhere(['like', 'zmcredit', $this->zmcredit])
            ->andFilterWhere(['like', 'certificateno', $this->certificateno])
            ->andFilterWhere(['like', 'skill', $this->skill])
            ->andFilterWhere(['like', 'addedservice', $this->addedservice])
            ->andFilterWhere(['like', 'pushcity', $this->pushcity])
            ->andFilterWhere(['like', 'majordistrict', $this->majordistrict])
            ->andFilterWhere(['like', 'businesscard', $this->businesscard])
            ->andFilterWhere(['like', 't_organization_logo.organizationlogo', $this->organizationlogo]);


        return $dataProvider;
    }
}
