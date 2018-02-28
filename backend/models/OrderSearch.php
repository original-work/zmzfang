<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Order;

/**
 * OrderSearch represents the model behind the search form about `backend\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'time_end', 'total_fee', 'coupon_fee'], 'integer'],
            [['out_trade_no', 'attach', 'fee_type', 'bank_type', 'trade_type', 'openid', 'result_code', 'err_code', 'err_code_des', 'coupon_count', 'sign'], 'safe'],
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
        $query = Order::find();

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
            'time_end' => $this->time_end,
            'total_fee' => $this->total_fee,
            'coupon_fee' => $this->coupon_fee,
        ]);

        $query->andFilterWhere(['like', 'out_trade_no', $this->out_trade_no])
            ->andFilterWhere(['like', 'attach', $this->attach])
            ->andFilterWhere(['like', 'fee_type', $this->fee_type])
            ->andFilterWhere(['like', 'bank_type', $this->bank_type])
            ->andFilterWhere(['like', 'trade_type', $this->trade_type])
            ->andFilterWhere(['like', 'openid', $this->openid])
            ->andFilterWhere(['like', 'result_code', $this->result_code])
            ->andFilterWhere(['like', 'err_code', $this->err_code])
            ->andFilterWhere(['like', 'err_code_des', $this->err_code_des])
            ->andFilterWhere(['like', 'coupon_count', $this->coupon_count])
            ->andFilterWhere(['like', 'sign', $this->sign]);

        return $dataProvider;
    }
}
