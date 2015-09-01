CREATE DATABASE  IF NOT EXISTS `scicrunch` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `scicrunch`;
-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: scicrunch
-- ------------------------------------------------------
-- Server version	5.5.24-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `api_keys`
--

DROP TABLE IF EXISTS `api_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `name` text,
  `project` text,
  `community` int(11) DEFAULT NULL,
  `community_name` text,
  `description` text,
  `apiKey` text,
  `inactive` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `api_log`
--

DROP TABLE IF EXISTS `api_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version` int(11) DEFAULT NULL,
  `section` text,
  `action` text,
  `param1` text,
  `param2` text,
  `ip` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `collected`
--

DROP TABLE IF EXISTS `collected`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collected` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `collection` int(11) DEFAULT NULL,
  `community` int(11) DEFAULT NULL,
  `view` text,
  `uuid` text,
  `snippet` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `collections`
--

DROP TABLE IF EXISTS `collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `collections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `name` text,
  `count` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `communities`
--

DROP TABLE IF EXISTS `communities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `communities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `name` text,
  `description` text,
  `portalName` text,
  `url` text,
  `shortName` text,
  `logo` text,
  `private` int(11) DEFAULT NULL,
  `access` int(11) DEFAULT NULL,
  `resourceView` int(11) DEFAULT NULL,
  `dataView` int(11) DEFAULT NULL,
  `literatureView` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `community_access`
--

DROP TABLE IF EXISTS `community_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `community_access` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `name` text,
  `cid` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `date` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `community_categories`
--

DROP TABLE IF EXISTS `community_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `community_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `parent` text,
  `name` text,
  `title` text,
  `nifIDs` text,
  `urls` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `community_components`
--

DROP TABLE IF EXISTS `community_components`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `community_components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `component` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `type` text,
  `image` text,
  `text1` text,
  `text2` text,
  `text3` text,
  `color1` text,
  `color2` text,
  `color3` text,
  `icon1` text,
  `icon2` text,
  `icon3` text,
  `disabled` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `community_log`
--

DROP TABLE IF EXISTS `community_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `community_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `name` text,
  `cmid` int(11) DEFAULT NULL,
  `action` text,
  `euid` text,
  `resourceName` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `community_metadata`
--

DROP TABLE IF EXISTS `community_metadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `community_metadata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `name` text,
  `value` text,
  `active` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `community_pages`
--

DROP TABLE IF EXISTS `community_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `community_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `url` text,
  `title` text,
  `content` text,
  `active` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `community_relationships`
--

DROP TABLE IF EXISTS `community_relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `community_relationships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `rid` int(11) DEFAULT NULL,
  `type` text,
  `query` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `community_sections`
--

DROP TABLE IF EXISTS `community_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `community_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `pos` int(11) DEFAULT NULL,
  `title` varchar(32) DEFAULT NULL,
  `text` varchar(10300) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `community_structure`
--

DROP TABLE IF EXISTS `community_structure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `community_structure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `x` int(11) DEFAULT NULL,
  `y` int(11) DEFAULT NULL,
  `z` int(11) DEFAULT NULL,
  `category` text,
  `subcategory` text,
  `source` text,
  `filter` text,
  `facet` text,
  `active` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=258 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `community_structure`
--

LOCK TABLES `community_structure` WRITE;
/*!40000 ALTER TABLE `community_structure` DISABLE KEYS */;
INSERT INTO `community_structure` VALUES (33,216,7,0,0,0,'Resources',NULL,'nlx_144509-1',NULL,NULL,1,1412636151),(34,216,8,0,0,0,'Resources',NULL,'nlx_144509-1',NULL,NULL,1,1412702942),(242,216,1,0,1,0,'Materials','Antibody Suppliers','nif-0000-07730-1',NULL,NULL,1,NULL),(244,216,1,0,2,0,'Materials','Plamids','nif-0000-11872-1',NULL,'',1,NULL),(245,216,1,0,3,0,'Materials','Drugs','nif-0000-00234-1',NULL,'',1,NULL),(249,216,1,1,0,0,'Funding Agencies','Resources','nlx_144509-1',NULL,'&facet=Resource%20Type:funding%20resource',1,NULL),(250,216,1,1,1,0,'Funding Agencies','Awarded','nif-0000-10319-1',NULL,'',1,NULL),(251,216,1,1,2,0,'Funding Agencies','Opportunity','nif-0000-22393-1',NULL,'',1,NULL),(254,216,1,4,0,0,'Databases',NULL,'nlx_144509-1',NULL,'&facet=Resource%20Type:database&facet=Resource%20Type:web%20accessible%20database&facet=Resource%20Type:downloadable%20database',1,NULL),(255,216,9,NULL,NULL,NULL,'Resources',NULL,'nlx_144509-1',NULL,NULL,1,1414788753),(256,216,1,0,0,1,'Materials',NULL,'nlx_152633-2',NULL,NULL,1,1417543827),(257,216,1,0,0,2,'Materials',NULL,'nlx_152633-1',NULL,NULL,1,1417543884);
/*!40000 ALTER TABLE `community_structure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `component_data`
--

DROP TABLE IF EXISTS `component_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `component_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `component` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `image` text,
  `title` text,
  `icon` text,
  `description` text,
  `content` text,
  `link` text,
  `color` text,
  `disabled` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `end` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `component_tags`
--

DROP TABLE IF EXISTS `component_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `component_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_id` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `component` int(11) DEFAULT NULL,
  `tag` varchar(256) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_search` (`data_id`),
  KEY `tag_search` (`tag`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `components`
--

DROP TABLE IF EXISTS `components`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `components` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` int(11) DEFAULT NULL,
  `name` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `custom_columns`
--

DROP TABLE IF EXISTS `custom_columns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_columns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `vid` int(11) DEFAULT NULL,
  `type` text,
  `field` text,
  `x` int(11) DEFAULT NULL,
  `y` int(11) DEFAULT NULL,
  `z` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_columns`
--

LOCK TABLES `custom_columns` WRITE;
/*!40000 ALTER TABLE `custom_columns` DISABLE KEYS */;
INSERT INTO `custom_columns` VALUES (1,216,0,1,'text','Resource Type',0,0,0,1418416600),(2,216,0,1,'text','Keywords',0,0,1,1418416600),(3,216,0,1,'text','Resource ID',0,1,0,1418416600),(4,216,0,1,'text','Supporting Agency',0,1,1,1418416600),(5,216,0,1,'text','Related Condition',0,2,0,1418416600),(6,216,0,1,'text','Website Status',0,2,1,1418416600),(7,216,0,1,'map-text','Parent Organization',1,0,0,1418416600),(8,216,0,1,'literature-link','Mentioned In Literature',0,0,0,1418416600),(9,216,0,1,'literature-link','Reference',0,0,0,1418416600);
/*!40000 ALTER TABLE `custom_columns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `custom_views`
--

DROP TABLE IF EXISTS `custom_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_views` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `view` text,
  `title` text,
  `description` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `extended_data`
--

DROP TABLE IF EXISTS `extended_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extended_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `component` int(11) DEFAULT NULL,
  `data` int(11) DEFAULT NULL,
  `type` text,
  `name` text,
  `description` text,
  `link` text,
  `file` text,
  `extension` text,
  `views` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `form_log`
--

DROP TABLE IF EXISTS `form_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `rid` int(11) DEFAULT NULL,
  `message` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` int(11) DEFAULT NULL,
  `receiver` int(11) DEFAULT NULL,
  `view` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `type` varchar(128) DEFAULT NULL,
  `content` text,
  `seen` int(11) DEFAULT NULL,
  `timed` int(11) DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `end` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `note_time` (`time`),
  KEY `comm_note` (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `online_users`
--

DROP TABLE IF EXISTS `online_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `online_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `end` int(11) DEFAULT NULL,
  `last` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `registry_fork_log`
--

DROP TABLE IF EXISTS `registry_fork_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registry_fork_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `rid` text,
  `name` text,
  `action` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `registry_log`
--

DROP TABLE IF EXISTS `registry_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registry_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `rid` text,
  `name` text,
  `action` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `relational_types`
--

DROP TABLE IF EXISTS `relational_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `relational_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `name` text,
  `autocomplete` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `relationships`
--

DROP TABLE IF EXISTS `relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `relationships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) DEFAULT NULL,
  `nif_id` text,
  `type` text,
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `resource_columns`
--

DROP TABLE IF EXISTS `resource_columns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_columns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `name` text,
  `value` text,
  `link` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `column_id` (`rid`),
  FULLTEXT KEY `column_search` (`value`)
) ENGINE=MyISAM AUTO_INCREMENT=671704 DEFAULT CHARSET=latin1
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `resource_data`
--

DROP TABLE IF EXISTS `resource_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `euid` text,
  `view` text,
  `cid` int(11) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `dislikes` int(11) DEFAULT NULL,
  `tag` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `resource_fields`
--

DROP TABLE IF EXISTS `resource_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `tid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `required` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `name` text,
  `type` text,
  `display` text,
  `autocomplete` text,
  `alt` text,
  `login` int(11) DEFAULT NULL,
  `curator` int(11) DEFAULT NULL,
  `hidden` int(11) DEFAULT NULL,
  `weight` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `resource_type`
--

DROP TABLE IF EXISTS `resource_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `name` text,
  `description` text,
  `parent` int(11) DEFAULT NULL,
  `facet` text,
  `url` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `resource_versions`
--

DROP TABLE IF EXISTS `resource_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resource_versions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `email` text,
  `cid` int(11) DEFAULT NULL,
  `rid` int(11) DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `status` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `resources`
--

DROP TABLE IF EXISTS `resources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `email` text,
  `cid` int(11) DEFAULT NULL,
  `version` int(11) DEFAULT NULL,
  `rid` text,
  `original_id` text,
  `pid` int(11) DEFAULT NULL,
  `parent` text,
  `type` text,
  `typeID` int(11) DEFAULT NULL,
  `status` text,
  `insert_time` int(11) DEFAULT NULL,
  `edit_time` int(11) DEFAULT NULL,
  `curate_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=157 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `saved_history`
--

DROP TABLE IF EXISTS `saved_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saved_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `search` int(11) DEFAULT NULL,
  `week` int(11) DEFAULT NULL,
  `main` int(11) DEFAULT NULL,
  `view` text,
  `count` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `saved_searches`
--

DROP TABLE IF EXISTS `saved_searches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `saved_searches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `name` text,
  `cid` int(11) DEFAULT NULL,
  `category` text,
  `subcategory` text,
  `nif` text,
  `query` text,
  `display` text,
  `params` text,
  `weekly` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scicrunch_communities`
--

DROP TABLE IF EXISTS `scicrunch_communities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scicrunch_communities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner` int(11) DEFAULT NULL,
  `name` text,
  `description` text,
  `shortName` text,
  `portal` text,
  `portalName` varchar(32) DEFAULT NULL,
  `url` text,
  `wiki` text,
  `private` tinyint(2) DEFAULT NULL,
  `ontology` text,
  `logo` text,
  `twitter` text,
  `twitterID` text,
  `headColor` text,
  `textColor` text,
  `dropdownColor` text,
  `hoverColor` text,
  `homeTextColor` text,
  `resourceView` int(11) DEFAULT NULL,
  `dataView` int(11) DEFAULT NULL,
  `literatureView` int(11) DEFAULT NULL,
  `access` text,
  `grants` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `portalName` (`portalName`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scicrunch_content`
--

DROP TABLE IF EXISTS `scicrunch_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scicrunch_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `type` text,
  `content` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scicrunch_events`
--

DROP TABLE IF EXISTS `scicrunch_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scicrunch_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `type` text,
  `name` text,
  `content` text,
  `notice` int(11) DEFAULT NULL,
  `start` int(11) DEFAULT NULL,
  `end` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scicrunch_notifications`
--

DROP TABLE IF EXISTS `scicrunch_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scicrunch_notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `type` text,
  `content` text,
  `seen` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=522 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scicrunch_pages`
--

DROP TABLE IF EXISTS `scicrunch_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scicrunch_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `name` text,
  `content` text,
  `active` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `scicrunch_sources`
--

DROP TABLE IF EXISTS `scicrunch_sources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scicrunch_sources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nif` varchar(25) DEFAULT NULL,
  `source` text,
  `view` text,
  `description` text,
  `image` text,
  `data` int(11) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `updated` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=251 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `search_data`
--

DROP TABLE IF EXISTS `search_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(512) DEFAULT NULL,
  `xml` mediumtext,
  PRIMARY KEY (`id`),
  KEY `url_search` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `search_log`
--

DROP TABLE IF EXISTS `search_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `search_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `community` text,
  `category` text,
  `subcategory` text,
  `nif` text,
  `query` text,
  `filter` int(11) DEFAULT NULL,
  `siteLink` text,
  `serviceLink` text,
  `count` int(11) DEFAULT NULL,
  `ip` text,
  `hidden` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=317 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `snippets`
--

DROP TABLE IF EXISTS `snippets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `snippets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `view` text,
  `sourceName` text,
  `snippet` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_log`
--

DROP TABLE IF EXISTS `user_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `name` text,
  `location` text,
  `action` text,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=284 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` int(11) DEFAULT NULL,
  `email` text,
  `password` text,
  `salt` text,
  `banned` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `firstName` text,
  `middleInitial` text,
  `lastName` text,
  `created` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;


create table error_notifications (id int primary key auto_increment, uid int, type text, message text, seen int, time int);
create table fake_registry (resource_name text,description text,url text, keyword text, nif_pmid_display text, relatedto text, parent_organization text, abbrev text, synonym text, supporting_agency text, grants text, resource_type text, listedby text, lists text, usedby text, uses text, recommendedby text, recommends text, availability text, termsofuseurl text, alturl text, oldurl text, xref text, relation text, related_application text, related_disease text, located_in text, processing text, species text, supercategory text, publicationlink text, resource_pubmedids_display text, comment text, editorial_note text, resource_updated text, valid_status text, website_status text, curationstatus text, resource_type_ids text, see_full_record text, relatedtoforfacet text, date_created text, date_updated text);

CREATE TABLE `test_xmls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xml` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1

--
-- Dumping data for table `component_data`
--

LOCK TABLES `component_data` WRITE;
/*!40000 ALTER TABLE `component_data` DISABLE KEYS */;
INSERT INTO `component_data` VALUES (2,216,1,102,NULL,NULL,'Testing Community Versions',NULL,'Some description','<p>content goes here</p>',NULL,'0',0,0,1410383837),(3,216,0,104,NULL,NULL,'How do I do this?',NULL,'By being more awesome and not asking dumb questions.',NULL,NULL,'0',0,0,1410806723),(4,216,0,105,NULL,NULL,'New Tutorial',NULL,'This is a new tutorial to showcase how to make tutorials and such.','<p>Some content for the tutorial</p>',NULL,'000000',0,0,1410969216),(5,216,0,104,NULL,NULL,'Random Question?',NULL,'No Random Question',NULL,NULL,'0',0,0,1411073800),(6,216,0,104,NULL,NULL,'Unanswered Question?',NULL,NULL,NULL,NULL,'000000',0,0,1411140922),(7,216,1,30,0,NULL,'New Data','fa fa-bars','Some description of things',NULL,'http://alpha.scicrunch.com',NULL,0,0,1411669284),(8,216,1,22,0,'dknet_data_919953.png','I am News!',NULL,NULL,NULL,'http://alpha.scicrunch.com',NULL,0,1,1411669941),(10,216,1,22,1,'dknet_data_322876.png','Some News Title 1',NULL,NULL,NULL,'http://alpha.scicrunch.com/dknet',NULL,0,0,1411685443),(11,216,0,200,NULL,NULL,'Version 0.19 - Resource Registry Part 2',NULL,'Placeholder&nbsp;&nbsp;&nbsp;&nbsp;','<p><span style=\"font-weight: bold;\">New Features:</span></p><p><ol><li>Tabularized Account Pages</li></ol></p>',NULL,'000000',0,16,1411935391),(12,216,1,104,NULL,NULL,'What is dkNET?',NULL,NULL,NULL,NULL,'000000',0,0,1413079521),(13,216,0,10,0,'_data_712830.png','Beta Testing Begins',NULL,'Please Read the best testing guidelines',NULL,'http://alpha.scicrunch.com/news/3',NULL,0,0,1413316591),(14,216,0,201,0,'','Fake News Story','','Testing out the different timeline options for containers. Need to make sure i can switch freely and that the style is consistent.','<p><br></p>','','0',0,2,1413316591),(15,216,0,202,NULL,NULL,'Some news',NULL,'Hello! &nbsp; &nbsp;','<p><br></p>',NULL,'0',0,0,1413828932),(16,216,1,202,NULL,NULL,'Hello',NULL,'Bye','<p><br></p>',NULL,'000000',0,9,1413835920),(17,216,1,202,NULL,NULL,'Hello1',NULL,'Bye','<p><br></p>',NULL,'000000',0,9,1413835920),(18,216,1,202,NULL,NULL,'Hello2',NULL,'Bye','<p><br></p>',NULL,'000000',0,9,1413835920),(19,216,1,202,NULL,NULL,'Hello3',NULL,'Bye','<p><br></p>',NULL,'000000',0,9,1413835920),(20,216,1,202,NULL,NULL,'Hello4',NULL,'Bye','<p><br></p>',NULL,'000000',0,9,1413835920),(21,216,1,202,NULL,NULL,'Hello5',NULL,'Bye','<p><br></p>',NULL,'000000',0,9,1413835920),(22,216,1,202,NULL,NULL,'Hello6',NULL,'Bye','<p><br></p>',NULL,'000000',0,9,1413835920),(23,216,1,202,NULL,NULL,'Hello7',NULL,'Bye','<p><br></p>',NULL,'000000',0,9,1413835920),(24,216,1,202,NULL,NULL,'Hello8',NULL,'Bye','<p><br></p>',NULL,'000000',0,9,1413835920),(25,216,1,202,NULL,NULL,'Hello9',NULL,'Bye','<p><br></p>',NULL,'000000',0,9,1413835920),(26,216,1,202,NULL,NULL,'Hello10',NULL,'Bye','<p><br></p>',NULL,'000000',0,9,1413835920),(27,216,1,202,NULL,NULL,'Hello11',NULL,'Bye','<p><br></p>',NULL,'000000',0,9,1413835920),(28,216,1,202,NULL,NULL,'Hello12',NULL,'Bye','<p><br></p>',NULL,'000000',0,10,1413835920),(29,216,1,202,NULL,NULL,'Hello13!',NULL,'Bye','<p><br></p>',NULL,NULL,0,43,1413835920),(30,216,8,204,NULL,NULL,'New Content',NULL,'Something something checking','<p><br></p>',NULL,'000000',0,0,1413914555),(31,216,1,205,NULL,NULL,'New Dataset',NULL,'This dataset does something important','<p><br></p>',NULL,'000000',0,0,1414000566),(32,216,1,205,NULL,NULL,'Second Dataset',NULL,'Some dataset',NULL,NULL,'nlx_144509-1',0,34,1414002725),(33,216,0,206,NULL,NULL,'Dataset 1','1.0,2.2','Some other description that needs changing',NULL,NULL,'nif-0000-07730-1',0,0,1414173224),(34,216,0,206,NULL,NULL,'Dataset 2','7.3,8.0','Hello',NULL,'','nlx_144509-1',0,16,1414173483),(35,216,0,10,1,'_data_125885.png','Next',NULL,'blah',NULL,'',NULL,0,0,1414791945),(36,216,0,10,2,'_data_758942.png','Another',NULL,'something',NULL,'',NULL,0,0,1414791972),(37,216,9,13,0,'blank_data_842408.png','A new Slide',NULL,'Some category description you can add',NULL,'http://alpha.scicrunch.com/dknet','ffffff',0,0,1415048474),(38,216,9,13,1,'blank_data_992127.png','Another Slide',NULL,'Adding content to your homepage operates differently than just editing the appearance.',NULL,'http://alpha.scicrunch.com/news/3','ffffff',0,0,1415049505),(39,216,9,35,0,'fafafa','First Category','fa fa-adjust','Some category description you can add',NULL,'http://alpha.scicrunch.com/faq/tutorials/11','555555',0,0,1415052203);
/*!40000 ALTER TABLE `component_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `resource_fields`
--

LOCK TABLES `resource_fields` WRITE;
/*!40000 ALTER TABLE `resource_fields` DISABLE KEYS */;
INSERT INTO `resource_fields` VALUES (21,0,0,0,1,0,'Resource Name','text','title','','The name of the unique resource you are submitting',0,0,0,1418669078),(22,0,0,0,1,1,'Description','textarea','description','','A description about what the resource is and what it is used for',0,0,0,1418669078),(23,0,0,0,1,2,'Resource URL','text','url','','The location of this resource for others to find and use',0,0,0,1418669078),(24,0,0,0,0,3,'Keywords','text','text','','Words and concepts that relate to this resource',0,0,0,1418669078),(25,0,0,0,0,4,'Defining Citation','text','literature-text','','The paper that outlines what this resource is about',0,0,0,1418669078),(26,0,0,0,0,5,'Related To','text','resource','','What other resource is this one related to',0,0,0,1418669078),(27,0,0,0,0,6,'Parent Organization','text','map-text','','The organization that created or is managing this resource',0,0,0,1418669078),(28,0,0,0,0,7,'Abbreviation','text','text','','Any abbreviations this resource has',0,0,0,1418669078),(29,0,0,0,0,8,'Synonyms','text','text','','Any synonyms for this resource',0,0,0,1418669078),(30,0,0,0,0,9,'Funding Information','text','text','','Any funding or grant information about this resource',0,0,0,1418669078),(31,216,2,1,0,1,'Another New Field','text','text','Assay','Some Tooltip',NULL,NULL,NULL,1418761810),(32,216,4,1,0,1,'Blah','text','text','','',NULL,NULL,NULL,1418764313);
/*!40000 ALTER TABLE `resource_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `communities`
--

LOCK TABLES `communities` WRITE;
/*!40000 ALTER TABLE `communities` DISABLE KEYS */;
INSERT INTO `communities` VALUES (1,216,'NIDDK Interconnectivity Network','dkNET provides a catalog of resources important to research on kidney, urologic, hematologic, digestive, metabolic and endocrine diseases, diabetes and nutrition.','dknet','http://dknet.org','dkNET','dknet.png',0,0,1,1,1,1412635980),(7,216,'A Unify Test','A fake community for testing the unify create forms.','unify','','unify',NULL,1,0,1,1,1,1412636151),(8,216,'Logo Community','A test of grabbing dynamic logos if none are provided','logo','','logo','_327606.png',0,0,1,1,1,1412702941),(9,216,'Blank Community','Some COmmunity','blank','','blank','blank_257446.png',1,0,1,1,1,1414788752);
/*!40000 ALTER TABLE `communities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `community_components`
--

LOCK TABLES `community_components` WRITE;
/*!40000 ALTER TABLE `community_components` DISABLE KEYS */;
INSERT INTO `community_components` VALUES (1,216,1,3,0,'header',NULL,NULL,NULL,NULL,'18ba9b',NULL,NULL,NULL,NULL,NULL,1,1409160530),(2,216,1,92,0,'footer',NULL,'25, Lorem Lis Street, OrangeCalifornia, USPhone: 800 123 3456Fax: 800 123 3456Email:&nbsp;info@anybiz.com','Insert a description of your community here! &#34;hello&#34;!',NULL,'72c02c','585f69','3e4753',NULL,NULL,NULL,1,1409160530),(4,216,1,31,2,'body','','<h2>Create Communities</h2><p>Create communities to create personalized data exploration portals for yourself or your group to work with</p>','<h2>Share Resources</h2><p>Join the largest scientific resource registry and add, share, and search for new resources with your community.</p>','<h2>Explore Data</h2><p>Explore our 300+ data sources with over 800 million records on your own, or through one of the many customized community portals.</p>',NULL,NULL,NULL,'fa fa-building-o','fa fa-exchange','fa fa-check-circle-o',NULL,1409160530),(5,216,1,30,3,'body','','Sample Header!','neuinfo','337978929476411393',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1409160530),(7,216,1,22,6,'body','','Recommended News','Some descriptive text about what this section is supposed to be for this community.',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1409160530),(8,216,1,100,0,'breadcrumbs','dknet_8.jpg','','','','ffffff','72c02c','585f69','','','',0,1409160530),(9,216,1,101,0,'search','','Search through dkNET!','* Search Tips can go here','','585f69','72c02c','','','','',0,1409160530),(10,216,1,102,0,'version','','Development Release Notes','','','','','','','','',0,1409160530),(11,216,1,103,0,'blog','','dkNET Blog','','','','','','','','',0,1409160530),(14,216,1,21,1,'body',NULL,'Register a Resource!','Add a resource to our resource registry to get an identifier for your resource and share it with others.','Add Resource','72c02c','5fb611',NULL,'fa fa-exchange',NULL,NULL,NULL,1411589826),(15,216,1,11,4,'body','dknet_552002.png',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1411593057),(24,0,0,2,0,'header',NULL,NULL,NULL,NULL,'ff0000',NULL,NULL,NULL,NULL,NULL,0,1412282974),(25,0,0,92,0,'footer',NULL,'<p>Our Information</p>','Welcome to the SciCrunch Community.',NULL,'72c02c','585f69','3e4753',NULL,NULL,NULL,0,1412282974),(26,0,0,100,0,'breadcrumbs',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1412282974),(27,0,0,101,0,'search',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1412282974),(28,0,0,10,0,'body',NULL,NULL,NULL,NULL,'72c02c','585f69','3e4753',NULL,NULL,NULL,0,1412282974),(29,0,0,21,1,'body','/create/resource','Register a Resource','Add a resource to our resource registry to get an identifier for your resource and share it with others.','Add Resource','72c02c','5fb611',NULL,'fa fa-plus',NULL,NULL,0,1412282974),(30,0,0,31,2,'body',NULL,'<h2>Create Communities</h2><p>Create communities to create personalized data exploration portals for yourself or your group to work with</p>','<h2>Share Resources</h2><p>Join the largest scientific resource registry and add, share, and search for new resources with your community.</p>','<h2>Receive Updates</h2><p>Join our community to receive updates about data and our organization. See our personalized tutorials and ask us questions.</p>',NULL,NULL,NULL,'fa fa-plus-circle','fa fa-globe','fa fa-database',0,1412282974),(32,216,0,34,4,'body',NULL,'About Us','SciCrunch is a community creation website the emphasizes sharing data within your community and to other communities. With a SciCrunch Community you get access to our extensive custom portals and 200+ data sources we have collected to tailor to your needs.',NULL,'72c02c',NULL,NULL,NULL,NULL,NULL,NULL,1412360291),(33,216,1,23,5,'body','','https://www.google.com/calendar/embed?showTitle=0&showNav=0&showDate=0&showPrint=0&showTabs=0&showCalendars=0&mode=AGENDA&height=400&wkst=1&bgcolor=%23FFFFFF&src=c59nv1610ishqmj94e3lncpd2c%40group.calendar.google.com&color=%232952A3&ctz=America%2FLos_Angeles','http://www.youtube.com/embed/Squv4KI751w',NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1409160530),(34,0,7,0,0,'header',NULL,NULL,NULL,NULL,'72c02c',NULL,NULL,NULL,NULL,NULL,0,1412636151),(35,0,7,92,0,'footer',NULL,'<p>Our Information</p>','Welcome to the A Unify Test Community.',NULL,'72c02c','585f69','3e4753',NULL,NULL,NULL,0,1412636151),(36,0,7,100,0,'breadcrumbs',NULL,NULL,NULL,NULL,'ffffff','72c02c','585f69',NULL,NULL,NULL,0,1412636151),(37,0,7,101,0,'search',NULL,'Search through unify','Selecting a term from the dropdown will search for that entity exactly',NULL,'585f69','72c02c',NULL,NULL,NULL,NULL,0,1412636151),(38,0,7,12,0,'body','default-12.png','Discover New Things','Search for data related to your query',NULL,'ffffff','72c02c',NULL,NULL,NULL,NULL,0,1412636151),(39,0,7,21,1,'body','/unify/about/resource','Register a Resource!','Add a resource to our resource registry to get an identifier for your resource and share it with others.','Add Resource','72c02c','5fb611',NULL,'fa fa-plus',NULL,NULL,0,1412636151),(40,0,7,31,2,'body',NULL,'<h2>Search our Categories</h2><p>Search through data in a way unique to A Unify Test and find what is relevant to you.</p>','<h2>Share Resources</h2><p>Join the largest scientific resource registry and add, share, and search for new resources with your community.</p>','<h2>Receive Updates</h2><p>Join our community to receive updates, learn about our organization, see our tutorials and ask us questions.</p>',NULL,NULL,NULL,'fa fa-search','fa fa-globe','fa fa-database',0,1412636151),(41,0,7,11,3,'body','default-11.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1412636151),(42,0,7,34,4,'body',NULL,'About Us','A fake community for testing the unify create forms.',NULL,'72c02c',NULL,NULL,NULL,NULL,NULL,0,1412636151),(43,0,8,0,0,'header',NULL,NULL,NULL,NULL,'72c02c',NULL,NULL,NULL,NULL,NULL,0,1412702942),(44,0,8,92,0,'footer',NULL,'<p>Our Information</p>','Welcome to the Logo Community Community.',NULL,'72c02c','585f69','3e4753',NULL,NULL,NULL,0,1412702942),(45,0,8,100,0,'breadcrumbs',NULL,NULL,NULL,NULL,'ffffff','72c02c','585f69',NULL,NULL,NULL,0,1412702942),(46,0,8,101,0,'search',NULL,'Search through logo','Selecting a term from the dropdown will search for that entity exactly',NULL,'585f69','72c02c',NULL,NULL,NULL,NULL,0,1412702942),(47,0,8,12,0,'body','default-12.png','Discover New Things','Search for data related to your query',NULL,'ffffff','72c02c',NULL,NULL,NULL,NULL,0,1412702942),(48,0,8,21,1,'body','/logo/about/resource','Register a Resource','Add a resource to our resource registry to get an identifier for your resource and share it with others.','Add Resource','72c02c','5fb611',NULL,'fa fa-plus',NULL,NULL,0,1412702942),(49,0,8,31,2,'body',NULL,'<h2>Search our Categories</h2><p>Search through data in a way unique to Logo Community and find what is relevant to you.</p>','<h2>Share Resources</h2><p>Join the largest scientific resource registry and add, share, and search for new resources with your community.</p>','<h2>Receive Updates</h2><p>Join our community to receive updates, learn about our organization, see our tutorials and ask us questions.</p>',NULL,NULL,NULL,'fa fa-search','fa fa-globe','fa fa-database',0,1412702942),(50,0,8,11,3,'body','default-11.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,1412702942),(51,0,8,34,4,'body',NULL,'About Us','A test of grabbing dynamic logos if none are provided',NULL,'72c02c',NULL,NULL,NULL,NULL,NULL,0,1412702942),(52,0,0,200,1,'page',NULL,'Release Notes','versions',NULL,NULL,NULL,NULL,'timeline1',NULL,NULL,0,1412282974),(53,0,0,201,0,'page','','News','news','','','','','timeline2','','',0,1412282974),(56,216,1,202,0,'page',NULL,'Release Notes','versions',NULL,NULL,NULL,NULL,'timeline1',NULL,NULL,NULL,1413828889),(57,216,1,203,1,'page',NULL,'News','news',NULL,NULL,NULL,NULL,'timeline2',NULL,NULL,NULL,1413828907),(58,216,8,204,NULL,'page',NULL,'Timeline Check','timeline',NULL,NULL,NULL,NULL,'timeline1',NULL,NULL,NULL,1413914514),(59,216,1,205,2,'page',NULL,'Datasets','datasets','A record of all available datasets through us',NULL,NULL,NULL,'files1',NULL,NULL,NULL,1413828907),(60,216,0,206,2,'page',NULL,'Datasets','datasets','<p>Something</p>',NULL,NULL,NULL,'files1','Custom 1,Custom 2',NULL,NULL,1414173207),(61,0,9,2,0,'header',NULL,NULL,NULL,NULL,'72c02c',NULL,NULL,NULL,NULL,NULL,0,1414788752),(62,0,9,92,0,'footer',NULL,'<p>Our Information</p>','Welcome to the Blank Community Community.',NULL,'72c02c','585f69','3e4753',NULL,NULL,NULL,0,1414788752),(63,0,9,100,0,'breadcrumbs',NULL,NULL,NULL,NULL,'ffffff','72c02c','585f69',NULL,NULL,NULL,0,1414788752),(64,0,9,101,0,'search',NULL,'Search through blank','Selecting a term from the dropdown will search for that entity exactly',NULL,'585f69','72c02c',NULL,NULL,NULL,NULL,0,1414788752),(66,0,9,21,2,'body','/blank/register','Join our Community','Joining our community let\'s you submit resources to our registry and get updates from us.','Join Now','72c02c','5fb611',NULL,'fa fa-plus',NULL,NULL,0,1414788752),(69,0,9,34,4,'body',NULL,'About Us','Some COmmunity',NULL,'72c02c',NULL,NULL,NULL,NULL,NULL,0,1414788753),(70,216,9,13,0,'body',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1415043677),(71,216,9,35,3,'body',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1415052161),(73,216,9,24,1,'body',NULL,'Search through our resources','Search Now',NULL,'121212','555555',NULL,NULL,NULL,NULL,NULL,1415056181),(74,216,9,25,5,'body','_386627.png','Some text has to go here','<p>Need something pretty long here, so just going to repeat this over and over again.&nbsp;<span style=\"line-height: 20.1499996185303px;\">Need something pretty long here, so just going to repeat this over and over again.&nbsp;</span><span style=\"line-height: 20.1499996185303px;\">Need something pretty long here, so just going to repeat this over and over again.&nbsp;</span><span style=\"line-height: 20.1499996185303px;\">Need something pretty long here, so just going to repeat this over and over again.&nbsp;</span><span style=\"line-height: 20.1499996185303px;\">Need something pretty long here, so just going to repeat this over and over again.&nbsp;</span><span style=\"line-height: 20.1499996185303px;\">Need something pretty long here, so just going to repeat this over and over again.</span></p><p><span style=\"line-height: 20.1499996185303px;\">Need something pretty long here, so just going to repeat this over and over again.&nbsp;</span><span style=\"line-height: 20.1499996185303px;\">Need something pretty long here, so just going to repeat this over and over again.&nbsp;</span><span style=\"line-height: 20.1499996185303px;\">Need something pretty long here, so just going to repeat this over and over again.</span><span style=\"line-height: 20.1499996185303px;\"><br></span></p>','What\'s Up','33bb55','555555','ffffff','fa fa-arrows-h','http://alpha.scicrunch.com',NULL,NULL,1415127890),(75,216,0,14,3,'body','_915162.png','Welcome to SciCrunch','<p>In SciCrunch we house several different communities and data sources from across all fields of science.</p>',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1415385426),(76,216,1,12,0,'body',NULL,'Search for DKNET related data','Search Now',NULL,'ffffff','7ccf43','c943b7',NULL,NULL,NULL,NULL,1416591594),(77,216,1,207,3,'page',NULL,'Fake Container','fake','<p>Fake container to test position</p>',NULL,NULL,NULL,'timeline1','',NULL,NULL,1416608926),(78,216,1,208,4,'page',NULL,'Some Static','Static','<p>the static text</p>',NULL,NULL,NULL,'static','',NULL,NULL,1416943973);
/*!40000 ALTER TABLE `community_components` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `components`
--

LOCK TABLES `components` WRITE;
/*!40000 ALTER TABLE `components` DISABLE KEYS */;
/*!40000 ALTER TABLE `components` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `custom_views`
--

LOCK TABLES `custom_views` WRITE;
/*!40000 ALTER TABLE `custom_views` DISABLE KEYS */;
INSERT INTO `custom_views` VALUES (1,216,0,'nlx_144509-1','Resource Name','Description',1418416600);
/*!40000 ALTER TABLE `custom_views` ENABLE KEYS */;
UNLOCK TABLES;


/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-12-22  9:04:02
