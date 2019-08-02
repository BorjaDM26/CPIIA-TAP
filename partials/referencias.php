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
?>