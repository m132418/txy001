<?php
namespace common\models;
use Yii;
use yii\helpers\ArrayHelper ;
/**
 * This is the model class for table "card_suite".
 *
 * @property integer $id
 * @property string $tname
 * @property string $desc
 * @property integer $req_level
 * @property integer $period
 * @property integer $price
 * @property integer $amount
 */
class CardSuite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    private static $_data;
    public static function tableName()
    {
        return 'card_suite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['id'], 'required'],
            [['id', 'req_level', 'price', 'period' , 'amount'], 'integer'],
            [['tname'], 'string', 'max' => 80],
            [['desc'], 'string', 'max' => 128],
            [['amount'], 'integer', 'min'=>10, 'max' => 100000 ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
//            'id' => 'ID',
            'tname' => '套餐名',
            'desc' => '描述',
            'period'=>'卡周期',
            'req_level' => '代理商级别',
            'price' => '价格',
            'amount' => '发卡量',
        ];
    }
    public static function ref_lebels ($id = null)
    {
        if (static::$_data==null) {
           static::$_data =ArrayHelper::map( self::find()->asArray()->all() , 'id','tname') ;   
        }
        
        if ($id !== null && isset(static::$_data[$id])) {
            return static::$_data[$id];
        } else {
            return static::$_data;
        }
    }
    public static function ref_lebel ($id)
    {
        $data = static::ref_lebels() ;
        if ($id !== null && isset($data[$id])) {
            return $data[$id];
        } else {
            return "-null-";
        }
        
    }

}
