<?php
/*
*   method 方法  包含所有会员相关操作
    管理员/会员  添加/删除/编辑/用户登陆
    用户日志其他相关连的通过  memberclass关联
*/
class method extends adminbaseclass
{
    public function index()
    {
        $link = IUrl::creatUrl('member/memberlist');
        $this->refunction('', $link);
    }

    public function memberlist()
    {
        $data['username'] =  trim(IReq::get('username'));
        $data['email'] =  trim(IReq::get('email'));
        $data['groupid'] >= 5;
        $data['phone'] =  trim(IReq::get('phone'));
		$data['stationadminid'] =  trim(IReq::get('stationadminid'));
        //构造查询条件
        $newlink = '';
        $where = ' where 1 ';
        if (!empty($data['username'])) {
            $where .= " and username like '%".$data['username']."%'";
            $newlink .= '/username/'.$data['username'];
        }
        if (!empty($data['phone'])) {
            $where .=" and phone='".$data['phone']."'";
            $newlink .= '/phone/'.$data['phone'];
        }
        if (!empty($data['email'])) {
            $where .=" and email='".$data['email']."'";
            $newlink .= '/phone/'.$data['email'];
        }
        if (!empty($data['stationadminid'])) {
            $where .=" and stationadminid='".$data['stationadminid']."'";
            $newlink .= '/stationadminid/'.$data['stationadminid'];
        }

        $data['where'] = $where;

        $pageinfo = new page();
        $pageinfo->setpage(intval(IReq::get('page')), 20);

        $member_list = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."member $where   order by uid desc   limit ".$pageinfo->startnum().", ".$pageinfo->getsize()." ");
        $shuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."member $where   order by uid desc");
        $pageinfo->setnum($shuliang);
        $pagelink = IUrl::creatUrl('adminpage/member/module/memberlist'.$newlink);
        $data['pagecontent'] = $pageinfo->getpagebar($pagelink);
        foreach($member_list as $key => $member)
        {
            $order_data = $this->mysql->select_one("select count(id) as order_count,sum(allcost) as allcost from ".Mysite::$app->config['tablepre']."order  where buyeruid = '".$member['uid']."' and status >1 and status < 4");
            $member_list[$key]['order_count'] = $order_data['order_count'];
            $member_list[$key]['allcost'] = $order_data['allcost'];
        }
        $data['member_list'] = $member_list;
        Mysite::$app->setdata($data);
    }



    public function memberlistshop()
    {
        $data['username'] =  trim(IReq::get('username'));
        $data['email'] =  trim(IReq::get('email'));
        $data['groupid'] = 3;
        $data['phone'] =  trim(IReq::get('phone'));
        $data['stationid'] =  intval(IReq::get('stationid'));
        //构造查询条件
        $where = ' where 1';
        $newlink = '';
        if (!empty($data['username'])) {
            $where .= " and m.username like '%".$data['username']."%'";
            $newlink .= '/username/'.$data['username'];
        }
        if (!empty($data['email'])) {
            $where .=" and m.email='".$data['email']."'";
            $newlink .= '/phone/'.$data['email'];
        }
        if (!empty($data['stationid'])) {
            $where .=" and s.stationid='".$data['stationid']."'";
            $newlink .= '/stationid/'.$data['stationid'];
        }

        $pageshow = new page();
        $pageshow->setpage(IReq::get('page'), 20);
        $link = IUrl::creatUrl('/adminpage/member/module/memberlistshop'.$newlink);

        $memberlistshop = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."member as m join ".Mysite::$app->config['tablepre']."shop as s on s.uid = m.uid ".$where."  order by m.uid desc limit ".$pageshow->startnum().", ".$pageshow->getsize()."");

        $shuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."member as m join ".Mysite::$app->config['tablepre']."shop as s on s.uid = m.uid ".$where." ");
        $pageshow->setnum($shuliang);
        $data['pagecontent'] = $pageshow->getpagebar($link);
        $data['memberlistshop'] = $memberlistshop;
        $data['where'] = $where;

        Mysite::$app->setdata($data);
    }

    public function adminlist()
    {
        $grouplist =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."group where type ='admin'  ");
        $temp = array();
        foreach ($grouplist as $key=>$value) {
            $temp[$value['id']] = $value['name'];
            $ids[] = $value['id'];
        }
        $data['grouplist'] = $temp;
        $data['ids'] = implode(',', $ids);

        Mysite::$app->setdata($data);
    }

    //后台添加管理员
    public function saveadmin()
    {
        // limitalert();
        $uid = IReq::get('uid');
        $username = IReq::get('username');
        $password = IReq::get('password');
        $groupid = IReq::get('groupid');
        if (empty($uid)) {
            if (empty($username)) {
                $this->message('member_emptyname');
            }
            if (empty($username)) {
                $this->message('member_emptypwd');
            }
            $testinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."admin where username='".$username."' ");
            if (!empty($testinfo)) {
                $this->message('member_repeatname');
            }
            $arr['username'] = $username;
            $arr['password'] = md5($password);
            $arr['time'] = time();
            $arr['groupid'] = $groupid;
            $this->mysql->insert(Mysite::$app->config['tablepre'].'admin', $arr);
        } else {
            $testinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."admin where username='".$username."' ");
            if (empty($testinfo)) {
                $this->message('member_editfail');
            }
            if (!empty($password)) {
                $arr['password'] = md5($password);
            }
            $arr['groupid'] = $groupid;
            $this->mysql->update(Mysite::$app->config['tablepre'].'admin', $arr, "uid='".$uid."'");
        }
        $this->success('success');
        // $this->json(array('error'=>false));
    }
    //后台删除管理管理员
    public function deladmin()
    {
        #limitalert();
        #$tmsg = limitalert();
        #if(!empty($tmsg)) $this->message($tmsg);

        $uid = intval(IReq::get('id'));
        if (empty($uid)) {
            $this->message('member_emptyuid');
        }
        if ($uid  == 1) {
            $this->message('member_cantdel');
        }
        $this->mysql->delete(Mysite::$app->config['tablepre'].'admin', "uid = '$uid'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'applogin', "uid = '$uid'");
        $this->success('success');
    }
    public function addmember()
    {
        $url = $_SERVER["HTTP_REFERER"];
        $data['ref_url'] = $url;
        Mysite::$app->setdata($data);
    }
    //后台保存会员
    public function savemember()
    { //limitalert();
        $uid = intval(IReq::get('uid'));
        $data['username'] = IReq::get('username');
        $data['password'] = IReq::get('password');
        $data['phone'] = IReq::get('phone');
        $data['address'] = IReq::get('address');
        $data['email'] = IReq::get('email');
        $data['group'] = IReq::get('group');
        $data['score']=  IReq::get('score');
		$data['stationadminid']=  IReq::get('stationadminid');
        if ($uid > 0) {
            $checkmem = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$uid."' ");
            if (!empty($checkmem)) {
                $cost = $checkmem['cost'];
            } else {
                $this->message("获取用户信息失败");
            }
        } else {
            $cost = IReq::get('cost');
        }

        if (empty($uid)) {
            if ($this->memberCls->regester($data['email'], $data['username'], $data['password'], $data['phone'], $data['group'], '', $data['address'], $data['cost'], $data['score'], $data['admin_id'],$data['stationadminid'])) {
                $this->success('success');
            } else {
                $this->message($this->memberCls->ero());
            }
        } else {
            $default_cityid = isset(Mysite::$app->config['default_cityid'])?Mysite::$app->config['default_cityid']:0;
            $data['admin_id'] = $default_cityid;

            if ($this->memberCls->modify($data, $uid)) {
                $is_phonenotice = IReq::get('is_phonenotice');  //是否短信通知 1为通知  0不通知
                $notice_content = trim(IReq::get('notice_content'));


                $bdliyou = $is_phonenotice==0?"管理员直接操作变动":$notice_content;
                if ($is_zengjian > 0) {
                    $this->memberCls->addlog($uid, 2, $is_zengjian, $yuecost, '管理员操作金额', $bdliyou, $data['cost']);
                    $this->memberCls->addmemcostlog($uid, $checkmem['username'], $checkmem['cost'], $is_zengjian, $yuecost, $data['cost'], $bdliyou, ICookie::get('adminuid'), ICookie::get('adminname'));
                }
                if ($is_phonenotice == 1) {
                    $this->fasongmsg($notice_content, $data['phone'])  ;
                    $this->success('success');
                }
            } else {
                $this->message($this->memberCls->ero());
            }
        }
        $this->success('操作成功');
    }
    public function fasongmsg($notice_content, $phone)
    {
        $contents = $notice_content;
        $phonecode = new phonecode($this->mysql, 0, $phone);
        if (strlen($contents) > 498) {
            $content1 = substr($contents, 0, 498);
            $phonecode->sendother($content1);
            $content2 = substr($contents, 498, strlen($contents));
            $phonecode->sendother($content2);
        } else {
            $phonecode->sendother($contents);
        }
    }
    //后台删除会员
    public function delmember()
    {

         #limitalert();

        if (!empty($tmsg)) {
            $this->message($tmsg);
        }

        $uid = intval(IReq::get('id'));
        if (empty($uid)) {
            $this->message('member_emptyuid');
        }

        /*删除相关店铺**/
        /*用户直接相关部分*/
        $this->mysql->delete(Mysite::$app->config['tablepre'].'member', "uid = '$uid'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'oauth', "uid = '$uid'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'giftlog', "uid = '$uid'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'address', "userid = '$uid'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'comment', "uid = '$uid'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'collect', "uid = '$uid'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'card', "uid = '$uid'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'ask', "uid = '$uid'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'juan', "uid = '$uid'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'memberlog', "userid = '$uid'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'applogin', "uid = '$uid'");
        $data['is_bang'] = 0;
        $this->mysql->update(Mysite::$app->config['tablepre'].'wxuser', $data, "uid = '$uid'");
        $testinfo = $this->mysql->select_one("select id from ".Mysite::$app->config['tablepre']."shop where uid='".$uid."' ");
        if (!empty($testinfo)) {
            $this->mysql->delete(Mysite::$app->config['tablepre'].'shop', "id = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'shopfast', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'shopattr', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'shopsearch', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'areatoadd', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'areashop', "shopid = '".$testinfo['id']."'");
            /*2017-06-27  start*/
            $this->mysql->delete(Mysite::$app->config['tablepre'].'shopjs', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'shoptx', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'shopreal', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'shopsearch', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'shopwait', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'ask', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'comment', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'drawbacklog', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'excomment', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'drawbacklog', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'orderps', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'product', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'orderps', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'shophui', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'shophuiorder', "shopid = '".$testinfo['id']."'");
            /*2017-06-27   end*/
            $this->mysql->delete(Mysite::$app->config['tablepre'].'goods', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'goodstype', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'order', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'orderdet', "shopid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'searkey', " type=1 and goid = '".$testinfo['id']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'rule', "shopid = '".$testinfo['id']."'");
        }
        $this->success('success');
    }
    //后台保存会员组
    public function savegroup()
    {
        // limitalert();
        $id = intval(IReq::get('id'));
        $data['name'] = IReq::get('name');
        $type = IReq::get('type');
        if (empty($data['name'])) {
            $this->message('member_group_noexit');
        }
        $data['type'] = $type == 1?'admin':'font';
        if (empty($id)) {
            $testinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."group where name='".$data['name']."' ");
            if (!empty($testinfo)) {
                $this->message('member_group_repeat');
            }
            $this->mysql->insert(Mysite::$app->config['tablepre'].'group', $data);
        } else {
            $this->mysql->update(Mysite::$app->config['tablepre'].'group', $data, "id='".$id."'");
        }
        $this->success('success');
    }
    //后台删除会员组
    public function delgroup()
    {

          /* limitalert();

         $tmsg = limitalert();
        if(!empty($tmsg)) $this->message($tmsg); */


        $uid = intval(IReq::get('id'));
        if (empty($uid)) {
            $this->message('member_emptyuid');
        }
        if (in_array($uid, array(1,2,3,4,5))) {
            $this->message('member_group_system');
        }
        $this->mysql->delete(Mysite::$app->config['tablepre'].'group', "id = '$uid'");
        $this->success('success');
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
    public function adminmodify()
    {
        limitalert();

        $oldpwd = trim(IReq::get('oldpwd'));
        $pwd  = trim(IReq::get('pwd'));
        if (empty($oldpwd)) {
            $this->message('emptyoldpwd');
        }
        if (empty($pwd)) {
            $this->message('emptynewpwd');
        }
        if ($this->admin['password'] != md5($oldpwd)) {
            $this->message('oldpwderr');
        }
        $arr['password'] = md5($pwd);
        $this->mysql->update(Mysite::$app->config['tablepre'].'admin', $arr, "uid='".$this->admin['uid']."'");
        $this->success('success');
    }

    public function membergrade()
    {
        $configs = new config('membergrade.php', hopedir);
        $data['membergrade'] = $configs->getInfo();

        Mysite::$app->setdata($data);
    }
    public function savemembergrade()
    {
        limitalert();
        $gradename =   IFilter::act(IReq::get('gradename'));
        $from =   IFilter::act(IReq::get('from'));
        $to =   IFilter::act(IReq::get('to'));
        if (!is_array($gradename)) {
            $this->message('member_grade_formaterr');
        }
        if (count($gradename) != count($from)) {
            $this->message('member_grade_counterr');
        }
        if (count($gradename) != count($to)) {
            $this->message('member_grade_jifenerr');
        }
        $newarray = array();
        foreach ($gradename as $key=>$value) {
            $temp['gradename'] = $value;
            $temp['from'] = $from[$key];
            $temp['to'] = $to[$key];
            $newarray[] = $temp;
        }


        $configData = var_export($newarray, true);
        $configStr = "<?php return {$configData}?>";
        $fileObj   = new IFile(hopedir.'/config/membergrade.php', 'w+');
        $fileObj->write($configStr);

        $this->success('success');
    }
    public function gradeinstro()
    {
        $configs = new config('membergrade.php', hopedir);
        $data['membergrade'] = $configs->getInfo();

        //总长度900px;

        $data['perlong'] = intval(900/(count($data['membergrade'])));


        Mysite::$app->setdata($data);
    }

    public function setmemsafepwd()
    {
        $uid = intval($this->admin['uid']) ;
        $data['id'] = $uid;

        $testinfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."safepwd where adminuid='".$uid."' ");
        print_r($testinfo);
        Mysite::$app->setdata($data);
    }
    // 保存用户验证密码
    public function savememsafepwd()
    {
        limitalert();
        $uid = IFilter::act(IReq::get('uid')) ;

        $checksafeinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."safepwd where adminuid='".$uid."' ");
        if (!empty($checksafeinfo)) {
            $this->message('管理员已设置过验证密码');
        }

        $pwd = IFilter::act(IReq::get('password'));
        if (empty($pwd)) {
            $this->message('验证密码为空！');
        }
        $data['adminuid'] = $uid;
        $data['password'] = md5($pwd);
        $data['addtime']  = time();
        $data['type']     = 0;
        $this->mysql->insert(Mysite::$app->config['tablepre'].'safepwd', $data);
        $this->success('success');
    }
    public function xiugaimemsafepwd()
    {
        limitalert();
        # print_r($this->admin['uid']);
        # exit;
        $oldpwd  = trim(IReq::get('oldpwd'));
        $md5oldpwd  = md5(trim(IReq::get('oldpwd')));
        $newpwd  = trim(IReq::get('newpwd'));
        if (empty($oldpwd)) {
            $this->message('旧密码不能为空！');
        }
        $checksafeinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."safepwd where adminuid='".$this->admin['uid']."'   ");
        if (empty($checksafeinfo)) {
            $this->message('用户不存在！');
        }

        if ($checksafeinfo['password'] != md5($oldpwd)) {
            $this->message('旧密码不正确！');
        }
        if (empty($newpwd)) {
            $this->message('新密码不能为空！');
        }

        $arr['password'] = md5($newpwd);
        $this->mysql->update(Mysite::$app->config['tablepre'].'safepwd', $arr, "adminuid='".$this->admin['uid']."'");
        $this->success('success');
    }
    public function memcostloglist()
    {
        $querytype = IReq::get('querytype');
        $searchvalue = IReq::get('searchvalue');
        $starttime = IReq::get('starttime');
        $endtime = IReq::get('endtime');
        $nowday = date('Y-m-d', time());
        $starttime = empty($starttime)? $nowday:$starttime;
        $endtime = empty($endtime)? $nowday:$endtime;
        $where = '  where addtime > '.strtotime($starttime.' 00:00:00').' and addtime < '.strtotime($endtime.' 23:59:59');
        $data['starttime'] = $starttime;
        $data['endtime'] = $endtime;
        $newlink = '/starttime/'.$starttime.'/endtime/'.$endtime;
        $data['searchvalue'] ='';
        $data['querytype'] ='';
        if (!empty($querytype)) {
            if (!empty($searchvalue)) {
                $data['searchvalue'] = $searchvalue;
                $where .= ' and '.$querytype.' LIKE \'%'.$searchvalue.'%\' ';
                $newlink .= '/searchvalue/'.$searchvalue.'/querytype/'.$querytype;
                $data['querytype'] = $querytype;
            }//IUrl::creatUrl('admin/asklist/commentlist
        }

        $link = IUrl::creatUrl('/adminpage/member/module/memcostloglist'.$newlink);
        $pageshow = new page();
        $pageshow->setpage(IReq::get('page'), 10);
        //order: id  dno 订单编号 shopuid 店铺UID shopid 店铺ID shopname 店铺名称 shopphone 店铺电话 shopaddress 店铺地址 buyeruid 购买用户ID，0未注册用户 buyername
        //

        $memcostloglist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."memcostlog ".$where."  order by addtime desc limit ".$pageshow->startnum().", ".$pageshow->getsize()."");
        $shuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."memcostlog  ".$where." ");
        $pageshow->setnum($shuliang);
        $data['pagecontent'] = $pageshow->getpagebar($link);
        $data['memcostloglist'] = $memcostloglist;

        Mysite::$app->setdata($data);
    }
}
