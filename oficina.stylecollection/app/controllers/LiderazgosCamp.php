<?php 
	
$amLiderazgosCamp = 0;
$amLiderazgosCampR = 0;
$amLiderazgosCampC = 0;
$amLiderazgosCampE = 0;
$amLiderazgosCampB = 0;
foreach ($accesos as $access) {
	if(!empty($access['id_acceso'])){
	  if($access['nombre_modulo'] == "Liderazgos De Campaña"){
	    $amLiderazgosCamp = 1;
	    if($access['nombre_permiso'] == "Registrar"){
	      $amLiderazgosCampR = 1;
	    }
	    if($access['nombre_permiso'] == "Ver"){
	      $amLiderazgosCampC = 1;
	    }
	    if($access['nombre_permiso'] == "Editar"){
	      $amLiderazgosCampE = 1;
	    }
	    if($access['nombre_permiso'] == "Borrar"){
	      $amLiderazgosCampB = 1;
	    }
	  }
	}
}
if($amLiderazgosCampC == 1){

  $id_campana = $_GET['campaing'];
  $numero_campana = $_GET['n'];
  $anio_campana = $_GET['y'];

  $id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";


	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
  		if($amLiderazgosCampB == 1){

			$query = "UPDATE liderazgos_campana SET estatus = 0 WHERE id_lc = $id";
			$res1 = $lider->eliminar($query);
			if($res1['ejecucion']==true){
				$response = "1";

		            if(!empty($modulo) && !empty($accion)){
		              $fecha = date('Y-m-d');
		              $hora = date('H:i:a');
		              $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Liderazgos de Campaña, 'Borrar', '{$fecha}', '{$hora}')";
		              $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
		            }
			}else{
				$response = "2"; // echo 'Error en la conexion con la bd';
			}
		}else{
			require_once 'public/views/error404.php';
		}
	}

	if(empty($_POST)){
		$query = "SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1 and liderazgos_campana.id_despacho = {$id_despacho} ORDER BY liderazgos.id_liderazgo ASC";
		$liderazgos = $lider->consultarQuery($query);
		if($liderazgos['ejecucion']==1){
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