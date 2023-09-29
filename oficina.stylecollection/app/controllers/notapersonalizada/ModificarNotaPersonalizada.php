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

	function separateDatosCuentaTel($num){
		// echo $num[0];
		// echo strlen($num);
		$set = 0;
		$newNum = '';
		for ($i=0; $i < strlen($num); $i++) { 
			if($i==4){
				$newNum .= '-';
			}
			if($i==7){
				$newNum .= '-';
			}
			if($i==9){
				$newNum .= '-';
			}
			$newNum .= $num[$i];
		}
		return $newNum;
	}
	if(!empty($_POST['refrescandoCantidades'])){
		$_SESSION['cargaTemporalNotaPersonalizadaMod'] = $_POST;
		echo "1";
	}
	if (!empty($_POST['direccion_emision'])) {
		$cantidad_registros = $_POST['cantidadRegistros'];
		$direccion = mb_strtoupper($_POST['direccion_emision']);
		$lugar = ucwords(mb_strtolower($_POST['lugar_emision']));
		$fecha = $_POST['fecha_emision'];
		$num = $_POST['numero'];
		$nameAnalista = "";
		if(!empty($_POST['nombreanalista'])){
			$nameAnalista = ucwords(mb_strtolower($_POST['nombreanalista']));
		}

		$id_nota = $_GET['nota'];
		$notaP = $lider->consultarQuery("SELECT * FROM notasentregapersonalizada WHERE id_nota_entrega_personalizada = {$id_nota}");
		$notaP = $notaP[0];

		$id_lider = $notaP['id_cliente'];
		$pedidoss = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = {$id_lider} and id_despacho = {$id_despacho}");
		$id_pedido = $pedidoss[0]['id_pedido'];
		
		$cantidades = [];
		if(!empty($_POST['cantidades'])){
			$cantidades = $_POST['cantidades'];
		}
		$tipos = [];
		if(!empty($_POST['tipos'])){
			$tipos = $_POST['tipos'];
		}
		$productos = [];
		if(!empty($_POST['productos'])){
			$productos = $_POST['productos'];
		}
		$premios = [];
		if(!empty($_POST['premios'])){
			$premios = $_POST['premios'];
		}
		$conceptos = [];
		if(!empty($_POST['conceptos'])){
			$conceptos = $_POST['conceptos'];
		}
		$opts = [];
		if(!empty($_POST['opts'])){
			$opts = $_POST['opts'];
		}

		$max = count($opts);
		if($max!=$cantidad_registros){
			$max = $cantidad_registros;
		}

		$query = "UPDATE notasentregapersonalizada SET direccion_emision='{$direccion}', lugar_emision='{$lugar}', fecha_emision='{$fecha}', numero_nota_entrega={$num}, nombreanalista='{$nameAnalista}' WHERE id_nota_entrega_personalizada = {$id_nota}";
		$exec = $lider->modificar($query);
		if($exec['ejecucion']==true){
			$nume = 0;
			$errores = 0;
			$sum = 0;
			$execElim = $lider->eliminar("DELETE FROM opcionesentregapersonalizada WHERE id_nota_entrega_personalizada = {$id_nota}");
			if($exec['ejecucion']==true){
				for ($i=0; $i < $max; $i++){
					$premio_producto_act = "";
					$cantidadAct = $cantidades[$i];
					$tipoAct = $tipos[$i];
					$productoAct = $productos[$i];
					$premioAct = $premios[$i];
					$conceptoAct = ucwords(mb_strtolower($conceptos[$i]));
					$optsAct = $opts[$i];
					if($tipoAct=="Productos"){
						$premio_producto_act = $productoAct;
					}
					if($tipoAct=="Premios"){
						$premio_producto_act = $premioAct;
					}
					if($cantidadAct!="" && $tipoAct && $premio_producto_act!=""){
						$query2 = "INSERT INTO opcionesentregapersonalizada (id_opcion_entrega_personalizada, id_nota_entrega_personalizada, cantidad, tipo, producto_premio, concepto, opcion, estatus) VALUES (DEFAULT, {$id_nota}, {$cantidadAct}, '{$tipoAct}', {$premio_producto_act}, '{$conceptoAct}', '{$optsAct}', 1)";
						$exec2 = $lider->registrar($query2, "opcionesentregapersonalizada", "id_opcion_entrega_personalizada");
						if($exec2['ejecucion']==true){
							$sum++;
						}else{
							$errores++;
						}
					}
				}
				if($errores==0){
					$response = "1";
				}else{
					$response = "2";
				}
			}else{
				$response = "2";
			}

		}else{
			$response = "2";
		}

		if(count($notaP)>1){
			$id_cliente = $notaP['id_cliente'];
			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and pedidos.id_cliente = $id_cliente");
			$pedido = $pedidos[0];
			$id_pedido = $pedido['id_pedido'];
			$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1");
			$numFactura = "";
			$factura = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido}");
			if(count($factura)>1){
				$numFactura = $factura[0]['numero_factura'];
				switch (strlen($factura[0]['numero_factura'])) {
					case 1:
						$numFactura = "00000".$factura[0]['numero_factura'];
						break;
					case 2:
						$numFactura = "0000".$factura[0]['numero_factura'];
						break;
					case 3:
						$numFactura = "000".$factura[0]['numero_factura'];
						break;
					case 4:
						$numFactura = "00".$factura[0]['numero_factura'];
						break;
					case 5:
						$numFactura = "0".$factura[0]['numero_factura'];
						break;
					case 6:
						$numFactura = "".$factura[0]['numero_factura'];
						break;
				}
			}
			$nombreanalista = $notaP['nombreanalista'];
			$nume = $notaP['numero_nota_entrega'];
			$productos = $lider->consultarQuery("SELECT * FROM productos WHERE productos.estatus = 1");
			$premios = $lider->consultarQuery("SELECT * FROM premios WHERE premios.estatus = 1");

			$opcionesEntregas = $lider->consultarQuery("SELECT * FROM opcionesentregapersonalizada WHERE id_nota_entrega_personalizada = {$id_nota}");
			if(empty($_GET['cant'])){
				$_SESSION['cargaTemporalNotaPersonalizadaMod'] = [];
				$nx = 0;
				foreach ($opcionesEntregas as $key) {
					if(!empty($key['id_nota_entrega_personalizada'])){
						$_SESSION['cargaTemporalNotaPersonalizadaMod']['cantidades'][$nx] = $key['cantidad'];	
						$_SESSION['cargaTemporalNotaPersonalizadaMod']['tipos'][$nx] = $key['tipo'];
						if($key['tipo']=="Productos"){
							$_SESSION['cargaTemporalNotaPersonalizadaMod']['productos'][$nx] = $key['producto_premio'];
							$_SESSION['cargaTemporalNotaPersonalizadaMod']['premios'][$nx] = "";
						}
						if($key['tipo']=="Premios"){
							$_SESSION['cargaTemporalNotaPersonalizadaMod']['premios'][$nx] = $key['producto_premio'];
							$_SESSION['cargaTemporalNotaPersonalizadaMod']['productos'][$nx] = "";
						}
						$_SESSION['cargaTemporalNotaPersonalizadaMod']['conceptos'][$nx] = $key['concepto'];
						$_SESSION['cargaTemporalNotaPersonalizadaMod']['opts'][$nx] = $key['opcion'];
						$nx++;
					}
				}
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
		}else{
			require_once 'public/views/error404.php';
		}

	}
	if(empty($_POST)){
		$id_nota=$_GET['nota'];
		$notaP = $lider->consultarQuery("SELECT * FROM notasentregapersonalizada WHERE id_nota_entrega_personalizada = {$id_nota}");
		if(count($notaP)>1){
			$notaP = $notaP[0];
			$id_cliente = $notaP['id_cliente'];
			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and pedidos.id_cliente = $id_cliente");
			$pedido = $pedidos[0];
			$id_pedido = $pedido['id_pedido'];
			$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1");
			$numFactura = "";
			$factura = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido}");
			if(count($factura)>1){
				$numFactura = $factura[0]['numero_factura'];
				switch (strlen($factura[0]['numero_factura'])) {
					case 1:
						$numFactura = "00000".$factura[0]['numero_factura'];
						break;
					case 2:
						$numFactura = "0000".$factura[0]['numero_factura'];
						break;
					case 3:
						$numFactura = "000".$factura[0]['numero_factura'];
						break;
					case 4:
						$numFactura = "00".$factura[0]['numero_factura'];
						break;
					case 5:
						$numFactura = "0".$factura[0]['numero_factura'];
						break;
					case 6:
						$numFactura = "".$factura[0]['numero_factura'];
						break;
				}
			}
			$nombreanalista = $notaP['nombreanalista'];
			$nume = $notaP['numero_nota_entrega'];
			$productos = $lider->consultarQuery("SELECT * FROM productos WHERE productos.estatus = 1");
			$premios = $lider->consultarQuery("SELECT * FROM premios WHERE premios.estatus = 1");

			$opcionesEntregas = $lider->consultarQuery("SELECT * FROM opcionesentregapersonalizada WHERE id_nota_entrega_personalizada = {$id_nota}");
			if(empty($_GET['cant'])){
				$_SESSION['cargaTemporalNotaPersonalizadaMod'] = [];
				$nx = 0;
				foreach ($opcionesEntregas as $key) {
					if(!empty($key['id_nota_entrega_personalizada'])){
						$_SESSION['cargaTemporalNotaPersonalizadaMod']['cantidades'][$nx] = $key['cantidad'];	
						$_SESSION['cargaTemporalNotaPersonalizadaMod']['tipos'][$nx] = $key['tipo'];
						if($key['tipo']=="Productos"){
							$_SESSION['cargaTemporalNotaPersonalizadaMod']['productos'][$nx] = $key['producto_premio'];
							$_SESSION['cargaTemporalNotaPersonalizadaMod']['premios'][$nx] = "";
						}
						if($key['tipo']=="Premios"){
							$_SESSION['cargaTemporalNotaPersonalizadaMod']['premios'][$nx] = $key['producto_premio'];
							$_SESSION['cargaTemporalNotaPersonalizadaMod']['productos'][$nx] = "";
						}
						$_SESSION['cargaTemporalNotaPersonalizadaMod']['conceptos'][$nx] = $key['concepto'];
						$_SESSION['cargaTemporalNotaPersonalizadaMod']['opts'][$nx] = $key['opcion'];
						$nx++;
					}
				}
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
		}else{
			    require_once 'public/views/error404.php';
		}

	}
}else{
   require_once 'public/views/error404.php';
}
?>