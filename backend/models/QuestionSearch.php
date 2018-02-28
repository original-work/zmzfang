<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Question;

/**
 * QuestionSearch represents the model behind the search form about `backend\models\Question`.
 */
class QuestionSearch extends Question
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userid', 'expertid', 'openflag', 'listenedcnt', 'duration', 'priority'], 'integer'],
            [['questionsubject', 'questiondetail', 'answer', 'questiondate', 'anserdate'], 'safe'],
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
        $query = Question::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'priority' =>SORT_DESC,
                    'id' => SORT_DESC,
                ]
            ]
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
            'openflag' => $this->openflag,
            'listenedcnt' => $this->listenedcnt,
            'questiondate' => $this->questiondate,
            'anserdate' => $this->anserdate,
            'duration' => $this->duration,
            'priority' => $this->priority,
        ]);

        $query->andFilterWhere(['like', 'questionsubject', $this->questionsubject])
            ->andFilterWhere(['like', 'questiondetail', $this->questiondetail])
            ->andFilterWhere(['like', 'answer', $this->answer]);

        return $dataProvider;
    }
}
