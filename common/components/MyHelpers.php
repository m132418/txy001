<?php
namespace common\components;
use Yii;
class MyHelpers
{

    public static function re_sort_arr_key($array)
    {
        if (empty($array)) {
            return $array;
        }
        while ($value = current($array)) {
            $arr[] = $value;
            next($array);
        }
        return ($arr);
    }
    
    
    public static function future_time_point($ttype,$tspan,$kickoff_at)
    {
        $date1 = date('Y-m-d',$kickoff_at) ;
        $target_date = null ;
        switch ($ttype) {
            case 1: // 86400); //60s*60min*24h 
            $target_date =   date('Y-m-d',strtotime("$date1 +$tspan day"));
            break;
            case 2:// 86400); //60s*60min*24h*7 
                $target_date =   date('Y-m-d',strtotime("$date1 +$tspan*7 day"));
                break;
                case 3:
                     $target_date =   date('Y-m-d',strtotime("$date1 +$tspan month"));
                    break;
            
            default:
                ;
            break;
        }
        return $target_date ;
    }
    
    
    public static function future_time_point_unixtime($ttype,$tspan,$kickoff_at)
    {
        $date1 = date('Y-m-d',$kickoff_at) ;
        $target_date = null ;
        switch ($ttype) {
            case 1: // 86400); //60s*60min*24h
                $target_date =  strtotime("$date1 +$tspan day");
                break;
            case 2:// 86400); //60s*60min*24h*7
                $target_date =  strtotime("$date1 +$tspan*7 day");
                break;
            case 3:
                $target_date =   strtotime("$date1 +$tspan month");
                break;
    
            default:
                ;
                break;
        }
        return $target_date ;
    }
    
    public static function deposit_time_progress($ttype,$tspan,$kickoff_at,$now_time)
    {
        
        $target_date = self::future_time_point_unixtime($ttype, $tspan, $kickoff_at) ;
        
        if (($now_time >= $kickoff_at) && ($target_date >= $kickoff_at)) 
        {
            $progress   = ($now_time - $kickoff_at ) / ($target_date - $kickoff_at) ;            
            return $progress ;
        }
        else 
            return -1 ;
        
      
    }
    
    
    //天数之间相减
    public static function timeDays($startTime,$endTime)
    {
        $startTimeDay = strtotime(date('Y-m-d',$startTime));
        $endTimeDay = strtotime(date('Y-m-d',$endTime));
        $days=ceil(($endTimeDay-$startTimeDay)/86400); //60s*60min*24h
        if($days < 0) $days = 0;
        return $days;
    }

    public static function gen_random_cd($length)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i ++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public static function gen_random_num_cd($length)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i ++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public static  function login_check($param) {
               
        $data_string = json_encode($param);        
        $ch = curl_init('http://apps.quandouyou.wang/module1/usergate/chkuser');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string)
        ));        
        $out = curl_exec($ch);        
        curl_close($ch);
      $rtn_data  = json_decode($out) ;
     return $rtn_data;
    }
    
    public static function check_vcd($param) {

        $re = Yii::$app->params['pubk1'] ;
        return md5($re . $param) ;
       
    }
    /**
     * MyHelpers::log("log.txt", Yii::$app->session);
     * @param unknown $filename
     * @param unknown $var
     */
    public static function log($filename , $var){
         file_put_contents($filename,var_export($var , true),FILE_APPEND);
        file_put_contents($filename, "\r\n",FILE_APPEND);
    }
    
}