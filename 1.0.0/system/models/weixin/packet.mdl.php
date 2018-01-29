<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Weixin_Packet extends Mdl_Table
{   
  
    protected $_table = 'weixin_packet';
    protected $_pk = 'id';
    protected $_cols = 'id,wx_id,title,keyword,msg_pic,desc,info,start_time,end_time,ext_total,get_number,value_count,is_open,item_num,item_sum,item_max,item_unit,packet_type,deci,people,password';

    
    public function create($data, $checked=false)
    {
        if(!$checked && !$data = $this->_check_schema($data)){
            return false;
        }
        return $this->db->insert($this->_table, $data, true);
    }

    public function update($pk, $data, $checked=false)
    {
        $this->_checkpk();
        if(!$checked && !$data = $this->_check_schema($data,  $pk)){
            return false;
        }
        return $this->db->update($this->_table, $data, $this->field($this->_pk, $pk));
    }
}