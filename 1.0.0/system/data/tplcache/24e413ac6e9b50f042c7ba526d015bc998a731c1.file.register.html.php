<?php /* Smarty version Smarty-3.1.8, created on 2017-11-27 08:55:38
         compiled from "D:\WWW\48ym\themes\ele\web\passport\register.html" */ ?>
<?php /*%%SmartyHeaderCode:147165a1b628a60ff19-50665452%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24e413ac6e9b50f042c7ba526d015bc998a731c1' => 
    array (
      0 => 'D:\\WWW\\48ym\\themes\\ele\\web\\passport\\register.html',
      1 => 1474187892,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '147165a1b628a60ff19-50665452',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'reg_yzm' => 0,
    'pager' => 0,
    'backurl' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a1b628a6a07b3_61397441',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a1b628a6a07b3_61397441')) {function content_5a1b628a6a07b3_61397441($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\WWW\\48ym\\system\\plugins/smarty\\function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("web/block/head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<script type="text/javascript" language="javascript">
    function enterPress(e){ 
        if(e.keyCode == 13) { 
            $('#reg').click();
        }
    }
</script>
<!--内容开始-->
<div class="register-box">
		<header class="head">
			<a href="#"><img src="/themes/ele/web/static/images/logo1.png"/></a>
        </header>
		<div class="register-cont">
        	 	<div class="line"><h3>使用手机注册</h3></div>
                <div class="register-aside">
                     <h3 class="register-title">已经注册过 ？</h3>	
                     <p class="register-info">请点击 <a href="<?php echo smarty_function_link(array('ctl'=>'web/passport/login'),$_smarty_tpl);?>
">直接登录</a></p>
                     <div class="register-auth">
                     	  <h4 class="linktitle">可使用以下账号直接登录</h4>
                          <a href="javascript:void(0);" class="auth-link qq"></a><a href="javascript:void(0);" class="auth-link weibo"></a>
                     </div>
                </div>	
                <div class="register-form">
                        <form>
                                <div class="form-groups one int_box">
                                        <label class="regi_lab">手机号码</label><input class="regi_inp" type="text" onKeyDown="javascript:enterPress(event);" id="mobile" placeholder="请输入你的手机号"/>
                                </div>	
                                <div class="form-groups int_box">
                                        <label class="regi_lab">手机验证码</label><input class="regi_inp" type="text" onKeyDown="javascript:enterPress(event);" id="yzm"/><button class="regi_btn yzm-btn yzmget" login="sendsms">获取验证码</button>
                                </div>
                                <?php if ($_smarty_tpl->tpl_vars['reg_yzm']->value=='on'){?>
                                <div class="yzm_box"><input type="number" maxlength="6" onKeyDown="javascript:enterPress(event);" id="verifycode" placeholder="验证码"><img style="border-radius: 5px; margin-left: 10px;" verify="#pass-verify" src="<?php echo smarty_function_link(array('ctl'=>'magic:verify','http'=>'ajax'),$_smarty_tpl);?>
&_=<?php echo $_smarty_tpl->tpl_vars['pager']->value['dateline'];?>
"  width="90" height="38"></a><a href="javascript:void(0);" id="pass-verify" class="change">看不清换一张</a>
                                </div>
                                <?php }?>
                                <div class="form-groups int_box">
                                        <label class="regi_lab">设置密码</label><input class="regi_inp" type="password" onKeyDown="javascript:enterPress(event);" id="passwd" placeholder="密码长度6-20字符"/>
                                </div>
                                <div class="form-groups int_box"><label class="regi_lab">再次输入密码</label><input class="regi_inp" type="password" onKeyDown="javascript:enterPress(event);" id="repasswd" placeholder="请再次输入密码"></div>
                                <script>
									function focusInput(focusClass, normalClass) {
										var elements = document.getElementsByTagName("input");
										for (var i = 0; i < elements.length; i++) {
											if (elements[i].type != "button" && elements[i].type != "submit" && elements[i].type != "reset") {
												//if(elements[i].type=="text"){
												elements[i].onfocus = function () {
													$(this).parent(".register-form .int_box").addClass("on")
												};
												elements[i].onblur = function () {
													$(this).parent(".register-form .int_box").removeClass("on")
												};
											}
										}
									}
									window.onload = function () {
										focusInput('focusInput', 'normalInput');
									}//input状态
			
									var minute = 60;
									var mobile_timeout;
									var mobile_count = minute;
									var mobile_lock = 0;
			
			
									BtnCount = function () {
										if (mobile_count == 0) {
											$(".yzmget").addClass("on");
											$('.yzmget').removeAttr("disabled");
											$('.yzmget').val("<?php echo L('重新获取');?>
");
											mobile_lock = 0;
											clearTimeout(mobile_timeout);
											$('.yzmget').removeClass("on");
										} else {
											mobile_count--;
											$('.yzmget').val("重新获取(" + mobile_count.toString() + ")" + "<?php echo L('秒');?>
");
											mobile_timeout = setTimeout(BtnCount, 1000);
										}
									};
			
			
									$("[login]").click(function () {
										if (mobile_lock == 0) {
											var mobile = $('#mobile').val();
											var link = "<?php echo smarty_function_link(array('ctl'=>'web/passport/sendsms'),$_smarty_tpl);?>
";
											$(".yzmget").addClass("on");
											//alert(mobile);return false;
											$.post(link, {mobile: mobile}, function (ret) {
			
			
												if (ret.error == 0) {
			
													BtnCount();
													mobile_lock = 1;
													$(".yzmget").addClass("on");
													$('.yzmget').attr("disabled", "disabled");
			
												} else {
													layer.msg(ret.message);
													mobile_lock = 0;
			
												}
											}, 'json');
			
			
											mobile_count = minute;
										}
									});
                    			</script>
                                <div class="form-groups">
                                        <button class="regi_btn submit" id="reg">同意协议并注册</button>
                                </div>	
                        </form>
                                <div class="line-text"><a href="<?php echo smarty_function_link(array('ctl'=>'web/help/agreement'),$_smarty_tpl);?>
" target="_blank">《使用条款和协议》</a></div>	
                                
                </div>
                <div class="cl"></div>       
        </div>
</div>

<script>
    $('#reg').click(function () {
        var mobile = $('#mobile').val();
        var yzm = $('#yzm').val();
        var yzm_val = $('#verifycode').val();
        var passwd = $('#passwd').val();
        var repasswd = $('#repasswd').val();
        var link = "<?php echo smarty_function_link(array('ctl'=>'web/passport/register'),$_smarty_tpl);?>
";
        $.post(link, {mobile: mobile, yzm: yzm, yzm_val: yzm_val, passwd: passwd, repasswd: repasswd}, function (ret) {
            if (ret.error == 0) {
                layer.msg(ret.message);
                setTimeout(function () {
                    window.location.href = "<?php echo smarty_function_link(array('ctl'=>'web/index'),$_smarty_tpl);?>
";
                }, 2000)
                BtnCount();
            } else {
                layer.msg(ret.message);
                return;
            }

        }, 'json');
    })



    $('#long_btn').click(function () {
        var mobile = $('#mobile').val();
        var yzm = $('#yzm').val();
        var yzm_val = $('#verifycode').val();
        var link = "<?php echo smarty_function_link(array('ctl'=>'web/passport/handle'),$_smarty_tpl);?>
";
        $.post(link, {mobile: mobile, yzm: yzm, yzm_val: yzm_val}, function (ret) {
            if (ret.error == 0) {
                layer.msg(ret.message);
                setTimeout(function () {
                    window.location.href = '<?php echo $_smarty_tpl->tpl_vars['backurl']->value;?>
';
                }, 1000)
                BtnCount();
            } else {
                layer.msg(ret.message);
            }

        }, 'json');
    })
</script>
<!--内容结束-->
<?php echo $_smarty_tpl->getSubTemplate ("web/block/foot.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>