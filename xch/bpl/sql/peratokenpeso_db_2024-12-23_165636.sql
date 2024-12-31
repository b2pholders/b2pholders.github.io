-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: peratokenpeso_db
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `idCountry` int NOT NULL,
  `countryCode` char(2) NOT NULL DEFAULT '',
  `countryName` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`idCountry`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'AD','Andorra'),(2,'AE','United Arab Emirates'),(3,'AF','Afghanistan'),(4,'AG','Antigua and Barbuda'),(5,'AI','Anguilla'),(6,'AL','Albania'),(7,'AM','Armenia'),(8,'AO','Angola'),(9,'AQ','Antarctica'),(10,'AR','Argentina'),(11,'AS','American Samoa'),(12,'AT','Austria'),(13,'AU','Australia'),(14,'AW','Aruba'),(15,'AX','Åland'),(16,'AZ','Azerbaijan'),(17,'BA','Bosnia and Herzegovina'),(18,'BB','Barbados'),(19,'BD','Bangladesh'),(20,'BE','Belgium'),(21,'BF','Burkina Faso'),(22,'BG','Bulgaria'),(23,'BH','Bahrain'),(24,'BI','Burundi'),(25,'BJ','Benin'),(26,'BL','Saint Barthélemy'),(27,'BM','Bermuda'),(28,'BN','Brunei'),(29,'BO','Bolivia'),(30,'BQ','Bonaire'),(31,'BR','Brazil'),(32,'BS','Bahamas'),(33,'BT','Bhutan'),(34,'BV','Bouvet Island'),(35,'BW','Botswana'),(36,'BY','Belarus'),(37,'BZ','Belize'),(38,'CA','Canada'),(39,'CC','Cocos [Keeling] Islands'),(40,'CD','Democratic Republic of the Congo'),(41,'CF','Central African Republic'),(42,'CG','Republic of the Congo'),(43,'CH','Switzerland'),(44,'CI','Ivory Coast'),(45,'CK','Cook Islands'),(46,'CL','Chile'),(47,'CM','Cameroon'),(48,'CN','China'),(49,'CO','Colombia'),(50,'CR','Costa Rica'),(51,'CU','Cuba'),(52,'CV','Cape Verde'),(53,'CW','Curacao'),(54,'CX','Christmas Island'),(55,'CY','Cyprus'),(56,'CZ','Czechia'),(57,'DE','Germany'),(58,'DJ','Djibouti'),(59,'DK','Denmark'),(60,'DM','Dominica'),(61,'DO','Dominican Republic'),(62,'DZ','Algeria'),(63,'EC','Ecuador'),(64,'EE','Estonia'),(65,'EG','Egypt'),(66,'EH','Western Sahara'),(67,'ER','Eritrea'),(68,'ES','Spain'),(69,'ET','Ethiopia'),(70,'FI','Finland'),(71,'FJ','Fiji'),(72,'FK','Falkland Islands'),(73,'FM','Micronesia'),(74,'FO','Faroe Islands'),(75,'FR','France'),(76,'GA','Gabon'),(77,'GB','United Kingdom'),(78,'GD','Grenada'),(79,'GE','Georgia'),(80,'GF','French Guiana'),(81,'GG','Guernsey'),(82,'GH','Ghana'),(83,'GI','Gibraltar'),(84,'GL','Greenland'),(85,'GM','Gambia'),(86,'GN','Guinea'),(87,'GP','Guadeloupe'),(88,'GQ','Equatorial Guinea'),(89,'GR','Greece'),(90,'GS','South Georgia and the South Sandwich Islands'),(91,'GT','Guatemala'),(92,'GU','Guam'),(93,'GW','Guinea-Bissau'),(94,'GY','Guyana'),(95,'HK','Hong Kong'),(96,'HM','Heard Island and McDonald Islands'),(97,'HN','Honduras'),(98,'HR','Croatia'),(99,'HT','Haiti'),(100,'HU','Hungary'),(101,'ID','Indonesia'),(102,'IE','Ireland'),(103,'IL','Israel'),(104,'IM','Isle of Man'),(105,'IN','India'),(106,'IO','British Indian Ocean Territory'),(107,'IQ','Iraq'),(108,'IR','Iran'),(109,'IS','Iceland'),(110,'IT','Italy'),(111,'JE','Jersey'),(112,'JM','Jamaica'),(113,'JO','Jordan'),(114,'JP','Japan'),(115,'KE','Kenya'),(116,'KG','Kyrgyzstan'),(117,'KH','Cambodia'),(118,'KI','Kiribati'),(119,'KM','Comoros'),(120,'KN','Saint Kitts and Nevis'),(121,'KP','North Korea'),(122,'KR','South Korea'),(123,'KW','Kuwait'),(124,'KY','Cayman Islands'),(125,'KZ','Kazakhstan'),(126,'LA','Laos'),(127,'LB','Lebanon'),(128,'LC','Saint Lucia'),(129,'LI','Liechtenstein'),(130,'LK','Sri Lanka'),(131,'LR','Liberia'),(132,'LS','Lesotho'),(133,'LT','Lithuania'),(134,'LU','Luxembourg'),(135,'LV','Latvia'),(136,'LY','Libya'),(137,'MA','Morocco'),(138,'MC','Monaco'),(139,'MD','Moldova'),(140,'ME','Montenegro'),(141,'MF','Saint Martin'),(142,'MG','Madagascar'),(143,'MH','Marshall Islands'),(144,'MK','Macedonia'),(145,'ML','Mali'),(146,'MM','Myanmar [Burma]'),(147,'MN','Mongolia'),(148,'MO','Macao'),(149,'MP','Northern Mariana Islands'),(150,'MQ','Martinique'),(151,'MR','Mauritania'),(152,'MS','Montserrat'),(153,'MT','Malta'),(154,'MU','Mauritius'),(155,'MV','Maldives'),(156,'MW','Malawi'),(157,'MX','Mexico'),(158,'MY','Malaysia'),(159,'MZ','Mozambique'),(160,'NA','Namibia'),(161,'NC','New Caledonia'),(162,'NE','Niger'),(163,'NF','Norfolk Island'),(164,'NG','Nigeria'),(165,'NI','Nicaragua'),(166,'NL','Netherlands'),(167,'NO','Norway'),(168,'NP','Nepal'),(169,'NR','Nauru'),(170,'NU','Niue'),(171,'NZ','New Zealand'),(172,'OM','Oman'),(173,'PA','Panama'),(174,'PE','Peru'),(175,'PF','French Polynesia'),(176,'PG','Papua New Guinea'),(177,'PH','Philippines'),(178,'PK','Pakistan'),(179,'PL','Poland'),(180,'PM','Saint Pierre and Miquelon'),(181,'PN','Pitcairn Islands'),(182,'PR','Puerto Rico'),(183,'PS','Palestine'),(184,'PT','Portugal'),(185,'PW','Palau'),(186,'PY','Paraguay'),(187,'QA','Qatar'),(188,'RE','Réunion'),(189,'RO','Romania'),(190,'RS','Serbia'),(191,'RU','Russia'),(192,'RW','Rwanda'),(193,'SA','Saudi Arabia'),(194,'SB','Solomon Islands'),(195,'SC','Seychelles'),(196,'SD','Sudan'),(197,'SE','Sweden'),(198,'SG','Singapore'),(199,'SH','Saint Helena'),(200,'SI','Slovenia'),(201,'SJ','Svalbard and Jan Mayen'),(202,'SK','Slovakia'),(203,'SL','Sierra Leone'),(204,'SM','San Marino'),(205,'SN','Senegal'),(206,'SO','Somalia'),(207,'SR','Suriname'),(208,'SS','South Sudan'),(209,'ST','São Tomé and Príncipe'),(210,'SV','El Salvador'),(211,'SX','Sint Maarten'),(212,'SY','Syria'),(213,'SZ','Swaziland'),(214,'TC','Turks and Caicos Islands'),(215,'TD','Chad'),(216,'TF','French Southern Territories'),(217,'TG','Togo'),(218,'TH','Thailand'),(219,'TJ','Tajikistan'),(220,'TK','Tokelau'),(221,'TL','East Timor'),(222,'TM','Turkmenistan'),(223,'TN','Tunisia'),(224,'TO','Tonga'),(225,'TR','Turkey'),(226,'TT','Trinidad and Tobago'),(227,'TV','Tuvalu'),(228,'TW','Taiwan'),(229,'TZ','Tanzania'),(230,'UA','Ukraine'),(231,'UG','Uganda'),(232,'UM','U.S. Minor Outlying Islands'),(233,'US','United States'),(234,'UY','Uruguay'),(235,'UZ','Uzbekistan'),(236,'VA','Vatican City'),(237,'VC','Saint Vincent and the Grenadines'),(238,'VE','Venezuela'),(239,'VG','British Virgin Islands'),(240,'VI','U.S. Virgin Islands'),(241,'VN','Vietnam'),(242,'VU','Vanuatu'),(243,'WF','Wallis and Futuna'),(244,'WS','Samoa'),(245,'XK','Kosovo'),(246,'YE','Yemen'),(247,'YT','Mayotte'),(248,'ZA','South Africa'),(249,'ZM','Zambia'),(250,'ZW','Zimbabwe');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;

--
-- Table structure for table `joomla_action_log_config`
--

DROP TABLE IF EXISTS `joomla_action_log_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_action_log_config` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `type_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type_alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `id_holder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_holder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `table_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_prefix` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_action_log_config`
--

/*!40000 ALTER TABLE `joomla_action_log_config` DISABLE KEYS */;
INSERT INTO `joomla_action_log_config` VALUES (1,'article','com_content.article','id','title','#__content','PLG_ACTIONLOG_JOOMLA'),(2,'article','com_content.form','id','title','#__content','PLG_ACTIONLOG_JOOMLA'),(3,'banner','com_banners.banner','id','name','#__banners','PLG_ACTIONLOG_JOOMLA'),(4,'user_note','com_users.note','id','subject','#__user_notes','PLG_ACTIONLOG_JOOMLA'),(5,'media','com_media.file','','name','','PLG_ACTIONLOG_JOOMLA'),(6,'category','com_categories.category','id','title','#__categories','PLG_ACTIONLOG_JOOMLA'),(7,'menu','com_menus.menu','id','title','#__menu_types','PLG_ACTIONLOG_JOOMLA'),(8,'menu_item','com_menus.item','id','title','#__menu','PLG_ACTIONLOG_JOOMLA'),(9,'newsfeed','com_newsfeeds.newsfeed','id','name','#__newsfeeds','PLG_ACTIONLOG_JOOMLA'),(10,'link','com_redirect.link','id','old_url','#__redirect_links','PLG_ACTIONLOG_JOOMLA'),(11,'tag','com_tags.tag','id','title','#__tags','PLG_ACTIONLOG_JOOMLA'),(12,'style','com_templates.style','id','title','#__template_styles','PLG_ACTIONLOG_JOOMLA'),(13,'plugin','com_plugins.plugin','extension_id','name','#__extensions','PLG_ACTIONLOG_JOOMLA'),(14,'component_config','com_config.component','extension_id','name','','PLG_ACTIONLOG_JOOMLA'),(15,'contact','com_contact.contact','id','name','#__contact_details','PLG_ACTIONLOG_JOOMLA'),(16,'module','com_modules.module','id','title','#__modules','PLG_ACTIONLOG_JOOMLA'),(17,'access_level','com_users.level','id','title','#__viewlevels','PLG_ACTIONLOG_JOOMLA'),(18,'banner_client','com_banners.client','id','name','#__banner_clients','PLG_ACTIONLOG_JOOMLA'),(19,'application_config','com_config.application','','name','','PLG_ACTIONLOG_JOOMLA');
/*!40000 ALTER TABLE `joomla_action_log_config` ENABLE KEYS */;

--
-- Table structure for table `joomla_action_logs`
--

DROP TABLE IF EXISTS `joomla_action_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_action_logs` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `message_language_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `log_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `extension` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_id` int NOT NULL DEFAULT '0',
  `item_id` int NOT NULL DEFAULT '0',
  `ip_address` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0.0.0.0',
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_user_id_logdate` (`user_id`,`log_date`),
  KEY `idx_user_id_extension` (`user_id`,`extension`),
  KEY `idx_extension_item_id` (`extension`,`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=333 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_action_logs`
--

/*!40000 ALTER TABLE `joomla_action_logs` DISABLE KEYS */;
INSERT INTO `joomla_action_logs` VALUES (1,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2019-07-26 06:29:02','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(2,'PLG_ACTIONLOG_JOOMLA_EXTENSION_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MODULE\",\"id\":\"10001\",\"name\":\"Jumi\",\"extension_name\":\"Jumi\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 06:29:34','com_installer',632,10001,'COM_ACTIONLOGS_DISABLED'),(3,'PLG_ACTIONLOG_JOOMLA_PLUGIN_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PLUGIN\",\"id\":\"10002\",\"name\":\"System - Jumi\",\"extension_name\":\"System - Jumi\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 06:29:34','com_installer',632,10002,'COM_ACTIONLOGS_DISABLED'),(4,'PLG_ACTIONLOG_JOOMLA_PLUGIN_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PLUGIN\",\"id\":\"10003\",\"name\":\"System - Jumi Router\",\"extension_name\":\"System - Jumi Router\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 06:29:34','com_installer',632,10003,'COM_ACTIONLOGS_DISABLED'),(5,'PLG_ACTIONLOG_JOOMLA_EXTENSION_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_COMPONENT\",\"id\":\"10000\",\"name\":\"com_jumi\",\"extension_name\":\"com_jumi\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 06:29:34','com_installer',632,10000,'COM_ACTIONLOGS_DISABLED'),(6,'PLG_ACTIONLOG_JOOMLA_EXTENSION_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_TEMPLATE\",\"id\":\"10004\",\"name\":\"yoo_master2\",\"extension_name\":\"yoo_master2\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 06:29:54','com_installer',632,10004,'COM_ACTIONLOGS_DISABLED'),(7,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2019-07-26 07:28:37','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(8,'PLG_SYSTEM_ACTIONLOGS_CONTENT_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":101,\"title\":\"Home\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=101\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:30:42','com_menus.item',632,101,'COM_ACTIONLOGS_DISABLED'),(9,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2019-07-26 08:30:42','com_menus',632,632,'COM_ACTIONLOGS_DISABLED'),(10,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU\",\"id\":\"2\",\"title\":\"Hidden\",\"itemlink\":\"index.php?option=com_menus&task=menu.edit&id=2\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:31:19','com_menus.menu',632,2,'COM_ACTIONLOGS_DISABLED'),(11,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"103\",\"title\":\"Account Summary\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=103\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:35:17','com_menus.item',632,103,'COM_ACTIONLOGS_DISABLED'),(12,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"104\",\"title\":\"Active Income\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=104\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:37:50','com_menus.item',632,104,'COM_ACTIONLOGS_DISABLED'),(13,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"105\",\"title\":\"Activity\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=105\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:38:18','com_menus.item',632,105,'COM_ACTIONLOGS_DISABLED'),(14,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"106\",\"title\":\"Add Efunds\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=106\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:38:40','com_menus.item',632,106,'COM_ACTIONLOGS_DISABLED'),(15,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"107\",\"title\":\"Add Tokens\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=107\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:39:04','com_menus.item',632,107,'COM_ACTIONLOGS_DISABLED'),(16,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"108\",\"title\":\"Admin Account Update\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=108\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:39:25','com_menus.item',632,108,'COM_ACTIONLOGS_DISABLED'),(17,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"109\",\"title\":\"Admin Code Inventory\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=109\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:39:48','com_menus.item',632,109,'COM_ACTIONLOGS_DISABLED'),(18,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"110\",\"title\":\"Block\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=110\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:40:04','com_menus.item',632,110,'COM_ACTIONLOGS_DISABLED'),(19,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"111\",\"title\":\"Buy Items\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=111\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:40:23','com_menus.item',632,111,'COM_ACTIONLOGS_DISABLED'),(20,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"112\",\"title\":\"Buy Package\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=112\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:41:06','com_menus.item',632,112,'COM_ACTIONLOGS_DISABLED'),(21,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"113\",\"title\":\"Commission Deduct\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=113\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:41:39','com_menus.item',632,113,'COM_ACTIONLOGS_DISABLED'),(22,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"114\",\"title\":\"Converter\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=114\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:41:57','com_menus.item',632,114,'COM_ACTIONLOGS_DISABLED'),(23,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"115\",\"title\":\"Direct Referrals\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=115\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:42:16','com_menus.item',632,115,'COM_ACTIONLOGS_DISABLED'),(24,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"116\",\"title\":\"Downlines\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=116\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:42:38','com_menus.item',632,116,'COM_ACTIONLOGS_DISABLED'),(25,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"117\",\"title\":\"Efund Deposit\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=117\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:43:17','com_menus.item',632,117,'COM_ACTIONLOGS_DISABLED'),(26,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"118\",\"title\":\"Efund Transfer\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=118\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:43:50','com_menus.item',632,118,'COM_ACTIONLOGS_DISABLED'),(27,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"119\",\"title\":\"Etrade\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=119\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:44:16','com_menus.item',632,119,'COM_ACTIONLOGS_DISABLED'),(28,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"120\",\"title\":\"Etrade Deposit\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=120\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:44:36','com_menus.item',632,120,'COM_ACTIONLOGS_DISABLED'),(29,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"121\",\"title\":\"Fast Track\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=121\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:44:58','com_menus.item',632,121,'COM_ACTIONLOGS_DISABLED'),(30,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"122\",\"title\":\"Fast Track Deposit\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=122\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:45:20','com_menus.item',632,122,'COM_ACTIONLOGS_DISABLED'),(31,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"123\",\"title\":\"Genealogy Binary\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=123\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:45:44','com_menus.item',632,123,'COM_ACTIONLOGS_DISABLED'),(32,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"124\",\"title\":\"Genealogy Harvest Associate\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=124\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:46:18','com_menus.item',632,124,'COM_ACTIONLOGS_DISABLED'),(33,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"125\",\"title\":\"Genealogy Harvest Basic\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=125\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:46:41','com_menus.item',632,125,'COM_ACTIONLOGS_DISABLED'),(34,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"126\",\"title\":\"Genealogy Indirect\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=126\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:47:17','com_menus.item',632,126,'COM_ACTIONLOGS_DISABLED'),(35,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"127\",\"title\":\"Genealogy Leadership\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=127\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:47:51','com_menus.item',632,127,'COM_ACTIONLOGS_DISABLED'),(36,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"128\",\"title\":\"Genealogy Leadership Passive\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=128\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:48:15','com_menus.item',632,128,'COM_ACTIONLOGS_DISABLED'),(37,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"129\",\"title\":\"Genealogy Profit Share Associate\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=129\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:48:40','com_menus.item',632,129,'COM_ACTIONLOGS_DISABLED'),(38,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"130\",\"title\":\"Genealogy Profit Share Basic\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=130\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:49:05','com_menus.item',632,130,'COM_ACTIONLOGS_DISABLED'),(39,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"131\",\"title\":\"Genealogy Profit Share Chairman\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=131\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:49:34','com_menus.item',632,131,'COM_ACTIONLOGS_DISABLED'),(40,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"132\",\"title\":\"Genealogy Profit Share Director\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=132\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:50:01','com_menus.item',632,132,'COM_ACTIONLOGS_DISABLED'),(41,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"133\",\"title\":\"Genealogy Profit Share Executive\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=133\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:50:28','com_menus.item',632,133,'COM_ACTIONLOGS_DISABLED'),(42,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"134\",\"title\":\"Genealogy Profit Share Regular\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=134\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:50:54','com_menus.item',632,134,'COM_ACTIONLOGS_DISABLED'),(43,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"135\",\"title\":\"Genealogy Unilevel\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=135\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:51:17','com_menus.item',632,135,'COM_ACTIONLOGS_DISABLED'),(44,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"136\",\"title\":\"Generate Codes\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=136\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:51:56','com_menus.item',632,136,'COM_ACTIONLOGS_DISABLED'),(45,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"137\",\"title\":\"Income Log\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=137\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:52:51','com_menus.item',632,137,'COM_ACTIONLOGS_DISABLED'),(46,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"138\",\"title\":\"Indirect Bonus\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=138\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:53:15','com_menus.item',632,138,'COM_ACTIONLOGS_DISABLED'),(47,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"139\",\"title\":\"Leadership Bonus\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=139\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:53:37','com_menus.item',632,139,'COM_ACTIONLOGS_DISABLED'),(48,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"140\",\"title\":\"Leadership Bonus Passive\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=140\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:54:06','com_menus.item',632,140,'COM_ACTIONLOGS_DISABLED'),(49,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"141\",\"title\":\"Leadership Bonus Passive Deposit\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=141\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:54:46','com_menus.item',632,141,'COM_ACTIONLOGS_DISABLED'),(50,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"142\",\"title\":\"List Members\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=142\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:55:13','com_menus.item',632,142,'COM_ACTIONLOGS_DISABLED'),(51,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"143\",\"title\":\"Logout\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=143\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:55:35','com_menus.item',632,143,'COM_ACTIONLOGS_DISABLED'),(52,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"144\",\"title\":\"Lookup Code\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=144\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:55:54','com_menus.item',632,144,'COM_ACTIONLOGS_DISABLED'),(53,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"145\",\"title\":\"Member\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=145\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:56:24','com_menus.item',632,145,'COM_ACTIONLOGS_DISABLED'),(54,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"146\",\"title\":\"Member Info\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=146\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:56:44','com_menus.item',632,146,'COM_ACTIONLOGS_DISABLED'),(55,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"147\",\"title\":\"Merchant\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=147\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:57:04','com_menus.item',632,147,'COM_ACTIONLOGS_DISABLED'),(56,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"148\",\"title\":\"Merchant Package Buy\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=148\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:57:23','com_menus.item',632,148,'COM_ACTIONLOGS_DISABLED'),(57,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"149\",\"title\":\"Overall Purchase History\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=149\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:57:47','com_menus.item',632,149,'COM_ACTIONLOGS_DISABLED'),(58,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"150\",\"title\":\"Overall Reward Redemption History\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=150\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:58:08','com_menus.item',632,150,'COM_ACTIONLOGS_DISABLED'),(59,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"151\",\"title\":\"Payout Log\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=151\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:58:26','com_menus.item',632,151,'COM_ACTIONLOGS_DISABLED'),(60,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"152\",\"title\":\"Point Rewards Items\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=152\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:58:48','com_menus.item',632,152,'COM_ACTIONLOGS_DISABLED'),(61,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"153\",\"title\":\"Point Rewards Items Add\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=153\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:59:10','com_menus.item',632,153,'COM_ACTIONLOGS_DISABLED'),(62,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"154\",\"title\":\"Point Rewards Items Edit\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=154\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:59:32','com_menus.item',632,154,'COM_ACTIONLOGS_DISABLED'),(63,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"155\",\"title\":\"Point Reward Redemption List\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=155\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 08:59:59','com_menus.item',632,155,'COM_ACTIONLOGS_DISABLED'),(64,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"156\",\"title\":\"Power Share Associate\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=156\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:00:26','com_menus.item',632,156,'COM_ACTIONLOGS_DISABLED'),(65,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"157\",\"title\":\"Power Share Basic\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=157\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:00:47','com_menus.item',632,157,'COM_ACTIONLOGS_DISABLED'),(66,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"158\",\"title\":\"Power Share Deposit\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=158\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:01:11','com_menus.item',632,158,'COM_ACTIONLOGS_DISABLED'),(67,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"159\",\"title\":\"Power Share Executive\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=159\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:01:34','com_menus.item',632,159,'COM_ACTIONLOGS_DISABLED'),(68,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"160\",\"title\":\"Power Share Regular\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=160\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:01:58','com_menus.item',632,160,'COM_ACTIONLOGS_DISABLED'),(69,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"161\",\"title\":\"Power Share Upgrade\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=161\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:02:20','com_menus.item',632,161,'COM_ACTIONLOGS_DISABLED'),(70,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"162\",\"title\":\"Profile Update\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=162\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:02:42','com_menus.item',632,162,'COM_ACTIONLOGS_DISABLED'),(71,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"163\",\"title\":\"Profit Share Deposit\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=163\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:03:30','com_menus.item',632,163,'COM_ACTIONLOGS_DISABLED'),(72,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"164\",\"title\":\"Purchase Items Confirm\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=164\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:03:53','com_menus.item',632,164,'COM_ACTIONLOGS_DISABLED'),(73,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"165\",\"title\":\"Purchase Items Invoice\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=165\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:04:18','com_menus.item',632,165,'COM_ACTIONLOGS_DISABLED'),(74,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"166\",\"title\":\"Redeem Point Rewards\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=166\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:07:13','com_menus.item',632,166,'COM_ACTIONLOGS_DISABLED'),(75,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"167\",\"title\":\"Registration\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=167\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:07:32','com_menus.item',632,167,'COM_ACTIONLOGS_DISABLED'),(76,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"168\",\"title\":\"Registration Codes\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=168\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:08:01','com_menus.item',632,168,'COM_ACTIONLOGS_DISABLED'),(77,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"169\",\"title\":\"Registration Codes Inventory\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=169\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:08:23','com_menus.item',632,169,'COM_ACTIONLOGS_DISABLED'),(78,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"170\",\"title\":\"Registration Codes Used\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=170\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:08:48','com_menus.item',632,170,'COM_ACTIONLOGS_DISABLED'),(79,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"171\",\"title\":\"Repeat Purchase Items\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=171\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:09:12','com_menus.item',632,171,'COM_ACTIONLOGS_DISABLED'),(80,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"172\",\"title\":\"Repeat Purchase Items Add\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=172\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:09:37','com_menus.item',632,172,'COM_ACTIONLOGS_DISABLED'),(81,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"173\",\"title\":\"Repeat Purchase Items Edit\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=173\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:10:04','com_menus.item',632,173,'COM_ACTIONLOGS_DISABLED'),(82,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"174\",\"title\":\"Repeat Purchase Items List\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=174\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:10:23','com_menus.item',632,174,'COM_ACTIONLOGS_DISABLED'),(83,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"175\",\"title\":\"Request Efund\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=175\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:10:44','com_menus.item',632,175,'COM_ACTIONLOGS_DISABLED'),(84,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"176\",\"title\":\"Request Efund Confirmed\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=176\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:11:07','com_menus.item',632,176,'COM_ACTIONLOGS_DISABLED'),(85,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"177\",\"title\":\"Request Efund Log\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=177\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:11:28','com_menus.item',632,177,'COM_ACTIONLOGS_DISABLED'),(86,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"178\",\"title\":\"Request Efund Pending\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=178\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:11:50','com_menus.item',632,178,'COM_ACTIONLOGS_DISABLED'),(87,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"179\",\"title\":\"Reset\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=179\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:12:08','com_menus.item',632,179,'COM_ACTIONLOGS_DISABLED'),(88,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"180\",\"title\":\"Reward Redemption Confirm\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=180\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:12:34','com_menus.item',632,180,'COM_ACTIONLOGS_DISABLED'),(89,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"181\",\"title\":\"Sales Overview\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=181\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:12:54','com_menus.item',632,181,'COM_ACTIONLOGS_DISABLED'),(90,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"182\",\"title\":\"Settings Binary\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=182\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:13:19','com_menus.item',632,182,'COM_ACTIONLOGS_DISABLED'),(91,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"183\",\"title\":\"Settings Entry\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=183\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:13:39','com_menus.item',632,183,'COM_ACTIONLOGS_DISABLED'),(92,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"184\",\"title\":\"Settings Indirect Referral\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=184\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:14:06','com_menus.item',632,184,'COM_ACTIONLOGS_DISABLED'),(93,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"185\",\"title\":\"Settings Investment\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=185\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:14:30','com_menus.item',632,185,'COM_ACTIONLOGS_DISABLED'),(94,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"186\",\"title\":\"Settings Leadership Binary\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=186\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:15:14','com_menus.item',632,186,'COM_ACTIONLOGS_DISABLED'),(95,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"187\",\"title\":\"Settings Leadership Passive\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=187\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:15:43','com_menus.item',632,187,'COM_ACTIONLOGS_DISABLED'),(96,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"188\",\"title\":\"Settings Matrix\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=188\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:16:22','com_menus.item',632,188,'COM_ACTIONLOGS_DISABLED'),(97,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"189\",\"title\":\"Settings Merchant\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=189\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:16:46','com_menus.item',632,189,'COM_ACTIONLOGS_DISABLED'),(98,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"190\",\"title\":\"Settings Plans\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=190\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:17:08','com_menus.item',632,190,'COM_ACTIONLOGS_DISABLED'),(99,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"191\",\"title\":\"Settings Power\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=191\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:17:31','com_menus.item',632,191,'COM_ACTIONLOGS_DISABLED'),(100,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"192\",\"title\":\"Settings Ranking\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=192\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:17:57','com_menus.item',632,192,'COM_ACTIONLOGS_DISABLED'),(101,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"193\",\"title\":\"Settings Referral\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=193\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:18:20','com_menus.item',632,193,'COM_ACTIONLOGS_DISABLED'),(102,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"194\",\"title\":\"Settings Trading\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=194\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:18:42','com_menus.item',632,194,'COM_ACTIONLOGS_DISABLED'),(103,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"195\",\"title\":\"Settings Unilevel\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=195\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:19:08','com_menus.item',632,195,'COM_ACTIONLOGS_DISABLED'),(104,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"196\",\"title\":\"Settings Withdrawal\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=196\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:19:31','com_menus.item',632,196,'COM_ACTIONLOGS_DISABLED'),(105,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"197\",\"title\":\"Slogin\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=197\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:19:53','com_menus.item',632,197,'COM_ACTIONLOGS_DISABLED'),(106,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"198\",\"title\":\"Slogout\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=198\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:20:15','com_menus.item',632,198,'COM_ACTIONLOGS_DISABLED'),(107,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"199\",\"title\":\"System Reset Confirm\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=199\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:20:39','com_menus.item',632,199,'COM_ACTIONLOGS_DISABLED'),(108,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"200\",\"title\":\"Token Conversion\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=200\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:20:59','com_menus.item',632,200,'COM_ACTIONLOGS_DISABLED'),(109,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"201\",\"title\":\"Token Conversion Completed\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=201\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:21:25','com_menus.item',632,201,'COM_ACTIONLOGS_DISABLED'),(110,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"202\",\"title\":\"Token Conversion Confirm\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=202\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:22:18','com_menus.item',632,202,'COM_ACTIONLOGS_DISABLED'),(111,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"203\",\"title\":\"Token Conversion Log\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=203\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:22:37','com_menus.item',632,203,'COM_ACTIONLOGS_DISABLED'),(112,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"204\",\"title\":\"Token Transfer\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=204\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:22:58','com_menus.item',632,204,'COM_ACTIONLOGS_DISABLED'),(113,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"205\",\"title\":\"Top Up\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=205\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:23:19','com_menus.item',632,205,'COM_ACTIONLOGS_DISABLED'),(114,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"206\",\"title\":\"Top Up Deposit\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=206\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:23:41','com_menus.item',632,206,'COM_ACTIONLOGS_DISABLED'),(115,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"207\",\"title\":\"Trader\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=207\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:24:06','com_menus.item',632,207,'COM_ACTIONLOGS_DISABLED'),(116,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"208\",\"title\":\"Transactions\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=208\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:24:27','com_menus.item',632,208,'COM_ACTIONLOGS_DISABLED'),(117,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"209\",\"title\":\"Unblock\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=209\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:24:49','com_menus.item',632,209,'COM_ACTIONLOGS_DISABLED'),(118,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"210\",\"title\":\"Uncommission Deduct\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=210\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:25:11','com_menus.item',632,210,'COM_ACTIONLOGS_DISABLED'),(119,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"211\",\"title\":\"Unilevel Bonus\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=211\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:25:31','com_menus.item',632,211,'COM_ACTIONLOGS_DISABLED'),(120,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"212\",\"title\":\"Upgrade Account Type\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=212\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:25:53','com_menus.item',632,212,'COM_ACTIONLOGS_DISABLED'),(121,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"213\",\"title\":\"Withdrawal Completed\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=213\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:26:17','com_menus.item',632,213,'COM_ACTIONLOGS_DISABLED'),(122,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"214\",\"title\":\"Withdrawal Confirm\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=214\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:26:37','com_menus.item',632,214,'COM_ACTIONLOGS_DISABLED'),(123,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"215\",\"title\":\"Withdrawal Request\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=215\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 09:27:11','com_menus.item',632,215,'COM_ACTIONLOGS_DISABLED'),(124,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2019-07-26 10:30:58','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(125,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-26 10:33:06','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(126,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2019-07-28 03:49:19','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(127,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2019-07-29 10:28:11','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(128,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"216\",\"title\":\"Etrade\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=216\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-29 10:31:00','com_menus.item',632,216,'COM_ACTIONLOGS_DISABLED'),(129,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"217\",\"title\":\"Etrade Deposit\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=217\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-29 10:31:26','com_menus.item',632,217,'COM_ACTIONLOGS_DISABLED'),(130,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2019-07-30 03:51:09','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(131,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2019-07-30 06:19:04','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(132,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-30 06:19:30','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(133,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2019-07-30 06:22:09','com_menus',632,632,'COM_ACTIONLOGS_DISABLED'),(134,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-07-30 06:22:26','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(135,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2019-08-12 02:13:38','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(136,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"218\",\"title\":\"Add Ecash\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=218\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-08-12 02:16:38','com_menus.item',632,218,'COM_ACTIONLOGS_DISABLED'),(137,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2019-11-07 11:01:51','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(138,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2019-11-07 11:54:07','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(139,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2019-11-07 12:13:55','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(140,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2019-11-07 14:10:22','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(141,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2019-11-07 14:13:20','com_menus',632,632,'COM_ACTIONLOGS_DISABLED'),(142,'PLG_SYSTEM_ACTIONLOGS_CONTENT_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":192,\"title\":\"Settings Royalty\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=192\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-11-07 14:13:40','com_menus.item',632,192,'COM_ACTIONLOGS_DISABLED'),(143,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2019-11-07 14:13:40','com_menus',632,632,'COM_ACTIONLOGS_DISABLED'),(144,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"219\",\"title\":\"Settings Upline Support\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=219\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-11-07 14:14:21','com_menus.item',632,219,'COM_ACTIONLOGS_DISABLED'),(145,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2019-11-07 22:45:02','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(146,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2019-11-07 22:45:32','com_menus',632,632,'COM_ACTIONLOGS_DISABLED'),(147,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"220\",\"title\":\"Settings Passup\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=220\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-11-07 22:47:26','com_menus.item',632,220,'COM_ACTIONLOGS_DISABLED'),(148,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2019-11-07 23:28:12','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(149,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"221\",\"title\":\"Settings Elite Reward\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=221\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-11-07 23:30:05','com_menus.item',632,221,'COM_ACTIONLOGS_DISABLED'),(150,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2019-11-08 11:03:05','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(151,'PLG_SYSTEM_ACTIONLOGS_CONTENT_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":192,\"title\":\"Settings Royalty\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=192\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-11-08 11:03:53','com_menus.item',632,192,'COM_ACTIONLOGS_DISABLED'),(152,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2019-11-08 11:03:53','com_menus',632,632,'COM_ACTIONLOGS_DISABLED'),(153,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2019-11-10 06:44:29','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(154,'PLG_SYSTEM_ACTIONLOGS_CONTENT_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":196,\"title\":\"Settings Ancillaries\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=196\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2019-11-10 06:46:06','com_menus.item',632,196,'COM_ACTIONLOGS_DISABLED'),(155,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2019-11-10 06:46:06','com_menus',632,632,'COM_ACTIONLOGS_DISABLED'),(156,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2019-11-10 09:21:46','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(157,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2020-03-07 06:58:39','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(158,'PLG_ACTIONLOG_JOOMLA_USER_LOGIN_FAILED','{\"action\":\"login\",\"id\":\"632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-03 04:57:12','com_users',632,632,'COM_ACTIONLOGS_DISABLED'),(159,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-03 04:57:19','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(160,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-03 07:51:01','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(161,'PLG_ACTIONLOG_JOOMLA_USER_UPDATE','{\"action\":\"joomlaupdate\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"version\":\"3.9.28\",\"oldversion\":\"Unknown\"}','2021-08-03 07:54:11','com_joomlaupdate',632,632,'COM_ACTIONLOGS_DISABLED'),(162,'PLG_ACTIONLOG_JOOMLA_USER_LOGIN_FAILED','{\"action\":\"login\",\"id\":\"632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-13 03:28:53','com_users',632,632,'COM_ACTIONLOGS_DISABLED'),(163,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-13 03:29:05','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(164,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-13 03:59:52','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(165,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"222\",\"title\":\"Binary Reactivate\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=222\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2021-08-13 04:17:53','com_menus.item',632,222,'COM_ACTIONLOGS_DISABLED'),(166,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-13 04:53:18','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(167,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-13 05:25:33','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(168,'PLG_ACTIONLOG_JOOMLA_USER_LOGIN_FAILED','{\"action\":\"login\",\"id\":\"632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-13 06:10:33','com_users',632,632,'COM_ACTIONLOGS_DISABLED'),(169,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-13 06:10:49','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(170,'PLG_ACTIONLOG_JOOMLA_USER_LOGIN_FAILED','{\"action\":\"login\",\"id\":\"632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-14 14:16:20','com_users',632,632,'COM_ACTIONLOGS_DISABLED'),(171,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-14 14:16:29','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(172,'PLG_SYSTEM_ACTIONLOGS_CONTENT_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":199,\"title\":\"System Reset\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=199\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2021-08-14 14:20:28','com_menus.item',632,199,'COM_ACTIONLOGS_DISABLED'),(173,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2021-08-14 14:20:28','com_checkin',632,632,'COM_ACTIONLOGS_DISABLED'),(174,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-14 17:29:14','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(175,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-15 02:43:38','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(176,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-16 01:40:20','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(177,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2021-08-16 01:41:38','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(178,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2021-08-16 01:46:45','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(179,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-16 06:49:31','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(180,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-16 09:09:02','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(181,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_OUT','{\"action\":\"logout\",\"id\":\"632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-16 09:12:44','com_users',632,632,'COM_ACTIONLOGS_DISABLED'),(182,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-16 09:12:59','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(183,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-18 04:32:02','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(184,'PLG_ACTIONLOG_JOOMLA_USER_UPDATE','{\"action\":\"joomlaupdate\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"version\":\"3.10.0\",\"oldversion\":\"3.9.28\"}','2021-08-18 04:35:20','com_joomlaupdate',632,632,'COM_ACTIONLOGS_DISABLED'),(185,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-08-18 05:30:41','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(186,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-10-06 19:09:18','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(187,'PLG_ACTIONLOG_JOOMLA_USER_UPDATE','{\"action\":\"joomlaupdate\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"version\":\"3.10.2\",\"oldversion\":\"3.10.0\"}','2021-10-06 19:16:32','com_joomlaupdate',632,632,'COM_ACTIONLOGS_DISABLED'),(188,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-10-26 04:25:19','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(189,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"223\",\"title\":\"Settings Harvest\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=223\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2021-10-26 04:28:55','com_menus.item',632,223,'COM_ACTIONLOGS_DISABLED'),(190,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-10-26 10:37:42','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(191,'PLG_ACTIONLOG_JOOMLA_USER_UPDATE','{\"action\":\"joomlaupdate\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"version\":\"3.10.3\",\"oldversion\":\"3.10.1\"}','2021-10-26 10:38:43','com_joomlaupdate',632,632,'COM_ACTIONLOGS_DISABLED'),(192,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-11-03 04:43:01','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(193,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2021-11-03 04:44:25','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(194,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2021-11-03 04:45:38','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(195,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2021-11-03 04:46:31','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(196,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-11-03 16:25:43','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(197,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2021-11-03 16:26:31','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(198,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2021-12-12 13:10:55','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(199,'PLG_ACTIONLOG_JOOMLA_USER_UPDATE','{\"action\":\"joomlaupdate\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"version\":\"3.10.3\",\"oldversion\":\"3.10.2\"}','2021-12-12 13:12:35','com_joomlaupdate',632,632,'COM_ACTIONLOGS_DISABLED'),(200,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-01-12 06:40:18','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(201,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-02-19 19:56:52','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(202,'PLG_ACTIONLOG_JOOMLA_USER_UPDATE','{\"action\":\"joomlaupdate\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"version\":\"3.10.6\",\"oldversion\":\"3.10.4\"}','2022-02-19 19:57:45','com_joomlaupdate',632,632,'COM_ACTIONLOGS_DISABLED'),(203,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-02-26 17:17:16','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(204,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-04-22 04:19:48','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(205,'PLG_ACTIONLOG_JOOMLA_USER_UPDATE','{\"action\":\"joomlaupdate\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"version\":\"3.10.8\",\"oldversion\":\"3.10.6\"}','2022-04-22 04:25:29','com_joomlaupdate',632,632,'COM_ACTIONLOGS_DISABLED'),(206,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-05-21 13:47:57','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(207,'PLG_ACTIONLOG_JOOMLA_USER_UPDATE','{\"action\":\"joomlaupdate\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"version\":\"3.10.9\",\"oldversion\":\"3.10.8\"}','2022-05-21 13:49:52','com_joomlaupdate',632,632,'COM_ACTIONLOGS_DISABLED'),(208,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-06-23 02:53:31','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(209,'PLG_ACTIONLOG_JOOMLA_USER_UPDATE','{\"action\":\"joomlaupdate\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"version\":\"3.10.10\",\"oldversion\":\"3.10.9\"}','2022-06-23 02:55:07','com_joomlaupdate',632,632,'COM_ACTIONLOGS_DISABLED'),(210,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-07-15 05:45:27','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(211,'PLG_SYSTEM_ACTIONLOGS_CONTENT_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":156,\"title\":\"P2P Sell Token\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=156\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-07-15 05:49:41','com_menus.item',632,156,'COM_ACTIONLOGS_DISABLED'),(212,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2022-07-15 05:49:41','com_checkin',632,632,'COM_ACTIONLOGS_DISABLED'),(213,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-07-16 21:21:43','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(214,'PLG_SYSTEM_ACTIONLOGS_CONTENT_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":157,\"title\":\"P2P Buy Token\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=157\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-07-16 21:24:13','com_menus.item',632,157,'COM_ACTIONLOGS_DISABLED'),(215,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2022-07-16 21:24:13','com_checkin',632,632,'COM_ACTIONLOGS_DISABLED'),(216,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-07-17 12:07:22','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(217,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-07-18 17:03:41','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(218,'PLG_SYSTEM_ACTIONLOGS_CONTENT_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":158,\"title\":\"P2P Trade History\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=158\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-07-18 17:06:14','com_menus.item',632,158,'COM_ACTIONLOGS_DISABLED'),(219,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2022-07-18 17:06:14','com_checkin',632,632,'COM_ACTIONLOGS_DISABLED'),(220,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-07-18 17:33:31','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(221,'PLG_ACTIONLOG_JOOMLA_COMPONENT_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_COMPONENT_CONFIG\",\"id\":\"28\",\"title\":\"com_joomlaupdate\",\"extension_name\":\"com_joomlaupdate\",\"itemlink\":\"index.php?option=com_config&task=component.edit&extension_id=28\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-07-18 17:40:44','com_config.component',632,28,'COM_ACTIONLOGS_DISABLED'),(222,'PLG_ACTIONLOG_JOOMLA_COMPONENT_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_COMPONENT_CONFIG\",\"id\":\"28\",\"title\":\"com_joomlaupdate\",\"extension_name\":\"com_joomlaupdate\",\"itemlink\":\"index.php?option=com_config&task=component.edit&extension_id=28\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-07-18 17:43:36','com_config.component',632,28,'COM_ACTIONLOGS_DISABLED'),(223,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-07-18 18:09:25','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(224,'PLG_ACTIONLOG_JOOMLA_PLUGIN_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PLUGIN\",\"id\":\"10006\",\"name\":\"plg_installer_webinstaller\",\"extension_name\":\"plg_installer_webinstaller\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-07-18 18:10:39','com_installer',632,10006,'COM_ACTIONLOGS_DISABLED'),(225,'PLG_ACTIONLOG_JOOMLA_EXTENSION_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_LIBRARY\",\"id\":\"10008\",\"name\":\"Regular Labs Library\",\"extension_name\":\"Regular Labs Library\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-07-18 18:11:26','com_installer',632,10008,'COM_ACTIONLOGS_DISABLED'),(226,'PLG_ACTIONLOG_JOOMLA_PLUGIN_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PLUGIN\",\"id\":\"10009\",\"name\":\"PLG_SYSTEM_REGULARLABS\",\"extension_name\":\"PLG_SYSTEM_REGULARLABS\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-07-18 18:11:26','com_installer',632,10009,'COM_ACTIONLOGS_DISABLED'),(227,'PLG_ACTIONLOG_JOOMLA_EXTENSION_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_LIBRARY\",\"id\":\"10010\",\"name\":\"Regular Labs Library\",\"extension_name\":\"Regular Labs Library\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-07-18 18:11:26','com_installer',632,10010,'COM_ACTIONLOGS_DISABLED'),(228,'PLG_ACTIONLOG_JOOMLA_PLUGIN_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PLUGIN\",\"id\":\"10011\",\"name\":\"PLG_EDITORS-XTD_SOURCERER\",\"extension_name\":\"PLG_EDITORS-XTD_SOURCERER\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-07-18 18:11:26','com_installer',632,10011,'COM_ACTIONLOGS_DISABLED'),(229,'PLG_ACTIONLOG_JOOMLA_PLUGIN_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PLUGIN\",\"id\":\"10009\",\"name\":\"PLG_SYSTEM_REGULARLABS\",\"extension_name\":\"PLG_SYSTEM_REGULARLABS\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-07-18 18:11:26','com_installer',632,10009,'COM_ACTIONLOGS_DISABLED'),(230,'PLG_ACTIONLOG_JOOMLA_PLUGIN_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PLUGIN\",\"id\":\"10012\",\"name\":\"PLG_SYSTEM_SOURCERER\",\"extension_name\":\"PLG_SYSTEM_SOURCERER\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-07-18 18:11:26','com_installer',632,10012,'COM_ACTIONLOGS_DISABLED'),(231,'PLG_ACTIONLOG_JOOMLA_PLUGIN_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PLUGIN\",\"id\":\"10007\",\"name\":\"System - Regular Labs Installer\",\"extension_name\":\"System - Regular Labs Installer\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-07-18 18:11:26','com_installer',632,10007,'COM_ACTIONLOGS_DISABLED'),(232,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-07-20 12:48:55','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(233,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-08-01 04:25:39','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(234,'PLG_SYSTEM_ACTIONLOGS_CONTENT_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":159,\"title\":\"Convert e-Token\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=159\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-08-01 04:34:23','com_menus.item',632,159,'COM_ACTIONLOGS_DISABLED'),(235,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2022-08-01 04:34:23','com_checkin',632,632,'COM_ACTIONLOGS_DISABLED'),(236,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-08-01 14:02:41','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(237,'PLG_SYSTEM_ACTIONLOGS_CONTENT_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":159,\"title\":\"Convert Gold\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=159\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-08-01 14:04:47','com_menus.item',632,159,'COM_ACTIONLOGS_DISABLED'),(238,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2022-08-01 14:04:47','com_checkin',632,632,'COM_ACTIONLOGS_DISABLED'),(239,'PLG_SYSTEM_ACTIONLOGS_CONTENT_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":160,\"title\":\"Convert Gold Pending\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=160\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-08-01 14:06:52','com_menus.item',632,160,'COM_ACTIONLOGS_DISABLED'),(240,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2022-08-01 14:06:52','com_checkin',632,632,'COM_ACTIONLOGS_DISABLED'),(241,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-08-01 14:37:32','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(242,'PLG_SYSTEM_ACTIONLOGS_CONTENT_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":161,\"title\":\"Convert Gold Confirmed\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=161\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-08-01 14:44:10','com_menus.item',632,161,'COM_ACTIONLOGS_DISABLED'),(243,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2022-08-01 14:44:10','com_checkin',632,632,'COM_ACTIONLOGS_DISABLED'),(244,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-08-01 15:05:15','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(245,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-08-01 18:51:54','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(246,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2022-08-01 18:52:57','com_checkin',632,632,'COM_ACTIONLOGS_DISABLED'),(247,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"224\",\"title\":\"Convert Gold Logs\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=224\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-08-01 18:53:25','com_menus.item',632,224,'COM_ACTIONLOGS_DISABLED'),(248,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-08-17 11:20:24','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(249,'PLG_ACTIONLOG_JOOMLA_USER_UPDATE','{\"action\":\"joomlaupdate\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"version\":\"3.10.11\",\"oldversion\":\"3.10.10\"}','2022-08-17 11:22:45','com_joomlaupdate',632,632,'COM_ACTIONLOGS_DISABLED'),(250,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-08-18 09:12:25','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(251,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"225\",\"title\":\"Online Shop Merchants\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=225\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-08-18 09:21:55','com_menus.item',632,225,'COM_ACTIONLOGS_DISABLED'),(252,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"226\",\"title\":\"Add Online Shop Merchant\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=226\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-08-18 09:26:23','com_menus.item',632,226,'COM_ACTIONLOGS_DISABLED'),(253,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"227\",\"title\":\"Edit Online Shop Merchant\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=227\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-08-18 09:26:58','com_menus.item',632,227,'COM_ACTIONLOGS_DISABLED'),(254,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-08-18 17:17:33','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(255,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-08-18 21:20:50','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(256,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"228\",\"title\":\"P2P Sell Item\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=228\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-08-18 21:22:50','com_menus.item',632,228,'COM_ACTIONLOGS_DISABLED'),(257,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"229\",\"title\":\"P2P Buy Item\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=229\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-08-18 21:26:37','com_menus.item',632,229,'COM_ACTIONLOGS_DISABLED'),(258,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"230\",\"title\":\"P2P Trade Item History\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=230\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-08-18 21:28:25','com_menus.item',632,230,'COM_ACTIONLOGS_DISABLED'),(259,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-08-21 13:40:56','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(260,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"231\",\"title\":\"Settings P2P Category\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=231\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-08-21 13:42:30','com_menus.item',632,231,'COM_ACTIONLOGS_DISABLED'),(261,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-08-22 04:11:19','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(262,'PLG_SYSTEM_ACTIONLOGS_CONTENT_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":231,\"title\":\"Empty\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=231\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-08-22 04:13:55','com_menus.item',632,231,'COM_ACTIONLOGS_DISABLED'),(263,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2022-08-22 04:13:55','com_checkin',632,632,'COM_ACTIONLOGS_DISABLED'),(264,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-08-22 13:38:33','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(265,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-08-25 02:19:31','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(266,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2022-11-18 02:04:50','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(267,'PLG_ACTIONLOG_JOOMLA_EXTENSION_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_LIBRARY\",\"id\":\"10013\",\"name\":\"Regular Labs Library\",\"extension_name\":\"Regular Labs Library\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-11-18 02:05:21','com_installer',632,10013,'COM_ACTIONLOGS_DISABLED'),(268,'PLG_ACTIONLOG_JOOMLA_PLUGIN_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PLUGIN\",\"id\":\"10009\",\"name\":\"PLG_SYSTEM_REGULARLABS\",\"extension_name\":\"PLG_SYSTEM_REGULARLABS\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-11-18 02:05:21','com_installer',632,10009,'COM_ACTIONLOGS_DISABLED'),(269,'PLG_ACTIONLOG_JOOMLA_EXTENSION_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PACKAGE\",\"id\":\"10014\",\"name\":\"PKG_REGULARLABS\",\"extension_name\":\"PKG_REGULARLABS\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-11-18 02:05:21','com_installer',632,10014,'COM_ACTIONLOGS_DISABLED'),(270,'PLG_ACTIONLOG_JOOMLA_PLUGIN_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PLUGIN\",\"id\":\"10012\",\"name\":\"PLG_SYSTEM_SOURCERER\",\"extension_name\":\"PLG_SYSTEM_SOURCERER\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-11-18 02:05:21','com_installer',632,10012,'COM_ACTIONLOGS_DISABLED'),(271,'PLG_ACTIONLOG_JOOMLA_PLUGIN_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PLUGIN\",\"id\":\"10011\",\"name\":\"PLG_EDITORS-XTD_SOURCERER\",\"extension_name\":\"PLG_EDITORS-XTD_SOURCERER\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-11-18 02:05:21','com_installer',632,10011,'COM_ACTIONLOGS_DISABLED'),(272,'PLG_ACTIONLOG_JOOMLA_EXTENSION_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PACKAGE\",\"id\":\"10015\",\"name\":\"PKG_SOURCERER\",\"extension_name\":\"PKG_SOURCERER\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2022-11-18 02:05:21','com_installer',632,10015,'COM_ACTIONLOGS_DISABLED'),(273,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2023-02-01 15:01:04','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(274,'PLG_SYSTEM_ACTIONLOGS_CONTENT_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":231,\"title\":\"Settings Freeze\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=231\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-02-01 15:05:25','com_menus.item',632,231,'COM_ACTIONLOGS_DISABLED'),(275,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2023-02-01 15:05:25','com_checkin',632,632,'COM_ACTIONLOGS_DISABLED'),(276,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2023-02-01 18:39:10','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(277,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"232\",\"title\":\"Account Reactivate\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=232\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-02-01 18:41:01','com_menus.item',632,232,'COM_ACTIONLOGS_DISABLED'),(278,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2023-02-09 13:53:55','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(279,'PLG_SYSTEM_ACTIONLOGS_CONTENT_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":231,\"title\":\"Settings Freeze\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=231\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-02-09 13:56:00','com_menus.item',632,231,'COM_ACTIONLOGS_DISABLED'),(280,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2023-02-09 13:56:00','com_checkin',632,632,'COM_ACTIONLOGS_DISABLED'),(281,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2023-04-07 10:55:19','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(282,'PLG_ACTIONLOG_JOOMLA_EXTENSION_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_LIBRARY\",\"id\":\"10016\",\"name\":\"Regular Labs Library\",\"extension_name\":\"Regular Labs Library\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-04-07 10:56:04','com_installer',632,10016,'COM_ACTIONLOGS_DISABLED'),(283,'PLG_ACTIONLOG_JOOMLA_PLUGIN_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PLUGIN\",\"id\":\"10009\",\"name\":\"PLG_SYSTEM_REGULARLABS\",\"extension_name\":\"PLG_SYSTEM_REGULARLABS\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-04-07 10:56:04','com_installer',632,10009,'COM_ACTIONLOGS_DISABLED'),(284,'PLG_ACTIONLOG_JOOMLA_EXTENSION_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PACKAGE\",\"id\":\"10014\",\"name\":\"PKG_REGULARLABS\",\"extension_name\":\"PKG_REGULARLABS\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-04-07 10:56:04','com_installer',632,10014,'COM_ACTIONLOGS_DISABLED'),(285,'PLG_ACTIONLOG_JOOMLA_PLUGIN_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PLUGIN\",\"id\":\"10012\",\"name\":\"PLG_SYSTEM_SOURCERER\",\"extension_name\":\"PLG_SYSTEM_SOURCERER\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-04-07 10:56:04','com_installer',632,10012,'COM_ACTIONLOGS_DISABLED'),(286,'PLG_ACTIONLOG_JOOMLA_PLUGIN_INSTALLED','{\"action\":\"install\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PLUGIN\",\"id\":\"10011\",\"name\":\"PLG_EDITORS-XTD_SOURCERER\",\"extension_name\":\"PLG_EDITORS-XTD_SOURCERER\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-04-07 10:56:04','com_installer',632,10011,'COM_ACTIONLOGS_DISABLED'),(287,'PLG_ACTIONLOG_JOOMLA_EXTENSION_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_PACKAGE\",\"id\":\"10015\",\"name\":\"PKG_SOURCERER\",\"extension_name\":\"PKG_SOURCERER\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-04-07 10:56:04','com_installer',632,10015,'COM_ACTIONLOGS_DISABLED'),(288,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2023-04-10 10:04:37','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(289,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2023-04-22 09:57:53','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(290,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-04-22 10:09:16','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(291,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2023-04-23 09:19:36','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(292,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-04-23 09:55:46','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(293,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-04-23 10:08:53','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(294,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2023-04-23 11:06:15','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(295,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-04-23 11:10:27','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(296,'PLG_ACTIONLOG_JOOMLA_COMPONENT_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_COMPONENT_CONFIG\",\"id\":\"13\",\"title\":\"com_media\",\"extension_name\":\"com_media\",\"itemlink\":\"index.php?option=com_config&task=component.edit&extension_id=13\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-04-23 11:23:14','com_config.component',632,13,'COM_ACTIONLOGS_DISABLED'),(297,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-04-23 11:23:44','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(298,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-04-23 11:29:46','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(299,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2023-04-23 11:48:16','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(300,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2023-04-25 08:47:59','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(301,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-04-25 08:49:39','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(302,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-04-25 08:49:55','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(303,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-04-25 08:50:42','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(304,'PLG_ACTIONLOG_JOOMLA_APPLICATION_CONFIG_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_APPLICATION_CONFIG\",\"extension_name\":\"com_config.application\",\"itemlink\":\"index.php?option=com_config\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-04-25 08:50:55','com_config.application',632,0,'COM_ACTIONLOGS_DISABLED'),(305,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2023-09-24 00:57:28','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(306,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"233\",\"title\":\"Add Points\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=233\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-09-24 00:59:29','com_menus.item',632,233,'COM_ACTIONLOGS_DISABLED'),(307,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"234\",\"title\":\"Transfer Points\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=234\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2023-09-24 00:59:48','com_menus.item',632,234,'COM_ACTIONLOGS_DISABLED'),(308,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2024-03-18 07:26:14','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(309,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"235\",\"title\":\"Savings Transfer\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=235\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2024-03-18 07:29:49','com_menus.item',632,235,'COM_ACTIONLOGS_DISABLED'),(310,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2024-03-18 09:46:18','com_checkin',632,632,'COM_ACTIONLOGS_DISABLED'),(311,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"236\",\"title\":\"Request Share Fund\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=236\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2024-03-18 15:48:33','com_menus.item',632,236,'COM_ACTIONLOGS_DISABLED'),(312,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"237\",\"title\":\"Request Share Confirmed\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=237\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2024-03-18 15:49:06','com_menus.item',632,237,'COM_ACTIONLOGS_DISABLED'),(313,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"238\",\"title\":\"Request Share Fund Log\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=238\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2024-03-18 15:49:56','com_menus.item',632,238,'COM_ACTIONLOGS_DISABLED'),(314,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"239\",\"title\":\"Request Share Fund Pending\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=239\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2024-03-18 15:50:28','com_menus.item',632,239,'COM_ACTIONLOGS_DISABLED'),(315,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"240\",\"title\":\"Loans Transfer\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=240\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2024-03-19 12:57:49','com_menus.item',632,240,'COM_ACTIONLOGS_DISABLED'),(316,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"241\",\"title\":\"Request Loan\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=241\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2024-03-19 12:58:37','com_menus.item',632,241,'COM_ACTIONLOGS_DISABLED'),(317,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"242\",\"title\":\"Request Loan Confirmed\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=242\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2024-03-19 12:59:12','com_menus.item',632,242,'COM_ACTIONLOGS_DISABLED'),(318,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"243\",\"title\":\"Request Loan Log\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=243\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2024-03-19 12:59:42','com_menus.item',632,243,'COM_ACTIONLOGS_DISABLED'),(319,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"244\",\"title\":\"Request Loan Pending\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=244\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2024-03-19 13:00:18','com_menus.item',632,244,'COM_ACTIONLOGS_DISABLED'),(320,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2024-07-28 15:59:02','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(321,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2024-07-30 07:06:02','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(322,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"245\",\"title\":\"Join\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=245\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2024-07-30 07:07:55','com_menus.item',632,245,'COM_ACTIONLOGS_DISABLED'),(323,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2024-08-11 19:13:25','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(324,'PLG_SYSTEM_ACTIONLOGS_CONTENT_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":101,\"title\":\"Home\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=101\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2024-08-11 19:14:43','com_menus.item',632,101,'COM_ACTIONLOGS_DISABLED'),(325,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2024-08-11 19:14:43','com_checkin',632,632,'COM_ACTIONLOGS_DISABLED'),(326,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2024-12-22 17:01:55','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(327,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"246\",\"title\":\"Echelon Royalty\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=246\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2024-12-22 17:35:48','com_menus.item',632,246,'COM_ACTIONLOGS_DISABLED'),(328,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"247\",\"title\":\"Echelon Royalty Settings\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=247\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2024-12-22 17:36:16','com_menus.item',632,247,'COM_ACTIONLOGS_DISABLED'),(329,'PLG_ACTIONLOG_JOOMLA_USER_LOGGED_IN','{\"action\":\"login\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"app\":\"PLG_ACTIONLOG_JOOMLA_APPLICATION_ADMINISTRATOR\"}','2024-12-23 05:34:52','com_users',632,0,'COM_ACTIONLOGS_DISABLED'),(330,'PLG_SYSTEM_ACTIONLOGS_CONTENT_UPDATED','{\"action\":\"update\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":101,\"title\":\"Home\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=101\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2024-12-23 05:35:22','com_menus.item',632,101,'COM_ACTIONLOGS_DISABLED'),(331,'PLG_ACTIONLOG_JOOMLA_USER_CHECKIN','{\"action\":\"checkin\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_USER\",\"id\":\"632\",\"title\":\"admin\",\"itemlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\",\"table\":\"#__menu\"}','2024-12-23 05:35:22','com_checkin',632,632,'COM_ACTIONLOGS_DISABLED'),(332,'PLG_SYSTEM_ACTIONLOGS_CONTENT_ADDED','{\"action\":\"add\",\"type\":\"PLG_ACTIONLOG_JOOMLA_TYPE_MENU_ITEM\",\"id\":\"248\",\"title\":\"Genealogy Echelon\",\"itemlink\":\"index.php?option=com_menus&task=item.edit&id=248\",\"userid\":\"632\",\"username\":\"admin\",\"accountlink\":\"index.php?option=com_users&task=user.edit&id=632\"}','2024-12-23 08:28:05','com_menus.item',632,248,'COM_ACTIONLOGS_DISABLED');
/*!40000 ALTER TABLE `joomla_action_logs` ENABLE KEYS */;

--
-- Table structure for table `joomla_action_logs_extensions`
--

DROP TABLE IF EXISTS `joomla_action_logs_extensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_action_logs_extensions` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_action_logs_extensions`
--

/*!40000 ALTER TABLE `joomla_action_logs_extensions` DISABLE KEYS */;
INSERT INTO `joomla_action_logs_extensions` VALUES (1,'com_banners'),(2,'com_cache'),(3,'com_categories'),(4,'com_config'),(5,'com_contact'),(6,'com_content'),(7,'com_installer'),(8,'com_media'),(9,'com_menus'),(10,'com_messages'),(11,'com_modules'),(12,'com_newsfeeds'),(13,'com_plugins'),(14,'com_redirect'),(15,'com_tags'),(16,'com_templates'),(17,'com_users'),(18,'com_checkin');
/*!40000 ALTER TABLE `joomla_action_logs_extensions` ENABLE KEYS */;

--
-- Table structure for table `joomla_action_logs_users`
--

DROP TABLE IF EXISTS `joomla_action_logs_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_action_logs_users` (
  `user_id` int unsigned NOT NULL,
  `notify` tinyint unsigned NOT NULL,
  `extensions` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `idx_notify` (`notify`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_action_logs_users`
--

/*!40000 ALTER TABLE `joomla_action_logs_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_action_logs_users` ENABLE KEYS */;

--
-- Table structure for table `joomla_assets`
--

DROP TABLE IF EXISTS `joomla_assets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_assets` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `parent_id` int NOT NULL DEFAULT '0' COMMENT 'Nested set parent.',
  `lft` int NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `level` int unsigned NOT NULL COMMENT 'The cached level in the nested tree.',
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The unique name for the asset.\n',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The descriptive title for the asset.',
  `rules` varchar(5120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_asset_name` (`name`),
  KEY `idx_lft_rgt` (`lft`,`rgt`),
  KEY `idx_parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_assets`
--

/*!40000 ALTER TABLE `joomla_assets` DISABLE KEYS */;
INSERT INTO `joomla_assets` VALUES (1,0,0,123,0,'root.1','Root Asset','{\"core.login.site\":{\"6\":1,\"2\":1},\"core.login.admin\":{\"6\":1},\"core.login.offline\":{\"6\":1},\"core.admin\":{\"8\":1},\"core.manage\":{\"7\":1},\"core.create\":{\"6\":1,\"3\":1},\"core.delete\":{\"6\":1},\"core.edit\":{\"6\":1,\"4\":1},\"core.edit.state\":{\"6\":1,\"5\":1},\"core.edit.own\":{\"6\":1,\"3\":1}}'),(2,1,1,2,1,'com_admin','com_admin','{}'),(3,1,3,6,1,'com_banners','com_banners','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1}}'),(4,1,7,8,1,'com_cache','com_cache','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1}}'),(5,1,9,10,1,'com_checkin','com_checkin','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1}}'),(6,1,11,12,1,'com_config','com_config','{}'),(7,1,13,16,1,'com_contact','com_contact','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1}}'),(8,1,17,20,1,'com_content','com_content','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":{\"3\":1},\"core.edit\":{\"4\":1},\"core.edit.state\":{\"5\":1}}'),(9,1,21,22,1,'com_cpanel','com_cpanel','{}'),(10,1,23,24,1,'com_installer','com_installer','{\"core.manage\":{\"7\":0},\"core.delete\":{\"7\":0},\"core.edit.state\":{\"7\":0}}'),(11,1,25,26,1,'com_languages','com_languages','{\"core.admin\":{\"7\":1}}'),(12,1,27,28,1,'com_login','com_login','{}'),(13,1,29,30,1,'com_mailto','com_mailto','{}'),(14,1,31,32,1,'com_massmail','com_massmail','{}'),(15,1,33,34,1,'com_media','com_media','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1},\"core.create\":{\"3\":1},\"core.delete\":{\"5\":1}}'),(16,1,35,40,1,'com_menus','com_menus','{\"core.admin\":{\"7\":1}}'),(17,1,41,42,1,'com_messages','com_messages','{\"core.admin\":{\"7\":1},\"core.manage\":{\"7\":1}}'),(18,1,43,82,1,'com_modules','com_modules','{\"core.admin\":{\"7\":1}}'),(19,1,83,86,1,'com_newsfeeds','com_newsfeeds','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1}}'),(20,1,87,88,1,'com_plugins','com_plugins','{\"core.admin\":{\"7\":1}}'),(21,1,89,90,1,'com_redirect','com_redirect','{\"core.admin\":{\"7\":1}}'),(22,1,91,92,1,'com_search','com_search','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1}}'),(23,1,93,94,1,'com_templates','com_templates','{\"core.admin\":{\"7\":1}}'),(24,1,95,98,1,'com_users','com_users','{\"core.admin\":{\"7\":1}}'),(26,1,99,100,1,'com_wrapper','com_wrapper','{}'),(27,8,18,19,2,'com_content.category.2','Uncategorised','{}'),(28,3,4,5,2,'com_banners.category.3','Uncategorised','{}'),(29,7,14,15,2,'com_contact.category.4','Uncategorised','{}'),(30,19,84,85,2,'com_newsfeeds.category.5','Uncategorised','{}'),(32,24,96,97,2,'com_users.category.7','Uncategorised','{}'),(33,1,101,102,1,'com_finder','com_finder','{\"core.admin\":{\"7\":1},\"core.manage\":{\"6\":1}}'),(34,1,103,104,1,'com_joomlaupdate','com_joomlaupdate','{}'),(35,1,105,106,1,'com_tags','com_tags','{}'),(36,1,107,108,1,'com_contenthistory','com_contenthistory','{}'),(37,1,109,110,1,'com_ajax','com_ajax','{}'),(38,1,111,112,1,'com_postinstall','com_postinstall','{}'),(39,18,44,45,2,'com_modules.module.1','Main Menu','{}'),(40,18,46,47,2,'com_modules.module.2','Login','{}'),(41,18,48,49,2,'com_modules.module.3','Popular Articles','{}'),(42,18,50,51,2,'com_modules.module.4','Recently Added Articles','{}'),(43,18,52,53,2,'com_modules.module.8','Toolbar','{}'),(44,18,54,55,2,'com_modules.module.9','Quick Icons','{}'),(45,18,56,57,2,'com_modules.module.10','Logged-in Users','{}'),(46,18,58,59,2,'com_modules.module.12','Admin Menu','{}'),(47,18,60,61,2,'com_modules.module.13','Admin Submenu','{}'),(48,18,62,63,2,'com_modules.module.14','User Status','{}'),(49,18,64,65,2,'com_modules.module.15','Title','{}'),(50,18,66,67,2,'com_modules.module.16','Login Form','{}'),(51,18,68,69,2,'com_modules.module.17','Breadcrumbs','{}'),(52,18,70,71,2,'com_modules.module.79','Multilanguage status','{}'),(53,18,72,73,2,'com_modules.module.86','Joomla Version','{}'),(54,16,36,37,2,'com_menus.menu.1','Main Menu','{}'),(55,18,74,75,2,'com_modules.module.87','Sample Data','{}'),(56,1,113,114,1,'com_privacy','com_privacy','{}'),(57,1,115,116,1,'com_actionlogs','com_actionlogs','{}'),(58,18,76,77,2,'com_modules.module.88','Latest Actions','{}'),(59,18,78,79,2,'com_modules.module.89','Privacy Dashboard','{}'),(60,18,80,81,2,'com_modules.module.90','Jumi','{}'),(61,1,117,118,1,'com_jumi','com_jumi','{}'),(62,16,38,39,2,'com_menus.menu.2','Hidden','{}'),(63,1,119,120,1,'com_fields','com_fields','{}'),(64,1,121,122,1,'com_associations','com_associations','{}');
/*!40000 ALTER TABLE `joomla_assets` ENABLE KEYS */;

--
-- Table structure for table `joomla_associations`
--

DROP TABLE IF EXISTS `joomla_associations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_associations` (
  `id` int NOT NULL COMMENT 'A reference to the associated item.',
  `context` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The context of the associated item.',
  `key` char(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The key for the association computed from an md5 on associated ids.',
  PRIMARY KEY (`context`,`id`),
  KEY `idx_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_associations`
--

/*!40000 ALTER TABLE `joomla_associations` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_associations` ENABLE KEYS */;

--
-- Table structure for table `joomla_banner_clients`
--

DROP TABLE IF EXISTS `joomla_banner_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_banner_clients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `contact` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `extrainfo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint NOT NULL DEFAULT '0',
  `checked_out` int unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `metakey` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `own_prefix` tinyint NOT NULL DEFAULT '0',
  `metakey_prefix` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `purchase_type` tinyint NOT NULL DEFAULT '-1',
  `track_clicks` tinyint NOT NULL DEFAULT '-1',
  `track_impressions` tinyint NOT NULL DEFAULT '-1',
  PRIMARY KEY (`id`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`(100))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_banner_clients`
--

/*!40000 ALTER TABLE `joomla_banner_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_banner_clients` ENABLE KEYS */;

--
-- Table structure for table `joomla_banner_tracks`
--

DROP TABLE IF EXISTS `joomla_banner_tracks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_banner_tracks` (
  `track_date` datetime NOT NULL,
  `track_type` int unsigned NOT NULL,
  `banner_id` int unsigned NOT NULL,
  `count` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`track_date`,`track_type`,`banner_id`),
  KEY `idx_track_date` (`track_date`),
  KEY `idx_track_type` (`track_type`),
  KEY `idx_banner_id` (`banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_banner_tracks`
--

/*!40000 ALTER TABLE `joomla_banner_tracks` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_banner_tracks` ENABLE KEYS */;

--
-- Table structure for table `joomla_banners`
--

DROP TABLE IF EXISTS `joomla_banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_banners` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cid` int NOT NULL DEFAULT '0',
  `type` int NOT NULL DEFAULT '0',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `imptotal` int NOT NULL DEFAULT '0',
  `impmade` int NOT NULL DEFAULT '0',
  `clicks` int NOT NULL DEFAULT '0',
  `clickurl` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `state` tinyint NOT NULL DEFAULT '0',
  `catid` int unsigned NOT NULL DEFAULT '0',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `custombannercode` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sticky` tinyint unsigned NOT NULL DEFAULT '0',
  `ordering` int NOT NULL DEFAULT '0',
  `metakey` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `own_prefix` tinyint(1) NOT NULL DEFAULT '0',
  `metakey_prefix` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `purchase_type` tinyint NOT NULL DEFAULT '-1',
  `track_clicks` tinyint NOT NULL DEFAULT '-1',
  `track_impressions` tinyint NOT NULL DEFAULT '-1',
  `checked_out` int unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `reset` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `language` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_by` int unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int unsigned NOT NULL DEFAULT '0',
  `version` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_state` (`state`),
  KEY `idx_own_prefix` (`own_prefix`),
  KEY `idx_metakey_prefix` (`metakey_prefix`(100)),
  KEY `idx_banner_catid` (`catid`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_banners`
--

/*!40000 ALTER TABLE `joomla_banners` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_banners` ENABLE KEYS */;

--
-- Table structure for table `joomla_categories`
--

DROP TABLE IF EXISTS `joomla_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `asset_id` int unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `parent_id` int unsigned NOT NULL DEFAULT '0',
  `lft` int NOT NULL DEFAULT '0',
  `rgt` int NOT NULL DEFAULT '0',
  `level` int unsigned NOT NULL DEFAULT '0',
  `path` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `extension` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int unsigned NOT NULL DEFAULT '0',
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `metadesc` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'JSON encoded metadata properties.',
  `created_user_id` int unsigned NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_user_id` int unsigned NOT NULL DEFAULT '0',
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `hits` int unsigned NOT NULL DEFAULT '0',
  `language` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `version` int unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `cat_idx` (`extension`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_path` (`path`(100)),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`(100)),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_categories`
--

/*!40000 ALTER TABLE `joomla_categories` DISABLE KEYS */;
INSERT INTO `joomla_categories` VALUES (1,0,0,0,11,0,'','system','ROOT','root','','',1,0,'0000-00-00 00:00:00',1,'{}','','','{}',632,'2019-07-26 06:28:42',0,'0000-00-00 00:00:00',0,'*',1),(2,27,1,1,2,1,'uncategorised','com_content','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',632,'2019-07-26 06:28:42',0,'0000-00-00 00:00:00',0,'*',1),(3,28,1,3,4,1,'uncategorised','com_banners','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',632,'2019-07-26 06:28:42',0,'0000-00-00 00:00:00',0,'*',1),(4,29,1,5,6,1,'uncategorised','com_contact','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',632,'2019-07-26 06:28:42',0,'0000-00-00 00:00:00',0,'*',1),(5,30,1,7,8,1,'uncategorised','com_newsfeeds','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',632,'2019-07-26 06:28:42',0,'0000-00-00 00:00:00',0,'*',1),(7,32,1,9,10,1,'uncategorised','com_users','Uncategorised','uncategorised','','',1,0,'0000-00-00 00:00:00',1,'{\"category_layout\":\"\",\"image\":\"\"}','','','{\"author\":\"\",\"robots\":\"\"}',632,'2019-07-26 06:28:42',0,'0000-00-00 00:00:00',0,'*',1);
/*!40000 ALTER TABLE `joomla_categories` ENABLE KEYS */;

--
-- Table structure for table `joomla_contact_details`
--

DROP TABLE IF EXISTS `joomla_contact_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_contact_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `con_position` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `suburb` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `misc` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_to` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_con` tinyint unsigned NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int NOT NULL DEFAULT '0',
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `catid` int NOT NULL DEFAULT '0',
  `access` int unsigned NOT NULL DEFAULT '0',
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `webpage` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sortname1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sortname2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `sortname3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `language` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int unsigned NOT NULL DEFAULT '0',
  `metakey` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadata` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured` tinyint unsigned NOT NULL DEFAULT '0' COMMENT 'Set if contact is featured.',
  `xreference` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `version` int unsigned NOT NULL DEFAULT '1',
  `hits` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_contact_details`
--

/*!40000 ALTER TABLE `joomla_contact_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_contact_details` ENABLE KEYS */;

--
-- Table structure for table `joomla_content`
--

DROP TABLE IF EXISTS `joomla_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_content` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `introtext` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fulltext` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint NOT NULL DEFAULT '0',
  `catid` int unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int unsigned NOT NULL DEFAULT '0',
  `checked_out` int unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urls` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attribs` varchar(5120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int unsigned NOT NULL DEFAULT '1',
  `ordering` int NOT NULL DEFAULT '0',
  `metakey` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int unsigned NOT NULL DEFAULT '0',
  `hits` int unsigned NOT NULL DEFAULT '0',
  `metadata` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured` tinyint unsigned NOT NULL DEFAULT '0' COMMENT 'Set if article is featured.',
  `language` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The language code for the article.',
  `xreference` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'A reference to enable linkages to external data sets.',
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_featured_catid` (`featured`,`catid`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`),
  KEY `idx_alias` (`alias`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_content`
--

/*!40000 ALTER TABLE `joomla_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_content` ENABLE KEYS */;

--
-- Table structure for table `joomla_content_frontpage`
--

DROP TABLE IF EXISTS `joomla_content_frontpage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_content_frontpage` (
  `content_id` int NOT NULL DEFAULT '0',
  `ordering` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_content_frontpage`
--

/*!40000 ALTER TABLE `joomla_content_frontpage` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_content_frontpage` ENABLE KEYS */;

--
-- Table structure for table `joomla_content_rating`
--

DROP TABLE IF EXISTS `joomla_content_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_content_rating` (
  `content_id` int NOT NULL DEFAULT '0',
  `rating_sum` int unsigned NOT NULL DEFAULT '0',
  `rating_count` int unsigned NOT NULL DEFAULT '0',
  `lastip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_content_rating`
--

/*!40000 ALTER TABLE `joomla_content_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_content_rating` ENABLE KEYS */;

--
-- Table structure for table `joomla_content_types`
--

DROP TABLE IF EXISTS `joomla_content_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_content_types` (
  `type_id` int unsigned NOT NULL AUTO_INCREMENT,
  `type_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `type_alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `table` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rules` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_mappings` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `router` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content_history_options` varchar(5120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'JSON string for com_contenthistory options',
  PRIMARY KEY (`type_id`),
  KEY `idx_alias` (`type_alias`(100))
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_content_types`
--

/*!40000 ALTER TABLE `joomla_content_types` DISABLE KEYS */;
INSERT INTO `joomla_content_types` VALUES (1,'Article','com_content.article','{\"special\":{\"dbtable\":\"#__content\",\"key\":\"id\",\"type\":\"Content\",\"prefix\":\"JTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"title\",\"core_state\":\"state\",\"core_alias\":\"alias\",\"core_created_time\":\"created\",\"core_modified_time\":\"modified\",\"core_body\":\"introtext\", \"core_hits\":\"hits\",\"core_publish_up\":\"publish_up\",\"core_publish_down\":\"publish_down\",\"core_access\":\"access\", \"core_params\":\"attribs\", \"core_featured\":\"featured\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"images\", \"core_urls\":\"urls\", \"core_version\":\"version\", \"core_ordering\":\"ordering\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"catid\", \"core_xreference\":\"xreference\", \"asset_id\":\"asset_id\", \"note\":\"note\"}, \"special\":{\"fulltext\":\"fulltext\"}}','ContentHelperRoute::getArticleRoute','{\"formFile\":\"administrator\\/components\\/com_content\\/models\\/forms\\/article.xml\", \"hideFields\":[\"asset_id\",\"checked_out\",\"checked_out_time\",\"version\"],\"ignoreChanges\":[\"modified_by\", \"modified\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\", \"ordering\"],\"convertToInt\":[\"publish_up\", \"publish_down\", \"featured\", \"ordering\"],\"displayLookup\":[{\"sourceColumn\":\"catid\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"created_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"} ]}'),(2,'Contact','com_contact.contact','{\"special\":{\"dbtable\":\"#__contact_details\",\"key\":\"id\",\"type\":\"Contact\",\"prefix\":\"ContactTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"name\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created\",\"core_modified_time\":\"modified\",\"core_body\":\"address\", \"core_hits\":\"hits\",\"core_publish_up\":\"publish_up\",\"core_publish_down\":\"publish_down\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"featured\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"image\", \"core_urls\":\"webpage\", \"core_version\":\"version\", \"core_ordering\":\"ordering\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"catid\", \"core_xreference\":\"xreference\", \"asset_id\":\"null\"}, \"special\":{\"con_position\":\"con_position\",\"suburb\":\"suburb\",\"state\":\"state\",\"country\":\"country\",\"postcode\":\"postcode\",\"telephone\":\"telephone\",\"fax\":\"fax\",\"misc\":\"misc\",\"email_to\":\"email_to\",\"default_con\":\"default_con\",\"user_id\":\"user_id\",\"mobile\":\"mobile\",\"sortname1\":\"sortname1\",\"sortname2\":\"sortname2\",\"sortname3\":\"sortname3\"}}','ContactHelperRoute::getContactRoute','{\"formFile\":\"administrator\\/components\\/com_contact\\/models\\/forms\\/contact.xml\",\"hideFields\":[\"default_con\",\"checked_out\",\"checked_out_time\",\"version\",\"xreference\"],\"ignoreChanges\":[\"modified_by\", \"modified\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\", \"ordering\"],\"convertToInt\":[\"publish_up\", \"publish_down\", \"featured\", \"ordering\"], \"displayLookup\":[ {\"sourceColumn\":\"created_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"catid\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"} ] }'),(3,'Newsfeed','com_newsfeeds.newsfeed','{\"special\":{\"dbtable\":\"#__newsfeeds\",\"key\":\"id\",\"type\":\"Newsfeed\",\"prefix\":\"NewsfeedsTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"name\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created\",\"core_modified_time\":\"modified\",\"core_body\":\"description\", \"core_hits\":\"hits\",\"core_publish_up\":\"publish_up\",\"core_publish_down\":\"publish_down\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"featured\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"images\", \"core_urls\":\"link\", \"core_version\":\"version\", \"core_ordering\":\"ordering\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"catid\", \"core_xreference\":\"xreference\", \"asset_id\":\"null\"}, \"special\":{\"numarticles\":\"numarticles\",\"cache_time\":\"cache_time\",\"rtl\":\"rtl\"}}','NewsfeedsHelperRoute::getNewsfeedRoute','{\"formFile\":\"administrator\\/components\\/com_newsfeeds\\/models\\/forms\\/newsfeed.xml\",\"hideFields\":[\"asset_id\",\"checked_out\",\"checked_out_time\",\"version\"],\"ignoreChanges\":[\"modified_by\", \"modified\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\", \"ordering\"],\"convertToInt\":[\"publish_up\", \"publish_down\", \"featured\", \"ordering\"],\"displayLookup\":[{\"sourceColumn\":\"catid\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"created_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"} ]}'),(4,'User','com_users.user','{\"special\":{\"dbtable\":\"#__users\",\"key\":\"id\",\"type\":\"User\",\"prefix\":\"JTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"name\",\"core_state\":\"null\",\"core_alias\":\"username\",\"core_created_time\":\"registerdate\",\"core_modified_time\":\"lastvisitDate\",\"core_body\":\"null\", \"core_hits\":\"null\",\"core_publish_up\":\"null\",\"core_publish_down\":\"null\",\"access\":\"null\", \"core_params\":\"params\", \"core_featured\":\"null\", \"core_metadata\":\"null\", \"core_language\":\"null\", \"core_images\":\"null\", \"core_urls\":\"null\", \"core_version\":\"null\", \"core_ordering\":\"null\", \"core_metakey\":\"null\", \"core_metadesc\":\"null\", \"core_catid\":\"null\", \"core_xreference\":\"null\", \"asset_id\":\"null\"}, \"special\":{}}','UsersHelperRoute::getUserRoute',''),(5,'Article Category','com_content.category','{\"special\":{\"dbtable\":\"#__categories\",\"key\":\"id\",\"type\":\"Category\",\"prefix\":\"JTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"title\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created_time\",\"core_modified_time\":\"modified_time\",\"core_body\":\"description\", \"core_hits\":\"hits\",\"core_publish_up\":\"null\",\"core_publish_down\":\"null\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"null\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"null\", \"core_urls\":\"null\", \"core_version\":\"version\", \"core_ordering\":\"null\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"parent_id\", \"core_xreference\":\"null\", \"asset_id\":\"asset_id\"}, \"special\":{\"parent_id\":\"parent_id\",\"lft\":\"lft\",\"rgt\":\"rgt\",\"level\":\"level\",\"path\":\"path\",\"extension\":\"extension\",\"note\":\"note\"}}','ContentHelperRoute::getCategoryRoute','{\"formFile\":\"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml\", \"hideFields\":[\"asset_id\",\"checked_out\",\"checked_out_time\",\"version\",\"lft\",\"rgt\",\"level\",\"path\",\"extension\"], \"ignoreChanges\":[\"modified_user_id\", \"modified_time\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\", \"path\"],\"convertToInt\":[\"publish_up\", \"publish_down\"], \"displayLookup\":[{\"sourceColumn\":\"created_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"parent_id\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"}]}'),(6,'Contact Category','com_contact.category','{\"special\":{\"dbtable\":\"#__categories\",\"key\":\"id\",\"type\":\"Category\",\"prefix\":\"JTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"title\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created_time\",\"core_modified_time\":\"modified_time\",\"core_body\":\"description\", \"core_hits\":\"hits\",\"core_publish_up\":\"null\",\"core_publish_down\":\"null\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"null\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"null\", \"core_urls\":\"null\", \"core_version\":\"version\", \"core_ordering\":\"null\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"parent_id\", \"core_xreference\":\"null\", \"asset_id\":\"asset_id\"}, \"special\":{\"parent_id\":\"parent_id\",\"lft\":\"lft\",\"rgt\":\"rgt\",\"level\":\"level\",\"path\":\"path\",\"extension\":\"extension\",\"note\":\"note\"}}','ContactHelperRoute::getCategoryRoute','{\"formFile\":\"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml\", \"hideFields\":[\"asset_id\",\"checked_out\",\"checked_out_time\",\"version\",\"lft\",\"rgt\",\"level\",\"path\",\"extension\"], \"ignoreChanges\":[\"modified_user_id\", \"modified_time\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\", \"path\"],\"convertToInt\":[\"publish_up\", \"publish_down\"], \"displayLookup\":[{\"sourceColumn\":\"created_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"parent_id\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"}]}'),(7,'Newsfeeds Category','com_newsfeeds.category','{\"special\":{\"dbtable\":\"#__categories\",\"key\":\"id\",\"type\":\"Category\",\"prefix\":\"JTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"title\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created_time\",\"core_modified_time\":\"modified_time\",\"core_body\":\"description\", \"core_hits\":\"hits\",\"core_publish_up\":\"null\",\"core_publish_down\":\"null\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"null\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"null\", \"core_urls\":\"null\", \"core_version\":\"version\", \"core_ordering\":\"null\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"parent_id\", \"core_xreference\":\"null\", \"asset_id\":\"asset_id\"}, \"special\":{\"parent_id\":\"parent_id\",\"lft\":\"lft\",\"rgt\":\"rgt\",\"level\":\"level\",\"path\":\"path\",\"extension\":\"extension\",\"note\":\"note\"}}','NewsfeedsHelperRoute::getCategoryRoute','{\"formFile\":\"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml\", \"hideFields\":[\"asset_id\",\"checked_out\",\"checked_out_time\",\"version\",\"lft\",\"rgt\",\"level\",\"path\",\"extension\"], \"ignoreChanges\":[\"modified_user_id\", \"modified_time\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\", \"path\"],\"convertToInt\":[\"publish_up\", \"publish_down\"], \"displayLookup\":[{\"sourceColumn\":\"created_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"parent_id\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"}]}'),(8,'Tag','com_tags.tag','{\"special\":{\"dbtable\":\"#__tags\",\"key\":\"tag_id\",\"type\":\"Tag\",\"prefix\":\"TagsTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"title\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created_time\",\"core_modified_time\":\"modified_time\",\"core_body\":\"description\", \"core_hits\":\"hits\",\"core_publish_up\":\"null\",\"core_publish_down\":\"null\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"featured\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"images\", \"core_urls\":\"urls\", \"core_version\":\"version\", \"core_ordering\":\"null\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"null\", \"core_xreference\":\"null\", \"asset_id\":\"null\"}, \"special\":{\"parent_id\":\"parent_id\",\"lft\":\"lft\",\"rgt\":\"rgt\",\"level\":\"level\",\"path\":\"path\"}}','TagsHelperRoute::getTagRoute','{\"formFile\":\"administrator\\/components\\/com_tags\\/models\\/forms\\/tag.xml\", \"hideFields\":[\"checked_out\",\"checked_out_time\",\"version\", \"lft\", \"rgt\", \"level\", \"path\", \"urls\", \"publish_up\", \"publish_down\"],\"ignoreChanges\":[\"modified_user_id\", \"modified_time\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\", \"path\"],\"convertToInt\":[\"publish_up\", \"publish_down\"], \"displayLookup\":[{\"sourceColumn\":\"created_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"}, {\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"}, {\"sourceColumn\":\"modified_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"}]}'),(9,'Banner','com_banners.banner','{\"special\":{\"dbtable\":\"#__banners\",\"key\":\"id\",\"type\":\"Banner\",\"prefix\":\"BannersTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"name\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created\",\"core_modified_time\":\"modified\",\"core_body\":\"description\", \"core_hits\":\"null\",\"core_publish_up\":\"publish_up\",\"core_publish_down\":\"publish_down\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"null\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"images\", \"core_urls\":\"link\", \"core_version\":\"version\", \"core_ordering\":\"ordering\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"catid\", \"core_xreference\":\"null\", \"asset_id\":\"null\"}, \"special\":{\"imptotal\":\"imptotal\", \"impmade\":\"impmade\", \"clicks\":\"clicks\", \"clickurl\":\"clickurl\", \"custombannercode\":\"custombannercode\", \"cid\":\"cid\", \"purchase_type\":\"purchase_type\", \"track_impressions\":\"track_impressions\", \"track_clicks\":\"track_clicks\"}}','','{\"formFile\":\"administrator\\/components\\/com_banners\\/models\\/forms\\/banner.xml\", \"hideFields\":[\"checked_out\",\"checked_out_time\",\"version\", \"reset\"],\"ignoreChanges\":[\"modified_by\", \"modified\", \"checked_out\", \"checked_out_time\", \"version\", \"imptotal\", \"impmade\", \"reset\"], \"convertToInt\":[\"publish_up\", \"publish_down\", \"ordering\"], \"displayLookup\":[{\"sourceColumn\":\"catid\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"}, {\"sourceColumn\":\"cid\",\"targetTable\":\"#__banner_clients\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"}, {\"sourceColumn\":\"created_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"modified_by\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"} ]}'),(10,'Banners Category','com_banners.category','{\"special\":{\"dbtable\":\"#__categories\",\"key\":\"id\",\"type\":\"Category\",\"prefix\":\"JTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"title\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created_time\",\"core_modified_time\":\"modified_time\",\"core_body\":\"description\", \"core_hits\":\"hits\",\"core_publish_up\":\"null\",\"core_publish_down\":\"null\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"null\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"null\", \"core_urls\":\"null\", \"core_version\":\"version\", \"core_ordering\":\"null\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"parent_id\", \"core_xreference\":\"null\", \"asset_id\":\"asset_id\"}, \"special\": {\"parent_id\":\"parent_id\",\"lft\":\"lft\",\"rgt\":\"rgt\",\"level\":\"level\",\"path\":\"path\",\"extension\":\"extension\",\"note\":\"note\"}}','','{\"formFile\":\"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml\", \"hideFields\":[\"asset_id\",\"checked_out\",\"checked_out_time\",\"version\",\"lft\",\"rgt\",\"level\",\"path\",\"extension\"], \"ignoreChanges\":[\"modified_user_id\", \"modified_time\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\", \"path\"], \"convertToInt\":[\"publish_up\", \"publish_down\"], \"displayLookup\":[{\"sourceColumn\":\"created_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"parent_id\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"}]}'),(11,'Banner Client','com_banners.client','{\"special\":{\"dbtable\":\"#__banner_clients\",\"key\":\"id\",\"type\":\"Client\",\"prefix\":\"BannersTable\"}}','','','','{\"formFile\":\"administrator\\/components\\/com_banners\\/models\\/forms\\/client.xml\", \"hideFields\":[\"checked_out\",\"checked_out_time\"], \"ignoreChanges\":[\"checked_out\", \"checked_out_time\"], \"convertToInt\":[], \"displayLookup\":[]}'),(12,'User Notes','com_users.note','{\"special\":{\"dbtable\":\"#__user_notes\",\"key\":\"id\",\"type\":\"Note\",\"prefix\":\"UsersTable\"}}','','','','{\"formFile\":\"administrator\\/components\\/com_users\\/models\\/forms\\/note.xml\", \"hideFields\":[\"checked_out\",\"checked_out_time\", \"publish_up\", \"publish_down\"],\"ignoreChanges\":[\"modified_user_id\", \"modified_time\", \"checked_out\", \"checked_out_time\"], \"convertToInt\":[\"publish_up\", \"publish_down\"],\"displayLookup\":[{\"sourceColumn\":\"catid\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"}, {\"sourceColumn\":\"created_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"}, {\"sourceColumn\":\"user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"}, {\"sourceColumn\":\"modified_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"}]}'),(13,'User Notes Category','com_users.category','{\"special\":{\"dbtable\":\"#__categories\",\"key\":\"id\",\"type\":\"Category\",\"prefix\":\"JTable\",\"config\":\"array()\"},\"common\":{\"dbtable\":\"#__ucm_content\",\"key\":\"ucm_id\",\"type\":\"Corecontent\",\"prefix\":\"JTable\",\"config\":\"array()\"}}','','{\"common\":{\"core_content_item_id\":\"id\",\"core_title\":\"title\",\"core_state\":\"published\",\"core_alias\":\"alias\",\"core_created_time\":\"created_time\",\"core_modified_time\":\"modified_time\",\"core_body\":\"description\", \"core_hits\":\"hits\",\"core_publish_up\":\"null\",\"core_publish_down\":\"null\",\"core_access\":\"access\", \"core_params\":\"params\", \"core_featured\":\"null\", \"core_metadata\":\"metadata\", \"core_language\":\"language\", \"core_images\":\"null\", \"core_urls\":\"null\", \"core_version\":\"version\", \"core_ordering\":\"null\", \"core_metakey\":\"metakey\", \"core_metadesc\":\"metadesc\", \"core_catid\":\"parent_id\", \"core_xreference\":\"null\", \"asset_id\":\"asset_id\"}, \"special\":{\"parent_id\":\"parent_id\",\"lft\":\"lft\",\"rgt\":\"rgt\",\"level\":\"level\",\"path\":\"path\",\"extension\":\"extension\",\"note\":\"note\"}}','','{\"formFile\":\"administrator\\/components\\/com_categories\\/models\\/forms\\/category.xml\", \"hideFields\":[\"checked_out\",\"checked_out_time\",\"version\",\"lft\",\"rgt\",\"level\",\"path\",\"extension\"], \"ignoreChanges\":[\"modified_user_id\", \"modified_time\", \"checked_out\", \"checked_out_time\", \"version\", \"hits\", \"path\"], \"convertToInt\":[\"publish_up\", \"publish_down\"], \"displayLookup\":[{\"sourceColumn\":\"created_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"}, {\"sourceColumn\":\"access\",\"targetTable\":\"#__viewlevels\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"},{\"sourceColumn\":\"modified_user_id\",\"targetTable\":\"#__users\",\"targetColumn\":\"id\",\"displayColumn\":\"name\"},{\"sourceColumn\":\"parent_id\",\"targetTable\":\"#__categories\",\"targetColumn\":\"id\",\"displayColumn\":\"title\"}]}');
/*!40000 ALTER TABLE `joomla_content_types` ENABLE KEYS */;

--
-- Table structure for table `joomla_contentitem_tag_map`
--

DROP TABLE IF EXISTS `joomla_contentitem_tag_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_contentitem_tag_map` (
  `type_alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `core_content_id` int unsigned NOT NULL COMMENT 'PK from the core content table',
  `content_item_id` int NOT NULL COMMENT 'PK from the content type table',
  `tag_id` int unsigned NOT NULL COMMENT 'PK from the tag table',
  `tag_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Date of most recent save for this tag-item',
  `type_id` mediumint NOT NULL COMMENT 'PK from the content_type table',
  UNIQUE KEY `uc_ItemnameTagid` (`type_id`,`content_item_id`,`tag_id`),
  KEY `idx_tag_type` (`tag_id`,`type_id`),
  KEY `idx_date_id` (`tag_date`,`tag_id`),
  KEY `idx_core_content_id` (`core_content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Maps items from content tables to tags';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_contentitem_tag_map`
--

/*!40000 ALTER TABLE `joomla_contentitem_tag_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_contentitem_tag_map` ENABLE KEYS */;

--
-- Table structure for table `joomla_core_log_searches`
--

DROP TABLE IF EXISTS `joomla_core_log_searches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_core_log_searches` (
  `search_term` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `hits` int unsigned NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_core_log_searches`
--

/*!40000 ALTER TABLE `joomla_core_log_searches` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_core_log_searches` ENABLE KEYS */;

--
-- Table structure for table `joomla_extensions`
--

DROP TABLE IF EXISTS `joomla_extensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_extensions` (
  `extension_id` int NOT NULL AUTO_INCREMENT,
  `package_id` int NOT NULL DEFAULT '0' COMMENT 'Parent package ID for extensions installed as a package.',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `element` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` tinyint NOT NULL,
  `enabled` tinyint NOT NULL DEFAULT '0',
  `access` int unsigned NOT NULL DEFAULT '1',
  `protected` tinyint NOT NULL DEFAULT '0',
  `manifest_cache` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `custom_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `system_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `checked_out` int unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int DEFAULT '0',
  `state` int DEFAULT '0',
  PRIMARY KEY (`extension_id`),
  KEY `element_clientid` (`element`,`client_id`),
  KEY `element_folder_clientid` (`element`,`folder`,`client_id`),
  KEY `extension` (`type`,`element`,`folder`,`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10017 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_extensions`
--

/*!40000 ALTER TABLE `joomla_extensions` DISABLE KEYS */;
INSERT INTO `joomla_extensions` VALUES (1,0,'com_mailto','component','com_mailto','',0,1,1,1,'{\"name\":\"com_mailto\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_MAILTO_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mailto\"}','','','',0,'0000-00-00 00:00:00',0,0),(2,0,'com_wrapper','component','com_wrapper','',0,1,1,1,'{\"name\":\"com_wrapper\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2007 Open Source Matters, Inc.\\n\\t\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_WRAPPER_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"wrapper\"}','','','',0,'0000-00-00 00:00:00',0,0),(3,0,'com_admin','component','com_admin','',1,1,1,1,'{\"name\":\"com_admin\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_ADMIN_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(4,0,'com_banners','component','com_banners','',1,1,1,0,'{\"name\":\"com_banners\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_BANNERS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"banners\"}','{\"purchase_type\":\"3\",\"track_impressions\":\"0\",\"track_clicks\":\"0\",\"metakey_prefix\":\"\",\"save_history\":\"1\",\"history_limit\":10}','','',0,'0000-00-00 00:00:00',0,0),(5,0,'com_cache','component','com_cache','',1,1,1,1,'{\"name\":\"com_cache\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_CACHE_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(6,0,'com_categories','component','com_categories','',1,1,1,1,'{\"name\":\"com_categories\",\"type\":\"component\",\"creationDate\":\"December 2007\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2007 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_CATEGORIES_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(7,0,'com_checkin','component','com_checkin','',1,1,1,1,'{\"name\":\"com_checkin\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_CHECKIN_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(8,0,'com_contact','component','com_contact','',1,1,1,0,'{\"name\":\"com_contact\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_CONTACT_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"contact\"}','{\"contact_layout\":\"_:default\",\"show_contact_category\":\"hide\",\"save_history\":\"1\",\"history_limit\":10,\"show_contact_list\":\"0\",\"presentation_style\":\"sliders\",\"show_tags\":\"1\",\"show_info\":\"1\",\"show_name\":\"1\",\"show_position\":\"1\",\"show_email\":\"0\",\"show_street_address\":\"1\",\"show_suburb\":\"1\",\"show_state\":\"1\",\"show_postcode\":\"1\",\"show_country\":\"1\",\"show_telephone\":\"1\",\"show_mobile\":\"1\",\"show_fax\":\"1\",\"show_webpage\":\"1\",\"show_image\":\"1\",\"show_misc\":\"1\",\"image\":\"\",\"allow_vcard\":\"0\",\"show_articles\":\"0\",\"articles_display_num\":\"10\",\"show_profile\":\"0\",\"show_user_custom_fields\":[\"-1\"],\"show_links\":\"0\",\"linka_name\":\"\",\"linkb_name\":\"\",\"linkc_name\":\"\",\"linkd_name\":\"\",\"linke_name\":\"\",\"contact_icons\":\"0\",\"icon_address\":\"\",\"icon_email\":\"\",\"icon_telephone\":\"\",\"icon_mobile\":\"\",\"icon_fax\":\"\",\"icon_misc\":\"\",\"category_layout\":\"_:default\",\"show_category_title\":\"1\",\"show_description\":\"1\",\"show_description_image\":\"0\",\"maxLevel\":\"-1\",\"show_subcat_desc\":\"1\",\"show_empty_categories\":\"0\",\"show_cat_items\":\"1\",\"show_cat_tags\":\"1\",\"show_base_description\":\"1\",\"maxLevelcat\":\"-1\",\"show_subcat_desc_cat\":\"1\",\"show_empty_categories_cat\":\"0\",\"show_cat_items_cat\":\"1\",\"filter_field\":\"0\",\"show_pagination_limit\":\"0\",\"show_headings\":\"1\",\"show_image_heading\":\"0\",\"show_position_headings\":\"1\",\"show_email_headings\":\"0\",\"show_telephone_headings\":\"1\",\"show_mobile_headings\":\"0\",\"show_fax_headings\":\"0\",\"show_suburb_headings\":\"1\",\"show_state_headings\":\"1\",\"show_country_headings\":\"1\",\"show_pagination\":\"2\",\"show_pagination_results\":\"1\",\"initial_sort\":\"ordering\",\"captcha\":\"\",\"show_email_form\":\"1\",\"show_email_copy\":\"0\",\"banned_email\":\"\",\"banned_subject\":\"\",\"banned_text\":\"\",\"validate_session\":\"1\",\"custom_reply\":\"0\",\"redirect\":\"\",\"show_feed_link\":\"1\",\"sef_advanced\":0,\"sef_ids\":0,\"custom_fields_enable\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(9,0,'com_cpanel','component','com_cpanel','',1,1,1,1,'{\"name\":\"com_cpanel\",\"type\":\"component\",\"creationDate\":\"Jun 2007\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2007 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_CPANEL_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(10,0,'com_installer','component','com_installer','',1,1,1,1,'{\"name\":\"com_installer\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_INSTALLER_XML_DESCRIPTION\",\"group\":\"\"}','{\"show_jed_info\":\"1\",\"cachetimeout\":\"6\",\"minimum_stability\":\"4\"}','','',0,'0000-00-00 00:00:00',0,0),(11,0,'com_languages','component','com_languages','',1,1,1,1,'{\"name\":\"com_languages\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_LANGUAGES_XML_DESCRIPTION\",\"group\":\"\"}','{\"administrator\":\"en-GB\",\"site\":\"en-GB\"}','','',0,'0000-00-00 00:00:00',0,0),(12,0,'com_login','component','com_login','',1,1,1,1,'{\"name\":\"com_login\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_LOGIN_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(13,0,'com_media','component','com_media','',1,1,0,1,'{\"name\":\"com_media\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_MEDIA_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"media\"}','{\"upload_extensions\":\"bmp,csv,doc,gif,ico,jpg,jpeg,odg,odp,ods,odt,pdf,png,ppt,txt,xcf,xls,BMP,CSV,DOC,GIF,ICO,JPG,JPEG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,TXT,XCF,XLS\",\"upload_maxsize\":\"10\",\"file_path\":\"images\",\"image_path\":\"images\",\"restrict_uploads\":\"1\",\"check_mime\":\"1\",\"image_extensions\":\"bmp,gif,jpg,png\",\"ignore_extensions\":\"\",\"upload_mime\":\"image\\/jpeg,image\\/gif,image\\/png,image\\/bmp,application\\/msword,application\\/excel,application\\/pdf,application\\/powerpoint,text\\/plain,application\\/x-zip\",\"upload_mime_illegal\":\"text\\/html\"}','','',0,'0000-00-00 00:00:00',0,0),(14,0,'com_menus','component','com_menus','',1,1,1,1,'{\"name\":\"com_menus\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_MENUS_XML_DESCRIPTION\",\"group\":\"\"}','{\"page_title\":\"\",\"show_page_heading\":0,\"page_heading\":\"\",\"pageclass_sfx\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(15,0,'com_messages','component','com_messages','',1,1,1,1,'{\"name\":\"com_messages\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_MESSAGES_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(16,0,'com_modules','component','com_modules','',1,1,1,1,'{\"name\":\"com_modules\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_MODULES_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(17,0,'com_newsfeeds','component','com_newsfeeds','',1,1,1,0,'{\"name\":\"com_newsfeeds\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_NEWSFEEDS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"newsfeeds\"}','{\"newsfeed_layout\":\"_:default\",\"save_history\":\"1\",\"history_limit\":5,\"show_feed_image\":\"1\",\"show_feed_description\":\"1\",\"show_item_description\":\"1\",\"feed_character_count\":\"0\",\"feed_display_order\":\"des\",\"float_first\":\"right\",\"float_second\":\"right\",\"show_tags\":\"1\",\"category_layout\":\"_:default\",\"show_category_title\":\"1\",\"show_description\":\"1\",\"show_description_image\":\"1\",\"maxLevel\":\"-1\",\"show_empty_categories\":\"0\",\"show_subcat_desc\":\"1\",\"show_cat_items\":\"1\",\"show_cat_tags\":\"1\",\"show_base_description\":\"1\",\"maxLevelcat\":\"-1\",\"show_empty_categories_cat\":\"0\",\"show_subcat_desc_cat\":\"1\",\"show_cat_items_cat\":\"1\",\"filter_field\":\"1\",\"show_pagination_limit\":\"1\",\"show_headings\":\"1\",\"show_articles\":\"0\",\"show_link\":\"1\",\"show_pagination\":\"1\",\"show_pagination_results\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(18,0,'com_plugins','component','com_plugins','',1,1,1,1,'{\"name\":\"com_plugins\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_PLUGINS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(19,0,'com_search','component','com_search','',1,1,1,0,'{\"name\":\"com_search\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_SEARCH_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"search\"}','{\"enabled\":\"0\",\"search_phrases\":\"1\",\"search_areas\":\"1\",\"show_date\":\"1\",\"opensearch_name\":\"\",\"opensearch_description\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(20,0,'com_templates','component','com_templates','',1,1,1,1,'{\"name\":\"com_templates\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_TEMPLATES_XML_DESCRIPTION\",\"group\":\"\"}','{\"template_positions_display\":\"0\",\"upload_limit\":\"10\",\"image_formats\":\"gif,bmp,jpg,jpeg,png\",\"source_formats\":\"txt,less,ini,xml,js,php,css,scss,sass\",\"font_formats\":\"woff,ttf,otf\",\"compressed_formats\":\"zip\"}','','',0,'0000-00-00 00:00:00',0,0),(22,0,'com_content','component','com_content','',1,1,0,1,'{\"name\":\"com_content\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_CONTENT_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"content\"}','{\"article_layout\":\"_:default\",\"show_title\":\"1\",\"link_titles\":\"1\",\"show_intro\":\"1\",\"show_category\":\"1\",\"link_category\":\"1\",\"show_parent_category\":\"0\",\"link_parent_category\":\"0\",\"show_author\":\"1\",\"link_author\":\"0\",\"show_create_date\":\"0\",\"show_modify_date\":\"0\",\"show_publish_date\":\"1\",\"show_item_navigation\":\"1\",\"show_vote\":\"0\",\"show_readmore\":\"1\",\"show_readmore_title\":\"1\",\"readmore_limit\":\"100\",\"show_icons\":\"1\",\"show_print_icon\":\"1\",\"show_email_icon\":\"0\",\"show_hits\":\"1\",\"show_noauth\":\"0\",\"show_publishing_options\":\"1\",\"show_article_options\":\"1\",\"save_history\":\"1\",\"history_limit\":10,\"show_urls_images_frontend\":\"0\",\"show_urls_images_backend\":\"1\",\"targeta\":0,\"targetb\":0,\"targetc\":0,\"float_intro\":\"left\",\"float_fulltext\":\"left\",\"category_layout\":\"_:blog\",\"show_category_title\":\"0\",\"show_description\":\"0\",\"show_description_image\":\"0\",\"maxLevel\":\"1\",\"show_empty_categories\":\"0\",\"show_no_articles\":\"1\",\"show_subcat_desc\":\"1\",\"show_cat_num_articles\":\"0\",\"show_base_description\":\"1\",\"maxLevelcat\":\"-1\",\"show_empty_categories_cat\":\"0\",\"show_subcat_desc_cat\":\"1\",\"show_cat_num_articles_cat\":\"1\",\"num_leading_articles\":\"1\",\"num_intro_articles\":\"4\",\"num_columns\":\"2\",\"num_links\":\"4\",\"multi_column_order\":\"0\",\"show_subcategory_content\":\"0\",\"show_pagination_limit\":\"1\",\"filter_field\":\"hide\",\"show_headings\":\"1\",\"list_show_date\":\"0\",\"date_format\":\"\",\"list_show_hits\":\"1\",\"list_show_author\":\"1\",\"orderby_pri\":\"order\",\"orderby_sec\":\"rdate\",\"order_date\":\"published\",\"show_pagination\":\"2\",\"show_pagination_results\":\"1\",\"show_feed_link\":\"1\",\"feed_summary\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(23,0,'com_config','component','com_config','',1,1,0,1,'{\"name\":\"com_config\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_CONFIG_XML_DESCRIPTION\",\"group\":\"\"}','{\"filters\":{\"1\":{\"filter_type\":\"NH\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"9\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"6\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"7\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"2\":{\"filter_type\":\"NH\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"3\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"4\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"5\":{\"filter_type\":\"BL\",\"filter_tags\":\"\",\"filter_attributes\":\"\"},\"8\":{\"filter_type\":\"NONE\",\"filter_tags\":\"\",\"filter_attributes\":\"\"}}}','','',0,'0000-00-00 00:00:00',0,0),(24,0,'com_redirect','component','com_redirect','',1,1,0,1,'{\"name\":\"com_redirect\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_REDIRECT_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(25,0,'com_users','component','com_users','',1,1,0,1,'{\"name\":\"com_users\",\"type\":\"component\",\"creationDate\":\"April 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_USERS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"users\"}','{\"allowUserRegistration\":\"0\",\"new_usertype\":\"2\",\"guest_usergroup\":\"9\",\"sendpassword\":\"0\",\"useractivation\":\"2\",\"mail_to_admin\":\"1\",\"captcha\":\"\",\"frontend_userparams\":\"1\",\"site_language\":\"0\",\"change_login_name\":\"0\",\"reset_count\":\"10\",\"reset_time\":\"1\",\"minimum_length\":\"4\",\"minimum_integers\":\"0\",\"minimum_symbols\":\"0\",\"minimum_uppercase\":\"0\",\"save_history\":\"1\",\"history_limit\":5,\"mailSubjectPrefix\":\"\",\"mailBodySuffix\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(27,0,'com_finder','component','com_finder','',1,1,0,0,'{\"name\":\"com_finder\",\"type\":\"component\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2011 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"COM_FINDER_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"finder\"}','{\"enabled\":\"0\",\"show_description\":\"1\",\"description_length\":255,\"allow_empty_query\":\"0\",\"show_url\":\"1\",\"show_autosuggest\":\"1\",\"show_suggested_query\":\"1\",\"show_explained_query\":\"1\",\"show_advanced\":\"1\",\"show_advanced_tips\":\"1\",\"expand_advanced\":\"0\",\"show_date_filters\":\"0\",\"sort_order\":\"relevance\",\"sort_direction\":\"desc\",\"highlight_terms\":\"1\",\"opensearch_name\":\"\",\"opensearch_description\":\"\",\"batch_size\":\"50\",\"memory_table_limit\":30000,\"title_multiplier\":\"1.7\",\"text_multiplier\":\"0.7\",\"meta_multiplier\":\"1.2\",\"path_multiplier\":\"2.0\",\"misc_multiplier\":\"0.3\",\"stem\":\"1\",\"stemmer\":\"snowball\",\"enable_logging\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(28,0,'com_joomlaupdate','component','com_joomlaupdate','',1,1,0,1,'{\"name\":\"com_joomlaupdate\",\"type\":\"component\",\"creationDate\":\"February 2012\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2012 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.10.1\",\"description\":\"COM_JOOMLAUPDATE_XML_DESCRIPTION\",\"group\":\"\"}','{\"updatesource\":\"default\",\"minimum_stability\":\"4\",\"customurl\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(29,0,'com_tags','component','com_tags','',1,1,1,1,'{\"name\":\"com_tags\",\"type\":\"component\",\"creationDate\":\"December 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2013 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.1.0\",\"description\":\"COM_TAGS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"tags\"}','{\"tag_layout\":\"_:default\",\"save_history\":\"1\",\"history_limit\":5,\"show_tag_title\":\"0\",\"tag_list_show_tag_image\":\"0\",\"tag_list_show_tag_description\":\"0\",\"tag_list_image\":\"\",\"tag_list_orderby\":\"title\",\"tag_list_orderby_direction\":\"ASC\",\"show_headings\":\"0\",\"tag_list_show_date\":\"0\",\"tag_list_show_item_image\":\"0\",\"tag_list_show_item_description\":\"0\",\"tag_list_item_maximum_characters\":0,\"return_any_or_all\":\"1\",\"include_children\":\"0\",\"maximum\":200,\"tag_list_language_filter\":\"all\",\"tags_layout\":\"_:default\",\"all_tags_orderby\":\"title\",\"all_tags_orderby_direction\":\"ASC\",\"all_tags_show_tag_image\":\"0\",\"all_tags_show_tag_description\":\"0\",\"all_tags_tag_maximum_characters\":20,\"all_tags_show_tag_hits\":\"0\",\"filter_field\":\"1\",\"show_pagination_limit\":\"1\",\"show_pagination\":\"2\",\"show_pagination_results\":\"1\",\"tag_field_ajax_mode\":\"1\",\"show_feed_link\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(30,0,'com_contenthistory','component','com_contenthistory','',1,1,1,0,'{\"name\":\"com_contenthistory\",\"type\":\"component\",\"creationDate\":\"May 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2013 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.2.0\",\"description\":\"COM_CONTENTHISTORY_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"contenthistory\"}','','','',0,'0000-00-00 00:00:00',0,0),(31,0,'com_ajax','component','com_ajax','',1,1,1,1,'{\"name\":\"com_ajax\",\"type\":\"component\",\"creationDate\":\"August 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2013 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.2.0\",\"description\":\"COM_AJAX_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"ajax\"}','','','',0,'0000-00-00 00:00:00',0,0),(32,0,'com_postinstall','component','com_postinstall','',1,1,1,1,'{\"name\":\"com_postinstall\",\"type\":\"component\",\"creationDate\":\"September 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2013 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.2.0\",\"description\":\"COM_POSTINSTALL_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(33,0,'com_fields','component','com_fields','',1,1,1,0,'{\"name\":\"com_fields\",\"type\":\"component\",\"creationDate\":\"March 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"COM_FIELDS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"fields\"}','','','',0,'0000-00-00 00:00:00',0,0),(34,0,'com_associations','component','com_associations','',1,1,1,0,'{\"name\":\"com_associations\",\"type\":\"component\",\"creationDate\":\"January 2017\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2017 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"COM_ASSOCIATIONS_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(35,0,'com_privacy','component','com_privacy','',1,1,1,1,'{\"name\":\"com_privacy\",\"type\":\"component\",\"creationDate\":\"May 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"COM_PRIVACY_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"privacy\"}','','','',0,'0000-00-00 00:00:00',0,0),(36,0,'com_actionlogs','component','com_actionlogs','',1,1,1,1,'{\"name\":\"com_actionlogs\",\"type\":\"component\",\"creationDate\":\"May 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"COM_ACTIONLOGS_XML_DESCRIPTION\",\"group\":\"\"}','{\"ip_logging\":0,\"csv_delimiter\":\",\",\"loggable_extensions\":[\"com_banners\",\"com_cache\",\"com_categories\",\"com_checkin\",\"com_config\",\"com_contact\",\"com_content\",\"com_installer\",\"com_media\",\"com_menus\",\"com_messages\",\"com_modules\",\"com_newsfeeds\",\"com_plugins\",\"com_redirect\",\"com_tags\",\"com_templates\",\"com_users\"]}','','',0,'0000-00-00 00:00:00',0,0),(102,0,'LIB_PHPUTF8','library','phputf8','',0,1,1,1,'{\"name\":\"LIB_PHPUTF8\",\"type\":\"library\",\"creationDate\":\"2006\",\"author\":\"Harry Fuecks\",\"copyright\":\"Copyright various authors\",\"authorEmail\":\"hfuecks@gmail.com\",\"authorUrl\":\"http:\\/\\/sourceforge.net\\/projects\\/phputf8\",\"version\":\"0.5\",\"description\":\"LIB_PHPUTF8_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"phputf8\"}','','','',0,'0000-00-00 00:00:00',0,0),(103,0,'LIB_JOOMLA','library','joomla','',0,1,1,1,'{\"name\":\"LIB_JOOMLA\",\"type\":\"library\",\"creationDate\":\"2008\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2008 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"https:\\/\\/www.joomla.org\",\"version\":\"13.1\",\"description\":\"LIB_JOOMLA_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"joomla\"}','{\"mediaversion\":\"904a2431b91fb4b20081a27fd19e7b44\"}','','',0,'0000-00-00 00:00:00',0,0),(104,0,'LIB_IDNA','library','idna_convert','',0,1,1,1,'{\"name\":\"LIB_IDNA\",\"type\":\"library\",\"creationDate\":\"2004\",\"author\":\"phlyLabs\",\"copyright\":\"2004-2011 phlyLabs Berlin, http:\\/\\/phlylabs.de\",\"authorEmail\":\"phlymail@phlylabs.de\",\"authorUrl\":\"http:\\/\\/phlylabs.de\",\"version\":\"0.8.0\",\"description\":\"LIB_IDNA_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"idna_convert\"}','','','',0,'0000-00-00 00:00:00',0,0),(105,0,'FOF','library','fof','',0,1,1,1,'{\"name\":\"FOF\",\"type\":\"library\",\"creationDate\":\"2015-04-22 13:15:32\",\"author\":\"Nicholas K. Dionysopoulos \\/ Akeeba Ltd\",\"copyright\":\"(C)2011-2015 Nicholas K. Dionysopoulos\",\"authorEmail\":\"nicholas@akeebabackup.com\",\"authorUrl\":\"https:\\/\\/www.akeebabackup.com\",\"version\":\"2.4.3\",\"description\":\"LIB_FOF_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"fof\"}','','','',0,'0000-00-00 00:00:00',0,0),(106,0,'LIB_PHPASS','library','phpass','',0,1,1,1,'{\"name\":\"LIB_PHPASS\",\"type\":\"library\",\"creationDate\":\"2004-2006\",\"author\":\"Solar Designer\",\"copyright\":\"\",\"authorEmail\":\"solar@openwall.com\",\"authorUrl\":\"http:\\/\\/www.openwall.com\\/phpass\\/\",\"version\":\"0.3\",\"description\":\"LIB_PHPASS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"phpass\"}','','','',0,'0000-00-00 00:00:00',0,0),(200,0,'mod_articles_archive','module','mod_articles_archive','',0,1,1,0,'{\"name\":\"mod_articles_archive\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_ARTICLES_ARCHIVE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_articles_archive\"}','','','',0,'0000-00-00 00:00:00',0,0),(201,0,'mod_articles_latest','module','mod_articles_latest','',0,1,1,0,'{\"name\":\"mod_articles_latest\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_LATEST_NEWS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_articles_latest\"}','','','',0,'0000-00-00 00:00:00',0,0),(202,0,'mod_articles_popular','module','mod_articles_popular','',0,1,1,0,'{\"name\":\"mod_articles_popular\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_POPULAR_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_articles_popular\"}','','','',0,'0000-00-00 00:00:00',0,0),(203,0,'mod_banners','module','mod_banners','',0,1,1,0,'{\"name\":\"mod_banners\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_BANNERS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_banners\"}','','','',0,'0000-00-00 00:00:00',0,0),(204,0,'mod_breadcrumbs','module','mod_breadcrumbs','',0,1,1,1,'{\"name\":\"mod_breadcrumbs\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_BREADCRUMBS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_breadcrumbs\"}','','','',0,'0000-00-00 00:00:00',0,0),(205,0,'mod_custom','module','mod_custom','',0,1,1,1,'{\"name\":\"mod_custom\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_CUSTOM_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_custom\"}','','','',0,'0000-00-00 00:00:00',0,0),(206,0,'mod_feed','module','mod_feed','',0,1,1,0,'{\"name\":\"mod_feed\",\"type\":\"module\",\"creationDate\":\"July 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_FEED_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_feed\"}','','','',0,'0000-00-00 00:00:00',0,0),(207,0,'mod_footer','module','mod_footer','',0,1,1,0,'{\"name\":\"mod_footer\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_FOOTER_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_footer\"}','','','',0,'0000-00-00 00:00:00',0,0),(208,0,'mod_login','module','mod_login','',0,1,1,1,'{\"name\":\"mod_login\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_LOGIN_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_login\"}','','','',0,'0000-00-00 00:00:00',0,0),(209,0,'mod_menu','module','mod_menu','',0,1,1,1,'{\"name\":\"mod_menu\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_MENU_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_menu\"}','','','',0,'0000-00-00 00:00:00',0,0),(210,0,'mod_articles_news','module','mod_articles_news','',0,1,1,0,'{\"name\":\"mod_articles_news\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_ARTICLES_NEWS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_articles_news\"}','','','',0,'0000-00-00 00:00:00',0,0),(211,0,'mod_random_image','module','mod_random_image','',0,1,1,0,'{\"name\":\"mod_random_image\",\"type\":\"module\",\"creationDate\":\"July 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_RANDOM_IMAGE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_random_image\"}','','','',0,'0000-00-00 00:00:00',0,0),(212,0,'mod_related_items','module','mod_related_items','',0,1,1,0,'{\"name\":\"mod_related_items\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_RELATED_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_related_items\"}','','','',0,'0000-00-00 00:00:00',0,0),(213,0,'mod_search','module','mod_search','',0,1,1,0,'{\"name\":\"mod_search\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_SEARCH_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_search\"}','','','',0,'0000-00-00 00:00:00',0,0),(214,0,'mod_stats','module','mod_stats','',0,1,1,0,'{\"name\":\"mod_stats\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_STATS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_stats\"}','','','',0,'0000-00-00 00:00:00',0,0),(215,0,'mod_syndicate','module','mod_syndicate','',0,1,1,1,'{\"name\":\"mod_syndicate\",\"type\":\"module\",\"creationDate\":\"May 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_SYNDICATE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_syndicate\"}','','','',0,'0000-00-00 00:00:00',0,0),(216,0,'mod_users_latest','module','mod_users_latest','',0,1,1,0,'{\"name\":\"mod_users_latest\",\"type\":\"module\",\"creationDate\":\"December 2009\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2009 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_USERS_LATEST_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_users_latest\"}','','','',0,'0000-00-00 00:00:00',0,0),(218,0,'mod_whosonline','module','mod_whosonline','',0,1,1,0,'{\"name\":\"mod_whosonline\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_WHOSONLINE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_whosonline\"}','','','',0,'0000-00-00 00:00:00',0,0),(219,0,'mod_wrapper','module','mod_wrapper','',0,1,1,0,'{\"name\":\"mod_wrapper\",\"type\":\"module\",\"creationDate\":\"October 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_WRAPPER_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_wrapper\"}','','','',0,'0000-00-00 00:00:00',0,0),(220,0,'mod_articles_category','module','mod_articles_category','',0,1,1,0,'{\"name\":\"mod_articles_category\",\"type\":\"module\",\"creationDate\":\"February 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2010 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_ARTICLES_CATEGORY_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_articles_category\"}','','','',0,'0000-00-00 00:00:00',0,0),(221,0,'mod_articles_categories','module','mod_articles_categories','',0,1,1,0,'{\"name\":\"mod_articles_categories\",\"type\":\"module\",\"creationDate\":\"February 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2010 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_ARTICLES_CATEGORIES_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_articles_categories\"}','','','',0,'0000-00-00 00:00:00',0,0),(222,0,'mod_languages','module','mod_languages','',0,1,1,1,'{\"name\":\"mod_languages\",\"type\":\"module\",\"creationDate\":\"February 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2010 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.5.0\",\"description\":\"MOD_LANGUAGES_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_languages\"}','','','',0,'0000-00-00 00:00:00',0,0),(223,0,'mod_finder','module','mod_finder','',0,1,0,0,'{\"name\":\"mod_finder\",\"type\":\"module\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2011 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_FINDER_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_finder\"}','','','',0,'0000-00-00 00:00:00',0,0),(300,0,'mod_custom','module','mod_custom','',1,1,1,1,'{\"name\":\"mod_custom\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_CUSTOM_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_custom\"}','','','',0,'0000-00-00 00:00:00',0,0),(301,0,'mod_feed','module','mod_feed','',1,1,1,0,'{\"name\":\"mod_feed\",\"type\":\"module\",\"creationDate\":\"July 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_FEED_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_feed\"}','','','',0,'0000-00-00 00:00:00',0,0),(302,0,'mod_latest','module','mod_latest','',1,1,1,0,'{\"name\":\"mod_latest\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_LATEST_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_latest\"}','','','',0,'0000-00-00 00:00:00',0,0),(303,0,'mod_logged','module','mod_logged','',1,1,1,0,'{\"name\":\"mod_logged\",\"type\":\"module\",\"creationDate\":\"January 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_LOGGED_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_logged\"}','','','',0,'0000-00-00 00:00:00',0,0),(304,0,'mod_login','module','mod_login','',1,1,1,1,'{\"name\":\"mod_login\",\"type\":\"module\",\"creationDate\":\"March 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_LOGIN_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_login\"}','','','',0,'0000-00-00 00:00:00',0,0),(305,0,'mod_menu','module','mod_menu','',1,1,1,0,'{\"name\":\"mod_menu\",\"type\":\"module\",\"creationDate\":\"March 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_MENU_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_menu\"}','','','',0,'0000-00-00 00:00:00',0,0),(307,0,'mod_popular','module','mod_popular','',1,1,1,0,'{\"name\":\"mod_popular\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_POPULAR_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_popular\"}','','','',0,'0000-00-00 00:00:00',0,0),(308,0,'mod_quickicon','module','mod_quickicon','',1,1,1,1,'{\"name\":\"mod_quickicon\",\"type\":\"module\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_QUICKICON_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_quickicon\"}','','','',0,'0000-00-00 00:00:00',0,0),(309,0,'mod_status','module','mod_status','',1,1,1,0,'{\"name\":\"mod_status\",\"type\":\"module\",\"creationDate\":\"February 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_STATUS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_status\"}','','','',0,'0000-00-00 00:00:00',0,0),(310,0,'mod_submenu','module','mod_submenu','',1,1,1,0,'{\"name\":\"mod_submenu\",\"type\":\"module\",\"creationDate\":\"February 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_SUBMENU_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_submenu\"}','','','',0,'0000-00-00 00:00:00',0,0),(311,0,'mod_title','module','mod_title','',1,1,1,0,'{\"name\":\"mod_title\",\"type\":\"module\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_TITLE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_title\"}','','','',0,'0000-00-00 00:00:00',0,0),(312,0,'mod_toolbar','module','mod_toolbar','',1,1,1,1,'{\"name\":\"mod_toolbar\",\"type\":\"module\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_TOOLBAR_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_toolbar\"}','','','',0,'0000-00-00 00:00:00',0,0),(313,0,'mod_multilangstatus','module','mod_multilangstatus','',1,1,1,0,'{\"name\":\"mod_multilangstatus\",\"type\":\"module\",\"creationDate\":\"September 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2011 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_MULTILANGSTATUS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_multilangstatus\"}','{\"cache\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(314,0,'mod_version','module','mod_version','',1,1,1,0,'{\"name\":\"mod_version\",\"type\":\"module\",\"creationDate\":\"January 2012\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2012 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_VERSION_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_version\"}','{\"format\":\"short\",\"product\":\"1\",\"cache\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(315,0,'mod_stats_admin','module','mod_stats_admin','',1,1,1,0,'{\"name\":\"mod_stats_admin\",\"type\":\"module\",\"creationDate\":\"July 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"MOD_STATS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_stats_admin\"}','{\"serverinfo\":\"0\",\"siteinfo\":\"0\",\"counter\":\"0\",\"increase\":\"0\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"static\"}','','',0,'0000-00-00 00:00:00',0,0),(316,0,'mod_tags_popular','module','mod_tags_popular','',0,1,1,0,'{\"name\":\"mod_tags_popular\",\"type\":\"module\",\"creationDate\":\"January 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2013 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.1.0\",\"description\":\"MOD_TAGS_POPULAR_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_tags_popular\"}','{\"maximum\":\"5\",\"timeframe\":\"alltime\",\"owncache\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(317,0,'mod_tags_similar','module','mod_tags_similar','',0,1,1,0,'{\"name\":\"mod_tags_similar\",\"type\":\"module\",\"creationDate\":\"January 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2013 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.1.0\",\"description\":\"MOD_TAGS_SIMILAR_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_tags_similar\"}','{\"maximum\":\"5\",\"matchtype\":\"any\",\"owncache\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(318,0,'mod_sampledata','module','mod_sampledata','',1,1,1,0,'{\"name\":\"mod_sampledata\",\"type\":\"module\",\"creationDate\":\"July 2017\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2017 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.8.0\",\"description\":\"MOD_SAMPLEDATA_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_sampledata\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(319,0,'mod_latestactions','module','mod_latestactions','',1,1,1,0,'{\"name\":\"mod_latestactions\",\"type\":\"module\",\"creationDate\":\"May 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"MOD_LATESTACTIONS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_latestactions\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(320,0,'mod_privacy_dashboard','module','mod_privacy_dashboard','',1,1,1,0,'{\"name\":\"mod_privacy_dashboard\",\"type\":\"module\",\"creationDate\":\"June 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"MOD_PRIVACY_DASHBOARD_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"mod_privacy_dashboard\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(400,0,'plg_authentication_gmail','plugin','gmail','authentication',0,0,1,0,'{\"name\":\"plg_authentication_gmail\",\"type\":\"plugin\",\"creationDate\":\"February 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_GMAIL_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"gmail\"}','{\"applysuffix\":\"0\",\"suffix\":\"\",\"verifypeer\":\"1\",\"user_blacklist\":\"\"}','','',0,'0000-00-00 00:00:00',1,0),(401,0,'plg_authentication_joomla','plugin','joomla','authentication',0,1,1,1,'{\"name\":\"plg_authentication_joomla\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_AUTH_JOOMLA_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"joomla\"}','','','',0,'0000-00-00 00:00:00',0,0),(402,0,'plg_authentication_ldap','plugin','ldap','authentication',0,0,1,0,'{\"name\":\"plg_authentication_ldap\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_LDAP_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"ldap\"}','{\"host\":\"\",\"port\":\"389\",\"use_ldapV3\":\"0\",\"negotiate_tls\":\"0\",\"no_referrals\":\"0\",\"auth_method\":\"bind\",\"base_dn\":\"\",\"search_string\":\"\",\"users_dn\":\"\",\"username\":\"admin\",\"password\":\"bobby7\",\"ldap_fullname\":\"fullName\",\"ldap_email\":\"mail\",\"ldap_uid\":\"uid\"}','','',0,'0000-00-00 00:00:00',3,0),(403,0,'plg_content_contact','plugin','contact','content',0,1,1,0,'{\"name\":\"plg_content_contact\",\"type\":\"plugin\",\"creationDate\":\"January 2014\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2014 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.2.2\",\"description\":\"PLG_CONTENT_CONTACT_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"contact\"}','','','',0,'0000-00-00 00:00:00',1,0),(404,0,'plg_content_emailcloak','plugin','emailcloak','content',0,1,1,0,'{\"name\":\"plg_content_emailcloak\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_CONTENT_EMAILCLOAK_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"emailcloak\"}','{\"mode\":\"1\"}','','',0,'0000-00-00 00:00:00',1,0),(406,0,'plg_content_loadmodule','plugin','loadmodule','content',0,1,1,0,'{\"name\":\"plg_content_loadmodule\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_LOADMODULE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"loadmodule\"}','{\"style\":\"xhtml\"}','','',0,'2011-09-18 15:22:50',0,0),(407,0,'plg_content_pagebreak','plugin','pagebreak','content',0,1,1,0,'{\"name\":\"plg_content_pagebreak\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_CONTENT_PAGEBREAK_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"pagebreak\"}','{\"title\":\"1\",\"multipage_toc\":\"1\",\"showall\":\"1\"}','','',0,'0000-00-00 00:00:00',4,0),(408,0,'plg_content_pagenavigation','plugin','pagenavigation','content',0,1,1,0,'{\"name\":\"plg_content_pagenavigation\",\"type\":\"plugin\",\"creationDate\":\"January 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_PAGENAVIGATION_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"pagenavigation\"}','{\"position\":\"1\"}','','',0,'0000-00-00 00:00:00',5,0),(409,0,'plg_content_vote','plugin','vote','content',0,0,1,0,'{\"name\":\"plg_content_vote\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_VOTE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"vote\"}','','','',0,'0000-00-00 00:00:00',6,0),(410,0,'plg_editors_codemirror','plugin','codemirror','editors',0,1,1,1,'{\"name\":\"plg_editors_codemirror\",\"type\":\"plugin\",\"creationDate\":\"28 March 2011\",\"author\":\"Marijn Haverbeke\",\"copyright\":\"Copyright (C) 2014 - 2021 by Marijn Haverbeke <marijnh@gmail.com> and others\",\"authorEmail\":\"marijnh@gmail.com\",\"authorUrl\":\"https:\\/\\/codemirror.net\\/\",\"version\":\"5.60.0\",\"description\":\"PLG_CODEMIRROR_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"codemirror\"}','{\"lineNumbers\":\"1\",\"lineWrapping\":\"1\",\"matchTags\":\"1\",\"matchBrackets\":\"1\",\"marker-gutter\":\"1\",\"autoCloseTags\":\"1\",\"autoCloseBrackets\":\"1\",\"autoFocus\":\"1\",\"theme\":\"default\",\"tabmode\":\"indent\"}','','',0,'0000-00-00 00:00:00',1,0),(411,0,'plg_editors_none','plugin','none','editors',0,1,1,1,'{\"name\":\"plg_editors_none\",\"type\":\"plugin\",\"creationDate\":\"September 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_NONE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"none\"}','','','',0,'0000-00-00 00:00:00',2,0),(412,0,'plg_editors_tinymce','plugin','tinymce','editors',0,1,1,0,'{\"name\":\"plg_editors_tinymce\",\"type\":\"plugin\",\"creationDate\":\"2005-2020\",\"author\":\"Tiny Technologies, Inc\",\"copyright\":\"Tiny Technologies, Inc\",\"authorEmail\":\"N\\/A\",\"authorUrl\":\"https:\\/\\/www.tiny.cloud\",\"version\":\"4.5.12\",\"description\":\"PLG_TINY_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"tinymce\"}','{\"configuration\":{\"toolbars\":{\"2\":{\"toolbar1\":[\"bold\",\"underline\",\"strikethrough\",\"|\",\"undo\",\"redo\",\"|\",\"bullist\",\"numlist\",\"|\",\"pastetext\"]},\"1\":{\"menu\":[\"edit\",\"insert\",\"view\",\"format\",\"table\",\"tools\"],\"toolbar1\":[\"bold\",\"italic\",\"underline\",\"strikethrough\",\"|\",\"alignleft\",\"aligncenter\",\"alignright\",\"alignjustify\",\"|\",\"formatselect\",\"|\",\"bullist\",\"numlist\",\"|\",\"outdent\",\"indent\",\"|\",\"undo\",\"redo\",\"|\",\"link\",\"unlink\",\"anchor\",\"code\",\"|\",\"hr\",\"table\",\"|\",\"subscript\",\"superscript\",\"|\",\"charmap\",\"pastetext\",\"preview\"]},\"0\":{\"menu\":[\"edit\",\"insert\",\"view\",\"format\",\"table\",\"tools\"],\"toolbar1\":[\"bold\",\"italic\",\"underline\",\"strikethrough\",\"|\",\"alignleft\",\"aligncenter\",\"alignright\",\"alignjustify\",\"|\",\"styleselect\",\"|\",\"formatselect\",\"fontselect\",\"fontsizeselect\",\"|\",\"searchreplace\",\"|\",\"bullist\",\"numlist\",\"|\",\"outdent\",\"indent\",\"|\",\"undo\",\"redo\",\"|\",\"link\",\"unlink\",\"anchor\",\"image\",\"|\",\"code\",\"|\",\"forecolor\",\"backcolor\",\"|\",\"fullscreen\",\"|\",\"table\",\"|\",\"subscript\",\"superscript\",\"|\",\"charmap\",\"emoticons\",\"media\",\"hr\",\"ltr\",\"rtl\",\"|\",\"cut\",\"copy\",\"paste\",\"pastetext\",\"|\",\"visualchars\",\"visualblocks\",\"nonbreaking\",\"blockquote\",\"template\",\"|\",\"print\",\"preview\",\"codesample\",\"insertdatetime\",\"removeformat\"]}},\"setoptions\":{\"2\":{\"access\":[\"1\"],\"skin\":\"0\",\"skin_admin\":\"0\",\"mobile\":\"0\",\"drag_drop\":\"1\",\"path\":\"\",\"entity_encoding\":\"raw\",\"lang_mode\":\"1\",\"text_direction\":\"ltr\",\"content_css\":\"1\",\"content_css_custom\":\"\",\"relative_urls\":\"1\",\"newlines\":\"0\",\"use_config_textfilters\":\"0\",\"invalid_elements\":\"script,applet,iframe\",\"valid_elements\":\"\",\"extended_elements\":\"\",\"resizing\":\"1\",\"resize_horizontal\":\"1\",\"element_path\":\"1\",\"wordcount\":\"1\",\"image_advtab\":\"0\",\"advlist\":\"1\",\"autosave\":\"1\",\"contextmenu\":\"1\",\"custom_plugin\":\"\",\"custom_button\":\"\"},\"1\":{\"access\":[\"6\",\"2\"],\"skin\":\"0\",\"skin_admin\":\"0\",\"mobile\":\"0\",\"drag_drop\":\"1\",\"path\":\"\",\"entity_encoding\":\"raw\",\"lang_mode\":\"1\",\"text_direction\":\"ltr\",\"content_css\":\"1\",\"content_css_custom\":\"\",\"relative_urls\":\"1\",\"newlines\":\"0\",\"use_config_textfilters\":\"0\",\"invalid_elements\":\"script,applet,iframe\",\"valid_elements\":\"\",\"extended_elements\":\"\",\"resizing\":\"1\",\"resize_horizontal\":\"1\",\"element_path\":\"1\",\"wordcount\":\"1\",\"image_advtab\":\"0\",\"advlist\":\"1\",\"autosave\":\"1\",\"contextmenu\":\"1\",\"custom_plugin\":\"\",\"custom_button\":\"\"},\"0\":{\"access\":[\"7\",\"4\",\"8\"],\"skin\":\"0\",\"skin_admin\":\"0\",\"mobile\":\"0\",\"drag_drop\":\"1\",\"path\":\"\",\"entity_encoding\":\"raw\",\"lang_mode\":\"1\",\"text_direction\":\"ltr\",\"content_css\":\"1\",\"content_css_custom\":\"\",\"relative_urls\":\"1\",\"newlines\":\"0\",\"use_config_textfilters\":\"0\",\"invalid_elements\":\"script,applet,iframe\",\"valid_elements\":\"\",\"extended_elements\":\"\",\"resizing\":\"1\",\"resize_horizontal\":\"1\",\"element_path\":\"1\",\"wordcount\":\"1\",\"image_advtab\":\"1\",\"advlist\":\"1\",\"autosave\":\"1\",\"contextmenu\":\"1\",\"custom_plugin\":\"\",\"custom_button\":\"\"}}},\"sets_amount\":3,\"html_height\":\"550\",\"html_width\":\"750\"}','','',0,'0000-00-00 00:00:00',3,0),(413,0,'plg_editors-xtd_article','plugin','article','editors-xtd',0,1,1,0,'{\"name\":\"plg_editors-xtd_article\",\"type\":\"plugin\",\"creationDate\":\"October 2009\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2009 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_ARTICLE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"article\"}','','','',0,'0000-00-00 00:00:00',1,0),(414,0,'plg_editors-xtd_image','plugin','image','editors-xtd',0,1,1,0,'{\"name\":\"plg_editors-xtd_image\",\"type\":\"plugin\",\"creationDate\":\"August 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_IMAGE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"image\"}','','','',0,'0000-00-00 00:00:00',2,0),(415,0,'plg_editors-xtd_pagebreak','plugin','pagebreak','editors-xtd',0,1,1,0,'{\"name\":\"plg_editors-xtd_pagebreak\",\"type\":\"plugin\",\"creationDate\":\"August 2004\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_EDITORSXTD_PAGEBREAK_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"pagebreak\"}','','','',0,'0000-00-00 00:00:00',3,0),(416,0,'plg_editors-xtd_readmore','plugin','readmore','editors-xtd',0,1,1,0,'{\"name\":\"plg_editors-xtd_readmore\",\"type\":\"plugin\",\"creationDate\":\"March 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_READMORE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"readmore\"}','','','',0,'0000-00-00 00:00:00',4,0),(417,0,'plg_search_categories','plugin','categories','search',0,1,1,0,'{\"name\":\"plg_search_categories\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SEARCH_CATEGORIES_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"categories\"}','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(418,0,'plg_search_contacts','plugin','contacts','search',0,1,1,0,'{\"name\":\"plg_search_contacts\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SEARCH_CONTACTS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"contacts\"}','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(419,0,'plg_search_content','plugin','content','search',0,1,1,0,'{\"name\":\"plg_search_content\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SEARCH_CONTENT_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"content\"}','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(420,0,'plg_search_newsfeeds','plugin','newsfeeds','search',0,1,1,0,'{\"name\":\"plg_search_newsfeeds\",\"type\":\"plugin\",\"creationDate\":\"November 2005\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SEARCH_NEWSFEEDS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"newsfeeds\"}','{\"search_limit\":\"50\",\"search_content\":\"1\",\"search_archived\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(422,0,'plg_system_languagefilter','plugin','languagefilter','system',0,0,1,1,'{\"name\":\"plg_system_languagefilter\",\"type\":\"plugin\",\"creationDate\":\"July 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2010 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SYSTEM_LANGUAGEFILTER_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"languagefilter\"}','','','',0,'0000-00-00 00:00:00',1,0),(423,0,'plg_system_p3p','plugin','p3p','system',0,0,1,0,'{\"name\":\"plg_system_p3p\",\"type\":\"plugin\",\"creationDate\":\"September 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2010 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_P3P_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"p3p\"}','{\"headers\":\"NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM\"}','','',0,'0000-00-00 00:00:00',2,0),(424,0,'plg_system_cache','plugin','cache','system',0,0,1,1,'{\"name\":\"plg_system_cache\",\"type\":\"plugin\",\"creationDate\":\"February 2007\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2007 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_CACHE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"cache\"}','{\"browsercache\":\"0\",\"cachetime\":\"15\"}','','',0,'0000-00-00 00:00:00',9,0),(425,0,'plg_system_debug','plugin','debug','system',0,1,1,0,'{\"name\":\"plg_system_debug\",\"type\":\"plugin\",\"creationDate\":\"December 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_DEBUG_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"debug\"}','{\"profile\":\"1\",\"queries\":\"1\",\"memory\":\"1\",\"language_files\":\"1\",\"language_strings\":\"1\",\"strip-first\":\"1\",\"strip-prefix\":\"\",\"strip-suffix\":\"\"}','','',0,'0000-00-00 00:00:00',4,0),(426,0,'plg_system_log','plugin','log','system',0,1,1,1,'{\"name\":\"plg_system_log\",\"type\":\"plugin\",\"creationDate\":\"April 2007\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2007 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_LOG_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"log\"}','','','',0,'0000-00-00 00:00:00',5,0),(427,0,'plg_system_redirect','plugin','redirect','system',0,0,1,1,'{\"name\":\"plg_system_redirect\",\"type\":\"plugin\",\"creationDate\":\"April 2009\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2009 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SYSTEM_REDIRECT_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"redirect\"}','','','',0,'0000-00-00 00:00:00',3,0),(428,0,'plg_system_remember','plugin','remember','system',0,1,1,1,'{\"name\":\"plg_system_remember\",\"type\":\"plugin\",\"creationDate\":\"April 2007\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2007 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_REMEMBER_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"remember\"}','','','',0,'0000-00-00 00:00:00',7,0),(429,0,'plg_system_sef','plugin','sef','system',0,1,1,0,'{\"name\":\"plg_system_sef\",\"type\":\"plugin\",\"creationDate\":\"December 2007\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2007 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SEF_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"sef\"}','','','',0,'0000-00-00 00:00:00',8,0),(430,0,'plg_system_logout','plugin','logout','system',0,1,1,1,'{\"name\":\"plg_system_logout\",\"type\":\"plugin\",\"creationDate\":\"April 2009\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2009 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SYSTEM_LOGOUT_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"logout\"}','','','',0,'0000-00-00 00:00:00',6,0),(431,0,'plg_user_contactcreator','plugin','contactcreator','user',0,0,1,0,'{\"name\":\"plg_user_contactcreator\",\"type\":\"plugin\",\"creationDate\":\"August 2009\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2009 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_CONTACTCREATOR_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"contactcreator\"}','{\"autowebpage\":\"\",\"category\":\"34\",\"autopublish\":\"0\"}','','',0,'0000-00-00 00:00:00',1,0),(432,0,'plg_user_joomla','plugin','joomla','user',0,1,1,0,'{\"name\":\"plg_user_joomla\",\"type\":\"plugin\",\"creationDate\":\"December 2006\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_USER_JOOMLA_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"joomla\"}','{\"autoregister\":\"1\",\"mail_to_user\":\"1\",\"forceLogout\":\"1\"}','','',0,'0000-00-00 00:00:00',2,0),(433,0,'plg_user_profile','plugin','profile','user',0,0,1,0,'{\"name\":\"plg_user_profile\",\"type\":\"plugin\",\"creationDate\":\"January 2008\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2008 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_USER_PROFILE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"profile\"}','{\"register-require_address1\":\"1\",\"register-require_address2\":\"1\",\"register-require_city\":\"1\",\"register-require_region\":\"1\",\"register-require_country\":\"1\",\"register-require_postal_code\":\"1\",\"register-require_phone\":\"1\",\"register-require_website\":\"1\",\"register-require_favoritebook\":\"1\",\"register-require_aboutme\":\"1\",\"register-require_tos\":\"1\",\"register-require_dob\":\"1\",\"profile-require_address1\":\"1\",\"profile-require_address2\":\"1\",\"profile-require_city\":\"1\",\"profile-require_region\":\"1\",\"profile-require_country\":\"1\",\"profile-require_postal_code\":\"1\",\"profile-require_phone\":\"1\",\"profile-require_website\":\"1\",\"profile-require_favoritebook\":\"1\",\"profile-require_aboutme\":\"1\",\"profile-require_tos\":\"1\",\"profile-require_dob\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(434,0,'plg_extension_joomla','plugin','joomla','extension',0,1,1,1,'{\"name\":\"plg_extension_joomla\",\"type\":\"plugin\",\"creationDate\":\"May 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2010 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_EXTENSION_JOOMLA_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"joomla\"}','','','',0,'0000-00-00 00:00:00',1,0),(435,0,'plg_content_joomla','plugin','joomla','content',0,1,1,0,'{\"name\":\"plg_content_joomla\",\"type\":\"plugin\",\"creationDate\":\"November 2010\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2010 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_CONTENT_JOOMLA_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"joomla\"}','','','',0,'0000-00-00 00:00:00',0,0),(436,0,'plg_system_languagecode','plugin','languagecode','system',0,0,1,0,'{\"name\":\"plg_system_languagecode\",\"type\":\"plugin\",\"creationDate\":\"November 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2011 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SYSTEM_LANGUAGECODE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"languagecode\"}','','','',0,'0000-00-00 00:00:00',10,0),(437,0,'plg_quickicon_joomlaupdate','plugin','joomlaupdate','quickicon',0,1,1,1,'{\"name\":\"plg_quickicon_joomlaupdate\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2011 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_QUICKICON_JOOMLAUPDATE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"joomlaupdate\"}','','','',0,'0000-00-00 00:00:00',0,0),(438,0,'plg_quickicon_extensionupdate','plugin','extensionupdate','quickicon',0,1,1,1,'{\"name\":\"plg_quickicon_extensionupdate\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2011 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_QUICKICON_EXTENSIONUPDATE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"extensionupdate\"}','','','',0,'0000-00-00 00:00:00',0,0),(439,0,'plg_captcha_recaptcha','plugin','recaptcha','captcha',0,0,1,0,'{\"name\":\"plg_captcha_recaptcha\",\"type\":\"plugin\",\"creationDate\":\"December 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2011 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.4.0\",\"description\":\"PLG_CAPTCHA_RECAPTCHA_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"recaptcha\"}','{\"public_key\":\"\",\"private_key\":\"\",\"theme\":\"clean\"}','','',0,'0000-00-00 00:00:00',0,0),(440,0,'plg_system_highlight','plugin','highlight','system',0,1,1,0,'{\"name\":\"plg_system_highlight\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2011 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SYSTEM_HIGHLIGHT_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"highlight\"}','','','',0,'0000-00-00 00:00:00',7,0),(441,0,'plg_content_finder','plugin','finder','content',0,0,1,0,'{\"name\":\"plg_content_finder\",\"type\":\"plugin\",\"creationDate\":\"December 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2011 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_CONTENT_FINDER_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"finder\"}','','','',0,'0000-00-00 00:00:00',0,0),(442,0,'plg_finder_categories','plugin','categories','finder',0,1,1,0,'{\"name\":\"plg_finder_categories\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2011 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_FINDER_CATEGORIES_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"categories\"}','','','',0,'0000-00-00 00:00:00',1,0),(443,0,'plg_finder_contacts','plugin','contacts','finder',0,1,1,0,'{\"name\":\"plg_finder_contacts\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2011 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_FINDER_CONTACTS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"contacts\"}','','','',0,'0000-00-00 00:00:00',2,0),(444,0,'plg_finder_content','plugin','content','finder',0,1,1,0,'{\"name\":\"plg_finder_content\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2011 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_FINDER_CONTENT_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"content\"}','','','',0,'0000-00-00 00:00:00',3,0),(445,0,'plg_finder_newsfeeds','plugin','newsfeeds','finder',0,1,1,0,'{\"name\":\"plg_finder_newsfeeds\",\"type\":\"plugin\",\"creationDate\":\"August 2011\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2011 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_FINDER_NEWSFEEDS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"newsfeeds\"}','','','',0,'0000-00-00 00:00:00',4,0),(447,0,'plg_finder_tags','plugin','tags','finder',0,1,1,0,'{\"name\":\"plg_finder_tags\",\"type\":\"plugin\",\"creationDate\":\"February 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2013 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_FINDER_TAGS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"tags\"}','','','',0,'0000-00-00 00:00:00',0,0),(448,0,'plg_twofactorauth_totp','plugin','totp','twofactorauth',0,0,1,0,'{\"name\":\"plg_twofactorauth_totp\",\"type\":\"plugin\",\"creationDate\":\"August 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2013 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.2.0\",\"description\":\"PLG_TWOFACTORAUTH_TOTP_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"totp\"}','','','',0,'0000-00-00 00:00:00',0,0),(449,0,'plg_authentication_cookie','plugin','cookie','authentication',0,1,1,0,'{\"name\":\"plg_authentication_cookie\",\"type\":\"plugin\",\"creationDate\":\"July 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2013 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_AUTH_COOKIE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"cookie\"}','','','',0,'0000-00-00 00:00:00',0,0),(450,0,'plg_twofactorauth_yubikey','plugin','yubikey','twofactorauth',0,0,1,0,'{\"name\":\"plg_twofactorauth_yubikey\",\"type\":\"plugin\",\"creationDate\":\"September 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2013 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.2.0\",\"description\":\"PLG_TWOFACTORAUTH_YUBIKEY_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"yubikey\"}','','','',0,'0000-00-00 00:00:00',0,0),(451,0,'plg_search_tags','plugin','tags','search',0,1,1,0,'{\"name\":\"plg_search_tags\",\"type\":\"plugin\",\"creationDate\":\"March 2014\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2014 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.0.0\",\"description\":\"PLG_SEARCH_TAGS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"tags\"}','{\"search_limit\":\"50\",\"show_tagged_items\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(452,0,'plg_system_updatenotification','plugin','updatenotification','system',0,1,1,0,'{\"name\":\"plg_system_updatenotification\",\"type\":\"plugin\",\"creationDate\":\"May 2015\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2015 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.5.0\",\"description\":\"PLG_SYSTEM_UPDATENOTIFICATION_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"updatenotification\"}','{\"lastrun\":1734932067}','','',0,'0000-00-00 00:00:00',0,0),(453,0,'plg_editors-xtd_module','plugin','module','editors-xtd',0,1,1,0,'{\"name\":\"plg_editors-xtd_module\",\"type\":\"plugin\",\"creationDate\":\"October 2015\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2015 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.5.0\",\"description\":\"PLG_MODULE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"module\"}','','','',0,'0000-00-00 00:00:00',0,0),(454,0,'plg_system_stats','plugin','stats','system',0,1,1,0,'{\"name\":\"plg_system_stats\",\"type\":\"plugin\",\"creationDate\":\"November 2013\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2013 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.5.0\",\"description\":\"PLG_SYSTEM_STATS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"stats\"}','{\"mode\":1,\"lastrun\":1734932093,\"unique_id\":\"14dc9b953caf00f3685d9634033a606cbd7e4eed\",\"interval\":12}','','',0,'0000-00-00 00:00:00',0,0),(455,0,'plg_installer_packageinstaller','plugin','packageinstaller','installer',0,1,1,1,'{\"name\":\"plg_installer_packageinstaller\",\"type\":\"plugin\",\"creationDate\":\"May 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.6.0\",\"description\":\"PLG_INSTALLER_PACKAGEINSTALLER_PLUGIN_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"packageinstaller\"}','','','',0,'0000-00-00 00:00:00',1,0),(456,0,'PLG_INSTALLER_FOLDERINSTALLER','plugin','folderinstaller','installer',0,1,1,1,'{\"name\":\"PLG_INSTALLER_FOLDERINSTALLER\",\"type\":\"plugin\",\"creationDate\":\"May 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.6.0\",\"description\":\"PLG_INSTALLER_FOLDERINSTALLER_PLUGIN_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"folderinstaller\"}','','','',0,'0000-00-00 00:00:00',2,0),(457,0,'PLG_INSTALLER_URLINSTALLER','plugin','urlinstaller','installer',0,1,1,1,'{\"name\":\"PLG_INSTALLER_URLINSTALLER\",\"type\":\"plugin\",\"creationDate\":\"May 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.6.0\",\"description\":\"PLG_INSTALLER_URLINSTALLER_PLUGIN_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"urlinstaller\"}','','','',0,'0000-00-00 00:00:00',3,0),(458,0,'plg_quickicon_phpversioncheck','plugin','phpversioncheck','quickicon',0,1,1,1,'{\"name\":\"plg_quickicon_phpversioncheck\",\"type\":\"plugin\",\"creationDate\":\"August 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_QUICKICON_PHPVERSIONCHECK_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"phpversioncheck\"}','','','',0,'0000-00-00 00:00:00',0,0),(459,0,'plg_editors-xtd_menu','plugin','menu','editors-xtd',0,1,1,0,'{\"name\":\"plg_editors-xtd_menu\",\"type\":\"plugin\",\"creationDate\":\"August 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_EDITORS-XTD_MENU_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"menu\"}','','','',0,'0000-00-00 00:00:00',0,0),(460,0,'plg_editors-xtd_contact','plugin','contact','editors-xtd',0,1,1,0,'{\"name\":\"plg_editors-xtd_contact\",\"type\":\"plugin\",\"creationDate\":\"October 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_EDITORS-XTD_CONTACT_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"contact\"}','','','',0,'0000-00-00 00:00:00',0,0),(461,0,'plg_system_fields','plugin','fields','system',0,1,1,0,'{\"name\":\"plg_system_fields\",\"type\":\"plugin\",\"creationDate\":\"March 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_SYSTEM_FIELDS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"fields\"}','','','',0,'0000-00-00 00:00:00',0,0),(462,0,'plg_fields_calendar','plugin','calendar','fields',0,1,1,0,'{\"name\":\"plg_fields_calendar\",\"type\":\"plugin\",\"creationDate\":\"March 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_FIELDS_CALENDAR_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"calendar\"}','','','',0,'0000-00-00 00:00:00',0,0),(463,0,'plg_fields_checkboxes','plugin','checkboxes','fields',0,1,1,0,'{\"name\":\"plg_fields_checkboxes\",\"type\":\"plugin\",\"creationDate\":\"March 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_FIELDS_CHECKBOXES_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"checkboxes\"}','','','',0,'0000-00-00 00:00:00',0,0),(464,0,'plg_fields_color','plugin','color','fields',0,1,1,0,'{\"name\":\"plg_fields_color\",\"type\":\"plugin\",\"creationDate\":\"March 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_FIELDS_COLOR_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"color\"}','','','',0,'0000-00-00 00:00:00',0,0),(465,0,'plg_fields_editor','plugin','editor','fields',0,1,1,0,'{\"name\":\"plg_fields_editor\",\"type\":\"plugin\",\"creationDate\":\"March 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_FIELDS_EDITOR_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"editor\"}','','','',0,'0000-00-00 00:00:00',0,0),(466,0,'plg_fields_imagelist','plugin','imagelist','fields',0,1,1,0,'{\"name\":\"plg_fields_imagelist\",\"type\":\"plugin\",\"creationDate\":\"March 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_FIELDS_IMAGELIST_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"imagelist\"}','','','',0,'0000-00-00 00:00:00',0,0),(467,0,'plg_fields_integer','plugin','integer','fields',0,1,1,0,'{\"name\":\"plg_fields_integer\",\"type\":\"plugin\",\"creationDate\":\"March 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_FIELDS_INTEGER_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"integer\"}','{\"multiple\":\"0\",\"first\":\"1\",\"last\":\"100\",\"step\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(468,0,'plg_fields_list','plugin','list','fields',0,1,1,0,'{\"name\":\"plg_fields_list\",\"type\":\"plugin\",\"creationDate\":\"March 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_FIELDS_LIST_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"list\"}','','','',0,'0000-00-00 00:00:00',0,0),(469,0,'plg_fields_media','plugin','media','fields',0,1,1,0,'{\"name\":\"plg_fields_media\",\"type\":\"plugin\",\"creationDate\":\"March 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_FIELDS_MEDIA_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"media\"}','','','',0,'0000-00-00 00:00:00',0,0),(470,0,'plg_fields_radio','plugin','radio','fields',0,1,1,0,'{\"name\":\"plg_fields_radio\",\"type\":\"plugin\",\"creationDate\":\"March 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_FIELDS_RADIO_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"radio\"}','','','',0,'0000-00-00 00:00:00',0,0),(471,0,'plg_fields_sql','plugin','sql','fields',0,1,1,0,'{\"name\":\"plg_fields_sql\",\"type\":\"plugin\",\"creationDate\":\"March 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_FIELDS_SQL_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"sql\"}','','','',0,'0000-00-00 00:00:00',0,0),(472,0,'plg_fields_text','plugin','text','fields',0,1,1,0,'{\"name\":\"plg_fields_text\",\"type\":\"plugin\",\"creationDate\":\"March 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_FIELDS_TEXT_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"text\"}','','','',0,'0000-00-00 00:00:00',0,0),(473,0,'plg_fields_textarea','plugin','textarea','fields',0,1,1,0,'{\"name\":\"plg_fields_textarea\",\"type\":\"plugin\",\"creationDate\":\"March 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_FIELDS_TEXTAREA_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"textarea\"}','','','',0,'0000-00-00 00:00:00',0,0),(474,0,'plg_fields_url','plugin','url','fields',0,1,1,0,'{\"name\":\"plg_fields_url\",\"type\":\"plugin\",\"creationDate\":\"March 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_FIELDS_URL_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"url\"}','','','',0,'0000-00-00 00:00:00',0,0),(475,0,'plg_fields_user','plugin','user','fields',0,1,1,0,'{\"name\":\"plg_fields_user\",\"type\":\"plugin\",\"creationDate\":\"March 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_FIELDS_USER_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"user\"}','','','',0,'0000-00-00 00:00:00',0,0),(476,0,'plg_fields_usergrouplist','plugin','usergrouplist','fields',0,1,1,0,'{\"name\":\"plg_fields_usergrouplist\",\"type\":\"plugin\",\"creationDate\":\"March 2016\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2016 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_FIELDS_USERGROUPLIST_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"usergrouplist\"}','','','',0,'0000-00-00 00:00:00',0,0),(477,0,'plg_content_fields','plugin','fields','content',0,1,1,0,'{\"name\":\"plg_content_fields\",\"type\":\"plugin\",\"creationDate\":\"February 2017\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2017 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_CONTENT_FIELDS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"fields\"}','','','',0,'0000-00-00 00:00:00',0,0),(478,0,'plg_editors-xtd_fields','plugin','fields','editors-xtd',0,1,1,0,'{\"name\":\"plg_editors-xtd_fields\",\"type\":\"plugin\",\"creationDate\":\"February 2017\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2017 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.7.0\",\"description\":\"PLG_EDITORS-XTD_FIELDS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"fields\"}','','','',0,'0000-00-00 00:00:00',0,0),(479,0,'plg_sampledata_blog','plugin','blog','sampledata',0,1,1,0,'{\"name\":\"plg_sampledata_blog\",\"type\":\"plugin\",\"creationDate\":\"July 2017\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2017 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.8.0\",\"description\":\"PLG_SAMPLEDATA_BLOG_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"blog\"}','','','',0,'0000-00-00 00:00:00',0,0),(480,0,'plg_system_sessiongc','plugin','sessiongc','system',0,1,1,0,'{\"name\":\"plg_system_sessiongc\",\"type\":\"plugin\",\"creationDate\":\"February 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.8.6\",\"description\":\"PLG_SYSTEM_SESSIONGC_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"sessiongc\"}','','','',0,'0000-00-00 00:00:00',0,0),(481,0,'plg_fields_repeatable','plugin','repeatable','fields',0,1,1,0,'{\"name\":\"plg_fields_repeatable\",\"type\":\"plugin\",\"creationDate\":\"April 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"PLG_FIELDS_REPEATABLE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"repeatable\"}','','','',0,'0000-00-00 00:00:00',0,0),(482,0,'plg_content_confirmconsent','plugin','confirmconsent','content',0,0,1,0,'{\"name\":\"plg_content_confirmconsent\",\"type\":\"plugin\",\"creationDate\":\"May 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"PLG_CONTENT_CONFIRMCONSENT_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"confirmconsent\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(483,0,'PLG_SYSTEM_ACTIONLOGS','plugin','actionlogs','system',0,1,1,0,'{\"name\":\"PLG_SYSTEM_ACTIONLOGS\",\"type\":\"plugin\",\"creationDate\":\"May 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"PLG_SYSTEM_ACTIONLOGS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"actionlogs\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(484,0,'PLG_ACTIONLOG_JOOMLA','plugin','joomla','actionlog',0,1,1,0,'{\"name\":\"PLG_ACTIONLOG_JOOMLA\",\"type\":\"plugin\",\"creationDate\":\"May 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"PLG_ACTIONLOG_JOOMLA_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"joomla\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(485,0,'plg_system_privacyconsent','plugin','privacyconsent','system',0,0,1,0,'{\"name\":\"plg_system_privacyconsent\",\"type\":\"plugin\",\"creationDate\":\"April 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"PLG_SYSTEM_PRIVACYCONSENT_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"privacyconsent\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(486,0,'plg_system_logrotation','plugin','logrotation','system',0,1,1,0,'{\"name\":\"plg_system_logrotation\",\"type\":\"plugin\",\"creationDate\":\"May 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"PLG_SYSTEM_LOGROTATION_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"logrotation\"}','{\"lastrun\":1734325039}','','',0,'0000-00-00 00:00:00',0,0),(487,0,'plg_privacy_user','plugin','user','privacy',0,1,1,0,'{\"name\":\"plg_privacy_user\",\"type\":\"plugin\",\"creationDate\":\"May 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"PLG_PRIVACY_USER_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"user\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(488,0,'plg_quickicon_privacycheck','plugin','privacycheck','quickicon',0,1,1,0,'{\"name\":\"plg_quickicon_privacycheck\",\"type\":\"plugin\",\"creationDate\":\"June 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"PLG_QUICKICON_PRIVACYCHECK_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"privacycheck\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(489,0,'plg_user_terms','plugin','terms','user',0,0,1,0,'{\"name\":\"plg_user_terms\",\"type\":\"plugin\",\"creationDate\":\"June 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"PLG_USER_TERMS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"terms\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(490,0,'plg_privacy_contact','plugin','contact','privacy',0,1,1,0,'{\"name\":\"plg_privacy_contact\",\"type\":\"plugin\",\"creationDate\":\"July 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"PLG_PRIVACY_CONTACT_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"contact\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(491,0,'plg_privacy_content','plugin','content','privacy',0,1,1,0,'{\"name\":\"plg_privacy_content\",\"type\":\"plugin\",\"creationDate\":\"July 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"PLG_PRIVACY_CONTENT_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"content\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(492,0,'plg_privacy_message','plugin','message','privacy',0,1,1,0,'{\"name\":\"plg_privacy_message\",\"type\":\"plugin\",\"creationDate\":\"July 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"PLG_PRIVACY_MESSAGE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"message\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(493,0,'plg_privacy_actionlogs','plugin','actionlogs','privacy',0,1,1,0,'{\"name\":\"plg_privacy_actionlogs\",\"type\":\"plugin\",\"creationDate\":\"July 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"PLG_PRIVACY_ACTIONLOGS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"actionlogs\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(494,0,'plg_captcha_recaptcha_invisible','plugin','recaptcha_invisible','captcha',0,0,1,0,'{\"name\":\"plg_captcha_recaptcha_invisible\",\"type\":\"plugin\",\"creationDate\":\"November 2017\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2017 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.8\",\"description\":\"PLG_CAPTCHA_RECAPTCHA_INVISIBLE_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"recaptcha_invisible\"}','{\"public_key\":\"\",\"private_key\":\"\",\"theme\":\"clean\"}','','',0,'0000-00-00 00:00:00',0,0),(495,0,'plg_privacy_consents','plugin','consents','privacy',0,1,1,0,'{\"name\":\"plg_privacy_consents\",\"type\":\"plugin\",\"creationDate\":\"July 2018\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2018 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.9.0\",\"description\":\"PLG_PRIVACY_CONSENTS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"consents\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(503,0,'beez3','template','beez3','',0,1,1,0,'{\"name\":\"beez3\",\"type\":\"template\",\"creationDate\":\"25 November 2009\",\"author\":\"Angie Radtke\",\"copyright\":\"(C) 2010 Open Source Matters, Inc.\",\"authorEmail\":\"a.radtke@derauftritt.de\",\"authorUrl\":\"http:\\/\\/www.der-auftritt.de\",\"version\":\"3.1.0\",\"description\":\"TPL_BEEZ3_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"templateDetails\"}','{\"wrapperSmall\":\"53\",\"wrapperLarge\":\"72\",\"sitetitle\":\"\",\"sitedescription\":\"\",\"navposition\":\"center\",\"templatecolor\":\"nature\"}','','',0,'0000-00-00 00:00:00',0,0),(504,0,'hathor','template','hathor','',1,1,1,0,'{\"name\":\"hathor\",\"type\":\"template\",\"creationDate\":\"May 2010\",\"author\":\"Andrea Tarr\",\"copyright\":\"(C) 2010 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"\",\"version\":\"3.0.0\",\"description\":\"TPL_HATHOR_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"templateDetails\"}','{\"showSiteName\":\"0\",\"colourChoice\":\"0\",\"boldText\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(506,0,'protostar','template','protostar','',0,1,1,0,'{\"name\":\"protostar\",\"type\":\"template\",\"creationDate\":\"4\\/30\\/2012\",\"author\":\"Kyle Ledbetter\",\"copyright\":\"(C) 2012 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"\",\"version\":\"1.0\",\"description\":\"TPL_PROTOSTAR_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"templateDetails\"}','{\"templateColor\":\"\",\"logoFile\":\"\",\"googleFont\":\"1\",\"googleFontName\":\"Open+Sans\",\"fluidContainer\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(507,0,'isis','template','isis','',1,1,1,0,'{\"name\":\"isis\",\"type\":\"template\",\"creationDate\":\"3\\/30\\/2012\",\"author\":\"Kyle Ledbetter\",\"copyright\":\"(C) 2012 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"\",\"version\":\"1.0\",\"description\":\"TPL_ISIS_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"templateDetails\"}','{\"templateColor\":\"\",\"logoFile\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(600,802,'English (en-GB)','language','en-GB','',0,1,1,1,'{\"name\":\"English (en-GB)\",\"type\":\"language\",\"creationDate\":\"August 2022\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2006 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.10.11\",\"description\":\"en-GB site language\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(601,802,'English (en-GB)','language','en-GB','',1,1,1,1,'{\"name\":\"English (en-GB)\",\"type\":\"language\",\"creationDate\":\"August 2022\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2005 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.10.11\",\"description\":\"en-GB administrator language\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(700,0,'files_joomla','file','joomla','',0,1,1,1,'{\"name\":\"files_joomla\",\"type\":\"file\",\"creationDate\":\"August 2022\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2019 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.10.11\",\"description\":\"FILES_JOOMLA_XML_DESCRIPTION\",\"group\":\"\"}','','','',0,'0000-00-00 00:00:00',0,0),(802,0,'English (en-GB) Language Pack','package','pkg_en-GB','',0,1,1,1,'{\"name\":\"English (en-GB) Language Pack\",\"type\":\"package\",\"creationDate\":\"August 2022\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2019 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.10.11.1\",\"description\":\"en-GB language pack\",\"group\":\"\",\"filename\":\"pkg_en-GB\"}','','','',0,'0000-00-00 00:00:00',0,0),(10000,0,'com_jumi','component','com_jumi','',1,1,0,0,'{\"name\":\"com_jumi\",\"type\":\"component\",\"creationDate\":\"January 2011\",\"author\":\"Edvard Ananyan\",\"copyright\":\"Copyright (c) 2008 - 2015 Edvard Ananyan. All rights reserved.\",\"authorEmail\":\"info@2glux.com\",\"authorUrl\":\"http:\\/\\/2glux.com\\/\",\"version\":\"3.0.5\",\"description\":\"This component includes custom scripts (html, php, js, css, ...) into Joomla! pages.<br \\/>Collaboration between multiple Joomla! pages and other Jumi extensions is easy.<br \\/>For Jumi downloads and guides visit <a href=\\\"http:\\/\\/2glux.com\\/projects\\/jumi\\\" target=\\\"_blank\\\">http:\\/\\/2glux.com\\/projects\\/jumi<\\/a><br \\/>For Jumi demos, tips and tricks visit <a href=\\\"http:\\/\\/2glux.com\\/projects\\/jumi\\/tutorial\\\" target=\\\"_blank\\\">http:\\/\\/2glux.com\\/projects\\/jumi\\/tutorial<\\/a>\",\"group\":\"\",\"filename\":\"jumi\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(10001,0,'Jumi','module','mod_jumi','',0,1,0,0,'{\"name\":\"Jumi\",\"type\":\"module\",\"creationDate\":\"January 2011\",\"author\":\"Edvard Ananyan\",\"copyright\":\"Copyright (c) 2006 - 2010 Martin Hajek, 2011 - 2015 Edvard Ananyan. All rights reserved.\",\"authorEmail\":\"info@2glux.com\",\"authorUrl\":\"http:\\/\\/2glux.com\",\"version\":\"3.0.1\",\"description\":\"MOD_JUMI_DESC\",\"group\":\"\",\"filename\":\"mod_jumi\"}','{\"notepad\":\"\",\"@spacer\":\"\",\"code_written\":\"\",\"source_code_storage\":\"\",\"default_absolute_path\":\"\",\"moduleclass_sfx\":\"\",\"cache\":\"1\",\"cache_time\":\"900\"}','','',0,'0000-00-00 00:00:00',0,0),(10002,0,'System - Jumi','plugin','jumi','system',0,1,1,0,'{\"name\":\"System - Jumi\",\"type\":\"plugin\",\"creationDate\":\"January 2011\",\"author\":\"Edvard Ananyan\",\"copyright\":\"Copyright (c) 2006 - 2010 Martin Hajek, 2011 - 2015 Edvard Ananyan. All rights reserved.\",\"authorEmail\":\"info@2glux.com\",\"authorUrl\":\"http:\\/\\/2glux.com\",\"version\":\"3.0.4\",\"description\":\"JUMIPLUGINDESC\",\"group\":\"\",\"filename\":\"jumi\"}','{\"default_absolute_path\":\"\",\"hide_code\":\"0\",\"nested_replace\":\"0\"}','','',0,'0000-00-00 00:00:00',0,0),(10003,0,'System - Jumi Router','plugin','jumirouter','system',0,1,1,0,'{\"name\":\"System - Jumi Router\",\"type\":\"plugin\",\"creationDate\":\"January 2011\",\"author\":\"Edvard Ananyan\",\"copyright\":\"Copyright (C) 2008 - 2011 Edvard Ananyan. All rights reserved.\",\"authorEmail\":\"edo888@gmail.com\",\"authorUrl\":\"http:\\/\\/edo.webmaster.am\",\"version\":\"2.0.6\",\"description\":\"SEF routing plugin for Jumi, which will enable direct access to jumi application with it\'s alias.\",\"group\":\"\",\"filename\":\"jumirouter\"}','{}','','',0,'0000-00-00 00:00:00',100,0),(10004,0,'yoo_master2','template','yoo_master2','',0,1,1,0,'{\"name\":\"yoo_master2\",\"type\":\"template\",\"creationDate\":\"March 2014\",\"author\":\"YOOtheme\",\"copyright\":\"Copyright (C) YOOtheme GmbH\",\"authorEmail\":\"info@yootheme.com\",\"authorUrl\":\"http:\\/\\/www.yootheme.com\",\"version\":\"1.0.0\",\"description\":\"Master theme of the YOOtheme club. It is based on YOOtheme\'s Warp theme framework.\",\"group\":\"\",\"filename\":\"templateDetails\"}','{\"config\":\"\"}','','',0,'0000-00-00 00:00:00',0,0),(10005,0,'plg_quickicon_eos310','plugin','eos310','quickicon',0,1,1,0,'{\"name\":\"plg_quickicon_eos310\",\"type\":\"plugin\",\"creationDate\":\"June 2021\",\"author\":\"Joomla! Project\",\"copyright\":\"(C) 2021 Open Source Matters, Inc.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"3.10.0\",\"description\":\"PLG_QUICKICON_EOS310_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"eos310\"}','{\"last_snoozed_id\":4}','','',0,'0000-00-00 00:00:00',0,0),(10006,0,'plg_installer_webinstaller','plugin','webinstaller','installer',0,1,1,0,'{\"name\":\"plg_installer_webinstaller\",\"type\":\"plugin\",\"creationDate\":\"28 April 2017\",\"author\":\"Joomla! Project\",\"copyright\":\"Copyright (C) 2013 - 2019 Open Source Matters. All rights reserved.\",\"authorEmail\":\"admin@joomla.org\",\"authorUrl\":\"www.joomla.org\",\"version\":\"2.1.2\",\"description\":\"PLG_INSTALLER_WEBINSTALLER_XML_DESCRIPTION\",\"group\":\"\",\"filename\":\"webinstaller\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(10009,10014,'PLG_SYSTEM_REGULARLABS','plugin','regularlabs','system',0,1,1,0,'{\"name\":\"PLG_SYSTEM_REGULARLABS\",\"type\":\"plugin\",\"creationDate\":\"March 2023\",\"author\":\"Regular Labs (Peter van Westen)\",\"copyright\":\"Copyright \\u00a9 2023 Regular Labs - All Rights Reserved\",\"authorEmail\":\"info@regularlabs.com\",\"authorUrl\":\"https:\\/\\/regularlabs.com\",\"version\":\"23.3.22766\",\"description\":\"PLG_SYSTEM_REGULARLABS_DESC\",\"group\":\"\",\"filename\":\"regularlabs\"}','{\"combine_admin_menu\":\"0\",\"show_help_menu\":\"1\",\"max_list_count\":\"10000\"}','','',0,'0000-00-00 00:00:00',0,0),(10011,10015,'PLG_EDITORS-XTD_SOURCERER','plugin','sourcerer','editors-xtd',0,1,1,0,'{\"name\":\"PLG_EDITORS-XTD_SOURCERER\",\"type\":\"plugin\",\"creationDate\":\"March 2023\",\"author\":\"Regular Labs (Peter van Westen)\",\"copyright\":\"Copyright \\u00a9 2023 Regular Labs - All Rights Reserved\",\"authorEmail\":\"info@regularlabs.com\",\"authorUrl\":\"https:\\/\\/regularlabs.com\",\"version\":\"9.5.1\",\"description\":\"PLG_EDITORS-XTD_SOURCERER_DESC\",\"group\":\"\",\"filename\":\"sourcerer\"}','[]','','',0,'0000-00-00 00:00:00',0,0),(10012,10015,'PLG_SYSTEM_SOURCERER','plugin','sourcerer','system',0,1,1,0,'{\"name\":\"PLG_SYSTEM_SOURCERER\",\"type\":\"plugin\",\"creationDate\":\"March 2023\",\"author\":\"Regular Labs (Peter van Westen)\",\"copyright\":\"Copyright \\u00a9 2023 Regular Labs - All Rights Reserved\",\"authorEmail\":\"info@regularlabs.com\",\"authorUrl\":\"https:\\/\\/regularlabs.com\",\"version\":\"9.5.1\",\"description\":\"PLG_SYSTEM_SOURCERER_DESC\",\"group\":\"\",\"filename\":\"sourcerer\"}','{\"enable_css\":\"1\",\"enable_js\":\"1\",\"enable_php\":\"1\",\"forbidden_php\":\"dl, escapeshellarg, escapeshellcmd, exec, passthru, popen, proc_close, proc_open, shell_exec, symlink, system\",\"forbidden_tags\":\"\",\"@wizard\":\"0\",\"button_text\":\"Code\",\"enable_frontend\":\"1\",\"syntax_word\":\"source\",\"tag_characters\":\"{.}\",\"trim\":\"0\",\"enable_in_head\":\"0\",\"remove_from_search\":\"0\",\"include_path\":\"\\/\",\"tmp_path\":\"\",\"place_comments\":\"1\"}','','',0,'0000-00-00 00:00:00',0,0),(10014,0,'PKG_REGULARLABS','package','pkg_regularlabs','',0,1,1,0,'{\"name\":\"PKG_REGULARLABS\",\"type\":\"package\",\"creationDate\":\"March 2023\",\"author\":\"Regular Labs (Peter van Westen)\",\"copyright\":\"Copyright \\u00a9 2023 Regular Labs - All Rights Reserved\",\"authorEmail\":\"info@regularlabs.com\",\"authorUrl\":\"https:\\/\\/regularlabs.com\",\"version\":\"23.3.22766\",\"description\":\"\",\"group\":\"\",\"filename\":\"pkg_regularlabs\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(10015,0,'PKG_SOURCERER','package','pkg_sourcerer','',0,1,1,0,'{\"name\":\"PKG_SOURCERER\",\"type\":\"package\",\"creationDate\":\"March 2023\",\"author\":\"Regular Labs (Peter van Westen)\",\"copyright\":\"Copyright \\u00a9 2023 Regular Labs - All Rights Reserved\",\"authorEmail\":\"info@regularlabs.com\",\"authorUrl\":\"https:\\/\\/regularlabs.com\",\"version\":\"9.5.1\",\"description\":\"\",\"group\":\"\",\"filename\":\"pkg_sourcerer\"}','{}','','',0,'0000-00-00 00:00:00',0,0),(10016,10014,'Regular Labs Library','library','regularlabs','',0,1,1,0,'{\"name\":\"Regular Labs Library\",\"type\":\"library\",\"creationDate\":\"March 2023\",\"author\":\"Regular Labs (Peter van Westen)\",\"copyright\":\"Copyright \\u00a9 2023 Regular Labs - All Rights Reserved\",\"authorEmail\":\"info@regularlabs.com\",\"authorUrl\":\"https:\\/\\/regularlabs.com\",\"version\":\"23.3.22766\",\"description\":\"Regular Labs Library - used by Regular Labs extensions\",\"group\":\"\",\"filename\":\"regularlabs\"}','{}','','',0,'0000-00-00 00:00:00',0,0);
/*!40000 ALTER TABLE `joomla_extensions` ENABLE KEYS */;

--
-- Table structure for table `joomla_fields`
--

DROP TABLE IF EXISTS `joomla_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_fields` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int unsigned NOT NULL DEFAULT '0',
  `context` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `group_id` int unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `default_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int NOT NULL DEFAULT '0',
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `fieldparams` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user_id` int unsigned NOT NULL DEFAULT '0',
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int unsigned NOT NULL DEFAULT '0',
  `access` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_created_user_id` (`created_user_id`),
  KEY `idx_access` (`access`),
  KEY `idx_context` (`context`(191)),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_fields`
--

/*!40000 ALTER TABLE `joomla_fields` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_fields` ENABLE KEYS */;

--
-- Table structure for table `joomla_fields_categories`
--

DROP TABLE IF EXISTS `joomla_fields_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_fields_categories` (
  `field_id` int NOT NULL DEFAULT '0',
  `category_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`field_id`,`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_fields_categories`
--

/*!40000 ALTER TABLE `joomla_fields_categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_fields_categories` ENABLE KEYS */;

--
-- Table structure for table `joomla_fields_groups`
--

DROP TABLE IF EXISTS `joomla_fields_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_fields_groups` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int unsigned NOT NULL DEFAULT '0',
  `context` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int NOT NULL DEFAULT '0',
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int unsigned NOT NULL DEFAULT '0',
  `access` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_created_by` (`created_by`),
  KEY `idx_access` (`access`),
  KEY `idx_context` (`context`(191)),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_fields_groups`
--

/*!40000 ALTER TABLE `joomla_fields_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_fields_groups` ENABLE KEYS */;

--
-- Table structure for table `joomla_fields_values`
--

DROP TABLE IF EXISTS `joomla_fields_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_fields_values` (
  `field_id` int unsigned NOT NULL,
  `item_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Allow references to items which have strings as ids, eg. none db systems.',
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  KEY `idx_field_id` (`field_id`),
  KEY `idx_item_id` (`item_id`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_fields_values`
--

/*!40000 ALTER TABLE `joomla_fields_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_fields_values` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_filters`
--

DROP TABLE IF EXISTS `joomla_finder_filters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_filters` (
  `filter_id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int unsigned NOT NULL,
  `created_by_alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int unsigned NOT NULL DEFAULT '0',
  `checked_out` int unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `map_count` int unsigned NOT NULL DEFAULT '0',
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `params` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`filter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_filters`
--

/*!40000 ALTER TABLE `joomla_finder_filters` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_filters` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_links`
--

DROP TABLE IF EXISTS `joomla_finder_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_links` (
  `link_id` int unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `route` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `indexdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `md5sum` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `state` int DEFAULT '1',
  `access` int DEFAULT '0',
  `language` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `publish_start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `list_price` double unsigned NOT NULL DEFAULT '0',
  `sale_price` double unsigned NOT NULL DEFAULT '0',
  `type_id` int NOT NULL,
  `object` mediumblob NOT NULL,
  PRIMARY KEY (`link_id`),
  KEY `idx_type` (`type_id`),
  KEY `idx_title` (`title`(100)),
  KEY `idx_md5` (`md5sum`),
  KEY `idx_url` (`url`(75)),
  KEY `idx_published_list` (`published`,`state`,`access`,`publish_start_date`,`publish_end_date`,`list_price`),
  KEY `idx_published_sale` (`published`,`state`,`access`,`publish_start_date`,`publish_end_date`,`sale_price`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_links`
--

/*!40000 ALTER TABLE `joomla_finder_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_links` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_links_terms0`
--

DROP TABLE IF EXISTS `joomla_finder_links_terms0`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_links_terms0` (
  `link_id` int unsigned NOT NULL,
  `term_id` int unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_links_terms0`
--

/*!40000 ALTER TABLE `joomla_finder_links_terms0` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_links_terms0` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_links_terms1`
--

DROP TABLE IF EXISTS `joomla_finder_links_terms1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_links_terms1` (
  `link_id` int unsigned NOT NULL,
  `term_id` int unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_links_terms1`
--

/*!40000 ALTER TABLE `joomla_finder_links_terms1` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_links_terms1` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_links_terms2`
--

DROP TABLE IF EXISTS `joomla_finder_links_terms2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_links_terms2` (
  `link_id` int unsigned NOT NULL,
  `term_id` int unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_links_terms2`
--

/*!40000 ALTER TABLE `joomla_finder_links_terms2` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_links_terms2` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_links_terms3`
--

DROP TABLE IF EXISTS `joomla_finder_links_terms3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_links_terms3` (
  `link_id` int unsigned NOT NULL,
  `term_id` int unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_links_terms3`
--

/*!40000 ALTER TABLE `joomla_finder_links_terms3` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_links_terms3` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_links_terms4`
--

DROP TABLE IF EXISTS `joomla_finder_links_terms4`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_links_terms4` (
  `link_id` int unsigned NOT NULL,
  `term_id` int unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_links_terms4`
--

/*!40000 ALTER TABLE `joomla_finder_links_terms4` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_links_terms4` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_links_terms5`
--

DROP TABLE IF EXISTS `joomla_finder_links_terms5`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_links_terms5` (
  `link_id` int unsigned NOT NULL,
  `term_id` int unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_links_terms5`
--

/*!40000 ALTER TABLE `joomla_finder_links_terms5` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_links_terms5` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_links_terms6`
--

DROP TABLE IF EXISTS `joomla_finder_links_terms6`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_links_terms6` (
  `link_id` int unsigned NOT NULL,
  `term_id` int unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_links_terms6`
--

/*!40000 ALTER TABLE `joomla_finder_links_terms6` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_links_terms6` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_links_terms7`
--

DROP TABLE IF EXISTS `joomla_finder_links_terms7`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_links_terms7` (
  `link_id` int unsigned NOT NULL,
  `term_id` int unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_links_terms7`
--

/*!40000 ALTER TABLE `joomla_finder_links_terms7` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_links_terms7` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_links_terms8`
--

DROP TABLE IF EXISTS `joomla_finder_links_terms8`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_links_terms8` (
  `link_id` int unsigned NOT NULL,
  `term_id` int unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_links_terms8`
--

/*!40000 ALTER TABLE `joomla_finder_links_terms8` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_links_terms8` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_links_terms9`
--

DROP TABLE IF EXISTS `joomla_finder_links_terms9`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_links_terms9` (
  `link_id` int unsigned NOT NULL,
  `term_id` int unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_links_terms9`
--

/*!40000 ALTER TABLE `joomla_finder_links_terms9` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_links_terms9` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_links_termsa`
--

DROP TABLE IF EXISTS `joomla_finder_links_termsa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_links_termsa` (
  `link_id` int unsigned NOT NULL,
  `term_id` int unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_links_termsa`
--

/*!40000 ALTER TABLE `joomla_finder_links_termsa` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_links_termsa` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_links_termsb`
--

DROP TABLE IF EXISTS `joomla_finder_links_termsb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_links_termsb` (
  `link_id` int unsigned NOT NULL,
  `term_id` int unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_links_termsb`
--

/*!40000 ALTER TABLE `joomla_finder_links_termsb` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_links_termsb` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_links_termsc`
--

DROP TABLE IF EXISTS `joomla_finder_links_termsc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_links_termsc` (
  `link_id` int unsigned NOT NULL,
  `term_id` int unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_links_termsc`
--

/*!40000 ALTER TABLE `joomla_finder_links_termsc` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_links_termsc` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_links_termsd`
--

DROP TABLE IF EXISTS `joomla_finder_links_termsd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_links_termsd` (
  `link_id` int unsigned NOT NULL,
  `term_id` int unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_links_termsd`
--

/*!40000 ALTER TABLE `joomla_finder_links_termsd` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_links_termsd` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_links_termse`
--

DROP TABLE IF EXISTS `joomla_finder_links_termse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_links_termse` (
  `link_id` int unsigned NOT NULL,
  `term_id` int unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_links_termse`
--

/*!40000 ALTER TABLE `joomla_finder_links_termse` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_links_termse` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_links_termsf`
--

DROP TABLE IF EXISTS `joomla_finder_links_termsf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_links_termsf` (
  `link_id` int unsigned NOT NULL,
  `term_id` int unsigned NOT NULL,
  `weight` float unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`term_id`),
  KEY `idx_term_weight` (`term_id`,`weight`),
  KEY `idx_link_term_weight` (`link_id`,`term_id`,`weight`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_links_termsf`
--

/*!40000 ALTER TABLE `joomla_finder_links_termsf` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_links_termsf` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_taxonomy`
--

DROP TABLE IF EXISTS `joomla_finder_taxonomy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_taxonomy` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int unsigned NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `state` tinyint unsigned NOT NULL DEFAULT '1',
  `access` tinyint unsigned NOT NULL DEFAULT '0',
  `ordering` tinyint unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `state` (`state`),
  KEY `ordering` (`ordering`),
  KEY `access` (`access`),
  KEY `idx_parent_published` (`parent_id`,`state`,`access`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_taxonomy`
--

/*!40000 ALTER TABLE `joomla_finder_taxonomy` DISABLE KEYS */;
INSERT INTO `joomla_finder_taxonomy` VALUES (1,0,'ROOT',0,0,0);
/*!40000 ALTER TABLE `joomla_finder_taxonomy` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_taxonomy_map`
--

DROP TABLE IF EXISTS `joomla_finder_taxonomy_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_taxonomy_map` (
  `link_id` int unsigned NOT NULL,
  `node_id` int unsigned NOT NULL,
  PRIMARY KEY (`link_id`,`node_id`),
  KEY `link_id` (`link_id`),
  KEY `node_id` (`node_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_taxonomy_map`
--

/*!40000 ALTER TABLE `joomla_finder_taxonomy_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_taxonomy_map` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_terms`
--

DROP TABLE IF EXISTS `joomla_finder_terms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_terms` (
  `term_id` int unsigned NOT NULL AUTO_INCREMENT,
  `term` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stem` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `common` tinyint unsigned NOT NULL DEFAULT '0',
  `phrase` tinyint unsigned NOT NULL DEFAULT '0',
  `weight` float unsigned NOT NULL DEFAULT '0',
  `soundex` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `links` int NOT NULL DEFAULT '0',
  `language` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`term_id`),
  UNIQUE KEY `idx_term` (`term`),
  KEY `idx_term_phrase` (`term`,`phrase`),
  KEY `idx_stem_phrase` (`stem`,`phrase`),
  KEY `idx_soundex_phrase` (`soundex`,`phrase`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_terms`
--

/*!40000 ALTER TABLE `joomla_finder_terms` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_terms` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_terms_common`
--

DROP TABLE IF EXISTS `joomla_finder_terms_common`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_terms_common` (
  `term` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `language` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  KEY `idx_word_lang` (`term`,`language`),
  KEY `idx_lang` (`language`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_terms_common`
--

/*!40000 ALTER TABLE `joomla_finder_terms_common` DISABLE KEYS */;
INSERT INTO `joomla_finder_terms_common` VALUES ('a','en'),('about','en'),('after','en'),('ago','en'),('all','en'),('am','en'),('an','en'),('and','en'),('any','en'),('are','en'),('aren\'t','en'),('as','en'),('at','en'),('be','en'),('but','en'),('by','en'),('for','en'),('from','en'),('get','en'),('go','en'),('how','en'),('if','en'),('in','en'),('into','en'),('is','en'),('isn\'t','en'),('it','en'),('its','en'),('me','en'),('more','en'),('most','en'),('must','en'),('my','en'),('new','en'),('no','en'),('none','en'),('not','en'),('nothing','en'),('of','en'),('off','en'),('often','en'),('old','en'),('on','en'),('onc','en'),('once','en'),('only','en'),('or','en'),('other','en'),('our','en'),('ours','en'),('out','en'),('over','en'),('page','en'),('she','en'),('should','en'),('small','en'),('so','en'),('some','en'),('than','en'),('thank','en'),('that','en'),('the','en'),('their','en'),('theirs','en'),('them','en'),('then','en'),('there','en'),('these','en'),('they','en'),('this','en'),('those','en'),('thus','en'),('time','en'),('times','en'),('to','en'),('too','en'),('true','en'),('under','en'),('until','en'),('up','en'),('upon','en'),('use','en'),('user','en'),('users','en'),('version','en'),('very','en'),('via','en'),('want','en'),('was','en'),('way','en'),('were','en'),('what','en'),('when','en'),('where','en'),('which','en'),('who','en'),('whom','en'),('whose','en'),('why','en'),('wide','en'),('will','en'),('with','en'),('within','en'),('without','en'),('would','en'),('yes','en'),('yet','en'),('you','en'),('your','en'),('yours','en');
/*!40000 ALTER TABLE `joomla_finder_terms_common` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_tokens`
--

DROP TABLE IF EXISTS `joomla_finder_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_tokens` (
  `term` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stem` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `common` tinyint unsigned NOT NULL DEFAULT '0',
  `phrase` tinyint unsigned NOT NULL DEFAULT '0',
  `weight` float unsigned NOT NULL DEFAULT '1',
  `context` tinyint unsigned NOT NULL DEFAULT '2',
  `language` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  KEY `idx_word` (`term`),
  KEY `idx_context` (`context`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_tokens`
--

/*!40000 ALTER TABLE `joomla_finder_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_tokens` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_tokens_aggregate`
--

DROP TABLE IF EXISTS `joomla_finder_tokens_aggregate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_tokens_aggregate` (
  `term_id` int unsigned NOT NULL,
  `map_suffix` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `term` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stem` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `common` tinyint unsigned NOT NULL DEFAULT '0',
  `phrase` tinyint unsigned NOT NULL DEFAULT '0',
  `term_weight` float unsigned NOT NULL,
  `context` tinyint unsigned NOT NULL DEFAULT '2',
  `context_weight` float unsigned NOT NULL,
  `total_weight` float unsigned NOT NULL,
  `language` char(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  KEY `token` (`term`),
  KEY `keyword_id` (`term_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_tokens_aggregate`
--

/*!40000 ALTER TABLE `joomla_finder_tokens_aggregate` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_tokens_aggregate` ENABLE KEYS */;

--
-- Table structure for table `joomla_finder_types`
--

DROP TABLE IF EXISTS `joomla_finder_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_finder_types` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `mime` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_finder_types`
--

/*!40000 ALTER TABLE `joomla_finder_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_finder_types` ENABLE KEYS */;

--
-- Table structure for table `joomla_jumi`
--

DROP TABLE IF EXISTS `joomla_jumi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_jumi` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `custom_script` text,
  `access` int unsigned NOT NULL DEFAULT '0',
  `checked_out` int NOT NULL DEFAULT '0',
  `published` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=148 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_jumi`
--

/*!40000 ALTER TABLE `joomla_jumi` DISABLE KEYS */;
INSERT INTO `joomla_jumi` VALUES (1,'Account Summary','','','<?php require_once \'bpl/jumi/account_summary.php\';',0,0,1),(5,'Add Tokens','','','<?php require_once \'bpl/jumi/add_tokens.php\';\r\n',0,0,1),(6,'Admin Account Update','','','<?php require_once \'bpl/jumi/admin_account_update.php\';\r\n',0,0,1),(7,'Admin Code Inventory','','','<?php require_once \'bpl/jumi/admin_code_inventory.php\';\r\n',0,0,1),(8,'Block','','','<?php require_once \'bpl/jumi/block.php\';\r\n',0,0,1),(9,'Buy Items','','','<?php require_once \'bpl/jumi/buy_items.php\';\r\n',0,0,1),(10,'Buy Package','','','<?php require_once \'bpl/jumi/buy_package.php\';\r\n',0,0,1),(11,'Commission Deduct','','','<?php require_once \'bpl/jumi/commission_deduct.php\';\r\n',0,0,1),(12,'Converter','','','<?php require_once \'bpl/jumi/converter.php\';\r\n',0,0,1),(13,'Direct Referrals','','','<?php require_once \'bpl/jumi/direct_referrals.php\';\r\n',0,0,1),(14,'Downlines','','','<?php require_once \'bpl/jumi/downlines.php\';\r\n',0,0,1),(15,'Efund Deposit','','','<?php require_once \'bpl/jumi/efund_deposit.php\';\r\n',0,0,1),(16,'Efund Transfer','','','<?php require_once \'bpl/jumi/efund_transfer.php\';\r\n',0,0,1),(17,'Fixed Daily','','','<?php require_once \'bpl/jumi/fixed_daily.php\';\r\n',0,0,1),(18,'Fixed Daily Deposit','','','<?php require_once \'bpl/jumi/fixed_daily_deposit.php\';\r\n',0,0,1),(19,'Fast Track','','','<?php require_once \'bpl/jumi/fast_track.php\';\r\n',0,0,1),(20,'Fast Track Deposit','','','<?php require_once \'bpl/jumi/fast_track_deposit.php\';\r\n',0,0,1),(21,'Genealogy Binary','','','<?php require_once \'bpl/jumi/genealogy_binary.php\';\r\n',0,0,1),(22,'Genealogy Harvest Associate','','','<?php require_once \'bpl/jumi/genealogy_harvest_associate.php\';\r\n',0,0,1),(23,'Genealogy Harvest Basic','','','<?php require_once \'bpl/jumi/genealogy_harvest_basic.php\';\r\n',0,0,1),(2,'Active Income','','','<?php require_once \'bpl/jumi/active_income.php\';\r\n',0,0,1),(3,'Activity','','','<?php require_once \'bpl/jumi/activity.php\';\r\n',0,0,1),(4,'Add Efunds','','','<?php require_once \'bpl/jumi/add_efunds.php\';\r\n',0,0,1),(24,'Genealogy Indirect','','','<?php require_once \'bpl/jumi/genealogy_indirect.php\';\r\n',0,0,1),(25,'Genealogy Leadership','','','<?php require_once \'bpl/jumi/genealogy_leadership.php\';\r\n',0,0,1),(26,'Genealogy Leadership Passive','','','<?php require_once \'bpl/jumi/genealogy_leadership_passive.php\';\r\n',0,0,1),(27,'Genealogy Matrix Table Associate','','','<?php require_once \'bpl/jumi/genealogy_matrix_table_associate.php\';\r\n',0,0,1),(28,'Genealogy Matrix Table Basic','','','<?php require_once \'bpl/jumi/genealogy_matrix_table_basic.php\';\r\n',0,0,1),(29,'Genealogy Matrix Table Chairman','','','<?php require_once \'bpl/jumi/genealogy_matrix_table_chairman.php\';\r\n',0,0,1),(30,'Genealogy Matrix Table Director','','','<?php require_once \'bpl/jumi/genealogy_matrix_table_director.php\';\r\n',0,0,1),(31,'Genealogy Matrix Table Executive','','','<?php require_once \'bpl/jumi/genealogy_matrix_table_executive.php\';\r\n',0,0,1),(32,'Genealogy Matrix Table Regular','','','<?php require_once \'bpl/jumi/genealogy_matrix_table_regular.php\';\r\n',0,0,1),(33,'Genealogy Unilevel','','','<?php require_once \'bpl/jumi/genealogy_unilevel.php\';\r\n',0,0,1),(34,'Generate Codes','','','<?php require_once \'bpl/jumi/generate_codes.php\';\r\n',0,0,1),(35,'Income Log','','','<?php require_once \'bpl/jumi/income_log.php\';\r\n',0,0,1),(36,'Indirect Bonus','','','<?php require_once \'bpl/jumi/indirect_bonus.php\';\r\n',0,0,1),(37,'Leadership Bonus','','','<?php require_once \'bpl/jumi/leadership_bonus.php\';\r\n',0,0,1),(38,'Leadership Bonus Passive','','','<?php require_once \'bpl/jumi/leadership_bonus_passive.php\';\r\n',0,0,1),(39,'Leadership Bonus Passive Deposit','','','<?php require_once \'bpl/jumi/leadership_bonus_passive_deposit.php\';\r\n',0,0,1),(40,'List Members','','','<?php require_once \'bpl/jumi/list_members.php\';\r\n',0,0,1),(41,'Logout','','','<?php require_once \'bpl/jumi/logout.php\';\r\n',0,0,1),(42,'Lookup Code','','','<?php require_once \'bpl/jumi/lookup_code.php\';\r\n',0,0,1),(43,'Member','','','<?php require_once \'bpl/jumi/member.php\';\r\n',0,0,1),(44,'Member Info','','','<?php require_once \'bpl/jumi/member_info.php\';\r\n',0,0,1),(45,'Merchant','','','<?php require_once \'bpl/jumi/merchant.php\';\r\n',0,0,1),(46,'Merchant Package Buy','','','<?php require_once \'bpl/jumi/merchant_package_buy.php\';\r\n',0,0,1),(47,'Overall Purchase History','','','<?php require_once \'bpl/jumi/overall_purchase_history.php\';\r\n',0,0,1),(48,'Overall Reward Redemption History','','','<?php require_once \'bpl/jumi/overall_reward_redemption_history.php\';\r\n',0,0,1),(49,'Payout Log','','','<?php require_once \'bpl/jumi/payout_log.php\';\r\n',0,0,1),(50,'Point Rewards Items','','','<?php require_once \'bpl/jumi/point_rewards_items.php\';\r\n',0,0,1),(51,'Point Rewards Items Add','','','<?php require_once \'bpl/jumi/point_rewards_items_add.php\';\r\n',0,0,1),(52,'Point Rewards Items Edit','','','<?php require_once \'bpl/jumi/point_rewards_items_edit.php\';\r\n',0,0,1),(53,'Point Reward Redemption List','','','<?php require_once \'bpl/jumi/point_reward_redemption_list.php\';\r\n',0,0,1),(54,'P2P Sell Token','','','<?php require_once \'bpl/jumi/p2p_sell_token.php\';\r\n',0,0,1),(55,'P2P Buy Token','','','<?php require_once \'bpl/jumi/p2p_buy_token.php\';\r\n',0,0,1),(56,'P2P Trade History','','','<?php require_once \'bpl/jumi/p2p_trade_history.php\';\r\n',0,0,1),(57,'Convert Gold','','','<?php require_once \'bpl/jumi/convert_efund.php\';\r\n',0,0,1),(58,'Convert Gold Pending','','','<?php require_once \'bpl/jumi/convert_efund_pending.php\';\r\n',0,0,1),(59,'Convert Gold Confirmed','','','<?php require_once \'bpl/jumi/convert_efund_confirmed.php\';\r\n',0,0,1),(60,'Profile Update','','','<?php require_once \'bpl/jumi/profile_update.php\';\r\n',0,0,1),(61,'Profit Share Deposit','','','<?php require_once \'bpl/jumi/profit_share_deposit.php\';\r\n',0,0,1),(62,'Purchase Items Confirm','','','<?php require_once \'bpl/jumi/purchase_items_confirm.php\';\r\n',0,0,1),(63,'Purchase Items Invoice','','','<?php require_once \'bpl/jumi/purchase_items_invoice.php\';\r\n',0,0,1),(64,'Redeem Point Rewards','','','<?php require_once \'bpl/jumi/redeem_point_rewards.php\';\r\n',0,0,1),(65,'Registration','','','<?php require_once \'bpl/jumi/registration.php\';\r\n',0,0,1),(66,'Registration Codes','','','<?php require_once \'bpl/jumi/registration_codes.php\';\r\n',0,0,1),(67,'Registration Codes Inventory','','','<?php require_once \'bpl/jumi/registration_codes_inventory.php\';\r\n',0,0,1),(68,'Registration Codes Used','','','<?php require_once \'bpl/jumi/registration_codes_used.php\';\r\n',0,0,1),(69,'Repeat Purchase Items','','','<?php require_once \'bpl/jumi/repeat_purchase_items.php\';\r\n',0,0,1),(70,'Repeat Purchase Items Add','','','<?php require_once \'bpl/jumi/repeat_purchase_items_add.php\';\r\n',0,0,1),(71,'Repeat Purchase Items Edit','','','<?php require_once \'bpl/jumi/repeat_purchase_items_edit.php\';\r\n',0,0,1),(72,'Repeat Purchase Items List','','','<?php require_once \'bpl/jumi/repeat_purchase_items_list.php\';\r\n',0,0,1),(73,'Request Efund','','','<?php require_once \'bpl/jumi/request_efund.php\';\r\n',0,0,1),(74,'Request Efund Confirmed','','','<?php require_once \'bpl/jumi/request_efund_confirmed.php\';\r\n',0,0,1),(75,'Request Efund Log','','','<?php require_once \'bpl/jumi/request_efund_log.php\';\r\n',0,0,1),(76,'Request Efund Pending','','','<?php require_once \'bpl/jumi/request_efund_pending.php\';\r\n',0,0,1),(77,'Reset','','','<?php require_once \'bpl/jumi/reset.php\';\r\n',0,0,1),(78,'Reward Redemption Confirm','','','<?php require_once \'bpl/jumi/reward_redemption_confirm.php\';\r\n',0,0,1),(79,'Sales Overview','','','<?php require_once \'bpl/jumi/sales_overview.php\';\r\n',0,0,1),(80,'Settings Binary','','','<?php require_once \'bpl/jumi/settings_binary.php\';\r\n',0,0,1),(81,'Settings Entry','','','<?php require_once \'bpl/jumi/settings_entry.php\';\r\n',0,0,1),(82,'Settings Indirect Referral','','','<?php require_once \'bpl/jumi/settings_indirect_referral.php\';\r\n',0,0,1),(83,'Settings Investment','','','<?php require_once \'bpl/jumi/settings_investment.php\';\r\n',0,0,1),(84,'Settings Leadership Binary','','','<?php require_once \'bpl/jumi/settings_leadership_binary.php\';\r\n',0,0,1),(85,'Settings Leadership Passive','','','<?php require_once \'bpl/jumi/settings_leadership_passive.php\';\r\n',0,0,1),(86,'Settings Matrix','','','<?php require_once \'bpl/jumi/settings_matrix.php\';\r\n',0,0,1),(87,'Settings Merchant','','','<?php require_once \'bpl/jumi/settings_merchant.php\';\r\n',0,0,1),(88,'Settings Plans','','','<?php require_once \'bpl/jumi/settings_plans.php\';\r\n',0,0,1),(89,'Settings Power','','','<?php require_once \'bpl/jumi/settings_power.php\';\r\n',0,0,1),(90,'Settings Royalty','','','<?php require_once \'bpl/jumi/settings_royalty.php\';\r\n',0,0,1),(91,'Settings Referral','','','<?php require_once \'bpl/jumi/settings_referral.php\';\r\n',0,0,1),(92,'Settings Trading','','','<?php require_once \'bpl/jumi/settings_trading.php\';\r\n',0,0,1),(93,'Settings Unilevel','','','<?php require_once \'bpl/jumi/settings_unilevel.php\';\r\n',0,0,1),(94,'Settings Ancillaries','','','<?php require_once \'bpl/jumi/settings_ancillaries.php\';\r\n',0,0,1),(95,'Slogin','','','<?php require_once \'bpl/jumi/slogin.php\';\r\n',0,0,1),(96,'Slogout','','','<?php require_once \'bpl/jumi/slogout.php\';\r\n',0,0,1),(97,'System Reset','','','<?php require_once \'bpl/jumi/system_reset.php\';\r\n',0,0,1),(98,'Token Conversion','','','<?php require_once \'bpl/jumi/token_conversion.php\';\r\n',0,0,1),(99,'Token Conversion Completed','','','<?php require_once \'bpl/jumi/token_conversion_completed.php\';\r\n',0,0,1),(100,'Token Conversion Confirm','','','<?php require_once \'bpl/jumi/token_conversion_confirm.php\';\r\n',0,0,1),(101,'Token Conversion Log','','','<?php require_once \'bpl/jumi/token_conversion_log.php\';\r\n',0,0,1),(102,'Token Transfer','','','<?php require_once \'bpl/jumi/token_transfer.php\';\r\n',0,0,1),(103,'Top Up','','','<?php require_once \'bpl/jumi/top_up.php\';\r\n',0,0,1),(104,'Top Up Deposit','','','<?php require_once \'bpl/jumi/top_up_deposit.php\';\r\n',0,0,1),(105,'Trader','','','<?php require_once \'bpl/jumi/trader.php\';\r\n',0,0,1),(106,'Transactions','','','<?php require_once \'bpl/jumi/transactions.php\';\r\n',0,0,1),(107,'Unblock','','','<?php require_once \'bpl/jumi/unblock.php\';\r\n',0,0,1),(108,'Uncommission Deduct','','','<?php require_once \'bpl/jumi/uncommission_deduct.php\';\r\n',0,0,1),(109,'Unilevel Bonus','','','<?php require_once \'bpl/jumi/unilevel_bonus.php\';\r\n',0,0,1),(110,'Upgrade Account Type','','','<?php require_once \'bpl/jumi/upgrade_account_type.php\';\r\n',0,0,1),(111,'Withdrawal Completed','','','<?php require_once \'bpl/jumi/withdrawal_completed.php\';\r\n',0,0,1),(112,'Withdrawal Confirm','','','<?php require_once \'bpl/jumi/withdrawal_confirm.php\';\r\n',0,0,1),(113,'Withdrawal Request','','','<?php require_once \'bpl/jumi/withdrawal_request.php\';\r\n',0,0,1),(114,'Etrade','','','<?php require_once \'bpl/jumi/etrade.php\';',0,0,1),(115,'Etrade Deposit','','','<?php require_once \'bpl/jumi/etrade_deposit.php\';',0,0,1),(116,'Add Ecash','','','<?php require_once \'bpl/jumi/add_ecash.php\';',0,0,1),(117,'Settings Upline Support','','','<?php require_once \'bpl/jumi/settings_upline_support.php\';',0,0,1),(118,'Settings Passup','','','<?php require_once \'bpl/jumi/settings_passup.php\';',0,0,1),(119,'Settings Elite Reward','','','<?php require_once \'bpl/jumi/settings_elite_reward.php\';',0,0,1),(120,'Binary Reactivate','','','<?php require_once \'bpl/jumi/binary_reactivate.php\';',0,0,1),(121,'Settings Harvest','','','<?php require_once \'bpl/jumi/settings_harvest.php\';',0,0,1),(122,'Convert Gold Logs','','','<?php require_once \'bpl/jumi/convert_efund_log.php\';',0,0,1),(123,'Online Shop Merchants','','','<?php require_once \'bpl/jumi/repeat_purchase_items_merchant.php\';',0,0,1),(124,'Add Online Shop Merchant','','','<?php require_once \'bpl/jumi/repeat_purchase_merchants_add.php\';',0,0,1),(125,'Edit Online Shop Merchant','','','<?php require_once \'bpl/jumi/repeat_purchase_merchants_edit.php\';',0,0,1),(126,'P2P Sell Item','','','<?php require_once \'bpl/jumi/p2p_sell_item.php\';',0,0,1),(127,'P2P Buy Item','','','<?php require_once \'bpl/jumi/p2p_buy_item.php\';',0,0,1),(128,'P2P Trade Item History','','','<?php require_once \'bpl/jumi/p2p_trade_item_history.php\';',0,0,1),(129,'Settings Freeze','','','<?php require_once \'bpl/jumi/settings_freeze.php\';',0,0,1),(130,'Account Reactivate','','','<?php require_once \'bpl/jumi/account_reactivate.php\';',0,0,1),(131,'Withdraw Savings','','','<?php require_once \'bpl/jumi/convert_savings.php\';',0,0,1),(132,'Add Points','','','<?php require_once \'bpl/jumi/add_points.php\';',0,0,1),(133,'Transfer Points','','','<?php require_once \'bpl/jumi/point_transfer.php\';',0,0,1),(134,'Savings Transfer','','','<?php require_once \'bpl/jumi/savings_transfer.php\';',0,0,1),(135,'Request Share Fund','','','<?php require_once \'bpl/jumi/request_share_fund.php\';',0,0,1),(136,'Request Share Confirmed','','','<?php require_once \'bpl/jumi/request_share_fund_confirmed.php\';',0,0,1),(137,'Request Share Fund Log','','','<?php require_once \'bpl/jumi/request_share_fund_log.php\';',0,0,1),(138,'Request Share Fund Pending','','','<?php require_once \'bpl/jumi/request_share_fund_pending.php\';',0,0,1),(139,'Loans Transfer','','','<?php require_once \'bpl/jumi/loans_transfer.php\';',0,0,1),(140,'Request Loan','','','<?php require_once \'bpl/jumi/request_loan.php\';',0,0,1),(141,'Request Loan Confirmed','','','<?php require_once \'bpl/jumi/request_loan_confirmed.php\';',0,0,1),(142,'Request Loan Log','','','<?php require_once \'bpl/jumi/request_loan_log.php\';',0,0,1),(143,'Request Loan Pending','','','<?php require_once \'bpl/jumi/request_loan_pending.php\';',0,0,1),(144,'Join','','','<?php require_once \'bpl/jumi/join.php\';',0,0,1),(145,'Echelon Royalty','','','<?php require_once \'bpl/jumi/echelon_bonus.php\';',0,0,1),(146,'Echelon Royalty Settings','','','<?php require_once \'bpl/jumi/settings_echelon.php\';',0,0,1),(147,'Genealogy Echelon','','','<?php require_once \'bpl/jumi/genealogy_echelon.php\';',0,0,1);
/*!40000 ALTER TABLE `joomla_jumi` ENABLE KEYS */;

--
-- Table structure for table `joomla_languages`
--

DROP TABLE IF EXISTS `joomla_languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_languages` (
  `lang_id` int unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int unsigned NOT NULL DEFAULT '0',
  `lang_code` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_native` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sef` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `metakey` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sitename` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `published` int NOT NULL DEFAULT '0',
  `access` int unsigned NOT NULL DEFAULT '0',
  `ordering` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`lang_id`),
  UNIQUE KEY `idx_sef` (`sef`),
  UNIQUE KEY `idx_langcode` (`lang_code`),
  KEY `idx_access` (`access`),
  KEY `idx_ordering` (`ordering`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_languages`
--

/*!40000 ALTER TABLE `joomla_languages` DISABLE KEYS */;
INSERT INTO `joomla_languages` VALUES (1,0,'en-GB','English (en-GB)','English (United Kingdom)','en','en_gb','','','','',1,1,1);
/*!40000 ALTER TABLE `joomla_languages` ENABLE KEYS */;

--
-- Table structure for table `joomla_menu`
--

DROP TABLE IF EXISTS `joomla_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `menutype` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The type of menu this item belongs to. FK to #__menu_types.menutype',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The display title of the menu item.',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT 'The SEF alias of the menu item.',
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `path` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The computed path of the menu item based on the alias field.',
  `link` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The actually link the menu item refers to.',
  `type` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The type of link: Component, URL, Alias, Separator',
  `published` tinyint NOT NULL DEFAULT '0' COMMENT 'The published state of the menu link.',
  `parent_id` int unsigned NOT NULL DEFAULT '1' COMMENT 'The parent menu item in the menu tree.',
  `level` int unsigned NOT NULL DEFAULT '0' COMMENT 'The relative level in the tree.',
  `component_id` int unsigned NOT NULL DEFAULT '0' COMMENT 'FK to #__extensions.id',
  `checked_out` int unsigned NOT NULL DEFAULT '0' COMMENT 'FK to #__users.id',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'The time the menu item was checked out.',
  `browserNav` tinyint NOT NULL DEFAULT '0' COMMENT 'The click behaviour of the link.',
  `access` int unsigned NOT NULL DEFAULT '0' COMMENT 'The access level required to view the menu item.',
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The image of the menu item.',
  `template_style_id` int unsigned NOT NULL DEFAULT '0',
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'JSON encoded data for the menu item.',
  `lft` int NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `home` tinyint unsigned NOT NULL DEFAULT '0' COMMENT 'Indicates if this menu item is the home or default page.',
  `language` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `client_id` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_client_id_parent_id_alias_language` (`client_id`,`parent_id`,`alias`(100),`language`),
  KEY `idx_componentid` (`component_id`,`menutype`,`published`,`access`),
  KEY `idx_menutype` (`menutype`),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`(100)),
  KEY `idx_path` (`path`(100)),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=249 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_menu`
--

/*!40000 ALTER TABLE `joomla_menu` DISABLE KEYS */;
INSERT INTO `joomla_menu` VALUES (1,'','Menu_Item_Root','root','','','','',1,0,0,0,0,'0000-00-00 00:00:00',0,0,'',0,'',0,337,0,'*',0),(2,'main','com_banners','Banners','','Banners','index.php?option=com_banners','component',1,1,1,4,0,'0000-00-00 00:00:00',0,0,'class:banners',0,'',1,10,0,'*',1),(3,'main','com_banners','Banners','','Banners/Banners','index.php?option=com_banners','component',1,2,2,4,0,'0000-00-00 00:00:00',0,0,'class:banners',0,'',2,3,0,'*',1),(4,'main','com_banners_categories','Categories','','Banners/Categories','index.php?option=com_categories&extension=com_banners','component',1,2,2,6,0,'0000-00-00 00:00:00',0,0,'class:banners-cat',0,'',4,5,0,'*',1),(5,'main','com_banners_clients','Clients','','Banners/Clients','index.php?option=com_banners&view=clients','component',1,2,2,4,0,'0000-00-00 00:00:00',0,0,'class:banners-clients',0,'',6,7,0,'*',1),(6,'main','com_banners_tracks','Tracks','','Banners/Tracks','index.php?option=com_banners&view=tracks','component',1,2,2,4,0,'0000-00-00 00:00:00',0,0,'class:banners-tracks',0,'',8,9,0,'*',1),(7,'main','com_contact','Contacts','','Contacts','index.php?option=com_contact','component',1,1,1,8,0,'0000-00-00 00:00:00',0,0,'class:contact',0,'',11,16,0,'*',1),(8,'main','com_contact_contacts','Contacts','','Contacts/Contacts','index.php?option=com_contact','component',1,7,2,8,0,'0000-00-00 00:00:00',0,0,'class:contact',0,'',12,13,0,'*',1),(9,'main','com_contact_categories','Categories','','Contacts/Categories','index.php?option=com_categories&extension=com_contact','component',1,7,2,6,0,'0000-00-00 00:00:00',0,0,'class:contact-cat',0,'',14,15,0,'*',1),(10,'main','com_messages','Messaging','','Messaging','index.php?option=com_messages','component',1,1,1,15,0,'0000-00-00 00:00:00',0,0,'class:messages',0,'',17,20,0,'*',1),(11,'main','com_messages_add','New Private Message','','Messaging/New Private Message','index.php?option=com_messages&task=message.add','component',1,10,2,15,0,'0000-00-00 00:00:00',0,0,'class:messages-add',0,'',18,19,0,'*',1),(13,'main','com_newsfeeds','News Feeds','','News Feeds','index.php?option=com_newsfeeds','component',1,1,1,17,0,'0000-00-00 00:00:00',0,0,'class:newsfeeds',0,'',21,26,0,'*',1),(14,'main','com_newsfeeds_feeds','Feeds','','News Feeds/Feeds','index.php?option=com_newsfeeds','component',1,13,2,17,0,'0000-00-00 00:00:00',0,0,'class:newsfeeds',0,'',22,23,0,'*',1),(15,'main','com_newsfeeds_categories','Categories','','News Feeds/Categories','index.php?option=com_categories&extension=com_newsfeeds','component',1,13,2,6,0,'0000-00-00 00:00:00',0,0,'class:newsfeeds-cat',0,'',24,25,0,'*',1),(16,'main','com_redirect','Redirect','','Redirect','index.php?option=com_redirect','component',1,1,1,24,0,'0000-00-00 00:00:00',0,0,'class:redirect',0,'',27,28,0,'*',1),(17,'main','com_search','Basic Search','','Basic Search','index.php?option=com_search','component',1,1,1,19,0,'0000-00-00 00:00:00',0,0,'class:search',0,'',29,30,0,'*',1),(18,'main','com_finder','Smart Search','','Smart Search','index.php?option=com_finder','component',1,1,1,27,0,'0000-00-00 00:00:00',0,0,'class:finder',0,'',31,32,0,'*',1),(19,'main','com_joomlaupdate','Joomla! Update','','Joomla! Update','index.php?option=com_joomlaupdate','component',1,1,1,28,0,'0000-00-00 00:00:00',0,0,'class:joomlaupdate',0,'',33,34,0,'*',1),(20,'main','com_tags','Tags','','Tags','index.php?option=com_tags','component',1,1,1,29,0,'0000-00-00 00:00:00',0,1,'class:tags',0,'',35,36,0,'',1),(21,'main','com_postinstall','Post-installation messages','','Post-installation messages','index.php?option=com_postinstall','component',1,1,1,32,0,'0000-00-00 00:00:00',0,1,'class:postinstall',0,'',37,38,0,'*',1),(22,'main','com_associations','Multilingual Associations','','Multilingual Associations','index.php?option=com_associations','component',1,1,1,34,0,'0000-00-00 00:00:00',0,0,'class:associations',0,'',39,40,0,'*',1),(101,'mainmenu','Home','home','','home','index.php?option=com_jumi&view=application&fileid=43','component',1,1,1,10000,632,'2024-12-23 05:36:21',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"1\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',41,42,1,'*',0),(102,'main','COM_JUMI_MENU','com-jumi-menu','','com-jumi-menu','index.php?option=com_jumi','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,'components/com_jumi/images/jumi.png',0,'{}',43,44,0,'',1),(103,'hidden','Account Summary','account-summary','','account-summary','index.php?option=com_jumi&view=application&fileid=1','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',45,46,0,'*',0),(104,'hidden','Active Income','active-income','','active-income','index.php?option=com_jumi&view=application&fileid=2','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',47,48,0,'*',0),(105,'hidden','Activity','activity','','activity','index.php?option=com_jumi&view=application&fileid=3','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',49,50,0,'*',0),(106,'hidden','Add Efunds','add-efunds','','add-efunds','index.php?option=com_jumi&view=application&fileid=4','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',51,52,0,'*',0),(107,'hidden','Add Tokens','add-tokens','','add-tokens','index.php?option=com_jumi&view=application&fileid=5','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',53,54,0,'*',0),(108,'hidden','Admin Account Update','admin-account-update','','admin-account-update','index.php?option=com_jumi&view=application&fileid=6','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',55,56,0,'*',0),(109,'hidden','Admin Code Inventory','admin-code-inventory','','admin-code-inventory','index.php?option=com_jumi&view=application&fileid=7','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',57,58,0,'*',0),(110,'hidden','Block','block','','block','index.php?option=com_jumi&view=application&fileid=8','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',59,60,0,'*',0),(111,'hidden','Buy Items','buy-items','','buy-items','index.php?option=com_jumi&view=application&fileid=9','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',61,62,0,'*',0),(112,'hidden','Buy Package','buy-package','','buy-package','index.php?option=com_jumi&view=application&fileid=10','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',63,64,0,'*',0),(113,'hidden','Commission Deduct','commission-deduct','','commission-deduct','index.php?option=com_jumi&view=application&fileid=11','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',65,66,0,'*',0),(114,'hidden','Converter','converter','','converter','index.php?option=com_jumi&view=application&fileid=12','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',67,68,0,'*',0),(115,'hidden','Direct Referrals','direct-referrals','','direct-referrals','index.php?option=com_jumi&view=application&fileid=13','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',69,70,0,'*',0),(116,'hidden','Downlines','downlines','','downlines','index.php?option=com_jumi&view=application&fileid=14','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',71,72,0,'*',0),(117,'hidden','Efund Deposit','efund-deposit','','efund-deposit','index.php?option=com_jumi&view=application&fileid=15','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',73,74,0,'*',0),(118,'hidden','Efund Transfer','efund-transfer','','efund-transfer','index.php?option=com_jumi&view=application&fileid=16','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',75,76,0,'*',0),(119,'hidden','Fixed Daily','fixed-daily','','fixed-daily','index.php?option=com_jumi&view=application&fileid=17','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',77,78,0,'*',0),(120,'hidden','Fixed Daily Deposit','fixed-daily-deposit','','fixed-daily-deposit','index.php?option=com_jumi&view=application&fileid=18','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',79,80,0,'*',0),(121,'hidden','Fast Track','fast-track','','fast-track','index.php?option=com_jumi&view=application&fileid=19','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',81,82,0,'*',0),(122,'hidden','Fast Track Deposit','fast-track-deposit','','fast-track-deposit','index.php?option=com_jumi&view=application&fileid=20','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',83,84,0,'*',0),(123,'hidden','Genealogy Binary','genealogy-binary','','genealogy-binary','index.php?option=com_jumi&view=application&fileid=21','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',85,86,0,'*',0),(124,'hidden','Genealogy Harvest Associate','genealogy-harvest-associate','','genealogy-harvest-associate','index.php?option=com_jumi&view=application&fileid=22','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',87,88,0,'*',0),(125,'hidden','Genealogy Harvest Basic','genealogy-harvest-basic','','genealogy-harvest-basic','index.php?option=com_jumi&view=application&fileid=23','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',89,90,0,'*',0),(126,'hidden','Genealogy Indirect','genealogy-indirect','','genealogy-indirect','index.php?option=com_jumi&view=application&fileid=24','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',91,92,0,'*',0),(127,'hidden','Genealogy Leadership','genealogy-leadership','','genealogy-leadership','index.php?option=com_jumi&view=application&fileid=25','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',93,94,0,'*',0),(128,'hidden','Genealogy Leadership Passive','genealogy-leadership-passive','','genealogy-leadership-passive','index.php?option=com_jumi&view=application&fileid=26','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',95,96,0,'*',0),(129,'hidden','Genealogy Profit Share Associate','genealogy-profit-share-associate','','genealogy-profit-share-associate','index.php?option=com_jumi&view=application&fileid=27','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',97,98,0,'*',0),(130,'hidden','Genealogy Profit Share Basic','genealogy-profit-share-basic','','genealogy-profit-share-basic','index.php?option=com_jumi&view=application&fileid=28','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',99,100,0,'*',0),(131,'hidden','Genealogy Profit Share Chairman','genealogy-profit-share-chairman','','genealogy-profit-share-chairman','index.php?option=com_jumi&view=application&fileid=29','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',101,102,0,'*',0),(132,'hidden','Genealogy Profit Share Director','genealogy-profit-share-director','','genealogy-profit-share-director','index.php?option=com_jumi&view=application&fileid=30','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',103,104,0,'*',0),(133,'hidden','Genealogy Profit Share Executive','genealogy-profit-share-executive','','genealogy-profit-share-executive','index.php?option=com_jumi&view=application&fileid=31','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',105,106,0,'*',0),(134,'hidden','Genealogy Profit Share Regular','genealogy-profit-share-regular','','genealogy-profit-share-regular','index.php?option=com_jumi&view=application&fileid=32','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',107,108,0,'*',0),(135,'hidden','Genealogy Unilevel','genealogy-unilevel','','genealogy-unilevel','index.php?option=com_jumi&view=application&fileid=33','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',109,110,0,'*',0),(136,'hidden','Generate Codes','generate-codes','','generate-codes','index.php?option=com_jumi&view=application&fileid=34','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',111,112,0,'*',0),(137,'hidden','Income Log','income-log','','income-log','index.php?option=com_jumi&view=application&fileid=35','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',113,114,0,'*',0),(138,'hidden','Indirect Bonus','indirect-bonus','','indirect-bonus','index.php?option=com_jumi&view=application&fileid=36','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',115,116,0,'*',0),(139,'hidden','Leadership Bonus','leadership-bonus','','leadership-bonus','index.php?option=com_jumi&view=application&fileid=37','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',117,118,0,'*',0),(140,'hidden','Leadership Bonus Passive','leadership-bonus-passive','','leadership-bonus-passive','index.php?option=com_jumi&view=application&fileid=38','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',119,120,0,'*',0),(141,'hidden','Leadership Bonus Passive Deposit','leadership-bonus-passive-deposit','','leadership-bonus-passive-deposit','index.php?option=com_jumi&view=application&fileid=39','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',121,122,0,'*',0),(142,'hidden','List Members','list-members','','list-members','index.php?option=com_jumi&view=application&fileid=40','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',123,124,0,'*',0),(143,'hidden','Logout','logout','','logout','index.php?option=com_jumi&view=application&fileid=41','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',125,126,0,'*',0),(144,'hidden','Lookup Code','lookup-code','','lookup-code','index.php?option=com_jumi&view=application&fileid=42','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',127,128,0,'*',0),(145,'hidden','Member','member','','member','index.php?option=com_jumi&view=application&fileid=43','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',129,130,0,'*',0),(146,'hidden','Member Info','member-info','','member-info','index.php?option=com_jumi&view=application&fileid=44','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',131,132,0,'*',0),(147,'hidden','Merchant','merchant','','merchant','index.php?option=com_jumi&view=application&fileid=45','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',133,134,0,'*',0),(148,'hidden','Merchant Package Buy','merchant-package-buy','','merchant-package-buy','index.php?option=com_jumi&view=application&fileid=46','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',135,136,0,'*',0),(149,'hidden','Overall Purchase History','overall-purchase-history','','overall-purchase-history','index.php?option=com_jumi&view=application&fileid=47','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',137,138,0,'*',0),(150,'hidden','Overall Reward Redemption History','overall-reward-redemption-history','','overall-reward-redemption-history','index.php?option=com_jumi&view=application&fileid=48','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',139,140,0,'*',0),(151,'hidden','Payout Log','payout-log','','payout-log','index.php?option=com_jumi&view=application&fileid=49','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',141,142,0,'*',0),(152,'hidden','Point Rewards Items','point-rewards-items','','point-rewards-items','index.php?option=com_jumi&view=application&fileid=50','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',143,144,0,'*',0),(153,'hidden','Point Rewards Items Add','point-rewards-items-add','','point-rewards-items-add','index.php?option=com_jumi&view=application&fileid=51','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',145,146,0,'*',0),(154,'hidden','Point Rewards Items Edit','point-rewards-items-edit','','point-rewards-items-edit','index.php?option=com_jumi&view=application&fileid=52','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',147,148,0,'*',0),(155,'hidden','Point Reward Redemption List','point-reward-redemption-list','','point-reward-redemption-list','index.php?option=com_jumi&view=application&fileid=53','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',149,150,0,'*',0),(156,'hidden','P2P Sell Token','p2p-sell-token','','p2p-sell-token','index.php?option=com_jumi&view=application&fileid=54','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',151,152,0,'*',0),(157,'hidden','P2P Buy Token','p2p-buy-token','','p2p-buy-token','index.php?option=com_jumi&view=application&fileid=55','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',153,154,0,'*',0),(158,'hidden','P2P Trade History','p2p-trade-history','','p2p-trade-history','index.php?option=com_jumi&view=application&fileid=56','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',155,156,0,'*',0),(159,'hidden','Convert Gold','convert-gold','','convert-gold','index.php?option=com_jumi&view=application&fileid=57','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',157,158,0,'*',0),(160,'hidden','Convert Gold Pending','convert-gold-pending','','convert-gold-pending','index.php?option=com_jumi&view=application&fileid=58','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',159,160,0,'*',0),(161,'hidden','Convert Gold Confirmed','convert-gold-confirmed','','convert-gold-confirmed','index.php?option=com_jumi&view=application&fileid=59','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',161,162,0,'*',0),(162,'hidden','Profile Update','profile-update','','profile-update','index.php?option=com_jumi&view=application&fileid=60','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',163,164,0,'*',0),(163,'hidden','Profit Share Deposit','profit-share-deposit','','profit-share-deposit','index.php?option=com_jumi&view=application&fileid=61','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',165,166,0,'*',0),(164,'hidden','Purchase Items Confirm','purchase-items-confirm','','purchase-items-confirm','index.php?option=com_jumi&view=application&fileid=62','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',167,168,0,'*',0),(165,'hidden','Purchase Items Invoice','purchase-items-invoice','','purchase-items-invoice','index.php?option=com_jumi&view=application&fileid=63','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',169,170,0,'*',0),(166,'hidden','Redeem Point Rewards','redeem-point-rewards','','redeem-point-rewards','index.php?option=com_jumi&view=application&fileid=64','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',171,172,0,'*',0),(167,'hidden','Registration','registration','','registration','index.php?option=com_jumi&view=application&fileid=65','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',173,174,0,'*',0),(168,'hidden','Registration Codes','registration-codes','','registration-codes','index.php?option=com_jumi&view=application&fileid=66','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',175,176,0,'*',0),(169,'hidden','Registration Codes Inventory','registration-codes-inventory','','registration-codes-inventory','index.php?option=com_jumi&view=application&fileid=67','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',177,178,0,'*',0),(170,'hidden','Registration Codes Used','registration-codes-used','','registration-codes-used','index.php?option=com_jumi&view=application&fileid=68','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',179,180,0,'*',0),(171,'hidden','Repeat Purchase Items','repeat-purchase-items','','repeat-purchase-items','index.php?option=com_jumi&view=application&fileid=69','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',181,182,0,'*',0),(172,'hidden','Repeat Purchase Items Add','repeat-purchase-items-add','','repeat-purchase-items-add','index.php?option=com_jumi&view=application&fileid=70','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',183,184,0,'*',0),(173,'hidden','Repeat Purchase Items Edit','repeat-purchase-items-edit','','repeat-purchase-items-edit','index.php?option=com_jumi&view=application&fileid=71','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',185,186,0,'*',0),(174,'hidden','Repeat Purchase Items List','repeat-purchase-items-list','','repeat-purchase-items-list','index.php?option=com_jumi&view=application&fileid=72','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',187,188,0,'*',0),(175,'hidden','Request Efund','request-efund','','request-efund','index.php?option=com_jumi&view=application&fileid=73','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',189,190,0,'*',0),(176,'hidden','Request Efund Confirmed','request-efund-confirmed','','request-efund-confirmed','index.php?option=com_jumi&view=application&fileid=74','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',191,192,0,'*',0),(177,'hidden','Request Efund Log','request-efund-log','','request-efund-log','index.php?option=com_jumi&view=application&fileid=75','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',193,194,0,'*',0),(178,'hidden','Request Efund Pending','request-efund-pending','','request-efund-pending','index.php?option=com_jumi&view=application&fileid=76','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',195,196,0,'*',0),(179,'hidden','Reset','reset','','reset','index.php?option=com_jumi&view=application&fileid=77','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',197,198,0,'*',0),(180,'hidden','Reward Redemption Confirm','reward-redemption-confirm','','reward-redemption-confirm','index.php?option=com_jumi&view=application&fileid=78','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',199,200,0,'*',0),(181,'hidden','Sales Overview','sales-overview','','sales-overview','index.php?option=com_jumi&view=application&fileid=79','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',201,202,0,'*',0),(182,'hidden','Settings Binary','settings-binary','','settings-binary','index.php?option=com_jumi&view=application&fileid=80','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',203,204,0,'*',0),(183,'hidden','Settings Entry','settings-entry','','settings-entry','index.php?option=com_jumi&view=application&fileid=81','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',205,206,0,'*',0),(184,'hidden','Settings Indirect Referral','settings-indirect-referral','','settings-indirect-referral','index.php?option=com_jumi&view=application&fileid=82','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',207,208,0,'*',0),(185,'hidden','Settings Investment','settings-investment','','settings-investment','index.php?option=com_jumi&view=application&fileid=83','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',209,210,0,'*',0),(186,'hidden','Settings Leadership Binary','settings-leadership-binary','','settings-leadership-binary','index.php?option=com_jumi&view=application&fileid=84','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',211,212,0,'*',0),(187,'hidden','Settings Leadership Passive','settings-leadership-passive','','settings-leadership-passive','index.php?option=com_jumi&view=application&fileid=85','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',213,214,0,'*',0),(188,'hidden','Settings Matrix','settings-matrix','','settings-matrix','index.php?option=com_jumi&view=application&fileid=86','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',215,216,0,'*',0),(189,'hidden','Settings Merchant','settings-merchant','','settings-merchant','index.php?option=com_jumi&view=application&fileid=87','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',217,218,0,'*',0),(190,'hidden','Settings Plans','settings-plans','','settings-plans','index.php?option=com_jumi&view=application&fileid=88','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',219,220,0,'*',0),(191,'hidden','Settings Power','settings-power','','settings-power','index.php?option=com_jumi&view=application&fileid=89','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',221,222,0,'*',0),(192,'hidden','Settings Royalty','settings-royalty','','settings-royalty','index.php?option=com_jumi&view=application&fileid=90','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',223,224,0,'*',0),(193,'hidden','Settings Referral','settings-referral','','settings-referral','index.php?option=com_jumi&view=application&fileid=91','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',225,226,0,'*',0),(194,'hidden','Settings Trading','settings-trading','','settings-trading','index.php?option=com_jumi&view=application&fileid=92','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',227,228,0,'*',0),(195,'hidden','Settings Unilevel','settings-unilevel','','settings-unilevel','index.php?option=com_jumi&view=application&fileid=93','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',229,230,0,'*',0),(196,'hidden','Settings Ancillaries','settings-ancillaries','','settings-ancillaries','index.php?option=com_jumi&view=application&fileid=94','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',231,232,0,'*',0),(197,'hidden','Slogin','slogin','','slogin','index.php?option=com_jumi&view=application&fileid=95','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',233,234,0,'*',0),(198,'hidden','Slogout','slogout','','slogout','index.php?option=com_jumi&view=application&fileid=96','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',235,236,0,'*',0),(199,'hidden','System Reset','system-reset','','system-reset','index.php?option=com_jumi&view=application&fileid=97','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',237,238,0,'*',0),(200,'hidden','Token Conversion','token-conversion','','token-conversion','index.php?option=com_jumi&view=application&fileid=98','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',239,240,0,'*',0),(201,'hidden','Token Conversion Completed','token-conversion-completed','','token-conversion-completed','index.php?option=com_jumi&view=application&fileid=99','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',241,242,0,'*',0),(202,'hidden','Token Conversion Confirm','token-conversion-confirm','','token-conversion-confirm','index.php?option=com_jumi&view=application&fileid=100','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',243,244,0,'*',0),(203,'hidden','Token Conversion Log','token-conversion-log','','token-conversion-log','index.php?option=com_jumi&view=application&fileid=101','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',245,246,0,'*',0),(204,'hidden','Token Transfer','token-transfer','','token-transfer','index.php?option=com_jumi&view=application&fileid=102','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',247,248,0,'*',0),(205,'hidden','Top Up','top-up','','top-up','index.php?option=com_jumi&view=application&fileid=103','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',249,250,0,'*',0),(206,'hidden','Top Up Deposit','top-up-deposit','','top-up-deposit','index.php?option=com_jumi&view=application&fileid=104','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',251,252,0,'*',0),(207,'hidden','Trader','trader','','trader','index.php?option=com_jumi&view=application&fileid=105','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',253,254,0,'*',0),(208,'hidden','Transactions','transactions','','transactions','index.php?option=com_jumi&view=application&fileid=106','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',255,256,0,'*',0),(209,'hidden','Unblock','unblock','','unblock','index.php?option=com_jumi&view=application&fileid=107','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',257,258,0,'*',0),(210,'hidden','Uncommission Deduct','uncommission-deduct','','uncommission-deduct','index.php?option=com_jumi&view=application&fileid=108','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',259,260,0,'*',0),(211,'hidden','Unilevel Bonus','unilevel-bonus','','unilevel-bonus','index.php?option=com_jumi&view=application&fileid=109','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',261,262,0,'*',0),(212,'hidden','Upgrade Account Type','upgrade-account-type','','upgrade-account-type','index.php?option=com_jumi&view=application&fileid=110','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',263,264,0,'*',0),(213,'hidden','Withdrawal Completed','withdrawal-completed','','withdrawal-completed','index.php?option=com_jumi&view=application&fileid=111','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',265,266,0,'*',0),(214,'hidden','Withdrawal Confirm','withdrawal-confirm','','withdrawal-confirm','index.php?option=com_jumi&view=application&fileid=112','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',267,268,0,'*',0),(215,'hidden','Withdrawal Request','withdrawal-request','','withdrawal-request','index.php?option=com_jumi&view=application&fileid=113','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',269,270,0,'*',0),(216,'hidden','Etrade','etrade','','etrade','index.php?option=com_jumi&view=application&fileid=114','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',271,272,0,'*',0),(217,'hidden','Etrade Deposit','etrade-deposit','','etrade-deposit','index.php?option=com_jumi&view=application&fileid=115','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',273,274,0,'*',0),(218,'hidden','Add Ecash','add-ecash','','add-ecash','index.php?option=com_jumi&view=application&fileid=116','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',275,276,0,'*',0),(219,'hidden','Settings Upline Support','settings-upline-support','','settings-upline-support','index.php?option=com_jumi&view=application&fileid=117','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',277,278,0,'*',0),(220,'hidden','Settings Passup','settings-passup','','settings-passup','index.php?option=com_jumi&view=application&fileid=118','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',279,280,0,'*',0),(221,'hidden','Settings Elite Reward','settings-elite-reward','','settings-elite-reward','index.php?option=com_jumi&view=application&fileid=119','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',281,282,0,'*',0),(222,'hidden','Binary Reactivate','binary-reactivate','','binary-reactivate','index.php?option=com_jumi&view=application&fileid=120','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',283,284,0,'*',0),(223,'hidden','Settings Harvest','settings-harvest','','settings-harvest','index.php?option=com_jumi&view=application&fileid=1','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',285,286,0,'*',0),(224,'hidden','Convert Gold Logs','convert-gold-logs','','convert-gold-logs','index.php?option=com_jumi&view=application&fileid=122','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',287,288,0,'*',0),(225,'hidden','Online Shop Merchants','online-shop-merchants','','online-shop-merchants','index.php?option=com_jumi&view=application&fileid=123','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',289,290,0,'*',0),(226,'hidden','Add Online Shop Merchant','add-online-shop-merchant','','add-online-shop-merchant','index.php?option=com_jumi&view=application&fileid=124','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',291,292,0,'*',0),(227,'hidden','Edit Online Shop Merchant','edit-online-shop-merchant','','edit-online-shop-merchant','index.php?option=com_jumi&view=application&fileid=125','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',293,294,0,'*',0),(228,'hidden','P2P Sell Item','p2p-sell-item','','p2p-sell-item','index.php?option=com_jumi&view=application&fileid=126','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',295,296,0,'*',0),(229,'hidden','P2P Buy Item','p2p-buy-item','','p2p-buy-item','index.php?option=com_jumi&view=application&fileid=127','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',297,298,0,'*',0),(230,'hidden','P2P Trade Item History','p2p-trade-item-history','','p2p-trade-item-history','index.php?option=com_jumi&view=application&fileid=128','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',299,300,0,'*',0),(231,'hidden','Settings Freeze','settings-freeze','','settings-freeze','index.php?option=com_jumi&view=application&fileid=129','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',301,302,0,'*',0),(232,'hidden','Account Reactivate','account-reactivate','','account-reactivate','index.php?option=com_jumi&view=application&fileid=130','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',303,304,0,'*',0),(233,'hidden','Add Points','add-points','','add-points','index.php?option=com_jumi&view=application&fileid=132','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',305,306,0,'*',0),(234,'hidden','Transfer Points','transfer-points','','transfer-points','index.php?option=com_jumi&view=application&fileid=133','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',307,308,0,'*',0),(235,'hidden','Savings Transfer','savings-transfer','','savings-transfer','index.php?option=com_jumi&view=application&fileid=134','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',309,310,0,'*',0),(236,'hidden','Request Share Fund','request-share-fund','','request-share-fund','index.php?option=com_jumi&view=application&fileid=135','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',311,312,0,'*',0),(237,'hidden','Request Share Confirmed','request-share-confirmed','','request-share-confirmed','index.php?option=com_jumi&view=application&fileid=136','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',313,314,0,'*',0),(238,'hidden','Request Share Fund Log','request-share-fund-log','','request-share-fund-log','index.php?option=com_jumi&view=application&fileid=137','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',315,316,0,'*',0),(239,'hidden','Request Share Fund Pending','request-share-fund-pending','','request-share-fund-pending','index.php?option=com_jumi&view=application&fileid=138','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',317,318,0,'*',0),(240,'hidden','Loans Transfer','loans-transfer','','loans-transfer','index.php?option=com_jumi&view=application&fileid=139','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',319,320,0,'*',0),(241,'hidden','Request Loan','request-loan','','request-loan','index.php?option=com_jumi&view=application&fileid=140','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',321,322,0,'*',0),(242,'hidden','Request Loan Confirmed','request-loan-confirmed','','request-loan-confirmed','index.php?option=com_jumi&view=application&fileid=141','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',323,324,0,'*',0),(243,'hidden','Request Loan Log','request-loan-log','','request-loan-log','index.php?option=com_jumi&view=application&fileid=142','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',325,326,0,'*',0),(244,'hidden','Request Loan Pending','request-loan-pending','','request-loan-pending','index.php?option=com_jumi&view=application&fileid=143','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',327,328,0,'*',0),(245,'hidden','Join','join','','join','index.php?option=com_jumi&view=application&fileid=144','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',329,330,0,'*',0),(246,'hidden','Echelon Royalty','echelon-royalty','','echelon-royalty','index.php?option=com_jumi&view=application&fileid=145','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',331,332,0,'*',0),(247,'hidden','Echelon Royalty Settings','echelon-royalty-settings','','echelon-royalty-settings','index.php?option=com_jumi&view=application&fileid=146','component',1,1,1,10000,0,'0000-00-00 00:00:00',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',333,334,0,'*',0),(248,'hidden','Genealogy Echelon','genealogy-echelon','','genealogy-echelon','index.php?option=com_jumi&view=application&fileid=147','component',1,1,1,10000,632,'2024-12-23 08:28:17',0,1,' ',0,'{\"menu-anchor_title\":\"\",\"menu-anchor_css\":\"\",\"menu_image\":\"\",\"menu_image_css\":\"\",\"menu_text\":1,\"menu_show\":1,\"page_title\":\"\",\"show_page_heading\":\"\",\"page_heading\":\"\",\"pageclass_sfx\":\"\",\"menu-meta_description\":\"\",\"menu-meta_keywords\":\"\",\"robots\":\"\",\"secure\":0}',335,336,0,'*',0);
/*!40000 ALTER TABLE `joomla_menu` ENABLE KEYS */;

--
-- Table structure for table `joomla_menu_types`
--

DROP TABLE IF EXISTS `joomla_menu_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_menu_types` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int unsigned NOT NULL DEFAULT '0',
  `menutype` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(48) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `client_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_menutype` (`menutype`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_menu_types`
--

/*!40000 ALTER TABLE `joomla_menu_types` DISABLE KEYS */;
INSERT INTO `joomla_menu_types` VALUES (1,0,'mainmenu','Main Menu','The main menu for the site',0),(2,62,'hidden','Hidden','',0);
/*!40000 ALTER TABLE `joomla_menu_types` ENABLE KEYS */;

--
-- Table structure for table `joomla_messages`
--

DROP TABLE IF EXISTS `joomla_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_messages` (
  `message_id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id_from` int unsigned NOT NULL DEFAULT '0',
  `user_id_to` int unsigned NOT NULL DEFAULT '0',
  `folder_id` tinyint unsigned NOT NULL DEFAULT '0',
  `date_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `priority` tinyint unsigned NOT NULL DEFAULT '0',
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`message_id`),
  KEY `useridto_state` (`user_id_to`,`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_messages`
--

/*!40000 ALTER TABLE `joomla_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_messages` ENABLE KEYS */;

--
-- Table structure for table `joomla_messages_cfg`
--

DROP TABLE IF EXISTS `joomla_messages_cfg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_messages_cfg` (
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `cfg_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `cfg_value` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_messages_cfg`
--

/*!40000 ALTER TABLE `joomla_messages_cfg` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_messages_cfg` ENABLE KEYS */;

--
-- Table structure for table `joomla_modules`
--

DROP TABLE IF EXISTS `joomla_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_modules` (
  `id` int NOT NULL AUTO_INCREMENT,
  `asset_id` int unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `ordering` int NOT NULL DEFAULT '0',
  `position` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `checked_out` int unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `module` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access` int unsigned NOT NULL DEFAULT '0',
  `showtitle` tinyint unsigned NOT NULL DEFAULT '1',
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` tinyint NOT NULL DEFAULT '0',
  `language` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_modules`
--

/*!40000 ALTER TABLE `joomla_modules` DISABLE KEYS */;
INSERT INTO `joomla_modules` VALUES (1,39,'Main Menu','','',1,'position-7',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_menu',1,1,'{\"menutype\":\"mainmenu\",\"startLevel\":\"0\",\"endLevel\":\"0\",\"showAllChildren\":\"1\",\"tag_id\":\"\",\"class_sfx\":\"\",\"window_open\":\"\",\"layout\":\"\",\"moduleclass_sfx\":\"_menu\",\"cache\":\"1\",\"cache_time\":\"900\",\"cachemode\":\"itemid\"}',0,'*'),(2,40,'Login','','',1,'login',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_login',1,1,'',1,'*'),(3,41,'Popular Articles','','',3,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_popular',3,1,'{\"count\":\"5\",\"catid\":\"\",\"user_id\":\"0\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\"}',1,'*'),(4,42,'Recently Added Articles','','',4,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_latest',3,1,'{\"count\":\"5\",\"ordering\":\"c_dsc\",\"catid\":\"\",\"user_id\":\"0\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\"}',1,'*'),(8,43,'Toolbar','','',1,'toolbar',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_toolbar',3,1,'',1,'*'),(9,44,'Quick Icons','','',1,'icon',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_quickicon',3,1,'',1,'*'),(10,45,'Logged-in Users','','',2,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_logged',3,1,'{\"count\":\"5\",\"name\":\"1\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\"}',1,'*'),(12,46,'Admin Menu','','',1,'menu',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_menu',3,1,'{\"layout\":\"\",\"moduleclass_sfx\":\"\",\"shownew\":\"1\",\"showhelp\":\"1\",\"cache\":\"0\"}',1,'*'),(13,47,'Admin Submenu','','',1,'submenu',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_submenu',3,1,'',1,'*'),(14,48,'User Status','','',2,'status',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_status',3,1,'',1,'*'),(15,49,'Title','','',1,'title',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_title',3,1,'',1,'*'),(16,50,'Login Form','','',7,'position-7',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_login',1,1,'{\"greeting\":\"1\",\"name\":\"0\"}',0,'*'),(17,51,'Breadcrumbs','','',1,'position-2',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_breadcrumbs',1,1,'{\"moduleclass_sfx\":\"\",\"showHome\":\"1\",\"homeText\":\"\",\"showComponent\":\"1\",\"separator\":\"\",\"cache\":\"0\",\"cache_time\":\"0\",\"cachemode\":\"itemid\"}',0,'*'),(79,52,'Multilanguage status','','',1,'status',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_multilangstatus',3,1,'{\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\"}',1,'*'),(86,53,'Joomla Version','','',1,'footer',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_version',3,1,'{\"format\":\"short\",\"product\":\"1\",\"layout\":\"_:default\",\"moduleclass_sfx\":\"\",\"cache\":\"0\"}',1,'*'),(87,55,'Sample Data','','',0,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_sampledata',6,1,'{}',1,'*'),(88,58,'Latest Actions','','',0,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_latestactions',6,1,'{}',1,'*'),(89,59,'Privacy Dashboard','','',0,'cpanel',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'mod_privacy_dashboard',6,1,'{}',1,'*'),(90,60,'Jumi','','',0,'',0,'0000-00-00 00:00:00','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'mod_jumi',1,1,'',0,'*');
/*!40000 ALTER TABLE `joomla_modules` ENABLE KEYS */;

--
-- Table structure for table `joomla_modules_menu`
--

DROP TABLE IF EXISTS `joomla_modules_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_modules_menu` (
  `moduleid` int NOT NULL DEFAULT '0',
  `menuid` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`moduleid`,`menuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_modules_menu`
--

/*!40000 ALTER TABLE `joomla_modules_menu` DISABLE KEYS */;
INSERT INTO `joomla_modules_menu` VALUES (1,0),(2,0),(3,0),(4,0),(6,0),(7,0),(8,0),(9,0),(10,0),(12,0),(13,0),(14,0),(15,0),(16,0),(17,0),(79,0),(86,0),(87,0),(88,0),(89,0);
/*!40000 ALTER TABLE `joomla_modules_menu` ENABLE KEYS */;

--
-- Table structure for table `joomla_newsfeeds`
--

DROP TABLE IF EXISTS `joomla_newsfeeds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_newsfeeds` (
  `catid` int NOT NULL DEFAULT '0',
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `link` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `numarticles` int unsigned NOT NULL DEFAULT '1',
  `cache_time` int unsigned NOT NULL DEFAULT '3600',
  `checked_out` int unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int NOT NULL DEFAULT '0',
  `rtl` tinyint NOT NULL DEFAULT '0',
  `access` int unsigned NOT NULL DEFAULT '0',
  `language` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int unsigned NOT NULL DEFAULT '0',
  `created_by_alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int unsigned NOT NULL DEFAULT '0',
  `metakey` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadata` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `xreference` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'A reference to enable linkages to external data sets.',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int unsigned NOT NULL DEFAULT '1',
  `hits` int unsigned NOT NULL DEFAULT '0',
  `images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`published`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_language` (`language`),
  KEY `idx_xreference` (`xreference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_newsfeeds`
--

/*!40000 ALTER TABLE `joomla_newsfeeds` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_newsfeeds` ENABLE KEYS */;

--
-- Table structure for table `joomla_overrider`
--

DROP TABLE IF EXISTS `joomla_overrider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_overrider` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `constant` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `string` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_overrider`
--

/*!40000 ALTER TABLE `joomla_overrider` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_overrider` ENABLE KEYS */;

--
-- Table structure for table `joomla_postinstall_messages`
--

DROP TABLE IF EXISTS `joomla_postinstall_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_postinstall_messages` (
  `postinstall_message_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `extension_id` bigint NOT NULL DEFAULT '700' COMMENT 'FK to #__extensions',
  `title_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Lang key for the title',
  `description_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Lang key for description',
  `action_key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `language_extension` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'com_postinstall' COMMENT 'Extension holding lang keys',
  `language_client_id` tinyint NOT NULL DEFAULT '1',
  `type` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'link' COMMENT 'Message type - message, link, action',
  `action_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'RAD URI to the PHP file containing action method',
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'Action method name or URL',
  `condition_file` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'RAD URI to file holding display condition method',
  `condition_method` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Display condition method, must return boolean',
  `version_introduced` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '3.2.0' COMMENT 'Version when this message was introduced',
  `enabled` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`postinstall_message_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_postinstall_messages`
--

/*!40000 ALTER TABLE `joomla_postinstall_messages` DISABLE KEYS */;
INSERT INTO `joomla_postinstall_messages` VALUES (1,700,'PLG_TWOFACTORAUTH_TOTP_POSTINSTALL_TITLE','PLG_TWOFACTORAUTH_TOTP_POSTINSTALL_BODY','PLG_TWOFACTORAUTH_TOTP_POSTINSTALL_ACTION','plg_twofactorauth_totp',1,'action','site://plugins/twofactorauth/totp/postinstall/actions.php','twofactorauth_postinstall_action','site://plugins/twofactorauth/totp/postinstall/actions.php','twofactorauth_postinstall_condition','3.2.0',1),(2,700,'COM_CPANEL_WELCOME_BEGINNERS_TITLE','COM_CPANEL_WELCOME_BEGINNERS_MESSAGE','','com_cpanel',1,'message','','','','','3.2.0',1),(3,700,'COM_CPANEL_MSG_STATS_COLLECTION_TITLE','COM_CPANEL_MSG_STATS_COLLECTION_BODY','','com_cpanel',1,'message','','','admin://components/com_admin/postinstall/statscollection.php','admin_postinstall_statscollection_condition','3.5.0',1),(4,700,'PLG_SYSTEM_UPDATENOTIFICATION_POSTINSTALL_UPDATECACHETIME','PLG_SYSTEM_UPDATENOTIFICATION_POSTINSTALL_UPDATECACHETIME_BODY','PLG_SYSTEM_UPDATENOTIFICATION_POSTINSTALL_UPDATECACHETIME_ACTION','plg_system_updatenotification',1,'action','site://plugins/system/updatenotification/postinstall/updatecachetime.php','updatecachetime_postinstall_action','site://plugins/system/updatenotification/postinstall/updatecachetime.php','updatecachetime_postinstall_condition','3.6.3',1),(5,700,'COM_CPANEL_MSG_JOOMLA40_PRE_CHECKS_TITLE','COM_CPANEL_MSG_JOOMLA40_PRE_CHECKS_BODY','','com_cpanel',1,'message','','','admin://components/com_admin/postinstall/joomla40checks.php','admin_postinstall_joomla40checks_condition','3.7.0',1),(6,700,'TPL_HATHOR_MESSAGE_POSTINSTALL_TITLE','TPL_HATHOR_MESSAGE_POSTINSTALL_BODY','TPL_HATHOR_MESSAGE_POSTINSTALL_ACTION','tpl_hathor',1,'action','admin://templates/hathor/postinstall/hathormessage.php','hathormessage_postinstall_action','admin://templates/hathor/postinstall/hathormessage.php','hathormessage_postinstall_condition','3.7.0',1),(7,700,'PLG_PLG_RECAPTCHA_VERSION_1_POSTINSTALL_TITLE','PLG_PLG_RECAPTCHA_VERSION_1_POSTINSTALL_BODY','PLG_PLG_RECAPTCHA_VERSION_1_POSTINSTALL_ACTION','plg_captcha_recaptcha',1,'action','site://plugins/captcha/recaptcha/postinstall/actions.php','recaptcha_postinstall_action','site://plugins/captcha/recaptcha/postinstall/actions.php','recaptcha_postinstall_condition','3.8.6',1),(8,700,'COM_ACTIONLOGS_POSTINSTALL_TITLE','COM_ACTIONLOGS_POSTINSTALL_BODY','','com_actionlogs',1,'message','','','','','3.9.0',1),(9,700,'COM_PRIVACY_POSTINSTALL_TITLE','COM_PRIVACY_POSTINSTALL_BODY','','com_privacy',1,'message','','','','','3.9.0',1),(10,700,'COM_CPANEL_MSG_TEXTFILTER3919_TITLE','COM_CPANEL_MSG_TEXTFILTER3919_BODY','','com_cpanel',1,'message','','','admin://components/com_admin/postinstall/textfilter3919.php','admin_postinstall_textfilter3919_condition','3.9.19',1),(11,700,'COM_CPANEL_MSG_HTACCESSSVG_TITLE','COM_CPANEL_MSG_HTACCESSSVG_BODY','','com_cpanel',1,'message','','','admin://components/com_admin/postinstall/htaccesssvg.php','admin_postinstall_htaccesssvg_condition','3.9.21',1),(12,700,'COM_ADMIN_POSTINSTALL_MSG_HTACCESS_AUTOINDEX_TITLE','COM_ADMIN_POSTINSTALL_MSG_HTACCESS_AUTOINDEX_DESCRIPTION','','com_admin',1,'message','','',NULL,NULL,'3.9.22',1),(13,700,'COM_ADMIN_POSTINSTALL_MSG_BEHIND_LOAD_BALANCER_TITLE','COM_ADMIN_POSTINSTALL_MSG_BEHIND_LOAD_BALANCER_DESCRIPTION','COM_ADMIN_POSTINSTALL_MSG_BEHIND_LOAD_BALANCER_ACTION','com_admin',1,'action','admin://components/com_admin/postinstall/behindproxy.php','behindproxy_postinstall_action','admin://components/com_admin/postinstall/behindproxy.php','admin_postinstall_behindproxy_condition','3.9.26',1);
/*!40000 ALTER TABLE `joomla_postinstall_messages` ENABLE KEYS */;

--
-- Table structure for table `joomla_privacy_consents`
--

DROP TABLE IF EXISTS `joomla_privacy_consents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_privacy_consents` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `state` int NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remind` tinyint NOT NULL DEFAULT '0',
  `token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_privacy_consents`
--

/*!40000 ALTER TABLE `joomla_privacy_consents` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_privacy_consents` ENABLE KEYS */;

--
-- Table structure for table `joomla_privacy_requests`
--

DROP TABLE IF EXISTS `joomla_privacy_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_privacy_requests` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `requested_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint NOT NULL DEFAULT '0',
  `request_type` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `confirm_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `confirm_token_created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_privacy_requests`
--

/*!40000 ALTER TABLE `joomla_privacy_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_privacy_requests` ENABLE KEYS */;

--
-- Table structure for table `joomla_redirect_links`
--

DROP TABLE IF EXISTS `joomla_redirect_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_redirect_links` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `old_url` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `new_url` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `referer` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `hits` int unsigned NOT NULL DEFAULT '0',
  `published` tinyint NOT NULL,
  `created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `header` smallint NOT NULL DEFAULT '301',
  PRIMARY KEY (`id`),
  KEY `idx_old_url` (`old_url`(100)),
  KEY `idx_link_modifed` (`modified_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_redirect_links`
--

/*!40000 ALTER TABLE `joomla_redirect_links` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_redirect_links` ENABLE KEYS */;

--
-- Table structure for table `joomla_schemas`
--

DROP TABLE IF EXISTS `joomla_schemas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_schemas` (
  `extension_id` int NOT NULL,
  `version_id` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`extension_id`,`version_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_schemas`
--

/*!40000 ALTER TABLE `joomla_schemas` DISABLE KEYS */;
INSERT INTO `joomla_schemas` VALUES (700,'3.10.7-2022-03-18');
/*!40000 ALTER TABLE `joomla_schemas` ENABLE KEYS */;

--
-- Table structure for table `joomla_session`
--

DROP TABLE IF EXISTS `joomla_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_session` (
  `session_id` varbinary(192) NOT NULL,
  `client_id` tinyint unsigned DEFAULT NULL,
  `guest` tinyint unsigned DEFAULT '1',
  `time` int NOT NULL DEFAULT '0',
  `data` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `userid` int DEFAULT '0',
  `username` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`session_id`),
  KEY `userid` (`userid`),
  KEY `time` (`time`),
  KEY `client_id_guest` (`client_id`,`guest`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_session`
--

/*!40000 ALTER TABLE `joomla_session` DISABLE KEYS */;
INSERT INTO `joomla_session` VALUES (0x3061686A36306869396D70673030317273663938766D366C6B6C,1,0,1734942518,'joomla|s:1956:\"TzoyNDoiSm9vbWxhXFJlZ2lzdHJ5XFJlZ2lzdHJ5IjozOntzOjc6IgAqAGRhdGEiO086ODoic3RkQ2xhc3MiOjE6e3M6OToiX19kZWZhdWx0IjtPOjg6InN0ZENsYXNzIjo0OntzOjc6InNlc3Npb24iO086ODoic3RkQ2xhc3MiOjM6e3M6NzoiY291bnRlciI7aTo2MjtzOjU6InRpbWVyIjtPOjg6InN0ZENsYXNzIjozOntzOjU6InN0YXJ0IjtpOjE3MzQ4ODY5MDY7czo0OiJsYXN0IjtpOjE3MzQ5NDI0OTc7czozOiJub3ciO2k6MTczNDk0MjUxNzt9czo1OiJ0b2tlbiI7czozMjoiYkhCdnM0Z1RidmVNaVNtRFJoYTRBRHF3SzFydUJaMjQiO31zOjg6InJlZ2lzdHJ5IjtPOjI0OiJKb29tbGFcUmVnaXN0cnlcUmVnaXN0cnkiOjM6e3M6NzoiACoAZGF0YSI7Tzo4OiJzdGRDbGFzcyI6NDp7czoxMzoiY29tX2luc3RhbGxlciI7Tzo4OiJzdGRDbGFzcyI6Mjp7czo3OiJtZXNzYWdlIjtzOjA6IiI7czoxNzoiZXh0ZW5zaW9uX21lc3NhZ2UiO3M6MDoiIjt9czo4OiJjb21fanVtaSI7Tzo4OiJzdGRDbGFzcyI6NTp7czoxMjoiZmlsdGVyX29yZGVyIjtzOjQ6Im0uaWQiO3M6MTY6ImZpbHRlcl9vcmRlcl9EaXIiO3M6MDoiIjtzOjEyOiJmaWx0ZXJfc3RhdGUiO3M6MDoiIjtzOjY6InNlYXJjaCI7czowOiIiO3M6NToibGltaXQiO2k6MjA7fXM6MjQ6ImNvbV9qdW1pc2hvd0FwcGxpY2F0aW9ucyI7Tzo4OiJzdGRDbGFzcyI6MTp7czoxMDoibGltaXRzdGFydCI7aToxNDA7fXM6OToiY29tX21lbnVzIjtPOjg6InN0ZENsYXNzIjoyOntzOjU6Iml0ZW1zIjtPOjg6InN0ZENsYXNzIjo3OntzOjg6Im1lbnV0eXBlIjtzOjY6ImhpZGRlbiI7czo5OiJjbGllbnRfaWQiO2k6MDtzOjEwOiJsaW1pdHN0YXJ0IjtpOjE0MDtzOjQ6Imxpc3QiO2E6Mjp7czoxMjoiZnVsbG9yZGVyaW5nIjtzOjk6ImEubGZ0IEFTQyI7czo1OiJsaW1pdCI7czoyOiIyMCI7fXM6Njoic2VhcmNoIjtzOjA6IiI7czo5OiJwdWJsaXNoZWQiO3M6MDoiIjtzOjY6ImZpbHRlciI7YTo2OntzOjY6InNlYXJjaCI7czowOiIiO3M6OToicHVibGlzaGVkIjtzOjA6IiI7czo2OiJhY2Nlc3MiO3M6MDoiIjtzOjg6Imxhbmd1YWdlIjtzOjA6IiI7czo1OiJsZXZlbCI7czowOiIiO3M6OToicGFyZW50X2lkIjtzOjA6IiI7fX1zOjQ6ImVkaXQiO086ODoic3RkQ2xhc3MiOjE6e3M6NDoiaXRlbSI7Tzo4OiJzdGRDbGFzcyI6NDp7czo0OiJkYXRhIjtOO3M6NDoidHlwZSI7TjtzOjQ6ImxpbmsiO047czoyOiJpZCI7YToxOntpOjA7aToyNDg7fX19fX1zOjE0OiIAKgBpbml0aWFsaXplZCI7YjowO3M6OToic2VwYXJhdG9yIjtzOjE6Ii4iO31zOjQ6InVzZXIiO086MjA6Ikpvb21sYVxDTVNcVXNlclxVc2VyIjoxOntzOjI6ImlkIjtzOjM6IjYzMiI7fXM6MTE6ImFwcGxpY2F0aW9uIjtPOjg6InN0ZENsYXNzIjoxOntzOjU6InF1ZXVlIjthOjA6e319fX1zOjE0OiIAKgBpbml0aWFsaXplZCI7YjowO3M6OToic2VwYXJhdG9yIjtzOjE6Ii4iO30=\";',632,'admin'),(0x386D613868326E633930386C333865627066393537396A687467,0,1,1734540244,'joomla|s:1068:\"TzoyNDoiSm9vbWxhXFJlZ2lzdHJ5XFJlZ2lzdHJ5IjozOntzOjc6IgAqAGRhdGEiO086ODoic3RkQ2xhc3MiOjE6e3M6OToiX19kZWZhdWx0IjtPOjg6InN0ZENsYXNzIjoxMTp7czo3OiJzZXNzaW9uIjtPOjg6InN0ZENsYXNzIjozOntzOjc6ImNvdW50ZXIiO2k6NztzOjU6InRpbWVyIjtPOjg6InN0ZENsYXNzIjozOntzOjU6InN0YXJ0IjtpOjE3MzQ1NDAyMTU7czo0OiJsYXN0IjtpOjE3MzQ1NDAyNDM7czozOiJub3ciO2k6MTczNDU0MDI0NDt9czo1OiJ0b2tlbiI7czozMjoiVkIxbTFldUpvbG9PQkpyVzJKekdITkZJMnpJUExHSFgiO31zOjg6InJlZ2lzdHJ5IjtPOjI0OiJKb29tbGFcUmVnaXN0cnlcUmVnaXN0cnkiOjM6e3M6NzoiACoAZGF0YSI7Tzo4OiJzdGRDbGFzcyI6MDp7fXM6MTQ6IgAqAGluaXRpYWxpemVkIjtiOjA7czo5OiJzZXBhcmF0b3IiO3M6MToiLiI7fXM6NDoidXNlciI7TzoyMDoiSm9vbWxhXENNU1xVc2VyXFVzZXIiOjE6e3M6MjoiaWQiO2k6MDt9czo4OiJ1c2VydHlwZSI7czo2OiJNZW1iZXIiO3M6MTI6ImFjY291bnRfdHlwZSI7czo5OiJhc3NvY2lhdGUiO3M6MTM6Im1lcmNoYW50X3R5cGUiO3M6Nzoic3RhcnRlciI7czo0OiJyYW5rIjtzOjk6ImFmZmlsaWF0ZSI7czo4OiJ1c2VybmFtZSI7czo1OiJ0ZXN0MSI7czo3OiJ1c2VyX2lkIjtzOjE6IjIiO3M6ODoiYXR0ZW1wdHMiO2k6MDtzOjExOiJhcHBsaWNhdGlvbiI7Tzo4OiJzdGRDbGFzcyI6MTp7czo1OiJxdWV1ZSI7YTowOnt9fX19czoxNDoiACoAaW5pdGlhbGl6ZWQiO2I6MDtzOjk6InNlcGFyYXRvciI7czoxOiIuIjt9\";',0,''),(0x646635686D396631666564636E34727239676239673536376975,0,1,1734326511,'joomla|s:996:\"TzoyNDoiSm9vbWxhXFJlZ2lzdHJ5XFJlZ2lzdHJ5IjozOntzOjc6IgAqAGRhdGEiO086ODoic3RkQ2xhc3MiOjE6e3M6OToiX19kZWZhdWx0IjtPOjg6InN0ZENsYXNzIjoxMDp7czo3OiJzZXNzaW9uIjtPOjg6InN0ZENsYXNzIjozOntzOjc6ImNvdW50ZXIiO2k6NTI7czo1OiJ0aW1lciI7Tzo4OiJzdGRDbGFzcyI6Mzp7czo1OiJzdGFydCI7aToxNzM0MzI1MDM4O3M6NDoibGFzdCI7aToxNzM0MzI2NDc5O3M6Mzoibm93IjtpOjE3MzQzMjY1MTE7fXM6NToidG9rZW4iO3M6MzI6ImJhYUdDcjBpZkFScFNMMHJUeGlaTmhKS0lERUkwbGxaIjt9czo4OiJyZWdpc3RyeSI7TzoyNDoiSm9vbWxhXFJlZ2lzdHJ5XFJlZ2lzdHJ5IjozOntzOjc6IgAqAGRhdGEiO086ODoic3RkQ2xhc3MiOjA6e31zOjE0OiIAKgBpbml0aWFsaXplZCI7YjowO3M6OToic2VwYXJhdG9yIjtzOjE6Ii4iO31zOjQ6InVzZXIiO086MjA6Ikpvb21sYVxDTVNcVXNlclxVc2VyIjoxOntzOjI6ImlkIjtpOjA7fXM6ODoidXNlcnR5cGUiO3M6NToiQWRtaW4iO3M6MTI6ImFjY291bnRfdHlwZSI7czo5OiJleGVjdXRpdmUiO3M6MTM6Im1lcmNoYW50X3R5cGUiO3M6OToiZXhlY3V0aXZlIjtzOjQ6InJhbmsiO3M6ODoiZGlyZWN0b3IiO3M6ODoidXNlcm5hbWUiO3M6NToiYWRtaW4iO3M6NzoidXNlcl9pZCI7czoxOiIxIjtzOjg6ImF0dGVtcHRzIjtpOjA7fX1zOjE0OiIAKgBpbml0aWFsaXplZCI7YjowO3M6OToic2VwYXJhdG9yIjtzOjE6Ii4iO30=\";',0,''),(0x68746F68377268313876726C346833396B6C63756E3874326230,0,1,1734532171,'joomla|s:1120:\"TzoyNDoiSm9vbWxhXFJlZ2lzdHJ5XFJlZ2lzdHJ5IjozOntzOjc6IgAqAGRhdGEiO086ODoic3RkQ2xhc3MiOjE6e3M6OToiX19kZWZhdWx0IjtPOjg6InN0ZENsYXNzIjoxMzp7czo3OiJzZXNzaW9uIjtPOjg6InN0ZENsYXNzIjozOntzOjc6ImNvdW50ZXIiO2k6Mzc7czo1OiJ0aW1lciI7Tzo4OiJzdGRDbGFzcyI6Mzp7czo1OiJzdGFydCI7aToxNzM0NDg2NTA1O3M6NDoibGFzdCI7aToxNzM0NTMyMTUwO3M6Mzoibm93IjtpOjE3MzQ1MzIxNzA7fXM6NToidG9rZW4iO3M6MzI6IjBaTWhSSldnOUkzdmprVGZrMDV0VEpqZDN1Y25yc3ZqIjt9czo4OiJyZWdpc3RyeSI7TzoyNDoiSm9vbWxhXFJlZ2lzdHJ5XFJlZ2lzdHJ5IjozOntzOjc6IgAqAGRhdGEiO086ODoic3RkQ2xhc3MiOjA6e31zOjE0OiIAKgBpbml0aWFsaXplZCI7YjowO3M6OToic2VwYXJhdG9yIjtzOjE6Ii4iO31zOjQ6InVzZXIiO086MjA6Ikpvb21sYVxDTVNcVXNlclxVc2VyIjoxOntzOjI6ImlkIjtpOjA7fXM6NDoiZWRpdCI7YjowO3M6ODoidXNlcnR5cGUiO3M6NjoiTWVtYmVyIjtzOjEyOiJhY2NvdW50X3R5cGUiO3M6OToiYXNzb2NpYXRlIjtzOjEzOiJtZXJjaGFudF90eXBlIjtzOjc6InN0YXJ0ZXIiO3M6NDoicmFuayI7czo5OiJhZmZpbGlhdGUiO3M6ODoidXNlcm5hbWUiO3M6NToidGVzdDEiO3M6NzoidXNlcl9pZCI7czoxOiIyIjtzOjg6ImF0dGVtcHRzIjtpOjA7czoxMToiYXBwbGljYXRpb24iO086ODoic3RkQ2xhc3MiOjE6e3M6NToicXVldWUiO2E6MDp7fX1zOjk6ImFkbWludHlwZSI7czowOiIiO319czoxNDoiACoAaW5pdGlhbGl6ZWQiO2I6MDtzOjk6InNlcGFyYXRvciI7czoxOiIuIjt9\";',0,''),(0x6C316C73656D3271376236757472366D6369313671336C63376B,0,1,1734502415,'joomla|s:1116:\"TzoyNDoiSm9vbWxhXFJlZ2lzdHJ5XFJlZ2lzdHJ5IjozOntzOjc6IgAqAGRhdGEiO086ODoic3RkQ2xhc3MiOjE6e3M6OToiX19kZWZhdWx0IjtPOjg6InN0ZENsYXNzIjoxMzp7czo3OiJzZXNzaW9uIjtPOjg6InN0ZENsYXNzIjozOntzOjc6ImNvdW50ZXIiO2k6NTgyO3M6NToidGltZXIiO086ODoic3RkQ2xhc3MiOjM6e3M6NToic3RhcnQiO2k6MTczNDQ4MDY3ODtzOjQ6Imxhc3QiO2k6MTczNDUwMjM4NDtzOjM6Im5vdyI7aToxNzM0NTAyNDE1O31zOjU6InRva2VuIjtzOjMyOiJSNW0yaWpBQWhMYzM0RTR5OWIwTXp3ZUhKajRMTUFBQyI7fXM6ODoicmVnaXN0cnkiO086MjQ6Ikpvb21sYVxSZWdpc3RyeVxSZWdpc3RyeSI6Mzp7czo3OiIAKgBkYXRhIjtPOjg6InN0ZENsYXNzIjowOnt9czoxNDoiACoAaW5pdGlhbGl6ZWQiO2I6MDtzOjk6InNlcGFyYXRvciI7czoxOiIuIjt9czo0OiJ1c2VyIjtPOjIwOiJKb29tbGFcQ01TXFVzZXJcVXNlciI6MTp7czoyOiJpZCI7aTowO31zOjg6ImF0dGVtcHRzIjtpOjA7czoxMToiYXBwbGljYXRpb24iO086ODoic3RkQ2xhc3MiOjE6e3M6NToicXVldWUiO2E6MDp7fX1zOjg6InVzZXJ0eXBlIjtzOjY6Ik1lbWJlciI7czoxMjoiYWNjb3VudF90eXBlIjtzOjU6ImJhc2ljIjtzOjEzOiJtZXJjaGFudF90eXBlIjtzOjc6InN0YXJ0ZXIiO3M6NDoicmFuayI7czo5OiJhZmZpbGlhdGUiO3M6ODoidXNlcm5hbWUiO3M6NToidGVzdDEiO3M6NzoidXNlcl9pZCI7czoxOiIyIjtzOjQ6ImVkaXQiO2I6MDtzOjk6ImFkbWludHlwZSI7czowOiIiO319czoxNDoiACoAaW5pdGlhbGl6ZWQiO2I6MDtzOjk6InNlcGFyYXRvciI7czoxOiIuIjt9\";',0,''),(0x7034357538376F6932683730313461686732336A686F3175366B,1,0,1734932182,'joomla|s:1436:\"TzoyNDoiSm9vbWxhXFJlZ2lzdHJ5XFJlZ2lzdHJ5IjozOntzOjc6IgAqAGRhdGEiO086ODoic3RkQ2xhc3MiOjE6e3M6OToiX19kZWZhdWx0IjtPOjg6InN0ZENsYXNzIjo0OntzOjc6InNlc3Npb24iO086ODoic3RkQ2xhc3MiOjM6e3M6NzoiY291bnRlciI7aToxNTtzOjU6InRpbWVyIjtPOjg6InN0ZENsYXNzIjozOntzOjU6InN0YXJ0IjtpOjE3MzQ5MzIwODQ7czo0OiJsYXN0IjtpOjE3MzQ5MzIxODE7czozOiJub3ciO2k6MTczNDkzMjE4MTt9czo1OiJ0b2tlbiI7czozMjoiYkdKckVhUzJPQ21iZjh0VjdPYkJmUFY1TEdWUnByTGwiO31zOjg6InJlZ2lzdHJ5IjtPOjI0OiJKb29tbGFcUmVnaXN0cnlcUmVnaXN0cnkiOjM6e3M6NzoiACoAZGF0YSI7Tzo4OiJzdGRDbGFzcyI6Mjp7czoxMzoiY29tX2luc3RhbGxlciI7Tzo4OiJzdGRDbGFzcyI6Mjp7czo3OiJtZXNzYWdlIjtzOjA6IiI7czoxNzoiZXh0ZW5zaW9uX21lc3NhZ2UiO3M6MDoiIjt9czo5OiJjb21fbWVudXMiO086ODoic3RkQ2xhc3MiOjI6e3M6NToiaXRlbXMiO086ODoic3RkQ2xhc3MiOjQ6e3M6ODoibWVudXR5cGUiO3M6ODoibWFpbm1lbnUiO3M6OToiY2xpZW50X2lkIjtpOjA7czoxMDoibGltaXRzdGFydCI7aTowO3M6NDoibGlzdCI7YTo0OntzOjk6ImRpcmVjdGlvbiI7czozOiJhc2MiO3M6NToibGltaXQiO3M6MjoiMjAiO3M6ODoib3JkZXJpbmciO3M6NToiYS5sZnQiO3M6NToic3RhcnQiO2Q6MDt9fXM6NDoiZWRpdCI7Tzo4OiJzdGRDbGFzcyI6MTp7czo0OiJpdGVtIjtPOjg6InN0ZENsYXNzIjo0OntzOjI6ImlkIjthOjE6e2k6MDtpOjEwMTt9czo0OiJkYXRhIjtOO3M6NDoidHlwZSI7TjtzOjQ6ImxpbmsiO047fX19fXM6MTQ6IgAqAGluaXRpYWxpemVkIjtiOjA7czo5OiJzZXBhcmF0b3IiO3M6MToiLiI7fXM6NDoidXNlciI7TzoyMDoiSm9vbWxhXENNU1xVc2VyXFVzZXIiOjE6e3M6MjoiaWQiO3M6MzoiNjMyIjt9czoxMToiYXBwbGljYXRpb24iO086ODoic3RkQ2xhc3MiOjE6e3M6NToicXVldWUiO2E6MDp7fX19fXM6MTQ6IgAqAGluaXRpYWxpemVkIjtiOjA7czo5OiJzZXBhcmF0b3IiO3M6MToiLiI7fQ==\";',632,'admin'),(0x72363574703576353639756B38656A726534646876356C723264,0,1,1734943458,'joomla|s:1236:\"TzoyNDoiSm9vbWxhXFJlZ2lzdHJ5XFJlZ2lzdHJ5IjozOntzOjc6IgAqAGRhdGEiO086ODoic3RkQ2xhc3MiOjE6e3M6OToiX19kZWZhdWx0IjtPOjg6InN0ZENsYXNzIjoxNjp7czo3OiJzZXNzaW9uIjtPOjg6InN0ZENsYXNzIjozOntzOjc6ImNvdW50ZXIiO2k6NDQ2OTtzOjU6InRpbWVyIjtPOjg6InN0ZENsYXNzIjozOntzOjU6InN0YXJ0IjtpOjE3MzQzMjcwMTU7czo0OiJsYXN0IjtpOjE3MzQ5NDMxNzI7czozOiJub3ciO2k6MTczNDk0MzQ1ODt9czo1OiJ0b2tlbiI7czozMjoiU0VMdDNQNEdNZFgyTmhYQ0xVWmN2eUlYM0I3TXZGVVoiO31zOjg6InJlZ2lzdHJ5IjtPOjI0OiJKb29tbGFcUmVnaXN0cnlcUmVnaXN0cnkiOjM6e3M6NzoiACoAZGF0YSI7Tzo4OiJzdGRDbGFzcyI6MDp7fXM6MTQ6IgAqAGluaXRpYWxpemVkIjtiOjA7czo5OiJzZXBhcmF0b3IiO3M6MToiLiI7fXM6NDoidXNlciI7TzoyMDoiSm9vbWxhXENNU1xVc2VyXFVzZXIiOjE6e3M6MjoiaWQiO2k6MDt9czo4OiJ1c2VydHlwZSI7czo1OiJBZG1pbiI7czoxMjoiYWNjb3VudF90eXBlIjtzOjk6ImV4ZWN1dGl2ZSI7czoxMzoibWVyY2hhbnRfdHlwZSI7czo5OiJleGVjdXRpdmUiO3M6NDoicmFuayI7czo4OiJkaXJlY3RvciI7czo4OiJ1c2VybmFtZSI7czo1OiJhZG1pbiI7czo3OiJ1c2VyX2lkIjtzOjE6IjEiO3M6ODoiYXR0ZW1wdHMiO2k6MDtzOjk6ImFkbWludHlwZSI7czo1OiJTdXBlciI7czo0OiJlZGl0IjtiOjA7czoxMToiYXBwbGljYXRpb24iO086ODoic3RkQ2xhc3MiOjE6e3M6NToicXVldWUiO2E6MDp7fX1zOjEwOiJzX3VzZXJuYW1lIjtzOjU6InRlc3QxIjtzOjc6InNfZW1haWwiO3M6MToiMSI7czoxMDoic19wYXNzd29yZCI7czoxOiIxIjt9fXM6MTQ6IgAqAGluaXRpYWxpemVkIjtiOjA7czo5OiJzZXBhcmF0b3IiO3M6MToiLiI7fQ==\";',0,''),(0x763731316E7031346463696838766D6E6B636867377572333830,0,1,1734943209,'joomla|s:1228:\"TzoyNDoiSm9vbWxhXFJlZ2lzdHJ5XFJlZ2lzdHJ5IjozOntzOjc6IgAqAGRhdGEiO086ODoic3RkQ2xhc3MiOjE6e3M6OToiX19kZWZhdWx0IjtPOjg6InN0ZENsYXNzIjoxNjp7czo3OiJzZXNzaW9uIjtPOjg6InN0ZENsYXNzIjozOntzOjc6ImNvdW50ZXIiO2k6MzUzO3M6NToidGltZXIiO086ODoic3RkQ2xhc3MiOjM6e3M6NToic3RhcnQiO2k6MTczNDkwODc0MTtzOjQ6Imxhc3QiO2k6MTczNDk0MzE3ODtzOjM6Im5vdyI7aToxNzM0OTQzMjA5O31zOjU6InRva2VuIjtzOjMyOiJhTGwyaXc4YjRySXhvakxOYkJIUzdKQ0lMUkhobHVobCI7fXM6ODoicmVnaXN0cnkiO086MjQ6Ikpvb21sYVxSZWdpc3RyeVxSZWdpc3RyeSI6Mzp7czo3OiIAKgBkYXRhIjtPOjg6InN0ZENsYXNzIjowOnt9czoxNDoiACoAaW5pdGlhbGl6ZWQiO2I6MDtzOjk6InNlcGFyYXRvciI7czoxOiIuIjt9czo0OiJ1c2VyIjtPOjIwOiJKb29tbGFcQ01TXFVzZXJcVXNlciI6MTp7czoyOiJpZCI7aTowO31zOjQ6ImVkaXQiO2I6MDtzOjg6InVzZXJ0eXBlIjtzOjY6Ik1lbWJlciI7czoxMjoiYWNjb3VudF90eXBlIjtzOjk6ImFzc29jaWF0ZSI7czoxMzoibWVyY2hhbnRfdHlwZSI7czo3OiJzdGFydGVyIjtzOjQ6InJhbmsiO3M6OToiYWZmaWxpYXRlIjtzOjg6InVzZXJuYW1lIjtzOjU6InRlc3QxIjtzOjc6InVzZXJfaWQiO3M6MToiMiI7czo4OiJhdHRlbXB0cyI7aTowO3M6MTE6ImFwcGxpY2F0aW9uIjtPOjg6InN0ZENsYXNzIjoxOntzOjU6InF1ZXVlIjthOjA6e319czo5OiJhZG1pbnR5cGUiO3M6MDoiIjtzOjEwOiJzX3VzZXJuYW1lIjtzOjU6InRlc3QyIjtzOjc6InNfZW1haWwiO3M6MToiMSI7czoxMDoic19wYXNzd29yZCI7czoxOiIxIjt9fXM6MTQ6IgAqAGluaXRpYWxpemVkIjtiOjA7czo5OiJzZXBhcmF0b3IiO3M6MToiLiI7fQ==\";',0,'');
/*!40000 ALTER TABLE `joomla_session` ENABLE KEYS */;

--
-- Table structure for table `joomla_tags`
--

DROP TABLE IF EXISTS `joomla_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_tags` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int unsigned NOT NULL DEFAULT '0',
  `lft` int NOT NULL DEFAULT '0',
  `rgt` int NOT NULL DEFAULT '0',
  `level` int unsigned NOT NULL DEFAULT '0',
  `path` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `access` int unsigned NOT NULL DEFAULT '0',
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `metadesc` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The meta description for the page.',
  `metakey` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'The meta keywords for the page.',
  `metadata` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'JSON encoded metadata properties.',
  `created_user_id` int unsigned NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by_alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `modified_user_id` int unsigned NOT NULL DEFAULT '0',
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `urls` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `hits` int unsigned NOT NULL DEFAULT '0',
  `language` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` int unsigned NOT NULL DEFAULT '1',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `tag_idx` (`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_path` (`path`(100)),
  KEY `idx_left_right` (`lft`,`rgt`),
  KEY `idx_alias` (`alias`(100)),
  KEY `idx_language` (`language`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_tags`
--

/*!40000 ALTER TABLE `joomla_tags` DISABLE KEYS */;
INSERT INTO `joomla_tags` VALUES (1,0,0,1,0,'','ROOT','root','','',1,0,'0000-00-00 00:00:00',1,'','','','',632,'2019-07-26 06:28:42','',0,'0000-00-00 00:00:00','','',0,'*',1,'0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `joomla_tags` ENABLE KEYS */;

--
-- Table structure for table `joomla_template_styles`
--

DROP TABLE IF EXISTS `joomla_template_styles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_template_styles` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `template` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `client_id` tinyint unsigned NOT NULL DEFAULT '0',
  `home` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `inheritable` tinyint NOT NULL DEFAULT '0',
  `parent` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `idx_template` (`template`),
  KEY `idx_client_id` (`client_id`),
  KEY `idx_client_id_home` (`client_id`,`home`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_template_styles`
--

/*!40000 ALTER TABLE `joomla_template_styles` DISABLE KEYS */;
INSERT INTO `joomla_template_styles` VALUES (4,'beez3',0,'0','Beez3 - Default','{\"wrapperSmall\":\"53\",\"wrapperLarge\":\"72\",\"logo\":\"images\\/joomla_black.png\",\"sitetitle\":\"Joomla!\",\"sitedescription\":\"Open Source Content Management\",\"navposition\":\"left\",\"templatecolor\":\"personal\",\"html5\":\"0\"}',0,''),(5,'hathor',1,'0','Hathor - Default','{\"showSiteName\":\"0\",\"colourChoice\":\"\",\"boldText\":\"0\"}',0,''),(7,'protostar',0,'0','protostar - Default','{\"templateColor\":\"\",\"logoFile\":\"\",\"googleFont\":\"1\",\"googleFontName\":\"Open+Sans\",\"fluidContainer\":\"0\"}',0,''),(8,'isis',1,'1','isis - Default','{\"templateColor\":\"\",\"logoFile\":\"\"}',0,''),(9,'yoo_master2',0,'1','yoo_master2 - Default','{\"config\":\"\"}',0,'');
/*!40000 ALTER TABLE `joomla_template_styles` ENABLE KEYS */;

--
-- Table structure for table `joomla_ucm_base`
--

DROP TABLE IF EXISTS `joomla_ucm_base`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_ucm_base` (
  `ucm_id` int unsigned NOT NULL,
  `ucm_item_id` int NOT NULL,
  `ucm_type_id` int NOT NULL,
  `ucm_language_id` int NOT NULL,
  PRIMARY KEY (`ucm_id`),
  KEY `idx_ucm_item_id` (`ucm_item_id`),
  KEY `idx_ucm_type_id` (`ucm_type_id`),
  KEY `idx_ucm_language_id` (`ucm_language_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_ucm_base`
--

/*!40000 ALTER TABLE `joomla_ucm_base` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_ucm_base` ENABLE KEYS */;

--
-- Table structure for table `joomla_ucm_content`
--

DROP TABLE IF EXISTS `joomla_ucm_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_ucm_content` (
  `core_content_id` int unsigned NOT NULL AUTO_INCREMENT,
  `core_type_alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'FK to the content types table',
  `core_title` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `core_alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '',
  `core_body` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `core_state` tinyint(1) NOT NULL DEFAULT '0',
  `core_checked_out_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0000-00-00 00:00:00',
  `core_checked_out_user_id` int unsigned NOT NULL DEFAULT '0',
  `core_access` int unsigned NOT NULL DEFAULT '0',
  `core_params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `core_featured` tinyint unsigned NOT NULL DEFAULT '0',
  `core_metadata` varchar(2048) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'JSON encoded metadata properties.',
  `core_created_user_id` int unsigned NOT NULL DEFAULT '0',
  `core_created_by_alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `core_created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `core_modified_user_id` int unsigned NOT NULL DEFAULT '0' COMMENT 'Most recent user that modified',
  `core_modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `core_language` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `core_publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `core_publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `core_content_item_id` int unsigned NOT NULL DEFAULT '0' COMMENT 'ID from the individual type table',
  `asset_id` int unsigned NOT NULL DEFAULT '0' COMMENT 'FK to the #__assets table.',
  `core_images` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `core_urls` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `core_hits` int unsigned NOT NULL DEFAULT '0',
  `core_version` int unsigned NOT NULL DEFAULT '1',
  `core_ordering` int NOT NULL DEFAULT '0',
  `core_metakey` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `core_metadesc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `core_catid` int unsigned NOT NULL DEFAULT '0',
  `core_xreference` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'A reference to enable linkages to external data sets.',
  `core_type_id` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`core_content_id`),
  KEY `tag_idx` (`core_state`,`core_access`),
  KEY `idx_access` (`core_access`),
  KEY `idx_alias` (`core_alias`(100)),
  KEY `idx_language` (`core_language`),
  KEY `idx_title` (`core_title`(100)),
  KEY `idx_modified_time` (`core_modified_time`),
  KEY `idx_created_time` (`core_created_time`),
  KEY `idx_content_type` (`core_type_alias`(100)),
  KEY `idx_core_modified_user_id` (`core_modified_user_id`),
  KEY `idx_core_checked_out_user_id` (`core_checked_out_user_id`),
  KEY `idx_core_created_user_id` (`core_created_user_id`),
  KEY `idx_core_type_id` (`core_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Contains core content data in name spaced fields';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_ucm_content`
--

/*!40000 ALTER TABLE `joomla_ucm_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_ucm_content` ENABLE KEYS */;

--
-- Table structure for table `joomla_ucm_history`
--

DROP TABLE IF EXISTS `joomla_ucm_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_ucm_history` (
  `version_id` int unsigned NOT NULL AUTO_INCREMENT,
  `ucm_item_id` int unsigned NOT NULL,
  `ucm_type_id` int unsigned NOT NULL,
  `version_note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Optional version name',
  `save_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `editor_user_id` int unsigned NOT NULL DEFAULT '0',
  `character_count` int unsigned NOT NULL DEFAULT '0' COMMENT 'Number of characters in this version.',
  `sha1_hash` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'SHA1 hash of the version_data column.',
  `version_data` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'json-encoded string of version data',
  `keep_forever` tinyint NOT NULL DEFAULT '0' COMMENT '0=auto delete; 1=keep',
  PRIMARY KEY (`version_id`),
  KEY `idx_ucm_item_id` (`ucm_type_id`,`ucm_item_id`),
  KEY `idx_save_date` (`save_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_ucm_history`
--

/*!40000 ALTER TABLE `joomla_ucm_history` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_ucm_history` ENABLE KEYS */;

--
-- Table structure for table `joomla_update_sites`
--

DROP TABLE IF EXISTS `joomla_update_sites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_update_sites` (
  `update_site_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `location` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `enabled` int DEFAULT '0',
  `last_check_timestamp` bigint DEFAULT '0',
  `extra_query` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`update_site_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Update Sites';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_update_sites`
--

/*!40000 ALTER TABLE `joomla_update_sites` DISABLE KEYS */;
INSERT INTO `joomla_update_sites` VALUES (1,'Joomla! Core','collection','https://update.joomla.org/core/list.xml',0,1690176439,''),(2,'Accredited Joomla! Translations','collection','https://update.joomla.org/language/translationlist_3.xml',1,1734932095,''),(3,'Joomla! Update Component Update Site','extension','https://update.joomla.org/core/extensions/com_joomlaupdate.xml',1,1734932095,''),(4,'WebInstaller Update Site','extension','https://appscdn.joomla.org/webapps/jedapps/webinstaller.xml',1,1734932096,''),(5,'Regular Labs Library','extension','https://download.regularlabs.com/updates.xml?e=library&type=.xml',1,1734932098,''),(6,'Regular Labs - Sourcerer','extension','https://download.regularlabs.com/updates.xml?e=sourcerer&type=.xml',1,1734932100,'');
/*!40000 ALTER TABLE `joomla_update_sites` ENABLE KEYS */;

--
-- Table structure for table `joomla_update_sites_extensions`
--

DROP TABLE IF EXISTS `joomla_update_sites_extensions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_update_sites_extensions` (
  `update_site_id` int NOT NULL DEFAULT '0',
  `extension_id` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`update_site_id`,`extension_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Links extensions to update sites';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_update_sites_extensions`
--

/*!40000 ALTER TABLE `joomla_update_sites_extensions` DISABLE KEYS */;
INSERT INTO `joomla_update_sites_extensions` VALUES (1,700),(2,802),(3,28),(4,10006),(5,10008),(5,10009),(5,10014),(6,10011),(6,10012),(6,10015);
/*!40000 ALTER TABLE `joomla_update_sites_extensions` ENABLE KEYS */;

--
-- Table structure for table `joomla_updates`
--

DROP TABLE IF EXISTS `joomla_updates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_updates` (
  `update_id` int NOT NULL AUTO_INCREMENT,
  `update_site_id` int DEFAULT '0',
  `extension_id` int DEFAULT '0',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `element` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `folder` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `client_id` tinyint DEFAULT '0',
  `version` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `detailsurl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `infourl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra_query` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`update_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1118 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Available Updates';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_updates`
--

/*!40000 ALTER TABLE `joomla_updates` DISABLE KEYS */;
INSERT INTO `joomla_updates` VALUES (1039,2,0,'Afrikaans','','pkg_af-ZA','package','',0,'3.9.16.1','','https://update.joomla.org/language/details3/af-ZA_details.xml','',''),(1040,2,0,'Albanian','','pkg_sq-AL','package','',0,'3.1.1.2','','https://update.joomla.org/language/details3/sq-AL_details.xml','',''),(1041,2,0,'Arabic Unitag','','pkg_ar-AA','package','',0,'3.9.27.1','','https://update.joomla.org/language/details3/ar-AA_details.xml','',''),(1042,2,0,'Armenian','','pkg_hy-AM','package','',0,'3.4.4.1','','https://update.joomla.org/language/details3/hy-AM_details.xml','',''),(1043,2,0,'Basque','','pkg_eu-ES','package','',0,'3.9.24.1','','https://update.joomla.org/language/details3/eu-ES_details.xml','',''),(1044,2,0,'Belarusian','','pkg_be-BY','package','',0,'3.2.1.2','','https://update.joomla.org/language/details3/be-BY_details.xml','',''),(1045,2,0,'Bengali, Bangladesh','','pkg_bn-BD','package','',0,'3.8.10.1','','https://update.joomla.org/language/details3/bn-BD_details.xml','',''),(1046,2,0,'Bosnian','','pkg_bs-BA','package','',0,'3.9.24.1','','https://update.joomla.org/language/details3/bs-BA_details.xml','',''),(1047,2,0,'Bulgarian','','pkg_bg-BG','package','',0,'3.6.5.2','','https://update.joomla.org/language/details3/bg-BG_details.xml','',''),(1048,2,0,'Catalan','','pkg_ca-ES','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/ca-ES_details.xml','',''),(1049,2,0,'Chinese, Simplified','','pkg_zh-CN','package','',0,'3.10.6.1','','https://update.joomla.org/language/details3/zh-CN_details.xml','',''),(1050,2,0,'Chinese, Traditional','','pkg_zh-TW','package','',0,'3.8.0.1','','https://update.joomla.org/language/details3/zh-TW_details.xml','',''),(1051,2,0,'Croatian','','pkg_hr-HR','package','',0,'3.10.11.1','','https://update.joomla.org/language/details3/hr-HR_details.xml','',''),(1052,2,0,'Czech','','pkg_cs-CZ','package','',0,'3.10.11.1','','https://update.joomla.org/language/details3/cs-CZ_details.xml','',''),(1053,2,0,'Danish','','pkg_da-DK','package','',0,'3.10.10.1','','https://update.joomla.org/language/details3/da-DK_details.xml','',''),(1054,2,0,'Dari Persian','','pkg_prs-AF','package','',0,'3.4.4.3','','https://update.joomla.org/language/details3/prs-AF_details.xml','',''),(1055,2,0,'Dutch','','pkg_nl-NL','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/nl-NL_details.xml','',''),(1056,2,0,'Dzongkha','','pkg_dz-BT','package','',0,'3.6.2.1','','https://update.joomla.org/language/details3/dz-BT_details.xml','',''),(1057,2,0,'English, Australia','','pkg_en-AU','package','',0,'3.9.28.1','','https://update.joomla.org/language/details3/en-AU_details.xml','',''),(1058,2,0,'English, Canada','','pkg_en-CA','package','',0,'3.9.28.1','','https://update.joomla.org/language/details3/en-CA_details.xml','',''),(1059,2,0,'English, New Zealand','','pkg_en-NZ','package','',0,'3.9.28.1','','https://update.joomla.org/language/details3/en-NZ_details.xml','',''),(1060,2,0,'English, USA','','pkg_en-US','package','',0,'3.9.28.1','','https://update.joomla.org/language/details3/en-US_details.xml','',''),(1061,2,0,'Esperanto','','pkg_eo-XX','package','',0,'3.8.11.1','','https://update.joomla.org/language/details3/eo-XX_details.xml','',''),(1062,2,0,'Estonian','','pkg_et-EE','package','',0,'3.9.21.1','','https://update.joomla.org/language/details3/et-EE_details.xml','',''),(1063,2,0,'Finnish','','pkg_fi-FI','package','',0,'3.9.16.1','','https://update.joomla.org/language/details3/fi-FI_details.xml','',''),(1064,2,0,'Flemish','','pkg_nl-BE','package','',0,'3.10.11.1','','https://update.joomla.org/language/details3/nl-BE_details.xml','',''),(1065,2,0,'French','','pkg_fr-FR','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/fr-FR_details.xml','',''),(1066,2,0,'French, Canada','','pkg_fr-CA','package','',0,'3.6.5.1','','https://update.joomla.org/language/details3/fr-CA_details.xml','',''),(1067,2,0,'Galician','','pkg_gl-ES','package','',0,'3.3.1.2','','https://update.joomla.org/language/details3/gl-ES_details.xml','',''),(1068,2,0,'Georgian','','pkg_ka-GE','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/ka-GE_details.xml','',''),(1069,2,0,'German','','pkg_de-DE','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/de-DE_details.xml','',''),(1070,2,0,'German, Austria','','pkg_de-AT','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/de-AT_details.xml','',''),(1071,2,0,'German, Liechtenstein','','pkg_de-LI','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/de-LI_details.xml','',''),(1072,2,0,'German, Luxembourg','','pkg_de-LU','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/de-LU_details.xml','',''),(1073,2,0,'German, Switzerland','','pkg_de-CH','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/de-CH_details.xml','',''),(1074,2,0,'Greek','','pkg_el-GR','package','',0,'3.10.11.1','','https://update.joomla.org/language/details3/el-GR_details.xml','',''),(1075,2,0,'Hebrew','','pkg_he-IL','package','',0,'3.1.1.2','','https://update.joomla.org/language/details3/he-IL_details.xml','',''),(1076,2,0,'Hindi, India','','pkg_hi-IN','package','',0,'3.3.6.2','','https://update.joomla.org/language/details3/hi-IN_details.xml','',''),(1077,2,0,'Hungarian','','pkg_hu-HU','package','',0,'3.10.12.2','','https://update.joomla.org/language/details3/hu-HU_details.xml','',''),(1078,2,0,'Indonesian, Bahasa Indonesia','','pkg_id-ID','package','',0,'3.6.2.1','','https://update.joomla.org/language/details3/id-ID_details.xml','',''),(1079,2,0,'Irish','','pkg_ga-IE','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/ga-IE_details.xml','',''),(1080,2,0,'Italian','','pkg_it-IT','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/it-IT_details.xml','',''),(1081,2,0,'Japanese','','pkg_ja-JP','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/ja-JP_details.xml','',''),(1082,2,0,'Kazakh','','pkg_kk-KZ','package','',0,'3.9.23.1','','https://update.joomla.org/language/details3/kk-KZ_details.xml','',''),(1083,2,0,'Khmer','','pkg_km-KH','package','',0,'3.4.5.1','','https://update.joomla.org/language/details3/km-KH_details.xml','',''),(1084,2,0,'Korean','','pkg_ko-KR','package','',0,'3.8.9.1','','https://update.joomla.org/language/details3/ko-KR_details.xml','',''),(1085,2,0,'Latvian','','pkg_lv-LV','package','',0,'3.9.25.2','','https://update.joomla.org/language/details3/lv-LV_details.xml','',''),(1086,2,0,'Lithuanian','','pkg_lt-LT','package','',0,'3.9.16.1','','https://update.joomla.org/language/details3/lt-LT_details.xml','',''),(1087,2,0,'Macedonian','','pkg_mk-MK','package','',0,'3.6.5.1','','https://update.joomla.org/language/details3/mk-MK_details.xml','',''),(1088,2,0,'Malay','','pkg_ms-MY','package','',0,'3.4.1.2','','https://update.joomla.org/language/details3/ms-MY_details.xml','',''),(1089,2,0,'Montenegrin','','pkg_srp-ME','package','',0,'3.3.1.2','','https://update.joomla.org/language/details3/srp-ME_details.xml','',''),(1090,2,0,'Norwegian Bokmål','','pkg_nb-NO','package','',0,'3.10.12.2','','https://update.joomla.org/language/details3/nb-NO_details.xml','',''),(1091,2,0,'Norwegian Nynorsk','','pkg_nn-NO','package','',0,'3.4.2.1','','https://update.joomla.org/language/details3/nn-NO_details.xml','',''),(1092,2,0,'Persian Farsi','','pkg_fa-IR','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/fa-IR_details.xml','',''),(1093,2,0,'Polish','','pkg_pl-PL','package','',0,'3.10.10.1','','https://update.joomla.org/language/details3/pl-PL_details.xml','',''),(1094,2,0,'Portuguese, Brazil','','pkg_pt-BR','package','',0,'3.9.21.1','','https://update.joomla.org/language/details3/pt-BR_details.xml','',''),(1095,2,0,'Portuguese, Portugal','','pkg_pt-PT','package','',0,'3.10.12.3','','https://update.joomla.org/language/details3/pt-PT_details.xml','',''),(1096,2,0,'Romanian','','pkg_ro-RO','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/ro-RO_details.xml','',''),(1097,2,0,'Russian','','pkg_ru-RU','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/ru-RU_details.xml','',''),(1098,2,0,'Serbian, Cyrillic','','pkg_sr-RS','package','',0,'3.10.2.1','','https://update.joomla.org/language/details3/sr-RS_details.xml','',''),(1099,2,0,'Serbian, Latin','','pkg_sr-YU','package','',0,'3.10.2.1','','https://update.joomla.org/language/details3/sr-YU_details.xml','',''),(1100,2,0,'Sinhala','','pkg_si-LK','package','',0,'3.3.1.2','','https://update.joomla.org/language/details3/si-LK_details.xml','',''),(1101,2,0,'Slovak','','pkg_sk-SK','package','',0,'3.10.5.1','','https://update.joomla.org/language/details3/sk-SK_details.xml','',''),(1102,2,0,'Slovenian','','pkg_sl-SI','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/sl-SI_details.xml','',''),(1103,2,0,'Spanish','','pkg_es-ES','package','',0,'3.10.10.1','','https://update.joomla.org/language/details3/es-ES_details.xml','',''),(1104,2,0,'Spanish, Colombia','','pkg_es-CO','package','',0,'3.9.15.1','','https://update.joomla.org/language/details3/es-CO_details.xml','',''),(1105,2,0,'Swahili','','pkg_sw-KE','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/sw-KE_details.xml','',''),(1106,2,0,'Swedish','','pkg_sv-SE','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/sv-SE_details.xml','',''),(1107,2,0,'Syriac, East','','pkg_sy-IQ','package','',0,'3.4.5.1','','https://update.joomla.org/language/details3/sy-IQ_details.xml','',''),(1108,2,0,'Tamil, India','','pkg_ta-IN','package','',0,'3.10.11.1','','https://update.joomla.org/language/details3/ta-IN_details.xml','',''),(1109,2,0,'Thai','','pkg_th-TH','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/th-TH_details.xml','',''),(1110,2,0,'Turkish','','pkg_tr-TR','package','',0,'3.9.28.1','','https://update.joomla.org/language/details3/tr-TR_details.xml','',''),(1111,2,0,'Turkmen','','pkg_tk-TM','package','',0,'3.5.0.2','','https://update.joomla.org/language/details3/tk-TM_details.xml','',''),(1112,2,0,'Ukrainian','','pkg_uk-UA','package','',0,'3.10.2.1','','https://update.joomla.org/language/details3/uk-UA_details.xml','',''),(1113,2,0,'Uyghur','','pkg_ug-CN','package','',0,'3.7.5.2','','https://update.joomla.org/language/details3/ug-CN_details.xml','',''),(1114,2,0,'Vietnamese','','pkg_vi-VN','package','',0,'3.2.1.2','','https://update.joomla.org/language/details3/vi-VN_details.xml','',''),(1115,2,0,'Welsh','','pkg_cy-GB','package','',0,'3.10.12.1','','https://update.joomla.org/language/details3/cy-GB_details.xml','',''),(1116,5,0,'Regular Labs - Regular Labs Library','','library','library','',0,'21.8.0','','https://download.regularlabs.com/updates.xml?e=library&type=.xml','',''),(1117,6,10012,'Regular Labs - Sourcerer','','sourcerer','plugin','system',0,'9.8.0','','https://download.regularlabs.com/updates.xml?e=sourcerer&type=.xml','https://www.regularlabs.com/sourcerer/download','');
/*!40000 ALTER TABLE `joomla_updates` ENABLE KEYS */;

--
-- Table structure for table `joomla_user_keys`
--

DROP TABLE IF EXISTS `joomla_user_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_user_keys` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `series` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `invalid` tinyint NOT NULL,
  `time` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `uastring` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `series` (`series`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_user_keys`
--

/*!40000 ALTER TABLE `joomla_user_keys` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_user_keys` ENABLE KEYS */;

--
-- Table structure for table `joomla_user_notes`
--

DROP TABLE IF EXISTS `joomla_user_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_user_notes` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int unsigned NOT NULL DEFAULT '0',
  `catid` int unsigned NOT NULL DEFAULT '0',
  `subject` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` tinyint NOT NULL DEFAULT '0',
  `checked_out` int unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_user_id` int unsigned NOT NULL DEFAULT '0',
  `created_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_user_id` int unsigned NOT NULL,
  `modified_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `review_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_category_id` (`catid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_user_notes`
--

/*!40000 ALTER TABLE `joomla_user_notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_user_notes` ENABLE KEYS */;

--
-- Table structure for table `joomla_user_profiles`
--

DROP TABLE IF EXISTS `joomla_user_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_user_profiles` (
  `user_id` int NOT NULL,
  `profile_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordering` int NOT NULL DEFAULT '0',
  UNIQUE KEY `idx_user_id_profile_key` (`user_id`,`profile_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Simple user profile storage table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_user_profiles`
--

/*!40000 ALTER TABLE `joomla_user_profiles` DISABLE KEYS */;
/*!40000 ALTER TABLE `joomla_user_profiles` ENABLE KEYS */;

--
-- Table structure for table `joomla_user_usergroup_map`
--

DROP TABLE IF EXISTS `joomla_user_usergroup_map`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_user_usergroup_map` (
  `user_id` int unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__users.id',
  `group_id` int unsigned NOT NULL DEFAULT '0' COMMENT 'Foreign Key to #__usergroups.id',
  PRIMARY KEY (`user_id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_user_usergroup_map`
--

/*!40000 ALTER TABLE `joomla_user_usergroup_map` DISABLE KEYS */;
INSERT INTO `joomla_user_usergroup_map` VALUES (632,8);
/*!40000 ALTER TABLE `joomla_user_usergroup_map` ENABLE KEYS */;

--
-- Table structure for table `joomla_usergroups`
--

DROP TABLE IF EXISTS `joomla_usergroups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_usergroups` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `parent_id` int unsigned NOT NULL DEFAULT '0' COMMENT 'Adjacency List Reference Id',
  `lft` int NOT NULL DEFAULT '0' COMMENT 'Nested set lft.',
  `rgt` int NOT NULL DEFAULT '0' COMMENT 'Nested set rgt.',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_usergroup_parent_title_lookup` (`parent_id`,`title`),
  KEY `idx_usergroup_title_lookup` (`title`),
  KEY `idx_usergroup_adjacency_lookup` (`parent_id`),
  KEY `idx_usergroup_nested_set_lookup` (`lft`,`rgt`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_usergroups`
--

/*!40000 ALTER TABLE `joomla_usergroups` DISABLE KEYS */;
INSERT INTO `joomla_usergroups` VALUES (1,0,1,18,'Public'),(2,1,8,15,'Registered'),(3,2,9,14,'Author'),(4,3,10,13,'Editor'),(5,4,11,12,'Publisher'),(6,1,4,7,'Manager'),(7,6,5,6,'Administrator'),(8,1,16,17,'Super Users'),(9,1,2,3,'Guest');
/*!40000 ALTER TABLE `joomla_usergroups` ENABLE KEYS */;

--
-- Table structure for table `joomla_users`
--

DROP TABLE IF EXISTS `joomla_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `username` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `block` tinyint NOT NULL DEFAULT '0',
  `sendEmail` tinyint DEFAULT '0',
  `registerDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastResetTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Date of last password reset',
  `resetCount` int NOT NULL DEFAULT '0' COMMENT 'Count of password resets since lastResetTime',
  `otpKey` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Two factor authentication encrypted keys',
  `otep` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'One time emergency passwords',
  `requireReset` tinyint NOT NULL DEFAULT '0' COMMENT 'Require user to reset password on next login',
  `authProvider` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT 'Name of used authentication plugin',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_username` (`username`),
  KEY `idx_name` (`name`(100)),
  KEY `idx_block` (`block`),
  KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=633 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_users`
--

/*!40000 ALTER TABLE `joomla_users` DISABLE KEYS */;
INSERT INTO `joomla_users` VALUES (632,'Super User','admin','joomproto@gmail.com','$2y$10$MvtHqS0lGUpx6Cxc.ASWHuuYfOfq1NCTNcVybehw9Esdhspzx.4Ha',0,1,'2019-07-26 06:28:42','2024-12-23 05:34:52','0','','0000-00-00 00:00:00',0,'','',0,'');
/*!40000 ALTER TABLE `joomla_users` ENABLE KEYS */;

--
-- Table structure for table `joomla_utf8_conversion`
--

DROP TABLE IF EXISTS `joomla_utf8_conversion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_utf8_conversion` (
  `converted` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_utf8_conversion`
--

/*!40000 ALTER TABLE `joomla_utf8_conversion` DISABLE KEYS */;
INSERT INTO `joomla_utf8_conversion` VALUES (5);
/*!40000 ALTER TABLE `joomla_utf8_conversion` ENABLE KEYS */;

--
-- Table structure for table `joomla_viewlevels`
--

DROP TABLE IF EXISTS `joomla_viewlevels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `joomla_viewlevels` (
  `id` int unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary Key',
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ordering` int NOT NULL DEFAULT '0',
  `rules` varchar(5120) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'JSON encoded access control.',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_assetgroup_title_lookup` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joomla_viewlevels`
--

/*!40000 ALTER TABLE `joomla_viewlevels` DISABLE KEYS */;
INSERT INTO `joomla_viewlevels` VALUES (1,'Public',0,'[1]'),(2,'Registered',2,'[6,2,8]'),(3,'Special',3,'[6,3,8]'),(5,'Guest',1,'[9]'),(6,'Super Users',4,'[8]');
/*!40000 ALTER TABLE `joomla_viewlevels` ENABLE KEYS */;

--
-- Table structure for table `network_activity`
--

DROP TABLE IF EXISTS `network_activity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_activity` (
  `activity_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `sponsor_id` int NOT NULL,
  `activity` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `activity_date` int NOT NULL,
  `upline_id` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_activity`
--

/*!40000 ALTER TABLE `network_activity` DISABLE KEYS */;
INSERT INTO `network_activity` VALUES (1,1,1,'<b>Account Update: </b><a href=\"member-info?uid=1\">admin</a> updated member account: <a href=\"member-info?uid=1\">admin</a>.',1734931505,1),(2,2,1,'<b>USDT Added: </b> Admin transferred 10,000.00 AET to <a href=\"member-info?uid=2\">test1</a>.',1734931584,1),(3,2,2,'<b>Account Update: </b> <a href=\"member-info?uid=2\">test1</a> updated own account.',1734931638,2),(4,2,1,'<b>1000 Activation: </b><a href=\"member-info?uid=2\">test1</a>, sponsored by <a href=\"member-info?uid=1\">admin</a>.',1734931655,1),(5,2,0,'<b>Indirect Referral Entry: </b> <a href=\"member-info?uid=2\"></a> has entered into Indirect Referral upon 1000 Sign Up.',1734931655,1),(6,2,0,'<b>Royalty PESO Entry: </b> <a href=\"member-info?uid=2\"></a> has entered into Royalty PESO upon 1000 Activation.',1734931655,1),(7,2,1,'<b>Fixed Daily Entry: </b> <a href=\"member-info?uid=2\">test1</a> has entered into Fixed Daily upon 1000 activation.',1734931655,1),(8,1,0,'<b>Royalty PESO Bonus: </b> <a href=\"member-info?uid=1\">admin</a> has earned 120.00 AET',1734931695,1),(9,2,2,'<b>USDT Withdrawal Approved: </b><a href=\"member-info?uid=2\">test1</a> has withdrawn 1,000.00000000 AET',1734931695,1),(10,3,2,'<b>USDT Added: </b> Admin transferred 10,000.00 AET to <a href=\"member-info?uid=3\">test2</a>.',1734937776,1),(11,3,2,'<b>1000 Activation: </b><a href=\"member-info?uid=3\">test2</a>, sponsored by <a href=\"member-info?uid=2\">test1</a>.',1734937919,1),(12,3,0,'<b>Indirect Referral Entry: </b> <a href=\"member-info?uid=3\"></a> has entered into Indirect Referral upon 1000 Sign Up.',1734937919,1),(13,2,1,'<b>Indirect Referral Bonus: </b> <a href=\"member-info?uid=2\">test1</a> has earned 20.00 AET',1734937919,1),(14,3,0,'<b>Royalty PESO Entry: </b> <a href=\"member-info?uid=3\"></a> has entered into Royalty PESO upon 1000 Activation.',1734937919,1),(15,3,2,'<b>Fixed Daily Entry: </b> <a href=\"member-info?uid=3\">test2</a> has entered into Fixed Daily upon 1000 activation.',1734937919,1),(16,3,3,'<b>Account Update: </b> <a href=\"member-info?uid=3\">test2</a> updated own account.',1734938107,3),(17,1,0,'<b>Royalty PESO Bonus: </b> <a href=\"member-info?uid=1\">admin</a> has earned 100.00 AET',1734938140,1),(18,2,1,'<b>Royalty PESO Bonus: </b> <a href=\"member-info?uid=2\">test1</a> has earned 120.00 AET',1734938140,1),(19,3,3,'<b>USDT Withdrawal Approved: </b><a href=\"member-info?uid=3\">test2</a> has withdrawn 1,000.00000000 AET',1734938141,1);
/*!40000 ALTER TABLE `network_activity` ENABLE KEYS */;

--
-- Table structure for table `network_admin`
--

DROP TABLE IF EXISTS `network_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_admin` (
  `id` int NOT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admintype` enum('Mega','Ultra','Super') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Super',
  PRIMARY KEY (`id`),
  UNIQUE KEY `tbl_network_admin_id_uindex` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_admin`
--

/*!40000 ALTER TABLE `network_admin` DISABLE KEYS */;
INSERT INTO `network_admin` VALUES (1,'superadmin','63a9f0ea7bb98050796b649e85481845','Super');
/*!40000 ALTER TABLE `network_admin` ENABLE KEYS */;

--
-- Table structure for table `network_balance`
--

DROP TABLE IF EXISTS `network_balance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_balance` (
  `balance_id` int NOT NULL,
  `transaction_id` int NOT NULL,
  `value` double NOT NULL,
  `balance` double NOT NULL,
  `date` int NOT NULL,
  PRIMARY KEY (`balance_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_balance`
--

/*!40000 ALTER TABLE `network_balance` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_balance` ENABLE KEYS */;

--
-- Table structure for table `network_binary`
--

DROP TABLE IF EXISTS `network_binary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_binary` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `upline_id` int NOT NULL DEFAULT '0',
  `position` enum('Head','Left','Right') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Left',
  `downline_left_id` int NOT NULL DEFAULT '0',
  `downline_right_id` int NOT NULL DEFAULT '0',
  `ctr_left` double NOT NULL DEFAULT '0',
  `ctr_right` double NOT NULL DEFAULT '0',
  `pairs` double NOT NULL DEFAULT '0',
  `pairs_today` double NOT NULL DEFAULT '0',
  `pairs_today_total` double NOT NULL DEFAULT '0',
  `pairs_5th` double NOT NULL DEFAULT '0',
  `income_cycle` double NOT NULL DEFAULT '0',
  `income_giftcheck` double NOT NULL DEFAULT '0',
  `income_flushout` double NOT NULL DEFAULT '0',
  `capping_cycle` double NOT NULL DEFAULT '0',
  `reactivate_count` int NOT NULL DEFAULT '0',
  `nth_pair_cycle` double NOT NULL DEFAULT '0',
  `status` enum('inactive','active','reactivated','graduate') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'inactive',
  `direct_cycle` int NOT NULL DEFAULT '0',
  `status_cycle` int NOT NULL DEFAULT '0',
  `date_last_flushout` int NOT NULL DEFAULT '0',
  `freeze_flushout` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_binary`
--

/*!40000 ALTER TABLE `network_binary` DISABLE KEYS */;
INSERT INTO `network_binary` VALUES (1,1,0,'Head',0,0,0,0,0,0,0,0,0,0,0,0,0,0,'active',0,1,1734931380,0);
/*!40000 ALTER TABLE `network_binary` ENABLE KEYS */;

--
-- Table structure for table `network_binary_entry`
--

DROP TABLE IF EXISTS `network_binary_entry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_binary_entry` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount` double NOT NULL DEFAULT '0',
  `date` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_binary_entry`
--

/*!40000 ALTER TABLE `network_binary_entry` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_binary_entry` ENABLE KEYS */;

--
-- Table structure for table `network_codes`
--

DROP TABLE IF EXISTS `network_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_codes` (
  `code_id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `type` enum('chairman','executive','regular','associate','basic','chairman_cd','executive_cd','regular_cd','associate_cd','basic_cd','starter') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_id` int NOT NULL,
  PRIMARY KEY (`code_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_codes`
--

/*!40000 ALTER TABLE `network_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_codes` ENABLE KEYS */;

--
-- Table structure for table `network_commission_deduct`
--

DROP TABLE IF EXISTS `network_commission_deduct`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_commission_deduct` (
  `id` int NOT NULL,
  `balance` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_commission_deduct`
--

/*!40000 ALTER TABLE `network_commission_deduct` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_commission_deduct` ENABLE KEYS */;

--
-- Table structure for table `network_compound`
--

DROP TABLE IF EXISTS `network_compound`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_compound` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `time_last` int NOT NULL DEFAULT '0',
  `value_last` double NOT NULL DEFAULT '0',
  `day` int NOT NULL DEFAULT '0',
  `processing` int NOT NULL DEFAULT '0',
  `maturity` int NOT NULL DEFAULT '0',
  `time_mature` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_compound`
--

/*!40000 ALTER TABLE `network_compound` DISABLE KEYS */;
INSERT INTO `network_compound` VALUES (1,1,0,0,0,0,90,0);
/*!40000 ALTER TABLE `network_compound` ENABLE KEYS */;

--
-- Table structure for table `network_ecash_add`
--

DROP TABLE IF EXISTS `network_ecash_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_ecash_add` (
  `add_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount` double NOT NULL,
  `date` int NOT NULL,
  PRIMARY KEY (`add_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_ecash_add`
--

/*!40000 ALTER TABLE `network_ecash_add` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_ecash_add` ENABLE KEYS */;

--
-- Table structure for table `network_echelon`
--

DROP TABLE IF EXISTS `network_echelon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_echelon` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `bonus_echelon` double NOT NULL DEFAULT '0',
  `bonus_echelon_now` double NOT NULL DEFAULT '0',
  `bonus_echelon_last` double NOT NULL DEFAULT '0',
  `bonus_echelon_points` double NOT NULL DEFAULT '0',
  `bonus_echelon_points_now` double NOT NULL DEFAULT '0',
  `bonus_echelon_points_last` double NOT NULL DEFAULT '0',
  `bonus_echelon_fmc` double NOT NULL DEFAULT '0',
  `bonus_echelon_fmc_now` double NOT NULL DEFAULT '0',
  `bonus_echelon_fmc_last` double NOT NULL DEFAULT '0',
  `income_today` double NOT NULL DEFAULT '0',
  `flushout_local` double NOT NULL DEFAULT '0',
  `flushout_global` double NOT NULL DEFAULT '0',
  `date_last_flushout` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_echelon`
--

/*!40000 ALTER TABLE `network_echelon` DISABLE KEYS */;
INSERT INTO `network_echelon` VALUES (1,1,220,220,220,0,0,0,0,0,0,220,0,0,0),(2,2,120,120,120,0,0,0,0,0,0,120,0,0,0),(3,3,0,0,0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `network_echelon` ENABLE KEYS */;

--
-- Table structure for table `network_efund_add`
--

DROP TABLE IF EXISTS `network_efund_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_efund_add` (
  `add_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount` double NOT NULL,
  `date` int NOT NULL,
  PRIMARY KEY (`add_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_efund_add`
--

/*!40000 ALTER TABLE `network_efund_add` DISABLE KEYS */;
INSERT INTO `network_efund_add` VALUES (1,2,10000,1734931584),(2,3,10000,1734937776);
/*!40000 ALTER TABLE `network_efund_add` ENABLE KEYS */;

--
-- Table structure for table `network_efund_conversions`
--

DROP TABLE IF EXISTS `network_efund_conversions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_efund_conversions` (
  `conversion_id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NOT NULL DEFAULT '0',
  `amount` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `method` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `conversion_date` int NOT NULL DEFAULT '0',
  `conversion_total` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`conversion_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_efund_conversions`
--

/*!40000 ALTER TABLE `network_efund_conversions` DISABLE KEYS */;
INSERT INTO `network_efund_conversions` VALUES (1,3,1000,404166666.66667,'aet',1734931695,1000),(2,6,1000,5408201.3120032,'aet',1734938141,2000);
/*!40000 ALTER TABLE `network_efund_conversions` ENABLE KEYS */;

--
-- Table structure for table `network_efund_convert`
--

DROP TABLE IF EXISTS `network_efund_convert`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_efund_convert` (
  `convert_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `amount` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `cut` double NOT NULL DEFAULT '0',
  `mode` enum('sop','fdp','ftk') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'sop',
  `method` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `date_posted` int NOT NULL DEFAULT '0',
  `date_approved` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`convert_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_efund_convert`
--

/*!40000 ALTER TABLE `network_efund_convert` DISABLE KEYS */;
INSERT INTO `network_efund_convert` VALUES (1,2,1000,404166666.66667,30,'sop','aet',1734931674,1734931695),(2,3,1000,5408201.3120032,30,'sop','aet',1734938119,1734938140);
/*!40000 ALTER TABLE `network_efund_convert` ENABLE KEYS */;

--
-- Table structure for table `network_efund_request`
--

DROP TABLE IF EXISTS `network_efund_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_efund_request` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount` double NOT NULL,
  `price` double NOT NULL,
  `method` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_requested` int NOT NULL,
  `date_confirmed` int NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_efund_request`
--

/*!40000 ALTER TABLE `network_efund_request` DISABLE KEYS */;
INSERT INTO `network_efund_request` VALUES (1,2,1000,5575465.2701064,'aet',1734932377,0);
/*!40000 ALTER TABLE `network_efund_request` ENABLE KEYS */;

--
-- Table structure for table `network_efund_requests`
--

DROP TABLE IF EXISTS `network_efund_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_efund_requests` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NOT NULL,
  `amount` double NOT NULL,
  `price` double NOT NULL,
  `method` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_date` int NOT NULL,
  `request_total` double NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_efund_requests`
--

/*!40000 ALTER TABLE `network_efund_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_efund_requests` ENABLE KEYS */;

--
-- Table structure for table `network_elite_maintain`
--

DROP TABLE IF EXISTS `network_elite_maintain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_elite_maintain` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `maintain_elite` double NOT NULL DEFAULT '0',
  `maintain_elite_now` double NOT NULL DEFAULT '0',
  `maintain_elite_last` double NOT NULL DEFAULT '0',
  `period_elite_maintain` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_elite_maintain`
--

/*!40000 ALTER TABLE `network_elite_maintain` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_elite_maintain` ENABLE KEYS */;

--
-- Table structure for table `network_endowment`
--

DROP TABLE IF EXISTS `network_endowment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_endowment` (
  `endowment_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `time_last` int NOT NULL DEFAULT '0',
  `value_last` double NOT NULL DEFAULT '0',
  `day` int NOT NULL DEFAULT '0',
  `date_entry` int NOT NULL DEFAULT '0',
  `maturity` int NOT NULL DEFAULT '0',
  `time_mature` int NOT NULL DEFAULT '0',
  `pocket` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`endowment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_endowment`
--

/*!40000 ALTER TABLE `network_endowment` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_endowment` ENABLE KEYS */;

--
-- Table structure for table `network_fast_track`
--

DROP TABLE IF EXISTS `network_fast_track`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_fast_track` (
  `fast_track_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `time_last` int NOT NULL,
  `value_last` double NOT NULL,
  `day` int NOT NULL,
  `principal` double NOT NULL,
  `date_entry` int NOT NULL,
  `processing` int NOT NULL,
  `time_mature` int NOT NULL DEFAULT '0',
  `date_last_cron` int NOT NULL DEFAULT '0',
  `flushout_global` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`fast_track_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_fast_track`
--

/*!40000 ALTER TABLE `network_fast_track` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_fast_track` ENABLE KEYS */;

--
-- Table structure for table `network_fixed_daily`
--

DROP TABLE IF EXISTS `network_fixed_daily`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_fixed_daily` (
  `fixed_daily_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `time_last` int NOT NULL DEFAULT '0',
  `value_last` double NOT NULL DEFAULT '0',
  `day` int NOT NULL DEFAULT '0',
  `processing` int NOT NULL DEFAULT '0',
  `time_mature` int NOT NULL DEFAULT '0',
  `date_last_cron` int NOT NULL DEFAULT '0',
  `flushout_global` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`fixed_daily_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_fixed_daily`
--

/*!40000 ALTER TABLE `network_fixed_daily` DISABLE KEYS */;
INSERT INTO `network_fixed_daily` VALUES (1,1,0,0,0,0,0,0,0),(2,2,0,0,0,0,0,0,0),(3,3,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `network_fixed_daily` ENABLE KEYS */;

--
-- Table structure for table `network_fmc`
--

DROP TABLE IF EXISTS `network_fmc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_fmc` (
  `balance` double NOT NULL,
  `sales_fmc` double NOT NULL,
  `purchase_fmc` double NOT NULL,
  `price_btc` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_fmc`
--

/*!40000 ALTER TABLE `network_fmc` DISABLE KEYS */;
INSERT INTO `network_fmc` VALUES (16000000000,0,0,0);
/*!40000 ALTER TABLE `network_fmc` ENABLE KEYS */;

--
-- Table structure for table `network_fmc_trade`
--

DROP TABLE IF EXISTS `network_fmc_trade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_fmc_trade` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `order_type` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `price` double NOT NULL,
  `amount` double NOT NULL,
  `time_post` int NOT NULL DEFAULT '0',
  `time_complete` int NOT NULL DEFAULT '0',
  `complete_by` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_fmc_trade`
--

/*!40000 ALTER TABLE `network_fmc_trade` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_fmc_trade` ENABLE KEYS */;

--
-- Table structure for table `network_harvest`
--

DROP TABLE IF EXISTS `network_harvest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_harvest` (
  `user_id` int NOT NULL,
  `bonus_harvest_associate` double NOT NULL DEFAULT '0',
  `bonus_harvest_associate_now` double NOT NULL DEFAULT '0',
  `bonus_harvest_associate_last` double NOT NULL DEFAULT '0',
  `bonus_harvest_basic` double NOT NULL DEFAULT '0',
  `bonus_harvest_basic_now` double NOT NULL DEFAULT '0',
  `bonus_harvest_basic_last` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_harvest`
--

/*!40000 ALTER TABLE `network_harvest` DISABLE KEYS */;
INSERT INTO `network_harvest` VALUES (1,0,0,0,0,0,0);
/*!40000 ALTER TABLE `network_harvest` ENABLE KEYS */;

--
-- Table structure for table `network_harvest_associate`
--

DROP TABLE IF EXISTS `network_harvest_associate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_harvest_associate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `harvest_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_harvest_associate`
--

/*!40000 ALTER TABLE `network_harvest_associate` DISABLE KEYS */;
INSERT INTO `network_harvest_associate` VALUES (1,1,0,0,1);
/*!40000 ALTER TABLE `network_harvest_associate` ENABLE KEYS */;

--
-- Table structure for table `network_harvest_basic`
--

DROP TABLE IF EXISTS `network_harvest_basic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_harvest_basic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `harvest_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_harvest_basic`
--

/*!40000 ALTER TABLE `network_harvest_basic` DISABLE KEYS */;
INSERT INTO `network_harvest_basic` VALUES (1,1,0,0,1);
/*!40000 ALTER TABLE `network_harvest_basic` ENABLE KEYS */;

--
-- Table structure for table `network_harvest_executive`
--

DROP TABLE IF EXISTS `network_harvest_executive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_harvest_executive` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `harvest_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_harvest_executive`
--

/*!40000 ALTER TABLE `network_harvest_executive` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_harvest_executive` ENABLE KEYS */;

--
-- Table structure for table `network_harvest_regular`
--

DROP TABLE IF EXISTS `network_harvest_regular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_harvest_regular` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `harvest_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_harvest_regular`
--

/*!40000 ALTER TABLE `network_harvest_regular` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_harvest_regular` ENABLE KEYS */;

--
-- Table structure for table `network_incentive`
--

DROP TABLE IF EXISTS `network_incentive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_incentive` (
  `incentive_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `item_id` int NOT NULL,
  `date` int NOT NULL,
  `price` double NOT NULL,
  `quantity` int NOT NULL,
  `status` enum('Awaiting Delivery','Delivered') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Awaiting Delivery',
  `total_purchases` double NOT NULL,
  PRIMARY KEY (`incentive_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_incentive`
--

/*!40000 ALTER TABLE `network_incentive` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_incentive` ENABLE KEYS */;

--
-- Table structure for table `network_income`
--

DROP TABLE IF EXISTS `network_income`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_income` (
  `income_id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NOT NULL,
  `amount` double NOT NULL,
  `income_total` double NOT NULL,
  `income_date` int NOT NULL,
  PRIMARY KEY (`income_id`),
  UNIQUE KEY `balance_id` (`income_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_income`
--

/*!40000 ALTER TABLE `network_income` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_income` ENABLE KEYS */;

--
-- Table structure for table `network_indirect`
--

DROP TABLE IF EXISTS `network_indirect`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_indirect` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `bonus_indirect` double NOT NULL DEFAULT '0',
  `bonus_indirect_now` double NOT NULL DEFAULT '0',
  `bonus_indirect_last` double NOT NULL DEFAULT '0',
  `bonus_indirect_points` double NOT NULL DEFAULT '0',
  `bonus_indirect_points_now` double NOT NULL DEFAULT '0',
  `bonus_indirect_points_last` double NOT NULL DEFAULT '0',
  `bonus_indirect_fmc` double NOT NULL DEFAULT '0',
  `bonus_indirect_fmc_now` double NOT NULL DEFAULT '0',
  `bonus_indirect_fmc_last` double NOT NULL DEFAULT '0',
  `income_today` double NOT NULL DEFAULT '0',
  `flushout_local` double NOT NULL DEFAULT '0',
  `flushout_global` double NOT NULL DEFAULT '0',
  `date_last_flushout` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_indirect`
--

/*!40000 ALTER TABLE `network_indirect` DISABLE KEYS */;
INSERT INTO `network_indirect` VALUES (1,1,0,0,0,0,0,0,0,0,0,0,0,0,0),(2,2,20,20,20,0,0,0,0,0,0,20,0,0,0),(3,3,0,0,0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `network_indirect` ENABLE KEYS */;

--
-- Table structure for table `network_items_incentive`
--

DROP TABLE IF EXISTS `network_items_incentive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_items_incentive` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `quantity` int NOT NULL,
  `picture` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_items_incentive`
--

/*!40000 ALTER TABLE `network_items_incentive` DISABLE KEYS */;
INSERT INTO `network_items_incentive` VALUES (14,'AET','asset eternity token',1.3,300,'14.png'),(15,'B2P','Binance Token Payments',0.005,700,'15.png');
/*!40000 ALTER TABLE `network_items_incentive` ENABLE KEYS */;

--
-- Table structure for table `network_items_merchant`
--

DROP TABLE IF EXISTS `network_items_merchant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_items_merchant` (
  `merchant_id` int NOT NULL AUTO_INCREMENT,
  `merchant_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`merchant_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_items_merchant`
--

/*!40000 ALTER TABLE `network_items_merchant` DISABLE KEYS */;
INSERT INTO `network_items_merchant` VALUES (2,'1WayHi.Com','One Way Hi','hghdsgfh hgsdfgshdf jhsgduytewyr sdjyfgsuydgf iuyewruigwergwhe jhsdgfjsgdf','2.png'),(4,'Health186.Store','Health 186 Store','hgh sdg fhjsdgfh jsdghfgs dhfghjs dgfjhsd gfjhsg dfhjgsd hjfgjhsd gfjhsdg fjsg hf','4.png');
/*!40000 ALTER TABLE `network_items_merchant` ENABLE KEYS */;

--
-- Table structure for table `network_items_repeat`
--

DROP TABLE IF EXISTS `network_items_repeat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_items_repeat` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat_id` int NOT NULL DEFAULT '0',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `price_retail` double NOT NULL,
  `binary_points` double NOT NULL,
  `quantity` int NOT NULL,
  `reward_points` double NOT NULL,
  `unilevel_points` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_items_repeat`
--

/*!40000 ALTER TABLE `network_items_repeat` DISABLE KEYS */;
INSERT INTO `network_items_repeat` VALUES (6,'Prime Sanitary Pad & Panty Liners','qq',20,'qq','6.jpg',11,11,11,1,0,0),(7,'Prime Pro Ion Eyeglass','',7,'Ion Spec Eyeglass\r\nAnti Blue ray light and anti Radiation','7.jpg',4250,8500,300,2,0,0),(14,'Prime  Magnetic Negative Ion Bracelet','Made with Titanium, Stainless\r\n',7,'Effective in treating chronic pain, inflammation, disease, and general health deficiencies. \r\nContra Indication: Patient with Pace maker and patient who uses an insulin pump','14.png',0,0,0,1,0,0),(15,'Prime Thera Care','f',7,'f','15.jpg',0,0,0,1,0,0),(17,'Prime Multi-Vitamins','1000mg Effervescent Tablets',4,'','17.png',0,0,0,1,0,0),(18,'Prime Super Collagen Peptides','1000mg Effervescent Tablets ',4,'- Enhances tissue repair\r\n- Boost immune system response\r\n- Best for skin rejuvenation\r\n- Increase bone mineral density to prevent osteoporosis','18.png',0,0,0,1,0,0),(19,'Prime Cranberry','Improve Immunity, Eliminate Genital itching, Odor, Abnormal Leucorrhea and other discomfort symptom cause by gynecoligical inflammation',4,'','19.jpg',0,0,0,1,0,0),(20,'Prime Vitamin C -Orange','1000mg Effervescent Tablets ',4,'- Protect cell from damaging\r\n- Maintain healthy skin, blood vessel, bones and cartilage\r\n- Increase capacity of wound healing\r\n','20.png',0,0,0,1,0,0),(22,'Prime Hydrogen water','This alkaline water bottle is made of 304 good-grade stainless steel, inside with more than 7 kinds of mineral stones for making health alkaline water, pH level 8-9.5.\r\n1. ORP Ball or Alkaline Hydrogen Reducing Ball - responsible for eliminating harmful health factors ( Oxygen Free Radicals ) in air and water.\r\n2. Negative Ion Ball - is made from natural stones through the nanometer processing which can be continuously produced negative ions, widely used in industry, food industry and water treatment.\r\n3. Zinc Stone - known as a healing stone, it dissolved impurities within water.\r\n4. Hydrogen Ball - Increase pH value of drinking water and make rich hydrogen drinking water, also used in mineral water treatment.\r\n5. Germanium Ball - is a strong elements that provides oxygen, its function is to give vitality to the skin.\r\n6. Alkaline Ball - Use to enhance and revitalize your drinking water, increase water pH with in the level of 7-11.\r\n7. Far-infrared Ball -  suppress the growth of exces',9,'This alkaline water bottle is made of 304 good-grade stainless steel, inside with more than 7 kinds of mineral stones for making health alkaline water, pH level 8-9.5.\r\nPrime Alkaline Water Mug\r\nIntroducing the Alkaline Water Mug, a game-changing hydration solution that transforms ordinary water into alkaline water, promoting overall well-being. With its sleek design and advanced technology, this mug allows you to enjoy the benefits of alkaline water wherever you go, supporting optimal hydration and a healthier lifestyle.','22.png',1500,1500,0,113,36,180),(23,'Prime Quantum Pendant','many benefits from the energy carried into cells by scalar enhanced supplements. The surface tension of enhanced products is reduced, making them easier for the body to assimilate. And remember, scalar energy is readily transferred from product to cell.The electrical charge generated across cell membranes is brought up to optimal levels.\r\nThis allows nutrients to move into the cell and wastes to move out with maximum efficiency. Overall body energy increases as each of the trillions of cells are energized. Scalar energy strengthens chemical bonds within DNA, making it more resistant to damage. Blood is cleansed and its cellular elements function as they should. Immune function improves.',7,'Alpha Spin Scalar quantum energy Stainless steel glass Chi EMF protection charm pendant','23.png',0,0,0,81,0,0),(24,'Prime Uric Acid Cleanse','Introducing Prime Care Uric Acid Cleanse Fast relief from gout attacks. Liquid Formula absorbs and eliminates pain and inflammation instantly.',4,'Introducing Prime Care Uric Acid Cleanse Fast relief from gout attacks. Liquid Formula absorbs and eliminates pain and inflammation instantly.','24.jpg',950,950,0,83,20,100),(25,'Prime Omega-3','Contains more than 80% Omega-3 EFA\'s with Advanced Molecular, Distilled and Purified, 3x Potent and Powerful',4,'Contains more than 80% Omega-3 EFA\'s with Advanced Molecular, Distilled and Purified, 3x Potent and Powerful','25.jpg',950,950,0,81,20,100);
/*!40000 ALTER TABLE `network_items_repeat` ENABLE KEYS */;

--
-- Table structure for table `network_leadership`
--

DROP TABLE IF EXISTS `network_leadership`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_leadership` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `bonus_leadership` double NOT NULL DEFAULT '0',
  `bonus_leadership_now` double NOT NULL DEFAULT '0',
  `bonus_leadership_last` double NOT NULL DEFAULT '0',
  `income_today` double NOT NULL DEFAULT '0',
  `date_last_flushout` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_leadership`
--

/*!40000 ALTER TABLE `network_leadership` DISABLE KEYS */;
INSERT INTO `network_leadership` VALUES (1,1,0,0,0,0,0);
/*!40000 ALTER TABLE `network_leadership` ENABLE KEYS */;

--
-- Table structure for table `network_leadership_passive`
--

DROP TABLE IF EXISTS `network_leadership_passive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_leadership_passive` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `bonus_leadership_passive` double NOT NULL DEFAULT '0',
  `bonus_leadership_passive_now` double NOT NULL DEFAULT '0',
  `bonus_leadership_passive_last` double NOT NULL DEFAULT '0',
  `income_today` double NOT NULL DEFAULT '0',
  `flushout_local` double NOT NULL DEFAULT '0',
  `flushout_global` double NOT NULL DEFAULT '0',
  `date_last_flushout` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_leadership_passive`
--

/*!40000 ALTER TABLE `network_leadership_passive` DISABLE KEYS */;
INSERT INTO `network_leadership_passive` VALUES (1,1,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `network_leadership_passive` ENABLE KEYS */;

--
-- Table structure for table `network_loan_request`
--

DROP TABLE IF EXISTS `network_loan_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_loan_request` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount` double NOT NULL,
  `price` double NOT NULL,
  `method` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_requested` int NOT NULL,
  `date_confirmed` int NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_loan_request`
--

/*!40000 ALTER TABLE `network_loan_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_loan_request` ENABLE KEYS */;

--
-- Table structure for table `network_loan_requests`
--

DROP TABLE IF EXISTS `network_loan_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_loan_requests` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NOT NULL,
  `amount` double NOT NULL,
  `price` double NOT NULL,
  `method` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_date` int NOT NULL,
  `request_total` double NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_loan_requests`
--

/*!40000 ALTER TABLE `network_loan_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_loan_requests` ENABLE KEYS */;

--
-- Table structure for table `network_loans_transfer`
--

DROP TABLE IF EXISTS `network_loans_transfer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_loans_transfer` (
  `transfer_id` int NOT NULL AUTO_INCREMENT,
  `transfer_from` int NOT NULL,
  `transfer_to` int NOT NULL,
  `type` enum('transfer','deposit') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'transfer',
  `date` int NOT NULL,
  `amount` double NOT NULL,
  PRIMARY KEY (`transfer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_loans_transfer`
--

/*!40000 ALTER TABLE `network_loans_transfer` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_loans_transfer` ENABLE KEYS */;

--
-- Table structure for table `network_matrix`
--

DROP TABLE IF EXISTS `network_matrix`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_matrix` (
  `user_id` int NOT NULL,
  `bonus_matrix_executive` double NOT NULL DEFAULT '0',
  `bonus_matrix_executive_now` double NOT NULL DEFAULT '0',
  `bonus_matrix_executive_last` double NOT NULL DEFAULT '0',
  `bonus_matrix_regular` double NOT NULL DEFAULT '0',
  `bonus_matrix_regular_now` double NOT NULL DEFAULT '0',
  `bonus_matrix_regular_last` double NOT NULL DEFAULT '0',
  `bonus_matrix_associate` double NOT NULL DEFAULT '0',
  `bonus_matrix_associate_now` double NOT NULL DEFAULT '0',
  `bonus_matrix_associate_last` double NOT NULL DEFAULT '0',
  `bonus_matrix_basic` double NOT NULL DEFAULT '0',
  `bonus_matrix_basic_now` double NOT NULL DEFAULT '0',
  `bonus_matrix_basic_last` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_matrix`
--

/*!40000 ALTER TABLE `network_matrix` DISABLE KEYS */;
INSERT INTO `network_matrix` VALUES (1,0,0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `network_matrix` ENABLE KEYS */;

--
-- Table structure for table `network_matrix_associate`
--

DROP TABLE IF EXISTS `network_matrix_associate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_matrix_associate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `matrix_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_matrix_associate`
--

/*!40000 ALTER TABLE `network_matrix_associate` DISABLE KEYS */;
INSERT INTO `network_matrix_associate` VALUES (1,1,0,0,1);
/*!40000 ALTER TABLE `network_matrix_associate` ENABLE KEYS */;

--
-- Table structure for table `network_matrix_basic`
--

DROP TABLE IF EXISTS `network_matrix_basic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_matrix_basic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `matrix_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_matrix_basic`
--

/*!40000 ALTER TABLE `network_matrix_basic` DISABLE KEYS */;
INSERT INTO `network_matrix_basic` VALUES (1,1,0,0,1);
/*!40000 ALTER TABLE `network_matrix_basic` ENABLE KEYS */;

--
-- Table structure for table `network_matrix_executive`
--

DROP TABLE IF EXISTS `network_matrix_executive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_matrix_executive` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `matrix_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_matrix_executive`
--

/*!40000 ALTER TABLE `network_matrix_executive` DISABLE KEYS */;
INSERT INTO `network_matrix_executive` VALUES (1,1,0,0,1);
/*!40000 ALTER TABLE `network_matrix_executive` ENABLE KEYS */;

--
-- Table structure for table `network_matrix_regular`
--

DROP TABLE IF EXISTS `network_matrix_regular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_matrix_regular` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `matrix_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_matrix_regular`
--

/*!40000 ALTER TABLE `network_matrix_regular` DISABLE KEYS */;
INSERT INTO `network_matrix_regular` VALUES (1,1,0,0,1);
/*!40000 ALTER TABLE `network_matrix_regular` ENABLE KEYS */;

--
-- Table structure for table `network_p2p_item_sale`
--

DROP TABLE IF EXISTS `network_p2p_item_sale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_p2p_item_sale` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `sale_id` int NOT NULL DEFAULT '0',
  `buyer_id` int NOT NULL DEFAULT '0',
  `item_id` int NOT NULL DEFAULT '0',
  `amount_min` double NOT NULL DEFAULT '0',
  `method` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `total` double NOT NULL DEFAULT '0',
  `date_requested` int NOT NULL DEFAULT '0',
  `date_updated` int NOT NULL DEFAULT '0',
  `date_confirmed` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_p2p_item_sale`
--

/*!40000 ALTER TABLE `network_p2p_item_sale` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_p2p_item_sale` ENABLE KEYS */;

--
-- Table structure for table `network_p2p_item_transactions`
--

DROP TABLE IF EXISTS `network_p2p_item_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_p2p_item_transactions` (
  `trx_id` int NOT NULL AUTO_INCREMENT,
  `seller_id` int NOT NULL DEFAULT '0',
  `buyer_id` int NOT NULL DEFAULT '0',
  `item_id` int NOT NULL DEFAULT '0',
  `amount` double NOT NULL DEFAULT '0',
  `method` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `final` double NOT NULL DEFAULT '0',
  `date_open` int NOT NULL DEFAULT '0',
  `date_close` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`trx_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_p2p_item_transactions`
--

/*!40000 ALTER TABLE `network_p2p_item_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_p2p_item_transactions` ENABLE KEYS */;

--
-- Table structure for table `network_p2p_items`
--

DROP TABLE IF EXISTS `network_p2p_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_p2p_items` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `item_name` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `cat_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `picture` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `price` double NOT NULL DEFAULT '0',
  `quantity` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_p2p_items`
--

/*!40000 ALTER TABLE `network_p2p_items` DISABLE KEYS */;
INSERT INTO `network_p2p_items` VALUES (1,1,'Item1','Description 1','1','sdadasfa asafasf  asasf asd','1.jpg',1,1000);
/*!40000 ALTER TABLE `network_p2p_items` ENABLE KEYS */;

--
-- Table structure for table `network_p2p_sell_items`
--

DROP TABLE IF EXISTS `network_p2p_sell_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_p2p_sell_items` (
  `sell_id` int NOT NULL AUTO_INCREMENT,
  `purchase_id` int NOT NULL DEFAULT '0',
  `item_id` int NOT NULL DEFAULT '0',
  `amount_min` double NOT NULL DEFAULT '0',
  `method` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `total` double NOT NULL DEFAULT '0',
  `date_posted` int NOT NULL DEFAULT '0',
  `date_updated` int NOT NULL DEFAULT '0',
  `date_confirmed` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`sell_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_p2p_sell_items`
--

/*!40000 ALTER TABLE `network_p2p_sell_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_p2p_sell_items` ENABLE KEYS */;

--
-- Table structure for table `network_p2p_sell_tokens`
--

DROP TABLE IF EXISTS `network_p2p_sell_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_p2p_sell_tokens` (
  `sell_id` int NOT NULL AUTO_INCREMENT,
  `purchase_id` int NOT NULL DEFAULT '0',
  `seller_id` int NOT NULL DEFAULT '0',
  `amount_remaining` double NOT NULL DEFAULT '0',
  `amount_minimum` double NOT NULL DEFAULT '0',
  `amount_sold` double NOT NULL DEFAULT '0',
  `type` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `method` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `price` double NOT NULL DEFAULT '0',
  `total_sell` double NOT NULL DEFAULT '0',
  `date_posted` int NOT NULL DEFAULT '0',
  `date_updated` int NOT NULL DEFAULT '0',
  `date_confirmed` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`sell_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_p2p_sell_tokens`
--

/*!40000 ALTER TABLE `network_p2p_sell_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_p2p_sell_tokens` ENABLE KEYS */;

--
-- Table structure for table `network_p2p_token_sale`
--

DROP TABLE IF EXISTS `network_p2p_token_sale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_p2p_token_sale` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `sale_id` int NOT NULL DEFAULT '0',
  `buyer_id` int NOT NULL DEFAULT '0',
  `amount_pending` double NOT NULL DEFAULT '0',
  `amount_minimum` double NOT NULL DEFAULT '0',
  `amount` double NOT NULL DEFAULT '0',
  `type_buy` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `method_buy` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `price_buy` double NOT NULL DEFAULT '0',
  `total` double NOT NULL DEFAULT '0',
  `date_requested` int NOT NULL DEFAULT '0',
  `date_updated` int NOT NULL DEFAULT '0',
  `date_confirmed` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_p2p_token_sale`
--

/*!40000 ALTER TABLE `network_p2p_token_sale` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_p2p_token_sale` ENABLE KEYS */;

--
-- Table structure for table `network_p2p_transactions`
--

DROP TABLE IF EXISTS `network_p2p_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_p2p_transactions` (
  `transaction_id` int NOT NULL AUTO_INCREMENT,
  `seller_id` int NOT NULL DEFAULT '0',
  `buyer_id` int NOT NULL DEFAULT '0',
  `amount` double NOT NULL DEFAULT '0',
  `type` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `method` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `price` double NOT NULL DEFAULT '0',
  `final` double NOT NULL DEFAULT '0',
  `date_open` int NOT NULL DEFAULT '0',
  `date_close` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_p2p_transactions`
--

/*!40000 ALTER TABLE `network_p2p_transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_p2p_transactions` ENABLE KEYS */;

--
-- Table structure for table `network_payouts`
--

DROP TABLE IF EXISTS `network_payouts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_payouts` (
  `payout_id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NOT NULL,
  `amount` double NOT NULL,
  `payout_date` int NOT NULL,
  `payout_total` double NOT NULL,
  `amount_tax` double NOT NULL,
  `total_tax` double NOT NULL,
  PRIMARY KEY (`payout_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_payouts`
--

/*!40000 ALTER TABLE `network_payouts` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_payouts` ENABLE KEYS */;

--
-- Table structure for table `network_point_add`
--

DROP TABLE IF EXISTS `network_point_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_point_add` (
  `add_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount` double NOT NULL,
  `date` int NOT NULL,
  PRIMARY KEY (`add_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_point_add`
--

/*!40000 ALTER TABLE `network_point_add` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_point_add` ENABLE KEYS */;

--
-- Table structure for table `network_points`
--

DROP TABLE IF EXISTS `network_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_points` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `points` double NOT NULL DEFAULT '0',
  `points_spent` double NOT NULL DEFAULT '0',
  `points_waiting` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_points`
--

/*!40000 ALTER TABLE `network_points` DISABLE KEYS */;
INSERT INTO `network_points` VALUES (1,1,0,0,0);
/*!40000 ALTER TABLE `network_points` ENABLE KEYS */;

--
-- Table structure for table `network_power`
--

DROP TABLE IF EXISTS `network_power`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_power` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bonus_power_executive` double NOT NULL DEFAULT '0',
  `bonus_power_executive_now` double NOT NULL DEFAULT '0',
  `bonus_power_executive_last` double NOT NULL DEFAULT '0',
  `bonus_power_regular` double NOT NULL DEFAULT '0',
  `bonus_power_regular_now` double NOT NULL DEFAULT '0',
  `bonus_power_regular_last` double NOT NULL DEFAULT '0',
  `bonus_power_associate` double NOT NULL DEFAULT '0',
  `bonus_power_associate_now` double NOT NULL DEFAULT '0',
  `bonus_power_associate_last` double NOT NULL DEFAULT '0',
  `bonus_power_basic` double NOT NULL DEFAULT '0',
  `bonus_power_basic_now` double NOT NULL DEFAULT '0',
  `bonus_power_basic_last` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_power`
--

/*!40000 ALTER TABLE `network_power` DISABLE KEYS */;
INSERT INTO `network_power` VALUES (1,0,0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `network_power` ENABLE KEYS */;

--
-- Table structure for table `network_power_associate`
--

DROP TABLE IF EXISTS `network_power_associate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_power_associate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `power_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_power_associate`
--

/*!40000 ALTER TABLE `network_power_associate` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_power_associate` ENABLE KEYS */;

--
-- Table structure for table `network_power_basic`
--

DROP TABLE IF EXISTS `network_power_basic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_power_basic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `power_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_power_basic`
--

/*!40000 ALTER TABLE `network_power_basic` DISABLE KEYS */;
INSERT INTO `network_power_basic` VALUES (1,1,0,0,1);
/*!40000 ALTER TABLE `network_power_basic` ENABLE KEYS */;

--
-- Table structure for table `network_power_executive`
--

DROP TABLE IF EXISTS `network_power_executive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_power_executive` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `power_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_power_executive`
--

/*!40000 ALTER TABLE `network_power_executive` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_power_executive` ENABLE KEYS */;

--
-- Table structure for table `network_power_regular`
--

DROP TABLE IF EXISTS `network_power_regular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_power_regular` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `power_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_power_regular`
--

/*!40000 ALTER TABLE `network_power_regular` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_power_regular` ENABLE KEYS */;

--
-- Table structure for table `network_ranking_maintain`
--

DROP TABLE IF EXISTS `network_ranking_maintain`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_ranking_maintain` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `maintain_ranking` double NOT NULL DEFAULT '0',
  `maintain_ranking_now` double NOT NULL DEFAULT '0',
  `maintain_ranking_last` double NOT NULL DEFAULT '0',
  `period_ranking_maintain` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_ranking_maintain`
--

/*!40000 ALTER TABLE `network_ranking_maintain` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_ranking_maintain` ENABLE KEYS */;

--
-- Table structure for table `network_repeat`
--

DROP TABLE IF EXISTS `network_repeat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_repeat` (
  `repeat_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `item_id` int NOT NULL,
  `date` int NOT NULL,
  `reward_points` double NOT NULL,
  `unilevel_points` double NOT NULL,
  `binary_points` double NOT NULL,
  `price` double NOT NULL,
  `quantity` int NOT NULL,
  `position` enum('Left','Right') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Left',
  `total_purchases` double NOT NULL,
  `code` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `method` enum('efund','token') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'efund',
  `status` enum('Awaiting Delivery','Delivered') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Awaiting Delivery',
  PRIMARY KEY (`repeat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_repeat`
--

/*!40000 ALTER TABLE `network_repeat` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_repeat` ENABLE KEYS */;

--
-- Table structure for table `network_savings_transfer`
--

DROP TABLE IF EXISTS `network_savings_transfer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_savings_transfer` (
  `transfer_id` int NOT NULL AUTO_INCREMENT,
  `transfer_from` int NOT NULL,
  `transfer_to` int NOT NULL,
  `type` enum('transfer','deposit') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'transfer',
  `date` int NOT NULL,
  `amount` double NOT NULL,
  PRIMARY KEY (`transfer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_savings_transfer`
--

/*!40000 ALTER TABLE `network_savings_transfer` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_savings_transfer` ENABLE KEYS */;

--
-- Table structure for table `network_session`
--

DROP TABLE IF EXISTS `network_session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_session` (
  `user_id` int NOT NULL COMMENT 'user id',
  `session_id` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'md5(key)',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `session_id` (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_session`
--

/*!40000 ALTER TABLE `network_session` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_session` ENABLE KEYS */;

--
-- Table structure for table `network_settings_ancillaries`
--

DROP TABLE IF EXISTS `network_settings_ancillaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_ancillaries` (
  `payment_mode` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'CODE',
  `currency` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'USD',
  `email_official` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'mail@onewayhi.com',
  `company_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'One Way High, Inc.',
  `cybercharge` double NOT NULL DEFAULT '0',
  `processing_fee` double NOT NULL DEFAULT '0',
  `grace_period` int NOT NULL DEFAULT '0',
  `chairman_min_withdraw` double DEFAULT '0',
  `executive_min_withdraw` double NOT NULL DEFAULT '0',
  `regular_min_withdraw` double NOT NULL DEFAULT '0',
  `associate_min_withdraw` double NOT NULL DEFAULT '0',
  `basic_min_withdraw` double NOT NULL DEFAULT '0',
  `chairman_min_bal_usd` double DEFAULT '0',
  `executive_min_bal_usd` double NOT NULL DEFAULT '0',
  `regular_min_bal_usd` double NOT NULL DEFAULT '0',
  `associate_min_bal_usd` double NOT NULL DEFAULT '0',
  `basic_min_bal_usd` double NOT NULL DEFAULT '0',
  `chairman_min_bal_fmc` double DEFAULT '0',
  `executive_min_bal_fmc` double NOT NULL DEFAULT '0',
  `regular_min_bal_fmc` double NOT NULL DEFAULT '0',
  `associate_min_bal_fmc` double NOT NULL DEFAULT '0',
  `basic_min_bal_fmc` double NOT NULL DEFAULT '0',
  `chairman_max_request_usd` double DEFAULT '0',
  `executive_max_request_usd` double NOT NULL DEFAULT '0',
  `regular_max_request_usd` double NOT NULL DEFAULT '0',
  `associate_max_request_usd` double NOT NULL DEFAULT '0',
  `basic_max_request_usd` double NOT NULL DEFAULT '0',
  `chairman_min_request_usd` double DEFAULT '0',
  `executive_min_request_usd` double NOT NULL DEFAULT '0',
  `regular_min_request_usd` double NOT NULL DEFAULT '0',
  `associate_min_request_usd` double NOT NULL DEFAULT '0',
  `basic_min_request_usd` double NOT NULL DEFAULT '0',
  `chairman_min_convert_usd` double DEFAULT '0',
  `executive_min_convert_usd` double NOT NULL DEFAULT '0',
  `regular_min_convert_usd` double NOT NULL DEFAULT '0',
  `associate_min_convert_usd` double NOT NULL DEFAULT '0',
  `basic_min_convert_usd` double NOT NULL DEFAULT '0',
  `chairman_max_convert_usd` double DEFAULT '0',
  `executive_max_convert_usd` double NOT NULL DEFAULT '0',
  `regular_max_convert_usd` double NOT NULL DEFAULT '0',
  `associate_max_convert_usd` double NOT NULL DEFAULT '0',
  `basic_max_convert_usd` double NOT NULL DEFAULT '0',
  `chairman_min_convert_fmc` double DEFAULT '0',
  `executive_min_convert_fmc` double NOT NULL DEFAULT '0',
  `regular_min_convert_fmc` double NOT NULL DEFAULT '0',
  `associate_min_convert_fmc` double NOT NULL DEFAULT '0',
  `basic_min_convert_fmc` double NOT NULL DEFAULT '0',
  `chairman_convert_points_cut` double DEFAULT '0',
  `executive_convert_points_cut` double NOT NULL DEFAULT '0',
  `regular_convert_points_cut` double NOT NULL DEFAULT '0',
  `associate_convert_points_cut` double NOT NULL DEFAULT '0',
  `basic_convert_points_cut` double NOT NULL DEFAULT '0',
  `chairman_convert_points_usd` double DEFAULT '0',
  `executive_convert_points_usd` double NOT NULL DEFAULT '0',
  `regular_convert_points_usd` double NOT NULL DEFAULT '0',
  `associate_convert_points_usd` double NOT NULL DEFAULT '0',
  `basic_convert_points_usd` double NOT NULL DEFAULT '0',
  `chairman_savings_min_bal` double NOT NULL DEFAULT '0',
  `executive_savings_min_bal` double NOT NULL DEFAULT '0',
  `regular_savings_min_bal` double NOT NULL DEFAULT '0',
  `associate_savings_min_bal` double NOT NULL DEFAULT '0',
  `basic_savings_min_bal` double NOT NULL DEFAULT '0',
  `chairman_savings_target` double NOT NULL DEFAULT '0',
  `executive_savings_target` double NOT NULL DEFAULT '0',
  `regular_savings_target` double NOT NULL DEFAULT '0',
  `associate_savings_target` double NOT NULL DEFAULT '0',
  `basic_savings_target` double NOT NULL DEFAULT '0',
  `referral_mode` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'standard',
  `withdrawal_mode` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'standard',
  `cd_mode` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'no_cd',
  `efund_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'E-Fund',
  `share_fund_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Share',
  `loan_fund_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Loan',
  `p2p_price_buffer` double NOT NULL DEFAULT '0',
  `freezer` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_ancillaries`
--

/*!40000 ALTER TABLE `network_settings_ancillaries` DISABLE KEYS */;
INSERT INTO `network_settings_ancillaries` VALUES ('ECASH','AET','ask@p2pclub.online','Club P2P Online',3,1,1,100,100,100,100,100,1,1,1,1,1,1,1,1,1,1,20000,20000,20000,20000,20000,20,20,20,20,20,100,100,100,100,100,20000,20000,20000,20000,20000,10,10,10,10,10,3,3,3,3,3,100,100,100,100,100,0,0,0,0,0,1,0,0,0,0,'standard','coin','no_cd','USDT','SF','LF',9.6,200);
/*!40000 ALTER TABLE `network_settings_ancillaries` ENABLE KEYS */;

--
-- Table structure for table `network_settings_binary`
--

DROP TABLE IF EXISTS `network_settings_binary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_binary` (
  `hedge` enum('flushout','capping') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'flushout',
  `chairman_pairs` double NOT NULL DEFAULT '0',
  `executive_pairs` double NOT NULL DEFAULT '0',
  `regular_pairs` double NOT NULL DEFAULT '0',
  `associate_pairs` double NOT NULL DEFAULT '0',
  `basic_pairs` double NOT NULL DEFAULT '0',
  `chairman_max_cycle` double NOT NULL DEFAULT '0',
  `executive_max_cycle` double NOT NULL DEFAULT '0',
  `regular_max_cycle` double NOT NULL DEFAULT '0',
  `associate_max_cycle` double NOT NULL DEFAULT '0',
  `basic_max_cycle` double NOT NULL DEFAULT '0',
  `chairman_max_daily` double NOT NULL DEFAULT '0',
  `executive_max_daily` double NOT NULL DEFAULT '0',
  `regular_max_daily` double NOT NULL DEFAULT '0',
  `associate_max_daily` double NOT NULL DEFAULT '0',
  `basic_max_daily` double NOT NULL DEFAULT '0',
  `chairman_leg_retention` double NOT NULL DEFAULT '0',
  `executive_leg_retention` double NOT NULL DEFAULT '0',
  `regular_leg_retention` double NOT NULL DEFAULT '0',
  `associate_leg_retention` double NOT NULL DEFAULT '0',
  `basic_leg_retention` double NOT NULL DEFAULT '0',
  `chairman_pairs_safety` int NOT NULL DEFAULT '0',
  `executive_pairs_safety` int NOT NULL DEFAULT '0',
  `regular_pairs_safety` int NOT NULL DEFAULT '0',
  `associate_pairs_safety` int NOT NULL DEFAULT '0',
  `basic_pairs_safety` int NOT NULL DEFAULT '0',
  `chairman_max_pairs` double NOT NULL DEFAULT '0',
  `executive_max_pairs` double NOT NULL DEFAULT '0',
  `regular_max_pairs` double NOT NULL DEFAULT '0',
  `associate_max_pairs` double NOT NULL DEFAULT '0',
  `basic_max_pairs` double NOT NULL DEFAULT '0',
  `chairman_binary_sponsored` int NOT NULL DEFAULT '0',
  `executive_binary_sponsored` int NOT NULL DEFAULT '0',
  `regular_binary_sponsored` int NOT NULL DEFAULT '0',
  `associate_binary_sponsored` int NOT NULL DEFAULT '0',
  `basic_binary_sponsored` int NOT NULL DEFAULT '0',
  `chairman_required_pairs` double NOT NULL DEFAULT '0',
  `executive_required_pairs` double NOT NULL DEFAULT '0',
  `regular_required_pairs` double NOT NULL DEFAULT '0',
  `associate_required_pairs` double NOT NULL DEFAULT '0',
  `basic_required_pairs` double NOT NULL DEFAULT '0',
  `chairman_pairs_proper` double NOT NULL DEFAULT '0',
  `executive_pairs_proper` double NOT NULL DEFAULT '0',
  `regular_pairs_proper` double NOT NULL DEFAULT '0',
  `associate_pairs_proper` double NOT NULL DEFAULT '0',
  `basic_pairs_proper` double NOT NULL DEFAULT '0',
  `chairman_pairs_capped` double NOT NULL DEFAULT '0',
  `executive_pairs_capped` double NOT NULL DEFAULT '0',
  `regular_pairs_capped` double NOT NULL DEFAULT '0',
  `associate_pairs_capped` double NOT NULL DEFAULT '0',
  `basic_pairs_capped` double NOT NULL DEFAULT '0',
  `chairman_pairs_reactivate` double NOT NULL DEFAULT '0',
  `executive_pairs_reactivate` double NOT NULL DEFAULT '0',
  `regular_pairs_reactivate` double NOT NULL DEFAULT '0',
  `associate_pairs_reactivate` double NOT NULL DEFAULT '0',
  `basic_pairs_reactivate` double NOT NULL DEFAULT '0',
  `chairman_capping_cycle_max` int NOT NULL DEFAULT '0',
  `executive_capping_cycle_max` int NOT NULL DEFAULT '0',
  `regular_capping_cycle_max` int NOT NULL DEFAULT '0',
  `associate_capping_cycle_max` int NOT NULL DEFAULT '0',
  `basic_capping_cycle_max` int NOT NULL DEFAULT '0',
  `chairman_maximum_income` double NOT NULL DEFAULT '0',
  `executive_maximum_income` double NOT NULL DEFAULT '0',
  `regular_maximum_income` double NOT NULL DEFAULT '0',
  `associate_maximum_income` double NOT NULL DEFAULT '0',
  `basic_maximum_income` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_binary`
--

/*!40000 ALTER TABLE `network_settings_binary` DISABLE KEYS */;
INSERT INTO `network_settings_binary` VALUES ('capping',0,0,30,20,10,0,0,100,100,100,0,0,100,100,100,0,0,0,0,0,0,0,0,0,0,0,0,4000,3000,1500,0,0,0,0,0,0,0,0,0,0,0,0,30,20,10,0,0,30,20,10,0,0,300,200,100,0,0,1000000,50,50,0,0,4000000000,150000,75000);
/*!40000 ALTER TABLE `network_settings_binary` ENABLE KEYS */;

--
-- Table structure for table `network_settings_echelon`
--

DROP TABLE IF EXISTS `network_settings_echelon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_echelon` (
  `executive_echelon_share_1` double NOT NULL DEFAULT '0',
  `regular_echelon_share_1` double NOT NULL DEFAULT '0',
  `associate_echelon_share_1` double NOT NULL DEFAULT '0',
  `basic_echelon_share_1` double NOT NULL DEFAULT '0',
  `executive_echelon_share_2` double NOT NULL DEFAULT '0',
  `regular_echelon_share_2` double NOT NULL DEFAULT '0',
  `associate_echelon_share_2` double NOT NULL DEFAULT '0',
  `basic_echelon_share_2` double NOT NULL DEFAULT '0',
  `executive_echelon_share_3` double NOT NULL DEFAULT '0',
  `regular_echelon_share_3` double NOT NULL DEFAULT '0',
  `associate_echelon_share_3` double NOT NULL DEFAULT '0',
  `basic_echelon_share_3` double NOT NULL DEFAULT '0',
  `executive_echelon_share_4` double NOT NULL DEFAULT '0',
  `regular_echelon_share_4` double NOT NULL DEFAULT '0',
  `associate_echelon_share_4` double NOT NULL DEFAULT '0',
  `basic_echelon_share_4` double NOT NULL DEFAULT '0',
  `executive_echelon_share_5` double NOT NULL DEFAULT '0',
  `regular_echelon_share_5` double NOT NULL DEFAULT '0',
  `associate_echelon_share_5` double NOT NULL DEFAULT '0',
  `basic_echelon_share_5` double NOT NULL DEFAULT '0',
  `executive_echelon_share_6` double NOT NULL DEFAULT '0',
  `regular_echelon_share_6` double NOT NULL DEFAULT '0',
  `associate_echelon_share_6` double NOT NULL DEFAULT '0',
  `basic_echelon_share_6` double NOT NULL DEFAULT '0',
  `executive_echelon_share_7` double NOT NULL DEFAULT '0',
  `regular_echelon_share_7` double NOT NULL DEFAULT '0',
  `associate_echelon_share_7` double NOT NULL DEFAULT '0',
  `basic_echelon_share_7` double NOT NULL DEFAULT '0',
  `executive_echelon_share_8` double NOT NULL DEFAULT '0',
  `regular_echelon_share_8` double NOT NULL DEFAULT '0',
  `associate_echelon_share_8` double NOT NULL DEFAULT '0',
  `basic_echelon_share_8` double NOT NULL DEFAULT '0',
  `executive_echelon_share_9` double NOT NULL DEFAULT '0',
  `regular_echelon_share_9` double NOT NULL DEFAULT '0',
  `associate_echelon_share_9` double NOT NULL DEFAULT '0',
  `basic_echelon_share_9` double NOT NULL DEFAULT '0',
  `executive_echelon_share_10` double NOT NULL DEFAULT '0',
  `regular_echelon_share_10` double NOT NULL DEFAULT '0',
  `associate_echelon_share_10` double NOT NULL DEFAULT '0',
  `basic_echelon_share_10` double NOT NULL DEFAULT '0',
  `executive_echelon_share_11` double NOT NULL DEFAULT '0',
  `regular_echelon_share_11` int DEFAULT NULL,
  `associate_echelon_share_11` int DEFAULT NULL,
  `basic_echelon_share_11` int DEFAULT NULL,
  `executive_echelon_share_12` int DEFAULT NULL,
  `regular_echelon_share_12` int DEFAULT NULL,
  `associate_echelon_share_12` int DEFAULT NULL,
  `basic_echelon_share_12` int DEFAULT NULL,
  `executive_echelon_share_13` int DEFAULT NULL,
  `regular_echelon_share_13` int DEFAULT NULL,
  `associate_echelon_share_13` int DEFAULT NULL,
  `basic_echelon_share_13` int DEFAULT NULL,
  `executive_echelon_share_14` int DEFAULT NULL,
  `regular_echelon_share_14` int DEFAULT NULL,
  `associate_echelon_share_14` int DEFAULT NULL,
  `basic_echelon_share_14` int DEFAULT NULL,
  `executive_echelon_share_15` int DEFAULT NULL,
  `regular_echelon_share_15` int DEFAULT NULL,
  `associate_echelon_share_15` int DEFAULT NULL,
  `basic_echelon_share_15` int DEFAULT NULL,
  `executive_echelon_share_16` int DEFAULT NULL,
  `regular_echelon_share_16` int DEFAULT NULL,
  `associate_echelon_share_16` int DEFAULT NULL,
  `basic_echelon_share_16` int DEFAULT NULL,
  `executive_echelon_share_17` int DEFAULT NULL,
  `regular_echelon_share_17` int DEFAULT NULL,
  `associate_echelon_share_17` int DEFAULT NULL,
  `basic_echelon_share_17` int DEFAULT NULL,
  `executive_echelon_share_18` int DEFAULT NULL,
  `regular_echelon_share_18` int DEFAULT NULL,
  `associate_echelon_share_18` int DEFAULT NULL,
  `basic_echelon_share_18` int DEFAULT NULL,
  `executive_echelon_share_19` int DEFAULT NULL,
  `regular_echelon_share_19` int DEFAULT NULL,
  `associate_echelon_share_19` int DEFAULT NULL,
  `basic_echelon_share_19` int DEFAULT NULL,
  `executive_echelon_share_20` int DEFAULT NULL,
  `regular_echelon_share_20` int DEFAULT NULL,
  `associate_echelon_share_20` int DEFAULT NULL,
  `basic_echelon_share_20` int DEFAULT NULL,
  `executive_echelon_share_cut_1` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_1` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_1` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_1` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_2` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_2` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_2` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_2` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_3` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_3` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_3` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_3` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_4` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_4` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_4` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_4` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_5` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_5` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_5` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_5` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_6` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_6` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_6` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_6` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_7` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_7` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_7` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_7` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_8` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_8` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_8` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_8` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_9` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_9` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_9` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_9` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_10` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_10` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_10` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_10` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_11` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_11` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_11` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_11` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_12` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_12` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_12` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_12` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_13` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_13` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_13` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_13` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_14` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_14` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_14` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_14` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_15` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_15` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_15` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_15` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_16` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_16` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_16` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_16` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_17` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_17` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_17` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_17` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_18` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_18` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_18` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_18` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_19` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_19` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_19` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_19` double NOT NULL DEFAULT '0',
  `executive_echelon_share_cut_20` double NOT NULL DEFAULT '0',
  `regular_echelon_share_cut_20` double NOT NULL DEFAULT '0',
  `associate_echelon_share_cut_20` double NOT NULL DEFAULT '0',
  `basic_echelon_share_cut_20` double NOT NULL DEFAULT '0',
  `executive_echelon_level` int NOT NULL DEFAULT '0',
  `regular_echelon_level` int NOT NULL DEFAULT '0',
  `associate_echelon_level` int NOT NULL DEFAULT '0',
  `basic_echelon_level` int NOT NULL DEFAULT '0',
  `executive_echelon_points` double NOT NULL DEFAULT '0',
  `regular_echelon_points` double NOT NULL DEFAULT '0',
  `associate_echelon_points` double NOT NULL DEFAULT '0',
  `basic_echelon_points` double NOT NULL DEFAULT '0',
  `executive_echelon_fmc` double NOT NULL DEFAULT '0',
  `regular_echelon_fmc` double NOT NULL DEFAULT '0',
  `associate_echelon_fmc` double NOT NULL DEFAULT '0',
  `basic_echelon_fmc` double NOT NULL DEFAULT '0',
  `executive_echelon_sponsored` int NOT NULL DEFAULT '0',
  `regular_echelon_sponsored` int NOT NULL DEFAULT '0',
  `associate_echelon_sponsored` int NOT NULL DEFAULT '0',
  `basic_echelon_sponsored` int NOT NULL DEFAULT '0',
  `executive_echelon_maximum` double NOT NULL DEFAULT '0',
  `regular_echelon_maximum` double NOT NULL DEFAULT '0',
  `associate_echelon_maximum` double NOT NULL DEFAULT '0',
  `basic_echelon_maximum` double NOT NULL DEFAULT '0',
  `executive_echelon_max_daily_income` double NOT NULL DEFAULT '0',
  `regular_echelon_max_daily_income` double NOT NULL DEFAULT '0',
  `associate_echelon_max_daily_income` double NOT NULL DEFAULT '0',
  `basic_echelon_max_daily_income` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_1` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_2` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_3` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_4` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_5` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_6` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_7` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_8` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_9` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_10` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_11` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_12` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_13` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_14` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_15` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_16` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_17` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_18` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_19` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_20` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_1` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_2` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_3` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_4` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_5` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_6` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_7` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_8` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_9` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_10` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_11` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_12` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_13` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_14` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_15` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_16` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_17` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_18` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_19` double NOT NULL DEFAULT '0',
  `chairman_echelon_share_cut_20` double NOT NULL DEFAULT '0',
  `chairman_echelon_level` int NOT NULL DEFAULT '0',
  `chairman_echelon_points` double NOT NULL DEFAULT '0',
  `chairman_echelon_fmc` double NOT NULL DEFAULT '0',
  `chairman_echelon_sponsored` int NOT NULL DEFAULT '0',
  `chairman_echelon_maximum` double NOT NULL DEFAULT '0',
  `chairman_echelon_max_daily_income` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_echelon`
--

/*!40000 ALTER TABLE `network_settings_echelon` DISABLE KEYS */;
INSERT INTO `network_settings_echelon` VALUES (14,13,12,11,10,10,10,10,10,10,10,10,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,100,100,100,100,100,100,100,100,100,100,100,100,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,3,3,3,3,0,0,0,0,0,0,0,0,0,0,0,0,2300000,2300000,2300000,2300000,2200000,2100000,2000000,1900000,15,10,10,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,100,100,100,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,3,0,0,0,2300000,2300000);
/*!40000 ALTER TABLE `network_settings_echelon` ENABLE KEYS */;

--
-- Table structure for table `network_settings_elite_reward`
--

DROP TABLE IF EXISTS `network_settings_elite_reward`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_elite_reward` (
  `directs` int NOT NULL DEFAULT '0',
  `sales` double NOT NULL DEFAULT '0',
  `group_limit` int NOT NULL DEFAULT '0',
  `repeat_purchase_reward` double NOT NULL DEFAULT '0',
  `basic_reward` double NOT NULL DEFAULT '0',
  `associate_reward` double NOT NULL DEFAULT '0',
  `regular_reward` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_elite_reward`
--

/*!40000 ALTER TABLE `network_settings_elite_reward` DISABLE KEYS */;
INSERT INTO `network_settings_elite_reward` VALUES (10,500000,20,10,50,350,2000);
/*!40000 ALTER TABLE `network_settings_elite_reward` ENABLE KEYS */;

--
-- Table structure for table `network_settings_entry`
--

DROP TABLE IF EXISTS `network_settings_entry`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_entry` (
  `chairman_entry` double NOT NULL DEFAULT '0',
  `executive_entry` double NOT NULL DEFAULT '0',
  `regular_entry` double NOT NULL DEFAULT '0',
  `associate_entry` double NOT NULL DEFAULT '0',
  `basic_entry` double NOT NULL DEFAULT '0',
  `starter_entry` double NOT NULL DEFAULT '0',
  `chairman_package_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'chairman',
  `executive_package_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'executive',
  `regular_package_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'regular',
  `associate_package_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'associate',
  `basic_package_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'basic',
  `starter_package_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'starter',
  `chairman_global` double NOT NULL DEFAULT '0',
  `executive_global` double NOT NULL DEFAULT '0',
  `regular_global` double NOT NULL DEFAULT '0',
  `associate_global` double NOT NULL DEFAULT '0',
  `basic_global` double NOT NULL DEFAULT '0',
  `starter_global` double NOT NULL DEFAULT '0',
  `chairman_points` double NOT NULL DEFAULT '0',
  `executive_points` double NOT NULL DEFAULT '0',
  `regular_points` double NOT NULL DEFAULT '0',
  `associate_points` double NOT NULL DEFAULT '0',
  `basic_points` double NOT NULL DEFAULT '0',
  `starter_points` double DEFAULT '0',
  `chairman_p2p_share` double DEFAULT '0',
  `executive_p2p_share` double DEFAULT '0',
  `regular_p2p_share` double DEFAULT '0',
  `associate_p2p_share` double DEFAULT '0',
  `basic_p2p_share` double DEFAULT '0',
  `starter_p2p_share` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_entry`
--

/*!40000 ALTER TABLE `network_settings_entry` DISABLE KEYS */;
INSERT INTO `network_settings_entry` VALUES (1000000,100000,10000,1000,100,20,'1000000','100000','10000','1000','100','20',0,0,0,0,0,0,1000000,100000,10000,1000,100,20,10,8,7,6,5,3);
/*!40000 ALTER TABLE `network_settings_entry` ENABLE KEYS */;

--
-- Table structure for table `network_settings_freeze`
--

DROP TABLE IF EXISTS `network_settings_freeze`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_freeze` (
  `executive_reactivation` double NOT NULL DEFAULT '0',
  `regular_reactivation` double NOT NULL DEFAULT '0',
  `associate_reactivation` double NOT NULL DEFAULT '0',
  `basic_reactivation` double NOT NULL DEFAULT '0',
  `executive_percentage` double NOT NULL DEFAULT '0',
  `regular_percentage` double NOT NULL DEFAULT '0',
  `associate_percentage` double NOT NULL DEFAULT '0',
  `basic_percentage` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_freeze`
--

/*!40000 ALTER TABLE `network_settings_freeze` DISABLE KEYS */;
INSERT INTO `network_settings_freeze` VALUES (300,300,200,100,1000000000,1000000000,1000000000,1000000000);
/*!40000 ALTER TABLE `network_settings_freeze` ENABLE KEYS */;

--
-- Table structure for table `network_settings_harvest`
--

DROP TABLE IF EXISTS `network_settings_harvest`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_harvest` (
  `executive_harvest_1_bonus` double NOT NULL DEFAULT '0',
  `regular_harvest_1_bonus` double NOT NULL DEFAULT '0',
  `associate_harvest_1_bonus` double NOT NULL DEFAULT '0',
  `basic_harvest_1_bonus` double NOT NULL DEFAULT '0',
  `executive_harvest_2_bonus` double NOT NULL DEFAULT '0',
  `regular_harvest_2_bonus` double NOT NULL DEFAULT '0',
  `associate_harvest_2_bonus` double NOT NULL DEFAULT '0',
  `basic_harvest_2_bonus` double NOT NULL DEFAULT '0',
  `executive_harvest_3_bonus` double NOT NULL DEFAULT '0',
  `regular_harvest_3_bonus` double NOT NULL DEFAULT '0',
  `associate_harvest_3_bonus` double NOT NULL DEFAULT '0',
  `basic_harvest_3_bonus` double NOT NULL DEFAULT '0',
  `executive_harvest_4_bonus` double NOT NULL DEFAULT '0',
  `regular_harvest_4_bonus` double NOT NULL DEFAULT '0',
  `associate_harvest_4_bonus` double NOT NULL DEFAULT '0',
  `basic_harvest_4_bonus` double NOT NULL DEFAULT '0',
  `executive_harvest_5_bonus` double NOT NULL DEFAULT '0',
  `regular_harvest_5_bonus` double NOT NULL DEFAULT '0',
  `associate_harvest_5_bonus` double NOT NULL DEFAULT '0',
  `basic_harvest_5_bonus` double NOT NULL DEFAULT '0',
  `executive_harvest_6_bonus` double NOT NULL DEFAULT '0',
  `regular_harvest_6_bonus` double NOT NULL DEFAULT '0',
  `associate_harvest_6_bonus` double NOT NULL DEFAULT '0',
  `basic_harvest_6_bonus` double NOT NULL DEFAULT '0',
  `executive_harvest_7_bonus` double NOT NULL DEFAULT '0',
  `regular_harvest_7_bonus` double NOT NULL DEFAULT '0',
  `associate_harvest_7_bonus` double NOT NULL DEFAULT '0',
  `basic_harvest_7_bonus` double NOT NULL DEFAULT '0',
  `executive_harvest_8_bonus` double NOT NULL DEFAULT '0',
  `regular_harvest_8_bonus` double NOT NULL DEFAULT '0',
  `associate_harvest_8_bonus` double NOT NULL DEFAULT '0',
  `basic_harvest_8_bonus` double NOT NULL DEFAULT '0',
  `executive_harvest_9_bonus` double NOT NULL DEFAULT '0',
  `regular_harvest_9_bonus` double NOT NULL DEFAULT '0',
  `associate_harvest_9_bonus` double NOT NULL DEFAULT '0',
  `basic_harvest_9_bonus` double NOT NULL DEFAULT '0',
  `executive_harvest_10_bonus` double NOT NULL DEFAULT '0',
  `regular_harvest_10_bonus` double NOT NULL DEFAULT '0',
  `associate_harvest_10_bonus` double NOT NULL DEFAULT '0',
  `basic_harvest_10_bonus` double NOT NULL DEFAULT '0',
  `executive_harvest_level` int NOT NULL DEFAULT '0',
  `regular_harvest_level` int NOT NULL DEFAULT '0',
  `associate_harvest_level` int NOT NULL DEFAULT '0',
  `basic_harvest_level` int NOT NULL DEFAULT '0',
  `executive_harvest_width` int NOT NULL DEFAULT '0',
  `regular_harvest_width` int NOT NULL DEFAULT '0',
  `associate_harvest_width` int NOT NULL DEFAULT '0',
  `basic_harvest_width` int NOT NULL DEFAULT '0',
  `executive_harvest_sponsored` int NOT NULL DEFAULT '0',
  `regular_harvest_sponsored` int NOT NULL DEFAULT '0',
  `associate_harvest_sponsored` int NOT NULL DEFAULT '0',
  `basic_harvest_sponsored` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_harvest`
--

/*!40000 ALTER TABLE `network_settings_harvest` DISABLE KEYS */;
INSERT INTO `network_settings_harvest` VALUES (0,0,2000,1000,0,0,4000,2000,0,0,8000,4000,0,0,12000,5000,0,0,25000,10000,0,0,100000,0,0,0,250000,0,0,0,480000,0,0,0,2500000,0,0,0,5000000,0,10,10,10,10,2,2,2,2,2,2,1,1);
/*!40000 ALTER TABLE `network_settings_harvest` ENABLE KEYS */;

--
-- Table structure for table `network_settings_indirect_referral`
--

DROP TABLE IF EXISTS `network_settings_indirect_referral`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_indirect_referral` (
  `executive_indirect_referral_share_1` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_1` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_1` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_1` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_2` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_2` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_2` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_2` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_3` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_3` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_3` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_3` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_4` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_4` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_4` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_4` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_5` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_5` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_5` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_5` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_6` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_6` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_6` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_6` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_7` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_7` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_7` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_7` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_8` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_8` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_8` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_8` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_9` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_9` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_9` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_9` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_10` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_10` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_10` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_10` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_11` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_11` int DEFAULT NULL,
  `associate_indirect_referral_share_11` int DEFAULT NULL,
  `basic_indirect_referral_share_11` int DEFAULT NULL,
  `executive_indirect_referral_share_12` int DEFAULT NULL,
  `regular_indirect_referral_share_12` int DEFAULT NULL,
  `associate_indirect_referral_share_12` int DEFAULT NULL,
  `basic_indirect_referral_share_12` int DEFAULT NULL,
  `executive_indirect_referral_share_13` int DEFAULT NULL,
  `regular_indirect_referral_share_13` int DEFAULT NULL,
  `associate_indirect_referral_share_13` int DEFAULT NULL,
  `basic_indirect_referral_share_13` int DEFAULT NULL,
  `executive_indirect_referral_share_14` int DEFAULT NULL,
  `regular_indirect_referral_share_14` int DEFAULT NULL,
  `associate_indirect_referral_share_14` int DEFAULT NULL,
  `basic_indirect_referral_share_14` int DEFAULT NULL,
  `executive_indirect_referral_share_15` int DEFAULT NULL,
  `regular_indirect_referral_share_15` int DEFAULT NULL,
  `associate_indirect_referral_share_15` int DEFAULT NULL,
  `basic_indirect_referral_share_15` int DEFAULT NULL,
  `executive_indirect_referral_share_16` int DEFAULT NULL,
  `regular_indirect_referral_share_16` int DEFAULT NULL,
  `associate_indirect_referral_share_16` int DEFAULT NULL,
  `basic_indirect_referral_share_16` int DEFAULT NULL,
  `executive_indirect_referral_share_17` int DEFAULT NULL,
  `regular_indirect_referral_share_17` int DEFAULT NULL,
  `associate_indirect_referral_share_17` int DEFAULT NULL,
  `basic_indirect_referral_share_17` int DEFAULT NULL,
  `executive_indirect_referral_share_18` int DEFAULT NULL,
  `regular_indirect_referral_share_18` int DEFAULT NULL,
  `associate_indirect_referral_share_18` int DEFAULT NULL,
  `basic_indirect_referral_share_18` int DEFAULT NULL,
  `executive_indirect_referral_share_19` int DEFAULT NULL,
  `regular_indirect_referral_share_19` int DEFAULT NULL,
  `associate_indirect_referral_share_19` int DEFAULT NULL,
  `basic_indirect_referral_share_19` int DEFAULT NULL,
  `executive_indirect_referral_share_20` int DEFAULT NULL,
  `regular_indirect_referral_share_20` int DEFAULT NULL,
  `associate_indirect_referral_share_20` int DEFAULT NULL,
  `basic_indirect_referral_share_20` int DEFAULT NULL,
  `executive_indirect_referral_share_cut_1` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_1` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_1` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_1` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_2` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_2` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_2` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_2` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_3` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_3` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_3` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_3` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_4` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_4` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_4` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_4` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_5` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_5` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_5` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_5` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_6` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_6` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_6` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_6` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_7` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_7` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_7` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_7` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_8` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_8` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_8` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_8` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_9` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_9` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_9` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_9` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_10` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_10` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_10` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_10` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_11` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_11` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_11` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_11` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_12` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_12` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_12` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_12` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_13` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_13` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_13` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_13` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_14` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_14` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_14` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_14` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_15` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_15` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_15` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_15` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_16` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_16` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_16` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_16` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_17` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_17` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_17` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_17` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_18` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_18` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_18` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_18` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_19` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_19` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_19` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_19` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_share_cut_20` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_share_cut_20` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_share_cut_20` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_share_cut_20` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_level` int NOT NULL DEFAULT '0',
  `regular_indirect_referral_level` int NOT NULL DEFAULT '0',
  `associate_indirect_referral_level` int NOT NULL DEFAULT '0',
  `basic_indirect_referral_level` int NOT NULL DEFAULT '0',
  `executive_indirect_referral_points` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_points` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_points` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_points` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_fmc` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_fmc` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_fmc` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_fmc` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_sponsored` int NOT NULL DEFAULT '0',
  `regular_indirect_referral_sponsored` int NOT NULL DEFAULT '0',
  `associate_indirect_referral_sponsored` int NOT NULL DEFAULT '0',
  `basic_indirect_referral_sponsored` int NOT NULL DEFAULT '0',
  `executive_indirect_referral_maximum` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_maximum` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_maximum` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_maximum` double NOT NULL DEFAULT '0',
  `executive_indirect_referral_max_daily_income` double NOT NULL DEFAULT '0',
  `regular_indirect_referral_max_daily_income` double NOT NULL DEFAULT '0',
  `associate_indirect_referral_max_daily_income` double NOT NULL DEFAULT '0',
  `basic_indirect_referral_max_daily_income` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_1` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_2` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_3` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_4` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_5` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_6` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_7` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_8` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_9` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_10` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_11` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_12` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_13` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_14` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_15` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_16` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_17` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_18` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_19` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_20` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_1` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_2` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_3` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_4` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_5` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_6` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_7` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_8` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_9` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_10` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_11` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_12` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_13` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_14` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_15` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_16` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_17` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_18` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_19` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_share_cut_20` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_level` int NOT NULL DEFAULT '0',
  `chairman_indirect_referral_points` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_fmc` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_sponsored` int NOT NULL DEFAULT '0',
  `chairman_indirect_referral_maximum` double NOT NULL DEFAULT '0',
  `chairman_indirect_referral_max_daily_income` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_indirect_referral`
--

/*!40000 ALTER TABLE `network_settings_indirect_referral` DISABLE KEYS */;
INSERT INTO `network_settings_indirect_referral` VALUES (0,30,20,10,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,5,5,5,5,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,0,0,0,0,0,0,0,0,0,0,0,0,0,100000000,100000000,100000000,0,10000,1000,100,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `network_settings_indirect_referral` ENABLE KEYS */;

--
-- Table structure for table `network_settings_investment`
--

DROP TABLE IF EXISTS `network_settings_investment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_investment` (
  `regular_maturity` int NOT NULL DEFAULT '0',
  `associate_maturity` int NOT NULL DEFAULT '0',
  `basic_maturity` int NOT NULL DEFAULT '0',
  `executive_principal_cut` double NOT NULL DEFAULT '0',
  `regular_principal_cut` double NOT NULL DEFAULT '0',
  `associate_principal_cut` double NOT NULL DEFAULT '0',
  `basic_principal_cut` double NOT NULL DEFAULT '0',
  `executive_interest` double NOT NULL DEFAULT '0',
  `regular_interest` double NOT NULL DEFAULT '0',
  `associate_interest` double NOT NULL DEFAULT '0',
  `basic_interest` double NOT NULL DEFAULT '0',
  `executive_fixed_daily_interval` int NOT NULL DEFAULT '0',
  `regular_fixed_daily_interval` int NOT NULL DEFAULT '0',
  `associate_fixed_daily_interval` int NOT NULL DEFAULT '0',
  `basic_fixed_daily_interval` int NOT NULL DEFAULT '0',
  `executive_fixed_daily_processing` int NOT NULL DEFAULT '0',
  `regular_fixed_daily_processing` int NOT NULL DEFAULT '0',
  `associate_fixed_daily_processing` int NOT NULL DEFAULT '0',
  `basic_fixed_daily_processing` int NOT NULL DEFAULT '0',
  `executive_fixed_daily_donation` double NOT NULL DEFAULT '0',
  `regular_fixed_daily_donation` double NOT NULL DEFAULT '0',
  `associate_fixed_daily_donation` double NOT NULL DEFAULT '0',
  `basic_fixed_daily_donation` double NOT NULL DEFAULT '0',
  `executive_fixed_daily_minimum_deposit` double NOT NULL DEFAULT '0',
  `regular_fixed_daily_minimum_deposit` double NOT NULL DEFAULT '0',
  `associate_fixed_daily_minimum_deposit` double NOT NULL DEFAULT '0',
  `basic_fixed_daily_minimum_deposit` double NOT NULL DEFAULT '0',
  `executive_fixed_daily_maximum_deposit` double NOT NULL DEFAULT '0',
  `regular_fixed_daily_maximum_deposit` double NOT NULL DEFAULT '0',
  `associate_fixed_daily_maximum_deposit` double NOT NULL DEFAULT '0',
  `basic_fixed_daily_maximum_deposit` double NOT NULL DEFAULT '0',
  `executive_fixed_daily_required_directs` int NOT NULL DEFAULT '0',
  `regular_fixed_daily_required_directs` int NOT NULL DEFAULT '0',
  `associate_fixed_daily_required_directs` int NOT NULL DEFAULT '0',
  `basic_fixed_daily_required_directs` int NOT NULL DEFAULT '0',
  `executive_top_up_principal_cut` double NOT NULL DEFAULT '0',
  `regular_top_up_principal_cut` double NOT NULL DEFAULT '0',
  `associate_top_up_principal_cut` double NOT NULL DEFAULT '0',
  `basic_top_up_principal_cut` double NOT NULL DEFAULT '0',
  `executive_top_up_interest` double NOT NULL DEFAULT '0',
  `regular_top_up_interest` double NOT NULL DEFAULT '0',
  `associate_top_up_interest` double NOT NULL DEFAULT '0',
  `basic_top_up_interest` double NOT NULL DEFAULT '0',
  `executive_top_up_maturity` int NOT NULL DEFAULT '0',
  `regular_top_up_maturity` int NOT NULL DEFAULT '0',
  `associate_top_up_maturity` int NOT NULL DEFAULT '0',
  `basic_top_up_maturity` int NOT NULL DEFAULT '0',
  `executive_top_up_minimum` double NOT NULL DEFAULT '0',
  `regular_top_up_minimum` double NOT NULL DEFAULT '0',
  `associate_top_up_minimum` double NOT NULL DEFAULT '0',
  `basic_top_up_minimum` double NOT NULL DEFAULT '0',
  `executive_top_up_maximum` double NOT NULL DEFAULT '0',
  `regular_top_up_maximum` double NOT NULL DEFAULT '0',
  `associate_top_up_maximum` double NOT NULL DEFAULT '0',
  `basic_top_up_maximum` double NOT NULL DEFAULT '0',
  `executive_top_up_principal_maximum` double NOT NULL DEFAULT '0',
  `regular_top_up_principal_maximum` double NOT NULL DEFAULT '0',
  `executive_principal` double NOT NULL DEFAULT '0',
  `regular_principal` double NOT NULL DEFAULT '0',
  `associate_principal` double NOT NULL DEFAULT '0',
  `basic_principal` double NOT NULL DEFAULT '0',
  `associate_top_up_principal_maximum` double NOT NULL DEFAULT '0',
  `basic_top_up_principal_maximum` double NOT NULL DEFAULT '0',
  `executive_top_up_processing` int NOT NULL DEFAULT '0',
  `regular_top_up_processing` int NOT NULL DEFAULT '0',
  `associate_top_up_processing` int NOT NULL DEFAULT '0',
  `basic_top_up_processing` int NOT NULL DEFAULT '0',
  `executive_top_up_donation` double NOT NULL DEFAULT '0',
  `regular_top_up_donation` double NOT NULL DEFAULT '0',
  `associate_top_up_donation` double NOT NULL DEFAULT '0',
  `basic_top_up_donation` double NOT NULL DEFAULT '0',
  `executive_top_up_minimum_deposit` double NOT NULL DEFAULT '0',
  `regular_top_up_minimum_deposit` double NOT NULL DEFAULT '0',
  `associate_top_up_minimum_deposit` double NOT NULL DEFAULT '0',
  `basic_top_up_minimum_deposit` double NOT NULL DEFAULT '0',
  `executive_top_up_maximum_deposit` double NOT NULL DEFAULT '0',
  `regular_top_up_maximum_deposit` double NOT NULL DEFAULT '0',
  `associate_top_up_maximum_deposit` double NOT NULL DEFAULT '0',
  `basic_top_up_maximum_deposit` double NOT NULL DEFAULT '0',
  `executive_top_up_required_directs` int NOT NULL DEFAULT '0',
  `regular_top_up_required_directs` int NOT NULL DEFAULT '0',
  `associate_top_up_required_directs` int NOT NULL DEFAULT '0',
  `basic_top_up_required_directs` int NOT NULL DEFAULT '0',
  `executive_fast_track_principal_cut` double NOT NULL DEFAULT '0',
  `regular_fast_track_principal_cut` double NOT NULL DEFAULT '0',
  `associate_fast_track_principal_cut` double NOT NULL DEFAULT '0',
  `basic_fast_track_principal_cut` double NOT NULL DEFAULT '0',
  `executive_fast_track_interest` double NOT NULL DEFAULT '0',
  `regular_fast_track_interest` double NOT NULL DEFAULT '0',
  `associate_fast_track_interest` double NOT NULL DEFAULT '0',
  `basic_fast_track_interest` double NOT NULL DEFAULT '0',
  `executive_fast_track_maturity` int NOT NULL DEFAULT '0',
  `regular_fast_track_maturity` int NOT NULL DEFAULT '0',
  `associate_fast_track_maturity` int NOT NULL DEFAULT '0',
  `basic_fast_track_maturity` int NOT NULL DEFAULT '0',
  `executive_fast_track_minimum` double NOT NULL DEFAULT '0',
  `regular_fast_track_minimum` double NOT NULL DEFAULT '0',
  `associate_fast_track_minimum` double NOT NULL DEFAULT '0',
  `basic_fast_track_minimum` double NOT NULL DEFAULT '0',
  `executive_fast_track_maximum` double NOT NULL DEFAULT '0',
  `regular_fast_track_maximum` double NOT NULL DEFAULT '0',
  `associate_fast_track_maximum` double NOT NULL DEFAULT '0',
  `basic_fast_track_maximum` double NOT NULL DEFAULT '0',
  `executive_fast_track_principal_maximum` double NOT NULL DEFAULT '0',
  `regular_fast_track_principal_maximum` double NOT NULL DEFAULT '0',
  `associate_fast_track_principal_maximum` double NOT NULL DEFAULT '0',
  `basic_fast_track_principal_maximum` double NOT NULL DEFAULT '0',
  `executive_fast_track_interval` int NOT NULL DEFAULT '0',
  `regular_fast_track_interval` int NOT NULL DEFAULT '0',
  `associate_fast_track_interval` int NOT NULL DEFAULT '0',
  `basic_fast_track_interval` int NOT NULL DEFAULT '0',
  `executive_fast_track_processing` int NOT NULL DEFAULT '0',
  `regular_fast_track_processing` int NOT NULL DEFAULT '0',
  `associate_fast_track_processing` int NOT NULL DEFAULT '0',
  `basic_fast_track_processing` int NOT NULL DEFAULT '0',
  `executive_fast_track_donation` double NOT NULL DEFAULT '0',
  `regular_fast_track_donation` double NOT NULL DEFAULT '0',
  `associate_fast_track_donation` double NOT NULL DEFAULT '0',
  `basic_fast_track_donation` double NOT NULL DEFAULT '0',
  `executive_fast_track_minimum_deposit` double NOT NULL DEFAULT '0',
  `regular_fast_track_minimum_deposit` double NOT NULL DEFAULT '0',
  `associate_fast_track_minimum_deposit` double NOT NULL DEFAULT '0',
  `basic_fast_track_minimum_deposit` double NOT NULL DEFAULT '0',
  `executive_fast_track_maximum_deposit` double NOT NULL DEFAULT '0',
  `regular_fast_track_maximum_deposit` double NOT NULL DEFAULT '0',
  `associate_fast_track_maximum_deposit` double NOT NULL DEFAULT '0',
  `basic_fast_track_maximum_deposit` double NOT NULL DEFAULT '0',
  `executive_fast_track_required_directs` int NOT NULL DEFAULT '0',
  `regular_fast_track_required_directs` int NOT NULL DEFAULT '0',
  `associate_fast_track_required_directs` int NOT NULL DEFAULT '0',
  `basic_fast_track_required_directs` int NOT NULL DEFAULT '0',
  `executive_maturity` int NOT NULL DEFAULT '0',
  `executive_processing` int NOT NULL DEFAULT '0',
  `regular_processing` int NOT NULL DEFAULT '0',
  `associate_processing` int NOT NULL DEFAULT '0',
  `basic_processing` int NOT NULL DEFAULT '0',
  `executive_minimum_deposit` double NOT NULL DEFAULT '0',
  `regular_minimum_deposit` double NOT NULL DEFAULT '0',
  `associate_minimum_deposit` double NOT NULL DEFAULT '0',
  `basic_minimum_deposit` double NOT NULL DEFAULT '0',
  `executive_maximum_deposit` double NOT NULL DEFAULT '0',
  `regular_maximum_deposit` double NOT NULL DEFAULT '0',
  `associate_maximum_deposit` double NOT NULL DEFAULT '0',
  `basic_maximum_deposit` double NOT NULL DEFAULT '0',
  `executive_required_directs` int NOT NULL DEFAULT '0',
  `regular_required_directs` int NOT NULL DEFAULT '0',
  `associate_required_directs` int NOT NULL DEFAULT '0',
  `basic_required_directs` int NOT NULL DEFAULT '0',
  `executive_fixed_daily_principal` double NOT NULL DEFAULT '0',
  `regular_fixed_daily_principal` double NOT NULL DEFAULT '0',
  `associate_fixed_daily_principal` double NOT NULL DEFAULT '0',
  `basic_fixed_daily_principal` double NOT NULL DEFAULT '0',
  `executive_fixed_daily_principal_cut` double NOT NULL DEFAULT '0',
  `regular_fixed_daily_principal_cut` double NOT NULL DEFAULT '0',
  `associate_fixed_daily_principal_cut` double NOT NULL DEFAULT '0',
  `basic_fixed_daily_principal_cut` double NOT NULL DEFAULT '0',
  `executive_fixed_daily_interest` double NOT NULL DEFAULT '0',
  `regular_fixed_daily_interest` double NOT NULL DEFAULT '0',
  `associate_fixed_daily_interest` double NOT NULL DEFAULT '0',
  `basic_fixed_daily_interest` double NOT NULL DEFAULT '0',
  `executive_fixed_daily_maturity` int NOT NULL DEFAULT '0',
  `regular_fixed_daily_maturity` int NOT NULL DEFAULT '0',
  `associate_fixed_daily_maturity` int NOT NULL DEFAULT '0',
  `basic_fixed_daily_maturity` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_investment`
--

/*!40000 ALTER TABLE `network_settings_investment` DISABLE KEYS */;
INSERT INTO `network_settings_investment` VALUES (10,10,10,0,0,0,0,1.2,1.2,1.2,1.2,86400,86400,86400,86400,0,0,0,0,0,0,0,0,1,1,1,1,1000,1000,1000,1000,0,0,0,0,0,0,0,0,0,0,0,0,180,180,180,180,200,200,200,200,2000,1000,500,200,20000,10000,0,0,0,0,5000,1000,1,1,1,1,50,20,10,5,100,50,20,10,2021,2223,2425,2627,0,0,0,0,0,0,0,0,2,1,0.5,0.2,100,100,100,100,1000,1000,1000,1000,1000,1000,1000,1000,1000000,1000000,1000000,1000000,86400,86400,86400,86400,0,0,0,0,0,0,0,0,1,1,1,1,1000,1000,1000,1000,0,0,0,0,10,1,1,1,1,1000,100,10,2,123,456,789,1011,0,0,0,0,5000,1000,100,10,0,0,0,0,2,1,0.5,0.2,100,100,100,100);
/*!40000 ALTER TABLE `network_settings_investment` ENABLE KEYS */;

--
-- Table structure for table `network_settings_leadership`
--

DROP TABLE IF EXISTS `network_settings_leadership`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_leadership` (
  `chairman_leadership_share_1` double NOT NULL DEFAULT '0',
  `executive_leadership_share_1` double NOT NULL DEFAULT '0',
  `regular_leadership_share_1` double NOT NULL DEFAULT '0',
  `associate_leadership_share_1` double NOT NULL DEFAULT '0',
  `basic_leadership_share_1` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_2` double NOT NULL DEFAULT '0',
  `executive_leadership_share_2` double NOT NULL DEFAULT '0',
  `regular_leadership_share_2` double NOT NULL DEFAULT '0',
  `associate_leadership_share_2` double NOT NULL DEFAULT '0',
  `basic_leadership_share_2` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_3` double NOT NULL DEFAULT '0',
  `executive_leadership_share_3` double NOT NULL DEFAULT '0',
  `regular_leadership_share_3` double NOT NULL DEFAULT '0',
  `associate_leadership_share_3` double NOT NULL DEFAULT '0',
  `basic_leadership_share_3` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_4` double NOT NULL DEFAULT '0',
  `executive_leadership_share_4` double NOT NULL DEFAULT '0',
  `regular_leadership_share_4` double NOT NULL DEFAULT '0',
  `associate_leadership_share_4` double NOT NULL DEFAULT '0',
  `basic_leadership_share_4` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_5` double NOT NULL DEFAULT '0',
  `executive_leadership_share_5` double NOT NULL DEFAULT '0',
  `regular_leadership_share_5` double NOT NULL DEFAULT '0',
  `associate_leadership_share_5` double NOT NULL DEFAULT '0',
  `basic_leadership_share_5` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_6` double NOT NULL DEFAULT '0',
  `executive_leadership_share_6` double NOT NULL DEFAULT '0',
  `regular_leadership_share_6` double NOT NULL DEFAULT '0',
  `associate_leadership_share_6` double NOT NULL DEFAULT '0',
  `basic_leadership_share_6` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_7` double NOT NULL DEFAULT '0',
  `executive_leadership_share_7` double NOT NULL DEFAULT '0',
  `regular_leadership_share_7` double NOT NULL DEFAULT '0',
  `associate_leadership_share_7` double NOT NULL DEFAULT '0',
  `basic_leadership_share_7` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_8` double NOT NULL DEFAULT '0',
  `executive_leadership_share_8` double NOT NULL DEFAULT '0',
  `regular_leadership_share_8` double NOT NULL DEFAULT '0',
  `associate_leadership_share_8` double NOT NULL DEFAULT '0',
  `basic_leadership_share_8` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_9` double NOT NULL DEFAULT '0',
  `executive_leadership_share_9` double NOT NULL DEFAULT '0',
  `regular_leadership_share_9` double NOT NULL DEFAULT '0',
  `associate_leadership_share_9` double NOT NULL DEFAULT '0',
  `basic_leadership_share_9` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_10` double NOT NULL DEFAULT '0',
  `executive_leadership_share_10` double NOT NULL DEFAULT '0',
  `regular_leadership_share_10` double NOT NULL DEFAULT '0',
  `associate_leadership_share_10` double NOT NULL DEFAULT '0',
  `basic_leadership_share_10` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_11` double NOT NULL DEFAULT '0',
  `executive_leadership_share_11` double NOT NULL DEFAULT '0',
  `regular_leadership_share_11` double NOT NULL DEFAULT '0',
  `associate_leadership_share_11` double NOT NULL DEFAULT '0',
  `basic_leadership_share_11` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_12` double NOT NULL DEFAULT '0',
  `executive_leadership_share_12` double NOT NULL DEFAULT '0',
  `regular_leadership_share_12` double NOT NULL DEFAULT '0',
  `associate_leadership_share_12` double NOT NULL DEFAULT '0',
  `basic_leadership_share_12` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_13` double NOT NULL DEFAULT '0',
  `executive_leadership_share_13` double NOT NULL DEFAULT '0',
  `regular_leadership_share_13` double NOT NULL DEFAULT '0',
  `associate_leadership_share_13` double NOT NULL DEFAULT '0',
  `basic_leadership_share_13` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_14` double NOT NULL DEFAULT '0',
  `executive_leadership_share_14` double NOT NULL DEFAULT '0',
  `regular_leadership_share_14` double NOT NULL DEFAULT '0',
  `associate_leadership_share_14` double NOT NULL DEFAULT '0',
  `basic_leadership_share_14` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_15` double NOT NULL DEFAULT '0',
  `executive_leadership_share_15` double NOT NULL DEFAULT '0',
  `regular_leadership_share_15` double NOT NULL DEFAULT '0',
  `associate_leadership_share_15` double NOT NULL DEFAULT '0',
  `basic_leadership_share_15` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_16` double NOT NULL DEFAULT '0',
  `executive_leadership_share_16` double NOT NULL DEFAULT '0',
  `regular_leadership_share_16` double NOT NULL DEFAULT '0',
  `associate_leadership_share_16` double NOT NULL DEFAULT '0',
  `basic_leadership_share_16` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_17` double NOT NULL DEFAULT '0',
  `executive_leadership_share_17` double NOT NULL DEFAULT '0',
  `regular_leadership_share_17` double NOT NULL DEFAULT '0',
  `associate_leadership_share_17` double NOT NULL DEFAULT '0',
  `basic_leadership_share_17` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_18` double NOT NULL DEFAULT '0',
  `executive_leadership_share_18` double NOT NULL DEFAULT '0',
  `regular_leadership_share_18` double NOT NULL DEFAULT '0',
  `associate_leadership_share_18` double NOT NULL DEFAULT '0',
  `basic_leadership_share_18` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_19` double NOT NULL DEFAULT '0',
  `executive_leadership_share_19` double NOT NULL DEFAULT '0',
  `regular_leadership_share_19` double NOT NULL DEFAULT '0',
  `associate_leadership_share_19` double NOT NULL DEFAULT '0',
  `basic_leadership_share_19` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_20` double NOT NULL DEFAULT '0',
  `executive_leadership_share_20` double NOT NULL DEFAULT '0',
  `regular_leadership_share_20` double NOT NULL DEFAULT '0',
  `associate_leadership_share_20` double NOT NULL DEFAULT '0',
  `basic_leadership_share_20` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_1` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_1` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_1` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_1` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_1` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_2` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_2` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_2` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_2` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_2` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_3` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_3` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_3` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_3` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_3` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_4` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_4` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_4` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_4` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_4` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_5` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_5` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_5` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_5` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_5` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_6` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_6` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_6` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_6` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_6` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_7` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_7` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_7` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_7` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_7` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_8` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_8` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_8` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_8` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_8` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_9` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_9` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_9` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_9` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_9` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_10` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_10` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_10` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_10` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_10` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_11` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_11` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_11` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_11` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_11` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_12` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_12` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_12` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_12` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_12` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_13` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_13` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_13` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_13` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_13` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_14` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_14` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_14` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_14` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_14` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_15` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_15` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_15` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_15` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_15` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_16` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_16` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_16` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_16` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_16` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_17` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_17` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_17` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_17` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_17` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_18` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_18` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_18` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_18` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_18` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_19` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_19` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_19` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_19` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_19` double NOT NULL DEFAULT '0',
  `chairman_leadership_share_cut_20` double NOT NULL DEFAULT '0',
  `executive_leadership_share_cut_20` double NOT NULL DEFAULT '0',
  `regular_leadership_share_cut_20` double NOT NULL DEFAULT '0',
  `associate_leadership_share_cut_20` double NOT NULL DEFAULT '0',
  `basic_leadership_share_cut_20` double NOT NULL DEFAULT '0',
  `chairman_leadership_sponsored` int NOT NULL DEFAULT '0',
  `executive_leadership_sponsored` int NOT NULL DEFAULT '0',
  `regular_leadership_sponsored` int NOT NULL DEFAULT '0',
  `associate_leadership_sponsored` int NOT NULL DEFAULT '0',
  `basic_leadership_sponsored` int NOT NULL DEFAULT '0',
  `chairman_leadership_level` int NOT NULL DEFAULT '0',
  `executive_leadership_level` int NOT NULL DEFAULT '0',
  `regular_leadership_level` int NOT NULL DEFAULT '0',
  `associate_leadership_level` int NOT NULL DEFAULT '0',
  `basic_leadership_level` int NOT NULL DEFAULT '0',
  `chairman_leadership_max` double NOT NULL DEFAULT '0',
  `executive_leadership_max` double NOT NULL DEFAULT '0',
  `regular_leadership_max` double NOT NULL DEFAULT '0',
  `associate_leadership_max` double NOT NULL DEFAULT '0',
  `basic_leadership_max` double NOT NULL DEFAULT '0',
  `chairman_leadership_max_daily_income` double NOT NULL DEFAULT '0',
  `executive_leadership_max_daily_income` double NOT NULL DEFAULT '0',
  `regular_leadership_max_daily_income` double NOT NULL DEFAULT '0',
  `associate_leadership_max_daily_income` double NOT NULL DEFAULT '0',
  `basic_leadership_max_daily_income` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_leadership`
--

/*!40000 ALTER TABLE `network_settings_leadership` DISABLE KEYS */;
INSERT INTO `network_settings_leadership` VALUES (0,0,20,15,10,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,100,100,100,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,3,3,3,0,0,1,1,1,0,0,1500000,200000,100000,0,0,100,100,100);
/*!40000 ALTER TABLE `network_settings_leadership` ENABLE KEYS */;

--
-- Table structure for table `network_settings_leadership_passive`
--

DROP TABLE IF EXISTS `network_settings_leadership_passive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_leadership_passive` (
  `executive_leadership_passive_share_1` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_1` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_1` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_1` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_2` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_2` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_2` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_2` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_3` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_3` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_3` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_3` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_4` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_4` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_4` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_4` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_5` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_5` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_5` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_5` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_6` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_6` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_6` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_6` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_7` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_7` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_7` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_7` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_8` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_8` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_8` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_8` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_9` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_9` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_9` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_9` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_10` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_10` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_10` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_10` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_cut_1` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_cut_1` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_cut_1` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_cut_1` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_cut_2` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_cut_2` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_cut_2` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_cut_2` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_cut_3` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_cut_3` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_cut_3` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_cut_3` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_cut_4` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_cut_4` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_cut_4` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_cut_4` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_cut_5` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_cut_5` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_cut_5` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_cut_5` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_cut_6` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_cut_6` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_cut_6` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_cut_6` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_cut_7` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_cut_7` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_cut_7` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_cut_7` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_cut_8` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_cut_8` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_cut_8` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_cut_8` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_cut_9` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_cut_9` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_cut_9` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_cut_9` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_share_cut_10` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_share_cut_10` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_share_cut_10` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_share_cut_10` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_level` int NOT NULL DEFAULT '0',
  `regular_leadership_passive_level` int NOT NULL DEFAULT '0',
  `associate_leadership_passive_level` int NOT NULL DEFAULT '0',
  `basic_leadership_passive_level` int NOT NULL DEFAULT '0',
  `executive_leadership_passive_sponsored` int NOT NULL DEFAULT '0',
  `regular_leadership_passive_sponsored` int NOT NULL DEFAULT '0',
  `associate_leadership_passive_sponsored` int NOT NULL DEFAULT '0',
  `basic_leadership_passive_sponsored` int NOT NULL DEFAULT '0',
  `executive_leadership_passive_minimum_deposit` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_minimum_deposit` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_minimum_deposit` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_minimum_deposit` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_max_daily_income` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_max_daily_income` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_max_daily_income` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_max_daily_income` double NOT NULL DEFAULT '0',
  `executive_leadership_passive_maximum` double NOT NULL DEFAULT '0',
  `regular_leadership_passive_maximum` double NOT NULL DEFAULT '0',
  `associate_leadership_passive_maximum` double NOT NULL DEFAULT '0',
  `basic_leadership_passive_maximum` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_leadership_passive`
--

/*!40000 ALTER TABLE `network_settings_leadership_passive` DISABLE KEYS */;
INSERT INTO `network_settings_leadership_passive` VALUES (100,100,100,100,100,100,100,100,100,100,100,100,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,5,5,5,5,3,3,3,3,2,2,2,2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,3,3,3,3,0,0,0,0,1000,1000,1000,1000,10000,10000,10000,10000,10000000,1000000,100000,10000);
/*!40000 ALTER TABLE `network_settings_leadership_passive` ENABLE KEYS */;

--
-- Table structure for table `network_settings_matrix`
--

DROP TABLE IF EXISTS `network_settings_matrix`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_matrix` (
  `executive_matrix_share_1` double NOT NULL DEFAULT '0',
  `regular_matrix_share_1` double NOT NULL DEFAULT '0',
  `associate_matrix_share_1` double NOT NULL DEFAULT '0',
  `basic_matrix_share_1` double NOT NULL DEFAULT '0',
  `executive_matrix_share_2` double NOT NULL DEFAULT '0',
  `regular_matrix_share_2` double NOT NULL DEFAULT '0',
  `associate_matrix_share_2` double NOT NULL DEFAULT '0',
  `basic_matrix_share_2` double NOT NULL DEFAULT '0',
  `executive_matrix_share_3` double NOT NULL DEFAULT '0',
  `regular_matrix_share_3` double NOT NULL DEFAULT '0',
  `associate_matrix_share_3` double NOT NULL DEFAULT '0',
  `basic_matrix_share_3` double NOT NULL DEFAULT '0',
  `executive_matrix_share_4` double NOT NULL DEFAULT '0',
  `regular_matrix_share_4` double NOT NULL DEFAULT '0',
  `associate_matrix_share_4` double NOT NULL DEFAULT '0',
  `basic_matrix_share_4` double NOT NULL DEFAULT '0',
  `executive_matrix_share_5` double NOT NULL DEFAULT '0',
  `regular_matrix_share_5` double NOT NULL DEFAULT '0',
  `associate_matrix_share_5` double NOT NULL DEFAULT '0',
  `basic_matrix_share_5` double NOT NULL DEFAULT '0',
  `executive_matrix_share_6` double NOT NULL DEFAULT '0',
  `regular_matrix_share_6` double NOT NULL DEFAULT '0',
  `associate_matrix_share_6` double NOT NULL DEFAULT '0',
  `basic_matrix_share_6` double NOT NULL DEFAULT '0',
  `executive_matrix_share_7` double NOT NULL DEFAULT '0',
  `regular_matrix_share_7` double NOT NULL DEFAULT '0',
  `associate_matrix_share_7` double NOT NULL DEFAULT '0',
  `basic_matrix_share_7` double NOT NULL DEFAULT '0',
  `executive_matrix_share_8` double NOT NULL DEFAULT '0',
  `regular_matrix_share_8` double NOT NULL DEFAULT '0',
  `associate_matrix_share_8` double NOT NULL DEFAULT '0',
  `basic_matrix_share_8` double NOT NULL DEFAULT '0',
  `executive_matrix_share_9` double NOT NULL DEFAULT '0',
  `regular_matrix_share_9` double NOT NULL DEFAULT '0',
  `associate_matrix_share_9` double NOT NULL DEFAULT '0',
  `basic_matrix_share_9` double NOT NULL DEFAULT '0',
  `executive_matrix_share_10` double NOT NULL DEFAULT '0',
  `regular_matrix_share_10` double NOT NULL DEFAULT '0',
  `associate_matrix_share_10` double NOT NULL DEFAULT '0',
  `basic_matrix_share_10` double NOT NULL DEFAULT '0',
  `executive_matrix_share_cut_1` double NOT NULL DEFAULT '0',
  `regular_matrix_share_cut_1` double NOT NULL DEFAULT '0',
  `associate_matrix_share_cut_1` double NOT NULL DEFAULT '0',
  `basic_matrix_share_cut_1` double NOT NULL DEFAULT '0',
  `executive_matrix_share_cut_2` double NOT NULL DEFAULT '0',
  `regular_matrix_share_cut_2` double NOT NULL DEFAULT '0',
  `associate_matrix_share_cut_2` double NOT NULL DEFAULT '0',
  `basic_matrix_share_cut_2` double NOT NULL DEFAULT '0',
  `executive_matrix_share_cut_3` double NOT NULL DEFAULT '0',
  `regular_matrix_share_cut_3` double NOT NULL DEFAULT '0',
  `associate_matrix_share_cut_3` double NOT NULL DEFAULT '0',
  `basic_matrix_share_cut_3` double NOT NULL DEFAULT '0',
  `executive_matrix_share_cut_4` double NOT NULL DEFAULT '0',
  `regular_matrix_share_cut_4` double NOT NULL DEFAULT '0',
  `associate_matrix_share_cut_4` double NOT NULL DEFAULT '0',
  `basic_matrix_share_cut_4` double NOT NULL DEFAULT '0',
  `executive_matrix_share_cut_5` double NOT NULL DEFAULT '0',
  `regular_matrix_share_cut_5` double NOT NULL DEFAULT '0',
  `associate_matrix_share_cut_5` double NOT NULL DEFAULT '0',
  `basic_matrix_share_cut_5` double NOT NULL DEFAULT '0',
  `executive_matrix_share_cut_6` double NOT NULL DEFAULT '0',
  `regular_matrix_share_cut_6` double NOT NULL DEFAULT '0',
  `associate_matrix_share_cut_6` double NOT NULL DEFAULT '0',
  `basic_matrix_share_cut_6` double NOT NULL DEFAULT '0',
  `executive_matrix_share_cut_7` double NOT NULL DEFAULT '0',
  `regular_matrix_share_cut_7` double NOT NULL DEFAULT '0',
  `associate_matrix_share_cut_7` double NOT NULL DEFAULT '0',
  `basic_matrix_share_cut_7` double NOT NULL DEFAULT '0',
  `executive_matrix_share_cut_8` double NOT NULL DEFAULT '0',
  `regular_matrix_share_cut_8` double NOT NULL DEFAULT '0',
  `associate_matrix_share_cut_8` double NOT NULL DEFAULT '0',
  `basic_matrix_share_cut_8` double NOT NULL DEFAULT '0',
  `executive_matrix_share_cut_9` double NOT NULL DEFAULT '0',
  `regular_matrix_share_cut_9` double NOT NULL DEFAULT '0',
  `associate_matrix_share_cut_9` double NOT NULL DEFAULT '0',
  `basic_matrix_share_cut_9` double NOT NULL DEFAULT '0',
  `executive_matrix_share_cut_10` double NOT NULL DEFAULT '0',
  `regular_matrix_share_cut_10` double NOT NULL DEFAULT '0',
  `associate_matrix_share_cut_10` double NOT NULL DEFAULT '0',
  `basic_matrix_share_cut_10` double NOT NULL DEFAULT '0',
  `executive_matrix_level` int NOT NULL DEFAULT '0',
  `regular_matrix_level` int NOT NULL DEFAULT '0',
  `associate_matrix_level` int NOT NULL DEFAULT '0',
  `basic_matrix_level` int NOT NULL DEFAULT '0',
  `executive_matrix_width` int NOT NULL DEFAULT '0',
  `regular_matrix_width` int NOT NULL DEFAULT '0',
  `associate_matrix_width` int NOT NULL DEFAULT '0',
  `basic_matrix_width` int NOT NULL DEFAULT '0',
  `executive_entry` double NOT NULL DEFAULT '0',
  `regular_entry` double NOT NULL DEFAULT '0',
  `associate_entry` double NOT NULL DEFAULT '0',
  `basic_entry` double NOT NULL DEFAULT '0',
  `executive_reentry` double NOT NULL DEFAULT '0',
  `regular_reentry` double NOT NULL DEFAULT '0',
  `associate_reentry` double NOT NULL DEFAULT '0',
  `basic_reentry` double NOT NULL DEFAULT '0',
  `executive_upgrade` double NOT NULL DEFAULT '0',
  `regular_upgrade` double NOT NULL DEFAULT '0',
  `associate_upgrade` double NOT NULL DEFAULT '0',
  `basic_upgrade` double NOT NULL DEFAULT '0',
  `executive_sponsored` int NOT NULL DEFAULT '0',
  `regular_sponsored` int NOT NULL DEFAULT '0',
  `associate_sponsored` int NOT NULL DEFAULT '0',
  `basic_sponsored` int NOT NULL DEFAULT '0',
  `executive_status` tinyint(1) NOT NULL DEFAULT '0',
  `regular_status` tinyint(1) NOT NULL DEFAULT '0',
  `associate_status` tinyint(1) NOT NULL DEFAULT '0',
  `basic_status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_matrix`
--

/*!40000 ALTER TABLE `network_settings_matrix` DISABLE KEYS */;
INSERT INTO `network_settings_matrix` VALUES (0,0,100,100,0,0,100,100,0,0,100,100,0,0,100,100,0,0,100,100,0,0,100,100,0,0,100,0,0,0,100,0,0,0,100,0,0,0,100,0,0,0,22.23704,33.40013,0,0,14.82469,33.40013,0,0,13.509,18.55562,0,0,10.42217,12.37014,0,0,6.95635,8.24694,0,0,5.4036,5.4036,0,0,3.6024,0,0,0,2.95018,0,0,0,4.23659,0,0,0,2.82439,0,0,0,10,5,2,2,3,3,2700,1200,2998,998,2400,1000,0,0,120000,50000,0,0,2,2,3,3,0,0,1,1);
/*!40000 ALTER TABLE `network_settings_matrix` ENABLE KEYS */;

--
-- Table structure for table `network_settings_merchant`
--

DROP TABLE IF EXISTS `network_settings_merchant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_merchant` (
  `executive_merchant_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'executive',
  `regular_merchant_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'regular',
  `associate_merchant_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'associate',
  `basic_merchant_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'basic',
  `executive_merchant_entry` double NOT NULL DEFAULT '0',
  `regular_merchant_entry` double NOT NULL DEFAULT '0',
  `associate_merchant_entry` double NOT NULL DEFAULT '0',
  `basic_merchant_entry` double NOT NULL DEFAULT '0',
  `executive_merchant_cut` double NOT NULL DEFAULT '0',
  `regular_merchant_cut` double NOT NULL DEFAULT '0',
  `associate_merchant_cut` double NOT NULL DEFAULT '0',
  `basic_merchant_cut` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_merchant`
--

/*!40000 ALTER TABLE `network_settings_merchant` DISABLE KEYS */;
INSERT INTO `network_settings_merchant` VALUES ('Ultra','Mega','Regular','Mini',0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `network_settings_merchant` ENABLE KEYS */;

--
-- Table structure for table `network_settings_passup`
--

DROP TABLE IF EXISTS `network_settings_passup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_passup` (
  `executive_passup_bonus` double NOT NULL DEFAULT '0',
  `regular_passup_bonus` double NOT NULL DEFAULT '0',
  `associate_passup_bonus` double NOT NULL DEFAULT '0',
  `basic_passup_bonus` double NOT NULL DEFAULT '0',
  `executive_passup_width` int NOT NULL DEFAULT '0',
  `regular_passup_width` int NOT NULL DEFAULT '0',
  `associate_passup_width` int NOT NULL DEFAULT '0',
  `basic_passup_width` int NOT NULL DEFAULT '0',
  `executive_passup_interval` int NOT NULL DEFAULT '0',
  `regular_passup_interval` int NOT NULL DEFAULT '0',
  `associate_passup_interval` int NOT NULL DEFAULT '0',
  `basic_passup_interval` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_passup`
--

/*!40000 ALTER TABLE `network_settings_passup` DISABLE KEYS */;
INSERT INTO `network_settings_passup` VALUES (40,30,20,10,10,10,10,10,2,2,2,2);
/*!40000 ALTER TABLE `network_settings_passup` ENABLE KEYS */;

--
-- Table structure for table `network_settings_plans`
--

DROP TABLE IF EXISTS `network_settings_plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_plans` (
  `account_freeze` tinyint NOT NULL DEFAULT '0',
  `direct_referral` tinyint NOT NULL DEFAULT '0',
  `indirect_referral` tinyint NOT NULL DEFAULT '0',
  `unilevel` tinyint NOT NULL DEFAULT '0',
  `binary_pair` tinyint NOT NULL DEFAULT '0',
  `leadership_binary` tinyint NOT NULL DEFAULT '0',
  `leadership_passive` tinyint NOT NULL DEFAULT '0',
  `redundant_binary` tinyint NOT NULL DEFAULT '0',
  `matrix` tinyint NOT NULL DEFAULT '0',
  `power` tinyint NOT NULL DEFAULT '0',
  `royalty` tinyint NOT NULL DEFAULT '0',
  `echelon` tinyint NOT NULL DEFAULT '0',
  `etrade` tinyint NOT NULL DEFAULT '0',
  `top_up` tinyint NOT NULL DEFAULT '0',
  `fast_track` tinyint NOT NULL DEFAULT '0',
  `fixed_daily` tinyint NOT NULL DEFAULT '0',
  `trading` tinyint NOT NULL DEFAULT '0',
  `merchant` tinyint NOT NULL DEFAULT '0',
  `table_matrix` tinyint NOT NULL DEFAULT '0',
  `upline_support` tinyint NOT NULL DEFAULT '0',
  `passup` tinyint NOT NULL DEFAULT '0',
  `elite_reward` tinyint NOT NULL DEFAULT '0',
  `stockist` tinyint NOT NULL DEFAULT '0',
  `franchise` tinyint NOT NULL DEFAULT '0',
  `harvest` tinyint NOT NULL DEFAULT '0',
  `p2p_trading` tinyint NOT NULL DEFAULT '0',
  `p2p_commerce` tinyint NOT NULL DEFAULT '0',
  `account_freeze_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Account Freeze',
  `direct_referral_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Direct Referral',
  `indirect_referral_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Indirect_Referral',
  `unilevel_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unilevel',
  `binary_pair_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Binary',
  `leadership_binary_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Leadership Binary',
  `leadership_passive_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Leadership Passive',
  `redundant_binary_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Redundant Binary',
  `matrix_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Matrix',
  `power_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Power',
  `royalty_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Royalty',
  `echelon_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Echelon',
  `etrade_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Etrade',
  `top_up_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Top Up',
  `fast_track_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Fast Track',
  `fixed_daily_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Fixed Daily',
  `trading_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Trading',
  `table_matrix_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Table Matrix',
  `merchant_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Merchant',
  `upline_support_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Upline Support',
  `passup_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Passup',
  `elite_reward_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Elite Reward',
  `stockist_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Stockist',
  `franchise_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'Franchise',
  `harvest_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Harvest',
  `p2p_trading_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'P2P Trading',
  `p2p_commerce_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'P2P Commerce'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_plans`
--

/*!40000 ALTER TABLE `network_settings_plans` DISABLE KEYS */;
INSERT INTO `network_settings_plans` VALUES (1,1,1,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'Account Freeze','Direct Referral','Indirect Referral','Unilevel','Binary','Leadership Binary','Leadership Passive','Redundant Binary','','','Royalty ala Edgar','Royalty PESO','Etrade','Top Up','Fast Track','Fixed Daily','Trading','','Merchant','Upline Support','Passup','Elite Reward','Stockist','Franchise','Harvest','P2P Trading','P2P Commerce');
/*!40000 ALTER TABLE `network_settings_plans` ENABLE KEYS */;

--
-- Table structure for table `network_settings_power`
--

DROP TABLE IF EXISTS `network_settings_power`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_power` (
  `executive_power_share_1` double NOT NULL DEFAULT '0',
  `regular_power_share_1` double NOT NULL DEFAULT '0',
  `associate_power_share_1` double NOT NULL DEFAULT '0',
  `basic_power_share_1` double NOT NULL DEFAULT '0',
  `executive_power_share_2` double NOT NULL DEFAULT '0',
  `regular_power_share_2` double NOT NULL DEFAULT '0',
  `associate_power_share_2` double NOT NULL DEFAULT '0',
  `basic_power_share_2` double NOT NULL DEFAULT '0',
  `executive_power_share_3` double NOT NULL DEFAULT '0',
  `regular_power_share_3` double NOT NULL DEFAULT '0',
  `associate_power_share_3` double NOT NULL DEFAULT '0',
  `basic_power_share_3` double NOT NULL DEFAULT '0',
  `executive_power_share_4` double NOT NULL DEFAULT '0',
  `regular_power_share_4` double NOT NULL DEFAULT '0',
  `associate_power_share_4` double NOT NULL DEFAULT '0',
  `basic_power_share_4` double NOT NULL DEFAULT '0',
  `executive_power_share_5` double NOT NULL DEFAULT '0',
  `regular_power_share_5` double NOT NULL DEFAULT '0',
  `associate_power_share_5` double NOT NULL DEFAULT '0',
  `basic_power_share_5` double NOT NULL DEFAULT '0',
  `executive_power_share_6` double NOT NULL DEFAULT '0',
  `regular_power_share_6` double NOT NULL DEFAULT '0',
  `associate_power_share_6` double NOT NULL DEFAULT '0',
  `basic_power_share_6` double NOT NULL DEFAULT '0',
  `executive_power_share_7` double NOT NULL DEFAULT '0',
  `regular_power_share_7` double NOT NULL DEFAULT '0',
  `associate_power_share_7` double NOT NULL DEFAULT '0',
  `basic_power_share_7` double NOT NULL DEFAULT '0',
  `executive_power_share_8` double NOT NULL DEFAULT '0',
  `regular_power_share_8` double NOT NULL DEFAULT '0',
  `associate_power_share_8` double NOT NULL DEFAULT '0',
  `basic_power_share_8` double NOT NULL DEFAULT '0',
  `executive_power_share_9` double NOT NULL DEFAULT '0',
  `regular_power_share_9` double NOT NULL DEFAULT '0',
  `associate_power_share_9` double NOT NULL DEFAULT '0',
  `basic_power_share_9` double NOT NULL DEFAULT '0',
  `executive_power_share_10` double NOT NULL DEFAULT '0',
  `regular_power_share_10` double NOT NULL DEFAULT '0',
  `associate_power_share_10` double NOT NULL DEFAULT '0',
  `basic_power_share_10` double NOT NULL DEFAULT '0',
  `executive_power_share_cut_1` double NOT NULL DEFAULT '0',
  `regular_power_share_cut_1` double NOT NULL DEFAULT '0',
  `associate_power_share_cut_1` double NOT NULL DEFAULT '0',
  `basic_power_share_cut_1` double NOT NULL DEFAULT '0',
  `executive_power_share_cut_2` double NOT NULL DEFAULT '0',
  `regular_power_share_cut_2` double NOT NULL DEFAULT '0',
  `associate_power_share_cut_2` double NOT NULL DEFAULT '0',
  `basic_power_share_cut_2` double NOT NULL DEFAULT '0',
  `executive_power_share_cut_3` double NOT NULL DEFAULT '0',
  `regular_power_share_cut_3` double NOT NULL DEFAULT '0',
  `associate_power_share_cut_3` double NOT NULL DEFAULT '0',
  `basic_power_share_cut_3` double NOT NULL DEFAULT '0',
  `executive_power_share_cut_4` double NOT NULL DEFAULT '0',
  `regular_power_share_cut_4` double NOT NULL DEFAULT '0',
  `associate_power_share_cut_4` double NOT NULL DEFAULT '0',
  `basic_power_share_cut_4` double NOT NULL DEFAULT '0',
  `executive_power_share_cut_5` double NOT NULL DEFAULT '0',
  `regular_power_share_cut_5` double NOT NULL DEFAULT '0',
  `associate_power_share_cut_5` double NOT NULL DEFAULT '0',
  `basic_power_share_cut_5` double NOT NULL DEFAULT '0',
  `executive_power_share_cut_6` double NOT NULL DEFAULT '0',
  `regular_power_share_cut_6` double NOT NULL DEFAULT '0',
  `associate_power_share_cut_6` double NOT NULL DEFAULT '0',
  `basic_power_share_cut_6` double NOT NULL DEFAULT '0',
  `executive_power_share_cut_7` double NOT NULL DEFAULT '0',
  `regular_power_share_cut_7` double NOT NULL DEFAULT '0',
  `associate_power_share_cut_7` double NOT NULL DEFAULT '0',
  `basic_power_share_cut_7` double NOT NULL DEFAULT '0',
  `executive_power_share_cut_8` double NOT NULL DEFAULT '0',
  `regular_power_share_cut_8` double NOT NULL DEFAULT '0',
  `associate_power_share_cut_8` double NOT NULL DEFAULT '0',
  `basic_power_share_cut_8` double NOT NULL DEFAULT '0',
  `executive_power_share_cut_9` double NOT NULL DEFAULT '0',
  `regular_power_share_cut_9` double NOT NULL DEFAULT '0',
  `associate_power_share_cut_9` double NOT NULL DEFAULT '0',
  `basic_power_share_cut_9` double NOT NULL DEFAULT '0',
  `executive_power_share_cut_10` double NOT NULL DEFAULT '0',
  `regular_power_share_cut_10` double NOT NULL DEFAULT '0',
  `associate_power_share_cut_10` double NOT NULL DEFAULT '0',
  `basic_power_share_cut_10` double NOT NULL DEFAULT '0',
  `executive_power_level` int NOT NULL DEFAULT '0',
  `regular_power_level` int NOT NULL DEFAULT '0',
  `associate_power_level` int NOT NULL DEFAULT '0',
  `basic_power_level` int NOT NULL DEFAULT '0',
  `executive_power_width` int NOT NULL DEFAULT '0',
  `regular_power_width` int NOT NULL DEFAULT '0',
  `associate_power_width` int NOT NULL DEFAULT '0',
  `basic_power_width` int NOT NULL DEFAULT '0',
  `executive_entry` double NOT NULL DEFAULT '0',
  `regular_entry` double NOT NULL DEFAULT '0',
  `associate_entry` double NOT NULL DEFAULT '0',
  `basic_entry` double NOT NULL DEFAULT '0',
  `executive_reentry` double NOT NULL DEFAULT '0',
  `regular_reentry` double NOT NULL DEFAULT '0',
  `associate_reentry` double NOT NULL DEFAULT '0',
  `basic_reentry` double NOT NULL DEFAULT '0',
  `executive_upgrade` double NOT NULL DEFAULT '0',
  `regular_upgrade` double NOT NULL DEFAULT '0',
  `associate_upgrade` double NOT NULL DEFAULT '0',
  `basic_upgrade` double NOT NULL DEFAULT '0',
  `executive_sponsored` int NOT NULL DEFAULT '0',
  `regular_sponsored` int NOT NULL DEFAULT '0',
  `associate_sponsored` int NOT NULL DEFAULT '0',
  `basic_sponsored` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_power`
--

/*!40000 ALTER TABLE `network_settings_power` DISABLE KEYS */;
INSERT INTO `network_settings_power` VALUES (5,5,5,5,5,5,5,5,5,5,5,5,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,20,20,20,20,20,20,20,20,20,20,20,20,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,3,3,3,3,2,2,2,2,2000,200,30,20,1500,150,20,10,1600,160,50,0,2,2,2,2);
/*!40000 ALTER TABLE `network_settings_power` ENABLE KEYS */;

--
-- Table structure for table `network_settings_product_category`
--

DROP TABLE IF EXISTS `network_settings_product_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_product_category` (
  `cat_id` int NOT NULL AUTO_INCREMENT,
  `category` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_product_category`
--

/*!40000 ALTER TABLE `network_settings_product_category` DISABLE KEYS */;
INSERT INTO `network_settings_product_category` VALUES (1,'Agricultural Products'),(2,'Farm Products'),(3,'Processed Foods'),(4,'Food Supplement'),(5,'Beverage'),(6,'Apparel'),(7,'Gadget'),(8,'Telco Services'),(9,'Home Supplies'),(10,'Office Supplies'),(11,'Hardware Tools'),(12,'Automotive'),(13,'Industrial Machines'),(14,'Real Estate'),(15,'Commodities'),(16,'Literature'),(17,'Software'),(18,'Beauty'),(19,'Perfume'),(20,'Hygiene');
/*!40000 ALTER TABLE `network_settings_product_category` ENABLE KEYS */;

--
-- Table structure for table `network_settings_referral`
--

DROP TABLE IF EXISTS `network_settings_referral`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_referral` (
  `chairman_referral` double NOT NULL DEFAULT '0',
  `executive_referral` double NOT NULL DEFAULT '0',
  `regular_referral` double NOT NULL DEFAULT '0',
  `associate_referral` double NOT NULL DEFAULT '0',
  `basic_referral` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_referral`
--

/*!40000 ALTER TABLE `network_settings_referral` DISABLE KEYS */;
INSERT INTO `network_settings_referral` VALUES (0,120,60,30,10);
/*!40000 ALTER TABLE `network_settings_referral` ENABLE KEYS */;

--
-- Table structure for table `network_settings_royalty`
--

DROP TABLE IF EXISTS `network_settings_royalty`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_royalty` (
  `supervisor_members` int NOT NULL DEFAULT '0',
  `supervisor_member_directs` int NOT NULL DEFAULT '0',
  `supervisor_sales` double NOT NULL DEFAULT '0',
  `manager_supervisors` int NOT NULL DEFAULT '0',
  `manager_sales` double NOT NULL DEFAULT '0',
  `director_managers` int NOT NULL DEFAULT '0',
  `director_sales` double NOT NULL DEFAULT '0',
  `supervisor_repeat_purchase_reward` double NOT NULL DEFAULT '0',
  `supervisor_basic_reward` double NOT NULL DEFAULT '0',
  `supervisor_associate_reward` double NOT NULL DEFAULT '0',
  `supervisor_regular_reward` double NOT NULL DEFAULT '0',
  `manager_repeat_purchase_reward` double NOT NULL DEFAULT '0',
  `manager_basic_reward` double NOT NULL DEFAULT '0',
  `manager_associate_reward` double NOT NULL DEFAULT '0',
  `manager_regular_reward` double NOT NULL DEFAULT '0',
  `director_repeat_purchase_reward` double NOT NULL DEFAULT '0',
  `director_basic_reward` double NOT NULL DEFAULT '0',
  `director_associate_reward` double NOT NULL DEFAULT '0',
  `director_regular_reward` double NOT NULL DEFAULT '0',
  `director_rank_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Director',
  `manager_rank_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Manager',
  `supervisor_rank_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Supervisor',
  `affiliate_rank_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Affiliate'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_royalty`
--

/*!40000 ALTER TABLE `network_settings_royalty` DISABLE KEYS */;
INSERT INTO `network_settings_royalty` VALUES (20,3,100000,10,200000,5,500000,3,20,100,500,5,30,200,1000,10,50,350,2000,'Director','Manager','Supervisor','Agent');
/*!40000 ALTER TABLE `network_settings_royalty` ENABLE KEYS */;

--
-- Table structure for table `network_settings_trading`
--

DROP TABLE IF EXISTS `network_settings_trading`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_trading` (
  `chairman_fmc` double NOT NULL DEFAULT '0',
  `executive_fmc` double NOT NULL DEFAULT '0',
  `regular_fmc` double NOT NULL DEFAULT '0',
  `associate_fmc` double NOT NULL DEFAULT '0',
  `basic_fmc` double NOT NULL DEFAULT '0',
  `starter_fmc` double NOT NULL DEFAULT '0',
  `fmc_to_usd` double NOT NULL DEFAULT '0',
  `fmc_to_btc3` double NOT NULL DEFAULT '0',
  `token_name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'token',
  `donation_name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'donation',
  `vlt_min_stock` double NOT NULL DEFAULT '0',
  `vlt_buy_charge` double NOT NULL DEFAULT '0',
  `vlt_sell_charge` double NOT NULL DEFAULT '0',
  `trade_buy_charge` double NOT NULL DEFAULT '0',
  `trade_sell_charge` double NOT NULL DEFAULT '0',
  `chairman_minimum_bal_fmc` double NOT NULL DEFAULT '0',
  `executive_minimum_bal_fmc` double NOT NULL DEFAULT '0',
  `regular_minimum_bal_fmc` double NOT NULL DEFAULT '0',
  `associate_minimum_bal_fmc` double NOT NULL DEFAULT '0',
  `basic_minimum_bal_fmc` double NOT NULL DEFAULT '0',
  `starter_minimum_bal_fmc` double NOT NULL DEFAULT '0',
  `chairman_minimum_sell` double NOT NULL DEFAULT '0',
  `executive_minimum_sell` double NOT NULL DEFAULT '0',
  `regular_minimum_sell` double NOT NULL DEFAULT '0',
  `associate_minimum_sell` double NOT NULL DEFAULT '0',
  `basic_minimum_sell` double NOT NULL DEFAULT '0',
  `starter_minimum_sell` double NOT NULL DEFAULT '0',
  `chairman_maximum_buy` double NOT NULL DEFAULT '0',
  `executive_maximum_buy` double NOT NULL DEFAULT '0',
  `regular_maximum_buy` double NOT NULL DEFAULT '0',
  `associate_maximum_buy` double NOT NULL DEFAULT '0',
  `basic_maximum_buy` double NOT NULL DEFAULT '0',
  `starter_maximum_buy` double NOT NULL DEFAULT '0',
  `chairman_minimum_buy` double NOT NULL DEFAULT '0',
  `executive_minimum_buy` double NOT NULL DEFAULT '0',
  `regular_minimum_buy` double NOT NULL DEFAULT '0',
  `associate_minimum_buy` double NOT NULL DEFAULT '0',
  `basic_minimum_buy` double NOT NULL DEFAULT '0',
  `starter_minimum_buy` double NOT NULL DEFAULT '0',
  `merchant_share` double NOT NULL DEFAULT '0',
  `chairman_minimum_transfer` double NOT NULL DEFAULT '0',
  `executive_minimum_transfer` double NOT NULL DEFAULT '0',
  `regular_minimum_transfer` double NOT NULL DEFAULT '0',
  `associate_minimum_transfer` double NOT NULL DEFAULT '0',
  `basic_minimum_transfer` double NOT NULL DEFAULT '0',
  `starter_minimum_transfer` double NOT NULL DEFAULT '0',
  `chairman_transfer_fee` double NOT NULL DEFAULT '0',
  `executive_transfer_fee` double NOT NULL DEFAULT '0',
  `regular_transfer_fee` double NOT NULL DEFAULT '0',
  `associate_transfer_fee` double NOT NULL DEFAULT '0',
  `basic_transfer_fee` double NOT NULL DEFAULT '0',
  `starter_transfer_fee` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_trading`
--

/*!40000 ALTER TABLE `network_settings_trading` DISABLE KEYS */;
INSERT INTO `network_settings_trading` VALUES (100000,10000,1000,100,10,0,0.00000008,4,'AET','donation',10000000,3,3,3,3,1,1,1,1,1,0,10,10,10,10,10,10,10000,10000,10000,10000,10000,10000,10,10,10,10,10,10,10,0.1,0.1,1,1,1,1,0,0,0,0,0,0);
/*!40000 ALTER TABLE `network_settings_trading` ENABLE KEYS */;

--
-- Table structure for table `network_settings_unilevel`
--

DROP TABLE IF EXISTS `network_settings_unilevel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_unilevel` (
  `executive_unilevel_share_1` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_1` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_1` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_1` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_2` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_2` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_2` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_2` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_3` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_3` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_3` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_3` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_4` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_4` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_4` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_4` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_5` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_5` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_5` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_5` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_6` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_6` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_6` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_6` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_7` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_7` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_7` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_7` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_8` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_8` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_8` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_8` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_9` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_9` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_9` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_9` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_10` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_10` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_10` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_10` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_11` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_11` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_11` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_11` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_12` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_12` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_12` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_12` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_13` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_13` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_13` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_13` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_14` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_14` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_14` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_14` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_15` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_15` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_15` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_15` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_16` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_16` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_16` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_16` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_17` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_17` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_17` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_17` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_18` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_18` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_18` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_18` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_19` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_19` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_19` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_19` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_20` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_20` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_20` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_20` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_cut_1` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_cut_1` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_cut_1` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_cut_1` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_cut_2` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_cut_2` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_cut_2` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_cut_2` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_cut_3` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_cut_3` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_cut_3` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_cut_3` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_cut_4` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_cut_4` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_cut_4` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_cut_4` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_cut_5` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_cut_5` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_cut_5` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_cut_5` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_cut_6` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_cut_6` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_cut_6` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_cut_6` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_cut_7` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_cut_7` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_cut_7` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_cut_7` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_cut_8` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_cut_8` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_cut_8` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_cut_8` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_cut_9` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_cut_9` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_cut_9` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_cut_9` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_cut_10` double NOT NULL DEFAULT '0',
  `regular_unilevel_share_cut_10` double NOT NULL DEFAULT '0',
  `associate_unilevel_share_cut_10` double NOT NULL DEFAULT '0',
  `basic_unilevel_share_cut_10` double NOT NULL DEFAULT '0',
  `executive_unilevel_share_cut_11` double DEFAULT '0',
  `regular_unilevel_share_cut_11` double DEFAULT '0',
  `associate_unilevel_share_cut_11` double DEFAULT '0',
  `basic_unilevel_share_cut_11` double DEFAULT '0',
  `executive_unilevel_share_cut_12` double DEFAULT '0',
  `regular_unilevel_share_cut_12` double DEFAULT '0',
  `associate_unilevel_share_cut_12` double DEFAULT '0',
  `basic_unilevel_share_cut_12` double DEFAULT '0',
  `executive_unilevel_share_cut_13` double DEFAULT '0',
  `regular_unilevel_share_cut_13` double DEFAULT '0',
  `associate_unilevel_share_cut_13` double DEFAULT '0',
  `basic_unilevel_share_cut_13` double DEFAULT '0',
  `executive_unilevel_share_cut_14` double DEFAULT '0',
  `regular_unilevel_share_cut_14` double DEFAULT '0',
  `associate_unilevel_share_cut_14` double DEFAULT '0',
  `basic_unilevel_share_cut_14` double DEFAULT '0',
  `executive_unilevel_share_cut_15` double DEFAULT '0',
  `regular_unilevel_share_cut_15` double DEFAULT '0',
  `associate_unilevel_share_cut_15` double DEFAULT '0',
  `basic_unilevel_share_cut_15` double DEFAULT '0',
  `executive_unilevel_share_cut_16` double DEFAULT '0',
  `regular_unilevel_share_cut_16` double DEFAULT '0',
  `associate_unilevel_share_cut_16` double DEFAULT '0',
  `basic_unilevel_share_cut_16` double DEFAULT '0',
  `executive_unilevel_share_cut_17` double DEFAULT '0',
  `regular_unilevel_share_cut_17` double DEFAULT '0',
  `associate_unilevel_share_cut_17` double DEFAULT '0',
  `basic_unilevel_share_cut_17` double DEFAULT '0',
  `executive_unilevel_share_cut_18` double DEFAULT '0',
  `regular_unilevel_share_cut_18` double DEFAULT '0',
  `associate_unilevel_share_cut_18` double DEFAULT '0',
  `basic_unilevel_share_cut_18` double DEFAULT '0',
  `executive_unilevel_share_cut_19` double DEFAULT '0',
  `regular_unilevel_share_cut_19` double DEFAULT '0',
  `associate_unilevel_share_cut_19` double DEFAULT '0',
  `basic_unilevel_share_cut_19` double DEFAULT '0',
  `executive_unilevel_share_cut_20` double DEFAULT '0',
  `regular_unilevel_share_cut_20` double DEFAULT '0',
  `associate_unilevel_share_cut_20` double DEFAULT '0',
  `basic_unilevel_share_cut_20` double DEFAULT '0',
  `executive_unilevel_level` int NOT NULL DEFAULT '0',
  `regular_unilevel_level` int NOT NULL DEFAULT '0',
  `associate_unilevel_level` int NOT NULL DEFAULT '0',
  `basic_unilevel_level` int NOT NULL DEFAULT '0',
  `executive_unilevel_maintenance` double NOT NULL DEFAULT '0',
  `regular_unilevel_maintenance` double NOT NULL DEFAULT '0',
  `associate_unilevel_maintenance` double NOT NULL DEFAULT '0',
  `basic_unilevel_maintenance` double NOT NULL DEFAULT '0',
  `executive_unilevel_period` tinyint DEFAULT '4',
  `regular_unilevel_period` tinyint DEFAULT '4',
  `associate_unilevel_period` tinyint DEFAULT '4',
  `basic_unilevel_period` tinyint DEFAULT '4',
  `executive_unilevel_max_daily_income` double NOT NULL DEFAULT '0',
  `regular_unilevel_max_daily_income` double NOT NULL DEFAULT '0',
  `associate_unilevel_max_daily_income` double NOT NULL DEFAULT '0',
  `basic_unilevel_max_daily_income` double NOT NULL DEFAULT '0',
  `executive_unilevel_maximum` double NOT NULL DEFAULT '0',
  `regular_unilevel_maximum` double NOT NULL DEFAULT '0',
  `associate_unilevel_maximum` double NOT NULL DEFAULT '0',
  `basic_unilevel_maximum` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_1` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_2` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_3` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_4` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_5` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_6` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_7` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_8` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_9` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_10` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_11` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_12` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_13` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_14` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_15` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_16` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_17` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_18` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_19` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_20` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_1` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_2` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_3` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_4` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_5` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_6` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_7` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_8` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_9` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_10` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_11` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_12` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_13` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_14` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_15` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_16` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_17` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_18` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_19` double NOT NULL DEFAULT '0',
  `chairman_unilevel_share_cut_20` double NOT NULL DEFAULT '0',
  `chairman_unilevel_level` double NOT NULL DEFAULT '0',
  `chairman_unilevel_maintenance` double NOT NULL DEFAULT '0',
  `chairman_unilevel_period` double NOT NULL DEFAULT '0',
  `chairman_unilevel_max_daily_income` double NOT NULL DEFAULT '0',
  `chairman_unilevel_maximum` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_unilevel`
--

/*!40000 ALTER TABLE `network_settings_unilevel` DISABLE KEYS */;
INSERT INTO `network_settings_unilevel` VALUES (10,100,100,100,10,100,100,100,10,100,100,100,10,100,100,100,10,100,100,100,5,100,100,100,5,100,100,100,5,100,100,100,5,100,100,100,5,100,100,100,5,0,0,0,5,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,10,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,10,10,10,10,0,0,0,0,4,4,4,4,10000000000,1000000,500000,50000,10000000000,1000000,500000,50000,10,10,10,10,10,5,5,5,5,5,5,5,5,5,5,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,15,0,0,0,0);
/*!40000 ALTER TABLE `network_settings_unilevel` ENABLE KEYS */;

--
-- Table structure for table `network_settings_upline_support`
--

DROP TABLE IF EXISTS `network_settings_upline_support`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_settings_upline_support` (
  `executive_upline_support_share_1` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_1` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_1` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_1` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_2` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_2` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_2` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_2` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_3` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_3` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_3` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_3` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_4` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_4` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_4` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_4` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_5` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_5` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_5` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_5` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_6` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_6` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_6` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_6` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_7` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_7` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_7` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_7` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_8` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_8` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_8` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_8` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_9` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_9` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_9` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_9` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_10` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_10` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_10` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_10` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_cut_1` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_cut_1` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_cut_1` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_cut_1` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_cut_2` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_cut_2` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_cut_2` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_cut_2` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_cut_3` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_cut_3` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_cut_3` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_cut_3` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_cut_4` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_cut_4` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_cut_4` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_cut_4` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_cut_5` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_cut_5` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_cut_5` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_cut_5` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_cut_6` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_cut_6` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_cut_6` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_cut_6` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_cut_7` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_cut_7` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_cut_7` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_cut_7` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_cut_8` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_cut_8` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_cut_8` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_cut_8` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_cut_9` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_cut_9` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_cut_9` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_cut_9` double NOT NULL DEFAULT '0',
  `executive_upline_support_share_cut_10` double NOT NULL DEFAULT '0',
  `regular_upline_support_share_cut_10` double NOT NULL DEFAULT '0',
  `associate_upline_support_share_cut_10` double NOT NULL DEFAULT '0',
  `basic_upline_support_share_cut_10` double NOT NULL DEFAULT '0',
  `executive_upline_support_level` int NOT NULL DEFAULT '0',
  `regular_upline_support_level` int NOT NULL DEFAULT '0',
  `associate_upline_support_level` int NOT NULL DEFAULT '0',
  `basic_upline_support_level` int NOT NULL DEFAULT '0',
  `executive_upline_support_points` double NOT NULL DEFAULT '0',
  `regular_upline_support_points` double NOT NULL DEFAULT '0',
  `associate_upline_support_points` double NOT NULL DEFAULT '0',
  `basic_upline_support_points` double NOT NULL DEFAULT '0',
  `executive_upline_support_fmc` double NOT NULL DEFAULT '0',
  `regular_upline_support_fmc` double NOT NULL DEFAULT '0',
  `associate_upline_support_fmc` double NOT NULL DEFAULT '0',
  `basic_upline_support_fmc` double NOT NULL DEFAULT '0',
  `executive_upline_support_sponsored` int NOT NULL DEFAULT '0',
  `regular_upline_support_sponsored` int NOT NULL DEFAULT '0',
  `associate_upline_support_sponsored` int NOT NULL DEFAULT '0',
  `basic_upline_support_sponsored` int NOT NULL DEFAULT '0',
  `executive_upline_support_maximum` double NOT NULL DEFAULT '0',
  `regular_upline_support_maximum` double NOT NULL DEFAULT '0',
  `associate_upline_support_maximum` double NOT NULL DEFAULT '0',
  `basic_upline_support_maximum` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_settings_upline_support`
--

/*!40000 ALTER TABLE `network_settings_upline_support` DISABLE KEYS */;
INSERT INTO `network_settings_upline_support` VALUES (100,100,100,100,100,100,100,100,100,100,100,100,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,5,5,5,5,3,3,3,3,2,2,2,2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,3,3,3,2,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `network_settings_upline_support` ENABLE KEYS */;

--
-- Table structure for table `network_share`
--

DROP TABLE IF EXISTS `network_share`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_share` (
  `id` int NOT NULL AUTO_INCREMENT,
  `bonus_share_chairman` double NOT NULL DEFAULT '0',
  `bonus_share_chairman_now` double NOT NULL DEFAULT '0',
  `bonus_share_chairman_last` double NOT NULL DEFAULT '0',
  `bonus_share_director` double NOT NULL DEFAULT '0',
  `bonus_share_director_now` double NOT NULL DEFAULT '0',
  `bonus_share_director_last` double NOT NULL DEFAULT '0',
  `bonus_share_executive` double NOT NULL DEFAULT '0',
  `bonus_share_executive_now` double NOT NULL DEFAULT '0',
  `bonus_share_executive_last` double NOT NULL DEFAULT '0',
  `bonus_share_regular` double NOT NULL DEFAULT '0',
  `bonus_share_regular_now` double NOT NULL DEFAULT '0',
  `bonus_share_regular_last` double NOT NULL DEFAULT '0',
  `bonus_share_associate` double NOT NULL DEFAULT '0',
  `bonus_share_associate_now` double NOT NULL DEFAULT '0',
  `bonus_share_associate_last` double NOT NULL DEFAULT '0',
  `bonus_share_basic` double NOT NULL DEFAULT '0',
  `bonus_share_basic_now` double NOT NULL DEFAULT '0',
  `bonus_share_basic_last` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_share`
--

/*!40000 ALTER TABLE `network_share` DISABLE KEYS */;
INSERT INTO `network_share` VALUES (1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
/*!40000 ALTER TABLE `network_share` ENABLE KEYS */;

--
-- Table structure for table `network_share_associate`
--

DROP TABLE IF EXISTS `network_share_associate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_share_associate` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `share_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_share_associate`
--

/*!40000 ALTER TABLE `network_share_associate` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_share_associate` ENABLE KEYS */;

--
-- Table structure for table `network_share_basic`
--

DROP TABLE IF EXISTS `network_share_basic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_share_basic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `share_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_share_basic`
--

/*!40000 ALTER TABLE `network_share_basic` DISABLE KEYS */;
INSERT INTO `network_share_basic` VALUES (1,1,0,0,1);
/*!40000 ALTER TABLE `network_share_basic` ENABLE KEYS */;

--
-- Table structure for table `network_share_chairman`
--

DROP TABLE IF EXISTS `network_share_chairman`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_share_chairman` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `share_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_share_chairman`
--

/*!40000 ALTER TABLE `network_share_chairman` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_share_chairman` ENABLE KEYS */;

--
-- Table structure for table `network_share_director`
--

DROP TABLE IF EXISTS `network_share_director`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_share_director` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `share_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_share_director`
--

/*!40000 ALTER TABLE `network_share_director` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_share_director` ENABLE KEYS */;

--
-- Table structure for table `network_share_executive`
--

DROP TABLE IF EXISTS `network_share_executive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_share_executive` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `share_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_share_executive`
--

/*!40000 ALTER TABLE `network_share_executive` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_share_executive` ENABLE KEYS */;

--
-- Table structure for table `network_share_fund_request`
--

DROP TABLE IF EXISTS `network_share_fund_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_share_fund_request` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount` double NOT NULL,
  `price` double NOT NULL,
  `method` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_requested` int NOT NULL,
  `date_confirmed` int NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_share_fund_request`
--

/*!40000 ALTER TABLE `network_share_fund_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_share_fund_request` ENABLE KEYS */;

--
-- Table structure for table `network_share_fund_requests`
--

DROP TABLE IF EXISTS `network_share_fund_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_share_fund_requests` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NOT NULL,
  `amount` double NOT NULL,
  `price` double NOT NULL,
  `method` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_date` int NOT NULL,
  `request_total` double NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_share_fund_requests`
--

/*!40000 ALTER TABLE `network_share_fund_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_share_fund_requests` ENABLE KEYS */;

--
-- Table structure for table `network_share_regular`
--

DROP TABLE IF EXISTS `network_share_regular`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_share_regular` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `share_upline_id` int NOT NULL DEFAULT '0',
  `has_mature` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_share_regular`
--

/*!40000 ALTER TABLE `network_share_regular` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_share_regular` ENABLE KEYS */;

--
-- Table structure for table `network_subscribe_request`
--

DROP TABLE IF EXISTS `network_subscribe_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_subscribe_request` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount` double NOT NULL,
  `price` double NOT NULL,
  `method` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_requested` int NOT NULL,
  `date_confirmed` int NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_subscribe_request`
--

/*!40000 ALTER TABLE `network_subscribe_request` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_subscribe_request` ENABLE KEYS */;

--
-- Table structure for table `network_subscribe_requests`
--

DROP TABLE IF EXISTS `network_subscribe_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_subscribe_requests` (
  `request_id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NOT NULL,
  `amount` double NOT NULL,
  `price` double NOT NULL,
  `method` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `request_date` int NOT NULL,
  `request_total` double NOT NULL,
  PRIMARY KEY (`request_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_subscribe_requests`
--

/*!40000 ALTER TABLE `network_subscribe_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_subscribe_requests` ENABLE KEYS */;

--
-- Table structure for table `network_token_add`
--

DROP TABLE IF EXISTS `network_token_add`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_token_add` (
  `add_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount` double NOT NULL,
  `date` int NOT NULL,
  PRIMARY KEY (`add_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_token_add`
--

/*!40000 ALTER TABLE `network_token_add` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_token_add` ENABLE KEYS */;

--
-- Table structure for table `network_token_conversions`
--

DROP TABLE IF EXISTS `network_token_conversions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_token_conversions` (
  `conversion_id` int NOT NULL AUTO_INCREMENT,
  `transaction_id` int NOT NULL,
  `amount` double NOT NULL,
  `conversion_date` int NOT NULL,
  `conversion_total` double NOT NULL,
  `amount_tax` double NOT NULL,
  `total_tax` double NOT NULL,
  PRIMARY KEY (`conversion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_token_conversions`
--

/*!40000 ALTER TABLE `network_token_conversions` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_token_conversions` ENABLE KEYS */;

--
-- Table structure for table `network_token_convert`
--

DROP TABLE IF EXISTS `network_token_convert`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_token_convert` (
  `convert_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount` double NOT NULL,
  `amount_final` double NOT NULL,
  `deduction_total` double NOT NULL,
  `date_converted` int NOT NULL,
  `date_completed` int NOT NULL,
  `method` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '',
  PRIMARY KEY (`convert_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_token_convert`
--

/*!40000 ALTER TABLE `network_token_convert` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_token_convert` ENABLE KEYS */;

--
-- Table structure for table `network_top_up`
--

DROP TABLE IF EXISTS `network_top_up`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_top_up` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `time_last` int NOT NULL,
  `value_last` double NOT NULL,
  `day` int NOT NULL,
  `principal` double NOT NULL,
  `date_entry` int NOT NULL,
  `processing` int NOT NULL,
  `maturity` int NOT NULL,
  `time_mature` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_top_up`
--

/*!40000 ALTER TABLE `network_top_up` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_top_up` ENABLE KEYS */;

--
-- Table structure for table `network_transactions`
--

DROP TABLE IF EXISTS `network_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_transactions` (
  `transaction_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `transaction` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` double NOT NULL,
  `balance` double NOT NULL,
  `transaction_date` int NOT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_transactions`
--

/*!40000 ALTER TABLE `network_transactions` DISABLE KEYS */;
INSERT INTO `network_transactions` VALUES (1,2,'Admin Added USDT','10,000.00 AET added to <a href=\"member-info?uid=2\">test1</a>.',10000,20000,1734931584),(2,2,'Account Activation','<b>1000 Activation: </b><a href=\"member-info?uid=2\">test1</a>, sponsored by <a href=\"member-info?uid=1\">admin</a>.',1000,0,1734931655),(3,2,'USDT Withdrawal Approved','<b>USDT Withdrawal Approved: </b><a href=\"member-info?uid=2\">test1</a> has withdrawn 1,000.00000000 AET',1000,1000,1734931695),(4,3,'Admin Added USDT','10,000.00 AET added to <a href=\"member-info?uid=3\">test2</a>.',10000,20000,1734937776),(5,3,'Account Activation','<b>1000 Activation: </b><a href=\"member-info?uid=3\">test2</a>, sponsored by <a href=\"member-info?uid=2\">test1</a>.',1000,0,1734937919),(6,3,'USDT Withdrawal Approved','<b>USDT Withdrawal Approved: </b><a href=\"member-info?uid=3\">test2</a> has withdrawn 1,000.00000000 AET',1000,1000,1734938141);
/*!40000 ALTER TABLE `network_transactions` ENABLE KEYS */;

--
-- Table structure for table `network_transfer`
--

DROP TABLE IF EXISTS `network_transfer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_transfer` (
  `transfer_id` int NOT NULL AUTO_INCREMENT,
  `transfer_from` int NOT NULL,
  `transfer_to` int NOT NULL,
  `type` enum('transfer','deposit') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'transfer',
  `date` int NOT NULL,
  `amount` double NOT NULL,
  PRIMARY KEY (`transfer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_transfer`
--

/*!40000 ALTER TABLE `network_transfer` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_transfer` ENABLE KEYS */;

--
-- Table structure for table `network_transfer_fmc`
--

DROP TABLE IF EXISTS `network_transfer_fmc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_transfer_fmc` (
  `transfer_id` int NOT NULL AUTO_INCREMENT,
  `transfer_from` int NOT NULL,
  `transfer_to` int NOT NULL,
  `type` enum('transfer','deposit') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'transfer',
  `date` int NOT NULL,
  `amount` double NOT NULL,
  PRIMARY KEY (`transfer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_transfer_fmc`
--

/*!40000 ALTER TABLE `network_transfer_fmc` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_transfer_fmc` ENABLE KEYS */;

--
-- Table structure for table `network_transfer_points`
--

DROP TABLE IF EXISTS `network_transfer_points`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_transfer_points` (
  `transfer_id` int NOT NULL AUTO_INCREMENT,
  `transfer_from` int NOT NULL,
  `transfer_to` int NOT NULL,
  `type` enum('transfer','deposit') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'transfer',
  `date` int NOT NULL,
  `amount` double NOT NULL,
  PRIMARY KEY (`transfer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_transfer_points`
--

/*!40000 ALTER TABLE `network_transfer_points` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_transfer_points` ENABLE KEYS */;

--
-- Table structure for table `network_unilevel`
--

DROP TABLE IF EXISTS `network_unilevel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_unilevel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL DEFAULT '0',
  `bonus_unilevel` double NOT NULL DEFAULT '0',
  `bonus_unilevel_now` double NOT NULL DEFAULT '0',
  `bonus_unilevel_last` double NOT NULL DEFAULT '0',
  `period_unilevel` double NOT NULL DEFAULT '0',
  `income_today` double NOT NULL DEFAULT '0',
  `date_last_flushout` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_unilevel`
--

/*!40000 ALTER TABLE `network_unilevel` DISABLE KEYS */;
INSERT INTO `network_unilevel` VALUES (1,1,0,0,0,0,0,0);
/*!40000 ALTER TABLE `network_unilevel` ENABLE KEYS */;

--
-- Table structure for table `network_users`
--

DROP TABLE IF EXISTS `network_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sponsor_id` int NOT NULL DEFAULT '0',
  `has_maintain` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `elite` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `balance` double NOT NULL DEFAULT '0',
  `income_cycle_global` double NOT NULL DEFAULT '0',
  `income_flushout` double NOT NULL DEFAULT '0',
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `fullname` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `block` tinyint NOT NULL DEFAULT '0',
  `usertype` enum('Member','Admin','manager') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Member',
  `picture` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `date_registered` int NOT NULL DEFAULT '0',
  `date_activated` int NOT NULL DEFAULT '0',
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `contact` json DEFAULT NULL,
  `beneficiary` json DEFAULT NULL,
  `points` double NOT NULL DEFAULT '0',
  `account_type` enum('chairman','executive','regular','associate','basic','starter') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'starter',
  `rank` enum('affiliate','supervisor','manager','director') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'affiliate',
  `rank_reward` double NOT NULL DEFAULT '0',
  `elite_reward` double NOT NULL DEFAULT '0',
  `bank` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` json DEFAULT NULL,
  `income_referral` double NOT NULL DEFAULT '0',
  `income_referral_flushout` double NOT NULL DEFAULT '0',
  `bonus_echelon` double NOT NULL DEFAULT '0',
  `payout_total` double NOT NULL DEFAULT '0',
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payout_giftcheck` double NOT NULL DEFAULT '0',
  `payout_transfer` double NOT NULL DEFAULT '0',
  `unilevel` double NOT NULL DEFAULT '0',
  `balance_fmc` double NOT NULL DEFAULT '0',
  `p2p_wallet` json DEFAULT NULL,
  `bonus_leadership` double NOT NULL DEFAULT '0',
  `bonus_leadership_passive` double NOT NULL DEFAULT '0',
  `bonus_indirect_referral` double NOT NULL DEFAULT '0',
  `bonus_indirect_referral_points` double NOT NULL DEFAULT '0',
  `bonus_indirect_referral_fmc` double NOT NULL DEFAULT '0',
  `bonus_matrix` double NOT NULL DEFAULT '0',
  `bonus_power` double NOT NULL DEFAULT '0',
  `bonus_share` double NOT NULL DEFAULT '0',
  `bonus_harvest` double NOT NULL DEFAULT '0',
  `top_up_principal` double NOT NULL DEFAULT '0',
  `top_up_interest` double NOT NULL DEFAULT '0',
  `fast_track_principal` double NOT NULL DEFAULT '0',
  `fast_track_interest` double NOT NULL DEFAULT '0',
  `fixed_daily_interest` double NOT NULL DEFAULT '0',
  `compound_daily_interest` double NOT NULL DEFAULT '0',
  `donation` double NOT NULL DEFAULT '0',
  `merchant_type` enum('chairman','executive','regular','associate','basic','starter') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'starter',
  `bonus_merchant` double NOT NULL DEFAULT '0',
  `coin_transfer` double NOT NULL DEFAULT '0',
  `bonus_leadership_passive_balance` double NOT NULL DEFAULT '0',
  `top_up_balance` double NOT NULL DEFAULT '0',
  `fast_track_balance` double NOT NULL DEFAULT '0',
  `fixed_daily_balance` double NOT NULL DEFAULT '0',
  `compound_daily_balance` double NOT NULL DEFAULT '0',
  `upline_support` double NOT NULL DEFAULT '0',
  `passup_bonus` double NOT NULL DEFAULT '0',
  `stockist_bonus` double NOT NULL DEFAULT '0',
  `franchise_bonus` double NOT NULL DEFAULT '0',
  `endowment_bonus` double NOT NULL DEFAULT '0',
  `converted_today` double NOT NULL DEFAULT '0',
  `requested_today` double NOT NULL DEFAULT '0',
  `status_global` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `savings` double NOT NULL DEFAULT '0',
  `share_fund` double NOT NULL DEFAULT '0',
  `loans` double NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_users`
--

/*!40000 ALTER TABLE `network_users` DISABLE KEYS */;
INSERT INTO `network_users` VALUES (1,0,'0','0',0,220,0,'admin','Bitcash','63a9f0ea7bb98050796b649e85481845',0,'Admin','',1734931505,1734931505,'admin@bit-cash.online','{\"messenger\": \"1\"}',NULL,0,'executive','director',0,0,'','{\"aet\": \"1\"}',30,0,220,0,'1|1|1|1|16',0,1000350,0,20978512206.617813,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'executive',0,0,0,0,0,0,0,0,0,0,0,0,0,0,'active',0,0,0),(2,1,'0','0',0,140,0,'test1','1','c4ca4238a0b923820dcc509a6f75849b',0,'Member','',1734931638,1734931655,'1','{\"messenger\": \"1\"}',NULL,30,'associate','affiliate',0,0,'','{\"aet\": \"1\"}',30,0,120,0,'1|1|1|1|19',0,8268,0,0,NULL,0,0,20,0,0,0,0,0,0,0,0,0,0,0,0,0,'starter',0,0,0,0,0,0,0,0,0,0,0,0,1000,0,'active',0,0,0),(3,2,'0','0',0,0,0,'test2','1','c4ca4238a0b923820dcc509a6f75849b',0,'Member','',1734938107,1734938107,'1','{\"messenger\": \"1\"}',NULL,30,'associate','affiliate',0,0,'','{\"aet\": \"1\"}',0,0,0,0,'1|1|1|1|23',0,7998,0,0,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'starter',0,0,0,0,0,0,0,0,0,0,0,0,1000,0,'active',0,0,0);
/*!40000 ALTER TABLE `network_users` ENABLE KEYS */;

--
-- Table structure for table `network_withdrawals`
--

DROP TABLE IF EXISTS `network_withdrawals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `network_withdrawals` (
  `withdrawal_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `amount` double NOT NULL,
  `amount_final` double NOT NULL,
  `deductions_total` double NOT NULL,
  `date_requested` int NOT NULL,
  `date_completed` int NOT NULL,
  `method` enum('Check','Bank Deposit') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Check',
  PRIMARY KEY (`withdrawal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `network_withdrawals`
--

/*!40000 ALTER TABLE `network_withdrawals` DISABLE KEYS */;
/*!40000 ALTER TABLE `network_withdrawals` ENABLE KEYS */;

--
-- Dumping routines for database 'peratokenpeso_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-23 16:57:18
