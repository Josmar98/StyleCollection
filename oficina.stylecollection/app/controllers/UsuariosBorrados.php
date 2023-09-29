<?php 
	
if($_SESSION['nombre_rol']=="Superusuario"){
	$usuarioss=$lider->consultarQuery("SELECT * FROM usuarios WHERE id_usuario > 1 and estatus = 0 ORDER BY nombre_usuario asc;");
	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

		$query = "UPDATE usuarios SET estatus = 1 WHERE id_usuario = $id";
		$res1 = $lider->eliminar($query);

		if($res1['ejecucion']==true){
			$response = "1";

				if(!empty($modulo) && !empty($accion)){
					$fecha = date('Y-m-d');
					$hora = date('H:i:a');
					$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Usuarios', 'Restaurar', '{$fecha}', '{$hora}')";
					$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
				}
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
	}

	if(empty($_POST)){
		$usuarioss = $lider->consultarQuery("SELECT * FROM roles, usuarios, clientes WHERE roles.id_rol = usuarios.id_rol and clientes.id_cliente = usuarios.id_cliente and usuarios.estatus = 0 and usuarios.id_usuario > 1");
		if($usuarioss['ejecucion']==1){
			if(!empty($action)){
				if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
					require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
				}else{
				    require_once 'public/views/error404.php';
				}
			}else{
				if (is_file('public/views/'.$url.'.php')) {
					require_once 'public/views/'.$url.'.php';
				}else{
				    require_once 'public/views/error404.php';
				}
			}

		}else{
				    require_once 'public/views/error404.php';
				}
	}

}else{
    require_once 'public/views/error404.php';
}

?>