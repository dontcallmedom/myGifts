ALTER TABLE `gft_gift` ADD `owner` VARCHAR (32 )AFTER `forUser` ;
update gft_gift set owner=forUser;
ALTER TABLE `gft_gift` ADD INDEX (`owner` );