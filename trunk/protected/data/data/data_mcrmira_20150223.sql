# Host: 127.0.0.1  (Version: 5.6.17)
# Date: 2014-11-17 16:11:02
# Generator: MySQL-Front 5.3  (Build 4.156)

/*!40101 SET NAMES utf8 */;

#
# Data for table "actividad_economica"
#

INSERT INTO `actividad_economica` (`id`,`nombre`,`estado`) VALUES (1,'Mecánico','ACTIVO'),(2,'Panadero','ACTIVO'),(3,'Comerciante','ACTIVO');

#
# Data for table "ahorro"
#


#
# Data for table "ahorro_deposito"
#


#
# Data for table "ahorro_extra"
#


#
# Data for table "ahorro_retiro"
#


#
# Data for table "ahorro_retiro_detalle"
#


#
# Data for table "credito"
#


#
# Data for table "credito_deposito"
#


#
# Data for table "credito_amortizacion"
#


#
# Data for table "cruge_authitem"
#

INSERT INTO `cruge_authitem` (`name`,`type`,`description`,`bizrule`,`data`) VALUES ('action_actividadEconomica_admin',0,'',NULL,'N;'),('action_ahorroDeposito_create',0,'',NULL,'N;'),('action_ahorroRetiro_admin',0,'',NULL,'N;'),('action_ahorro_admin',0,'',NULL,'N;'),('action_ahorro_ajaxCreateAhorroVoluntario',0,'',NULL,'N;'),('action_ahorro_create',0,'',NULL,'N;'),('action_ahorro_view',0,'',NULL,'N;'),('action_barrio_admin',0,'',NULL,'N;'),('action_barrio_ajaxGetBarrioByParroquia',0,'',NULL,'N;'),('action_canton_admin',0,'',NULL,'N;'),('action_canton_ajaxGetCantonByProvincia',0,'',NULL,'N;'),('action_canton_create',0,'',NULL,'N;'),('action_creditoEtapa_admin',0,'',NULL,'N;'),('action_credito_admin',0,'',NULL,'N;'),('action_dashboard_index',0,'',NULL,'N;'),('action_entidadBancaria_admin',0,'',NULL,'N;'),('action_parroquia_admin',0,'',NULL,'N;'),('action_parroquia_ajaxGetParroquiaByCanton',0,'',NULL,'N;'),('action_personaEtapa_admin',0,'',NULL,'N;'),('action_personaEtapa_create',0,'',NULL,'N;'),('action_persona_admin',0,'',NULL,'N;'),('action_persona_ajaxUpdateEtapa',0,'',NULL,'N;'),('action_persona_create',0,'',NULL,'N;'),('action_persona_kanban',0,'',NULL,'N;'),('action_persona_view',0,'',NULL,'N;'),('action_provincia_admin',0,'',NULL,'N;'),('action_sucursal_admin',0,'',NULL,'N;'),('action_sucursal_create',0,'',NULL,'N;'),('action_ui_editprofile',0,'',NULL,'N;'),('action_ui_usermanagementadmin',0,'',NULL,'N;'),('action_ui_usermanagementcreate',0,'',NULL,'N;'),('action_ui_usermanagementupdate',0,'',NULL,'N;'),('admin',0,'',NULL,'N;'),('Cruge.ui.*',0,'',NULL,'N;'),('edit-advanced-profile-features',0,'C:\\wamp\\www\\mcrmira\\protected\\modules\\cruge\\views\\ui\\usermanagementupdate.php linea 105',NULL,'N;');

#
# Data for table "cruge_authitemchild"
#


#
# Data for table "cruge_field"
#


#
# Data for table "cruge_session"
#

-- INSERT INTO `cruge_session` (`idsession`,`iduser`,`created`,`expire`,`status`,`ipaddress`,`usagecount`,`lastusage`,`logoutdate`,`ipaddressout`) VALUES (1,1,1415238763,1415286763,0,'::1',1,1415238763,1415241328,'::1'),(2,5,1415241335,1415289335,1,'::1',1,1415241335,NULL,NULL),(3,1,1415241730,1415289730,1,'::1',1,1415241730,NULL,NULL),(4,1,1415838248,1415886248,1,'::1',1,1415838248,NULL,NULL),(5,1,1416257854,1416305854,1,'::1',1,1416257854,NULL,NULL);

#
# Data for table "cruge_system"
#

INSERT INTO `cruge_system` (`idsystem`,`name`,`largename`,`sessionmaxdurationmins`,`sessionmaxsameipconnections`,`sessionreusesessions`,`sessionmaxsessionsperday`,`sessionmaxsessionsperuser`,`systemnonewsessions`,`systemdown`,`registerusingcaptcha`,`registerusingterms`,`terms`,`registerusingactivation`,`defaultroleforregistration`,`registerusingtermslabel`,`registrationonlogin`) VALUES (1,'default',NULL,800,10,1,-1,-1,0,0,0,0,NULL,0,'','',1);

#
# Data for table "cruge_user"
#

INSERT INTO `cruge_user` (`iduser`,`regdate`,`actdate`,`logondate`,`username`,`email`,`password`,`authkey`,`state`,`totalsessioncounter`,`currentsessioncounter`) VALUES (1,NULL,NULL,1416257854,'admin','armand1live@gmail.com','admin','admin',1,0,0);

#
# Data for table "cruge_fieldvalue"
#


#
# Data for table "cruge_authassignment"
#


#
# Data for table "cruge_user_sucursal"
#

INSERT INTO `cruge_user_sucursal` (`cruge_id`,`sucursal_id`) VALUES (1,1);

#
# Data for table "persona_etapa"
#

INSERT INTO `persona_etapa` (`id`,`nombre`,`peso`,`estado`) VALUES (1,'Oficio dirigido al Presidente de la Asociación',1,'ACTIVO'),(2,'En Aprobación',2,'ACTIVO'),(3,'Pago de cuota de ingreso',3,'ACTIVO');


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

-- INSERT INTO `direccion` (`id`,`calle_1`,`calle_2`,`numero`,`referencia`,`tipo`,`barrio_id`,`parroquia_id`) VALUES (1,'Calle 1','Calle 2','123456',NULL,'S',NULL,15),(2,'Calle 1','Calle 2','123456',NULL,'S',NULL,9);

#
# Data for table "entidad_bancaria"
#

-- INSERT INTO `entidad_bancaria` (`id`,`nombre`,`direccion_id`,`estado`,`num_cuenta`,`tipo_cuenta`) VALUES (1,'Pichincha',1,'ACTIVO','2201133485','AHORRO');

#
# Data for table "sucursal"
#

-- INSERT INTO `sucursal` (`id`,`nombre`,`direccion_id`,`estado`) VALUES (1,'Mira',1,'ACTIVO'),(2,'Espejo',2,'ACTIVO');
--

