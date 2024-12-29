<?php 
	
$amRetos = 0;
$amRetosR = 0;
$amRetosC = 0;
$amRetosE = 0;
$amRetosB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Retos"){
      $amRetos = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amRetosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amRetosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amRetosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amRetosB = 1;
      }
    }
  }
}
if($amRetosC == 1){

	$retos=$lider->consultarQuery("SELECT * FROM retosinv WHERE estatus=0");

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		if($amRetosB == 1){
			$query = "UPDATE retosinv SET estatus = 1 WHERE id_retoinv = $id";
			$res1 = $lider->eliminar($query);

			if($res1['ejecucion']==true){
				$response = "1";

		        if(!empty($modulo) && !empty($accion)){
		          $fecha = date('Y-m-d');
		          $hora = date('H:i:a');
		          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Retos de inventario', 'Restaurar', '{$fecha}', '{$hora}')";
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

		// $campanass = $lider->consultarQuery("SELECT * FROM productos_fragancias, fragancias WHERE fragancias.id_fragancia = productos_fragancias.id_fragancia");
		
		if($retos['ejecucion']==1){
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