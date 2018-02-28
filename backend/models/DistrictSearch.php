<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\District;

/**
 * DistrictSearch represents the model behind the search form about `backend\models\District`.
 */
class DistrictSearch extends District
{
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['districtid'], 'integer'],
			[['districtname', 'address', 'completedtime', 'region', 'plate'], 'safe'],
			[['latitude', 'longitude'], 'number'],
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
		$query = District::find();
		
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
		// $query->union(\backend\models\District_0010::find())->union(\backend\models\District_0020::find())->union(\backend\models\District_0755::find())->union(\backend\models\District_0571::find());
		// grid filtering conditions
		$query->andFilterWhere([
			'districtid' => $this->districtid,
			// 'latitude' => $this->latitude,
			// 'longitude' => $this->longitude,
			'completedtime' => $this->completedtime,
		]);

		$query->andFilterWhere(['like', 'districtname', $this->districtname])
			->andFilterWhere(['like', 'address', $this->address])
			->andFilterWhere(['like', 'region', $this->region])
			->andFilterWhere(['like', 'plate', $this->plate]);

		return $dataProvider;
	}
}
