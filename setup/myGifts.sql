
CREATE TABLE gft_claim (
  userId varchar(32) NOT NULL default '0',
  giftId int(11) NOT NULL default '0',
  comment varchar(255) default NULL,
  PRIMARY KEY  (userId,giftId)
);

CREATE TABLE gft_gift (
  id int(11) NOT NULL,
  forUser varchar(32) NOT NULL default '0',
  owner varchar(32) default NULL,
  name varchar(255) NOT NULL default '',
  comment varchar(255) default NULL,
  url varchar(255) default NULL,
  restricted tinyint(1) NOT NULL default '0',
  offered tinyint(4) NOT NULL default '0',
  offeredOn varchar(64) default NULL,
  picture varchar(255) default NULL,
  priority tinyint(4) default NULL,
  price float(24,2) default NULL,
  PRIMARY KEY  (id)
);

CREATE INDEX forUser ON gft_gift (forUser);
CREATE INDEX owner ON gft_gift (owner);

CREATE TABLE gft_user (
  id char(32) NOT NULL default '',
  name varchar(32) NOT NULL default '',
  password varchar(32) NOT NULL default '',
  birthDate date default NULL,
  email varchar(128) default NULL,
  lastLogin datetime default NULL,
  creationDate datetime NOT NULL default '0000-00-00 00:00:00',
  accessLevel tinyint(1) NOT NULL default '0',
  oldName varchar(32) default NULL,
  renameDate datetime default NULL,
  PRIMARY KEY  (id)
);
CREATE INDEX loginIdx ON gft_user (name,password);

CREATE TABLE gft_visibility (
  userId varchar(32) NOT NULL default '0',
  giftId int(11) NOT NULL default '0',
  comment varchar(255) default NULL,
  PRIMARY KEY  (userId,giftId)
);

CREATE TABLE gft_users_group (
  groupId int(11) NOT NULL default '0',
  userId char(32) NOT NULL default ''
);
CREATE INDEX group_id ON gft_users_group (groupId,userId);

CREATE TABLE gft_group (
  id int(11) NOT NULL,
  name varchar(32) NOT NULL default '',
  PRIMARY KEY  (id)
);

CREATE TABLE gft_params (name VARCHAR(32) NOT NULL, type VARCHAR(16) NOT NULL, valueInt INT, valueStr VARCHAR(64), PRIMARY KEY (name));
CREATE TABLE gft_alert (owner varchar(32) NOT NULL, list varchar(32) NOT NULL, type char(1) NOT NULL, lastSent INT, PRIMARY KEY  (owner,list));
insert into gft_params (name, type, valueInt) values("dbVersionNum", "int", 250);