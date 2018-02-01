<?php /* Smarty version Smarty-3.1.10, created on 2018-01-31 23:14:33
         compiled from "D:\UPUPW_K2.1\htdocs\wmr87\module\wxsite\template\editaddress.html" */ ?>
<?php /*%%SmartyHeaderCode:292855a71dd59c65a66-84074122%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '52c8677e98dc920f5f1e934f2ee9c60db906f856' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\module\\wxsite\\template\\editaddress.html',
      1 => 1507885277,
      2 => 'file',
    ),
    '2a6b37467a120b1a6178c413540045d22b38c043' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\m7\\public\\wxsite.html',
      1 => 1506688735,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '292855a71dd59c65a66-84074122',
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
  'unifunc' => 'content_5a71dd5ae0c528_57750871',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a71dd5ae0c528_57750871')) {function content_5a71dd5ae0c528_57750871($_smarty_tpl) {?><?php if (!is_callable('smarty_function_load_data')) include 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\lib\\Smarty\\libs\\plugins\\function.load_data.php';
?><!DOCTYPE html>
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


<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/css/gaodecss.css"/>
  <script src="<?php echo $_smarty_tpl->tpl_vars['map_comment_link']->value;?>
webapi.amap.com/maps?v=1.3&key=<?php echo $_smarty_tpl->tpl_vars['map_javascript_key']->value;?>
"></script>
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
$(function(){
	var getscreenwidth = $(window).width();
	var inputWidth = getscreenwidth-58;
	$(".newaddBox ul li input").css('width',inputWidth+'px');

});
		function scorllerfreach(scoller_name,elements_name){
		
			if(typeof(scoller_name) != 'undefined'){
				scoller_name.destroy();
			}

			scoller_name = new iScroll(''+elements_name +'', {
				hScroll:false,hScrollbar:false, vScrollbar:false,mouseWheel: true, click: true, tap: true,mouseWheel: true,preventDefault:false,
			});
			return scoller_name;
		}
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
 
	<!--标题-->
 <?php echo smarty_function_load_data(array('assign'=>"info",'table'=>"address",'type'=>"one",'where'=>"id='".((string)$_smarty_tpl->tpl_vars['id']->value)."' and userid = '".((string)$_smarty_tpl->tpl_vars['member']->value['uid'])."'",'fileds'=>"*"),$_smarty_tpl);?>
 

	<!--标题-->
<div class="toptitCon">
 <div class="toptitBox addressbox" >
 <div class="toptitL" ><i></i></div>
  <div class="toptitC"><h3><?php if (!empty($_smarty_tpl->tpl_vars['info']->value)){?>编辑<?php }else{ ?>新增<?php }?>收货地址</h3></div>
<!--  <div class="toptitR" onclick="saveaddress();"><h3>保存</h3></div>-->
 </div>
 
 <div class="mapaddressbox toptitBox" style="display:none; padding:0px; height:49px;">
 <!--搜索框-->
 
<div class="searchCon" >
 <div class="toptitL" style="margin-top:5px;"><i></i></div>
 <div class="searchBox" style="float:left; margin-left:15px; width:80%; height:32px;">
 <input style="height:32px; line-height:32px; padding-left:25px; font-size:14px;width:100%;" type="text" id="searchKeywords"  onkeyup="getscraddress();" placeholder="搜索地址"><i></i></div>
</div>

</div>
 
 
</div>



	
	
 <div id="wrapper" style="top:40px;">
	<div id="scroller">

 <style>
 .newadd li .newinp {
    width: 200px;
  margin-left: 0px;
    font-size: 14px;
}
.newadd {width:100%;}
.newadd li {
    border-bottom: 1px solid #e8e8e8;
    line-height: 42px;}
 </style>



	    <div class="addressbox">
			<input type="hidden" name="add_addressid" value="<?php echo $_smarty_tpl->tpl_vars['addressid']->value;?>
"  >
            <!--联系人-->
            <div class="newaddCon">
                <div class="newaddBox">
                    <ul class="newadd">
                        <li><a>&nbsp;&nbsp;&nbsp;姓名：</a><input type="text" placeholder="请填写收货人的姓名" id="contactname" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['contactname'];?>
" name="" class="newinp"></li>
                        <li><a>&nbsp;&nbsp;&nbsp;手机：</a><input type="text" placeholder="请填写收货人手机号" id="mobile" name="phone" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['phone'];?>
" class="newinp"></li>
                         <?php if ($_smarty_tpl->tpl_vars['areacode']->value==1){?>
                         <li id="showgetcode" class="signmehide">
                             <i class="signinmess"></i>
                             <input type="text" name="check_message" id="phoneyan"   value="" placeholder="输入短信验证码">
                             <input type="button"  onclick="clickyanzheng();"   time="0" id="dosendbtn"  value="发送到手机" class="signmeinput">
                         </li>
                         <?php }?>
                      
                 
                        <li style=" height:44px; ">
                            <a style="float:left;">&nbsp;&nbsp;&nbsp;地址：</a>
                            <div lng="<?php echo $_smarty_tpl->tpl_vars['info']->value['lng'];?>
" lat="<?php echo $_smarty_tpl->tpl_vars['info']->value['lat'];?>
" lnglat="" style="float:left; height:44px; line-height:44px;margin-left:20px;" id ='selectSendAddress' type="text"  class="newinp1"><?php echo (($tmp = @$_smarty_tpl->tpl_vars['info']->value['bigadr'])===null||$tmp==='' ? '点击选择地址' : $tmp);?>
</div>
                        </li>
                        <div class="clear"></div>
                        <li><a>&nbsp;&nbsp;&nbsp;楼号-门牌号：</a><input type="text" placeholder="例：16号楼107室" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['detailadr'];?>
" class="newinp2"></li>
                  
						 
						<div class="selectLabCon">
	<div class="selectLabL">
		<span>标&nbsp;&nbsp;&nbsp;签：</span>
	</div>
	<div class="selectLabR">
			<div class="selectLabBox">
			<input type="hidden" name="i_tag" id="i_tag" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['info']->value['tag'])===null||$tmp==='' ? 1 : $tmp);?>
" /> 
			<span><?php if (!empty($_smarty_tpl->tpl_vars['info']->value)){?><?php if ($_smarty_tpl->tpl_vars['info']->value['tag']==1){?>家<?php }elseif($_smarty_tpl->tpl_vars['info']->value['tag']==2){?>公司<?php }elseif($_smarty_tpl->tpl_vars['info']->value['tag']==3){?>学校<?php }else{ ?>无<?php }?><?php }else{ ?>家<?php }?></span>
			<i class="fa fa-caret-down" style="font-size: 14px; margin-right: 12px;"></i>
		</div>
			<div class="selectLab" style="display:none;">
			<ul>
							<li tagid="1" tagname="家">
					<span>家</span>
					<input type="radio" name="selb">
				</li>
							<li tagid="2" tagname="公司">
					<span>公司</span>
					<input type="radio" name="selb">
				</li>
							<li tagid="3" tagname="学校">
					<span>学校</span>
					<input type="radio" name="selb">
				</li>
							<li tagid="0" tagname="无">
					<span>无</span>
					<input type="radio" name="selb">
				</li>
							 
			</ul>
		</div>
	</div>
</div>
 		 
                    </ul>
                </div>
            </div>
            <div class="intexchabutt"  onclick="saveaddress();" style="margin-top:15px;"><input type="button"  value="保存地址" class="intexbg1"></div>
        </div>



		<div class="mapaddressbox"  style="display:none;">
	<div class="showmapbox">
		 <div class="mapditu" id="map">
			
		 </div>
		 
		 <div id="marker_red_sprite"><img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/upload/map/marker_red_sprite.png" /></div>
	</div>
 
	
<div id="choiceguidebox" >
	<ul>
	 
	</ul>
</div>
</div>

<!-------------------------------------------------------------------------切换地址结束---------------------------------------------------------------------------------->

	
	
	
  </div>
</div>
<div id="selectAddress" style="display:none; position:absolute;z-index:1; width:100%;height:100%;background:#fff;  " >

</div>

<script>
var back = 1;
var map,market;
var biaoqianval = false;
 function bqzhi(){
	biaoqianval  = false;
}
var selectSendAddress; 
$("#selectSendAddress").bind('click',function() {
	if (lockclick()) {
		back = 1
		$("#selectAddress").show();
		$(".addressbox").hide();
		$("#selectAddress").html('');
		var content = htmlback(siteurl + '/index.php?ctrl=wxsite&action=gaodewebapi', {});
		if (content.flag == false) {
			$("#selectAddress").html(content.content);
			$('#searchAddresslist').hide();
			$('#searchKeywordss').unbind();
			$("#searchKeywordss").bind('click',function(){
								back = 1;
								$('#searchAddresslist').show();
								 $('#searchAddresslist').css({'position':'absolute','top':'0px','marginTop':'42px','width':'100%','background':'#FFF','zIndex':'99999999999999','height':($(window).height()-42)+'px'}); 
								  
								 selectSendAddress=    new iScroll('searchAddresslist', {
									useTransform: false,
									onBeforeScrollStart: function (e) {
									var target = e.target;
									while (target.nodeType != 1) target = target.parentNode;

									if (target.tagName != 'SELECT' && target.tagName != 'INPUT' && target.tagName != 'TEXTAREA')
										e.preventDefault();
									}
								});
								bindsearchclick();
			});  
			$("#searchKeywordss").bind('keyup',function(e){
				//if(biaoqianval == false){
					//biaoqianval  = true;
					//setTimeout("bqzhi()", 500 );
					var searchval  = $("#searchKeywordss").val();
					if( searchval != '' && searchval != undefined ){
						var addresslist = '<?php echo $_smarty_tpl->tpl_vars['map_comment_link']->value;?>
restapi.amap.com/v3/place/text?&keywords='+searchval+'&city=<?php echo $_smarty_tpl->tpl_vars['CITY_NAME']->value;?>
&output=json&offset=20&page=1&key=<?php echo $_smarty_tpl->tpl_vars['map_webservice_key']->value;?>
&extensions=all&callback=showaddresslist';
						$.getScript(addresslist);
					}else{
						$('#searchAddresslist div').html('');
					}
				//}
			});
			
			
		} 
		window.addEventListener("message", function(e){
				var name = e.data.name;
				var lnglat = e.data.location;
				if(  name != '' && lnglat!='' ){
					$('#selectAddress').hide();
					$('#selectSendAddress').text(name);
					$('#selectSendAddress').attr('lnglat',lnglat);
					$("#selectAddress").hide();
					$(".addressbox").show();

				}else{
					Tmsg('数据获取失败');
				}
		}, false);

	}
	
	  
		
		$("#houtuiimg").bind('click',function(){ 
				 if(back == 1){
						 $("#selectAddress").hide();
						 $(".addressbox").show();
				  }else{
						 back = 1;
						 $("#searchAddresslist").hide();
						 $('#selectadd').show();
				  } 
		  }); 
		
	});
 $('.selectLabBox').bind('click',function(){
		if( lockclick() ){
			
			$('.selectLab li').removeClass('show');
			var curtagid = $('input[name="i_tag"]').val();
			console.log(curtagid);
			if( curtagid > 0 ){
				$('.selectLab li').eq(curtagid-1).addClass('show');
			}else{
				$('.selectLab li').eq(3).addClass('show');
			}
 			$('.selectLab').toggle();
			if($(".selectLab").is(":hidden")){
				$('.selectLabBox i').addClass('fa-caret-down');
				$('.selectLabBox i').removeClass('fa-caret-up');
			}else{
				$('.selectLabBox i').addClass('fa-caret-up');
				$('.selectLabBox i').removeClass('fa-caret-down');
			}
			
			$('.selectLab li').bind('click',function(){
				if( lockclick() ){
 					$('input[name="i_tag"]').val($(this).attr('tagid'));
					$('.selectLabBox span').text($(this).attr('tagname'));
					$('.selectLab').toggle();
					if($(".selectLab").is(":hidden")){
						$('.selectLabBox i').addClass('fa-caret-down');
						$('.selectLabBox i').removeClass('fa-caret-up');
					}else{
						$('.selectLabBox i').addClass('fa-caret-up');
						$('.selectLabBox i').removeClass('fa-caret-down');
					}
				}
			});
			
		}
	}); 
function showaddresslist(data){
	 
	$("#searchAddresslist").show();
	var datas = eval(data);
	if(datas.info == "OK"  && datas.status == 1  && datas.pois.length > 0 ){
		$('#searchAddresslist div').html('');
		var addresslist = datas.pois;

		var showhtmls = '';
		$.each(addresslist, function(i, newobj) {
			showhtmls += '<div class="selADditem J_returnLng" data-lng-lat="'+newobj.location+'"  ><div class="txt"><div class="poicard-name">'+newobj.name+'</div> <div class="poicard-addr">'+newobj.address+'</div></div></div>';
		});
	     $('#searchAddresslist div').append(showhtmls); 
		selectSendAddress.refresh();		
		bindsearchclick();
	}
}


function bindsearchclick(){ 
	$('#searchAddresslist .selADditem').unbind();
	$('#searchAddresslist .selADditem').bind('click',function(){
		
		var name = $(this).find('.poicard-name').text();
		var lnglat = $(this).attr('data-lng-lat');
		choiceaddresslnglat(name,lnglat);
	});
}
function choiceaddresslnglat(name,lnglat){
	$("#selectAddress").hide();
	$(".addressbox").show();
	colde_type = 0;
	if(  name != '' && lnglat!='' ){
		$('#selectSendAddress').text(name);
		$('#selectSendAddress').attr('lnglat',lnglat);
	}else{
		Tmsg('选择地址获取失败，请重新选择');
	}
}


function saveaddress(){
	$('#loading').show();
	var detailadr = $(".newinp2").val();
<?php if ($_smarty_tpl->tpl_vars['addAreaType']->value==1){?>
	var bigadr = $(".newinp1").val();
	var tempaddress = $(".newinp1").val();
<?php }else{ ?>
	var bigadr = $(".newinp1").text();
	var tempaddress = $(".newinp1").text()+$(".newinp2").val();
<?php }?>
	var	lnglatstr= $(".newinp1").attr("lnglat");
	if(lnglatstr){
		lnglatarr = lnglatstr.split(',');
		var lng = lnglatarr[0];
		var lat = lnglatarr[1];
	}else{
		var lng = $(".newinp1").attr('lng');
		var lat = $(".newinp1").attr('lat');
	}
	var tag = $('input[name="i_tag"]').val();
	var info = {'contactname':$('#contactname').val(),'tag':tag,'lng':lng,'lat':lat,'phone':$('#mobile').val(),'check_message':$('#phoneyan').val(),'bigadr':bigadr,'detailadr':detailadr,'add_new':tempaddress,'addressid':$('input[name="add_addressid"]').val()};
	var url = '<?php echo FUNC_function(array('type'=>'url','link'=>"/area/saveaddress/random/@random@/datatype/json"),$_smarty_tpl);?>
';
	var backdata = ajaxback(url,info);
	if(backdata.flag == false){
		window.location.href = '<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/address"),$_smarty_tpl);?>
';
	}else{
		$('#loading').hide();
		newTmsg(backdata.content);
	}

}
//获取手机验证码
function clickyanzheng(){
		var tempurl = siteurl + '/index.php?ctrl=area&action=areaAddressPhone&random=@random@&phone=@phone@';
		tempurl = tempurl.replace('@random@', 1 + Math.round(Math.random() * 1000)).replace('@phone@', $('#mobile').val());
		$.getScript(tempurl);
}
function areashowsend(phone,time){
	$('input[name="phone"]').val(phone);
	$('#dosendbtn').attr('time',time);
	setTimeout("btntime();",1000);
}
function noshow(msg){
	alert(msg);
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