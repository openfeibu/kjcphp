<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id: index.ctl.php 14351 2015-07-22 01:25:14Z wanglei $
 */
if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Ctl_Position extends Ctl
{
    
    public function index()
    {   
        if($this->uid){
            $addr_list = K::M('member/addr')->items(array('uid'=>$this->uid));
            $this->pagedata['addr_list']= $addr_list;
        }
        $this->tmpl = 'position.html';
    }
    
  
}