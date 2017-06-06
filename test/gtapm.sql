/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : gtapm

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-06-13 11:33:39

select COLUMN_COMMENT from information_schema.COLUMNS where TABLE_SCHEMA='gtaoam' and TABLE_NAME='catalog_product_entity'
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uname` varchar(255),
  `email` varchar(255),
  `password` varchar(255),
  `role_id` varchar(100)  DEFAULT NULL,
  `dept_id` varchar(100)  DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rname` varchar(255),
  `rrule` varchar(255),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for dept
-- ----------------------------
DROP TABLE IF EXISTS `dept`;
CREATE TABLE `dept` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dname` varchar(255),
  `drule` varchar(255),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for modules
-- ----------------------------
DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(255),
  `entity_name` varchar(255),
  `sort_order` smallint(6),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for eav_attribute_set
-- ----------------------------
DROP TABLE IF EXISTS `attribute_set`;
CREATE TABLE `attribute_set` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Attribute Set Id',
  `module_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Type Id',
  `attribute_set_name` varchar(255) DEFAULT NULL COMMENT 'Attribute Set Name',
  `sort_order` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Sort Order',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for attributes
-- ----------------------------
DROP TABLE IF EXISTS `attribute`;
CREATE TABLE `attribute` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` smallint(5) NOT NULL DEFAULT '0' ,
  `attribute_code` varchar(255),
  `attribute_type` varchar(255),
  `frontend_input` varchar(255),
  `frontend_label` varchar(255),
  `is_required` smallint(5),
  `is_user_defined` smallint(5),
  `default_value` text,
  `is_unique` smallint(5),
  `is_option` smallint(5),
  `sort_order` smallint(6),
  `note` varchar(255),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of attributes
-- ----------------------------

-- ----------------------------
-- Table structure for entity_attribute
-- ----------------------------
DROP TABLE IF EXISTS `entity_attribute`;
CREATE TABLE `entity_attribute` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Entity Attribute Id',
  `module_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Entity Type Id',
  `attribute_set_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute Set Id',
  `attribute_group_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute Group Id',
  `attribute_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Attribute Id',
  `sort_order` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Sort Order',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for entities
-- ----------------------------
DROP TABLE IF EXISTS `entity`;
CREATE TABLE `entity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_id` smallint(5),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of entities
-- ----------------------------

-- ----------------------------
-- Table structure for edatetimes
-- ----------------------------
DROP TABLE IF EXISTS `edatetime`;
CREATE TABLE `edatetime` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` int(11),
  `attribute_id` smallint(5),
  `value` datetime,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of edatetimes
-- ----------------------------

-- ----------------------------
-- Table structure for edecimals
-- ----------------------------
DROP TABLE IF EXISTS `edecimal`;
CREATE TABLE `edecimal` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` int(11),
  `attribute_id` smallint(5),
  `value` decimal(12,2),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of edecimals
-- ----------------------------

-- ----------------------------
-- Table structure for eintegers
-- ----------------------------
DROP TABLE IF EXISTS `eint`;
CREATE TABLE `eint` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` int(11),
  `attribute_id` smallint(5),
  `value` int(11),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for etexts
-- ----------------------------
DROP TABLE IF EXISTS `etext`;
CREATE TABLE `etext` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` int(11),
  `attribute_id` smallint(5),
  `value` text,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of etexts
-- ----------------------------

-- ----------------------------
-- Table structure for evarchars
-- ----------------------------
DROP TABLE IF EXISTS `evarchar`;
CREATE TABLE `evarchar` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` int(11),
  `attribute_id` smallint(5),
  `value` varchar(255),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for eentity
-- ----------------------------
DROP TABLE IF EXISTS `eentity`;
CREATE TABLE `eentity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entity_id` int(11),
  `attribute_id` smallint(5),
  `value` int(11),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of evarchars
-- ----------------------------
/* ��ݵ���

INSERT INTO modules (`id`, `module_name`, `entity_name`) SELECT entity_type_id,entity_type_code,entity_type_code FROM gtaoam.eav_entity_type;

INSERT INTO attribute_set SELECT * FROM gtaoam.eav_attribute_set;

INSERT INTO attribute(id,`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`, `is_required`, `is_user_defined`, `default_value`, `is_unique`,  `note`) SELECT attribute_id,`entity_type_id`, `attribute_code`, `backend_type`, `frontend_input`, `frontend_label`, `is_required`, `is_user_defined`, `default_value`, `is_unique`, `note` FROM gtaoam.eav_attribute;

INSERT INTO entity_attribute SELECT * FROM gtaoam.eav_entity_attribute;

INSERT INTO entity (id,module_id,attribute_set_id) SELECT entity_id,entity_type_id,attribute_set_id FROM gtaoam.catalog_product_entity;

INSERT INTO edatetime (id,entity_id,attribute_id,value) SELECT value_id,entity_id,attribute_id,`value` FROM gtaoam.catalog_product_entity_datetime;

INSERT INTO edecimal (id,entity_id,attribute_id,value)
SELECT value_id,entity_id,attribute_id,`value` FROM gtaoam.catalog_product_entity_decimal;

INSERT INTO eint (id,entity_id,attribute_id,value)
SELECT value_id,entity_id,attribute_id,`value` FROM gtaoam.catalog_product_entity_int;

INSERT INTO etext (id,entity_id,attribute_id,value)
SELECT value_id,entity_id,attribute_id,`value` FROM gtaoam.catalog_product_entity_text;

INSERT INTO evarchar (id,entity_id,attribute_id,value)
SELECT value_id,entity_id,attribute_id,`value` FROM gtaoam.catalog_product_entity_varchar;

----------------------

INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_date', 'datetime', 'date', 'date');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_datetime', 'datetime', 'datetime', 'datetime');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_datetime-local', 'datetime', 'datetime-local', 'datetime-local');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_month', 'datetime', 'month', 'month');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_week', 'datetime', 'week', 'week');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_time', 'datetime', 'time', 'time');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_tel', 'varchar', 'tel', 'tel');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_email', 'varchar', 'email', 'email');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_hidden', 'varchar', 'hidden', 'hidden');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_search', 'varchar', 'search', 'search');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_password', 'varchar', 'password', 'password');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_url', 'varchar', 'url', 'url');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_range', 'varchar', 'range', 'range');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_color', 'varchar', 'color', 'color');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_file', 'varchar', 'file', 'file');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_text', 'varchar', 'text', 'text');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_number', 'int', 'number', 'number');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_select', 'int', 'select', 'select');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_radio', 'int', 'radio', 'radio');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_textarea', 'text', 'textarea', 'textarea');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_price', 'decimal', 'price', 'price');
INSERT INTO `attribute` (`module_id`, `attribute_code`, `attribute_type`, `frontend_input`, `frontend_label`) VALUES (5,'exp_button', 'varchar', 'button', 'button');

INSERT INTO entity_attribute (`module_id`, `attribute_set_id`, `attribute_group_id`, `attribute_id`) SELECT  5,14,21,id FROM attribute WHERE `attribute_code` LIKE 'exp_%';

 */
