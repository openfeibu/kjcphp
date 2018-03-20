<?php

/**
 * @class Cart
 * @brief 天气预报
 */
class orderclass
{
    private $error = '';
    private $orderid = '';

    //普通用户登录

    protected $ordmysql;
    public function __construct()
    {
        $this->ordmysql =new mysql_class();
    }
    //关闭订单






    //关闭订单通知
    public function noticeclose($orderid, $reason)
    {
        $orderinfo =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."order  where id= '".$orderid."'   ");
        if (!empty($orderinfo['buyeruid'])) {
            $smtp = new ISmtp(Mysite::$app->config['smpt'], 25, Mysite::$app->config['emailname'], Mysite::$app->config['emailpwd'], false);
            $wx_s = new wx_s();
            $appCls = new appbuyclass();
            //app信息
            $appcheck =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."appbuyerlogin where uid = '".$orderinfo['buyeruid']."'   ");
            $default_tpl = new config('tplset.php', hopedir);
            $tpllist = $default_tpl->getInfo();
            $orderinfo['reason'] = $reason;
            if (isset($tpllist['noticemake']) && !empty($tpllist['phoneunorder'])) {
                $emailcontent = Mysite::$app->statichtml($tpllist['phoneunorder'], $orderinfo);
                if (!empty($appcheck)) {
                    $tempuser[] = $appcheck;
                    $backinfo = $appCls->SetUserlist($tempuser)->sendNewmsg('订单被关闭', $emailcontent);
                }
                if (!empty($orderinfo['buyeruid'])) {
                    $wxbuyer = $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."wxuser  where uid= '".$orderinfo['buyeruid']."'   ");
                    if (!empty($wxbuyer)) {
                        if ($wx_s->sendmsg($emailcontent, $wxbuyer['openid'])) {
                        } else {
                            logwrite('微信客服发送错误:'.$wx_s->err());
                        }
                    }
                }
            }
        }
    }
    //制作订单通知 8.6更新
    public function noticemake($orderid)
    {
        $orderinfo =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."order  where id= '".$orderid."'   ");
        //自动生成配送单------
        if ($orderinfo['pstype'] == 0 && $orderinfo['is_goshop'] == 0) {//网站配送自动生成配送单

            $psylist =  $this->ordmysql->getarr("select a.*  from ".Mysite::$app->config['tablepre']."apploginps as a left join ".Mysite::$app->config['tablepre']."member as b on a.uid = b.uid where b.admin_id = ".$orderinfo['admin_id']."");
            $psCls = new apppsyclass();
            $psCls->SetUserlist($psylist)->sendNewmsg('订单提醒', '有新订单可以处理');
        }
        //配送单结束--------

        if (!empty($orderinfo['buyeruid'])) {
            $smtp = new ISmtp(Mysite::$app->config['smpt'], 25, Mysite::$app->config['emailname'], Mysite::$app->config['emailpwd'], false);
            $wx_s = new wx_s();
            $appCls = new appbuyclass();  //appBuyclass
            //app信息
            $appcheck =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."appbuyerlogin where uid = '".$orderinfo['buyeruid']."'   ");
            $default_tpl = new config('tplset.php', hopedir);
            $tpllist = $default_tpl->getInfo();
            if (isset($tpllist['noticemake']) && !empty($tpllist['noticemake'])) {
                $emailcontent = Mysite::$app->statichtml($tpllist['noticemake'], $orderinfo);
                if (!empty($appcheck)) {
                    $tempuser[] = $appcheck;
                    $backinfo = $appCls->SetUserlist($tempuser)->sendNewmsg('商家确认制作该订单', $emailcontent);
                }
                if (!empty($orderinfo['buyeruid'])) {
                    $wxbuyer = $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."wxuser  where uid= '".$orderinfo['buyeruid']."'   ");
                    if (!empty($wxbuyer)) {
                        if ($wx_s->sendmsg($emailcontent, $wxbuyer['openid'])) {
                        } else {
                            logwrite('微信客服发送错误:'.$wx_s->err());
                        }
                    }
                }
            }
        }
    }
    //不制作订单通知
    public function noticeunmake($orderid)
    {
        $orderinfo =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."order  where id= '".$orderid."'   ");
        if (!empty($orderinfo['buyeruid'])) {
            $smtp = new ISmtp(Mysite::$app->config['smpt'], 25, Mysite::$app->config['emailname'], Mysite::$app->config['emailpwd'], false);
            $wx_s = new wx_s();
            $appCls = new appbuyclass();
            //app信息
            $appcheck =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."appbuyerlogin where uid = '".$orderinfo['buyeruid']."'   ");
            $default_tpl = new config('tplset.php', hopedir);
            $tpllist = $default_tpl->getInfo();
            if (isset($tpllist['noticeunmake']) && !empty($tpllist['noticeunmake'])) {
                $emailcontent = Mysite::$app->statichtml($tpllist['noticeunmake'], $orderinfo);

                if (!empty($orderinfo['buyeruid'])) {
                    $wxbuyer = $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."wxuser  where uid= '".$orderinfo['buyeruid']."'   ");
                    if (!empty($wxbuyer)) {
                        if ($wx_s->sendmsg($emailcontent, $wxbuyer['openid'])) {
                        } else {
                            logwrite('微信客服发送错误:'.$wx_s->err());
                        }
                    }
                }
            }
        }
    }
    //退款成功通知
    public function noticeback($orderid)
    {
        $orderinfo =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."order  where id= '".$orderid."'   ");
        //-----------取消配送单---
        $checkpsinfo = $this->ordmysql->select_one("select * from ".Mysite::$app->config['tablepre']."orderps where orderid='".$orderinfo['id']."'   ");
        if (!empty($checkpsinfo)) {
            $psdata['status'] =4;
            $this->ordmysql->ordmysql(Mysite::$app->config['tablepre'].'orderps', $psdata, "id='".$checkpsinfo['id']."'");
        }
        //-----------取消配送单---
        if (!empty($orderinfo['buyeruid'])) {
            $smtp = new ISmtp(Mysite::$app->config['smpt'], 25, Mysite::$app->config['emailname'], Mysite::$app->config['emailpwd'], false);
            $wx_s = new wx_s();
            $appCls = new appbuyclass();
            $drawbacklog =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."drawbacklog  where orderid= '".$orderid."'   ");
            $orderinfo['reason'] = $drawbacklog['bkcontent'];

            //app信息
            $appcheck =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."appbuyerlogin where uid = '".$orderinfo['buyeruid']."'   ");
            $default_tpl = new config('tplset.php', hopedir);
            $tpllist = $default_tpl->getInfo();
            if (isset($tpllist['noticeback']) && !empty($tpllist['noticeback'])) {
                $emailcontent = Mysite::$app->statichtml($tpllist['noticeback'], $orderinfo);
                if (!empty($appcheck)) {
                    $tempuser[] = $appcheck;
                    $backinfo = $appCls->SetUserlist($tempuser)->sendNewmsg('退款成功', $emailcontent);
                }
                if (!empty($orderinfo['buyeruid'])) {
                    $wxbuyer = $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."wxuser  where uid= '".$orderinfo['buyeruid']."'   ");
                    if (!empty($wxbuyer)) {
                        if ($wx_s->sendmsg($emailcontent, $wxbuyer['openid'])) {
                        } else {
                            logwrite('微信客服发送错误:'.$wx_s->err());
                        }
                    }
                }
            }
        }
    }
    //发货通知
    public function noticesend($orderid)
    {
        $orderinfo =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."order  where id= '".$orderid."'   ");
        if (!empty($orderinfo['buyeruid'])) {
            $smtp = new ISmtp(Mysite::$app->config['smpt'], 25, Mysite::$app->config['emailname'], Mysite::$app->config['emailpwd'], false);
            $wx_s = new wx_s();
            $appCls = new appbuyclass();
            $drawbacklog =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."drawbacklog  where orderid= '".$orderid."'   ");
            $orderinfo['reason'] = $drawbacklog['bkcontent'];
            //app信息
            $appcheck =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."appbuyerlogin where uid = '".$orderinfo['buyeruid']."'   ");
            $default_tpl = new config('tplset.php', hopedir);
            $tpllist = $default_tpl->getInfo();
            if (isset($tpllist['noticesend']) && !empty($tpllist['noticesend'])) {
                $emailcontent = Mysite::$app->statichtml($tpllist['noticesend'], $orderinfo);
                if (!empty($appcheck)) {
                    $tempuser[] = $appcheck;
                    $backinfo = $appCls->SetUserlist($tempuser)->sendNewmsg("发货提示", $emailcontent);
                }
                if (!empty($orderinfo['buyeruid'])) {
                    $wxbuyer = $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."wxuser  where uid= '".$orderinfo['buyeruid']."'   ");
                    if (!empty($wxbuyer)) {
                        if ($wx_s->sendmsg($emailcontent, $wxbuyer['openid'])) {
                        } else {
                            logwrite('微信客服发送错误:'.$wx_s->err());
                        }
                    }
                }
                // $memberinfo = $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."member where uid = '".$orderinfo['buyeruid']."'   ");
                // if(IValidate::email($memberinfo['email'])){
                     // $info = $smtp->send($memberinfo['email'], Mysite::$app->config['emailname'],'发货通知',$emailcontent, "" , "HTML" , "" , "");
                // }
            }
        }
    }



    //退款失败通知
    public function noticeunback($orderid)
    {
        $orderinfo =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."order  where id= '".$orderid."'   ");
        if (!empty($orderinfo['buyeruid'])) {
            $smtp = new ISmtp(Mysite::$app->config['smpt'], 25, Mysite::$app->config['emailname'], Mysite::$app->config['emailpwd'], false);
            $wx_s = new wx_s();
            $appCls = new appbuyclass();
            $drawbacklog =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."drawbacklog  where orderid= '".$orderid."'   ");
            $orderinfo['reason'] = $drawbacklog['bkcontent'];
            //app信息
            $appcheck =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."appbuyerlogin where uid = '".$orderinfo['buyeruid']."'   ");
            $default_tpl = new config('tplset.php', hopedir);
            $tpllist = $default_tpl->getInfo();
            $emailcontent = Mysite::$app->statichtml($tpllist['noticeunback'], $orderinfo);
            if (!empty($appcheck)) {
                $tempuser[] = $appcheck;
                $backinfo = $appCls->SetUserlist($tempuser)->sendNewmsg("退款提示", $emailcontent);
            }
            if (!empty($orderinfo['buyeruid'])) {
                $wxbuyer = $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."wxuser  where uid= '".$orderinfo['buyeruid']."'   ");
                if (!empty($wxbuyer)) {
                    if ($wx_s->sendmsg($emailcontent, $wxbuyer['openid'])) {
                    } else {
                        logwrite('微信客服发送错误:'.$wx_s->err());
                    }
                }
            }
            // $memberinfo = $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."member where uid = '".$orderinfo['buyeruid']."'   ");
            // if(IValidate::email($memberinfo['email'])){
            // 	 $info = $smtp->send($shopinfo['email'], Mysite::$app->config['emailname'],'退款失败通知',$emailcontent, "" , "HTML" , "" , "");
            // }
        }
    }

    //发送下单通知
    public function sendmess($orderid)
    {
        require_once hopedir."class/printclass.php";

        $smtp = new ISmtp(Mysite::$app->config['smpt'], 25, Mysite::$app->config['emailname'], Mysite::$app->config['emailpwd'], false);
        $wx_s = new wx_s();
        $orderinfo =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."order  where id= '".$orderid."'   ");
        $orderdet =  $this->ordmysql->getarr("select *  from ".Mysite::$app->config['tablepre']."orderdet  where order_id= '".$orderid."'   ");
        $shopinfo =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shop  where id= '".$orderinfo['shopid']."'   ");
        $memberinfo =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."member  where uid= '".$orderinfo['buyeruid']."'   ");
        //负责人
        $senders = $this->ordmysql->getarr("select *  from ".Mysite::$app->config['tablepre']."member as m join  ".Mysite::$app->config['tablepre']."wxuser as wm on wm.uid =  m.uid  where m.stationadminid= '".$shopinfo['stationid']."'");

        $contents = '';
        $checknotice =  isset($shopinfo['noticetype'])? explode(',', $shopinfo['noticetype']):array();
        $contents = '';

        $orderpastatus = $orderinfo['paystatus'] == 1?'已支付':'未支付';
        $orderpaytype = $orderinfo['paytype'] == 1?'在线支付':'货到支付';
        $tempdata = array('orderinfo'=>$orderinfo,'orderdet'=>$orderdet,'sitename'=>Mysite::$app->config['sitename']);
        $open_acouttempdata = array('orderinfo'=>$orderinfo,'orderdet'=>$orderdet,'sitename'=>Mysite::$app->config['sitename'],'memberinfo'=>$memberinfo);



        /*
          $psCls = new apppsyclass();
         if( $orderinfo['shoptype'] == '100' ){
                       $psCls->sendall('订单提醒','有新订单待送货');
           }else{
               if($orderinfo['is_goshop'] == 0){

                       $psCls->sendbytag('订单提醒','有新订单待送货','admin_id'.$orderinfo['admin_id']);
               }
           }  */

        //打印机 通知商家

        if (!empty($shopinfo['machine_code'])&&!empty($shopinfo['mKey'])) {
            $temp_content = '';
            foreach ($orderdet as $km=>$vc) {
                $temp_content .= '<B><BOLD>'.$vc['goodsname'].'('.$vc['goodscount'].'份) ('.$vc['goodscost'].'元) </BOLD></B><BR>';
            }

            if ($orderinfo['is_goshop'] == 0 &&  $orderinfo['bagcost'] > 0) {
                $bagcostContent =  '打包费：'.$orderinfo['bagcost'].'元 <BR>';
            } else {
                $bagcostContent = '';
            }
            $msg = '<CB>#'.$orderinfo['daycode'].' '.Mysite::$app->config['sitename'].'</CB><BR>';
            $msg .= '<C><BOLD>*'.$shopinfo['shopname'].'*</BOLD></C><BR>';
            $msg .= '<L>姓名：'.$orderinfo['buyername'].'</L><BR>';
            $msg .= '<L>电话：'.$orderinfo['buyerphone'].'</L><BR>';
            $msg .= '<B>地址：'.$orderinfo['buyeraddress'].'</B><BR>';
            $msg .= '下单时间：'.date('m-d H:i', $orderinfo['addtime']).'<BR>';
            $msg .= '订单编号'.$orderinfo['dno'].'<BR>';
            $msg .= '--------------------------------<BR>';
            $msg .= ''.$temp_content.'';
            $msg .= '--------------------------------<BR>';
            $msg .= ''.$bagcostContent.'';
            $msg .= '配送费：'.$orderinfo['shopps'].'元<BR>';
            $msg .= '<B>合计：'.$orderinfo['allcost'].'元</B><BR>';
            $msg .= '--------------------------------<BR>';
            $msg .= '<B>备注'.$orderinfo['content'].'</B><BR>';
            $msg .= '谢谢惠顾，欢迎下次光临<BR>';

            $msg .= '*******************************<BR>';

            //把二维码字符串用标签套上即可自动生成二维码
            wp_print($shopinfo['machine_code'],$msg,1);
        }


        //微信通知商家
        $shopmember = $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."member where uid = '".$shopinfo['uid']."' ");
        $gmember = $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."member where guid = '".$shopmember['uid']."' ");
        if($gmember){
             $shopwxuser = $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."wxuser where uid = '".$gmember['uid']."' ");
             //（微信客服）
             /*
             if($shopwxuser){
                 $temp_content = $orderinfo['shopname'].'收到新的订单，共计'.$orderinfo['allcost'].'元\n';
                 $temp_content .='单号:'.$orderinfo['dno'].'\n';
                 $temp_content .='订单内容:'.$orderinfo['content'].'\n';
                 foreach ($orderdet as $km=>$vc) {
                     $temp_content .=$vc['goodsname'].'('.$vc['goodscount'].'份)\n';
                 }
                 $temp_content .='下单时间：'.date('m-d H:i', $orderinfo['addtime']).'\n';
                 $temp_content .='收货人:'.$orderinfo['buyername'].'\n';
                 $temp_content .='联系电话:'.$orderinfo['buyerphone'].'\n';
                 $temp_content .='地址:'.$orderinfo['buyeraddress'].'\n';
                 $temp_content .='请点详情及时处理订单，不要让顾客就等哦\n';

                 $dolink = Mysite::$app->config['siteurl'].'/index.php?ctrl=wxsite&action=shopordershow&orderid='.$orderinfo['id'];

                 $temp_content .= '<a href=\''.trim($dolink).'\' style=\'color:red\'>查看详情</a>';

                 if($wx_s->sendmsg($temp_content, $shopwxuser['openid'])){
                     logwrite('商家微信客服发送开始');
                 }else{
                     logwrite('商家微信客服发送错误:'.$wx_s->err());
                 }
             }*/
             //消息模板
             if($shopwxuser){
                 $temp_content = '';
                 foreach ($orderdet as $km=>$vc) {
                     $temp_content .=$vc['goodsname'].'('.$vc['goodscount'].'份)\n';
                 }
                 $template_id = '88eaR02txV8yKVNKmPDQOoXxresHFooXA2BByBaWVt4';
                 $dolink = Mysite::$app->config['siteurl'].'/index.php?ctrl=wxsite&action=shopordershow&orderid='.$orderinfo['id'];
                 $data = array(
                     "first" => array(
                             "value"=> $orderinfo['shopname'].'收到新的订单，单号：'.$orderinfo['dno'],
                             "color"=>"#173177"
                     ),
                     "keyword1"=>array(
                             "value"=> $temp_content,
                             "color"=>"#173177"
                     ),
                     "keyword2"=>array(
                             "value"=> $orderinfo['allcost'],
                             "color"=>"#173177"
                     ),
                     "keyword3"=>array(
                             "value"=>'微信支付',
                             "color"=>"#173177"
                     ),
                     "keyword4"=>array(
                             "value"=>$orderinfo['content'].'\n',
                             "color"=>"#173177"
                     ),
                     "remark"=> array(
                             "value"=>"请点详情及时处理订单，不要让顾客就等哦",
                             "color"=>"#173177"
                     ),
                 );
                 $wx_s->sendMbMessage($shopwxuser['openid'],$template_id,$data,$dolink);
             }
        }

    }
    /*配送员通知*/
    public function sendpsmess($orderid)
    {
        $wx_s = new wx_s();
        $orderinfo =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."order  where id= '".$orderid."'   ");
        $orderdet =  $this->ordmysql->getarr("select *  from ".Mysite::$app->config['tablepre']."orderdet  where order_id= '".$orderid."'   ");
        $shopinfo =  $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."shop  where id= '".$orderinfo['shopid']."'   ");
        //负责人
        $senders = $this->ordmysql->getarr("select *  from ".Mysite::$app->config['tablepre']."member as m join  ".Mysite::$app->config['tablepre']."wxuser as wm on wm.uid =  m.uid  where m.stationadminid= '".$shopinfo['stationid']."'");

        //微信通知配送员有效

        if (!empty($orderinfo['buyeruid'])) {
            // $wxbuyer = $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."wxuser  where uid= '".$orderinfo['buyeruid']."'   ");
            // if (!empty($wxbuyer)) {
                if ($orderinfo['is_goshop'] == 0 &&  $orderinfo['bagcost'] > 0) {
                    $bagcostContent =  ',打包费:'.$orderinfo['bagcost'].'元 ';
                } else {
                    $bagcostContent = '';
                }

                $temp_content = '在'.Mysite::$app->config['sitename'].'下单成功'.'\n';
                $temp_content .= '店铺：'.$orderinfo['shopname'].'\n';
                $temp_content .='下单时间：'.date('m-d H:i', $orderinfo['addtime']).'\n';
                // if ($orderinfo['shoptype'] == 100) {
                //     $temp_content .='配送时间：'. $orderinfo['postdate'].'\n';
                // } else {
                //     $temp_content .='配送时间：'.date('m-d H:i', $orderinfo['posttime']).'\n';
                // }
                // $temp_content .='支付方式'.$orderpaytype.','.$orderpastatus.' '.'\n';
                $temp_content .='收货人:'.$orderinfo['buyername'].'\n';
                $temp_content .='地址:'.$orderinfo['buyeraddress'].'\n';
                $temp_content .='联系电话:'.$orderinfo['buyerphone'].'\n';
                $temp_content .='单号:'.$orderinfo['dno'].'\n';
                $temp_content .='总价:'.$orderinfo['allcost'].'元'.$bagcostContent.',配送费:'.$orderinfo['shopps'].'元\n';
                $temp_content .='备注:'.$orderinfo['content'].'\n';
                foreach ($orderdet as $km=>$vc) {
                    $temp_content .=$vc['goodsname'].'('.$vc['goodscount'].'份)\n';
                }
                $contents = $to_sender = $temp_content;
                if (!empty($contents)) {

                    $to_sender = $orderinfo['buyername'].$to_sender;
                    foreach($senders as $senderkey => $sender){
                        if($wx_s->sendmsg($to_sender, $sender['openid'])){
                            logwrite('配送员微信客服发送开始');
                            sleep(0.5);
                        }else{
                            logwrite('配送员微信客服发送错误:'.$wx_s->err());
                        }
                    }
                }
            //}
        }
    }

    public function request_by_other($remote_server, $post_string)
    {
        $context = array(   'http' => array(
                                  'method' => 'POST',
                                 'header' => 'Content-type: application/x-www-form-urlencoded' .

                                           '\r\n'.'User-Agent : Jimmy\'s POST Example beta' .

                                           '\r\n'.'Content-length:' . strlen($post_string) + 8,
                               'content' => '' . $post_string)
                     );

        $stream_context = stream_context_create($context);

        $data = file_get_contents($remote_server, false, $stream_context);

        return $data;
    }
    public function getorder()
    {
        return $this->orderid;
    }
    public function ero()
    {
        return $this->error;
    }
    public function dosengprint($msg, $machine_code, $mKey)
    {
        $xmlData = '<xml>
 <mKey><![CDATA['.$mKey.']]></mKey >
<machine_code><![CDATA['.$machine_code.']]></machine_code >
<Content><![CDATA['.$msg.']]></Content >
</xml>';

        //第一种发送方式，也是推荐的方式：
$url = 'http://www.waimairen.com/print/wmr.php';  //接收xml数据的文件
$header[] = "Content-type: text/xml";        //定义content-type为xml,注意是数组
$ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
        }
        curl_close($ch);
    }
    //订单处理 普通订单处理

    public function makenormal($info)
    {
        //需要的公共数据
        //$data['othercontent'] = $info['othercontent'];
        // $data['cattype'] = $info['cattype'];//表示 是否是订台
        $data['areaids'] = $info['areaids'];
        $data['admin_id'] = $info['shopinfo']['admin_id'];
        $data['shoptype'] = $info['shopinfo']['shoptype'];//: 0:普通订单，1订台订单
        //获取店铺商品总价  获取超市商品总价
        $data['shopcost'] = $info['allcost'];
        $data['shopps'] = $info['shopps'];
        $data['addpscost'] = $info['addpscost'];


        $data['bagcost'] =  $info['bagcost'];
        $data['ordertype'] = $info['ordertype'];

        $data['buyerlng'] = $info['buyerlng'];
        $data['buyerlat'] = $info['buyerlat'];
        $data['shoplng'] = $info['shopinfo']['lng'];
        $data['shoplat'] = $info['shopinfo']['lat'];

        //支付方式检测
        $userid = $info['userid'];
        $data['paytype'] = $info['paytype'];
        $data['cxids'] = '';
        $data['cxcost'] = 0;
        $zpin = array();
        if ($data['shopcost'] > 0) {
            $sellrule =new sellrule();
            if ($info['platform']) {
                $platform=$info['platform'];
            } else {
                $platform=0;
            }
            $sellrule->setdata($info['shopinfo']['id'], $data['shopcost'] - $info['cxcosttotal'], $info['shopinfo']['shoptype'], $info['userid'], $platform, $data['paytype']);
            //		    $sellrule->setdata($info['shopinfo']['id'],$data['shopcost'],$info['shopinfo']['shoptype']);
            $ruleinfo = $sellrule->getdata();
            /*
            //判断是否存在打折商品
            foreach ($info['goodslist'] as $k=>$v) {
                if ($v['cxinfo']['is_cx']==1 &&  $v['cxinfo']['cxcost']>0) {
                    //如果存在打折商品 修改促销金额为0
                    $ruleinfo['downcost'] = 0;
                    $ruleinfo['nops'] = false;
                    break;
                }
            }
            */
            $data['pstype'] = $info['pstype'] ;
            $data['shopdowncost'] = $ruleinfo['shopdowncost'];//促销中  平台承担的部分
            $data['cxcost'] = $ruleinfo['downcost'];
            if ($ruleinfo['nops'] == true) {
                //存在免配送费时，把配送费算在促销金额中，平台配送情况下减免的配送费全部由平台承担，商家配送的情况下减免的配送费全部由商家承担
              if ($data['pstype'] == 1) {//商家配送
                  $data['shopdowncost'] = $data['shopdowncost'];
              } else { //平台配送
                  $data['shopdowncost'] = $data['shopdowncost'] + $data['shopps'];
              }
                $data['cxcost'] = $data['cxcost'] + $data['shopps'];
            }

            $data['cxids'] = $ruleinfo['cxids'];
            $zpin = $ruleinfo['zid'];//赠品
        }

        //判断优惠劵
        $allcost = $data['shopcost'];

        $data['yhjcost'] = 0;
        $data['yhjids'] = '';
        $userid = $info['userid'];
        $juanid = $info['juanid'];
        if ($juanid > 0 && $userid > 0) {
            $juaninfo = $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."juan  where id= '".$juanid."' and uid='".$userid."'  and status = 1 and endtime > ".time()." ");
            if (!empty($juaninfo)) {
                if ($allcost >= $juaninfo['limitcost']) {
                    $data['yhjcost'] =  $juaninfo['cost'];
                    $juandata['status'] = 2;
                    $juandata['usetime'] =  time();
                    $this->ordmysql->update(Mysite::$app->config['tablepre'].'juan', $juandata, "id='".$juanid."'");
                    $data['yhjids'] = $juanid;
                }
            }
        }

        //积分抵扣
        $allcost = $allcost - $data['cxcost'] - $data['yhjcost'];
        $data['scoredown'] = 0;
        $dikou = $info['dikou'];
        if (!empty($userid) && $dikou > 0 && Mysite::$app->config['scoretocost'] > 0 && $allcost > $dikou) {
            $checkuser= $this->ordmysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$userid."'  ");
            if (is_array($checkuser)) {
                $checkscore = $dikou*(intval(Mysite::$app->config['scoretocost']));
                if ($checkuser['score']  >= $checkscore) {
                    $data['scoredown'] =  $checkscore;
                    $this->ordmysql->update(Mysite::$app->config['tablepre'].'member', '`score`=`score`-'.$checkscore, "uid ='".$userid."' ");
                }
            }
        }
        $dikou = $data['scoredown'] > 0?$dikou:0;
        $allcost = $allcost-$dikou;
        $fupscost = isset($info['addpscost'])?$info['addpscost']:0;


        $data['allcost'] = $allcost+$data['shopps']+$fupscost+$data['bagcost']; //订单应收费用
        $data['allcost'] = $data['allcost']>=0?$data['allcost']:0;
        $data['shopps'] = $ruleinfo['nops'] == true?0:$data['shopps'];
        $data['shopps'] = $data['shopps'];
        $data['addpscost']=$fupscost;//增加附加配送费
        //检测店铺

        $data['shopuid'] = $info['shopinfo']['uid'];// 店铺UID
        $data['shopid'] =  $info['shopinfo']['id']; //店铺ID
        $data['stationid'] =  $info['shopinfo']['stationid']; //stationid
        $data['shopname'] = $info['shopinfo']['shopname']; //店铺名称
        $data['shopphone'] = $info['shopinfo']['phone']; //店铺电话
        $data['shopaddress'] = $info['shopinfo']['address'];// 店铺地址
        $data['buyeraddress'] = $info['addressdet'];
        $data['ordertype'] = $info['ordertype'];//来源方式;
        $data['buyeruid'] = $userid;// 购买用户ID，0未注册用户
        $data['buyername'] =  $info['username'];//购买热名称
        $data['buyerphone'] = $info['mobile'];// 联系电话
        $data['goodscxcost'] = $info['cxcosttotal']; //单个商品促销总价，用于佣金计算
        $panduan = Mysite::$app->config['man_ispass'];
        $data['status'] = 0;
        if ($panduan != 1 && $data['paytype'] == 0) {
            $data['status'] = 1;
        }
        $data['paystatus'] = 0;// 支付状态1已支付
        $data['content'] = $info['remark'];// 订单备注

        //  daycode 当天订单序号
        $data['ipaddress'] = $info['ipaddress'];
        $data['is_ping'] = 0;// 是否评价字段 1已评完 0未评
        $data['addtime'] = time();
        $data['posttime'] = $info['sendtime'];//: 配送时间

        //送达时间
        $sdtime = $info['shopinfo']['arrivetime']*60;
        //制作时间
        $mztime = $info['shopinfo']['maketime']*60;
        $ordertime1 = $data['addtime']+$sdtime+$mztime;
        $ordertime2 = $data['posttime'];
        //比如，如果客户点击立即下单，现在8.50  那就8.50+制作时间和配送时间。   如果客户现在下单，选择的是10.00-10.30，那就10.00是这个预计送达时间。如果客户选的是9.00-9.30送达，那就当前时间加上制作时间和配送时间。  意思就是说，
        //如果选择配送的时间段大于制作时间+配送时间的话，那就按配送时间段开启的那个时间设为预计送达时间。如果，客户选择的送达时间端，距离当前时间比较近，小于配送时间加制作时间的话，那么就从下单时间+制作时间+配送时间 得到预计送达时间
        if ($ordertime2 < $ordertime1) {
            $data['posttime'] = $ordertime1;
        }
        $data['postdate'] = $info['postdate'];//配送时间段
        $data['othertext'] = $info['othercontent'];//其他说明
        // if ($info['shopinfo']['is_autopreceipt'] ==1) {
        //   $data['is_make'] =1;
        //   $data['maketime'] =time();
        // }
        $data['is_goshop'] = 0;
        //  :审核时间
        $data['passtime'] = time();
        if ($data['status']  == 1) {
            $data['passtime'] == 0;
        }
        $data['buycode'] = substr(md5(time()), 9, 6);
        $data['dno'] = time().rand(1000, 9999);
        $minitime = strtotime(date('Y-m-d', time()));
        $tj = $this->ordmysql->select_one("select daycode,id from ".Mysite::$app->config['tablepre']."order where shopid='".$info['shopid']."' and addtime > ".$minitime." order by id desc limit 0,1000");

        $data['daycode'] = empty($tj)?1:$tj['daycode']+1;





        $this->ordmysql->insert(Mysite::$app->config['tablepre'].'order', $data);  //写主订单

        $orderid = $this->ordmysql->insertid();
        $sendmsgtops = false;
        /* 写订单物流 状态 */
        /* 第一步 提交成功 */
        $this->writewuliustatus($orderid, 1, $data['paytype']);

        $this->orderid = $orderid;
        foreach ($info['goodslist'] as $key=>$value) {
            $cmd['order_id'] = $orderid;
            $cmd['goodsid'] = isset($value['gg'])?$value['gg']['goodsid']:$value['id'];
            $cmd['goodsname'] = isset($value['gg'])?$value['name']."【".$value['gg']['attrname']."】":$value['name'];
            $cmd['goodscost'] = isset($value['gg'])?$value['gg']['cost']:$value['cost'];
            $cmd['goodscount'] = $value['count'];
            $cmd['shopid'] = $value['shopid'];
            $cmd['status'] = 0;
            $cmd['is_send'] = 0;
            $cmd['have_det'] = $value['have_det'];
            $cmd['product_id'] = isset($value['gg'])?$value['gg']['id']:0;
            $this->ordmysql->insert(Mysite::$app->config['tablepre'].'orderdet', $cmd);
            if (isset($value['gg'])) {
                $this->ordmysql->update(Mysite::$app->config['tablepre'].'product', '`stock`=`stock`-'.$cmd['goodscount'].' ', "id='".$cmd['product_id']."'");

                $this->ordmysql->update(Mysite::$app->config['tablepre'].'goods', '`sellcount`=`sellcount`+'.$cmd['goodscount'].' ', "id='".$cmd['goodsid']."'");

                $this->ordmysql->update(Mysite::$app->config['tablepre'].'goods', '`count`=`count`-'.$cmd['goodscount'].' ', "id='".$cmd['goodsid']."'");
            } else {
                $this->ordmysql->update(Mysite::$app->config['tablepre'].'goods', '`count`=`count`-'.$cmd['goodscount'].' ,`sellcount`=`sellcount`+'.$cmd['goodscount'], "id='".$cmd['goodsid']."'");
            }
        }

        if (is_array($zpin)&& count($zpin) > 0) {
            foreach ($zpin as $key=>$value) {
                $datadet['order_id'] = $orderid;
                $datadet['goodsid'] = $key;
                $datadet['goodsname'] = $value['presenttitle'];
                $datadet['goodscost'] = 0;
                $datadet['goodscount'] = 1;
                $datadet['shopid'] = $info['shopid'];
                $datadet['status'] = 0;
                $datadet['is_send'] = 1;
                $datadet['have_det']=0;
                $datadet['product_id'] =0;
                //更新促销规则中 此赠品的数量
                $this->ordmysql->insert(Mysite::$app->config['tablepre'].'orderdet', $datadet);
                $this->ordmysql->update(Mysite::$app->config['tablepre'].'rule', '`controlcontent`=`controlcontent`-1', "id='".$key."'");
            }
        }

        $checkbuyer = Mysite::$app->config['allowedsendbuyer'];
        $checksend = Mysite::$app->config['man_ispass'];
        if ($checksend != 1) {
            if ($data['status'] == 1) {
                $this->sendmess($orderid);
            }
        }
        if ($userid > 0) {
            $checkinfo =   $this->ordmysql->select_one("select * from ".Mysite::$app->config['tablepre']."address where userid='".$userid."'  ");
            if (empty($checkinfo)) {
                $addata['userid'] = $userid;
                $addata['username'] = $data['buyername'];
                $addata['address'] = $data['buyeraddress'];
                $addata['phone'] = $data['buyerphone'];
                $addata['contactname'] = $data['buyername'];
                $addata['default'] = 1;
                $this->ordmysql->insert(Mysite::$app->config['tablepre'].'address', $addata);
            }
        }
        if ($sendmsgtops == true) {
            // $psylist =  $this->ordmysql->getarr("select a.*  from ".Mysite::$app->config['tablepre']."apploginps as a left join ".Mysite::$app->config['tablepre']."member as b on a.uid = b.uid where b.admin_id = ".$data['admin_id']."");
            // $psCls = new apppsyclass();
            // $psCls->SetUserlist($psylist)->sendNewmsg('订单提醒','有新订单可以处理');
        }

        if ($data['paytype'] == 0) {
            if ($panduan == 0) {
                if ($data['is_make'] == 1) {
                    $this->writewuliustatus($orderid, 4, $data['paytype']);  //订单审核后自动 商家接单
                    $auto_send = Mysite::$app->config['auto_send'];
                    if ($auto_send == 1) {
                        //					  $this->writewuliustatus($orderid,2,$data['paytype']);//订单审核后自动 商家接单后自动发货
//					  $orderdatac['sendtime'] = time();
//					  $this->ordmysql->update(Mysite::$app->config['tablepre'].'order',$orderdatac,"id ='".$orderid."' ");
                    } else {
                        //自动生成配送单------|||||||||||||||-----------------------
                      if ($data['pstype'] == 0) {//网站配送自动生成配送费
                          /*
                            $psdata['orderid'] = $orderid;
                            $psdata['shopid'] = $data['shopid'];
                            $psdata['status'] =0;
                            $psdata['dno'] = $data['dno'];
                            $psdata['addtime'] = time();
                            $psdata['pstime'] = $data['posttime'];
                            $checkpsyset = Mysite::$app->config['psycostset'];
                            $bilifei =Mysite::$app->config['psybili']*0.01*$data['allcost'];
                            $psdata['psycost'] = $checkpsyset == 1?Mysite::$app->config['psycost']:$bilifei;
                            $this->ordmysql->insert(Mysite::$app->config['tablepre'].'orderps',$psdata);  //写配送订单
                              */
                          $sendmsgtops = true;
                      } elseif ($data['pstype'] == 2) {
                          $sendmsgtops = false;
                          $psbinterface = new psbinterface();
                          if ($psbinterface->psbnoticeorder($orderid)) {
                          }
                      }
                        //自动生成配送单结束-------------
                    }
                }
            }
        }
    }
    /*
    * $orderid  订单Id
    * $step 订单物流状态
    *
    *		function writewuliustatus($orderid,$step,$paytype){ }
    *
    *		  1 为订单提交成功 			2 为订单被管理员取消  			 3为在线支付成功    		 	4为商家确认制作  		5为商家取消订单
    *		  6 配送发货  				7 分配给配送员（配送员已接单）   8配送元已取货   		 		9 已完成（已送达） 	10 用户已确认收货
    *	      11用户已评价，完成订单   12用户自己取消订单（货到付款）    13用户取消订单，申请退款（在线支付）
    *		  14 管理员同意退款给用户      15 管理员拒绝退款给用户
    *
    * $paytype 支付方式 1 为在线支付 0为货到付款
    *
    */
    public function writewuliustatus($orderid, $step, $paytype)
    {
        $orderinfo =   $this->ordmysql->select_one("select shoptype,pttype from ".Mysite::$app->config['tablepre']."order where id='".$orderid."'  ");
        $statusdata['orderid']     =  $orderid;
        if ($orderinfo['shoptype'] ==100) {
            switch ($step) {
                case 1:
                    $statusdata['statustitle'] =  "订单已提交";
                    $statusdata['ststusdesc']  =  "订单未支付，请及时完成在线支付";
                    break;
                case 2:

                    break;
                case 3:
                    $statusdata['statustitle'] =  "在线支付成功";
                    $statusdata['ststusdesc']  =  "下单成功，请等待附近配送员抢单";
                    break;
                case 7:
                    $statusdata['statustitle'] =  "配送员已接单";
                    $statusdata['ststusdesc']  =  "配送员正赶往商家";
                    break;
                case 8:
                    if ($orderinfo['pttype']==2) {
                        $statusdata['statustitle'] =  "配送员已购买";
                        $statusdata['ststusdesc']  =  "正前往收货地，请耐心等待~";
                    } else {
                        $statusdata['statustitle'] =  "配送员已取货";
                        $statusdata['ststusdesc']  =  "正前往收货地，请耐心等待~";
                    }

                    break;
                /* 		case 9 :
                            $statusdata['statustitle'] =  "已送达";
                            $statusdata['ststusdesc']  =  "请确认收货";
                            break; */
                case 9:
                    $statusdata['statustitle'] =  "已完成订单";
                    $statusdata['ststusdesc']  =  "请评价订单";
                    break;
                case 10:
                    $statusdata['statustitle'] =  "已确认收货";
                    $statusdata['ststusdesc']  =  "请评价订单";
                    break;
                case 11:
                    $statusdata['statustitle'] =  "已完成订单";
                    $statusdata['ststusdesc']  =  "已评价";
                    break;
                case 12:
                    $statusdata['statustitle'] =  "已取消订单";
                    $statusdata['ststusdesc']  =  "已取消订单";
                    break;
                case 13:
                    $statusdata['statustitle'] =  "申请退款处理中";
                    $statusdata['ststusdesc']  =  "申请同意后,金额将于2个工作日内退还到您的支付账户";
                    break;
                case 14:
                    $statusdata['statustitle'] =  "退款成功";
                    $statusdata['ststusdesc']  =  "您可以在您对应的支付账户中查看退款";
                    break;
                case 15:
                    $statusdata['statustitle'] =  "拒绝退款";
                    $statusdata['ststusdesc']  =  "经审核，您的条件不符合退款标准";
                    break;
                default:
                    $this->message('nodefined_func');
                    break;
            }
        } else {
            switch ($step) {
                    case 1:
                        $statusdata['statustitle'] =  "订单已提交";
                        if ($paytype == 1) {
                            $statusdata['ststusdesc']  =  "订单未支付，请及时完成在线支付";
                        } else {
                            $statusdata['ststusdesc']  =  "订单已提交，请等待商家确认";
                        }
                        break;
                    case 2:

                        break;
                    case 3:
                        $statusdata['statustitle'] =  "在线支付成功";
                        $statusdata['ststusdesc']  =  "订单已在线支付成功";
                        break;
                    case 4:
                        $statusdata['statustitle'] =  "商家已接单";
                        $statusdata['ststusdesc']  =  "商家正在准备商品";
                        break;
                    case 5:
                        $statusdata['statustitle'] =  "商家取消订单";
                        if ($paytype == 1) {
                            $statusdata['ststusdesc']  =  "金额将于2个工作日内退还到您的支付账户";
                        }
                        break;
                    case 16:
                        $statusdata['statustitle'] =  "商家取消订单";
                        if ($paytype == 1) {
                            $statusdata['ststusdesc']  =  "订单已被取消";
                        }
                        break;
                    case 6:
                        $statusdata['statustitle'] =  "商家已发货";
                        $statusdata['ststusdesc']  =  "商品已经准备好";
                        break;
                    case 7:
                        $statusdata['statustitle'] =  "配送员已接单";
                        $statusdata['ststusdesc']  =  "配送员正赶往商家";
                        break;
                    case 8:
                        $statusdata['statustitle'] =  "配送员已取货";
                        $statusdata['ststusdesc']  =  "请耐心等待配送";
                        break;
            /* 		case 9 :
                        $statusdata['statustitle'] =  "已送达";
                        $statusdata['ststusdesc']  =  "请确认收货";
                        break; */
                        case 9:
                        $statusdata['statustitle'] =  "已完成订单";
                        $statusdata['ststusdesc']  =  "请评价订单";
                        break;
                    case 10:
                        $statusdata['statustitle'] =  "已确认收货";
                        $statusdata['ststusdesc']  =  "请评价订单";
                        break;
                    case 11:
                        $statusdata['statustitle'] =  "已完成订单";
                        $statusdata['ststusdesc']  =  "已评价";
                        break;
                    case 12:
                        $statusdata['statustitle'] =  "已取消订单";
                        $statusdata['ststusdesc']  =  "已取消订单";
                        break;
                    case 13:
                        $statusdata['statustitle'] =  "申请退款处理中";
                        $statusdata['ststusdesc']  =  "申请同意后,金额将于2个工作日内退还到您的支付账户";
                        break;
                    case 14:
                        $statusdata['statustitle'] =  "退款成功";
                        $statusdata['ststusdesc']  =  "您可以在您对应的支付账户中查看退款";
                        break;
                    case 15:
                        $statusdata['statustitle'] =  "拒绝退款";
                        $statusdata['ststusdesc']  =  "经审核，您的条件不符合退款标准";
                        break;
                    default:
                        $this->message('nodefined_func');
                        break;
                }
        }
        $statusdata['addtime']     =  time();
        $this->ordmysql->insert(Mysite::$app->config['tablepre'].'orderstatus', $statusdata);
    }
    //后台 代课下单
    public function houtaimakenormal($info)
    {
        //需要的公共数据
        //$data['othercontent'] = $info['othercontent'];
        // $data['cattype'] = $info['cattype'];//表示 是否是订台
        $data['areaids'] = $info['areaids'];
        $data['admin_id'] = $info['shopinfo']['admin_id'];
        $data['shoptype'] = $info['shopinfo']['shoptype'];//: 0:普通订单，1订台订单
        //获取店铺商品总价  获取超市商品总价
        $data['shopcost'] = $info['allcost'];
        $data['shopps'] = $info['shopps'];
        $data['bagcost'] =  $info['bagcost'];
        $data['ordertype'] = $info['ordertype'];
        //支付方式检测
        $userid = $info['userid'];
        $data['paytype'] = $info['paytype'];
        $data['cxids'] = '';
        $data['cxcost'] = 0;
        $zpin = array();
        if ($data['shopcost'] > 0) {
            $sellrule =new sellrule();
            $sellrule->setdata($info['shopinfo']['id'], $data['shopcost'], $info['shopinfo']['shoptype']);
            $ruleinfo = $sellrule->getdata();
            $data['shopdowncost'] = $ruleinfo['shopdowncost'];
            $data['cxcost'] = $ruleinfo['downcost'];
            $data['cxids'] = $ruleinfo['cxids'];
            $zpin = $ruleinfo['zid'];//赠品
            $data['shopps'] = $ruleinfo['nops'] == true?0:$data['shopps'];
        }
        //判断优惠劵
        $allcost = $data['shopcost'];
        $data['yhjcost'] = 0;
        $data['yhjids'] = '';
        $userid = $info['userid'];
        $juanid = $info['juanid'];
        if ($juanid > 0 && $userid > 0) {
            $juaninfo = $this->ordmysql->select_one("select *  from ".Mysite::$app->config['tablepre']."juan  where id= '".$juanid."' and uid='".$userid."'  and status = 1 and endtime > ".time()." ");
            if (!empty($juaninfo)) {
                if ($allcost >= $juaninfo['limitcost']) {
                    $data['yhjcost'] =  $juaninfo['cost'];
                    $juandata['status'] = 2;
                    $juandata['usetime'] =  time();
                    $this->ordmysql->update(Mysite::$app->config['tablepre'].'juan', $juandata, "id='".$juanid."'");
                    $data['yhjids'] = $juanid;
                }
            }
        }
        //积分抵扣
        $allcost = $allcost - $data['cxcost'] - $data['yhjcost'];
        $data['scoredown'] = 0;
        $dikou = $info['dikou'];
        if (!empty($userid) && $dikou > 0 && Mysite::$app->config['scoretocost'] > 0 && $allcost > $dikou) {
            $checkuser= $this->ordmysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$userid."'  ");
            if (is_array($checkuser)) {
                $checkscore = $dikou*(intval(Mysite::$app->config['scoretocost']));
                if ($checkuser['score']  >= $checkscore) {
                    $data['scoredown'] =  $checkscore;
                    $this->ordmysql->update(Mysite::$app->config['tablepre'].'member', '`score`=`score`-'.$checkscore, "uid ='".$userid."' ");
                }
            }
        }
        $dikou = $data['scoredown'] > 0?$dikou:0;
        $allcost = $allcost-$dikou;
        $fupscost = isset($info['addpscost'])?$info['addpscost']:0;
        $data['allcost'] = $allcost+$data['shopps']+$fupscost+$data['bagcost']; //订单应收费用
      $data['shopps'] = $data['shopps']+$fupscost;//增加附件配送费
        $data['pstype'] = $info['pstype'] ;
        //检测店铺

        $data['shopuid'] = $info['shopinfo']['uid'];// 店铺UID
      $data['shopid'] =  $info['shopinfo']['id']; //店铺ID
        $data['shopname'] = $info['shopinfo']['shopname']; //店铺名称
      $data['shopphone'] = $info['shopinfo']['phone']; //店铺电话
      $data['shopaddress'] = $info['shopinfo']['address'];// 店铺地址
      $data['buyeraddress'] = $info['addressdet'];
        $data['ordertype'] = $info['ordertype'];//来源方式;
      $data['buyeruid'] = $userid;// 购买用户ID，0未注册用户
        $data['buyername'] =  $info['username'];//购买热名称
        $data['buyerphone'] = $info['mobile'];// 联系电话
        $panduan = 0;

        $data['paystatus'] = 1;// 默认1已支付
      $data['paytype_name'] = 'open_acout';// 默认未余额支付
        $data['content'] = $info['remark'];// 订单备注

        //  daycode 当天订单序号
        $data['ipaddress'] = $info['ipaddress'];
        $data['is_ping'] = 0;// 是否评价字段 1已评完 0未评
        $data['addtime'] = time();
        $data['posttime'] = $info['sendtime'];//: 配送时间


        //送达时间
        $sdtime = $info['shopinfo']['arrivetime']*60;
        //制作时间
        $mztime = $info['shopinfo']['maketime']*60;
        $ordertime1 = $data['addtime']+$sdtime+$mztime;
        $ordertime2 = $data['posttime'];
        //比如，如果客户点击立即下单，现在8.50  那就8.50+制作时间和配送时间。   如果客户现在下单，选择的是10.00-10.30，那就10.00是这个预计送达时间。如果客户选的是9.00-9.30送达，那就当前时间加上制作时间和配送时间。  意思就是说，
        //如果选择配送的时间段大于制作时间+配送时间的话，那就按配送时间段开启的那个时间设为预计送达时间。如果，客户选择的送达时间端，距离当前时间比较近，小于配送时间加制作时间的话，那么就从下单时间+制作时间+配送时间 得到预计送达时间
        if ($ordertime2 < $ordertime1) {
            $data['posttime'] = $ordertime1;
        }


        $data['postdate'] = $info['postdate'];//配送时间段
      $data['othertext'] = $info['othercontent'];//其他说明
      if ($info['shopinfo']['is_autopreceipt'] == 1) {
          $data['is_make'] =1;
          $data['maketime'] =time();
      }

        //  :审核时间
        $data['passtime'] = time();
        $data['status'] = 1;
        if ($data['status']  == 1) {
            $data['passtime'] == 0;
        }
        $data['buycode'] = substr(md5(time()), 9, 6);
        $data['dno'] = time().rand(1000, 9999);
        $minitime = strtotime(date('Y-m-d', time()));
        $tj = $this->ordmysql->select_one("select daycode,id from ".Mysite::$app->config['tablepre']."order where shopid='".$info['shopid']."' and addtime > ".$minitime." order by id desc limit 0,1000");
        $data['daycode'] = empty($tj)?1:$tj['daycode']+1;
        $data['status'] = 1;
        $this->ordmysql->insert(Mysite::$app->config['tablepre'].'order', $data);  //写主订单

        $orderid = $this->ordmysql->insertid();

        $sendmsgtops = false;


        /* 写订单物流 状态 */
        /* 第一步 提交成功 */
        $this->writewuliustatus($orderid, 1, $data['paytype']);
        if ($data['paytype'] == 0) {
            if ($panduan == 0) {
                if ($data['is_make'] == 1) {
                    $this->writewuliustatus($orderid, 4, $data['paytype']);  //订单审核后自动 商家接单
                    $auto_send = Mysite::$app->config['auto_send'];
                    if ($auto_send == 1) {
                        $this->writewuliustatus($orderid, 6, $data['paytype']);//订单审核后自动 商家接单后自动发货
                        $orderdatac['sendtime'] = time();
                        $this->ordmysql->update(Mysite::$app->config['tablepre'].'order', $orderdatac, "id ='".$orderid."' ");
                    } else {
                        //自动生成配送单------|||||||||||||||-----------------------
                      if ($data['pstype'] == 0) {//网站配送自动生成配送费
                      /*
                          $psdata['orderid'] = $orderid;
                          $psdata['shopid'] = $data['shopid'];
                          $psdata['status'] =0;
                          $psdata['dno'] = $data['dno'];
                          $psdata['addtime'] = time();
                          $psdata['pstime'] = $data['posttime'];
                          $checkpsyset = Mysite::$app->config['psycostset'];
                          $bilifei =Mysite::$app->config['psybili']*0.01*$data['allcost'];
                          $psdata['psycost'] = $checkpsyset == 1?Mysite::$app->config['psycost']:$bilifei;
                          $this->ordmysql->insert(Mysite::$app->config['tablepre'].'orderps',$psdata);  //写配送订单
                        */
                          $sendmsgtops = true;
                      } elseif ($orderinfo['pstype'] == 2) {
                          $sendmsgtops = false;
                          $psbinterface = new psbinterface();
                          if ($psbinterface->psbnoticeorder($orderid)) {
                          }
                      }
                        //自动生成配送单结束-------------
                    }
                }
            }
        }

        $this->orderid = $orderid;
        foreach ($info['goodslist'] as $key=>$value) {
            $cmd['order_id'] = $orderid;
            $cmd['goodsid'] = $value['id'];
            $cmd['goodsname'] = $value['name'];
            $cmd['goodscost'] = $value['cost'];
            $cmd['goodscount'] = $value['count'];
            $cmd['shopid'] = $value['shopid'];
            $cmd['status'] = 0;
            $cmd['is_send'] = 0;
            $this->ordmysql->insert(Mysite::$app->config['tablepre'].'orderdet', $cmd);
            $this->ordmysql->update(Mysite::$app->config['tablepre'].'goods', '`count`=`count`-'.$cmd['goodscount'].' ,`sellcount`=`sellcount`+'.$cmd['goodscount'], "id='".$cmd['goodsid']."'");
        }

        if (is_array($zpin)&& count($zpin) > 0) {
            foreach ($zpin as $key=>$value) {
                $datadet['order_id'] = $orderid;
                $datadet['goodsid'] = $key;
                $datadet['goodsname'] = $value['presenttitle'];
                $datadet['goodscost'] = 0;
                $datadet['goodscount'] = 1;
                $datadet['shopid'] = $info['shopid'];
                $datadet['status'] = 0;
                $datadet['is_send'] = 1;
                //更新促销规则中 此赠品的数量
                $this->ordmysql->insert(Mysite::$app->config['tablepre'].'orderdet', $datadet);
                $this->ordmysql->update(Mysite::$app->config['tablepre'].'rule', '`controlcontent`=`controlcontent`-1', "id='".$key."'");
            }
        }

        $checkbuyer = Mysite::$app->config['allowedsendbuyer'];
        $checksend = Mysite::$app->config['man_ispass'];
        if ($checksend != 1) {
            if ($data['status'] == 1) {
                $this->sendmess($orderid);
            }
        }
        if ($userid > 0) {
            $checkinfo =   $this->ordmysql->select_one("select * from ".Mysite::$app->config['tablepre']."address where userid='".$userid."'  ");
            if (empty($checkinfo)) {
                $addata['userid'] = $userid;
                $addata['username'] = $data['buyername'];
                $addata['address'] = $data['buyeraddress'];
                $addata['phone'] = $data['buyerphone'];
                $addata['contactname'] = $data['buyername'];
                $addata['default'] = 1;
                $this->ordmysql->insert(Mysite::$app->config['tablepre'].'address', $addata);
            }
        }
        if ($sendmsgtops == true) {
            $psylist =  $this->ordmysql->getarr("select a.*  from ".Mysite::$app->config['tablepre']."apploginps as a left join ".Mysite::$app->config['tablepre']."member as b on a.uid = b.uid where b.admin_id = ".$data['admin_id']."");
            $psCls = new apppsyclass();
            $psCls->SetUserlist($psylist)->sendNewmsg('订单提醒', '有新订单可以处理');
        }
    }


    //预订订单
    public function orderyuding($info)
    {
        //$data['subtype'] = $info['subtype'];
        $data['is_goshop'] = $info['is_goshop'];
        $data['areaids'] = $info['areaids'];
        $data['admin_id'] = $info['shopinfo']['admin_id'];
        $data['shopcost'] = $info['allcost'];//:店铺商品总价
         $data['shopps'] = 0;//店铺配送费
         $data['shoptype'] = 0;//: 0:普通订单，1订台订单
         $data['bagcost']=0;//:打包费
         //获取店铺商品总价  获取超市商品总价
         $data['paytype'] = $info['paytype'];
        $data['cxids'] = '';
        $data['cxcost'] = 0;
        $data['yhjcost'] = 0;
        $data['yhjids'] = '';
        $data['scoredown'] = 0;
        $data['allcost'] =$info['allcost']; //订单应收费用
      $data['shopuid'] =$info['shopinfo']['uid'];// 店铺UID
        $data['shopid'] =  $info['shopinfo']['id']; //店铺ID
        $data['shopname'] =$info['shopinfo']['shopname']; //店铺名称
        $data['shopphone'] =  $info['shopinfo']['phone']; //店铺电话
        $data['shopaddress'] =$info['shopinfo']['address'];// 店铺地址
        $data['pstype'] = $info['pstype'] ;
        $data['shoptype'] = 0;
        $data['buyeraddress'] = '';
        $data['ordertype'] = $info['ordertype'];//来源方式;
      $data['buyeruid'] = $info['userid'];// 购买用户ID，0未注册用户
        $data['buyername'] =  $info['username'];//购买热名称
        $data['buyerphone'] = $info['mobile'];// 联系电话
      $data['paystatus'] = 0;// 支付状态1已支付
        $data['content'] = $info['remark'];// 订单备注
        //  daycode 当天订单序号
      $data['ipaddress'] = $info['ipaddress'];
        $data['is_ping'] = 0;// 是否评价字段 1已评完 0未评
        $data['addtime'] = time();

        $data['posttime'] = $info['sendtime'];//: 配送时间



        //送达时间
        $sdtime = $info['shopinfo']['arrivetime']*60;
        //制作时间
        $mztime = $info['shopinfo']['maketime']*60;
        $ordertime1 = $data['addtime']+$sdtime+$mztime;
        $ordertime2 = $data['posttime'];
        //比如，如果客户点击立即下单，现在8.50  那就8.50+制作时间和配送时间。   如果客户现在下单，选择的是10.00-10.30，那就10.00是这个预计送达时间。如果客户选的是9.00-9.30送达，那就当前时间加上制作时间和配送时间。  意思就是说，
        //如果选择配送的时间段大于制作时间+配送时间的话，那就按配送时间段开启的那个时间设为预计送达时间。如果，客户选择的送达时间端，距离当前时间比较近，小于配送时间加制作时间的话，那么就从下单时间+制作时间+配送时间 得到预计送达时间
        if ($ordertime2 < $ordertime1) {
            $data['posttime'] = $ordertime1;
        }




        $data['postdate'] = $info['postdate'];//配送时间段
      $data['othertext'] = $info['othercontent'];//其他说明
      //  :审核时间
      $data['passtime'] = time();
        $data['buycode'] = substr(md5(time()), 9, 6);
        $data['dno'] = time().rand(1000, 9999);
        $minitime = strtotime(date('Y-m-d', time()));
        $zpin = array();
        if ($info['subtype'] == 1) {
            // $this->message('订桌位');
           //
        } elseif ($info['subtype'] == 2) {
            $data['shopcost'] = $data['shopcost'];
            $data['cxids'] = '';
            $data['cxcost'] = 0;
            $cattype = $info['cattype'];
            if ($data['shopcost'] > 0) {
                $sellrule =new sellrule();
                $sellrule->setdata($info['shopid'], $data['shopcost'], $info['shopinfo']['shoptype']);
                $ruleinfo = $sellrule->getdata();
                $data['shopdowncost'] = $ruleinfo['shopdowncost'];
                $data['cxcost'] = $ruleinfo['downcost'];
                $data['cxids'] = $ruleinfo['cxids'];
                $zpin = $ruleinfo['zid'];//赠品
            }
            $data['allcost'] =   $data['shopcost'] - $data['cxcost'];
        }
        $panduan = Mysite::$app->config['man_ispass'];
        $data['status'] = 0;
        if ($panduan != 1 && $data['paytype'] == 0) {
            $data['status'] = 1;
        }

        if (Mysite::$app->config['allowed_is_make'] == 0) {
            $data['is_make'] =1;
            $data['maketime'] =time();
        }

        #$data['is_make'] = Mysite::$app->config['allowed_is_make'] == 1?0:1;
        $minitime = strtotime(date('Y-m-d', time()));
        $tj = $this->ordmysql->select_one("select count(id) as shuliang from ".Mysite::$app->config['tablepre']."order where shopid='".$info['shopid']."' and addtime > ".$minitime."  limit 0,1000");
        $data['daycode'] = $tj['shuliang']+1;
        $this->ordmysql->insert(Mysite::$app->config['tablepre'].'order', $data);  //写主订单
        $orderid = $this->ordmysql->insertid();

        $this->orderid = $orderid;



        /* 写订单物流 状态 */
        /* 第一步 提交成功 */
        $this->writewuliustatus($orderid, 1, $data['paytype']);
        if ($data['paytype'] == 0) {
            if ($panduan == 0) {
                if ($data['is_make'] == 1) {
                    $this->writewuliustatus($orderid, 4, $data['paytype']);  //订单审核后自动 商家接单
                    $auto_send = Mysite::$app->config['auto_send'];
                    if ($auto_send == 1) {
                        $orderdatac['sendtime'] = time();
                        $this->ordmysql->update(Mysite::$app->config['tablepre'].'order', $orderdatac, "id ='".$orderid."' ");
                        $this->writewuliustatus($orderid, 6, $data['paytype']);//订单审核后自动 商家接单后自动发货
                    }
                }
            }
        }





        if ($info['subtype'] == 2) {
            foreach ($info['goodslist'] as $key=>$value) {
                $cmd['order_id'] = $orderid;
                $cmd['goodsid'] = isset($value['gg'])?$value['gg']['goodsid']:$value['id'];
                $cmd['goodsname'] = isset($value['gg'])?$value['name']."【".$value['gg']['attrname']."】":$value['name'];
                $cmd['goodscost'] = isset($value['gg'])?$value['gg']['cost']:$value['cost'];
                $cmd['goodscount'] = $value['count'];
                $cmd['shopid'] = $value['shopid'];
                $cmd['status'] = 0;
                $cmd['is_send'] = 0;
                $cmd['have_det'] = $value['have_det'];
                $cmd['product_id'] = isset($value['gg'])?$value['gg']['id']:0;
                $this->ordmysql->insert(Mysite::$app->config['tablepre'].'orderdet', $cmd);
                if (isset($value['gg'])) {
                    $this->ordmysql->update(Mysite::$app->config['tablepre'].'product', '`stock`=`stock`-'.$cmd['goodscount'].' ', "id='".$cmd['product_id']."'");

                    $this->ordmysql->update(Mysite::$app->config['tablepre'].'goods', '`sellcount`=`sellcount`+'.$cmd['goodscount'].' ', "id='".$cmd['goodsid']."'");
                } else {
                    $this->ordmysql->update(Mysite::$app->config['tablepre'].'goods', '`count`=`count`-'.$cmd['goodscount'].' ,`sellcount`=`sellcount`+'.$cmd['goodscount'], "id='".$cmd['goodsid']."'");
                }
            }
            if (is_array($zpin)&& count($zpin) > 0) {
                foreach ($zpin as $key=>$value) {
                    $datadet['order_id'] = $orderid;
                    $datadet['goodsid'] = $key;
                    $datadet['goodsname'] = $value['presenttitle'];
                    $datadet['goodscost'] = 0;
                    $datadet['goodscount'] = 1;
                    $datadet['shopid'] = $info['shopid'];
                    $datadet['status'] = 0;
                    $datadet['is_send'] = 1;
                    $datadet['have_det'] = 0;
                    $datadet['product_id'] = 0;
                    //更新促销规则中 此赠品的数量
                    $this->ordmysql->insert(Mysite::$app->config['tablepre'].'orderdet', $datadet);
                    $this->ordmysql->update(Mysite::$app->config['tablepre'].'rule', '`controlcontent`=`controlcontent`-1', "id='".$key."'");
                }
            }
        }

        $checkbuyer = Mysite::$app->config['allowedsendbuyer'];
        $checksend = Mysite::$app->config['man_ispass'];
        if ($checksend != 1) {
            if ($data['status'] == 1) {
                $this->sendmess($orderid);
            }
        }
    }
    public function handleOrderStatus($order)
    {
        $status = '';
        if ($order['status'] == 0) {
            $status = "待付款";
        }
        if ($order['status'] == 1 && $order['is_reback'] ==0) {
            if ($order['is_make'] == 0) {
                $status = "待商家确认";
            } elseif ($order['is_make'] == 1) {
                $status = '待发货';
            }
        }else if($order['status'] ==1 && $order['is_reback'] ==1){
            $status = "退款中";
        }else if($order['status'] ==1 && $order['is_reback'] ==2){
            $status = "已退款";
        }else if($order['status'] ==1 && $order['is_reback'] ==3){
            $status = "拒绝退款";
        }else if($order['status'] ==1 && $order['is_reback'] ==4){
            $status = "退款中";
        }
        if($order['status'] == 2){
            $status = "已发货";
        }
        if($order['status'] == 3){
            $status = "已收货";
        }
        if($order['status'] == 4 && $order['is_reback'] !=2){
            $status = "已取消";
        }else if($order['status'] == 4 && $order['is_reback'] ==2){
            $status = "已退款";
        }
        if($order['status'] == 5){
            $status = "已退款";
        }
        /*
        if ($order['is_reback'] == 0) {
            if ($order['status'] == 0) {
                $status = "待付款";
            } else if ($order['status'] == 1) {
                if ($order['is_make'] == 0) {
                    $status = "待商家确认";
                } elseif ($order['is_make'] == 1) {
                    $status = '待发货';
                }
            } elseif ($order['status'] == 2) {
                $status = "已发货";
            } elseif ($order['status'] == 3) {
                $status = "已完成";
            } else{
                $status = "已取消";
            }
        } else {
            if ($order['is_reback'] == 1) {
                $status = "退款中";
            } elseif ($order['is_reback'] == 2) {
                $status = "已退款";
            } elseif ($order['is_reback'] == 4) {
                $status = "退款中";
            } else {
                $status = "待处理";
            }
        }*/
        return $status;
    }
    /*
    shopdowncost：满减平台承担优惠
    allcost：用户付总费用
    shopps：费送费
    bagcost：打包费
    goodscxcost：促销价格（不参与佣金）
    yhjcost:优惠券价格，平台承担优惠
    */
    public function clearing($orderinfo)
    {
        if($orderinfo['is_js'] != 1)
        {
            $jstime = date("Y-m-d");
            $shopinfo = $this->ordmysql->select_one("select * from ".Mysite::$app->config['tablepre']."shop where id='".$orderinfo['shopid']."' ");
            $this->ordmysql->update(Mysite::$app->config['tablepre'].'order', array('is_js' => 1), "id = '".$orderinfo['id']."' ");
            $yjbl = $shopinfo['yjin']< 1?Mysite::$app->config['yjin']:$shopinfo['yjin'];
            $newdata['yjb'] = empty($yjbl)?0:$yjbl;
            $shop_getcost = $orderinfo['allcost']-$orderinfo['shopps']-$orderinfo['bagcost'];
            $yjcost =  ($shop_getcost-$orderinfo['goodscxcost'])*$yjbl*0.01;
            $newdata['onlinecount'] = 1;
            $newdata['onlinecost'] = $shop_getcost;
            $newdata['unlinecount'] = 0;
            $newdata['unlinecost'] = 0;
            $newdata['acountcost'] = $shop_getcost-$yjcost+$orderinfo['shopdowncost']+$orderinfo['yhjcost'];
            $newdata['goodscxcost'] = $orderinfo['goodscxcost'];
            $newdata['yjcost'] = $yjcost;
            $newdata['pstype'] = $sendtype = 1;
            $newdata['shopid'] = $shopinfo['id'];
            $newdata['shopuid'] = $shopinfo['uid'];
            //平台承担费用
            $newdata['shopdowncost'] = $orderinfo['shopdowncost'] + $orderinfo['yhjcost'];
            $newdata['addtime'] = time();
            $newdata['jstime'] = time();
            $newdata['orderid'] = $orderinfo['id'];
            $this->ordmysql->insert(Mysite::$app->config['tablepre'].'shopjs', $newdata);

            $orderid = $this->ordmysql->insertid();
            /***自动  更新用户 账号余额***/
            $memberinfo = $this->ordmysql->select_one("select * from ".Mysite::$app->config['tablepre']."member where uid='".$shopinfo['uid']."' ");
             $this->ordmysql->update(Mysite::$app->config['tablepre'].'member','`shopcost`=`shopcost`+'.$newdata['acountcost'],"uid ='".$shopinfo['uid']."' ");
            $newdatac['cost'] = $newdata['acountcost'];
            $newdatac['type'] = 3;
            $newdatac['status'] = 2;
            $newdatac['addtime'] = time()+1;
            $newdatac['shopid'] = 0;
            $newdatac['shopuid'] =  $shopinfo['uid'];
            $newdatac['name'] = $jstime.'日结算转入';
            $newdatac['yue'] = $memberinfo['shopcost']+$newdata['acountcost'];
            $newdatac['jsid'] = $orderid;
            //账号余额
            $this->ordmysql->insert(Mysite::$app->config['tablepre'].'shoptx', $newdatac);

            return 'success';
        }
    }
}
