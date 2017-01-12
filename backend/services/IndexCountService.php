<?php
namespace backend\services;
use Yii ;
use common\models\Card;
class IndexCountService
{

    public static function q_with_native_sql($sql_in )
    {
        $db = \Yii::$app->db;
        $model = $db->createCommand($sql_in);
        return $model ;
//        $data = null ;
//        switch ($intype) {
//            case 1:
//                {
//                    $data= $model->queryAll();
//                }
//                break;
//
//            case 2:
//                {
//                     $data= $model->queryColumn($clumns); // array []
//                }
//                break;
//            case 3:
//                {
//                     $data= $model->queryOne();
//                }
//                break;
//            case 4:
//                {
//                     $data= $model->queryScalar();
//                }
//                break;
//           case 5:
//                {
//                     $data= $model->execute();
//                }
//                 break;
//
//            default:
//                ;
//                break;
//        }
//         var_dump($data) ;exit() ;
//        return  $data ;
    }
    public static function count_users()
    {
        if (Yii::$app->user->isGuest) return ;   
    
        $count_users_sql = "SELECT COUNT(1) FROM `user` where username not like 'appadmin' " ;
        $count_users_result = static::q_with_native_sql($count_users_sql)->queryScalar() ;    

        $count_users_tody_sql = "SELECT COUNT(1) FROM `user` where username not like 'appadmin' " 
            ." AND FROM_UNIXTIME(created_at, '%Y-%m-%d') = CURDATE()" ;
        $count_users_today_result = static::q_with_native_sql($count_users_tody_sql)->queryScalar() ;

        return [$count_users_result,$count_users_today_result];
    }

    public static function count_cards_all()
    {
        if (Yii::$app->user->isGuest) return ;
        
        
      $count_cards_not_used_sql = "SELECT COUNT(1) FROM card WHERE `status` = ". Card::STATUS_CREATED   ;
      $count_cards_not_used_result = static::q_with_native_sql($count_cards_not_used_sql)->queryScalar() ;
      $count_cards_used_sql = "SELECT COUNT(1) FROM card WHERE `status` = ". Card::STATUS_USED  ;
      $count_cards_used_result = static::q_with_native_sql($count_cards_used_sql)->queryScalar() ;
      return [$count_cards_not_used_result  , $count_cards_used_result ,$count_cards_not_used_result+$count_cards_used_result ];
    }
    public static function count_cards_today()
    {
        if (Yii::$app->user->isGuest) return ;
        $count_cards_not_used_sql = "SELECT COUNT(1) FROM card WHERE `status` = ". Card::STATUS_CREATED 
        ." AND FROM_UNIXTIME(created_at, '%Y-%m-%d') = CURDATE()" ;
        $count_cards_not_used_result = static::q_with_native_sql($count_cards_not_used_sql)->queryScalar() ;
        $count_cards_used_sql = "SELECT COUNT(1) FROM card WHERE `status` = ". Card::STATUS_USED 
        ." AND FROM_UNIXTIME(created_at, '%Y-%m-%d') = CURDATE()" ;
        $count_cards_used_result = static::q_with_native_sql($count_cards_used_sql)->queryScalar() ;
        return [$count_cards_not_used_result  , $count_cards_used_result ,$count_cards_not_used_result+$count_cards_used_result ];
    }
    public static function count_in_money_all()
    {
        if (Yii::$app->user->isGuest) return ;
        $count_cards_not_used_sql = "SELECT IFNULL(SUM(howmuch) ,0) FROM `order` WHERE is_payed =1";
        $count_in_money_all_result = static::q_with_native_sql($count_cards_not_used_sql)->queryScalar() ;     
        
        $count_in_money_today = "SELECT IFNULL(SUM(howmuch) ,0) FROM `order` WHERE is_payed =1" 
        ." AND FROM_UNIXTIME(created_at, '%Y-%m-%d') = CURDATE()" ;
        $count_in_money_today_result = static::q_with_native_sql($count_in_money_today)->queryScalar() ;
        
        return [$count_in_money_all_result,$count_in_money_today_result  ];
    }
    

    
}

?>