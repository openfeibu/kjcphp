<?php
/*
*  app 用户端和 商家段合用
*   版本v.2.1
*/
class method   extends baseclass
{ 
	public $platpsinfo;
     
		
	 
	/***************外卖人首页： 优选商家 分类 专题页 *****************/
	function waimairenindex(){

		$adcode = trim(IFilter::act(IReq::get('adcode')));
		$lat = trim(IFilter::act(IReq::get('lat')));
		$lng = trim(IFilter::act(IReq::get('lng')));
		$cityid = 0;
		$cityinfo = array(); 
		if( !empty($adcode) ){
				$areacodeone =  $this->mysql->select_one("select id,pid from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  ");
  				if( !empty($areacodeone) ){
					$adcodeid = $areacodeone['id'];
					$pid = $areacodeone['pid'];
   					$areainfoone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  ");
  					if( !empty($areainfoone) ){
						$city_id = "CITY_ID_".$areainfoone['adcode'];
						$city_name = "CITY_NAME_".$areainfoone['name'];
						ICookie::set('CITY_ID',$city_id);
						ICookie::set('CITY_NAME',$city_name);
						$cityinfo = $areainfoone;
 					}
				}
		}  
		if( empty($cityinfo) ){
 			 $this->message("获取城市失败，跳转到选择城市页面");
 		}else{
			$cityid = $cityinfo['adcode'];
		} 
		$data['cityinfo'] = $cityinfo; 
		$citywhere =  " and ( cityid = '".$cityid."'  or cityid = 0 )  "; 
		
		$shopopentype = intval(IFilter::act(IReq::get('shopopentype'))); //0,1
		$ordertype = intval(IFilter::act(IReq::get('ordertype'))); //排序类型   0,1,2,3
		//shoptype
		$areaid = intval(IFilter::act(IReq::get('areaid')));//区域ID
		$limitcosttype = intval(IFilter::act(IReq::get('limitcosttype'))); //起送价格类型 0 1 2 3  
		$lat = IFilter::act(IReq::get('lat'));
		$lng = IFilter::act(IReq::get('lng')); 
		$lat = empty($lat)?0:$lat;
		$lng =empty($lng)?0:$lng;
		
		
		$userAgent = $_SERVER['HTTP_USER_AGENT']; 
		$listflag = true;
		if(strpos($userAgent,"iPhone") || strpos($userAgent,"iPad") || strpos($userAgent,"iPod")){
			$source =  intval(IFilter::act(IReq::get('source')));
			$ios_waiting =   Mysite::$app->config['ios_waiting'];
			if($source == 1 && $ios_waiting == true){
				$listflag = false;
			}else{
			}
		}else{ 
		}
		 

		$Mdata['appadv1'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."appadv where id > 0 and  type !=2   ".$citywhere." order by orderid asc");
		$Mdata['appadv2'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."appadv where id > 0 and type =2 and is_show=1 ".$citywhere." order by orderid asc");
		$Mdata['appadv']  = array_merge($Mdata['appadv1'],$Mdata['appadv2']);

		//轮播图
		$imgtran1  =  $this->mysql->getarr("select img,linkurl,title from ".Mysite::$app->config['tablepre']."adv where cityid='".$cityid."' and  advtype='weixinlb' and  is_show=1  order by sort asc  limit 5  ");
		$newimgtran1 = array();
		if(!empty($imgtran1)){
			foreach($imgtran1 as $key=>$value){
				if( $value['linkurl'] == '#' || $value['linkurl'] == 'javascript:void(0);' || $value['linkurl'] == 'javascript:;' ){
					$value['linkurl'] = ''; 
				}
				$newimgtran1[] = $value;
			}
		}
		$Mdata['imgtran1'] = $newimgtran1;

		$imgtran2  =  $this->mysql->getarr("select img,linkurl,title from ".Mysite::$app->config['tablepre']."adv where cityid='".$cityid."' and  advtype='weixinlb2' and is_show=1  order by sort asc  limit 5  ");
		$newimgtran2 = array();
		if(!empty($imgtran2)){
			foreach($imgtran2 as $key=>$value){
				if( $value['linkurl'] == '#' || $value['linkurl'] == 'javascript:void(0);' || $value['linkurl'] == 'javascript:;' ){
					$value['linkurl'] = ''; 
				}
				$newimgtran2[] = $value;
			}
		}
		$Mdata['imgtran2']  = $newimgtran2;
		
		//通知
		$Mdata['noticeInfo'] = $this->mysql->select_one("select title,cityid from ".Mysite::$app->config['tablepre']."information where type = 1 ".$citywhere." order by addtime asc limit 1");
		if(empty($Mdata['noticeInfo'])){
			$Mdata['noticeInfo']['title'] = "";
			$Mdata['noticeInfo']['cityid'] = "";
		}

		// 专题页
        $Mdata['ztymode']  =  $this->mysql->select_one("select type from ".Mysite::$app->config['tablepre']."ztymode where cityid='".$cityid."'  ");
		$ztstyle = empty($Mdata['ztymode'])?0:$Mdata['ztymode']['type'];
		$ztycitywhere =  " and ( b.cityid = '".$cityid."'  or b.cityid = 0 )  ";
		$Mdata['ztylist'] =   $this->mysql->getarr("select b.id,b.name,a.indeximg as img,b.showtype,b.cx_type,b.is_custom,b.cityid from ".Mysite::$app->config['tablepre']."ztyimginfo as a left join ".Mysite::$app->config['tablepre']."specialpage as b on a.ztyid = b.id where a.is_show=1 and b.is_bd=2 and a.type={$ztstyle}   ".$ztycitywhere." and ((b.is_custom =0 ) or (  b.is_custom =1 ) or (b.cx_type = 9) )  order by b.orderid  asc");

		$data['appadv'] =$Mdata['appadv'];
		$data['noticeInfo'] =$Mdata['noticeInfo'];

		$data['ztylist'] =$Mdata['ztylist'];
		$data['ztymode'] =$Mdata['ztymode'];

		$data['imgtran1'] =$Mdata['imgtran1'];
		$data['imgtran2'] =$Mdata['imgtran2']; 
			
		$limitcosttype = in_array($limitcosttype,array(0,1,2,3))?$limitcosttype:0;
		$shopopentype = in_array($shopopentype,array(0,1,2))?$shopopentype:0;
		
		
		$limitarr = array();
		if($shopopentype == 0){
			$limitarr['shoptype'] = 1;
		}elseif($shopopentype == 1){ 
			$limitarr['shoptype'] = 2;
		}
		if($limitcosttype > 0){
			$limitarr['limitcost'] = $limitcosttype;
		}
		$limitarr['index_com'] =1;
		if($listflag == false){//当为苹果并且上架时强制性输出所有.
			$datalistx = $this->Tdata($cityid,$limitarr,array('juli'=>'asc'),$lat,$lng,4,1);
		}else{
			$datalistx = $this->Tdata($cityid,$limitarr,array('juli'=>'asc'),$lat,$lng,4);
		}
		$pageinfo = new page();
		$pageinfo->setpage(intval(IReq::get('page'))); 
		$starnum = $pageinfo->startnum();
		$pagesize = $pageinfo->getsize();
		$templist = array();
		for($k = 0;$k<$pagesize;$k++){
			$checknum = $starnum+$k;
			if(isset($datalistx[$checknum])){
				$templist[] = $datalistx[$checknum];
			}else{
				break;
			}
		}  
		$tempc = array();
		foreach($datalistx as $key=>$value){
			if($value['isforyou'] == 1&& $value['canps'] == 1){
				$tempc[] = $value;
			}
		}

		$sort = array(
				'direction' => 'SORT_ASC',
				'field'     => 'sort',
		);
		$arrSort = array();
		foreach($tempc as $uniqid => $row){
			foreach($row as $key=>$value){
				$arrSort[$key][$uniqid] = $value;
			}
		}
		if($sort['direction']){
			array_multisort($arrSort[$sort['field']], constant($sort['direction']), $tempc);
		}


		$shuliang = 0;
		$fyshop = array();
		foreach($tempc as $key=>$value){
			$fyshop[] = $value;
			$shuliang = $shuliang+1;
			if($shuliang == 6){
				break;
			}
		}
		$data['regimg'] = Mysite::$app->config['regimg'];
		$data['shoplist'] = $templist;
		$data['fyshoplist'] = $fyshop;  
		$data['mobilemodule']=1;
		$this->success($data);  
	}
	function saveloation(){ 
			ICookie::clear('lat');
			ICookie::clear('lng');
			ICookie::clear('mapname');
			ICookie::clear('addressname');
			ICookie::clear('CITY_ID');
			ICookie::clear('CITY_NAME');
			$adcode = IFilter::act(IReq::get('adcode'));   
			$lat = IFilter::act(IReq::get('lat'));   
			$lng = IFilter::act(IReq::get('lng')); 
			$addressname = IFilter::act(IReq::get('addressname')); 
			
			/* $adcode = '410100';
			$lat = 34.802461;
			$lng = 113.597715;
			$addressname = '电子商务产业园(郑州高新区)'; */
			
			ICookie::set('lat',$lat);  
			ICookie::set('lng',$lng);  
			ICookie::set('addressname',$addressname); 
			ICookie::set('mapname',$addressname); 
			
			$data['areainfoone'] = array();
			
			if( !empty($adcode) ){
				$areacodeone =  $this->mysql->select_one("select id,pid from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  ");
				if( !empty($areacodeone) ){
					$adcodeid = $areacodeone['id'];
					$pid = $areacodeone['pid'];
   					$areainfoone =  $this->mysql->select_one("select adcode,name from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  ");
					if( !empty($areainfoone) ){
						$city_id = "CITY_ID_".$areainfoone['adcode'];
						$city_name = "CITY_NAME_".$areainfoone['name'];
						ICookie::set('CITY_ID',$city_id);
						ICookie::set('CITY_NAME',$city_name);
						$data['areainfoone']  = $areainfoone;
 					}
				}
			}
			$this->success($data);
	}
	function newwaimairenindexPage(){ 
		$adcode = trim(IFilter::act(IReq::get('adcode'))); 
		$shoplogo = Mysite::$app->config['shoplogo'];
		$cityid = 0;
		$cityinfo = array(); 
		if( !empty($adcode) ){
				$areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  "); 
  				if( !empty($areacodeone) ){
					$adcodeid = $areacodeone['id'];
					$pid = $areacodeone['pid'];
   					$areainfoone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  "); 
  					if( !empty($areainfoone)){
						$city_id = "CITY_ID_".$areainfoone['adcode'];
						$city_name = "CITY_NAME_".$areainfoone['name'];
						ICookie::set('CITY_ID',$city_id);
						ICookie::set('CITY_NAME',$city_name);
						$cityinfo = $areainfoone;
 					}
				}
		}  
		if( empty($cityinfo)){
 			 $this->message("获取城市失败，跳转到选择城市页面");
 		}else{
			$cityid = $cityinfo['adcode'];
		} 
		$data['cityinfo'] = $cityinfo; 
		$citywhere =  " and ( cityid = '".$cityid."'  or cityid = 0 )  ";  
		$shopopentype = intval(IFilter::act(IReq::get('shopopentype'))); //0,1
		$ordertype = intval(IFilter::act(IReq::get('ordertype'))); //排序类型   0,1,2,3
		//shoptype
		$areaid = intval(IFilter::act(IReq::get('areaid')));//区域ID
		$limitcosttype = intval(IFilter::act(IReq::get('limitcosttype'))); //起送价格类型 0 1 2 3
		$is_waimai = intval(IFilter::act(IReq::get('is_waimai'))); //表示外送
		$is_goshop = intval(IFilter::act(IReq::get('is_goshop'))); //表示到店
		$searvalue = IFilter::act(IReq::get('searchvalue'));
		$lat = IFilter::act(IReq::get('lat'));
		$lng = IFilter::act(IReq::get('lng'));
		$goodstype = intval(IFilter::act(IReq::get('shoptype')));
		$is_com = intval(IFilter::act(IReq::get('is_com')));
		$is_hot = intval(IFilter::act(IReq::get('is_hot')));
		$is_new = intval(IFilter::act(IReq::get('is_new')));
		$lat = empty($lat)?0:$lat;
		$lng =empty($lng)?0:$lng;
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		$listflag = true;
		if(strpos($userAgent,"iPhone") || strpos($userAgent,"iPad") || strpos($userAgent,"iPod")){
			$source =  intval(IFilter::act(IReq::get('source')));
			$ios_waiting =   Mysite::$app->config['ios_waiting'];
			if($source == 1 && $ios_waiting == true){
				$listflag = false;
			}else{
			}
		}else{
		}
		 
		$limitcosttype = in_array($limitcosttype,array(0,1,2,3))?$limitcosttype:0;
		$shopopentype = in_array($shopopentype,array(0,1,2))?$shopopentype:0;
		$limitarr = array();
		if($shopopentype == 0){
			$limitarr['shoptype'] = 1;
		}elseif($shopopentype == 1){ 
			$limitarr['shoptype'] = 2;
		}
		if($limitcosttype > 0){
			$limitarr['limitcost'] = $limitcosttype;
		}
		$limitarr['index_com'] =1;
		
		if($listflag == false){//当为苹果并且上架时强制性输出所有.
			$datalistx = $this->Tdata($cityid,$limitarr,array('juli'=>'asc'),$lat,$lng,4,1);
		}else{
			$datalistx = $this->Tdata($cityid,$limitarr,array('juli'=>'asc'),$lat,$lng,4);
		}
		 
		$pageinfo = new page();
		$pageinfo->setpage(intval(IReq::get('page'))); 
		$starnum = $pageinfo->startnum();
		$pagesize = $pageinfo->getsize();
		$templist = array();
		for($k = 0;$k<$pagesize;$k++){
			$checknum = $starnum+$k;
			if(isset($datalistx[$checknum])){
				$templist[] = $datalistx[$checknum];
			}else{
				break;
			}
		}  	 
			 
		$data['shoplist'] = $templist;
		#print_r($data['shoplist']);
		$data['mobilemodule']=1;
		$this->success($data); 
	} 
	function newshop(){ 
		$shoplogo = Mysite::$app->config['shoplogo'];
		$shopopentype = intval(IFilter::act(IReq::get('shopopentype'))); //0,1
		$ordertype = intval(IFilter::act(IReq::get('ordertype'))); //排序类型   0,1,2,3
		//shoptype
		$adcode = intval(IFilter::act(IReq::get('adcode')));
		if( !empty($adcode) ){
			$areacodeone =  $this->mysql->select_one("select id,pid from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  ");
			if( !empty($areacodeone) ){
				$adcodeid = $areacodeone['id'];
				$pid = $areacodeone['pid'];
				$areainfoone =  $this->mysql->select_one("select adcode from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  ");
			}
            if( empty($areainfoone) ){
                $this->message("获取城市失败");
            }else{
                $adcode = $areainfoone['adcode'];
            }
		} 
		$areaid = intval(IFilter::act(IReq::get('areaid')));//区域ID
		$limitcosttype = intval(IFilter::act(IReq::get('limitcosttype'))); //起送价格类型 0 1 2 3
		$is_waimai = intval(IFilter::act(IReq::get('is_waimai'))); //表示外送
		$is_goshop = intval(IFilter::act(IReq::get('is_goshop'))); //表示到店
		$searvalue = IFilter::act(IReq::get('searchvalue')); 
		$lat = IFilter::act(IReq::get('lat'));
		$lng = IFilter::act(IReq::get('lng'));
		$goodstype = intval(IFilter::act(IReq::get('shoptype')));
		$is_com = intval(IFilter::act(IReq::get('is_com')));
		$is_hot = intval(IFilter::act(IReq::get('is_hot')));
		$is_new = intval(IFilter::act(IReq::get('is_new')));
		$lat = empty($lat)?0:$lat;
		$lng =empty($lng)?0:$lng;
		
		$limitcosttype = in_array($limitcosttype,array(0,1,2,3))?$limitcosttype:0;
		$shopopentype = in_array($shopopentype,array(0,1,2))?$shopopentype:0; 
		
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		$listflag = true;
		if(strpos($userAgent,"iPhone") || strpos($userAgent,"iPad") || strpos($userAgent,"iPod")){
			$source =  intval(IFilter::act(IReq::get('source')));
			$ios_waiting =   Mysite::$app->config['ios_waiting'];
			if($source == 1 && $ios_waiting == true){
				$listflag = false;
			}else{
			}
		}else{
		} 
	 
		$limitarr = array();
		 
		if($limitcosttype > 0){
			$limitarr['limitcost'] = $limitcosttype;
		} 
		if($is_waimai == 1){
			$limitarr['is_waimai'] = 1;
		}
		if($is_goshop == 1){
			$limitarr['is_goshop'] = 1;
		} 
		if($goodstype > 0){
			$limitarr['shopcat'] =$goodstype;
		}
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
		
		$order = in_array($ordertype,array(1,2,3))? $ordertype:0; 
		
		
		if($listflag == false){//当为苹果并且上架时强制性输出所有.
			$datalistx = $this->Tdata($adcode,$limitarr,array('juli'=>'asc'),$lat,$lng,4,1);
		}else{
			$datalistx = $this->Tdata($adcode,$limitarr,$orderarray[$order],$lat,$lng,4);
		}
		 
		 
		$pageinfo = new page();
		$pageinfo->setpage(intval(IReq::get('page'))); 
		$starnum = $pageinfo->startnum();
		$pagesize = $pageinfo->getsize();
		$templist = array();
		for($k = 0;$k<$pagesize;$k++){
			$checknum = $starnum+$k;
			if(isset($datalistx[$checknum])){
				$templist[] = $datalistx[$checknum];
			}else{
				break;
			}
		}  	 
		$this->success($templist); 
	}
	function getuserinfo(){
		$member = array();
		$uid = intval(IFilter::act(IReq::get('uid')));
		$pwd = trim(IFilter::act(IReq::get('pwd')));
		$logintype = trim(IFilter::act(IReq::get('logintype')));
		$phone = trim(IFilter::act(IReq::get('phone')));
		if( $logintype == 'phone' ){// 快捷登录
			$member= $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$uid."' and  phone='".$phone."' "); 
		}else{
			$member= $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$uid."' and  password='".md5($pwd)."' ");
		}
		if( !empty($member) ){
			$this->success($member);
		}else{
			$this->message('获取会员信息失败！');
		}
	}
	/**
	*@method 用户端  分类下超市便利店独立模块
	*@request_url http://m6.waimairen.com/index.php?ctrl=app&action=marketshop&lat=34.802330&lng=113.543806&page=1&datatype=json 
 	*@所需参数   lat  lng 坐标参数   page 页码
	*添加时间:2017/9/27    技术：闫
	**/
	function marketshop(){
		
		$shoplogo = Mysite::$app->config['shoplogo'];		 
		$lat = trim(IFilter::act(IReq::get('lat')));
		$lng = trim(IFilter::act(IReq::get('lng')));  		 
        $adcode = trim(IFilter::act(IReq::get('adcode')));  		 
		if(empty($adcode)){
			if( !empty($lat) &&  !empty($lng) ){
				   $content =   file_get_contents('https://restapi.amap.com/v3/geocode/regeo?output=json&location='.$lng.','.$lat.'&key='.Mysite::$app->config['map_webservice_key'].'&radius=1000&extensions=all'); 
					 $backinfo  = json_decode($content,true);
					
					if( $backinfo['status'] == 1 && $backinfo['info'] == 'OK'){
						$adcode = $backinfo['regeocode']['addressComponent']['adcode']; 
						 
					}  
						
			}else{
				$this->message('位置获取失败');
		    }
		}
		$areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  "); 
		
		if( !empty($areacodeone) ){
			$adcodeid = $areacodeone['id'];
			$pid = $areacodeone['pid'];
			$adcode = $adcode;
			$areainfoone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  ");   
			
			if( !empty($areainfoone) ){
				$city_id = "CITY_ID_".$areainfoone['adcode'];
				$city_name = "CITY_NAME_".$areainfoone['name'];
				ICookie::set('CITY_ID',$city_id);
				ICookie::set('CITY_NAME',$city_name);
				$data['areainfoone']  = $areainfoone;
				$adcode = $areainfoone['adcode']; 
			}
			
		}
		
		
		
		$imglist  = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."adv where `advtype` = 'chaoshilb' and cityid=".$adcode." " );
		foreach($imglist as $k=>$v){
			 $v['img'] = Mysite::$app->config['siteurl'].$v['img'];
             $data['imglist'][] = $v;	 
		}	
		$userAgent = $_SERVER['HTTP_USER_AGENT']; 
		$listflag = true;
		if(strpos($userAgent,"iPhone") || strpos($userAgent,"iPad") || strpos($userAgent,"iPod")){
			$source =  intval(IFilter::act(IReq::get('source')));
			$ios_waiting =   Mysite::$app->config['ios_waiting'];
			if($source == 1 && $ios_waiting == true){
				$listflag = false;
			}else{
			}
		}else{ 
		} 
		 
		$limitarr = array(); 
		$limitarr['shoptype'] =2; 
		if($listflag == false){//当为苹果并且上架时强制性输出所有.
			$datalistx = $this->Tdata($adcode,$limitarr,array('juli'=>'asc'),$lat,$lng,4,1);
		}else{
			$datalistx = $this->Tdata($adcode,$limitarr,array('juli'=>'asc'),$lat,$lng,4);
		}
		 
		 
		$pageinfo = new page();
		$pageinfo->setpage(intval(IReq::get('page'))); 
		$starnum = $pageinfo->startnum();
		$pagesize = $pageinfo->getsize();
		$templist = array();
		for($k = 0;$k<$pagesize;$k++){
			$checknum = $starnum+$k;
			if(isset($datalistx[$checknum])){
				$templist[] = $datalistx[$checknum];
			}else{
				break;
			}
		}  	
		 
		 
        $data['shoplist'] = $templist;	
		$this->success($data);
			
	}
	/**
	*@method 新版商家端  编辑优惠活动时  获取优惠活动详情
	*@request_url http://m6.waimairen.com/index.php?ctrl=app&action=editrule&uid=10203&pwd=123456&id=485&datatype=json 
 	*@所需参数   uid：用户uid   pwd：用户密码   id：优惠活动活动id 	
	*@备注：   
	*添加时间:2017/9/27    技术：闫
	**/
    function editrule(){
		$backinfo = $this->checkapp();		 
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$id = IFilter::act(IReq::get('id'));
		$ruleinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."rule where id = ".$id." "); 
		if(empty($ruleinfo)) $this->message('活动信息获取失败');
			$ruleinfo['creattime'] = date('Y-m-d H:i:s',$ruleinfo['creattime']);
			$ruleinfo['starttime'] = empty($ruleinfo['starttime'])?'':date('Y-m-d',$ruleinfo['starttime']);
			$ruleinfo['endtime'] = empty($ruleinfo['endtime'])?'':date('Y-m-d',$ruleinfo['endtime']);						 
			$ruleinfo['limitcontent'] = explode(',',$ruleinfo['limitcontent']);
			$ruleinfo['controlcontent'] = explode(',',$ruleinfo['controlcontent']);	 
			$ruleinfo['presenttitle'] = empty($ruleinfo['presenttitle'])?'':$ruleinfo['presenttitle'];
			$ruleinfo['imgurl'] = Mysite::$app->config['siteurl'].$ruleinfo['imgurl'];
		    $ruleinfo['supportplatform'] = explode(',',$ruleinfo['supportplatform']);			 						 		 
			$ruleinfo['limittime'] = explode(',',$ruleinfo['limittime']);	 
		$this->success($ruleinfo);
	}
	/**
	*@method 新版商家端  促销活动列表
	*@request_url http://m6.waimairen.com/index.php?ctrl=app&action=cxrulelist&uid=10203&pwd=123456&type=1&datatype=json 
 	*@所需参数   uid：用户uid   pwd：用户密码   type：1 待生效 2进行中 3已结束
	*@备注：   
	*添加时间:2017/9/27    技术：闫
	**/
   function cxrulelist(){
       $backinfo = $this->checkapp();		 
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
	   $shopinfo = $this->mysql->select_one("select id, shoptype  from ".Mysite::$app->config['tablepre']."shop  where uid = '".$backinfo['uid']."'  ");			
	   if(empty($shopinfo)) $this->message('店铺信息获取失败');
	   if($shopinfo['shoptype'] == 0){
		   $psinfo = $this->mysql->select_one("select sendtype from ".Mysite::$app->config['tablepre']."shopfast  where shopid = '".$shopinfo['id']."'  ");	
	   }else{
		   $psinfo = $this->mysql->select_one("select sendtype from ".Mysite::$app->config['tablepre']."shopmarket where shopid = '".$shopinfo['id']."'  ");	
	   }
	   
	   
	   $type = intval(IReq::get('type'));//1 待生效 2进行中 3已结束
       $type = in_array($type, array(1, 2, 3)) ? $type : 1;     
	   if($psinfo['sendtype'] == 1){ //商家配送的情况下   进行中的活动不显示  平台设置的免配送费活动
		  $wherearr = array(	    
		   '1'=>' and parentid = 0 and limittype = 3  and starttime > '.time().' and status = 1 ',
		   '2'=>' and status = 1 and ( limittype < 3  or ( limittype = 3 and endtime > '.time().' and starttime < '.time().')) and ( ( parentid = 1 and controltype != 4 ) or parentid = 0 )',
		   '3'=>' and parentid = 0 and ( status = 0 or ( limittype = 3 and endtime < '.time().' ) )  ',	    
		   ); 
		   
	   }else{//平台配送的情况下   进行中的活动不显示  商家设置的免配送费活动
		   $wherearr = array(	    
		   '1'=>' and parentid = 0 and limittype = 3  and starttime > '.time().' and status = 1 ',
		   '2'=>' and status = 1 and ( limittype < 3  or ( limittype = 3 and endtime > '.time().' and starttime < '.time().')) and ( ( parentid = 0 and controltype != 4 ) or parentid = 1 ) ',
		   '3'=>' and parentid = 0 and ( status = 0 or ( limittype = 3 and endtime < '.time().' ) )  ',	    
		   );   
	   }
	   
	    
       $cxrulelist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."rule where  FIND_IN_SET(".$shopinfo['id'].",shopid) ".$wherearr[$type]."   order by id desc " );
	   
	   $data['cxrulelist'] = array();
	   foreach($cxrulelist as $k=>$v){
		    $v['creattime'] = date('Y-m-d H:i:s',$v['creattime']);
		    $v['starttime'] = empty($v['starttime'])?'':date('Y-m-d',$v['starttime']);
			$v['endtime'] = empty($v['endtime'])?'':date('Y-m-d',$v['endtime']);			 
			$v['presenttitle'] = empty($v['presenttitle'])?'':$v['presenttitle'];
			$v['imgurl'] = Mysite::$app->config['siteurl'].$v['imgurl'];
			$v['supportplatform'] = explode(',',$v['supportplatform']);	 
			$v['limitcontent'] = explode(',',$v['limitcontent']);
			$v['controlcontent'] = explode(',',$v['controlcontent']);	 
			$v['limittime'] = explode(',',$v['limittime']);	 
			$data['cxrulelist'][] = $v;	    
	   }  	   
	   $this->success($data);                
   }
   /**
	*@method 新版商家端  检测是否可以添加活动
	*@request_url http://m6.waimairen.com/index.php?ctrl=app&action=checkcx&uid=10203&pwd=123456&type=1&datatype=json 
 	*@所需参数   uid：用户uid   pwd：用户密码  type:活动类型 1满赠活动 2满减活动 3折扣活动 4免配送费 
	*@备注：   
	*添加时间:2017/9/28    技术：闫
	**/
	function checkcx(){
		$backinfo = $this->checkapp();		 
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$type = IFilter::act(IReq::get('type'));
		if(empty($type)) $this->message('活动类型获取失败');
		$shopinfo = $this->mysql->select_one("select id,shoptype  from ".Mysite::$app->config['tablepre']."shop  where uid = '".$backinfo['uid']."'  ");
		if(empty($shopinfo)) $this->message('店铺信息获取失败');
		if($shopinfo['shoptype'] == 1){
			$psinfo = $this->mysql->select_one("select sendtype  from ".Mysite::$app->config['tablepre']."shopmarket  where shopid = '".$shopinfo['id']."'  ");
		}else{
			$psinfo = $this->mysql->select_one("select sendtype  from ".Mysite::$app->config['tablepre']."shopfast  where shopid = '".$shopinfo['id']."'  ");
		}
		if($type==4){
			if($psinfo['sendtype']!=1){//平台配送
				$data['canadd'] = 0;
			    $data['reason'] = '仅限商家配送店铺创建此活动';
			}else{
				$checkcxinfox1 = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."rule where parentid = 0 and shopid = ".$shopinfo['id']." and controltype = ".$type." and  limittype = 3  and starttime > ".time()." and status = 1  "); 
			//进行中
			    $checkcxinfox2 = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."rule where parentid = 0 and shopid = ".$shopinfo['id']." and controltype = ".$type." and status = 1 and ( limittype < 3  or ( limittype = 3 and endtime > ".time()." and starttime < ".time()."))"); 
		    if(!(empty($checkcxinfox1) && empty($checkcxinfox2))){
					$data['canadd'] = 0;
			        $data['reason'] = '当前已有该类型活动，无法进行创建';
				}else{
					$data['canadd'] = 1;
			        $data['reason'] = '可创建该类型活动';
				}
				
			}
			
		}
		if($type < 4){
			//待生效
			$checkcxinfo1 = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."rule where parentid = 0 and shopid = ".$shopinfo['id']." and controltype = ".$type." and  limittype = 3  and starttime > ".time()." and status = 1  "); 
			//进行中
			$checkcxinfo2 = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."rule where parentid = 0 and shopid = ".$shopinfo['id']." and controltype = ".$type." and status = 1 and ( limittype < 3  or ( limittype = 3 and endtime > ".time()." and starttime < ".time()."))"); 
		    if(!empty($checkcxinfo1) || !empty($checkcxinfo2)){
				$data['canadd'] = 0;
			    $data['reason'] = '当前已有该类型活动，无法进行创建';
			}else{
				$data['canadd'] = 1;
			    $data['reason'] = '可创建该类型活动';
			}
		}
		$this->success($data); 
	}


    /**
	*@method 新版商家端  终止进行中的活动
	*@request_url http://m6.waimairen.com/index.php?ctrl=app&action=stopcx&uid=10203&pwd=123456&cxid=123&datatype=json 
 	*@所需参数   uid：用户uid   pwd：用户密码  cxid:活动id
	*@备注：   
	*添加时间:2017/9/27    技术：闫
	**/
	function stopcx(){
		$backinfo = $this->checkapp();		 
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$id = IFilter::act(IReq::get('cxid'));
		$ruleinfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."rule where id = ".$id." "); 
		if(empty($ruleinfo))$this->message('活动数据获取失败');  
		$data['status'] = 0;
		$this->mysql->update(Mysite::$app->config['tablepre'].'rule',$data,"id='".$id."'");
		$this->success('success'); 
	}

   /**
	*@method 新版商家端  保存促销活动
	*@request_url http://m6.waimairen.com/index.php?ctrl=app&action=savecxrule&uid=10203&pwd=123456&controltype=1&supporttype=1&limitcontent=30&presenttitle=测试玩具&limittype=1&datatype=json 
 	*@所需参数  
		|  参数名         | 类型   | 说明                                                               |   		 
		|  uid            | string | 用户uid                                                            |
		|  pwd            | string | 密码                                                               |
		|  cxid           | string | 编辑原有活动传活动id  新增不传该参数                               |
		|  controltype    | string | 1满赠活动 2满减活动 3折扣活动 4免配送费 5首单立减                  |
		|  limitcontent   | string | 限制金额  多条满减时  限制金额用逗号隔开 例 30,40,50               |
		|  controlcontent | string | 减免金额  折扣数  多条满减时  减免金额用逗号隔开 例 10,20,30       |   
		|  presenttitle   | string | controltype=1为满赠活动时  需传赠品名称  其他类型活动该参数可不传值| 
		|  limittype      | string | 1不限制 2表示指定星期 3自定义日期                                  |
		|  limittime      | string | limittype=1和3时不传值 limittype=2时传星期  例1,2,5,7              |    
		|  starttime      | string | limittype=3时传值  开始时间 2016-02-02                             |
		|  endtime        | string | limittype=3时传值  结束时间 2016-03-02    	                        |
	*@备注：   
	*添加时间:2017/9/27    技术：闫
	**/
	function savecxrule(){
        $backinfo = $this->checkapp();		 
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
	    $shopinfo = $this->mysql->select_one("select id  from ".Mysite::$app->config['tablepre']."shop  where uid = '".$backinfo['uid']."'  ");
		$data['shopid'] = $shopinfo['id'];	
		if(empty($data['shopid']))$this->message('店铺数据获取失败');        
        $data['parentid'] = 0;
        $data['shopbili'] = 0;
        $data['type'] = 1;//默认购物车限制
		$cxid = intval(IReq::get('cxid'));
        $controltype = intval(IReq::get('controltype'));//1满赠活动 2满减活动 3折扣活动 4免配送费 5首单立减
		$data['controltype'] = $controltype;		
        $setinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."cxruleset where  id = ".$controltype."   " );
		$data['imgurl'] = $setinfo['imgurl'];//活动图标
		$data['supporttype'] = $setinfo['supportorder'];//支持订单类型 1支持全部订单 2只支持在线支付订单
		$data['supportplatform'] = $setinfo['supportplat'];//支持平台类型 1pc 2微信 3触屏 4app
		$data['status'] = 1;
		$ordertype = $data['supporttype']==2?'在线支付满':'满';
		$data['limitcontent'] = IReq::get('limitcontent');
		$data['controlcontent'] = IReq::get('controlcontent');
		if($controltype == 1){//1满赠活动			 
			$data['presenttitle'] = trim(IFilter::act(IReq::get('presenttitle')));
			if(empty($data['limitcontent'])) $this->message('请输入订单限制金额');
			if(empty($data['presenttitle'])) $this->message('请输入赠品名称及数量'); 
			$data['name']= $ordertype.''.$data['limitcontent'].'赠送'.$data['presenttitle'];	 
		}
		if($controltype == 2){//2满减活动
            if(empty($data['limitcontent'])) $this->message('请输入订单限制金额');		
			$limit = explode(',',$data['limitcontent']);
			$jian = explode(',',$data['controlcontent']);
			$name = $data['supporttype']==2?'在线支付':'';
			foreach($limit as $k1=>$v1){
				if($jian[$k1]>$v1){
					$this->message('减免金额不能大于限制金额');		
				}
				$name .= '满'.$v1.'减'.$jian[$k1].';';
			}
			$data['name'] = rtrim($name, ";");
		}
		if($controltype == 3){//3折扣活动			 
			$zhe = $data['controlcontent']/10;
			$data['name']= $ordertype.''.$data['limitcontent'].'享'.$zhe.'折优惠';
			if(empty($data['limitcontent'])) $this->message('请输入订单限制金额');
			if(empty($data['controlcontent'])) $this->message('请输入折扣值'); 
		}
		if($controltype == 4){//4免配送费			 		 
			$data['name']= $ordertype.''.$data['limitcontent'].'免基础配送费';
			if(empty($data['limitcontent'])) $this->message('请输入订单限制金额');			 
		}
		if($controltype == 5){//5首单立减
			$data['limitcontent'] = 0;	            
			$data['name']= '新用户下单立减'.$data['controlcontent'].'元';	 	
		}
        if(empty($data['name'])) $this->message('促销标题不能为空');
        $limittype = intval(IReq::get('limittype'));//1不限制 2表示指定星期 3自定义日期
        $data['limittype'] = in_array($limittype,array('1,','2','3')) ? $limittype:1;
        if($data['limittype'] ==  1){
            $data['limittime'] = '';
        }elseif($data['limittype'] == 2){
            $limittime = IReq::get('limittime');
            if(empty($limittime)) $this->message('请选择星期');
            $data['limittime'] = $limittime;
        }else{
			$starttime = IFilter::act(IReq::get('starttime'));
            $endtime = IFilter::act(IReq::get('endtime'));			
            if(empty($starttime)) $this->message('cx_starttime');
			if(empty($endtime)) $this->message('cx_endtime');        
			$data['starttime'] = strtotime($starttime.' 00:00:00');
			$data['endtime'] = strtotime($endtime.' 23:59:59');
			if($data['endtime'] <= $data['starttime']) $this->message('结束时间不能早于开始时间');     
        } 
         		
        if(empty($cxid)){
			/**新建活动时 检测是否添加过该类型活动**/		
			//待生效
			$checkcxinfo1 = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."rule where parentid = 0 and shopid = ".$shopinfo['id']." and controltype = ".$controltype." and  limittype = 3  and starttime > '.time().' and status = 1  "); 
			//进行中
			$checkcxinfo2 = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."rule where parentid = 0 and shopid = ".$shopinfo['id']." and controltype = ".$controltype." and status = 1 and ( limittype < 3  or ( limittype = 3 and endtime > '.time().' and starttime < '.time().'))");
			if(!empty($checkcxinfo1) || !empty($checkcxinfo2))  $this->message('已存在同类型活动，不可重复添加');
			$data['creattime'] = time();			 
            $this->mysql->insert(Mysite::$app->config['tablepre'].'rule',$data);
        }else{ 
            $oneinfo = $this->mysql->select_one("select parentid  from ".Mysite::$app->config['tablepre']."rule  where id = '".$cxid."'  ");		if($oneinfo['parentid']==1) $this->message('您无权修改平台活动');     
			$this->mysql->update(Mysite::$app->config['tablepre'].'rule',$data,"id='".$cxid."'");
        }
		
        $this->success('success');
	}
	
	
//跑腿8.6升级（2017.4.15）
    function getpaotuiinfo(){
		$helpbuyinfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."helpbuy where isnotsee= 0 order by orderid asc"); 
		$helpmoveinfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."helpmove where isnotsee= 0 order by orderid asc "); 
		$data['helpbuyinfo'] = $helpbuyinfo;
		$data['helpmoveinfo'] = $helpmoveinfo;
		$this->success($data); 
	}
	/** 
	 * @shopapi
     * @name 新版商家端  订单详情地图中   买家、店铺、配送员位置信息 
	 * @other 2017/8/11   闫
     * @orderid   订单id 必传 
	 * @datatype 固定值 json 必传  
	 * @extend 必传登陆验证参数 
	*	 { 
	*	 "error" : "false", 
	*	 "msg" : { 
	*		  "shoplat" : "34.753611", 【店铺坐标lat值】
	*		  "shoplng" : "113.682705", 【店铺坐标lng值】
	*		  "buyerlat" : "34.746423", 【买家坐标lat值】
	*		  "buyerlng" : "113.601503", 【买家坐标lng值】
	*		  "psylng" : "113.54336615668403", 【配送员坐标lng值】
	*		  "psylat" : "34.80242648654514"   【配送员坐标lat值】
	*      } 
	*}
     */  
    function orderlocationinfo(){
	    $orderid = IFilter::act(IReq::get('orderid'));	    
		if(empty($orderid)) $this->message('订单id获取失败');
		$orderinfo = $this->mysql->select_one("select psuid,pstype,status,shoplat,shoplng,buyerlat,buyerlng,psyoverlng,psyoverlat from ".Mysite::$app->config['tablepre']."order where id='".$orderid."' "); 	
		if(empty($orderinfo)) $this->message('订单获取失败');
        $data['shoplat'] = $orderinfo['shoplat'];
		$data['shoplng'] = $orderinfo['shoplng'];
		$data['buyerlat'] = $orderinfo['buyerlat'];
		$data['buyerlng'] = $orderinfo['buyerlng'];
		if($orderinfo['pstype'] != 2){
			$data['psylat'] = '';
		    $data['psylng'] = '';
		}else{
			if($orderinfo['psuid'] > 0){
			     if($orderinfo['status'] == 3){
					 $data['psylng'] = empty($orderinfo['psyoverlng'])?'':$orderinfo['psyoverlng'];
		             $data['psylat'] = empty($orderinfo['psyoverlat'])?'':$orderinfo['psyoverlat'];
				 }else{
					 $psbinterface = new psbinterface();				 
					 $psylocationonfo = $psbinterface->getpsbclerkinfo($orderinfo['psuid']);
					 if( !empty($psylocationonfo) && !empty($psylocationonfo['posilnglat']) ){					
					     $posilnglatarr = explode(',',$psylocationonfo['posilnglat']);
					     $posilng = $posilnglatarr[0];
					     $posilat = $posilnglatarr[1]; 
						 if(!empty($posilng) && !empty($posilat)){
							 $data['psylng'] = $posilng;
							 $data['psylat'] = $posilat;
						 }else{
							 $data['psylng'] = '';
							 $data['psylat'] = '';
						 }	 
				     }else{
						 $data['psylng'] = '';
					     $data['psylat'] = '';
					 }	 					 
				 }	
			}else{
				$data['psylng'] = '';
		        $data['psylat'] = '';	
			}	
		}				
		$this->success($data); 		
	}
	
	/**
	*@method 新版商家端  待处理->退款->同意退款和拒绝退款操作
	*@request_url http://m6.waimairen.com/index.php?ctrl=app&action=drawbackoperation&uid=10203&pwd=123456&operationtype=ok&orderid=29873&datatype=json 
 	*@所需参数   uid：用户uid   pwd：用户密码    operationtype：商家退款操作ok同意退款  no拒绝退款    orderid：订单id 	
	*@备注：当商家同意退款  operationtype参数值传ok   商家拒绝退款  operationtype参数值传no   
	*添加时间:2017/8/9    技术：闫旭明
	**/
	function drawbackoperation(){
		$backinfo = $this->checkapp();		 
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$operationtype = IFilter::act(IReq::get('operationtype'));
		if(empty($operationtype)) $this->message('未定义的操作');
		$orderid = IFilter::act(IReq::get('orderid'));
		if(empty($orderid)) $this->message('订单id获取失败');	
		$orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where id='".$orderid."' "); 	
		if(empty($orderinfo)) $this->message('订单获取失败');		
		if($orderinfo['is_reback'] == 0) $this->message('订单未申请退款');			 
		if($orderinfo['status'] > 3) $this->message('订单已取消');			 
		$drawbacklog = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."drawbacklog where orderid=".$orderid." order by  id desc  limit 0,2");		
		if(empty($drawbacklog)) $this->message('退款申请不存在');			
		if($drawbacklog['status'] > 0 && $drawbacklog['status'] < 3)  $this->message('退款申请已处理'); //退款状态 0未待处理 1为已退 2为拒绝退款 3待商家确认			
		#if($drawbacklog['type'] != 0)  $this->message('商家已处理过退款');
        if($operationtype == 'ok'){
			#$data['type'] = 1;
			$data['status'] = 0;
			$this->mysql->update(Mysite::$app->config['tablepre'].'drawbacklog',$data,"id='".$drawbacklog['id']."'"); 
			$data1['is_reback'] = 1;
			$this->mysql->update(Mysite::$app->config['tablepre'].'order',$data1,"id='".$orderid."'"); 
			$ordCls = new orderclass();
			$ordCls->noticeback($orderid);
            //退款通知配送宝
            if($orderinfo['pstype'] == 2 && $orderinfo['is_make'] == 1){
                $psbinterface = new psbinterface();
                if($psbinterface->psbdraworder($orderid)){

                }
            }
			$this->success('同意退款操作成功'); 
		}else{
			$udata['is_reback'] = 0;//商家拒绝退款后   订单返回原状态
			$this->mysql->update(Mysite::$app->config['tablepre'].'order',$udata,"id='".$orderid."'");
			$ordCls = new orderclass();
			$ordCls->writewuliustatus($orderid,15,$orderinfo['paytype']);  // 拒绝退款
		    $ordCls->noticeunback($orderid); 
            $this->success('拒绝退款操作成功'); 			
		}
	}
	/**
	*@method 新版商家端  门店管理->店铺统计->营业统计
	*@request_url http://m6.waimairen.com/index.php?ctrl=app&action=shopStatistics&uid=12154&pwd=123456&searchtype=today&starttime=2006-1-1&endtime=2018-1-1&datatype=json 
	*@所需参数   searchtype = week:近七天  today:今天  month:近30天  自定义:selfdefined
 	*@所需参数   starttime = 开始时间   endtime = 结束时间
	*@返回数据   total:营业总额  shopsubsidy:商家补贴  validcount:有效订单量  invalidcount:无效订单量
	*@备注：当searchtype参数值为selfdefined时   需要传起止时间starttime和endtime参数   其他情况不需要起止时间参数
	*添加时间:2017/8/5    技术：闫旭明
	**/
	function shopStatistics(){
		$backinfo = $this->checkapp();		 
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
        $shopinfo = $this->mysql->select_one("select id  from ".Mysite::$app->config['tablepre']."shop  where uid = '".$backinfo['uid']."'  ");			
		if(empty($shopinfo)) $this->message('店铺信息获取失败');
		$shopid = $shopinfo['id'];		
		$searchtype = trim(IFilter::act(IReq::get('searchtype')));
		$searchtype = empty($searchtype)?'today':$searchtype;
		$endtime = time();
		$nowtime = strtotime(date('Y-m-d',time())); //当天开始时间		 
		if($searchtype == 'today'){
			$starttime = $nowtime;						
		}
		if($searchtype == 'week'){
			$starttime = $nowtime - 6*86400;			
		}
		if($searchtype == 'month'){
			$starttime = $nowtime - 29*86400;			
		}
		if($searchtype == 'selfdefined'){
			$starttime = strtotime(IReq::get('starttime'));
			$endtime = strtotime(IReq::get('endtime')) + 86400;		
		}
        //营业总额		
		$total =  $this->mysql->select_one("select sum(acountcost) as total from ".Mysite::$app->config['tablepre']."shopjs  where shopid = '".$shopid."'  and addtime > ".$starttime." and addtime < ".$endtime." ");		
        $data['total'] = empty($total['total'])?0:round($total['total'],2);		 
		//商家补贴
		$shopsubsidy = $this->mysql->select_one("select sum(cxcost - shopdowncost) as shopsubsidy  from ".Mysite::$app->config['tablepre']."order  where shopid = '".$shopid."'  and addtime > ".$starttime." and addtime < ".$endtime." and status = 3 and is_reback = 0 ");		
		$data['shopsubsidy'] = empty($shopsubsidy['shopsubsidy'])?0:round($shopsubsidy['shopsubsidy'],2);
		//有效订单量
		$validcount = $this->mysql->select_one("select count(id) as validcount from ".Mysite::$app->config['tablepre']."order  where shopid = '".$shopid."'  and addtime > ".$starttime." and addtime < ".$endtime." and status = 3  ");		
		$data['validcount'] = $validcount['validcount'];
		//无效订单量
		$invalidcount = $this->mysql->select_one("select count(id) as invalidcount from ".Mysite::$app->config['tablepre']."order  where shopid = '".$shopid."'  and addtime > ".$starttime." and addtime < ".$endtime." and status != 3 and is_reback > 0 ");
		$data['invalidcount'] = $invalidcount['invalidcount'];
		 
		$this->success($data); 		
	}
	/**
	*@method 新版商家端  门店管理->设置->配送信息
	*@request_url http://m6.waimairen.com/index.php?ctrl=app&action=shoppsinfo&uid=12154&pwd=123456&datatype=json   	
	*@返回数据   limitcost:起送价  maketime:制作时间  arrivetime:送达时间
	*添加时间:2017/8/5    技术：闫旭明
	**/
	function shoppsinfo(){
		$backinfo = $this->checkapp();		 
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
        $shopinfo = $this->mysql->select_one("select id,shoptype  from ".Mysite::$app->config['tablepre']."shop  where uid = '".$backinfo['uid']."'  ");			
		if(empty($shopinfo)) $this->message('店铺信息获取失败');
		if($shopinfo['shoptype'] == 0){
			$shoppsinfo = $this->mysql->select_one("select limitcost,maketime,arrivetime  from ".Mysite::$app->config['tablepre']."shopfast  where shopid = '".$shopinfo['id']."'  ");			
		}else{
			$shoppsinfo = $this->mysql->select_one("select limitcost,maketime,arrivetime  from ".Mysite::$app->config['tablepre']."shopmarket  where shopid = '".$shopinfo['id']."'  ");
		}
		$this->success($shoppsinfo); 
	}
	/**
	*@method 新版商家端  门店管理->设置->配送信息->保存配送信息
	*@request_url http://m6.waimairen.com/index.php?ctrl=app&action=saveshoppsinfo&uid=12154&pwd=123456&limitcost=10&maketime=10&arrivetime=10&datatype=json   	
	*@所需参数   limitcost:起送价  maketime:制作时间  arrivetime:送达时间
	*添加时间:2017/8/5    技术：闫旭明
	**/
	function saveshoppsinfo(){
		$backinfo = $this->checkapp();		 
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
        $shopinfo = $this->mysql->select_one("select id,shoptype  from ".Mysite::$app->config['tablepre']."shop  where uid = '".$backinfo['uid']."'  ");			
		if(empty($shopinfo)) $this->message('店铺信息获取失败');
		$data['limitcost'] = IFilter::act(IReq::get('limitcost')) ;
		$data['maketime'] = IFilter::act(IReq::get('maketime'));
		$data['arrivetime'] = IFilter::act(IReq::get('arrivetime'));
		if($shopinfo['shoptype'] == 0){
			$this->mysql->update(Mysite::$app->config['tablepre'].'shopfast',$data,"shopid='".$shopinfo['id']."'");
		}else{
			$this->mysql->update(Mysite::$app->config['tablepre'].'shopmarket',$data,"shopid='".$shopinfo['id']."'");
		}
		$this->success('配送信息设置成功！'); 
	}
	/**
	*@method 新版商家端 订单详情->打印订单
	*@request_url http://m6.waimairen.com/index.php?ctrl=app&action=orderprintdata&uid=12154&pwd=123456&dno=15019210358158&datatype=json   	
	*@所需参数   dno:订单编号
	*@返回数据   sitename网站名字       shopname店铺名   bookphone订餐电话  orderstatus订单状态  buyername顾客名字   buyerphone顾客电话  dno订单编号
    *@返回数据   buyeraddress下单地址   addtime下单时间  posttime配送时间   orderdet商品详情     shopps配送费        allcost订单总价     content订单备注
	*添加时间:2017/8/5    技术：闫旭明
	**/
    function orderprintdata(){
		$dno =  IFilter::act(IReq::get('dno'));
		$orderinfo = $this->mysql->select_one("select id,shopid,paystatus,paytype,buyername,buyerphone,buyeraddress,addtime,posttime,shopps,addpscost,content,dno,allcost  from ".Mysite::$app->config['tablepre']."order  where dno= '".$dno."'   ");
		 
		if(empty($orderinfo))  $this->message('订单获取失败！');
		$orderdet =  $this->mysql->getarr("select goodsname,goodscost,goodscount,goodsattr  from ".Mysite::$app->config['tablepre']."orderdet  where order_id= '".$orderinfo['id']."'   ");
		
		foreach($orderdet as $key=>$value){
		    if(empty($value['goodsattr'])){
				$value['goodsattr'] = '份';
			}
			$allcost = $value['goodscost'] * $value['goodscount'];
			$value['allcost'] = number_format($allcost, 2);
			$goods[] = $value;	
		}	
		
		$shopinfo =  $this->mysql->select_one("select shopname,phone  from ".Mysite::$app->config['tablepre']."shop  where id= '".$orderinfo['shopid']."'   ");		 
		$data['sitename'] = Mysite::$app->config['sitename'];		
		$payarrr = array('outpay'=>'到付','open_acout'=>'余额支付');
		$orderpastatus = $orderinfo['paystatus'] == 1?'已支付':'未支付';
		$orderpaytype = isset($payarrr[$orderinfo['paytype']])?$payarrr[$orderinfo['paytype']]:'在线支付';
		$data['shopname'] = $shopinfo['shopname'];
		$data['bookphone'] = $shopinfo['phone'];
		$data['orderstatus'] = $orderpaytype.'('.$orderpastatus.')';
		$data['buyername'] = $orderinfo['buyername'];
		$data['buyerphone'] = $orderinfo['buyerphone'];
		$data['buyeraddress'] = $orderinfo['buyeraddress'];
		$data['addtime'] = date('m-d H:i',$orderinfo['addtime']); 
		$data['posttime'] = date('m-d H:i',$orderinfo['posttime']);
        $data['orderdet'] = $goods;
        $data['shopps'] = $orderinfo['shopps'];
        $data['allcost'] = $orderinfo['allcost'];
		$data['dno'] = $orderinfo['dno'];	
		$data['addpscost'] = $orderinfo['addpscost'];	
		$data['content'] = empty($orderinfo['content'])?'无':$orderinfo['content'];					 
		$this->success($data); 	
	}
	function pthelpme(){  // 跑腿----帮我送/买
                //获取对应模块下的标签
                $id = intval(IReq::get('id'));               
                if(!empty($id)) {                     
                    $title = $this->mysql->select_one(" select name from ".Mysite::$app->config['tablepre']."helpbuy where id = ".$id." ");
                    $bqlist = $this->mysql->getarr(" select name from ".Mysite::$app->config['tablepre']."helpbuybq where parent_id = ".$id." order by id asc");
                }
                 $data['goods'] = IReq::get('goods'); 
                 $data['title'] = $title;
                 $data['bqlist'] = $bqlist;
                 $data['movegoodsname'] = IReq::get('movegoods');   
                 $data['movegoodscost'] = IReq::get('cost');    
                 $data['movegoodsweight'] = IReq::get('weight');    
                 
                 $lng = ICookie::get('lng');
                 $lat = ICookie::get('lat');
                 $mapname = ICookie::get('mapname');
                 $city_id = $this->CITY_ID;
                 $city_name = $this->CITY_NAME;
	 
		if( !empty($city_id) && !empty($city_name) ){
			$where = " where  cityid = '".$city_id."' ";
		}
		
		$data['lng'] = $lng;
		$data['lat'] = $lat;
		$data['mapname'] = $mapname;
	
 		$pttype = intval(IReq::get('pttype')); 
		$data['pttype'] = $pttype;  // 1为帮我送  2为帮我买
		
		$data['ptsetinfo'] = $this->mysql->select_one(" select * from ".Mysite::$app->config['tablepre']."paotuiset ".$where."  "); 
		 
		  $postdate =  $data['ptsetinfo']['postdate'];
		  $befortime = $data['ptsetinfo']['pt_orderday'];
		  if($data['ptsetinfo']['is_ptorderbefore']==0){$befortime = 0;}
		  
 $nowhout = strtotime(date('Y-m-d',time()));//当天最小linux 时间
		$timelist = !empty($postdate)?unserialize($postdate):array();
		$data['pstimelist'] = array();
		$checknow = time();
		
		 
		$whilestatic = $befortime;
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
					$tempt['cost'] =  isset($value['cost'])?$value['cost']:0;
					
					$tempt['name'] = $stime > $checknow?$tempt['s'].'-'.$tempt['e']:'立即配送';
					$data['pstimelist'][] = $tempt;
				}
			}
		 
			$nowwhiltcheck = $nowwhiltcheck+1;
		}
		
		
		$this->success($data); 
	}
	
	
        
	function getofinfo(){
		$default_cityid = isset(Mysite::$app->config['default_cityid'])?Mysite::$app->config['default_cityid']:0;
		
		$areainfo = $this->mysql->select_one("select name from ".Mysite::$app->config['tablepre']."area where adcode=".$default_cityid."  ");
		
		if(empty($areainfo)){
			$cityname = Mysite::$app->config['cityname'];
		}else{
			$cityname = $areainfo['name'];
		}
	 
		
 		$data['default_city_adcode'] = $default_cityid;
		$data['default_city_name'] = $cityname;

		$this->success($data); 
	}
	/*到店消费商家  计算优惠后的金额*/
	
	function shophuicount(){
		    $shopid = trim(IFilter::act(IReq::get('shopid')));		    
			$xfcost  = trim(IFilter::act(IReq::get('shopcost')));
		
		if($shopone['shoptype'] == 0){
            $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop as a left join ".Mysite::$app->config['tablepre']."shopfast as b on a.id = b.shopid where a.id='".$shopid."' "); // 店铺信息
        }else{
            $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop as a left join ".Mysite::$app->config['tablepre']."shopmarket as b on a.id = b.shopid where a.id='".$shopid."' "); // 店铺信息
        }

		  if( $shopinfo['is_shophui'] == 1 ){
           
                $shophuiinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shophui where shopid='".$shopid."' ");  //闪慧信息
                if(!empty($shophuiinfo)  && $shophuiinfo['shopid'] == $shopid) {
					if( $shophuiinfo['controltype'] == 2 ){
						$checkcost = $shophuiinfo['mjlimitcost']; // 每满费用金额
						if( $xfcost >= $checkcost  ){
							$yhcost = $shophuiinfo['controlcontent'];
						}else{ 
						    $yhcost = 0;
						} 
					}
					if( $shophuiinfo['controltype'] == 3 ){
						$checkcost = $shophuiinfo['limitzhekoucost']; // 打折金额限制
						if( $xfcost >= $checkcost  ){
							$yhcost = $xfcost*((100-$shophuiinfo['controlcontent'])/100);	 
						}else{
						    $yhcost = 0;
						}				
					}
				   $data[huihoucost] = $xfcost - $yhcost ;
                }else{
                   $data[huihoucost] = $xfcost ;
                }
            }
			$this->success($data);
        }
			
	
	
	function modify(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		} 
		$phone = trim(IFilter::act(IReq::get('uname')));
		$oldpwd = trim(IFilter::act(IReq::get('oldpwd')));
		$newpwd = trim(IFilter::act(IReq::get('newpwd')));
		$surepwd = trim(IFilter::act(IReq::get('surepwd'))); 
		$code = IFilter::act(IReq::get('code')); 
		if(empty($newpwd)){
			$this->message('新密码不能为空');
		}
		if($newpwd != $surepwd){
			$this->message('新密码和确认密码不一致');
		}
		if(isset($backinfo['temp_password']) && !empty($backinfo['temp_password'])){ 
				$this->message('快捷登录请使用其他方法修改密码'); 
		}
	 
		if($backinfo['password'] != md5($oldpwd)){
			$this->message('旧密码错误');
		}  
		$newdata['password'] = md5($newpwd); 
		$this->mysql->update(Mysite::$app->config['tablepre'].'member',$newdata,"uid='".$backinfo['uid']."'");
		unset($backinfo['password']);
		$this->success($backinfo); 
	}
	function modifyphone(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$phone =  trim(IFilter::act(IReq::get('phone'))); 
		$newphone =  trim(IFilter::act(IReq::get('newphone'))); 
		$code =  trim(IFilter::act(IReq::get('code')));  
	    $member= $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where phone='".$phone."' ");
  	    if(empty($member)){
			$this->message('用户不存在');
		}
		if($backinfo['uid']  != $member['uid']){
		   $this->message('手机号不对应本账号');
		}
		 
		// if($code != $yanzhengcode){
			// $this->message('验证失败');
		// }
	   
		if(!IValidate::suremobi($newphone)){
			$this->message('新手机号格式错误');
		 } 
		  $check2 = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where phone='".$newphone."' ");
  	  
	    if(!empty($check2)){
			 $this->message('新手机号已绑定其他账号不能重复绑定');
		}
		$phonecls = new phonecode($this->mysql,8,$newphone); 
		if($phonecls->checkcode($code)){
			$newdata['phone'] = $newphone;
			$this->mysql->update(Mysite::$app->config['tablepre'].'member',$newdata,"uid='".$member['uid']."'");
			$this->success('success');
		}else{
			$this->message($phonecls->getError());
		}  
	}
  function advimgs(){
	   $type = IFilter::act(IReq::get('imgid'));
	   $imginfo= $this->mysql->select_one("select name,img from ".Mysite::$app->config['tablepre']."appadv where type='".$type."' ");
	   $this->success($imginfo);
	}
	function fastmodify(){ 
		$uid = IFilter::act(IReq::get('uid'));
		$phone = IFilter::act(IReq::get('phone'));
		$oldpwd =  IFilter::act(IReq::get('oldpwd'));
		$newpwd = trim(IFilter::act(IReq::get('newpwd')));
		$surepwd = trim(IFilter::act(IReq::get('surepwd'))); 
		$code = IFilter::act(IReq::get('code')); 
		$member= $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$uid."' ");
		if(empty($member['phone'])){ 
			$this->message('用户未绑定任何手机号');
		}
		if($member['phone'] != $phone){
			$this->message('账号和登录手机号不一致');
		} 
		if(!empty($member['temp_password'])){ 
			if($member['temp_password'] != $oldpwd){
				$this->message('密码错误!');
			}
		}/* else{
			if($member['password'] != md5($oldpwd)){
				$this->message('旧密码错误');
			}
		}   */		
		$newdata['password'] = md5($newpwd);
		$backinfo['temp_password'] = '';
		$this->mysql->update(Mysite::$app->config['tablepre'].'member',$newdata,"uid='".$backinfo['uid']."'");
		unset($backinfo['password']);
		$this->success($backinfo); 
	}
    /** 	
     * @userapi 
     * @name 普通会员登录
     * @uname    账号
	 * @pwd     密码
	 * @userid  设备值
     * @datatype 固定值 json 必传   
	*/
	function appMemlogin(){
		$uname = trim(IFilter::act(IReq::get('uname')));
		$pwd = trim(IFilter::act(IReq::get('pwd')));
		$mDeviceID =  trim(IFilter::act(IReq::get('mDeviceID')));
		if(empty($uname)) $this->message('用户名为空');
		if(empty($pwd)) $this->message('密码为空'); 
		if(!$this->memberCls->login($uname,$pwd)){
	    	    $this->message($this->memberCls->ero());
		}
		$uid = $this->memberCls->getuid();
		$member= $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$uid."' ");
		$tjyhj = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."juan where uid='".$uid."' and status < 2 and  endtime > ".time()." "); 
		if(!empty($member['logo'])){ 
			$member['logo'] = preg_match('/(http:\/\/)|(https:\/\/)/i', $member['logo'])?$member['logo']:Mysite::$app->config['siteurl'].$member['logo'];
		}else{
			$member['logo'] = Mysite::$app->config['siteurl'].Mysite::$app->config['userlogo'];
		}
		
		
		
		$member['juancount'] = $tjyhj;
		$channelid = trim(IFilter::act(IReq::get('channelid')));
		$userid = trim(IFilter::act(IReq::get('userid')));
		
		
		  
		 ICookie::set('appuid',$member['uid'],86400);
		 
		 
		 
		if(!empty($userid)){
			$checkmid =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."appbuyerlogin where uid='".$uid."' ");
			if(empty($checkmid)){
				$Mdata['channelid'] = $channelid;
				$Mdata['userid'] = $userid;
				$Mdata['uid']=$uid;
				$Mdata['addtime'] = time(); 
				$this->mysql->insert(Mysite::$app->config['tablepre'].'appbuyerlogin',$Mdata);  //插入新数据
			}else{
				if($checkmid['userid'] != $userid){ 
						$Mdata['channelid'] = $channelid;
						$Mdata['userid'] = $userid;
						$Mdata['uid']=$uid;
						$Mdata['addtime'] = time();
						$this->mysql->update(Mysite::$app->config['tablepre'].'appbuyerlogin',$Mdata,"uid='".$backinfo['uid']."'"); 
				}
			}
	    }
		unset($member['password']);
		$this->success($member);
	}
	function fastlogin(){
		$phone = trim(IFilter::act(IReq::get('phone'))); 
		$code =  trim(IFilter::act(IReq::get('code')));
		 
		$phonecls = new phonecode($this->mysql,4,$phone); 
		if($phonecls->checkcode($code)){
			$member = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where phone='".$phone."' ");
		    if(empty($member)){ 
			     $checkphone = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."mobileapp where phone ='".$phone."'   order by addtime desc limit 0,1");
				 $temp_password = rand(100000,999999);  
				 $checkstr = md5($checkphone['phone']);
				 $arr['username'] = substr($checkstr,0,8);
				 $arr['phone'] = $checkphone['phone'];
				 $arr['address'] = '';
				 $arr['password'] = md5($temp_password);
				 $arr['email'] = '';
				 $arr['creattime'] = time(); 
				 $arr['score']  = $score == 0?Mysite::$app->config['regesterscore']:$score;
				 $arr['logintime'] = time(); 
				 $arr['logo'] = Mysite::$app->config['userlogo'];
				 $arr['loginip'] = IClient::getIp();
				 $arr['group'] = 5;
				 $arr['cost'] = 0; 
				 $arr['parent_id'] =0;
				 $arr['temp_password'] = $temp_password;
				 $this->mysql->insert(Mysite::$app->config['tablepre'].'member',$arr);   
				 $uid = $this->mysql->insertid(); 
				 if($arr['score'] > 0){
					$this->memberCls->addlog($uid,1,1,$arr['score'],'注册送积分','注册送积分'.$arr['score'],$arr['score']);
				 } 
         $juansetinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 2 or name = '注册送优惠券' " );  	   
         $juaninfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."alljuan where type = 2 or name= '注册送优惠券' order by id asc " );	   
		 if($juansetinfo['status'] ==1 && !empty($juaninfo)){
	 	   //注册送优惠券		   		   	  
		   foreach($juaninfo as $key=>$value){			   
			   $juandata['uid'] = $this->uid;// 用户ID	
			   $juandata['username'] = $arr['username'];// 用户名
			   $juandata['name'] = $value['name'];//  优惠券名称 
			   $juandata['status'] = 1;// 状态，0未使用，1已绑定，2已使用，3无效	
			   $juandata['card'] = $nowtime.rand(100,999);
			   $juandata['card_password'] =  substr(md5($juandata['card']),0,5);
			   $juandata['limitcost']	= $value['limitcost'];	
			   
			   if($juansetinfo['timetype'] == 1){
					$juandata['creattime'] = time();
					$date = date('Y-m-d',$juandata['creattime']);
					$endtime = strtotime($date) + ($juansetinfo['days']-1)*24*60*60 + 86399;
					$juandata['endtime'] = $endtime;
			   }else{
					$juandata['creattime'] = $value['starttime'];
					$juandata['endtime'] =  $value['endtime'];
			   }
               if($juansetinfo['costtype'] == 1){
				    $juandata['cost'] = $value['cost'];
			   }else{
					$juandata['cost'] = rand($value['costmin'],$value['costmax']);
			   }			   			   		  	    		   
			   $this->mysql->insert(Mysite::$app->config['tablepre'].'juan',$juandata);			   
		   } 
       }	   
					   		  				   
			$member = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$uid."' ");
			}
			$tjyhj = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."juan where uid='".$member['uid']."' and status < 2 and  endtime > ".time()." ");
			$member['logo'] = empty($member['logo'])?Mysite::$app->config['siteurl'].Mysite::$app->config['userlogo']:Mysite::$app->config['siteurl'].$member['logo'];
			$member['juancount'] = $tjyhj;
			$member['temp_password'] = md5(rand(100000,999999));  
			
			$channelid = trim(IFilter::act(IReq::get('channelid')));
			$userid = trim(IFilter::act(IReq::get('userid')));
			if(!empty($userid)){
				$checkmid =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."appbuyerlogin where uid='".$uid."' ");
				if(empty($checkmid)){
					$Mdata['channelid'] = $channelid;
					$Mdata['userid'] = $userid;
					$Mdata['uid']=$uid;
					$Mdata['addtime'] = time(); 
					$this->mysql->insert(Mysite::$app->config['tablepre'].'appbuyerlogin',$Mdata);  //插入新数据
				}else{
					if($checkmid['userid'] != $userid){ 
							$Mdata['channelid'] = $channelid;
							$Mdata['userid'] = $userid;
							$Mdata['uid']=$uid;
							$Mdata['addtime'] = time();
							$this->mysql->update(Mysite::$app->config['tablepre'].'appbuyerlogin',$Mdata,"uid='".$backinfo['uid']."'"); 
					}
				}
			}
			$expire = time() + 86400; // 设置24小时的有效期
			setcookie("app_login", "app_login", $expire);
			setcookie("app_loginphone", $phone, $expire); 
			unset($member['password']);
			$this->success($member);
			 
		}else{
			$this->message($phonecls->getError());
		}
	}
	function updateuserimg(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}    
		$json = new Services_JSON();
		$uploadpath = 'upload/user/';
		$filepath = '/upload/user/';
		$upload = new upload($uploadpath,array('gif','jpg','jpge','png'));//upload
		$file = $upload->getfile();
		if($upload->errno!=15&&$upload->errno!=0) {
			$this->message($upload->errmsg());

		}else{
			$data['logo'] = $filepath.$file[0]['saveName'];
		    $this->mysql->update(Mysite::$app->config['tablepre'].'member',$data,"uid='".$backinfo['uid']."'  "); 
			$this->success($data);
		} 
	}
	function fastupdateuserimg(){
		$uid = trim(IFilter::act(IReq::get('uid')));
		if(empty($uid)){
			$this->message('未登录');
		} 
		$json = new Services_JSON();
		$uploadpath = 'upload/user/';
		$filepath = '/upload/user/';
		$upload = new upload($uploadpath,array('gif','jpg','jpge','png'));//upload
		$file = $upload->getfile();
		if($upload->errno!=15&&$upload->errno!=0) {
			$this->message($upload->errmsg()); 
		}else{
			$data['logo'] = $filepath.$file[0]['saveName'];
		    $this->mysql->update(Mysite::$app->config['tablepre'].'member',$data,"uid='".$uid."'  "); 
			$this->success($data);
		} 
	}
	
	/*
	  保存APP通知百度信息
	  参数
	  uid  用户UID
	  pwd 用户密码
	  channelid  百度地图ID
	  userid  百度地图生成的userid
	  公共代码  保存百度 账号绑定信息
	*/
	function testlist(){
		$ztylist =   $this->mysql->getarr("select* from ".Mysite::$app->config['tablepre']."specialpage where is_show=1  order by orderid  asc");
		$data['ztylist'] = $ztylist;
		print_r($ztylist);
		exit;
	}
	function appbaidu(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		if($backinfo['group'] != 3){
		   $this->message('noshangjia');
		}
		$channelid = trim(IFilter::act(IReq::get('channelid')));
		$userid = trim(IFilter::act(IReq::get('userid')));
		if(empty($userid)) $this->message('获取失败');
		// if(empty($channelid)) $this->message('changlid获取失败');
		$checkmid =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."applogin where uid='".$backinfo['uid']."' ");
  		if(empty($checkmid)){
  		      $Mdata['channelid'] = $channelid;
  		       $Mdata['userid'] = $userid;
	          $Mdata['uid']=$backinfo['uid'];
	          $Mdata['addtime'] = time();
	      //    $this->mysql->delete(Mysite::$app->config['tablepre']."applogin"," channelid='".$channelid."' and  userid = '".$userid."'"); //删除设备历史记录
            $this->mysql->insert(Mysite::$app->config['tablepre'].'applogin',$Mdata);  //插入新数据
  		}else{
			if($checkmid['userid'] != $userid){
  			 	//     $this->mysql->delete(Mysite::$app->config['tablepre']."applogin"," uid='".$backinfo['uid']."'  "); //删除数据库用户
	           //  $this->mysql->delete(Mysite::$app->config['tablepre']."applogin"," channelid='".$channelid."' and userid = '".$userid."' "); //删除历史相同设备ID
	           $Mdata['channelid'] = $channelid;
  		       $Mdata['userid'] = $userid;
	           $Mdata['uid']=$backinfo['uid'];
	           $Mdata['addtime'] = time();
			   $this->mysql->update(Mysite::$app->config['tablepre'].'applogin',$Mdata,"uid='".$backinfo['uid']."'");  
  			}
  		}

		$this->success('操作成功');


	}
	function getgoodsattr(){
		$shoptype = intval(IFilter::act(IReq::get('shoptype')));
		//shoptype == 1 时获取 所有 超市 规格
		$gglist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodsgg where   shoptype=".$shoptype." and parent_id = 0  order by id desc limit 0,1000  ");
				 
				$product_attr = array();
				if(!empty($gglist)){//获取所有规格不为空
				   foreach($gglist as $key=>$value){
					       
							    $value['det'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodsgg where   parent_id = ".$value['id']."  order by id desc limit 0,1000  ");
						      
								$product_attr[] = $value; 
				   }
				}
		$this->success($product_attr);		 
				exit;
	}
  
	/*
	*  检测商家是否登陆
	*/
	function checkapp(){
		$uid = trim(IFilter::act(IReq::get('uid')));
		$pwd = trim(IFilter::act(IReq::get('pwd')));
		$member= $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$uid."' ");
		 
		$backarr = array('uid'=>0);
		if(!empty($member)){
			if($member['password'] == md5($pwd)){
				$backarr = $member;
			}

		}
		return $backarr;
	}
	/*
	* 商家获取促销规则
	2015-12-26新增
	*/
	function shopcxlist(){
		 
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		  
		 
		if(empty($shopinfo)) $this->message('获取店铺资料失败'); 
		$controltype = intval(IFilter::act(IReq::get('controltype')));
		$controltype = in_array($controltype,array(1,2,3,4))?$controltype:1;
		 
		$page = intval(IFilter::act(IReq::get('page')));
		$pagesize = intval(IFilter::act(IReq::get('pagesize'))); 
		$pagesize = $pagesize > 0? $pagesize:10; 
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);  
		$tempcxlist =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."rule where  FIND_IN_SET(".$shopinfo['id'].",shopid)   and controltype='".$controltype."' order by id desc  limit   ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."  ");
        $cxlist = array();
        foreach($tempcxlist as $key=>$value){
			$tempc = array();
			$tempc['id'] = $value['id'];
			$tempc['name'] = $value['name'];
			$tempc['status'] = $value['status'];
			$content_c = '';
			$tempc['starttime'] = date('Y-m-d H:i',$value['starttime']);
			$tempc['endtime'] = date('Y-m-d H:i',$value['endtime']);
//			print_r($value);exit;
			if($value['limittype'] == 1){
				$content_c = '';
			}elseif($value['limittype'] == 2){
				$content_c = '每周星期【'.rtrim($value['limittime'], ",").'】';
			}elseif($value['limittype'] == 3){
				$content_c = '每天时间【'.rtrim($value['limittime'], ",").'】';
			}
			if($value['controltype'] == 1){
				$content_c .= '订单总金额不少于'.$value['limitcontent'].'元，赠送'.$value['presenttitle'];
			}elseif($value['controltype'] == 2){
					$content_c .= '订单总金额不少于'.$value['limitcontent'].'元，减'.$value['controlcontent'].'元';
			}elseif($value['controltype'] == 3){
				$tempdd = $value['controlcontent']*0.1;
					$content_c .= '订单总金额不少于'.$value['limitcontent'].'元，'.$tempdd.'折';
			}elseif($value['controltype'] == 4){
					$content_c .= '订单总金额不少于'.$value['limitcontent'].'元，免配送费';
			}
			$tempc['content_c'] = $content_c;
			$cxlist[] = $tempc;
			
		} 
		$this->success($cxlist);
	}
	function getshopcx(){ 
	 
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');  
		 
		 
		$id = intval(IFilter::act(IReq::get('id')));
		$temparr  =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."rule where shopid='".$shopinfo['id']."'  and id='".$id."' order by id desc  limit 0,1 ");
        if(!empty($temparr)){
			$data['cxinfo'] =$temparr;
			$data['cxinfo']['starttime'] = date('Y-m-d',$data['cxinfo']['starttime']);
			$data['cxinfo']['endtime'] = date('Y-m-d',$data['cxinfo']['endtime']);
			
			if($data['cxinfo']['controltype'] ==3){
				$data['cxinfo']['controlcontent'] = $data['cxinfo']['controlcontent']*0.1;
			}
			
		}else{
			$data['cxinfo']  = '';
		}
	
	   $this->success($data);  
	}
	/*新版商家端  
	获取单条促销活动详情
	2017-07-14 yxm
	**/
	function getcxdetail(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$id = intval(IFilter::act(IReq::get('id')));
		$cxinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."rule where id='".$id."' ");
        /*活动的起止时间  格式重组*/
		$starttime = $cxinfo['starttime'];		
		$stime['year'] =  date('Y',$starttime);		
		$stime['mouth'] =  date('m',$starttime);		
		$stime['day'] =  date('d',$starttime);
		$cxinfo['starttime'] = $stime;
		 
		$endtime = $cxinfo['endtime'];
		$etime['year'] =  date('Y',$endtime);
		$etime['mouth'] =  date('m',$endtime);
		$etime['day'] =  date('d',$endtime);
		$cxinfo['endtime'] = $etime;
	    $this->success($cxinfo); 
	}
	function savecx(){
		 
		 
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');   
		 
		 $id = intval(IFilter::act(IReq::get('id')));
		 $data['name'] = trim(IFilter::act(IReq::get('name')));
		 if(empty($data['name'])) $this->message('促销活动标题不能为空'); 
		 if($id > 0){
			 $temparr  =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."rule where shopid='".$shopinfo['id']."'  and id='".$id."' order by id desc  limit 0,1 ");
			 if(empty($temparr)){
				 $this->message('促销规则不存在');
			 }
      
		 }
		 $limittype = intval(IFilter::act(IReq::get('limittype')));
        $data['supporttype'] = IFilter::act(IReq::get('supporttype'));//支持类型：1首单有效，2在线支付有效
        $data['supportplatform'] = IFilter::act(IReq::get('supportplatform'));//支持平台：1pc端，2微信端，3触屏端，4客户端（安卓苹果）
		 if($limittype == 2){
			 $data['limittype'] =2;
			 $data['limittime'] = trim(IFilter::act(IReq::get('limittime')));//格式 未1到7中任意组合   使用逗号分隔 
		 }elseif($limittype == 3){
			  $data['limittype'] =3;
			  $data['limittime'] = trim(IFilter::act(IReq::get('limittime')));//使用 08:00-09:00 多个时间段,分隔
		 }else{
			 $data['limittype'] =1;
			 $data['limittime'] = '';
		 }
		 $data['limitcontent'] = intval(IFilter::act(IReq::get('limitcontent')));
		 $controltype = intval(IFilter::act(IReq::get('controltype')));
		 if(!in_array($controltype,array('1','2','3','4'))) $this->message('未设置的促销类型');
	     $data['controltype'] = $controltype;
		 $data['presenttitle'] = $controltype == 1? trim(IFilter::act(IReq::get('presenttitle'))):'';
		 $controlcontent = IFilter::act(IReq::get('controlcontent'));
		 $data['controlcontent'] = $controltype == 3? intval($controlcontent*10):intval($controlcontent);  
		 if($controltype ==2 || $controltype ==3){
			 if($data['controlcontent'] < 1) $this->message('减少金额或者折扣不能等于0');
		 }elseif($controltype == 1){
			  if(empty($data['presenttitle']))$this->message('赠品标题不能为空');
		 }
		 $data['shopid'] = $shopinfo['id'];
		 $data['cattype'] = $shopinfo['shoptype'];
		 $data['status'] = intval(IFilter::act(IReq::get('status')));
		 $data['signid'] = intval(IFilter::act(IReq::get('signid')));
		 if(empty($data['signid']))$this->message('请选择促销标签');
		 $data['starttime'] = strtotime(IFilter::act(IReq::get('starttime')));
		 $data['endtime'] = strtotime(IFilter::act(IReq::get('endtime')))+86399; 
		 if($data['starttime']>$data['endtime'])$this->message('开始时间不能大于结束时间');
		 $data['type'] = 1;
		 if($id > 0){
			  $this->mysql->update(Mysite::$app->config['tablepre'].'rule',$data,"id='".$id."'");  
		 }else{
			 $this->mysql->insert(Mysite::$app->config['tablepre'].'rule',$data);  //插入新数据
			 $id = $this->mysql->insertid();
		 } 
		 $this->success($id); 
	}
	function delcx(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');   
		 
		 $id = intval(IFilter::act(IReq::get('id')));
		 if(empty($id)) $this->message('促销ID为空'); 
	      
		 $temparr  =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."rule where shopid='".$shopinfo['id']."'  and id='".$id."'  ");
		 if(empty($temparr)) $this->message('促销规则不存在');
		 $this->mysql->delete(Mysite::$app->config['tablepre']."rule"," shopid='".$shopinfo['id']."' and id=".$id." ");
		 $this->success('操作成功'); 
	}
	
	 
	
	/**
	获取商家评价 
	2015-12-26
	***/
	function managescommt(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,shoplogo,shoptype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,intr_info,notice_info from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		 
		$page = intval(IFilter::act(IReq::get('page')));
		$pagesize = intval(IFilter::act(IReq::get('pagesize'))); 
		$pagesize = $pagesize > 0? $pagesize:10;
		$pointtype = intval(IFilter::act(IReq::get('pointtype')));
		$pointwherearr = array(
		0=>' and point > 0',
		1=>' and point > 4',
		2=>' and point > 1 and point < 5',
		3=>' and point < 2', 
		);
		$tempwhere =  isset($pointwherearr[$pointtype]) ? $pointwherearr[$pointtype]:'';
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);   
		
		$backdata = array();
		#$memberlog = $this->mysql->getarr("select a.*,b.username,b.logo,c.name from ".Mysite::$app->config['tablepre']."comment as a left join  ".Mysite::$app->config['tablepre']."member as b on a.uid = b.uid left join ".Mysite::$app->config['tablepre']."goods as c on a.goodsid = c.id  where a.shopid=".$shopinfo['id']." ".$tempwhere." order by a.id desc   limit   ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."  ");
	     
		$orderid = $this->mysql->getarr("select id from ".Mysite::$app->config['tablepre']."order   where shopid ='".$shopinfo['id']."'   ".$tempwhere." and status = 3   order by id desc limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()." ");
		 
		 
		foreach($orderid as $k=>$v){
			 $usercomment = array();
			 $comment = array();
			 $commentinfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."comment  where shopid ='".$shopinfo['id']."' and orderid = ".$v['id']." ");			 
			 if(!empty($commentinfo)){
			    foreach($commentinfo as $k1=>$v1){
					 $v1['addtime'] = date('Y-m-d',$v1['addtime']);
					 if(empty($v1['replycontent'])){				  
					 $v1['replycontent'] = '';
					 $v1['replytime'] = '';
					 }else{					 
						$v1['replytime'] = date('Y-m-d',$v1['replytime']);
					 }
					 $v1['virtualname'] = empty($v1['virtualname'])?'':$v1['virtualname'];
					 $goodsinfo = $this->mysql->select_one("select goodsname  from ".Mysite::$app->config['tablepre']."orderdet where id='".$v1['orderdetid']."' ");
					 $v1['name'] = $goodsinfo['goodsname']; 
					 $comment[] = $v1;
				}
				 $uid = $comment[0]['uid'];
				 $userinfo = $goodsinfo = $this->mysql->select_one("select username,logo  from ".Mysite::$app->config['tablepre']."member where uid='".$uid."' ");	 
				 $usercomment['orderid'] = $comment[0]['orderid'];
				 $usercomment['username'] = $userinfo['username'];
				 $usercomment['logo'] = $userinfo['logo'];
				 $usercomment['addtime'] = $comment[0]['addtime'];			 
				 $usercomment['replycontent'] = $comment[0]['replycontent'];
				 $usercomment['replytime'] = $comment[0]['replytime'];
				 $usercomment['repstatus'] = empty($usercomment['replycontent'])?1:0;
				 $usercomment['commentinfo'] = $comment;
				 $backdata[]=$usercomment;
			 }
		}
		$this->success($backdata); 
	}
	/*
	商家提交评价回复
	2017/10/8修改
	之前商家回复是针对某条商品的评论进行回复  现在改为商家对某个订单中的商品评价进行统一回复  同一订单的商品评价 收到商家的回复是一样的   展示时取该订单中商品评价回复中的第一条进行展示
	*/
	function shopreplyping(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,shoplogo,shoptype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,intr_info,notice_info from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		
		$orderid = intval(IFilter::act(IReq::get('orderid')));
		$content = trim(IFilter::act(IReq::get('replaycontent')));
		$data['replytime'] = time();
		$checkcomment = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."comment   where orderid ='".$orderid."'     order by id desc limit 0,1 ");
	 
		if(empty($checkcomment)) $this->message('评价不存在');
		if(!empty($checkcomment['replycontent'])) $this->message('该评价已回复');
		if($checkcomment['shopid'] != $shopinfo['id']) $this->message('该评价不属于该店铺');
		if(empty($content)) $this->message('评价回复不能为空');
		$data['replycontent'] = $content;
		$this->mysql->update(Mysite::$app->config['tablepre'].'comment',$data,"orderid='".$orderid."'");  
		$this->success('success');
	}
	/**
	*@method 新版商家端 待处理->待处理订单列表
	*@request_url http://m6.waimairen.com/index.php?ctrl=app&action=appwaitorder&uid=10203&pwd=123456&datatype=json&page=1	 
 	*@所需参数   uid   pwd	 
	*添加时间:2017/6/26    技术：闫旭明
    **/	
	function appwaitorder(){
		  
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		 
		$page = intval(IFilter::act(IReq::get('page')));
		$pagesize = intval(IFilter::act(IReq::get('pagesize'))); 
		$pagesize = $pagesize > 0? $pagesize:10; 
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);   
  		/*
	    获取平台设置的结算公式			
 	    */
		$jsinfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."jscompute where id > 0  ");
		$data['ptyj'] = $jsinfo[0];   //平台配送情况下的佣金设置
		$data['sjyj'] = $jsinfo[1];   //商家配送情况下的佣金设置
		$data['ptjs'] = $jsinfo[2];   //平台配送情况下的结算设置
		$data['sjjs'] = $jsinfo[3];   //商家配送情况下的结算设置	
		 
		$orderlist =  $this->mysql->getarr("select id,content,pstype,cxcost,bagcost,shopps,shopdowncost,shopcost,addtime,shopid,posttime,paytype,paystatus,dno,allcost,status,is_make,daycode,buyeruid,buyername,buyerphone,buyeraddress,postdate from ".Mysite::$app->config['tablepre']."order where shopuid = ".$backinfo['uid']." and  status > 0 and status < 2 and is_make = 0 and is_reback = 0 order by addtime desc  limit   ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."   ");   /* and posttime < ".$endtime." */
		 
		
		if(empty($orderlist)){
			$this->message('暂无符合条件的订单');
		}
		foreach($orderlist as $key=>$value){
		 		
  
		$scoretocost =Mysite::$app->config['scoretocost'];
		$scorcost = $value['scoredown'] > 0? intval($value['scoredown']/$scoretocost):0;
		$value['allcx'] = $value['cxcost']+$value['yhjcost']+$scorcost;
	    if($value['paytype'] == 0){
			$value['paystatustype'] = "货到支付";
		}else{
		    $value['paystatustype'] =  empty($value['paystatus'])?'未支付':'已支付';	
		}
		$value['addtime'] = date('H:i:s',$value['addtime']);
		$value['posttime'] = date('Y-m-d',$value['posttime'])." ".$value['postdate'];
		//下单次数		 	 
		$sdf = $this->mysql->getarr("select  dno from ".Mysite::$app->config['tablepre']."order where buyeruid = ".$value['buyeruid']." and shopid = ".$value['shopid']."  ");
			 
				foreach($sdf as $k=>$v){
					if($v['dno']==$value['dno']){
						$value['orderNum'] = $k+1;
					}
				}
		$value['orderNum'] = $value['orderNum'];
		//计算佣金(平台服务费)和结算金额(本单预计收入)
	    $shopinfo =   $this->mysql->select_one("select id,yjin,shoptype from ".Mysite::$app->config['tablepre']."shop where id='".$value['shopid']."' ");
        if($shopinfo['shoptype'] == 0){
		    $sendinfo = $this->mysql->select_one("select sendtype from ".Mysite::$app->config['tablepre']."shopfast where shopid='".$value['shopid']."' ");	
		}else{
		    $sendinfo = $this->mysql->select_one("select sendtype from ".Mysite::$app->config['tablepre']."shopmarket where shopid='".$value['shopid']."' ");				
		}
		 
		if($sendinfo['sendtype'] == 1){
			
			//计算商家配送情况下佣金
			$sjyjnum = $value['shopcost'];
            if($data['sjyj']['pscost'] == 1){
			    $sjyjnum = 	$sjyjnum + $value['shopps'];
			}
			if($data['sjyj']['bagcost'] == 1){
			    $sjyjnum = 	$sjyjnum + $value['bagcost'];
			}
			if($data['sjyj']['shopdowncost'] == 1){
			    $sjyjnum = 	$sjyjnum - ($value['cxcost'] - $value['shopdowncost']);
			}
			$value['servicecost'] = $sjyjnum * $shopinfo['yjin'] * 0.01;//平台服务费（佣金）
			$value['servicecost'] = round($value['servicecost'] ,2);
			//计算商家配送情况下本单预计收入（结算金额）
			$sjjsnum = $value['shopcost'];
            if($data['sjjs']['pscost'] == 1){
			    $sjjsnum = 	$sjjsnum + $value['shopps'];
			}
			if($data['sjjs']['bagcost'] == 1){
			    $sjjsnum = 	$sjjsnum + $value['bagcost'];
			}
			if($data['sjjs']['shopdowncost'] == 1){
			    $sjjsnum = 	$sjjsnum - ($value['cxcost'] - $value['shopdowncost']);
			}			
			$value['expectincome'] = $sjjsnum - $value['servicecost'];//本单预计收入（结算金额）		
		    $value['expectincome'] = round($value['expectincome'] ,2);
		}else{
			 
			//计算平台配送情况下佣金
			$ptyjnum = $value['shopcost'];          			
			if($data['ptyj']['pscost'] == 1){
			    $ptyjnum = 	$ptyjnum + $value['shopps'];
			}
			if($data['ptyj']['bagcost'] == 1){
			    $ptyjnum = 	$ptyjnum + $value['bagcost'];
			}
			if($data['ptyj']['shopdowncost'] == 1){
			    $ptyjnum = 	$ptyjnum - ($value['cxcost'] - $value['shopdowncost']);
			}
			$value['servicecost'] = $ptyjnum * $shopinfo['yjin'] * 0.01;//平台服务费（佣金）
			$value['servicecost'] = round($value['servicecost'] ,2);
			//计算平台配送情况下本单预计收入（结算金额）
			$ptjsnum = $value['shopcost'];
            if($data['ptjs']['pscost'] == 1){
			    $ptjsnum = 	$ptjsnum + $value['shopps'];
			}
			if($data['ptjs']['bagcost'] == 1){
			    $ptjsnum = 	$ptjsnum + $value['bagcost'];
			}
			if($data['ptjs']['shopdowncost'] == 1){
			    $ptjsnum = 	$ptjsnum - ($value['cxcost'] - $value['shopdowncost']);
			}			
		    $value['expectincome'] = $ptjsnum - $value['servicecost'];//本单预计收入（结算金额）
            $value['expectincome'] = round($value['expectincome'] ,2);			
		}	
		$templist =   $this->mysql->getarr("select id,order_id,goodsname,goodscost,goodscount from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$value['id']."' ");
		$newdatalist = array();
		$shuliang = 0;
		 
		foreach($templist as $key=>$value1){
			$value1['goodscost'] = $value1['goodscost'];
			$newdatalist[] = $value1; 
			$shuliang += $value1['goodscount'];
		}
		
		$value['det'] = $newdatalist;

		if(!empty($value['othertext'])){
			$tempcontent = unserialize($value['othertext']);
			foreach($tempcontent as $key=>$value){
				$value['content'] = $value['content'].$key.':'.$value.',';
			}
		}

		$waitorderlist[] = $value;
		}
		
   
		$this->success($waitorderlist);
	}
	
	
    /**
	*@method 新版商家端 待处理->获取待商家处理退款订单个数
	*@order表中   is_reback字段值代表意义：0正常状态   1退款中待平台处理  2退款成功  3拒绝退款   4退款中待商家处理
	*@request_url http://m6.waimairen.com/index.php?ctrl=app&action=getrebackordercount&uid=10203&pwd=123456&datatype=json
 	*@所需参数   uid   pwd	 
	*添加时间:2017/8/10
	**/
    function getrebackordercount(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$rebackcount =  $this->mysql->counts("select id  from ".Mysite::$app->config['tablepre']."order where shopuid = ".$backinfo['uid']." and is_reback = 4 ");  
	    $this->success($rebackcount);
	}
	
	
	/**
	*@method 新版商家端 待处理->待商家处理退款订单列表
	*@request_url http://m6.waimairen.com/index.php?ctrl=app&action=apprebackorder&uid=10203&pwd=123456&datatype=json&page=1	 
 	*@所需参数   uid   pwd	 
	*添加时间:2017/8/9    技术：闫旭明
	**/
	function apprebackorder(){
		  
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		 
		$page = intval(IFilter::act(IReq::get('page')));
		$pagesize = intval(IFilter::act(IReq::get('pagesize'))); 
		$pagesize = $pagesize > 0? $pagesize:10; 
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);   
  		/*
	    获取平台设置的结算公式			
 	    */
		$jsinfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."jscompute where id > 0  ");
		$data['ptyj'] = $jsinfo[0];   //平台配送情况下的佣金设置
		$data['sjyj'] = $jsinfo[1];   //商家配送情况下的佣金设置
		$data['ptjs'] = $jsinfo[2];   //平台配送情况下的结算设置
		$data['sjjs'] = $jsinfo[3];   //商家配送情况下的结算设置	
		 
		$orderlist =  $this->mysql->getarr("select id,content,pstype,is_reback,cxcost,bagcost,shopps,shopdowncost,shopcost,addtime,shopid,posttime,paytype,paystatus,dno,allcost,status,is_make,daycode,buyeruid,buyername,buyerphone,buyeraddress,postdate from ".Mysite::$app->config['tablepre']."order where shopuid = ".$backinfo['uid']." and is_reback = 4 order by addtime desc  limit   ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."   ");  
		 
		 
		if(empty($orderlist)){
			$this->message('暂无符合条件的订单');
		}
		foreach($orderlist as $key=>$value){
		 		
  
		$scoretocost =Mysite::$app->config['scoretocost'];
		$scorcost = $value['scoredown'] > 0? intval($value['scoredown']/$scoretocost):0;
		$value['allcx'] = $value['cxcost']+$value['yhjcost']+$scorcost;
	    if($value['paytype'] == 0){
			$value['paystatustype'] = "货到支付";
		}else{
		    $value['paystatustype'] =  empty($value['paystatus'])?'未支付':'已支付';	
		}
		$value['addtime'] = date('H:i:s',$value['addtime']);
		$value['posttime'] = date('Y-m-d',$value['posttime'])." ".$value['postdate'];
		//下单次数		 	 
		$sdf = $this->mysql->getarr("select  dno from ".Mysite::$app->config['tablepre']."order where buyeruid = ".$value['buyeruid']." and shopid = ".$value['shopid']."  ");
			 
				foreach($sdf as $k=>$v){
					if($v['dno']==$value['dno']){
						$value['orderNum'] = $k+1;
					}
				}
		$value['orderNum'] = $value['orderNum'];
		//计算佣金(平台服务费)和结算金额(本单预计收入)
	    $shopinfo =   $this->mysql->select_one("select id,yjin,shoptype from ".Mysite::$app->config['tablepre']."shop where id='".$value['shopid']."' ");
        if($shopinfo['shoptype'] == 0){
		    $sendinfo = $this->mysql->select_one("select sendtype from ".Mysite::$app->config['tablepre']."shopfast where shopid='".$value['shopid']."' ");	
		}else{
		    $sendinfo = $this->mysql->select_one("select sendtype from ".Mysite::$app->config['tablepre']."shopmarket where shopid='".$value['shopid']."' ");				
		}
		 
		if($sendinfo['sendtype'] == 1){
			
			//计算商家配送情况下佣金
			$sjyjnum = $value['shopcost'];
            if($data['sjyj']['pscost'] == 1){
			    $sjyjnum = 	$sjyjnum + $value['shopps'];
			}
			if($data['sjyj']['bagcost'] == 1){
			    $sjyjnum = 	$sjyjnum + $value['bagcost'];
			}
			if($data['sjyj']['shopdowncost'] == 1){
			    $sjyjnum = 	$sjyjnum - ($value['cxcost'] - $value['shopdowncost']);
			}
			$value['servicecost'] = $sjyjnum * $shopinfo['yjin'] * 0.01;//平台服务费（佣金）
			$value['servicecost'] = round($value['servicecost'] ,2);
			//计算商家配送情况下本单预计收入（结算金额）
			$sjjsnum = $value['shopcost'];
            if($data['sjjs']['pscost'] == 1){
			    $sjjsnum = 	$sjjsnum + $value['shopps'];
			}
			if($data['sjjs']['bagcost'] == 1){
			    $sjjsnum = 	$sjjsnum + $value['bagcost'];
			}
			if($data['sjjs']['shopdowncost'] == 1){
			    $sjjsnum = 	$sjjsnum - ($value['cxcost'] - $value['shopdowncost']);
			}			
			$value['expectincome'] = $sjjsnum - $value['servicecost'];//本单预计收入（结算金额）		
		    $value['expectincome'] = round($value['expectincome'] ,2);
		}else{
			 
			//计算平台配送情况下佣金
			$ptyjnum = $value['shopcost'];          			
			if($data['ptyj']['pscost'] == 1){
			    $ptyjnum = 	$ptyjnum + $value['shopps'];
			}
			if($data['ptyj']['bagcost'] == 1){
			    $ptyjnum = 	$ptyjnum + $value['bagcost'];
			}
			if($data['ptyj']['shopdowncost'] == 1){
			    $ptyjnum = 	$ptyjnum - ($value['cxcost'] - $value['shopdowncost']);
			}
			$value['servicecost'] = $ptyjnum * $shopinfo['yjin'] * 0.01;//平台服务费（佣金）
			$value['servicecost'] = round($value['servicecost'] ,2);
			//计算平台配送情况下本单预计收入（结算金额）
			$ptjsnum = $value['shopcost'];
            if($data['ptjs']['pscost'] == 1){
			    $ptjsnum = 	$ptjsnum + $value['shopps'];
			}
			if($data['ptjs']['bagcost'] == 1){
			    $ptjsnum = 	$ptjsnum + $value['bagcost'];
			}
			if($data['ptjs']['shopdowncost'] == 1){
			    $ptjsnum = 	$ptjsnum - ($value['cxcost'] - $value['shopdowncost']);
			}			
		    $value['expectincome'] = $ptjsnum - $value['servicecost'];//本单预计收入（结算金额）
            $value['expectincome'] = round($value['expectincome'] ,2);			
		}	
		$templist =   $this->mysql->getarr("select id,order_id,goodsname,goodscost,goodscount from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$value['id']."' ");
		$newdatalist = array();
		$shuliang = 0;
		 
		foreach($templist as $key=>$value1){
			$value1['goodscost'] = $value1['goodscost'];
			$newdatalist[] = $value1; 
			$shuliang += $value1['goodscount'];
		}
		
		$value['det'] = $newdatalist;

		if(!empty($value['othertext'])){
			$tempcontent = unserialize($value['othertext']);
			foreach($tempcontent as $key=>$value){
				$value['content'] = $value['content'].$key.':'.$value.',';
			}
		}

		$rebackorderlist[] = $value;
		}
		
   
		$this->success($rebackorderlist);
	}
	
	/**
	*@method 新版商家端 待处理->待平台处理退款订单列表
	*@request_url http://m6.waimairen.com/index.php?ctrl=app&action=platformrebackorder&uid=10203&pwd=123456&datatype=json&page=1	 
 	*@所需参数   uid   pwd	 
	*添加时间:2017/8/9    技术：闫旭明
	**/
	function platformrebackorder(){
		  
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$phone = intval(IFilter::act(IReq::get('phone'))); 
		$phonewhere = empty($phone)?"":" and buyerphone like '%".$phone."%' " ;
		$page = intval(IFilter::act(IReq::get('page')));
		$pagesize = intval(IFilter::act(IReq::get('pagesize'))); 
		$pagesize = $pagesize > 0? $pagesize:10; 
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);   
  		/*
	    获取平台设置的结算公式			
 	    */
		$jsinfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."jscompute where id > 0  ");
		$data['ptyj'] = $jsinfo[0];   //平台配送情况下的佣金设置
		$data['sjyj'] = $jsinfo[1];   //商家配送情况下的佣金设置
		$data['ptjs'] = $jsinfo[2];   //平台配送情况下的结算设置
		$data['sjjs'] = $jsinfo[3];   //商家配送情况下的结算设置	
		 #print_r($phonewhere);
		$orderlist =  $this->mysql->getarr("select id,content,pstype,is_reback,cxcost,bagcost,shopps,shopdowncost,shopcost,addtime,shopid,posttime,paytype,paystatus,dno,allcost,status,is_make,daycode,buyeruid,buyername,buyerphone,buyeraddress,postdate from ".Mysite::$app->config['tablepre']."order where shopuid = ".$backinfo['uid']." and is_reback > 0  and is_reback < 3 ".$phonewhere."  order by addtime desc  limit   ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."   ");  
		 	
		if(empty($orderlist)){
			$this->message('暂无符合条件的订单');
		}
		foreach($orderlist as $key=>$value){
		 		
  
		$scoretocost =Mysite::$app->config['scoretocost'];
		$scorcost = $value['scoredown'] > 0? intval($value['scoredown']/$scoretocost):0;
		$value['allcx'] = $value['cxcost']+$value['yhjcost']+$scorcost;
	    if($value['paytype'] == 0){
			$value['paystatustype'] = "货到支付";
		}else{
		    $value['paystatustype'] =  empty($value['paystatus'])?'未支付':'已支付';	
		}
		$value['addtime'] = date('H:i:s',$value['addtime']);
		$value['posttime'] = date('Y-m-d',$value['posttime'])." ".$value['postdate'];
		$value['status'] = $value['is_reback'] == 2?'平台已退款':'等待平台审核';
		//下单次数		 	 
		$sdf = $this->mysql->getarr("select  dno from ".Mysite::$app->config['tablepre']."order where buyeruid = ".$value['buyeruid']." and shopid = ".$value['shopid']."  ");
			 
				foreach($sdf as $k=>$v){
					if($v['dno']==$value['dno']){
						$value['orderNum'] = $k+1;
					}
				}
		$value['orderNum'] = $value['orderNum'];
		//计算佣金(平台服务费)和结算金额(本单预计收入)
	    $shopinfo =   $this->mysql->select_one("select id,yjin,shoptype from ".Mysite::$app->config['tablepre']."shop where id='".$value['shopid']."' ");
        if($shopinfo['shoptype'] == 0){
		    $sendinfo = $this->mysql->select_one("select sendtype from ".Mysite::$app->config['tablepre']."shopfast where shopid='".$value['shopid']."' ");	
		}else{
		    $sendinfo = $this->mysql->select_one("select sendtype from ".Mysite::$app->config['tablepre']."shopmarket where shopid='".$value['shopid']."' ");				
		}
		 
		if($sendinfo['sendtype'] == 1){
			
			//计算商家配送情况下佣金
			$sjyjnum = $value['shopcost'];
            if($data['sjyj']['pscost'] == 1){
			    $sjyjnum = 	$sjyjnum + $value['shopps'];
			}
			if($data['sjyj']['bagcost'] == 1){
			    $sjyjnum = 	$sjyjnum + $value['bagcost'];
			}
			if($data['sjyj']['shopdowncost'] == 1){
			    $sjyjnum = 	$sjyjnum - ($value['cxcost'] - $value['shopdowncost']);
			}
			$value['servicecost'] = $sjyjnum * $shopinfo['yjin'] * 0.01;//平台服务费（佣金）
			$value['servicecost'] = round($value['servicecost'] ,2);
			//计算商家配送情况下本单预计收入（结算金额）
			$sjjsnum = $value['shopcost'];
            if($data['sjjs']['pscost'] == 1){
			    $sjjsnum = 	$sjjsnum + $value['shopps'];
			}
			if($data['sjjs']['bagcost'] == 1){
			    $sjjsnum = 	$sjjsnum + $value['bagcost'];
			}
			if($data['sjjs']['shopdowncost'] == 1){
			    $sjjsnum = 	$sjjsnum - ($value['cxcost'] - $value['shopdowncost']);
			}			
			$value['expectincome'] = $sjjsnum - $value['servicecost'];//本单预计收入（结算金额）		
		    $value['expectincome'] = round($value['expectincome'] ,2);
		}else{
			 
			//计算平台配送情况下佣金
			$ptyjnum = $value['shopcost'];          			
			if($data['ptyj']['pscost'] == 1){
			    $ptyjnum = 	$ptyjnum + $value['shopps'];
			}
			if($data['ptyj']['bagcost'] == 1){
			    $ptyjnum = 	$ptyjnum + $value['bagcost'];
			}
			if($data['ptyj']['shopdowncost'] == 1){
			    $ptyjnum = 	$ptyjnum - ($value['cxcost'] - $value['shopdowncost']);
			}
			$value['servicecost'] = $ptyjnum * $shopinfo['yjin'] * 0.01;//平台服务费（佣金）
			$value['servicecost'] = round($value['servicecost'] ,2);
			//计算平台配送情况下本单预计收入（结算金额）
			$ptjsnum = $value['shopcost'];
            if($data['ptjs']['pscost'] == 1){
			    $ptjsnum = 	$ptjsnum + $value['shopps'];
			}
			if($data['ptjs']['bagcost'] == 1){
			    $ptjsnum = 	$ptjsnum + $value['bagcost'];
			}
			if($data['ptjs']['shopdowncost'] == 1){
			    $ptjsnum = 	$ptjsnum - ($value['cxcost'] - $value['shopdowncost']);
			}			
		    $value['expectincome'] = $ptjsnum - $value['servicecost'];//本单预计收入（结算金额）
            $value['expectincome'] = round($value['expectincome'] ,2);			
		}	
		$templist =   $this->mysql->getarr("select id,order_id,goodsname,goodscost,goodscount from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$value['id']."' ");
		$newdatalist = array();
		$shuliang = 0;
		 
		foreach($templist as $key=>$value1){
			$value1['goodscost'] = $value1['goodscost'];
			$newdatalist[] = $value1; 
			$shuliang += $value1['goodscount'];
		}
		
		$value['det'] = $newdatalist;

		if(!empty($value['othertext'])){
			$tempcontent = unserialize($value['othertext']);
			foreach($tempcontent as $key=>$value){
				$value['content'] = $value['content'].$key.':'.$value.',';
			}
		}

		$rebackorderlist[] = $value;
		}
		
   
		$this->success($rebackorderlist);
	} 
	        
	function aaa(){
		$shopinfo =   $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where dno='15073669562394' "); 	
		print_r($shopinfo);exit;
	}
	
	/* 新版商家端
	*  商家获取进行中和已完成订单
	2017-07-06 yxm
	*/	
	function newapporder(){	
		$backinfo = $this->checkapp();
	    if(empty($backinfo['uid'])){
			$this->message('nologin');
		} 
		$phone = trim(IFilter::act(IReq::get('phone')));		 
		$gettype = trim(IFilter::act(IReq::get('gettype')));		 
		$gettype = !in_array($gettype,array('doing','finish')) ?'doing':$gettype;
		$checktime = IFilter::act(IReq::get('checktime'));
		$stime = empty($checktime)?strtotime(date("Y-m-d")):strtotime($checktime); 
		$endtime = $stime + 86400;	 
		//进行中的订单  不加时间限制  已完成的订单  默认显示全部  选择日期时再根据日期筛选
		if(empty($checktime)){
			$wherearr = array(
			'doing'=> ' status < 3 and is_make = 1 and is_reback = 0 ',	//进行中		 
			'finish'=>' status = 3 and is_reback = 0 '                    //已完成 
		    );
		}else{
			$wherearr = array(
			'doing'=> ' status < 3 and is_make = 1 and is_reback = 0 ',	//进行中		 
			'finish'=>' status = 3 and is_reback = 0 and suretime >'.$stime.' and suretime < '.$endtime.' '                    //已完成 
		    );
		}
		
        
		$page = intval(IFilter::act(IReq::get('page')));
		$pagesize = intval(IFilter::act(IReq::get('pagesize'))); 
		$pagesize = $pagesize > 0? $pagesize:10; 
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);   
  	    
		/*
	    获取平台设置的结算公式			
 	    */		
		$jsinfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."jscompute where id > 0  ");
		$data['ptyj'] = $jsinfo[0];   //平台配送情况下的佣金设置
		$data['sjyj'] = $jsinfo[1];   //商家配送情况下的佣金设置
		$data['ptjs'] = $jsinfo[2];   //平台配送情况下的结算设置
		$data['sjjs'] = $jsinfo[3];   //商家配送情况下的结算设置			 
		  
		if($phone > 0){
			$orderlist =  $this->mysql->getarr("select id,content,psuid,psusername,psemail,pstype,psstatus,picktime,cxcost,bagcost,shopps,shopdowncost,shopcost,addtime,shopid,posttime,paytype,paystatus,dno,allcost,status,is_make,daycode,buyeruid,buyername,buyerphone,buyeraddress,postdate from ".Mysite::$app->config['tablepre']."order where shopuid = ".$backinfo['uid']." and ".$wherearr[$gettype]."  and buyerphone like '%".$phone."%'  limit   ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."    ");   				 				    
		}else{
			$orderlist =  $this->mysql->getarr("select id,content,psuid,psusername,psemail,pstype,psstatus,picktime,cxcost,bagcost,shopps,shopdowncost,shopcost,addtime,shopid,posttime,paytype,paystatus,dno,allcost,status,is_make,daycode,buyeruid,buyername,buyerphone,buyeraddress,postdate from ".Mysite::$app->config['tablepre']."order where shopuid = ".$backinfo['uid']." and ".$wherearr[$gettype]."   order by addtime desc  limit   ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."   ");   				 
		}			  
		if(empty($orderlist)){
			$this->message('暂无满足条件的订单');
		}
	     
		foreach($orderlist as $key=>$value){
		$scoretocost =Mysite::$app->config['scoretocost'];
		$scorcost = $value['scoredown'] > 0? intval($value['scoredown']/$scoretocost):0;
		$value['allcx'] = $value['cxcost']+$value['yhjcost']+$scorcost;
	    if($value['paytype'] == 0){
			$value['paystatustype'] = "货到支付";
		}else{
		    $value['paystatustype'] =  empty($value['paystatus'])?'未支付':'已支付';	
		}	
		$value['addtime'] = date('H:i:s',$value['addtime']);
		$value['posttime'] = date('Y-m-d',$value['posttime'])." ".$value['postdate'];
		$value['psuid'] = empty($value['psuid'])?'':$value['psuid'];
		$value['showsend'] = 0;//是否显示发货按钮
		$value['showover'] = 0;//是否显示确认完成按钮
		
		
		//下单次数		 	 
		$sdf = $this->mysql->getarr("select  dno from ".Mysite::$app->config['tablepre']."order where buyeruid = ".$value['buyeruid']." and shopid = ".$value['shopid']."  ");
			 
				foreach($sdf as $k=>$v){
					if($v['dno']==$value['dno']){
						$value['orderNum'] = $k+1;
					}
				}
		$value['orderNum'] = $value['orderNum'];
		
	    $shopinfo =   $this->mysql->select_one("select id,yjin,shoptype from ".Mysite::$app->config['tablepre']."shop where id='".$value['shopid']."' ");
        if($shopinfo['shoptype'] == 0){
		    $sendinfo = $this->mysql->select_one("select sendtype from ".Mysite::$app->config['tablepre']."shopfast where shopid='".$value['shopid']."' ");	
		}else{
		    $sendinfo = $this->mysql->select_one("select sendtype from ".Mysite::$app->config['tablepre']."shopmarket where shopid='".$value['shopid']."' ");				
		}
		if($sendinfo['sendtype'] == 1 && $value['is_make'] == 1 && $value['status'] == 1){
			$value['showsend'] = 1;
		}
		if($value['status'] == 2 && $sendinfo['sendtype'] == 1){
			$data['showover'] = 1;
		}
		
		if( $value['pstype'] == 1){//商家配送的情况
			$value['psyname'] = '';
			$value['psyphone'] = '';
			$value['picktime'] = '';
			if($value['status'] < 2){
				$value['orderstatus'] = '待发货';				 
			}
            if($value['status']==2){
				$value['orderstatus'] = '配送中';	
			}
            if($value['status']==3){
				$value['orderstatus'] = '订单已完成';	
			}           		
		}else{
			if($value['psuid'] > 0){
			if($value['pstype'] == 0){//网站配送
				$orderpsinfo = $this->mysql->select_one("select status,picktime from ".Mysite::$app->config['tablepre']."orderps where orderid='".$value['id']."' ");	
			    if(empty($orderpsinfo)) $this->message('配送单不存在');
				if($orderpsinfo['status'] == 1 && $value['status'] != 3 ){
					$value['orderstatus'] = '待取货';
					$value['psyname'] = empty($value['psusername'])?'':$value['psusername'];
					$value['psyphone'] = empty($value['psemail'])?'':$value['psemail'];
					$orderpsinfo1 = $this->mysql->select_one("select addtime from ".Mysite::$app->config['tablepre']."orderstatus where statustitle = '配送员已抢单' ");				   
					$value['picktime'] = date('H:i',$orderpsinfo1['addtime']);
				}
				if($orderpsinfo['status'] == 2 && $value['status'] != 3){
					$value['orderstatus'] = '配送中';
					$value['psyname'] = empty($value['psusername'])?'':$value['psusername'];
					$value['psyphone'] = empty($value['psemail'])?'':$value['psemail'];
					$value['picktime'] = date('H:i',$orderpsinfo['picktime']);
				}
				if($value['status'] == 3){
					$value['orderstatus'] = '已完成';
					$value['psyname'] = empty($value['psusername'])?'':$value['psusername'];
					$value['psyphone'] = empty($value['psemail'])?'':$value['psemail'];
					$value['picktime'] = date('H:i',$orderpsinfo['picktime']);
				}
			}
	 
			if($value['pstype'] == 2){//配送宝
				if($value['psstatus'] < 3 && $value['status'] != 3){
					$value['orderstatus'] = '待取货';
					$value['psyname'] = empty($value['psusername'])?'':$value['psusername'];
					$value['psyphone'] = empty($value['psemail'])?'':$value['psemail'];
					$value['picktime'] = $value['picktime'];
					$value['psystatus'] = date('H:i',$value['picktime']).'接单，正在到店取货';
				}
				if($value['psstatus'] == 3 && $value['status'] != 3){
					$value['orderstatus'] = '配送中';
					$value['psyname'] = empty($value['psusername'])?'':$value['psusername'];
					$value['psyphone'] = empty($value['psemail'])?'':$value['psemail'];
					$value['picktime'] = $value['picktime'];
					$value['psystatus'] = date('H:i',$value['picktime']).'取货，正在配送中';
				}
                if($value['status'] == 3){
					$value['orderstatus'] = '已完成';
					$value['psyname'] = empty($value['psusername'])?'':$value['psusername'];
					$value['psyphone'] = empty($value['psemail'])?'':$value['psemail'];
					$value['picktime'] = $value['picktime'];
					$value['psystatus'] = date('H:i',$value['picktime']).'已送达';
				}				
			}	
		}else{
			if($value['status'] < 2 && $value['is_make'] == 1 ){
				$value['orderstatus'] = '待发货';
				$value['psyname'] = '';
				$value['psyphone'] = '';
				$value['picktime'] = '';			
			}
			if($value['status'] != 3){
				$value['orderstatus'] = '待抢单';
				$value['psyname'] = '';
				$value['psyphone'] = '';
				$value['picktime'] = '';
			}
			if($value['status'] == 3){
				$value['orderstatus'] = '已完成';
				$value['psyname'] = '';
				$value['psyphone'] = '';
				$value['picktime'] = '';
			}			
		}
			
			
			
		}

		
		//计算佣金(平台服务费)和结算金额(本单预计收入)
		if($sendinfo['sendtype'] == 1){
			
			//计算商家配送情况下佣金
			$sjyjnum = $value['shopcost'];
            if($data['sjyj']['pscost'] == 1){
			    $sjyjnum = 	$sjyjnum + $value['shopps'];
			}
			if($data['sjyj']['bagcost'] == 1){
			    $sjyjnum = 	$sjyjnum + $value['bagcost'];
			}
			if($data['sjyj']['shopdowncost'] == 1){
			    $sjyjnum = 	$sjyjnum - ($value['cxcost'] - $value['shopdowncost']);
			}
			$value['servicecost'] = $sjyjnum * $shopinfo['yjin'] * 0.01;//平台服务费（佣金）
			$value['servicecost'] = round($value['servicecost'] ,2);
			//计算商家配送情况下本单预计收入（结算金额）
			$sjjsnum = $value['shopcost'];
            if($data['sjjs']['pscost'] == 1){
			    $sjjsnum = 	$sjjsnum + $value['shopps'];
			}
			if($data['sjjs']['bagcost'] == 1){
			    $sjjsnum = 	$sjjsnum + $value['bagcost'];
			}
			if($data['sjjs']['shopdowncost'] == 1){
			    $sjjsnum = 	$sjjsnum - ($value['cxcost'] - $value['shopdowncost']);
			}			
			$value['expectincome'] = $sjjsnum - $value['servicecost'];//本单预计收入（结算金额）
            $value['expectincome'] = round($value['expectincome'] ,2);			
		}else{
			 
			//计算平台配送情况下佣金
			$ptyjnum = $value['shopcost'];          			
			if($data['ptyj']['pscost'] == 1){
			    $ptyjnum = 	$ptyjnum + $value['shopps'];
			}
			if($data['ptyj']['bagcost'] == 1){
			    $ptyjnum = 	$ptyjnum + $value['bagcost'];
			}
			if($data['ptyj']['shopdowncost'] == 1){
			    $ptyjnum = 	$ptyjnum - ($value['cxcost'] - $value['shopdowncost']);
			}
			$value['servicecost'] = $ptyjnum * $shopinfo['yjin'] * 0.01;//平台服务费（佣金）
			$value['servicecost'] = round($value['servicecost'] ,2);
			//计算平台配送情况下本单预计收入（结算金额）
			$ptjsnum = $value['shopcost'];
            if($data['ptjs']['pscost'] == 1){
			    $ptjsnum = 	$ptjsnum + $value['shopps'];
			}
			if($data['ptjs']['bagcost'] == 1){
			    $ptjsnum = 	$ptjsnum + $value['bagcost'];
			}
			if($data['ptjs']['shopdowncost'] == 1){
			    $ptjsnum = 	$ptjsnum - ($value['cxcost'] - $value['shopdowncost']);
			}			
		    $value['expectincome'] = $ptjsnum - $value['servicecost'];//本单预计收入（结算金额）
            $value['expectincome'] = round($value['expectincome'] ,2);			
		}	
		$templist =   $this->mysql->getarr("select id,order_id,goodsname,goodscost,goodscount from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$value['id']."' ");
		$newdatalist = array();
		$shuliang = 0;
		 
		foreach($templist as $key=>$value1){
			$value1['goodscost'] = $value1['goodscost'];
			$newdatalist[] = $value1; 
			$shuliang += $value1['goodscount'];
		}
		$value['det'] = $newdatalist;

		if(!empty($value['othertext'])){
			$tempcontent = unserialize($value['othertext']);
			foreach($tempcontent as $key=>$value){
				$value['content'] = $value['content'].$key.':'.$value.',';
			}
		}

		$orderlistdata[] = $value;
		}
		
   
		$this->success($orderlistdata);
	}
	
	
	
	
	/*
	*  获取商家订单
	*/
	
	
	function apporder(){
		$statusarr = array('0'=>'新订单','1'=>'待发货','2'=>'待完成','3'=>'完成','4'=>'关闭','5'=>'关闭');
		$gostatusarr = array('0'=>'新订单','1'=>'待消费','2'=>'待消费','3'=>'已消费','4'=>'关闭','5'=>'关闭');
		$backinfo = $this->checkapp();
		/* if(empty($backinfo['uid'])){
			$this->message('nologin');
		} */
		//
		$gettype = trim(IFilter::act(IReq::get('gettype')));
		$gettype = !in_array($gettype,array('wait','waitsend','is_send')) ?'wait':$gettype;
		$newwherearray =array(
			'wait'=> ' status > 0 and status < 2 and is_make = 0 and is_reback = 0',
			'waitsend'=>' status = 1 and is_make = 1  and is_goshop = 0',
			'is_send'=>' status > 1 '
		);

		$todatay = strtotime(date('Y-m-d',time()));
		$endtime = strtotime(date('Y-m-d',time()).' 23:59:59');
		$orderlist =  $this->mysql->getarr("select id,addtime,posttime,paytype,paystatus,dno,is_reback,allcost,status,is_make,daycode,buyeruid,is_goshop,buyername,buyerphone,buyeraddress,postdate,shopid,postdate from ".Mysite::$app->config['tablepre']."order where shopuid = ".$backinfo['uid']." and ".$newwherearray[$gettype]."  and posttime > ".$todatay."");   /* and posttime < ".$endtime." */
		$backdatalist = array();
		foreach($orderlist as $key=>$value){
			if($value['is_goshop'] == 1){
				$value['showstatus'] = $gostatusarr[$value['status']];
			}else{
				$value['showstatus'] = $statusarr[$value['status']]; 
			}
			$shop= $this->mysql->select_one("select shoptype from ".Mysite::$app->config['tablepre']."shop where id='".$value['shopid']."' ");
			if($shop['shoptype']==0){
				$shopinfo= $this->mysql->select_one("select interval_minit from ".Mysite::$app->config['tablepre']."shopfast where shopid='".$value['shopid']."' ");
			}else{
				$shopinfo= $this->mysql->select_one("select interval_minit from ".Mysite::$app->config['tablepre']."shopmarket where shopid='".$value['shopid']."' ");
			}
			$timearr = explode("-",$value['postdate']);
			$maxpstime = strtotime($timearr[1]);
			$value['is_yuding'] = $maxpstime -  $shopinfo['interval_minit']*60  > $value['addtime']?'1':'2';
			
			$value['addtime'] = date('H:i:s',$value['addtime']);
			$value['posttime'] = date('m-d',$value['posttime']);
			$value['posttime'] = $value['posttime'].' '.$value['postdate'];
			if($value['paytype'] == 1){
				$value['payresult'] = '在线支付';
				if($value['paystatus'] == 1){
					$value['payresult'] .= '已付';
					if($value['is_reback'] == 1){
						$value['payresult'] = '申请退款';
					}elseif($value['is_reback'] == 2){
						$value['payresult'] = '退款成功';
					}elseif($value['is_reback'] == 3){
						$value['payresult'] = '取消退款';
					}
				}else{
					$value['payresult'] .= '未付';
				}
			}else{
				$value['payresult'] = '货到支付';
			}
			$checkuid = intval($value['buyeruid']);
			if($checkuid > 0){
				$sdf = $this->mysql->getarr("select  * from ".Mysite::$app->config['tablepre']."order where buyeruid = ".$value['buyeruid']." and shopid = ".$value['shopid']."  ");
				foreach($sdf as $k=>$v){
					if($v['dno']==$value['dno']){
						$value['orderNum'] = $k;
					}
				}

			}else{
				$value['orderNum'] =  0;
			}
			//统计下单次数
				if($value['status'] ==  1){
				if($value['is_make'] == 0){
					$value['showstatus'] = $value['is_goshop']== 1?'新订台订单':'新订单';
				}elseif($value['status'] !=1){
					$value['showstatus'] = $value['is_goshop']== 1?'商家取消订单':'取消制作';
				}
			}
			$backdatalist[] = $value;
		}
		 
		$this->success($backdatalist);
	}
	/**
	*@method 新版商家端  开启关闭自动接单功能
	*@request_url http://m6.waimairen.com/index.php?ctrl=app&action=editautopreceipt&uid=10203&pwd=123456&status=1&datatype=json 
 	*@所需参数   uid：用户uid   pwd：用户密码    status：开启传1   关闭传0	   
	*添加时间:2017/9/26    技术：闫
	**/
	function editautopreceipt(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$data['is_autopreceipt'] = trim(IFilter::act(IReq::get('status')));
		$this->mysql->update(Mysite::$app->config['tablepre'].'shop',$data,"uid='".$backinfo['uid']."' ");
     	$this->success('操作成功');	
	}
	/*
	* 商家获取信息
	2015-12-25修改
	*/
	function appshop(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		//获取店铺
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,shoplogo,shoptype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,intr_info,notice_info,is_autopreceipt from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		$shopinfo['opentime'] = str_replace("|", ",", $shopinfo['opentime']);
		$shopinfo['intr_info'] =strip_tags($shopinfo['intr_info']);
		$shopinfo['notice_info']= strip_tags($shopinfo['notice_info']);
		$shopinfo['shoplogo'] = empty($shopinfo['shoplogo'])? Mysite::$app->config['siteurl'].Mysite::$app->config['shoplogo']:Mysite::$app->config['siteurl'].$shopinfo['shoplogo'];
		if($shopinfo['shoptype'] == 0){
			$shopdet  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast       where  shopid = ".$shopinfo['id']."   ");
		}else{
			$shopdet  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket       where  shopid = ".$shopinfo['id']."   ");

		} 
		$shopinfo['isshowpsf'] = $shopdet['sendtype'] == 1?1:0;
		$shopattr = $this->mysql->getarr("select value from ".Mysite::$app->config['tablepre']."shopattr where shopid='".$shopinfo['id']."' ");		
		foreach($shopattr as $k=>$v){
			$shoptype[] = $v['value'];
		}
		#print_r($shopdet);exit;
		$shoptype = implode(',',$shoptype);
		$shopinfo['shoptype'] = empty($shoptype)?'': $shoptype;
		$shopinfo['is_orderbefore'] = empty($shopdet)?0:$shopdet['is_orderbefore']; 
	    $shopinfo['limitcost']  = empty($shopdet)?0:$shopdet['limitcost']; 
		#print_r($shopinfo);exit;
		$this->success($shopinfo);
	}
	/*
	* 商家获取商品分类
	2015-12-26修改
	*/
	function goodstype(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		if($shopinfo['shoptype'] != 0)$this->message('超市店铺不通过此链接返回'); 
		
		$shoptype =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodstype where shopid='".$shopinfo['id']."' order by orderid asc");
		$tempc = array();
		foreach($shoptype as $key=>$value){
			$value['shuliang'] = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."goods where shopid='".$shopinfo['id']."' and typeid=".$value['id']." order by good_order asc");
			$tempc[] = $value;
		} 
		$this->success($tempc);
	}
	/*
	* 商家端改版后
	商家店铺设置获取店铺类型信息
	2017-07-04修改yxm
	*/
	function newgetshoptype(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}		
		$shopinfo = $this->mysql->select_one("select id,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		$shopattr = $this->mysql->getarr("select attrid from ".Mysite::$app->config['tablepre']."shopattr where shopid='".$shopinfo['id']."' ");
		foreach($shopattr as $k=>$v){
			$attrids[] = $v['attrid'];
		}		
		$catparent = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype  where  type='checkbox' order by cattype asc limit 0,100");
			$catlist = array();
			foreach($catparent as $key=>$value){
				$tempcat   = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype  where parent_id = '".$value['id']."' and cattype = ".$shopinfo['shoptype']." limit 0,100");
				
				foreach($tempcat as $k=>$v){
					 if(in_array($v['id'],$attrids)){
						$v['check'] = 1;
					}else{
						$v['check'] = 0;
					}
					$catlist[] = $v;
				}
			}
		$this->success($catlist);
	}
	
	/** 商家端改版后
	商家店铺设置保存店铺类型信息
	2017-07-04修改yxm
	**/
	function saveshoptype(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo = $this->mysql->select_one("select id from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");		
		$attrids = IFilter::act(IReq::get('attrids'));
		if(empty($attrids)) $this->message('请选择店铺类型');
		$attrids = explode(',',$attrids);
		$this->mysql->delete(Mysite::$app->config['tablepre'].'shopattr',"shopid ='".$shopinfo['id']."' ");
		foreach($attrids as $k=>$v){
		    $info = $this->mysql->select_one("select name,parent_id from ".Mysite::$app->config['tablepre']."shoptype where id='".$v."' ");		
			$data['shopid'] = $shopinfo['id'];
			$data['attrid'] = $v;
			$data['firstattr'] = $info['parent_id'];
			$data['value'] = $info['name'];
			$this->mysql->insert(Mysite::$app->config['tablepre']."shopattr",$data);
		}
        $this->success('操作成功');		
	}
	/** 商家端改版后
	商家店铺获取配送费设置
	2017-07-05修改yxm
	**/
	function getpsinfo(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		} 		
	    $shopinfo = $this->mysql->select_one("select id,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");		        
	    if($shopinfo['shoptype'] == 1){
			$psinfo = $this->mysql->select_one("select pradius, pradiusvalue from ".Mysite::$app->config['tablepre']."shopmarket where shopid='".$shopinfo['id']."' ");	
		}else{
			$psinfo = $this->mysql->select_one("select pradius, pradiusvalue from ".Mysite::$app->config['tablepre']."shopfast where shopid='".$shopinfo['id']."' ");	
		}
	    $pradiusvalue = unserialize($psinfo['pradiusvalue']);		
		$pradius = $psinfo['pradius'];
		for($k=0; $k<$pradius; $k++){
			$value['id'] = $k;
			$value['range'] = $k."-".($k+1)."km配送费";
			$value['cost'] = empty($pradiusvalue[$k])?0:$pradiusvalue[$k];
			$pslist[] = $value;
		}
	    $this->success($pslist);			 
	}
        
	/** 商家端改版后
	商家店铺保存配送费设置
	2017-07-05修改yxm
	**/
	function savepsinfo(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		} 
		$psinfo = IFilter::act(IReq::get('psinfo'));	 
		$pslist = explode(',',$psinfo);		
		$data['pradiusvalue'] = serialize($pslist);		
		$shopinfo = $this->mysql->select_one("select id,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");		        
	    if($shopinfo['shoptype'] == 1){
			$this->mysql->update(Mysite::$app->config['tablepre'].'shopmarket',$data,"shopid='".$shopinfo['id']."' ");	
		}else{
			$this->mysql->update(Mysite::$app->config['tablepre'].'shopfast',$data,"shopid='".$shopinfo['id']."' ");	
		}
		$this->success("配送费设置成功！");				
	} 
	/** 商家端改版后	
     * @shopapi 
     * @name 新版商家端  订单详情
     * @other 2017/8/18   闫
     * @orderid  订单id  必传
     * @datatype 固定值 json 必传 
     * @extend 必传登陆验证参数
	 * @返回示例：
	*{ 
     *"error" : "false", 
     *"msg" : { 
     *     "status" : "等待处理", 【订单状态】
	*	  "status1" : "08:00下单", 【订单状态右上角显示】
     *     "posttime" : "2017-08-09 17:42", 【配送时间】
     *     "addtime" : "2017-08-09 17:10", 【下单日期时间】
     *     "addtime1" : "17:10", 【下单时间】
      *    "daycode" : "3", 【订单序号#】
     *     "buyername" : "123", 【买家名字】
     *     "buyerphone" : "15222222222", 【买家电话】
     *    "buyeraddress" : "郑州市政府213", 【买家地址】
     *     "orderstatus" : "1", 
     *     "orderNum" : "3", 【下单次数】
     *     "allcost" : "18.80", 【订单总价】
     *     "is_reback" : "1", 【退款状态  0正常 1待平台审核 2退款成功 3待商家审核】
     *     "servicecost" : "0", 【平台服务费】
     *     "expectincome" : "18.8", 【预计收入】
	*	  "pscost" : "5.00",【配送费】
     *     "cxcost" : "36.00",【促销优惠减金额】
	*	  "jfcost" : "0.00",【积分抵扣金额】
	*	  "yhjcost" : "0.00",【优惠券抵扣金额】
	*	  "bagcost" : "8.00",【打包费】
    *      "dno" : "15022698256802", 【订单编号】
    *      "content" : "", 【备注】
    *      "psyname" : "", 【配送员名字】
    *      "psyphone" : "", 【配送员电话】
    *     "sendtype" : "1", 【配送类型 1商家配送 非1网站配送】
    *      "shopcost" : "14.80", 【商品总价】
    *      "orderdetail" : { 【商品详情】
    *           "0" : { 
    *                "goodsname" : "进口金奇异果", 【名字】
    *                "goodscost" : "14.80", 【价格】
    *                "goodscount" : "1" 【数量】
    *           }, 
    *      }, 
    *      "paystatustype" : "已支付" 【支付状态】
    * } 
	*}
	*/
	function orderdetail(){		 
		/* $orderinfo = $this->mysql->select_one("select id from ".Mysite::$app->config['tablepre']."order where dno = 14991588346974  ");		 
        print_r($orderinfo);exit; */
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		
		$orderid = IFilter::act(IReq::get('orderid'));
		if(empty($orderid)) $this->message('订单获取失败');
		$orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where id=".$orderid." and shopuid = ".$backinfo['uid']."  order by id desc limit 0,20");		 		 
		#print_r($orderinfo);
		$data['status2'] = '';
		if($orderinfo['status'] == 0 || $orderinfo['is_make'] == 0){
			$data['status'] = '等待处理';
			$data['status1'] = date('H:i',$orderinfo['addtime']).'下单';
		}
		if($orderinfo['status'] == 1 && $orderinfo['is_make'] == 1 && $orderinfo['pstype'] == 1 ){
			$data['status'] = '等待发货';
			$data['status1'] = date('H:i',$orderinfo['maketime']).'接单';
		}
		if($orderinfo['status'] == 2 && $orderinfo['pstype'] == 1){
			$data['status'] = '等待用户确认';
			$data['status1'] = date('H:i',$orderinfo['sendtime']).'发货';
		}
		if(empty($orderinfo['psuid']) && $orderinfo['pstype'] != 1 && $orderinfo['is_make'] == 1){
			$data['status'] = '等待配送员抢单';
			$data['status1'] = date('H:i',$orderinfo['maketime']).'接单';
		}
		if(!empty($orderinfo['psuid']) && $orderinfo['pstype'] != 1 && $orderinfo['status'] != 3 && $orderinfo['psstatus'] < 3 ){			 
			$data['status'] = '配送员正在取货中';
			$orderstatusinfo = $this->mysql->select_one("select addtime from ".Mysite::$app->config['tablepre']."orderstatus where orderid=".$orderid." and statustitle = '配送员已抢单' ");		 		 						 
			$data['status1'] = date('H:i',$orderstatusinfo['addtime']).'抢单';
			$data['status2'] = date('H:i',$orderstatusinfo['addtime']).'接单，正在到店取货';
		}
		
		if(!empty($orderinfo['psuid']) && $orderinfo['pstype'] != 1 && $orderinfo['status'] != 3 && $orderinfo['psstatus'] == 3 ){			 
			$data['status'] = '配送员正在配送中';
			$data['status1'] = date('H:i',$orderinfo['picktime']).'取货';
			$data['status2'] = date('H:i',$orderinfo['picktime']).'取货，正在配送中';
		}
		if($orderinfo['status'] == 3){
			$data['status'] = '订单已完成';
			$data['status1'] = date('H:i',$orderinfo['suretime']).'送达';
			$data['status2'] = date('H:i',$orderinfo['suretime']).'已送达';
		}
		if($orderinfo['is_reback'] == 1){
			$data['status'] = '等待平台审核';
		}
		if($orderinfo['is_reback'] == 2){
			$data['status'] = '退款成功';
		}
		if($orderinfo['is_reback'] > 2){
			$data['status'] = '顾客申请退款，待处理';
		}
		if($orderinfo['status'] > 3){
			$data['status'] = '订单取消';
		}						
		$data['posttime'] = date('Y-m-d H:i',$orderinfo['posttime']);    //配送时间
		$data['addtime'] = date('Y-m-d H:i',$orderinfo['addtime']); //下单日期
		$data['addtime1'] = date('H:i',$orderinfo['addtime']); //下单时间
		$data['daycode'] = $orderinfo['daycode'];      //订单序号
		$data['buyername'] = $orderinfo['buyername'];  //顾客名字
		$data['buyerphone'] = $orderinfo['buyerphone'];//顾客电话
		$data['buyeraddress'] = $orderinfo['buyeraddress'];//顾客地址	
        $data['orderstatus'] = $orderinfo['status'];		
		$sdf = $this->mysql->getarr("select dno from ".Mysite::$app->config['tablepre']."order where buyeruid = ".$orderinfo['buyeruid']." and shopid = ".$orderinfo['shopid']."  ");			 
		 
		foreach($sdf as $k=>$v){
				if($v['dno']==$orderinfo['dno']){
					$value['orderNum'] = $k+1;
				}
			}
		$data['orderNum'] = $value['orderNum'];//下单次数			
		$data['allcost'] = $orderinfo['allcost'];//订单金额
		$data['is_reback'] = $orderinfo['is_reback'];
	    /****获取平台设置的结算公式	计算平台服务费(佣金)  订单预计收入(结算金额)*****/	
 	    
		$jsinfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."jscompute where id > 0  ");
		$data1['ptyj'] = $jsinfo[0];   //平台配送情况下的佣金设置
		$data1['sjyj'] = $jsinfo[1];   //商家配送情况下的佣金设置
		$data1['ptjs'] = $jsinfo[2];   //平台配送情况下的结算设置
		$data1['sjjs'] = $jsinfo[3];   //商家配送情况下的结算设置			 
	    $shopinfo = $this->mysql->select_one("select id,yjin,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
        if(empty($shopinfo)) $this->message('店铺信息获取失败');
	    if($shopinfo['shoptype'] == 0){
		    $sendinfo = $this->mysql->select_one("select sendtype from ".Mysite::$app->config['tablepre']."shopfast where shopid='".$shopinfo['id']."' ");	
		}else{
		    $sendinfo = $this->mysql->select_one("select sendtype from ".Mysite::$app->config['tablepre']."shopmarket where shopid='".$shopinfo['id']."' ");				
		}		 
		if($sendinfo['sendtype'] == 1){			
			//计算商家配送情况下佣金
			$sjyjnum = $orderinfo['shopcost'];
            if($data1['sjyj']['pscost'] == 1){
			    $sjyjnum = 	$sjyjnum + $orderinfo['shopps'];
			}
			if($data1['sjyj']['bagcost'] == 1){
			    $sjyjnum = 	$sjyjnum + $orderinfo['bagcost'];
			}
			if($data1['sjyj']['shopdowncost'] == 1){
			    $sjyjnum = 	$sjyjnum - ($orderinfo['cxcost'] - $orderinfo['shopdowncost']);
			}
			$data['servicecost'] = $sjyjnum * $shopinfo['yjin'] * 0.01;//平台服务费（佣金）
			$data['servicecost'] = number_format($data['servicecost'] ,2);
			//计算商家配送情况下本单预计收入（结算金额）
			$sjjsnum = $orderinfo['shopcost'];
            if($data1['sjjs']['pscost'] == 1){
			    $sjjsnum = 	$sjjsnum + $orderinfo['shopps'];
			}
			if($data1['sjjs']['bagcost'] == 1){
			    $sjjsnum = 	$sjjsnum + $orderinfo['bagcost'];
			}
			if($data1['sjjs']['shopdowncost'] == 1){
			    $sjjsnum = 	$sjjsnum - ($orderinfo['cxcost'] - $orderinfo['shopdowncost']);
			}			
			$data['expectincome'] = $sjjsnum - $data['servicecost'];//本单预计收入（结算金额）	
            $data['expectincome'] = number_format($data['expectincome'] ,2);			
		}else{
			 
			//计算平台配送情况下佣金
			$ptyjnum = $orderinfo['shopcost'];          			
			if($data1['ptyj']['pscost'] == 1){
			    $ptyjnum = 	$ptyjnum + $orderinfo['shopps'];
			}
			if($data1['ptyj']['bagcost'] == 1){
			    $ptyjnum = 	$ptyjnum + $orderinfo['bagcost'];
			}
			if($data1['ptyj']['shopdowncost'] == 1){
			    $ptyjnum = 	$ptyjnum - ($orderinfo['cxcost'] - $orderinfo['shopdowncost']);
			}
			$data['servicecost'] = $ptyjnum * $shopinfo['yjin'] * 0.01;//平台服务费（佣金）
			$data['servicecost'] = number_format($data['servicecost'] ,2);
			//计算平台配送情况下本单预计收入（结算金额）
			$ptjsnum = $orderinfo['shopcost'];
            if($data1['ptjs']['pscost'] == 1){
			    $ptjsnum = 	$ptjsnum + $orderinfo['shopps'];
			}
			if($data1['ptjs']['bagcost'] == 1){
			    $ptjsnum = 	$ptjsnum + $orderinfo['bagcost'];
			}
			if($data1['ptjs']['shopdowncost'] == 1){
			    $ptjsnum = 	$ptjsnum - ($orderinfo['cxcost'] - $orderinfo['shopdowncost']);
			}			
		    $data['expectincome'] = $ptjsnum - $data['servicecost'];//本单预计收入（结算金额）	
			$data['expectincome'] = number_format($data['expectincome'] ,2);
		}	
		$data['pscost'] = number_format($orderinfo['shopps'],2);//配送费
		$data['cxcost'] = number_format($orderinfo['cxcost'],2);//促销优惠金额
		$data['jfcost'] = number_format($orderinfo['scoredown']/Mysite::$app->config['scoretocost'],2);//积分抵扣金额
		$data['yhjcost'] = number_format($orderinfo['yhjcost'],2);//优惠券抵扣金额
		$data['bagcost'] = number_format($orderinfo['bagcost'],2);//打包费
		$data['addpscost'] = number_format($orderinfo['addpscost'],2);//附加配送费
		$data['dno'] = $orderinfo['dno'];//订单编号		
		$data['content'] = $orderinfo['content'];//订单备注
		$data['psyname'] = empty($orderinfo['psusername'])?'':$orderinfo['psusername'];//配送员名字
		$data['psyphone'] = empty($orderinfo['psemail'])?'':$orderinfo['psemail'];//配送员电话
		$data['sendtype'] = $orderinfo['pstype'];//配送方式  1商家配送  其他为网站配送
		$data['shopcost'] = $orderinfo['shopcost'];//商品总价	       	
		$data['orderdetail'] = $this->mysql->getarr("select goodsname,goodscost,goodscount from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$orderinfo['id']."' ");
		if($orderinfo['paytype'] == 0){
			$data['paystatustype'] = "货到支付";
		}else{
		    $data['paystatustype'] =  empty($orderinfo['paystatus'])?'未支付':'已支付';	
		}
		$this->success($data);
	}
	
	/*
	* 商家端改版后
	商家删除商品分类
	2017-07-04修改yxm
	*/
	function delgoodstype(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		} 
        $typeid = intval(IFilter::act(IReq::get('typeid')));		
		$shopinfo = $this->mysql->select_one("select id,shoptype from ".Mysite::$app->config['tablepre']."shop where uid=".$backinfo['uid']." ");		 
		
		if($shopinfo['shoptype'] == 1){//超市
			$checkinfo = $this->mysql->select_one("select parent_id from ".Mysite::$app->config['tablepre']."marketcate where id=".$typeid." ");		 
			if($checkinfo['parent_id'] > 0){//超市二级分类  				
				$this->mysql->delete(Mysite::$app->config['tablepre'].'goods',"typeid ='".$typeid."' and shopid = ".$shopinfo['id']."  ");		
			}else{ //超市一级分类
				$sontypeid = $this->mysql->getarr("select id from ".Mysite::$app->config['tablepre']."marketcate where parent_id=".$typeid." ");	 
				foreach($sontypeid as $k=>$v){
					$this->mysql->delete(Mysite::$app->config['tablepre'].'goods',"typeid ='".$v['id']."' and shopid = ".$shopinfo['id']."  ");	
					$this->mysql->delete(Mysite::$app->config['tablepre'].'marketcate',"id ='".$v['id']."' ");	
				}
			}
			$this->mysql->delete(Mysite::$app->config['tablepre'].'marketcate',"id ='".$typeid."' ");	 
		}else{//外卖
			$this->mysql->delete(Mysite::$app->config['tablepre'].'goodstype',"id ='".$typeid."' ");
			$this->mysql->delete(Mysite::$app->config['tablepre'].'goods',"typeid ='".$typeid."' and shopid = ".$shopinfo['id']."  ");	
		}
		$this->success("删除商品分类成功");	
	}
	/*
	* 商家端改版后
	商家编辑商品分类
	2017-07-04修改yxm
	*/
	function editgoodstype(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}  	 
		$shoptype = intval(IFilter::act(IReq::get('shoptype')));//店铺类型 0外卖 1超市
		$id = intval(IFilter::act(IReq::get('id')));
		if($shoptype == 0){
		    $goodstype =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goodstype where id=".$id." order by orderid asc");	    
		}else{
			$goodstype =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."marketcate where id=".$id." order by orderid asc");	
		}
		if(empty($goodstype)) $this->message('分类获取失败');
		$this->success($goodstype);		
	}
	/*
	* 商家端改版后
	商家保存商品分类
	2017-07-04修改yxm
	*/
	function savegoodstype(){		 
		$backinfo = $this->checkapp();		  
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}  	          
		$shopinfo = $this->mysql->select_one("select id,shoptype from ".Mysite::$app->config['tablepre']."shop where uid=".$backinfo['uid']." ");		 
		if(empty($shopinfo)) $this->message('店铺信息获取失败'); 
		$shopid = $shopinfo['id'];//店铺id
		$shoptype = $shopinfo['shoptype'];//店铺类型 0外卖 1超市		
		$id = intval(IFilter::act(IReq::get('id')));    //分类id		
		$name = trim(IFilter::act(IReq::get('name')));  //分类名字
		if(mb_strlen($name,"UTF8")>10) $this->message('商品名称长度不能大于10个字符'); 
		if(empty($name)) $this->message('商品名称不能为空'); 
		
		$pid = intval(IFilter::act(IReq::get('pid')));   //分类父id
		$orderid = intval(IFilter::act(IReq::get('orderid')));//排序号        		
		if($id > 0){  //编辑分类
			if($shoptype == 0){  //外卖分类
				$checkinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goodstype where shopid=".$shopid." and name = '".$name."' and id !=".$id." ");
				if(!empty($checkinfo)) $this->message('该分类已存在，不可重复添加'); 
				$data['name'] = $name;
				$data['orderid'] = $orderid;
				$this->mysql->update(Mysite::$app->config['tablepre'].'goodstype',$data,"id='".$id."' ");			
		    }else{               //超市分类
			    if($pid > 0){    //二级分类
					$checkinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid=".$shopid." and name = '".$name."' and id !=".$id." and parent_id = ".$pid." ");
					if(!empty($checkinfo)) $this->message('该分类已存在，不可重复添加'); 
					$data['name'] = $name;
					$data['orderid'] = $orderid;
					$data['parent_id'] = $pid;
					$this->mysql->update(Mysite::$app->config['tablepre'].'marketcate',$data,"id='".$id."' ");			
			    }else{           //一级分类
				    $checkinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid=".$shopid." and name = '".$name."' and id !=".$id." ");
					if(!empty($checkinfo)) $this->message('该分类已存在，不可重复添加'); 
					$data['name'] = $name;
					$data['orderid'] = $orderid;			
					$this->mysql->update(Mysite::$app->config['tablepre'].'marketcate',$data,"id='".$id."' ");	
			    }
		    }
		}else{      //新建分类
			if($shoptype == 0){  //外卖分类
			    $checkinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goodstype where shopid=".$shopid." and name = '".$name."' ");
				if(!empty($checkinfo)) $this->message('该分类已存在，不可重复添加'); 
				$data['name'] = $name;
				$data['orderid'] = $orderid;
				$data['shopid'] = $shopid;
				$this->mysql->insert(Mysite::$app->config['tablepre']."goodstype",$data);						
		    }else{               //超市分类
			    if($pid > 0){    //二级分类
				    $checkinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid=".$shopid." and name = '".$name."' and parent_id =".$pid." ");
				    if(!empty($checkinfo)) $this->message('该分类已存在，不可重复添加'); 
					$data['name'] = $name;
					$data['orderid'] = $orderid;
					$data['parent_id'] = $pid;
					$data['shopid'] = $shopid;
					$this->mysql->insert(Mysite::$app->config['tablepre'].'marketcate',$data);			
			    }else{           //一级分类
				    $checkinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid=".$shopid." and name = '".$name."' and parent_id = 0 ");
				    if(!empty($checkinfo)) $this->message('该分类已存在，不可重复添加'); 
					$data['name'] = $name;
					$data['orderid'] = $orderid;
                    $data['parent_id'] = 0;		
                    $data['shopid'] = $shopid;                   				
					$this->mysql->insert(Mysite::$app->config['tablepre'].'marketcate',$data);	
			    }
		    } 
		}			 
		$this->success('保存成功！');		
	}
	
	/*
	* 商家端改版后
	商家获取商品分类
	2017-06-26修改yxm
	*/
	function newgoodstype(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		//外卖店铺商品分类
		if($shopinfo['shoptype'] == 0){
		$goodstype =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodstype where shopid='".$shopinfo['id']."' order by orderid asc");	    
     	$tempc = array();
		foreach($goodstype as $key=>$value){
			$value['goodscount'] = $this->mysql->counts("select id from ".Mysite::$app->config['tablepre']."goods where shopid='".$shopinfo['id']."' and typeid   =".$value['id']."  order by id desc"); 
 			$value['sontype'] = array();
			$tempc[] = $value;			
		   } 
		    $data['shoptype'] = 0;
		//超市店铺商品一级分类   
		}else{
		$goodstype =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and parent_id = 0 order by orderid asc");
		$tempc = array();
		foreach($goodstype as $key=>$value){ 
 			//超市店铺商品二级分类   
			$sontypearr =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and parent_id = ".$value['id']." order by orderid asc");
           	$value['goodscount'] = $this->mysql->counts("select id from ".Mysite::$app->config['tablepre']."goods where shopid='".$shopinfo['id']."' and typeid in(select id from ".Mysite::$app->config['tablepre']."marketcate where parent_id =".$value['id'].") order by id desc"); 
		   $value['sontype'] = array();
		   $sontype = array();
		   foreach($sontypearr as $key1=>$value1){			   	
				$value1['goodscount'] = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."goods where shopid='".$shopinfo['id']."' and typeid   =".$value1['id']."  order by id asc"); 
				$sontype[] = $value1;
				$value['sontype'] = $sontype;
			}
			$tempc[] = $value;			
		} 	
         $data['shoptype'] = 1;
		}
		$data['typeinfo'] = $tempc;
		$this->success($data);
	}
	
	/*
	* 商家端改版后
	商家添加商品分类
	2017-06-28修改yxm
	*/
	function newaddgoodstype(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		$id = intval(IFilter::act(IReq::get('id')));
		$name = trim(IFilter::act(IReq::get('name')));
		$orderid = intval(IFilter::act(IReq::get('orderid')));
		$parent_id = intval(IFilter::act(IReq::get('parent_id')));
		
		//外卖店铺商品分类
		if($shopinfo['shoptype'] == 0){	
		$goodstype =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodstype where shopid='".$shopinfo['id']."' order by orderid asc");	    
     	$tempc = array();
		foreach($goodstype as $key=>$value){
 			$value['sontype'] = array();
			$tempc[] = $value;			
		   } 
		//超市店铺商品一级分类   
		}else{
		$goodstype =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and parent_id = 0 order by orderid desc");
		$tempc = array();
		foreach($goodstype as $key=>$value){ 
 			//超市店铺商品二级分类   
			$sontypearr =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and parent_id = ".$value['id']." order by orderid desc");
            foreach($sontypearr as $key1=>$value1){
				$sontype[] = $value1;
				$value['sontype'] = $sontype;
			}
			$tempc[] = $value;			
	    } 		
		}
		$this->success($tempc);
	}
	
	
	/*
	* 商家删除商品分类
	2015-12-26修改
	*/
	function delgoostype(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		$id = intval(IFilter::act(IReq::get('id')));
		if(empty($id)) $this->message('删除ID获取失败');
		if($shopinfo['shoptype'] != 0)$this->message('超市店铺分类删除链接错误'); 
		//增加个check  判断是否
		$checkdata =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods where shopid='".$shopinfo['id']."' and typeid=".$id." order by id desc");
		if(!empty($checkdata)) $this->message('该分类下有商品，删除失败');
		$this->mysql->delete(Mysite::$app->config['tablepre']."goodstype"," shopid='".$shopinfo['id']."' and id=".$id." ");
		$shoptype =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodstype where shopid='".$shopinfo['id']."' order by orderid desc");
		$this->success($shoptype); 
	}
	/*
	* 商家添加商品分类
	2015-12-26修改
	*/
	function addgoostype(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		$id = intval(IFilter::act(IReq::get('id')));
		$name = trim(IFilter::act(IReq::get('name')));
		$orderid = intval(IFilter::act(IReq::get('orderid')));
		//	id	shopid 店铺ID	name 分类名称	orderid	cattype 1外卖 2订台
		if($shopinfo['shoptype'] != 0)$this->message('超市店铺分类添加不通过此处操作'); 
		if(empty($name)) $this->message('分类名称不能为空');
		$newdata['shopid'] = $shopinfo['id'];
		$newdata['name'] = $name;
		$newdata['orderid'] = $orderid;
		$newdata['cattype'] = $shopinfo['shoptype'];
 
		if(empty($id)){
			//新增
			$this->mysql->insert(Mysite::$app->config['tablepre']."goodstype",$newdata);
		}else{
			//编辑
			$this->mysql->update(Mysite::$app->config['tablepre'].'goodstype',$newdata,"id='".$id."' and shopid = '".$shopinfo['id']."'");
		}
		$shoptype =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodstype where shopid='".$shopinfo['id']."' order by orderid desc");
		$this->success($shoptype);
	}
	function typebyid(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
	    $typeid = intval(IFilter::act(IReq::get('typeid'))); 
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		
		if($shopinfo['shoptype'] == 1){
			$typeone = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."marketcate where id='".$typeid."'   order by id desc");
			if(empty($typeone)){
				$this->message('商品分类获取失败');
			}
			$data['typelist'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."marketcate where parent_id='".$typeone['parent_id']."' and shopid  ='".$typeone['shopid']."' order by orderid desc");
			$this->success($data); 
		}else{
			
			$typeone = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goodstype where id='".$typeid."'   order by id desc");
			if(empty($typeone)){
				$this->message('商品分类获取失败');
			}
			$data['typelist'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodstype where shopid='".$typeone['shopid']."'   order by orderid desc");
			$this->success($data); 
		}
		
	}
	/*
	* 商家获取商品
	2017-07-03修改 yxm
	*/
	function newgoodslist(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		$typeid = intval(IFilter::act(IReq::get('typeid'))); 
		$page = intval(IFilter::act(IReq::get('page')));
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		if(strpos($userAgent,"iPhone") || strpos($userAgent,"iPad") || strpos($userAgent,"iPod")){
			 $pagesize = 1000000; 
		}else{
			$pagesize = intval(IFilter::act(IReq::get('pagesize')));
		}

		$pagesize = $pagesize > 0? $pagesize:10; 
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);  
        $goodslist1 =  $this->mysql->getarr("select id,typeid,name,count,cost,bagcost,img,have_det,is_live,shopid,instro,descgoods from ".Mysite::$app->config['tablepre']."goods where shopid='".$shopinfo['id']."' and typeid = ".$typeid." order by id desc  limit   ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."  ");
		
        foreach($goodslist1 as $k=>$v){	 
			$v['img'] = empty($v['img'])?"": Mysite::$app->config['siteurl'].$v['img'];	
			$v['instro'] = empty($v['instro'])?"":strip_tags($v['instro']);
			$goodslist[] = $v;
		}
		$this->success($goodslist);
	}
	/*
	* 商家获取商品
	2015-12-26修改
	*/
	function goodslist(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		$typeid = intval(IFilter::act(IReq::get('typeid'))); 
		$page = intval(IFilter::act(IReq::get('page')));
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		if(strpos($userAgent,"iPhone") || strpos($userAgent,"iPad") || strpos($userAgent,"iPod")){
			 $pagesize = 1000000; 
		}else{
			$pagesize = intval(IFilter::act(IReq::get('pagesize')));
		}
		
		$pagesize = $pagesize > 0? $pagesize:10; 
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);  
//		$goodslist =  $this->mysql->getarr("select id,typeid,name,count,cost,bagcost,img,have_det from ".Mysite::$app->config['tablepre']."goods where shopid='".$shopinfo['id']."' and typeid = ".$typeid." order by id desc  limit   ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."  ");
        $goodslist =  $this->mysql->getarr("select id,typeid,name,count,cost,bagcost,img,have_det,is_live,shopid from ".Mysite::$app->config['tablepre']."goods where shopid='".$shopinfo['id']."' and typeid = ".$typeid." order by id desc  limit   ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."  ");
		$this->success($goodslist);
	}
	/*
	*  商家删除商品
	2015-12-26 修改
	*/
	function delgoos(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
  		$id = intval(IFilter::act(IReq::get('id')));
		if(empty($id)) $this->message('删除ID获取失败');
		$this->mysql->delete(Mysite::$app->config['tablepre']."goods"," shopid='".$shopinfo['id']."' and id=".$id." ");
		$typeid = intval(IFilter::act(IReq::get('typeid')));
		$this->mysql->delete(Mysite::$app->config['tablepre']."product"," shopid='".$shopinfo['id']."' and goodsid=".$id." ");
		//$goodslist =  $this->mysql->getarr("select id,typeid,name,count,cost,bagcost,img from ".Mysite::$app->config['tablepre']."goods where shopid='".$shopinfo['id']."' and typeid = ".$typeid." order by id desc");
		$this->success('ok');
	}
	function onegoods(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
	    $id = intval(IFilter::act(IReq::get('id')));
		if(empty($id)) $this->message('商品获取失败');
		$goodsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods where shopid='".$shopinfo['id']."' and id = ".$id." order by id desc  limit   0,1 ");
		if(empty($goodsinfo)) $this->message("商品获取失败");
		$temparray= empty($goodsinfo['product_attr'])?array():unserialize($goodsinfo['product_attr']);
		//$temparray = array_keys($temparray);
		sort($temparray); 
		$doarray = array();
		if(count($temparray) > 0){
			foreach($temparray as $key=>$value){
			   $doarray[] = $value;
			}
		}
		$goodsinfo['product_attr'] = $doarray;
		 
		$productlist = array();
		if($goodsinfo['have_det'] == 1){
			$productlist= $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."product where shopid='".$shopinfo['id']."' and goodsid = ".$id." order by id desc  limit  0,100  ");
		}
		 
		
		
		
		$tempgglist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodsgg where shoptype = '".$shopinfo['shoptype']."'  order by orderid asc limit 0,1000  ");
        $gglist=array();
        foreach($tempgglist as $key=>$value){
			if($value['parent_id'] == 0){
				 
				
				$value['det'] = array();
				foreach($tempgglist as $c=>$d){
					if($d['parent_id'] == $value['id']){
						$value['det'][] = $d;
					}
				}
				 
				$gglist[] = $value;
			}
			
		}		
	    $backdata['goodsinfo'] =$goodsinfo;
		$backdata['productlist'] =$productlist;
		$backdata['gglist'] = $gglist;
		$this->success($backdata);
		
		
	}
	/*
	*  新版商家端获取后台添加的计量单位
	2017-07-04修改 yxm
	*/
	function goodsattr(){
		$goodsattr = Mysite::$app->config['goodsattr'];
		$goodsattr = unserialize($goodsattr);
		$this->success($goodsattr);
	}

	/*
	*  新版商家端商家编辑已有商品
	2017-07-03修改 yxm
	*/
	function editgoods(){
		$id = intval(IFilter::act(IReq::get('goodsid')));
		$goodsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods where id =  ".$id." ");
		#$goodsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods where id =  5191    ");
		
		$data['name'] = $goodsinfo['name'];      //商品名字
		$data['have_det'] = $goodsinfo['have_det'];  //是否为多规格
		$data['img'] = empty($goodsinfo['img'])?'': Mysite::$app->config['siteurl'].$goodsinfo['img'];//图片全路径
		$data['img1'] = empty($goodsinfo['img'])?'':$goodsinfo['img'];//图片半路径
		$data['bagcost'] = $goodsinfo['bagcost'];  //打包费
		$data['instro'] = empty($goodsinfo['instro'])?"":$goodsinfo['instro'];    //商品简述
		$data['goodattr'] = $goodsinfo['goodattr'];//计量单位
		$data['typeid'] = $goodsinfo['typeid'];    //所属分类
		$product_attr = unserialize($goodsinfo['product_attr']);//规格值
		 
		#print_r($product_attr);exit;
		if($data['have_det'] == 1){
			foreach($product_attr as $key=>$value){
			$fgg[] = $key;    
            $cgg = array();			
			foreach($value['det'] as $k=>$v){
			$cgg[] = $v['id'];		
		    }
			$cgg1[] = implode(',',$cgg);          	 
		}
		    $fgg = implode(',',$fgg);
			$cgg = implode('@',$cgg1);
			$data['fgg'] = empty($fgg)?"":$fgg;
			$data['cgg'] = empty($cgg1)?"":$cgg;
			$productinfo =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."product where goodsid =  ".$id." ");	 
			#print_r($productinfo);exit;
			$sgg = array();
			$price = array();
			$count = array();
			foreach($productinfo as $key=>$value){
				$sgg[] = $value['attrids'];
                $sggname[] = $value['attrname'];				
				$price[] = $value['cost'];	
				$count[] = $value['stock'];	
			}			
			$sgg = implode('@',$sgg);
			$sggname = implode('@',$sggname);
			$data['sgg'] = empty($sgg)?"":$sgg;
			$data['sggname'] = empty($sggname)?"":$sggname;
			$price = implode(',',$price);
			$count = implode(',',$count);
			$data['price'] = $price;
			$data['count'] = $count;
		}else{
			$data['price'] = $goodsinfo['cost'];
			$data['count'] = $goodsinfo['count'];
		}		
		$this->success($data);		
	}
	
	
	
	/*
	*  新版商家端商家添加商品
	2017-07-01修改 yxm
	*/
	function addgoods(){		 
	      /* $goodsinfo =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."product where goodsid =  5189    ");
		print_r($goodsinfo);exit;   */  
	    $backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo = $this->mysql->select_one("select id,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' "); 
		/* $shopinfo = $this->mysql->select_one("select id,shoptype from ".Mysite::$app->config['tablepre']."shop where uid= 13549"); */
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		$id = intval(IFilter::act(IReq::get('id')));    //判断是新增还是编辑   为空时新增商品  不为空时编辑已有商品
		$name = trim(IFilter::act(IReq::get('name')));
		$count = intval(IFilter::act(IReq::get('count')));   //库存
		$price = trim(IFilter::act(IReq::get('price')));
		$price = intval($price*100);
		$price = $price/100;                                    //价格
		$goodattr = trim(IFilter::act(IReq::get('goodattr'))); //计量单位
		$instro = trim(IFilter::act(IReq::get('instro')));     //商品简述
		$typeid = intval(IFilter::act(IReq::get('typeid')));   //所属分类
		$bagcost = IFilter::act(IReq::get('bagcost'));   //餐盒费
		$img = trim(IFilter::act(IReq::get('img')));           //图片
		$havedet = intval(IFilter::act(IReq::get('havedet')));	// 判断有无规格  0无规格  1有规格
        
		$data['shopid'] = $shopinfo['id'];
		$data['is_live'] = 1;
		$data['name'] = $name;
		$data['count'] = $count;
		$data['cost'] = $price;
		$data['typeid'] = $typeid; 
		$data['bagcost'] = $bagcost;		 
		$data['img'] = $img; 
		$data['goodattr'] = $goodattr;
		$data['instro'] = $instro;
		
		if(empty($name)) $this->message('商品名称不能为空'); 
		if(empty($typeid)) $this->message('请选择商品分类'); 
		 //编辑商品
		if($id > 0){           
			if($havedet == 0){  //编辑无规格商品			
	            $data['have_det'] = 0;
			    $this->mysql->update(Mysite::$app->config['tablepre'].'goods',$data,"id='".$id."' and shopid='".$shopinfo['id']."' ");
			    $this->mysql->delete(Mysite::$app->config['tablepre'].'product',"`goodsid`=".$id." ");
				$goodsid = $id;			
			}else{              //编辑有规格商品			    
			    $this->mysql->delete(Mysite::$app->config['tablepre'].'goods'," `id`=".$id." ");  
			    $this->mysql->delete(Mysite::$app->config['tablepre'].'product',"`goodsid`=".$id." ");  
			    $data['have_det'] = 1;
				$data['id'] = $id;
				$fgg = trim(IFilter::act(IReq::get('fgg')));     //父规格集合
				 #print_r($fgg);exit;    114,99
				$cgg = trim(IFilter::act(IReq::get('cgg')));     //每个父规格下被选中的子规格id集
				 #print_r($cgg);exit;    117,116@113,101
				$sgg = trim(IFilter::act(IReq::get('sgg')));     //每个商品选中的子规格集合
				 #print_r($sgg);exit;    117,113@117,101@116,113@116,101
				$price = trim(IFilter::act(IReq::get('price'))); //价格集合
				$count = trim(IFilter::act(IReq::get('count'))); //库存集合			 
				$pricearr =  explode(",", $price);//价格数组
				$data['cost'] = min($pricearr);  //获取所有规格中价格最小的那个作为主商品的价格
				$countarr =  explode(",", $count); //库存数组
				$data['count'] = min($countarr);  //获取所有规格中库存最小的那个作为主商品的库存				
				$cgg = str_replace("@",",", $cgg);	//子规格id集合		
				/*  Array ( [0] => 117,116 [1] => 113,101 )  */
				
				#prinT_r($cggarr);exit;
				$sggarr = explode("@", $sgg);	//每个商品选中的子规格数组			
				/*Array ( [0] => 117,113 [1] => 117,101 [2] => 116,113 [3] => 116,101 )*/
				#prinT_r($sggarr);exit;
				$gglist = $this->mysql->getarr("select * from " . Mysite::$app->config['tablepre'] . "goodsgg where  FIND_IN_SET( `id` , '" . $fgg . "' ) and parent_id = 0  order by orderid asc limit 0,1000  ");				
				/*Array
					(
						[0] => Array
							(
								[id] => 99
								[shoptype] => 0
								[name] => 辣
								[orderid] => 1
								[parent_id] => 0
							)

						[1] => Array
							(
								[id] => 114
								[shoptype] => 0
								[name] => 份
								[orderid] => 1
								[parent_id] => 0
							)

					)*/
				#prinT_r($gglist);exit;
				$product_attr = array();
				foreach ($gglist as $key => $value) {					 					
					$value['det'] = $this->mysql->getarr("select * from " . Mysite::$app->config['tablepre'] . "goodsgg where  FIND_IN_SET( `id` , '" . $cgg . "' ) and parent_id = " . $value['id'] . "  order by orderid asc limit 0,1000  ");                     
					$product_attr[$value['id']] = $value;				     
				}				
				$data['product_attr'] = serialize($product_attr);				
				//生成主商品  插入goods表		 
				$this->mysql->insert(Mysite::$app->config['tablepre']."goods",$data);			    				
				//生成子商品  循环插入product表
				$gdata['shopid'] = $data['shopid'];
				$gdata['bagcost'] = $data['bagcost'];
				$gdata['goodsid'] = $id;
				$gdata['goodsname'] = $data['name'];				
				foreach ($sggarr as $key => $value) {					 
					$gdata['attrids'] = $value;
					$gdata['cost'] = $pricearr[$key];
					$gdata['stock'] = $countarr[$key];
					//获取单个商品对应的规格名
					$attrnamearr = $this->mysql->getarr("select name from " . Mysite::$app->config['tablepre'] . "goodsgg where  FIND_IN_SET( `id` , '" . $value . "' )  order by orderid asc limit 0,1000  ");            				    				
					$namearr = array();
					foreach ($attrnamearr as $key => $value) {
						$namearr[] = $value['name'];						
					}
					$attrname = implode(',',$namearr);
					$gdata['attrname'] = $attrname;					 
                    $this->mysql->insert(Mysite::$app->config['tablepre']."product",$gdata); 
				}
                $goodsid = $id;				
			}
	    //新增商品
		}else{                   
			if($havedet == 0){   //新增无规格商品				
	            $data['have_det'] = 0;
				$this->mysql->insert(Mysite::$app->config['tablepre']."goods",$data);
			    $goodsid = $this->mysql->insertid();
			}else{               //新增有规格商品			
				$data['have_det'] = 1;
				$fgg = trim(IFilter::act(IReq::get('fgg')));     //父规格集合
				$cgg = trim(IFilter::act(IReq::get('cgg')));     //每个父规格下被选中的子规格id集
				$sgg = trim(IFilter::act(IReq::get('sgg')));     //每个商品选中的子规格集合
				$price = trim(IFilter::act(IReq::get('price'))); //价格集合
				$count = trim(IFilter::act(IReq::get('count'))); //库存集合			 
				$pricearr =  explode(",", $price);//价格数组
				$data['cost'] = min($pricearr);  //获取所有规格中价格最小的那个作为主商品的价格
				$countarr =  explode(",", $count); //库存数组
				$data['count'] = min($countarr);  //获取所有规格中库存最小的那个作为主商品的库存				
				$cgg = str_replace("@",",", $cgg);	//子规格集合			
				$sggarr = explode("@", $sgg);	//每个商品选中的子规格数组			
				$gglist = $this->mysql->getarr("select * from " . Mysite::$app->config['tablepre'] . "goodsgg where  FIND_IN_SET( `id` , '" . $fgg . "' ) and parent_id = 0  order by orderid asc limit 0,1000  ");				
				$product_attr = array();
				foreach ($gglist as $key => $value) {
					$value['det'] = $this->mysql->getarr("select * from " . Mysite::$app->config['tablepre'] . "goodsgg where  FIND_IN_SET( `id` , '" . $cgg . "' ) and parent_id = " . $value['id'] . "  order by orderid asc limit 0,1000  ");
                    $product_attr[$value['id']] = $value;				     
				}
				#print_r($product_attr);exit;
				$data['product_attr'] = serialize($product_attr);
                  				
				//生成主商品  插入goods表		 
				$this->mysql->insert(Mysite::$app->config['tablepre']."goods",$data);
			    $goodsid = $this->mysql->insertid();
				//生成子商品  循环插入product表
				$gdata['shopid'] = $data['shopid'];
				$gdata['bagcost'] = $data['bagcost'];
				$gdata['goodsid'] = $goodsid;
				$gdata['goodsname'] = $data['name'];				
				foreach ($sggarr as $key => $value) {					 
					$gdata['attrids'] = $value;
					$gdata['cost'] = $pricearr[$key];
					$gdata['stock'] = $countarr[$key];
					//获取单个商品对应的规格名
					$attrnamearr = $this->mysql->getarr("select name from " . Mysite::$app->config['tablepre'] . "goodsgg where  FIND_IN_SET( `id` , '" . $value . "' )  order by orderid asc limit 0,1000  ");            				    				
					$namearr = array();
					foreach ($attrnamearr as $key => $value) {
						$namearr[] = $value['name'];						
					}
					$attrname = implode(',',$namearr);
					$gdata['attrname'] = $attrname;					 
                    $this->mysql->insert(Mysite::$app->config['tablepre']."product",$gdata); 
				}	 
			}		
		} 
		$this->success($goodsid);
	}	
	/*
	*  商家添加商品
	2015-12-25修改
	*/
	function addgoos(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		$id = intval(IFilter::act(IReq::get('id')));
		$name = trim(IFilter::act(IReq::get('name')));
		$count = intval(IFilter::act(IReq::get('count')));
		$cost = trim(IFilter::act(IReq::get('cost')));
		$cost = intval($cost*100);
		$cost = $cost/100;
		$typeid = intval(IFilter::act(IReq::get('typeid'))); 
		$bagcost = trim(IFilter::act(IReq::get('bagcost')));
		$img = trim(IFilter::act(IReq::get('img')));
		$changeflag = intval(IFilter::act(IReq::get('changeflag')));
		//	id	shopid 店铺ID	name 分类名称	orderid	cattype 1外卖 2订台
		if(empty($name)) $this->message('商品名称不能为空'); 
		
	    if($id > 0){
			$goodsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods where shopid='".$shopinfo['id']."' and id = ".$id." order by id desc  limit   0,1 ");
		    if(empty($goodsinfo)) $this->message('商品不存在');  
		} 
		if($changeflag ==1){
			if($id < 1) $this->message('编辑商品商品不存在');
		}
		if($typeid < 1) $this->message('请选择商品所属分类');
		if($shopinfo['shoptype'] == 0){
			$catinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goodstype where shopid='".$shopinfo['id']."' and id = ".$typeid." order by id desc  limit   0,1 ");
		    if(empty($catinfo)) $this->message('商品分类不存在');
		}else{
			$catinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and id = ".$typeid." order by id desc  limit   0,1 ");
		    if(empty($catinfo)) $this->message('商品分类不存在');
		}
		$data['shopid'] = $shopinfo['id'];
		$data['is_live'] = 1;
		$data['name'] = $name;
		$data['count'] = $count;
		$data['cost'] = $cost;
		$data['typeid'] = $typeid; 
		$data['bagcost'] = $bagcost;
		if(!empty($img)){
			$data['img'] = $img; 
		}	
		if($changeflag == 1){           //编辑商品
			   $data['have_det'] = $goodsinfo['have_det'];
			   $data['product_attr'] = $goodsinfo['product_attr'];
		}else{                          //新增商品
			   $Productids = array();
			   $have_det = intval(IFilter::act(IReq::get('have_det')));
			   $data['have_det'] = 0;
			   $data['product_attr'] = '';
			   $idtonamearray = array();
				if($have_det == 1){
					$fggids = trim(IFilter::act(IReq::get('fggids')));
					if(!empty($fggids)){ 
					 
						$gglist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodsgg where  FIND_IN_SET( `id` , '".$fggids."' ) and parent_id = 0  order by id desc limit 0,1000  ");
						 
						$product_attr = array();
						if(!empty($gglist)){//获取所有规格不为空
						   foreach($gglist as $key=>$value){
								  $checkid = IFilter::act(IReq::get('choicegg'.$value['id']));
								  if(!empty($checkid)){
										$checkid = is_array($checkid)?join(',',$checkid):trim($checkid);
										
										 
										$value['det'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodsgg where  FIND_IN_SET( `id` , '".$checkid."' ) and parent_id = ".$value['id']."  order by id desc limit 0,1000  ");
										$product_attr[$value['id']] = $value; 
										 
										foreach($value['det']  as $k=>$v){
											$idtonamearray[$v['id']] = $v['name'];
										}
								  }
						   }
						} 
						if(count($product_attr) > 0){
							
							 $data['have_det'] = 1;
							 $data['product_attr'] = serialize($product_attr);  
							 //循环写入入字表
							 // goodsdetids  goodsdetids
							 $goodsdetids  =IFilter::act(IReq::get('goodsdetids'));  //删除所有 改商品 gooids 相同但不在goodsdetids 里的值
							 $checkinfoggggg = $goodsdetids;
							 $goodsdetids = is_array($goodsdetids)?join(',',$goodsdetids):intval($goodsdetids);
							 if($id > 0){
								//$checkinfo = join(',',$goodsdetids);
								if(!empty($goodsdetids)){
									$tempidsddd = array();
									foreach($checkinfoggggg as $key=>$value){
										if(!empty($value)){
											$tempidsddd[] = $value;
										}
									}
									$sqlstr = join(',',$tempidsddd);
									if(!empty($sqlstr)){
										$this->mysql->delete(Mysite::$app->config['tablepre'].'product'," `id` not in(".$goodsdetids.")  and `goodsid`=".$id." ");  
									}else{
										$this->mysql->delete(Mysite::$app->config['tablepre'].'product',"   `goodsid`=".$id." ");  
									}
								}else{
									 $this->mysql->delete(Mysite::$app->config['tablepre'].'product',"   `goodsid`=".$id." ");  
								
								}
							 }
							 $productlist = array();
							 $gg_scost=IFilter::act(IReq::get('gg_scost'));
							 $gg_sstock = IFilter::act(IReq::get('gg_sstock'));
							 $gg_sids =  IFilter::act(IReq::get('gg_sids'));
							 $goodsdetids =  IFilter::act(IReq::get('goodsdetids'));
							 if(is_array($gg_scost)){ 
								$data['count'] = 0;
								 foreach($gg_scost as $key=>$value){
									 if(isset($gg_sids[$key]) && !empty($gg_sids[$key])){
										 $tempids = $gg_sids[$key];
										 $attr_ids = explode(',',$tempids);
										 $attr_arr = array();
										 foreach($attr_ids as $k=>$v){
											 if(isset($idtonamearray[$v])){
												 $attr_arr[] = $idtonamearray[$v];
											 }
										 }
										 $prodata['shopid'] = $shopinfo['id'];
										 $prodata['goodsid'] = $id;
										 $prodata['goodsname'] = $name;
										 $prodata['attrname'] = join(',',$attr_arr);//需要根据参数
										 $prodata['attrids']   = $gg_sids[$key];//需要根据参数
										 $prodata['stock'] =  isset($gg_sstock[$key])?$gg_sstock[$key]:0;//需要参数量
										 $prodata['bagcost'] = $bagcost;
										 $prodata['cost'] = $value;//
										  if($id > 0){
												$prodata['id'] = isset($goodsdetids[$key])?$goodsdetids[$key]:0;
										  }else{
											  $prodata['id'] = 0;
										  }
										 $productlist[] = $prodata;
										 $data['cost'] = $value;
										 $data['count'] = $data['count']+$prodata['stock'];
									 }
								 }
							}
							
							 
							foreach($productlist as $key=>$value){
								if($value['id'] > 0){ 
									$tempp = $value;
									unset($tempp['id']);
									$this->mysql->update(Mysite::$app->config['tablepre'].'product',$tempp,"id='".$value['id']."'  ");
								}else{
									unset($value['id']);
									$this->mysql->insert(Mysite::$app->config['tablepre'].'product',$value); 
									$ccid = $this->mysql->insertid(); 
										$Productids[] = $ccid;
									 
								} 
							} 
									
						}  
					}
				}  
		}
		 
		//			exit;
		if(empty($id)){
			//新增
			//sellcount 销售数量	shopid 店铺ID	uid  daycount  shoptype
			$data['sellcount'] = 0;
			$data['shopid'] = $shopinfo['id'];
			$data['uid'] =$backinfo['uid'];
			$data['shoptype'] =  $shopinfo['shoptype'];
			$data['daycount'] = $data['count'];
			$this->mysql->insert(Mysite::$app->config['tablepre']."goods",$data);
			$goodsid = $this->mysql->insertid();
			if(count($Productids)> 0){
				$this->mysql->update(Mysite::$app->config['tablepre'].'product',array('goodsid'=>$goodsid),"id in(".join(',',$Productids).")  ");
			}
		}else{
			//编辑
			$this->mysql->update(Mysite::$app->config['tablepre'].'goods',$data,"id='".$id."' and shopid='".$shopinfo['id']."' ");
			$goodsid = $id;
		}
		$this->success($goodsid);
	}
	
	//编辑子商品
	function edit_product(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败'); 
		$productid = intval(IFilter::act(IReq::get('productid')));
		$stock = intval(IFilter::act(IReq::get('stock')));
		$cost = intval(IFilter::act(IReq::get('cost')));
		$productinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."product where id='".$productid."' ");
		if(empty($productinfo)){
			$this->message('商品信息不存在');
		}
		$goodsinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods where id='".$productinfo['goodsid']."'");
		if(empty($goodsinfo)){
			$this->message('商品信息不存在');
		}
		if($productinfo['shopid'] != $shopinfo['id']){
			$this->message('商品id和店铺id不一直');
		}
		
		$newdata['stock'] = $stock;
		$newdata['cost'] = $cost;
		$newdata['bagcost'] = $goodsinfo['bagcost']; 
		
		 $this->mysql->update(Mysite::$app->config['tablepre'].'product',$newdata,"id =".$productid."  ");
		 $this->success('success'); 
	}
	
	
	//获取店铺 配送时间列表
	function shop_pstimelist(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		} 
		$shopinfo= $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)){
			$this->message('店铺不存在');
		}else{
			$shopdet = '';
			if($shopinfo['shoptype'] == 0){
				$shopdet  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast       where  shopid = ".$shopinfo['id']."   ");  
			}else{
				$shopdet  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket       where  shopid = ".$shopinfo['id']."   ");  
			} 
			if(empty($shopdet)){
				$this->message('店铺未开启');
			}
			//一次性构造所有时间段
			$intvaltime = intval($shopdet['interval_minit']);
			$intvaltime = $intvaltime < 5?30:$intvaltime;
			
			$minidaydaytime = strtotime(date('Y-m-d',time()));  //当天最小时间
			$minday = date('Y-m-d',time());
			
			$tempopendata = explode('|',$shopinfo['starttime']);
			if(empty($shopinfo['starttime'])){
				$this->message('请先设置营业时间');
			}
			//构造所有时间段
			$opendata = array();
			foreach($tempopendata as $key=>$value){
				if(!empty($value)){
					$newtemp = explode('-',$value);
					if(count($newtemp)==2 && !empty($newtemp[0]) && !empty($newtemp[1])){
						$ccc =array();
						$temp_a_s  = $newtemp[0];
						$temp_a_e = $newtemp[1];
						$temp_a_s = strtotime($minday.' '.$temp_a_s.':00'); 
						$temp_a_e = strtotime($minday.' '.$temp_a_e.':00');
						$checkdotime = $temp_a_s;
						while($checkdotime < $temp_a_e){
							$tempd = array();
							$astime = date('H:i',$checkdotime);
							$tempd['sdata'] = $checkdotime-$minidaydaytime; 
							$checkdotime = $checkdotime+60*$intvaltime;
							if($checkdotime < $temp_a_e){ 
							}else{
								$checkdotime = $temp_a_e; 
							}
						    $tempd['edata'] = $checkdotime-$minidaydaytime;
							$estime = date('H:i',$checkdotime);
						    $tempd['stime'] = $astime;
						    $tempd['etime'] = $estime;
							$tempd['choice'] = 0;
							$opendata[] = $tempd;
						}
					}
				} 
			}
			$timelist = !empty($shopdet['postdate'])?unserialize($shopdet['postdate']):array();  
			$newopendata = array();
			foreach($opendata as $key=>$value){
				$tempfind = false;
				foreach($timelist as $k=>$v){
				    if($value['sdata'] == $v['s'] && $value['edata'] == $v['e']){
					   $tempfind = true;
				    } 
				} 
				if($tempfind == true){
					$value['choice'] = 1;
				}
				$newopendata[] = $value;
			} 
		    $this->success($newopendata); 
		} 
	}
	function editshop(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$typename = trim(IFilter::act(IReq::get('typename')));
		$typevalue = trim(IFilter::act(IReq::get('typevalue')));
	 
	 
		//   opentime
		// if(!in_array($typename,array('opentype','opentime','shopphone'))) $this->message('未定义的操作');
		if($typename == 'shopopentype'){  
			$data['is_open'] = intval($typevalue);
		}elseif($typename == 'opentime'){ 
			$bakcdata = str_replace(",", "|", $typevalue);
			
			$checkinfo = explode('|',$bakcdata);
			$checktime = 0;
			if(count($checkinfo) > 0){
				foreach($checkinfo as $key=>$value){
					  if(!empty($value)){
						 $check2 = explode('-',$value);
						 if(count($check2)== 2){
							 $chka = strtotime($check2[0]);
							 if($checktime > $chka){
								   $this->message('时间格式错误上次结束时间'.date('H:i',$checktime).'大于'.date('H:i',$chka));
							 }
							 $checktime = $chka;
							  $chkb = strtotime($check2[1]);
							 if($checktime > $chkb){
								   $this->message('时间格式错误上次结束时间'.date('H:i',$checktime).'大于'.date('H:i',$chkb));
							 }
							  $checktime = $chkb;
						 }
					  }
					
				}
				
			} 
			$data['starttime'] = $bakcdata;
		}elseif($typename=='shopname'){  
			$data['shopname'] = trim($typevalue);
		}elseif($typename=='shopaddress'){  
			$data['address'] = trim($typevalue);
		}elseif($typename == 'shopphone'){
			if(!(IValidate::phone($typevalue))) $this->message('正录入正确的订餐电话');
			$data['phone'] = $typevalue;
		}elseif($typename == 'intr_info'){
			$data['intr_info'] = trim($typevalue);
		}elseif($typename == 'notice_info'){
			$data['notice_info'] = trim($typevalue);
		}elseif($typename == 'is_orderbefore'){
			$data['is_orderbefore'] = trim($typevalue);
			$shopinfo= $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' "); 
			if(empty($shopinfo)){
				$this->message('店铺不存在');
			}
			$shopdet = '';
			if($shopinfo['shoptype'] == 0){
				$shopdet  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast       where  shopid = ".$shopinfo['id']."   ");  
			}else{
				$shopdet  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket       where  shopid = ".$shopinfo['id']."   ");  
			} 
			if(empty($shopdet)){
				$this->message('店铺未开启');
			}
			
			if($shopinfo['shoptype'] == 0){
				$this->mysql->update(Mysite::$app->config['tablepre'].'shopfast',$data,"shopid='".$shopinfo['id']."'");
			}else{
				$this->mysql->update(Mysite::$app->config['tablepre'].'shopmarket',$data,"shopid='".$shopinfo['id']."'"); 
			}
			$this->success('ok');  
		}elseif($typename == 'pstime'){
		 
			$pstimestime = IFilter::act(IReq::get('pstimestime'));
			$pstimeetime = IFilter::act(IReq::get('pstimeetime')); 
			
			 
			$postdata = array();
			$miniday = strtotime(date('Y-m-d',time()));
			$minidaydate = date('Y-m-d',time());
			if(is_array($pstimestime)){
				foreach($pstimestime as $key=>$value){  
						 if(isset($pstimeetime[$key]) && !empty($pstimeetime[$key]) && !empty($value)){
							 $tempb = array();
							 $tempb['s'] = strtotime($minidaydate.' '.$value.':00')-$miniday;
							 $tempb['e'] = strtotime($minidaydate.' '.$pstimeetime[$key].':00')-$miniday;
							 
							 
							 
							 
							 $tempb['i'] = ''; 
							 $tempb['cost'] = 0;
							 $postdata[] = $tempb;
						 } 
				}
			}
			$shopinfo= $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		 
			if(empty($shopinfo)){
				$this->message('店铺不存在');
			}
			$shopdet = '';
			if($shopinfo['shoptype'] == 0){
				$shopdet  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast       where  shopid = ".$shopinfo['id']."   ");  
			}else{
				$shopdet  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket       where  shopid = ".$shopinfo['id']."   ");  
			} 
			if(empty($shopdet)){
				$this->message('店铺未开启');
			}
			$timelist = !empty($shopdet['postdate'])?unserialize($shopdet['postdate']):array();   
			$newopendata = array();
			foreach($postdata as $key=>$value){
				$tempfind = false;
				foreach($timelist as $k=>$v){
				    if($value['s'] == $v['s'] && $value['e'] == $v['e']){
						
					   $tempfind = true;
					   $value['cost'] = $v['cost'];
				    } 
				} 
				$newopendata[] = $value;
			} 
		    $data['postdate'] =serialize($newopendata); 
			if($shopinfo['shoptype'] == 0){
				$this->mysql->update(Mysite::$app->config['tablepre'].'shopfast',$data,"shopid='".$shopinfo['id']."'");
			}else{
				$this->mysql->update(Mysite::$app->config['tablepre'].'shopmarket',$data,"shopid='".$shopinfo['id']."'"); 
			}
			$this->success('ok');  
		}elseif($typename == 'limitcost'){
			$data['limitcost'] = trim($typevalue);
			$shopinfo= $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		    if(empty($shopinfo)){
				$this->message('店铺不存在');
			}else{
				if($shopinfo['shoptype'] == 0){
					$shopdet  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast       where  shopid = ".$shopinfo['id']."   "); 
				  
				}else{
					$shopdet  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket       where  shopid = ".$shopinfo['id']."   "); 
				 
				} 
				if(!empty($shopdet)){
					if($shopinfo['shoptype'] == 0){
						$this->mysql->update(Mysite::$app->config['tablepre'].'shopfast',$data,"shopid='".$shopinfo['id']."'");
					}else{
						$this->mysql->update(Mysite::$app->config['tablepre'].'shopmarket',$data,"shopid='".$shopinfo['id']."'"); 
					}
				}
			}
			$this->success('ok');
		}else{ 
			$this->message('未定义的操作');
		}
		$this->mysql->update(Mysite::$app->config['tablepre'].'shop',$data,"uid='".$backinfo['uid']."'");  
		$this->success('ok');
	}
    function uplodeimg(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}   	
		$json = new Services_JSON();
		$uploadpath = 'upload/goods/';
		$filepath = '/upload/goods/';
		$upload = new upload($uploadpath,array('gif','jpg','jpge','png'));//upload
		$file = $upload->getfile();
		if($upload->errno!=15&&$upload->errno!=0) {
			$this->message($upload->errmsg());

		}else{
			$data['img'] = $filepath.$file[0]['saveName'];			
			$this->success($data);
		} 
	}

	/*
	* 商家获取单个订单
	*/
	function appone(){
		$statusarr = array('0'=>'新订单','1'=>'待发货','2'=>'待完成','3'=>'完成','4'=>'关闭','5'=>'关闭');
		$gostatusarr = array('0'=>'新订单','1'=>'待消费','2'=>'待消费','3'=>'已消费','4'=>'关闭','5'=>'关闭');
		$paytypelist = array('0'=>'货到支付','1'=>'账号余额支付');
		$shoptypearr = array(
			'0'=>'外卖',
			'1'=>'超市',
			'2'=>'其他',
			'100'=>'跑腿',
	     );
		$paylist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."paylist   order by id asc limit 0,50");
		if(is_array($paylist)){
			foreach($paylist as $key=>$value){
				$paytypelist[$value['loginname']] = $value['logindesc'];
			}
		}
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$orderid = trim(IFilter::act(IReq::get('orderid')));
		if(empty($orderid)){
			$this->message('订单不存在或者不属于您');
		}
		$order= $this->mysql->select_one("select id,dno,addtime,daycode,shopcost,shopname,shopuid,paytype,paystatus,daycode,ipaddress,allcost,buyername,buyeraddress,buyerphone,posttime,status,is_make,pstype,shopps,shoptype,cxcost,yhjcost,scoredown,bagcost,content,othertext,is_goshop from ".Mysite::$app->config['tablepre']."order where id='".$orderid."' "); //cxids 促销规则ID集	cxcost  yhjcost  bagcost
		if(empty($order)){
			$this->message('订单不存在');
		}
		if($order['shopuid'] != $backinfo['uid']) $this->message('您不是订单所有者');
		$order['showstatus'] = $order['is_goshop'] == 1?$gostatusarr[$order['status']]: $statusarr[$order['status']];
		if($order['status'] ==  1){
			if($order['is_make'] == 0){
				$order['showstatus'] = '新订单';
			}elseif($order['status'] !=1){
				$order['showstatus'] = '取消制作';
			}
		}
		$order['othercontent'] = '';
		if(!empty($order['othertext'])){
			$dosendata = unserialize($order['othertext']);
			foreach($dosendata as $key=>$value){
				$order['othercontent']  = empty($order['othercontent'])?$key.$value:$key.$value.','.$order['othercontent'];
			}
		}
		$order['posttimename'] = '配送时间:';
		if($order['is_goshop'] == 1){
		   $order['ordershow'] = '预订/订座';
		   $order['posttimename'] = '消费时间:';
		   $paytypelist[0] = '到店支付';
		}else if($order['shoptype'] == 100){
		   $order['ordershow'] = '跑腿'; 
		}elseif($order['shoptype'] == 1){
			 $order['ordershow'] = '超市'; 
		}else{
			$order['ordershow'] = '外卖';
		}
		
 	    $order['shoptype'] = isset($shoptypearr[$order['shoptype']])?$shoptypearr[$order['shoptype']]:'其他';
		 
		
		//cxcost,yhjcost,scoredown,
		$scoretocost =Mysite::$app->config['scoretocost'];
		$scorcost = $order['scoredown'] > 0? intval($order['scoredown']/$scoretocost):0;
		$order['allcx'] = $order['cxcost']+$order['yhjcost']+$scorcost;
	
		$order['paytype'] = $paytypelist[$order['paytype']];
		$order['paystatustype'] =  empty($order['paystatus'])?'未支付':'已支付';
		$order['addtime'] = date('H:i:s',$order['addtime']);
		$order['posttime'] = date('Y-m-d H:i:s',$order['posttime']);
		$templist =   $this->mysql->getarr("select id,order_id,goodsname,goodscost,goodscount from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$orderid."' ");
		$newdatalist = array();
		$shuliang = 0;
		foreach($templist as $key=>$value){
			$value['goodscost'] = $value['goodscost'];
			$newdatalist[] = $value; 
			$shuliang += $value['goodscount'];
		}
		$newgoods = array('id'=>'0','order_id'=>$orderid,'goodsname'=>'商品总价','goodscount'=>$shuliang,'goodscost'=>$order['shopcost']);
		$newdatalist[] = $newgoods;

		$order['det'] = $newdatalist;
		if(!empty($order['othertext'])){
			$tempcontent = unserialize($order['othertext']);
			foreach($tempcontent as $key=>$value){
				$order['content'] = $order['content'].$key.':'.$value.',';
			}
		}
		
 

		$this->success($order);
	}
	/*
     商家订单处理 8.6修改
	*/
	function ordercontrol(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$orderid = trim(IFilter::act(IReq::get('orderid')));
		$dostring = trim(IFilter::act(IReq::get('dostring')));
		if(empty($orderid)) $this->message('订单获取失败');
		if(!in_array($dostring,array('domake','unmake','send','over'))) $this->message('未定义的操作'); 
		$shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop  where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)){
			$this->message('店铺不存在');
		} 
		$shopctlord = new shopctlord($orderid,$shopinfo['id'],$this->mysql); 
		if($dostring == 'domake'){ 
			if($shopctlord->makeorder()){
				$this->success('success');
			}else{
				$this->message($shopctlord->Error());
			}  
		}elseif($dostring == 'unmake'){  
		     if($shopctlord->SetMemberls($this->memberCls)->unmakeorder()){
				$this->success('success');
			}else{
				$this->message($shopctlord->Error());
			}  
		}elseif($dostring == 'send'){ 
			if($shopctlord->sendorder()){
				$this->success('success');
			}else{
				$this->message($shopctlord->Error());
			}  
		}elseif($dostring == 'over'){
			if($shopctlord->SetMemberls($this->memberCls)->wancheng()){
					$this->success('success');
			}else{
				$this->message($shopctlord->Error());
			}  
		}else{
			$this->message('未定义的操作');
		}
		$this->success('操作成功');
	}
	/*
	*   商家登陆
	*/
function applogin(){
	$uname = trim(IFilter::act(IReq::get('uname')));
	$pwd = trim(IFilter::act(IReq::get('pwd')));
	$mDeviceID =  trim(IFilter::act(IReq::get('mDeviceID')));
	if(empty($uname)) $this->message('用户名为空');
	if(empty($pwd)) $this->message('密码为空'); 
	if(!$this->memberCls->login($uname,$pwd)){
		$this->message($this->memberCls->ero());
	}
	$uid = $this->memberCls->getuid();
	$member= $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$uid."' ");
	//2015.6.6新增加获取店铺类型
	$showtype = trim(IFilter::act(IReq::get('showtype')));
	$member['shoptype'] = 0;//模式普通店铺
	$shopinfo = $this->mysql->select_one("select shoptype,id from ".Mysite::$app->config['tablepre']."shop  where uid='".$uid."' ");
	if(empty($shopinfo)){
		$this->message('店铺不存在');
	}
	if($shopinfo['id'] == Mysite::$app->config['plateshopid'] ){
		$this->message('平台采购店铺请在pc端登录');
	}
	$member['shoptype'] = $shopinfo['shoptype'];
	//获取结束
	/*userid
	/*channelid */
	$userid = trim(IFilter::act(IReq::get('userid')));
	 
		$checkmid =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."applogin where uid='".$member['uid']."' ");
		if(empty($checkmid)){
			$Mdata['channelid'] = $channelid;
			$Mdata['userid'] = $userid;
			$Mdata['uid']=$member['uid'];
			$Mdata['addtime'] = time();
		//    $this->mysql->delete(Mysite::$app->config['tablepre']."applogin"," channelid='".$channelid."' and  userid = '".$userid."'"); //删除设备历史记录
			$this->mysql->insert(Mysite::$app->config['tablepre'].'applogin',$Mdata);  //插入新数据
		}else{
			if($checkmid['userid'] != $userid){
				//     $this->mysql->delete(Mysite::$app->config['tablepre']."applogin"," uid='".$backinfo['uid']."'  "); //删除数据库用户
				//  $this->mysql->delete(Mysite::$app->config['tablepre']."applogin"," channelid='".$channelid."' and userid = '".$userid."' "); //删除历史相同设备ID
				$Mdata['channelid'] = $channelid;
				$Mdata['userid'] = $userid;
				$Mdata['uid']=$member['uid'];
				$Mdata['addtime'] = time();
				$this->mysql->update(Mysite::$app->config['tablepre'].'applogin',$Mdata,"uid='".$member['uid']."'");  
			}
		}
	 
	
	
	unset($member['password']);
	$member['ghtsmusic'] = Mysite::$app->config['ghtsmusic'];
	$this->success($member);
}
	/*** 2016.3.5 新增
	商家申请提现
	***/
	function shoptxadd(){
		//$uid,$cost,$shopid
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$uid = $backinfo['uid'];
		if($uid < 1){
			$this->message('nologin');
		}
		$cost = trim(IFilter::act(IReq::get('cost')));
		$shopinfo = $this->mysql->select_one(" select *  from ".Mysite::$app->config['tablepre']."shop where uid='".$uid."'  ");
		if(empty($shopinfo)){
			$this->message('未开启店铺');
		}
		$shopid = $shopinfo['id'];
		$userinfo = $backinfo; 
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
		$this->success($info); 
	}
	
	/***
	2016.3.5 新增
	商家资金记录***/
    function shopcostlog(){
			$backinfo = $this->checkapp();
			if(empty($backinfo['uid'])){
				$this->message('nologin');
			}
			$uid = $backinfo['uid'];
			if($uid < 1){
				$this->message('nologin');
			}
		 
		  $pageshow = new page();
	      $pageshow->setpage(IReq::get('page'),10); 
		  $where = " where shopuid=".$uid." ";
		  $type = intval(IReq::get('type'));// 0 表示提出        1表示充值   2表示取消提现  3结算转入
		  if($type == 1){
			  $where .=" and (type = 0 or cost < 0)";
		  }elseif($type == 2){
			  $where .=" and type > 0 and cost > 0";
		  } 
		  
		  $startday = trim(IReq::get('startday'));
		  $endday = trim(IReq::get('endday'));
		  if( empty($startday) && empty($endday) ){//不传时间时默认显示近七天的
			  $todaybegintime = strtotime(date('Y-m-d'));			  
			  $zhoutime = $todaybegintime - 86400*6;			 
			  $where .= " and addtime > ".$zhoutime;
		  }
		  if(!empty($startday)) $where .=" and addtime > ".strtotime($startday);
		  if(!empty($endday)){
			  $info = strtotime($endday)+86399;
			  $where .=" and addtime < ".$info;
		  } 
		   
	      $txlist =   $this->mysql->getarr("select *  from ".Mysite::$app->config['tablepre']."shoptx  ".$where."  order by addtime desc   limit ".$pageshow->startnum().", ".$pageshow->getsize().""); 
	      $shuliang  = $this->mysql->counts("select *  from ".Mysite::$app->config['tablepre']."shoptx    ".$where."   order by id asc  ");
	      #print_r( $txlist);
		  $tempdata = array();
		  $typearray = array(0=>'提现申请',1=>'账号充值',2=>'取消提现',3=>'店铺结算转入');
		  $statusarray = array(0=>'空',1=>'处理中',2=>'处理成功',3=>'已取消');
		  if(is_array($txlist)){
			  foreach($txlist as $key=>$value){
				  //$value['name'] = isset($typearray[$value['type']])?$typearray[$value['type']]:'未定义';
				  $value['statusname'] = isset($statusarray[$value['status']])?$statusarray[$value['status']]:'未定义';
				  $value['adddate'] = date('Y-m-d H:i:s',$value['addtime']);
				  if($value['cost'] < 0 || $value['jsid'] == 0 ){
					  $value['sztype'] = '支出'; 
				  }
				  if($value['cost'] >= 0 && $value['jsid'] > 0 ){
					  $value['sztype'] = '收入'; 
				  }
				  $tempdata[] = $value;
			  }
		  } 
		  $this->success($tempdata); 
	 }
	 //获取提现记录
	 function shoptxlog(){
			$backinfo = $this->checkapp();
			if(empty($backinfo['uid'])){
				$this->message('nologin');
			}
			$uid = $backinfo['uid'];
			if($uid < 1){
				$this->message('nologin');
			}
		 
		  $pageshow = new page();
	      $pageshow->setpage(IReq::get('page'),10); 
		   
	      $txlist =   $this->mysql->getarr("select *  from ".Mysite::$app->config['tablepre']."shoptx  where shopuid=".$uid."  and type = 0 order by addtime desc   limit ".$pageshow->startnum().", ".$pageshow->getsize().""); 
	      $shuliang  = $this->mysql->counts("select *  from ".Mysite::$app->config['tablepre']."shoptx  where shopuid=".$uid." and type = 0   order by id asc  ");
	     
		  $tempdata = array();
		  $typearray = array(0=>'提现申请',1=>'账号充值',2=>'取消提现',3=>'店铺结算转入');
		  $statusarray = array(0=>'空',1=>'处理中',2=>'处理成功',3=>'已取消');
		  if(is_array($txlist)){
			  foreach($txlist as $key=>$value){
				  //$value['name'] = isset($typearray[$value['type']])?$typearray[$value['type']]:'未定义';
				  $value['statusname'] = isset($statusarray[$value['status']])?$statusarray[$value['status']]:'未定义';
				  $value['adddate'] = date('Y-m-d H:i:s',$value['addtime']);
				  $tempdata[] = $value;
			  }
		  } 
		  $this->success($tempdata); 
	 }
	 /***
		2016.3.5 店铺取消提现
	 ***/
	 function shopuntx(){
		 $backinfo = $this->checkapp();
			if(empty($backinfo['uid'])){
				$this->message('nologin');
			}
			$uid = $backinfo['uid'];
			if($uid < 1){
				$this->message('nologin');
			}
		 $txid = trim(IFilter::act(IReq::get('txid')));
		 
		 $txinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shoptx where id='".$txid."'  ");
		 if(empty($txinfo)){
			$this->message('提现信息获取失败');
		 }
		 if($txinfo['status'] != 1){
			 $this->message('提现已受理不能取消');
		 }
		 if($txinfo['type'] != 0){
			 $this->message('不是店铺提现不能取消');
		 }
		 if($txinfo['shopuid'] != $uid){
			 $this->message('该条提现记录不属于您');
		 } 
		 $userinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$txinfo['shopuid']."'  ");
		 if(empty($userinfo)){
			 $this->message('用户不存在');
		 }
	     $this->mysql->update(Mysite::$app->config['tablepre'].'shoptx','`status`=3',"id ='".$txid."' ");
		 $this->mysql->update(Mysite::$app->config['tablepre'].'member','`shopcost`=`shopcost`+'.$txinfo['cost'],"uid ='".$txinfo['shopuid']."' ");
		  
		 $newdata['cost'] = $txinfo['cost'];
		 $newdata['type'] = 2;
		 $newdata['status'] = 2;
		 $newdata['addtime'] = time();
		 $newdata['shopid'] = 0;
         $newdata['shopuid'] =  $uid;
		 $newdata['name'] = '取消'.date('Y-m-d',$txinfo['addtime']).$txinfo['name'];
		 $newdata['yue'] = $userinfo['shopcost']+$txinfo['cost'];
		 $this->mysql->insert(Mysite::$app->config['tablepre'].'shoptx',$newdata);
		 $orderid = $this->mysql->insertid(); 
		 $info = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shoptx  where id = ".$orderid." ");
		 $this->success($info);
	 }
	 function tjcxcost(){
		 
		 //可提现金额
		 //总收入
		 //支付佣金
	    $backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		 $newdata['yj']=0.00;
		$newdata['shopcost'] = $backinfo['shopcost'];
		//shopjs
		//shopuid
		$info = $this->mysql->select_one("select sum(acountcost) as acountcost,sum(yjcost) as yjc from ".Mysite::$app->config['tablepre']."shopjs  where shopuid = ".$backinfo['uid']."  ");
		$info['yjc'] = empty($info['yjc'])?0:$info['yjc'];
		$newdata['zsr'] = empty($info['acountcost'])?0:$info['acountcost'];
		$newdata['yj'] = empty($info['yjc'])?0:$info['yjc']; 
		$this->success($newdata);
	 } 
	function getshoploginfo(){//8.7及以后  弃用该函数
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$uid = $backinfo['uid'];
		if($uid < 1){
			$this->message('nologin');
		}
		$txid = trim(IFilter::act(IReq::get('txid')));

		$txinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shoptx where id='".$txid."'  ");
		if(empty($txinfo)){
			$this->message('信息获取失败');
		}
		 $statusarray = array(0=>'空',1=>'处理中',2=>'处理成功',3=>'已取消');
		if($txinfo['jsid'] > 0){
			$info = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopjs where addtime='".$txinfo['addtime']."'  ");
		    $info['name'] = '结算'.date('Y-m-d',$info['jstime']);
			$info['adddate'] = date('Y-m-d H:i:s',$info['addtime']);
			 $info['statusname'] = isset($statusarray[$info['status']])?$statusarray[$info['status']]:'未定义';
			$this->success($info);
		}else{
			 $txinfo['statusname'] = isset($statusarray[$txinfo['status']])?$statusarray[$txinfo['status']]:'未定义';
			
		    $txinfo['adddate'] = date('Y-m-d H:i:s',$txinfo['addtime']);
			$this->success($txinfo); 
		} 
	 }
	 
	function shoptxdetail(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$uid = $backinfo['uid'];
		if($uid < 1){
			$this->message('nologin');
		}
		$txid = trim(IFilter::act(IReq::get('txid')));

		$txinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shoptx where id='".$txid."'  ");
		 
		if(empty($txinfo)){
			$this->message('信息获取失败');
		}
		 $statusarray = array(0=>'空',1=>'处理中',2=>'处理成功',3=>'已取消');
		if($txinfo['jsid'] > 0){
			//订单结算
			$jsinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopjs where addtime='".$txinfo['addtime']."'  ");
		    $orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where id='".$jsinfo['orderid']."'  ");
			$payarr = array(
				'open_acout'=>'余额支付',
				'weixin'=>'微信支付',
				'alipay'=>'支付宝',
				'alimobile'=>'手机支付宝'		
			);
			$paytype = empty($orderinfo['paytype_name'])?'未定义':$payarr[$orderinfo['paytype_name']];				 					 
			if($orderinfo['paytype'] == 0){
				$paytype = '货到付款';
			}
			if($jsinfo['acountcost'] > 0){
				$info[] = array('name'=>'账户收入','content'=>number_format($jsinfo['acountcost'],2));
				$info[] = array('name'=>'收入类型','content'=>'订单收入');
			}else{
				$info[] = array('name'=>'账户支出','content'=>number_format($jsinfo['acountcost'],2));
				$info[] = array('name'=>'支出类型','content'=>'订单佣金');
			}
			
			$info[] = array('name'=>'订单编号','content'=>$orderinfo['dno']);
			$info[] = array('name'=>'订单金额','content'=>$orderinfo['allcost']);
			$info[] = array('name'=>'支付平台佣金','content'=>$jsinfo['yjcost']);
			$info[] = array('name'=>'订单支付方式','content'=>$paytype);
			if($jsinfo['acountcost'] > 0){
				$info[] = array('name'=>'当前状态','content'=>'已转入余额');
			}else{
				$info[] = array('name'=>'当前状态','content'=>'已转出余额');
			}
			$info[] = array('name'=>'创建时间','content'=>date('Y-m-d H:i:s',$jsinfo['addtime']));
			$this->success($info);
		}else{
			//店铺提现
			$userinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$txinfo['shopuid']."'  ");			 
			$ctxinfo[] = array('name'=>'账户支出','content'=>$txinfo['cost']);
			$ctxinfo[] = array('name'=>'支出类型','content'=>'余额提现');
			$ctxinfo[] = array('name'=>'申请时间','content'=>date('Y-m-d H:i:s',$txinfo['addtime']));
			$ctxinfo[] = array('name'=>'收款账户','content'=>empty($userinfo['backacount'])?'暂未提供':$userinfo['backacount']);
			$ctxinfo[] = array('name'=>'收款人','content'=>$userinfo['username']);
			$ctxinfo[] = array('name'=>'当前状态','content'=> isset($statusarray[$txinfo['status']])?$statusarray[$txinfo['status']]:'未定义');
			$ctxinfo[] = array('name'=>'创建时间','content'=> date('Y-m-d H:i:s',$txinfo['addtime']));			 
			$this->success($ctxinfo); 
		} 
	 }
	
	

	function checkreg(){
		$this->success('成功');
	}
	/*
	*   检测普通用户登录
	*/
	function checkappMem(){
		$uid = trim(IFilter::act(IReq::get('uid')));
		$pwd = trim(IFilter::act(IReq::get('pwd')));
		$mapname = trim(IFilter::act(IReq::get('mapname')));

		$checklogintype = $_COOKIE['app_login'];
			
	    $logintype = trim(IFilter::act(IReq::get('logintype')));
		$phone = trim(IFilter::act(IReq::get('phone')));
			
		$uid = empty($uid)?ICookie::get('appuid'):$uid;
		$pwd = empty($pwd)?ICookie::get('apppwd'):$pwd;
		
		if($checklogintype == 'applogin'||$logintype=='phone'){
			 $checkphone = $_COOKIE['app_loginphone'];
			 if(empty($checkphone)){
				 $checkphone = $phone;
			 }
			 $member= $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where phone='".$checkphone."' ");
			 $backarr = array('uid'=>0,'sitephone'=>Mysite::$app->config['litel']);
			 if(!empty($member)){
				$backarr = $member;
				$backarr['sitephone'] = Mysite::$app->config['litel'];
			 }
		}else{ 
			 $member= $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$uid."' ");
			
			  $backarr = array('uid'=>0,'sitephone'=>Mysite::$app->config['litel']);
			 if(!empty($member)){
				if($member['password'] == md5($pwd)){
					$backarr = $member;
					$backarr['sitephone'] = Mysite::$app->config['litel'];
					ICookie::set('appuid',$member['uid'],86400);
					ICookie::set('apppwd',$pwd,86400); 
					ICookie::set('appmapname',$mapname,86400);
					
					ICookie::set('email',$member['email'],86400);
					ICookie::set('memberpwd',$pwd,86400);
					ICookie::set('membername',$member['username'],86400);
					ICookie::set('uid',$member['uid'],86400); 
				}

			} 
		}
		return $backarr;
	}
	function gettest(){
		print_r($_COOKIE);
		$uid = ICookie::get('uid');
		$this->message($uid);
	}
	/*
	* 普通用户注册
	*/
	function reg(){
		$tname = IFilter::act(IReq::get('tname'));
		$password = IFilter::act(IReq::get('pwd'));
		$phone = IFilter::act(IReq::get('phone'));
		$password2 = IFilter::act(IReq::get('pwd2'));
		$email = IFilter::act(IReq::get('email'));
		$code = IFilter::act(IReq::get('code'));
		if($password2 != $password){
			$this->message('2次密码不一致');
		}
		if(strlen($tname) < 5 || strlen($tname) > 24){
			$this->message('账号长度应在5到24个字符之间');
		}
		
		
		$phonecls = new phonecode($this->mysql,0,$phone); 
		if($phonecls->checkcode($code)){  
				if($this->memberCls->regester($email,$tname,$password,$phone,5)){
					$this->memberCls->login($tname,$password);
					$uid = $this->memberCls->getuid();
					$member= $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$uid."' ");
					unset($member['password']); 
					
					$tjyhj = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."juan where uid='".$uid."' and status < 2 and  endtime > ".time()." ");
					$member['logo'] = empty($member['logo'])?Mysite::$app->config['siteurl'].Mysite::$app->config['userlogo']:Mysite::$app->config['siteurl'].$member['logo'];
					$member['juancount'] = $tjyhj;
					
					$channelid = trim(IFilter::act(IReq::get('channelid')));
					$userid = trim(IFilter::act(IReq::get('userid')));
					if(!empty($channelid) && !empty($userid)){
						$checkmid =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."appbuyerlogin where uid='".$uid."' ");
						if(empty($checkmid)){
							$Mdata['channelid'] = $channelid;
							$Mdata['userid'] = $userid;
							$Mdata['uid']=$uid;
							$Mdata['addtime'] = time(); 
							$this->mysql->insert(Mysite::$app->config['tablepre'].'appbuyerlogin',$Mdata);  //插入新数据
						}else{
							if($checkmid['channelid'] != $channelid ||  $checkmid['userid'] != $userid){ 
								$Mdata['channelid'] = $channelid;
								$Mdata['userid'] = $userid;
								$Mdata['uid']=$uid;
								$Mdata['addtime'] = time();
								$this->mysql->update(Mysite::$app->config['tablepre'].'appbuyerlogin',$Mdata,"uid='".$backinfo['uid']."'"); 
							}
						}
					} 
					$this->success($member);
				}else{
					$this->message($this->memberCls->ero());
				}
		}else{
			$this->message($phonecls->getError());
		} 

	}
	
	
	
	
	function appuserinfo(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		unset($backinfo['password']);
	    $tjyhj = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."juan where uid='".$backinfo['uid']."' and status < 2 and  endtime > ".time()." "); 
		$backinfo['logo'] = empty($backinfo['logo'])?Mysite::$app->config['siteurl'].Mysite::$app->config['userlogo']:Mysite::$app->config['siteurl'].$backinfo['logo'];
		$backinfo['juancount'] = $tjyhj;
		$this->success($backinfo);
	}
	
	function findpwd(){
		$phone =  trim(IFilter::act(IReq::get('phone'))); 
		$newpwd =  trim(IFilter::act(IReq::get('newpwd')));
		$surepwd = trim(IFilter::act(IReq::get('surepwd'))); 
		$code =  trim(IFilter::act(IReq::get('code')));  
	    $member= $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where phone='".$phone."' ");
  	    if(empty($member)){
			$this->message('用户不存在');
		}
		// if(!empty($member['temp_password'])){
			// $this->message('快捷登录用户不需找回密码');
		// }
		// if($code != $yanzhengcode){
			// $this->message('验证失败');
		// }
		if(empty($newpwd)){
			$this->message('新密码不能为空');
		}
		if($newpwd != $surepwd){
			$this->message('新密码和确认密码不一致');
		} 
		$phonecls = new phonecode($this->mysql,2,$phone); 
		if($phonecls->checkcode($code)){
			$newdata['password'] = md5($newpwd);
			$newdata['temp_password'] = '';
			$this->mysql->update(Mysite::$app->config['tablepre'].'member',$newdata,"uid='".$member['uid']."'");
		}else{
			$this->message($phonecls->getError());
		}
		$this->success('success');
	}

    function strlength($str){
        $strlen=0;
        for($i=0;$i<strlen($str);$i++){
            if(ord(substr($str,$i,1))>0xa0){
                $strlen+=0.5;
            }else{
                $strlen+=1;
            }
        }
        return $strlen;
    }
    function fastloginmodifyname(){//快速登录修改用户名
        $backinfo = $this->checkappMem();
        if(empty($backinfo['uid'])){
            $this->message('nologin');
        }
        if($backinfo['md_flag'] == 1){
            $this->message('快捷登录用户仅能修改一次用户名');
        }
        $data['username'] =  trim(IFilter::act(IReq::get('username')));
        $namelength = $this->strlength($data['username']);
        if($namelength < 5) $this->message('用户名不能小于5个字符');
        if($namelength > 24) $this->message('用户名不能大于24个字符');
        if(empty($data['username'])) $this->message('新用户名为空');

        $checkmid =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where username='".$data['username']."' ");
        if(!empty($checkmid)) $this->message('用户名已存在');
        $data['md_flag'] = 1;
        $this->mysql->update(Mysite::$app->config['tablepre'].'member',$data,"uid='".$backinfo['uid']."'");

        $this->success('success');
    }
	
	//3
	
	
	
	
	/*
	* 获取店铺列表
	暂无判断  坐标所在店铺
	*/
	function shop(){
		$lat = IFilter::act(IReq::get('lat'));
		$lng = IFilter::act(IReq::get('lng'));
		$showtype = IFilter::act(IReq::get('showtype'));
		$backtype = IFilter::act(IReq::get('backtype'));
		$orderby = in_array($showtype,array('juli','cost','is_com'))?$showtype:'juli';
		$checklat = intval($lat);
		$checklng = intval($lng);
		$lat = empty($checklat)?0:$lat;
		$lng = empty($checklng)?0:$lng;
		$orderarray = array(
			'juli'=>' order by  SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) asc ',
			'cost'=>' order by a.limitcost asc ',
			'is_com'=>' order by a.is_com asc '
		);
		$areaid = intval(IFilter::act(IReq::get('areaid')));

		$where = ' where endtime > '.time().' and  SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < `pradius`*0.01094 ';
		if(!empty($areaid)){
			$where = " where b.id in(select shopid from ".Mysite::$app->config['tablepre']."areashop where areaid = ".$areaid." ) ";
			$orderarray = array(
				'juli'=>' order by id asc ',
				'cost'=>' order by a.limitcost asc ',
				'is_com'=>' order by a.is_com asc '
			);
		}else{ 
			if(empty($lat)){
				$this->success(array());
			}
		}
		$where = '';
		$where = $showtype == 'is_com'? $where.' and a.is_com = 1 ':$where;
	

		// print_r($where);

		$this->pageCls->setpage(intval(IReq::get('page')),20);
		$list = $this->mysql->getarr("select a.shopid,b.id,b.shopname,b.is_open,b.starttime,b.pointcount as sellcount,lat,lng,a.is_orderbefore,a.limitcost,b.shoplogo,a.personcost,a.is_hot,a.is_com,a.is_new,a.maketime,a.pradius,b.lat,b.lng,a.sendtype,a.pscost,a.arrivetime from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id ".$where."   ".$orderarray[$orderby]."   limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."");
		$shopdata = array();
		$nowhour = date('H:i:s',time());
		$nowhour = strtotime($nowhour);
		foreach($list as $key=>$value){
			$value['juli'] =  $this->GetDistance($lat, $lng, $value['lat'], $value['lng']).'米';//'未测距';
			$value['opentype'] = '1';//1营业  0未营业
			$imgurl = empty($value['shoplogo'])? Mysite::$app->config['shoplogo']:$value['shoplogo'];
			$checkinfo = $this->shopIsopen($value['is_open'],$value['starttime'],$value['is_orderbefore'],$nowhour);

			if($checkinfo['opentype'] != 2 && $checkinfo['opentype'] != 3){
				$value['opentype'] = '0';
			}
			if($backtype > 0){
				if($checkinfo['opentype'] != 2 && $checkinfo['opentype'] != 3){
					$value['opentype'] = '0';
				}else{
					$value['opentype'] = $checkinfo['opentype'];
				}
				$checkstr =  $value['starttime'];
				$tempstr = array();
				if(!empty($checkstr)){
					$tempstr = explode('-',$checkstr);
				}
				$value['starttime'] = count($tempstr) > 0 ? $tempstr[0]:'';
			}
			//$items['opentype'] != 2 && $items['opentype'] != 3

			$value['shopimg'] = Mysite::$app->config['siteurl'].$imgurl;
			unset($value['sendset']);
			$shopdata[] = $value;
		}
		$this->success($shopdata);
	}
	function appbuyorder(){
		$statusarr = array('0'=>'新订单','1'=>'待发货','2'=>'待评价','3'=>'已完成','4'=>'关闭','5'=>'关闭');
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		//
		$gettype = trim(IFilter::act(IReq::get('gettype')));
		$gettype = !in_array($gettype,array('wait','waitsend','is_send')) ?'wait':$gettype;
		$newwherearray =array(
			'wait'=> ' status > 0 and status < 2 and is_make = 0',
			'waitsend'=>' status = 1 and is_make = 1',
			'is_send'=>' status > 1 '
		); 
		$todatay = strtotime(date('Y-m-d',time()));
		$todatay = $todatay - 604800;//最近一周订单

		$orderlist =  $this->mysql->getarr("select id,addtime,posttime,dno,allcost,status,is_make,daycode,shopname,is_ping from ".Mysite::$app->config['tablepre']."order where buyeruid = ".$backinfo['uid']."   and addtime > ".$todatay." order by id desc  "); //and ".$newwherearray[$gettype]."
		$backdatalist = array();
		foreach($orderlist as $key=>$value){
			$value['showstatus'] = $statusarr[$value['status']];
			$value['addtime'] = date('Y-m-d H:i:s',$value['addtime']);
			if($value['status'] ==  1){
				if($value['is_make'] == 0){
					$value['showstatus'] = '等待审核';
				}elseif($value['is_make'] ==2){
					$value['showstatus'] = '无效订单';
					$value['status'] = 4;

				}
			}elseif($value['status'] == 3){
				if(empty($value['is_ping'])){
					$value['showstatus'] ='待评价';
				}

			}

			$backdatalist[] = $value;
		}
		$this->success($backdatalist);
	}

	function shopshow(){
		$id = intval(IFilter::act(IReq::get('id')));
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where id='".$id."' ");   //店铺基本信息
	 	if(empty($shopinfo)){
	 	 	//需要进行跳转
			echo '店铺获取失败';
			exit;
		}
		$shopdet = array();
		if(empty($shopinfo['shoptype'])){
			$shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast where shopid='".$id."' ");
		}elseif($shopinfo['shoptype'] == 1){
			$shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket where shopid='".$id."' ");
		}
		$nowhour = date('H:i:s',time());
		$data['openinfo'] = $this->shopIsopen($shopinfo['is_open'],$shopinfo['starttime'],$shopdet['is_orderbefore'],$nowhour);
		$data['shopinfo'] = $shopinfo;
		$data['shopdet'] = $shopdet;
		$templist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodstype where shopid='".$id."' ");
		$data['goodstype'] = array();
		foreach($templist as $key=>$value){
	 	 	$value['det'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goods where shopid='".$id."' and typeid =".$value['id']." order by good_order asc ");
			$data['goodstype'][]  = $value;
		}
		$shopdet['id'] = $id;
		$shopdet['shoptype']=1;
		
		$this->platpsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$shopinfo['admin_id']."' "); 
		$lat = IFilter::act(IReq::get('lat'));
		$lng = IFilter::act(IReq::get('lng'));
		$tempinfo =   $this->pscost($shopdet,$lng,$lat);
		$backdata['pstype'] = $tempinfo['pstype'];
		$backdata['pscost'] = $tempinfo['pscost'];
		$data['psinfo'] = $backdata;
		$data['mainattr'] = array();
		$templist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where  cattype = ".$shopinfo['shoptype']." and parent_id = 0 and is_main =1  order by orderid asc limit 0,1000");
		foreach($templist as $key=>$value){
			$value['det'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where parent_id = ".$value['id']." order by orderid asc  limit 0,20");
			$data['mainattr'][] = $value;
		}
		$data['shopattr'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopattr  where  cattype = ".$shopinfo['shoptype']." and shopid = '".$shopinfo['id']."'  order by firstattr asc limit 0,1000");
		$data['cxinfo'] = array();
		$sellrule =new sellrule();
		$sellrule->setdata($id,10000,$shopinfo['shoptype']);
		$ruleinfo = $sellrule->getdata();
		if(isset($ruleinfo['gzdata'])){
			$data['cxinfo'] = $ruleinfo['gzdata'];
		}
		Mysite::$app->setdata($data);
	}
	function cart(){
		$Cart = new smCart;
		$carinfo = $Cart->getMyCart();
		$shopid = intval(IReq::get('shopid'));
		$backdata = array();
		if($shopid  > 0){
			if(isset($carinfo['list'][$shopid]['data'])){
				$backdata['list'] = $carinfo['list'][$shopid]['data'];
				$backdata['sumcount'] =$carinfo['list'][$shopid]['count'];
				$backdata['sum'] =$carinfo['list'][$shopid]['sum'];
				$backdata['bagcost'] =$carinfo['list'][$shopid]['bagcost'];
				$cxclass = new sellrule();
				if($carinfo['list'][$shopid]['shopinfo']['shoptype'] ==1){
					$shopcheckinfo =   $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id where a.shopid = '".$shopid."'    ");
				}else{
					$shopcheckinfo =   $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id where a.shopid = '".$shopid."'    ");
				}
				$cxclass->setdata($shopid,$backdata['sum'],$carinfo['list'][$shopid]['shopinfo']['shoptype']);
				$cxinfo = $cxclass->getdata();
				$backdata['surecost'] = $cxinfo['surecost'];
				$backdata['downcost'] = $cxinfo['downcost'];
				$backdata['gzdata'] = isset($cxinfo['gzdata'])?$cxinfo['gzdata']:array();
				
				$this->platpsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$shopcheckinfo['admin_id']."' "); 
				$lat = IFilter::act(IReq::get('lat'));
				$lng = IFilter::act(IReq::get('lng'));

				$tempinfo =   $this->pscost($shopcheckinfo,$lng,$lat);
				$backdata['pstype'] = $tempinfo['pstype'];
				$backdata['pscost'] = $cxinfo['nops'] == true?0:$tempinfo['pscost'];
				$backdata['canps'] = $tempinfo['canps'];
				$source =  intval(IFilter::act(IReq::get('source')));
				$ios_waiting =   Mysite::$app->config['ios_waiting'];
				if($source == 1 && $ios_waiting == true){
					$backdata['canps'] = 1;
				}
			}else{
				$this->message(array());
				//  $this->hjson(array('error'=>true,'data'=>array()));
			}

		}else{
			$this->message(array());//$backdata = $carinfo;
		}
		$this->success($backdata);
	}
	function shopcart(){//购物车
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$id = IFilter::act(IReq::get('id'));
		$data['scoretocost'] = Mysite::$app->config['scoretocost'];
		//	id	card 优惠劵卡号	card_password 优惠劵密码	status 状态，0未使用，1已绑定，2已使用，3无效	creattime 制造时间	cost 优惠金额	limitcost 购物车限制金额下限	endtime 失效时间	uid 用户ID	username 用户名	usetime 使用时间	name
		$data['juanlist'] =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."juan  where uid='".$backinfo['uid']."' and endtime > ".time()." and status = 1   "); 
		$shopinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where shopid = ".$id."   ");
		if(empty($shopinfo)){
			$shopinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where shopid = ".$id."   ");
		}
		$nowtime = time();
		$timelist = array();
		$info = explode('|',$shopinfo['starttime']);
		$info = is_array($info)?$info:array($info);
		$data['is_open'] = 0;
		$dototime = time()+$shopinfo['maketime']*60;
		foreach($info as $key=>$value){
			if(!empty($value)){
				$temptime = explode('-',$value);
				if(count($temptime) == 2){ //开始转换

					$btime = strtotime($temptime[0].':00');
					$etime = strtotime($temptime[1].':00');
					$whtime = $btime;
		     	  	while ($whtime < $etime){
						if($whtime < $etime && $whtime >= $nowtime && $whtime > $dototime ){
							$timelist[] = date('H:i',$whtime);
							$data['is_open'] = 1;
						}
						$whtime +=900;
					}

				}
			}
		}
		if($shopinfo['is_open'] == 0  || $shopinfo['is_pass'] == 0){
			$data['is_open'] = 0;
		}
		$data['timelist'] =$timelist;
		$data['deaddress'] =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."address  where userid = ".$backinfo['uid']." and `default`=1   ");
		$data['appmapname'] = ICookie::get('appmapname');


		$data['domember'] = $backinfo;
		Mysite::$app->setdata($data);
	}
	function makeorder(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}


		
		
		$info['shopid'] = intval(IReq::get('shopid'));//店铺ID
		$info['remark'] = IFilter::act(IReq::get('remark'));//备注
		$info['paytype'] =  intval(IFilter::act(IReq::get('payline')));//支付方式
		$info['dikou'] =  intval(IReq::get('dikou'));//抵扣金额
		$info['username'] = IFilter::act(IReq::get('username'));
		$info['mobile'] = IFilter::act(IReq::get('mobile'));
		$info['addressdet'] = IFilter::act(IReq::get('addressdet'));
		$info['senddate'] = date('Y-m-d',time());// IFilter::act(IReq::get('senddate'));
		$info['minit'] = IFilter::act(IReq::get('minit'));
		$info['juanid']  =  intval(IReq::get('juanid'));//优惠劵ID
		$info['ordertype'] = 4;//订单类型
		$peopleNum = IFilter::act(IReq::get('peopleNum'));
		$info['othercontent'] ='';//empty($peopleNum)?'':serialize(array('人数'=>$peopleNum));

		if(empty($info['shopid'])) $this->message('店铺ID错误');
		$Cart = new smCart;
		$carinfo = $Cart->getMyCart();
		if(!isset($carinfo['list'][$info['shopid']]['data'])) $this->message('对应店铺购物车商品为空');
		if($carinfo['list'][$info['shopid']]['shopinfo']['shoptype'] == 1){
			$shopinfo=   $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id where a.shopid = '".$info['shopid']."'    ");
		}else{
			$shopinfo=   $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id where a.shopid = '".$info['shopid']."'    ");
		}
		if(empty($shopinfo))   $this->message('店铺获取失败');
		$lng = IFilter::act(IReq::get('lng'));
		$lat = IFilter::act(IReq::get('lat'));
		$this->platpsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$shopinfo['admin_id']."' "); 
		$checkps = 	 $this->pscost($shopinfo,$lng,$lat);
		if($checkps['canps'] != 1) $this->message('该店铺不在配送范围内');
		$source =  intval(IFilter::act(IReq::get('source')));
		$ios_waiting =   Mysite::$app->config['ios_waiting'];
		if($source == 1 && $ios_waiting == true){
			$checkps['canps']  = 1;
			$checkps['pscost']  = $shopinfo['pscost'];
		}
		
		if($source == 1){
			$info['ordertype'] = 6;
		}
		$info['cattype'] = 0;//
		if(empty($info['username'])) 		  $this->message('联系人不能为空');
	  	if(!IValidate::suremobi($info['mobile']))   $this->message('请输入正确的手机号');
		if(empty($info['addressdet'])) $this->message('详细地址为空');

		$info['userid'] = !isset($backinfo['score'])?'0':$backinfo['uid'];
		$info['ipaddress'] = '';
		$ip_l=new iplocation();
		$ipaddress=$ip_l->getaddress($ip_l->getIP());
		if(isset($ipaddress["area1"])){
			#$info['ipaddress']  = $ipaddress['ip'].mb_convert_encoding($ipaddress["area1"],'UTF-8','GB2312');//('GB2312','ansi',);
			$info['ipaddress']  = $ipaddress['ip'] ;
		}
		//area1 二级地址名称	area2 三级地址名称	area3
		$info['areaids'] = '';
		$paytype = $info['paytype'];
		 

	    $senddate = $info['senddate'];
		$minit = $info['minit'];
		$nowpost = strtotime($senddate.' '.$minit.':00'); 
		$settime = time() - (10*60);
		if($settime > $nowpost)  $this->message('提交配送时间和服务器时间相差超过10分钟下单失败');
		$temp = strtotime($minit.':00');
		$is_orderbefore = $shopinfo['is_orderbefore'] == 0?0:$shopinfo['befortime'];
		$tempinfo = $this->checkshopopentime($is_orderbefore,$nowpost,$shopinfo['starttime']);
		if(!$tempinfo) $this->message('配送时间不在有效配送时间范围');
		if($shopinfo['is_open'] != 1) $this->message('店铺暂停营业');
		$info['sendtime'] = $nowpost; 
		$info['shopinfo'] = $shopinfo;
		$info['allcost'] = $carinfo['list'][$info['shopid']]['sum'];
		$info['bagcost'] = $carinfo['list'][$info['shopid']]['bagcost'];
		$info['allcount'] = $carinfo['list'][$info['shopid']]['count'];
		$info['shopps'] = $checkps['pscost'];
		$info['goodslist']   = $carinfo['list'][$info['shopid']]['data'];
		$info['pstype'] = $checkps['pstype'];
		$info['cattype'] = 0;//表示不是预订
		$info['is_goshop']=0;
	    if($shopinfo['limitcost'] > $info['allcost']) $this->message('商品总价低于最小起送价'.$shopinfo['limitcost']);
		$orderclass = new orderclass();
		$orderclass->makenormal($info);
		$orderid = $orderclass->getorder();
		if($info['userid'] ==  0){
	  	   ICookie::set('orderid',$orderid,86400);
		}

		$Cart->delshop($info['shopid']);
		$this->success($orderid);
		exit;
	}
	public static function checkshopopentime($is_orderbefore,$posttime,$starttime){
		$maxnowdaytime = strtotime(date('Y-m-d',time()));
		$daynottime = 24*60*60 -1;
		$findpostime = false;
		for($i=0;$i <= $is_orderbefore;$i++){
			if($findpostime == false){
				$miniday = $maxnowdaytime+$daynottime*$i;
				$maxday = $miniday+$daynottime;
				$tempinfo = explode('|',$starttime);
				foreach($tempinfo as $key=>$value){
					if(!empty($value)){
						$temp2 = explode('-',$value);
						if(count($temp2) > 1){
							$minbijiaotime = date('Y-m-d',$miniday);
							$minbijiaotime = strtotime($minbijiaotime.' '.$temp2[0].':00');

							$maxbijiaotime = date('Y-m-d',$maxday);
							$maxbijiaotime = strtotime($maxbijiaotime.' '.$temp2[1].':00');

							if($posttime > $minbijiaotime && $posttime < $maxbijiaotime){
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
	function showorder(){
		$orderid = intval(IFilter::act(IReq::get('orderid')));
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}else{
			if($backinfo['uid'] == 0){
				ICookie::set('email',$backinfo['email'],86400);
				ICookie::set('memberpwd',ICookie::get('apppwd'),86400);
				ICookie::set('membername',$backinfo['username'],86400);
				ICookie::set('uid',$backinfo['uid'],86400);
			}
		}
			//order="++"&uid="+account+"&pwd="+password+"&mapname="+m.getMapname()+"&lat="+m.getLat()+"&lng="+m.getLng()
		if(!empty($orderid)){

	     	$order = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where buyeruid='".$backinfo['uid']."' and id = ".$orderid."");

	     	if(empty($order)){
	     		$data['order'] = '';
	     		Mysite::$app->setdata($data);
	     	}else{
				$order['ps'] = $order['shopps'];
	     	     // 超市商品总价	 超市配送配送	shopcost 店铺商品总价	shopps 店铺配送费	pstype 配送方式 0：平台1：个人	bagcost
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
				$paytypelist = array('outpay'=>'货到支付','open_acout'=>'账号余额支付');
				$paylist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."paylist   order by id asc limit 0,50");
				if(is_array($paylist)){
					foreach($paylist as $key=>$value){
						$paytypelist[$value['loginname']] = $value['logindesc'];
					}
	            }
				$paytypearr = $paytypelist;
				$order['surestatus'] = $order['status'];
				$order['status'] = $buyerstatus[$order['status']];
				$order['paytype'] = $paytypearr[$order['paytype']];
				$order['paystatus'] = $order['paystatus']==1?'已支付':'未支付';
				$order['addtime'] = date('Y-m-d H:i:s',$order['addtime']);
				$order['posttime'] = date('Y-m-d H:i:s',$order['posttime']);
				$data['order'] = $order;
				$data['orderdet'] = $orderdet;

				Mysite::$app->setdata($data);

			}
		}else{
			$data['order'] = '';
			Mysite::$app->setdata($data);
		}
	}
	function commentorder(){ 
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}else{
			if($backinfo['uid'] == 0){
				ICookie::set('email',$backinfo['email'],86400);
				ICookie::set('memberpwd',ICookie::get('apppwd'),86400);
				ICookie::set('membername',$backinfo['username'],86400);
				ICookie::set('uid',$backinfo['uid'],86400);
			}
		} 
	    $orderid = intval(IReq::get('orderid'));
	    if(!empty($orderid)){
			$order = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where buyeruid='".$backinfo['uid']."' and id = ".$orderid."");

	     	if(empty($order)){
	     		$data['order'] = '';
	     		Mysite::$app->setdata($data);
	     	}else{
				$data['order'] =$order;
				$orderdet = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$order['id']."'");
				$data['orderdet'] = $orderdet;
				$tempcoment = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."comment where orderid='".$order['id']."'");
				$data['comment'] = array();
				foreach($tempcoment as $key=>$value){
					$data['comment'][$value['orderdetid']] = $value;
				}
				//  id		orderdetid	shopid	goodsid	uid	content	addtime	replycontent	replytime	 评分	is_show 0展示，1不展示
				Mysite::$app->setdata($data);

			}
	    }else{
			$data['order'] = '';
			Mysite::$app->setdata($data);
	    } 
	}
	function address(){
		//
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}else{
			if($backinfo['uid'] == 0){
				ICookie::set('email',$backinfo['email'],86400);
				ICookie::set('memberpwd',ICookie::get('apppwd'),86400);
				ICookie::set('membername',$backinfo['username'],86400);
				ICookie::set('uid',$backinfo['uid'],86400);
			}
		}
		$tarelist = $this->mysql->getarr("select *  from ".Mysite::$app->config['tablepre']."address where userid='".$backinfo['uid']."'   order by id asc limit 0,50");
		$arelist = array();
		$data['arealist'] = $tarelist;
		$data['areaarr'] = $arelist;
		Mysite::$app->setdata($data);

	}
	function giftlog(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}else{
			if($backinfo['uid'] == 0){
				ICookie::set('email',$backinfo['email'],86400);
				ICookie::set('memberpwd',ICookie::get('apppwd'),86400);
				ICookie::set('membername',$backinfo['username'],86400);
				ICookie::set('uid',$backinfo['uid'],86400);
			}
		}
		echo '获取礼品记录';
		exit;
	}
	function gift(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		echo '获取所有礼品';
		exit;
	}
	function juan(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$wjuan = array('shuliang'=>0,'list'=>array());
		$ujuan = array('shuliang'=>0,'list'=>array());
		$ojuan = array('shuliang'=>0,'list'=>array());
		$nowtime = time();
		$wjuan['shuliang'] =  $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."juan    where uid = ".$backinfo['uid']." and endtime > ".$nowtime." and status = 1 ");
		$wjuan['list'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."juan where uid = ".$backinfo['uid']." and endtime > ".$nowtime." and status = 1 ");
		$ujuan['shuliang'] =  $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."juan    where uid = ".$backinfo['uid']."  and status = 2 ");
		$ujuan['list'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."juan where uid = ".$backinfo['uid']."   and status = 2 ");

		$ojuan['shuliang'] =  $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."juan    where uid = ".$backinfo['uid']." and endtime < ".$nowtime." and (status = 1 or status =3)");
		$ojuan['list'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."juan where uid = ".$backinfo['uid']." and endtime < ".$nowtime." and (status = 1 or status =3)  ");

		$data['wjuan'] = $wjuan;
		$data['ujuan'] = $ujuan;
		$data['ojuan'] = $ojuan;
		Mysite::$app->setdata($data);
	}
	/**
	 *  @brief 保存通道号
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function appbuybaidu(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$channelid = trim(IFilter::act(IReq::get('channelid')));
		$userid = trim(IFilter::act(IReq::get('userid')));
		if(empty($userid)) $this->message('获取失败'); 
		$checkmid =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."appbuyerlogin where uid='".$backinfo['uid']."' ");
  		if(empty($checkmid)){ 
  		    $Mdata['channelid'] = $channelid;
  		    $Mdata['userid'] = $userid;
	        $Mdata['uid']=$backinfo['uid'];
	        $Mdata['addtime'] = time(); 
            $this->mysql->insert(Mysite::$app->config['tablepre'].'appbuyerlogin',$Mdata);  //插入新数据
  		}else{  
			if($checkmid['userid'] != $userid){ 
	           $Mdata['channelid'] = $channelid;
  		       $Mdata['userid'] = $userid;
	           $Mdata['uid']=$backinfo['uid'];
	           $Mdata['addtime'] = time();
			   $this->mysql->update(Mysite::$app->config['tablepre'].'appbuyerlogin',$Mdata,"uid='".$backinfo['uid']."'");  
  			} 
  		} 
		$this->success('操作成功'); 
	}
	function dologin(){
  	 $this->memberCls->login($tname,$password);

	}
	/**
	 *  @brief 买家获取单个订单
	 *  
	 *  @return 
	 *  
	 *  @details Details
	 */
	function appbuyerone(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$statusarr = array('0'=>'取消订单','1'=>'待发货','2'=>'待完成','3'=>'已完成','4'=>'关闭','5'=>'关闭');
		$paytypelist = array('outpay'=>'货到支付','open_acout'=>'账号余额支付');
		$shoptypearr = array(
			'0'=>'外卖',
			'1'=>'超市',
			'2'=>'其他',
	     );
		$paylist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."paylist   order by id asc limit 0,50");
		if(is_array($paylist)){
			foreach($paylist as $key=>$value){
		   	    $paytypelist[$value['loginname']] = $value['logindesc'];
			}
		}
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$orderid = trim(IFilter::act(IReq::get('orderid')));
		if(empty($orderid)){
			$this->message('订单不存在或者不属于您');
		}
		$order= $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where id='".$orderid."' "); //cxids 促销规则ID集	cxcost  yhjcost  bagcost
		if(empty($order)){
			$this->message('订单不存在');
		}
		if($order['buyeruid'] != $backinfo['uid']) $this->message('您不是订单所有者');

		$backdata['dno'] = $order['dno'];
		$backdata['addtime'] = date('Y-m-d H:i:s',$order['addtime']);
		$backdata['id'] = $order['id'];
		$backdata['allcost'] = $order['allcost'];
		$backdata['shopcost'] = $order['shopcost'];
		$backdata['shopname'] = $order['shopname']; 
		$backdata['showstatus'] = $statusarr[$order['status']];
		if($order['status'] ==  1){
			if($order['is_make'] == 0){
				$backdata['showstatus'] = '取消订单';
			}elseif($order['is_make'] ==2){
				$backdata['showstatus'] = '无效订单';
				$backdata['status'] = 4; 
			}
		}elseif($order['status'] == 3){
			if(empty($order['is_ping'])){
				$backdata['showstatus'] ='待评价';
			}
		}
		$backdata['is_ping'] = $order['is_ping'];
		$backdata['is_make'] = $order['is_make'];
		$backdata['status'] = $order['status'];
		$temlist = array();
		$dotem =   empty($order['paystatus'])?'未支付':'已支付';
		$templist[]['mytext'] = '订单编号：'.$order['dno'];
		$templist[]['mytext'] = '买家地址：'.$order['buyeraddress'];
		$templist[]['mytext'] = '联系电话：'.$order['buyerphone'];
		$templist[]['mytext'] = '配送时间：'.date('Y-m-d H:i:s',$order['posttime']);
		$templist[]['mytext'] = '支付类型：'.$paytypelist[$order['paytype']];
		$templist[]['mytext'] = '支付状态：'.$dotem;
		$templist[]['mytext'] = '备注：'.$order['content']; 
		$templist[]['mytext'] = '店铺名：'.$order['shopname'];
		$templist[]['mytext'] = '店铺地址：'.$order['shopaddress'];
		$backdata['itemlist'] = $templist; 
		$templist =   $this->mysql->getarr("select id,order_id,goodsname,goodscost,goodscount from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$orderid."' ");
		$newdatalist = array();
		$shuliang = 0;
		foreach($templist as $key=>$value){
			$value['goodscost'] = $value['goodscost'];
			$newdatalist[] = $value;

			$shuliang += $value['goodscount'];
		} 
		$backdata['det'] = $newdatalist;

		$this->success($backdata);
	}
	/**
	 *  @brief 买家关闭订单
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function appbuyerclose(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$orderid = trim(IFilter::act(IReq::get('orderid')));
		if(empty($orderid)){
			$this->message('订单不存在或者不属于您');
		}
		$order= $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where id='".$orderid."' "); //cxids 促销规则ID集	cxcost  yhjcost  bagcost
		if(empty($order)){
			$this->message('订单不存在');
		}
		if($order['buyeruid'] != $backinfo['uid']) $this->message('您不是订单所有者');
		if(empty($order['status']) || $order['status'] == 1){
			if($order['status'] == 1){
				if(!empty($order['is_make'])){
					$this->message('订单状态不可取消');
				}
			}
			if($order['paystatus'] == 1){
     	      $this->message('订单已支付请登录网站申请退款');
			}
			$orderdata['status'] = 5;
			$this->mysql->update(Mysite::$app->config['tablepre'].'order',$orderdata,"id='".$orderid."'");
			if(!empty($order['buyeruid'])){
				$detail = '';
				$memberinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$order['buyeruid']."'   ");
					if($order['scoredown']> 0){
		             	$this->mysql->update(Mysite::$app->config['tablepre'].'member','`score`=`score`+'.$order['scoredown'],"uid ='".$order['buyeruid']."' ");
		             	$memberscs = $memberinfo['score']+$order['scoredown'];
		                $this->memberCls->addlog($order['buyeruid'],1,1,$order['scoredown'],'取消订单','用户关闭订单'.$order['dno'].'抵扣积分'.$order['scoredown'].'返回帐号',$memberscs);
		            }
	   	      }

			$this->success('操作成功');

		}else{
			$this->message('订单状态不可取消');
		}
	}
	/**
	 *  @brief 获取所有区域
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function appallarea(){ 
 		$arealist= $this->mysql->getarr("select id,name,parent_id,lat,lng,admin_id,adcode,procode from ".Mysite::$app->config['tablepre']."area where id > 0 and parent_id = 0 limit 0,1000 "); 
		$this->success($arealist); 
	}
	/**
	 *  @brief 调用远程打印机
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */ 
	function appprint(){
		$orderid = trim(IFilter::act(IReq::get('orderid')));
		if(empty($orderid)) $this->message('订单ID错误');
		$ordercode = trim(IFilter::act(IReq::get('ordercode')));
		$cfkey = trim(IFilter::act(IReq::get('cfkey')));
		$cfcode = trim(IFilter::act(IReq::get('cfcode')));
		$qtkey = trim(IFilter::act(IReq::get('qtkey')));
		$qtcode = trim(IFilter::act(IReq::get('qtcode')));


		$orderinfo =  $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."order  where id= '".$orderid."'   ");
		if(empty($orderinfo)) $this->message('订单信息为空');

			$orderdet =  $this->mysql->getarr("select *  from ".Mysite::$app->config['tablepre']."orderdet  where order_id= '".$orderid."'   ");
			$shopinfo =  $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shop  where id= '".$orderinfo['shopid']."'   ");
			$payarrr = array('outpay'=>'到付','open_acout'=>'余额支付');
			$orderpastatus = $orderinfo['paystatus'] == 1?'已支付':'未支付';
			$orderpaytype = isset($payarrr[$orderinfo['paytype']])?$payarrr[$orderinfo['paytype']]:'在线支付';
			$temp_content = '';
			foreach($orderdet as $km=>$vc){
                $temp_content .= $vc['goodsname'].'('.$vc['goodscount'].'份) \n ';
			}
$msg = '商家:'.$shopinfo['shopname'].'
订餐热线:'.Mysite::$app->config['litel'].'
订单状态：'.$orderpaytype.',('.$orderpastatus.')
姓名：'.$orderinfo['buyername'].'
电话：'.$orderinfo['buyerphone'].'
地址：'.$orderinfo['buyeraddress'].'
下单时间：'.date('m-d H:i',$orderinfo['addtime']).'
配送时间:'.date('m-d H:i',$orderinfo['posttime']).'
*******************************
'.$temp_content.'
*******************************

配送费：'.$orderinfo['shopps'].'元
合计：'.$orderinfo['allcost'].'元
※※※※※※※※※※※※※※
谢谢惠顾，欢迎下次光临
订单编号'.$orderinfo['dno'].'
备注'.$orderinfo['content'].'
';
		$backdata = array('print_1'=>5,'print_2'=>5);
		if(!empty($cfcode)&&!empty($cfkey)){
			$backdata['print_1'] =  $this->dosengprint($msg,$cfcode,$cfkey);
	    }
	    if(!empty($qtcode)&&!empty($qtkey)){
			$backdata['print_2'] =  $this->dosengprint($msg,$qtcode,$qtkey);
	    }
	    /*
	    cfcode  0 发送成功 ,1发送到队列  2没找到MAC地址,403错误，,4链接出错
	    */
		$this->success($backdata); 
	}
	/**
	 *  @brief 获取店铺商品分类
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function getshoptype(){ 
		$is_market = intval(IFilter::act(IReq::get('is_market')));
		$goodstype  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shoptype  where parent_id = 0 and  is_search = 1  and cattype = ".$is_market." and type = 'checkbox'     ");
		if(empty($goodstype)){
			$this->success(array());
		}
		$goodstype = $this->mysql->getarr("select *  from ".Mysite::$app->config['tablepre']."shoptype where parent_id = '".$goodstype['id']."' ");
		$this->success($goodstype);
	}
	 /**
	 *  @brief 获取店铺及商品
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	
function getshopnew(){
		$shopid = trim(IFilter::act(IReq::get('shopid')));
		if(empty($shopid)) $this->message('店铺数据获取失败'); 
		$shopinfo  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shop  where id = '".$shopid."'    ");
		if(empty($shopinfo)) $this->message('店铺数据获取失败');

		$data['ptypelist'] = array();
		if($shopinfo['shoptype'] == 0){
			$goodstype =  $this->mysql->getarr("select id,name from ".Mysite::$app->config['tablepre']."goodstype where shopid = ".$shopinfo['id']."   order by orderid asc");
		}else{
			$goodstype =	$this->mysql->getarr("select id,name,parent_id from ".Mysite::$app->config['tablepre']."marketcate where   shopid =".$shopinfo['id']."   order by orderid asc limit 0,100");
			 
		}
		$da = date("w"); 
		$goodsinfo = array();
		if(is_array($goodstype)){
			foreach($goodstype as $key=>$value){//id	typeid 商品类型	name 商品名称	count 商品数量	costimg 图片地址	pointbagcost
				if($shopinfo['shoptype'] == 0){ 
					$goodsdet = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goods where typeid = ".$value['id']."  and shopid =".$shopinfo['id']." and is_live = 1 and FIND_IN_SET(".$da.",weeks) order by good_order asc");
					$temparr = array();
					foreach($goodsdet as $k=>$v){
						
						
						if(empty($v['goodattr'])){
							$shopdefaultattr = $this->mysql->select_one("select goodattrdefault from ".Mysite::$app->config['tablepre']."shop where id = ".$shopid." ");
							if(!empty($shopdefaultattr)){
							   $v['goodattr'] =  $shopdefaultattr['goodattrdefault'];
							}else{
								$v['goodattr'] = '份';
							}
						}
                        $v['instro'] = strip_tags($v['instro']);
						$cxinfo = $this->goodscx($v);
						$v['is_cx'] = $cxinfo['is_cx'];
						$v['cost'] = $cxinfo['cxcost'];
						$v['zhekou'] = $cxinfo['zhekou'];
						$v['cxnum'] = intval($cxinfo['cxnum']);
                        $v['sellcount'] = $v['sellcount'] + $v['virtualsellcount']; 
						$v['img'] = empty($v['img'])?$v['img']:Mysite::$app->config['siteurl'].$v['img'];
						$v['product_attr'] = !empty($v['product_attr'])?unserialize($v['product_attr']):array();
						if(count($v['product_attr']) > 0){
							$temparray = array();
							foreach($v['product_attr'] as $m=>$e){
								$temparray[] = $e;
							}
							
							$v['product_attr'] = $temparray;
						}
						
						
						
						if($v['have_det'] ==1){
							$v['product'] = $this->mysql->getarr("select id,attrname,attrids,stock,cost  from ".Mysite::$app->config['tablepre']."product where goodsid = ".$v['id']."  and shopid =".$shopinfo['id']."  order by id asc");
						}else{
							$v['product'] = array(); 
						}
						 
						$temparr[] = $v;
					}

					$value['det'] = $temparr;
					
					$goodsinfo[] = $value;
				}else{
					$ios = trim(IFilter::act(IReq::get('ios')));
					if($ios == 'marketos'){
						 
						if($value['parent_id'] > 0){
							$goodsdet = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goods where typeid = ".$value['id']."  and shopid =".$shopinfo['id']." and is_live = 1 and FIND_IN_SET(".$da.",weeks)  order by good_order asc ");
							$temparr = array();
							foreach($goodsdet as $k=>$v){
								
								if(empty($v['goodattr'])){
                                    $shopdefaultattr = $this->mysql->select_one("select goodattrdefault from ".Mysite::$app->config['tablepre']."shop where id = ".$shopid." ");
                                    if(!empty($goodsinfo)){
                                       $v['goodattr'] =  $shopdefaultattr['goodattrdefault'];
                                    }else{
                                        $v['goodattr'] = '份';
                                    }
                                }
								
								$cxinfo = $this->goodscx($v);
							$v['is_cx'] = $cxinfo['is_cx'];
						$v['cost'] = $cxinfo['cxcost'];
						$v['zhekou'] = $cxinfo['zhekou'];  
						$v['cxnum'] = intval($cxinfo['cxnum']);
								$v['img'] = empty($v['img'])?$v['img']:Mysite::$app->config['siteurl'].$v['img'];
								$v['product_attr'] = !empty($v['product_attr'])?unserialize($v['product_attr']):array();
								if(count($v['product_attr']) > 0){
									$temparray = array();
									foreach($v['product_attr'] as $m=>$e){
										$temparray[] = $e;
									}
									$v['product_attr'] = $temparray;
								}
								if($v['have_det'] ==1){
									$v['product'] = $this->mysql->getarr("select id,attrname,attrids,stock,cost  from ".Mysite::$app->config['tablepre']."product where goodsid = ".$v['id']."  and shopid =".$shopinfo['id']."  order by id asc");
								}else{
									$v['product'] = array(); 
								}
								$temparr[] = $v;
							}
							$value['det'] = $temparr;
							$goodsinfo[] = $value;
						}
					}else{
						if($value['parent_id'] == 0){
							$value['det'] = array();
							$goodsinfo[] = $value;
						}else{
							$goodsdet = $this->mysql->getarr("select id,typeid,name,count,cost,img,point,bagcost,is_cx,sellcount,shopid,have_det,product_attr,descgoods,goodattr from ".Mysite::$app->config['tablepre']."goods where typeid = ".$value['id']."  and shopid =".$shopinfo['id']."  and is_live = 1  and FIND_IN_SET(".$da.",weeks) order by good_order asc ");
							$temparr = array();
							foreach($goodsdet as $k=>$v){
                                if(empty($v['goodattr'])){
                                    $shopdefaultattr = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where id = ".$shopid." ");
                                    if(!empty($goodsinfo)){
                                       $v['goodattr'] =  $shopdefaultattr['goodattrdefault'];
                                    }else{
                                        $v['goodattr'] = '份';
                                    }
                                }
								$cxinfo = $this->goodscx($v);
								$v['is_cx'] = $cxinfo['is_cx'];
						$v['cost'] = $cxinfo['cxcost'];
						$v['zhekou'] = $cxinfo['zhekou'];
						$v['cxnum'] = intval($cxinfo['cxnum']);
								$v['img'] = empty($v['img'])?$v['img']:Mysite::$app->config['siteurl'].$v['img'];
								$v['product_attr'] = !empty($v['product_attr'])?unserialize($v['product_attr']):array();
								if(count($v['product_attr']) > 0){
										$temparray = array();
										foreach($v['product_attr'] as $m=>$e){
											$temparray[] = $e;
										} 
										$v['product_attr'] = $temparray;
								}
								if($v['have_det'] ==1){
									$v['product'] = $this->mysql->getarr("select id,attrname,attrids,stock,cost  from ".Mysite::$app->config['tablepre']."product where goodsid = ".$v['id']."  and shopid =".$shopinfo['id']."  order by id asc");
								}else{
									$v['product'] = array(); 
								}
								$temparr[] = $v;
							}

							$value['det'] = $temparr;
							$goodsinfo[] = $value;
						}
					}
				}
			}
		}
		$backdata['goods'] = $goodsinfo;
		$this->success($goodsinfo); 
	}
	function goodsone(){//获取一个商品信息
		$goodsid = trim(IFilter::act(IReq::get('goodsid')));
		if(empty($goodsid)) $this->message('商品不存在'); 
		
		$goodsinfo = $this->mysql->select_one("select  * from ".Mysite::$app->config['tablepre']."goods where id = ".$goodsid."   order by id asc");
		$source = trim(IFilter::act(IReq::get('source')));
	    /*商品简述和商品描述字段值互换开始*/
		$descgoods = $goodsinfo['descgoods'];
		$instro = $goodsinfo['instro'];
		if($source == 1){
			$goodsinfo['instro'] = $instro;//ios
		}else{
			$goodsinfo['instro'] = $descgoods;
		}
		$goodsinfo['descgoods'] = $instro;
		
		/*商品简述和商品描述字段值互换结束*/
		 $cxinfo = $this->goodscx($goodsinfo);
		$goodsinfo['is_cx'] = $cxinfo['is_cx'];
		$goodsinfo['cost'] = $cxinfo['cxcost'];
		$goodsinfo['zhekou'] = $cxinfo['zhekou'];
		$goodsinfo['cxnum'] = $cxinfo['cxnum'];
		 
		
		if(empty($goodsinfo)) $this->message('商品不存在');  
		$shopid = $goodsinfo['shopid'];
		$shopinfo  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shop  where id = '".$goodsinfo['shopid']."'    ");
		if(empty($shopinfo)) $this->message('店铺数据获取失败'); 
		if($shopinfo['shoptype'] == 0){
			$shopdet  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shopfast  where shopid = '".$shopid."'    ");
		}else{
			$shopdet  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shopmarket  where shopid = '".$shopid."'    ");
		}
		$goodsinfo['sellcount'] = $goodsinfo['sellcount'] + $goodsinfo['virtualsellcount']; 
        $goodsinfo['instro'] = $goodsinfo['instro'];
        // print_r($goodsinfo['instro']);
		if(empty($shopdet)) $this->message('店铺数未开启');
		$shop = array_merge($shopinfo,$shopdet);
		 $goodsinfo['product_attr'] = !empty($goodsinfo['product_attr'])?unserialize($goodsinfo['product_attr']):array();
		if($goodsinfo['have_det'] ==1){
			if(count($goodsinfo['product_attr']) > 0){
				$temparray = array();
				foreach($goodsinfo['product_attr'] as $m=>$e){
						$temparray[] = $e;
				}
					$goodsinfo['product_attr'] = $temparray;
			}
			
			
			$productlist = $this->mysql->getarr("select pro.id,pro.attrname,pro.attrids,pro.stock,pro.cost,gc.cxnum  from ".Mysite::$app->config['tablepre']."product  as pro left join ".Mysite::$app->config['tablepre']."goodscx as gc on gc.goodsid = pro.goodsid  where pro.goodsid = ".$goodsid."  and pro.shopid =".$shopinfo['id']."  order by pro.id asc");
			$goodsinfo['product'] = array();
			foreach($productlist as $k=>$v){
				$tempgoods = $goodsinfo;
				$tempgoods['cost']= $v['cost'];
				
				$cxinfo2 = $this->goodscx($tempgoods);
				$v['oldcost'] = $v['cost'];
				$v['cost'] = $cxinfo2['cxcost']; 
				$v['is_cx'] = $cxinfo2['is_cx'];
				$v['cxnum'] = empty($v['cxnum'])?0:$v['cxnum'];
				$goodsinfo['product'][] = $v;
			}
			
           
		
		}else{
			$goodsinfo['product'] = array(); 
		}
		
 	    $goodsinfo['img'] = !empty($goodsinfo['img'])?Mysite::$app->config['siteurl'].$goodsinfo['img']:Mysite::$app->config['siteurl'].$goodsinfo['img'];	    
		
		/* 4.12 新增商品多图轮播展示 */
		$tempimgs = $this->mysql->getarr("select imgurl from ".Mysite::$app->config['tablepre']."goodsimg where goodsid = ".$goodsid."  ");		
 		
		$tempimgs1 = array();
 		if(!empty($tempimgs)){
			$temparray = array();
		    $temparray[] = array('imgurl'=>$goodsinfo['img']);
			foreach($tempimgs as $key=>$value){
				$temparray[] = array('imgurl'=>Mysite::$app->config['siteurl'].$value['imgurl']);
			} 
			$tempimgs1 = $temparray; 
		}else{
			$tempimgs1[] = array('imgurl'=>$goodsinfo['img']);
		}
 		$goodsinfo['img'] =  $tempimgs1;
		
 		
		$list = $this->mysql->getarr("select a.*,b.username,b.logo,c.name from ".Mysite::$app->config['tablepre']."comment as a left join  ".Mysite::$app->config['tablepre']."member as b on a.uid = b.uid left join ".Mysite::$app->config['tablepre']."goods as c on a.goodsid = c.id  where a.goodsid=".$goodsid." and a.is_show  =0 and  a.content != ''  and  a.content is not null  order by a.id desc   limit 0,10");
		$backdata['comment'] = array();
		
		foreach($list as $key=>$value){
			if(IValidate::url($value['logo'])){
				
			}else{ 
				$value['logo'] = empty($value['logo'])?Mysite::$app->config['siteurl'].Mysite::$app->config['userlogo']:Mysite::$app->config['siteurl'].$value['logo'];
			}
			
			if( !empty($value['virtualname']) ){
				$value['username'] = $value['virtualname'];
				$xunigoodsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods   where id = '".$value['goodsid']."'   ");
				if( empty($goodsinfo) ){
					$xunigoodsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."product   where goodsid = '".$value['goodsid']."'   ");
					$value['goodsname'] = $xunigoodsinfo['goodsname'].'【'.$attrname.'】';
				}else{
					$value['goodsname'] = $xunigoodsinfo['name'];
				} 
			}
			if( empty($value['username']) ){
				$value['username'] = '游客';
			}
			
			$value['replycontent'] = empty($value['replycontent'])?'':$value['replycontent'];
			$value['addtime'] = date('Y-m-d',$value['addtime']);
			$value['replytime'] = date('Y-m-d',$value['replytime']);
			$backdata['comment'][] = $value;
		}
		$shuliang = $this->mysql->select_one("select count(point) as pointzongshu from  ".Mysite::$app->config['tablepre']."comment where goodsid=".$goodsid." and shopid=".$shopid." order by addtime desc  ");
		$commentlist = $this->mysql->select_one("select count(point) as zongshu from  ".Mysite::$app->config['tablepre']."comment where goodsid=".$goodsid." and shopid=".$shopid." and point= 5 order by addtime desc  ");
	 
		$zongshu =  $commentlist['zongshu']; 
		$pointzongshu =  $shuliang['pointzongshu'];
		if($pointzongshu != 0){
			$haoping = round(($zongshu/$pointzongshu) * 100);
		}else{
			$haoping = 0;
		}
	    $backdata['haoping'] = $haoping;
		$backdata['goods'] = $goodsinfo;
		$backdata['shopinfo'] = $shopdet;
		$this->success($backdata); 
	}
	//新店铺列表获取 
	function newsearchshopxxxx(){
		$shopopentype = intval(IFilter::act(IReq::get('shopopentype'))); //0,1 
		$areaid = intval(IFilter::act(IReq::get('areaid'))); //0,1 
		$searchvalue = trim(IFilter::act(IReq::get('searchvalue')));
		$lat = IFilter::act(IReq::get('lat'));
		$lng = IFilter::act(IReq::get('lng')); 
		$lat = empty($lat)?0:$lat;
		$lng =empty($lng)?0:$lng;
		$orderarray = array(
			0 =>'order by  SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) asc',
			1=>' order by  SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) asc ' 
		);
		$limitarray = array(
			0=>'', 
		);  
		$where = ' where  endtime > '.time().' and  SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < `pradiusa`*0.01094 ';
		if($areaid > 0){
			$where = " where   b.id in(select shopid from ".Mysite::$app->config['tablepre']."areashop where areaid = ".$areaid." ) ";
		}
		$source =  intval(IFilter::act(IReq::get('source')));
		$ios_waiting =   Mysite::$app->config['ios_waiting'];
		if($source == 1 && $ios_waiting == true){
			
			$where = ' where   endtime > '.time().' ';
		}  
		if(empty($searchvalue)){
			$this->message('搜索关键字未空');
		}
		$where .= " and shopname like '%".$searchvalue."%' "; 
		$this->pageCls->setpage(intval(IReq::get('page')),100);
		
		
		$where = Mysite::$app->config['plateshopid'] > 0? $where.' and id != '.Mysite::$app->config['plateshopid'] .' ':$where;
		
		$tempdd = array();
 
		$tempdd[] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop  ".$where."  and is_recom=1  ".$orderarray[0]."   limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."");
	 	 $tempdd[] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop  ".$where." and is_recom!=1  ".$orderarray[0]."   limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."");
	 	
		$shopdata = array();
		$nowhour = date('H:i:s',time());
		$nowhour = strtotime($nowhour);
		$sellrule = new sellrule();
		foreach($tempdd as $kv=>$list){
			
			foreach($list as $key=>$value){  
				$newvalue['id'] = $value['id'];
				$newvalue['shopname'] = $value['shopname'];
				$newvalue['is_open'] = $value['is_open'];
				$newvalue['starttime'] = $value['starttime'];
				$newvalue['pointcount'] = $value['sellcount'];
				$newvalue['lat'] = $value['lat'];
				$newvalue['lng'] = $value['lng']; 
				$newvalue['shoplogo'] = $value['shoplogo']; 
				$newvalue['point'] = $value['point']; 
				$newvalue['pointcount'] = $value['pointcount'];
				$newvalue['address'] = $value['address']; 
				$newvalue['shoptype'] = $value['shoptype']; 
				$newvalue['instro'] = strip_tags($value['instro']);
				$delvalue = array();
				if($value['shoptype'] == 0){
					$delvalue  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shopfast  where shopid = '".$value['id']."'    ");
				}else{
					$delvalue  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shopmarket  where shopid = '".$value['id']."'    ");
				}
				if(isset($delvalue['shopid'])){ 
						$cvalue= array_merge($newvalue,$delvalue); 
						
						
						$juli = $this->GetDistance($lat, $lng, $cvalue['lat'], $cvalue['lng']); 
						$sellrule->setdata($cvalue['id'],1000,$cvalue['shoptype']);
						$rulist = $sellrule->get_rulelist();
						
						
						$tempruleids = array();
						$temprule = array();
						foreach($rulist as $k=>$v){
							if(!in_array($v['controltype'],$tempruleids)){
								$temprule[] = $v;
								$tempruleids[] = $v['controltype'];
							}
						}
						$cvalue['cxinfo'] = $temprule;
						$cvalue['juli'] =  $juli.'米';//'未测距';
						$cvalue['pscost'] = '0';
						$cvalue['canps'] = 0;
						$valuelist = empty($cvalue['pradiusvalue'])? unserialize($this->platpsinfo['radiusvalue']):unserialize($cvalue['pradiusvalue']);
						$juliceshi = intval($juli/1000);
						if(is_array($valuelist)){
							foreach($valuelist as $k=>$v){
								if($juliceshi == $k){
									$cvalue['pscost'] = $v;
									$cvalue['canps'] = 1;
								}
							}
						}
						$source =  intval(IFilter::act(IReq::get('source')));
						$ios_waiting =   Mysite::$app->config['ios_waiting'];
						if($source == 1 && $ios_waiting == true){ 
							$cvalue['canps'] = 1;
						}
						$cvalue['opentype'] = '1';//1营业  0未营业
						$imgurl = empty($cvalue['shoplogo'])? Mysite::$app->config['shoplogo']:$cvalue['shoplogo'];
						$checkinfo = $this->shopIsopen($cvalue['is_open'],$cvalue['starttime'],$cvalue['is_orderbefore'],$nowhour);

						if($checkinfo['opentype'] != 2 && $checkinfo['opentype'] != 3){
							$cvalue['opentype'] = '0';
						}else{
							$cvalue['opentype'] = $checkinfo['opentype'];
						}
						$checkstr =  $cvalue['starttime'];
						$tempstr = array();
						if(!empty($checkstr)){
							$tempstr = explode('-',$checkstr);
						}
						$cvalue['starttime'] = count($tempstr) > 0 ? $tempstr[0]:'';  
						$cvalue['shopimg'] = Mysite::$app->config['siteurl'].$imgurl; 
						
						
						$zongpoint = $cvalue['point'];
						$zongpointcount = $cvalue['pointcount'];
						if($zongpointcount != 0 ){
							$shopstart = intval( round($zongpoint/$zongpointcount) );
						}else{
							$shopstart= 0;
						}
						$cvalue['point'] = 	$shopstart; 
						
						
						
						$shopdata[] = $cvalue;
				}
			}
		
		}
		$data['shoplist'] = $shopdata; 
		$weekji = date('w'); 
		$goodwhere = '';  
		$goodssearch = $searchvalue;  
		if(!empty($goodssearch)) $goodlistwhere=" and name like '%".$goodssearch."%' ";  
		$goodwhere = empty($goodwhere)?'   and  SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradiusa`*0.01094) ': $goodwhere.' and SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradiusa`*0.01094) ';
            	 
		$list =   $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop where is_pass = 1 ".$goodwhere." ");		
		$nowhour = date('H:i:s',time()); 
		$nowhour = strtotime($nowhour);
		$goodssearchlist = array(); 
				   
		if(is_array($list)){
			foreach($list as $keys=>$vatt){
				if($vatt['id'] > 0){
					if( $vatt['shoptype'] == 1 ){
							$shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket where  shopid = ".$vatt['id']."   ");
					}else{
							$shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast where  shopid = ".$vatt['id']."   ");
					}
					$checkinfo = $this->shopIsopen($vatt['is_open'],$vatt['starttime'],$shopdet['is_orderbefore'],$nowhour); 
					$opentype = 1;
					if($checkinfo['opentype'] != 2 && $checkinfo['opentype'] != 3){
						$opentype = 0;
					} 		 
					//"id":"3101","typeid":"248","parentid":"0","name":"\u81ca\u5b50\u9762","count":"400","cost":"16.00","img":"\/upload\/pliang\/20150829103116364.jpg","point":"7","sellcount":"16","shopid":"15","uid":"6","signid":"","pointcount":"1"
					$detaa = $this->mysql->getarr("select  * from ".Mysite::$app->config['tablepre']."goods where shopid='".$vatt['id']."'  and shoptype = ".$vatt['shoptype']."  and    FIND_IN_SET( ".$weekji." , `weeks` )  ".$goodlistwhere."   order by good_order asc ");
						if(!empty($detaa)){ 
					
							foreach ( $detaa as $keyq=>$valq ){
									if($valq['is_cx'] == 1){
									//测算促销 重新设置金额
										$cxdata = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goodscx where goodsid=".$valq['id']."  ");
										$newdata = getgoodscx($valq['cost'],$cxdata); 
										$valq['zhekou'] = $newdata['zhekou'];
										$valq['is_cx'] = $newdata['is_cx'];
										$valq['cost'] = $newdata['cost'];
									}
									
									$valq['product_attr'] = !empty($valq['product_attr'])?unserialize($valq['product_attr']):array();
									if(count($valq['product_attr']) > 0){
										$temparray = array();
										foreach($valq['product_attr'] as $m=>$e){
											$temparray[] = $e;
										}
										
										$valq['product_attr'] = $temparray;
									}
									
									
									
									if($valq['have_det'] ==1){
										$valq['product'] = $this->mysql->getarr("select id,attrname,attrids,stock,cost  from ".Mysite::$app->config['tablepre']."product where goodsid = ".$valq['id']."  and shopid =".$valq['shopid']."  order by id asc");
									}else{
										$valq['product'] = array(); 
									}
									
									
									
									$valq['opentype'] = $opentype;
									$valq['shoptype'] = $vatt['shoptype']; 
                                    $imgurl = empty($valq['img'])? Mysite::$app->config['shoplogo']:$valq['img'];
							        $valq['img'] = Mysite::$app->config['siteurl'].$imgurl;
									$valq['instro'] = strip_tags($valq['instro']);
									 
									$goodssearchlist[] = $valq; 
							}
							
						}	
						
					}
					
			   } 
		}
		$data['goodslist']   = empty($goodssearchlist)?array():$goodssearchlist; 
		$this->success($data);
	}
	function newsearchshop(){   //ajax搜索 商家和商品结果
		//$shopopentype = intval(IFilter::act(IReq::get('shopopentype'))); //0,1 
		//$areaid = intval(IFilter::act(IReq::get('areaid'))); //0,1 
		 


		$searchname = IFilter::act(IReq::get('searchvalue'))   ;
		 
         
			
		$cxsignlist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodssign where type='cx' order by id desc limit 0, 100");
		$cxarray  =  array();
		foreach($cxsignlist as $key=>$value){
		   $cxarray[$value['id']] = $value['imgurl'];
		} 		

		/* 搜索店铺 结果  */
		$where = '';  
		$lng = 0;
		$lat = 0;  
		$lng = IFilter::act(IReq::get('lng'));
		$lat =IFilter::act(IReq::get('lat'));
		$lng = empty($lng)?0:$lng;
		$lat =empty($lat)?0:$lat;
		$shopsearch = IFilter::act(IReq::get('searchvalue')); 
		$shopsearch		 = urldecode($shopsearch); 
		if(!empty($shopsearch)) $where=" and shopname like '%".$shopsearch."%' "; 
		$adcode = intval(IFilter::act(IReq::get('adcode'))); 
		if($adcode < 1){
			 
			if( !empty($lat) &&  !empty($lng) ){
					  $content =   file_get_contents('https://restapi.amap.com/v3/geocode/regeo?output=json&location='.$lng.','.$lat.'&key='.Mysite::$app->config['map_webservice_key'].'&radius=1000&extensions=all'); 
						 $backinfo  = json_decode($content,true);
						if( $backinfo['status'] == 1 && $backinfo['info'] == 'OK'){
							$adcode = $backinfo['regeocode']['addressComponent']['adcode'];  
						}  
							
			}
		}
		 
		
		if( $adcode > 0 ){
			$areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  "); 
			if( !empty($areacodeone) ){
				$adcodeid = $areacodeone['id'];
				$pid = $areacodeone['pid'];
				$adcode = $adcode;
				$areainfoone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  ");   
				if( !empty($areainfoone) ){
					$city_id = "CITY_ID_".$areainfoone['adcode'];
					$city_name = "CITY_NAME_".$areainfoone['name'];
					ICookie::set('CITY_ID',$city_id);
					ICookie::set('CITY_NAME',$city_name);
					$data['areainfoone']  = $areainfoone;
					$adcode = $areainfoone['adcode'];
				}
				
			}
		}
		$this->CITY_ID = $adcode; 
		
		$where = empty($where)?'   and  SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradiusa`*0.01094-0.01094) ': $where.' and SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradiusa`*0.01094-0.01094) ';
            	 
                 
		$lng = trim($lng);
		$lat = trim($lat);
		$lng = empty($lng)?0:$lng;
		$lat =empty($lat)?0:$lat;
                      
		/*获取店铺*/
		$where = Mysite::$app->config['plateshopid'] > 0? $where.' and  id != '.Mysite::$app->config['plateshopid'] .' ':$where;
		$pageinfo = new page();
		$pageinfo->setpage(intval(IReq::get('page'))); 
					  
		$tempdd = array();
		//and is_recom = 1
		 
		$tempdd[] =   $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop where is_pass = 1  and (   admin_id='".$this->CITY_ID."'  or  admin_id = 0 )     and endtime > ".time()."  ".$where." ");		
		#	$tempdd[] =   $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop where is_pass = 1  and (   admin_id='".$this->CITY_ID."'  or  admin_id = 0 )  and is_open = 1  and is_recom != 1 and endtime > ".time()."  ".$where." ");
				 
		$this->platpsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$adcode."' "); 		 
				 
		$nowhour = date('H:i:s',time()); 
		$nowhour = strtotime($nowhour);
		$templist = array();
		$cxclass = new sellrule();  
		foreach($tempdd as $key=>$list){ 

			if(is_array($list)){
				foreach($list as $keys=>$values){   
					if($values['id'] > 0){ 
						$templist111 = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where cattype = ".$values['shoptype']." and  parent_id = 0    order by orderid asc limit 0,1000"); 
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
						if($values['shoptype'] == 1 ){
							$shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket where  shopid = ".$values['id']."   ");
						}else{
							$shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast where  shopid = ".$values['id']."   ");
						} 
						if(empty($shopdet['limitcost'])){
							$values['limitcost'] = 0;
						}else{
							$values['limitcost'] = $shopdet['limitcost'];
						}
						if(empty($shopdet['pscost'])){
							$values['pscost'] = 0;
						}else{
							$values['pscost'] = $shopdet['pscost'];
						}	
						if(empty($shopdet['arrivetime'])){
							$values['arrivetime'] = 0;
						}else{
							$values['arrivetime'] = $shopdet['arrivetime'];
						}				
						$values = array_merge($values,$shopdet); 
						$values['shoplogo'] = empty($values['shoplogo'])? Mysite::$app->config['imgserver'].Mysite::$app->config['shoplogo']:Mysite::$app->config['imgserver'].$values['shoplogo'];
						$checkinfo = $this->shopIsopen($values['is_open'],$values['starttime'],$values['is_orderbefore'],$nowhour); 
						$values['opentype'] = $checkinfo['opentype'];
						$values['newstartime']  =  $checkinfo['newstartime'];  
						$attrdet = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopattr where  cattype = ".$values['shoptype']." and shopid = ".$values['id']."");
						$cxclass->setdata($values['id'],1000,$values['shoptype']); 
									  
						$checkps = 	 $this->pscost($values,$lng,$lat); 
						$imgurl = empty($values['shoplogo'])? Mysite::$app->config['shoplogo']:$values['shoplogo'];
						 
						$values['shopimg'] =  $imgurl; 
						
						$values['canps'] = $checkps['canps']; 
						$values['pstype'] = $checkps['pstype']; 
						$source =  intval(IFilter::act(IReq::get('source')));
						$ios_waiting =   Mysite::$app->config['ios_waiting'];
						if($source == 1 && $ios_waiting == true){ 
							$values['canps'] = 1;
						}
						$values['opentype'] = '1';//1营业  0未营业
					 
						$checkinfo = $this->shopIsopen($values['is_open'],$values['starttime'],$values['is_orderbefore'],$nowhour);

						if($checkinfo['opentype'] != 2 && $checkinfo['opentype'] != 3){
							$values['opentype'] = '0';
						}else{
							$values['opentype'] = $checkinfo['opentype'];
						}

						$mi = $this->GetDistance($lat,$lng, $values['lat'],$values['lng'], 1); 
						$tempmi = $mi;
                        $juli = $mi;
						$mi = $mi > 1000? round($mi/1000,2).'km':$mi.'m';
														  
						$values['juli'] = 		$mi;

                        $juliceshi = intval($juli/1000);


                        $values['pscost'] = '0';
                        $values['canps'] = 0;
                        $platpsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$values['admin_id']."' ");
                        if( $values['sendtype'] == 1 ){
                            $values['psimg'] = Mysite::$app->config['shoppsimg'];
                            $valuelist = empty($values['pradiusvalue'])? '':unserialize($values['pradiusvalue']);
                        }else{
                            $values['psimg'] = Mysite::$app->config['psimg'];
                            $valuelist = empty($platpsinfo['radiusvalue'])? '':unserialize($platpsinfo['radiusvalue']);
                        }
                        #$valuelist = empty($value['pradiusvalue'])? unserialize($this->platpsinfo['radiusvalue']):unserialize($value['pradiusvalue']);

                        if(is_array($valuelist)){
                            foreach($valuelist as $k=>$v){
                                if($juliceshi == $k){
                                    $values['pscost'] = $v;
                                    $values['canps'] = 1;
                                }
                            }
                        }

						$shopcounts = $this->mysql->select_one( "select count(id) as shuliang  from ".Mysite::$app->config['tablepre']."order	 where status = 3 and  shopid = ".$values['id']."" );
	 
						if(empty( $shopcounts['shuliang']  )){
							$values['ordercount'] = 0;
						}else{
							$values['ordercount']  = $shopcounts['shuliang'];
						}  			
                        						
						$cxinfo = $this->mysql->getarr("select name,id,imgurl from ".Mysite::$app->config['tablepre']."rule where  FIND_IN_SET(".$values['id'].",shopid)   and status = 1   and ( limittype < 3  or ( limittype = 3 and endtime > ".time()." and starttime < ".time().")) ");
						$values['cxlist'] = $cxinfo; 						 
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
     
		$data['shoplist']   = $templist; 
	#	print_r($data['shopsearchlist']); 
		/* 搜索商品列表 */
		$weekji = date('w');
		$goodwhere = '';  
		$goodssearch = IFilter::act(IReq::get('searchvalue')); 
		//$goodssearch	 = urldecode($goodssearch); 
		if(!empty($goodssearch)) $goodlistwhere=" and name like '%".$goodssearch."%' "; 
		$lng = 0;
		$lat = 0; 
		$lng = IFilter::act(IReq::get('lng')); 
		$lat = IFilter::act(IReq::get('lat')); 
		$lng = empty($lng)?0:$lng;
		$lat =empty($lat)?0:$lat;
		$goodwhere = empty($goodwhere)?'   and  SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradiusa`*0.01094-0.01094) ': $goodwhere.' and SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradiusa`*0.01094-0.01094) ';
            	        
		$lng = trim($lng);
		$lat = trim($lat);
		$lng = empty($lng)?0:$lng;
		$lat =empty($lat)?0:$lat; 
		$templist11 = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where  cattype = 0 and parent_id = 0 and is_main =1  order by orderid asc limit 0,1000"); 
		$attra['input'] = 0;
		$attra['img'] = 0;
		$attra['checkbox'] = 0; 
		foreach($templist11 as $key=>$value){
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
		$list =   $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop where is_pass = 1     and endtime > ".time()."  ".$goodwhere." ");			 					
		#   $list = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where  b.is_pass = 1  ".$tempwhere." ".$goodwhere."    order by ".$orderarray[$order]." limit ".$pageinfo->startnum().", ".$pageinfo->getsize().""); 
		// print_r($list); 
		$nowhour = date('H:i:s',time()); 
		$nowhour = strtotime($nowhour);
		$goodssearchlist = array();
		$cxclass = new sellrule(); 
		if(is_array($list)){
			foreach($list as $keys=>$vatt){
			 
			// print_r($valq['shoplogo']);
				if($vatt['id'] > 0){
					$detaa = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goods where shopid='".$vatt['id']."'  and shoptype = ".$vatt['shoptype']."  and    FIND_IN_SET( ".$weekji." , `weeks` )  ".$goodlistwhere."   order by good_order asc ");
					if(!empty($detaa)){ 
							foreach ( $detaa as $keyq=>$valq ){
								if($valq['is_cx'] == 1){
								//测算促销 重新设置金额
									$cxdata = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goodscx where goodsid=".$valq['id']."  ");
									$newdata = getgoodscx($valq['cost'],$cxdata);
									
									$valq['zhekou'] = $newdata['zhekou'];
									$valq['is_cx'] = $newdata['is_cx'];
									$valq['cost'] = $newdata['cost'];
									$valq['cxnum'] = $cxdata['cxnum'];
								}
								$shoplist1 = $this->mysql->select_one("select shoplogo,shopname from ".Mysite::$app->config['tablepre']."shop where  id = ".$valq['shopid']."   ");
								if( $shoptype == 1 ){
									 $shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket where  shopid = ".$valq['shopid']."   ");
								}else{
									  $shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast where  shopid = ".$valq['shopid']."   ");
								}
								$checkinfo = $this->shopIsopen($vatt['is_open'],$vatt['starttime'],$shopdet['is_orderbefore'],$nowhour); 
								if(empty($shopdet['limitcost'])){
									$valq['limitcost'] = 0;
								}else{
									$valq['limitcost'] = $shopdet['limitcost'];
								}
								if(empty($shopdet['pscost'])){
									$valq['pscost'] = 0;
								}else{
									$valq['pscost'] = $shopdet['pscost'];
								}	
								if(empty($shopdet['arrivetime'])){
									$valq['arrivetime'] = 0;
								}else{
									$valq['arrivetime'] = $shopdet['arrivetime'];
								}				
								$valq['opentype'] = $checkinfo['opentype'];
								#$valq['limitcost'] = $shopdet['limitcost'];
								#$valq['pscost'] = $shopdet['pscost'];
								#$valq['arrivetime'] = $shopdet['maketime'];
								// $valq['shoplogo'] = $shopdet['shoplogo'];
								$valq['shoplogo'] = $shoplist1['shoplogo'];
								$valq['shopname'] = $shoplist1['shopname'];
								$valq['sellcount'] = $valq['sellcount']+$valq['virtualsellcount'];
								$imgurl = empty($valq['img'])? Mysite::$app->config['shoplogo']:$valq['img'];
								$valq['img'] = Mysite::$app->config['siteurl'].$imgurl;
								$temparray[] =$valq; 
								$vakk = $temparray;
							} 
					}	
					$goodssearchlist = $vakk; 
				}
			} 
		} 		
		$data['goodslist']   = $goodssearchlist; 
		$this->success($data);
	}
	public function searchhotkey(){
		
		$searchwords = Mysite::$app->config['searchwords'];
		$searchwords = empty($searchwords)?array():unserialize($searchwords);
		$temparray = array();
		if(is_array($searchwords)){
			foreach($searchwords as $key=>$value){
				$tempc = array();
				$tempc['id'] = $key;
				$tempc['name'] = $value;
				$temparray[] = $tempc;
			}
		}
		
		 $this->success($temparray);
	}
	
	/**
	 *  @brief 获取店铺信息
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */ 
	function newshopinfo(){
		$backinfo = $this->checkappMem();
		$shopid = trim(IFilter::act(IReq::get('shopid')));
		$shoplogo = Mysite::$app->config['shoplogo'];
		$lat = IFilter::act(IReq::get('lat'));
		$lng = IFilter::act(IReq::get('lng'));
		$lat = empty($lat)?0:$lat;
		$lng = empty($lng)?0:$lng;
		if(empty($shopid)) $this->message('店铺数据获取失败');

		$shopinfo  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shop  where id = '".$shopid."'    ");
		$shopinfo['notice_info']= strip_tags($shopinfo['notice_info']);
		if(empty($shopinfo['notice_info'])){
		$shopinfo['notice_info']= strip_tags(Mysite::$app->config['shopnotice']);	
		}
		if(empty($shopinfo)) $this->message('店铺数据获取失败');
 
		if($shopinfo['shoptype'] == 0){
			$shopdet  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shopfast  where shopid = '".$shopid."'    ");
		}else{
			$shopdet  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shopmarket  where shopid = '".$shopid."'    ");
		}
		if(empty($shopdet)) $this->message('店铺数未开启');
		$shop = array_merge($shopinfo,$shopdet);
		//2015.3.23修改
		$nowhour = date('H:i:s',time());
		$nowhour = strtotime($nowhour);
		$checkinfo = $this->shopIsopen($shop['is_open'],$shop['starttime'],$shop['is_orderbefore'],$nowhour);
		$shop['opentype'] = $checkinfo['opentype']; 
			
		//2015.3.23修改		
		// unset($shop['intr_info']);
		// unset($shop['cx_info']);
		
		$shop['intr_info'] = strip_tags($shop['intr_info']);
		$shop['cx_info'] = strip_tags($shop['cx_info']);
		$imgurl = empty($shop['shoplogo'])? Mysite::$app->config['shoplogo']:$shop['shoplogo'];
		$shop['shopimg'] = Mysite::$app->config['siteurl'].$imgurl;
		$juli = $this->GetDistance($lat, $lng, $shop['lat'], $shop['lng']);

		$platpsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$shop['admin_id']."' ");   
			if( $shop['sendtype'] == 1 ){
				   $valuelist =  unserialize($shop['pradiusvalue']);
			  }else{
				   $valuelist = unserialize($platpsinfo['radiusvalue']);
			  }
		#$valuelist = empty($shop['pradiusvalue'])? unserialize($this->platpsinfo['radiusvalue']):unserialize($shop['pradiusvalue']);
		 
		
		 
		
		
		$juliceshi = intval($juli/1000);
		$shop['baidupscost'] = '不在配送区域';
		$shop['pscost'] = '0';
		$shop['canps'] = 0;
		if(is_array($valuelist)){
			foreach($valuelist as $k=>$v){
  	       	    if($juliceshi == $k){
					$shop['pscost'] = $v;
					$shop['baidupscost'] =$v;
  	       	        $shop['canps'] = 1;
  	       	    }
  	       	}
		}
		$source =  intval(IFilter::act(IReq::get('source')));
		$ios_waiting =   Mysite::$app->config['ios_waiting'];
		if($source == 1 && $ios_waiting == true){
			$shop['baidupscost']  = $shop['pscost'];
		    $shop['canps'] = 1;
		}
		$shop['collect'] = 0;
		if($backinfo['uid'] > 0){ 
			$collect = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."collect where uid ='".$backinfo['uid']."'  and collectid = '".$shopid."' and collecttype  = 0  ");
			if(!empty($collect)){
				$shop['collect'] = 1;
			}
		}
		$zongpoint = $shop['point'];
		$zongpointcount = $shop['pointcount'];
		if($zongpointcount != 0 ){
			$shopstart = intval( round($zongpoint/$zongpointcount) );
		}else{
			$shopstart= 0;
		}
		$shop['point'] = 	$shopstart;
		$psservicepoint = $shop['psservicepoint'];
		$psservicepointcount = $shop['psservicepointcount'];
		if($psservicepoint != 0 ){
			$shopstartx = intval( round($psservicepoint/$psservicepointcount) );
		}else{
			$shopstartx= 0;
		}
		$shop['pspoint'] = 	$shopstartx;
		
		 if( $shop['sendtype'] == 1 ){
					 $shop['psimg'] = Mysite::$app->config['shoppsimg'];
                     
				}else{
					 $shop['psimg'] = Mysite::$app->config['psimg']; 	 
				}
		
                                $d =date("w");
                                if($d == 0){
                                    $d =7;
                                }
		
		$cxrule = $this->mysql->getarr("select name,imgurl  from ".Mysite::$app->config['tablepre']."rule  where  FIND_IN_SET(".$shopid.",shopid)   and status = 1   and ( limittype = 1 or ( limittype = 2 and ".$d."  in ( limittime ) )  or ( limittype = 3 and endtime > ".time()." and starttime < ".time().")) ");
		$cxinfo = array();
		foreach($cxrule as $key=>$value){
			$value['logo'] = isset($value['imgurl'])?Mysite::$app->config['siteurl'].$value['imgurl']:'';
			$cxinfo[] = $value;
		}
		$data['shopinfo'] = $shop;
		$data['cx'] = $cxinfo;
		$this->success($data);
	}
	/**
	 *  @brief 获取店铺10个最近评价
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function commentshop(){
		$shopid = intval(IFilter::act(IReq::get('shopid')));
		$list = $this->mysql->getarr("select a.*,b.username,a.virtualname,b.logo,c.name from ".Mysite::$app->config['tablepre']."comment as a left join  ".Mysite::$app->config['tablepre']."member as b on a.uid = b.uid left join ".Mysite::$app->config['tablepre']."goods as c on a.goodsid = c.id  where a.shopid=".$shopid." and a.is_show  =0  and  a.content is not null and a.content is not null order by a.id desc   limit 0,10");
		$backdata = array();
		foreach($list as $key=>$value){
			//http://
			if(IValidate::url($value['logo'])){
				
			}else{ 
				$value['logo'] = empty($value['logo'])?Mysite::$app->config['siteurl'].Mysite::$app->config['userlogo']:Mysite::$app->config['siteurl'].$value['logo'];
			}
			if( !empty($value['virtualname']) ){
				$value['username'] = $value['virtualname'];
				$xunigoodsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods   where id = '".$value['goodsid']."'   ");
				if( empty($goodsinfo) ){
					$xunigoodsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."product   where goodsid = '".$value['goodsid']."'   ");
					$value['goodsname'] = $xunigoodsinfo['goodsname'].'【'.$attrname.'】';
				}else{
					$value['goodsname'] = $xunigoodsinfo['name'];
				} 
			}
			if( empty($value['username']) ){
				$value['username'] = '游客';
			}
			
			
			
			 if(!empty($value['replycontent'])){
				 $value['replytime'] = date('Y-m-d',$value['replytime']);
			 }
			
			$value['addtime'] = date('Y-m-d',$value['addtime']);
			$backdata[] = $value;
		}
		$this->success($backdata);
	}
	/**
	 *  @brief 获取兑换商品
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function giftlist(){
		//获取所有礼品列表
		//score	title	content	typeid	sell_count 销售数量	stock 库存	img
		$page = intval(IFilter::act(IReq::get('page')));
		$pagesize = intval(IFilter::act(IReq::get('pagesize'))); 
		$pagesize = $pagesize > 0? $pagesize:10;
		
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize); 
		$cximglist = $this->mysql->getarr("select id,score,title,stock,img from ".Mysite::$app->config['tablepre']."gift  order by id asc limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."");
		$backdata = array();
		foreach($cximglist as $key=>$value){
			$value['img'] =  empty($value['img'])?Mysite::$app->config['siteurl'].Mysite::$app->config['shoplogo']:Mysite::$app->config['siteurl'].$value['img'];
			$backdata[]= $value;
		}
		$this->success($backdata); 
	}
	/**
	 *  @brief 兑换礼品
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */ 
	function exchange(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}

		$lipin_id = intval(IReq::get('id'));
		if(empty($lipin_id)) $this->message("gift_empty");
		$lipininfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."gift where id ='".$lipin_id."'  order by id asc  ");
		if(empty($lipininfo)) $this->message("gift_empty");
		if($lipininfo['stock'] < 1)$this->message("gift_emptystock");
		$moren_addr = intval(IReq::get('address_id'));
		$shuliang = intval(IReq::get('shuliang'));


		if(empty($shuliang)) $this->message('礼品兑换数量错误');
		$data['address'] = IFilter::act(IReq::get('address'));
		$data['contactman'] = IFilter::act(IReq::get('contactname'));
		$data['telphone'] = IFilter::act(IReq::get('phone'));
		if(empty($data['address']))$this->message("emptyaddress");
		if(empty($data['contactman']))$this->message("emptycontact");
		if(empty($data['telphone']))$this->message("errphone");

        if(!preg_match("/^1[34578]{1}\d{9}$/",$data['telphone'])){
            $this->message('手机号格式错误');
        }

	    $checkjifen = $lipininfo['score']*$shuliang;
	   	if($backinfo['score'] < $checkjifen)$this->message('member_scoredown');
	   	$ndata['score'] = $backinfo['score'] - $checkjifen;
	   	//更新用户积分
	     $this->mysql->update(Mysite::$app->config['tablepre'].'member',$ndata,"uid='".$backinfo['uid']."'");
	   	$data['giftid'] = $lipininfo['id'];
	   	$data['uid'] = $backinfo['uid'];
	   	$data['addtime'] = time();
	   	$data['status'] = 0;
	   	$data['count'] = $shuliang;
	   	$data['score'] = $checkjifen;
		$this->mysql->insert(Mysite::$app->config['tablepre'].'giftlog',$data);
		$this->memberCls->addlog($backinfo['uid'],1,2,$checkjifen,'兑换礼品','兑换'.$lipininfo['title'].'('.$shuliang.'件)减少'.$lipininfo['score'].'积分',$ndata['score']);
		//更新礼品表
		$lidata['stock'] =  $lipininfo['stock']-$shuliang;
		$lidata['sell_count'] =  $lipininfo['sell_count']+$shuliang;
	   	$this->mysql->update(Mysite::$app->config['tablepre'].'gift',$lidata,"id='".$lipin_id."'");
	    $this->success('success');
	}
    /**
     *  @brief 兑换记录
     *  
     *  @return Return_Description
     *  
     *  @details Details
     */ 
	function exgiftlog(){
		$uid = intval(IReq::get('uid'));
		$backinfo =$this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid ='".$uid."' ");
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$page = intval(IFilter::act(IReq::get('page')));
		$pagesize = intval(IFilter::act(IReq::get('pagesize'))); 
		$pagesize = $pagesize > 0? $pagesize:10;
		
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);  
		$backdata = array();
		 
		$lipinlist = $this->mysql->getarr("select a.*,b.title,b.img from ".Mysite::$app->config['tablepre']."giftlog  as a left join ".Mysite::$app->config['tablepre']."gift as b on a.giftid = b.id  where a.uid ='".$backinfo['uid']."'   order by a.id desc limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()." ");
		foreach($lipinlist as $key=>$value){
			$value['img'] =  empty($value['img'])?Mysite::$app->config['siteurl'].Mysite::$app->config['shoplogo']:Mysite::$app->config['siteurl'].$value['img'];
			$value['addtime'] = date('Y-m-d',$value['addtime']);
			$backdata[]= $value;
		}
		$this->success($backdata);
	}
	/**
	 *  @brief 礼品操作
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function controlgift(){
		//http://192.168.0.109/index.php?ctrl=app&action=exchange&id=2&controlname=colse&uid=1&pwd=waimairen&datatype=json
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		} 
		$id = intval(IReq::get('id'));
		$controlname = IFilter::act(IReq::get('controlname'));
		if(empty($id)) $this->message('gift_emptygiftlog');
		$info  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."giftlog where uid ='".$backinfo['uid']."' and id=".$id." ");
		if(empty($info)) $this->message('gift_emptygiftlog');

		$lipininfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."gift where id ='".$info['giftid']."'  order by id asc  ");
		if($controlname == "colse"){
			if($info['status'] != 0)$this->message('gift_cantlogun');
			$titles = isset($lipininfo['title'])? $lipininfo['title']:$info['id'];
			$this->mysql->update(Mysite::$app->config['tablepre'].'giftlog',array('status'=>'4'),"id='".$id."'");
			$ndata['score'] = $backinfo['score'] + $info['score'];
		      //更新用户积分
	        $this->mysql->update(Mysite::$app->config['tablepre'].'member','`score` = `score`+'.$info['score'],"uid='".$backinfo['uid']."'");
	        	//写消息
	        $this->memberCls->addlog($backinfo['uid'],1,1,$info['score'],'取消兑换礼品','取消兑换ID为:'.$id.'的礼品['.$titles.'],帐号积分'.$ndata['score'] ,$ndata['score'] );

			$lidata['stock'] =  $lipininfo['stock']+$info['count'];
			$lidata['sell_count'] =  $lipininfo['sell_count']-$info['count'];
			$this->mysql->update(Mysite::$app->config['tablepre'].'gift',$lidata,"id='".$info['giftid']."'");
	        $this->success('success');
		}else{
	 	    if($info['status'] < 4) $this->message('礼品兑换记录状态不可删除');
	 	    $this->mysql->delete(Mysite::$app->config['tablepre'].'giftlog',"id in($id)");
			$this->success('success');
		}
	}
	/**
	 *  @brief 优惠卷列表
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function myjuan(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$page = intval(IFilter::act(IReq::get('page')));
		$pagesize = intval(IFilter::act(IReq::get('pagesize'))); 
		$pagesize = $pagesize > 0? $pagesize:10;
		
		
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);  
		// 状态，0未使用，1已绑定，2已使用，3无效	 制造时间	 优惠金额	 购物车限制金额下限	 失效时间	uid 用户ID	username 用户名	usetime 使用时间	name
		$cximglist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."juan where uid =".$backinfo['uid']." and status=1 order by id desc   limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."");
/* 		print_r($backinfo); */
		
		$backdata = array();
		//status 状态，0未使用，1已绑定，2已使用，3无效
		foreach($cximglist as $key=>$value){
			if($value['endtime'] < time()){
				$value['status'] = $value['status'] < 2?3:$value['status'];
			}
			
			$checkpaytype = 0;
			if($value['paytype'] =='1'){
				$checkpaytype =1;
			}elseif($value['paytype'] =='2'){
				$checkpaytype =2;
			}else{
				$checkpaytype =3;
			}
			$value['paytype'] = $checkpaytype;
			
			$value['endtime'] = date('Y-m-d',$value['endtime']);
			$backdata[] = $value;
		}
		foreach($backdata as $k=>$v){
		    if($v['status'] >1){
				$disabled[] = $v;
			}
			if($v['status'] <2){
				$available[] = $v;
		    }
		}
		$data['available'] = $available;//可用
		$data['disabled'] = $disabled;//不可用	
		
		$this->success($data);
	}
	/**
	 *  @brief 绑定优惠券
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function savejuan(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$card = trim(IFilter::act(IReq::get('card')));
		$password = trim(IFilter::act(IReq::get('cardpwd')));
		if(empty($card)) $this->message('card_emptyjuancard');
		if(empty($password)) $this->message('card_emptyjuanpwd');
		$checkinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."juan where card ='".$card."'  and card_password = '".$password."' and endtime > ".time()." and status = 0");
		if(empty($checkinfo)) $this->message('card_emptyjuan');
		if($checkinfo['uid'] > 0) $this->message('card_juanisuse');

		$arr['uid'] = $backinfo['uid'];
		$arr['status'] =  1;
		$arr['username'] = $backinfo['username'];
		$this->mysql->update(Mysite::$app->config['tablepre'].'juan',$arr,"card='".$card."'  and card_password = '".$password."' and endtime > ".time()." and status = 0 and uid = 0");
		$mess['userid'] = $backinfo['uid'];
		$mess['username']  ='';
		$mess['content'] = '绑定优惠劵'.$checkinfo['card'];
		$mess['addtime'] = time();
		//$this->mysql->insert(Mysite::$app->config['tablepre'].'message',$mess);  //写消息表
		$this->success('success');
	}
	//添加收藏
	function addcollect(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$collectid = intval(IFilter::act(IReq::get('collectid')));
		$collecttype = intval(IFilter::act(IReq::get('collecttype')));
		$collect = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."collect where uid ='".$backinfo['uid']."'  and collectid = '".$collectid."' and collecttype  = '".$collecttype."'  ");
		if(!empty($collectinfo)) $this->message('已收藏该店铺');
		$data['collectid'] = $collectid;
		$data['collecttype'] = $collecttype;
		$data['uid'] = $backinfo['uid'];
		
		if($collecttype == 1){
			$goodsinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods where id ='".$collectid."'    ");
		    if(empty($goodsinfo)) $this->message('商品不存在');
			$data['shopuid'] = $goodsinfo['uid'];
		}else{
			$shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where id ='".$collectid."'    ");
		    if(empty($shopinfo))  $this->message('店铺不存在');
			$data['shopuid'] = $shopinfo['uid'];
		}
		$this->mysql->insert(Mysite::$app->config['tablepre'].'collect',$data);
		$this->success('success!'); 
	}
	function delcollect(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		 
		$collectid = intval(IFilter::act(IReq::get('collectid')));
		$collecttype = intval(IFilter::act(IReq::get('collecttype')));
		$collect = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."collect where uid ='".$backinfo['uid']."'  and collectid = '".$collectid."' and collecttype  = '".$collecttype."'  ");
		if(empty($collect)) $this->message('未收藏');
		 
	    $this->mysql->delete(Mysite::$app->config['tablepre'].'collect',"uid ='".$backinfo['uid']."' and collectid = '".$collectid."' and collecttype  = '".$collecttype."' ");   
	 	$this->success('success!');  
	}
	/**
	 *  @brief 通过店铺ID集获取店铺信息
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function collectshop(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
	   $templist = $this->mysql->getarr("select *  from ".Mysite::$app->config['tablepre']."collect  where uid ='".$backinfo['uid']."' and collecttype  = 0   ");  
	   if(count($templist) == 0) {
		   $this->success(array());
	   }
	   $tempids = array();
        foreach($templist as $key=>$value){
		  $tempids[] = $value['collectid'];
	   } 
	   if(count($tempids)> 0){
		   $where = " where id in(".join(',',$tempids).") ";
	   }else{
		    $this->success(array());
	   } 
	   
	    $lat = IFilter::act(IReq::get('lat'));
		  $lng = IFilter::act(IReq::get('lng'));
             


		 if( !empty($lat) &&  !empty($lng) ){
				  $content =   file_get_contents('https://restapi.amap.com/v3/geocode/regeo?output=json&location='.$lng.','.$lat.'&key='.Mysite::$app->config['map_webservice_key'].'&radius=1000&extensions=all'); 
					 $backinfo  = json_decode($content,true);

					if( $backinfo['status'] == 1 && $backinfo['info'] == 'OK'){
						$adcode = $backinfo['regeocode']['addressComponent']['adcode']; 
						 
					}

						
		}
		 
		if( !empty($adcode) ){
			$areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  "); 
			
			if( !empty($areacodeone) ){
				$adcodeid = $areacodeone['id'];
				$pid = $areacodeone['pid'];
				$adcode = $adcode;
				$areainfoone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  ");   
				
				if( !empty($areainfoone) ){ 
					$adcode = $areainfoone['adcode']; 
				}
				
			}
		}
		if(!empty($adcode)){
			$this->platpsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$adcode."' ");   
			$this->pageCls->setpage(intval(IReq::get('page')),100);  
			$list = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop  ".$where."  and endtime > ".time()."  and admin_id = ".$adcode."   limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."");
		}else{
			$list = array();
		}
		$shopdata = array();
		$nowhour = date('H:i:s',time());
		$nowhour = strtotime($nowhour);
		$sellrule = new sellrule();
		foreach($list as $key=>$value){  
			$newvalue['id'] = $value['id'];
			$newvalue['shopname'] = $value['shopname'];
			$newvalue['is_open'] = $value['is_open'];
			$newvalue['starttime'] = $value['starttime'];
			$newvalue['pointcount'] = $value['sellcount'];
			$newvalue['lat'] = $value['lat'];
			$newvalue['lng'] = $value['lng']; 
			$newvalue['shoplogo'] = $value['shoplogo']; 
			$newvalue['point'] = $value['point']; 
			$newvalue['address'] = $value['address']; 
			$newvalue['shoptype'] = $value['shoptype']; 
			$newvalue['sellcount'] = $value['sellcount']; 
                        $newvalue['virtualsellcounts'] = $value['virtualsellcounts']; 
                        $newvalue['limitcost'] = $value['limitcost'];
                        $newvalue['pscost'] = $value['pscost'];

			$delvalue = array();
			if($value['shoptype'] == 0){
				$delvalue  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shopfast  where shopid = '".$value['id']."'    ");
			}else{
				$delvalue  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shopmarket  where shopid = '".$value['id']."'    ");
			}
			if(isset($delvalue['shopid'])){ 
			        $cvalue= array_merge($newvalue,$delvalue); 
					
					
					$juli = $this->GetDistance($lat, $lng, $cvalue['lat'], $cvalue['lng'],1); 
                                        $juli = $juli > 1000? round($juli/1000,2).'km':$juli.'m';
					$sellrule->setdata($cvalue['id'],1000,$cvalue['shoptype']);
					$rulist = $sellrule->get_rulelist();
					
					
					//array('1'=>'赠送','2'=>'减费用','3'=>'折扣','4'=>'免配送费')
					// $temprulelist = array();
					// foreach($rulist  as $k=>$v){
						// $temprulelist[$v['controltype']][] = $v['name'];
					// }
					$tempruleids = array();
					$temprule = array();
					foreach($rulist as $k=>$v){
						if(!in_array($v['controltype'],$tempruleids)){
							$temprule[] = $v;
							$tempruleids[] = $v['controltype'];
						}
					}
					$cvalue['cxinfo'] = $temprule;
					$cvalue['juli'] =  $juli;//'未测距';
					$cvalue['pscost'] = '0';
					$cvalue['canps'] = 0;
					$valuelist = empty($cvalue['pradiusvalue'])? unserialize($this->platpsinfo['radiusvalue']):unserialize($cvalue['pradiusvalue']);
					$juliceshi = intval($juli/1000);
                       /* if($cvalue['sendtype'] == 1){
						 $cvalue['psimg'] = Mysite::$app->config['shoppsimg'];
						 $valuelist = empty($value['pradiusvalue'])? '':unserialize($value['pradiusvalue']);
					}else{
						 $cvalue['psimg'] = Mysite::$app->config['psimg'];
						 $valuelist = empty($platpsinfo['radiusvalue'])? '':unserialize($platpsinfo['radiusvalue']);	 
					}*/
                              $shopinfo = array_merge($value, $delvalue); 
                             
                              $checkps = $this->pscost($shopinfo,$lng,$lat); 
            			      
            			       $cvalue['pscost'] = $checkps['pscost'];
                                       
			/*		 if(is_array($valuelist)){
						foreach($valuelist as $k=>$v){
                                                          
							if($juliceshi == $k){
							  $cvalue['pscost'] = $v;
                                                               
								$cvalue['canps'] = 1;
							}
						}
					}*/
					$source =  intval(IFilter::act(IReq::get('source')));
					$ios_waiting =   Mysite::$app->config['ios_waiting'];
					if($source == 1 && $ios_waiting == true){ 
						$cvalue['canps'] = 1;
					}
					$cvalue['opentype'] = '1';//1营业  0未营业
                                        
                                        $cvalue['sellcount'] = $cvalue['sellcount']+$value['virtualsellcounts'];
                                        
					$imgurl = empty($cvalue['shoplogo'])? Mysite::$app->config['shoplogo']:$cvalue['shoplogo'];
					$checkinfo = $this->shopIsopen($cvalue['is_open'],$cvalue['starttime'],$cvalue['is_orderbefore'],$nowhour);

					if($checkinfo['opentype'] != 2 && $checkinfo['opentype'] != 3){
						$cvalue['opentype'] = '0';
					}else{
						$cvalue['opentype'] = $checkinfo['opentype'];
					}
					$checkstr =  $cvalue['starttime'];
					$tempstr = array();
					if(!empty($checkstr)){
						$tempstr = explode('-',$checkstr);
					}
					$cvalue['starttime'] = count($tempstr) > 0 ? $tempstr[0]:'';  
					$cvalue['shopimg'] = Mysite::$app->config['siteurl'].$imgurl; 
					$shopdata[] = $cvalue;
			}
		}
	   
	    $this->success($shopdata);
	}
	/**
	 *  @brief 用户最近2周订单记录
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function neworder(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		 
		$ordershowtype = intval(IFilter::act(IReq::get('ordershowtype')));
		$where = "";
		if($ordershowtype > 0){
			//1 外卖
			if($ordershowtype == 1){
				$where = " and shoptype = 0 and is_goshop =0 ";
			}elseif($ordershowtype ==2){
				$where = "  and shoptype = 0 and is_goshop =1  ";
			}elseif($ordershowtype == 3){
				$where = " and shoptype = 1";
			}
			// 2预订
			// 3超市
		}
		$pagesize = intval(IFilter::act(IReq::get('pagesize')));
		$pagesize = empty($pagesize)?10:$pagesize;
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);
		$statusarr = array('0'=>'新订单','1'=>'待发货','2'=>'待确认','3'=>'已完成','4'=>'订单取消','5'=>'订单取消'); 
		$goshoparr = array('0'=>'新订单','1'=>'等待消费','2'=>'等待消费','3'=>'已完成','4'=>'订单取消','5'=>'订单取消');
		/* 获取订单数:   shopname  id  shoplogo  allcost addtime  status paystatus   paytype  */
		$nowtime = time()-14*24*60*60;
		$orderlist = $this->mysql->getarr("select id,shopname,shopid,allcost,addtime,status,paystatus,paytype,is_reback,is_goshop,is_make,is_ping,pstype from ".Mysite::$app->config['tablepre']."order where  buyeruid = ".$backinfo['uid']." ".$where."  and shoptype != 100 order by id desc  limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."");
		if(empty($orderlist)) $this->success(array());
		$backdata = array();
		//status 状态，0未使用，1已绑定，2已使用，3无效
		foreach($orderlist as $key=>$value){
			$shoptemp = $this->mysql->select_one("select shoplogo from ".Mysite::$app->config['tablepre']."shop where id = ".$value['shopid']."");
			$imgurl = empty($shoptemp['shoplogo'])? Mysite::$app->config['shoplogo']:$shoptemp['shoplogo'];
			$value['shoplogo'] =  Mysite::$app->config['siteurl'].$imgurl;
			$value['addtime'] = date('Y-m-d H:i:s',$value['addtime']);
			if($value['is_goshop'] == 1){
				$value['seestatus'] = isset($goshoparr[$value['status']])?$goshoparr[$value['status']]:'';
			}else{
				$value['seestatus'] = isset($statusarr[$value['status']])?$statusarr[$value['status']]:'';
			}
			
			$backdata[] = $value;
			// print_r($backdata);
		}
		$this->success($backdata);
	}
	/**
	 *  @brief 订单详情
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */ 
	function neworderdet(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$orderid = IFilter::act(IReq::get('orderid'));
		if(empty($orderid)) $this->message('订单获取失败');
		$orderlist = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where id=".$orderid." and buyeruid = ".$backinfo['uid']." order by id desc limit 0,20");		 
		if(empty($orderlist)) $this->message('订单为空');
		$orderdet =$this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."orderdet where order_id=".$orderid." order by id desc limit 0,20");
		
		 
		
		//自动更新  订单状态可取消
		if($orderlist['paytype'] == 1 && $orderlist['paystatus'] == 0 && $orderlist['status'] < 3){
			$checktime = time() - $orderlist['addtime'];
			if($checktime > 900){
				//说明该订单可以关闭
				if($orderlist['yhjids']>0){
					$jdata['status'] =1;
					$this->mysql->update(Mysite::$app->config['tablepre'].'juan',$jdata,"id='".$orderlist['yhjids']."'");
				}
				$cdata['status'] = 4;
				$this->mysql->update(Mysite::$app->config['tablepre'].'order',$cdata,"id='".$orderid."'");
			    $this->mysql->delete(Mysite::$app->config['tablepre'].'orderps',"orderid = '$orderid' and status !=3 ");
				/*更新订单 状态说明*/
				
				$statusdata['orderid']     =  $orderid;
				$statusdata['addtime']     =  $orderlist['addtime']+900;
				$statusdata['statustitle'] =  "自动关闭订单";
				$statusdata['ststusdesc']  =  "在线支付订单，未支付自动关闭"; 		
				$this->mysql->insert(Mysite::$app->config['tablepre'].'orderstatus',$statusdata); 
				$orderlist['status'] = '4';
				
			} 
		}
		
		
		 
		
		$orderlist['addtime'] = date('Y-m-d H:i',$orderlist['addtime']);
		$orderlist['posttime'] = date('Y-m-d',$orderlist['posttime']).' '.$orderlist['postdate'];
		$orderlist['sendtime'] = date('Y-m-d H:i',$orderlist['sendtime']);
		$orderlist['suretime'] = date('Y-m-d H:i',$orderlist['suretime']);
		$orderlist['passtime'] = date('Y-m-d H:i',$orderlist['passtime']);
		//id	dno 订单编号	shopuid 店铺UID	shopid 店铺ID	shopname 店铺名称	shopphone 店铺电话	shopaddress 店铺地址	buyeruid 购买用户ID，0未注册用户	buyername 购买热名称	buyeraddress 联系地址
		//	buyerphone 联系电话	status 状态	paytype 支付类型outpay货到支付，open_acout账户余额支付，other调用paylist	paystatus 支付状态1已支付	content 订单备注	ordertype 订餐方式1网站，2电话，3微信，4App	daycode 当天订单序
		//号	area1 二级地址名称	area2 三级地址名称	area3	cxids 促销规则ID集	cxcost 店铺促销优惠金额	yhjcost 优惠劵优惠金额	yhjids 使用优惠劵ID集	ipaddress	scoredown 积分抵扣数	is_ping 是否评价字段 1已评完 0未评	isbefore 0:普通订单，1订台订单
		//marketcost 超市商品总价	marketps 超市配送配送	shopcost 店铺商品总价	shopps 店铺配送费   addpscost 附加配送费	pstype 配送方式 0：平台1：个人	bagcost 打包费	addtime 制造时间	posttime 配送时间	passtime 审核时间	sendtime 发货时间	suretime 递增 完成时间
		//	allcost 订单实收费	buycode 订台码	othertext 其他说明	is_print	wxstatus 1商家确认，2商家取消	shoptype	is_make	is_reback	areaids	psuid	psusername	psemail	admin_id	is_goshop 0:外送 1订台/到店消费/自取

		//is_reback   is_print  is_goshop  status   paystatus     id,dno
		$ctaiarr = array();
		 $tctaiarr  =  $this->mysql->getarr("select statustitle as name , ststusdesc as  miaoshu,addtime  from ".Mysite::$app->config['tablepre']."orderstatus where orderid=".$orderid." order by addtime asc  limit 0,20");
		if(is_array($tctaiarr)){
			foreach($tctaiarr as $key=>$value){
				$value['time'] = date('m-d H:i',$value['addtime']);
				if( $value['name'] == '商家已接单' ){
					$value['phone'] = $orderlist['shopphone'];
				}else if( $value['name'] == '配送员已抢单' ){
					$value['phone'] = $orderlist['psemail'];
				}
				$ctaiarr[] = $value;
			}
		}
		
		 

		$instrolist = array(); 
		//订单类型
		if( $orderlist['is_goshop'] == 1 ){
			$backdata['ordertype'] = '到店消费';
		}elseif($orderlist['shoptype'] == 100){
			$backdata['ordertype'] = '跑腿';
		}elseif($orderlist['shoptype'] == 1){
			$backdata['ordertype'] = '超市';
		}else{
			$backdata['ordertype'] = '外卖';
		}
		 
	 
		$payarrr = array('0'=>'到付','1'=>'在线支付');
		$orderpastatus = $orderlist['paystatus'] == 1?'已支付':'未支付';
		$orderpaytype = isset($payarrr[$orderlist['paytype']])?$payarrr[$orderlist['paytype']]:'在线支付';
		//支付状态
		$backdata['paystatusintro'] = $orderpaytype.'('.$orderpastatus.')'; 
		//商品总价
		$backdata['shopcost'] = $orderlist['shopcost'];
		
		//配送费
		$backdata['shopps'] = $orderlist['shopps']; 
		//附加配送费
		$backdata['addpscost'] = $orderlist['addpscost']; 
		
		//促销优惠
		$backdata['cxcost'] = $orderlist['yhjcost']+$orderlist['cxcost'];
		//打包费
		$backdata['bagcost'] = $orderlist['bagcost']; 
		//订单总价
		$backdata['allcost'] = $orderlist['allcost']; 
        $backdata['shoptype'] = $orderlist['shoptype'];
		$backdata['is_goshop'] = $orderlist['is_goshop'];
		$backdata['pstype'] = $orderlist['pstype'];
		$backdata['posttime'] = $orderlist['posttime']; 
		$backdata['buyername'] = $orderlist['buyername']; 
		$backdata['buyerphone'] = $orderlist['buyerphone']; 
		$backdata['buyeraddress'] = $orderlist['buyeraddress']; 
		$backdata['shopid'] = $orderlist['shopid'];
		$backdata['id'] =  $orderlist['id'];
		
		 
		$backdata['shopaddress'] = $orderlist['shopaddress']; 
		$backdata['shopphone'] = $orderlist['shopphone']; 
		$backdata['content'] = $orderlist['content'];  
		$backdata['dno'] =  $orderlist['dno'];
		$backdata['addtime'] = $orderlist['addtime'];
		$backdata['posttime'] = $orderlist['posttime'];
		$backdata['sendtime'] = $orderlist['sendtime'];
		$backdata['suretime'] = $orderlist['suretime'];
		$backdata['passtime'] = $orderlist['passtime'];
		$backdata['shopname'] = $orderlist['shopname'];
		if($orderlist['shoptype'] == 100){
			$backdata['shopname'] = $orderlist['pttype'] == 1?'跑腿【帮我送】':'跑腿【帮我买】';
		}
		
		$backdata['psuid'] = $orderlist['psuid'];
		$backdata['psusername'] = $orderlist['psusername'];
		$backdata['psemail'] = $orderlist['psemail'];
		
		
		$backdata['statuslist'] = $ctaiarr;
		 
        $backdata['allowreack'] = Mysite::$app->config['allowreback'];
		$backdata['is_reback'] = $orderlist['is_reback'];
		$backdata['is_print'] = $orderlist['is_print'];
		$backdata['is_goshop'] = $orderlist['is_goshop'];
		$backdata['status'] = $orderlist['status'];
		$backdata['is_make'] = $orderlist['is_make']; 
		$backdata['paystatus'] = $orderlist['paystatus'];
		$backdata['paytype'] = $orderlist['paytype'];
		$backdata['is_ping'] = $orderlist['is_ping'];
		$backdata['shopphone'] = $orderlist['shopphone']; 
		$backdata['id'] =  $orderlist['id'];
		if($backdata['shopcost'] > 0){
			$temp['id'] = 0;
			$temp['order_id'] = 0;
			$temp['goodsid'] = 0;
			$temp['goodsname'] = '商品总价';
			$temp['goodscost'] = $backdata['shopcost'];
			$temp['goodscount'] = 0;
			$temp['status'] = 0;
			$temp['is_send'] = 0;
			$temp['shopid'] = 0;
			$orderdet[] = $temp;
		}
		
		//neworderdet  
		if($backdata['shopps'] > 0){
			$temp['id'] = 0;
			$temp['order_id'] = 0;
			$temp['goodsid'] = 0;
			$temp['goodsname'] = '配送费';
			$temp['goodscost'] = $backdata['shopps'];
			#$temp['addpscost'] = $backdata['addpscost'];//配送费
			$temp['goodscount'] = 0;
			$temp['status'] = 0;
			$temp['is_send'] = 0;
			$temp['shopid'] = 0;
			$orderdet[] = $temp;
		}
		if($backdata['shopps'] > 0){
			$temp['id'] = 0;
			$temp['order_id'] = 0;
			$temp['goodsid'] = 0;
			$temp['goodsname'] = '附加配送费';
			$temp['goodscost'] = $backdata['addpscost'];//附加配送费
			
			$temp['goodscount'] = 0;
			$temp['status'] = 0;
			$temp['is_send'] = 0;
			$temp['shopid'] = 0;
			$orderdet[] = $temp;
		}
		if($backdata['bagcost'] > 0){
			$temp['id'] = 0;
			$temp['order_id'] = 0;
			$temp['goodsid'] = 0;
			$temp['goodsname'] = '打包费';
			$temp['goodscost'] = $backdata['bagcost'];
			$temp['goodscount'] = 0;
			$temp['status'] = 0;
			$temp['is_send'] = 0;
			$temp['shopid'] = 0;
			$orderdet[] = $temp;
		}
		if($backdata['cxcost'] > 0){
			$temp['id'] = 0;
			$temp['order_id'] = 0;
			$temp['goodsid'] = 0;
			$temp['goodsname'] = '优惠金额';
			$temp['goodscost'] = $backdata['cxcost'];
			$temp['goodscount'] = 0;
			$temp['status'] = 0;
			$temp['is_send'] = 0;
			$temp['shopid'] = 0;
			$orderdet[] = $temp;
		}
		if($backdata['allcost'] > 0){
			$temp['id'] = 0;
			$temp['order_id'] = 0;
			$temp['goodsid'] = 0;
			$temp['goodsname'] = '订单实价';
			$temp['goodscost'] = $backdata['allcost'];
			$temp['goodscount'] = 0;
			$temp['status'] = 0;
			$temp['is_send'] = 0;
			$temp['shopid'] = 0;
			$orderdet[] = $temp;
		}
		
		
		
		 $backdata['psbpsyinfo'] = array();
			 
				if(  $orderlist['status'] == 2 ||  $orderlist['status'] == 3 ){
					if(  $orderlist['pstype'] == 2 &&  $orderlist['psuid'] > 0  ){
						 $psbinterface = new psbinterface(); 
						$backdata['psbpsyinfo'] = $psbinterface->getpsbclerkinfo($orderlist['psuid']);
						if( !empty($backdata['psbpsyinfo']) && !empty($backdata['psbpsyinfo']['posilnglat']) ){
							$posilnglatarr = explode(',',$backdata['psbpsyinfo']['posilnglat']);
							$posilng = $posilnglatarr[0];
							$posilat = $posilnglatarr[1];
							if( !empty($posilng) && !empty($posilat)  ){
								$backdata['psbpsyinfo']['posilnglatarr'] = $posilnglatarr;
							}else{
								$backdata['psbpsyinfo'] = array();
							}
							
						}
					}else if(   $orderlist['pstype'] == 1 &&  $orderlist['psuid'] > 0  ){
						$backdata['psbpsyinfo'] = $this->mysql->select_one("select uid,lng,lat from ".Mysite::$app->config['tablepre']."locationpsy where uid='".$orderlist['psuid']."' ");
						if( !empty($backdata['psbpsyinfo'])  &&  !empty($backdata['psbpsyinfo']['lng'])  &&  !empty($backdata['psbpsyinfo']['lat'])      ){
							$backdata['psbpsyinfo']['posilnglat'] = $backdata['psbpsyinfo']['lng'].','.$backdata['psbpsyinfo']['lat'];
						}else{
							 $backdata['psbpsyinfo'] = array();
						}
					}else{
						$backdata['psbpsyinfo'] = array();
					}
				}
		
		if( $backdata['psbpsyinfo'] == false ){
			$backdata['psbpsyinfo'] = array();
		}
		
		
		$backdata['gdlist'] = $orderdet;
	   
		$this->success($backdata);
	}
	
	function ajaxroutemapshow(){
		
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		
		$orderid = intval(IReq::get('orderid')); 
		$order = $this->mysql->select_one("select id as orderid,dno,shopid,status,pstype,psuid,psusername,psemail,shoptype,shoplat,shoplng,buyerlat,buyerlng,psyoverlng,psyoverlat from ".Mysite::$app->config['tablepre']."order where buyeruid='".$backinfo['uid']."' and id = ".$orderid.""); 
		$data['psbpsyinfo'] = array();
		if( !empty($order) ){
			
		}
		
		$data['order'] = $order;
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
		
		#print_R($data);
		$this->success($data);
				
	}
	
	
	
	
	
	
	/**
	 *  @brief 买家关闭和完成订单
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	 
	 
	 
	// 8.6修改
	function userdelorder(){
		$this->checkmemberlogin();
		$orderid = intval(IReq::get('orderid'));  
		if(empty($this->member['uid'])) $this->message('member_nologin');
		$userctlord = new userctlord($orderid,$this->member['uid'],$this->mysql);
		if($userctlord->delorder() == false){
			$this->message($userctlord->Error());
		}else{
			$this->success('success');
		}  
	}
	 
	// 8.6修改
	function newordercontrol(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$orderid = IFilter::act(IReq::get('orderid'));
        $orderinfo  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where id='".$orderid."'  ");
        if(empty($orderinfo)){
			$this->message('订单不存在');
		}
		$doname = IFilter::act(IReq::get('doname')); 
		if($doname == 'closeorder'){  
			$userctlord = new userctlord($orderid,$backinfo['uid'],$this->mysql);
			if($userctlord->unorder() == false){
				$this->message($userctlord->Error());
			}else{
				$this->success('success');
			} 
		}elseif($doname == 'sureorder'){
			$userctlord = new userctlord($orderid,$backinfo['uid'],$this->mysql);
			if($userctlord->sureorder() == false){
				$this->message($userctlord->Error());
			}else{
				$this->success('success');
			} 
		}elseif($doname =='reback'){  
			$drawbacklog = new drawbacklog($this->mysql,$this->memberCls); 
 			$drawbackdata['allcost'] = $orderinfo['allcost'];
 			$drawbackdata['orderid'] = $orderinfo['id'];
 			$drawbackdata['reason'] = trim(IFilter::act(IReq::get('reason'))); 
 			$drawbackdata['content'] = trim(IFilter::act(IReq::get('reason'))); 
  			$drawbackdata['typeid'] = $orderinfo['paytype'];
  			$drawbackdata['laiyuan'] = 'app';
  			$drawbackdata['uid'] = $backinfo['uid'];
			$check = $drawbacklog->setsavedraw($drawbackdata)->save();
			if($check == true){
				$this->success('success');  
			}else{
				 $msg = $drawbacklog->GetErr();
				$this->message($msg);
			} 
		}elseif($doname == 'delorder'){//删除订单
			$userctlord = new userctlord($orderid,$backinfo['uid'],$this->mysql);
			if($userctlord->delorder() == false){
				$this->message($userctlord->Error());
			}else{
				$this->success('success');
			}   
		}
	}
	 
	function rebackreason(){
		 
		$templist = Mysite::$app->config['drawsmlist'];
		$templist = empty($templist)?array():unserialize($templist);
		$drawsmlist = array();
		if(is_array($templist)){
			foreach($templist as $key=>$value){
				$tempc=array();
				$tempc['id'] = $key;
				$tempc['name'] = $value;
				$drawsmlist[] = $tempc;
			}
		} 
		$this->success($drawsmlist);
	}
	/**
	 *  @brief 获取订单评价信息
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function neworderpinglist(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$orderid = IFilter::act(IReq::get('orderid'));
		$orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where id=".$orderid." and buyeruid = ".$backinfo['uid']." order by id desc limit 0,20");
		if(empty($orderinfo)) $this->message('订单为空');
		if($orderinfo['status'] != 3) $this->message('订单未完成不可评价，请先完成');
		$orderdet =$this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."orderdet where order_id=".$orderid." order by id desc limit 0,20");
		if(empty($orderdet)){
			$data['is_ping'] = 1;
			$this->mysql->update(Mysite::$app->config['tablepre'].'order',$data,"id='".$orderinfo['id']."'");
			$this->message('预订座位订单不无商品不可评价');
		}
		$tempdata = array();
		foreach($orderdet as $key=>$value){
			//order_id	goodsid	goodsname	goodscost	goodscount	status	shopid	is_send
			$goodsinfo = $this->mysql->select_one("select img from ".Mysite::$app->config['tablepre']."goods where id=".$value['goodsid']." ");

			//orderid	orderdetid	shopid	goodsid	uid	content	addtime	replycontent	replytime	point 评分	is_show 0展示，1不展示
			$pingjinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."comment where goodsid=".$value['goodsid']." and orderdetid='".$value['id']."' ");
			if(!empty($pingjinfo)){
				$value['pingcontent'] = $pingjinfo['content'];
				$value['pingtime'] = date('Y-m-d',$pingjinfo['addtime']);;
				$value['point'] = intval($pingjinfo['point']);
			}else{
				$value['pingcontent'] = "";
				$value['pingtime'] = '';
				$value['point'] = '0';
			}
			if(empty($goodsinfo)){
				$value['img'] = Mysite::$app->config['siteurl'].Mysite::$app->config['shoplogo'];
			}else{
				$imgurl = empty($goodsinfo['img'])? Mysite::$app->config['shoplogo']:$goodsinfo['img'];
				$value['img'] =  Mysite::$app->config['siteurl'].$imgurl;
			}
			$tempdata[] = $value;
		}
		$this->success($tempdata);
	}
	//评价订单
	function newpingorder(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$orderdetid = IFilter::act(IReq::get('orderdetid'));
		$point = intval(IFilter::act(IReq::get('point')));
		$pointcontent = trim(IFilter::act(IReq::get('pointcontent')));
		if(empty($orderdetid)) $this->message('订单不存在');
		$orderdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."orderdet where id=".$orderdetid." ");
		if(empty($orderdet)) $this->message('订单不存在');
		$orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where id=".$orderdet['order_id']."   order by id desc limit 0,20");
		if(empty($orderinfo)) $this->message('订单不存在');
		if($orderinfo['status'] != 3) $this->message('订单状态不能评价');
		if($orderinfo['buyeruid'] != $backinfo['uid']) $this->message('订单不属于您');
		if($orderdet['status'] == 1) $this->message('该条订单记录已评价');
		$data['orderid'] = $orderinfo['id'];
		$data['orderdetid'] = $orderdetid;
		$data['shopid'] = $orderinfo['shopid'];
		$data['goodsid'] = $orderdet['goodsid'];
		$data['uid'] = $backinfo['uid'];
		$data['content'] = $pointcontent;
		$data['point'] = $point;
		$data['addtime'] = time();
		//更新订单详情表数据
		$udata['status'] = 1;
		$this->mysql->update(Mysite::$app->config['tablepre'].'orderdet',$udata,"id='".$orderdetid."'");
		//将评数据写到 数据表中/
		$this->mysql->insert(Mysite::$app->config['tablepre'].'comment',$data);
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
		if(intval(Mysite::$app->config['commenttype']) > 0 && $issong == 1) { //赠送积分 大于0赠送积分到用户帐号  赠送基础积分
			$scoreadd = Mysite::$app->config['commenttype'];
			$checktime = date('Y-m-d',time());
			$checktime = strtotime($checktime);
			$checklog = $this->mysql->select_one("select sum(result) as jieguo from ".Mysite::$app->config['tablepre']."memberlog where type = 1 and   userid = ".$backinfo['uid']." and addtype =1 and  addtime > ".$checktime);
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
				$this->mysql->update(Mysite::$app->config['tablepre'].'member','`score`=`score`+'.$scoreadd,"uid='".$backinfo['uid']."'");
				$fscoreadd =$scoreadd;
				$memberallcost = $backinfo['score']+$scoreadd;
				$this->memberCls->addlog($backinfo['uid'],1,1,$scoreadd,'评价商品','评价商品'.$orderdet['goodsname'].'获得'.$scoreadd.'积分',$memberallcost);
			}
		}
		// 查询子订单是否所有的状态都为 1，  是的话更新订单标志
		$shuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$orderinfo['id']."' and status = 0");
		if($shuliang < 1){//订单已评价完毕
			$this->mysql->update(Mysite::$app->config['tablepre'].'order','`is_ping`=1',"id='".$orderinfo['id']."'");

			if(intval(Mysite::$app->config['commentscore']) > 0 && $issong ==  1){//扩张积分 大于0
				$scoreadd = intval(Mysite::$app->config['commentscore'])*$orderinfo['allcost'];
				$checktime = date('Y-m-d',time());
				$checktime = strtotime($checktime);
				$checklog = $this->mysql->select_one("select sum(result) as jieguo from ".Mysite::$app->config['tablepre']."memberlog where type = 1 and   userid = ".$backinfo['uid']." and addtype =1 and  addtime > ".$checktime);
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
					$this->mysql->update(Mysite::$app->config['tablepre'].'member','`score`=`score`+'.$scoreadd,"uid='".$backinfo['uid']."'");
					$memberallcost = $backinfo['score']+$scoreadd+$fscoreadd;
					$this->memberCls->addlog($backinfo['uid'],1,1,$scoreadd,'评价完订单','评价完订单'.$orderinfo['dno'].'奖励，'.$scoreadd.'积分',$memberallcost);
				}
			}
		}
		//店铺平分
		$newpoint['point'] = 5;
		$shuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."comment where shopid='".$orderinfo['shopid']."' ");
		$scorall = $this->mysql->select_one("select sum(point) as allpoint from ".Mysite::$app->config['tablepre']."comment where shopid='".$orderinfo['shopid']."' ");
		if($shuliang > 0){
			$newpoint['point'] = intval($scorall['allpoint']/$shuliang);
		}
		$newpoint['pointcount'] = $shuliang;
	  
		//店铺销售数量
		$chengallshu  = $this->mysql->select_one("select sum(goodscount) as shuliang from ".Mysite::$app->config['tablepre']."orderdet where order_id in (select id from ".Mysite::$app->config['tablepre']."order where status =3 and shopid = '".$orderinfo['shopid']."') ");
		$newpoint['sellcount'] = 0 ;
		if(isset($chengallshu['shuliang'])){
			$newpoint['sellcount']  = intval($chengallshu['shuliang']);
                       
		} 
		$this->mysql->update(Mysite::$app->config['tablepre'].'shop',$newpoint,"id='".$orderinfo['shopid']."'");
		//商品评分
		$newpoint['point'] = 5;
		$shuliang  = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."comment where goodsid='".$orderdet['goodsid']."' ");
		$scorall = $this->mysql->select_one("select sum(point) as allpoint from ".Mysite::$app->config['tablepre']."comment where goodsid='".$orderdet['goodsid']."' ");
		if($shuliang > 0){
			$newpoint['point'] = intval($scorall['allpoint']/$shuliang);
		}
		$newpoint['pointcount'] = $shuliang;
		//pointcount `$key`
		$this->mysql->update(Mysite::$app->config['tablepre'].'goods',$newpoint,"id='".$orderdet['goodsid']."'");
		$this->success('success');

	}
	function getcx(){
		//以下为返回数据
		//商品总价
		//配送费
		//打包费
		//订单实价
		//配送时间列表
		//优惠券列表
		//需要提交数据   lng lat  shopid goodsid  goodscount
		 
		$backinfo = $this->checkappMem();
		/* if(empty($backinfo['uid'])){
			$this->message('nologin');
		} */
		$shopid = trim(IFilter::act(IReq::get('shopid')));
		$lat = IFilter::act(IReq::get('lat'));
		$lng = IFilter::act(IReq::get('lng'));
		$ids = IFilter::act(IReq::get('ids'));
		$idscount = IFilter::act(IReq::get('idscount'));
		$backdata['allcost'] = 0;
		$backdata['pscost'] = '不在配送区域';
		$backdata['surecost'] = 0;
		$backdata['bagcost'] = 0;
		$backdata['timelist'] = array();
		$backdata['cxlist'] = array();
		$backdata['yhjlist'] = array();
		$lat = empty($lat)?0:$lat;
		$lng = empty($lng)?0:$lng;
		if(empty($shopid)) $this->message('店铺数据获取失败');
		$shopinfo  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shop  where id = '".$shopid."'    ");
		
		if(empty($shopinfo)) $this->message('店铺数据获取失败');
		if($shopinfo['shoptype'] == 0){
			$shopdet  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shopfast  where shopid = '".$shopid."'    ");
		}else{
			$shopdet  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shopmarket  where shopid = '".$shopid."'    ");
		}
		if(empty($shopdet)) $this->message('店铺数未开启');
		$shop = array_merge($shopinfo,$shopdet); 
		unset($shop['intr_info']);
		unset($shop['cx_info']);
		$shop['canps'] = 0;
		if($shopinfo['is_open'] != 1) $this->message('店铺未开启');
    	$juli = $this->GetDistance($lat, $lng, $shop['lat'], $shop['lng']);
		$adcode = $shopinfo['admin_id'];
		if(!empty($adcode)){
			$this->getplatpsinfo($adcode);
		}
		$valuelist = $shop['sendtype']!=1? unserialize($this->platpsinfo['radiusvalue']):unserialize($shop['pradiusvalue']);
		$juliceshi = intval($juli/1000);

		$shop['baidupscost'] = '不在配送区域';
		if(is_array($valuelist)){
			foreach($valuelist as $k=>$v){
				if($juliceshi == $k){
  	       	        $shop['baidupscost'] = $v;
  	       	        $shop['pscost'] = $v;
					$shop['canps'] = 1;
				}
			}
		}

		$backdata['hdpay'] = Mysite::$app->config['is_daopay'];//货到付款
		$backdata['zxpay'] = Mysite::$app->config['open_acout'];//在线支付
		$source =  intval(IFilter::act(IReq::get('source')));
		$ios_waiting =   Mysite::$app->config['ios_waiting'];
	 	if($source == 1 && $ios_waiting == true){
			 $shop['baidupscost'] = $shop['pscost'];

			$shop['canps'] = 1;
	 	}
		$backdata['canps'] = $shop['canps'];
		$backdata['pscost'] = $shop['pscost'];
		// print_r($backdata['pscost']);
		$backdata['baidupscost'] = $shop['baidupscost'];
		//print_r($backdata['baidupscost']);
		if(Mysite::$app->config['plateshopid'] ==$shopid ){
			$shop['canps'] = 1;
			$backdata['pscost'] = 0;
			$backdata['canps'] = 1; 
			$backdata['baidupscost'] = 0;
		}
		$cximglist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodssign  where  type = 'cx'  order by id asc limit 0,1000");
		$ruleimg = array();
		foreach($cximglist as $key=>$value){
		    $ruleimg[$value['id']] = $value['imgurl'];
		} 
		//if(empty($ids)) $this->message('商品ID错误');
		$tempid = explode(',',$ids);
		$tempacout = explode(',',$idscount);
		//if(count($tempid) != count($tempacout)) $this->message('商品ID和商品数量错误');
		$myidlist = array();
		$querids = array();

		foreach($tempid as $key=>$value){
			$checkid = intval($value); 
			if($checkid > 0){
				$myidlist[$checkid] = $tempacout[$key];
				$querids[] = $checkid;
			}
		} 
		//if(count($querids) == 0) $this->message('商品数量错误');
		if(count($querids) > 0){
			$goodslist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goods  where  id in(".join(',',$querids).") order by id asc limit 0,1000");
			foreach($goodslist as $key=>$value){ 
				if($value['count'] < $myidlist[$value['id']]){
					$this->message($value['name'].'库存不足'); 
				}
				$cxinfo = $this->goodscx($value);
				$value['is_cx'] = $cxinfo['is_cx'];
				$value['cost'] = $cxinfo['cxcost'];
				// print_r($value['cost']);
				$value['zhekou'] = $cxinfo['zhekou'];
				$backdata['allcost'] += $value['cost']*$myidlist[$value['id']];
				$backdata['bagcost'] += $value['bagcost']*$myidlist[$value['id']]; 
			}
		}
		
		$pids = IFilter::act(IReq::get('pids')); 
		$pnum = IFilter::act(IReq::get('pnum'));
		if(!empty($pids)){
				$temppids = explode(',',$pids);
				$temppnum = explode(',',$pnum);
				$newid = array();
				$pidtonum = array();
				foreach($temppids as $key=>$value){
					if(!empty($value)){
					   $check1 = intval($value);
					   $check2 = intval($temppnum[$key]);
					   if($check1 > 0 && $check2 > 0){
						   $newid[] = $value;
						   $pidtonum[$value] = $check2;
					   }
				  }
			   }
			   $whereid = join(',',$newid);
			   if(!empty($whereid)){
				   $tempclist =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."product where shopid =".$shopid." and id in(".$whereid.") ");
				   foreach($tempclist as $key=>$value){
					   $dosee = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods where shopid =".$shopid." and id =".$value['goodsid']." ");
					   $dosee['gg'] = $value;
					   $dosee['count'] = $pidtonum[$value['id']];
					   $dosee['cost'] = $value['cost'];
					   
					   $cxinfo = $this->goodscx($dosee);
						$dosee['is_cx'] = $cxinfo['is_cx'];
						$dosee['cost'] = $cxinfo['cxcost'];

						$dosee['zhekou'] =$cxinfo['zhekou'];
					   
					   
					   $backdata['allcost'] += $dosee['cost']*intval($pidtonum[$value['id']]);
					    $backdata['bagcost'] += $dosee['bagcost']*intval($pidtonum[$value['id']]); 
						 
				   }
				   
			   }
			
		}



        $paytype = intval(IReq::get('paytype'));
        $sellrule =new sellrule();
        $sellrule->setdata($shop['shopid'],$backdata['allcost'],$shop['shoptype'],$backinfo['uid'],4,$paytype);
		$ruleinfo = $sellrule->getdata();
		
		$downcost = $ruleinfo['downcost'];
        $backdata['cxdet'] = empty($ruleinfo['cxdet'])?array():$ruleinfo['cxdet'];
		if(!empty($tempid)){
			foreach($tempid  as $v){
				if(!empty($v)){
					$godinfo =	$this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods where id=".$v." and shopid = ".$shopid." ");
					$is_cx = $this->goodscx($godinfo);
					if($is_cx['is_cx'] == 1){
						$downcost = 0;
                        $ruleinfo['nops']  = false;
						break;
					}
				}

			}
		}

		 $d =date("w") == 0?7:date("w");
		if(!empty($ruleinfo['cxids'])){
			$cxrule = $this->mysql->getarr("select name,signid,controltype,presenttitle,imgurl from ".Mysite::$app->config['tablepre']."rule  where  FIND_IN_SET(".$shopid.",shopid) and status = 1   and ( limittype = 1  or ( limittype = 2 and  ".$d."  in ( limittime ) )  or ( limittype = 3 and endtime > ".time()." and starttime < ".time().")) ");
			
			$cxinfo = array(); 
			foreach($cxrule as $key=>$value){
				$value['logo'] = isset($value['imgurl'])?Mysite::$app->config['siteurl'].$value['imgurl']:'';
				$cxinfo[] = $value; 
			}
			$backdata['cxlist'] = $cxinfo;
		}
		$backdata['surecost'] = $backdata['allcost']-$downcost;
		$backdata['surecost2'] =  $backdata['surecost'];
		$backdata['pscost'] = $ruleinfo['nops'] == true?0:$backdata['pscost'];

		$backdata['canps'] = $shop['canps'];



		$backdata['surecost'] =  $backdata['surecost2']+$backdata['pscost']+$backdata['bagcost']+$backdata['addpscost'];
		 #print_r($backdata['surecost']);
		$backdata['downcost'] = $downcost;
		// print_r($backdata['downcost']);
	  //获取所有促销 
	    $nowhout = strtotime(date('Y-m-d',time()));//当天最小linux 时间
		$timelist = !empty($shop['postdate'])?unserialize($shop['postdate']):array();
		$data['timelist'] = array();
		$checknow = time();
		$whilestatic = $shop['befortime'];
		$nowwhiltcheck = 0;
		while($whilestatic >= $nowwhiltcheck){
		    $startwhil = $nowwhiltcheck*86400;
			foreach($timelist as $key=>$value){
				$stime = $startwhil+$nowhout+$value['s'];
				$etime = $startwhil+$nowhout+$value['e'];
				if($etime  >= $checknow){
					$tempt = array();
					$tempt['value'] = $value['s']+$startwhil;
					$tempt['s'] = date('H:i',$nowhout+$value['s']);
					$tempt['e'] = date('H:i',$nowhout+$value['e']);
					$tempt['d'] = date('Y-m-d',$stime);
					$tempt['s'] = $tempt['d'].' '.$tempt['s'];
					$tempt['i'] =  $value['i'];
					$tempt['cost'] =  isset($value['cost'])?$value['cost']:'0';
					// print_r($tempt['cost']);
					$tempt['name'] = $stime > $checknow?$tempt['s'].'-'.$tempt['e']:'立即配送';
					$data['timelist'][] = $tempt;
				}
			}
		 
			$nowwhiltcheck = $nowwhiltcheck+1;
		}
		
		
		$backdata['timelist'] = $data['timelist'];  
		$backdata['addpscost']=$data['timelist']['cost'];
		 
		$newjuanlist = $this->mysql->getarr("select id,creattime,endtime,cost,limitcost,name,status,paytype from ".Mysite::$app->config['tablepre']."juan  where uid='".$backinfo['uid']."' and endtime > ".time()." and status = 1   ");
		 
		$availablejuan = array();
		$unavailablejuan = array();
		$checkpaytype = $paytype + 1;//接口中传来的是  货到是0  在线支付是1   但是  优惠券中  支持订单类型是   货到是1 在线支付是2
		
		foreach($newjuanlist as $k=>$v){
			$v['paytype'] = empty($v['paytype'])?'1,2':$v['paytype'];
			$v['starttime'] = date('Y-m-d',$v['creattime']);
			$v['endtime'] = date('Y-m-d',$v['endtime']);
			$v['unavailable_reason'] = array();	
			$paytypearr = array();
			$paytypearr = explode(',',$v['paytype']);
			if(($backdata['allcost'] + $backdata['bagcost']) >= $v['limitcost'] && in_array($checkpaytype,$paytypearr)){
				$v['is_available'] = 1;			   		
			    $availablejuan[] = $v;
			}else{
				$v['is_available'] = 0;
                if(($backdata['allcost'] + $backdata['bagcost']) < $v['limitcost']){
	                $v['unavailable_reason'][] = '满'.$v['limitcost'].'元可使用';
				}
				if(!(in_array($checkpaytype,$paytypearr))){
					if($checkpaytype == 1){
						$v['unavailable_reason'][] = '仅限在线支付订单使用';
					}else{
						$v['unavailable_reason'][] = '仅限货到付款订单使用';
					}
				}
				$unavailablejuan[] = $v;
			}
	
		}
		$backdata['yhjlist'] = array_merge($availablejuan,$unavailablejuan);
		$backdata['availablejuancount'] = count($availablejuan);
		
		 
		$backdata['sendtype'] = $shop['sendtype'];
		# print_r($backdata);
		$this->success($backdata);
	}
	
	private function goodscx($goodsinfo){
		//将规格转换为真实 数据 
		//array(1=>'买即送',2=>'限时直降',3=>'限时折扣',4=>'限时价');		cxtype
	/* 	 
		 if($valq['is_cx'] == 1){
				//测算促销 重新设置金额
					$cxdata = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goodscx where goodsid=".$valq['id']."  ");
					$newdata = getgoodscx($valq['cost'],$cxdata);
					
					$valq['zhekou'] = $newdata['zhekou'];
					$valq['is_cx'] = $newdata['is_cx'];
					$valq['cost'] = $newdata['cost'];
				} */
		 
		$newarray = array('cxcost'=>$goodsinfo['cost'],'oldcost'=>$goodsinfo['cost'],'zhekou'=>0,'is_cx'=>0);	
		if($goodsinfo['is_cx'] == 1){		
			$cxdata =	$this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goodscx where goodsid=".$goodsinfo['id']."  ");
			 
			$newdata = getgoodscx($goodsinfo['cost'],$cxdata);
			$newarray['oldcost'] = $goodsinfo['cost'];
			$newarray['cxcost'] = $newdata['cost'];
			$newarray['zhekou'] = $newdata['zhekou'];
			$newarray['is_cx'] = $newdata['is_cx'];
			//2016/12/27新增
			$newarray['cxnum'] = $cxdata['cxnum'];
		}
		return  $newarray;
	}
	function newmakeorder(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopid = intval(IReq::get('shopid'));
		$mobile = IFilter::act(IReq::get('mobile'));
		$yhjid = intval(IFilter::act(IReq::get('yhjid')));
		$sendtime = IFilter::act(IReq::get('pstime'));
		$contactname =  IFilter::act(IReq::get('contactname'));
		$addressdet =  IFilter::act(IReq::get('address'));
		$remark = IFilter::act(IReq::get('beizhu'));
		$ids = IFilter::act(IReq::get('ids'));
		$idscount = IFilter::act(IReq::get('idscount'));
		$payline = intval(IFilter::act(IReq::get('payline')));
		$lat = IFilter::act(IReq::get('lat'));
		$lng = IFilter::act(IReq::get('lng'));
        if(empty($addressdet))   $this->message('emptyaddress');
        if(empty($contactname))   $this->message('emptycontact');
		if(!IValidate::suremobi($mobile))   $this->message('errphone');
		$lat = empty($lat)?0:$lat;
		$lng = empty($lng)?0:$lng;
		if(empty($shopid)) $this->message('店铺数据获取失败');
		$shopinfo  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shop  where id = '".$shopid."'    ");
		if(empty($shopinfo)) $this->message('店铺数据获取失败');
		if($shopinfo['shoptype'] == 0){
			$shopdet  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shopfast  where shopid = '".$shopid."'    ");
		}else{
			$shopdet  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shopmarket  where shopid = '".$shopid."'    ");
		}
		if(empty($shopdet)) $this->message('店铺数未开启');
		$shop = array_merge($shopinfo,$shopdet); 
		if($shopinfo['is_open'] != 1) $this->message('店铺未开启');

		$juli = $this->GetDistance($lat, $lng, $shop['lat'], $shop['lng']);
		$adcode = $shopinfo['admin_id'];
		if(!empty($adcode)){
			$this->getplatpsinfo($adcode);
		}
		$valuelist = $shop['sendtype']!=1? unserialize($this->platpsinfo['radiusvalue']):unserialize($shop['pradiusvalue']);
		$juliceshi = intval($juli/1000);

		$shop['baidupscost'] = '不在配送区域';
		$shop['canps'] = 0;
		if(is_array($valuelist)){
			foreach($valuelist as $k=>$v){
				if($juliceshi == $k){
  	       	        $shop['baidupscost'] = $v;
  	       	        $shop['pscost'] = $v;
					$shop['canps'] = 1;
				}
			}
		}

		$source =  intval(IFilter::act(IReq::get('source')));
		$ios_waiting =   Mysite::$app->config['ios_waiting'];
		if($source == 1 && $ios_waiting == true){
			$shop['baidupscost'] = $shop['pscost'];
			$shop['canps'] = 1;
		}
		if(Mysite::$app->config['plateshopid'] ==$shopid ){
			$shop['canps'] = 1;
			$shop['pscost'] = 0; 
			$shop['baidupscost'] = 0;
		}

		#if($shop['canps'] == 0) $this->message('不在配送区'); 
		//if(empty($ids)) $this->message('商品ID错误');
		$tempid = explode(',',$ids);
		$tempacout = explode(',',$idscount);
		//if(count($tempid) != count($tempacout)) $this->message('商品ID和商品数量错误');
		$myidlist = array();
		$querids = array(); 
		foreach($tempid as $key=>$value){
			$checkid = intval($value); 
			if($checkid > 0){
				$myidlist[$checkid] = $tempacout[$key];
				$querids[] = $checkid;
			}
		}
		$allcost = 0;
	 	$bagcost = 0;
	 	$allshu = 0;
		$tempgooddata = array();
		if(count($querids) > 0) {
	 	
			$goodslist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goods  where  id in(".join(',',$querids).") order by id asc limit 0,1000");
			
			foreach($goodslist as $key=>$value){ 
				if($value['count'] < $myidlist[$value['id']]){
					$this->message($value['name'].'库存不足'); 
				}
				 $value['cxinfo'] = $this->goodscx($value);
				 if($value['cxinfo']['is_cx'] == 1 ){
						$value['cost'] = $value['cxinfo']['cxcost']; 
				 }
				
				
				$allcost += $value['cost']*$myidlist[$value['id']];
				$bagcost += $value['bagcost']*$myidlist[$value['id']];
				$allshu  += $myidlist[$value['id']]; 
				$value['count'] = $myidlist[$value['id']];
				$tempgooddata[] = $value; 
			}
		}
	 
		
		$pids = IFilter::act(IReq::get('pids')); 
		$pnum = IFilter::act(IReq::get('pnum'));
		if(!empty($pids)){
				$temppids = explode(',',$pids);
				$temppnum = explode(',',$pnum);
				$newid = array();
				$pidtonum = array();
				foreach($temppids as $key=>$value){
					if(!empty($value)){
					   $check1 = intval($value);
					   $check2 = intval($temppnum[$key]);
					   if($check1 > 0 && $check2 > 0){
						   $newid[] = $value;
						   $pidtonum[$value] = $check2;
					   }
				  }
			   }
			   $whereid = join(',',$newid);
			   
			   if(!empty($whereid)){
				   $tempclist =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."product where shopid =".$shopid." and id in(".$whereid.") ");
			 
				   foreach($tempclist as $key=>$value){
					   $dosee = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods where shopid =".$shopid." and id =".$value['goodsid']." ");
					   $dosee['gg'] = $value;
					   $dosee['count'] = $pidtonum[$value['id']];
					   $dosee['cost'] = $value['cost'];
					   $value['cxinfo'] = $this->goodscx($dosee);
						 if($value['cxinfo']['is_cx'] == 1 ){
								$value['cost'] = $value['cxinfo']['cxcost']; 
						 }
					   $dosee['gg']['cost'] = $value['cost'];
					   
					   $allcost += $value['cost']*intval($pidtonum[$value['id']]);
					    $bagcost += $dosee['bagcost']*intval($pidtonum[$value['id']]); 
						  $allshu += $dosee['count'];
						    $tempgooddata[] =$dosee;
						 
				   }
				   
			   }
			
		}
		 
		if(count($tempgooddata) == 0)$this->message('无商品在购物车');
	
		
		$info['ipaddress'] = '';
		$ip_l=new iplocation();
		$ipaddress=$ip_l->getaddress($ip_l->getIP());
		if(isset($ipaddress["area1"])){
		 #  $info['ipaddress']  = $ipaddress['ip'].mb_convert_encoding($ipaddress["area1"],'UTF-8','GB2312');//('GB2312','ansi',);
		   $info['ipaddress']  = $ipaddress['ip'] ;
		}
		 if($shopinfo['is_open'] != 1) $this->message('店铺暂停营业'); 
	  
		$tempdata = $this->getOpenPosttime($shop['is_orderbefore'],$shop['starttime'],$shop['postdate'],$sendtime,$shop['befortime']); 
		if($tempdata['is_opentime'] ==  2) $this->message('选择的配送时间段，店铺未设置');
		if($tempdata['is_opentime'] == 3) $this->message('选择的配送时间段已超时');
		$info['sendtime'] = $tempdata['is_posttime'];
		$info['postdate'] = $tempdata['is_postdate'];
		$info['addpscost']  = $tempdata['cost'];
		if($shop['limitcost'] > $allcost) $this->message('商品总价低于最小起送价'.$shop['limitcost']);
        $orderlistls = $this->mysql->select_one("select addtime,dnos from ".Mysite::$app->config['tablepre']."order where shopid ='".$shopinfo['id']."' order by addtime desc limit 0,1");
        $daytime = strtotime(date("Y-m-d",time())."23:59:59");
        $ntime = $daytime - $orderlistls['addtime'];
        if($ntime > 86400){
            $info['dnos']=1;
        }else{
            $info['dnos'] = $orderlistls['dnos']+1;
        }

	    $userid = $backinfo['uid'];
		$info['paytype'] = $payline == 0? '0':'1';
		$info['dikou'] = 0;
		$info['username'] = $contactname;
		$info['addressdet'] = $addressdet;
		$info['mobile'] = $mobile;
		$info['juanid'] = $yhjid;
		$info['ordertype'] = IFilter::act(IReq::get('ordertype'));//订单类型
		$info['ordertype'] = empty($info['ordertype'])?'4':$info['ordertype'];
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		if(strpos($userAgent,"iPhone") || strpos($userAgent,"iPad") || strpos($userAgent,"iPod")){
			$info['ordertype'] = 6;
		}
		$info['othercontent'] = ''; 
		$info['shopid'] = $shopid;
		$info['remark'] = $remark;//备注 

		$info['cattype'] = 0;//
		$info['userid'] = $userid; 
		$info['areaids'] = '';

		 
		    

		$a = $this->mysql->select_one("select stationis_open from ".Mysite::$app->config['tablepre']."stationadmininfo  where cityid=".$adcode."");

        
        if($a['stationis_open'] == 1) $this->message('分站已关闭');
		  

		$info['shopinfo'] = $shop;
		$info['allcost'] = $allcost;
		$info['bagcost'] = $bagcost;
		$info['allcount'] = $allshu;
		$info['shopps'] = $shop['pscost'];
		$info['goodslist']   = $tempgooddata; 
		$info['pstype'] = $shop['sendtype'];
		$info['cattype'] = 0;//表示不是预订
		$info['is_goshop']=0;
		$info['buyerlat'] = $lat;//用户lat坐标
		$info['buyerlng'] = $lng;//用户lng坐标
	    if($shop['limitcost'] > $info['allcost']) $this->message('商品总价低于最小起送价'.$shop['limitcost']);
		$checkpstype = Mysite::$app->config['psbopen']; 
		if($shop['sendtype'] == 2){
			$info['pstype'] =$checkpstype == 1? 2:0;
		}else{
			$info['pstype'] = $shop['sendtype'];
		}
		
		$orderclass = new orderclass();
		$orderclass->makenormal($info);
	    $orderid = $orderclass->getorder();
	   
		if($backinfo['uid'] ==  0){

		}else{
	      //保持地址数据
			$checkinfo =   $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."address where userid='".$backinfo['uid']."'  ");
			if(empty($checkinfo)){
				$addata['userid'] = $backinfo['uid'];
				$addata['username'] = $backinfo['username'];
				$addata['address'] = $addressdet;
				$addata['phone'] = $mobile;
				$addata['contactname'] = $contactname;
				$addata['default'] = 1;
				$this->mysql->insert(Mysite::$app->config['tablepre'].'address',$addata);
			}
		}
		$this->success($orderid);
		exit;
	}
	/**
	 *  @brief 获取店铺时间列表
	 *  
	 *  @return Return_Description
	 *  
	 *  @details Details
	 */
	function gettimelist(){
		//以下为返回数据
		//商品总价
		//配送费
		//打包费
		//订单实价
		//配送时间列表
		//优惠券列表
		//需要提交数据   lng lat  shopid goodsid  goodscount
		/*
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
		$this->message('未登陆,请先登陆');
		}
		*/
		$shopid = trim(IFilter::act(IReq::get('shopid')));
		$lat = IFilter::act(IReq::get('lat'));
		$lng = IFilter::act(IReq::get('lng'));

		$lat = empty($lat)?0:$lat;
		$lng = empty($lng)?0:$lng;
		if(empty($shopid)) $this->message('店铺数据获取失败');
		$shopinfo  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shop  where id = '".$shopid."'    ");
		if(empty($shopinfo)) $this->message('店铺数据获取失败');
		if($shopinfo['shoptype'] == 0){
			$shopdet  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shopfast  where shopid = '".$shopid."'    ");
		}else{
			$shopdet  = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shopmarket  where shopid = '".$shopid."'    ");
		}
		if(empty($shopdet)) $this->message('店铺数未开启');
		$shop = array_merge($shopinfo,$shopdet);

		unset($shop['intr_info']);
		unset($shop['cx_info']);
		$nowhout = strtotime(date('Y-m-d',time()));//当天最小linux 时间
		$timelist = !empty($shop['postdate'])?unserialize($shop['postdate']):array();
		$data['timelist'] = array();
		$checknow = time();
		$whilestatic = $shop['befortime'];
		$nowwhiltcheck = 0;
		while($whilestatic >= $nowwhiltcheck){
		    $startwhil = $nowwhiltcheck*86400;
			foreach($timelist as $key=>$value){
				$stime = $startwhil+$nowhout+$value['s'];
				$etime = $startwhil+$nowhout+$value['e'];
				if($etime  >= $checknow){
					$tempt = array();
					$tempt['value'] = $value['s']+$startwhil;
					$tempt['s'] = date('H:i',$nowhout+$value['s']);
					$tempt['e'] = date('H:i',$nowhout+$value['e']);
					$tempt['d'] = date('Y-m-d',$stime);
					$tempt['s'] = $tempt['d'].' '.$tempt['s'];
					$tempt['i'] =  $value['i'];
					$tempt['cost'] =  isset($value['cost'])?$value['cost']:'0'; 
					$tempt['name'] = $stime > $checknow?$tempt['s'].'-'.$tempt['e']:'立即配送'; 
					$data['timelist'][] = $tempt;
				}
			}
		 
			$nowwhiltcheck = $nowwhiltcheck+1;
		}
		$backdata['timelist'] = $data['timelist']; 
		$this->success($backdata);
	}
	function newmakezorder(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopid = intval(IReq::get('shopid'));
		$mobile = IFilter::act(IReq::get('mobile'));
		$sendtime = IFilter::act(IReq::get('pstime'));
		$yhjid = intval(IFilter::act(IReq::get('yhjid')));
		$sendtime = IFilter::act(IReq::get('pstime'));
		$contactname =  IFilter::act(IReq::get('contactname'));


		$remark = IFilter::act(IReq::get('beizhu'));
		$ids = IFilter::act(IReq::get('ids'));
		$idscount = IFilter::act(IReq::get('idscount'));
		$subtype = intval(IReq::get('subtype'));
		$peopleNum = intval(IFilter::act(IReq::get('people')));
		if($peopleNum < 1) $this->message('预订人数不能少于1人');
			$info['othercontent'] = empty($peopleNum)?'':serialize(array('人数'=>$peopleNum));
			$shopinfo=   $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id where a.shopid = '".$shopid."'    ");
			if(empty($shopinfo)) $this->message('店铺不存在');
			/*监测验证码*/ 
			if(empty($contactname)) 		  $this->message('emptycontact');
			if(!IValidate::suremobi($mobile))   $this->message('errphone');
			$info['ipaddress'] = "";
			$ip_l=new iplocation();
			$ipaddress=$ip_l->getaddress($ip_l->getIP());
			if(isset($ipaddress["area1"])){
				#$info['ipaddress']  = $ipaddress['ip'].mb_convert_encoding($ipaddress["area1"],'UTF-8','GB2312');//('GB2312','ansi',);
				$info['ipaddress']  = $ipaddress['ip'] ;
			}

			if($shopinfo['is_open'] != 1) $this->message('店铺暂停营业');
			  $tempdata = $this->getOpenPosttime($shopinfo['is_orderbefore'],$shopinfo['starttime'],$shopinfo['postdate'],$sendtime,$shopinfo['befortime']); 
			if($tempdata['is_opentime'] ==  2) $this->message('选择的配送时间段，店铺未设置');
			if($tempdata['is_opentime'] == 3) $this->message('选择的配送时间段已超时');
			$info['sendtime'] = $tempdata['is_posttime'];
			$info['postdate'] = $tempdata['is_postdate'];
			 $info['addpscost'] = $tempdata['cost'];
	  
	 
			$info['userid'] = $backinfo['uid'];
			$subtype = intval(IReq::get('subtype'));
			$info['shopid'] = $shopid;//店铺ID
			$info['remark'] = $remark;//备注
			$info['paytype'] = '0';//支付方式
			$info['username'] = $contactname;
			$info['mobile'] = $mobile;
			$info['addressdet'] = '';

			$info['juanid']  = '';//优惠劵ID
			$info['ordertype'] = IFilter::act(IReq::get('ordertype'));//订单类型
			$info['ordertype'] = empty($info['ordertype'])?'4':$info['ordertype'];
			$info['cattype'] = 0;//
			$info['areaids'] = '';
			$info['shopinfo'] = $shopinfo;
		if($subtype == 1){
			$info['allcost'] = 0 ;
			$info['bagcost'] = 0;
			$info['allcount'] = 0;
			$info['goodslist'] = array();
		}else{
			if(empty($info['shopid'])) $this->message('shop_noexit');
			$ids = IFilter::act(IReq::get('ids'));
			$idscount = IFilter::act(IReq::get('idscount'));
			if(empty($ids)) $this->message('商品ID错误');
			$tempid = explode(',',$ids);
			$tempacout = explode(',',$idscount);
			if(count($tempid) != count($tempacout)) $this->message('商品ID和商品数量错误');
			$querids = array();
			foreach($tempid as $key=>$value){
				$checkid = intval($value); 
				if($checkid > 0){
					$myidlist[$checkid] = $tempacout[$key];
					$querids[] = $checkid;
				}
			} 
			if(count($querids) == 0) $this->message('商品数量错误');
			$allcost = 0;
			$bagcost = 0;
			$allnum = 0;
			$goodslist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goods  where  id in(".join(',',$querids).") order by id asc limit 0,1000");
			$tempdata = array();
			foreach($goodslist as $key=>$value){ 
				if($value['count'] < $myidlist[$value['id']]){
					$this->message($value['name'].'库存不足'); 
				}
				$allcost += $value['cost']*$myidlist[$value['id']];
				$value['count'] = $myidlist[$value['id']];
				$allnum += $myidlist[$value['id']];
				$tempdata[] = $value;
			}
			$pids = IFilter::act(IReq::get('pids')); 
			$pnum = IFilter::act(IReq::get('pnum'));
			if(!empty($pids)){
					$temppids = explode(',',$pids);
					$temppnum = explode(',',$pnum);
					$newid = array();
					$pidtonum = array();
					foreach($temppids as $key=>$value){
						if(!empty($value)){
						   $check1 = intval($value);
						   $check2 = intval($temppnum[$key]);
						   if($check1 > 0 && $check2 > 0){
							   $newid[] = $value;
							   $pidtonum[$value] = $check2;
						   }
					  }
				   }
				   $whereid = join(',',$newid);
				   if(!empty($whereid)){
					   $tempclist =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."product where shopid =".$info['shopid']." and id in(".$whereid.") ");
					   foreach($tempclist as $key=>$value){
						   $dosee = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods where shopid =".$info['shopid']." and id =".$value['goodsid']." ");
						   $dosee['gg'] = $value;
						   $dosee['count'] = $pidtonum[$value['id']];
						   $allcost += $dosee['cost']*intval($pidtonum[$value['id']]); 
							  $allnum += $dosee['count'];
								$tempdata[] =$dosee;
					   }
					   
				   }
				
			}
			$info['allcost'] = $allcost;
			$info['goodslist']   = $tempdata;
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
	    
		$this->success($orderid); 
		exit;
	}
	function sendregphone(){
		$phone = IReq::get('phone');  
	    $type = intval(IFilter::act(IReq::get('type'))); 
		if($type == 8){
			$phone = IReq::get('tphone');  
		}
		$phonecls = new phonecode($this->mysql,$type,$phone); 

		if($phonecls->sendcode()){
             
			$this->success($phonecls->getCode());
		}else{
			$this->message($phonecls->getError());
		} 
	}
	function saveask(){
		$backinfo = $this->checkappMem();
	  	$shopid = intval(IReq::get('shopid'));
	  	$data['content'] = trim(IFilter::act(IReq::get('content')));
	  	$type = intval(IReq::get('type'));//留言类型 shop
	    if(empty($data['content'])) $this->message('ask_emptycontent');
	    if(strlen($data['content']) > 200) $this->message('ask_contentlength');
	    $data['shopid'] = empty($shopid)?'0':$shopid;
	    $data['uid'] = $backinfo['uid'];
	    $data['typeid'] = 5;
	    $data['addtime'] = time();
	    $this->mysql->insert(Mysite::$app->config['tablepre'].'ask',$data);
		  $this->success('success');
	}
	function checkupdate(){
		$apptype = trim(IFilter::act(IReq::get('apptype')));
		if($apptype == 'buyer'){
			$data['appvison'] = Mysite::$app->config['appvison1'];
			$data['appdownload'] =  Mysite::$app->config['appdownload1'];
		}elseif($apptype == 'seller'){
			$data['appvison'] = Mysite::$app->config['appvison2'];
			$data['appdownload'] =  Mysite::$app->config['appdownload2'];
		}elseif($apptype == 'psuer'){
			$data['appvison'] = Mysite::$app->config['appvison3'];
			$data['appdownload'] =  Mysite::$app->config['appdownload3'];
		}else{
			$this->message('未来定义的操作');
		}
		$this->success($data);
	}
	 
	function searchmap(){
		$searchvalue = trim(IFilter::act(IReq::get('searchvalue')));
		//http://api.map.baidu.com/place/v2/search?q=饭店&region=北京&output=json&ak=E4805d16520de693a3fe707cdc962045&
	     $content =   file_get_contents('http://api.map.baidu.com/place/v2/search?ak='.Mysite::$app->config['baidumapkey'].'&output=json&query='.$searchvalue.'&page_size=12&page_num=0&scope=1&region='.Mysite::$app->config['cityname']); 
	   echo $content;
	   exit;
	} 
	function updateimg(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}   
		$goodsid = intval(IReq::get('goodsid'));
		$goodsinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods where id='".$goodsid."' ");
		$json = new Services_JSON();
		$uploadpath = 'upload/goods/';
		$filepath = '/upload/goods/';
		$upload = new upload($uploadpath,array('gif','jpg','jpge','png'));//upload
		$file = $upload->getfile();
		if($upload->errno!=15&&$upload->errno!=0) {
			$this->message($upload->errmsg());

		}else{
			$data['img'] = $filepath.$file[0]['saveName'];
			if(!empty($goodsinfo)){
				$this->mysql->update(Mysite::$app->config['tablepre'].'goods',$data,"id='".$goodsid."'  "); 
			}
			$this->success($data);
		} 
	}
	function shoptj(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}  
        $shopinfo = $this->mysql->select_one("select id,shoptype,is_selfsitecx from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");        
	 	$data['is_selfsitecx'] = 1;
		if($shopinfo['shoptype'] == 1){
			$detailinfo = $this->mysql->select_one("select is_hui from ".Mysite::$app->config['tablepre']."shopmarket where shopid='".$shopinfo['id']."' ");     
		}else{
			$detailinfo = $this->mysql->select_one("select is_hui from ".Mysite::$app->config['tablepre']."shopfast where shopid='".$shopinfo['id']."' ");  
		}
		$data['is_hui'] = empty($detailinfo['is_hui'])?0:$detailinfo['is_hui'];
		$starttime = strtotime(date('Y-m-d',time())); 
     	$endtime = strtotime(date('Y-m-d',time()))+86399; 	
		$where2 = ' and addtime  > '.$starttime.' and addtime < '.$endtime;		
		$yuetj=  $this->mysql->select_one("select  count(id) as shuliang,sum(cxcost) as cxcost,sum(yhjcost) as yhcost, sum(shopcost) as shopcost,sum(scoredown) as score, sum(shopps)as pscost, sum(bagcost) as bagcost,sum(allcost) as doallcost from ".Mysite::$app->config['tablepre']."order  where shopuid = '".$backinfo['uid']."'  and   status = 3 ".$where2."  order by id asc  limit 0,1000");		
		$total =  $this->mysql->select_one("select sum(acountcost) as total from ".Mysite::$app->config['tablepre']."shopjs  where shopuid = '".$backinfo['uid']."'" .$where2." ");		        
		$data['allcost'] = empty($total['total'])?0:round($total['total'],2);	//营业额（即扣除佣金后的纯收入）	         
		$data['yuecost'] = intval($yuetj['shuliang']); //订单数
		#$data['allcost'] = round($yuetj['doallcost'],2);//营业额（即扣除佣金后的纯收入）
		$data['shopcost'] = $backinfo['shopcost'];//账户余额
		$plateshopid = intval(Mysite::$app->config['plateshopid']);
		if(empty($plateshopid)){
			$data['plateshopid'] = 0;
		    $data['plateshopname'] = '平台采购店';
		}else{
			$shopinfo = $this->mysql->select_one("select   * from ".Mysite::$app->config['tablepre']."shop where id='".$plateshopid."' ");
			if(empty($shopinfo)){
				$data['plateshopid'] = 0;
				$data['plateshopname'] = '平台采购店';
			}else{
				if($shopinfo['shoptype'] == 0){
					$data['plateshopid'] = 0;
					$data['plateshopname'] = '平台采购店';
				}else{
					$data['plateshopid'] = $plateshopid;
					$data['plateshopname'] = $shopinfo['shopname'];
				}
				
			}
			
		}
		
		$this->success($data); 
	}
	//2016 1.27改
	function newshoptj(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}  		
		//日统计
		$daytime = date('Y-m-d',time());
		$daytime = strtotime($daytime);
		$enddaytime = $daytime-86399;
		$wheredaytime = ' and  addtime  < '.time().' and addtime > '.$daytime;
		$yuetj=  $this->mysql->select_one("select  count(id) as shuliang,sum(cxcost) as cxcost,sum(yhjcost) as yhcost, sum(shopcost) as shopcost,sum(scoredown) as score, sum(shopps)as pscost, sum(bagcost) as bagcost,sum(allcost) as doallcost from ".Mysite::$app->config['tablepre']."order  where shopuid = '".$backinfo['uid']."'  and   status = 3 ".$wheredaytime." order by id asc  limit 0,1000");
		$alltj=  $this->mysql->counts("select  * from ".Mysite::$app->config['tablepre']."order  where shopuid = '".$backinfo['uid']."'  and status = 3  ".$wheredaytime." order by id asc  limit 0,1000");
		$data['daycost'] = round($yuetj['doallcost'],2);
		$data['daycount'] = $alltj;
		
		//周统计
		$weektime = date('Y-m-d',time());
		$weektime = strtotime($weektime);
		$endweektime = $daytime-86399*7;
		$whereweektime = ' and  addtime  < '.time().' and addtime > '.$endweektime;
		$yuetj=  $this->mysql->select_one("select  count(id) as shuliang,sum(cxcost) as cxcost,sum(yhjcost) as yhcost, sum(shopcost) as shopcost,sum(scoredown) as score, sum(shopps)as pscost, sum(bagcost) as bagcost,sum(allcost) as doallcost from ".Mysite::$app->config['tablepre']."order  where shopuid = '".$backinfo['uid']."'  and   status = 3 ".$whereweektime." order by id asc  limit 0,1000");
		$alltj=  $this->mysql->counts("select  * from ".Mysite::$app->config['tablepre']."order  where shopuid = '".$backinfo['uid']."'  and status = 3  ".$whereweektime." order by id asc  limit 0,1000");
		$data['weekcost'] = round($yuetj['doallcost'],2);
		$data['weekcount'] = $alltj;
		
		//月统计
		$monthtime = date('Y-m-d',time());
		$monthtime = strtotime($monthtime);
		$endmonthtime = $daytime-86399*30;
		$wheremonthtime = ' and  addtime  < '.time().' and addtime > '.$endmonthtime;
		$yuetj=  $this->mysql->select_one("select  count(id) as shuliang,sum(cxcost) as cxcost,sum(yhjcost) as yhcost, sum(shopcost) as shopcost,sum(scoredown) as score, sum(shopps)as pscost, sum(bagcost) as bagcost,sum(allcost) as doallcost from ".Mysite::$app->config['tablepre']."order  where shopuid = '".$backinfo['uid']."'  and   status = 3 ".$wheremonthtime." order by id asc  limit 0,1000");
		$alltj=  $this->mysql->counts("select  * from ".Mysite::$app->config['tablepre']."order  where shopuid = '".$backinfo['uid']."'  and status = 3  ".$wheremonthtime." order by id asc  limit 0,1000");
		$data['monthcost'] = round($yuetj['doallcost'],2);
		$data['monthcount'] = $alltj; 
		//日  周  30天  指定天数 
		$this->success($data); 
	}
	function shoptjsearch(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}  
		$startday = IFilter::act(IReq::get('startday'));
		$endday = IFilter::act(IReq::get('endday'));
		$starttime = strtotime($startday);
		$endtime = strtotime($endday)+86399;
		$wheremonthtime = ' and  addtime  > '.$starttime.' and addtime < '.$endtime;
		$yuetj=  $this->mysql->select_one("select  count(id) as shuliang,sum(cxcost) as cxcost,sum(yhjcost) as yhcost, sum(shopcost) as shopcost,sum(scoredown) as score, sum(shopps)as pscost, sum(bagcost) as bagcost,sum(allcost) as doallcost from ".Mysite::$app->config['tablepre']."order  where shopuid = '".$backinfo['uid']."'  and   status = 3 ".$wheremonthtime." order by id asc  limit 0,1000");
		$alltj=  $this->mysql->counts("select  * from ".Mysite::$app->config['tablepre']."order  where shopuid = '".$backinfo['uid']."'  and status = 3  ".$wheremonthtime." order by id asc  limit 0,1000");
		$data['searchcost'] = round($yuetj['doallcost'],2);
		$data['searchcount'] = $alltj; 
		$this->success($data); 
	}

	function subshow(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			 $this->message('nologin');
		}
		$orderid = intval(IReq::get('orderid'));  
		$userid = empty($backinfo['uid'])?0:$backinfo['uid']; 
		$orderid = intval(IReq::get('orderid')); 
		if(empty($orderid)) $this->message('订单获取失败');
		 
	   if($orderid < 1){ 
	  	 echo '订单获取失败';
		 exit;
	   }
	  
		$order = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where buyeruid='".$backinfo['uid']."' and id = ".$orderid."");   
		$order['ps'] = $order['shopps'];
		// 超市商品总价	 超市配送配送	shopcost 店铺商品总价	shopps 店铺配送费	pstype 配送方式 0：平台1：个人	bagc 
		if(empty($order)){ 
			echo '获取定单失败';
		} 
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
		$paylist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."paylist  where  type=0 or type=2 order by id asc limit 0,50"); 
		 
		$data['paylist'] = $paylist;
		$order['status'] = $buyerstatus[$order['status']];
		$order['showpaytype'] = $order['paytype'] == 1?'在线支付':'货到支付';
		$order['showpaystatus'] = $order['paystatus']==1?'已支付':'未支付';
		$order['addtime'] = date('Y-m-d H:i:s',$order['addtime']);
		$order['posttime'] = date('Y-m-d H:i:s',$order['posttime']); 
		$data['order'] = $order;
		$data['orderdet'] = $orderdet;
		 
		Mysite::$app->setdata($data); 
	}
	function postmsg(){ 
	    $orderid = intval(IReq::get('orderid'));
		if(empty($orderid)) {
			echo '订单号错误';
			exit;
		} 
		//$info =  mysql_query("SELECT * from `".$cfg['tablepre']."onlinelog` where id = '".$out_trade_no."' ");
	 
		 
		 $orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where id='".$orderid."'  ");  
		if(empty($orderinfo)){
		   echo '支付记录不存在';
		   exit;
		}
		if($orderinfo['is_print'] == 0 && $orderinfo['paystatus'] == 1){
				$orderclass = new orderclass();
				$orderclass->sendmess($orderinfo['id']);
				
		        $this->mysql->update(Mysite::$app->config['tablepre'].'order',array('is_print'=>1),"id ='".$orderinfo['id']."' ");
	    }
		
		$this->success('success');
	}
	function gotopay(){
		 
		 $orderid = intval(IReq::get('orderid')); 
	   		$payerrlink = IUrl::creatUrl('app/subshow/orderid/'.$orderid);    
			$errdata = array('paysure'=>false,'reason'=>'','url'=>''); 
	     
		  if(empty($orderid)){
				$backurl = IUrl::creatUrl('wxsite/index');  
				$errdata['url'] = $backurl;
				$errdata['reason'] = '订单获取失败';
				$errdata['paysure'] = false;  
				$this->showpayhtml($errdata);   

		  } 
	 	$userid = empty($this->member['uid'])?0:$backinfo['uid']; 
		if($userid == 0){
			$neworderid = ICookie::get('orderid');
			if($orderid != $neworderid) {
				$errdata['url'] = $payerrlink;
				$errdata['reason'] = '订单操作无权限';
				$errdata['paysure'] = false;  
				$this->showpayhtml($errdata);    
			}
		}
		$orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where id=".$orderid."  ");  //获取主单
	//	print_r($orderinfo);
		if(empty($orderinfo)){
			$errdata['url'] = $payerrlink;
				$errdata['reason'] = '订单数据获取失败';
				$errdata['paysure'] = false;  
				$this->showpayhtml($errdata);  
		} 
		if($userid > 0){
			if($orderinfo['buyeruid'] !=  $userid){
				$errdata['url'] = $payerrlink;
				$errdata['reason'] = '订单不属于您';
				$errdata['paysure'] = false;  
				$this->showpayhtml($errdata);  
			} 
		}
		if($orderinfo['paytype'] == 0){
			 
				$errdata['url'] = $payerrlink;
				$errdata['reason'] = '此订单是货到支付订单不可操作';
				$errdata['paysure'] = false;  
				$this->showpayhtml($errdata);  
			  
		}
		if($orderinfo['status']  > 2){
			 
				$errdata['url'] = $payerrlink;
				$errdata['reason'] = '此订单已发货或者其他状态不可操作';
				$errdata['paysure'] = false;  
				$this->showpayhtml($errdata);  
			 
		}
		//
		$paydotype = IFilter::act(IReq::get('paydotype'));
		 
	 
		 $paylist = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."paylist where  loginname = '".$paydotype."'   order by id asc limit 0,50");
		 
		if(empty($paylist)){
			$errdata['url'] = $payerrlink;
				$errdata['reason'] = '不存在的支付类型';
				$errdata['paysure'] = false;  
				$this->showpayhtml($errdata);  
		}			 
		 
		if($orderinfo['paystatus'] == 1){
			$errdata['url'] = $payerrlink;
				$errdata['reason'] = '此订单已支付';
				$errdata['paysure'] = false;  
				$this->showpayhtml($errdata); 
		 
		}
		$paydir = hopedir.'/plug/pay/'.$paydotype;
	 	if(!file_exists($paydir.'/pay.php'))
		{ 
			$errdata['url'] = $payerrlink;
				$errdata['reason'] = '支付方式文件不存在';
				$errdata['paysure'] = false;  
				$this->showpayhtml($errdata); 
			 
		} 
		$dopaydata = array('type'=>'order','upid'=>$orderid,'cost'=>$orderinfo['allcost'],'source'=>3);//支付数据   返回数据为3
		include_once($paydir.'/pay.php');   
		//调用方式  直接调用支付方式
		exit;
	}
	function showpayhtml($data){//定义函数
		$tempcontent = '';
		//array('paysure'=>false,'reason'=>'','url'=>''); 
		 $tempjs = '';
		if($data['paysure'] == true){
		$tempcontent = '<div style="margin-top:50px;background-color:#fff;">
			 <div style="height:30px;width:80%;padding-left:10%;padding-right:10%;padding-top:10%;">
			    <span style="background:url(\'http://'.Mysite::$app->config['siteurl'].'/upload/images/order_ok.png\') left no-repeat;height:30px;width:30px;background-size:100% 100%;display: inline-block;"></span>
				<div style="position:absolute;margin-left:50px;  margin-top: -30px; font-size: 20px;  font-weight: bold;  line-height: 20px;">恭喜您，支付订单成功</div>
				
			    
			</div>
			<div style="width:80%;margin:0px auto;padding-top:10px;"><font style="font-size:12px;">单号:</font><span style="padding-left:20px;font-size:12px;display: inline-block;">'.$data['reason']['dno'].'</span></div>
			<div style="width:80%;margin:0px auto;padding-top:10px;"><font style="font-size:12px;">总价:</font><span style="padding-left:20px;color:red;font-weight:bold;font-size:15px;">￥'.$data['reason']['allcost'].'元</span></div> 
			<div style="width:80%;margin:0px auto;padding-top:30px;text-align:right;"><span style="font-size:20px;color:#fff;padding:5px;background-color:red;" onClick="window.waimai.goCtrl(\'orderdet\',\'0\');">立即返回</span></div>
	   </div>';
	   $tempjs='window.onload=function(){
					 
					window.waimai.goCtrl(\'paydo\',\'0\');
				}';
		}else{//
	   $tempcontent = '<div style="margin-top:50px;background-color:#fff;">
			 <div style="height:30px;width:80%;padding-left:10%;padding-right:10%;padding-top:10%;">
			    <span style="background:url(\''.Mysite::$app->config['siteurl'].'/upload/images/nocontent.png\') left no-repeat;height:30px;width:30px;background-size:100% 100%;display: inline-block;"></span>
				<div style="position:absolute;margin-left:50px;  margin-top: -30px; font-size: 20px;  font-weight: bold;  line-height: 20px;">sorry,支付订单失败</div>
				
			    
			</div>
			<div style="width:80%;margin:0px auto;padding-top:10px;"><font style="font-size:12px;">原因:</font><span style="padding-left:20px;font-size:12px;display: inline-block;">'.$data['reason'].'</span></div> 
			<div style="width:80%;margin:0px auto;padding-top:30px;text-align:right;"><span style="font-size:20px;color:#fff;padding:5px;background-color:red;  cursor: pointer;" onClick="window.waimai.goCtrl(\'closeshow\',\'0\');">立即返回</span></div>
	   </div>';
		} 
		//onClick="windwo.waimai.goCtrl('closeshow','0');"
		$html = '<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
	<title>支付返回信息</title> 
	 
	 
 
 <script>
 	 '.$tempjs.'
</script>

 
</head>
<body style="height:100%;width:100%;margin:0px;"> 
   <div style="max-width:400px;margin:0px;margin:0px auto;min-height:300px;"> '.$tempcontent.'    </div>
	 
</body>
</html>'; 
print_r($html);
exit; 
    }
	
	/*****  2015.6.6 新增加超市分类和超市商品管理***/
    // $listtype = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid = '".$shopid."'  order by orderid asc  ");
	// $listtype =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid = '".$shopid."' and parent_id =".$newtopid." order by orderid asc  ");  
	/*
	* 超市商家获取一级商品分类
	2015-12-26修改
	*/
	function MarketFgoodstype(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		if($shopinfo['shoptype'] !=1) $this->message('店铺不是超市店铺');
		$shoptype =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and parent_id = 0 order by orderid desc");
		$tempc = array();
		foreach($shoptype as $key=>$value){ 
			$value['shuliang'] = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."goods where shopid='".$shopinfo['id']."' and typeid in(select id from ".Mysite::$app->config['tablepre']."marketcate where parent_id =".$value['id'].") order by id desc"); 
			$tempc[] = $value;
		} 
		
		
		
		$this->success($tempc);
	}
	/*
	* 超市商家删除一级商品分类
	2015-12-26修改
	*/
	function delMarketFgoostype(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		if($shopinfo['shoptype'] !=1) $this->message('店铺不是超市店铺');
		$id = intval(IFilter::act(IReq::get('id')));
		if(empty($id)) $this->message('删除ID获取失败');
		//增加个check  判断是否
		$nowtype = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and id=".$id." order by id desc"); 
		if(empty($nowtype)) $this->message('商品分类不存在');
		if($nowtype['parent_id'] != 0) $this->message('当前分类不是一级分类');
		if($nowtype['parent_id'] == 0){
		   $checkdata =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and parent_id=".$id." order by id desc"); 
			if(!empty($checkdata)) $this->message('该分类下有下级分类删除失败，删除失败');
		}else{
			$checkdata =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods where shopid='".$shopinfo['id']."' and typeid=".$id." order by id desc"); 
			if(!empty($checkdata)) $this->message('该分类下有商品，删除失败');
		}
		$this->mysql->delete(Mysite::$app->config['tablepre']."marketcate"," shopid='".$shopinfo['id']."' and id=".$id." ");
		$shoptype =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and parent_id = 0 order by orderid desc");
		$this->success($shoptype); 
	}
	/*
	* 超市 商家添加一级商品分类 
	2015-12-26修改
	*/
	function addMarketFgoostype(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		if($shopinfo['shoptype'] !=1) $this->message('店铺不是超市店铺');
		$id = intval(IFilter::act(IReq::get('id')));
		$name = trim(IFilter::act(IReq::get('name')));
		$orderid = intval(IFilter::act(IReq::get('orderid')));
		//	id	shopid 店铺ID	name 分类名称	orderid	cattype 1外卖 2订台
		if(empty($name)) $this->message('分类名称不能为空');
		$newdata['shopid'] = $shopinfo['id'];
		$newdata['name'] = $name;
		$newdata['orderid'] = $orderid; 
		$newdata['parent_id'] = 0;
/* 		$newdata['bagcost'] = intval(IFilter::act(IReq::get('bagcost')));
		$newdata['uid'] = $backinfo['uid']; */
		if($id > 0){
			$nowtype = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and id=".$id." order by id desc"); 
			if(empty($nowtype))$this->message('编辑一级分类不存在');
			if($nowtype['parent_id'] > 0) $this->message('当前分类不是一级分类');
			if($nowtype['shopid'] != $nowtype['shopid']) $this->message('当前分类不属于该店铺管理'); 
		}
		if(empty($id)){
			//新增
			$this->mysql->insert(Mysite::$app->config['tablepre']."marketcate",$newdata);
		}else{
			//编辑
			$this->mysql->update(Mysite::$app->config['tablepre'].'marketcate',$newdata,"id='".$id."' and shopid = '".$shopinfo['id']."'");
		}
		$shoptype =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and parent_id = 0 order by orderid desc");
		$this->success($shoptype);
	}
	/*
	* 超市商家获取二级商品分类
	2015-12-26修改
	*/
	function MarketTgoodstype(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$ftype = intval(IFilter::act(IReq::get('ftype')));
		if(empty($ftype)){
		   $this->message('无上级分类获取失败');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		if($shopinfo['shoptype'] !=1) $this->message('店铺不是超市店铺');
		$shoptype =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and parent_id = ".$ftype." order by orderid desc");
		$tempc = array();
		foreach($shoptype as $key=>$value){ 
			$value['shuliang'] = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."goods where shopid='".$shopinfo['id']."' and typeid   =".$value['id']."  order by id desc"); 
			$tempc[] = $value;
		}  
		
		$this->success($tempc);
	}
	/*
	* 超市商家删除二级商品分类
	2015-12-26修改
	*/
	function delMarketTgoostype(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$ftype = intval(IFilter::act(IReq::get('ftype')));
		if(empty($ftype)){
		   $this->message('无上级分类获取失败');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		if($shopinfo['shoptype'] !=1) $this->message('店铺不是超市店铺');
		
		$parenttype = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and id=".$ftype." order by id desc"); 
		if(empty($parenttype)) 			$this->message('上级分类不存在');
		if($parenttype['parent_id'] !=0) $this->message('上级分类不是一级分类'); 
		$id = intval(IFilter::act(IReq::get('id')));
		if(empty($id)) $this->message('删除ID获取失败');
		//增加个check  判断是否
		$nowtype = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and id=".$id." order by id desc"); 
		if(empty($nowtype)) $this->message('商品分类不存在');
		if($nowtype['parent_id'] ==0) $this->message('商品分类不是二级分类'); 
		if($nowtype['parent_id'] == 0){
		   $checkdata =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and parent_id=".$id." order by id desc"); 
			if(!empty($checkdata)) $this->message('该分类下有下级分类删除失败，删除失败');
		}else{
			$checkdata =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goods where shopid='".$shopinfo['id']."' and typeid=".$id." order by id desc"); 
			if(!empty($checkdata)) $this->message('该分类下有商品，删除失败');
		}
		$this->mysql->delete(Mysite::$app->config['tablepre']."marketcate"," shopid='".$shopinfo['id']."' and id=".$id." ");
		$shoptype =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and parent_id = '".$ftype."'  order by orderid desc");
		$this->success($shoptype); 
	}
	/*
	* 超市 商家添加二级商品分类 
	2015-12-26修改
	*/
	function addMarketTgoostype(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$ftype = intval(IFilter::act(IReq::get('ftype')));
		if(empty($ftype)){
		   $this->message('无上级分类获取失败');
		}
		$shopinfo= $this->mysql->select_one("select is_open as shopopentype,starttime as opentime,shopname,id,address as shopaddress,phone as shopphone,shoptype from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
		if(empty($shopinfo)) $this->message('获取店铺资料失败');
		if($shopinfo['shoptype'] !=1) $this->message('店铺不是超市店铺');
		$id = intval(IFilter::act(IReq::get('id')));
		$name = trim(IFilter::act(IReq::get('name')));
		$orderid = intval(IFilter::act(IReq::get('orderid')));
		//	id	shopid 店铺ID	name 分类名称	orderid	cattype 1外卖 2订台
		if(empty($name)) $this->message('分类名称不能为空');
		$newdata['shopid'] = $shopinfo['id'];
		$newdata['name'] = $name;
		$newdata['orderid'] = $orderid; 
		$newdata['parent_id'] = $ftype;
/* 		$newdata['bagcost'] = intval(IFilter::act(IReq::get('bagcost')));
		$newdata['uid'] = $backinfo['uid']; */
		$parenttype = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and id=".$ftype." order by id desc"); 
		if(empty($parenttype)) 			$this->message('上级分类不存在');
		if($parenttype['parent_id'] !=0) $this->message('上级分类不是一级分类');
		if($id > 0){
			$nowtype = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and id=".$id." order by id desc"); 
			if($nowtype['parent_id'] == 0) $this->message('当前分类不是二级分类');
			if($nowtype['shopid'] != $nowtype['shopid']) $this->message('当前分类不属于该店铺管理'); 
		}
		if(empty($id)){
			//新增
			$this->mysql->insert(Mysite::$app->config['tablepre']."marketcate",$newdata);
		}else{
			//编辑
			$this->mysql->update(Mysite::$app->config['tablepre'].'marketcate',$newdata,"id='".$id."' and shopid = '".$shopinfo['id']."' and parent_id = '".$ftype."' ");
		}
		$shoptype =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and parent_id = '".$ftype."' order by orderid desc");
		$this->success($shoptype);
	}
	//获取网站最新配置   ---- 获取网站加载模板
	function getnewconfig(){
		//	name 模块名称--固定写	imgurl 模块图标	is_display 0不在首页展示 1在首页展示	cnname 中文名称（统一录入 无ID 仅name关键字）	ctlname ctlname	is_install 0.APP完
	     
		$config = new config('appset.php',hopedir);   
	    $tempinfo = $config->getInfo(); 
		$data = $tempinfo;
        $data['mobilemodule']= '1';
		
		$data['is_openOnlinePay'] = Mysite::$app->config['open_acout'];
		$data['is_openDapPay'] = Mysite::$app->config['is_daopay'];
		 
		
		$data['color'] = Mysite::$app->config['color'];
		
		if( $data['color'] == 'red' ){
			#$data['colorName'] = '_'.$data['color'];
			$data['colorName'] = '';
			$data['color'] = '#FF6E6E';
  			$data['ioscolor'] = '255,110,110';
			
		}else{
			if( $data['color'] == 'green' ){ 
				$data['colorName'] = '_'.$data['color'];
				$data['color'] =  '#00CD85';
 				$data['ioscolor'] = '0,205,133';
 			}else if( $data['color'] == 'yellow' ){ 
				$data['colorName'] = '_'.$data['color'];
				$data['color'] =  '#FF7600';
 				$data['ioscolor'] = '255,118,0';
			}else{
				#$data['colorName'] = '_'.$data['color'];
				$data['colorName'] = '';
				$data['color'] = '#FF6E6E';
 				$data['ioscolor'] = '255,110,110';
			}
			
		}
		
	    $this->success($data);
		//推荐外卖商家
//热卖外卖商家
//新增外卖商家
//推荐超市
//普通超市
//Array ( [appinfo] => Array ( [APPindex] => 5 [apppayacount] => 1 [apppayonline] => 1 [appdataver] => 1 ) )
		//$data['appmodule'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."appmudel where  is_install = 1 order by name desc");
		//$data['appadv'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."marketcate where shopid='".$shopinfo['id']."' and parent_id = '".$ftype."' order by name desc");
	}
	function getnewadv(){
	    $data['appmodule'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."appmudel  order by orderid asc");
		$data['appadv'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."appadv  order by orderid asc");
	//    $data['ztylist'] =   $this->mysql->getarr("select id,name,indeximg as img,showtype,cx_type,is_custom from ".Mysite::$app->config['tablepre']."specialpage where is_show=1 and cx_type<>9 and ((is_custom =0 ) or (  is_custom =1 and showtype =1) )  order by orderid  asc"); 
	   
	 
			
	   $data['ztylist'] =   $this->mysql->getarr("select id,name,indeximg as img,showtype,cx_type,is_custom from ".Mysite::$app->config['tablepre']."specialpage where is_show=1 and ((is_custom =0 ) or (  is_custom =1 and showtype =1) or (cx_type = 9) )  order by orderid  asc"); 

			
		 

		$this->success($data);
	}
	
	
	
	function foodshow(){  	//菜品详情
		 $shopshowtype = ICookie::get('shopshowtype');
		$sellcount = intval(IReq::get('sellcount') );
		$id = intval( IReq::get('id') );
		$foodshow = $this->mysql->select_one( "select * from  ".Mysite::$app->config['tablepre']."goods where id= ".$id."  " );
		$shopid = $foodshow['shopid'];
		$shopdet  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where a.shopid = ".$shopid."   "); 
		if( empty($shopdet)){
			$shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where a.shopid = ".$shopid."   "); 
		} 
		 
		$data['shopdet'] = $shopdet;
		$data['foodshow']  = $foodshow; 
		$data['sellcount'] = $sellcount;
	#	print_r( $shopdet);
		Mysite::$app->setdata($data);
	#	print_r($foodshow);
   }
   
   //新增 获取城市平台配送配送地图范围
   function getWaimaiPsrange(){
	   
	  
	  
	   $adcode = intval(IReq::get('adcode'));
	   $cityId = 0;
	   $waimai_psrangearr = array();
	   if( !empty($adcode) ){
				$areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  "); 
				if( !empty($areacodeone) ){
					$adcodeid = $areacodeone['id'];
					$pid = $areacodeone['pid'];
   					$areainfoone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  ");   
					if( !empty($areainfoone) ){
						$cityId = $areainfoone['adcode']; 
 					}else{
						$cityId = $areacodeone['id'];
					}
				}
		} 
		
		$ddd = array();
		
	   if( $cityId > 0 ){
		   $waimai_psrange = '';
		   $platpsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$cityId."' ");   
		   if( !empty($platpsinfo) ){
			   $waimai_psrange = $platpsinfo['waimai_psrange'];
			   $waimai_psrangearr = explode('#',$waimai_psrange);
			   if(!empty($waimai_psrangearr)){
				   foreach($waimai_psrangearr as $key=>$value){
					    $aa = substr($value,2);
						$bb = substr($aa,0,-2);
						 $cccc = array();
 					    $temparr = explode('],[',$bb);
						foreach( $temparr as $key=>$val){
 							 $lnglat = explode(',',$val);
 							 $cccc[] = $lnglat;
						}
					    $ddd[] = $cccc;
				   }
			   }
 		   }	   
	   }
	   
	 # print_R($ddd);
	   $this->success($ddd);
   }
   
   //判断一个点是否在多边形中
   function pointInPolygon($checkdata,$lat,$lng){  
		 
		foreach($checkdata as $key=>$value){
		   if(count($value) < 3) continue;
		   $i = 0;
		   $j=count($value)-1;
			$oddNodes=false; 
		   for ($i=0;$i<count($value); $i++) { 
 			if((	($value[$i]['lat']< $lat && $value[$j]['lat'] >=$lat)  ||   ($value[$j]['lat']<$lat && $value[$i]['lat']>=$lat) )  ){//&&  ($value[$i]['lat']<=$lat || $value[$j]['lat']<=$lat)
				$aaa = $value[$i]['lng']+($lat-$value[$i]['lat'])/($value[$j]['lat']-$value[$i]['lat'])*($value[$j]['lng']-$value[$i]['lng']);
 				if(   $aaa  < $lng) {
  					$oddNodes=!$oddNodes;
				}
			}
				
				
				$j=$i;
		   }   
		   if($oddNodes == true){
			 return true;
		   }
			
		}
		return false;
		//return oddNodes; 
	}
    //判断传入的城市code是否存在和设置配送范围
   function checkCityCode($adcode,$lng,$lat){
 	  $canps = false;
	  
 	   $cityId = 0;
	   $waimai_psrangearr = array();
	   if( !empty($adcode) ){
				$areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  "); 
				if( !empty($areacodeone) ){
					$adcodeid = $areacodeone['id'];
					$pid = $areacodeone['pid'];
   					$areainfoone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  ");   
					if( !empty($areainfoone) ){
						$cityId = $areainfoone['adcode']; 
 					}
				}
		} 
		
		$ddd = array();
		 
	   if( $cityId > 0 ){
		   $waimai_psrange = '';
		   $platpsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$cityId."' ");   
		   if( !empty($platpsinfo) ){
			   $waimai_psrange = $platpsinfo['waimai_psrange'];
			 
 			   if(!empty($waimai_psrange)){
	  //[[113.816474,34.841423],[113.794501,34.686865],[113.654426,34.615693],[113.500617,34.633774],[113.379767,34.772641],[113.368781,34.896633],[113.517097,34.966437],[113.695624,34.967563],[113.73957,34.948429],[113.797248,34.892128],[113.817847,34.839169]]#[[113.707984,34.577258],[113.937324,34.487883],[113.941443,34.631514]]  
				   
				    $info = explode('#',$waimai_psrange);
 					$ddata = array();
					if( !empty($info) ){
						foreach($info as $key=>$value){
							if(!empty($value)){
							   $tempinfo = substr($value,1,strlen($value)-2); 
								if(!empty($tempinfo)){
									$adata = array();
									$tem = explode('],',$tempinfo);
									foreach($tem as $k=>$v){
										if(!empty($v)){
											$tempbb = substr($v,1,strlen($v)-2); 
											$tempbb = explode(',',$tempbb);
											$cnew = array('lng'=>$tempbb[0],'lat'=>$tempbb[1]);
											#$cnew = array('lng'=>$tempbb[1],'lat'=>$tempbb[0]);
											$adata[] =  $cnew;
										}
										 
									}
									if(count($adata) > 0){
										$ddata[] = $adata;
									}
								} 
							}
						}
					}  
				
					if( !empty($ddata) ){
						$result = $this->pointInPolygon($ddata,$lat,$lng);
						   
						return $result;
					}
			   } 
 		   }	   
	   } 
	   
	   
	  return $canps;
   }
   function getplatpsinfo($adcode){
	   $platpsinfo = array();
	   $areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  "); 
				if( !empty($areacodeone) ){
					$adcodeid = $areacodeone['id'];
					$pid = $areacodeone['pid'];
   					$areainfoone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  ");   
					if(!empty($areainfoone)){
						$cityid = $areainfoone['adcode'];
					}else{
						$cityid = $areacodeone['id'];;
					}
					$platpsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$cityid."' ");   
 					$this->platpsinfo = $platpsinfo;
				}
   }
   function addresslist(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		} 
		
		$shopid = intval(IReq::get('shopid'));
		$adcode = intval(IReq::get('adcode'));
	
		if( !empty($adcode) ){
			$this->getplatpsinfo($adcode); 
		 }
			 
		$page = intval(IFilter::act(IReq::get('page')));
		$pagesize = intval(IFilter::act(IReq::get('pagesize'))); 
		$pagesize = $pagesize > 0? $pagesize:10; 
		$this->pageCls->setpage($page,$pagesize);  
 	 
 		
		
		$shopinfo  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where a.shopid = ".$shopid."   "); 
		if( empty($shopinfo)){
			$shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket as a left join ".Mysite::$app->config['tablepre']."shop as b  on a.shopid = b.id  where a.shopid = ".$shopid."   "); 
		}
		if(!empty($adcode)){
			 
		}else{
			if(!empty($shopinfo)){
				$this->platpsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$shopinfo['admin_id']."' "); 
			}
		}
		
		
		$this->pageCls->setpage(intval(IReq::get('page')),10); 
		/* 获取订单数:   shopname  id  shoplogo  allcost addtime  status paystatus   paytype  */
		$nowtime = time()-14*24*60*60;
		//  从地图选择的地址
		$orderlist =array();
		$temparr = $this->mysql->getarr("select id,username,address,phone,contactname,`default`,sex,bigadr,detailadr,lat,lng,tag from ".Mysite::$app->config['tablepre']."address where  userid = ".$backinfo['uid']."   order by id desc  limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."");
		if( !empty($temparr) ){
			foreach($temparr as $key=>$value){
				if( !empty($shopid)  && !empty($shopinfo) ){ 
					$value['adcode'] = '';
					 if( $shopinfo['sendtype'] == 1 ){
							$psdata = $this->pscost($shopinfo,$value['lng'],$value['lat']);
							$value['pscost'] = $psdata['pscost'];
							$value['pstype'] = $psdata['pstype'];
							$value['canps'] = $psdata['canps'];
							$value['juli'] = $psdata['juli'];
							if( $psdata['canps'] == 1){
								$value['adcode'] = $shopinfo['admin_id'];
							}
					 }else{
						 if( $this->checkCityCode($adcode,$value['lng'],$value['lat']) ){
							$psdata = $this->pscost($shopinfo,$value['lng'],$value['lat']);
							$value['pscost'] = $psdata['pscost'];
							$value['pstype'] = $psdata['pstype'];
							$value['canps'] = $psdata['canps'];
							$value['juli'] = $psdata['juli'];
							if( $psdata['canps'] == 1){
								$value['adcode'] = $shopinfo['admin_id'];
							}
						}else{
							$value['pscost'] = 0;
							$value['pstype'] = 0;
							$value['canps'] = 0;
							$value['juli'] = 0;
						}
					 } 
					
				}else{
					$value['canps'] = 2;
				}
				
				if( !empty($value['lng']) &&  !empty($value['lat']) ){
				   $content =   file_get_contents('https://restapi.amap.com/v3/geocode/regeo?output=json&location='.$value['lng'].','.$value['lat'].'&key='.Mysite::$app->config['map_webservice_key'].'&radius=1000&extensions=all'); 
					   $backinfo  = json_decode($content,true);
					    
					  if( $backinfo['status'] == 1 && $backinfo['info'] == 'OK'){
						 $value['adcode'] = $backinfo['regeocode']['addressComponent']['adcode']; 
						 $orderlist[] = $value;
					  }  
						
				}
				
				
			}
			
		}
	 
		if(empty($orderlist)) $this->success(array());
		$backdata = $orderlist; 
		$this->success($backdata);
	}
	function deladdress(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$addresid = intval(IReq::get('addresid'));
	    $this->mysql->delete(Mysite::$app->config['tablepre']."address"," id='".$addresid."' and  userid = '".$backinfo['uid']."'"); 
		$this->success('操作成功');
	}
	function addaddress(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$addresid = intval(IReq::get('addresid'));
		$data['username'] = $backinfo['username'];//隐藏的
		
		$data['phone'] = trim(IReq::get('addressphone'));
		$data['contactname'] = trim(IReq::get('contactname'));
		$data['default'] = intval(IReq::get('default'));
		$data['sex'] = intval(IReq::get('sex'));
		$data['bigadr'] = trim(IReq::get('bigadr'));
		$data['detailadr'] = trim(IReq::get('detailadr'));
		$data['lat'] = trim(IReq::get('lat'));
		$data['lng'] = trim(IReq::get('lng'));
		$data['address'] = $data['bigadr'].$data['detailadr']; 
		$data['tag'] = intval(IReq::get('tag'));
		
		if(empty($data['contactname'])) $this->message('联系人信息不能为空');
		if(empty($data['phone'])) $this->message('请填写手机号');
		if(!IValidate::suremobi($data['phone'])) $this->message('手机号格式不正确'); 
//		if(empty($data['bigadr'])) $this->message('请选择地址');
		if(empty($data['lat'])) $this->message('坐标获取失败');
		if(empty($data['lng'])) $this->message('坐标获取失败');
		if(empty($data['detailadr'])) $this->message('请填写具体地址');
		if(empty($data['address'])) $this->message('地区信息不能为空');
		
	    if($data['default'] ==1){
			$cdata['default'] = 0;
			$this->mysql->update(Mysite::$app->config['tablepre'].'address',$cdata,"  userid = '".$backinfo['uid']."'   ");
		}
		if($addresid == 0){
			//新增
			$data['userid'] =$backinfo['uid'];
			 
			$this->mysql->insert(Mysite::$app->config['tablepre']."address",$data);
			$this->success('新增成功');
		}else{
			//编辑
			$this->mysql->update(Mysite::$app->config['tablepre'].'address',$data,"id='".$addresid."' and userid = '".$backinfo['uid']."'   ");
			$this->success('编辑成功');
		} 
	}
	function setdefaddress(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
	    $addresid = intval(IReq::get('addresid'));
		
			
	    $checkinfo =  $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."address where id= '".$addresid."' and  userid = ".$backinfo['uid']."   order by id desc  limit 0,10");
		if(empty($checkinfo)){
			$this->message('地址信息不存在');
		} 
			$cdata['default'] = 0;
			$this->mysql->update(Mysite::$app->config['tablepre'].'address',$cdata,"  userid = '".$backinfo['uid']."'   ");
			$this->mysql->update(Mysite::$app->config['tablepre'].'address',array('default'=>1)," id='".$addresid."' and  userid = '".$backinfo['uid']."'   ");
       $this->success('操作成功');   
   }
   
   
    
	//充值卡充值
	function exchangcard(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$card = trim(IFilter::act(IReq::get('card')));
		$password = trim(IFilter::act(IReq::get('password')));
		if(empty($card)) $this->message('card_emptycard');
		if(empty($password)) $this->message('card_emptycardpwd');
		$checkinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."card where card ='".$card."'  and card_password = '".$password."' and uid =0 and status = 0");
		if(empty($checkinfo)) $this->message('card_cardiuser');
		$arr['uid'] = $backinfo['uid'];
		$arr['status'] =  1;
		$arr['username'] = $backinfo['username'];
		$this->mysql->update(Mysite::$app->config['tablepre'].'card',$arr,"card ='".$card."'  and card_password = '".$password."' and uid =0 and status = 0");
		//`$key`
		$this->mysql->update(Mysite::$app->config['tablepre'].'member','`cost`=`cost`+'.$checkinfo['cost'],"uid ='".$backinfo['uid']."' ");
		$allcost = $backinfo['cost']+$checkinfo['cost'];
		$this->memberCls->addlog($backinfo['uid'],2,1,$checkinfo['cost'],'充值卡充值','使用充值卡'.$checkinfo['card'].'充值'.$checkinfo['cost'].'元',$allcost);
		$this->success($allcost);
	}
	//资金记录
	function paylog(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		
		 
		$page = intval(IFilter::act(IReq::get('page')));
		$pagesize = intval(IFilter::act(IReq::get('pagesize'))); 
		$pagesize = $pagesize > 0? $pagesize:10;
		
		$this->pageCls->setpage($page,$pagesize);  
		$backdata = array();
	 
		$memberlog = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."memberlog   where userid ='".$backinfo['uid']."' and   type=2   order by id desc limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()." ");
		
		foreach($memberlog as $key=>$value){
			 $value['addtime'] = date('Y-m-d H:i',$value['addtime']);
			 $backdata[] = $value;
		}
		$this->success($backdata); 
	}
	
	function scorelog(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		
		 
		$page = intval(IFilter::act(IReq::get('page')));
		$pagesize = intval(IFilter::act(IReq::get('pagesize'))); 
		$pagesize = $pagesize > 0? $pagesize:10;
		
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);  
		$backdata = array();
		//
		$memberlog = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."memberlog   where userid ='".$backinfo['uid']."' and   type=1   order by id desc limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()." ");
		
		foreach($memberlog as $key=>$value){
			 $value['addtime'] = date('Y-m-d H:i',$value['addtime']);
			 $backdata[] = $value;
		}
		$this->success($backdata); 
	}
	function pingall(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		
		
		$orderid = intval( IFilter::act(IReq::get('orderid')) );
		$orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where buyeruid='".$backinfo['uid']."' and id = ".$orderid."");  
		if($orderinfo['is_ping'] == 1) $this->message('order_isping');		
	    if(empty($orderinfo)) $this->message('获取此订单失败'); 
		$orderdet = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."orderdet where order_id='".$orderinfo['id']."'");  
		$data['orderid'] =   $orderinfo['id']; 
		 
		$data['shopid'] = $orderinfo['shopid'];
		if(empty($backinfo['uid'])) $this->message('获取用户失败');
		$data['uid'] = $backinfo['uid'];
		$data['addtime'] = time();
		$data['is_show'] = 0;
		$shoppointnum =  trim( IFilter::act(IReq::get('shoppointnum')) );
		$shopsudupointnum =  intval( IFilter::act(IReq::get('shopsudupointnum')) ); 
		
		if(empty($shoppointnum)) $this->message('请评论总体评价');
		if(empty($shopsudupointnum)) $this->message('请评论配送服务');
		$pointdata['point'] = $shoppointnum;
		$this->mysql->update(Mysite::$app->config['tablepre'].'order',$pointdata,"id='".$orderinfo['id']."'");
		
		
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
					$checklog = $this->mysql->select_one("select sum(result) as jieguo from ".Mysite::$app->config['tablepre']."memberlog where type = 1 and   userid = ".$backinfo['uid']." and addtype =1 and  addtime > ".$checktime);
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
						   $this->mysql->update(Mysite::$app->config['tablepre'].'member','`score`=`score`+'.$scoreadd,"uid='".$backinfo['uid']."'");
						   $fscoreadd =$scoreadd;
						 $memberallcost = $backinfo['score']+$scoreadd;
						 $this->memberCls->addlog($backinfo['uid'],1,1,$scoreadd,'评价商品','评价商品'.$orderdet['goodsname'].'获得'.$scoreadd.'积分',$memberallcost);
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
				 $checklog = $this->mysql->select_one("select sum(result) as jieguo from ".Mysite::$app->config['tablepre']."memberlog where type = 1 and   userid = ".$backinfo['uid']." and addtype =1 and  addtime > ".$checktime);
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
					   $this->mysql->update(Mysite::$app->config['tablepre'].'member','`score`=`score`+'.$scoreadd,"uid='".$backinfo['uid']."'");
					 $memberallcost = $backinfo['score']+$scoreadd+$fscoreadd;
				   $this->memberCls->addlog($backinfo['uid'],1,1,$scoreadd,'评价完订单','评价完订单'.$orderinfo['dno'].'奖励，'.$scoreadd.'积分',$memberallcost);
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
		  $newpoint['psservicepoint'] = intval($psservicepoint+$psservicepointcount);
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
	function apppaydata(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$type = IFilter::act(IReq::get('type')); 
		$cost= IFilter::act(IReq::get('cost'));
		$orderid = IFilter::act(IReq::get('orderid')); 
		$alipaydata = array(
						'paytype'=>'order',
						'orderid'=>$orderid,
						'allcost'=>'',
						'wmrid'=>'',
						'support'=>0,
						'RSA_PRIVATE'=>'MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAK/bHIp5h08b3428afV6TqpJcWboGjunLbA477+/yek7/B/RdteoYDnfPGP7t5O6qbmq2yS9a1AuMpjymcjn99eZGRN20g8jJnoUZxc6UnAmIuWfMimlJMNHpHQDc0P710Cxn4PC8YH0cLgOlQMMU33jPYmUnwLLNEZz1Mg5DwEzAgMBAAECgYB+Keq+BhZnUQ3/t88lCExrqykqtRYs+fGzXgXTQZtwM1Lc2QA0FF6E5n2DFdJMsDyYMdXq8+KLsbknNdXS52lNGXQjhM7tX/26QH9dkZ4l8ViOSPSKHFsPU7tz4t5T5TwEASZyF+bPWx7PeHJwOTn4IsS/C+6WDeHcIwEYMQOGsQJBAN93XpbfgH37FQ2AMl6PTRVeJSEwmbgqvkC5+EtmmQRRAIypMBA1qnX3FtRdL00vBzjusEi5N0zgQO9/7fmc2ZUCQQDJdUtJGrz/HwimixWublffBdneBlY9SnNotbcQjsgcA/ObZLTc4cNLZE4XLSQUdc+pI1XpXzZZW+fIteHCzo2nAkEAmNU1Fg6p/H96eI9S46UyXQjUcAyjNXfWQsJt9HOo93DG5WzY+F0bxi5FqNxKe4lMcT2dxz8VeThucN6XzX3euQJAYpT5QE7LSXSgQQ8yjucELOiqElG7hcaW7xhs+rdECSGN5e7D6oq3jH8LD6BRVYnJEpVuBwNGjzfAFqGaVj/JZQJBAKp4BXKPCF1f++Vupc/E+nMSeijp03DvTeNk0UeNWcl8/Y1PTj3MZoS/Kg2PrV6YDo+QUeb75JTt5O/haDvjH2w=',
						'RSA_PUBLIC'=>'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCv2xyKeYdPG9+NvGn1ek6qSXFm6Bo7py2wOO+/v8npO/wf0XbXqGA53zxj+7eTuqm5qtskvWtQLjKY8pnI5/fXmRkTdtIPIyZ6FGcXOlJwJiLlnzIppSTDR6R0A3ND+9dAsZ+DwvGB9HC4DpUDDFN94z2JlJ8CyzRGc9TIOQ8BMwIDAQAB',
						'SELLER'=>'',
						'PARTNER'=>'',
						'Notify_Url'=>Mysite::$app->config['siteurl'].'/plug/pay/alipayapp/notify_url.php',
					  );
		$platedata = array( 
						'acountcost'=>$backinfo['cost'], 
						'support'=>0,
					  );	
		$weixindata = array( 
						'appid'=>'',
						'noncestr'=>'',
						'package'=>'Sign=WXPay',
						'partnerid'=>'',
						'prepayid'=>'',
						'timestamp'=>'',
						'sign'=>'', 
						'support'=>0,
					  );
		$weixindir = hopedir.'/plug/pay/weixinapp/'; 			  
		$weixincheck = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."paylist where  loginname ='weixinapp'   order by id asc limit 0,1");
		$alipaychek = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."paylist where  loginname ='alipayapp'   order by id asc limit 0,1");
		$acountpaychek = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."paylist where  loginname ='open_acout'   order by id asc limit 0,1");
		$allcost = 0;
		 
		$titlename = "在线充值";
		if($type == 'acount'){//余额充值 
		    $allcost = $cost;
			$titlename = "在线充值";
			if(!empty($alipaychek)){
				$dopaydata = array('type'=>'acount','upid'=>$backinfo['uid'],'cost'=>$cost,'source'=>0,'status'=>0,'addtime'=>time());//支付数据  
				$this->mysql->insert(Mysite::$app->config['tablepre'].'onlinelog',$dopaydata);
				$newid = $this->mysql->insertid(); 
				$alipaydata['paytype'] = 'acount';
				$alipaydata['allcost'] = $cost;
				$alipaydata['wmrid']=$newid;
				$alipaydata['support'] = 1;
			   $alidatat = json_decode($alipaychek['temp'],true);
				$alipaydata['SELLER'] = $alidatat['seller_email'];
				$alipaydata['PARTNER'] = $alidatat['partner'];
			}
			if(!empty($weixincheck)){
			 
				require_once $weixindir."lib/WxPay.Api.php";
				//require_once $weixindir."WxPay.JsApiPay.php";   
				$dno = 'acount_'.$backinfo['uid'];
				$dtime = time();
				$acountid = 'acount_'.time(); 
				//②、统一下单
				$input = new WxPayUnifiedOrder();
				$input->SetBody("账号充值的".$backinfo['username']);
				$input->SetAttach($dno);
				$input->SetOut_trade_no($acountid);
				$input->SetTotal_fee($cost*100);
				$input->SetTime_start(date("YmdHis"));
				$input->SetTime_expire(date("YmdHis", time() + 600));
				$input->SetTimeStamp($dtime);
				$input->SetGoods_tag('在线充值');
				$input->SetNotify_url(Mysite::$app->config['siteurl']."/plug/pay/weixinapp/notify.php");
				$input->SetTrade_type("APP");  
				//$input->SetOpenid($openId);
			    
				$ordermm = WxPayApi::unifiedOrder($input); 
				if($ordermm['error'] ==true){
					//2次签名 
					//print_r($ordermm);
					$weixindata= $ordermm['inputdata'];
					$weixindata['support'] = 1; 
					
				}else{
					
					
					
				}
			}
			 
			
		}elseif($type == 'order'){//支付订单
		   
			$orderinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where  id ='".$orderid."'   order by id asc limit 0,1");
			
			if($orderinfo['paytype'] == 1 && $orderinfo['paystatus'] == 0 && $orderinfo['status'] < 3){
				$checktime = time() - $orderinfo['addtime'];
				if($checktime > 900){
					//说明该订单可以关闭
					if($orderinfo['yhjids']>0){
                        $jdata['status'] =1;
                        $this->mysql->update(Mysite::$app->config['tablepre'].'juan',$jdata,"id='".$orderinfo['yhjids']."'");
                    }
					
					$cdata['status'] = 4;
					$this->mysql->update(Mysite::$app->config['tablepre'].'order',$cdata,"id='".$orderid."'");
					$this->mysql->delete(Mysite::$app->config['tablepre'].'orderps',"orderid = '$orderid' and status != 3 ");
					/*更新订单 状态说明*/
					$statusdata['orderid']     =  $orderid;
					$statusdata['addtime']     =  $orderinfo['addtime']+900;
					$statusdata['statustitle'] =  "自动关闭订单";
					$statusdata['ststusdesc']  =  "在线支付订单，未支付自动关闭"; 		
					$this->mysql->insert(Mysite::$app->config['tablepre'].'orderstatus',$statusdata); 
					$orderinfo['status'] = '4'; 
				} 
			} 
			if(empty($orderinfo))$this->message('订单不存在');
			if($orderinfo['paytype'] != 1) $this->message('订单不是在线支付订单');
			if($orderinfo['status'] > 1) $this->message('订单状态不能支付');
			if($orderinfo['is_make'] ==2) $this->message('商家不受理该订单不能支付');
			if($orderinfo['paytstatus'] ==1) $this->message('订单已支付不能重复支付');
			/*
			$checktime = time()-15*60;
			if($orderinfo['addtime'] < $checktime){
				 $newdata['status'] = 4; 
				$this->mysql->update(Mysite::$app->config['tablepre'].'order',$newdata,"id='".$orderid."'");
				$orderCLs = new orderclass(); 
				$orderCLs->writewuliustatus($orderinfo['id'],16,$orderinfo['paytype']);  //在线支付成功状态	 
				$this->message('订单在15分钟内未支付已取消');
			} */
			$titlename = $orderinfo['dno'];
			$allcost = $orderinfo['allcost'];
			if(!empty($alipaychek)){  
				$dopaydata = array('type'=>'order','upid'=>$orderid,'cost'=>$orderinfo['allcost'],'source'=>0,'status'=>0,'addtime'=>time());//支付数据 
				$this->mysql->insert(Mysite::$app->config['tablepre'].'onlinelog',$dopaydata);
				$newid = $this->mysql->insertid(); 
				$alipaydata['allcost'] = $orderinfo['allcost'];
				$alipaydata['wmrid']=$newid;
				$alipaydata['support'] = 1;
				$alidatat = json_decode($alipaychek['temp'],true);
				$alipaydata['SELLER'] = $alidatat['seller_email'];
				$alipaydata['PARTNER'] = $alidatat['partner'];
			}
			if(!empty($acountpaychek)){
				$platedata['support'] = 1;
				$platedata['acountcost'] = $backinfo['cost'];
			}
			if(!empty($weixincheck)){
				require_once $weixindir."lib/WxPay.Api.php";
				//require_once $weixindir."WxPay.JsApiPay.php"; 
				//②、统一下单
				$dtime = time();
				$input = new WxPayUnifiedOrder();
				$input->SetBody("支付订单".$orderinfo['dno']);
				$input->SetAttach($orderinfo['dno']);
				$input->SetOut_trade_no($orderinfo['id']);
				$input->SetTotal_fee($orderinfo['allcost']*100);
				$input->SetTime_start(date("YmdHis"));
				$input->SetTime_expire(date("YmdHis", time() + 600));
				$input->SetTimeStamp($dtime);
				$input->SetGoods_tag('订餐');
				$input->SetNotify_url(Mysite::$app->config['siteurl']."/plug/pay/weixinapp/notify.php");
				$input->SetTrade_type("APP"); 
				//$url = Mysite::$app->config['siteurl'].'/plug/pay/weixin/jsapi.php';
				//print_r($input); 
				 $ordermm = WxPayApi::unifiedOrder($input); 
				if($ordermm['error'] ==true){
					//2次签名 
					//print_r($ordermm);
					$weixindata= $ordermm['inputdata'];
					$weixindata['support'] = 1; 
					
				}else{
					
					
					
				}
				 
			}
			
			
		}elseif($type == 'yhorder'){//支付订单  
		    $orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shophuiorder where uid='".$backinfo['uid']."' and id = ".$orderid."");
			if(empty($orderinfo)) $this->message('订单不存在');
			if($orderinfo['status'] ==1) $this->message('订单已处理不能支付');
			if($orderinfo['paytstatus'] ==1) $this->message('订单已支付不能重复支付'); 
			$titlename = '优惠买单'.$orderinfo['id'];
			$allcost = $orderinfo['sjcost'];
			if(!empty($alipaychek)){  
				$dopaydata = array('type'=>'yhorder','upid'=>$orderid,'cost'=>$orderinfo['sjcost'],'source'=>0,'status'=>0,'addtime'=>time());//支付数据 
				$this->mysql->insert(Mysite::$app->config['tablepre'].'onlinelog',$dopaydata);
				$newid = $this->mysql->insertid(); 
				$alipaydata['allcost'] = $orderinfo['sjcost'];
				$alipaydata['wmrid']=$newid;
				$alipaydata['support'] = 1;
				$alipaydata['paytype'] = 'yhorder';
				$alidatat = json_decode($alipaychek['temp'],true);
				$alipaydata['SELLER'] = $alidatat['seller_email'];
				$alipaydata['PARTNER'] = $alidatat['partner'];
			}
			if(!empty($acountpaychek)){
				$platedata['support'] = 1;
				$platedata['acountcost'] = $backinfo['cost'];
				$platedata['paytype'] = 'yhorder';
			}
			if(!empty($weixincheck)){
				require_once $weixindir."lib/WxPay.Api.php";
				//require_once $weixindir."WxPay.JsApiPay.php"; 
				//②、统一下单
				$dtime = time();
				$input = new WxPayUnifiedOrder();
				$input->SetBody("支付优惠订单".$orderinfo['id']);
				$input->SetAttach($orderinfo['id']);
				$input->SetOut_trade_no('a_'.$orderinfo['id']);
				$input->SetTotal_fee($orderinfo['sjcost']*100);
				$input->SetTime_start(date("YmdHis"));
				$input->SetTime_expire(date("YmdHis", time() + 600));
				$input->SetTimeStamp($dtime);
				$input->SetGoods_tag('订餐');
				$input->SetNotify_url(Mysite::$app->config['siteurl']."/plug/pay/weixinapp/notify.php");
				$input->SetTrade_type("APP");  
				 $ordermm = WxPayApi::unifiedOrder($input); 
				if($ordermm['error'] ==true){ 
					$weixindata= $ordermm['inputdata'];
					$weixindata['support'] = 1; 
					
				}else{ 
					
				}
				 
			} 
		}else{
			$this->message('未定义的支付');
		}  
		$backdata=array(
					'alipay'=>$alipaydata,
					'plate'=>$platedata,
					'weixin'=>$weixindata,
					'allcost'=>$allcost,//待支付总金额
					'titlename'=>$titlename
		 );  	 
		$this->success($backdata);
		
	}
//账号余额支付  8.6修改
	function appacoutpay(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		if($this->checksession()){
			$type = IFilter::act(IReq::get('type')); 
			$cost= IFilter::act(IReq::get('cost'));
			$orderid = IFilter::act(IReq::get('orderid')); 
			if($type == 'order'){//支付订单 
				$orderinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where  id ='".$orderid."'   order by id asc limit 0,1");
				
				if(empty($orderinfo))$this->message('订单不存在');
				if($orderinfo['paytype'] != 1) $this->message('订单不是在线支付订单');
				if($orderinfo['status'] > 1) $this->message('订单状态不能支付');
				if($orderinfo['is_make'] ==2) $this->message('商家不受理该订单不能支付');
				if($orderinfo['paystatus'] ==1) $this->message('订单已支付不能重复支付');
			
				/*
				$checktime = time()-15*60;
				if($orderinfo['addtime'] < $checktime){
					 $newdata['status'] = 4; 
					$this->mysql->update(Mysite::$app->config['tablepre'].'order',$newdata,"id='".$orderid."'");
					$orderCLs = new orderclass(); 
					$orderCLs->writewuliustatus($orderinfo['id'],16,$orderinfo['paytype']);  //在线支付成功状态	 
					$this->message('订单在15分钟内未支付已取消');
				} */
				if(Mysite::$app->config['open_acout'] != 1) $this->message('网站开启支付');
			
				if($backinfo['cost'] < $orderinfo['allcost']) $this->message('账号余额不足');
	 
	
				$this->mysql->update(Mysite::$app->config['tablepre'].'member','`cost`=`cost`-'.$orderinfo['allcost'],"uid ='".$backinfo['uid']."' ");
				//更新订单数据 
				$orderdata['paystatus'] = 1;
				if($orderinfo['status'] == 0){
				   $orderdata['status'] = 1; 
				} 
				$orderdata['paytype_name'] = 'open_acout';
				$this->mysql->update(Mysite::$app->config['tablepre'].'order',$orderdata,"id ='".$orderid."' ");

				$accost = $backinfo['cost']-$orderinfo['allcost'];
				$this->memberCls->addlog($backinfo['uid'],2,2,$orderinfo['allcost'],'余额支付订单','支付订单'.$orderinfo['dno'].'帐号金额减少'.$orderinfo['allcost'].'元', $accost);
				$this->memberCls->addmemcostlog($orderinfo['buyeruid'],$backinfo['username'],$backinfo['cost'],2,$orderinfo['allcost'],$accost,"下单余额消费",$backinfo['uid'],$backinfo['username']);
				$checkflag = false;
				$orderCLs = new orderclass(); 
					 $orderCLs->writewuliustatus($orderinfo['id'],3,$orderinfo['paytype']);  //在线支付成功状态	 
					  if($orderinfo['is_make']  == 1 ){
					 $orderCLs->writewuliustatus($orderinfo['id'],4,$orderinfo['paytype']);  //商家自动确认接单	  
					  $auto_send = Mysite::$app->config['auto_send'];
						  if($auto_send == 1){
							 $orderCLs->writewuliustatus($orderinfo['id'],6,$orderinfo['paytype']);//订单审核后自动 商家接单后自动发货
						  }else{
							  if($orderinfo['shoptype'] != 100){
									  if($orderinfo['pstype'] == 0 ){//网站配送自动生成配送费 
									      $orderpsinfo  =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."orderps where  orderid ='".$orderid."'   ");
										  if(empty($orderpsinfo)){
											  
											  $psdata['orderid'] = $orderinfo['id'];
											  $psdata['shopid'] = $orderinfo['shopid'];
											  $psdata['status'] =0;
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
										  $checkflag = false;
											$psbinterface = new psbinterface();
											if($psbinterface->psbnoticeorder($orderid)){
												
											}
										}
								  }else{
									  $psbinterface = new psbinterface();
											if($psbinterface->paotuitopsb($orderid)){
												$checkflag = false;
											}
								  }
						  }
			}else{
				if($orderinfo['shoptype'] == 100){
					$checkflag = false;
					$psbinterface = new psbinterface();
					if($psbinterface->paotuitopsb($orderid)){
						
					}
				}
			}

				$orderCLs->sendmess($orderid); 
				$membertinfo=   $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where  uid ='".$backinfo['uid']."'   order by uid asc limit 0,1"); 
				if($checkflag == true){
					$psylist =  $this->mysql->getarr("select a.*  from ".Mysite::$app->config['tablepre']."apploginps as a left join ".Mysite::$app->config['tablepre']."member as b on a.uid = b.uid where b.admin_id = ".$orderinfo['admin_id']."");
				    $newarray = array();
				    foreach($psylist as $key=>$value){
					  if(!empty($value['userid'])){
						$newarray[] = $value['userid'];
					  }
				    }
				    if(count($newarray) > 0){
					  $psCls = new apppsyclass(); 
					  $psCls->sendmsg(join(',',$newarray),'','订单提醒','有新订单可以处理',1);
				    }
				}
				$this->success($membertinfo['cost']);
			}elseif($type == 'yhorder'){
				$orderinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shophuiorder where  id ='".$orderid."'   order by id asc limit 0,1"); 
				if(empty($orderinfo))$this->message('订单不存在'); 
				if($orderinfo['status'] == 1) $this->message('订单状态不能支付'); 
				if($orderinfo['paystatus'] ==1) $this->message('订单已支付不能重复支付'); 
				if(Mysite::$app->config['open_acout'] != 1) $this->message('网站开启支付'); 
				if($backinfo['cost'] < $orderinfo['sjcost']) $this->message('账号余额不足'); 
				$this->mysql->update(Mysite::$app->config['tablepre'].'member','`cost`=`cost`-'.$orderinfo['sjcost'],"uid ='".$backinfo['uid']."' ");
				//更新订单数据 
				$orderdata['paystatus'] = 1; 
			    $orderdata['status'] = 1;   
				$this->mysql->update(Mysite::$app->config['tablepre'].'shophuiorder',$orderdata,"id ='".$orderid."' "); 
				$accost = $backinfo['cost']-$orderinfo['sjcost'];
				$this->memberCls->addlog($backinfo['uid'],2,2,$orderinfo['sjcost'],'余额支付订单','余额优惠买单'.$orderinfo['id'].'帐号金额减少'.$orderinfo['sjcost'].'元', $accost);
				$this->memberCls->addmemcostlog($orderinfo['uid'],$backinfo['username'],$backinfo['cost'],2,$orderinfo['sjcost'],$accost,"下单优惠买单",$backinfo['uid'],$backinfo['username']);
				$membertinfo=   $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where  uid ='".$backinfo['uid']."'   order by uid asc limit 0,1");
				
				if($orderinfo['uid'] > 0){ 
					if($orderinfo['givejifen'] > 0){
						$sorce = $orderinfo['givejifen']; 
								$this->mysql->update(Mysite::$app->config['tablepre'].'member','`score`=`score`+'.$sorce,"uid ='".$membertinfo['uid']."' ");
								$allscore = $membertinfo['score']+$sorce; 
								$this->memberCls->addlog($membertinfo['uid'],1,1,$orderinfo['allcost'],'优惠买单','支付成功'.$orderinfo['dno'].'帐号赠送积分增加'.$sorce.'', $allscore);
					} 
				} 
				  
				
				$this->success($membertinfo['cost']); 
			}else{ 
				$this->message('未定义的支付');
			} 
		}else{
			$this->message('请稍后在试');
		}
	}
	 
	function  checksession(){
		 session_start(); 
		 $time = $_SESSION['expire_time'];
		 if(empty($token)){
			 $_SESSION['token'] =time(); 
			 return true;
		 }elseif($time -3 > time()){
			  $_SESSION['token'] =time(); 
			 return true;
		 }else{
			 return false;
		 } 
	} 
           
	function single(){
		$code = trim(IFilter::act(IReq::get('code')));
		$data['single'] =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."single where  code ='".$code."'   order by id asc limit 0,1");
		
	     Mysite::$app->setdata($data); 
	}
	function specialpage(){

		$id = intval(IReq::get('id'));
		$data['id'] = $id;
		$lat = trim(IReq::get('lat'));
		$lng = trim(IReq::get('lng'));
		$mapname = trim(IReq::get('mapname'));
		$data['lat'] = $lat;
		$data['lng'] = $lng;
		$data['mapname'] = $mapname;
		ICookie::set('lng',$lng,2592000);  
		ICookie::set('lat',$lat,2592000);  
		ICookie::set('mapname',$mapname,2592000);  
		
		$data['latx'] = $lat;
		$data['lngx'] = $lng; 
	 
		if( !empty($lat) &&  !empty($lng) ){
				  $content =   file_get_contents('https://restapi.amap.com/v3/geocode/regeo?output=json&location='.$lng.','.$lat.'&key='.Mysite::$app->config['map_webservice_key'].'&radius=1000&extensions=all'); 
					 $backinfo  = json_decode($content,true);
					if( $backinfo['status'] == 1 && $backinfo['info'] == 'OK'){
						$adcode = $backinfo['regeocode']['addressComponent']['adcode']; 
						 
					}  
						
		}
		
		
		if( !empty($adcode) ){
			$areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  "); 
			if( !empty($areacodeone) ){
				$adcodeid = $areacodeone['id'];
				$pid = $areacodeone['pid'];
				$adcode = $adcode;
				$areainfoone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  ");   
				if( !empty($areainfoone) ){
					$city_id = "CITY_ID_".$areainfoone['adcode'];
					$city_name = "CITY_NAME_".$areainfoone['name'];
					ICookie::set('CITY_ID',$city_id);
					ICookie::set('CITY_NAME',$city_name);
					$data['areainfoone']  = $areainfoone;
					$adcode = $areainfoone['adcode'];
				}
				
			}
		}
		$data['ctidx'] = $adcode; 
		
		$ztyinfo = $this->mysql->select_one(" select * from ".Mysite::$app->config['tablepre']."specialpage where id = ".$id."  ");
		$data['ztyinfo'] = $ztyinfo;
                #sprint_R($data['ztyinfo']);exit;
		$data['addressname'] = ICookie::get('addressname');
		 
		
		if($ztyinfo['is_custom'] == 1 && $ztyinfo['showtype'] == 0 && $ztyinfo['cx_type'] > 5 ){
            if($ztyinfo['listids']=='marketshop'){
                $link = IUrl::creatUrl('wxsite/marketshop');
                $this->message('',$link);
            }
            //8.7专题页修改
            if($ztyinfo['cx_type'] == 6){
                $link = IUrl::creatUrl("wxsite/waimai/typeid/{$ztyinfo['listids']}");
            }
            //8.7专题页修改
            if($ztyinfo['cx_type'] == 7){
                $link = IUrl::creatUrl("wxsite/marketlist/typeid/{$ztyinfo['listids']}");
            }
//			if($ztyinfo['cx_type'] == 6){
//				$link = IUrl::creatUrl('wxsite/waimai');
//			}
//			if($ztyinfo['cx_type'] == 7){
//				$link = IUrl::creatUrl('wxsite/marketlist');
//			}
			if($ztyinfo['cx_type'] == 8){
				$link = IUrl::creatUrl('wxsite/dingtai'); 
			}
			if($ztyinfo['cx_type'] == 9){
				$link = IUrl::creatUrl('wxsite/paotui'); 
			}
            //8.7专题页修改
            if($ztyinfo['cx_type'] == 11){
                $link = IUrl::creatUrl('wxsite/memsharej');
            }
			$this->message('',$link);
		}

		$speciallist = $this->getztyshowlist($ztyinfo['is_custom'],$ztyinfo['showtype'],$ztyinfo['cx_type'],$ztyinfo['listids'],$lat,$lng);

		#print_r($speciallist);		
		 
		 $data['speciallist'] = $speciallist;
		Mysite::$app->setdata($data);
	}
	function getztyshowlist($is_custom,$showtype,$cx_type,$listids,$lat,$lng){
		$cxsignlist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodssign where type='cx' order by id desc limit 0, 100");
		$cxarray  =  array();
		foreach($cxsignlist as $key=>$value){
		   $cxarray[$value['id']] = $value['imgurl'];
		}
		$weekji = date('w');
		$nowhour = date('H:i:s',time()); 
         $nowhour = strtotime($nowhour);
          $templist = array();
           $cxclass = new sellrule(); 
		    $where = '';  
 				 
    $where = empty($where)?'   and  SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradiusa`*0.01094) ': $where.' and SQRT((`lat` -'.$lat.') * (`lat` -'.$lat.' ) + (`lng` -'.$lng.' ) * (`lng` -'.$lng.' )) < (`pradiusa`*0.01094) ';
            	 
            	         
            	       
                 
					  $pageinfo = new page();
					 $pageinfo->setpage(intval(IReq::get('page')),100000000);


if($showtype == 0){    // 店铺 
       if($is_custom == 0 ){   //自定义专题页情况下
			if(!empty($listids)){
				$list = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop where id in (".$listids.") ".$where."  order by sort asc limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."  ");   		   
			}else{
				$list = array();
			}
	   }
	   if($is_custom == 1 ){  // 系统默认  cx_type 店铺 1为推荐店铺  2为满减商家 3为打折商家 4免配送费     //  private $rulecontrol = array('1'=>'赠送','2'=>'减费用','3'=>'折扣','4'=>免配送费);
		   switch ($cx_type){ 
			case 1: 
				$ztywhere =  "  and  is_recom = 1   ";
				$list = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop where is_pass = 1 ".$ztywhere."  ".$where."   order by sort asc limit ".$pageinfo->startnum().", ".$pageinfo->getsize()." ");
				break; 
			case 2:
				$list = $this->getdycxshops(2);
				break;
			case 3:
				$list = $this->getdycxshops(3);
				break;
			case 4:
				$list = $this->getdycxshops(4);
				break;
			case 5:
				$list = $this->getdycxshops(1);
				break;
			default : 
				$list = array();
				break; 
			}  
	   } 
            	   
               if(is_array($list)){
            	foreach($list as $keys=>$values){  
            	if($values['id'] > 0){						
				$templist111 = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where cattype = ".$values['shoptype']." and  parent_id = 0    order by orderid asc limit 0,1000"); 
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
						
										
										
										
										/* 店铺星级计算 */
									$zongpoint = $values['point'];
									$zongpointcount = $values['pointcount'];
									if($zongpointcount != 0 ){
										$values['shopstart'] = intval( round($zongpoint/$zongpointcount) );
									}else{
										$values['shopstart'] = 0;
									}
		 
										if($values['shoptype'] == 1 ){
											$shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket where  shopid = ".$values['id']."   ");
										}else{
											$shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast where  shopid = ".$values['id']."   ");
										}
										if(!empty($shopdet)){ 
									 	$values = array_merge($values,$shopdet);
										}
            			    			$values['shoplogo'] = empty($values['shoplogo'])? Mysite::$app->config['imgserver'].Mysite::$app->config['shoplogo']:Mysite::$app->config['imgserver'].$values['shoplogo'];
            			          $checkinfo = $this->shopIsopen($values['is_open'],$values['starttime'],$values['is_orderbefore'],$nowhour); 
            			          $values['opentype'] = $checkinfo['opentype'];
            			          $values['newstartime']  =  $checkinfo['newstartime'];  
            			          $attrdet = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopattr where  cattype = ".$values['shoptype']." and shopid = ".$values['id']."");
            			          $cxclass->setdata($values['id'],1000,$values['shoptype']);
								  if(empty($this->platpsinfo)){
										$this->platpsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$values['admin_id']."' "); 
								  
								  }

            			          $checkps = $this->pscost($values,$lng,$lat);
            			          $values['pscost'] = $checkps['pscost'];

								  
								  	  $mi = $this->GetDistance($lat,$lng, $values['lat'],$values['lng'], 1); 
									$tempmi = $mi;
								  $mi = $mi > 1000? round($mi/1000,2).'km':$mi.'m';
													  
									$values['juli'] = 		$mi;
								  
								    $firstday = strtotime( date('Y-m-01 00:00:00', strtotime(date("Y-m-d H:i:s")))	);   //当月第一天
									$lastday = strtotime( date('Y-m-d 00:00:00',strtotime("$firstday +1 month -1 day"))	);  //当月最后一天
								 
	 $shopcounts = $this->mysql->select_one( "select count(id) as shuliang  from ".Mysite::$app->config['tablepre']."order	 where suretime >= ".$firstday." and suretime <= ".$lastday."  and status = 3 and  shopid = ".$values['id']."" );
								#	print_r(  $shopcounts );
									if(empty( $shopcounts['shuliang']  )){
										$values['ordercount'] = 0;
									}else{
										$values['ordercount']  = $shopcounts['shuliang'];
									} 
								  			  
								      $cxinfo = $this->mysql->getarr("select name,id,imgurl from ".Mysite::$app->config['tablepre']."rule  where  FIND_IN_SET(".$values['id'].",shopid)   and status = 1   and ( limittype < 3  or ( limittype = 3 and endtime > ".time()." and starttime < ".time().")) ");
								      $values['cxlist'] = $cxinfo;								    
							
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


if($showtype == 1){    // 加载商品

	 if($is_custom == 0 ){   //自定义专题页情况下
			if(!empty($listids)){
 				$list = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop where is_pass = 1  ".$where."    order by id desc limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."  ");
				 
			}else{
				$list = array();
			}
			 
	   }
	   if($is_custom == 1 ){  // 系统默认  cx_type 商品1为折扣
		   switch ($cx_type){ 
			case 1:  
				$list = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop where is_pass = 1  ".$where."   order by id desc limit ".$pageinfo->startnum().", ".$pageinfo->getsize()."  ");
				break;
			default : 
				$list = array();
				break; 
			}  
	   } 
	  
			if(is_array($list)){
            			    foreach($list as $keys=>$vatt){  
            			     
           if($vatt['id'] > 0){
			   if($is_custom == 0){
					$detaa = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goods where  id in (".$listids.")  and shopid='".$vatt['id']."'  and shoptype = ".$vatt['shoptype']."  and    FIND_IN_SET( ".$weekji." , `weeks` )  ".$goodlistwhere."   order by good_order asc  limit ".$pageinfo->startnum().", ".$pageinfo->getsize()." ");
			
			  }else{
					$detaa = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goods where shopid='".$vatt['id']."'  and shoptype = ".$vatt['shoptype']."  and    FIND_IN_SET( ".$weekji." , `weeks` )  ".$goodlistwhere."   order by good_order asc limit ".$pageinfo->startnum().", ".$pageinfo->getsize()." ");
			   }
			   
					if(!empty($detaa)){
						 
				
					
						foreach ( $detaa as $keyq=>$valq ){
							if($valq['is_cx'] == 1){
							//测算促销 重新设置金额
								$cxdata = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goodscx where goodsid=".$valq['id']."  ");
								$newdata = getgoodscx($valq['cost'],$cxdata);
								
								$valq['zhekou'] = $newdata['zhekou'];
								$valq['is_cx'] = $newdata['is_cx'];
								$valq['cost'] = $newdata['cost'];
							}
							if( $shoptype == 1 ){
								 $shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket where  shopid = ".$valq['shopid']."   ");
							}else{
								  $shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast where  shopid = ".$valq['shopid']."   ");
							}
							$checkinfo = $this->shopIsopen($vatt['is_open'],$vatt['starttime'],$shopdet['is_orderbefore'],$nowhour); 
            			    $valq['opentype'] = $checkinfo['opentype'];
            			    $valq['shopname'] = $vatt['shopname'];
						//	print_r($valq['is_cx']);
							if(  $is_custom == 1){	
								if(  $valq['is_cx'] == 1 ){	
									 $templist[]  = $valq;  
								}
							}else{
								$templist[]  = $valq;
							}
						}
						
					 }	
			 
				 
									}
            	       } 
            	    }


} 
	   $data = $templist;
	  
	  return $data;
	   
	}
	function fabupaotui(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		if($backinfo['uid'] == 0)  $this->message('未登陆'); 
		
		
		$adcode = trim(IReq::get('adcode'));
		if(empty($adcode)){
			$this->message('获取所在城市失败');
		}
		
		if( !empty($adcode) ){
				$areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  "); 
  				if( !empty($areacodeone) ){
					$adcodeid = $areacodeone['id'];
					$pid = $areacodeone['pid'];
   					$areainfoone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  "); 
  					if( empty($areainfoone) ){
						 $this->message('选择的城市暂未开通');
 					}
				}
		}
		
		$ptinfoset = $this->mysql->select_one(" select * from ".Mysite::$app->config['tablepre']."paotuiset where cityid = ".$areainfoone['adcode']." "); 
		if( empty($ptinfoset) ){
			$this->message('获取跑腿规则失败~');
		}
		
		$data['admin_id'] = $areainfoone['adcode'];
		
		
		$demandcontent = trim(IFilter::act(IReq::get('demandcontent')));  // 需求内容
		 // 取货地址： 地址 补充地址  lng lat 
	//	$getaddress = trim(IReq::get('getaddress')); 
		$getdetaddress = trim(IReq::get('getdetaddress'));
		$getlng = trim(IReq::get('getlng'));
		$getlat = trim(IReq::get('getlat'));
		 // 收货地址： 地址 补充地址  lng lat 
	//	$shouaddress = trim(IReq::get('shouaddress'));
		$shouetaddress = trim(IReq::get('shouetaddress'));
		$shoulng = trim(IReq::get('shoulng'));
		$shoulat = trim(IReq::get('shoulat'));
    //帮我送物品类型和价值
	    $data['movegoodstype'] = trim(IReq::get('movegoodstype'));//类型
		$data['movegoodscost'] = trim(IReq::get('movegoodscost'));//价值
		$default = trim(IReq::get('default'));  // 取货电话
		
		$getphone = trim(IReq::get('getphone'));  // 取货电话
		$shouphone = trim(IReq::get('shouphone'));  // 收货电话
		$minit = trim(IReq::get('minit'));			// 收/取 货时间
		$ptkg = intval(IReq::get('ptkg'));	// 货 公斤 数 
		$farecost = trim(IReq::get('farecost'));		// 加价（小费） 
		$pttype = trim(IReq::get('pttype'));		// 	1为帮我送 2为帮我买
		$paytype = 1;		//  支付方式，默认为在线支付

		if( empty($demandcontent) )  $this->message("请简要填写需求内容");
		if( empty($getdetaddress) )  $this->message("获取取货地址失败,请重新获取");
		if( empty($getlng) )  $this->message("获取取货地址失败,请重新获取");
		if( empty($getlat) )  $this->message("获取取货地址失败,请重新获取");

		if( empty($shouetaddress) )  $this->message("获取收货地址失败,请重新获取");
		if( empty($shoulng) )  $this->message("获取收货地址失败,请重新获取");
		if( empty($shoulat) )  $this->message("获取收货地址失败,请重新获取");
		
		if($farecost < 0) $this->message("加价格式错误");

		if($pttype==1){
			if( empty($getphone) )  $this->message("请填写取货电话");
			if(!IValidate::suremobi($getphone))   $this->message('请输入正确的手机号'); 	
		}
		if( empty($shouphone) )  $this->message("请填写收货电话");
		if(!IValidate::suremobi($shouphone))   $this->message('请输入正确的手机号'); 	

		if( $minit == 0 ){
			 $data['sendtime'] = time();
			 $data['postdate'] = '立即取货';
		}else{ 
			$tempdata = $this->getOpenPosttime($ptinfoset['is_ptorderbefore'],time(),$ptinfoset['postdate'],$minit,$ptinfoset['pt_orderday']); 
		    if($tempdata['is_opentime'] ==  2) $this->message('选择的配送时间段，店铺未设置');
			if($tempdata['is_opentime'] == 3) $this->message('选择的配送时间段已超时');
			$data['sendtime'] = $tempdata['is_posttime'];
			$data['postdate'] = $tempdata['is_postdate']; 
			//$data['shopps'] = $tempdata['cost']; 
		}

		$data['pttype'] = $pttype;  // 1为帮我送  2为帮我买

		$data['content'] = $demandcontent;
		if($default == 1){
			$data['shopaddress']  = "就近购买";   
		}else{
		$data['shopaddress']  = $getdetaddress;  } 
		$data['buyeraddress']  = $shouetaddress;  
		if($pttype==1){
			$data['shopphone']  = $getphone;			//取件电话
		}
		$data['buyerphone']  = $shouphone;			//收件电话
		$data['addtime'] = time();
		$data['ordertype'] = 4;//订单类型
		
		
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		if(strpos($userAgent,"iPhone") || strpos($userAgent,"iPad") || strpos($userAgent,"iPod")){
			$data['ordertype'] =6;

		}
		$data['shoptype'] = 100;//订单类型
		$data['paytype'] = $paytype; 
		$data['paystatus'] = 0;  
		$data['ptkg'] = $ptkg;  
		$data['dno'] = time().rand(1000,9999);
		$data['pstype']  = 1;
		$data['buyeruid']  = $backinfo['uid'];
		$data['buyername'] = $backinfo['username']; 
		/* 计算两点之间的距离  并且 判断是否与前台的  千米距离金额是否一致 */
		$juli = $this->GetDistance($getlat,$getlng, $shoulat,$shoulng, 1,1); 
		$tempmi = $juli; 	
		$juli = round($juli/1000,1); 
		$tmpallkmcost =  0;
		if( $juli <= $ptinfoset['km']  ){
			$tmpallkmcost = $ptinfoset['kmcost'];
		}else{
			$addjuli = $juli-$ptinfoset['km'];
			$addnum = ceil( ($addjuli/$ptinfoset['addkm']));
			$addcost = $addnum*$ptinfoset['addkmcost'];
			$tmpallkmcost = $ptinfoset['kmcost']+$addcost;
		}  
		$data['ptkm'] = $juli;
		/* 计算重量  并且 判断是否与前台的  公斤金额是否一致 */
		$tmpallkgcost =  0;
		if( $ptkg <= $ptinfoset['kg']  ){
			$tmpallkgcost = $ptinfoset['kgcost'];
		}else{
			$addkg = $ptkg-$ptinfoset['kg'];
			$addkgnum = ceil( ($addkg/$ptinfoset['addkg'])); 
			$addkgcost = $addkgnum*$ptinfoset['addkgcost']; 
			$tmpallkgcost = $ptinfoset['kgcost']+$addkgcost; 
		} 
		$data['allkgcost'] = $tmpallkgcost;
		$data['allkmcost'] = $tmpallkmcost;
		$data['farecost'] = $farecost;
		if($pttype == 2){
		$data['allcost'] = $farecost+$tmpallkmcost;	
		}else{
		$data['allcost'] = $farecost+$tmpallkgcost+$tmpallkmcost;
		}
		
		$data['buyerlng'] = $getlng;
		$data['buyerlat'] = $getlat;
		$data['shoplng'] = $shoulng;
		$data['shoplat'] = $shoulat;
		
		 
		$data['status'] = 0;
		$data['ipaddress'] = "";
		$ip_l=new iplocation(); 
		$ipaddress=$ip_l->getaddress($ip_l->getIP());  
		if(isset($ipaddress["area1"])){
			#$data['ipaddress']  = $ipaddress['ip'].mb_convert_encoding($ipaddress["area1"],'UTF-8','GB2312');//('GB2312','ansi',);
			$data['ipaddress']  = $ipaddress['ip'] ;
		} 
		
		$this->mysql->insert(Mysite::$app->config['tablepre'].'order',$data);
		$orderid = $this->mysql->insertid();  
		/* 写订单物流 状态 */
		/* 第一步 提交成功 */
		$orderClass = new orderClass();
		$orderClass->writewuliustatus($orderid,1,$data['paytype']); 
		$this->success($orderid);
		
		
	}
	function paotuitime(){
		
		$adcode = trim(IReq::get('adcode'));
		$weight = trim(IReq::get('weight'));
		if(empty($adcode)){
			$this->message('获取所在城市失败');
		}
		
		if( !empty($adcode) ){
				$areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  "); 
  				if( !empty($areacodeone) ){
					$adcodeid = $areacodeone['id'];
					$pid = $areacodeone['pid'];
   					$areainfoone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  "); 
  					if( empty($areainfoone) ){
 						 $this->message('选择的城市暂未开通');
 					}
				}else{
					$this->message('获取所在城市失败~');
				}
		}
		
		$ptinfoset = $this->mysql->select_one(" select * from ".Mysite::$app->config['tablepre']."paotuiset where cityid = ".$areainfoone['adcode']." "); 
		if( empty($ptinfoset) ){
			$this->message('获取跑腿规则失败~');
		}
 		  $postdate =  $ptinfoset['postdate'];
		  $befortime = $ptinfoset['pt_orderday'];
		  
		$nowhout = strtotime(date('Y-m-d',time()));//当天最小linux 时间
		$timelist = !empty($postdate)?unserialize($postdate):array();
		$pstimelist = array();
		$checknow = time();
		
		 
		$whilestatic = $befortime;
		$nowwhiltcheck = 0;
		while($whilestatic >= $nowwhiltcheck){
		    $startwhil = $nowwhiltcheck*86400;
			foreach($timelist as $key=>$value){
				$stime = $startwhil+$nowhout+$value['s'];
				$etime = $startwhil+$nowhout+$value['e'];
				if($etime  >= $checknow){
					$tempt = array();
					$tempt['value'] = $value['s']+$startwhil;
					$tempt['s'] = date('H:i',$nowhout+$value['s']);
					$tempt['e'] = date('H:i',$nowhout+$value['e']);
					$tempt['d'] = date('Y-m-d',$stime);
					$tempt['i'] =  $value['i'];
					$tempt['cost'] =  isset($value['cost'])?$value['cost']:'0'; 
					$tempt['name'] = $stime > $checknow?$tempt['s'].'-'.$tempt['e']:'立即配送';
					$pstimelist[] = $tempt;
				}
			}
		 
			$nowwhiltcheck = $nowwhiltcheck+1;
		}
		
		$data['pstimelist'] = $pstimelist;
		$data['minkg'] = $ptinfoset['kg'];
		$data['minkgcost'] = $ptinfoset['kgcost'];
		$data['minkm'] = $ptinfoset['km'];
		$data['minkmcost'] = $ptinfoset['kmcost'];
		$addkg = $ptinfoset['addkg'];
		$addkgcost = $ptinfoset['addkgcost'];
		if($weight <= $data['minkg']){
			$pscost = $data['minkgcost'];
		}else{
			$pscost = $data['minkgcost'] + ceil(($weight - $data['minkg'])/$addkg)*$addkgcost;
		}
		$data['pscost'] = $pscost;	
		
		
		
		$this->success($data);
	}
	 
	function paotuiajax(){
			
		$adcode = trim(IReq::get('adcode'));
		if(empty($adcode)){
			$this->message('获取所在城市失败');
		}
		
		if( !empty($adcode) ){
				$areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  "); 
  				if( !empty($areacodeone) ){
					$adcodeid = $areacodeone['id'];
					$pid = $areacodeone['pid'];
   					$areainfoone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  "); 
  					if( empty($areainfoone) ){
 						 $this->message('选择的城市暂未开通');
 					}
				}else{
					$this->message('获取所在城市失败~');
				}
		}
		
		$ptinfoset = $this->mysql->select_one(" select * from ".Mysite::$app->config['tablepre']."paotuiset where cityid = ".$areainfoone['adcode']." "); 
		if( empty($ptinfoset) ){
			$this->message('获取跑腿规则失败~');
		}
		
		
 		$getlng = trim(IReq::get('getlng'));
		$getlat = trim(IReq::get('getlat'));
		$shoulng = trim(IReq::get('shoulng'));
		$shoulat = trim(IReq::get('shoulat'));
		$ptkg = intval(IReq::get('ptkg'));	 
	    if( empty($getlng) )  $this->message("获取取货地址失败,请重新获取");
		if( empty($getlat) )  $this->message("获取取货地址失败,请重新获取");
		if( empty($shoulng) )  $this->message("获取收货地址失败,请重新获取");
		if( empty($shoulat) )  $this->message("获取收货地址失败,请重新获取");
		
		$juli = $this->GetDistance($getlat,$getlng, $shoulat,$shoulng, 1,1); 
		$tempmi = $juli; 	
		$juli = round($juli/1000,1); 
		$tmpallkmcost =  0;
		if( $juli <= $ptinfoset['km']  ){
			$tmpallkmcost = $ptinfoset['kmcost'];
		}else{
			$addjuli = $juli-$ptinfoset['km'];
			$addnum = round( ($addjuli/$ptinfoset['addkm']));
			$addcost = $addnum*$ptinfoset['addkmcost'];
			$tmpallkmcost = $ptinfoset['kmcost']+$addcost;
		}   
		/* 计算重量  并且 判断是否与前台的  公斤金额是否一致 */
		$tmpallkgcost =  0;
		if( $ptkg <= $ptinfoset['kg']  ){
			$tmpallkgcost = $ptinfoset['kgcost'];
		}else{
			$addkg = $ptkg-$ptinfoset['kg'];
			$addkgnum = round( ($addkg/$ptinfoset['addkg'])); 
			$addkgcost = $addkgnum*$ptinfoset['addkgcost']; 
			$tmpallkgcost = $ptinfoset['kgcost']+$addkgcost; 
		} 
		$backdata['allkgcost'] = $tmpallkgcost;
		$backdata['allkmcost'] = $tmpallkmcost;
		$backdata['juli'] = $juli.'';
		$this->success($backdata);
	}
	//2016-3 开始
	//获取 开店类型
	function opentypelist(){
		$catparent = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype  where  type='checkbox' order by cattype asc limit 0,100");
		$catlist = array();
		foreach($catparent as $key=>$value){
			$tempcat   = $this->mysql->getarr("select id,name,cattype from ".Mysite::$app->config['tablepre']."shoptype  where parent_id = '".$value['id']."'  limit 0,100");
			foreach($tempcat as $k=>$v){
				 $v['cattypename'] = $v['cattype'] == 0?'外卖':'超市';
				 $catlist[] = $v;
			}
		} 
		$this->success($catlist);
	}
	function checkopen(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}  
		$checkshopin = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where  uid='".$backinfo['uid']."' "); 
		if(empty($checkshopin)){
			$this->success('waitopen');
		}else{
			$this->success($checkshopin);//is_pass
		}
	}
	function openshop()
	{
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}  
		$sdata['shopname'] = IReq::get('shopname');//店铺名称
		$sdata['address'] = IReq::get('shopaddress');//店铺地址
		$sdata['shoplicense']  = IReq::get('shoplicense');//商家营业执照
		$attrid =  intval(IReq::get('attrid')); 
		
		$checkshopin = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where  uid='".$backinfo['uid']."' ");
		if(!empty($checkshopin)){
			$this->message('商家已开店');
		} 
		if(empty($sdata['shopname']))  $this->message('shop_emptyname');
		if(empty($sdata['shoplicense'])) $this->message('请上传营业执照');
		$shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where  shopname='".$sdata['shopname']."'  ");
		if(!empty($shopinfo)) $this->message('shop_repeatname');
		
		
	 
		$sdata['uid'] = $backinfo['uid'];
		$sdata['maphone'] =  $backinfo['phone'];
		$sdata['addtime'] = time();
		$sdata['email'] =  $backinfo['email'];    
		$sdata['admin_id'] = 0;
		$nowday = 24*60*60*365;
		$sdata['endtime'] = time()+$nowday;   
		$checkshoptype =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shoptype where id=".$attrid."  ");
		if(empty($checkshoptype))  $this->message("获取店铺分类失败");

		$sdata['shoptype']  = $checkshoptype['cattype'];   // 店铺大类型 0为外卖 1为超市
		
		$this->mysql->insert(Mysite::$app->config['tablepre'].'shop',$sdata); 
		$shopid = $this->mysql->insertid(); 
		$attrdata['shopid'] = $shopid;
		$attrdata['cattype'] = $checkshoptype['cattype'];
		$attrdata['firstattr'] = $checkshoptype['parent_id'];
		$attrdata['attrid'] = $checkshoptype['id'];
		$attrdata['value'] = $checkshoptype['name']; 

		$this->mysql->insert(Mysite::$app->config['tablepre'].'shopattr',$attrdata); 
		$this->mysql->update(Mysite::$app->config['tablepre'].'member',array('shopid'=>$shopid),"uid='".$this->member['uid']."'"); 
		$this->success('success'); 
	}
	function updatezhizhao(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}    
		$json = new Services_JSON();
		$uploadpath = 'upload/user/';
		$filepath = '/upload/user/';
		$upload = new upload($uploadpath,array('gif','jpg','jpge','png'));//upload
		$file = $upload->getfile();
		if($upload->errno!=15&&$upload->errno!=0) {
			$this->message($upload->errmsg());

		}else{
			$data['logo'] = $filepath.$file[0]['saveName']; 
			$this->success($data);
		} 
	}
	//2016-3 结束 
	function paotuiorder(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		 $data['pttype'] = $pttype;  // 1为帮我送  2为帮我买
		$ordershowtype = intval(IFilter::act(IReq::get('ordershowtype')));
		$where = " and shoptype = 100 ";
		if($ordershowtype == 1){
			$where .=" and pttype = 1 ";
		}elseif($ordershowtype == 2){
			$where .=" and pttype = 2 ";
		}
		$pagesize = intval(IFilter::act(IReq::get('pagesize')));
		$pagesize = empty($pagesize)?10:$pagesize;
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);
		$statusarr = array('0'=>'新订单','1'=>'等待取货','2'=>'确认取货','3'=>'已送达','4'=>'关闭','5'=>'关闭'); 
		$goshoparr = array('0'=>'新订单','1'=>'等待购买','2'=>'等待送货','3'=>'已送达','4'=>'关闭','5'=>'关闭');
		/* 获取订单数:   shopname  id  shoplogo  allcost addtime  status paystatus   paytype  */
		$nowtime = time()-14*24*60*60;
		$orderlist = $this->mysql->getarr("select  addtime,pstype,status,paystatus,content,paytype,id,ptkg,ptkm,allkgcost,allkmcost,farecost,allcost,pttype,is_reback from ".Mysite::$app->config['tablepre']."order where  buyeruid = ".$backinfo['uid']." ".$where." order by id desc  limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."");
		if(empty($orderlist)) $this->success(array());
		$backdata = array();
		//status 状态，0未使用，1已绑定，2已使用，3无效
		foreach($orderlist as $key=>$value){ 
			$value['addtime'] = date('Y-m-d H:i:s',$value['addtime']);
		    if($value['pttype'] == 1){
				$value['seestatus'] = isset($statusarr[$value['status']])?$statusarr[$value['status']]:'';
			}else{
				$value['seestatus'] = isset($goshoparr[$value['status']])?$goshoparr[$value['status']]:'';
			} 
			if($value['is_reback'] == 1){
				$value['seestatus'] = "退款中";
			}
			 
			$backdata[] = $value;
		}
		$this->success($backdata);
	}
	function onepaotui(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		} 
		$orderid = intval(IFilter::act(IReq::get('orderid')));
		$where = " and id = '".$orderid."' and shoptype = 100 ";
		 
		$statusarr = array('0'=>'新订单','1'=>'等待取货','2'=>'确认取货','3'=>'已送达','4'=>'关闭','5'=>'关闭'); 
		$goshoparr = array('0'=>'新订单','1'=>'等待购买','2'=>'等待送货','3'=>'已送达','4'=>'关闭','5'=>'关闭');
		/* 获取订单数:   shopname  id  shoplogo  allcost addtime  status paystatus   paytype  */
		$nowtime = time()-14*24*60*60;
		$orderinfo = $this->mysql->select_one("select  * from ".Mysite::$app->config['tablepre']."order where  buyeruid = ".$backinfo['uid']." ".$where." order by id desc  ");
		if(empty($orderinfo)){ 
			$this->message('订单不存在');
		}
		$orderinfo['addtime'] = date('Y-m-d H:i:s',$orderinfo['addtime']);
		if($orderinfo['pttype'] == 1){
			$orderinfo['seestatus'] = isset($statusarr[$orderinfo['status']])?$statusarr[$orderinfo['status']]:'';
		}else{
			$orderinfo['seestatus'] = isset($goshoparr[$orderinfo['status']])?$goshoparr[$orderinfo['status']]:'';
		}  
		$this->success($orderinfo);
	}

	/* 2016.3.29  WMR8.2版本更新 */
	function getNotice(){  // 获取首页一条通知 
	
		$adcode = trim(IFilter::act(IReq::get('adcode')));
		
		$cityid = 0;
		$cityinfo = array();
		
		if( !empty($adcode) ){
				$areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  "); 
  				if( !empty($areacodeone) ){
					$adcodeid = $areacodeone['id'];
					$pid = $areacodeone['pid'];
   					$areainfoone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  "); 
  					if( !empty($areainfoone) ){
						$city_id = "CITY_ID_".$areainfoone['adcode'];
						$city_name = "CITY_NAME_".$areainfoone['name'];
						ICookie::set('CITY_ID',$city_id);
						ICookie::set('CITY_NAME',$city_name);
						$cityinfo = $areainfoone;
 					}
				}
		}  
		if( !empty($cityinfo) ){ 
			$cityid = $cityinfo['adcode'];
		}
		$data['cityinfo'] = $cityinfo; 
		if( $cityid == 0 ){
			$citywhere = '     ';
		}else{
			$citywhere =  " and ( cityid = '".$cityid."'  or cityid = 0 )  ";
		}
		
	    $data['noticeInfo'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."information where type = 1 ".$citywhere."  order by orderid asc limit 1");
		$data['noticeInfo']['addtime'] = date("Y-m-d",$data['noticeInfo']['addtime']);
		 $data['noticeInfo']['content'] = strip_tags($data['noticeInfo']['content']); 
		$this->success($data);
	}	
	
	function getNoticeList(){  // 获取通知列表 
		
		$adcode = trim(IFilter::act(IReq::get('adcode')));
		
		$cityid = 0;
		$cityinfo = array();
		
		if( !empty($adcode) ){
				$areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  "); 
  				if( !empty($areacodeone) ){
					$adcodeid = $areacodeone['id'];
					$pid = $areacodeone['pid'];
   					$areainfoone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  "); 
  					if( !empty($areainfoone) ){
						$city_id = "CITY_ID_".$areainfoone['adcode'];
						$city_name = "CITY_NAME_".$areainfoone['name'];
						ICookie::set('CITY_ID',$city_id);
						ICookie::set('CITY_NAME',$city_name);
						$cityinfo = $areainfoone;
 					}
				}
		}  
		if( !empty($cityinfo) ){ 
			$cityid = $cityinfo['adcode'];
		}
		$data['cityinfo'] = $cityinfo; 
		if( $cityid == 0 ){
			$citywhere = '   ';
		}else{
			$citywhere =  " and ( cityid = '".$cityid."'  or cityid = 0 )  ";
		}
	
	
		$pagesize = intval(IFilter::act(IReq::get('pagesize')));
		$pagesize = empty($pagesize)?10:$pagesize;
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);
	    $noticeList = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."information where type = 1  ".$citywhere."  order by addtime desc  limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()." ");
		$data['noticeList'] = array();
		foreach($noticeList as $key=>$value){
			$value['addtime'] = date("Y-m-d",$value['addtime']);
			$value['content'] = $value['content']; 
			$data['noticeList'][] = $value;
		}
		$this->success($data);
	}	
	function getoneNotice(){  // 获取某条网站通知详情
		$id = intval(trim(IReq::get('id')));
		$data['onenoticeInfo'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."information where type = 1 and id = ".$id." order by orderid asc limit 1");
		$data['onenoticeInfo']['addtime'] = date("Y-m-d",$data['onenoticeInfo']['addtime']);
		$data['onenoticeInfo']['content'] = $data['onenoticeInfo']['content']; 
		$this->success($data);
		
	}
	 
	 
	function getLifehelpList(){  // 获取生活服务列表 
	
		
		$adcode = trim(IFilter::act(IReq::get('adcode')));
		
		$cityid = 0;
		$cityinfo = array();
		
		if( !empty($adcode) ){
				$areacodeone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."areacode where id=".$adcode."  "); 
  				if( !empty($areacodeone) ){
					$adcodeid = $areacodeone['id'];
					$pid = $areacodeone['pid'];
   					$areainfoone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."area where  adcode=".$adcodeid." or adcode=".$pid."  "); 
  					if( !empty($areainfoone) ){
						$city_id = "CITY_ID_".$areainfoone['adcode'];
						$city_name = "CITY_NAME_".$areainfoone['name'];
						ICookie::set('CITY_ID',$city_id);
						ICookie::set('CITY_NAME',$city_name);
						$cityinfo = $areainfoone;
 					}
				}
		}  
		if( !empty($cityinfo) ){ 
			$cityid = $cityinfo['adcode'];
		}
		$data['cityinfo'] = $cityinfo; 
		if( $cityid == 0 ){
			$citywhere = '     ';
		}else{
			$citywhere =  " and ( cityid = '".$cityid."'  or cityid = 0 )  ";
		}
		
	
		$pagesize = intval(IFilter::act(IReq::get('pagesize')));
		$pagesize = empty($pagesize)?10:$pagesize;
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);
	    $lifehelpList = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."information where type = 2  ".$citywhere." order by orderid asc  limit ".$this->pageCls->startnum().", ".$this->pageCls->getsize()." ");
		$data['lifehelpList'] = array();
		foreach($lifehelpList as $key=>$value){
			$value['addtime'] = date("Y-m-d",$value['addtime']);
			//$value['content'] = strip_tags($value['content']); 
			$data['lifehelpList'][] = $value;
		}
		$this->success($data);
	}	
	function getoneLifehelp(){  // 获取某条生活服务详情
		$id = intval(trim(IReq::get('id')));
		$data['lifeassinfo'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."information where type = 2 and id = ".$id." order by orderid asc limit 1");
		$data['lifeassinfo']['addtime'] = date("Y-m-d",$data['lifeassinfo']['addtime']);
		# print_r($this->dip2px());
		Mysite::$app->setdata($data);//$this->success($data);
		
	}
	
	/* 获取某店铺下 实景图列表 */
    function getShopRealInfo(){
		$shopid = intval(trim(IReq::get('shopid')));
	    $shoprealcat = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopreal where shopid = ".$shopid."   order by id asc   ");
		$shopRealInfo = array();
		foreach($shoprealcat as $key=>$value){
			$value['imgcount'] = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."shoprealimg where parent_id = ".$value['id']."   order by id asc   ");
			$value['imglist'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoprealimg where parent_id = ".$value['id']."   order by id asc   ");
			$shopRealInfo[] = $value;
		} 
		$data['shopRealInfo'] = $shopRealInfo;
		$this->success($data);
		
	}
	/* 4.6新增 获取网站电话 */
	function getSiteTel(){
		$litel = Mysite::$app->config['litel'];
		$this->success($litel);
	}
	
		
	/* 4.9 举报商家页面 */
	   function shopreport(){
         $shopid = intval(IReq::get(shopid));
		$shopinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where id=".$shopid."  ");
		if(empty($shopinfo)) $this->message("获取店铺信息失败！");
        $shopname = $shopinfo['shopname'];
		$typelist = unserialize( Mysite::$app->config['refundreasonlist'] );
		$tempc = array();
		$i = 0;
		if(is_array($typelist)){
			foreach($typelist as $key=>$value){
				$tempd = array('id'=>$i,'name'=>$value);
				$tempc[$i] = $tempd;
				 
				$i++;
			}
		}
		 
		
		$data['typelist'] = $tempc; 
        $data['shopname'] = $shopname;
        $this->success($data);
    } 
    function saveshopreport(){
        $typeidContent = IFilter::act(IReq::get('typeidContent'));
        $shopname = IFilter::act(IReq::get('shopname'));
        $content = IFilter::act(IReq::get('content'));
        $phone= IReq::get('phone');
        if($typeidContent == null || $typeidContent == '')	$this->message('请选择一种投诉类型');
        if(empty($content))	$this->message('详细情况不能为空');
        if(empty($phone))	$this->message('手机号码不能为空');
        $myreg = '/^1[34578]{1}\d{9}$/';
        if(!preg_match($myreg,$phone))$this->message('手机号码格式错误');
        $arr['typeidContent'] = $typeidContent;
        $arr['shopname'] = $shopname;
        $arr['addtime'] = time();
        $arr['content'] = $content;
        $arr['phone'] = $phone;
        $this->mysql->insert(Mysite::$app->config['tablepre'].'shopreport',$arr);
        $this->success('success');
    }
	/** 	
     * @userapi 
     * @name qq获取绑定手机号返回信息
     * @other 2017/8/19   赵
     * @phonecode  手机验证码  必传
	 * @phone 手机号          必传
	 * @openid qq登陆openid   必传
     * @datatype 固定值 json 必传  
	*{
	*	"error": false,
	*	"msg": {
	*		"uid": "2989",【用户uid】 
	*		"username": "aedf4b77",【账号名称】
	*		"phone": "18638005332",【绑定手机号】 
	*		"score": "10",【积分】
	*		"cost": "0.00",【余额】
	*       "temp_password":"",【未设置密码的快捷登陆账号密码】
	*		"logo": "http://qzapp.qlogo.cn/qzapp/101416262/5D5E1ECC63F45FBBE40429C16F0DD2F6/100",【头像】 
	*		"juancount": 0【所拥有的优惠券张数】
	*	}
	*}   
	*/
	function qqlogin(){
		$phonecode =  IFilter::act(IReq::get('phonecode'));
		$openid =  IFilter::act(IReq::get('openid'));
		$phone =  IFilter::act(IReq::get('phone'));
		$phonecls = new phonecode($this->mysql,7,$phone); 
		if($phonecls->checkcode($phonecode)){
			include_once(hopedir.'/plug/login/qqapp/ghqqappOauth.php');
			$ghqqappOauth = new ghqqappOauth($this->mysql,$this->memberCls);
			if($ghqqappOauth->bingphone($phone,$openid)){
				$this->success($ghqqappOauth->getuserinfo());
			}else{
				$this->message($ghqqappOauth->geterr());
			} 
		}else{ 
			$this->message($phonecls->getError());
		}
		
	}
	/** 	
     * @userapi 
     * @name 拉取qq账号信息
     * @other 2017/8/19   赵
     * @access_token  qq登陆token  必传 
	 * @openid qq登陆openid   必传 
     * @datatype 固定值 json 必传  
	 *情况1   当账号已绑定手机
	*{
	*	"error": false,
	*	"msg": {
	*		"uid": "2989",【用户uid】 
	*		"username": "aedf4b77",【账号名称】
	*		"phone": "18638005332",【绑定手机号】 
	*		"score": "10",【积分】
	*		"cost": "0.00",【余额】
	*       "temp_password":"",【未设置密码的快捷登陆账号密码】
	*		"logo": "http://qzapp.qlogo.cn/qzapp/101416262/5D5E1ECC63F45FBBE40429C16F0DD2F6/100",【头像】 
	*		"juancount": 0【所拥有的优惠券张数】
	*	}
	*} 
	*情况2   账号未绑定手机
	*{
	*	"error": false,
	*	"msg": {
	*	  "phone": "",   
	*	}
	*}
	*/
	function qqinfo(){ 
		$access_token =  IFilter::act(IReq::get('access_token'));
		$openid =  IFilter::act(IReq::get('openid'));
		include_once(hopedir.'/plug/login/qqapp/ghqqappOauth.php');
		$ghqqappOauth = new ghqqappOauth($this->mysql,$this->memberCls);
		if($ghqqappOauth->login($access_token,$openid)){
			$this->success($ghqqappOauth->getuserinfo());
		}else{
			$this->message($ghqqappOauth->geterr());
		} 
	}
	/** 	
     * @userapi 
     * @name 获取第三方登陆列表
     * @other 2017/8/19   赵  
     * @datatype 固定值 json 必传  
	*{
	*	"error": false,
	*	"msg": {
	*		"wxappid": "321321321",【微信app登陆appid】 未空时不能使用微信app登陆 
	*		"qqappid": "f4243242",【qqapp登陆appid】未空时不能使用QQ app登陆  
	*	}
	*}   
	*/
	function loginapi(){ 
		$data['wxappid'] = '';
		$data['qqappid'] = '';
		$checkfile = hopedir.'/plug/pay/weixinapp/lib/WxPay.Config.php';
		if(file_exists($checkfile)){
			include_once(hopedir.'/plug/pay/weixinapp/lib/WxPay.Config.php');
			$data['wxappid'] = WxPayConfig::APPID;			 
		} 
		$checkfile2 = hopedir.'/plug/login/qqapp/ghqqappOauth.php';
		if(file_exists($checkfile2)){
		    include_once(hopedir.'/plug/login/qqapp/ghqqappOauth.php');
			 $ghqqappOauth = new ghqqappOauth($this->mysql,$this->memberCls);  
			 $data['qqappid'] =$ghqqappOauth->getappid();
		}
	    $this->success($data); 
	}
	function wxlogin(){
		//微信发起调用成功绑定手机号---
		$phonecode =  IFilter::act(IReq::get('phonecode'));
		$openid =  IFilter::act(IReq::get('openid'));
		$phone =  IFilter::act(IReq::get('phone'));
		$phonecls = new phonecode($this->mysql,7,$phone); 
		if($phonecls->checkcode($phonecode)){
			 
		     $oauthinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."wxappoauth where openid='".$openid."'  ");
			if(empty($openid)){
				$this->message('未提交微信openid');
			}
			if(empty($oauthinfo)){
				$this->message('请先发起登录后再绑定手机号');
			}
			if($oauthinfo['uid'] > 0){
				 $checkmember =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$oauthinfo['uid']."'  ");
				 if(!empty($checkmember)){
					 $this->message('用户已绑定手机号不能重复绑定');
				 }
			}
		    $phonemember =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where phone='".$phone."'  ");
			if(empty($phonemember)){
				//写新用户数据到 用户表中
				 $temp_password = rand(100000,999999);  
				 $checkstr = md5($phone);
				 $arr['username'] = substr($checkstr,0,8);
				 $arr['phone'] = $phone;
				 $arr['address'] = '';
				 $arr['password'] = md5($temp_password);
				 $arr['email'] = '';
				 $arr['creattime'] = time(); 
				 $arr['score']  = $score == 0?Mysite::$app->config['regesterscore']:$score;
				 $arr['logintime'] = time(); 
				 $arr['logo'] = Mysite::$app->config['userlogo'];
				 $arr['loginip'] = IClient::getIp();
				 $arr['group'] = 5;
				 $arr['cost'] = 0; 
				 $arr['parent_id'] =0;
				 $arr['temp_password'] = $temp_password;
				 $this->mysql->insert(Mysite::$app->config['tablepre'].'member',$arr);   
				 $uid = $this->mysql->insertid(); 
				 if($arr['score'] > 0){
					$this->memberCls->addlog($uid,1,1,$arr['score'],'注册送积分','注册送积分'.$arr['score'],$arr['score']);
				 } 
				 $juansetinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 2 or name = '注册送优惠券' " );  	   
                 $juaninfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."alljuan where type = 2 or name= '注册送优惠券' order by id asc " );	   
		 if($juansetinfo['status'] ==1 && !empty($juaninfo)){
	 	   //注册送优惠券		   		   	  
		   foreach($juaninfo as $key=>$value){			   
			   $juandata['uid'] = $uid;// 用户ID	
			   $juandata['username'] = $arr['username'];// 用户名
			   $juandata['name'] = $value['name'];//  优惠券名称 
			   $juandata['status'] = 1;// 状态，0未使用，1已绑定，2已使用，3无效	
			   $juandata['card'] = $nowtime.rand(100,999);
			   $juandata['card_password'] =  substr(md5($juandata['card']),0,5);
			   $juandata['limitcost']	= $value['limitcost'];	
			   
			   if($juansetinfo['timetype'] == 1){
					$juandata['creattime'] = time();
					$date = date('Y-m-d',$juandata['creattime']);
					$endtime = strtotime($date) + ($juansetinfo['days']-1)*24*60*60 + 86399;
					$juandata['endtime'] = $endtime;
			   }else{
					$juandata['creattime'] = $value['starttime'];
					$juandata['endtime'] =  $value['endtime'];
			   }
               if($juansetinfo['costtype'] == 1){
				    $juandata['cost'] = $value['cost'];
			   }else{
					$juandata['cost'] = rand($value['costmin'],$value['costmax']);
			   }			   			   		  	    		   
			   $this->mysql->insert(Mysite::$app->config['tablepre'].'juan',$juandata);			   
		   } 
       }
			     $phonemember = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$uid."' ");
		   
			}  
			$cnewdata['uid'] = $phonemember['uid'];
		    $this->mysql->update(Mysite::$app->config['tablepre'].'wxappoauth',$cnewdata,"openid='".$openid."'");   
		    $oauthinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."wxappoauth where openid='".$openid."'  ");
		    $oauthinfo['phone'] = $phone;
			$tjyhj = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."juan where uid='".$phonemember['uid']."' and status < 2 and  endtime > ".time()." ");
			$oauthinfo['juancount'] = $tjyhj;
			if(!empty($phonemember)){
				unset($phonemember['password']);
				$oauthinfo = array_merge($phonemember,$oauthinfo);
				$oauthinfo['logo'] = Mysite::$app->config['siteurl'].$oauthinfo['logo'];
				$expire = time() + 86400; // 设置24小时的有效期
				setcookie("app_login", "app_login", $expire);
				setcookie("app_loginphone", $phonemember['phone'], $expire); 
			}
		    $this->success($oauthinfo);
		}else{
			$this->message($phonecls->getError());
		}
		
	}
	function wxappset(){
		$checkfile = hopedir.'/plug/pay/weixinapp/lib/WxPay.Config.php';
		if(file_exists($checkfile)){
			 include_once(hopedir.'/plug/pay/weixinapp/lib/WxPay.Config.php');
			 $this->success(WxPayConfig::APPID);
		}else{
			$this->message('网站未使用APP登录');
		} 
	}
	function wxinfo(){
		//微信获取用户信息 写数据到
		$code =  IFilter::act(IReq::get('code'));
		//---直接调用 微信 支付的APP设置
		include_once(hopedir.'/plug/pay/weixinapp/lib/WxPay.Config.php');
		//print_r(WxPayConfig::APPID);//静态变脸的调用
		//WxPayConfig::APPSECRET
		  
		//获取 access_token  
		$userinfo = array();
		$token_link = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.WxPayConfig::APPID.'&secret='.WxPayConfig::APPSECRET.'&code='.$code.'&grant_type=authorization_code'; 
		$token =json_decode($this->curl_get_content($token_link), TRUE); 
	    if(isset($token['access_token'])){
			$userinfo['openid'] = $token['openid'];
			$userinfo['unionid'] = $token['unionid'];
			$userinfo['access_token'] = $token['access_token'];
			$userinfo['refresh_token'] = $token['refresh_token'];
			$expires_in = $token['expires_in'];
			if($expires_in < 1){
				//刷新CODE
				$refresh_link = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='.WxPayConfig::APPID.'&grant_type=refresh_token&refresh_token='.$userinfo['refresh_token'];
			    $refresh =json_decode($this->curl_get_content($refresh_link), TRUE); 
				if(isset($refresh['access_token'])){
					$userinfo['openid'] = $refresh['openid'];
					$userinfo['unionid'] = $refresh['unionid'];
					$userinfo['access_token'] = $refresh['access_token'];
					$userinfo['refresh_token'] = $refresh['refresh_token'];
					$expires_in = $refresh['expires_in']; 
				}else{
					$this->message($refresh['errcode']);
				} 
			}
			
		}else{
			$this->message($token['errcode']);
		}
		//校研 openid
		
		$check_link = 'https://api.weixin.qq.com/sns/auth?access_token='.$userinfo['access_token'].'&openid='.$userinfo['openid'];
		$checkopen =json_decode($this->curl_get_content($check_link), TRUE); 
		if($checkopen['errcode'] == 0){
			
		}else{ 
			$this->message($checkopen['errcode']);
		} 
		
		//获取用户信息
		$getlink = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$userinfo['access_token'].'&openid='.$userinfo['openid'];
		$wxuser =json_decode($this->curl_get_content($getlink), TRUE); 
		 
		
		if(isset($wxuser['openid'])){
			 
			/*
			 [openid] => oHBxnv1_CHEb5EMs5Rf4TM8fCJlU [nickname] => 潇湘雨 [sex] => 1 [language] => zh_CN [city] => Zhengzhou [province] => Henan [country] => CN [headimgurl] => http://wx.qlogo.cn/mmopen/kAcicic6Sn2KxTVJjHbaNr6mqvSo5w7HK8iaEsMStX74drvnHd8iarPMkMV5YVcwWk1nhWTHjc4kJhicLHIIGEvt4fUEUrdCJrNicD/0 [privilege] => Array ( ) [unionid] => oK4VYt9Y59KxJoSLAZi5tVh0BmoE
			 */
			 
			
			
			
		}else{
			$this->message($wxuser['errcode']); 
		}
		//  [openid] => oHBxnv1_CHEb5EMs5Rf4TM8fCJlU [nickname] => 潇湘雨 [sex] => 1 [language] => zh_CN [city] => Zhengzhou [province] => Henan [country] => CN [headimgurl] => http://wx.qlogo.cn/mmopen/kAcicic6Sn2KxTVJjHbaNr6mqvSo5w7HK8iaEsMStX74drvnHd8iarPMkMV5YVcwWk1nhWTHjc4kJhicLHIIGEvt4fUEUrdCJrNicD/0 [privilege] => Array ( ) [unionid] => oK4VYt9Y59KxJoSLAZi5tVh0BmoE
		//wxuser
		//构造微信APP登录 xiaozu_wxappoauth
		$wxoauth['openid'] = $wxuser['openid'];
		$wxoauth['username'] = $wxuser['nickname'];
	 
		 
		 //openId 
		 //username
		 //imgurl
		 //uid 
         //
        $oauthinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."wxappoauth where openid='".$wxuser['openid']."'  ");
		if(empty($checkuser)){
			$newdata['openid'] = $wxuser['openid'];
			$newdata['username'] =  $wxuser['nickname'];
			$newdata['imgurl'] = $wxuser['headimgurl'];
			$newdata['uid'] = 0; 
			$this->mysql->insert(Mysite::$app->config['tablepre'].'wxappoauth',$newdata); 
			 
			$oauthinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."wxappoauth where openid='".$wxuser['openid']."'  "); 
			if(!empty($oauthinfo['logo'])){ 
				$oauthinfo['logo'] = preg_match('/(http:\/\/)|(https:\/\/)/i',$oauthinfo['logo'])?$oauthinfo['logo']:Mysite::$app->config['siteurl'].$oauthinfo['logo'];
			}else{
				$oauthinfo['logo'] = Mysite::$app->config['siteurl'].Mysite::$app->config['userlogo'];
			}
		} 
		if($oauthinfo['uid'] > 0){
			$checkuserinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid=".$oauthinfo['uid']."  ");
			$oauthinfo['phone'] = $checkuserinfo['phone']; 
		    if(!empty($checkuserinfo)&& !empty($checkuserinfo['phone'])){
				unset($checkuserinfo['password']); 
				$oauthinfo = array_merge($checkuserinfo,$oauthinfo); 
				if(!empty($oauthinfo['logo'])){ 
					$oauthinfo['logo'] = preg_match('/(http:\/\/)|(https:\/\/)/i',$oauthinfo['logo'])?$oauthinfo['logo']:Mysite::$app->config['siteurl'].$oauthinfo['logo'];
				}else{
					$oauthinfo['logo'] = Mysite::$app->config['siteurl'].Mysite::$app->config['userlogo'];
				}
				$tjyhj = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."juan where uid='".$oauthinfo['uid']."' and status < 2 and  endtime > ".time()." ");
				$oauthinfo['juancount'] = $tjyhj;
				 
				$expire = time() + 86400; // 设置24小时的有效期
				setcookie("app_login", "app_login", $expire);
				setcookie("app_loginphone", $checkuserinfo['phone'], $expire); 
			}
			 
		}else{
			$oauthinfo['phone'] = '';
		}
		
		
		//oauthinfo
		$this->success($oauthinfo); 
	}
 
	
	public function bluetooth_data(){
		$dno =  IFilter::act(IReq::get('dno'));
		$orderinfo = $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."order  where dno= '".$dno."'   ");
		if(empty($orderinfo))  $this->message('订单不存在');
		$orderdet =  $this->mysql->getarr("select *  from ".Mysite::$app->config['tablepre']."orderdet  where order_id= '".$orderinfo['id']."'   ");
		$shopinfo =  $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shop  where id= '".$orderinfo['shopid']."'   ");
		$temp_content = '';
		if(is_array($orderdet)){
			foreach($orderdet as $km=>$vc){
				$temp_content .= $vc['goodsname'].'('.$vc['goodscount'].'份) \n ';
			}
		}
		$payarrr = array('outpay'=>'到付','open_acout'=>'余额支付');
		$orderpastatus = $orderinfo['paystatus'] == 1?'已支付':'未支付';
		$orderpaytype = isset($payarrr[$orderinfo['paytype']])?$payarrr[$orderinfo['paytype']]:'在线支付';
		$backdata['top'] = $shopinfo['shopname'];
		$backdata['body'] = '订餐热线:'.Mysite::$app->config['litel'].' 
订单状态：'.$orderpaytype.',('.$orderpastatus.')  
姓名：'.$orderinfo['buyername'].' 
电话：'.$orderinfo['buyerphone'].' 
地址：'.$orderinfo['buyeraddress'].' 
下单时间：'.date('m-d H:i',$orderinfo['addtime']).' 
配送时间:'.date('m-d H:i',$orderinfo['posttime']).' 
 
******************************* 
'.$temp_content.'
******************************* 
 
配送费：'.$orderinfo['shopps'].'元 
合计：'.$orderinfo['allcost'].'元 
※※※※※※※※※※※※※※ 
谢谢惠顾，欢迎下次光临 
订单编号'.$orderinfo['dno'].' 
备注'.$orderinfo['content'].' 
'; 
		$this->success($backdata); 
		
		
	}
	/* 8.3新增   2016-06-04  zem */
 function memcard(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
	  
	  $rechargelist = $this->mysql->getarr("select *  from ".Mysite::$app->config['tablepre']."rechargecost where cost > 0 order by orderid asc limit 0,100");
	  $data['rechargelist'] = array();
	  foreach($rechargelist as $key=>$value ){
		  $totalsendcost = '';
		  if( $value['is_sendcost'] == 1 ){
			  $totalsendcost = $totalsendcost+$value['sendcost'];
		  }
		  if( $value['is_sendjuan'] == 1 ){
			  $totalsendcost = $totalsendcost+$value['sendjuancost'];
		  }
		  $value['totalsendcost'] = $totalsendcost;
		  
		  $tempname = '充值'.$value['cost'].'元';
		   if( $value['is_sendcost'] == 1  || $value['is_sendjuan'] == 1  ){
			   $tempname .= '赠送';
		   }
		   if( $value['is_sendcost'] == 1   ){
			   $tempname .= $value['sendcost'].'元';
		   }
		   if( $value['is_sendcost'] == 1 && $value['is_sendjuan'] == 1  ){
			   $tempname .= '+';
		   }
		    if(   $value['is_sendjuan'] == 1  ){
			   $tempname .= $value['sendjuancost'].'元优惠券';
		   }
		  $value['juanname'] = $tempname;
		  
		  $data['rechargelist'][] = $value;
	  }
	  
	 $this->success($data); 
	  
	 
   }




    //8.3新增显示所有、或搜索闪惠商家
    function shophuilist(){
        $cxsignlist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodssign where type='cx' order by id desc limit 0, 100");
        $cxarray  =  array();
        foreach($cxsignlist as $key=>$value){
            $cxarray[$value['id']] = $value['imgurl'];
        }
        $where = '';
        $shopsearch = IFilter::act(IReq::get('search_input'));
        $shopsearch = urldecode($shopsearch);
        if(!empty($shopsearch)) $where=" and shopname like '%".$shopsearch."%' ";
        $areaid= intval(IFilter::act(IReq::get('areaid')));
        $templist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where  cattype = 0 and parent_id = 0 and is_main =1  order by orderid asc limit 0,1000");
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

        $shopxinxi = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shop where is_pass = 1 and ".time()." < endtime and is_open =1  ".$where);

        $list = array();
        foreach ($shopxinxi as $key=>$value){ 
            $shoplists = array();
            if($value['shoptype'] == 0){
                $shopfast =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast where shopid = ".$value['id']." and  is_hui=1 and is_shophui=1 ");

                if(!empty($shopfast)){
                    $shoplists = array_merge( $value , $shopfast);
                    $list[] = $shoplists;
                }


            }else{
                $shopmarket =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket where shopid = ".$value['id']." and  is_hui=1 and is_shophui=1");
                if(!empty($shopmarket)){
                    $shoplists = array_merge( $value , $shopmarket);
                    $list[] = $shoplists;
                }
            }


        }
        $nowhour = date('H:i:s',time());
        $nowhour = strtotime($nowhour);
        $templist = array();
		
        if(is_array($list)){
            foreach($list as $keys=>$values){
                if($values['id'] > 0){
					 $shopshui = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shophui where  status = 1 and shopid = ".$values['id']."");
					 if(!empty($shopshui)){
                    
						$values['shopshui']=$shopshui;
						$firstday = strtotime( date('Y-m-01 00:00:00', strtotime(date("Y-m-d H:i:s")))	);   //当月第一天
						$shopcounts = $this->mysql->select_one( "select count(id) as shuliang  from ".Mysite::$app->config['tablepre']."order	 where suretime >= ".$firstday."   and status = 3 and  shopid = ".$values['id']."" );
						if(empty( $shopcounts['shuliang']  )){
							$values['ordercount'] = 0;//月销量
						}else{
							$values['ordercount']  = $shopcounts['shuliang'];
						}
						$lng = IFilter::act(IReq::get('lng'));
						$lat = IFilter::act(IReq::get('lat'));
						$lng = empty($lng)?0:$lng;
						$lat =empty($lat)?0:$lat;
						
						$mi = $this->GetDistance($lat,$lng, $values['lat'],$values['lng'], 1);
						
						$mi = $mi > 1000? round($mi/1000,2).'km':$mi.'m';
						$values['juli'] = $mi;//店铺距离
						$values['shoplogo'] = empty($values['shoplogo'])? Mysite::$app->config['imgserver'].Mysite::$app->config['shoplogo']:Mysite::$app->config['imgserver'].$values['shoplogo'];
						$checkinfo = $this->shopIsopen($values['is_open'],$values['starttime'],$values['is_orderbefore'],$nowhour);
						$values['opentype'] = $checkinfo['opentype'];
						$values['newstartime']  =  $checkinfo['newstartime'];
						 
						$attrdet = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopattr where  cattype = 0 and shopid = ".$values['id']."");
						if(empty($this->platpsinfo)){
							$this->platpsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$$this->platpsinfo['admin_id']."' "); 
						}
						$checkps = 	 $this->pscost($values,$lng,$lat);
						 
						$values['pscost'] = $checkps['pscost'];
					   
						
						$cxinfo = $this->mysql->getarr("select name,id,imgurl from ".Mysite::$app->config['tablepre']."rule  where  FIND_IN_SET(".$values['id'].",shopid)   and status = 1   and ( limittype < 3  or ( limittype = 3 and endtime > ".time()." and starttime < ".time().")) ");
					   
						$cxinfodd = $cxinfo;
						 
						 $values['cxlist'] = $cxinfodd;
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
        $data  = $templist;
        $this->success($data);
    }


    //8.3新增闪惠商家详情页
    function shophuishow(){
        $shopid = IFilter::act(IReq::get('shopid'));
        $shopinfo = $this->mysql->select_one("select *  from  ".Mysite::$app->config['tablepre']."shop  where id = ".$shopid." ");
        if(empty($shopinfo)) $this->message('获取店铺数据失败');
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

        $cxinfo = $this->mysql->getarr("select name,id,imgurl from ".Mysite::$app->config['tablepre']."rule where   FIND_IN_SET(".$shopinfo['id'].",shopid)   and status = 1   and ( limittype < 3  or ( limittype = 3 and endtime > ".time()." and starttime < ".time().")) ");
        $cxlist = array();
        $data['shophui'][] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shophui where  status = 1 and shopid = ".$shopinfo['id']."");      
        $data['cxlist'] = $cxinfo;

        $areaid = ICookie::get('myaddress');

        $newshoparray = array_merge($shopinfo,$shopdet);
		
		$this->platpsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$newshoparray['admin_id']."' "); 
		
		
        $tempinfo =   $this->pscost($newshoparray);
        $backdata['pstype'] = $tempinfo['pstype'];
        $backdata['pscost'] = $tempinfo['pscost'];
        $data['psinfo'] = $backdata;


        $data['shopstart'] = $shopstart;
        $data['shopinfo'] = $shopinfo;
        $data['shopdet'] = $shopdet;
        $this->success($data);
    }

    //8.3新增app闪惠买单页面接口
    function huisubshow(){
		$backinfo = $this->checkappMem(); 
        $id = intval(IReq::get('shopid'));
        $list = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where id='".$id."'");
        $data['shopid'] = $list['id'];
        if(empty($list)) $this->message("获取商家失败");
        if( $list['shoptype'] == 0 ){
            $shopinfo  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop as a left join ".Mysite::$app->config['tablepre']."shopfast as b on a.id = b.shopid where a.id='".$id."'");
        }else{
            $shopinfo  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop as a left join ".Mysite::$app->config['tablepre']."shopmarket as b on a.id = b.shopid where a.id='".$id."'");
        }
        $weeknum = date("w"); //今天星期几
        $nowtime = time();
        if( $shopinfo['is_shophui']==1 && $shopinfo['is_hui']==1 ){
            $shophuiinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shophui where shopid = '".$shopinfo['id']."' and status=1 "." and starttime <= ".$nowtime." and endtime >=".$nowtime);
            if(!empty($shophuiinfo)){
                if( !empty($shophuiinfo['limitweek']) &&  !empty($shophuiinfo['limittimes']) ){
                    $weekarray = explode(',',$shophuiinfo['limitweek']);
                    $datey = date('Y-m-d',$nowtime);
                    $info =explode(',',$shophuiinfo['limittimes']);
                    $find = false;
                    foreach($info as $kc=>$val)
                    {
                        if(!empty($val))
                        {
                            $checkinfo = explode('-',$val);
                            if(!empty($checkinfo[1]))
                            {
                                $time1 = strtotime($datey.' '.$checkinfo[0].':00');
                                $time2 = strtotime($datey.' '.$checkinfo[1].':00');
                                if($nowtime > $time1 && $nowtime < $time2)
                                {
                                    $find = true;
                                    break;
                                }
                            }
                        }
                    }
                    if( in_array($weeknum,$weekarray)  &&  $nowtime >= $shophuiinfo['starttime']  &&  $nowtime <= $shophuiinfo['endtime'] && $find==true ){
                        $is_shophui = 1;  	// 当前时间有闪慧
                    }else{
                        $is_shophui = 0;
                    }
                }else{
                    $is_shophui  = 1;
                }
            }else{

                $shophuiinfo = array();
                $is_shophui  = 0;

            }
        }else{
            $shophuiinfo = array();
            $is_shophui  = 0;
        }
        $data['is_shophui'] = $is_shophui;
        $data['shophuiinfo'] = $shophuiinfo;
        $data['shopinfo'] = $shopinfo;
		$data['acountcost'] = empty($backinfo['cost'])?0:$backinfo['cost']; 
        $paylist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."paylist where  loginname ='weixinapp' or loginname ='alipayapp' or loginname ='open_acout' order by id asc limit 0,50");
        if(is_array($paylist)){
            $data['paylist'] = $paylist;
        }else{
//            $this->message('支付类型获取失败');
            $data['paylist'] = array();
        }
        $this->success($data);

    }


//8.3新增到店消费制作订单app接口  lzh  2016-6-7
    function makeshophuiorder(){
        $uid = intval( IFilter::act(IReq::get('uid')) );
        if( $uid > 0 ){
            $memberinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$uid."' ");
            $username = $memberinfo['username'];
        }

        $shopid = intval( IFilter::act(IReq::get('shopid')) );
        $huiid =  intval(IFilter::act(IReq::get('huiid')) );
        $xfcost =  IFilter::act(IReq::get('xfcost')) ;  //消费金额
        $buyorderphone = trim(IFilter::act(IReq::get('buyorderphone')));		 // 买单人 联系号
        $yhcost =  0 ;  //优惠金额
        $sjcost =  0 ;  //实际支付金额

        $pay =  IFilter::act(IReq::get('paytype'));
        if($pay == 'weixin'){
            $paytype=1;
        }elseif($pay == 'alimobile'){
            $paytype=2;
        }
        if(empty($xfcost)) $this->message('消费金额为空');
		if($xfcost > 0){
			
		}else{
			$this->message('消费金额必须大于0');
		}
      


        $shopone = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where id='".$shopid."' "); // 店铺信息\
        if( empty($shopone) ) $this->message("获取商户信息失败");
        if($shopone['shoptype'] == 0){
            $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop as a left join ".Mysite::$app->config['tablepre']."shopfast as b on a.id = b.shopid where a.id='".$shopid."' "); // 店铺信息
        }else{
            $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop as a left join ".Mysite::$app->config['tablepre']."shopmarket as b on a.id = b.shopid where a.id='".$shopid."' "); // 店铺信息
        }
		
        if( $shopinfo['is_shophui'] == 1 ){
            
                $shophuiinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shophui where shopid='".$shopid."' ");  //闪慧信息
                if(!empty($shophuiinfo)  && $shophuiinfo['shopid'] == $shopid) {
					 
					if( $shophuiinfo['controltype'] == 2 ){
						 
						$checkcost = $shophuiinfo['mjlimitcost']; // 每满费用金额
						if( $xfcost >= $checkcost  ){
							$yhcost = $shophuiinfo['controlcontent']; 
						}else{ 
						} 
						$data['huilimitcost'] = $shophuiinfo['mjlimitcost'];
						
					}
					if( $shophuiinfo['controltype'] == 3 ){
						 
						$checkcost = $shophuiinfo['limitzhekoucost']; // 打折金额限制
						if( $xfcost >= $checkcost  ){
							$yhcost = $xfcost*((100-$shophuiinfo['controlcontent'])/100);
							 
						}else{
						 
						}
						
						$data['huilimitcost'] = $shophuiinfo['limitzhekoucost'];
						
					}
					
					
					
                    $data['huilimitcost'] = $shophuiinfo['limitzhekoucost'];
                    $data['huiid'] = $shophuiinfo['id'];
                    $data['huiname'] = $shophuiinfo['name'];
                    $data['huitype'] = $shophuiinfo['controltype'];
                    $data['huicost'] = $shophuiinfo['controlcontent'];
					
					
					
					
					
					
					


                }else{
                    $data['huiid'] = '';
                    $data['huiname'] ='';
                    $data['huitype'] = '';
                    $data['huilimitcost'] = '';
                    $data['huicost'] = '';
                }
            
        }
		 if($yhcost > $xfcost){
			 $this->message('优惠金额不能大于消费总金额');
			 
		 }
	    $sjcost = $xfcost-$yhcost;
        $data['uid'] = $uid;
        $data['username'] = $username;
        $data['dno'] = time().rand(1000,9999);
        $data['shopid'] = $shopid;
        $data['shopname'] = $shopinfo['shopname'];
        $data['xfcost'] = $xfcost;
        $data['buyorderphone'] = $buyorderphone;
        $data['yhcost'] = $yhcost;
        $data['sjcost'] = $sjcost;
		
        if( $shopinfo['is_shgift'] == 1 ){
            $data['givejifen'] = floor($sjcost/$shopinfo['sendgift']);
        }else{
            $data['givejifen'] =  0;
        }

        $data['paytype'] = $paytype;
        $data['paystatus'] = 0;
        $data['status'] = 0;
        $data['addtime'] = time();
        $data['completetime'] =0;
        $this->mysql->insert(Mysite::$app->config['tablepre'].'shophuiorder',$data);
        $orderid = $this->mysql->insertid();
        if($orderid > 0){
            $array=array();
            $array['orderid']=$orderid;
            $this->success($array);
        }else{
            $this->message('订单制作失败');
        }
    }




	/* 8.3 新增下单分享优惠券数据 */
	function ordersharejuan(){
		
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$orderid = intval(IFilter::act(IReq::get('orderid')));		
		$juansetinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 4 or name = '下单送优惠券' " );  	   
        $juaninfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."alljuan where type = 4 or name= '下单送优惠券' order by id asc " );		
		$shareinfo = $this->mysql->select_one("select title,img,`describe`  from ".Mysite::$app->config['tablepre']."juanshowinfo where type=2 order by orderid asc  ");
		$shareinfo['img'] = Mysite::$app->config['siteurl'].$shareinfo['img'];
		$shareinfo['link'] = Mysite::$app->config['siteurl'].'/index.php?ctrl=wxsite&action=sharehb&did='.$orderid;		 				
		if( !empty($juaninfo) && $juansetinfo['status'] == 1 &&  !empty($shareinfo)  ){
			$data['shareinfo'] = $shareinfo;
		}else{
			$this->message('下单关闭分享图标');
		}	 
		$this->success($data);
		
	}
	
	/* 8.3 新增会员推广分享优惠券数据 */
	function memsharejuan(){
		
		$backinfo = $this->checkappMem();
		
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$jiamiuidkey = base64_encode($backinfo['uid']); 		 
		$juansetinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."alljuanset where type = 5 or name = '邀请好友送红包' " );  	   
        $juaninfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."alljuan where type = 5 or name= '邀请好友送红包' order by id asc " );
		$shareinfo = $this->mysql->select_one("select  title,img,`describe`  from ".Mysite::$app->config['tablepre']."juanshowinfo where type=3 order by orderid asc  ");
 		$shareinfo['img'] = Mysite::$app->config['siteurl'].$shareinfo['img'];		
		$shareinfo['link'] = Mysite::$app->config['siteurl'].'/index.php?ctrl=wxsite&action=memsharehb&key='.$jiamiuidkey;		 		
		if(!empty($juaninfo) && $juansetinfo['status'] == 1 &&  !empty($shareinfo)  ){
			$data['shareinfo'] = $shareinfo;
		}else{
			$this->message('会员推广关闭分享图标');
		}	 
		$this->success($data);
		
	}
	
	
	function memsharej(){   //会员中心推广分享优惠券页面
		
		$backinfo = $this->checkappMem();
		
 		$jiamiuidkey = base64_encode($backinfo['uid']);  //  base64_decode
		$data['jiamiuidkey'] = $jiamiuidkey;
  		$wxclass = new wx_s();
		$signPackage = $wxclass->getSignPackage();
 		$data['signPackage'] = $signPackage;
		$juansetinfo = $this->mysql->select_one("select status from ".Mysite::$app->config['tablepre']."alljuanset where type = 5 or name = '邀请好友送红包' " );  	   
        $juaninfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."alljuan where type = 5 or name= '邀请好友送红包' order by id asc " );
		$shareinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."juanshowinfo where type=3 order by orderid asc  ");		 
		if( empty($shareinfo) ){
			$shareinfo['title'] = Mysite::$app->config['sitename'];
			$shareinfo['img'] = Mysite::$app->config['sitelogo'];
			$shareinfo['describe'] = Mysite::$app->config['sitename'];
		}
		$data['shareinfo'] = $shareinfo;

		$memberinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid=".$backinfo['uid']."  ");
        
		$historyphone =   $_COOKIE['historyphone'];  //  ICookie::get('historyphone');
 		if( !empty($historyphone) ){
			$juanlist =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."juan where shareuid=".$backinfo['uid']."  and bangphone = '".$historyphone."' ");
		}else{
			$juanlist = array();
		}
 		$data['sengjuanstatus'] = $juansetinfo['status'];
 		$data['historyphone'] = $historyphone;
		$data['juanlist'] = $juanlist;
		$data['memberinfo'] = $memberinfo;
		Mysite::$app->setdata($data);
		
	}
		/* 8.3  会员中心推广分享优惠券页面 */
	function memsharejMMM(){   //会员忠心推广分享优惠券页面
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		} 
 		$jiamiuidkey = base64_encode($backinfo['uid']);  //  base64_decode
		$data['jiamiuidkey'] = $jiamiuidkey;
  	 
		$shareinfo = $this->mysql->select_one("select  *  from ".Mysite::$app->config['tablepre']."juanshowinfo where type=3 order by orderid asc  ");
		
		$shareinfo['link'] = Mysite::$app->config['siteurl'].'/index.php?ctrl=wxsite&action=memsharehb&key='.$jiamiuidkey;
		$data['shareinfo'] = $shareinfo;
		
		$userextensionsharejuan = Mysite::$app->config['userextensionsharejuan'];
 		
		$where = "  where type=3 and addtime < ".time()." and endtime > ".time()." and is_open = 1 and juannum = 1 ";
 		$checkinfosendjuan = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."juanrule ".$where." order by orderid asc ");
	 
	 
		if( !empty($checkinfosendjuan) && $userextensionsharejuan == 0 &&  !empty($shareinfo)  ){
			$data['shareinfo'] = $shareinfo;
		}else{
			$this->message('优惠券已经领取完毕');
		}
	 
   		$this->success($data);
		
	}



    //8.3新增商品上、下架功能 lzh 2016-6-7
    function editgoodslive(){
        $backinfo = $this->checkapp();
        if(empty($backinfo['uid'])){
            $this->message('nologin');
        }
        $shopinfo= $this->mysql->select_one("select id from ".Mysite::$app->config['tablepre']."shop where uid='".$backinfo['uid']."' ");
        if(empty($shopinfo)) $this->message('店铺获取失败');
        $shopid = $shopinfo['id'];
        $goodsid = IFilter::act(IReq::get('goodsid'));
        $is_live = IFilter::act(IReq::get('is_live'));
        if(empty($goodsid))	$this->message('商品不存在');
        $arr['is_live'] = $is_live;
        $this->mysql->update(Mysite::$app->config['tablepre'].'goods',$arr,"id='".$goodsid."' and shopid=".$shopid);
        $this->success($goodsid);
    }




    //8.4  新增店铺内搜索商品
    function stroresearchlist(){
        /* 搜索商品列表 */
        $weekji = date('w');
        $goodssearch = IFilter::act(IReq::get('searchname'));
        $shopid= IFilter::act(IReq::get('shopid'));
        $goodssearch= urldecode($goodssearch);
        if(!empty($goodssearch)) $goodlistwhere=" and name like '%".$goodssearch."%' ";
        $nowhour = date('H:i:s',time());
        $nowhour = strtotime($nowhour);
        $temparray = array();
        $shopinfo=$this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where id='".$shopid."'");
        $detaa = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goods where shopid='".$shopid."' and  FIND_IN_SET( ".$weekji." , `weeks` )  ".$goodlistwhere." order by good_order asc ");
        if(!empty($detaa)){
            foreach ( $detaa as $keyq=>$valq ){
                if($valq['is_cx'] == 1){
                    //测算促销 重新设置金额
                    $cxdata = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."goodscx where goodsid=".$valq['id']."  ");
                    $newdata = getgoodscx($valq['cost'],$cxdata);

                    $valq['zhekou'] = $newdata['zhekou'];
                    $valq['is_cx'] = $newdata['is_cx'];
                    $valq['cost'] = $newdata['cost'];
                }
                if( $shopinfo['shoptype'] == 1 ){
                    $shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket where  shopid = ".$valq['shopid']."   ");
                }else{
                    $shopdet = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast where  shopid = ".$valq['shopid']."   ");
                }
                $checkinfo = $this->shopIsopen($shopinfo['is_open'],$shopinfo['starttime'],$shopdet['is_orderbefore'],$nowhour);
                $valq['opentype'] = $checkinfo['opentype'];
                $temparray[] =$valq;
            }
        }
        $data['goodssearchlist'] = $temparray;
        $this->success($data);
    }
	
	//2016-6.14  新增 取单的提醒功能
	
	function txingorder(){
		 $orderid = IFilter::act(IReq::get('orderid'));
		 
		 if(empty($orderid)){
			 $this->message('订单错误');
		 }
		 $orderinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."order where id='".$orderid."'"); 
		 if(empty($orderinfo)) $this->message('订单不存在');
		 $orderps = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."orderps where orderid='".$orderid."'");
		 if(empty($orderps)) $this->message('配送单不存在');
		 if($orderps['status'] > 2) $this->message('订单已配送'); 
		 if(empty($orderinfo['psuid'])) $this->message('配送员还未抢单');
		 $psylist =  $this->mysql->select_one("select *  from ".Mysite::$app->config['tablepre']."apploginps  where uid='".$orderinfo['psuid']."' "); 
		  if(!empty($psylist)){
			$psCls = new apppsyclass(); 
			$psCls->sendmsg($psylist['userid'],'','取单提醒',$orderinfo['shopname'].'需要您取单',1);
 		  } 
		 $this->success('ok');
	}
	
	function shopyhorderlist(){
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		} 
		$shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where uid = '".$backinfo['uid']."' ");
		if(empty($shopinfo)){
				$this->message('店铺不存在');
		}
		 
		$where =" where shopid = '".$shopinfo['id']."' and paystatus = 1 ";
		$startday = trim(IReq::get('startday'));
		$endday = trim(IReq::get('endday'));
		if(!empty($startday)) $where .=" and addtime > ".strtotime($startday);
		if(!empty($endday)){
			  $info = strtotime($endday)+86399;
			  $where .=" and addtime < ".$info;
		} 
		
		
		
	 
		$page = intval(IFilter::act(IReq::get('page')));
		$pagesize = intval(IFilter::act(IReq::get('pagesize'))); 
		$pagesize = $pagesize > 0? $pagesize:10; 
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);   
	    $tempcxlist =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shophuiorder  ".$where." order by id desc  limit   ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."  ");
		$backdata = array();
		if(is_array($tempcxlist)){
			foreach($tempcxlist as $key=>$value){
				$shoptemp = $this->mysql->select_one("select shoplogo from ".Mysite::$app->config['tablepre']."shop where id = ".$value['shopid']."");
				$imgurl = empty($shoptemp['shoplogo'])? Mysite::$app->config['shoplogo']:$shoptemp['shoplogo'];
				$value['shoplogo'] =  Mysite::$app->config['siteurl'].$imgurl;
				$value['addtime'] =  date('Y-m-d H:i:s',$value['addtime']); 
				$backdata[] = $value; 
			}
		}
		 
		$this->success($backdata);  
	}
	
	function getonehuiorder(){
		$orderid = intval(IReq::get('orderid'));
		if($orderid < 1){
			$this->message('订单不存在');
		}
		$checkinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shophuiorder  where  id = ".$orderid." ");
		if(empty($checkinfo)){
			$this->message('订单不存在');
		} 
		$checkinfo['addtime'] = date('Y-m-d',$checkinfo['addtime']);
		$this->success($checkinfo); 
	}
	
	function useryhorderlist(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$where =" where uid = '".$backinfo['uid']."' ";
		$startday = trim(IReq::get('startday'));
		$endday = trim(IReq::get('endday'));
		if(!empty($startday)) $where .=" and addtime > ".strtotime($startday);
		if(!empty($endday)){
			  $info = strtotime($endday)+86399;
			  $where .=" and addtime < ".$info;
		} 
		$page = intval(IFilter::act(IReq::get('page')));
		$pagesize = intval(IFilter::act(IReq::get('pagesize'))); 
		$pagesize = $pagesize > 0? $pagesize:10; 
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);   
	    $tempcxlist =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shophuiorder  ".$where." order by id desc  limit   ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."  ");
		$backdata = array();
		if(is_array($tempcxlist)){
			foreach($tempcxlist as $key=>$value){
				$shoptemp = $this->mysql->select_one("select shoplogo from ".Mysite::$app->config['tablepre']."shop where id = ".$value['shopid']."");
				$imgurl = empty($shoptemp['shoplogo'])? Mysite::$app->config['shoplogo']:$shoptemp['shoplogo'];
				$value['shoplogo'] =  Mysite::$app->config['siteurl'].$imgurl;
				$value['addtime'] =  date('Y-m-d H:i:s',$value['addtime']); 
				$backdata[] = $value; 
			}
		}
		 
		$this->success($backdata); 
	}
	//删除优惠订单id
	function delyhorder(){
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$orderid = intval(IReq::get('orderid'));
		if($orderid < 1){
			$this->message('订单不存在');
		}
		$checkinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shophuiorder  where  id = ".$orderid." ");
		if(empty($checkinfo)){
			$this->message('订单不存在');
		}
		if($checkinfo['paystatus'] == 1){
			$this->message('已支付不能删除,删除请联系平台');
		}
		if($checkinfo['uid'] != $backinfo['uid']){
			$this->message('订单不属于您管理');
		}
	    $this->mysql->delete(Mysite::$app->config['tablepre']."shophuiorder"," id='".$orderid."'");
	    $this->success('success');
	}


    //新增礼品详情页面接口   2016-6-28  lzh
    function giftinfo(){
        $id = intval(IReq::get('id'));
        $backdata['giftinfo'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."gift where id = ".$id);
        $this->success($backdata);
    }
	 
	/** 	
     * @userapi 
     * @name 分享设置
     * @other 2017/8/19   赵 
     * @datatype 固定值 json 必传  
	*{
	*	"error": false,
	*	"msg": {
	*		"ymengkey": "2989",【友盟账号id】 
	*		"qqshareappid": "",【qq分享id】 为空时不能分享
	*		"qqsharekey": "",【qq分享key】 
	*		"wxshareappid": "",【微信分享id】为空时不能分享
	*		"wxsharekey": "",【微信分享key】 
	*	}
	*}   
	*/
	function sharesetxxx(){
		$backdata = array(
			'ymengkey'=> Mysite::$app->config['ymengkey'], 
			'qqshareappid'=> Mysite::$app->config['qqshareappid'],
			'qqsharekey'=> Mysite::$app->config['qqsharekey'],
			'wxshareappid'=>'',
			'wxsharekey'=>'',
		); 
		 
		$weixindir = hopedir.'/plug/pay/weixinapp/lib/WxPay.Config.php'; 
		if(file_exists($weixindir)){
			include_once($weixindir);
			$backdata['wxshareappid'] = WxPayConfig::APPID;
			$backdata['wxsharekey'] = WxPayConfig::APPSECRET;
		}
		$this->success($backdata); 
	}
	 
	  /*获取所有历史订单  商家端  2019-09-29 */
	 
	 function allorder(){
		$statusarr = array('0'=>'新订单','1'=>'待发货','2'=>'待完成','3'=>'完成','4'=>'关闭','5'=>'关闭');
		$gostatusarr = array('0'=>'新订单','1'=>'待消费','2'=>'待消费','3'=>'已消费','4'=>'关闭','5'=>'关闭');
		$backinfo = $this->checkapp();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		//
		 $where = '';
		$startday = trim(IReq::get('startday'));
		$endday = trim(IReq::get('endday'));
		if(!empty($startday)) $where .=" and addtime > ".strtotime($startday);
		if(!empty($endday)){
			  $info = strtotime($endday)+86399;
			  $where .=" and addtime < ".$info;
		} 
		$where .= " and status = 3 and is_reback = 0 and is_make = 1 ";
		$page = intval(IFilter::act(IReq::get('page')));
		$pagesize = intval(IFilter::act(IReq::get('pagesize'))); 
		$pagesize = $pagesize > 0? $pagesize:10; 
		$this->pageCls->setpage(intval(IReq::get('page')),$pagesize);   
  		
		$orderlist =  $this->mysql->getarr("select id,addtime,posttime,paytype,paystatus,dno,is_reback,allcost,status,is_make,daycode,buyeruid,is_goshop,buyername,buyerphone,buyeraddress,postdate from ".Mysite::$app->config['tablepre']."order where shopuid = ".$backinfo['uid']." ".$where." order by addtime desc  limit   ".$this->pageCls->startnum().", ".$this->pageCls->getsize()."   ");   /* and posttime < ".$endtime." */
		$backdatalist = array();
		foreach($orderlist as $key=>$value){
			if($value['is_goshop'] == 1){
				$value['showstatus'] = $gostatusarr[$value['status']];
			}else{
				$value['showstatus'] = $statusarr[$value['status']]; 
			}
			$value['is_yuding'] = $value['posttime'] - $value['addtime'] > 1800?'1':'2';
			$value['addtime'] = date('H:i:s',$value['addtime']);
			$value['posttime'] = date('m-d',$value['posttime']);
			$value['posttime'] = $value['posttime'].' '.$value['postdate'];
			if($value['paytype'] == 1){
				$value['payresult'] = '在线支付';
				if($value['paystatus'] == 1){
					$value['payresult'] .= '已付';
					if($value['is_reback'] == 1){
						$value['payresult'] = '申请退款';
					}elseif($value['is_reback'] == 2){
						$value['payresult'] = '退款成功';
					}elseif($value['is_reback'] == 3){
						 $value['payresult'] = '取消退款';
					}
				}else{
					$value['payresult'] .= '未付';
				}
			}else{
				$value['payresult'] = '货到支付';
			}
			$checkuid = intval($value['buyeruid']);
			if($checkuid > 0){
				$value['orderNum'] = $this->mysql->counts("select  * from ".Mysite::$app->config['tablepre']."order where buyeruid = ".$value['buyeruid']."  and status = 3 ");
		
			}else{
				$value['orderNum'] =  0;
			}
			//统计下单次数
				if($value['status'] ==  1){
				if($value['is_make'] == 0){
					$value['showstatus'] = $value['is_goshop']  == 1?'新订台订单':'新订单';
				}elseif($value['status'] !=1){
					$value['showstatus'] = $value['is_goshop']  == 1?'商家取消订单':'取消制作'; 
				}
			}
			$backdatalist[] = $value;
		}
		$this->success($backdatalist);
	}
	 
	 
		
//新增函数 
	
	function adrmap(){ 
		$ghlnglat = trim(IFilter::act(IReq::get('ghlnglat')));
 		$data['ghlnglat'] = $ghlnglat;
		Mysite::$app->setdata($data);
	}
	 
	 function ptadrmap(){ 
		$ghlnglat = trim(IFilter::act(IReq::get('ghlnglat')));
 		$data['ghlnglat'] = $ghlnglat;
		Mysite::$app->setdata($data);
	} 
	
	function regtokenerr(){
		logwrite('注册苹果失败');
		$this->success('操作成功');
	}
	
	
	function checkorderclose(){ 
		$backinfo = $this->checkappMem();
		if(empty($backinfo['uid'])){
			$this->message('nologin');
		}
		$orderids =  trim(IFilter::act(IReq::get('orderids')));
		if(empty($orderids)){
			$this->message('emptyorderid1');
		}
		$ids = explode(',',$orderids);
		$ids = array_filter($ids);
		if(count($ids) == 0){
			$this->message('emptyorderid2');
		} 
		//print_r($ids);
		$orderlist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."order where id in(".join(',',$ids).") order by id asc"); 
        $newids = array();
		$checktime = time()-15*60;
		//print_r($orderlist);
		foreach($orderlist as $key=>$orderinfo){ 
			if($orderinfo['addtime'] < $checktime && $orderinfo['paytype'] == 1 && $orderinfo['paystatus'] == 0 && $orderinfo['status'] < 2){
				$newdata['status'] = 4; 
				$this->mysql->update(Mysite::$app->config['tablepre'].'order',$newdata,"id='".$orderinfo['id']."'");
				$orderCLs = new orderclass(); 
				$orderCLs->writewuliustatus($orderinfo['id'],16,$orderinfo['paytype']);  //在线支付成功状态	  
				$newids[] = $orderinfo['id'];
			} 
		}
		if(count($newids) == 0){
			$this->message('emptyorderid3');
		}
		$this->success(join(',',$newids));
		
	}
	
	
	function shopneed(){
		$shopuid = intval(IFilter::act(IReq::get('uid')));
		$daymintime = strtotime(date('Y-m-d',time()));
	    $tempshu =  $this->mysql->select_one("select count(id) as shuliang  from ".Mysite::$app->config['tablepre']."order where shopuid='".$shopuid."' and  status > 0  and  status <  3 and is_make = 0 and posttime > ".$daymintime." limit 0,1000");
	    $hidecount = isset($tempshu['shuliang'])?$tempshu['shuliang']:0;
	    $this->success($hidecount); 
	}
	 
	
	
}