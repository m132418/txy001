<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "ref_agents".
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property integer $set_point
 */
class RefAgents extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    private static $_data ;
    public static function tableName()
    {
        return 'ref_agents';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'set_point'], 'integer'],
            [['name'], 'string', 'max' => 20],
            [['desc'], 'string', 'max' => 120],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '级别名字',
            'desc' => '描述',
            'set_point' => '设置积分值',
        ];
    }

    public static function ref_lebels ($id = null)
    {
        if (static::$_data) {
            ;
        }else 
        {
            static::$_data =ArrayHelper::map( self::find()->asArray()->all() , 'id','name') ;
        }
        
        

        if ($id !== null && isset( static::$_data[$id])) {
            return  static::$_data[$id];
        } else {
            return  static::$_data;
        }
    }
}
