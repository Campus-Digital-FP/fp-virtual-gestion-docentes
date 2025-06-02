-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: gestor_profesores
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--
USE gestor_profesores;

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_user_unique` (`user`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'admin','admin@gmail.com','$2y$12$4SQXrUyzYOu/Hd0U5WDA0uZ4b.NUfWIRcvmKuGPVLsdPIAb9NvbJG',NULL,'2025-06-02 07:37:10','2025-06-02 07:37:10');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centro_ciclo`
--

DROP TABLE IF EXISTS `centro_ciclo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `centro_ciclo` (
  `id_centro` varchar(50) NOT NULL,
  `id_ciclo` varchar(50) NOT NULL,
  PRIMARY KEY (`id_centro`,`id_ciclo`),
  KEY `centro_ciclo_id_ciclo_foreign` (`id_ciclo`),
  CONSTRAINT `centro_ciclo_id_centro_foreign` FOREIGN KEY (`id_centro`) REFERENCES `centros` (`id_centro`) ON DELETE CASCADE,
  CONSTRAINT `centro_ciclo_id_ciclo_foreign` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclos` (`id_ciclo`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `centro_ciclo`
--

LOCK TABLES `centro_ciclo` WRITE;
/*!40000 ALTER TABLE `centro_ciclo` DISABLE KEYS */;
INSERT INTO `centro_ciclo` VALUES (' 50018829','ADG302'),('22002491','SSC201'),('22002521','ADG201'),('22002521','CESIFC01'),('22004611','SSC302'),('22010712','ELE202'),('44003028','SEA301'),('44003211','ADG201'),('44003235','SAN203'),('44010537','IFC302'),('50008460','SSC201'),('50008642','SSC303'),('50009348','SSC302'),('50009567','ELE304'),('50009567','SAN202'),('50009567','SAN203'),('50010144','IFC301'),('50010156','HOT301'),('50010314','COM201'),('50010314','COM301'),('50010314','COM302'),('50010314','COM303'),('50010314','IFC201'),('50010314','IFC303'),('50010314','IMS302'),('50010511','ADG201'),('50018829','ADG301'),('50018829','ADG302'),('50018829','QUI301'),('50020125','CESIFC01'),('50020125','CESIFC02'),('50020125','IFC201'),('50020125','IFC301'),('50020125','IFC302'),('50020125','IFC303'),('actualizacion','moodle'),('formacion','profesorado'),('moodle','para'),('muestra','smr');
/*!40000 ALTER TABLE `centro_ciclo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centro_docente`
--

DROP TABLE IF EXISTS `centro_docente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `centro_docente` (
  `id_centro` varchar(255) NOT NULL,
  `dni` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id_centro`,`dni`),
  KEY `centro_docente_dni_foreign` (`dni`),
  CONSTRAINT `centro_docente_dni_foreign` FOREIGN KEY (`dni`) REFERENCES `docentes` (`dni`) ON DELETE CASCADE,
  CONSTRAINT `centro_docente_id_centro_foreign` FOREIGN KEY (`id_centro`) REFERENCES `centros` (`id_centro`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `centro_docente`
--

LOCK TABLES `centro_docente` WRITE;
/*!40000 ALTER TABLE `centro_docente` DISABLE KEYS */;
/*!40000 ALTER TABLE `centro_docente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `centros`
--

DROP TABLE IF EXISTS `centros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `centros` (
  `id_centro` varchar(50) NOT NULL,
  `nombre` varchar(128) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_centro`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `centros`
--

LOCK TABLES `centros` WRITE;
/*!40000 ALTER TABLE `centros` DISABLE KEYS */;
INSERT INTO `centros` VALUES (' 50018829','CPIFP CORONA DE ARAGÓN',NULL,NULL),('22002491','CPIFP MONTEARAGON',NULL,NULL),('22002521','IES SIERRA DE GUARA',NULL,NULL),('22004611','IES MARTÍNEZ VARGAS',NULL,NULL),('22010712','CPIFP PIRÁMIDE',NULL,NULL),('44003028','CPIFP SAN BLAS',NULL,NULL),('44003211','IES SANTA EMERENCIANA',NULL,NULL),('44003235','IES VEGA DEL TURIA',NULL,NULL),('44010537','CPIFP BAJO ARAGÓN',NULL,NULL),('50008460','IES LUIS BUÑUEL',NULL,NULL),('50008642','IES MARÍA MOLINER',NULL,NULL),('50009348','IES AVEMPACE',NULL,NULL),('50009567','IES RÍO GÁLLEGO',NULL,NULL),('50010144','IES PABLO SERRANO',NULL,NULL),('50010156','IES MIRALBUENO',NULL,NULL),('50010314','CPIFP LOS ENLACES',NULL,NULL),('50010511','IES TIEMPOS MODERNOS',NULL,NULL),('50018829','CPIFP CORONA DE ARAGÓN',NULL,NULL),('50020125','CAMPUS DIGITAL FP',NULL,NULL),('actualizacion','Miscelánea',NULL,NULL),('ayuda','General',NULL,NULL),('CD_interno','Miscelánea',NULL,NULL),('coordinacion','General',NULL,NULL),('dig','Miscelánea',NULL,NULL),('ejemplo','Miscelánea',NULL,NULL),('formacion','Miscelánea',NULL,NULL),('ing','Miscelánea',NULL,NULL),('Interno','Miscelánea',NULL,NULL),('m1','Miscelánea',NULL,NULL),('m2','Miscelánea',NULL,NULL),('marketplaces','NO BORRAR - APP MOVIL',NULL,NULL),('moodle','Miscelánea',NULL,NULL),('muestra','Miscelánea',NULL,NULL),('profesorado','General',NULL,NULL),('pruebas','Miscelánea',NULL,NULL),('restauraciones','Miscelánea',NULL,NULL),('STI_Inglés_1','Miscelánea',NULL,NULL);
/*!40000 ALTER TABLE `centros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciclo_modulo`
--

DROP TABLE IF EXISTS `ciclo_modulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ciclo_modulo` (
  `id_ciclo` varchar(50) NOT NULL,
  `id_modulo` varchar(255) NOT NULL,
  PRIMARY KEY (`id_ciclo`,`id_modulo`),
  KEY `ciclo_modulo_id_modulo_foreign` (`id_modulo`),
  CONSTRAINT `ciclo_modulo_id_ciclo_foreign` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclos` (`id_ciclo`) ON DELETE CASCADE,
  CONSTRAINT `ciclo_modulo_id_modulo_foreign` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciclo_modulo`
--

LOCK TABLES `ciclo_modulo` WRITE;
/*!40000 ALTER TABLE `ciclo_modulo` DISABLE KEYS */;
INSERT INTO `ciclo_modulo` VALUES ('ADG201','14636'),('ADG201','14638'),('ADG201','14640'),('ADG201','14642'),('ADG201','14655'),('ADG201','14657'),('ADG201','14663'),('ADG201','14665'),('ADG201','5111'),('ADG201','5114'),('ADG201','5117'),('ADG201','5118'),('ADG201','5119'),('ADG201','5120'),('ADG201','5122'),('ADG201','5364'),('ADG201','5365'),('ADG201','5367'),('ADG201','5368'),('ADG201','5373'),('ADG201','639t'),('ADG301','14675'),('ADG301','14679'),('ADG301','14681'),('ADG301','14700'),('ADG301','14702'),('ADG301','14704'),('ADG301','14709'),('ADG301','5099'),('ADG301','5100'),('ADG301','5101'),('ADG301','5148'),('ADG301','5149'),('ADG301','5150'),('ADG301','5152'),('ADG301','5193'),('ADG301','5194'),('ADG301','5294'),('ADG301','5295'),('ADG301','5296'),('ADG301','5297'),('ADG301','5403'),('ADG301','79t'),('ADG302','14713'),('ADG302','14717'),('ADG302','14719'),('ADG302','14730'),('ADG302','14732'),('ADG302','14739'),('ADG302','14743'),('ADG302','750t'),('ADG302','7851'),('ADG302','7852'),('ADG302','7853'),('ADG302','7854'),('ADG302','7855'),('ADG302','7861'),('ADG302','7862'),('ADG302','7863'),('ADG302','7869'),('ADG302','7870'),('ADG302','7871'),('ADG302','7872'),('ADG302','8491'),('CESIFC01','14339'),('CESIFC01','14340'),('CESIFC01','14341'),('CESIFC01','14342'),('CESIFC01','14343'),('CESIFC01','14344'),('CESIFC01','873t'),('CESIFC02','14345'),('CESIFC02','14346'),('CESIFC02','14347'),('CESIFC02','14348'),('CESIFC02','14349'),('CESIFC02','866t'),('COM201','13942'),('COM201','13943'),('COM201','13944'),('COM201','13945'),('COM201','13946'),('COM201','13947'),('COM201','13948'),('COM201','13949'),('COM201','13950'),('COM201','13951'),('COM201','13952'),('COM201','13953'),('COM201','13954'),('COM201','15335'),('COM201','15342'),('COM201','15344'),('COM201','15350'),('COM201','15356'),('COM201','15358'),('COM201','15360'),('COM201','15365'),('COM201','15369'),('COM201','700t'),('COM301','15373'),('COM301','15380'),('COM301','15382'),('COM301','15392'),('COM301','15399'),('COM301','15403'),('COM301','15407'),('COM301','5158'),('COM301','5159'),('COM301','5160'),('COM301','5161'),('COM301','5162'),('COM301','5163'),('COM301','5164'),('COM301','5166'),('COM301','5405'),('COM301','5406'),('COM301','5407'),('COM301','5408'),('COM301','5409'),('COM301','5417'),('COM301','83t'),('COM302','15409'),('COM302','15414'),('COM302','15416'),('COM302','15418'),('COM302','15428'),('COM302','15435'),('COM302','15439'),('COM302','15441'),('COM302','738t'),('COM302','7907'),('COM302','7908'),('COM302','7909'),('COM302','7910'),('COM302','7913'),('COM302','7916'),('COM302','7917'),('COM302','7918'),('COM302','7919'),('COM302','7920'),('COM302','7925'),('COM302','7926'),('COM302','7928'),('COM302','8412'),('COM303','15445'),('COM303','15452'),('COM303','15454'),('COM303','15465'),('COM303','15470'),('COM303','15477'),('COM303','15479'),('COM303','5195'),('COM303','5198'),('COM303','5200'),('COM303','5202'),('COM303','5203'),('COM303','5204'),('COM303','5206'),('COM303','5419'),('COM303','5421'),('COM303','5422'),('COM303','5424'),('COM303','5426'),('COM303','5430'),('COM303','85t'),('ELE202','12359'),('ELE202','12360'),('ELE202','15564'),('ELE202','15571'),('ELE202','15575'),('ELE202','15577'),('ELE202','15588'),('ELE202','15592'),('ELE202','15594'),('ELE202','15596'),('ELE202','15598'),('ELE202','4980'),('ELE202','4981'),('ELE202','4982'),('ELE202','4984'),('ELE202','4986'),('ELE202','4987'),('ELE202','5335'),('ELE202','5337'),('ELE202','5338'),('ELE202','5344'),('ELE202','624t'),('ELE304','13926'),('ELE304','13927'),('ELE304','13928'),('ELE304','13929'),('ELE304','13930'),('ELE304','13931'),('ELE304','13932'),('ELE304','13933'),('ELE304','13934'),('ELE304','13935'),('ELE304','13936'),('ELE304','13937'),('ELE304','13938'),('ELE304','13939'),('ELE304','13940'),('ELE304','13941'),('ELE304','15758'),('ELE304','15764'),('ELE304','15766'),('ELE304','15768'),('ELE304','15774'),('ELE304','97t'),('HOT301','16462'),('HOT301','16468'),('HOT301','16470'),('HOT301','16472'),('HOT301','16478'),('HOT301','16482'),('HOT301','16484'),('HOT301','16488'),('HOT301','5223'),('HOT301','5224'),('HOT301','5225'),('HOT301','5228'),('HOT301','5234'),('HOT301','5235'),('HOT301','5236'),('HOT301','5237'),('HOT301','5239'),('HOT301','5447'),('HOT301','5456'),('HOT301','5457'),('HOT301','5458'),('HOT301','5463'),('HOT301','645t'),('IFC201','16693'),('IFC201','16695'),('IFC201','16697'),('IFC201','16706'),('IFC201','16711'),('IFC201','16713'),('IFC201','16715'),('IFC201','16724'),('IFC201','16726'),('IFC201','4991'),('IFC201','4993'),('IFC201','4994'),('IFC201','4995'),('IFC201','4997'),('IFC201','4998'),('IFC201','5001'),('IFC201','5347'),('IFC201','5348'),('IFC201','5349'),('IFC201','5351'),('IFC201','5355'),('IFC201','5359'),('IFC201','627t'),('IFC301','16728'),('IFC301','16737'),('IFC301','16739'),('IFC301','16752'),('IFC301','16754'),('IFC301','16756'),('IFC301','16762'),('IFC301','5051'),('IFC301','5052'),('IFC301','5053'),('IFC301','5054'),('IFC301','5055'),('IFC301','5056'),('IFC301','5058'),('IFC301','5059'),('IFC301','5061'),('IFC301','5272'),('IFC301','5273'),('IFC301','5274'),('IFC301','5275'),('IFC301','5276'),('IFC301','5283'),('IFC301','5286'),('IFC301','643t'),('IFC302','16767'),('IFC302','16771'),('IFC302','16773'),('IFC302','16787'),('IFC302','16789'),('IFC302','16796'),('IFC302','16801'),('IFC302','5066'),('IFC302','5068'),('IFC302','5069'),('IFC302','5070'),('IFC302','5071'),('IFC302','5072'),('IFC302','5074'),('IFC302','5075'),('IFC302','5077'),('IFC302','5173'),('IFC302','5176'),('IFC302','5288'),('IFC302','5289'),('IFC302','5290'),('IFC302','5291'),('IFC302','5293'),('IFC302','681t'),('IFC303','16805'),('IFC303','16809'),('IFC303','16811'),('IFC303','16829'),('IFC303','16831'),('IFC303','16833'),('IFC303','16835'),('IFC303','5083'),('IFC303','5084'),('IFC303','5085'),('IFC303','5086'),('IFC303','5087'),('IFC303','5089'),('IFC303','5090'),('IFC303','5092'),('IFC303','5178'),('IFC303','5179'),('IFC303','5180'),('IFC303','5181'),('IFC303','5182'),('IFC303','5188'),('IFC303','5191'),('IFC303','682t'),('IMS302','17349'),('IMS302','17351'),('IMS302','17353'),('IMS302','17371'),('IMS302','17375'),('IMS302','17377'),('IMS302','745t'),('IMS302','7929'),('IMS302','7930'),('IMS302','7933'),('IMS302','7935'),('IMS302','7940'),('IMS302','7941'),('IMS302','7942'),('IMS302','7945'),('IMS302','7946'),('IMS302','7948'),('IMS302','7950'),('IMS302','7951'),('IMS302','7952'),('IMS302','9333'),('moodle','fp'),('para','fp'),('profesorado','coordinacion'),('QUI301','122t'),('QUI301','17881'),('QUI301','17887'),('QUI301','17889'),('QUI301','17896'),('QUI301','17903'),('QUI301','17905'),('QUI301','17907'),('QUI301','17909'),('QUI301','5031'),('QUI301','5032'),('QUI301','5035'),('QUI301','5036'),('QUI301','5039'),('QUI301','5041'),('QUI301','5042'),('QUI301','5045'),('QUI301','5255'),('QUI301','5256'),('QUI301','5259'),('QUI301','5260'),('QUI301','5266'),('QUI301','5270'),('SAN202','17983'),('SAN202','17989'),('SAN202','17991'),('SAN202','18000'),('SAN202','18007'),('SAN202','18009'),('SAN202','18013'),('SAN202','18015'),('SAN202','18017'),('SAN202','4969'),('SAN202','4971'),('SAN202','4972'),('SAN202','4974'),('SAN202','4975'),('SAN202','5323'),('SAN202','5324'),('SAN202','5325'),('SAN202','5326'),('SAN202','5327'),('SAN202','5329'),('SAN202','5332'),('SAN202','630t'),('SAN203','18025'),('SAN203','18032'),('SAN203','18034'),('SAN203','18038'),('SAN203','18042'),('SAN203','18046'),('SAN203','18050'),('SAN203','18052'),('SAN203','18057'),('SAN203','4952'),('SAN203','4955'),('SAN203','4958'),('SAN203','4959'),('SAN203','4962'),('SAN203','4963'),('SAN203','5310'),('SAN203','5312'),('SAN203','5313'),('SAN203','5315'),('SAN203','5316'),('SAN203','5319'),('SAN203','5320'),('SAN203','618t'),('SEA301','12338'),('SEA301','12339'),('SEA301','12340'),('SEA301','12341'),('SEA301','12342'),('SEA301','12343'),('SEA301','12344'),('SEA301','12345'),('SEA301','12346'),('SEA301','12347'),('SEA301','12348'),('SEA301','12349'),('SEA301','12350'),('SEA301','12351'),('SEA301','12352'),('SEA301','12353'),('SEA301','18379'),('SEA301','18385'),('SEA301','18387'),('SEA301','18403'),('SEA301','18409'),('SEA301','757t'),('smr','aplicaciones'),('SSC201','18500'),('SSC201','18502'),('SSC201','18504'),('SSC201','18506'),('SSC201','18510'),('SSC201','18518'),('SSC201','18520'),('SSC201','18524'),('SSC201','18526'),('SSC201','18530'),('SSC201','5124'),('SSC201','5125'),('SSC201','5128'),('SSC201','5131'),('SSC201','5133'),('SSC201','5134'),('SSC201','5135'),('SSC201','5375'),('SSC201','5378'),('SSC201','5379'),('SSC201','5381'),('SSC201','5382'),('SSC201','5384'),('SSC201','687t'),('SSC302','140t'),('SSC302','18593'),('SSC302','18595'),('SSC302','18597'),('SSC302','18599'),('SSC302','18613'),('SSC302','18615'),('SSC302','18617'),('SSC302','18619'),('SSC302','5210'),('SSC302','5212'),('SSC302','5213'),('SSC302','5214'),('SSC302','5215'),('SSC302','5218'),('SSC302','5219'),('SSC302','5221'),('SSC302','5432'),('SSC302','5433'),('SSC302','5434'),('SSC302','5436'),('SSC302','5441'),('SSC302','5442'),('SSC302','5445'),('SSC303','18623'),('SSC303','18625'),('SSC303','18627'),('SSC303','18631'),('SSC303','18633'),('SSC303','18643'),('SSC303','18647'),('SSC303','18649'),('SSC303','18653'),('SSC303','768t'),('SSC303','7793'),('SSC303','7874'),('SSC303','7875'),('SSC303','7877'),('SSC303','7878'),('SSC303','7879'),('SSC303','7882'),('SSC303','7884'),('SSC303','7885'),('SSC303','7889'),('SSC303','7892'),('SSC303','7896'),('SSC303','7897'),('SSC303','7899'),('SSC303','7901'),('SSC303','7902'),('SSC303','8339');
/*!40000 ALTER TABLE `ciclo_modulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciclos`
--

DROP TABLE IF EXISTS `ciclos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ciclos` (
  `id_ciclo` varchar(50) NOT NULL,
  `nombre` varchar(256) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_ciclo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciclos`
--

LOCK TABLES `ciclos` WRITE;
/*!40000 ALTER TABLE `ciclos` DISABLE KEYS */;
INSERT INTO `ciclos` VALUES ('ADG201','Gestión Administrativa',NULL,NULL),('ADG301','Administración y Finanzas',NULL,NULL),('ADG302','Asistencia a la Dirección',NULL,NULL),('CESIFC01','Ciberseguridad en Entornos de las Tecnologías de la Información',NULL,NULL),('CESIFC02','Inteligencia Artificial y Big Data',NULL,NULL),('COM201','Actividades Comerciales',NULL,NULL),('COM301','Comercio Internacional',NULL,NULL),('COM302','Gestión de Ventas y Espacios Comerciales',NULL,NULL),('COM303','Transporte y Logística',NULL,NULL),('ELE202','Instalaciones Eléctricas y Automáticas',NULL,NULL),('ELE304','Sistemas de Telecomunicaciones e Informáticos',NULL,NULL),('HOT301','Agencias de Viajes y Gestión de Eventos',NULL,NULL),('IFC201','Sistemas Microinformáticos y Redes',NULL,NULL),('IFC301','Administración de Sistemas Informáticos en Red',NULL,NULL),('IFC302','Desarrollo de Aplicaciones Multiplataforma',NULL,NULL),('IFC303','Desarrollo de Aplicaciones WEB',NULL,NULL),('IMS302','Producción de Audiovisuales y Espectáculos',NULL,NULL),('moodle','Formación profesorado',NULL,NULL),('para','Formación profesorado',NULL,NULL),('profesorado','Formación profesorado',NULL,NULL),('QUI301','Laboratorio de Análisis y de Control de Calidad',NULL,NULL),('SAN202','Farmacia y Parafarmacia',NULL,NULL),('SAN203','Emergencias Sanitarias',NULL,NULL),('SEA301','Educación y Control Ambiental',NULL,NULL),('smr','Pruebas',NULL,NULL),('SSC201','Atención a Personas en situación de Dependencia',NULL,NULL),('SSC302','Educación Infantil (Formación Profesional)',NULL,NULL),('SSC303','Integración Social',NULL,NULL);
/*!40000 ALTER TABLE `ciclos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coordinadores`
--

DROP TABLE IF EXISTS `coordinadores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `coordinadores` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_centro` varchar(50) NOT NULL,
  `id_ciclo` varchar(50) NOT NULL,
  `dni` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `coordinadores_id_centro_foreign` (`id_centro`),
  KEY `coordinadores_id_ciclo_foreign` (`id_ciclo`),
  CONSTRAINT `coordinadores_id_centro_foreign` FOREIGN KEY (`id_centro`) REFERENCES `centros` (`id_centro`) ON DELETE CASCADE,
  CONSTRAINT `coordinadores_id_ciclo_foreign` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclos` (`id_ciclo`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coordinadores`
--

LOCK TABLES `coordinadores` WRITE;
/*!40000 ALTER TABLE `coordinadores` DISABLE KEYS */;
/*!40000 ALTER TABLE `coordinadores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `docente_modulo_ciclo`
--

DROP TABLE IF EXISTS `docente_modulo_ciclo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `docente_modulo_ciclo` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dni` varchar(255) NOT NULL,
  `id_ciclo` varchar(255) NOT NULL,
  `id_modulo` varchar(255) NOT NULL,
  `id_centro` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `docente_modulo_ciclo_dni_foreign` (`dni`),
  KEY `docente_modulo_ciclo_id_ciclo_foreign` (`id_ciclo`),
  KEY `docente_modulo_ciclo_id_modulo_foreign` (`id_modulo`),
  KEY `docente_modulo_ciclo_id_centro_foreign` (`id_centro`),
  CONSTRAINT `docente_modulo_ciclo_dni_foreign` FOREIGN KEY (`dni`) REFERENCES `docentes` (`dni`) ON DELETE CASCADE,
  CONSTRAINT `docente_modulo_ciclo_id_centro_foreign` FOREIGN KEY (`id_centro`) REFERENCES `centros` (`id_centro`) ON DELETE CASCADE,
  CONSTRAINT `docente_modulo_ciclo_id_ciclo_foreign` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclos` (`id_ciclo`) ON DELETE CASCADE,
  CONSTRAINT `docente_modulo_ciclo_id_modulo_foreign` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docente_modulo_ciclo`
--

LOCK TABLES `docente_modulo_ciclo` WRITE;
/*!40000 ALTER TABLE `docente_modulo_ciclo` DISABLE KEYS */;
/*!40000 ALTER TABLE `docente_modulo_ciclo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `docentes`
--

DROP TABLE IF EXISTS `docentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `docentes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `dni` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `docentes_dni_unique` (`dni`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docentes`
--

LOCK TABLES `docentes` WRITE;
/*!40000 ALTER TABLE `docentes` DISABLE KEYS */;
/*!40000 ALTER TABLE `docentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imparte`
--

DROP TABLE IF EXISTS `imparte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `imparte` (
  `dni` varchar(255) NOT NULL,
  `id_modulo` varchar(255) NOT NULL,
  `id_centro` varchar(50) NOT NULL,
  PRIMARY KEY (`dni`,`id_modulo`,`id_centro`),
  KEY `imparte_id_modulo_foreign` (`id_modulo`),
  KEY `imparte_id_centro_foreign` (`id_centro`),
  CONSTRAINT `imparte_id_centro_foreign` FOREIGN KEY (`id_centro`) REFERENCES `centros` (`id_centro`) ON DELETE CASCADE,
  CONSTRAINT `imparte_id_modulo_foreign` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id_modulo`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imparte`
--

LOCK TABLES `imparte` WRITE;
/*!40000 ALTER TABLE `imparte` DISABLE KEYS */;
/*!40000 ALTER TABLE `imparte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000001_create_cache_table',1),(2,'0001_01_01_000002_create_jobs_table',1),(3,'2025_04_03_000000_create_centros_table',1),(4,'2025_04_03_113222_create_usuario_table',1),(5,'2025_04_03_120513_create_sessions_table',1),(6,'2025_04_08_091904_create_docentes_table',1),(7,'2025_04_08_113746_create_ciclos_table',1),(8,'2025_04_08_114143_create_centro_ciclo_table',1),(9,'2025_04_08_114621_create_modulos_table',1),(10,'2025_04_08_114923_create_ciclo_modulo_table',1),(11,'2025_04_08_115239_create_coordinadores_table',1),(12,'2025_04_08_115516_create_tutores_table',1),(13,'2025_04_08_115537_create_imparte_table',1),(14,'2025_04_24_111417_create_centro_docente_table',1),(15,'2025_05_07_090750_create_docente_ciclo_modulo_table',1),(16,'2025_05_21_114858_create_admins_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modulos`
--

DROP TABLE IF EXISTS `modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `modulos` (
  `id_modulo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_modulo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modulos`
--

LOCK TABLES `modulos` WRITE;
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
INSERT INTO `modulos` VALUES ('122t','Coordinación - Tutoría',NULL,NULL),('12338','Gestión ambiental',NULL,NULL),('12339','Estructura y dinámica del medio ambiente',NULL,NULL),('12340','Formación y orientación laboral',NULL,NULL),('12341','Lengua extranjera profesional: inglés, 1',NULL,NULL),('12342','Medio natural',NULL,NULL),('12343','Métodos y productos cartográficos',NULL,NULL),('12344','Programas de educación ambiental',NULL,NULL),('12345','Actividades de uso público',NULL,NULL),('12346','Actividades humanas y problemática ambiental',NULL,NULL),('12347','Desenvolvimiento en el medio',NULL,NULL),('12348','Empresa e iniciativa emprendedora',NULL,NULL),('12349','Formación en centros de trabajo',NULL,NULL),('12350','Habilidades sociales',NULL,NULL),('12351','Lengua extranjera profesional: inglés, 2',NULL,NULL),('12352','Proyecto de educación y control ambiental',NULL,NULL),('12353','Técnicas de educación ambiental',NULL,NULL),('12359','Electrónica',NULL,NULL),('12360','Instalaciones solares fotovoltaicas',NULL,NULL),('13926','Gestión de proyectos de instalaciones de telecomunicaciones',NULL,NULL),('13927','Lengua Extranjera  profesional: Inglés 1',NULL,NULL),('13928','Sistemas informáticos y redes locales',NULL,NULL),('13929','Elementos de sistemas de telecomunicaciones',NULL,NULL),('13930','Sistemas de telefonía fija y móvil',NULL,NULL),('13931','Formación y orientación laboral',NULL,NULL),('13932','Configuración de infraestructuras de sistemas de telecomunicaciones',NULL,NULL),('13933','Técnicas y procesos en infraestructuras de telecomunicaciones',NULL,NULL),('13934','Empresa e iniciativa emprendedora',NULL,NULL),('13935','Sistemas de radiocomunicaciones',NULL,NULL),('13936','Sistemas de producción audiovisual (LOE)',NULL,NULL),('13937','Redes telemáticas',NULL,NULL),('13938','Lengua Extranjera profesional: Inglés 2',NULL,NULL),('13939','Formación en centros de trabajo',NULL,NULL),('13940','Sistemas integrados y hogar digital',NULL,NULL),('13941','Proyecto de Sistemas de Telecomunicaciones e Informáticos',NULL,NULL),('13942','Procesos de venta',NULL,NULL),('13943','Marketing en la actividad comercial',NULL,NULL),('13944','Inglés',NULL,NULL),('13945','Gestión de compras',NULL,NULL),('13946','AC - Formación y orientación laboral',NULL,NULL),('13947','Dinamización del punto de venta',NULL,NULL),('13948','Aplicaciones informáticas para el comercio',NULL,NULL),('13949','Venta técnica',NULL,NULL),('13950','Técnicas de almacén',NULL,NULL),('13951','Servicios de atención comercial',NULL,NULL),('13952','Gestión de un pequeño comercio',NULL,NULL),('13953','Formación en centros de trabajo',NULL,NULL),('13954','Comercio electrónico',NULL,NULL),('140t','Coordinación - Tutoría',NULL,NULL),('14339','Incidentes de ciberseguridad',NULL,NULL),('14340','Bastionado de redes y sistemas',NULL,NULL),('14341','Puesta en producción segura',NULL,NULL),('14342','Análisis forense informático',NULL,NULL),('14343','Hacking ético',NULL,NULL),('14344','Normativa de ciberseguridad.',NULL,NULL),('14345','Modelos de Inteligencia Artificial.',NULL,NULL),('14346','Sistemas de Big Data.',NULL,NULL),('14347','Big Data aplicado.',NULL,NULL),('14348','Sistemas de aprendizaje automático.',NULL,NULL),('14349','Programación de Inteligencia Artificial.',NULL,NULL),('14636','Digitalización aplicada a los sectores productivos (GM)',NULL,NULL),('14638','Empresa y Administración (LFP)',NULL,NULL),('14640','GA - Inglés profesional (GM)',NULL,NULL),('14642','GA - Itinerario personal para la empleabilidad I',NULL,NULL),('14655','Itinerario personal para la empleabilidad II',NULL,NULL),('14657','Módulo profesional optativo',NULL,NULL),('14663','Proyecto intermodular',NULL,NULL),('14665','Sostenibilidad aplicada al sistema productivo',NULL,NULL),('14675','AyF - Digitalización aplicada a los sectores productivos (GS)',NULL,NULL),('14679','AyF - Inglés profesional',NULL,NULL),('14681','AyF - Itinerario personal para la empleabilidad I',NULL,NULL),('14700','AyF - Itinerario personal para la empleabilidad II',NULL,NULL),('14702','AyF - Módulo profesional optativo',NULL,NULL),('14704','AyF - Proyecto intermodular de administración y finanzas',NULL,NULL),('14709','AyF - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('14713','AD - Digitalización aplicada a los sectores productivos (GS)',NULL,NULL),('14717','AD - Inglés profesional',NULL,NULL),('14719','AD - Itinerario personal para la empleabilidad I',NULL,NULL),('14730','AD - Itinerario personal para la empleabilidad II',NULL,NULL),('14732','AD - Módulo profesional optativo',NULL,NULL),('14739','AD - Proyecto intermodular de asistencia a la dirección',NULL,NULL),('14743','AD - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('15335','AC - Digitalización aplicada a los sectores productivos (GM)',NULL,NULL),('15342','AC - Inglés profesional (GM)',NULL,NULL),('15344','AC - Itinerario personal para la empleabilidad I',NULL,NULL),('15350','AC - Tutoría I',NULL,NULL),('15356','AC - Itinerario personal para la empleabilidad II',NULL,NULL),('15358','AC - Módulo profesional optativo',NULL,NULL),('15360','AC - Proyecto intermodular',NULL,NULL),('15365','AC - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('15369','AC - Tutoría II',NULL,NULL),('15373','CI - Digitalización aplicada a los sectores productivos (GS)',NULL,NULL),('15380','CI - Inglés profesional',NULL,NULL),('15382','CI - Itinerario personal para la empleabilidad I',NULL,NULL),('15392','CI - Itinerario personal para la empleabilidad II',NULL,NULL),('15399','CI - Módulo profesional optativo',NULL,NULL),('15403','CI - Proyecto intermodular de comercio internacional',NULL,NULL),('15407','CI - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('15409','GVEC - Digitalización aplicada a los sectores productivos (GS)',NULL,NULL),('15414','GVEC - Inglés profesional',NULL,NULL),('15416','Investigación comercial (LFP)',NULL,NULL),('15418','GVEC - Itinerario personal para la empleabilidad I',NULL,NULL),('15428','GVEC - Itinerario personal para la empleabilidad II',NULL,NULL),('15435','GVEC - Módulo profesional optativo',NULL,NULL),('15439','GVEC - Proyecto intermodular de Gestión de ventas y espacios comerciales',NULL,NULL),('15441','GVEC - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('15445','TL - Digitalización aplicada a los sectores productivos (GS)',NULL,NULL),('15452','TL - Inglés profesional',NULL,NULL),('15454','TL - Itinerario personal para la empleabilidad I',NULL,NULL),('15465','TL - Itinerario personal para la empleabilidad II',NULL,NULL),('15470','TL - Módulo profesional optativo',NULL,NULL),('15477','TL - Proyecto intermodular de transporte y logística',NULL,NULL),('15479','TL - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('15564','IEA - Digitalización aplicada a los sectores productivos (GM)',NULL,NULL),('15571','IEA - Inglés profesional (GM)',NULL,NULL),('15575','IEA - Itinerario personal para la empleabilidad I',NULL,NULL),('15577','IEA - Tutoría I',NULL,NULL),('15588','IEA - Itinerario personal para la empleabilidad II',NULL,NULL),('15592','IEA - Módulo profesional optativo',NULL,NULL),('15594','IEA - Proyecto intermodular',NULL,NULL),('15596','IEA - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('15598','IEA - Tutoría II',NULL,NULL),('15758','STI - Digitalización aplicada a los sectores productivos (GS)',NULL,NULL),('15764','STI - Inglés profesional',NULL,NULL),('15766','STI - Itinerario personal para la empleabilidad I',NULL,NULL),('15768','Sistemas de producción audiovisual (LFP)',NULL,NULL),('15774','STI - Itinerario personal para la empleabilidad II',NULL,NULL),('16462','AVGE - Digitalización aplicada a los sectores productivos (GS)',NULL,NULL),('16468','AVGE - Inglés profesional',NULL,NULL),('16470','AVGE - Itinerario personal para la empleabilidad I',NULL,NULL),('16472','Protocolo y relaciones públicas (LFP)',NULL,NULL),('16478','AVGE - Itinerario personal para la empleabilidad II',NULL,NULL),('16482','AVGE - Módulo profesional optativo',NULL,NULL),('16484','AVGE - Proyecto intermodular de agencias de viajes y gestión de eventos',NULL,NULL),('16488','AVGE - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('16693','SMR - Digitalización aplicada a los sectores productivos (GM)',NULL,NULL),('16695','SMR - Inglés profesional (GM)',NULL,NULL),('16697','SMR - Itinerario personal para la empleabilidad I',NULL,NULL),('16706','SMR - Tutoría I',NULL,NULL),('16711','SMR - Itinerario personal para la empleabilidad II',NULL,NULL),('16713','SMR - Módulo profesional optativo',NULL,NULL),('16715','SMR - Proyecto intermodular',NULL,NULL),('16724','SMR - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('16726','SMR - Tutoría II',NULL,NULL),('16728','ASIR - Digitalización aplicada a los sectores productivos (GS)',NULL,NULL),('16737','ASIR - Inglés profesional',NULL,NULL),('16739','ASIR - Itinerario personal para la empleabilidad I',NULL,NULL),('16752','ASIR - Itinerario personal para la empleabilidad II',NULL,NULL),('16754','ASIR - Módulo profesional optativo',NULL,NULL),('16756','ASIR - Proyecto intermodular de administración de sistemas informáticos en red',NULL,NULL),('16762','ASIR - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('16767','DAM - Digitalización aplicada a los sectores productivos (GS)',NULL,NULL),('16771','DAM - Inglés profesional',NULL,NULL),('16773','DAM - Itinerario personal para la empleabilidad I',NULL,NULL),('16787','DAM - Itinerario personal para la empleabilidad II',NULL,NULL),('16789','DAM - Módulo profesional optativo',NULL,NULL),('16796','DAM - Proyecto intermodular de desarrollo de aplicaciones multiplataforma',NULL,NULL),('16801','DAM - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('16805','DAW - Digitalización aplicada a los sectores productivos (GS)',NULL,NULL),('16809','DAW - Inglés profesional',NULL,NULL),('16811','DAW - Itinerario personal para la empleabilidad I',NULL,NULL),('16829','DAW - Itinerario personal para la empleabilidad II',NULL,NULL),('16831','DAW - Módulo profesional optativo',NULL,NULL),('16833','DAW - Proyecto intermodular de desarrollo de aplicaciones web',NULL,NULL),('16835','DAW - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('17349','PAE - Digitalización aplicada a los sectores productivos (GS)',NULL,NULL),('17351','PAE - Inglés profesional',NULL,NULL),('17353','PAE - Itinerario personal para la empleabilidad I',NULL,NULL),('17371','PAE - Itinerario personal para la empleabilidad II',NULL,NULL),('17375','PAE - Proyecto intermodular de producción de audiovisuales y espectáculos',NULL,NULL),('17377','PAE - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('17881','LACC - Digitalización aplicada a los sectores productivos (GS)',NULL,NULL),('17887','LACC - Inglés profesional',NULL,NULL),('17889','LACC - Itinerario personal para la empleabilidad I',NULL,NULL),('17896','Calidad y seguridad en el laboratorio Global (LFP)',NULL,NULL),('17903','LACC - Itinerario personal para la empleabilidad II',NULL,NULL),('17905','LACC - Módulo profesional optativo',NULL,NULL),('17907','LACC - Proyecto intermodular de laboratorio de análisis y de control de calidad',NULL,NULL),('17909','LACC - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('17983','FyP - Digitalización aplicada a los sectores productivos (GM)',NULL,NULL),('17989','FyP - Inglés profesional',NULL,NULL),('17991','FyP - Itinerario personal para la empleabilidad I',NULL,NULL),('18000','FyP - Tutoría I',NULL,NULL),('18007','FyP - Itinerario personal para la empleabilidad II',NULL,NULL),('18009','FyP - Módulo profesional optativo',NULL,NULL),('18013','FyP - Proyecto intermodular',NULL,NULL),('18015','FyP - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('18017','FyP - Tutoría II',NULL,NULL),('18025','ES - Digitalización aplicada a los sectores productivos (GM)',NULL,NULL),('18032','Inglés profesional',NULL,NULL),('18034','ES - Itinerario personal para la empleabilidad I',NULL,NULL),('18038','Tutoría I',NULL,NULL),('18042','Itinerario personal para la empleabilidad II',NULL,NULL),('18046','Módulo profesional optativo',NULL,NULL),('18050','Proyecto intermodular',NULL,NULL),('18052','Sostenibilidad aplicada al sistema productivo',NULL,NULL),('18057','Tutoría II',NULL,NULL),('18379','ECA - Digitalización aplicada a los sectores productivos (GS)',NULL,NULL),('18385','ECA - Inglés profesional',NULL,NULL),('18387','ECA - Itinerario personal para la empleabilidad I',NULL,NULL),('18403','ECA - Itinerario personal para la empleabilidad II',NULL,NULL),('18409','ECA - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('18500','Destrezas sociales (LFP)',NULL,NULL),('18502','APSD - Digitalización aplicada a los sectores productivos (GM)',NULL,NULL),('18504','APSD - Inglés profesional (GM)',NULL,NULL),('18506','APSD - Itinerario personal para la empleabilidad I',NULL,NULL),('18510','APSD - Tutoría I',NULL,NULL),('18518','APSD - Itinerario personal para la empleabilidad II',NULL,NULL),('18520','APSD - Módulo profesional optativo',NULL,NULL),('18524','APSD - Proyecto intermodular',NULL,NULL),('18526','APSD - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('18530','APSD - Tutoría II',NULL,NULL),('18593','EI -Digitalización aplicada a los sectores productivos (GS)',NULL,NULL),('18595','Habilidades sociales (LFP)',NULL,NULL),('18597','EI -Inglés profesional',NULL,NULL),('18599','EI - Itinerario personal para la empleabilidad I',NULL,NULL),('18613','EI -Itinerario personal para la empleabilidad II',NULL,NULL),('18615','EI -Módulo profesional optativo',NULL,NULL),('18617','EI - Proyecto intermodular de atención a la infancia',NULL,NULL),('18619','EI - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('18623','IS - Digitalización aplicada a los sectores productivos (GS)',NULL,NULL),('18625','Habilidades sociales (LFP)',NULL,NULL),('18627','IS - Inglés profesional',NULL,NULL),('18631','IS - Itinerario personal para la empleabilidad I',NULL,NULL),('18633','Metodología de la intervención social (LFP)',NULL,NULL),('18643','IS - Itinerario personal para la empleabilidad II',NULL,NULL),('18647','IS - Módulo profesional optativo',NULL,NULL),('18649','IS - Proyecto intermodular de integración social',NULL,NULL),('18653','IS - Sostenibilidad aplicada al sistema productivo',NULL,NULL),('4952','Logística sanitaria en emergencias',NULL,NULL),('4955','Atención sanitaria especial en situaciones de emergencia',NULL,NULL),('4958','Planes de emergencia y dispositivos de riesgos previsibles',NULL,NULL),('4959','Tele emergencia',NULL,NULL),('4962','Empresa e iniciativa emprendedora',NULL,NULL),('4963','Formación en centros de trabajo',NULL,NULL),('4969','Dispensación de productos parafarmacéuticos',NULL,NULL),('4971','Formulación magistral',NULL,NULL),('4972','Promoción de la salud',NULL,NULL),('4974','Empresa e iniciativa emprendedora',NULL,NULL),('4975','Formación en centros de trabajo',NULL,NULL),('4980','Instalaciones de distribución',NULL,NULL),('4981','Infraestructuras comunes de telecomunicaciones en viviendas y edificios',NULL,NULL),('4982','Instalaciones domóticas.',NULL,NULL),('4984','Máquinas eléctricas',NULL,NULL),('4986','Empresa e iniciativa emprendedora',NULL,NULL),('4987','Formación en centros de trabajo',NULL,NULL),('4991','Sistemas operativos en red',NULL,NULL),('4993','Seguridad informática',NULL,NULL),('4994','Servicios en red',NULL,NULL),('4995','Aplicaciones Web',NULL,NULL),('4997','SMR - Empresa e iniciativa emprendedora',NULL,NULL),('4998','Formación en centros de trabajo',NULL,NULL),('5001','SMR - Lengua extranjera profesional: inglés 2',NULL,NULL),('5031','Análisis instrumental',NULL,NULL),('5032','Ensayos físicos',NULL,NULL),('5035','Ensayos biotecnológicos',NULL,NULL),('5036','Calidad y seguridad en el laboratorio Global (LOE)',NULL,NULL),('5039','Proyecto de laboratorio de análisis y de control de calidad',NULL,NULL),('5041','Empresa e iniciativa emprendedora',NULL,NULL),('5042','Formación en centros de trabajo',NULL,NULL),('5045','Lengua Extranjera profesional: inglés 2',NULL,NULL),('5051','Administración de sistemas operativos.',NULL,NULL),('5052','Servicios de red e Internet.',NULL,NULL),('5053','Implantación de aplicaciones web.',NULL,NULL),('5054','Administración de sistemas gestores de bases de datos.',NULL,NULL),('5055','Seguridad y alta disponibilidad.',NULL,NULL),('5056','Proyecto de administración de sistemas informáticos en red.',NULL,NULL),('5058','ASIR - Empresa e iniciativa emprendedora',NULL,NULL),('5059','Formación en centros de trabajo',NULL,NULL),('5061','ASIR - Lengua extranjera profesional: inglés 2',NULL,NULL),('5066','DAM - Acceso a datos',NULL,NULL),('5068','Desarrollo de interfaces',NULL,NULL),('5069','Programación multimedia y dispositivos móviles',NULL,NULL),('5070','Programación de servicios y procesos',NULL,NULL),('5071','Sistemas de gestión empresarial',NULL,NULL),('5072','Proyecto de desarrollo de aplicaciones multiplataforma',NULL,NULL),('5074','DAM - Empresa e iniciativa emprendedora',NULL,NULL),('5075','Formación en centros de trabajo',NULL,NULL),('5077','DAM - Lengua Extranjera profesional: Inglés 2',NULL,NULL),('5083','DAW - Desarrollo web  en entorno cliente',NULL,NULL),('5084','DAW - Desarrollo web  en entorno servidor',NULL,NULL),('5085','DAW - Despliegue de aplicaciones web',NULL,NULL),('5086','DAW - Diseño de interfaces Web',NULL,NULL),('5087','Proyecto de desarrollo de aplicaciones Web',NULL,NULL),('5089','DAW - Empresa e iniciativa emprendedora',NULL,NULL),('5090','Formación en centros de trabajo',NULL,NULL),('5092','DAW - Lengua Extranjera profesional: Inglés 2',NULL,NULL),('5099','Gestión de recursos humanos',NULL,NULL),('5100','Gestión financiera',NULL,NULL),('5101','Contabilidad y fiscalidad',NULL,NULL),('5111','Inglés  Global',NULL,NULL),('5114','Empresa y Administración (LOE)',NULL,NULL),('5117','Operaciones administrativas de recursos humanos',NULL,NULL),('5118','Tratamiento de la documentación contable',NULL,NULL),('5119','Empresa en el aula',NULL,NULL),('5120','Operaciones auxiliares de gestión de tesorería',NULL,NULL),('5122','Formación en centros de trabajo',NULL,NULL),('5124','Organización de la atención a las personas en situación de dependencia',NULL,NULL),('5125','Destrezas sociales (LOE)',NULL,NULL),('5128','Apoyo a la comunicación',NULL,NULL),('5131','Atención higiénica',NULL,NULL),('5133','Empresa e iniciativa emprendedora',NULL,NULL),('5134','Formación en centros de trabajo',NULL,NULL),('5135','Teleasistencia',NULL,NULL),('5148','Gestión logística y comercial',NULL,NULL),('5149','Simulación empresarial',NULL,NULL),('5150','Proyecto de administración y finanzas',NULL,NULL),('5152','Formación en centros de trabajo',NULL,NULL),('5158','Sistema de información de mercados',NULL,NULL),('5159','Marketing internacional',NULL,NULL),('5160','Negociación internacional',NULL,NULL),('5161','Financiación internacional',NULL,NULL),('5162','Medios de pago internacionales',NULL,NULL),('5163','Comercio digital internacional',NULL,NULL),('5164','Proyecto de comercio internacional',NULL,NULL),('5166','CI - Formación en centros de trabajo',NULL,NULL),('5173','DAM - Formación y Orientación Laboral',NULL,NULL),('5176','DAM - Lengua Extranjera profesional: Inglés 1',NULL,NULL),('5178','DAW - Lenguajes de marcas y sistemas de gestión de información',NULL,NULL),('5179','DAW - Sistemas informáticos',NULL,NULL),('5180','DAW - Bases de datos',NULL,NULL),('5181','DAW - Programación',NULL,NULL),('5182','DAW - Entornos de desarrollo',NULL,NULL),('5188','DAW - Formación y orientación laboral',NULL,NULL),('5191','DAW - Lengua Extranjera profesional: Inglés 1',NULL,NULL),('5193','Inglés',NULL,NULL),('5194','Gestión de la documentación jurídica y empresarial',NULL,NULL),('5195','Gestión administrativa del transporte y la logística',NULL,NULL),('5198','Comercialización del transporte y la logística',NULL,NULL),('5200','Logística de aprovisionamiento',NULL,NULL),('5202','Organización del transporte de viajeros',NULL,NULL),('5203','Organización del transporte de mercancías',NULL,NULL),('5204','Proyecto de transporte y logística',NULL,NULL),('5206','Formación en centros de trabajo',NULL,NULL),('5210','Expresión y comunicación.',NULL,NULL),('5212','Desarrollo socioafectivo.',NULL,NULL),('5213','Habilidades sociales (LOE)',NULL,NULL),('5214','Intervención con familias y atención a menores en riesgo social.',NULL,NULL),('5215','Proyecto de atención a la infancia.',NULL,NULL),('5218','Empresa e iniciativa emprendedora.',NULL,NULL),('5219','Formación en centros de trabajo',NULL,NULL),('5221','Lengua extranjera profesional: inglés 2',NULL,NULL),('5223','Protocolo y relaciones públicas (LOE)',NULL,NULL),('5224','Marketing turístico',NULL,NULL),('5225','Inglés  Global',NULL,NULL),('5228','Segunda lengua extranjera: Francés Global',NULL,NULL),('5234','Empresa e iniciativa emprendedora',NULL,NULL),('5235','Formación en centros de trabajo',NULL,NULL),('5236','Gestión de productos turísticos',NULL,NULL),('5237','Venta de servicios turísticos',NULL,NULL),('5239','Proyecto de agencias de viajes y gestión de eventos',NULL,NULL),('5255','Muestreo y preparación de la muestra',NULL,NULL),('5256','Análisis químicos',NULL,NULL),('5259','Ensayos fisicoquímicos',NULL,NULL),('5260','Ensayos microbiológicos',NULL,NULL),('5266','Formación y orientación laboral',NULL,NULL),('5270','Lengua Extranjera profesional: inglés 1',NULL,NULL),('5272','Implantación de sistemas operativos.',NULL,NULL),('5273','Planificación y administración de redes.',NULL,NULL),('5274','Fundamentos de hardware.',NULL,NULL),('5275','Gestión de bases de datos.',NULL,NULL),('5276','Lenguajes de marcas y sistemas de gestión de información.',NULL,NULL),('5283','ASIR - Formación y orientación laboral',NULL,NULL),('5286','ASIR - Lengua extranjera profesional: inglés 1',NULL,NULL),('5288','DAM - Lenguajes de marcas y sistemas de gestión de información',NULL,NULL),('5289','Sistemas informáticos',NULL,NULL),('5290','DAM - Bases de datos',NULL,NULL),('5291','DAM - Programación',NULL,NULL),('5293','DAM - Entornos de desarrollo',NULL,NULL),('5294','Recursos humanos y responsabilidad social corporativa',NULL,NULL),('5295','Ofimática y proceso de la información',NULL,NULL),('5296','Proceso integral de la actividad comercial',NULL,NULL),('5297','Comunicación y atención al cliente',NULL,NULL),('5310','Mantenimiento mecánico preventivo del vehículo',NULL,NULL),('5312','Dotación sanitaria',NULL,NULL),('5313','Atención sanitaria inicial en situaciones de emergencia',NULL,NULL),('5315','Evacuación y traslado de pacientes',NULL,NULL),('5316','Apoyo psicológico en situaciones de emergencia',NULL,NULL),('5319','Anatomofisiología y patología básicas',NULL,NULL),('5320','Formación y orientación laboral',NULL,NULL),('5323','Primeros auxilios',NULL,NULL),('5324','Anatomofisiología  y Patología básicas',NULL,NULL),('5325','Disposición y venta de productos',NULL,NULL),('5326','Oficina de Farmacia',NULL,NULL),('5327','Dispensación de productos farmacéuticos',NULL,NULL),('5329','Operaciones básicas de laboratorio',NULL,NULL),('5332','Formación y orientación laboral',NULL,NULL),('5335','Automatismos industriales',NULL,NULL),('5337','Electrotecnia',NULL,NULL),('5338','Instalaciones eléctricas interiores.',NULL,NULL),('5344','Formación y orientación laboral',NULL,NULL),('5347','Montaje y mantenimiento de equipos',NULL,NULL),('5348','Sistemas operativos monopuesto',NULL,NULL),('5349','Aplicaciones ofimáticas',NULL,NULL),('5351','Redes locales',NULL,NULL),('5355','SMR - Formación y orientación laboral',NULL,NULL),('5359','SMR - Lengua extranjera profesional: inglés 1',NULL,NULL),('5364','Comunicación empresarial y atención al cliente',NULL,NULL),('5365','Operaciones administrativas de compra',NULL,NULL),('5367','Tratamiento informático de la información',NULL,NULL),('5368','Técnica contable',NULL,NULL),('5373','Formación y orientación laboral',NULL,NULL),('5375','Primeros auxilios',NULL,NULL),('5378','Características y necesidades de las personas en situación de dependencia',NULL,NULL),('5379','Atención y apoyo psicosocial',NULL,NULL),('5381','Apoyo domiciliario',NULL,NULL),('5382','Atención sanitaria',NULL,NULL),('5384','Formación y orientación laboral',NULL,NULL),('5403','Formación y Orientación Laboral',NULL,NULL),('5405','Inglés',NULL,NULL),('5406','Transporte internacional de mercancías',NULL,NULL),('5407','CI - Gestión económica y financiera de la empresa',NULL,NULL),('5408','Logística de almacenamiento',NULL,NULL),('5409','Gestión administrativa del comercio internacional',NULL,NULL),('5417','Formación y Orientación Laboral',NULL,NULL),('5419','Inglés',NULL,NULL),('5421','Transporte internacional de mercancías',NULL,NULL),('5422','Gestión económica y financiera de la empresa de transporte y logística',NULL,NULL),('5424','Logística de almacenamiento',NULL,NULL),('5426','Gestión administrativa del comercio internacional',NULL,NULL),('5430','TL - Formación y orientación laboral',NULL,NULL),('5432','Didáctica de la Educación Infantil.',NULL,NULL),('5433','Autonomía personal y salud infantil.',NULL,NULL),('5434','El juego infantil y su metodología.',NULL,NULL),('5436','Desarrollo cognitivo y motor.',NULL,NULL),('5441','Primeros auxilios.',NULL,NULL),('5442','Formación y orientación laboral.',NULL,NULL),('5445','Lengua extranjera profesional: inglés 1',NULL,NULL),('5447','Estructura del mercado turístico',NULL,NULL),('5456','Destinos turísticos',NULL,NULL),('5457','Recursos turísticos',NULL,NULL),('5458','Formación y orientación laboral',NULL,NULL),('5463','Dirección de entidades de intermediación turística',NULL,NULL),('618t','Coordinación - Tutoría',NULL,NULL),('624t','Coordinación - Tutoría',NULL,NULL),('627t','Coordinación - Tutoría',NULL,NULL),('630t','Coordinación - Tutoría',NULL,NULL),('639t','Coordinación - Tutoría',NULL,NULL),('643t','Coordinación - Tutoría',NULL,NULL),('645t','Coordinación - Tutoría',NULL,NULL),('681t','Coordinación - Tutoría',NULL,NULL),('682t','Coordinación - Tutoría',NULL,NULL),('687t','Coordinación - Tutoría',NULL,NULL),('700t','Coordinación  - Tutoría',NULL,NULL),('738t','Coordinación_GVEC - Tutoría',NULL,NULL),('745t','Coordinación - Tutoría',NULL,NULL),('750t','Coordinación - Tutoría',NULL,NULL),('757t','Coordinación - Tutoría',NULL,NULL),('768t','Coordinación - Tutoría',NULL,NULL),('7793','Formación y orientación laboral ERRÓNEO',NULL,NULL),('7851','Gestión de la documentación jurídica y empresarial',NULL,NULL),('7852','Recursos humanos y responsabilidad social corporativa',NULL,NULL),('7853','Ofimática y proceso de la información',NULL,NULL),('7854','Proceso integral de la actividad comercial',NULL,NULL),('7855','Comunicación y atención al cliente',NULL,NULL),('7861','Formación en centros de trabajo',NULL,NULL),('7862','Inglés',NULL,NULL),('7863','Segunda lengua extranjera: Francés',NULL,NULL),('7869','Protocolo empresarial',NULL,NULL),('7870','Organización de eventos empresariales',NULL,NULL),('7871','Gestión avanzada de la información',NULL,NULL),('7872','Proyecto de asistencia a la dirección',NULL,NULL),('7874','Contexto de la intervención social',NULL,NULL),('7875','Inserción sociolaboral',NULL,NULL),('7877','Mediación comunitaria',NULL,NULL),('7878','Apoyo a la intervención educativa',NULL,NULL),('7879','Promoción de la autonomía personal',NULL,NULL),('7882','Primeros auxilios',NULL,NULL),('7884','Lengua extranjera profesional: Inglés 1',NULL,NULL),('7885','Lengua extranjera profesional: Inglés 2',NULL,NULL),('7889','Formación en centros de trabajo',NULL,NULL),('7892','Atención a las unidades de convivencia',NULL,NULL),('7896','Sistemas aumentativos y alternativos de comunicación',NULL,NULL),('7897','Metodología de la intervención social (LOE)',NULL,NULL),('7899','Habilidades sociales (LOE)',NULL,NULL),('7901','Proyecto de integración social',NULL,NULL),('7902','Empresa e iniciativa emprendedora',NULL,NULL),('7907','Políticas de marketing',NULL,NULL),('7908','Marketing digital',NULL,NULL),('7909','GVEC - Gestión económica y financiera de la empresa',NULL,NULL),('7910','Logística de almacenamiento',NULL,NULL),('7913','Inglés',NULL,NULL),('7916','Formación en centros de trabajo',NULL,NULL),('7917','Escaparatismo y diseño de espacios comerciales',NULL,NULL),('7918','Gestión de productos y promociones en el punto de venta',NULL,NULL),('7919','Organización de equipos de ventas',NULL,NULL),('7920','Técnicas de venta y negociación',NULL,NULL),('7925','Logística de aprovisionamiento',NULL,NULL),('7926','Investigación comercial (LOE)',NULL,NULL),('7928','Proyecto de gestión de ventas y espacios comerciales',NULL,NULL),('7929','Medios técnicos audiovisuales y escénicos',NULL,NULL),('7930','Planificación de proyectos audiovisuales',NULL,NULL),('7933','Planificación de proyectos de espectáculos y eventos',NULL,NULL),('7935','Recursos expresivos audiovisuales y escénicos',NULL,NULL),('7940','Formación en centros de trabajo',NULL,NULL),('7941','Lengua extranjera profesional: Inglés 1',NULL,NULL),('7942','Lengua extranjera profesional: Inglés 2',NULL,NULL),('7945','Gestión de proyectos de cine, video y multimedia',NULL,NULL),('7946','Gestión de proyectos de televisión y radio',NULL,NULL),('7948','Gestión de proyectos de espectáculos y eventos',NULL,NULL),('7950','Administración y promoción de audiovisuales y espectáculos',NULL,NULL),('7951','Proyecto de producción de audiovisuales y espectáculos',NULL,NULL),('7952','PAE - Empresa e iniciativa emprendedora',NULL,NULL),('79t','Coordinación - Tutoría',NULL,NULL),('8339','Formación y orientación laboral',NULL,NULL),('83t','Coordinación_CI - Tutoría',NULL,NULL),('8412','GVEC - Formación y orientación laboral',NULL,NULL),('8491','Formación y orientación laboral',NULL,NULL),('85t','Coordinación - Tutoría',NULL,NULL),('866t','Coordinación - Tutoría',NULL,NULL),('873t','Coordinación - Tutoría',NULL,NULL),('9333','PAE - Formación y orientación laboral',NULL,NULL),('97t','Coordinación  - Tutoría',NULL,NULL),('aplicaciones','Muestra - SMR - Aplicaciones web',NULL,NULL),('cidead','Digitalización aplicada a los sectores productivos CIDEAD GM',NULL,NULL),('coordinacion','Formación metodológica para profesorado y coordinador/a. FP virtual y semipresencial',NULL,NULL),('fp','Actualización de Moodle 4 para la FP a distancia',NULL,NULL);
/*!40000 ALTER TABLE `modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tutores`
--

DROP TABLE IF EXISTS `tutores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tutores` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_centro` varchar(50) NOT NULL,
  `id_ciclo` varchar(50) NOT NULL,
  `dni` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tutores_id_centro_foreign` (`id_centro`),
  KEY `tutores_id_ciclo_foreign` (`id_ciclo`),
  CONSTRAINT `tutores_id_centro_foreign` FOREIGN KEY (`id_centro`) REFERENCES `centros` (`id_centro`) ON DELETE CASCADE,
  CONSTRAINT `tutores_id_ciclo_foreign` FOREIGN KEY (`id_ciclo`) REFERENCES `ciclos` (`id_ciclo`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tutores`
--

LOCK TABLES `tutores` WRITE;
/*!40000 ALTER TABLE `tutores` DISABLE KEYS */;
/*!40000 ALTER TABLE `tutores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_centro` varchar(50) DEFAULT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario_email_unique` (`email`),
  KEY `usuario_id_centro_foreign` (`id_centro`),
  CONSTRAINT `usuario_id_centro_foreign` FOREIGN KEY (`id_centro`) REFERENCES `centros` (`id_centro`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'22002521','Admin','admin@gmail.com','$2y$12$HWOUKqGJVa3ZBC.DKQf8GOZwQQxb7o0zqtTx1cutHYC4f/h7T93y.',NULL,NULL,NULL),(2,'50020125','Jefe Estudios','jefeestudios@gmail.com','$2y$12$Eev3./tIgYHwgOiXiyGp/eesT0Ks/2T1PyLUdHEJJOfqPuMz3GS1m',NULL,NULL,NULL);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-06-02 11:38:41
