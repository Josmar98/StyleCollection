<?php 
$amServicios = 0;
$amServiciosR = 0;
$amServiciosC = 0;
$amServiciosE = 0;
$amServiciosB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
	if($access['nombre_modulo'] == "Servicios"){
	  $amServicios = 1;
	  if($access['nombre_permiso'] == "Registrar"){
		$amServiciosR = 1;
	  }
	  if($access['nombre_permiso'] == "Ver"){
		$amServiciosC = 1;
	  }
	  if($access['nombre_permiso'] == "Editar"){
		$amServiciosE = 1;
	  }
	  if($access['nombre_permiso'] == "Borrar"){
		$amServiciosB = 1;
	  }
	}
  }
}
if($amServiciosC == 1){
	
	$limitesOpciones = 10;
	$limitesElementos = 10;

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		$query = "UPDATE servicio SET estatus = 0 WHERE id_servicio = $id";
		$res1 = $lider->eliminar($query);
		if($res1['ejecucion']==true){
			$response = "1";
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
	}




	if(empty($_POST)){
		$servicio = $lider->consultarQuery("SELECT * FROM servicio, servicioss WHERE servicioss.id_servicioss=servicio.id_servicioss and servicio.id_campana = {$id_campana} and servicio.estatus = 1");
		// print_r($servicio);
		// $promocion_productos = $lider->consultarQuery("SELECT * FROM productos_promocion WHERE productos_promocion.id_campana = {$id_campana} and productos_promocion.estatus = 1");
		// $promocion_premios = $lider->consultarQuery("SELECT * FROM premios_promocion WHERE premios_promocion.id_campana = {$id_campana} and premios_promocion.estatus = 1");
		// $productos=$lider->consultarQuery("SELECT * FROM productos");
    	// $premios=$lider->consultarQuery("SELECT * FROM premios");
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