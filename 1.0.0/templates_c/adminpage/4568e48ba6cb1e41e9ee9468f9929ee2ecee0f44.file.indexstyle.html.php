<?php /* Smarty version Smarty-3.1.10, created on 2018-01-31 23:12:17
         compiled from "D:\UPUPW_K2.1\htdocs\wmr87\templates\adminpage\weixin\indexstyle.html" */ ?>
<?php /*%%SmartyHeaderCode:300835a71dcd14ca5f2-37332833%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4568e48ba6cb1e41e9ee9468f9929ee2ecee0f44' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\adminpage\\weixin\\indexstyle.html',
      1 => 1508234871,
      2 => 'file',
    ),
    '1956299623e26c37e8fd2d283464ea2ebcb0eefc' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\adminpage\\public\\admin.html',
      1 => 1505877233,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '300835a71dcd14ca5f2-37332833',
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
  'unifunc' => 'content_5a71dcd1b28979_56547795',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a71dcd1b28979_56547795')) {function content_5a71dcd1b28979_56547795($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\lib\\Smarty\\libs\\plugins\\modifier.date_format.php';
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

<link href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/css/phone.css" rel="stylesheet" type="text/css">
        
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
   	        	 	   <div class="showtop_t" id="positionname">用户端首页设置</div>
   	        	 </div>
   	        	 <div class="show_content_m_t2">
   	        	 	
   	        	 	
   <div style="width:auto;overflow-x:hidden;overflow-y:auto;bottom:50px;">
       <div class="page" style="height:800px;">
           <div class="appAddtoCon">
               <div class="appAddtoLeft">
                   <div class="appAddtoImgCon">
                       <div class="appAddtoImgBox">

                           <div class="appAddtoBox">
                               <div class="appAddtoImg">
                                   <img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/images/app_001.png" />
                               </div>
                               <div class="appAddto">
                                   <a href="javascript:;" data="imgflash" >编辑</a>
                               </div>
                           </div>

                           <div class="appAddtoBox">
                               <div class="appAddtoImg">
                                   <img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/images/app_002.png" />
                               </div>
                               <div class="appAddto">
                                   <a href="javascript:;" data="classlist" >编辑</a>
                               </div>
                           </div>
                           <div class="appAddtoBox">
                               <div class="appAddtoImg">
                                   <img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/images/app_0011.png" />
                               </div>
                           </div>
                           <div class="appAddtoBox">
                               <div class="appAddtoImg" id="sddd" style="background-color:#fff;">


                               </div>
                               <div class="appAddto">
                                   <a href="javascript:;" data="ztylist" >编辑</a>
                               </div>
                           </div>

                           <div class="appAddtoBox" style="background-color: #fff;">
                               <div class="appAddtoImg">
                                   <img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/images/app0714.png" style="width:93.5%;margin-left:8px;" />
                               </div>
                               <div class="appAddto">
                                   <a href="javascript:;" data="imgflash2" >编辑</a>
                               </div>
                           </div>

                           <div class="appAddtoBox">
                               <div class="appAddtoImg">
                                   <img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/images/app_004.png" />
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <!---  js 调用模块 -->
               <div id="showjscontent"></div>
           </div>
       </div>

       <script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/js/ajaxfileupload.js"> </script>
       <script>
           $(function(){
               showzty();
               $('.appAddto a').bind('click',function(){
                   $('#showjscontent').html('');
                   var act = $(this).attr('data');
                   get_paramhtml(act);
               });
           });
           function get_paramhtml(act){
               if(act == ' '){
                   alert("获取失败");
                   return false;
               }
               var content = htmlback("<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/index.php?ctrl=adminpage&action=weixin&module="+act+"");
               if(content.flag == false){
                   var getmoreContent =  $.trim(content.content);
                   if( getmoreContent == ''){
                       alert("获取失败");
                   }else{
                       $('#showjscontent').append(getmoreContent);
                   }
               }else{
                   alert('获取失败');
               }
           }

           $("input[name='ztystyle']").live('click',function(){
               var url = '<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/index.php?ctrl=adminpage&action=weixin&module=ztymodetog&random=@random@&datatype=json';
               $.ajax({
                   type: 'post',
                   async:true,
                   data:{'ztytype': $(this).val()},
                   url: url.replace('@random@', 1+Math.round(Math.random()*1000)),
                   dataType: 'json',success: function(content) {
                       if(content.error == false){
                           $('#showjscontent').html('');
                           get_paramhtml('ztylist');
                           showzty();
                       }else{
                           if(content.error == true){
                               alert(content.msg);
                           }else{
                               alert(content);
                           }
                       }
                   },
                   error: function(content) {
                       alert('数据提交失败');
                   }
           })
           })

           $("#imgFile").live("change", function (){
               ajaxFileUpload();
               $("#upload").replaceWith($("#upload").clone(true));
           });
           $('input[name="link_type"]').live('click',function(){
               var link_type = $(this).val();
               if(link_type == 1){
                   $('select[name="i_catid"]').show();
                   $('select[name="i_catid"]').parent().show();
                   $('input[name="i_links"]').hide();
                   $('input[name="i_links"]').parent().hide();
               }else if(link_type == 2){
                   $('select[name="i_catid"]').hide();
                   $('select[name="i_catid"]').parent().hide();
                   $('input[name="i_links"]').show();
                   $('input[name="i_links"]').parent().show();
               }
           });


           $('#doclose').live('click',function(){
               $('#bottom_edit').hide();
           });
           $('.appAdda_bg01').live('click',function(){
               if(confirm('确认显示')){
                   var tempid = $(this).parents('tr').attr('cid');
                   if(tempid==0){
                       alert("数据不存在");return;
                   }
                   var type = $(this).parents('tr').attr('type');
                   var ztytype=$("input[name='ztystyle']:checked").val();
                   $(this).html('隐藏');
                   $(this).addClass('appAdda_bg02');
                   $(this).removeClass('appAdda_bg01');
                   var url = '<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/index.php?ctrl=adminpage&action=weixin&module=togdata&random=@random@&datatype=json';
                   $.ajax({
                       type: 'post',
                       async:false,
                       data:{'id':tempid,'type':type,'flag':1,'ztytype':ztytype},
                       url: url.replace('@random@', 1+Math.round(Math.random()*1000)),
                       dataType: 'json',success: function(content) {
                           if(content.error == false){

                           }else{
                               if(content.error == true)
                               {
                                   alert(content.msg);
                               }else{
                                   alert(content);
                               }
                           }
                       },
                       error: function(content) {
                           alert('数据提交失败');
                       }
                   });
               }
               return false;
           });
           $('.appAdda_bg02').live('click',function(){
               if(confirm('确认隐藏')){
                   var tempid = $(this).parents('tr').attr('cid');
                   var type = $(this).parents('tr').attr('type');
                   var ztytype=$("input[name='ztystyle']:checked").val();
                   $(this).html('显示');
                   $(this).addClass('appAdda_bg01');
                   $(this).removeClass('appAdda_bg02');
                   var url = '<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/index.php?ctrl=adminpage&action=weixin&module=togdata&random=@random@&datatype=json';
                   $.ajax({
                       type: 'post',
                       async:false,
                       data:{'id':tempid,'type':type,'flag':0,'ztytype':ztytype},
                       url: url.replace('@random@', 1+Math.round(Math.random()*1000)),
                       dataType: 'json',success: function(content) {
                           if(content.error == false){

                           }else{
                               if(content.error == true)
                               {
                                   alert(content.msg);
                               }else{
                                   alert(content);
                               }
                           }
                       },
                       error: function(content) {
                           alert('数据提交失败');
                       }
                   });
               }
           });
           function GetRequest(url) {
               var theRequest = new Object();
               if (url.indexOf("?") != -1) {
                   var str = url.substr(1);
                   strs = str.split("&");
                   for(var i = 0; i < strs.length; i ++) {
                       theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
                   }
               }
               return theRequest;
           }
           function ajaxFileUpload()
           {
               $.ajaxFileUpload
               (
                       {
                           url:'<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/index.php?ctrl=adminpage&action=weixin&module=uploadapp&datatype=json',
                           secureuri:false,
                           fileElementId:'imgFile',
                           dataType: 'json',
                           data:'',
                           success: function (data, status)
                           {
                               if(typeof(data.error) != 'undefined')
                               {
                                   if(data.error == false)
                                   {
                                       $('input[name="i_img_url"]').val(data.msg[0].saveName);
                                   }else
                                   {
                                       alert(data.msg);
                                   }
                               }else{
                                   alert(data);
                               }
                           },
                           error: function (data, status, e)
                           {
                               alert(e);
                           }
                       }
               )

               return false;

           }
           $("#imgFile1").live("change", function () {
               ajaxFileUpload1();
               $("#upload").replaceWith($("#upload").clone(true));
           });
           function ajaxFileUpload1()
           {
               $.ajaxFileUpload
               (
                       {
                           url:'http://demo.guangheo2o.com/index.php?c=admin_system&act=uploadbyadmin1&datatype=json',
                           secureuri:false,
                           fileElementId:'imgFile1',
                           dataType: 'json',
                           data:'',
                           success: function (data, status)
                           {console.log(data);
                               if(typeof(data.error) != 'undefined')
                               {
                                   if(data.error == false)
                                   {
                                       $('input[name="i_img_url1"]').val(data.url);
                                   }else
                                   {
                                       alert(data.message);
                                   }
                               }else{
                                   alert(data);
                               }
                           },
                           error: function (data, status, e)
                           {
                               alert(e);
                           }
                       }
               )

               return false;

           }
           function htmlback(url,info)
           {
               var backmessage = {'flag':true,'content':''};
               $.ajax({
                   type: 'POST',
                   async:false,
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

           function showzty(){
               $('#sddd').html(' ');
               var type=$("input[name='ztystyle']:checked").val();
               var ztyurl = '<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/index.php?ctrl=adminpage&action=weixin&module=ztymodehtml';
               var content = htmlback(ztyurl,{'type':type});
               if(content.flag == false){
                   var getmoreContent =  $.trim(content.content);
                   if( getmoreContent == ''){
                       alert("获取失败");
                   }else{
                       $('#sddd').append(getmoreContent);
                   }
               }else{
                   alert('获取失败');
               }
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