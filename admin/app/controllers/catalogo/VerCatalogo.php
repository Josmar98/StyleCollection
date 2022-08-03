<?php 


	$catalogos=$lider->consultarQuery("SELECT * FROM catalogos WHERE estatus = 1 ORDER BY cantidad_gemas asc;");
	if(empty($_POST)){
		$cantidades = $lider->consultarQuery("SELECT DISTINCT cantidad_gemas FROM catalogos WHERE estatus = 1 ORDER BY cantidad_gemas ASC;");
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


?>