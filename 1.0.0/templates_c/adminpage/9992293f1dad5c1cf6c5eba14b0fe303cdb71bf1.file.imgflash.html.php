<?php /* Smarty version Smarty-3.1.10, created on 2018-01-31 23:34:22
         compiled from "D:\UPUPW_K2.1\htdocs\wmr87\templates\adminpage\weixin\imgflash.html" */ ?>
<?php /*%%SmartyHeaderCode:26795a71e1fea8ecb6-97611528%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9992293f1dad5c1cf6c5eba14b0fe303cdb71bf1' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\adminpage\\weixin\\imgflash.html',
      1 => 1506390930,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '26795a71e1fea8ecb6-97611528',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'items' => 0,
    'siteurl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_5a71e1feca2419_31982685',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a71e1feca2419_31982685')) {function content_5a71e1feca2419_31982685($_smarty_tpl) {?><style>
	.appAddtoCon .appAddtoRight .appAddtoModi table tbody tr td img.yuan{
		width: 96px;
		border-radius:0px;
	}
</style>
<div class="appAddtoRight home_1">
<i class="app_tri"></i>
<div class="appAddtoTit">
	<i class="icon_edit"></i>
	<h3>首页模块编辑</h3>
</div>
<div class="appAddtoSubj">
	<table>
		<thead>
			<tr>
				<td>图标</td>
				<td>排序</td>
				<td>操作</td>
			</tr>
		</thead>
	</table>
</div>

<div class="appAddtoModi">
	<table>
		<tbody>
				<?php if (!empty($_smarty_tpl->tpl_vars['list']->value)){?>
				<?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
?>
				<tr cid="<?php echo $_smarty_tpl->tpl_vars['items']->value['id'];?>
" type="imgflash">
					<td>
						<img class="yuan"  src="<?php echo $_smarty_tpl->tpl_vars['items']->value['img'];?>
"  />
					</td>
					<td>
						<span class="orderid"><?php echo $_smarty_tpl->tpl_vars['items']->value['sort'];?>
</span>
					</td>
					<td>
						<a class="appAddaL_bg" href="javascript:;">编辑</a>
						<?php if ($_smarty_tpl->tpl_vars['items']->value['is_show']==1){?>
						<a class="appAdda_bg02" href="javascript:;">隐藏</a>
						<?php }else{ ?>
						<a class="appAdda_bg01" href="javascript:;">显示</a>
						<?php }?>
						</td>
					<input type="hidden" class="link" value="<?php echo $_smarty_tpl->tpl_vars['items']->value['linkurl'];?>
">
					<input type="hidden" class="imgurl" value="<?php echo $_smarty_tpl->tpl_vars['items']->value['img'];?>
">
					<input type="hidden" class="id" value="<?php echo $_smarty_tpl->tpl_vars['items']->value['id'];?>
">
				</tr>
				<?php } ?>
				<?php }?>
		</tbody>
	</table>
</div>
<div class="appAddtoPopuCon" style="height:220px;" >

	<div class="appAddtoPopuCon" style="height:220px;">
		<div class="appAddtoPopuTit">
			<h4>编辑关键字模块</h4>
		</div>
		<div id="bottom_edit"  style="display:none;">
			<div class="appAddtoPopuBox">
				<div class="appAddtoPopuTop">
					<form id="dosaveform">
						<ul>
							<input type="hidden" name="htmldataid" value="">
							<li>
								<span>超连接：</span>
								<input type="text" value="" name="i_links"/>
							</li>

							<li>
								<span>排序ID：</span>
								<input type="text" value="0" name="i_orderid"/>
								<b>排序</b>
							</li>
							<li>
								<span>上传图片：</span>
								<div class="appAddtoFile">
									<input readonly="readonly" type="text" value="" name="i_img_url"/>
									<span>浏览</span>
									<input class="appfile" type="file" id="imgFile" name="imgFile"/>
								</div>
							</li>
						</ul>
						<input type="hidden" name="id" value="0">
					</form>

				</div>
				<div class="appAddtoPopuBot">
					<input type="button" value="保存修改" id="dosave"/>
					<a href="javascript:;" id="doclose">取消</a>
				</div>
			</div>
		</div>
</div>
</div>
<script>
	$(".appAddaL_bg").click(function(){
		$('#bottom_edit').show();
		$("input[name='i_links']").val($(this).parents("tr").find(".link").val());
		$("input[name='i_img_url']").val( $(this).parents("tr").find(".imgurl").val());
		$("input[name='i_orderid']").val($(this).parents("tr").find(".orderid").html());
		$("input[name='id']").val($(this).parents("tr").find(".id").val());
	})
	$('#dosave').click(function(){
		var url = '<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/index.php?ctrl=adminpage&action=weixin&module=saveappindex&datatype=json&type=imgflash';
		$.ajax({
			type: 'post',
			async:false,
			data:$('#dosaveform').serialize(),
			url: url.replace('@random@', 1+Math.round(Math.random()*1000)),
			dataType: 'json',success: function(content) {
				if(content.error == false){
					alert('更新成功');
					$('#showjscontent').html('');
					var content = htmlback("<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/index.php?ctrl=adminpage&action=weixin&module=imgflash");
					if(content.flag == false){
						var getmoreContent =  $.trim(content.content);
						$('#showjscontent').append(getmoreContent);
					}
				}else{
					if(content.error == true)
					{
						alert(content.msg);
					}else{
						alert(content);
					}
				}
			},
			error: function(content) {
				alert('数据提交失败');
			}
		});
	});
</script><?php }} ?>