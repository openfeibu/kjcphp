<?php
class method extends baseclass
{
    /*
    [0] => Array
        (
            [id] => 26175
            [dno] => 14942998857420
            [shopuid] => 2874
            [shopid] => 173
            [shopname] => 光合体验店
            [shopphone] => 0371-8350453
            [shopaddress] => 开封市集英街一大道
            [buyeruid] => 6039
            [buyername] => 大写光合人
            [buyeraddress] => 河南省电子商务产业园1605
            [buyerphone] => 15738832712
            [status] => 1
            [is_acceptorder] => 0
            [paytype] => 1
            [paystatus] => 1
            [trade_no] => 4003282001201705090146580408
            [content] =>
            [ordertype] => 3
            [daycode] => 2
            [area1] =>
            [area2] =>
            [area3] =>
            [cxids] =>
            [cxcost] => 0.00
            [yhjcost] => 0
            [yhjids] =>
            [ipaddress] => 171.15.157.8???
            [scoredown] => 0
            [is_ping] => 0
            [isbefore] => 0
            [marketcost] => 0.00
            [marketps] => 0.00
            [shopcost] => 0.10
            [shopps] => 8.00
            [pstype] => 2
            [bagcost] => 0.00
            [addtime] => 1494299885
            [posttime] => 1494302285
            [passtime] => 1494299885
            [sendtime] => 0
            [suretime] => 0
            [allcost] => 0.10
            [buycode] => 188f75
            [othertext] =>
            [is_print] => 0
            [wxstatus] => 0
            [shoptype] => 0
            [is_make] => 0
            [is_reback] => 0
            [areaids] =>
            [psuid] =>
            [psusername] =>
            [psemail] =>
            [admin_id] => 410100
            [is_goshop] => 0
            [paytype_name] => weixin
            [taxcost] => 0.00
            [postdate] => 11:14-11:44
            [pttype] => 0
            [ptkg] =>
            [ptkm] =>
            [allkgcost] => 0.00
            [allkmcost] => 0.00
            [farecost] =>
            [dnos] => 0
            [shoplat] => 34.735325
            [shoplng] => 113.614724
            [buyerlat] => 34.802330
            [buyerlng] => 113.543806
            [psbflag] => 1
            [movegoodscost] =>
            [movegoodstype] =>
            [psyoverlng] =>
            [psyoverlat] =>
            [shopdowncost] => 0
            [acountname] => zem123456789101112131415161718192021222324252627282930313233
            [detlist] => Array
                (
                    [0] => Array
                        (
                            [id] => 18715
                            [order_id] => 26175
                            [goodsid] => 3483
                            [goodsname] => 微信支付测试商品
                            [goodscost] => 0.10
                            [goodscount] => 1
                            [status] => 0
                            [shopid] => 173
                            [is_send] => 0
                            [product_id] => 0
                            [have_det] => 0
                            [typeid] =>
                            [goodsattr] =>
                        )

                )

        )

    */
    //生成签名
    public function getsignature($data)
    {
        ksort($data);
        $stringA = '';
        $newarray = array();
        foreach ($data as $key=>$value) {
            $newarray[] = $key.'='.$value;
        }
        $stringA = implode('&', $newarray);

        $apimiyao = 'GHkj2004GHkj2004GHkj2004GHkj2004';
        $stringSignTemp = $stringA.'&key='.$apimiyao;
        print_R($stringSignTemp);
        $sign = strtoupper(md5($stringSignTemp));

        return $sign;
    }
    //测试退款操作
    public function wxrefundpay()
    {
        $datas = array();
        $datas['appid'] = 'wx90d68db4fe91edae';
        $datas['mch_id'] = '1302694901';
        $datas['nonce_str'] = md5(time().$datas['appid'].time().$datas['mch_id']);
        $datas['op_user_id'] = '1302694901';
        $datas['out_refund_no'] = '812749725686';
        $datas['total_fee'] = '100';
        $datas['refund_fee'] = '100';
        $datas['transaction_id'] = '4003282001201705090146580408';
        $datas['sign'] = $this->getsignature($datas);

        $newdataa = $this->ToXml($datas);
        #print_R($datas);

        $returnxml = $this->curl_post_ssl('https://api.mch.weixin.qq.com/secapi/pay/refund', $newdataa);
        $returndata = $this->FromXml($returnxml);
        print_r($returndata);
    }

    /**
     * 输出xml字符
     * @throws WxPayException
    **/
    public function ToXml($datas)
    {
        if (!is_array($datas)
            || count($datas) <= 0) {
            throw new WxPayException("数组数据异常！");
        }

        $xml = "<xml>";
        foreach ($datas as $key=>$val) {
            if (is_numeric($val)) {
                $xml.="<".$key.">".$val."</".$key.">";
            } else {
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
        * 将xml转为array
        * @param string $xml
        * @throws WxPayException
        */
    public function FromXml($returnxml)
    {
        if (!$returnxml) {
            throw new WxPayException("xml数据异常！");
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $data = json_decode(json_encode(simplexml_load_string($returnxml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $data;
    }
    public function curl_post_ssl($url, $vars, $second=30, $aHeader=array())
    {
        $ch = curl_init();
        //超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //这里设置代理，如果有的话
        //curl_setopt($ch,CURLOPT_PROXY, '10.206.30.98');
        //curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        //以下两种方式需选择一种

        //第一种方法，cert 与 key 分别属于两个.pem文件
        //默认格式为PEM，可以注释
        curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLCERT, getcwd().'/plug/pay/weixin/cert/apiclient_cert.pem');
        //默认格式为PEM，可以注释
        curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
        curl_setopt($ch, CURLOPT_SSLKEY, getcwd().'/plug/pay/weixin/cert/apiclient_key.pem');

        //第二种方式，两个文件合成一个.pem文件
        //	curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');

        if (count($aHeader) >= 1) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
        $data = curl_exec($ch);

        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            echo "call faild, errorCode:$error\n";
            curl_close($ch);
            return false;
        }
    }





    public function adminupload()  // 会员中心申请开店
    {
        $func = IFilter::act(IReq::get('func'));
        $obj = IReq::get('obj');
        $uploaddir =IFilter::act(IReq::get('dir'));
        if (is_array($_FILES)&& isset($_FILES['imgFile'])) {
            $uploaddir = empty($uploaddir)?'goods':$uploaddir;
            $json = new Services_JSON();
            $uploadpath = 'upload/'.$uploaddir.'/';
            $filepath = '/upload/'.$uploaddir.'/';
            $upload = new upload($uploadpath, array('gif','jpg','jpge','doc','png'));//upload 自动生成压缩图片
            $file = $upload->getfile();
            if ($upload->errno!=15&&$upload->errno!=0) {
                echo "<script>parent.".$func."(true,'".$obj."','".json_encode($upload->errmsg())."');</script>";
            } else {
                echo "<script>parent.".$func."(false,'".$obj."','".$filepath.$file[0]['saveName']."');</script>";
            }
            exit;
        }
        $data['obj'] = $obj;
        $data['uploaddir'] = $uploaddir;
        $data['func'] = $func;
        Mysite::$app->setdata($data);
    }

    public function saveupload()
    {
        $json = new Services_JSON();
        $uploadpath = 'upload/goods/';
        $filepath = Mysite::$app->config['imgserver'].'/upload/goods/';
        $upload = new upload($uploadpath, array('gif','jpg','jpge','png'));//upload
        $file = $upload->getfile();
        if ($upload->errno!=15&&$upload->errno!=0) {
            $msg = $json->encode(array('error' => 1, 'message' => $upload->errmsg()));
        } else {
            $msg = $json->encode(array('error' => 0, 'url' => $filepath.$file[0][saveName], 'trueurl' => $upload->returninfo['name']));
        }
        echo $msg;
        exit;
    }
    public function userupload()
    {
        $link = IUrl::creatUrl('member/login');
        // if($this->member['uid'] == 0&&$this->admin['uid'] == 0)  $this->message('未登陆',$link);
        $_FILES['imgFile'] = $_FILES['head'];
        $type = IFilter::act(IReq::get('type'));
        if (empty($type)) {
            $this->message('未定义的操作');
        }
        $json = new Services_JSON();
        $uploadpath = 'upload/user/';
        $filepath ='/upload/user/';
        $upload = new upload($uploadpath, array('gif','jpg','jpge','png'));//upload
        $file = $upload->getfile();
        if ($upload->errno!=15&&$upload->errno!=0) {
            $this->message($upload->errmsg());
        } else {
            if ($type == 'userlogo') {
                $arr['logo'] = $filepath.$file[0]['saveName'];
                $this->mysql->update(Mysite::$app->config['tablepre'].'member', $arr, 'uid = '.$this->member['uid'].' ');
            } elseif ($type == 'goods') {
                $shopid = ICookie::get('adminshopid');
                $gid = intval(IFilter::act(IReq::get('gid')));
                $data['img'] = $filepath.$file[0]['saveName'];
                $this->mysql->update(Mysite::$app->config['tablepre'].'goods', $data, "id='".$gid."' and shopid='".$shopid."'");
            } elseif ($type == 'shoplogo') {
                $shopid = ICookie::get('adminshopid');
                if (!empty($shopid)) {
                    $data['shoplogo'] = $filepath.$file[0]['saveName'];
                    $this->mysql->update(Mysite::$app->config['tablepre'].'shop', $data, "id='".$shopid."'");
                }
            }
            $this->success($filepath.$file[0]['saveName']);
        }
    }
    public function goodsupload()
    {
        $link = IUrl::creatUrl('member/login');
        if ($this->member['uid'] == 0&&$this->admin['uid'] == 0) {
            $this->message('未登陆', $link);
        }
        $type = IReq::get('type');
        $goodsid =  intval(IReq::get('goodsid'));
        $shopid = ICookie::get('adminshopid');
        if ($shopid < 0) {
            echo '无权限操作';
            exit;
        }
        if (is_array($_FILES)&& isset($_FILES['imgFile'])) {
            $json = new Services_JSON();
            $uploadpath = 'upload/shop/';
            $filepath ='/upload/shop/';
            $upload = new upload($uploadpath, array('gif','jpg','jpge','doc','png'));//upload
            $file = $upload->getfile();
            if ($upload->errno!=15&&$upload->errno!=0) {
                echo "<script>parent.uploaderror('".json_encode($upload->errmsg())."');</script>";
            } else {
                if ($goodsid > 0&& $shopid > 0) {
                    $data['img'] = $filepath.$file[0]['saveName'];
                    $this->mysql->update(Mysite::$app->config['tablepre'].'goods', $data, "id='".$goodsid."' and shopid='".$shopid."'");
                }
                echo "<script>parent.uploadsucess('".$filepath.$file[0]['saveName']."');</script>";
            }
            exit;
        }
        $imgurl ='';
        if ($goodsid > 0 && $type == 'goods') {
            $temp = $this->mysql->select_one("select img from ".Mysite::$app->config['tablepre']."goods where id='".$goodsid."' and shopid='".$shopid."'");
            $imgurl = $temp['img'];
        }
        Mysite::$app->setdata(array('type'=>$type,'goodsid'=>$goodsid,'imgurl'=>$imgurl));
    }


    /* 配送宝上传图片接口 */
    public function psbimgUpload()
    {
        $uploadname ='imgFile';//传入参数  用户名
        $json = new Services_JSON();
        $uploadpath = 'upload/psbimg/';//size 获取文件大小
        if (isset($_FILES[$uploadname])) {
            if ($_FILES[$uploadname]['error'] == 0) {//可以上传
                $upload1 = new upload($uploadpath, array('gif','jpg','jpge','doc','png'));
                $file1 = $upload1->getfile();

                if ($upload1->errno !=15 && $upload1->errno !=0) {
                    $this->message($upload1->errmsg());
                } else {
                    $data['psbimgUploadUrl'] = Mysite::$app->config['siteurl'].'/'.$uploadpath.$file1[0]['saveName'];
                    $this->success($data);
                }
            } else {
                $this->message('上传失败');
            }
        } else {
            $this->message('上传失败');
        }
    }
}
