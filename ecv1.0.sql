/*
SQLyog Ultimate v8.71 
MySQL - 5.1.33-community : Database - diem
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`diem` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `diem`;

/*Table structure for table `score_term` */

DROP TABLE IF EXISTS `score_term`;

CREATE TABLE `score_term` (
  `student_id` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `term_name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `subject_id` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `mid_term` double DEFAULT NULL,
  `end_term` double DEFAULT NULL,
  `avg` double DEFAULT NULL,
  PRIMARY KEY (`student_id`,`term_name`,`subject_id`),
  KEY `term_name` (`term_name`),
  KEY `subject_id` (`subject_id`),
  CONSTRAINT `score_term_ibfk_1` FOREIGN KEY (`term_name`) REFERENCES `term` (`term_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `score_term_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `score_term_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `score_term` */

/*Table structure for table `student` */

DROP TABLE IF EXISTS `student`;

CREATE TABLE `student` (
  `student_id` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `sname` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `student` */

/*Table structure for table `subject` */

DROP TABLE IF EXISTS `subject`;

CREATE TABLE `subject` (
  `subject_id` varchar(6) COLLATE utf8_unicode_ci NOT NULL,
  `subject_name` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `credit` int(2) DEFAULT NULL,
  PRIMARY KEY (`subject_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `subject` */

/*Table structure for table `term` */

DROP TABLE IF EXISTS `term`;

CREATE TABLE `term` (
  `term_name` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `student_id` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `num_cre_reg` int(3) DEFAULT NULL,
  `num_cre_pass` int(3) DEFAULT NULL,
  `avg_grade_term` double DEFAULT NULL,
  `num_cre_all` int(3) DEFAULT NULL,
  `avg_grade_all` double DEFAULT NULL,
  PRIMARY KEY (`term_name`,`student_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `term` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
