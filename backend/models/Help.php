<?php
namespace backend\models;

use Yii;

/**
 * This is the model class for table "t_requirement_help".
 *
 * @property integer $helpid
 * @property integer $publishuserid
 * @property integer $publishusertype
 * @property integer $requirementtype
 * @property string $region
 * @property string $forhelpsubject
 * @property integer $level
 * @property string $forhelpdetail
 * @property integer $rewardflag
 * @property double $rewardfee
 * @property string $publishuserpaytime
 * @property integer $status
 * @property integer $replycnt
 * @property integer $adoptedreplyid
 * @property integer $adoptedreplyuserid
 * @property string $adopttime
 * @property string $adoptpaytime
 * @property string $updatetime
 * @property string $createtime
 * @property integer $validflag
 */
class Help extends \backend\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 't_requirement_help';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['publishuserid', 'publishusertype', 'requirementtype', 'region', 'forhelpsubject', 'forhelpdetail', 'rewardflag', 'status', 'replycnt', 'updatetime', 'createtime', 'validflag'], 'required'],
            [['publishuserid', 'publishusertype', 'requirementtype', 'level', 'rewardflag', 'status', 'replycnt', 'adoptedreplyid', 'adoptedreplyuserid', 'validflag'], 'integer'],
            [['rewardfee'], 'number'],
            [['publishuserpaytime', 'adopttime', 'adoptpaytime', 'updatetime', 'createtime'], 'safe'],
            [['region'], 'string', 'max' => 10],
            [['forhelpsubject'], 'string', 'max' => 64],
            [['forhelpdetail'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'helpid' => '求助需求ID，主键，自增长',
            'publishuserid' => '发布人id',
            'publishusertype' => '发布人类型，0表示普通用户，1表示经纪人',
            'requirementtype' => '需求类型，0表示普通求租，预留；',
            'region' => '区域id；',
            'forhelpsubject' => '求助主题',
            'level' => '求助紧急程度，1表示不紧急，2表示一般紧急，3紧急，4很紧急，5非常紧急；默认3',
            'forhelpdetail' => '求助描述；',
            'rewardflag' => '奖励标识，0不奖励，1奖励；默认为0',
            'rewardfee' => '奖励金额，单位元；当采纳用户帮助建议后，打入到用户微信零钱',
            'publishuserpaytime' => '发布人付款时间',
            'status' => '求助状态，0表示初始状态未支付，1表示已支付；2表示已采纳，3其他；',
            'replycnt' => '反馈记录条数，默认为0；',
            'adoptedreplyid' => '采纳的答复id',
            'adoptedreplyuserid' => '采纳的答复人用户id',
            'adopttime' => '采纳时间',
            'adoptpaytime' => '平台向答复人付款时间',
            'updatetime' => '最近一次更新时间',
            'createtime' => '创建时间',
            'validflag' => '有效标识，0表示无效，1表示有效；初始化为有效',
        ];
    }

  /**
     * 返回数据库字段信息，仅在生成CRUD时使用，如不需要生成CRUD，请注释或删除该getTableColumnInfo()代码
     * COLUMN_COMMENT可用key如下:
     * label - 显示的label
     * inputType 控件类型, 暂时只支持text,hidden  // select,checkbox,radio,file,password,
     * isEdit   是否允许编辑，如果允许编辑将在添加和修改时输入
     * isSearch 是否允许搜索
     * isDisplay 是否在列表中显示
     * isOrder 是否排序
     * udc - udc code，inputtype为select,checkbox,radio三个值时用到。
     * 特别字段：
     * id：主键。必须含有主键，统一都是id
     * create_date: 创建时间。生成的代码自动赋值
     * update_date: 修改时间。生成的代码自动赋值
     */
    public function getTableColumnInfo(){
        return array(
        'helpid' => array(
                        'name' => 'helpid',
                        'allowNull' => false,
//                         'autoIncrement' => true,
//                         'comment' => '求助需求ID，主键，自增长',
//                         'dbType' => "int(11)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => true,
                        'phpType' => 'integer',
                        'precision' => '11',
                        'scale' => '',
                        'size' => '11',
                        'type' => 'integer',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('helpid'),
                        'inputType' => 'hidden',
                        'isEdit' => true,
                        'isSearch' => true,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'publishuserid' => array(
                        'name' => 'publishuserid',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '发布人id',
//                         'dbType' => "int(11)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '11',
                        'scale' => '',
                        'size' => '11',
                        'type' => 'integer',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('publishuserid'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'publishusertype' => array(
                        'name' => 'publishusertype',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '发布人类型，0表示普通用户，1表示经纪人',
//                         'dbType' => "tinyint(4)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '4',
                        'scale' => '',
                        'size' => '4',
                        'type' => 'smallint',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('publishusertype'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'requirementtype' => array(
                        'name' => 'requirementtype',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '需求类型，0表示普通求租，预留；',
//                         'dbType' => "tinyint(4)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '4',
                        'scale' => '',
                        'size' => '4',
                        'type' => 'smallint',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('requirementtype'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'region' => array(
                        'name' => 'region',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '区域id；',
//                         'dbType' => "varchar(10)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '10',
                        'scale' => '',
                        'size' => '10',
                        'type' => 'string',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('region'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'forhelpsubject' => array(
                        'name' => 'forhelpsubject',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '求助主题',
//                         'dbType' => "varchar(64)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '64',
                        'scale' => '',
                        'size' => '64',
                        'type' => 'string',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('forhelpsubject'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'level' => array(
                        'name' => 'level',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '求助紧急程度，1表示不紧急，2表示一般紧急，3紧急，4很紧急，5非常紧急；默认3',
//                         'dbType' => "tinyint(4)",
                        'defaultValue' => '3',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '4',
                        'scale' => '',
                        'size' => '4',
                        'type' => 'smallint',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('level'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'forhelpdetail' => array(
                        'name' => 'forhelpdetail',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '求助描述；',
//                         'dbType' => "varchar(255)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '255',
                        'scale' => '',
                        'size' => '255',
                        'type' => 'string',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('forhelpdetail'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'rewardflag' => array(
                        'name' => 'rewardflag',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '奖励标识，0不奖励，1奖励；默认为0',
//                         'dbType' => "tinyint(4)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '4',
                        'scale' => '',
                        'size' => '4',
                        'type' => 'smallint',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('rewardflag'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'rewardfee' => array(
                        'name' => 'rewardfee',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '奖励金额，单位元；当采纳用户帮助建议后，打入到用户微信零钱',
//                         'dbType' => "double",
                        'defaultValue' => '0',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'double',
                        'precision' => '',
                        'scale' => '',
                        'size' => '',
                        'type' => 'double',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('rewardfee'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'publishuserpaytime' => array(
                        'name' => 'publishuserpaytime',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '发布人付款时间',
//                         'dbType' => "datetime",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '',
                        'scale' => '',
                        'size' => '',
                        'type' => 'datetime',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('publishuserpaytime'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'status' => array(
                        'name' => 'status',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '求助状态，0表示初始状态未支付，1表示已支付；2表示已采纳，3其他；',
//                         'dbType' => "tinyint(4)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '4',
                        'scale' => '',
                        'size' => '4',
                        'type' => 'smallint',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('status'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'replycnt' => array(
                        'name' => 'replycnt',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '反馈记录条数，默认为0；',
//                         'dbType' => "int(11)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '11',
                        'scale' => '',
                        'size' => '11',
                        'type' => 'integer',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('replycnt'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'adoptedreplyid' => array(
                        'name' => 'adoptedreplyid',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '采纳的答复id',
//                         'dbType' => "int(11)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '11',
                        'scale' => '',
                        'size' => '11',
                        'type' => 'integer',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('adoptedreplyid'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'adoptedreplyuserid' => array(
                        'name' => 'adoptedreplyuserid',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '采纳的答复人用户id',
//                         'dbType' => "int(11)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '11',
                        'scale' => '',
                        'size' => '11',
                        'type' => 'integer',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('adoptedreplyuserid'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'adopttime' => array(
                        'name' => 'adopttime',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '采纳时间',
//                         'dbType' => "datetime",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '',
                        'scale' => '',
                        'size' => '',
                        'type' => 'datetime',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('adopttime'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'adoptpaytime' => array(
                        'name' => 'adoptpaytime',
                        'allowNull' => true,
//                         'autoIncrement' => false,
//                         'comment' => '平台向答复人付款时间',
//                         'dbType' => "datetime",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '',
                        'scale' => '',
                        'size' => '',
                        'type' => 'datetime',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('adoptpaytime'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'updatetime' => array(
                        'name' => 'updatetime',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '最近一次更新时间',
//                         'dbType' => "datetime",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '',
                        'scale' => '',
                        'size' => '',
                        'type' => 'datetime',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('updatetime'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'createtime' => array(
                        'name' => 'createtime',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '创建时间',
//                         'dbType' => "datetime",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'string',
                        'precision' => '',
                        'scale' => '',
                        'size' => '',
                        'type' => 'datetime',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('createtime'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		'validflag' => array(
                        'name' => 'validflag',
                        'allowNull' => false,
//                         'autoIncrement' => false,
//                         'comment' => '有效标识，0表示无效，1表示有效；初始化为有效',
//                         'dbType' => "tinyint(4)",
                        'defaultValue' => '',
                        'enumValues' => null,
                        'isPrimaryKey' => false,
                        'phpType' => 'integer',
                        'precision' => '4',
                        'scale' => '',
                        'size' => '4',
                        'type' => 'smallint',
                        'unsigned' => false,
                        'label'=>$this->getAttributeLabel('validflag'),
                        'inputType' => 'text',
                        'isEdit' => true,
                        'isSearch' => false,
                        'isDisplay' => true,
                        'isSort' => true,
//                         'udc'=>'',
                    ),
		        );
        
    }
 
}