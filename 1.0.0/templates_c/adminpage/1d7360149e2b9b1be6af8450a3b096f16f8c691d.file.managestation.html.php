<?php /* Smarty version Smarty-3.1.10, created on 2018-01-31 23:23:06
         compiled from "D:\UPUPW_K2.1\htdocs\wmr87\templates\adminpage\station\managestation.html" */ ?>
<?php /*%%SmartyHeaderCode:49785a71df5a30dc05-12618676%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1d7360149e2b9b1be6af8450a3b096f16f8c691d' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\adminpage\\station\\managestation.html',
      1 => 1505458154,
      2 => 'file',
    ),
    '1956299623e26c37e8fd2d283464ea2ebcb0eefc' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\adminpage\\public\\admin.html',
      1 => 1505877233,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '49785a71df5a30dc05-12618676',
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
  'unifunc' => 'content_5a71df5ad28ca3_42713041',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a71df5ad28ca3_42713041')) {function content_5a71df5ad28ca3_42713041($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\lib\\Smarty\\libs\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_function_load_data')) include 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\lib\\Smarty\\libs\\plugins\\function.load_data.php';
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
   	        	 	   <div class="showtop_t" id="positionname">添加分站</div>
   	        	 </div>
   	        	 <div class="show_content_m_t2">
   	        	 	
   	        	 	
   <div style="width:auto;overflow-x:hidden;overflow-y:auto"> 
          <div class="tags">
           <?php echo smarty_function_load_data(array('assign'=>"info",'table'=>"admin",'where'=>"`uid`=".((string)$_smarty_tpl->tpl_vars['id']->value),'type'=>"one"),$_smarty_tpl);?>
 
           <?php echo smarty_function_load_data(array('assign'=>"stationinfo",'table'=>"stationadmininfo",'where'=>"`uid`=".((string)$_smarty_tpl->tpl_vars['id']->value),'type'=>"one"),$_smarty_tpl);?>
 
          <div id="tagscontent">
            <form method="post" name="form1" action="<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/station/module/savestationadmin/datatype/json"),$_smarty_tpl);?>
" onsubmit="return subform('<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/station/module/stationlist"),$_smarty_tpl);?>
',this);">
              <div>
                <table border="0" cellspacing="2" cellpadding="4" class="list" name="table" id="table" width="100%">
                  <tbody>
                    <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">
                      <td class="left">分站账号</td>
                      <td><input type="text" name="username" id="username" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['info']->value['username'])===null||$tmp==='' ? '' : $tmp);?>
" class="skey" style="width:150px;" <?php if (!empty($_smarty_tpl->tpl_vars['info']->value)){?> readonly<?php }?>></td>
                    </tr> 
                    <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">
                      <td class="left">分站密码</td>
                      <td><input type="password" name="password" id="password" value="" class="skey" style="width:250px;"></td>
                    </tr> 
                  
                    <input type="hidden" name="uid" id="uid" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['uid'];?>
" class="skey" style="width:150px;">
					 
				  <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">
                      <td class="left">分站名称</td>
                      <td><input type="text" name="stationname" id="stationname" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['stationinfo']->value['stationname'])===null||$tmp==='' ? '' : $tmp);?>
" class="skey" style="width:250px;"></td>
                    </tr>
					  <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">
                      <td class="left">分站负责人</td>
                      <td><input type="text" name="stationusername" id="stationusername" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['stationinfo']->value['stationusername'])===null||$tmp==='' ? '' : $tmp);?>
" class="skey" style="width:250px;"></td>
                    </tr> 
					<tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">
                      <td class="left">分站联系电话</td>
                      <td><input type="text" name="stationphone" id="stationphone" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['stationinfo']->value['stationphone'])===null||$tmp==='' ? '' : $tmp);?>
" class="skey" style="width:250px;"></td>
                    </tr>
					<?php if (!empty($_smarty_tpl->tpl_vars['stationinfo']->value)){?>
						<tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">
						  <td class="left" valign="top">所属城市</td>
						  <td>  
							<?php echo smarty_function_load_data(array('assign'=>"cityinfo",'table'=>"area",'type'=>"one",'where'=>"adcode='".((string)$_smarty_tpl->tpl_vars['stationinfo']->value['cityid'])."'",'fileds'=>"name"),$_smarty_tpl);?>
  
							<span style="margin-left:10px;"><?php echo $_smarty_tpl->tpl_vars['cityinfo']->value['name'];?>
</span>
						  </td>
						</tr>
					<?php }else{ ?>
					<tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">
                      <td class="left" valign="top">选择城市</td>
                      <td>  
                      <select name="cityid">
 							<?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_smarty_tpl->tpl_vars['myid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['citylist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
 $_smarty_tpl->tpl_vars['myid']->value = $_smarty_tpl->tpl_vars['items']->key;
?>  
							   <option value="<?php echo $_smarty_tpl->tpl_vars['items']->value['adcode'];?>
" <?php if ($_smarty_tpl->tpl_vars['stationinfo']->value['cityid']==$_smarty_tpl->tpl_vars['items']->value['adcode']){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['items']->value['name'];?>
</option>
							<?php } ?> 
                      </select>
                      	</td>
                    </tr>
					<?php }?>
					
					 
					 <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">
                      <td class="left">分站位置</td>
                      <td><!-- <input type="text"  readonly  value="拾取坐标" class="skey" style="width:100px;"> -->
<input type="text" name="stationaddress" id="stationaddress" placeholder="分站地址" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['stationinfo']->value['stationaddress'])===null||$tmp==='' ? '' : $tmp);?>
" class="skey" style="width:250px;">
					  <input type="hidden" name="stationlnglat" id="stationlnglat" readonly  value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['stationinfo']->value['stationlnglat'])===null||$tmp==='' ? '' : $tmp);?>
" class="skey" style="width:250px;">
					  </td>
                    </tr>

					<tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">
					  <td class="left">优惠促销权限</td>
                      <td><input type="radio" <?php if ($_smarty_tpl->tpl_vars['stationinfo']->value['is_selfsitecx']==1){?>checked<?php }?>  name="is_selfsitecx" value="1" />允许独立设置优惠促销
                       <input type="radio" <?php if ($_smarty_tpl->tpl_vars['stationinfo']->value['is_selfsitecx']==0){?>checked<?php }?>   name="is_selfsitecx" value="0">不允许独立设置优惠促销<font style="color:red">（当设置为不允许时，该分站后台独立设置的优惠促销活动将会被删除）</font></td>
                    </tr>
					 <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">
					  <td class="left">排序</td>
                      <td><input type="text" name="orderid" id="orderid"   value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['stationinfo']->value['orderid'])===null||$tmp==='' ? '' : $tmp);?>
" class="skey" style="width:100px;"></td>
                    </tr>
					 <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">
					  <td class="left">是否启用</td>
                      <td><input type="radio" <?php if ($_smarty_tpl->tpl_vars['stationinfo']->value['stationis_open']==0){?>checked<?php }?>  name="stationis_open" value="0" />是
                       <input type="radio" <?php if ($_smarty_tpl->tpl_vars['stationinfo']->value['stationis_open']==1){?>checked<?php }?>   name="stationis_open" value="1">否</td>
                    </tr>
					
                   
                  </tbody>
                </table>
              </div>
              <div class="blank20"></div>
              <input type="hidden" name="tijiao" id="tijiao" value="do" class="skey" style="width:250px;">
              <input type="hidden" name="saction" id="saction" value="siteset" class="skey" style="width:250px;">
               <input type="submit" value="确认提交" class="button">  
            </form>
          </div>
        </div>
        <div class="blank20"></div> 
      
      </div>
      <div class="clear"></div>
    </div>
   
   
    </div> 
<script>	 
function checkword(flag)
{ 
	 
	$("input[name='limit[]']").attr("checked",flag); 
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