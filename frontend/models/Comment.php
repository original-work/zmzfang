<?php
namespace frontend\models;

use Yii;
use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
	public static function tableName()
    {
        return 't_expert_comment';
    }

    public static function GetComment($jsonObj)
    {
        try{
                Yii::error("request is ".print_r($jsonObj,1)."\n");
                $sql=sprintf('SELECT * FROM t_expert_comment WHERE expertid=%s order by createtime desc LIMIT %s,%s', $jsonObj->expertid,$jsonObj->start,$jsonObj->count);
                Yii::error("sql is ".$sql."\n");
                $connection = Yii::$app->db;
                $command = $connection->createCommand($sql);
                $comment = $command->queryAll();
                
                $comment_count = count($comment);
                if($comment_count<1){
                    return;
                }

                for($i=0;$i<$comment_count;$i++){
                    $res[$i][userid]=$comment[$i][userid];
                    $res[$i][praisecnt]=$comment[$i][praisecnt];
                    $res[$i][comment]=$comment[$i][comment];
                    $res[$i][createtime]=$comment[$i][createtime];

                    $sql=sprintf('SELECT * FROM t_user WHERE id=%s', $res[$i][userid]);
                    Yii::error("sql is ".$sql."\n");
                    $command = $connection->createCommand($sql);
                    $user = $command->queryAll();
                    $res[$i][nickname]=$user[0][nickname];
                    $res[$i][picture]=$user[0][picture];
                    Yii::error("requirement[0] is ".print_r($requirement[0],1)."\n");
                }
                
                return $res;
            } catch(\Exception $e) {
                Yii::error("Comment::GetComment error is ".$e->getMessage()."\n");
                return $e->getMessage();
            }
    }



    public static function AddComment($jsonObj)
    {
        try{
                Yii::error("request is ".print_r($jsonObj,1)."\n");
                $comment = new Comment();
                $comment->expertid=$jsonObj->expertid;
                $comment->userid=$jsonObj->userid;
                $comment->comment=$jsonObj->comment;
                $comment->praisecnt=$jsonObj->praisecnt;
                $comment->createtime=date('y-m-d H:i:s',time());
                $comment->save();
                // $model = new \frontend\models\Expert();
                // $model->praisecnt = $jsonObj->praisecnt;
                // $model->save();
                $expert = \frontend\models\Expert::getExpertInfo($jsonObj->expertid);
                $expert->praisecnt += $jsonObj->praisecnt;
                $expert->save();
                
                $arr['rscode']=0;
                return $arr;
            } catch(\Exception $e) {
                Yii::error("Comment::AddComment error is ".$e->getMessage()."\n");
                return $e->getMessage();
            }
    }



    public static function DeleteComment($jsonObj)
    {
        try{
                Yii::error("request is ".print_r($jsonObj,1)."\n");
                $connection = Yii::$app->db;

                $comment_count=count($jsonObj->commentids);
                for($i=0;$i<$comment_count;$i++){
                    $sql=sprintf('DELETE FROM t_expert_comment WHERE expertid=%s AND id=%s', $jsonObj->expertid,$jsonObj->commentids[$i]);
                    Yii::error("sql is ".$sql."\n");
                    $command = $connection->createCommand($sql);
                    $comment = $command->execute();
                }
                
                $arr['rscode']=0;
                return $arr;
            } catch(\Exception $e) {
                Yii::error("Comment::DeleteComment error is ".$e->getMessage()."\n");
                return $e->getMessage();
            }
    }
    
    
}
