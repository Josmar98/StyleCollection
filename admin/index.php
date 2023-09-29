<?php

session_start();
ini_set('date.timezone', 'america/caracas');
define('SERVERURL', 'StyleCollection');
define('ROOTURL', '/StyleCollection/admin');
// $fucsia = "#ED2A77";
// color:#CA2B6A;
// new Color: #BF0D78
$fucsia = "#EA018C";
$negro = "#000000";
$blanco = "#FFFFFF";
//"#2B73F7"
// 237
// 42
// 119

// $color_btn_sweetalert = "#ED2A77";
$color_btn_sweetalert = "#EA018C";
if(isset($_SESSION['recuerdamePage'])){
	if($_SESSION['recuerdamePage']==0){
		$timeLimiteExits = 60*30;
		if(!isset($_SESSION['timeLimiteSystemPage'])){
			$_SESSION['timeLimiteSystemPage'] = time();
		}
		$resTime = time()-$_SESSION['timeLimiteSystemPage'];
		if($resTime > $timeLimiteExits){
			unset($_SESSION['cuentaPage']);
			// unset($_SESSION['accesos']);
			unset($_SESSION['id_usuarioPage']);
			// unset($_SESSION['id_rol']);
			// unset($_SESSION['nombre_rol']);
			unset($_SESSION['id_clientePage']);
			unset($_SESSION['usernamePage']);
			unset($_SESSION['passPage']);
			unset($_SESSION['page_style']);
			unset($_SESSION['admin1Page']);
			unset($_SESSION['recuerdamePage']);
			unset($_SESSION['timeLimiteSystemPage']);
			session_unset();
			session_destroy();
			header("location:./");
		}
	}
	$_SESSION['timeLimiteSystemPage'] = time();
}
// print_r(['arroz'=>'carmen']);
// print_r($_SESSION);
// define('SERVERURL', $_SERVER['REQUEST_URI']);
// $route = $_SERVER['REQUEST_URI'];
// $_SESSION['temaSystem'] = "Oscuro";
// $_SESSION['temaSystem'] = "Claro";


// print_r($_SESSION['cuentaPage']);
if(!empty($_SESSION['id_usuarioPage']) && !empty($_SESSION['cuentaPage']) && !empty($_SESSION['page_style'])){
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
	$cuenta=$_SESSION['cuentaPage'];
	// $accesos=$_SESSION['accesos'];
	if (is_file(__DIR__.'/app/controllers/index.php')) {
		require_once __DIR__.'/app/controllers/index.php';
    }else{
        require_once __DIR__.'public/views/error404.php';
    }

####En caso de que no exista petición vía GET
} else {
	$url = "login";
	if (is_file(__DIR__.'/app/controllers/index.php')) {
		require_once __DIR__.'/app/controllers/index.php';
    }else{
        require_once __DIR__.'public/views/error404.php';
    }
}
