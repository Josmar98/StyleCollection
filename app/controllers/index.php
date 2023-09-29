<?php 



	if(is_file('app/models/modelsIndex.php')){
		require_once'app/models/modelsIndex.php';
	}
	if(is_file('../app/models/modelsIndex.php')){
		require_once'../app/models/modelsIndex.php';
	}
	$lider = new Models();

	if(!empty($action)){
		if(is_file("app/controllers/".strtolower($url)."/".$action.$url.".php")){
			require_once "app/controllers/".strtolower($url)."/".$action.$url.".php";
		}else{
		    require_once 'public/views/error404.php';
		}
	}else{
		if(is_file("app/controllers/".$url.".php")){
			require_once "app/controllers/".$url.".php";
		}else{
		    require_once 'public/views/error404.php';
		}
	}






 ?>