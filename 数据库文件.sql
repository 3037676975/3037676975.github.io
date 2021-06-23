CREATE DATABASE IF NOT EXISTS `sucai` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `sucai`;

DROP TABLE IF EXISTS `setting`;
CREATE TABLE `setting` (
	`key` varchar(255) NOT NULL DEFAULT '' COMMENT '变量名',
	`value` mediumtext NOT NULL COMMENT '变量值',
	PRIMARY KEY (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='全局设置';

INSERT INTO `setting` VALUES 
('site_open',1),
('allow_register',1),
('site_name','百度一下'),
('AccessKeyId',''),
('AccessKeySecret',''),
('Endpoint','http://oss-cn-shanghai.aliyuncs.com'),
('Bucket',''),
('qq','123456'),
('proxy_card_numbers','100'),
('proxy_card_account_times','10'),
('proxy_card_rule','@@##**'),
('auto_save_file',1),
('parse_between_time',60);

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs`  (
	`id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
	`title` varchar(255) NOT NULL DEFAULT '' COMMENT '名称',
	`queue` varchar(255) NOT NULL DEFAULT '' COMMENT '类型',
	`payload` longtext NOT NULL COMMENT '执行任务文件',
	`attempts` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '已执行次数',
	`reserved` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '重发次数',
	`reserved_at` int(11) unsigned NULL DEFAULT NULL COMMENT '执行任务文件',
	`available_at` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '执行任务文件',
	`created_at` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '创建时间',
	`status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='队列';

INSERT INTO `jobs` VALUES
(1, '下载文件', 'default', '{\"job\":\"common\\/Download\",\"data\":\"\"}', 0, 1, 1549970379, 1549940197, 1549940196, 1),
(2, '上传文件', 'default', '{\"job\":\"common\\/Upload\",\"data\":\"\"}', 0, 1, 1549970379, 1549940197, 1549940196, 1),
(3, '刷新Cookie', 'default', '{\"job\":\"common\\/RefreshCookie\",\"data\":\"\"}', 0, 1, 1549970379, 1549940197, 1549940196, 1),
(4, '刷新下载次数', 'default', '{\"job\":\"common\\/ResetTimes\",\"data\":\"\"}', 0, 1, 1549970379, 1549940197, 1549940196, 1);

DROP TABLE IF EXISTS `web_site`;
CREATE TABLE `web_site`  (
	`site_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
	`title` varchar(255) NOT NULL DEFAULT '' COMMENT '网站名称',
	`url` varchar(255) NOT NULL DEFAULT '' COMMENT '官网地址',
	`url_regular` varchar(500) NOT NULL DEFAULT '' COMMENT 'url特征',
	`download_url` varchar(255) NOT NULL DEFAULT '' COMMENT '下载地址',
	`bucket` varchar(255) NOT NULL DEFAULT '' COMMENT '存储使用的oss Bucket',
	`type` varchar(255) NOT NULL DEFAULT '' COMMENT '站点类型',
	`status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
	PRIMARY KEY (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='站点';

DROP TABLE IF EXISTS `web_site_cookie`;
CREATE TABLE `web_site_cookie`  (
	`cookie_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'cookie_id',
	`site_id` smallint(6) unsigned NOT NULL DEFAULT 0 COMMENT '网站ID',
	`name` varchar(500) NOT NULL DEFAULT '' COMMENT '名称，方便自己查看',
	`content` text NOT NULL COMMENT 'cookie内容',
	`used_times` smallint(6) unsigned NOT NULL DEFAULT 0 COMMENT '今日已使用次数',
	`times` smallint(6) unsigned NOT NULL DEFAULT 0 COMMENT '该COOKIE每日可用次数',
	`status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
	PRIMARY KEY (`cookie_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='站点Cookie';


INSERT INTO `web_site` VALUES (1, '觅元素', 'http://www.51yuansu.com/', '51yuansu.com', 'http://www.51yuansu.com/sc/lcvnlvrkig.html', '', '', 1);
INSERT INTO `web_site` VALUES (2, '我图网', 'https://www.ooopic.com/', 'ooopic.com', 'https://www.ooopic.com/pic_27796570.html', '', '', 1);
INSERT INTO `web_site` VALUES (3, '千图网', 'https://www.58pic.com/', '58pic.com', 'http://www.58pic.com/newpic/33513860.html', '', '', 1);
INSERT INTO `web_site` VALUES (4, '昵图网', 'http://www.nipic.com/', 'nipic.com', 'http://www.nipic.com/show/22717419.html', '', '', 1);
INSERT INTO `web_site` VALUES (5, '90设计', 'http://90sheji.com/', '90sheji.com', 'http://90sheji.com/sucai/22176591.html', '', '', 1);
INSERT INTO `web_site` VALUES (6, '千库网', 'http://588ku.com/', '588ku.com', 'http://588ku.com/ycpng/11716645.html', '', '', 1);
INSERT INTO `web_site` VALUES (7, '包图网', 'https://ibaotu.com/', 'ibaotu.com', 'https://ibaotu.com/sucai/18002368.html', '', '', 1);
INSERT INTO `web_site` VALUES (8, '摄图网', 'http://699pic.com/', '699pic.com', 'http://699pic.com/tupian-501104528.html', '', '', 1);
INSERT INTO `web_site` VALUES (9, 'CSDN下载', 'https://download.csdn.net/', 'download.csdn.net', 'https://download.csdn.net/download/qgy879765368/10961370', '', '', 1);
INSERT INTO `web_site` VALUES (10, '稻壳儿', 'http://www.docer.com/', 'docer.com', 'http://detail.docer.com/4512476.html', '', '', 1);
INSERT INTO `web_site` VALUES (11, '百度文库', 'https://wenku.baidu.com/', 'wenku.baidu.com', 'https://wenku.baidu.com/view/72264a1b6d85ec3a87c24028915f804d2b16877f.html', '', '', 1);
INSERT INTO `web_site` VALUES (12, '17素材', 'http://www.17sucai.com/', '17sucai.com', 'http://www.17sucai.com/pins/32451.html', '', '', 1);
INSERT INTO `web_site` VALUES (13, '熊猫办公', 'http://www.tukuppt.com/', 'tukuppt.com', 'http://www.tukuppt.com/muban/pgxdkwmz.html', '', '', 1);
INSERT INTO `web_site` VALUES (14, '92素材', 'http://www.92sucai.com/', '92sucai.com', 'http://www.92sucai.com/ae/31712.html', '', '', 1);
INSERT INTO `web_site` VALUES (15, '演界网', 'http://www.yanj.cn/', 'yanj.cn', 'http://www.yanj.cn/goods-177783.html', '', '', 1);
INSERT INTO `web_site` VALUES (16, '彼岸图', 'http://pic.netbian.com/', 'pic.netbian.com', 'http://pic.netbian.com/tupian/23507.html', '', '', 1);
INSERT INTO `web_site` VALUES (17, '绘艺素材', 'https://www.huiyi8.com/', 'huiyi8.com', 'https://www.huiyi8.com/sc/1100690.html', '', '', 1);
INSERT INTO `web_site` VALUES (18, '图品汇', 'https://www.88tph.com/', '88tph.com', 'https://www.88tph.com/sucai/12508222.html', '', '', 1);
INSERT INTO `web_site` VALUES (19, '觅知网', 'https://www.51miz.com/', '51miz.com', 'http://www.51miz.com/sucai/999440.html', '', '', 1);
INSERT INTO `web_site` VALUES (20, '六图网', 'https://www.16pic.com/', '16pic.com', 'https://www.16pic.com/pic/pic_8717237.html', '', '', 1);
INSERT INTO `web_site` VALUES (21, '全图网', 'https://www.125pic.com/', '125pic.com', 'http://www.125pic.com/sucai/104678', '', '', 1);


DROP TABLE IF EXISTS `attach`;
CREATE TABLE `attach`  (
	`attach_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
	`site_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
	`request_url` varchar(2500) NOT NULL DEFAULT '' COMMENT '请求url地址',
	`response_url` varchar(2500) NOT NULL DEFAULT '' COMMENT '返回url地址',
	`site_code_type` varchar(1000) NOT NULL DEFAULT '' COMMENT 'code类型',
	`site_code` varchar(1000) NOT NULL DEFAULT '' COMMENT '请求地址唯一标识',
	`filename` varchar(2500) NOT NULL DEFAULT '' COMMENT '文件名称',
	`filesize` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '文件大小',
	`savename` varchar(2500) NOT NULL DEFAULT '' COMMENT '保存路径',
	`downloads` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '下载次数',
	`create_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '访问时间',
	`create_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '访问ip',
	`update_time` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '最后访问时间',
	`update_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '最后访问ip',
	`local_file` varchar(255) NOT NULL DEFAULT '' COMMENT '临时文件',
	`download_time` varchar(20) NOT NULL DEFAULT '' COMMENT '下载耗时',
	`upload_time` varchar(20) NOT NULL DEFAULT '' COMMENT '上传耗时',
	`button_name` varchar(255) NOT NULL DEFAULT '' COMMENT '下载按钮名称',
	`queue_error` varchar(2500) NOT NULL DEFAULT '' COMMENT '队列执行错误信息',
	`delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据删除时间',
	`status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0-新建，1-下载中，2-已下载，3-上传中，4-上传成功',
	PRIMARY KEY (`attach_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='附件';

DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
	`uid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
	`username` varchar(30) NOT NULL DEFAULT '' COMMENT '账户名，可用作登陆不能重复',
	`password` varchar(255) NOT NULL DEFAULT '' COMMENT '登录密码',
	`password_see` varchar(255) NOT NULL DEFAULT '' COMMENT '登录密码可见',
	`email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱地址',
	`mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
	`email_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '邮箱认证状态，0未认证，1已认证',
	`mobile_verify` tinyint(1) NOT NULL DEFAULT '0' COMMENT '手机认证状态，0未认证，1已认证',
	`balance` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账户余额',
	`new_notice` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '未读通知',
	`register_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
	`register_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '注册ip',
	`last_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后访问时间',
	`last_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '最后访问IP',
	`delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据删除时间',
	`out_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户过期时间',
	`type` varchar(255) NOT NULL DEFAULT 'member' COMMENT 'system-管理员，proxy-代理，member-会员',
	`site_access` text NOT NULL COMMENT '下载权限',
	`reset_times` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '权限刷新时间',
	`from` varchar(255) NOT NULL DEFAULT '' COMMENT '账号来源',
	`parse_times` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '账户已解析总次数',
	`parse_max_times` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '账户拥有总解析次数，0-无限制',
	`status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '-2-已注销，-1-禁止访问，0-待审核，1-正常',
	PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户资料';

INSERT INTO `member` VALUES 
(1, 'admin', '$2y$10$a0j7Iv.eHOs2Wd3/CbPKNunWfBIDWmnVgtsVz6xfhKWFsZxzcCary','', '', '', 0, 0, 0.00, 0, 1549771692, '::1', 1549782892, '::1', 0,0, 'system','{"1":{"day_used":"0","max_used":"0","day":"10","all":"20"},"2":{"day_used":"0","max_used":"0","day":"10","all":"20"},"3":{"day_used":"0","max_used":"0","day":"10","all":"20"},"4":{"day_used":"0","max_used":"0","day":"10","all":"20"},"5":{"day_used":"0","max_used":"0","day":"10","all":"20"},"6":{"day_used":"0","max_used":"0","day":"10","all":"20"},"7":{"day_used":"0","max_used":"0","day":"10","all":"20"},"8":{"day_used":"0","max_used":"0","day":"10","all":"20"},"9":{"day_used":"0","max_used":"0","day":"10","all":"20"},"10":{"day_used":"0","max_used":"0","day":"10","all":"20"},"11":{"day_used":"0","max_used":"0","day":"10","all":"20"},"12":{"day_used":"0","max_used":"0","day":"10","all":"20"},"13":{"day_used":"0","max_used":"0","day":"10","all":"20"},"14":{"day_used":"0","max_used":"0","day":"10","all":"20"},"15":{"day_used":"0","max_used":"0","day":"10","all":"20"},"16":{"day_used":"0","max_used":"0","day":"10","all":"20"},"17":{"day_used":"0","max_used":"0","day":"10","all":"20"},"18":{"day_used":"0","max_used":"0","day":"10","all":"20"},"19":{"day_used":"0","max_used":"0","day":"10","all":"20"},"20":{"day_used":"0","max_used":"0","day":"10","all":"20"},"21":{"day_used":"0","max_used":"0","day":"10","all":"20"}}', 20190216,'',0,0,1);

INSERT INTO `member` VALUES 
(2, 'test1', '$2y$10$qbXdaZ4J9qS2SiFaIi2aNegFbzN9X6idz93SIslxw/3LHZYyk32mi','', '', '', 0, 0, 0.00, 0, 1549771692, '::1', 1549782892, '::1', 0,0, 'member','{"1":{"day_used":"0","max_used":"0","day":"10","all":"20"},"2":{"day_used":"0","max_used":"0","day":"10","all":"20"},"3":{"day_used":"0","max_used":"0","day":"10","all":"20"},"4":{"day_used":"0","max_used":"0","day":"10","all":"20"},"5":{"day_used":"0","max_used":"0","day":"10","all":"20"},"6":{"day_used":"0","max_used":"0","day":"10","all":"20"},"7":{"day_used":"0","max_used":"0","day":"10","all":"20"},"8":{"day_used":"0","max_used":"0","day":"10","all":"20"},"9":{"day_used":"0","max_used":"0","day":"10","all":"20"},"10":{"day_used":"0","max_used":"0","day":"10","all":"20"},"11":{"day_used":"0","max_used":"0","day":"10","all":"20"},"12":{"day_used":"0","max_used":"0","day":"10","all":"20"},"13":{"day_used":"0","max_used":"0","day":"10","all":"20"},"14":{"day_used":"0","max_used":"0","day":"10","all":"20"},"15":{"day_used":"0","max_used":"0","day":"10","all":"20"},"16":{"day_used":"0","max_used":"0","day":"10","all":"20"},"17":{"day_used":"0","max_used":"0","day":"10","all":"20"},"18":{"day_used":"0","max_used":"0","day":"10","all":"20"},"19":{"day_used":"0","max_used":"0","day":"10","all":"20"},"20":{"day_used":"0","max_used":"0","day":"10","all":"20"},"21":{"day_used":"0","max_used":"0","day":"10","all":"20"}}', 20190216,'',0,0,1);

INSERT INTO `member` VALUES 
(3, 'test2', '$2y$10$qbXdaZ4J9qS2SiFaIi2aNegFbzN9X6idz93SIslxw/3LHZYyk32mi','', '', '', 0, 0, 0.00, 0, 1549771692, '::1', 1549782892, '::1', 0,0, 'member','{"1":{"day_used":"0","max_used":"0","day":"10","all":"20"},"2":{"day_used":"0","max_used":"0","day":"10","all":"20"},"3":{"day_used":"0","max_used":"0","day":"10","all":"20"},"4":{"day_used":"0","max_used":"0","day":"10","all":"20"},"5":{"day_used":"0","max_used":"0","day":"10","all":"20"},"6":{"day_used":"0","max_used":"0","day":"10","all":"20"},"7":{"day_used":"0","max_used":"0","day":"10","all":"20"},"8":{"day_used":"0","max_used":"0","day":"10","all":"20"},"9":{"day_used":"0","max_used":"0","day":"10","all":"20"},"10":{"day_used":"0","max_used":"0","day":"10","all":"20"},"11":{"day_used":"0","max_used":"0","day":"10","all":"20"},"12":{"day_used":"0","max_used":"0","day":"10","all":"20"},"13":{"day_used":"0","max_used":"0","day":"10","all":"20"},"14":{"day_used":"0","max_used":"0","day":"10","all":"20"},"15":{"day_used":"0","max_used":"0","day":"10","all":"20"},"16":{"day_used":"0","max_used":"0","day":"10","all":"20"},"17":{"day_used":"0","max_used":"0","day":"10","all":"20"},"18":{"day_used":"0","max_used":"0","day":"10","all":"20"},"19":{"day_used":"0","max_used":"0","day":"10","all":"20"},"20":{"day_used":"0","max_used":"0","day":"10","all":"20"},"21":{"day_used":"0","max_used":"0","day":"10","all":"20"}}', 20190216,'',0,0,1);

INSERT INTO `member` VALUES 
(4, 'test3', '$2y$10$qbXdaZ4J9qS2SiFaIi2aNegFbzN9X6idz93SIslxw/3LHZYyk32mi','', '', '', 0, 0, 0.00, 0, 1549771692, '::1', 1549782892, '::1', 0,0, 'member','{"1":{"day_used":"0","max_used":"0","day":"10","all":"20"},"2":{"day_used":"0","max_used":"0","day":"10","all":"20"},"3":{"day_used":"0","max_used":"0","day":"10","all":"20"},"4":{"day_used":"0","max_used":"0","day":"10","all":"20"},"5":{"day_used":"0","max_used":"0","day":"10","all":"20"},"6":{"day_used":"0","max_used":"0","day":"10","all":"20"},"7":{"day_used":"0","max_used":"0","day":"10","all":"20"},"8":{"day_used":"0","max_used":"0","day":"10","all":"20"},"9":{"day_used":"0","max_used":"0","day":"10","all":"20"},"10":{"day_used":"0","max_used":"0","day":"10","all":"20"},"11":{"day_used":"0","max_used":"0","day":"10","all":"20"},"12":{"day_used":"0","max_used":"0","day":"10","all":"20"},"13":{"day_used":"0","max_used":"0","day":"10","all":"20"},"14":{"day_used":"0","max_used":"0","day":"10","all":"20"},"15":{"day_used":"0","max_used":"0","day":"10","all":"20"},"16":{"day_used":"0","max_used":"0","day":"10","all":"20"},"17":{"day_used":"0","max_used":"0","day":"10","all":"20"},"18":{"day_used":"0","max_used":"0","day":"10","all":"20"},"19":{"day_used":"0","max_used":"0","day":"10","all":"20"},"20":{"day_used":"0","max_used":"0","day":"10","all":"20"},"21":{"day_used":"0","max_used":"0","day":"10","all":"20"}}', 20190216,'',0,0,1);

INSERT INTO `member` VALUES 
(5, 'test4', '$2y$10$qbXdaZ4J9qS2SiFaIi2aNegFbzN9X6idz93SIslxw/3LHZYyk32mi','', '', '', 0, 0, 0.00, 0, 1549771692, '::1', 1549782892, '::1', 0,0, 'member','{"1":{"day_used":"0","max_used":"0","day":"10","all":"20"},"2":{"day_used":"0","max_used":"0","day":"10","all":"20"},"3":{"day_used":"0","max_used":"0","day":"10","all":"20"},"4":{"day_used":"0","max_used":"0","day":"10","all":"20"},"5":{"day_used":"0","max_used":"0","day":"10","all":"20"},"6":{"day_used":"0","max_used":"0","day":"10","all":"20"},"7":{"day_used":"0","max_used":"0","day":"10","all":"20"},"8":{"day_used":"0","max_used":"0","day":"10","all":"20"},"9":{"day_used":"0","max_used":"0","day":"10","all":"20"},"10":{"day_used":"0","max_used":"0","day":"10","all":"20"},"11":{"day_used":"0","max_used":"0","day":"10","all":"20"},"12":{"day_used":"0","max_used":"0","day":"10","all":"20"},"13":{"day_used":"0","max_used":"0","day":"10","all":"20"},"14":{"day_used":"0","max_used":"0","day":"10","all":"20"},"15":{"day_used":"0","max_used":"0","day":"10","all":"20"},"16":{"day_used":"0","max_used":"0","day":"10","all":"20"},"17":{"day_used":"0","max_used":"0","day":"10","all":"20"},"18":{"day_used":"0","max_used":"0","day":"10","all":"20"},"19":{"day_used":"0","max_used":"0","day":"10","all":"20"},"20":{"day_used":"0","max_used":"0","day":"10","all":"20"},"21":{"day_used":"0","max_used":"0","day":"10","all":"20"}}', 20190216,'',0,0,1);

DROP TABLE IF EXISTS `member_log`;
CREATE TABLE `member_log` (
	`log_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
	`uid` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '用户ID',
	`site_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '站点ID',
	`parse_url` varchar(255) NOT NULL DEFAULT '' COMMENT '解析地址',
	`create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '解析时间',
	`create_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '解析ip',
	`times` smallint(6) unsigned NOT NULL DEFAULT 0 COMMENT '解析消耗次数',
	`delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据删除时间',
	`status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0-解析失败，1-解析成功',
	PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='解析记录';

DROP TABLE IF EXISTS `card`;
CREATE TABLE `card` (
	`card_id` varchar(255) NOT NULL DEFAULT '' COMMENT 'ID',
	`valid_time` int(11) NOT NULL DEFAULT '0' COMMENT '有效期，秒',
	`access_times` text NOT NULL COMMENT '单站点权限次数',
	`account_times` int(11) NOT NULL DEFAULT 0 COMMENT '账户总解析次数',
	`create_uid` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '生成用户',
	`use_uid` int(11) unsigned NOT NULL DEFAULT 0 COMMENT '使用用户',
	`create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '解析时间',
	`create_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '解析ip',
	`use_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '使用时间',
	`use_ip` varchar(20) NOT NULL DEFAULT '' COMMENT '使用ip',
	`from` varchar(255) NOT NULL DEFAULT '' COMMENT '权限刷新时间',
	`delete_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据删除时间',
	`status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1-可用，0-已使用，-1失效',
	PRIMARY KEY (`card_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='充值卡';