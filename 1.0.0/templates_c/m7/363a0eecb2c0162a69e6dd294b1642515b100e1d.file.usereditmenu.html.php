<?php /* Smarty version Smarty-3.1.10, created on 2018-02-01 10:41:31
         compiled from "D:\UPUPW_K2.1\htdocs\wmr87\templates\m7\shopcenter\usereditmenu.html" */ ?>
<?php /*%%SmartyHeaderCode:72285a727e5b057429-07210849%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '363a0eecb2c0162a69e6dd294b1642515b100e1d' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\m7\\shopcenter\\usereditmenu.html',
      1 => 1483080008,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '72285a727e5b057429-07210849',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'urlshort' => 0,
    'siteurl' => 0,
    'tempdir' => 0,
    'shopinfo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_5a727e5b4200a8_89492441',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a727e5b4200a8_89492441')) {function content_5a727e5b4200a8_89492441($_smarty_tpl) {?> <div class="waimaiset"> 
	<div class="jbset <?php if ($_smarty_tpl->tpl_vars['urlshort']->value=='shopcenter/useredit'){?> onset<?php }?>" onclick="openlink('<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/useredit"),$_smarty_tpl);?>
');">
                	<img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/images/jbBg.png" /><span>基本设置</span>
                </div>
                <?php if (empty($_smarty_tpl->tpl_vars['shopinfo']->value['shoptype'])){?>
                <div  class="jbset <?php if ($_smarty_tpl->tpl_vars['urlshort']->value=='shopcenter/usershopfast'){?> onset<?php }?>" onclick="openlink('<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/usershopfast"),$_smarty_tpl);?>
');" >
                	<img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/images/wmset.png" /><span>外卖设置</span>
                </div>
                <?php }else{ ?>
                <div  class="jbset <?php if ($_smarty_tpl->tpl_vars['urlshort']->value=='shopcenter/usershopmarket'){?> onset<?php }?>"   onclick="openlink('<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/usershopmarket"),$_smarty_tpl);?>
')">
                	<img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/images/wmset.png" /><span>超市市场</span>
                </div>
                
                <?php }?> 
                <div class="jbset <?php if ($_smarty_tpl->tpl_vars['urlshort']->value=='shopcenter/usershopinstro'){?> onset<?php }?>" onclick="openlink('<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/usershopinstro"),$_smarty_tpl);?>
');">
                	<img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/images/dianpujieshao.png" /><span>店铺介绍</span>
                </div>
                <div class="jbset <?php if ($_smarty_tpl->tpl_vars['urlshort']->value=='shopcenter/usershopnotice'){?> onset<?php }?>" onclick="openlink('<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/usershopnotice"),$_smarty_tpl);?>
');">
                	<img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/images/gonggao.png" /><span>店铺公告</span>
                </div>
                 <div class="jbset <?php if ($_smarty_tpl->tpl_vars['urlshort']->value=='shopcenter/usershopreal'){?> onset<?php }?>" onclick="openlink('<?php echo FUNC_function(array('type'=>'url','link'=>"/shopcenter/usershopreal"),$_smarty_tpl);?>
');">
                 <img src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/shopcenter/images/dianpujieshao.png" /><span>商家实景</span>
                 </div>
              </div>
<script>       	
				$(function(){
					$(".waimaiset .jbset").click(function(){
						$(this).css('background','#ec7501').siblings().css('background','');
						
					});	
					
				});
 </script>
       	 
       		 <?php }} ?>