<?php /* Smarty version Smarty-3.1.10, created on 2018-01-31 23:16:58
         compiled from "D:\UPUPW_K2.1\htdocs\wmr87\templates\adminpage\area\setps.html" */ ?>
<?php /*%%SmartyHeaderCode:210315a71ddeaddda27-76078924%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3db1e4d165a9b80669a9a70bae523bb2e06a597b' => 
    array (
      0 => 'D:\\UPUPW_K2.1\\htdocs\\wmr87\\templates\\adminpage\\area\\setps.html',
      1 => 1500608902,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '210315a71ddeaddda27-76078924',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'siteurl' => 0,
    'tempdir' => 0,
    'shopdetinfo' => 0,
    'psbopen' => 0,
    'shopinfo' => 0,
    'shopid' => 0,
    'citylist' => 0,
    'itv' => 0,
    'locationtype' => 0,
    'dolenth' => 0,
    'shopvalues' => 0,
    'mykey' => 0,
    'items' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.10',
  'unifunc' => 'content_5a71ddeb558277_80004965',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a71ddeb558277_80004965')) {function content_5a71ddeb558277_80004965($_smarty_tpl) {?><html xmlns="http://www.w3.org/1999/xhtml"><head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<meta http-equiv="Content-Language" content="zh-CN"> 
<meta content="all" name="robots"> 
<meta name="description" content=""> 
<meta content="" name="keywords"> 
<title>配送设置</title> 
<link rel="stylesheet" type="text/css" href="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/css/admin.css">
 
 <script src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/js/jquery.js" type="text/javascript" language="javascript"></script>  
 <script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->tpl_vars['siteurl']->value;?>
/templates/<?php echo $_smarty_tpl->tpl_vars['tempdir']->value;?>
/public/js/artdialog/artDialog.js?skin=blue"></script>
</head>
<body style="background:none;height:300px;">
	 <form  method="post" name="upform" action="<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/area/module/savesetps"),$_smarty_tpl);?>
" style="text-align:center;">  
	<div style="width:800px;">
	<div style="width:360px;float:left;height:300px;OVERFLOW-Y: auto;OVERFLOW-X: hidden;">
	 	<table>
	 		
	 		<tr><th colspan="2" style="text-align:left;">配送设置</th></tr>
	 		
	 		<tr>
	 			<td  >配送类型:</td>
				<td>  
					 
					<input type="radio" name="sendtype" value="1" <?php if ($_smarty_tpl->tpl_vars['shopdetinfo']->value['sendtype']==1){?>checked<?php }?>>店铺配送 
					<?php if (isset($_smarty_tpl->tpl_vars['psbopen']->value)&&$_smarty_tpl->tpl_vars['psbopen']->value==1){?><input type="radio" name="sendtype" value="2" <?php if ($_smarty_tpl->tpl_vars['shopdetinfo']->value['sendtype']==2){?>checked<?php }?>>平台配送(配送宝)<?php }?>
				</td>
	 		</tr>
			<?php if (isset($_smarty_tpl->tpl_vars['psbopen']->value)&&$_smarty_tpl->tpl_vars['psbopen']->value==1){?>
				<?php if (empty($_smarty_tpl->tpl_vars['shopinfo']->value['psbaccid'])){?>
			    <tr class="psbtype" style="display:none;">
					<td  >对接类型:</td><td>  
						<input type="radio" name="duijietype" value="1"  >自动对接
						<input type="radio" name="duijietype" value="2"  >手动对接
					
					</td>
				</tr>
				
				<tr class="psselect" style="display:none;">
					<td  >选择配送站:</td><td>  
						<select name="stationid" onchange="loadgroup();">
							  
						</select>
					</td>
				</tr>
				<tr class="psselect" style="display:none;">
					<td  >选择配送组:</td><td>  
						<select name="psgroupid">
							 
						</select>
					</td>
				</tr>
				<tr class="psselect" style="display:none;">
					<td  >选择商圈:</td><td>  
						<select name="bizdistrictid">
							 
						</select>
					</td>
				</tr>
				<tr class="psselect" style="display:none;">
					<td  >提交:</td><td>  
						 <a href="#" onclick="doautoadd();">确认对接</a>
					</td>
				</tr>
				<?php }?>
				<tr class="psbps" <?php if ($_smarty_tpl->tpl_vars['shopdetinfo']->value['sendtype']!=2){?>style="display:none;"<?php }?> > <td>配送宝链接:</td><td> <input type="text" name="psblink" value="<?php echo $_smarty_tpl->tpl_vars['shopinfo']->value['psblink'];?>
"></td></tr> 
				<tr class="psbps" <?php if ($_smarty_tpl->tpl_vars['shopdetinfo']->value['sendtype']!=2){?>style="display:none;"<?php }?> > <td>配送宝商家id:</td><td> <input type="text" name="psbaccid" value="<?php echo $_smarty_tpl->tpl_vars['shopinfo']->value['psbaccid'];?>
"></td></tr>
				<tr class="psbps" <?php if ($_smarty_tpl->tpl_vars['shopdetinfo']->value['sendtype']!=2){?>style="display:none;"<?php }?> > <td>配送宝key:</td><td> <input type="text" name="psbkey" value="<?php echo $_smarty_tpl->tpl_vars['shopinfo']->value['psbkey'];?>
"></td></tr>
				<tr class="psbps" <?php if ($_smarty_tpl->tpl_vars['shopdetinfo']->value['sendtype']!=2){?>style="display:none;"<?php }?> > <td>配送宝code:</td><td> <input type="text" name="psbcode" value="<?php echo $_smarty_tpl->tpl_vars['shopinfo']->value['psbcode'];?>
"><a href="javascript:teskpsb();" id="testrestul">测试对接</a></td></tr>
			<?php }?>
			
	 		 
	 		<tr class="showbangjing" id="showbangjing"> <td><?php if ($_smarty_tpl->tpl_vars['shopdetinfo']->value['sendtype']==1){?>店铺<?php }else{ ?>平台<?php }?>配送半径</td><td> <input type="text" name="pradius" value="<?php echo $_smarty_tpl->tpl_vars['shopdetinfo']->value['pradius'];?>
" style="width:50px;"  >千米 </td></tr>
			 
	   
	  
	 				
	 		</table>     
   	 
	  <input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['shopid']->value;?>
" name="shopid">
	
	</div>
   <div style="width:300px;float:left;height:260px;OVERFLOW-Y: auto;OVERFLOW-X: hidden;" id="arealist">
	 	<table>
	 		<tr><th colspan="2" style="text-align:left;">绑定所属城市：</th></tr>
	  		
	 	 <tr  > <td>所属城市</td><td> 
	 	 	<select name="admin_id" onchange="doselectadmin();"> 
	 	 		 <option value="0">请选择城市</option>
	 	 		 <?php  $_smarty_tpl->tpl_vars['itv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['itv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['citylist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['itv']->key => $_smarty_tpl->tpl_vars['itv']->value){
$_smarty_tpl->tpl_vars['itv']->_loop = true;
?>
	 	 		     <option value="<?php echo $_smarty_tpl->tpl_vars['itv']->value['adcode'];?>
" <?php if ($_smarty_tpl->tpl_vars['itv']->value['adcode']==$_smarty_tpl->tpl_vars['shopinfo']->value['admin_id']){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['itv']->value['name'];?>
</option>
	 	 		 <?php } ?>
	 	 	
	 	 	
	 	 	
	 	 	</td></tr>
	 	   
	
	 		</table>   
			<div style="clear:both;height:30px;"> 	<input type="submit" value="确认提交" class="button">  </div>
	 	</div>


	</div>
  </form>
<script>
var checklocation = '<?php echo $_smarty_tpl->tpl_vars['locationtype']->value;?>
';
$(function(){ 
	/*
	if(checklocation == 1){
	 
	  $('.showpesong').hide();
	  doselect(); 
	}else{
		$('.showbangjing').hide();
	}*/
	doselectadmin();
	<!-- doselect(); -->
	 $('input[name="sendtype"]').bind('click',function(){
        var sendtype = $('input[name="sendtype"]:checked ').val();
        if(sendtype == 2){
			if($('.psbtype').length > 0){
				$('.psbtype').show();
			}else{ 
				$('.psbps').show();
			}
        }else{
            $('.psbps').hide();
			$('.psbtype').hide();
             
        }
    });
	$('input[name="duijietype"]').bind('click',function(){
        var sendtype = $('input[name="duijietype"]:checked ').val();
        if(sendtype == 1){ 
			$('.psbps').hide();
			$('.psselect').show(); 
			loadstation();
			
        }else{
            $('.psbps').show(); 
			$('.psselect').hide();
        }
    });
	
});
function doselectadmin(){
	var checkid = $("select[name='admin_id']").find("option:selected").val(); 
	if(checkid != '0'){
	  $('.s_out').hide();
	  $('.doselect_'+checkid).show();
	}else{
	  $('.s_out').show();
	}
}
function doselect(){
	var bangjing = $('input[name="pradius"]').val();
	var htmls = '';
	var checkleng = Number(<?php echo $_smarty_tpl->tpl_vars['dolenth']->value;?>
);
	$('.bangjingvalue').remove();
	for(var i=0;i<bangjing;i++){
		var c = i+1; 
		if(i < checkleng){
		<?php  $_smarty_tpl->tpl_vars['items'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['items']->_loop = false;
 $_smarty_tpl->tpl_vars['mykey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['shopvalues']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['items']->key => $_smarty_tpl->tpl_vars['items']->value){
$_smarty_tpl->tpl_vars['items']->_loop = true;
 $_smarty_tpl->tpl_vars['mykey']->value = $_smarty_tpl->tpl_vars['items']->key;
?>
		  if(i == <?php echo $_smarty_tpl->tpl_vars['mykey']->value;?>
){
	     	htmls += '<tr class="bangjingvalue"><td>'+i+'-'+c+'千米配送费:</td><td>  <input type="text" name="radiusvalue'+i+'" value="<?php echo $_smarty_tpl->tpl_vars['items']->value;?>
" style="width:50px;"  >元 </td></tr>';
	    }
		<?php } ?>
		
	  }else{
	  	htmls += '<tr class="bangjingvalue"><td>'+i+'-'+c+'千米配送费:</td><td>  <input type="text" name="radiusvalue'+i+'" value="" style="width:50px;"  >元 </td></tr>';
	  }
		
	}
	$('#showbangjing').after(htmls);

	//
}
function teskpsb(){ 
	var url = '<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/area/module/testpsblink/datatype/json/random/@random@"),$_smarty_tpl);?>
'; 
	 $.ajax({
	 type: 'post',
	 async:true,
	 data:{'psblink':$('input[name="psblink"]').val(),'bizid':$('input[name="psbaccid"]').val(),'psbkey':$('input[name="psbkey"]').val(),'psbcode':$('input[name="psbcode"]').val()},
	 url: url.replace('@random@', 1+Math.round(Math.random()*1000)), 
	 dataType: 'json',success: function(content) {  
		if(content.error == false){
			 $('#testrestul').html('测试成功');
		}else{
			if(content.error == true)
			{
				 $('#testrestul').html(content.msg); 
			}else{
				 $('#testrestul').html(content); 
			}
		} 
		},
	error: function(content) {   
		 $('#testrestul').html('数据获取失败'); 
	  }
   });   
}

function loadstation(){
	var url = '<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/area/module/getstaionlist/datatype/json/random/@random@"),$_smarty_tpl);?>
'; 
	$('select[name="stationid"]').html('');
	$('select[name="psgroupid"]').html('');
	$('select[name="bizdistrictid"]').html('');
	 $.ajax({
	 type: 'post',
	 async:true,
	 data:{},
	 url: url.replace('@random@', 1+Math.round(Math.random()*1000)), 
	 dataType: 'json',success: function(content) {  
		if(content.error == false){
			// $('#testrestul').html('测试成功'); 
			if(content.msg.stationlist.length > 0){
			   for(var i = 0;i<content.msg.stationlist.length;i++){
			        $('select[name="stationid"]').append('<option value="'+content.msg.stationlist[i].sid+'">'+content.msg.stationlist[i].sname+'</option>');
			   }
			} 
			setTimeout("loadgroup()",500); 
			 
		}else{
			if(content.error == true)
			{
			alert(content.msg);
				 //$('#testrestul').html(); 
			}else{
			alert(content);
				// $('#testrestul').html(content); 
			}
		} 
		},
	error: function(content) {   
		 alert('数据获取失败');// $('#testrestul').html(''); 
	  }
   });   
}
function doautoadd(){
	var url = '<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/area/module/addacounttopsb/datatype/json/random/@random@"),$_smarty_tpl);?>
'; 
	var stationid = $("select[name='stationid']").find("option:selected").val();
	var shopid = $("input[name='shopid']").val();
	var psgroupid = $("select[name='psgroupid']").find("option:selected").val();
	var bizdistrictid = $("select[name='bizdistrictid']").find("option:selected").val();
	 $.ajax({
	 type: 'post',
	 async:true,
	 data:{'stationid':stationid,'shopid':shopid,'psgroupid':psgroupid,'bizdistrictid':bizdistrictid},
	 url: url.replace('@random@', 1+Math.round(Math.random()*1000)), 
	 dataType: 'json',success: function(content) {  
		if(content.error == false){
			// $('#testrestul').html('测试成功'); 
			 location.reload();  
		}else{
			if(content.error == true)
			{
			alert(content.msg);
				 //$('#testrestul').html(); 
			}else{
			alert(content);
				// $('#testrestul').html(content); 
			}
		} 
		},
	error: function(content) {   
		 alert('数据获取失败');// $('#testrestul').html(''); 
	  }
   });  
}
function loadgroup(){
$('select[name="psgroupid"]').html('');
	$('select[name="bizdistrictid"]').html('');
	var url = '<?php echo FUNC_function(array('type'=>'url','link'=>"/adminpage/area/module/getstationchild/datatype/json/random/@random@"),$_smarty_tpl);?>
'; 
	var stationid = $("select[name='stationid']").find("option:selected").val();
	 $.ajax({
	 type: 'post',
	 async:true,
	 data:{'stationid':stationid},
	 url: url.replace('@random@', 1+Math.round(Math.random()*1000)), 
	 dataType: 'json',success: function(content) {  
		if(content.error == false){
			// $('#testrestul').html('测试成功'); 
			if(content.msg.psgroup.length > 0){
			   for(var i = 0;i<content.msg.psgroup.length;i++){
			        $('select[name="psgroupid"]').append('<option value="'+content.msg.psgroup[i].id+'">'+content.msg.psgroup[i].name+'</option>');
			   }
			} 
			if(content.msg.bizdistrict.length > 0){
			   for(var i = 0;i<content.msg.bizdistrict.length;i++){
			        $('select[name="bizdistrictid"]').append('<option value="'+content.msg.bizdistrict[i].bizdistrictid+'">'+content.msg.bizdistrict[i].bizdistrictname+'</option>');
			   }
			}
			 
		}else{
			if(content.error == true)
			{
			alert(content.msg);
				 //$('#testrestul').html(); 
			}else{
			alert(content);
				// $('#testrestul').html(content); 
			}
		} 
		},
	error: function(content) {   
		 alert('数据获取失败');// $('#testrestul').html(''); 
	  }
   }); 


}
</script>
</body>
</html><?php }} ?>