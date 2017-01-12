<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "op_log".
 *
 * @property integer $id
 * @property string $ipadd
 * @property string $opr
 * @property string $misc
 */
class OpLog extends \yii\db\ActiveRecord
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
        return 'op_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ipadd', 'opr'], 'string', 'max' => 20],
            [['misc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ipadd' => 'IP地址',
            'opr' => '操作',
            'misc' => '其他说明',
            'created_at'=> '创建于',
        ];
    }
}
