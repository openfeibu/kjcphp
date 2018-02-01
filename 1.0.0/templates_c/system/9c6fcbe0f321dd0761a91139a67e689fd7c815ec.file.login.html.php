<?php /* Smarty version Smarty-3.1.10, created on 2018-01-31 23:48:21
         compiled from "D:\UPUPW_K2.1\htdocs\wmr87\module\wxsite\template\login.html" */ ?>
<?php /*%%SmartyHeaderCode:18335a71e54558c633-21076081%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9c6fcbe0f321dd0761a91139a67e689fd7c815ec' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\module\\wxsite\\template\\login.html',
      1 => 1507716584,
      2 => 'file',
    ),
    '2a6b37467a120b1a6178c413540045d22b38c043' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\m7\\public\\wxsite.html',
      1 => 1506688735,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18335a71e54558c633-21076081',
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
  'unifunc' => 'content_5a71e54633ad50_82948270',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a71e54633ad50_82948270')) {function content_5a71e54633ad50_82948270($_smarty_tpl) {?><!DOCTYPE html>
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
/public/wxsite/css/gift.css">

 
  <script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/js/template.min.js"></script>    

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

			if (target.tagName != 'SELECT' && target.tagName != 'INPUT' && target.tagName != 'TEXTAREA')
				e.preventDefault();
		}
	});
}
document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false); 
document.addEventListener('DOMContentLoaded', function () { setTimeout(loaded, 200); }, false);
</script>
<script>
 	$(function(){
 	$('.intexbg1userlogin').click(function(){ 
 		var checkuname = $('#logEmailOrPhone').val();
 		if(checkuname != ''){
 		  
  	 	$('#loading').toggle(); 
  	  	var info = {'uname':$('#logEmailOrPhone').val(),'pwd':$('#logPassword').val(),'logintype':'html5'}; 
  	 	  var  url = siteurl+'/index.php?ctrl=member&action=login&datatype=json&random=@random@' 
  	 	   $.ajax({ 
             url: url.replace('@random@', 1+Math.round(Math.random()*1000)), 
            dataType: "json", 
            data:info, 
            success:function(content) {  
            	$('#loading').toggle(); 
            	if(content.msg ==  false){
                    window.location.href = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['web_extend_link']->value)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['siteurl']->value : $tmp);?>
';
            	}else{ 
            	   Tmsg(content.msg);
              }
            	
            }, 
            error:function(){
            	$('#loading').toggle();

            } 
         });  
    }else{
    	Tmsg('用户帐号不能为空');
    }
		  
	 }); 
	});

 </script>
 <script>
 	$(function(){
 	$('.intexbg1fastlogin').click(function(){ 
	 
 		var phone = $('#phone').val();
		var phoneyan = $('#phoneyan').val();
 		if(phone < 1){
		     Tmsg('请输入手机号');
			 return false;
		}
		if(phoneyan < 1){
		     Tmsg('请输入验证码');
			 return false;
		} 	  
  	 	$('#loading').toggle(); 
  	  	var info = {'phone':phone,'phoneyan':phoneyan}; 
  	 	  var  url = siteurl+'/index.php?ctrl=member&action=fastlogin&datatype=json&random=@random@' 
  	 	   $.ajax({ 
             url: url.replace('@random@', 1+Math.round(Math.random()*1000)), 
            dataType: "json", 
            data:info, 
            success:function(content) {  
			    console.log(content)
            	$('#loading').toggle(); 
            	if(content.error ==  false){
                    window.location.href= siteurl+'/index.php?ctrl=wxsite&action=member';
            	}else{ 
            	   Tmsg(content.msg);
              }
            	
            }, 
            error:function(){
            	$('#loading').toggle();

            } 
         });  
  
		  
	 }); 
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
 
	
<div class="toptitCon">
 <div class="toptitBox">
  <div class="toptitL"><i></i></div>
  <div class="toptitC"><h3>登录</h3><span onclick="dolink('<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/reg"),$_smarty_tpl);?>
');"  style='color:#fff;position: absolute;top: 9px;right: 10px;font-size:80%'>立即注册</span></div>
 </div>
</div>

	
	 
 <div id="wrapper" style="top:40px;">
	<div id="scroller">
<!--登录-->
<div class="signinregistertit" >
 <ul style='border:none;'>
  <li class="ainregaA userloginbtn">账号密码登录</li>
  <li class='fastloginbtn'>手机号快捷登录</li>
 </ul>
</div>
<script>
$('.userloginbtn').click(function(){
    $('.userloginbtn').addClass('ainregaA');
    $('.userlogin').show();
	$('.fastloginbtn').removeClass('ainregaA');
	$('.fastlogin').hide();
})
$('.fastloginbtn').click(function(){
    $('.fastloginbtn').addClass('ainregaA');
    $('.fastlogin').show();
	$('.userloginbtn').removeClass('ainregaA');
	$('.userlogin').hide();
})
</script>
<!--输入用户名密码-->
<!-------------------账号密码登录开始----------------------->
<div class="signininput userlogin" style='border:none;'>
 <ul>
  <li><i class="signinuser"></i><input type="text"  id="logEmailOrPhone"  placeholder="账号"></li>
  <li><i class="signinpassw"></i><input type="password" id="logPassword" placeholder="密码"></li>
 </ul>
</div>
<div class="intexchabutt userlogin" style='margin-top:15px' ><input type="button" value="登录" style='border-radius: 5px;' class="intexbg1 intexbg1userlogin"><span  onclick="dolink('<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/forpwd"),$_smarty_tpl);?>
');"  class="sinzhmm">找回密码</span></div>
<!-------------------账号密码登录结束----------------------->

<!-------------------手机快捷登录开始----------------------->
<div class="signininput fastlogin" style='border:none;display:none'>
 <ul>
 
  <li><i class="signinpho"></i><input type="text" id="phone" value="" placeholder="手机号"></li>
    <li id="showgetcode" class="signmehide"><i class="signinmess"></i><input type="text" name="phoneyan" id="phoneyan"   value="" placeholder="验证码"><input type="button"  onclick="clickyanzheng();"  style='border-radius: 5px; float:right;margin-top: 10px;' time="0" id="dosendbtn"  value="发送验证码" class="signmeinput"></li> 
  <li class="signmehide"><i class="signinmess"></i><input type="text"  placeholder="输入短信验证码"><input type="button" value="剩余120秒" class="signmeinput signmebg1"></li>
 </ul>
</div>
<div class="intexchabutt fastlogin" style='display:none;margin-top:15px' ><input type="button" value="登录" style='border-radius: 5px;' class="intexbg1 intexbg1fastlogin"><span  onclick="dolink('<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/forpwd"),$_smarty_tpl);?>
');"  class="sinzhmm">找回密码</span></div>
<!-------------------手机快捷登录结束----------------------->
		 <div style="height:10px;"></div>
        <style>
            .signinFast {
                width: 100%;
                padding-top:100px;
                text-align: center;
            }
            .signinFast .xL {
                width: 90px;
                height: 2px;
                background-color: #edecec;
                display: block;
                float: left;
                margin-top: 9px;
            }
            .signinFast .xR {
                width: 90px;
                height: 2px;
                background-color: #edecec;
                display: block;
                float: right;
                margin-top: 9px;
            }
            .signinFast span {
                line-height: 22px;
                margin-right: 10px;
                font-size: 14px;
                color: #333333;
            }
            .signinFast span {
                line-height: 22px;
                margin-right: 10px;
                font-size: 14px;
                color: #333333;
            }
            .signinFast span {
                line-height: 22px;
                margin-right: 10px;
                font-size: 14px;
                color: #333333;
            }
            #logintype li{
                float:left;
                margin-left:20px;
            }
            #morelogin img{
                width:60px;
                height:60px;
            }
            #morelogin a{
                margin-left:10px;
            }
			 
.signininput ul li {
    border-bottom: 1px solid #f5f5f5!important;     
}
 
        </style>
        <?php if ($_smarty_tpl->tpl_vars['is_wx']->value!=1){?>
        <div style="padding:0px 10px;">
            <div class="signinFast">
                <span class="xL"></span>
                <span style="color:#cccccc;font-size:15px;">其它登录方式</span>
                <span class="xR"></span>
            </div>
        </div>

        <div style="text-align:center;width:100%;height:100px;margin-top:20px;" id="morelogin">
            <a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/plug/login/qqphone/login.php"><img src="/templates/m7/public/wxsite/images/h5_QQ_login.png" alt=""></a>
            <!--<a href=""><img src="/templates/m7/public/wxsite/images/h5_wx_login.png" alt=""></a>-->
        </div>
        <?php }?>
	</div>
</div>
<script>
 var regestercode = '<?php echo $_smarty_tpl->tpl_vars['regestercode']->value;?>
';
 $(function(){    
    if(regestercode ==  1){
    	$('#showgetcode').show();
     
    } 
}); 
function noshow(msg){  
    	Tmsg(msg);
}
//获取手机验证码
function clickyanzheng(){ 
 
        var tempurl = siteurl+'/index.php?ctrl=member&action=fastloginphone&random=@random@&phone=@phone@';
   	 	     tempurl = tempurl.replace('@random@', 1+Math.round(Math.random()*1000)).replace('@phone@',$('#phone').val());
	         $.getScript(tempurl);    
	 
}
function showsend(phone,time){  
  	    $('input[name="phone"]').val(phone);
        $('#dosendbtn').attr('time',time);
        setTimeout("btntime();",1000);   
} 
	function  btntime(){
  
	   var nowtime = Number($('#dosendbtn').attr('time'));
	   if(nowtime > 0){
	      $('#dosendbtn').attr('disabled',true);
	      $('#dosendbtn').addClass('signmebg1');
	      var c = Number(nowtime)-1;
	       $('#dosendbtn').attr('time',c);
	       var  mx = 120-(120 - Number(c));
	        $('#dosendbtn').attr('value','剩余'+mx+'秒');
	         setTimeout("btntime();",1000);
	   }else{
	   	 $('#dosendbtn').attr('disabled',false);
		  $('#dosendbtn').removeClass('signmebg1');
	   	 $('#dosendbtn').attr('value','重新发送');
     }
  
}
	
	
	

 </script>





  
 
 
 
     <div class="bottom-bar-warp">
        <div class="bottom-bar" id="bottom-bar">
            <div class="bbar-btn tap-click" onclick="dolink('<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/index"),$_smarty_tpl);?>
');"  ><i  class="icon icon_home"></i><div class="text" style="margin-top:-8px;">首页</div></div>
            <div class="bbar-btn tap-click" onclick="dolink('<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/order"),$_smarty_tpl);?>
');" ><i class="icon icon_user"></i><div class="text" style="margin-top:-8px;">我的订单</div></div>
     
            <div class="bbar-btn tap-click" onclick="dolink('<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/togethersay"),$_smarty_tpl);?>
');"  ><i class="icon icon_order"></i><div class="text" style="margin-top:-8px;">一起说</div></div>
            <div class="bbar-btn"  onclick="dolink('<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/member"),$_smarty_tpl);?>
');"><i class="icon icon_phone" style="margin-top: 8px;"></i></a><a class="text"  style="margin-top:-10px;">个人中心</div>
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
	//分享到朋友圈
	wx.onMenuShareTimeline({
		title: sharetitle, // 分享标题
		link: sharelink, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
		imgUrl: shareimgUrl, // 分享图标
		success: function () { 
			// 用户确认分享后执行的回调函数
		},
		cancel: function () { 
			// 用户取消分享后执行的回调函数
		}
	});
	//分享给朋友
	wx.onMenuShareAppMessage({
		title: sharetitle, // 
		desc: sharedesc, // 
		link: sharelink, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
		imgUrl: shareimgUrl, // 分享图标
		type: 'link', // 分享类型,music、video或，不填默认为link
		dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
		success: function () { 
			// 用户确认分享后执行的回调函数
			//Tmsg(shareimgUrl);
		},
		cancel: function () { 
			// 用户取消分享后执行的回调函数
			//Tmsg('取消分享');
		}
	}); 
	wx.onMenuShareQQ({
		title: sharetitle, // 分享标题
		desc: sharedesc, // 分享描述
		link: sharelink, // 分享链接
		imgUrl: shareimgUrl, // 分享图标
		success: function () { 
		   // 用户确认分享后执行的回调函数
		},
		cancel: function () { 
		   // 用户取消分享后执行的回调函数
		}
	});
	
	wx.onMenuShareWeibo({
		title: sharetitle, // 分享标题
		desc: sharedesc, // 分享描述
		link: sharelink, // 分享链接
		imgUrl: shareimgUrl, // 分享图标
		success: function () { 
		   // 用户确认分享后执行的回调函数
		},
		cancel: function () { 
			// 用户取消分享后执行的回调函数
		}
	}); 
	wx.onMenuShareQZone({
		title: sharetitle, // 分享标题
		desc: sharedesc, // 分享描述
		link: sharelink, // 分享链接
		imgUrl: shareimgUrl, // 分享图标
		success: function () { 
		   // 用户确认分享后执行的回调函数
		},
		cancel: function () { 
			// 用户取消分享后执行的回调函数
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