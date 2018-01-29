<?php /* Smarty version Smarty-3.1.8, created on 2017-11-27 08:55:31
         compiled from "admin:config/wechat.html" */ ?>
<?php /*%%SmartyHeaderCode:271925a1b6283df9d66-11651247%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '19429ac2150557a7e7e8d1f9033f23a5e4dedd6b' => 
    array (
      0 => 'admin:config/wechat.html',
      1 => 1461671654,
      2 => 'admin',
    ),
  ),
  'nocache_hash' => '271925a1b6283df9d66-11651247',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'MOD' => 0,
    'config' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a1b6283ea9a10_71692427',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a1b6283ea9a10_71692427')) {function content_5a1b6283ea9a10_71692427($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("admin:common/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="page-title">
    <table width="100%" align="center" cellpadding="0" cellspacing="0" >
      <tr>
        <td width="30" align="right"><img src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['url'];?>
/images/main-h5-ico.gif" alt="" /></td>
        <th><?php echo $_smarty_tpl->tpl_vars['MOD']->value['title'];?>
</th>
        <td align="right"></td>
        <td width="15"></td>
      </tr>
    </table>
</div>
<div class="page-data"><form action="?system/config-wechat.html" mini-form="config-form" method="post" >
<input type="hidden" name="K" value="wechat" />
<table width="100%" border="0" cellspacing="0" class="table-data form">
<tr><th>公众号类型：</th>
    <td>
        <label><input type="radio" value="0" <?php if (empty($_smarty_tpl->tpl_vars['config']->value['type'])){?>checked="checked"<?php }?>name="config[type]">订阅号</label>
        <label><input type="radio" value="1" <?php if ($_smarty_tpl->tpl_vars['config']->value['type']){?>checked="checked"<?php }?> name="config[type]">服务号</label>&nbsp;&nbsp;
        
    </td>
</tr>
<tr><th>公众号APPID：</th>
    <td><input type="text" name="config[appid]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['appid'];?>
" class="input w-300"/></td>
</tr>
<tr><th>公众号APPSecret：</th>
    <td><input type="text" name="config[appsecret]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['appsecret'];?>
" class="input w-300"/></td>
</tr>
<th>微信Token：</th><td><input type="text" name="config[wechat_token]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['wechat_token'])===null||$tmp==='' ? md5((__CFG::SECRET_KEY).(__CFG::Authorize)) : $tmp);?>
" class="input w-300"/><span class="tip-comment"><a href=""微信接口Token,全站统一Token</span></td></tr>
<th>微信EncodingAESKey：</th><td><input type="text" name="config[wechat_aeskey]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['wechat_aeskey'];?>
" class="input w-300"/><span class="tip-comment"><a href=""微信接口Token,全站统一Token</span></td></tr>
<tr><th>APP应用ID：</th>
    <td>
        <input type="text" name="config[app_appid]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['app_appid'];?>
" class="input w-300"/>
        <span class="tip-comment">微信开放平台申请获得，<a href="https://open.weixin.qq.com/" target="_blank">立即申请</a></span>
    </td>
</tr>
<tr><th>APP应用Secret：</th>
    <td>
        <input type="text" name="config[app_appsecret]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['app_appsecret'];?>
" class="input w-300"/>
        <span class="tip-comment">微信开放平台申请获得，<a href="https://open.weixin.qq.com/" target="_blank">立即申请</a></span>
    </td>
</tr>
<tr><th>公众号应用ID：</th>
    <td>
        <input type="text" name="config[open_mp_appid]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['open_mp_appid'];?>
" class="input w-300"/>
        <span class="tip-comment">公众号第三方平台AppId, 微信开放平台申请获得，<a href="https://open.weixin.qq.com/" target="_blank">立即申请</a></span>
    </td>
</tr>
<tr><th>公众号应用Secret：</th>
    <td>
        <input type="text" name="config[open_mp_appsecret]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['open_mp_appsecret'];?>
" class="input w-300"/>
        <span class="tip-comment">公众号第三方平台AppSecret, 微信开放平台申请获得，<a href="https://open.weixin.qq.com/" target="_blank">立即申请</a></span>
    </td>
</tr>
<th>公众号应用Token：</th><td><input type="text" name="config[open_mp_token]" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['config']->value['open_mp_token'])===null||$tmp==='' ? md5((__CFG::SECRET_KEY).(__CFG::Authorize)) : $tmp);?>
" class="input w-300"/><span class="tip-comment"><a href=""微信接口Token,全站统一Token</span></td></tr>
<th>公众号应用AESKey：</th><td><input type="text" name="config[open_mp_aeskey]" value="<?php echo $_smarty_tpl->tpl_vars['config']->value['open_mp_aeskey'];?>
" class="input w-300"/><span class="tip-comment"><a href=""微信接口Token,全站统一Token</span></td></tr>

<tr><th class="clear-th-bottom"></th><td class="clear-td-bottom" colspan="10"><input type="submit" class="bt-big" value="提交数据" /></td></tr>
</table>
</form></div>

<?php echo $_smarty_tpl->getSubTemplate ("admin:common/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>