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
		// print_r($_POST);
		$_SESSION['cargaTemporalNotaPersonalizada'] = $_POST;
		echo "1";
	}
	if (!empty($_POST['direccion_emision'])) {
		// print_r($_POST);
		$select = $_GET['select'];
		$name_leyenda="Venta";
		if($select==2){
			$name_leyenda="Promociones";
		}
		if($select==3){
			$name_leyenda="Credito Style";
		}

		$id_almacen = $_POST['almacen'];
		$observacion = $_POST['detalleObservacion'];
		$cantidad_registros = $_POST['cantidadRegistros'];
		$direccion = mb_strtoupper($_POST['direccion_emision']);
		$lugar = ucwords(mb_strtolower($_POST['lugar_emision']));
		$fecha = $_POST['fecha_emision'];
		$num = $_POST['numero'];
		$maxNumero = $lider->consultarQuery("SELECT MAX(notasentregapersonalizada.numero_nota_entrega) as numero_nota FROM notasentregapersonalizada WHERE estatus=1");
		if(!empty($maxNumero[0]['numero_nota'])){
			if($maxNumero[0]['numero_nota']>=$num){
				$num = $maxNumero[0]['numero_nota'];
				$num++;
			}
		}
		$nameAnalista = "";
		if(!empty($_POST['nombreanalista'])){
			$nameAnalista = ucwords(mb_strtolower($_POST['nombreanalista']));
		}
		$id_lider = $_POST['id_cliente'];
		if($select=="1"){
			$pedidoss = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = {$id_lider} and id_despacho = {$id_despacho}");
			if(!empty($pedidoss[0]['id_pedido'])){
				$id_pedido = $pedidoss[0]['id_pedido'];
			}else{
				$id_pedido = 0;
			}
		}
		if($select=="2"){
			$pedidoss = $lider->consultarQuery("SELECT * FROM promociones WHERE id_cliente = {$id_lider} and id_despacho = {$id_despacho}");
			if(!empty($pedidoss[0]['id_pedido'])){
				$id_pedido = $pedidoss[0]['id_pedido'];
			}else{
				$id_pedido = 0;
			}
		}
		if($select=="3"){
			// $pedidoss = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = {$id_lider} and id_despacho = {$id_despacho}");
			// $id_pedido = $pedidoss[0]['id_pedido'];
			$id_pedido=0;
		}
		
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
		$mercancia = [];
		if(!empty($_POST['mercancia'])){
			$mercancia = $_POST['mercancia'];
		}
		$conceptos = [];
		if(!empty($_POST['conceptos'])){
			$conceptos = $_POST['conceptos'];
		}
		$precios_venta = [];
		if(!empty($_POST['precios_venta'])){
			$precios_venta = $_POST['precios_venta'];
		}
		$precios_nota = [];
		if(!empty($_POST['precios_nota'])){
			$precios_nota = $_POST['precios_nota'];
		}
		$opts = [];
		if(!empty($_POST['opts'])){
			$opts = $_POST['opts'];
		}

		$max = count($opts);
		if($max!=$cantidad_registros){
			$max = $cantidad_registros;
		}
		$query = "INSERT INTO notasentregapersonalizada (id_nota_entrega_personalizada, id_cliente, id_pedido, id_campana, direccion_emision, lugar_emision, fecha_emision, numero_nota_entrega, nombreanalista, leyenda, observacion, id_almacen, estado_nota_personalizada, estatus) VALUES (DEFAULT, {$id_lider}, {$id_pedido}, {$id_campana}, '{$direccion}', '{$lugar}', '{$fecha}', {$num}, '{$nameAnalista}', '{$name_leyenda}', '{$observacion}', {$id_almacen}, 1, 1)";
		$exec = $lider->registrar($query, "notasentregapersonalizada", "id_nota_entrega_personalizada");
		// echo $query."<br><br>";
		// print_r($exec);
		if($exec['ejecucion']==true){
			$id_nota = $exec['id'];
			$nume = 0;
			$errores = 0;
			$sum = 0;
			for ($i=0; $i < $max; $i++){
				$premio_producto_act = "";
				$cantidadAct = $cantidades[$i];
				$tipoAct = $tipos[$i];
				$productoAct = $productos[$i];
				$mercanciaAct = $mercancia[$i];
				$conceptoAct = ucwords(mb_strtolower($conceptos[$i]));
				$precioVentaAct = $precios_venta[$i];
				$precioNotaAct = $precios_nota[$i];
				$optsAct = $opts[$i];
				if($tipoAct=="Productos"){
					$premio_producto_act = $productoAct;
				}
				if($tipoAct=="Mercancia"){
					$premio_producto_act = $mercanciaAct;
				}
				if($cantidadAct!="" && $tipoAct && $premio_producto_act!="" && $conceptoAct!="" && $precioVentaAct!="" && $precioNotaAct!=""){
					$query2 = "INSERT INTO opcionesentregapersonalizada (id_opcion_entrega_personalizada, id_nota_entrega_personalizada, cantidad, tipo, producto_premio, concepto, precios_venta, precios_nota, opcion, estatus) VALUES (DEFAULT, {$id_nota}, {$cantidadAct}, '{$tipoAct}', {$premio_producto_act}, '{$conceptoAct}', {$precioVentaAct}, {$precioNotaAct}, '{$optsAct}', 1)";
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


		// echo $response;
		// die();

		$almacenes = $lider->consultarQuery("SELECT * FROM almacenes WHERE estatus=1");
		if(!empty($_GET['admin']) && !empty($_GET['lider']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista")){
			$productosAll = $lider->consultarQuery("SELECT * FROM productos WHERE estatus=1");
			$mercanciaAll = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1");
			$detalleObservacion="";
			if($_GET['select']=="1"){
				$id = $_GET['lider'];
				$pedidos = $lider->consultarQuery("SELECT *, clientes.id_cliente as id_persona FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
				$pedido = $pedidos[0];
				$id_pedido = $pedido['id_pedido'];
				$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1");

				$factura = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido}");
				$numFactura = "";
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
			}
			if($_GET['select']=="2"){
				$id = $_GET['lider'][0];
				$ids = "";
				$limId = count($_GET['lider']);
				$indexOne=1;
				foreach ($_GET['lider'] as $idlid) {
					// echo $idlid." | ";
					$ids.="{$idlid}";
					if($indexOne<$limId){
						$ids.=", ";
					}
					$indexOne++;
				}
				$querys = "SELECT *, clientes.id_cliente as id_persona FROM clientes, promociones, promocion, productos_promocion WHERE productos_promocion.id_promocion=promocion.id_promocion and promocion.id_promocion = promociones.id_promocion and clientes.id_cliente = promociones.id_cliente and promociones.id_despacho={$id_despacho} and promocion.id_campana={$id_campana} and productos_promocion.id_campana={$id_campana} and promociones.estatus = 1 and clientes.estatus = 1 and promociones.id_promociones IN ({$ids}) ORDER BY clientes.id_cliente ASC";
				// $querys = "SELECT * FROM clientes, promociones, promocion WHERE promocion.id_promocion = promociones.id_promocion and clientes.id_cliente = promociones.id_cliente and promociones.id_despacho={$id_despacho} and promocion.id_campana={$id_campana} and promociones.estatus = 1 and clientes.estatus = 1 and promociones.id_promociones={$id} ORDER BY clientes.id_cliente ASC";
				$pedidos = $lider->consultarQuery($querys);
				$pedido = $pedidos[0];
				
				foreach ($pedidos as $ped) {
					if(!empty($ped['id_cliente'])){
						if($detalleObservacion!=""){ $detalleObservacion.="&nbsp&nbsp|&nbsp&nbsp"; }
						$detalleObservacion .= "(".$pedido['cantidad_aprobada_promocion'].") Promo ".$pedido['nombre_promocion'];
					}
				}
				$id_pedido = $pedido['id_pedido'];
				$id_premio = $pedido['id_producto'];
				$premioInv = $lider->consultarQuery("SELECT * FROM premios, premios_inventario WHERE premios.id_premio={$id_premio} and premios.id_premio=premios_inventario.id_premio and premios.estatus=1 and premios_inventario.estatus=1 ORDER BY premios_inventario.id_premio_inventario ASC;");
				$premiosInv = [];
				$index=0;
				for ($i=0; $i < count($premioInv)-1; $i++) { 
					$prinv = $premioInv[$i];
					$premiosInv[$index]=$prinv;
					// $prinv['id_inventario']
					if($prinv['tipo_inventario']=="Productos"){
						$inventarios = $lider->consultarQuery("SELECT *, producto as elemento, codigo_producto as codigo FROM productos WHERE id_producto={$prinv['id_inventario']}");
					}
					if($prinv['tipo_inventario']=="Mercancia"){
						$inventarios = $lider->consultarQuery("SELECT *, mercancia as elemento, codigo_mercancia as codigo FROM mercancia WHERE id_mercancia={$prinv['id_inventario']}");
					}
					foreach ($inventarios as $keys){
						if(!empty($keys['codigo'])){
							$premioInv[$i]['codigo']=$keys['codigo'];
							$premioInv[$i]['elemento']=$keys['elemento'];
							$premiosInv[$index]['codigo']=$keys['codigo'];
							$premiosInv[$index]['elemento']=$keys['elemento'];
						}
					}
					$index++;
				}
				// echo "Elementos: ".count($premiosInv);
				// foreach ($premiosInv as $key) {
				// 	print_r($key);
				// 	echo "<br><br><br>";
				// }


				$factura = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido}");
				$numFactura = "";
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
				// echo count($pedidos);
				
			}
			if($_GET['select']=="3"){
				$id = $_GET['lider'];
				$pedidos = $lider->consultarQuery("SELECT *, empleados.id_empleado as id_persona FROM empleados WHERE empleados.id_empleado = $id");
				$pedido = $pedidos[0];
				$numFactura="";
			}
		}
		if(!empty($_GET['select'])){
			if($_GET['select']=="1"){
				$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
			}
			if($_GET['select']=="2"){
				$lideres = $lider->consultarQuery("SELECT * FROM clientes, promociones, promocion WHERE promocion.id_promocion = promociones.id_promocion and clientes.id_cliente = promociones.id_cliente and promociones.id_despacho = {$id_despacho} and promocion.id_campana={$id_campana} and promociones.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
			}
			if($_GET['select']=="3"){
				$empleados = $lider->consultarQuery("SELECT * FROM empleados WHERE empleados.estatus = 1 ORDER BY empleados.primer_nombre, empleados.primer_apellido ASC");
			}
		}

		$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
		unset($_SESSION['cargaTemporalNotaPersonalizada']);
		$nume = $num;


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
		$queryAnalista = "SELECT *, clientes.estatus as estatus_cliente, usuarios.estatus as estatus_usuario, roles.estatus as estatus_rol FROM clientes, usuarios, roles WHERE clientes.id_cliente=usuarios.id_cliente and usuarios.id_rol=roles.id_rol and roles.nombre_rol in ('Analista', 'Analista Supervisor') and usuarios.estatus=1";
		$analistasList=$lider->consultarQuery($queryAnalista);


		$almacenes = $lider->consultarQuery("SELECT * FROM almacenes WHERE estatus=1");
		$detalleObservacion="";
		$cantPromos=1;
		if(!empty($_GET['admin']) && !empty($_GET['lider']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista")){
			$productosAll = $lider->consultarQuery("SELECT * FROM productos WHERE estatus=1");
			$mercanciaAll = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1");

			if($_GET['select']=="1"){
				$id = $_GET['lider'];
				$pedidos = $lider->consultarQuery("SELECT *, clientes.id_cliente as id_persona FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
				$pedido = $pedidos[0];
				$id_pedido = $pedido['id_pedido'];
				$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1");

				$factura = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido}");
				$numFactura = "";
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
			}
			if($_GET['select']=="2"){
				$cantPromos=0;
				$id = $_GET['lider'][0];
				$ids = "";
				$limId = count($_GET['lider']);
				$indexOne=1;
				foreach ($_GET['lider'] as $idlid) {
					// echo $idlid." | ";
					$ids.="{$idlid}";
					if($indexOne<$limId){
						$ids.=", ";
					}
					$indexOne++;
				}
				$querys = "SELECT *, clientes.id_cliente as id_persona FROM clientes, promociones, promocion, productos_promocion WHERE productos_promocion.id_promocion=promocion.id_promocion and promocion.id_promocion = promociones.id_promocion and clientes.id_cliente = promociones.id_cliente and promociones.id_despacho={$id_despacho} and promocion.id_campana={$id_campana} and productos_promocion.id_campana={$id_campana} and promociones.estatus = 1 and clientes.estatus = 1 and promociones.id_promociones IN ({$ids}) ORDER BY clientes.id_cliente ASC";
				// $querys = "SELECT * FROM clientes, promociones, promocion WHERE promocion.id_promocion = promociones.id_promocion and clientes.id_cliente = promociones.id_cliente and promociones.id_despacho={$id_despacho} and promocion.id_campana={$id_campana} and promociones.estatus = 1 and clientes.estatus = 1 and promociones.id_promociones={$id} ORDER BY clientes.id_cliente ASC";
				$pedidos = $lider->consultarQuery($querys);
				$pedido = $pedidos[0];
				$detalleObservacion="";
				foreach ($pedidos as $ped) {
					if(!empty($ped['id_cliente'])){
						$cantPromos+=$pedido['cantidad_aprobada_promocion'];
						if($detalleObservacion!=""){ $detalleObservacion.="&nbsp&nbsp|&nbsp&nbsp"; }
						$detalleObservacion .= "(".$pedido['cantidad_aprobada_promocion'].") Promo ".$pedido['nombre_promocion'];
					}
				}
				$id_pedido = $pedido['id_pedido'];
				$id_premio = $pedido['id_producto'];
				$premioInv = $lider->consultarQuery("SELECT * FROM premios, premios_inventario WHERE premios.id_premio={$id_premio} and premios.id_premio=premios_inventario.id_premio and premios.estatus=1 and premios_inventario.estatus=1 ORDER BY premios_inventario.id_premio_inventario ASC;");
				$premiosInv = [];
				$index=0;
				for ($i=0; $i < count($premioInv)-1; $i++) { 
					$prinv = $premioInv[$i];
					$premiosInv[$index]=$prinv;
					// $prinv['id_inventario']
					if($prinv['tipo_inventario']=="Productos"){
						$inventarios = $lider->consultarQuery("SELECT *, producto as elemento, codigo_producto as codigo FROM productos WHERE id_producto={$prinv['id_inventario']}");
					}
					if($prinv['tipo_inventario']=="Mercancia"){
						$inventarios = $lider->consultarQuery("SELECT *, mercancia as elemento, codigo_mercancia as codigo FROM mercancia WHERE id_mercancia={$prinv['id_inventario']}");
					}
					foreach ($inventarios as $keys){
						if(!empty($keys['codigo'])){
							$premioInv[$i]['codigo']=$keys['codigo'];
							$premioInv[$i]['elemento']=$keys['elemento'];
							$premiosInv[$index]['codigo']=$keys['codigo'];
							$premiosInv[$index]['elemento']=$keys['elemento'];
						}
					}
					$index++;
				}
				// echo "Elementos: ".count($premiosInv);
				// foreach ($premiosInv as $key) {
				// 	print_r($key);
				// 	echo "<br><br><br>";
				// }


				$factura = $lider->consultarQuery("SELECT * FROM factura_despacho WHERE id_pedido = {$id_pedido}");
				$numFactura = "";
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
				// echo count($pedidos);
				
			}
			if($_GET['select']=="3"){
				$id = $_GET['lider'];
				$pedidos = $lider->consultarQuery("SELECT *, empleados.id_empleado as id_persona FROM empleados WHERE empleados.id_empleado = $id");
				$pedido = $pedidos[0];
				$numFactura="";
			}
		}
		if(!empty($_GET['select'])){
			if($_GET['select']=="1"){
				$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
			}
			if($_GET['select']=="2"){
				$lideres = $lider->consultarQuery("SELECT * FROM clientes, promociones, promocion WHERE promocion.id_promocion = promociones.id_promocion and clientes.id_cliente = promociones.id_cliente and promociones.id_despacho = {$id_despacho} and promocion.id_campana={$id_campana} and promociones.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
			}
			if($_GET['select']=="3"){
				$empleados = $lider->consultarQuery("SELECT * FROM empleados WHERE empleados.estatus = 1 ORDER BY empleados.primer_nombre, empleados.primer_apellido ASC");
			}
		}
		// $lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

		$notas = $lider->consultarQuery("SELECT * FROM notasentrega WHERE estatus = 1");
		$notasPer = $lider->consultarQuery("SELECT * FROM notasentregapersonalizada WHERE estatus = 1");
		$nume1 = 0;
		$nume2 = 0;
		$nume = 0;
		if(count($notas)>1){
			foreach ($notas as $key) {
				if(!empty($key['id_nota_entrega'])){
					if($key['numero_nota_entrega'] > $nume){
						$nume1 = $key['numero_nota_entrega'];
					}
				}
			}
		}
		if(count($notasPer)>1){
			foreach ($notasPer as $key) {
				if(!empty($key['id_nota_entrega_personalizada'])){
					if($key['numero_nota_entrega'] > $nume){
						$nume2 = $key['numero_nota_entrega'];
					}
				}
			}
		}
		if($nume1 > $nume2){
			$nume = $nume1;
		}else{
			$nume = $nume2;
		}

		
		$nume++;
		if(empty($_GET['cant'])){
			unset($_SESSION['cargaTemporalNotaPersonalizada']);	
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
		// }else{
			    // require_once 'public/views/error404.php';
		// }

	}
}else{
   require_once 'public/views/error404.php';
}
?>