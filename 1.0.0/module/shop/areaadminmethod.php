<?php
class method   extends areaadminbaseclass
{
	
	 function cxrulelist(){
             $cityid = $this->admin['cityid'];
             
             $cxinfolist = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."rule where  parentid = 1  and  cityid = ".$cityid." order by id asc " );
             $data['cxrulelist'] = $cxinfolist;
             $data['nowtime'] = time();
			 #print_r($data);exit;
             Mysite::$app->setdata($data); 
         }
	 function addcxrule(){
		   $id = intval(IReq::get('id'));      
		   $cxinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."rule where  id = ".$id."   " );
		   $cityid = $this->admin['cityid'];		    
		   $shoplist = array();
		   $shoplist = $this->mysql->getarr("select id,shopname,shoptype from ".Mysite::$app->config['tablepre']."shop where is_pass = 1 and admin_id = ".$cityid."   " );
		   
		   foreach($shoplist as $k=>$v){
			   if($v['shoptype']==1){
				   $psinfo = $this->mysql->select_one("select sendtype from ".Mysite::$app->config['tablepre']."shopmarket where  shopid = ".$v['id']."   " );
				   if($psinfo['sendtype'] == 1){
					   $shopps[] = $v;   
				   }else{
					   $platps[] = $v;   
				   }			   
			   }else{
				   $psinfo = $this->mysql->select_one("select sendtype from ".Mysite::$app->config['tablepre']."shopfast where  shopid = ".$v['id']."   " );
				   if($psinfo['sendtype'] == 1){
					   $shopps[] = $v;   
				   }else{
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
	 function addcxrule1(){
		   $id = intval(IReq::get('id')); 
		   $cityid = $this->admin['cityid'];
		   $cxinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."rule where  id = ".$id."   " );
   
		   $shoplist = $this->mysql->getarr("select id,shopname from ".Mysite::$app->config['tablepre']."shop where  admin_id = ".$cityid."   " );
		   $data['cxsignlist'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."goodssign where type='cx' order by id desc limit 0, 100");
		   $data['cxinfo'] = $cxinfo;
		   $data['shoplist'] = $shoplist;
		   Mysite::$app->setdata($data);                
	 }
	 function delcxrule(){
		   $id = IReq::get('id'); 
		   if(empty($id))  $this->message('id??????');
		   $ids = is_array($id)? join(',',$id):$id;    
		   $this->mysql->delete(Mysite::$app->config['tablepre'].'rule',"id in($ids)");  
		   $this->success('success');  
         }
    function savecxrule(){
			$shopidarr = IReq::get('shopid');
			if(empty($shopidarr))$this->message('???????????????????????????');
			$data['shopid'] = implode(',',$shopidarr);	
			$data['parentid'] = intval(IReq::get('parentid'));
			$data['shopbili'] = intval(IReq::get('shopbili'));
			$data['cityid'] = $this->admin['cityid'];
			$data['type'] = 1;//?????????????????????
			$cxid = intval(IReq::get('cxid'));
			$controltype = intval(IReq::get('controltype'));//1???????????? 2???????????? 3???????????? 4???????????? 5????????????
			$data['controltype'] = $controltype;
			$setinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."cxruleset where  id = ".$controltype."   " );
			$data['imgurl'] = $setinfo['imgurl'];//????????????
			$data['supporttype'] = $setinfo['supportorder'];//?????????????????? 1?????????????????? 2???????????????????????????
			$data['supportplatform'] = $setinfo['supportplat'];//?????????????????? 1pc 2?????? 3?????? 4app
			$data['status'] =  intval(IReq::get('status'));
			$ordertype = $data['supporttype']==2?'???????????????':'???';
			if($controltype == 1){//1????????????
				$data['limitcontent'] = intval(IReq::get('limitcontent_1'));
				$data['presenttitle'] = trim(IFilter::act(IReq::get('presenttitle')));
				if(empty($data['limitcontent'])) $this->message('???????????????????????????');
				if(empty($data['presenttitle'])) $this->message('??????????????????????????????'); 
				$data['name']= $ordertype.''.$data['limitcontent'].'??????'.$data['presenttitle'];	 
			}
			if($controltype == 2){//2????????????
				$limitcontent = IReq::get('limitcontent_2');
				$controlcontent = IReq::get('controlcontent_2');
				$data['limitcontent'] = implode(',',$limitcontent);
				$data['controlcontent'] = implode(',',$controlcontent);			
				$name = $data['supporttype']==2?'????????????':'';
				foreach($limitcontent as $k=>$v){
					$name .= '???'.$v.'???'.$controlcontent[$k].';';
				}
				$data['name'] = rtrim($name, ";");
			}
			if($controltype == 3){//3????????????
				$data['limitcontent'] = intval(IReq::get('limitcontent_3'));
				$data['controlcontent'] = intval(IReq::get('controlcontent_3'));
				$zhe = $data['controlcontent']/10;
				$data['name']= $ordertype.''.$data['limitcontent'].'???'.$zhe.'?????????';
				if(empty($data['limitcontent'])) $this->message('???????????????????????????');
				if(empty($data['controlcontent'])) $this->message('??????????????????'); 
			}
			if($controltype == 4){//4????????????
				$data['limitcontent'] = intval(IReq::get('limitcontent_4'));			 
				$data['name']= $ordertype.''.$data['limitcontent'].'??????????????????';
				if(empty($data['limitcontent'])) $this->message('???????????????????????????');			 
			}
			if($controltype == 5){//5????????????
				$data['limitcontent'] = 0;	
				$data['controlcontent'] = intval(IReq::get('controlcontent_5'));	
				$data['name']= '?????????????????????'.$data['controlcontent'].'???';	 	
			}
			if(empty($data['name'])) $this->message('????????????????????????');
			$limittype = intval(IReq::get('limittype'));//1????????? 2?????????????????? 3???????????????
			$data['limittype'] = in_array($limittype,array('1,','2','3')) ? $limittype:1;
			if($data['limittype'] ==  1){
				$data['limittime'] = '';
			}elseif($data['limittype'] == 2){
				$limittime = IFilter::act(IReq::get('limittime1'));
				if(!is_array($limittime)) $this->message('errweek');
				$data['limittime'] = join(',',$limittime);
			}else{
				$starttime = IFilter::act(IReq::get('starttime'));
				$endtime = IFilter::act(IReq::get('endtime'));			
				if(empty($starttime)) $this->message('cx_starttime');
				if(empty($endtime)) $this->message('cx_endtime');        
				$data['starttime'] = strtotime($starttime.' 00:00:00');
				$data['endtime'] = strtotime($endtime.' 23:59:59');
				if($data['endtime'] <= $data['starttime']) $this->message('????????????????????????????????????');     
			}  		
			if(empty($cxid)){
				$data['creattime'] = time();
				$this->mysql->insert(Mysite::$app->config['tablepre'].'rule',$data);
			}else{        
				$this->mysql->update(Mysite::$app->config['tablepre'].'rule',$data,"id='".$cxid."'");
			}
			
			$this->success('success');
    }
	
	 function cateset(){ 
			 
 			$catparent = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype  where  type='checkbox' order by cattype asc limit 0,100");
			$catlist = array();
			foreach($catparent as $key=>$value){
				$tempcat   = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype  where parent_id = '".$value['id']."'  limit 0,100");
				foreach($tempcat as $k=>$v){
					 $catlist[] = $v;
				}
			}
			$data['catarr'] = array('0'=>'??????','1'=>'??????');
			$data['catlist'] = $catlist;  
			$data['appadvlist'] =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."appadv where cityid = '".$this->admin['cityid']."'  order by orderid asc   limit 0,100");
			
			
          	Mysite::$app->setdata($data); 
		 
	 }
	function showshopdetail(){		//????????????
		$id = intval(IReq::get('id'));
		 $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where  id='".$id."'  ");
		# print_r($shopinfo);
		$data['shopinfo']  = $shopinfo;
		 Mysite::$app->setdata($data);
	}
	//????????????
	function saveshop()
	{
		$subtype = intval(IReq::get('subtype'));
		$id = intval(IReq::get('uid'));
		if(!in_array($subtype,array(1,2))) $this->message('system_err');
		if($subtype == 1){
			  $username = IReq::get('username');
			  if(empty($username)) $this->message('member_emptyname');
				$testinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where username='".$username."'  ");
			  if(empty($testinfo)) $this->message('member_noexit');
			  if($testinfo['admin_id'] != $this->admin['cityid']) $this->message('shop_noownadmin');
			  $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."usrlimit where  `group`='".$testinfo['group']."' and  name='editshop' ");
			  if(empty($shopinfo)) $this->message('member_noownshop');
			  $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where  uid='".$testinfo['uid']."' ");
			  if(!empty($shopinfo)) $this->message('member_isbangshop');
			  $data['shopname'] = IReq::get('shopname');
			  if(empty($data['shopname']))  $this->message('shop_emptyname');
			  $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where  shopname='".$data['shopname']."'  ");
			  if(!empty($shopinfo)) $this->message('shop_repeatname');
			  $this->mysql->update(Mysite::$app->config['tablepre'].'member',array('admin_id'=>$this->admin['cityid']),"uid='".$testinfo['uid']."'");	 
			  $data['uid'] = $testinfo['uid'];
			  $data['admin_id'] = $this->admin['cityid'];
			  $data['shoptype'] = intval(IReq::get('shoptype'));
			  $nowday = 24*60*60*365;
	       $data['endtime'] = time()+$nowday;
	       $data['is_pass'] = 1;
			$data['yjin']  = Mysite::$app->config['yjin']; //??????????????????
			  $this->mysql->insert(Mysite::$app->config['tablepre'].'shop',$data);
			  $this->success('success');
		}elseif($subtype ==  2){
			/*??????*/
			$data['username'] = IReq::get('username');
		  $data['phone'] = IReq::get('maphone');
      $data['email'] = IReq::get('email');
      $data['password'] = IReq::get('password');
      $sdata['shopname'] = IReq::get('shopname');
       if(empty($sdata['shopname']))  $this->message('shop_emptyname');
		   $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where  shopname='".$sdata['shopname']."'  ");
			 if(!empty($shopinfo)) $this->message('shop_repeatname');
			 $password2 = IReq::get('password2');
		   if($password2 != $data['password']) $this->message('member_twopwdnoequale');
			 $uid = 0;
			 if($this->memberCls->regester($data['email'],$data['username'],$data['password'],$data['phone'],3)){
			 	 $uid = $this->memberCls->getuid();
			 	 $this->mysql->update(Mysite::$app->config['tablepre'].'member',array('admin_id'=>$this->admin['cityid']),"uid='".$uid."'");	 
			 }else{
			 	 $this->message($this->memberCls->ero());
			 }
      $sdata['uid'] = $uid;
      $sdata['maphone'] =  $data['phone'];
      $sdata['addtime'] = time();
      $sdata['email'] =  $data['email'];
      $sdata['shoptype'] = intval(IReq::get('shoptype'));
      $nowday = 24*60*60*365;
	     $sdata['endtime'] = time()+$nowday;
	     $sdata['admin_id'] = $this->admin['cityid'];
		 $sdata['is_pass'] = 1;
		$sdata['yjin']  = Mysite::$app->config['yjin']; //??????????????????
      $this->mysql->insert(Mysite::$app->config['tablepre'].'shop',$sdata);
		  $this->success('success');
		}else{
		 $this->message('nodefined_func');
		}
	}
	 function shopbiaoqian()
	 {
	 	  $this->setstatus();
	 	  $shopid =  intval(IReq::get('id'));
	 	  if(empty($shopid))
	 	  {
	 	  	 echo 'shop_noexit';
	 	  	 exit;
	 	   }
	 	  $shopinfo= $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where id=".$shopid."  ");
	 	  if(empty($shopinfo))
	 	  {
	 	     echo 'shop_noexit';
	 	  	 exit;
	 	  }
	 	  $fastfood = array();
	 	  if($shopinfo['shoptype'] == 0){
	 	     $fastfood = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopfast where shopid=".$shopid."  ");
	   	}else{
			 $fastfood = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopmarket where shopid=".$shopid."  ");

		}
	 	  $attrinfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where  cattype='".$shopinfo['shoptype']."' and  parent_id = 0 and is_admin = 1  order by orderid desc limit 0,1000");//??????????????????????????????
	 	  $data['attrlist'] = array(); //???????????????  --???????????????
	    foreach($attrinfo as $key=>$value){
	  	   $value['det'] =  $this->mysql->getarr("select id,name,instro from ".Mysite::$app->config['tablepre']."shoptype where  cattype='".$shopinfo['shoptype']."' and   parent_id = ".$value['id']." order by id desc ");
	  	   $data['attrlist'][] = $value;
	    }
	 	  $shopsetatt = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopattr where    cattype='".$shopinfo['shoptype']."' and  shopid = '".$shopid."'  limit 0,1000");
	    $myattr = array();
	    foreach($shopsetatt as $key=>$value){
	  	    $myattr[$value['firstattr'].'-'.$value['attrid']] = $value['value'];
	    }
	    $data['myattr'] = $myattr;
	 	  $data['fastfood'] = $fastfood;
	 	  $data['shopid'] = $shopid;
	 	  $data['shopinfo'] = $shopinfo;
		  
		  
		  
		  $data['ztylist'] =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."specialpage where  is_custom = 0 and showtype = 0 and is_show = 1 order by orderid asc ");
		 
		  
	    Mysite::$app->setdata($data);
	  }
	  
	  function savemoreshop(){  //??????????????????
		
      $sdata['shopname'] = IReq::get('shopname');
		$data['username'] = IReq::get('username');
		  $data['phone'] = IReq::get('maphone');
       $data['password'] = IReq::get('password');
       if(empty($sdata['shopname']))  $this->message('shop_emptyname');
		   $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where  shopname='".$sdata['shopname']."'  ");
			 if(!empty($shopinfo)) $this->message('shop_repeatname');
 			 $uid = 0;
			 if($this->memberCls->regester($data['email'],$data['username'],$data['password'],$data['phone'],3)){
			 	$uid = $this->memberCls->getuid(); 
			 	$this->mysql->update(Mysite::$app->config['tablepre'].'member',array('admin_id'=>intval(IReq::get('admin_id'))),"uid='".$uid."'");
			 	
			 }else{
			 	 $this->message($this->memberCls->ero());
			 }
      $sdata['uid'] = $uid;
      $sdata['maphone'] =  $data['phone'];
      $sdata['addtime'] = time();
       $sdata['admin_id'] = $this->admin['cityid'];
      $nowday = 24*60*60*365;
	     $sdata['endtime'] = time()+$nowday;
  
  
		$shoptype =  IReq::get('shoptype') ; 
	  $temparray = explode('_',$shoptype);
	  $sdata['yjin'] = Mysite::$app->config['yjin'];
	   
	  $sdata['shoptype']  = $temparray[0];   // ??????????????? 0????????? 1?????????
	  $attrid =  $temparray[1];
	   
  
	   $checkshoptype =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shoptype where id=".$attrid."  ");
	   if(empty($checkshoptype))  $this->message("????????????????????????");
	   
	   $sdata['is_pass']  = 1;
	    $this->mysql->insert(Mysite::$app->config['tablepre'].'shop',$sdata);
	  
	   $shopid = $this->mysql->insertid();
	    
	   $attrdata['shopid'] = $shopid;
	   $attrdata['cattype'] = $checkshoptype['cattype'];
	   $attrdata['firstattr'] = $checkshoptype['parent_id'];
	   $attrdata['attrid'] = $checkshoptype['id'];
	   $attrdata['value'] = $checkshoptype['name']; 
	   
	   $this->mysql->insert(Mysite::$app->config['tablepre'].'shopattr',$attrdata);
	  
		  $this->success('success');
		
	}
	 function saveshopbq()
	{   
		 $id = IReq::get('ids');
		 $shopid = intval(IReq::get('shopid'));
		 
		 if(empty($shopid))
		 {
		 	  echo "<script>parent.uploaderror('??????????????????');</script>";
		 	 exit;
		 	}
		 	
		  $is_recom = intval(IReq::get('is_recom'));
		  $isforyou = intval(IReq::get('isforyou'));
          $is_selfsitecx = intval(IReq::get('is_selfsitecx'));		  
		  if($is_selfsitecx != 1){
			 $this->mysql->delete(Mysite::$app->config['tablepre'] . 'rule', "shopid = '$shopid'");  
		  }
		  $shopinfo= $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where id=".$shopid."  ");
		  if(!empty($shopinfo)){
		  	$udata['is_recom'] = $is_recom;
			$udata['is_selfsitecx'] = $is_selfsitecx;
			$udata['isforyou'] = $isforyou;
		    	$this->mysql->update(Mysite::$app->config['tablepre'].'shop',$udata,"id='".$shopid."'");
		  }
	  if($shopinfo['shoptype'] == 0){
		   $fastfood = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopfast where shopid=".$shopid."  ");
		   if(count($fastfood) > 0){
		 	  $data['is_com'] = intval(IReq::get('fis_com'));
		 	  $data['is_hot'] = intval(IReq::get('fis_hot'));
		 	  $data['is_new'] = intval(IReq::get('fis_new'));
			  $data['is_hui'] = intval(IReq::get('fis_hui'));
		 	   $this->mysql->update(Mysite::$app->config['tablepre'].'shopfast',$data,"shopid='".$shopid."'");
		   }
	  }else{
		    $fastfood = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopmarket where shopid=".$shopid."  ");
		   if(count($fastfood) > 0){
		 	
		 	  $data['is_hui'] = intval(IReq::get('fis_hui'));
			
		 	   $this->mysql->update(Mysite::$app->config['tablepre'].'shopmarket',$data,"shopid='".$shopid."'");
		   }
	  }

		$attrinfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where  cattype = '".$shopinfo['shoptype']."' and parent_id = 0 and is_admin = 1  order by orderid desc limit 0,1000");
		$tempinfo = array();
		foreach($attrinfo as $key=>$value){
			    $tempinfo[] = $value['id'];
		}
		if(count($tempinfo) > 0){
			//???????????????????????????????????????
			 $this->mysql->delete(Mysite::$app->config['tablepre']."shopattr"," shopid='".$shopid."' and firstattr in(".join(',',$tempinfo).") ");
		   //???????????????
		  foreach($attrinfo as $key=>$value){
			     //shopid     value ;
			     $attrdata['shopid'] = $shopid;
			     $attrdata['cattype'] = $shopinfo['shoptype'];
			     $attrdata['firstattr']  = $value['id'];
			     $inputdata = IFilter::act(IReq::get('mydata'.$value['id']));

			     //shopid  cattype     value;
			     if($value['type'] == 'input'){
			     	 $attrdata['attrid'] = 0;
			     	 $attrdata['value'] = $inputdata;
			     	 $this->mysql->insert(Mysite::$app->config['tablepre']."shopattr",$attrdata);
			     }elseif($value['type'] == 'img'){
			     	 $temp = array();
			     	 $temp = is_array($inputdata)?$inputdata:array($inputdata);
			     	 $ids = join(',',$temp);
			     	 if(empty($ids)){
			     	    continue;
			     	 }
			     	 $tempattr  = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where id in(".$ids.")   order by orderid desc limit 0,1000");
			     	 foreach($tempattr as $ky=>$val){
			     	 	$attrdata['attrid'] = $val['id'];
			     	  $attrdata['value'] = $val['name'];
			     	  $this->mysql->insert(Mysite::$app->config['tablepre']."shopattr",$attrdata);
			     	 }
			     }elseif($value['type'] =='checkbox'){
			     	 $temp = array();
			     	 $temp = is_array($inputdata)?$inputdata:array($inputdata);
			     	 $ids = join(',',$temp);
			     	 if(empty($ids)){
			     	    continue;
			     	 }
			     	 $tempattr  = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where id in(".$ids.")   order by orderid desc limit 0,1000");
			     	 foreach($tempattr as $ky=>$val){
			     	 	$attrdata['attrid'] = $val['id'];
			     	  $attrdata['value'] = $val['name'];
			     	  $this->mysql->insert(Mysite::$app->config['tablepre']."shopattr",$attrdata);
			     	 }
			     }elseif($value['type'] = 'radio'){
			     	 //$this->json($inputdata);
			     	  $tempattr  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shoptype where id in(".intval($inputdata).")   order by orderid desc limit 0,1000");
			     	  if(empty($tempattr)){
			     	    continue;
			     	  }

			     	  $attrdata['attrid'] = $tempattr['id'];
			     	  $attrdata['value'] = $tempattr['name'];
			     	  $this->mysql->insert(Mysite::$app->config['tablepre']."shopattr",$attrdata);
			     }else{
			      continue;
		       }
		  }
		  //is_search
		  $this->mysql->delete(Mysite::$app->config['tablepre']."shopsearch"," shopid='".$shopid."'  and parent_id in(".join(',',$tempinfo).") ");
		  foreach($attrinfo as $key=>$value){
		  	if($value['is_search'] == 1 && $value['type'] != 'input'){
		  		$inputdata = IFilter::act(IReq::get('mydata'.$value['id']));
		  		$temp = is_array($inputdata)?$inputdata:array($inputdata);
		  		foreach($temp as $ky=>$val){
		  			$searchdata['shopid'] = $shopid;
		  			$searchdata['parent_id'] = $value['id'];
		  			$searchdata['cattype'] = $shopinfo['shoptype'];
		  			$searchdata['second_id'] = intval($val);
		  			if($val > 0){
		  				 $this->mysql->insert(Mysite::$app->config['tablepre']."shopsearch",$searchdata);
		  			}
		  		}

		  	}
		  }
		}
		 echo "<script>parent.uploadsucess('');</script>";
		 exit;
	}
	 
	function saveshopbqxxx()
	{
		 $id = IReq::get('ids');
		 $shopid = intval(IReq::get('shopid'));
		 
		 if(empty($shopid))
		 {
		 	  echo "<script>parent.uploaderror('??????????????????');</script>";
		 	 exit;
		 	}
		 	//fis_com
		  $is_recom = intval(IReq::get('is_recom'));
		  $isforyou = intval(IReq::get('isforyou'));
          $is_selfsitecx = intval(IReq::get('is_selfsitecx'));
		  if($is_selfsitecx != 1){
			 $this->mysql->delete(Mysite::$app->config['tablepre'] . 'rule', "shopid = '$shopid'");  
		  }
		  if(!empty($shopinfo)){
		  	$udata['is_recom'] = $is_recom;
			$udata['is_selfsitecx'] = $is_selfsitecx;
			$udata['isforyou'] = $isforyou;
		    	$this->mysql->update(Mysite::$app->config['tablepre'].'shop',$udata,"id='".$shopid."'");
		  }
	  if($shopinfo['shoptype'] == 0){
		   $fastfood = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopfast where shopid=".$shopid."  ");
		   if(count($fastfood) > 0){
		 	  $data['is_com'] = intval(IReq::get('fis_com'));
		 	  $data['is_hot'] = intval(IReq::get('fis_hot'));
		 	  $data['is_new'] = intval(IReq::get('fis_new'));
			  $data['is_hui'] = intval(IReq::get('fis_hui'));
		 	   $this->mysql->update(Mysite::$app->config['tablepre'].'shopfast',$data,"shopid='".$shopid."'");
		   }
	  }else{
		    $fastfood = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shopmarket where shopid=".$shopid."  ");
		   if(count($fastfood) > 0){
		 	
		 	  $data['is_hui'] = intval(IReq::get('fis_hui'));
			
		 	   $this->mysql->update(Mysite::$app->config['tablepre'].'shopmarket',$data,"shopid='".$shopid."'");
		   }
	  }

		$attrinfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where  cattype = '".$shopinfo['shoptype']."' and parent_id = 0 and is_admin = 1  order by orderid desc limit 0,1000");
		$tempinfo = array();
		foreach($attrinfo as $key=>$value){
			    $tempinfo[] = $value['id'];
		}
		if(count($tempinfo) > 0){
			//???????????????????????????????????????
			 $this->mysql->delete(Mysite::$app->config['tablepre']."shopattr"," shopid='".$shopid."' and firstattr in(".join(',',$tempinfo).") ");
		   //???????????????
		  foreach($attrinfo as $key=>$value){
			     //shopid     value ;
			     $attrdata['shopid'] = $shopid;
			     $attrdata['cattype'] = $shopinfo['shoptype'];
			     $attrdata['firstattr']  = $value['id'];
			     $inputdata = IFilter::act(IReq::get('mydata'.$value['id']));

			     //shopid  cattype     value;
			     if($value['type'] == 'input'){
			     	 $attrdata['attrid'] = 0;
			     	 $attrdata['value'] = $inputdata;
			     	 $this->mysql->insert(Mysite::$app->config['tablepre']."shopattr",$attrdata);
			     }elseif($value['type'] == 'img'){
			     	 $temp = array();
			     	 $temp = is_array($inputdata)?$inputdata:array($inputdata);
			     	 $ids = join(',',$temp);
			     	 if(empty($ids)){
			     	    continue;
			     	 }
			     	 $tempattr  = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where id in(".$ids.")   order by orderid desc limit 0,1000");
			     	 foreach($tempattr as $ky=>$val){
			     	 	$attrdata['attrid'] = $val['id'];
			     	  $attrdata['value'] = $val['name'];
			     	  $this->mysql->insert(Mysite::$app->config['tablepre']."shopattr",$attrdata);
			     	 }
			     }elseif($value['type'] =='checkbox'){
			     	 $temp = array();
			     	 $temp = is_array($inputdata)?$inputdata:array($inputdata);
			     	 $ids = join(',',$temp);
			     	 if(empty($ids)){
			     	    continue;
			     	 }
			     	 $tempattr  = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype where id in(".$ids.")   order by orderid desc limit 0,1000");
			     	 foreach($tempattr as $ky=>$val){
			     	 	$attrdata['attrid'] = $val['id'];
			     	  $attrdata['value'] = $val['name'];
			     	  $this->mysql->insert(Mysite::$app->config['tablepre']."shopattr",$attrdata);
			     	 }
			     }elseif($value['type'] = 'radio'){
			     	 //$this->json($inputdata);
			     	  $tempattr  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shoptype where id in(".intval($inputdata).")   order by orderid desc limit 0,1000");
			     	  if(empty($tempattr)){
			     	    continue;
			     	  }

			     	  $attrdata['attrid'] = $tempattr['id'];
			     	  $attrdata['value'] = $tempattr['name'];
			     	  $this->mysql->insert(Mysite::$app->config['tablepre']."shopattr",$attrdata);
			     }else{
			      continue;
		       }
		  }
		  //is_search
		  $this->mysql->delete(Mysite::$app->config['tablepre']."shopsearch"," shopid='".$shopid."'  and parent_id in(".join(',',$tempinfo).") ");
		  foreach($attrinfo as $key=>$value){
		  	if($value['is_search'] == 1 && $value['type'] != 'input'){
		  		$inputdata = IFilter::act(IReq::get('mydata'.$value['id']));
		  		$temp = is_array($inputdata)?$inputdata:array($inputdata);
		  		foreach($temp as $ky=>$val){
		  			$searchdata['shopid'] = $shopid;
		  			$searchdata['parent_id'] = $value['id'];
		  			$searchdata['cattype'] = $shopinfo['shoptype'];
		  			$searchdata['second_id'] = intval($val);
		  			if($val > 0){
		  				 $this->mysql->insert(Mysite::$app->config['tablepre']."shopsearch",$searchdata);
		  			}
		  		}

		  	}
		  }
		}
		 echo "<script>parent.uploadsucess('');</script>";
		 exit;
	}
	function passhop()
	{
		 $id = intval(IReq::get('id'));
		 $data['is_pass'] =  1;
		$data['yjin'] =Mysite::$app->config['yjin'];//??????????????????
		 if(empty($id)) $this->message('shop_noexit');
		  $tempattr  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop  where id=".$id." ");
	    if(empty($tempattr))$this->message('shop_noexit');
	     if($tempattr['admin_id'] != $this->admin['cityid']) $this->message('shop_noownadmin');
	  	$this->mysql->update(Mysite::$app->config['tablepre'].'shop',$data,"id='".$id."'");
	  	$cdata['group'] = 3;
	  	$this->mysql->update(Mysite::$app->config['tablepre'].'member',$cdata,"uid='".$tempattr['uid']."'");
	  	$this->success('success');
	}
	//????????????    ---??????????????????
	function savesetshopyjin(){
		 $yjin = IReq::get('yjin');
		 $shopid = intval(IReq::get('shopid'));
		 if(empty($shopid)) $this->message('shop_noexit');
		 $shopinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop  where id=".$shopid."  ");
		 if(empty($shopinfo)){
			 $this->message('???????????????????????????');
		 }
		 $userinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."member  where uid=".$shopinfo['uid']." ");
		 if(empty($userinfo)) $this->message('???????????????????????????');
		 $cdata['backacount'] = trim(IReq::get('backacount'));
		 if(empty($cdata['backacount'])) $this->message('????????????????????????');
		  $this->mysql->update(Mysite::$app->config['tablepre'].'member',$cdata,"uid='".$userinfo['uid']."'");
		 $data['yjin'] = round($yjin, 2);//$yjin;
		 $this->mysql->update(Mysite::$app->config['tablepre'].'shop',$data,"id='".$shopid."'");
		 $this->success('success');
	}
	//????????????
	function adminshoppx(){
		$shopid = intval(IReq::get('id'));
		$data['sort'] = intval(IReq::get('pxid'));
		 $tempattr  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop  where id=".$shopid." ");
	    if(empty($tempattr))$this->message('shop_noexit');
	    if($tempattr['admin_id'] != $this->admin['cityid']) $this->message('shop_noownadmin');
		$this->mysql->update(Mysite::$app->config['tablepre'].'shop',$data,"id='".$shopid."'");
	  $this->success('success');
	}
	//??????????????????
	function shopactivetime(){
		$shopid = intval(IReq::get('shopid'));
		$mysetclosetime= intval(IReq::get('mysetclosetime'));
		$nowday = 24*60*60*$mysetclosetime;
		$data['endtime'] = time()+$nowday;
		 $tempattr  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop  where id=".$shopid." ");
	    if(empty($tempattr))$this->message('shop_noexit');
	    if($tempattr['admin_id'] != $this->admin['cityid']) $this->message('shop_noownadmin');
		$this->mysql->update(Mysite::$app->config['tablepre'].'shop',$data,"id='".$shopid."'");
		$this->success('success');
	}
	function delshop()
	{
		 $id = IReq::get('id');
		 if(empty($id))  $this->message('shop_noexit');
		  $tempattr  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop  where id=".$id." ");
		   if(empty($tempattr))$this->message('shop_noexit');
	     if($tempattr['admin_id'] != $this->admin['cityid']) $this->message('shop_noownadmin');
		  
		  
		 $ids = is_array($id)? join(',',$id):$id;
		 
		 
	   $this->mysql->delete(Mysite::$app->config['tablepre'].'shop',"id in($ids)");
	   /*???????????????????????????????????????*/
	   $this->mysql->delete(Mysite::$app->config['tablepre'].'goodstype',"shopid in($ids)");
     $this->mysql->delete(Mysite::$app->config['tablepre'].'goods',"shopid in($ids)");
     $this->mysql->delete(Mysite::$app->config['tablepre'].'shopmarket'," shopid in($ids)");
     $this->mysql->delete(Mysite::$app->config['tablepre'].'shopfast'," shopid in($ids)");
		 $this->mysql->delete(Mysite::$app->config['tablepre']."shopattr"," shopid in($ids)");
		 $this->mysql->delete(Mysite::$app->config['tablepre']."shopsearch"," shopid in($ids)");
		 $this->mysql->delete(Mysite::$app->config['tablepre']."areatoadd"," shopid  in($ids) "); //
	   $this->mysql->delete(Mysite::$app->config['tablepre']."searkey"," goid  in($ids)   ");
	   $this->mysql->delete(Mysite::$app->config['tablepre']."areamarket"," shopid  in($ids) ");
	   $this->mysql->delete(Mysite::$app->config['tablepre']."areatomar"," shopid  in($ids) ");
	   $this->mysql->delete(Mysite::$app->config['tablepre']."marketcate"," shopid  in($ids) ");
	   $this->mysql->delete(Mysite::$app->config['tablepre']."shopmarket"," shopid  in($ids) "); //

	   $this->success('success');
	} 
	function resetdefualt(){
		$shopid = IReq::get('shopid');
			 $tempattr  = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop  where id=".$shopid." ");
			 $link = IUrl::creatUrl('areaadminpage/shop');
	    if(empty($tempattr))$this->message('shop_noexit',$link);
	    if($tempattr['admin_id'] != $this->admin['cityid']) $this->message('shop_noownadmin',$link);
	  ICookie::set('adminshopid',$shopid,86400);
		$link = IUrl::creatUrl('shopcenter/useredit');
    $this->refunction('',$link);
	} 
	function adminshoplist(){
	    $this->setstatus();
	    $where = '';
	    
	    
	    $data['shopname'] =  trim(IReq::get('shopname'));
	   $data['username'] =  trim(IReq::get('username'));
	 	 $data['phone'] = trim(IReq::get('phone'));
	 	 if(!empty($data['shopname'])){
 		    $where .= " and shopname like '%".$data['shopname']."%'";
	 	 }
	 	 if(!empty($data['username'])){
	 	   $where .= " and uid in(select uid from ".Mysite::$app->config['tablepre']."member where username='".$data['username']."')";
	 	 }
	 	 if(!empty($data['phone'])){
	 	    $where .=" and phone='".$data['phone']."'";
	 	 }
	 	 $where .= "  and   admin_id = '".$this->admin['cityid']."' ";
	 	 //??????????????????
	 	 $data['where'] = $where; 
	    
	    Mysite::$app->setdata($data);
	    
	}
    function adoptshop(){
        $this->setstatus();
        $where = ' ';

        $data['shopname'] =  trim(IReq::get('shopname'));
        $data['username'] =  trim(IReq::get('username'));
        if(!empty($data['shopname'])){
            $where .= " and shopname like '%".$data['shopname']."%'";
        }
        if(!empty($data['username'])){
            $where .= " and uid in(select uid from ".Mysite::$app->config['tablepre']."member where username='".$data['username']."')";
        }
        $where .= "  and   admin_id = '".$this->admin['cityid']."' ";
        //??????????????????
        $data['where'] = $where;
        Mysite::$app->setdata($data);

    }
	function setstatus(){
	    $data['shoptype'] = array('0'=>'??????','1'=>'??????');
	   Mysite::$app->setdata($data);
	}
	function adminshopwati(){
	   $this->setstatus();
	}
	 
	function addshop(){
	   $this->setstatus(); 
	   $uid = $this->admin['cityid'];
 	   $areaadminone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."admin where groupid='4'  and uid = '".$uid."'  ");  
	 	 $data['areaadminone'] = $areaadminone;
		 $catparent = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype  where  type='checkbox' order by cattype asc limit 0,100");
			$catlist = array();
			foreach($catparent as $key=>$value){
				$tempcat   = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype  where parent_id = '".$value['id']."'  limit 0,100");
				foreach($tempcat as $k=>$v){
					 $catlist[] = $v;
				}
			}
			$data['catarr'] = array('0'=>'??????','1'=>'??????');
			$data['catlist'] = $catlist; 
	 
	 	 Mysite::$app->setdata($data);  
	}
	function moreaddshop(){
	    $this->setstatus();  
	    $uid = $this->admin['cityid'];
		
	    $areaadminone =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."admin where groupid='4'  and uid = '".$uid."'  ");  
	 	 $data['areaadminone'] = $areaadminone;
		 $catparent = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype  where  type='checkbox' order by cattype asc limit 0,100");
			$catlist = array();
			foreach($catparent as $key=>$value){
				$tempcat   = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype  where parent_id = '".$value['id']."'  limit 0,100");
				foreach($tempcat as $k=>$v){
					 $catlist[] = $v;
				}
			}
			$data['catarr'] = array('0'=>'??????','1'=>'??????');
			$data['catlist'] = $catlist; 
	 
	 	 Mysite::$app->setdata($data);  
	}
	function setnotice(){
		 $shopid =  intval(IReq::get('shopid'));
	 	  if(empty($shopid))
	 	  {
	 	  	 echo '???????????????';
	 	  	 exit;
	 	   }
	 	  $shopinfo= $this->mysql->select_one("select noticetype,IMEI,machine_code,mKey,admin_id from ".Mysite::$app->config['tablepre']."shop where id=".$shopid."  ");
	 	  if(empty($shopinfo))
	 	  {
	 	     echo '???????????????';
	 	  	 exit;
	 	   }
	 	   if($shopinfo['admin_id'] != $this->admin['cityid']){
	 	     echo '???????????????????????????';
	 	     exit;
	 	  }
	   $data['IMEI'] = $shopinfo['IMEI'];
	   $data['shopid'] = $shopid;
	   $data['machine_code'] = $shopinfo['machine_code'];
	   $data['mKey'] = $shopinfo['mKey'];
	   $data['noticetype'] = explode(',',$shopinfo['noticetype']);
	    
	   Mysite::$app->setdata($data);
	}
	
	function saveshoppnotice(){
		$pstype = IReq::get('pstype');
		 $shopid = intval(IReq::get('shopid'));
		  $data['IMEI'] = IReq::get('IMEI');
		 if(empty($shopid))
		 {
		 	  echo "<script>parent.uploaderror('??????????????????');</script>";
		 	 exit;
		 	}
		 $tempvalue = '';
		 if(is_array($pstype)){
		 	$tempvalue = join(',',$pstype);
		 }
      $shopinfo= $this->mysql->select_one("select noticetype,IMEI,machine_code,mKey,admin_id from ".Mysite::$app->config['tablepre']."shop where id=".$shopid."  ");
	 	  if(empty($shopinfo))
	 	  {
	 	    echo "<script>parent.uploaderror('???????????????');</script>";
		 	 exit;
	 	   }
	 	   if($shopinfo['admin_id'] != $this->admin['cityid']){
	 	     echo "<script>parent.uploaderror('???????????????????????????');</script>";
		 	 exit;  
	 	  }
		 $data['noticetype'] = $tempvalue;
		 $data['machine_code'] = IReq::get('machine_code');
		 $data['mKey'] =  IReq::get('mKey');
		 $this->mysql->update(Mysite::$app->config['tablepre'].'shop',$data,"id='".$shopid."'");
		  echo "<script>parent.uploadsucess('');</script>";
		 exit;
	}
	
	
	public function uploadapp(){
		$func = IFilter::act(IReq::get('func'));
		$obj = IReq::get('obj');
		$uploaddir =IFilter::act(IReq::get('dir'));
		if(is_array($_FILES)&& isset($_FILES['imgFile']))
		{
			$uploaddir = empty($uploaddir)?'goods':$uploaddir;
			$json = new Services_JSON();
			$uploadpath = 'upload/'.$uploaddir.'/';
			$filepath = '/upload/'.$uploaddir.'/';
			$upload = new upload($uploadpath,array('gif','jpg','jpge','doc','png'));//upload ????????????????????????
			$file = $upload->getfile();
			if($upload->errno!=15&&$upload->errno!=0){
				echo "<script>parent.".$func."(true,'".$obj."','".json_encode($upload->errmsg())."');</script>";
			}else{
				echo "<script>parent.".$func."(false,'".$obj."','".$filepath.$file[0]['saveName']."');</script>";

			}
			exit;
		}
		$data['obj'] = $obj;
		$data['uploaddir'] = $uploaddir;
		$data['func'] = $func;
		Mysite::$app->setdata($data); 
	}
	
	 function addgd(){
       
        $cattypeid = IFilter::act(IReq::get('typeid'));//???????????????     typeid ???lifthelp?????????????????????????????? ?????????????????????
        $name = trim(IFilter::act(IReq::get('name')));// ????????????
        $appposition = intval(IFilter::act(IReq::get('appposition')));//1?????????????????????     2????????????????????????    3????????????????????? ????????????????????????
        $id = intval(IFilter::act(IReq::get('id')));
        $orderid = intval(IFilter::act(IReq::get('orderid')));
        if(empty($cattypeid))$this->message('???????????????');
        if(empty($name)) $this->message('???????????????');
        if(empty($appposition))$this->message('?????????????????????');
		
		$citywhere = "  and cityid = '".$this->admin['cityid']."'  ";

        if( $cattypeid != 'lifehelp' && $cattypeid != 'shophui' && $cattypeid != 'paotui'){
            $checkinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shoptype  where  id='".$cattypeid."' order by cattype asc limit 0,100");
            if(empty($checkinfo)) $this->message('?????????????????????');
            if($id > 0){
                $checkinfo2 = $this->mysql->select_one("select param from ".Mysite::$app->config['tablepre']."appadv  where id='".$id."'  ".$citywhere." ");
                if($checkinfo2['param'] != $cattypeid) {
                    $checkaa = $this->mysql->counts("select id from " . Mysite::$app->config['tablepre'] . "appadv  where  param='" . $cattypeid . "' and  type = '".$appposition."'	 ".$citywhere."	");
                    if ($checkaa > 0) $this->message('??????????????????????????????????????????');
                }
            }else {
                $checkinfo2 = $this->mysql->counts("select id from " . Mysite::$app->config['tablepre'] . "appadv  where  param='" . $cattypeid . "' and  type = '".$appposition."'	  ".$citywhere."	");
                if ($checkinfo2 > 0) $this->message('??????????????????????????????????????????');
            }

            $data['activity'] =  empty($checkinfo['cattype'])?'waimai':'market';

        }else{
            if($cattypeid == 'lifehelp'){
                $data['activity'] =  'lifehelp';
            }
			if($cattypeid == 'shophui'){
                $data['activity'] =  'shophui';
            }
			if($cattypeid == 'paotui'){
                $data['activity'] =  'paotui';
            }

            if($id > 0){
                $checkinfo2 = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."appadv  where  id='".$id."'   ".$citywhere."  ");
                if($checkinfo2['param'] != $cattypeid) {
                    $checkaa = $this->mysql->counts("select id from " . Mysite::$app->config['tablepre'] . "appadv  where  param='" . $cattypeid . "' and  type = '".$appposition. "'   ".$citywhere." ");
                    if ($checkaa > 0) $this->message('??????????????????????????????????????????');
                }

            }else{
                $checkinfo2 = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."appadv  where  param='".$cattypeid."' and type = '".$appposition."'  ".$citywhere."  ");
                if (!empty($checkinfo2)) $this->message('??????????????????????????????????????????');
            }

        } 
		
        $data['cityid'] = $this->admin['cityid'];
        $data['orderid'] = $orderid;
        $data['name'] = $name;
        $data['type'] = $appposition;
        $data['img'] = trim(IFilter::act(IReq::get('imgurl')));
        if(empty($data['img'])) $this->message('????????????');
        //????????????


        $data['param'] = $cattypeid;
        if($id > 0){
            $this->mysql->update(Mysite::$app->config['tablepre'].'appadv',$data,"id='".$id."'");
        }else{
            $this->mysql->insert(Mysite::$app->config['tablepre'].'appadv',$data);
        }
        $this->success('??????');
    }
	 function addad(){
		
			$name = trim(IFilter::act(IReq::get('name')));// ????????????
			$appposition = intval(IFilter::act(IReq::get('appposition')));//1?????????????????????     2????????????????????????    3????????????????????? ???????????????????????? 
			$id = intval(IFilter::act(IReq::get('id')));
		 
			if(empty($name)) $this->message('???????????????'); 
			if(empty($appposition))$this->message('?????????????????????'); 
			
			$data['name'] = $name;
			$data['type'] = $appposition;
			$data['img'] = trim(IFilter::act(IReq::get('imgurl')));
			if(empty($data['img'])) $this->message('????????????');
			//????????????
			$data['activity'] ='';
			$data['param'] = 0; 
			if($id > 0){
				 $this->mysql->update(Mysite::$app->config['tablepre'].'appadv',$data,"id='".$id."'");
			}else{
				$this->mysql->insert(Mysite::$app->config['tablepre'].'appadv',$data); 
			}
			$this->success('??????'); 
	 }
	 function delappadv(){
		
	    $id =  intval(IFilter::act(IReq::get('id')));
	    $this->mysql->delete(Mysite::$app->config['tablepre'].'appadv',"id  = '".$id."' "); 
	    $this->success('????????????');
	 }
	 
	 
	 
	 	
 /* ???????????????????????? */
	 
function shopcateadv(){
		$where = ''; 
	
		$cateid = intval(IReq::get('cateid'));
		$data['cateid'] = $cateid;
		if( $cateid > 0 ){
			$where = '  cateid = "'.$cateid.'" and ';
		}
		$data['where'] = $where;
	 $data['catarr'] = array('waimai'=>'??????','market'=>'??????');
	  $default_cityid = $this->admin['cityid'];
	 	$moretypelist = $this->mysql->getarr("select* from ".Mysite::$app->config['tablepre']."appadv where type=2 and (   cityid='".$default_cityid."'  or  cityid = 0 ) and ( activity = 'waimai' or activity = 'market' ) order by orderid  asc");
	$data['moretypelist'] = $moretypelist;
	
 			
	 
		 Mysite::$app->setdata($data);
}
 function addshopcateadv(){
	 
	 
	 	$id = intval(IReq::get('id'));
		$data['info'] = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shopcateadv where id=".$id."  "); 
	 
	 $data['catarr'] = array('waimai'=>'??????','market'=>'??????');
	 
	 $default_cityid = $this->admin['cityid'];
	$moretypelist = $this->mysql->getarr("select* from ".Mysite::$app->config['tablepre']."appadv where type=2 and (   cityid='".$default_cityid."'  or  cityid = 0 ) and ( activity = 'waimai' or activity = 'market' ) order by orderid  asc");
	$data['moretypelist'] = $moretypelist;
	
 			
		 Mysite::$app->setdata($data);
	    	
	 
 }
	 
function saveshopcateadv(){
	$id = IReq::get('uid');
	   	$data['addtime'] = time();
	   	$data['title'] = IReq::get('title');
 	   	$data['orderid'] = IReq::get('orderid');
	   	$data['img'] = IReq::get('img');
 	   	$data['desc'] = IReq::get('desc');
 	   	$data['cateid'] = intval(IReq::get('cateid'));
 	   	$data['link'] = trim(IReq::get('link'));
 		$data['cityid'] = $this->admin['cityid'];
		 
	   	if(empty($id))
	   	{
	   		$link = IUrl::creatUrl('areaadminpage/shop/module/addshopcateadv');
	   		if(empty($data['cateid'])) $this->message('??????????????????',$link); 
			
			$appadvone = $this->mysql->select_one("select* from ".Mysite::$app->config['tablepre']."appadv where   type=2 and param = '".$data['cateid']."' and (   cityid='".$data['cityid']."'  or  cityid = 0 ) ");
			$data['shoptype'] = $appadvone['activity'];
			if(empty($data['img'])) $this->message('??????????????????',$link); 
	   		$this->mysql->insert(Mysite::$app->config['tablepre'].'shopcateadv',$data);
	   	}else{
	   		$link = IUrl::creatUrl('areaadminpage/shop/module/addshopcateadv/id/'.$id);
 
			if(empty($data['cateid'])) $this->message('??????????????????',$link); 
			$appadvone = $this->mysql->select_one("select* from ".Mysite::$app->config['tablepre']."appadv where   type=2 and param = '".$data['cateid']."' and (   cityid='".$data['cityid']."'  or  cityid = 0 ) ");
		 
			$data['shoptype'] = $appadvone['activity'];
			if(empty($data['img'])) $this->message('??????????????????',$link); 
	   		$this->mysql->update(Mysite::$app->config['tablepre'].'shopcateadv',$data,"id='".$id."'");
	   	}
	   	$link = IUrl::creatUrl('areaadminpage/shop/module/shopcateadv');
	    $this->success('success',$link);
}	 

  function delshopcateadv(){
   	  $id = IFilter::act(IReq::get('id'));
		  if(empty($id))  $this->message('?????????');
		  $ids = is_array($id)? join(',',$id):$id;
		 if(empty($ids))  $this->message('????????????');
	    $this->mysql->delete(Mysite::$app->config['tablepre'].'shopcateadv'," id in($ids)");
	    $this->success('success','');
  }

	 
	 
	
	
	
	 
}



?>