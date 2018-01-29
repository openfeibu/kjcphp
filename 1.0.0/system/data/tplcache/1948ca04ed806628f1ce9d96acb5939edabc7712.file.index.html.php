<?php /* Smarty version Smarty-3.1.8, created on 2017-11-27 08:55:35
         compiled from "D:\WWW\48ym\themes\ele\web\index.html" */ ?>
<?php /*%%SmartyHeaderCode:169675a1b62877bcfc9-63094040%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1948ca04ed806628f1ce9d96acb5939edabc7712' => 
    array (
      0 => 'D:\\WWW\\48ym\\themes\\ele\\web\\index.html',
      1 => 1479784203,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '169675a1b62877bcfc9-63094040',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'site' => 0,
    'MEMBER' => 0,
    'mcity' => 0,
    'city' => 0,
    'k' => 0,
    'items' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a1b62878787e4_01753922',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a1b62878787e4_01753922')) {function content_5a1b62878787e4_01753922($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\WWW\\48ym\\system\\plugins/smarty\\function.link.php';
if (!is_callable('smarty_modifier_qq')) include 'D:\\WWW\\48ym\\system\\plugins/smarty\\modifier.qq.php';
?><!DOCTYPE html>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>酷乐送</title>

<link rel="stylesheet" type="text/css" href="/themes/default/web/static/css/pub.css?201601013" />

<link rel="stylesheet" type="text/css" href="/themes/default/web/static/css/style.css?201601013" />

<script type="text/javascript" src="/themes/default/web/static/js/jquery.js?201601013"></script>

<script src="/static/script/layer/layer.js" type="text/javascript" charset="utf-8"></script>

<script src="/themes/default/web/static/js/common.js?201601013" type="text/javascript" charset="utf-8"></script>

</head>

<body class="smallpage" style="background:#E7E8EB;">

<iframe id="miniframe" name="miniframe" style="display:none;"></iframe>



<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=7b92b3afff29988b6d4dbf9a00698ed8"></script>

<script type="text/javascript" language="javascript">

    function enterPress(e){ 

        if(e.keyCode == 13) { 

            $('#search_btn').click();

        }

    }

</script>

<style>

    .tangram-suggestion table tr td{height: 60px !important;line-height: 60px !important; border-bottom: 1px solid #ededed;}

    #l-map img{transition: all 0s ease; -webkit-transition: all 0s ease; -moz-transition: all 0s ease; -ms-transition: all 0s ease;}

   // .tangram-suggestion-main{top: 315px;}

</style>

<!--内容开始-->

<div class="login_bg">

	<div class="login_top">

        <div class="login_wd">

            <div class="fl logo"><a href="<?php echo smarty_function_link(array('ctl'=>'web/shop/index'),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['site']->value['logo'];?>
" height="40"></a></div>

            <div class="fr linkA_box"><?php if (!$_smarty_tpl->tpl_vars['MEMBER']->value['uid']){?><a class="btn" href="<?php echo smarty_function_link(array('ctl'=>'web/passport/register'),$_smarty_tpl);?>
">注册</a><span class="xian"></span><a class="btn" href="<?php echo smarty_function_link(array('ctl'=>'web/passport/login','type'=>2),$_smarty_tpl);?>
">登录</a><?php }else{ ?>欢迎您，<a class="member" href="<?php echo smarty_function_link(array('ctl'=>'web/ucenter/index'),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['MEMBER']->value['nickname'];?>
</a><a class="btn" id="logout" href="javascript:void(0);">退出</a><?php }?></div>

            <div class="cl"></div>

        </div>

    </div>

    <div class="login_wd sy_serch_map">

    	<div class="sy_bt">请输入您的位置</div>

        <div class="sy_serch_box">

            <div class="fl int_box" id="r-result">

            	<div class="addrSelct fl"><?php echo $_smarty_tpl->tpl_vars['mcity']->value['city_name'];?>
<em class="ico"></em></div>

            	<input type="text" id="suggestId" placeholder="请输入你的收货地址（写字楼，小区，街道或者学校）">

                <div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none; margin-top: 10px;"></div>

                <script>

                    $(document).ready(function () {

                        $("#logout").click(function () {

                            var url = "<?php echo smarty_function_link(array('ctl'=>'web/passport/loginout'),$_smarty_tpl);?>
";

                            $.post(url, {}, function (ret) {

                                if (ret.error == 0) {

                                    layer.msg(ret.message);

                                    setTimeout(function () {

                                        window.location.href = "<?php echo smarty_function_link(array('ctl'=>'web/index'),$_smarty_tpl);?>
";

                                    }, '1000')

                                }

                            }, 'json')

                        })



                        $(".sy_serch_box .addrSelct").click(function () {

                            $(".addrSelct_map").hide();

                            if ($(".sy_serch_box .addrSelct_nr").css('display') == 'block') {

                                $(".sy_serch_box .addrSelct_nr").hide();

                            }

                            else {

                                $(".sy_serch_box .addrSelct_nr").show();

                            }

                        });

                    });

                </script>

                <div class="addrSelct_map" style="display:none;">

                    <!-- 左侧搜索结果列表 -->

                    <div class="locaNr_serNr fl" >

                        <ul id="locaNr_serUl" class="locaNr_serUl">



                        </ul>

                    </div>

                    <!-- 右侧地图 -->

                    <div class="locaNr_serMap fr" style=" width: 660px; height: 480px;" id="l-map"></div>

                    <div class="cl"></div>

                </div>

                <div class="addrSelct_nr">

                    <div class="addrSelct_top">

                        <P class="fl cai"><small>猜你在：</small><span class="maincl ml10"><?php echo $_smarty_tpl->tpl_vars['mcity']->value['city_name'];?>
</span></P>

                        <!--<div class="fl">直接搜索</div>

                        <div class="fl serch_box"><em class="ico"></em><input type="text" placeholder="城市名称、拼音"></div>-->

                    </div>

                    <div class="addrSelct_box">

                        <table width="100%" border="0" cellspacing="0" cellpadding="0">

                            <?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['city']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['items']->key;
?>

                            <tr>

                                <td width="96"><span class="bt"><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
</span></td>

                                <td>

                                    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>

                                    <a class="city_name" rel="<?php echo $_smarty_tpl->tpl_vars['item']->value['city_id'];?>
" href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['item']->value['city_name'];?>
</a>

                                    <?php } ?>

                                </td>

                            </tr>

                            <?php } ?>

                        </table>

                    </div>

                </div>

            </div>

            <div class="fr"><input type="button" id="search_btn" onKeyDown="javascript:enterPress(event);" class="btn" value=""></div>

            <div class="cl"></div>

            <script type="text/javascript">

                // 百度地图API功能

                var map = new BMap.Map("l-map");

                if(!Cookie.get('UxCity')){

                    var city = "<?php echo $_smarty_tpl->tpl_vars['mcity']->value['city_name'];?>
";

                    Cookie.set("UxCity", city);

                }else{                

                    var city = Cookie.get('UxCity');                

                }

                //$("#addrSelct_ser").onchange(function(){

                //    reset();

                //})

                var addr = null;

                var title = null;

                map.centerAndZoom(city, 15);   // 初始化地图,设置城市和地图级别。

                map.clearOverlays();

                //map.addOverlay(marker);              // 将标注添加到地图中

                //marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画

                function showPoint(e) {

                    var p = new BMap.Point(e.point.lng, e.point.lat);

                    var mk = new BMap.Marker(p);

                    map.clearOverlays();

                    //removeOverlay(overlay:Overlay);

                    map.addOverlay(mk);

                    //mk.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画

                    var geoc = new BMap.Geocoder();

                    geoc.getLocation(p, function (rs) {

                        var addComp = rs.addressComponents;

                        var Pois = rs.surroundingPois;

                        var business = rs.business;

                        if (Pois[0]) {

                            title = Pois[0].title;

                        } else {

                            title = business;

                        }

                        addr = addComp.province + addComp.city + addComp.district + addComp.street + addComp.streetNumber;

                        var opts = {

                            width: 260, // 信息窗口宽度

                            height: 120, // 信息窗口高度

                            enableMessage: false,

                        }

                        var infoWindow = new BMap.InfoWindow("<h3 style='font-size:18px;color:#000;width:260px;height:26px;line-height:26px;overflow:hidden;'>" + title + "</h3><div id='addr' style='height:48px; line-height:24px; color:#555; margin-top:5px;'>地址:" + addr + "</div>" + "\r\n<div style='height:30px; line-height:30px;  text-align:center; padding:0px 15px;background:#00CDDA; width:100px; margin:0px auto; cursor:pointer;'><a style='font-size:16px; color:#fff;' id='search_shop' href='javascript:void(0);'>查看附近商家</a></div>", opts);  // 创建信息窗口对象 

                        map.openInfoWindow(infoWindow, p); //开启信息窗口

                        setTimeout(function () {

                            $('#search_shop').on('click', function () {

                                setCookie(title, e.point.lng, e.point.lat);

                            });

                        }, 100);

                    });

                }

                map.enableScrollWheelZoom(true);

                map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件

                map.addEventListener("click", showPoint);



                $(document).on('click', '.jq_li', function () {

                    var addr = $(this).children('p').html();

                    var title = $(this).children('h3').html();

                    var myGeo = new BMap.Geocoder();

                    // 将地址解析结果显示在地图上,并调整地图视野

                    myGeo.getPoint(addr, function (point) {

                        if (point) {

                            map.clearOverlays();

                            map.centerAndZoom(point, 16);

                            var market = new BMap.Marker(point);

                            map.addOverlay(market);

                            var opts = {

                                width: 260, // 信息窗口宽度

                                height: 120, // 信息窗口高度

                                enableMessage: false,

                            }

                            var infoWindow = new BMap.InfoWindow("<h3 style='font-size:18px;color:#000;width:260px;height:26px;line-height:26px;overflow:hidden;'>" + title + "</h3><div id='addr' style='height:48px; line-height:24px; color:#555; margin-top:5px;'>" + addr + "</div>" + "\r\n<div style='height:30px; line-height:30px;  text-align:center; padding:0px 15px;background:#00CDDA; width:100px; margin:0px auto; cursor:pointer;'><a style='font-size:16px; color:#fff;' id='search_shop' href='javascript:void(0);'>查看附近商家</a></div>", opts);  // 创建信息窗口对象 

                            map.openInfoWindow(infoWindow, point); //开启信息窗口

                            setTimeout(function () {

                                $('#search_shop').on('click', function () {

                                    setCookie(title, point.lng, point.lat);

                                });

                            }, 100);

                        }

                    }, city);



                });



                function G(id) {

                    return document.getElementById(id);

                }

                var ac = new BMap.Autocomplete(//建立一个自动完成的对象

                        {"input": "suggestId"

                            , "location": map

                        });



                ac.addEventListener("onhighlight", function (e) {  //鼠标放在下拉列表上的事件

                    var str = "";

                    var _value = e.fromitem.value;

                    var value = "";

                    if (e.fromitem.index > -1) {

                        value = _value.province + _value.city + _value.district + _value.street + _value.business;

                    }

                    str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;



                    value = "";

                    if (e.toitem.index > -1) {

                        _value = e.toitem.value;

                        value = _value.province + _value.city + _value.district + _value.street + _value.business;

                    }

                    str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;

                    G("searchResultPanel").innerHTML = str;

                });



                var myValue;

                ac.addEventListener("onconfirm", function (e) {    //鼠标点击下拉列表后的事件

                    var _value = e.item.value;

                    myValue = _value.province + _value.city + _value.district + _value.street + _value.business;

                    G("searchResultPanel").innerHTML = "onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;

                    //setPoint();



                    setPlace(myValue);

                    $(".sy_serch_map").addClass("on");

                    $(".addrSelct_map").show();

                });



                function setPlace(key) {

                    map.clearOverlays();    //清除地图上所有覆盖物

                    var options = {

                        onSearchComplete: function (results) {

                            if (local.getStatus() == BMAP_STATUS_SUCCESS) {

                                // 判断状态是否正确      

                                var s = [];

                                for (var i = 0; i < results.getCurrentNumPois(); i++) {

                                    s.push("<li class='jq_li'><em></em><a class='locaNr_look' href='javascript:void(0);'>查看附近商家</a><h3>" + results.getPoi(i).title + "</h3><p class='jq_addr'>地址：" + results.getPoi(i).address + "</p></li>");

                                }

                                document.getElementById("locaNr_serUl").innerHTML = s.join("");

                            }

                        }

                    };

                    var local = new BMap.LocalSearch(map, options);

                    local.setPageCapacity(6);

                    local.search(key);

                }



                $("#search_btn").click(function () {

                    var addr_str = $("#suggestId").val();

                    if(addr_str){

                        //map.clearOverlays();

                        setTimeout(function () {

                            setPlace($("#suggestId").val());

                        }, 100)

                        $(".addrSelct_map").show();

                    }else{

                        layer.msg("请输入您的收货地址");return false;

                    }

                })



                function setPoint() {

                    map.clearOverlays();

                    var myGeo = new BMap.Geocoder(); //点击下拉列表将经纬度、地址存cookie

                    myGeo.getPoint(myValue, function (point) {

                        if (point) {

                            setCookie(myValue, point.lng, point.lat);

                        }

                    }, city);

                }



                function setCookie(addr, lng, lat) {

                    Cookie.set("addr", escape(addr), 86400 * 365, '/');

                    Cookie.set("lng", lng, 86400 * 365, '/');

                    Cookie.set("lat", lat, 86400 * 365, '/');

                    window.location.href = "<?php echo smarty_function_link(array('ctl'=>'web/shop/index'),$_smarty_tpl);?>
";

                }



            </script>

        </div>

    </div>

</div>

<script>

    $(document).ready(function () {

        $(".city_name").click(function () {

            var city_id = $(this).attr('rel');

            var city_name = $(this).html();

            Cookie.set("UxCityId", city_id, 86400 * 365, '/');

            Cookie.set("UxCity", city_name, 86400 * 365, '/');

            $(".addrSelct").html($(this).html() + '<em class="ico"></em>');

            $(".sy_serch_box .addrSelct_nr").hide();

            var map = new BMap.Map("l-map");

            map.centerAndZoom(city_name,15);                   // 初始化地图,设置城市和地图级别。

            var ac = new BMap.Autocomplete(    //建立一个自动完成的对象

                    {"input" : "suggestId"

                    ,"location" : map

                });

            })

        $("#suggestId").keyup(function(){

            $(".sy_serch_box .addrSelct_nr").hide();

        })

        

    })

</script>

<!--内容结束-->

<!--回到顶部-->

<div class="rightFloat">

    <div class="wx_box">

        <img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['site']->value['weixinqr'];?>
" width="86" height="86">

        <p class="maincl">下载客户端<a href="javascript:void(0);" class="close black9">×</a></p>

    </div>

    <div class="topBack"></div>

    <div style="width: 100px; text-align: center;"><?php echo smarty_modifier_qq($_smarty_tpl->tpl_vars['site']->value['kfqq']);?>
</div>

</div>

<script>

$(document).ready(function () {

        $(window).scroll(function () {

            if ($(window).scrollTop() > 100) {

                $(".rightFloat").show();

				$(".rightFloat").css("bottom","200px");

            } else {

                $(".rightFloat").hide();

            }

			

        });

		$(".topBack").click(function () {

            $("html,body").animate({scrollTop: 0}, 200);

        });

});

</script>

<!--回到顶部end-->

<?php echo $_smarty_tpl->getSubTemplate ("web/block/foot.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<?php }} ?>