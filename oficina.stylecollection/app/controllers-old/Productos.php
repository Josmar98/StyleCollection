<?php 

$amProductos = 0;
$amProductosR = 0;
$amProductosC = 0;
$amProductosE = 0;
$amProductosB = 0;
$amFragancias = 0;
$amFraganciasR = 0;
$amFraganciasC = 0;
$amFraganciasE = 0;
$amFraganciasB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Productos"){
      $amProductos = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amProductosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amProductosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amProductosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amProductosB = 1;
      }
    }
    if($access['nombre_modulo'] == "Fragancias"){
      $amFragancias = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amFraganciasR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amFraganciasC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amFraganciasE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amFraganciasB = 1;
      }
    }
  }
}
if($amProductosC == 1){
	
	$productos=$lider->consultarQuery("SELECT * FROM productos WHERE estatus = 1 ORDER BY producto asc;");

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		if($amFraganciasB == 1){

			$query = "UPDATE productos SET estatus = 0 WHERE id_producto = $id";
			$res1 = $lider->eliminar($query);

			if($res1['ejecucion']==true){
				$response = "1";

					if(!empty($modulo) && !empty($accion)){
						$fecha = date('Y-m-d');
						$hora = date('H:i:a');
						$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Productos', 'Borrar', '{$fecha}', '{$hora}')";
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
		$fragancias = $lider->consultarQuery("SELECT * FROM productos_fragancias, fragancias WHERE fragancias.id_fragancia = productos_fragancias.id_fragancia");
		
		if($productos['ejecucion']==1){
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