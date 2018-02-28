<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\House;

/**
 * HouseSearch represents the model behind the search form about `backend\models\House`.
 */
class HouseSearch extends House
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['houseid', 'userid', 'districtid', 'housenumber', 'roomnumber', 'storey', 'totalstorey', 'roomcnt', 'hallcnt', 'bathroomcnt', 'houseage', 'schooldistrictflag', 'metroflag', 'owneronlyflag', 'overfiveonlyflag', 'validflag'], 'integer'],
            [['districtname', 'buildingtype', 'decorationtype', 'orientation', 'detail', 'publishdate'], 'safe'],
            [['buildingarea', 'expectsaleprice'], 'number'],
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
        $query = House::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'validflag' => SORT_DESC,
                    'houseid' => SORT_DESC,
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
            'houseid' => $this->houseid,
            'userid' => $this->userid,
            'districtid' => $this->districtid,
            'housenumber' => $this->housenumber,
            'roomnumber' => $this->roomnumber,
            'buildingarea' => $this->buildingarea,
            'expectsaleprice' => $this->expectsaleprice,
            'storey' => $this->storey,
            'totalstorey' => $this->totalstorey,
            'roomcnt' => $this->roomcnt,
            'hallcnt' => $this->hallcnt,
            'bathroomcnt' => $this->bathroomcnt,
            'houseage' => $this->houseage,
            'schooldistrictflag' => $this->schooldistrictflag,
            'metroflag' => $this->metroflag,
            'owneronlyflag' => $this->owneronlyflag,
            'publishdate' => $this->publishdate,
            'overfiveonlyflag' => $this->overfiveonlyflag,
            'validflag' => $this->validflag,
        ]);

        $query->andFilterWhere(['like', 'districtname', $this->districtname])
            ->andFilterWhere(['like', 'buildingtype', $this->buildingtype])
            ->andFilterWhere(['like', 'decorationtype', $this->decorationtype])
            ->andFilterWhere(['like', 'orientation', $this->orientation])
            ->andFilterWhere(['like', 'detail', $this->detail]);

        return $dataProvider;
    }
}
