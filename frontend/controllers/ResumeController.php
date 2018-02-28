<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\Resume;
use frontend\models\ResumeWork;
use frontend\models\ResumeEdu;

class ResumeController extends Controller
{
	public $enableCsrfValidation = false;

    public function actionAddResume()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Resume::addResume($obj);
        return json_encode($res);
    }

    public function actionModifyResume()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Resume::modifyResume($obj);
        return json_encode($res);
    }

    public function actionDeleteResume()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Resume::deleteResume($obj);
        return json_encode($res);
    }

    public function actionGetResume()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Resume::getResume($obj);
        return json_encode($res);
    }

    public function actionGetResumeByUserId()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Resume::getResumeByUserid($obj);
        return json_encode($res);
    }


    public function actionGetResumeDetail()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res['resumeinfo']=Resume::getResume($obj);
        $res['worklist']=ResumeWork::GetResumeWorkList($obj);
        $res['edulist']=ResumeEdu::GetResumeEduList($obj);
        return json_encode($res);
    }

    public function actionGetResumeListByRecruitid()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Resume::GetResumeListByRecruitid($obj);
        return json_encode($res);
    }

    public function actionGetResumeListUnhandled()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Resume::GetResumeListUnhandled($obj);
        return json_encode($res);
    }

    public function actionGetResumeListAll()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Resume::GetResumeListAll($obj);
        return json_encode($res);
    }


    public function actionGetRecruitListByResumeid()
    {
        $data=Yii::$app->request->rawBody;
        $obj = json_decode($data);
        $res=Resume::GetRecruitListByResumeid($obj);
        return json_encode($res);
    }

}

?>