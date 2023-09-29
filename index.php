<?php

session_start();
ini_set('date.timezone', 'america/caracas');
define('SERVERURL', 'StyleCollection');
define('ROOTURL', '/StyleCollection');
$fucsia = "#ED2A77";
$negro = "#000000";
$blanco = "#FFFFFF";
//"#2B73F7"
$color_btn_sweetalert = "#ED2A77";

// define('SERVERURL', $_SERVER['REQUEST_URI']);
// $route = $_SERVER['REQUEST_URI'];
// $_SESSION['temaSystem'] = "Oscuro";
// $_SESSION['temaSystem'] = "Claro";


	$url = "Home";
	if(!empty($_GET['route'])){
		$url = $_GET['route'];
	}
	if(!empty($_GET['action'])){
		$action = $_GET['action'];
	}
	if(!empty($_GET['cod'])){
		$cod = $_GET['cod'];
	}
	if(!empty($_GET['id'])){
		$id = $_GET['id'];
	}
	if (is_file(__DIR__.'/app/controllers/index.php')) {
		require_once __DIR__.'/app/controllers/index.php';
    }else{
        require_once __DIR__.'public/views/error404.php';
    }

    
    

####En caso de que no exista petición vía GET
