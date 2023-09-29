<?php 
	
            // if(!empty($modulo) && !empty($accion)){
            //   $fecha = date('Y-m-d');
            //   $hora = date('H:i:a');
            //   $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['home']['id_usuario']}, 'Sistema', 'Cierre de sesion', '{$fecha}', '{$hora}')";
            //   $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
            // }
	unset($_SESSION['home']['cuenta']);
    // unset($_SESSION['home']['accesos']);
	unset($_SESSION['home']['id_usuario']);
	// unset($_SESSION['home']['id_rol']);
	// unset($_SESSION['home']['nombre_rol']);
	unset($_SESSION['home']['id_cliente']);
	unset($_SESSION['home']['username']);
	unset($_SESSION['home']['pass']);
	unset($_SESSION['home']['home_style']);
	unset($_SESSION['home']['admin1']);
	unset($_SESSION['home']['recuerdame']);
	unset($_SESSION['home']['cuentaUsuario']);	
	unset($_SESSION['home']['timeLimiteSystem']);
	session_unset();
	session_destroy();

    header("location:./");
?>