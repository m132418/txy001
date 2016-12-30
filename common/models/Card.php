<?php
namespace common\models;
use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "card".
 *
 * @property integer $id
 * @property string $sn
 * @property integer $refapp
 * @property integer $status
 * @property integer $period
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $bind_at
 * @property integer $bind_uid
 * @property integer $whoissue
 */
class Card extends \yii\db\ActiveRecord
{
    const STATUS_CREATED = 1;
    const STATUS_USED = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'card';
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['refapp', 'status', 'period',  'created_at', 'updated_at', 'bind_at', 'bind_uid','whoissue'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_CREATED],
            ['status', 'in', 'range' => [self::STATUS_CREATED, self::STATUS_USED]],
            [['sn'], 'string', 'max' => 255],
            ['refapp','check_in_range']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sn' => '序列号',
            'refapp' => '参照系统',
            'status' => '状态',
            'period' => '时长',
            'created_at' => '创建于',
            'updated_at' => 'Updated At',
            'bind_at' => '使用于',
            'bind_uid' => '使用用户',
        ];
    }

    public static function ref_status_lebels($id = null)
    {
        $data = [
            self::STATUS_CREATED => "未使用",
            self::STATUS_USED => "已使用"
        ];

        if ($id !== null && isset($data[$id])) {
            return $data[$id];
        } else {
            return $data;
        }
    }
    public static function ref_period_lebels($id = null)
    {
        $data = [
            1 => "年",            2 => "半年",
            3 => "季",            4 => "月",
        ];

        if ($id !== null && isset($data[$id])) {
            return $data[$id];
        } else {
            return $data;
        }
    }
    public function check_in_range($attribute,$params){

      $ref =  RefApp::findOne(['id'=>$this->refapp]) ;

        if(!$ref ){
            $this->addError($attribute, '参照系统超出范围了');
        }
    }
}
