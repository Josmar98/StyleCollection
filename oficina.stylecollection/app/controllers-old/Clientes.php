<?php 
	
$amClientes = 0;
$amClientesR = 0;
$amClientesC = 0;
$amClientesE = 0;
$amClientesB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Clientes"){
      $amClientes = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amClientesR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amClientesC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amClientesE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amClientesB = 1;
      }

    }
  }
}
if($amClientesC == 1){

	$clientes=$lider->consultar("clientes");

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		if($amClientesB == 1){

			$query = "UPDATE clientes SET estatus = 0 WHERE id_cliente = $id";
			$res1 = $lider->eliminar($query);
			if($res1['ejecucion']==true){
				$response = "1";

		        if(!empty($modulo) && !empty($accion)){
		          $fecha = date('Y-m-d');
		          $hora = date('H:i:a');
		          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Clientes', 'Borrar', '{$fecha}', '{$hora}')";
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
		if($clientes['ejecucion']==1){
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