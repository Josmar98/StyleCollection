<?php 
	
$amEmpleados = 0;
$amEmpleadosR = 0;
$amEmpleadosC = 0;
$amEmpleadosE = 0;
$amEmpleadosB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Empleados"){
      $amEmpleados = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amEmpleadosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amEmpleadosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amEmpleadosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amEmpleadosB = 1;
      }

    }
  }
}
if($amEmpleadosC == 1){

	$empleados=$lider->consultar("empleados");

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		if($amEmpleadosB == 1){

			$query = "UPDATE empleados SET estatus = 0 WHERE id_empleado = $id";
			$res1 = $lider->eliminar($query);
			if($res1['ejecucion']==true){
				$response = "1";

		        if(!empty($modulo) && !empty($accion)){
		          $fecha = date('Y-m-d');
		          $hora = date('H:i:a');
		          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Empleados', 'Borrar', '{$fecha}', '{$hora}')";
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
		if($empleados['ejecucion']==1){
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