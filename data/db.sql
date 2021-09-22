-- MySQL dump 10.13  Distrib 5.7.19, for Win64 (x86_64)
--
-- Host: localhost    Database: inoveinn_wp806
-- ------------------------------------------------------
-- Server version	5.7.19

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
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_email_address` varchar(255) COLLATE utf8_bin NOT NULL,
  `subject_id` varchar(255) COLLATE utf8_bin NOT NULL,
  `subject_type` varchar(255) COLLATE utf8_bin NOT NULL,
  `content` text COLLATE utf8_bin NOT NULL,
  `posted_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'indice@indice.com','20','ind_announces','Une suggestion','2021-02-04 06:15:21'),(2,'indice@indice.com','20','ind_announces','Lorem ipsum, dolor sit amet consectetur adipisicing elit. Pariatur voluptas fuga omnis molestias placeat obcaecati amet sapiente architecto consequatur, tempore voluptates, nisi, perspiciatis excepturi dolore ut. Fugit commodi perspiciatis odio eius cum, ullam omnis cumque iste. Odit ipsam placeat qui, deleniti sed iste atque. Molestiae mollitia nesciunt odit animi nam commodi eveniet. Voluptate, dolore deleniti. Perferendis porro repellendus iure distinctio autem tenetur, tempore, aliquam reiciendis vitae dignissimos odit eius recusandae voluptates nesciunt voluptatibus architecto blanditiis nihil earum fuga. Quidem perspiciatis officia, quibusdam natus expedita laboriosam totam sunt sit ducimus rerum odio quo nobis amet enim? Neque explicabo possimus harum modi.','2021-02-04 06:47:10'),(3,'indice@indice.com','20','ind_announces','Un petit commentaire','2021-02-04 06:52:46'),(4,'indice@indice.com','20','ind_announces','Un petit commentaire','2021-02-04 06:53:38'),(5,'indice@indice.com','20','ind_announces','Voici le dernier commentaire que j\'ai laissé.','2021-02-04 20:28:09'),(6,'indice@indice.com','20','ind_announces','Voici le dernier commentaire que j\'ai laissé.','2021-02-04 20:28:52'),(7,'tanohbassapatrick@gmail.com','20','ind_announces','Mon commentaire.','2021-02-04 20:37:22'),(8,'indice@indice.com','19','ind_announces','Pour valider cette annonce, vous devez changer les images et choisir des images plus en relation avec le titre.\r\nAussi La description n\'est pas parlante.','2021-02-04 20:56:46'),(9,'indice@indice.com','20','ind_announces','Un autre commentaire','2021-02-05 19:54:45');
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `slug` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
INSERT INTO `countries` VALUES (1,'Côte d\'Ivoire','cote-d-ivoire');
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ind_announces`
--

DROP TABLE IF EXISTS `ind_announces`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ind_announces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `id_category` int(11) NOT NULL,
  `id_sub_category` int(11) DEFAULT NULL,
  `price` varchar(255) DEFAULT NULL,
  `user_email_address` varchar(255) NOT NULL,
  `user_to_join` varchar(255) DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `direction` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `posted_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `icon_class` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_category` (`id_category`),
  KEY `fk_id_sub_category` (`id_sub_category`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ind_announces`
--

LOCK TABLES `ind_announces` WRITE;
/*!40000 ALTER TABLE `ind_announces` DISABLE KEYS */;
INSERT INTO `ind_announces` VALUES (20,'mon super ordinateur','&lt;p&gt;Mon super ordinateur&lt;/p&gt;','mon-super-ordinateur-20',5,NULL,'250000','tanohbassapatrick@gmail.com',NULL,NULL,'Bouake','offre','particulier',0,'2021-01-15 20:22:40',NULL,NULL,26,NULL),(16,'Vente d\'ordinateur ASUS Core i5 7ème génération 6 G Ram','&lt;p&gt;Un bel ordinateur Asus Core i5 avec 6 G de ram.&lt;br&gt;&lt;/p&gt;','vente-d-ordinateur-asus-core-i5-7eme-generation-6-g-ram-16',5,NULL,'130000','tanohbassapatrick@gmail.com',NULL,NULL,'Abidjan','offre','particulier',2,'2021-01-09 10:27:19',NULL,NULL,6,NULL),(18,'Test','Une offre d\'emploi extraordinaire.&lt;br&gt;','test-18',2,NULL,'price_on_call','tanohbassapatrick@gmail.com','tanohbassapatrick@gmail.com','+225 0545996095','Grand-Bassam','offre','professionnel',2,'2021-01-10 18:54:44',NULL,NULL,3,NULL),(19,'Rédacteur à Jesus Bénit TV','&lt;p&gt;Cet emploi est un emploi merveilleux, il vous garantit une bonne expérience, bien sûr en considérant que vous ferez tout pour le garder. Il est rémunéré à 150 000 F CFA. Lieu de travail : Abengourou.&lt;/p&gt;','redacteur-a-jesus-benit-tv-19',6,NULL,'150000','tanohbassapatrick@gmail.com','tanohbassapatrick@gmail.com','+225 0545996095','Abengourou','offre','professionnel',2,'2021-01-10 19:33:09',NULL,NULL,4,NULL),(22,'Formation pour comment Parler en public','&lt;p&gt;Une belle femme !&lt;br&gt;&lt;/p&gt;','formation-pour-comment-parler-en-public-22',6,NULL,'price_on_call','tanohbassapatrick@gmail.com','tanohbassapatrick@gmail.com','+225 0545996095','Bouaké','offre','particulier',2,'2021-01-16 13:29:26',NULL,NULL,4,NULL),(26,'De bons fruits','&lt;p&gt;De bons fruits.&lt;br&gt;&lt;/p&gt;','de-bons-fruits-26',10,NULL,'500','tanohbassapatrick@gmail.com','joel.developpeur@gmail.com','0545996095','Bouaké','offre','particulier',1,'2021-02-27 11:18:49',NULL,NULL,0,NULL);
/*!40000 ALTER TABLE `ind_announces` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ind_categories`
--

DROP TABLE IF EXISTS `ind_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ind_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `description` text,
  `icon_class` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_title` (`title`),
  UNIQUE KEY `uni_slug` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ind_categories`
--

LOCK TABLES `ind_categories` WRITE;
/*!40000 ALTER TABLE `ind_categories` DISABLE KEYS */;
INSERT INTO `ind_categories` VALUES (4,'Bonnes affaires','bonnes-affaires','2020-12-24 06:30:57',NULL,NULL,'lni-control-panel'),(2,'Véhicules','vehicules','2020-12-24 06:17:23',NULL,NULL,'lni-car'),(3,'Immobilier','immobilier','2020-12-24 06:17:23',NULL,NULL,'lni-home'),(5,'High-Tech','high-tech','2020-12-24 06:30:57',NULL,NULL,'lni-laptop'),(6,'Emploi Formations','emploi-formations','2020-12-24 06:46:14',NULL,NULL,'lni-briefcase'),(7,'Rencontre','rencontre','2020-12-24 06:46:14',NULL,NULL,'lni-heart'),(8,'Matériel professionnel','materiel-professionnel','2020-12-24 06:46:14',NULL,NULL,'lni-notepad'),(9,'Communauté','communaute','2020-12-24 06:46:14',NULL,NULL,'lni-hand'),(10,'Bien-être','bien-etre','2020-12-24 06:46:14',NULL,NULL,'lni-leaf');
/*!40000 ALTER TABLE `ind_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ind_sub_categories`
--

DROP TABLE IF EXISTS `ind_sub_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ind_sub_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `id_category` int(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `modified_at` datetime DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_title` (`title`) USING BTREE,
  UNIQUE KEY `uni_slug` (`slug`),
  KEY `fk_id_category` (`id_category`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ind_sub_categories`
--

LOCK TABLES `ind_sub_categories` WRITE;
/*!40000 ALTER TABLE `ind_sub_categories` DISABLE KEYS */;
INSERT INTO `ind_sub_categories` VALUES (1,'Jeu de football','jeu-de-football',1,'2020-11-27 23:57:24',NULL,'C\'est un jeu de football');
/*!40000 ALTER TABLE `ind_sub_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_address` varchar(255) COLLATE utf8_bin NOT NULL,
  `suscribed_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletters`
--

LOCK TABLES `newsletters` WRITE;
/*!40000 ALTER TABLE `newsletters` DISABLE KEYS */;
INSERT INTO `newsletters` VALUES (2,'tanohbassapatrick@gmail.com','2021-01-31 22:37:09'),(3,'joel.developpeur@gmail.com','2021-01-31 23:13:21'),(4,'indice@indice.com','2021-02-03 21:12:10'),(5,'jsame@inoveinn.com','2021-02-20 07:01:45');
/*!40000 ALTER TABLE `newsletters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `towns`
--

DROP TABLE IF EXISTS `towns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `towns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `id_country` int(11) DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `towns`
--

LOCK TABLES `towns` WRITE;
/*!40000 ALTER TABLE `towns` DISABLE KEYS */;
INSERT INTO `towns` VALUES (1,'Abidjan',1,'abidjan'),(2,'Bouaké',1,'bouake'),(3,'Daloa',1,'daloa'),(4,'Yamoussokro',1,'yamoussokro'),(5,'San-Pédro',1,'san-pedro'),(6,'Divo',1,'divo'),(7,'Korhogo',1,'korhogo'),(8,'Abengourou',1,'agengourou'),(9,'Man',1,'man'),(10,'Gagnoa',1,'gagnoa'),(11,'Soubré',1,'soubre'),(12,'Agboville',1,'agboville'),(13,'Dabou',1,'dabou'),(14,'Grand-Bassam',1,'grand-bassam'),(15,'Bouaflé',1,'bouaflé'),(16,'Issia',1,'issia'),(17,'Sinfra',1,'sinfra'),(18,'Katiola',1,'katiola'),(19,'Bingerville',1,'bingerville'),(20,'Adzopé',1,'adzope'),(21,'Séguéla',1,'seguela'),(22,'Bondoukou',1,'bondoukou'),(23,'Oumé',1,'oume'),(24,'Ferkessedougou',1,'ferkessedougou'),(25,'Dimbokro',1,'dimbokro'),(26,'Odienné',1,'odienne'),(27,'Danané',1,'danane'),(28,'Tingréla',1,'tingrela'),(29,'Guiglo',1,'guiglo'),(30,'Boundiali',1,'boundiali'),(31,'Agnibilékro',1,'agnibilékro'),(32,'Daoukro',1,'daoukro'),(33,'Vavoua',1,'vavoua'),(34,'Zuénoula',1,'zuenoula'),(35,'Tiassalé',1,'tiassale'),(36,'Toumodi',1,'toumodi'),(37,'Akoupé',1,'akoupe'),(38,'Lakota',1,'lakota');
/*!40000 ALTER TABLE `towns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `first_names` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `registered_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  `status` int(11) DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uni_pseudo` (`pseudo`),
  UNIQUE KEY `un_email` (`email_address`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'IdUqwvLaEK4','tanohbassapatrick@gmail.com','TANOH','Joel','jojo1509','$2y$10$kRrZ5L6LsT1T3LI3iaU./eHQgdYAH53zcDJy64DNY1DGsaEv97JDq','+225 45996095','2021-01-01 23:03:25',NULL,1,1),(8,'fbPP60','joel.developpeur@gmail.com','Bassa','Patrick','dieudesannounces','$2y$10$rEabaRX.C1iVB2DKMU9e3OIFoBYS/l7oFPbWK61ZK6HQteHuTiZE6','0749324696','2021-02-01 19:07:15',NULL,0,1),(9,'pIBhZ7Wtng','indice@indice.com','Administrateur','Indice','admin','$2y$10$0dz6BpN//ZJSYOgwW04iHebTzX5ioJo2UcQTJhhkCSNYFvBFODC0y','0749324696','2021-02-03 21:12:09',NULL,1,1),(10,'ypsYhY','jsame@inoveinn.com','jsame','jsame','jsame','$2y$10$GH7y8HoH6uiKI00r4OGLxuT58arPNdMthtKMMmzLkGk27t.N9.kjC','12345678','2021-02-20 07:01:45',NULL,1,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visitors`
--

DROP TABLE IF EXISTS `visitors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visitors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_value` varchar(255) COLLATE utf8_bin NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_action_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visitors`
--

LOCK TABLES `visitors` WRITE;
/*!40000 ALTER TABLE `visitors` DISABLE KEYS */;
INSERT INTO `visitors` VALUES (11,'tanohbassapatrick@gmail.com','2021-01-30 22:15:57','2021-01-30 22:16:48'),(12,'4ETIYcbq','2021-01-30 22:17:38','2021-01-30 22:44:26'),(13,'tLfReJDDqw','2021-01-31 10:34:23','2021-02-01 01:02:34'),(14,'joel.developpeur@gmail.com','2021-02-01 07:13:57','2021-02-01 07:17:50'),(15,'tanohbassapatrick@gmail.com','2021-02-01 18:59:04','2021-02-01 19:02:15'),(16,'oXXgs2KT0F','2021-02-01 23:53:55','2021-02-01 23:57:36'),(17,'tanohbassapatrick@gmail.com','2021-02-02 18:57:16','2021-02-02 19:01:16'),(18,'tanohbassapatrick@gmail.com','2021-02-02 19:50:46','2021-02-02 19:58:36'),(19,'joel.developpeur@gmail.com','2021-02-02 19:59:02','2021-02-02 19:59:28'),(20,'D7iXz6A','2021-02-02 20:30:05','2021-02-02 20:30:05'),(21,'WMkbYiGCE','2021-02-02 20:30:05','2021-02-02 20:30:05'),(22,'ia1OpMwQe','2021-02-02 22:12:01','2021-02-02 22:12:01'),(23,'7hcfMbIA','2021-02-03 07:52:37','2021-02-03 09:06:26'),(24,'tanohbassapatrick@gmail.com','2021-02-03 08:12:03','2021-02-03 08:16:06'),(25,'indice@indice.com','2021-02-03 20:58:50','2021-02-03 21:12:08'),(26,'Z1IIRgHoSX','2021-02-04 06:46:18','2021-02-04 06:46:18'),(27,'J2AE0jq','2021-02-04 20:24:48','2021-02-04 21:18:11'),(28,'MdLrR_VKcLO','2021-02-05 19:44:08','2021-02-06 23:34:22'),(29,'7Ekc_Lj','2021-02-07 11:14:20','2021-02-07 18:01:33'),(30,'tanohbassapatrick@gmail.com','2021-02-07 18:03:34','2021-02-08 00:19:16'),(31,'joel.developpeur@gmail.com','2021-02-08 00:20:37','2021-02-08 00:28:16'),(32,'tanohbassapatrick@gmail.com','2021-02-08 00:28:38','2021-02-08 00:28:53'),(33,'joel.developpeur@gmail.com','2021-02-08 20:15:24','2021-02-08 20:24:08'),(34,'indice@indice.com','2021-02-08 20:25:49','2021-02-08 20:26:23'),(35,'indice@indice.com','2021-02-08 22:12:57','2021-02-09 20:19:03'),(36,'joel.developpeur@gmail.com','2021-02-10 06:00:45','2021-02-10 06:01:35'),(37,'uYGxVB8kEc_','2021-02-10 06:32:44','2021-02-11 22:14:08'),(38,'KrPnzrj','2021-02-15 06:28:25','2021-02-15 06:28:25'),(39,'TMBavbui','2021-02-15 06:28:29','2021-02-16 20:49:32'),(40,'0iRaCT','2021-02-15 06:28:36','2021-02-15 06:36:02'),(41,'VjUt3HK6e2','2021-02-16 20:49:58','2021-02-17 18:32:03'),(42,'QMrR8I3kC','2021-02-16 20:51:22','2021-02-19 21:32:45'),(43,'k_wpvjsfj','2021-02-17 17:56:14','2021-02-17 22:45:36'),(44,'HOiXOO8FOL','2021-02-18 19:38:55','2021-02-18 19:38:55'),(45,'joel.developpeur@gmail.com','2021-02-18 19:38:57','2021-02-18 21:24:05'),(46,'xYbw6B','2021-02-19 19:42:52','2021-02-19 20:39:52'),(47,'indice@indice.com','2021-02-19 20:50:11','2021-02-19 20:51:05'),(48,'tanohbassapatrick@gmail.com','2021-02-19 21:03:28','2021-02-19 21:03:43'),(49,'tanohbassapatrick@gmail.com','2021-02-19 21:25:52','2021-02-20 07:17:02'),(50,'joel.developpeur@gmail.com','2021-02-19 21:28:30','2021-02-19 21:31:35'),(53,'jsame@inoveinn.com','2021-02-20 06:58:33','2021-02-20 07:01:45'),(54,'tanohbassapatrick@gmail.com','2021-02-20 11:39:09','2021-02-20 12:59:11'),(55,'joel.developpeur@gmail.com','2021-02-20 13:11:55','2021-02-20 13:13:18'),(56,'joel.developpeur@gmail.com','2021-02-20 13:15:32','2021-02-20 13:16:59'),(57,'duQpyj9','2021-02-20 16:56:57','2021-02-20 18:03:48'),(58,'zQGIFLSfiE2','2021-02-20 17:51:08','2021-02-20 17:51:08'),(59,'SgwH2e','2021-02-22 22:16:23','2021-02-22 22:18:00'),(60,'rduPg3pFH','2021-02-23 20:01:14','2021-02-23 20:53:12'),(61,'U5d0Pw8BX','2021-02-25 18:17:26','2021-02-25 19:13:21'),(62,'Fric11hSqS','2021-02-25 19:11:56','2021-02-25 19:11:56'),(63,'tanohbassapatrick@gmail.com','2021-02-27 10:24:06','2021-02-27 11:08:47'),(64,'hhCvCzl','2021-02-27 12:43:06','2021-02-27 12:43:06');
/*!40000 ALTER TABLE `visitors` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-02-27 13:32:24
