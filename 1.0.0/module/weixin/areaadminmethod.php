<?php
class method   extends areaadminbaseclass
{
    function ztymodehtml(){

        $type =intval(IFilter::act(IReq::get('type')));
        $default_cityid = $this->admin['cityid'];
        $ztymode = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."ztymode  where cityid = '".$default_cityid."'");
        if(empty($ztymode)){
            $ztymode['cityid']=$default_cityid;
            $ztymode['type']=1;
            $this->mysql->insert(Mysite::$app->config['tablepre'].'ztymode',$ztymode);
        }
        $allzty = $this->mysql->getarr("select a.indeximg as ztyimg,b.* from ".Mysite::$app->config['tablepre']."ztyimginfo as a left join  ".Mysite::$app->config['tablepre']."specialpage as b on a.ztyid = b.id  where b.cityid = '".$default_cityid."' and b.is_bd = 2 and a.type={$ztymode['type']} order by orderid asc");
        $data['list'] = $allzty;
        if($type>0){
            $ztymode['type'] = $type;
        }
        $data['ztymode'] = $ztymode;

        Mysite::$app->setdata($data);
    }

    //轮播图
    function imgflash(){
        $default_cityid = $this->admin['cityid'];
        $num = $this->mysql->counts("select id from ".Mysite::$app->config['tablepre']."adv  where cityid = '".$default_cityid."' and advtype= 'weixinlb'  ");
        if($num<5){
            for($i=1;$i<=5-$num;$i++){
                $data['advtype']='weixinlb';
                $data['img']="/upload/goods/20160109181719939.png";
                $data['linkurl']='#';
                $data['module'] =Mysite::$app->config['sitetemp'];
                $data['is_show'] =0;
                $data['sort'] =999;
                $data['cityid'] =$default_cityid;
                $this->mysql->insert(Mysite::$app->config['tablepre'].'adv',$data);
            }
        }
        $platpssetinfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."adv  where cityid = '".$default_cityid."' and advtype= 'weixinlb' order by sort asc limit 5 ");
        $data['list'] = $platpssetinfo;
        Mysite::$app->setdata($data);
    }

    //轮播图
    function imgflash2(){
        $default_cityid = $this->admin['cityid'];
        $num = $this->mysql->counts("select id from ".Mysite::$app->config['tablepre']."adv  where cityid = '".$default_cityid."' and advtype= 'weixinlb2'  ");
        if($num<5){
            for($i=1;$i<=5-$num;$i++){
                $data['advtype']='weixinlb2';
                $data['img']="/upload/goods/20160109181719939.png";
                $data['linkurl']='#';
                $data['module'] =Mysite::$app->config['sitetemp'];
                $data['is_show'] =0;
                $data['sort'] =999;
                $data['cityid'] =$default_cityid;
                $this->mysql->insert(Mysite::$app->config['tablepre'].'adv',$data);
            }
        }
        $platpssetinfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."adv  where cityid = '".$default_cityid."' and advtype= 'weixinlb2' order by sort asc limit 5 ");
        $data['list'] = $platpssetinfo;
        Mysite::$app->setdata($data);
    }


    //分类
    function classlist(){
        $default_cityid = $this->admin['cityid'];
        $num = $this->mysql->counts("select id from ".Mysite::$app->config['tablepre']."appadv  where cityid = '".$default_cityid."' and type= 2  ");
        if($num<16){
            $defaulrinfo = $this->mysql->select_one("select name,id from ".Mysite::$app->config['tablepre']."shoptype  where parent_id>0   limit 1");
            for($i=1;$i<=16-$num;$i++){
                //默认值
                $data['name']='美食外卖';
                $data['img']="/upload/goods/20160109181632354.png";
                $data['type']=2;
                $data['param']=$defaulrinfo['id'];
                $data['activity']='waimai';
                $data['is_show'] =0;
                $data['orderid'] =999;
                $data['cityid'] =$default_cityid;
                $this->mysql->insert(Mysite::$app->config['tablepre'].'appadv',$data);
            }
        }
        $catparent = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype  where  type='checkbox' order by cattype asc limit 0,100");
        $catlist = array();
        foreach($catparent as $key=>$value){
            $tempcat   = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."shoptype  where parent_id = '".$value['id']."'  limit 0,100");
            foreach($tempcat as $k=>$v){
                $catlist[] = $v;
            }
        }
        $data['catarr'] = array('0'=>'外卖','1'=>'超市');
        $data['catlist'] = $catlist;
        $platpssetinfo = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."appadv  where cityid = '".$default_cityid."' and type= 2 order by orderid asc limit 16 ");
        $data['list'] = $platpssetinfo;
        Mysite::$app->setdata($data);
    }
    //专题页
    function ztylist(){
        $default_cityid = $this->admin['cityid'];
        $ztymode = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."ztymode  where cityid = '".$default_cityid."'");
        $limit = 6-$ztymode['type'];
        $allzty = $this->mysql->getarr("select a.indeximg as ztyimg,a.is_show as is_hidden,a.id as ids,b.* from ".Mysite::$app->config['tablepre']."ztyimginfo as a left join  ".Mysite::$app->config['tablepre']."specialpage as b on a.ztyid = b.id  where b.cityid = '".$default_cityid."' and b.is_bd = 2 and a.type='".$ztymode['type']."' order by b.orderid asc limit {$limit}");
        $is_bdzty = $this->mysql->getarr("select * from ".Mysite::$app->config['tablepre']."specialpage  where cityid = '".$default_cityid."'  order by orderid asc");
        $data['ztymode'] = $ztymode;
        $data['list'] = $allzty;
        $data['zlist'] = $is_bdzty;
        Mysite::$app->setdata($data);
    }


    function saveappindex(){
        $default_cityid = $this->admin['cityid'];
        $type =IFilter::act(IReq::get('type'));
        $id =IFilter::act(IReq::get('id'));
        switch($type){
            case 'imgflash':
                $data['linkurl'] =IReq::get('i_links');
                $data['img'] =IReq::get('i_img_url');
                $data['sort'] =intval(IReq::get('i_orderid'));
                $data['module'] =Mysite::$app->config['sitetemp'];
                $data['title'] ="首页轮播图";
                $data['cityid'] =$default_cityid;
                $this->mysql->update(Mysite::$app->config['tablepre'].'adv',$data,"id='".$id."'");
                $this->success();
            case 'imgflash2':
                $data['linkurl'] =IReq::get('i_links');
                $data['img'] =IReq::get('i_img_url');
                $data['sort'] =intval(IReq::get('i_orderid'));
                $data['module'] =Mysite::$app->config['sitetemp'];
                $data['title'] ="首页广告位";
                $data['cityid'] =$default_cityid;
                $this->mysql->update(Mysite::$app->config['tablepre'].'adv',$data,"id='".$id."'");
                $this->success();
            case 'classlist':
                $cattypeid = IFilter::act(IReq::get('optclasslist'));//跳转属性指
                $name = trim(IFilter::act(IReq::get('name')));// 跳转属性
                $orderid = intval(IFilter::act(IReq::get('i_orderid')));
                $modeopt = intval(IFilter::act(IReq::get('modeopt')));
                $link = IReq::get('link');
                if(empty($cattypeid))$this->message('未选择模块');
                if(empty($name)) $this->message('请输入名称');
                $default_cityid = $this->admin['cityid'];
                $data['cityid'] = $default_cityid;
                $where = "  and cityid = '".$default_cityid."'  " ;
                if($cattypeid != 'lifehelp' && $cattypeid != 'shophui' && $cattypeid != 'paotui'){
                    $checkinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."shoptype  where  id='".$cattypeid."' order by cattype asc limit 0,100");
                    if(empty($checkinfo)) $this->message('未查找到分类值');
                    if($id > 0){
                        $checkinfo2 = $this->mysql->select_one("select param from ".Mysite::$app->config['tablepre']."appadv  where id='".$id."'  ".$where." ");
                        if($checkinfo2['param'] != $cattypeid){
                            $checkaa = $this->mysql->counts("select id from " . Mysite::$app->config['tablepre'] . "appadv  where  param='" . $cattypeid . "' and  type = '".$appposition."'   ".$where." 		");
                            if ($checkaa > 0) $this->message('跳转页面分类选项不可重复选择');
                        }
                    }else{
                        $checkinfo2 = $this->mysql->counts("select id from " . Mysite::$app->config['tablepre'] . "appadv  where  param='" . $cattypeid . "' and  type = '".$appposition."'   ".$where." 	 ");
                        if ($checkinfo2 > 0) $this->message('跳转页面分类选项不可重复选择');
                    }
                    $data['activity'] =  empty($checkinfo['cattype'])?'waimai':'market';
                }else{
                    if($cattypeid == 'lifehelp'){
                        $data['activity'] =  'lifehelp';
                    }
                    if($cattypeid == 'shophui'){
                        $data['activity'] =  'shophui';
                    }
                    if($cattypeid == 'paotui'){
                        $data['activity'] =  'paotui';
                    }
                    if($id > 0){
                        $checkinfo2 = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."appadv  where  id='".$id."'  ".$where."    ");
                        if($checkinfo2['param'] != $cattypeid){
                            $checkaa = $this->mysql->counts("select id from " . Mysite::$app->config['tablepre'] . "appadv  where  param='" . $cattypeid . "' and  type = '".$appposition. "'  ".$where."  ");
                            if ($checkaa>0) $this->message('跳转页面分类选项不可重复选择');
                        }
                    }else{
                        $checkinfo2 = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."appadv  where  param='".$cattypeid."' and type = '".$appposition."'  ".$where."   ");
                        if (!empty($checkinfo2)) $this->message('跳转页面分类选项不可重复选择');
                    }
                }
                $data['orderid'] = $orderid;
                $data['name'] = $name;
                $data['type'] = 2;
                $data['link'] = $link;
                $data['modeopt'] = $modeopt;
                $data['img'] = trim(IFilter::act(IReq::get('i_img_url')));
                if(empty($data['img'])) $this->message('图片为空');
                if($modeopt==2){
                    $data['param'] = 'weblink';
                }else{
                    $data['param'] = $cattypeid;
                }
                $this->mysql->update(Mysite::$app->config['tablepre'].'appadv',$data,"id='".$id."'");
                $this->success();
            case 'ztylist':
                $ztyid =IReq::get('ztyid');
                $ztytype =intval(IReq::get('ztytype'));
//                $data['indeximg'] =IReq::get('i_img_url');
                $data['ztystyle'] =$ztytype;
                $data['orderid'] =intval(IReq::get('i_orderid'));
                $data['cityid'] =$default_cityid;
                $data['is_bd'] =2;
                $ztyimginfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."ztyimginfo  where  cityid='".$default_cityid."' and ztyid = '".$ztyid."' and type = '".$ztytype."' ");
                if(!empty($ztyimginfo) && $ztyimginfo['id'] != $id){
                    $this->message("该专题页已添加，请勿重复操作");
                }
                $ztymode = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."ztymode  where  cityid='".$default_cityid."'");
                $ztymodedata['type'] = $ztytype;
                $ztymodedata['cityid'] = $default_cityid;
                if(empty($ztymode)){
                    $this->mysql->insert(Mysite::$app->config['tablepre'].'ztymode',$ztymodedata);
                }else{
                    $this->mysql->update(Mysite::$app->config['tablepre'].'ztymode',$ztymodedata,"cityid='".$default_cityid."'");
                }

                $ztyimgdata['type'] = $ztytype;
                $ztyimgdata['indeximg'] = IReq::get('i_img_url');
                $ztyimgdata['ztyid'] = $ztyid;
                $ztyimgdata['cityid'] = $default_cityid;

                if(empty($ztyimginfo)){
                    $this->mysql->insert(Mysite::$app->config['tablepre'].'ztyimginfo',$ztyimgdata);
                }else{
                    $this->mysql->update(Mysite::$app->config['tablepre'].'ztyimginfo',$ztyimgdata,"id='".$id."'");
                }
                $this->mysql->update(Mysite::$app->config['tablepre'].'specialpage',$data,"id='".$ztyid."'");
                $this->success();
        }
    }
    function ztymodetog(){
        $default_cityid = $this->admin['cityid'];
        $ztytype =intval(IReq::get('ztytype'));
        $ztymode = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."ztymode  where  cityid='".$default_cityid."'");
        $ztymodedata['type'] = $ztytype;
        $ztymodedata['cityid'] = $default_cityid;
        if(empty($ztymode)){
            $this->mysql->insert(Mysite::$app->config['tablepre'].'ztymode',$ztymodedata);
        }else{
            $this->mysql->update(Mysite::$app->config['tablepre'].'ztymode',$ztymodedata,"cityid='".$default_cityid."'");
        }
        $this->success();
    }
    function togdata(){
        $id =IFilter::act(IReq::get('id'));
        $type =IFilter::act(IReq::get('type'));
        $flag =IFilter::act(IReq::get('flag'));
        $ztystyle =IFilter::act(IReq::get('ztytype'));
        if(empty($id) || empty($type)) $this->message("提交失败");
        $data['is_show'] = $flag;
        switch($type){
            case 'imgflash':
                $this->mysql->update(Mysite::$app->config['tablepre'].'adv',$data,"id='".$id."'");
                $this->success();
            case 'imgflash2':
                $this->mysql->update(Mysite::$app->config['tablepre'].'adv',$data,"id='".$id."'");
                $this->success();
            case 'classlist':
                $this->mysql->update(Mysite::$app->config['tablepre'].'appadv',$data,"id='".$id."'");
                $this->success();
            case 'ztylist':
                $this->mysql->update(Mysite::$app->config['tablepre'].'ztyimginfo',$data,"ztyid='".$id."' and type=".$ztystyle." ");
                $this->success();
        }
    }


    public function uploadapp(){
        $uploaddir =IFilter::act(IReq::get('dir'));
        if(is_array($_FILES)&& isset($_FILES['imgFile']))
        {
            $uploaddir = empty($uploaddir)?'app':$uploaddir;
            $json = new Services_JSON();
            $uploadpath = 'upload/'.$uploaddir.'/';
            $filepath = '/upload/'.$uploaddir.'/';
            $upload = new upload($uploadpath,array('gif','jpg','jpge','doc','png'));//upload 自动生成压缩图片
            $file = $upload->getfile();
            $file[0]['saveName'] = $filepath.$file[0]['saveName'];
            if($upload->errno!=15&&$upload->errno!=0){
                $this->message($upload->errmsg());
            }else{
                $this->success($file);

            }
        }
    }
	function wxkefu(){
            
		$default_cityid = $this->admin['cityid'];
                
		$platpssetinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid = '".$default_cityid."'  ");
 		$data['station1'] = $platpssetinfo;
		Mysite::$app->setdata($data); 
	}
	 function savewxkefu(){
//		 limitalert();
		 $cityid = $this->admin['cityid'];
	 	 $platpssetinfo = $this->mysql->select_one("select * from ".Mysite::$app->config['tablepre']."platpsset  where cityid = '".$cityid."'  ");
		 
		 
             $data['cityid'] =  $cityid;
	     $data['wxkefu_open'] =  intval(IFilter::act(IReq::get('wxkefu_open'))); 
	     $data['wxkefu_ewm'] =  trim(IFilter::act(IReq::get('wxkefu_ewm'))); 
	     $data['wxkefu_phone'] =  trim(IFilter::act(IReq::get('wxkefu_phone'))); 
		 if( !empty($platpssetinfo) ){
			 $this->mysql->update(Mysite::$app->config['tablepre'].'platpsset',$data,"cityid='".$cityid."'");	 
		}else{
                    $this->mysql->insert(Mysite::$app->config['tablepre'].'platpsset',$data);
                } 
	    $this->success('success'); 
		 
	 }
 }
?>