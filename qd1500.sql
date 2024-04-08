-- MySQL dump 10.13  Distrib 5.6.50, for Linux (x86_64)
--
-- Host: localhost    Database: qd1500_jglgs_com
-- ------------------------------------------------------
-- Server version	5.6.50-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `ysk_admin`
--

DROP TABLE IF EXISTS `ysk_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'UID',
  `auth_id` int(11) NOT NULL DEFAULT '1' COMMENT '角色ID',
  `nickname` varchar(63) DEFAULT NULL COMMENT '昵称',
  `username` varchar(31) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(63) NOT NULL DEFAULT '' COMMENT '密码',
  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `reg_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  `reg_type` varchar(20) DEFAULT NULL COMMENT '注册人',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='后台管理员表格';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_admin`
--

LOCK TABLES `ysk_admin` WRITE;
/*!40000 ALTER TABLE `ysk_admin` DISABLE KEYS */;
INSERT INTO `ysk_admin` VALUES (1,1,'超级管理员','admin','8f3bd6b4d00391c9d09cc14e32fee28c','',0,1691651748,1691651748,1,'');
/*!40000 ALTER TABLE `ysk_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_bankcard`
--

DROP TABLE IF EXISTS `ysk_bankcard`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_bankcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL COMMENT 'uid',
  `name` varchar(225) NOT NULL COMMENT '持卡人',
  `bankname` varchar(225) NOT NULL COMMENT '所属银行',
  `banknum` varchar(225) NOT NULL COMMENT '银行卡号',
  `addtime` varchar(225) NOT NULL COMMENT '添加时间',
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 银行卡  1支付宝',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='银行卡管理';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_bankcard`
--

LOCK TABLES `ysk_bankcard` WRITE;
/*!40000 ALTER TABLE `ysk_bankcard` DISABLE KEYS */;
INSERT INTO `ysk_bankcard` VALUES (10,210,'','','TCL7CFGXQJTsruZBhpej5LHg9NVuarXoQD','1691911969',0);
/*!40000 ALTER TABLE `ysk_bankcard` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_cdkey`
--

DROP TABLE IF EXISTS `ysk_cdkey`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_cdkey` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) DEFAULT NULL COMMENT '会员ID',
  `cdkey` varchar(225) NOT NULL COMMENT 'key',
  `status` int(1) NOT NULL DEFAULT '0',
  `addtime` int(11) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='key';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_cdkey`
--

LOCK TABLES `ysk_cdkey` WRITE;
/*!40000 ALTER TABLE `ysk_cdkey` DISABLE KEYS */;
/*!40000 ALTER TABLE `ysk_cdkey` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_complaint`
--

DROP TABLE IF EXISTS `ysk_complaint`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_complaint` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL COMMENT '投诉人id',
  `content` text CHARACTER SET utf8mb4 COMMENT '投诉内容',
  `imgs` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '图片路径',
  `status` tinyint(1) DEFAULT '0' COMMENT '0 未查看 1 已查看',
  `create_time` int(10) DEFAULT NULL COMMENT '投诉时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='投诉建议表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_complaint`
--

LOCK TABLES `ysk_complaint` WRITE;
/*!40000 ALTER TABLE `ysk_complaint` DISABLE KEYS */;
/*!40000 ALTER TABLE `ysk_complaint` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_config`
--

DROP TABLE IF EXISTS `ysk_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '配置标题',
  `name` varchar(32) DEFAULT NULL COMMENT '配置名称',
  `value` text NOT NULL COMMENT '配置值',
  `group` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '配置分组',
  `type` varchar(16) NOT NULL DEFAULT '' COMMENT '配置类型',
  `options` varchar(255) NOT NULL DEFAULT '' COMMENT '配置额外值',
  `tip` varchar(100) NOT NULL DEFAULT '' COMMENT '配置说明',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `sort` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统配置表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_config`
--

LOCK TABLES `ysk_config` WRITE;
/*!40000 ALTER TABLE `ysk_config` DISABLE KEYS */;
INSERT INTO `ysk_config` VALUES (1,'站点开关','TOGGLE_WEB_SITE','1',3,'0','0:关闭\r\n1:开启','商城建设中......',1378898976,1406992386,1,1),(2,'网站标题','WEB_SITE_TITLE','',1,'0','','网站标题前台显示标题',1378898976,1379235274,2,1),(3,'网站LOGO','WEB_SITE_LOGO','',1,'0','','网站LOGO',1407003397,1407004692,3,1),(4,'网站描述','WEB_SITE_DESCRIPTION','',1,'0','','网站搜索引擎描述',1378898976,1379235841,4,1),(5,'网站关键字','WEB_SITE_KEYWORD','',1,'0','','网站搜索引擎关键字',1378898976,1381390100,5,1),(6,'版权信息','WEB_SITE_COPYRIGHT','',1,'0','','设置在网站底部显示的版权信息，如“版权所有 (c) 2020 科斯克网络科技”',1406991855,1406992583,6,1),(7,'网站备案号','WEB_SITE_ICP','',1,'0','','设置在网站底部显示的备案号，如“苏ICP备1502009号\"',1378900335,1415983236,9,1),(26,'微信二维码','WEB_SITE_WX','',1,'','','',0,0,0,1),(32,'注册开关','close_reg','1',3,'','0:关闭1:开启','关闭注册功能说明',0,0,12,1),(33,'交易开关','close_trading','1',3,'','0:关闭1:开启','交易暂时关闭，16:00后开启',0,0,13,0),(41,'实时价格每分钟增长','growem','',2,'','','',0,0,12,1),(44,'奖励开关','regjifen','0',1,'0','','',1407003397,1407004692,3,1);
/*!40000 ALTER TABLE `ysk_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_ewm`
--

DROP TABLE IF EXISTS `ysk_ewm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_ewm` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '记录id',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `ewm_class` int(11) NOT NULL COMMENT '二维码类型',
  `ewm_url` varchar(225) NOT NULL COMMENT '二维码地址',
  `ewm_price` varchar(255) NOT NULL COMMENT '二维码收款金额 改 支付宝昵称',
  `ewm_acc` varchar(225) NOT NULL COMMENT '二维码账号',
  `uaccount` varchar(225) NOT NULL COMMENT '用户账号',
  `uname` varchar(225) NOT NULL COMMENT '用户名',
  `addtime` varchar(225) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='二维码管理';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_ewm`
--

LOCK TABLES `ysk_ewm` WRITE;
/*!40000 ALTER TABLE `ysk_ewm` DISABLE KEYS */;
/*!40000 ALTER TABLE `ysk_ewm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_group`
--

DROP TABLE IF EXISTS `ysk_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_group` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '部门ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级部门ID',
  `title` varchar(31) NOT NULL DEFAULT '' COMMENT '部门名称',
  `icon` varchar(31) NOT NULL DEFAULT '' COMMENT '图标',
  `menu_auth` text NOT NULL COMMENT '权限列表',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '排序（同级有效）',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  `auth_id` int(11) DEFAULT NULL,
  `hylb` varchar(10) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='部门信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_group`
--

LOCK TABLES `ysk_group` WRITE;
/*!40000 ALTER TABLE `ysk_group` DISABLE KEYS */;
INSERT INTO `ysk_group` VALUES (1,0,'超级管理员','','',1691651748,1691651748,0,1,1,'0'),(2,0,'财务查看','','1,7,8,9,337,10,11,316,341,340,344,324,342,322,338,3,323,347',1498324367,1551095515,0,1,2,'5'),(7,0,'超级管理','','1,3,4,6,327,7,8,9,316,318,322,323',1526152893,1528963727,0,-1,0,''),(8,0,'数据管理','','1,3,4,327,7,8,10,11,315,324,325,334,329,328',1527085184,1527140823,0,-1,0,'0'),(9,0,'平台客服微信','','8',1574255538,1576466013,50,-1,NULL,''),(11,0,'客服','','1,7,8,9,362,348,349,350,351,359,352,353,360,356,357,3,5,323',1576466067,1576466067,1,1,NULL,'1,2,3,4,5');
/*!40000 ALTER TABLE `ysk_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_menu`
--

DROP TABLE IF EXISTS `ysk_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL COMMENT '菜单名称',
  `pid` int(11) NOT NULL COMMENT '父级id',
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '爷爷ID、',
  `col` varchar(30) NOT NULL COMMENT '控制器',
  `act` varchar(30) NOT NULL COMMENT '方法',
  `patch` varchar(50) DEFAULT NULL COMMENT '全路径',
  `level` int(11) NOT NULL COMMENT '级别',
  `icon` varchar(50) DEFAULT NULL,
  `sort` char(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=363 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_menu`
--

LOCK TABLES `ysk_menu` WRITE;
/*!40000 ALTER TABLE `ysk_menu` DISABLE KEYS */;
INSERT INTO `ysk_menu` VALUES (327,'数据库管理',3,1,'Database','index','',2,'fa fa-lock','14',0),(323,'系统公告',3,1,'News','index','',2,'fa-twitter-square','51',1),(356,'工作成功列表',352,1,'Roborder','ordersucc','',2,'fa-file-text','41',1),(355,'匹配成功列表',352,1,'Roborder','robsucc','',2,'fa-file-text','40',0),(354,'会员抢单列表',352,1,'Roborder','userrob','',2,'fa-file-text','39',0),(1,'系统',0,0,'','','',0,'fa-cog','0',1),(9,'推荐结构',7,1,'Tree','index','',2,'fa-th-large','22',1),(8,'会员列表',7,1,'User','index','',2,'fa-user','21',1),(7,'会员管理',1,1,'','','',1,'fa-folder-open-o','1',1),(5,'角色管理',3,1,'Group','index','',2,'fa-sitemap','12',1),(3,'统用功能',1,1,'','','',1,'fa-folder-open-o','3',1),(352,'工作管理',1,1,'','','',1,'fa-folder-open-o','2',1),(353,'发布订单列表',352,1,'Roborder','index','',2,'fa-user','38',1),(357,'工作参数设置',352,1,'Roborder','asystem','',2,'fa-file-text','43',1),(351,'银行卡管理',7,1,'User','bankcard','',2,'fa-file-text','37',1),(350,'二维码管理',7,1,'User','ewm','',2,'fa-file-text','36',1),(349,'提现管理',7,1,'User','withdraw','',2,'fa-file-text','35',1),(348,'充值管理',7,1,'User','recharge','',2,'fa-file-text','34',1),(358,'收款二维码管理',3,1,'Roborder','skewm','',2,'fa-twitter-square','42',0),(359,'资金流水',7,1,'User','bill','',2,'fa-file-text','43',1),(360,'正在工作列表',352,1,'Roborder','orderwait','',2,'fa-file-text','40',1),(361,'生成注册码',7,1,'User','create_cdk','',2,'fa-user','20',0),(362,'团队管理',7,1,'User','team','',2,'fa-user','22',1);
/*!40000 ALTER TABLE `ysk_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_news`
--

DROP TABLE IF EXISTS `ysk_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '文章标题',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '文章图片',
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `desc` varchar(255) NOT NULL DEFAULT '',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `is_out` tinyint(4) NOT NULL DEFAULT '0',
  `content` text NOT NULL COMMENT '内容',
  `from` varchar(255) NOT NULL DEFAULT '' COMMENT '文章来源',
  `visit` smallint(6) NOT NULL DEFAULT '0',
  `lang` tinyint(4) NOT NULL DEFAULT '0',
  `tuijian` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统公告';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_news`
--

LOCK TABLES `ysk_news` WRITE;
/*!40000 ALTER TABLE `ysk_news` DISABLE KEYS */;
INSERT INTO `ysk_news` VALUES (1,'系统公告','',0,'',1691651748,0,'须弥山系统开发！','',0,0,0);
/*!40000 ALTER TABLE `ysk_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_notice`
--

DROP TABLE IF EXISTS `ysk_notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `notice_tittle` varchar(80) NOT NULL COMMENT '公告标题',
  `notice_content` varchar(600) NOT NULL COMMENT '公告详情',
  `notice_addtime` varchar(20) NOT NULL COMMENT '公告添加时间',
  `notice_read` text NOT NULL COMMENT '看过公告会员',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_notice`
--

LOCK TABLES `ysk_notice` WRITE;
/*!40000 ALTER TABLE `ysk_notice` DISABLE KEYS */;
/*!40000 ALTER TABLE `ysk_notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_qrcode`
--

DROP TABLE IF EXISTS `ysk_qrcode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_qrcode` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `uname` varchar(225) NOT NULL COMMENT '会员名称',
  `code_class` int(2) NOT NULL COMMENT '二维码类型1支付宝2微信3银行卡',
  `code_url` varchar(225) NOT NULL COMMENT '二维码图片地址',
  `uaccount` varchar(225) NOT NULL COMMENT '会员账号',
  `code_acc` varchar(225) NOT NULL COMMENT '二维码账号，如支付宝账号',
  `addtime` varchar(225) NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='二维码管理';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_qrcode`
--

LOCK TABLES `ysk_qrcode` WRITE;
/*!40000 ALTER TABLE `ysk_qrcode` DISABLE KEYS */;
/*!40000 ALTER TABLE `ysk_qrcode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_recharge`
--

DROP TABLE IF EXISTS `ysk_recharge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_recharge` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `account` varchar(225) NOT NULL COMMENT '会员账号',
  `name` varchar(225) NOT NULL COMMENT '姓名',
  `price` float(10,2) NOT NULL COMMENT '充值金额',
  `way` int(11) NOT NULL COMMENT '充值方式：1支付宝2微信3银行卡',
  `addtime` varchar(225) NOT NULL COMMENT '充值日期',
  `status` int(11) NOT NULL COMMENT '充值状态1提交，2退回，3成功',
  `marker` varchar(225) NOT NULL COMMENT '备注',
  `orderid` int(11) NOT NULL,
  `voucher` varchar(255) NOT NULL,
  `conversion` decimal(10,4) NOT NULL COMMENT '比例  1：？',
  `usdt_money` decimal(14,4) NOT NULL COMMENT '可获得usdt金额',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=59 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='会员充值表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_recharge`
--

LOCK TABLES `ysk_recharge` WRITE;
/*!40000 ALTER TABLE `ysk_recharge` DISABLE KEYS */;
INSERT INTO `ysk_recharge` VALUES (58,210,'','',100.00,3,'1691910673',1,'',850169150,'/Public/attached/2023/08/13/64d8820a1f8f9.png',0.0000,0.0000);
/*!40000 ALTER TABLE `ysk_recharge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_roborder`
--

DROP TABLE IF EXISTS `ysk_roborder`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_roborder` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `class` tinyint(2) DEFAULT '0' COMMENT '收款类型',
  `price` decimal(20,0) NOT NULL COMMENT '收款金额',
  `yongjin` decimal(20,2) NOT NULL DEFAULT '0.00',
  `hk_price` decimal(20,2) NOT NULL DEFAULT '0.00',
  `addtime` varchar(225) NOT NULL COMMENT '添加时间',
  `status` int(2) NOT NULL COMMENT '订单状态 2待完成 3 已完成',
  `uid` int(11) NOT NULL COMMENT '匹配用户ID',
  `uname` varchar(225) NOT NULL COMMENT '匹配用户名称',
  `umoney` float(10,2) NOT NULL COMMENT '匹配用户余额',
  `pipeitime` varchar(225) NOT NULL COMMENT '匹配时间',
  `finishtime` varchar(225) NOT NULL COMMENT '完成时间',
  `ordernum` varchar(225) NOT NULL COMMENT '订单号',
  `surplustime` int(11) DEFAULT NULL,
  `is_hk` int(1) NOT NULL DEFAULT '0' COMMENT '0meiyou,1huikuanle',
  `is_check` int(1) NOT NULL DEFAULT '0' COMMENT '0待审核,1已完成,2失败',
  `voucher` varchar(255) DEFAULT NULL,
  `endtime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `prices` varchar(255) DEFAULT NULL COMMENT '改 拆分金额',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='抢单表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_roborder`
--

LOCK TABLES `ysk_roborder` WRITE;
/*!40000 ALTER TABLE `ysk_roborder` DISABLE KEYS */;
INSERT INTO `ysk_roborder` VALUES (1,2,100,0.00,0.00,'1691907374',2,208,'须弥山',0.00,'1691907374','','JZ254338',1691907374,0,0,NULL,1691910974,NULL),(2,2,100,0.00,0.00,'1691847732',2,209,'二当家',0.00,'1691847732','','JZ636283',1691847732,0,0,NULL,1691851332,NULL),(3,2,100,0.00,0.00,'1691847222',2,208,'须弥山',0.00,'1691847222','','JZ396882',1691847222,0,0,NULL,1691850822,NULL),(4,1,500,4.50,0.00,'1691847671',3,209,'二当家',500.00,'1691847671','1691847755','JZ159197',1691847671,2,0,NULL,1691851271,'{\"1\":{\"num\":500}}'),(5,1,500,0.00,0.00,'1691907291',2,208,'须弥山',500.00,'1691907291','','JZ672989',1691907291,0,0,NULL,1691910891,'{\"1\":{\"num\":500}}'),(6,1,500,0.00,0.00,'1691907432',2,208,'须弥山',500.00,'1691907432','','JZT76295',1691907432,0,0,NULL,1691911032,'{\"1\":{\"num\":500}}');
/*!40000 ALTER TABLE `ysk_roborder` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_skm`
--

DROP TABLE IF EXISTS `ysk_skm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_skm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wxewm` varchar(225) NOT NULL,
  `zfbewm` varchar(225) NOT NULL,
  `bankewm` varchar(225) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='收款码';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_skm`
--

LOCK TABLES `ysk_skm` WRITE;
/*!40000 ALTER TABLE `ysk_skm` DISABLE KEYS */;
INSERT INTO `ysk_skm` VALUES (1,'2019pay/2019-03-20/5c911c22156dc.png','2019pay/2019-03-20/5c911c22188b8.png','2019pay/2019-03-20/5c911c221b2c7.png');
/*!40000 ALTER TABLE `ysk_skm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_sms_log`
--

DROP TABLE IF EXISTS `ysk_sms_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_sms_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '表id',
  `mobile` varchar(11) DEFAULT '' COMMENT '手机号',
  `session_id` varchar(128) DEFAULT '' COMMENT 'session_id',
  `add_time` int(11) DEFAULT '0' COMMENT '发送时间',
  `code` varchar(10) DEFAULT '' COMMENT '验证码',
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '发送状态,1:成功,0:失败',
  `msg` varchar(255) DEFAULT NULL COMMENT '短信内容',
  `scene` int(1) DEFAULT '0' COMMENT '发送场景,1:用户注册,2:找回密码,3:客户下单,4:客户支付,5:商家发货,6:身份验证',
  `error_msg` text COMMENT '发送短信异常内容',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_sms_log`
--

LOCK TABLES `ysk_sms_log` WRITE;
/*!40000 ALTER TABLE `ysk_sms_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `ysk_sms_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_somebill`
--

DROP TABLE IF EXISTS `ysk_somebill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_somebill` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `jl_class` int(11) NOT NULL COMMENT '流水类别：1佣金2团队奖励改直推奖励 3充值4提现5订单匹配 6 团队奖',
  `info` varchar(225) NOT NULL COMMENT '说明',
  `addtime` varchar(225) NOT NULL COMMENT '事件时间',
  `jc_class` varchar(225) NOT NULL COMMENT '分+ 或-',
  `num` decimal(20,4) NOT NULL COMMENT '币量',
  `before` decimal(20,4) NOT NULL,
  `after` decimal(20,4) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='会员流水账单';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_somebill`
--

LOCK TABLES `ysk_somebill` WRITE;
/*!40000 ALTER TABLE `ysk_somebill` DISABLE KEYS */;
INSERT INTO `ysk_somebill` VALUES (1,209,3,'平台充值','1691847527','+',1000.0000,0.0000,1000.0000),(2,209,3,'平台充值','1691847556','+',1000.0000,1000.0000,2000.0000),(3,209,5,'开启接单','1691847671','-',500.0000,0.0000,0.0000),(4,209,5,'开启手动接单','1691847725','-',600.0000,0.0000,0.0000),(5,209,1,'接单利息','1691847755','+',4.5000,895.5000,4.5000),(6,208,5,'开启接单','1691907291','-',500.0000,0.0000,0.0000),(7,208,5,'开启接单','1691907432','-',500.0000,0.0000,0.0000),(8,210,3,'平台充值','1691912082','+',1000.0000,0.0000,1000.0000),(9,210,4,'余额提现','1691912354','-',111.0000,1000.0000,889.0000);
/*!40000 ALTER TABLE `ysk_somebill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_store`
--

DROP TABLE IF EXISTS `ysk_store`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_store` (
  `uid` int(11) unsigned NOT NULL COMMENT '用户id',
  `cangku_num` decimal(13,5) NOT NULL DEFAULT '0.00000' COMMENT '钱包余额',
  `fengmi_num` decimal(13,5) NOT NULL DEFAULT '0.00000' COMMENT '积分',
  `plant_num` decimal(13,4) NOT NULL DEFAULT '0.0000' COMMENT '播种总数',
  `huafei_total` decimal(13,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '施肥累计',
  `vip_grade` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_store`
--

LOCK TABLES `ysk_store` WRITE;
/*!40000 ALTER TABLE `ysk_store` DISABLE KEYS */;
/*!40000 ALTER TABLE `ysk_store` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_system`
--

DROP TABLE IF EXISTS `ysk_system`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_system` (
  `id` int(2) NOT NULL AUTO_INCREMENT COMMENT '记录ID',
  `qd_cf` int(11) NOT NULL COMMENT '抢单余额比列',
  `qd_nd` varchar(225) NOT NULL COMMENT '抢单难度，数组(0.1,0.2,0.3)',
  `qd_wxyj` decimal(20,5) NOT NULL COMMENT '微信抢单佣金30%填0.3',
  `qd_zfbyj` decimal(20,5) NOT NULL COMMENT '支付宝抢单佣金30%填0.3',
  `qd_bkyj` decimal(20,5) NOT NULL COMMENT '银行卡抢单佣金30%填0.3',
  `qd_ndtime` varchar(225) NOT NULL COMMENT '增加难度时间点',
  `qd_yjjc` varchar(12) NOT NULL COMMENT '佣金加成',
  `qd_minmoney` float NOT NULL COMMENT '抢单最低额度',
  `min_recharge` float(10,2) NOT NULL COMMENT '最低充值额度',
  `mix_withdraw` float(10,2) NOT NULL COMMENT '最小提现额度',
  `max_withdraw` float(10,2) NOT NULL COMMENT '最大提现额度',
  `tx_yeb` float NOT NULL COMMENT '提现要求：收款与余额比例 ',
  `team_onecount` int(11) NOT NULL DEFAULT '1',
  `team_oneyj` decimal(20,5) NOT NULL COMMENT '1代佣金比例30%写0.3',
  `team_twoprice` decimal(20,2) NOT NULL DEFAULT '0.00',
  `team_twoyj` decimal(20,5) NOT NULL COMMENT '2代佣金比例30%写0.3',
  `team_threeyj` decimal(20,5) NOT NULL COMMENT '3代佣金比例30%写0.3',
  `cz_yh` varchar(255) NOT NULL,
  `cz_xm` varchar(255) NOT NULL,
  `cz_kh` varchar(255) NOT NULL,
  `s_time` int(11) NOT NULL DEFAULT '30',
  `team_twocount` int(11) NOT NULL DEFAULT '1',
  `sjjz_kefu` varchar(255) DEFAULT NULL,
  `wechat_qr` varchar(255) DEFAULT NULL,
  `ali_qr` varchar(255) DEFAULT NULL,
  `user_num` varchar(255) DEFAULT '0' COMMENT '伞下人数',
  `user_money` varchar(255) DEFAULT '0' COMMENT '伞下+自己的总充值量',
  `qd_time` tinyint(2) DEFAULT '0' COMMENT '跑分多久一轮',
  `qd_num` tinyint(2) DEFAULT '0' COMMENT '需要拆分的订单数',
  `user_profit` varchar(255) DEFAULT NULL COMMENT '直推跑分',
  `total_profit` varchar(255) DEFAULT NULL COMMENT '团队跑分',
  `notice` varchar(100) DEFAULT NULL,
  `switch` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否开启跑分 0 关闭 1开启',
  `kf_qr` varchar(255) DEFAULT NULL,
  `usdt_money` varchar(255) NOT NULL COMMENT 'usdt钱包地址',
  `conversion` decimal(10,4) NOT NULL COMMENT '转化比例 RMB 1:？USDT',
  `user_first_num` varchar(255) DEFAULT NULL,
  `activation` tinyint(4) DEFAULT '0',
  `time` decimal(10,0) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='游戏参数设置表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_system`
--

LOCK TABLES `ysk_system` WRITE;
/*!40000 ALTER TABLE `ysk_system` DISABLE KEYS */;
INSERT INTO `ysk_system` VALUES (1,0,'',0.00000,0.00000,0.00000,'','0.01',500,500.00,100.00,20000.00,5,1,0.00000,0.00,0.00000,0.00000,'（TRC10/TRC20）','须弥山','TCL7CFGXQJTsruZBhpej5LHg9NVuarXoQD',30,0,'','','','[\"1\",\"2\",\"30\",\"100\",\"100\",\"100\",\"0\",\"0\",\"0\",\"0\"]','[\"0.0090\",\"0.0120\",\"0.014\",\"0.016\",\"0.018\",\"0.020\",\"0\",\"0\",\"0\",\"0\"]',1,1,'\"\"','\"\"','这个是演示站供学习用，需要搭建本站请联系 @hs8833',1,'/Public/attached/2023/08/12/64d78273ad32a.png','',0.0000,'[\"1\",\"1\",\"2\",\"2\",\"3\",\"3\",\"\",\"0\",\"0\",\"0\"]',0,72);
/*!40000 ALTER TABLE `ysk_system` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_transfer`
--

DROP TABLE IF EXISTS `ysk_transfer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_transfer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '用户id',
  `account` varchar(11) NOT NULL COMMENT '用户账号',
  `t_uid` int(11) NOT NULL COMMENT '目标人id',
  `t_account` varchar(11) NOT NULL COMMENT '目标人账号',
  `num` decimal(10,4) NOT NULL COMMENT '数量',
  `addtime` int(11) NOT NULL COMMENT '添加时间 ',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_transfer`
--

LOCK TABLES `ysk_transfer` WRITE;
/*!40000 ALTER TABLE `ysk_transfer` DISABLE KEYS */;
/*!40000 ALTER TABLE `ysk_transfer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_unique`
--

DROP TABLE IF EXISTS `ysk_unique`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_unique` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `key` varchar(225) NOT NULL COMMENT 'key',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='unique';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_unique`
--

LOCK TABLES `ysk_unique` WRITE;
/*!40000 ALTER TABLE `ysk_unique` DISABLE KEYS */;
/*!40000 ALTER TABLE `ysk_unique` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_upload`
--

DROP TABLE IF EXISTS `ysk_upload`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_upload` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'UID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '文件名',
  `path` varchar(255) NOT NULL DEFAULT '' COMMENT '文件路径',
  `url` varchar(255) DEFAULT NULL COMMENT '文件链接',
  `ext` char(4) NOT NULL DEFAULT '' COMMENT '文件类型',
  `size` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `md5` char(32) DEFAULT NULL COMMENT '文件md5',
  `sha1` char(40) DEFAULT NULL COMMENT '文件sha1编码',
  `location` varchar(15) NOT NULL DEFAULT '' COMMENT '文件存储位置',
  `download` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '下载次数',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '修改时间',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='文件上传表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_upload`
--

LOCK TABLES `ysk_upload` WRITE;
/*!40000 ALTER TABLE `ysk_upload` DISABLE KEYS */;
/*!40000 ALTER TABLE `ysk_upload` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_user`
--

DROP TABLE IF EXISTS `ysk_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_user` (
  `userid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL COMMENT '上级ID',
  `gid` int(11) NOT NULL DEFAULT '0' COMMENT '上上级ID',
  `ggid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上上上级ID',
  `account` char(20) NOT NULL DEFAULT '0' COMMENT '用户账号',
  `mobile` char(20) NOT NULL COMMENT '用户手机号',
  `u_yqm` varchar(225) NOT NULL COMMENT '邀请码',
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `login_pwd` varchar(225) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `login_salt` char(5) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `money` decimal(20,4) NOT NULL DEFAULT '0.0000' COMMENT '用户余额',
  `reg_date` int(11) NOT NULL COMMENT '注册时间',
  `reg_ip` varchar(20) NOT NULL COMMENT '注册IP',
  `status` tinyint(4) DEFAULT '0' COMMENT '用户锁定  1 不锁  0拉黑  -1 删除',
  `activates` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否激活 1-已激活 0-未激活',
  `session_id` varchar(225) DEFAULT NULL,
  `wx_no` varchar(225) DEFAULT NULL COMMENT '微信账号',
  `alipay` varchar(225) DEFAULT NULL COMMENT '支付宝',
  `truename` varchar(225) NOT NULL COMMENT '真实姓名',
  `email` varchar(225) DEFAULT NULL COMMENT '电子邮件',
  `userqq` varchar(32) DEFAULT NULL COMMENT 'QQ',
  `usercard` varchar(32) NOT NULL COMMENT '身份证号码',
  `path` text COMMENT '关系链',
  `use_grade` tinyint(2) NOT NULL DEFAULT '0' COMMENT '用户等级',
  `u_ztnum` int(11) NOT NULL COMMENT '直推人数',
  `rz_st` int(1) NOT NULL COMMENT '资料完善状态，1OK2no',
  `tx_status` int(11) NOT NULL COMMENT '提现状态',
  `zsy` decimal(20,4) NOT NULL DEFAULT '0.0000' COMMENT '总收益',
  `d_money` decimal(20,4) DEFAULT '0.0000',
  `cdkey_id` int(11) DEFAULT NULL,
  `yongjin` decimal(20,2) DEFAULT '0.00' COMMENT '佣金',
  `unfreeze_expire` int(11) DEFAULT NULL COMMENT '解冻过期',
  `trend_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '动态余额',
  `static_profit` decimal(10,4) NOT NULL DEFAULT '0.0000' COMMENT '静态收益',
  `total_recharge` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '伞下充值',
  `total_profit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '动态收益',
  `usdt_address` varchar(255) NOT NULL COMMENT '钱包地址',
  `update_time` int(11) DEFAULT NULL,
  `paypass` varchar(32) DEFAULT NULL,
  `lock_money` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`userid`) USING BTREE,
  UNIQUE KEY `mobile` (`mobile`) USING BTREE,
  UNIQUE KEY `account` (`account`) USING BTREE,
  KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=211 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_user`
--

LOCK TABLES `ysk_user` WRITE;
/*!40000 ALTER TABLE `ysk_user` DISABLE KEYS */;
INSERT INTO `ysk_user` VALUES (208,0,0,0,'18888888888','18888888888','tMhKQjVPrMuS','须弥山','14e1b600b1fd579f47433b88e8d85291','',9000.0000,0,'',1,1,'rj1nst2josmmcn02kfh5ufqcs6','18888888888','18888888888','须弥山','','','4444444444444444',NULL,1,1,1,0,100.0000,0.0000,NULL,0.00,1691651748,0.00,100.0000,100000.00,0.00,'',1691651748,'14e1b600b1fd579f47433b88e8d85291',300.00),(209,0,0,0,'15555555555','15555555555','N24FKtDkXPl5','二当家','14e1b600b1fd579f47433b88e8d85291','',904.5000,0,'',1,1,'ehfbcanpe9no5tms3phds8vqqr','','','二当家','','','112233199909190018',NULL,1,0,1,0,4.5000,0.0000,NULL,0.00,1691932744,0.00,4.5000,2000.00,0.00,'',1691847658,'14e1b600b1fd579f47433b88e8d85291',500.00),(210,208,0,0,'13333333333','13333333333','l2eRcwsiZ3Cm','13333333333','049d21336a29159fcb0f1a82412a3197','hibH',889.0000,1691905119,'43.239.85.245',1,1,'m94gc19s79fr77ke2l7u9gij4j','','','',NULL,NULL,'','-208-',0,0,0,1,0.0000,0.0000,NULL,0.00,NULL,0.00,0.0000,1000.00,0.00,'',1691912340,'049d21336a29159fcb0f1a82412a3197',0.00);
/*!40000 ALTER TABLE `ysk_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_userrob`
--

DROP TABLE IF EXISTS `ysk_userrob`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_userrob` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `class` int(2) NOT NULL COMMENT '支付类别',
  `price` float(10,2) NOT NULL COMMENT '金额',
  `yjjc` float(10,2) NOT NULL COMMENT '佣金加成',
  `umoney` float(10,2) NOT NULL COMMENT '会员余额',
  `uaccount` varchar(225) NOT NULL COMMENT '会员账号',
  `uname` varchar(225) NOT NULL COMMENT '会员姓名',
  `ppid` int(11) NOT NULL COMMENT '匹配的ID号',
  `status` int(2) NOT NULL COMMENT '状态1匹配中2全部金额匹配完成',
  `addtime` varchar(225) NOT NULL COMMENT '添加时间',
  `pipeitime` varchar(225) NOT NULL COMMENT '匹配成功时间',
  `finishtime` varchar(225) NOT NULL COMMENT '交易完成时间',
  `ordernum` varchar(225) NOT NULL COMMENT '订单号',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='会员抢单表前台发起的';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_userrob`
--

LOCK TABLES `ysk_userrob` WRITE;
/*!40000 ALTER TABLE `ysk_userrob` DISABLE KEYS */;
/*!40000 ALTER TABLE `ysk_userrob` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ysk_withdraw`
--

DROP TABLE IF EXISTS `ysk_withdraw`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ysk_withdraw` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL COMMENT '会员ID',
  `account` varchar(225) NOT NULL COMMENT '提现账号',
  `name` varchar(225) NOT NULL COMMENT '提现人姓名',
  `way` varchar(225) NOT NULL COMMENT '提现方式',
  `price` float(10,2) NOT NULL COMMENT '提现金额',
  `addtime` varchar(225) NOT NULL COMMENT '提现时间',
  `endtime` varchar(225) NOT NULL COMMENT '完成时间',
  `status` int(11) NOT NULL COMMENT '状态1提交，2退回3成功',
  `related` int(10) DEFAULT NULL,
  `type` tinyint(1) DEFAULT '0',
  `conversion` decimal(10,4) NOT NULL COMMENT '比例',
  `rmb_money` decimal(14,4) NOT NULL COMMENT '用USDT转化后的余额',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='提现申请表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ysk_withdraw`
--

LOCK TABLES `ysk_withdraw` WRITE;
/*!40000 ALTER TABLE `ysk_withdraw` DISABLE KEYS */;
INSERT INTO `ysk_withdraw` VALUES (6,210,'TCL7CFGXQJTsruZBhpej5LHg9NVuarXoQD','','',111.00,'1691912354','',1,10,0,0.0000,0.0000);
/*!40000 ALTER TABLE `ysk_withdraw` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'qd1500_jglgs_com'
--

--
-- Dumping routines for database 'qd1500_jglgs_com'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-08-13 16:07:29
