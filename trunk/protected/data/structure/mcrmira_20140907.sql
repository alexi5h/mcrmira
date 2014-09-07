SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `mcrmira` ;
CREATE SCHEMA IF NOT EXISTS `mcrmira` DEFAULT CHARACTER SET latin1 ;
USE `mcrmira` ;

-- -----------------------------------------------------
-- Table `mcrmira`.`provincia`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`provincia` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(21) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `mcrmira`.`canton`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`canton` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `provincia_id` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_canton_provincia1_idx` (`provincia_id` ASC) ,
  CONSTRAINT `fk_canton_provincia1`
    FOREIGN KEY (`provincia_id` )
    REFERENCES `mcrmira`.`provincia` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mcrmira`.`parroquia`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`parroquia` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(32) NOT NULL ,
  `canton_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_parroquia_canton1_idx` (`canton_id` ASC) ,
  CONSTRAINT `fk_parroquia_canton1`
    FOREIGN KEY (`canton_id` )
    REFERENCES `mcrmira`.`canton` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mcrmira`.`barrio`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`barrio` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `parroquia_id` INT(11) NOT NULL ,
  `tipo` ENUM('B','C') NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_barrio_parroquia1_idx` (`parroquia_id` ASC) ,
  CONSTRAINT `fk_barrio_parroquia1`
    FOREIGN KEY (`parroquia_id` )
    REFERENCES `mcrmira`.`parroquia` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mcrmira`.`direccion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`direccion` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `calle_1` VARCHAR(128) NULL DEFAULT NULL ,
  `calle_2` VARCHAR(128) NULL DEFAULT NULL ,
  `numero` VARCHAR(8) NULL DEFAULT NULL ,
  `referencia` TEXT NULL DEFAULT NULL ,
  `tipo` ENUM('C','S','E') NOT NULL ,
  `barrio_id` INT NULL ,
  `parroquia_id` INT(11) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_direccion_barrio1_idx` (`barrio_id` ASC) ,
  INDEX `fk_direccion_parroquia1_idx` (`parroquia_id` ASC) ,
  CONSTRAINT `fk_direccion_barrio1`
    FOREIGN KEY (`barrio_id` )
    REFERENCES `mcrmira`.`barrio` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_direccion_parroquia1`
    FOREIGN KEY (`parroquia_id` )
    REFERENCES `mcrmira`.`parroquia` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mcrmira`.`sucursal`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`sucursal` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `direccion_id` INT(11) NOT NULL ,
  `estado` ENUM('ACTIVO','INACTIVO') NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_sucursal_direccion1_idx` (`direccion_id` ASC) ,
  CONSTRAINT `fk_sucursal_direccion1`
    FOREIGN KEY (`direccion_id` )
    REFERENCES `mcrmira`.`direccion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mcrmira`.`persona_etapa`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`persona_etapa` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(64) NOT NULL ,
  `peso` INT(3) NULL ,
  `estado` ENUM('ACTIVO','INACTIVO') NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mcrmira`.`actividad_economica`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`actividad_economica` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  `estado` ENUM('ACTIVO','INACTIVO') NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mcrmira`.`persona`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`persona` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `primer_nombre` VARCHAR(20) NOT NULL ,
  `segundo_nombre` VARCHAR(20) NULL ,
  `apellido_paterno` VARCHAR(30) NOT NULL ,
  `apellido_materno` VARCHAR(30) NULL ,
  `cedula` VARCHAR(20) NOT NULL ,
  `ruc` VARCHAR(13) NULL ,
  `telefono` VARCHAR(24) NULL ,
  `celular` VARCHAR(24) NULL ,
  `email` VARCHAR(255) NULL ,
  `descripcion` TEXT NULL ,
  `tipo` ENUM('CLIENTE','GARANTE') NULL ,
  `estado` ENUM('ACTIVO','INACTIVO') NOT NULL DEFAULT 'ACTIVO' ,
  `fecha_creacion` DATETIME NOT NULL ,
  `fecha_actualizacion` DATETIME NULL ,
  `usuario_creacion_id` INT(11) NOT NULL ,
  `usuario_actualizacion_id` INT(11) NULL ,
  `aprobado` TINYINT NULL DEFAULT 0 ,
  `sucursal_id` INT NOT NULL ,
  `persona_etapa_id` INT NOT NULL ,
  `direccion_domicilio_id` INT(11) NULL ,
  `direccion_negocio_id` INT(11) NULL ,
  `sexo` ENUM('M','F') NOT NULL ,
  `fecha_nacimiento` DATE NOT NULL ,
  `carga_familiar` INT(3) NOT NULL ,
  `discapacidad` ENUM('SI','NO') NOT NULL ,
  `estado_civil` ENUM('SOLTERO','CASADO','DIVORCIADO','VIUDO') NOT NULL ,
  `actividad_economica_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_cliente_sucursal1_idx` (`sucursal_id` ASC) ,
  INDEX `fk_cliente_direccion1_idx` (`direccion_domicilio_id` ASC) ,
  INDEX `fk_cliente_direccion2_idx` (`direccion_negocio_id` ASC) ,
  INDEX `fk_persona_persona_etapa1_idx` (`persona_etapa_id` ASC) ,
  INDEX `fk_persona_actividad_economica1_idx` (`actividad_economica_id` ASC) ,
  CONSTRAINT `fk_cliente_sucursal1`
    FOREIGN KEY (`sucursal_id` )
    REFERENCES `mcrmira`.`sucursal` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_direccion1`
    FOREIGN KEY (`direccion_domicilio_id` )
    REFERENCES `mcrmira`.`direccion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_direccion2`
    FOREIGN KEY (`direccion_negocio_id` )
    REFERENCES `mcrmira`.`direccion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_persona_persona_etapa1`
    FOREIGN KEY (`persona_etapa_id` )
    REFERENCES `mcrmira`.`persona_etapa` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_persona_actividad_economica1`
    FOREIGN KEY (`actividad_economica_id` )
    REFERENCES `mcrmira`.`actividad_economica` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mcrmira`.`cruge_authitem`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`cruge_authitem` (
  `name` VARCHAR(64) NOT NULL ,
  `type` INT(11) NOT NULL ,
  `description` TEXT NULL DEFAULT NULL ,
  `bizrule` TEXT NULL DEFAULT NULL ,
  `data` TEXT NULL DEFAULT NULL ,
  PRIMARY KEY (`name`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `mcrmira`.`cruge_user`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`cruge_user` (
  `iduser` INT(11) NOT NULL AUTO_INCREMENT ,
  `regdate` BIGINT(30) NULL DEFAULT NULL ,
  `actdate` BIGINT(30) NULL DEFAULT NULL ,
  `logondate` BIGINT(30) NULL DEFAULT NULL ,
  `username` VARCHAR(64) NULL DEFAULT NULL ,
  `email` VARCHAR(45) NULL DEFAULT NULL ,
  `password` VARCHAR(64) NULL DEFAULT NULL COMMENT 'Hashed password' ,
  `authkey` VARCHAR(100) NULL DEFAULT NULL COMMENT 'llave de autentificacion' ,
  `state` INT(11) NULL DEFAULT '0' ,
  `totalsessioncounter` INT(11) NULL DEFAULT '0' ,
  `currentsessioncounter` INT(11) NULL DEFAULT '0' ,
  PRIMARY KEY (`iduser`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `mcrmira`.`cruge_authassignment`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`cruge_authassignment` (
  `userid` INT(11) NOT NULL ,
  `bizrule` TEXT NULL DEFAULT NULL ,
  `data` TEXT NULL DEFAULT NULL ,
  `itemname` VARCHAR(64) NOT NULL ,
  PRIMARY KEY (`userid`, `itemname`) ,
  INDEX `fk_cruge_authassignment_cruge_authitem1` (`itemname` ASC) ,
  INDEX `fk_cruge_authassignment_user` (`userid` ASC) ,
  CONSTRAINT `fk_cruge_authassignment_cruge_authitem1`
    FOREIGN KEY (`itemname` )
    REFERENCES `mcrmira`.`cruge_authitem` (`name` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cruge_authassignment_user`
    FOREIGN KEY (`userid` )
    REFERENCES `mcrmira`.`cruge_user` (`iduser` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `mcrmira`.`cruge_authitemchild`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`cruge_authitemchild` (
  `parent` VARCHAR(64) NOT NULL ,
  `child` VARCHAR(64) NOT NULL ,
  PRIMARY KEY (`parent`, `child`) ,
  INDEX `child` (`child` ASC) ,
  CONSTRAINT `crugeauthitemchild_ibfk_1`
    FOREIGN KEY (`parent` )
    REFERENCES `mcrmira`.`cruge_authitem` (`name` )
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `crugeauthitemchild_ibfk_2`
    FOREIGN KEY (`child` )
    REFERENCES `mcrmira`.`cruge_authitem` (`name` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `mcrmira`.`cruge_field`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`cruge_field` (
  `idfield` INT(11) NOT NULL AUTO_INCREMENT ,
  `fieldname` VARCHAR(20) NOT NULL ,
  `longname` VARCHAR(50) NULL DEFAULT NULL ,
  `position` INT(11) NULL DEFAULT '0' ,
  `required` INT(11) NULL DEFAULT '0' ,
  `fieldtype` INT(11) NULL DEFAULT '0' ,
  `fieldsize` INT(11) NULL DEFAULT '20' ,
  `maxlength` INT(11) NULL DEFAULT '45' ,
  `showinreports` INT(11) NULL DEFAULT '0' ,
  `useregexp` VARCHAR(512) NULL DEFAULT NULL ,
  `useregexpmsg` VARCHAR(512) NULL DEFAULT NULL ,
  `predetvalue` MEDIUMBLOB NULL DEFAULT NULL ,
  PRIMARY KEY (`idfield`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `mcrmira`.`cruge_fieldvalue`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`cruge_fieldvalue` (
  `idfieldvalue` INT(11) NOT NULL AUTO_INCREMENT ,
  `iduser` INT(11) NOT NULL ,
  `idfield` INT(11) NOT NULL ,
  `value` BLOB NULL DEFAULT NULL ,
  PRIMARY KEY (`idfieldvalue`) ,
  INDEX `fk_cruge_fieldvalue_cruge_user1` (`iduser` ASC) ,
  INDEX `fk_cruge_fieldvalue_cruge_field1` (`idfield` ASC) ,
  CONSTRAINT `fk_cruge_fieldvalue_cruge_user1`
    FOREIGN KEY (`iduser` )
    REFERENCES `mcrmira`.`cruge_user` (`iduser` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cruge_fieldvalue_cruge_field1`
    FOREIGN KEY (`idfield` )
    REFERENCES `mcrmira`.`cruge_field` (`idfield` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `mcrmira`.`cruge_session`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`cruge_session` (
  `idsession` INT(11) NOT NULL AUTO_INCREMENT ,
  `iduser` INT(11) NOT NULL ,
  `created` BIGINT(30) NULL DEFAULT NULL ,
  `expire` BIGINT(30) NULL DEFAULT NULL ,
  `status` INT(11) NULL DEFAULT '0' ,
  `ipaddress` VARCHAR(45) NULL DEFAULT NULL ,
  `usagecount` INT(11) NULL DEFAULT '0' ,
  `lastusage` BIGINT(30) NULL DEFAULT NULL ,
  `logoutdate` BIGINT(30) NULL DEFAULT NULL ,
  `ipaddressout` VARCHAR(45) NULL DEFAULT NULL ,
  PRIMARY KEY (`idsession`) ,
  INDEX `crugesession_iduser` (`iduser` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `mcrmira`.`cruge_system`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`cruge_system` (
  `idsystem` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL DEFAULT NULL ,
  `largename` VARCHAR(45) NULL DEFAULT NULL ,
  `sessionmaxdurationmins` INT(11) NULL DEFAULT '30' ,
  `sessionmaxsameipconnections` INT(11) NULL DEFAULT '10' ,
  `sessionreusesessions` INT(11) NULL DEFAULT '1' COMMENT '1yes 0no' ,
  `sessionmaxsessionsperday` INT(11) NULL DEFAULT '-1' ,
  `sessionmaxsessionsperuser` INT(11) NULL DEFAULT '-1' ,
  `systemnonewsessions` INT(11) NULL DEFAULT '0' COMMENT '1yes 0no' ,
  `systemdown` INT(11) NULL DEFAULT '0' ,
  `registerusingcaptcha` INT(11) NULL DEFAULT '0' ,
  `registerusingterms` INT(11) NULL DEFAULT '0' ,
  `terms` BLOB NULL DEFAULT NULL ,
  `registerusingactivation` INT(11) NULL DEFAULT '1' ,
  `defaultroleforregistration` VARCHAR(64) NULL DEFAULT NULL ,
  `registerusingtermslabel` VARCHAR(100) NULL DEFAULT NULL ,
  `registrationonlogin` INT(11) NULL DEFAULT '1' ,
  PRIMARY KEY (`idsystem`) )
ENGINE = InnoDB
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `mcrmira`.`ahorro`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`ahorro` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `descripcion` VARCHAR(50) NOT NULL ,
  `socio_id` INT NOT NULL ,
  `cantidad` DECIMAL(10,2) NOT NULL ,
  `fecha` DATETIME NOT NULL ,
  `estado` ENUM('DEUDA','PAGADO') NULL ,
  `tipo` ENUM('OBLIGATORIO','VOLUNTARIO','PRIMER_PAGO') NOT NULL ,
  `saldo_contra` DECIMAL(10,2) NULL ,
  `saldo_favor` DECIMAL(10,2) NULL ,
  `anulado` TINYINT(1) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mcrmira`.`ahorro_deposito`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`ahorro_deposito` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `cantidad` DECIMAL(10,2) NOT NULL ,
  `entidad_bancaria_id` INT NOT NULL ,
  `cod_comprobante_entidad` VARCHAR(45) NOT NULL ,
  `fecha_comprobante_entidad` DATETIME NOT NULL ,
  `sucursal_comprobante_id` INT NOT NULL ,
  `cod_comprobante_su` VARCHAR(45) NOT NULL ,
  `fecha_comprobante_su` DATETIME NOT NULL ,
  `observaciones` TEXT NULL ,
  `pago_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_deposito_pago1_idx` (`pago_id` ASC) ,
  CONSTRAINT `fk_deposito_pago1`
    FOREIGN KEY (`pago_id` )
    REFERENCES `mcrmira`.`ahorro` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mcrmira`.`credito`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`credito` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `socio_id` INT NOT NULL ,
  `garante_id` INT NOT NULL ,
  `sucursal_id` INT NOT NULL ,
  `fecha_credito` DATETIME NOT NULL ,
  `fecha_limite` DATETIME NOT NULL ,
  `cantidad_total` DECIMAL(10,2) NOT NULL ,
  `interes` DECIMAL(3,2) NOT NULL ,
  `estado` ENUM('DEUDA','PAGADO') NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mcrmira`.`entidad_bancaria`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`entidad_bancaria` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(45) NOT NULL ,
  `direccion_id` INT(11) NOT NULL ,
  `estado` ENUM('ACTIVO','INACTIVO') NOT NULL ,
  `num_cuenta` VARCHAR(45) NOT NULL ,
  `tipo_cuenta` ENUM('AHORRO','CORRIENTE') NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_entidad_bacaria_direccion1_idx` (`direccion_id` ASC) ,
  CONSTRAINT `fk_entidad_bacaria_direccion1`
    FOREIGN KEY (`direccion_id` )
    REFERENCES `mcrmira`.`direccion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mcrmira`.`ahorro_retiro`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`ahorro_retiro` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `socio_id` INT(10) NOT NULL ,
  `sucursal_id` INT(10) NOT NULL ,
  `cantidad` DECIMAL(10,2) NOT NULL ,
  `fecha_retiro` DATETIME NOT NULL ,
  `comprobante_retiro` VARCHAR(45) NOT NULL ,
  `entidad_bancaria_id` INT NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mcrmira`.`ahorro_retiro_detalle`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`ahorro_retiro_detalle` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `cantidad` DECIMAL(10,2) NOT NULL ,
  `ahorro_id` INT NOT NULL ,
  `ahorro_retiro_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_retiro_detalle_ahorro_retiro1_idx` (`ahorro_retiro_id` ASC) ,
  CONSTRAINT `fk_retiro_detalle_ahorro_retiro1`
    FOREIGN KEY (`ahorro_retiro_id` )
    REFERENCES `mcrmira`.`ahorro_retiro` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mcrmira`.`credito_amortizacion`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`credito_amortizacion` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nro_cuota` INT NOT NULL ,
  `fecha_pago` DATE NOT NULL ,
  `cuota` DECIMAL(10,2) NOT NULL ,
  `interes` DECIMAL(10,2) NOT NULL ,
  `mora` DECIMAL(10,2) NULL ,
  `estado` ENUM('DEUDA','PAGADO') NOT NULL ,
  `credito_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_credito_amortizacion_credito1_idx` (`credito_id` ASC) ,
  CONSTRAINT `fk_credito_amortizacion_credito1`
    FOREIGN KEY (`credito_id` )
    REFERENCES `mcrmira`.`credito` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mcrmira`.`credito_deposito`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mcrmira`.`credito_deposito` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `cantidad` DECIMAL(10,2) NOT NULL ,
  `entidad_bancaria_id` INT NOT NULL ,
  `cod_comprobante_entidad` VARCHAR(45) NOT NULL ,
  `fecha_comprobante_entidad` DATETIME NOT NULL ,
  `sucursal_comprobante_id` INT NOT NULL ,
  `cod_comprobante_su` VARCHAR(45) NOT NULL ,
  `fecha_comprobante_su` DATETIME NOT NULL ,
  `observaciones` TEXT NULL ,
  `credito_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_credito_deposito_credito1_idx` (`credito_id` ASC) ,
  CONSTRAINT `fk_credito_deposito_credito1`
    FOREIGN KEY (`credito_id` )
    REFERENCES `mcrmira`.`credito` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `mcrmira` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
