<?php 
	require_once 'baseDatos.php';
	$index = 'cpiia-tap/';
	$curPage 	 = basename($_SERVER['PHP_SELF']);
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
?>