<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Account extends ActiveRecord
{
	public static function tableName()
    {
        return 't_account';
    }

    public static function getAccount($jsonObj)
    {
        return static::find()->where(['userid'=>$jsonObj->userid,'usertype'=>$jsonObj->usertype])->asArray()->one();
    }


    public static function getAccountDetail($jsonObj)
    {
        return AccountDetail::getAccountDetail($jsonObj->userid,$jsonObj->usertype,$jsonObj->count,$jsonObj->start);
    }


    public static function applyDrawed($jsonObj)
    {
        $transaction = Yii::$app->db->beginTransaction(); 
        try{

            $withdraw_cash=new WithDrawCash();
            $withdraw_cash->userid=$jsonObj->userid;
            $withdraw_cash->usertype=$jsonObj->usertype;
            $withdraw_cash->amount=$jsonObj->account;
            $withdraw_cash->createtime=date('y-m-d H:i:s',time());
            $withdraw_cash->updatetime=date('y-m-d H:i:s',time());
            $withdraw_cash->status=1;
            $withdraw_cash->validflag=1;
            Yii::error("withdraw_cash is ".print_r($withdraw_cash,1)."\n");
            $withdraw_cash->save();


            $withdraw_cash_status=new WithDrawCashStatus();
            $withdraw_cash_status->withdrawcashid=$withdraw_cash->attributes['id'];
            $withdraw_cash_status->status=1;
            $withdraw_cash_status->statustime=date('y-m-d H:i:s',time());
            

            switch($jsonObj->usertype)
            {
                case 1:
                    Yii::error("userid is : ".$jsonObj->userid."\n");
                    $user=User::findOne($jsonObj->userid);
                    if ($user === null) {
                        Yii::error("userid ".$jsonObj->userid." not found in t_user\n");
                        $arr['rscode']=1;
                        return $arr;
                    }else{
                        $withdraw_cash_status->operatename=$user->nickname;
                    }
                    break;
                case 2:
                    $expert=Expert::findOne($jsonObj->userid);
                    if ($expert === null) {
                        Yii::error("userid ".$jsonObj->userid." not found in t_expert\n");
                        $arr['rscode']=1;
                        return $arr;
                    }else{
                        $withdraw_cash_status->operatename=$expert->name;
                    }
                    break;
                default:
                    Yii::error("usertype error, usertype is : ".$jsonObj->usertype."\n");
                    $arr['rscode']=1;
                    return $arr;
            }
            //Yii::error("withdraw_cash_status is ".print_r($withdraw_cash_status,1)."\n");
            $withdraw_cash_status->save();

            $account_detail=new AccountDetail();
            $account_detail->userid=$jsonObj->userid;
            $account_detail->usertype=$jsonObj->usertype;
            $account_detail->sumdate=date("Ymd");
            $account_detail->accounttype=20;
            $account_detail->servicetype=2004;
            $account_detail->originalfee=$jsonObj->account;
            $account_detail->actualfee=$jsonObj->account;
            $account_detail->subject='微信提现';
            $account_detail->ordertype=4;
            $account_detail->orderid=$withdraw_cash->attributes['id'];
            $account_detail->createtime=date('y-m-d H:i:s',time());
            // Yii::error("account_detail is ".print_r($account_detail,1)."\n");
            $account_detail->save();

            $account=static::find()->where(['userid' => $jsonObj->userid])->one();
            if ($account === null) {
                Yii::error("userid ".$jsonObj->userid." not found in t_account\n");
                $arr['rscode']=1;
                return $arr;
            }
            
            $account->remainedprofit=$account->remainedprofit-$jsonObj->account;
            $account->usedprofit=$account->usedprofit+$jsonObj->account;
            $account->lockingprofit=$account->lockingprofit+$jsonObj->account;
            $account->updatetime=date('y-m-d H:i:s',time());
            $account->save();

            $transaction->commit();
            $arr['rscode']=0;
            return $arr;
        }catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Account::applyDrawed error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }


    public static function payUseZmzfangaccount($jsonObj)
    {
        $transaction = Yii::$app->db->beginTransaction();
        try{

            Yii::error("payUseZmzfangaccount 0001");
            $account_detail=new AccountDetail();
            $account_detail->userid=$jsonObj->userid;
            $account_detail->usertype=$jsonObj->usertype;
            $account_detail->sumdate=date("Ymd");
            $account_detail->accounttype=20;
            $account_detail->servicetype=$jsonObj->servicetype;
            $account_detail->originalfee=$jsonObj->fee;
            $account_detail->actualfee=$jsonObj->fee;
            $account_detail->subject=$jsonObj->subject;
            $account_detail->ordertype=$jsonObj->ordertype;
            $account_detail->orderid=$jsonObj->orderid;
            $account_detail->createtime=date('y-m-d H:i:s',time());
            Yii::error("payUseZmzfangaccount 0002");
            $account_detail->save();
            Yii::error("payUseZmzfangaccount 0003");

            $account=static::find()->where(['userid' => $jsonObj->userid])->one();
            if ($account === null) {
                Yii::error("userid ".$jsonObj->userid." not found in t_account\n");
                $arr['rscode']=1;
                return $arr;
            }
            Yii::error("payUseZmzfangaccount 0004");
            $account->remainedprofit=$account->remainedprofit-$jsonObj->fee;
            $account->usedprofit=$account->usedprofit+$jsonObj->fee;
            $account->updatetime=date('y-m-d H:i:s',time());
            $account->save();

            $expert_appointment_status=new ExpertAppointmentStatus();
            $to_expert_id;
            
            Yii::error("payUseZmzfangaccount 0005");
            switch($jsonObj->ordertype)
            {
                case 1:
                {
                    $expert_appointment=ExpertAppointment::find()->where(['id'=>$jsonObj->orderid,'validflag'=>1])->one();
                    if ($expert_appointment === null) {
                        Yii::error("orderid ".$jsonObj->orderid." not found in t_expert_appointment\n");
                        $arr['rscode']=1;
                        return $arr;
                    }
                     Yii::error("payUseZmzfangaccount 1001");
                    $expert_appointment->status=1;
                     Yii::error("payUseZmzfangaccount 1002");
                    $expert_appointment_status->orderstatus=1;
                    break;
                }
                case 2:
                {
                    $expert_appointment=ExpertAppointment::find()->where(['id'=>$jsonObj->orderid,'validflag'=>1])->one();
                    if ($expert_appointment === null) {
                        Yii::error("orderid ".$jsonObj->orderid." not found in t_expert_appointment\n");
                        $arr['rscode']=1;
                        return $arr;
                    }
                    $expert_appointment->status=2;
                    $expert_appointment_status->orderstatus=2;
                    break;
                }
                case 3:
                {
                    $t_pay_question=PayQuestion::find()->where(['userid'=>$jsonObj->userid,'orderid'=>$jsonObj->orderid])->one();
                    $t_pay_question->status=1;
                    $t_pay_question->date=date('y-m-d H:i:s',time());
                    $t_pay_question->save();
                }
                default:
                    Yii::error("ordertype error, ordertype is : ".$jsonObj->ordertype."\n");
                    $arr['rscode']=1;
                    return $arr;
            }                
            Yii::error("payUseZmzfangaccount 0006");
            $expert_appointment->paytype=2;
            $to_expert_id = $expert_appointment->expertid;
            $from_user_id = $expert_appointment->userid;
            $expert_appointment->updatetime=date('y-m-d H:i:s',time());
            $expert_appointment->save();

            
            $expert_appointment_status->orderid=$jsonObj->orderid;
            Yii::error("payUseZmzfangaccount 0007");
            $expert_appointment_status->statustime=date('y-m-d H:i:s',time());
            switch($jsonObj->usertype)
            {
                case 1:
                    $user=User::findOne($jsonObj->userid);
                    if ($user === null) {
                        Yii::error("userid ".$jsonObj->userid." not found in t_user\n");
                        $arr['rscode']=1;
                        return $arr;
                    }else{
                        $expert_appointment_status->operator=$user->nickname;
                    }
                    break;
                case 2:
                    $expert=Expert::findOne($jsonObj->userid);
                    if ($expert === null) {
                        Yii::error("userid ".$jsonObj->userid." not found in t_expert\n");
                        $arr['rscode']=1;
                        return $arr;
                    }else{
                        $expert_appointment_status->operator=$expert->name;
                    }
                    break;
                default:
                    Yii::error("usertype error, usertype is : ".$jsonObj->usertype."\n");
                    $arr['rscode']=1;
                    return $arr;
            }
            Yii::error("payUseZmzfangaccount 0008");
            $expert_appointment_status->save();

            //  start 模板消息  
            $ExpertInfo=\frontend\models\Expert::find()->select('name,userid')->where(['id'=>$to_expert_id])->asArray()->one(); 
            $toUserInfo=User::find()->where(['id'=>$ExpertInfo['userid']])->asArray()->one();

            $fromUserInfo=User::find()->where(['id'=>$from_user_id])->asArray()->one();
            $fromNickname='系统通知';
            $url='http://www.zmzfang.com/?r=door/scope&view=Expert/Mine/AppointmentMeList';
            
            $content = "点击下方查看详情";
            $first = '您好,'.$ExpertInfo['name'].'专家，您的客户'.$fromUserInfo['nickname'].'已付款。请尽快跟进！';
            $template['template_id'] = '8ECirb_XZvyWNoWJ1_zlpCQoU9N5nOC18E6OAxY8E2A';
            $columns = ['first','keyword1','keyword2','keyword3'];
            $str = [$first,$fromNickname,date('Y-m-d H:i:s',time()),$content];
            $col = [];

            foreach($columns as $key => $value){
                $template['data'][$value]['value'] = $str[$key];
                if(count($col)){
                    $template['data'][$value]['color'] = $col[$key];
                }
            }
            $template['touser'] = $toUserInfo['wxopenid'];
            $template['url']    = $url;
            
            if(!empty($toUserInfo['wxopenid'])){
                $Wechatmodel = new \common\models\Wechat();
                $res = $Wechatmodel -> sendTemplateMessage($template);
            }else{
                $res =[];
            }
                // end 模板消息

            $transaction->commit();
            $arr['rscode']=0;
            return $arr;
        }catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error("Account::payUseZmzfangaccount error is ".$e->getMessage()."\n");
            $arr['rscode']=1;
            return $arr;
        }
    }


    public static function getApplyDrawedList($jsonObj)
    {
        return WithDrawCash::find()->where(['userid'=>$jsonObj->userid,'usertype'=>$jsonObj->usertype])
        ->limit($jsonObj->count)->offset($jsonObj->start)->orderBy('updatetime DESC')->asArray()->all();
    }
    
    
}
