<?php
//注册函数
 function FUNC_function($params, $smarty)
 {
     global $config;
     $siteconfig = include($config);
     $returndata = '';
     switch ($params['type']) {
         case 'url'://构造方式  /link/data
           if (empty($params['link'])) {
               $returndata = $siteconfig['siteurl'];
           } else {
               if ($siteconfig['is_static'] == 1) {//全静态
                   $returndata=$siteconfig['siteurl'].$params['link'];
               } elseif ($siteconfig['is_static'] == 2) {//半静态
                   $returndata=$siteconfig['siteurl'].'/index.php'.$params['link'];
               } else {//全动态
                   $dolink = explode('/', $params['link']);
                   $findkey = 0;
                   foreach ($dolink as $key=>$value) {
                       if (!empty($value)) {
                           if ($findkey == 0) {
                               $returndata=$siteconfig['siteurl'].'/index.php?ctrl='.$value;
                           } elseif ($findkey == 1) {
                               $returndata .='&action='.$value;
                           } else {
                               $returndata .= $findkey%2==0?'&'.$value:'='.$value;
                           }
                           $findkey++;
                       }
                   }
               }
           }
         break;
         default:
           $returndata = '调用你参数不足';
         break;

      }
     return $returndata;
 }
//$smarty->registerPlugin("function","OFUC", "FUNC_function");
//$smarty->registerPlugin("block","OBLC", "FUNC_block");
//注册函数
function FUNC_block($params, $content, $smarty, &$repeat, $template)
{
    if (isset($content)) {
        $lang = $params["lang"];
        // do some translation with $content
        return $translation;
    }
}
function getgoodscx($cost, $cxdata)
{
    $newarray = array('is_cx'=>0,'cost'=>$cost,'zhekou'=>10);
    if (!empty($cxdata)) {
        //   	goodscx
        $nowdate = date('Y-m-d', time());
        $nowtime = time();
        if ($nowtime > $cxdata['cxstarttime'] && $nowtime< $cxdata['ecxendttime']) {
            //在促销时间段
            $checktime = $nowtime-strtotime($nowdate);
            if ($checktime > $cxdata['cxstime1']  && $checktime < $cxdata['cxetime1']) {
                $newarray['cost'] = $cost*$cxdata['cxzhe']*0.01;
                $newarray['is_cx'] = 1;
                $newarray['zhekou'] = $cxdata['cxzhe']*0.1;

                //表示在促销
            } else {
                if ($checktime > $cxdata['cxstime2']  && $checktime < $cxdata['cxetime2']) {
                    //表示在促销
                    $newarray['cost'] = $cost*$cxdata['cxzhe']*0.01;
                    $newarray['is_cx'] = 1;
                    $newarray['zhekou'] = $cxdata['cxzhe']*0.1;
                }
            }
        }
    }
    return $newarray;
}
function is_mobile_request()
{
    $_SERVER['ALL_HTTP'] = isset($_SERVER['ALL_HTTP']) ? $_SERVER['ALL_HTTP'] : '';

    if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|iphone|ipad|ipod|android|xoom)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
        return true;
    }
    if ((isset($_SERVER['HTTP_ACCEPT'])) and (strpos(strtolower($_SERVER['HTTP_ACCEPT']), 'application/vnd.wap.xhtml+xml') !== false)) {
        return true;
    }

    if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
        return true;
    }
    if (isset($_SERVER['HTTP_PROFILE'])) {
        return true;
    }
    $mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
    $mobile_agents = array(
        'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
        'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
        'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
        'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
        'newt','noki','oper','palm','pana','pant','phil','play','port','prox',
        'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
        'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
        'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
        'wapr','webc','winw','winw','xda','xda-'
        );
    if (in_array($mobile_ua, $mobile_agents)) {
        return true;
    }

    if (strpos(strtolower($_SERVER['ALL_HTTP']), 'operamini') !== false) {
        return true;
    }
    if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'windows phone') !== false) {
        return true;
    }
    return false;
}
function error($type, $msg)
{
    logwrite($msg, 1);
}
function logwrite($msg, $checkflag = 1)
{
    /*写日志*/
    //时间   操作内容
    if ($checkflag == 1) {
        $nowdate = date('Y-m-d', time());
        if (!file_exists(hopedir.'log/'.$nowdate.'.php')) {//创建文件
            if (!is_dir(hopedir.'log')) {
                mkdir(hopedir.'log', 0777);
            }
            $fp = @fopen(hopedir.'log/'.$nowdate.'.php', 'w');
            @fclose($fp);
        }
        $file=fopen(hopedir.'log/'.$nowdate.'.php', "a+");
        $linsk = $_SERVER['REQUEST_URI'];
        $content = "时间:".date('Y-m-d H:i:s', time()).",".$linsk."描述:".$msg."\r\n";
        fwrite($file, $content);
        fclose($file);
    }
}

 function limitalert()
 {
     /* $tmsg = '您暂无权限设置,如有疑问请联系QQ：244115659  Tel：18539299239';
       echo '{"error":true,"msg":"'.$tmsg.'"}';
       exit;  */
 }
 /**
 * @param $lat1
 * @param $lng1
 * @param $lat2
 * @param $lng2
 * @return int
 */
function getDistance($lat1, $lng1, $lat2, $lng2){

    //将角度转为狐度

    $radLat1=deg2rad($lat1);//deg2rad()函数将角度转换为弧度

    $radLat2=deg2rad($lat2);

    $radLng1=deg2rad($lng1);

    $radLng2=deg2rad($lng2);

    $a=$radLat1-$radLat2;

    $b=$radLng1-$radLng2;

    $s=2*asin(sqrt(pow(sin($a/2),2)+cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)))*6378.137;

    return $s;

}
 /**
 * @param $lat1
 * @param $lng1
 * @param $lat2
 * @param $lng2
 * @param float $radius  星球半径
 * @return float
 */
function distance($lat1, $lng1, $lat2,$lng2,$radius = EARTH_RADIUS)
{
    $rad = floatval(M_PI / 180.0);

    $lat1 = floatval($lat1) * $rad;
    $lng1 = floatval($lng1) * $rad;
    $lat2 = floatval($lat2) * $rad;
    $lng2 = floatval($lng2) * $rad;

    $theta = $lng2 - $lng1;

    $dist = acos(sin($lat1) * sin($lat2) +
                cos($lat1) * cos($lat2) * cos($theta)
            );

    if ($dist < 0 ) {
        $dist += M_PI;
    }

    return $dist = $dist * $radius;
}
/**
* @desc 根据两点间的经纬度计算距离
* @param float $lat 纬度值
* @param float $lng 经度值
*/
function getDistance1($lat1, $lng1, $lat2, $lng2)
{
    $earthRadius = EARTH_RADIUS;

    /*
    Convert these degrees to radians
    to work with the formula
    */

    $lat1 = ($lat1 * pi() ) / 180;
    $lng1 = ($lng1 * pi() ) / 180;

    $lat2 = ($lat2 * pi() ) / 180;
    $lng2 = ($lng2 * pi() ) / 180;

    $calcLongitude = $lng2 - $lng1;
    $calcLatitude = $lat2 - $lat1;
    $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
    $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
    $calculatedDistance = $earthRadius * $stepTwo;

    return round($calculatedDistance);
}
function friendlyDate($sTime, $type = 'mohu', $alt = 'false')
{
    if (!$sTime) {
        return '';
    }
    //sTime=源时间，cTime=当前时间，dTime=时间差
    $cTime = time();
    $dTime = $cTime - $sTime;
    $dDay = ceil($dTime/3600/24);
    //$dDay     =   intval($dTime/3600/24);
    $dYear = intval(date('Y', $cTime)) - intval(date('Y', $sTime));
    //normal：n秒前，n分钟前，n小时前，日期
    if ($type == 'normal') {
        if ($dTime < 60) {
            if ($dTime < 10) {
                return '刚刚';    //by yangjs
            } else {
                return intval(floor($dTime / 10) * 10).'秒前';
            }
        } elseif ($dTime < 3600) {
            return intval($dTime / 60).'分钟前';
            //今天的数据.年份相同.日期相同.
        } elseif ($dYear == 0 && $dDay == 0) {
            //return intval($dTime/3600)."小时前";
            return '今天'.date('H:i', $sTime);
        } elseif ($dYear == 0) {
            return date('m月d日 H:i', $sTime);
        } else {
            return date('Y-m-d H:i', $sTime);
        }
    }elseif ($type == 'weixin'){
        //返回的时间
        $timeStr = "";
        //获取当前时间
        $addTime = explode(',', date('Y,n,j,w,a,h,i,y', $sTime));//年，月，日，星期，上下午，时，分
        $nowTime = explode(',', date('Y,n,j,w,a,h,i,y', $cTime));

        $dayPerMonthAddTime = getDayPerMonth($addTime[0]);
        $week = array(0=>"星期日",1=>"星期一",2=>"星期二",3=>"星期三",4=>"星期四",5=>"星期五",6=>"星期六");
        //如果时间差小于一天的,显示（上午 时间） / （下午 时间）
        if($addTime[0] == $nowTime[0] && $addTime[1] == $nowTime[1] && $addTime[2] == $nowTime[2]) {
            $timeStr .= $addTime[5] . ":" . $addTime[6];
        } else if(($addTime[0] == $nowTime[0] && $addTime[1] == $nowTime[1] && $addTime[2] == $nowTime[2]-1)
            || ($addTime[0] == $nowTime[0] && $nowTime[1]-$addTime[1] == 1 && $dayPerMonthAddTime[$addTime[1]] == $addTime[2] && $nowTime[2] == 1)
            || ($nowTime[0]-$addTime[0] == 1 && $addTime[1] == 12 && $addTime[2] == 31 && $nowTime[1] == 1 && $nowTime[2] == 1)) {
                //如果时间差在昨天,三种情况（同一月份内跨一天、月末跨越到月初、年末跨越到年初）显示格式：昨天 时:分 上午/下午
            $timeStr .= "昨天 " . $addTime[5] . ":" . $addTime[6] . " ";
        } else if(($addTime[0] == $nowTime[0] && $addTime[1] == $nowTime[1] && $nowTime[2] - $addTime[2] < 7)
            || ($addTime[0] == $nowTime[0] && $nowTime[1]-$addTime[1] == 1 && $dayPerMonthAddTime[$addTime[1]]-$addTime[2]+$nowTime[2] < 7
                || ($nowTime[0]-$addTime[0] == 1 && $addTime[1] == 12 && $nowTime[1] == 1 && 31-$addTime[2]+$nowTime[2] < 7))) { //如果时间差在一个星期之内的,也是三种情况，显示格式：星期 时:分 上午/下午

            $timeStr .= $week[$addTime[3]] . " " . $addTime[5] . ":" . $addTime[6];
        } else { //显示格式：月/日/年 时:分 上午/下午
            $timeStr .= $addTime[1] . "/" . $addTime[2] . "/" . $addTime[7] . " " . $addTime[5] . ":" . $addTime[6];
        }

        if($addTime[4] == "am") {
            $timeStr .= " 上午";
        } else if($addTime[4] == "pm") {
            $timeStr .= " 下午";
        }

        return $timeStr;
    }elseif ($type == 'mohu') {
        if ($dTime < 60) {
            return $dTime.'秒前';
        } elseif ($dTime < 3600) {
            return intval($dTime / 60).'分钟前';
        } elseif ($dTime >= 3600 && $dTime < 3600 * 24) {
            return intval($dTime / 3600).'小时前';
        } elseif ($dDay > 0 && $dDay <= 7) {
            return intval($dDay).'天前';
        } elseif ($dDay > 7 &&  $dDay <= 30) {
            return intval($dDay / 7).'周前';
        } elseif ($dDay > 30) {
            return intval($dDay / 30).'个月前';
        }
        var_dump($dDay);exit;
        //full: Y-m-d , H:i:s
    } elseif ($type == 'full') {
        return date('Y-m-d , H:i:s', $sTime);
    } elseif ($type == 'ymd') {
        return date('Y-m-d', $sTime);
    } else {
        if ($dTime < 60) {
            return $dTime.'秒前';
        } elseif ($dTime < 3600) {
            return intval($dTime / 60).'分钟前';
        } elseif ($dTime >= 3600 && $dDay == 0) {
            return intval($dTime / 3600).'小时前';
        } elseif ($dYear == 0) {
            return date('Y-m-d H:i:s', $sTime);
        } else {
            return date('Y-m-d H:i:s', $sTime);
        }
    }
}
function buildSn($prefix = ''){
    $out_trade_no = $prefix.'KJC'.date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    return $out_trade_no;
}
/**
 * 求两个日期之间相差的天数
 * (针对1970年1月1日之后，求之前可以采用泰勒公式)
 * @param string $day1
 * @param string $day2
 * @return number
 */
function diffBetweenTwoDays ($day1, $day2)
{
  $second1 = strtotime($day1);
  $second2 = strtotime($day2);

  if ($second1 < $second2) {
    $tmp = $second2;
    $second2 = $second1;
    $second1 = $tmp;
  }
  return ($second1 - $second2) / 86400;
}
