<?php
class method extends baseclass
{

    public function updateshoporder()
    {
        $shopinfo =  $this->mysql->getarr("select  id from ".Mysite::$app->config['tablepre']."shop where id>0");
        foreach ($shopinfo as $k=>$v) {
            $ordernum = $this->mysql->select_one("select count(id) as shuliang  from " . Mysite::$app->config['tablepre'] . "order	 where  status = 3 and  shopid = " . $v['id'] . "");
            $data['ordercount'] = $ordernum['shuliang'];
            $this->mysql->update(Mysite::$app->config['tablepre'].'shop', $data, " id=".$v['id']." ");
        }
        $this->success('遍历更新店铺订单总数成功！');
    }

    /*购物车部分***********************/

    /*添加购物车*/

    public function addcart()
    {
        $smardb = new newsmcart();
        $shopid = intval(IReq::get('shopid'));
        $goods_id = intval(IReq::get('goods_id'));
        $gdtype = intval(IReq::get('gdtype'));//1普通商品 2规格商品
        $gdtype = in_array($gdtype, array(1,2))?$gdtype:1;
        if (!in_array($gdtype, array(1,2))) {
            $this->message('未定义的商品类型');
        }
        if ($smardb->setdb($this->mysql)->SetShopId($shopid)->SetGoodsType($gdtype)->SetUid($this->member['uid'])->AddGoods($goods_id)) {
            $this->success('添加购物车成功');
        } else {
            $this->message($smardb->getError());
        }
        $this->success($goods_id);
    }
    //减少购物车数量
    public function downcart()
    {
        $smardb = new newsmcart();
        $shopid = intval(IReq::get('shopid'));
        $goods_id = intval(IReq::get('goods_id'));
        $num = intval(IReq::get('num'));
        if ($shopid < 0) {
            $this->message('店铺获取失败');
        }
        if ($goods_id < 0) {
            $this->message('获取商品失败');
        }
        if ($num <  1) {
            $this->message('商品数量失败');
        }
        $gdtype = intval(IReq::get('gdtype'));//1普通商品 2规格商品
        $gdtype = in_array($gdtype, array(1,2))?$gdtype:1; //1普通商品 2规格商品 对应的 商品子ID
        if ($smardb->setdb($this->mysql)->SetShopId($shopid)->SetGoodsType($gdtype)->DownGoods($goods_id)) {
            $this->success('添加购物车成功');
        } else {
            $this->message($smardb->getError());
        }
        $this->success('操作成功');
    }
    //删除某店铺某商品
    public function delcartgoods()
    {
        $smardb = new newsmcart();
        $shopid = intval(IReq::get('shopid'));
        $goods_id = intval(IReq::get('goods_id'));
        $gdtype = intval(IReq::get('gdtype'));//1普通商品 2规格商品 对应的 商品子ID
        $gdtype = in_array($gdtype, array(1,2))?$gdtype:1; //1普通商品 2规格商品 对应的 商品子ID
        if ($smardb->setdb($this->mysql)->SetShopId($shopid)->SetGoodsType($gdtype)->DelGoods($goods_id)) {
            $this->success('添加购物车成功');
        } else {
            $this->message($smardb->getError());
        }

        $this->success('操作成功');
    }
    //删除某店铺所有商品
    public function delshopcart()
    {
        $smardb = new newsmcart();
        $shopid = intval(IReq::get('shopid'));
        if ($smardb->setdb($this->mysql)->SetShopId($shopid)->DelShop()) {
            $this->success('添加购物车成功');
        } else {
            $this->message($smardb->getError());
        }
    }
    public function selectproduct()
    {//显示商品类型
        $shopid = intval(IReq::get('shopid'));
        $goods_id = intval(IReq::get('goods_id'));
        $goodsinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods where id=".$goods_id." and shopid=".$shopid."");

        $data['productinfo'] = !empty($goodsinfo)?unserialize($goodsinfo['product_attr']):array();

        $smardb = new newsmcart();
        $nowselect = $smardb->setdb($this->mysql)->SetShopId($shopid)->FindInproduct($goods_id);
        $data['nowselect'] = $nowselect;
        //获取product 在goodsid中的商品
        $data['attrids'] = array();
        if (!empty($nowselect)) {
            $data['attrids'] = explode(',', $nowselect['attrids']);
        }

        $productlist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."product where goodsid=".$goods_id." and shopid=".$shopid."");
        $data['productlist'] = $productlist;
        $data['goodsinfo'] = $goodsinfo;
        Mysite::$app->setdata($data);
    }
    public function doselectproduct()
    {
        $shopid = intval(IReq::get('shopid'));
        $goods_id = intval(IReq::get('goods_id'));
        $fgg =  trim(IReq::get('fgg'));
        $ggdetids =  trim(IReq::get('ggdetids'));
        $type =intval(IReq::get('type'));//但默认选择全部的时候 则select_one 否则select_array()

        if (empty($ggdetids)) {
            $this->message("选择规格");
        }
        if ($type == 1) {
            $ggdetids = explode(',', $ggdetids);
            $ggwhere = '';
            foreach ($ggdetids as $key=>$value) {
                $ggwhere .= "  and   FIND_IN_SET( ".$value.",`attrids`)    ";
            }

            //and   `attrids` = '".join(',',$ggdetids)."'
            $productlist = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."product where goodsid=".$goods_id." ".$ggwhere."  and shopid=".$shopid."");

            $zigoodsinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods where id=".$productlist['goodsid']."  and shopid=".$shopid."");

            if ($zigoodsinfo['is_cx'] == 1) {
                //测算促销 重新设置金额
                $cxdata = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goodscx where goodsid=".$zigoodsinfo['id']."  ");

                $newdata = getgoodscx($productlist['cost'], $cxdata);

                $productlist['zhekou'] = $newdata['zhekou'];
                $productlist['is_cx'] = $newdata['is_cx'];
                $productlist['oldcost'] = $productlist['cost'];
                $productlist['cost'] = $newdata['cost'];
            }

            $smardb = new newsmcart();
            $nowselect = $smardb->setdb($this->mysql)->SetShopId($shopid)->productone($productlist['id']);
            $productlist['goodcartnum'] = $nowselect;
            # print_r($productlist);
            $this->success($productlist);
        } else {
            $ggdetids = explode(',', $ggdetids);
            sort($ggdetids);
            $tempid = join(',', $ggdetids);  //
            $productlist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."product where goodsid=".$goods_id."  and  FIND_IN_SET('".$tempid."',`attrids`) and shopid=".$shopid."");
            $canchoiceid = array();
            foreach ($productlist as $key=>$value) {
                if ($value['stock'] > 0) {
                    $tempids = explode(',', $value['attrids']);
                    foreach ($tempids as $k=>$v) {
                        if (!in_array($v, $canchoiceid)) {
                            $canchoiceid[] = $v;
                        }
                    }
                }
            }
            $this->success(join(',', $canchoiceid));
        }
    }

    //清楚购物车所有商品
    public function clearcart()
    {
        $smardb = new newsmcart();
        $smardb->setdb($this->mysql)->ClearCart();
        $this->success('清空所有商品成功');
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
}
