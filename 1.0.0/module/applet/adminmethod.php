<?php
class method   extends adminbaseclass
{		
 
 function appletsave(){
	   
		$info['appletAppID'] = trim(IReq::get('appletAppID'));
 		$info['appletsecret'] = trim(IReq::get('appletsecret'));
 		$info['appletmapkey'] = trim(IReq::get('appletmapkey'));
 		$info['is_pass_applet'] = intval(IReq::get('is_pass_applet'));
		if(empty($info['appletAppID'])) $this->message('小程序appid不能为空');
		if(empty($info['appletsecret'])) $this->message('小程序secret不能为空');
		if(empty($info['appletmapkey'])) $this->message('小程序高德KEY值不能为空');
		  $config = new config('hopeconfig.php',hopedir);
		  $config->write($info);
		  $this->success('操作成功');
   }

	
}