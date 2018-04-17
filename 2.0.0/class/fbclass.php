<?php

/**
 * @class baseclass
 * @描述   基础类
 */
class fbclass
{
    public $mysql;
    public function __construct()
    {
        $this->mysql =  new mysql_class();
    }




    public function checkadminlogin()
    {
        $link = IUrl::creatUrl('member/adminlogin');
        if ($this->admin['uid'] == 0) {
            $this->message('未登陆', $link);
        }
    }
    public function checkmemberlogin()
    {
        $link = IUrl::creatUrl('member/login');
        if ($this->member['uid'] == 0) {
            $this->message('未登陆', $link);
        }
    }
    public function checkshoplogin()
    {
        $link = IUrl::creatUrl('member/shoplogin');
        if ($this->member['uid'] == 0 && $this->admin['uid'] == 0) {
            $this->message('未登陆', $link);
        }
        $shopid = ICookie::get('adminshopid');
        if (empty($shopid)) {
            $this->message('未登陆', $link);
        }
    }
    public static function sqllink($where, $sqlkey, $sqlvalue, $fuhao)
    {
        if (empty($sqlvalue)) {
            return  $where;
        } else {
            if (empty($where)) {
                return  '`'.$sqlkey.'`'.$fuhao.'\''.$sqlvalue.'\'';
            } else {
                return $where.' and `'.$sqlkey.'`'.$fuhao.'\''.$sqlvalue.'\'';
            }
        }
    }
    public static function message($msg, $link='')
    {
        $datatype = IFilter::act(IReq::get('datatype'));
        if ($datatype == 'json') {
            //languagecls
            $lngcls = new languagecls();
            $msg = $lngcls->show($msg);
            echo json_encode(array('error'=>true,'msg'=>$msg));
            exit;
        } else {
            self::refunction($msg, $link);
        }
    }
    public static function refunction($msg, $info='')
    {
        $newrul = empty($info)?Mysite::$app->config['siteurl']:$info;
        header("Content-Type:text/html;charset=utf-8");
        if (!empty($msg)) {
            $lngcls = new languagecls();
            $msg = $lngcls->show($msg);
            echo '<script>alert(\''.$msg.'\');location.href=\''.$newrul.'\';</script>';
        } else {
            echo '<script>location.href=\''.$newrul.'\';</script>';
        }
        exit;
    }
    public static function success($msg, $link='')
    {
        $datatype = IFilter::act(IReq::get('datatype'));
        if ($datatype == 'json') {
            echo json_encode(array('error'=>false,'msg'=>$msg));
            exit;
        } else {
            self::refunction($msg, $link);
        }
    }
    public static function shopIsopen($is_open, $starttime, $is_orderbefore, $nowhour)
    {
        $find = 0 ;
        $hfind =0;
        $timekey =0;
        $gotime ='';
        $opentype = 0;
        $endtime = '';
        $checkstart = '';
        $checkend = '';
        if ($is_open == 0) {
            $opentype = 4;//店铺休息
        } else {
            if (empty($starttime)) {
                $opentype = 1;//已打烊
            } else {
                $foo = explode('|', $starttime);
                foreach ($foo as $key=>$value) {
                    $opentime=array();
                    if (!empty($value)) {
                        $mytime = explode('-', $value);
                        if (count($mytime) > 1) {
                            $time1 = strtotime($mytime[0]);
                            $time2 = strtotime($mytime[1]);
                            $opentime[]=$time1;
                            if ($nowhour >= $time1 && $nowhour <= $time2) {
                                $find = 1;
                                $opentype = 2;//营业中
                                $gotime = empty($gotime)?$mytime[0]:$gotime;
                                $endtime = !empty($mytime[1])?strtotime($mytime[1]):$endtime;
                            }
                            if ($nowhour <= $time2) {
                                //		 						$hfind = 1;
                                $gotime = empty($gotime)?$mytime[0]:$gotime;
                                $checkstart = empty($checkstart)?strtotime($mytime[0]):$checkstart;
                                $checkend = !empty($mytime[1])?strtotime($mytime[1]):$checkend;
                            }
                        }
                    }
                    if ($nowhour < $opentime[0]) {
                        $hfind = 1;
                    } else {
                        $hfind = 0;
                    }
                }
                if ($opentype == 0) {
                    if ($is_orderbefore == 1 && $hfind ==1) {
                        $opentype = 3;//3接受预定
                    }
                }
            }
        }
        return array('opentype'=>$opentype,'newstartime'=>$gotime,'endtime'=>$endtime,'startoktime'=>$checkstart,'startendtime'=>$checkend);
    }

    public function pscost($shopinfo, $newlng=null, $newlat=null)
    {
        $backdata = array('pscost'=>0,'pstype'=>0,'canps'=>0,'juli'=>0);
        if ($shopinfo['sendtype'] == 1) {
            $pradiusvalue =  unserialize($shopinfo['pradiusvalue']);
        } else {
            $pradiusvalue = unserialize($this->platpsinfo['radiusvalue']);
        }
        if (!empty($newlng) && !empty($newlat)) {
            $lat = $newlat;
            $lng = $newlng;
        } else {
            $lat = ICookie::get('lat');
            $lng = ICookie::get('lng');
        }
        if (!empty($lat)) {
            $lat = empty($lat)?0:$lat;
            $lng = empty($lng)?0:$lng;
            $shoplat = isset($shopinfo['lat'])?$shopinfo['lat']:0;
            $shoplng = isset($shopinfo['lng'])?$shopinfo['lng']:0;
            $juli =  $this->GetDistance($lat, $lng, $shoplat, $shoplng, 1);
            $juliceshi = intval($juli/1000);
            if (is_array($pradiusvalue)) {
                foreach ($pradiusvalue as $key=>$value) {
                    if ($juliceshi == $key) {
                        $backdata['pscost'] = $value;
                        $backdata['canps'] = 1;
                    }
                }

            }
        }
        $backdata['pscost'] = $shopinfo['pscost'];
        $backdata['canps'] = 1;

        $backdata['pstype'] = $shopinfo['sendtype'];
        $checkpstype = Mysite::$app->config['psbopen'];
        if ($shopinfo['sendtype'] == 2) {
            $backdata['pstype'] =$checkpstype == 1? 2:0;
        }
        return $backdata;
    }

    public function GetDistance($lat1, $lng1, $lat2, $lng2, $len_type = 1, $decimal = 2)
    {
        $earth = 6378.137;
        $pi = 3.1415926;
        $radLat1 = $lat1 * PI()/ 180.0;   //PI()圆周率
        $radLat2 = $lat2 * PI() / 180.0;
        $a = $radLat1 - $radLat2;
        $b = ($lng1 * PI() / 180.0) - ($lng2 * PI() / 180.0);
        $s = 2 * asin(sqrt(pow(sin($a/2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2), 2)));
        $s = $s * EARTH_RADIUS;
        $s = round($s * 1000);
        if ($len_type > 1) {
            $s /= 1000;
        }
        return round($s, $decimal);
    }
    public function getOpenPosttime($is_before, $starttime, $postdate, $minit, $befortime=0)
    {
        $backarray = array('is_opentime'=>0,'is_posttime'=>'','is_postdate'=>'','cost'=>0);
        $maxnowdaytime = strtotime(date('Y-m-d', time()));
        $daynottime = 24*60*60 -1;
        $findpostime = false;
        $posttime = time();
        $miniday = $maxnowdaytime;
        $maxday = $miniday+$daynottime;
        $findps = false;
        $timelist = !empty($postdate)?unserialize($postdate):array();
        $data['pstimelist'] = array();
        $checknow = time();
        $whilestatic = $befortime;
        $nowwhiltcheck = 0;
        while ($whilestatic >= $nowwhiltcheck) {
            $nowstartcheck = $nowwhiltcheck*86400;
            foreach ($timelist as $key=>$value) {
                $docheck = $nowstartcheck+$value['s'];
                if ($docheck== $minit) {
                    $findps = true;
                    $tempt['s'] = date('H:i', $miniday+$value['s']);
                    $tempt['e'] = date('H:i', $miniday+$value['e']);
                    $backarray['is_posttime'] = $nowstartcheck+$miniday+$value['s'];
                    $backarray['is_postdate'] =  $tempt['s'] .'-'.$tempt['e'];
                    $checkdotime = $nowstartcheck+$miniday+$value['e'];
                    $backarray['cost'] = isset($value['cost'])?$value['cost']:0;
                    if ($checkdotime < $posttime) {
                        $backarray['is_opentime'] = 3;
                    }
                    break;
                }
            }
            $nowwhiltcheck = $nowwhiltcheck+1;
        }
        if ($findps ==  false) {
            $backarray['is_opentime'] = 2;
        }
        return $backarray;
    }


    public function curl_get_content($url)
    {
        $tmpInfo = file_get_contents($url,true);
		 return $tmpInfo;
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
       // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); //对认证证书来源的检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); //模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_REFERER, '');//设置Referer
        curl_setopt($curl, CURLOPT_POST, 0); //发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_TIMEOUT, 120); //设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); //显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo;
    }
	public function curl_get_content2($url)
    {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
       // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); //对认证证书来源的检查
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); //模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_REFERER, '');//设置Referer
        curl_setopt($curl, CURLOPT_POST, 0); //发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_TIMEOUT, 120); //设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); //显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo;
    }
    public function strFilter($str)
    {
        $str = str_replace('`', '', $str);
        $str = str_replace('·', '', $str);
        $str = str_replace('~', '', $str);
        $str = str_replace('!', '', $str);
        $str = str_replace('！', '', $str);
        $str = str_replace('@', '', $str);
        $str = str_replace('#', '', $str);
        $str = str_replace('$', '', $str);
        $str = str_replace('￥', '', $str);
        $str = str_replace('%', '', $str);
        $str = str_replace('^', '', $str);
        $str = str_replace('……', '', $str);
        $str = str_replace('&', '', $str);
        $str = str_replace('*', '', $str);
        $str = str_replace('(', '', $str);
        $str = str_replace(')', '', $str);
        $str = str_replace('（', '', $str);
        $str = str_replace('）', '', $str);
        $str = str_replace('-', '', $str);
        $str = str_replace('_', '', $str);
        $str = str_replace('——', '', $str);
        $str = str_replace('+', '', $str);
        $str = str_replace('=', '', $str);
        $str = str_replace('|', '', $str);
        $str = str_replace('', '', $str);
        $str = str_replace('[', '', $str);
        $str = str_replace(']', '', $str);
        $str = str_replace('【', '', $str);
        $str = str_replace('】', '', $str);
        $str = str_replace('{', '', $str);
        $str = str_replace('}', '', $str);
        $str = str_replace(';', '', $str);
        $str = str_replace('；', '', $str);
        $str = str_replace(':', '', $str);
        $str = str_replace('：', '', $str);
        $str = str_replace('\'', '', $str);
        $str = str_replace('"', '', $str);
        $str = str_replace('“', '', $str);
        $str = str_replace('”', '', $str);
        $str = str_replace(',', '', $str);
        $str = str_replace('，', '', $str);
        $str = str_replace('<', '', $str);
        $str = str_replace('>', '', $str);
        $str = str_replace('《', '', $str);
        $str = str_replace('》', '', $str);
        $str = str_replace('.', '', $str);
        $str = str_replace('。', '', $str);
        $str = str_replace('/', '', $str);
        $str = str_replace('、', '', $str);
        $str = str_replace('?', '', $str);
        $str = str_replace('？', '', $str);
        return trim($str);
    }
    public function Tdata($stationid, $limitarr, $paixuarr, $lat, $lng, $source, $limitjuli=1)
    {// 0所有  1外卖  2超时

        //排序方式 ：综合排序，好评优先 起送价最低  ，距离 ,
        // cityid 城市ID
        //筛选方式 : 【店铺分类ID】，【促销活动类型】，【配送方式】【店铺类型】,【分校ID】,【首页推荐】，
        // array(	'shopcat'=>'店铺分类ID',
        //			'cxtype'=>'促销规则类型ID',
        //			'sendtype'=>'配送类 1商家配送 2平台配送 ',
        //			'shoptype'=>'1外卖  2超时',
        //			'index_com'=>'是否仅显示首页推荐  1时有效  其他无效',
        // 			"is_goshop"=>'1时表示 仅显示到店买单店铺 其他无效',
        //          "is_waimai" =>'1时仅支持外送的 其他无效',
        //			"limitcost"=>  1对应下边的   limitcost《 0
        /*
        $limitarray = array(
                0=>'',
                1=>' and b.limitcost < 10 ',
                2=>' and b.limitcost >= 10 and b.limitcost < 20 ',
                3=>' and b.limitcost >= 20  ',
            );*/
        //);
        //整个都是营业在前 非营业在后显示
        //array( 'juli'=>'desc',距离远近
        //		 'ping'=>'desc',评分排序
        //       'limitcost'=>'asc',起送价
        //       'sell'=>desc' //销量价格
        //);
        //$sourcetype  来源类型    1.PC端 2微信端,3web端,4app(安卓,苹果
        //配置文件的 open_wxcx   表示店铺列表是否显示 促销
        //$limitjuli  是否限制距离   1不限制

        $pxvalue = 'mijuli';
        $pxtype = SORT_ASC;
        if (isset($paixuarr['juli'])) {
            $pxtype = $paixuarr['juli'] == 'asc'?SORT_ASC:SORT_DESC;
        } elseif (isset($paixuarr['ping'])) {
            $pxvalue = 'point';
            $pxtype = $paixuarr['ping'] == 'asc'?SORT_ASC:SORT_DESC;
        } elseif (isset($paixuarr['limitcost'])) {
            $pxvalue = 'limitcost';
            $pxtype = $paixuarr['limitcost'] == 'asc'?SORT_ASC:SORT_DESC;
        } elseif (isset($paixuarr['sell'])) {
            $pxvalue = 'sellcount';
            $pxtype = $paixuarr['sell'] == 'asc'?SORT_ASC:SORT_DESC;
        } elseif (isset($paixuarr['ordercount'])) {
            $pxvalue = 'ordercount';
            $pxtype = $paixuarr['ordercount'] == 'asc'?SORT_ASC:SORT_DESC;
        } elseif (isset($paixuarr['maxcx'])) {
            $pxvalue = 'maxcx';
            $pxtype = $paixuarr['maxcx'] == 'asc'?SORT_ASC:SORT_DESC;
        }
        // print_r($this->CITY_ID);
        //$cityid = 410100;
        $tempwherexxx =  Mysite::$app->config['plateshopid'] > 0? ' and a.id != '.Mysite::$app->config['plateshopid'] .' ':'';
        $tempwherexxx .=  " and a.stationid = '".$stationid."'  ";

        if (isset($limitarr['shopcat'])&& $limitarr['shopcat'] > 0) {
            // $tempwherexxx =   $tempwherexxx." and b.shopid in(select sh.shopid from  ".Mysite::$app->config['tablepre']."shopsearch  as sh    where sh.second_id = ".$limitarr['shopcat']."  group by shopid  ) ";
            $tempwherexxx =   $tempwherexxx." and b.shopid in(select sa.shopid from  ".Mysite::$app->config['tablepre']."shopattr  as sa    where sa.attrid = ".$limitarr['shopcat']."  group by shopid  ) ";
        }
        //cxtype  运算中在测算 ---这个构造的 shopid太长了在list里运算
        $limitcx = 0;//是否限制店铺促销类型
        $cxshopid = array();
        if (isset($limitarr['cxtype'])&& $limitarr['cxtype'] > 0) {
            $d = (date("w") ==0) ?7:date("w") ;
            $limitcx = 1;
            $cxshop = $this->mysql->getarr("select shopid from ".Mysite::$app->config['tablepre']."rule where controltype = ".$limitarr['cxtype']." and FIND_IN_SET(".$source.",supportplatform)    and status = 1  and ( limittype = 1 or ( limittype = 2 and  find_in_set(".$d.",limittime) )  or ( limittype = 3 and endtime > ".time()." and starttime < ".time().")) ");
            if (is_array($cxshop)) {
                foreach ($cxshop as $k=>$v) {
                    $cxshopid = array_merge($cxshopid, explode(',', $v['shopid']));
                }
                $cxshopid = array_unique($cxshopid);
            }
        }

        if (isset($limitarr['sendtype']) && $limitarr['sendtype'] > 0) {
            $tempwherexxx = $limitarr['sendtype']==1?$tempwherexxx." and b.sendtype = 1":$tempwherexxx." and b.sendtype != 1";
        }
        $dotype = 0;
        if (isset($limitarr['shoptype']) && $limitarr['shoptype'] > 0) {
            if ($limitarr['shoptype'] == 1) {
                $dotype = 1;
            } elseif ($limitarr['shoptype'] == 2) {
                $dotype = 2;
            }
        }
        if (isset($limitarr['index_com']) && $limitarr['index_com'] ==1) {
            $tempwherexxx .=  " and a.is_recom = 1  ";
        }
        if (isset($limitarr['is_goshop']) && $limitarr['is_goshop'] ==1) {
            $dotype = 1;
            $tempwherexxx .=  " and b.is_goshop  = 1  ";
        }
        if (isset($limitarr['is_waimai']) && $limitarr['is_waimai'] ==1) {
            $dotype = 1;
            $tempwherexxx .=  " and b.is_waimai   = 1  ";
        }
        if (isset($limitarr['search_input']) && !empty($limitarr['search_input'])) {
            $dotype = 1;
            $tempwherexxx .=  " and a.shopname like '%".$limitarr['search_input']."%'  ";
        }
        if (isset($limitarr['limitcost']) &&  $limitarr['limitcost'] > 0) {
            $limitdo = array(
                0=>'',
                1=>' and b.limitcost < 10 ',
                2=>' and b.limitcost >= 10 and b.limitcost < 20 ',
                3=>' and b.limitcost >= 20  ',
            );
            $tempwherexxx .= $limitdo[$limitarr['limitcost']];
        }



        $list = array();

        $platbangjing = isset($platpsinfo['locationradius'])?intval($platpsinfo['locationradius']):0;
        $platbangjing = $platbangjing *1000;

        // print_r($tempwherexxx);

        $juliwhere = "";


        $list = $this->mysql->getarr("select  a.sort, a.id,a.shopname,a.sellcount,a.ordercount,a.point,a.pointcount,a.virtualsellcounts,a.is_open,a.starttime,a.pointcount as pointsellcount,a.lat,a.lng,a.shoplogo,a.shoptype,a.address,a.isforyou,a.is_recom,
		 b.shopid,b.is_orderbefore,b.limitcost,b.is_hot,b.is_com,b.is_new,b.maketime,b.pradius,b.sendtype,b.pscost,b.pradiusvalue,b.arrivetime,b.postdate,SQRT(  power(6370693.5*( COS(a.`lat` * 0.01745329252)  )*  (a.`lng` * 0.01745329252 - ".$lng." * 0.01745329252) ,2)+power(6370693.5*(a.`lat` * 0.01745329252 - ".$lat." * 0.01745329252),2) ) as juli
		 from ".Mysite::$app->config['tablepre']."shopfast as b left join ".Mysite::$app->config['tablepre']."shop as a  on b.shopid  = a.id
		 where a.is_pass = 1    ".$tempwherexxx." and a.endtime > ".time()." ".$juliwhere." order by id desc  limit 0,2000 ");

        $marketlist = array();

        $tempdds = $list;

        //print_r($waimailist);


        $open_wxcx = Mysite::$app->config['open_wxcx'];

        $datalist = array();
        $nowhour = date('H:i:s', time());
        $nowhour = strtotime($nowhour);

        $pxvalue2 = array();
        $pxvalue1 = array();
        $shoppsimg = Mysite::$app->config['shoppsimg'];
        $psimg = Mysite::$app->config['psimg'];
        $nowhout = strtotime(date('Y-m-d', time()));
        foreach ($tempdds as $key=>$value) {
            if ($limitcx == 1) {
                if (!in_array($value['shopid'], $cxshopid)) {
                    continue;
                }
            }

            $value['psimg'] = $shoppsimg;
            $value['valuelist'] = empty($value['pradiusvalue'])? '':unserialize($value['pradiusvalue']);

            $value['mijuli'] = $value['juli'];
            $juli = $value['juli'];
            $juliceshi = intval($juli/1000);
            if ($juli > 1000) {
                $juli = $juli*0.001;
                $juli = round($juli, 2);
                $value['juli'] =  $juli.'km';//'未测距';
            } else {
                $juli = round($juli, 0);
                $value['juli'] =  $juli.'m';//'未测距
            }
            // $value['pscost'] = '0';
            // $value['canps'] = 0;
            $valuelist = $value['valuelist'];
            if(is_array($valuelist)){
				// foreach($valuelist as $k=>$v){
				// 	if($juliceshi == $k){
				// 		$value['pscost'] = $v;
				// 		$value['canps'] = 1;
				// 	}
				// }
                // $value['pscost'] = end($valuelist);
                // $value['canps'] = 1;
			}

            $value['pscost'] = $value['pscost'];
            $value['canps'] = 1;

            $value['opentype'] = '1';//1营业  0未营业
            $checkinfo = $this->shopIsopen($value['is_open'], $value['starttime'], $value['is_orderbefore'], $nowhour);
            $value['newstartime']  =  $checkinfo['newstartime'];
            if ($checkinfo['opentype'] != 2 && $checkinfo['opentype'] != 3) {
                $value['opentype'] = '0';
            } else {
                $value['opentype'] = $checkinfo['opentype'];
            }
            $pxvalue2[$key] = $value['opentype'] == 2||$value['opentype'] == 3?1:0;

            $timelist = !empty($value['postdate'])?unserialize($value['postdate']):array();

            $value['pstime']=$value['newstartime'];

            foreach ($timelist as $k=>$v) {
                if (($nowhout+$v['s'])>= strtotime($value['newstartime'])) {
                    $value['pstime']  = date("H:i", $nowhout+$v['s']);
                    break;
                }
            }

            $goods = $this->mysql->select_one("SELECT SUM(virtualsellcount) as virtualsellcounts  FROM ".Mysite::$app->config['tablepre']."goods where shopid = '".$value['id']."'");
            $value['virtualsellcounts'] = $goods['virtualsellcounts'];



            $cxinfo = array();
            $d = date("w") ==0?7:date("w");
            $value['maxcx'] = 0;
            if ($open_wxcx == 1) {
                $cxinfo = $this->mysql->getarr("select id,name,imgurl,controltype ,controlcontent from ".Mysite::$app->config['tablepre']."rule where  FIND_IN_SET(".$value['id'].",shopid) and FIND_IN_SET(".$source.",supportplatform)    and status = 1  and ( limittype = 1 or ( limittype = 2 and FIND_IN_SET(".$d.",limittime) )  or ( limittype = 3 and endtime > ".time()." and starttime < ".time().")) ");
                $maxcx = 0;
                foreach($cxinfo as $cxk => $cxv)
                {
                    $cxv_arr = array_filter(explode(',',$cxv['controlcontent']));
                    $maxcx = max($cxv_arr) > $maxcx ? max($cxv_arr) : $maxcx;
                }
                $value['maxcx'] = $maxcx;
            }//
            $value['cxlist'] =  $cxinfo;
            $value['cxinfo'] =  $cxinfo;

            $value['virtualsellcounts'] = intval($value['virtualsellcounts']);

            $imgurl = empty($value['shoplogo'])?Mysite::$app->config['imgserver'].Mysite::$app->config['shoplogo']:Mysite::$app->config['imgserver'].$value['shoplogo'];
            $value['shopimg'] = $imgurl;
            $value['shoplogo'] = $imgurl;

            $mstart = strtotime(date("Y-m-01"));
            $mgoods = $this->mysql->select_one("SELECT SUM(goodscount) as mgoodscount  FROM ".Mysite::$app->config['tablepre']."order as o join ".Mysite::$app->config['tablepre']."orderdet as od on o.id = od.order_id  where o.shopid = '".$value['id']."' AND o.addtime >= $mstart AND o.status = 3 ");
            $value['ordercount'] = $mgoods['mgoodscount'];

            $value['sellcount'] = $value['virtualsellcounts']+$value['ordercount'];
            $value['ordercount'] =$value['sellcount'];

            $zongpoint = $value['point'];
            $zongpointcount = $value['pointcount'];
            if ($zongpointcount != 0) {
                $shopstart = intval(round($zongpoint/$zongpointcount));
            } else {
                $shopstart= 0;
            }
            $value['point'] = 	$shopstart;

            $pxvalue1[$key] = $value[$pxvalue];
            unset( $value['valuelist'] );
            unset( $value['pradiusvalue'] );
            unset($value['postdate']);
            $datalist[] = $value;
        }

        array_multisort($pxvalue2, SORT_DESC, $pxvalue1, $pxtype, $datalist);

        return $datalist;
    }
}
