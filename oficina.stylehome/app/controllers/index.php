<?php 
	if(mb_strtolower($url)==mb_strtolower("Home")){ $modulo = "Inicio"; }
	else if(mb_strtolower($url)==mb_strtolower("CHome")){ $modulo = "Pedidos ".$_GET['n']."/".$_GET['y']; }
	else if(mb_strtolower($url)==mb_strtolower("Clientes")){ $modulo = "Líderes"; }
	else if(mb_strtolower($url)==mb_strtolower("LiderazgosCiclos")){ $modulo = "Liderazgos de Ciclos"; }
	else if(mb_strtolower($url)==mb_strtolower("PuntosAutorizados")){ $modulo = "Puntos autorizados"; }
	else if(mb_strtolower($url)==mb_strtolower("Notass")){ $modulo = "Notas"; }
	else{ $modulo = $url; }


	$personalInterno = false;
	$personalExterno = false;
	$personalAdmin = false;
	if(!empty($_SESSION['home'])){
		if($_SESSION['home']['nombre_rol'] == "Administrativo" || $_SESSION['home']['nombre_rol'] == "Administrador" || $_SESSION['home']['nombre_rol'] == "Superusuario" || $_SESSION['home']['nombre_rol']=="Analista Supervisor" || $_SESSION['home']['nombre_rol'] == "Analista2"){
			$personalInterno = true;
		}
		if($_SESSION['home']['nombre_rol'] == "Vendedor"){
			$personalExterno = true;
		}
		if($_SESSION['home']['nombre_rol'] == "Superusuario" || $_SESSION['home']['nombre_rol'] == "Administrador" || $_SESSION['home']['nombre_rol'] == "Administrativo2" || $_SESSION['home']['nombre_rol']=="Analista Supervisor2" || $_SESSION['home']['nombre_rol'] == "Analista2"){
			$personalAdmin = true;
		}
	}

	if(is_file('app/models/indexModels.php')){
		require_once'app/models/indexModels.php';
	}
	if(is_file('../app/models/indexModels.php')){
		require_once'../app/models/indexModels.php';
	}
	if(is_file('app/models/indexModels3.php')){
		require_once'app/models/indexModels3.php';
	}
	if(is_file('../app/models/indexModels3.php')){
		require_once'../app/models/indexModels3.php';
	}
	$lider = new Models();
	$lid3r = new Models3();

	if(empty($action)){
		$action = "Consultar";
	}
	$fechaActual = date("Y-m-d");
	$horaActual = date("h:ia");
	// $fechaActual = "2023-09-10";
	

	if(is_file("app/controllers/".$url.".php")){
		require_once "app/controllers/".$url.".php";
	}else{
	    require_once 'public/views/error404.php';
	}
?>