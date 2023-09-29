<?php

session_start();
ini_set('date.timezone', 'america/caracas');
define('SERVERURL', 'StyleCollection');
define('ROOTURL', '/StyleCollection/admin');
//ruta = "http://127.0.0.1/stylecollection/config/api/tmcm/";
//ruta = "https://stylecollection.org/config/api/tmcm/";

if (is_file(__DIR__.'/app/controllers/index.php')) {
	require_once __DIR__.'/app/controllers/index.php';
}else{
	require_once __DIR__.'public/views/error404.php';
}
