<?php /* Smarty version Smarty-3.1.10, created on 2018-01-31 23:22:22
         compiled from "D:\UPUPW_K2.1\htdocs\wmr87\templates\adminpage\station\managecity.html" */ ?>
<?php /*%%SmartyHeaderCode:150835a71df2e838c65-52410454%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '92221c3addf0ebe77ed4b395324e3b50ad8bf49a' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\adminpage\\station\\managecity.html',
      1 => 1500349342,
      2 => 'file',
    ),
    '1956299623e26c37e8fd2d283464ea2ebcb0eefc' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\adminpage\\public\\admin.html',
      1 => 1505877233,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '150835a71df2e838c65-52410454',
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
  'unifunc' => 'content_5a71df2ef15ee4_26777548',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a71df2ef15ee4_26777548')) {function content_5a71df2ef15ee4_26777548($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\lib\\Smarty\\libs\\plugins\\modifier.date_format.php';
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
   	        	 	   <div class="showtop_t" id="positionname">城市添加</div>
   	        	 </div>
   	        	 <div class="show_content_m_t2">
   	        	 	
   	        	 	
 <style>
 #adrcodeList{display:none;position:absolute;top:32px; left:0px; background:#FFF;border:1px solid #c15050;padding:0px 10px; width:228px;max-height:400px;overflow: auto;}
 #adrcodeList li{width:100%;color:#0076cf;cursor:pointer;}
 </style>
 <div style="width:auto;overflow-x:hidden;overflow-y:auto"> 
          <div class="tags">
          <?php echo smarty_function_load_data(array('assign'=>"info",'table'=>"area",'type'=>"one",'where'=>"id='".((string)$_smarty_tpl->tpl_vars['id']->value)."'"),$_smarty_tpl);?>
 
          <div id="tagscontent">
		  
            <form method="post" name="form1" action="<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/station/module/savecity/datatype/json"),$_smarty_tpl);?>
" onsubmit="return subform('<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/station/module/citylist"),$_smarty_tpl);?>
',this);">
              <div>
                <table border="0" cellspacing="2" cellpadding="4" class="list" name="table" id="table" width="100%">
                  <tbody>
                    <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">
                      <td class="left">城市名称</td>
                      <td style="position:relative;">
					  <input type="text" name="name"  id="searchKeywords"   id="name" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['name'];?>
" class="skey" style="width:150px;" />
					  <input type="hidden" name="adcode"  value="<?php echo $_smarty_tpl->tpl_vars['info']->value['adcode'];?>
" class="skey" style="width:150px;" />
					  <input type="hidden" name="procode"  value="<?php echo $_smarty_tpl->tpl_vars['info']->value['procode'];?>
" class="skey" style="width:150px;" />
					  注意：请搜索选择城市，勿随便添加
					  <div id="adrcodeList" >
							<ul>
  							</ul>
					  </div>
 					  </td>
                    </tr>  
                    <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">
                      <td class="left">首字母拼音</td>
                      <td><input type="text" name="pin" id="pin" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['pin'];?>
" class="skey" style="width:150px;" ></td>
                    </tr> 
                    <tr onmouseover="this.bgColor='#F5F5F5';" onmouseout="this.bgColor='ffffff';" bgcolor="ffffff">
                      <td class="left">排序ID</td>
                      <td><input type="text" name="orderid" id="orderid" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['orderid'];?>
" class="skey" style="width:150px;" ></td>
                    </tr> 
                   
                    
                    <input type="hidden" name="uid" id="uid" value="<?php echo $_smarty_tpl->tpl_vars['info']->value['id'];?>
" class="skey" style="width:150px;"> 
                  </tbody> 
                </table>
              </div>
              <div class="blank20"></div> 
               <input type="submit" value="确认提交" class="button">  
			    <div style="height:400px; padding-left: 150px;padding-top: 20px; line-height: 30px;" class="blank20">
				<p><b style="color:red;font-size:15px" >添加城市注意事项：</span></b>
				<p>添加的城市之间可以级别不同，<span style="color:red">但不能存在直接管辖关系。</span></p>
				<p>举例：</p>
				<p>【北京市】&nbsp;&nbsp;&nbsp;【海淀区】 &nbsp;(海淀区隶属北京市管辖) </p>
				<p>【上海市】&nbsp;&nbsp;&nbsp;【黄浦区】 &nbsp;(黄浦区隶属上海市管辖) </p>
				<p>由于【海淀区】属于【北京市】直接管辖，所以两者不能共存。</p>
				<p>同理【黄埔区】属于【上海市】直接管辖，所以两者不能共存。</p>
				<p>但是，【北京市】和【黄浦区】可以共存，【上海市】和【海淀区】可以共存，</p>
				<p>因为他们虽然级别不同，但是不存在直接管辖关系。</p>
				<p>【海淀区】 【黄浦区】也可以共存，因为他们之间不存在直接管辖关系</p>
				 
				
				
				
				
				</div> 
			   
            </form>
          </div>
        </div>
        <div class="blank20"></div> 
      
      </div>
      <div class="clear"></div>
    </div>
    
    
    
  </div> 
<script>
var biaoqianval = false;
function bqzhi(){
	biaoqianval  = false;
}
$("#searchKeywords").bind('click',function(e){
searchAdCodelist();  
});
$("#searchKeywords").bind('keyup',function(e){
					if(biaoqianval == false){
						biaoqianval  = true;
						setTimeout("bqzhi()", 500 ); 
						 
							searchAdCodelist();	 
					
					
					}
				});

function searchAdCodelist(){


	var searchval  = $("#searchKeywords").val();
 								if( searchval != '' && searchval != undefined ){
									$('#adrcodeList').show();
									$('#adrcodeList ul').html('');
									var info = {'searchval':searchval}; 
									var url = '<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/station/module/getcitylist/datatype/json"),$_smarty_tpl);?>
';
									  var backdata = ajaxback(url,info); 
									  if(backdata.flag == false){ 
											console.log(backdata.content);
											var adrcodelist = backdata.content;
											if( adrcodelist.length > 0 ){
												var htmls = '';
												$.each(adrcodelist, function(i, newobj) {
												  htmls += '<li adcode="'+newobj.id+'" procode="'+newobj.pid+'"  name="'+newobj.name+'" >'+newobj.name+'</li>';
												});
												console.log(htmls);
												$('#adrcodeList ul').html(htmls);
												
												$('#adrcodeList ul li').click(function(){
													var adcode = $(this).attr('adcode');
													var procode = $(this).attr('procode');
													var addname = $(this).attr('name');
													if( adcode != '' && procode != '' && addname != ''  ){
														$("#searchKeywords").val(addname);
														$('input[name="adcode"]').val(adcode);
														$('input[name="procode"]').val(procode);
														$('#adrcodeList').hide();
													}
												});
												
											}else{
												$('#adrcodeList ul').html('<li adcode="0" procode="0" >未从省市区标准区域找到有关搜索的区域</li>');
											}
											
									  }else{
 										 diaerror(backdata.content);
									  } 
								} else{
									$('#adrcodeList').hide();
								}


}				
				
				
	 function addimg()
	 {
	 	 var panduan = $("#parent_id  option:selected").val(); 
	 	 if(panduan == 0)
	 	 {
	 	 	showupload();
	 	 }else{
	 	 	hideupload();
	  	} 
	 }
	 function showupload()
	 {
	 	  $('#imgdo').show();
	 }
	 function hideupload()
	 {
	 	  $('#imgdo').hide();
	 }
	 var dialogs ;
 function uploads(){  
 	  dialogs = art.dialog.open('<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/other/module/adminupload/func/uploadsucess"),$_smarty_tpl);?>
');
 	  dialogs.title('上传图片'); 
 } 
 function uploadsucess(flag,obj,linkurl){
 	 if(flag == true){
 		alert(linkurl);
		dialogs.close();
		uploads();
 	 }else{ 
 		dialogs.close();
 	  $('#imgurl').val(linkurl);
 	  $('#imgshow').attr('src',linkurl);
 	  $('#imgshow').show(); 
   }
 } 
</script>
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