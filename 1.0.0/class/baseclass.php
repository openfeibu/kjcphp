<?php 

/**
 * @class baseclass 
 * @描述   基础类
 */
class baseclass extends wmrclass
{
	 
	 public $memberCls;
	 public $member;
	 public $pageCls;
	 public $admin;
	 public $digui;
	 public $CITY_ID;
	 public $CITY_NAME;
	 public $platpsinfo;
 	 function init(){
	 	     //主要是检测权限   
	 	     $this->memberCls = new memberclass($this->mysql); 
	 	     $this->member = $this->memberCls->getinfo();  
	 	     $this->pageCls = new page();
	 	     $this->admin =  $this->memberCls->getadmininfo();  
	 	     $this->digui = array();//递归处理数组
			 
	 	     $controller = Mysite::$app->getController();
			 $action = Mysite::$app->getAction(); 
	 	   
	 	     $data['member'] = $this->member; 
	 	     $data['admininfo'] = $this->admin;  
			$cityId = 0;
			$CITY_ID = ICookie::get('CITY_ID');
			if( !empty($CITY_ID) ){
				$CITY_IDArr = explode('_',$CITY_ID);
				$cityId = $CITY_IDArr[2];
			}
			if(  ( $controller == 'site' && $action == 'index' )    ||   ( $controller == 'market' && $action == 'index' )   ||   ( $controller == 'site' && $action == 'showcart' )   ||   ( $controller == 'shop' && $action == 'index' )   ) {   
				if( empty($cityId)  ) {
 					$link = IUrl::creatUrl('site/guide'); 
					$this->message('',$link);
				}
			}
			$this->CITY_ID = $cityId;
			$CITY_NAME = ICookie::get('CITY_NAME');
			if( !empty($CITY_NAME) ){
				$CITY_NameArr = explode('_',$CITY_NAME);
				$CITY_NAME = $CITY_NameArr[2];
			}
			$this->CITY_NAME = $CITY_NAME;
			$data['CITY_ID'] = $this->CITY_ID;
			$data['CITY_NAME'] = $this->CITY_NAME;

	 	     $platpsinfo =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$cityId."' ");

	 	      $shopid = intval(IReq::get('shopid'));
	 	     if(!empty($shopid) && empty($cityId) && empty($platpsinfo)){
	 	         $shopadmin_id=  $this->mysql->select_one("select admin_id from ".Mysite::$app->config['tablepre']."shop  where id={$shopid}");
	 	         $platpsinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid='".$shopadmin_id['admin_id']."' ");
	 	     }


			 $this->platpsinfo = $platpsinfo;
			 $data['platpsinfo'] = $platpsinfo;
 			 
	 	     $checkmodule =  $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."module  where name='".$controller."' and install=1 limit 0,20");  
	 	     if(empty($checkmodule) && !in_array($controller,array('site','market'))){ 
	 	         $this->message('未安装此模版'); 
	 	     }  
	 	     $openid =   IFilter::act(IReq::get('openid'));  //openid='.$this->obj->FromUserName.'&='.$time.'&= 
		   	  $actime =  IFilter::act(IReq::get('actime')); 
		   	  if(!empty($openid) && !empty($actime)){
		   	  	if($controller == 'wxsite'){
		   	     $sign =  IFilter::act(IReq::get('sign')); 
		   	    $mycode = Mysite::$app->config['wxtoken'];
		   	    $checkstr = md5($mycode.$actime);
		   	    $checkstr = substr($checkstr,3,15); 
		   	     
		   	    if($checkstr == $sign && !empty($openid)){
		   	   	 
		   	   	  $checkinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."wxuser where openid ='".$openid."' ");
		   	   	  if(!empty($checkinfo)){
		   	   	       ICookie::set('logintype','wx',86400);
		   	   	       ICookie::set('wxopenid',$openid,86400);
		   	   	       $backinfo = IFilter::act(IReq::get('backinfo')); 
		   	   	       if(empty($backinfo)){
		   	   	       $link = IUrl::creatUrl('wxsite/index'); 
		   	   	      }else{
		   	   	        	$newtr = '';
		   	   	         
		   	   	        	$testinfo = explode(',',$backinfo); 
		   	   	        	
                       foreach($testinfo as $key=>$value){
                       	if(!empty($value)){
                            $newtr .= chr($value);
                          }
                       }
                  
		   	   	      	$link = $newtr;
		   	   	       
		   	   	      	if(empty($link)){
		   	   	      		 $link = IUrl::creatUrl('wxsite/index'); 
		   	   	      	}
		   	   	      }
		   	   	       
		   	   	      $this->message('',$link);
		   	      } 
		   	    } 
		   	  }
		   	 }
		   	   
	 	      
	 	     $data['moduleid']= $checkmodule['id']; 
	 	     $data['moduleparent'] = $checkmodule['parent_id']; 
	 	     $id = intval(IFilter::act(IReq::get('id'))); 
	 	     $data['id'] = $id; 
	 	   
	 	     Mysite::$app->setdata($data);  
	} 

	 
}
?>