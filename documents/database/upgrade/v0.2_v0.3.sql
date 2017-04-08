CREATE TABLE `version` (
	`name` VARCHAR(32) NOT NULL COMMENT '名称',
	`version` VARCHAR(32) NOT NULL COMMENT '版本',
	PRIMARY KEY (`name`)
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
;

INSERT INTO `version` (`name`, `version`) VALUES ('db', '0.3');
