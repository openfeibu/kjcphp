<?php
class method extends adminbaseclass
{
    /**编辑促销活动设置**/
    public function editrule()
    {
        $id = IReq::get('id');
        $data['ruleinfo'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."cxruleset where id = ".$id." ");
        if (empty($data['ruleinfo'])) {
            $this->message('信息获取失败');
        }
        Mysite::$app->setdata($data);
    }
    /**保存促销活动设置**/
    public function saveruleset()
    {
        $id = IReq::get('id');
        $data['imgurl'] = IReq::get('imgurl');
        $data['supportorder'] = IReq::get('supportorder');
        $supportplat = IReq::get('supportplat');
        $data['supportplat'] = implode(',', $supportplat);
        if (empty($id)) {
            $this->message('优惠活动id获取失败');
        }
        if (empty($data['imgurl'])) {
            $this->message('优惠活动标签获取失败');
        }
        if (empty($data['supportorder'])) {
            $this->message('优惠活动支持订单获取失败');
        }
        if (empty($data['supportplat'])) {
            $this->message('优惠活动支持平台获取失败');
        }
        $this->mysql->update(Mysite::$app->config['tablepre'].'cxruleset', $data, "id=".$id."");
        $this->success('success');
    }
    /*代金券发放*/
    public function grantset()
    {
        $data['juansetinfo'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 6 or name = '代金券活动' ");
        $data['juaninfo'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."alljuan where type = 6 or name= '代金券活动' order by id asc ");
        Mysite::$app->setdata($data);
    }
    /**保存关注微信领取代金券相关信息**/
    public function savegrantjuanset()
    {
        error_reporting(-1);
        ini_set('display_errors',1);
        $followjuan = IReq::get('followjuan');//是否开启  0关闭 1开启
        $costtype = 1;//面值类型  1固定面值  2随机面值
        $id_arr = IReq::get('id');
        $ids = implode(',',array_filter($id_arr));
        $cost = IReq::get('fjuancost');//代金券固定面值数组
        $flimitcost = IReq::get('fjuanlimitcost');//代金券固定面值限制金额数组
        $rlimitcost = IReq::get('rjuanlimitcost');//代金券随机面值限制金额数组
        $count = IReq::get('count');//代金券随机面值限制金额数组
        $costmin = IReq::get('rjuancostmin');//代金券随机面值金额下限数组
        $costmax = IReq::get('rjuancostmax');//代金券随机面值金额上限数组
        // $paytype = IReq::get('paytype'); //支持类型数组 1在线支付 2货到付款 1,2都支持
        $timetype = 2;// 失效时间类型 1固定天数 2固定时间段
        $days = IReq::get('juanday');  //失效天数
        if ($timetype == 1 && $days <=0) {
           $this->message('请输入正确的失效天数');
        }
        $starttime = IReq::get('starttime');//有效时间开始值
        $endtime = IReq::get('endtime');//有效时间结束值
        // if (strtotime($endtime.' 23:59:59') < strtotime($starttime.' 00:00:00')) {
        //    $this->message('过期时间不能早于生效时间');
        // }
        //更新代金券活动设置
        $data['status'] = $followjuan;
        $data['costtype'] = $costtype;
        $data['timetype'] = $timetype;
        $data['days'] = $days;
        // $data['starttime'] = strtotime($starttime.' 00:00:00');
        // $data['endtime'] = strtotime($endtime.' 23:59:59');
        // $this->mysql->update(Mysite::$app->config['tablepre'].'alljuanset', $data, "type = 6 or name = '代金券活动'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'alljuan', " type = 6 and id not in ($ids)");//更新时  先删除以前的后插入新的
        $data1['paytype'] = '1,2';
        $data1['type'] = 6;
        $data1['name'] = '代金券活动';
        if ($costtype == 1) { //固定面值
            foreach ($cost as $k1=>$v1) {

                $data1['cost'] = $v1;
                $data1['limitcost'] = $flimitcost[$k1];
                if ($data1['cost']<= 0 || $data1['limitcost']<=0) {
                    $this->message('请输入大于0的金额数值');
                }
                $data1['starttime'] = strtotime(date('Y-m-d 00:00:00'));
                $data1['endtime'] = strtotime($endtime[$k1].' 23:59:59');
                $data1['count'] = $count[$k1];

                if(isset($id_arr[$k1]) && !empty($id_arr[$k1]))
                {
                    $this->mysql->update(Mysite::$app->config['tablepre'].'alljuan', $data1, "id = ".$id_arr[$k1]."");
                }else{

                    $this->mysql->insert(Mysite::$app->config['tablepre'].'alljuan', $data1);
                }
            }
        } else {
            foreach ($rlimitcost as $k2=>$v2) {
                $data1['limitcost'] = $v2;
                $data1['costmin'] = $costmin[$k2];
                $data1['costmax'] = $costmax[$k2];
                if ($data1['costmin']<= 0 ||$data1['costmax']<= 0 || $data1['limitcost']<=0) {
                    $this->message('请输入大于0的金额数值');
                }
                $data1['starttime'] = strtotime($starttime.' 00:00:00');
                $data1['endtime'] = strtotime($endtime.' 23:59:59');
                $data1['count'] = $count[$k2];
                $this->mysql->insert(Mysite::$app->config['tablepre'].'alljuan', $data1);
            }
        }
        $this->success('success');
    }
    /**关注微信领取代金券相关信息**/
    public function followsjset()
    {
        $data['juansetinfo'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 1 or name = '关注送代金券' ");
        $data['juaninfo'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."alljuan where type = 1 or name= '关注送代金券' order by id asc ");
        Mysite::$app->setdata($data);
    }
    /**保存关注微信领取代金券相关信息**/
    public function savefollowjuanset()
    {
        $followjuan = IReq::get('followjuan');//是否开启  0关闭 1开启
       $costtype = IReq::get('costtype');//面值类型  1固定面值  2随机面值
       $cost = IReq::get('fjuancost');//代金券固定面值数组
       $flimitcost = IReq::get('fjuanlimitcost');//代金券固定面值限制金额数组
       $rlimitcost = IReq::get('rjuanlimitcost');//代金券随机面值限制金额数组
       $costmin = IReq::get('rjuancostmin');//代金券随机面值金额下限数组
       $costmax = IReq::get('rjuancostmax');//代金券随机面值金额上限数组
       $paytype = IReq::get('paytype'); //支持类型数组 1在线支付 2货到付款 1,2都支持
       $timetype = IReq::get('timetype');// 失效时间类型 1固定天数 2固定时间段
       $days = IReq::get('juanday');  //失效天数
       if ($timetype == 1 && $days <=0) {
           $this->message('请输入正确的失效天数');
       }
        $starttime = IReq::get('starttime');//有效时间开始值
       $endtime = IReq::get('endtime');//有效时间结束值
       if (strtotime($endtime.' 23:59:59') < strtotime($starttime.' 00:00:00')) {
           $this->message('过期时间不能早于生效时间');
       }

        //更新关注微信领取代金券设置
        $data['status'] = $followjuan;
        $data['costtype'] = $costtype;
        $data['paytype'] = implode(',', $paytype);
        $data['timetype'] = $timetype;
        $data['days'] = $days;
        $data['starttime'] = strtotime($starttime.' 00:00:00');
        $data['endtime'] = strtotime($endtime.' 23:59:59');
        $this->mysql->update(Mysite::$app->config['tablepre'].'alljuanset', $data, "type = 1 or name = '关注送代金券'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'alljuan', " type = 1");//更新时  先删除以前的后插入新的
        $data1['paytype'] = implode(',', $paytype);
        $data1['type'] = 1;
        $data1['name'] = '关注送代金券';
        if ($costtype == 1) { //固定面值
            foreach ($cost as $k1=>$v1) {
                $data1['cost'] = $v1;
                $data1['limitcost'] = $flimitcost[$k1];
                if ($data1['cost']<= 0 || $data1['limitcost']<=0) {
                    $this->message('请输入大于0的金额数值');
                }
                $data1['starttime'] = strtotime($starttime.' 00:00:00');
                $data1['endtime'] = strtotime($endtime.' 23:59:59');
                $this->mysql->insert(Mysite::$app->config['tablepre'].'alljuan', $data1);
            }
        } else {
            foreach ($rlimitcost as $k2=>$v2) {
                $data1['limitcost'] = $v2;
                $data1['costmin'] = $costmin[$k2];
                $data1['costmax'] = $costmax[$k2];
                if ($data1['costmin']<= 0 ||$data1['costmax']<= 0 || $data1['limitcost']<=0) {
                    $this->message('请输入大于0的金额数值');
                }
                $data1['starttime'] = strtotime($starttime.' 00:00:00');
                $data1['endtime'] = strtotime($endtime.' 23:59:59');
                $this->mysql->insert(Mysite::$app->config['tablepre'].'alljuan', $data1);
            }
        }
        $this->success('success');
    }

    /**注册领取代金券相关信息**/
    public function registersjset()
    {
        $data['juansetinfo'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 2 or name = '注册送代金券' ");
        $data['juaninfo'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."alljuan where type = 2 or name= '注册送代金券' order by id asc ");
        Mysite::$app->setdata($data);
    }
    /**保存注册领取代金券相关信息**/
    public function saveregistersjset()
    {
        $followjuan = IReq::get('followjuan');//是否开启  0关闭 1开启
       $costtype = 1;//面值类型  1固定面值  2随机面值
       $cost = IReq::get('fjuancost');//代金券固定面值数组
       $flimitcost = IReq::get('fjuanlimitcost');//代金券固定面值限制金额数组
       $rlimitcost = IReq::get('rjuanlimitcost');//代金券随机面值限制金额数组
       $costmin = IReq::get('rjuancostmin');//代金券随机面值金额下限数组
       $costmax = IReq::get('rjuancostmax');//代金券随机面值金额上限数组
       $paytype = IReq::get('paytype'); //支持类型数组 1在线支付 2货到付款 1,2都支持
       $timetype = IReq::get('timetype');// 失效时间类型 1固定天数 2固定时间段
       $days = IReq::get('juanday');  //失效天数
       if ($timetype == 1 && $days <=0) {
           $this->message('请输入正确的失效天数');
       }
        $starttime = IReq::get('starttime');//有效时间开始值
       $endtime = IReq::get('endtime');//有效时间结束值
       if (strtotime($endtime.' 23:59:59') < strtotime($starttime.' 00:00:00')) {
           $this->message('过期时间不能早于生效时间');
       }
        //更新关注微信领取代金券设置
        $data['status'] = $followjuan;
        $data['costtype'] = $costtype;
        $data['paytype'] = implode(',', $paytype);
        $data['timetype'] = $timetype;
        $data['days'] = $days;
        $data['starttime'] = strtotime($starttime.' 00:00:00');
        $data['endtime'] = strtotime($endtime.' 23:59:59');
        $this->mysql->update(Mysite::$app->config['tablepre'].'alljuanset', $data, "type = 2 or name = '注册送代金券'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'alljuan', " type = 2");//更新时  先删除以前的后插入新的
        $data1['paytype'] = implode(',', $paytype);
        $data1['type'] = 2;
        $data1['name'] = '注册送代金券';
        if ($costtype == 1) { //固定面值
            foreach ($cost as $k1=>$v1) {
                $data1['cost'] = $v1;
                $data1['limitcost'] = $flimitcost[$k1];
                if ($data1['cost']<= 0 || $data1['limitcost']<=0) {
                    $this->message('请输入大于0的金额数值');
                }
                $data1['starttime'] = strtotime($starttime.' 00:00:00');
                $data1['endtime'] = strtotime($endtime.' 23:59:59');
                $this->mysql->insert(Mysite::$app->config['tablepre'].'alljuan', $data1);
            }
        } else {
            foreach ($rlimitcost as $k2=>$v2) {
                $data1['limitcost'] = $v2;
                $data1['costmin'] = $costmin[$k2];
                $data1['costmax'] = $costmax[$k2];
                if ($data1['costmin']<= 0 ||$data1['costmax']<= 0 || $data1['limitcost']<=0) {
                    $this->message('请输入大于0的金额数值');
                }
                $data1['starttime'] = strtotime($starttime.' 00:00:00');
                $data1['endtime'] = strtotime($endtime.' 23:59:59');
                $this->mysql->insert(Mysite::$app->config['tablepre'].'alljuan', $data1);
            }
        }
        $this->success('success');
    }
    /**充值送代金券相关信息**/
    public function rechargesjset()
    {
        $data['juansetinfo'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 3 or name = '充值送代金券' ");
        $data['juaninfo'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."alljuan where type = 3 or name= '充值送代金券' order by id asc ");
        Mysite::$app->setdata($data);
    }
    /**保存充值送代金券相关信息**/
    public function saverechargesjset()
    {
        $costtype = IReq::get('costtype');//面值类型  1固定面值  2随机面值
       $cost = IReq::get('fjuancost');//代金券固定面值数组
       $flimitcost = IReq::get('fjuanlimitcost');//代金券固定面值限制金额数组
       $rlimitcost = IReq::get('rjuanlimitcost');//代金券随机面值限制金额数组
       $costmin = IReq::get('rjuancostmin');//代金券随机面值金额下限数组
       $costmax = IReq::get('rjuancostmax');//代金券随机面值金额上限数组
       $paytype = IReq::get('paytype'); //支持类型数组 1在线支付 2货到付款 1,2都支持
       $timetype = IReq::get('timetype');// 失效时间类型 1固定天数 2固定时间段
       $days = IReq::get('juanday');  //失效天数
       if ($timetype == 1 && $days <=0) {
           $this->message('请输入正确的失效天数');
       }
        $starttime = IReq::get('starttime');//有效时间开始值
       $endtime = IReq::get('endtime');//有效时间结束值
       if (strtotime($endtime.' 23:59:59') < strtotime($starttime.' 00:00:00')) {
           $this->message('过期时间不能早于生效时间');
       }
        //更新关注微信领取代金券设置
        $data['status'] = $followjuan;
        $data['costtype'] = $costtype;
        $data['paytype'] = implode(',', $paytype);
        $data['timetype'] = $timetype;
        $data['days'] = $days;
        $data['starttime'] = strtotime($starttime.' 00:00:00');
        $data['endtime'] = strtotime($endtime.' 23:59:59');
        $this->mysql->update(Mysite::$app->config['tablepre'].'alljuanset', $data, "type = 3 or name = '充值送代金券'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'alljuan', " type = 3");//更新时  先删除以前的后插入新的
        $data1['paytype'] = implode(',', $paytype);
        $data1['type'] = 3;
        $data1['name'] = '充值送代金券';
        if ($costtype == 1) { //固定面值
            foreach ($cost as $k1=>$v1) {
                $data1['cost'] = $v1;
                $data1['limitcost'] = $flimitcost[$k1];
                if ($data1['cost']<= 0 || $data1['limitcost']<=0) {
                    $this->message('请输入大于0的金额数值');
                }
                $data1['starttime'] = strtotime($starttime.' 00:00:00');
                $data1['endtime'] = strtotime($endtime.' 23:59:59');
                $this->mysql->insert(Mysite::$app->config['tablepre'].'alljuan', $data1);
            }
        } else {
            foreach ($rlimitcost as $k2=>$v2) {
                $data1['limitcost'] = $v2;
                $data1['costmin'] = $costmin[$k2];
                $data1['costmax'] = $costmax[$k2];
                if ($data1['costmin']<= 0 ||$data1['costmax']<= 0 || $data1['limitcost']<=0) {
                    $this->message('请输入大于0的金额数值');
                }
                $data1['starttime'] = strtotime($starttime.' 00:00:00');
                $data1['endtime'] = strtotime($endtime.' 23:59:59');
                $this->mysql->insert(Mysite::$app->config['tablepre'].'alljuan', $data1);
            }
        }
        $this->success('success');
    }
    /**下单领取代金券相关信息**/
    public function makeordersjset()
    {
        $data['juansetinfo'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 4 or name = '下单送代金券' ");
        $data['juaninfo'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."alljuan where type = 4 or name= '下单送代金券' order by id asc ");
        Mysite::$app->setdata($data);
    }
    /**保存下单领取代金券相关信息**/
    public function savemakeordersjset()
    {
        $followjuan = IReq::get('followjuan');//是否开启  0关闭 1开启
       $costtype = IReq::get('costtype');//面值类型  1固定面值  2随机面值
       $cost = IReq::get('fjuancost');//代金券固定面值数组
       $flimitcost = IReq::get('fjuanlimitcost');//代金券固定面值限制金额数组
       $rlimitcost = IReq::get('rjuanlimitcost');//代金券随机面值限制金额数组
       $costmin = IReq::get('rjuancostmin');//代金券随机面值金额下限数组
       $costmax = IReq::get('rjuancostmax');//代金券随机面值金额上限数组
       $paytype = IReq::get('paytype'); //支持类型数组 1在线支付 2货到付款 1,2都支持
       $timetype = IReq::get('timetype');// 失效时间类型 1固定天数 2固定时间段
       $days = IReq::get('juanday');  //失效天数
       if ($timetype == 1 && $days <=0) {
           $this->message('请输入正确的失效天数');
       }
        $starttime = IReq::get('starttime');//有效时间开始值
       $endtime = IReq::get('endtime');//有效时间结束值
      if (strtotime($endtime.' 23:59:59') < strtotime($starttime.' 00:00:00')) {
          $this->message('过期时间不能早于生效时间');
      }

        //更新关注微信领取代金券设置
        $data['status'] = $followjuan;
        $data['costtype'] = $costtype;
        $data['paytype'] = implode(',', $paytype);
        $data['timetype'] = $timetype;
        $data['days'] = $days;
        $data['starttime'] = strtotime($starttime.' 00:00:00');
        $data['endtime'] = strtotime($endtime.' 23:59:59');
        $this->mysql->update(Mysite::$app->config['tablepre'].'alljuanset', $data, "type = 4 or name = '下单送代金券'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'alljuan', " type = 4");//更新时  先删除以前的后插入新的
        $data1['paytype'] = implode(',', $paytype);
        $data1['type'] = 4;
        $data1['name'] = '下单送代金券';
        if ($costtype == 1) { //固定面值
            foreach ($cost as $k1=>$v1) {
                $data1['cost'] = $v1;
                $data1['limitcost'] = $flimitcost[$k1];
                if ($data1['cost']<= 0 || $data1['limitcost']<=0) {
                    $this->message('请输入大于0的金额数值');
                }
                $data1['starttime'] = strtotime($starttime.' 00:00:00');
                $data1['endtime'] = strtotime($endtime.' 23:59:59');
                $this->mysql->insert(Mysite::$app->config['tablepre'].'alljuan', $data1);
            }
        } else {
            foreach ($rlimitcost as $k2=>$v2) {
                $data1['limitcost'] = $v2;
                $data1['costmin'] = $costmin[$k2];
                $data1['costmax'] = $costmax[$k2];
                if ($data1['costmin']<= 0 ||$data1['costmax']<= 0 || $data1['limitcost']<=0) {
                    $this->message('请输入大于0的金额数值');
                }
                $data1['starttime'] = strtotime($starttime.' 00:00:00');
                $data1['endtime'] = strtotime($endtime.' 23:59:59');
                $this->mysql->insert(Mysite::$app->config['tablepre'].'alljuan', $data1);
            }
        }
        $this->success('success');
    }
    /**邀请好友送红包相关信息**/
    public function invitesjset()
    {
        $data['juansetinfo'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 5 or name = '邀请好友送红包' ");
        $data['juaninfo'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."alljuan where type = 5 or name= '邀请好友送红包' order by id asc ");
        Mysite::$app->setdata($data);
    }
    /**保存邀请好友送红包相关信息**/
    public function saveinvitesjset()
    {
        $followjuan = IReq::get('followjuan');//是否开启  0关闭 1开启
       $costtype = IReq::get('costtype');//面值类型  1固定面值  2随机面值
       $cost = IReq::get('fjuancost');//代金券固定面值数组
       $flimitcost = IReq::get('fjuanlimitcost');//代金券固定面值限制金额数组
       $rlimitcost = IReq::get('rjuanlimitcost');//代金券随机面值限制金额数组
       $costmin = IReq::get('rjuancostmin');//代金券随机面值金额下限数组
       $costmax = IReq::get('rjuancostmax');//代金券随机面值金额上限数组
       $paytype = IReq::get('paytype'); //支持类型数组 1在线支付 2货到付款 1,2都支持
       $timetype = IReq::get('timetype');// 失效时间类型 1固定天数 2固定时间段
       $days = IReq::get('juanday');  //失效天数
       if ($timetype == 1 && $days <=0) {
           $this->message('请输入正确的失效天数');
       }
        $starttime = IReq::get('starttime');//有效时间开始值
       $endtime = IReq::get('endtime');//有效时间结束值

       if (strtotime($endtime.' 23:59:59') < strtotime($starttime.' 00:00:00')) {
           $this->message('过期时间不能早于生效时间');
       }

        //更新关注微信领取代金券设置
        $data['status'] = $followjuan;
        $data['costtype'] = $costtype;
        $data['paytype'] = implode(',', $paytype);
        $data['timetype'] = $timetype;
        $data['days'] = $days;
        $data['starttime'] = strtotime($starttime.' 00:00:00');
        $data['endtime'] = strtotime($endtime.' 23:59:59');
        $this->mysql->update(Mysite::$app->config['tablepre'].'alljuanset', $data, "type = 5 or name = '邀请好友送红包'");
        $this->mysql->delete(Mysite::$app->config['tablepre'].'alljuan', " type = 5");//更新时  先删除以前的后插入新的
        $data1['paytype'] = implode(',', $paytype);
        $data1['type'] = 5;
        $data1['name'] = '邀请好友送红包';
        if ($costtype == 1) { //固定面值
            foreach ($cost as $k1=>$v1) {
                $data1['cost'] = $v1;
                $data1['limitcost'] = $flimitcost[$k1];
                if ($data1['cost']<= 0 || $data1['limitcost']<=0) {
                    $this->message('请输入大于0的金额数值');
                }
                $data1['starttime'] = strtotime($starttime.' 00:00:00');
                $data1['endtime'] = strtotime($endtime.' 23:59:59');
                $this->mysql->insert(Mysite::$app->config['tablepre'].'alljuan', $data1);
            }
        } else {
            foreach ($rlimitcost as $k2=>$v2) {
                $data1['limitcost'] = $v2;
                $data1['costmin'] = $costmin[$k2];
                $data1['costmax'] = $costmax[$k2];
                if ($data1['costmin']<= 0 ||$data1['costmax']<= 0 || $data1['limitcost']<=0) {
                    $this->message('请输入大于0的金额数值');
                }
                $data1['starttime'] = strtotime($starttime.' 00:00:00');
                $data1['endtime'] = strtotime($endtime.' 23:59:59');
                $this->mysql->insert(Mysite::$app->config['tablepre'].'alljuan', $data1);
            }
        }
        $this->success('success');
    }
    /**添加充值送余额时   选择赠送代金券数据**/
    public function addrechargecost()
    {
        $data['juansetinfo'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 3 or name = '充值送代金券' ");
        $data['juaninfo'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."alljuan where type = 3 or name= '充值送代金券' order by id asc ");
        Mysite::$app->setdata($data);
    }
    /**促销活动列表**/
    public function cxrulelist()
    {
        $cityid = Mysite::$app->config['default_cityid'];
        $type = intval(IReq::get('type'));//0全部 1待生效 2进行中 3已结束 4未启用
        $type = in_array($type, array(0, 1, 2, 3, 4)) ? $type : 0;
        $wherearr = array(
       '0'=>' ',
       '1'=>' and limittype = 3  and starttime > '.time().' and status = 1 ',
       '2'=>' and status = 1 and ( limittype < 3  or ( limittype = 3 and endtime > '.time().' and starttime < '.time().')) ',
       '3'=>' and limittype = 3 and endtime < '.time().' and status = 1 ',
       '4'=>' and status =0 '
       );
        $cxrulelist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."rule where  parentid = 1 ".$wherearr[$type]."  and  cityid = ".$cityid." order by id desc ");
        $data['cxrulelist'] = $cxrulelist;
        $data['type'] = $type;
        $data['nowtime'] = time();
        Mysite::$app->setdata($data);
    }
    public function addcxrule()
    {
        $id = intval(IReq::get('id'));
        $cityid = Mysite::$app->config['default_cityid'];
        $cxinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."rule where  id = ".$id."   ");
        $cityid = Mysite::$app->config['default_cityid'];
        $shoplist = array();
        $shoplist = $this->mysql->getarr("select id,shopname,shoptype from ".Mysite::$app->config['tablepre']."shop where is_pass = 1 and admin_id = ".$cityid."   ");
        foreach ($shoplist as $k=>$v) {
            if ($v['shoptype']==1) {
                $psinfo = $this->mysql->select_one("select sendtype from ".Mysite::$app->config['tablepre']."shopmarket where  shopid = ".$v['id']."   ");
                if ($psinfo['sendtype'] == 1) {
                    $shopps[] = $v;
                } else {
                    $platps[] = $v;
                }
            } else {
                $psinfo = $this->mysql->select_one("select sendtype from ".Mysite::$app->config['tablepre']."shopfast where  shopid = ".$v['id']."   ");
                if ($psinfo['sendtype'] == 1) {
                    $shopps[] = $v;
                } else {
                    $platps[] = $v;
                }
            }
        }
        $data['cxsignlist'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodssign where type='cx' order by id desc limit 0, 100");
        $data['cxinfo'] = $cxinfo;
        $data['shopps'] = $shopps;
        $data['platps'] = $platps;
        Mysite::$app->setdata($data);
    }
    public function delcxrule()
    {
        limitalert();
        $id = IReq::get('id');
        if (empty($id)) {
            $this->message('id为空');
        }
        $ids = is_array($id)? join(',', $id):$id;
        $this->mysql->delete(Mysite::$app->config['tablepre'].'rule', "id in($ids)");
        $this->success('success');
    }

    public function savecxrule()
    {
        $shopidarr = IReq::get('shopid');
        if (empty($shopidarr)) {
            $this->message('请选择参与活动商家');
        }
        $data['shopid'] = implode(',', $shopidarr);
        $data['parentid'] = intval(IReq::get('parentid'));
        $data['shopbili'] = intval(IReq::get('shopbili'));
        $data['cityid'] = Mysite::$app->config['default_cityid'];
        $data['type'] = 1;//默认购物车限制
        $cxid = intval(IReq::get('cxid'));
        $controltype = intval(IReq::get('controltype'));//1满赠活动 2满减活动 3折扣活动 4免配送费 5首单立减
        $data['controltype'] = $controltype;
        $setinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."cxruleset where  id = ".$controltype."   ");
        $data['imgurl'] = $setinfo['imgurl'];//活动图标
        $data['supporttype'] = $setinfo['supportorder'];//支持订单类型 1支持全部订单 2只支持在线支付订单
        $data['supportplatform'] = $setinfo['supportplat'];//支持平台类型 1pc 2微信 3触屏 4app
        $data['status'] =  intval(IReq::get('status'));
        $ordertype = $data['supporttype']==2?'在线支付满':'满';
        if ($controltype == 1) {//1满赠活动
            $data['limitcontent'] = intval(IReq::get('limitcontent_1'));
            $data['presenttitle'] = trim(IFilter::act(IReq::get('presenttitle')));
            if (empty($data['limitcontent'])) {
                $this->message('请输入订单限制金额');
            }
            if (empty($data['presenttitle'])) {
                $this->message('请输入赠品名称及数量');
            }
            $data['name']= $ordertype.''.$data['limitcontent'].'赠送'.$data['presenttitle'];
        }
        if ($controltype == 2) {//2满减活动
            $limitcontent = IReq::get('limitcontent_2');
            $controlcontent = IReq::get('controlcontent_2');
            $data['limitcontent'] = implode(',', $limitcontent);
            $data['controlcontent'] = implode(',', $controlcontent);
            $name = $data['supporttype']==2?'在线支付':'';
            foreach ($limitcontent as $k=>$v) {
                $name .= '满'.$v.'减'.$controlcontent[$k].';';
            }
            $data['name'] = rtrim($name, ";");
        }
        if ($controltype == 3) {//3折扣活动
            $data['limitcontent'] = intval(IReq::get('limitcontent_3'));
            $data['controlcontent'] = intval(IReq::get('controlcontent_3'));
            $zhe = $data['controlcontent']/10;
            $data['name']= $ordertype.''.$data['limitcontent'].'享'.$zhe.'折优惠';
            if (empty($data['limitcontent'])) {
                $this->message('请输入订单限制金额');
            }
            if (empty($data['controlcontent'])) {
                $this->message('请输入折扣值');
            }
        }
        if ($controltype == 4) {//4免配送费
            $data['limitcontent'] = intval(IReq::get('limitcontent_4'));
            $data['name']= $ordertype.''.$data['limitcontent'].'免基础配送费';
            if (empty($data['limitcontent'])) {
                $this->message('请输入订单限制金额');
            }
        }
        if ($controltype == 5) {//5首单立减
            $data['limitcontent'] = 0;
            $data['controlcontent'] = intval(IReq::get('controlcontent_5'));
            $data['name']= '新用户下单立减'.$data['controlcontent'].'元';
        }
        if (empty($data['name'])) {
            $this->message('促销标题不能为空');
        }
        $limittype = intval(IReq::get('limittype'));//1不限制 2表示指定星期 3自定义日期
        $data['limittype'] = in_array($limittype, array('1,','2','3')) ? $limittype:1;
        if ($data['limittype'] ==  1) {
            $data['limittime'] = '';
        } elseif ($data['limittype'] == 2) {
            $limittime = IFilter::act(IReq::get('limittime1'));
            if (!is_array($limittime)) {
                $this->message('errweek');
            }
            $data['limittime'] = join(',', $limittime);
        } else {
            $starttime = IFilter::act(IReq::get('starttime'));
            $endtime = IFilter::act(IReq::get('endtime'));
            if (empty($starttime)) {
                $this->message('cx_starttime');
            }
            if (empty($endtime)) {
                $this->message('cx_endtime');
            }
            $data['starttime'] = strtotime($starttime.' 00:00:00');
            $data['endtime'] = strtotime($endtime.' 23:59:59');
            if ($data['endtime'] <= $data['starttime']) {
                $this->message('结束时间不能早于开始时间');
            }
        }
        if (empty($cxid)) {
            $data['creattime'] = time();
            $this->mysql->insert(Mysite::$app->config['tablepre'].'rule', $data);
        } else {
            $this->mysql->update(Mysite::$app->config['tablepre'].'rule', $data, "id='".$cxid."'");
        }

        $this->success('success');
    }


    public function delcard()
    {
        limitalert();
        $id = IReq::get('id');
        if (empty($id)) {
            $this->message('card_empty');
        }
        $ids = is_array($id)? join(',', $id):$id;
        $this->mysql->delete(Mysite::$app->config['tablepre'].'card', "id in($ids)");
        $this->success('success');
    }
    public function saveprensentjuan()
    {
        $siteinfo['regester_juan'] = intval(IReq::get('regester_juan'));
        $siteinfo['regester_juanlimit'] = intval(IReq::get('regester_juanlimit'));
        $siteinfo['regester_juancost'] = intval(IReq::get('regester_juancost'));
        $siteinfo['regester_juanday'] = intval(IReq::get('regester_juanday'));
        $siteinfo['wx_juan'] = intval(IReq::get('wx_juan'));
        $siteinfo['wx_juancost'] = intval(IReq::get('wx_juancost'));
        $siteinfo['wx_juanlimit'] = intval(IReq::get('wx_juanlimit'));
        $siteinfo['wx_juanday'] = intval(IReq::get('wx_juanday'));
        $siteinfo['login_juan'] = intval(IReq::get('login_juan'));
        $siteinfo['login_data'] = strtotime(IReq::get('login_data'));
        $siteinfo['login_juanlimit'] = intval(IReq::get('login_juanlimit'));
        $siteinfo['login_juancost'] = intval(IReq::get('login_juancost'));
        $siteinfo['login_juanday'] = intval(IReq::get('login_juanday'));
        $siteinfo['tui_juan'] = intval(IReq::get('tui_juan'));
        $siteinfo['tui_juanlimit'] = intval(IReq::get('tui_juanlimit'));
        $siteinfo['tui_juancost'] = intval(IReq::get('tui_juancost'));
        $siteinfo['tui_juanday'] = intval(IReq::get('tui_juanday'));
        $config = new config('hopeconfig.php', hopedir);
        $config->write($siteinfo);
        $this->success('success');
    }
    public function cardlist()
    {
        $searchvalue = intval(IReq::get('searchvalue'));
        $orderstatus = intval(IReq::get('orderstatus'));
        $starttime = trim(IReq::get('starttime'));
        $endtime = trim(IReq::get('endtime'));
        $newlink = '';
        $where= '';
        $data['searchvalue'] = '';
        if ($searchvalue > 0) {//限制值
            $data['searchvalue'] = $searchvalue;
            $where .= ' and  cost = \''.$searchvalue.'\' ';
            $newlink .= '/searchvalue/'.$searchvalue;
        }

        $data['starttime'] = '';
        if (!empty($starttime)) {
            $data['starttime'] = $starttime;
            $where .= ' and  creattime > '.strtotime($starttime.' 00:00:01').' ';
            $newlink .= '/starttime/'.$starttime;
        }
        $data['endtime'] = '';
        if (!empty($endtime)) {
            $data['endtime'] = $endtime;
            $where .= ' and  creattime < '.strtotime($endtime.' 23:59:59').' ';
            $newlink .= '/endtime/'.$endtime;
        }
        $data['where'] = " id > 0 ".$where;
        #	print_r($data['where']);

        $pageinfo = new page();
        $pageinfo->setpage(intval(IReq::get('page')), 10);

        $cardlist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."card where   ".$data['where']."   order by id desc    limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."  ");

        $shuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."card where   ".$data['where']."   order by id desc");
        $pageinfo->setnum($shuliang);
        $pagelink = IUrl::creatUrl('adminpage/card/module/cardlist'.$newlink);
        $data['pagecontent'] = $pageinfo->getpagebar($pagelink);

        $data['cardlist'] = $cardlist;

        $link = IUrl::creatUrl('adminpage/card/module/cardlist'.$newlink);
        $data['outlink'] =IUrl::creatUrl('adminpage/card/module/outcard/outtype/query'.$newlink);
        Mysite::$app->setdata($data);
    }
    public function carduserecord()
    {
        $username = IReq::get('username');
        $starttime = trim(IReq::get('starttime'));
        $endtime = trim(IReq::get('endtime'));
        $newlink = '';
        $where= '';
        $data['username'] = '';
        if (!empty($username)) {
            $data['username'] = $username;
            $where .= ' and  username = \''.$username.'\' ';
            $newlink .= '/username/'.$username;
        }
        $data['starttime'] = '';
        if (!empty($starttime)) {
            $data['starttime'] = $starttime;
            $where .= ' and  usetime > '.strtotime($starttime.' 00:00:01').' ';
            $newlink .= '/starttime/'.$starttime;
        }
        $data['endtime'] = '';
        if (!empty($endtime)) {
            $data['endtime'] = $endtime;
            $where .= ' and  usetime < '.strtotime($endtime.' 23:59:59').' ';
            $newlink .= '/endtime/'.$endtime;
        }
        $data['where'] = " id > 0 ".$where;
        $pageinfo = new page();
        $pageinfo->setpage(intval(IReq::get('page')), 10);
        $cardlist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."card where   ".$data['where']." and status = 1   order by id desc    limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."  ");
        $shuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."card where   ".$data['where']." and status = 1  order by id desc");
        $pageinfo->setnum($shuliang);
        $pagelink = IUrl::creatUrl('adminpage/card/module/carduserecord'.$newlink);
        $data['pagecontent'] = $pageinfo->getpagebar($pagelink);
        $data['cardlist'] = $cardlist;
        Mysite::$app->setdata($data);
    }
    public function savecard()
    {
        limitalert();
        $card_temp = trim(IReq::get('card_temp'));
        $card_acount = intval(IReq::get('card_acount'));
        $card_cost = intval(IReq::get('card_cost'));
        if (empty($card_temp)) {
            $this->message('card_emptypre');
        }
        if ($card_acount < 1) {
            $this->message('card_emptycout');
        }
        if (!in_array($card_cost, array(10,20,50,100,200,500,1000))) {
            $this->message('card_costerr');
        }
        $timenow = time();
        for ($i=0;$i< $card_acount;$i++) {
            $data['card'] = $card_temp.$timenow.$i.rand(1000, 9999);
            $data['card_password'] = substr(md5($data['card']), 0, 11);
            $data['status'] = 0;
            $data['cost'] = $card_cost;
            $data['creattime'] = $timenow;
            $this->mysql->insert(Mysite::$app->config['tablepre'].'card', $data);
        }
        $this->success('success');
    }
    public function outcard()
    {
        $outtype = IReq::get('outtype');
        if (!in_array($outtype, array('query','ids'))) {
            header("Content-Type: text/html; charset=UTF-8");
            echo '查询条件错误';
            exit;
        }
        $where = '';
        if ($outtype == 'ids') {
            $id = trim(IReq::get('id'));
            if (empty($id)) {
                header("Content-Type: text/html; charset=UTF-8");
                echo '查询条件不能为空';
                exit;
            }
            $doid = explode('-', $id);
            $id = join(',', $doid);
            $where .= ' and id in('.$id.') ';
        } else {
            $searchvalue = intval(IReq::get('searchvalue'));
            $where .= $searchvalue > 0? ' and  cost = \''.$searchvalue.'\' ':'';

            $orderstatus = intval(IReq::get('orderstatus'));
            $where .= $orderstatus > 0?' and  status = \''.($orderstatus-1).'\' ':'';

            $starttime = trim(IReq::get('starttime'));
            $where .= !empty($starttime)? ' and  creattime > '.strtotime($starttime.' 00:00:01').' ':'';

            $endtime = trim(IReq::get('endtime'));
            $where .= !empty($endtime)? ' and  creattime < '.strtotime($endtime.' 23:59:59').' ':'';
        }

        $outexcel = new phptoexcel();
        $titledata = array('卡号','密码','充值金额');
        $titlelabel = array('card','card_password','cost');
        $datalist = $this->mysql->getarr("select card,card_password,cost from ".Mysite::$app->config['tablepre']."card where id > 0 ".$where."   order by id desc  limit 0,2000 ");
        $outexcel->out($titledata, $titlelabel, $datalist, '', '充指卡导出结果');
    }
    public function juanlist()
    {
        $searchvalue = intval(IReq::get('searchvalue'));

        $orderstatus = intval(IReq::get('orderstatus'));
        #	print_r($orderstatus);

        $starttime = trim(IReq::get('starttime'));
        $endtime = trim(IReq::get('endtime'));

        $newlink = '';
        $where= '';
        $data['searchvalue'] = '';
        if ($searchvalue > 0) {//限制值
            $data['searchvalue'] = $searchvalue;
            $where .= ' and  limitcost = \''.$searchvalue.'\' ';
            $newlink .= '/searchvalue/'.$searchvalue;
        }
        $data['orderstatus'] = '';
        if ($orderstatus > 0) {
            $chastatus = $orderstatus-1 ;
            $data['orderstatus'] = $orderstatus;
            $where .= ' and  status = \''.$chastatus.'\' ';
            $newlink .= '/orderstatus/'.$orderstatus;
        }
        $data['starttime'] = '';
        if (!empty($starttime)) {
            $data['starttime'] = $starttime;
            $where .= ' and  creattime > '.strtotime($starttime.' 00:00:01').' ';
            $newlink .= '/starttime/'.$starttime;
        }
        $data['endtime'] = '';
        if (!empty($endtime)) {
            $data['endtime'] = $endtime;
            $where .= ' and  creattime < '.strtotime($endtime.' 23:59:59').' ';
            $newlink .= '/endtime/'.$endtime;
        }

        $where = ' where id > 0 '.$where;

        $link = IUrl::creatUrl('adminpage/card/module/juanlist'.$newlink);
        $pageshow = new page();
        $pageshow->setpage(IReq::get('page'));
        $juanlist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."juan ".$where." order by id desc limit ".$pageshow->startnum().", ".$pageshow->getsize()."");
        $juanshuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."juan ".$where." ");
        $pageshow->setnum($juanshuliang);
        $data['pagecontent'] = $pageshow->getpagebar($link);
        $data['juanlist']=$juanlist;
        $data['outlink'] =IUrl::creatUrl('adminpage/card/module/outjuan/outtype/query'.$newlink);
        $data['nowtime'] = time();
        $data['statustype'] = array(
                  '1'=>'已绑定',
                  '2'=>'已使用',
                  '3'=>'无效'
                  );
        Mysite::$app->setdata($data);
    }
    public function addregjuan()
    {
        $id = intval(IReq::get('id'));
        $regjuan = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."regsendjuan where id  =  ".$id."    ");
        $data['regjuan'] = $regjuan;
        Mysite::$app->setdata($data);
    }
    public function delregsendcard()
    {
        $id = IReq::get('id');
        if (empty($id)) {
            $this->message('card_emptyjuan');
        }
        $ids = is_array($id)? join(',', $id):$id;
        $this->mysql->delete(Mysite::$app->config['tablepre'].'regsendjuan', "id in($ids)");
        $this->success('success');
    }
    public function saveregsendjuan()
    {
        $id = intval(IReq::get('id'));
        if (!empty($id)) {
            $checkregjuan = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."regsendjuan where id  =  ".$id."    ");
            if (empty($checkregjuan)) {
                $this->message('获取注册代金券失败');
            }
        }
        $name = trim(IReq::get('name'));
        $limitcost = trim(IReq::get('limitcost'));
        $jiancost = trim(IReq::get('jiancost'));
        $starttime = strtotime(IReq::get('starttime'));
        $endtime =   strtotime(IReq::get('endtime'));
        $is_open = intval(IReq::get('is_open'));

        if (empty($name)) {
            $this->message('请填写代金券名称');
        }
        if (empty($limitcost)) {
            $this->message('请填写最低消费使用金额');
        }
        if (empty($jiancost)) {
            $this->message('请填写优惠金额');
        }
        if (empty($starttime)) {
            $this->message('请填写开始时间');
        }
        if (empty($endtime)) {
            $this->message('请填写结束时间');
        }
        if ($starttime > $endtime) {
            $this->message('时间填写不规范，请重新选择');
        }

        $data['name'] = $name;
        $data['limitcost'] = $limitcost;
        $data['jiancost'] = $jiancost;
        $data['starttime'] = $starttime;
        $data['endtime'] = $endtime;
        $data['is_open'] = $is_open;

        if (empty($id)) {
            $this->mysql->insert(Mysite::$app->config['tablepre'].'regsendjuan', $data);
        } else {
            $this->mysql->update(Mysite::$app->config['tablepre'].'regsendjuan', $data, "id='".$id."'");
        }
        $this->success('success');
    }

    public function savejuan()
    {
        $paytype = IReq::get('paytype');
        $paytype = implode(',', $paytype);
        if (empty($paytype)) {
            $this->message('请选择代金券支持的支付方式');
        }
        $card_temp = trim(IReq::get('card_temp')); //卡前缀
        $card_acount = intval(IReq::get('card_acount')); //卡数量
        $card_cost = intval(IReq::get('card_cost')); //优惠金额
        $limit_cost = intval(IReq::get('limit_cost')); //限制金额
        $card_time = intval(IReq::get('card_time'));//有效时间
        $name = trim(IReq::get('name'));

        if (empty($name)) {
            $this->message('card_emptyjuanname');
        }
        if (empty($card_temp)) {
            $this->message('card_emptyjuanpre');
        }
        if ($card_acount < 1) {
            $this->message('card_emptyjuancount');
        }
        if ($card_cost < 1) {
            $this->message('card_emptyjuancost');
        }
        if ($limit_cost < 1) {
            $this->message('card_emptyjuanlimitcost');
        }
        if ($card_time < 1) {
            $this->message('card_emptyjuanactimetime');
        }
        if ($card_acount > 100) {
            $this->message('card_emptyjuanlimitcount');
        }
        $timenow = time();
        for ($i=0;$i< $card_acount;$i++) {
            $data['card'] = $card_temp.$timenow.$i.rand(10, 99);
            $data['card_password'] = substr(md5($data['card']), 0, 5);
            $data['status'] = 0;
            $data['creattime'] = $timenow;
            $data['cost'] = $card_cost;
            $data['paytype'] = $paytype;
            $data['limitcost'] = $limit_cost;
            $data['endtime'] = $timenow+$card_time*24*60*60;
            $data['name'] = $name;
            //uid ,  usetime username
            $this->mysql->insert(Mysite::$app->config['tablepre'].'juan', $data);
        }
        $this->success('success');
    }
    public function deljuan()
    {
        // limitalert();
        $id = IReq::get('id');
        if (empty($id)) {
            $this->message('card_emptyjuan');
        }
        $ids = is_array($id)? join(',', $id):$id;
        $this->mysql->delete(Mysite::$app->config['tablepre'].'juan', "id in($ids)");
        $this->success('success');
    }
    public function outjuan()
    {
        $this->checkadminlogin();
        $outtype = IReq::get('outtype');

        if (!in_array($outtype, array('query','ids'))) {
            header("Content-Type: text/html; charset=UTF-8");
            echo '查询条件错误';
            exit;
        }
        $where = '';
        if ($outtype == 'ids') {
            $id = trim(IReq::get('id'));
            if (empty($id)) {
                header("Content-Type: text/html; charset=UTF-8");
                echo '查询条件不能为空';
                exit;
            }
            $doid = explode('-', $id);
            $id = join(',', $doid);
            $where .= ' and id in('.$id.') ';
        } else {
            $searchvalue = intval(IReq::get('searchvalue'));
            $where .= $searchvalue > 0? ' and  limitcost = \''.$searchvalue.'\' ':'';

            $orderstatus = intval(IReq::get('orderstatus'));
            $where .= $orderstatus > 0?' and  status = \''.($orderstatus-1).'\' ':'';

            $starttime = trim(IReq::get('starttime'));
            $where .= !empty($starttime)? ' and  creattime > '.strtotime($starttime.' 00:00:01').' ':'';

            $endtime = trim(IReq::get('endtime'));
            $where .= !empty($endtime)? ' and  creattime > '.strtotime($endtime.' 23:59:59').' ':'';
        }

        $outexcel = new phptoexcel();
        $titledata = array('卡号','密码','购物车限制金额','优惠金');
        $titlelabel = array('card','card_password','limitcost','cost');
        $datalist = $this->mysql->getarr("select card,card_password,limitcost,cost from ".Mysite::$app->config['tablepre']."juan where id > 0 ".$where."   order by id desc  limit 0,2000 ");
        $outexcel->out($titledata, $titlelabel, $datalist, '', '消费卷导出结果');
    }
    public function savescore()
    {
        $siteinfo['commentscore'] = intval(IReq::get('commentscore'));
        $siteinfo['loginscore'] = intval(IReq::get('loginscore'));
        $siteinfo['regesterscore'] = intval(IReq::get('regesterscore'));
        $siteinfo['commenttype'] =intval(IReq::get('commenttype'));
        $siteinfo['maxdayscore'] =intval(IReq::get('maxdayscore'));
        $siteinfo['commentday'] = intval(IReq::get('commentday'));
        $siteinfo['consumption']=intval(IReq::get('consumption'));
        $siteinfo['con_extend']=intval(IReq::get('con_extend'));
        $config = new config('hopeconfig.php', hopedir);
        $config->write($siteinfo);
        $this->success('success');
    }
    public function savescoredx()
    {
        $siteinfo['scoretocost'] = intval(IReq::get('scoretocost'));
        $siteinfo['isopenscoretocost'] = intval(IReq::get('isopenscoretocost'));
        $siteinfo['scoretocostmax'] = intval(IReq::get('scoretocostmax'));
        $config = new config('hopeconfig.php', hopedir);
        $config->write($siteinfo);
        $this->success('success');
    }
    /*礼品兑换模块*/
    public function savegifttype()
    {
        $id = intval(IReq::get('uid'));
        $data['name'] = IReq::get('name');
        $data['orderid']  = intval(IReq::get('orderid'));
        if (empty($data['name'])) {
            $this->message('gift_emptytypename');
        }
        if (empty($id)) {
            $this->mysql->insert(Mysite::$app->config['tablepre'].'gifttype', $data);
        } else {
            $this->mysql->update(Mysite::$app->config['tablepre'].'gifttype', $data, "id='".$id."'");
        }
        $this->success('success');
    }
    public function delgifttype()
    {
        $id = IReq::get('id');
        if (empty($id)) {
            $this->message('gift_emptytype');
        }
        $ids = is_array($id)? join(',', $id):$id;
        $this->mysql->delete(Mysite::$app->config['tablepre'].'gifttype', "id in($ids)");
        $this->success('success');
    }
    public function savegift()
    {
        $id = IReq::get('uid');
        $data['title'] = IReq::get('title');
        $data['content'] = IReq::get('content');
        $data['market_cost'] = intval(IReq::get('market_cost'));
        $data['score'] = intval(IReq::get('score'));
        $data['stock'] = intval(IReq::get('stock'));
        $data['img'] = IReq::get('img');
        $data['sell_count'] = intval(IReq::get('sell_count'));
        if (empty($id)) {
            $link = IUrl::creatUrl('adminpage/card/module/addgift');
            if (empty($data['content'])) {
                $this->message('gift_emptycontent', $link);
            }
            if (empty($data['title'])) {
                $this->message('gift_emptytitle', $link);
            }
            if (empty($data['score'])) {
                $this->message('gift_emptyscore', $link);
            }
            $this->mysql->insert(Mysite::$app->config['tablepre'].'gift', $data);
        } else {
            $link = IUrl::creatUrl('adminpage/card/module/addgift/id/'.$id);
            if (empty($data['content'])) {
                $this->message('gift_emptycontent', $link);
            }
            if (empty($data['title'])) {
                $this->message('gift_emptytitle', $link);
            }
            if (empty($data['score'])) {
                $this->message('gift_emptyscore', $link);
            }
            $this->mysql->update(Mysite::$app->config['tablepre'].'gift', $data, "id='".$id."'");
        }
        $link = IUrl::creatUrl('adminpage/card/module/giftlist');
        $this->message('success', $link);
    }
    public function delgift()
    {
        $id = IReq::get('id');
        if (empty($id)) {
            $this->message('gift_empty');
        }
        $ids = is_array($id)? join(',', $id):$id;
        $this->mysql->delete(Mysite::$app->config['tablepre'].'gift', "id in($ids)");
        $this->success('success');
    }
    public function logstat()
    {
        $data['logstat'] = array('0'=>'待处理','1'=>'已处理，配送中','2'=>'兑换完成','3'=>'兑换成功','4'=>'已取消兑换');
        Mysite::$app->setdata($data);
    }
    public function giftlog()
    {
        $orderstatus = intval(IReq::get('orderstatus'));
        $starttime = trim(IReq::get('starttime'));
        $endtime = trim(IReq::get('endtime'));
        $newlink = '';
        $where= '';
        $data['orderstatus'] = '';
        if ($orderstatus > 0) {
            $chastatus = $orderstatus -1;
            $data['orderstatus'] = $orderstatus;
            $where .= ' and  gg.status = \''.$chastatus.'\' ';
            $newlink .= '/orderstatus/'.$orderstatus;
        }
        $data['starttime'] ='';
        if (!empty($starttime)) {
            $data['starttime'] = $starttime;
            $where .= ' and  gg.addtime > '.strtotime($starttime.' 00:00:01').' ';
            $newlink .= '/starttime/'.$starttime;
        }
        $data['endtime'] = '';
        if (!empty($endtime)) {
            $data['endtime'] = $endtime;
            $where .= ' and  gg.addtime < '.strtotime($endtime.' 23:59:59').' ';
            $newlink .= '/endtime/'.$endtime;
        }

        $link = IUrl::creatUrl('adminpage/card/module/giftlog'.$newlink);
        $data['outlink'] =IUrl::creatUrl('adminpage/card/module/outgiftlog/outtype/query'.$newlink);

        $this->pageCls->setpage(IReq::get('page'));
        $data['list'] = $this->mysql->getarr("select gg.*,gf.title,mb.username from ".Mysite::$app->config['tablepre']."giftlog as gg left join ".Mysite::$app->config['tablepre']."gift as gf on gf.id = gg.giftid  left join ".Mysite::$app->config['tablepre']."member as mb on mb.uid=gg.uid where  gg.id > 0  ".$where." order by gg.id desc  limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."");
        $shuliang  = $this->mysql->counts("select gg.* from ".Mysite::$app->config['tablepre']."giftlog as gg where  gg.id > 0 ".$where." ");
        $this->pageCls->setnum($shuliang);
        $data['pagecontent'] = $this->pageCls->getpagebar($link);

        Mysite::$app->setdata($data);
    }
    public function delgiftlog()
    {
        $id = IReq::get('id');
        if (empty($id)) {
            $this->message('gift_emptygiftlog');
        }
        $ids = is_array($id)? join(',', $id):$id;
        $this->mysql->delete(Mysite::$app->config['tablepre'].'giftlog', " id in($ids) ");
        $this->success('success');
    }
    public function outgiftlog()
    {
        $outtype = IReq::get('outtype');

        if (!in_array($outtype, array('query','ids'))) {
            header("Content-Type: text/html; charset=UTF-8");
            echo '查询条件错误';
            exit;
        }
        $where = '';
        if ($outtype == 'ids') {
            $id = trim(IReq::get('id'));
            if (empty($id)) {
                header("Content-Type: text/html; charset=UTF-8");
                echo '查询条件不能为空';
                exit;
            }
            $doid = explode('-', $id);
            $id = join(',', $doid);
            $where .= ' and gg.id in('.$id.') ';
        } else {
            $orderstatus = intval(IReq::get('orderstatus'));
            $where .= $orderstatus > 0?' and   gg.status = \''.($orderstatus-1).'\' ':'';

            $starttime = trim(IReq::get('starttime'));
            $where .= !empty($starttime)? ' and   gg.addtime > '.strtotime($starttime.' 00:00:01').' ':'';

            $endtime = trim(IReq::get('endtime'));
            $where .= !empty($endtime)? ' and   gg.addtime > '.strtotime($endtime.' 23:59:59').' ':'';
        }

        $outexcel = new phptoexcel();
        $titledata = array('礼品名称','用户名','用户地址','联系电话','联系人');
        $titlelabel = array('title','username','address','telphone','contactman');

        $datalist = $this->mysql->getarr("select gf.title,mb.username,gg.address,gg.telphone,gg.contactman from ".Mysite::$app->config['tablepre']."giftlog as gg left join ".Mysite::$app->config['tablepre']."gift as gf on gf.id = gg.giftid  left join ".Mysite::$app->config['tablepre']."member as mb on mb.uid=gg.uid where  gg.id > 0  ".$where." order by gg.id desc  limit 0,2000");

        $outexcel->out($titledata, $titlelabel, $datalist, '', '积分兑换导出结果');
    }
    public function exgift()
    {
        $id = intval(IReq::get('id'));
        $type = IReq::get('type');//un取消  pass审核  unpass 取消审核  send发货 over完成
        if (empty($id)) {
            $this->message('gift_empty');
        }
        $checkinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."giftlog where id=".$id."  ");
        if (empty($checkinfo)) {
            $this->message('gift_emptygiftlog');
        }
        $giftinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."gift where id=".$checkinfo['giftid']."  ");
        if (empty($giftinfo)) {
            $this->message('gift_empty');
        }
        $memberinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid=".$checkinfo['uid']."  ");
        switch ($type) {
          case 'un':
                //取消 积分兑换
                if ($checkinfo['status'] != 0) {
                    $this->message('gift_cantlogun');
                }
                //更新兑换记录
                $data['status'] =4;
                $this->mysql->update(Mysite::$app->config['tablepre'].'giftlog', $data, "id='".$id."'");
                //更新用户积分 并写消息
                if (!empty($memberinfo)) {
                    $ndata['score'] = $memberinfo['score'] + $checkinfo['score'];
                    $this->mysql->update(Mysite::$app->config['tablepre'].'member', '`score` = `score`+'.$checkinfo['score'], "uid='".$memberinfo['uid']."'");
                    $this->memberCls->addlog($memberinfo['uid'], 1, 1, $checkinfo['score'], '取消兑换礼品', '管理员取消兑换ID为:'.$giftinfo['id'].'的礼品['.$giftinfo['title'].'],帐号积分'.$ndata['score'], $ndata['score']);
                }
                //还库存
                $gdata['sell_count'] = $giftinfo['sell_count'] -$checkinfo['count'];
                $gdata['stock'] = $giftinfo['stock'] +$checkinfo['count'];
                $this->mysql->update(Mysite::$app->config['tablepre'].'gift', $gdata, "id='".$giftinfo['id']."'");
          break;
          case 'pass':
                 if ($checkinfo['status'] != 0) {
                     $this->message('gift_cantlogpass');
                 }
                $data['status'] =1;
                $this->mysql->update(Mysite::$app->config['tablepre'].'giftlog', $data, "id='".$id."'");
          break;
          case 'unpass':
                 if ($checkinfo['status'] != 1) {
                     $this->message('gift_cantlogunpass');
                 }
                $data['status'] =0;
                $this->mysql->update(Mysite::$app->config['tablepre'].'giftlog', $data, "id='".$id."'");
          break;
          case 'send':
               if ($checkinfo['status'] != 1) {
                   $this->message('gift_cantlogsend');
               }
                $data['status'] =2;
                $this->mysql->update(Mysite::$app->config['tablepre'].'giftlog', $data, "id='".$id."'");
          break;
          case 'over':
               if ($checkinfo['status'] != 2) {
                   $this->message('gift_cantlogover');
               }
                $data['status'] =3;
                $this->mysql->update(Mysite::$app->config['tablepre'].'giftlog', $data, "id='".$id."'");
          break;
          default:
           $this->message('nodefined_func');
          break;
        }

        $this->success('success');
    }

    public function savesendtask()
    {
        $data['taskname'] = IReq::get('taskname');
        $data['tasktype'] = IReq::get('tasktype');
        $data['tasktype'] = empty($data['tasktype'])?1:$data['tasktype'];
        $data['taskusertype'] = IReq::get('taskusertype');
        $data['taskusertype'] = empty($data['taskusertype'])?1:$data['taskusertype'];
        $data['usertype'] = IReq::get('usertype');
        $data['userscore'] = IReq::get('userscore');
        $data['creattime_starttime'] = IReq::get('creattime_starttime');
        $data['creattime_endtime'] = IReq::get('creattime_endtime');
        $data['logintime_starttime'] = IReq::get('logintime_starttime');
        $data['logintime_endtime'] = IReq::get('logintime_endtime');
        $data['objcontent'] = IReq::get('objcontent');
        $data['content']  = IReq::get('content');
        $link = IUrl::creatUrl('adminpage/card/module/sendtask');

        if (empty($data['taskname'])) {
            $this->message('task_emptytitle', $link);
        }
        if (empty($data['content'])) {
            $this->message('task_emptycontent', $link);
        }
        $miaoshu = $data['tasktype']==1?'群发邮件':'群发短信';
        if ($data['taskusertype'] ==1) {
            $where = '';
            $miaoshu .= '根据条件：';
            if ($data['usertype'] > 0) {
                if ($data['usertype'] == 1) {
                    $where .= " and usertype  = \'0\' ";
                } else {
                    $where .= " and usertype  = \'1\' ";
                }
                $miaoshu .= $data['usertype'] == 1?'普通会员':'商家会员';
            }
            if ($data['userscore'] > 0) {
                $where .= " and score   > ".$data['userscore']." ";
                $miaoshu .=  '积分大于'.$data['userscore'];
            }
            if (!empty($data['creattime_starttime'])) {
                $limittime = strtotime($data['creattime_starttime'].' 00:00:00');
                $where .= " and creattime   > ".$limittime." ";
                $miaoshu .=  '注册时间大于'.$data['creattime_starttime'];
            }
            if (!empty($data['logintime_starttime'])) {
                $limittime = strtotime($data['creattime_endtime'].' 00:00:00');
                $where .= " and creattime   < ".$limittime." ";
                $miaoshu .=  '注册时间小于'.$data['creattime_endtime'];
            }
            if (!empty($data['logintime_starttime'])) {
                $limittime = strtotime($data['logintime_starttime'].' 00:00:00');
                $where .= " and logintime   > ".$limittime." ";
                $miaoshu .=  '最近登陆时间大于'.$data['logintime_starttime'];
            }
            if (!empty($data['logintime_endtime'])) {
                $limittime = strtotime($data['logintime_endtime'].' 00:00:00');
                $where .= " and logintime   < ".$limittime." ";
                $miaoshu .=  '最近登陆时间小于'.$data['logintime_endtime'];
            }
            $data['tasklimit'] = $where;
            $data['othercontent'] = $miaoshu;
        } else {
            if (empty($data['objcontent'])) {
                $this->message('task_emptyobj', $link);
            }
            $data['tasklimit'] = $data['objcontent'];
            $data['othercontent'] = $miaoshu.'指定对象:'.$data['objcontent'];
        }
        unset($data['usertype']);
        unset($data['userscore']);
        unset($data['creattime_starttime']);
        unset($data['creattime_endtime']);
        unset($data['logintime_starttime']);
        unset($data['logintime_endtime']);
        unset($data['objcontent']);
        $this->mysql->insert(Mysite::$app->config['tablepre'].'task', $data);
        $link = IUrl::creatUrl('adminpage/card/module/sendtasklist');
        $this->message('', $link);
    }
    public function starttask()
    {
        $taskid = IReq::get('taskid');
        $taskinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."task where id='".$taskid."'  ");
        if (empty($taskinfo)) {
            echo '任务不存在';
            exit;
        }
        if ($taskinfo['status'] > 1) {
            echo '任务执行完毕,请关闭窗口';
            exit;
        }
        $data = array('taskmiaoshu'=>'');
        //执行任务
        if ($taskinfo['tasktype'] == 1) {
            $emailids = '';//邮箱ID集
        $newdata = array();//任务处理数据
        $data['taskmiaoshu'] .= '邮件群发任务';
            if ($taskinfo['taskusertype'] == 1) {
                //	echo '根据用户表筛选查询'.$taskinfo['tasklimit'];//tasklimit
            //构造默认查询
            $where = ' where uid > '.$taskinfo['start_id'].'  '.$taskinfo['tasklimit']; //start_id;//起点UID

            $memberlist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."member ".$where." order by uid asc  limit 0, 10");
                $startid =  $taskinfo['start_id'];
                if (count($memberlist) > 9) {
                    foreach ($memberlist as $key=>$value) {//循环取出邮件集
                        if (IValidate::email($value['email'])) {
                            $emailids .= empty($emailids)?	$value['email']:','.$value['email'];
                        }
                        $startid = $value['uid'];
                    }
                }
                if (count($memberlist) < 10) {
                    //更新任务执行完毕
                    $newdata['status'] = 2;
                    $data['taskmiaoshu'] .= ',执行完毕';
                } else {
                    //
                    $newdata['status'] = 1;
                    $newdata['start_id'] = $startid;//更新下一页
                    $data['taskmiaoshu'] .= ',从用户表uid为'.$taskinfo['start_id'].'执行到uid为'.$startid;
                }
                //更新任务
            } else {
                $tasklimit = $taskinfo['tasklimit'];
                $checklist = explode(',', $tasklimit);
                foreach ($checklist as $key=>$value) {
                    if (IValidate::email($value)) {
                        $emailids .= empty($emailids)? $value:','.$value;
                    }
                }
                $newdata['status'] = 2;
                //更新任务
                $data['taskmiaoshu'] .= ',根据指定邮箱地址发送邮件完成';
            }
            //更新任务
            $this->mysql->update(Mysite::$app->config['tablepre'].'task', $newdata, "id='".$taskid."'");
            if (!empty($emailids)) {
                $smtp = new ISmtp(Mysite::$app->config['smpt'], 25, Mysite::$app->config['emailname'], Mysite::$app->config['emailpwd'], false);
                //$content = iconv('utf-8','gb2312',$content);
                $info = $smtp->send($emailids, Mysite::$app->config['emailname'], $taskinfo['taskname'], $taskinfo['content'], "", "HTML", "", "");
            }
            $data['taskdata'] = $newdata;
            $data['showcontent'] = $emailids;
        } else {
            $emailids = '';//邮箱ID集
        $newdata = array();//任务处理数据
        $data['taskmiaoshu'] .= '短信群发任务';
            if ($taskinfo['taskusertype'] == 1) {
                //	echo '根据用户表筛选查询'.$taskinfo['tasklimit'];//tasklimit
            //构造默认查询
            $where = ' where uid > '.$taskinfo['start_id'].'  '.$taskinfo['tasklimit']; //start_id;//起点UID

            $memberlist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."member ".$where." order by uid asc  limit 0, 10");
                $startid =  $taskinfo['start_id'];
                if (count($memberlist) > 9) {
                    foreach ($memberlist as $key=>$value) {//循环取出邮件集
                        if (IValidate::suremobi($value['phone'])) {
                            $emailids .= empty($emailids)?	$value['phone']:','.$value['phone'];
                        }
                        $startid = $value['uid'];
                    }
                }
                if (count($memberlist) < 10) {
                    //更新任务执行完毕
                    $newdata['status'] = 2;
                    $data['taskmiaoshu'] .= ',执行完毕';
                } else {
                    //
                    $newdata['status'] = 1;
                    $newdata['start_id'] = $startid;//更新下一页
                    $data['taskmiaoshu'] .= ',从用户表uid为'.$taskinfo['start_id'].'执行到uid为'.$startid;
                }
                //更新任务
            } else {
                $tasklimit = $taskinfo['tasklimit'];
                $checklist = explode(',', $tasklimit);
                foreach ($checklist as $key=>$value) {
                    if (IValidate::suremobi($value)) {
                        $emailids .= empty($emailids)? $value:','.$value;
                    }
                }
                $newdata['status'] = 2;
                //更新任务
                $data['taskmiaoshu'] .= ',根据指定手机号发送短信完成';
            }
            //更新任务
            $data['showcontent'] = $emailids;
            if (!empty($emailids)) {
                $data['taskmiaoshu'] .= ',不支持群发,错误代码:'.$chekcinfo;
            }

            $data['taskdata'] = $newdata;
        }
        Mysite::$app->setdata($data);
    }
    public function deltask()
    {
        limitalert();
        $id = IReq::get('id');
        if (empty($id)) {
            $this->message('task_empty');
        }
        $ids = is_array($id)? join(',', $id):$id;
        $this->mysql->delete(Mysite::$app->config['tablepre'].'task', " id in($ids) ");
        $this->success('success');//(array('error'=>false));
    }


    /* 8.3新增  2016-05-29  zem	 */

    public function juanmarketing()
    {
        $name = IReq::get('name');
        $type = intval(IReq::get('type'));
        $starttime = trim(IReq::get('starttime'));
        $endtime = trim(IReq::get('endtime'));
        $newlink = '';
        $where= '';
        $data['name'] = '';
        if (!empty($name)) {//限制值
            $data['name'] = $name;
            $where .= " and name like '%".$name."%'";
            $newlink .= '/name/'.$name;
        }

        $data['type'] = '';
        if (!empty($type)) {//限制值
            $data['type'] = $type;
            $where .= " and type =  ".$type." ";
            $newlink .= '/type/'.$type;
        }



        $data['starttime'] = '';
        if (!empty($starttime)) {
            $data['starttime'] = $starttime;
            $where .= ' and  addtime > '.strtotime($starttime.' 00:00:01').' ';
            $newlink .= '/addtime/'.$starttime;
        }
        $data['endtime'] = '';
        if (!empty($endtime)) {
            $data['endtime'] = $endtime;
            $where .= ' and  endtime < '.strtotime($endtime.' 23:59:59').' ';
            $newlink .= '/endtime/'.$endtime;
        }
        $data['where'] = " id > 0 ".$where;



        $pageinfo = new page();
        $pageinfo->setpage(intval(IReq::get('page')), 10);

        $marketinglist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."juanrule where   ".$data['where']."   order by orderid asc    limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."  ");
        #print_r($marketinglist);
        $shuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."juanrule where   ".$data['where']."   order by orderid asc");
        $pageinfo->setnum($shuliang);
        $pagelink = IUrl::creatUrl('adminpage/card/module/juanmarketing'.$newlink);
        $data['pagecontent'] = $pageinfo->getpagebar($pagelink);

        $data['marketinglist'] = $marketinglist;



        $data['juantypename'] = array(
            '1'=>'充值',
            '2'=>'下单成功分享',
            '3'=>'推广',
            '4'=>'首次关注微信领取',
        );


        Mysite::$app->setdata($data);
    }


    public function savemarketing()
    {
        limitalert();
        $id = intval(IReq::get('id'));
        $data['id'] = $id;
        $name = trim(IReq::get('name'));
        $type = intval(IReq::get('type'));
        $juantotalcost = intval(IReq::get('juantotalcost'));
        $juannum = intval(IReq::get('juannum'));
        $jiancostmin = intval(IReq::get('jiancostmin'));
        $jiancostmax = intval(IReq::get('jiancostmax'));
        $jiacostmin = intval(IReq::get('jiacostmin'));
        $jiacostmax = intval(IReq::get('jiacostmax'));
        $paytype = IReq::get('paytype');
        $daynum = intval(IReq::get('daynum'));
        $is_open = intval(IReq::get('is_open'));
        $orderid = intval(IReq::get('orderid'));


        if (empty($name)) {
            $this->message('请填写名称！');
        }
        if ($type <= 0) {
            $this->message('请选择代金券类型');
        }
        if (!in_array($type, array(1,2,3,4))) {
            $this->message('获取代金券类型失败');
        }
        if ($type != 1) {
            if (empty($juannum)) {
                $this->message('代金券数量为空');
            }
        }
        if ($jiancostmax > 0) {
            if ($jiancostmin > $jiancostmax) {
                $this->message('请正确填写代金券限制金额范围');
            }
        }
        if ($jiacostmin > $jiacostmax) {
            $this->message('请正确填写代金券优惠金额范围');
        }

        $tempvalue = '';
        if (is_array($paytype)) {
            $tempvalue = join(',', $paytype);
        }

        if (empty($tempvalue)) {
            $this->message('请选择代金券支持的支付方式');
        }

        // if(substr($daynum,1,1) == '.')$this->message('请填写天数');exit;
        if (empty($daynum)) {
            $this->message('请填写代金券有效时间');
        }





        $data['name'] = $name;
        $data['type'] = $type;
        $data['juantotalcost'] = $juantotalcost;
        $data['juannum'] = $juannum;
        $data['jiancostmin'] = $jiancostmin;
        $data['jiancostmax'] = $jiancostmax;
        $data['jiacostmin'] = $jiacostmin;
        $data['jiacostmax'] = $jiacostmax;
        $data['paytype'] = $tempvalue;

        $data['is_open'] = $is_open;
        $data['orderid'] = $orderid;


        if (empty($id)) {
            $data['addtime'] = time();
            $data['endtime'] = $data['addtime']+$daynum*24*60*60;
            $this->mysql->insert(Mysite::$app->config['tablepre'].'juanrule', $data);
        } else {
            $juans = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."juanrule where  id={$id}  order by orderid asc");
            $data['endtime'] =  $juans['addtime']+$daynum*24*60*60;
            $this->mysql->update(Mysite::$app->config['tablepre'].'juanrule', $data, "id='".$id."'");
        }
        $this->success('success');
    }

    public function delmarketing()
    {
        limitalert();
        $id = IReq::get('id');
        if (empty($id)) {
            $this->message('获取失败');
        }
        $ids = is_array($id)? join(',', $id):$id;
        $this->mysql->delete(Mysite::$app->config['tablepre'].'juanrule', "id in($ids)");
        $this->success('success');
    }



    public function saverechargecost()
    {
        $id = intval(IReq::get('id'));
        $data['id'] = $id;
        $cost = intval(IReq::get('cost'));
        $is_sendcost = intval(IReq::get('is_sendcost'));
        $sendcost = trim(IReq::get('sendcost'));
        $is_sendjuan = intval(IReq::get('is_sendjuan'));
        $orderid = intval(IReq::get('orderid'));
        $juanid = intval(IReq::get('juanid'));
        if (empty($juanid)) {
            $this->message('请填写充值金额！');
        }
        if (empty($cost)) {
            $this->message('请填写充值金额！');
        }
        if ($is_sendcost > 0) {
            if (empty($sendcost)) {
                $this->message('请填写赠送金额！');
            }
        }
        $juaninfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuan where type  = 3 and id = ".$juanid."   ");
        if ($is_sendjuan == 1) {
            if (empty($juaninfo)) {
                $this->message('代金券信息获取失败！');
            }
        }
        $juansetinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 3 or name = '充值送代金券' ");

        $data['juanid'] = $juanid;
        $data['cost'] = $cost;
        $data['is_sendcost'] = $is_sendcost;
        $data['sendcost'] = $sendcost;
        $data['is_sendjuan'] = $is_sendjuan;
        if ($juansetinfo['costtype'] == 1) {
            $sendjuancost = $juaninfo['cost'];
        } else {
            $sendjuancost = rand($juaninfo['costmin'], $juaninfo['costmax']);
        }
        $data['sendjuancost'] = $sendjuancost;
        $data['orderid'] = $orderid;
        if (empty($id)) {
            $this->mysql->insert(Mysite::$app->config['tablepre'].'rechargecost', $data);
        } else {
            $this->mysql->update(Mysite::$app->config['tablepre'].'rechargecost', $data, "id='".$id."'");
        }
        $this->success('success');
    }


    public function rechargezend()
    {
        $cost = IReq::get('cost');
        $newlink = '';
        $where= '';


        $data['cost'] = '';
        if (!empty($cost)) {//限制值
            $data['cost'] = $cost;
            $where .= " and cost =  ".$cost." ";
            $newlink .= '/cost/'.$cost;
        }



        $data['where'] = " id > 0 ".$where;



        $pageinfo = new page();
        $pageinfo->setpage(intval(IReq::get('page')), 10);

        $rechargelist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."rechargecost where   ".$data['where']."   order by orderid asc    limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."  ");

        $shuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."rechargecost where   ".$data['where']."   order by orderid asc");
        $pageinfo->setnum($shuliang);
        $pagelink = IUrl::creatUrl('adminpage/card/module/rechargecost'.$newlink);
        $data['pagecontent'] = $pageinfo->getpagebar($pagelink);

        $data['rechargelist'] = $rechargelist;

        $data['juantypename'] = array(
            '1'=>'充值',
            '2'=>'下单成功分享',
            '3'=>'推广',
        );


        Mysite::$app->setdata($data);
    }

    public function delrechargecost()
    {
        limitalert();
        $id = IReq::get('id');
        if (empty($id)) {
            $this->message('获取失败');
        }
        $ids = is_array($id)? join(',', $id):$id;
        $this->mysql->delete(Mysite::$app->config['tablepre'].'rechargecost', "id in($ids)");
        $this->success('success');
    }

    public function juanupload()
    {
        $_FILES['imgFile'] = $_FILES['head'];
        $json = new Services_JSON();
        $uploadpath = 'upload/juan/';
        $filepath ='/upload/juan/';
        $upload = new upload($uploadpath, array('gif','jpg','jpge','png'));//upload
        $file = $upload->getfile();

        if ($upload->errno!=15&&$upload->errno!=0) {
            $this->message($upload->errmsg());
        } else {
            $this->success($filepath.$file[0]['saveName']);
        }
    }


    public function savejuanshowinfo()
    {
        $id = intval(IReq::get('id'));
        $data['id'] = $id;
        $bigimg = trim(IReq::get('bigimg'));
        $color = trim(IReq::get('color'));
        $actcolor = trim(IReq::get('actcolor'));
        $avtrule = trim(IReq::get('content'));
        if (empty($bigimg)) {
            $this->message('请上传领取代金券页面头部展示大图！');
        }
        if (empty($color)) {
            $this->message('请填写领取代金券页面背景色！');
        }
        if (empty($actcolor)) {
            $this->message('请填写领取代金券页面活动规则背景色！');
        }
        if (empty($avtrule)) {
            $this->message('请填写活动规则！');
        }

        $data['bigimg'] = $bigimg;
        $data['color'] = $color;
        $data['actcolor'] = $actcolor;
        $data['avtrule'] = $avtrule;

        if (empty($id)) {
            $data['addtime'] = time();
            $this->mysql->insert(Mysite::$app->config['tablepre'].'juanshowinfo', $data);
        } else {
            $this->mysql->update(Mysite::$app->config['tablepre'].'juanshowinfo', $data, "id='".$id."'");
        }
        $this->success('success');
    }
    public function savejuanshareinfo()
    {
        $id = intval(IReq::get('id'));
        $data['id'] = $id;
        $title = trim(IReq::get('title'));
        $img = trim(IReq::get('img'));
        $describe = trim(IReq::get('describe'));
        $url = '/index.php?ctrl=adminpage&action=card&module=addshareinfo&id='.$id;
        if (empty($title)) {
            $this->message('请填写标题！', $url);
        }
        if (empty($img)) {
            $this->message('请上传分享展示图标！', $url);
        }
        if (empty($describe)) {
            $this->message('请填写描述！', $url);
        }
        $data['type'] = $type;
        $data['title'] = $title;
        $data['img'] = $img;
        $data['describe'] = $describe;
        if (empty($id)) {
            $data['addtime'] = time();
            $this->mysql->insert(Mysite::$app->config['tablepre'].'juanshowinfo', $data);
        } else {
            $this->mysql->update(Mysite::$app->config['tablepre'].'juanshowinfo', $data, "id='".$id."'");
        }
        $this->success('success', $url);
    }

    public function sharejsinfo()
    {
        $title = IReq::get('title');
        $type = intval(IReq::get('type'));
        $newlink = '';
        $where= '';
        $data['title'] = '';
        if (!empty($title)) {//限制值
            $data['title'] = $title;
            $where .= " and title like '%".$title."%'";
            $newlink .= '/title/'.$title;
        }

        $data['type'] = '';
        if (!empty($type)) {//限制值
            $data['type'] = $type;
            $where .= " and type =  ".$type." ";
            $newlink .= '/type/'.$type;
        }


        $data['where'] = " id > 0 ".$where;



        $pageinfo = new page();
        $pageinfo->setpage(intval(IReq::get('page')), 10);

        $shareshowinfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."juanshowinfo where   ".$data['where']."   order by orderid asc    limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."  ");

        $shuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."juanshowinfo where   ".$data['where']."   order by orderid asc");
        $pageinfo->setnum($shuliang);
        $pagelink = IUrl::creatUrl('adminpage/card/module/sharejsinfo'.$newlink);
        $data['pagecontent'] = $pageinfo->getpagebar($pagelink);

        $data['shareshowinfo'] = $shareshowinfo;



        $data['juantypename'] = array(
            '2'=>'下单分享页面',
            '3'=>'推广页面',
            '4'=>'关注微信领取代金券',
        );


        Mysite::$app->setdata($data);
    }

    public function delsjsinfo()
    {
        limitalert();
        $id = IReq::get('id');
        if (empty($id)) {
            $this->message('获取失败');
        }
        $ids = is_array($id)? join(',', $id):$id;
        $this->mysql->delete(Mysite::$app->config['tablepre'].'juanshowinfo', "id in($ids)");
        $this->success('success');
    }

    public function receivejuanlog()
    {  // 代金券领取记录列表

        $name = IReq::get('name');
        $username = IReq::get('username');
        $bangphone = IReq::get('bangphone');
        $type = intval(IReq::get('type'));
        $status = intval(IReq::get('status'));
        $starttime = trim(IReq::get('starttime'));
        $endtime = trim(IReq::get('endtime'));
        $newlink = '';
        $where= '';
        $data['name'] = '';
        if (!empty($name)) {//限制值
            $data['name'] = $name;
            $where .= " and name like '%".$name."%'";
            $newlink .= '/name/'.$name;
        }
        $data['username'] = '';
        if (!empty($username)) {//限制值
            $data['username'] = $username;
            $where .= " and username like '%".$username."%'";
            $newlink .= '/username/'.$username;
        }
        $data['bangphone'] = '';
        if (!empty($bangphone)) {//限制值
            $data['bangphone'] = $bangphone;
            $where .= " and bangphone like '%".$bangphone."%'";
            $newlink .= '/bangphone/'.$bangphone;
        }

        $data['type'] = '';
        if (!empty($type)) {//限制值
            $data['type'] = $type;
            $where .= " and type =  ".$type." ";
            $newlink .= '/type/'.$type;
        }
        $data['status'] = '';
        if (!empty($status)) {//限制值
            $newstatus = $status-1;
            $data['status'] = $status;
            $where .= " and status =  ".$newstatus." ";
            $newlink .= '/status/'.$newstatus;
        }

        $data['starttime'] = '';
        if (!empty($starttime)) {
            $data['starttime'] = $starttime;
            $where .= ' and  creattime > '.strtotime($starttime.' 00:00:01').' ';
            $newlink .= '/addtime/'.$starttime;
        }
        $data['endtime'] = '';
        if (!empty($endtime)) {
            $data['endtime'] = $endtime;
            $where .= ' and  creattime < '.strtotime($endtime.' 23:59:59').' ';
            $newlink .= '/endtime/'.$endtime;
        }
        $data['where'] = " id > 0 ".$where;
        $pageinfo = new page();
        $pageinfo->setpage(intval(IReq::get('page')), 10);

        $receivejuanlog = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."juan where  type in(1,2,3,4,5) and  ".$data['where']."   order by creattime desc    limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."  ");

        $shuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."juan where   type in(1,2,3,4,5) and   ".$data['where']."   order by creattime desc");
        $pageinfo->setnum($shuliang);
        $pagelink = IUrl::creatUrl('adminpage/card/module/receivejuanlog'.$newlink);
        $data['pagecontent'] = $pageinfo->getpagebar($pagelink);
        $data['receivejuanlog'] = $receivejuanlog;
        $data['juantypename'] = array(
            '1'=>'关注送代金券',
            '2'=>'注册送代金券',
            '3'=>'充值送代金券',
            '4'=>'下单发红包',
            '5'=>'邀请好友送红包',
            '6'=>'邀请好友反赠',
        );
        $data['juanstatus'] = array(
            '0'=>'未使用',
            '1'=>'已绑定',
            '2'=>'已使用',
            '3'=>'无效',
        );
        Mysite::$app->setdata($data);
    }
    public function savesharejuanset()
    {   //保存分享代金券设置
        limitalert();
        $siteinfo['userordersharejuan'] =  intval(IReq::get('userordersharejuan'));
        $siteinfo['userextensionsharejuan'] =  intval(IReq::get('userextensionsharejuan'));
        $config = new config('hopeconfig.php', hopedir);
        $config->write($siteinfo);
        $configs = new config('hopeconfig.php', hopedir);
        $tests = $config->getInfo();
        $this->success('success');
    }



    /*
    *	8.3新增功能
    *	2016-06-04------
    *	zem
    */
    public function setstatus()
    {
        $data['shoptype'] = array('0'=>'外卖','1'=>'超市');
        Mysite::$app->setdata($data);
    }
    public function virtualinfo()
    {	//增加店铺虚拟信息
        $this->setstatus();
        $where = '';
        $goodswhere = '';


        $data['shopname'] =  trim(IReq::get('shopname'));
        $data['name'] =  trim(IReq::get('name'));
        $data['username'] =  trim(IReq::get('username'));
        $data['shop_type'] =  intval(IReq::get('shop_type'));
        $data['phone'] = trim(IReq::get('phone'));
        if (!empty($data['shopname'])) {
            $where .= " and shopname like '%".$data['shopname']."%'";
        }
        if (!empty($data['shop_type'])) {
            $newshoptype = $data['shop_type']-1;
            $where .= " and shoptype = '".$newshoptype."'  ";
        }
        if (!empty($data['username'])) {
            $where .= " and uid in(select uid from ".Mysite::$app->config['tablepre']."member where username='".$data['username']."')";
        }
        if (!empty($data['phone'])) {
            $where .=" and phone='".$data['phone']."'";
        }
        //构造查询条件
        $data['where'] = $where;


        if (!empty($data['shopname'])) {
            $goodswhere .= " and shopname like '%".$data['shopname']."%'";
        }
        if (!empty($data['name'])) {
            $goodswhere .= " and name like '%".$data['name']."%'";
        }


        $this->pageCls->setpage(intval(IReq::get('page')), 60);

        $selectlist = $this->mysql->getarr("select id,shopname,phone,shoptype,uid,virtualsellcounts from ".Mysite::$app->config['tablepre']."shop  where is_pass = 1 ".$where."  order by sort asc  limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."  ");
        $shuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."shop  where is_pass = 1 ".$where." ");

        $this->pageCls->setnum($shuliang);
        $data['pagecontent'] = $this->pageCls->getpagebar();
        $data['selectlist'] = $selectlist;

        Mysite::$app->setdata($data);
    }
    public function saveshopsellcount()
    {   //保存店铺虚拟总销量
        // limitalert();
        $shopid = intval(IReq::get('shopid'));
        $virtualsellcounts= intval(IReq::get('savesellcounts'));
        $data['virtualsellcounts'] = $virtualsellcounts;
        $this->mysql->update(Mysite::$app->config['tablepre'].'shop', $data, "id='".$shopid."'");
        $this->success('success');
    }


    public function virtualgoods()
    {	//增加商品虚拟信息
        $this->setstatus();
        $where = '';
        $goodswhere = '';
        $goodswhere2 = '';
        $shopid =  intval(IReq::get('id'));
        $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop   where id = '".$shopid."'  ");
        if (empty($shopinfo)) {
            echo "获取店铺失败";
            exit;
        }
        $data['shopinfo'] = $shopinfo;
        $data['name'] =  trim(IReq::get('name'));

        //构造查询条件
        $data['where'] = $where;

        if (!empty($data['name'])) {
            $goodswhere .= " and name like '%".$data['name']."%'";
            $goodswhere2 .= " and goodsname like '%".$data['name']."%'";
        }


        $this->pageCls->setpage(intval(IReq::get('page')), 60);

        $selectlist1 = $this->mysql->getarr("select id,name,sellcount,virtualsellcount from ".Mysite::$app->config['tablepre']."goods  where shopid = '".$shopinfo['id']."'  ".$goodswhere."  order by good_order asc  limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."  ");
        $selectlist3 =array();
        $selectlist2 = $this->mysql->getarr("select id,goodsid,goodsname,attrname from ".Mysite::$app->config['tablepre']."product  where shopid = '".$shopinfo['id']."'  ".$goodswhere2."  order by id asc  limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."  ");

        foreach ($selectlist2 as $key=>$val) {
            $val['name'] = $val['goodsname'].'【'.$val['attrname'].'】';
            $val['id'] = $val['goodsid'];
            $selectlist3[] = $val;
        }
        $selectlist = array_merge($selectlist1, $selectlist3);

        $shuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."goods  where shopid = '".$shopinfo['id']."'   ".$goodswhere." ");

        $this->pageCls->setnum($shuliang);
        $data['pagecontent'] = $this->pageCls->getpagebar();
        $data['selectlist'] = $selectlist;

        Mysite::$app->setdata($data);
    }

    public function savevirtualgoodcom()
    {  //后台保存添加商品虚拟评价
        limitalert();
        $goodid = intval(IReq::get('goodid'));
        $point = intval(IReq::get('point'));
        $content = trim(IReq::get('content'));
        $addtime = trim(IReq::get('addtime'));
        $virtualname = trim(IReq::get('virtualname'));   // 新增   虚拟人名称

        $goodsinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods   where id = '".$goodid."'  ");
        if (empty($goodsinfo)) {
            $this->message('获取商品信息失败');
        }
        if (empty($point)) {
            $this->message('请对商品进行评分');
        }
        if (empty($virtualname)) {
            $this->message('请填写评论人');
        }


        $data['goodsid'] = $goodid;
        $data['shopid'] = $goodsinfo['shopid'];
        $data['content'] = $content;
        $data['addtime'] = strtotime($addtime);
        $data['point'] = $point;
        $data['is_show'] = 0;
        $data['virtualname'] = $virtualname;
        $this->mysql->insert(Mysite::$app->config['tablepre'].'comment', $data);
        $this->success('success');
    }
}
