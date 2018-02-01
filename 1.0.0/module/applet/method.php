<?php
/*
*   method 方法  包含所有会员相关操作
    管理员/会员  添加/删除/编辑/用户登陆
    用户日志其他相关连的通过  memberclass关联
*/
class method   extends  baseclass
{  
     public $CITY_ID;
     public $platpssetinfo;
     public $is_pass_applet ;
     public $default_adcode ;
	 
	public function __construct()
	{
		$this->mysql =  new mysql_class(); 
		$this->is_pass_applet = Mysite::$app->config['is_pass_applet'];
        $this->default_adcode = Mysite::$app->config['default_cityid'];
	}
	 
    public function curl_get_content($url)
    {
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_REFERER,'');// 设置Referer
        curl_setopt($curl, CURLOPT_POST, 0); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo;
    }
    //获取微信小程序配置信息
    function getconfig(){
       $data['appid'] =  Mysite::$app->config['appletAppID'];
       $data['secret'] = Mysite::$app->config['appletsecret'];
       $data['mapkey'] = Mysite::$app->config['appletmapkey']; 

        $this->success($data);
    }
    //根据adcode获取城市信息
    public function getOpenCity(){
		 $adcode = IFilter::act(IReq::get('adcode'));
		 if( $this->is_pass_applet == 0 ){
			 $adcode = $this->default_adcode;
		 }
  		 if( !empty($adcode) ){
				$areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  ");
				if( !empty($areacodeone) ){
					$adcodeid = $areacodeone['id'];
					$pid = $areacodeone['pid'];
   					$info =  $this->mysql->select_one("select name,adcode from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  ");
					if( !empty($info) ){
 						$platpssetinfo = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."platpsset where   cityid='".$info['adcode']."'   ");
						if( !empty($platpssetinfo) ){
 							$platpssetinfo['cityname'] = $info['name'];
							$this->platpssetinfo = $platpssetinfo;
							$this->CITY_ID = $platpssetinfo['cityid'];
 						}
 					}else{
						$this->message("获取城市信息失败");
					}

				}else{
					$this->message("获取城市信息失败");
				}
			}else{
				$this->message("获取城市信息失败");
			}
 	 }
    //获取首页顶部分类数据
	  function checkopencity(){ 
			$this->getOpenCity();
			$moretypelist =array();
            if( !empty($this->platpssetinfo) ){
//                $moretypelist = $this->mysql->getarr("select `img`,`name`,`activity`,`param` from ".Mysite::$app->config['tablepre']."appadv where type=2 and cityid='".$this->CITY_ID."'  and ( activity = 'waimai' or activity = 'market') order by orderid  asc");
                $moretypelist = $this->mysql->getarr("select `img`,`name`,`activity`,`param` from ".Mysite::$app->config['tablepre']."appadv where type=2 and ( cityid='".$this->CITY_ID."' or  cityid = 0 )  and is_show = 1 order by orderid  asc");
            }
				 
 			$newmoretypelist = array();
			if( !empty($moretypelist) ){
				foreach($moretypelist as $key=>$value){
					$value['img'] = Mysite::$app->config['siteurl'].$value['img'];
					$newmoretypelist[] = $value;
				}
			}
			
          $data['moretypelist'] = array();
          $data['setinfo'] = $this->platpssetinfo;
          $data['typecount'] = count($newmoretypelist);
          if(count($newmoretypelist) > 0){
              $data['moretypelist'][]  = array_slice($newmoretypelist,0,8);
              if(count($newmoretypelist) > 8){
                  $data['moretypelist'][]  = array_slice($newmoretypelist,8,8);
              }
          }

          $advlist = $this->mysql->getarr("select `linkurl`,`img` from ".Mysite::$app->config['tablepre']."adv where advtype='weixinlb' and  module='".Mysite::$app->config['sitetemp']."' and cityid='".$this->CITY_ID."'  and is_show = 1 limit 0,5");
          $advArr = array();
          if( !empty($advlist) ){
              foreach($advlist as $va){
                  $va['img'] = Mysite::$app->config['siteurl'].$va['img'];
                  $advArr[] = $va;
              }
          }
          $data['advlist'] = $advArr;

          $data['notice'] = '';
          $notice = $this->mysql->select_one("select `title` from ".Mysite::$app->config['tablepre']."information where type=1 and ( cityid = '".$this->CITY_ID."' or cityid = 0  ) order by orderid asc ");
          if(!empty($notice)){
              $data['notice'] = $notice['title'];
          }

          $ztymode = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."ztymode where cityid='".$this->CITY_ID."'  ");
          $data['ztymode'] = $ztymode['type'];

          if($ztymode['type'] == 1){
              $limits = 5;
          }else if($ztymode['type'] == 2){
              $limits = 4;
          }else{
              $limits = 3;
          }
          $ztylist = $this->mysql->getarr("select `id`,`indeximg` from ".Mysite::$app->config['tablepre']."specialpage where is_show = 1  and is_bd = 2  and ( cityid='".$this->CITY_ID."' or  cityid = 0 ) order by orderid  asc limit {$limits} ");
          $ztyArr = array();
          if(!empty($ztylist)){
              foreach($ztylist as $vz){
                  $vz['indeximg'] = Mysite::$app->config['siteurl'].$vz['indeximg'];
                  $ztyArr[] = $vz;
              }
          }
          $data['ztylist'] = $ztyArr;

          $advlist2 = $this->mysql->getarr("select `linkurl`,`img` from ".Mysite::$app->config['tablepre']."adv where advtype='weixinlb2' and  module='".Mysite::$app->config['sitetemp']."' and cityid='".$this->CITY_ID."'  and is_show = 1 limit 0,5");
          $advArr2 = array();
          if( !empty($advlist2) ){
              foreach($advlist2 as $va2){
                  $va2['img'] = Mysite::$app->config['siteurl'].$va2['img'];
                  $advArr2[] = $va2;
              }
          }
          $data['advlist2'] = $advArr2;

          $lng = trim(IReq::get('lng'));
          $lat = trim(IReq::get('lat'));
          $lng = empty($lng)?0:$lng;
          $lat =empty($lat)?0:$lat;
          $where =  Mysite::$app->config['plateshopid'] > 0 ? ' and id != '.Mysite::$app->config['plateshopid'] .' ': '';
          $where .= " and admin_id=".$this->CITY_ID."   ";
          $where .= ' and SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradiusa`*0.01094-0.01094) ';
          $fyshoplist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop where is_pass = 1 and isforyou = 1  and endtime > ".time()."  ".$where."  order by sort asc limit 6 ");
          $fyshopArr = array();
          if(!empty($fyshoplist)){
              foreach($fyshoplist as $tf){
                  $tf['shoplogo'] = empty($tf['shoplogo']) ? Mysite::$app->config['shoplogo'] : $tf['shoplogo'];
                  $tf['shoplogo'] = Mysite::$app->config['siteurl'].$tf['shoplogo'];
                  $fyshopArr[] = $tf;
              }
          }
          $data['fyshoplist'] = $fyshopArr;

          $wxkefu_open = 0;
          $wxkefu_ewm = '';
          $wxkefu_phone = '';
          if(!empty($this->platpssetinfo)){
              if($this->platpssetinfo['wxkefu_open'] == 1){
                  $wxkefu_open = 1;
              }
              if(!empty($this->platpssetinfo['wxkefu_ewm'])){
                  $wxkefu_ewm = Mysite::$app->config['siteurl'].$this->platpssetinfo['wxkefu_ewm'];
              }
              if(!empty($this->platpssetinfo['wxkefu_phone'])){
                  $wxkefu_phone = $this->platpssetinfo['wxkefu_phone'];
              }
          }
          $data['wxkefu_open'] = $wxkefu_open;
          $data['wxkefu_ewm'] = $wxkefu_ewm;
          $data['wxkefu_phone'] = $wxkefu_phone;

        $this->success($data);
	}
    //用户判断登录
    public function setwxlogin(){
        $code = IFilter::act(IReq::get('code'));
        $appid = IFilter::act(IReq::get('appid'));
        $secret = IFilter::act(IReq::get('secret'));
        $token_link = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
        $token =json_decode($this->curl_get_content($token_link), TRUE);
        if(isset($token['errcode'])){
            $this->message($token['errmsg']);
        }else{
            $wxoauth['openid'] = $token['openid'];
        }
        $wxuser['sex'] = IFilter::act(IReq::get('gender'));
        $wxoauth['username'] = IFilter::act(IReq::get('nickName'));
        $wxoauth['imgurl'] = IFilter::act(IReq::get('avatarUrl'));
        $oauthinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."wxuser where openid='".$wxoauth['openid']."'  ");
        if(empty($oauthinfo)){//写用户数据
            $arr['username'] = $wxoauth['openid'];
            $arr['phone'] = '';
            $arr['address'] = '';
            $arr['password'] = md5($wxoauth['openid']);
            $arr['email'] = '';
            $arr['creattime'] = time();
            $arr['score'] = empty(Mysite::$app->config['regesterscore']) ? 0 :Mysite::$app->config['regesterscore'];
            $arr['logintime'] = time();
            $arr['loginip'] ='';
            $arr['group'] = 10;
            $arr['logo'] = $wxoauth['imgurl'];
            $arr['sex'] = $wxuser['sex'];  //用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
            $newusername = $wxoauth['username'];
            $checkusername ='xxx';
            $k = 0;
            while(!empty($checkusername)){
                $newusername = $k==0? $newusername:$newusername.$k;
                $checkusername = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where username ='".$newusername."' ");
                $k = $k+1;
                if(empty($checkusername)){
                    break;
                }
            }
            $arr['username'] = $newusername;
            $this->mysql->insert(Mysite::$app->config['tablepre']."member",$arr);
            $uid = $this->mysql->insertid();
            $userid = $uid;
            $mbdata['uid'] = $uid;
            $mbdata['openid'] = $wxoauth['openid'];
            $mbdata['is_bang'] = 0;
            $this->mysql->insert(Mysite::$app->config['tablepre'].'wxuser',$mbdata);
        }else{//更新用户数据
            $userid = $oauthinfo['uid'];
            $membercheck = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid ='".$oauthinfo['uid']."' ");
            if(!empty($membercheck)){
                if(empty($membercheck['username'])){
                    $newusername = $wxoauth['username'];
                    $checkusername ='xxx';
                    $k = 0;
                    while(!empty($checkusername)){
                        $newusername = $k==0? $newusername:$newusername.$k;
                        $checkusername = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where username ='".$newusername."' ");
                        $k = $k+1;
                        if(empty($checkusername)){
                            break;
                        }
                    }
                    $cnewdata['username'] = $newusername;
                }
                $cnewdata['logo'] = $wxoauth['imgurl'];
                $cnewdata['sex'] = $wxuser['sex'];
                $loginscore = empty(Mysite::$app->config['loginscore']) ? 0 :Mysite::$app->config['loginscore'];
                $cnewdata['score'] = $membercheck['score'] + $loginscore;
                $this->mysql->update(Mysite::$app->config['tablepre'].'member',$cnewdata,"uid='".$oauthinfo['uid']."'");
            }else{
                $arr['username'] = $wxoauth['openid'];
                $arr['phone'] = '';
                $arr['address'] = '';
                $arr['password'] = md5($wxoauth['openid']);
                $arr['email'] = '';
                $arr['creattime'] = time();
                $arr['score'] = empty(Mysite::$app->config['regesterscore']) ? 0 :Mysite::$app->config['regesterscore'];
                $arr['logintime'] = time();
                $arr['loginip'] ='';
                $arr['group'] = 10;
                $arr['logo'] = $wxoauth['imgurl'];
                $arr['sex'] = $wxoauth['sex'];  //用户的性别，值为1时是男性，值为2时是女性，值为0时是未知
                $arr['uid'] = $oauthinfo['uid'];
                $newusername = $wxoauth['username'];
                $checkusername ='xxx';
                $k = 0;
                while(!empty($checkusername)){
                    $newusername = $k==0? $newusername:$newusername.$k;
                    $checkusername = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where username ='".$newusername."' ");
                    $k = $k+1;
                    if(empty($checkusername)){
                        break;
                    }
                }
                $arr['username'] = $newusername;
                $this->mysql->insert(Mysite::$app->config['tablepre']."member",$arr);
                $uid = $this->mysql->insertid();
                $userid = $uid;
            }
        }
        $data['userinfo'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid ='".$userid."' ");
        $this->success($data);
    }
    //获取用户信息
    public function getuserinfo(){
        $userid = intval(IReq::get('userid'));
        if(empty($userid)){
            $this->message("用户ID为空");
        }
        $data['userinfo'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid ='".$userid."' ");
        if(empty($data['userinfo'])){
            $this->message("用户不存在");
        }
        $this->success($data);
    }
    //获取openid
    public function getwxapi(){
        $code = IFilter::act(IReq::get('code'));
        $appid = IFilter::act(IReq::get('appid'));
        $secret = IFilter::act(IReq::get('secret'));
        $token_link = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
        $token =json_decode($this->curl_get_content($token_link), TRUE);
        if(isset($token['errcode'])){
            $this->message($token['errmsg']);
        }else{
            $data['openid'] = $token['openid'];
            $this->success($data);
        }
    }
    //搜索 商家和商品页面
    function search(){
        $data['searchwords'] = array();
        if(!empty(Mysite::$app->config['searchwords'])){
            $data['searchwords'] = unserialize(Mysite::$app->config['searchwords']);
        }
        $this->success($data);
    }

    //店铺列表数据
    function indexshoplistdata(){		// 首页获取附近商家列表（外卖和超市）
		$this->getOpenCity();
		$cxsignlist = $this->mysql->getarr("select `id`,`imgurl` from ".Mysite::$app->config['tablepre']."goodssign where type='cx' order by id desc limit 0, 100");
		$cxarray  =  array();
		foreach($cxsignlist as $key=>$value){
		   $cxarray[$value['id']] = $value['imgurl'];
		}
        $shopsearch = IFilter::act(IReq::get('searchname'));
        $shopsearch	= urldecode($shopsearch);
		$where = "  and admin_id=".$this->CITY_ID."   ";
        $pagesize = 30;
        if(!empty($shopsearch)){
            $where .= " and shopname like '%".$shopsearch."%' ";
            $pagesize = 100;
        }
		$lng = trim(IReq::get('lng'));
		$lat = trim(IReq::get('lat'));
        $lng = empty($lng)?0:$lng;
        $lat =empty($lat)?0:$lat;
		if( $this->is_pass_applet == 1 ){ 
			$where = empty($where)?'   and  SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradiusa`*0.01094-0.01094) ': $where.' and SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradiusa`*0.01094-0.01094) ';
		}
		$orderarray = array(
		'0' =>" (2 * 6378.137* ASIN(SQRT(POW(SIN(3.1415926535898*(".$lat."-lat)/360),2)+COS(3.1415926535898*".$lat."/180)* COS(lat * 3.1415926535898/180)*POW(SIN(3.1415926535898*(".$lng."-lng)/360),2))))*1000  ASC      ",		
	//	'0'=>'   sort asc      ',                       
		);
		/*获取店铺*/
		$pageinfo = new page();
		$pageinfo->setpage(intval(IReq::get('page')),$pagesize);
 		$where = Mysite::$app->config['plateshopid'] > 0? $where.' and  id != '.Mysite::$app->config['plateshopid'] .' ':$where;
        //获取营业中、休息中店铺
        $noopen=array();//休息中
        $open=array();//营业中
        $checkShop = $this->mysql->getarr("select `id`,`shoptype`,`shoplogo`,`is_open`,`starttime` from ".Mysite::$app->config['tablepre']."shop where is_pass = 1  and is_open = 1  and endtime > ".time()."  ".$where." order by ".$orderarray[0]." ");
        $nowhour = date('H:i:s',time());
        $nowhour = strtotime($nowhour);
        foreach($checkShop as $cp){
            if($cp['id'] > 0){
                if($cp['shoptype'] == 1 ){
                    $checkShopdet = $this->mysql->select_one("select `is_orderbefore` from ".Mysite::$app->config['tablepre']."shopmarket where  shopid = ".$cp['id']."   ");
                }else{
                    $checkShopdet = $this->mysql->select_one("select `is_orderbefore` from ".Mysite::$app->config['tablepre']."shopfast where  shopid = ".$cp['id']."   ");
                }
                if(!empty($checkShopdet)){
                    $cp = array_merge($cp,$checkShopdet);
                    $checkinfo = $this->shopIsopen($cp['is_open'],$cp['starttime'],$cp['is_orderbefore'],$nowhour);
                    if($checkinfo['opentype'] != 2 && $checkinfo['opentype'] != 3){
						if($cp['id']>0){
							$noopen[] = $cp['id'];
						}
                    }else{
						if($cp['id']>0){
							$open[] = $cp['id'];
						}
                    }
                }
            }
        }
        if(!empty($open)){
            $open = array_unique($open);
        }
        if(!empty($noopen)){
            $noopen = array_unique($noopen);
        }
        if(empty($open) && empty($noopen)){
            $newwhere = ' 1 = 2 ';
        }else{
            $newstrshopid= implode(",",array_merge($open,$noopen));
            $newwhere = ' and id in('.$newstrshopid.') order by field(id,'.$newstrshopid.')';
        }

     	 $tempdd = array();
		 $selectSql = "`shoplogo`,`id`,`shoptype`,`shopname`,`point`,`sellcount`,`is_open`,`starttime`,`lat`,`lng`,`virtualsellcounts`,`pointcount`";
		$tempdd[] =   $this->mysql->getarr("select ".$selectSql." from ".Mysite::$app->config['tablepre']."shop where is_pass = 1  and is_open = 1  and endtime > ".time()."  ".$newwhere." limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."  ");
		$templist = array();
		$cxclass = new sellrule();  
        foreach($tempdd as $kv=>$list){
          if(is_array($list)){
                foreach($list as $keys=>$values){
                        if($values['id'] > 0){
                             $templist111 = $this->mysql->getarr("select `type`,`id` from ".Mysite::$app->config['tablepre']."shoptype where cattype = ".$values['shoptype']." and  parent_id = 0    order by orderid asc limit 0,1000");
                             $attra = array();
                             $attra['input'] = 0;
                             $attra['img'] = 0;
                             $attra['checkbox'] = 0;
                             foreach($templist111 as $key=>$vall){
                                  if($vall['type'] == 'input'){
                                   $attra['input'] =  $attra['input'] > 0?$attra['input']:$vall['id'];
                                  }elseif($vall['type'] == 'img'){
                                     $attra['img'] =  $attra['img'] > 0?$attra['img']:$vall['id'];
                                  }elseif($vall['type'] == 'checkbox'){
                                    $attra['checkbox'] =  $attra['checkbox'] > 0?$attra['checkbox']:$vall['id'];
                                  }
                             }
                            $shopdetSql = "`arrivetime`,`limitcost`,`sendtype`,`pradiusvalue`,`pscost`,`is_orderbefore`,`postdate`";
                            if($values['shoptype'] == 1 ){
                                $shopdet = $this->mysql->select_one("select ".$shopdetSql." from ".Mysite::$app->config['tablepre']."shopmarket where  shopid = ".$values['id']."   ");
                            }else{
                                $shopdet = $this->mysql->select_one("select ".$shopdetSql." from ".Mysite::$app->config['tablepre']."shopfast where  shopid = ".$values['id']."   ");
                            }
                            if(!empty($shopdet)){
                                $values = array_merge($values,$shopdet);
                              $values['shoplogo'] = empty($values['shoplogo'])? Mysite::$app->config['imgserver'].Mysite::$app->config['shoplogo']:Mysite::$app->config['imgserver'].$values['shoplogo'];
                              $checkinfo = $this->shopIsopen($values['is_open'],$values['starttime'],$values['is_orderbefore'],$nowhour);
                              $values['opentype'] = $checkinfo['opentype'];
                              $values['newstartime'] = $checkinfo['newstartime'];
                              $attrdet = $this->mysql->getarr("select `firstattr`,`value` from ".Mysite::$app->config['tablepre']."shopattr where  cattype = ".$values['shoptype']." and shopid = ".$values['id']."");
                              $cxclass->setdata($values['id'],1000,$values['shoptype']);
                              $checkps = $this->pscost($values,$lng,$lat);
                              $values['pscost'] = $checkps['pscost'];
                              $mi = $this->GetDistance($lat,$lng, $values['lat'],$values['lng'], 1);
                              $mi = $mi > 1000? round($mi/1000,2).'km':$mi.'m';
                            $values['juli'] = $mi;
                            $shopcounts = $this->mysql->select_one( "select count(id) as shuliang  from ".Mysite::$app->config['tablepre']."order	 where  status = 3 and  shopid = ".$values['id']."" );
                            if(empty( $shopcounts['shuliang']  )){
                                $values['ordercount'] = 0;
                            }else{
                                $values['ordercount']  = $shopcounts['shuliang'];
                            }
                            $values['ordercount'] = intval($values['ordercount']+$values['virtualsellcounts']);
                            if($values['sendtype']==1){
                                $cxinfo = $this->mysql->getarr("select `name`,`id`,`imgurl` from ".Mysite::$app->config['tablepre']."rule where  FIND_IN_SET(".$values['id'].",shopid)   and status = 1 and controltype!=4 and ( limittype < 3  or ( limittype = 3 and endtime > ".time()." and starttime < ".time().")) ");
                            }else{
                                $cxinfo = $this->mysql->getarr("select `name`,`id`,`imgurl` from ".Mysite::$app->config['tablepre']."rule where  FIND_IN_SET(".$values['id'].",shopid)   and status = 1   and ( limittype < 3  or ( limittype = 3 and endtime > ".time()." and starttime < ".time().")) ");
                            }
                            $values['cxlist'] = array();
                            if(Mysite::$app->config['open_wxcx'] == 1 && !empty($cxinfo)){
                                foreach($cxinfo as $k1=>$v1){
                                    $v1['imgurl'] = Mysite::$app->config['imgserver'].$v1['imgurl'];
                                    $values['cxlist'][] = $v1;
                                }
                            }
                        $values['cxcount'] = count($values['cxlist']);
                        $values['checkcx'] = 0;
                        //可预订情况下第一个配送时间
                        $nowhout = strtotime(date('Y-m-d',time()));//当天最小linux 时间
                        $timelist = !empty($values['postdate'])?unserialize($values['postdate']):array();
                        $values['pstime'] = date('H:i',$nowhout+$timelist[0]['s']);
                        /* 店铺星级计算 */
                        $zongpoint = $values['point'];
                        $zongpointcount = $values['pointcount'];
                        if($zongpointcount != 0 ){
                            $shopstart = intval( round($zongpoint/$zongpointcount) );
                        }else{
                            $shopstart= 0;
                        }
                        $values['point'] = 	$shopstart;
                         $values['attrdet'] = array();
                          foreach($attrdet as $k=>$v){
                               if($v['firstattr'] == $attra['input']){
                                $values['attrdet']['input'] = $v['value'];
                               }elseif($v['firstattr'] == $attra['img']){
                                $values['attrdet']['img'][] = $v['value'];
                               }elseif($v['firstattr'] == $attra['checkbox']){
                                    $values['attrdet']['checkbox'][] = $v['value'];
                               }
                          }
                #		 print_r($values['attrdet']);
                          $templist[] = $values;
                        }
                    }
                }
           }
		}
		$data['shoplist']  = $templist;
        $data['psimg']  = Mysite::$app->config['imgserver'].Mysite::$app->config['psimg'];
        $data['shoppsimg']  = Mysite::$app->config['imgserver'].Mysite::$app->config['shoppsimg'];
        $this->success($data);
	}
    //通用带条件的店铺列表
    function shoplistdata(){
       /*  ini_set("display_errors", "On");
        error_reporting(E_ALL | E_STRICT); */
        $this->getOpenCity();
        $shopshowtype = IFilter::act(IReq::get('shoptype'));
        $cxsignlist = $this->mysql->getarr("select `id`,`imgurl` from ".Mysite::$app->config['tablepre']."goodssign where type='cx' order by id desc limit 0, 100");
        $cxarray  =  array();
        foreach($cxsignlist as $key=>$value){
            $cxarray[$value['id']] = $value['imgurl'];
        }
        $areaid= intval(IFilter::act(IReq::get('areaid')));
        $catid = intval(IReq::get('catid'));
        $order = intval(IReq::get('order'));
        $order = in_array($order,array(1,2,3))? $order:0;
        $qsjid = intval(IReq::get('qsjid'));
        $qsjid = in_array($qsjid,array(1,2,3))? $qsjid:0;
        $shopSql = "b.`shoplogo`,b.`id`,b.`shoptype`,b.`shopname`,b.`point`,b.`sellcount`,b.`is_open`,b.`starttime`,b.`lat`,b.`lng`,b.`virtualsellcounts`,b.`pointcount`";
        $shopdetSql = "a.`arrivetime`,a.`limitcost`,a.`sendtype`,a.`pradiusvalue`,a.`pscost`,a.`is_orderbefore`,a.`postdate`";
        $selectSql = $shopSql.",".$shopdetSql;
        if($shopshowtype == 'market'){
            $where = '';
            $shopsearch = IFilter::act(IReq::get('search_input'));
            $shopsearch = urldecode($shopsearch);
            if(!empty($shopsearch)) $where=" and b.shopname like '%".$shopsearch."%' ";

            //构造菜品查询
            $where2 = '';
            if($catid > 0) $where2 = 'where sh.second_id = '.$catid;
            $checkareaid = $areaid;
            if($checkareaid > 0) {
                $where2 = empty($where2) ?' where  ard.areaid = '.$checkareaid:$where2.' and  ard.areaid = '.$checkareaid;
                $where = empty($where2)? $where:$where." and b.id in(select ard.shopid from ".Mysite::$app->config['tablepre']."areashop as ard left join ".Mysite::$app->config['tablepre']."shopsearch  as sh  on ard.shopid = sh.shopid   ".$where2."  group by shopid  ) ";
            }else{
                $where = empty($where2)? $where:$where." and b.id in(select sh.shopid from  ".Mysite::$app->config['tablepre']."shopsearch  as sh    ".$where2."  group by shopid  ) ";
            }
            $lng = 0;
            $lat = 0;
            if($checkareaid > 0){
                $areainfo =    $this->mysql->select_one("select `lng`,`lat` from ".Mysite::$app->config['tablepre']."area where id=".$checkareaid."  ");
                if(!empty($areainfo)){
                    $lng = $areainfo['lng'];
                    $lat = $areainfo['lat'];

                }
            }else{
                $lng = IFilter::act(IReq::get('lng'));
                $lat = IFilter::act(IReq::get('lat'));
                $lng = empty($lng)?0:$lng;
                $lat =empty($lat)?0:$lat;
				if( $this->is_pass_applet == 1 ){ 
                    $where = empty($where)?'   and  SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradius`*0.01094-0.01094) ': $where.' and SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradius`*0.01094-0.01094) ';
				}
		   }

            $lng = trim($lng);
            $lat = trim($lat);
            $lng = empty($lng)?0:$lng;
            $lat =empty($lat)?0:$lat;
            $orderarray = array(
				'0' =>" (2 * 6378.137* ASIN(SQRT(POW(SIN(3.1415926535898*(".$lat."-lat)/360),2)+COS(3.1415926535898*".$lat."/180)* COS(lat * 3.1415926535898/180)*POW(SIN(3.1415926535898*(".$lng."-lng)/360),2))))*1000  ASC      ",		
								 //    '0'=>'  sort ASC       ',
				'1' =>" (2 * 6378.137* ASIN(SQRT(POW(SIN(3.1415926535898*(".$lat."-lat)/360),2)+COS(3.1415926535898*".$lat."/180)* COS(lat * 3.1415926535898/180)*POW(SIN(3.1415926535898*(".$lng."-lng)/360),2))))*1000  ASC      ",		
                '2'=>' limitcost asc     ',
                '3'=>' is_com desc '
            );
            $qsjarray = array(
                '0'=>'  ',
                '1'=>' and limitcost < 5  ',
                '2'=>' and limitcost >= 5 and limitcost <= 10 ',
                '3'=>' and limitcost > 10 '
            );
            $templist = $this->mysql->getarr("select `id`,`type` from ".Mysite::$app->config['tablepre']."shoptype where  cattype = 1 and parent_id = 0    order by orderid asc limit 0,1000");
            $attra['input'] = 0;
            $attra['img'] = 0;
            $attra['checkbox'] = 0;
            foreach($templist as $key=>$value){
                if($value['type'] == 'input'){
                    $attra['input'] =  $attra['input'] > 0?$attra['input']:$value['id'];
                }elseif($value['type'] == 'img'){
                    $attra['img'] =  $attra['img'] > 0?$attra['img']:$value['id'];
                }elseif($value['type'] == 'checkbox'){
                    $attra['checkbox'] =  $attra['checkbox'] > 0?$attra['checkbox']:$value['id'];
                }
            }
            /*获取店铺*/
            $pageinfo = new page();
            $pageinfo->setpage(intval(IReq::get('page')));
            $where .= $qsjarray[$qsjid];
            $where .= $qsjarray[$qsjid];
            $where .= "  and admin_id=".$this->CITY_ID."   ";
            $where .= ' and shoptype=1 ';
            $where = Mysite::$app->config['plateshopid'] > 0? $where.' and a.shopid != '.Mysite::$app->config['plateshopid'] .' ':$where;
            $temb = array();
            # $temb[] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopmarket as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where  b.is_pass = 1 and b.is_recom = 1 ".$where."    order by ".$orderarray[$order]." limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."");
            $temb[] = $this->mysql->getarr("select ".$selectSql." from ".Mysite::$app->config['tablepre']."shopmarket as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where  b.is_pass = 1  ".$where." order by ".$orderarray[$order]." limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."");
            
			
			 $nowhour = date('H:i:s',time());
			 $nowhour = strtotime($nowhour);
            //获取营业中、休息中店铺
            $noopen=array();//休息中
            $open=array();//营业中
			 foreach($temb as $kc=>$list){
				 if(is_array($list)){
					 foreach($list as $keys=>$values){
						 if($values['id'] > 0){
							 $checkinfo = $this->shopIsopen($values['is_open'],$values['starttime'],$values['is_orderbefore'],$nowhour);
							 if($checkinfo['opentype'] != 2 && $checkinfo['opentype'] != 3){
								 $values['opentype'] = '0';
								 $noopen[]=$values['id'];
							 }else{
								 $values['opentype'] = $checkinfo['opentype'];
								 $open[]=$values['id'];
							 }
						 }
					 }
				 }
			 }
            if(!empty($open)){
                $open = array_unique($open);
            }
            if(!empty($noopen)){
                $noopen = array_unique($noopen);
            }
            if(empty($open) && empty($noopen)){
                $newwhere = ' 1 = 2 ';
            }else{
                $newstrshopid= implode(",",array_merge($open,$noopen));
                $newwhere = ' and b.id in('.$newstrshopid.') order by field(b.id,'.$newstrshopid.')';
            }

				 

					//and b.is_recom != 1
				 $tembxxx[] = $this->mysql->getarr("select b.id,b.shopname,b.pointcount,b.point,b.starttime,b.is_open,b.shoplogo,b.shoptype,b.lng,b.lat,b.virtualsellcounts,a.arrivetime,a.limitcost,a.is_orderbefore,a.postdate,a.sendtype from ".Mysite::$app->config['tablepre']."shopmarket as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where  b.is_pass = 1  ".$where."   ".$newwhere."   limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."");
				
            	$nowhour = date('H:i:s',time());
                  $nowhour = strtotime($nowhour);
                  $templist = array();
                   $cxclass = new sellrule();  
			
			
            foreach($tembxxx as $kc=>$list){
                if(is_array($list)){
                    foreach($list as $keys=>$values){
                        if($values['id'] > 0){
                            $values['shoplogo'] = empty($values['shoplogo'])? Mysite::$app->config['imgserver'].Mysite::$app->config['shoplogo']:Mysite::$app->config['imgserver'].$values['shoplogo'];
                            $checkinfo = $this->shopIsopen($values['is_open'],$values['starttime'],$values['is_orderbefore'],$nowhour);
                            $values['opentype'] = $checkinfo['opentype'];
                            $values['newstartime']  =  $checkinfo['newstartime'];
                            $attrdet = $this->mysql->getarr("select `firstattr`,`value` from ".Mysite::$app->config['tablepre']."shopattr where  cattype = 1 and shopid = ".$values['id']."");
                            $cxclass->setdata($values['id'],1000,$values['shoptype']);
                            $checkps = $this->pscost($values,$lng,$lat);
                            $values['pscost'] = $checkps['pscost'];
                            $mi = $this->GetDistance($lat,$lng, $values['lat'],$values['lng'], 1);
                            $mi = $mi > 1000? round($mi/1000,2).'km':$mi.'m';
                            $values['juli'] = $mi;
                            $shopcounts = $this->mysql->select_one( "select count(id) as shuliang  from ".Mysite::$app->config['tablepre']."order	 where   status = 3 and  shopid = ".$values['id']."" );
                            #	print_r(  $shopcounts );
                            if(empty( $shopcounts['shuliang']  )){
                                $values['ordercount'] = 0;
                            }else{
                                $values['ordercount']  = $shopcounts['shuliang'];
                            }
                            $values['ordercount'] = $values['ordercount']+$values['virtualsellcounts'];
                            $cxinfo = $this->mysql->getarr("select `name`,`id`,`signid` from ".Mysite::$app->config['tablepre']."rule where  FIND_IN_SET(".$values['id'].",shopid)  and status = 1 and starttime  < ".time()." and endtime > ".time()." ");
                            $values['cxlist'] = array();
                            foreach($cxinfo as $k1=>$v1){
                                if(isset($cxarray[$v1['signid']])){
                                    $v1['imgurl'] = Mysite::$app->config['imgserver'].$cxarray[$v1['signid']];
                                    $values['cxlist'][] = $v1;
                                }
                            }
                            $values['cxcount'] = count($values['cxlist']);
                            $values['checkcx'] = 0;
                            //可预订情况下第一个配送时间
                            $nowhout = strtotime(date('Y-m-d',time()));//当天最小linux 时间
                            $timelist = !empty($values['postdate'])?unserialize($values['postdate']):array();
                            $values['pstime'] = date('H:i',$nowhout+$timelist[0]['s']);
                            /* 店铺星级计算 */
                            $zongpoint = $values['point'];
                            $zongpointcount = $values['pointcount'];
                            if($zongpointcount != 0 ){
                                $shopstart = intval( round($zongpoint/$zongpointcount) );
                            }else{
                                $shopstart= 0;
                            }
                            $values['point'] = 	$shopstart;
                            $values['attrdet'] = array();
                            foreach($attrdet as $k=>$v){
                                if($v['firstattr'] == $attra['input']){
                                    $values['attrdet']['input'] = $v['value'];
                                }elseif($v['firstattr'] == $attra['img']){
                                    $values['attrdet']['img'][] = $v['value'];
                                }elseif($v['firstattr'] == $attra['checkbox']){
                                    $values['attrdet']['checkbox'][] = $v['value'];
                                }
                            }
                            $templist[] = $values;
                        }
                    }
                }
            }
        }else{
            $where = '';
            $shopsearch = IFilter::act(IReq::get('search_input'));
            $shopsearch = urldecode($shopsearch);
            if(!empty($shopsearch)) $where=" and b.shopname like '%".$shopsearch."%' ";
            //构造菜品查询
            $where2 = '';
            if($catid > 0) $where2 = 'where sh.second_id = '.$catid;
            $checkareaid = $areaid;
            if($checkareaid > 0) {
                $where2 = empty($where2) ?' where  ard.areaid = '.$checkareaid:$where2.' and  ard.areaid = '.$checkareaid;
                $where = empty($where2)? $where:$where." and b.id in(select ard.shopid from ".Mysite::$app->config['tablepre']."areashop as ard left join ".Mysite::$app->config['tablepre']."shopsearch  as sh  on ard.shopid = sh.shopid   ".$where2."  group by shopid  ) ";
            }else{
                $where = empty($where2)? $where:$where." and b.id in(select sh.shopid from  ".Mysite::$app->config['tablepre']."shopsearch  as sh    ".$where2."  group by shopid  ) ";
            }
            $lng = 0;
            $lat = 0;
            if($checkareaid > 0){
                $areainfo =    $this->mysql->select_one("select `lng`,`lat` from ".Mysite::$app->config['tablepre']."area where id=".$checkareaid."  ");
                if(!empty($areainfo)){
                    $lng = $areainfo['lng'];
                    $lat = $areainfo['lat'];

                }
            }else{
                $lng = IFilter::act(IReq::get('lng'));
                $lat = IFilter::act(IReq::get('lat'));
                $lng = empty($lng)?0:$lng;
                $lat =empty($lat)?0:$lat;
				if( $this->is_pass_applet == 1 ){ 
                  $where = empty($where)?'   and  SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradius`*0.01094-0.01094) ': $where.' and SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradius`*0.01094-0.01094) ';
				}
			}
            $lng = trim($lng);
            $lat = trim($lat);
            $lng = empty($lng)?0:$lng;
            $lat =empty($lat)?0:$lat;
            $orderarray = array(
				'0' =>" (2 * 6378.137* ASIN(SQRT(POW(SIN(3.1415926535898*(".$lat."-lat)/360),2)+COS(3.1415926535898*".$lat."/180)* COS(lat * 3.1415926535898/180)*POW(SIN(3.1415926535898*(".$lng."-lng)/360),2))))*1000  ASC      ",		
				'1' =>" (2 * 6378.137* ASIN(SQRT(POW(SIN(3.1415926535898*(".$lat."-lat)/360),2)+COS(3.1415926535898*".$lat."/180)* COS(lat * 3.1415926535898/180)*POW(SIN(3.1415926535898*(".$lng."-lng)/360),2))))*1000  ASC      ",		
                '2'=>' limitcost asc ',
                '3'=>' is_com desc '
            );
            $qsjarray = array(
                '0'=>'  ',
                '1'=>' and limitcost < 5 ',
                '2'=>' and limitcost >= 5 and limitcost <= 10 ',
                '3'=>' and limitcost > 10 '
            );
            $templist = $this->mysql->getarr("select `id`,`type` from ".Mysite::$app->config['tablepre']."shoptype where  cattype = 0 and parent_id = 0 and is_main =1  order by orderid asc limit 0,1000");
            $attra['input'] = 0;
            $attra['img'] = 0;
            $attra['checkbox'] = 0;
            foreach($templist as $key=>$value){
                if($value['type'] == 'input'){
                    $attra['input'] =  $attra['input'] > 0?$attra['input']:$value['id'];
                }elseif($value['type'] == 'img'){
                    $attra['img'] =  $attra['img'] > 0?$attra['img']:$value['id'];
                }elseif($value['type'] == 'checkbox'){
                    $attra['checkbox'] =  $attra['checkbox'] > 0?$attra['checkbox']:$value['id'];
                }
            }
            /*获取店铺*/
            $pageinfo = new page();
            $pageinfo->setpage(intval(IReq::get('page')));
            $where .= $qsjarray[$qsjid];
            $tempwhere = $shopshowtype == 'dingtai'?' and is_goshop =1 ':' and is_waimai =1 ';
            $where .= " and shoptype =  0  ";

            $where .= "  and admin_id=".$this->CITY_ID."   ";

            $where = Mysite::$app->config['plateshopid'] > 0? $where.' and a.shopid != '.Mysite::$app->config['plateshopid'] .' ':$where;
           $teempd = array();
					$teempds = array();
            	 #   $teempd[] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where  b.is_pass = 1 and b.is_recom = 1  ".$tempwhere." ".$where."    order by ".$orderarray[$order]." limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."");
			//            	 and b.is_recom != 1


			 $teempds[] = $this->mysql->getarr("select a.is_orderbefore,b.is_open,b.starttime,b.id from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where  b.is_pass = 1  ".$tempwhere." ".$where."    order by ".$orderarray[0]." ");

			 $nowhour = date('H:i:s',time());
			 $nowhour = strtotime($nowhour);
            //获取营业中、休息中店铺
            $noopen=array();//休息中
            $open=array();//营业中
			 foreach($teempds as $kv=>$list){
				 if(is_array($list)){
					 foreach($list as $keys=>$values){
						 if($values['id'] > 0){
							 $values['shoplogo'] = empty($values['shoplogo'])? Mysite::$app->config['imgserver'].Mysite::$app->config['shoplogo']:Mysite::$app->config['imgserver'].$values['shoplogo'];
							 $checkinfo = $this->shopIsopen($values['is_open'],$values['starttime'],$values['is_orderbefore'],$nowhour);
							 if($checkinfo['opentype'] != 2 && $checkinfo['opentype'] != 3){
								 $values['opentype'] = '0';
								 $noopen[]=$values['id'];
							 }else{
								 $values['opentype'] = $checkinfo['opentype'];
								 $open[]=$values['id'];
							 }
						 }
					 }
				 }
			 }
			 if(!empty($open)){
                 $open = array_unique($open);
             }
            if(!empty($noopen)){
                $noopen = array_unique($noopen);
            }
			 if(empty($open) && empty($noopen)){
				 $newwheres = ' 1 = 2 ';
			 }else{
                 $newstrshopid= implode(",",array_merge($open,$noopen));
				 $newwheres = ' and b.id in('.$newstrshopid.') order by field(b.id,'.$newstrshopid.')';
			 }

				$teempdxxx[] = $this->mysql->getarr("select  b.id,b.shopname,b.pointcount,b.point,b.starttime,b.is_open,b.shoplogo,b.shoptype,b.lng,b.lat,b.virtualsellcounts,a.arrivetime,a.limitcost,a.is_orderbefore,a.postdate,a.sendtype from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where  b.is_pass = 1  ".$tempwhere."  ".$newwheres."    limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."");
				$nowhour = date('H:i:s',time());
                  $nowhour = strtotime($nowhour);
                  $templist = array();
                   $cxclass = new sellrule();  
            foreach($teempdxxx as $kv=>$list){
                if(is_array($list)){
                    foreach($list as $keys=>$values){

                        if($values['id'] > 0){
                            $values['shoplogo'] = empty($values['shoplogo'])? Mysite::$app->config['imgserver'].Mysite::$app->config['shoplogo']:Mysite::$app->config['imgserver'].$values['shoplogo'];
                            $checkinfo = $this->shopIsopen($values['is_open'],$values['starttime'],$values['is_orderbefore'],$nowhour);
                            $values['opentype'] = $checkinfo['opentype'];
                            $values['newstartime']  =  $checkinfo['newstartime'];
                            $attrdet = $this->mysql->getarr("select `firstattr`,`value` from ".Mysite::$app->config['tablepre']."shopattr where  cattype = 0 and shopid = ".$values['id']."");
                            $cxclass->setdata($values['id'],1000,$values['shoptype']);
                            $checkps = $this->pscost($values,$lng,$lat);
                            if( $shopshowtype == 'dingtai'){
                                $values['pscost'] =0;
                            }else{
                                $values['pscost'] = $checkps['pscost'];
                            }
                            $mi = $this->GetDistance($lat,$lng, $values['lat'],$values['lng'], 1);
                            $mi = $mi > 1000? round($mi/1000,2).'km':$mi.'m';
                            $values['juli'] = 		$mi;
                            $shopcounts = $this->mysql->select_one( "select count(id) as shuliang  from ".Mysite::$app->config['tablepre']."order	 where  status = 3 and  shopid = ".$values['id']."" );
                            if(empty( $shopcounts['shuliang']  )){
                                $values['ordercount'] = 0;
                            }else{
                                $values['ordercount']  = $shopcounts['shuliang'];
                            }
                            $values['ordercount'] = $values['ordercount']+$values['virtualsellcounts'];
                            $cxinfo = $this->mysql->getarr("select `name`,`id`,`signid` from ".Mysite::$app->config['tablepre']."rule where  FIND_IN_SET(".$values['id'].",shopid)   and status = 1 and starttime  < ".time()." and endtime > ".time()." ");
                            $values['cxlist'] = array();
                            foreach($cxinfo as $k1=>$v1){
                                if(isset($cxarray[$v1['signid']])){
                                    $v1['imgurl'] = Mysite::$app->config['imgserver'].$cxarray[$v1['signid']];
                                    $values['cxlist'][] = $v1;
                                }
                            }
                            $values['cxcount'] = count($values['cxlist']);
                            $values['checkcx'] = 0;
                            //可预订情况下第一个配送时间
                            $nowhout = strtotime(date('Y-m-d',time()));//当天最小linux 时间
                            $timelist = !empty($values['postdate'])?unserialize($values['postdate']):array();
                            $values['pstime'] = date('H:i',$nowhout+$timelist[0]['s']);
                            /* 店铺星级计算 */
                            $zongpoint = $values['point'];
                            $zongpointcount = $values['pointcount'];
                            if($zongpointcount != 0 ){
                                $shopstart = intval( round($zongpoint/$zongpointcount) );
                            }else{
                                $shopstart= 0;
                            }
                            $values['point'] = 	$shopstart;
                            $values['attrdet'] = array();
                            foreach($attrdet as $k=>$v){
                                if($v['firstattr'] == $attra['input']){
                                    $values['attrdet']['input'] = $v['value'];
                                }elseif($v['firstattr'] == $attra['img']){
                                    $values['attrdet']['img'][] = $v['value'];
                                }elseif($v['firstattr'] == $attra['checkbox']){
                                    $values['attrdet']['checkbox'][] = $v['value'];
                                }
                            }
                            $templist[] = $values;
                        }
                    }
                }
            }
        }

        $data['shopshowtype'] = $shopshowtype;
        $data['shoplist']  = $templist;
        $data['psimg']  = Mysite::$app->config['imgserver'].Mysite::$app->config['psimg'];
        $data['shoppsimg']  = Mysite::$app->config['imgserver'].Mysite::$app->config['shoppsimg'];
        $this->success($data);
    }

    //店铺分类列表
    function shoptypelist(){
        $this->getOpenCity();
        $shopshowtype = IFilter::act(IReq::get('shoptype'));
        if(!in_array($shopshowtype,array('waimai','market','dingtai'))){
            $shopshowtype = 'waimai';
        }
        $data['caipin'] = array();
        if($shopshowtype == 'market'){
            $cattype = 1;
        }else{
            $cattype = 0;
        }
        $templist = $this->mysql->select_one("select `id` from ".Mysite::$app->config['tablepre']."shoptype where  cattype = '".$cattype."' and parent_id = 0 and is_search = 1 and type ='checkbox'  order by orderid asc limit 0,1000");
        if(!empty($templist)){
            $data['caipin']  = $this->mysql->getarr("select `id`,`name` from ".Mysite::$app->config['tablepre']."shoptype where parent_id='".$templist['id']."'  ");
        }
        $this->success($data);
    }
    //店铺页面获取商品分类
    function shopgoodstype(){
        $shoptype = IFilter::act(IReq::get('shoptype'));
        $id = intval(IReq::get('id'));
        $cateid = intval(IReq::get('cateid'));
        $lng = IFilter::act(IReq::get('lng'));
        $lat = IFilter::act(IReq::get('lat'));
        $shopinfo = $this->mysql->select_one("select `id`,`is_open`,`starttime`,`lat`,`lng`,`goodlistmodule` from ".Mysite::$app->config['tablepre']."shop where id='".$id."' ");   //店铺基本信息
        if($shoptype == 1){
            $shopdet = $this->mysql->select_one("select `is_orderbefore`,`pradiusvalue`,`sendtype` from ".Mysite::$app->config['tablepre']."shopmarket where shopid='".$id."' ");
            $cateWhere = '';
            if($cateid > 0)$cateWhere .= ' and id = '.$cateid;
            $goodstype=  $this->mysql->getarr("select `id`,`name` from ".Mysite::$app->config['tablepre']."marketcate where shopid = ".$shopinfo['id']."   and parent_id = 0 ".$cateWhere." order by orderid asc");
            $newgoodstype = array();

            foreach($goodstype as $key=>$value){
                $soncatearray = $this->mysql->getarr("select `id`,`name` from ".Mysite::$app->config['tablepre']."marketcate where shopid = ".$id."   and parent_id = ".$value['id']."  order by orderid asc");
                $value['soncate']  = $soncatearray;
                $newgoodstype[] =$value;
            }
            $data['goodstype'] = $newgoodstype;
            $shopdet['id'] = $id;
            $shopdet['shoptype']=1;
            $newshoparray = array_merge($shopinfo,$shopdet);
            $tempinfo = $this->pscost($newshoparray,$lng,$lat);
            $data['shopinfo'] = $newshoparray;
            $backdata['pstype'] = $tempinfo['pstype'];
            $backdata['pscost'] = $tempinfo['pscost'];
            $data['psinfo'] = $backdata;
        }else{
            $shopdet = $this->mysql->select_one("select `is_orderbefore`,`pradiusvalue`,`sendtype` from ".Mysite::$app->config['tablepre']."shopfast where shopid='".$id."' ");
            $templist = $this->mysql->getarr("select `id`,`name` from ".Mysite::$app->config['tablepre']."goodstype  where shopid='".$id."' order by orderid asc  ");
            $newgoodstype = array();
            foreach($templist as $value){
                $value['soncate']  = array();
                $newgoodstype[] =$value;
            }
            $data['goodstype'] = $newgoodstype;
            $shopdet['id'] = $id;
            $shopdet['shoptype']=1;
            $newshoparray = array_merge($shopinfo,$shopdet);
            $tempinfo = $this->pscost($newshoparray,$lng,$lat);
            $data['shopinfo'] = $newshoparray;
            $backdata['pstype'] = $tempinfo['pstype'];
            $backdata['pscost'] = $tempinfo['pscost'];
            $data['psinfo'] = $backdata;
        }
        $this->success($data);
    }

    //店铺页面获取分类商品列表
    function catefoods(){
        $weekji = date('w');
        $shopid = intval( IFilter::act(IReq::get('shopid')) ) ;
        $curcateid = intval( IFilter::act(IReq::get('curcateid')) ) ;
        $shoptype = intval( IFilter::act(IReq::get('shoptype')) ) ;
        $shopinfo = $this->mysql->select_one("select `id`,`is_open`,`starttime`,`shoplogo`,`goodattrdefault` from ".Mysite::$app->config['tablepre']."shop where id=".$shopid." ");
        if($shoptype == 1 ){
            $cateinfo = $this->mysql->getarr("select `id`,`parent_id`,`name` from ".Mysite::$app->config['tablepre']."marketcate where id = ".$curcateid." and shopid = ".$shopid." ");
            $shopdet = $this->mysql->select_one("select `is_orderbefore`,`limitcost` from ".Mysite::$app->config['tablepre']."shopmarket where shopid = ".$shopinfo['id']." ");
        }else{
            $cateinfo = $this->mysql->getarr("select `id`,`name` from ".Mysite::$app->config['tablepre']."goodstype where id = ".$curcateid." ");
            $shopdet = $this->mysql->select_one("select `is_orderbefore`,`limitcost` from ".Mysite::$app->config['tablepre']."shopfast where shopid = ".$shopinfo['id']." ");
        }
        $nowhour = date('H:i:s',time());
        $nowhour = strtotime($nowhour);
        $checkinfo = $this->shopIsopen($shopinfo['is_open'],$shopinfo['starttime'],$shopdet['is_orderbefore'],$nowhour);
        $data['opentype'] = $checkinfo['opentype'];
        $newcateinfo = array();
        $goodsSelect = "`id`,`is_cx`,`cost`,`img`,`goodattr`,`descgoods`,`sellcount`,`virtualsellcount`,`name`,`have_det`,`count`,`bagcost`";
        if(isset($cateinfo[0]['parent_id']) && $cateinfo[0]['parent_id'] == 0){
            $soncate = $this->mysql->getarr("select `id`,`parent_id`,`name` from ".Mysite::$app->config['tablepre']."marketcate where parent_id = ".$cateinfo[0]['id']." and shopid = ".$shopid." ");
            if(!empty($soncate)){
                foreach($soncate as $vv){
                    $catefoodslist = array();
                    $detaa = $this->mysql->getarr("select ".$goodsSelect." from ".Mysite::$app->config['tablepre']."goods where typeid='".$vv['id']."' and is_waisong = 1 and shopid = ".$shopid." and  FIND_IN_SET( ".$weekji." , `weeks` )  and is_live = 1  order by good_order asc  ");
                    foreach ( $detaa as $valq ){
                        if($valq['is_cx'] == 1){
                            //测算促销 重新设置金额
                            $cxdata = $this->mysql->select_one("select `cxstarttime`,`ecxendttime`,`cxetime1`,`cxzhe`,`cxstime2`,`cxnum` from ".Mysite::$app->config['tablepre']."goodscx where goodsid=".$valq['id']."  ");
                            $newdata = getgoodscx($valq['cost'],$cxdata);
                            $valq['zhekou'] = $newdata['zhekou'];
                            $valq['is_cx'] = $newdata['is_cx'];
                            $valq['cost'] = $newdata['cost'];
                            $valq['cxnum'] = $cxdata['cxnum'];
                        }
                        $valq['shoplogo']  = Mysite::$app->config['imgserver'].$shopinfo['shoplogo'];
                        $valq['img'] = empty($valq['img'])? Mysite::$app->config['imgserver'].$shopinfo['shoplogo']:Mysite::$app->config['imgserver'].$valq['img'];
                        $valq['goodattr'] = empty($valq['goodattr'])? $shopinfo['goodattrdefault']:$valq['goodattr'];
                        $valq['descgoods'] = empty($valq['descgoods'])? '':$valq['descgoods'];
                        $valq['sellcount'] = $valq['sellcount']+$valq['virtualsellcount'];
                        $valq['cartnum'] = 0;
                        $catefoodslist[] =$valq;
                    }
                    $vv['goodslist'] = $catefoodslist;
                    $newcateinfo[] = $vv;
                }
            }
        }else{
            foreach($cateinfo as $item){
                $catefoodslist = array();
                $detaa = $this->mysql->getarr("select ".$goodsSelect." from ".Mysite::$app->config['tablepre']."goods where typeid='".$curcateid."' and is_waisong = 1 and shopid = ".$shopid." and    FIND_IN_SET( ".$weekji." , `weeks` )  and is_live = 1  order by good_order asc  ");
                foreach ( $detaa as $keyq=>$valq ){
                    if($valq['is_cx'] == 1){
                        //测算促销 重新设置金额
                        $cxdata = $this->mysql->select_one("select `cxstarttime`,`ecxendttime`,`cxetime1`,`cxzhe`,`cxstime2`,`cxnum` from ".Mysite::$app->config['tablepre']."goodscx where goodsid=".$valq['id']."  ");
                        $newdata = getgoodscx($valq['cost'],$cxdata);
                        $valq['zhekou'] = $newdata['zhekou'];
                        $valq['is_cx'] = $newdata['is_cx'];
                        $valq['cost'] = $newdata['cost'];
                        $valq['cxnum'] = $cxdata['cxnum'];
                    }
                    $valq['shoplogo']  = Mysite::$app->config['imgserver'].$shopinfo['shoplogo'];
                    $valq['img'] = empty($valq['img'])? Mysite::$app->config['imgserver'].$shopinfo['shoplogo']:Mysite::$app->config['imgserver'].$valq['img'];
                    $valq['goodattr'] = empty($valq['goodattr'])? $shopinfo['goodattrdefault']:$valq['goodattr'];
                    $valq['descgoods'] = empty($valq['descgoods'])? '':$valq['descgoods'];
                    $valq['sellcount'] = $valq['sellcount']+$valq['virtualsellcount'];
                    $valq['cartnum'] = 0;
                    $catefoodslist[] =$valq;
                }
                $item['goodslist'] = $catefoodslist;
                $newcateinfo[] = $item;
            }
        }

        $data['shopdet'] = $shopdet;
        $data['catefoodslist'] = $newcateinfo;
        $this->success($data);
    }

    //获取规格商品的规格信息
    function foodsgg(){
        $id = intval( IReq::get('id') );
        $attrid =  IReq::get('attrid');
        $foodshow = $this->mysql->select_one( "select `img`,`product_attr`,`is_cx`,`id`,`name`,`bagcost` from  ".Mysite::$app->config['tablepre']."goods where id= ".$id."  " );
        $foodshow['img'] = empty($foodshow['img'])? '':Mysite::$app->config['imgserver'].$foodshow['img'];
        $data['foodshow']  = $foodshow;
        $productinfo = !empty($foodshow)?unserialize($foodshow['product_attr']):array();
        $choiceattr = array();
        $newproductinfo = array();
        $choiceinfo = array(
              'id'=> 0,
              'goodsid'=> 0,
              'attrids'=> '',
              'cost'=> 0,
              'stock'=> 0,
              'attrname'=> ''
        );
        $data['chekcstr'] = '';
        if(!empty($productinfo)){
            foreach($productinfo as $values){
                foreach($values['det'] as $kk=>$vv){
                    if($kk == 0){
                        $choiceattr[] = $vv['id'];
                    }
                }
            }
            sort($choiceattr);
            $tempid = implode(',',$choiceattr);
            $productlist = $this->mysql->select_one("select `id`,`goodsid`,`cost`,`attrids`,`cost`,`stock`,`attrname` from ".Mysite::$app->config['tablepre']."product where goodsid=".$id."  and  `attrids` =  '".$tempid."'");
            if(!empty($productlist)){
                if($foodshow['is_cx'] == 1){
                    //测算促销 重新设置金额
                    $cxdata = $this->mysql->select_one("select `cxstarttime`,`ecxendttime`,`cxetime1`,`cxzhe`,`cxstime2`,`cxnum` from ".Mysite::$app->config['tablepre']."goodscx where goodsid=".$foodshow['id']."  ");
                    $newdata = getgoodscx($productlist['cost'],$cxdata);
                    $productlist['zhekou'] = $newdata['zhekou'];
                    $productlist['is_cx'] = $newdata['is_cx'];
                    $productlist['oldcost'] = $productlist['cost'];
                    $productlist['cost'] = $newdata['cost'];
                    $productlist['cxnum'] = $cxdata['cxnum'];
                }
                $choiceinfo = $productlist;
            }
            $attrid = empty($attrid) ? $tempid : $attrid;
            $data['chekcstr'] = $attrid;

            $checkattr = explode(',',$attrid);
            foreach($productinfo as $value){
                if(!empty($value['det']) && !empty($attrid)){
                    $newdet = array();
                    foreach($value['det'] as $val){
                        if(in_array($val['id'],$checkattr)){
                            $val['check'] = 1;
                        }else{
                            $val['check'] = 0;
                        }
                        $newdet[] = $val;
                        $value['det'] = $newdet;
                    }
                }
                $newproductinfo[] =  $value;
            }
        }
        $data['choiceinfo'] = $choiceinfo;
        $data['productinfo'] = $newproductinfo;

        $this->success($data);
    }
    //点击规格获取商品属性
    function doselectproduct(){
        $goods_id = intval(IReq::get('goodsid'));
        $ggdetid =  trim(IReq::get('ggdetid'));//点击规格的id
        $attrids =  IReq::get('attrid');//上次选中的规格id集
        $mainid =  IReq::get('mainid');//点击规格的上级ID
        if(empty($ggdetid) || empty($mainid)) $this->message("请选择规格");
        $foodshow = $this->mysql->select_one( "select `img`,`product_attr`,`is_cx`,`id`,`name`,`bagcost` from  ".Mysite::$app->config['tablepre']."goods where id= ".$goods_id."  " );
        $foodshow['img'] = empty($foodshow['img'])? '':Mysite::$app->config['imgserver'].$foodshow['img'];
        $data['foodshow']  = $foodshow;
        $productinfo = !empty($foodshow)?unserialize($foodshow['product_attr']):array();
        $mainarr = array();
        if(!empty($productinfo)){
            foreach($productinfo as $vp){
                if($mainid == $vp['id']){
                    foreach($vp['det'] as $itt){
                        if($itt['id'] != $ggdetid){
                            $mainarr[] = $itt['id'];
                        }
                    }
                }
            }
        }else{
            $this->message("规格商品不存在");
        }
        $newcheck = array();
        if(!empty($attrids)){
            $attrArr = explode(',',$attrids);
            foreach($attrArr as $item){
                if(!in_array($item,$mainarr)){
                    $newcheck[] = $item;
                }
            }
        }
        $newcheck[] = $ggdetid;
        $newcheckstr = implode(',',$newcheck);
        $data['chekcstr'] = $newcheckstr;

        $ggdetids = explode(',',$newcheckstr);
        sort($ggdetids);
        $tempid = implode(',',$ggdetids);
        $productlist = $this->mysql->select_one("select `id`,`goodsid`,`cost`,`attrids`,`cost`,`stock`,`attrname` from ".Mysite::$app->config['tablepre']."product where goodsid=".$goods_id."  and  `attrids` =  '".$tempid."'");
        if(!empty($productlist)){
            if($foodshow['is_cx'] == 1){
                //测算促销 重新设置金额
                $cxdata = $this->mysql->select_one("select `cxstarttime`,`ecxendttime`,`cxetime1`,`cxzhe`,`cxstime2`,`cxnum` from ".Mysite::$app->config['tablepre']."goodscx where goodsid=".$foodshow['id']."  ");
                $newdata = getgoodscx($productlist['cost'],$cxdata);
                $productlist['zhekou'] = $newdata['zhekou'];
                $productlist['is_cx'] = $newdata['is_cx'];
                $productlist['oldcost'] = $productlist['cost'];
                $productlist['cost'] = $newdata['cost'];
                $productlist['cxnum'] = $cxdata['cxnum'];
            }
            $data['productlist'] = $productlist;
        }else{
            $data['productlist'] = '';
        }

        $newproductinfo = array();
        if(!empty($productinfo)){
            foreach($productinfo as $value){
                if(!empty($value['det']) && !empty($newcheck)){
                    $newdet = array();
                    foreach($value['det'] as $val){
                        if(in_array($val['id'],$newcheck)){
                            $val['check'] = 1;
                        }else{
                            $val['check'] = 0;
                        }
                        $newdet[] = $val;
                        $value['det'] = $newdet;
                    }
                }
                $newproductinfo[] =  $value;
            }
        }
        $data['productinfo'] = $newproductinfo;
        $this->success($data);
    }

    //店铺评价页面
    function getshopcomment(){
        $shopid = IFilter::act(IReq::get('shopid'));
        $shopinfo = $this->mysql->select_one("select *  from  ".Mysite::$app->config['tablepre']."shop  where id = ".$shopid." ");

        if(empty($shopinfo)) $this->message('获取店铺数据失败');
        $data['collect'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."collect where  collecttype = 0 and uid = ".$this->member['uid']." and collectid  = '".$shopinfo['id']."' ");//收藏

        if( $shopinfo['pointcount'] != 0){
            $zongtistart = round( $shopinfo['point']/$shopinfo['pointcount'] ); // 总体评分  // 12 / 3 = 54
            $zonghefen = round( $shopinfo['point']/$shopinfo['pointcount'],1 ); // 综合评分
        }else{
            $zongtistart = 0;
            $zonghefen = 0;
        }
        if( $shopinfo['pointcount'] != 0){
            $psfuwustart = round( $shopinfo['psservicepoint']/$shopinfo['psservicepointcount'] ); // 配送服务
        }else{
            $psfuwustart = 0;
        }
        $data['zonghefen'] = $zonghefen;
        $data['zongtistart'] = $zongtistart > 5 ? 5 : $zongtistart;
        $data['psfuwustart'] = $psfuwustart > 5 ? 5 : $psfuwustart;
        $this->success($data);
    }
    //评价页面获取评价列表
    function getshopmorecomment(){
        $shopid = IFilter::act(IReq::get('shopid'));
        $goodid = IFilter::act(IReq::get('goodid'));

        $pageinfo = new page();
        $pageinfo->setpage(intval(IReq::get('page')),10);
        if( !empty($goodid) ){
            $temparray = $this->mysql->getarr("select * from  ".Mysite::$app->config['tablepre']."comment where  shopid=".$shopid." and is_show = 0 and goodsid = ".$goodid." order by addtime desc  limit ".$pageinfo->startnum().", ".$pageinfo->getsize()." ");
        }else{
            $temparray = $this->mysql->getarr("select * from  ".Mysite::$app->config['tablepre']."comment where  shopid=".$shopid." and is_show = 0 order by addtime desc  limit ".$pageinfo->startnum().", ".$pageinfo->getsize()." ");
        }
        $commentlist = array();
        foreach($temparray as $key=>$value){
            $memberinfo = $this->mysql->select_one("select * from  ".Mysite::$app->config['tablepre']."member where uid = ".$value['uid']." ");
            $goodinfo = $this->mysql->select_one("select * from  ".Mysite::$app->config['tablepre']."goods where id = ".$value['goodsid']." ");
            if(empty($goodinfo)){
                $goodinfo = $this->mysql->select_one("select * from  ".Mysite::$app->config['tablepre']."product where goodsid  = ".$value['goodsid']." ");
                $value['goodname'] =$goodinfo['goodsname'];
            }else{
                $value['goodname'] =$goodinfo['name'];
            }
            $value['username'] =$memberinfo['username'];

            if( !empty($value['virtualname']) ){
                $value['username'] = $value['virtualname'];
                $goodsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods   where id = '".$value['goodsid']."'   ");
                if( empty($goodsinfo) ){
                    $goodsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."product   where goodsid = '".$value['goodsid']."'   ");
                    $value['goodsname'] = $goodsinfo['goodsname'].'【刷】';
                }else{
                    $value['goodsname'] = $goodsinfo['name'].'【刷】';
                }
            }

            $value['point'] = ceil($value['point']);
            $value['userlogo'] =$memberinfo['logo'];
            $value['goodpoint'] =$goodinfo['point'];
            $value['addtime'] = date('Y-m-d H:i',$value['addtime']);
            $value['huifutime'] = date('Y-m-d H:i',$value['replytime']);
            $commentlist[] = $value;
        }
        $data['commentlist'] = $commentlist;
        $this->success($data);
    }

    //商家页面
    function getdetailinfo(){
        $shopid = IFilter::act(IReq::get('shopid'));
        $lng = IFilter::act(IReq::get('lng'));
        $lat = IFilter::act(IReq::get('lat'));
        $shopinfo = $this->mysql->select_one("select *  from  ".Mysite::$app->config['tablepre']."shop  where id = ".$shopid." ");
        if(empty($shopinfo)) $this->message('获取店铺数据失败');
        if(empty($shopinfo['intr_info'])) $shopinfo['intr_info'] = '暂无说明';
		$shopinfo['shoplogo'] = Mysite::$app->config['siteurl'].$shopinfo['shoplogo'];
        $data['collect'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."collect where  collecttype = 0 and uid = ".$this->member['uid']." and collectid  = '".$shopinfo['id']."' ");//收藏
        $shopreal = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopreal where  shopid = ".$shopid." limit 0,4");//商家实景分类
        $data['shopreal']=array();
        foreach($shopreal as $key=>$val){
            $shoprealimg = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoprealimg where  parent_id = ".$val['id']);//商家实景分类图片
            $imgcount = $this->mysql->select_one("select count(id) as count from ".Mysite::$app->config['tablepre']."shoprealimg where  parent_id = ".$val['id']);//商家实景分类图片总数
            $val['shoprealimg']=$shoprealimg;
            $val['imgcount']=$imgcount['count'];
            $data['shopreal'][]=$val;
        }
        $shopshowtype = $shopinfo['shoptype'];
        if( $shopshowtype == 1 ){
            $shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where a.shopid = ".$shopid."   ");
        }else{
            $shopdet  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where a.shopid = ".$shopid."   ");
        }
        /* 店铺星级计算 */
        $zongpoint = $shopinfo['point'];
        $zongpointcount = $shopinfo['pointcount'];
        if($zongpointcount != 0 ){
            $shopstart = intval( round($zongpoint/$zongpointcount) );
        }else{
            $shopstart= 0;
        }
        $cxsignlist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodssign where type='cx' order by id desc limit 0, 100");
        $cxarray  =  array();
        foreach($cxsignlist as $key=>$value){
            $cxarray[$value['id']] = $value['imgurl'];
        }
        $cxinfo = $this->mysql->getarr("select name,id,signid from ".Mysite::$app->config['tablepre']."rule where   shopid = ".$shopinfo['id']." and status = 1 and starttime  < ".time()." and endtime > ".time()." ");
        $cxlist = array();
        foreach($cxinfo as $k1=>$v1){
            if(isset($cxarray[$v1['signid']])){
                $v1['imgurl'] = $cxarray[$v1['signid']];
                $cxlist[] = $v1;
            }
        }
        $data['cxlist'] = $cxlist;
        $newshoparray = array_merge($shopinfo,$shopdet);
        $tempinfo = $this->pscost($newshoparray,$lng,$lat);
        $backdata['pstype'] = $tempinfo['pstype'];
        $backdata['pscost'] = $tempinfo['pscost'];
        $data['psinfo'] = $backdata;
        $data['shopstart'] = $shopstart;
        $data['shopinfo'] = $shopinfo;
        $data['shopdet'] = $shopdet;
        $this->success($data);
    }
    //计算配送费
    function pscost($shopinfo,$newlng,$newlat){
        $backdata = array('pscost'=>0,'pstype'=>0,'canps'=>0,'juli'=>0);
        if( $shopinfo['sendtype'] == 1 ){
            $pradiusvalue =  unserialize($shopinfo['pradiusvalue']);
        }else{
            $pradiusvalue = unserialize($this->platpssetinfo['radiusvalue']);
        }

        $shoplat = isset($shopinfo['lat'])?$shopinfo['lat']:0;
        $shoplng = isset($shopinfo['lng'])?$shopinfo['lng']:0;
        $juli =  $this->GetDistance($newlat,$newlng, $shoplat,$shoplng, 1);
        $juliceshi = intval($juli/1000);
        $backdata['juli'] = $juliceshi.'Km';
        if(is_array($pradiusvalue)){
            foreach($pradiusvalue as $key=>$value){
                if($juliceshi == $key){
                    $backdata['pscost'] = $value;
                    $backdata['canps'] = 1;
                }
            }
        }

        $backdata['pstype'] = $shopinfo['sendtype'];
        $checkpstype = Mysite::$app->config['psbopen'];
        if($shopinfo['sendtype'] == 2){
            $backdata['pstype'] =$checkpstype == 1? 2:0;
        }
        return $backdata;
    }

    //我的收获地址
    function address(){
        $userid = IFilter::act(IReq::get('userid'));
        $shopid = IFilter::act(IReq::get('shopid'));
        $area = IFilter::act(IReq::get('area'));
        $minit = IReq::get('minit');
        $tarelist = $this->mysql->getarr("select `default`,`lng`,`lat`,`contactname`,`phone`,`bigadr`,`detailadr`,`tag`,`id`,`address` from ".Mysite::$app->config['tablepre']."address where userid='".$userid."' order by id asc limit 0,50");
        $defaultmsg = null;
        $shopinfo = null;
        $data['open_acout'] = Mysite::$app->config['open_acout'];
        $data['is_daopay'] = Mysite::$app->config['is_daopay'];
        $data['downcost'] = 0;
        $data['addpscost'] = 0;

        if(!empty($shopid)){
            $this->getOpenCity();
            $shopinfo = $this->mysql->select_one("select `id`,`shoptype`,`shopname`,`lat`,`lng`,`starttime` from ".Mysite::$app->config['tablepre']."shop where  id ='".$shopid."'   ");
            if( !empty($shopinfo) ){
                if( $shopinfo['shoptype'] == 1){
                    $shopdet = $this->mysql->select_one("select `is_orderbefore`,`postdate`,`befortime`,`sendtype`,`pradiusvalue` from ".Mysite::$app->config['tablepre']."shopmarket where  shopid ='".$shopinfo['id']."'   ");
                }else{
                    $shopdet = $this->mysql->select_one("select `is_orderbefore`,`postdate`,`befortime`,`sendtype`,`pradiusvalue` from ".Mysite::$app->config['tablepre']."shopfast where  shopid ='".$shopinfo['id']."'   ");
                }
            }
            if( !empty($shopdet)){
                $shopinfo = array_merge($shopinfo,$shopdet);
            }

            $cxclass = new sellrule();
            $platform = 2;//微信
            $paytype = IReq::get('paytype');
            $cartcost = IReq::get('cartcost');
            $cartcost = isset($cartcost)?$cartcost:0;
            if(!isset($paytype)){
                if($data['open_acout'] == 1){
                    $paytype = 1;
                }else{
                    if($data['is_daopay'] == 1){
                        $paytype = 0;
                    }
                }
            }
            $cxclass->setdata($shopid,$cartcost,$shopinfo['shoptype'],$userid,$platform,$paytype);
            $cxinfo = $cxclass->getdata();
            $data['surecost'] = $cxinfo['surecost'];
            $data['downcost'] = $cxinfo['downcost'];


            $nowhout = strtotime(date('Y-m-d',time()));//当天最小linux 时间
            $timelist = !empty($shopinfo['postdate'])?unserialize($shopinfo['postdate']):array();
            $data['timelist'] = array();
            $datatimelist = array();
            $checknow = time();
            $whilestatic = $shopinfo['befortime'];
            $nowwhiltcheck = 0;
            while($whilestatic >= $nowwhiltcheck){
                $startwhil = $nowwhiltcheck*86400;
                foreach($timelist as $key=>$value){
                    $stime = $startwhil+$nowhout+$value['s'];
                    $etime = $startwhil+$nowhout+$value['e'];
                    if($etime  > $checknow){
                        $tempt = array();
                        $tempt['value'] = $value['s']+$startwhil;
                        $tempt['s'] = date('H:i',$nowhout+$value['s']);
                        $tempt['e'] = date('H:i',$nowhout+$value['e']);
                        $tempt['d'] = date('Y-m-d',$stime);
                        $tempt['i'] =  $value['i'];
                        $tempt['cost'] =  isset($value['cost'])?$value['cost']:'0';
                        $tempt['name'] = $tempt['s'].'-'.$tempt['e'];
                        $datatimelist[] = $tempt;
                    }
                }
                $nowwhiltcheck = $nowwhiltcheck+1;
            }
           if(!empty($datatimelist)){
               foreach($datatimelist as $k=>$v){
                   if($k == 0){
                       $v['name']='立即配送';
                   }
                   $data['timelist'][]=$v;
               }
           }

            $score = intval(IReq::get('score'));
            $scoretocost = Mysite::$app->config['scoretocost'];
            $data['scorelist'] = array(array('name'=>'不使用积分抵扣','cost'=>0));
            if($score > 0 && $scoretocost > 0 && $data['surecost'] > 0){
                $rslt = $score/$scoretocost;
                $cancost = $data['surecost'] > $rslt ? $rslt:$data['surecost'];
                for($i = 1;$i <= $cancost;$i++){
                    $newScroe = array();
                    $jifenall = $scoretocost * $i;
                    $newScroe['name'] = '使用'.$jifenall.'积分抵扣'.$i.'元';
                    $newScroe['cost'] = $i;
                    $data['scorelist'][] = $newScroe;
                }
            }

            if(!empty($tarelist)){
                foreach($tarelist as $value){
                    if($value['default'] == 1){
                        $psdata = $this->pscost($shopinfo,$value['lng'],$value['lat']);
                        $value['canps'] = $psdata['canps'];
                        $value['pscost'] = $cxinfo['nops'] == true ? 0 : $psdata['pscost'];
                        $value['pscost'] = $psdata['pscost'];
                        $defaultmsg = $value;
                    }
                }
            }


            if(!empty($minit)){
                $tempdata = $this->getOpenPosttime($shopinfo['is_orderbefore'],$shopinfo['starttime'],$shopinfo['postdate'],$minit,$shopinfo['befortime']);
                $data['addpscost'] = $tempdata['cost'];
            }else{
                if(!empty($data['timelist'])){
                    $tempdata = $this->getOpenPosttime($shopinfo['is_orderbefore'],$shopinfo['starttime'],$shopinfo['postdate'],$data['timelist'][0]['value'],$shopinfo['befortime']);
                    $data['addpscost'] = $tempdata['cost'];
                }
            }
        }
        $data['citylist'] = array();
        if($area == 1){
            $citylist = $this->mysql->getarr("select `name`,`adcode` from ".Mysite::$app->config['tablepre']."area where  id > 0 and parent_id = 0  ");
            if(!empty($citylist)){
                foreach($citylist as $ct){
                    $searchLink = Mysite::$app->config['map_comment_link'].'restapi.amap.com/v3/geocode/geo?address='.$ct['name'].'&city='.$ct['adcode'].'&output=json&key='.Mysite::$app->config['map_webservice_key'];
                    $result =json_decode($this->curl_get_content($searchLink), TRUE);
                    $ct['location'] = '';
                    if($result['status'] == 1 && $result['info'] == 'OK'){
                        $ct['location'] = $result['geocodes'][0]['location'];
                    }
                    $data['citylist'][] = $ct;
                }
            }
        }

        $data['psimg']  = Mysite::$app->config['imgserver'].Mysite::$app->config['psimg'];
        $data['shoppsimg']  = Mysite::$app->config['imgserver'].Mysite::$app->config['shoppsimg'];
        $default_cityid = Mysite::$app->config['default_cityid'];
        $data['default_cityid'] = empty($default_cityid) ? 0 : $default_cityid;
        $data['shopinfo'] = $shopinfo;
        $data['arealist'] = $tarelist;
        $data['defaultmsg'] = $defaultmsg;
        $this->success($data);
    }
    //获取单个地址信息
    function oneAddress(){
        $addressid = intval(IReq::get('id'));
        if(empty($addressid)) $this->message('地址ID为空');
        $data['info'] = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."address where id='".$addressid."' order by id asc limit 0,50");
        $this->success($data);
    }
    //获取城市adcode
    function getadcode(){
        $lng = IReq::get('lng');
        $lat = IReq::get('lat');
        if(empty($lng) || empty($lat)) $this->message('坐标错误');
        $location = $lng.','.$lat;
        $searchLink = Mysite::$app->config['map_comment_link'].'restapi.amap.com/v3/geocode/regeo?key='.Mysite::$app->config['map_webservice_key'].'&location='.$location.'&output=json&radius=1000&extensions=all';
        $result =json_decode($this->curl_get_content($searchLink), TRUE);
        if(!empty($result['regeocode'])){
            $adcode = $result['regeocode']['addressComponent']['adcode'];
            $address = $result['regeocode']['addressComponent']['building']['name'];
            if( empty($address) ){
                $address = $result['regeocode']['pois'][0]['name'];
                if( empty($address) ){
                    $address = $result['regeocode']['addressComponent']['district'].$result['regeocode']['addressComponent']['township'];
                    if( empty($address) ){
                        $address = $result['regeocode']['formatted_address'];
                    }
                }
            }
        }else{
            $adcode = 410100;
            $address = '电子商务产业园(郑州高新区)';
        }

        if( !empty($adcode) ){
            $areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  ");
            if( !empty($areacodeone) ){
                $adcodeid = $areacodeone['id'];
                $pid = $areacodeone['pid'];
                $areainfoone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  ");
                if( !empty($areainfoone) ){
                    $adcode = $areainfoone['adcode'];
                }
            }
        }
        $data['info']['adcode'] = $adcode;
        $data['info']['address'] = $address;
        $this->success($data);
    }
    //搜索地址
    function searchAddress(){
        $searchval = IFilter::act(IReq::get('searchval'));
        $cityname = IFilter::act(IReq::get('cityname'));
        $cityname = empty($cityname) ? Mysite::$app->config['CITY_NAME'] : $cityname;
        $searchLink = Mysite::$app->config['map_comment_link'].'restapi.amap.com/v3/place/text?&keywords='.$searchval.'&city='.$cityname.'&output=json&offset=20&page=1&key='.Mysite::$app->config['map_webservice_key'].'&extensions=all';
        $result =json_decode($this->curl_get_content($searchLink), TRUE);
        $data['list'] = $result['pois'];
        $this->success($data);
    }
    //保存地址
    function saveaddress(){
        $userid = intval(IReq::get('userid'));
        $username = trim(IReq::get('username'));
        $addressid = intval(IReq::get('addressid'));
        $arr['tag'] =  intval(IReq::get('tag'));
        if(empty($addressid))
        {
            $checknum = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."address where userid='".$userid."' ");
            if(Mysite::$app->config['addresslimit'] < $checknum)$this->message('member_addresslimit');
            $arr['userid'] = $userid;
            $arr['username'] = $username;
            $arr['phone'] = IFilter::act(IReq::get('phone'));
            $arr['otherphone'] = '';
            $arr['contactname'] = IFilter::act(IReq::get('contactname'));
            $check_message = IFilter::act(IReq::get('check_message'));
            $arr['sex'] = 0;
            $arr['default'] = $checknum == 0?1:0;
            $arr['addtime'] = time();
            if(!(IValidate::len($arr['contactname'],2,6)))$this->message('contactlength');
            if(!(IValidate::phone($arr['phone'])))$this->message('errphone');
            $areacode = Mysite::$app->config['areacode'];
            if( $areacode  == 1 ){
                $phonecls = new phonecode($this->mysql,9,$arr['phone']);
                if($phonecls->checkcode($check_message)){
                }else{
                    $this->message($phonecls->getError());
                }
            }
            $arr['bigadr'] =  IFilter::act(IReq::get('bigadr'));
            $arr['lat'] =  IFilter::act(IReq::get('lat'));
            $arr['lng'] =  IFilter::act(IReq::get('lng'));
            $arr['detailadr'] =  IFilter::act(IReq::get('detailadr'));
            $arr['address'] = $arr['bigadr'].$arr['detailadr'];
            if( empty($arr['bigadr']) ||  $arr['bigadr'] == '点击选择地址' ) $this->message('请选择地址！');
            if( empty($arr['detailadr'])  ) $this->message('请填写详细地址！');
            if( empty($arr['lat'])  ) $this->message('获取地图坐标失败，请重新获取！');
            if( empty($arr['lng'])  ) $this->message('获取地图坐标失败，请重新获取！');
            if(!(IValidate::len($arr['address'],3,50)))$this->message('member_addresslength');
            $this->mysql->insert(Mysite::$app->config['tablepre'].'address',$arr);
            $addid = $this->mysql->insertid();
            $this->mysql->update(Mysite::$app->config['tablepre'].'address',array('default'=>0),'userid = '.$userid.' ');
            $this->mysql->update(Mysite::$app->config['tablepre'].'address',array('default'=>1),'userid = '.$userid.' and id='.$addid.'');
            $newid = $addid;
        }else{
            $arr['phone'] = IFilter::act(IReq::get('phone'));
            $arr['otherphone'] = '';
            $arr['contactname'] = IFilter::act(IReq::get('contactname'));
            $arr['sex'] = 0;
            $arr['addtime'] = time();
            if(!(IValidate::len($arr['contactname'],2,6)))$this->message('contactlength');
            if(!(IValidate::phone($arr['phone'])))$this->message('errphone');
            $check_message = IFilter::act(IReq::get('check_message'));
            if(Mysite::$app->config['areacode']==1){
                $phonecls = new phonecode($this->mysql,9,$arr['phone']);
                if($phonecls->checkcode($check_message)){
                }else{
                    $this->message($phonecls->getError());
                }
            }

            $arr['bigadr'] =  IFilter::act(IReq::get('bigadr'));
            $arr['lat'] =  IFilter::act(IReq::get('lat'));
            $arr['lng'] =  IFilter::act(IReq::get('lng'));
            $arr['detailadr'] =  IFilter::act(IReq::get('detailadr'));
            $arr['address'] = $arr['bigadr'].$arr['detailadr'];
            if( empty($arr['bigadr']) ||  $arr['bigadr'] == '点击选择地址' ) $this->message('请选择地址！');
            if( empty($arr['detailadr'])  ) $this->message('请填写详细地址！');
            if( empty($arr['lat'])  ) $this->message('获取地图坐标失败，请重新获取！');
            if( empty($arr['lng'])  ) $this->message('获取地图坐标失败，请重新获取！');
            if(!(IValidate::len($arr['address'],3,50)))$this->message('member_addresslength');
            $this->mysql->update(Mysite::$app->config['tablepre'].'address',$arr,'userid = '.$userid.' and id='.$addressid.'');
            $this->mysql->update(Mysite::$app->config['tablepre'].'address',array('default'=>0),'userid = '.$userid.' ');
            $this->mysql->update(Mysite::$app->config['tablepre'].'address',array('default'=>1),'userid = '.$userid.' and id='.$addressid.'');
            $newid = $addressid;
        }
        $data['info'] = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."address where id='".$newid."' order by id asc limit 0,50");
        $this->success($data);
    }

    //编辑地址
    function editaddress(){
        $what = trim(IFilter::act(IReq::get('what')));
        $addressid = intval(IReq::get('addressid'));
        $userid = intval(IReq::get('userid'));
        if(empty($addressid)) $this->message('member_noexitaddress');
        if($what == 'default')
        {
            $arr['default'] = 0;
            $this->mysql->update(Mysite::$app->config['tablepre'].'address',$arr,"userid='".$userid."'");
            $arr['default'] = 1;
            $this->mysql->update(Mysite::$app->config['tablepre'].'address',$arr,"id='".$addressid."' and userid='".$userid."' ");
            $this->success('success');
        }elseif($what == 'addr')
        {
            $arr['address'] = IFilter::act(IReq::get('controlname'));
            if(!(IValidate::len($arr['address'],3,50))) $this->message('member_addresslength');
            $this->mysql->update(Mysite::$app->config['tablepre'].'address',$arr,"id='".$addressid."' and userid='".$this->member['uid']."' ");
            $this->success('success');
        }elseif($what == 'phone')
        {
            $arr['phone'] = IFilter::act(IReq::get('controlname'));
            if(!IValidate::phone($arr['phone'])) $this->message('errphone');
            $this->mysql->update(Mysite::$app->config['tablepre'].'address',$arr,"id='".$addressid."' and userid='".$this->member['uid']."' ");
            $this->success('success');
        }
        elseif($what == 'bak_phone')
        {
            $arr['otherphone'] = IFilter::act(IReq::get('controlname'));
            if(!IValidate::phone($arr['otherphone']))$this->message('errphone');

            $this->mysql->update(Mysite::$app->config['tablepre'].'address',$arr,"id='".$addressid."' and userid='".$this->member['uid']."' ");
            $this->success('success');
        }
        elseif($what == 'recieve_name')
        {
            $arr['contactname'] =  IFilter::act(IReq::get('controlname'));
            if(!(IValidate::len($arr['contactname'],2,6))) $this->message('contactlength');
            $this->mysql->update(Mysite::$app->config['tablepre'].'address',$arr,"id='".$addressid."' and userid='".$this->member['uid']."' ");
            $this->success('success');
        }else{
            $this->message('nodefined_func');
        }
    }

    //删除地址
    function deladdress(){
        $addressid = intval(IReq::get('addressid'));
        $userid = intval(IReq::get('userid'));
        if(empty($addressid)) $this->message('member_noexitaddress');
        $this->mysql->delete(Mysite::$app->config['tablepre'].'address',"id = '$addressid' and  userid='".$userid."'");
        $this->success('success');
    }


    //订单列表
    function userorder(){
        $userid = intval(IReq::get('userid'));
        $pageinfo = new page();
        $pageinfo->setpage(intval(IReq::get('page')),10);
        $orderSelect = "`id`,`shopid`,`addtime`,`pstype`,`shopname`,`allcost`,`status`,`is_ping`,`is_acceptorder`,`shoptype`";
        $datalist = $this->mysql->getarr("select ".$orderSelect." from ".Mysite::$app->config['tablepre']."order where buyeruid='".$userid."' and shoptype != 100  order by id desc limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."");
        $backdata = array();
        foreach($datalist as $key=>$value){
            $listdet = $this->mysql->getarr("select `goodsname` from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$value['id']."'");
            $value['det'] = '';
            foreach($listdet as $k=>$v){
                if(!empty($value['det'])){
                    $value['det'] .= ','.$v['goodsname'];
                }else{
                    $value['det'] = $v['goodsname'];
                }
            }
            $shopinfo = $this->mysql->select_one("select `shoplogo` from ".Mysite::$app->config['tablepre']."shop where id='".$value['shopid']."'");
            $value['shoplogo'] = empty($shopinfo['shoplogo'])? Mysite::$app->config['imgserver'].Mysite::$app->config['shoplogo']:Mysite::$app->config['imgserver'].$shopinfo['shoplogo'];
            $orderwuliustatus = $this->mysql->select_one("select `statustitle` from ".Mysite::$app->config['tablepre']."orderstatus where   orderid = ".$value['id']." order by id desc limit 0,1 ");
            $value['orderwuliustatus'] = $orderwuliustatus['statustitle'];
            $value['addtime'] = date('Y-m-d H:i',$value['addtime']);
            if($value['pstype'] == 0){
                $value['provide'] = '由'.Mysite::$app->config['sitename'].'提供优质服务';
            }else{
                $value['provide'] = '由商家提供优质服务';
            }

            $backdata[] =$value;
        }
        $data['orderlist'] = $backdata;
        $this->success($data);
    }
    //订单详情
    function ordershow(){
        $orderid = intval(IReq::get('orderid'));
        $userid = intval(IReq::get('userid'));
        $shareinfo = $this->mysql->select_one("select title,img,`describe`  from ".Mysite::$app->config['tablepre']."juanshowinfo where type=2 order by orderid asc  ");
        if( empty($shareinfo) ){
            $shareinfo['title'] = Mysite::$app->config['sitename'];
            $shareinfo['img'] = Mysite::$app->config['sitelogo'];
            $shareinfo['describe'] = Mysite::$app->config['sitename'];
        }
        $data['shareinfo'] = $shareinfo;
        $where = "  where type=2 and addtime < ".time()."  and is_open = 1 and juannum > 0 ";
        $checkinfosendjuan = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."juanrule ".$where." order by orderid asc ");
        $data['checkinfosendjuan'] = $checkinfosendjuan;
        if(!empty($orderid)){
            $order = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where buyeruid='".$userid."' and id = ".$orderid."");
            if(empty($order)){
                $this->message('订单不存在');
            }else{
                if($order['paytype'] == 1 && $order['paystatus'] == 0 && $order['status'] < 3){
                    $checktime = time() - $order['addtime'];
                    if($checktime > 900){
                        //说明该订单可以关闭
                        $cdata['status'] = 4;
                        $this->mysql->update(Mysite::$app->config['tablepre'].'order',$cdata,"id='".$orderid."'");
                        $this->mysql->delete(Mysite::$app->config['tablepre'].'orderps',"orderid = '$orderid' and status != 3");
                        /*更新订单 状态说明*/
                        $statusdata['orderid'] = $orderid;
                        $statusdata['addtime'] = $order['addtime']+900;
                        $statusdata['statustitle'] = "自动关闭订单";
                        $statusdata['ststusdesc'] = "在线支付订单，未支付自动关闭";
                        $this->mysql->insert(Mysite::$app->config['tablepre'].'orderstatus',$statusdata);
                        $order['status'] = 4;
                    }
                }
                $scoretocost = Mysite::$app->config['scoretocost'];
                $order['scoredown'] =  $order['scoredown']/$scoretocost;//抵扣积分
                $order['ps'] = $order['shopps'];
                // 超市商品总价	 超市配送配送	shopcost 店铺商品总价	shopps 店铺配送费	pstype 配送方式 0：平台1：个人	bagcost
                $orderdet = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$order['id']."'");
                $order['cp'] = count($orderdet);
                $order['surestatus'] = $order['status'];
                $order['basetype'] = $order['paytype'];
                $order['basepaystatus'] =$order['paystatus'];
                $order['addtime'] = date('Y-m-d H:i:s',$order['addtime']);
                $order['posttime'] = date('Y-m-d H:i:s',$order['posttime']);
                if($order['paystatus'] == 0){
                    $paystatusname = '（未付）';
                }elseif($order['paystatus'] == 1){
                    $paystatusname = '（已付）';
                }
                if($order['paytype'] == 0){
                    $order['paystatusname'] = '货到支付'.$paystatusname;
                }elseif($order['paytype'] == 1){
                    if($order['paytype_name'] == ''){
                        $order['paystatusname'] = '在线支付'.$paystatusname;
                    }else{
                        if($order['paytype_name'] == 'open_acout'){
                            $order['paystatusname'] = '余额支付'.$paystatusname;
                        }elseif($order['paytype_name'] == 'weixin'){
                            $order['paystatusname'] = '微信支付'.$paystatusname;
                        }elseif($order['paytype_name'] == 'alipay' || $order['paytype_name'] == 'alimobile'){
                            $order['paystatusname'] = '支付宝支付'.$paystatusname;
                        }
                    }
                }
                if($order['pstype'] == 1){
                    $pstypename = '商家';
                }else{
                    $pstypename = Mysite::$app->config['sitename'];
                }
                $order['pstypename'] = '本订单由'.$pstypename.'提供配送服务';

                $data['order'] = $order;
                $data['orderdet'] = $orderdet;
                $data['psbpsyinfo'] = array();
                if(   $order['psuid'] > 0 && $order['shoptype'] != 100  ){
                    if(  $order['status'] == 2   ){
                        if(  $order['pstype'] == 2  ){
                            $psbinterface = new psbinterface();
                            $data['psbpsyinfo'] = $psbinterface->getpsbclerkinfo($order['psuid']);

                            if( !empty($data['psbpsyinfo']) && !empty($data['psbpsyinfo']['posilnglat']) ){
                                $posilnglatarr = explode(',',$data['psbpsyinfo']['posilnglat']);
                                $posilng = $posilnglatarr[0];
                                $posilat = $posilnglatarr[1];
                                if( !empty($posilng) && !empty($posilat)  ){
                                    $data['psbpsyinfo']['posilnglatarr'] = $posilnglatarr;
                                }else{
                                    $data['psbpsyinfo'] = array();
                                }

                            }
                        }else if(   $order['pstype'] == 0    ){
                            $data['psbpsyinfo'] = $this->mysql->select_one("select uid,lng,lat from ".Mysite::$app->config['tablepre']."locationpsy where uid='".$order['psuid']."' ");
                            if( !empty($data['psbpsyinfo'])  &&  !empty($data['psbpsyinfo']['lng'])  &&  !empty($data['psbpsyinfo']['lat'])      ){
                                $data['psbpsyinfo']['posilnglat'] = $data['psbpsyinfo']['lng'].','.$data['psbpsyinfo']['lat'];
                                $data['psbpsyinfo']['posilnglatarr'] = explode(',',$data['psbpsyinfo']['posilnglat']);
                            }else{
                                $data['psbpsyinfo'] = array();
                            }
                        }else{
                            $data['psbpsyinfo'] = array();
                        }
                    }else if(  $order['status'] == 3 &&  (  $order['pstype'] == 0 ||  $order['pstype'] == 2  ) ){
                        $psyoverlng = $order['psyoverlng'];
                        $psyoverlat = $order['psyoverlat'];
                        $data['psbpsyinfo']['clerkid'] = $order['psuid'];
                        $data['psbpsyinfo']['posilnglat'] = $psyoverlng.','.$psyoverlat;
                        $data['psbpsyinfo']['posilnglatarr'] = explode(',',$data['psbpsyinfo']['posilnglat']);
                    }
                }


                $orderwuliustatus = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."orderstatus where orderid = ".$order['id']." order by addtime asc limit 0,10 ");
                $data['orderwuliustatus'] = array();
                if(!empty($orderwuliustatus)){
                    foreach($orderwuliustatus as $vvl){
                        $vvl['addtime'] = date('m月d日 H:i',$vvl['addtime']);
                        $vvl['telnum'] = 0;
                        $vvl['showmap'] = 0;
                        if($vvl['statustitle'] == '配送员已抢单'){
                            $vvl['ststusdesc'] = '配送员电话：';
                            $vvl['telnum'] = $order['psemail'];
                        }elseif($vvl['statustitle'] == '商家已接单'){
                            $vvl['ststusdesc'] = '商家电话：';
                            $vvl['telnum'] = $order['shopphone'];
                        }elseif($vvl['statustitle'] == '配送员已取货'){
                            if($order['psuid'] > 0 && !empty($data['psbpsyinfo']) && !empty($data['psbpsyinfo']['posilnglat'])){
                                $vvl['showmap'] = 1;
                                $posilnglat = explode(',',$data['psbpsyinfo']['posilnglat']);

                                $vvl['markers'] = array(
                                    array(
                                        'id'=> 0,
                                        'iconPath'=> "/images/psylocation_icon.png",
                                        'latitude'=> $posilnglat[1],
                                        'longitude'=> $posilnglat[0],
                                        'width'=> 30,
                                        'height'=> 30
                                    )
                                );
                                $vvl['maplng'] = $posilnglat[0];
                                $vvl['maplat'] = $posilnglat[1];
                            }
                        }elseif($vvl['statustitle'] == '订单已提交'){
                            $vvl['ststusdesc'] = '订单已提交，等待商家确认';
                        }
                        $data['orderwuliustatus'][] = $vvl;
                    }
                }
                $data['buttonshow'] = '';
                $data['buttontype'] = 0;//1继续支付、2取消订单、3申请退款、4查看退款详情、5确认收货、6评价订单、7再来一单
                if($order['paytype'] == 1 && $order['paystatus'] == 0 && $order['status'] == 0){
                    $appendinfo = array();
                    $appendinfo['statustitle'] = '待支付';
                    $appendinfo['addtime'] = $data['orderwuliustatus'][0]['addtime'];
                    $appendinfo['ststusdesc'] = '请在15分钟内完成支付';
                    $appendinfo['telnum'] = 0;
                    $appendinfo['showmap'] = 0;
                    $data['orderwuliustatus'][] = $appendinfo;
                    $data['buttonshow'] = '继续支付';
                    $data['buttontype'] = 1;
                }
                if($order['status'] > 0 && $order['status'] < 2){
                    if($order['is_reback'] == 0){
                        if($order['is_make'] == 0){
                            if($order['paystatus'] == 1){
                                if($order['paytype'] == 0){
                                    $data['buttonshow'] = '取消订单';
                                    $data['buttontype'] = 2;
                                }else{
                                    $data['buttonshow'] = '申请退款';
                                    $data['buttontype'] = 3;
                                }
                            }else{
                                $data['buttonshow'] = '取消订单';
                                $data['buttontype'] = 2;
                            }
                        }
                    }else{
                        $data['buttonshow'] = '查看退款详情';
                        $data['buttontype'] = 4;
                    }
                }
                if($order['status'] == 2 && $order['is_reback'] == 0){
                    $data['buttonshow'] = '确认收货';
                    $data['buttontype'] = 5;
                }
                if($order['status'] == 3  && $order['is_acceptorder'] == 1){
                    if($order['is_ping'] == 0){
                        $data['buttonshow'] = '评价订单';
                        $data['buttontype'] = 6;
                    }else{
                        $data['buttonshow'] = '再来一单';
                        $data['buttontype'] = 7;
                    }
                }

                $paylist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."paylist where type = 0 or type=2  order by id asc limit 0,50");
                $data['paylist'] = $paylist;
                $this->success($data);
            }
        }else{
            $this->message('订单ID为空');
        }
    }
    //用户确认收货
    function acceptorder(){
        $userid = intval(IReq::get('userid'));
        $orderid = intval(IReq::get('orderid'));
        $userctlord = new userctlord($orderid,$userid,$this->mysql);
        if($userctlord->sureorder() == false){
            $this->message($userctlord->Error());
        }else{
            $this->success('success');
        }
    }
    // 用户删除订单
    function userdelorder(){
        $userid = intval(IReq::get('userid'));
        $orderid = intval(IReq::get('orderid'));
        $userctlord = new userctlord($orderid,$userid,$this->mysql);
        if($userctlord->delorder() == false){
            $this->message($userctlord->Error());
        }else{
            $this->success('success');
        }
    }
    //取消订单
    function userunorder(){
        $userid = intval(IReq::get('userid'));
        $orderid = intval(IReq::get('orderid'));
        $userctlord = new userctlord($orderid,$userid,$this->mysql);
        if($userctlord->unorder() == false){
            $this->message($userctlord->Error());
        }else{
            $this->success('success');
        }
    }

    //评价订单页面
    function commentorder(){
        $orderid = intval(IReq::get('orderid'));
        $userid = intval(IReq::get('userid'));
        if(empty($userid)) $this->message('用户ID为空');
        $data['orderdet'] = array();
        if(!empty($orderid)){
            $order = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where buyeruid='".$userid."' and id = ".$orderid."");
            if(empty($order)){
                $this->message('订单不存在');
            }else{
                $data['order'] = $order;
                $orderdet = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$order['id']."'");
                if(!empty($orderdet)){
                    foreach($orderdet as $val){
                        $val['evaluate'] = 5;
                        $data['orderdet'][] = $val;
                    }
                }
                $tempcoment = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."comment where orderid='".$order['id']."'");
                $data['comment'] = array();
                foreach($tempcoment as $key=>$value){
                    $data['comment'][$value['orderdetid']] = $value;
                }
            }
        }else{
            $this->message('订单ID为空');
        }
        $this->success($data);
    }
    //评价订单
    function yijianping(){
        $orderid = intval( IFilter::act(IReq::get('orderid')) );
        $userid = intval(IReq::get('userid'));
        if(empty($userid)) $this->message('用户ID为空');
        if(empty($orderid)) $this->message('订单ID为空');
        $orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where buyeruid='".$userid."' and id = ".$orderid."");
        if(empty($orderinfo)) $this->message('订单不存在');
        $memberinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$userid."' ");
        if(empty($memberinfo)) $this->message('用户不存在');
        if($orderinfo['is_ping'] == 1) $this->message('order_isping');
        $orderdet = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$orderinfo['id']."'");
        $data['orderid'] = $orderinfo['id'];
        $data['shopid'] = $orderinfo['shopid'];
        $data['uid'] = $userid;
        $data['addtime'] = time();
        $data['is_show'] = 0;
        $shoppointnum =  trim( IFilter::act(IReq::get('shoppointnum')) );
        $shopsudupointnum =  intval( IFilter::act(IReq::get('shopsudupointnum')) );
        if(empty($shoppointnum)) $this->message('请评论总体评价');
        if(empty($shopsudupointnum)) $this->message('请评论配送服务');

        foreach($orderdet as $key=>$value){
            $data['point'] = intval( IFilter::act(IReq::get('goodsid_'.$value['id'])) );
            $data['content'] =  trim( IFilter::act(IReq::get('content_'.$value['id'])) );
            $data['orderdetid'] = $value['id'];
            $data['goodsid'] =   $value['goodsid'];
            if(!empty($data['point']) || !empty($data['content']) ){
                $this->mysql->insert(Mysite::$app->config['tablepre'].'comment',$data);
                $udata['status'] = 1;
                $this->mysql->update(Mysite::$app->config['tablepre'].'orderdet',$udata,"id='".$value['id']."'");
                //商品评分
                $goodinfo  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods where id='".$value['goodsid']."'  ");
                $goodpointcount = $goodinfo['pointcount'];
                $goodnewpoint['point'] = intval($goodinfo['point']+$data['point']);
                $goodnewpoint['pointcount'] = intval($goodpointcount+1);
                $this->mysql->update(Mysite::$app->config['tablepre'].'goods',$goodnewpoint,"id='".$value['goodsid']."'");
                /*写日志*/
                $issong = 1;
                if(intval(Mysite::$app->config['commentday']) > 0){//检测是否赠送积分
                    $uptime = Mysite::$app->config['commentday']*24*60*60;
                    $uptime = $orderinfo['addtime'] +$uptime;
                    if($uptime > time()){
                        $issong = 1;
                    }else{
                        $issong = 0;
                    }
                }
                $fscoreadd = 0;
                if(intval(Mysite::$app->config['commenttype']) > 0 && $issong == 1)
                { //赠送积分 大于0赠送积分到用户帐号  赠送基础积分
                    $scoreadd = Mysite::$app->config['commenttype'];
                    $checktime = date('Y-m-d',time());
                    $checktime = strtotime($checktime);
                    $checklog = $this->mysql->select_one("select sum(result) as jieguo from ".Mysite::$app->config['tablepre']."memberlog where type = 1 and   userid = ".$userid." and addtype =1 and  addtime > ".$checktime);
                    if(Mysite::$app->config['maxdayscore'] > 0){
                        $checkguo = $checklog['jieguo']+$scoreadd;
                        if($checkguo < Mysite::$app->config['maxdayscore']){
                            //最大值小于当前和
                        }elseif(Mysite::$app->config['maxdayscore'] > $checklog['jieguo']){
                            //最大指 大于 已增指
                            $scoreadd = Mysite::$app->config['maxdayscore'] - $checklog['jieguo'];
                        }else{
                            $scoreadd = 0;
                        }
                    }
                    if($scoreadd > 0){
                        $this->mysql->update(Mysite::$app->config['tablepre'].'member','`score`=`score`+'.$scoreadd,"uid='".$userid."'");
                        $fscoreadd =$scoreadd;
                        $memberallcost = $memberinfo['score']+$scoreadd;
                        $this->memberCls->addlog($userid,1,1,$scoreadd,'评价商品','评价商品'.$orderdet['goodsname'].'获得'.$scoreadd.'积分',$memberallcost);
                    }
                }
            }
        }
        $this->mysql->update(Mysite::$app->config['tablepre'].'order','`is_ping`=1',"id='".$orderinfo['id']."'");
        $ordCls = new orderclass();
        $ordCls->writewuliustatus($orderinfo['id'],11,$orderinfo['paytype']);  // 用户已评价订单，完成订单
        // 查询子订单是否所有的状态都为 1，  是的话更新订单标志
        $shuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$orderinfo['id']."' and status = 0");
        if($shuliang < 1)//订单已评价完毕
        {
            if(intval(Mysite::$app->config['commentscore']) > 0 && $issong ==  1){//扩张积分 大于0
                $scoreadd = intval(Mysite::$app->config['commentscore'])*$orderinfo['allcost'];
                $checktime = date('Y-m-d',time());
                $checktime = strtotime($checktime);
                $checklog = $this->mysql->select_one("select sum(result) as jieguo from ".Mysite::$app->config['tablepre']."memberlog where type = 1 and   userid = ".$userid." and addtype =1 and  addtime > ".$checktime);
                if(Mysite::$app->config['maxdayscore'] > 0){
                    $checkguo = $checklog['jieguo']+$scoreadd;
                    if($checkguo < Mysite::$app->config['maxdayscore']){
                        //最大值小于当前和
                    }elseif(Mysite::$app->config['maxdayscore'] > $checklog['jieguo']){
                        //最大指 大于 已增指
                        $scoreadd = Mysite::$app->config['maxdayscore'] - $checklog['jieguo'];
                    }else{
                        $scoreadd = 0;
                    }
                }
                if($scoreadd > 0){
                    $this->mysql->update(Mysite::$app->config['tablepre'].'member','`score`=`score`+'.$scoreadd,"uid='".$userid."'");
                    $memberallcost = $memberinfo['score']+$scoreadd+$fscoreadd;
                    $this->memberCls->addlog($userid,1,1,$scoreadd,'评价完订单','评价完订单'.$orderinfo['dno'].'奖励，'.$scoreadd.'积分',$memberallcost);
                }
            }
        }

        $shopinfo  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where id='".$orderinfo['shopid']."' ");
        $shuliangx = $shopinfo['point'];
        $pointcount = $shopinfo['pointcount'];
        $psservicepoint = $shopinfo['psservicepoint'];
        $psservicepointcount = $shopinfo['psservicepointcount'];
        $newpoint['point'] = intval($shoppointnum+$shuliangx);
        $newpoint['pointcount'] = intval($pointcount+1);
        $newpoint['psservicepoint'] = intval($psservicepoint+$shopsudupointnum);
        $newpoint['psservicepointcount'] = intval($psservicepointcount+1);
        $tjshop  = $this->mysql->select_one("select sum(goodscount) as sellcount from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$orderinfo['id']."'  ");
        if(!empty($tjshop) && $tjshop['sellcount'] > 0){
            $newpoint['sellcount'] = $shopinfo['sellcount']+$tjshop['sellcount'];
        }

        $this->mysql->update(Mysite::$app->config['tablepre'].'shop',$newpoint,"id='".$orderinfo['shopid']."'");
        $this->mysql->update(Mysite::$app->config['tablepre'].'orderps','`status`=3',"orderid='".$orderinfo['id']."'");
        $psbinterface = new psbinterface();
        $psbinterface->pingpsb($orderinfo['id'],$shopsudupointnum,'');
        $this->success('success');
    }

    //申请退款页面、查看退款详情页面
    function drawbacklog(){
        $userid = intval(IReq::get('userid'));
        $orderid = intval(IReq::get('orderid'));
        if(!empty($orderid)){
            $order = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where buyeruid='".$userid."' and id = ".$orderid."");
            $data['order'] = $order;
            $data['drawbacklog'] = null;
            if($order['is_reback'] > 0){
                $drawbacklog =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."drawbacklog where orderid='".$order['id']."'  ");
                if($drawbacklog['status'] == 0){
                    $drawbacklog['statusname'] = '待处理';
                }elseif($drawbacklog['status'] ==  1){
                    $drawbacklog['statusname'] = '已退款，请在对应的支付账户中查看';
                }elseif($drawbacklog['status'] ==  2){
                    $drawbacklog['statusname'] = '拒绝退款，如有疑问请联系商家';
                }
                $data['drawbacklog'] = $drawbacklog;
            }
            $data['drawsmlist'] = unserialize(Mysite::$app->config['drawsmlist']);
            $this->success($data);
        }else{
            $this->message('订单ID为空');
        }
    }
    //提交退款申请
    function savedrawbacklog(){
        $drawbacklog = new drawbacklog($this->mysql,$this->memberCls);
        $data['allcost'] =  IFilter::act(IReq::get('allcost'));
        $data['orderid'] = intval(IFilter::act(IReq::get('orderid')));// 订单id
        $data['reason'] = trim(IFilter::act(IReq::get('reason'))); //退款原因
        $data['content'] = trim(IFilter::act(IReq::get('content'))); //退款详细内容说明
        $data['typeid'] = intval(IFilter::act(IReq::get('typeid'))); //支付类型
        $data['uid'] = intval(IFilter::act(IReq::get('userid'))); //用户ID
        $data['laiyuan'] = 'app'; //支付类型
        $drawbacklog->setsavedraw($data);
        $check = $drawbacklog->save();
        if($check == true){
            $this->success('success');
        }else{
            $msg = $drawbacklog->GetErr();
            $this->message($msg);
        }
    }

    //提交订单
    function makeorder(){
        $this->getOpenCity();
        $userid = intval(IFilter::act(IReq::get('userid'))); //用户ID
        $addressinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."address  where userid = ".$userid." and `default`=1   ");
        if(empty($addressinfo)) $this->message('未设置默认地址');
        $info['username'] = $addressinfo['contactname'];
        $info['mobile'] = $addressinfo['phone'];
        $info['addressdet'] = $addressinfo['address'];
        $info['buyerlng'] = $addressinfo['lng'];
        $info['buyerlat'] = $addressinfo['lat'];
        $info['shopid'] = intval(IReq::get('shopid'));//店铺ID
        $info['remark'] = IFilter::act(IReq::get('remark'));//备注
        $info['paytype'] = IFilter::act(IReq::get('paytype'));//支付方式
        $info['dikou'] = intval(IReq::get('dikou'));//抵扣金额
        $info['minit'] = IFilter::act(IReq::get('minit'));//配送时间（秒）
        $info['juanid'] = intval(IReq::get('juanid'));//优惠劵ID
        $info['userid'] = intval(IReq::get('userid'));
        $info['ordertype'] = 3;//订单类型
        $info['othercontent'] = '';//empty($peopleNum)?'':serialize(array('人数'=>$peopleNum));
        if(empty($info['shopid'])) $this->message('店铺ID错误');
        $shoptype = intval(IReq::get('shoptype'));
        if($shoptype == 1){
            $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id where a.shopid = '".$info['shopid']."'    ");
        }else{
            $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id where a.shopid = '".$info['shopid']."'    ");
        }
        if(empty($shopinfo))   $this->message('店铺获取失败');
        $temp = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."address  where userid = ".$info['userid']." and `default`=1   ");
        $checkps = 	 $this->pscost($shopinfo,$temp['lng'],$temp['lat']);
        if($checkps['canps'] != 1) $this->message('该店铺不在配送范围内');
        $info['cattype'] = 0;
        if(empty($info['username'])) 		  $this->message('联系人不能为空');
        if(!IValidate::suremobi($info['mobile']))   $this->message('请输入正确的手机号');
        if(empty($info['addressdet'])) $this->message('详细地址为空');

        if(Mysite::$app->config['allowedguestbuy'] != 1){
            if($info['userid']==0) $this->message('禁止游客下单');
        }
        $info['ipaddress'] = '';
        $ip_l=new iplocation();
        $ipaddress=$ip_l->getaddress($ip_l->getIP());
        if(isset($ipaddress["area1"])){
            $info['ipaddress']  = $ipaddress['ip'] ;
        }
        $info['areaids'] = '';
        if($shopinfo['is_open'] != 1) $this->message('店铺暂停营业');
        $tempdata = $this->getOpenPosttime($shopinfo['is_orderbefore'],$shopinfo['starttime'],$shopinfo['postdate'],$info['minit'],$shopinfo['befortime']);
        if($tempdata['is_opentime'] ==  2) $this->message('选择的配送时间段，店铺未设置');
        if($tempdata['is_opentime'] == 3) $this->message('选择的配送时间段已超时');
        $info['sendtime'] = $tempdata['is_posttime'];
        $info['postdate'] = $tempdata['is_postdate'];
        $info['addpscost'] = $tempdata['cost'];
        $checksend = Mysite::$app->config['ordercheckphone'];
        if($checksend == 1){
            if(empty($info['userid'])){
                $checkphone = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."mobile where phone ='".$info['mobile']."' order by addtime desc limit 0,50");
                if(empty($checkphone)) $this->message('member_emailyan');
                if(empty($checkphone['is_send'])){
                    $mycode = IFilter::act(IReq::get('phonecode'));
                    if($mycode == $checkphone['code']){
                        $this->mysql->update(Mysite::$app->config['tablepre'].'mobile',array('is_send'=>1),"phone='".$info['mobile']."'");
                    }else{
                        $this->message('member_emailyan');
                    }
                }
            }
        }

        $info['shopinfo'] = $shopinfo;
        $info['allcost'] = IFilter::act(IReq::get('allcost'));
        $info['bagcost'] = IFilter::act(IReq::get('bagcost'));
        $info['allcount'] = IFilter::act(IReq::get('allcount'));
        $info['shopps'] = $checkps['pscost'];
        $dishs = IReq::get('dishs'); 
        $ggdishs = IReq::get('ggdishs');
		 
        if(empty($dishs) && empty($ggdishs)) $this->message('对应店铺购物车商品为空');
        $goodslist = array();
        if(!empty($dishs)){
            $dishs = json_decode($dishs);
            foreach($dishs as $vv){
                $vv = (array)$vv;
                if($vv['count'] > 0){
                    $newgoods = array();
                    $newgoods['shopid'] = $info['shopid'];
                    $newgoods['count'] = $vv['count'];
                    $newgoods['id'] = $vv['id'];
                    $newgoods['name'] = $vv['name'];
                    $newgoods['cost'] = $vv['price'];
                    $newgoods['have_det'] = 0;
                    $goodslist[] = $newgoods;
                }
            }
        }
        if(!empty($ggdishs)){
            $ggdishs = json_decode($ggdishs);
            foreach($ggdishs as $vg){
                $vg = (array)$vg;
                if($vg['count'] > 0){
                    $ggnewgoods = array();
                    $ggnewgoods['shopid'] = $info['shopid'];
                    $ggnewgoods['count'] = $vg['count'];
                    $ggnewgoods['name'] = $vg['name'];
                    $ggnewgoods['have_det'] = 1;
                    $ggnewgoods['gg']['goodsid'] = $vg['gid'];
                    $ggnewgoods['gg']['attrname'] = $vg['attrname'];
                    $ggnewgoods['gg']['cost'] = $vg['price'];
                    $ggnewgoods['gg']['id'] = $vg['id'];
                    $goodslist[] = $ggnewgoods;
                }
            }
        }
        $info['goodslist'] = $goodslist;
        $info['pstype'] = $checkps['pstype'];
        $info['cattype'] = 0;//表示不是预订
        $info['platform'] = 2;//微信
        $info['is_goshop'] = 0;
        if($shopinfo['limitcost'] > $info['allcost']) $this->message('商品总价低于最小起送价'.$shopinfo['limitcost']);
        $orderclass = new orderclass();
        $orderclass->makenormal($info);
        $orderid = $orderclass->getorder();
        $data['id'] = $orderid;
        $this->success($data);
    }

    //确认支付
    function gotopay(){
        $orderid = intval(IReq::get('orderid'));
        $paydotype = IFilter::act(IReq::get('paydotype'));
        $userid = intval(IReq::get('userid'));
        if(empty($orderid)) $this->message('订单ID为空');
        if(empty($userid)) $this->message('用户ID为空');
        if(empty($paydotype)) $this->message('支付类型为空');
        $orderinfo = $this->mysql->select_one("select * from `".Mysite::$app->config['tablepre']."order` where id=".$orderid."  ");//获取主单
        if(empty($orderinfo)) $this->message('订单不存在');
        $userinfo = $this->mysql->select_one("select * from `".Mysite::$app->config['tablepre']."member` where uid=".$userid."  ");//获取用户信息
        if(empty($userinfo)) $this->message('用户不存在');
        if(Mysite::$app->config['open_acout'] != 1){
            $this->message('网站未开启在线支付，不能支付');
        }
        if($userid > 0){
            if($orderinfo['buyeruid'] !=  $userid){
                $this->message('订单不属于您');
            }
        }
        if($orderinfo['paytype'] == 0){
            $this->message('此订单是货到支付订单不可操作');
        }
        if($orderinfo['status']  > 2){
            $this->message('此订单已发货或者其他状态不可操作');
        }
        $paylist = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."paylist where  loginname = '".$paydotype."' and (type = 0 or type=2) order by id asc limit 0,50");
        if(empty($paylist)){
            $this->message('不存在的支付类型');
        }
        if($orderinfo['paystatus'] == 1){
            $this->message('此订单已支付');
        }
        $paydir = hopedir.'/plug/pay/'.$paydotype;
        if(!file_exists($paydir.'/pay.php'))
        {
            $this->message('支付方式文件不存在');
        }

        //更新用户数据
        $this->mysql->update(Mysite::$app->config['tablepre'].'member','`cost`=`cost`-'.$orderinfo['allcost'],"uid ='".$userid."' ");
        //更新订单数据
        $orderdata['paystatus'] = 1;
        if($orderinfo['status'] == 0){
            $orderdata['status'] = 1;
        }
        $orderdata['paytype_name'] = $paydotype;
        $this->mysql->update(Mysite::$app->config['tablepre'].'order',$orderdata,"id ='".$orderid."' ");
        $accost = $userinfo['cost']-$orderinfo['allcost'];
        $this->memberCls->addlog($userinfo['uid'],2,2,$orderinfo['allcost'],'余额支付订单','支付订单'.$orderinfo['dno'].'帐号金额减少'.$orderinfo['allcost'].'元', $accost);
        $this->memberCls->addmemcostlog($orderinfo['buyeruid'],$userinfo['username'],$userinfo['cost'],2,$orderinfo['allcost'],$accost,"下单余额消费",$userinfo['uid'],$userinfo['username']);
        $checkflag = false;
        $orderCLs = new orderclass();
        $orderCLs->writewuliustatus($orderinfo['id'],3,$orderinfo['paytype']);  //在线支付成功状态
        if($orderinfo['is_make']  == 1 ){
            $orderCLs->writewuliustatus($orderinfo['id'],4,$orderinfo['paytype']);  //商家自动确认接单
            $auto_send = Mysite::$app->config['auto_send'];
            if($auto_send == 1){
                $orderCLs->writewuliustatus($orderinfo['id'],6,$orderinfo['paytype']);//订单审核后自动 商家接单后自动发货
                $orderdatac['sendtime'] = time();
                $this->mysql->update(Mysite::$app->config['tablepre'].'order',$orderdatac,"id ='".$orderid."' ");
            }else{
                //自动生成配送单
                if($orderinfo['shoptype'] != 100){
                    if($orderinfo['pstype'] == 0 ){//网站配送自动生成配送费
                        $orderpsinfo  =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."orderps where  orderid ='".$orderid."'   ");
                        if(empty($orderpsinfo)){
                            $psdata['orderid'] = $orderinfo['id'];
                            $psdata['shopid'] = $orderinfo['shopid'];
                            $psdata['status'] = 0;
                            $psdata['dno'] = $orderinfo['dno'];
                            $psdata['addtime'] = time();
                            $psdata['pstime'] = $orderinfo['posttime'];
                            $admin_id = $orderinfo['admin_id'];
                            $psset = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."platpsset  where cityid= '".$admin_id."'   ");
                            $checkpsyset = $psset['psycostset'];
                            $bilifei =$psset['psybili']*0.01*$orderinfo['allcost'];
                            $psdata['psycost'] = $checkpsyset == 1?$psset['psycost']:$bilifei;
                            $this->mysql->insert(Mysite::$app->config['tablepre'].'orderps',$psdata);  //写配送订单
                        }
                        $checkflag = true;
                    }elseif($orderinfo['pstype'] == 2){
                        $psbinterface = new psbinterface();
                        if($psbinterface->psbnoticeorder($orderid)){
                            $checkflag = false;
                        }
                    }
                }else{
                    //生成跑腿订单的办法调用
                    $psbinterface = new psbinterface();
                    if($psbinterface->paotuitopsb($orderid)){
                        $checkflag = false;
                    }
                }
                //自动生成配送单结束-------------
            }
        }else{
            if($orderinfo['shoptype'] == 100){
                $psbinterface = new psbinterface();
                if($psbinterface->paotuitopsb($orderid)){
                    $checkflag = false;
                }
            }
        }
        $orderCLs->sendmess($orderid);
        if($checkflag ==true){
            $psylist =  $this->mysql->getarr("select a.*  from ".Mysite::$app->config['tablepre']."apploginps as a left join ".Mysite::$app->config['tablepre']."member as b on a.uid = b.uid where b.admin_id = ".$orderinfo['admin_id']."");
            $psCls = new apppsyclass();
            $psCls->SetUserlist($psylist)->sendNewmsg('订单提醒','有新订单可以处理');
        }

        $data['id'] = $orderid;
        $this->success($data);
    }

    //获取支付数据
    function paydata(){
        $orderid = intval(IReq::get('orderid'));
        $wxopenid = IReq::get('openid');
        if(empty($orderid))$this->message('订单ID为空');
        if(empty($wxopenid))$this->message('openid为空');
        $orderinfo = $this->mysql->select_one("select * from `".Mysite::$app->config['tablepre']."order` where id=".$orderid."  ");//获取主单
        $weixindir = hopedir.'/plug/pay/weixinapplet/';
        $weixindata = array(
            'appid'=>'',
            'nonce_str'=>'',
            'package'=>'',
            'paySign'=>'',
            'timeStamp'=>''
        );
        $weixincheck = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."paylist where  loginname ='weixin'   order by id asc limit 0,1");
        if(!empty($weixincheck)){
            require_once $weixindir."lib/WxPay.Api.php";
            //②、统一下单
            $input = new WxPayUnifiedOrder();
            $input->SetBody("支付订单".$orderinfo['dno']);
            $input->SetOut_trade_no($orderinfo['id']);
            $input->SetTotal_fee($orderinfo['allcost']*100);
            $input->SetTime_start(date("YmdHis"));
            $input->SetTime_expire(date("YmdHis", time() + 600));
            $input->SetTimeStamp(time());
            $input->SetGoods_tag('订餐');
            $input->SetNotify_url(Mysite::$app->config['siteurl']."/plug/pay/weixinapplet/notify.php");
            $input->SetTrade_type("JSAPI");
            $input->SetOpenid($wxopenid);
//            print_r($input);
            $ordermm = WxPayApi::unifiedOrder($input);
//            print_r($ordermm);
            if($ordermm){
                $nowTime = (string)time();
                $weixindata['appid'] = $ordermm['appid'];
                $weixindata['nonce_str'] = $ordermm['nonce_str'];
                $weixindata['package'] = 'prepay_id='.$ordermm['prepay_id'];
                $key = WxPayConfig::KEY;
                $string = 'appId='.$ordermm['appid'].'&nonceStr='.$ordermm['nonce_str'].'&package='.$weixindata['package'].'&signType=MD5&timeStamp='.$nowTime.'&key='.$key;
                $string = md5($string);
                //签名步骤四：所有字符转为大写
                $result = strtoupper($string);
                $weixindata['paySign'] = $result;
                $weixindata['timeStamp'] = $nowTime;
            }
        }
        $this->success($weixindata);
    }






}