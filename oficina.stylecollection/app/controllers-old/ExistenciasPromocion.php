<?php 

if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){

  
	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

		$query = "UPDATE existencias_promocion SET estatus = 0 WHERE id_existencia_promocion = $id";
		$res1 = $lider->eliminar($query);

		if($res1['ejecucion']==true){
			$response = "1";
	        // if(!empty($modulo) && !empty($accion)){
	        //   $fecha = date('Y-m-d');
	        //   $hora = date('H:i:a');
	        //   $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Existencias', 'Borrar', '{$fecha}', '{$hora}')";
	        //   $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
	        // }
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}

	}




	if(empty($_POST)){
    $existencias = $lider->consultarQuery("SELECT * FROM promocion, existencias_promocion WHERE existencias_promocion.id_promocion = promocion.id_promocion and  existencias_promocion.estatus = 1 and existencias_promocion.id_campana = {$id_campana}");

		if($existencias['ejecucion']==1){
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