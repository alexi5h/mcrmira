# Host: localhost  (Version: 5.6.17)
# Date: 2014-08-03 20:55:38
# Generator: MySQL-Front 5.3  (Build 4.133)

/*!40101 SET NAMES utf8 */;

#
# Data for table "credito"
#


#
# Data for table "cruge_authitem"
#


#
# Data for table "cruge_authitemchild"
#


#
# Data for table "cruge_field"
#


#
# Data for table "cruge_session"
#


#
# Data for table "cruge_system"
#

INSERT INTO `cruge_system` (`idsystem`,`name`,`largename`,`sessionmaxdurationmins`,`sessionmaxsameipconnections`,`sessionreusesessions`,`sessionmaxsessionsperday`,`sessionmaxsessionsperuser`,`systemnonewsessions`,`systemdown`,`registerusingcaptcha`,`registerusingterms`,`terms`,`registerusingactivation`,`defaultroleforregistration`,`registerusingtermslabel`,`registrationonlogin`) VALUES (1,'default',NULL,800,10,1,-1,-1,0,0,0,0,NULL,0,'','',1);

#
# Data for table "cruge_user"
#

INSERT INTO `cruge_user` (`iduser`,`regdate`,`actdate`,`logondate`,`username`,`email`,`password`,`authkey`,`state`,`totalsessioncounter`,`currentsessioncounter`) VALUES (1,NULL,NULL,1407108665,'admin','armand1live@gmail.com','admin','admin',1,0,0);

#
# Data for table "cruge_fieldvalue"
#


#
# Data for table "cruge_authassignment"
#


#
# Data for table "pago"
#


#
# Data for table "deposito"
#


#
# Data for table "persona_etapa"
#

INSERT INTO `persona_etapa` (`id`,`nombre`,`peso`,`estado`) VALUES (1,'Etapa 1',1,'ACTIVO'),(2,'Etapa 2',2,'ACTIVO');

#
# Data for table "provincia"
#

INSERT INTO `provincia` (`id`,`nombre`) VALUES (1,'Imbabura'),(2,'Carchi');

#
# Data for table "canton"
#

INSERT INTO `canton` (`id`,`nombre`,`provincia_id`) VALUES (1,'Antonio Ante',1),(2,'Cotacachi',1),(3,'Otavalo',1),(4,'Ibarra',1),(5,'Pimampiro',1),(6,'San Miguel de Urcuquí',1),(7,'Bolívar',2),(8,'Espejo',2),(9,'Mira',2),(10,'Montúfar',2),(11,'San Pedro de Huaca',2),(12,'Tulcán',2);

#
# Data for table "parroquia"
#

INSERT INTO `parroquia` (`id`,`nombre`,`canton_id`) VALUES (1,'Atuntaqui',1),(2,'Imbaya',1),(3,'Natabuela',1),(4,'Chaltura',1),(5,'San Roque',1),(6,'Andrade Marín',1),(7,'Alpachaca',4),(8,'La Esperanza',4),(9,'Caranqui',4),(10,'Chugá',5),(11,'Mariano Acosta',5),(12,'San Francisco de Sigsipamba',5),(13,'Eugenio Espejo',3),(14,'González Suárez',3),(15,'Miguel Egas Cabezas',3),(16,'Mira',9);

#
# Data for table "barrio"
#


#
# Data for table "direccion"
#

INSERT INTO `direccion` (`id`,`calle_1`,`calle_2`,`numero`,`referencia`,`tipo`,`barrio_id`,`parroquia_id`) VALUES (1,'Calle 1','Calle 2','123456',NULL,'S',NULL,15);

#
# Data for table "entidad_bancaria"
#

INSERT INTO `entidad_bancaria` (`id`,`nombre`,`direccion_id`,`estado`,`num_cuenta`,`tipo_cuenta`) VALUES (1,'Pichincha',1,'ACTIVO','10a','AHORRO');

#
# Data for table "sucursal"
#

INSERT INTO `sucursal` (`id`,`nombre`,`direccion_id`,`estado`) VALUES (1,'Mira',1,'ACTIVO');

#
# Data for table "persona"
#


#
# Data for table "actividad_economica"
#

INSERT INTO `actividad_economica` (`id`,`nombre`,`estado`) VALUES (1,'Mecánico','ACTIVO'),(2,'Panadero','ACTIVO'),(3,'Comerciante','ACTIVO');


#
# Data for table "cruge_user_sucursal"
#

INSERT INTO `cruge_user_sucursal` (`cruge_id`,`sucursal_id`) VALUES (1,1);