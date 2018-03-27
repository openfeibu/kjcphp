<?php
/*
*   method 方法  包含所有会员相关操作
    管理员/会员  添加/删除/编辑/用户登陆
    用户日志其他相关连的通过  memberclass关联
*/
class method extends baseclass
{
    public function index()
    {
        if (empty($this->member['uid'])) {
            $link = IUrl::creatUrl('member/login');
            $this->refunction('', $link);
        } else {
            $link = IUrl::creatUrl('member/base');
            $this->refunction('', $link);
        }
    }
    public function base()
    {
        $this->checkmemberlogin();
        $temparea =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."area   ");
        $areatoname = array();
        foreach ($temparea as $key=>$value) {
            $areatoname[$value['id']] = $value['name'];
        }
        $areatoname[0] = '';
        $data['areatoname'] = $areatoname;
        $nowday = date('Y-m-d', time());
        //   $where = '  and posttime > '.strtotime($nowday.' 00:00:00').' and posttime < '.strtotime($nowday.' 23:59:59');
        $where = ' and status < 3';
        $data['temp'] =  $this->mysql->select_one("select count(id) as shuliang from ".Mysite::$app->config['tablepre']."order where buyeruid='".$this->member['uid']."'  ".$where."  and shoptype=1 order by id desc  limit 0,6"); //商城订单

        $data['temp2'] =  $this->mysql->select_one("select count(id) as shuliang from ".Mysite::$app->config['tablepre']."order where buyeruid='".$this->member['uid']."'  ".$where."  and shoptype=0 order by id desc  limit 0,6");

        $data['temp3'] =  $this->mysql->select_one("select count(id) as shuliang from ".Mysite::$app->config['tablepre']."order where buyeruid='".$this->member['uid']."'  ".$where."   and shoptype=0 order by id desc  limit 0,6");
        $data['temp4'] =  $this->mysql->select_one("select count(id) as shuliang from ".Mysite::$app->config['tablepre']."order where buyeruid='".$this->member['uid']."' and status = 3 and is_ping =0 order by id desc  limit 0,6");

        Mysite::$app->setdata($data);
    }





    //后台管理员登陆
    public function adminlogin()
    {
        if (strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger')) {
            //判断是微信浏览器不
            echo file_get_contents(Mysite::$app->config['siteurl']."/index.php?ctrl=site&action=wxopen");
            exit;
        }

        $signup_name =  IFilter::act(IReq::get('signup_name'));
        $signup_password =  IFilter::act(IReq::get('signup_password'));
        $cookiename =  IFilter::act(IReq::get('cookiename'));

        if (!empty($signup_name)) {
            $userinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."admin where username ='".$signup_name."'");
            if (empty($signup_password)) {
                $this->message('signup_password_tip');
            }
            if ($userinfo['password'] != md5($signup_password)) {
                $this->message('signup_password_tip');
            }
            $data['loginip'] = IClient::getIp();
            $data['logintime'] = time();
            $this->mysql->update(Mysite::$app->config['tablepre'].'admin', $data, "uid='".$userinfo['uid']."'");

            ICookie::set('adminname', $userinfo['username'], 86400);
            ICookie::set('adminpwd', $signup_password, 86400);
            ICookie::set('adminuid', $userinfo['uid'], 86400);
            $this->success('success');
        }
    }
    //后台管理员登出
    public function adminloginout()
    {
        ICookie::clear('adminname');
        ICookie::clear('adminpwd');
        ICookie::clear('adminuid');
        ICookie::clear('adminshopid');
        $link = IUrl::creatUrl('member/adminlogin');
        $this->refunction('', $link);
    }

    public function fastlogin()
    {
        $phone = trim(IFilter::act(IReq::get('phone')));
        $code =  trim(IFilter::act(IReq::get('phoneyan')));

        $phonecls = new phonecode($this->mysql, 4, $phone);
        if ($phonecls->checkcode($code)) {
            $member = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where phone='".$phone."' ");
            if (empty($member)) { //该手机号未注册过   则注册
                $temp_password = rand(100000, 999999);
                $checkstr = md5($phone);
                $arr['username'] = substr($checkstr, 0, 8);
                $arr['phone'] = $phone;
                $arr['address'] = '';
                $arr['password'] = md5($temp_password);
                $arr['email'] = '';
                $arr['creattime'] = time();
                $arr['score']  = $score == 0?Mysite::$app->config['regesterscore']:$score;
                $arr['logintime'] = time();
                $arr['logo'] = Mysite::$app->config['userlogo'];
                $arr['group'] = 5;
                $arr['cost'] = 0;
                $arr['parent_id'] =0;
                $arr['temp_password'] = $temp_password;
                $this->mysql->insert(Mysite::$app->config['tablepre'].'member', $arr);
                $uid = $this->mysql->insertid();
                if ($arr['score'] > 0) {
                    $this->memberCls->addlog($uid, 1, 1, $arr['score'], '注册送积分', '注册送积分'.$arr['score'], $arr['score']);
                }
                $juansetinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 2 or name = '注册送代金券' ");
                $juaninfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."alljuan where type = 2 or name= '注册送代金券' order by id asc ");
                if ($juansetinfo['status'] ==1 && !empty($juaninfo)) {
                    //注册送代金券
                    foreach ($juaninfo as $key=>$value) {
                        $juandata['uid'] = $this->uid;// 用户ID
               $juandata['username'] = $arr['username'];// 用户名
               $juandata['name'] = $value['name'];//  代金券名称
               $juandata['status'] = 1;// 状态，0未使用，1已绑定，2已使用，3无效
               $juandata['card'] = $nowtime.rand(100, 999);
                        $juandata['card_password'] =  substr(md5($juandata['card']), 0, 5);
                        $juandata['limitcost']	= $value['limitcost'];

                        if ($juansetinfo['timetype'] == 1) {
                            $juandata['creattime'] = time();
                            $date = date('Y-m-d', $juandata['creattime']);
                            $endtime = strtotime($date) + ($juansetinfo['days']-1)*24*60*60 + 86399;
                            $juandata['endtime'] = $endtime;
                        } else {
                            $juandata['creattime'] = $value['starttime'];
                            $juandata['endtime'] =  $value['endtime'];
                        }
                        if ($juansetinfo['costtype'] == 1) {
                            $juandata['cost'] = $value['cost'];
                        } else {
                            $juandata['cost'] = rand($value['costmin'], $value['costmax']);
                        }
                        $this->mysql->insert(Mysite::$app->config['tablepre'].'juan', $juandata);
                    }
                }	// 根据前台注册的手机号检测此手机号数据库中是否领取过代金券，如果有则更新UID和username status=1
                // 如果前台新注册的用户 存在分享者 shareuid > 0 则考虑返增推广分享者代金券
                $checkphonejuan =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."juan where bangphone='".$phone."' and uid=0 and status = 0  ");
                if (!empty($checkphonejuan)) {
                    $tdata['uid'] = $uid;
                    $tdata['username'] = $arr['username'];
                    $tdata['status'] = 1;
                    $this->mysql->update(Mysite::$app->config['tablepre'].'juan', $tdata, "bangphone='".$phone."' and uid=0 and status = 0 ");
                }
                ICookie::set('membername', $arr['username'], 86400);
                ICookie::set('uid', $uid, 86400);
                ICookie::set('phone', $phone, 86400);
                ICookie::set('logintype', 'fastlogin', 86400);
                $this->success('success');
            } else { //如果该手机号注册过  则登录该手机号绑定的账号
                ICookie::set('membername', $member['username'], 86400);
                ICookie::set('uid', $member['uid'], 86400);
                ICookie::set('phone', $phone, 86400);
                ICookie::set('logintype', 'fastlogin', 86400);
                $this->success('success');
            }
        } else {
            $this->message($phonecls->getError());
        }
    }
    public function login()
    {
        $uname = IFilter::act(IReq::get('uname'));
        $pwd = IFilter::act(IReq::get('pwd'));
        $link = IUrl::creatUrl('member/login');
        $logincode = intval(IFilter::act(IReq::get('logincode')));
        if (!empty($logincode)) {
            ICookie::set('logincode', $logincode, 86400);
        }
        if (!empty($uname)) {
            if (empty($uname)) {
                $this->message('member_emptyname', $link);
            }
            if (empty($pwd)) {
                $this->message('member_emptypwd', $link);
            }
            $logintype = IFilter::act(IReq::get('logintype'));
            if ($logintype != 'html5') {
                if (Mysite::$app->config['allowedcode'] == 1) {
                    $Captcha = IFilter::act(IReq::get('Captcha'));
                    if ($Captcha != ICookie::get('Captcha')) {
                        $this->message('member_codeerr', $link);
                    }
                }
            }
            if (!$this->memberCls->login($uname, $pwd)) {
                $this->message($this->memberCls->ero(), $link);
            }
            $link = IUrl::creatUrl('member/base');
            $this->success('', $link);
        }
    }
    public function loginout()
    {
        $this->memberCls->loginout();
		// if($_GET['ceshi'])
		// {
			// exit;
		// }
        $link = IUrl::creatUrl('member/shoplogin');
        $this->refunction('', $link);
    }
    public function payoncard()
    {
        $this->checkmemberlogin();
    }


    public function bindingwxlogin()
    {
        $userid = $this->member['uid'];
        $phone = IFilter::act(IReq::get('phone'));
        if (empty($phone)) {
            echo 'noshow(\'请填写手机号\')';
            exit;
        }
        if (!preg_match("/^1[34578]{1}\d{9}$/", $phone)) {
            echo  'noshow(\'手机格式错误\')';
            exit;
        }
        $makecode =  mt_rand(10000, 99999);
        $contents =  '绑定手机号，验证码为：'.$makecode;
        $phonecode = new phonecode($this->mysql, 0, $phone);
        $phonecode->sendother($contents);
        ICookie::set('bindingwxcode', $makecode, 90);
        ICookie::set('bindingwx', $phone, 90);
        $longtime = time()+90;
        ICookie::set('bindingwxlogintime', $longtime, 90);
        echo 'showsend(\''.$phone.'\',90,\''.$userid.'\')';
        exit;
    }




    public function paylog()
    {
        $this->checkmemberlogin();
        $data['sitetitle'] = '资金变换记录';
        $data['nowdate'] = date('Y-m-d', (time() - 30*24*60*60));

        $status = intval(IFilter::act(IReq::get('status')));
        $starttime =  IFilter::act(IReq::get('starttime'));
        $endtime =  IFilter::act(IReq::get('endtime'));
        $starttime = empty($starttime)?  time() - 30*24*60*60:strtotime($starttime.' 00:00:01');
        $endtime = empty($endtime)? time():strtotime($endtime.' 23:59:59');

        $statusarr = array(1=>'',2=>' and addtype != 1 ',3=>' and addtype = 1');
        $where = in_array($status, array(1,2,3)) ? $statusarr[$status]:'';
        $where .= ' and addtime > '.$starttime.' and '.$endtime;
        $data['where'] = ' userid = '.$this->member['uid'].' and type=2 '.$where;
        Mysite::$app->setdata($data);
    }



    public function jifenlog()
    {
        $this->checkmemberlogin();
        $data['sitetitle'] = '积分记录表';
        $what = trim(IFilter::act(IReq::get('what')));
        $query = array('out'=>' and addtype != 1','in'=>' and addtype = 1');
        $where = in_array($what, array('out','in'))? $query[$what]:'';
        $data['what'] = in_array($what, array('out','in'))? $what:'';
        $link = in_array($what, array('out','in'))? '/member/jifenlog/what/'.$what.'/page/@page@':'/membercenter/jifenlog/page/@page@';
        $data['where'] = ' userid =\''.$this->member['uid'].'\' and type=1 '.$where;
        Mysite::$app->setdata($data);
    }

    public function xiugaimempwd()
    { //会员密码
        //'oldpaypwd':$('#oldpaypwd').val(),'newpaypwd':$('#newpaypwd').val(),'verifynewpaypwd':$('#').val()
        $this->checkmemberlogin();
        $oldpaypwd = trim(IFilter::act(IReq::get('oldpaypwd')));
        $newpaypwd = trim(IFilter::act(IReq::get('newpaypwd')));
        $verifynewpaypwd = trim(IFilter::act(IReq::get('verifynewpaypwd')));
        if (empty($oldpaypwd)) {
            $this->message('原密码为空');
        }
        if ($this->member['password'] != '') {
            if (md5($oldpaypwd) != $this->member['password']) {
                $this->message('原密码不正确');
            }
        }
        if (empty($newpaypwd)) {
            $this->message('emptynewpwd');
        }
        if ($newpaypwd !=  $verifynewpaypwd) {
            $this->message('member_twopwdnoequale');
        }
        $data['password'] = md5($newpaypwd);
        $this->mysql->update(Mysite::$app->config['tablepre'].'member', $data, "uid ='".$this->member['uid']."' ");
        #	 ICookie::clear('uid');
        $this->success('success');
    }

    public function safepwd()
    {  //支付密码
        //'oldpaypwd':$('#oldpaypwd').val(),'newpaypwd':$('#newpaypwd').val(),'verifynewpaypwd':$('#').val()
        $this->checkmemberlogin();
        $oldpaypwd = trim(IFilter::act(IReq::get('oldpaypwd')));
        $newpaypwd = trim(IFilter::act(IReq::get('newpaypwd')));
        $verifynewpaypwd = trim(IFilter::act(IReq::get('verifynewpaypwd')));
        if ($this->member['safepwd'] != '') {
            if (md5($oldpaypwd) != $this->member['safepwd']) {
                $this->message('member_safepwderr');
            }
        }
        if (empty($newpaypwd)) {
            $this->message('emptynewpwd');
        }
        if ($newpaypwd !=  $verifynewpaypwd) {
            $this->message('member_twopwdnoequale');
        }
        $data['safepwd'] = md5($newpaypwd);
        $this->mysql->update(Mysite::$app->config['tablepre'].'member', $data, "uid ='".$this->member['uid']."' ");
        $this->success('success');
    }

    public function edituser()
    {
        $this->checkmemberlogin();
        $data['showaction'] = IFilter::act(IReq::get('showaction'));
        $data['sitetitle'] = '修改密码';
        Mysite::$app->setdata($data);
    }
    public function saveuser()
    {
        $this->checkmemberlogin();
        $controlname = IFilter::act(IReq::get('controlname'));
        switch ($controlname) {
               case 'username':
                 $arra['username'] = trim(IFilter::act(IReq::get('obj')));
                 if (!(IValidate::len($arra['username'], 3, 20))) {
                     $this->message('member_usernamelent3to30');
                 }
                 $checkinfo = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."member where username='".$arra['username']."'");
                 if ($checkinfo > 0) {
                     $this->message('member_repeatname');
                 }
                 $this->mysql->update(Mysite::$app->config['tablepre'].'member', $arra, 'uid = '.$this->member['uid'].' ');
                  $this->success('success');
               break;
               case 'email':
                 $arra['email'] = trim(IFilter::act(IReq::get('obj')));
                  if (!empty($this->member['email'])) {
                      $this->message('member_cantemail');
                  }
                 if (!(IValidate::email($arra['email']))) {
                     $this->message('erremail');
                 }
                 $checkinfo = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."member where email='".$arra['email']."'");
                 if ($checkinfo > 0) {
                     $this->message('exitemail');
                 }
                 $this->mysql->update(Mysite::$app->config['tablepre'].'member', $arra, 'uid = '.$this->member['uid'].' ');
                  $this->success('success');
               break;
               case 'mobile':

                 $arra['phone'] = trim(IFilter::act(IReq::get('obj')));
               #  if(!empty($this->member['phone'])) $this->message('member_cantphone');
                 if (!(IValidate::suremobi($arra['phone']))) {
                     $this->message('errphone');
                 }
                  $checkinfo = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."member where phone='".$arra['phone']."'");
                 if ($checkinfo > 0) {
                     $this->message('exitphone');
                 }
                 $checkinfo = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."member where phone='".$arra['phone']."'");
                 $this->mysql->update(Mysite::$app->config['tablepre'].'member', $arra, 'uid = '.$this->member['uid'].' ');
                  $this->success('success');
               break;
               case 'pwd':
                 $pwd =  IFilter::act(IReq::get('pwd'));
               $newpwd = IFilter::act(IReq::get('newpwd'));
              $newpwd2 = IFilter::act(IReq::get('newpwd2'));
              if (empty($pwd)) {
                  $this->message('oldpwderr');
              }
              $checkpass = md5($pwd);
              if ($checkpass != $this->member['password']) {
                  $this->message('oldpwderr');
              }
              if (empty($newpwd)) {
                  $this->message('emptynewpwd');
              }
              if ($newpwd != $newpwd2) {
                  $this->message('member_twopwdnoequale');
              }
              $arr['password'] = md5($newpwd);
            $this->mysql->update(Mysite::$app->config['tablepre'].'member', $arr, "uid='".$this->member['uid']."'");
            $this->memberCls->loginout();
                $this->success('success');
                // no break
               default:
               $this->message('nodefined_func');
               break;

         }
    }
    public function linktest()
    {
        $logintype = IFilter::act(IReq::get('logintype'));
        if (in_array($logintype, array('qq','sina'))) {
            $link =  Mysite::$app->config['siteurl']."/plug/login/".$logintype."/login.php";
            $this->message('', $link);
        } else {
            $link = IUrl::creatUrl('member/login');

            $this->message('未定义的接口', $link);
        }
    }
    public function otherlogin()
    {
        $logintype = IFilter::act(IReq::get('logintype'));

        if (empty($logintype)) {
            $this->message('other_emptyapi');
        }
        $logindir = hopedir.'/plug/login/'.$logintype;
        #  print_r($logindir);

        if (!file_exists($logindir.'/back.php')) {
            $this->error('other_emptyapi');
        }
        $apiinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."otherlogin where loginname='".$logintype."'  ");
        if (empty($apiinfo)) {
            $this->message('other_notinstallapi');
        }

        include_once($logindir.'/back.php');
    }
    public function bandaout()
    {
        $logintype = ICookie::get('adlogintype');

        $token = ICookie::get('adtoken');
        $openid = ICookie::get('adopenid');
        if (empty($logintype)) {
            $this->message('other_emptyapi');
        }
        if (!empty($this->member['uid'])) {
            $this->message('member_islogin');
        }
        $apiinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."otherlogin where loginname='".$logintype."'  ");
        if (empty($apiinfo)) {
            $this->message('other_notinstallapi');
        }
        $data['apiinfo'] = $apiinfo;
        $data['uid'] = $this->member['uid'];
        $data['allowedcode'] =  Mysite::$app->config['allowedcode'];
        $data['apiuname'] = ICookie::get('apiuname');
        $data['apiemail'] = ICookie::get('apiemail');
        $data['apilogo'] = ICookie::get('apilogo');

        Mysite::$app->setdata($data);
    }
    public function saveregester()
    {
        if (!empty($this->member['uid'])) {
            $this->message('member_islogin');
        }
        $tname = IFilter::act(IReq::get('tname'));
        $password = IFilter::act(IReq::get('pwd'));
        $email = IFilter::act(IReq::get('email'));
        $phone = IFilter::act(IReq::get('phone'));
        $password2 = IFilter::act(IReq::get('pwd2'));
        $phoneyan =  IFilter::act(IReq::get('phoneyan'));
        $checklogin =  IFilter::act(IReq::get('checklogin'));


        if ($password2 != $password) {
            $this->message('member_twopwdnoequale');
        }

        if (Mysite::$app->config['regestercode'] == 1) {
            if (empty($phoneyan)) {
                $this->message('member_codeerr');
            }

            if (!empty($phone)) {
                $phonecls = new phonecode($this->mysql, 0, $phone);
//
//				if($phonecls->checkcode($phoneyan)){
//				}else{
//
// 					 $this->message($phonecls->getError());
//				}
            } elseif (!empty($email)) {
                $checkcode =    ICookie::get('regemailcode');
                if ($phoneyan != $checkcode) {
                    $this->message('member_codeerr1');
                }
            }
        } else {
            if (Mysite::$app->config['allowedcode'] == 1) {
                $Captcha = IFilter::act(IReq::get('Captcha'));
                if ($Captcha != ICookie::get('Captcha')) {
                    $this->message('member_codeerr');
                }
            }
        }
        if ($this->memberCls->regester($email, $tname, $password, $phone, 5)) {
            $this->memberCls->login($tname, $password);
            $this->success('success');
        } else {
            $this->message($this->memberCls->ero());
        }
    }
    public function checkemail()
    {
        $uname = IFilter::act(IReq::get('uname'));
        if ($this->memberCls->checkemail($uname)) {
            $this->success('error');
        } else {
            $this->message('true');
        }
    }
    public function checkname()
    {
        $uname = IFilter::act(IReq::get('uname'));
        if ($this->memberCls->checkname($uname)) {
            $this->success('error');
        } else {
            $this->message($this->memberCls->ero());
        }
    }
    public function savefind()
    {
        $uname =IFilter::act(IReq::get('uname'));
        if ($this->memberCls->findpwd($uname)) {
            $this->success('success');
        } else {
            $this->message($this->memberCls->ero());
        }
    }
    public function payonline()
    {
        //在线支付
        $this->checkmemberlogin();
        $paytype =  IReq::get('paydotype') ;

        //	$paytype='alipay';
        $cost = intval(IReq::get('cost'));
        if ($cost < 10) {
            $this->message('card_limit');
        }
        $paylist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."paylist   order by id asc limit 0,50");
        if (is_array($paylist)) {
            foreach ($paylist as $key=>$value) {
                $paytypelist[] =$value['loginname'];
            }
        }
        if (!in_array($paytype, $paytypelist)) {
            $this->message('other_nodefinepay');
        }
        $paydir = hopedir.'/plug/pay/'.$paytype;

        if (!file_exists($paydir.'/pay.php')) {
            $this->message('other_notinstallapi');
        }
        $dopaydata = array('type'=>'acount','upid'=>$this->member['uid'],'cost'=>$cost);//支付数据
        include_once($paydir.'/pay.php');
    }

    //发送邮箱验证码
    public function regesteremail()
    {
        $regestercode = Mysite::$app->config['regestercode'];
        $checkcode =    ICookie::get('regemailcode');
        $checkphone =   ICookie::get('regemail');
        $checktime =   ICookie::get('regtime');
        if (empty($regestercode)) {
            echo 'noshow(\'不需要验证CODE\')';
            exit;
        }
        if (!empty($checkcode)) {
            $backtime = $checktime-time();
            if ($backtime > 0) {
                echo 'showsendemail(\''.$checkphone.'\','.$backtime.')';
                exit;
            }
        }
        if (!empty($this->member['uid'])) {
            echo 'noshow(\'已登陆\')';
            exit;
        }
        $email = IFilter::act(IReq::get('email'));
        if (!(IValidate::email($email))) {
            echo '';
            exit;
        }
        $userinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where email='".$email."' ");
        if (!empty($userinfo)) {
            echo 'noshow(\'邮箱已注册\')';
            exit;
        }


        $makecode =  mt_rand(10000, 99999);
        $title =Mysite::$app->config['sitename'].'注册验证码';
        $smtp = new ISmtp(Mysite::$app->config['smpt'], 25, Mysite::$app->config['emailname'], Mysite::$app->config['emailpwd'], false);
        $content = '欢迎注册'.Mysite::$app->config['sitename'].'会员,注册验证码为:'.$makecode;
        $info = $smtp->send($email, Mysite::$app->config['emailname'], $title, $content, "", "HTML", "", "");
        ICookie::set('regemailcode', $makecode, 180);
        ICookie::set('regemail', $email, 180);
        $longtime = time()+180;
        ICookie::set('regtime', $longtime, 180);
        echo 'showsendemail(\''.$email.'\',180)';
        exit;
    }
    //发送手机验证码
    public function regesterphone()
    {
        $regestercode = Mysite::$app->config['regestercode'];
        if (empty($regestercode)) {
            echo 'noshow(\'不需要验证CODE\')';
            exit;
        }
        if (!empty($this->member['uid'])) {
            echo 'noshow(\'已登陆\')';
            exit;
        }
        $phone = IFilter::act(IReq::get('phone'));
        $phonecls = new phonecode($this->mysql, 0, $phone);
        if ($phonecls->sendcode()) {
            echo 'showsend(\''.$phone.'\','.$phonecls->getTime().')';
            exit;
        } else {
            echo 'noshow(\''.$phonecls->getError().'\')';
            exit;
        }
    }
    //手机号快捷登录获取验证码
    public function fastloginphone()
    {
        $regestercode = Mysite::$app->config['regestercode'];
        if (empty($regestercode)) {
            echo 'noshow(\'不需要验证CODE\')';
            exit;
        }
        if (!empty($this->member['uid'])) {
            echo 'noshow(\'已登陆\')';
            exit;
        }
        $phone = IFilter::act(IReq::get('phone'));
        $phonecls = new phonecode($this->mysql, 4, $phone);
        if ($phonecls->sendcode()) {
            echo 'showsend(\''.$phone.'\','.$phonecls->getTime().')';
            exit;
        } else {
            echo 'noshow(\''.$phonecls->getError().'\')';
            exit;
        }
    }
    public function shoplogin()
    {
        if (strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger')) {
            //判断是微信浏览器不
            echo file_get_contents(Mysite::$app->config['siteurl']."/index.php?ctrl=site&action=wxopen");
            exit;
        }
    }

    public function shoploginin()
    {
        $uname = IFilter::act(IReq::get('uname'));
        $pwd = IFilter::act(IReq::get('pwd'));
        if (empty($uname)) {
            $this->message('member_emptyname');
        }
        if (empty($pwd)) {
            $this->message('member_emptypwd');
        }
        if (Mysite::$app->config['allowedcode'] == 1) {
            $Captcha = IFilter::act(IReq::get('Captcha'));
            if ($Captcha != ICookie::get('Captcha')) {
                $this->message('member_codeerr');
            }
        }

        if (!$this->memberCls->login($uname, $pwd)) {
            $this->message($this->memberCls->ero());
        }
        $checkuid = $this->memberCls->getuid();
        $userinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where    is_pass=1 and uid=".$checkuid." ");
        if (empty($userinfo)) {
            $this->message('shop_noexit');
        }
        ICookie::set('adminshopid', $userinfo['id'], 86400);
        $this->success('success');
    }

    public function resetpwd()
    {
        if (!empty($this->member['uid'])) {
            $link = IUrl::creatUrl('member/base');
            $this->message('', $link);
        }
        $username = trim(IFilter::act(IReq::get('username')));
        $sign = trim(IFilter::act(IReq::get('sign')));
        $uid = intval(IFilter::act(IReq::get('uid')));
        $link = IUrl::creatUrl('member/findpwd');
        $newpwd = trim(IFilter::act(IReq::get('newpwd')));
        $newpwd2 = trim(IFilter::act(IReq::get('newpwd2')));
        $data['error'] = '';
        if (!empty($newpwd)) {
            if ($this->memberCls->resetpwd($username, $sign, $uid, $newpwd, $newpwd2)) {
                if ($this->memberCls->ero() == 'ok') {
                    $link = IUrl::creatUrl('member/login');
                    $this->message('success', $link);
                } else {
                    $data['error'] = $this->memberCls->ero();
                }
            } else {
                //$data['error'] = $this->memberCls->ero();
                $link = IUrl::creatUrl('member/findpwd');
                $this->message($this->memberCls->ero(), $link);
            }
        }
        $data['sitetitle'] = '重置密码';
        $data['actionlink'] = '/index.php/member/resetpwd/uid/'.$uid.'/username/'.$username.'/sign/'.$sign;
        Mysite::$app->setdata($data);
    }

    public function drawbacklog()
    {
        if (empty($this->member['uid'])) {
            $link = IUrl::creatUrl('member/login');
            $this->message('', $link);
        }
    }
    public function savedrawbacklog()
    {
        if (empty($this->member['uid'])) {
            $this->message('member_nologin');
        }

        $dno = trim(IFilter::act(IReq::get('dno')));
        $data['reason'] = trim(IFilter::act(IReq::get('reason')));
        $data['content'] = trim(IFilter::act(IReq::get('content')));
        $data['phone'] = trim(IFilter::act(IReq::get('phone')));
        $data['contactname'] = trim(IFilter::act(IReq::get('contactname')));
        $typeid = intval(IFilter::act(IReq::get('typeid')));
        if (empty($dno)) {
            $this->message('order_noexit');
        }
        if ($typeid == 1) {
            $orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where dno='".$dno."' ");
            if (empty($orderinfo)) {
                $this->message('order_noexit');
            }
            if ($orderinfo['buyeruid'] != $this->member['uid']) {
                $this->message('order_baknoown');
            }
            if ($orderinfo['paystatus'] != 1) {
                $this->message('order_nopay');
            }
            if ($orderinfo['status'] < 1 && $orderinfo['status'] < 3) {
                $this->message('order_cantdoorder');
            }
            if ($orderinfo['paytype'] == 'outpay'||empty($orderinfo['paytype'])) {
                $this->message('order_iswaitcantbak');
            }
            if (!empty($orderinfo['is_reback'])) {
                $this->message('order_bakrepeat');
            }
            $checklog = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."drawbacklog where orderid='".$orderinfo['id']."' ");
        } else {
            if (empty($data['reason'])) {
                $this->message('order_bakreason');
            }
            if (empty($data['content'])) {
                $this->message('order_bakcontent');
            }
            if (!(IValidate::suremobi($data['phone']))) {
                $this->message('errphone');
            }
            if (empty($data['contactname'])) {
                $this->message('emptycontact');
            }
            $orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where dno='".$dno."' ");
            if (empty($orderinfo)) {
                $this->message('order_noexit');
            }
            if ($orderinfo['buyeruid'] != $this->member['uid']) {
                $this->message('order_baknoown');
            }
            if ($orderinfo['paystatus'] != 1) {
                $this->message('order_nopay');
            }
            if ($orderinfo['status'] < 1 && $orderinfo['status'] < 3) {
                $this->message('order_cantdoorder');
            }
            if ($orderinfo['paytype'] == 'outpay'||empty($orderinfo['paytype'])) {
                $this->message('order_iswaitcantbak');
            }
            if (!empty($orderinfo['is_reback'])) {
                $this->message('order_bakrepeat');
            }
            $checklog = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."drawbacklog where orderid='".$orderinfo['id']."' ");
            if (!empty($checklog)) {
                $this->message('order_bakrepeat');
            }
        }
        $data['orderid'] = $orderinfo['id'];
        $data['uid'] = $this->member['uid'];
        $data['username'] = $this->member['username'];
        $data['status'] = 0;
        $data['addtime'] = time();
        $data['cost'] = $orderinfo['allcost'];
        $data['admin_id'] = $orderinfo['admin_id'];
        $data['type'] = $typeid;
        $this->mysql->insert(Mysite::$app->config['tablepre'].'drawbacklog', $data);
        $udata['is_reback'] = 1;
        $this->mysql->update(Mysite::$app->config['tablepre'].'order', $udata, "id='".$orderinfo['id']."'");
        $this->success('success');
    }


    /* 新增代理商功能 */


    //代理商后台管理员登陆
    public function saveagentlogin()
    {
        $signup_name =  IFilter::act(IReq::get('signup_name'));
        $signup_password =  IFilter::act(IReq::get('signup_password'));
        if (!empty($signup_name)) {
            $userinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."admin where username ='".$signup_name."'");
            if ($userinfo['groupid'] != 4) {
                $this->message("不是代理商用户！");
            }
            if (empty($signup_password)) {
                $this->message('密码为空！');
            }
            if ($userinfo['password'] != md5($signup_password)) {
                $this->message('密码不正确！');
            }
            $data['loginip'] = IClient::getIp();
            $data['logintime'] = time();
            $this->mysql->update(Mysite::$app->config['tablepre'].'admin', $data, "uid='".$userinfo['uid']."'");
            ICookie::set('agentadminname', $userinfo['username'], 86400);
            ICookie::set('agentadminpwd', $signup_password, 86400);
            ICookie::set('agentadminuid', $userinfo['uid'], 86400);
            $this->success('success');
        }
    }

    //代理商后台管理员退出
    public function agentadminloginout()
    {
        ICookie::clear('agentadminname');
        ICookie::clear('agentadminpwd');
        ICookie::clear('agentadminuid');
        ICookie::clear('agentadminshopid');
        $link = IUrl::creatUrl('member/agentlogin');
        $this->refunction('', $link);
    }



    //新增 8.5
    //获取会员地址列表
    public function address()
    {
        if (empty($this->member['uid'])) {
            $this->message('未登录');
        }
        $this->checkmemberlogin();
        $addresslist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."address where userid ='".$this->member['uid']."'");
        $data['addresslist'] = $addresslist;
        $this->success($data);
    }

    //根据店铺ID和配送地址ID检测是否在配送范围，如果在配送范围计算配送费
    public function checkIsPaPsrange()
    {
        if (empty($this->member['uid'])) {
            $this->message('未登录');
        }
        $uid = $this->member['uid'];
        $shopid = intval(IReq::get('shopid'));
        $addressid = intval(IReq::get('addressid'));

        if (empty($shopid)) {
            $this->message('店铺信息获取失败');
        }
        if (empty($addressid)) {
            $this->message('地址获取失败');
        }

        $buyerlng = '';
        $buyerlat = '';
        $addressone = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."address where userid ='".$this->member['uid']."'  and  id ='".$addressid."'   ");
        if (!empty($addressone)) {
            $buyerlng = $addressone['lng'];
            $buyerlat = $addressone['lat'];
        }

        $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where  id ='".$shopid."'   ");
        if (!empty($shopinfo)) {
            if ($shopinfo['shoptype'] == 1) {
                $shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket where  shopid ='".$shopinfo['id']."'   ");
            } else {
                $shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast where  shopid ='".$shopinfo['id']."'   ");
            }
        }
        if (!empty($shopdet)) {
            $shopinfo = array_merge($shopinfo, $shopdet);
        }
        $psdata = $this->pscost($shopinfo, $buyerlng, $buyerlat);
        $data['psdata'] = $psdata;

        $this->success($data);
    }
}
