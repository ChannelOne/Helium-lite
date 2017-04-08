/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE TABLE IF NOT EXISTS `agiso_log` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Agiso日志ID',
  `date` int(10) unsigned NOT NULL COMMENT '推送日期',
  `tao_order_id` varchar(32) NOT NULL COMMENT '淘宝订单号',
  `metadata` text NOT NULL COMMENT '推送内容',
  `type` varchar(4) NOT NULL COMMENT '推送类型(订单/退款)',
  `ip` varchar(46) NOT NULL COMMENT '推送IP',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='Agiso 推送日志';

CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '客户ID',
  `nickname` varchar(32) DEFAULT NULL COMMENT '客户昵称',
  `email` varchar(32) DEFAULT NULL COMMENT '客户邮箱',
  `mobile` varchar(32) DEFAULT NULL COMMENT '客户手机',
  PRIMARY KEY (`customer_id`),
  KEY `nickname` (`nickname`),
  KEY `email` (`email`),
  KEY `mobile` (`mobile`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='客户信息';

CREATE TABLE IF NOT EXISTS `customer_ext` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '客户外部信息ID',
  `account_type` varchar(32) NOT NULL COMMENT '外部信息类型',
  `account` varchar(32) NOT NULL COMMENT '外部信息值',
  `customer_id` int(8) unsigned NOT NULL COMMENT '绑定的客户ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account_type` (`account_type`,`account`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='外部客户信息绑定';

CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `status` varchar(32) NOT NULL COMMENT '订单状态',
  `channel` varchar(32) NOT NULL COMMENT '订单渠道',
  `ext_order_id` varchar(32) DEFAULT NULL COMMENT '外部订单ID',
  `ext_sub_id` int(4) unsigned DEFAULT '1' COMMENT '外部子订单ID',
  `software_id` varchar(32) NOT NULL COMMENT '软件ID',
  `customer_id` int(8) unsigned DEFAULT NULL COMMENT '客户ID',
  `lic_fname` varchar(128) DEFAULT NULL COMMENT '授权-名',
  `lic_lname` varchar(128) DEFAULT NULL COMMENT '授权-姓',
  `lic_name` varchar(128) DEFAULT NULL COMMENT '授权姓名',
  `lic_email` varchar(128) DEFAULT NULL COMMENT '授权邮箱',
  `notify_email` varchar(128) DEFAULT NULL COMMENT '通知邮箱',
  `extra_info` text COMMENT '订单附加信息',
  `licence_key` text COMMENT '订单授权码',
  `last_error` text COMMENT '最后发生的错误',
  `system_log` text COMMENT '系统日志',
  `operator_log` text COMMENT '操作员日志',
  `create_date` int(10) unsigned NOT NULL COMMENT '创建时间',
  `update_date` int(10) unsigned NOT NULL COMMENT '更新时间',
  `update_operator` int(8) unsigned NOT NULL COMMENT '更新操作员',
  `sequence` int(4) unsigned NOT NULL DEFAULT '1' COMMENT '序号',
  PRIMARY KEY (`order_id`),
  KEY `status` (`status`),
  KEY `software_id` (`software_id`),
  KEY `user_id` (`customer_id`),
  KEY `create_date` (`create_date`),
  KEY `ext_order_id` (`ext_order_id`),
  KEY `channel` (`channel`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单信息表';

CREATE TABLE IF NOT EXISTS `order_fare` (
  `order_id` int(12) unsigned NOT NULL COMMENT '订单ID',
  `base_cost` int(8) unsigned NOT NULL COMMENT '基础成本价格',
  `override_rule_id` int(8) unsigned DEFAULT NULL COMMENT '调价规则ID',
  `override_cost` int(8) unsigned DEFAULT NULL COMMENT '调价成本价格',
  `cost` int(8) unsigned NOT NULL COMMENT '最终成本价格',
  `cost_currency` varchar(3) NOT NULL DEFAULT 'CNY' COMMENT '最终成本货币',
  `sale_price` int(8) unsigned NOT NULL COMMENT '售价',
  `payment_method` varchar(32) DEFAULT NULL COMMENT '支付方法',
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单价格表';

CREATE TABLE IF NOT EXISTS `order_history` (
  `history_id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单历史ID',
  `order_id` int(12) unsigned NOT NULL COMMENT '订单ID',
  `status` varchar(32) NOT NULL COMMENT '订单状态',
  `metadata` text NOT NULL COMMENT '订单信息',
  `sequence` int(4) unsigned NOT NULL COMMENT '订单序号',
  `update_date` int(10) unsigned NOT NULL COMMENT '更新日期',
  `update_operator` int(8) unsigned NOT NULL COMMENT '更新操作员',
  PRIMARY KEY (`history_id`) USING BTREE,
  KEY `order_id` (`order_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='订单历史信息表';

CREATE TABLE IF NOT EXISTS `order_onhold` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `channel` varchar(32) NOT NULL COMMENT '订单渠道',
  `ext_order_id` varchar(50) NOT NULL COMMENT '外部订单ID',
  `blocked_date` int(10) unsigned NOT NULL COMMENT '屏蔽日期',
  `operator_id` int(8) unsigned NOT NULL COMMENT '屏蔽操作员',
  PRIMARY KEY (`id`),
  KEY `ext_order` (`channel`,`ext_order_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='订单屏蔽表';

CREATE TABLE IF NOT EXISTS `price_info` (
  `id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '价格信息ID',
  `software_id` varchar(32) NOT NULL COMMENT '软件ID',
  `price` int(8) unsigned NOT NULL COMMENT '成本价',
  `currency` varchar(3) NOT NULL COMMENT '成本价货币',
  `min_sale` int(8) unsigned NOT NULL COMMENT '最低售价',
  PRIMARY KEY (`id`),
  UNIQUE KEY `software_id` (`software_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='基础价格信息表';

CREATE TABLE IF NOT EXISTS `price_override` (
  `id` int(11) NOT NULL COMMENT '价格复写ID',
  `name` varchar(64) NOT NULL COMMENT '价格复写规则名',
  `begin_date` int(10) unsigned NOT NULL COMMENT '开始应用日期',
  `end_date` int(10) unsigned NOT NULL COMMENT '结束应用日期',
  `software_id` varchar(32) NOT NULL COMMENT '软件ID',
  `cost` int(8) unsigned NOT NULL COMMENT '重写价格',
  `min_sale` int(8) unsigned NOT NULL COMMENT '最低售价',
  `api_key` varchar(64) DEFAULT NULL COMMENT '对开发商API键',
  `api_value` varchar(64) DEFAULT NULL COMMENT '对开发商API值',
  `enabled` int(1) unsigned NOT NULL COMMENT '启用规则',
  `auto_apply` int(1) unsigned NOT NULL COMMENT '自动应用规则',
  `add_date` int(10) NOT NULL COMMENT '创建日期',
  `operator_id` int(4) NOT NULL COMMENT '创建操作员',
  PRIMARY KEY (`id`),
  KEY `auto_apply` (`auto_apply`),
  KEY `enabled` (`enabled`),
  KEY `software_id` (`software_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='价格复写规则表';

CREATE TABLE IF NOT EXISTS `privilege_group` (
  `id` int(8) NOT NULL AUTO_INCREMENT COMMENT '权限组ID',
  `type` enum('user','skudb','report') NOT NULL COMMENT '权限组类型',
  `name` varchar(64) NOT NULL COMMENT '权限组名称',
  `privilege` text NOT NULL COMMENT '权限列表',
  PRIMARY KEY (`id`),
  KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='权限组表';

CREATE TABLE IF NOT EXISTS `queue` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '列队项ID',
  `queue_id` int(4) unsigned NOT NULL COMMENT '列队类别ID',
  `order_id` int(12) unsigned NOT NULL COMMENT '订单ID',
  `operator_id` int(8) unsigned NOT NULL COMMENT '操作员ID',
  `create_date` int(10) unsigned NOT NULL COMMENT '创建日期',
  `process_date` int(10) unsigned DEFAULT NULL COMMENT '处理日期',
  PRIMARY KEY (`id`),
  KEY `queue_id` (`queue_id`),
  KEY `process_date` (`process_date`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='订单列队表';

CREATE TABLE IF NOT EXISTS `redeem_data` (
  `redeem_key` varchar(32) NOT NULL COMMENT '兑换码',
  `key_metadata` text COMMENT '兑换码元数据',
  `order_metadata` text COMMENT '订单元数据',
  `redeem_metadata` text COMMENT '兑换信息元数据',
  `create_date` int(10) unsigned NOT NULL COMMENT '创建日期 (active)',
  `create_ip` varchar(46) NOT NULL COMMENT '创建IP',
  `update_date` int(10) unsigned DEFAULT NULL COMMENT '更新日期 (fullfill)',
  `update_ip` varchar(46) DEFAULT NULL COMMENT '更新IP',
  `updated` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '已更新',
  `processed` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '已处理',
  `bind_order_id` int(12) unsigned DEFAULT NULL COMMENT '绑定的订单ID',
  PRIMARY KEY (`redeem_key`),
  KEY `processed` (`processed`),
  KEY `updated` (`updated`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='兑换码信息表';

CREATE TABLE IF NOT EXISTS `redeem_key` (
  `redeem_key` varchar(32) NOT NULL COMMENT '兑换码',
  `software_id` varchar(32) NOT NULL COMMENT '软件ID',
  `batch_id` varchar(16) NOT NULL COMMENT '批量添加ID',
  `create_date` int(10) unsigned NOT NULL COMMENT '创建日期',
  `create_user` int(4) unsigned NOT NULL COMMENT '创建操作员',
  `expire_date` int(10) unsigned DEFAULT NULL COMMENT '过期日期',
  `used` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '已使用',
  `used_date` int(10) unsigned DEFAULT NULL COMMENT '使用日期',
  PRIMARY KEY (`redeem_key`),
  KEY `software_id` (`software_id`),
  KEY `used` (`used`),
  KEY `batch_id` (`batch_id`),
  KEY `create_date` (`create_date`),
  KEY `expire_date` (`expire_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='兑换码表';

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(12) unsigned NOT NULL AUTO_INCREMENT COMMENT '操作员ID',
  `display_name` varchar(32) NOT NULL COMMENT '昵称',
  `email` varchar(32) NOT NULL COMMENT '邮箱',
  `mobile` varchar(16) NOT NULL COMMENT '手机',
  `password` varchar(64) NOT NULL COMMENT '密码hash',
  `tfa_secret` varchar(32) NOT NULL COMMENT '两步认证码',
  `user_group` int(12) unsigned DEFAULT '1' COMMENT 'USER组',
  `skudb_group` int(12) unsigned DEFAULT '2' COMMENT 'SKUDB组',
  `report_group` int(12) unsigned DEFAULT '3' COMMENT 'REPORT组',
  `sku_tree_node` varchar(64) DEFAULT NULL COMMENT 'SKUDB绑定节点',
  `last_login_date` int(10) unsigned DEFAULT NULL COMMENT '最后更新日期',
  `last_login_ip` varchar(46) DEFAULT NULL COMMENT '最后更新IP',
  `disabled` int(1) unsigned NOT NULL DEFAULT '0' COMMENT '已禁用',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='操作员表';


INSERT INTO `user` (`user_id`, `display_name`, `email`, `mobile`, `password`, `tfa_secret`, `user_group`, `skudb_group`, `report_group`, `sku_tree_node`, `last_login_date`, `last_login_ip`, `disabled`) VALUES (1, '系统', '', '', '', '', 1, 2, 3, NULL, NULL, NULL, 1);

INSERT INTO `privilege_group` (`id`, `type`, `name`, `privilege`) VALUES (1, 'user', '无权限组', 'NULL');
INSERT INTO `privilege_group` (`id`, `type`, `name`, `privilege`) VALUES (2, 'skudb', '无权限组', 'NULL');
INSERT INTO `privilege_group` (`id`, `type`, `name`, `privilege`) VALUES (3, 'report', '无权限组', 'NULL');
INSERT INTO `privilege_group` (`id`, `type`, `name`, `privilege`) VALUES (4, 'user', '超级用户', 'EVERYTHING');

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
