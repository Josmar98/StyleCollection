<?php 
	

$amTasas = 0;
$amTasasR = 0;
$amTasasC = 0;
$amTasasE = 0;
$amTasasB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Tasas"){
      $amTasas = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amTasasR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amTasasC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amTasasE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amTasasB = 1;
      }
    }
  }
}
if($amTasasC == 1){
	
	$eficoins=$lider->consultarQuery("SELECT * FROM eficoin WHERE estatus = 1 ORDER BY fecha_tasa asc;");

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		if($amTasasB == 1){

			$query = "UPDATE eficoin SET estatus = 0 WHERE id_eficoin = $id";
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
		}else{
		    require_once 'public/views/error404.php';
		}
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

}else{
    require_once 'public/views/error404.php';
}

?>