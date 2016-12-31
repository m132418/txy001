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
            'name' => 'Name',
            'desc' => 'Desc',
            'set_point' => 'Set Point',
        ];
    }

    public static function ref_lebels ($id = null)
    {
        $data =ArrayHelper::map( self::find()->asArray()->all() , 'id','name') ;

        if ($id !== null && isset($data[$id])) {
            return $data[$id];
        } else {
            return $data;
        }
    }
}
