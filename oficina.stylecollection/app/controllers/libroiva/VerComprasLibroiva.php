<?php 
if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Contable"){

	$compras=$lider->consultarQuery("SELECT * FROM proveedores_compras, factura_compras WHERE proveedores_compras.id_proveedor_compras = factura_compras.id_proveedor_compras and factura_compras.estatus=1 ORDER BY factura_compras.periodoAnio DESC, factura_compras.periodoMes DESC, factura_compras.fechaFactura ASC;");

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		$query = "UPDATE factura_compras SET estatus = 0 WHERE id_factura_compra = {$id}";
		$res1 = $lider->eliminar($query);
		if($res1['ejecucion']==true){
			$response = "1";
			if(!empty($modulo) && !empty($accion)){
				$fecha = date('Y-m-d');
				$hora = date('H:i:a');
				$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Factura de Compras', 'Borrar', '{$fecha}', '{$hora}')";
				$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
			}

		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
	}

	if(empty($_POST)){
		
		if($compras['ejecucion']==1){
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