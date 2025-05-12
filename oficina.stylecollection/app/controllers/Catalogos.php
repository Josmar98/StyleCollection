<?php 
$amCatalogos = 0;
$amCatalogosR = 0;
$amCatalogosC = 0;
$amCatalogosE = 0;
$amCatalogosB = 0;
foreach ($accesos as $access) {
	if(!empty($access['id_acceso'])){
	  if($access['nombre_modulo'] == "Catalogos"){
		$amCatalogos = 1;
		if($access['nombre_permiso'] == "Registrar"){
		  $amCatalogosR = 1;
		}
		if($access['nombre_permiso'] == "Ver"){
		  $amCatalogosC = 1;
		}
		if($access['nombre_permiso'] == "Editar"){
		  $amCatalogosE = 1;
		}
		if($access['nombre_permiso'] == "Borrar"){
		  $amCatalogosB = 1;
		}
	  }
	}
  }
if($amCatalogosC){
// if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor2" ){

	$catalogos=$lider->consultarQuery("SELECT * FROM catalogos WHERE estatus = 1 ORDER BY cantidad_gemas ASC;");

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
			$query = "UPDATE catalogos SET estatus = 0 WHERE id_catalogo = $id";
			$res1 = $lider->eliminar($query);

			if($res1['ejecucion']==true){
				$response = "1";

					if(!empty($modulo) && !empty($accion)){
						$fecha = date('Y-m-d');
						$hora = date('H:i:a');
						$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Catalogos', 'Borrar', '{$fecha}', '{$hora}')";
						$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
					}
			}else{
				$response = "2"; // echo 'Error en la conexion con la bd';
			}
	}


	if(empty($_POST)){
		$cantidades = $lider->consultarQuery("SELECT DISTINCT cantidad_gemas FROM catalogos WHERE estatus = 1 ORDER BY cantidad_gemas ASC");
		// print_r($cantidades);
		// foreach ($cantidades as $key) {
		// 	echo "Cantidad: ".$key['cantidad_gemas']."<br>";
		// }
		if($catalogos['ejecucion']==1){
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