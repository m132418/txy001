<?php
namespace common\services;
use Yii ;
use common\components\MyHelpers;
use yii\base\Exception;
class CardService
{
    public static  function batch_gen_card($amt,$period,$uid)
    {
    
//         $uid = \Yii::$app->user->identity->id ;
        $t = time() ;
        $data =null ;
        for ($x = 1; $x <= $amt; $x++) {
            $data[$x-1] = [
            //                         'sn'=> 'T' .date('YmdHis') .  rand(100000,999999),
                'sn'=> 'T' .  MyHelpers::gen_random_num_cd(20) ,
                'refapp'=>1,
                'period'=>$period,
                'whoissue'=>$uid,
                'created_at'=>$t ,
                'updated_at'=>$t ,
                'isfree' =>1
            ] ;
        }
    
    
        $clomns = ['sn','refapp','period','whoissue','created_at' ,'updated_at','isfree'] ;
    
    
    
        try {
            $insertCount = Yii::$app->db->createCommand()
            ->batchInsert("card", $clomns, $data)
            ->execute();
        } catch (Exception $e) {
            return $amt ;
        }
         
        return $insertCount;
    }
}

?>