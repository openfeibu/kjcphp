<?php /* Smarty version Smarty-3.1.8, created on 2017-11-27 09:01:04
         compiled from "D:\WWW\48ym\themes\default\biz/index.html" */ ?>
<?php /*%%SmartyHeaderCode:31165a1b63d08ba319-14162350%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '69deef346c09b536c7bf62a06743b0946fde7191' => 
    array (
      0 => 'D:\\WWW\\48ym\\themes\\default\\biz/index.html',
      1 => 1461060090,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '31165a1b63d08ba319-14162350',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'wait_accept' => 0,
    'wait_peisong' => 0,
    'today_order' => 0,
    'all_order' => 0,
    'week_in' => 0,
    'v1' => 0,
    'month_in' => 0,
    'v2' => 0,
    'week_order' => 0,
    'month_order' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_5a1b63d09cf8d9_96766400',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a1b63d09cf8d9_96766400')) {function content_5a1b63d09cf8d9_96766400($_smarty_tpl) {?><?php if (!is_callable('smarty_function_link')) include 'D:\\WWW\\48ym\\system\\plugins/smarty\\function.link.php';
?><?php echo $_smarty_tpl->getSubTemplate ("biz/block/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="userIndex">
        <div class="userIndex_order_box" >
            <div class="userIndex_order lt">
                <ul>
                    <li class="userIndex_order_list">
                        <div class="lt">
                            <i class="lt ico ico_1"></i>
                            <div class="wz">
                                <p><?php echo L('待接订单');?>
</p>
                                <p class="num"><?php if ($_smarty_tpl->tpl_vars['wait_accept']->value>0){?><?php echo $_smarty_tpl->tpl_vars['wait_accept']->value;?>
<?php }else{ ?>0<?php }?></p>
                            </div>
                        </div>
                        <div class="rt"><a href="<?php echo smarty_function_link(array('ctl'=>'biz/order:index'),$_smarty_tpl);?>
" class="btn"><?php echo L('立即查看');?>
</a></div>
                        <div class="cl"></div>
                    </li>
                    <li class="userIndex_order_list">
                        <div class="lt">
                            <i class="lt ico ico_2"></i>
                            <div class="wz">
                                <p><?php echo L('待配送订单');?>
</p>
                                <p class="num"><?php if ($_smarty_tpl->tpl_vars['wait_peisong']->value>0){?><?php echo $_smarty_tpl->tpl_vars['wait_peisong']->value;?>
<?php }else{ ?>0<?php }?></p>
                            </div>
                        </div>
                        <div class="rt"><a href="<?php echo smarty_function_link(array('ctl'=>'biz/order:pei'),$_smarty_tpl);?>
" class="btn"><?php echo L('立即查看');?>
</a></div>
                        <div class="cl"></div>
                    </li>
                </ul>
            </div>
            <div class="userIndex_order rt">
                <ul>
                    <li class="userIndex_order_list">
                        <div class="lt">
                            <i class="lt ico ico_3"></i>
                            <div class="wz">
                                <p><?php echo L('今日完成订单');?>
</p>
                                <p class="num"><?php if ($_smarty_tpl->tpl_vars['today_order']->value>0){?><?php echo $_smarty_tpl->tpl_vars['today_order']->value;?>
<?php }else{ ?>0<?php }?></p>
                            </div>
                        </div>
                        <div class="rt"><a href="<?php echo smarty_function_link(array('ctl'=>'biz/order:complete'),$_smarty_tpl);?>
" class="btn"><?php echo L('立即查看');?>
</a></div>
                        <div class="cl"></div>
                    </li>
                    <li class="userIndex_order_list">
                        <div class="lt">
                            <i class="lt ico ico_4"></i>
                            <div class="wz">
                                <p><?php echo L('总完成订单');?>
</p>
                                <p class="num"><?php if ($_smarty_tpl->tpl_vars['all_order']->value>0){?><?php echo $_smarty_tpl->tpl_vars['all_order']->value;?>
<?php }else{ ?>0<?php }?></p>
                            </div>
                        </div>
                        <div class="rt"><a href="<?php echo smarty_function_link(array('ctl'=>'biz/order:complete'),$_smarty_tpl);?>
" class="btn"><?php echo L('立即查看');?>
</a></div>
                        <div class="cl"></div>
                    </li>
                </ul>
            </div>
            <div class="cl"></div>
        </div>
        <div class="userIndex">

            
            <div class="userIndex_table">
                <div class="userIndex_table_tab_box mb20">
                    <ul class="userIndex_table_tab">
                        <li class="list on"><?php echo L('收入统计');?>
</li>
                        <li class="list"><?php echo L('订单统计');?>
</li>
                    </ul>
                </div>
                <div class="userIndex_table_box">
                    <div class="userIndex_table_list">
                        <div class="userIndex_table_bt mb20">
                            <div class="lt bt"><?php echo L('收入统计');?>
</div>
                            <div class="rt">
                                <a href="" class="tab_list on"><em></em><?php echo L('近一周');?>
</a>
                                <a href="" class="tab_list"><em></em><?php echo L('近一月');?>
</a>
                            </div>
                            <div class="cl"></div>
                        </div>
                        <div class="userIndex_table_cont_box">
                            <div class="userIndex_table_cont" id="week_in_chart"><?php echo L('一周');?>
</div>
                            <div class="userIndex_table_cont" id="month_in_chart" style="display:none;"><?php echo L('一月');?>
</div>
                        </div>
                    </div>
                    <div class="userIndex_table_list" style="display:none;">
                        <div class="userIndex_table_bt mb20">
                            <div class="lt bt"><?php echo L('订单统计');?>
</div>
                            <div class="rt">
                                <a href="" class="tab_list on"><em></em><?php echo L('近一周');?>
</a>
                                <a href="" class="tab_list"><em></em><?php echo L('近一月');?>
</a>
                            </div>
                            <div class="cl"></div>
                        </div>
                        <div class="userIndex_table_cont_box">
                            <div class="userIndex_table_cont" id="week_order_chart"></div>
                            <div class="userIndex_table_cont" id="month_order_chart" style="display:none;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<script>
$(document).ready(function() {
    $(".userIndex_table_tab .list").each(function(a){
        $(this).mouseover(function(){
            $(this).parent().find(".list").removeClass("on");
            $(this).addClass("on");
            $(".userIndex_table_box .userIndex_table_list").each(function(b){
                if(a==b){
                    $(this).parent().find(".userIndex_table_list").hide();
                    $(this).show();
                }
                else{
                    $(this).hide();
                }
            });
        });
    });
    
    $(".userIndex_table_list").each(function(a){
        var obj = $(this);
        obj.find(".userIndex_table_bt .tab_list").mouseover(function(i) {
            obj.find(".userIndex_table_bt .tab_list").removeClass('on');
            $(this).addClass('on');
            var index = $(this).index();
            if( obj.find(".userIndex_table_cont_box .userIndex_table_cont").length >0){
                obj.find(".userIndex_table_cont_box .userIndex_table_cont").hide();
                obj.find(".userIndex_table_cont_box .userIndex_table_cont").eq(index).show();
            }
         }); 
     });
});
</script>



<script type="text/javascript">
(function(K, $){

})(window.KT, window.jQuery);
</script>
<?php echo $_smarty_tpl->getSubTemplate ("biz/block/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>



<script>
$(function () {
    $('#week_in_chart').highcharts({
        chart: {
            type: 'line'
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        title: {
            text: '<?php echo L("近一周收入曲线");?>
',
            x: -20 //center
        },

        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            categories: []
        },
        yAxis: {
            title: {
                text: '<?php echo L("收入");?>
 (<?php echo L("元");?>
)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ' <?php echo L("元");?>
'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: '<?php echo L("收入");?>
',
            data: [
                <?php  $_smarty_tpl->tpl_vars['v1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v1']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['week_in']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v1']->key => $_smarty_tpl->tpl_vars['v1']->value){
$_smarty_tpl->tpl_vars['v1']->_loop = true;
?>
                [<?php echo $_smarty_tpl->tpl_vars['v1']->value['date'];?>
,   <?php if (empty($_smarty_tpl->tpl_vars['v1']->value['money'])){?>0<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['v1']->value['money'];?>
<?php }?>],
                <?php } ?>
            ]
        }]
    });

    $('#month_in_chart').highcharts({
        title: {
            text: '<?php echo L("近一月收入曲线");?>
',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -90,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            title: {
                text: '<?php echo L("收入");?>
 (<?php echo L("元");?>
)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ' <?php echo L("元");?>
'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: '<?php echo L("收入");?>
',
            data: [
               <?php  $_smarty_tpl->tpl_vars['v2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v2']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['month_in']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v2']->key => $_smarty_tpl->tpl_vars['v2']->value){
$_smarty_tpl->tpl_vars['v2']->_loop = true;
?>
                [<?php echo $_smarty_tpl->tpl_vars['v2']->value['date'];?>
,   <?php if (empty($_smarty_tpl->tpl_vars['v2']->value['money'])){?>0<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['v2']->value['money'];?>
<?php }?>],
                <?php } ?>
            ]
        }]
    });

    $('#week_order_chart').highcharts({
        chart: {
            type: 'line'
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        title: {
            text: '<?php echo L("近一周订单量曲线");?>
',
            x: -20 //center
        },

        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            categories: []
        },
        yAxis: {
            title: {
                text: '<?php echo L("订单量");?>
 (<?php echo L("个");?>
)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ' <?php echo L("个");?>
'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: '<?php echo L("订单量");?>
',
            data: [
                <?php  $_smarty_tpl->tpl_vars['v1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v1']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['week_order']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v1']->key => $_smarty_tpl->tpl_vars['v1']->value){
$_smarty_tpl->tpl_vars['v1']->_loop = true;
?>
                [<?php echo $_smarty_tpl->tpl_vars['v1']->value['date'];?>
,   <?php if (empty($_smarty_tpl->tpl_vars['v1']->value['day_order'])){?>0<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['v1']->value['day_order'];?>
<?php }?>],
                <?php } ?>
            ]
        }]
    });

    $('#month_order_chart').highcharts({
        title: {
            text: '<?php echo L("近一月订单量曲线");?>
',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -90,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        },
        yAxis: {
            title: {
                text: '<?php echo L("订单量");?>
 (<?php echo L("个");?>
)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ' <?php echo L("个");?>
'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: '<?php echo L("订单量");?>
',
            data: [
                <?php  $_smarty_tpl->tpl_vars['v2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v2']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['month_order']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v2']->key => $_smarty_tpl->tpl_vars['v2']->value){
$_smarty_tpl->tpl_vars['v2']->_loop = true;
?>
                [<?php echo $_smarty_tpl->tpl_vars['v2']->value['date'];?>
,   <?php if (empty($_smarty_tpl->tpl_vars['v2']->value['day_order'])){?>0<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['v2']->value['day_order'];?>
<?php }?>],
                <?php } ?>
            ]
        }]
    });
});
</script><?php }} ?>