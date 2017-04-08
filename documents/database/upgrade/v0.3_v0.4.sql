RENAME TABLE `price_override` TO `price_rule`;

ALTER TABLE `order`
	CHANGE COLUMN `fare_info` `price_info` TEXT NULL COMMENT '价格信息' AFTER `customer_id`;

UPDATE `version` SET `version` = 0.4 WHERE `name` = 'db';
