<?php 
if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Contable"){

		// if(!empty($_POST['validarData'])){
		// 	$id = $_POST['id'];
		// 	$query = "SELECT * FROM liderazgos WHERE id_liderazgo = $id";
		// 	$res1 = $lider->consultarQuery($query);
		// 	if($res1['ejecucion']==true){
		// 		if(Count($res1)>1){
		// 			$response = "1";
		// 		}else{
		// 			$response = "9"; //echo "Registro ya guardado.";
		// 		}
		// 	}else{
		// 		$response = "5"; // echo 'Error en la conexion con la bd';
		// 	}
		// 	echo $response;
		// }
		if(!empty($_POST['id_factura_despacho']) && isset($_POST['monto']) && isset($_POST['control1']) && isset($_POST['control2'])){
			// print_r($_POST);
			$monto = (float) number_format($_POST['monto'],2,'.','');
			$control1 = $_POST['control1'];
			$control2 = $_POST['control2'];
			$id_factura_despacho = $_POST['id_factura_despacho'];
			// die();
			$query = "UPDATE factura_ventas SET totalVenta={$monto}, estatus = 1 WHERE id_factura_ventas = {$id}";
			$exec = $lider->modificar($query);
			if($exec['ejecucion']==true){
				// $response = "1";
				$query = "UPDATE factura_despacho SET numero_control1={$control1}, numero_control2={$control2}, estatus = 1 WHERE id_factura_despacho = {$id_factura_despacho}";
				$exec = $lider->modificar($query);
				if($exec['ejecucion']==true){
					$response = "1";
					if(!empty($modulo) && !empty($accion)){
						$fecha = date('Y-m-d');
						$hora = date('H:i:a');
						$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Factura de Ventas', 'Editar', '{$fecha}', '{$hora}')";
						$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
					}
				}else{
					$response = "2";
				}
			}else{
				$response = "2";
			}
			
			echo $response;

		}
		if(empty($_POST)){
			$ruta="";
			if( !empty($_GET['tipo']) ){
				$ruta.="&tipo=".$_GET['tipo'];
			}
			if( !empty($_GET['anio']) ){
				$ruta.="&anio=".$_GET['anio'];
			}
			if( !empty($_GET['mes']) ){
				$ruta.="&mes=".$_GET['mes'];
			}
			// echo $ruta;
			$query = "SELECT * FROM factura_ventas, factura_despacho WHERE factura_despacho.id_factura_despacho=factura_ventas.id_factura_despacho and factura_ventas.id_factura_ventas = {$id}";
			$facturasVentas=$lider->consultarQuery($query);
			if(Count($facturasVentas)>1){
				$venta = $facturasVentas[0];
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