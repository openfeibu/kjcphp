<?php /* Smarty version Smarty-3.1.10, created on 2018-04-16 22:35:47
         compiled from "C:\UPUPW_K2.1\htdocs\kjc\2.0.0\templates\m7\public\error.html" */ ?>
<?php /*%%SmartyHeaderCode:308775ad4b4c3b9f4d3-82044348%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b920afcc4ed3c6d0daeb10d24111dd55d6bcdbd3' => 
    array (
      0 => 'C:\\UPUPW_K2.1\\htdocs\\kjc\\2.0.0\\templates\\m7\\public\\error.html',
      1 => 1520874031,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '308775ad4b4c3b9f4d3-82044348',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'msg' => 0,
    'errorlink' => 0,
    'siteurl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_5ad4b4c3bfada9_92755364',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5ad4b4c3bfada9_92755364')) {function content_5ad4b4c3bfada9_92755364($_smarty_tpl) {?>
						<div style="float:left;margin-right: 10px;">
							<span class="hc_login_div_span">错误提示信息：</span>
						    <?php echo $_smarty_tpl->tpl_vars['msg']->value;?>
<br>
							<p class="tip" style="margin-left:100px;"><a href="<?php echo $_smarty_tpl->tpl_vars['errorlink']->value;?>
">返回上一页</a>  <span style="margin-left:100px;"><a href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
">返回首页</a></span></p>
						</div>
<?php }} ?>