--<?php exit("Access Denied");?>
DROP TABLE IF EXISTS `jh_paotui`;
CREATE TABLE `jh_paotui` (
  `paotui_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) DEFAULT NULL,
  `addr` varchar(255) DEFAULT '',
  `house` varchar(255) DEFAULT '',
  `contact` varchar(15) DEFAULT '',
  `mobile` varchar(11) DEFAULT '',
  `lat` varchar(10) DEFAULT '',
  `lng` varchar(10) DEFAULT '',
  `time` int(10) unsigned DEFAULT '0',
  `o_addr` varchar(255) DEFAULT '',
  `o_house` varchar(255) DEFAULT '',
  `o_contact` varchar(12) DEFAULT '',
  `o_mobile` varchar(11) DEFAULT '',
  `o_lng` varchar(10) DEFAULT '',
  `o_lat` varchar(10) DEFAULT '',
  `o_time` int(10) unsigned DEFAULT '0',
  `intro` varchar(255) DEFAULT '',
  `photo` varchar(255) DEFAULT '',
  `voice` varchar(255) DEFAULT '',
  `voice_time` int(10) unsigned DEFAULT '0',
  `paotui_amount` decimal(10,2) DEFAULT '0.00',
  `danbao_amount` decimal(10,2) DEFAULT '0.00',
  `jiesuan_amount` decimal(10,2) DEFAULT '0.00',
  `type` enum('buy','song','paotui') DEFAULT 'song',
  `staff_id` mediumint(8) DEFAULT '0',
  `order_status` tinyint(1) DEFAULT '0',
  `pay_status` tinyint(1) DEFAULT '0',
  `pay_time` int(10) DEFAULT '0',
  `pay_code` varchar(10) DEFAULT '',
  `pay_ip` varchar(15) DEFAULT '',
  `day` int(8) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`paotui_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `jh_paotui_log`;
CREATE TABLE `jh_paotui_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `paotui_id` int(10) DEFAULT '0',
  `log` varchar(255) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  `from` enum('admin','staff','member') DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

insert  into `jh_system_config`(`k`,`v`,`title`,`dateline`) values ('paotui','a:5:{s:11:\"start_price\";s:1:\"8\";s:8:\"start_km\";s:1:\"5\";s:8:\"start_kg\";s:1:\"1\";s:11:\"addkm_price\";s:1:\"1\";s:11:\"addkg_price\";s:1:\"1\";}','跑腿配置',1453879078);

insert  into `jh_system_module`(`mod_id`,`module`,`level`,`ctl`,`act`,`title`,`visible`,`parent_id`,`orderby`,`dateline`) values (1498,'module',3,'paotui/paotui','index','跑腿订单',1,1514,2,1453348218);
insert  into `jh_system_module`(`mod_id`,`module`,`level`,`ctl`,`act`,`title`,`visible`,`parent_id`,`orderby`,`dateline`) values (1499,'module',3,'paotui/log','index','跑腿日志',0,1514,50,1453348218);
insert  into `jh_system_module`(`mod_id`,`module`,`level`,`ctl`,`act`,`title`,`visible`,`parent_id`,`orderby`,`dateline`) values (1500,'module',3,'paotui/paotui','detail','查看订单',0,1514,50,1453452774);
insert  into `jh_system_module`(`mod_id`,`module`,`level`,`ctl`,`act`,`title`,`visible`,`parent_id`,`orderby`,`dateline`) values (1501,'module',3,'paotui/paotui','delete','删除订单',0,1514,50,1453452816);
insert  into `jh_system_module`(`mod_id`,`module`,`level`,`ctl`,`act`,`title`,`visible`,`parent_id`,`orderby`,`dateline`) values (1502,'module',3,'paotui/paotui','export','导出订单',0,1514,50,1453457100);
insert  into `jh_system_module`(`mod_id`,`module`,`level`,`ctl`,`act`,`title`,`visible`,`parent_id`,`orderby`,`dateline`) values (1503,'module',3,'paotui/paotui','cancel','取消订单',0,1514,50,1453515032);
insert  into `jh_system_module`(`mod_id`,`module`,`level`,`ctl`,`act`,`title`,`visible`,`parent_id`,`orderby`,`dateline`) values (1504,'module',3,'system/config','paotui','跑腿配置',1,1514,1,1453878786);
insert  into `jh_system_module`(`mod_id`,`module`,`level`,`ctl`,`act`,`title`,`visible`,`parent_id`,`orderby`,`dateline`) values (1513,'module',3,'paotui/paotui','paidan','派单管理',1,1514,3,1458287637);
insert  into `jh_system_module`(`mod_id`,`module`,`level`,`ctl`,`act`,`title`,`visible`,`parent_id`,`orderby`,`dateline`) values (1514,'menu',2,'','','跑腿管理',1,71,50,1458287656);
insert  into `jh_system_module`(`mod_id`,`module`,`level`,`ctl`,`act`,`title`,`visible`,`parent_id`,`orderby`,`dateline`) values (1515,'module',3,'paotui/paotui','dopaidan','配送派单',0,1514,50,1458555270);