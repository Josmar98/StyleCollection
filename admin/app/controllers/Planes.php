<?php 
	
$amPlanes = 0;
$amPlanesR = 0;
$amPlanesC = 0;
$amPlanesE = 0;
$amPlanesB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Planes"){
      $amPlanes = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amPlanesR = 1;
      }
      if
        ($access['nombre_permiso'] == "Ver"){
        $amPlanesC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amPlanesE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amPlanesB = 1;
      }
    }
  }
}
if($amPlanesE == 1){
	$planes=$lider->consultar("planes");
	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		if($amPlanesB == 1){

			$query = "UPDATE planes SET estatus = 0 WHERE id_plan = $id";
			$res1 = $lider->eliminar($query);

			if($res1['ejecucion']==true){
				$response = "1";


					if(!empty($modulo) && !empty($accion)){
						$fecha = date('Y-m-d');
						$hora = date('H:i:a');
						$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Planes', 'Borrar', '{$fecha}', '{$hora}')";
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
		
		if($planes['ejecucion']==1){
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