 <?php

/**
 * @class drawbacklog
 * @brief 退款申请类
 $obj = get_class($usercls); //获取类名
 print_r($obj);
 */
class drawbacklog
{
    private $error = '';
    private $orderid = '';
    private $logtype = array('0'=>'退款到支付宝','1'=>'退款到账户');
    private $typeidlist = array('0','1');
    private $actionclas;
    private $drawdata;
    protected $mysql;
    /**
     *  @brief Brief
     *
     *  @param [in] $mysql 数据库操作
     *  @param [in] $usercls 传用户类 操作'
     *  @return Return_Description
     *
     *  @details Details
     */
    public function __construct($mysql, $usercls)
    {
        $this->mysql =$mysql;
        $this->actionclas = $usercls;//memberclass   //print_r($this->actionclas->getadmininfo());//获取管理员信息   getinfo//获取
    }
    public function setsavedraw($data)
    {  //

        $this->drawdata = $data;
        return $this;
    }
    //添加退款记录
    public function save()
    {
        if ($this->drawdata  == null) {
            $allcost =  IFilter::act(IReq::get('allcost'));
            $orderid = intval(IFilter::act(IReq::get('orderid')));    // 订单号
            $data['reason'] = trim(IFilter::act(IReq::get('reason'))); //退款原因
            $data['content'] = trim(IFilter::act(IReq::get('content'))); //退款详细内容说明
            $typeid = intval(IFilter::act(IReq::get('typeid'))); //支付类型
        } else {
            $allcost =  $this->drawdata['allcost'];
            $orderid =  $this->drawdata['orderid'];// 订单号
            $data['reason'] = $this->drawdata['reason']; //退款原因
            $data['content'] = $this->drawdata['content']; //退款详细内容说明
            $typeid = $this->drawdata['typeid']; //支付类型
            $laiyuan = $this->drawdata['laiyuan']; //退款来源
            $uid = $this->drawdata['uid']; //退款来源是app时候 的uid
        }
        if (!in_array($typeid, $this->typeidlist)) {
            $this->error = '未定义退款类型';
            return false;
        }
        // if (empty($data['reason'])) {
        //     $this->error = '未选择退款原因';
        //     return false;
        // }

        $orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where id='".$orderid."' ");
        if (empty($orderinfo)) {
            $this->error = '订单不存在';
            return false;
        }

        // if ($orderinfo['allcost'] != $allcost) {
        //     $this->error = "退款金额错误";
        //     return false;
        // }

        if ($laiyuan == 'app') {
            $memberinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$uid."' ");
        } else {
            $memberinfo = $this->GetMem();
        }
        if (empty($memberinfo)) {
            $this->error = '获取用户信息失败';
            return false;
        }

        if ($orderinfo['buyeruid'] != $memberinfo['uid']) {
            $this->error = '购买用户和用户不一致';
            return false;
        }
        if ($orderinfo['paystatus'] != 1) {
            $this->error = '该订单未支付';
            return false;
        }
        if ($orderinfo['status'] < 1 || $orderinfo['status'] >= 3) {
            $this->error = '订单状态不能申请退款';
            return false;
        }
        if ($orderinfo['paytype'] == 0||empty($orderinfo['paytype'])) {
            $this->error = '货到支付订单';
            return false;
        }
        if (!empty($orderinfo['is_reback'])) {
            $this->error = '已申请退款';
            return false;
        }

        // if (empty($data['content'])) {
        //     $this->error = '请填写退款详细内容说明';
        //     return false;
        // }

        $checklog = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."drawbacklog where orderid='".$orderinfo['id']."' ");
        if (!empty($checklog) && $orderinfo['is_reback'] > 0) {
            $this->error = '已申请过退款';
            return false;
        }
        $data['orderid'] = $orderinfo['id'];
        $data['shopid'] = $orderinfo['shopid'];
        $data['uid'] = $memberinfo['uid'];
        $data['username'] = $memberinfo['username'];
        $data['status'] = 0;//退款状态 0待处理 1为已退 2为拒绝退款 3待商家确认
        $data['addtime'] = time();
        $data['cost'] = $orderinfo['allcost'];
        $data['admin_id'] = $orderinfo['admin_id'];
        $data['type'] = $typeid;

        //如果订单未制作，退款申请跳过商家直接到平台  等待平台处理   需插入日志  并在平台退款退款申请处理那里显示
        //如果订单已经制作  退款申请到商家   等待商家处理
        //如果商家同意退款   退款申请再到平台   等待平台处理
        //如果商家拒绝退款   订单返回原状态   平台不需要任何操作
        // if ($orderinfo['is_make'] ==1) {
        //     $data['status'] = 3;//退款状态 0待处理 1为已退 2为拒绝退款 3待商家确认
        // }
        $this->mysql->insert(Mysite::$app->config['tablepre'].'drawbacklog', $data);
        $udata['is_reback'] = 1;
        // if ($orderinfo['is_make'] ==1) {
        //     $udata['is_reback'] = 4;//如果商家确认制作后允许申请退款的话   客户申请退款   is_reback=4(申请退款，待商家确认)
        // } else {
        //     $udata['is_reback'] = 1;
        // }
        $this->mysql->update(Mysite::$app->config['tablepre'].'order', $udata, "id='".$orderinfo['id']."'");
        $ordCls = new orderclass();
        $ordCls->writewuliustatus($orderinfo['id'], 13, $orderinfo['paytype']);  // 管理员 操作配送发货
        if ($orderinfo['is_make'] ==1) {
            $appCls = new appclass();
            $appCls->SetUid($orderinfo['shopuid'])->sendNewmsg(Mysite::$app->config['sitename'].'退款提醒', '您有新的退款订单等待处理');
        }
        return true;
    }
    public function shopcnetersave()
    {
        if ($this->drawdata  == null) {
            $allcost =  IFilter::act(IReq::get('allcost'));
            $orderid = intval(IFilter::act(IReq::get('orderid')));    // 订单号
        $data['reason'] = trim(IFilter::act(IReq::get('reason'))); //退款原因
        $data['content'] = trim(IFilter::act(IReq::get('content'))); //退款详细内容说明
        $typeid = intval(IFilter::act(IReq::get('typeid'))); //支付类型
        } else {
            $allcost =  $this->drawdata['allcost'];
            $orderid =  $this->drawdata['orderid'];// 订单号
        $data['reason'] = $this->drawdata['reason']; //退款原因
        $data['content'] = $this->drawdata['content']; //退款详细内容说明
        $typeid = $this->drawdata['typeid']; //支付类型
        }
        if (!in_array($typeid, $this->typeidlist)) {
            $this->error = '未定义退款类型';
            return false;
        }
        if (empty($data['reason'])) {
            $this->error = '未选择退款原因';
            return false;
        }


        $orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where id='".$orderid."' ");
        if (empty($orderinfo)) {
            $this->error = '订单不存在';
            return false;
        }

        if ($orderinfo['allcost'] != $allcost) {
            $this->error = "退款金额错误";
            return false;
        }

        $memberinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$orderinfo['buyeruid']."' ");

        if (empty($memberinfo)) {
            $this->error = '获取会员信息错误';
            return false;
        }


        if ($orderinfo['paystatus'] != 1) {
            $this->error = '该订单未支付';
            return false;
        }
        if ($orderinfo['status'] < 1 && $orderinfo['status'] < 3) {
            $this->error = '订单状态不能申请退款';
            return false;
        }
        if ($orderinfo['paytype'] == 0||empty($orderinfo['paytype'])) {
            $this->error = '货到支付订单';
            return false;
        }
        if (!empty($orderinfo['is_reback'])) {
            $this->error = '已申请退款';
            return false;
        }

        if (empty($data['content'])) {
            $this->error = '请填写退款详细内容说明';
            return false;
        }

        $checklog = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."drawbacklog where orderid='".$orderinfo['id']."' ");
        if (!empty($checklog)) {
            $this->error = '已申请过退款';
            return false;
        }
        $data['orderid'] = $orderinfo['id'];
        $data['shopid'] = $orderinfo['shopid'];
        $data['uid'] = $memberinfo['uid'];
        $data['username'] = $memberinfo['username'];
        $data['status'] = 0;
        $data['addtime'] = time();
        $data['cost'] = $orderinfo['allcost'];
        $data['admin_id'] = $orderinfo['admin_id'];
        $data['type'] = $typeid;
        $this->mysql->insert(Mysite::$app->config['tablepre'].'drawbacklog', $data);
        $udata['is_reback'] = 1;
        $this->mysql->update(Mysite::$app->config['tablepre'].'order', $udata, "id='".$orderinfo['id']."'");
        $ordCls = new orderclass();
        $ordCls->writewuliustatus($orderinfo['id'], 13, $orderinfo['paytype']);  // 管理员 操作配送发货
        return true;
    }


    //返回错误
    public function GetErr()
    {
        return $this->error;
    }
    //返回退款类型
    public function gettype()
    {
        return $this->logtype;
    }
    /**
     *  @brief Brief
     *
     *  @param [in] $type 操作类型  0-同意退款  1表示取消退款
     *  			$role 操作者   admin-后台管理员  areaadmin-区域管理员  shop-店铺
     *  			$roleid 操作者ID   $role=admin-后台管理ID   $role=areaadmin-区域管理员uid   $role=shop-店铺所有者ID
     *  @return true/false;
     *
     *  @details Details
    */
    public function control($type=0, $role='uid', $roleid='0', $orderid)
    {
        $drawbacklog = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."drawbacklog where orderid=".$orderid." order by  id desc  limit 0,2");
        if (empty($drawbacklog)) {
            $this->error = '退款记录为空';
            return false;
        }
        if ($drawbacklog['status'] != 0) {
            $this->error = '退款记录已处理过';
            return false;
        }
        if ($type == 0) {
            if ($role == 'uid') {
                //店铺  同意
                if ($drawbacklog['type']==0) {
                    $this->error = '退款到支付宝需要网站后台处理';
                    return false;
                }
            }
            $data['bkcontent'] = IReq::get('reasons');
            $data['status'] = 2;//
            $this->mysql->update(Mysite::$app->config['tablepre'].'drawbacklog', $data, "id='".$drawbacklog['id']."'");
        } elseif ($type==1) {
            $data['status'] = 3;//
            $this->mysql->update(Mysite::$app->config['tablepre'].'drawbacklog', $data, "id='".$drawbacklog['id']."'");
        }
        return true;
    }

    private function CkMem()
    {
        $memberinfo = $this->GetMem;
    }
    private function CkAdmin()
    {
        $memberinfo = $this->GetAdmin;
    }
    //返回用户信息
    private function GetMem()
    {
        return $this->actionclas->getinfo();
    }
    //放回 管理员信息
    private function GetAdmin()
    {
        return $this->actionclas->getadmininfo();
    }
}
?>
