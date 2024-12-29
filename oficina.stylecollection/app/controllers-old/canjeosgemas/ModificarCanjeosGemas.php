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
		$id_cliente_personal_cliente = $_GET['lider'];

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

		$id_cliente = $_GET['lider'];
		$precio = $_POST['precioGema'];
		$cantidad = $_POST['cantidad'];
		$total = $_POST['total'];
		$total = $precio * $cantidad;
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

			$query = "UPDATE canjeos_gemas SET cantidad='{$cantidad}', total='{$total}', estado={$estado}, estatus=1 WHERE id_canjeo_gema={$id}";
			$exec = $lider->modificar($query);
			if($exec['ejecucion']){
				$response = "1";
			}else{
				$response = "1";
			}
		}else{
			$response = "2";
		}

		$canjeos_gemas = $lider->consultarQuery("SELECT * FROM canjeos_gemas WHERE id_canjeo_gema = {$id}");
		$canjeo_gema = $canjeos_gemas[0];

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

		$id_cliente_personal_cliente = $_GET['lider'];

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

		$canjeos_gemas = $lider->consultarQuery("SELECT * FROM canjeos_gemas WHERE id_canjeo_gema = {$id}");
		$canjeo_gema = $canjeos_gemas[0];
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