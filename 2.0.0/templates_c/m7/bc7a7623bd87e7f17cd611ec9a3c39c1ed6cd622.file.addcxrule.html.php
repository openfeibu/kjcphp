<?php /* Smarty version Smarty-3.1.10, created on 2018-04-16 22:44:19
         compiled from "C:\UPUPW_K2.1\htdocs\kjc\2.0.0\templates\m7\shopcenter\addcxrule.html" */ ?>
<?php /*%%SmartyHeaderCode:298715ad4b6c3bc56c8-20817769%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bc7a7623bd87e7f17cd611ec9a3c39c1ed6cd622' => 
    array (
      0 => 'C:\\UPUPW_K2.1\\htdocs\\kjc\\2.0.0\\templates\\m7\\shopcenter\\addcxrule.html',
      1 => 1520562874,
      2 => 'file',
    ),
    'c5f459e29195fda36db88d6eae59d180bee153e0' => 
    array (
      0 => 'C:\\UPUPW_K2.1\\htdocs\\kjc\\2.0.0\\templates\\m7\\public\\shopcenter.html',
      1 => 1521805921,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '298715ad4b6c3bc56c8-20817769',
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
  'unifunc' => 'content_5ad4b6c4686a64_61926674',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ad4b6c4686a64_61926674')) {function content_5ad4b6c4686a64_61926674($_smarty_tpl) {?><?php if (!is_callable('smarty_function_load_data')) include 'C:\\UPUPW_K2.1\\htdocs\\kjc\\2.0.0\\lib\\Smarty\\libs\\plugins\\function.load_data.php';
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
<script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/js/datepicker/WdatePicker.js" type="text/javascript" language="javascript"></script>


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





           
        <div class="conWaiSet fr">
            <div class="shopSetTop">
            	<span><?php if (empty($_smarty_tpl->tpl_vars['cxinfo']->value)){?>添加<?php }else{ ?>编辑<?php }?>促销规则列表</span>
            </div>
           <form id="loginForm" method="post" action="<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/savecxrule/datatype/json"),$_smarty_tpl);?>
" >
                 <div class="jutiSet">
             <!---------------------促销类型开始----------------------->
					<div class="serxuanze">
                    	<div class="xuanze_left">
                        	<span>促销类型：</span>
                        </div>
                        <div class="xuanze_right">
                        	<select name="controltype" id="controltype" onchange="changetxt(this)" style="height:42px;;width:124px;">
                                <option value="2"   <?php if ($_smarty_tpl->tpl_vars['cxinfo']->value['controltype']==2){?>selected<?php }?>>满减活动</option>
		 
						    </select>
                        </div>
                        <div class="cl"></div>
                    </div>
			 <!----------------------促销类型结束---------------------->
			
			 <!----------------------活动规则开始---------------------->
                    <div class="serxuanze" style='height: fit-content;'>
                    	<div class="xuanze_left">
                        	<span>活动规则：</span>
                        </div>
				<!--------1满赠活动--------->
                        <div class="xuanze_right action action_1" style='display:none' >
                        	订单满 
							<input type="text" style=" width:50px;margin-top:5px;height:30px;line-height:30px;" id="limitcontent_1" name="limitcontent_1" value="<?php echo $_smarty_tpl->tpl_vars['cxinfo']->value['limitcontent'];?>
" >
							 元，赠送 
							<input type="text" placeholder="请输入赠品名称及赠送数量" style=" width:200px;margin-top:5px;height:30px;line-height:30px;" id="presenttitle" name="presenttitle" value="<?php echo $_smarty_tpl->tpl_vars['cxinfo']->value['presenttitle'];?>
" >
                        </div>						
				<!--------2满赠活动--------->
						<div class="xuanze_right action action_2" style='height:auto;display:none' >
                        	
						<?php $_smarty_tpl->tpl_vars['limitcontent'] = new Smarty_variable(explode(",",$_smarty_tpl->tpl_vars['cxinfo']->value['limitcontent']), null, 0);?>
					    <?php $_smarty_tpl->tpl_vars['controlcontent'] = new Smarty_variable(explode(",",$_smarty_tpl->tpl_vars['cxinfo']->value['controlcontent']), null, 0);?>
					 <?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['limitcontent']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['items']->key;
?>
					      <?php if ($_smarty_tpl->tpl_vars['keys']->value==0){?>
							订单满 <input type="text" style=" width:50px;margin-top:5px;height:30px;line-height:30px;" id="limitcontent_2" name="limitcontent_2[]" value="<?php echo $_smarty_tpl->tpl_vars['items']->value;?>
" >
                             减 <input type="text" style=" width:50px;margin-top:5px;height:30px;line-height:30px;" id="controlcontent_2" name="controlcontent_2[]" value="<?php echo $_smarty_tpl->tpl_vars['controlcontent']->value[$_smarty_tpl->tpl_vars['keys']->value];?>
" ><span class='addmj' style="color: yellow;margin-left: 20px;">+添加规则</span>
						  <?php }?>
					 <?php } ?>  
					 <?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_smarty_tpl->tpl_vars['keys'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['limitcontent']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
 $_smarty_tpl->tpl_vars['keys']->value = $_smarty_tpl->tpl_vars['items']->key;
?>
					      <?php if ($_smarty_tpl->tpl_vars['keys']->value>0){?>
					         <span id="count_<?php echo $_smarty_tpl->tpl_vars['keys']->value;?>
"><br>订单满 <input type="text" style=" width:50px;margin-top:5px;height:30px;line-height:30px;" id="limitcontent_2" name="limitcontent_2[]" value="<?php echo $_smarty_tpl->tpl_vars['items']->value;?>
" >
                             减 <input type="text" style=" width:50px;margin-top:5px;height:30px;line-height:30px;" id="controlcontent_2" name="controlcontent_2[]" value="<?php echo $_smarty_tpl->tpl_vars['controlcontent']->value[$_smarty_tpl->tpl_vars['keys']->value];?>
" ><span data="<?php echo $_smarty_tpl->tpl_vars['keys']->value;?>
" class="delmj" style="color:red; margin-left: 20px;">删除</span></span>
				           <?php }?>
					  <?php } ?>
							
                        </div>
				<!--------3折扣活动--------->				
						<div class="xuanze_right action action_3"  style='display:none' >
                        	订单满 
							<input type="text" style=" width:50px;margin-top:5px;height:30px;line-height:30px;" id="limitcontent_3" name="limitcontent_3" value="<?php echo $_smarty_tpl->tpl_vars['cxinfo']->value['limitcontent'];?>
" >
                            元，享受
							<input type="text" style=" width:50px;margin-top:5px;height:30px;line-height:30px;" id="controlcontent_3" name="controlcontent_3" value="<?php echo $_smarty_tpl->tpl_vars['cxinfo']->value['controlcontent'];?>
" > 折优惠（录入80即表示8折优惠）
                        </div>
				<!--------4免配送费--------->				 
						<div class="xuanze_right action action_4"  style='display:none' >
                        	订单满 <input type="text" style=" width:50px;margin-top:5px;height:30px;line-height:30px;" id="limitcontent_4" name="limitcontent_4" value="<?php echo $_smarty_tpl->tpl_vars['cxinfo']->value['limitcontent'];?>
" >
                            元，免基础配送费 （不包含附加配送费，减免的配送费全部由店铺自行承担）
                        </div>			 
						 
                        <div class="cl"></div>
                    </div>
             <!----------------------活动规则结束---------------------->
                    <div class="serxuanze">
                    	<div class="xuanze_left">
                        	<span>具体时间：</span>
                        </div>
                        <div class="xuanze_right fb_radio">
                        	<input type="radio" name="limittype" value="1" checked><span>不限制 </span>
                        	<input type="radio" name="limittype" value="2" <?php if ($_smarty_tpl->tpl_vars['cxinfo']->value['limittype']==2){?>checked<?php }?>><span>每周</span>
                        	<input type="radio" name="limittype" value="3" <?php if ($_smarty_tpl->tpl_vars['cxinfo']->value['limittype']==3){?>checked<?php }?>><span>自定义</span>


                        </div>
                        <div class="cl"></div>
                    </div>

                     <div class="serxuanze" id="limittime1" style="display:none;">
                    	<div class="xuanze_left">
                        	<span>选择星期：</span>
                        </div>
                        <div class="xuanze_right fb_radio">
                        	<?php $_smarty_tpl->tpl_vars['mysign'] = new Smarty_variable(explode(",",$_smarty_tpl->tpl_vars['cxinfo']->value['limittime']), null, 0);?>
                        	<?php $_smarty_tpl->tpl_vars['signshu'] = new Smarty_variable("1", null, 0);?>
                          <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['name'] = 'loop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'] = is_array($_loop=7) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['loop']['total']);
?>
                  	          <input type="checkbox" name="limittime1[]" value="<?php echo $_smarty_tpl->tpl_vars['signshu']->value;?>
" <?php if (in_array($_smarty_tpl->tpl_vars['signshu']->value,$_smarty_tpl->tpl_vars['mysign']->value)){?>checked<?php }?>> <span>星期<?php if ($_smarty_tpl->tpl_vars['signshu']->value==7){?>天<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['signshu']->value;?>
</span><?php }?>
                  	          <?php $_smarty_tpl->tpl_vars['signshu'] = new Smarty_variable($_smarty_tpl->tpl_vars['signshu']->value+1, null, 0);?>
                         <?php endfor; endif; ?>
                        </div>
                        <div class="cl"></div>
                    </div>

                    <div id="limittime2">


                    	 
                        	  	     <div class="serxuanze">
                    	  <div class="xuanze_left">
                        	<span>选择时间：</span>
                        </div>
                        <div class="xuanze_right">
                        	从 <input class="Wdate datefmt" type="text" name="starttime" id="starttime" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['cxinfo']->value['starttime'],"%Y-%m-%d");?>
"  onFocus="WdatePicker({isShowClear:false,readOnly:true});" />
                        	至 <input class="Wdate datefmt" type="text" name="endtime" id="endtime" value="<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['cxinfo']->value['endtime'],"%Y-%m-%d");?>
"  onFocus="WdatePicker({isShowClear:false,readOnly:true});" />
                        </div>
                         <div class="cl"></div>
                      </div>
                        	  	    
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['cxinfo']->value['status']==1&&$_smarty_tpl->tpl_vars['cxinfo']->value['limittype']<3||($_smarty_tpl->tpl_vars['cxinfo']->value['limittype']==3&&$_smarty_tpl->tpl_vars['cxinfo']->value['endtime']>time()&&$_smarty_tpl->tpl_vars['cxinfo']->value['starttime']<time())){?>
                      <div class="serxuanze">
                    	<div class="xuanze_left">
                        	<span>是否撤销：</span>
                        </div>
                        <div class="xuanze_right">
                        	<input type="radio" name="status" value="1" <?php if ($_smarty_tpl->tpl_vars['cxinfo']->value['status']==1){?> checked<?php }?>>否
                        	<input type="radio" name="status" value="0" >是&nbsp;&nbsp;&nbsp;&nbsp;（活动撤销后将变为已结束状态，不可编辑，请谨慎操作）
                        </div>
                        <div class="cl"></div>
                    </div>
                    <?php }?>	

                    
                    <br><br>

                   <input type="hidden" name="cxid" value="<?php echo $_smarty_tpl->tpl_vars['cxinfo']->value['id'];?>
">

                  	 <div class="settijiao">

                          <div class="xuanze_right hc_login_btn_div"></div>


                        <div class="cl"></div>
                    </div>


       			 </div>
       			 </form>



        </div>
        <div class="cl"></div>

<script>
    var mynomenu='basecx';
	var type = <?php echo (($tmp = @$_smarty_tpl->tpl_vars['cxinfo']->value['controltype'])===null||$tmp==='' ? 0 : $tmp);?>
; 			
	
	if(type>0){	
		$('.action').hide();
		$('.action_'+type).show();
	}else{	 
		$('.action').hide();
		$('.action_1').show();
	}
	 
	
	$('.addmj').live('click',function(){
	    var mjcount = $(".delmj").length;
		if(mjcount < 3){
		    var mjhtml='<span id="count_'+mjcount+'"><br>订单满 <input type="text" style=" width:50px;margin-top:5px;height:30px;line-height:30px;" id="limitcontent_2" name="limitcontent_2[]" value="" > 减 <input type="text" style=" width:50px;margin-top:5px;height:30px;line-height:30px;" id="controlcontent_2" name="controlcontent_2[]" value="" ><span data="'+mjcount+'" class="delmj" style="color:red; margin-left: 20px;">删除</span></span>';   
		$('.action_2').append(mjhtml);
		}else{
		    alert('最多只能添加4条满减规则');
		    return false;
		}		
	})
	$('.delmj').live('click',function(){
	    var data = $(this).attr('data');		
		$('#count_'+data).remove();
	})

 </script>


<script type="text/javascript">
	$(function(){
		$("input[name='limittype']:checked").trigger("click");
		$('#controltype').trigger('change');
	});
	
	function removetime2(obj){
		$(obj).parent().parent().remove();
	}
	$("input[name='limittype']").click(function(){
		var dovalue = $(this).val();
		if(dovalue ==  2){
			 $('#limittime1').show();
			 $('#limittime2').hide();
		}else{
			 if(dovalue == 3){
			 $('#limittime1').hide();
			  $('#limittime2').show();
		}else{
			 $('#limittime1').hide();
			  $('#limittime2').hide();
		  }
		}
	});
	function changetxt(obj){
		var controltype = $(obj).find("option:selected").val();
		if(controltype == 4){
		    $('.shopps').hide()
			$('.platbili').hide()
		}else{
		    $('.shopps').show()
			$('.platbili').show()
		}
		$('.action').hide();
        $('.action_'+controltype).show();
         	
	}
	$('.hc_login_btn_div').click(function(){		 
	  subform('<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/cxrule"),$_smarty_tpl);?>
',$('#loginForm'));
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