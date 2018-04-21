<?php
/*
*   method 方法  包含所有会员相关操作
    管理员/会员  添加/删除/编辑/用户登陆
    用户日志其他相关连的通过  memberclass关联
*/
class method extends wxbaseclass
{
    public function setlogin()
    {
        $this->wxlogin();
        $code = IFilter::act(IReq::get('code'));
        if ($code != ICookie::get('wxcode')) {
            $wxinfo = $this->setwxlogin(1);
            ICookie::set('wxuser', $wxinfo, 86400);
            ICookie::set('wxcode', $code, 86400);
        } else {
            $wxinfo = ICookie::get('wxuser');
        }
        $user = $this->mysql->select_one("select a.phone from ".Mysite::$app->config['tablepre']."member as a left join ".Mysite::$app->config['tablepre']."wxuser as b on a.uid = b.uid  where b.openid = '".$wxinfo['wxuser']['openid']."'");
        if (empty($user['phone'])) {
            $link = IUrl::creatUrl('wxsite/wxbdphone');
            $this->message('', $link);
        } else {
            $this->setLoginInfo($wxinfo['wxuser'], $wxinfo['userinfo']);
            $defaultlink = IUrl::creatUrl('wxsite/member');
            $weblink = ICookie::get('wx_login_link');
            $link = empty($weblink)? $defaultlink:$weblink;
            $this->message('', $link);
        }
    }

    public function savewxbd()
    {
        $phone = IFilter::act(IReq::get('phone'));
        $code = IFilter::act(IReq::get('code'));
        $codec = ICookie::get('bindingwxcode');
        $checklogins = 0;
        if ($code != $codec) {
            $this->message("验证码错误");
        }
        $is_user = $this->mysql->select_one("select uid from ".Mysite::$app->config['tablepre']."member where phone ='".$phone."'  ");
        if (!empty($is_user)) {
            $is_wxuser = $this->mysql->select_one("select openid from ".Mysite::$app->config['tablepre']."wxuser where uid ='".$is_user['uid']."'  ");
            if (!empty($is_wxuser)) {
                $this->message("该手机号已绑定其他微信账号，请先解绑");
            }
        }
        $wxinfo = ICookie::get('wxuser');
        if (empty($wxinfo)) {
            $this->message("wxempty");
        }
        $wxinfo['wxuser']['phone'] = $phone;
        $this->setLoginInfo($wxinfo['wxuser'], $wxinfo['userinfo']);
        $checklogins = ICookie::get('checklogins');
        $this->success($checklogins);
    }

    public function loginmode()
    {
        if (strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger')) {
            $data['is_wxlogin'] = 1;
        } else {
            $data['is_wxlogin'] = 0;
        }
        Mysite::$app->setdata($data);
    }


    public function index()
    {
        $this->checkwxweb();
        $areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where phone='18768891083' ");
        $areacodeoness =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."wxuser where uid='".$areacodeone."' ");
        $lng = $this->lng;
        $lat = $this->lat;

        $station = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."stationadmininfo where stationis_open = 0 AND id = '".$this->stationid."' order by id desc");

        $data['lat'] = $lat;
        $data['lng'] = $lng;
        $data['addressname'] = $station['stationname'];
        $data['addressid'] = $station['id'];
        //判断平台类型  //2微信端,3web端
        $source = 3;
        if (strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger')) {
            $source = 2;
        }

        $julidatalistx = $this->Tdata($this->stationid, array(), array('mijuli'=>'asc'), $lat, $lng, $source);
        $data['julishoplist']  = $julidatalistx;
        $ordercountdatalistx = $this->Tdata($this->stationid, array(), array('mordercount'=>'desc'), $lat, $lng, $source);
        $data['ordercountshoplist']  = $ordercountdatalistx;
        $cxdatalist = $this->Tdata($this->stationid, array('cxtype' => '2,3'), array('maxcx'=>'desc'), $lat, $lng, $source);
        $data['cxdatalist']  = $cxdatalist;
        $shoptypelist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where parent_id <> 0 order by orderid  asc");
        foreach ($shoptypelist as $key => $value) {
            $shoptypelist[$key]['catelink'] = IUrl::creatUrl('/wxsite/shoplist/typelx/wm/typeid/'.$value['id'].'');
        }
        $data['shoptypelist']  = $shoptypelist;

        $data['stationlist'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."stationadmininfo where stationis_open = 0 order by id desc");

        // $data['juansetinfo'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 6");
        $time = time();
        $juansetinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 6 or name = '代金券活动' ");
        $juaninfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."alljuan where type = 6 AND count > 0 AND endtime > $time AND starttime <= $time order by id asc ");
        if(!empty($juansetinfo) && $juansetinfo['status'] == 1){
            foreach ($juaninfo as $key => $value) {
                $user_juan = $this->mysql->select_one("SELECT * FROM ".Mysite::$app->config['tablepre']."juan WHERE alljuanid = ".$value['id']." AND uid = ".$this->member['uid']." ");
                if(empty($user_juan))
                {
                    $have_juan = 1;
                }

            }
        }
        $data['have_juan'] = $have_juan;

        Mysite::$app->setdata($data);
    }

    public function loadindexshoplist()
    {
    }




    public function shoplist()
    {
        if (!strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger')) {    //判断是微信浏览器不
            $data['wxType'] = 2;
        } else {
            $data['wxType'] = 1;
        }
        $shopshowtype = 'waimai';

        $areaid = IFilter::act(IReq::get('areaid'));
        if ($areaid <= 0) {
            ICookie::clear('myaddress');
        }
        $data['typeid'] = IFilter::act(IReq::get('typeid'));



        $catewhere = "  and   cityid = '".$this->CITY_ID."' ";
        $shopcateinfo =array();
        $shopcateinfo = $this->mysql->select_one("select img,link from ".Mysite::$app->config['tablepre']."shopcateadv where cateid='".$data['typeid']."' ".$catewhere." order by orderid asc  ");
        $data['shopcateinfo']  = $shopcateinfo;


        $data['caipin']  = $this->mysql->getarr("select id,name from ".Mysite::$app->config['tablepre']."shoptype where parent_id <> 0  ");

        $data['shopshowtype'] = $shopshowtype;
        $shopsearch = IFilter::act(IReq::get('search_input'));
        $data['search_input'] = $shopsearch;

        $data['areaid'] = $areaid;
        Mysite::$app->setdata($data);
    }
    public function testshop()
    {
        ini_set('display_errors', 1);            //错误信息
        ini_set('display_startup_errors', 1);    //php启动错误信息
        error_reporting(-1);
        $orderclass = new orderclass();
        $orderclass->sendpsmess('33124');
        echo 'success';
        exit;
        Mysite::$app->setdata($data);
    }


    public function shoplistdata()
    {

        $shopshowtype = 'waimai';
        //返回的所有店铺数据
        $templist = array();

        //判断平台类型  //2微信端,3web端
        $source = 3;
        if (strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger')) {
            $source = 2;
        }
        $order = intval(IReq::get('order'));
        $order = in_array($order, array(1,2,3))? $order:0;
        $orderarray = array(
            //默认距离由近到远排序
            '0' =>array('juli'=>'asc'),
            //按好评由高到低排序
            '1'=>array('ping'=>'desc'),
            //按起送价由低到高排序
            '2'=>array('limitcost'=>'asc'),
            //按销量由高到低排序
            '3'=>array('sell'=>'desc'),
        );

        $catid = intval(IReq::get('catid'));//店铺分类id

        $sendtype = intval(IReq::get('sendtype'));
        $cxtype = intval(IReq::get('cxtype'));

        $lng = $this->lng;
        $lat = $this->lat;


        $limitarr['shoptype'] = 1;
        $limitarr['shopcat'] = $catid;
        $limitarr['sendtype'] = $sendtype;
        $limitarr['cxtype'] = $cxtype;
        if ($shopshowtype == 'dingtai') {
            $limitarr['is_goshop'] = 1;
        } else {
            $limitarr['is_waimai'] = 1;
        }
        $datalistx = $this->Tdata($this->stationid, $limitarr, $orderarray[$order], $lat, $lng, $source);

        /*获取店铺*/
        $pageinfo = new page();
        $pageinfo->setpage(intval(IReq::get('page')));
        $starnum = $pageinfo->startnum();
        $pagesize = 10;

        for ($k = 0;$k<$pagesize;$k++) {
            $checknum = $starnum+$k;
            if (isset($datalistx[$checknum])) {
                $templist[] = $datalistx[$checknum];
            } else {
                break;
            }
        }


        $data['shopshowtype'] = $shopshowtype;
        $data['shoplist']  = $templist;
        Mysite::$app->setdata($data);
    }


    public function shopshow()
    {//店铺详情

        $areaid = ICookie::get('myaddress');
        $typelx = IFilter::act(IReq::get('typelx'));

        $data['typelx'] = 'wm';

        $id = intval(IReq::get('id'));
        $d = (date("w") ==0) ?7:date("w") ;

        $cxrule = $this->mysql->getarr("select name,id,imgurl from ".Mysite::$app->config['tablepre']."rule where  FIND_IN_SET(".$id.",shopid)   and status = 1   and ( limittype = 1 or ( limittype = 2 and  find_in_set(".$d.",limittime) )  or ( limittype = 3 and endtime > ".time()." and starttime < ".time().")) ");

        $data['cxlist'] = $cxrule;
        $data['id'] = $id;

        $shopinfo1 = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where id='".$id."'  ");
        // print_r($shopinfo1);
        if (empty($shopinfo1)) {
            $shopinfo1['shopname'] = Mysite::$app->config['sitename'];
            $shopinfo1['shoplogo'] = Mysite::$app->config['sitelogo'];
            $shopinfo1['intr_info'] = Mysite::$app->config['sitename'];
        }
        $data['shopinfo1'] = $shopinfo1;
        $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where id='".$id."' ");   //店铺基本信息
        #print_r($shopinfo);
        $weekji = date('w');

        if (empty($shopinfo)) {
            //需要进行跳转
            $link = IUrl::creatUrl('wxsite/shoplist');
            $this->message('', $link);
        }

        $shopdet = array();

        $shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast where shopid='".$id."' ");

        $nowhour = time();

        $data['openinfo'] = $this->shopIsopen($shopinfo['is_open'], $shopinfo['starttime'], $shopdet['is_orderbefore'], $nowhour);

        $data['collect'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."collect where  collecttype = 0 and uid = ".$this->member['uid']." and collectid  = '".$shopinfo['id']."' ");//收藏

        $data['shopinfo'] = $shopinfo;
        $data['shopdet'] = $shopdet;
        $templist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodstype  where shopid='".$id."' order by orderid asc  ");
        $data['goodstype'] = array();
        $wheretype  = '';
        if ($shopshowtype == 'dingtai') {
            $wheretype = "and is_dingtai = 1 and    FIND_IN_SET( ".$weekji." , `weeks` )    ";
        } else {
            $wheretype = "and is_waisong = 1 and    FIND_IN_SET( ".$weekji." , `weeks` )    ";
        }

        foreach ($templist as $key=>$value) {
            $value['det'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goods where shopid='".$id."'  ".$wheretype."  and typeid =".$value['id']."  and is_live = 1 order by good_order asc");
            $newdet=array();
            foreach ($value['det'] as $k=>$val) {
                if ($val['is_cx'] == 1) {
                    //测算促销 重新设置金额
                    $cxdata = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goodscx where goodsid=".$val['id']."  ");
                    $newdata = getgoodscx($val['cost'], $cxdata);
                    $val['zhekou'] = $newdata['zhekou'];
                    $val['is_cx'] = $newdata['is_cx'];
                    $val['cost'] = $newdata['cost'];
                    $val['cxnum'] = $cxdata['cxnum'];
                }
                if ($val['have_det'] == 1) {
                    $price=array();
                    $gooddet = $this->mysql->getarr("select cost from ".Mysite::$app->config['tablepre']."product where goodsid=".$val['id']."  ");
                    #print_r($gooddet);
                    foreach ($gooddet as $keyd=>$vald) {
                        $price[] = $vald['cost'];
                    }
                    $val['cost'] = min($price);//获取多规格商品中价格最小的价格作为展示价格
                }
                $val['sellcount'] = $val['sellcount']+$val['virtualsellcount'];
                $newdet[]=$val;
            }
            $value['det']=  $newdet;
            #print_r($value['det']);
            $data['goodstype'][]  = $value;
        }

        $shopdet['id'] = $id;
        $shopdet['shoptype']=1;
        $newshoparray = array_merge($shopinfo, $shopdet);
        $tempinfo =   $this->pscost($newshoparray);
        $backdata['pstype'] = $tempinfo['pstype'];

        if ($shopshowtype == 'dingtai') {
            $backdata['pscost'] =0;
        } else {
            $backdata['pscost'] = $tempinfo['pscost'];
        }

        $data['psinfo'] = $backdata;
        $data['mainattr'] = array();
        $templist = $this->mysql->getarr("select id from ".Mysite::$app->config['tablepre']."shoptype where  cattype = ".$shopinfo['shoptype']." and parent_id = 0 and is_main =1  order by orderid asc limit 0,1000");
        foreach ($templist as $key=>$value) {
            $value['det'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where parent_id = ".$value['id']." order by orderid asc  limit 0,20");
            $data['mainattr'][] = $value;
        }
        $data['shopattr'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopattr  where  cattype = ".$shopinfo['shoptype']." and shopid = '".$shopinfo['id']."'  order by firstattr asc limit 0,1000");


        $data['weekji']  =$weekji ;

        $shopreal = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopreal where  shopid = ".$id." limit 0,4");//商家实景分类
        $data['shopreal']=array();
        foreach ($shopreal as $key=>$val) {
            $shoprealimg = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoprealimg where  parent_id = ".$val['id']);//商家实景分类图片
            $imgcount = $this->mysql->select_one("select count(id) as count from ".Mysite::$app->config['tablepre']."shoprealimg where  parent_id = ".$val['id']);//商家实景分类图片总数
            $val['shoprealimg']=$shoprealimg;
            $val['imgcount']=$imgcount['count'];

            $data['shopreal'][]=$val;
        }
        #print_r($data);
        //print_r($data['goodstype']);exit;

        /*   购物车开始  */
        $shopid = $shopinfo['id'];
        $backdata = array();
        $smardb = new newsmcart();
        $carinfo = array();
        if ($smardb->setdb($this->mysql)->SetShopId($shopid)->OneShop()) {
            $carinfo = $smardb->getdata();
            $backdata['list'] = $carinfo['goodslist'];
            $backdata['sumcount'] =$carinfo['count'];
            $backdata['sum'] =$carinfo['sum'];

            $shopcheckinfo =   $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id where a.shopid = '".$shopid."'    ");


            $backdata['bagcost'] =$carinfo['bagcost'];

            $cxclass = new sellrule();
            if (!strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger')) {    //判断是微信浏览器不
                $platform=3;//触屏
            } else {
                $platform=2;//微信
            }
            $areaid = ICookie::get('myaddress');
            $tempinfo =   $this->pscost($shopcheckinfo);
            $backdata['pstype'] = $tempinfo['pstype'];
            $backdata['canps'] = $tempinfo['canps'];
        }
        $data['backdata'] = $backdata;
        /*   购物车结束*/

        /*  优惠商品开始  */
        $cx_goodsids = array();
        $nowtime = time();
        $nowdate = date('Y-m-d', time());
        $checktime = $nowtime-strtotime($nowdate);
        $sql = "SELECT * FROM ".Mysite::$app->config['tablepre']."goods as g left join ".Mysite::$app->config['tablepre']."goodscx as gc on g.id = gc.goodsid WHERE g.shopid = $shopid AND g.is_cx = 1 AND g.is_live = 1 AND ".$nowtime." > gc.cxstarttime AND ".$nowtime." < gc.ecxendttime AND (($checktime > gc.cxstime1 AND $checktime < gc.cxetime1) OR ($checktime > gc.cxstime2 AND $checktime < gc.cxetime2)) ";
        $goods_list = $this->mysql->getarr($sql);
        foreach ($goods_list as $key => $goods) {
            $goods_list[$key]['cost'] = $goods['cost']*$goods['cxzhe']*0.01;
            $goods_list[$key]['zhekou'] = $goods['cxzhe']*0.1;
            $where1 = ' where ord.addtime > '.$goods['cxstarttime'] .' and ord.status = 3  and is_reback = 0';
            //$where1 = ' where ord.addtime > '.$goods['cxstarttime'] .'';
            $sql = "select count(ordet.id) as shuliang from ".Mysite::$app->config['tablepre']."orderdet  as ordet left join  ".Mysite::$app->config['tablepre']."order as ord on ordet.order_id = ord.id  ".$where1." and  ordet.goodsid = ".$goods['id']."";
            $goods_count_data = $this->mysql->select_one($sql);
            $sell_count = $goods_count_data['shuliang'];
            $goods_list[$key]['sell_count'] = $sell_count;
            $all_count = $sell_count + $goods['count'];
            $goods_list[$key]['percent'] = $sell_count <= 0 ? '0%' : ($goods['count'] > 0 ? round($sell_count/$all_count * 100 , 2) . "%" : '100%');
            $cx_goodsids[] = $goods['id'];
        }
        $data['cx_goods_list'] = $goods_list;
        $data['cx_goodsids'] = $cx_goodsids;
        /*  优惠商品结束  */
        Mysite::$app->setdata($data);

        if ($shopinfo['shoptype'] == 1) {
            Mysite::$app->setAction('mkshopshow');
        } else {
            Mysite::$app->setAction('shopshow');
        }
    }
    public function foodsgg()
    {   //新增  规格弹窗
        $shopshowtype = ICookie::get('shopshowtype');
        $data['shopshowtype'] = $shopshowtype;
        $id = intval(IReq::get('id'));
        $data['goodsid']=$id;
        $foodshow = $this->mysql->select_one("select * from  ".Mysite::$app->config['tablepre']."goods where id= ".$id."  ");
        $shopid = $foodshow['shopid'];
        $data['shopinfo'] = $this->mysql->select_one("select * from  ".Mysite::$app->config['tablepre']."shop where id= ".$shopid."  ");


        $shopdet  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where a.shopid = ".$shopid."   ");


        $nowhour = date('H:i:s', time());
        $nowhour = strtotime($nowhour);
        $checkinfo = $this->shopIsopen($data['shopinfo']['is_open'], $data['shopinfo']['starttime'], $shopdet['is_orderbefore'], $nowhour);
        $data['opentype'] = $checkinfo['opentype'];
        /* 商品评价 */
        $data['pointcount'] = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."comment   where shopid = ".$shopid." and  goodsid  = ".$id."   ");
        if ($foodshow['is_cx'] == 1) {
            //测算促销 重新设置金额
            $cxdata = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goodscx where goodsid=".$foodshow['id']."  ");
            $newdata = getgoodscx($foodshow['cost'], $cxdata);

            $foodshow['zhekou'] = $newdata['zhekou'];
            $foodshow['is_cx'] = $newdata['is_cx'];
            $foodshow['cost'] = $newdata['cost'];
            $foodshow['cxnum'] = $cxdata['cxnum'];
        }
        $foodshow['sellcount'] = $foodshow['sellcount']+$foodshow['virtualsellcount'];

        $data['shopdet'] = $shopdet;
        $data['foodshow']  = $foodshow;

        /* 配送费 */
        $newshoparray = array_merge($data['shopinfo'], $shopdet);
        $tempinfo =   $this->pscost($newshoparray);
        $backdata['pstype'] = $tempinfo['pstype'];
        $backdata['pscost'] = $tempinfo['pscost'];
        $data['psinfo'] = $backdata;



        $data['productinfo'] = !empty($foodshow)?unserialize($foodshow['product_attr']):array();

        $smardb = new newsmcart();
        $smardb->setdb($this->mysql)->SetShopId($shopid);
        $data['nowselect'] = array();
        if ($foodshow['have_det'] == 0) {
            $tempinfo = $smardb->SetGoodsType(1)->productone($id);

            $data['carnum'] =  $tempinfo;
        } else {
            $nowselect =$smardb->FindInproduct($id);
            $data['nowselect'] = $nowselect;
            $data['carnum'] = $nowselect['count'];
        }


        //获取product 在goodsid中的商品
        $data['attrids'] = array();
        if (!empty($nowselect)) {
            $data['attrids'] = explode(',', $nowselect['attrids']);
        }

        $productlist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."product where goodsid=".$id." and shopid=".$shopid."");
        $data['productlist'] = $productlist;

        $temparray = $this->mysql->getarr("select * from  ".Mysite::$app->config['tablepre']."comment where goodsid=".$id." and shopid=".$shopid." order by addtime desc limit 10 ");
        $commentlist = array();
        foreach ($temparray as $key=>$value) {
            $memberinfo = $this->mysql->select_one("select * from  ".Mysite::$app->config['tablepre']."member where uid = ".$value['uid']." ");
            $value['username'] =$memberinfo['username'];
            $commentlist[] = $value;
        }
        $data['commentlist'] = $commentlist;

        $shuliang = $this->mysql->select_one("select count(id) as zongshu , sum(point) as pointzongshu from  ".Mysite::$app->config['tablepre']."comment where goodsid=".$id." and shopid=".$shopid." order by addtime desc  ");

        $zongshu =  $shuliang['zongshu'];
        $pointzongshu =  $shuliang['pointzongshu'];
        if ($pointzongshu != 0) {
            $haoping = round($zongshu/$pointzongshu, 3)*5*100;
        } else {
            $haoping = 0;
        }
        $data['haoping'] = $haoping;   // 计算好评率
        Mysite::$app->setdata($data);
    }

    /*  改变函数 */
    public function foodshow()
    {   //菜品详情
        $shopshowtype = ICookie::get('shopshowtype');
        $data['shopshowtype'] = $shopshowtype;
        $id = intval(IReq::get('id'));
        $data['goodsid']=$id;
        $wxclass = new wx_s();
        $signPackage = $wxclass->getSignPackage();
        $data['signPackage'] = $signPackage;
        // print_r($data['signPackage']);
        // $shopinfo1 = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where id='".$id."'  ");
        //  // print_r($shopinfo1);
        // if( empty($shopinfo1) ){
        //  $shopinfo1['shopname'] = Mysite::$app->config['sitename'];
        //  $shopinfo1['shoplogo'] = Mysite::$app->config['sitelogo'];
        //  $shopinfo1['intr_info'] = Mysite::$app->config['sitename'];
        // }
        // $data['shopinfo1'] = $shopinfo1;

        $foodshow = $this->mysql->select_one("select * from  ".Mysite::$app->config['tablepre']."goods where id= ".$id."  ");
        $shopid = $foodshow['shopid'];
        $data['shopinfo'] = $this->mysql->select_one("select * from  ".Mysite::$app->config['tablepre']."shop where id= ".$shopid."  ");


        $shopdet  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where a.shopid = ".$shopid."   ");


        $nowhour = date('H:i:s', time());
        $nowhour = strtotime($nowhour);
        $checkinfo = $this->shopIsopen($data['shopinfo']['is_open'], $data['shopinfo']['starttime'], $shopdet['is_orderbefore'], $nowhour);
        $data['opentype'] = $checkinfo['opentype'];
        /* 商品评价 */
        $data['pointcount'] = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."comment   where shopid = ".$shopid." and  goodsid  = ".$id."   ");
        if ($foodshow['is_cx'] == 1) {
            //测算促销 重新设置金额
            $cxdata = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goodscx where goodsid=".$foodshow['id']."  ");
            $newdata = getgoodscx($foodshow['cost'], $cxdata);

            $foodshow['zhekou'] = $newdata['zhekou'];
            $foodshow['is_cx'] = $newdata['is_cx'];
            $foodshow['cost'] = $newdata['cost'];
            $foodshow['cxnum'] = $cxdata['cxnum'];
        }
        $foodshow['sellcount'] = $foodshow['sellcount']+$foodshow['virtualsellcount'];

        $data['shopdet'] = $shopdet;
        $data['foodshow']  = $foodshow;
        // print_r($data['foodshow']);

        /* 配送费 */
        $newshoparray = array_merge($data['shopinfo'], $shopdet);
        $tempinfo =   $this->pscost($newshoparray);
        $backdata['pstype'] = $tempinfo['pstype'];
        $backdata['pscost'] = $tempinfo['pscost'];
        $data['psinfo'] = $backdata;



        $data['productinfo'] = !empty($foodshow)?unserialize($foodshow['product_attr']):array();

        $smardb = new newsmcart();
        $smardb->setdb($this->mysql)->SetShopId($shopid);
        $data['nowselect'] = array();
        if ($foodshow['have_det'] == 0) {
            $tempinfo = $smardb->SetGoodsType(1)->productone($id);

            $data['carnum'] =  $tempinfo;
        } else {
            $nowselect =$smardb->FindInproduct($id);
            $data['nowselect'] = $nowselect;
            $data['carnum'] = $nowselect['count'];
        }


        //获取product 在goodsid中的商品
        $data['attrids'] = array();
        if (!empty($nowselect)) {
            $data['attrids'] = explode(',', $nowselect['attrids']);
        }
        #print_r($data['attrids']);exit;
        $productlist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."product where goodsid=".$id." and shopid=".$shopid."");
        $data['productlist'] = $productlist;

        $temparray = $this->mysql->getarr("select * from  ".Mysite::$app->config['tablepre']."comment where goodsid=".$id." and shopid=".$shopid." order by addtime desc limit 10 ");
        $commentlist = array();
        foreach ($temparray as $key=>$value) {
            $memberinfo = $this->mysql->select_one("select * from  ".Mysite::$app->config['tablepre']."member where uid = ".$value['uid']." ");
            $value['username'] =$memberinfo['username'];
            $commentlist[] = $value;
        }
        $data['commentlist'] = $commentlist;

        $shuliang = $this->mysql->select_one("select count(point) as pointzongshu from  ".Mysite::$app->config['tablepre']."comment where goodsid=".$id." and shopid=".$shopid." order by addtime desc  ");
        $commentlist = $this->mysql->select_one("select count(point) as zongshu from  ".Mysite::$app->config['tablepre']."comment where goodsid=".$id." and shopid=".$shopid." and point = 5 order by addtime desc  ");

        $zongshu =  $commentlist['zongshu'];
        $pointzongshu =  $shuliang['pointzongshu'];
        if ($pointzongshu != 0) {
            $haoping = round(($zongshu/$pointzongshu) * 100);
        } else {
            $haoping = 0;
        }
        $data['haoping'] = $haoping;   // 计算好评率
        Mysite::$app->setdata($data);
    }


    public function shopgoodslist()
    {//点菜

        $id = IFilter::act(IReq::get('id'));
        $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where id='".$id."' ");
        $data['shopinfo'] = $shopinfo;
        if (empty($shopinfo)) {
            //需要进行跳转
            $link = IUrl::creatUrl('wxsite/shoplist');
            $this->message('', $link);
        }
        $data['goodstype'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodstype where shopid='".$id."' ");
        $data['goodslist'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goods where shopid='".$id."' ");
        Mysite::$app->setdata($data);
    }
    public function shopcart()
    {//购物车
        $this->checkwxweb();
        $id = IFilter::act(IReq::get('id'));
        $data['scoretocost'] = Mysite::$app->config['scoretocost'];
        //  id  card 优惠劵卡号  card_password 优惠劵密码 status 状态，0未使用，1已绑定，2已使用，3无效    creattime 制造时间  cost 优惠金额   limitcost 购物车限制金额下限 endtime 失效时间    uid 用户ID    username 用户名    usetime 使用时间    name
        $data['juanlist'] =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."juan  where uid='".$this->member['uid']."' and endtime > ".time()." and status = 1   ");

        $data['juancount'] = !empty($data['juanlist']) ? count($data['juanlist']) : 0;
        //id    juanid  fafangtime  uid 顾客uid   username 顾客姓名   juanname 优惠卷名称  juancost 面值 juanlimitcost 限制金额  endtime 过期时间    lqstatus 默认0是未领取 1是用户已领取    status 状态 0未使，1已使用，2无效  juanshu 优惠卷数量   usetime 优惠卷使用时间
        $data['wxjuanlist'] =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."wxuserjuan  where uid='".$this->member['uid']."' and endtime > ".time()." and lqstatus = 1 and status = 0   ");

        #   print_r($data['wxjuanlist']);

        $shopinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where shopid = ".$id."   ");


        $nowtime = time();
        $timelist = array();
        $info = explode('|', $shopinfo['starttime']);
        $info = is_array($info)?$info:array($info);
        $data['is_open'] = 0;

        if ($shopinfo['is_open'] == 0  || $shopinfo['is_pass'] == 0) {
            $data['is_open'] = 0;
        }

        $nowhout = strtotime(date('Y-m-d', time()));//当天最小linux 时间
        $timelist = !empty($shopinfo['postdate'])?unserialize($shopinfo['postdate']):array();
        $data['timelist'] = array();
        $checknow = time();
        $whilestatic = $shopinfo['befortime'];
        $nowwhiltcheck = 0;
        while ($whilestatic >= $nowwhiltcheck) {
            $startwhil = $nowwhiltcheck*86400;
            foreach ($timelist as $key=>$value) {
                $stime = $startwhil+$nowhout+$value['s'];
                $etime = $startwhil+$nowhout+$value['e'];
                if ($etime  > $checknow) {
                    $tempt = array();
                    $tempt['value'] = $value['s']+$startwhil;
                    $tempt['s'] = date('H:i', $nowhout+$value['s']);
                    $tempt['e'] = date('H:i', $nowhout+$value['e']);
                    $tempt['d'] = date('Y-m-d', $stime);
                    $tempt['i'] =  $value['i'];
                    $tempt['cost'] =  isset($value['cost'])?$value['cost']:'0';

                    $tempt['name'] = $tempt['s'].'-'.$tempt['e'];
                    $datatimelist[] = $tempt;
                }
            }

            $nowwhiltcheck = $nowwhiltcheck+1;
        }

        foreach ($datatimelist as $k=>$v) {
            $dtime = date("H:i", time());
            $timearr = explode('-', $v['name']);

            if ($k == 0 && $dtime>$timearr[0] && $dtime<$timearr[1]) {
                $v['name']='立即配送';
            }
            $data['timelist'][]=$v;
        }

        if (empty($this->member['uid']) || $this->member['uid'] ==  0) {
            $data['deaddress']  = array();
            $cdata['id'] = 0;
            $cdata['default'] = 1;
            $cdata['contactname'] = ICookie::get('wxguest_username');
            $cdata['phone'] = ICookie::get('wxguest_phone');
            $cdata['address']  = ICookie::get('wxguest_address');
            if (empty($cdata['contactname'])) {
                $data['deaddress'] = array();
            } else {
                $data['deaddress'] = $cdata;
            }
        } else {
            $data['deaddress'] =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."address  where userid = ".$this->member['uid']." and `default`=1   ");
            $areaid = ICookie::get('myaddress');
            $template = $this->pscost($shopinfo, $data['deaddress']['lng'], $data['deaddress']['lat']);
            $data['deaddress']['newpscost'] = $template['pscost'];
            $data['deaddress']['canps'] = $template['canps'];
        }
        $data['lat'] = ICookie::get('lat');
        $data['lng'] = ICookie::get('lng');
        $data['addressname'] =  ICookie::get('addressname');
        $data['shopinfo'] = $shopinfo;


        $waimai_psrangearr = $this->platpsinfo['waimai_psrange'];
        ;
        $waimai_psrangearr = explode('#', $waimai_psrangearr);
        $data['waimai_psrange_arr'] = $waimai_psrangearr;
        $data['shopid'] = $id;
        Mysite::$app->setdata($data);
    }
    public function getjuan()
    {
        $this->checkwxweb();
        $id = intval(IReq::get('id'));
        $wxuserjuan = $this->mysql->select_one("select a.*,b.cartdesrc from ".Mysite::$app->config['tablepre']."wxuserjuan as a left join ".Mysite::$app->config['tablepre']."wxjuan as b on a.juanid = b.id  where a.id='".$id."' and a.uid='".$this->member['uid']."'  ");
        if (empty($wxuserjuan)) {
            $this->message('获取用户失败！');
        }
        $data['wxuserjuan']  = $wxuserjuan;
        Mysite::$app->setdata($data);
    }

    public function wxgetjuan()
    {
        $this->checkwxweb();
        $id = intval(IReq::get('id'));
        $wxuserjuan = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."wxuserjuan where id='".$id."'");

        if (empty($wxuserjuan)) {
            $this->message('获取优惠卷失败！');
        }

        $data['lqstatus']  = 1;
        $this->mysql->update(Mysite::$app->config['tablepre'].'wxuserjuan', $data, "id='".$id."'");


        $this->success('success');
    }


    public function member()
    {//用户中心
        // ini_set('display_errors',1);            //错误信息
        // ini_set('display_startup_errors',1);    //php启动错误信息
        // error_reporting(-1);
        // print_r($this->member);
        $wxuser = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."wxuser where uid='".$this->member['uid']."'");
        $data['wxuserbangd'] =  $wxuser['is_bang'];
        $data['userinfo'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$this->member['uid']."' ");
        $data['phone'] =  substr($data['userinfo']['phone'], 0, 3).'****'.substr($data['userinfo']['phone'], 7);
        $data['juanshu'] = $this->mysql->counts("select *  from ".Mysite::$app->config['tablepre']."juan where uid='".$this->member['uid']."'  and uid >0 and status = 1 and endtime > ".time()."  order by id asc ");
        $data['wxjuanshu'] = $this->mysql->counts("select *  from ".Mysite::$app->config['tablepre']."wxuserjuan where uid='".$this->member['uid']."'  and uid >0  and lqstatus = 1 order by id asc limit 0,50");
        Mysite::$app->setdata($data);
    }
    public function bangdmem()
    {
        $wxuser = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."wxuser where uid='".$this->member['uid']."'");
        $link = IUrl::creatUrl('wxsite/member');
        if (empty($wxuser)) {
            $this->message('未关注我们，不可绑定帐号', $link);
        }
    }

    public function paycart()
    {
    }

    public function payonline()
    {
        //在线支付
        $this->checkmemberlogin();
        $paytype='alimobile';
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

    public function address()
    {
        $this->checkwxweb();
        $shopid = IReq::get('shopid');
        $link = IUrl::creatUrl('wxsite/shoplist');
        if ($this->member['uid'] == 0) {
            $this->message('', $link);
        }
        $tarelist = $this->mysql->getarr("select *  from ".Mysite::$app->config['tablepre']."address where userid='".$this->member['uid']."'   order by id asc limit 0,50");
        $arelist = array();
        $areaid=array();
        foreach ($tarelist as $key=>$value) {
            $areaid[] = $value['areaid1'];
            $areaid[] = $value['areaid3'];
            $areaid[] = $value['areaid2'];
        }
        if (count($areaid) > 0) {
            $areaarr = $this->mysql->getarr("select id,name from ".Mysite::$app->config['tablepre']."area  where id in(".join(',', $areaid).")  order by id asc limit 0,1000");
            foreach ($areaarr as $key=>$value) {
                $arelist[$value['id']] = $value['name'];
            }
        }
        $data['arealist'] = $tarelist;
        $data['areaarr'] = $arelist;
        $data['shopid'] = $shopid;
        Mysite::$app->setdata($data);
    }
    public function editaddress()
    {
        $addressid = intval(IReq::get('id'));
        $data['addressid'] = $addressid;
        $link = IUrl::creatUrl('wxsite/index');
        $data['backtype'] = IFilter::act(IReq::get('backtype'));
        $data['shopid'] = IFilter::act(IReq::get('shopid'));
        $data['addressid'] = IFilter::act(IReq::get('id'));
        $data['lat'] = ICookie::get('lat');
        $data['lng'] = ICookie::get('lng');
        #  print_r($data);
        Mysite::$app->setdata($data);
        if ($this->member['uid'] == 0) {
            $this->message('', $link);
        }
    }
    public function bkaddress()
    {
        $link = IUrl::creatUrl('wxsite/index');
        if ($this->member['uid'] == 0) {
            $this->message('', $link);
        }
        $data['shopid'] = IFilter::act(IReq::get('shopid'));
        $data['backtype'] =  IFilter::act(IReq::get('backtype'));
        $tarelist = $this->mysql->getarr("select *  from ".Mysite::$app->config['tablepre']."address where userid='".$this->member['uid']."'   order by id asc limit 0,50");
        $arelist = array();
        $data['arealist'] = $tarelist;
        Mysite::$app->setdata($data);
    }
    public function myajaxadlist()
    {
        if ($this->checkbackinfo()) {
            if ($this->member['uid'] == 0) {
                $this->message('请先登录！');
            }
        }
        $data['shopid'] = IFilter::act(IReq::get('shopid'));
        $data['backtype'] =  IFilter::act(IReq::get('backtype'));


        if (empty($this->member['uid']) || $this->member['uid'] ==  0) {
            $tarelist = array();
            $cdata['id'] = 0;
            $cdata['default'] = 1;
            $cdata['contactname'] = ICookie::get('wxguest_username');
            $cdata['phone'] = ICookie::get('wxguest_phone');
            $cdata['address']  = ICookie::get('wxguest_address');
            if (empty($cdata['contactname'])) {
                $tarelist = array();
            } else {
                $tarelist[] = $cdata;
            }
        } else {
            $tarelist = $this->mysql->getarr("select *  from ".Mysite::$app->config['tablepre']."address where userid='".$this->member['uid']."'    order by id asc limit 0,50");
        }

        $this->success($tarelist);
    }
    public function savemyaddress()
    {
        //  if( $this->checkbackinfo() ){
        if ($this->member['uid'] == 0) {
            $username = IFilter::act(IReq::get('contactname'));
            $phone = IFilter::act(IReq::get('phone'));
            $address =  IFilter::act(IReq::get('add_new'));

            ICookie::set('wxguest_username', $username, 86400);
            ICookie::set('wxguest_phone', $phone, 86400);
            ICookie::set('wxguest_address', $address, 86400);
            #   $this->message(ICookie::get('wxguest_username'));
            $this->success('success');
        }
        //   }
        $addressid = intval(IReq::get('addressid'));
        if (empty($addressid)) {
            $checknum = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."address where userid='".$this->member['uid']."' ");
            if (Mysite::$app->config['addresslimit'] < $checknum) {
                $this->message('member_addresslimit');
            }

            $arr['userid'] = $this->member['uid'];
            $arr['username'] = $this->member['username'];

            $arr['address'] =  IFilter::act(IReq::get('add_new'));
            $arr['phone'] = IFilter::act(IReq::get('phone'));
            $arr['otherphone'] = '';
            $arr['contactname'] = IFilter::act(IReq::get('contactname'));
            $arr['sex'] =  IFilter::act(IReq::get('sex'));
            $arr['default'] = 1;

            if (!(IValidate::len(IFilter::act(IReq::get('add_new')), 3, 50))) {
                $this->message('member_addresslength');
            }
            if (!(IValidate::phone($arr['phone']))) {
                $this->message('errphone');
            }
            if (!empty($arr['otherphone'])&&!(IValidate::phone($arr['otherphone']))) {
                $this->message('errphone');
            }
            if (!(IValidate::len($arr['contactname'], 2, 6))) {
                $this->message('contactlength');
            }
            // print_r($arr);exit;
            $this->mysql->update(Mysite::$app->config['tablepre'].'address', array('default'=>0), 'userid = '.$this->member['uid'].' ');
            $this->mysql->insert(Mysite::$app->config['tablepre'].'address', $arr);
            $this->success('success');
        } else {
            $arr['address'] =  IFilter::act(IReq::get('add_new'));
            $arr['phone'] = IFilter::act(IReq::get('phone'));
            $arr['otherphone'] = '';
            $arr['contactname'] = IFilter::act(IReq::get('contactname'));
            $arr['sex'] =  IFilter::act(IReq::get('sex'));
            $arr['default'] = 1;

            if (!(IValidate::len(IFilter::act(IReq::get('add_new')), 3, 50))) {
                $this->message('member_addresslength');
            }
            if (!(IValidate::phone($arr['phone']))) {
                $this->message('errphone');
            }
            if (!empty($arr['otherphone'])&&!(IValidate::phone($arr['otherphone']))) {
                $this->message('errphone');
            }
            if (!(IValidate::len($arr['contactname'], 2, 6))) {
                $this->message('contactlength');
            }
            // print_r($arr);exit;
            $this->mysql->update(Mysite::$app->config['tablepre'].'address', array('default'=>0), 'userid = '.$this->member['uid'].' ');
            $this->mysql->update(Mysite::$app->config['tablepre'].'address', $arr, 'userid = '.$this->member['uid'].' and id='.$addressid.'');
            $this->success('success');
        }
        $this->success('success');
    }
    public function setmydefadid()
    {
        if ($this->checkbackinfo()) {
            if ($this->member['uid'] == 0) {
                $this->message('未登陆获取地区信息失败');
            }
        }
        $addressid = intval(IReq::get('addressid'));
        if (empty($addressid)) {
            $this->message('默认值错误');
        }
        $checkdata =   $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."address where id='".$addressid."' and userid = '".$this->member['uid']."' ");
        if (empty($checkdata)) {
            $this->message('该地址不属于你该账号');
        }
        $this->mysql->update(Mysite::$app->config['tablepre'].'address', array('default'=>0), 'userid = '.$this->member['uid'].' ');
        $this->mysql->update(Mysite::$app->config['tablepre'].'address', array('default'=>1), 'userid = '.$this->member['uid'].' and id='.$addressid.'');
        $this->success('success');
    }



    public function order()
    {
        $weixindir = hopedir.'/plug/pay/weixin/';
        require_once $weixindir."lib/WxPay.Api.php";
        require_once $weixindir."WxPay.JsApiPay.php";        //错误信息
        $tools = new JsApiPay();
    //  $openId = $tools->GetOpenid();
        $order = new orderclass();
        $this->checkwxweb();
        $link = IUrl::creatUrl('wxsite/index');
        if ($this->member['uid'] == 0) {
            $this->message('', $link);
        }

    }
    public function userorder()
    {
        $link = IUrl::creatUrl('wxsite/index');
        if ($this->member['uid'] == 0) {
            $this->message('', $link);
        }
        $orderclass = new orderclass();
        $pageinfo = new page();
        $pageinfo->setpage(intval(IReq::get('page')), 5);
        //
        $where = "";
        $order_status = IReq::get('order_status');
        switch ($order_status) {
            case '1':
                $where .= " AND status = 0 AND is_reback = 0 ";
                break;
            case '3':
                //待发货，已发货，待收货
                $where .= " and status in (1,2) AND is_reback = 0";
                break;
            case '4':
                //已完成
                $where .= " AND paystatus = 1 AND status = 3 ";
                break;
            case '5':
                //退款售后
                $where .= " AND status > 0 AND status <= 4 AND paystatus =1 AND is_reback > 0 ";
                break;
        }


        $datalist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."order where buyeruid='".$this->member['uid']."' and shoptype != 100 ".$where." order by id desc limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."");
        $temparray = array('0'=>'外卖','1'=>'超市','2'=>'其他','100'=>'跑腿订单');
        $backdata = array();
        foreach ($datalist as $key=>$value) {
                $value['goods_count'] = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."orderdet    where order_id = ".$value['id']." ");
        //自动关闭订单
            if ($value['paytype'] == 1 && $value['paystatus'] == 0 && $value['status'] < 3) {
                $checktime = time() - $value['addtime'];
                if ($checktime > 900) {
                    //说明该订单可以关闭
                    if ($value['yhjids']>0) {
                        $jdata['status'] =1;
                        $this->mysql->update(Mysite::$app->config['tablepre'].'juan', $jdata, "id='".$value['yhjids']."'");
                    }
                    $cdata['status'] = 4;
                    $this->mysql->update(Mysite::$app->config['tablepre'].'order', $cdata, "id='".$value['id']."'");
                    $this->mysql->delete(Mysite::$app->config['tablepre'].'orderps', "orderid = {$value['id']} and status != 3");
                    /*更新订单 状态说明*/
                    $statusdata['orderid']     =  $value['id'];
                    $statusdata['addtime']     =  $value['addtime']+900;
                    $statusdata['statustitle'] =  "自动关闭订单";
                    $statusdata['ststusdesc']  =  "在线支付订单，未支付自动关闭";
                    $this->mysql->insert(Mysite::$app->config['tablepre'].'orderstatus', $statusdata);
                }
            }

            $listdet = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$value['id']."'");
            $value['det'] = '';
            foreach ($listdet as $k=>$v) {
                $value['det'] .= $v['goodsname'].',';
            }
            $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where id='".$value['shopid']."'");
            // print_r($shopinfo);
            $value['shoplogo'] = $shopinfo['shoplogo'];
            //  $value['shoptype'] = $temparray[$value['shoptype']];

            $orderwuliustatus = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."orderstatus where   orderid = ".$value['id']." order by id desc limit 0,1 ");

            # print_r($orderwuliustatus);

            $value['orderwuliustatus'] = $orderwuliustatus['statustitle'];

            $value['addtime'] = date('Y-m-d H:i', $value['addtime']);
            $value['order_status'] = $orderclass->handleOrderStatus($value);
            $backdata[] =$value;
        }

        $data['orderlist'] = $backdata;
        Mysite::$app->setdata($data);
        /*
        $datas = json_encode($backdata);
          echo 'showmoreorder('.$datas.')';
          exit;
            $this->success($data);

         print_r($backdata);
            exit;
            $this->success($backdata); */
    }
    public function ordershow()
    {
        $link = IUrl::creatUrl('wxsite/index');
        if ($this->member['uid'] == 0) {
            $this->message('未登陆', $link);
        }
        $orderid = intval(IReq::get('orderid'));

        $orderclass = new orderclass();

        $shareinfo = $this->mysql->select_one("select title,img,`describe`  from ".Mysite::$app->config['tablepre']."juanshowinfo where type=2 order by orderid asc  ");
        if (empty($shareinfo)) {
            $shareinfo['title'] = Mysite::$app->config['sitename'];
            $shareinfo['img'] = Mysite::$app->config['sitelogo'];
            $shareinfo['describe'] = Mysite::$app->config['sitename'];
        }
        $data['shareinfo'] = $shareinfo;

        $where = "  where type=2 and addtime < ".time()."  and is_open = 1 and juannum > 0 ";
        $checkinfosendjuan = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."juanrule ".$where." order by orderid asc ");
        $data['checkinfosendjuan'] = $checkinfosendjuan;

        $orderwuliustatus = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."orderstatus where   orderid = ".$orderid." order by addtime asc limit 0,10 ");
        $data['orderwuliustatus'] = $orderwuliustatus;

        $juansetinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 4 or name = '下单送代金券' ");
        $data['juaninfo'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."alljuan where type = 4 or name= '下单送代金券' order by id asc ");
        $data['sendjuanstatus'] = $juansetinfo['status'];

        if (!empty($orderid)) {
            $order = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where buyeruid='".$this->member['uid']."' and id = ".$orderid."");

            //自动关闭订单
            if ($order['paytype'] == 1 && $order['paystatus'] == 0 && $order['status'] < 3) {
                $checktime = time() - $order['addtime'];
                if ($checktime > 900) {
                    //说明该订单可以关闭
                    if ($order['yhjids']>0) {
                        $jdata['status'] =1;
                        $this->mysql->update(Mysite::$app->config['tablepre'].'juan', $jdata, "id='".$order['yhjids']."'");
                    }
                    $cdata['status'] = 4;
                    $this->mysql->update(Mysite::$app->config['tablepre'].'order', $cdata, "id='".$orderid."'");
                    $this->mysql->delete(Mysite::$app->config['tablepre'].'orderps', "orderid = '$orderid' and status != 3");
                    /*更新订单 状态说明*/
                    $statusdata['orderid']     =  $orderid;
                    $statusdata['addtime']     =  $order['addtime']+900;
                    $statusdata['statustitle'] =  "自动关闭订单";
                    $statusdata['ststusdesc']  =  "在线支付订单，未支付自动关闭";
                    $this->mysql->insert(Mysite::$app->config['tablepre'].'orderstatus', $statusdata);
                    $order['status'] = 4;
                }
            }

            $data['paytype'] = $order['paytype'];
            if (empty($order)) {
                $data['order'] = '';
                Mysite::$app->setdata($data);
            } else {
                $scoretocost =Mysite::$app->config['scoretocost'];
                $order['scoredown'] =  $order['scoredown']/$scoretocost;//抵扣积分
                $order['ps'] = $order['shopps'];
                // 超市商品总价    超市配送配送 shopcost 店铺商品总价 shopps 店铺配送费    pstype 配送方式 0：平台1：个人    bagcost
                $orderdet = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$order['id']."'");
                $order['cp'] = count($orderdet);
                $buyerstatus= array(
                  '0'=>'等待处理',
                  '1'=>'订餐成功处理中',
                  '2'=>'订单已发货',
                  '3'=>'订单完成',
                  '4'=>'订单已取消',
                  '5'=>'订单已取消'
                  );
                $paytypelist = array(0=>'货到支付',1=>'在线支付');

                $paytypearr = $paytypelist;
                $order['is_acceptorder'] = $order['is_acceptorder'];
                $order['surestatus'] = $order['status'];
                $order['basetype'] = $order['paytype'];
                $order['basepaystatus'] =$order['paystatus'];
                #  $order['status'] = $buyerstatus[$order['status']];
                $order['paytype'] =  $order['paytype'];
                #   $order['paystatus'] = $order['paystatus']==1?'已支付':'未支付';
                $order['paystatus'] = $order['paystatus'] ;
                $order['setime'] = 15 * 60 - (time() - $order['addtime']);
                $order['addtime'] = date('Y-m-d H:i:s', $order['addtime']);
                $order['posttime'] = date('Y-m-d H:i:s', $order['posttime']);

                $order['order_status'] = $orderclass->handleOrderStatus($order);

                #print_r($order);
                $data['order'] = $order;
                $data['orderdet'] = $orderdet;

                $data['psbpsyinfo'] = array();

                if ($order['psuid'] > 0 && $order['shoptype'] != 100) {
                    if ($order['status'] == 2) {
                        if ($order['pstype'] == 2) {
                            $psbinterface = new psbinterface();
                            $data['psbpsyinfo'] = $psbinterface->getpsbclerkinfo($order['psuid']);

                            if (!empty($data['psbpsyinfo']) && !empty($data['psbpsyinfo']['posilnglat'])) {
                                $posilnglatarr = explode(',', $data['psbpsyinfo']['posilnglat']);
                                $posilng = $posilnglatarr[0];
                                $posilat = $posilnglatarr[1];
                                if (!empty($posilng) && !empty($posilat)) {
                                    $data['psbpsyinfo']['posilnglatarr'] = $posilnglatarr;
                                } else {
                                    $data['psbpsyinfo'] = array();
                                }
                            }
                        } elseif ($order['pstype'] == 0) {
                            $data['psbpsyinfo'] = $this->mysql->select_one("select uid,lng,lat from ".Mysite::$app->config['tablepre']."locationpsy where uid='".$order['psuid']."' ");
                            if (!empty($data['psbpsyinfo'])  &&  !empty($data['psbpsyinfo']['lng'])  &&  !empty($data['psbpsyinfo']['lat'])) {
                                $data['psbpsyinfo']['posilnglat'] = $data['psbpsyinfo']['lng'].','.$data['psbpsyinfo']['lat'];
                            } else {
                                $data['psbpsyinfo'] = array();
                            }
                        } else {
                            $data['psbpsyinfo'] = array();
                        }
                    } elseif ($order['status'] == 3 &&  ($order['pstype'] == 0 ||  $order['pstype'] == 2)) {
                        $psyoverlng = $order['psyoverlng'];
                        $psyoverlat = $order['psyoverlat'];
                        $data['psbpsyinfo']['clerkid'] = $order['psuid'];
                        $data['psbpsyinfo']['posilnglat'] = $psyoverlng.','.$psyoverlat;
                        $data['psbpsyinfo']['posilnglatarr'] = explode(',', $data['psbpsyinfo']['posilnglat']);
                    }
                }



                Mysite::$app->setdata($data);
            }
        } else {
            $data['order'] = '';
            Mysite::$app->setdata($data);
        }
    }




    public function cart()
    {
        $shopid = intval(IReq::get('shopid'));
        $shopshowtype = ICookie::get('shopshowtype');
        $backdata = array();
        $smardb = new newsmcart();
        $carinfo = array();
        if ($smardb->setdb($this->mysql)->SetShopId($shopid)->OneShop()) {
            $carinfo = $smardb->getdata();
            $backdata['list'] = $carinfo['goodslist'];
            $backdata['sumcount'] =$carinfo['count'];
            $backdata['sum'] =$carinfo['sum'];

            $shopcheckinfo =   $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id where a.shopid = '".$shopid."'    ");

            if ($shopshowtype == 'dingtai') {
                $backdata['bagcost'] = 0;
            } else {
                $backdata['bagcost'] =$carinfo['bagcost'];
            }

            $cxclass = new sellrule();
            if (!strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger')) {    //判断是微信浏览器不
                $platform=3;//触屏
            } else {
                $platform=2;//微信
            }
            //$paytype = intval(IReq::get('paytype'));
            $paytype = 1;
            $cxclass->setdata($shopid, $carinfo['sum'] - $carinfo['cxcosttotal'], $carinfo['shopinfo']['shoptype'], $this->member['uid'], $platform, $paytype);
            $cxinfo = $cxclass->getdata();
            #print_r($cxinfo);
            $backdata['surecost'] = $cxinfo['surecost'];
            $backdata['downcost'] = $cxinfo['downcost'];
            $backdata['cxcosttotal'] = $carinfo['cxcosttotal'];
            $backdata['cxdet'] = $cxinfo['cxdet'];
            // if (!empty($backdata['list'])) {
            //     foreach ($backdata['list']  as $v) {
            //         if (!empty($v)) {
            //             if ($v['cxinfo']['is_cx'] == 1 && $v['cxinfo']['cxcost']>0) {
            //                 $backdata['downcost'] = 0;
            //                 $cxinfo['nops'] = false;
            //                 break;
            //             }
            //         }
            //     }
            // }

            $backdata['gzdata'] = isset($cxinfo['gzdata'])?$cxinfo['gzdata']:array();
            $backdata['zpinfo'] = $cxinfo['zid'];
            $areaid = ICookie::get('myaddress');
            $tempinfo =   $this->pscost($shopcheckinfo);
            $backdata['pstype'] = $tempinfo['pstype'];
            //$backdata['pscost'] = $tempinfo['pscost'] * $backdata['sumcount'];
            $backdata['pscost'] = $tempinfo['pscost'];
            $backdata['canps'] = $tempinfo['canps'];
            $backdata['nops'] = $cxinfo['nops'];

            $this->success($backdata);
        } else {
            $this->message(array());
        }
    }


    /* 提交订单 start */
    public function makeorder()
    {
        $this->checkwxweb();
        if ($this->checkbackinfo()) {
            if ($this->member['uid'] == 0) {
                $this->message('未登陆');
            }
        }
        if (empty($this->member['uid']) || $this->member['uid'] ==  0) {
            $addressinfo  = null;
            $cdata['id'] = 0;
            $cdata['default'] = 1;
            $cdata['contactname'] = ICookie::get('wxguest_username');
            $cdata['phone'] = ICookie::get('wxguest_phone');
            $cdata['address']  = ICookie::get('wxguest_address');
            if (empty($cdata['contactname'])) {
            } else {
                $addressinfo = $cdata;
            }
        } else {
            $addressinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."address  where userid = ".$this->member['uid']." and `default`=1   ");
        }

        if (empty($addressinfo)) {
            $this->message('未设置默认地址');
        }
        $info['buyerlng'] = IFilter::act(IReq::get('buyerlng'));
        $info['buyerlat'] = IFilter::act(IReq::get('buyerlat'));

        $nowID = ICookie::get('CITY_ID');
        if (!empty($nowID)) {
            $nowID = explode('_', $nowID);
            $nowID = end($nowID);

            $a = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."stationadmininfo where cityid =".$nowID."");

            if ($a['stationis_open'] == 1) {
                $this->message('分校已关闭');
            }
        }


        $info['username'] = $addressinfo['contactname'];
        $info['mobile'] = $addressinfo['phone'];
        $info['addressdet'] = $addressinfo['detailadr'];

        $info['shopid'] = intval(IReq::get('shopid'));//店铺ID
        $info['remark'] = IFilter::act(IReq::get('remark'));//备注
        $info['paytype'] =  1;//支付方式
        $info['dikou'] =  intval(IReq::get('dikou'));//抵扣金额

    //   $info['senddate'] = date('Y-m-d',time());// IFilter::act(IReq::get('senddate'));
        $info['minit'] = IFilter::act(IReq::get('minit'));
        $info['juanid']  =  intval(IReq::get('juanid'));//优惠劵ID
        if ($this->checkbackinfo()) {
            $info['ordertype'] = 3;//订单类型
        } else {
            $info['ordertype'] = 5;
        }
        $peopleNum = IFilter::act(IReq::get('peopleNum'));
        $info['othercontent'] ='';//empty($peopleNum)?'':serialize(array('人数'=>$peopleNum));

        if (empty($info['shopid'])) {
            $this->message('店铺ID错误');
        }

        $smardb = new newsmcart();
        $carinfo = array();
        if ($smardb->setdb($this->mysql)->SetShopId($info['shopid'])->OneShop()) {
            $carinfo = $smardb->getdata();
        } else {
            $this->message($smardb->getError());
        }
        #print_r($carinfo);exit;
        if (count($carinfo['goodslist'])==0) {
            $this->message('对应店铺购物车商品为空');
        }

        $shopinfo=   $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id where a.shopid = '".$info['shopid']."'    ");


        if (empty($shopinfo)) {
            $this->message('店铺获取失败');
        }
        $areaid = ICookie::get('myaddress');
        $temp = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."address  where userid = ".$this->member['uid']." and `default`=1   ");
        $checkps =   $this->pscost($shopinfo, $temp['lng'], $temp['lat']);

        $info['cattype'] = 0;//
        if (empty($info['username'])) {
            $this->message('联系人不能为空');
        }
        if (!IValidate::suremobi($info['mobile'])) {
            $this->message('请输入正确的手机号');
        }

        if (empty($info['addressdet'])) {
            $this->message('详细地址为空');
        }
        $info['userid'] = !isset($this->member['score'])?'0':$this->member['uid'];
        if (Mysite::$app->config['allowedguestbuy'] != 1) {
            if ($info['userid']==0) {
                $this->message('禁止游客下单');
            }
        }
        $info['ipaddress'] = "";
        $ip_l=new iplocation();
        $ipaddress=$ip_l->getaddress($ip_l->getIP());
        if (isset($ipaddress["area1"])) {
            if (function_exists('mb_convert_encoding')) {
                $info['ipaddress']  = $ipaddress['ip'];//('GB2312','ansi',);
            } elseif (function_exists('iconv')) {
                $info['ipaddress']  = $ipaddress['ip'].iconv('GB2312', $ipaddress["area1"], 'UTF-8');//('GB2312','ansi',);
            } else {
                $info['ipaddress']='0';
            }
        }
        //area1 二级地址名称  area2 三级地址名称    area3
        $info['areaids'] = '';

        #  logwrite($info['postdate']);
        if ($shopinfo['is_open'] != 1) {
            $this->message('店铺暂停营业');
        }
        $tempdata = $this->getOpenPosttime($shopinfo['is_orderbefore'], $shopinfo['starttime'], $shopinfo['postdate'], $info['minit'], $shopinfo['befortime']);
        /*
        if ($tempdata['is_opentime'] ==  2) {
            $this->message('选择的配送时间段，店铺未设置');
        }
        if ($tempdata['is_opentime'] == 3) {
            $this->message('选择的配送时间段已超时');
        }
        */
        $info['sendtime'] = $tempdata['is_posttime'];
        $info['postdate'] = $tempdata['is_postdate'];
        $info['addpscost'] = $tempdata['cost'];
        $checksend = Mysite::$app->config['ordercheckphone'];
        if ($checksend == 1) {
            if (empty($this->member['uid'])) {
                $checkphone = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."mobile where phone ='".$info['mobile']."'   order by addtime desc limit 0,50");
                if (empty($checkphone)) {
                    $this->message('member_emailyan');
                }
                if (empty($checkphone['is_send'])) {
                    $mycode = IFilter::act(IReq::get('phonecode'));
                    if ($mycode == $checkphone['code']) {
                        $this->mysql->update(Mysite::$app->config['tablepre'].'mobile', array('is_send'=>1), "phone='".$info['mobile']."'");
                    } else {
                        $this->message('member_emailyan');
                    }
                }
            }
        }
        $paytype = $info['paytype'] == 1?1:0;

        $info['shopinfo'] = $shopinfo;
        $info['allcost'] = $carinfo['sum'] ;
        $info['bagcost'] = $carinfo['bagcost'];
        $info['allcount'] = $carinfo['count'];
      //  $info['shopps'] = $checkps['pscost'] * $carinfo['count'];
	  $info['shopps'] = $checkps['pscost'];
        $info['goodslist']   = $carinfo['goodslist'];
        $info['cxcosttotal'] = $carinfo['cxcosttotal'];

        $info['pstype'] = $checkps['pstype'];
        $info['cattype'] = 0;//表示不是预订

        #print_r($info['addpscost']);
        #print_r($info['shopps']);

        //检测库存
        //var_dump($info['goodslist']);exit;
        foreach ($info['goodslist'] as $key=>$value) {
            if($value['is_live'] !=1)
            {
                $this->message($value['name'].'已下架');
            }
            if ($value['stock'] < $value['count']) {
                $this->message($value['name'].'商品库存不足，剩余'.$value['stock']);
            }

        }

        if (!strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger')) {    //判断是微信浏览器不
        $info['platform']=3;//触屏
        } else {
            $info['platform']=2;//微信
        }
        $info['is_goshop']=0;
        if ($shopinfo['limitcost'] > $info['allcost']) {
            $this->message('商品总价低于最小起送价'.$shopinfo['limitcost']);
        }
        $orderclass = new orderclass();
        $orderclass->makenormal($info);
        $orderid = $orderclass->getorder();
        if ($info['userid'] ==  0) {
            ICookie::set('orderid', $orderid, 86400);
        }
        $smardb->DelShop($info['shopid']);
        echo $this->createOrder($orderid);exit;
    }
    public function pay()
    {
        $orderid = intval(IReq::get('orderid'));
        if (empty($orderid)) {
            $err = '订单获取失败';
        }
        $userid = empty($this->member['uid'])?0:$this->member['uid'];
		if($userid == 0){
            $err = '订单操作无权限';
        }
        $orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where id=".$orderid."  ");
        if(empty($orderinfo)){
            $err = '订单数据获取失败';
        }
        if($userid > 0){
			if($orderinfo['buyeruid'] !=  $userid){
				$err = '订单不属于您';
			}
		}
        if ($orderinfo['paytype'] == 1 && $orderinfo['paystatus'] == 0 && $orderinfo['status'] < 3) {
            $checktime = time() - $orderinfo['addtime'];
            if ($checktime > 900) {
                //说明该订单可以关闭
                if ($orderinfo['yhjids']>0) {
                    $jdata['status'] =1;
                    $this->mysql->update(Mysite::$app->config['tablepre'].'juan', $jdata, "id='".$orderinfo['yhjids']."'");
                }
                $cdata['status'] = 4;
                $this->mysql->update(Mysite::$app->config['tablepre'].'order', $cdata, "id='".$orderid."'");
                $this->mysql->delete(Mysite::$app->config['tablepre'].'orderps', "orderid = '$orderid' and status != 3");
                /*更新订单 状态说明*/
                $statusdata['orderid']     =  $orderid;
                $statusdata['addtime']     =  $orderinfo['addtime']+900;
                $statusdata['statustitle'] =  "自动关闭订单";
                $statusdata['ststusdesc']  =  "在线支付订单，未支付自动关闭";
                $this->mysql->insert(Mysite::$app->config['tablepre'].'orderstatus', $statusdata);
                $orderinfo['status'] = 4;
            }
        }
        if($orderinfo['status']  == 4){
            $err = '订单已超时或其他状态不可操作';
        }
        if($err)
        {
            $data['error'] = true;
            $data['msg'] = $err;
            echo json_encode($data);exit;
        }
        echo $this->createOrder($orderid);exit;
    }
    public function createOrder($orderid)
    {
        $weixindir = hopedir.'/plug/pay/weixin/';
        require_once $weixindir."lib/WxPay.Api.php";
        require_once $weixindir."WxPay.JsApiPay.php";        //错误信息
        $wxopenid = ICookie::get('wxopenid');
        $tools = new JsApiPay();
        // $openId = $tools->GetOpenid();
        $order = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where buyeruid='".$this->member['uid']."' and id = ".$orderid."");
        $data['error'] = false;
        $data['msg'] = '';
        $data['orderid'] = $orderid;
        //②、统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody("支付订单".$order['dno']);
        $input->SetAttach($order['dno']);
        $input->SetOut_trade_no($order['dno']);
        $input->SetTotal_fee($order['allcost']*100);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetTimeStamp(time());
        $input->SetGoods_tag('订餐');
        $input->SetNotify_url(Mysite::$app->config['siteurl']."/plug/pay/weixin/notify.php");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($wxopenid);
        try{
            $ordermm = WxPayApi::unifiedOrder($input);
            if($ordermm['return_code'] == 'SUCCESS'){
                $jsApiParameters = $tools->GetJsApiParameters($ordermm);
                $data['wxdata'] = $jsApiParameters;
            }else{
                $data['error'] = true;
                $data['msg']  = $ordermm['return_msg'];
            }
        }catch (Exception $e) {
            $data['error'] = true;
            $data['msg'] = $e->getmessage();
        }
        return json_encode($data);
        exit;
    }

    public function makeorder2()
    {
        $this->checkwxweb();
        if ($this->checkbackinfo()) {
            if ($this->member['uid'] == 0) {
                $this->message('未登陆');
            }
        }


        if (empty($this->member['uid']) || $this->member['uid'] ==  0) {
            $addressinfo  = null;
            $cdata['id'] = 0;
            $cdata['default'] = 1;
            $cdata['contactname'] = ICookie::get('wxguest_username');
            $cdata['phone'] = ICookie::get('wxguest_phone');
            $cdata['address']  = ICookie::get('wxguest_address');
            if (empty($cdata['contactname'])) {
            } else {
                $addressinfo = $cdata;
            }
        } else {
            $addressinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."address  where userid = ".$this->member['uid']." and `default`=1   ");
        }

        if (empty($addressinfo)) {
            $this->message('未设置默认地址');
        }
        $info['username'] = $addressinfo['contactname'];
        $info['mobile'] = $addressinfo['phone'];
        $info['addressdet'] = $addressinfo['address'];
        $subtype = intval(IReq::get('subtype'));
        $info['shopid'] = intval(IReq::get('shopid'));//店铺ID
         $info['remark'] = IFilter::act(IReq::get('content'));//备注
         $info['paytype'] = IFilter::act(IReq::get('paytype'));//'outpay';//支付方式
        if ($info['paytype'] == '') {
            $this->message('未开启任何支付方式，请联系管理员！');
        }
        // $info['senddate'] =  IFilter::act(IReq::get('senddate'));
        $info['minit'] = IFilter::act(IReq::get('minit'));
        $info['juanid']  = intval(IReq::get('juanid'));//优惠劵ID
        if ($this->checkbackinfo()) {
            $info['ordertype'] = 3;//订单类型
        } else {
            $info['ordertype'] = 5;
        }
        $peopleNum = IFilter::act(IReq::get('personcount'));
        if ($peopleNum < 1) {
            $this->message('选择消费人数');
        }
        $info['othercontent'] = empty($peopleNum)?'':serialize(array('人数'=>$peopleNum));
        $info['userid'] = !isset($this->member['score'])?'0':$this->member['uid'];
        if (Mysite::$app->config['allowedguestbuy'] != 1) {
            if ($info['userid']==0) {
                $this->message('member_nologin');
            }
        }
        $shopinfo=   $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id where a.shopid = '".$info['shopid']."'    ");
        if (empty($shopinfo)) {
            $this->message('店铺不存在');
        }
        /*监测验证码*/

        if (empty($info['username'])) {
            $this->message('emptycontact');
        }
        if (!IValidate::suremobi($info['mobile'])) {
            $this->message('errphone');
        }
        $info['ipaddress'] = "";
        $ip_l=new iplocation();
        $ipaddress=$ip_l->getaddress($ip_l->getIP());
        if (isset($ipaddress["area1"])) {
            if (function_exists(mb_convert_encoding)) {
                $info['ipaddress']  = $ipaddress['ip'].mb_convert_encoding($ipaddress["area1"], 'UTF-8', 'GB2312');//('GB2312','ansi',);
            } elseif (function_exists(iconv)) {
                $info['ipaddress']  = $ipaddress['ip'].iconv('GB2312', $ipaddress["area1"], 'UTF-8');//('GB2312','ansi',);
            } else {
                $info['ipaddress']='0';
            }
        }
        $info['cattype'] = 0;//


        if ($shopinfo['is_open'] != 1) {
            $this->message('店铺暂停营业');
        }
        $tempdata = $this->getOpenPosttime($shopinfo['is_orderbefore'], $shopinfo['starttime'], $shopinfo['postdate'], $info['minit'], $shopinfo['befortime']);
        if ($tempdata['is_opentime'] ==  2) {
            $this->message('选择的配送时间段，店铺未设置');
        }
        if ($tempdata['is_opentime'] == 3) {
            $this->message('选择的配送时间段已超时');
        }
        $info['sendtime'] = $tempdata['is_posttime'];
        $info['postdate'] = $tempdata['is_postdate'];
        $info['addpscost'] = $tempdata['cost'];

        if ($info['paytype'] == 'undefined') {
            $this->message("未开启任何支付方式，请联系管理员！");
        }


        $info['paytype'] = $info['paytype'] == 1?1:0;

        $info['areaids'] = '';
        $info['shopinfo'] = $shopinfo;
        if ($subtype == 1) {
            $info['allcost'] = 0 ;
            $info['bagcost'] = 0;
            $info['allcount'] = 0;
            $info['goodslist'] = array();
        } else {
            if (empty($info['shopid'])) {
                $this->message('shop_noexit');
            }


            $smardb = new newsmcart();
            $carinfo = array();
            if ($smardb->setdb($this->mysql)->SetShopId($info['shopid'])->OneShop()) {
                $carinfo = $smardb->getdata();
            } else {
                $this->message($smardb->getError());
            }

            if (count($carinfo['goodslist'])==0) {
                $this->message('对应店铺购物车商品为空');
            }

            $info['allcost'] = $carinfo['sum'];
            $info['goodslist']   = $carinfo['goodslist'];

            $info['bagcost'] = 0;
            $info['allcount'] = 0;
        }
        $info['shopps'] = 0;
        $info['pstype'] = 0;
        $info['cattype'] = 1;//表示不是预订
        $info['is_goshop']=1;
        $info['subtype'] = $subtype;
        $orderclass = new orderclass();
        $orderclass->orderyuding($info);
        $orderid = $orderclass->getorder();

        if ($info['userid'] ==  0) {
            ICookie::set('orderid', $orderid, 86400);
        }
        if ($subtype == 2) {
            $smardb->delshop($info['shopid']);
        }

        $this->success($orderid);
        exit;
    }
    public static function checkshopopentime($is_orderbefore, $posttime, $starttime)
    {
        $maxnowdaytime = strtotime(date('Y-m-d', time()));
        $daynottime = 24*60*60 -1;
        $findpostime = false;
        for ($i=0;$i <= $is_orderbefore;$i++) {
            if ($findpostime == false) {
                $miniday = $maxnowdaytime+$daynottime*$i;
                $maxday = $miniday+$daynottime;
                $tempinfo = explode('|', $starttime);
                foreach ($tempinfo as $key=>$value) {
                    if (!empty($value)) {
                        $temp2 = explode('-', $value);
                        if (count($temp2) > 1) {
                            $minbijiaotime = date('Y-m-d', $miniday);
                            $minbijiaotime = strtotime($minbijiaotime.' '.$temp2[0].':00');

                            $maxbijiaotime = date('Y-m-d', $maxday);
                            $maxbijiaotime = strtotime($maxbijiaotime.' '.$temp2[1].':00');

                            if ($posttime > $minbijiaotime && $posttime < $maxbijiaotime) {
                                $findpostime = true;
                                break;
                            }
                        }
                    }
                }
            }
        }
        return $findpostime;
    }


    public function ajaxlocation()
    {
        $lat = IFilter::act(IReq::get('lat'));
        $lng = IFilter::act(IReq::get('lng'));

        $content =   file_get_contents('http://api.map.baidu.com/geoconv/v1/?coords='.$lng.','.$lat.'&&from=1&to=5&ak='.Mysite::$app->config['baidumapkey']);
        $backinfo = json_decode($content, true);
        //Array ( [status] => 0 [result] => Array ( [0] => Array ( [x] => 113.6778066454 [y] => 34.799780450303 ) ) )
        if ($backinfo['status'] == 0) {
            $data['lat'] = $backinfo['result'][0]['y'];
            $data['lng'] = $backinfo['result'][0]['x'];
            ICookie::set('lat', $backinfo['result'][0]['y'], 2592000);
            ICookie::set('lng', $backinfo['result'][0]['x'], 2592000);
            $this->success($data);
        } else {
            $this->message('失败');
        }
    }
    public function locationshop()
    {
        ICookie::clear('myaddress');
        $link = IUrl::creatUrl('wxsite/shoplist');
        $this->message('', $link);
    }


    public function checkwxuser()
    {
        /*
      $logintype = ICookie::get('logintype');
      if($logintype == 'wx'){
      }else{
          $this->message('Not allowed');
      }*/
        if (Mysite::$app->config['wxLoginType'] == 1 && $this->member['uid'] <= 0) {
            $link = IUrl::creatUrl('wxsite/login');
            $this->message('', $link);
        }
    }

    public function drawbacklog()
    {
        $link = IUrl::creatUrl('wxsite/index');
        if ($this->member['uid'] == 0) {
            $this->message('未登陆', $link);
        }
        $orderid = intval(IReq::get('orderid'));
        if (!empty($orderid)) {
            $order = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where buyeruid='".$this->member['uid']."' and id = ".$orderid."");
            $data['order'] = $order;
            if ($order['is_reback'] > 0) {
                $drawbacklog =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."drawbacklog where orderid='".$order['id']."'  ");
                $data['drawbacklog'] = $drawbacklog;
                #print_r($drawbacklog);
            }
            Mysite::$app->setdata($data);
        } else {
            $data['order'] = '';
            Mysite::$app->setdata($data);
        }
    }
    public function savedrawbacklog()
    {
        if (empty($this->member['uid'])) {
            $this->message('member_nologin');
        }
        $orderid = intval(IReq::get('orderid'));
        $orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where id='".$orderid."' and buyeruid=".$this->member['uid']."  ");
        $err = '';
        if($orderinfo['is_reback'] > 0){
			$err = '退款处理中，不能受理';
		}
		if($orderinfo['status'] > 3){
			$err = '订单已取消，不能受理';
		}
		if($orderinfo['status'] == 2){
			$err = '订单已发货，不能受理';
		}
		if($orderinfo['status'] == 3){
			$err = '订单已完成，不能受理';
		}
		if($orderinfo['status'] == 0){
			$err = '订单还未通过审核，不能受理';
		}
        if($err)
        {
            $this->message($err);
        }
        $drawbacklog = new drawbacklog($this->mysql, $this->memberCls);

        $check = $drawbacklog->save();
        if ($check == true) {
            $this->success('success');
        } else {
            $msg = $drawbacklog->GetErr();
            $this->message($msg);
        }
    }

    public function login()
    {
        $data = array();
        if (strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger')) {    //判断是微信浏览器不
            $data['is_wx'] = 1;
        } else {
            $data['is_wx'] = 0;
        }
        if ($this->member['uid'] > 0) {
            $link = IUrl::creatUrl('wxsite/member');
            $this->message('', $link);
        }
        $info = $this->mysql->select_one(" select id from `".Mysite::$app->config['tablepre']."otherlogin`   where `loginname`='qqphone' ");

        $weblink = ICookie::get('wx_login_link');
        $defaultlink = IUrl::creatUrl('wxsite/member');
        $data['web_extend_link'] = empty($weblink)? $defaultlink:$weblink;
        $data['is_installqq'] = $info;
        Mysite::$app->setdata($data);
    }
    public function reg()
    {
        if ($this->member['uid'] > 0) {
            $link = IUrl::creatUrl('wxsite/member');
            $this->message('', $link);
        }
    }
    public function loginout()
    {
        $this->memberCls->loginout();
		// if($_GET['ceshi'])
		// {
			// exit;
		// }
        $link = IUrl::creatUrl('wxsite/index');
        $this->message('', $link);
    }
    public function checkwxweb()
    {
        $myurl = Mysite::$app->config['siteurl'].$_SERVER["REQUEST_URI"];

        $action = Mysite::$app->getAction();
        if ($action != 'setlogin') {
            $checkinfo =  ICookie::set('wx_login_link');
            $myurl = empty($checkinfo)?$myurl:$checkinfo;
            ICookie::set('wx_login_link', $myurl, 86400);
        }
        if ($this->member['uid'] <= 0) {
            $link = IUrl::creatUrl('wxsite/login');
            $this->message('未登陆', $link);
        }
    }
    public function checkshopmemberlogin()
    {
        if(empty($this->member['shopinfo'])) $this->message('店铺不存在');
    }
    public function checkbackinfo()
    {
        if (strpos($_SERVER["HTTP_USER_AGENT"], 'MicroMessenger')) {    //判断是微信浏览器不
            return true;
        } else {
            return false;
        }
    }


    public function searchresult()
    {   //ajax搜索 商家和商品结果
        $searchname = IFilter::act(IReq::get('searchname'))   ;
        $uid = $this->member['uid'];
        $searchlist = ICookie::get('searchlist');
        if (empty($searchlist)) {
            $searchlist = array();
            array_unshift($searchlist, array('searchval'=>$searchname,'searchtime'=>time()));
        } else {
            foreach ($searchlist as  $val) {
                $temp[]=$val['searchval'];
            }
            if (!in_array($searchname, $temp)) {
                array_unshift($searchlist, array('searchval'=>$searchname,'searchtime'=>time()));
            }
        }
        ICookie::set("searchlist", $searchlist);


        if ($uid > 0) {
            $sdata['uid'] = $uid;
            $sdata['searchval'] = $searchname;
            $sdata['searchtime'] = time();
            $checksearch = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."searchlog where searchval = '".$searchname."' ");

            if (empty($checksearch)) {
                $this->mysql->insert(Mysite::$app->config['tablepre'].'searchlog', $sdata);   // 插入用户 搜索记录
            }
        }

        $cxsignlist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodssign where type='cx' order by id desc limit 0, 100");
        $cxarray  =  array();
        foreach ($cxsignlist as $key=>$value) {
            $cxarray[$value['id']] = $value['imgurl'];
        }


        /* 搜索店铺 结果  */
        $where = '';
        $shopsearch = IFilter::act(IReq::get('searchname'));
        $shopsearch      = urldecode($shopsearch);
        if (!empty($shopsearch)) {
            $where=" and shopname like '%".$shopsearch."%' ";
        }
        $where .= " AND stationid = ".$this->stationid;

        $lng = 0;
        $lat = 0;

        $lng = $this->lng;
        $lat = $this->lat;


        #  $where = empty($where)?'   and  SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradiusa`*0.01094-0.01094) ': $where.' and SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradiusa`*0.01094-0.01094) ';


        $lng = trim($lng);
        $lat = trim($lat);



        /*获取店铺*/
        $where = Mysite::$app->config['plateshopid'] > 0? $where.' and  id != '.Mysite::$app->config['plateshopid'] .' ':$where;
        $pageinfo = new page();
        $pageinfo->setpage(intval(IReq::get('page')));

        $tempdd = array();
        //and is_recom = 1
        $tempdd[] =   $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop where is_pass = 1  and (   admin_id='".$this->CITY_ID."'  or  admin_id = 0 )     and endtime > ".time()."  ".$where." ");
        #   $tempdd[] =   $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop where is_pass = 1  and (   admin_id='".$this->CITY_ID."'  or  admin_id = 0 )  and is_open = 1  and is_recom != 1 and endtime > ".time()."  ".$where." ");
        // print_r($tempdd);
        $nowhour = date('H:i:s', time());
        $nowhour = strtotime($nowhour);
        $templist = array();
        $cxclass = new sellrule();
        foreach ($tempdd as $key=>$list) {
            if (is_array($list)) {
                foreach ($list as $keys=>$values) {
                    if ($values['id'] > 0) {
                        $templist111 = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where cattype = ".$values['shoptype']." and  parent_id = 0    order by orderid asc limit 0,1000");
                        $attra = array();
                        $attra['input'] = 0;
                        $attra['img'] = 0;
                        $attra['checkbox'] = 0;
                        foreach ($templist111 as $key=>$vall) {
                            if ($vall['type'] == 'input') {
                                $attra['input'] =  $attra['input'] > 0?$attra['input']:$vall['id'];
                            } elseif ($vall['type'] == 'img') {
                                $attra['img'] =  $attra['img'] > 0?$attra['img']:$vall['id'];
                            } elseif ($vall['type'] == 'checkbox') {
                                $attra['checkbox'] =  $attra['checkbox'] > 0?$attra['checkbox']:$vall['id'];
                            }
                        }


                        $shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast where  shopid = ".$values['id']."   ");


                        $values = array_merge($values, $shopdet);

                        $values['shoplogo'] = empty($values['shoplogo'])? Mysite::$app->config['imgserver'].Mysite::$app->config['shoplogo']:Mysite::$app->config['imgserver'].$values['shoplogo'];
                        $checkinfo = $this->shopIsopen($values['is_open'], $values['starttime'], $values['is_orderbefore'], $nowhour);
                        $values['opentype'] = $checkinfo['opentype'];
                        $values['newstartime']  =  $checkinfo['newstartime'];
                        $attrdet = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopattr where  cattype = ".$values['shoptype']." and shopid = ".$values['id']."");
                        $cxclass->setdata($values['id'], 1000, $values['shoptype']);



                        $checkps =   $this->pscost($values);
                        $values['pscost'] = $checkps['pscost'];


                        $mi = $this->GetDistance($lat, $lng, $values['lat'], $values['lng'], 1);
                        $tempmi = $mi;
                        $mi = $mi > 1000? round($mi/1000, 2).'km':$mi.'m';

                        $values['juli'] =       $mi;

                        $shopcounts = $this->mysql->select_one("select count(id) as shuliang  from ".Mysite::$app->config['tablepre']."order     where status = 3 and  shopid = ".$values['id']."");

                        if (empty($shopcounts['shuliang'])) {
                            $values['ordercount'] = 0;
                        } else {
                            $values['ordercount']  = $shopcounts['shuliang'];
                        }
                        #print_r($values['ordercount'].'---');print_r($values['virtualsellcounts'].'++++');
                        $values['ordercount']  = $values['ordercount']+$values['virtualsellcounts'];
                        $cxinfo = $this->mysql->getarr("select name,id,signid from ".Mysite::$app->config['tablepre']."rule where   shopid = ".$values['id']." and status = 1 and starttime  < ".time()." and endtime > ".time()." ");
                        $values['cxlist'] = array();

                        foreach ($cxinfo as $k1=>$v1) {
                            if (isset($cxarray[$v1['signid']])) {
                                $v1['imgurl'] = $cxarray[$v1['signid']];
                                $values['cxlist'][] = $v1;
                            }
                        }






                        /* 店铺星级计算 */
                        $zongpoint = $values['point'];
                        $zongpointcount = $values['pointcount'];
                        if ($zongpointcount != 0) {
                            $shopstart = intval(round($zongpoint/$zongpointcount));
                        } else {
                            $shopstart= 0;
                        }
                        $values['point'] =  $shopstart;

                        // print_r($values['point']);
                        $values['attrdet'] = array();
                        foreach ($attrdet as $k=>$v) {
                            if ($v['firstattr'] == $attra['input']) {
                                $values['attrdet']['input'] = $v['value'];
                            } elseif ($v['firstattr'] == $attra['img']) {
                                $values['attrdet']['img'][] = $v['value'];
                            } elseif ($v['firstattr'] == $attra['checkbox']) {
                                $values['attrdet']['checkbox'][] = $v['value'];
                            }
                        }

                        $templist[] = $values;
                    }
                }
            }
        }
        $data['shopsearchlist']   = $templist;


        #   print_r($data['shopsearchlist']);




        /* 搜索商品列表 */
        $weekji = date('w');
        $goodwhere = '';
        $goodssearch = IFilter::act(IReq::get('searchname'));
        $goodssearch         = urldecode($goodssearch);
        if (!empty($goodssearch)) {
            $goodlistwhere=" and name like '%".$goodssearch."%' ";
        }
        $lng = 0;
        $lat = 0;

        $lng = $this->lng;
        $lat = $this->lat;


        $goodwhere = empty($goodwhere)?'   and  SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradiusa`*0.01094-0.01094) ': $goodwhere.' and SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradiusa`*0.01094-0.01094) ';

        $lng = trim($lng);
        $lat = trim($lat);



        $templist11 = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where  cattype = 0 and parent_id = 0 and is_main =1  order by orderid asc limit 0,1000");
        $attra['input'] = 0;
        $attra['img'] = 0;
        $attra['checkbox'] = 0;
        foreach ($templist11 as $key=>$value) {
            if ($value['type'] == 'input') {
                $attra['input'] =  $attra['input'] > 0?$attra['input']:$value['id'];
            } elseif ($value['type'] == 'img') {
                $attra['img'] =  $attra['img'] > 0?$attra['img']:$value['id'];
            } elseif ($value['type'] == 'checkbox') {
                $attra['checkbox'] =  $attra['checkbox'] > 0?$attra['checkbox']:$value['id'];
            }
        }
        /*获取店铺*/
        $pageinfo = new page();
        $pageinfo->setpage(intval(IReq::get('page')));
        $goodwhere = Mysite::$app->config['plateshopid'] > 0? $goodwhere.' and  id != '.Mysite::$app->config['plateshopid'] .' ':$goodwhere;

        $list =   $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop where is_pass = 1     and endtime > ".time()."  ".$goodwhere." ");


        #   $list = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where  b.is_pass = 1  ".$tempwhere." ".$goodwhere."    order by ".$orderarray[$order]." limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."");


        $nowhour = date('H:i:s', time());
        $nowhour = strtotime($nowhour);
        $goodssearchlist = array();
        $cxclass = new sellrule();

        if (is_array($list)) {
            foreach ($list as $keys=>$vatt) {
                if ($vatt['id'] > 0) {
                    $detaa = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goods where shopid='".$vatt['id']."'  and shoptype = ".$vatt['shoptype']."  and    FIND_IN_SET( ".$weekji." , `weeks` )  ".$goodlistwhere."   order by good_order asc ");
                    if (!empty($detaa)) {
                        foreach ($detaa as $keyq=>$valq) {
                            if ($valq['is_cx'] == 1) {
                                //测算促销 重新设置金额
                                $cxdata = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goodscx where goodsid=".$valq['id']."  ");
                                $newdata = getgoodscx($valq['cost'], $cxdata);

                                $valq['zhekou'] = $newdata['zhekou'];
                                $valq['is_cx'] = $newdata['is_cx'];
                                $valq['cost'] = $newdata['cost'];
                                $valq['cxnum'] = $cxdata['cxnum'];
                            }

                            $shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast where  shopid = ".$valq['shopid']."   ");

                            $checkinfo = $this->shopIsopen($vatt['is_open'], $vatt['starttime'], $shopdet['is_orderbefore'], $nowhour);
                            $valq['opentype'] = $checkinfo['opentype'];

                            $temparray[] =$valq;
                            $vakk = $temparray;
                        }
                    }
                    $goodssearchlist = $vakk;

                    #           $vatt['goodsdet'] = $this->mysql->getarr("  ");

                                #       $templist11[] = $vatt;
                }
            }
        }




        $data['goodssearchlist']   = $goodssearchlist;
        $shop_mang=$this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop where id = '173' ");
        #print_r($shop_mang);
        #print_r($data['goodssearchlist']);



        Mysite::$app->setdata($data);
    }

    public function qkmemsearchlog()
    {  //清空会员搜索记录

        $uid = $this->member['uid'];
        if ($uid > 0) {
            $this->mysql->delete(Mysite::$app->config['tablepre'].'searchlog', "uid ='".$uid."'");
            ICookie::set('searchlist', array());
            $this->success('success');
        } else {
            ICookie::set('searchlist', array());
            $this->success('success');
        }
    }
    // 个人中心点击头像判断登录
    public function myaccount()
    {
        $this->checkwxweb();

        $userinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."wxuser where uid = ".$this->member['uid']." ");
        $stationadmininfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."stationadmininfo where id = ".$this->stationid." ");
        $data['is_bang'] = $userinfo['is_bang'];
        $data['stationadmininfo'] = $stationadmininfo;
        Mysite::$app->setdata($data);
    }
    // 个人中心点击我的收藏判断登录
    public function collect()
    {
        $this->checkwxweb();
        $lng = $this->lng;
        $lat = $this->lat;


        $lng = trim($lng);
        $lat = trim($lat);


        $list =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop where is_pass = 1  and endtime > ".time()."  ");
        $nowhour = date('H:i:s', time());
        $nowhour = strtotime($nowhour);
        $templist = array();
        $cxclass = new sellrule();

        if (is_array($list)) {
            foreach ($list as $keys=>$values) {
                if ($values['id'] > 0) {
                    $values['collect'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."collect where  collecttype = 0 and uid = ".$this->member['uid']." and collectid  = '".$values['id']."' ");//收藏
                    if (!empty($values['collect'])) {
                        $templist111 = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where cattype = ".$values['shoptype']." and  parent_id = 0    order by orderid asc limit 0,1000");
                        $attra = array();
                        $attra['input'] = 0;
                        $attra['img'] = 0;
                        $attra['checkbox'] = 0;
                        foreach ($templist111 as $key=>$vall) {
                            if ($vall['type'] == 'input') {
                                $attra['input'] =  $attra['input'] > 0?$attra['input']:$vall['id'];
                            } elseif ($vall['type'] == 'img') {
                                $attra['img'] =  $attra['img'] > 0?$attra['img']:$vall['id'];
                            } elseif ($vall['type'] == 'checkbox') {
                                $attra['checkbox'] =  $attra['checkbox'] > 0?$attra['checkbox']:$vall['id'];
                            }
                        }
                        #       print_r($attra);
                        #       echo("11111111");


                        $shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast where  shopid = ".$values['id']."   ");

                        if (!empty($shopdet)) {
                            $values = array_merge($values, $shopdet);

                            $values['shoplogo'] = empty($values['shoplogo'])? Mysite::$app->config['imgserver'].Mysite::$app->config['shoplogo']:Mysite::$app->config['imgserver'].$values['shoplogo'];
                            $checkinfo = $this->shopIsopen($values['is_open'], $values['starttime'], $values['is_orderbefore'], $nowhour);
                            $values['opentype'] = $checkinfo['opentype'];
                            $values['newstartime']  =  $checkinfo['newstartime'];

                            $attrdet = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopattr where  cattype = ".$values['shoptype']." and shopid = ".$values['id']."");
                            $cxclass->setdata($values['id'], 1000, $values['shoptype']);

                            $mi = $this->GetDistance($lat, $lng, $values['lat'], $values['lng'], 1);
                            $tempmi = $mi;
                            $mi = $mi > 1000? round($mi/1000, 2).'km':$mi.'m';

                            $values['juli'] =       $mi;

                            $checkps =   $this->pscost($values);
                            $values['pscost'] = $checkps['pscost'];

                            $shopcounts = $this->mysql->select_one("select sellcount as shuliang  from ".Mysite::$app->config['tablepre']."shop  where    id = ".$values['id']."");
                            if (empty($shopcounts['shuliang'])) {
                                $values['ordercount'] = 0;
                            } else {
                                $values['ordercount']  = $shopcounts['shuliang'];
                            }
                            $values['ordercount']  = $values['ordercount']+$values['virtualsellcounts'];

                            $d = (date("w") ==0) ?7:date("w") ;
                            $cxinfo = $this->mysql->getarr("select name,id,imgurl,signid from ".Mysite::$app->config['tablepre']."rule where  FIND_IN_SET(".$values['id'].",shopid)   and status = 1   and ( limittype = 1 or ( limittype = 2 and ".$d."  in ( limittime )  )  or ( limittype = 3 and endtime > ".time()." and starttime < ".time().")) ");
//var_dump($cxinfo);exit;
                            $values['cxlist'] = $cxinfo;

                            // foreach ($cxinfo as $k1=>$v1) {
                            //     if (isset($cxarray[$v1['signid']])) {
                            //         $v1['imgurl'] = $cxarray[$v1['signid']];
                            //         $values['cxlist'][] = $v1;
                            //     }
                            // }
                            // 店铺星级计算
                            $zongpoint = $values['point'];
                            $zongpointcount = $values['pointcount'];
                            if ($zongpointcount != 0) {
                                $shopstart = intval(round($zongpoint/$zongpointcount));
                            } else {
                                $shopstart= 0;
                            }
                            $values['point'] =  $shopstart;
                            $values['attrdet'] = array();
                            foreach ($attrdet as $k=>$v) {
                                if ($v['firstattr'] == $attra['input']) {
                                    $values['attrdet']['input'] = $v['value'];
                                } elseif ($v['firstattr'] == $attra['img']) {
                                    $values['attrdet']['img'][] = $v['value'];
                                } elseif ($v['firstattr'] == $attra['checkbox']) {
                                    $values['attrdet']['checkbox'][] = $v['value'];
                                }
                            }

                            #        print_r($values['attrdet']);

                            $templist[] = $values;
                        }
                    }
                }
            }
        }
        $data['templist'] = $templist;
        Mysite::$app->setdata($data);
    }


    public function delphone()
    {
        $phone = intval(IReq::get('phone'));
        $areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where phone={$phone} ");
        if (!empty($areacodeone)) {
            $this->mysql->delete(Mysite::$app->config['tablepre'].'member', "uid ='".$areacodeone['uid']."'");
            $this->mysql->delete(Mysite::$app->config['tablepre'].'wxuser', "uid ='".$areacodeone['uid']."'");
        }
        echo "删除成功";
        exit;
    }
    public function wxbdphone()
    {
        $weblink = ICookie::get('wx_login_link');
        $defaultlink = IUrl::creatUrl('wxsite/member');
        $data['web_extend_link'] = empty($weblink)? $defaultlink:$weblink;
        Mysite::$app->setdata($data);
    }

    public function discount()
    {
        error_reporting(-1);
        ini_set('display_errors',1);            //错误信息
    }
    public function discountlistdata()
    {
        $pageinfo = new page();
        $pageinfo->setpage(intval(IReq::get('page')));
        $nowtime = time();
        $nowdate = date('Y-m-d', time());
        $checktime = $nowtime-strtotime($nowdate);
        $sql = "SELECT * FROM ".Mysite::$app->config['tablepre']."goods as g left join ".Mysite::$app->config['tablepre']."goodscx as gc on g.id = gc.goodsid join ".Mysite::$app->config['tablepre']."shop as s on g.shopid = s.id WHERE s.stationid = ".$this->stationid." AND g.is_cx = 1 AND g.is_live = 1 AND ".$nowtime." > gc.cxstarttime AND ".$nowtime." < gc.ecxendttime AND (($checktime > gc.cxstime1 AND $checktime < gc.cxetime1) OR ($checktime > gc.cxstime2 AND $checktime < gc.cxetime2)) limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."  ";
        $goods_list = $this->mysql->getarr($sql);

        foreach ($goods_list as $key => $goods) {
            $goods_list[$key]['cost'] = $goods['cost']*$goods['cxzhe']*0.01;
            $goods_list[$key]['zhekou'] = $goods['cxzhe']*0.1;
            $where1 = ' where ord.addtime > '.$goods['cxstarttime'] .' and ord.status >=1  and ord.is_reback = 0';
            $sql = "select count(ordet.id) as shuliang from ".Mysite::$app->config['tablepre']."orderdet  as ordet left join  ".Mysite::$app->config['tablepre']."order as ord on ordet.order_id = ord.id  ".$where1." and  ordet.goodsid = ".$goods['goodsid']."";
            $goods_count_data = $this->mysql->select_one($sql);
            //var_dump($goods_count_data);exit;
            $sell_count = $goods_count_data['shuliang'];
            $goods_list[$key]['sell_count'] = $sell_count;
            $all_count = $sell_count + $goods['count'];
            $goods_list[$key]['percent'] = $sell_count <= 0 ? '0%' : ($goods['count'] > 0 ? round($sell_count/$all_count * 100 , 2) . "%" : '100%');
        }
        $data['goods_list'] = $goods_list;
        Mysite::$app->setdata($data);
    }
    public function coupon()
    {
        $data['list'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."juan where endtime > ".time()." and status = 1 and  uid = ".$this->member['uid']." ");
        Mysite::$app->setdata($data);
    }
    public function getCoupon()
    {
        $time = time();
        $data['juansetinfo'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 6");
        $juaninfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."alljuan where type = 6 AND count > 0 AND endtime > $time AND starttime <= $time order by id asc ");
        foreach ($juaninfo as $key => $value) {
            $user_juan = $this->mysql->select_one("SELECT * FROM ".Mysite::$app->config['tablepre']."juan WHERE alljuanid = ".$value['id']." AND uid = ".$this->member['uid']." ");
            if(!empty($user_juan))
            {
                if($user_juan['status'] == 1 && $user_juan['endtime'] > time()){
                    $juaninfo[$key]['is_user_juan'] = 1;
                }else{
                    unset($juaninfo[$key]);
                }
            }else{
                $juaninfo[$key]['is_user_juan'] = 0;
            }
        }
        $data['juaninfo'] = $juaninfo;
        Mysite::$app->setdata($data);
    }
    public function getCouponSubmit()
    {
        $id = intval(IReq::get('id'));
        $nowtime = time();
        $user_juan = $this->mysql->select_one("SELECT * FROM ".Mysite::$app->config['tablepre']."juan WHERE alljuanid = $id AND uid = ".$this->member['uid']." ");
        if($user_juan){
            $this->message("您已领过该券");
        }
        $sql = "SELECT * FROM ".Mysite::$app->config['tablepre']."alljuan WHERE id = $id";
        $juaninfo = $this->mysql->select_one($sql);
        if($juaninfo['count'] <= 0)
        {
            $this->message("该代金券已领完");
        }else{
            $juansetinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 6" );
            $juandata['uid'] = $this->member['uid'];// 用户ID
            $juandata['username'] = $this->member['username'];// 用户名
            $juandata['name'] = $juansetinfo['name'];//  代金券名称
            $juandata['status'] = 1;// 状态，0未使用，1已绑定，2已使用，3无效
            $juandata['card'] = $nowtime.rand(100,999);
            $juandata['card_password'] =  substr(md5($juandata['card']),0,5);
            $juandata['limitcost']  = $juaninfo['limitcost'];
            $juandata['alljuanid'] = $id;

            if($juansetinfo['timetype'] == 1){
                 $juandata['creattime'] = time();
                 $date = date('Y-m-d',$juandata['creattime']);
                 $endtime = strtotime($date) + ($juansetinfo['days']-1)*24*60*60 + 86399;
                 $juandata['endtime'] = $endtime;
            }else{
                 $juandata['creattime'] = $juaninfo['starttime'];
                 $juandata['endtime'] =  $juaninfo['endtime'];
            }
            if($juansetinfo['costtype'] == 1){
                 $juandata['cost'] = $juaninfo['cost'];
            }else{
                 $juandata['cost'] = rand($value['costmin'],$juaninfo['costmax']);
            }
            $this->mysql->insert(Mysite::$app->config['tablepre'].'juan',$juandata);
            $data['count'] = $juaninfo['count'] - 1;
            $this->mysql->update(Mysite::$app->config['tablepre'].'alljuan',$data,"id='".$id."'");
            $tape = array(
                'name' => '系统消息',
                'content' => '你已领取一张代金券，请在“我的券包”中查看。',
                'uid' => $this->member['uid'],
            );
            $this->memberCls->insertTape($tape['uid'],$tape['name'],$tape['content']);
            $this->success('success');
        }
    }
    public function page()
    {
        $code = trim(IFilter::act(IReq::get('code')));
        $data['single'] =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."single where  code ='".$code."'   order by id asc limit 0,1");
        Mysite::$app->setdata($data);
    }
    public function about()
    {
        $code = 'about';
        $data['single'] =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."single where  code ='".$code."'   order by id asc limit 0,1");
        Mysite::$app->setdata($data);
    }
    public function contact()
    {

    }
    public function tape()
    {
        $data['list'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."tape where uid = ".$this->member['uid']."  order by id desc limit 0,20");
        Mysite::$app->setdata($data);
    }
    public function updateMemberlnglat()
    {
        $lat = trim(IFilter::act(IReq::get('lat')));
        $lng = trim(IFilter::act(IReq::get('lng')));
        $data['lat'] = $lat;
        $data['lng'] = $lng;

        $stationlist = $this->mysql->getarr("select id,lng,lat from ".Mysite::$app->config['tablepre']."stationadmininfo where stationis_open = 0 order by id desc");
        $distancedata = array();
        foreach ($stationlist as $key => $value) {
            $distance = distance($lat,$lng,$value['lat'],$value['lng']);
            $distancedata[$value['id']] = $distance;
        }
        asort($distancedata);
        reset($distancedata);
        $stationid = key($distancedata);
        $data['stationid'] = $stationid;
        $this->mysql->update(Mysite::$app->config['tablepre'].'member',$data,"uid ='".$this->member['uid']."' ");
        $this->success('success');
    }
    public function updateMemberStationid()
    {
        $stationid = intval(IReq::get('stationid'));
        $data['stationid'] = $stationid;
        $this->mysql->update(Mysite::$app->config['tablepre'].'member',$data,"uid ='".$this->member['uid']."' ");
        $this->success('success');
    }
    public function updateMobile()
    {
        $phone = trim(IFilter::act(IReq::get('phone')));
        if(!IValidate::suremobi($phone))   $this->message('errphone');
        $member= $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where phone='".$phone."' and uid = '".$this->member['uid']."' ");
        if($member){
            $this->message('手机号已绑定其他账号不能重复绑定');
        }
        $data['phone'] = $phone;
        $this->mysql->update(Mysite::$app->config['tablepre'].'member',$data,"uid ='".$this->member['uid']."' ");
        $this->success('success');
    }

    public function shoptx()
    {
        if(empty($this->member['shopinfo']))
        {
            header('Location:'.IUrl::creatUrl('wxsite/shopLogin'));
        }
    }
    public function shopLogin()
    {
        if($this->member['shopinfo']){
            header('Location:'.IUrl::creatUrl('wxsite/shoptx'));
        }
    }
    public function bindShopLogin()
    {
        $this->checkwxweb();
        if($this->member['guid']){
            $this->message('您已绑定过店铺');
        }
        $uname = IFilter::act(IReq::get('uname'));
        $pwd = IFilter::act(IReq::get('pwd'));
        if (empty($uname)) {
            $this->message('member_emptyname');
        }
        if (empty($pwd)) {
            $this->message('member_emptypwd');
        }
        if (!$checkuid = $this->memberCls->shopLogin($uname, $pwd)) {
            $this->message($this->memberCls->ero());
        }
        $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where is_pass=1 and uid=".$checkuid." ");

        if (empty($shopinfo)) {
            $this->message('shop_noexit');
        }
        //判断是否绑定过
        $gmember = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where guid = ".$checkuid." ");
        if (!empty($gmember)) {
            $this->message('该店铺已绑定其他账号！请联系管理员');
        }
        else{
            $data['guid'] = $checkuid;
            $this->mysql->update(Mysite::$app->config['tablepre'].'member', $data, "uid='".$this->member['uid']."'");
        }
        $this->success('success');
    }
    public function shopordershow()
    {
        $orderid = intval(IReq::get('orderid'));
        $orderclass = new orderClass();
        if (!empty($orderid)) {
            $order = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where shopuid='".$this->member['shopinfo']['uid']."' and id = ".$orderid."");
            if(empty($order))
            {
                echo "订单不存在或没有权限";
                exit;
            }else{
                $scoretocost =Mysite::$app->config['scoretocost'];
                $order['scoredown'] =  $order['scoredown']/$scoretocost;//抵扣积分
                $order['ps'] = $order['shopps'];
                // 超市商品总价    超市配送配送 shopcost 店铺商品总价 shopps 店铺配送费    pstype 配送方式 0：平台1：个人    bagcost
                $orderdet = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$order['id']."'");
                $order['cp'] = count($orderdet);
                $buyerstatus= array(
                  '0'=>'等待处理',
                  '1'=>'订餐成功处理中',
                  '2'=>'订单已发货',
                  '3'=>'订单完成',
                  '4'=>'订单已取消',
                  '5'=>'订单已取消'
                  );

                $order['is_acceptorder'] = $order['is_acceptorder'];
                $order['surestatus'] = $order['status'];
                $order['basetype'] = $order['paytype'];
                $order['basepaystatus'] =$order['paystatus'];
                $order['paytype'] =  $order['paytype'];
                $order['paystatus'] = $order['paystatus'] ;
                $order['setime'] = 15 * 60 - (time() - $order['addtime']);
                $order['addtime'] = date('Y-m-d H:i:s', $order['addtime']);
                $order['posttime'] = date('Y-m-d H:i:s', $order['posttime']);

                $order['order_status'] = $orderclass->handleOrderStatus($order);

                $data['order'] = $order;
                $data['orderdet'] = $orderdet;

                $data['psbpsyinfo'] = array();
                Mysite::$app->setdata($data);
            }

        } else {
            echo "订单不存在";
            exit;
        }
    }

    public function shopctlord()
    {
        $this->checkwxweb();
        $controlname =trim(IFilter::act(IReq::get('controlname')));
        $orderid = intval(IReq::get('orderid'));
        $shopid = $this->member['shopinfo']['id'];
        $shopctlord = new shopctlord($orderid,$shopid,$this->mysql);
        switch($controlname){
            case 'sendorder':
                if($shopctlord->sendorder()){
                    $this->success('success');
                }else{
                    $this->message($shopctlord->Error());
                }
            break;
            case 'closeorder':
                if($shopctlord->SetMemberls($this->memberCls)->closeorder()){
                    $this->success('success');
                }else{
                    $this->message($shopctlord->Error());
                }
            break;
            default:
            $this->message('nodefined_func');
            break;
        }
    }
    public function shoptxadd(){
        $this->checkshopmemberlogin();

        require_once hopedir."class/LockSystem.php";
        $lockSystem = new LockSystem(LockSystem::LOCK_TYPE_FILE);

        $shopid = $this->member['shopinfo']['id'];
        $shopinfo = $this->member['shopinfo'];
        $uid = $shopinfo['uid'];
        $member = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$shopinfo['uid']."'  ");
        $cost = trim(IFilter::act(IReq::get('cost')));

        //获取锁
        $lockKey = 'pay'.$shopid;
        $lockSystem->getLock($lockKey,8);

        $userinfo = $member;
        $checkcost = intval($cost);
        if($checkcost < 100){
            $this->message('提现金额不能少于100元');
        }
        if($userinfo['shopcost'] < $checkcost){
            $this->message('账号金额小于提现金额');
        }
        $newdata['cost'] = $checkcost;
        $newdata['type'] = 0;
        $newdata['status'] = 1;
        $newdata['addtime'] = time();
        $newdata['shopid'] = $shopid;
        $newdata['shopuid'] =  $uid;
        $newdata['name'] = '申请提现';
        $newdata['yue'] = $userinfo['shopcost']-$checkcost;

        $this->mysql->update(Mysite::$app->config['tablepre'].'member','`shopcost`=`shopcost`-'.$checkcost,"uid ='".$uid."' ");
        $this->mysql->insert(Mysite::$app->config['tablepre'].'shoptx',$newdata);
        $orderid = $this->mysql->insertid();
        $info = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shoptx  where id = ".$orderid." ");
        //释放锁
        $lockSystem->releaseLock($lockKey);
        $this->success($info);
    }
}
