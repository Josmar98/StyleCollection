<?php 
	

// $amTasas = 0;
// $amTasasR = 0;
// $amTasasC = 0;
// $amTasasE = 0;
// $amTasasB = 0;
// foreach ($accesos as $access) {
//   if(!empty($access['id_acceso'])){
//     if($access['nombre_modulo'] == "Tasas"){
//       $amTasas = 1;
//       if($access['nombre_permiso'] == "Registrar"){
//         $amTasasR = 1;
//       }
//       if($access['nombre_permiso'] == "Ver"){
//         $amTasasC = 1;
//       }
//       if($access['nombre_permiso'] == "Editar"){
//         $amTasasE = 1;
//       }
//       if($access['nombre_permiso'] == "Borrar"){
//         $amTasasB = 1;
//       }
//     }
//   }
// }
// if($amTasasC == 1){
    $id_campana = $_GET['campaing'];
    $numero_campana = $_GET['n'];
    $anio_campana = $_GET['y'];
    $id_despacho = $_GET['dpid'];
    $num_despacho = $_GET['dp'];
    $menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";
    $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and campanas.numero_campana = {$numero_campana} and despachos.id_despacho = {$id_despacho} and despachos.numero_despacho = {$num_despacho}");
    $pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1 ORDER BY pagos_despachos.id_pago_despacho ASC;");
    $despacho = $despachos[0];
	$estados="";
	
	
	$fechaActualHoy = date('Y-m-d');
	$numDiaHoy= date('w');
	$dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
	$numDiasHabiles = 0;
	$numDiasMenos = 0;
	// $diaHoy = $dias[date('w')];
	$sentencesFechasLimites="";
	if(!empty($_GET['admin'])){
		$estados="Abonado";
	}else{
		$estados="Reportado";
		while($numDiasHabiles<7){
			$numDiasMenos++;
			$numDay = date('w', time()-($numDiasMenos*(24*3600)));
			$fechaNew = date('Y-m-d', time()-($numDiasMenos*(24*3600)));
			if($numDay!=0 && $numDay!=6){
				$numDiasHabiles++;
			}			
		}
		$sentencesFechasLimites="and eficoin_divisas.fecha_pago BETWEEN '{$fechaNew}' and '{$fechaActualHoy}' ";
		// if($numDiaHoy!=0 && $numDiaHoy!=6){
		// 	echo $dias[1]." | ";
		// 	echo $dias[2]." | ";
		// 	echo $dias[3]." | ";
		// 	echo $dias[4]." | ";
		// 	echo $dias[5]." | ";
		// }
	}
	if($_SESSION['nombre_rol']=="Vendedor"){
		$queryEfi = "SELECT * FROM eficoin_divisas, clientes WHERE eficoin_divisas.id_cliente=clientes.id_cliente and eficoin_divisas.estatus = 1 and eficoin_divisas.estado_pago='{$estados}' and eficoin_divisas.id_campana={$id_campana} {$sentencesFechasLimites} and eficoin_divisas.id_cliente={$_SESSION['id_cliente']} ORDER BY eficoin_divisas.fecha_registro DESC;";
	}else{
		$queryEfi="SELECT * FROM eficoin_divisas, clientes WHERE eficoin_divisas.id_cliente=clientes.id_cliente and eficoin_divisas.estatus = 1 and eficoin_divisas.estado_pago='{$estados}' and eficoin_divisas.id_campana={$id_campana} {$sentencesFechasLimites} ORDER BY eficoin_divisas.fecha_registro DESC;";
	}
	$eficoins=$lider->consultarQuery($queryEfi);
	$detalleEficoin=$lider->consultarQuery("SELECT * FROM eficoin_detalle WHERE eficoin_detalle.estatus = 1 and eficoin_detalle.id_campana={$id_campana}");
	// print_r($eficoins);
    $rutaRecarga = $menu3."route=".$_GET['route'];
    // echo "<br><br>";
	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

			$query = "UPDATE eficoin_divisas SET estatus = 0 WHERE id_eficoin_div = {$id}";
			$res1 = $lider->eliminar($query);

			if($res1['ejecucion']==true){
				$response = "1";

					if(!empty($modulo) && !empty($accion)){
						$fecha = date('Y-m-d');
						$hora = date('H:i:a');
						$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Eficoin', 'Borrar', '{$fecha}', '{$hora}')";
						$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
					}
			}else{
				$response = "2"; // echo 'Error en la conexion con la bd';
			}

			// if(!empty($action)){
			// 	if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
			// 		require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
			// 	}else{
			// 	    require_once 'public/views/error404.php';
			// 	}
			// }else{
			// 	if (is_file('public/views/'.$url.'.php')) {
			// 		require_once 'public/views/'.$url.'.php';
			// 	}else{
			// 	    require_once 'public/views/error404.php';
			// 	}
			// }
	}


	if(empty($_POST)){
		
		if($eficoins['ejecucion']==1){
			if(!empty($action)){
				if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
					require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
				}else{
				    require_once 'public/views/error404.php';
				}
			}else{
				if (is_file('public/views/'.$url.'.php')) {
					require_once 'public/views/'.$url.'.php';
				}else{
				    require_once 'public/views/error404.php';
				}
			}

		}else{
				    require_once 'public/views/error404.php';
				}
	}

// }else{
//     require_once 'public/views/error404.php';
// }

?>