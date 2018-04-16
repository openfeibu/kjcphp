<?php
class method extends adminbaseclass
{
    public function init()
    {
        parent::init();
        $data['stationid'] = intval(IFilter::act(IReq::get('stationid')));
        $data['stationlist'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."stationadmininfo order by id desc");
        Mysite::$app->setdata($data);
        $this->stationid = $data['stationid'];
    }

    public function shop()
    {
        //店铺统计
        $selecttype = intval(IFilter::act(IReq::get('selecttype')));
        $tempselecttype = in_array($selecttype, array(0,1,2,3))?$selecttype:0;
        $wherearray = array(
            '0'=>'',
            '1'=>'  o.addtime > '.strtotime('-1 month'),
            '2'=>'  o.addtime > '.strtotime('-7 day'),
            '3'=>'  o.addtime > '.strtotime(date('Y-m-d', time()))
        );
        $where1 = ' where 1 ';
        $where1 .= empty($wherearray[$tempselecttype]) ? '':' AND '.$wherearray[$tempselecttype];
        $where1 .= empty($this->stationid) ? '':' AND o.stationid = '.$this->stationid;
        $where2 = empty($wherearray[$tempselecttype]) ? '':' and '.$wherearray[$tempselecttype];

        $orderlist = $this->mysql->getarr("select count(o.id) as shuliang ,o.shopid from ".Mysite::$app->config['tablepre']."order  as o ". $where1."   group by o.shopid   order by shuliang desc  limit 0,11");

        $data['list'] = array();
        $data['newdata'] = array();
        foreach ($orderlist as $key=>$value) {
            if ($value['shopid'] > 0) {
                $shopinfo = $this->mysql->select_one("select  shopname,id from ".Mysite::$app->config['tablepre']."shop  where id=".$value['shopid']." ");
                $value['det'] = $this->mysql->getarr("select count(o.id) as shuliang ,o.shopid from ".Mysite::$app->config['tablepre']."order as o where  o.shopid =".$value['shopid']." ".$where2."  order by id desc  limit 0,11");
                $value['shopname'] = isset($shopinfo['shopname'])? $shopinfo['shopname']:'不存在';

                $data['list'][] = $value;
            }
        }

        $timearr= array(
            '0'=>'所有时间',
            '1'=>'最近一月',
            '2'=>'最近一周',
            '3'=>'当天'
        );

        $data['typeshow'] = $timearr[$tempselecttype];
        $data['selecttype'] = $selecttype;
        Mysite::$app->setdata($data);
    }

    public function goods()
    {
        //店铺统计
        $selecttype = intval(IFilter::act(IReq::get('selecttype')));
        // $tempselecttype = in_array($selecttype,array(0,1,2,3))?$selecttype:0;
        $wherearray = array(
            '0'=>'',
            '1'=>'  ord.addtime > '.strtotime('-1 month'),
            '2'=>'  ord.addtime > '.strtotime('-7 day'),
            '3'=>'  ord.addtime > '.strtotime(date('Y-m-d', time()))
        );
        $where1 = " where 1";
        $where1 .= empty($wherearray[$selecttype]) ? '':' AND '.$wherearray[$selecttype];
        $where1 .= empty($this->stationid) ? '':' AND ord.stationid = '.$this->stationid;
        $where2 =  empty($wherearray[$selecttype]) ? '':' and '.$wherearray[$selecttype];
        $where1 .= ' and ord.status = 3  and is_reback = 0 ';
        $data['list']= $this->mysql->getarr("select count(ordet.id) as shuliang ,ordet.goodsid,ordet.goodsname as shopname from ".Mysite::$app->config['tablepre']."orderdet  as ordet left join  ".Mysite::$app->config['tablepre']."order as ord on ordet.order_id = ord.id  ".$where1." group by ordet.goodsid   order by shuliang desc  limit 0,5");

        $data['selecttype'] = $selecttype;
        Mysite::$app->setdata($data);
    }
    public function user()
    {
        //店铺统计

        $selecttype = intval(IFilter::act(IReq::get('selecttype')));
        // $tempselecttype = in_array($selecttype,array(0,1,2,3))?$selecttype:0;

        $wherearray = array(
            '0'=> 'where 1 ',
            '1'=>' where addtime > '.strtotime('-1 month'),
            '2'=>' where addtime > '.strtotime('-7 day'),
            '3'=>' where addtime > '.strtotime(date('Y-m-d', time()))
        );
        $where = empty($this->stationid) ? '' : " AND stationid = ".$this->stationid;
        $tempdata =   $this->mysql->getarr(" SELECT count(id) as shuliang ,DATE_FORMAT(FROM_UNIXTIME(`addtime`),'%k') as month FROM ".Mysite::$app->config['tablepre']."order  ".$wherearray[$selecttype].$where." GROUP BY month ");
        $list = array();
        if (is_array($tempdata)) {
            foreach ($tempdata as $key=>$value) {
                $list[$value['month']] = $value['shuliang'];
            }
        }
        $data['list'] = $list;
        $data['selecttype'] = $selecttype;
        Mysite::$app->setdata($data);
    }
    public function shopcost()
    {
        $BeginDate = IReq::get('BeginDate');
        $BeginDate = $BeginDate ? $BeginDate : date('Y-m-01');

        $GEndDate = IReq::get('EndDate');
        $GEndDate = $GEndDate ? $GEndDate : date('Y-m-d');

        $EndDate = date('Y-m-d',strtotime("$GEndDate +1 day"));
        $diff = diffBetweenTwoDays($BeginDate, $EndDate);

        $dates = $consume_dates = array();
        for ($i= $diff; $i >= 1; $i--) {
            $dates[] = $consume_dates[] = date('Y-m-d',strtotime("$EndDate -$i day"));
        }
        $where = empty($this->stationid) ? '': " AND stationid = ".$this->stationid;
        $consumes= array();
        $allcost = 0;
        foreach($dates as $key => $value)
        {
            $datas = $this->mysql->select_one(" SELECT sum(allcost) as allcost ,DATE_FORMAT(FROM_UNIXTIME(`addtime`),'%Y-%m-%d') as day FROM ".Mysite::$app->config['tablepre']."order  where DATE_FORMAT(FROM_UNIXTIME(`addtime`),'%Y-%m-%d') = '".$value."' AND status = 3 AND is_reback = 0 ".$where." GROUP BY day ");
            $consumes["'".date('md',strtotime($value))."'"] = $datas ? $datas['allcost'] : 0;
            $allcost += $datas['allcost'];
        }
        $data['consumes'] = $consumes;
        $data['x'] = implode(',',array_keys($consumes));
        $data['y'] = implode(',',array_values($consumes));
        $data['datemy'] = $datemy;
        $data['BeginDate'] = $BeginDate;
        $data['EndDate'] = $GEndDate;
        $data['allcost'] = $allcost;
        Mysite::$app->setdata($data);
    }
    public function ordertotal()
    {
        $data['buyerstatus'] = array(
            '0'=>'待处理订单',
            '1'=>'审核通过,待发货',
            '2'=>'订单已发货',
            '3'=>'订单完成',
            '4'=>'买家取消订单',
            '5'=>'卖家取消订单'
        );
        $querytype = IReq::get('querytype');
        $searchvalue = IReq::get('searchvalue');
        $orderstatus = intval(IReq::get('orderstatus'));
        $starttime = IReq::get('starttime');
        $endtime = IReq::get('endtime');
        $nowday = date('Y-m-d', time());
        $starttime = empty($starttime)? $nowday:$starttime;
        $endtime = empty($endtime)? $nowday:$endtime;
        $where = '  where ord.suretime > '.strtotime($starttime.' 00:00:00').' and ord.suretime < '.strtotime($endtime.' 23:59:59');
        $where .= empty($this->stationid) ? " " : " AND ord.stationid = ".$this->stationid;
        $data['starttime'] = $starttime;
        $data['endtime'] = $endtime;
        $data['querytype'] = '';
        $data['searchvalue'] = '';
        if (!empty($querytype)) {
            if (!empty($searchvalue)) {
                $data['searchvalue'] = $searchvalue;
                $where .= ' and '.$querytype.' =\''.$searchvalue.'\' ';
                $data['querytype'] = $querytype;
            }
        }

        $data['list'] = $this->mysql->getarr("select count(ord.id) as shuliang,ord.status,sum(allcost) as allcost,sum(scoredown) as scorecost from ".Mysite::$app->config['tablepre']."order as ord left join  ".Mysite::$app->config['tablepre']."member as mb on mb.uid = ord.buyeruid   ".$where." group by ord.status order by ord.id desc limit 0, 10");

        Mysite::$app->setdata($data);
    }

    public function orderyjin()
    {
        $searchvalue = IReq::get('searchvalue');
        $starttime = trim(IReq::get('starttime'));
        $endtime = trim(IReq::get('endtime'));

        $quyuguanli = $this->mysql->getarr("select *  from ".Mysite::$app->config['tablepre']."stationadmininfo  limit 0,1000");
        $data['quyuguanli'] = $quyuguanli;

        $newlink = '';
        $where= '';
        $where2 = '';
        $where3='';
        $data['searchvalue'] = '';
        if (!empty($searchvalue)) {
            $data['searchvalue'] = $searchvalue;
            $where .= ' where shopname = \''.$searchvalue.'\' ';
            $newlink .= '/searchvalue/'.$searchvalue;
        }
        $data['starttime'] = '';
        if (!empty($starttime)) {
            $data['starttime'] = $starttime;
            $where2 .= ' and  suretime > '.strtotime($starttime.' 00:00:01').' ';
            $where3 .= ' and  jstime > '.strtotime($starttime.' 00:00:01').' ';
            $newlink .= '/starttime/'.$starttime;
        }
        $data['endtime'] = '';
        if (!empty($endtime)) {
            $data['endtime'] = $endtime;
            $where2 .= ' and  suretime < '.strtotime($endtime.' 23:59:59').' ';
            $where3 .= ' and  jstime < '.strtotime($endtime.' 23:59:59').' ';
            $newlink .= '/endtime/'.$endtime;
        }

        $stationid = intval(IReq::get('stationid'));
        if (!empty($stationid)) {
            $where .=empty($where)?' where stationid = \''.$stationid.'\'': ' and stationid = \''.$stationid.'\' ';
            $newlink .= '/stationid/'.$stationid;
        }

        $data['stationid'] = $stationid;

        $link = IUrl::creatUrl('adminpage/analysis/module/orderyjin'.$newlink);
        $data['outlink'] =IUrl::creatUrl('adminpage/analysis/module/outtjorder/outtype/query'.$newlink);
        $data['outlinkch'] =IUrl::creatUrl('adminpage/analysis/module/outtjorder'.$newlink);
        $pageinfo = new page();
        $pageinfo->setpage(IReq::get('page'));
        $shoplist = $this->mysql->getarr("select id,shopname,yjin,shoptype from ".Mysite::$app->config['tablepre']."shop ".$where."   order by id asc  limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."");
        $list = array();
        if (is_array($shoplist)) {
            foreach ($shoplist as $key=>$value) {

                $value['sendtype'] = '平台配送';

                //货到支付
                $shoptj=  $this->mysql->select_one("select count(id) as shuliang,sum(cxcost) as cxcost,sum(yhjcost) as yhcost, sum(shopcost) as shopcost,sum(shopdowncost) as shopdowncost,sum(scoredown) as score, sum(shopps)as pscost, sum(bagcost) as bagcost from ".Mysite::$app->config['tablepre']."order  where shopid = '".$value['id']."' and paytype =0 and shopcost > 0 and status = 3 ".$where2." order by id asc  limit 0,1000");
                //在线支付
                $line  =  $this->mysql->select_one("select count(id) as shuliang,sum(cxcost) as cxcost,sum(yhjcost) as yhcost, sum(shopcost) as shopcost,sum(shopdowncost) as shopdowncost,sum(scoredown) as score, sum(shopps)as pscost, sum(bagcost) as bagcost from ".Mysite::$app->config['tablepre']."order  where shopid = '".$value['id']."' and paytype !=0  and paystatus =1 and shopcost > 0 and status = 3 ".$where2."   order by id asc  limit 0,1000");

                $value['orderNum'] =  $shoptj['shuliang']+$line['shuliang'];//订单总个数
                $scordedown = !empty(Mysite::$app->config['scoretocost']) ? $line['score']/Mysite::$app->config['scoretocost']:0;
                $value['onlinescore'] = $scordedown;
                $value['online'] = $line['shopcost']+$line['pscost']+$line['bagcost'] -$line['cxcost'] - $line['yhcost']-$scordedown;//在线支付总金额
                $scordedown = !empty(Mysite::$app->config['scoretocost']) ? $shoptj['score']/Mysite::$app->config['scoretocost']:0;
                $value['unlinescore'] = $scordedown;
                $value['unline'] = $shoptj['shopcost']+$shoptj['pscost']+$shoptj['bagcost'] -$shoptj['cxcost'] - $shoptj['yhcost']-$scordedown;
                $value['yhjcost'] = $line['yhcost'] +$shoptj['yhcost'];//使用代金券
                $value['cxcost'] = $line['cxcost'] +$shoptj['cxcost'];// 总优惠
                $value['ptcxcost'] = $line['shopdowncost'] +$shoptj['shopdowncost'];//总优惠金额中  平台承担的部分
                $value['shopcxcost'] = $value['cxcost'] - $value['ptcxcost'];//总优惠金额中  商家承担的部分
                $value['score'] = $value['unlinescore'] +$value['onlinescore']; //  使用积分
                $value['bagcost'] = $line['bagcost'] +$shoptj['bagcost'];//   打包费
                $value['pscost'] = $line['pscost'] +$shoptj['pscost'];//   配送费
                $value['allcost'] = $line['shopcost'] +$shoptj['shopcost'] - $value['cxcost'];
                $value['goodscost'] = $line['shopcost'] +$shoptj['shopcost'];//商品总价
                $jsinfo= $this->mysql->select_one("select sum(yjcost) as yjcost,sum(acountcost) as acountcost from ".Mysite::$app->config['tablepre']."shopjs  where shopid ='".$value['id']."'".$where3."  ");
                #print_r($jsinfo);
                if (!empty($jsinfo)) {
                    $value['yje']=$jsinfo['yjcost'];
                    $value['jse']=$jsinfo['acountcost'];
                } else {
                    $value['yje']='未结算';
                    $value['jse']='未结算';
                }


                #$value['yje'] = $value['yb']*$value['allcost'];
                $value['outdetail'] =IUrl::creatUrl('adminpage/analysis/module/outdetail/outtype/query/shopid/'.$value['id'].$newlink);
                $list[] = $value;
            }
        }

        $data['list'] =$list;

        $shuliang  = $this->mysql->counts("select id from ".Mysite::$app->config['tablepre']."shop ".$where."  ");
        $pageinfo->setnum($shuliang);
        $data['pagecontent'] = $pageinfo->getpagebar($link);
        Mysite::$app->setdata($data);
    }




    public function outtjorder()
    {
        $outtype = IReq::get('outtype');
        if (!in_array($outtype, array('query','ids'))) {
            header("Content-Type: text/html; charset=UTF-8");
            echo '查询条件错误';
            exit;
        }
        $where = '';
        $where2 = '';
        $where3='';
        if ($outtype == 'ids') {
            $id = trim(IReq::get('id'));
            if (empty($id)) {
                header("Content-Type: text/html; charset=UTF-8");
                echo '查询条件不能为空';
                exit;
            }
            $doid = explode('-', $id);
            $id = join(',', $doid);
            $where .= ' where id in('.$id.') ';

            $searchvalue = trim(IReq::get('searchvalue'));
            $where .= !empty($searchvalue)? ' and shopname = \''.$searchvalue.'\'':'';
            //   $data['searchvalue'] = $searchvalue;
            //	   $where .= ' where shopname = \''.$searchvalue.'\' ';

            $starttime = trim(IReq::get('starttime'));
            $where2 .= !empty($starttime)? ' and  suretime > '.strtotime($starttime.' 00:00:01').' ':'';
            $where3 .= !empty($starttime)? ' and  jstime > '.strtotime($starttime.' 00:00:01').' ':'';
            $endtime = trim(IReq::get('endtime'));
            $where2 .= !empty($endtime)? ' and  suretime < '.strtotime($endtime.' 23:59:59').' ':'';
            $where3 .= !empty($starttime)? ' and  jstime > '.strtotime($starttime.' 00:00:01').' ':'';
        } else {
            $searchvalue = trim(IReq::get('searchvalue'));
            $where .= !empty($searchvalue)? ' where shopname = \''.$searchvalue.'\'':'';
            //   $data['searchvalue'] = $searchvalue;
            //	   $where .= ' where shopname = \''.$searchvalue.'\' ';

            $starttime = trim(IReq::get('starttime'));
            $where2 .= !empty($starttime)? ' and  suretime > '.strtotime($starttime.' 00:00:01').' ':'';
            $where3 .= !empty($starttime)? ' and  jstime > '.strtotime($starttime.' 00:00:01').' ':'';
            $endtime = trim(IReq::get('endtime'));
            $where2 .= !empty($endtime)? ' and  suretime < '.strtotime($endtime.' 23:59:59').' ':'';
            $where3 .= !empty($endtime)? ' and  jstime < '.strtotime($endtime.' 23:59:59').' ':'';
        }
        $admin_id = intval(IReq::get('admin_id'));
        if (!empty($admin_id)) {
            $where .= empty($where)?' where admin_id = \''.$admin_id.'\'':' and admin_id = \''.$admin_id.'\' ';
        }


        $shoplist = $this->mysql->getarr("select id,shopname,yjin from ".Mysite::$app->config['tablepre']."shop ".$where."   order by id asc  limit 0,2000");
        $list = array();
        if (is_array($shoplist)) {
            foreach ($shoplist as $key=>$value) {

                $value['sendtype'] = '网站配送';

                $shoptj=  $this->mysql->select_one("select count(id) as shuliang,sum(cxcost) as cxcost,sum(yhjcost) as yhcost,sum(shopcost) as shopcost,sum(shopdowncost) as shopdowncost,sum(scoredown) as score, sum(shopps)as pscost, sum(bagcost) as bagcost from ".Mysite::$app->config['tablepre']."order  where shopid = '".$value['id']."' and paytype =0 and shopcost > 0 and status = 3 ".$where2." order by id asc  limit 0,1000");
                $line=    $this->mysql->select_one("select count(id) as shuliang,sum(cxcost) as cxcost,sum(yhjcost) as yhcost,sum(shopcost) as shopcost, sum(shopdowncost) as shopdowncost,sum(scoredown) as score, sum(shopps)as pscost, sum(bagcost) as bagcost from ".Mysite::$app->config['tablepre']."order  where shopid = '".$value['id']."' and paytype =1  and paystatus =1 and shopcost > 0 and status = 3 ".$where2."   order by id asc  limit 0,1000");


                $value['orderNum'] =  $shoptj['shuliang']+$line['shuliang'];//订单总个数

                $scordedown = !empty(Mysite::$app->config['scoretocost']) ? $line['score']/Mysite::$app->config['scoretocost']:0;
                $value['onlinescore'] = $scordedown;
                $value['online'] = $line['shopcost']+$line['pscost']+$line['bagcost'] -$line['cxcost'] - $line['yhcost']-$scordedown;//在线支付总金额
                $scordedown = !empty(Mysite::$app->config['scoretocost']) ? $shoptj['score']/Mysite::$app->config['scoretocost']:0;
                $value['unlinescore'] = $scordedown;
                $value['unline'] = $shoptj['shopcost']+$shoptj['pscost']+$shoptj['bagcost'] -$shoptj['cxcost'] - $shoptj['yhcost']-$scordedown;
                $value['yhjcost'] = $line['yhcost'] +$shoptj['yhcost'];//使用代金券
                $value['cxcost'] = $line['cxcost'] +$shoptj['cxcost'];// 促销总优惠

                $value['ptcxcost'] = $line['shopdowncost'] +$shoptj['shopdowncost'];// 促销总优惠中  平台承担的部分
                $value['shopcxcost'] = $value['cxcost'] - $value['ptcxcost'];       // 促销总优惠中  商家承担的部分



                $value['score'] = $value['unlinescore'] +$value['onlinescore']; //  使用积分
                $value['bagcost'] = $line['bagcost'] +$shoptj['bagcost'];//   打包费
                $value['pscost'] = $line['pscost'] +$shoptj['pscost'];//   配送费
                $value['allcost'] = $line['shopcost'] +$shoptj['shopcost'] - $value['cxcost'];
                $value['goodscost'] = $line['shopcost'] +$shoptj['shopcost'];
                $jsinfo= $this->mysql->select_one("select sum(yjcost) as yjcost,sum(acountcost) as acountcost from ".Mysite::$app->config['tablepre']."shopjs  where shopid ='".$value['id']."'".$where3."  ");
                if (!empty($jsinfo)) {
                    $value['yje']=$jsinfo['yjcost'];
                    $value['jse']=$jsinfo['acountcost'];
                } else {
                    $value['yje']='未结算';
                    $value['jse']='未结算';
                }


                $list[] = $value;
                // $list[] = $value1;
            }
        }
        $outexcel = new phptoexcel();
        $titledata = array('店铺名称','配送方式','订单数量','线上支付','线下支付','代金券','平台促销','店铺促销','积分低扣金额','配送费','商品总价','打包费','佣金');
        $titlelabel = array('shopname','sendtype','orderNum','online','unline','yhjcost','ptcxcost','shopcxcost','score','pscost','goodscost','bagcost','yje');
        // $datalist = $this->mysql->getarr("select card,card_password,cost from ".Mysite::$app->config['tablepre']."card where id > 0 ".$where."   order by id desc  limit 0,2000 ");
        $outexcel->out($titledata, $titlelabel, $list, '', '商家结算');
    }
    //导出商家结算详情
    public function outdetail()
    {
        // 订单号    时间    订单内容    配送费用  总价
        $shopid =  intval(IReq::get('shopid'));

        if (empty($shopid)) {
            header("Content-Type: text/html; charset=UTF-8");
            echo '店铺获取失败';
            exit;
        }
        $shoplist = $this->mysql->select_one("select id,shopname,yjin,shoptype from ".Mysite::$app->config['tablepre']."shop  where id='".$shopid."'   order by id asc  limit 0,2000");
        if (empty($shoplist)) {
            header("Content-Type: text/html; charset=UTF-8");
            echo '店铺获取失败';
            exit;
        }
        //dno
        $where = '';
        $where2 = '';
        $starttime = trim(IReq::get('starttime'));
        $where2 .= !empty($starttime)? ' and  suretime > '.strtotime($starttime.' 00:00:01').' ':'';

        $endtime = trim(IReq::get('endtime'));
        $where2 .= !empty($endtime)? ' and  suretime < '.strtotime($endtime.' 23:59:59').' ':'';

        $orderlist = $this->mysql->getarr("select id,dno,allcost,bagcost,shopps,shopcost,addtime,posttime,pstype ,paytype,paystatus from ".Mysite::$app->config['tablepre']."order where shopid = '".$shopid."' and  status = 3 ".$where2." order by id asc  limit 0,2000");
        $list = array();
        if (is_array($orderlist)) {
            foreach ($orderlist as $key=>$value) {
                $detlist = $this->mysql->getarr("select goodsname,goodscount as shuliang from ".Mysite::$app->config['tablepre']."orderdet  where order_id = '".$value['id']."' and shopid > 0  order by id asc  limit 0,5");
                $detinfo = '';
                if (is_array($detlist)) {
                    foreach ($detlist as $keys=>$val) {
                        $detinfo .= $val['goodsname'].'/'.$val['shuliang'].'份,';
                    }
                }

                $value['content'] = $detinfo;
                $value['payname'] = $value['paytype'] == 0?'货到支付':'在线支付';
                $value['dotime'] = date('Y-m-d H:i:s', $value['addtime']);
                $value['posttime'] = date('Y-m-d H:i:s', $value['posttime']);
                $value['pstype'] = $value['pstype'] == 1?'自送':'平台';
                $list[] = $value;
            }
        }

        $outexcel = new phptoexcel();
        $titledata = array('订单编号','订单总价','配送类型','店铺商品总价','店铺配送费','打包费','订单详情','支付方式','下单时间','配送时间');
        $titlelabel = array('dno','allcost','pstype','shopcost','shopps','bagcost','content','payname','dotime','posttime');
        $outexcel->out($titledata, $titlelabel, $list, '', '商家结算详情'.$shoplist['shopname']);
    }
    public function shopjsover()
    {
        $jstime = IFilter::act(IReq::get('daytime')); //结算日
        $searchvalue = IReq::get('searchvalue');
        $stationid = IReq::get('stationid');

        $yjb=Mysite::$app->config['yjin'];

        $nowtime = time();
        $nowmintime =  strtotime($jstime);
        $checktime = $nowtime - $nowmintime;
        if ($checktime > 457141240) {
            $nowmintime = strtotime(date('Y-m-d', $nowtime));
        }
        $where = " where js.jstime >= ".$nowmintime;

        $endtime = IFilter::act(IReq::get('endtime')); //结算日
        $checkendtime = strtotime($endtime.' 23:59:59');
        if ($checkendtime   > $nowmintime) {
            $where .= " and  js.jstime < ".$checkendtime;
        } else {
            $checkendtime = strtotime(date('Y-m-d', $nowtime));
        }
        $data['daytime'] = date('Y-m-d', $nowmintime);
        $data['endtime'] =  date('Y-m-d', $checkendtime);
        $newlink = '/daytime/'.$data['daytime'].'/endtime/'.$data['endtime'];
        $data['searchvalue'] = '';
        if (!empty($searchvalue)) {
            $data['searchvalue'] = $searchvalue;
            $where .= ' AND s.shopname = \''.$searchvalue.'\' ';
            $newlink .= '/searchvalue/'.$searchvalue;
        }
        if (!empty($stationid)) {
            $data['stationid'] = $stationid;
            $where .= ' AND s.stationid = \''.$stationid.'\' ';
            $newlink .= '/stationid/'.$stationid;
        }
        $pageshow = new page();
        $pageshow->setpage(IReq::get('page'), 10);

        $datalist =   $this->mysql->getarr("select *  from ".Mysite::$app->config['tablepre']."shopjs as js join ".Mysite::$app->config['tablepre']."shop as s on s.id = js.shopid  ".$where."   order by js.addtime desc   limit ".$pageshow->startnum().", ".$pageshow->getsize()."");
        $shuliang  = $this->mysql->counts("select *  from ".Mysite::$app->config['tablepre']."shopjs as js join ".Mysite::$app->config['tablepre']."shop as s on s.id = js.shopid ".$where."  order by js.addtime asc  ");
        $pageshow->setnum($shuliang);

        $link = IUrl::creatUrl('/adminpage/analysis/module/shopjsover'.$newlink);
        $data['pagecontent'] = $pageshow->getpagebar($link);

        $data['jslist'] = $datalist;
        $data['stationid'] = $stationid ;

        Mysite::$app->setdata($data);
    }


}
