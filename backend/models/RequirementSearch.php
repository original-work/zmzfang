<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Requirement;

/**
 * RequirementSearch represents the model behind the search form about `backend\models\Requirement`.
 */
class RequirementSearch extends Requirement
{
    /**
     * @inheritdoc
     */
    public $nickname; 
    public function rules()
    {
        return [
            [['id', 'publishuserid', 'publishusertype', 'requirementtype', 'acceptagentflag'], 'integer'],
            [['region1', 'region2', 'region3', 'districtid', 'districtname', 'budget', 'housetype', 'storey', 'buildingtype', 'detail', 'dividefeedescribe', 'updatetime', 'createtime', 'dividerate', 'subject', 'validflag','nickname'], 'safe'],
            [['agentfee', 'expectdividefee'], 'number'],
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
        $query = Requirement::find();

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
        $sort->attributes['nickname']['asc'] = ['nickname'=>SORT_ASC];
        $sort->attributes['nickname']['desc'] = ['nickname'=>SORT_DESC];
        $dataProvider->setSort($sort);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('user');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'publishuserid' => $this->publishuserid,
            'publishusertype' => $this->publishusertype,
            'requirementtype' => $this->requirementtype,
            'acceptagentflag' => $this->acceptagentflag,
            'agentfee' => $this->agentfee,
            'updatetime' => $this->updatetime,
            'createtime' => $this->createtime,
            'expectdividefee' => $this->expectdividefee,
        ]);

        $query->andFilterWhere(['like', 'region1', $this->region1])
            ->andFilterWhere(['like', 'region2', $this->region2])
            ->andFilterWhere(['like', 'region3', $this->region3])
            ->andFilterWhere(['like', 'districtid', $this->districtid])
            ->andFilterWhere(['like', 'districtname', $this->districtname])
            ->andFilterWhere(['like', 'budget', $this->budget])
            ->andFilterWhere(['like', 'housetype', $this->housetype])
            ->andFilterWhere(['like', 'storey', $this->storey])
            ->andFilterWhere(['like', 'buildingtype', $this->buildingtype])
            ->andFilterWhere(['like', 'detail', $this->detail])
            ->andFilterWhere(['like', 'dividefeedescribe', $this->dividefeedescribe])
            ->andFilterWhere(['like', 'dividerate', $this->dividerate])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'validflag', $this->validflag])
            ->andFilterWhere(['like', 't_user.nickname', $this->nickname]);

        return $dataProvider;
    }
}
