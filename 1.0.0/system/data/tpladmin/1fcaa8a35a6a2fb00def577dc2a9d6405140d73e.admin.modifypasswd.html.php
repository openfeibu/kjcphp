<?php /* Smarty version Smarty-3.1.8, created on 2017-11-27 08:55:03
         compiled from "admin:admin/admin/modifypasswd.html" */ ?>
<?php /*%%SmartyHeaderCode:52605a1b6267690d99-03925415%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1fcaa8a35a6a2fb00def577dc2a9d6405140d73e' => 
    array (
      0 => 'admin:admin/admin/modifypasswd.html',
      1 => 1453183424,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '52605a1b6267690d99-03925415',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'ADMIN' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a1b62676b7e98_62550116',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a1b62676b7e98_62550116')) {function content_5a1b62676b7e98_62550116($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
        <th>修改密码</th>
        <td align="right"></td>
      </tr>
    </table>
</div>
<div class="page-data">
	<form action="?index-modifypasswd.html" mini-form="admin-form" method="post">
	<table width="100%" border="0" cellspacing="0" class="table-data form">
		<tr>
			<th class="w-200">管理员:</th>
			<td><?php echo $_smarty_tpl->tpl_vars['ADMIN']->value['admin_name'];?>
</td>
		</tr>
		<tr>
			<th>旧密码:</th>
			<td><input type="password" name="data[oldpasswd]" value="" class="input w-200"/></td>
		</tr>
		<tr>
			<th>新密码:</th>
			<td><input type="password" name="data[newpasswd]" value="" class="input w-200"/></td>
		</tr>
		<tr>
			<th>确认密码:</th>
			<td><input type="password" name="data[confirmpasswd]" value="" class="input w-200"/></td>
		</tr>
		<tr>
			<th class="clear-th-bottom">&nbsp;</th>
			<td height="50" class="clear-td-bottom"><input type="submit" class="bt-big"  id="button2" value="提交数据" /></td>
		</tr>
	</table>
	</form>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>