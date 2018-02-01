<?php /* Smarty version Smarty-3.1.10, created on 2017-11-23 17:55:34
         compiled from "D:\wwwroot\wm87_demo\web\templates\adminpage\system\siteset.html" */ ?>
<?php /*%%SmartyHeaderCode:325735a169b16311d38-49553159%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '53576d581b5712eae2d7d99122e1cb79d187f00b' => 
    array (
      0 => 'D:\\wwwroot\\wm87_demo\\web\\templates\\adminpage\\system\\siteset.html',
      1 => 1498545790,
      2 => 'file',
    ),
    '398c43a12bcc6e9ae18001a73e5bbcfeb1f8243c' => 
    array (
      0 => 'D:\\wwwroot\\wm87_demo\\web\\templates\\adminpage\\public\\admin.html',
      1 => 1505877233,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '325735a169b16311d38-49553159',
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
  'unifunc' => 'content_5a169b165fd821_55180004',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a169b165fd821_55180004')) {function content_5a169b165fd821_55180004($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\wwwroot\\wm87_demo\\web\\lib\\Smarty\\libs\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_function_load_data')) include 'D:\\wwwroot\\wm87_demo\\web\\lib\\Smarty\\libs\\plugins\\function.load_data.php';
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
   	        	 	   <div class="showtop_t" id="positionname">网站设置</div>
   	        	 </div>
   	        	 <div class="show_content_m_t2">
   	        	 	
   	        	 	 
	
	  <div style="width:auto;overflow-x:hidden;overflow-y:auto;">   
          <div id="tagscontent">
            <form method="post" name="form1" action="<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/system/module/saveset/datatype/json"),$_smarty_tpl);?>
" onsubmit="return subform('',this);">
              <div>
                <table border="0" cellspacing="2" cellpadding="4" class="list" name="table" id="table" width="100%">
                  <tbody>
                    <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">
                      <td class="left">网站名称</td>
                      <td><input type="text" name="sitename" id="sitename" value="<?php echo $_smarty_tpl->tpl_vars['sitename']->value;?>
" class="skey" style="width:150px;"></td>
                    </tr>
                    
                    <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">
                      <td class="left">网站SEO描述</td>
                      <td><input type="text" name="description" id="description" value="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
" class="skey" style="width:250px;"></td>
                    </tr>
                     <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="#ffffff">
                      <td class="left">网站SEO关键字</td>
                      <td><input type="text" name="keywords" id="keywords" value="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
" class="skey" style="width:250px;"></td>
                    </tr>
                    <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="#ffffff">
                      <td class="left">公司名称</td>
                      <td><input type="text" name="companyname" id="companyname" value="<?php echo $_smarty_tpl->tpl_vars['companyname']->value;?>
" class="skey" style="width:250px;"></td>
                    </tr>
                    <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="#ffffff">
                      <td class="left">网站地址</td>
                      <td><input type="text" name="website" id="website" value="<?php echo $_smarty_tpl->tpl_vars['website']->value;?>
" class="skey" style="width:250px;"></td>
                    </tr>
                     
                    <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="#ffffff">
                      <td class="left">备案号</td>
                      <td><input type="text" name="beian" id="beian" value="<?php echo $_smarty_tpl->tpl_vars['beian']->value;?>
" class="skey" style="width:250px;"></td>
                    </tr>
                    <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="#ffffff">
                      <td class="left">客服电话</td>
                      <td><input type="text" name="litel" id="litel" value="<?php echo $_smarty_tpl->tpl_vars['litel']->value;?>
" class="skey" style="width:250px;"></td>
                    </tr>
                   
                    <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="#ffffff" >
                      <td class="left">佣金比例</td>
                      <td><input type="text" name="yjin" id="yjin" value="<?php echo $_smarty_tpl->tpl_vars['yjin']->value;?>
" class="skey" style="width:50px;">整数,例如：5 表示佣金比例为订单总金额的5%</td>
                    </tr>
                    
					  <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="#ffffff" >
                      <td class="left">短信签名</td>
                      <td><input type="text" name="msgqianming" id="msgqianming" value="<?php echo $_smarty_tpl->tpl_vars['msgqianming']->value;?>
" class="skey" style="width:100px;">比如：【短信签名】</td>
                    </tr>
                     <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="#ffffff">
                      <td class="left">网站默认城市</td>
                      <td><input type="text" name="cityname" id="cityname" value="<?php echo $_smarty_tpl->tpl_vars['cityname']->value;?>
" class="skey" style="width:100px;"></td>
                    </tr>
					
					 <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="#ffffff">
                      <td class="left">绑定网站自营城市</td>
                      <td>
					   <select name="default_cityid">
						<option value="0">请选择网站自营城市</option> 
							 <?php echo smarty_function_load_data(array('assign'=>"arealist",'table'=>"area",'fileds'=>"*",'where'=>" parent_id=0 ",'orderby'=>" orderid asc ",'limit'=>"1000"),$_smarty_tpl);?>
  
								<?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_smarty_tpl->tpl_vars['myid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['arealist']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
 $_smarty_tpl->tpl_vars['myid']->value = $_smarty_tpl->tpl_vars['items']->key;
?>  
								   <option value="<?php echo $_smarty_tpl->tpl_vars['items']->value['adcode'];?>
" <?php if ($_smarty_tpl->tpl_vars['default_cityid']->value==$_smarty_tpl->tpl_vars['items']->value['adcode']){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['items']->value['name'];?>
</option>
								<?php } ?> 
						  </select>
					  </td>
                    </tr>
					
					
					
					
					<?php if (!empty($_smarty_tpl->tpl_vars['default_cityid']->value)){?>
					
					
				 <!--  <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="#ffffff">
                      <td class="left" style="color:red;">设置相关数据全部绑定当前城市</td>
                      <td><input type="button" id="bangdingDefCity" value="点击设置" class="skey" style="width:100px;" />
					  <br /><span style="color:red;font-weight:bold;">提示：设置后无法撤销，请谨慎操作，如果不懂请咨询客服，点击设置会将以下数据自动绑定为上面所绑定的网站自营城市：广告、分类、店铺、配送员所属城市、网站通知、生活服务、跑腿信息设置、专题页管理</span>
					  </td>
                    </tr> -->
					<script>
					$('#bangdingDefCity').click(function(){
					
						if(confirm("确定要把相关数据绑定为当前城市吗?\n设置后无法撤销，请谨慎操作"))
						 {
						 
						 
						var url= siteurl+'/index.php?ctrl=adminpage&action=system&module=setCityDatas&datatype=json&random=@random@';
						url = url.replace('@random@', 1+Math.round(Math.random()*1000)); 
						var bk = ajaxback(url,{}); 
						if(bk.flag == false){
							diaerror("设置成功！");
						}else{
							diaerror(bk.content);
						}
						 
						 
						 
						 }
					
					});
					</script>
					
					<?php }?>
         
                   <!--  <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="#ffffff">
                      <td class="left">网站公告</td>
                      <td><textarea name="notice"><?php echo $_smarty_tpl->tpl_vars['notice']->value;?>
</textarea></td>
                    </tr>
					 -->
                    <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="#ffffff">
                      <td class="left">店铺公告</td>
                      <td><textarea name="shopnotice"><?php echo $_smarty_tpl->tpl_vars['shopnotice']->value;?>
</textarea>在店铺没有自行设置店铺公告的情况下,默认显示该公告</td>
                    </tr>

                    
                    <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="#ffffff">
                      <td class="left">网站meta数据</td>
                      <td><textarea name="metadata"><?php echo stripslashes($_smarty_tpl->tpl_vars['metadata']->value);?>
</textarea></td>
                    </tr>
                    <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="#ffffff">
                      <td class="left">统计代码</td>
                      <td><textarea name="footerdata"><?php echo stripslashes($_smarty_tpl->tpl_vars['footerdata']->value);?>
</textarea></td>
                    </tr>
					
				 
				 
					 <!-- <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">
                      <td class="left">启用配送宝</td>
                      <td>  
						<input type="radio" name="psbopen"  value="2" checked>不启用
						<input type="radio" name="psbopen"  value="1" <?php if (isset($_smarty_tpl->tpl_vars['psbopen']->value)&&$_smarty_tpl->tpl_vars['psbopen']->value==1){?>checked<?php }?> >启用
						&nbsp;&nbsp;&nbsp;(启用后才能为商家设置配送宝对接) 
					  </td>
                    </tr>  
					<tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff" class="pspsb">
                      <td class="left">自动对接配送宝域名</td>
                      <td>
                       <input type="text" name="autopsblink" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['autopsblink']->value)===null||$tmp==='' ? '' : $tmp);?>
" style="width:200px;">
                      </td>
                    </tr>  
					<tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff" class="pspsb">
                      <td class="left">自动对接配送宝key</td>
                      <td>
                       <input type="text" name="autopsbkey" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['autopsbkey']->value)===null||$tmp==='' ? '' : $tmp);?>
"  style="width:200px;">
                      </td>
                    </tr>  -->
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
      
    

          </div> 



  
<!--newmain 结束-->
 
   	        	 	
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