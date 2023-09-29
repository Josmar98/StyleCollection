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

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		if($amDespachosB == 1){
			$query = "UPDATE despachos SET estatus = 0 WHERE id_despacho = $id";
			$res1 = $lider->eliminar($query);

			if($res1['ejecucion']==true){
				// $response = "1";
				$query = "UPDATE pagos_despachos SET estatus = 0 WHERE id_despacho = $id";
				$res1 = $lider->eliminar($query);
				if($res1['ejecucion']==true){
					$query = "UPDATE colecciones SET estatus = 0 WHERE id_despacho = $id";
					$res1 = $lider->eliminar($query);
					if($res1['ejecucion']==true){
						$response = "1";
			        if(!empty($modulo) && !empty($accion)){
			          $fecha = date('Y-m-d');
			          $hora = date('H:i:a');
			          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Pedidos', 'Borrar', '{$fecha}', '{$hora}')";
			          $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
			        }
					}else{
						$response = "2"; // echo 'Error en la conexion con la bd';
					}
				}else{
					$response = "2";
				}
			}else{
				$response = "2"; // echo 'Error en la conexion con la bd';
			}

		}else{
	    	require_once 'public/views/error404.php';
		}
	}



	if(empty($_POST)){
		$despachos=$lider->consultarQuery("SELECT * FROM despachos WHERE id_campana = {$id_campana} and estatus = 1");
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