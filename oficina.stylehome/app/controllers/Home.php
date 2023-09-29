<?php 
if(strtolower($url)=="home"){
	if(!empty($action)){
		if($action=="Consultar"){
			if(empty($_POST)){
				$ciclos=$lider->consultarQuery("SELECT * FROM ciclos WHERE ciclos.estatus = 1");
				if (is_file('public/views/'.$url.'.php')) {
					require_once 'public/views/'.$url.'.php';
				}else{
					require_once 'public/views/error404.php';
				}
			}
		}
	}
}


?>