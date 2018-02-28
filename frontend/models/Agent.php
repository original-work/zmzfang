<?php 
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;
use frontend\models\User;
use frontend\models\UserOperate;
use common\helpers\Functions;

class Agent extends ActiveRecord
{
	public static function tableName()
    {
        return 't_agent';
    }

    public static function findIdentity($id)
    {
        return static::findOne(['userid' => $id]);
    }

    public static function modifyAgent($obj){
    	if($model = static::find()->where(['userid'=>$obj->userid])->one()){
            //先更新用户基本信息
            $user=User::findIdentity($obj->userid);
            $select = implode(',', $obj->select);
            if(!empty($user))
            {
                $user->nickname=$obj->nickname;
                $user->picture=$obj->picture;
                $user->email=$obj->email;
                $user->sex=$obj->sex;
                $user->realname=$obj->realname;
                $user->city=$obj->city;
                $user->identitycard=$obj->identitycard;
                $user->tags=$select;
                $user->agentflag=$obj->agentflag;
                $user->activeregion=$obj->activeregion;
                $user->save();              
            }

            $model -> majordistrict = $obj -> majordistrict;
            $model -> organization  = $obj -> organization;
            $model -> storeinfo  = $obj -> storeinfo;
            $model -> workperiod    = $obj -> workperiod;
            $model -> position      = $obj -> position;
            $model -> education      = $obj -> education;
            $model -> schoolinfo      = $obj -> schoolinfo;
            $model-> businesscard = $obj->businesscard;
            $model -> nativeplace   = $obj -> nativeplace;
            $model -> certificateflag   = $obj -> certificateflag;
            $model -> certificateno   = $obj -> certificateno;
            $model -> skill         = $obj -> skill;
            $model -> addedservice  = $obj -> addedservice;
            $model -> pushcity      = $obj -> pushcity;
            $model -> updatetime    = date('Y-m-d H:i:s');
            $logoArr = \frontend\models\OrgLogo::logos();
            foreach($logoArr as $logo){
                if(mb_strpos("$".$obj -> organization,$logo['organizationkey']) >0){
                    $model -> organizationlogoid  = $logo['organizationlogoid'];
                    break;
                }
            }
            if($model->save()){
                //增加完整度的计算
                static::updateAgentDataCompleterate($obj->userid);
                return ['rscode'=>0];
            }else{
                return ['rscode'=>1];
            }
        }else{
            //先更新用户基本信息
            $user=User::findIdentity($obj->userid);
            if(!empty($user))
            {

                $user->nickname=$obj->nickname;
                $user->picture=$obj->picture;
                $user->email=$obj->email;
                $user->sex=$obj->sex;
                $user->realname=$obj->realname;
                $user->city=$obj->city;
                $user->identitycard=$obj->identitycard;
                $user->tags=$select;
                $user->agentflag=$obj->agentflag;
                $user->activeregion=$obj->activeregion;
                $user->save();              
            }

            $new = new static;
            $new -> userid        = $obj->userid;
            $new -> majordistrict = $obj -> majordistrict;
            $new -> organization  = $obj -> organization;
            $new -> storeinfo  = $obj -> storeinfo;
            $new -> workperiod    = $obj -> workperiod;
            $new -> position      = $obj -> position;
            $new -> education      = $obj -> education;
            $new -> schoolinfo      = $obj -> schoolinfo;
            $new-> businesscard = $obj->businesscard;
            $new -> nativeplace   = $obj -> nativeplace;
            $new -> certificateflag   = $obj -> certificateflag;
            $new -> certificateno   = $obj -> certificateno;
            $new -> skill         = $obj -> skill;
            $new -> addedservice  = $obj -> addedservice;
            $new -> pushcity      = $obj -> pushcity;
            $new -> updatetime    = date('Y-m-d H:i:s');
            $logoArr = \frontend\models\OrgLogo::logos();
            foreach($logoArr as $logo){
                if(mb_strpos("$".$obj -> organization,$logo['organizationkey']) >0){
                    $new -> organizationlogoid  = $logo['organizationlogoid'];
                    break;
                }
            }
            if($new->save()){
                static::updateAgentDataCompleterate($obj->userid);
                return ['rscode'=>0];
            }else{
                return ['rscode'=>1];
            }
        }
    }

    public static function getAgentDetail($obj){
        Yii::error("getAgentDetail obj is : ".print_r($obj,1)."\n");
    	$data = static::find()->from('v_agent')->where(['userid'=>$obj->id])->asArray()->one();
        Yii::error("getAgentDetail data is : ".print_r($data,1)."\n");
        if($data['majordistrict']){
            $majordistricts = explode(',', $data['majordistrict']);
            $majordistrict = \frontend\models\ResidentialInfo::find()->select(['districtid','districtname'])->where(['in','districtid',$majordistricts])->asArray()->all();
        }
        $data['majordistricts'] = $majordistrict;
        Yii::error("getAgentDetail data is : ".print_r($data,1)."\n");
        return $data;
    }

    public static function getAgentExtra($obj){
    	// 尚未处理
  		//（1）根据userid，查看t_user,t_agent中的记录，查看各记录是否填写，生成资料完成比例（详细算法后台确定）；
		//（2）根据userid 到t_estate_agent表中查找楼盘的记录个数，并返回，默认为0；
        $userInfo = User::find()->select(['t_user.nickname','t_user.sex','t_user.city','t_user.realname','t_user.tags','t_user.phone','t_user.activeregion','t_agent.organization','t_agent.workperiod','t_agent.position','t_agent.education','t_agent.nativeplace','t_agent.skill','t_agent.addedservice','t_agent.majordistrict','t_agent.businesscard'])->where(['t_user.id'=>$obj->userid])->leftjoin('t_agent','t_user.id = t_agent.userid')->asArray()->one();
        $q = 0;
        foreach ($userInfo as $value) {
            if(trim($value)){
                $q++;
            }
        }

        //'zmcredit',暂不用
    	return ['datacompleterate'=>round($q*100/16),'estatecnt'=>5];

    }

    public static function getAgentDataCompleterate($userid){
        // 尚未处理
        //（1）根据userid，查看t_user,t_agent中的记录，查看各记录是否填写，生成资料完成比例（详细算法后台确定）；
        //（2）根据userid 到t_estate_agent表中查找楼盘的记录个数，并返回，默认为0；
        $userInfo = User::find()->select(['t_user.nickname','t_user.sex','t_user.city','t_user.realname','t_user.tags','t_user.phone','t_user.activeregion','t_agent.organization','t_agent.workperiod','t_agent.position','t_agent.education','t_agent.nativeplace','t_agent.skill','t_agent.addedservice','t_agent.majordistrict','t_agent.businesscard'])->where(['t_user.id'=>$userid])->leftjoin('t_agent','t_user.id = t_agent.userid')->asArray()->one();
        $q = 0;
        foreach ($userInfo as $value) {
            if(trim($value)){
                $q++;
            }
        }

        //'zmcredit',暂不用
        return round($q*100/16);
    }


    public static function getColleague($obj){
    	$data = static::findOne(['userid'=>$obj->userid]);
        // return static::find()->from('v_agent')->where(['like','organization',$data->organization])->andwhere(['<>', 'userid',$obj->userid])->asArray()->all();
        $so = \scws_new();
        $so->set_charset('utf8');
        $so->set_dict('../../common/utils/dict.txt',SCWS_XDICT_TXT );
        $so->set_rule('../../common/utils/rules.ini');
        $so->send_text($data->organization);
        Yii::error("fenci obj is : $data->organization\n");
        $tmp = $so->get_result();
        Yii::error("fenci obj is : ".print_r($tmp,1)."\n");
        // print_r($tmp);
        $key=array("链家","中原","爱屋吉屋","21世纪","Q房网","汉宇","创林","房天下","福美来","好年华","沪联","慧邦","吉家","菁英","瑞阳","太平洋","易居臣信","志远","中联","住商","爱上租","保源","创盈","春翔","鼎铭","房多多","房好多",
            "房友","福人居","合富","华义","金丰易居","金色家园","锦明","九间伴","聚家","丽兹行","玛雅","美联","品信","瑞鹏","申康","顺昌","信义","易轩","永轩","远景","智恒","中正","众佑","我爱我家","佳歆","京科","云房","云燕","悟空","华知居","拓客多","伟叠","开宏","第一别墅","富顺","杰尚","金管家","立好信","六星","明明","平安好房","先原","宅福","彰荣","中居","中佑","锦锐");
        $num = count($tmp);
        for($i=0; $i<$num; $i++){
            Yii::error("fenci ".$tmp[$i]['word']."!\n");
            if(in_array($tmp[$i]['word'], $key)){
                Yii::error("$tmp[$i]['word'] match!\n");
                return static::find()->from('v_agent')->where(['like','organization',$tmp[$i]['word']])->andwhere(['<>', 'userid',$obj->userid])->asArray()->all();
            }
        }
        $so->close();
        return $res;
    }


    public static function getNearColleague($obj){
        $data = User::find()->select(['t_user.activeregion','t_agent.organization'])->leftjoin('t_agent','t_user.id = t_agent.userid')->where(['userid'=>$obj->userid])->asArray()->one();

        $activeregion = explode(',',$data['activeregion']);
        $first =static::find()->from('v_agent')->where(['organization'=>$data['organization']]);
        $count = count($activeregion);
        if($count > 1){
            foreach ($activeregion as $value) {
                $where[] = "find_in_set('".$value."',activeregion)";
            }
            $andwhere = implode(' or ', $where);
            return $first->andwhere($andwhere)->andwhere(['<>', 'userid',$obj->userid])->asArray()->all();
            // $a = $first->andwhere($andwhere)->andwhere(['<>', 'userid',$obj->userid])->asArray()->createCommand();
            // return ['sql'=>$a->sql];
        }else{
            if($count){
                // $a = $first->andwhere("find_in_set('$activeregion[0]',activeregion)")->andwhere(['<>', 'userid',$obj->userid])->asArray()->createCommand();
                // return ['sql'=>$a->sql];
                return $first->andwhere("find_in_set('$activeregion[0]',activeregion)")->andwhere(['<>', 'userid',$obj->userid])->asArray()->all();
            }else{
                return [];
            }
            
        }
        
    }

    public static function getCompetitor($obj){
    	$data = static::findOne(['userid'=>$obj->userid]);
    	return static::find()->from('v_agent')->where(['majordistrict'=>$data->majordistrict])->andwhere(['<>', 'userid',$obj->userid])->asArray()->all();
    }

    public static function getMyestateStatistics($obj){
    	return ['estatecnt'=>0,'estateinfolist'=>[]];
    }

    public static function updateAllAgentDataCompleterate()
    {
        //echo "Agent::updateAllAgentDataCompleterate\n";
        $agents = static::find()->where(['validflag' => 1])->orderBy('id')->asArray()->all();
        //echo "Agent are : ".print_r($agents,1)."\n";

        foreach ($agents as $agent) {
           self::updateAgentDataCompleterate($agent['userid']);
        }
        
        return ['rscode'=>0];
    }

    public static function updateAgentDataCompleterate($userid)
    {
        //echo "Agent::updateAgentDataCompleterate\n";
        if($model = static::find()->where(['userid'=>$userid])->one())
        {
            $datacompleterate = self::getAgentDataCompleterate($userid);
            $model->datacompleterate = $datacompleterate;
            $model->save();
        }
    }

    // 首页插条 Homepage/index.html 推荐80%以上资料的经纪人
    static function getTjjr(){
        $info = [];
        $notIn = ['10038','10037','10039','10040','12610','10145'];
        for($i=0;$i<=6;$i++){
            $one = static::find()->select('t1.*,t_agent.*,t_user.nickname,t_user.picture')->from('`t_mission` AS t1  JOIN (SELECT ROUND(RAND() * ((SELECT MAX(id) FROM `t_mission`)-(SELECT MIN(id) FROM `t_mission`))+(SELECT MIN(id) FROM `t_mission`)) AS id) AS t2')->leftjoin('t_agent','t_agent.userid = t1.userid')->leftjoin('t_user','t_user.id = t1.userid')->where('t1.id >= t2.id and t1.mid=1')->andwhere(['not in','t1.userid',$notIn])->orderBy(['t1.id'=>SORT_ASC])->limit(1)->asArray()->one();
                array_push($notIn,$one['userid']);
                array_push($info, $one);
        }
        return $info;
    }
}

?>