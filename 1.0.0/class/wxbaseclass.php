<?php

/**
 * @class baseclass
 * @描述   基础类
 */
class wxbaseclass extends wmrclass
{
    public $memberCls;
    public $member;
    public $pageCls;
    public $admin;
    public $digui;
    public $CITY_ID;
    public $CITY_NAME;
    public $platpsinfo;
    public function init()
    {
        //主要是检测权限
        $this->memberCls = new memberclass($this->mysql);
        $this->member = $this->memberCls->getinfo();
        if(!$this->member['wxuser']){
            $this->memberCls->loginout();
            $this->member['uid'] == 0;
        }
        $this->pageCls = new page();
        $this->admin =  $this->memberCls->getadmininfo();
        $this->digui = array();//递归处理数组
        $controller = Mysite::$app->getController();
        $action = Mysite::$app->getAction();

        $data['member'] = $this->member;
        $data['admininfo'] = $this->admin;
        $logintype = ICookie::get('logintype');
        //$this->adminshopid = ICookie::get('adminshopid');

        $cityId = 0;
        $CITY_ID = ICookie::get('CITY_ID');
        if (!empty($CITY_ID)) {
            $CITY_IDArr = explode('_', $CITY_ID);
            $cityId = $CITY_IDArr[2];
        }
        #   print_R($cityId);
        $this->CITY_ID = $cityId = 440100;

        $lng = $lat = $stationid = 0;
        if($this->member['uid'])
        {
            $mlng = $lng = $this->member['lng'];
            $mlat = $lat = $this->member['lat'];
            $stationid = $this->member['stationid'];
        }
        if(!$stationid)
        {
            $station = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."stationadmininfo where stationis_open = 0 order by id desc");
            $stationid = $station['id'];
            $lng = $station['lng'];
            $lat = $station['lat'];
            $this->CITY_ID = $station['cityid'];
        }else{
            $station = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."stationadmininfo where stationis_open = 0 AND id = ".$stationid." order by id desc");
            $lng = $lng > 0 ? $lng : $station['lng'];
            $lat = $lat > 0 ? $lat : $station['lat'];
        }

        // $lng = ICookie::get('lng');
        // $lat = ICookie::get('lat');
        $data['lng'] = $this->lng = $lng;
        $data['lat'] = $this->lat = $lat;
        $data['latitude'] = $lat;
        $data['longitude'] = $lng;
        $data['mlatitude'] = $mlat;
        $data['mlongitude'] = $mlng;
        $data['stationid'] = $this->stationid = $stationid;

        $CITY_NAME = ICookie::get('CITY_NAME');
        if (!empty($CITY_NAME)) {
            $CITY_NameArr = explode('_', $CITY_NAME);
            $CITY_NAME = $CITY_NameArr[2];
        }
        $this->CITY_NAME = $CITY_NAME;
        $data['CITY_ID'] = $this->CITY_ID;
        $data['CITY_NAME'] = $this->CITY_NAME;
        $id = IFilter::act(IReq::get('id'));
        if (empty($cityId)) {
            $shop = $this->mysql->select_one("select admin_id from ".Mysite::$app->config['tablepre']."shop  where id ='".$id."' ");
            $cityId = $shop['admin_id'];
        }
        $platpsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$cityId."' ");
        $this->platpsinfo = $platpsinfo;
        $data['platpsinfo'] = $platpsinfo;
        // if (!strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger')) {    //判断是微信浏览器不
        //     $data['WeChatType'] = 0;
        // } else {
            $data['WeChatType'] = 1;//微信端
        //}
        //loadindexcontent
        $wxopenid  = ICookie::get('wxopenid');
        $action = Mysite::$app->getAction();
        # logwrite($action."----------");
        $datatype = IFilter::act(IReq::get('datatype'));
        $ulogin = intval(IFilter::act(IReq::get('ulogin')));
        $loadaction=array('index','noticelist','ajaxnoticelist','notice','shopshow','mkshopshow','mkcatefoods','loadindexcontent','indexshoplistdata','shoplistdata','saveloation','shoplist','specialpagelistdata','loginmode','choice','marketshop','specialpage','marketlistdata','waimai','marketlist','paotui','togethersay','togethersaydata','foodshow','getshopmorecomment','getshopcomment','getdetailinfo','commentwxuser');
        if ($datatype == 'json') {
        } else {
            //if (strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger')) { //判断是微信浏览器不
                if ($this->member['uid'] <= 0  || !$this->member['wxuser']) {
                    if (Mysite::$app->config['wxLoginType']==0) {
                        //微信自动登录
                        $this->wxlogin();
                        $this->setwxlogin(0);
                    } else {
                        $arract=array('reg','forpwd','forgetnextpwd','setlogin','wxbdphone','qqbdphone');
                        if ($ulogin != 1 &&  !in_array($action, $arract)) {
                            $myurl = Mysite::$app->config['siteurl'].$_SERVER["REQUEST_URI"];
                            ICookie::set('wx_login_link', $myurl, 86400);
                            $link = IUrl::creatUrl('wxsite/loginmode');
                            $this->message('', $link);
                        }
                    }
                }

            //}
        }
        $this->doshare();
        $checkmodule =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."module  where name='".$controller."' and install=1 limit 0,20");
        if (empty($checkmodule) && !in_array($controller, array('site','market'))) {
            $this->message('未安装此模版');
        }
        $data['moduleid']= $checkmodule['id'];
        $data['moduleparent'] = $checkmodule['parent_id'];
        $id = intval(IFilter::act(IReq::get('id')));
        $data['id'] = $id;
        $data['member'] = $this->member;

        $wxclass = new wx_s();
        $signPackage = $wxclass->getSignPackage();
        $data['signPackage'] = $signPackage;
        $shareinfo['title'] = Mysite::$app->config['sitename'];
        $shareinfo['img'] = Mysite::$app->config['share_img'];
        $shareinfo['describe'] = Mysite::$app->config['description'];
        $data['shareinfo'] = $shareinfo;

        Mysite::$app->setdata($data);
    }
    /***设置分享***/
    public function doshare()
    {
        $sharedata['signPackage'] = '';
        if (strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger')) {
            $wxclass = new wx_s();
            $signPackage = $wxclass->getSignPackage();
            $sharedata['signPackage'] = $signPackage;
            $sharedata['signPackage']['shareimg'] = Mysite::$app->config['share_img'];
        }
        Mysite::$app->setdata($sharedata);
    }
    //判断微信登陆
    public function setwxlogin($loginmode)
    {
        $code = IFilter::act(IReq::get('code'));

        $userinfo = array();
        $token_link = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . Mysite::$app->config['wxappid'] . '&secret=' . Mysite::$app->config['wxsecret'] . '&code=' . $code . '&grant_type=authorization_code';
        $token = json_decode($this->curl_get_content($token_link), true);
        if (isset($token['access_token'])) {
            $userinfo['openid'] = $token['openid'];
            $userinfo['unionid'] = $token['unionid'];
            $userinfo['access_token'] = $token['access_token'];
            $userinfo['refresh_token'] = $token['refresh_token'];
            $expires_in = $token['expires_in'];
            if ($expires_in < 1) {
                //刷新CODE
                $refresh_link = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=' . Mysite::$app->config['wxappid'] . '&grant_type=refresh_token&refresh_token=' . $userinfo['refresh_token'];
                $refresh = json_decode($this->curl_get_content($refresh_link), true);
                if (isset($refresh['access_token'])) {
                    $userinfo['openid'] = $refresh['openid'];
                    $userinfo['unionid'] = $refresh['unionid'];
                    $userinfo['access_token'] = $refresh['access_token'];
                    $userinfo['refresh_token'] = $refresh['refresh_token'];
                    $expires_in = $refresh['expires_in'];
                } else {
                    refresh();
                }
            }
        } else {
            if($token['errcode'] == 40163)
            {
                refresh();
            }
            refresh();
        }
        // $check_link = 'https://api.weixin.qq.com/sns/auth?access_token=' . $userinfo['access_token'] . '&openid=' . $userinfo['openid'];
        // $checkopen = json_decode($this->curl_get_content($check_link), true);
        // if ($checkopen['errcode'] == 0) {
        // } else {
            // echo $checkopen['errcode'];
            // exit;
        // }
        //获取用户信息
        $getlink = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $userinfo['access_token'] . '&openid=' . $userinfo['openid'];
        $wxuser = json_decode($this->curl_get_content($getlink), true);
        if (isset($wxuser['openid'])) {
        } else {
            refresh();
        }
        if ($loginmode==0) {
            $this->setLoginInfo($wxuser, $userinfo);
            refresh();
        } else {
            $data['wxuser'] = $wxuser;
            $data['userinfo'] = $userinfo;
            return $data;
        }

    }
    public function setLoginInfo($wxuser, $userinfo)
    {

        //构造微信APP登录 xiaozu_wxappoauth
        $wxoauth['openid'] = $wxuser['openid'];
        $wxoauth['username'] =  $wxuser['nickname'];
        $wxoauth['imgurl'] = $wxuser['headimgurl'];
        $flag = 0;
        $is_user = array();

        $uid = 0;
        $oauthinfo=$this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."wxuser where openid='".$wxuser['openid']."'  ");

        if (empty($oauthinfo)) {//写用户数据
            $arr['username'] = $this->strFilter($wxoauth['username']) ? $this->strFilter($wxoauth['username']) : $wxoauth['openid'];
            $arr['phone'] = $wxuser['phone'];
            $arr['address'] = '';
            $arr['password'] = md5($wxoauth['openid']);
            $arr['email'] = '';
            $arr['creattime'] = time();
            $arr['score']  =0;
            $arr['logintime'] = time();
            $arr['loginip'] ='';
            $arr['group'] = 10;
            $arr['logo'] = $wxoauth['imgurl'];
            $arr['sex'] = $wxuser['sex'];  //用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
            $this->mysql->insert(Mysite::$app->config['tablepre']."member", $arr);
            $uid = $this->mysql->insertid();

            $mbdata['uid'] = $uid;
            $mbdata['openid'] = $wxoauth['openid'];
            $mbdata['is_bang'] = 0;
            $mbdata['access_token'] = $userinfo['access_token'];
            $mbdata['expires_in'] = $userinfo['expires_in']+time();
            $mbdata['refresh_token'] = $userinfo['refresh_token'];
            $this->mysql->insert(Mysite::$app->config['tablepre'].'wxuser', $mbdata);
            $flag = 1;
        } else {//更新用户数据

            $mbdata['access_token'] = $userinfo['access_token'];
            $mbdata['expires_in'] = $userinfo['expires_in']+time();
            $mbdata['refresh_token'] = $userinfo['refresh_token'];
            $this->mysql->update(Mysite::$app->config['tablepre'].'wxuser', $mbdata, "openid='".$wxuser['openid']."'");

            $membercheck = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid ='".$oauthinfo['uid']."' ");
            $yuid = $membercheck['uid'];
            if (!empty($membercheck)) {
                //if (empty($membercheck['username'])) {
                    $newusername = $this->strFilter($wxoauth['username']) ? $this->strFilter($wxoauth['username']) : $wxoauth['openid'];
                    $cnewdata['username'] = $newusername;
                    $cnewdata['logo'] = $wxoauth['imgurl'];
					$this->mysql->update(Mysite::$app->config['tablepre'].'member', $cnewdata, "uid='".$oauthinfo['uid']."' ");
                //}
                $flag = 2;
                $uid = $oauthinfo['uid'];

            } else {
                $arr['username'] = $this->strFilter($wxoauth['username']) ? $this->strFilter($wxoauth['username']) : $wxoauth['openid'];
                $arr['phone'] = $wxuser['phone'];
                $arr['address'] = '';
                $arr['password'] = md5($wxoauth['openid']);
                $arr['email'] = '';
                $arr['creattime'] = time();
                $arr['score'] =0;
                $arr['logintime'] = time();
                $arr['loginip'] ='';
                $arr['group'] = 10;
                $arr['logo'] = $wxoauth['imgurl'];
                $arr['sex'] = $wxoauth['sex'];  //用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
                $arr['uid'] = $oauthinfo['uid'];
                $this->mysql->insert(Mysite::$app->config['tablepre']."member", $arr);
                $uid = $this->mysql->insertid();

                $wx['uid'] = $uid;
                $this->mysql->update(Mysite::$app->config['tablepre'].'wxuser', $wx, "openid='".$wxuser['openid']."'");
                $flag = 1;
            }
        }
        ICookie::set('checklogins', $flag, 86400);
        ICookie::set('logintype', 'wx', 86400);
        ICookie::set('wxopenid', $wxuser['openid'], 86400);
        $userinfo=  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$uid."'  ");
        $this->member = $userinfo;
        ICookie::set('email', $userinfo['email'], 86400);
        ICookie::set('memberpwd', $userinfo['password'], 86400);
        ICookie::set('membername', $userinfo['username'], 86400);
		// if($_GET['ceshi'])
		// {
			// var_dump( $uid);exit;
		// }
        ICookie::set('uid', $uid, 86400);

    }



    public function wxlogin()
    {
        // if (is_mobile_request()) {
        //     if (strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger')) {
                $wxopenid  = ICookie::get('wxopenid');
                $code = IFilter::act(IReq::get('code'));
                $state = IFilter::act(IReq::get('state'));
                $doinsert = 0;
                if (empty($wxopenid)) {
                    //echo 'openid 为空';
                    if (empty($code)) {
                        //跳转到微信OPenlink
                        $this->getwxcode();
                    }
                } else {
                    $wxinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."wxuser where openid='".$wxopenid."'");
                    if (empty($wxinfo)) {
                        /*未关注用户不可登陆*/
                        if (empty($code)) {
                            $this->getwxcode();
                        }
                    }
                }
        //     } else {
        //     }
        // } else {
        //     if (strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger')) {
        //         $wxopenid  = ICookie::get('wxopenid');
        //         $code = IFilter::act(IReq::get('code'));
        //         $doinsert = 0;
        //         if (empty($wxopenid)) {
        //             //echo 'openid 为空';
        //             if (empty($code)) {
        //                 //跳转到微信OPenlink
        //                 $this->getwxcode();
        //             }
        //         } else {
        //             $wxinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."wxuser where openid='".$wxopenid."'");
        //             if (empty($wxinfo)) {
        //                 /*未关注用户不可登陆*/
        //                 if (empty($code)) {
        //                     $this->getwxcode();
        //                 }
        //             }
        //         }
        //     } else {
        //     }
        // }
    }
    public function getwxcode()
    {
        $myurl = Mysite::$app->config['siteurl'].$_SERVER["REQUEST_URI"];
        $action = Mysite::$app->getAction();
        if ($action != 'setlogin') {
            ICookie::set('wx_login_link', $myurl, 86400);
        }
        $newurl = urlencode($myurl);
        $getlink = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".Mysite::$app->config['wxappid']."&redirect_uri=".$newurl."&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
        header("location:".$getlink);
        exit;
    }
}
