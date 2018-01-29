<?php
/**
 * Copy Right IJH.CC
 * Each engineer has a duty to keep the code elegant
 * $Id$
 */

if(!defined('__CORE_DIR')){
    exit("Access Denied");
}

class Mdl_Staff_Msg extends Mdl_Table
{   
  
    protected $_table = 'staff_msg';
    protected $_pk = 'msg_id';
    protected $_cols = 'msg_id,staff_id,title,content,is_read,clientip,dateline';
    protected $_orderby = array('msg_id'=>'DESC', 'is_read'=>'ASC');
}