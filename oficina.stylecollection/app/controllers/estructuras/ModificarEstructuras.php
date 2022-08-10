<?php

if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){


	if(!empty($_POST)){
		if(!empty($_POST['validarData'])){
			// print_r($_POST);
			$id_usuario = $_POST['analista'];
			$query = "SELECT * FROM estructuras WHERE analista = $id_usuario";
			$res1 = $lider->consultarQuery($query);
			// print_r($res1);
			if($res1['ejecucion']==true){
				if(Count($res1)>1){
					$response = "1";
				}else{
					// $response = "9"; //echo "Registro ya guardado.";
					$res2 = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = $id_usuario and estatus = 0");
					if($res2['ejecucion']==true){
						if(Count($res2)>1){
							$res3 = $lider->modificar("UPDATE estructuras SET estatus = 1 WHERE analista = $id_usuario");
							if($res3['ejecucion']==true){
								$response = "1";
							}
						}else{
							$response = "9"; //echo "Registro ya guardado.";
						}
					}
				}
			}else{
				$response = "5"; // echo 'Error en la conexion con la bd';
			}
			echo $response;
		}
		if(empty($_POST['validarData']) && !empty($_POST['analista']) && empty($_POST['clientes']) && !empty($_POST['lideres'])){
			// print_r($_POST);
			$analista = $_POST['analista'];
			$lideres = $_POST['lideres'];
			$max = count($lideres);
			$result = 0;
			$exec = $lider->eliminar("DELETE from estructuras WHERE analista = $id");
		    if($exec['ejecucion']==true){
				foreach ($lideres as $id_cliente) {
					$query = "INSERT INTO estructuras (id_estructura, id_cliente, analista, estatus) VALUES (DEFAULT, {$id_cliente}, {$analista}, 1)";
					$exec = $lider->registrar($query, "estructuras", "id_estructura");
					if($exec['ejecucion']==true){
						$result += "1";
					}else{
						$result += "2";
					}
				}
				if($max == $result){
					$response = "1";
				}else{
					$response = "2";
				}
			}else{
				$response = "2";
			}


			$analistas = $lider->consultarQuery("SELECT * FROM clientes, usuarios, roles WHERE usuarios.id_cliente = clientes.id_cliente and usuarios.id_rol = roles.id_rol and (roles.nombre_rol = 'Analista' or roles.nombre_rol = 'Analista Supervisor') and usuarios.estatus = 1 and usuarios.id_usuario = {$id}");
			$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1");

			$estructurasAnalistas = $lider->consultarQuery("SELECT DISTINCT analista FROM estructuras WHERE estatus = 1 and analista = {$id}");
			$estructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE estatus = 1");

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
	}
	if(empty($_POST)){
		$analistas = $lider->consultarQuery("SELECT * FROM clientes, usuarios, roles WHERE usuarios.id_cliente = clientes.id_cliente and usuarios.id_rol = roles.id_rol and (roles.nombre_rol = 'Analista' or roles.nombre_rol = 'Analista Supervisor') and usuarios.estatus = 1 and usuarios.id_usuario = {$id}");
		$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1");

		$estructurasAnalistas = $lider->consultarQuery("SELECT DISTINCT analista FROM estructuras WHERE estatus = 1 and analista = {$id}");
		$estructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE estatus = 1");


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