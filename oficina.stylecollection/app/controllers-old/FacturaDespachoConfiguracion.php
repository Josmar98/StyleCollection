<?php 
	
if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";
	$estado_campana2 = $lider->consultarQuery("SELECT estado_campana FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
    $estado_campana = $estado_campana2[0]['estado_campana'];
    if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
		$estado_campana = "1";
	}
	if($estado_campana=="1"){
	  //  REGISTRAR
		if(!empty($_POST['precio_col']) && empty($_GET['operation'])){
			$precio_col = $_POST['precio_col'];

			$buscar = $lider->consultarQuery("SELECT * FROM opcion_factura_despacho WHERE id_campana = {$id_campana} and estatus = 1");
			if($buscar['ejecucion'] && count($buscar)>1){
				$response = "9";
			}else{
				$buscar = $lider->consultarQuery("SELECT * FROM opcion_factura_despacho WHERE id_campana = {$id_campana} and estatus = 0");
				if($buscar['ejecucion'] && count($buscar)>1){
					$query = "UPDATE opcion_factura_despacho SET precio_coleccion_campana = {$precio_col}, estatus = 1 WHERE id_campana = {$id_campana}";
					$exec = $lider->modificar($query);
					if($exec['ejecucion']==true){
						$response = "1";
					}else{
						$response = "2";
					} 
				}else{
					$query = "INSERT INTO opcion_factura_despacho (id_opt_fact_desp, id_campana, precio_coleccion_campana, estatus) VALUES (DEFAULT, {$id_campana}, {$precio_col}, 1)";
					$exec = $lider->registrar($query, "opcion_factura_despacho", "id_opt_fact_desp");
					if($exec['ejecucion']==true){
						$response = "1";
					}else{
						$response = "2";
					}  
				}

				if(!empty($modulo) && !empty($accion)){
					$fecha = date('Y-m-d');
					$hora = date('H:i:a');
					$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Configuracion De Factura', 'Registrar', '{$fecha}', '{$hora}')";
					$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
				}
			}

			$query = "SELECT * FROM opcion_factura_despacho WHERE opcion_factura_despacho.id_campana = {$id_campana}";
			$facturas = $lider->consultarQuery($query);
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

			// modificar
		if(!empty($_POST['precio_col']) && !empty($_GET['operation']) && $_GET['operation']=="Modificar"){
			// print_r($_POST['precio_col']);
			$precio_col = $_POST['precio_col'];
			$query = "UPDATE opcion_factura_despacho SET precio_coleccion_campana = {$precio_col}, estatus = 1 WHERE id_campana = {$id_campana}";
			$exec = $lider->modificar($query);
			if($exec['ejecucion']==true){
				$response = "1";

		        if(!empty($modulo) && !empty($accion)){
		          $fecha = date('Y-m-d');
		          $hora = date('H:i:a');
		          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Configuracion De Factura', 'Editar', '{$fecha}', '{$hora}')";
		          $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
		        }
			}else{
				$response = "2";
			} 
			$query = "SELECT * FROM opcion_factura_despacho WHERE opcion_factura_despacho.id_campana = {$id_campana}";
			$facturas = $lider->consultarQuery($query);
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

		if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){

			$query = "UPDATE opcion_factura_despacho SET estatus = 0 WHERE id_opt_fact_desp = $id";
			$res1 = $lider->eliminar($query);
			if($res1['ejecucion']==true){
				$response = "1";

		        if(!empty($modulo) && !empty($accion)){
		          $fecha = date('Y-m-d');
		          $hora = date('H:i:a');
		          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Configuracion De Factura', 'Borrar', '{$fecha}', '{$hora}')";
		          $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
		        }
			}else{
				$response = "2"; // echo 'Error en la conexion con la bd';
			}

			// if(!empty($action)){
			// 	if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
			// 		require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
			// 	}else{
			// 	    require_once 'public/views/error404.php';
			// 	}
			// }else{
			// 	if (is_file('public/views/'.$url.'.php')) {
			// 		require_once 'public/views/'.$url.'.php';
			// 	}else{
			// 	    require_once 'public/views/error404.php';
			// 	}
			// }
		}



		if(empty($_POST)){
			// $pedidosFull = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho ORDER BY pedidos.id_pedido DESC");
			$query = "SELECT * FROM opcion_factura_despacho WHERE opcion_factura_despacho.id_campana = {$id_campana} and estatus = 1";
			$facturas = $lider->consultarQuery($query);
			if($facturas['ejecucion']==1){
			
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
}else{
	require_once 'public/views/error404.php';
}

?>