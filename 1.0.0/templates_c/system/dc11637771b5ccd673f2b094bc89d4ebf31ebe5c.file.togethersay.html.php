<?php /* Smarty version Smarty-3.1.10, created on 2018-01-31 23:15:26
         compiled from "D:\UPUPW_K2.1\htdocs\wmr87\module\wxsite\template\togethersay.html" */ ?>
<?php /*%%SmartyHeaderCode:143625a71dd8ec15151-06997633%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dc11637771b5ccd673f2b094bc89d4ebf31ebe5c' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\module\\wxsite\\template\\togethersay.html',
      1 => 1501578473,
      2 => 'file',
    ),
    '2a6b37467a120b1a6178c413540045d22b38c043' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\m7\\public\\wxsite.html',
      1 => 1506688735,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '143625a71dd8ec15151-06997633',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tempdir' => 0,
    'siteurl' => 0,
    'color' => 0,
    'is_static' => 0,
    'Taction' => 0,
    'https' => 0,
    'lat' => 0,
    'lng' => 0,
    'sitename' => 0,
    'description' => 0,
    'signPackage' => 0,
    'sitelogo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_5a71dd8fc13758_66820877',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a71dd8fc13758_66820877')) {function content_5a71dd8fc13758_66820877($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<meta name="MobileOptimized" content="320">
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta name="HandheldFriendly" content="true">
<meta name="author" content="johnye">
<meta name="shenma-site-verification" content="f28da5e2e3fb6e2afd372a3eedfda998">
<meta name="baidu-site-verification" content="eafwEzRbnz">
<title><?php echo $_smarty_tpl->tpl_vars['sitename']->value;?>
</title> 
<link rel="stylesheet"  href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/css/public1.css"> 
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/css/newweixin.css"> 
  <link rel="stylesheet"  href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/newcss/index.css">
  <link rel="stylesheet"  href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/newcss/font-awesome.min.css">
    <link rel="stylesheet"  href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/css/scrllo_function.css">
<?php if ($_smarty_tpl->tpl_vars['color']->value=="green"){?>
<link rel="stylesheet"  href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/newcss/green.css"> 
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['color']->value=="yellow"){?>
<link rel="stylesheet"  href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/newcss/yellow.css"> 
<?php }?>

<script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/js/jquerymobile/jquery-1.6.4.min.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/js/public.js"></script>  
<script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/js/allj.js"></script>  
<script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/js/swipe.js"></script> 
<script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/js/iscroll.js"></script> 
<script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/js/newiscroll.js"></script>  
<script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/js/scrllo_function.js?v=1.0.0"></script>  
<script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/js/jquery.cookie.js"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/js/jquery.lazyload.min.js" type="text/javascript" language="javascript"></script> 
  
<link rel="stylesheet"  href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/css/shopshow.css">   
<link rel="stylesheet"  href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/css/togetersay.css">   

  
  <script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/js/wxshop.js"></script>  
 <script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/js/jweixin-1.0.0.js"></script>  

<script>  
	var siteurl = "<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
";
	var is_static ="<?php echo $_smarty_tpl->tpl_vars['is_static']->value;?>
";
	var taction = "<?php echo $_smarty_tpl->tpl_vars['Taction']->value;?>
"; 
	var https = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['https']->value)===null||$tmp==='' ? '' : $tmp);?>
';
    var lat = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['lat']->value)===null||$tmp==='' ? 0 : $tmp);?>
';
    var lng = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['lng']->value)===null||$tmp==='' ? 0 : $tmp);?>
';
	if ( taction != 'member' &&  taction != 'login' &&  taction != 'reg'  ){
		var cururl = window.location.href;
		$.cookie('wxCurUrl', cururl);
	}
 
</script>

 <script>
 	$(function(){  		
 	   $('#loading').hide(); 
	   
	   
	   
  });
  </script>


<script> 
		var myScroll;
		
function loaded() {
	myScroll = new iScroll('wrapper', {
		useTransform: false,
		onBeforeScrollStart: function (e) {
			var target = e.target;
			while (target.nodeType != 1) target = target.parentNode;

			if (target.tagName != 'a' && target.tagName != 'span')
				e.preventDefault();
		}
	});
	 

}
$(function(){ 

document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false); 
document.addEventListener('DOMContentLoaded', function () { setTimeout(loaded, 200); }, false);
});
</script>

 
<?php if (!empty($_smarty_tpl->tpl_vars['https']->value)&&empty($_smarty_tpl->tpl_vars['lat']->value)&&empty($_smarty_tpl->tpl_vars['lng']->value)){?>
<iframe id="iframe1" name="iframe1" src="<?php echo $_smarty_tpl->tpl_vars['https']->value;?>
/frmeload.html" style="display:none;"></iframe>
<?php }?> 
 
</head>
<body> 
<style>
.page-app{ background:#f0f0f0;}
body{background:#f0f0f0;}
  
</style>
  
  <div class="wmr-loader" id="loading" >
 <span class="wmr-icon wmr-icon-loading"></span>
 <h1>loading</h1>
 </div>
 <style>
 .wmr-loader {
     background: #5e5e5e;
    width: 100px!important;
    height: 100px!important;
    border-radius: 8px;
     z-index: 9999999;
    position: fixed!important;
    top: 50%!important;
    left: 50%;
    border: 0;
    margin-left: -50px!important;
    margin-top: -50px!important;
}.wmr-loader .wmr-icon-loading {
    background-color: #F00;
    display: block;
    margin: 10px 0px 5px 25px;
    width: 50px;
    height: 50px;
    -webkit-border-radius: 2.25em;
    border-radius: 2.25em;
    background: url(/upload/images/newloading.gif) no-repeat center;
    text-align: center;
}.wmr-loader h1 {
    color: #fff;
    text-align: center;
}
  </style> 
 
	
 <!--??????-->
    <header style="position: fixed;display:block; " id=""><div class="return"></div>?????????
	<div   onclick="dolink('<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/wxmsglist"),$_smarty_tpl);?>
');"  style="position: fixed;
  display: block;
  z-index: 3;
  top: 1px;
  right: 15px;"><p style="line-height: 12px;"><img style="width: 25px;" src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/images/iconfont-xiaoxiweixuanzhong.png" /></p><p  style="line-height: 12px; font-size:12px;">??????</p></div>
	</header>

	
	 
<div id="wrapper">
	<div id="scroller" style="position: absolute;
    z-index: 1;
    width: 100%;
    padding: 0;" class="page-app">
	<div class="wxsaycontentlist">
	
		<ul id='yislistdata'>
			<center style='height:50px;;line-height:50px;font-size:13px;color:#a9a9a9;'>?????????...</center>
		</ul>
	</div>
	<div  id="lodingmore" style="display:none;"   class="downLoading "><div class="moreLoading"><i class="iconstartloading"></i><span>????????????...</span></div></div>
 </div>
		</div>

  </div>
 <div  onclick="dolink('<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/fabiaozhuti"),$_smarty_tpl);?>
');"  style="position:fixed; z-index:99; bottom:46px; margin-left:-25px; left:50%;">
	<?php if ($_smarty_tpl->tpl_vars['color']->value=="green"){?>
	<img style="width:50px;" src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/images/writecomment_1.png" />
	<?php }elseif($_smarty_tpl->tpl_vars['color']->value=="yellow"){?>
	<img style="width:50px;" src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/images/writecomment_2.png" />
	<?php }else{ ?>
	<img style="width:50px;" src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/images/writecomment.png" />
	<?php }?>
 </div>

   <div id="cat_zhe" class="cart_zhe"  onclick="quxiaobtnpl();" ></div>
 <!-- ??????????????? -->
 <div class="corfimjubao" style="display:none;">
	<p class="jubaotext">????????????????</p>
	<p class="jubaoifqdqx">
		<span class="jubaospan" ><span onclick="quedingjubao();" jubaoid="" class="quedingjubao">??????</span></span>
		<span class="jubaospan" ><span  onclick="quxiaobtnpl();" class="quxiaojubao">??????</span></span>
	</p>
 </div>
<!-- ??????????????? -->
 <div class="corfimjubaodel" style="display:none;">
	<p class="jubaotextdel">????????????????</p>
	<p class="jubaoifqdqxdel">
		<span class="jubaospandel" ><span onclick="quedingshanchu();" shanchuid="" class="quedingjubaodel">??????</span></span>
		<span class="jubaospandel" ><span  onclick="quxiaobtndel();" class="quxiaojubaodel">??????</span></span>
	</p>
 </div>


   <style>
   .cart_zhe {
   display:none;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 666;
  width:100%;
  height:100%;
  background-color: #000;
  opacity: 0.4;
  filter: alpha(opacity=40);
}
   </style> 

   <script>
     wx.config({
      debug: false,
      appId: '<?php echo $_smarty_tpl->tpl_vars['signPackage']->value['appId'];?>
',
      timestamp: '<?php echo $_smarty_tpl->tpl_vars['signPackage']->value['timestamp'];?>
',
      nonceStr: '<?php echo $_smarty_tpl->tpl_vars['signPackage']->value['nonceStr'];?>
',
      signature: '<?php echo $_smarty_tpl->tpl_vars['signPackage']->value['signature'];?>
',
      jsApiList: [
        'checkJsApi',
        'previewImage'
      ]
  });
  
    // 5.2 ????????????
  //document.querySelector('.previewImage').onclick = function () {
$(".previewImage").click(function(){	
 var userimgs = $(this).attr('dataattr');
	//	 Tmsg(1);
		var stringarray = userimgs.split("@");	
		//Tmsg(stringarray);		
		 wx.previewImage({
		  current: $(this).attr('src'),
		  urls: stringarray
		});
	});

  //};
  
  
   </script>
  <script>
 var wxmemuid = <?php echo $_smarty_tpl->tpl_vars['member']->value['uid'];?>
;
   function quxiaobtnpl(){
		$(".corfimjubao").hide();
		$(".cart_zhe").hide();
		$(".wxusercomfir").hide();
   } 
   function quxiaobtndel(){
		$(".corfimjubaodel").hide();
		$(".cart_zhe").hide();
		$(".wxusercomfir").hide();
   } 

function caozuousercont(commentid){
		$(".wxusercomfir_"+commentid).toggle();
}
function wxuserjubao(commentid){
	// ???????????????
	$(".corfimjubao").show();
	$(".cart_zhe").show();
	$(".quedingjubao").attr('jubaoid',commentid);
}


//????????????
function quedingjubao(){
	var jubaoid = $(".quedingjubao").attr('jubaoid');
	
	$.ajax({
	  	url:'<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/savejubaowxuser/datatype/json"),$_smarty_tpl);?>
',
	  	data:{uid:wxmemuid,jubaoid:jubaoid},
	  	dataType: 'json',
	  	success:function (data, status)
	  	{
		
	  		if(typeof(data.error) != 'undefined')
				{
					if(data.error == false)
					{
					$(".corfimjubao").hide();
					$(".cart_zhe").hide();
					
						Tmsg('????????????');

					 }else{
					 		if(data.msg == '?????????????????????~'){
								Tmsg(data.msg);
									$(".corfimjubao").hide();
								$(".cart_zhe").hide();
							}else{
								Tmsg(data.msg);
							}
							
					 		
					}
				}else{
					Tmsg(data.msg);
				} 

	  	},
		  error: function (data, status, e)
		  {
					Tmsg('??????????????????');
		  }
	  }); 
}
//??????
function wxuserdel(commentid){
	// ???????????????
	$(".corfimjubaodel").show();
	$(".cart_zhe").show();
	$(".quedingjubaodel").attr('shanchuid',commentid);
} 
// ???????????????????????????
function quedingshanchu(){
	var shanchuid = $(".quedingjubaodel").attr('shanchuid');
	
	$.ajax({
	  	url:'<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/saveshanchuwxuser/datatype/json"),$_smarty_tpl);?>
',
	  	data:{uid:wxmemuid,shanchuid:shanchuid},
	  	dataType: 'json',
	  	success:function (data, status)
	  	{
		
	  		if(typeof(data.error) != 'undefined')
				{
					if(data.error == false)
					{
					$(".corfimjubaodel").hide();
					$(".cart_zhe").hide();
						$(".wxsaycontentlist .wxusersay_"+shanchuid).remove();
						Tmsg('????????????');
											
					 }else{
					 		Tmsg(data.msg);
					 		
					}
				}else{
					Tmsg(data.msg);
				} 

	  	},
		  error: function (data, status, e)
		  {
					Tmsg('??????????????????');
		  }
	  }); 
}

   
$(function(){
	$(".zongzanshuliang").click(function(){
		var pingjiavalue = $(this).attr('pingjiaattr');
		var zancommentid = $(this).attr('zanidattr');
	
		var zongzanshu = $(this).text();
	
		if(pingjiavalue == 0){
			zanyige(zancommentid);
		}
		if(pingjiavalue == 1){
			quxiaozanyige(zancommentid);
		}
	});
	
	var wxmemuid = <?php echo $_smarty_tpl->tpl_vars['member']->value['uid'];?>
;
//  ?????????
	function zanyige(zancommentid){
	
	
	
	$.ajax({
	  	url:'<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/saveuserzanjia/datatype/json"),$_smarty_tpl);?>
',
	  	data:{uid:wxmemuid,commentid:zancommentid},
	  	dataType: 'json',
	  	success:function (data, status)
	  	{
		
	  		if(typeof(data.error) != 'undefined')
				{
					if(data.error == false)
					{
					var zongzanshu = $(".zongzanshuliang_"+zancommentid).text();
					 $(".zongzanshuliang_"+zancommentid).removeClass('zongzanshu');
					 $(".zongzanshuliang_"+zancommentid).addClass('zongzanshucur');
					 $(".zongzanshuliang_"+zancommentid).attr('pingjiaattr','1');
					 var shijizzs = Number(zongzanshu)+1;
					
					 $(".zongzanshuliang_"+zancommentid).text(shijizzs);
					 
				
					 }else{
					 		Tmsg(data.msg);
					}
				}else{
					Tmsg(data.msg);
				} 

	  	},
		  error: function (data, status, e)
		  {
					Tmsg('??????????????????');
		  }
	  }); 
	}
//??????????????? 
	function quxiaozanyige(zancommentid){
		
	
	
	$.ajax({
	  	url:'<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/saveuserzanjian/datatype/json"),$_smarty_tpl);?>
',
	  	data:{uid:wxmemuid,commentid:zancommentid},
	  	dataType: 'json',
	  	success:function (data, status)
	  	{
		
	  		if(typeof(data.error) != 'undefined')
				{
					if(data.error == false)
					{
					var zongzanshu = $(".zongzanshuliang_"+zancommentid).text();
					 $(".zongzanshuliang_"+zancommentid).removeClass('zongzanshucur');
					 $(".zongzanshuliang_"+zancommentid).addClass('zongzanshu');					 
					  $(".zongzanshuliang_"+zancommentid).attr('pingjiaattr','0');
					   	 var shijizzs = Number(zongzanshu)-1;					
						$(".zongzanshuliang_"+zancommentid).text(shijizzs);
					
							
					 }else{
					 		Tmsg(data.msg);
					}
				}else{
					Tmsg(data.msg);
				} 

	  	},
		  error: function (data, status, e)
		  {
					Tmsg('??????????????????');
		  }
	  }); 
	}
});
 var defaultSwiper; //????????????????????????
 var holdPosition = 0;
 var maxposition = 0;
 var page =1;
 var pageend = false;
 addfresh();
 function freshpage(){//????????????
	 page =1;
	 pageend = false;
	 $('#yislistdata').html('');
	 var content = htmlback(siteurl+'/index.php?ctrl=wxsite&action=togethersaydata',{'page':page});
	 if(content.flag == false){
		 var getmoreContent =  $.trim(content.content);
		 if( getmoreContent == ''){
			 $('#yislistdata').html("<center style='height:50px;;line-height:50px;font-size:13px;color:#a9a9a9;'>????????????</center>");
		 }else{
			 $('#lodingmore').show();
			 $('#yislistdata').append(getmoreContent);
		 }
	 }else{
		 Tmsg('????????????');
	 }
	 $('#loading').hide();
	 hidefresh();
 }
 function loadmore(){
	 page = page+1;
	 var content = htmlback(siteurl+'/index.php?ctrl=wxsite&action=togethersaydata',{'page':page});
	 if(content.flag == false){
		 $('#lodingmore .moreLoading i').addClass('iconstartloading');
		 $('#lodingmore .moreLoading i').removeClass('iconloading');
		 $('#lodingmore .moreLoading i').removeClass('iconOverload');
		 $("#lodingmore span").text("????????????...");
		 var getmoreContent =  $.trim(content.content);

		 if( getmoreContent == ''  ){
			 pageend = true;
			 $('#lodingmore .moreLoading i').removeClass('iconstartloading');
			 $('#lodingmore .moreLoading i').removeClass('iconloading');
			 $('#lodingmore .moreLoading i').addClass('iconOverload');
			 $("#lodingmore span").text("????????????...");

		 }else{
			 $('#yislistdata').append(getmoreContent);
		 }

	 }else{
		 pageend = true;
		 $('#lodingmore .moreLoading i').removeClass('iconstartloading');
		 $('#lodingmore .moreLoading i').removeClass('iconloading');
		 $('#lodingmore .moreLoading i').addClass('iconOverload');
		 $("#lodingmore span").text("????????????...");
	 }
	 hideloadmore();

 }

  </script>

 
 
 
 
     <div class="bottom-bar-warp">
        <div class="bottom-bar" id="bottom-bar">
            <div class="bbar-btn tap-click" onclick="dolink('<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/index"),$_smarty_tpl);?>
');"  ><i  class="icon icon_home"></i><div class="text" style="margin-top:-8px;">??????</div></div>
            <div class="bbar-btn tap-click" onclick="dolink('<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/order"),$_smarty_tpl);?>
');" ><i class="icon icon_user"></i><div class="text" style="margin-top:-8px;">????????????</div></div>
     
            <div class="bbar-btn tap-click" onclick="dolink('<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/togethersay"),$_smarty_tpl);?>
');"  ><i class="icon icon_order"></i><div class="text" style="margin-top:-8px;">?????????</div></div>
            <div class="bbar-btn"  onclick="dolink('<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/member"),$_smarty_tpl);?>
');"><i class="icon icon_phone" style="margin-top: 8px;"></i></a><a class="text"  style="margin-top:-10px;">????????????</div>
        </div>
    </div>




    
<?php if ($_smarty_tpl->tpl_vars['color']->value=="green"){?>
<script>
	$(function(){
		if( taction  == 'index' ){          	
			$(".icon_home").next().css('color','#00cd85');			
			$(".icon_home").css('backgroundPosition','0px -23px');		
		}
		if( taction  == 'member' ){		
			$(".icon_phone").next().css('color','#00cd85');
			$(".icon_phone").css('backgroundPosition','-92px -23px');		
		}
		if( taction  == 'order' ){		
			$(".icon_user").next().css('color','#00cd85');
			$(".icon_user").css('backgroundPosition','-23px -23px');		
		}
			if( taction  == 'togethersay' ){		
			$(".icon_order").next().css('color','#00cd85');
			$(".icon_order").css('backgroundPosition','-69px -23px');		
		}
	});
</script>
<?php }?>


<?php if ($_smarty_tpl->tpl_vars['color']->value=="yellow"){?>
<script>
	$(function(){
		if( taction  == 'index' ){          	
			$(".icon_home").next().css('color','#ff7600 ');			
			$(".icon_home").css('backgroundPosition','0px -23px');		
		}
		if( taction  == 'member' ){		
			$(".icon_phone").next().css('color','#ff7600 ');
			$(".icon_phone").css('backgroundPosition','-92px -23px');		
		}
		if( taction  == 'order' ){		
			$(".icon_user").next().css('color','#ff7600 ');
			$(".icon_user").css('backgroundPosition','-23px -23px');		
		}
			if( taction  == 'togethersay' ){		
			$(".icon_order").next().css('color','#ff7600 ');
			$(".icon_order").css('backgroundPosition','-69px -23px');		
		}
	});
</script>

<?php }?>

<?php if ($_smarty_tpl->tpl_vars['color']->value=="red"||empty($_smarty_tpl->tpl_vars['color']->value)){?>
<script>
	$(function(){
		if( taction  == 'index' ){          	
			$(".icon_home").next().css('color','#ff6e6e');			
			$(".icon_home").css('backgroundPosition','0px -23px');		
		}
		if( taction  == 'member' ){		
			$(".icon_phone").next().css('color','#ff6e6e');
			$(".icon_phone").css('backgroundPosition','-92px -23px');		
		}
		if( taction  == 'order' ){		
			$(".icon_user").next().css('color','#ff6e6e');
			$(".icon_user").css('backgroundPosition','-23px -23px');		
		}
			if( taction  == 'togethersay' ){		
			$(".icon_order").next().css('color','#ff6e6e');
			$(".icon_order").css('backgroundPosition','-69px -23px');		
		}
	});
</script>
<?php }?>
<script>
 var sharetitle = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['sitename']->value)===null||$tmp==='' ? '' : $tmp);?>
';
 var sharedesc = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['description']->value)===null||$tmp==='' ? '' : $tmp);?>
';
 var shareimgUrl = '<?php if (!empty($_smarty_tpl->tpl_vars['signPackage']->value['shareimg'])){?><?php echo $_smarty_tpl->tpl_vars['signPackage']->value['shareimg'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
<?php echo $_smarty_tpl->tpl_vars['sitelogo']->value;?>
<?php }?>';
 var sharelink = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['signPackage']->value['url'])===null||$tmp==='' ? '' : $tmp);?>
';
</script>
<?php if (is_array($_smarty_tpl->tpl_vars['signPackage']->value)&&$_smarty_tpl->tpl_vars['Taction']->value!='togethersay'&&$_smarty_tpl->tpl_vars['Taction']->value!='togethersaydata'&&$_smarty_tpl->tpl_vars['Taction']->value!='fabiaozhuti'){?> 
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript" language="javascript"></script> 
<script> 
    wx.config({
      debug: false,
      appId: '<?php echo $_smarty_tpl->tpl_vars['signPackage']->value['appId'];?>
',
      timestamp: <?php echo $_smarty_tpl->tpl_vars['signPackage']->value['timestamp'];?>
,
      nonceStr: '<?php echo $_smarty_tpl->tpl_vars['signPackage']->value['nonceStr'];?>
',
      signature: '<?php echo $_smarty_tpl->tpl_vars['signPackage']->value['signature'];?>
',
      jsApiList: [
        'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'onMenuShareQZone'
      ] 
  }); 
 // alert('<?php echo $_smarty_tpl->tpl_vars['signPackage']->value['appId'];?>
');
 wx.ready(function(){
	//??????????????????
	wx.onMenuShareTimeline({
		title: sharetitle, // ????????????
		link: sharelink, // ??????????????????????????????????????????????????????????????????????????????JS??????????????????
		imgUrl: shareimgUrl, // ????????????
		success: function () { 
			// ??????????????????????????????????????????
		},
		cancel: function () { 
			// ??????????????????????????????????????????
		}
	});
	//???????????????
	wx.onMenuShareAppMessage({
		title: sharetitle, // 
		desc: sharedesc, // 
		link: sharelink, // ??????????????????????????????????????????????????????????????????????????????JS??????????????????
		imgUrl: shareimgUrl, // ????????????
		type: 'link', // ????????????,music???video?????????????????????link
		dataUrl: '', // ??????type???music???video??????????????????????????????????????????
		success: function () { 
			// ??????????????????????????????????????????
			//Tmsg(shareimgUrl);
		},
		cancel: function () { 
			// ??????????????????????????????????????????
			//Tmsg('????????????');
		}
	}); 
	wx.onMenuShareQQ({
		title: sharetitle, // ????????????
		desc: sharedesc, // ????????????
		link: sharelink, // ????????????
		imgUrl: shareimgUrl, // ????????????
		success: function () { 
		   // ??????????????????????????????????????????
		},
		cancel: function () { 
		   // ??????????????????????????????????????????
		}
	});
	
	wx.onMenuShareWeibo({
		title: sharetitle, // ????????????
		desc: sharedesc, // ????????????
		link: sharelink, // ????????????
		imgUrl: shareimgUrl, // ????????????
		success: function () { 
		   // ??????????????????????????????????????????
		},
		cancel: function () { 
			// ??????????????????????????????????????????
		}
	}); 
	wx.onMenuShareQZone({
		title: sharetitle, // ????????????
		desc: sharedesc, // ????????????
		link: sharelink, // ????????????
		imgUrl: shareimgUrl, // ????????????
		success: function () { 
		   // ??????????????????????????????????????????
		},
		cancel: function () { 
			// ??????????????????????????????????????????
		}
	});
});
wx.error(function(res){ 
	 alert(res.errMsg);
});




</script> 
<?php }?>  
</body>
</html>
 <?php }} ?>