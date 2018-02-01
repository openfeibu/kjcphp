<?php /* Smarty version Smarty-3.1.10, created on 2017-11-23 17:55:10
         compiled from "D:\wwwroot\wm87_demo\web\templates\adminpage\weixin\ztymodehtml.html" */ ?>
<?php /*%%SmartyHeaderCode:52525a169afe84cc97-84356817%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '485b7ef261a6be4bbc1c571b6478b59bc42c2fb5' => 
    array (
      0 => 'D:\\wwwroot\\wm87_demo\\web\\templates\\adminpage\\weixin\\ztymodehtml.html',
      1 => 1508237057,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '52525a169afe84cc97-84356817',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ztymode' => 0,
    'list' => 0,
    'siteurl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_5a169afe9fbd84_14596862',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a169afe9fbd84_14596862')) {function content_5a169afe9fbd84_14596862($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['ztymode']->value['type']==1){?>
<ul id="zty_style1" style="padding:8px;height:180px;"  >
    <li style="width:49.28%;height:95px;float:left"><img src="<?php if (!empty($_smarty_tpl->tpl_vars['list']->value[0]['ztyimg'])){?><?php echo $_smarty_tpl->tpl_vars['list']->value[0]['ztyimg'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/images/t1_01.png<?php }?>" alt=""></li>
    <li style="width:49.28%;height:95px;float:left;margin-left:3px;"><img src="<?php if (!empty($_smarty_tpl->tpl_vars['list']->value[1]['ztyimg'])){?><?php echo $_smarty_tpl->tpl_vars['list']->value[1]['ztyimg'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/images/t1_02.png<?php }?>" alt=""></li>
    <li style="width:32.28%;height:85px;float:left;margin-top:3px;"><img src="<?php if (!empty($_smarty_tpl->tpl_vars['list']->value[2]['ztyimg'])){?><?php echo $_smarty_tpl->tpl_vars['list']->value[2]['ztyimg'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/images/t1_03.png<?php }?>" alt=""></li>
    <li style="width:32.28%;height:85px;float:left;margin-top:3px;margin-left:3px;"><img src="<?php if (!empty($_smarty_tpl->tpl_vars['list']->value[3]['ztyimg'])){?><?php echo $_smarty_tpl->tpl_vars['list']->value[3]['ztyimg'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/images/t1_04.png<?php }?>" alt=""></li>
    <li style="width:32.28%;height:85px;float:left;margin-top:3px;margin-left:3px;"><img src="<?php if (!empty($_smarty_tpl->tpl_vars['list']->value[4]['ztyimg'])){?><?php echo $_smarty_tpl->tpl_vars['list']->value[4]['ztyimg'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/images/t1_05.png<?php }?>" alt=""></li>
</ul>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['ztymode']->value['type']==2){?>
<ul id="zty_style2" style="padding:8px;height:100px;" >
    <li style="width:49.28%;float:left;height:50px"><img src="<?php if (!empty($_smarty_tpl->tpl_vars['list']->value[0]['ztyimg'])){?><?php echo $_smarty_tpl->tpl_vars['list']->value[0]['ztyimg'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/images/t2_01.png<?php }?>" alt=""></li>
    <li style="width:49.28%;float:right;height:50px"><img src="<?php if (!empty($_smarty_tpl->tpl_vars['list']->value[1]['ztyimg'])){?><?php echo $_smarty_tpl->tpl_vars['list']->value[1]['ztyimg'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/images/t2_02.png<?php }?>" alt=""></li>
    <li style="width:49.28%;float:left;margin-top:3px;height:50px"><img src="<?php if (!empty($_smarty_tpl->tpl_vars['list']->value[2]['ztyimg'])){?><?php echo $_smarty_tpl->tpl_vars['list']->value[2]['ztyimg'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/images/t2_03.png<?php }?>" alt=""></li>
    <li style="width:49.28%;float:right;margin-top:3px;height:50px"><img src="<?php if (!empty($_smarty_tpl->tpl_vars['list']->value[3]['ztyimg'])){?><?php echo $_smarty_tpl->tpl_vars['list']->value[3]['ztyimg'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/images/t2_04.png<?php }?>" alt=""></li>
</ul>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['ztymode']->value['type']==3){?>
<ul id="zty_style3" style="padding:8px;height:100px;" >
    <li style="width:49.28%;float:left;height:100px"><img src="<?php if (!empty($_smarty_tpl->tpl_vars['list']->value[0]['ztyimg'])){?><?php echo $_smarty_tpl->tpl_vars['list']->value[0]['ztyimg'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/images/t3_01.png<?php }?>" alt=""></li>
    <li style="width:49.28%;float:right;height:49px"><img src="<?php if (!empty($_smarty_tpl->tpl_vars['list']->value[1]['ztyimg'])){?><?php echo $_smarty_tpl->tpl_vars['list']->value[1]['ztyimg'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/images/t3_02.png<?php }?>" alt=""></li>
    <li style="width:49.28%;float:right;margin-top:3px;height:49px"><img src="<?php if (!empty($_smarty_tpl->tpl_vars['list']->value[2]['ztyimg'])){?><?php echo $_smarty_tpl->tpl_vars['list']->value[2]['ztyimg'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/adminpage/public/images/t3_02.png<?php }?>" alt=""></li>
</ul>
<?php }?><?php }} ?>