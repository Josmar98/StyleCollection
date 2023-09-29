<?php

	$campanas=$lider->consultarQuery("SELECT * FROM campanas WHERE estatus = 1 and visibilidad = 1 ORDER BY id_campana DESC;");
	if (is_file('public/views/'.$url.'.php')) {
		require_once 'public/views/'.$url.'.php';
	}else{
		require_once 'public/views/error404.php';
	}

?>