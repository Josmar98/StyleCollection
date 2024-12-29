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

	$estado_campana2 = $lider->consultarQuery("SELECT estado_campana FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
    $estado_campana = $estado_campana2[0]['estado_campana'];
    if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
		$estado_campana = "1";
	}
if($estado_campana=="1"){

	if (!empty($_POST)) {
		$id = $_GET['lider'];
		$id_cliente = $_GET['lider'];
		$gemasCanjeadasCliente = 0;
		$canjeoGemasCliente = 0;
		$gemasAdquiridasNombramientoCliente = 0;
		$gemasAdquiridasBloqueadasCliente = 0;
		$gemasAdquiridasDisponiblesCliente = 0;
		$gemasAdquiridasFacturaCliente = 0;
		$gemasAdquiridasFacturaClienteBloqueadasCliente = 0;
		$gemasAdquiridasFacturaClienteDisponiblesCliente = 0;
		$gemasAdquiridasBonosCliente = 0;
		$gemasBonosCliente = 0;
		$id_cliente_personal_cliente = $id;

		$canjeosPersonalesCliente = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and id_cliente = {$id_cliente_personal_cliente} and canjeos.estatus = 1");
		foreach ($canjeosPersonalesCliente as $canje) {
			if(!empty($canje['cantidad_gemas'])){
				$gemasCanjeadasCliente += $canje['cantidad_gemas'];
			}
		}


		$canjeosGemasCliente = $lider->consultarQuery("SELECT * FROM canjeos_gemas WHERE id_cliente = {$id_cliente_personal_cliente} and canjeos_gemas.estatus = 1");
		foreach ($canjeosGemasCliente as $canje) {
			if(!empty($canje['cantidad'])){
				$canjeoGemasCliente += $canje['cantidad'];
			}
		}


		$nombramientoAdquiridoCliente = $lider->consultarQuery("SELECT * FROM nombramientos WHERE id_cliente = {$id_cliente_personal_cliente} and estatus = 1");
		foreach ($nombramientoAdquiridoCliente as $data) {
			if(!empty($data['id_nombramiento'])){
				$gemasAdquiridasNombramientoCliente += $data['cantidad_gemas'];
			}
		}

		$gemasAdquiridasCliente = $lider->consultarQuery("SELECT * FROM gemas, configgemas WHERE configgemas.id_configgema = gemas.id_configgema and gemas.id_cliente = {$id_cliente_personal_cliente} and gemas.estatus = 1");
		foreach ($gemasAdquiridasCliente as $data) {
			if(!empty($data['id_gema'])){
				$gemasBonosCliente += $data['cantidad_gemas'];
				if($data['estado']=="Bloqueado"){
					$gemasAdquiridasBloqueadasCliente += $data['cantidad_gemas'];
				}
				if($data['estado']=="Disponible"){
					$gemasAdquiridasDisponiblesCliente += $data['activas'];
				}

				if($data['nombreconfiggema']=="Por Colecciones De Factura Directa"){
					$gemasAdquiridasFacturaCliente += $data['cantidad_gemas'];
					if($data['estado']=="Bloqueado"){
						$gemasAdquiridasFacturaClienteBloqueadasCliente += $data['cantidad_gemas'];
					}
					if($data['estado']=="Disponible"){
						$gemasAdquiridasFacturaClienteDisponiblesCliente += $data['cantidad_gemas'];
					}
				}
				if($data['nombreconfiggema']!="Por Colecciones De Factura Directa"){
					$gemasAdquiridasBonosCliente += $data['cantidad_gemas'];
				}
			}
		}
		$fotoGema = "public/assets/img/gemas/gema1.1.png";
		$fotoGemaBloqueadas = "public/assets/img/gemas/gema1.2.png";
		$gemasAdquiridasDisponiblesCliente += $gemasAdquiridasNombramientoCliente;
		$gemasAdquiridasDisponiblesCliente -= $gemasCanjeadasCliente;
		$cantidad_gemas_liquidadas = 0;
		$gemas_liquidadas_disponibles = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_cliente = {$id_cliente_personal_cliente}");
		if(count($gemas_liquidadas_disponibles)>1){
			$liquidacionGemas = $gemas_liquidadas_disponibles[0];
			$cantidad_gemas_liquidadas = $liquidacionGemas['cantidad_descuento_gemas'];
		}
		$gemasAdquiridasDisponiblesCliente -= $cantidad_gemas_liquidadas;
		$gemasAdquiridasDisponiblesCliente -= $canjeoGemasCliente;


		$precio = $_POST['precioGema'];
		$cantidad = $_POST['cantidad'];
		$total = $_POST['total'];
		$total = $precio * $cantidad;
		$fecha = date('Y-m-d');
	    $hora = date('h:i a');
		$estado = 0;
		// echo "Campaña: ".$id_campana."<br>";
		// echo "Despacho: ".$id_despacho."<br>";
		// echo "Cliente: ".$id_cliente."<br>";
		// echo "Precio de Gema: ".$precio."<br>";
		// echo "Gemas Disponibles: ".$gemasAdquiridasDisponiblesCliente."<br>";
		// echo "Cantidad Gemas A Canjear: ".$cantidad."<br>";
		// echo "Total Canjeado en $$: ".$total."<br>";
		// echo "Estado: ".$estado."<br>";



		if($cantidad <= $gemasAdquiridasDisponiblesCliente){

			// $query = "UPDATE canjeos_gemas SET cantidad='{$cantidad}', total='{$total}', estado={$estado}, estatus=1 WHERE id_canjeo_gema={$id}";
			$query = "INSERT INTO canjeos_gemas (id_canjeo_gema, id_campana, id_despacho, id_cliente, precio_gema, cantidad, total, fecha_canjeo_gema, hora_canjeo_gema, estado, estatus) VALUES (DEFAULT, {$id_campana}, {$id_despacho}, {$id_cliente}, '{$precio}', '{$cantidad}', '{$total}', '{$fecha}', '{$hora}', '{$estado}', 1)";
			$exec = $lider->registrar($query, "canjeos_gemas", "id_canjeo_gema");
			if($exec['ejecucion']){
				$response = "1";
			}else{
				$response = "1";
			}
		}else{
			$response = "2";
		}

		$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

		$precioGema = $lider->consultarQuery("SELECT * FROM precio_gema WHERE id_campana = {$id_campana} and estatus = 1");
		if(count($precioGema)>1){
			$precio_gema = $precioGema[0];
		}

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
	if(empty($_POST)){
		if(!empty($_GET['admin']) && !empty($_GET['lider']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista")){
			$id = $_GET['lider'];

			$gemasCanjeadasCliente = 0;
			$canjeoGemasCliente = 0;
			$gemasAdquiridasNombramientoCliente = 0;
			$gemasAdquiridasBloqueadasCliente = 0;
			$gemasAdquiridasDisponiblesCliente = 0;
			$gemasAdquiridasFacturaCliente = 0;
			$gemasAdquiridasFacturaClienteBloqueadasCliente = 0;
			$gemasAdquiridasFacturaClienteDisponiblesCliente = 0;
			$gemasAdquiridasBonosCliente = 0;
			$gemasBonosCliente = 0;
			$id_cliente_personal_cliente = $id;

			$canjeosPersonalesCliente = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and id_cliente = {$id_cliente_personal_cliente} and canjeos.estatus = 1");
			foreach ($canjeosPersonalesCliente as $canje) {
				if(!empty($canje['cantidad_gemas'])){
					$gemasCanjeadasCliente += $canje['cantidad_gemas'];
				}
			}

			$canjeosGemasCliente = $lider->consultarQuery("SELECT * FROM canjeos_gemas WHERE id_cliente = {$id_cliente_personal_cliente} and canjeos_gemas.estatus = 1 and canjeos_gemas.id_canjeo_gema != {$id}");
			foreach ($canjeosGemasCliente as $canje) {
				if(!empty($canje['cantidad'])){
					$canjeoGemasCliente += $canje['cantidad'];
				}
			}

			$nombramientoAdquiridoCliente = $lider->consultarQuery("SELECT * FROM nombramientos WHERE id_cliente = {$id_cliente_personal_cliente} and estatus = 1");
			foreach ($nombramientoAdquiridoCliente as $data) {
				if(!empty($data['id_nombramiento'])){
					$gemasAdquiridasNombramientoCliente += $data['cantidad_gemas'];
				}
			}

			$gemasAdquiridasCliente = $lider->consultarQuery("SELECT * FROM gemas, configgemas WHERE configgemas.id_configgema = gemas.id_configgema and gemas.id_cliente = {$id_cliente_personal_cliente} and gemas.estatus = 1");
			foreach ($gemasAdquiridasCliente as $data) {
				if(!empty($data['id_gema'])){
					$gemasBonosCliente += $data['cantidad_gemas'];
					if($data['estado']=="Bloqueado"){
						$gemasAdquiridasBloqueadasCliente += $data['cantidad_gemas'];
					}
					if($data['estado']=="Disponible"){
						$gemasAdquiridasDisponiblesCliente += $data['activas'];
					}

					if($data['nombreconfiggema']=="Por Colecciones De Factura Directa"){
						$gemasAdquiridasFacturaCliente += $data['cantidad_gemas'];
						if($data['estado']=="Bloqueado"){
							$gemasAdquiridasFacturaClienteBloqueadasCliente += $data['cantidad_gemas'];
						}
						if($data['estado']=="Disponible"){
							$gemasAdquiridasFacturaClienteDisponiblesCliente += $data['cantidad_gemas'];
						}
					}
					if($data['nombreconfiggema']!="Por Colecciones De Factura Directa"){
						$gemasAdquiridasBonosCliente += $data['cantidad_gemas'];
					}
				}
			}
			$fotoGema = "public/assets/img/gemas/gema1.1.png";
			$fotoGemaBloqueadas = "public/assets/img/gemas/gema1.2.png";
			$gemasAdquiridasDisponiblesCliente += $gemasAdquiridasNombramientoCliente;
			$gemasAdquiridasDisponiblesCliente -= $gemasCanjeadasCliente;
			$cantidad_gemas_liquidadas = 0;
			$gemas_liquidadas_disponibles = $lider->consultarQuery("SELECT * FROM descuentos_gemas WHERE estatus = 1 and id_cliente = {$id_cliente_personal_cliente}");
			if(count($gemas_liquidadas_disponibles)>1){
				$liquidacionGemas = $gemas_liquidadas_disponibles[0];
				$cantidad_gemas_liquidadas = $liquidacionGemas['cantidad_descuento_gemas'];
			}
			$gemasAdquiridasDisponiblesCliente -= $cantidad_gemas_liquidadas;
			$gemasAdquiridasDisponiblesCliente -= $canjeoGemasCliente;
		}


		$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

		$precioGema = $lider->consultarQuery("SELECT * FROM precio_gema WHERE id_campana = {$id_campana} and estatus = 1");
		if(count($precioGema)>1){
			$precio_gema = $precioGema[0];
		}

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