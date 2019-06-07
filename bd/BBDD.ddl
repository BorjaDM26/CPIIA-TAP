/* Script DDL para Generar la Base de Datos del TAP del CPIIA
--   en:            2019-04-19 16:29:17 CEST
--   tipo:          MySQL
--   Creado por:    Borja Delgado Martín
*/

/*------------------------------------------------------
--  CREACIÓN DE LA BASE DE DATOS
------------------------------------------------------*/
drop database bd-tap-cpiia;
create database bd-tap-cpiia DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;


/*------------------------------------------------------
--  CREACIÓN DE LA ESTRUCTURA DE TABLAS
------------------------------------------------------*/
CREATE TABLE `bd-tap-cpiia`.`colegiado` (
    `NumColegiado`          INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Pass`                  VARCHAR (200) NOT NULL,
    `Rol`                   ENUM ('Colegiado','Responsable') NOT NULL DEFAULT 'Colegiado',
    `Nombre`                VARCHAR (50) NOT NULL ,
    `Apellidos`             VARCHAR (50) NOT NULL ,
    `DomicilioProfesional`  VARCHAR (200) NOT NULL ,
    `Localidad`             VARCHAR (200) NOT NULL ,
    `CodigoPostal`          VARCHAR (5) NOT NULL ,
    `Provincia`             VARCHAR (50) NOT NULL ,
    `TelefonoProfesional`   VARCHAR (15) NOT NULL ,
    `CorreoElectronico`     VARCHAR (200) NOT NULL ,
    `URL`                   VARCHAR (200),
    `Inhabilitado`          BOOLEAN NOT NULL DEFAULT 0,
    `FinInhabilitacion`     DATE
) ENGINE = InnoDB;

CREATE TABLE `bd-tap-cpiia`.`territorio` (
    `NombreTerritorio`      VARCHAR (50) NOT NULL PRIMARY KEY
) ENGINE = InnoDB;

CREATE TABLE `bd-tap-cpiia`.`tipolista` (
    `IdTipoLista`           INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Nombre`                VARCHAR(30) NOT NULL,
    `Descripcion`           TEXT NOT NULL,
    `FechaIniVacacional`    DATE,
    `FechaFinVacacional`    DATE,
    `IdComision`            INT,
    UNIQUE (`Nombre`),
    UNIQUE (`IdComision`)
) ENGINE = InnoDB;

CREATE TABLE `bd-tap-cpiia`.`comisiontap` (
    `IdComision`    INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `IdTipoLista`   INT,
    `Presidente`    INT,
    UNIQUE (`IdTipoLista`),
    FOREIGN KEY(`IdTipoLista`) REFERENCES `bd-tap-cpiia`.`tipolista`(`IdTipoLista`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(`Presidente`) REFERENCES `bd-tap-cpiia`.`colegiado`(`NumColegiado`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

ALTER TABLE `bd-tap-cpiia`.`tipolista` ADD FOREIGN KEY(`IdComision`) 
    REFERENCES `bd-tap-cpiia`.`comisiontap`(`IdComision`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE `bd-tap-cpiia`.`miembrocomision` ( 
    `NumColegiado` INT NOT NULL , 
    `IdComision`   INT NOT NULL,
    PRIMARY KEY (`NumColegiado`, `IdComision`),
    FOREIGN KEY(`NumColegiado`) REFERENCES `bd-tap-cpiia`.`colegiado`(`NumColegiado`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(`IdComision`) REFERENCES `bd-tap-cpiia`.`comisiontap`(`IdComision`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `bd-tap-cpiia`.`campoespecializacion` (
    `IdEspecializacion`   INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Nombre`              VARCHAR(30) NOT NULL,
    `Descripcion`         TEXT NOT NULL,
    UNIQUE (`Nombre`)
) ENGINE = InnoDB;

CREATE TABLE `bd-tap-cpiia`.`especializacioncolegiado` (
    `NumColegiado`        INT NOT NULL,
    `IdEspecializacion`   INT NOT NULL,
    PRIMARY KEY (`NumColegiado`, `IdEspecializacion`),
    FOREIGN KEY(`NumColegiado`) REFERENCES `bd-tap-cpiia`.`colegiado`(`NumColegiado`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(`IdEspecializacion`) REFERENCES `bd-tap-cpiia`.`campoespecializacion`(`IdEspecializacion`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `bd-tap-cpiia`.`especializacionlista` (
    `IdTipoLista`        INT NOT NULL,
    `IdEspecializacion`   INT NOT NULL,
    PRIMARY KEY (`IdTipoLista`, `IdEspecializacion`),
    FOREIGN KEY(`IdTipoLista`) REFERENCES `bd-tap-cpiia`.`tipolista`(`IdTipoLista`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(`IdEspecializacion`) REFERENCES `bd-tap-cpiia`.`campoespecializacion`(`IdEspecializacion`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

/*Para la entidad de lista:
--  Si la lista es de revisores el atributos Publica será nulo.
--  Si la lista es de profesionales el atributos Publica será 0 o 1.*/
CREATE TABLE `bd-tap-cpiia`.`lista`(
    `IdLista`           INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `IdTipoLista`       INT NOT NULL,
    `Publica`           BOOLEAN,
    `Territorio`    VARCHAR(50),
    UNIQUE (`IdTipoLista`, `Publica`, `Territorio`),
    FOREIGN KEY(`IdTipoLista`) REFERENCES `bd-tap-cpiia`.`tipolista`(`IdTipoLista`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(`Territorio`) REFERENCES `bd-tap-cpiia`.`territorio`(`NombreTerritorio`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `bd-tap-cpiia`.`inscripcion` ( 
    `Estado`            ENUM ('Esperando turno','Turno asignado','Turno pendiente de revision') 
                            NOT NULL DEFAULT 'Turno asignado',
    `NumColegiado`      INT NOT NULL,
    `IdLista`           INT NOT NULL,
    PRIMARY KEY (`NumColegiado`, `IdLista`),
    FOREIGN KEY(`NumColegiado`) REFERENCES `bd-tap-cpiia`.`colegiado`(`NumColegiado`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(`IdLista`) REFERENCES `bd-tap-cpiia`.`lista`(`IdLista`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `bd-tap-cpiia`.`solicitudactuacion` (
    `IdSolicitudAct`    INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Nombre`            VARCHAR(50) NOT NULL,
    `Descripcion`       TEXT NOT NULL,
    `Visado`            BOOLEAN NOT NULL,
    `FechaSolicitud`    DATE NOT NULL,
    `Estado`            ENUM ('Pendiente de revision','Pendiente de presupuesto','En desarrollo','Finalizada',
                              'Cancelada','Pendiente de aceptacion del presupuesto'
                             ) NOT NULL DEFAULT 'Pendiente de revision', 
    `CorreoElectronico` VARCHAR (50) NOT NULL , 
    `Telefono`          VARCHAR (15) , 
    `IdLista`           INT NOT NULL ,
    FOREIGN KEY(`IdLista`) REFERENCES `bd-tap-cpiia`.`lista`(`IdLista`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `bd-tap-cpiia`.`servicioactuacion` (
    `NumColegiado`          INT NOT NULL,
    `IdSolicitudAct`        INT NOT NULL,
    `EstadoProyecto`        ENUM ('En proceso de realizacion','Pendiente de aceptacion',
                                  'Pendiente de presupuesto','Presupuesto entregado',
                                  'Proyecto finalizado','Servicio rechazado'
                                 ) NOT NULL DEFAULT 'Pendiente de aceptacion',
    `EstadoVisado`          ENUM ('Esperando fin de servicio','Revisando',
                                  'Servicio finalizado con errores','Servicio finalizado correctamente'
                                 ),
    `DescripcionVisado`     TEXT,
    `NumColegiadoRevisor`   INT,
    `NumColegiadoTutela`    INT,
    PRIMARY KEY (`NumColegiado`, `IdSolicitudAct`),
    FOREIGN KEY(`NumColegiado`) REFERENCES `bd-tap-cpiia`.`colegiado`(`NumColegiado`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(`IdSolicitudAct`) REFERENCES `bd-tap-cpiia`.`solicitudactuacion`(`IdSolicitudAct`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(`NumColegiadoRevisor`) REFERENCES `bd-tap-cpiia`.`colegiado`(`NumColegiado`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(`NumColegiadoTutela`) REFERENCES `bd-tap-cpiia`.`colegiado`(`NumColegiado`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

