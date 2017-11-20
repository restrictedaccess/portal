ALTER TABLE `chrisdb`.`history` ADD COLUMN `subject` TEXT AFTER `date_created`;
ALTER TABLE `chrisdb`.`history` MODIFY COLUMN `history` TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci;