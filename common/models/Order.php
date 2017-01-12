<?php
namespace common\models;
use Yii;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $pay_suite
 * @property integer $howmany
 * @property integer $howmuch
 * @property integer $period 
 * @property integer $whose
 * @property integer $is_payed
 * @property integer $is_gen 
 * @property string $payed_sn
 * @property integer $channel
 * @property string $buyer_id 
 * @property string $buyer_email  
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $temp1
 * @property string $temp2  
 */
class Order extends \yii\db\ActiveRecord
{
    const ISPAIED_NOTYET = 0;
    const ISPAIED_DONE = 1;
    
    const CHANNEL_ALI = 1;
    const CHANNEL_WEIXIN = 2; 
       
    const IS_GEN_NOTYET = 0;
    const IS_GEN_DONE = 1;
    
    
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
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pay_suite', 'howmany', 'howmuch','period', 'whose', 'is_payed', 'channel', 'is_gen','created_at', 'updated_at'], 'integer'],
            [['payed_sn'], 'string', 'max' => 80],
            [['buyer_id', 'temp1', 'temp2'], 'string', 'max' => 20],
            [['buyer_email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pay_suite' => '套餐',
            'howmany' => '出卡量',
            'howmuch' => '应付金额',
            'period' => '冲入时长',
            'whose' => '谁支付的',
            'is_payed' => '是否已支付',
            'payed_sn' => '渠道SN',
            'channel' => '支付渠道',
            'channelname'=>'支付渠道名称',
            'buyer_id' => '支付宝id',
            'buyer_email' => '支付宝email',
            'created_at' => '创建于',
            'updated_at' => '更新于',
        ];
    }
    public function getPayed() {
       
        if ($this->is_payed == 0) {
            return "未支付";
        }elseif ($this->is_payed == 1)
        return "已支付";
    }
    public function getSuitename() {
     return   CardSuite::ref_lebel($this->pay_suite);
    }
    public function getCardsuite() {
        return   CardSuite::findOne($this->pay_suite);
    }
    public function getChannelname() {
        
        if ($this->channel == static::CHANNEL_ALI) {
         return "支付宝"   ;
        }elseif ($this->channel == static::CHANNEL_ALI){
            return "微信";
        }else 
            return  "未知" ;
        
        
    }
    public static function  ref_payed_channel(){
        return [
            1=>"支付宝",
            2=>"微信",
        ] ;
    }
}
