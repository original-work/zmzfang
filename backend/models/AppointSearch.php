<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Appoint;

/**
 * AppointSearch represents the model behind the search form about `backend\models\Appoint`.
 */
class AppointSearch extends Appoint
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'expertid', 'appointmenttype', 'questionid', 'status', 'validflag', 'paytype'], 'integer'],
            [['appointmentsubject', 'ordersubject', 'createtime', 'updatetime'], 'safe'],
            [['fee'], 'number'],
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
        $query = Appoint::find();

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
            'userid' => $this->userid,
            'expertid' => $this->expertid,
            'appointmenttype' => $this->appointmenttype,
            'questionid' => $this->questionid,
            'fee' => $this->fee,
            'status' => $this->status,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
            'validflag' => $this->validflag,
            'paytype' => $this->paytype,
        ]);

        $query->andFilterWhere(['like', 'appointmentsubject', $this->appointmentsubject])
            ->andFilterWhere(['like', 'ordersubject', $this->ordersubject]);

        return $dataProvider;
    }
}
