<?php 
	
$amDespachos = 0;
$amDespachosR = 0;
$amDespachosC = 0;
$amDespachosE = 0;
$amDespachosB = 0;

foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Despachos"){
      $amDespachos = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amDespachosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amDespachosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amDespachosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amDespachosB = 1;
      }
    }
  }
}
if($amDespachosC == 1){
	
	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
  $id_despacho = $_GET['dpid'];
  $num_despacho = $_GET['dp'];
  $menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

  $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and campanas.numero_campana = {$numero_campana} and despachos.id_despacho = {$id_despacho} and despachos.numero_despacho = {$num_despacho}");
  $pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1");
  $cantPagos=count($pagos_despacho)-1;
  $despacho = $despachos[0];

  $opInicial = $despacho['opcion_inicial'];
  $pagosObligatorios = $despacho['opcionInicialObligatorio'];
  $inObligatoria = $despacho['opcionOpcionalInicial'];

  $cantidadPagosDespachosFild = [];
  if($pagosObligatorios == "Y"){
    if($opInicial=="Y"){
        $sumAdd = 1;
        $cantidadPagosDespachosFild[0] = ['cantidad'=>0,   'name'=> "Inicial",   'id'=> "inicial"];
    }else{
      $sumAdd = 0;
    }
    for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
      $key = $cantidadPagosDespachos[$i];
      if($key['cantidad'] <= $despacho['cantidad_pagos']){
        $cantidadPagosDespachosFild[$i+$sumAdd] = $key;
      }
    }
  }
  $cantidadPagosDespachosFild;
  if($pagosObligatorios == "N"){
    // if($inObligatoria=="N"){
    //  $sumAdd = 1;
    //  $cantidadPagosDespachosFild[0] = ['cantidad'=>0,   'name'=> "Inicial",   'id'=> "inicial"];
    // }else{
      $sumAdd = 0;
    // }
    for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
      $key = $cantidadPagosDespachos[$i];
      if($key['cantidad'] <= $despacho['cantidad_pagos']){
        $cantidadPagosDespachosFild[$i+$sumAdd] = $key;
      }
    }
  }

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		if($amDespachosB == 1){
			$query = "UPDATE despachos_secundarios SET estatus = 0 WHERE id_despacho_sec = $id";
			$res1 = $lider->eliminar($query);

			if($res1['ejecucion']==true){
				$response = "1";
				// $query = "UPDATE despachos_secundarios_pagos SET estatus = 0 WHERE id_despacho = $id";
				// $res1 = $lider->eliminar($query);
				// if($res1['ejecucion']==true){
				// 	$query = "UPDATE colecciones_secundarios SET estatus = 0 WHERE id_despacho = $id";
				// 	$res1 = $lider->eliminar($query);
				// 	if($res1['ejecucion']==true){
				// 		$response = "1";
			  //       if(!empty($modulo) && !empty($accion)){
			  //         $fecha = date('Y-m-d');
			  //         $hora = date('H:i:a');
			  //         $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Colecciones', 'Borrar', '{$fecha}', '{$hora}')";
			  //         $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
			  //       }
				// 	}else{
				// 		$response = "2"; // echo 'Error en la conexion con la bd';
				// 	}
				// }else{
				// 	$response = "2";
				// }
			}else{
				$response = "2"; // echo 'Error en la conexion con la bd';
			}

		}else{
	    	require_once 'public/views/error404.php';
		}
	}



	if(empty($_POST)){
		$despachos=$lider->consultarQuery("SELECT * FROM despachos WHERE id_campana = {$id_campana} and id_despacho = {$id_despacho} and estatus = 1");
		$despachosSec=$lider->consultarQuery("SELECT * FROM despachos_secundarios WHERE id_despacho = {$id_despacho} and despachos_secundarios.estatus = 1");
		$pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.estatus = 1 and pagos_despachos.estatus = 1");

		if($despachos['ejecucion']==1){
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


}else{
    require_once 'public/views/error404.php';
}

?>