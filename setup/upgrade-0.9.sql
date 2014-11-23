ALTER TABLE `gft_user` ADD `birthDate` DATE AFTER `password` ,
ADD `email` VARCHAR (128 ) AFTER `birthDate` ;

ALTER TABLE `gft_gift` ADD `offered` TINYINT DEFAULT '0' NOT NULL ,
ADD `offeredOn` VARCHAR( 64 ),
ADD `picture` VARCHAR(255) default NULL,
ADD `price` FLOAT(24,2) unsigned NOT NULL default 0.00,
ADD `priority` tinyint(4) default NULL ;

CREATE TABLE `gft_users_group` (
  `groupId` int(11) NOT NULL default '0',
  `userId` char(32) NOT NULL default '',
  KEY `group_id` (`groupId`,`userId`)
) TYPE=MyISAM;

CREATE TABLE `gft_group` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;