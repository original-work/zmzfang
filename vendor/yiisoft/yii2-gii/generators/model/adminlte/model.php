<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>
<?php 


?>
namespace <?= $generator->ns ?>;
use Yii;

/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 *
<?php foreach ($tableSchema->columns as $column): ?>
 * @property <?= "{$column->phpType} \${$column->name}\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends \backend\models\BaseModel
{
    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }
<?php if ($generator->db !== 'db'): ?>

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }
<?php endif; ?>

    public function rules()
    {
        return [<?= "\n            " . implode(",\n            ", $rules) . "\n        " ?>];
    }

    public function attributeLabels()
    {
        return [
<?php foreach ($labels as $name => $label): ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
        ];
    }
<?php foreach ($relations as $name => $relation): ?>

    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
<?php if ($queryClassName): ?>
<?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * @inheritdoc
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif; ?>

  /**
     * 返回数据库字段信息，仅在生成CRUD时使用，如不需要生成CRUD，请注释或删除该getTableColumnInfo()代码
     * COLUMN_COMMENT可用key如下:
     * label - 显示的label
     * phpType 显示格式 date|Y-m-d H:i:s（时间戳转换,参数参照date函数） bool （布尔值 参数为真的时候的值 : 布尔值 参数为假的时候的值） select(从udc中提取显示值，udc输入请采用键值型)
     * inputType 控件类型, 暂时只支持text,hidden,select,editor  // radio,file,password,
     * isEdit   是否允许编辑，如果允许编辑将在添加和修改时输入
     * isSearch 是否允许搜索
     * isDisplay 是否在列表中显示
     * isOrder 是否排序
     * udc - udc code 数组，inputtype为select,checkbox,radio三个值时用到。
     * 必须含有主键，统一都是id
     */
    public function getTableColumnInfo(){
        return array(
        <?php
            foreach ($tableSchema->columns as $column){
                $allowNull = $column->allowNull == true ? 'true' : 'false';
                $autoIncrement = $column->autoIncrement == true ? '自增' : '非自增';
                $isPrimaryKey = $column->isPrimaryKey == true ? 'true' : 'false';
                $inputtype = $column->isPrimaryKey == true ? 'hidden' : 'text';
                $unsigned = $column->unsigned == true ? '无符号' : '有符号';
                $searchble = $column->isPrimaryKey == true ? 'true' : 'false'; // 默认下只有主键提供搜索
                $editable = $column->isPrimaryKey == true ? 'false' : 'true'; // 默认下主键不允许编辑
                //$defaultValue = $column->phpType == 'string' ? '"'.$column->defaultValue.'"' : $column->defaultValue;
                //字段精度  不予展示 'precision' => '{$column->precision}',
                //字段长度  不予展示 'size' => '{$column->size}',
                //枚举字段？ 不予展示 'enumValues' => ". json_encode($column->enumValues).",
                //字段类型？ 不予展示 'type' => '{$column->type}',
                //作用于精度中小数位？ 不予展示 'scale' => '{$column->scale}',
                //是否是主键 不予展示 'isPrimaryKey' => {$isPrimaryKey},
                echo '//'.$column->dbType.' '.$unsigned.' '.$autoIncrement."\n";
                echo "        '{$column->name}' => array(
                        'name' => '{$column->name}',
                        'allowNull' => {$allowNull},
                        'placeholder' => '{$column->comment}',
                        'defaultValue' => '$column->defaultValue',
                        'phpType' => '{$column->phpType}',
                        'label'=>\$this->getAttributeLabel('{$column->name}'),
                        'inputType' => '$inputtype',
                        'isEdit' => $editable,
                        'isSearch' => $searchble,
                        'isDisplay' => true,
                        'isSort' => true,
                        'udc'=>[],
                    ),\n\t\t" ;
             } 
         ?>
        );
        
    }
  /**
     * 返回数据表主键，仅在生成CRUD时使用，如不需要生成CRUD，请注释或删除该getTableKeyColumn()代码
     */
    //仅作用于单主键 联合主键未作处理 （因为controller层作了联合主键的处理，请勿使用联合主键 请勿使用联合主键 请勿使用联合主键！ 会造成bug！ 之后版本可能会处理）
    public function getTableKeyColumn(){
        <?php
            foreach ($tableSchema->columns as $column){
                if($column->isPrimaryKey == true){
                    $key = $column->name;
                    break;
                }
             }
              echo "return '$key';";
         ?>        
    }
 
}