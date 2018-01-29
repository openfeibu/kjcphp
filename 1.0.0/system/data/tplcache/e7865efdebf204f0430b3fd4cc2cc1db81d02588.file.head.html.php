<?php /* Smarty version Smarty-3.1.8, created on 2017-11-27 08:55:38
         compiled from "D:\WWW\48ym\themes\ele\web\block\head.html" */ ?>
<?php /*%%SmartyHeaderCode:185485a1b628a6ac334-83486538%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e7865efdebf204f0430b3fd4cc2cc1db81d02588' => 
    array (
      0 => 'D:\\WWW\\48ym\\themes\\ele\\web\\block\\head.html',
      1 => 1474187892,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '185485a1b628a6ac334-83486538',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'seo_sub_title' => 0,
    'seo_title' => 0,
    'SEO' => 0,
    'CONFIG' => 0,
    'VER' => 0,
    'pager' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a1b628a6cb741_35843012',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a1b628a6cb741_35843012')) {function content_5a1b628a6cb741_35843012($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if ($_smarty_tpl->tpl_vars['seo_sub_title']->value){?><?php echo $_smarty_tpl->tpl_vars['seo_sub_title']->value;?>
_<?php }?><?php if ($_smarty_tpl->tpl_vars['seo_title']->value){?><?php echo $_smarty_tpl->tpl_vars['seo_title']->value;?>
<?php }elseif($_smarty_tpl->tpl_vars['SEO']->value['title']){?><?php echo $_smarty_tpl->tpl_vars['SEO']->value['title'];?>
<?php }else{ ?><?php echo L('商户管理');?>
-<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['title'];?>
<?php }?></title>
<link rel="stylesheet" type="text/css" href="/themes/ele/web/static/css/pub.css?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
" />
<link rel="stylesheet" type="text/css" href="/themes/default/web/static/css/style.css?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
" />
<link rel="stylesheet" type="text/css" href="/themes/ele/web/static/css/append.css?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
" />
<script type="text/javascript" src="/themes/default/web/static/js/jquery.js?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/script/fastclick.js" type="text/javascript" charset="utf-8"></script>
<script src="/themes/default/web/static/js/common.js?<?php echo $_smarty_tpl->tpl_vars['VER']->value;?>
" type="text/javascript" charset="utf-8"></script>
</head>
<body class="smallpage" style="background:#fff;">
<iframe id="miniframe" name="miniframe" style="display:none;"></iframe><?php }} ?>