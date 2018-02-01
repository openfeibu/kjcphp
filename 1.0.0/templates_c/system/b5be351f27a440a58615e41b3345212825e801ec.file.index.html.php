<?php /* Smarty version Smarty-3.1.10, created on 2018-02-01 10:43:06
         compiled from "D:\UPUPW_K2.1\htdocs\wmr87\module\wxsite\template\index.html" */ ?>
<?php /*%%SmartyHeaderCode:182695a71dd2abf95f3-29332537%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b5be351f27a440a58615e41b3345212825e801ec' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\module\\wxsite\\template\\index.html',
      1 => 1517452976,
      2 => 'file',
    ),
    '2a6b37467a120b1a6178c413540045d22b38c043' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\m7\\public\\wxsite.html',
      1 => 1506688735,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '182695a71dd2abf95f3-29332537',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_5a71dd2c0e3b67_06739315',
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
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a71dd2c0e3b67_06739315')) {function content_5a71dd2c0e3b67_06739315($_smarty_tpl) {?><!DOCTYPE html>
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
 
	
<div data-role="page" >


<link rel="stylesheet"  href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/css/weixinlunbo.css">
<link rel="stylesheet"  href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/css/swiper-3.4.1.min.css">
<link rel="stylesheet"  href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/css/tc114.css">
<script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/js/Swiper/idangerous.swiper.js"></script>


<link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/js/jquerymobile/jquery.mobile.min.css" />
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/js/jquerymobile/jquery.mobile.min.js"></script>

<div class="home_change_head_top">
  <div class="home_change_head_topb">
    <div class="home_change_head_left" onClick="dolink('<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/choice"),$_smarty_tpl);?>
');"  > <img src="/templates/m7/public/wxsite/images/icon_home_dw.png" /> <span lag="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['lat']->value)===null||$tmp==='' ? 0 : $tmp);?>
" lat="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['lng']->value)===null||$tmp==='' ? 0 : $tmp);?>
" id="showareainfo" ><?php if ($_smarty_tpl->tpl_vars['areaid']->value>0){?><?php echo $_smarty_tpl->tpl_vars['mapname']->value;?>
<?php }else{ ?>定位中...<?php }?></span> <i class="fa fa-angle-right"></i> </div>
    <div class="home_change_head_right" onClick="dolink('<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/search"),$_smarty_tpl);?>
');"  >
      <div class="home_change_head_rightinp">
        <input type="text" readonly  placeholder="输入商家或商品名称" />
      </div>
    </div>
  </div>
</div>
<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['CITY_ID']->value;?>
" />
<div id="wxbglogo" style="width:100%;text-align:center;display:none;position: fixed; top: 0px;z-index:-1;
 "><img src="<?php echo $_smarty_tpl->tpl_vars['wxbglogo']->value;?>
" alt="" style="width:40%;width:40%;margin-top:30px;"></div>

	
	

 <div id="loadindecContent"> </div>
 <div id="nearnoshop" style="display:none;">
  <div id="nearnoshopshowBox" style="background: #fff;"  >
     <center>
      <div id="noshop1" style="margin-bottom: 0px;height: 115px;width: 250px;"><img style="height: 115px;width: 250px;" src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/upload/images/nearnoshop.png"></div>
      <div id="noshop2" style="margin-bottom: 50px;height:25px;line-height:25px;color: #7a7a7a;font-size: 14px;">您所在城市暂无开通</div>
      <div id="noshop3" style="width: 110px;height:38px;line-height:38px;background: #ff6e6e;text-align:center;border-radius: 5px;" onClick="dolink('<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/choice"),$_smarty_tpl);?>
');"><span style="color:#fff;">切换城市</span></div>
    </center>
   </div>
</div>
 <script>
 $("#loading").show();
var can_show = true;
 var catid = <?php echo (($tmp = @$_smarty_tpl->tpl_vars['typeid']->value)===null||$tmp==='' ? 0 : $tmp);?>
;
var order = 0;
var qsjid = 0;
var typeid = <?php echo (($tmp = @$_smarty_tpl->tpl_vars['typeid']->value)===null||$tmp==='' ? 0 : $tmp);?>
;
var myaddress = '<?php echo $_smarty_tpl->tpl_vars['myaddress']->value;?>
';
var search_input = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['search_input']->value)===null||$tmp==='' ? '' : $tmp);?>
';
var shopshowtype  = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['shopshowtype']->value)===null||$tmp==='' ? '0' : $tmp);?>
';
var checknext = false;
var lat = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['lat']->value)===null||$tmp==='' ? 0 : $tmp);?>
';
var lng = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['lng']->value)===null||$tmp==='' ? 0 : $tmp);?>
';
var addressname = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['addressname']->value)===null||$tmp==='' ? '' : $tmp);?>
';
var CITY_ID = '<?php echo (($tmp = @$_smarty_tpl->tpl_vars['CITY_ID']->value)===null||$tmp==='' ? 0 : $tmp);?>
';
var is_loading = false;

 	  <?php if (!empty($_smarty_tpl->tpl_vars['lng']->value)&&!empty($_smarty_tpl->tpl_vars['lat']->value)&&!empty($_smarty_tpl->tpl_vars['addressname']->value)){?>
 			loadindexcontent();
		  $('#showareainfo').text(addressname);

   <?php }else{ ?>
		/*if(https == ''){
			getLocation();
		}else{
		}*/
        /* 给客户安装时   把这段代码注释解开   把下边一行demoAddress();注释
		var options = {
			enableHighAccuracy: true,
			maximumAge: 30000,
			timeout: 12000
		}
		window.locationCallback = function(data1,data2){
		   gpstolng(data1,data2);
		}
		var str = '<iframe src="javascript:(function(){window.navigator.geolocation.getCurrentPosition(function(position){  parent && parent.locationCallback && parent.locationCallback(position.coords.latitude,position.coords.longitude);        }, function(err){}, {enableHighAccuracy : '+ options.enableHighAccuracy +', maximumAge : '+ options.maximumAge +', timeout :'+ options.timeout +'});})()" style="display:none;"></iframe>';
		$('body').append(str);
	    */
		demoAddress();

    <?php }?>
	//方便演示测试地址 函数

function getLocation(){
     if (navigator.geolocation)
    {
       navigator.geolocation.getCurrentPosition(showPosition,showError);
    }
   else{
	loadindexcontent();
     $('#showareainfo').text("浏览器不支持定位");
	 setTimeout('goChoiceAdr()',1000);

   }
}
function showPosition(position)
{
	gpstolng(position.coords.latitude,position.coords.longitude);
}
function gpstolng(lat,lng){
	var changelnglaturl = '<?php echo $_smarty_tpl->tpl_vars['map_comment_link']->value;?>
restapi.amap.com/v3/assistant/coordinate/convert?locations='+lng+','+lat+'&coordsys=gps&output=json&key=<?php echo $_smarty_tpl->tpl_vars['map_webservice_key']->value;?>
&callback=changelnglat';
      $.getScript(changelnglaturl);
}
function changelnglat(datas){
 	if(datas.status == 1   && datas.info == 'ok' ) {
		var locations = datas.locations;
  		 var getaddurl = '<?php echo $_smarty_tpl->tpl_vars['map_comment_link']->value;?>
restapi.amap.com/v3/geocode/regeo?output=json&location='+locations+'&key=<?php echo $_smarty_tpl->tpl_vars['map_webservice_key']->value;?>
&radius=1000&extensions=all&callback=newrenderReverse';
		$.getScript(getaddurl);
	}
}

function demoAddress(){
		var lng = '113.543806';
		var lat = '34.80233';
		var formatted_address = '电子商务产业园(郑州高新区)';
		var adcode = '410100';
		 $.ajax({
           type: 'GET',
           url: '<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/saveloation/datatype/json"),$_smarty_tpl);?>
',
           async:false,
 		   data: {'lat':lat,'lng':lng,'addressname':formatted_address,'adcode':adcode},
           dataType: 'json',success: function(content) {
               if(content.error == false){
					 var areainfo = content.msg.areainfoone;
  					 if( areainfo == '' || areainfo.name == undefined ){
						 setTimeout('goChoiceAdr()',1000);
					 }else{
						CITY_ID = areainfo.adcode;
						loadindexcontent();
					 }

             }else{
             	  loadindexcontent();
             }
	    	  },
           error: function(content) {
				loadindexcontent();
	        }
       });
	$("#showareainfo").attr('lng',lng);
	$("#showareainfo").attr('lat',lat);
	$("#showareainfo").text(formatted_address);
}


function newrenderReverse(datas){
  	if(datas.status == 1   && datas.info == 'OK' ) {
	    var lnglat = '';
		var adcode = datas.regeocode.addressComponent.adcode;
		var aois = datas.regeocode.aois;
		var pois = datas.regeocode.pois;
		var roads = datas.regeocode.roads;
		if( aois.length > 0 ){
			var lnglat  = aois[0].location;
			var formatted_address = aois[0].name;
		}else if( pois.length > 0 ){
			var lnglat  = pois[0].location;
			var formatted_address = pois[0].address;
		}else if( roads.length > 0 ){
			var lnglat  = roads[0].location;
			var formatted_address = roads[0].name;
		}
		if( lnglat != '' ){
				var lnglatarr = lnglat.split(',');
				lng = lnglatarr[0];
				lat = lnglatarr[1];
		}

		 $.ajax({
           type: 'POST',
           url: '<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/saveloation/datatype/json"),$_smarty_tpl);?>
',
           async:false,
 		   data: {'lat':lat,'lng':lng,'addressname':formatted_address,'adcode':adcode},
           dataType: 'json',success: function(content) {
               if(content.error == false){
					 var areainfo = content.msg.areainfoone;
  					 if( areainfo == '' || areainfo.name == undefined ){
						 setTimeout('goChoiceAdr()',1000);
					 }else{
						CITY_ID = areainfo.adcode;
						loadindexcontent();
					 }

             }else{
             	  loadindexcontent();
             }
	    	  },
           error: function(content) {
				loadindexcontent();
	        }
       });

	 }else{
		 $('#showareainfo').text('定位失败');
		 setTimeout('goChoiceAdr()',1000);
		 loadindexcontent();
 	 }
	$("#showareainfo").attr('lng',lng);
	$("#showareainfo").attr('lat',lat);
	$("#showareainfo").text(formatted_address);
}


  function showError(error)
  {
	  setTimeout('goChoiceAdr()',1000);
	  loadindexcontent();
	  $('#showareainfo').text(error.code);
  	$('#showareainfo').text("定位失败");
  	Tmsg("定位失败,请手动选择");
   switch(error.code)
    {
    case error.PERMISSION_DENIED:
      //x.innerHTML="User denied the request for Geolocation."
    //  $('#showareainfo').text("User denied the request for Geolocation.");
      break;
    case error.POSITION_UNAVAILABLE:
     // x.innerHTML="Location information is unavailable."
      $('#showareainfo').text("Location information is unavailable.");
      break;
    case error.TIMEOUT:
    //  x.innerHTML="The request to get user location timed out."
    //$('#showareainfo').text("The request to get user location timed out.");
      break;
    case error.UNKNOWN_ERROR:
     // x.innerHTML="An unknown error occurred."
     //  $('#showareainfo').text("An unknown error occurred.");
      break;
    }



  }

  function loadindexcontent(){

		if( CITY_ID <= 0 ){
			  var winHeight = $(window).height()-40-33-46-40;
 			  var allHeight = 115+25+50+38;
 			  var paddHeight = (winHeight-allHeight)/2;
  			  $('#nearnoshopshowBox').css({'height':winHeight+'px','paddingTop':paddHeight+'px'});
			  $('#loadindecContent').html("");
			  $('#loadindecContent').html( $("#nearnoshop").html() );
			  $('#loading').hide();
		}else{
				var ajaxurl = '<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/loadindexcontent"),$_smarty_tpl);?>
';
				$.ajax({
				   type: 'POST',
				   async:true,
				   url: ajaxurl,
				   data: {},
				  dataType: 'html',success: function(content) {
						$('#loadindecContent').html(content);


						setTimeout("newlazyload()",1000);

						$('#wxbglogo').show();
						 $('#loading').hide();
					//	$('.ui-loader').hide();




				  },
				  error: function(content) {
						console.log("加载失败");
				   }
				  });
		}






  }

  function newlazyload(){
  console.log("lazyload");
 	$("#shoplist img").lazyload({
							 effect : "fadeIn"  ,
						   threshold: 2000
						 });
  }
function htmlback(url,info)
{
	var backmessage = {'flag':true,'content':''};
	$.ajax({
       type: 'POST',
       async:true,
       url: url.replace('@random@', 1+Math.round(Math.random()*1000)),
       data: info,
      dataType: 'html',success: function(content) {
	   backmessage['flag'] = false;
      	   backmessage['content'] = content;
		  },
      error: function(content) {
      backmessage['content'] = '获取失败';
	   }
   });
   return backmessage;
}

function goChoiceAdr(){
	 //location.href = '<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/choice"),$_smarty_tpl);?>
';
 	 var winHeight = $(window).height()-40-33-46-40;
 			  var allHeight = 115+25+50+38;
 			  var paddHeight = (winHeight-allHeight)/2;
  			  $('#nearnoshopshowBox').css({'height':winHeight+'px','paddingTop':paddHeight+'px'});
			  $('#loadindecContent').html("");
			  $('#loadindecContent').html( $("#nearnoshop").html() );
			  $('#loading').hide();
}
</script>
<?php if (!empty($_smarty_tpl->tpl_vars['https']->value)){?>
<script type="text/javascript">
function receiveMessage(e) {
	var newdata = e.data;
	<?php if (!empty($_smarty_tpl->tpl_vars['lng']->value)&&!empty($_smarty_tpl->tpl_vars['lat']->value)&&!empty($_smarty_tpl->tpl_vars['addressname']->value)){?>
		<?php }else{ ?>
			if(newdata.loadtion == 'success'){
				 gpstolng(newdata.lat,newdata.lng);
			}else{
				setTimeout('goChoiceAdr()',1000);
				loadindexcontent();
			}
	<?php }?>
}
if (typeof window.addEventListener != 'undefined') {//使用html5 的postMessage必须处理的
	window.addEventListener('message', receiveMessage, false);
} else if (typeof window.attachEvent != 'undefined') {
	window.attachEvent('onmessage', receiveMessage);
}
</script>
<?php }?>
 <style>
body{-webkit-overflow-scrolling: touch;}
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