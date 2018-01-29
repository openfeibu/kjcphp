<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Order_Log extends Mdl_Table
{   
  
    protected $_table = 'order_log';
    protected $_pk = 'log_id';
    protected $_cols = 'log_id,order_id,from,log,dateline,type';

    public function create($data)
    {
        $data['dateline'] = $data['dateline'] ? $data['dateline'] :  __CFG::TIME;
        if ($log_id = $this->db->insert($this->_table, $data, true)) {
            return $log_id;
        }
    }
    
    public function get_log_types(){
        return array(
            '-1' => L('取消'),
            '0' => L('其他'),
            '1' => L('下单'),
            '2' => L('支付'),
            '3' => L('接单'),
            '4' => L('配送'),
            '5' => L('送达'),
            '6' => L('确认完成'),
        );
    }
}