<?php 
	
	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }

	// if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" ){
	// 	$campanas=$lider->consultar("campanas");
	// }else{
	// 	$campanas=$lider->consultarQuery("SELECT * FROM campanas WHERE estatus = 1 and visibilidad = 1");
	// }



if(empty($_POST)){
	$campanas=$lider->consultarQuery("SELECT * FROM campanas WHERE campanas.estatus = 1");
	// $campanass = $lider->consultarQuery("SELECT * FROM productos_fragancias, fragancias WHERE fragancias.id_fragancia = productos_fragancias.id_fragancia");
	// $fecha = date('Y-m-d');
	// $tasas = $lider->consultarQuery("SELECT * FROM tasa WHERE estatus = 1 and fecha_tasa = '$fecha'");
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


?>