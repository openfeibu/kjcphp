-- phpMyAdmin SQL Dump
-- version 3.4.8
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 11 月 27 日 08:38
-- 服务器版本: 5.5.40
-- PHP 版本: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `jiaxiao`
--

-- --------------------------------------------------------

--
-- 表的结构 `jh_admin`
--

CREATE TABLE IF NOT EXISTS `jh_admin` (
  `admin_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(15) DEFAULT '',
  `passwd` char(32) DEFAULT '',
  `role_id` smallint(6) DEFAULT '0',
  `last_login` int(10) DEFAULT '0',
  `last_ip` varchar(15) DEFAULT '0.0.0.0',
  `closed` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `jh_admin`
--

INSERT INTO `jh_admin` (`admin_id`, `admin_name`, `passwd`, `role_id`, `last_login`, `last_ip`, `closed`, `dateline`) VALUES
(1, 'admin', '93e538e654e94139fb0931fae8135fc1', 1, 1511743059, '127.0.0.1', 0, 1470907452),
(2, 'admin-changzhou', '55eafb8dcd095b0e022709d7f2a684cc', 1, 1473179818, '202.112.25.15', 0, 1473179302);

-- --------------------------------------------------------

--
-- 表的结构 `jh_admin_role`
--

CREATE TABLE IF NOT EXISTS `jh_admin_role` (
  `role_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) DEFAULT '',
  `role` enum('editor','admin','system','fenzhan') DEFAULT NULL,
  `priv` mediumtext,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `jh_admin_role`
--

INSERT INTO `jh_admin_role` (`role_id`, `role_name`, `role`, `priv`) VALUES
(1, '系统管理员', 'system', '');

-- --------------------------------------------------------

--
-- 表的结构 `jh_adv`
--

CREATE TABLE IF NOT EXISTS `jh_adv` (
  `adv_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `theme` varchar(20) DEFAULT 'default',
  `theme_id` smallint(6) DEFAULT '0',
  `page` varchar(50) DEFAULT '',
  `title` varchar(50) DEFAULT '',
  `from` enum('text','photo','product','script','lunzhuan') DEFAULT 'photo',
  `limit` smallint(6) DEFAULT '10',
  `config` mediumtext,
  `desc` varchar(255) DEFAULT '',
  `tmpl` mediumtext,
  `orderby` smallint(6) unsigned DEFAULT '0',
  `audit` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) unsigned DEFAULT '0',
  `dateline` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`adv_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `jh_adv`
--

INSERT INTO `jh_adv` (`adv_id`, `theme`, `theme_id`, `page`, `title`, `from`, `limit`, `config`, `desc`, `tmpl`, `orderby`, `audit`, `closed`, `dateline`) VALUES
(1, 'default', 1, '', '首页轮播', 'lunzhuan', 5, 'a:2:{s:5:"width";s:4:"100%";s:6:"height";s:4:"100%";}', '', '[loop]\r\n<li><a href="<{$item.clickurl}>" <{$item.a_attr}>><img src="<{$pager.img}>/<{$item.thumb}>" width="640" height="198" alt="<{$item.title}>" text="<{$item.title}>" <{$item.item_attr}> /></a></li>\r\n[/loop]', 1, 1, 0, 1445221597),
(2, 'default', 1, '', '商城轮播', 'lunzhuan', 10, 'a:2:{s:5:"width";s:0:"";s:6:"height";s:0:"";}', '', '[loop]\r\n<li><a href="<{$item.clickurl}>" <{$item.a_attr}>><img style="width:100%;height:117px;" src="<{$pager.img}>/<{$item.thumb}>" width="640" height="198" alt="<{$item.title}>" text="<{$item.title}>" <{$item.item_attr}> /></a></li>\r\n[/loop]', 50, 1, 0, 1449217174);

-- --------------------------------------------------------

--
-- 表的结构 `jh_adv_item`
--

CREATE TABLE IF NOT EXISTS `jh_adv_item` (
  `item_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `adv_id` smallint(6) unsigned DEFAULT '0',
  `city_id` smallint(6) DEFAULT '0',
  `title` varchar(100) DEFAULT '',
  `link` varchar(150) DEFAULT '',
  `thumb` varchar(150) DEFAULT '',
  `script` mediumtext,
  `clicks` mediumint(8) unsigned DEFAULT '0',
  `stime` int(10) NOT NULL DEFAULT '0',
  `ltime` int(10) NOT NULL DEFAULT '0',
  `audit` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) unsigned DEFAULT '0',
  `dateline` int(10) unsigned DEFAULT '0',
  `desc` varchar(255) DEFAULT '',
  `target` enum('_self','_blank','_parent','_top') DEFAULT '_blank',
  `orderby` smallint(6) unsigned DEFAULT '50',
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- 转存表中的数据 `jh_adv_item`
--

INSERT INTO `jh_adv_item` (`item_id`, `adv_id`, `city_id`, `title`, `link`, `thumb`, `script`, `clicks`, `stime`, `ltime`, `audit`, `closed`, `dateline`, `desc`, `target`, `orderby`) VALUES
(1, 1, 1, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(2, 1, 2, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(3, 1, 3, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(4, 1, 4, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(5, 1, 5, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(6, 1, 6, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(7, 1, 7, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(8, 1, 8, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(9, 1, 9, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(10, 1, 10, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(11, 1, 11, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(12, 1, 12, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(13, 1, 13, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(14, 1, 14, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(15, 1, 15, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(16, 1, 16, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(17, 1, 17, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(18, 1, 18, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(19, 1, 19, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(20, 1, 20, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(21, 1, 21, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(22, 1, 22, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(23, 1, 23, '广告添加', 'http://www.48ym.com', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', NULL, 0, 0, 0, 1, 0, 1481426749, '', '_blank', 50),
(24, 2, 1, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(25, 2, 2, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(26, 2, 3, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(27, 2, 4, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(28, 2, 5, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(29, 2, 6, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(30, 2, 7, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(31, 2, 8, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(32, 2, 9, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(33, 2, 10, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(34, 2, 11, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(35, 2, 12, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(36, 2, 13, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(37, 2, 14, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(38, 2, 15, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(39, 2, 16, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(40, 2, 17, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(41, 2, 18, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(42, 2, 19, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(43, 2, 20, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(44, 2, 21, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(45, 2, 22, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50),
(46, 2, 23, 'qqqq', 'http://www.48ym.com', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', NULL, 0, 0, 0, 1, 0, 1481440124, '', '_blank', 50);

-- --------------------------------------------------------

--
-- 表的结构 `jh_article`
--

CREATE TABLE IF NOT EXISTS `jh_article` (
  `article_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` smallint(6) DEFAULT '0',
  `cat_id` mediumint(8) unsigned DEFAULT '0',
  `from` enum('article','about','help','page') DEFAULT 'article',
  `page` varchar(15) DEFAULT '',
  `title` varchar(200) DEFAULT '',
  `thumb` varchar(150) DEFAULT '',
  `desc` varchar(255) DEFAULT '',
  `views` mediumint(8) DEFAULT '0',
  `favorites` mediumint(8) DEFAULT '0',
  `allow_comment` tinyint(1) DEFAULT '1',
  `comments` mediumint(8) DEFAULT '0',
  `photos` smallint(6) DEFAULT '0',
  `linkurl` varchar(255) DEFAULT '',
  `ontime` int(10) DEFAULT '0',
  `hidden` tinyint(1) DEFAULT '0',
  `orderby` smallint(6) unsigned DEFAULT '50',
  `audit` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) unsigned DEFAULT '0',
  `dateline` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`article_id`),
  KEY `cat_id` (`cat_id`,`from`,`audit`,`closed`,`hidden`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `jh_article`
--

INSERT INTO `jh_article` (`article_id`, `city_id`, `cat_id`, `from`, `page`, `title`, `thumb`, `desc`, `views`, `favorites`, `allow_comment`, `comments`, `photos`, `linkurl`, `ontime`, `hidden`, `orderby`, `audit`, `closed`, `dateline`) VALUES
(1, 1, 1, 'help', '', '支付问题', '', '我们下单支付方式有微信支付、支付宝支付等多种支付方 式，充值支付方式有微信支付、支付宝支付。', 0, 0, 1, 0, 0, '', 0, 0, 50, 0, 0, 0),
(2, 1, 1, 'help', 'page/invite', '活动说明', '', '活动说明--分享活动的活动说明。字数不要太多，别人也懒的看', 1, 0, 1, 0, 0, '', 0, 0, 50, 1, 0, 1451036021),
(3, 1, 1, 'help', 'helptest', '测试文章esc', '', '测试文章esc测试文章esc', 1, 0, 1, 0, 0, '', 0, 0, 50, 1, 0, 1452753252),
(4, 1, 1, 'help', 'helptest', 'helptest', '', 'helptesthelptesthelptesthelptesthelptesthelptesthelptesthelptesthelptesthelptesthelptesthelptesthelptesthelptest', 1, 0, 1, 0, 0, '', 0, 0, 50, 1, 0, 1452753272),
(5, 1, 1, 'help', 'orderorder', 'orderorderorder', '', 'orderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorderorder', 1, 0, 1, 0, 0, '', 0, 0, 50, 1, 0, 1452753740),
(6, 0, 1, 'help', '1', '关于我们', '', '酷乐送外卖订餐系统是一个专业的O2O本地跑腿订餐系统。copyright@2015-2016雷锋站长络科技有限公司', 0, 0, 1, 0, 0, '', 0, 0, 50, 1, 1, 1475209661),
(7, 0, 2, 'about', '1', '关于我们', '', 'copyright@2015-2016雷锋站长络科技有限公司', 0, 0, 1, 0, 0, '', 0, 0, 50, 1, 0, 1475211346),
(8, 0, 1, 'help', '1', '关于我们', '', 'copyright@2015-2016雷锋站长络科技有限公司', 0, 0, 1, 0, 0, '', 0, 0, 50, 1, 0, 1475211488),
(9, 0, 0, 'article', '', '测试', 'photo/201609/20160930_EF82EDDAA0EBA8D22D83DD9CD6F91BC3.jpg', 'cces', 0, 0, 1, 0, 0, '', 0, 0, 50, 1, 0, 1475215092),
(10, 0, 0, 'article', '', '技术支持', '', '酷乐送app技术支持。', 0, 0, 1, 0, 0, '', 0, 0, 50, 1, 0, 1476267784),
(11, 0, 2, 'about', 'support', '技术支持', '', '技术支持', 0, 0, 1, 0, 0, '', 0, 0, 50, 1, 0, 1476426725);

-- --------------------------------------------------------

--
-- 表的结构 `jh_article_cate`
--

CREATE TABLE IF NOT EXISTS `jh_article_cate` (
  `cat_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` mediumint(8) unsigned DEFAULT '0',
  `title` varchar(150) DEFAULT '',
  `level` tinyint(1) unsigned DEFAULT '1',
  `from` enum('about','help','page','article') DEFAULT 'article',
  `seo_title` varchar(255) DEFAULT '',
  `seo_keywords` varchar(255) DEFAULT '',
  `seo_description` varchar(255) DEFAULT '',
  `orderby` smallint(6) unsigned DEFAULT '50',
  `hidden` tinyint(1) DEFAULT '0',
  `dateline` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `jh_article_cate`
--

INSERT INTO `jh_article_cate` (`cat_id`, `parent_id`, `title`, `level`, `from`, `seo_title`, `seo_keywords`, `seo_description`, `orderby`, `hidden`, `dateline`) VALUES
(1, 0, '帮助中心', 1, 'help', '', '', '', 1, 0, 1450161753),
(2, 0, '关于我们', 1, 'about', '', '', '', 1, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `jh_article_content`
--

CREATE TABLE IF NOT EXISTS `jh_article_content` (
  `content_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(10) NOT NULL,
  `seo_title` varchar(150) DEFAULT '',
  `seo_keywords` varchar(255) DEFAULT '',
  `seo_description` varchar(255) DEFAULT '',
  `content` mediumtext,
  `clientip` varchar(15) DEFAULT '0.0.0.0',
  PRIMARY KEY (`content_id`),
  KEY `article_id` (`article_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `jh_article_content`
--

INSERT INTO `jh_article_content` (`content_id`, `article_id`, `seo_title`, `seo_keywords`, `seo_description`, `content`, `clientip`) VALUES
(1, 2, '', '', '', '活动说明--分享活动的活动说明。字数不要太多，别人也懒的看', '127.0.0.1'),
(2, 3, '', '', '', '测试文章esc测试文章esc', '127.0.0.1'),
(3, 4, '', '', '', 'helptesthelptest', '127.0.0.1'),
(4, 5, '', '', '', 'orderorderorder', '127.0.0.1'),
(5, 6, '', '', '', '<table style="width:381px;" cellspacing="0" cellpadding="2" bordercolor="#666666" border="1" align="left" height="91">\r\n	<tbody>\r\n		<tr>\r\n			<td>\r\n				酷乐送外卖订餐系统是一个专业的O2O本地跑腿订餐系统。<br />\r\n			</td>\r\n		</tr>\r\n	</tbody>\r\n</table>\r\n<br />\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p align="center">\r\n	<span style="color:#999999;"><br />\r\n</span>\r\n</p>\r\n<p align="center">\r\n	<span style="color:#999999;"><br />\r\n</span>\r\n</p>\r\n<p align="center">\r\n	<span style="color:#999999;"><br />\r\n</span>\r\n</p>\r\n<p align="center">\r\n	<span style="color:#999999;">copyright@2015-2016</span> \r\n</p>\r\n<p align="center">\r\n	<span style="color:#999999;">雷锋站长络科技有限公司</span> \r\n</p>', '202.112.25.30'),
(6, 7, '', '', '', '<p align="center">\r\n	<span style="color:#666666;font-size:14px;font-family:Microsoft YaHei;">copyright@2015-2016</span><br />\r\n<span style="color:#666666;font-size:14px;font-family:Microsoft YaHei;">雷锋站长络科技有限公司</span> \r\n</p>', '202.112.25.30'),
(7, 8, '', '', '', '<p align="center">\r\n	<span style="font-family:Microsoft YaHei;font-size:14px;color:#666666;">copyright@2015-2016</span><br />\r\n<span style="font-family:Microsoft YaHei;font-size:14px;color:#666666;">雷锋站长络科技有限公司的</span> \r\n</p>', '202.112.25.30'),
(8, 9, '', '', '', '测试出', '124.73.165.165'),
(9, 10, '', '', '', '酷乐送app技术支持。<br />', '202.112.25.13'),
(10, 11, '', '', '', '酷乐送app技术支持。', '202.112.25.25');

-- --------------------------------------------------------

--
-- 表的结构 `jh_article_photo`
--

CREATE TABLE IF NOT EXISTS `jh_article_photo` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(10) DEFAULT '0',
  `title` varchar(100) DEFAULT NULL,
  `photo` varchar(150) DEFAULT '',
  `size` mediumint(8) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_block`
--

CREATE TABLE IF NOT EXISTS `jh_block` (
  `block_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `theme` varchar(30) DEFAULT NULL,
  `page_id` smallint(6) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `from` varchar(50) DEFAULT '',
  `type` enum('default','hot','new','only','zhanwei') DEFAULT 'default',
  `config` mediumtext,
  `tmpl` mediumtext,
  `limit` tinyint(3) DEFAULT '10',
  `ttl` mediumint(8) DEFAULT '900',
  `orderby` smallint(50) DEFAULT NULL,
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`block_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_block_item`
--

CREATE TABLE IF NOT EXISTS `jh_block_item` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `block_id` mediumint(8) unsigned DEFAULT '0',
  `itemId` int(10) DEFAULT '0',
  `title` varchar(50) DEFAULT '',
  `link` varchar(150) DEFAULT '',
  `thumb` varchar(150) DEFAULT '',
  `city_id` smallint(6) DEFAULT '0',
  `data` mediumtext,
  `expire_time` int(10) DEFAULT '0',
  `orderby` smallint(6) DEFAULT '50',
  `dateline` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `block_id` (`block_id`,`itemId`,`city_id`),
  KEY `orderby` (`orderby`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_block_page`
--

CREATE TABLE IF NOT EXISTS `jh_block_page` (
  `page_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) DEFAULT '',
  `orderby` smallint(6) DEFAULT '50',
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_data_city`
--

CREATE TABLE IF NOT EXISTS `jh_data_city` (
  `city_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `province_id` smallint(6) DEFAULT '0',
  `city_name` varchar(50) DEFAULT '',
  `pinyin` varchar(50) DEFAULT '',
  `theme_id` smallint(6) DEFAULT '0',
  `logo` varchar(150) DEFAULT '',
  `phone` varchar(30) DEFAULT '',
  `city_code` char(4) DEFAULT '',
  `mobile` varchar(15) DEFAULT '',
  `mail` varchar(30) DEFAULT '',
  `kfqq` varchar(30) DEFAULT '',
  `orderby` smallint(6) DEFAULT '50',
  `audit` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`city_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- 转存表中的数据 `jh_data_city`
--

INSERT INTO `jh_data_city` (`city_id`, `province_id`, `city_name`, `pinyin`, `theme_id`, `logo`, `phone`, `city_code`, `mobile`, `mail`, `kfqq`, `orderby`, `audit`, `dateline`) VALUES
(1, 1, '合肥', 'H', 1, '', '400-009-8862', '', '13812365478', 'ijianghu@qq.com', '123456', 50, 1, 1448415138),
(2, 1, '蚌埠', 'B', 1, '', '', '', '', '', '', 50, 1, 1450496309),
(3, 1, '宿州', 'S', 1, '', '', '', '', '', '', 50, 1, 1450496322),
(4, 1, '宣城', 'X', 1, '', '', '', '', '', '', 50, 1, 1450496330),
(5, 1, '芜湖', 'W', 1, '', '', '', '', '', '', 50, 1, 1450496337),
(6, 1, '淮南', 'H', 1, '', '', '', '', '', '', 50, 1, 1450496469),
(7, 1, '淮北', 'H', 1, '', '', '', '', '', '', 50, 1, 1450496545),
(8, 1, '安庆', 'A', 1, '', '', '', '', '', '', 50, 1, 1450496569),
(9, 1, '马鞍山', 'M', 1, '', '', '', '', '', '', 50, 1, 1450496613),
(10, 1, '铜陵', 'T', 1, '', '', '', '', '', '', 50, 1, 1450496625),
(11, 1, '黄山', 'H', 1, '', '', '', '', '', '', 50, 1, 1450496625),
(12, 1, '桐城', 'T', 1, '', '', '', '', '', '', 50, 1, 1450496725),
(13, 1, '滁州', 'C', 1, '', '', '', '', '', '', 50, 1, 1450496727),
(14, 1, '天长', 'T', 1, '', '', '', '', '', '', 50, 1, 1450496888),
(15, 1, '阜阳', 'F', 1, '', '', '', '', '', '', 50, 1, 1450496787),
(16, 1, '界首', 'J', 1, '', '', '', '', '', '', 50, 1, 1450496802),
(17, 1, '巢湖', 'C', 1, '', '', '', '', '', '', 50, 1, 1450496811),
(18, 1, '六安', 'L', 1, '', '', '', '', '', '', 50, 1, 1450496859),
(19, 1, '亳州', 'B', 1, '', '', '', '', '', '', 50, 1, 1450496870),
(20, 1, '池州', 'C', 1, '', '', '', '', '', '', 50, 1, 1450496899),
(21, 1, '宁国', 'N', 1, '', '', '', '', '', '', 50, 1, 1450496930),
(22, 3, '常州', 'changzhou', 1, '', '', '', '', '', '', 50, 1, 1472894368),
(23, 3, '无锡', 'wuxi', 1, '', '', '', '', '', '', 50, 1, 1472897876);

-- --------------------------------------------------------

--
-- 表的结构 `jh_data_province`
--

CREATE TABLE IF NOT EXISTS `jh_data_province` (
  `province_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `province_name` varchar(30) DEFAULT '',
  `orderby` smallint(6) DEFAULT '50',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`province_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `jh_data_province`
--

INSERT INTO `jh_data_province` (`province_id`, `province_name`, `orderby`, `dateline`) VALUES
(1, '安徽', 50, 1448354155),
(2, '湖南', 50, 1454320232),
(3, '江苏', 8, 1472894281),
(4, '山东', 50, 1481439202);

-- --------------------------------------------------------

--
-- 表的结构 `jh_ditui`
--

CREATE TABLE IF NOT EXISTS `jh_ditui` (
  `ditui_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` smallint(6) DEFAULT '0',
  `mobile` varchar(11) DEFAULT '0',
  `passwd` char(32) DEFAULT '',
  `money` decimal(10,2) DEFAULT '0.00',
  `pmid` char(9) DEFAULT '',
  `reg_count` mediumint(8) DEFAULT '0',
  `order_count` mediumint(8) DEFAULT '0',
  `name` varchar(30) DEFAULT '',
  `id_number` varchar(18) DEFAULT '',
  `id_photo` varchar(150) DEFAULT '',
  `account_type` varchar(30) DEFAULT '',
  `account_name` varchar(30) DEFAULT '',
  `account_number` varchar(30) DEFAULT '',
  `audit` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  `total_money` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`ditui_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_ditui_log`
--

CREATE TABLE IF NOT EXISTS `jh_ditui_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ditui_id` mediumint(8) DEFAULT '0',
  `money` decimal(8,2) DEFAULT '0.00',
  `intro` varchar(255) DEFAULT '',
  `admin` varchar(30) DEFAULT '',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_ditui_member`
--

CREATE TABLE IF NOT EXISTS `jh_ditui_member` (
  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ditui_id` mediumint(8) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `signup_amount` decimal(6,2) DEFAULT '0.00',
  `first_amount` decimal(6,2) DEFAULT '0.00',
  `first_order_id` int(10) DEFAULT '0',
  `first_order_amount` decimal(8,2) DEFAULT '0.00',
  `first_order_time` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_ditui_shop`
--

CREATE TABLE IF NOT EXISTS `jh_ditui_shop` (
  `sid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ditui_id` mediumint(8) DEFAULT '0',
  `shop_id` mediumint(8) DEFAULT '0',
  `signup_amount` decimal(6,2) DEFAULT '0.00',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_hongbao`
--

CREATE TABLE IF NOT EXISTS `jh_hongbao` (
  `hongbao_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `min_amount` int(10) NOT NULL,
  `amount` int(10) NOT NULL,
  `type` tinyint(1) DEFAULT '0',
  `uid` int(10) DEFAULT '0',
  `hongbao_sn` char(8) NOT NULL DEFAULT '',
  `stime` int(10) DEFAULT '0',
  `ltime` int(10) DEFAULT '0',
  `order_id` int(10) DEFAULT '0',
  `used_ip` varchar(15) DEFAULT '',
  `used_time` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(11) DEFAULT '0',
  PRIMARY KEY (`hongbao_id`),
  KEY `uid` (`uid`,`order_id`),
  KEY `stime` (`stime`,`ltime`),
  KEY `hongbao_sn` (`hongbao_sn`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_hongbao_log`
--

CREATE TABLE IF NOT EXISTS `jh_hongbao_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hongbao_id` int(10) unsigned NOT NULL,
  `order_id` int(10) unsigned NOT NULL,
  `uid` int(10) unsigned NOT NULL,
  `money` decimal(10,2) unsigned NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_mall_cate`
--

CREATE TABLE IF NOT EXISTS `jh_mall_cate` (
  `cate_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(30) DEFAULT '',
  `icon` varchar(150) DEFAULT '',
  `orderby` smallint(6) DEFAULT '50',
  PRIMARY KEY (`cate_id`),
  KEY `orderby` (`orderby`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `jh_mall_cate`
--

INSERT INTO `jh_mall_cate` (`cate_id`, `title`, `icon`, `orderby`) VALUES
(1, '个护美妆', 'photo/201512/20151204_7ADFF6775E81D8454FDA634238D70D32.png', 50),
(2, '食品饮料', 'photo/201512/20151204_1DAB661DF0D9B087859277D087E5441F.png', 50),
(3, '数码家电', 'photo/201512/20151204_88642A8EECC94B0B4F779A4E719AE3D2.png', 50),
(4, '日常家居', 'photo/201512/20151204_1BF144874731ED9E3832BA7552DCDE57.png', 50),
(5, '服饰鞋帽', 'photo/201512/20151204_EEAD67A695DE9507E5159E6FC46EBC03.png', 50),
(6, '健康运动', 'photo/201512/20151204_9EB01DA674B0945403C8818D3988EB20.png', 50),
(7, '新品推荐', 'photo/201512/20151209_6396A1A376E441A59708F78C7E1CCFBA.png', 50);

-- --------------------------------------------------------

--
-- 表的结构 `jh_mall_order`
--

CREATE TABLE IF NOT EXISTS `jh_mall_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) DEFAULT '0',
  `product_id` mediumint(8) DEFAULT '0',
  `product_name` varchar(80) DEFAULT '',
  `product_jifen` mediumint(8) DEFAULT '0',
  `product_number` smallint(6) DEFAULT '0',
  `contact` varchar(30) DEFAULT '',
  `mobile` char(11) DEFAULT '',
  `addr` varchar(150) DEFAULT '',
  `status` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_mall_product`
--

CREATE TABLE IF NOT EXISTS `jh_mall_product` (
  `product_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cate_id` smallint(6) DEFAULT '0',
  `title` varchar(80) DEFAULT '',
  `photo` varchar(150) DEFAULT '',
  `jifen` mediumint(8) DEFAULT '0',
  `info` mediumtext,
  `views` mediumint(8) DEFAULT '0',
  `sales` mediumint(8) DEFAULT '0',
  `sku` int(10) DEFAULT '0',
  `orderby` smallint(6) DEFAULT '50',
  `closed` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`product_id`),
  KEY `cate_id` (`cate_id`,`orderby`,`closed`),
  KEY `jifen` (`jifen`,`views`,`sales`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_member`
--

CREATE TABLE IF NOT EXISTS `jh_member` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(15) NOT NULL,
  `passwd` char(32) DEFAULT '',
  `paypasswd` char(32) DEFAULT '',
  `nickname` varchar(30) DEFAULT '',
  `money` decimal(10,2) DEFAULT '0.00',
  `total_money` decimal(10,2) DEFAULT '0.00',
  `orders` mediumint(8) DEFAULT '0',
  `jifen` int(10) DEFAULT '0',
  `face` varchar(150) DEFAULT '',
  `wx_openid` varchar(50) DEFAULT '',
  `wx_unionid` varchar(50) DEFAULT '',
  `loginip` varchar(15) DEFAULT '',
  `lastlogin` int(10) DEFAULT '0',
  `pmid` char(9) DEFAULT '',
  `closed` tinyint(1) DEFAULT '0',
  `regip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `jh_member`
--

INSERT INTO `jh_member` (`uid`, `mobile`, `passwd`, `paypasswd`, `nickname`, `money`, `total_money`, `orders`, `jifen`, `face`, `wx_openid`, `wx_unionid`, `loginip`, `lastlogin`, `pmid`, `closed`, `regip`, `dateline`) VALUES
(1, '13771331940', '55eafb8dcd095b0e022709d7f2a684cc', '55eafb8dcd095b0e022709d7f2a684cc', '吴志新', '19.02', '19.10', 100, 1, '', 'oMdJowzqcugEByHDWhJRxqagBvO0', '', '202.112.25.27', 1474456433, '', 0, '202.112.25.27', 1474456433),
(2, '13888888888', 'e10adc3949ba59abbe56e057f20f883e', '', '', '72.00', '100.00', 0, 0, '', '', '', '', 0, '', 0, '60.168.18.229', 1475224630),
(3, '15961414153', 'db670a1ffc40ae0a0022b2ffce64d936', 'db670a1ffc40ae0a0022b2ffce64d936', '61414153***4153', '0.00', '0.00', 0, 0, '', '', '', '180.116.239.40', 1476107797, '', 0, '180.116.239.40', 1476107797),
(4, '13921330310', '0c3096f1fd18304c2fc8df4c6710e285', '0c3096f1fd18304c2fc8df4c6710e285', '', '0.01', '0.02', 3, 0, '', '', '', '61.160.122.22', 1476173115, '', 0, '61.160.122.22', 1476173115),
(5, '13961508312', 'b1de8068f6893ab7a491b7c3f8f145e6', 'b1de8068f6893ab7a491b7c3f8f145e6', '', '0.00', '0.00', 0, 0, '', '', '', '183.207.217.62', 1476266125, '', 0, '183.207.217.62', 1476266125),
(6, '13506144317', 'c8320f379b8a0ac8fc6b9c7cb2134503', 'c8320f379b8a0ac8fc6b9c7cb2134503', '', '0.01', '0.02', 1, 0, '', '', '', '114.226.182.11', 1476429382, '', 0, '114.226.182.11', 1476429382),
(7, '15106120872', '2f57518fd05e42f7e68eefa9727a4ce7', '2f57518fd05e42f7e68eefa9727a4ce7', '陈芸', '0.00', '0.00', 0, 0, 'photo/201610/20161018_09BF9465CA39C1F2177ECC6D7632B958.jpg', 'oMdJow1uVUU6d6lbQzwiQ93BMD8k', 'osOHHv5mi56IAPrNwQ0sBio2zGSc', '60.55.8.93', 1476784787, '', 0, '60.55.8.93', 1476784787),
(8, '18655488651', 'e10adc3949ba59abbe56e057f20f883e', 'e10adc3949ba59abbe56e057f20f883e', '请联系我', '0.00', '0.00', 1, 0, '', '', '', '112.26.227.116', 1479667956, '', 0, '112.26.227.116', 1479667956),
(9, '15719685959', '74a1b22c7f39dc3d918c703e18bd7103', '74a1b22c7f39dc3d918c703e18bd7103', '19685959***5959', '100.00', '100.00', 0, 0, '', '', '', '211.161.244.137', 1480514319, '', 0, '211.161.244.137', 1480514319),
(10, '13856085909', 'e10adc3949ba59abbe56e057f20f883e', '', 'ceshi', '0.00', '0.00', 4, 0, '', '', '', '', 0, '', 0, '117.68.226.251', 1481016456),
(11, '15646464646', 'e10adc3949ba59abbe56e057f20f883e', 'e10adc3949ba59abbe56e057f20f883e', '普通会员', '0.00', '0.00', 0, 0, 'default/face.png', '', '', '221.178.181.17', 1481111204, '', 0, '221.178.181.17', 1481111204);

-- --------------------------------------------------------

--
-- 表的结构 `jh_member_addr`
--

CREATE TABLE IF NOT EXISTS `jh_member_addr` (
  `addr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) DEFAULT '0',
  `contact` varchar(30) DEFAULT '',
  `mobile` varchar(15) DEFAULT '',
  `addr` varchar(255) DEFAULT '',
  `house` varchar(150) DEFAULT '',
  `is_default` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  `lat` varchar(15) DEFAULT '',
  `lng` varchar(15) DEFAULT '',
  PRIMARY KEY (`addr_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `jh_member_addr`
--

INSERT INTO `jh_member_addr` (`addr_id`, `uid`, `contact`, `mobile`, `addr`, `house`, `is_default`, `dateline`, `lat`, `lng`) VALUES
(1, 1, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', 0, 1476788800, '31.798511', '119.912439'),
(2, 1, '吴志新', '13771331949', '全佳福北京涮羊肉(尚东店)', '尚东区花园54号', 0, 1476789096, '31.785594', '119.984394'),
(3, 1, '吴志新', '13771331940', '新城尚东区花园西区', 'ff', 0, 1476790080, '31.785365', '119.984917'),
(5, 4, '周文兴', '13921330310', '江苏省常州市钟楼区', '南大街/双桂坊(路口)', 0, 1476262708, '31.782186', '119.960722'),
(6, 1, '吴志新', '13771331940', '新城尚东区花园西区', '1417', 0, 1479122890, '31.785365', '119.984917'),
(7, 6, '赵俐娜', '13506144317', '勤业路262号附近', '钟楼区莱茵花苑23号商铺感岛眼镜店', 0, 1476429548, '31.793802', '119.93196'),
(8, 1, '五gffhh', '13771331940', '合肥汽车站', '明光路168号', 0, 1476692501, '31.867273', '117.306709'),
(9, 2, '测试', '13888888888', '无锡汽车客运站', '锡沪西路227号', 1, 1476929890, '31.592854', '120.308447'),
(10, 2, '测试2', '13888888888', '五彩国际', '望江西路与合作化南路交叉口华润五彩城(合作化路口)', 0, 1476929525, '31.829986', '117.249223'),
(11, 1, '吴志新', '13771331940', '江苏凌家塘物流有限公司(江凌路)', '邹区镇新312国道', 1, 1476943676, '31.779899', '119.863694'),
(12, 0, '吴志新', '13771331940', '北环路东侧、竹林北路北侧', '新城尚东区花园', 1, 1478192213, '31.791846', '119.993467'),
(13, 8, '陈先生', '18655488651', '淮南市田家庵区洞山中路16号', '淮南市卫生监督局', 0, 1479668204, '32.64281', '117.018639'),
(14, 8, '请联系我下', '18655488651', '淮南市田家庵区洞山中路16号', '淮南市卫生监督局', 0, 1479668296, '32.64281', '117.018639'),
(15, 8, '18655488651', '18655488651', '钟楼区', '钟楼区', 0, 1479669858, '31.807796', '119.90789'),
(16, 8, '18655488651', '18655488651', '江苏省常州市天宁区', '宁东路', 0, 1479669921, '31.792767', '119.992242'),
(17, 8, '请联系我', '18655488651', '江苏省常州市天宁区', '宁东路与腾飞路交叉口', 0, 1479687760, '31.7924', '119.99132'),
(18, 10, '测试', '13856565656', '合肥市蜀山区', '五彩国际', 0, 1481017008, '31.836407', '117.255809'),
(19, 10, '测试', '13856565656', '合肥市蜀山区', '五彩国际', 0, 1481017046, '31.836407', '117.255809'),
(20, 10, '测试', '13856565656', '合肥市蜀山区', '五彩国际', 0, 1481017064, '31.836407', '117.255809');

-- --------------------------------------------------------

--
-- 表的结构 `jh_member_help`
--

CREATE TABLE IF NOT EXISTS `jh_member_help` (
  `help_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT '',
  `details` text,
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`help_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_member_invite`
--

CREATE TABLE IF NOT EXISTS `jh_member_invite` (
  `invite_uid` mediumint(8) NOT NULL DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `mobile` char(11) DEFAULT '',
  `money` decimal(6,2) DEFAULT '0.00',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`invite_uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `jh_member_log`
--

CREATE TABLE IF NOT EXISTS `jh_member_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) DEFAULT '0',
  `type` enum('money','jifen') DEFAULT NULL,
  `number` float DEFAULT '0',
  `intro` varchar(255) DEFAULT '',
  `admin` varchar(80) DEFAULT '',
  `day` int(8) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `uid` (`uid`,`type`),
  KEY `day` (`day`,`dateline`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `jh_member_log`
--

INSERT INTO `jh_member_log` (`log_id`, `uid`, `type`, `number`, `intro`, `admin`, `day`, `clientip`, `dateline`) VALUES
(1, 1, 'money', 0.01, '订单(ID:10)取消退回到余额', '', 0, '202.112.25.16', 1476165387),
(2, 1, 'money', -0.01, '支付订单(ID:17)', '', 0, '202.112.25.16', 1476174581),
(3, 1, 'money', 0.01, '订单(ID:18)取消退回到余额', '', 0, '202.112.25.17', 1476197026),
(4, 1, 'money', 0.01, '订单(ID:19)取消退回到余额', '', 0, '202.112.25.17', 1476197027),
(5, 1, 'money', 0.01, '订单(ID:20)取消退回到余额', '', 0, '202.112.25.17', 1476197033),
(6, 1, 'jifen', 1, '订单22评价完成，获得积分', '', 0, '202.112.25.17', 1476232719),
(7, 1, 'money', -0.01, '订单抵扣金额', '', 0, '202.112.25.13', 1476264179),
(8, 1, 'money', 0.01, '订单(ID:29)取消退回到余额', '', 0, '202.112.25.13', 1476264188),
(9, 1, 'money', 0.01, '订单(ID:26)取消退回到余额', '', 0, '202.112.25.13', 1476266135),
(10, 4, 'money', 0.01, '订单(ID:28)取消退回到余额', '', 0, '202.112.25.13', 1476266136),
(11, 6, 'money', 0.01, '订单(ID:43)取消退回到余额', '', 0, '114.226.182.11', 1476429609),
(12, 1, 'money', -0.01, '订单抵扣金额', '', 0, '202.112.25.22', 1476554486),
(13, 1, 'money', -0.03, '订单抵扣金额', '', 0, '202.112.25.7', 1476800629),
(14, 1, 'money', 0.03, '订单(ID:62)取消退回到余额', '', 0, '202.112.25.7', 1476800657),
(15, 2, 'money', 100, '测试', '1:admin', 0, '60.166.196.49', 1476932762),
(16, 2, 'money', -18, '余额支付订单(ID:3)', '', 0, '60.166.196.49', 1476932770),
(17, 2, 'money', -10, '余额支付订单(ID:4)', '', 0, '60.166.198.181', 1476932890),
(18, 1, 'money', -0.02, '余额支付订单(ID:69)', '', 0, '202.112.25.6', 1476944207),
(19, 1, 'money', 0.01, '订单(ID:85)取消退回到余额', '', 0, '117.136.68.115', 1479106029),
(20, 9, 'money', 100, 'adf', '1:admin', 0, '36.57.177.152', 1481016466),
(21, 1, 'money', 19, '订单(ID:109)取消退回到余额', '', 0, '221.178.181.17', 1481111537);

-- --------------------------------------------------------

--
-- 表的结构 `jh_member_message`
--

CREATE TABLE IF NOT EXISTS `jh_member_message` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT '0',
  `title` varchar(80) DEFAULT NULL,
  `content` varchar(512) DEFAULT '',
  `type` tinyint(1) DEFAULT '0',
  `order_id` int(10) DEFAULT '0',
  `is_read` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`message_id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_order`
--

CREATE TABLE IF NOT EXISTS `jh_order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` smallint(6) DEFAULT '0',
  `shop_id` mediumint(8) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `product_number` mediumint(8) DEFAULT '0',
  `product_price` decimal(10,2) DEFAULT '0.00',
  `package_price` decimal(8,2) DEFAULT '0.00',
  `freight` decimal(6,2) DEFAULT '0.00',
  `money` decimal(10,2) DEFAULT '0.00',
  `amount` decimal(10,2) DEFAULT '0.00',
  `order_youhui` decimal(8,2) DEFAULT '0.00',
  `first_youhui` decimal(8,2) DEFAULT '0.00',
  `hongbao` decimal(8,2) DEFAULT '0.00',
  `hongbao_id` int(10) DEFAULT '0',
  `contact` varchar(30) DEFAULT '',
  `mobile` varchar(15) DEFAULT '',
  `addr` varchar(255) DEFAULT '',
  `house` varchar(150) DEFAULT '',
  `lat` varchar(15) DEFAULT '',
  `lng` varchar(15) DEFAULT '',
  `pei_time` char(11) DEFAULT '0',
  `note` varchar(150) DEFAULT '',
  `order_status` tinyint(1) DEFAULT '0',
  `pay_status` tinyint(1) DEFAULT '0',
  `online_pay` tinyint(1) DEFAULT '0',
  `pay_code` varchar(10) DEFAULT '',
  `pay_ip` varchar(15) DEFAULT '',
  `pay_time` int(10) DEFAULT '0',
  `staff_id` mediumint(8) DEFAULT '0',
  `pei_type` tinyint(1) DEFAULT '0',
  `pei_amount` decimal(6,2) DEFAULT '0.00',
  `comment_status` tinyint(1) DEFAULT '0',
  `cui_time` int(10) DEFAULT '0',
  `order_from` enum('weixin','ios','android','wap','www') DEFAULT 'weixin',
  `day` int(8) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  `lasttime` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`order_id`),
  KEY `shop_id` (`shop_id`,`uid`,`staff_id`),
  KEY `order_status` (`order_status`,`pay_status`,`closed`,`pei_type`),
  KEY `lat` (`lat`,`lng`),
  KEY `day` (`day`,`dateline`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=110 ;

--
-- 转存表中的数据 `jh_order`
--

INSERT INTO `jh_order` (`order_id`, `city_id`, `shop_id`, `uid`, `product_number`, `product_price`, `package_price`, `freight`, `money`, `amount`, `order_youhui`, `first_youhui`, `hongbao`, `hongbao_id`, `contact`, `mobile`, `addr`, `house`, `lat`, `lng`, `pei_time`, `note`, `order_status`, `pay_status`, `online_pay`, `pay_code`, `pay_ip`, `pay_time`, `staff_id`, `pei_type`, `pei_amount`, `comment_status`, `cui_time`, `order_from`, `day`, `closed`, `clientip`, `dateline`, `lasttime`) VALUES
(1, 22, 1, 1, 2, '46.00', '2.00', '7.00', '0.00', '55.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 0, 1, '', '', 0, 0, 1, '7.00', 0, 1475207725, 'wap', 20160930, 0, '117.136.67.105', 1475207725, 1475207725),
(2, 22, 1, 1, 2, '36.00', '2.00', '7.00', '0.00', '45.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 0, 0, '', '', 0, 0, 0, '0.00', 0, 1475663954, 'weixin', 20161005, 0, '112.81.190.186', 1475663954, 1475663954),
(3, 22, 1, 1, 2, '36.00', '2.00', '7.00', '0.00', '45.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 0, 1, '', '', 0, 0, 1, '7.00', 0, 1475741307, 'weixin', 20161006, 0, '112.81.190.186', 1475741307, 1475741307),
(4, 22, 1, 1, 2, '20.00', '2.00', '7.00', '0.00', '29.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 0, 1, '', '', 0, 0, 1, '7.00', 0, 1475853423, 'weixin', 20161007, 0, '202.112.25.30', 1475853423, 1475853423),
(5, 22, 1, 1, 2, '36.00', '2.00', '7.00', '0.00', '45.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 0, 1, '', '', 0, 0, 1, '7.00', 0, 1475936667, 'weixin', 20161008, 0, '202.112.25.30', 1475936667, 1475936667),
(6, 22, 1, 1, 2, '36.00', '2.00', '7.00', '0.00', '45.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 0, 1, '', '', 0, 0, 1, '7.00', 0, 1475936958, 'weixin', 20161008, 0, '202.112.25.30', 1475936958, 1475936958),
(7, 22, 1, 1, 2, '36.00', '2.00', '7.00', '0.00', '45.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 0, 1, '', '', 0, 0, 1, '7.00', 0, 1475942884, 'weixin', 20161009, 0, '202.112.25.30', 1475942884, 1475942884),
(8, 22, 1, 1, 3, '70.00', '3.00', '7.00', '0.00', '80.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 0, 1, '', '', 0, 0, 1, '7.00', 0, 1475943132, 'android', 20161009, 0, '202.112.25.30', 1475943132, 1475943132),
(9, 22, 1, 1, 2, '36.00', '2.00', '7.00', '0.00', '37.00', '8.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 0, 1, '', '', 0, 0, 1, '7.00', 0, 1475944938, 'android', 20161009, 0, '202.112.25.30', 1475944938, 1475944938),
(10, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 1, 1, 'wxpay', '101.226.103.70', 1476158523, 0, 0, '7.00', 0, 1476158502, 'android', 20161011, 0, '202.112.25.16', 1476158502, 1476158524),
(11, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476158579, 'android', 20161011, 0, '202.112.25.16', 1476158579, 1476158579),
(12, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476158632, 'weixin', 20161011, 0, '202.112.25.16', 1476158632, 1476158632),
(13, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476158739, 'weixin', 20161011, 0, '202.112.25.16', 1476158739, 1476158739),
(14, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476158764, 'weixin', 20161011, 0, '202.112.25.16', 1476158764, 1476158764),
(15, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476159294, 'android', 20161011, 0, '202.112.25.16', 1476159294, 1476159294),
(16, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476159559, 'weixin', 20161011, 0, '202.112.25.16', 1476159559, 1476159559),
(17, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', 8, 1, 1, 'money', '', 1476174581, 0, 0, '7.00', 0, 1476198282, 'weixin', 20161011, 0, '202.112.25.16', 1476160264, 1476198303),
(18, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 1, 1, 'wxpay', '101.226.103.62', 1476196207, 0, 0, '7.00', 0, 1476195884, 'weixin', 20161011, 0, '202.112.25.17', 1476195884, 1476196208),
(19, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 1, 1, 'wxpay', '101.226.103.70', 1476196437, 0, 0, '7.00', 0, 1476196426, 'weixin', 20161011, 0, '202.112.25.17', 1476196426, 1476196437),
(20, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', -1, 1, 1, 'wxpay', '140.207.54.75', 1476196520, 0, 0, '7.00', 0, 1476196509, 'android', 20161011, 0, '202.112.25.17', 1476196509, 1476196520),
(21, 22, 1, 1, 99, '0.99', '0.00', '0.00', '0.00', '0.99', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', 8, 1, 1, 'wxpay', '140.207.54.76', 1476198460, 0, 0, '7.00', 0, 1476198449, 'android', 20161011, 0, '202.112.25.17', 1476198449, 1476198570),
(22, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', 8, 0, 0, '', '', 0, 0, 0, '0.00', 1, 1476232585, 'android', 20161012, 0, '202.112.25.17', 1476232585, 1476232632),
(23, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', 8, 1, 1, 'wxpay', '140.207.54.73', 1476232804, 0, 0, '7.00', 0, 1476232752, 'android', 20161012, 0, '202.112.25.17', 1476232752, 1476232993),
(24, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '常州市钟楼区钟楼区', '莱蒙', '31.798511', '119.912439', '0', '', 8, 1, 1, 'wxpay', '140.207.54.75', 1476238703, 0, 0, '7.00', 0, 1476238695, 'android', 20161012, 0, '202.112.25.17', 1476238695, 1476238828),
(25, 22, 1, 4, 1, '0.01', '0.00', '0.00', '0.00', '-4.99', '0.00', '5.00', '0.00', 0, '周文兴', '13921330310', '江苏省常州市钟楼区', '南大街/双桂坊(路口)', '31.782186', '119.960722', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476262734, 'weixin', 20161012, 0, '49.80.137.143', 1476262734, 1476262734),
(26, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '北环路东侧、竹林北路北侧', '新城尚东区花园', '31.791457', '119.992964', '0', '', -1, 1, 1, 'wxpay', '101.226.103.69', 1476262844, 0, 0, '7.00', 0, 1476262833, 'android', 20161012, 0, '202.112.25.13', 1476262833, 1476262845),
(27, 22, 1, 4, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '周文兴', '13921330310', '江苏省常州市钟楼区', '南大街/双桂坊(路口)', '31.782186', '119.960722', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476262996, 'weixin', 20161012, 0, '49.80.137.143', 1476262996, 1476262996),
(28, 22, 1, 4, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '周文兴', '13921330310', '江苏省常州市钟楼区', '南大街/双桂坊(路口)', '31.782186', '119.960722', '0', '', -1, 1, 1, 'wxpay', '140.207.54.75', 1476263140, 0, 0, '7.00', 0, 1476263129, 'weixin', 20161012, 0, '49.80.137.143', 1476263129, 1476263140),
(29, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '北环路东侧、竹林北路北侧', '新城尚东区花园', '31.791457', '119.992964', '0', '', -1, 1, 1, 'money', '202.112.25.13', 1476264179, 0, 0, '7.00', 0, 1476264179, 'weixin', 20161012, 0, '202.112.25.13', 1476264179, 1476264179),
(30, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '北环路东侧、竹林北路北侧', '新城尚东区花园', '31.791457', '119.992964', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476264196, 'weixin', 20161012, 0, '202.112.25.13', 1476264196, 1476264196),
(31, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '北环路东侧、竹林北路北侧', '新城尚东区花园', '31.791457', '119.992964', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476264890, 'android', 20161012, 0, '202.112.25.13', 1476264890, 1476264890),
(32, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '北环路东侧、竹林北路北侧', '新城尚东区花园', '31.791457', '119.992964', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476267044, 'weixin', 20161012, 0, '202.112.25.13', 1476267044, 1476267044),
(33, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.74', 1476275963, 0, 0, '7.00', 0, 1476275945, 'android', 20161012, 0, '202.112.25.13', 1476275945, 1476276047),
(34, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', -1, 0, 0, '', '', 0, 0, 0, '0.00', 0, 1476347507, 'weixin', 20161013, 0, '202.112.25.9', 1476347507, 1476347507),
(35, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476347541, 'weixin', 20161013, 0, '202.112.25.9', 1476347541, 1476347541),
(36, 22, 1, 1, 1, '1.00', '0.00', '0.00', '0.00', '1.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.76', 1476368855, 0, 0, '7.00', 0, 1476368843, 'weixin', 20161013, 0, '202.112.25.9', 1476368843, 1476368959),
(37, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476384391, 'weixin', 20161014, 0, '202.112.25.9', 1476384391, 1476384391),
(38, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476384516, 'weixin', 20161014, 0, '202.112.25.9', 1476384516, 1476384516),
(39, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476384558, 'weixin', 20161014, 0, '202.112.25.9', 1476384558, 1476384558),
(40, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476385053, 'wap', 20161014, 0, '202.112.25.9', 1476385053, 1476385053),
(41, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476385739, 'wap', 20161014, 0, '202.112.25.9', 1476385739, 1476385739),
(42, 22, 1, 1, 1, '1.00', '0.00', '0.00', '0.00', '1.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 0, '7.00', 0, 1476385793, 'wap', 20161014, 0, '202.112.25.9', 1476385793, 1476385793),
(43, 22, 1, 6, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '赵俐娜', '13506144317', '勤业路262号附近', '钟楼区莱茵花苑23号商铺感岛眼镜店', '31.793802', '119.93196', '0', '', -1, 1, 1, 'alipay', '114.226.182.11', 1476429598, 0, 0, '7.00', 0, 1476429554, 'weixin', 20161014, 0, '114.226.182.11', 1476429554, 1476429598),
(44, 22, 1, 1, 1, '1.00', '0.00', '0.00', '0.00', '1.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.74', 1476456836, 0, 0, '7.00', 0, 1476456821, 'android', 20161014, 0, '202.112.25.25', 1476456821, 1476456874),
(45, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '101.226.103.62', 1476523091, 0, 0, '7.00', 0, 1476523078, 'android', 20161015, 0, '202.112.25.7', 1476523078, 1476523148),
(46, 22, 1, 1, 1, '1.00', '0.00', '0.00', '0.00', '1.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '101.226.103.62', 1476524111, 0, 0, '7.00', 0, 1476524099, 'android', 20161015, 0, '202.112.25.7', 1476524099, 1476524129),
(47, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.75', 1476552951, 0, 0, '7.00', 0, 1476552941, 'weixin', 20161016, 0, '202.112.25.22', 1476552941, 1476552989),
(48, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '101.226.103.70', 1476554592, 1, 1, '0.02', 0, 1476554440, 'android', 20161016, 0, '202.112.25.22', 1476554440, 1476555151),
(49, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'money', '202.112.25.22', 1476554486, 0, 0, '0.02', 0, 1476554486, 'weixin', 20161016, 0, '202.112.25.22', 1476554486, 1476554974),
(50, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '101.226.103.62', 1476555423, 1, 1, '0.02', 0, 1476555410, 'android', 20161016, 0, '202.112.25.22', 1476555410, 1476555531),
(51, 22, 1, 1, 1, '1.00', '0.00', '1.00', '0.00', '2.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.73', 1476556361, 1, 1, '1.00', 0, 1476556353, 'android', 20161016, 0, '202.112.25.22', 1476556353, 1476556470),
(52, 22, 1, 1, 2, '0.02', '0.00', '0.01', '0.00', '0.03', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 1, '0.01', 0, 1476707262, 'android', 20161017, 0, '202.112.25.14', 1476707262, 1476707262),
(53, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 1, '0.01', 0, 1476773080, 'android', 20161018, 0, '202.112.25.7', 1476773080, 1476773080),
(54, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', 'ff', '31.785365', '119.984917', '0', '', -1, 0, 0, '', '', 0, 0, 0, '0.00', 0, 1476773105, 'android', 20161018, 0, '202.112.25.7', 1476773105, 1476773105),
(55, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.76', 1476779919, 1, 1, '0.01', 0, 1476779907, 'android', 20161018, 0, '202.112.25.7', 1476779907, 1476780061),
(56, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', 'ff', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 1, '0.01', 0, 1476790090, 'android', 20161018, 0, '202.112.25.7', 1476790090, 1476790090),
(57, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 1, '0.01', 0, 1476790500, 'android', 20161018, 0, '202.112.25.7', 1476790500, 1476790500),
(58, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', 'ff', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '101.226.103.69', 1476790629, 1, 1, '0.01', 0, 1476790617, 'android', 20161018, 0, '202.112.25.7', 1476790617, 1476790727),
(59, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.76', 1476794409, 0, 0, '0.01', 0, 1476794395, 'android', 20161018, 0, '202.112.25.7', 1476794395, 1476794511),
(60, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.75', 1476794554, 1, 1, '0.01', 0, 1476794544, 'android', 20161018, 0, '202.112.25.7', 1476794544, 1476798660),
(61, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', 'ff', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 1, '0.01', 0, 1476799269, 'android', 20161018, 0, '202.112.25.7', 1476799269, 1476799269),
(62, 22, 1, 1, 2, '0.02', '0.00', '0.01', '0.03', '0.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', 'ff', '31.785365', '119.984917', '0', '', -1, 1, 1, 'money', '202.112.25.7', 1476800629, 0, 1, '0.01', 0, 1476800629, 'weixin', 20161018, 0, '202.112.25.7', 1476800629, 1476800629),
(63, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331949', '全佳福北京涮羊肉(尚东店)', '尚东区花园54号', '31.785594', '119.984394', '0', '', -1, 0, 1, '', '', 0, 0, 1, '0.01', 0, 1476805557, 'weixin', 20161018, 0, '202.112.25.7', 1476805557, 1476805557),
(64, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '101.226.103.61', 1476810687, 0, 0, '0.01', 0, 1476810669, 'android', 20161019, 0, '202.112.25.7', 1476810669, 1476810937),
(65, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.75', 1476811064, 0, 0, '0.01', 0, 1476811054, 'android', 20161019, 0, '202.112.25.7', 1476811054, 1476811141),
(66, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '101.226.103.69', 1476811241, 1, 1, '0.01', 0, 1476811231, 'android', 20161019, 0, '202.112.25.7', 1476811231, 1476811290),
(67, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', 'ff', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '101.226.103.70', 1476811415, 0, 0, '0.01', 0, 1476811405, 'android', 20161019, 0, '202.112.25.7', 1476811405, 1476818224),
(68, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.75', 1476942760, 1, 1, '0.01', 0, 1476942734, 'android', 20161020, 0, '202.112.25.6', 1476942734, 1476942824),
(69, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'money', '202.112.25.6', 1476944207, 0, 0, '0.01', 0, 1476944198, 'android', 20161020, 0, '202.112.25.6', 1476944198, 1476944292),
(70, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', 'ff', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.73', 1476947599, 1, 1, '0.01', 0, 1476947588, 'android', 20161020, 0, '202.112.25.6', 1476947588, 1476947708),
(71, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '101.226.103.69', 1476947848, 0, 0, '0.01', 0, 1476964508, 'android', 20161020, 0, '202.112.25.6', 1476947839, 1476947925),
(72, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331949', '全佳福北京涮羊肉(尚东店)', '尚东区花园54号', '31.785594', '119.984394', '0', '', -1, 0, 1, '', '', 0, 0, 0, '0.01', 0, 1476948466, 'weixin', 20161020, 0, '202.112.25.6', 1476948466, 1476948466),
(73, 22, 1, 1, 2, '0.02', '0.00', '0.01', '0.00', '0.03', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', 'ff', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 0, '0.01', 0, 1476955572, 'weixin', 20161020, 0, '202.112.25.6', 1476955572, 1476955572),
(74, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 0, '0.01', 0, 1476957766, 'weixin', 20161020, 0, '202.112.25.6', 1476957766, 1476957766),
(75, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.76', 1477015540, 0, 0, '0.01', 0, 1477015525, 'android', 20161021, 0, '202.112.25.6', 1477015525, 1477015618),
(76, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.76', 1477015714, 0, 0, '0.01', 0, 1477015705, 'android', 20161021, 0, '202.112.25.6', 1477015705, 1477015778),
(77, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', 'ff', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 0, '0.01', 0, 1477051668, 'android', 20161021, 0, '202.112.25.6', 1477051668, 1477051668),
(78, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', 'ff', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.76', 1477051878, 0, 0, '0.01', 0, 1477051870, 'android', 20161021, 0, '202.112.25.6', 1477051870, 1477051902),
(79, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.75', 1477179269, 0, 0, '0.01', 0, 1477179257, 'android', 20161023, 0, '202.112.25.6', 1477179257, 1477188364),
(80, 22, 1, 1, 1, '0.01', '0.00', '0.01', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '101.226.103.62', 1477205040, 0, 0, '0.01', 0, 1477205028, 'android', 20161023, 0, '112.81.145.10', 1477205028, 1477205059),
(81, 22, 1, 1, 2, '0.02', '0.00', '0.01', '0.00', '0.03', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.76', 1477277148, 0, 0, '0.01', 0, 1477277140, 'android', 20161024, 0, '112.81.254.230', 1477277140, 1477277181),
(82, 22, 1, 1, 2, '0.02', '0.00', '0.01', '0.00', '0.03', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 0, '0.01', 0, 1478955552, 'wap', 20161112, 0, '202.112.25.20', 1478955552, 1478955552),
(83, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', 'ff', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.75', 1479065097, 0, 0, '0.01', 0, 1479065087, 'android', 20161114, 0, '202.112.25.12', 1479065087, 1479065315),
(84, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.73', 1479105568, 1, 2, '0.01', 0, 1479105559, 'android', 20161114, 0, '117.136.68.115', 1479105559, 1479105840),
(85, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', 'ff', '31.785365', '119.984917', '0', '', -1, 1, 1, 'wxpay', '101.226.103.62', 1479105912, 0, 2, '0.01', 0, 1479105901, 'android', 20161114, 0, '117.136.68.115', 1479105901, 1479105913),
(86, 22, 1, 1, 2, '0.02', '0.00', '0.00', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 2, 1, 1, 'wxpay', '140.207.54.76', 1479106071, 1, 2, '0.01', 0, 1479106062, 'android', 20161114, 0, '117.136.68.115', 1479106062, 1479106071),
(87, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 2, 1, 1, 'wxpay', '140.207.54.76', 1479106245, 1, 2, '0.01', 0, 1479106234, 'android', 20161114, 0, '117.136.68.115', 1479106234, 1479106245),
(88, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 0, 1, 1, 'wxpay', '101.226.103.69', 1479119796, 0, 2, '0.01', 0, 1479119788, 'android', 20161114, 0, '202.112.25.23', 1479119788, 1479119796),
(89, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 0, 1, 1, 'wxpay', '140.207.54.76', 1479119910, 0, 2, '0.01', 0, 1479119900, 'weixin', 20161114, 0, '202.112.25.23', 1479119900, 1479119910),
(90, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 2, '0.01', 0, 1479120008, 'android', 20161114, 0, '202.112.25.23', 1479120008, 1479120008),
(91, 22, 1, 1, 1, '0.01', '0.00', '0.00', '0.00', '0.01', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 0, 1, 1, 'wxpay', '101.226.103.61', 1479120048, 0, 2, '0.01', 0, 1479120040, 'android', 20161114, 0, '202.112.25.23', 1479120040, 1479120048),
(92, 22, 1, 1, 2, '0.02', '0.00', '0.00', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 2, 1, 1, 'wxpay', '101.226.103.62', 1479120376, 1, 2, '0.01', 0, 1479120365, 'android', 20161114, 0, '202.112.25.23', 1479120365, 1479120376),
(93, 22, 1, 1, 2, '0.02', '0.00', '0.00', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 2, 1, 1, 'wxpay', '140.207.54.76', 1479122549, 1, 2, '0.01', 0, 1479122536, 'android', 20161114, 0, '202.112.25.23', 1479122536, 1479122549),
(94, 22, 1, 1, 3, '0.03', '0.00', '0.00', '0.00', '0.03', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', 'ff', '31.785365', '119.984917', '0', '', 0, 1, 1, 'wxpay', '140.207.54.76', 1479122727, 0, 2, '0.03', 0, 1479122716, 'android', 20161114, 0, '202.112.25.23', 1479122716, 1479122727),
(95, 22, 1, 1, 5, '0.05', '0.00', '0.00', '0.00', '0.05', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 8, 1, 1, 'wxpay', '140.207.54.76', 1479122923, 1, 2, '0.03', 0, 1479122916, 'android', 20161114, 0, '202.112.25.23', 1479122916, 1479123404),
(96, 22, 1, 1, 2, '0.02', '0.00', '0.00', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 0, 1, 1, 'wxpay', '140.207.54.75', 1479144335, 0, 2, '0.03', 0, 1479144327, 'android', 20161115, 0, '202.112.25.23', 1479144327, 1479144335),
(97, 22, 1, 1, 2, '0.02', '0.00', '0.00', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 2, 1, 1, 'wxpay', '101.226.103.62', 1479144576, 1, 2, '0.03', 0, 1479144568, 'android', 20161115, 0, '202.112.25.23', 1479144568, 1479144576),
(98, 22, 1, 1, 2, '0.02', '0.00', '0.00', '0.00', '0.02', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', 0, 1, 1, 'wxpay', '140.207.54.73', 1479144707, 0, 2, '0.00', 0, 1479144699, 'android', 20161115, 0, '202.112.25.23', 1479144699, 1479144707),
(99, 22, 1, 1, 1, '18.00', '1.00', '0.00', '0.00', '19.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 2, '0.00', 0, 1479485237, 'android', 20161119, 0, '202.112.25.23', 1479485237, 1479485237),
(100, 22, 1, 8, 4, '72.00', '4.00', '0.00', '0.00', '76.00', '0.00', '0.00', '0.00', 0, '18655488651', '18655488651', '江苏省常州市天宁区', '宁东路与腾飞路交叉口', '31.7924', '119.99132', '0', '', -1, 0, 0, '', '', 0, 0, 0, '0.00', 0, 1479687636, 'wap', 20161121, 0, '112.26.227.116', 1479687636, 1479687636),
(101, 22, 1, 1, 1, '18.00', '1.00', '0.00', '0.00', '19.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331940', '新城尚东区花园西区', '1417', '31.785365', '119.984917', '0', '', -1, 0, 1, '', '', 0, 0, 2, '0.00', 0, 1480247627, 'android', 20161127, 0, '112.81.147.219', 1480247627, 1480247627),
(102, 22, 1, 1, 1, '18.00', '1.00', '0.00', '0.00', '19.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331949', '全佳福北京涮羊肉(尚东店)', '尚东区花园54号', '31.785594', '119.984394', '0', '', -1, 0, 1, '', '', 0, 0, 2, '0.00', 0, 1480247736, 'weixin', 20161127, 0, '112.81.147.219', 1480247736, 1480247736),
(103, 22, 1, 1, 1, '18.00', '1.00', '0.00', '0.00', '19.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331949', '全佳福北京涮羊肉(尚东店)', '尚东区花园54号', '31.785594', '119.984394', '0', '', -1, 0, 1, '', '', 0, 0, 2, '0.00', 0, 1480766004, 'weixin', 20161203, 0, '153.35.47.104', 1480766004, 1480766004),
(104, 1, 2, 10, 1, '5.00', '0.00', '0.00', '0.00', '5.00', '0.00', '0.00', '0.00', 0, '测试', '13856565656', '合肥市蜀山区', '五彩国际', '31.836407', '117.255809', '0', '', -1, 0, 1, '', '', 0, 0, 0, '0.00', 0, 1481017048, 'weixin', 20161206, 0, '36.57.177.152', 1481017048, 1481017048),
(105, 1, 2, 10, 2, '10.00', '0.00', '0.00', '0.00', '10.00', '0.00', '0.00', '0.00', 0, '测试', '13856565656', '合肥市蜀山区', '五彩国际', '31.836407', '117.255809', '0', '', -1, 0, 1, '', '', 0, 0, 0, '0.00', 0, 1481017180, 'weixin', 20161206, 0, '36.57.177.152', 1481017180, 1481017180),
(106, 1, 2, 10, 1, '5.00', '0.00', '0.00', '0.00', '5.00', '0.00', '0.00', '0.00', 0, '测试', '13856565656', '合肥市蜀山区', '五彩国际', '31.836407', '117.255809', '0', '', -1, 0, 1, '', '', 0, 0, 0, '0.00', 0, 1481017373, 'wap', 20161206, 0, '117.68.226.251', 1481017373, 1481017373),
(107, 1, 2, 10, 1, '5.00', '0.00', '0.00', '0.00', '5.00', '0.00', '0.00', '0.00', 0, '测试', '13856565656', '合肥市蜀山区', '五彩国际', '31.836407', '117.255809', '0', '', -1, 0, 1, '', '', 0, 0, 0, '0.00', 0, 1481017465, 'weixin', 20161206, 0, '117.68.226.251', 1481017465, 1481017465),
(108, 22, 1, 1, 1, '18.00', '1.00', '0.00', '0.00', '19.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331949', '全佳福北京涮羊肉(尚东店)', '尚东区花园54号', '31.785594', '119.984394', '0', '', -1, 0, 1, '', '', 0, 0, 0, '0.00', 0, 1481079319, 'weixin', 20161207, 0, '122.193.190.152', 1481079319, 1481079319),
(109, 22, 1, 1, 1, '18.00', '1.00', '0.00', '0.00', '19.00', '0.00', '0.00', '0.00', 0, '吴志新', '13771331949', '全佳福北京涮羊肉(尚东店)', '尚东区花园54号', '31.785594', '119.984394', '0', '', -1, 1, 1, 'wxpay', '140.207.54.76', 1481090604, 0, 0, '0.00', 0, 1481090590, 'weixin', 20161207, 0, '122.193.190.152', 1481090590, 1481090604);

-- --------------------------------------------------------

--
-- 表的结构 `jh_order_complaint`
--

CREATE TABLE IF NOT EXISTS `jh_order_complaint` (
  `complaint_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) DEFAULT NULL,
  `uid` mediumint(8) DEFAULT '0',
  `shop_id` mediumint(8) DEFAULT '0',
  `staff_id` mediumint(8) DEFAULT '0',
  `title` varchar(80) DEFAULT '',
  `content` varchar(255) DEFAULT '',
  `clientip` varchar(15) DEFAULT '',
  `reply` varchar(255) DEFAULT '',
  `reply_time` int(10) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`complaint_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `jh_order_complaint`
--

INSERT INTO `jh_order_complaint` (`complaint_id`, `order_id`, `uid`, `shop_id`, `staff_id`, `title`, `content`, `clientip`, `reply`, `reply_time`, `dateline`) VALUES
(1, 24, 1, 1, 0, '投诉其他', '不好。', '202.112.25.17', '', 0, 1476238870),
(2, 33, 1, 1, 0, '商家参加了活动，但没有给优惠', '没优惠。', '202.112.25.13', '', 0, 1476276076);

-- --------------------------------------------------------

--
-- 表的结构 `jh_order_log`
--

CREATE TABLE IF NOT EXISTS `jh_order_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) DEFAULT '0',
  `from` enum('shop','admin','staff','member','payment') DEFAULT 'member',
  `log` varchar(255) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  `type` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`log_id`),
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=386 ;

--
-- 转存表中的数据 `jh_order_log`
--

INSERT INTO `jh_order_log` (`log_id`, `order_id`, `from`, `log`, `dateline`, `type`) VALUES
(1, 1, 'member', '订单已提交', 1475207725, 1),
(2, 1, 'member', '用户取消订单(ID:1)', 1475219030, -1),
(3, 2, 'member', '订单已提交', 1475663954, 1),
(4, 2, 'member', '用户取消订单(ID:2)', 1475664001, -1),
(5, 3, 'member', '订单已提交', 1475741307, 1),
(6, 4, 'member', '订单已提交', 1475853423, 1),
(7, 5, 'member', '订单已提交', 1475936667, 1),
(8, 6, 'member', '订单已提交', 1475936958, 1),
(9, 7, 'member', '订单已提交', 1475942884, 1),
(10, 8, 'member', '订单已提交成功', 1475943132, 1),
(11, 8, 'member', '用户取消订单(ID:8)', 1475943196, -1),
(12, 7, 'member', '用户取消订单(ID:7)', 1475943208, -1),
(13, 6, 'member', '用户取消订单(ID:6)', 1475943216, -1),
(14, 4, 'member', '用户取消订单(ID:4)', 1475943223, -1),
(15, 3, 'member', '用户取消订单(ID:3)', 1475943230, -1),
(16, 5, 'member', '用户取消订单(ID:5)', 1475943234, -1),
(17, 9, 'member', '订单已提交成功', 1475944938, 1),
(18, 10, 'member', '订单已提交成功', 1476158502, 1),
(19, 10, 'payment', '订单支付成功', 1476158523, 2),
(20, 11, 'member', '订单已提交成功', 1476158579, 1),
(21, 12, 'member', '订单已提交', 1476158632, 1),
(22, 13, 'member', '订单已提交', 1476158739, 1),
(23, 14, 'member', '订单已提交', 1476158764, 1),
(24, 15, 'member', '订单已提交成功', 1476159294, 1),
(25, 16, 'member', '订单已提交', 1476159559, 1),
(26, 17, 'member', '订单已提交', 1476160264, 1),
(27, 10, 'admin', '管理员取消订单(ID:10)', 1476165387, -1),
(28, 18, 'member', '订单已提交', 1476195884, 1),
(29, 18, 'payment', '订单支付成功', 1476196207, 2),
(30, 15, 'member', '用户取消订单(ID:15)', 1476196326, -1),
(31, 11, 'member', '用户取消订单(ID:11)', 1476196358, -1),
(32, 19, 'member', '订单已提交', 1476196426, 1),
(33, 19, 'payment', '订单支付成功', 1476196437, 2),
(34, 20, 'member', '订单已提交成功', 1476196509, 1),
(35, 20, 'payment', '订单支付成功', 1476196520, 2),
(36, 18, 'shop', '商家取消订单(ID:18)', 1476197026, -1),
(37, 19, 'shop', '商家取消订单(ID:19)', 1476197027, -1),
(38, 20, 'shop', '商家取消订单(ID:20)', 1476197033, -1),
(39, 17, 'shop', '商家已接单', 1476198239, 3),
(40, 17, 'shop', '商家开始配送', 1476198246, 4),
(41, 17, 'shop', '订单已送达', 1476198303, 5),
(42, 17, 'member', '用户确认订单完成', 1476198337, 6),
(43, 21, 'member', '订单已提交成功', 1476198449, 1),
(44, 21, 'payment', '订单支付成功', 1476198460, 2),
(45, 21, 'shop', '商家已接单', 1476198478, 3),
(46, 21, 'shop', '商家开始配送', 1476198539, 4),
(47, 21, 'shop', '订单已送达', 1476198570, 5),
(48, 21, 'member', '用户确认订单完成', 1476198589, 6),
(49, 16, 'member', '用户取消订单(ID:16)', 1476232523, -1),
(50, 14, 'member', '用户取消订单(ID:14)', 1476232527, -1),
(51, 9, 'member', '用户取消订单(ID:9)', 1476232536, -1),
(52, 12, 'member', '用户取消订单(ID:12)', 1476232551, -1),
(53, 13, 'member', '用户取消订单(ID:13)', 1476232558, -1),
(54, 22, 'member', '订单已提交成功', 1476232585, 1),
(55, 22, 'shop', '商家已接单', 1476232604, 3),
(56, 22, 'shop', '商家开始配送', 1476232613, 4),
(57, 22, 'shop', '订单已送达', 1476232632, 5),
(58, 22, 'member', '用户确认订单完成', 1476232646, 6),
(59, 23, 'member', '订单已提交成功', 1476232752, 1),
(60, 23, 'payment', '订单支付成功', 1476232804, 2),
(61, 23, 'shop', '商家已接单', 1476232823, 3),
(62, 23, 'shop', '商家开始配送', 1476232974, 4),
(63, 23, 'shop', '订单已送达', 1476232993, 5),
(64, 23, 'member', '用户确认订单完成', 1476233006, 6),
(65, 24, 'member', '订单已提交成功', 1476238695, 1),
(66, 24, 'payment', '订单支付成功', 1476238703, 2),
(67, 24, 'shop', '商家已接单', 1476238718, 3),
(68, 24, 'shop', '商家开始配送', 1476238725, 4),
(69, 24, 'shop', '订单已送达', 1476238828, 5),
(70, 24, 'member', '用户确认订单完成', 1476238872, 6),
(71, 25, 'member', '订单已提交', 1476262734, 1),
(72, 26, 'member', '订单已提交成功', 1476262833, 1),
(73, 26, 'payment', '订单支付成功', 1476262844, 2),
(74, 27, 'member', '订单已提交', 1476262996, 1),
(75, 28, 'member', '订单已提交', 1476263129, 1),
(76, 28, 'payment', '订单支付成功', 1476263140, 2),
(77, 29, 'member', '订单已提交', 1476264179, 1),
(78, 29, 'member', '订单余额支付成功', 1476264179, 2),
(79, 29, 'member', '用户取消订单(ID:29)', 1476264188, -1),
(80, 30, 'member', '订单已提交', 1476264196, 1),
(81, 31, 'member', '订单已提交成功', 1476264890, 1),
(82, 31, 'member', '用户取消订单(ID:31)', 1476265960, -1),
(83, 26, 'shop', '商家取消订单(ID:26)', 1476266135, -1),
(84, 28, 'shop', '商家取消订单(ID:28)', 1476266136, -1),
(85, 32, 'member', '订单已提交', 1476267044, 1),
(86, 33, 'member', '订单已提交成功', 1476275945, 1),
(87, 33, 'payment', '订单支付成功', 1476275963, 2),
(88, 33, 'shop', '商家已接单', 1476275988, 3),
(89, 33, 'shop', '商家开始配送', 1476275993, 4),
(90, 33, 'shop', '订单已送达', 1476276047, 5),
(91, 33, 'member', '用户确认订单完成', 1476276056, 6),
(92, 34, 'member', '订单已提交', 1476347507, 1),
(93, 34, 'member', '用户取消订单(ID:34)', 1476347519, -1),
(94, 35, 'member', '订单已提交', 1476347541, 1),
(95, 36, 'member', '订单已提交', 1476368843, 1),
(96, 36, 'payment', '订单支付成功', 1476368855, 2),
(97, 36, 'shop', '商家已接单', 1476368874, 3),
(98, 36, 'shop', '商家开始配送', 1476368949, 4),
(99, 36, 'shop', '订单已送达', 1476368959, 5),
(100, 36, 'member', '用户确认订单完成', 1476368992, 6),
(101, 37, 'member', '订单已提交', 1476384391, 1),
(102, 38, 'member', '订单已提交', 1476384516, 1),
(103, 39, 'member', '订单已提交', 1476384558, 1),
(104, 40, 'member', '订单已提交', 1476385053, 1),
(105, 41, 'member', '订单已提交', 1476385739, 1),
(106, 42, 'member', '订单已提交', 1476385793, 1),
(107, 43, 'member', '订单已提交', 1476429554, 1),
(108, 43, 'payment', '订单支付成功', 1476429598, 2),
(109, 43, 'member', '用户取消订单(ID:43)', 1476429609, -1),
(110, 44, 'member', '订单已提交成功', 1476456821, 1),
(111, 44, 'payment', '订单支付成功', 1476456836, 2),
(112, 44, 'shop', '商家已接单', 1476456847, 3),
(113, 44, 'shop', '商家开始配送', 1476456856, 4),
(114, 44, 'shop', '订单已送达', 1476456874, 5),
(115, 44, 'member', '用户确认订单完成', 1476456915, 6),
(116, 42, 'member', '用户取消订单(ID:42)', 1476457083, -1),
(117, 45, 'member', '订单已提交成功', 1476523078, 1),
(118, 45, 'payment', '订单支付成功', 1476523091, 2),
(119, 45, 'shop', '商家已接单', 1476523133, 3),
(120, 45, 'shop', '商家开始配送', 1476523139, 4),
(121, 45, 'shop', '订单已送达', 1476523148, 5),
(122, 45, 'member', '用户确认订单完成', 1476523176, 6),
(123, 46, 'member', '订单已提交成功', 1476524099, 1),
(124, 46, 'payment', '订单支付成功', 1476524111, 2),
(125, 46, 'shop', '商家已接单', 1476524121, 3),
(126, 46, 'shop', '商家开始配送', 1476524125, 4),
(127, 46, 'shop', '订单已送达', 1476524129, 5),
(128, 46, 'member', '用户确认订单完成', 1476524178, 6),
(129, 41, 'member', '用户取消订单(ID:41)', 1476524270, -1),
(130, 47, 'member', '订单已提交', 1476552941, 1),
(131, 47, 'payment', '订单支付成功', 1476552951, 2),
(132, 47, 'shop', '商家已接单', 1476552966, 3),
(133, 47, 'shop', '商家开始配送', 1476552977, 4),
(134, 47, 'shop', '订单已送达', 1476552989, 5),
(135, 47, 'member', '用户确认订单完成', 1476553046, 6),
(136, 48, 'member', '订单已提交成功', 1476554440, 1),
(137, 49, 'member', '订单已提交', 1476554486, 1),
(138, 49, 'member', '订单余额支付成功', 1476554486, 2),
(139, 48, 'payment', '订单支付成功', 1476554592, 2),
(140, 48, 'shop', '商家已接单', 1476554948, 3),
(141, 49, 'shop', '商家已接单', 1476554954, 3),
(142, 49, 'shop', '商家自己开始配送', 1476554966, 3),
(143, 49, 'shop', '订单已送达', 1476554974, 5),
(144, 48, 'staff', '配送员(吴志新)准备为您配送', 1476555139, 2),
(145, 48, 'staff', '配送员(吴志新)开始为您配送', 1476555147, 4),
(146, 48, 'staff', '配送员(吴志新)已经为您送达', 1476555151, 5),
(147, 49, 'member', '用户确认订单完成', 1476555322, 6),
(148, 40, 'member', '用户取消订单(ID:40)', 1476555327, -1),
(149, 50, 'member', '订单已提交成功', 1476555410, 1),
(150, 50, 'payment', '订单支付成功', 1476555423, 2),
(151, 50, 'shop', '商家已接单', 1476555454, 3),
(152, 50, 'staff', '配送员(吴志新)准备为您配送', 1476555509, 2),
(153, 50, 'staff', '配送员(吴志新)开始为您配送', 1476555526, 4),
(154, 50, 'staff', '配送员(吴志新)已经为您送达', 1476555531, 5),
(155, 51, 'member', '订单已提交成功', 1476556353, 1),
(156, 51, 'payment', '订单支付成功', 1476556361, 2),
(157, 51, 'shop', '商家已接单', 1476556372, 3),
(158, 51, 'staff', '配送员(吴志新)准备为您配送', 1476556385, 2),
(159, 51, 'staff', '配送员(吴志新)开始为您配送', 1476556388, 4),
(160, 51, 'staff', '配送员(吴志新)已经为您送达', 1476556470, 5),
(161, 51, 'member', '用户确认订单完成', 1476556600, 6),
(162, 37, 'member', '用户取消订单(ID:37)', 1476583380, -1),
(163, 52, 'member', '订单已提交成功', 1476707262, 1),
(164, 53, 'member', '订单已提交成功', 1476773080, 1),
(165, 53, 'member', '用户取消订单(ID:53)', 1476773086, -1),
(166, 54, 'member', '订单已提交成功', 1476773105, 1),
(167, 54, 'member', '用户取消订单(ID:54)', 1476773109, -1),
(168, 55, 'member', '订单已提交成功', 1476779907, 1),
(169, 55, 'payment', '订单支付成功', 1476779919, 2),
(170, 55, 'shop', '商家已接单', 1476779953, 3),
(171, 55, 'staff', '配送员(吴志新)准备为您配送', 1476780037, 2),
(172, 55, 'staff', '配送员(吴志新)开始为您配送', 1476780054, 4),
(173, 55, 'staff', '配送员(吴志新)已经为您送达', 1476780061, 5),
(174, 56, 'member', '订单已提交成功', 1476790090, 1),
(175, 56, 'member', '用户取消订单(ID:56)', 1476790116, -1),
(176, 57, 'member', '订单已提交成功', 1476790500, 1),
(177, 58, 'member', '订单已提交成功', 1476790617, 1),
(178, 58, 'payment', '订单支付成功', 1476790629, 2),
(179, 58, 'shop', '商家已接单', 1476790662, 3),
(180, 58, 'staff', '配送员(吴志新)准备为您配送', 1476790719, 2),
(181, 58, 'staff', '配送员(吴志新)开始为您配送', 1476790725, 4),
(182, 58, 'staff', '配送员(吴志新)已经为您送达', 1476790727, 5),
(183, 58, 'member', '用户确认订单完成', 1476790997, 6),
(184, 59, 'member', '订单已提交成功', 1476794395, 1),
(185, 59, 'payment', '订单支付成功', 1476794409, 2),
(186, 59, 'shop', '商家已接单', 1476794430, 3),
(187, 59, 'shop', '商家自己开始配送', 1476794487, 3),
(188, 59, 'shop', '订单已送达', 1476794511, 5),
(189, 59, 'member', '用户确认订单完成', 1476794523, 6),
(190, 60, 'member', '订单已提交成功', 1476794544, 1),
(191, 60, 'payment', '订单支付成功', 1476794554, 2),
(192, 60, 'shop', '商家已接单', 1476794567, 3),
(193, 60, 'staff', '配送员(吴志新)准备为您配送', 1476794587, 2),
(194, 60, 'staff', '配送员(吴志新)开始为您配送', 1476794599, 4),
(195, 60, 'staff', '配送员(吴志新)已经为您送达', 1476798660, 5),
(196, 61, 'member', '订单已提交成功', 1476799269, 1),
(197, 62, 'member', '订单已提交', 1476800629, 1),
(198, 62, 'member', '订单余额支付成功', 1476800629, 2),
(199, 62, 'member', '用户取消订单(ID:62)', 1476800657, -1),
(200, 63, 'member', '订单已提交', 1476805557, 1),
(201, 63, 'member', '用户取消订单(ID:63)', 1476805582, -1),
(202, 64, 'member', '订单已提交成功', 1476810669, 1),
(203, 64, 'payment', '订单支付成功', 1476810687, 2),
(204, 64, 'shop', '商家已接单', 1476810903, 3),
(205, 64, 'shop', '商家自己开始配送', 1476810923, 3),
(206, 64, 'shop', '订单已送达', 1476810937, 5),
(207, 64, 'member', '用户确认订单完成', 1476811000, 6),
(208, 65, 'member', '订单已提交成功', 1476811054, 1),
(209, 65, 'payment', '订单支付成功', 1476811064, 2),
(210, 65, 'shop', '商家已接单', 1476811110, 3),
(211, 65, 'shop', '商家自己开始配送', 1476811130, 3),
(212, 65, 'shop', '订单已送达', 1476811141, 5),
(213, 65, 'member', '用户确认订单完成', 1476811174, 6),
(214, 66, 'member', '订单已提交成功', 1476811231, 1),
(215, 66, 'payment', '订单支付成功', 1476811241, 2),
(216, 66, 'shop', '商家已接单', 1476811256, 3),
(217, 66, 'staff', '配送员(吴志新)准备为您配送', 1476811281, 2),
(218, 66, 'staff', '配送员(吴志新)开始为您配送', 1476811287, 4),
(219, 66, 'staff', '配送员(吴志新)已经为您送达', 1476811290, 5),
(220, 66, 'member', '用户确认订单完成', 1476811330, 6),
(221, 67, 'member', '订单已提交成功', 1476811405, 1),
(222, 67, 'payment', '订单支付成功', 1476811415, 2),
(223, 67, 'shop', '商家已接单', 1476811427, 3),
(224, 67, 'shop', '商家自己开始配送', 1476811431, 3),
(225, 67, 'shop', '订单已送达', 1476818224, 5),
(226, 68, 'member', '订单已提交成功', 1476942734, 1),
(227, 68, 'payment', '订单支付成功', 1476942760, 2),
(228, 68, 'shop', '商家已接单', 1476942796, 3),
(229, 68, 'staff', '配送员(吴志新)准备为您配送', 1476942803, 2),
(230, 68, 'staff', '配送员(吴志新)开始为您配送', 1476942821, 4),
(231, 68, 'staff', '配送员(吴志新)已经为您送达', 1476942824, 5),
(232, 69, 'member', '订单已提交成功', 1476944198, 1),
(233, 69, 'member', '订单使用余额支付成功', 1476944207, 2),
(234, 69, 'shop', '商家已接单', 1476944236, 3),
(235, 69, 'shop', '商家自己开始配送', 1476944272, 3),
(236, 69, 'shop', '订单已送达', 1476944292, 5),
(237, 61, 'member', '用户取消订单(ID:61)', 1476944345, -1),
(238, 39, 'member', '用户取消订单(ID:39)', 1476944355, -1),
(239, 52, 'member', '用户取消订单(ID:52)', 1476944371, -1),
(240, 50, 'member', '用户确认订单完成', 1476944387, 6),
(241, 48, 'member', '用户确认订单完成', 1476944403, 6),
(242, 60, 'member', '用户确认订单完成', 1476944479, 6),
(243, 69, 'member', '用户确认订单完成', 1476944594, 6),
(244, 67, 'member', '用户确认订单完成', 1476944598, 6),
(245, 55, 'member', '用户确认订单完成', 1476944603, 6),
(246, 35, 'member', '用户取消订单(ID:35)', 1476944605, -1),
(247, 32, 'member', '用户取消订单(ID:32)', 1476944611, -1),
(248, 30, 'member', '用户取消订单(ID:30)', 1476944621, -1),
(249, 38, 'member', '用户取消订单(ID:38)', 1476944631, -1),
(250, 57, 'member', '用户取消订单(ID:57)', 1476944637, -1),
(251, 68, 'member', '用户确认订单完成', 1476944642, 6),
(252, 70, 'member', '订单已提交成功', 1476947588, 1),
(253, 70, 'payment', '订单支付成功', 1476947599, 2),
(254, 70, 'shop', '商家已接单', 1476947618, 3),
(255, 70, 'staff', '配送员(吴志新)准备为您配送', 1476947662, 2),
(256, 70, 'staff', '配送员(吴志新)开始为您配送', 1476947687, 4),
(257, 70, 'staff', '配送员(吴志新)已经为您送达', 1476947708, 5),
(258, 71, 'member', '订单已提交成功', 1476947839, 1),
(259, 71, 'payment', '订单支付成功', 1476947848, 2),
(260, 71, 'shop', '商家已接单', 1476947859, 3),
(261, 71, 'shop', '商家开始配送', 1476947883, 4),
(262, 71, 'shop', '订单已送达', 1476947925, 5),
(263, 72, 'member', '订单已提交', 1476948466, 1),
(264, 73, 'member', '订单已提交', 1476955572, 1),
(265, 72, 'member', '用户取消订单(ID:72)', 1476955604, -1),
(266, 74, 'member', '订单已提交', 1476957766, 1),
(267, 74, 'member', '用户取消订单(ID:74)', 1476963032, -1),
(268, 73, 'member', '用户取消订单(ID:73)', 1476963047, -1),
(269, 70, 'member', '用户确认订单完成', 1476963220, 6),
(270, 75, 'member', '订单已提交成功', 1477015525, 1),
(271, 75, 'payment', '订单支付成功', 1477015540, 2),
(272, 75, 'shop', '商家已接单', 1477015555, 3),
(273, 75, 'shop', '商家开始配送', 1477015597, 4),
(274, 75, 'shop', '订单已送达', 1477015618, 5),
(275, 76, 'member', '订单已提交成功', 1477015705, 1),
(276, 76, 'payment', '订单支付成功', 1477015714, 2),
(277, 76, 'shop', '商家已接单', 1477015726, 3),
(278, 76, 'shop', '商家开始配送', 1477015771, 4),
(279, 76, 'shop', '订单已送达', 1477015778, 5),
(280, 27, '', '订单超时系统取消(ID:27)', 1477032151, -1),
(281, 25, '', '订单超时系统取消(ID:25)', 1477032151, -1),
(282, 76, '', '超过3小时系统自动确认订单完成', 1477032151, 6),
(283, 75, '', '超过3小时系统自动确认订单完成', 1477032151, 6),
(284, 71, '', '超过3小时系统自动确认订单完成', 1477032151, 6),
(285, 77, 'member', '订单已提交成功', 1477051668, 1),
(286, 77, 'member', '用户取消订单(ID:77)', 1477051672, -1),
(287, 78, 'member', '订单已提交成功', 1477051870, 1),
(288, 78, 'payment', '订单支付成功', 1477051878, 2),
(289, 78, 'shop', '商家已接单', 1477051886, 3),
(290, 78, 'shop', '商家开始配送', 1477051889, 4),
(291, 78, 'shop', '订单已送达', 1477051902, 5),
(292, 78, '', '超过3小时系统自动确认订单完成', 1477138399, 6),
(293, 79, 'member', '订单已提交成功', 1477179257, 1),
(294, 79, 'payment', '订单支付成功', 1477179269, 2),
(295, 79, 'shop', '商家已接单', 1477188348, 3),
(296, 79, 'shop', '商家开始配送', 1477188357, 4),
(297, 79, 'shop', '订单已送达', 1477188364, 5),
(298, 79, '', '超过3小时系统自动确认订单完成', 1477200601, 6),
(299, 80, 'member', '订单已提交成功', 1477205028, 1),
(300, 80, 'payment', '订单支付成功', 1477205040, 2),
(301, 80, 'shop', '商家已接单', 1477205050, 3),
(302, 80, 'shop', '商家开始配送', 1477205054, 4),
(303, 80, 'shop', '订单已送达', 1477205059, 5),
(304, 80, '', '超过3小时系统自动确认订单完成', 1477216801, 6),
(305, 81, 'member', '订单已提交成功', 1477277140, 1),
(306, 81, 'payment', '订单支付成功', 1477277148, 2),
(307, 81, 'shop', '商家已接单', 1477277165, 3),
(308, 81, 'shop', '商家开始配送', 1477277169, 4),
(309, 81, 'shop', '订单已送达', 1477277181, 5),
(310, 81, '', '超过3小时系统自动确认订单完成', 1477288801, 6),
(311, 82, 'member', '订单已提交', 1478955552, 1),
(312, 82, '', '订单超时系统取消(ID:82)', 1478957401, -1),
(313, 83, 'member', '订单已提交成功', 1479065087, 1),
(314, 83, 'payment', '订单支付成功', 1479065097, 2),
(315, 83, 'shop', '商家已接单', 1479065143, 3),
(316, 83, 'shop', '商家开始配送', 1479065298, 4),
(317, 83, 'shop', '订单已送达', 1479065315, 5),
(318, 83, '', '超过3小时系统自动确认订单完成', 1479076201, 6),
(319, 84, 'member', '订单已提交成功', 1479105559, 1),
(320, 84, 'payment', '订单支付成功', 1479105568, 2),
(321, 84, 'staff', '配送员(吴志新)准备为您配送', 1479105633, 2),
(322, 84, 'staff', '配送员(吴志新)开始为您配送', 1479105836, 4),
(323, 84, 'staff', '配送员(吴志新)已经为您送达', 1479105840, 5),
(324, 85, 'member', '订单已提交成功', 1479105901, 1),
(325, 85, 'payment', '订单支付成功', 1479105912, 2),
(326, 85, 'member', '用户取消订单(ID:85)', 1479106029, -1),
(327, 84, 'member', '用户确认订单完成', 1479106044, 6),
(328, 86, 'member', '订单已提交成功', 1479106062, 1),
(329, 86, 'payment', '订单支付成功', 1479106071, 2),
(330, 87, 'member', '订单已提交成功', 1479106234, 1),
(331, 87, 'payment', '订单支付成功', 1479106245, 2),
(332, 88, 'member', '订单已提交成功', 1479119788, 1),
(333, 88, 'payment', '订单支付成功', 1479119796, 2),
(334, 89, 'member', '订单已提交', 1479119900, 1),
(335, 89, 'payment', '订单支付成功', 1479119910, 2),
(336, 90, 'member', '订单已提交成功', 1479120008, 1),
(337, 91, 'member', '订单已提交成功', 1479120040, 1),
(338, 91, 'payment', '订单支付成功', 1479120048, 2),
(339, 86, 'staff', '配送员(吴志新)准备为您配送', 1479120106, 2),
(340, 87, 'staff', '配送员(吴志新)准备为您配送', 1479120110, 2),
(341, 92, 'member', '订单已提交成功', 1479120365, 1),
(342, 92, 'payment', '订单支付成功', 1479120376, 2),
(343, 90, '', '订单超时系统取消(ID:90)', 1479121201, -1),
(344, 93, 'member', '订单已提交成功', 1479122536, 1),
(345, 93, 'payment', '订单支付成功', 1479122549, 2),
(346, 93, 'staff', '配送员(吴志新)准备为您配送', 1479122624, 2),
(347, 92, 'staff', '配送员(吴志新)准备为您配送', 1479122628, 2),
(348, 94, 'member', '订单已提交成功', 1479122716, 1),
(349, 94, 'payment', '订单支付成功', 1479122727, 2),
(350, 95, 'member', '订单已提交成功', 1479122916, 1),
(351, 95, 'payment', '订单支付成功', 1479122923, 2),
(352, 95, 'staff', '配送员(吴志新)准备为您配送', 1479123364, 2),
(353, 95, 'staff', '配送员(吴志新)开始为您配送', 1479123377, 4),
(354, 95, 'staff', '配送员(吴志新)已经为您送达', 1479123404, 5),
(355, 95, '', '超过3小时系统自动确认订单完成', 1479135601, 6),
(356, 96, 'member', '订单已提交成功', 1479144327, 1),
(357, 96, 'payment', '订单支付成功', 1479144335, 2),
(358, 97, 'member', '订单已提交成功', 1479144568, 1),
(359, 97, 'payment', '订单支付成功', 1479144576, 2),
(360, 97, 'staff', '配送员(吴志新)准备为您配送', 1479144655, 2),
(361, 98, 'member', '订单已提交成功', 1479144699, 1),
(362, 98, 'payment', '订单支付成功', 1479144707, 2),
(363, 99, 'member', '订单已提交成功', 1479485237, 1),
(364, 99, '', '订单超时系统取消(ID:99)', 1479486601, -1),
(365, 100, 'member', '订单已提交', 1479687636, 1),
(366, 101, 'member', '订单已提交成功', 1480247627, 1),
(367, 102, 'member', '订单已提交', 1480247736, 1),
(368, 102, '', '订单超时系统取消(ID:102)', 1480249801, -1),
(369, 101, '', '订单超时系统取消(ID:101)', 1480249801, -1),
(370, 100, 'admin', '管理员取消订单(ID:100)', 1480316720, -1),
(371, 103, 'member', '订单已提交', 1480766004, 1),
(372, 103, '', '订单超时系统取消(ID:103)', 1480768201, -1),
(373, 104, 'member', '订单已提交', 1481017048, 1),
(374, 105, 'member', '订单已提交', 1481017180, 1),
(375, 106, 'member', '订单已提交', 1481017373, 1),
(376, 107, 'member', '订单已提交', 1481017465, 1),
(377, 107, '', '订单超时系统取消(ID:107)', 1481018401, -1),
(378, 106, '', '订单超时系统取消(ID:106)', 1481018401, -1),
(379, 105, '', '订单超时系统取消(ID:105)', 1481018401, -1),
(380, 104, '', '订单超时系统取消(ID:104)', 1481018401, -1),
(381, 108, 'member', '订单已提交', 1481079319, 1),
(382, 108, '', '订单超时系统取消(ID:108)', 1481081401, -1),
(383, 109, 'member', '订单已提交', 1481090590, 1),
(384, 109, 'payment', '订单支付成功', 1481090604, 2),
(385, 109, 'admin', '管理员取消订单(ID:109)', 1481111537, -1);

-- --------------------------------------------------------

--
-- 表的结构 `jh_order_product`
--

CREATE TABLE IF NOT EXISTS `jh_order_product` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) DEFAULT '0',
  `product_id` int(10) DEFAULT '0',
  `product_name` varchar(150) DEFAULT '',
  `product_price` decimal(8,2) DEFAULT NULL,
  `package_price` decimal(6,2) DEFAULT '0.00',
  `product_number` smallint(6) DEFAULT '0',
  `amount` decimal(8,2) DEFAULT '0.00',
  PRIMARY KEY (`pid`),
  KEY `order_id` (`order_id`,`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=112 ;

--
-- 转存表中的数据 `jh_order_product`
--

INSERT INTO `jh_order_product` (`pid`, `order_id`, `product_id`, `product_name`, `product_price`, `package_price`, `product_number`, `amount`) VALUES
(1, 1, 4, '水煮肉片', '28.00', '1.00', 1, '29.00'),
(2, 1, 3, '干锅土豆片', '18.00', '1.00', 1, '19.00'),
(3, 2, 3, '干锅土豆片', '18.00', '1.00', 2, '38.00'),
(4, 3, 3, '干锅土豆片', '18.00', '1.00', 2, '38.00'),
(5, 4, 2, '番茄蛋汤', '10.00', '1.00', 2, '22.00'),
(6, 5, 3, '干锅土豆片', '18.00', '1.00', 2, '38.00'),
(7, 6, 3, '干锅土豆片', '18.00', '1.00', 2, '38.00'),
(8, 7, 3, '干锅土豆片', '18.00', '1.00', 2, '38.00'),
(9, 8, 3, '干锅土豆片', '18.00', '1.00', 1, '19.00'),
(10, 8, 1, '酸菜草鱼', '26.00', '1.00', 2, '54.00'),
(11, 9, 3, '干锅土豆片', '18.00', '1.00', 2, '38.00'),
(12, 10, 7, '一分', '0.01', '0.00', 1, '0.01'),
(13, 11, 7, '一分', '0.01', '0.00', 1, '0.01'),
(14, 12, 7, '一分', '0.01', '0.00', 1, '0.01'),
(15, 13, 7, '一分', '0.01', '0.00', 1, '0.01'),
(16, 14, 7, '一分', '0.01', '0.00', 1, '0.01'),
(17, 15, 7, '一分', '0.01', '0.00', 1, '0.01'),
(18, 16, 7, '一分', '0.01', '0.00', 1, '0.01'),
(19, 17, 7, '一分', '0.01', '0.00', 1, '0.01'),
(20, 18, 7, '一分', '0.01', '0.00', 1, '0.01'),
(21, 19, 7, '一分', '0.01', '0.00', 1, '0.01'),
(22, 20, 7, '一分', '0.01', '0.00', 1, '0.01'),
(23, 21, 7, '一分', '0.01', '0.00', 99, '0.99'),
(24, 22, 7, '一分', '0.01', '0.00', 1, '0.01'),
(25, 23, 7, '一分', '0.01', '0.00', 1, '0.01'),
(26, 24, 7, '一分', '0.01', '0.00', 1, '0.01'),
(27, 25, 7, '一分', '0.01', '0.00', 1, '0.01'),
(28, 26, 7, '一分', '0.01', '0.00', 1, '0.01'),
(29, 27, 7, '一分', '0.01', '0.00', 1, '0.01'),
(30, 28, 7, '一分', '0.01', '0.00', 1, '0.01'),
(31, 29, 7, '一分', '0.01', '0.00', 1, '0.01'),
(32, 30, 7, '一分', '0.01', '0.00', 1, '0.01'),
(33, 31, 7, '一分', '0.01', '0.00', 1, '0.01'),
(34, 32, 7, '一分', '0.01', '0.00', 1, '0.01'),
(35, 33, 7, '一分', '0.01', '0.00', 1, '0.01'),
(36, 34, 7, '一分', '0.01', '0.00', 1, '0.01'),
(37, 35, 7, '一分', '0.01', '0.00', 1, '0.01'),
(38, 36, 7, '一分', '1.00', '0.00', 1, '1.00'),
(39, 37, 8, '一份', '0.01', '0.00', 1, '0.01'),
(40, 38, 8, '一份', '0.01', '0.00', 1, '0.01'),
(41, 39, 8, '一份', '0.01', '0.00', 1, '0.01'),
(42, 40, 8, '一份', '0.01', '0.00', 1, '0.01'),
(43, 41, 8, '一份', '0.01', '0.00', 1, '0.01'),
(44, 42, 7, '一分', '1.00', '0.00', 1, '1.00'),
(45, 43, 8, '一份', '0.01', '0.00', 1, '0.01'),
(46, 44, 7, '一分', '1.00', '0.00', 1, '1.00'),
(47, 45, 8, '一份', '0.01', '0.00', 1, '0.01'),
(48, 46, 7, '一分', '1.00', '0.00', 1, '1.00'),
(49, 47, 8, '一份', '0.01', '0.00', 1, '0.01'),
(50, 48, 8, '一份', '0.01', '0.00', 1, '0.01'),
(51, 49, 8, '一份', '0.01', '0.00', 1, '0.01'),
(52, 50, 8, '一份', '0.01', '0.00', 1, '0.01'),
(53, 51, 7, '一分', '1.00', '0.00', 1, '1.00'),
(54, 52, 8, '一份', '0.01', '0.00', 2, '0.02'),
(55, 53, 8, '一份', '0.01', '0.00', 1, '0.01'),
(56, 54, 8, '一份', '0.01', '0.00', 1, '0.01'),
(57, 55, 8, '一份', '0.01', '0.00', 1, '0.01'),
(58, 56, 8, '一份', '0.01', '0.00', 1, '0.01'),
(59, 57, 8, '一份', '0.01', '0.00', 1, '0.01'),
(60, 58, 8, '一份', '0.01', '0.00', 1, '0.01'),
(61, 59, 8, '一份', '0.01', '0.00', 1, '0.01'),
(62, 60, 8, '一份', '0.01', '0.00', 1, '0.01'),
(63, 61, 8, '一份', '0.01', '0.00', 1, '0.01'),
(64, 62, 8, '一份', '0.01', '0.00', 2, '0.02'),
(65, 63, 8, '一份', '0.01', '0.00', 1, '0.01'),
(66, 64, 8, '一份', '0.01', '0.00', 1, '0.01'),
(67, 65, 8, '一份', '0.01', '0.00', 1, '0.01'),
(68, 66, 8, '一份', '0.01', '0.00', 1, '0.01'),
(69, 67, 8, '一份', '0.01', '0.00', 1, '0.01'),
(70, 68, 8, '一份', '0.01', '0.00', 1, '0.01'),
(71, 69, 8, '一份', '0.01', '0.00', 1, '0.01'),
(72, 70, 8, '一份', '0.01', '0.00', 1, '0.01'),
(73, 71, 8, '一份', '0.01', '0.00', 1, '0.01'),
(74, 72, 8, '一份', '0.01', '0.00', 1, '0.01'),
(75, 73, 8, '一份', '0.01', '0.00', 2, '0.02'),
(76, 74, 8, '一份', '0.01', '0.00', 1, '0.01'),
(77, 75, 8, '一份', '0.01', '0.00', 1, '0.01'),
(78, 76, 8, '一份', '0.01', '0.00', 1, '0.01'),
(79, 77, 8, '一份', '0.01', '0.00', 1, '0.01'),
(80, 78, 8, '一份', '0.01', '0.00', 1, '0.01'),
(81, 79, 8, '一份', '0.01', '0.00', 1, '0.01'),
(82, 80, 8, '一份', '0.01', '0.00', 1, '0.01'),
(83, 81, 8, '一份', '0.01', '0.00', 2, '0.02'),
(84, 82, 8, '一份', '0.01', '0.00', 2, '0.02'),
(85, 83, 8, '一份', '0.01', '0.00', 1, '0.01'),
(86, 84, 8, '一份', '0.01', '0.00', 1, '0.01'),
(87, 85, 8, '一份', '0.01', '0.00', 1, '0.01'),
(88, 86, 8, '一份', '0.01', '0.00', 2, '0.02'),
(89, 87, 8, '一份', '0.01', '0.00', 1, '0.01'),
(90, 88, 8, '一份', '0.01', '0.00', 1, '0.01'),
(91, 89, 8, '一份', '0.01', '0.00', 1, '0.01'),
(92, 90, 8, '一份', '0.01', '0.00', 1, '0.01'),
(93, 91, 8, '一份', '0.01', '0.00', 1, '0.01'),
(94, 92, 8, '一份', '0.01', '0.00', 2, '0.02'),
(95, 93, 8, '一份', '0.01', '0.00', 2, '0.02'),
(96, 94, 8, '一份', '0.01', '0.00', 3, '0.03'),
(97, 95, 8, '一份', '0.01', '0.00', 5, '0.05'),
(98, 96, 8, '一份', '0.01', '0.00', 2, '0.02'),
(99, 97, 8, '一份', '0.01', '0.00', 2, '0.02'),
(100, 98, 8, '一份', '0.01', '0.00', 2, '0.02'),
(101, 99, 3, '干锅土豆片', '18.00', '1.00', 1, '19.00'),
(102, 100, 3, '干锅土豆片', '18.00', '1.00', 4, '76.00'),
(103, 101, 3, '干锅土豆片', '18.00', '1.00', 1, '19.00'),
(104, 102, 3, '干锅土豆片', '18.00', '1.00', 1, '19.00'),
(105, 103, 3, '干锅土豆片', '18.00', '1.00', 1, '19.00'),
(106, 104, 10, 'asdf', '5.00', '0.00', 1, '5.00'),
(107, 105, 10, 'asdf', '5.00', '0.00', 2, '10.00'),
(108, 106, 10, 'asdf', '5.00', '0.00', 1, '5.00'),
(109, 107, 10, 'asdf', '5.00', '0.00', 1, '5.00'),
(110, 108, 3, '干锅土豆片', '18.00', '1.00', 1, '19.00'),
(111, 109, 3, '干锅土豆片', '18.00', '1.00', 1, '19.00');

-- --------------------------------------------------------

--
-- 表的结构 `jh_paotui`
--

CREATE TABLE IF NOT EXISTS `jh_paotui` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `jh_paotui`
--

INSERT INTO `jh_paotui` (`paotui_id`, `uid`, `addr`, `house`, `contact`, `mobile`, `lat`, `lng`, `time`, `o_addr`, `o_house`, `o_contact`, `o_mobile`, `o_lng`, `o_lat`, `o_time`, `intro`, `photo`, `voice`, `voice_time`, `paotui_amount`, `danbao_amount`, `jiesuan_amount`, `type`, `staff_id`, `order_status`, `pay_status`, `pay_time`, `pay_code`, `pay_ip`, `day`, `clientip`, `dateline`) VALUES
(1, 1, '尚东区花园54号', 'r', 'r', '45', '31.785594', '119.984394', 1476637260, '尚东区花园54号', '2', '而', '122', '119.984394', '31.785594', 1476640920, 'rt', '', '', 3, '8.00', '0.00', '0.00', 'song', 1, 8, 1, 0, '', '', 20161016, '202.112.25.14', 1476607020),
(2, 1, '竹林路尚东区商铺62号(红星美凯龙旁)', '35', '而', '#$5', '31.785801', '119.984841', 1476550920, '尚东区花园54号', '', '', '', '119.984394', '31.785594', 0, '刚刚', '', '', 0, '8.00', '11.00', '0.00', 'buy', 0, -1, 0, 0, '', '', 20161016, '202.112.25.14', 1476633250),
(3, 2, '华阳路与望江西路交叉口东150米', '908', '恩呀', '13888888888', '31.830106', '117.249489', 1476975600, '', '', '', '', '0', '0', 0, '测试', '', '', 0, '8.00', '10.00', '0.00', 'buy', 2, 1, 1, 1476932770, 'money', '60.166.196.49', 20161020, '60.166.198.181', 1476932741),
(4, 2, '三里庵街道梅山路18号安徽饭店商圈内东侧', '321', '阿鲁', '13666666666', '31.849904', '117.27179', 1476972000, '华阳路与望江西路交叉口东150米', '369', '佛祖', '13888888888', '117.249489', '31.830106', 1477058400, '没啥', '', '', 0, '10.00', '0.00', '0.00', 'song', 1, 3, 1, 1476932890, 'money', '60.166.198.181', 20161020, '60.166.198.181', 1476932881),
(5, 1, '常州翠竹新村', '翠竹新小区', '无支持', '13771334970', '31.793649', '119.98982', 1478239200, '江苏凌家塘物流有限公司(江凌路)', '邹区镇新312国道', '刘志军', '13771331940', '119.863694', '31.779899', 1478235600, '凤凰', '', '', 0, '20.00', '0.00', '0.00', 'song', 0, 0, 0, 0, '', '', 20161104, '202.112.25.13', 1478192456),
(6, 1, '新城尚东区花园西区', '1417', '吴志新', '13771331940', '31.785365', '119.984917', 1478253600, '', '', '', '', '', '', 0, '一个', '', '', 0, '62.00', '0.00', '0.00', 'buy', 0, 0, 0, 0, '', '', 20161104, '202.112.25.13', 1478192616),
(7, 1, '北环路东侧、竹林北路北侧', '新城尚东区花园', 'Cv', '456', '31.791846', '119.993467', 1478239200, '新城尚东区花园西区', '1417', '无', '45', '119.984917', '31.785365', 1478235600, '风云', '', '', 0, '12.00', '0.00', '0.00', 'song', 0, 0, 0, 0, '', '', 20161104, '202.112.25.13', 1478192688),
(8, 1, '北环路东侧、竹林北路北侧', '新城尚东区花园', '23', '故', '31.791846', '119.993467', 1478304000, '新城尚东区花园西区', '1417', '无', '45', '119.984917', '31.785365', 1478484000, '规划', '', '', 0, '12.00', '0.00', '0.00', 'song', 0, 0, 0, 0, '', '', 20161104, '202.112.25.13', 1478192825);

-- --------------------------------------------------------

--
-- 表的结构 `jh_paotui_log`
--

CREATE TABLE IF NOT EXISTS `jh_paotui_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `paotui_id` int(10) DEFAULT '0',
  `log` varchar(255) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  `from` enum('admin','staff','member') DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `jh_paotui_log`
--

INSERT INTO `jh_paotui_log` (`log_id`, `paotui_id`, `log`, `dateline`, `from`, `type`) VALUES
(1, 1, '订单已提交', 1476607020, 'member', 1),
(2, 1, '订单支付成功', 1476607035, '', 2),
(3, 2, '订单已提交', 1476633250, 'member', 1),
(4, 2, '用户取消跑腿订单(ID:2)', 1476634064, 'member', -1),
(5, 3, '订单已提交', 1476932741, 'member', 1),
(6, 3, '订单使用余额支付成功', 1476932770, 'member', 2),
(7, 4, '订单已提交', 1476932881, 'member', 1),
(8, 4, '订单使用余额支付成功', 1476932890, 'member', 2),
(9, 5, '订单已提交', 1478192456, 'member', 1),
(10, 6, '订单已提交', 1478192616, 'member', 1),
(11, 7, '订单已提交', 1478192688, 'member', 1),
(12, 8, '订单已提交', 1478192825, 'member', 1);

-- --------------------------------------------------------

--
-- 表的结构 `jh_payment`
--

CREATE TABLE IF NOT EXISTS `jh_payment` (
  `payment_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `payment` varchar(20) DEFAULT '',
  `title` varchar(100) DEFAULT '',
  `logo` varchar(150) DEFAULT '',
  `config` mediumtext,
  `status` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `jh_payment`
--

INSERT INTO `jh_payment` (`payment_id`, `payment`, `title`, `logo`, `config`, `status`, `dateline`) VALUES
(1, 'alipay', '支付宝', 'photo/201612/20161206_8F8FEC58D1571263566E9381F6244831.png', 'a:6:{s:14:"alipay_service";s:25:"create_direct_pay_by_user";s:14:"alipay_account";s:20:"kulesongmail@163.com";s:14:"alipay_partner";s:14:"20885213092378";s:10:"alipay_key";s:32:"z2zn5jifeyxxs1lqsl4ax06n0dwd5rtn";s:18:"alipay_rsa_private";s:824:"MIICWwIBAAKBgQCYVDzS9QgqKn/xzmR6htypxiW4cA/8EnG6vBKpwL7KPxY6kuUE yLbAuLGu85Jhdhgv8RnHs/hy7ODOvrKsfV29rbim/b8Y9iVwwUnGsDNwpRqJgwTr 6K596oAPFdkVRKUDxCjwNSrrMfJHq8rtaGe0dCD1dP2FNnrko37v3ffNpwIDAQAB AoGAJY3W9Pc9zQ9vPZDxipeG/UABeqf9+NofObc2Lq17G+dTtpsSZQyKqZafD4+z Dd4Mdn1NKsO+w66MecvfxtCddE1m3lBEAf7V3QGR6ARSLEw08FN2OeWCKEcQ7AJ3 pw7WxJlxcpbZAZGmgFZUrcUgrRovEA+YY3hdS/zztd9plkkCQQDIw+tkeMkKYDj5 H5TvUNrgEptIvoSjvxRV6IKVtNkfOJPIya3v9k2/jw8lEG3BYvdQFkwdQjla2Bur freDQE27AkEAwjzovNcsr2u7A+ZrAxCOWTB770o7anRFrFb7Lypf0f0zsK4l85S4 qEYRK8/3ZH8B5HR3pNLvcNTlS3l/NYnLBQJAAnTzUn1v6GKZD+NlDTCuHQPdRpye Puq9svdvcamO5qTomhJtwHwBI5D6nHeBAFbXs/Ex6UHANe5jGEwqrr6AtQJANAL1 W2PO/mY9nMy9iQOM6osWFLxu7pGV+pEMD9Qr9mHzznLDjNcdH0or3OyCVXHBAvjA 9Oza2v7XK3+sNZzhNQJAcxHNPPBDalH8BaWfJimpkAIddGLm0A01wyqNZi9+QcQl XwXTViH+Cp7d5iXtCIpRM7xZbyS2YAwsx19vXfYfoA==";s:17:"alipay_rsa_public";s:219:"MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCYVDzS9QgqKn/xzmR6htypxiW4 cA/8EnG6vBKpwL7KPxY6kuUEyLbAuLGu85Jhdhgv8RnHs/hy7ODOvrKsfV29rbim /b8Y9iVwwUnGsDNwpRqJgwTr6K596oAPFdkVRKUDxCjwNSrrMfJHq8rtaGe0dCD1 dP2FNnrko37v3ffNpwIDAQAB";}', 1, 1475133895),
(2, 'wxpay', '微信支付', 'photo/201610/20161011_87DAEC97B609B73A7554506A2E3158A6.png', 'a:8:{s:5:"appid";s:18:"wx94a875308fdd52f1";s:9:"appsecret";s:32:"1d33e84c9c9ec5b3293aafe3509d3c99";s:6:"mch_id";s:11:"13922444021";s:3:"key";s:32:"55eafb8dcd095b0e022709d7f2a684cc";s:9:"app_appid";s:18:"wx9f5942cca34d37d2";s:13:"app_appsecret";s:32:"9871c6ead36073ba9aa0e989efd61a97";s:10:"app_mch_id";s:10:"1396654002";s:7:"app_key";s:32:"55eafb8dcd095b0e022709d7f2a684cc";}', 1, 1476149227),
(3, 'money', '余额支付', '', NULL, 1, 1476864712);

-- --------------------------------------------------------

--
-- 表的结构 `jh_payment_log`
--

CREATE TABLE IF NOT EXISTS `jh_payment_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) DEFAULT '0',
  `from` enum('money','order','paotui') DEFAULT NULL,
  `payment` varchar(20) DEFAULT '',
  `trade_no` int(10) DEFAULT '0',
  `order_id` int(10) DEFAULT '0',
  `pay_level` tinyint(1) DEFAULT '0',
  `amount` decimal(10,2) DEFAULT '0.00',
  `payed` tinyint(1) DEFAULT '0',
  `payedip` varchar(15) DEFAULT '',
  `payedtime` int(10) DEFAULT '0',
  `pay_trade_no` varchar(50) DEFAULT '',
  `extra_pay` varchar(200) DEFAULT '',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`log_id`),
  KEY `trade_no` (`trade_no`),
  KEY `uid` (`uid`),
  KEY `from` (`from`,`payed`),
  KEY `order_id` (`order_id`,`pay_level`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=93 ;

--
-- 转存表中的数据 `jh_payment_log`
--

INSERT INTO `jh_payment_log` (`log_id`, `uid`, `from`, `payment`, `trade_no`, `order_id`, `pay_level`, `amount`, `payed`, `payedip`, `payedtime`, `pay_trade_no`, `extra_pay`, `clientip`, `dateline`) VALUES
(1, 1, 'order', 'alipay', 1610064681, 3, 0, '45.00', 0, '', 0, '', '', '112.81.190.186', 1475741327),
(2, 1, 'order', 'alipay', 1610072300, 4, 0, '29.00', 0, '', 0, '', '', '202.112.25.30', 1475853428),
(3, 1, 'order', 'alipay', 1610085730, 5, 0, '45.00', 0, '', 0, '', '', '202.112.25.30', 1475936684),
(4, 1, 'order', 'alipay', 1610098124, 7, 0, '45.00', 0, '', 0, '', '', '202.112.25.30', 1475942901),
(5, 1, 'order', 'alipay', 1610092727, 8, 0, '80.00', 0, '', 0, '', '', '202.112.25.30', 1475943135),
(6, 1, 'order', 'alipay', 1610094971, 9, 0, '37.00', 0, '', 0, '', '', '202.112.25.30', 1475944951),
(7, 1, 'order', 'wxpay', 1610111486, 10, 0, '0.01', 1, '101.226.103.70', 1476158523, '', '', '202.112.25.16', 1476158506),
(8, 1, 'order', 'alipay', 1610118292, 11, 0, '0.01', 0, '', 0, '', '', '202.112.25.16', 1476158581),
(9, 1, 'order', 'wxpay', 1610111741, 12, 0, '0.01', 0, '', 0, '', '', '202.112.25.16', 1476158642),
(10, 1, 'order', 'wxpay', 1610118602, 13, 0, '0.01', 0, '', 0, '', '', '202.112.25.16', 1476158743),
(11, 1, 'order', 'wxpay', 1610114471, 14, 0, '0.01', 0, '', 0, '', '', '202.112.25.16', 1476158771),
(12, 1, 'money', 'alipay', 1610117635, 0, 0, '1.00', 0, '', 0, '', '', '202.112.25.16', 1476159197),
(13, 1, 'order', 'wxpay', 1610114757, 15, 0, '0.01', 0, '', 0, '', '', '202.112.25.16', 1476159302),
(14, 1, 'money', 'alipay', 1610119398, 0, 0, '1.00', 0, '', 0, '', '', '202.112.25.16', 1476159398),
(15, 1, 'money', 'alipay', 1610116297, 0, 0, '1.00', 0, '', 0, '', '', '202.112.25.16', 1476159412),
(16, 1, 'money', 'wxpay', 1610111975, 0, 0, '1.00', 0, '', 0, '', '', '202.112.25.16', 1476159421),
(17, 1, 'money', 'wxpay', 1610118979, 0, 0, '5000.00', 0, '', 0, '', '', '202.112.25.16', 1476159458),
(18, 1, 'money', 'alipay', 1610115156, 0, 0, '5000.00', 0, '', 0, '', '', '202.112.25.16', 1476159497),
(19, 1, 'order', 'wxpay', 1610119610, 16, 0, '0.01', 0, '', 0, '', '', '202.112.25.16', 1476159563),
(20, 1, 'order', 'wxpay', 1610117929, 17, 0, '0.01', 0, '', 0, '', '', '202.112.25.16', 1476160270),
(21, 1, 'order', 'wxpay', 1610117972, 18, 0, '0.01', 1, '101.226.103.62', 1476196207, '', '', '202.112.25.17', 1476195887),
(22, 1, 'order', 'wxpay', 1610115029, 19, 0, '0.01', 1, '101.226.103.70', 1476196437, '', '', '202.112.25.17', 1476196430),
(23, 1, 'order', 'wxpay', 1610114095, 20, 0, '0.01', 1, '140.207.54.75', 1476196520, '', '', '202.112.25.17', 1476196513),
(24, 1, 'order', 'wxpay', 1610111664, 21, 0, '0.99', 1, '140.207.54.76', 1476198460, '', '', '202.112.25.17', 1476198454),
(25, 1, 'order', 'wxpay', 1610122366, 23, 0, '0.01', 1, '140.207.54.73', 1476232804, '', '', '202.112.25.17', 1476232769),
(26, 1, 'order', 'wxpay', 1610129427, 24, 0, '0.01', 1, '140.207.54.75', 1476238703, '', '', '202.112.25.17', 1476238697),
(27, 4, 'order', 'alipay', 1610125442, 25, 0, '-4.99', 0, '', 0, '', '', '49.80.137.143', 1476262741),
(28, 1, 'order', 'wxpay', 1610124974, 26, 0, '0.01', 1, '101.226.103.69', 1476262844, '', '', '202.112.25.13', 1476262837),
(29, 4, 'order', 'alipay', 1610128257, 27, 0, '0.01', 0, '', 0, '', '', '49.80.137.143', 1476263000),
(30, 4, 'order', 'wxpay', 1610125686, 28, 0, '0.01', 1, '140.207.54.75', 1476263140, '', '', '49.80.137.143', 1476263132),
(31, 1, 'order', 'alipay', 1610120416, 30, 0, '0.01', 0, '', 0, '', '', '202.112.25.13', 1476264200),
(32, 1, 'order', 'alipay', 1610120477, 31, 0, '0.01', 0, '', 0, '', '', '202.112.25.13', 1476264891),
(33, 1, 'order', 'alipay', 1610124755, 32, 0, '0.01', 0, '', 0, '', '', '202.112.25.13', 1476267048),
(34, 1, 'order', 'wxpay', 1610124208, 33, 0, '0.01', 1, '140.207.54.74', 1476275963, '', '', '202.112.25.13', 1476275955),
(35, 1, 'order', 'wxpay', 1610132368, 36, 0, '1.00', 1, '140.207.54.76', 1476368855, '', '', '202.112.25.9', 1476368847),
(36, 1, 'order', 'alipay', 1610149501, 37, 0, '0.01', 0, '', 0, '', '', '202.112.25.9', 1476384394),
(37, 1, 'order', 'alipay', 1610148375, 38, 0, '0.01', 0, '', 0, '', '', '202.112.25.9', 1476384519),
(38, 1, 'order', 'alipay', 1610146709, 39, 0, '0.01', 0, '', 0, '', '', '202.112.25.9', 1476384561),
(39, 1, 'order', 'alipay', 1610142063, 40, 0, '0.01', 0, '', 0, '', '', '202.112.25.9', 1476385067),
(40, 6, 'order', 'alipay', 1610143249, 43, 0, '0.01', 1, '114.226.182.11', 1476429598, '', '', '114.226.182.11', 1476429559),
(41, 1, 'order', 'wxpay', 1610144871, 44, 0, '1.00', 1, '140.207.54.74', 1476456836, '', '', '202.112.25.25', 1476456829),
(42, 1, 'order', 'wxpay', 1610156528, 45, 0, '0.01', 1, '101.226.103.62', 1476523091, '', '', '202.112.25.7', 1476523083),
(43, 1, 'order', 'wxpay', 1610158041, 46, 0, '1.00', 1, '101.226.103.62', 1476524111, '', '', '202.112.25.7', 1476524103),
(44, 1, 'order', 'wxpay', 1610164402, 47, 0, '0.01', 1, '140.207.54.75', 1476552951, '', '', '202.112.25.22', 1476552945),
(45, 1, 'order', 'wxpay', 1610166758, 48, 0, '0.01', 1, '101.226.103.70', 1476554592, '', '', '202.112.25.22', 1476554585),
(46, 1, 'order', 'wxpay', 1610166235, 50, 0, '0.01', 1, '101.226.103.62', 1476555423, '', '', '202.112.25.22', 1476555413),
(47, 1, 'order', 'wxpay', 1610162013, 51, 0, '2.00', 1, '140.207.54.73', 1476556361, '', '', '202.112.25.22', 1476556356),
(48, 1, 'paotui', 'wxpay', 1610162784, 1, 0, '8.00', 1, '140.207.54.73', 1476607035, '', '', '202.112.25.14', 1476607028),
(49, 1, 'order', 'alipay', 1610170062, 52, 0, '0.03', 0, '', 0, '', '', '202.112.25.14', 1476707282),
(50, 1, 'order', 'wxpay', 1610180268, 55, 0, '0.02', 1, '140.207.54.76', 1476779919, '', '', '202.112.25.7', 1476779911),
(51, 1, 'order', 'alipay', 1610183512, 57, 0, '0.02', 0, '', 0, '', '', '202.112.25.7', 1476790509),
(52, 1, 'order', 'wxpay', 1610186976, 58, 0, '0.02', 1, '101.226.103.69', 1476790629, '', '', '202.112.25.7', 1476790621),
(53, 1, 'order', 'wxpay', 1610182240, 59, 0, '0.02', 1, '140.207.54.76', 1476794409, '', '', '202.112.25.7', 1476794401),
(54, 1, 'order', 'wxpay', 1610180395, 60, 0, '0.02', 1, '140.207.54.75', 1476794554, '', '', '202.112.25.7', 1476794548),
(55, 1, 'order', 'wxpay', 1610183179, 63, 0, '0.02', 0, '', 0, '', '', '202.112.25.7', 1476805571),
(56, 1, 'order', 'wxpay', 1610192495, 64, 0, '0.02', 1, '101.226.103.61', 1476810687, '', '', '202.112.25.7', 1476810676),
(57, 1, 'order', 'wxpay', 1610195360, 65, 0, '0.02', 1, '140.207.54.75', 1476811064, '', '', '202.112.25.7', 1476811057),
(58, 1, 'order', 'wxpay', 1610191707, 66, 0, '0.02', 1, '101.226.103.69', 1476811241, '', '', '202.112.25.7', 1476811234),
(59, 1, 'order', 'wxpay', 1610197374, 67, 0, '0.02', 1, '101.226.103.70', 1476811415, '', '', '202.112.25.7', 1476811408),
(60, 2, 'paotui', 'money', 1610209295, 3, 0, '18.00', 1, '60.166.196.49', 1476932770, '', '', '60.166.198.181', 1476932765),
(61, 2, 'paotui', 'money', 1610201416, 4, 0, '10.00', 1, '60.166.198.181', 1476932890, '', '', '60.166.198.181', 1476932885),
(62, 1, 'order', 'wxpay', 1610206704, 68, 0, '0.02', 1, '140.207.54.75', 1476942760, '', '', '202.112.25.6', 1476942736),
(63, 1, 'order', 'money', 1610201547, 69, 0, '0.02', 1, '202.112.25.6', 1476944207, '', '', '202.112.25.6', 1476944200),
(64, 1, 'order', 'wxpay', 1610201461, 70, 0, '0.02', 1, '140.207.54.73', 1476947599, '', '', '202.112.25.6', 1476947590),
(65, 1, 'order', 'wxpay', 1610207943, 71, 0, '0.02', 1, '101.226.103.69', 1476947848, '', '', '202.112.25.6', 1476947842),
(66, 1, 'order', 'alipay', 1610201775, 74, 0, '0.02', 0, '', 0, '', '', '202.112.25.6', 1476957773),
(67, 1, 'order', 'wxpay', 1610216596, 75, 0, '0.02', 1, '140.207.54.76', 1477015540, '', '', '202.112.25.6', 1477015531),
(68, 1, 'order', 'wxpay', 1610218416, 76, 0, '0.02', 1, '140.207.54.76', 1477015714, '', '', '202.112.25.6', 1477015708),
(69, 1, 'order', 'wxpay', 1610210121, 78, 0, '0.02', 1, '140.207.54.76', 1477051878, '', '', '202.112.25.6', 1477051872),
(70, 1, 'order', 'wxpay', 1610236212, 79, 0, '0.02', 1, '140.207.54.75', 1477179269, '', '', '202.112.25.6', 1477179260),
(71, 1, 'order', 'wxpay', 1610232158, 80, 0, '0.02', 1, '101.226.103.62', 1477205040, '', '', '112.81.145.10', 1477205030),
(72, 1, 'order', 'wxpay', 1610242007, 81, 0, '0.03', 1, '140.207.54.76', 1477277148, '', '', '112.81.254.230', 1477277142),
(73, 1, 'paotui', 'alipay', 1611043175, 6, 0, '62.00', 0, '', 0, '', '', '202.112.25.13', 1478192631),
(74, 1, 'order', 'alipay', 1611125788, 82, 0, '0.03', 0, '', 0, '', '', '202.112.25.20', 1478955559),
(75, 1, 'order', 'wxpay', 1611140558, 83, 0, '0.01', 1, '140.207.54.75', 1479065097, '', '', '202.112.25.12', 1479065090),
(76, 1, 'order', 'wxpay', 1611143124, 84, 0, '0.01', 1, '140.207.54.73', 1479105568, '', '', '117.136.68.115', 1479105561),
(77, 1, 'order', 'wxpay', 1611149035, 85, 0, '0.01', 1, '101.226.103.62', 1479105912, '', '', '117.136.68.115', 1479105905),
(78, 1, 'order', 'wxpay', 1611146279, 86, 0, '0.02', 1, '140.207.54.76', 1479106071, '', '', '117.136.68.115', 1479106064),
(79, 1, 'order', 'wxpay', 1611140667, 87, 0, '0.01', 1, '140.207.54.76', 1479106245, '', '', '117.136.68.115', 1479106238),
(80, 1, 'order', 'wxpay', 1611146831, 88, 0, '0.01', 1, '101.226.103.69', 1479119796, '', '', '202.112.25.23', 1479119790),
(81, 1, 'order', 'wxpay', 1611140649, 89, 0, '0.01', 1, '140.207.54.76', 1479119910, '', '', '202.112.25.23', 1479119903),
(82, 1, 'order', 'alipay', 1611140399, 90, 0, '0.01', 0, '', 0, '', '', '202.112.25.23', 1479120011),
(83, 1, 'order', 'wxpay', 1611145973, 91, 0, '0.01', 1, '101.226.103.61', 1479120048, '', '', '202.112.25.23', 1479120042),
(84, 1, 'order', 'wxpay', 1611149971, 92, 0, '0.02', 1, '101.226.103.62', 1479120376, '', '', '202.112.25.23', 1479120367),
(85, 1, 'order', 'wxpay', 1611141821, 93, 0, '0.02', 1, '140.207.54.76', 1479122549, '', '', '202.112.25.23', 1479122542),
(86, 1, 'order', 'wxpay', 1611146456, 94, 0, '0.03', 1, '140.207.54.76', 1479122727, '', '', '202.112.25.23', 1479122718),
(87, 1, 'order', 'wxpay', 1611149978, 95, 0, '0.05', 1, '140.207.54.76', 1479122923, '', '', '202.112.25.23', 1479122917),
(88, 1, 'order', 'wxpay', 1611156102, 96, 0, '0.02', 1, '140.207.54.75', 1479144335, '', '', '202.112.25.23', 1479144328),
(89, 1, 'order', 'wxpay', 1611159385, 97, 0, '0.02', 1, '101.226.103.62', 1479144576, '', '', '202.112.25.23', 1479144570),
(90, 1, 'order', 'wxpay', 1611152373, 98, 0, '0.02', 1, '140.207.54.73', 1479144707, '', '', '202.112.25.23', 1479144702),
(91, 1, 'order', 'alipay', 1612074089, 108, 0, '19.00', 0, '', 0, '', '', '122.193.190.152', 1481079323),
(92, 1, 'order', 'wxpay', 1612079397, 109, 0, '19.00', 1, '140.207.54.76', 1481090604, '', '', '122.193.190.152', 1481090594);

-- --------------------------------------------------------

--
-- 表的结构 `jh_product`
--

CREATE TABLE IF NOT EXISTS `jh_product` (
  `product_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` mediumint(8) DEFAULT '0',
  `cate_id` int(10) DEFAULT '0',
  `title` varchar(80) DEFAULT '',
  `photo` varchar(150) DEFAULT '',
  `price` decimal(8,2) DEFAULT '0.00',
  `package_price` decimal(6,2) DEFAULT '0.00',
  `sales` mediumint(8) DEFAULT '0',
  `sale_type` tinyint(1) DEFAULT '0',
  `sale_sku` mediumint(8) DEFAULT '0',
  `sale_count` mediumint(8) DEFAULT '0',
  `intro` varchar(1024) DEFAULT '',
  `orderby` smallint(6) DEFAULT '50',
  `closed` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`product_id`),
  KEY `shop_id` (`shop_id`,`cate_id`,`closed`),
  KEY `orderby` (`orderby`,`closed`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `jh_product`
--

INSERT INTO `jh_product` (`product_id`, `shop_id`, `cate_id`, `title`, `photo`, `price`, `package_price`, `sales`, `sale_type`, `sale_sku`, `sale_count`, `intro`, `orderby`, `closed`, `clientip`, `dateline`) VALUES
(1, 1, 1, '酸菜草鱼', 'photo/201609/20160928_EA274ABC73B586ECA04013A44941C0C4.jpeg', '26.00', '1.00', 14, 0, 0, 0, '传说酸菜鱼始于重庆江津的江村渔船。据传，渔夫将捕获的大鱼卖钱，往往将卖剩的小鱼与江边的农家换酸菜吃，渔夫将酸菜和鲜鱼一锅煮汤，想不到这汤的味道还真有些鲜美，于是一些鸡毛小店便将其移植，供应南往北来的食客。酸菜鱼流行于90年代初，在大大小小的餐馆都有其一席之地，重庆的厨师们又把它推向祖国的大江南北，酸菜鱼是重庆菜的开始先锋之一。 酸菜鱼肉质细嫩，汤酸香鲜美，微辣不腻，鱼片嫩黄爽滑。家里如果没有酸菜也不怕，现在市面上都有做酸菜鱼的酸菜包卖，很方便。”', 50, 0, '202.112.25.7', 1475055915),
(2, 1, 1, '番茄蛋汤', 'photo/201609/20160928_23C92C9D685BE5B5A52CE14B33355AC0.jpeg', '10.00', '1.00', 15, 0, 0, 0, '做法新颖、色泽美观、味道鲜美、亦汤亦菜。为家庭主妇必备菜品。', 50, 0, '202.112.25.7', 1475056151),
(3, 1, 1, '干锅土豆片', 'photo/201609/20160928_1BDFF4D16E94C19243F790B189902E9F.jpeg', '18.00', '1.00', 46, 0, 0, 0, '干锅土豆片是一道川渝地区的汉族名菜，主料是土豆和适量的五花肉。稍微炸过的土豆片外焦里嫩。也可根据自己的口味适当添加辣椒等调料。', 50, 0, '202.112.25.7', 1475056290),
(4, 1, 2, '水煮肉片', 'photo/201609/20160928_A85EB96B578D94ECF38397D148B58522.jpeg', '28.00', '1.00', 23, 0, 0, 0, '水煮肉片是一道汉族新创名菜，起源于自贡，发扬于西南，属于川菜中著名的家常菜。', 50, 0, '202.112.25.7', 1475056392),
(5, 1, 1, '剁椒鱼排豆腐', 'photo/201609/20160928_BB5CC5FA9E24F1E574F26DA29D6AD385.jpeg', '13.00', '1.00', 13, 0, 0, 0, '剁椒鱼块，是一道家常菜，制作原料主要有新鲜鱼块、剁椒等。', 50, 0, '202.112.25.7', 1475056475),
(6, 1, 2, '香波咕咾肉', 'photo/201609/20160928_60C75703F9BBF5F9F19407B1579D1EB4.jpeg', '26.00', '1.00', 32, 1, 0, 0, '酸酸甜甜，老少咸宜的一道夏天吃的粤菜。菠萝入菜口感清新还能解腻，酸甜的味道又能增进食欲，无论作为水果还是菜肴，都非常美味。', 50, 0, '202.112.25.7', 1475056546),
(7, 1, 1, '一分', 'default/product.png', '1.00', '0.00', 131, 0, 0, 0, '测试', 10, 1, '202.112.25.16', 1476158374),
(8, 1, 1, '一份', 'photo/201610/20161014_6954F356D07B9E4B5E4B212E6613D19A.png', '0.01', '0.00', 75, 0, 0, 0, '', 2, 1, '202.112.25.9', 1476384342),
(9, 1, 0, '一分钱', 'photo/201612/20161206_14F93F5CC993E7AD9FD11899A5724721.png', '0.01', '0.00', 0, 0, 0, 0, '', 0, 0, '122.193.190.152', 1481003246),
(10, 2, 4, 'asdf', 'photo/201612/20161206_56C300F3A5D8AC46FBD60D796A11B0D6.jpg', '5.00', '0.00', 5, 0, 0, 0, 'adsf', 50, 0, '36.57.177.152', 1481016978);

-- --------------------------------------------------------

--
-- 表的结构 `jh_product_cate`
--

CREATE TABLE IF NOT EXISTS `jh_product_cate` (
  `cate_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT '0',
  `shop_id` mediumint(8) DEFAULT '0',
  `title` varchar(30) DEFAULT '',
  `icon` varchar(150) DEFAULT '',
  `orderby` smallint(6) DEFAULT '50',
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`cate_id`),
  KEY `orderby` (`orderby`),
  KEY `shop_id` (`shop_id`,`parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `jh_product_cate`
--

INSERT INTO `jh_product_cate` (`cate_id`, `parent_id`, `shop_id`, `title`, `icon`, `orderby`, `dateline`) VALUES
(1, 0, 1, '热销榜', '', 50, 1475055708),
(2, 0, 1, '恒悦精品', '', 50, 1475055724),
(3, 0, 1, '招牌菜', '', 50, 1475055740),
(4, 0, 2, 'ceshi', '', 50, 1481016952);

-- --------------------------------------------------------

--
-- 表的结构 `jh_session`
--

CREATE TABLE IF NOT EXISTS `jh_session` (
  `SSID` char(35) NOT NULL,
  `uid` mediumint(8) DEFAULT '0',
  `city_id` mediumint(8) DEFAULT '0',
  `ip` char(15) DEFAULT '0.0.0.0',
  `data` varchar(1024) DEFAULT NULL,
  `lastupdate` int(10) DEFAULT '0',
  PRIMARY KEY (`SSID`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jh_session`
--

INSERT INTO `jh_session` (`SSID`, `uid`, `city_id`, `ip`, `data`, `lastupdate`) VALUES
('59gdb2ub5cvvd2pc251vciq5e7', 0, 0, '127.0.0.1', 'SSID|s:26:"59gdb2ub5cvvd2pc251vciq5e7";', 1511742853);

-- --------------------------------------------------------

--
-- 表的结构 `jh_shop`
--

CREATE TABLE IF NOT EXISTS `jh_shop` (
  `shop_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` smallint(6) DEFAULT '0',
  `cate_id` smallint(6) DEFAULT '0',
  `mobile` char(11) DEFAULT '',
  `passwd` char(32) DEFAULT '',
  `contact` varchar(30) DEFAULT '',
  `phone` varchar(20) DEFAULT '',
  `title` varchar(80) DEFAULT '',
  `money` decimal(10,2) DEFAULT '0.00',
  `total_money` decimal(10,2) DEFAULT '0.00',
  `banner` varchar(150) DEFAULT '',
  `logo` varchar(150) DEFAULT '',
  `lat` varchar(15) DEFAULT '',
  `lng` varchar(15) DEFAULT '',
  `addr` varchar(150) DEFAULT '',
  `views` mediumint(8) DEFAULT '0',
  `orders` mediumint(8) DEFAULT '0',
  `comments` mediumint(8) DEFAULT '0',
  `praise_num` mediumint(8) DEFAULT '0',
  `score` int(10) DEFAULT '0',
  `score_fuwu` int(10) DEFAULT '0',
  `score_kouwei` int(10) DEFAULT '0',
  `first_amount` decimal(6,2) DEFAULT '0.00',
  `min_amount` decimal(6,2) DEFAULT '0.00',
  `freight` decimal(6,2) DEFAULT '0.00',
  `pei_distance` decimal(6,0) DEFAULT '0',
  `pei_time` smallint(6) DEFAULT '0',
  `pei_type` tinyint(1) DEFAULT '0',
  `pei_amount` decimal(6,2) DEFAULT '0.00',
  `yy_status` tinyint(1) DEFAULT '0',
  `yy_stime` char(5) DEFAULT '9:00',
  `yy_ltime` char(5) DEFAULT '20:00',
  `yy_xiuxi` varchar(512) DEFAULT '',
  `is_new` tinyint(1) DEFAULT '0',
  `online_pay` tinyint(1) DEFAULT '0',
  `youhui` varchar(1024) DEFAULT NULL,
  `info` varchar(1024) DEFAULT '',
  `pmid` char(9) DEFAULT '',
  `verify_name` tinyint(1) DEFAULT '0',
  `audit` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  `tixian_percent` tinyint(2) unsigned DEFAULT '100',
  `orderby` tinyint(4) unsigned DEFAULT '50',
  PRIMARY KEY (`shop_id`),
  KEY `city_id` (`city_id`,`cate_id`),
  KEY `lat` (`lat`,`lng`),
  KEY `views` (`views`,`orders`,`comments`,`score`,`audit`,`closed`),
  KEY `pei_time` (`pei_time`,`pei_type`,`yy_stime`,`yy_ltime`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `jh_shop`
--

INSERT INTO `jh_shop` (`shop_id`, `city_id`, `cate_id`, `mobile`, `passwd`, `contact`, `phone`, `title`, `money`, `total_money`, `banner`, `logo`, `lat`, `lng`, `addr`, `views`, `orders`, `comments`, `praise_num`, `score`, `score_fuwu`, `score_kouwei`, `first_amount`, `min_amount`, `freight`, `pei_distance`, `pei_time`, `pei_type`, `pei_amount`, `yy_status`, `yy_stime`, `yy_ltime`, `yy_xiuxi`, `is_new`, `online_pay`, `youhui`, `info`, `pmid`, `verify_name`, `audit`, `closed`, `clientip`, `dateline`, `tixian_percent`, `orderby`) VALUES
(1, 22, 1, '18888888888', 'e10adc3949ba59abbe56e057f20f883e', '', '13771331940', '恒悦餐饮（莱蒙店）', '2.36', '5.38', '', 'photo/201612/20161211_9152CDD8347C991F2A05DAF9AD1AD061.jpg', '31.785365', '119.984917', '宁东路与腾飞路交叉口南100米', 0, 105, 0, 0, 0, 0, 0, '0.00', '0.00', '0.00', '5', 0, 0, '0.00', 1, '00:00', '23:30', '', 0, 1, '20:8', '加恒悦餐饮有限公司店长微信享现金私包一个。', '', 1, 1, 0, '202.112.25.27', 1474519455, 100, 50),
(2, 1, 15, '18715093232', 'e10adc3949ba59abbe56e057f20f883e', '', '13888888888', '测试', '0.00', '0.00', '', 'photo/201610/20161009_6466DB66A69085DD02D928D04CD89E0A.jpg', '31.836481', '117.249822', '123456', 0, 4, 0, 0, 0, 0, 0, '0.00', '0.00', '0.00', '1000', 0, 0, '0.00', 1, '08:00', '23:23', '', 0, 1, NULL, '', '', 0, 1, 0, '60.166.196.123', 1476004350, 100, 50),
(3, 1, 1, '15588000000', '761b7b6e50f8474743918169d56d124d', '', '15588000000', '雷锋站长', '0.00', '0.00', '', 'photo/201704/20170430_D5E9DB35B8F3C59C0CA1017A4C95891A.jpg', '39.912535', '116.408739', '雷锋站长雷锋站长还是雷锋站长', 0, 0, 0, 0, 0, 0, 0, '0.00', '0.00', '0.00', '0', 0, 0, '0.00', 0, '00:00', '00:00', '', 0, 1, NULL, '', '', 0, 1, 0, '127.0.0.1', 1493533769, 100, 50);

-- --------------------------------------------------------

--
-- 表的结构 `jh_shop_account`
--

CREATE TABLE IF NOT EXISTS `jh_shop_account` (
  `shop_id` mediumint(8) NOT NULL DEFAULT '0',
  `account_type` varchar(80) DEFAULT NULL,
  `account_name` varchar(30) DEFAULT '',
  `account_number` varchar(100) DEFAULT '',
  PRIMARY KEY (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jh_shop_account`
--

INSERT INTO `jh_shop_account` (`shop_id`, `account_type`, `account_name`, `account_number`) VALUES
(1, '农业银行', '吴志新', '6228480415096757273');

-- --------------------------------------------------------

--
-- 表的结构 `jh_shop_cate`
--

CREATE TABLE IF NOT EXISTS `jh_shop_cate` (
  `cate_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` smallint(6) DEFAULT '0',
  `title` varchar(30) DEFAULT '',
  `icon` varchar(150) DEFAULT '',
  `orderby` smallint(6) DEFAULT '50',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `jh_shop_cate`
--

INSERT INTO `jh_shop_cate` (`cate_id`, `parent_id`, `title`, `icon`, `orderby`, `dateline`) VALUES
(1, 0, '品牌馆', 'photo/201512/20151202_21B9ABD9C1D8082F3BB0BCB6010419D3.png', 50, 1448356515),
(2, 0, '餐饮外卖', 'photo/201512/20151202_2F979999DA57033C8D843A7851A93145.png', 50, 1448359515),
(3, 0, '快餐', 'photo/201512/20151202_C6557AF84D4D631D3D072AB1C4F90DFA.png', 50, 1449022383),
(4, 0, '水果牛奶', 'photo/201512/20151202_75E8C9FC3B9D21F05F69D2F635A362AF.png', 50, 1449022397),
(5, 0, '小吃', 'photo/201512/20151202_61CC6283CCF72D6894E6857C244120CF.png', 50, 1449022409),
(6, 0, '鲜花', 'photo/201512/20151202_DFC7A1D37143207C2D25BAA0031E55BC.png', 50, 1449022425),
(7, 0, '蛋糕甜点', 'photo/201512/20151202_0AFF10657C7F3C3ABF23B36177845500.png', 50, 1449022441),
(8, 1, '品牌馆子1', '', 2, 1449022441),
(9, 2, '餐饮外卖子1', '', 50, 0),
(10, 3, '快餐子1', '', 50, 0),
(11, 4, '水果牛奶子1', '', 50, 0),
(12, 5, '小吃子1', '', 50, 0),
(13, 6, '鲜花子1', '', 50, 0),
(14, 7, '蛋糕甜点子1', '', 50, 0),
(15, 1, '麻辣烫', '', 1, 1451996024);

-- --------------------------------------------------------

--
-- 表的结构 `jh_shop_collect`
--

CREATE TABLE IF NOT EXISTS `jh_shop_collect` (
  `shop_id` mediumint(8) NOT NULL DEFAULT '0',
  `uid` mediumint(8) NOT NULL DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`uid`,`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jh_shop_collect`
--

INSERT INTO `jh_shop_collect` (`shop_id`, `uid`, `dateline`) VALUES
(2, 2, 1476070718);

-- --------------------------------------------------------

--
-- 表的结构 `jh_shop_comment`
--

CREATE TABLE IF NOT EXISTS `jh_shop_comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` mediumint(8) DEFAULT '0',
  `uid` mediumint(8) DEFAULT '0',
  `order_id` int(8) DEFAULT '0',
  `score` tinyint(1) DEFAULT '0',
  `score_fuwu` tinyint(1) DEFAULT '0',
  `score_kouwei` tinyint(1) DEFAULT '0',
  `pei_time` smallint(6) DEFAULT '30',
  `content` varchar(1024) DEFAULT '',
  `have_photo` tinyint(1) DEFAULT '0',
  `reply` varchar(1024) DEFAULT '',
  `reply_ip` varchar(15) DEFAULT '',
  `reply_time` int(10) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `shop_id` (`shop_id`,`uid`),
  KEY `order_id` (`order_id`,`score`,`reply_time`,`closed`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `jh_shop_comment`
--

INSERT INTO `jh_shop_comment` (`comment_id`, `shop_id`, `uid`, `order_id`, `score`, `score_fuwu`, `score_kouwei`, `pei_time`, `content`, `have_photo`, `reply`, `reply_ip`, `reply_time`, `closed`, `clientip`, `dateline`) VALUES
(1, 1, 1, 22, 0, 0, 5, 10, '不错。', 0, '谢谢。', '202.112.25.17', 1476232906, 0, '202.112.25.17', 1476232719);

-- --------------------------------------------------------

--
-- 表的结构 `jh_shop_comment_photo`
--

CREATE TABLE IF NOT EXISTS `jh_shop_comment_photo` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` int(10) DEFAULT '0',
  `photo` varchar(150) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`photo_id`),
  KEY `comment_id` (`comment_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `jh_shop_comment_photo`
--

INSERT INTO `jh_shop_comment_photo` (`photo_id`, `comment_id`, `photo`, `dateline`) VALUES
(1, 1, 'photo/201610/20161012_6A6920D48E8DE0318F9FC4CCBB00BBC2.png', 1476232719);

-- --------------------------------------------------------

--
-- 表的结构 `jh_shop_log`
--

CREATE TABLE IF NOT EXISTS `jh_shop_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `money` decimal(10,2) DEFAULT '0.00',
  `intro` varchar(255) DEFAULT '',
  `admin` varchar(255) DEFAULT '',
  `day` int(8) DEFAULT '0',
  `clientip` varchar(25) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`log_id`),
  KEY `shop_id` (`shop_id`),
  KEY `day` (`day`,`dateline`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- 转存表中的数据 `jh_shop_log`
--

INSERT INTO `jh_shop_log` (`log_id`, `shop_id`, `money`, `intro`, `admin`, `day`, `clientip`, `dateline`) VALUES
(1, 1, '0.01', '订单完成结算(ID:17)', '', 20161011, '202.112.25.17', 1476198337),
(2, 1, '0.99', '订单完成结算(ID:21)', '', 20161011, '202.112.25.17', 1476198589),
(3, 1, '-1.00', '账户资金提现:支付宝(吴志新,13771331940)', '', 20161011, '202.112.25.17', 1476198622),
(4, 1, '0.01', '订单完成结算(ID:23)', '', 20161012, '202.112.25.17', 1476233006),
(5, 1, '0.01', '订单完成结算(ID:24)', '', 20161012, '202.112.25.17', 1476238872),
(6, 1, '0.01', '订单完成结算(ID:33)', '', 20161012, '202.112.25.13', 1476276056),
(7, 1, '1.00', '订单完成结算(ID:36)', '', 20161013, '202.112.25.9', 1476368992),
(8, 1, '-1.00', '账户资金提现:支付宝(吴志新,13771331940)', '', 20161013, '202.112.25.9', 1476369017),
(9, 1, '1.00', '订单完成结算(ID:44)', '', 20161014, '202.112.25.25', 1476456915),
(10, 1, '-1.00', '账户资金提现:农业银行(吴志新,6228480415096757273)', '', 20161014, '202.112.25.25', 1476456933),
(11, 1, '0.01', '订单完成结算(ID:45)', '', 20161015, '202.112.25.7', 1476523176),
(12, 1, '1.00', '订单完成结算(ID:46)', '', 20161015, '202.112.25.7', 1476524178),
(13, 1, '0.01', '订单完成结算(ID:47)', '', 20161016, '202.112.25.22', 1476553046),
(14, 1, '0.01', '订单完成结算(ID:49)', '', 20161016, '202.112.25.22', 1476555322),
(15, 1, '1.00', '订单完成结算(ID:51)', '', 20161016, '202.112.25.22', 1476556600),
(16, 1, '0.01', '订单完成结算(ID:58)', '', 20161018, '202.112.25.7', 1476790997),
(17, 1, '0.02', '订单完成结算(ID:59)', '', 20161018, '202.112.25.7', 1476794523),
(18, 1, '0.02', '订单完成结算(ID:64)', '', 20161019, '202.112.25.7', 1476811000),
(19, 1, '0.02', '订单完成结算(ID:65)', '', 20161019, '202.112.25.7', 1476811174),
(20, 1, '0.01', '订单完成结算(ID:66)', '', 20161019, '202.112.25.7', 1476811330),
(21, 1, '-0.01', '订单完成结算(ID:50)', '', 20161020, '202.112.25.6', 1476944387),
(22, 1, '-0.01', '订单完成结算(ID:48)', '', 20161020, '202.112.25.6', 1476944403),
(23, 1, '0.01', '订单完成结算(ID:60)', '', 20161020, '202.112.25.6', 1476944479),
(24, 1, '0.02', '订单完成结算(ID:69)', '', 20161020, '202.112.25.6', 1476944594),
(25, 1, '0.02', '订单完成结算(ID:67)', '', 20161020, '202.112.25.6', 1476944598),
(26, 1, '0.01', '订单完成结算(ID:55)', '', 20161020, '202.112.25.6', 1476944603),
(27, 1, '0.01', '订单完成结算(ID:68)', '', 20161020, '202.112.25.6', 1476944642),
(28, 1, '0.01', '订单完成结算(ID:70)', '', 20161020, '202.112.25.6', 1476963220),
(29, 1, '0.02', '订单完成结算(ID:76)', '', 20161021, '124.73.170.51', 1477032151),
(30, 1, '0.02', '订单完成结算(ID:75)', '', 20161021, '124.73.170.51', 1477032151),
(31, 1, '0.02', '订单完成结算(ID:71)', '', 20161021, '124.73.170.51', 1477032151),
(32, 1, '0.02', '订单完成结算(ID:78)', '', 20161022, '', 1477138399),
(33, 1, '0.02', '订单完成结算(ID:79)', '', 20161023, '', 1477200601),
(34, 1, '0.02', '订单完成结算(ID:80)', '', 20161023, '', 1477216801),
(35, 1, '0.03', '订单完成结算(ID:81)', '', 20161024, '', 1477288801),
(36, 1, '0.01', '订单完成结算(ID:83)', '', 20161114, '', 1479076201);

-- --------------------------------------------------------

--
-- 表的结构 `jh_shop_msg`
--

CREATE TABLE IF NOT EXISTS `jh_shop_msg` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` int(10) DEFAULT '0',
  `title` varchar(80) DEFAULT NULL,
  `content` varchar(512) DEFAULT '',
  `is_read` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0',
  `order_id` int(10) DEFAULT '0',
  PRIMARY KEY (`msg_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

--
-- 转存表中的数据 `jh_shop_msg`
--

INSERT INTO `jh_shop_msg` (`msg_id`, `shop_id`, `title`, `content`, `is_read`, `dateline`, `clientip`, `type`, `order_id`) VALUES
(1, 1, '订单已提交', '订单已提交', 1, 1475207725, '117.136.67.105', 1, 1),
(2, 1, '订单已取消', '用户(吴志新)已取消订单(ID:1)', 1, 1475219030, '183.207.216.97', 1, 1),
(3, 1, '订单已提交', '订单已提交', 1, 1475663954, '112.81.190.186', 1, 2),
(4, 1, '订单已取消', '用户(吴志新)已取消订单(ID:2)', 1, 1475664001, '112.81.190.186', 1, 2),
(5, 1, '订单已提交', '订单已提交', 1, 1475741307, '112.81.190.186', 1, 3),
(6, 1, '订单已提交', '订单已提交', 1, 1475853423, '202.112.25.30', 1, 4),
(7, 1, '订单已提交', '订单已提交', 1, 1475936667, '202.112.25.30', 1, 5),
(8, 1, '订单已提交', '订单已提交', 1, 1475936958, '202.112.25.30', 1, 6),
(9, 1, '订单已提交', '订单已提交', 1, 1475942884, '202.112.25.30', 1, 7),
(10, 1, '订单已提交', '订单已提交', 1, 1476158632, '202.112.25.16', 1, 12),
(11, 1, '订单已提交', '订单已提交', 1, 1476158739, '202.112.25.16', 1, 13),
(12, 1, '订单已提交', '订单已提交', 1, 1476158764, '202.112.25.16', 1, 14),
(13, 1, '订单已提交', '订单已提交', 1, 1476159559, '202.112.25.16', 1, 16),
(14, 1, '订单已提交', '订单已提交', 1, 1476160264, '202.112.25.16', 1, 17),
(15, 1, '订单已提交', '订单已提交', 1, 1476195884, '202.112.25.17', 1, 18),
(16, 1, '订单已提交', '订单已提交', 1, 1476196426, '202.112.25.17', 1, 19),
(17, 1, '催单消息', '用户于2016-10-11 23:04催单了(单号：17，手机号：13771331940)', 1, 1476198282, '202.112.25.17', 1, 17),
(18, 1, '用户已评价订单(22)', '不错。', 1, 1476232719, '202.112.25.17', 2, 22),
(19, 1, '用户(吴志新)投诉了订单(ID:24)', '不好。', 1, 1476238870, '202.112.25.17', 3, 24),
(20, 1, '订单已提交', '订单已提交', 1, 1476262734, '49.80.137.143', 1, 25),
(21, 1, '订单已提交', '订单已提交', 1, 1476262996, '49.80.137.143', 1, 27),
(22, 1, '订单已提交', '订单已提交', 1, 1476263129, '49.80.137.143', 1, 28),
(23, 1, '订单已提交', '订单已提交', 1, 1476264179, '202.112.25.13', 1, 29),
(24, 1, '订单余额支付成功', '订单余额支付成功', 1, 1476264179, '202.112.25.13', 1, 29),
(25, 1, '订单已取消', '用户(吴志新)已取消订单(ID:29)', 1, 1476264188, '202.112.25.13', 1, 29),
(26, 1, '订单已提交', '订单已提交', 1, 1476264196, '202.112.25.13', 1, 30),
(27, 1, '订单已提交', '订单已提交', 1, 1476267044, '202.112.25.13', 1, 32),
(28, 1, '用户(吴志新)投诉了订单(ID:33)', '没优惠。', 1, 1476276076, '202.112.25.13', 3, 33),
(29, 1, '订单已提交', '订单已提交', 1, 1476347507, '202.112.25.9', 1, 34),
(30, 1, '订单已取消', '用户(吴志新)已取消订单(ID:34)', 1, 1476347519, '202.112.25.9', 1, 34),
(31, 1, '订单已提交', '订单已提交', 1, 1476347541, '202.112.25.9', 1, 35),
(32, 1, '订单已提交', '订单已提交', 1, 1476368843, '202.112.25.9', 1, 36),
(33, 1, '订单已提交', '订单已提交', 1, 1476384391, '202.112.25.9', 1, 37),
(34, 1, '订单已提交', '订单已提交', 1, 1476384516, '202.112.25.9', 1, 38),
(35, 1, '订单已提交', '订单已提交', 1, 1476384558, '202.112.25.9', 1, 39),
(36, 1, '订单已提交', '订单已提交', 1, 1476385053, '202.112.25.9', 1, 40),
(37, 1, '订单已提交', '订单已提交', 1, 1476385739, '202.112.25.9', 1, 41),
(38, 1, '订单已提交', '订单已提交', 1, 1476385793, '202.112.25.9', 1, 42),
(39, 1, '订单已提交', '订单已提交', 1, 1476429554, '114.226.182.11', 1, 43),
(40, 1, '订单已取消', '用户(赵俐娜)已取消订单(ID:43)', 1, 1476429609, '114.226.182.11', 1, 43),
(41, 1, '订单已提交', '订单已提交', 1, 1476552941, '202.112.25.22', 1, 47),
(42, 1, '订单已提交', '订单已提交', 1, 1476554486, '202.112.25.22', 1, 49),
(43, 1, '订单余额支付成功', '订单余额支付成功', 1, 1476554486, '202.112.25.22', 1, 49),
(44, 1, '订单已提交', '订单已提交', 1, 1476800629, '202.112.25.7', 1, 62),
(45, 1, '订单余额支付成功', '订单余额支付成功', 1, 1476800629, '202.112.25.7', 1, 62),
(46, 1, '订单已取消', '用户(吴志新)已取消订单(ID:62)', 1, 1476800657, '202.112.25.7', 1, 62),
(47, 1, '订单已提交', '订单已提交', 1, 1476805557, '202.112.25.7', 1, 63),
(48, 1, '订单已取消', '用户(吴志新)已取消订单(ID:63)', 1, 1476805582, '202.112.25.7', 1, 63),
(49, 1, '订单已提交', '订单已提交', 0, 1476948466, '202.112.25.6', 1, 72),
(50, 1, '订单已提交', '订单已提交', 0, 1476955572, '202.112.25.6', 1, 73),
(51, 1, '订单已取消', '用户(吴志新)已取消订单(ID:72)', 0, 1476955604, '202.112.25.6', 1, 72),
(52, 1, '订单已提交', '订单已提交', 0, 1476957766, '202.112.25.6', 1, 74),
(53, 1, '订单已取消', '用户(吴志新)已取消订单(ID:74)', 1, 1476963032, '202.112.25.6', 1, 74),
(54, 1, '订单已取消', '用户(吴志新)已取消订单(ID:73)', 1, 1476963047, '202.112.25.6', 1, 73),
(55, 1, '用户正在催单', '用户(吴志新)正在催促订单(ID:71)', 1, 1476964508, '202.112.25.6', 1, 71),
(56, 1, '订单已提交', '订单已提交', 0, 1478955552, '202.112.25.20', 1, 82),
(57, 1, '订单已提交', '订单已提交', 0, 1479119900, '202.112.25.23', 1, 89),
(58, 1, '订单已提交', '订单已提交', 0, 1479687636, '112.26.227.116', 1, 100),
(59, 1, '订单已提交', '订单已提交', 0, 1480247736, '112.81.147.219', 1, 102),
(60, 1, '订单已提交', '订单已提交', 0, 1480766004, '153.35.47.104', 1, 103),
(61, 2, '订单已提交', '订单已提交', 0, 1481017048, '36.57.177.152', 1, 104),
(62, 2, '订单已提交', '订单已提交', 0, 1481017180, '36.57.177.152', 1, 105),
(63, 2, '订单已提交', '订单已提交', 0, 1481017373, '117.68.226.251', 1, 106),
(64, 2, '订单已提交', '订单已提交', 0, 1481017465, '117.68.226.251', 1, 107),
(65, 1, '订单已提交', '订单已提交', 0, 1481079319, '122.193.190.152', 1, 108),
(66, 1, '订单已提交', '订单已提交', 1, 1481090590, '122.193.190.152', 1, 109);

-- --------------------------------------------------------

--
-- 表的结构 `jh_shop_tixian`
--

CREATE TABLE IF NOT EXISTS `jh_shop_tixian` (
  `tixian_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` mediumint(8) DEFAULT '0',
  `money` decimal(10,2) DEFAULT '0.00',
  `intro` varchar(255) DEFAULT '',
  `account_info` varchar(512) DEFAULT '',
  `status` tinyint(1) DEFAULT '0',
  `reason` varchar(255) DEFAULT '',
  `updatetime` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT NULL,
  `end_money` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`tixian_id`),
  KEY `shop_id` (`shop_id`,`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `jh_shop_tixian`
--

INSERT INTO `jh_shop_tixian` (`tixian_id`, `shop_id`, `money`, `intro`, `account_info`, `status`, `reason`, `updatetime`, `clientip`, `dateline`, `end_money`) VALUES
(1, 1, '1.00', '', '支付宝(吴志新,13771331940)', 1, '', 1476517405, '202.112.25.17', 1476198622, '1.00'),
(2, 1, '1.00', '', '支付宝(吴志新,13771331940)', 1, '', 1476517405, '202.112.25.9', 1476369017, '1.00'),
(3, 1, '1.00', '', '农业银行(吴志新,6228480415096757273)', 1, '', 1476517405, '202.112.25.25', 1476456933, '1.00');

-- --------------------------------------------------------

--
-- 表的结构 `jh_shop_verify`
--

CREATE TABLE IF NOT EXISTS `jh_shop_verify` (
  `shop_id` mediumint(8) unsigned NOT NULL,
  `id_name` varchar(30) DEFAULT '',
  `id_number` varchar(20) DEFAULT '',
  `id_photo` varchar(150) DEFAULT '',
  `shop_photo` varchar(150) DEFAULT '',
  `verify_dianzhu` tinyint(1) DEFAULT '0',
  `yz_number` varchar(30) DEFAULT '',
  `yz_photo` varchar(150) DEFAULT '',
  `verify_yyzz` tinyint(1) DEFAULT '0',
  `cy_number` varchar(30) DEFAULT '',
  `cy_photo` varchar(150) DEFAULT '',
  `verify_cy` tinyint(1) DEFAULT '0',
  `refuse` varchar(255) DEFAULT '',
  `verify` tinyint(1) DEFAULT '0',
  `verify_time` int(10) DEFAULT '0',
  `updatetime` int(10) DEFAULT '0',
  PRIMARY KEY (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jh_shop_verify`
--

INSERT INTO `jh_shop_verify` (`shop_id`, `id_name`, `id_number`, `id_photo`, `shop_photo`, `verify_dianzhu`, `yz_number`, `yz_photo`, `verify_yyzz`, `cy_number`, `cy_photo`, `verify_cy`, `refuse`, `verify`, `verify_time`, `updatetime`) VALUES
(1, '吴志新', '320282198312270015', 'photo/201610/20161011_09119E7DA08AE5A7464148AF0D8AF2DE.png', 'photo/201610/20161011_B4391114888E62F0DA67BEC5A997B0D3.png', 1, '123456', 'photo/201610/20161011_76265E19227098762EF85A95B38CCF4C.png', 1, '123456', 'photo/201610/20161011_34BBE95B766CF9D390C71D296512D5A0.png', 1, '', 1, 1476198216, 1476196655);

-- --------------------------------------------------------

--
-- 表的结构 `jh_shop_youhui`
--

CREATE TABLE IF NOT EXISTS `jh_shop_youhui` (
  `youhui_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shop_id` mediumint(8) DEFAULT '0',
  `order_amount` decimal(10,2) DEFAULT '0.00',
  `youhui_amount` decimal(8,2) DEFAULT '0.00',
  `use_count` smallint(6) DEFAULT '0',
  `orderby` smallint(6) DEFAULT '0',
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`youhui_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `jh_shop_youhui`
--

INSERT INTO `jh_shop_youhui` (`youhui_id`, `shop_id`, `order_amount`, `youhui_amount`, `use_count`, `orderby`, `dateline`) VALUES
(3, 1, '20.00', '8.00', 0, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `jh_sms_log`
--

CREATE TABLE IF NOT EXISTS `jh_sms_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` varchar(50) DEFAULT '',
  `content` varchar(255) DEFAULT '',
  `sms` varchar(20) DEFAULT '',
  `status` tinyint(1) DEFAULT '0',
  `clientip` char(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- 转存表中的数据 `jh_sms_log`
--

INSERT INTO `jh_sms_log` (`log_id`, `mobile`, `content`, `sms`, `status`, `clientip`, `dateline`) VALUES
(1, '13771331940', '您的短信验证码是717839，该验证码3分钟有效。【酷乐送外卖】', '56dx', 0, '202.112.25.9', 1472895075),
(2, '13771331940', '您的短信验证码是440475，该验证码3分钟有效。【酷乐送外卖】', '56dx', 0, '202.112.25.27', 1474456031),
(3, '13771331940', '您的短信验证码是160864，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '202.112.25.27', 1474456190),
(4, '13771331940', '您的短信验证码是491707，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '202.112.25.27', 1474456383),
(5, '13771331940', '您的短信验证码是480776，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '202.112.25.27', 1474456393),
(6, '13771331940', '您的短信验证码是424097，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '202.112.25.27', 1474519267),
(7, '13771331940', '您的短信验证码是954424，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '202.112.25.27', 1474519439),
(8, '13771331940', '您的短信验证码是440545，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '202.112.25.27', 1474519607),
(9, '13771331940', '您的短信验证码是570541，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '202.112.25.30', 1474819200),
(10, '13771331940', '您的短信验证码是319260，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '202.112.25.30', 1475203806),
(11, '15961414153', '您的短信验证码是962694，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '180.116.239.40', 1476107749),
(12, '13921330310', '您的短信验证码是209366，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '61.160.122.22', 1476173093),
(13, '13961508312', '您的短信验证码是817694，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '183.207.217.62', 1476266082),
(14, '13771331940', '您的短信验证码是411693，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '202.112.25.9', 1476374601),
(15, '13506144317', '您的短信验证码是204799，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '114.226.182.11', 1476429345),
(16, '15106120872', '您的短信验证码是178147，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '60.55.8.93', 1476784759),
(17, '15106120872', '您的短信验证码是919291，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '60.55.8.93', 1476785040),
(18, '18311364811', '您的短信验证码是161163，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '111.193.82.90', 1479518610),
(19, '18655488651', '您的短信验证码是698171，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '112.26.227.116', 1479667923),
(20, '13916999445', '您的短信验证码是284546，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '223.104.5.239', 1479756501),
(21, '15711103055', '您的短信验证码是240520，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '117.73.147.3', 1480196949),
(22, '15719685959', '您的短信验证码是621915，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '211.161.244.137', 1480514228),
(23, '15719685959', '您的短信验证码是183781，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '211.161.244.137', 1480514301),
(24, '13921237808', '您的短信验证码是902803，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '221.178.181.17', 1481111155),
(25, '13921237808', '您的短信验证码是819854，该验证码3分钟有效。【酷乐送外卖】', '56dx', 1, '221.178.181.17', 1481112633),
(26, '15965656565', '您的短信验证码是222387，该验证码3分钟有效。【江湖外卖跑腿O2O系统V2.0破解版源码+客户端+配送端+商户端】', '56dx', 1, '127.0.0.1', 1481439358),
(27, '15954525356', '您的短信验证码是533685，该验证码3分钟有效。【江湖外卖跑腿O2O系统V2.0破解版源码+客户端+配送端+商户端】', '56dx', 1, '127.0.0.1', 1481439717),
(28, '15965656565', '您的短信验证码是926666，该验证码3分钟有效。【江湖外卖跑腿O2O系统V2.0破解版源码+客户端+配送端+商户端】', '56dx', 1, '127.0.0.1', 1481439839),
(29, '13888888888', '您的短信验证码是243920，该验证码3分钟有效。【江湖外卖跑腿O2O系统V2.0破解版源码+客户端+配送端+商户端】', '56dx', 1, '127.0.0.1', 1481440315);

-- --------------------------------------------------------

--
-- 表的结构 `jh_staff`
--

CREATE TABLE IF NOT EXISTS `jh_staff` (
  `staff_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` smallint(6) DEFAULT '0',
  `mobile` char(11) DEFAULT '',
  `passwd` char(32) DEFAULT '',
  `face` varchar(150) DEFAULT '',
  `money` decimal(10,2) DEFAULT '0.00',
  `total_money` decimal(10,2) DEFAULT '0.00',
  `orders` mediumint(8) DEFAULT '0',
  `loginip` varchar(15) DEFAULT '',
  `lastlogin` int(10) DEFAULT '0',
  `lat` varchar(15) DEFAULT '',
  `lng` varchar(15) DEFAULT '',
  `name` varchar(30) DEFAULT '',
  `id_number` varchar(20) DEFAULT '',
  `id_photo` varchar(150) DEFAULT '',
  `account_type` varchar(30) DEFAULT '',
  `account_name` varchar(30) DEFAULT '',
  `account_number` varchar(30) DEFAULT '',
  `verify_name` tinyint(1) DEFAULT '0',
  `audit` tinyint(1) DEFAULT '0',
  `closed` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  `tixian_percent` tinyint(2) unsigned DEFAULT '100',
  `status` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`staff_id`),
  KEY `mobile` (`mobile`,`closed`),
  KEY `city_id` (`city_id`,`audit`,`closed`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `jh_staff`
--

INSERT INTO `jh_staff` (`staff_id`, `city_id`, `mobile`, `passwd`, `face`, `money`, `total_money`, `orders`, `loginip`, `lastlogin`, `lat`, `lng`, `name`, `id_number`, `id_photo`, `account_type`, `account_name`, `account_number`, `verify_name`, `audit`, `closed`, `clientip`, `dateline`, `tixian_percent`, `status`) VALUES
(1, 0, '15636363636', 'e10adc3949ba59abbe56e057f20f883e', '', '8.16', '1.00', 16, '17.199.160.39', 1479532834, '31.362852647569', '119.82635660807', '吴志新', '', '', '支付宝', '吴志新', '15636363636', 1, 1, 0, '202.112.25.30', 1475203833, 100, 1),
(2, 0, '13888888888', 'e10adc3949ba59abbe56e057f20f883e', '', '0.00', '0.00', 0, '60.166.196.49', 1476932568, '31.83002', '117.249605', '测试', '', '', '支付宝', '测试', '13888888888', 1, 1, 0, '60.166.196.49', 1476932562, 100, 0),
(3, 0, '18311364811', '971bb6d8c575ed821139d3f818bdb53a', '', '0.00', '0.00', 0, '111.193.82.90', 1479631528, '39.860244', '116.352683', '蒋伟', '', '', '工商银行', '蒋伟', '612321199512162658', 1, 1, 0, '111.193.82.90', 1479518634, 100, 1),
(4, 0, '13916999445', 'e10adc3949ba59abbe56e057f20f883e', '', '0.00', '0.00', 0, '223.104.5.236', 1480013094, '31.279797', '121.467067', '周晓军', '', '', '支付宝', '', '', 0, 1, 0, '223.104.5.239', 1479756536, 100, 1),
(5, 0, '15711103055', '82fd77edcc896d74a260ea7f95d08df7', '', '0.00', '0.00', 0, '59.108.15.151', 1480404330, '39.951762', '116.404400', '平川川', '', '', '', '', '', 0, 1, 0, '117.73.147.3', 1480196969, 100, 1),
(6, 0, '13921237808', '1b7ca80fe68535c6347ec1976c3aab20', '', '0.00', '0.00', 0, '221.178.181.17', 1481112681, '31.922731', '120.265889', '史修成', '', '', '', '', '', 0, 1, 0, '221.178.181.17', 1481112659, 100, 1),
(7, 0, '15652565656', 'e10adc3949ba59abbe56e057f20f883e', '', '0.00', '0.00', 0, '', 0, '', '', '配送人员', '', '', '支付宝', '陈先生', '65465465', 0, 1, 0, '127.0.0.1', 1481439299, 100, 0),
(8, 0, '15888888888', 'e10adc3949ba59abbe56e057f20f883e', '', '0.00', '0.00', 0, '', 0, '', '', '张三', '', '', '支付宝', '张三', '6228454585458888', 0, 1, 0, '127.0.0.1', 1481441437, 100, 0),
(9, 0, '15858585858', 'e10adc3949ba59abbe56e057f20f883e', '', '0.00', '0.00', 0, '', 0, '', '', '配送人员', '', '', '支付宝', '豆腐坊', '56465464', 0, 1, 0, '127.0.0.1', 1481442064, 100, 0),
(10, 0, '15652565256', 'e10adc3949ba59abbe56e057f20f883e', '', '0.00', '0.00', 0, '', 0, '', '', '硕鼠硕鼠', '', '', '支付宝', '豆腐坊', '6546546464646', 0, 1, 0, '127.0.0.1', 1481442449, 100, 0);

-- --------------------------------------------------------

--
-- 表的结构 `jh_staff_log`
--

CREATE TABLE IF NOT EXISTS `jh_staff_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) DEFAULT NULL,
  `money` decimal(10,2) DEFAULT '0.00',
  `intro` varchar(255) DEFAULT '',
  `admin` varchar(255) DEFAULT '',
  `day` int(8) DEFAULT '0',
  `clientip` varchar(25) DEFAULT '',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`log_id`),
  KEY `staff_id` (`staff_id`),
  KEY `day` (`day`,`dateline`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 转存表中的数据 `jh_staff_log`
--

INSERT INTO `jh_staff_log` (`log_id`, `staff_id`, `money`, `intro`, `admin`, `day`, `clientip`, `dateline`) VALUES
(1, 1, '1.00', '订单配送完成结算(ID:51)', '', 20161016, '202.112.25.22', 1476556600),
(2, 1, '-1.00', '账户资金提现:支付宝(吴志新,13771331940)', '', 20161016, '202.112.25.22', 1476556722),
(3, 1, '0.01', '订单配送完成结算(ID:58)', '', 20161018, '202.112.25.7', 1476790997),
(4, 1, '0.01', '订单配送完成结算(ID:66)', '', 20161019, '202.112.25.7', 1476811330),
(5, 1, '0.02', '订单配送完成结算(ID:50)', '', 20161020, '202.112.25.6', 1476944387),
(6, 1, '0.02', '订单配送完成结算(ID:48)', '', 20161020, '202.112.25.6', 1476944403),
(7, 1, '0.01', '订单配送完成结算(ID:60)', '', 20161020, '202.112.25.6', 1476944479),
(8, 1, '0.01', '订单配送完成结算(ID:55)', '', 20161020, '202.112.25.6', 1476944603),
(9, 1, '0.01', '订单配送完成结算(ID:68)', '', 20161020, '202.112.25.6', 1476944642),
(10, 1, '0.01', '订单配送完成结算(ID:70)', '', 20161020, '202.112.25.6', 1476963220),
(11, 1, '0.01', '订单代购完成结算(ID:84)', '', 20161114, '117.136.68.115', 1479106044),
(12, 1, '0.05', '订单代购完成结算(ID:95)', '', 20161114, '', 1479135601);

-- --------------------------------------------------------

--
-- 表的结构 `jh_staff_msg`
--

CREATE TABLE IF NOT EXISTS `jh_staff_msg` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` int(10) DEFAULT '0',
  `title` varchar(80) DEFAULT NULL,
  `content` varchar(512) DEFAULT '',
  `is_read` tinyint(1) DEFAULT '0',
  `clientip` varchar(15) DEFAULT NULL,
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`msg_id`),
  KEY `staff_id` (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_staff_tixian`
--

CREATE TABLE IF NOT EXISTS `jh_staff_tixian` (
  `tixian_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `staff_id` mediumint(8) DEFAULT '0',
  `money` decimal(10,2) DEFAULT '0.00',
  `intro` varchar(255) DEFAULT '',
  `account_info` varchar(512) DEFAULT '',
  `status` tinyint(1) DEFAULT '0',
  `reason` varchar(255) DEFAULT '',
  `updatetime` int(10) DEFAULT '0',
  `clientip` varchar(15) DEFAULT '',
  `dateline` int(10) DEFAULT NULL,
  `end_money` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`tixian_id`),
  KEY `staff_id` (`staff_id`,`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `jh_staff_tixian`
--

INSERT INTO `jh_staff_tixian` (`tixian_id`, `staff_id`, `money`, `intro`, `account_info`, `status`, `reason`, `updatetime`, `clientip`, `dateline`, `end_money`) VALUES
(1, 1, '1.00', '', '支付宝(吴志新,13771331940)', 1, '', 0, '202.112.25.22', 1476556722, '1.00');

-- --------------------------------------------------------

--
-- 表的结构 `jh_staff_verify`
--

CREATE TABLE IF NOT EXISTS `jh_staff_verify` (
  `staff_id` mediumint(8) NOT NULL,
  `id_name` varchar(30) DEFAULT '',
  `id_number` varchar(18) DEFAULT '',
  `id_photo` varchar(150) DEFAULT '',
  `verify` tinyint(1) DEFAULT '0',
  `verify_time` int(10) DEFAULT '0',
  `refuse` varchar(150) DEFAULT '',
  `updatetime` int(10) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`staff_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jh_staff_verify`
--

INSERT INTO `jh_staff_verify` (`staff_id`, `id_name`, `id_number`, `id_photo`, `verify`, `verify_time`, `refuse`, `updatetime`, `dateline`) VALUES
(1, '吴志新', '320282198312270015', '', 1, 1481442245, '', 1475222792, 0),
(2, '测试', '341222199511112222', 'photo/201610/20161020_E342D0E37F9E318B45FF5FE6E34D2EA2.jpg', 1, 1476932613, '', 1476932605, 0),
(3, '18311364811', '612321199512162658', 'photo/201611/20161119_21146D4245D365AAE9E742995FA2B707.png', 1, 1481426651, '', 1479519801, 0);

-- --------------------------------------------------------

--
-- 表的结构 `jh_system_config`
--

CREATE TABLE IF NOT EXISTS `jh_system_config` (
  `k` varchar(30) NOT NULL,
  `v` mediumtext,
  `title` varchar(30) DEFAULT '',
  `dateline` int(10) DEFAULT NULL,
  PRIMARY KEY (`k`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `jh_system_config`
--

INSERT INTO `jh_system_config` (`k`, `v`, `title`, `dateline`) VALUES
('attach', 'a:10:{s:3:"dir";s:9:"./attachs";s:3:"url";s:9:"./attachs";s:10:"allow_exts";s:16:"jpg,gif,png,jpeg";s:10:"allow_size";s:4:"2048";s:13:"watermarktype";s:3:"png";s:13:"watermarktext";a:4:{s:4:"font";s:8:"cyzt.ttf";s:4:"size";s:2:"14";s:5:"color";s:7:"#000000";s:4:"text";s:7:"@{name}";}s:15:"watermarkstatus";s:1:"9";s:16:"watermarkquality";s:2:"90";s:12:"thumbquality";s:2:"90";s:5:"thumb";s:3:"200";}', '附件设置', 1493518960),
('config', 'a:2:{s:4:"hash";s:8360:"6956424F5277304B47676F414141414E535568455567414141483041414141744341594141414344446D545341414141475852465748525462325A30643246795A5142425A4739695A53424A6257466E5A564A6C5957523563636C6C5041414141794270564668305745314D4F6D4E76625335685A4739695A53353462584141414141414144772F654842685932746C644342695A576470626A30693737752F496942705A443069567A564E4D4531775132566F61556836636D5654656B355559337072597A6C6B496A382B494478344F6E68746347316C6447456765473173626E4D366544306959575276596D5536626E4D366257563059533869494867366547317764477339496B466B62324A6C4946684E5543424462334A6C494455754D43316A4D445977494459784C6A457A4E4463334E7977674D6A41784D4338774D6938784D6930784E7A6F7A4D6A6F774D4341674943416749434167496A346750484A6B5A6A70535245596765473173626E4D36636D526D50534A6F644852774F693876643364334C6E637A4C6D39795A7938784F546B354C7A41794C7A49794C584A6B5A69317A6557353059586774626E4D6A496A346750484A6B5A6A70455A584E6A636D6C7764476C76626942795A47593659574A76645851394969496765473173626E4D366547317750534A6F644852774F693876626E4D7559575276596D5575593239744C336868634338784C6A41764969423462577875637A70346258424E545430696148523063446F764C32357A4C6D466B62324A6C4C6D4E7662533934595841764D5334774C3231744C79496765473173626E4D36633352535A575939496D6830644841364C793975637935685A4739695A53356A62323076654746774C7A45754D43397A56486C775A5339535A584E7664584A6A5A564A6C5A694D694948687463447044636D566864473979564739766244306951575276596D5567554768766447397A6147397749454E544E5342586157356B6233647A496942346258424E5454704A626E4E305957356A5A556C4550534A346258417561576C6B4F6B55334D3055784E5459354D4449314D7A457852544D344D554933516A46475154597A4D304E474E54597A496942346258424E5454704562324E316257567564456C4550534A34625841755A476C6B4F6B55334D3055784E545A424D4449314D7A457852544D344D554933516A46475154597A4D304E474E54597A496A3467504868746345314E4F6B526C636D6C325A575247636D397449484E30556D566D4F6D6C7563335268626D4E6C53555139496E687463433570615751365254637A525445314E6A63774D6A557A4D5446464D7A6778516A64434D555A424E6A4D7A513059314E6A4D6949484E30556D566D4F6D5276593356745A57353053555139496E68746343356B615751365254637A525445314E6A67774D6A557A4D5446464D7A6778516A64434D555A424E6A4D7A513059314E6A4D694C7A3467504339795A4759365247567A59334A70634852706232342B49447776636D526D4F6C4A45526A3467504339344F6E68746347316C6447452B4944772F654842685932746C6443426C626D5139496E4969507A3637555966634141414973306C455156523432757963435778555652534737394253704341574B6367715167566B4559774C6771675246526663514E77696F6B614A476F4F4345414B4B454E53344C776949714B43345339474943305A6C55304645525648454254634552634343624E307330426E50795879547555376554476435725A33704F386B665A715A33376E74392F7A336E2F4F666357337942514D4234567265736E766349504E493971774F5737665468707930364C704A2F7567744B424B483466364267676D424F457466704C356774714C546D79784E4D45647A482B317A42564D4641727175574A64677347437A34323658662B5148426C594C6476506478543663497471517A6D58324B316964504F6F53336376673850386E37306539316450693870665736767143396F4858456D4F61434269343946795734726541515946754475754C7030634C376E69696637302F794F6E756A6646345A4D66632B687A4737557268757041556972686B7966355450367854705070657645306A524F394D3566576F61797947534A4B4B686369496963564E425A794B692B7A6E64737971745144444D656E34484343714961493073687970414F3477426D6C71755A6B777246725366434A654E686A466F69387346707775755A5137564F6A634A7A6955715855737139494F66304530653664566B536C4B7834414C4262344C56676D50514A4F3944666E394536445245714936355158417933766F59337277586B56784247744D46385A54674C6347744546384D3259634C68677132436B594B31676932735A412B396B69765874744346644F485A2F6763336A684F734A44586C776B32436A62786E666459454630456379464E506251584663564D5153454C5142665348337A6E43464A45415A4867524261514C6F345A6771386850653677373547656E4A306D6D43676F6F3953635473376542664768614B4135654A35674F4A4667752B424651536D457170587A37317242523959312B754C397A374D414E4C5350596E354E4854634B7A684A305A66772F48756E56613430463751526E514C6147315256346279346575524E767635586E6E45756531716A776854565845367350596C734A65587768704A636A695064772F517036437A7572714A4138306C32796475545338594B444254305156354E3570714671705A6D675348437334485842434D4751434E49445553716364594950436576614E376D436E6F55756F70645A57453879626F6B6C4944335371386D576B713956694E30702B453777454747335067547551356A5651316D586F514F614A4341575A3050305145546934344B4C5341586C7A4E553030624C59497A303557774D47556A6239535A342F694964665A676D725279444A494D4B557141666A764D346F7776347977537242766554362B6F542F3639415242703251556E5047733672744A4254336C3552515778427068586A34554A523371655667787A4457746C416E30422F78755771464671687A5031476C6B516E7646655251447437442B4E784D496A3151432B63376E5470374A74366D684A354E6E6A3059676155352F427A4272337A6E65484C384E31616E7271455645587A776B516668756C665267667A7649304963537268767866632B45587A5039373253725970636D597070447531484C746664794A6155583770622B424C50564A73793879476E495648675849685A5338672F6A43695154376C316965426F76486B444B554A562B6C6551337078726170672F4370337743796B6A4951644F42394C56632B36694A4D6C4B5952342F586E35696976657A682F745251716579434A5338682F464B62636B6542346B5863392B6643546F4A6E6F5845504479336B6B553446652F4F73577075726345585543573853636374744F6855775539423155394135622B61536151334A6F54574671753069486D47686F7432335971744D51735164666C34614448452F5955487678584864565A796A5A416D4B4C49453233693067597249735A527432377A775876326D2F66546C4D58362B472F7961355078626F337865616932457A53416838306833787A547474454773395351482B2F432B5A6554666B67546E31507A666D547A666C66546B4939392F79707756796478734F704475783674533356635057436F3478385837302F7738686B35625163546341547A324D334C77736A6A6E624D2B633535746739363965784A792F6D324158376C4772423542527043766877784651716478764A62684E634B5A4C3936596B7A7A4C42625653316E386E6E4A64787244387137515361344933647A48494A4C782B6E57367047385830325673426552714C582B71594A7271434B4757794976593067764A357756755454664D4A666D3055375A45784375432F4A75453978523232434E30584B744E2B57636B6A6B643062637978694A365774414E62353473654463697636757748574343323746643642634D5355513770454E7A7875336A556765344E4D38497646684C726B6D51734D46687758364556796F706568687A5A49773578304C344473624E635242304A66514164477456643968363862706A4A70466547303037613166772B6732384C5A62394948694E31307071573463783355674461724F5A4E35597449712B7261542F2B6C4E6F57336E305A527271325634394149377874346A744A4F34327846535A38357436327755534362656943654777636A5A31792B675731697653444D6F7A30546B544A55506B556A315656552F65306F734B33636336354869526B4E5258656D325559366145393742304F6554775A613244432B2B786254666730544C5659545A462B574977794B74314D6857432B31554E77347738783871786F754C2B3666344761494C304A3559715437557044306A556E6C3771735638704E2B49436B79515453727A6242566D4B6B3653624539326C49656F4377486C7251725632596334384A2F796D5A6274446B70697670326F3638586E4248464D476F4175547A4E4D3370577932437569547776577A6746423143352B50316F455337424B71696248697339332B51376D4F46366731664B486A424250764E655648477A7A644A37424456456C744F616455306766705939396631464B73656F476A7638504F6C704137645A446B687A6A6E314C487768356542464E5647797153635070337A52666439474E42303649647761782F6975486A61596C51626B617175314F7753764E2B476A567039547170316E676D31645863437234346836326A50586B374F5448635973354764484D3361523566314F316F5A783274545263335172616F4A304C544F754D73486563694B6D44334253476E693552693039665871704352353348686E7859505641596A385450707173326D56646C416734326F6F494C31716177445956682F634C586A48424C567074757478676E413948364C314E685042396647392B545A44754E346B664D7452636549734A62694C556468764751382B69524E4E652B306F54507257716E71363938686D51744A685157326A436634335346636359514370645243694F5A7270686F7A747A453069522B6C722F4975596436376F614366516B55562F65617871646D3867766C6831446F6361725A4F4E644942712B376A54526435685376556171696A7A534F70762F6E736C7235694441394C6855475637664159386537544458667367627A2F6859707566766444763564753768627542552F6378454B42733353473855682F4372536A4671324E6B4F79664D67665763566F6A4972536A5045546348704E466557772B63616A6654736575692F4B666B71536A4E704C6C36764278354F516F5346446C4C6F6D6267503850444663524165656D355447542B492B5871623843455131526136632F63323139336E46756D62574E6E466C68646F54567269554B2B57574D304B502B383349745A556B61364B73776E6A5A373479457A356B4744704F3747626E626A6371655A655663774D4F6E62416C654A76757076316F676E766830577744595675397552574C794D647A325779534F39623048564165576C7233716F35545A4649347975337A2F765041756D666566727048756D6365365A356C705030727741444766685A7833374E41374141414141424A52553545726B4A6767673D3D";s:4:"host";s:132:"687474703A2F2F77777725732E696A682E63632F696E6465782E7068703F63746C3D6C697374656E26686F73743D2573266B65793D25732676657273696F6E3D2573";}', '系统设置', NULL),
('mail', 'a:4:{s:6:"sender";s:15:"ijhmail@126.com";s:4:"mode";s:4:"smtp";s:4:"smtp";a:4:{s:4:"host";s:12:"smtp.126.com";s:4:"port";s:2:"25";s:5:"uname";s:15:"ijhmail@126.com";s:6:"passwd";s:8:"ijianghu";}s:5:"email";s:15:"ijianghu@qq.com";}', '邮件设置', 1410881223),
('site', 'a:16:{s:5:"title";s:76:"江湖外卖跑腿O2O系统V2.0破解版源码+客户端+配送端+商户端";s:7:"siteurl";s:21:"http://www.ertong.com";s:6:"secret";s:0:"";s:4:"mail";s:16:"278869155@qq.com";s:4:"kfqq";s:9:"278869155";s:5:"phone";s:11:"15588000000";s:4:"logo";s:58:"photo/201612/20161211_CD958AFC2A6712F10613634750CFBD70.png";s:8:"weixinqr";s:58:"photo/201612/20161211_6A7E87810029DBF8CB4522524BBFBD38.png";s:9:"is_status";s:1:"0";s:7:"city_id";s:1:"1";s:10:"multi_city";s:1:"0";s:6:"domain";s:10:"48ym.com";s:7:"rewrite";s:1:"0";s:5:"intro";s:89:"江湖外卖跑腿O2O系统V2.0破解版源码+客户端+配送端+商户端 雷锋站长";s:6:"tongji";s:89:"江湖外卖跑腿O2O系统V2.0破解版源码+客户端+配送端+商户端 雷锋站长";s:3:"icp";s:24:"雷锋站长源码论坛";}', '基本设置', 1511742824),
('sms', 'a:6:{s:10:"show_error";s:1:"0";s:5:"comid";s:4:"2938";s:9:"smsnumber";s:5:"10690";s:5:"uname";s:8:"kulesong";s:6:"passwd";s:20:"kulesong5566kulesong";s:6:"mobile";s:11:"13771331940";}', '短信设置', 1481439260),
('invite', 'a:7:{s:16:"invite_reg_money";s:2:"15";s:18:"invite_order_money";s:2:"11";s:14:"hongbao_amount";s:2:"15";s:18:"hongbao_min_amount";s:2:"20";s:11:"share_photo";s:58:"photo/201612/20161211_E2AA3C91C5778C2DED8EC1899CF49464.png";s:11:"share_title";s:24:"邀请好友奖励现金";s:5:"intro";s:96:"邀请好友奖励现金邀请好友奖励现金邀请好友奖励现金邀请好友奖励现金";}', '好友邀请', 1481439162),
('site_config', 'a:2:{s:4:"hash";s:8360:"6956424F5277304B47676F414141414E535568455567414141483041414141744341594141414344446D545341414141475852465748525462325A30643246795A5142425A4739695A53424A6257466E5A564A6C5957523563636C6C5041414141794270564668305745314D4F6D4E76625335685A4739695A53353462584141414141414144772F654842685932746C644342695A576470626A30693737752F496942705A443069567A564E4D4531775132566F61556836636D5654656B355559337072597A6C6B496A382B494478344F6E68746347316C6447456765473173626E4D366544306959575276596D5536626E4D366257563059533869494867366547317764477339496B466B62324A6C4946684E5543424462334A6C494455754D43316A4D445977494459784C6A457A4E4463334E7977674D6A41784D4338774D6938784D6930784E7A6F7A4D6A6F774D4341674943416749434167496A346750484A6B5A6A70535245596765473173626E4D36636D526D50534A6F644852774F693876643364334C6E637A4C6D39795A7938784F546B354C7A41794C7A49794C584A6B5A69317A6557353059586774626E4D6A496A346750484A6B5A6A70455A584E6A636D6C7764476C76626942795A47593659574A76645851394969496765473173626E4D366547317750534A6F644852774F693876626E4D7559575276596D5575593239744C336868634338784C6A41764969423462577875637A70346258424E545430696148523063446F764C32357A4C6D466B62324A6C4C6D4E7662533934595841764D5334774C3231744C79496765473173626E4D36633352535A575939496D6830644841364C793975637935685A4739695A53356A62323076654746774C7A45754D43397A56486C775A5339535A584E7664584A6A5A564A6C5A694D694948687463447044636D566864473979564739766244306951575276596D5567554768766447397A6147397749454E544E5342586157356B6233647A496942346258424E5454704A626E4E305957356A5A556C4550534A346258417561576C6B4F6B55334D3055784E5459354D4449314D7A457852544D344D554933516A46475154597A4D304E474E54597A496942346258424E5454704562324E316257567564456C4550534A34625841755A476C6B4F6B55334D3055784E545A424D4449314D7A457852544D344D554933516A46475154597A4D304E474E54597A496A3467504868746345314E4F6B526C636D6C325A575247636D397449484E30556D566D4F6D6C7563335268626D4E6C53555139496E687463433570615751365254637A525445314E6A63774D6A557A4D5446464D7A6778516A64434D555A424E6A4D7A513059314E6A4D6949484E30556D566D4F6D5276593356745A57353053555139496E68746343356B615751365254637A525445314E6A67774D6A557A4D5446464D7A6778516A64434D555A424E6A4D7A513059314E6A4D694C7A3467504339795A4759365247567A59334A70634852706232342B49447776636D526D4F6C4A45526A3467504339344F6E68746347316C6447452B4944772F654842685932746C6443426C626D5139496E4969507A3637555966634141414973306C455156523432757963435778555652534737394253704341574B6367715167566B4559774C6771675246526663514E77696F6B614A476F4F4345414B4B454E53344C776949714B43345339474943305A6C55304645525648454254634552634343624E307330426E50795879547555376554476435725A33704F386B665A715A33376E74392F7A336E2F4F666357337942514D4234567265736E766349504E493971774F5737665468707930364C704A2F7567744B424B483466364267676D424F457466704C356774714C546D79784E4D45647A482B317A42564D4641727175574A64677347437A34323658662B5148426C594C6476506478543663497471517A6D58324B316964504F6F53336376673850386E37306539316450693870665736767143396F4858456D4F61434269343946795734726541515946754475754C7030634C376E69696637302F794F6E756A6646345A4D66632B687A4737557268757041556972686B7966355450367854705070657645306A524F394D3566576F61797947534A4B4B686369496963564E425A794B692B7A6E64737971745144444D656E34484343714961493073687970414F3477426D6C71755A6B777246725366434A654E686A466F69387346707775755A5137564F6A634A7A6955715855737139494F66304530653664566B536C4B7834414C4262344C56676D50514A4F3944666E394536445245714936355158417933766F59337277586B56784247744D46385A54674C6347744546384D3259634C68677132436B594B31676932735A412B396B69765874744346644F485A2F6763336A684F734A44586C776B32436A62786E666459454630456379464E506251584663564D5153454C5142665348337A6E43464A45415A4867524261514C6F345A6771386850653677373547656E4A306D6D43676F6F3953635473376542664768614B4135654A35674F4A4667752B424651536D457170587A37317242523959312B754C397A374D414E4C5350596E354E4854634B7A684A305A66772F48756E56613430463751526E514C6147315256346279346575524E767635586E6E45756531716A776854565845367350596C734A65587768704A636A695064772F517036437A7572714A4138306C32796475545338594B444254305156354E3570714671705A6D675348437334485842434D4751434E49445553716364594950436576614E376D436E6F55756F70645A57453879626F6B6C4944335371386D576B713956694E30702B453777454747335067547551356A5651316D586F514F614A4341575A3050305145546934344B4C5341586C7A4E553030624C59497A303557774D47556A6239535A342F694964665A676D725279444A494D4B557141666A764D346F7776347977537242766554362B6F542F3639415242703251556E5047733672744A4254336C3552515778427068586A34554A523371655667787A4457746C416E30422F78755771464671687A5031476C6B516E7646655251447437442B4E784D496A3151432B63376E5470374A74366D684A354E6E6A3059676155352F427A4272337A6E65484C384E31616E7271455645587A776B516668756C665267667A7649304963537268767866632B45587A5039373253725970636D597070447531484C746664794A6155583770622B424C50564A73793879476E495648675849685A5338672F6A43695154376C316965426F76486B444B554A562B6C6551337078726170672F4370337743796B6A4951644F42394C56632B36694A4D6C4B5952342F586E35696976657A682F745251716579434A5338682F464B62636B6542346B5863392B6643546F4A6E6F5845504479336B6B553446652F4F73577075726345585543573853636374744F6855775539423155394135622B61536151334A6F54574671753069486D47686F7432335971744D51735164666C34614448452F5955487678584864565A796A5A416D4B4C49453233693067597249735A527432377A775876326D2F66546C4D58362B472F7961355078626F337865616932457A53416838306833787A547474454773395351482B2F432B5A6554666B67546E31507A666D547A666C66546B4939392F79707756796478734F704475783674533356635057436F3478385837302F7738686B35625163546341547A324D334C77736A6A6E624D2B633535746739363965784A792F6D324158376C4772423542527043766877784651716478764A62684E634B5A4C3936596B7A7A4C42625653316E386E6E4A64787244387137515361344933647A48494A4C782B6E57367047385830325673426552714C582B71594A7271434B4757794976593067764A357756755454664D4A666D3055375A45784375432F4A75453978523232434E30584B744E2B57636B6A6B643062637978694A365774414E62353473654463697636757748574343323746643642634D5355513770454E7A7875336A556765344E4D38497646684C726B6D51734D46687758364556796F706568687A5A49773578304C344473624E635242304A66514164477456643968363862706A4A70466547303037613166772B6732384C5A62394948694E31307071573463783355674461724F5A4E35597449712B7261542F2B6C4E6F57336E305A527271325634394149377874346A744A4F34327846535A38357436327755534362656943654777636A5A31792B675731697653444D6F7A30546B544A55506B556A315656552F65306F734B33636336354869526B4E5258656D325559366145393742304F6554775A613244432B2B786254666730544C5659545A462B574977794B74314D6857432B31554E77347738783871786F754C2B3666344761494C304A3559715437557044306A556E6C3771735638704E2B49436B79515453727A6242566D4B6B3653624539326C49656F4377486C7251725632596334384A2F796D5A6274446B70697670326F3638586E4248464D476F4175547A4E4D3370577932437569547776577A6746423143352B50316F455337424B71696248697339332B51376D4F46366731664B486A424250764E655648477A7A644A37424456456C744F616455306766705939396631464B73656F476A7638504F6C704137645A446B687A6A6E314C487768356542464E5647797153635070337A52666439474E42303649647761782F6975486A61596C51626B617175314F7753764E2B476A567039547170316E676D31645863437234346836326A50586B374F5448635973354764484D3361523566314F316F5A783274545263335172616F4A304C544F754D73486563694B6D44334253476E693552693039665871704352353348686E7859505641596A385450707173326D56646C416734326F6F494C31716177445956682F634C586A48424C567074757478676E413948364C314E685042396647392B545A44754E346B664D7452636549734A62694C556468764751382B69524E4E652B306F54507257716E71363938686D51744A685157326A436634335346636359514370645243694F5A7270686F7A747A453069522B6C722F4975596436376F614366516B55562F65617871646D3867766C6831446F6361725A4F4E644942712B376A54526435685376556171696A7A534F70762F6E736C7235694441394C6855475637664159386537544458667367627A2F6859707566766444763564753768627542552F6378454B42733353473855682F4372536A4671324E6B4F79664D67665763566F6A4972536A5045546348704E466557772B63616A6654736575692F4B666B71536A4E704C6C36764278354F516F5346446C4C6F6D6267503850444663524165656D355447542B492B5871623843455131526136632F63323139336E46756D62574E6E466C68646F54567269554B2B57574D304B502B383349745A556B61364B73776E6A5A373479457A356B4744704F3747626E626A6371655A655663774D4F6E62416C654A76757076316F676E766830577744595675397552574C794D647A325779534F39623048564165576C7233716F35545A4649347975337A2F765041756D666566727048756D6365365A356C705030727741444766685A7833374E41374141414141424A52553545726B4A6767673D3D";s:4:"host";s:114:"687474703A2F2F7777772E696A682E63632F696E6465782E7068703F63746C3D6D6F6E69746F72696E6726686F73743D2573266B65793D2573";}', '配置设置', 1389324222),
('score', 'a:3:{s:7:"company";a:5:{s:6:"score1";s:6:"服务";s:6:"score2";s:6:"价格";s:6:"score3";s:6:"设计";s:6:"score4";s:6:"施工";s:6:"score5";s:6:"售后";}s:8:"designer";a:3:{s:6:"score1";s:6:"设计";s:6:"score2";s:6:"服务";s:6:"score3";s:6:"贴心";}s:2:"gz";a:3:{s:6:"score1";s:6:"施工";s:6:"score2";s:6:"服务";s:6:"score3";s:6:"贴心";}}', '评论配置', 1414511280),
('jifen', 'a:1:{s:11:"jifen_ratio";s:3:"100";}', '积分设置', 1451290528),
('wechat', 'a:11:{s:4:"type";s:1:"1";s:5:"appid";s:18:"wx94a875308fdd52f1";s:9:"appsecret";s:32:"1d33e84c9c9ec5b3293aafe3509d3c99";s:12:"wechat_token";s:117:"DBt3udvCXdmCdRzbQe3IwmWgqyT6YyPbgFEXg0SdP9w9rjsWTpUECGiRLyHMT48l7HC-MtmyrPhm3OmKoTob9yHEf7EHQ9OftJex7WAbx3EOPUgABAWXC";s:13:"wechat_aeskey";s:43:"SxEig3kOzhwdx3inunvoNxswd3JMj52uKaaftZgst1X";s:9:"app_appid";s:18:"wx9f5942cca34d37d2";s:13:"app_appsecret";s:32:"9871c6ead36073ba9aa0e989efd61a97";s:13:"open_mp_appid";s:0:"";s:17:"open_mp_appsecret";s:0:"";s:13:"open_mp_token";s:32:"b6c27def35bcf7166636b5a303182db0";s:14:"open_mp_aeskey";s:0:"";}', '微信配置', 1475206964),
('access', 'a:9:{s:12:"signup_count";s:1:"0";s:11:"signup_time";s:1:"0";s:6:"denyip";s:0:"";s:12:"mobile_count";s:1:"0";s:11:"mobile_time";s:1:"0";s:11:"order_count";s:2:"10";s:10:"order_time";s:1:"5";s:6:"closed";s:1:"0";s:13:"closed_reason";s:0:"";}', '访问设置', 1446605898),
('wx_config', 'a:4:{s:12:"order_number";s:7:"TM00017";s:8:"order_id";s:43:"KKIfDKtqdsIZa0Swe_ZX82Kj8D0M4TEUkEGlvTm5H0E";s:12:"money_number";s:15:"OPENTM205454780";s:8:"money_id";s:43:"zn3sAuL36ea6d_VHyJPDsz4PqUy-fXSMTZEGEaucnsw";}', '微信模版消息', 1453098824),
('app_download', 'a:9:{s:14:"waimai_version";s:3:"1.0";s:15:"waimai_download";s:56:"http://www.ijh.cc/attachs/down/waimai/com.ijh.waimai.apk";s:12:"waimai_intro";s:181:"发现新版本\r\n【新增】搜索结果支持筛选、排序，在众多商家中快速定位！\r\n【优化】筛选功能优化，更方便易用~\r\n【优化】优化诸多细节";s:11:"biz_version";s:3:"1.0";s:12:"biz_download";s:60:"http://www.ijh.cc/attachs/down/waimai/com.ijh.waimai.biz.apk";s:9:"biz_intro";s:207:"发现新版本\r\n【新增】商家自主设置配送信息！\r\n【优化】商户管理中心自主编辑店铺的商品分类和上架的新菜单，更便捷！更畅快！\r\n【优化】优化诸多细节";s:13:"staff_version";s:3:"1.0";s:14:"staff_download";s:62:"http://www.ijh.cc/attachs/down/waimai/com.ijh.waimai.staff.apk";s:11:"staff_intro";s:234:"发现新版本\r\n【新增】订单统计和资金统计，近一周、近一月的订单和收入趋势走向一目了然！\r\n【优化】汇总订单量和收入，快速了解销量和收入状况！\r\n【优化】优化诸多细节";}', 'APP版本', 1454566154),
('paotui', 'a:5:{s:11:"start_price";s:2:"25";s:8:"start_km";s:1:"5";s:8:"start_kg";s:1:"5";s:11:"addkm_price";s:1:"5";s:11:"addkg_price";s:1:"3";}', '跑腿配置', 1481112839),
('rongcloud', 'a:2:{s:6:"appkey";s:13:"lmxuhwagxlamd";s:9:"appsecret";s:12:"0ObIR9tfk9p7";}', '融云接口', 1475939551);

-- --------------------------------------------------------

--
-- 表的结构 `jh_system_logs`
--

CREATE TABLE IF NOT EXISTS `jh_system_logs` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin` varchar(30) DEFAULT '',
  `action` varchar(50) DEFAULT '',
  `title` varchar(255) DEFAULT '',
  `content` mediumtext,
  `dateline` int(10) unsigned DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `jh_system_module`
--

CREATE TABLE IF NOT EXISTS `jh_system_module` (
  `mod_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `module` enum('top','menu','module') DEFAULT 'module',
  `level` tinyint(1) DEFAULT '3',
  `ctl` varchar(20) DEFAULT '',
  `act` varchar(20) DEFAULT '',
  `title` varchar(20) DEFAULT '',
  `visible` tinyint(1) DEFAULT '1',
  `parent_id` smallint(6) DEFAULT '0',
  `orderby` smallint(6) DEFAULT '50',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`mod_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1519 ;

--
-- 转存表中的数据 `jh_system_module`
--

INSERT INTO `jh_system_module` (`mod_id`, `module`, `level`, `ctl`, `act`, `title`, `visible`, `parent_id`, `orderby`, `dateline`) VALUES
(1, 'top', 1, '', '', '设置', 1, 0, 10, 1356434427),
(5, 'top', 1, '', '', '运营', 1, 0, 60, 1356434427),
(6, 'menu', 2, '', '', '权限管理', 1, 601, 20, 1356434427),
(7, 'menu', 2, '', '', '模块管理', 1, 601, 30, 1356434427),
(8, 'module', 3, 'module/menu', 'index', '导航菜单管理', 1, 7, 1, 1356434427),
(9, 'module', 3, 'module/ctl', 'index', '控制模型管理', 1, 7, 11, 1356434427),
(26, 'module', 3, 'module/menu', 'create', '添加导航菜单', 0, 7, 2, 1356434427),
(27, 'module', 3, 'module/menu', 'save', '保存导航菜单', 0, 7, 6, 1356434427),
(28, 'module', 3, 'module/menu', 'edit', '编辑导航菜单', 0, 7, 3, 1356434427),
(31, 'module', 3, 'module/ctl', 'batch', '指量添加控制模块', 0, 7, 13, 1356434427),
(32, 'module', 3, 'module/ctl', 'save', '保存控制模块', 0, 7, 14, 1356434427),
(33, 'module', 3, 'module/ctl', 'detail', '管理控制模型', 0, 7, 12, 1356434427),
(35, 'module', 3, 'module/menu', 'update', '更新导航菜单', 0, 7, 4, 1356434427),
(37, 'module', 3, 'module/ctl', 'remove', '删除控制模块', 0, 7, 15, 1356434427),
(44, 'module', 3, 'module/menu', 'remove', '删除导航菜单', 0, 7, 5, 1356437401),
(48, 'module', 3, 'admin/role', 'index', '角色管理', 1, 6, 1, 1356437591),
(49, 'module', 3, 'admin/admin', 'index', '管理员管理', 1, 6, 2, 1356437975),
(50, 'module', 3, 'admin/role', 'create', '创建角色', 0, 6, 50, 1356437975),
(51, 'module', 3, 'admin/role', 'detail', '管理角色', 0, 6, 50, 1356437975),
(52, 'module', 3, 'admin/role', 'save', '保存角色', 0, 6, 50, 1356437975),
(53, 'module', 3, 'admin/role', 'delete', '删除角色', 0, 6, 50, 1356437975),
(54, 'module', 3, 'admin/admin', 'create', '创建管理员', 0, 6, 50, 1356437975),
(55, 'module', 3, 'admin/admin', 'edit', '修改管理员', 0, 6, 50, 1356437975),
(56, 'module', 3, 'admin/admin', 'save', '保存管理员', 0, 6, 50, 1356437975),
(57, 'module', 3, 'admin/admin', 'delete', '删除管理员', 0, 6, 50, 1356437975),
(68, 'menu', 2, '', '', '广告管理', 1, 5, 10, 1356513698),
(71, 'top', 1, '', '', '会员', 1, 0, 20, 1356513738),
(72, 'menu', 2, '', '', '会员管理', 1, 71, 10, 1356513776),
(113, 'module', 3, 'adv/adv', 'index', '广告位管理', 1, 68, 50, 1357460157),
(114, 'module', 3, 'adv/adv', 'detail', '管理广告位', 0, 68, 50, 1357460260),
(115, 'module', 3, 'adv/adv', 'edit', '编辑广告位', 0, 68, 50, 1357460260),
(116, 'module', 3, 'adv/adv', 'create', '创建广告位', 0, 68, 50, 1357460260),
(117, 'module', 3, 'adv/adv', 'delete', '删除广告位', 0, 68, 50, 1357460260),
(119, 'module', 3, 'adv/item', 'create', '添加广告', 0, 68, 50, 1357460574),
(120, 'module', 3, 'adv/item', 'edit', '修改广告', 0, 68, 50, 1357460574),
(122, 'module', 3, 'adv/item', 'delete', '删除广告', 0, 68, 50, 1357460574),
(123, 'module', 3, 'adv/adv', 'update', '更新广告位', 0, 68, 50, 1357462189),
(124, 'module', 3, 'adv/item', 'update', '更新广告内容', 0, 68, 50, 1357463273),
(127, 'top', 1, '', '', '工具', 1, 0, 70, 1357609135),
(142, 'module', 3, 'member/member', 'index', '会员列表', 1, 72, 10, 1357714750),
(144, 'module', 3, 'member/member', 'ulock', '锁定会员', 0, 72, 14, 1357714750),
(146, 'module', 3, 'member/member', 'recycle', '会员回收站', 1, 72, 15, 1357714750),
(188, 'module', 3, 'member/member', 'delete', '删除会员', 0, 72, 16, 1358501680),
(189, 'module', 3, 'member/member', 'regain', '恢复会员', 0, 72, 17, 1358501680),
(244, 'menu', 2, '', '', '站长工具', 1, 127, 52, 1366388132),
(245, 'module', 3, 'tools/cache', 'clean', '清空缓存', 1, 244, 50, 1366388194),
(269, 'menu', 2, '', '', '网站设置', 1, 1, 1, 1370085075),
(279, 'menu', 2, '', '', '数据库管理', 1, 127, 50, 1371537222),
(383, 'module', 3, 'member/member', 'create', '添加会员', 0, 72, 11, 1372437934),
(384, 'module', 3, 'member/member', 'edit', '修改会员', 0, 72, 12, 1372437934),
(385, 'module', 3, 'member/member', 'so', '搜索会员', 0, 72, 13, 1372438141),
(386, 'module', 3, 'system/config', 'site', '基本设置', 1, 269, 1, 1372869314),
(1361, 'module', 3, 'product/cate', 'delete', '删除分类', 0, 1343, 50, 1448346444),
(1360, 'module', 3, 'product/cate', 'edit', '编辑分类', 0, 1343, 50, 1448346444),
(419, 'module', 3, 'member/log', 'index', '余额日志', 1, 72, 50, 1373683486),
(420, 'module', 3, 'member/log', 'so', '日志搜索', 0, 72, 50, 1373683486),
(430, 'module', 3, 'member/member', 'money', '充值余额', 0, 72, 18, 1373792200),
(470, 'module', 3, 'system/config', 'attach', '附件设置', 1, 269, 2, 1374459620),
(506, 'module', 3, 'system/config', 'sms', '短信设置', 1, 951, 50, 1376155472),
(515, 'module', 3, 'adv/adv', 'so', '搜索广告位', 0, 68, 50, 1376479539),
(516, 'module', 3, 'magic/upload', 'editor', '编辑器上传图片', 0, 269, 50, 1376590326),
(1359, 'module', 3, 'product/cate', 'create', '添加分类', 0, 1343, 50, 1448346444),
(551, 'menu', 2, '', '', '支付配置', 1, 1, 3, 1380438926),
(553, 'module', 3, 'payment/payment', 'index', '支付接口', 1, 551, 50, 1380440527),
(554, 'module', 3, 'tools/database', 'index', '数据库管理', 1, 279, 50, 1380561710),
(1327, 'module', 3, 'staff/tixian', 'doaudit', '审核提现', 0, 1305, 50, 1446282258),
(562, 'module', 3, 'member/member', 'ucard', '会员卡片层', 0, 72, 19, 1381942505),
(570, 'module', 3, 'member/member', 'face', '更新头像', 0, 72, 50, 1383112630),
(601, 'top', 1, '', '', '系统', 1, 0, 9, 1383820332),
(602, 'module', 3, 'member/member', 'dialog', '选择用户', 0, 72, 50, 1383980953),
(1323, 'module', 3, 'staff/staff', 'so', '搜索配送人员', 0, 1305, 50, 1446260623),
(1324, 'module', 3, 'staff/log', 'index', '资金日志', 1, 1305, 5, 1446281741),
(1358, 'module', 3, 'product/cate', 'index', '商品分类', 1, 1343, 1, 1448346444),
(1275, 'module', 3, 'member/member', 'detail', '会员资料', 0, 72, 50, 1442051185),
(1326, 'module', 3, 'staff/tixian', 'index', '提现申请', 1, 1305, 5, 1446282258),
(1285, 'module', 3, 'member/message', 'create', '添加消息', 0, 951, 50, 1442546094),
(670, 'menu', 2, '', '', '模板设置', 1, 1, 50, 1384760168),
(671, 'module', 3, 'system/theme', 'index', '模板管理', 1, 670, 50, 1384760203),
(1294, 'module', 3, 'system/config', 'wx_config', '模版消息', 1, 269, 50, 1445569927),
(1357, 'module', 3, 'product/product', 'so', '搜索商品', 0, 1343, 50, 1448345805),
(1322, 'module', 3, 'staff/staff', 'audit', '待审人员', 1, 1305, 3, 1446260344),
(1345, 'module', 3, 'member/addr', 'index', '收货地址', 1, 72, 50, 1448339823),
(1344, 'menu', 2, '', '', '订单管理', 1, 1209, 50, 1448335783),
(1346, 'module', 3, 'member/addr', 'create', '添加收货地址', 0, 72, 50, 1448341927),
(275, 'module', 3, 'tools/developer', 'module', '模块生成器', 1, 274, 50, 1371316412),
(1286, 'module', 3, 'member/message', 'edit', '修改消息', 0, 951, 50, 1442546094),
(1356, 'module', 3, 'product/product', 'detail', '查看商品', 0, 1343, 50, 1448345805),
(1290, 'module', 3, 'staff/complaint', 'delete', '删除投诉', 0, 1305, 50, 1443060158),
(1289, 'module', 3, 'staff/complaint', 'detail', '查看投诉', 0, 1305, 50, 1443060158),
(1373, 'module', 3, 'mall/cate', 'index', '商品分类', 1, 1363, 50, 1448349756),
(1284, 'module', 3, 'member/message', 'index', '消息列表', 1, 951, 50, 1442546094),
(891, 'module', 3, 'payment/payment', 'config', '配置接口', 0, 551, 50, 1388027577),
(892, 'module', 3, 'payment/payment', 'install', '安装接口', 0, 551, 50, 1388027577),
(893, 'module', 3, 'payment/payment', 'uninstall', '卸载接口', 0, 551, 50, 1388027577),
(1355, 'module', 3, 'product/product', 'delete', '删除商品', 0, 1343, 50, 1448345805),
(897, 'module', 3, 'payment/log', 'index', '支付流水', 1, 551, 50, 1388048090),
(899, 'module', 3, 'payment/log', 'so', '修改流水', 0, 551, 50, 1388048090),
(901, 'module', 3, 'payment/log', 'status', '更改状态', 0, 551, 50, 1388048090),
(919, 'module', 3, 'member/member', 'manager', '管理会员', 0, 72, 50, 1388485506),
(922, 'module', 3, 'system/theme', 'detail', '管理模板', 0, 670, 50, 1389258144),
(923, 'module', 3, 'system/theme', 'install', '安装模板', 0, 670, 50, 1389258144),
(924, 'module', 3, 'system/theme', 'uninstall', '卸载模板', 0, 670, 50, 1389258144),
(925, 'module', 3, 'system/theme', 'setdefault', '设置默认模板', 0, 670, 50, 1389258144),
(951, 'menu', 2, '', '', '通知设置', 1, 71, 50, 1403261297),
(1014, 'module', 3, 'tools/database', 'restore', '还原数据库', 0, 279, 50, 1413193393),
(1025, 'module', 3, 'hongbao/hongbao', 'index', '红包管理', 1, 72, 50, 1413947742),
(1022, 'module', 3, 'system/theme', 'tmplsave', '修改入库', 0, 670, 50, 1413447673),
(1021, 'module', 3, 'system/theme', 'tmpldelbak', '删除备份', 0, 670, 50, 1413429794),
(1020, 'module', 3, 'system/theme', 'tmplrestore', '还原模板', 0, 670, 50, 1413429248),
(1019, 'module', 3, 'system/theme', 'tmplbak', '查看备份', 0, 670, 50, 1413429248),
(1015, 'module', 3, 'tools/database', 'optimize', '优化数据库', 0, 279, 50, 1413193393),
(1016, 'module', 3, 'adv/adv', 'config', '广告位设置', 0, 68, 50, 1413384837),
(1018, 'module', 3, 'system/theme', 'tmpledit', '编辑模板', 0, 670, 50, 1413429248),
(1017, 'module', 3, 'adv/adv', 'code', '调用代码', 0, 68, 50, 1413384837),
(1013, 'module', 3, 'tools/database', 'backdel', '删除备份', 0, 279, 50, 1413193393),
(1012, 'module', 3, 'tools/database', 'backlist', '备份列表', 0, 279, 50, 1413193393),
(1011, 'module', 3, 'tools/database', 'backup', '备份数据库', 0, 279, 50, 1413193393),
(993, 'module', 3, 'adv/item', 'doaudit', '审核广告', 0, 68, 50, 1250176349),
(277, 'module', 3, 'tools/developer', 'config', '配置生成器', 1, 274, 50, 1371316412),
(1026, 'module', 3, 'hongbao/hongbao', 'create', '创建红包', 0, 72, 50, 1413947742),
(1027, 'module', 3, 'hongbao/hongbao', 'add', '添加红包', 0, 72, 50, 1413947742),
(1028, 'module', 3, 'hongbao/hongbao', 'edit', '修改红包', 0, 72, 50, 1413947742),
(1029, 'module', 3, 'hongbao/hongbao', 'delete', '删除红包', 0, 72, 50, 1413947742),
(1287, 'module', 3, 'member/message', 'delete', '删除消息', 0, 951, 50, 1442546094),
(1288, 'module', 3, 'staff/complaint', 'index', '投诉列表', 1, 1305, 6, 1443060158),
(278, 'module', 3, 'tools/developer', 'schema', '关联表Schema', 0, 274, 50, 1371445645),
(274, 'menu', 2, '', '', '开发工具', 1, 127, 50, 1371316254),
(1354, 'module', 3, 'product/product', 'edit', '编辑商品', 0, 1343, 50, 1448345805),
(1342, 'menu', 2, '', '', '商家管理', 1, 1209, 50, 1448335766),
(1343, 'menu', 2, '', '', '商品管理', 1, 1209, 50, 1448335774),
(1209, 'top', 1, '', '', '商家', 1, 0, 50, 1441878040),
(1325, 'module', 3, 'staff/log', 'so', '搜索日志', 0, 1305, 50, 1446281796),
(1096, 'module', 3, 'system/config', 'access', '访问设置', 1, 269, 50, 1419059027),
(1372, 'module', 3, 'order/log', 'index', '订单日志', 0, 1344, 10, 1448349592),
(1371, 'module', 3, 'order/product', 'index', '订单商品', 0, 1344, 50, 1448349592),
(1362, 'top', 1, '', '', '商城', 1, 0, 50, 1448348300),
(1311, 'module', 3, 'staff/staff', 'index', '配送人员', 1, 1305, 2, 1446198036),
(1312, 'module', 3, 'staff/staff', 'create', '添加配送人员', 0, 1305, 50, 1446198036),
(1130, 'module', 3, 'system/config', 'wechat', '微信配置', 1, 269, 5, 1420386712),
(1183, 'module', 3, 'adv/item', 'index', '内容管理', 0, 68, 50, 1431152244),
(1184, 'module', 3, 'adv/item', 'so', '搜索内容', 0, 68, 50, 1431167794),
(1315, 'module', 3, 'staff/staff', 'delete', '删除配送人员', 0, 1305, 50, 1446198036),
(1314, 'module', 3, 'staff/staff', 'doaudit', '审核配送人员', 0, 1305, 50, 1446198036),
(1313, 'module', 3, 'staff/staff', 'edit', '修改配送人员', 0, 1305, 50, 1446198036),
(1305, 'menu', 2, '', '', '配送人员', 1, 71, 50, 1446196040),
(1374, 'module', 3, 'mall/product', 'index', '商品列表', 1, 1363, 50, 1448350190),
(1196, 'module', 3, 'sms/log', 'index', '短信日志', 1, 951, 50, 1435192593),
(1328, 'module', 3, 'staff/tixian', 'reason', '拒绝提现', 0, 1305, 50, 1446282258),
(1329, 'module', 3, 'staff/complaint', 'replay', '回复投诉', 0, 951, 50, 1446284079),
(1330, 'module', 3, 'staff/tixian', 'detail', '查看提现', 0, 1305, 50, 1446458291),
(1353, 'module', 3, 'product/product', 'create', '添加商品', 0, 1343, 50, 1448345805),
(1352, 'module', 3, 'product/product', 'index', '商品列表', 1, 1343, 2, 1448345805),
(1351, 'module', 3, 'hongbao/hongbao', 'detail', '查看红包', 0, 72, 50, 1448343749),
(1350, 'module', 3, 'member/addr', 'so', '搜索收货地址', 0, 72, 50, 1448342367),
(1349, 'module', 3, 'member/addr', 'detail', '收货地址详情', 0, 72, 50, 1448342090),
(1348, 'module', 3, 'member/addr', 'delete', '删除收货地址', 0, 72, 50, 1448342090),
(1347, 'module', 3, 'member/addr', 'edit', '修改收货地址', 0, 72, 50, 1448342007),
(1341, 'module', 3, 'hongbao/hongbao', 'so', '红包搜索', 0, 72, 50, 1448333318),
(1363, 'menu', 2, '', '', '商品管理', 1, 1362, 50, 1448348347),
(1375, 'module', 3, 'mall/cate', 'create', '添加分类', 0, 1363, 50, 1448350795),
(1365, 'module', 3, 'order/order', 'index', '订单列表', 1, 1344, 1, 1448348861),
(1366, 'module', 3, 'order/order', 'delete', '订单删除', 0, 1344, 50, 1448348861),
(1367, 'module', 3, 'order/order', 'detail', '查看订单', 0, 1344, 50, 1448348861),
(1368, 'module', 3, 'order/order', 'so', '搜索订单', 0, 1344, 50, 1448348861),
(1369, 'menu', 2, '', '', '积分管理', 1, 1362, 50, 1448348905),
(1376, 'menu', 2, '', '', '数据设置', 1, 1, 2, 1448351132),
(1377, 'module', 3, 'data/province', 'index', '省份管理', 1, 1376, 50, 1448351276),
(1378, 'module', 3, 'data/province', 'create', '添加省份', 0, 1376, 50, 1448351276),
(1379, 'module', 3, 'data/province', 'edit', '修改省份', 0, 1376, 50, 1448351276),
(1380, 'module', 3, 'data/province', 'delete', '删除省份', 0, 1376, 50, 1448351276),
(1381, 'module', 3, 'data/city', 'index', '城市管理', 1, 1376, 50, 1448351276),
(1382, 'module', 3, 'data/city', 'create', '添加城市', 0, 1376, 50, 1448351276),
(1383, 'module', 3, 'data/city', 'edit', '修改城市', 0, 1376, 50, 1448351276),
(1384, 'module', 3, 'data/city', 'delete', '删除城市', 0, 1376, 50, 1448351276),
(1385, 'module', 3, 'data/city', 'so', '搜索城市', 0, 1376, 50, 1448351276),
(1386, 'module', 3, 'mall/cate', 'edit', '修改分类', 0, 1363, 50, 1448351599),
(1387, 'module', 3, 'mall/cate', 'delete', '删除分类', 0, 1363, 50, 1448351599),
(1388, 'module', 3, 'mall/cate', 'so', '搜索分类', 0, 1363, 50, 1448351599),
(1389, 'module', 3, 'mall/product', 'create', '添加商品', 0, 1363, 50, 1448353142),
(1390, 'module', 3, 'mall/product', 'edit', '修改分类', 0, 1363, 50, 1448353142),
(1391, 'module', 3, 'mall/product', 'delete', '删除分类', 0, 1363, 50, 1448353142),
(1392, 'module', 3, 'mall/product', 'so', '搜索分类', 0, 1363, 50, 1448353142),
(1393, 'module', 3, 'mall/cate', 'detail', '查看分类', 0, 1363, 50, 1448353208),
(1394, 'module', 3, 'mall/product', 'detail', '查看商品', 0, 1363, 50, 1448353208),
(1395, 'module', 3, 'shop/shop', 'index', '商家列表', 1, 1342, 2, 1448353698),
(1396, 'module', 3, 'shop/shop', 'create', '添加商家', 0, 1342, 50, 1448353698),
(1397, 'module', 3, 'shop/shop', 'edit', '编辑商家', 0, 1342, 50, 1448353698),
(1398, 'module', 3, 'shop/shop', 'delete', '删除商家', 0, 1342, 50, 1448353698),
(1399, 'module', 3, 'shop/shop', 'detail', '查看商家', 0, 1342, 50, 1448353698),
(1400, 'module', 3, 'shop/shop', 'so', '搜索商家', 0, 1342, 50, 1448353698),
(1401, 'module', 3, 'shop/shop', 'audit', '审核商家', 0, 1342, 50, 1448353698),
(1402, 'module', 3, 'shop/account', 'index', '商家账户', 0, 1342, 50, 1448354834),
(1403, 'module', 3, 'shop/cate', 'index', '商家分类', 1, 1342, 1, 1448354834),
(1404, 'module', 3, 'shop/cate', 'create', '添加分类', 0, 1342, 50, 1448354834),
(1405, 'module', 3, 'shop/cate', 'edit', '编辑分类', 0, 1342, 50, 1448354834),
(1406, 'module', 3, 'shop/cate', 'delete', '删除分类', 0, 1342, 50, 1448354834),
(1407, 'module', 3, 'mall/order', 'index', '兑换列表', 1, 1369, 50, 1448354982),
(1408, 'module', 3, 'mall/order', 'so', '搜索兑换', 0, 1369, 50, 1448355182),
(1409, 'module', 3, 'shop/comment', 'index', '商家评价', 1, 1342, 3, 1448357795),
(1410, 'module', 3, 'shop/comment', 'delete', '删除评价', 0, 1342, 50, 1448357795),
(1411, 'module', 3, 'shop/comment', 'detail', '查看评价', 0, 1342, 50, 1448357795),
(1412, 'module', 3, 'shop/log', 'index', '商家日志', 1, 1342, 4, 1448357795),
(1413, 'module', 3, 'shop/tixian', 'index', '商家提现', 1, 1342, 5, 1448357795),
(1414, 'module', 3, 'shop/tixian', 'doaudit', '提现审核', 0, 1342, 50, 1448357795),
(1415, 'module', 3, 'shop/tixian', 'reason', '退回提现', 0, 1342, 50, 1448357795),
(1416, 'module', 3, 'shop/shop', 'dialog', '选择商户', 0, 1343, 50, 1448431799),
(1417, 'module', 3, 'product/product', 'shop', '商家商品', 0, 1342, 50, 1448434149),
(1418, 'module', 3, 'product/product', 'create', '添加商品', 0, 1342, 50, 1448434149),
(1419, 'module', 3, 'product/product', 'edit', '编辑商品', 0, 1342, 50, 1448434149),
(1420, 'module', 3, 'product/product', 'delete', '删除商品', 0, 1342, 50, 1448434149),
(1421, 'module', 3, 'order/log', 'so', '搜索日志', 0, 1344, 50, 1448435972),
(1422, 'module', 3, 'shop/youhui', 'index', '商家优惠', 0, 1342, 50, 1448519148),
(1423, 'module', 3, 'shop/youhui', 'create', '添加优惠', 0, 1342, 50, 1448519148),
(1424, 'module', 3, 'shop/youhui', 'edit', '编辑优惠', 0, 1342, 50, 1448519148),
(1425, 'module', 3, 'shop/youhui', 'delete', '删除优惠', 0, 1342, 50, 1448519148),
(1426, 'module', 3, 'order/complaint', 'index', '订单投诉', 1, 1344, 50, 1448681002),
(1427, 'module', 3, 'order/complaint', 'delete', '删除投诉', 0, 1344, 50, 1448681002),
(1453, 'module', 3, 'shop/comment', 'edit', '修改评价', 0, 1342, 50, 1451369995),
(1429, 'module', 3, 'system/config', 'invite', '好友邀请', 1, 269, 50, 1449481112),
(1430, 'menu', 2, '', '', '文章管理', 1, 5, 20, 1450143779),
(1431, 'module', 3, 'article/cate', 'index', '文章分类', 1, 1430, 1, 1450143874),
(1432, 'module', 3, 'article/cate', 'create', '添加分类', 0, 1430, 50, 1450143874),
(1433, 'module', 3, 'article/cate', 'edit', '编辑分类', 0, 1430, 50, 1450143874),
(1434, 'module', 3, 'article/cate', 'delete', '删除分类', 0, 1430, 50, 1450143874),
(1435, 'module', 3, 'article/article', 'index', '文章列表', 1, 1430, 2, 1450144179),
(1436, 'module', 3, 'article/article', 'create', '添加文章', 0, 1430, 50, 1450160838),
(1437, 'module', 3, 'article/article', 'edit', '编辑文章', 0, 1430, 50, 1450160838),
(1438, 'module', 3, 'article/article', 'delete', '删除文章', 0, 1430, 50, 1450160838),
(1439, 'menu', 2, '', '', '帮助中心', 1, 5, 30, 1450160899),
(1440, 'menu', 2, '', '', '关于我们', 1, 5, 40, 1450160918),
(1441, 'module', 3, 'article/help', 'index', '帮助管理', 1, 1439, 1, 1450161189),
(1442, 'module', 3, 'article/help', 'create', '添加帮助', 0, 1439, 50, 1450161189),
(1443, 'module', 3, 'article/help', 'edit', '编辑帮助', 0, 1439, 50, 1450161189),
(1444, 'module', 3, 'article/help', 'delete', '删除帮助', 0, 1439, 50, 1450161189),
(1445, 'module', 3, 'article/help', 'so', '搜索帮助', 0, 1439, 50, 1450161189),
(1446, 'module', 3, 'article/about', 'index', '内容列表', 1, 1440, 1, 1450161332),
(1447, 'module', 3, 'article/about', 'create', '添加内容', 0, 1440, 50, 1450161332),
(1448, 'module', 3, 'article/about', 'edit', '编辑内容', 0, 1440, 50, 1450161332),
(1449, 'module', 3, 'article/about', 'delete', '删除内容', 0, 1440, 50, 1450161332),
(1450, 'module', 3, 'article/about', 'so', '搜索内容', 0, 1440, 50, 1450161332),
(1451, 'module', 3, 'article/cate', 'update', '更新分类', 0, 1430, 50, 1450162157),
(1452, 'module', 3, 'system/config', 'jifen', '积分设置', 1, 269, 50, 1451275113),
(1457, 'module', 3, 'staff/verify', 'so', '搜索认证', 0, 1305, 50, 1451392938),
(1454, 'module', 3, 'staff/verify', 'index', '实名认证', 1, 1305, 50, 1451383593),
(1455, 'module', 3, 'staff/verify', 'doaudit', '审核认证', 0, 1305, 50, 1451383593),
(1456, 'module', 3, 'staff/verify', 'refuse', '拒绝认证', 0, 1305, 50, 1451383593),
(1458, 'module', 3, 'staff/verify', 'detail', '查看认证', 0, 1305, 50, 1451393413),
(1459, 'module', 3, 'order/complaint', 'detail', '查看投诉', 0, 1344, 50, 1451439442),
(1460, 'module', 3, 'staff/msg', 'index', '消息管理', 1, 1305, 50, 1451454957),
(1461, 'module', 3, 'staff/msg', 'detail', '查看消息', 0, 1305, 50, 1451454957),
(1462, 'module', 3, 'staff/msg', 'edit', '修改消息', 0, 1305, 50, 1451454957),
(1463, 'module', 3, 'staff/msg', 'so', '搜索消息', 0, 1305, 50, 1451454957),
(1464, 'module', 3, 'staff/msg', 'delete', '删除消息', 0, 1305, 50, 1451454957),
(1465, 'module', 3, 'member/message', 'detail', '查看消息', 0, 951, 50, 1451480119),
(1466, 'module', 3, 'staff/staff', 'dialog', '选择配送人员', 0, 1305, 50, 1451481147),
(1467, 'module', 3, 'shop/comment', 'reply', '评价回复', 0, 1342, 50, 1451528483),
(1468, 'module', 3, 'order/complaint', 'reply', '投诉回复', 0, 1344, 50, 1451547317),
(1469, 'module', 3, 'shop/verify', 'index', '商户认证', 1, 1342, 50, 1451547150),
(1470, 'module', 3, 'shop/verify', 'detail', '查看认证', 0, 1342, 50, 1451547150),
(1471, 'module', 3, 'shop/verify', 'update', '更新认证', 0, 1342, 50, 1451547150),
(1472, 'module', 3, 'mall/order', 'deliver', '订单发货', 0, 1369, 50, 1451552755),
(1473, 'module', 3, 'mall/order', 'delete', '删除订单', 0, 1369, 50, 1451552755),
(1474, 'module', 3, 'mall/order', 'detail', '查看订单', 0, 1369, 50, 1451552755),
(1475, 'module', 3, 'shop/shop', 'manage', '管理商家', 0, 1342, 50, 1451887956),
(1507, 'module', 3, 'shop/shop', 'recycle', '商家回收站', 1, 1342, 50, 1455940160),
(1477, 'module', 3, 'order/order', 'cancel', '取消订单', 0, 1344, 50, 1451973018),
(1478, 'module', 3, 'order/order', 'accept', '接单', 0, 1344, 50, 1451975018),
(1479, 'module', 3, 'order/order', 'peisong', '配送开始', 0, 1344, 50, 1451976837),
(1480, 'module', 3, 'order/order', 'finish', '订单完成', 0, 1344, 50, 1451977245),
(1481, 'module', 3, 'shop/cate', 'update', '更新排序', 0, 1342, 50, 1452043594),
(1482, 'module', 3, 'member/invite', 'index', '会员返利', 1, 72, 50, 1452823418),
(1483, 'module', 3, 'order/order', 'tongji', '订单统计', 1, 1344, 50, 1452837169),
(1484, 'module', 3, 'order/order', 'checkout', '订单结算', 1, 1344, 50, 1452837169),
(1485, 'module', 3, 'staff/msg', 'create', '添加消息', 0, 1305, 50, 1452909864),
(1486, 'module', 3, 'shop/verify', 'delete', '删除认证', 0, 1342, 50, 1452910543),
(1487, 'module', 3, 'shop/verify', 'so', '搜索认证', 0, 1342, 50, 1452910962),
(1488, 'module', 3, 'order/order', 'export', '导出订单', 0, 1344, 50, 1452936917),
(1489, 'module', 3, 'order/order', 'checkbill', '对账单', 0, 1344, 50, 1453083569),
(1490, 'module', 3, 'order/order', 'exportform', '导出报表', 0, 1344, 50, 1453105799),
(1491, 'module', 3, 'order/order', 'dashboard', '今日汇总', 1, 1344, 50, 1453190815),
(1493, 'module', 3, 'system/config', 'app_download', 'APP版本', 1, 269, 50, 1453277651),
(1494, 'module', 3, 'order/order', 'neworder', '今日新单', 0, 1344, 50, 1453283512),
(1495, 'module', 3, 'order/order', 'newshop', '商户提现', 0, 1344, 50, 1453283512),
(1496, 'module', 3, 'order/order', 'stafftx', '配送提现', 0, 1344, 50, 1453283512),
(1497, 'module', 3, 'order/order', 'shoptx', '商户申请', 0, 1344, 50, 1453283512),
(1498, 'module', 3, 'paotui/paotui', 'index', '跑腿订单', 1, 1514, 2, 1453348218),
(1499, 'module', 3, 'paotui/log', 'index', '跑腿日志', 0, 1514, 50, 1453348218),
(1500, 'module', 3, 'paotui/paotui', 'detail', '查看订单', 0, 1514, 50, 1453452774),
(1501, 'module', 3, 'paotui/paotui', 'delete', '删除订单', 0, 1514, 50, 1453452816),
(1502, 'module', 3, 'paotui/paotui', 'export', '导出订单', 0, 1514, 50, 1453457100),
(1503, 'module', 3, 'paotui/paotui', 'cancel', '取消订单', 0, 1514, 50, 1453515032),
(1504, 'module', 3, 'system/config', 'paotui', '跑腿配置', 1, 1514, 1, 1453878786),
(1505, 'module', 3, 'shop/verify', 'edit', '商户审核', 0, 1342, 50, 1454467568),
(1506, 'module', 3, 'shop/verify', 'edit', '商户审核', 0, 1342, 50, 1455525604),
(1508, 'module', 3, 'shop/shop', 'regain', '商家恢复', 0, 1342, 50, 1455948859),
(1509, 'module', 3, 'order/order', 'paidan', '派单管理', 1, 1344, 50, 1458011287),
(1510, 'module', 3, 'order/order', 'quxiaopei', '取消配送', 0, 1344, 50, 1458011287),
(1511, 'module', 3, 'order/order', 'dopaidan', '配单配送', 0, 1344, 2, 1458011287),
(1512, 'module', 3, 'staff/staff', 'paiorder', '派单订单', 0, 1305, 50, 1458201936),
(1513, 'module', 3, 'paotui/paotui', 'paidan', '派单管理', 1, 1514, 3, 1458287637),
(1514, 'menu', 2, '', '', '跑腿管理', 1, 71, 50, 1458287656),
(1515, 'module', 3, 'paotui/paotui', 'dopaidan', '配送派单', 0, 1514, 50, 1458555270),
(1516, 'module', 3, 'staff/staff', 'paipaotui', '派单跑腿', 0, 1305, 50, 1458557243),
(1517, 'module', 3, 'system/config', 'moneypack', '充值配置', 1, 269, 50, 1459932870),
(1518, 'module', 3, 'system/config', 'rongcloud', '融云接口', 1, 269, 50, 1465961193);

-- --------------------------------------------------------

--
-- 表的结构 `jh_themes`
--

CREATE TABLE IF NOT EXISTS `jh_themes` (
  `theme_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `theme` varchar(50) DEFAULT '',
  `title` varchar(50) DEFAULT '',
  `thumb` varchar(150) DEFAULT '',
  `config` mediumtext,
  `default` tinyint(1) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`theme_id`),
  KEY `theme` (`theme`,`default`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `jh_themes`
--

INSERT INTO `jh_themes` (`theme_id`, `theme`, `title`, `thumb`, `config`, `default`, `dateline`) VALUES
(1, 'default', '默认模板', 'thumb.jpg', NULL, 0, 0),
(2, 'ele', 'ele模板', 'thumb.jpg', NULL, 1, 1474455758);

-- --------------------------------------------------------

--
-- 表的结构 `jh_upload_photo`
--

CREATE TABLE IF NOT EXISTS `jh_upload_photo` (
  `photo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) DEFAULT '0',
  `from` varchar(30) DEFAULT '',
  `hash` char(32) DEFAULT '',
  `name` varchar(255) DEFAULT '',
  `photo` varchar(150) DEFAULT '',
  `size` smallint(6) DEFAULT '0',
  `dateline` int(10) DEFAULT '0',
  PRIMARY KEY (`photo_id`),
  KEY `hash` (`hash`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=63 ;

--
-- 转存表中的数据 `jh_upload_photo`
--

INSERT INTO `jh_upload_photo` (`photo_id`, `uid`, `from`, `hash`, `name`, `photo`, `size`, `dateline`) VALUES
(1, 0, 'config', '4a60fefbd630e3c85e6f8eec57397ca9', '1024x1024.png', 'photo/201609/20160902_7793FD5385937C247B9089982419A330.png', 22757, 1472806691),
(2, 0, 'config', '9a9ecc600f9ce20313419a40d9ecf9d0', '用户端.png', 'photo/201609/20160903_2773F88E74A73F4C914E08B03525D856.png', 6087, 1472895180),
(3, 0, 'config', 'fad07d5a12f340dd1c03dc07b8f91d1f', '用户端.jpg', 'photo/201609/20160903_14333FAFEC1CFA85CB8ADC3659FDE3F3.jpg', 32767, 1472897293),
(4, 0, 'config', '0e327fec3f369555db9d60bb1cd0dc51', '用户端.jpg', 'photo/201609/20160903_DBAED93D1431B95417E6C066847E60ED.jpg', 32767, 1472897538),
(5, 0, 'shop', 'fb171edd11af73ee92f50f8d06925787', 'Food_Dome_48px_1185119_easyicon.net.jpg', 'photo/201609/20160907_630B95BC465869E98EB7BD7E602F132F.jpg', 29416, 1473179431),
(6, 0, 'config', '0ff0972e1cba5c1c17afccf0688c8068', 'Food_Dome_48px_1185119_easyicon.net.png', 'photo/201609/20160907_AEC4DC2971BE10C9429D2516684A91CD.png', 2694, 1473213326),
(7, 0, 'config', '750179f67ddcca55689565885f7e1783', '11.png', 'photo/201609/20160907_7EE1EFEAB102BD42200CAEA0B37DF9FC.png', 32767, 1473213783),
(8, 0, 'config', 'dd97c958159defc60270eac26cd5239d', '22.png', 'photo/201609/20160907_EAD69FA88A9A3DD1BBA4ACD73714CFE3.png', 32767, 1473214015),
(9, 0, 'config', '2916a2c91bf63f3ccdd87676af5390c6', '33.png', 'photo/201609/20160907_B1A6C1321132795EEE6660B2964FD75F.png', 32767, 1473215006),
(10, 0, 'config', 'b3ee7151fe38941c2b814c9c1075ab96', '22.png', 'photo/201609/20160907_6806EB3D80F8810982A8B12C761260E5.png', 32767, 1473215098),
(11, 0, 'photo', 'a6878c8bac7e080d8d514c5c537b585d', 'logo.jpeg', 'photo/201609/20160928_D39BBC3194EBFBF86DCD76348A6C1E83.jpeg', 1964, 1475055316),
(12, 0, 'photo', '0a597f1f3fdbe42eef4730338e80acbf', '1.jpeg', 'photo/201609/20160928_EA274ABC73B586ECA04013A44941C0C4.jpeg', 28021, 1475055861),
(13, 0, 'photo', 'b8f045953a12d92fa2b16c2289afa9ec', '2.jpeg', 'photo/201609/20160928_B06F84CB6191F04FE5F1FE1F337405D5.jpeg', 28021, 1475056112),
(14, 0, 'photo', 'ea05bd98d9632d331f77786ba36ee9e0', '2.jpeg', 'photo/201609/20160928_DB9E71F6E274DD5E27DA373F43122B49.jpeg', 28021, 1475056167),
(15, 0, 'photo', '4a4bc896eddd8dacdb6b93ac0c2e058d', '2.jpeg', 'photo/201609/20160928_23C92C9D685BE5B5A52CE14B33355AC0.jpeg', 18082, 1475056198),
(16, 0, 'photo', 'f809b913fad4db02acad8127daf3518f', '3.jpeg', 'photo/201609/20160928_1BDFF4D16E94C19243F790B189902E9F.jpeg', 20788, 1475056254),
(17, 0, 'photo', 'a94d2db3383d79092c9ddebcc7d53881', '4.jpeg', 'photo/201609/20160928_A85EB96B578D94ECF38397D148B58522.jpeg', 4124, 1475056340),
(18, 0, 'photo', 'e09e95ff9b37b7ef24bc2043c5a5b751', '5.jpeg', 'photo/201609/20160928_BB5CC5FA9E24F1E574F26DA29D6AD385.jpeg', 27172, 1475056426),
(19, 0, 'photo', 'e2a810b67dc0cba8cdbf403d642010ce', '6.jpeg', 'photo/201609/20160928_60C75703F9BBF5F9F19407B1579D1EB4.jpeg', 27172, 1475056518),
(20, 0, 'config', 'dcfb44b442b14f4068f064ff95500bfb', 'logo.jpg', 'photo/201609/20160928_262840060EF75DAFC78C701495CA5406.jpg', 22072, 1475061247),
(21, 0, 'config', '8b31173ba0c9713f22aba2009e0efc4c', 'logo.png', 'photo/201609/20160928_25441CAFB0366F91D1E5C7D2A8929E85.png', 32767, 1475061556),
(22, 0, 'config', '6918824212a76a519dd918de989924ca', '3.png', 'photo/201609/20160928_ECEB6B903E5451C1A496FEA014C0A73F.png', 32767, 1475062115),
(23, 0, 'config', '32fa9d12ee9f417b62c88eed1fb97766', '3.png', 'photo/201609/20160928_21456401F61607CBAD759F5DECDB6EE6.png', 32767, 1475062320),
(24, 0, 'config', '55ab3acc9d4c5da845846844bb51c186', '3.png', 'photo/201609/20160928_E66B1371C3BBFE3E19FD9035F723715B.png', 32767, 1475062495),
(25, 0, 'config', '10cc9af2deb3a3ee6c57eb58b132a07a', '3.png', 'photo/201609/20160928_8086E72AFE51B5F62D13FFDD3FA7726C.png', 32767, 1475062675),
(26, 0, 'config', 'c16248b8f0dc4cbd244b112df9f95fd7', '3.png', 'photo/201609/20160928_8DB0F3A1DE18E0219674B5F17002B71B.png', 32767, 1475062778),
(27, 0, 'config', '7856188c1256c2f00f74b5892d9fb806', 'logoindex.png', 'photo/201609/20160928_85A438BB10217E22E4B0CE49881E2EA7.png', 32767, 1475063303),
(28, 0, 'config', 'b8ce6a81b2ef13c3ec901b0f83b32130', 'logoindex.png', 'photo/201609/20160928_8D63550D0A7D9DC4D93D025DA79519AC.png', 32767, 1475063332),
(29, 0, 'payment', '9819982888bba7205569291d84010360', 'T1HHFgXXVeXXXXXXXX.png', 'photo/201609/20160929_FA66323A026F07C9EED5459FA29F8238.png', 5222, 1475133912),
(30, 0, 'payment', 'faf1631bfc0a7022715135439580459f', 'alipay.png', 'photo/201609/20160929_E100C0D6963D19D3F08514BDE2055CE5.png', 5222, 1475133947),
(31, 0, 'article', 'eb6fe8007817dc6cdff136ef8a86d70e', '状元.jpg', 'photo/201609/20160930_EF82EDDAA0EBA8D22D83DD9CD6F91BC3.jpg', 32767, 1475215092),
(32, 0, 'shop', '098eb003bdbc6fd9a1e48cc7d19432b1', '20160913171631.jpg', 'photo/201610/20161009_6466DB66A69085DD02D928D04CD89E0A.jpg', 32767, 1476004350),
(33, 0, 'payment', 'fb313e299a3ba91b4275ecc4dda51971', 'wxpay.png', 'photo/201610/20161011_87DAEC97B609B73A7554506A2E3158A6.png', 32767, 1476153567),
(34, 0, 'editor', '37dbb8034c3e94a0dfc90acac5cc0f92', 'Screenshot_2016-10-11-16-22-33-691_com.tencent.mm.png', 'photo/201610/20161011_09119E7DA08AE5A7464148AF0D8AF2DE.png', 32767, 1476196655),
(35, 0, 'editor', 'e091e805016f068736a67352eba6018b', 'Screenshot_2016-10-11-16-22-33-691_com.tencent.mm.png', 'photo/201610/20161011_B4391114888E62F0DA67BEC5A997B0D3.png', 32767, 1476196655),
(36, 0, 'editor', '31b2e4f2739ea3a55a8c8b6679311a4a', 'Screenshot_2016-10-11-16-22-33-691_com.tencent.mm.png', 'photo/201610/20161011_76265E19227098762EF85A95B38CCF4C.png', 32767, 1476196674),
(37, 0, 'editor', 'f7932b5cb067df170e5ed54efb58e193', 'Screenshot_2016-10-11-16-22-33-691_com.tencent.mm.png', 'photo/201610/20161011_34BBE95B766CF9D390C71D296512D5A0.png', 32767, 1476196684),
(38, 0, 'photo', '3065aac113aec22a53d9d5d920639e63', 'Screenshot_2016-10-09-16-51-35-195_com.tencent.mm.png', 'photo/201610/20161012_6A6920D48E8DE0318F9FC4CCBB00BBC2.png', 32767, 1476232719),
(39, 0, 'product', 'e9b76fbef86f0a6b5e0229e21c6c5997', 'Screenshot_2016-10-12-18-11-11-646_com.tencent.mm.png', 'photo/201610/20161014_6954F356D07B9E4B5E4B212E6613D19A.png', 32767, 1476384342),
(40, 0, 'car', '5d2be56146c3b8aa96c6d42c875b9c91', 'mmexport1476179678453.jpg', 'photo/201610/20161018_09BF9465CA39C1F2177ECC6D7632B958.jpg', 21353, 1476784921),
(41, 0, 'editor', 'ba0277e5b3f71efd6ec69663024c8913', 'Picture_01_Shark.jpg', 'photo/201610/20161020_E342D0E37F9E318B45FF5FE6E34D2EA2.jpg', 32767, 1476932605),
(42, 0, 'editor', 'aa37516613e842fe61224bd7572c2cde', 'id_photo.png', 'photo/201611/20161119_1521CD009C80E35C52A371377373995C.png', 32767, 1479519766),
(43, 0, 'editor', 'c48e312336b5c0aee1bbfdb73f5ccab8', 'id_photo.png', 'photo/201611/20161119_21146D4245D365AAE9E742995FA2B707.png', 32767, 1479519801),
(44, 0, 'payment', 'd6c60d792cf8b79f65255e07d182f6cb', '2015713162639.png', 'photo/201612/20161206_8F8FEC58D1571263566E9381F6244831.png', 12603, 1480990258),
(45, 0, 'product', 'c22c73e95a87b708a5ea10ba04ecb7e8', '05192016072901.png', 'photo/201612/20161206_14F93F5CC993E7AD9FD11899A5724721.png', 32767, 1481003246),
(46, 0, 'photo', 'ad263e31e1fd78806d9d8e9d3c354697', '200.jpg', 'photo/201612/20161206_2A3D27BD22F78130E1371FE219EB3302.jpg', 3499, 1481016655),
(47, 0, 'product', 'ad1de3dd918c9551a3a931b191b4c5e8', '200.jpg', 'photo/201612/20161206_56C300F3A5D8AC46FBD60D796A11B0D6.jpg', 3499, 1481016978),
(48, 0, 'config', '2dfa7b4156548f3d4b0f792309bf4ee8', '20160612212056536.png', 'photo/201612/20161211_FE52644623A6C3FADA73051A04EE568B.png', 2303, 1481425573),
(49, 0, 'config', 'e6a31becf5b9b5cfaa1ae8ed6bbf613a', 'user-default-avatar.png', 'photo/201612/20161211_6A7E87810029DBF8CB4522524BBFBD38.png', 1602, 1481425573),
(50, 0, 'config', '5e5aab663315210e8796167cf25375c7', '20160612212056536.png', 'photo/201612/20161211_8261563A08AA03EF9D9D0D6340D52AA0.png', 2303, 1481425594),
(51, 0, 'config', 'e6d5b8ab39b790e9987bb9accc0780fc', '20160612212056536.png', 'photo/201612/20161211_C627463B780B94F32CF6CF8AA6E11B33.png', 2303, 1481425676),
(52, 0, 'config', 'd8ffd1c51c355296e4284fe3c1847f35', '20160110153942795.png', 'photo/201612/20161211_C6A07A4E5C28D0EE17914D2019A88561.png', 8889, 1481425736),
(53, 0, 'config', '30adfaadd66961d708d7c1eb3a738777', '20160110153942795.png', 'photo/201612/20161211_88BA34795015BB9DC9353BCDC5B37DDD.png', 8889, 1481425863),
(54, 0, 'config', 'b0e73d9e4867ddf53bd56df969f945d5', '568c378107906a.png', 'photo/201612/20161211_7745185EB6EEA19BA281EE75E773FAEA.png', 32767, 1481425968),
(55, 0, 'config', '350cb34c9ad7bc06965cc5779e5b4294', '20160612212056536.png', 'photo/201612/20161211_CD958AFC2A6712F10613634750CFBD70.png', 2303, 1481426027),
(56, 0, 'adv', 'fdd59bab962c50ce66c6f28e81703c5a', 'dd.asa;.jpg', 'photo/201612/20161211_A7F83D697D71BCDBEAC64F9CAE3D12B0.jpg', 32767, 1481426749),
(57, 0, 'config', 'f4d7cc6ebd67b7c27ff52b04a5267fb6', '20160612212056536.png', 'photo/201612/20161211_E2AA3C91C5778C2DED8EC1899CF49464.png', 2303, 1481439162),
(58, 0, 'adv', '8e8a30c66a5d77ae6fbcc4b85062183f', '20160110153942795.png', 'photo/201612/20161211_7BF4FEDB45ED2D00A654C0E7A8D85ADF.png', 8889, 1481440124),
(59, 0, 'photo', 'b3886d16f30ecd838faeafc167d1a956', '22.jpg', 'photo/201612/20161211_9152CDD8347C991F2A05DAF9AD1AD061.jpg', 8872, 1481440493),
(60, 0, 'shop', '9292093fbe01141efcf3c1fbca3820da', 'preview.jpg', 'photo/201704/20170430_BDDE6A66B8517376D6BDF4C785E9900B.jpg', 32767, 1493533752),
(61, 0, 'shop', '4aea09d7578f4101aa03fec279bb8032', 'preview.jpg', 'photo/201704/20170430_5054246C85053D4B8C21B82EA957E7CC.jpg', 32767, 1493533763),
(62, 0, 'shop', 'f4ffdf8e3dd45f1f79b0c2d7c78eddf4', 'preview.jpg', 'photo/201704/20170430_D5E9DB35B8F3C59C0CA1017A4C95891A.jpg', 32767, 1493533769);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
