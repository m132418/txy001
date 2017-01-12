<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class ChgpwdForm extends Model
{

    public $password;
    public $password_repeat;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string','length' => [4, 20]],
            ['password', 'compare', 'compareAttribute' => 'password_repeat'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => '密码',
            'password_repeat' => '重复密码',
    
        ];
    }
}
