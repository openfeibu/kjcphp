<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Ucenter_Mall extends Ctl_Ucenter 
{
   public function index() //兑换记录
   {    
       if($mall = $this->GP('mall')){
            $this->pagedata['mall'] = $mall;
       }
       
        $page = max((int) $this->GP('page'), 1);
        $filter = array();
        $limit = 10;
        $filter['uid'] = $this->uid;
        $orderby = array('order_id'=>'desc');
        if($items = K::M('mall/order')->items($filter, $orderby, $page, $limit)){
            $product_ids = array();
            foreach($items as $key=>$val){
                $product_ids[$val['product_id']] = $val['product_id'];
            }
            $products = K::M('mall/product')->items_by_ids($product_ids);
            foreach($items as $k => $v){
                $items[$k]['photo'] = $products[$v['product_id']]['photo'];
            }
            $this->pagedata['items'] = $items;
        }
       $this->tmpl = 'ucenter/mall/index.html';  
   }                                                                                                                                      

   
}