<?php
class method extends baseclass
{
    public function setmydefadid()
    {
        $this->checkmemberlogin();
        $addressid = intval(IReq::get('addressid'));
        if (empty($addressid)) {
            $this->message('默认值错误');
        }
        $checkdata =   $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."address where id='".$addressid."' and userid = '".$this->member['uid']."' ");
        if (empty($checkdata)) {
            $this->message('该地址不属于你该账号');
        }
        $this->mysql->update(Mysite::$app->config['tablepre'].'address', array('default'=>0), 'userid = '.$this->member['uid'].' ');
        $this->mysql->update(Mysite::$app->config['tablepre'].'address', array('default'=>1), 'userid = '.$this->member['uid'].' and id='.$addressid.'');
        $this->success('success');
    }

    public function useraddress()
    {
        $this->checkmemberlogin();
        $data['addressid'] = intval(IReq::get('addressid'));
        $data['area_grade'] = empty(Mysite::$app->config['area_grade'])?1:Mysite::$app->config['area_grade'];
        $data['arealist'] = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."area  where  parent_id = 0 limit 0,100");

        $temparea =  $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."area   ");
        $areatoname = array();
        foreach ($temparea as $key=>$value) {
            $areatoname[$value['id']] = $value['name'];
        }
        $areatoname[0] = '';
        $data['areatoname'] = $areatoname;
        $data['addresslimit'] = Mysite::$app->config['addresslimit'];//限制绑定店铺数量
        Mysite::$app->setdata($data);
    }
    //id	userid	username	address 完整地址：选择地址与详细地址	phone	otherphone	contactname	default
    //areaid1 区域1ID	areaid2 区域2ID	areaid3 区域3ID	sex 1时是男性，值为2时是女性，值为0时是未知	bigadr 选择的地址
    //detailadr 详细地址	lat 地址坐标	lng 地址坐标	addtime
    public function saveaddress()
    {
        $this->checkmemberlogin();
        $addressid = intval(IReq::get('addressid'));
        $laiyuan = intval(IReq::get('laiyuan'));  // 地址来源，  1为PC端，PC端无坐标，不在微信端显示     手机端不传此参数，默认为0

        $arr['tag'] =  intval(IReq::get('tag'));
        if (empty($addressid)) {
            $checknum = $this->mysql->counts("select * from ".Mysite::$app->config['tablepre']."address where userid='".$this->member['uid']."' ");
            if (Mysite::$app->config['addresslimit'] < $checknum) {
                $this->message('member_addresslimit');
            }

            $arr['userid'] = $this->member['uid'];
            $arr['username'] = $this->member['username'];


            $arr['address'] =  IFilter::act(IReq::get('add_new'));
            $arr['phone'] = IFilter::act(IReq::get('phone'));
            $arr['otherphone'] = '';
            $arr['contactname'] = IFilter::act(IReq::get('contactname'));
            $check_message = IFilter::act(IReq::get('check_message'));
            $arr['sex'] =  IFilter::act(IReq::get('sex'));
            $arr['default'] = $checknum == 0?1:0;
            $arr['addtime'] = time();

            if (!(IValidate::len($arr['contactname'], 2, 6))) {
                $this->message('contactlength');
            }


            if (!(IValidate::phone($arr['phone']))) {
                $this->message('errphone');
            }
            if (strlen($arr['phone']) != "11") {
                $this->message('errphone');
            }

            // if (!(IValidate::len(IFilter::act(IReq::get('add_new')), 3, 50))) {
            //     $this->message('member_addresslength');
            // }

            $areacode = Mysite::$app->config['areacode'];
            if ($areacode  == 1) {
                $phonecls = new phonecode($this->mysql, 9, $arr['phone']);
                if ($phonecls->checkcode($check_message)) {
                } else {
                    $this->message($phonecls->getError());
                }
            }
            $arr['bigadr'] =  IFilter::act(IReq::get('bigadr'));
            $arr['lat'] =  IFilter::act(IReq::get('lat'));
            $arr['lng'] =  IFilter::act(IReq::get('lng'));
            $arr['detailadr'] =  IFilter::act(IReq::get('detailadr'));
            if ($laiyuan == 0 &&  Mysite::$app->config['addAreaType'] == 0) {
                // if (empty($arr['bigadr']) ||  $arr['bigadr'] == '点击选择地址') {
                //     $this->message('请选择地址！');
                // }
                if (empty($arr['detailadr'])) {
                    $this->message('请填写详细地址！');
                }
                // if (empty($arr['lat'])) {
                //     $this->message('获取地图坐标失败，请重新获取！');
                // }
                // if (empty($arr['lng'])) {
                //     $this->message('获取地图坐标失败，请重新获取！');
                // }
            }

            if (!empty($arr['otherphone'])&&!(IValidate::phone($arr['otherphone']))) {
                $this->message('errphone');
            }
            $this->mysql->insert(Mysite::$app->config['tablepre'].'address', $arr);
            $addid = $this->mysql->insertid();
            $this->mysql->update(Mysite::$app->config['tablepre'].'address', array('default'=>0), 'userid = '.$this->member['uid'].' ');
            $this->mysql->update(Mysite::$app->config['tablepre'].'address', array('default'=>1), 'userid = '.$this->member['uid'].' and id='.$addid.'');

            $this->success('success');
        } else {
            $arr['address'] =  IFilter::act(IReq::get('add_new'));
            $arr['phone'] = IFilter::act(IReq::get('phone'));
            $arr['otherphone'] = '';
            $arr['contactname'] = IFilter::act(IReq::get('contactname'));
            $arr['sex'] =  IFilter::act(IReq::get('sex'));
            $arr['addtime'] = time();

            if (!(IValidate::len($arr['contactname'], 2, 6))) {
                $this->message('contactlength');
            }
            // if (!(IValidate::len(IFilter::act(IReq::get('add_new')), 3, 50))) {
            //     $this->message('member_addresslength');
            // }

            if (!(IValidate::phone($arr['phone']))) {
                $this->message('errphone');
            }
            if (strlen($arr['phone']) != "11") {
                $this->message('errphone');
            }

            $check_message = IFilter::act(IReq::get('check_message'));
            if (Mysite::$app->config['areacode']==1) {
                $phonecls = new phonecode($this->mysql, 9, $arr['phone']);
                if ($phonecls->checkcode($check_message)) {
                } else {
                    $this->message($phonecls->getError());
                }
            }


            $arr['bigadr'] =  IFilter::act(IReq::get('bigadr'));
            $arr['lat'] =  IFilter::act(IReq::get('lat'));
            $arr['lng'] =  IFilter::act(IReq::get('lng'));
            $arr['detailadr'] =  IFilter::act(IReq::get('detailadr'));
            if ($laiyuan == 0 &&  Mysite::$app->config['addAreaType'] == 0) {
                // if (empty($arr['bigadr']) ||  $arr['bigadr'] == '点击选择地址') {
                //     $this->message('请选择地址！');
                // }
                if (empty($arr['detailadr'])) {
                    $this->message('请填写详细地址！');
                }
                // if (empty($arr['lat'])) {
                //     $this->message('获取地图坐标失败，请重新获取！');
                // }
                // if (empty($arr['lng'])) {
                //     $this->message('获取地图坐标失败，请重新获取！');
                // }
            }
            if (!empty($arr['otherphone'])&&!(IValidate::phone($arr['otherphone']))) {
                $this->message('errphone');
            }
            $this->mysql->update(Mysite::$app->config['tablepre'].'address', $arr, 'userid = '.$this->member['uid'].' and id='.$addressid.'');
            $this->mysql->update(Mysite::$app->config['tablepre'].'address', array('default'=>0), 'userid = '.$this->member['uid'].' ');
            $this->mysql->update(Mysite::$app->config['tablepre'].'address', array('default'=>1), 'userid = '.$this->member['uid'].' and id='.$addressid.'');
            $this->success('success');
        }
        $this->success('success');
    }
    public function deladdress()
    {
        $this->checkmemberlogin();
        $uid = intval(IReq::get('addressid'));
        if (empty($uid)) {
            $this->message('member_noexitaddress');
        }
        $this->mysql->delete(Mysite::$app->config['tablepre'].'address', "id = '$uid' and  userid='".$this->member['uid']."'");
        $this->success('success');
    }
    public function editaddress()
    {
        $this->checkmemberlogin();
        $what = trim(IFilter::act(IReq::get('what')));
        $addressid = intval(IReq::get('addressid'));
        if (empty($addressid)) {
            $this->message('member_noexitaddress');
        }
        if ($what == 'default') {
            $arr['default'] = 0;
            $this->mysql->update(Mysite::$app->config['tablepre'].'address', $arr, "userid='".$this->member['uid']."'");
            $arr['default'] = 1;
            $this->mysql->update(Mysite::$app->config['tablepre'].'address', $arr, "id='".$addressid."' and userid='".$this->member['uid']."' ");
            $this->success('success');
        } elseif ($what == 'addr') {
            $arr['address'] = IFilter::act(IReq::get('controlname'));
            if (!(IValidate::len($arr['address'], 3, 50))) {
                $this->message('member_addresslength');
            }
            $this->mysql->update(Mysite::$app->config['tablepre'].'address', $arr, "id='".$addressid."' and userid='".$this->member['uid']."' ");
            $this->success('success');
        } elseif ($what == 'phone') {
            $arr['phone'] = IFilter::act(IReq::get('controlname'));
            if (!IValidate::phone($arr['phone'])) {
                $this->message('errphone');
            }
            $this->mysql->update(Mysite::$app->config['tablepre'].'address', $arr, "id='".$addressid."' and userid='".$this->member['uid']."' ");
            $this->success('success');
        } elseif ($what == 'bak_phone') {
            $arr['otherphone'] = IFilter::act(IReq::get('controlname'));
            if (!IValidate::phone($arr['otherphone'])) {
                $this->message('errphone');
            }

            $this->mysql->update(Mysite::$app->config['tablepre'].'address', $arr, "id='".$addressid."' and userid='".$this->member['uid']."' ");
            $this->success('success');
        } elseif ($what == 'recieve_name') {
            $arr['contactname'] =  IFilter::act(IReq::get('controlname'));
            if (!(IValidate::len($arr['contactname'], 2, 6))) {
                $this->message('contactlength');
            }
            $this->mysql->update(Mysite::$app->config['tablepre'].'address', $arr, "id='".$addressid."' and userid='".$this->member['uid']."' ");
            $this->success('success');
        } else {
            $this->message('nodefined_func');
        }
    }
}
