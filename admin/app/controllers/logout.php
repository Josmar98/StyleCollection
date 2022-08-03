<?php 
	
            // if(!empty($modulo) && !empty($accion)){
            //   $fecha = date('Y-m-d');
            //   $hora = date('H:i:a');
            //   $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Sistema', 'Cierre de sesion', '{$fecha}', '{$hora}')";
            //   $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
            // }
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
	unset($_SESSION['recuerdamePAge']);
	unset($_SESSION['cuentaUsuarioPage']);	
	unset($_SESSION['timeLimiteSystemPage']);
	session_unset();
	session_destroy();

    header("location:./");
?>