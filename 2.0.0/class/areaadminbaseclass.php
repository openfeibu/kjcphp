<?php

/**
 * @class baseclass
 * @描述   基础类
 */
class areaadminbaseclass
{
    public $mysql;
    public $memberCls;
    public $member;
    public $pageCls;
    public $admin;
    public $digui;
    public $platpsinfo;
    public function init()
    {
        //主要是检测权限
        $controller = Mysite::$app->getController();
        $Taction = Mysite::$app->getAction();
        $this->mysql =  new mysql_class();
        $this->memberCls = new memberclass($this->mysql);
        $this->pageCls = new page();
        $this->admin =  $this->memberCls->getareaadmininfo();
        if (!empty($this->admin)) {
            $stationinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."stationadmininfo  where uid='".$this->admin['uid']."'  ");
            $cityinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area  where adcode='".$stationinfo['cityid']."'  ");
            $stationinfo['cityname'] = $cityinfo['name'];
            if (!empty($stationinfo)) {
                $this->admin = array_merge($this->admin, $stationinfo);
            }
        }
        $platpsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$stationinfo['cityid']."' ");
        $this->platpsinfo = $platpsinfo;
        $data['platpsinfo'] = $platpsinfo;

        $this->digui = array();//递归处理数组
        $link = IUrl::creatUrl('member/agentlogin');
        if ($this->admin['uid'] == 0) {
            $this->message('member_nologin', $link);
        }
        $data['admininfo'] = $this->admin;
        if ($this->admin['groupid'] != 4) {
            $links = IUrl::creatUrl('areaadminpage/system');
            $this->message('', $links);
        }
        $checkmodule =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."module  where name='".$Taction."' and install=1 limit 0,20");
        if (empty($checkmodule) && !in_array($controller, array('site','market'))) {
            $this->message('module_noinstall');
        }

        $action = Mysite::$app->getAction();
        $data['moduleid']= $checkmodule['id'];
        $data['moduleparent'] = $checkmodule['parent_id'];
        $id = intval(IFilter::act(IReq::get('id')));
        $data['id'] = $id;

        Mysite::$app->setdata($data);
    }
    public function checkadminlogin()
    {
        $link = IUrl::creatUrl('member/adminlogin');
        if ($this->admin['uid'] == 0) {
            $this->message('member_nologin', $link);
        }
    }
    public function checkmemberlogin()
    {
        $link = IUrl::creatUrl('member/login');
        if ($this->member['uid'] == 0) {
            $this->message('member_nologin', $link);
        }
    }
    public function checkshoplogin()
    {
        $link = IUrl::creatUrl('member/shoplogin');
        if ($this->member['uid'] == 0&&$this->admin['uid'] == 0) {
            $this->message('member_nologin', $link);
        }
        $shopid = ICookie::get('adminshopid');
        if (empty($shopid)) {
            $this->message('member_nologin', $link);
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
                    if (!empty($value)) {
                        $mytime = explode('-', $value);

                        if (count($mytime) > 1) {
                            $time1 = strtotime($mytime[0]);
                            $time2 = strtotime($mytime[1]);

                            if ($nowhour > $time1 && $nowhour < $time2) {
                                $find = 1;
                                $opentype = 2;//营业中
                                $gotime = empty($gotime)?$mytime[0]:$gotime;
                                $endtime = !empty($mytime[1])?strtotime($mytime[1]):$endtime;
                            }
                            if ($nowhour < $time2) {
                                $hfind = 1;
                                $gotime = empty($gotime)?$mytime[0]:$gotime;
                                $checkstart = empty($checkstart)?strtotime($mytime[0]):$checkstart;
                                $checkend = !empty($mytime[1])?strtotime($mytime[1]):$checkend;
                            }
                        }
                    }
                }
                if ($opentype == 0) {
                    if ($is_orderbefore == 1&& $hfind ==1) {
                        $opentype = 3;//3接受预定
                    }
                }
            }
        }
        return array('opentype'=>$opentype,'newstartime'=>$gotime,'endtime'=>$endtime,'startoktime'=>$checkstart,'startendtime'=>$checkend);
    }

    public function GetDistance($lat1, $lng1, $lat2, $lng2, $len_type = 1, $decimal = 2)
    {
        define('EARTH_RADIUS', 6378.137);//地球半径，假设地球是规则的球体
        define('PI', 3.1415926);
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
}
