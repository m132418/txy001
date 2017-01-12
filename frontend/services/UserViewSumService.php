<?php
namespace frontend\services;
use Yii ;
use common\models\Card;
class UserViewSumService
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

    public static function sum_user_in_cash_score($uid)
    {
        
        
      $sum_in_money_sql = 
      "SELECT FROM_UNIXTIME(created_at, '%Y-%m') x , SUM(howmany) amt FROM `order` where is_payed =1 and whose = ".$uid .
      " GROUP BY FROM_UNIXTIME(created_at, '%Y-%m') order by created_at"
         ;

      $sum_in_money_sql_result = static::q_with_native_sql($sum_in_money_sql)->queryAll() ;
 
      return [$sum_in_money_sql_result   ];
    }
    public static function sum_user_score($uid)
    {
    
    
        $sum_in_money_sql =
        "SELECT FROM_UNIXTIME(created_at, '%Y-%m') x , SUM(`value`) amt FROM score WHERE score.bindto = 1 GROUP BY FROM_UNIXTIME(created_at, '%Y-%m')  order by created_at"        
            ;
    
            $sum_in_money_sql_result = static::q_with_native_sql($sum_in_money_sql)->queryAll() ;
    
            return [$sum_in_money_sql_result   ];
    }
       
    

}

?>