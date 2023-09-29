<?php 
if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		$query = "UPDATE estructuras SET estatus = 0 WHERE analista = $id";
		$res1 = $lider->eliminar($query);
		if($res1['ejecucion']==true){
			$response = "1";
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
	}
	if(empty($_POST)){
		$estructurasAnalistas = $lider->consultarQuery("SELECT DISTINCT analista FROM estructuras WHERE estatus = 1");
		$analistas = $lider->consultarQuery("SELECT * FROM clientes, usuarios, roles WHERE usuarios.id_cliente = clientes.id_cliente and usuarios.id_rol = roles.id_rol and (roles.nombre_rol = 'Analista' or roles.nombre_rol = 'Analista Supervisor') and usuarios.estatus = 1");
		// $usuarios = $lider->consultarQuery("SELECT * FROM roles, usuarios, clientes WHERE roles.id_rol = usuarios.id_rol and clientes.id_cliente = usuarios.id_cliente and usuarios.estatus = 1");
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
	}
}else{
    require_once 'public/views/error404.php';
}

?>