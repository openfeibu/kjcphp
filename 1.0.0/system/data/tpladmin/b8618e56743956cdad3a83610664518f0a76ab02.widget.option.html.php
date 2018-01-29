<?php /* Smarty version Smarty-3.1.8, created on 2017-11-27 08:55:27
         compiled from "widget:default/option.html" */ ?>
<?php /*%%SmartyHeaderCode:130145a1b627f722d85-48313543%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b8618e56743956cdad3a83610664518f0a76ab02' => 
    array (
      0 => 'widget:default/option.html',
      1 => 1453183416,
      2 => 'widget',
    ),
  ),
  'nocache_hash' => '130145a1b627f722d85-48313543',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'data' => 0,
    'detail' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a1b627f72aa86_44481743',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a1b627f72aa86_44481743')) {function content_5a1b627f72aa86_44481743($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include 'D:\\WWW\\48ym\\system\\libs\\smarty\\plugins\\function.html_options.php';
?><?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['data']->value['options'],'selected'=>$_smarty_tpl->tpl_vars['data']->value['value'],'value'=>$_smarty_tpl->tpl_vars['detail']->value['value']),$_smarty_tpl);?>
<?php }} ?>