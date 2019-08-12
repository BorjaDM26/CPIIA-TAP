/* Script DDL para añadir contenido de pruebas a la base de datos del TAP del CPIIA
--   en:            2019-08-12 16:52:23 CEST
--   tipo:          MySQL
--   Creado por:    Borja Delgado Martín
*/

/*------------------------------------------------------
--  INSERCIONES
------------------------------------------------------*/
/*-- Colegiados --*/
INSERT INTO `bdTapCPIIA`.`colegiado` (`NumColegiado`, `Pass`, `Rol`, `Nombre`, `Apellidos`, `DomicilioProfesional`, `Localidad`, `CodigoPostal`, `Provincia`, `TelefonoProfesional`, `CorreoElectronico`, `URL`, `FinInhabilitacion`) VALUES
(2, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Colegiado', 'PHP', 'Calle del Abeto, N02, 2ºB', 'Cádiz', '22222', 'Cádiz', '650000002', 'colegiado@mail.com', 'www.colegiadoCCC.com', NULL),
(3, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Olivia', 'Ortiz', 'Calle del Naranjo, N26, 4ºA', 'Jeréz', '03281', 'Cádiz', '650000018', 'OliviaO@mail.com', 'www.oliviaooo.com', NULL),
(4, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Responsable', 'Jorge', 'Pr', 'Calle Pr', 'Pr', '00000', 'Pr', '650000000', 'pr@mail.com', 'www.pr.com', '2019-06-30'),
(5, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Angel', 'Álvarez', 'Calle Falsa 1', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.AA.com', '2019-07-27'),
(6, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Borja', 'Bermúdez', 'Calle Falsa 2', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.BB.com', NULL),
(7, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Carlos', 'Correa', 'Calle Falsa 3', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.CC.com', NULL),
(8, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Daniel', 'Díaz', 'Calle Falsa 4', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.DD.com', NULL),
(9, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Eric', 'Encina', 'Calle Falsa 5', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.EE.com', NULL),
(10, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Francisco', 'Fernández', 'Calle Falsa 6', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.FF.com', NULL),
(11, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Guillermo', 'García', 'Calle Falsa 7', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.GG.com', NULL),
(12, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Hector', 'Herrera', 'Calle Falsa 8', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.HH.com', NULL),
(13, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Inés', 'Itziar', 'Calle Falsa 9', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.II.com', NULL),
(14, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Jaime', 'Jurado', 'Calle Falsa 10', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.JJ.com', NULL),
(15, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Kiko', 'Kilo', 'Calle Falsa 11', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.KK.com', NULL),
(16, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Luísa', 'Lleida', 'Calle Falsa 12', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.LL.com', NULL),
(17, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'María', 'Martín', 'Calle Falsa 13', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.MM.com', NULL),
(18, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Nuria', 'Navarro', 'Calle Falsa 14', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.NN.com', NULL),
(19, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Ona', 'Ortiz', 'Calle Falsa 15', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.OO.com', NULL),
(20, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Pablo', 'Pérez', 'Calle Falsa 16', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.PP.com', NULL),
(21, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Rubén', 'Rueda', 'Calle Falsa 17', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.RR.com', NULL),
(22, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Silvia', 'Santoral', 'Calle Falsa 18', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.SS.com', NULL),
(23, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Tomás', 'Trujillo', 'Calle Falsa 19', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.TT.com', NULL),
(24, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Unai', 'Unser', 'Calle Falsa 20', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.UU.com', NULL),
(25, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Victoria', 'Vigo', 'Calle Falsa 21', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.VV.com', NULL),
(26, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Colegiado', 'Zacarías', 'Zafra', 'Calle Falsa 22', 'Málaga', '11111', 'Málaga', '650000001', 'AA@mail.com', 'www.ZZ.com', NULL),
(27, 'c95b2cd148a0898110e4495af75efd247cd3cf8769d61724dbab4fd8a7058c99', 'Responsable', 'Prueba2', 'PHP2', 'Calle Hans', '33', '22', '33', '999', 'oib', NULL, NULL),
(28, '086d585827196c6ddddb58af6986c4a27d57b8d100c467b233365277ad9f06e6', 'Responsable', 'Prueba2', 'PHP2', 'Calle Hans', '33', '29631', 'Málaga', '999999999', 'test@mail.com', NULL, NULL),
(29, '1bff025afb4d0ea3c70bbc91edba29a85566e4bd53a6e1975a96fbbe6b3e1d94', 'Responsable', 'Borja', 'Delgado Martín', 'Calle Hans', 'Málaga', '29631', 'Málaga', '999999999', 'bbpnm_bok@hotmail.com', 'www.prueba.com', NULL),
(30, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Responsable', 'Prueba', 'Pass', 'Calle del Olmo, N01, 1ºA', 'Málaga', '11111', 'Málaga', '650000001', 'admin@mail.com', 'www.adminAAA.com', NULL),
(31, '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Responsable', 'Admin', 'Temporal', 'Domicilio', 'Localidad', '00000', 'Provincia', '000000000', 'correo@mail.com', NULL, NULL);


/*-- Campos de especialización --*/
INSERT INTO `bdTapCPIIA`.`campoespecializacion` (`IdEspecializacion`, `Nombre`, `Descripcion`) VALUES
(1, 'Linux', 'Sistema operativo libre tipo Unix; multiplataforma, multiusuario y multitarea.'),
(2, 'MySQL', 'Sistema de gestión de bases de datos relacional.'),
(3, 'PHP', 'Es un lenguaje de programación de propósito general de código del lado del servidor originalmente diseñado para el desarrollo web de contenido dinámico.'),
(4, 'Minería de datos', 'Campo de la estadística y las ciencias de la computación referido al proceso que intenta descubrir patrones en grandes volúmenes de conjuntos de datos.​​'),
(5, 'Computación en la nube', 'Paradigma que permite ofrecer servicios de computación a través de una red, que usualmente es Internet.'),
(6, 'Java', 'Lenguaje de programación de propósito general, concurrente, orientado a objetos, que fue diseñado específicamente para tener tan pocas dependencias de implementación como fuera posible.'),
(7, 'ISO 27000', 'Estándares de seguridad publicados por la Organización Internacional para la Estandarización (ISO) y la Comisión Electrotécnica Internacional (IEC).'),
(8, 'Apache', 'Servidor web HTTP de código abierto, para plataformas Unix (BSD, GNU/Linux, etc.), Microsoft Windows, Macintosh y otras, que implementa el protocolo HTTP/1.1 y la noción de sitio virtual según la normativa RFC 2616.'),
(9, 'Windows', '  Prueba hans.  ');


/*-- Comisiones --*/
INSERT INTO `bdTapCPIIA`.`comisiontap` (`IdComision`, `Presidente`) VALUES
(1, 1),
(2, 3),
(3, NULL),
(4, NULL),
(5, NULL),
(6, NULL),
(7, NULL);


/*-- Tipos de lista --*/
INSERT INTO `bdTapCPIIA`.`tipolista` (`IdTipoLista`, `Nombre`, `Descripcion`, `FechaIniVacacional`, `FechaFinVacacional`, `IdComision`) VALUES
(1, 'Peritaje', 'Estudios e investigaciones orientados a la obtención de una prueba informática de aplicación en un asunto judicial para que sirva a un juez para decidir sobre la culpabilidad o inocencia de una de las partes.  ', '2019-08-01', '2019-08-31', 1),
(2, 'Pentesting', 'Una prueba de penetración, o \"pentest\", es un ataque a un sistema informático con la intención de encontrar las debilidades de seguridad y todo lo que podría tener acceso a ella, su funcionalidad y datos. <br><br>El proceso consiste en identificar el o los sistemas del objetivo. Las pruebas de penetración pueden hacerse sobre una \"caja blanca\" (donde se ofrece toda la información de fondo y de sistema) o caja negra (donde no se proporciona información, excepto el nombre de la empresa). Una prueba de penetración puede ayudar a determinar si un sistema es vulnerable a los ataques, si las defensas (si las hay) son suficientes y no fueron vencidas. <br><br>Los problemas de seguridad descubiertos a través de la prueba de penetración deben notificarse al propietario del sistema. Con los resultados de las pruebas de penetración podremos evaluar los impactos potenciales a la organización y sugerir medidas para reducir los riesgos.', NULL, NULL, 2),
(3, 'Auditoría', 'Proceso que consiste en recoger, agrupar y evaluar evidencias para determinar si un Sistema de Información salvaguarda el activo empresarial, mantiene la integridad de los datos, utiliza eficientemente los recursos, cumple con las leyes y regulaciones establecidas.   ', '2019-07-01', '2019-07-31', 3),
(4, 'Consultoría', 'Soy un tipo de lista de prueba.     ', NULL, NULL, 5),
(5, 'Comunicaciones', 'Hans.', NULL, NULL, 4);


/*-- Especializaciones de colegiado --*/
INSERT INTO `bdTapCPIIA`.`especializacioncolegiado` (`NumColegiado`, `IdEspecializacion`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 7),
(2, 1),
(2, 4),
(2, 7),
(3, 1),
(3, 2),
(3, 4),
(4, 1),
(4, 6),
(4, 8),
(4, 9);


/*-- Especializaciones de tipo de lista --*/
INSERT INTO `bdTapCPIIA`.`especializacionlista` (`IdTipoLista`, `IdEspecializacion`) VALUES
(1, 7),
(2, 1),
(2, 4),
(4, 1),
(4, 6),
(4, 8);


/*-- Inclusiones en comisiones --*/
INSERT INTO `bdTapCPIIA`.`miembrocomision` (`NumColegiado`, `IdComision`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 2);


/*-- Listas --*/
INSERT INTO `bdTapCPIIA`.`lista` (`IdLista`, `IdTipoLista`, `Publica`, `Territorio`) VALUES
(1, 1, 0, 'ALM'),
(2, 1, 0, 'CAD'),
(3, 1, 0, 'MAL'),
(4, 1, 0, 'SEV'),
(5, 1, 1, 'ALM'),
(6, 1, 1, 'CAD'),
(7, 1, 1, 'MAL'),
(8, 1, 1, 'SEV'),
(9, 2, 0, 'AOC'),
(10, 2, 0, 'AOR'),
(11, 2, 1, 'AOC'),
(12, 2, 1, 'AOR'),
(13, 3, 0, 'NAC'),
(14, 3, 1, 'NAC'),
(15, 1, NULL, 'NAC'),
(16, 1, 1, 'NAC'),
(17, 1, 0, 'NAC'),
(19, 3, 1, 'GRA'),
(20, 3, NULL, 'NAC'),
(21, 4, 0, 'ALM'),
(22, 2, NULL, 'NAC');


/*-- Inscripciones --*/
INSERT INTO `bdTapCPIIA`.`inscripcion` (`Estado`, `NumColegiado`, `IdLista`) VALUES
('Esperando turno', 1, 1),
('Esperando turno', 1, 3),
('Esperando turno', 1, 5),
('Esperando turno', 1, 6),
('Esperando turno', 1, 10),
('Esperando turno', 1, 11),
('Esperando turno', 1, 13),
('Turno asignado', 1, 14),
('Esperando turno', 1, 15),
('Turno asignado', 1, 20),
('Esperando turno', 1, 21),
('Turno asignado', 2, 1),
('Esperando turno', 2, 3),
('Turno asignado', 2, 6),
('Turno asignado', 2, 15),
('Turno asignado', 2, 21),
('Turno asignado', 3, 9),
('Turno asignado', 3, 21),
('Esperando turno', 4, 14),
('Esperando turno', 4, 20),
('Turno asignado', 5, 14),
('Turno asignado', 5, 20),
('Turno asignado', 8, 1),
('Turno asignado', 8, 14),
('Turno asignado', 8, 20),
('Esperando turno', 9, 1),
('Turno asignado', 10, 14),
('Turno asignado', 10, 20),
('Esperando turno', 12, 1),
('Turno asignado', 13, 14),
('Esperando turno', 13, 20),
('Turno asignado', 14, 1),
('Esperando turno', 15, 1),
('Turno asignado', 17, 1),
('Esperando turno', 18, 14),
('Turno asignado', 18, 20),
('Turno asignado', 20, 14),
('Turno asignado', 20, 20),
('Esperando turno', 21, 1),
('Esperando turno', 22, 1),
('Esperando turno', 22, 14),
('Esperando turno', 22, 20),
('Turno asignado', 23, 1),
('Esperando turno', 24, 1),
('Turno asignado', 25, 1);


/*-- Solicitudes de actuacion --*/
INSERT INTO `bdTapCPIIA`.`solicitudactuacion` (`IdSolicitudAct`, `Nombre`, `Descripcion`, `Visado`, `FechaSolicitud`, `Estado`, `CorreoElectronico`, `Telefono`, `IdLista`) VALUES
(1, 'Prueba', ' Hans ', 0, '2019-06-23', 'Pendiente de revision', 'test@mail.com', '666666666', 1),
(2, 'Prueba', 'rsbbrs', 1, '2019-06-23', 'Pendiente de revision', 'test@mail.com', '2', 4),
(3, 'Cambio', 'He cambiado cosas.', 1, '2019-06-23', 'En desarrollo', 'cambio@mail.com', NULL, 1),
(4, 'Prueba', 'srb', 0, '2019-06-23', 'Pendiente de revision', 'test@mail.com', '4', 9),
(5, 'Osvaldo', '     bsrsbrrb     ', 1, '2019-06-23', 'Pendiente de revision', 'test@mail.com', '5', 1),
(6, 'Web', ' Insertar solicitud de proyecto desde la web. ', 0, '2019-07-12', 'En desarrollo', 'test@mail.com', '666666666', 21),
(7, 'Prueba Vacaciones', 'Estoy probando que se asignen sin problemas las vacaciones.', 0, '2019-07-23', 'Pendiente de revision', 'prueba@mail.com', NULL, 14),
(8, 'Prueba2', 'Hans', 0, '2019-08-05', 'Pendiente de revision', 'oib', '666', 17),
(9, 'Prueba2', 'Hans', 0, '2019-08-05', 'Pendiente de revision', 'oib', '666', 2);


/*-- Servicios de actuación --*/
INSERT INTO `bdTapCPIIA`.`servicioactuacion` (`NumColegiado`, `IdSolicitudAct`, `EstadoProyecto`, `EstadoVisado`, `DescripcionVisado`, `NumColegiadoRevisor`, `NumColegiadoTutela`) VALUES
(1, 1, 'Servicio rechazado', NULL, NULL, NULL, 2),
(1, 5, 'Pendiente de aceptacion', 'Esperando fin de servicio', NULL, 2, NULL),
(1, 6, 'Pendiente de presupuesto', NULL, NULL, NULL, NULL),
(1, 7, 'Pendiente de aceptacion', 'Esperando fin de servicio', NULL, 8, NULL),
(2, 2, 'Pendiente de aceptacion', 'Esperando fin de servicio', ' Hans', 1, 3),
(2, 3, 'En proceso de realizacion', 'Servicio finalizado correctamente', 'Cambio realizado', 3, 1),
(2, 6, 'Servicio rechazado', NULL, NULL, NULL, NULL),
(3, 4, 'Pendiente de aceptacion', NULL, NULL, NULL, NULL),
(3, 6, 'Servicio rechazado', NULL, NULL, NULL, NULL),
(4, 1, 'Presupuesto entregado', 'Esperando fin de servicio', NULL, 9, NULL),
(4, 6, 'Servicio rechazado', NULL, NULL, NULL, NULL),
(10, 7, 'Servicio rechazado', NULL, NULL, NULL, NULL),
(18, 7, 'Servicio rechazado', NULL, NULL, NULL, NULL),
(29, 9, 'Pendiente de aceptacion', NULL, NULL, NULL, NULL);

