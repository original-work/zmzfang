<?php 

namespace backend\models;

use yii\db\ActiveRecord;

Class Expert extends ActiveRecord {
	public function rules()
	{
	    return [
	        [['id', 'userid', 'praisecnt', 'status'], 'integer'],
	        [['name', 'organization', 'workperiod', 'position', 'email', 'activeregion', 'domain', 'businesscard', 'headpicture', 'introduction', 'expertisen','status'], 'safe'],
	        [['onlinecharge', 'offlinetime', 'offlinecharge'], 'number'],
	    ];
	}
	public static function tableName()
    {
        return 't_expert';
    }
}