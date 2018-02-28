<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "t_organization_logo".
 *
 * @property integer $id
 * @property integer $organizationlogoid
 * @property string $organizationkey
 * @property string $organizationlogo
 * @property integer $pri
 * @property string $remark
 * @property string $detail
 * @property string $createtime
 * @property integer $validflag
 */
class OrgLogo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_organization_logo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['organizationlogoid', 'organizationkey', 'organizationlogo', 'pri', 'createtime', 'validflag'], 'required'],
            [['organizationlogoid', 'pri', 'validflag'], 'integer'],
            [['createtime'], 'safe'],
            [['organizationkey'], 'string', 'max' => 35],
            [['organizationlogo'], 'string', 'max' => 128],
            [['remark', 'detail'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'organizationlogoid' => 'Organizationlogoid',
            'organizationkey' => 'Organizationkey',
            'organizationlogo' => 'Organizationlogo',
            'pri' => 'Pri',
            'remark' => 'Remark',
            'detail' => 'Detail',
            'createtime' => 'Createtime',
            'validflag' => 'Validflag',
        ];
    }
}
