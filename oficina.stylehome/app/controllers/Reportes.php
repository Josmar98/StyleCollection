<?php
	if(strtolower($url)=="reportes"){
		if(!empty($action)){
			$accesoReportesC = false;
			foreach ($_SESSION['home']['accesos'] as $acc) {
				if(!empty($acc['id_rol'])){
					if(mb_strtolower($acc['nombre_modulo'])==mb_strtolower("Reportes")){
						if(mb_strtolower($acc['nombre_permiso'])==mb_strtolower($PConsultar)){ $accesoReportesC=true; }
					}
				}
			}
			$ciclos = $lider->consultarQuery("SELECT * FROM ciclos WHERE ciclos.estatus=1 ORDER BY ciclos.id_ciclo DESC;");
			$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
			if(
				$action=="ProductosSolicitados" 
				|| $action=="GenerarProductosSolicitados"
				|| $action=="ProductosAprobados"
				|| $action=="GenerarProductosAprobados"
			){
				if($accesoReportesC){
					if(empty($_POST)){
						if(!empty($_GET['ciclo'])){
							$id_ciclo = $_GET['ciclo'];
							$ciclo = $lider->consultarQuery("SELECT * FROM ciclos WHERE id_ciclo={$id_ciclo} and estatus=1");
							$ciclo = $ciclo[0];
							$pedidos = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente=pedidos.id_cliente and pedidos.estatus=1 and clientes.estatus=1 and pedidos.id_ciclo={$id_ciclo}");
						}
						if(!empty($action)){
							$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
							if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
								require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
							}else{
								require_once 'public/views/error404.php';
							}
						}else{
							require_once 'public/views/error404.php';
						}
					}
				}else{
					require_once 'public/views/error404.php';
				}
			}
			if(
				$action=="PorcentajeProductos"
				|| $action=="GenerarPorcentajeProductos"
			){
				if($accesoReportesC){
					if(empty($_POST)){
						if(!empty($_GET['ciclo'])){
							$id_ciclo = $_GET['ciclo'];
							$ciclo = $lider->consultarQuery("SELECT * FROM ciclos WHERE id_ciclo={$id_ciclo} and estatus=1");
							$ciclo = $ciclo[0];

							$productosInventario = $lider->consultarQuery("SELECT DISTINCT inventarios.cod_inventario, inventarios.nombre_inventario FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido=pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario=inventarios.cod_inventario and pedidos.estatus=1 and pedidos_inventarios.estatus=1 and inventarios.estatus=1 and pedidos.id_ciclo={$id_ciclo}");
							// $productosInventario = $lider->consultarQuery("SELECT * FROM pedidos, pedidos_inventarios, inventarios WHERE pedidos.id_pedido=pedidos_inventarios.id_pedido and pedidos_inventarios.cod_inventario=inventarios.cod_inventario and pedidos.estatus=1 and pedidos.id_ciclo={$id_ciclo}");
						}
						if(!empty($action)){
							$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['home']['id_usuario']}");
							if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
								require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
							}else{
								require_once 'public/views/error404.php';
							}
						}else{
							require_once 'public/views/error404.php';
						}
					}
				}else{
					require_once 'public/views/error404.php';
				}
			}
		}
	}

?>