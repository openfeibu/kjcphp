<?php
header("Content-type: text/html; charset=utf-8");
include 'HttpClient.php';

define('USER', 'kuaijiaocan1@163.com');	//*必填*：飞鹅云后台注册账号
define('UKEY', 'fgeUz5y5RFKTuAt3');	//*必填*: 飞鹅云注册账号后生成的UKEY

//以下参数不需要修改
define('IP', 'api.feieyun.cn');			//接口IP或域名
define('PORT', 80);						//接口IP端口
define('PATH', '/Api/Open/');		//接口路径
define('STIME', time());			    //公共参数，请求时间
define('SIG', sha1(USER.UKEY.STIME));   //公共参数，请求公钥


function addprinter($snlist)
{
    $content = array(
            'user'=>USER,
            'stime'=>STIME,
            'sig'=>SIG,
            'apiname'=>'Open_printerAddlist',

            'printerContent'=>$snlist
        );

    $client = new HttpClient(IP, PORT);
    if (!$client->post(PATH, $content)) {
        return false;
    } else {
        echo $client->getContent();
    }
}






/*
 *  方法1
    拼凑订单内容时可参考如下格式
    根据打印纸张的宽度，自行调整内容的格式，可参考下面的样例格式
*/
function wp_print($printer_sn, $orderInfo, $times)
{
    $content = array(
            'user'=>USER,
            'stime'=>STIME,
            'sig'=>SIG,
            'apiname'=>'Open_printMsg',

            'sn'=>$printer_sn,
            'content'=>$orderInfo,
            'times'=>$times//打印次数
        );

    $client = new HttpClient(IP, PORT);
    if (!$client->post(PATH, $content)) {
        return false;
    } else {
        //服务器返回的JSON字符串，建议要当做日志记录起来
        //return $client->getContent();
        return true;
    }
}





/*
 *  方法2
    根据订单索引,去查询订单是否打印成功,订单索引由方法1返回
*/
function queryOrderState($index)
{
    $msgInfo = array(
            'user'=>USER,
            'stime'=>STIME,
            'sig'=>SIG,
            'apiname'=>'Open_queryOrderState',

            'orderid'=>$index
        );

    $client = new HttpClient(IP, PORT);
    if (!$client->post(PATH, $msgInfo)) {
        return false;
    } else {
        $result = $client->getContent();
        echo $result;
    }
}




/*
 *  方法3
    查询指定打印机某天的订单详情
*/
function queryOrderInfoByDate($printer_sn, $date)
{
    $msgInfo = array(
            'user'=>USER,
            'stime'=>STIME,
            'sig'=>SIG,
            'apiname'=>'Open_queryOrderInfoByDate',

            'sn'=>$printer_sn,
            'date'=>$date
        );

    $client = new HttpClient(IP, PORT);
    if (!$client->post(PATH, $msgInfo)) {
        return false;
    } else {
        $result = $client->getContent();
        echo $result;
    }
}



/*
 *  方法4
    查询打印机的状态
*/
function queryPrinterStatus($printer_sn)
{
    $msgInfo = array(
            'user'=>USER,
            'stime'=>STIME,
            'sig'=>SIG,
            'apiname'=>'Open_queryPrinterStatus',

            'sn'=>$printer_sn
        );

    $client = new HttpClient(IP, PORT);
    if (!$client->post(PATH, $msgInfo)) {
        return false;
    } else {
        $result = $client->getContent();
        echo $result;
    }
}
