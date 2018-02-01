<?php return array (
  0 => 'CREATE TABLE `xiaozu_ztymode` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` int(2) NOT NULL DEFAULT \'1\' COMMENT \'1样式一，2样式二，3样式三\',
  `cityid` int(11) DEFAULT NULL COMMENT \'城市id\',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8',
  1 => 'INSERT INTO `xiaozu_ztymode`(`id`,`type`,`cityid`) VALUES(\'1\',\'1\',\'410500\')',
  2 => 'INSERT INTO `xiaozu_ztymode`(`id`,`type`,`cityid`) VALUES(\'2\',\'1\',\'410100\')',
  3 => 'INSERT INTO `xiaozu_ztymode`(`id`,`type`,`cityid`) VALUES(\'3\',\'3\',\'411600\')',
  4 => 'INSERT INTO `xiaozu_ztymode`(`id`,`type`,`cityid`) VALUES(\'4\',\'3\',\'110000\')',
  5 => 'INSERT INTO `xiaozu_ztymode`(`id`,`type`,`cityid`) VALUES(\'5\',\'2\',\'451200\')',
)?>