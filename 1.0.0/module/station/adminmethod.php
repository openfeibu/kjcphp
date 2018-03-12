<?php
class method extends adminbaseclass
{
    //分站列表
    public function stationlist()
    {
        $querytype = IReq::get('querytype');
        $searchvalue = IReq::get('searchvalue');
        $status = intval(IReq::get('status'));
        $cityid = intval(IReq::get('cityid'));
        $where = '  where 1  ';

        $data['searchvalue'] ='';
        $data['querytype'] ='';
        $newlink = '';
        if (!empty($querytype)) {
            if (!empty($searchvalue)) {
                $data['searchvalue'] = $searchvalue;
                $where .= ' and '.$querytype.' LIKE \'%'.$searchvalue.'%\' ';
                $newlink .= '/searchvalue/'.$searchvalue.'/querytype/'.$querytype;
                $data['querytype'] = $querytype;
            }
        }

        $data['status'] = '';
        if ($status > 0) {
            $newstatus = $status -1;
            $where .=  ' and st.stationis_open = '.$newstatus;
            $data['status'] = $status;
            $newlink .= '/status/'.$status;
        }
        $data['cityid'] = '';
        if ($cityid > 0) {
            $where .=  ' and st.cityid = '.$cityid;
            $data['cityid'] = $cityid;
            $newlink .= '/cityid/'.$cityid;
        }

        $link = IUrl::creatUrl('/adminpage/station/module/stationlist'.$newlink);
        $pageshow = new page();
        $pageshow->setpage(IReq::get('page'), 10);
        //order: id  dno 订单编号 shopuid 店铺UID shopid 店铺ID shopname 店铺名称 shopphone 店铺电话 shopaddress 店铺地址 buyeruid 购买用户ID，0未注册用户 buyername
        //
        $data['stationlist'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."stationadmininfo as st ".$where." order by st.id desc limit ".$pageshow->startnum().", ".$pageshow->getsize()."");

        $shuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."stationadmininfo as st ".$where." ");
        $pageshow->setnum($shuliang);
        $data['pagecontent'] = $pageshow->getpagebar($link);

        Mysite::$app->setdata($data);
    }
    public function managestation()
    {
        $id = intval(IReq::get('id'));
        $data['id'] = $id;
        $data['citylist'] = array();
        $temparr =	$this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."area where   id > 0 and parent_id = 0  order by orderid asc    ");
        if (!empty($temparr)) {
            foreach ($temparr as $key=>$value) {
                $checkinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."stationadmininfo where cityid='".$value['id']."' ");
                if (empty($checkinfo)) {
                    $data['citylist'][] = $value;
                }
            }
        }
        Mysite::$app->setdata($data);
    }
    //城市列表
    public function citylist()
    {
        $newlink= '';
        $where = "  id > 0 and parent_id = 0   ";
        $page=new page();//实例化分页类
        $page->setpage(intval(IReq::get('page')), 10);//赋初始值（偏移值、每页个数）
        $data['citylist']=	$this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."area where   ".$where."   order by orderid asc    limit ".$page->startnum().", ".$page->getsize());
        $pageCount	=$this->mysql->counts("select id from ".Mysite::$app->config['tablepre']."area where   ".$where." order by id desc");
        $page->setnum($pageCount);//总页数
        $pagelink = IUrl::creatUrl('adminpage/station/module/citylist'.$newlink);
        $data['pagecontent']=$page->getpagebar($pagelink);//显示分页
        Mysite::$app->setdata($data);
    }
    //删除城市
    public function delcity()
    {
        limitalert();

        $uid = intval(IReq::get('id'));
        if (empty($uid)) {
            $this->message('area_empty');
        }
        $this->mysql->delete(Mysite::$app->config['tablepre'].'area', "id = '$uid'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'areashop', "areaid = '$uid'");
        $this->success('success');
        ;
    }
    //删除分站
    public function delstation()
    {
        limitalert();

        $uid = intval(IReq::get('id'));
        if (empty($uid)) {
            $this->message('未选中');
        }
        $this->mysql->delete(Mysite::$app->config['tablepre'].'stationadmininfo', "uid = '$uid'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'admin', "uid = '$uid'");
        $this->success('success');
        ;
    }
    //新增或者编辑城市
    public function savecity()
    {

#limitalert();
        $id = intval(IReq::get('uid'));
        $data['name'] = IReq::get('name');
        $data['orderid']  = intval(IReq::get('orderid'));
        $data['pin'] = strtoupper(IReq::get('pin'));
        $data['parent_id'] = 0;
        $data['adcode'] =  intval(IReq::get('adcode'));
        $data['procode'] =  intval(IReq::get('procode'));
        if (empty($id)) {
            $data['lng'] = 0;
            $data['lat'] = 0;
            $link = IUrl::creatUrl('station/citylist');
            if (empty($data['name'])) {
                $this->message('area_emptyname', $link);
            }
            if (empty($data['pin'])) {
                $this->message('area_emptyfirdstword', $link);
            }
            if (empty($data['adcode'])) {
                $this->message('获取区域编码失败1', $link);
            }
            if (empty($data['procode'])) {
                $this->message('获取区域编码失败2', $link);
            }


            $adreinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area where adcode='".$data['adcode']."' ");
            if (!empty($adreinfo)) {
                $this->message('此城市已添加过，请勿重新添加');
            }

            if (!$this->mysql->insert(Mysite::$app->config['tablepre'].'area', $data)) {
                $this->message('system_err');
            }
        } else {
            $link = IUrl::creatUrl('area/adminarealist/id/'.$id);
            if (empty($data['name'])) {
                $this->message('area_emptyname', $link);
            }
            if (empty($data['pin'])) {
                $this->message('area_emptyfirdstword', $link);
            }
            if (empty($data['adcode'])) {
                $this->message('获取区域编码失败1', $link);
            }
            if (empty($data['procode'])) {
                $this->message('获取区域编码失败2', $link);
            }

            $this->mysql->update(Mysite::$app->config['tablepre'].'area', $data, "id='".$id."'");
        }
        $link = IUrl::creatUrl('station/citylist');
        $this->success('success', $link);
    }
    //添加分站

    //后台添加管理员
    public function savestationadmin()
    {
        # limitalert();
        $is_selfsitecx = intval(IReq::get('is_selfsitecx'));
        $uid = IReq::get('uid');
        $stationid = IReq::get('stationid');
        //$uid = ;
        //$username = trim(IReq::get('username'));
        //$password = trim(IReq::get('password'));
        $stationname = trim(IReq::get('stationname'));
        $stationusername = trim(IReq::get('stationusername'));
        $stationphone = trim(IReq::get('stationphone'));
        $stationlnglat = trim(IReq::get('stationlnglat'));
        $stationaddress = trim(IReq::get('stationaddress'));
        $orderid = intval(IReq::get('orderid'));
        $stationis_open = trim(IReq::get('stationis_open'));
        $cityid = trim(IReq::get('cityid'));
        //如果不允许分站自行设置优惠促销，则删除该分站下的促销活动

        if ($is_selfsitecx == 0) {
            $this->mysql->delete(Mysite::$app->config['tablepre'] . 'rule', "cityid = '$cityid'");
        }
        // if (empty($username)) {
        //     $this->message('member_emptyname');
        // }

        if (empty($stationid)) {
            /*
            if (empty($password)) {
                $this->message('member_emptypwd');
            }
            $testinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."admin where username='".$username."' ");
            if (!empty($testinfo)) {
                $this->message('member_repeatname');
            }
            */
            if (empty($stationname)) {
                $this->message('分站名称不能为空');
            }
            if (empty($stationusername)) {
                $this->message('分站负责人不能为空');
            }
            if (empty($stationphone)) {
                $this->message('分站负责人电话不能为空');
            }
            if (empty($cityid)) {
                $this->message('请选择所属城市');
            }
            /*
            $checkinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."stationadmininfo where cityid='".$cityid."' ");

            if (!empty($checkinfo)) {
                $this->message('所选城市已占用，请选择其他城市');
            }
            */
             if(empty($stationlnglat)){
                 $this->message('请设置分站地图坐标');
             }
             /*
            if (empty($stationaddress)) {
                $this->message('请填写分站地址');
            }

            $arr['username'] = $username;
            $arr['password'] = md5($password);
            $arr['time'] = time();
            $arr['groupid'] = 4;

            $this->mysql->insert(Mysite::$app->config['tablepre'].'admin', $arr);
            $stationuid = $this->mysql->insertid();
            */
            $stationlnglat = explode(',',$stationlnglat);
            $adddata = array();
            $adddata['uid'] = 1;
            $adddata['stationname'] = $stationname;
            $adddata['stationusername'] = $stationusername;
            $adddata['stationphone'] = $stationphone;
            $adddata['cityid'] = $cityid;
            $adddata['lng'] = $stationlnglat[0];
            $adddata['lat'] = $stationlnglat[1];
            $adddata['stationaddress'] = $stationaddress;
            $adddata['orderid'] = $orderid;
            $adddata['is_selfsitecx'] = $is_selfsitecx;
            $adddata['stationis_open'] = $stationis_open;

            $this->mysql->insert(Mysite::$app->config['tablepre'].'stationadmininfo', $adddata);
        } else {
            /*
            $testinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."admin where username='".$username."' ");
            if (empty($testinfo)) {
                $this->message('member_editfail');
            }
            if (!empty($password)) {
                $arr['password'] = md5($password);
            }
            */
            if (empty($stationname)) {
                $this->message('分站名称不能为空');
            }
            if (empty($stationusername)) {
                $this->message('分站负责人不能为空');
            }
            if (empty($stationphone)) {
                $this->message('分站负责人电话不能为空');
            }
            if(empty($stationlnglat)){
                 $this->message('请设置分站地图坐标');
             }
             /*
            if (empty($stationaddress)) {
                $this->message('请填写分站地址');
            }

            if (!empty($arr)) {
                $this->mysql->update(Mysite::$app->config['tablepre'].'admin', $arr, "uid='".$uid."'");
            }
            */
            $stationlnglat = explode(',',$stationlnglat);
            $updataarr = array();
            $updataarr['stationname'] = $stationname;
            $updataarr['stationusername'] = $stationusername;
            $updataarr['stationphone'] = $stationphone;
            $updataarr['lng'] = $stationlnglat[0];
            $updataarr['lat'] = $stationlnglat[1];
            $updataarr['stationaddress'] = $stationaddress;
            $updataarr['orderid'] = $orderid;
            $updataarr['stationis_open'] = $stationis_open;
            $updataarr['is_selfsitecx'] = $is_selfsitecx;
            $this->mysql->update(Mysite::$app->config['tablepre'].'stationadmininfo', $updataarr, "id='".$stationid."'");
        }
        $this->success('success');
        // $this->json(array('error'=>false));
    }
    //分站商家
    public function stationshoplist()
    {
        $this->setstatus();
        $where = ' and admin_id > 0 ';
        $data['shopname'] =  trim(IReq::get('shopname'));
        $data['username'] =  trim(IReq::get('username'));
        $data['phone'] = trim(IReq::get('phone'));
        $data['cityid'] = intval(IReq::get('cityid'));
        if (!empty($data['shopname'])) {
            #  $where .= " and shopname='".$data['shopname']."'";
            $where .= " and shopname like '%".$data['shopname']."%'";
        }
        if (!empty($data['username'])) {
            $where .= " and uid in(select uid from ".Mysite::$app->config['tablepre']."member where username='".$data['username']."')";
        }
        if (!empty($data['phone'])) {
            $where .=" and phone='".$data['phone']."'";
        }
        if (!empty($data['cityid'])) {
            $where .=" and admin_id='".$data['cityid']."'";
        }

        //构造查询条件
        $data['where'] = $where;

        Mysite::$app->setdata($data);
    }
    public function setstatus()
    {
        $data['buyerstatus'] = array(
           '0'=>'待处理订单',
           '1'=>'待发货',
           '2'=>'订单已发货',
           '3'=>'订单完成',
           '4'=>'买家取消订单',
           '5'=>'卖家取消订单'
           );
        $paytypelist = array(0=>'货到支付',1=>'在线支付','weixin'=>'微信支付');

        $data['shoptype'] = array(
         '0'=>'外卖',
         '1'=>'超市',
         '2'=>'其他',
         );
        $data['ordertypearr'] = array(
           '0'=>'网站',
           '1'=>'网站',
           '2'=>'电话',
           '3'=>'微信',
           '4'=>'AndroidAPP',
           '5'=>'手机网站',
           '6'=>'iosApp',
           '7'=>'后台客服下单',
           '8'=>'商家后台下单',
           '9'=>'html5手机站'
           );
        $data['backarray'] = array(
           '0'=>'',
           '1'=>'退款中..',
           '2'=>'退款成功',
           '3'=>'拒绝退款'
           );

        $data['payway'] = array(
           'open_acout'=>'余额支付',
           'weixin'=>'微信支付',
           'alipay'=>'支付宝',
           'alimobile'=>'手机支付宝'
           );

        $data['paytypearr'] = $paytypelist;
        Mysite::$app->setdata($data);
    }

    //获取搜索省市区编码列表
    public function getcitylist()
    {
        $searchval = trim(IReq::get('searchval'));
        $areacodelist = array();
        if (!empty($searchval)) {
            $where = " where name like '%".$searchval."%'";
            $areacodelist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."areacode  ".$where." ");
        }
        $this->success($areacodelist);
    }

    //分站订单列表查看
    public function stationorderlist()
    {
        $this->setstatus();
        $querytype = IReq::get('querytype');
        $searchvalue = IReq::get('searchvalue');
        $orderstatus = intval(IReq::get('orderstatus'));
        $cityid = intval(IReq::get('cityid'));
        $starttime = IReq::get('starttime');
        $endtime = IReq::get('endtime');
        $nowday = date('Y-m-d', time());
        $starttime = empty($starttime)? $nowday:$starttime;
        $endtime = empty($endtime)? $nowday:$endtime;
        $where = '  where ord.addtime > '.strtotime($starttime.' 00:00:00').' and ord.addtime < '.strtotime($endtime.' 23:59:59');
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
            }
        }
        if (!empty($cityid)) {
            $data['cityid'] = $cityid;
            $where .= empty($where)?' where ord.admin_id ='.$cityid:' and ord.admin_id = '.$cityid;
            $newlink .= '/cityid/'.$cityid;
        }

        $data['orderstatus'] = '';

        if ($orderstatus > 0) {
            if ($orderstatus  > 4) {
                $where .= empty($where)?' where ord.status > 3 ':' and ord.status > 3 ';
            } else {
                $newstatus = $orderstatus -1;
                $where .= empty($where)?' where ord.status ='.$newstatus:' and ord.status = '.$newstatus;
            }
            $data['orderstatus'] = $orderstatus;
            $newlink .= '/orderstatus/'.$orderstatus;
        }
        $link = IUrl::creatUrl('/adminpage/station/module/stationorderlist'.$newlink);
        $pageshow = new page();
        $pageshow->setpage(IReq::get('page'), 5);
        //order: id  dno 订单编号 shopuid 店铺UID shopid 店铺ID shopname 店铺名称 shopphone 店铺电话 shopaddress 店铺地址 buyeruid 购买用户ID，0未注册用户 buyername
        //

        $orderlist = $this->mysql->getarr("select ord.*,mb.username as acountname from ".Mysite::$app->config['tablepre']."order as ord left join  ".Mysite::$app->config['tablepre']."member as mb on mb.uid = ord.buyeruid   ".$where." order by ord.id desc limit ".$pageshow->startnum().", ".$pageshow->getsize()."");
        $shuliang  = $this->mysql->counts("select ord.*,mb.username as acountname from ".Mysite::$app->config['tablepre']."order as ord left join  ".Mysite::$app->config['tablepre']."member as mb on mb.uid = ord.buyeruid   ".$where." ");
        $pageshow->setnum($shuliang);
        $data['pagecontent'] = $pageshow->getpagebar($link);
        $data['list'] = array();
        if ($orderlist) {
            foreach ($orderlist as $key=>$value) {
                $value['detlist'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."orderdet where   order_id = ".$value['id']." order by id desc ");
                $value['buyeraddress'] = urldecode($value['buyeraddress']);
                $data['list'][] = $value;
            }
        }

        #	 print_r( $data['list'] );
        $data['scoretocost'] =Mysite::$app->config['scoretocost'];
        Mysite::$app->setdata($data);
    }


    public function stationcount()
    {
        $searchvalue = IReq::get('searchvalue');
        $starttime = trim(IReq::get('starttime'));
        $endtime = trim(IReq::get('endtime'));
        $stationid = intval(IReq::get('stationid'));
        $newlink = '';
        $where= ' where  id > 0  ';
        $where2 = '';
        $where3 = "";
        $data['searchvalue'] = '';
        if (!empty($searchvalue)) {
            $data['searchvalue'] = $searchvalue;
            $where .= ' and username = \''.$searchvalue.'\' ';
            $newlink .= '/searchvalue/'.$searchvalue;
        }
        $data['starttime'] = '';
        if (!empty($starttime)) {
            $data['starttime'] = $starttime;
            $where2 .= ' and  suretime > '.strtotime($starttime.' 00:00:01').' ';
            $where3 .=' and  suretime > '.strtotime($starttime.' 00:00:01').' ';
            $where4 .=' and  jstime > '.strtotime($starttime.' 00:00:01').' ';
            $newlink .= '/starttime/'.$starttime;
        }
        $data['endtime'] = '';
        if (!empty($endtime)) {
            $data['endtime'] = $endtime;
            $where2 .= ' and  suretime < '.strtotime($endtime.' 23:59:59').' ';
            $where3 .=' and  suretime < '.strtotime($endtime.' 23:59:59').' ';
            $where4 .=' and  jstime < '.strtotime($endtime.' 23:59:59').' ';
            $newlink .= '/endtime/'.$endtime;
        }
        $data['stationid'] = '';
        if (!empty($stationid)) {
            $data['endtime'] = $endtime;
            $where .= "  and id =   '".$stationid."'  ";
            $newlink .= '/stationid/'.$stationid;
            $data['stationid'] = $stationid;
        }
        $link = IUrl::creatUrl('/adminpage/station/module/stationcount'.$newlink);
        $pageinfo = new page();
        $pageinfo->setpage(IReq::get('page'), 10);

        $stationtj = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."stationadmininfo ".$where."   order by id asc  limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."");

        $list = array();

        if (is_array($stationtj)) {
            foreach ($stationtj as $key=>$value) {

                $value['stationname'] = $value['stationname'];

                $shopids = $this->mysql->getarr("select  id  from ".Mysite::$app->config['tablepre']."shop where stationid = ".$value['id']." ");

                if (!empty($shopids)) {
                    $yj = 0;
                    foreach ($shopids as $key1=>$value1) {
                        $shopjsinfo = $this->mysql->select_one("select sum(yjcost) as  yjcost  from ".Mysite::$app->config['tablepre']."shopjs where shopid = ".$value1['id']." ".$where4." ");
                        $yj = $yj + $shopjsinfo['yjcost'];
                    }
                    $value['yje'] = $yj;
                } else {
                    $value['yje'] = 0;
                }

                $shoptj=  $this->mysql->select_one("select  count(id) as shuliang,sum(cxcost) as cxcost,sum(yhjcost) as yhcost, sum(shopcost) as shopcost,sum(scoredown) as score, sum(shopps)as pscost, sum(bagcost) as bagcost,sum(allcost) as doallcost from ".Mysite::$app->config['tablepre']."order  where stationid > 0 and  stationid = '".$value['id']."' and  paytype ='0'   and status = 3 ".$where2." order by id asc  ");

                $line=  $this->mysql->select_one("select count(id) as shuliang,sum(cxcost) as cxcost,sum(yhjcost) as yhcost,sum(shopcost) as shopcost, sum(scoredown) as score, sum(shopps)as pscost, sum(bagcost) as bagcost,sum(allcost) as doallcost from ".Mysite::$app->config['tablepre']."order  where  stationid > 0 and stationid = '".$value['id']."' and paytype !='0'  and paystatus =1  and status = 3 ".$where2."   order by id asc   ");

                $value['orderNum'] =  $shoptj['shuliang']+$line['shuliang'];//订单总个数
                $value['online'] = $line['doallcost'];
                $value['unline'] = $shoptj['doallcost'];

                //商品销售金额     实际销售金额   支付宝付款金额   微信付款金额  促销金额   配送费  打包费 佣金
                //统计分站 商品销售金额(商品总金额不包含促销和配送费打包费) 实际销售金额（通过分站下单付给总站的总金额含配送费打包费不含促销）支付宝付款金额。 微信付款金额 促销金额 配送费  打包费。 佣金《商品销售金额百分比》
                $value['goodscost'] = round($shoptj['shopcost']+$line['shopcost'], 2);
                $value['cxcost'] = round($shoptj['cxcost']+$line['cxcost'], 2);
                $value['allcost'] = round($shoptj['doallcost']+$line['doallcost'], 2);
                $value['allcost'] = round($value['allcost']-$value['cxcost']);

                $value['pscost'] = round($shoptj['pscost']+$line['pscost'], 2);
                $value['bagcost'] = round($shoptj['bagcost']+$line['bagcost'], 2);

                /* $shopid = $value['shopid'];
                $shopinfo = $this->mysql->select_one("select  yjin  from ".Mysite::$app->config['tablepre']."shop where id = '".$shopid."'  ");

                if( $shopinfo['yjin'] == 0 ||   $shopinfo['yjin'] == '0.00' ||  $shopinfo['yjin'] == ''  ){
                     $yjinb = Mysite::$app->config['yjin'];
                 }else{
                     $yjinb = $shopinfo['yjin'];
                 }
               $value['yb'] = $yjinb * 0.01;
               $value['yje'] = $value['yb']*$value['goodscost'];
                 */

                //$value['outdetail'] =IUrl::creatUrl('adminpage/station/module/psyout/uid/'.$value['uid'].$newlink);
                $list[] = $value;
            }
        }


        $data['stationtj'] =$list;
        $shuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."area ".$where."  ");
        $pageinfo->setnum($shuliang);
        $data['pagecontent'] = $pageinfo->getpagebar($link);
        Mysite::$app->setdata($data);
    }
}
