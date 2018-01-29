<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Shop_Shop extends Ctl
{
    public function index($page=1)
    {
    	$filter = $pager = array();
    	$pager['page'] = max(intval($page), 1);
    	$pager['limit'] = $limit = 50;
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['city_id']){$filter['city_id'] = $SO['city_id'];}
            if($SO['cate_id']){$filter['cate_id'] = $SO['cate_id'];}
            if($SO['mobile']){$filter['mobile'] = $SO['mobile'];}
            if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
            if($SO['addr']){$filter['addr'] = "LIKE:%".$SO['addr']."%";}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        $filter['closed'] = 0;
        if($items = K::M('shop/shop')->items($filter, null, $page, $limit, $count)){
        	$pager['count'] = $count;
        	$pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:shop/shop/items.html';
    }

    public function so($target=null, $multi=null)
    {
        if($target){
            $pager['multi'] = $multi == 'Y' ? 'Y' : 'N';
            $pager['target'] = $target;
        }
        $this->pagedata['pager'] = $pager; 
        $this->tmpl = 'admin:shop/shop/so.html';
    }


    public function dialog($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 10;
        $pager['multi'] = $multi = ($this->GP('multi') == 'Y' ? 'Y' : 'N');
        if($SO = $this->GP('SO')){
            $pager['SO'] = $SO;
            if($SO['city_id']){$filter['city_id'] = $SO['city_id'];}
            if($SO['cate_id']){$filter['cate_id'] = $SO['cate_id'];}
            if($SO['mobile']){$filter['mobile'] = $SO['mobile'];}
            if($SO['title']){$filter['title'] = "LIKE:%".$SO['title']."%";}
            if($SO['addr']){$filter['addr'] = "LIKE:%".$SO['addr']."%";}
            if(is_array($SO['dateline'])){if($SO['dateline'][0] && $SO['dateline'][1]){$a = strtotime($SO['dateline'][0]); $b = strtotime($SO['dateline'][1])+86400;$filter['dateline'] = $a."~".$b;}}
        }
        $filter['closed'] = 0;
        if($items = K::M('shop/shop')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')), array('SO'=>$SO, 'multi'=>$multi));
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:shop/shop/dialog.html';   
    }

    public function detail($shop_id = null)
    {
        if(!$shop_id = (int)$shop_id){
            $this->msgbox->add('未指定要查看内容的ID', 211);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('您要查看的内容不存在或已经删除', 212);
        }else{
            $this->pagedata['detail'] = $detail;
            $this->tmpl = 'admin:shop/shop/detail.html';
        }
    }

    public function product($shop_id=null)
    {
        if(!$shop_id = (int)$shop_id){
            $this->err->add('未指定隶属商铺', 211);
        }else if(!$shop = K::M('shop/shop')->detail($shop_id, true)){
            $this->err->add('指定的商铺不存在或删除', 212);
        }else{
            $filter = array('shop_id'=>$shop_id, 'closed'=>0);
            if($items = K::M('product/product')->items($filter, null, $page, $limit, $count)){
                $pager['count'] = $count;
                $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array($shop_id, '{page}')));
                $this->pagedata['items'] = $items;
            }
            $this->pagedata['shop'] = $shop;
            $this->tmpl = 'admin:shop/shop/product/index.html';
        } 
    }
    
    
    public function create()
    {
        if($data = $this->checksubmit('data')){
            if($_FILES['data']){
                foreach($_FILES['data'] as $k=>$v){
                    foreach($v as $kk=>$vv){
                        $attachs[$kk][$k] = $vv;
                    }
                }
                $upload = K::M('magic/upload');
                foreach($attachs as $k=>$attach){
                    if($attach['error'] == UPLOAD_ERR_OK){
                        if($a = $upload->upload($attach, 'shop')){
                            $data[$k] = $a['photo'];
                        }
                    }
                }
            }

            
            if($shop_id = K::M('shop/shop')->create($data)){
                $this->msgbox->add('添加内容成功');
                $this->msgbox->set_data('forward', '?shop/shop-index.html');
            } 
        }else{
           $this->tmpl = 'admin:shop/shop/create.html';
        }
    }

    public function edit($shop_id=null)
    {
        if(!($shop_id = (int)$shop_id) && !($shop_id = $this->GP('shop_id'))){
            $this->msgbox->add('未指定要修改的内容ID', 211);
        }else if(!$detail = K::M('shop/shop')->detail($shop_id)){
            $this->msgbox->add('您要修改的内容不存在或已经删除', 212);
        }else if($data = $this->checksubmit('data')){
            if($data['tixian_percent']<0 || $data['tixian_percent']>100) {
                $this->msgbox->add('提现比例请填写0~100之间的数字', 213);
            }else {
                if($_FILES['data']){
                    foreach($_FILES['data'] as $k=>$v){
                        foreach($v as $kk=>$vv){
                            $attachs[$kk][$k] = $vv;
                        }
                    }
                    $upload = K::M('magic/upload');
                    foreach($attachs as $k=>$attach){
                        if($attach['error'] == UPLOAD_ERR_OK){
                            if($a = $upload->upload($attach, 'shop')){
                                $data[$k] = $a['photo'];
                            }
                        }
                    }
                }

                if(isset($data['passwd'])){
                    if($data['passwd'] == '******'){
                        unset($data['passwd']);
                    }
                }else{
                    $data['passwd'] = md5($data['passwd']);
                }
                if(K::M('shop/shop')->update($shop_id, $data)){
                    $this->msgbox->add('修改内容成功');
                }  
            }
        }else{
        	$this->pagedata['detail'] = $detail;
        	$this->tmpl = 'admin:shop/shop/edit.html';
        }
    }

    public function audit($shop_id=null)
    {
        if($shop_id = (int)$shop_id){
            if(K::M('shop/shop')->batch($shop_id, array('audit'=>1))){
                $this->msgbox->add('审核内容成功');
            }
        }else if($ids = $this->GP('shop_id')){
            if(K::M('shop/shop')->batch($ids, array('audit'=>1))){
                $this->msgbox->add('批量审核内容成功');
            }
        }else{
            $this->msgbox->add('未指定要审核的内容', 401);
        }
    }
   
    public function manage($shop_id)
    {
        K::M('shop/auth')->manager($shop_id);
        header("Location:".'../biz/index.php');
    }

    public function recycle($page=1)
    {
        $filter = $pager = array();
        $pager['page'] = max(intval($page), 1);
        $pager['limit'] = $limit = 50;
        $filter['closed'] = 1;
        if($items = K::M('shop/shop')->items($filter, null, $page, $limit, $count)){
            $pager['count'] = $count;
            $pager['pagebar'] = $this->mkpage($count, $limit, $page, $this->mklink(null, array('{page}')));;
        }
        $this->pagedata['items'] = $items;
        $this->pagedata['pager'] = $pager;
        $this->tmpl = 'admin:shop/shop/recycle.html';
    }

    public function delete($shop_id=null, $force=false)
    {
        if($shop_id = intval($shop_id)){
            if(K::M('shop/shop')->delete($shop_id, $force)){
                $this->msgbox->add('删除内容成功');
            }
        }else if($ids = $this->GP('shop_id')){
            $force = $this->GP('force') ? $this->GP('force') : $force;
            if(K::M('shop/shop')->delete($ids, $force)){
                $this->msgbox->add('批量删除内容成功');
            }
        }else{
            $this->msgbox->add('未指定要删除的内容ID', 401);
        }
    } 

    public function regain($shop_id=null)
    {
        if($shop_id = intval($shop_id)){
            if(K::M('shop/shop')->regain($shop_id)){
                $this->msgbox->add('恢复商家帐号成功');
            }
        }else if($ids = $this->GP('shop_id')){
            if(K::M('shop/shop')->regain($ids)){
                $this->msgbox->add('批量恢复商家帐号成功');
            }
        }else{
            $this->msgbox->add('未指定要恢复商家', 401);
        }
    }
  

}