-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: localhost    Database: homestead
-- ------------------------------------------------------
-- Server version	5.7.26-0ubuntu0.18.04.1

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
-- Current Database: `homestead`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `homestead` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin */;

USE `homestead`;

--
-- Table structure for table `acc_class`
--

DROP TABLE IF EXISTS `acc_class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acc_class` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_kelas` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_pelatih` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acc_class`
--

LOCK TABLES `acc_class` WRITE;
/*!40000 ALTER TABLE `acc_class` DISABLE KEYS */;
INSERT INTO `acc_class` VALUES (1,'fsSdT5','hflosqySM6fZ0NCCTBDrSpHic2rL5u8h','2019-07-15 00:38:57','2019-07-15 00:38:57'),(2,'wpIIck','T82znslzBDhJZODaIuU6SoCV6xWN4hyw','2019-07-15 05:49:45','2019-07-15 05:49:45');
/*!40000 ALTER TABLE `acc_class` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `access_auth_token`
--

DROP TABLE IF EXISTS `access_auth_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_auth_token` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_pair` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_pair` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_status` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access_auth_token`
--

LOCK TABLES `access_auth_token` WRITE;
/*!40000 ALTER TABLE `access_auth_token` DISABLE KEYS */;
/*!40000 ALTER TABLE `access_auth_token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kelas_data`
--

DROP TABLE IF EXISTS `kelas_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kelas_data` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_kelas` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_pelatih` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_kelas` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `durasi_latihan` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kelas_data_kode_kelas_unique` (`kode_kelas`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kelas_data`
--

LOCK TABLES `kelas_data` WRITE;
/*!40000 ALTER TABLE `kelas_data` DISABLE KEYS */;
INSERT INTO `kelas_data` VALUES (1,'fsSdT5','hflosqySM6fZ0NCCTBDrSpHic2rL5u8h','Karate Batu Poncosiwalan','96','/photos/2/15800009_1130957637002847_6767809703334865166_o.jpg','2019-07-15 00:38:57','2019-07-15 00:38:57'),(2,'wpIIck','T82znslzBDhJZODaIuU6SoCV6xWN4hyw','Karate Jalan Pintas','96','/photos/4/673431.jpg','2019-07-15 05:49:45','2019-07-27 22:30:40');
/*!40000 ALTER TABLE `kelas_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_07_14_160008_create_acc_class_table',1),(4,'2019_07_14_160030_create_record_latihan_table',1),(5,'2019_07_14_160049_create_kelas_data_table',1),(6,'2019_07_14_160119_create_pelatih_data_table',1),(7,'2019_07_14_160131_create_peserta_data_table',1),(8,'2019_07_14_160145_create_peserta_req_file_table',1),(9,'2019_07_14_160215_create_peserta_req_budget_table',1),(10,'2019_07_14_160232_create_static_req_budget_table',1),(11,'2019_07_14_160300_create_static_req_file_table',1),(12,'2019_07_14_160319_create_record_spp_peserta_table',1),(13,'2019_07_14_160334_create_access_auth_token_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pelatih_data`
--

DROP TABLE IF EXISTS `pelatih_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pelatih_data` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_pelatih` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pelatih` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `msh_pelatih` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pelatih_data_kode_pelatih_unique` (`kode_pelatih`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pelatih_data`
--

LOCK TABLES `pelatih_data` WRITE;
/*!40000 ALTER TABLE `pelatih_data` DISABLE KEYS */;
INSERT INTO `pelatih_data` VALUES (1,'hflosqySM6fZ0NCCTBDrSpHic2rL5u8h','Edo Satria Nata',NULL,'2019-07-15 00:36:00','2019-07-15 00:36:00'),(2,'T82znslzBDhJZODaIuU6SoCV6xWN4hyw','Saptiani Novirda','18346','2019-07-15 04:25:01','2019-07-27 22:35:52');
/*!40000 ALTER TABLE `pelatih_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peserta_data`
--

DROP TABLE IF EXISTS `peserta_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peserta_data` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_peserta` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_kelas_peserta` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_peserta` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `noinduk` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `peserta_data_kode_peserta_unique` (`kode_peserta`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peserta_data`
--

LOCK TABLES `peserta_data` WRITE;
/*!40000 ALTER TABLE `peserta_data` DISABLE KEYS */;
INSERT INTO `peserta_data` VALUES (1,'pJpf61KgV9WhMvoKPacql2ytzJrV10wl','fsSdT5','Rendi Bagas Saputra','5',NULL,'2019-07-15 00:41:49','2019-07-15 00:41:49'),(2,'AadpBycjyB2SMgObUZraWrHGdHwKTAN8','wpIIck','Desi Ratna Sari','3',NULL,'2019-07-15 08:43:12','2019-07-15 08:43:12'),(3,'pbR54qYAToUD3cjXvCfeaClG9EigKBRZ','wpIIck','Suroso Enaknyo Piyambak','3',NULL,'2019-07-27 21:33:14','2019-07-27 21:33:14');
/*!40000 ALTER TABLE `peserta_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peserta_req_budget`
--

DROP TABLE IF EXISTS `peserta_req_budget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peserta_req_budget` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_kelas` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_peserta` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_pj` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kredit` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `saldo` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peserta_req_budget`
--

LOCK TABLES `peserta_req_budget` WRITE;
/*!40000 ALTER TABLE `peserta_req_budget` DISABLE KEYS */;
INSERT INTO `peserta_req_budget` VALUES (1,'wpIIck','AadpBycjyB2SMgObUZraWrHGdHwKTAN8','T82znslzBDhJZODaIuU6SoCV6xWN4hyw','120000','120000','2019-07-15 08:47:13','2019-07-15 08:47:13'),(2,'wpIIck','AadpBycjyB2SMgObUZraWrHGdHwKTAN8','T82znslzBDhJZODaIuU6SoCV6xWN4hyw','20000','140000','2019-07-27 18:01:56','2019-07-27 18:01:56');
/*!40000 ALTER TABLE `peserta_req_budget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `peserta_req_file`
--

DROP TABLE IF EXISTS `peserta_req_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `peserta_req_file` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_kelas` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_peserta` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_pj` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_file` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_info` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `peserta_req_file`
--

LOCK TABLES `peserta_req_file` WRITE;
/*!40000 ALTER TABLE `peserta_req_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `peserta_req_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `record_latihan`
--

DROP TABLE IF EXISTS `record_latihan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `record_latihan` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_kelas_peserta` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_peserta` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_pelatih` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `durasi` varchar(2) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `record_latihan`
--

LOCK TABLES `record_latihan` WRITE;
/*!40000 ALTER TABLE `record_latihan` DISABLE KEYS */;
INSERT INTO `record_latihan` VALUES (1,'wpIIck','AadpBycjyB2SMgObUZraWrHGdHwKTAN8','T82znslzBDhJZODaIuU6SoCV6xWN4hyw','Latihan Kihon + kuda kuda','3','2019-07-27 21:48:17','2019-07-27 21:48:17'),(2,'wpIIck','pbR54qYAToUD3cjXvCfeaClG9EigKBRZ','T82znslzBDhJZODaIuU6SoCV6xWN4hyw','Latihan Kihon + kuda kuda','3','2019-07-27 21:48:17','2019-07-27 21:48:17');
/*!40000 ALTER TABLE `record_latihan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `record_spp_peserta`
--

DROP TABLE IF EXISTS `record_spp_peserta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `record_spp_peserta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_peserta` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kredit` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `untuk_bulan` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_pj` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `record_spp_peserta`
--

LOCK TABLES `record_spp_peserta` WRITE;
/*!40000 ALTER TABLE `record_spp_peserta` DISABLE KEYS */;
/*!40000 ALTER TABLE `record_spp_peserta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `static_req_budget`
--

DROP TABLE IF EXISTS `static_req_budget`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `static_req_budget` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_kelas` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `biaya_ujian` varchar(7) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `static_req_budget`
--

LOCK TABLES `static_req_budget` WRITE;
/*!40000 ALTER TABLE `static_req_budget` DISABLE KEYS */;
INSERT INTO `static_req_budget` VALUES (1,'wpIIck','10','175000','2019-07-16 00:30:12','2019-07-27 21:40:56'),(2,'wpIIck','8','120000','2019-07-16 00:37:11','2019-07-27 21:40:56'),(3,'wpIIck','6','140000','2019-07-16 00:37:11','2019-07-27 21:40:56'),(4,'wpIIck','3','160000','2019-07-16 00:38:44','2019-07-27 21:40:56'),(5,'wpIIck','7','145000','2019-07-27 21:40:56','2019-07-27 21:40:56');
/*!40000 ALTER TABLE `static_req_budget` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `static_req_file`
--

DROP TABLE IF EXISTS `static_req_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `static_req_file` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kode_file` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_kelas` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_file` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `static_req_file_kode_file_unique` (`kode_file`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `static_req_file`
--

LOCK TABLES `static_req_file` WRITE;
/*!40000 ALTER TABLE `static_req_file` DISABLE KEYS */;
INSERT INTO `static_req_file` VALUES (1,'GKtD9ClPtM','wpIIck','Foto 4x6','2019-07-27 21:42:00','2019-07-27 21:42:00'),(2,'fZR6FdDfHQ','wpIIck','Raport','2019-07-27 22:31:06','2019-07-27 22:31:06');
/*!40000 ALTER TABLE `static_req_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `born` date DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_line` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'bestnimda','Tio Rizky Bachtiar','bachtiar@mail.com',NULL,'$2y$10$2FVnpQ5LQNm5PEPj4o.js.QXVAhSX0R8f7MR/iguaviefBKbVFweC','1996-03-24',NULL,NULL,'/photos/1/thebachtiarz.png','97wzIGYkktZh1IXpNNRPojMsOOoLNwE7','TQYOaC2MOza0wobaldYb3kyDmZ8chSXgaTp0SJGIBt4hu2wAY3wyrEju630q','2019-07-02 08:41:31','2019-07-15 08:52:06'),(2,'moderator','Edo Satria Nata','edosatria@mail.com',NULL,'$2y$10$PZiKIaA2HSWZvyecJkb3mO24QPzV6WZpD3lK8sgqynABBN9X/cRr.',NULL,NULL,NULL,NULL,'hflosqySM6fZ0NCCTBDrSpHic2rL5u8h',NULL,'2019-07-15 00:34:26','2019-07-15 00:34:26'),(4,'moderator','Saptiani Novirda','saptiani@mail.com',NULL,'$2y$10$yhE9u.q7nlSgMGqwYGA/GOAOkYXMPgAs5bAOQaPobIfdrRJhCDEQy','1998-06-16','085122657512','novirdaseptiani98','/photos/4/112976_e.jpg','T82znslzBDhJZODaIuU6SoCV6xWN4hyw',NULL,'2019-07-15 04:19:21','2019-07-27 22:35:52'),(5,'guests','Surya Hermansyah','surya@mail.com',NULL,'$2y$10$1OaS5/5slAzS8gesQgCaFeu/GL4NbbVtkt8Ueex3FJELGiDoCXIWi','1998-06-16',NULL,NULL,'/photos/5/106834_e.jpg',NULL,NULL,'2019-07-27 22:51:33','2019-07-29 17:16:45');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-07-29 11:31:34
