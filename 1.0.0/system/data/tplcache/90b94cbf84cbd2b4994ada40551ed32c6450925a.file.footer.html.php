<?php /* Smarty version Smarty-3.1.8, created on 2017-11-27 09:01:04
         compiled from "D:\WWW\48ym\themes\default\biz/block/footer.html" */ ?>
<?php /*%%SmartyHeaderCode:105715a1b63d0a7f580-14643676%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90b94cbf84cbd2b4994ada40551ed32c6450925a' => 
    array (
      0 => 'D:\\WWW\\48ym\\themes\\default\\biz/block/footer.html',
      1 => 1461032160,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '105715a1b63d0a7f580-14643676',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'CONFIG' => 0,
    'pager' => 0,
    'request' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a1b63d0aa2802_42934748',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a1b63d0aa2802_42934748')) {function content_5a1b63d0aa2802_42934748($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\WWW\\48ym\\system\\plugins/smarty\\function.link.php';
?>		</div>
        <div class="cl"></div>
	</div>
	<div class="cl"></div>
	<div class="footer">
        <p>Copyright © 2013-<?php echo date("Y");?>
 <a href="http://www.ijh.cc" target="_blank"><?php echo L('江湖科技出品');?>
</a>, All rights reserved. ICP<?php echo L('备案');?>
：<?php echo $_smarty_tpl->tpl_vars['CONFIG']->value['site']['icp'];?>
</p>
	</div>
</div>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['pager']->value['res'];?>
/kindeditor/kindeditor.js"></script>
<script type="text/javascript">
(function(K, $){
KindEditor.ready(function(KE) {
    $("[uploadbtn]").each(function(){
         var upload_url = $(this).attr("uploadbtn")
         var uploadbutton = KE.uploadbutton({
            button : $(this)[0],
            fieldName : 'imgFile',
            url : '<?php echo smarty_function_link(array('ctl'=>"biz/upload:photo",'http'=>"ajax"),$_smarty_tpl);?>
',
            afterUpload : function(data) {
                if (data.error === 0) {
                    var photo = data.photo;
                    KE(upload_url).val(photo);
                    KE(upload_url).attr("photo", "<?php echo $_smarty_tpl->tpl_vars['pager']->value['img'];?>
/"+photo);
                    Widget.MsgBox.success('<?php echo L("上传图片成功");?>
');
                } else {
                    alert(data.message);
                }
            },
            afterError : function(str) {
                alert(str);
            }
        });
        uploadbutton.fileBox.change(function(e) {
            uploadbutton.submit();
        });           
    });
    $(".ke-upload_lay .ke-button").removeClass().addClass("btn btn-success btn-sm");
    $(".ke-upload_lay .ke-button-common").removeClass("ke-button-common");
    $("[preview]").click(function(){
        var el = $(this).attr("preview");
        if($(el).attr('photo')){
            layer.open({
                type: 1,
                shade: false,
                title: false,
                area: [400, 400],
                cancel: function(index){layer.close(index);},
                content: '<img src="'+$(el).attr('photo')+'" width="400" height="400"/>'
             });
        }else{
            alert("<?php echo L('还没有添加图片');?>
");
        }
    });
});
})(window.KT, window.jQuery);
</script>
<script type="text/javascript">
(function(K, $){
$("[date],[datepicker]").off("click").on("click", function(){$(this).addClass("Wdate ");WdatePicker({el:this,dateFmt:'yyyy-MM-dd'});});
$("[datetime],[timepicker]").off("click").on("click", function(){$(this).addClass("Wdate ");WdatePicker({el:this,dateFmt:'yyyy-MM-dd HH:mm:ss'});});
$("[map-marker]").off("click").on("click", function(e){
    e.stopPropagation();e.preventDefault();
    var input = $(this).attr("map-marker").split(",");
    var point = {lng:"", lat:""};
    if(input.length < 2){
        var d = $(input[0]).val().split(",");
        point.lng = d[0];
        point.lat = d[1];
    }else{
        point.lng = $(input[0]).val();
        point.lat = $(input[1]).val();
    }
    Widget.BMap.Marker(point, function(ret){
        if(input.length < 2){
            $(input[0]).val(ret.lng+","+ret.lat);
        }else{
            $(input[0]).val(ret.lng);
            $(input[1]).val(ret.lat);
        }
    });
});
$("[mini-select]").off("click").on("click", function(e){
    e.stopPropagation(); e.preventDefault();
    var a = $(this).attr("mini-select").split("/");
    var elm = a[0].split(",");
    var multi = a[1] || 'N';
    var city_id = a[2] || 0;
    var title = a[3] || ($(this).attr("title") || "<?php echo L('请选择');?>
");
    var link = $(this).attr("action") || $(this).attr("href");
    var width = $(this).attr("mini-width") || 500;
    if(link.indexOf("?")<0){
        link += "?city_id="+city_id;
    }else{
        link += "&city_id="+city_id;
    }
    Widget.Dialog.Select(link, multi, function(ret){
        if(multi == 'Y'){
            var itemIds = [], itemNames = [];
            for(var i=0; i<ret.length; i++){
                itemIds.push(ret[i][0]);
                itemNames.push(ret[i][1].title)
            }
            $(elm[0]).val(itemIds.join(","));
            if(elm.length > 1){
                $(elm[1]).val(itemNames.join(","));
            }
        }else{
            $(elm[0]).val(ret[0]);
            if(elm.length > 1){
                $(elm[1]).val(ret[1].title);
            }
        }
    }, {title:title,width:width});
});

})(window.KT, window.jQuery);
$(document).ready(function(){
    var r_height = $("#ucenter_right_lay").height();
    if($("#ucenter_left_lay").height() < r_height){
        $("#ucenter_left_lay").height(r_height);
    }
});
</script>


<?php if ($_smarty_tpl->tpl_vars['request']->value['MINI']=='load'){?>
<script type="text/javascript">(function(){$(".ui-dialog .ui-dialog-content .page-title").hide();$(".ui-dialog .ui-dialog-content .page-data").css({margin:"0px"});
$("[date],[datepicker]").off("click").on("click", function(){$(this).addClass("Wdate ");WdatePicker({el:this,dateFmt:'yyyy-MM-dd'});});
$("[datetime],[timepicker]").off("click").on("click", function(){$(this).addClass("Wdate ");WdatePicker({el:this,dateFmt:'yyyy-MM-dd HH:mm:ss'});});})(window.KT, window.jQuery);</script>
<?php }elseif($_smarty_tpl->tpl_vars['request']->value['MINI']=='LoadIframe'){?>
<script type="text/javascript">
(function(T, $){
$(":checkbox[CKA]").off("click").on("click",function(){
    var $cks = $(":checkbox[CK='"+$(this).attr("CKA")+"']");;
    if($(this).attr("checked")){
        $cks.each(function(){$(this).attr("checked",true);});
    }else{
        $cks.each(function(){$(this).attr("checked",false);});
    }
});
$(".page-title").hide();$(".page-data").css({margin:"0px"});
$("[date],[datepicker]").off("click").on("click", function(){$(this).addClass("Wdate ");WdatePicker({el:this,dateFmt:'yyyy-MM-dd'});});
$("[datetime],[timepicker]").off("click").on("click", function(){$(this).addClass("Wdate ");WdatePicker({el:this,dateFmt:'yyyy-MM-dd HH:mm:ss'});});
window.parent.Widget.MsgBox.hide();
if(typeof(window.parent.Dialog_Iframe) == 'object'){
    window.parent.Dialog_Iframe.dialog({height: $("body").height()+50});
}else{

}
})(window.KT, window.jQuery);
</script>
</body>
</html>
<?php }else{ ?>
<p class="s-50"></p>
<script type="text/javascript">
(function(T, $){
$("[date],[datepicker]").off("click").on("click", function(){$(this).addClass("Wdate ");WdatePicker({el:this,dateFmt:'yyyy-MM-dd'});});
$("[datetime],[timepicker]").off("click").on("click", function(){$(this).addClass("Wdate ");WdatePicker({el:this,dateFmt:'yyyy-MM-dd HH:mm:ss'});});
	$(":checkbox[CKA]").off("click").on("click",function(){
		var $cks = $(":checkbox[CK='"+$(this).attr("CKA")+"']");;
		if($(this).attr("checked")){
			$cks.each(function(){$(this).attr("checked",true);});
		}else{
			$cks.each(function(){$(this).attr("checked",false);});
		}
	});
	if (window.parent == window){
		$(".page-data").css({margin:"45px 10px 10px 10px"});
	}
})(window.KT, window.jQuery);
</script>
<?php }?>
</body>
</html><?php }} ?>