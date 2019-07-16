/* Script DDL para Generar la Base de Datos del TAP del CPIIA
--   en:            2019-04-19 16:29:17 CEST
--   tipo:          MySQL
--   Creado por:    Borja Delgado Martín
*/

/*------------------------------------------------------
--  CREACIÓN DE LA BASE DE DATOS
------------------------------------------------------*/
drop database bdTapCPIIA;
create database bdTapCPIIA DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;


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
    DECLARE idLst, encargadosDisp, idEncargado INT;
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
            UPDATE `inscripcion` SET `Estado` = 'Turno asignado' 
                WHERE `NumColegiado`=idEncargado AND `IdLista`=idLst;
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
    DECLARE idEncargado, idLst, revisoresDisp, idRevisor INT;
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
        WHERE I.NumColegiado=C.NumColegiado AND I.IdLista=21 AND I.Estado='Esperando turno' 
            AND I.NumColegiado NOT IN 
                (SELECT NumColegiado FROM servicioactuacion WHERE IdSolicitudAct=idSolicAct)
        ORDER BY C.Apellidos, C.Nombre;
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
INSERT INTO `bdTapCPIIA`.`colegiado` (`Pass`, `Rol`, `Nombre`, `Apellidos`, `DomicilioProfesional`, `Localidad`, `CodigoPostal`, `Provincia`, `TelefonoProfesional`, `CorreoElectronico`, `URL`) VALUES (PASSWORD('1234'), 'Colegiado', 'Olivia', 'Ordoñez', 'Calle del Naranjo, N26, 4ºA', 'Jeréz', '03281', 'Cádiz', '650000018', 'OliviaO@mail.com', 'www.oliviaooo.com');
/*
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000000Z', PASSWORD('1234'), 'Responsable', 'Ramón', 'Ramírez', '1974-04-03', 'Calle del Olmo, N01, 1ºA', 'Málaga', '14264', 'Málaga', '650000001', '952000001', 'RamonG@mail.com', 'www.ramonggg.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000001S', PASSWORD('1234'), 'Colegiado', 'Adolfo', 'Arjona', '1962-04-03', 'Calle del Pino, N02, 1ºB', 'Jaén', '18204', 'Jaén', '650000002', '952000002', 'AdolfoA@mail.com', 'www.adolfoaaa.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000002Q', PASSWORD('1234'), 'Colegiado', 'Miguel', 'Martín', '1989-11-30', 'Calle del Abeto, N03, 1ºC', 'Madrid', '20482', 'Madrid', '650000003', '952000003', 'RamonG@mail.com', 'www.ramonggg.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000003V', PASSWORD('1234'), 'Colegiado', 'Tomás', 'Tapia', '1980-07-21', 'Calle del Ciprés, N04, 2ºA', 'Barcelona', '03281', 'Barcelona', '650000004', '952000004', 'TomasT@mail.com', 'www.tomasttt.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000004H', PASSWORD('1234'), 'Colegiado', 'Jorge', 'Jurado', '1977-01-13', 'Calle del Arbusto, N05, 2ºB', 'Granada', '43910', 'Granada', '650000005', '952000005', 'JorgeJ@mail.com', 'www.jorgejjj.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000005L', PASSWORD('1234'), 'Colegiado', 'Victor', 'Vals', '1969-02-09', 'Calle del Manzano, N06, 2ºC', 'Córdoba', '22321', 'Córdoba', '650000006', '952000006', 'VictorV@mail.com', 'www.victorvvv.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000006C', PASSWORD('1234'), 'Responsable', 'Pablo', 'Pascual', '1963-06-06', 'Calle del Sauce, N11, 3ºA', 'Málaga', '14264', 'Málaga', '650000007', '952000007', 'PabloP@mail.com', 'www.pabloppp.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000007K', PASSWORD('1234'), 'Colegiado', 'Carlos', 'Castillo', '1979-12-11', 'Calle del Almendro, N12, 3ºB', 'Sevila', '18204', 'Sevilla', '650000008', '952000008', 'CarlosC@mail.com', 'www.carlosccc.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000008E', PASSWORD('1234'), 'Colegiado', 'Denise', 'Darder', '1978-03-03', 'Calle del Baobab, N13, 3ºC', 'Madrid', '20482', 'Madrid', '650000009', '952000009', 'DeniseD@mail.com', 'www.deniseddd.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000009T', PASSWORD('1234'), 'Colegiado', 'Eric', 'Egea', '1990-04-01', 'Calle del Fresno, N14,  4ºA', 'Barcelona', '03281', 'Barcelona', '650000010', '952000010', 'EricE@mail.com', 'www.ericeee.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000010R', PASSWORD('1234'), 'Colegiado', 'Fabian', 'Fajardo', '1981-11-27', 'Calle del Álamo, N15, 4ºB', 'Huelva', '43910', 'Huelva', '650000011', '952000011', 'FabianF@mail.com', 'www.fabianfff.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000011W', PASSWORD('1234'), 'Colegiado', 'Guillermo', 'Guerra', '1973-08-29', 'Calle del Peral, N16, 4ºC', 'Córdoba', '22321', 'Córdoba', '650000012', '952000012', 'GuilleG@mail.com', 'www.gilleggg.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000012A', PASSWORD('1234'), 'Responsable', 'Borja', 'Badía', '1948-04-22', 'Calle del Alcornoque, N21, 2ºB', 'Vigo', '43910', 'Vigo', '650000013', '9520000013', 'BorjaB@mail.com', 'www.borjabbb.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000013G', PASSWORD('1234'), 'Colegiado', 'Hector', 'Heredia', '1972-05-19', 'Calle del Arce, N22, 2ºC', 'Valencia', '22321', 'Valencia', '650000014', '9520000014', 'HectorH@mail.com', 'www.hectorhhh.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000014M', PASSWORD('1234'), 'Responsable', 'Inés', 'Iniesta', '1976-02-26', 'Calle del Olivo, N23, 3ºA', 'Bilbao', '14264', 'Bilbao', '650000015', '9520000015', 'InesI@mail.com', 'www.inesiii.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000015Y', PASSWORD('1234'), 'Colegiado', 'Luis', 'Lozano', '1969-12-15', 'Calle de la Morera, N24, 3ºB', 'Sevila', '18204', 'Sevilla', '650000016', '9520000016', 'LuisL@mail.com', 'www.luislll.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000016F', PASSWORD('1234'), 'Colegiado', 'Nadia', 'Navarro', '1984-10-06', 'Calle del Abedul, N25, 3ºC', 'Madrid', '20482', 'Madrid', '650000017', '952000017', 'NadiaN@mail.com', 'www.nadiannn.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000018D', PASSWORD('1234'), 'Colegiado', 'Sara', 'Salcedo', '1991-07-14', 'Calle de la Haya, N27, 4ºB', 'Málaga', '43910', 'Malaga', '650000019', '952000019', 'SaraS@mail.com', 'www.sarasss.com');
INSERT INTO `bdTapCPIIA`.`colegiado` (`DNI`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `FechaNacimiento`, `Domicilio`, `Localidad`, `CodigoPostal`, `territorio`, `TelefonoProfesional`, `OtroTelefono`, `CorreoElectronico`, `URL`) VALUES ('10000019X', PASSWORD('1234'), 'Colegiado', 'Guillermo', 'Guerra', '1971-03-22', 'Calle de la Secuoya, N28, 4ºC', 'Córdoba', '22321', 'Córdoba', '650000020', '952000020', 'GuilleG@mail.com', 'www.gilleggg.com');
*/

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

/*-- Comisiones --*/
INSERT INTO `bdTapCPIIA`.`comisiontap` (`Presidente`) VALUES 
(1),
(2),
(NULL);

/*-- Tipos de lista --*/
INSERT INTO `bdTapCPIIA`.`tipolista` (`Nombre`, `Descripcion`, `IdComision`) VALUES 
('Peritaje', 'Estudios e investigaciones orientados a la obtención de una prueba informática de aplicación en un asunto judicial para que sirva a un juez para decidir sobre la culpabilidad o inocencia de una de las partes.', 1),
('Pentesting', 'Una prueba de penetración, o "pentest", es un ataque a un sistema informático con la intención de encontrar las debilidades de seguridad y todo lo que podría tener acceso a ella, su funcionalidad y datos. <br><br>El proceso consiste en identificar el o los sistemas del objetivo. Las pruebas de penetración pueden hacerse sobre una "caja blanca" (donde se ofrece toda la información de fondo y de sistema) o caja negra (donde no se proporciona información, excepto el nombre de la empresa). Una prueba de penetración puede ayudar a determinar si un sistema es vulnerable a los ataques, si las defensas (si las hay) son suficientes y no fueron vencidas. <br><br>Los problemas de seguridad descubiertos a través de la prueba de penetración deben notificarse al propietario del sistema. Con los resultados de las pruebas de penetración podremos evaluar los impactos potenciales a la organización y sugerir medidas para reducir los riesgos.', 2),
('Auditoría', 'Proceso que consiste en recoger, agrupar y evaluar evidencias para determinar si un Sistema de Información salvaguarda el activo empresarial, mantiene la integridad de los datos, utiliza eficientemente los recursos, cumple con las leyes y regulaciones establecidas.', 3);

/*-- Campos de especialización --*/
INSERT INTO `bdTapCPIIA`.`campoespecializacion` (`Nombre`, `Descripcion`) VALUES 
('Linux',                  'Sistema operativo libre tipo Unix; multiplataforma, multiusuario y multitarea.'),
('MySQL',                  'Sistema de gestión de bases de datos relacional.'),
('PHP',                    'Es un lenguaje de programación de propósito general de código del lado del servidor originalmente diseñado para el desarrollo web de contenido dinámico.'),
('Minería de datos',       'Campo de la estadística y las ciencias de la computación referido al proceso que intenta descubrir patrones en grandes volúmenes de conjuntos de datos.​​'),
('Computación en la nube', 'Paradigma que permite ofrecer servicios de computación a través de una red, que usualmente es Internet.'),
('Java',                   'Lenguaje de programación de propósito general, concurrente, orientado a objetos, que fue diseñado específicamente para tener tan pocas dependencias de implementación como fuera posible.'),
('ISO 27000',              'Estándares de seguridad publicados por la Organización Internacional para la Estandarización (ISO) y la Comisión Electrotécnica Internacional (IEC).'),
('Apache',                 'Servidor web HTTP de código abierto, para plataformas Unix (BSD, GNU/Linux, etc.), Microsoft Windows, Macintosh y otras, que implementa el protocolo HTTP/1.1 y la noción de sitio virtual según la normativa RFC 2616.');

/*-- Especializaciones de colegiado --*/
INSERT INTO `bdTapCPIIA`.`especializacioncolegiado` (`NumColegiado`, `IdEspecializacion`) VALUES 
('1', '1'),
('1', '2'),
('1', '3'),
('1', '7'),
('2', '1');

/*-- Especializaciones de tipo de lista --*/
INSERT INTO `bdTapCPIIA`.`especializacionlista` (`IdTipoLista`, `IdEspecializacion`) VALUES 
('1', '7'),
('2', '1');

/*-- Inclusiones en comisiones --*/
INSERT INTO `bdTapCPIIA`.`miembrocomision` (`NumColegiado`, `IdComision`) VALUES 
('1', '1'),
('1', '2');

/*-- Listas --*/
INSERT INTO `bdTapCPIIA`.`lista` (`IdTipoLista`, `Publica`, `Territorio`) VALUES
(1, 0,    'ALM'),
(1, 0,    'CAD'),
(1, 0,    'MAL'),
(1, 0,    'SEV'),
(1, 1,    'ALM'),
(1, 1,    'CAD'),
(1, 1,    'MAL'),
(1, 1,    'SEV'),
(2, 0,    'AOC'),
(2, 0,    'AOR'),
(2, 1,    'AOC'),
(2, 1,    'AOR'),
(3, 0,    'NAC'),
(3, 1,    'NAC'),
(1, NULL, 'NAC');

/*-- Inscripciones --*/
INSERT INTO `bdTapCPIIA`.`inscripcion` (`NumColegiado`, `IdLista`) VALUES 
('1', '3'),
('1', '6'),
('1', '10'),
('1', '11'),
('1', '15'),
('2', '3'),
('2', '6'),
('2', '15');


/*-- Solicitudes de actuacion --*/
INSERT INTO `solicitudactuacion` (`IdSolicitudAct`, `Nombre`, `Descripcion`, `Visado`, `FechaSolicitud`, `Estado`, `CorreoElectronico`, `Telefono`, `IdLista`) VALUES
(1, 'Prueba', 'Hans',     0, '2019-06-23', 'Pendiente de revision', 'test@mail.com', '1', 1),
(2, 'Prueba', 'rsbbrs',   1, '2019-06-23', 'Pendiente de revision', 'test@mail.com', '2', 4),
(3, 'Prueba', 'rbs',      0, '2019-06-23', 'Pendiente de revision', 'test@mail.com', '3', 10),
(4, 'Prueba', 'srb',      0, '2019-06-23', 'Pendiente de revision', 'test@mail.com', '4', 9),
(5, 'Prueba', 'bsrsbrrb', 1, '2019-06-23', 'Pendiente de revision', 'test@mail.com', '5', 13);

/*-- Servicios de actuación --*/
INSERT INTO `servicioactuacion` (`NumColegiado`, `IdSolicitudAct`, `EstadoProyecto`, `EstadoVisado`, `NumColegiadoRevisor`, `NumColegiadoTutela`) VALUES
(1, 1, 'Presupuesto entregado',   NULL,        NULL, NULL),
(2, 2, 'Pendiente de aceptacion', 'Revisando', 1,    3),
(2, 3, 'Pendiente de aceptacion', NULL,        3,    1);

