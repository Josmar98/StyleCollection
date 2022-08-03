<?php 


if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){

	$clientes=$lider->consultarQuery("SELECT DISTINCT clientes.id_cliente, primer_nombre, primer_apellido, cedula FROM clientes, nombramientos WHERE clientes.id_cliente = nombramientos.id_cliente and  clientes.estatus = 1 and nombramientos.estatus = 1");

	$nombramientos=$lider->consultarQuery("SELECT * FROM nombramientos WHERE nombramientos.estatus = 1");
	$nombramientosX2=$lider->consultarQuery("SELECT * FROM campanas, clientes, liderazgos, nombramientos WHERE campanas.id_campana = nombramientos.id_campana and clientes.id_cliente = nombramientos.id_cliente and liderazgos.id_liderazgo=nombramientos.id_liderazgo and campanas.estatus = 1 and clientes.estatus = 1 and liderazgos.estatus = 1 and nombramientos.estatus = 1");
	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		if($_SESSION['nombre_rol']=="Superusuario"){

			$query = "UPDATE nombramientos SET estatus = 0 WHERE id_nombramiento = $id";
			$res1 = $lider->eliminar($query);
			if($res1['ejecucion']==true){
				$response = "1";
					if(!empty($modulo) && !empty($accion)){
						$fecha = date('Y-m-d');
						$hora = date('H:i:a');
						$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Nombramientos', 'Borrar', '{$fecha}', '{$hora}')";
						$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
					}
			}else{
				$response = "2"; // echo 'Error en la conexion con la bd';
			}
		}else{
		    require_once 'public/views/error404.php';
		}
	}

	if(empty($_POST)){
		if($nombramientosX2['ejecucion']==1){
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