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
		$_SESSION['cargaTempFactPersonalizadaMod'] = $_POST;
		echo "1";
	}
	if (!empty($_POST['num_factura']) && !empty($_POST['control1']) && !empty($_POST['forma']) && !empty($_POST['lugar'])) {
		// print_r($_POST);
		$cantidad_registros = $_POST['cantidadRegistros'];
		$num_factura = $_POST['num_factura'];
		$num_control = $_POST['control1'];
		$id_cliente = $_POST['lider'];
		$forma = ucwords(mb_strtolower($_POST['forma']));
		$lugar = ucwords(mb_strtolower($_POST['lugar']));
		$fecha1 = $_POST['fecha1'];
		$fecha2 = $_POST['fecha2'];
		// $nameAnalista = "";
		// if(!empty($_POST['nombreanalista'])){
		// 	$nameAnalista = ucwords(mb_strtolower($_POST['nombreanalista']));
		// }

		$id_nota = $_GET['id'];
		// $notaP = $lider->consultarQuery("SELECT * FROM notasentregapersonalizada WHERE id_nota_entrega_personalizada = {$id_nota}");
		// $notaP = $notaP[0];

		// $id_lider = $notaP['id_cliente'];
		// $pedidoss = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = {$id_lider} and id_despacho = {$id_despacho}");
		// $id_pedido = $pedidoss[0]['id_pedido'];
		
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
		$precios = [];
		if(!empty($_POST['precios'])){
			$precios = $_POST['precios'];
		}
		$conceptos = [];
		if(!empty($_POST['conceptos'])){
			$conceptos = $_POST['conceptos'];
		}
		
		$max = count($tipos);
		if($max!=$cantidad_registros){
			$max = $cantidad_registros;
		}
		$query = "UPDATE factura_personalizada SET numero_factura={$num_factura}, numero_control={$num_control}, id_cliente={$id_cliente}, forma_pago='{$forma}', lugar_emision='{$lugar}', fecha_emision='{$fecha1}', fecha_vencimiento='{$fecha2}' WHERE id_factura_personalizada = {$id_nota}";
		// die();
		$exec = $lider->modificar($query);
		if($exec['ejecucion']==true){
			$nume = 0;
			$errores = 0;
			$sum = 0;
			$id_factura_personaliada = $id_nota;
			// $id_factura_personaliada = 7;
			$execElim = $lider->eliminar("DELETE FROM lista_factura_personalizada WHERE lista_factura_personalizada.id_factura_personalizada = {$id_nota}");
			for ($i=0; $i < $max; $i++){
				// $premio_producto_act = "";
				$cantidadAct = $cantidades[$i];
				$tipoAct = $tipos[$i];
				$productoAct = $productos[$i]=="" ? 0 : $productos[$i];
				$premioAct = $premios[$i]=="" ? 0 : $premios[$i];
				$precioAct = (float) number_format($precios[$i],2,'.','');
				$conceptoAct = ucwords(mb_strtolower($conceptos[$i]));
				
				$query2 = "INSERT INTO lista_factura_personalizada (id_lista_factura_personalizada, id_factura_personalizada, cantidades, tipos, id_productos, id_premios, precios, conceptos, estatus) VALUES (DEFAULT, {$id_factura_personaliada}, {$cantidadAct}, '{$tipoAct}', {$productoAct}, {$premioAct}, {$precioAct}, '{$conceptoAct}', 1)";
				$exec2 = $lider->registrar($query2, "lista_factura_personalizada", "id_lista_factura_personalizada");
				if($exec2['ejecucion']==true){
					$sum++;
				}else{
					$errores++;
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

		$id_nota=$_GET['id'];
		$notaP = $lider->consultarQuery("SELECT * FROM factura_personalizada WHERE id_factura_personalizada = {$id_nota}");
		if(count($notaP)>1){
			$notaP = $notaP[0];
			$id_cliente = $notaP['id_cliente'];
			$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and pedidos.id_cliente = $id_cliente");
			$pedido = $pedidos[0];
			$id_pedido = $pedido['id_pedido'];
			$numFactura = "";
			$factura = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido}");
			$factura = $notaP;
			// print_r($factura);
			if(count($factura)>1){
				$numFactura = $factura['numero_factura'];
				switch (strlen($factura['numero_factura'])) {
					case 1:
						$numFactura = "00000".$factura['numero_factura'];
						break;
					case 2:
						$numFactura = "0000".$factura['numero_factura'];
						break;
					case 3:
						$numFactura = "000".$factura['numero_factura'];
						break;
					case 4:
						$numFactura = "00".$factura['numero_factura'];
						break;
					case 5:
						$numFactura = "0".$factura['numero_factura'];
						break;
					case 6:
						$numFactura = "".$factura['numero_factura'];
						break;
				}
			}
			$nombreanalista = "";
			$nume = $notaP['numero_factura'];
			$productos = $lider->consultarQuery("SELECT * FROM productos WHERE productos.estatus = 1");
			$premios = $lider->consultarQuery("SELECT * FROM premios WHERE premios.estatus = 1");

			$opcionesEntregas = $lider->consultarQuery("SELECT * FROM lista_factura_personalizada WHERE id_factura_personalizada = {$id_nota}");
			$nx = 0;
			
			if(empty($_GET['cant'])){
				$_SESSION['cargaTempFactPersonalizadaMod'] = [];
				$_SESSION['cargaTempFactPersonalizadaMod'] = $notaP;

				foreach ($opcionesEntregas as $key) {
					if(!empty($key['id_lista_factura_personalizada'])){
						$buscarRubro = [];
						if($key['tipos']=="Productos"){
							$buscarRubro = $lider->consultarQuery("SELECT * FROM productos WHERE productos.estatus=1 and productos.id_producto={$key['id_productos']}");
						}
						if($key['tipos']=="Premios"){
							$buscarRubro = $lider->consultarQuery("SELECT * FROM premios WHERE premios.estatus=1 and premios.id_premio={$key['id_premios']}");
						}
						// print_r($key);
						// echo "<br>";
						// print_r($buscarRubro);
						// echo "<br>";
						// echo "<br>";
						// echo "<br>";
						$_SESSION['cargaTempFactPersonalizadaMod']['cantidades'][$nx] = $key['cantidades'];	
						$_SESSION['cargaTempFactPersonalizadaMod']['tipos'][$nx] = $key['tipos'];
						if($key['tipos']=="Productos"){
							$_SESSION['cargaTempFactPersonalizadaMod']['productos'][$nx] = $buscarRubro[0]['id_producto'];
							$_SESSION['cargaTempFactPersonalizadaMod']['premios'][$nx] = "";
						}
						if($key['tipos']=="Premios"){
							$_SESSION['cargaTempFactPersonalizadaMod']['premios'][$nx] = $buscarRubro[0]['id_premio'];
							$_SESSION['cargaTempFactPersonalizadaMod']['productos'][$nx] = "";
						}
						$_SESSION['cargaTempFactPersonalizadaMod']['precios'][$nx] = $key['precios'];
						$_SESSION['cargaTempFactPersonalizadaMod']['conceptos'][$nx] = $key['conceptos'];
						$nx++;
					}
				}
			}
			unset($_SESSION['cargaTempFactPersonalizada']);

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
		$id_nota=$_GET['id'];
		$notaP = $lider->consultarQuery("SELECT * FROM factura_personalizada WHERE id_factura_personalizada = {$id_nota}");
		// print_r($notaP);
		if(count($notaP)>1){
			$notaP = $notaP[0];
			$id_cliente = $notaP['id_cliente'];
			$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
			$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and pedidos.id_cliente = $id_cliente");
			$pedido = $pedidos[0];
			$id_pedido = $pedido['id_pedido'];
			$numFactura = "";
			$factura = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido}");
			$factura = $notaP;
			// print_r($factura);
			if(count($factura)>1){
				$numFactura = $factura['numero_factura'];
				switch (strlen($factura['numero_factura'])) {
					case 1:
						$numFactura = "00000".$factura['numero_factura'];
						break;
					case 2:
						$numFactura = "0000".$factura['numero_factura'];
						break;
					case 3:
						$numFactura = "000".$factura['numero_factura'];
						break;
					case 4:
						$numFactura = "00".$factura['numero_factura'];
						break;
					case 5:
						$numFactura = "0".$factura['numero_factura'];
						break;
					case 6:
						$numFactura = "".$factura['numero_factura'];
						break;
				}
			}
			$nombreanalista = "";
			$nume = $notaP['numero_factura'];
			$productos = $lider->consultarQuery("SELECT * FROM productos WHERE productos.estatus = 1");
			$premios = $lider->consultarQuery("SELECT * FROM premios WHERE premios.estatus = 1");

			$opcionesEntregas = $lider->consultarQuery("SELECT * FROM lista_factura_personalizada WHERE id_factura_personalizada = {$id_nota}");
			$nx = 0;
			// $_SESSION['cargaTempFactPersonalizadaMod'] = [];
			if(empty($_GET['cant'])){
				$_SESSION['cargaTempFactPersonalizadaMod'] = [];
				$_SESSION['cargaTempFactPersonalizadaMod'] = $notaP;

				foreach ($opcionesEntregas as $key) {
					if(!empty($key['id_lista_factura_personalizada'])){
						$buscarRubro = [];
						if($key['tipos']=="Productos"){
							$buscarRubro = $lider->consultarQuery("SELECT * FROM productos WHERE productos.estatus=1 and productos.id_producto={$key['id_productos']}");
						}
						if($key['tipos']=="Premios"){
							$buscarRubro = $lider->consultarQuery("SELECT * FROM premios WHERE premios.estatus=1 and premios.id_premio={$key['id_premios']}");
						}
						// print_r($key);
						// echo "<br>";
						// print_r($buscarRubro);
						// echo "<br>";
						// echo "<br>";
						// echo "<br>";
						$_SESSION['cargaTempFactPersonalizadaMod']['cantidades'][$nx] = $key['cantidades'];	
						$_SESSION['cargaTempFactPersonalizadaMod']['tipos'][$nx] = $key['tipos'];
						if($key['tipos']=="Productos"){
							$_SESSION['cargaTempFactPersonalizadaMod']['productos'][$nx] = $buscarRubro[0]['id_producto'];
							$_SESSION['cargaTempFactPersonalizadaMod']['premios'][$nx] = "";
						}
						if($key['tipos']=="Premios"){
							$_SESSION['cargaTempFactPersonalizadaMod']['premios'][$nx] = $buscarRubro[0]['id_premio'];
							$_SESSION['cargaTempFactPersonalizadaMod']['productos'][$nx] = "";
						}
						$_SESSION['cargaTempFactPersonalizadaMod']['precios'][$nx] = $key['precios'];
						$_SESSION['cargaTempFactPersonalizadaMod']['conceptos'][$nx] = $key['conceptos'];
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