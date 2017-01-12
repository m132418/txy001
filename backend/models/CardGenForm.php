<?php
namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class CardGenForm extends Model
{
    public $amt;
    public $uid;
    public $period ;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['amt', 'uid' , 'period'], 'required'],
            ['amt', 'integer'],

        ];
    }




}
