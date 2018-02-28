<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\User;

/**
 * UserSearch represents the model behind the search form about `backend\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'agentflag', 'expertflag', 'srcflag', 'totaltimes', 'validflag', 'max_requirement', 'max_supplyment', 'havemsg'], 'integer'],
            [['nickname', 'phone', 'picture', 'password', 'email', 'sex', 'city', 'realname', 'identitycard', 'logintime', 'createtime', 'wxopenid', 'wxunionid', 'tags', 'activeregion', 'homecity'], 'safe'],
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
        $query = User::find();

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

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'agentflag' => $this->agentflag,
            'expertflag' => $this->expertflag,
            'srcflag' => $this->srcflag,
            'totaltimes' => $this->totaltimes,
            'logintime' => $this->logintime,
            'createtime' => $this->createtime,
            'validflag' => $this->validflag,
            'max_requirement' => $this->max_requirement,
            'max_supplyment' => $this->max_supplyment,
            'havemsg' => $this->havemsg,
        ]);

        $query->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'picture', $this->picture])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'realname', $this->realname])
            ->andFilterWhere(['like', 'identitycard', $this->identitycard])
            ->andFilterWhere(['like', 'wxopenid', $this->wxopenid])
            ->andFilterWhere(['like', 'wxunionid', $this->wxunionid])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'activeregion', $this->activeregion])
            ->andFilterWhere(['like', 'homecity', $this->homecity]);

        return $dataProvider;
    }
}
