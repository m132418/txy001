<?php
namespace backend\services;
use common\models\OpLog ;
class TraceService
{
/* 
        $opra = (Yii::$app->controller->id . "/".   Yii::$app->controller->action->id);
        $ip = (Yii::$app->request->userIp) ;
 */    
    public static  function opra_log($opra, $ip ,$mis=NULL)
    {
        $op = new OpLog() ;
        $op->ipadd = $ip ;
        $op->opr = $opra ;
        if ($mis!== null) {
            $op->misc = $mis ;
        }
        
        $op->save(false) ;
    }
}

?>