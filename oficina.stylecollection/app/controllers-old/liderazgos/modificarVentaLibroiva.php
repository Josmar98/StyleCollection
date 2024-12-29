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
if($amLiderazgosE == 1){

		if(!empty($_POST['validarData'])){
			$id = $_POST['id'];
			$query = "SELECT * FROM liderazgos WHERE id_liderazgo = $id";
			$res1 = $lider->consultarQuery($query);
			if($res1['ejecucion']==true){
				if(Count($res1)>1){
					$response = "1";
				}else{
					$response = "9"; //echo "Registro ya guardado.";
				}
			}else{
				$response = "5"; // echo 'Error en la conexion con la bd';
			}
			echo $response;
		}
		if(!empty($_POST['titulo'])){

			$id_liderazgo = $_POST['id'];
			$nombre_liderazgo = mb_strtoupper($_POST['titulo']);
			$color_liderazgo = mb_strtoupper($_POST['color']);
			
			$query = "UPDATE liderazgos SET nombre_liderazgo = '$nombre_liderazgo', color_liderazgo = '$color_liderazgo', estatus = 1 WHERE id_liderazgo = $id";
			$exec = $lider->modificar($query);
			if($exec['ejecucion']==true){
				$response = "1";


					if(!empty($modulo) && !empty($accion)){
		              $fecha = date('Y-m-d');
		              $hora = date('H:i:a');
		              $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Liderazgos', 'Editar', '{$fecha}', '{$hora}')";
		              $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
		            }
			}else{
				$response = "2";
			}

			$query = "SELECT * FROM liderazgos WHERE estatus = 1 and id_liderazgo = $id";
			$liderazgo=$lider->consultarQuery($query);
			$datas = $liderazgo[0];

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
		if(empty($_POST)){
			$query = "SELECT * FROM liderazgos WHERE estatus = 1 and id_liderazgo = $id";
			$liderazgo=$lider->consultarQuery($query);

			if(Count($liderazgo)>1){

				$datas = $liderazgo[0];
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