<?php  
header("Content-Type:text/html;charset=utf-8"); //输出格式 
date_default_timezone_set("Asia/Hong_Kong"); //时间区域
define('hopedir', dirname(__FILE__).DIRECTORY_SEPARATOR);
ini_set('display_errors',1);            //错误信息
ini_set('display_startup_errors',1);    //php启动错误信息
error_reporting(-1);  
$config = hopedir."config/hopeconfig.php";   
$cfg = include($config);  
$siteurl = $cfg['siteurl'];
include_once(hopedir.'/lib/core/extend/psbupload.php');
include_once(hopedir.'/lib/core/extend/Services_JSON.php');
include_once(hopedir.'/lib/core/extend/IFile.php');   
$json = new Services_JSON(); 
 $backdata = array('error'=>true,'msg'=>'');   
try{ 
 
 
 $upload = new upload($_POST,'',1);//upload 自动生成压缩图片 
$file = $upload->getfile();
 
if($upload->errno!=15&&$upload->errno!=0){ 
	$backdata['msg'] = $upload->errno(); 
}else{
	$uploadpath = 'upload/';  
	if(isset($_POST['savePath']) && !empty($_POST['savePath']) ){
		$uploadpath =  $_POST['savePath'];
	}  
	$backdata['msg'] = $siteurl.'/'.$_POST['savePath'].$file[0]['saveName']; 
	$backdata['error'] = false;
} 
echo json_encode($backdata);
}catch (Exception $e) { 
$backdata['msg'] = $e->getmessage();
echo json_encode($backdata); 
}
exit;