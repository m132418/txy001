<?php
namespace frontend\services;
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

    public static function count_cards_all($uid)
    {
        if (Yii::$app->user->isGuest) return ;
        
        
      $count_cards_not_used_sql = "SELECT COUNT(1) FROM card WHERE `status` = ". Card::STATUS_CREATED ." AND whoissue =" . $uid;
      $count_cards_not_used_result = static::q_with_native_sql($count_cards_not_used_sql)->queryScalar() ;
      $count_cards_used_sql = "SELECT COUNT(1) FROM card WHERE `status` = ". Card::STATUS_USED ." AND whoissue =" . $uid ;
      $count_cards_used_result = static::q_with_native_sql($count_cards_used_sql)->queryScalar() ;
      return [$count_cards_not_used_result  , $count_cards_used_result ,$count_cards_not_used_result+$count_cards_used_result ];
    }
    public static function count_cards_today($uid)
    {
        if (Yii::$app->user->isGuest) return ;
        $count_cards_not_used_sql = "SELECT COUNT(1) FROM card WHERE `status` = ". Card::STATUS_CREATED ." AND whoissue =" . $uid
        ." AND FROM_UNIXTIME(created_at, '%Y-%m-%d') = CURDATE()" ;
        $count_cards_not_used_result = static::q_with_native_sql($count_cards_not_used_sql)->queryScalar() ;
        $count_cards_used_sql = "SELECT COUNT(1) FROM card WHERE `status` = ". Card::STATUS_USED ." AND whoissue =" . $uid
        ." AND FROM_UNIXTIME(created_at, '%Y-%m-%d') = CURDATE()" ;
        $count_cards_used_result = static::q_with_native_sql($count_cards_used_sql)->queryScalar() ;
        return [$count_cards_not_used_result  , $count_cards_used_result ,$count_cards_not_used_result+$count_cards_used_result ];
    }
    public static function count_in_money_all($uid)
    {
        if (Yii::$app->user->isGuest) return ;
        $count_cards_not_used_sql = "SELECT IFNULL(SUM(howmuch) ,0) FROM `order` WHERE whose =" . $uid
        ." and is_payed =1";
        $count_cards_not_used_result = static::q_with_native_sql($count_cards_not_used_sql)->queryScalar() ;
    
        $count_in_money_today = "SELECT IFNULL(SUM(howmuch) ,0) FROM `order` WHERE whose =" . $uid
        ." and is_payed =1"
            ." AND FROM_UNIXTIME(created_at, '%Y-%m-%d') = CURDATE()" ;
        $count_in_money_today_result = static::q_with_native_sql($count_in_money_today)->queryScalar() ;
    
        return [$count_cards_not_used_result,$count_in_money_today_result  ];
    }
    public static function count_score_all($uid)
    {
        if (Yii::$app->user->isGuest) return ;
        $count_cards_not_used_sql = "SELECT IFNULL(SUM(value),0) FROM score where bindto =" . $uid 
        ;
        $count_cards_not_used_result = static::q_with_native_sql($count_cards_not_used_sql)->queryScalar() ;     
        
        $count_in_money_today = "SELECT IFNULL(SUM(value),0) FROM score where bindto =" . $uid        
        ." AND FROM_UNIXTIME(created_at, '%Y-%m-%d') = CURDATE()" ;
        $count_in_money_today_result = static::q_with_native_sql($count_in_money_today)->queryScalar() ;
        
        return [$count_cards_not_used_result,$count_in_money_today_result  ];
    }
    
    public static function retrieve_boards()
    {
      
    
        $boards_sql = "SELECT pub_bord.title,pub_bord.content FROM pub_bord"  ;
        $boards_result = static::q_with_native_sql($boards_sql)->queryAll() ;
        
        return $boards_result;
    }
    
}

?>