<?php /* Smarty version Smarty-3.1.10, created on 2018-04-16 22:44:16
         compiled from "C:\UPUPW_K2.1\htdocs\kjc\2.0.0\templates\m7\shopcenter\cxrule.html" */ ?>
<?php /*%%SmartyHeaderCode:113865ad4b6c0555792-53176193%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8c3f971106e33dbf0a8e1000dae76d0deae2dbb9' => 
    array (
      0 => 'C:\\UPUPW_K2.1\\htdocs\\kjc\\2.0.0\\templates\\m7\\shopcenter\\cxrule.html',
      1 => 1521801271,
      2 => 'file',
    ),
    'c5f459e29195fda36db88d6eae59d180bee153e0' => 
    array (
      0 => 'C:\\UPUPW_K2.1\\htdocs\\kjc\\2.0.0\\templates\\m7\\public\\shopcenter.html',
      1 => 1521805921,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '113865ad4b6c0555792-53176193',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tempdir' => 0,
    'sitename' => 0,
    'keywords' => 0,
    'description' => 0,
    'siteurl' => 0,
    'adminshopid' => 0,
    'todayshopcost' => 0,
    'allshopcost' => 0,
    'shopinfo' => 0,
    'beian' => 0,
    'footerdata' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_5ad4b6c0efd665_64835688',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ad4b6c0efd665_64835688')) {function content_5ad4b6c0efd665_64835688($_smarty_tpl) {?><?php if (!is_callable('smarty_function_load_data')) include 'C:\\UPUPW_K2.1\\htdocs\\kjc\\2.0.0\\lib\\Smarty\\libs\\plugins\\function.load_data.php';
if (!is_callable('smarty_modifier_date_format')) include 'C:\\UPUPW_K2.1\\htdocs\\kjc\\2.0.0\\lib\\Smarty\\libs\\plugins\\modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> 商家管理中心-<?php echo $_smarty_tpl->tpl_vars['sitename']->value;?>
</title>
<meta name="Keywords" content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
" />
<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
" />
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/css/commom.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/css/shangjiaAdmin.css" />

<script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/js/jquerynew.js" type="text/javascript" language="javascript"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/js/allj.js" type="text/javascript" language="javascript"></script>
<script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/js/artdialog/artDialog.js?skin=blue"></script>

 <script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/js/artdialog/plugins/iframeTools.js"></script>
 <script>
  	  var mynomenu='basecx';
  </script> 

<script>
	var siteurl = "<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
";
</script>
<!--[if lte IE 6]>
<script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/js/DD_belatedPNG_0.0.8a.js" type="text/javascript"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('div, ul, img, li, input , a');
        $('#footer').css('display','none');
    </script>
<![endif]-->
</head>
<body >
<?php echo smarty_function_load_data(array('assign'=>"shopinfo",'table'=>"shop",'where'=>"`id`=".((string)$_smarty_tpl->tpl_vars['adminshopid']->value),'type'=>"one"),$_smarty_tpl);?>

<!-- <div style="position: fixed;top: 0;left: 0;right: 0;bottom: 0;z-index: -1;background:url('<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/images/shoplogin_bg.jpg') no-repeat center/cover;"></div> -->
<!--header start-->
	<div class="header">
    	<div class="top">
        	<div class="topLeft fl">
            	<ul>
                    <li>今日营业额：<span><?php echo $_smarty_tpl->tpl_vars['todayshopcost']->value;?>
</span>元</li>
                    <li>总营业额：<span><?php echo $_smarty_tpl->tpl_vars['allshopcost']->value;?>
</span>元</li>

                </ul>
                 <div class="cl"></div>
            </div>
            <div class="topRight fr">

                    <span class="updataPass curbtn" onclick="modifypwd();">修改密码</span>

                    <span class="username curbtn" onclick="openlink('<?php echo FUNC_function(array('type'=>'url','link'=>"/member/loginout"),$_smarty_tpl);?>
');">退出</span>


            </div>
            <div class="cl"></div>


            <div class="shangjiaTop">
            	<div class="sjgl">

                </div>

            </div>
        </div>

    </div>
    <!---header end--->

 <!------以上是公共的头部部分------->

  <!---content start--->
	<div class="content">
   	 	<!---content left start--->
		<div class="conleft content_left fl" >
        	<div class="nav">
            	<ul>
                	<li onclick="openlink('<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/useredit"),$_smarty_tpl);?>
');" data="baseset"><div class="navimg"><img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/images/dpsz.png" /></div>
					<a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/useredit"),$_smarty_tpl);?>
">店铺设置</a></li>
                    <li onclick="openlink('<?php if (empty($_smarty_tpl->tpl_vars['shopinfo']->value['shoptype'])){?><?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/goodslist"),$_smarty_tpl);?>
<?php }else{ ?><?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/marketgoodslist"),$_smarty_tpl);?>
<?php }?>');" data="basemenu"><div class="navimg"><img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/images/cdgl.png" /></div><a href="<?php if (empty($_smarty_tpl->tpl_vars['shopinfo']->value['shoptype'])){?><?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/goodslist"),$_smarty_tpl);?>
<?php }else{ ?><?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/marketgoodslist"),$_smarty_tpl);?>
<?php }?>">菜单管理</a></li>
					<li onclick="openlink('<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/cxrule"),$_smarty_tpl);?>
');"  data="basecx"><div class="navimg"><img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/images/xxgz.png" /></div>
					<a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/cxrule"),$_smarty_tpl);?>
">促销规则</a></li>
                    <li onclick="openlink('<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/shoporderlist"),$_smarty_tpl);?>
');" data="baseorder"><div class="navimg"><img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/images/ddgl.png" /></div>
					<a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/shoporderlist"),$_smarty_tpl);?>
">订单管理</a></li>
                    <li onclick="openlink('<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/shoptotal"),$_smarty_tpl);?>
');" data="baseordertj"><div class="navimg"><img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/images/ddtj.png" /></div>
					<a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/shoptotal"),$_smarty_tpl);?>
">订单统计</a></li>
                     <li onclick="openlink('<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/txlog"),$_smarty_tpl);?>
');" data="baseorderjl"><div class="navimg"><img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/images/ddtj.png" /></div>
                    <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/txlog"),$_smarty_tpl);?>
">金额记录</a></li>
                     <li onclick="openlink('<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/shopjs"),$_smarty_tpl);?>
');" data="baseorderjs"><div class="navimg"><img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/images/ddtj.png" /></div>
                    <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/shopjs"),$_smarty_tpl);?>
">结算记录</a></li>

					<li onclick="openlink('<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/shoptxlog"),$_smarty_tpl);?>
');" data="shoptxlog"><div class="navimg"><img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/images/ddtj.png" /></div>
				   <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/shoptxlog"),$_smarty_tpl);?>
">提现记录</a></li>


                    <li onclick="openlink('<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/shoptx"),$_smarty_tpl);?>
');"  data="basetx"><div class="navimg"><img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/images/dianpujieshao.png" /></div>
                    <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/shoptx"),$_smarty_tpl);?>
">提现</a></li>
                    <li onclick="openlink('<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/shoptxxg"),$_smarty_tpl);?>
');"  data="basetxxg"><div class="navimg"><img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/images/dianpujieshao.png" /></div>
                    <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/shoptxxg"),$_smarty_tpl);?>
">提现信息修改</a></li>

                </ul>

            </div>
        </div>
       <!---content left end--->





           
 

 
  <!---content right start---> 
        <div class="conWaiSet fr">
        	
          
            <div class="cxruleset" style="height: 120px;font-size:12px;color:#fff">
            	<div class="cxrule_btn">
                 
                    <div class="cxruleButton" onclick="openlink('<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/addcxrule"),$_smarty_tpl);?>
');"></div>					
					<div style='margin-top:12px'>提示：满减活动可店家自行设置，也可以平台进行设置，同时生效<br>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;同类型的规则取优惠金额最大的使用。</div>
                </div>
                
                  <div class="cl"></div>
            </div>
             <div class="cl"></div>
                       
                <form action="" method="post">
                 <div class="caidanSet">
        			
                    
                
                	<div class="div_orderList">
                    	
                        <div class="cxrule_show">
                    
                        <div class="cxrule_show_goodli">
						   
                            <div class="cxrule_goodname" style='width:110px'>
                                <span>活动类型</span>
                            </div>
                            <div class="cxrule_shuoming" style='width:290px'>
                                 <span>规则说明</span>
                            </div>
                            <div class="cxrule_pri" style='width:350px'>
                                 <span>活动时间</span>
                            </div>                            
                            <div class="cxrule_day_num" style='width:100px'>
                                 <span>状态</span>
                            </div>
                             <div class="cxrule_cz" style='width:150px'>
                                 <span>操作</span>
                            </div>
                        </div>
                        
                        <div class="cl"></div>
                        
                        
                    	<div class="cxrule_list	">
                       		 
                          	 
                <?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_smarty_tpl->tpl_vars['myid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['rulelist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
 $_smarty_tpl->tpl_vars['myid']->value = $_smarty_tpl->tpl_vars['items']->key;
?>  
                          
                          <div class="cxrule_goodlist">
						     
                            <div class="cxrule_name" style="overflow: hidden;width:109px">
                                <span>
								<?php if ($_smarty_tpl->tpl_vars['items']->value['controltype']==1){?>满赠活动<?php }?>
								<?php if ($_smarty_tpl->tpl_vars['items']->value['controltype']==2){?>满减活动<?php }?>
								<?php if ($_smarty_tpl->tpl_vars['items']->value['controltype']==3){?>折扣活动<?php }?>
								<?php if ($_smarty_tpl->tpl_vars['items']->value['controltype']==4){?>免配送费<?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['items']->value['controltype']==5){?>首单立减<?php }?>								
								</span>
                            </div>
                            <div class="cxrule_sm" style='width:289px'>
                                 <span id="showrule_<?php echo $_smarty_tpl->tpl_vars['items']->value['id'];?>
" data=""></span>
                            </div>
                            <div class="cxrule_price" style='width:350px'>
                                 <span>
								 <?php if ($_smarty_tpl->tpl_vars['items']->value['limittype']==1){?>不限制<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['items']->value['limittype']==2){?>每周(星期<?php echo $_smarty_tpl->tpl_vars['items']->value['limittime'];?>
)<?php }?>
						<?php if ($_smarty_tpl->tpl_vars['items']->value['limittype']==3){?>从 <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['items']->value['starttime'],"Y-m-d H:i:s");?>
 至 <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['items']->value['endtime'],"Y-m-d H:i:s");?>
<?php }?>
								 
								 </span>
                            </div>                           
                            <div class="cxrule_dayNum" style='width:100px'>
                                 <span> 								  
									<?php if ($_smarty_tpl->tpl_vars['items']->value['status']==1&&$_smarty_tpl->tpl_vars['items']->value['limittype']==3&&$_smarty_tpl->tpl_vars['items']->value['starttime']>time()){?>待生效<?php }?>	
									<?php if ($_smarty_tpl->tpl_vars['items']->value['status']==1&&($_smarty_tpl->tpl_vars['items']->value['limittype']<3||($_smarty_tpl->tpl_vars['items']->value['limittype']==3&&$_smarty_tpl->tpl_vars['items']->value['endtime']>time()&&$_smarty_tpl->tpl_vars['items']->value['starttime']<time()))){?>进行中<?php }?>	
									<?php if ($_smarty_tpl->tpl_vars['items']->value['status']==0||($_smarty_tpl->tpl_vars['items']->value['limittype']==3&&$_smarty_tpl->tpl_vars['items']->value['endtime']<time())){?>已结束<?php }?>
						       </span>
                            </div>
							<!--已结束的不能编辑  只能删除-->
                             <div class="cxrule_caozuo"  style='width:150px'>
							 <?php if ($_smarty_tpl->tpl_vars['items']->value['parentid']==1){?>
							     <span style=" background:#aaaaaa; padding:8px; color:#fff; ">
								 <a href="#">平台活动</a>
								 </span>
							 <?php }else{ ?>
                                 <span style=" background:#27a9e3; padding:8px; color:#fff;<?php if ($_smarty_tpl->tpl_vars['items']->value['status']==0||($_smarty_tpl->tpl_vars['items']->value['limittype']==3&&$_smarty_tpl->tpl_vars['items']->value['endtime']<time())){?>display:none<?php }?>">
								 <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/addcxrule/id/".((string)$_smarty_tpl->tpl_vars['items']->value['id'])),$_smarty_tpl);?>
">编辑</a>
								 </span>
                                  <span style=" background:#ec7501; padding:8px; color:#fff;margin-left: 10px;">
								  <a onclick="return remind(this);"href="<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/delcxrule/cxid/".((string)$_smarty_tpl->tpl_vars['items']->value['id'])."/datatype/json"),$_smarty_tpl);?>
"> 删除</a></span>
								  <?php }?>
                            </div>
                          </div>
                    
                        
                        
                     <?php } ?> 
                      
                      
                    </div>
                        <div class="cl"></div>
                        
                        
                    </div>
         
                    </div>
                    
       			 </div>
                 
                 
              </form>  
                
                
        </div>
        <div class="cl"></div>

<script>
	var alllist = <?php echo json_encode($_smarty_tpl->tpl_vars['rulelist']->value);?>
;
$(function(){  
	$.each(alllist,function(i,field){
         
		var showcontent = '';	
		if(field.supporttype == 2){
			showcontent1 ='在线支付满';
		}else{
			showcontent1 ='订单满';
		} 		 
		if(field.controltype ==  1){
			showcontent +=showcontent1+''+field.limitcontent+'赠送'+field.presenttitle;
		}
		if(field.controltype ==  2){
			showcontent +=field.name;
		}
		if(field.controltype ==  3){
			var times = field.controlcontent*0.1;
			showcontent +=showcontent1+''+field.limitcontent+'享受'+times+'折优惠';
		}
		if(field.controltype ==  4){
			showcontent +=showcontent1+''+field.limitcontent+'免基础配送费';
		}
		if(field.controltype ==  5){
			showcontent +='新用户下单立减'+field.controlcontent+'元';
		}
		 
		
		 $('#showrule_'+field.id).text(showcontent);
	});
	
});
	
</script>








       </div>




<!------以下是公共的底部部分------->

    <div class="footer">

        <div class="foot2">
        	<p>@2018-2018 <?php echo $_smarty_tpl->tpl_vars['sitename']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['beian']->value;?>
 <?php echo stripslashes($_smarty_tpl->tpl_vars['footerdata']->value);?>
</p>
        </div>
    </div>

 <script>

$(function(){

	if("undefined" != typeof mynomenu){
	   var allobj = $('.nav').find('li');
	  $.each(allobj, function(i, newobj) {
	  	if($(this).attr('data') == mynomenu){
	  	   $(this).addClass('on');
	  	 }
	  	//alert($(this).attr('data'));

	  });
 	}
	$(".nav ul li").click(function(){
	    	$(this).addClass('on').siblings().removeClass('on');

	});
});
function openlink(newlinkes){
	window.location.href=newlinkes;
}
function modifypwd()
{
	var showcontent = '<form method="post" name="form1" action="'+siteurl+'/index.php?ctrl=shopcenter&action=updatepwd&datatype=json" onsubmit="return subform(\'\',this);"><div>旧密码:<input type="password" name="oldpwd" value=""></div><div style="padding-top:10px;">新密码:<input type="password" name="pwd" value=""></div><div style="padding-top:10px;padding-left:30px;"><input type="submit" value="确认提交" class="button"> </div> </form>';
	art.dialog({
    id: 'KDf435',
    title: '修改账号密码',
    content: showcontent
  });
}
</script>

</body>
</html>
<?php }} ?>