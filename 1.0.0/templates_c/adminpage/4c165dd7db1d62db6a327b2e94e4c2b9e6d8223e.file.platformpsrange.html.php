<?php /* Smarty version Smarty-3.1.10, created on 2018-01-31 23:19:13
         compiled from "D:\UPUPW_K2.1\htdocs\wmr87\templates\adminpage\area\platformpsrange.html" */ ?>
<?php /*%%SmartyHeaderCode:54835a71de7193eee6-26200215%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4c165dd7db1d62db6a327b2e94e4c2b9e6d8223e' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\adminpage\\area\\platformpsrange.html',
      1 => 1499823676,
      2 => 'file',
    ),
    '1956299623e26c37e8fd2d283464ea2ebcb0eefc' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\adminpage\\public\\admin.html',
      1 => 1505877233,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '54835a71de7193eee6-26200215',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tempdir' => 0,
    'siteurl' => 0,
    'is_static' => 0,
    'adminlogo' => 0,
    'admininfo' => 0,
    'companyname' => 0,
    'website' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_5a71de724b5181_56628172',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a71de724b5181_56628172')) {function content_5a71de724b5181_56628172($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\lib\\Smarty\\libs\\plugins\\modifier.date_format.php';
?>﻿ <html xmlns="http://www.w3.org/1999/xhtml"><head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<meta http-equiv="Content-Language" content="zh-CN"> 
<meta content="all" name="robots"> 
<meta name="description" content=""> 
<meta content="" name="keywords"> 
<title>后台管理中心 </title>  
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/css/admin1.css"> 
 <script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/js/jquery.js" type="text/javascript" language="javascript"></script>
 <script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/js/public.js" type="text/javascript" language="javascript"></script>
 <script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/js/allj.js" type="text/javascript" language="javascript"></script>
 <script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/js/artdialog/artDialog.js?skin=blue"></script>
 <script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/js/template.min.js" type="text/javascript" language="javascript"></script>

<script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/js/artdialog/plugins/iframeTools.js"></script>
 
<script>
	var menu = null;
	var siteurl = "<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
";
	var is_static ="<?php echo $_smarty_tpl->tpl_vars['is_static']->value;?>
";
	if(screen.width > 1359){
		
		$('.newtop').css('width',screen.width);
		$('.newmain').css('width',screen.width);
		$('.newfoot').css('width',screen.width);
	}  
	
</script> 
</head> 
<body> 
<div id="cat_zhe" class="cart_zhe" style="display:none;"></div>
<!--<div id="cat_tj" class="cart_out_cat" style="display:none;"> 数据提交中..</div>-->
<div class="newtop">
	  <div class="newadddiv">
	  <div class="newlogo">
	  	   <div class="imglogo"><a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
" target="_blank">
                          <?php if (empty($_smarty_tpl->tpl_vars['adminlogo']->value)){?>
                          <img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/images/admin/logo.png" style="height: 51px; width: 267px;">
                          <?php }else{ ?> 
                          <img src="<?php echo $_smarty_tpl->tpl_vars['adminlogo']->value;?>
" style="height: 51px; width: 267px;">
                          <?php }?>
                      </a></div>
	  </div>
	  <div class="newtopnav">
	  	 <ul>
	  	  <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tempdir']->value)."/public/admin_module.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
 
	  	 	<ul>
	  	
	  </div>
	</div>
</div> 
<div style="clear:both;"></div>
<div class="newmain">
	<!-- 提示导航-->
   <div class="top_nav">
	    <div class="nav2 datainfo">
	    	<?php echo smarty_modifier_date_format(time(),"%Y-%m-%d");?>
  
	    </div>
	    <div class="nav2 positioninfo" id="positionname2">
	    	网站首页
	    </div>
	    <!-- <div class="nav2 orderinfo">
	    	您有今天有0 个订单待审核
	    </div> -->
   </div>
   <!-- 主内容区-->
   <div class="newmain_all">
   	 <!-- 主内左区-->
   	 <div class="left_content">
   	 	   <!-- 主内左区用户信息-->
   	 	   <div class="userinfo">
   	 	   	   <div class="user_area">
   	 	   	   	      <div class="user_name">
   	 	   	   	      	<?php echo $_smarty_tpl->tpl_vars['admininfo']->value['username'];?>

   	 	   	   	      </div>
   	 	   	   	      <div class="content_url">
   	 	   	   	      	 <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/member/adminloginout"),$_smarty_tpl);?>
" class="out">退出</a> 
   	 	   	   	      	 <a onclick="modifypwd();" href="#">修改密码</a>
   	 	   	   	      </div>
   	 	   	  </div>
   	 	   	  <div class="now_name" id="nowactioninfo">
   	 	   	    	网站首页
   	 	   	    </div>
   	 	   </div>
   	 	   <!-- 主内左区导航条-->
   	 	    <div class="left_nav">
   	 	    	  <ul> 
   	 	    	  	
   	 	    	  	
   	 	    	  	 <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tempdir']->value)."/public/admin_menu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

   	 	    	 
   	 	    	     <li style="text-align:center;"><a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
" style="color:#0076cf;" target="_blank">返回网站首页</a></li>
   	 	    	  </ul>
   	 	    </div>
   	 	    <div class="left_navend">
   	 	    </div>
   	 	    <!-- 主内左区天气预报-->
   	 	    <div class="weather" id="weatherinfo" style="display:none;">
   	 	    	 <div class="todayweacher">
   	 	    	      <div class="weacher_left">
   	 	    	      	 <div id="wtoday_img"> </div>
   	 	    	      	 <div><span id="wcity" style="padding-right:5px;"></span><span id="wqihou"></span></div>
   	 	    	      </div>
   	 	    	      <div class="weacher_right" id="wwendu">
   	 	    	      	 
   	 	    	      </div>	 
   	 	    	 </div>
   	 	    	 <div style="clear:both;">
   	 	    	 	   <div class="tom">
   	 	    	 	   	    <div id="tom_1" class="tom_img"></div>
   	 	    	 	   	    <div class="tom_wendu" id="tom_day"></div>
   	 	    	 	   	    <div class="tom_wendu" id="tom_wendu"></div>
   	 	    	 	   	
   	 	    	 	   	</div>
   	 	    	 	   <div class="tom">
   	 	    	 	   	    <div id="tom_tom" class="tom_img"></div>
   	 	    	 	   	    <div class="tom_wendu" id="tom_tday"></div>
   	 	    	 	   	    <div class="tom_wendu" id="tom_twendu"></div>
   	 	    	 	   	</div>
   	 	    	 </div>
   	 	    </div>
   	 	     
   	  </div>
   	  
 
 
  
 
 
 <div class="right_content">
	<div class="show_content_m">
   	        	 <div class="show_content_m_ti">
   	        	 	   <div class="showtop_t" id="positionname">平台地图配送范围</div>
   	        	 </div>
   	        	 <div class="show_content_m_t2">
   	        	 	
   	        	 	
 <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/css/ghnewmap.css"> 
 <script src="<?php echo $_smarty_tpl->tpl_vars['map_comment_link']->value;?>
webapi.amap.com/maps?v=1.3&key=<?php echo $_smarty_tpl->tpl_vars['map_javascript_key']->value;?>
&plugin=AMap.MouseTool,AMap.PolyEditor"></script>
  <div style="width:auto;overflow-x:hidden;overflow-y:auto"> 
          <div class="tags">
           
          <div   style="position:relative;min-height:658px;">
   
 
    <input type="hidden" value="" name="lnglatString" id="lnglatString"  />
   
   
   	<div class="searchkuang" style="position:absolute;z-index:9999999; left:100px;">
 		<input type="hidden"  name="cityname" id="cityname" value="<?php echo $_smarty_tpl->tpl_vars['cityname']->value;?>
">
		 <div> 
		 <input type="text" id="searchvalue" name="searchvalue" value="录入搜索地址" placeholder="录入搜索地址" style="float:left;width:200px;line-height:25px;height:25px;">
		 <a href="javascript:void(0);" id="lnglat" class="mapBtns" onclick="dosearchcity();">提交搜索</a>  
		 <a href="javascript:void(0);" id="SUBlnglat" class="mapBtns"  style="background: #00B091;"  onclick="SUBlnglat();">提交保存</a> 
		 </div>
		 <div class="showsearch" style="background-color:#fff;" >
		   <ul id="backdatali">  
		   	</ul>	
		 	
		 </div>
	</div> 
	
	<div class="map-content">
    <div class="map-content-des">
      <span>配送区域</span>
      <a class=" btn-addLarge" style="color:#fff;" id="addLarge" href="javascript:void(0);" >添加配送区</a>
    </div>
	
	<div id="areaPsRange">
		
	</div>
   
  </div>

	
	
	
	<div id="SearchAddmap" style="  width:100%; position:absolute;top:0px; height:100%;">
		
		
		
	</div>
	</div>
	</div>
	</div>

<script type="text/javascript">


var colorarr = [];
var color1 = [];color1['borderColor'] = 'rgb(66, 127, 237)';color1['backgroundColor'] = 'rgba(66, 127, 237, 0.498039)';colorarr.push(color1);
var color2 = [];color2['borderColor'] = 'rgb(255, 70, 23)';color2['backgroundColor'] = 'rgba(255, 70, 23, 0.498039)';colorarr.push(color2);
var color3 = [];color3['borderColor'] = 'rgb(71, 195, 112)';color3['backgroundColor'] = 'rgba(71, 195, 112, 0.498039)';colorarr.push(color3);
var color4 = [];color4['borderColor'] = 'rgb(88, 201, 205)';color4['backgroundColor'] = 'rgba(88, 201, 205, 0.498039)';colorarr.push(color4);
var color5 = [];color5['borderColor'] = 'rgb(233, 193, 29)';color5['backgroundColor'] = 'rgba(233, 193, 29, 0.498039)';colorarr.push(color5);
var color6 = [];color6['borderColor'] = 'rgb(79, 220, 51)';color6['backgroundColor'] = 'rgba(79, 220, 51, 0.498039)';colorarr.push(color6);
var color7 = [];color7['borderColor'] = 'rgb(255, 127, 0)';color7['backgroundColor'] = 'rgba(255, 127, 0, 0.498039)';colorarr.push(color7);
var color8 = [];color8['borderColor'] = 'rgb(123, 71, 223)';color8['backgroundColor'] = 'rgba(123, 71, 223, 0.498039)';colorarr.push(color8);
var color9 = [];color9['borderColor'] = 'rgb(223, 71, 182)';color9['backgroundColor'] = 'rgba(223, 71, 182, 0.498039)';colorarr.push(color9);
var color10 = [];color10['borderColor'] = 'rgb(66, 127, 237)';color10['backgroundColor'] = 'rgba(66, 127, 237, 0.498039)';colorarr.push(color10);
var color11 = [];color11['borderColor'] = 'rgb(255, 70, 23)';color11['backgroundColor'] = 'rgba(255, 70, 23, 0.498039)';colorarr.push(color11);
var color12 = [];color12['borderColor'] = ' rgb(71, 195, 112)';color12['backgroundColor'] = ' rgba(71, 195, 112, 0.498039);';colorarr.push(color12); 

var arrr = new Array(); 
         //初始化地图对象，加载地图
    ////初始化加载地图时，若center及level属性缺省，地图默认显示用户当前城市范围
    var editorTool,marker, map = new AMap.Map('SearchAddmap', {
         resizeEnable: true,
         zoom:10,
     });	
	 map.setCity('<?php echo $_smarty_tpl->tpl_vars['cityname']->value;?>
');
	 var mouseTool = new AMap.MouseTool(map);
	$(function(){ 
		// mouseTool.polygon();  
		 htmlpsrange();
		 huamapPlo();
	}); 
	  AMap.plugin(['AMap.ToolBar','AMap.Scale','AMap.OverView','AMap.MapType'],function(){
            map.addControl(new AMap.ToolBar());
            map.addControl(new AMap.Scale());
            map.addControl(new AMap.MapType());
			map.addControl(new AMap.OverView({isOpen:false}));
    })
	 
$("#addLarge").bind('click',function(){
	 
	var lastkey = $('.map-content-delete:last').attr('click_key');
 	if( lastkey < 0 || lastkey == undefined ){
		var addkey = 0;
	}else{
		var addkey = Number(lastkey)+1;
	}
	if( arrr.length > 0 ){
		if( $('.flex-'+addkey).find('input.pathinput').val() == '' ||  $('.flex-'+addkey).find('input.pathinput').val() == undefined  ){
			diaerror('请先在地图中添加配送区域'+addkey);
			return false;
		}
	}
	 
  
		var psrangeHtml = '';
		if( addkey <= 0 ){
			psrangeHtml +=' <ul id="listLarge" class="map-content-list" style="height:auto;  display:inline-block; *display:inline; *zoom:1;" >     ';
		}
 				  psrangeHtml +=' <li ubt-click="'+(addkey+1)+'" ubt-ext="select"> ';
				  psrangeHtml +=' <div class="flex-'+(addkey+1)+'"> ';
				  psrangeHtml +=' 	<span class="map-zone-block color" style="border-color: '+colorarr[addkey]['borderColor']+'; background-color: '+colorarr[addkey]['backgroundColor']+';"></span> ';
				  psrangeHtml +=' <span class="li-name map-middle">区域<span class="li-index">'+(addkey+1)+'</span>&nbsp;&nbsp;&nbsp;（<span class="areainput">0</span><span>平方米</span>）</span> ';
			  	  psrangeHtml +=' <span click_key="'+addkey+'" class="map-content-delete delete" style="cursor:pointer;">删除</span> ';
			  	  psrangeHtml +=' <input type="hidden" class="pathinput" value="" />';
 				  psrangeHtml +=' </div> ';
				  psrangeHtml +=' <div>  ';
				  psrangeHtml +=' </div> ';
				  psrangeHtml +=' </li>  ';
				 
				  
		if( addkey <= 0 ){
			psrangeHtml +=' </ul> ';
			$("#areaPsRange").html(psrangeHtml);
		}else{
			$("#listLarge").append(psrangeHtml);
		}
		
		mouseTool.polygon();  
			
	 AMap.event.addListener(mouseTool, "draw", function callback(e) {
 	  
		 
            var eObject = e.obj.G.path;//obj属性就是鼠标事件完成所绘制的覆盖物对象。
			if(eObject.length > 0){
				 
				 var addLngLat = [];
				
  				 for(var i=0;i<eObject.length;i++){
 					var lnglat = [];
					lnglat.push(eObject[i].lng);
					lnglat.push(eObject[i].lat);
  					addLngLat.push(lnglat);
				}
			 
				console.log(addLngLat);
				var  editor_polygon_addkey = new AMap.Polygon({
					path:addLngLat,//设置多边形边界路径
					strokeColor: ""+colorarr[addkey]['borderColor']+"", //线颜色
					strokeOpacity: 1, //线透明度
					strokeWeight: 3,    //线宽
					fillColor: ""+colorarr[addkey]['borderColor']+"", //填充色
					fillOpacity: 0.35,//填充透明度
					strokeStyle:'solid',  //dashed  
				});
				 
				  editor_polygon_addkey.setMap(map);
				
				
				 arrr.push(editor_polygon_addkey);
	 
 				  var obj =  arrr[addkey]; 
				
				  var editorPolygonEditor_addkey = new AMap.PolyEditor(map, editor_polygon_addkey);
				  var getPath = editor_polygon_addkey.getPath(); //获取多边形轮廓线节点数组
						var getArea = editor_polygon_addkey.getArea(); //获取多边形的面积（单位：平方米）
						var patharr = [];
						if( getPath.length > 0 ){
							for(i=0;i<getPath.length;i++){
								patharr.push('['+getPath[i]+']');
							}
						}
						var newpathstring = '['+patharr.join(',')+']';
						$('.flex-'+(addkey+1)).find('input.pathinput').val(newpathstring);
						$('.flex-'+(addkey+1)).find('span.areainput').text(getArea);
						var click_flag_addkey = true;
				  AMap.event.addListener(editor_polygon_addkey, "click", function callback(e) { //鼠标左键单击事件
						if( click_flag_addkey == true ){
							editorPolygonEditor_addkey.open();
							click_flag_addkey = false;
						}else{
							editorPolygonEditor_addkey.close();
							click_flag_addkey =true;
						} 
				 });  
				 AMap.event.addListener(editor_polygon_addkey, "dblclick", function callback(e) {//鼠标左键双击事件 
						if( click_flag_addkey == true ){
							editorPolygonEditor_addkey.open();
							click_flag_addkey = false;
						}else{
							editorPolygonEditor_addkey.close();
							click_flag_addkey =true;
						}  
				 });  
				 
				 AMap.event.addListener(editor_polygon_addkey, "change", function callback(e) { //属性发生变化时
						var getPath = editor_polygon_addkey.getPath(); //获取多边形轮廓线节点数组
						var getArea = editor_polygon_addkey.getArea(); //获取多边形的面积（单位：平方米）
						var patharr = [];
						if( getPath.length > 0 ){
							for(i=0;i<getPath.length;i++){
								patharr.push('['+getPath[i]+']');
							}
						}
						var newpathstring = '['+patharr.join(',')+']';
						$('.flex-'+(addkey+1)).find('input.pathinput').val(newpathstring);
						$('.flex-'+(addkey+1)).find('span.areainput').text(getArea);
					 
				 });  
			
 				mouseTool.close(true);
				
			}
     }); 
 
				
	bindhoverarea();
	
});
function htmlpsrange(){

		var psrangeHtml = '';
		<?php if (!empty($_smarty_tpl->tpl_vars['arealnglatarr']->value)){?>
	
		 psrangeHtml +=' <ul id="listLarge" class="map-content-list" style="height:auto;" >    ';
			 <?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_smarty_tpl->tpl_vars['mykey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['arealnglatarr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
 $_smarty_tpl->tpl_vars['mykey']->value = $_smarty_tpl->tpl_vars['items']->key;
?> 
				  psrangeHtml +=' <li ubt-click="<?php echo $_smarty_tpl->tpl_vars['mykey']->value+1;?>
" ubt-ext="select"> ';
				  psrangeHtml +=' <div class="flex-<?php echo $_smarty_tpl->tpl_vars['mykey']->value+1;?>
"> ';
				  psrangeHtml +=' 	<span class="map-zone-block color" style="border-color: '+colorarr[<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
]['borderColor']+'; background-color: '+colorarr[<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
]['backgroundColor']+';"></span> ';
				  psrangeHtml +=' <span class="li-name map-middle">区域<span class="li-index"><?php echo $_smarty_tpl->tpl_vars['mykey']->value+1;?>
</span>&nbsp;&nbsp;&nbsp;（<span class="areainput">0</span><span>平方米</span>）</span> ';
			  	  psrangeHtml +=' <span click_key="<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
" class="map-content-delete delete" style="cursor:pointer;">删除</span> ';
			  	  psrangeHtml +=' <input type="hidden" class="pathinput" value="<?php echo $_smarty_tpl->tpl_vars['items']->value;?>
" />';
 				  psrangeHtml +=' </div> ';
				  psrangeHtml +=' <div>  ';
				  psrangeHtml +=' </div> ';
				  psrangeHtml +=' </li>  ';
			<?php } ?>  
		psrangeHtml +=' </ul> ';
	<?php }else{ ?> 
		psrangeHtml +=' <p class="map-none-area map-none-area-large" style="display:block ; text-align:center;margin-top:20px;">暂无配送区</p> ';
	<?php }?>
	$("#areaPsRange").html(psrangeHtml);
	is_hasArea();
	 bindhoverarea();
	
	
}	
	


 
function makePolygon(){
	var PolyEditorArr = new Array();
	for(var w=0;w<arrr.length;w++){
		var editorPolygonEditor = new AMap.PolyEditor(map, arrr[i]);
	    PolyEditorArr.push(editorPolygonEditor);
	}
 console.log(PolyEditorArr);


	map.clearMap();
	// console.log(arrr);
	var c = 0;
	 for(var m=0;m<arrr.length;m++){
 	     var obj =  arrr[m];
	     obj.setMap(map); 
		 
 		 
				var getPath = obj.getPath(); //获取多边形轮廓线节点数组
 				var getArea = obj.getArea(); //获取多边形的面积（单位：平方米）

				var patharr = [];
				if( getPath.length > 0 ){
					for(var j=0;j<getPath.length;j++){
						patharr.push('['+getPath[j]+']');
					}
				} 
				var newpathstring = '['+patharr.join(',')+']'; 
			//	console.log(m);
				var mmmm = m+1;
				$('.flex-'+mmmm).find('input.pathinput').val(newpathstring);
				$('.flex-'+mmmm).find('span.areainput').text(getArea);
	 
 		  AMap.event.addListener(obj, "click", function callback(e){ //鼠标左键单击事件   
					var editorPolygonEditor = new AMap.PolyEditor(map, obj);
					editorPolygonEditor.open(); 
					
		 },m);  
		 AMap.event.addListener(obj, "dblclick", function callback(e) {//鼠标左键双击事件 
 					var editorPolygonEditor = new AMap.PolyEditor(map, obj);
					editorPolygonEditor.close();
				 
		 },m); 
		 AMap.event.addListener(obj, "change", function callback(e) { //属性发生变化时 
 				var getPath = obj.getPath(); //获取多边形轮廓线节点数组
 				var getArea = obj.getArea(); //获取多边形的面积（单位：平方米）

				var patharr = [];
				if( getPath.length > 0 ){
					for(var j=0;j<getPath.length;j++){
						patharr.push('['+getPath[j]+']');
					}
				} 
				var newpathstring = '['+patharr.join(',')+']'; 
				$('.flex-'+m).find('input.pathinput').val(newpathstring);
				$('.flex-'+m).find('span.areainput').text(getArea);
 			 
		 },m); 
			 
		 
	}	 
		 
}	
	
function huamapPlo(){

	<?php if (!empty($_smarty_tpl->tpl_vars['arealnglatarr']->value)){?>
 	 
	 <?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_smarty_tpl->tpl_vars['mykey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['arealnglatarr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
 $_smarty_tpl->tpl_vars['mykey']->value = $_smarty_tpl->tpl_vars['items']->key;
?>
		 var click_flag_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
 = true;
		 var  editor_polygon_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
 = new AMap.Polygon({
					path:<?php echo (($tmp = @$_smarty_tpl->tpl_vars['items']->value)===null||$tmp==='' ? 0 : $tmp);?>
,//设置多边形边界路径
					strokeColor: ""+colorarr[<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
]['borderColor']+"", //线颜色
					strokeOpacity: 1, //线透明度
					strokeWeight: 3,    //线宽
					fillColor: ""+colorarr[<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
]['borderColor']+"", //填充色
					fillOpacity: 0.35,//填充透明度
					strokeStyle:'solid',  //dashed  
				});
				
				 arrr.push(editor_polygon_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
);
	 
				  editor_polygon_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
.setMap(map);
				  var obj =  arrr[<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
]; 
				
		  var editorPolygonEditor_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
 = new AMap.PolyEditor(map, editor_polygon_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
);
 		  var getArea = editor_polygon_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
.getArea(); //获取多边形的面积（单位：平方米）
		  $('.flex-'+<?php echo $_smarty_tpl->tpl_vars['mykey']->value+1;?>
).find('span.areainput').text(getArea);
 		  AMap.event.addListener(editor_polygon_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
, "click", function callback(e) { //鼠标左键单击事件
 				if( click_flag_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
 == true ){
					editorPolygonEditor_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
.open();
					click_flag_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
 = false;
				}else{
					editorPolygonEditor_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
.close();
					click_flag_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
 =true;
				} 
		 });  
		 AMap.event.addListener(editor_polygon_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
, "dblclick", function callback(e) {//鼠标左键双击事件 
				if( click_flag_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
 == true ){
					editorPolygonEditor_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
.open();
					click_flag_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
 = false;
				}else{
					editorPolygonEditor_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
.close();
					click_flag_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
 =true;
				}  
		 });  
		 AMap.event.addListener(editor_polygon_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
, "mousedown", function callback(e) {//鼠标按下
 		 }); 
		 AMap.event.addListener(editor_polygon_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
, "change", function callback(e) { //属性发生变化时
				var getPath = editor_polygon_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
.getPath(); //获取多边形轮廓线节点数组
 				var getArea = editor_polygon_<?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
.getArea(); //获取多边形的面积（单位：平方米）
				var patharr = [];
				if( getPath.length > 0 ){
					for(i=0;i<getPath.length;i++){
						patharr.push('['+getPath[i]+']');
					}
				}
				var newpathstring = '['+patharr.join(',')+']';
				$('.flex-'+<?php echo $_smarty_tpl->tpl_vars['mykey']->value+1;?>
).find('input.pathinput').val(newpathstring);
				$('.flex-'+<?php echo $_smarty_tpl->tpl_vars['mykey']->value+1;?>
).find('span.areainput').text(getArea);
 			 
		 });  
			
 	 <?php } ?>
	//  makePolygon();
	//  map.setFitView();
	
     bindhoverarea();
	 
 	 
	<?php }?>

}	
	
	
	 
//在输入框中 输入地址 在相似城市区域内查找 内容
function dosearchcity(){
	//searchvalue" value="录入搜索地址" placeholder="录入搜索地址"
	 $('.showsearch').show();
	   var searchvalue = $('#searchvalue').val();
	   var cityname = $('#cityname').val();
	  if($('#searchvalue').val() ==  $('#searchvalue').attr('placeholder')){
	    $('#backdatali').html('<li>请录入查询条件</li>');
	    return false;
	  }
	  if(searchvalue == ''){
	  	$('#backdatali').html('<li>请录入查询条件</li>');
	  	return false;
	  }   
	  
	   $.getScript('<?php echo $_smarty_tpl->tpl_vars['map_comment_link']->value;?>
restapi.amap.com/v3/place/text?&keywords='+searchvalue+'&output=json&city='+cityname+'&page=1&offset=10&key=<?php echo $_smarty_tpl->tpl_vars['map_webservice_key']->value;?>
&extensions=all&callback=showaddresslist'); 
	  
}

	

function showaddresslist(datas){
 	if( datas.status == 1   && datas.info == 'OK'   ){
		var  resultobj = datas.pois;
        $('#backdatali').html('');
         $.each(resultobj, function(i,val){  
         	 $('#backdatali').append('<li address="'+val.name+'"   lnglat="'+val.location+'" >'+val.name+'</li>'); 
         }); 
	}else{
         	$('#backdatali').html('<li>未查找到相关数组，请更换关键词搜索...</li>');
    }
}


function bindhoverarea(){
	//鼠标移上显示删除按钮
	$("#listLarge li").hover(function(){
		$(this).find('.map-content-delete').css('visibility','visible');
	},function(){
		$(this).find('.map-content-delete').css('visibility','hidden');
	});
	//点击删除某一块区域
	 $("#listLarge li .map-content-delete").bind('click',function(){
 				var key = $(this).attr('click_key');
				$(this).parent().parent().remove();
			  
				 var mapobj =  arrr[key];
				 console.log(mapobj);
				 mapobj.setMap(null);

				var newarr = new Array(); 
				if( arrr.length > 0 ){
					for( var i=0;i<arrr.length;i++ ){
						if( i != key ){
							newarr.push(arrr[i]);
						}
					}
					arrr = newarr;  
				}else{
					arrr = new Array();
				}
			
			is_hasArea();
		  
 	});
}
//判断是否有配送区域
function is_hasArea(){
	if( $('#listLarge li').length == 0 ){
		var psrangeHtml =' <p class="map-none-area map-none-area-large" style="display:block ; text-align:center;margin-top:20px;">暂无配送区</p> ';
		$("#areaPsRange").html(psrangeHtml);
		$(".map-none-tishi").remove();
	}else{
		if( $('.map-none-tishi').html() == '' ||  $('.map-none-tishi').html() == undefined ){
			var psrangeHtml ='<p class="map-none-area map-none-area-large map-none-tishi" style="display:block ;color:#ff6f00; text-align:left;text-indent:2rem;margin-top:20px;padding:0px 6px;">添加配送区提示：点击添加配送区之后，鼠标在地图上单击开始绘制多边形，鼠标左键双击或右键单击结束当前多边形的绘制。</p> ';
			$("#areaPsRange").append(psrangeHtml);
		}
	}
}
  
//搜索地址
$('.showsearch li').live("click", function() {  
		$('.showsearch').toggle();
		 var clicklnglat = $(this).attr('lnglat');
		 var address = $(this).attr('address');
		 var array = clicklnglat.split(",");
			var nums = [ ];
			for (var i=0 ; i< array.length ; i++)
			{
				nums.push(array[i]);
			}
			var getlng = nums[0];
			var getlat = nums[1];
		 $("#searchvalue").val(address);
	     $(this).addClass('on').siblings().removeClass('on'); 
	      map.setZoomAndCenter(16, array);
  });
	  $('#searchvalue').live("click",function(){
		if($(this).val() ==  $(this).attr('placeholder')){
			$(this).val('');
		} 
	  });
	  $("#searchvalue").focus(function(){
		  $('.showsearch').toggle();
		});
//提交保存
	function SUBlnglat(){  
  		var obj = $('#areaPsRange li input.pathinput');
		var pathStringData = '';
		$(obj).each(function(){
			if( $(this).val() != '' && $(this).val() != undefined ){
				if( pathStringData == ''){
					pathStringData = $(this).val();
				}else{
					pathStringData += '#'+$(this).val();
				}
			}
 		 }); 
		var templingk = '<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/index.php?ctrl=adminpage&action=area&module=sublnglatpsrange&random=@random@&datatype=json'; 
		templingk = templingk.replace('@random@', 1+Math.round(Math.random()*1000));
		var tempc = ajaxback(templingk,{'waimai_psrange':pathStringData}); 
		if(tempc.flag ==false){
			diasucces("保存成功！",'');
			 location.reload(); 
		}else{
			diaerror(tempc.content);
		}
		 
	 } 
	function ajaxback(url,info)
{
	var backmessage = {'flag':true,'content':''};
	$.ajax({
       type: 'POST',
       async:false,
       url: url.replace('@random@', 1+Math.round(Math.random()*1000)),
       data: info,
      dataType: 'json',success: function(content) { 
      	if(content.error == false)
      	{
      	 
      	   backmessage['flag'] = false;
      	   backmessage['content'] = content.msg;
      	  // alert(backmessage['flag']);
      	}else{
      		if(content.error == true)
      	  { 
      	  	backmessage['content'] = content.msg;
      	  }else{
      	   backmessage['content'] = content;
      	  }
        }
      	
		  },
      error: function(content) { 
      backmessage['content'] = '数据获取失败';
	   }
   });  
   return backmessage;
}
</script>   
 
 
 
 
 
 

   	        	 	
               <div class="show_content_m_t3">
   	        	 </div>
   	        	 
   	       </div>
   	       <!-- show_content_m结束-->


   	  </div>
   	  <!-- right_content 结束-->
   	  
   </div>
   <!-- newmain_all 结束-->
</div>	
	
<!--newmain 结束-->
















<div style="clear:both;"></div>
<div class="newfoot">
	
	  版权所有@<?php echo $_smarty_tpl->tpl_vars['companyname']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['website']->value;?>

</div>	
<script>
$(function(){ 
 $('.show_page a').wrap('<li></li>');
 $('.show_page').find('.current').eq(0).parent().css({'background':'#f60'}); 
});
   function limitalert(){
		diaerror("您暂无权限设置,如有疑问请联系QQ：375952873  Tel：18538930577");
	}
</script>
</body>
</html>





<?php }} ?>