<?php 


if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo" ||  $_SESSION['nombre_rol']=="Superusuario"){
	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];

	if(!empty($_POST['precio']) ){
		$precio = $_POST['precio'];

		$query = "UPDATE precio_gema SET precio_gema='{$precio}', estatus=1 WHERE id_precio_gema={$id}";
		$exec = $lider->modificar($query);
		if($exec['ejecucion']==true ){
			$response = "1";
		}else{
			$response = "2";
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
	}


    if(empty($_POST)){
    	$precio_gema = $lider->consultarQuery("SELECT * FROM precio_gema WHERE id_campana = {$id_campana} and estatus = 1 and id_precio_gema = {$id}");
    	if(count($precio_gema)>1){
    		$precio_gema = $precio_gema[0];
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