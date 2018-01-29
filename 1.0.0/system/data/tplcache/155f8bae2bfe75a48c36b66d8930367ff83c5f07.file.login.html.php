<?php /* Smarty version Smarty-3.1.8, created on 2017-11-27 09:01:04
         compiled from "D:\WWW\48ym\themes\default\biz/account/login.html" */ ?>
<?php /*%%SmartyHeaderCode:15255a1b63d0b56333-53808925%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '155f8bae2bfe75a48c36b66d8930367ff83c5f07' => 
    array (
      0 => 'D:\\WWW\\48ym\\themes\\default\\biz/account/login.html',
      1 => 1461032160,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15255a1b63d0b56333-53808925',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'VER' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a1b63d0ba4540_49156424',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a1b63d0ba4540_49156424')) {function content_5a1b63d0ba4540_49156424($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\WWW\\48ym\\system\\plugins/smarty\\function.link.php';
?><!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo L('商户管理中心登录');?>
</title>
    <script type="text/javascript"  src="http://apps.bdimg.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/kt.js?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"></script>
    <script type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/jBox/jBox.min.js?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"></script>
    <script type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/layer/layer.js?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"></script>
    <script type="text/javascript"  src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/widget.msgbox.js?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"></script>
    <link type="text/css" rel="stylesheet" href="/themes/default/biz/static/css/login.css">
</head>
<body>
<iframe id="miniframe" name="miniframe" style="display:none;"></iframe>
	<div class="login_cont">
		<div class="login">
			<h2><?php echo L('登录');?>
</h2>
			<form action="<?php echo smarty_function_link(array('ctl'=>'biz/account:login'),$_smarty_tpl);?>
" mini-form="biz-form" method="post">
			<input type="text" name="data[mobile]" class="text" placeholder="<?php echo L('请输入手机号');?>
">
			<input type="password" name="data[passwd]" class="text" placeholder="<?php echo L('请输入密码');?>
">
			<div class="login_link">
				<div class="lt ruzhu">
					<a href="<?php echo smarty_function_link(array('ctl'=>'biz/account:signup'),$_smarty_tpl);?>
"><?php echo L('申请入驻');?>
</a>
				</div>
				<div class="rt password">
					<a href="<?php echo smarty_function_link(array('ctl'=>'biz/account:forgot'),$_smarty_tpl);?>
"><?php echo L('忘记密码');?>
?</a>
				</div>
				<div class="cl"></div>
			</div>
			<input type="submit" class="btn" value="<?php echo L('登录');?>
">
			</form>
		</div>
	</div>
</body>
</html>
<?php }} ?>