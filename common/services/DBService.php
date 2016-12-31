<?php
namespace common\services;

class DBService
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
    /*
     *             1 => "年",            2 => "半年",
            3 => "季",            4 => "月",
     */
    public static function build_postpone_sql($period_type ,$id)
    {
        switch ($period_type){
            case 1:
                return "UPDATE user_info SET vip = 1 ,expire_time = DATE_ADD(expire_time,INTERVAL 1 YEAR) WHERE id = " . $id;
            case 2:
                return "UPDATE user_info SET vip = 1 ,expire_time = DATE_ADD(expire_time,INTERVAL 0.5 YEAR) WHERE id = " . $id;
            case 3:
                return "UPDATE user_info SET vip = 1 ,expire_time = DATE_ADD(expire_time,INTERVAL 0.25 YEAR) WHERE id = " . $id;
            case 4:
                return "UPDATE user_info SET vip = 1 ,expire_time = DATE_ADD(expire_time,INTERVAL 1 MONTH) WHERE id = " . $id;
            case 5:
                return "UPDATE user_info SET vip = 1 ,expire_time = DATE_ADD(expire_time,INTERVAL 1 DAY) WHERE id = " . $id;
        }
    }
}

?>