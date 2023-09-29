<?php

session_start();
ini_set('date.timezone', 'america/caracas');
define('SERVERURL', 'StyleHome');
define('ROOTURL', '/StyleCollection/oficina.stylehome');
// $fucsia = "#ED2A77";
// color:#CA2B6A;
// new Color: #BF0D78
// #00ADA7
// #07B0AB  // #2E9491
$fucsia = "#00ADA7";
// #EA018C
// #BF0D78
$negro = "#000000";
$blanco = "#FFFFFF";
//"#2B73F7"
// 237
// 42
// 119
$PRegistrar = "Registrar";
$PConsultar = "Ver";
$PModificar = "Editar";
$PEliminar = "Borrar";

// $color_btn_sweetalert = "#ED2A77";
// $color_btn_sweetalert = "#EA018C";
$colorPrimaryAll = "#00ADA7";
$color_btn_sweetalert = "#00ADA7";
if(isset($_SESSION['home']['recuerdame'])){
	if($_SESSION['home']['recuerdame']==0){
		$timeLimiteExits = 60*30;
		if(!isset($_SESSION['home']['timeLimiteSystem'])){
			$_SESSION['home']['timeLimiteSystem'] = time();
		}
		$resTime = time()-$_SESSION['home']['timeLimiteSystem'];
		if($resTime > $timeLimiteExits){
			unset($_SESSION['home']['cuenta']);
			unset($_SESSION['home']['accesos']);
			unset($_SESSION['home']['id_usuario']);
			unset($_SESSION['home']['id_rol']);
			unset($_SESSION['home']['nombre_rol']);
			unset($_SESSION['home']['id_cliente']);
			unset($_SESSION['home']['username']);
			unset($_SESSION['home']['pass']);
			unset($_SESSION['home']['home_style']);
			unset($_SESSION['home']['admin1']);
			unset($_SESSION['home']['recuerdame']);
			unset($_SESSION['home']['timeLimiteSystem']);
			session_unset();
			session_destroy();
			header("location:./");
		}
	}
	$_SESSION['home']['timeLimiteSystem'] = time();
}

$pal = "Cuota";
$cantidadPagosCiclos = [
	0=> ['numero_cuota'=>0,		'name'=> "Inicial ".$pal,		'id'=> "inicial_",			'cod'=>'INI'],
	1=> ['numero_cuota'=>1,		'name'=> "Primera ".$pal,		'id'=> "primera_",			'cod'=>'1ERA'],
	2=> ['numero_cuota'=>2,		'name'=> "Segunda ".$pal,		'id'=> "segunda_",			'cod'=>'2DA'],
	3=> ['numero_cuota'=>3,		'name'=> "Tercera ".$pal,		'id'=> "tercera_",			'cod'=>'3ERA'],
	4=> ['numero_cuota'=>4,		'name'=> "Cuarta ".$pal,		'id'=> "cuarta_",			'cod'=>'4TA'],
	5=> ['numero_cuota'=>5,		'name'=> "Quinta ".$pal,		'id'=> "quinta_",			'cod'=>'5TA'],
	6=> ['numero_cuota'=>6,		'name'=> "Sexta ".$pal,			'id'=> "sexta_",			'cod'=>'6TA'],
	7=> ['numero_cuota'=>7,		'name'=> "Septima ".$pal,		'id'=> "septima_",			'cod'=>'7MA'],
	8=> ['numero_cuota'=>8,		'name'=> "Octava ".$pal,		'id'=> "octava_",			'cod'=>'8VA'],
	9=> ['numero_cuota'=>9,		'name'=> "Novena ".$pal,		'id'=> "novena_",			'cod'=>'9NA'],
	10=> ['numero_cuota'=>10,	'name'=> "Decima ".$pal,		'id'=> "decima_",			'cod'=>'10MA'],
	11=> ['numero_cuota'=>11,	'name'=> "Undecima ".$pal,		'id'=> "undecima_",			'cod'=>'11MA'],
	12=> ['numero_cuota'=>12,	'name'=> "Duodecima ".$pal,		'id'=> "doudecima_",		'cod'=>'12MA'],
	13=> ['numero_cuota'=>13,	'name'=> "Decimotercera ".$pal,	'id'=> "decimotercera_",	'cod'=>'13RA'],
	14=> ['numero_cuota'=>14,	'name'=> "Decimocuarto ".$pal,	'id'=> "decimocuarta_",		'cod'=>'14TA'],
	15=> ['numero_cuota'=>15,	'name'=> "Decimoquinta ".$pal,	'id'=> "decimoquinta_",		'cod'=>'15TA'],
	16=> ['numero_cuota'=>16,	'name'=> "Decimosexta ".$pal,	'id'=> "decimosexta_",		'cod'=>'16TA'],
	17=> ['numero_cuota'=>17,	'name'=> "Decimoseptima ".$pal,	'id'=> "decimoseptima_",	'cod'=>'17MA'],
	18=> ['numero_cuota'=>18,	'name'=> "Decimooctava ".$pal,	'id'=> "decimoctava_",		'cod'=>'18VA'],
	19=> ['numero_cuota'=>19,	'name'=> "Decimonovena ".$pal,	'id'=> "decimonovena",		'cod'=>'19NA'],
	20=> ['numero_cuota'=>20,	'name'=> "vigesima ".$pal,		'id'=> "vigesima_",			'cod'=>'20MA'],
];
// print_r(['arroz'=>'carmen']);
// print_r($_SESSION['home']);
// define('SERVERURL', $_SERVER['REQUEST_URI']);
// $route = $_SERVER['REQUEST_URI'];
// $_SESSION['home']['temaSystem'] = "Oscuro";
// $_SESSION['home']['temaSystem'] = "Claro";


// print_r($_SESSION['home']['cuentaPage']);
if(!empty($_SESSION['home']['id_usuario']) && !empty($_SESSION['home']['cuenta']) && !empty($_SESSION['home']['home_style'])){
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
	$cuenta=$_SESSION['home']['cuenta'];
	// $accesos=$_SESSION['home']['accesos'];
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
