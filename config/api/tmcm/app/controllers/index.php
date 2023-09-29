<?php 
	if(!empty($_GET['route'])){
		$url = $_GET['route'];
	}else{
		$url = "Home";
	}
	
	if(is_file("app/controllers/".$url.".php")){
		require_once "app/controllers/".$url.".php";
	}else{
		require_once 'app/controllers/Home.php';
	}

?>