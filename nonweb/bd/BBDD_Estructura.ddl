/* Script DDL para generar la estructura de la base de datos del TAP del CPIIA
--   en:            2019-04-19 16:29:17 CEST
--   tipo:          MySQL
--   Creado por:    Borja Delgado Martín
*/

/*------------------------------------------------------
--  CREACIÓN DE LA BASE DE DATOS
------------------------------------------------------*/
drop database `bdTapCPIIA`;
create database `bdTapCPIIA` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;


/*------------------------------------------------------
--  CREACIÓN DE LA ESTRUCTURA DE TABLAS
------------------------------------------------------*/
CREATE TABLE `bdTapCPIIA`.`colegiado` (
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
    `FinInhabilitacion`     DATE
) ENGINE = InnoDB;

CREATE TABLE `bdTapCPIIA`.`territorio` (
    `IdTerritorio`  VARCHAR (3) NOT NULL PRIMARY KEY,
    `Nombre`        VARCHAR (50) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `bdTapCPIIA`.`comisiontap` (
    `IdComision`    INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Presidente`    INT,
    FOREIGN KEY(`Presidente`) REFERENCES `bdTapCPIIA`.`colegiado`(`NumColegiado`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `bdTapCPIIA`.`tipolista` (
    `IdTipoLista`           INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Nombre`                VARCHAR(30) NOT NULL,
    `Descripcion`           TEXT NOT NULL,
    `FechaIniVacacional`    DATE,
    `FechaFinVacacional`    DATE,
    `IdComision`            INT NOT NULL,
    UNIQUE (`Nombre`),
    UNIQUE (`IdComision`), 
    FOREIGN KEY(`IdComision`) REFERENCES `bdTapCPIIA`.`comisiontap`(`IdComision`) 
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `bdTapCPIIA`.`miembrocomision` ( 
    `NumColegiado` INT NOT NULL , 
    `IdComision`   INT NOT NULL,
    PRIMARY KEY (`NumColegiado`, `IdComision`),
    FOREIGN KEY(`NumColegiado`) REFERENCES `bdTapCPIIA`.`colegiado`(`NumColegiado`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(`IdComision`) REFERENCES `bdTapCPIIA`.`comisiontap`(`IdComision`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `bdTapCPIIA`.`campoespecializacion` (
    `IdEspecializacion`   INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Nombre`              VARCHAR(30) NOT NULL,
    `Descripcion`         TEXT NOT NULL,
    UNIQUE (`Nombre`)
) ENGINE = InnoDB;

CREATE TABLE `bdTapCPIIA`.`especializacioncolegiado` (
    `NumColegiado`      INT NOT NULL,
    `IdEspecializacion` INT NOT NULL,
    PRIMARY KEY (`NumColegiado`, `IdEspecializacion`),
    FOREIGN KEY(`NumColegiado`) REFERENCES `bdTapCPIIA`.`colegiado`(`NumColegiado`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(`IdEspecializacion`) REFERENCES `bdTapCPIIA`.`campoespecializacion`(`IdEspecializacion`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `bdTapCPIIA`.`especializacionlista` (
    `IdTipoLista`       INT NOT NULL,
    `IdEspecializacion` INT NOT NULL,
    PRIMARY KEY (`IdTipoLista`, `IdEspecializacion`),
    FOREIGN KEY(`IdTipoLista`) REFERENCES `bdTapCPIIA`.`tipolista`(`IdTipoLista`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(`IdEspecializacion`) REFERENCES `bdTapCPIIA`.`campoespecializacion`(`IdEspecializacion`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

/*Para la entidad de lista:
--  Si la lista es de revisores el atributos Publica será nulo.
--  Si la lista es de profesionales el atributos Publica será 0 o 1.*/
CREATE TABLE `bdTapCPIIA`.`lista`(
    `IdLista`           INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `IdTipoLista`       INT NOT NULL,
    `Publica`           BOOLEAN,
    `Territorio`        VARCHAR(3) NOT NULL,
    UNIQUE (`IdTipoLista`, `Publica`, `Territorio`),
    FOREIGN KEY(`IdTipoLista`) REFERENCES `bdTapCPIIA`.`tipolista`(`IdTipoLista`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(`Territorio`) REFERENCES `bdTapCPIIA`.`territorio`(`IdTerritorio`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `bdTapCPIIA`.`inscripcion` ( 
    `Estado`            ENUM ('Esperando turno','Turno asignado','Turno pendiente de revision') 
                            NOT NULL DEFAULT 'Turno asignado',
    `NumColegiado`      INT NOT NULL,
    `IdLista`           INT NOT NULL,
    PRIMARY KEY (`NumColegiado`, `IdLista`),
    FOREIGN KEY(`NumColegiado`) REFERENCES `bdTapCPIIA`.`colegiado`(`NumColegiado`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(`IdLista`) REFERENCES `bdTapCPIIA`.`lista`(`IdLista`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `bdTapCPIIA`.`solicitudactuacion` (
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
    FOREIGN KEY(`IdLista`) REFERENCES `bdTapCPIIA`.`lista`(`IdLista`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE `bdTapCPIIA`.`servicioactuacion` (
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
    FOREIGN KEY(`NumColegiado`) REFERENCES `bdTapCPIIA`.`colegiado`(`NumColegiado`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(`IdSolicitudAct`) REFERENCES `bdTapCPIIA`.`solicitudactuacion`(`IdSolicitudAct`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(`NumColegiadoRevisor`) REFERENCES `bdTapCPIIA`.`colegiado`(`NumColegiado`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY(`NumColegiadoTutela`) REFERENCES `bdTapCPIIA`.`colegiado`(`NumColegiado`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;



/*------------------------------------------------------
--  CREACIÓN DE PROCEDIMIENTOS
------------------------------------------------------*/
delimiter //

/* Encargar proyecto a un colegiado: (IdSolicitudAct, Respuesta) */
CREATE OR REPLACE PROCEDURE `bdTapCPIIA`.asignarProyectoAEncargado (
    IN idSolicAct INT, OUT res INT
) BEGIN
    DECLARE fallo INT DEFAULT FALSE;
    DECLARE idLst, encargadosDisp, idEncargado, vacaciones INT;
    /* Comprueba si la solicitud no está ya asignada a un colegiado */
    DECLARE curYaAsignada CURSOR FOR 
        SELECT IdLista FROM solicitudactuacion
        WHERE  IdSolicitudAct=idSolicAct AND IdSolicitudAct NOT IN 
            (SELECT IdSolicitudAct FROM servicioactuacion WHERE EstadoProyecto!='Servicio rechazado');
    /* Comprueba existen colegiados inscritos en la lista necesaria */
    DECLARE curEncargadosDisponibles CURSOR FOR 
        SELECT COUNT(NumColegiado) FROM inscripcion WHERE IdLista=idLst AND NumColegiado NOT IN 
            (SELECT NumColegiado FROM servicioactuacion WHERE IdSolicitudAct=idSolicAct);
    /* Selecciona el colegiado que se encargará de la solicitud */
    DECLARE curEncargadoSeleccionado CURSOR FOR 
        SELECT C.NumColegiado FROM inscripcion I, colegiado C
        WHERE I.NumColegiado=C.NumColegiado AND I.IdLista=idLst AND I.Estado='Esperando turno' 
            AND I.NumColegiado NOT IN 
                (SELECT NumColegiado FROM servicioactuacion WHERE IdSolicitudAct=idSolicAct)
        ORDER BY C.Apellidos, C.Nombre;
    /* Comprueba si estamos durante el periodo vacacional */
    DECLARE curVacacional CURSOR FOR 
        SELECT IF(CURRENT_DATE BETWEEN TL.FechaIniVacacional AND TL.FechaFinVacacional, 0, 1) Vacacional 
        FROM tipolista TL, lista L WHERE L.IdLista = idLst AND L.IdTipoLista=TL.IdTipoLista;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET fallo = TRUE;


    OPEN curYaAsignada;
    FETCH curYaAsignada INTO idLst;
    IF fallo THEN
        /* La solicitud está ya en manos de otro colegiado */
        select -1 into res;
    ELSE
        OPEN curEncargadosDisponibles;
        FETCH curEncargadosDisponibles INTO encargadosDisp;
        IF (encargadosDisp<=0) THEN
            /* No hay colegiados disponibles en la lista */
            select -2 into res;
        ELSE
            OPEN curEncargadoSeleccionado;
            FETCH curEncargadoSeleccionado INTO idEncargado;
            IF fallo THEN
                /* Ya se ha recorrido toda la lista */
                CLOSE curEncargadoSeleccionado;
                UPDATE `inscripcion` SET `Estado` = 'Esperando Turno' WHERE `IdLista`=idLst;
                OPEN curEncargadoSeleccionado;
                FETCH curEncargadoSeleccionado INTO idEncargado;
            END IF;
            /* Se ha encargado la solicitud a un colegiado */
            INSERT INTO `servicioactuacion` (`NumColegiado`, `IdSolicitudAct`, `EstadoProyecto`) 
                VALUES (idEncargado, idSolicAct, 'Pendiente de aceptacion');
            /* Si estamos en periodo vacacional no se actualiza el turno */
            OPEN curVacacional;
            FETCH curVacacional INTO vacaciones;
            IF vacaciones THEN
                UPDATE `inscripcion` SET `Estado` = 'Turno asignado' 
                    WHERE `NumColegiado`=idEncargado AND `IdLista`=idLst;
            END IF;
            select idEncargado into res;
            CLOSE curEncargadoSeleccionado;
        END IF;
        CLOSE curEncargadosDisponibles;        
    END IF;
    CLOSE curYaAsignada;
END//

/* Asignar revisión de un proyecto a un colegiado: (IdSolicitudAct, Respuesta) */
CREATE OR REPLACE PROCEDURE `bdTapCPIIA`.asignarProyectoARevisor (
    IN idSolicAct INT, OUT res INT
) BEGIN
    DECLARE fallo INT DEFAULT FALSE;
    DECLARE idEncargado, idLst, revisoresDisp, idRevisor, vacaciones INT;
    /* Comprueba el proyecto está asignado a un encargado pero no a un revisor. */
    DECLARE curYaAsignada CURSOR FOR 
        SELECT NumColegiado FROM servicioactuacion SE
        WHERE SE.IdSolicitudAct=idSolicAct AND SE.EstadoProyecto!='Servicio rechazado' 
            AND SE.NumColegiadoRevisor IS NULL;
    /* Selecciona el ID de la lista de revisores. */
    DECLARE curListaRevisores CURSOR FOR 
        SELECT LR.IdLista FROM solicitudactuacion SO, lista LP, lista LR
        WHERE SO.IdLista=LP.IdLista AND LP.IdTipoLista=LR.IdTipoLista 
            AND LR.Publica IS NULL AND SO.IdSolicitudAct=idSolicAct;
    /* Comprueba existen colegiados inscritos en la lista de revisores. */
    DECLARE curRevisoresDisponibles CURSOR FOR
        SELECT COUNT(NumColegiado) FROM inscripcion WHERE IdLista=idLst;
    /* Selecciona el revisor que se encargará de la solicitud */
    DECLARE curRevisorSeleccionado CURSOR FOR 
        SELECT C.NumColegiado FROM inscripcion I, colegiado C
        WHERE I.NumColegiado=C.NumColegiado AND I.IdLista=idLista AND I.Estado='Esperando turno' 
            AND I.NumColegiado NOT IN 
                (SELECT NumColegiado FROM servicioactuacion WHERE IdSolicitudAct=idSolicAct)
        ORDER BY C.Apellidos, C.Nombre;
    /* Comprueba si estamos durante el periodo vacacional */
    DECLARE curVacacional CURSOR FOR 
        SELECT IF(CURRENT_DATE BETWEEN TL.FechaIniVacacional AND TL.FechaFinVacacional, 0, 1) Vacacional 
        FROM tipolista TL, lista L WHERE L.IdLista = idLst AND L.IdTipoLista=TL.IdTipoLista;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET fallo = TRUE;


    OPEN curYaAsignada;
    FETCH curYaAsignada INTO idEncargado;
    IF fallo THEN
        /* No existe un encargado del proyecto o ya está asignada a un revisor. */
        select -1 into res;
    ELSE
        OPEN curListaRevisores;
        FETCH curListaRevisores INTO idLst;
        IF fallo THEN
            /* No existe una lista de revisores para ese tipo de lista. */
            select -2 into res;
        ELSE
            OPEN curRevisoresDisponibles;
            FETCH curRevisoresDisponibles INTO revisoresDisp;
            IF (revisoresDisp<=0) THEN
                /* No hay revisores disponibles. */
                select -3 into res;
            ELSE
                OPEN curRevisorSeleccionado;
                FETCH curRevisorSeleccionado INTO idRevisor;
                IF fallo THEN
                    /* Ya se ha recorrido toda la lista de revisores. */
                    CLOSE curRevisorSeleccionado;
                    UPDATE `inscripcion` SET `Estado` = 'Esperando Turno' WHERE `IdLista`=idLst;
                    OPEN curRevisorSeleccionado;
                    FETCH curRevisorSeleccionado INTO idRevisor;
                END IF;

                /* Se ha encargado la solicitud a un revisor. */
                UPDATE `servicioactuacion` 
                    SET `NumColegiadoRevisor`=idRevisor, `EstadoVisado`='Esperando fin de servicio' 
                    WHERE `NumColegiado`=idEncargado AND `IdSolicitudAct`=idSolicAct;
                /* Si estamos en periodo vacacional no se actualiza el turno */
                OPEN curVacacional;
                FETCH curVacacional INTO vacaciones;
                IF vacaciones THEN
                    UPDATE `inscripcion` SET `Estado` = 'Turno asignado' 
                        WHERE `NumColegiado`=idRevisor AND `IdLista`=idLst;
                END IF;
                CLOSE curVacacional;
                select idRevisor into res;
                CLOSE curRevisorSeleccionado;
            END IF;
            CLOSE curRevisoresDisponibles;
        END IF;
        CLOSE curListaRevisores;
    END IF;
    CLOSE curYaAsignada;
END//

delimiter ;


/*------------------------------------------------------
--  INSERCIONES
------------------------------------------------------*/
/*-- Colegiados --*/
INSERT INTO `bdTapCPIIA`.`colegiado` (`NumColegiado`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `DomicilioProfesional`, `Localidad`, `CodigoPostal`, `Provincia`, `TelefonoProfesional`, `CorreoElectronico`, `URL`, `FinInhabilitacion`) VALUES
(1, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Responsable', 'Admin', 'Temporal', 'Domicilio', 'Localidad', '00000', 'Provincia', '000000000', 'correo@mail.com', NULL, NULL);

/*-- Territorios --*/
INSERT INTO `bdTapCPIIA`.`territorio`(`IdTerritorio`, `Nombre`) VALUES 
('NAC', 'Nacional'),
('AND', 'Andalucía'),
('AOC', 'Andalucía Occidental'),
('AOR', 'Andalucía Oriental'),
('ALM', 'Almería'),
('CAD', 'Cádiz'),
('COR', 'Cordoba'),
('GRA', 'Granada'),
('HUE', 'Huelva'),
('JAE', 'Jaén'),
('MAL', 'Málaga'),
('SEV', 'Sevilla');
