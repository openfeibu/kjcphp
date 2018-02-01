<?php 
/*
app消息通知类
*/ 
class appclass
{
	private $gwUrl = 'http://app.waimairen.com/gt.php?';//访问地址
	private $user;//用户名
	private $secret;//密匙
	private $actime;//时间搓
	private $sign;//签名 
	private $otherlink;   
	function __construct(){  
		$this->tskey = Mysite::$app->config['ghtskey'];
		$this->tsurl = 'http://ts.ghwmr.com'; 
		$this->extra = null;
		$this->sendtime = null; 
		$this->opentype = null;
		$this->openurl = "";
    } 
	function SetUid($shopuid){
		$this->shopuid = $shopuid;
		return $this;
	}
	public function SetExtra($data){//附加字段
		//附加数据格式: activity|字段1:值,字段2:值 ----可与app约定
		//当作为根据推送距离推送时：格式 locat|距离|lng坐标,lat坐标
		$this->extra = $data;
		return $this;
	} 
	//设置用户所有数据
	function SetUserlist($userlist = array()){
		$newarray = array(); 
		if(is_array($userlist) && count($userlist) > 0){
			foreach($userlist as $key=>$value){
					if(!empty($value['userid'])){
						$newarray[] = $value['userid'];
					}
					//可能存在未更新数据库的情况
					if(isset($value['xmuserid']) && !empty($value['xmuserid'])){
						$this->xmuserlist[] = $value['xmuserid'];
					}
			}
		}
		$this->gtuserids = join(',',$newarray);
		return $this;
	}
	//新增函数  
	public function openUrl($openurl){
		if(!empty($openurl)){
			$this->opentype = "URL";
			$this->openurl = $openurl;
		} 
		return $this;
	}
	/*未使用*/
    function bklink(){ 
   	    return false;
    }
  /*未使用*/
	function sendbytag($message,$othermsg='',$tag='',$messagetype=1){
	   return false;
    }
	/*未使用*/
	function sendmsg($userID,$channelid,$message,$othermsg='',$messagetype=1){   
   	  return false; 
	} 
	
    /*未使用*/
	function sendall($title,$msgcontent = '' ,$sendtime=''){//发送整站商家
		// $tsdata['type'] = 'publish';
		// $tsdata['title'] = $title;
		// $tsdata['content'] = $msgcontent;
		// $tsdata['uid'] = $this->tskey;
		// $tsdata['sendtime'] = $sendtime;
		// $tsdata['type'] = '5';
		// $tsdata['keys'] = '';
		// $tsdata['extra'] = $this->extra == null?'':$this->extra; 
		return false;
	}
    function sendNewmsg($title,$msgcontent='',$sendtime=''){ 
	    $tsdata['type'] = 'publish';
		$tsdata['title'] = $title;
		$tsdata['content'] = $msgcontent;
		$tsdata['uid'] = $this->tskey;
		$tsdata['sendtime'] = $sendtime == null?'':$sendtime;
		$tsdata['type'] = '2';
		$tsdata['keys'] = $this->shopuid;
		$tsdata['extra'] = $this->extra == null?'':$this->extra;
		/*
		if($this->shopuid == null || $this->shopuid == ''){
				return '未设置店铺id';
		}
		*/
		$this->fasongtype =  intval(Mysite::$app->config['app_shop_fstype']);
		if($this->fasongtype !=  3){
			$this->postxm($this->tsurl,$tsdata); 
		}
		if(in_array($this->fasongtype,array(2,3))){
			$this->alinint();
		}
		return "ok";
	}
	private function alinint($title,$msgcontent=''){ 
		$backextend = $this->extra == null?"":$this->extra;
		$aliextend = array('extra'=>$backextend,'msgtype'=>'send');  
		if($this->msgtype == 6){//other_message --跨声音
			$aliextend['msgtype'] = 'other';
		}
		$newkeys = $this->shopuid;
		 
		if(empty($newkeys)){
			$this->error = '账号未空';
			return false;
		}
		 
	 
		$devicetype = "DEV";
		$useios = false; 
		$this->accessKeyId = Mysite::$app->config['app_shop_aliid'];
		$this->accessKeySecret = Mysite::$app->config['app_shop_alikey'];  
		$appkey = Mysite::$app->config['app_shop_aliappkey']; 
		$acttivity = Mysite::$app->config['app_shop_startact']; 
		$checkios = Mysite::$app->config['app_shop_iostype']; 
		if($checkios == 1){
			$devicetype = "PRODUCT";
		}
		if(in_array($checkios,array(1,2))){
				$useios = true;
		} 		
		$this->fasongtype = Mysite::$app->config['app_shop_fstype'];   
		 
		if(empty($appkey)){
			return false;
		}
		if(empty($this->accessKeyId)){
			return;
		}  
		$music = "sounda.aiff";
		// if($title == '商家端退款通知'){
			// $music = 'tuikuan.aiff';
		// }
		
		include_once(hopedir.'/plug/aliyun/aliyun-php-sdk-core/Config.php');
		include_once(hopedir.'/plug/aliyun/aliyun-php-sdk-push/Push/Request/V20160801/PushRequest.php'); 
		
		//苹果的默认声音
		$iClientProfile = DefaultProfile::getProfile("cn-hangzhou", $this->accessKeyId, $this->accessKeySecret);
		$client = new DefaultAcsClient($iClientProfile); 
		$request = new \Push\Request\V20160801\PushRequest(); 
		$request->setAppKey($appkey);
		$request->setTarget("ALIAS"); //推送目标: DEVICE:推送给设备; ACCOUNT:推送给指定帐号,TAG:推送给自定义标签; ALL: 推送给全部
		$request->setTargetValue($newkeys); //根据Target来设定，如Target=device, 则对应的值为 设备id1,设备id2. 多个值使用逗号分隔.(帐号与设备有一次最多100个的限制)
		if($useios == true){
			$request->setDeviceType("ALL"); //设备类型 ANDROID iOS ALL.
		}else{
			$request->setDeviceType("ANDROID");
		}
		
		$request->setPushType("NOTICE"); //消息类型 MESSAGE NOTICE
		$request->setTitle($title); // 消息的标题
		$request->setBody($msgcontent); // 消息的内容 
		
		if($useios == true){
			// 推送配置: iOS
			$request->setiOSBadge("0"); // iOS应用图标右上角角标
			$request->setiOSMusic($music); // iOS通知声音
			$request->setiOSApnsEnv($devicetype);//iOS的通知是通过APNs中心来发送的，需要填写对应的环境信息。"DEV" : 表示开发环境 "PRODUCT" : 表示生产环境
			$request->setiOSRemind("true"); // 推送时设备不在线（既与移动推送的服务端的长连接通道不通），则这条推送会做为通知，通过苹果的APNs通道送达一次(发送通知时,Summary为通知的内容,Message不起作用)。注意：离线消息转通知仅适用于生产环境
			$request->setiOSRemindBody($msgcontent);//iOS消息转通知时使用的iOS通知内容，仅当iOSApnsEnv=PRODUCT && iOSRemind为true时有效
			$request->setiOSExtParameters(json_encode($aliextend)); //自定义的kv结构,开发者扩展用 针对iOS设备
		}
		// 推送配置: Android
		$request->setAndroidNotifyType("BOTH");//通知的提醒方式 "VIBRATE" : 震动 "SOUND" : 声音 "BOTH" : 声音和震动 NONE : 静音
		$request->setAndroidNotificationBarType(1);//通知栏自定义样式0-100
		if($this->opentype == "URL"){
			$request->setAndroidOpenType("URL");
			$request->setAndroidOpenUrl($this->openurl);
		}else{ 
			$request->setAndroidOpenType("ACTIVITY");
		}
		//点击通知后动作 "APPLICATION" : 打开应用 "ACTIVITY" : 打开AndroidActivity "URL" : 打开URL "NONE" : 无跳转
		//$request->setAndroidOpenUrl("http://www.aliyun.com");//Android收到推送后打开对应的url,仅当AndroidOpenType="URL"有效
		$request->setAndroidActivity($acttivity);//设定通知打开的activity，仅当AndroidOpenType="Activity"有效
		
		$request->setAndroidMusic("");//Android通知音乐
		//$request->setAndroidPopupActivity("com.ali.demo.PopupActivity");//设置该参数后启动辅助托管弹窗功能, 此处指定通知点击后跳转的Activity（辅助弹窗的前提条件：1. 集成第三方辅助通道；2. StoreOffline参数设为true
		$request->setAndroidPopupTitle($title);
		$request->setAndroidPopupBody($msgcontent);
		 
		$request->setAndroidExtParameters(json_encode($aliextend)); // 设定android类型设备通知的扩展属性

		// 推送控制
		$pushTime = gmdate('Y-m-d\TH:i:s\Z', strtotime('+3 second'));//延迟3秒发送
		$request->setPushTime($pushTime);
		$expireTime = gmdate('Y-m-d\TH:i:s\Z', strtotime('+15 minute'));//设置失效时间为1天
		$request->setExpireTime($expireTime);
		$request->setStoreOffline("true"); // 离线消息是否保存,若保存, 在推送时候，用户即使不在线，下一次上线则会收到
		try{
			$response = $client->getAcsResponse($request);  
			//print_r($response); 
			if(isset($response->RequestId)){
				//logwrite('tuisong_'.$response->Message);	
				return true; 
			}else{
				//logwrite('tuisong_'.$response->Message);	
				return false;
			}
		}catch(Exception $e){
			//logwrite('tuisong_'.$e->getMessage());	
			 logwrite($e->getMessage());
			return false;
		}
	 
	}
   
	function checkcode($code){
		if($code == 'ok'){
			return 'ok';//发送信息成功 
		}else{
			return $code;//其他错误
		} 
	} 
	public function postxm($url,$data='',$cookie=''){ // 模拟提交数据函数  
					// $header = array( 
						// 'Authorization: key='.$this->xmkey
					// );   
					 
					$data = http_build_query($data);
					$curl = curl_init(); // 启动一个CURL会话
					curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
					 curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
					// curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
					// curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
					//curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
					curl_setopt($curl, CURLOPT_COOKIE, $cookie);
					curl_setopt($curl, CURLOPT_REFERER,'');// 设置Referer
					curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
					curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
					curl_setopt($curl, CURLOPT_TIMEOUT, 10); // 设置超时限制防止死循环
					curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
					$tmpInfo = curl_exec($curl); // 执行操作
					if (curl_errno($curl)) {
						 $tmpInfo = 'Errno';//捕抓异常.curl_error($curl)
					}
					curl_close($curl); // 关闭CURL会话  					
					return $tmpInfo; // 返回数据  
					
	}
	 

}
?>