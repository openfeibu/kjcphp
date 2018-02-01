<?php /* Smarty version Smarty-3.1.10, created on 2018-01-31 23:12:03
         compiled from "D:\UPUPW_K2.1\htdocs\wmr87\templates\adminpage\system\index.html" */ ?>
<?php /*%%SmartyHeaderCode:73255a71dcc30b91d3-22467773%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f83f8d80346bccee0c46943596d7e27f35c5e7f8' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\adminpage\\system\\index.html',
      1 => 1504675968,
      2 => 'file',
    ),
    '1956299623e26c37e8fd2d283464ea2ebcb0eefc' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\adminpage\\public\\admin.html',
      1 => 1505877233,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '73255a71dcc30b91d3-22467773',
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
  'unifunc' => 'content_5a71dcc3947bb9_60338974',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a71dcc3947bb9_60338974')) {function content_5a71dcc3947bb9_60338974($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\lib\\Smarty\\libs\\plugins\\modifier.date_format.php';
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

 <link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/css/index.css">
 <script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/js/kindeditor/kindeditor.js" type="text/javascript" language="javascript"></script>
 <script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/js/datepicker/WdatePicker.js" type="text/javascript" language="javascript"></script>
 
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
   	        	 	   <div class="showtop_t" id="positionname">网站信息</div>
   	        	 </div>
   	        	 <div class="show_content_m_t2">
   	        	 	
   	        	 	
 <style>
 .newfoot{
    position: absolute!important;
    bottom: 0!important;
 }
 
 
 </style>
 <div class="homeRightCon">
     <div class="homeRightTop">
         <ul>
             <li class="hoTopbg01">
                 <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/order/module/ordertoday"),$_smarty_tpl);?>
">
                     <i class="icon_ddks"></i>
                     <span>订单快速处理系统</span>
                 </a>
             </li>
             <li class="hoTopbg02">
                 <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/order/module/adminfastfoods"),$_smarty_tpl);?>
">
                     <i class="icon_dkxd"></i>
                     <span>客服代客下单系统</span>
                 </a>
             </li>
             <li class="hoTopbg03">
                 <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/order/module/shopjsadd"),$_smarty_tpl);?>
">
                     <i class="icon_sjjs"></i>
                     <span>商家结算系统</span>
                 </a>
             </li>
             <li class="hoTopbg04">
			 <?php ob_start();?><?php echo Mysite::$app->config['psbopen'];?>
<?php $_tmp1=ob_get_clean();?><?php if ($_tmp1==1){?>
                 <a target="_blank" href="<?php echo Mysite::$app->config['autopsblink'];?>
">
		     <?php }else{ ?>
				 <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/psuser/module/psymap"),$_smarty_tpl);?>
">
		     <?php }?>
                     <i class="icon_psydd"></i>
                     <span>配送员调度管理系统</span>
                 </a>
             </li>
             <li class="hoTopbg05">
                 <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/shop/module/goodslibrary"),$_smarty_tpl);?>
">
                     <i class="icon_spkgl"></i>
                     <span>商品库管理系统</span>
                 </a>
             </li>
         </ul>
     </div>
     <div class="homeRightBot">
         <div class="homeRightBox">
             <div class="homeRightTit hoRiTit_bg01">
                 <!--<i class="icon_edit"></i>-->
                 <i class="icon_data" style="width:60px;height:60px;"></i>
                 <h2>系统信息</h2>
             </div>


             <div class="homeRightEdit">
                 <table>
                     <tbody>
                     <tr>
                         <th>服务器当前时间：</th>
                         <td><?php echo smarty_modifier_date_format(time(),"%Y-%m-%d %H:%M:%S");?>
</td>
                     </tr>
                     <tr class="trbg">
                         <th>PHP版本：</th>
                         <td><?php echo phpversion();?>
</td>
                     </tr>
                     <tr>
                         <th>官方网站地址：</th>
                         <td><?php echo $_smarty_tpl->tpl_vars['website']->value;?>
</td> 
                     </tr>
                     <tr class="trbg">
                         <th>版权所有：</th>
                         <td><?php echo $_smarty_tpl->tpl_vars['companyname']->value;?>
</td>
                     </tr>
                     </tbody>
                 </table>
             </div>
         </div>
         <div class="homeRightBox">
             <div class="homeRightTit hoRiTit_bg02">
                    <!--<i class="icon_data"></i>-->
                   <i class="icon_edit" style="width:60px;heith:60px;"></i>
                    <h2>数据统计</h2>
                  </div> 


             <div class="homeRightData">
                 <ul>
                     <li class="font_red"><h3><?php echo $_smarty_tpl->tpl_vars['tjdata']->value['dayallorder'];?>
</h3><span>今日总订单</span></li>
                     <li class="font_org"><h3><?php echo $_smarty_tpl->tpl_vars['tjdata']->value['dayworder'];?>
</h3><span>今日待审核订单</span></li>
                     <li class="font_green"><h3><?php echo $_smarty_tpl->tpl_vars['tjdata']->value['dayporder'];?>
</h3><span>今日已审核订单</span></li>
                     <li><h3><?php echo $_smarty_tpl->tpl_vars['tjdata']->value['monthallorder'];?>
</h3><span>本月完成订单</span></li>
                     <li style="border-right:none;"><h3><?php echo $_smarty_tpl->tpl_vars['tjdata']->value['allorder'];?>
</h3><span>完成订单总量</span></li>
                     <li><h3><?php echo $_smarty_tpl->tpl_vars['tjdata']->value['pmember'];?>
</h3><span>会员总数</span></li>
                     <li><h3><?php echo $_smarty_tpl->tpl_vars['tjdata']->value['wshop'];?>
</h3><span>待审核商家</span></li>
                     <li><h3><?php echo $_smarty_tpl->tpl_vars['tjdata']->value['onlineshop'];?>
</h3><span>已上线商家</span></li>
                     <li><h3><?php echo $_smarty_tpl->tpl_vars['tjdata']->value['market'];?>
</h3><span>商城订单</span></li>
                     <li style="border-right:none;"><h3><?php echo $_smarty_tpl->tpl_vars['tjdata']->value['marketg'];?>
</h3><span>商品数量</span></li>
                 </ul>
             </div>
         </div>
     </div>
 </div>

   	        	 	
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