/*
SQLyog Community Edition- MySQL GUI v6.55
MySQL - 5.5.5-10.1.36-MariaDB : Database - selectjob
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`selectjob` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `selectjob`;

/*Table structure for table `categorie_offre` */

DROP TABLE IF EXISTS `categorie_offre`;

CREATE TABLE `categorie_offre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `categorie_offre` */

LOCK TABLES `categorie_offre` WRITE;

insert  into `categorie_offre`(`id`,`libelle`) values (1,'emploi'),(2,'stage');

UNLOCK TABLES;

/*Table structure for table `competence` */

DROP TABLE IF EXISTS `competence`;

CREATE TABLE `competence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `competence` */

LOCK TABLES `competence` WRITE;

insert  into `competence`(`id`,`libelle`) values (1,'developpement web'),(2,'web design'),(3,'tire d\'arme'),(4,'arnaquage'),(5,'voleur');

UNLOCK TABLES;

/*Table structure for table `competence_offre` */

DROP TABLE IF EXISTS `competence_offre`;

CREATE TABLE `competence_offre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `offre_id` int(11) NOT NULL,
  `competence_id` int(11) NOT NULL,
  `niveau_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_25A4D7894CC8505A` (`offre_id`),
  KEY `IDX_25A4D78915761DAB` (`competence_id`),
  KEY `IDX_25A4D789B3E9C81` (`niveau_id`),
  CONSTRAINT `FK_25A4D78915761DAB` FOREIGN KEY (`competence_id`) REFERENCES `competence` (`id`),
  CONSTRAINT `FK_25A4D7894CC8505A` FOREIGN KEY (`offre_id`) REFERENCES `offre` (`id`),
  CONSTRAINT `FK_25A4D789B3E9C81` FOREIGN KEY (`niveau_id`) REFERENCES `niveau` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `competence_offre` */

LOCK TABLES `competence_offre` WRITE;

UNLOCK TABLES;

/*Table structure for table `discussion` */

DROP TABLE IF EXISTS `discussion`;

CREATE TABLE `discussion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expediteur_id` int(11) NOT NULL,
  `destinataire_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_C0B9F90F537A1329` (`message_id`),
  KEY `IDX_C0B9F90F10335F61` (`expediteur_id`),
  KEY `IDX_C0B9F90FA4F84F6E` (`destinataire_id`),
  CONSTRAINT `FK_C0B9F90F10335F61` FOREIGN KEY (`expediteur_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_C0B9F90F537A1329` FOREIGN KEY (`message_id`) REFERENCES `message` (`id`),
  CONSTRAINT `FK_C0B9F90FA4F84F6E` FOREIGN KEY (`destinataire_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `discussion` */

LOCK TABLES `discussion` WRITE;

UNLOCK TABLES;

/*Table structure for table `entreprise` */

DROP TABLE IF EXISTS `entreprise`;

CREATE TABLE `entreprise` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `secteur_id` int(11) DEFAULT NULL,
  `localisation_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D19FA60A76ED395` (`user_id`),
  KEY `IDX_D19FA609F7E4405` (`secteur_id`),
  KEY `IDX_D19FA60C68BE09C` (`localisation_id`),
  CONSTRAINT `FK_D19FA609F7E4405` FOREIGN KEY (`secteur_id`) REFERENCES `secteur` (`id`),
  CONSTRAINT `FK_D19FA60A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_D19FA60C68BE09C` FOREIGN KEY (`localisation_id`) REFERENCES `localisation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `entreprise` */

LOCK TABLES `entreprise` WRITE;

insert  into `entreprise`(`id`,`secteur_id`,`localisation_id`,`user_id`,`nom`,`created_at`,`modified_at`) values (1,3,2,1,'test','0000-00-00 00:00:00','0000-00-00 00:00:00'),(2,1,1,2,'test','2019-06-27 11:25:10','2019-06-27 11:25:10');

UNLOCK TABLES;

/*Table structure for table `experience` */

DROP TABLE IF EXISTS `experience`;

CREATE TABLE `experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `experience` */

LOCK TABLES `experience` WRITE;

insert  into `experience`(`id`,`description`) values (1,'a fait participer au developpement de GOZEM'),(2,'a travailler chez IPNET Expert'),(3,'a travailler chez IPNET Expert');

UNLOCK TABLES;

/*Table structure for table `formation` */

DROP TABLE IF EXISTS `formation`;

CREATE TABLE `formation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lieu_id` int(11) NOT NULL,
  `auteur_id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `frais_inscription` double NOT NULL,
  `frais_formation` double NOT NULL,
  `fin_demande` datetime DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_404021BF6AB213CC` (`lieu_id`),
  KEY `IDX_404021BF60BB6FE6` (`auteur_id`),
  CONSTRAINT `FK_404021BF60BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `entreprise` (`id`),
  CONSTRAINT `FK_404021BF6AB213CC` FOREIGN KEY (`lieu_id`) REFERENCES `localisation` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `formation` */

LOCK TABLES `formation` WRITE;

insert  into `formation`(`id`,`lieu_id`,`auteur_id`,`titre`,`frais_inscription`,`frais_formation`,`fin_demande`,`email`,`telephone`,`description`) values (1,1,1,'vacances utiles',5000,25000,'2019-06-22 00:00:00','sam@gmail.com','2222222222','une formation de trois jours pour debutants en elctronique et robotique');

UNLOCK TABLES;

/*Table structure for table `formation_particulier` */

DROP TABLE IF EXISTS `formation_particulier`;

CREATE TABLE `formation_particulier` (
  `formation_id` int(11) NOT NULL,
  `particulier_id` int(11) NOT NULL,
  PRIMARY KEY (`formation_id`,`particulier_id`),
  KEY `IDX_3339F4285200282E` (`formation_id`),
  KEY `IDX_3339F428A89E0E67` (`particulier_id`),
  CONSTRAINT `FK_3339F4285200282E` FOREIGN KEY (`formation_id`) REFERENCES `formation` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_3339F428A89E0E67` FOREIGN KEY (`particulier_id`) REFERENCES `particulier` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `formation_particulier` */

LOCK TABLES `formation_particulier` WRITE;

UNLOCK TABLES;

/*Table structure for table `formation_prerequis` */

DROP TABLE IF EXISTS `formation_prerequis`;

CREATE TABLE `formation_prerequis` (
  `formation_id` int(11) NOT NULL,
  `prerequis_id` int(11) NOT NULL,
  PRIMARY KEY (`formation_id`,`prerequis_id`),
  KEY `IDX_9EBBD45200282E` (`formation_id`),
  KEY `IDX_9EBBD4ED196790` (`prerequis_id`),
  CONSTRAINT `FK_9EBBD45200282E` FOREIGN KEY (`formation_id`) REFERENCES `formation` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_9EBBD4ED196790` FOREIGN KEY (`prerequis_id`) REFERENCES `prerequis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `formation_prerequis` */

LOCK TABLES `formation_prerequis` WRITE;

UNLOCK TABLES;

/*Table structure for table `langue_parle` */

DROP TABLE IF EXISTS `langue_parle`;

CREATE TABLE `langue_parle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `langue_parle` */

LOCK TABLES `langue_parle` WRITE;

insert  into `langue_parle`(`id`,`libelle`) values (1,'francais'),(2,'anglais'),(3,'kabye'),(4,'ewe'),(5,'espagnol');

UNLOCK TABLES;

/*Table structure for table `localisation` */

DROP TABLE IF EXISTS `localisation`;

CREATE TABLE `localisation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `localisation` */

LOCK TABLES `localisation` WRITE;

insert  into `localisation`(`id`,`ville`,`description`) values (1,'lome','palais des congres'),(2,'kara','maison des jeunes');

UNLOCK TABLES;

/*Table structure for table `message` */

DROP TABLE IF EXISTS `message`;

CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contenu` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `message` */

LOCK TABLES `message` WRITE;

UNLOCK TABLES;

/*Table structure for table `migration_versions` */

DROP TABLE IF EXISTS `migration_versions`;

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migration_versions` */

LOCK TABLES `migration_versions` WRITE;

insert  into `migration_versions`(`version`,`executed_at`) values ('20190619223900','2019-06-19 22:39:08'),('20190619230642','2019-06-19 23:06:53'),('20190620074239','2019-06-20 07:43:12'),('20190620074456','2019-06-20 07:45:02'),('20190620123038','2019-06-20 12:31:20'),('20190620125236','2019-06-20 12:52:44'),('20190620130404','2019-06-20 13:04:20'),('20190620170529','2019-06-20 17:06:18'),('20190620190204','2019-06-20 19:02:18'),('20190620213438','2019-06-20 21:35:18'),('20190620214524','2019-06-20 21:45:30'),('20190621065728','2019-06-21 06:57:35'),('20190621072939','2019-06-21 07:29:54'),('20190622213618','2019-06-22 21:36:42'),('20190623151409','2019-06-23 15:14:55'),('20190625093345','2019-06-25 09:34:12'),('20190626150438','2019-06-26 15:04:51'),('20190626175211','2019-06-26 17:52:17');

UNLOCK TABLES;

/*Table structure for table `niveau` */

DROP TABLE IF EXISTS `niveau`;

CREATE TABLE `niveau` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `niveau` */

LOCK TABLES `niveau` WRITE;

insert  into `niveau`(`id`,`libelle`) values (1,'Débutant'),(2,'Amateur'),(3,'Professionnel');

UNLOCK TABLES;

/*Table structure for table `offre` */

DROP TABLE IF EXISTS `offre`;

CREATE TABLE `offre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categorie_id` int(11) DEFAULT NULL,
  `auteur_id` int(11) NOT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nb_experience` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `remuneration` double DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `fin_demande` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AF86866FBCF5E72D` (`categorie_id`),
  KEY `IDX_AF86866F60BB6FE6` (`auteur_id`),
  CONSTRAINT `FK_AF86866F60BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `entreprise` (`id`),
  CONSTRAINT `FK_AF86866FBCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie_offre` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `offre` */

LOCK TABLES `offre` WRITE;

insert  into `offre`(`id`,`categorie_id`,`auteur_id`,`titre`,`nb_experience`,`email`,`telephone`,`description`,`remuneration`,`duree`,`fin_demande`) values (1,2,1,'test',NULL,'entreprise@gmail.com','22112211','stages de vancance en maintenance reseaux',100000,2,'2019-08-08 00:00:00');

UNLOCK TABLES;

/*Table structure for table `offre_particulier` */

DROP TABLE IF EXISTS `offre_particulier`;

CREATE TABLE `offre_particulier` (
  `offre_id` int(11) NOT NULL,
  `particulier_id` int(11) NOT NULL,
  PRIMARY KEY (`offre_id`,`particulier_id`),
  KEY `IDX_27ED5ED34CC8505A` (`offre_id`),
  KEY `IDX_27ED5ED3A89E0E67` (`particulier_id`),
  CONSTRAINT `FK_27ED5ED34CC8505A` FOREIGN KEY (`offre_id`) REFERENCES `offre` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_27ED5ED3A89E0E67` FOREIGN KEY (`particulier_id`) REFERENCES `particulier` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `offre_particulier` */

LOCK TABLES `offre_particulier` WRITE;

UNLOCK TABLES;

/*Table structure for table `particulier` */

DROP TABLE IF EXISTS `particulier`;

CREATE TABLE `particulier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `profession_id` int(11) DEFAULT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sexe` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6CC4D4F3A76ED395` (`user_id`),
  KEY `IDX_6CC4D4F3FDEF8996` (`profession_id`),
  CONSTRAINT `FK_6CC4D4F3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_6CC4D4F3FDEF8996` FOREIGN KEY (`profession_id`) REFERENCES `profession` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `particulier` */

LOCK TABLES `particulier` WRITE;

insert  into `particulier`(`id`,`user_id`,`profession_id`,`nom`,`prenom`,`telephone`,`sexe`) values (1,4,1,'samtou','samtou','90989887','M');

UNLOCK TABLES;

/*Table structure for table `particulier_experience` */

DROP TABLE IF EXISTS `particulier_experience`;

CREATE TABLE `particulier_experience` (
  `particulier_id` int(11) NOT NULL,
  `experience_id` int(11) NOT NULL,
  PRIMARY KEY (`particulier_id`,`experience_id`),
  KEY `IDX_426FF895A89E0E67` (`particulier_id`),
  KEY `IDX_426FF89546E90E27` (`experience_id`),
  CONSTRAINT `FK_426FF89546E90E27` FOREIGN KEY (`experience_id`) REFERENCES `experience` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_426FF895A89E0E67` FOREIGN KEY (`particulier_id`) REFERENCES `particulier` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `particulier_experience` */

LOCK TABLES `particulier_experience` WRITE;

insert  into `particulier_experience`(`particulier_id`,`experience_id`) values (1,1),(1,3);

UNLOCK TABLES;

/*Table structure for table `particulier_langue_parle` */

DROP TABLE IF EXISTS `particulier_langue_parle`;

CREATE TABLE `particulier_langue_parle` (
  `particulier_id` int(11) NOT NULL,
  `langue_parle_id` int(11) NOT NULL,
  PRIMARY KEY (`particulier_id`,`langue_parle_id`),
  KEY `IDX_51AEAFA4A89E0E67` (`particulier_id`),
  KEY `IDX_51AEAFA4720496A0` (`langue_parle_id`),
  CONSTRAINT `FK_51AEAFA4720496A0` FOREIGN KEY (`langue_parle_id`) REFERENCES `langue_parle` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_51AEAFA4A89E0E67` FOREIGN KEY (`particulier_id`) REFERENCES `particulier` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `particulier_langue_parle` */

LOCK TABLES `particulier_langue_parle` WRITE;

insert  into `particulier_langue_parle`(`particulier_id`,`langue_parle_id`) values (1,1),(1,2),(1,3),(1,4),(1,5);

UNLOCK TABLES;

/*Table structure for table `prerequis` */

DROP TABLE IF EXISTS `prerequis`;

CREATE TABLE `prerequis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `prerequis` */

LOCK TABLES `prerequis` WRITE;

insert  into `prerequis`(`id`,`description`) values (1,'avoir une machine'),(6,'avoir des notions mathématiques');

UNLOCK TABLES;

/*Table structure for table `profession` */

DROP TABLE IF EXISTS `profession`;

CREATE TABLE `profession` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `profession` */

LOCK TABLES `profession` WRITE;

insert  into `profession`(`id`,`libelle`,`description`) values (1,'etudiant',NULL),(2,'enseignant',NULL);

UNLOCK TABLES;

/*Table structure for table `secteur` */

DROP TABLE IF EXISTS `secteur`;

CREATE TABLE `secteur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `secteur` */

LOCK TABLES `secteur` WRITE;

insert  into `secteur`(`id`,`libelle`,`description`) values (1,'agronomie',NULL),(2,'informatique',NULL),(3,'marketing et communication',NULL);

UNLOCK TABLES;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `user` */

LOCK TABLES `user` WRITE;

insert  into `user`(`id`,`email`,`password`,`username`) values (1,'samtou1999da@gmail.com','$argon2i$v=19$m=1024,t=2,p=2$aUYyQXJodzh1VnluTTAuMw$VI8cBhyMXh21q3waEkyaq5NzRLH0W2IKNLgzPp/qvcU','samtou'),(2,'particulier1@gmail.com','$2y$13$JZXeGMpenwQYo6d07QhkFO7aZGUsiZ5nLlR6BGAYh593BkC17XenK','samtou'),(4,'particulier2@gmail.com','$2y$13$jepEzPvM.dRetptDED4D.O7H4LmnN/bviFJKssmx6yDsVcuGhfbc.',NULL);

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
