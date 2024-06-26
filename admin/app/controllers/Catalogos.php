<?php 

// if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista2" || $_SESSION['nombre_rol']=="Analista Supervisor2" ){

	$catalogos=$lider->consultarQuery("SELECT * FROM ccatalogos WHERE estatus = 1 ORDER BY ccatalogos.codigo_catalogo ASC;");
	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		$query = "UPDATE ccatalogos SET estatus = 0 WHERE codigo_catalogo = '{$id}'";
		$res1 = $lider->eliminar($query);
		if($res1['ejecucion']==true){
			$response = "1";
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
	}
	if(empty($_POST)){
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

// }else{
//     require_once 'public/views/error404.php';
// }

?>