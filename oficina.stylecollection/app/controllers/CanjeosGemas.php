<?php 

	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }
	// $lider = new Models();

  $id_campana = $_GET['campaing'];
  $numero_campana = $_GET['n'];
  $anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

if(!empty($_GET['retirar']) && $_GET['retirar'] == 1 ){
	$query = "UPDATE canjeos_gemas SET estado = 1 WHERE id_canjeo_gema = '$id'";
	$res1 = $lider->modificar($query);
	if($res1['ejecucion']==true){
		$response = "1";
			if(!empty($modulo) && !empty($accion)){
				$fecha = date('Y-m-d');
				$hora = date('H:i:a');
				$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Canjeo de Gemas', 'Retirar', '{$fecha}', '{$hora}')";
				$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
			}
	}else{
		$response = "2"; // echo 'Error en la conexion con la bd';
	}
}
if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
	$query = "UPDATE canjeos_gemas SET estatus = 0 WHERE id_canjeo_gema = '$id'";
	$res1 = $lider->eliminar($query);
	if($res1['ejecucion']==true){
		$response = "1";
			if(!empty($modulo) && !empty($accion)){
				$fecha = date('Y-m-d');
				$hora = date('H:i:a');
				$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Canjeo de Gemas', 'Borrar', '{$fecha}', '{$hora}')";
				$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
			}
	}else{
		$response = "2"; // echo 'Error en la conexion con la bd';
	}
}
if(empty($_POST)){
	$canjeos = $lider->consultarQuery("SELECT * FROM clientes, canjeos_gemas WHERE clientes.id_cliente = canjeos_gemas.id_cliente and canjeos_gemas.id_campana = {$id_campana} and canjeos_gemas.id_despacho = {$id_despacho} and canjeos_gemas.estatus = 1");
	if($canjeos['ejecucion']==true){

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