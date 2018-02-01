<?php /* Smarty version Smarty-3.1.10, created on 2018-01-31 23:14:04
         compiled from "D:\UPUPW_K2.1\htdocs\wmr87\module\wxsite\template\choice.html" */ ?>
<?php /*%%SmartyHeaderCode:56225a71dd3c7ab5f7-21223677%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f5ece6ddd4daa4e59cec6708eb783da7b83672d9' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\module\\wxsite\\template\\choice.html',
      1 => 1507700479,
      2 => 'file',
    ),
    '2a6b37467a120b1a6178c413540045d22b38c043' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\m7\\public\\wxsite.html',
      1 => 1506688735,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '56225a71dd3c7ab5f7-21223677',
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
  'unifunc' => 'content_5a71dd3dc014b5_80781662',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a71dd3dc014b5_80781662')) {function content_5a71dd3dc014b5_80781662($_smarty_tpl) {?><?php if (!is_callable('smarty_function_load_data')) include 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\lib\\Smarty\\libs\\plugins\\function.load_data.php';
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
/public/wxsite/css/wmr_newaddress.css">    


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
<div class="toptitCon">
 <div class="toptitBox">
  <div class="adr_toptitL"><a href="javascript:void(0);"><i></i></a></div>
  <div class="toptitC"><h3>选择收货地址</h3></div>
 </div>
</div> 
<div class="swiaddCon">
	<div class="swiaddL" id="selectCity" style="width:auto!important;">
		<div class="swiadd" style="width:auto!important;padding-right:13px;">
			<span id="cityname" style="width:auto!important;"><?php if (!empty($_smarty_tpl->tpl_vars['CITY_NAME']->value)){?><?php echo (($tmp = @$_smarty_tpl->tpl_vars['CITY_NAME']->value)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['cityname']->value : $tmp);?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['cityname']->value;?>
<?php }?></span>
			<input type="hidden" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['CITY_ID']->value)===null||$tmp==='' ? $_smarty_tpl->tpl_vars['default_cityid']->value : $tmp);?>
" name="cityId" />
			<i class="fa fa-angle-down" style="margin-left:5px;"></i>
		</div>
	</div>
	<div class="swiaddR">
		<div class="swiaddsea">
			<input type="text" id="wmrSearchKeywords"  style="text-align:center;height:20px;"  value="" placeholder="请输入您的收货地址" />
			<i class="clearSerchInput" style="display:none;"></i>
		</div>
		<div class="swiaddbtn">
			<input id="searchButton" type="button" value="搜索" />
		</div>
	</div>
</div>


	
	  
 <div id="wrapper" style="top:88px;">
	<div id="scroller">
 
<div class="defaposCon"  onclick="dolink('<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/dwLocation"),$_smarty_tpl);?>
');"  >
	<i></i><span>定位当前位置</span>
</div> 

<?php echo smarty_function_load_data(array('assign'=>"addresslist",'table'=>"address",'fileds'=>"*",'limit'=>"100",'orderby'=>" addtime desc",'where'=>" userid = '".((string)$_smarty_tpl->tpl_vars['member']->value['uid'])."' and  lng != '' and lat != '' and  bigadr != '' and address != ''   "),$_smarty_tpl);?>
 
 <?php if (!empty($_smarty_tpl->tpl_vars['addresslist']->value['list'])){?>
 <div class="defaTit">
	<i></i><span>我的收货地址</span>
</div>
<div class="defaCon" id="historyaddList">
	<ul>
	<?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['addresslist']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
?>
		<li  lat="<?php echo $_smarty_tpl->tpl_vars['items']->value['lat'];?>
"  lng="<?php echo $_smarty_tpl->tpl_vars['items']->value['lng'];?>
"  address="<?php echo $_smarty_tpl->tpl_vars['items']->value['bigadr'];?>
"   >
			<div class="defaTop">
				<h3><?php echo $_smarty_tpl->tpl_vars['items']->value['address'];?>
</h3>
			</div>
			<div class="defaBot">
				<span><?php echo $_smarty_tpl->tpl_vars['items']->value['contactname'];?>
</span><span><?php echo $_smarty_tpl->tpl_vars['items']->value['phone'];?>
</span>
			</div>
		</li>
	 <?php } ?>
	</ul>
</div>
<?php }?>

 
   
  </div>
</div> 
 
 
<div id="searchAddresslist"  style="display:none;">
	<div>
	<?php if (!empty($_smarty_tpl->tpl_vars['cook_adrlistcookie']->value)){?>
		 <div class="defachoCon" id="searchHist">
			<div class="defachoTit">
				<div class="defachoTitL">
					<i></i><span>搜索历史</span>
				</div>
				<div id="clearAdrCookie" class="defachoTitR">
					<span>清空</span>
				</div>
			</div>
			<div class="defachoBox">
				<ul>
					<?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cook_adrlistcookie']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
?>
 							<li lng="<?php echo $_smarty_tpl->tpl_vars['items']->value[0];?>
" lat="<?php echo $_smarty_tpl->tpl_vars['items']->value[1];?>
" address="<?php echo $_smarty_tpl->tpl_vars['items']->value[2];?>
" adcode="<?php echo $_smarty_tpl->tpl_vars['items']->value[3];?>
" ><?php echo $_smarty_tpl->tpl_vars['items']->value[2];?>
</li>
 					<?php } ?>
				</ul>
			</div>
		</div>
	<?php }?>
	
		  <div class="entaddCon"  >
			<ul id="showAdrlist">
				 
			</ul>
		</div> 
		
		
	</div>
</div>


<div id="selectCityList"  style="display:none;">
	<div>
	 
		
		 <div class="alropeCon">
			<div class="alropeTit">
				<div class="alropeTitL">
					<span>已开通城市</span>
				</div>
			</div>
			<div class="alropeBox">
				<ul>
					<?php echo smarty_function_load_data(array('assign'=>"arealist",'table'=>"area",'fileds'=>"*",'limit'=>"1000",'orderby'=>" orderid asc",'where'=>" id > 0 and parent_id = 0 "),$_smarty_tpl);?>
 
 					<?php if (!empty($_smarty_tpl->tpl_vars['arealist']->value['list'])){?>
						<?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['arealist']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
?>
							<li cityid="<?php echo $_smarty_tpl->tpl_vars['items']->value['adcode'];?>
"  style="overflow:hidden;" <?php if ($_smarty_tpl->tpl_vars['CITY_ID']->value==$_smarty_tpl->tpl_vars['items']->value['adcode']){?> class="curaA" <?php }?> ><?php echo $_smarty_tpl->tpl_vars['items']->value['name'];?>
</li>
						<?php } ?>
					<?php }?>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		
	</div>
</div>



<script>
var lng;
var lat;
var address;
var backtype = 0;
var biaoqianval = false;
var selectaddscorl;
var adrlistcookie = new Array();
function bqzhi(){
	biaoqianval  = false;
}
 $(function(){  
	<?php if (!empty($_smarty_tpl->tpl_vars['cook_adrlistcookie']->value)){?>
		<?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cook_adrlistcookie']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
?>
			var adrtempary = new Array();
			<?php  $_smarty_tpl->tpl_vars['itv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['itv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['itv']->key => $_smarty_tpl->tpl_vars['itv']->value){
$_smarty_tpl->tpl_vars['itv']->_loop = true;
?> 
				adrtempary.push('<?php echo $_smarty_tpl->tpl_vars['itv']->value;?>
');
			<?php } ?>
			adrlistcookie.push(adrtempary);
		<?php } ?>
 	<?php }?> 
	 
 });
 
 $("#historyaddList ul li").bind('click',function(){
		if( lockclick() ){
			lat = $(this).attr('lat');
			lng = $(this).attr('lng');
			address = $(this).attr('address'); 
			var getaddurl = '<?php echo $_smarty_tpl->tpl_vars['map_comment_link']->value;?>
restapi.amap.com/v3/geocode/regeo?output=json&location='+lng+','+lat+'&key=<?php echo $_smarty_tpl->tpl_vars['map_webservice_key']->value;?>
&radius=1000&extensions=all&callback=func_getadcode';
			$.getScript(getaddurl); 
		}
		
	});
	 $("#searchHist ul li").bind('click',function(){
		if( lockclick() ){
			lat = $(this).attr('lat');
			lng = $(this).attr('lng');
			address = $(this).attr('address'); 
			adcode = $(this).attr('adcode'); 
			choiceaddress(lat,lng,address,adcode);
 		}
	}) 
 
 $('#clearAdrCookie').bind('click',function(){
	$('#searchHist').hide();
	$('#searchHist ul').html('');
	$.cookie('cook_adrlistcookie', null);
 });
function func_getadcode(datas){ 
	if(datas.status == 1   && datas.info == 'OK' ) {
		var adcode = datas.regeocode.addressComponent.adcode;
 		choiceaddress(lat,lng,address,adcode);
	}
}  
$('#selectCityList ul li').bind('click',function(){

	$('#selectCityList ul li').removeClass('curaA');
	$(this).addClass('curaA');
	$('#selectCityList').hide();
	$('#cityname').text($(this).text());
	var cityid = $(this).attr('cityid');
	$('input[name="cityId"]').val(cityid);
	
	var searchval  = $("#wmrSearchKeywords").val();
 	if( searchval != '' && searchval != undefined ){
		func_searchinputAdr();
	}

});  
$('.toptitBox .adr_toptitL').bind("click", function() {    
		if( backtype == 1 ){
			$("#searchAddresslist").hide();
			backtype = 0;
		}else if( backtype == 2 ){
			$("#searchAddresslist").hide();
			$("#selectCityList").hide();
			backtype = 0;
		}else{
			history.back();
		}
    });
function choiceaddress(lat,lng,address,adcode){  
	 $.ajax({
           type: 'GET', 
           url: '<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/saveloation/datatype/json"),$_smarty_tpl);?>
',
           async:false,
 		   data: {'lat':lat,'lng':lng,'addressname':address,'adcode':adcode},
           dataType: 'json',success: function(content) { 
               if(content.error == false){
					 var temparr = new Array();
					 temparr.push(lng); 
					 temparr.push(lat); 
					 temparr.push(address); 
					 temparr.push(adcode); 
					 adrlistcookie.push(temparr);
  					 var adrlistcookieList = adrlistcookie.join('#');
 					 $.cookie("cook_adrlistcookie",adrlistcookieList,{path: "/", expiress: 365*10});
					 window.location.href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/index.php?ctrl=wxsite";
             }else{
             	  newTmsg(content.msg);
             }
	    	  },
           error: function(content) { 
				newTmsg('提交数据失败');
	        }
       });  
		
	}
$('#searchButton').bind('click',function(){
	if( lockclick() ){
		$(".clearSerchInput").show();
		// $("#showAdrlist").html('');
		 $('#selectCityList').hide();
		 backtype = 1;
		 $('#searchAddresslist').show();
		 $('#searchAddresslist').css({'position':'absolute','top':'84px','width':'100%','background':'#FFF','zIndex':'9999','height':($(window).height()-84)+'px'}); 
		 selectaddscorl = scorllerfreach(selectaddscorl,'searchAddresslist');
	}
 });
$("#wmrSearchKeywords").bind('click',function(){
	if( lockclick() ){
		 $(".clearSerchInput").show();
		// $("#showAdrlist").html('');
		 $('#selectCityList').hide();
		 backtype = 1;
		 $('#searchAddresslist').show();
		 $('#searchAddresslist').css({'position':'absolute','top':'84px','width':'100%','background':'#FFF','zIndex':'9999','height':($(window).height()-84)+'px'}); 
		 selectaddscorl = scorllerfreach(selectaddscorl,'searchAddresslist');
	 }
 });
 $("#wmrSearchKeywords").bind('keyup',function(e){
					if(biaoqianval == false){
						biaoqianval  = true;
						setTimeout("bqzhi()", 500 );   
						func_searchinputAdr();
					}
}); 
function func_searchinputAdr(){
	var searchval  = $("#wmrSearchKeywords").val();
								var cityname  = $("#cityname").text();
								if( searchval != '' && searchval != undefined ){
									var addresslist = '<?php echo $_smarty_tpl->tpl_vars['map_comment_link']->value;?>
restapi.amap.com/v3/place/text?&keywords='+searchval+'&city='+cityname+'&output=json&offset=20&page=1&key=<?php echo $_smarty_tpl->tpl_vars['map_webservice_key']->value;?>
&extensions=all&callback=showaddresslist';						 
									$.getScript(addresslist); 
								}else{
 									$(".clearSerchInput").hide();
									$("#searchAddresslist").hide();
									backtype = 0;
								}
								 
}
function showaddresslist(data){
	console.log(data);
	var datas = eval(data); 
 	if(datas.info == "OK"  && datas.status == 1  && datas.pois.length > 0 ){
		$('#showAdrlist').html('');
		var addresslist = datas.pois;
 		var showhtmls = '';
		if( addresslist != '' ){
			$('#searchHist').hide();
			$('#selectCityList').hide();
			$.each(addresslist, function(i, newobj) {
			  showhtmls += '<li address="'+newobj.name+'" datalnglat="'+newobj.location+'"   ><div class="entaddL"><h3>'+newobj.name+'</h3><span>'+newobj.address+'</span></div><div class="entaddR"><span></span></div></li>';
			});
			 $('#showAdrlist').append(showhtmls);
			 selectaddscorl.refresh();
			 $('#showAdrlist li').bind('click',function(){
				 if( lockclick() ){
					var lnglat = $(this).attr('datalnglat');
					if( lnglat != '' && address != '' ){
						var lnglatarr = lnglat.split(',');
						lng = lnglatarr[0];
						lat = lnglatarr[1];
						address = $(this).attr('address');
						var getaddurl = '<?php echo $_smarty_tpl->tpl_vars['map_comment_link']->value;?>
restapi.amap.com/v3/geocode/regeo?output=json&location='+lng+','+lat+'&key=<?php echo $_smarty_tpl->tpl_vars['map_webservice_key']->value;?>
&radius=1000&extensions=all&callback=func_getadcode';
						$.getScript(getaddurl);
					}
				 }
			 });
		}else{
			$('#showAdrlist').html('');
			selectaddscorl.refresh();
		}
		 
	}else{
		$('#showAdrlist').html('');
		selectaddscorl.refresh();
	}
}
				 
$('.clearSerchInput').bind('click',function(){
	if( lockclick() ){
		$('#wmrSearchKeywords').val('');
		$(".clearSerchInput").hide();
		$("#searchAddresslist").hide();
		backtype = 0;
	}
 });
 
$("#selectCity").bind('click',function(){
	if( lockclick() ){
 		 backtype = 2;
		 $('#selectCityList').toggle();
		 $('#selectCityList').css({'position':'absolute','top':'84px','width':'100%','background':'#FFF','zIndex':'9999','height':($(window).height()-84)+'px'}); 
		 selectaddscorl = scorllerfreach(selectaddscorl,'selectCityList');
	 }
 }); 
 
function scorllerfreach(scoller_name,elements_name){
	 
	if(typeof(scoller_name) != 'undefined'){
		scoller_name.destroy();
	} 
	scoller_name = new iScroll(''+elements_name+'', { 
			hScrollbar:false, 
			vScrollbar:false,
			onBeforeScrollStart: function (e) {
			var target = e.target;
			while (target.nodeType != 1) target = target.parentNode;

			if (target.tagName != 'SELECT' && target.tagName != 'INPUT' && target.tagName != 'TEXTAREA' )
				e.preventDefault();
			},
			useTransition: true 
			
    });  
	return scoller_name;
}				 
</script>
<style>
#wmrSearchKeywords{color:#fff!important;}
.toptitBox .adr_toptitL {
    height: 22px;
    display: inline-block;
    width: 3.625%;
    float: left;
}
.toptitBox .adr_toptitL i {
    display: inline-block;
    width: 100%;
    height: 22px;
    background-image: url(<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/images/top04.png);
    background-repeat: no-repeat;
    background-size: 100%;
}
</style>
 
 
 
 
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