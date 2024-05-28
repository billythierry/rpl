/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.28-MariaDB : Database - rpl
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`rpl` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `rpl`;

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id_admin` char(20) NOT NULL,
  `id_pembeli` char(20) DEFAULT NULL,
  `nama_admin` varchar(20) DEFAULT NULL,
  `no_tlp_admin` decimal(15,0) DEFAULT NULL,
  PRIMARY KEY (`id_admin`),
  KEY `FK_id_pembeli` (`id_pembeli`),
  CONSTRAINT `FK_id_pembeli` FOREIGN KEY (`id_pembeli`) REFERENCES `pembeli` (`Id_pembeli`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `admin` */

insert  into `admin`(`id_admin`,`id_pembeli`,`nama_admin`,`no_tlp_admin`) values 
('A101','P101','Habib',85678933456),
('A102','P102','Ade',85623455678),
('A103','P103','Cinta',85678912345),
('A104','P104','Adhen',87645329845),
('A105','P105','Manda',86545789823);

/*Table structure for table `komentar` */

DROP TABLE IF EXISTS `komentar`;

CREATE TABLE `komentar` (
  `id_komentar` char(20) NOT NULL,
  `id_pembeli` char(20) DEFAULT NULL,
  `text_komentar` varchar(50) DEFAULT NULL,
  `tgl_komentar` datetime DEFAULT NULL,
  `rating` float DEFAULT NULL,
  PRIMARY KEY (`id_komentar`),
  KEY `id_pembeli` (`id_pembeli`),
  CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`id_pembeli`) REFERENCES `pembeli` (`Id_pembeli`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `komentar` */

/*Table structure for table `kurir` */

DROP TABLE IF EXISTS `kurir`;

CREATE TABLE `kurir` (
  `id_kurir` char(20) NOT NULL,
  `id_admin` char(20) DEFAULT NULL,
  `nama_kurir` varchar(20) DEFAULT NULL,
  `no_tlp_kurir` decimal(15,0) DEFAULT NULL,
  PRIMARY KEY (`id_kurir`),
  KEY `Id_Admin` (`id_admin`),
  CONSTRAINT `Id_Admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `kurir` */

insert  into `kurir`(`id_kurir`,`id_admin`,`nama_kurir`,`no_tlp_kurir`) values 
('K101','A105','Surya',86734214289),
('K102','A104','Alex',85439872576),
('K103','A103','Yossi',52347845679),
('K104','A102','Denny',84567239865),
('K105','A101','Yoga',87634529856);

/*Table structure for table `pembeli` */

DROP TABLE IF EXISTS `pembeli`;

CREATE TABLE `pembeli` (
  `Id_pembeli` char(20) NOT NULL,
  `nama_pembeli` varchar(20) DEFAULT NULL,
  `alamat_pembeli` varchar(50) DEFAULT NULL,
  `no_tlp_pembeli` decimal(15,0) DEFAULT NULL,
  PRIMARY KEY (`Id_pembeli`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `pembeli` */

insert  into `pembeli`(`Id_pembeli`,`nama_pembeli`,`alamat_pembeli`,`no_tlp_pembeli`) values 
('P101','Fajar','Wiyung',85852622143),
('P102','Rhimba','Sidoarjo',85857672143),
('P103','Billy','Gunung Anyar',82135674591),
('P104','Narendra','Rungkut Asri',82145463862),
('P105','Bagas','Kenjeran',85238914567);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
