<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class BindUserInputForm extends Model
{

    public $username;
    public $cardsn;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'string','length' => [1, 64]],

        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function attributeLabels()
    {
        return [
            'cardsn' => '卡序号',
            'username' => '用户名',

        ];
    }
}
