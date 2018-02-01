<?php
 
header("Content-Type:text/html;charset=utf-8"); 
define('hopedir', dirname(__FILE__).DIRECTORY_SEPARATOR);  
$config = hopedir."config/hopeconfig.php";   
$cfg = include($config); 
 
$lnk = mysql_connect($cfg['dbhost'], $cfg['dbuser'], $cfg['dbpw']) or die ('Not connected : ' . mysql_error()); 
$version = mysql_get_server_info(); 
if($version > '4.1' && $cfg['dbcharset']) {
				mysql_query("SET NAMES '".$cfg['dbcharset']."'");
} 
if($version > '5.0') {
				mysql_query("SET sql_mode=''");
}
												
if(!@mysql_select_db($cfg['dbname'])){ 
				if(@mysql_error()) {
					echo '数据库连接失败';exit;
				} else {
					mysql_select_db($cfg['dbname']);
				}
}


mysql_query("
CREATE TABLE IF NOT EXISTS `xiaozu_ztyimginfo` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` int(2) NOT NULL default '1',
  `indeximg` varchar(255) NOT NULL,
  `ztyid` int(11) NOT NULL,
  `cityid` int(11) NOT NULL,
  `is_show` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
 ");


echo mysql_error();
mysql_close($lnk);		 
echo 'ok';
exit;		
?>