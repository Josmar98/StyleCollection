<?php 
	
$amPremios = 0;
$amPremiosR = 0;
$amPremiosC = 0;
$amPremiosE = 0;
$amPremiosB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Premios"){
      $amPremios = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amPremiosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amPremiosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amPremiosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amPremiosB = 1;
      }
    }
  }
}
if($amPremiosC == 1){

	$premios=$lider->consultarQuery("SELECT * FROM premios WHERE estatus = 1 ORDER BY nombre_premio asc;");

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		if($amPremiosB == 1){

			$query = "UPDATE premios SET estatus = 0 WHERE id_premio = $id";
			$res1 = $lider->eliminar($query);

			if($res1['ejecucion']==true){
				$response = "1";

					if(!empty($modulo) && !empty($accion)){
						$fecha = date('Y-m-d');
						$hora = date('H:i:a');
						$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Premios', 'Borrar', '{$fecha}', '{$hora}')";
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
		}else{
		  require_once 'public/views/error404.php';
		}
	}
	
	if(empty($_POST)){
		// $fragancias = $lider->consultarQuery("SELECT * FROM productos_fragancias, fragancias WHERE fragancias.id_fragancia = productos_fragancias.id_fragancia");
		
		if($premios['ejecucion']==1){
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