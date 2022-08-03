<?php 

$amLiderazgos = 0;
$amLiderazgosR = 0;
$amLiderazgosC = 0;
$amLiderazgosE = 0;
$amLiderazgosB = 0;
foreach ($accesos as $access) {
if(!empty($access['id_acceso'])){
  if($access['nombre_modulo'] == "Liderazgos"){
    $amLiderazgos = 1;
    if($access['nombre_permiso'] == "Registrar"){
      $amLiderazgosR = 1;
    }
    if($access['nombre_permiso'] == "Ver"){
      $amLiderazgosC = 1;
    }
    if($access['nombre_permiso'] == "Editar"){
      $amLiderazgosE = 1;
    }
    if($access['nombre_permiso'] == "Borrar"){
      $amLiderazgosB = 1;
    }
  }
}
}
if($amLiderazgosR == 1){

		if(!empty($_POST['validarData'])){
			$nombre_liderazgo = mb_strtoupper($_POST['nombre_liderazgo']);
			$query = "SELECT * FROM liderazgos WHERE nombre_liderazgo = '$nombre_liderazgo'";
			$res1 = $lider->consultarQuery($query);
			if($res1['ejecucion']==true){
				if(Count($res1)>1){
					// $response = "9"; //echo "Registro ya guardado.";
				  $res2 = $lider->consultarQuery("SELECT * FROM liderazgos WHERE nombre_liderazgo = '$nombre_liderazgo' and estatus = 0");
			      if($res2['ejecucion']==true){
			        if(Count($res2)>1){
			          $res3 = $lider->modificar("UPDATE liderazgos SET estatus = 1 WHERE nombre_liderazgo = '$nombre_liderazgo'");
			          if($res3['ejecucion']==true){
			            $response = "1";
			          }
			        }else{
			          $response = "9"; //echo "Registro ya guardado.";
			        }
			      }


				}else{
					$response = "1";
				}
			}else{
				$response = "5"; // echo 'Error en la conexion con la bd';
			}
			echo $response;
		}
		if(!empty($_POST['titulo'])){

			$nombre_liderazgo = mb_strtoupper($_POST['titulo']);
			$color_liderazgo = mb_strtoupper($_POST['color']);


			$query = "INSERT INTO liderazgos (id_liderazgo, nombre_liderazgo, color_liderazgo, estatus) VALUES (DEFAULT, '$nombre_liderazgo', '$color_liderazgo', 1)";
			$exec = $lider->registrar($query, "liderazgos", "id_liderazgo");
			if($exec['ejecucion']==true){
				$response = "1";

					if(!empty($modulo) && !empty($accion)){
		              $fecha = date('Y-m-d');
		              $hora = date('H:i:a');
		              $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Liderazgos', 'Registrar', '{$fecha}', '{$hora}')";
		              $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
		            }
			}else{
				$response = "2"; //echo 'Error en SQL, no se guardaron los cambios';
			}
				
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


			// print_r($exec);
		}
		if(empty($_POST)){
			$liderazgos=$lider->consultar("liderazgos");
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
		}
}else{
	require_once 'public/views/error404.php';
}


?>