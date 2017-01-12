<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "score".
 *
 * @property integer $id
 * @property integer $value
 * @property integer $add_type
 * @property integer $bindto
 * @property integer $ord
 * @property integer $created_at
 * @property integer $updated_at
 */
class Score extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'score';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'add_type', 'bindto', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => '分值',
            'add_type' => '积分类型',
            'bindto' => '绑定于',
            'created_at' => '创建于',
            'updated_at' => '更改于',
        ];
    }
}
