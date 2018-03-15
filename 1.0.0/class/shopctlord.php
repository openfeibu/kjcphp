<?php
/**
 * @class shopctlord
 * @brief 店铺操作订单类
 */
class shopctlord
{
	private $mysql;
	private $orderid;
	private $shopid;
	private $err = '';
	private $goods = '';
	private $orderinfo;
	private $orderdetinfo;
	private $memberCls;
	//构造函数
	function __construct($orderid,$shopid,$mysql)
	{
		$this->mysql = $mysql;
		$this->orderid = $orderid;
		$this->shopid = $shopid;
	}
	//获取订单信息
	private function orderinfo(){
		if($this->orderid == null || $this->orderid == ""){
			$this->err = '订单不存在';
			return false;
		}
		if($this->shopid == null || $this->shopid == ""){
			$this->err = '店铺不存在';
			return false;
		}
		$this->orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where id='".$this->orderid."' and shopid=".$this->shopid."  ");


		if(empty($this->orderinfo)){
			$this->err = '订单不存在';
			return false;
		}
		return true;
	}
	/*释放商品库存默认增加赠品未释放*/
	private function releasestroe()
	{
		$ordetinfo = $this->mysql->getarr("select ort.goodscount,go.id,go.sellcount,go.count as stroe from ".Mysite::$app->config['tablepre']."orderdet as ort left join  ".Mysite::$app->config['tablepre']."goods as go on go.id = ort.goodsid  where ort.order_id='".$this->orderinfo['id']."' and ort.is_send = 0 ");
	 	foreach($ordetinfo as $key=>$value)
		{
			 $this->mysql->update(Mysite::$app->config['tablepre'].'goods','`count`=`count`+'.$value['goodscount'].' ,`sellcount`=`sellcount`-'.$value['goodscount'],"id='".$value['id']."'");
		}
	}
	private function orderdetinfo(){
		$this->orderdetinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$this->orderid."'   ");
	}
	//商家取消订单
	public function unorder(){

		$reason = trim(IFilter::act(IReq::get('reason')));
		if($this->orderinfo() == false){
			return false;
		}
		if($this->orderinfo['status'] != 0){
			$this->err = '订单已处理过不能被商家取消';
			return false;
		}
		if($this->orderinfo['reback'] > 0){
			$this->err = '有退款操作,不能被商家取消';
			return false;
		}
		$detail = '';
		 if($this->orderinfo['paystatus'] == 1&& $this->orderinfo['paytype'] != 0){
		     $this->err = '订单已支付，取消订单请用户到用户中心申请退款';
		 	   return false;
		 }elseif($this->orderinfo['scoredown'] > 0){
		 	 $data['status'] = 4;
		    $this->mysql->update(Mysite::$app->config['tablepre']."order",$data,"id='".$this->orderinfo['id']."'");
			$this->mysql->update(Mysite::$app->config['tablepre'].'member','`score`=`score`+'.$this->orderinfo['scoredown'],"uid ='".$this->orderinfo['buyeruid']."' ");
		 }else{

		 	 $data['status'] = 4;
		    $this->mysql->update(Mysite::$app->config['tablepre']."order",$data,"id='".$this->orderinfo['id']."'");
		 }
		$this->releasestroe();
		$ordCls = new orderclass();
		$this->mysql->delete(Mysite::$app->config['tablepre'].'orderps',"orderid = '".$this->orderid."' and status !=3 ");  //删除不为完成的配送单
		$ordCls->noticeclose($this->orderid,$reason);
		return true;
	}
	//商家制作订单
	public function makeorder(){
		if($this->orderinfo() == false){
			return false;
		}
		if($this->orderinfo['is_make']){
			$this->err = '订单制作状态已处理';
			return false;
		}
		if($this->orderinfo['is_reback'] > 0){
			$this->err = '退款处理';
			return false;
		}
		if($this->orderinfo['status'] > 3){
			$this->err = '订单已取消';
			return false;
		}
		if($this->orderinfo['status'] == 2){
			$this->err = '订单已发货';
			return false;
		}
		if($this->orderinfo['status'] == 3){
			$this->err = '订单已完成';
			return false;
		}
		if($this->orderinfo['status'] == 0){
			$this->err = '订单还未通过审核，不能受理';
			return false;
		}

		if($this->orderinfo['paytype'] == 1){
			if($this->orderinfo['paystatus'] == 0){
				$this->err = '订单未支付，等待支付后确认制作';
				return false;
			}
		}
		$udata['is_make'] = 1;
		$udata['maketime'] = time();
		$this->mysql->update(Mysite::$app->config['tablepre'].'order',$udata,"id='".$this->orderid."'");
		$ordCls = new orderclass();
		$ordCls->writewuliustatus($this->orderinfo['id'],4,$this->orderinfo['paytype']);
		$ordCls->noticemake($this->orderid);
		if($this->orderinfo['pstype'] == 2){
			$psbinterface = new psbinterface();
			if($psbinterface->psbnoticeorder($this->orderid)){

			}
		}
		return true;
	}
	//商家取消订单
	public function unmakeorder(){
		if($this->orderinfo() == false){
			return false;
		}
		if($this->orderinfo['is_make']){
			$this->err = '订单制作状态已处理';
			return false;
		}
		if($this->orderinfo['is_reback'] > 0){
			$this->err = '退款处理中';
			return false;
		}
		if($this->orderinfo['status'] > 3){
			$this->err = '订单已取消';
			return false;
		}
		if($this->orderinfo['status'] == 2){
			$this->err = '订单已发货';
			return false;
		}
		if($this->orderinfo['status'] == 3){
			$this->err = '订单已完成';
			return false;
		}
		if($this->orderinfo['status'] == 0){
			$this->err = '订单还未通过审核，不能受理';
			return false;
		}
		$udata['is_make'] = 2;
		$this->mysql->update(Mysite::$app->config['tablepre'].'order',$udata,"id='".$this->orderid."'");
		$ordCls = new orderclass();
		$ordCls->noticeunmake($this->orderid);
		$ordCls->writewuliustatus($this->orderid,5,$this->orderinfo['paytype']);  //商家不接单  物流状态
		if( $this->orderinfo['paytype'] == 1 &&  $this->orderinfo['paystatus'] == 1 ){
			$drawbacklog = new drawbacklog($this->mysql,$this->memberCls);
			$drawdata = array();
			$drawdata['allcost'] = $this->orderinfo['allcost'];
			$drawdata['orderid'] = $this->orderinfo['id'];
			$drawdata['reason'] =  '商家取消订单';
			$drawdata['content'] = '商家取消订单,由于某原因不能制作此订单';
			$drawdata['typeid'] = 1;
			$check = $drawbacklog->setsavedraw($drawdata)->shopcnetersave();
			if($check == true){

			}else{

			}
		}else{
            $data['status'] = 5;
		    $this->mysql->update(Mysite::$app->config['tablepre']."order",$data,"id='".$this->orderinfo['id']."'");

		}
		return true;

	}
	public function SetMemberls($membercls){
		$this->memberCls = $membercls;
		return $this;
	}
	//商家订单发货
	public function sendorder(){


		if($this->orderinfo() == false){
			return false;
		}

		if($this->orderinfo['is_reback'] > 0){
			$this->err = '订单申请退款';
			return false;
		}
		if($this->orderinfo['status'] > 3){
			$this->err = '订单已取消';
			return false;
		}
		if($this->orderinfo['status'] == 0){
			$this->err = '订单状态未审核';
			return false;
		}
		if($this->orderinfo['status'] == 2){
			$this->err = '订单已发货';
			return false;
		}
		if($this->orderinfo['status'] == 3){
			$this->err = '订单已完成';
			return false;
		}
		if($this->orderinfo['is_make'] == 0){
			$this->err = '商家未确认制作不能发货';
			return false;
		}
		if($this->orderinfo['is_make'] == 2){
			$this->err = '商家已取消制作不能发货';
			return false;
		}
		if($this->orderinfo['pstype'] == 0 || $this->orderinfo['pstype'] == 2){
			$this->err = '此订单由配送员取货默认发货';
			return false;
		}
		$udata['status'] = 2;
		$udata['sendtime'] = time();
		$this->mysql->update(Mysite::$app->config['tablepre'].'order',$udata,"id='".$this->orderid."'");
		$ordCls = new orderclass();
		$ordCls->writewuliustatus($this->orderinfo['id'],6,$this->orderinfo['paytype']);
		$ordCls->noticesend($this->orderid);
		return true;
	}
	//商家删除订单
	public function delorder(){
		if($this->orderinfo() == false){
			return false;
		}

		if($this->orderinfo['is_reback'] > 0 && $this->orderinfo['is_reback'] < 3 ){
			$this->err = '订单申请退款中';
			return false;
		}
		if($this->orderinfo['status'] !=4 && $this->orderinfo['status'] !=5 ){
		 	   $this->err = '订单状态不可彻底删除';
		 	   return false;
		}
		$this->mysql->delete(Mysite::$app->config['tablepre'].'order',"id='".$this->orderinfo['id']."'");
		$this->mysql->delete(Mysite::$app->config['tablepre'].'orderdet',"order_id='".$this->orderinfo['id']."'");
		$this->mysql->delete(Mysite::$app->config['tablepre'].'orderps',"orderid = '".$this->orderinfo['id']."' and status != 3");
		return true;
	}
	//商家完成订单
	public function wancheng(){
		if($this->orderinfo() == false){
			return false;
		}
		if($this->orderinfo['is_reback'] > 0){
			$this->err = '订单申请退款';
			return false;
		}
		if($this->orderinfo['status'] > 3){
			$this->err = '订单已取消';
			return false;
		}
		if($this->orderinfo['status'] == 0){
			$this->err = '订单状态未审核';
			return false;
		}
		if($this->orderinfo['status'] == 1){
			$this->err = '订单未发货';
			return false;
		}
		if($this->orderinfo['is_make'] == 0){
			$this->err = '订单商家还未确认制作';
			return false;
		}
		if($this->orderinfo['is_make'] == 2){
			$this->err = '订单已取消制作';
			return false;
		}
		 if($this->orderinfo['status'] == 3){
			$this->err = '订单已完成';
			return false;
		}
		if($this->orderinfo['pstype'] == 0){
			$this->err = '平台配送订单由配送员处理';
			return false;
		}
		$ordCls = new orderclass();
		$ordCls->writewuliustatus($this->orderinfo['id'],9,$this->orderinfo['paytype']);  // 商家 操作 完成订单
		$orderdata['is_acceptorder'] = 1;
		$orderdata['status'] = 3;
		$orderdata['suretime'] = time();

 				/* 记录配送员送达时候坐标 */
				if(  $this->orderinfo['psuid'] > 0 ){
					if(  $this->orderinfo['pstype'] == 0 ){
						$psylocationonfo = $this->mysql->select_one("select uid,lng,lat from ".Mysite::$app->config['tablepre']."locationpsy where uid='".$this->orderinfo['psuid']."' ");
						if(!empty($psylocationonfo)){
							 $orderdata['psyoverlng'] = $psylocationonfo['lng'];
							 $orderdata['psyoverlat'] = $psylocationonfo['lat'];
						}
					}
					if(  $this->orderinfo['pstype'] == 2 ){
						$psbinterface = new psbinterface();
						$psylocationonfo = $psbinterface->getpsbclerkinfo($this->orderinfo['psuid']);
						if( !empty($psylocationonfo) && !empty($psylocationonfo['posilnglat']) ){
							$posilnglatarr = explode(',',$psylocationonfo['posilnglat']);
							$posilng = $posilnglatarr[0];
							$posilat = $posilnglatarr[1];
							if( !empty($posilng) && !empty($posilat)  ){
								 $orderdata['psyoverlng'] = $posilng;
								 $orderdata['psyoverlat'] = $posilat;
							}
						}
					}
				}


		$this->mysql->update(Mysite::$app->config['tablepre'].'order',$orderdata,"id='".$this->orderid."'");

		//更新销量
		$shuliang  = $this->mysql->select_one("select sum(goodscount) as sellcount from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$this->orderinfo['id']."'  ");
		if(!empty($shuliang) && $shuliang['sellcount'] > 0){
			$this->mysql->update(Mysite::$app->config['tablepre'].'shop','`sellcount`=`sellcount`+'.$shuliang['sellcount'].'',"id ='".$this->orderinfo['shopid']."' ");
		}
		//更新用户成长值
		if(!empty($this->orderinfo['buyeruid'])){
			$memberinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$this->orderinfo['buyeruid']."'   ");
			if(!empty($memberinfo)){
				$data['total']=$memberinfo['total']+$this->orderinfo['allcost'];
				$data['score'] = $memberinfo['score']+Mysite::$app->config['consumption'];
				if(Mysite::$app->config['con_extend'] > 0){
					$allscore= $this->orderinfo['allcost']*Mysite::$app->config['con_extend'];
					$data['score']+=$allscore;
					$consumption=$allscore;
				}
				if(!empty($consumption)){
					$consumption+=Mysite::$app->config['consumption'];
				}else{
					$consumption=Mysite::$app->config['consumption'];
				}
				$this->mysql->update(Mysite::$app->config['tablepre'].'member',$data,"uid ='".$this->orderinfo['buyeruid']."' ");
				if($consumption > 0){
					$this->memberCls->addlog($this->orderinfo['buyeruid'],1,1,$consumption,'消费送积分','消费送积分'.$consumption,$data['score']);
				}
				if($memberinfo['parent_id'] > 0){
					$upuser = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$memberinfo['parent_id']."'   ");
					if(!empty($upuser)){
						if(Mysite::$app->config['tui_juan'] ==1){
							$nowtime = time();
							$endtime = $nowtime+Mysite::$app->config['tui_juanday']*24*60*60;
							$juandata['card'] = $nowtime.rand(100,999);
							$juandata['card_password'] =  substr(md5($juandata['card']),0,5);
							$juandata['status'] = 1;// 状态，0未使用，1已绑定，2已使用，3无效
							$juandata['creattime'] = $nowtime;// 制造时间
							$juandata['cost'] = Mysite::$app->config['tui_juancost'];// 优惠金额
							$juandata['limitcost'] =  Mysite::$app->config['tui_juanlimit'];// 购物车限制金额下限
							$juandata['endtime'] = $endtime;// 失效时间
							$juandata['uid'] = $upuser['uid'];// 用户ID
							$juandata['username'] = $upuser['username'];// 用户名
							$juandata['name'] = '推荐送优惠券';//  优惠券名称
							$this->mysql->insert(Mysite::$app->config['tablepre'].'juan',$juandata);
							$this->mysql->update(Mysite::$app->config['tablepre'].'member','`parent_id`=0',"uid ='".$this->orderinfo['buyeruid']."' ");
							$logdata['uid'] = $upuser['uid'];
							$logdata['childusername'] = $memberinfo['username'];
							$logdata['titile'] = '推荐送优惠券';
							$logdata['addtime'] = time();
							$logdata['content'] = '被推荐下单完成';
							$this->mysql->insert(Mysite::$app->config['tablepre'].'sharealog',$logdata);
						}
					}
				}
			}
		}
		return true;
	}
	//同意退款
	public function reback(){

		if($this->orderinfo() == false){
			return false;
		}
		if($this->orderinfo['is_reback'] == 0){
			$this->err = '订单未申请退款';
			return false;
		}
		if($this->orderinfo['status'] > 3){
			$this->err = '订单已取消';
			return false;
		}
		$drawbacklog = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."drawbacklog where orderid=".$this->orderid." order by  id desc  limit 0,2");


		if(empty($drawbacklog)){
			$this->err = '退款申请不存在';
			return false;
		}
		if($drawbacklog['status'] > 0 && $drawbacklog['status'] < 3){   //退款状态 0未待处理 1为已退 2为拒绝退款 3待商家确认
			$this->err = '退款申请已处理';
			return false;
		}
		if($drawbacklog['type'] != 0){
			$this->err = '商家已处理过退款';
			return false;
		}

		$data['type'] = 1;
		$data['status'] = 0;
		$this->mysql->update(Mysite::$app->config['tablepre'].'drawbacklog',$data,"id='".$drawbacklog['id']."'");
		$data1['is_reback'] = 1;
		$this->mysql->update(Mysite::$app->config['tablepre'].'order',$data1,"id='".$this->orderid."'");
		$ordCls = new orderclass();
		$ordCls->noticeback($this->orderid);
        //退款通知配送宝
        if($this->orderinfo['pstype'] == 2 && $this->orderinfo['is_make'] == 1){
            $psbinterface = new psbinterface();
            if($psbinterface->psbdraworder($this->orderid)){

            }
        }
		return true;
	}
	//不同意退款
	public function unreback(){
		if($this->orderinfo() == false){

			return false;
		}
		if($this->orderinfo['is_reback'] == 0){
			$this->err = '订单未申请退款';
			return false;
		}
		if($this->orderinfo['status'] > 3){

			$this->err = '订单已取消';
			return false;
		}
		$drawbacklog = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."drawbacklog where orderid=".$this->orderid." order by  id desc  limit 0,2");

		if(empty($drawbacklog)){
			$this->err = '退款申请不存在';
			return false;
		}
		if($drawbacklog['status'] > 0 && $drawbacklog['status'] < 3){
			$this->err = '退款申请已处理';
			return false;
		}
		if($drawbacklog['type'] != 0){
			$this->err = '商家已处理过退款';
			return false;
		}
		/* $data['type'] = 2;//
		$data['status'] = 2;
		$this->mysql->update(Mysite::$app->config['tablepre'].'drawbacklog',$data,"id='".$drawbacklog['id']."'");  */
		$udata['is_reback'] = 0;//商家拒绝退款后   订单返回原状态
		$this->mysql->update(Mysite::$app->config['tablepre'].'order',$udata,"id='".$this->orderid."'");
		$ordCls = new orderclass();
		$ordCls->writewuliustatus($this->orderinfo['id'],15,$this->orderinfo['paytype']);  // 拒绝退款
		$ordCls->noticeunback($this->orderid);
		return true;
	}

	public function closeorder()
	{
		if($this->orderinfo() == false){
			return false;
		}
		if($this->orderinfo['is_reback'] > 0){
			$this->err = '退款处理中';
			return false;
		}
		if($this->orderinfo['status'] > 3){
			$this->err = '订单已取消';
			return false;
		}
		if($this->orderinfo['status'] == 2){
			$this->err = '订单已发货';
			return false;
		}
		if($this->orderinfo['status'] == 3){
			$this->err = '订单已完成';
			return false;
		}
		if($this->orderinfo['status'] == 0){
			$this->err = '订单还未通过审核，不能受理';
			return false;
		}
		$udata['is_make'] = 2;
		$this->mysql->update(Mysite::$app->config['tablepre'].'order',$udata,"id='".$this->orderid."'");
		$ordCls = new orderclass();
		$ordCls->noticeunmake($this->orderid);
		$ordCls->writewuliustatus($this->orderid,5,$this->orderinfo['paytype']);  //商家不接单  物流状态
		if( $this->orderinfo['paytype'] == 1 &&  $this->orderinfo['paystatus'] == 1 ){
			$drawbacklog = new drawbacklog($this->mysql,$this->memberCls);
			$drawdata = array();
			$drawdata['allcost'] = $this->orderinfo['allcost'];
			$drawdata['orderid'] = $this->orderinfo['id'];
			$drawdata['reason'] =  '商家取消订单';
			$drawdata['content'] = '商家取消订单,由于某原因不能制作此订单';
			$drawdata['typeid'] = 1;
			$check = $drawbacklog->setsavedraw($drawdata)->shopcnetersave();
			if($check == true){

			}else{

			}
		}else{
            $data['status'] = 5;
		    $this->mysql->update(Mysite::$app->config['tablepre']."order",$data,"id='".$this->orderinfo['id']."'");

		}
		return true;
	}

	public function Error()
	{
		return $this->err;
	}
	//写消息
	private function wirtemess($mes)
	{

	}

}
?>
