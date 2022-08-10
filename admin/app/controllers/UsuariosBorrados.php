<?php 
	
	$usuarioss=$lider->consultarQuery("SELECT * FROM usuarios WHERE id_usuario > 1 and estatus = 0 ORDER BY nombre_usuario asc;");
	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

		$query = "UPDATE usuarios SET estatus = 1 WHERE id_usuario = $id";
		$res1 = $lider->eliminar($query);

		if($res1['ejecucion']==true){
			$response = "1";
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
	}

	if(empty($_POST)){
		$usuarioss = $lider->consultarQuery("SELECT * FROM usuarios, clientes WHERE clientes.id_cliente = usuarios.id_cliente and usuarios.estatus = 0 and usuarios.id_usuario > 1");
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


?>