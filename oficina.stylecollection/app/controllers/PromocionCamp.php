<?php 

if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor2"){

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
			$query = "UPDATE promocion SET estatus = 0 WHERE id_promocion = $id";
			$res1 = $lider->eliminar($query);
			if($res1['ejecucion']==true){
				$response = "1";
			}else{
				$response = "2"; // echo 'Error en la conexion con la bd';
			}
	}




	if(empty($_POST)){
		$promocion = $lider->consultarQuery("SELECT * FROM promocion WHERE promocion.id_campana = {$id_campana} and promocion.estatus = 1");
		$promocion_productos = $lider->consultarQuery("SELECT * FROM productos_promocion WHERE productos_promocion.id_campana = {$id_campana} and productos_promocion.estatus = 1");
		$promocion_premios = $lider->consultarQuery("SELECT * FROM premios_promocion WHERE premios_promocion.id_campana = {$id_campana} and premios_promocion.estatus = 1");
		$productos=$lider->consultarQuery("SELECT * FROM productos");
    	$premios=$lider->consultarQuery("SELECT * FROM premios");
		// print_r($promocion_productos);
		// $retos_campana = $lider->consultarQuery("SELECT * FROM premios, retos_campana WHERE premios.id_premio = retos_campana.id_premio and retos_campana.estatus = 1 and retos_campana.id_campana = {$id_campana}");
		
		// if($retos_campana['ejecucion']==1){
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

		// }else{
		//     require_once 'public/views/error404.php';
		// }
	}
}else{
	require_once 'public/views/error404.php';
}


?>