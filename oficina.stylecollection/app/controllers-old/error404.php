<?php 
	echo 'Hola';
	if (is_file(SERVERURL.'public/views/' . $url . '.php')) {
		require_once SERVERURL.'public/views/' . $url . '.php';
    }else{
        require_once SERVERURL.'public/views/error404.php';
    }

?>