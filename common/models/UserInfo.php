<?php
namespace common\models;
use Yii;
use yii\helpers\ArrayHelper ;
/**
 * This is the model class for table "user_info".
 *
 * @property integer $id
 * @property string $phonenumber
 * @property string $email
 * @property string $user_name
 * @property string $password
 * @property string $pastime
 * @property integer $status
 * @property integer $vip
 * @property string $expire_time
 * @property string $last_login
 * @property string $create_time
 */
class UserInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_info';
    }
    
    private static  $_data ;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phonenumber', 'email', 'user_name', 'password', 'pastime'], 'required'],
            [['status', 'vip'], 'integer'],
            [['expire_time', 'last_login', 'create_time'], 'safe'],
            [['phonenumber'], 'string', 'max' => 11],
            [['email', 'user_name'], 'string', 'max' => 64],
            [['password', 'pastime'], 'string', 'max' => 32],
            [['user_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phonenumber' => 'Phonenumber',
            'email' => 'Email',
            'user_name' => 'User Name',
            'password' => 'Password',
            'pastime' => 'Pastime',
            'status' => 'Status',
            'vip' => 'Vip',
            'expire_time' => 'Expire Time',
            'last_login' => 'Last Login',
            'create_time' => 'Create Time',
        ];
    }
    public static function ref_lebels ($id = null)
    {
//         $data =ArrayHelper::map( self::find()->asArray()->all() , 'id','user_name') ;
//         if ($id !== null && isset($data[$id])) {
//             return $data[$id];
//         } else {
//             return $data;
//         }
       if (static::$_data) {
           ;
       }else 
        static::$_data =ArrayHelper::map( self::find()->orderBy("user_name")->asArray()->all() , 'id','user_name') ;
       
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
