<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "t_agent".
 *
 * @property integer $id
 * @property integer $userid
 * @property string $organization
 * @property string $storeinfo
 * @property string $workperiod
 * @property string $position
 * @property string $education
 * @property string $schoolinfo
 * @property string $nativeplace
 * @property string $zmcredit
 * @property integer $certificateflag
 * @property string $certificateno
 * @property string $skill
 * @property string $addedservice
 * @property string $pushcity
 * @property string $majordistrict
 * @property integer $praisecnt
 * @property string $createtime
 * @property string $updatetime
 * @property integer $validflag
 * @property string $businesscard
 * @property integer $datacompleterate
 */
class Agent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_agent';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'majordistrict', 'createtime', 'updatetime'], 'required'],
            [['userid', 'certificateflag', 'praisecnt', 'validflag', 'datacompleterate'], 'integer'],
            [['createtime', 'updatetime','organizationlogoid'], 'safe'],
            [['organization', 'storeinfo'], 'string', 'max' => 35],
            [['workperiod'], 'string', 'max' => 20],
            [['position', 'education', 'schoolinfo', 'nativeplace', 'zmcredit', 'certificateno'], 'string', 'max' => 40],
            [['skill', 'addedservice', 'majordistrict'], 'string', 'max' => 128],
            [['pushcity'], 'string', 'max' => 64],
            [['businesscard'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '经纪人ID',
            'userid' => '用户id',
            'organization' => '任职机构',
            'storeinfo' => '门店信息，如张江店',
            'workperiod' => '从业年限',
            'position' => '职位',
            'education' => '学历',
            'schoolinfo' => '学校信息',
            'nativeplace' => '籍贯',
            'zmcredit' => '芝麻信用',
            'certificateflag' => '证书标识，0表示无，1表示有',
            'certificateno' => '经纪人证书标识',
            'skill' => '技能',
            'addedservice' => '增值服务',
            'pushcity' => '推送城市',
            'majordistrict' => 'Majordistrict',
            'praisecnt' => '点赞个数，默认为0',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
            'validflag' => 'Validflag',
            'businesscard' => '名片路径',
            'datacompleterate' => '经纪人信息完整度',
        ];
    }
    function getLogo(){
        return $this->hasOne(OrgLogo::className(), ['organizationlogoid' => 'organizationlogoid']);
    }
}
