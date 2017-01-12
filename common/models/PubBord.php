<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pub_bord".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 */
class PubBord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pub_bord';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '题目',
            'content' => '内容',
        ];
    }
}
