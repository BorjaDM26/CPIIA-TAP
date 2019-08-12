<?php 
	require_once 'baseDatos.php';
	$index = 'cpiia-tap/';
	$curPage = basename($_SERVER['PHP_SELF']);
	$porPagina = 10; // Número máximo de filas a mostrar en una tabla
	
	$estadosInscripcion = [
	    'Esperando turno' => 'Esperando turno',
	    'Turno asignado' => 'Turno asignado',
	    'Turno pendiente de revision' => 'Turno pendiente de revision',
	];
	$estadosSolicitud = [
	    'Pendiente de revision' => 'Pendiente de revision',
	    'Pendiente de presupuesto' => 'Pendiente de presupuesto',
	    'Pendiente de aceptacion del presupuesto' => 'Pendiente de aceptacion del presupuesto',
	    'En desarrollo' => 'En desarrollo',
	    'Finalizada' => 'Finalizada',
	    'Cancelada' => 'Cancelada',
	];
	$estadosServicio = [
	    'Pendiente de aceptacion' => 'Pendiente de aceptacion',
	    'Pendiente de presupuesto' => 'Pendiente de presupuesto',
	    'Presupuesto entregado' => 'Presupuesto entregado',
	    'En proceso de realizacion' => 'En proceso de realizacion',
	    'Proyecto finalizado' => 'Proyecto finalizado',
	    'Servicio rechazado' => 'Servicio rechazado',
	];
	$estadosVisado = [
	    'Esperando fin de servicio' => 'Esperando fin de servicio',
	    'Revisando' => 'Revisando',
	    'Servicio finalizado correctamente' => 'Servicio finalizado correctamente',
	    'Servicio finalizado con errores' => 'Servicio finalizado con errores',
	];

	
	// Generación de un número aleatorio para la creación de la contraseña temporal
    function numeroAleatorio($length) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	// Cálculo de los números a mostrar en la paginación de las tablas
	function paginacionBotones($maxPaginas, $paginaActual){
        if($maxPaginas <= 5){
        	$paginacionBotones=['Inicio'=>1, 'Fin'=>$maxPaginas];
        } elseif ($paginaActual-2<1){
        	$paginacionBotones=['Inicio'=>1, 'Fin'=>5];
        } else if ($paginaActual+2>$maxPaginas){
        	$paginacionBotones=['Inicio'=>$maxPaginas-4, 'Fin'=>$maxPaginas];
        } else {
        	$paginacionBotones=['Inicio'=>$paginaActual-2, 'Fin'=>$paginaActual+2];
        }
        return $paginacionBotones;
    }

	// Envío de correo con las credenciales de inicio de sesión al crear un usuario
    function correoAltaColegiado($numColegiado, $pass, $emailDestinatario, $nombreDestinatario){
        $asunto = utf8_decode('Alta de Colegiado en el Turno de Actuación Profesional del CPIIA');
        $contenido = "D/Dª $nombreDestinatario, ha sido usted dado/a de alta en el sistema de Turnos de Actuación Profesional (TAP) del Colegio Profesional de Ingeniería en Informática de Andalucía (CPIIA). \r\n \r\n Sus datos de acceso son:
        	-Número de Colegiado: $numColegiado
        	-Contraseña: $pass \r\n \r\n Una vez inicie sesión con sus credenciales, podrá modificar su contraseña desde su perfil.";

        mail($emailDestinatario, $asunto, $contenido);
    }

    // Envío de correo al crear una solicitud de actuación
    function correoCrearSolicitudActuacion($nombreSolicitante, $email, $telefono, $tipoLista, $provincia, $visado, $descripcion){
        $asunto = utf8_decode('Solicitud de Actuación en el TAP del CPIIA');
        $contenido = "$nombreSolicitante, gracias por confiar el Colegio Profesional de Ingeniería en Informática y su servicio de Turnos de actuación profesional. \r\n Su solicitud de actuación ha sido satisfactoriamente registrada y está siendo validada por la comisión pertinente. \r\n \r\n Datos de la solicitud:
        	-Nombre del solicitante: $nombreSolicitante
        	-Correo electrónico: $email
        	-Teléfono de contacto: $telefono
        	-Tipo de lista: $tipoLista
        	-Provincia: $provincia
        	-Visado: $visado
        	-Descripción: $descripcion";

        mail($email, $asunto, $contenido);
    }

    // Envío de correo al crear una solicitud de actuación
    function correoAsignacionProyecto($datos, $funcion){
        $asunto = utf8_decode('Solicitud de Actuación Asignada');
        $contenido = $datos['Encargado'].", le ha sido asignada una solicitud de actuación a través del TAP del CPIIA. 

    Lo datos de la solicitud son los mostrados a continuación:
    	-Identificador del proyecto: ".$datos['IdSolicitudAct']."
    	-Nombre del solicitante: ".$datos['Solicitante']."
    	-Correo electrónico: ".$datos['EmailSolicitante']."
    	-Teléfono de contacto: ".$datos['Telefono']."
    	-Tipo de lista: ".$datos['TipoLista']."
    	-Territorio: ".$datos['Territorio']."
    	-Visado: ".$datos['Visado']."
    	-Descripción: [[".$datos['Descripcion']."]]

    A partir de la recepción de este correo, tiene usted un plazo de dos días laborables para aceptar o rechazar el proyecto, y mandar un primer correo electrónico de contacto al cliente, en el que pondrá a la Comisión de TAP con copia oculta.";

        mail($datos['EmailEncargado'], $asunto, $contenido);
    }
?>