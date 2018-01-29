<?php /* Smarty version Smarty-3.1.8, created on 2017-11-27 08:55:35
         compiled from "D:\WWW\48ym\themes\ele\web\block\foot.html" */ ?>
<?php /*%%SmartyHeaderCode:251355a1b6287884375-29448028%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e6b8dc36a21d89b51431cfcf8368ce98ac6e835d' => 
    array (
      0 => 'D:\\WWW\\48ym\\themes\\ele\\web\\block\\foot.html',
      1 => 1493473017,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '251355a1b6287884375-29448028',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'pager' => 0,
    'site' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a1b62878ce700_36513542',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a1b62878ce700_36513542')) {function content_5a1b62878ce700_36513542($_smarty_tpl) {?><?php if (!is_callable('smarty_block_calldata')) include 'D:\\WWW\\48ym\\system\\plugins/smarty\\block.calldata.php';
?><!--回到顶部end-->

<!--底部开始-->

<div class="login_bottom">

    <img width="200" height="200" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/<?php echo $_smarty_tpl->tpl_vars['site']->value['weixinqr'];?>
">

    <div class="linkA_box">

        <?php $_smarty_tpl->smarty->_tag_stack[] = array('calldata', array('mdl'=>"article/cate",'parent_id'=>"1",'limit'=>5)); $_block_repeat=true; echo smarty_block_calldata(array('mdl'=>"article/cate",'parent_id'=>"1",'limit'=>5), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>


            <{calldata mdl='article/article' from="help" hidden="0" limit=1 cat_id=$item.cat_id}>

				<{if $item.page}>

				<a href="<{link ctl='web/help:'|cat:$item.page}>"><{$item.title}></a>|

				<{else}>

				<a href="<{link ctl='web/help:detail' arg0=$item.article_id}>"><{$item.title}></a>|

				<{/if}>

            <{/calldata}>

        <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_calldata(array('mdl'=>"article/cate",'parent_id'=>"1",'limit'=>5), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>


    </div>

    <p class="black9"><a href="http://www.miitbeian.gov.cn/">苏ICP备16046414号</a>|常州新麦网络科技有限公司|Copyright ©2013-2016 <?php echo $_smarty_tpl->tpl_vars['site']->value['domain'];?>
, All Rights Reserved.</p>

    	 	<div>

		 		<a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=32041102000186" style="display:inline-block;text-decoration:none;height:20px;line-height:20px;"><img src="http://demo.52jscn.com/themes/ele/web/static/images/beian.png" style="float:left;"/><p style="float:left;height:20px;line-height:20px;margin: 0px 0px 0px 5px; color:#939393;">苏公网安备 32041102000186号</p></a>

		 	</div>

		 

</div>

<!--底部结束-->

</body>

</html><?php }} ?>