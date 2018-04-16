<?php /* Smarty version Smarty-3.1.10, created on 2018-04-16 22:39:57
         compiled from "C:\UPUPW_K2.1\htdocs\kjc\2.0.0\templates\adminpage\station\stationlist.html" */ ?>
<?php /*%%SmartyHeaderCode:97735ad4b5bd47fda0-52849815%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8dbcfe146c562de7807c16aa6904ea36c298321e' => 
    array (
      0 => 'C:\\UPUPW_K2.1\\htdocs\\kjc\\2.0.0\\templates\\adminpage\\station\\stationlist.html',
      1 => 1520997460,
      2 => 'file',
    ),
    '16b7baed3539d44da7f62e0f70b69068782a0306' => 
    array (
      0 => 'C:\\UPUPW_K2.1\\htdocs\\kjc\\2.0.0\\templates\\adminpage\\public\\admin.html',
      1 => 1520829804,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '97735ad4b5bd47fda0-52849815',
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
  'unifunc' => 'content_5ad4b5bdaefcd5_07386458',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ad4b5bdaefcd5_07386458')) {function content_5ad4b5bdaefcd5_07386458($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'C:\\UPUPW_K2.1\\htdocs\\kjc\\2.0.0\\lib\\Smarty\\libs\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_function_load_data')) include 'C:\\UPUPW_K2.1\\htdocs\\kjc\\2.0.0\\lib\\Smarty\\libs\\plugins\\function.load_data.php';
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
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
	  	   <div class="imglogo"><a  target="_blank">
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
	    	今天是：<?php echo smarty_modifier_date_format(time(),"%Y-%m-%d");?>
  
	    </div>
<!-- 	    <div class="nav2 positioninfo" id="positionname2">
	    	网站首页
	    </div> -->
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

   	 	    	 
   	 	    	      <!-- <li style="text-align:center;"><a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
" style="color:#0076cf;" target="_blank">返回网站首页</a></li>-->
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
   	        	 	   <div class="showtop_t" id="positionname">分校列表</div>
   	        	 </div>
   	        	 <div class="show_content_m_t2">
   	        	 	
   	        	 	
 <div style="width:auto;overflow-x:hidden;overflow-y:auto">

      	<div class="search">



            <div class="search_content">

            	 <form method="post" name="form1" action="<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/station/module/stationlist"),$_smarty_tpl);?>
">
            		<!-- 		  <select name="cityid">
            					<option value="0">全部</option>
                                  	 <?php echo smarty_function_load_data(array('assign'=>"arealist",'table'=>"area",'fileds'=>"*",'where'=>" parent_id=0 ",'orderby'=>" orderid asc ",'limit'=>"1000"),$_smarty_tpl);?>

            							<?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_smarty_tpl->tpl_vars['myid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['arealist']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
 $_smarty_tpl->tpl_vars['myid']->value = $_smarty_tpl->tpl_vars['items']->key;
?>
            							   <option value="<?php echo $_smarty_tpl->tpl_vars['items']->value['adcode'];?>
" <?php if ($_smarty_tpl->tpl_vars['cityid']->value==$_smarty_tpl->tpl_vars['items']->value['adcode']){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['items']->value['name'];?>
</option>
            							<?php } ?>
                      </select> -->
                <input type="hidden" name="cityid" value="0">
            	  <label>查询类型：</label>
            	  <select name="querytype">
            	  	<option value="0">未选择</option>
            	  	<option value="st.stationname"  <?php if ($_smarty_tpl->tpl_vars['querytype']->value=='st.stationname'){?>selected<?php }?>>分校名称</option>
            	  	<option value="st.stationusername"  <?php if ($_smarty_tpl->tpl_vars['querytype']->value=='st.stationusername'){?>selected<?php }?>>分校负责人</option>
            	  	<option value="st.stationphone"  <?php if ($_smarty_tpl->tpl_vars['querytype']->value=='st.stationphone'){?>selected<?php }?>>分校电话</option>
             	  </select>
            	  <label>查询条件：</label>
            	   <input type="text" name="searchvalue" value="<?php echo $_smarty_tpl->tpl_vars['searchvalue']->value;?>
">

            	   <select name="status">
								<option value="all">状态</option>
			   		 	  	  <option value="1" <?php if ($_smarty_tpl->tpl_vars['status']->value=='1'){?>selected<?php }?>>开启</option>
			   		 	  	  <option value="2" <?php if ($_smarty_tpl->tpl_vars['status']->value=='2'){?>selected<?php }?>>关闭</option>
            	  </select>

            	    <input type="submit" value="提交查询" class="button">

            	 </form>
            </div>

      	</div>



           <div class="tags">



          <div id="tagscontent">

            <div id="con_one_1">

              <div class="table_td" style="margin-top:10px;">

              <form method="post" action="" onsubmit="return remind();"  id="delform">

                  <table border="0" cellspacing="2" cellpadding="4" class="list" name="table" id="table" width="100%">

                    <thead>

                      <tr>

                        <!-- <th width="60px"><input type="checkbox" id="chkall" name="chkall" onclick="checkall()"></th> -->

                        <th align="center">ID</th>
                        <!-- <th align="center">分校账号</th> -->
                        <th align="center">分校名称</th>
                        <th align="center">所属城市</th>
                        <th align="center">分校负责人</th>
                        <th align="center">分校电话</th>
                        <th align="center">分校地址</th>
                        <th align="center">状态</th>
                        <th align="center">排序</th>
                        <th align="center">操作</th>

                      </tr>

                    </thead>

                     <tbody>

					 <?php if (empty($_smarty_tpl->tpl_vars['stationlist']->value)){?>
						 <tr class="s_out" onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="#ffffff">
							<td colspan=10 align="center">暂无数据  </td>
						  </tr>
					<?php }else{ ?>
                       <?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['stationlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
?>
                      <tr class="s_out" onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="#ffffff">
                        <!-- <td align="center" ><input type="checkbox" name="id[]" value="<?php echo $_smarty_tpl->tpl_vars['items']->value['id'];?>
"></td> -->
                        <td align="center"><?php echo $_smarty_tpl->tpl_vars['items']->value['id'];?>
  </td>

                        <td align="center"> <?php echo $_smarty_tpl->tpl_vars['items']->value['stationname'];?>
 </td>
						 <td align="center">
						<?php echo smarty_function_load_data(array('assign'=>"cityinfo",'table'=>"area",'type'=>"one",'where'=>"adcode='".((string)$_smarty_tpl->tpl_vars['items']->value['cityid'])."'",'fileds'=>"name"),$_smarty_tpl);?>

						<?php echo $_smarty_tpl->tpl_vars['cityinfo']->value['name'];?>
 </td>
                        <td align="center"> <?php echo $_smarty_tpl->tpl_vars['items']->value['stationusername'];?>
 </td>
                        <td align="center"> <?php echo $_smarty_tpl->tpl_vars['items']->value['stationphone'];?>
 </td>
                        <td align="center"> <?php echo $_smarty_tpl->tpl_vars['items']->value['stationaddress'];?>
 </td>
                        <td align="center"> <?php if ($_smarty_tpl->tpl_vars['items']->value['stationis_open']==0){?>开启中<?php }elseif($_smarty_tpl->tpl_vars['items']->value['stationis_open']==1){?>关闭<?php }else{ ?>未知<?php }?> </td>
                        <td align="center"> <?php echo $_smarty_tpl->tpl_vars['items']->value['orderid'];?>
 </td>
                         <td align="center">
							  <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/station/module/managestation/id/".((string)$_smarty_tpl->tpl_vars['items']->value['id'])),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/images/admin/edit.jpg"></a>
                <a onclick="return remind(this);" href="<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/station/module/delstation/id/".((string)$_smarty_tpl->tpl_vars['items']->value['uid'])."/datatype/json"),$_smarty_tpl);?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/images/admin/del.jpg"></a>
							   </td>
                      </tr>
                       <?php } ?>
					<?php }?>
                    </tbody>

                  </table>

                <div class="blank20"></div>

                 <input type="hidden" name="stopoutenable" id="stopoutenable" value="4ce2f22509228162cadfc0ca0473ec19"/>

                </form>

               <div class="page_newc">
                 	     <!-- <div class="select_page">
                 	     	<a href="#" onclick="checkword(true);">全选</a>/<a href="#" onclick="checkword(false);">取消</a>
                 	     <a onclick="return remindall(this);" href="<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/ask/module/delask/datatype/json"),$_smarty_tpl);?>
" class="delurl">删除</a>
                 	     	</div> -->
                       <div class="show_page"><ul><?php echo $_smarty_tpl->tpl_vars['pagecontent']->value;?>
</ul></div>
                 </div>

                <div class="blank20"></div>

              </div>

            </div>

          </div>

        </div>


  </div>
 <div id="askback" style="display:none;">

               <div>
                <table border="0" cellspacing="1" cellpadding="4" class="list" name="table" id="table" width="100%">
                  <tbody>

                  	<tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">

                      <td><textarea name="askback" style="height:70px;width:200px"></textarea></td>
                    </tr>

                    </table>
                </div>
              <div class="blank20"></div>
              <input type="hidden" name="askbackid" id="askbackid" value="" class="skey" style="width:150px;">
               <input type="submit" value="确认提交" class="button">

  </div>
 <script>
	var dialogs ;
 function reask(ids,obj){
 	 var formurl = '<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/ask/module/backask/datatype/json"),$_smarty_tpl);?>
';
 	 $('#askbackid').val(ids);
 	 var showcontent = '<form method="post" name="form1" action="'+formurl+'" onsubmit="return subform(\'<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/ask/module/asklist"),$_smarty_tpl);?>
\',this);">'

      showcontent += $('#askback').html();
      showcontent +='</form>';
   var dialog =  art.dialog({
    title:'留言回复',
    id:'ask',
    content: showcontent
  });
 }

</script>
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