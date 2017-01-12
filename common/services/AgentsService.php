<?php
namespace common\services;
use Yii ;
// use yii\base\Exception;
use common\components\MyHelpers;
class AgentsService
{
    public static  function compute_agents_level($uid,$level)
    {
        $i = 1 ;
        $con= Yii::$app->db ;
    
        while ($i==1) {
           MyHelpers::log("log.txt", $i);
           MyHelpers::log("log.txt", $level);           
             $i =  self::pra_loop($uid, $level,$con);
             $level++ ;
        }
         
        
    }
 private static function pra_loop($uid, $level,$con)
    {
        $sum_now_in_money_sql = "SELECT IFNULL(SUM(value),0) FROM score where bindto =".$uid ;
        $next_level_point_sql = "SELECT set_point FROM ref_agents where id = " . ($level +1) ;       
        
            $sum_now_in_money = $con
            ->createCommand($sum_now_in_money_sql)->queryScalar();
            $next_level_point = $con
            ->createCommand($next_level_point_sql)->queryOne();
            MyHelpers::log("log.txt", $sum_now_in_money_sql);
            MyHelpers::log("log.txt", $next_level_point_sql);  
            if ($next_level_point["set_point"])
                ; 
                else                    
                return -1;
                MyHelpers::log("log.txt", $sum_now_in_money);
                MyHelpers::log("log.txt", $next_level_point["set_point"]);
        if ((int)$sum_now_in_money >= (int)$next_level_point["set_point"]) {            
            // increase one level in session
            $a =Yii::$app->session['user'] ;
            $a["level"]= Yii::$app->session['user']["level"]+1 ;
            Yii::$app->getSession()->set("user", $a);
            $update_sql ="update user set level = level+1 where id=" . $uid ;
            $con
            ->createCommand($update_sql)->execute();
            return 1 ;
        }else 
            return -1 ;
    }

}

?>