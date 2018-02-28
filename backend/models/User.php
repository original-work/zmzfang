<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "t_user".
 *
 * @property integer $id
 * @property string $nickname
 * @property string $phone
 * @property string $picture
 * @property string $password
 * @property string $email
 * @property string $sex
 * @property string $city
 * @property string $realname
 * @property integer $agentflag
 * @property string $identitycard
 * @property integer $expertflag
 * @property integer $srcflag
 * @property integer $totaltimes
 * @property string $logintime
 * @property string $createtime
 * @property string $wxopenid
 * @property string $wxunionid
 * @property string $tags
 * @property integer $validflag
 * @property integer $max_requirement
 * @property integer $max_supplyment
 * @property string $havemsg
 * @property string $activeregion
 * @property string $homecity
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nickname', 'picture', 'sex', 'expertflag', 'srcflag', 'logintime', 'createtime', 'wxopenid', 'tags'], 'required'],
            [['agentflag', 'expertflag', 'srcflag', 'totaltimes', 'validflag', 'max_requirement', 'max_supplyment', 'havemsg'], 'integer'],
            [['logintime', 'createtime'], 'safe'],
            [['nickname', 'password', 'email', 'city', 'realname', 'identitycard', 'activeregion', 'homecity'], 'string', 'max' => 40],
            [['phone'], 'string', 'max' => 35],
            [['picture'], 'string', 'max' => 200],
            [['sex'], 'string', 'max' => 10],
            [['wxopenid', 'wxunionid', 'tags'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户id',
            'nickname' => '用户昵称',
            'phone' => '用户手机号',
            'picture' => '用户头像',
            'password' => '密码md5',
            'email' => '邮箱',
            'sex' => '性别',
            'city' => '城市',
            'realname' => '真实姓名',
            'agentflag' => '经纪人标识',
            'identitycard' => '身份证号',
            'expertflag' => '专家标识',
            'srcflag' => '来源，1：手机APP，2：PC，3：微信',
            'totaltimes' => '登陆次数',
            'logintime' => '最后一次登陆时间',
            'createtime' => '注册时间',
            'wxopenid' => 'Wxopenid',
            'wxunionid' => 'Wxunionid',
            'tags' => '1-二手房，2-一手房，3-商业办公，4-厂房土地,5-海外房产,6-旅游度假房产,7-养老房产,8-城市周边投资房产，9-拍卖房产',
            'validflag' => '是否真实用户',
            'max_requirement' => 'Max Requirement',
            'max_supplyment' => 'Max Supplyment',
            'havemsg' => 'Havemsg',
            'activeregion' => 'Activeregion',
            'homecity' => '家乡城市,主要用于普通用户',
            'position' => '职位'
        ];
    }
    function getAgent(){
         return $this->hasOne(Agent::className(), ['userid' => 'id']);
    }
}
