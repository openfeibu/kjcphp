<?php /* Smarty version Smarty-3.1.10, created on 2018-01-31 23:14:58
         compiled from "D:\UPUPW_K2.1\htdocs\wmr87\module\wxsite\template\gaodewebapi.html" */ ?>
<?php /*%%SmartyHeaderCode:216385a71dd72111a86-16777930%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ca4fa17e028ebbd136c0128fa3696aa2fca68d3f' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\module\\wxsite\\template\\gaodewebapi.html',
      1 => 1505185985,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '216385a71dd72111a86-16777930',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'siteurl' => 0,
    'tempdir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_5a71dd721786c8_04066252',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a71dd721786c8_04066252')) {function content_5a71dd721786c8_04066252($_smarty_tpl) {?><div class="titCons" style="">
    <div class="titBoxs">
        <div class="titCs" style="width: 71.7647%;">
            <div class="searchCons">
                <div class="searchBoxs">
                    <img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/wxsite/images/top04.png" id="houtuiimg" style="width:14px;height:20px;position:absolute;top:10px;left:12px;" alt="">
                    <i></i>
                    <input style=" font-size: 14px;text-indent:2em; background-color:#fff;" type="text"   id="searchKeywordss"  placeholder="搜索附近位置">
                </div>
            </div>
        </div>
    </div>
</div>
<div style="clrar:both;"></div>
<div id="searchAddresslist" style="display:none;position:absolute;left:0px;top:40px;width:100%;z-index:9999999999999;bottom:0px;">
    <div style="width:350px;">

    </div>
</div>
<iframe id="selectadd" style="width:100%;height:100%;position: absolute;top: -6px; z-index: 999999;opacity:10;  " 
src="http://apis.map.qq.com/tools/locpicker?search=1&type=1&key=OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77&referer=myapp&search=1"></iframe>

<script>
   	 
					 window.addEventListener('message', function(event) {
					
						console.log(event);
						// 接收位置信息，用户选择确认位置点后选点组件会触发该事件，回传用户的位置信息
 						// var name = event.data.poiaddress;
		 				var name = event.data.poiname;
		 				if(name == '我的位置'){
		 					var name = event.data.poiaddress;
		 				}
						var lng = event.data.latlng.lng;
						var lat = event.data.latlng.lat;
						var lnglat = lng+','+lat;
						var module = event.data.module;
						
						if (module == 'locationPicker' &&   name != '' && lnglat != '') {
							$('#selectAddress').hide();
							$('#detailaddress').text(name);
							 $('.newinp2').text(name);
							$('#detailaddress').text(name);
							$('#selectSendAddress').text(name);
							
							$('.newinp2').attr('address',name);
							$('.newinp2').attr('lnglat',lnglat);
							$('#selectSendAddress').attr('lnglat', lnglat);
							$('#selectSendAddress').attr('lng', lng);
							$('#selectSendAddress').attr('lat', lat);
							$(".addressbox").show();

						} else {
							newTmsg('数据获取失败');
						}
						                                
					}, false);  
					 
</script><?php }} ?>