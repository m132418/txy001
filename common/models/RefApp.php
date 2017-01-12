<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ref_app".
 *
 * @property integer $id
 * @property string $appname
 * @property string $des
 */
class RefApp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ref_app';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['appname'], 'string', 'max' => 50],
            [['des'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'appname' => 'Appname',
            'des' => 'Des',
        ];
    }
}
