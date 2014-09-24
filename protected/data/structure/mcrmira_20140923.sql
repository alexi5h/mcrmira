# Host: localhost  (Version: 5.5.24-log)
# Date: 2014-09-23 19:26:59
# Generator: MySQL-Front 5.3  (Build 4.136)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "credito"
#

DROP TABLE IF EXISTS `credito`;
CREATE TABLE `credito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `socio_id` int(11) NOT NULL,
  `garante_id` int(11) NOT NULL,
  `sucursal_id` int(11) NOT NULL,
  `fecha_credito` datetime NOT NULL,
  `fecha_limite` datetime NOT NULL,
  `cantidad_total` decimal(10,2) NOT NULL,
  `interes` decimal(3,2) NOT NULL,
  `periodos` int(11) NOT NULL DEFAULT '0',
  `estado` enum('DEUDA','PAGADO') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
