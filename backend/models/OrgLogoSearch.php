<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\OrgLogo;

/**
 * OrgLogoSearch represents the model behind the search form about `backend\models\OrgLogo`.
 */
class OrgLogoSearch extends OrgLogo
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'organizationlogoid', 'pri', 'validflag'], 'integer'],
            [['organizationkey', 'organizationlogo', 'remark', 'detail', 'createtime'], 'safe'],
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
        $query = OrgLogo::find();

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
            'organizationlogoid' => $this->organizationlogoid,
            'pri' => $this->pri,
            'createtime' => $this->createtime,
            'validflag' => $this->validflag,
        ]);

        $query->andFilterWhere(['like', 'organizationkey', $this->organizationkey])
            ->andFilterWhere(['like', 'organizationlogo', $this->organizationlogo])
            ->andFilterWhere(['like', 'remark', $this->remark])
            ->andFilterWhere(['like', 'detail', $this->detail]);

        return $dataProvider;
    }
}
