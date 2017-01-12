<?php
namespace common\models;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $tel
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $level
 * @property string $password write-only password
 * @property string $xingming
 * @property string $qq
 * @property string $id_card
 * @property string $comp_misc 
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0; //
    const STATUS_ACTIVE = 10; 
    
    private static $_data_exclude_appadmin ;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
//             ['tel', 'unique', 'targetClass' => '\common\models\User', 'message' => '电话号唯一'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'comp_misc'], 'string', 'max' => 255],
//             [['auth_key'], 'string', 'max' => 32],
            [['tel', 'qq', 'id_card'], 'string', 'max' => 20],
            [['xingming'], 'string', 'max' => 80],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'created_at' => '创建于',
            'tel'=>'电话',
            'level' => '级别',
           'xingming' => '姓名',
           'qq' => 'QQ',
           'id_card' => '身份证号',
           'comp_misc' => '公司信息',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    
    public static function ref_lebels ()
    {
        
        $data =ArrayHelper::map( self::find()->asArray()->all() , 'id','username') ;       
            return $data;
        
    }
    public static function ref_lebels2 ()
    {
    
        $data =ArrayHelper::map( self::find()->asArray()->where(['not like', 'username', 'appadmin'])->orderBy('username')->all() , 'id','username') ;
        return $data;
    
    }
    public static function ref_lebels_exclude_appadmin ()
    {
//         if (static::$_data_exclude_appadmin) {
//           return static::$_data_exclude_appadmin  ;
//         }else 
//         {
//            static::$_data_exclude_appadmin =ArrayHelper::map( self::find()->where(['not like', 'username', 'appadmin'])->orderBy('username')->asArray()->all() , 'id','username') ;
//         }
        return ArrayHelper::map( self::find()->where(['not like', 'username', 'appadmin'])->orderBy('username')->asArray()->all() , 'id','username') ;
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
    public static function ref_lebel_exclude_appadmin ($id)
    {  $data = static::ref_lebels_exclude_appadmin() ;          
//         if ($id !== null && isset($data[$id])) {
//             return $data[$id];
//         } else {
//             return "-null2-";
//         }
              if ($id == null) {
                  return "-null-";
              }elseif ($data[$id] == null)
              {
                  $data = static::ref_lebels_exclude_appadmin() ; 
                  if ($data[$id]==null) {
                     return "-null3-" ;
                  }else 
                    return   $data[$id];
              }
              else 
                  return $data[$id] ;
    
    }
}
