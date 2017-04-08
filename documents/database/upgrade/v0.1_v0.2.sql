ALTER TABLE `price_info`
	DROP COLUMN `id`,
	DROP PRIMARY KEY,
	DROP INDEX `software_id`,
	ADD PRIMARY KEY (`software_id`);
