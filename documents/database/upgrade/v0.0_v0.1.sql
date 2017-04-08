ALTER TABLE `order`
    ADD COLUMN `fare_info` TEXT NULL DEFAULT NULL COMMENT '价格信息' AFTER `customer_id`;

DROP TABLE `order_fare`;