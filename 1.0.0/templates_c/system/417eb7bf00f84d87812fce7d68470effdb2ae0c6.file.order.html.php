<?php /* Smarty version Smarty-3.1.10, created on 2018-01-31 23:15:21
         compiled from "D:\UPUPW_K2.1\htdocs\wmr87\module\wxsite\template\order.html" */ ?>
<?php /*%%SmartyHeaderCode:81515a71dd897d7fa7-69099948%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '417eb7bf00f84d87812fce7d68470effdb2ae0c6' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\module\\wxsite\\template\\order.html',
      1 => 1501063828,
      2 => 'file',
    ),
    '2a6b37467a120b1a6178c413540045d22b38c043' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\m7\\public\\wxsite.html',
      1 => 1506688735,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '81515a71dd897d7fa7-69099948',
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
  'unifunc' => 'content_5a71dd8a4fce06_15396426',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a71dd8a4fce06_15396426')) {function content_5a71dd8a4fce06_15396426($_smarty_tpl) {?><!DOCTYPE html>
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
/public/wxsite/css/order.css">

 
  <script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/js/template.min.js"></script>   

 <script> 
    $(function(){
			$('.toptitBox .toptitL').bind("click", function() {
            window.location.href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/index.php?ctrl=wxsite";
			})
		});
   
  function acceptorder(orderid){  
 
 	if(confirm('???????????????')){
   	     $('#loading').show(); 
   		   var url = siteurl+'/index.php?ctrl=order&action=acceptorder&orderid='+orderid+'&datatype=json&random=@random@';   
 	        $.ajax({ 
           dataType: "json",  
           url: url.replace('@random@', 1+Math.round(Math.random()*1000)),  
           success: function(content) {    
           	 if(content.error == false) 
          	{  
           		$('#loading').hide();
				window.location.reload();
				
          	}else{ 
          			Tmsg(content.msg);
          		  $('#loading').hide();
          	}  
          	 
	         }, 
           error: function(content) {  
             	Tmsg('??????????????????');
        	    $('#loading').hide();
	         }
       
         });  
     }
     return false; 
   } 
   
   
 function delorder(orderid){  
 
 	if(confirm('???????????????')){
   	     $('#loading').show(); 
   		   var url = siteurl+'/index.php?ctrl=order&action=userdelorder&orderid='+orderid+'&datatype=json&random=@random@';   
 	        $.ajax({ 
           dataType: "json",  
           url: url.replace('@random@', 1+Math.round(Math.random()*1000)),  
           success: function(content) {    
           	 if(content.error == false) 
          	{  
           		$('#loading').hide();
				window.location.reload();
				
          	}else{ 
          			Tmsg(content.msg);
          		  $('#loading').hide();
          	}  
          	 
	         }, 
           error: function(content) {  
             	Tmsg('??????????????????');
        	    $('#loading').hide();
	         }
       
         });  
     }
     return false; 
   } 

 	</script>
 
<script>
var defaultSwiper; //???????????????????????? 
var holdPosition = 0; 
var maxposition = 0;
var page =1;
var pageend = false;
var html5_config = {'showheader':true,'showfooter':true,'bodyscller':true,'Canfresh':true,'CanloadMore':true,'titilename':'????????????'}; 
$(function(){
	loading();
});
function freshpage(){//???????????? 
  page =1;
  pageend = false;
    $('#orderlist').html(''); 
	var content = htmlback(siteurl+'/index.php?ctrl=wxsite&action=userorder',{'page':page});
  	if(content.flag == false){
 	     $('#orderlist').append(content.content);    
				if($.trim(content.content) != '' && $("#orderlist .editordercon").length >= 5  ){
 					$("#lodingmore").show();
				} 
				if(  $.trim(content.content) == ''  ){
					htmlNull(1,'????????????????????????','nullorderimg.png');
				}else{
					htmlNull(0);
				}
				
				defaultSwiper.refresh();
	}else{
	    Tmsg('xxxx');
	}  
	$('#loading').hide(); 
	hidefresh();
    //setTimeout("hidefresh()",50);  
}
function loadmore(){ 
	page = page+1;
	   var content = htmlback(siteurl+'/index.php?ctrl=wxsite&action=userorder',{'page':page});
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
				 $('#orderlist').append(content.content);
		   }
		  
		}else{
			pageend = true;
			$('#lodingmore .moreLoading i').removeClass('iconstartloading');
			$('#lodingmore .moreLoading i').removeClass('iconloading');
	     	$('#lodingmore .moreLoading i').addClass('iconOverload');
			$("#lodingmore span").text("????????????...");
		}
		//  setTimeout("hideloadmore()",500);  
		hideloadmore();
	
} 
  
//??????????????????
function loading(){
 	if(typeof html5_config == 'undefined'){
		alert('????????????');
	}else{ 
	    
		if(html5_config.bodyscller == true){
 			 setTimeout(function(){  
				$('#wrapper').show();    
				 addfresh();
				 
			 },500);
		}
	 //	$('#loading').hide();
		//loaddata();
		
	}
}  
</script>

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


<style>
.shanchuedit{ 
    background-color: #ff6e6e;
    color: #fff;
	width: 72px;
    height: 30px;
    border-radius: 3px;
    font-size: 14px;
	    line-height: 30px;
		    position: absolute;
    top: 80px;
    right: 5px;
	    text-align: center;
}
.editorderbut ul li .editordinp1 {
    background-color: #ff6e6e;
    color: #fff;
	width: 72px;
    height: 30px;
    border-radius: 3px;
    font-size: 14px;
	    line-height: 30px;
	    text-align: center;
}
.editorderbut ul li .editordinp2 {
    border: 1px solid #bfbfbf;
    background-color: transparent;
    color: #000000;
	width: 72px;
    height: 30px;
    border-radius: 3px;
    font-size: 14px;
	 line-height: 30px;
	    text-align: center;
}
</style> 

 
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
 
	
<div class="toptitCon">
 <div class="toptitBox">
  <div class="toptitL"><i></i></div>
  <div class="toptitC"><h3>????????????</h3></div>
 </div>
</div>

	
	 
<style>
p{padding:0px; margin:0px;}
</style>
 <div id="wrapper" style="top:40px; ">
	<div id="scroller">
	 
   <div id="orderlist">
 
 
</div>
	<div  id="lodingmore"   style="display:none;"   class="downLoading "><div class="moreLoading"><i class="iconstartloading"></i><span>????????????...</span></div></div>
   
</div>
</div>
 
 
 
  
 
 
 
 
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