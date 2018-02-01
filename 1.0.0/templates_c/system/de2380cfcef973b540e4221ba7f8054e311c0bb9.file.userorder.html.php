<?php /* Smarty version Smarty-3.1.10, created on 2017-11-23 17:55:02
         compiled from "D:\wwwroot\wm87_demo\web\module\wxsite\template\userorder.html" */ ?>
<?php /*%%SmartyHeaderCode:195515a169af6090f54-83610825%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'de2380cfcef973b540e4221ba7f8054e311c0bb9' => 
    array (
      0 => 'D:\\wwwroot\\wm87_demo\\web\\module\\wxsite\\template\\userorder.html',
      1 => 1500463856,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '195515a169af6090f54-83610825',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'orderlist' => 0,
    'items' => 0,
    'shoplogo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_5a169af61c2228_47353433',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a169af61c2228_47353433')) {function content_5a169af61c2228_47353433($_smarty_tpl) {?><?php if (!empty($_smarty_tpl->tpl_vars['orderlist']->value)){?>
 <?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['orderlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
?>
 				 
				 
				 
				 
				 	<div class="editordercon" style="position:relative;"> 	
				 	 <div class="editordertit">  
				 	  <ul> 
				 	   <li><i></i><?php echo $_smarty_tpl->tpl_vars['items']->value['shopname'];?>
</li> 
				 	   <li class="editordright"><span class="editorfoncol"><?php echo $_smarty_tpl->tpl_vars['items']->value['orderwuliustatus'];?>
</span></li> 
				 	  </ul> 
				 	 </div> 
				 	 <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/ordershow/orderid/".((string)$_smarty_tpl->tpl_vars['items']->value['id'])),$_smarty_tpl);?>
"> 
 				 	 <div class="editorderbox" > 
				 	  <ul> 
				<?php if ($_smarty_tpl->tpl_vars['items']->value['shoplogo']==''){?>	  
 					 	   <li><img src="<?php echo $_smarty_tpl->tpl_vars['shoplogo']->value;?>
"></li> 
				<?php }else{ ?>
					 	   <li><img src="<?php echo $_smarty_tpl->tpl_vars['items']->value['shoplogo'];?>
"></li> 
				<?php }?>
				 	   <li> 
				 		<ul> 
				 		 <li><span>￥<?php echo $_smarty_tpl->tpl_vars['items']->value['allcost'];?>
</span></li> 
				 		 <li><?php echo $_smarty_tpl->tpl_vars['items']->value['addtime'];?>
</li>
 				<?php if ($_smarty_tpl->tpl_vars['items']->value['pstype']!=1){?>
					 		 <li>由平台提供配送服务</li>
				<?php }else{ ?>
					 		 <li>由商家提供配送服务</li>
				<?php }?>
				 		</ul> 
				 	   </li> 
 				 	  </ul> 
				 	 </div> 
				 	 </a> 
		<?php if ($_smarty_tpl->tpl_vars['items']->value['status']<4&&$_smarty_tpl->tpl_vars['items']->value['status']>0){?>
 				 	 <div class="editorderbut"> 
				 	  <div><div   class="editordinp1"    ></div></div>
				 	  <ul> 
				<?php if ($_smarty_tpl->tpl_vars['items']->value['status']==2){?>
 					 	   <li><div   class="editordinp1"  onclick="acceptorder(<?php echo $_smarty_tpl->tpl_vars['items']->value['id'];?>
);" >确认收货</div></li> 
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['items']->value['status']==3&&$_smarty_tpl->tpl_vars['items']->value['is_acceptorder']==1&&$_smarty_tpl->tpl_vars['items']->value['is_ping']==0){?>
 					 	 <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/commentorder/orderid/".((string)$_smarty_tpl->tpl_vars['items']->value['id'])),$_smarty_tpl);?>
"> 
					 	   <li><div   class="editordinp1"   >评价订单</div></li> 
					 	  </a> 
				<?php }?>				
	 		<?php if ($_smarty_tpl->tpl_vars['items']->value['is_goshop']==0){?>
						<?php if ($_smarty_tpl->tpl_vars['items']->value['shoptype']==1){?> 
							 	 <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/shopshow/typelx/mk/id/".((string)$_smarty_tpl->tpl_vars['items']->value['shopid'])),$_smarty_tpl);?>
"> 
						<?php }else{ ?>
								 	 <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/shopshow/typelx/wm/id/".((string)$_smarty_tpl->tpl_vars['items']->value['shopid'])),$_smarty_tpl);?>
"> 
						<?php }?>		
				<?php }else{ ?>
								 	 <a href="<?php echo FUNC_function(array('type'=>'url','link'=>"/wxsite/shopshow/typelx/yd/id/".((string)$_smarty_tpl->tpl_vars['items']->value['shopid'])),$_smarty_tpl);?>
"> 
				 <?php }?>		
						 	   <li><div   class="editordinp2"   >再来一单</div></li> 
						 	  </a> 
	
				 	  </ul> 
				 	 </div> 
				
		<?php }else{ ?>
		
			
			 	<div   class="shanchuedit"  onclick="delorder(<?php echo $_smarty_tpl->tpl_vars['items']->value['id'];?>
);"  >删除</div> 
		
		
		<?php }?>			 
				 	</div>
				 
				 
	<?php } ?>
 <?php }?><?php }} ?>