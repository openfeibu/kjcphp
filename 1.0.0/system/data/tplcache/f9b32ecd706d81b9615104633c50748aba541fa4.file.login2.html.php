<?php /* Smarty version Smarty-3.1.8, created on 2017-11-27 08:55:44
         compiled from "D:\WWW\48ym\themes\ele\web\passport\login2.html" */ ?>
<?php /*%%SmartyHeaderCode:284505a1b629008f0b3-14673035%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f9b32ecd706d81b9615104633c50748aba541fa4' => 
    array (
      0 => 'D:\\WWW\\48ym\\themes\\ele\\web\\passport\\login2.html',
      1 => 1474187892,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '284505a1b629008f0b3-14673035',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'backurl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a1b62900c1d48_71582804',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a1b62900c1d48_71582804')) {function content_5a1b62900c1d48_71582804($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\WWW\\48ym\\system\\plugins/smarty\\function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("web/block/head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript" language="javascript">
    function enterPress(e){ 
        if(e.keyCode == 13) { 
            $('#psw_btn').click();
        }
    }
</script>
<!--内容开始-->
<div style="background:#fff;">
	<div class="new_login">
		<header class="head">
			<a href="#"><img src="/themes/ele/web/static/images/logo1.png"/></a>
		</header>
		<div class="login_newNr">
			<img src="/themes/ele/web/static/images/login-left.png" class="img" />
			<div class="login_form">
				<div class="top">
					<h3>登录</h3>
					<a href="<?php echo smarty_function_link(array('ctl'=>'web/passport/login'),$_smarty_tpl);?>
">手机验证登录<i class="ico ico1"></i></a>
					<div class="cl"></div>
				</div>
				<form>
					<div class="compact int_box">
						<em class="ico ico_1"></em>
						<input type="text" placeholder="手机号/邮箱/用户名" onKeyDown="javascript:enterPress(event);" id="mobile"/>
					</div>					
					<div class="compact int_box">
						<em class="ico ico_2"></em>
						<input type="password" placeholder="密码" onKeyDown="javascript:enterPress(event);" id="password"/>
					</div>
					<!--
					<div class="compact int_group">
						<input type="text" maxlength="6" placeholder="验证码"/>
						<span class="group">
							<span><img src=""/><a href="#">看不清换一张</a></span>
						</span>
					</div>
					-->
					<div class="compact" style=" font-size:14px; color:#666;"> 
						<label> <input class="check" type="checkbox" checked="checked">下次自动登录 </label> 
					</div>
					<input type="button" id="psw_btn" class="long_btn" value="登录">
				</form>
				<div class="line">
					<a href=="<?php echo smarty_function_link(array('ctl'=>'web/passport/register'),$_smarty_tpl);?>
">新用户注册</a>
					<a href="<?php echo smarty_function_link(array('ctl'=>'web/passport/passwd'),$_smarty_tpl);?>
" class="fr">忘记密码</a>
					<div class="cl"></div>
				</div>
				<div class="zhanghao">
					<div>
						<h4>可使用以下账号直接登录</h4>
						<a href="#" class="qq"></a>
						<a href="#" class="weibo"></a>
					</div>
				</div>
			</div>
			<div class="cl"></div>
		</div>
	</div>
</div>

                    <script>
                        function focusInput(focusClass, normalClass) {
                            var elements = document.getElementsByTagName("input");
                            for (var i = 0; i < elements.length; i++) {
                                if (elements[i].type != "button" && elements[i].type != "submit" && elements[i].type != "reset") {
                                    //if(elements[i].type=="text"){
                                    elements[i].onfocus = function () {
                                        $(this).parent(".login_form .int_box").addClass("on")
                                    };
                                    elements[i].onblur = function () {
                                        $(this).parent(".login_form .int_box").removeClass("on")
                                    };
                                }
                            }
                        }
                        window.onload = function () {
                            focusInput('focusInput', 'normalInput');
                        }//input状态
                        $(document).ready(function () {
                            $(".login_form .selct_int .box").click(function () {
                                if ($(this).hasClass("on")) {
                                    $(this).removeClass("on");
                                }
                                else {
                                    $(this).addClass("on");
                                }
                            });
                        });
                    </script>
                    
<!--内容结束-->
<script>
    $(document).ready(function(){
        $('#psw_btn').click(function(){
            var mobile = $('#mobile').val(); 
            var password = $('#password').val();
            var link = "<?php echo smarty_function_link(array('ctl'=>'passport/handle2'),$_smarty_tpl);?>
";
            $.post(link,{mobile:mobile,password:password},function(ret){
                if(ret.error != 0){
                    layer.msg(ret.message);
                    return ;
                }else{
                    layer.msg(ret.message);
                    setTimeout(function(){
                       window.location.href='<?php echo $_smarty_tpl->tpl_vars['backurl']->value;?>
';
                    },1000)
                    BtnCount();
                }
            },'json');
        })
    })
</script>
<?php echo $_smarty_tpl->getSubTemplate ("web/block/foot.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>