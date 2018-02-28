<?php 
namespace backend\models;

use yii\db\ActiveRecord;

Class House extends ActiveRecord {
	public static function tableName()
    {
        return 't_house';
    }


    public function rules()
    {
        return [
            [['houseid', 'userid', 'districtid', 'housenumber', 'roomnumber', 'storey', 'totalstorey', 'roomcnt', 'hallcnt', 'bathroomcnt', 'houseage', 'schooldistrictflag', 'metroflag', 'owneronlyflag', 'overfiveonlyflag', 'validflag'], 'integer'],
            [['districtname', 'buildingtype', 'decorationtype', 'orientation', 'detail', 'publishdate'], 'safe'],
            [['buildingarea', 'expectsaleprice'], 'number'],
        ];
    }

    function pics($houseid){
        $pics = \backend\models\Pic::find()->where(['houseid'=> $houseid])->asArray()->all();
        $imgs = '';
        foreach ($pics as $pic){
            $imgs .=\yii\helpers\html::img($pic['picture'], ['width' => '200','height' => '200']);
        }
        return $imgs;
    }
    
}