<?php 
	
            if(!empty($modulo) && !empty($accion)){
              $fecha = date('Y-m-d');
              $hora = date('H:i:a');
              $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Sistema', 'Cierre de sesion', '{$fecha}', '{$hora}')";
              $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
            }
	unset($_SESSION['cuenta']);
    unset($_SESSION['accesos']);
	unset($_SESSION['id_usuario']);
	unset($_SESSION['id_rol']);
	unset($_SESSION['nombre_rol']);
	unset($_SESSION['id_cliente']);
	unset($_SESSION['username']);
	unset($_SESSION['pass']);
	unset($_SESSION['system_style']);
	unset($_SESSION['admin1']);
	unset($_SESSION['recuerdame']);
	unset($_SESSION['cuentaUsuario']);	
	unset($_SESSION['timeLimiteSystem']);
	session_unset();
	session_destroy();

    header("location:./");
?>