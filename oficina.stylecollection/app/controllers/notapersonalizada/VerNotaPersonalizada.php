<?php 

	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }
	// $lider = new Models();
// if($_SESSION['nombre_rol']!="Superusuario"){ die(); }
  $id_campana = $_GET['campaing'];
  $numero_campana = $_GET['n'];
  $anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

	$menuPersonalizado = $menu3."route=".$_GET['route']."&action=".$_GET['action']."&nota=".$_GET['nota']."&";

	$estado_campana2 = $lider->consultarQuery("SELECT estado_campana FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
    $estado_campana = $estado_campana2[0]['estado_campana'];
    if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
		$estado_campana = "1";
	}
	$limiteElementos=5;
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
	$id_nota = $_GET['nota'];
	$moduloFacturacion="NotasP";
	if(!empty($_POST)){
		if(!empty($_POST['cantidad_elementos']) && !empty($_POST['stock']) && !empty($_POST['inventario']) && !empty($_POST['tipos']) ){
			// print_r($_POST);
			// die();
			$id_nota_entrega = $_GET['nota'];
			$codigo = $_POST['codigo_identificador'];
			$limiteElementos = $_POST['limiteElementos'];
			$cantidad_elementos = $_POST['cantidad_elementos'];
			$stocks = $_POST['stock'];
			$inventarios = $_POST['inventario'];
			$precio_venta = $_POST['precio_venta'];
			$precio_nota = $_POST['precio_nota'];
			$tipos = $_POST['tipos'];

			// echo "<br>";
			$errores = 0;
			for ($i=0; $i < $cantidad_elementos; $i++) {
				if(strlen(strpos($inventarios[$i],'m'))==0){
				}else{
					$inventarios[$i]=substr($inventarios[$i],1);
	
				}
				// echo $id_campana." - ";
				// echo $id_despacho." - ";
				// echo $codigo." - ";
				// echo $stocks[$i]." - ";
				// echo $tipos[$i]." - ";
				// echo $inventarios[$i]." - ";
				// echo $totales[$i]." - ";
				
				// echo "<br>";
	
				$query = "INSERT INTO notas_modificada_personalizada (id_nota_modificada_personalizada, id_campana, id_despacho, id_nota_entrega_personalizada, codigo_identificador, stock, tipo_inventario, precio_venta, precio_nota, id_inventario, estatus) VALUES (DEFAULT, {$id_campana}, {$id_despacho}, {$id_nota_entrega}, '{$codigo}', {$stocks[$i]}, '{$tipos[$i]}', {$precio_venta[$i]}, {$precio_nota[$i]}, {$inventarios[$i]}, 1);";
				// echo "<br>".$query."<br>";
				$exec = $lider->registrar($query, "notas_modificada_personalizada", "id_nota_modificada_personalizada");
				if($exec['ejecucion']==true){
				}else{
					$errores++;
				}
				// echo "<br>";
				// echo "<br>";
				// echo "<br>";
			}
			if($errores==0){
				$response="11";
				$menuResponse = $menu3."route=".$_GET['route']."&action=".$_GET['action']."&nota=".$_GET['nota']."&action=".$_GET['action']."&nota=".$_GET['nota'];
				$_GET['e']=[];
			}else{
				$response="2";
			}
			// die();
		}
		if(!empty($_POST['observaciones'])){
			$observacion = ucwords(mb_strtolower($_POST['observaciones']));
			$execModif = $lider->modificar("UPDATE notasentregapersonalizada SET observacion='{$observacion}' WHERE id_nota_entrega_personalizada={$id_nota}");
			if($execModif['ejecucion']==true){
				echo "1";
			}else{
				echo "2";
			}
			die();
		}
	}
	if(!empty($_GET['delete'])){
		$id_delete = $_GET['delete'];
		$query = "UPDATE notas_modificada_personalizada SET estatus=0 WHERE id_nota_modificada_personalizada={$id_delete}";
		$borrar = $lider->eliminar($query);
		if($borrar['ejecucion']==true){
			$response="11";
			$menuResponse = $menu3."route=".$_GET['route']."&action=".$_GET['action']."&nota=".$_GET['nota']."&action=".$_GET['action']."&nota=".$_GET['nota'];
			$_GET['e']=[];
		}else{
			$response="2";
		}
		// die();
	}
	if(!empty($_GET['cerrar'])){
		// die();
		// die();
		$query = "UPDATE notasentregapersonalizada SET estado_nota_personalizada=0 WHERE id_nota_entrega_personalizada={$id_nota}";
		$borrar = $lider->modificar($query);
		// $borrar=['ejecucion'=>true];
		$errores = 0;
		if($borrar['ejecucion']==true){
			$notas = $lider->consultarQuery("SELECT * FROM notasentregapersonalizada WHERE id_nota_entrega_personalizada={$id_nota}");
			$id_cliente = $notas[0]['id_cliente'];
			$id_almacen = $notas[0]['id_almacen'];
			$tipo_persona="Cliente";
			if($notas[0]['leyenda']=="Credito Style"){
				$tipo_persona="Empleado";
			}
			$fecha_operacion = date('Y-m-d H:i:s');
			$fecha_documento = date('Y-m-d');
			$numero_documento = $notas[0]['numero_nota_entrega'];
			$mostrarListaNotas=$_SESSION['mostrarNotasResumidasNotaPerso'.$_GET['nota']];
			foreach ($mostrarListaNotas as $key) {
				$operaciones = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$key['id_inventario']} and tipo_inventario='{$key['tipo_inventario']}' and id_almacen={$id_almacen} ORDER BY id_operacion DESC;");
				$total_operacion = 0;
				$stock_almacen = 0;
				$total_almacen = 0;
				$precio_venta = 0;
				if(!empty($operaciones[0])){
					// print_r($key);
					// echo "<br><br>";
					// print_r($operaciones[0]);
					// echo "<br><br>";
					$precio_venta = (float) number_format($key['precio_venta'],2,'.','');
					// $precio_venta = $operaciones[0]['total_operacion'] / $operaciones[0]['stock_operacion'];
					$stock_almacen = $operaciones[0]['stock_operacion_almacen'];
					$total_operacion = (float) number_format($precio_venta*$key['cantidad'],2,'.','');
					$stock_almacen = $stock_almacen-$key['cantidad'];
					$total_almacen = (float) number_format($precio_venta*$stock_almacen,2,'.','');
				}
		
				$operaciones = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$key['id_inventario']} and tipo_inventario='{$key['tipo_inventario']}' ORDER BY id_operacion DESC;");
				$stock_total = 0;
				$total_total = 0;
				if(!empty($operaciones[0])){
					$stock_total = $operaciones[0]['stock_operacion_total'];
					$stock_total = $stock_total-$key['cantidad'];
					$total_total = (float) number_format($precio_venta*$stock_total,2,'.','');
				}
				// if($_GET['select']==1){
				// 	$leyendaa="Venta";
				// }
				// if($_GET['select']==2){
				// 	$leyendaa="Promociones";
				// }
				// if($_GET['select']==3){
				// 	$leyendaa="Crédito Style";
				// }
				$conceptoFactura = $key['concepto'];
				$concepto_operacion = "Venta A Lideres";
				$leyenda = "Factura Cerrada";

				// $buscarRepetido = $lider->consultarQuery("SELECT * FROM operaciones WHERE modulo_factura='{$moduloFacturacion}' and id_factura={$id_nota} and tipo_inventario={$key['tipo_inventario']} and id_inventario={$key['id_inventario']} and concepto_factura='{$concepto_factura}' and precio_nota={$precio_nota} and tipo_operacion='Entrada'");
				// if(count($buscarRepetido)<2){
					
				// }

				$buscarCostos=$lider->consultarQuery("SELECT * FROM cartelera_costos WHERE id_inventario={$key['id_inventario']} and tipo_inventario='{$key['tipo_inventario']}' ORDER BY id_cartelera_costo DESC LIMIT 1");
				if(count($buscarCostos)>1){
					$costoHistorico = $buscarCostos[0]['costo_historico'];
					$costoPromedio = $buscarCostos[0]['costo_promedio'];
					$total_operacion=(float) number_format(($key['cantidad']*$costoPromedio),2,'.','');
					$total_almacen=(float) number_format(($stock_almacen*$costoPromedio),2,'.','');
					$total_total=(float) number_format(($stock_total*$costoPromedio),2,'.','');
				}
				$query = "INSERT INTO operaciones (id_operacion, tipo_operacion, transaccion, concepto, leyenda, tipo_persona, id_personal, id_inventario, id_almacen, tipo_inventario, fecha_operacion, fecha_documento, numero_documento, numero_control, stock_operacion, total_operacion, stock_operacion_almacen, total_operacion_almacen, stock_operacion_total, total_operacion_total, precio_venta, modulo_factura, id_factura, concepto_factura, estatus) VALUES (DEFAULT, 'Salida', 'Venta', '{$concepto_operacion}', '{$leyenda}', '{$tipo_persona}', {$id_cliente}, {$key['id_inventario']}, {$id_almacen}, '{$key['tipo_inventario']}', '{$fecha_operacion}', '{$fecha_documento}', {$numero_documento}, {$numero_documento}, {$key['cantidad']}, {$total_operacion}, {$stock_almacen}, {$total_almacen}, {$stock_total}, {$total_total}, {$precio_venta}, '{$moduloFacturacion}', {$id_nota}, '{$conceptoFactura}', 1); ";
				// echo $query."<br><br>";
				$exec = $lider->registrar($query, "operaciones", "id_operacion");
				if($exec['ejecucion']==true){
				}else{
					$errores++;
				}
			}
			$_SESSION['mostrarNotasResumidasNotaPerso'.$_GET['nota']]=[];
		}else{
			$errores++;
		}
		// die();
		if($errores==0){
			$response="11";
			$menuResponse = $menu3."route=".$_GET['route']."&action=".$_GET['action']."&nota=".$_GET['nota']."&action=".$_GET['action']."&nota=".$_GET['nota'];
			$_GET['e']=[];
		}else{
			$response="2";
		}
	}
	if(!empty($_GET['abrir'])){
		$query = "UPDATE notasentregapersonalizada SET estado_nota_personalizada=1 WHERE id_nota_entrega_personalizada={$id_nota}";
		// $query = "UPDATE notasentrega  SET estado_nota=1 WHERE id_nota_entrega={$id_nota}";
		$borrar = $lider->modificar($query);
		$errores = 0;
		if($borrar['ejecucion']==true){
			$notas = $lider->consultarQuery("SELECT * FROM notasentregapersonalizada WHERE id_nota_entrega_personalizada={$id_nota}");
			$id_cliente = $notas[0]['id_cliente'];
			$id_almacen = $notas[0]['id_almacen'];
			$tipo_persona="Cliente";
			if($notas[0]['leyenda']=="Credito Style"){
				$tipo_persona="Empleado";
			}
			$fecha_operacion = date('Y-m-d H:i:s');
			$fecha_documento = date('Y-m-d');
			$numero_documento = $notas[0]['numero_nota_entrega'];
			$mostrarListaNotas=$_SESSION['mostrarNotasResumidasNotaPerso'.$_GET['nota']];
			foreach ($mostrarListaNotas as $key) {
				$operaciones = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$key['id_inventario']} and tipo_inventario='{$key['tipo_inventario']}' and id_almacen={$id_almacen} ORDER BY id_operacion DESC;");
				$total_operacion = 0;
				$stock_almacen = 0;
				$total_almacen = 0;
				$precio_venta = 0;
				if(!empty($operaciones[0])){
					$precio_venta = (float) number_format(($operaciones[0]['total_operacion'] / $operaciones[0]['stock_operacion']),2,'.','');
					$stock_almacen = $operaciones[0]['stock_operacion_almacen'];
					$total_operacion = (float) number_format($precio_venta*$key['cantidad'],2,'.','');
					$stock_almacen = $stock_almacen+$key['cantidad'];
					$total_almacen = (float) number_format($precio_venta*$stock_almacen,2,'.','');
				}
		
				$operaciones = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$key['id_inventario']} and tipo_inventario='{$key['tipo_inventario']}' ORDER BY id_operacion DESC;");
				$stock_total = 0;
				$total_total = 0;
				if(!empty($operaciones[0])){
					$stock_total = $operaciones[0]['stock_operacion_total'];
					$stock_total = $stock_total+$key['cantidad'];
					$total_total = (float) number_format($precio_venta*$stock_total,2,'.','');
				}

				$conceptoFactura = $key['concepto'];
				$concepto_operacion = "Factura Abierta";
				$leyenda = "Factura Abierta";

				$buscarCostos=$lider->consultarQuery("SELECT * FROM cartelera_costos WHERE id_inventario={$key['id_inventario']} and tipo_inventario='{$key['tipo_inventario']}' ORDER BY id_cartelera_costo DESC LIMIT 1");
				if(count($buscarCostos)>1){
					$costoHistorico = $buscarCostos[0]['costo_historico'];
					$costoPromedio = $buscarCostos[0]['costo_promedio'];
					$total_operacion=(float) number_format(($key['cantidad']*$costoPromedio),2,'.','');
					$total_almacen=(float) number_format(($stock_almacen*$costoPromedio),2,'.','');
					$total_total=(float) number_format(($stock_total*$costoPromedio),2,'.','');
				}
				$query = "INSERT INTO operaciones (id_operacion, tipo_operacion, transaccion, concepto, leyenda, tipo_persona, id_personal, id_inventario, id_almacen, tipo_inventario, fecha_operacion, fecha_documento, numero_documento, numero_control, stock_operacion, total_operacion, stock_operacion_almacen, total_operacion_almacen, stock_operacion_total, total_operacion_total, precio_venta, modulo_factura, id_factura, concepto_factura, estatus) VALUES (DEFAULT, 'Entrada', 'Venta', '{$concepto_operacion}', '{$leyenda}', '{$tipo_persona}', {$id_cliente}, {$key['id_inventario']}, {$id_almacen}, '{$key['tipo_inventario']}', '{$fecha_operacion}', '{$fecha_documento}', {$numero_documento}, {$numero_documento}, {$key['cantidad']}, {$total_operacion}, {$stock_almacen}, {$total_almacen}, {$stock_total}, {$total_total}, {$precio_venta}, '{$moduloFacturacion}', {$id_nota}, '{$conceptoFactura}', 1); ";
				// echo $query."<br><br>";
				$exec = $lider->registrar($query, "operaciones", "id_operacion");
				if($exec['ejecucion']==true){
				}else{
					$errores++;
				}
			}
			$_SESSION['mostrarNotasResumidasNotaPerso'.$_GET['nota']]=[];
		}else{
			$errores++;
		}
		if($errores==0){
			$response="11";
			$menuResponse = $menu3."route=".$_GET['route']."&action=".$_GET['action']."&nota=".$_GET['nota']."&action=".$_GET['action']."&nota=".$_GET['nota'];
			$_GET['e']=[];
		}else{
			$response="2";
		}
	}

	$notaP = $lider->consultarQuery("SELECT * FROM notasentregapersonalizada WHERE id_nota_entrega_personalizada = {$id_nota}");
	if(count($notaP)>1){
		$notaP = $notaP[0];
		$id_cliente = $notaP['id_cliente'];
		if(mb_strtolower($notaP['leyenda'])=="credito style"){
			$persona = $lider->consultarQuery("SELECT * FROM empleados WHERE id_empleado={$id_cliente}");
		}else{
			$persona = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente={$id_cliente}");
		}
		if(count($persona)>1){
			$persona=$persona[0];
		}
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
		// $productos = $lider->consultarQuery("SELECT * FROM productos");
		// $premios = $lider->consultarQuery("SELECT * FROM premios");

		$opcionesEntregas = $lider->consultarQuery("SELECT *, tipo as tipo_inventario, producto_premio as id_inventario FROM notasentregapersonalizada, opcionesentregapersonalizada WHERE notasentregapersonalizada.id_nota_entrega_personalizada=opcionesentregapersonalizada.id_nota_entrega_personalizada and opcionesentregapersonalizada.id_nota_entrega_personalizada = {$id_nota} ORDER BY opcionesentregapersonalizada.id_opcion_entrega_personalizada ASC;");
		for ($i=0; $i < count($opcionesEntregas)-1; $i++) { 
			$temp = $opcionesEntregas[$i];
			if($temp['tipo_inventario']=="Productos"){
				$inventario = $lider->consultarQuery("SELECT *, producto as elemento, producto as descripcion, codigo_producto as codigo FROM productos WHERE id_producto={$temp['id_inventario']} and estatus=1");
			}
			if($temp['tipo_inventario']=="Mercancia"){
				$inventario = $lider->consultarQuery("SELECT *, mercancia as elemento, mercancia as descripcion, codigo_mercancia as codigo FROM mercancia WHERE id_mercancia={$temp['id_inventario']} and estatus=1");
			}
			foreach ($inventario as $key){
				if(!empty($key['elemento'])){
					$opcionesEntregas[$i]['elemento']=$key['elemento'];
					$opcionesEntregas[$i]['descripcion']=$key['descripcion'];
					$opcionesEntregas[$i]['codigo']=$key['codigo'];
				}
			}
			// $temp = $opcionesEntregas[$i];
			// print_r($temp);
			// echo "<br><br>";
		}
		
		$productosAll = $lider->consultarQuery("SELECT * FROM productos");
		$mercanciaAll = $lider->consultarQuery("SELECT * FROM mercancia");
		$almacenes = $lider->consultarQuery("SELECT * FROM almacenes WHERE estatus=1");
		$productoss = [];
		$mercancias = [];
		$id_almacen = $notaP['id_almacen'];
		$index=0;
		foreach($productosAll as $pd){ if(!empty($pd['id_producto'])){
			$operacionesInv = $lider->consultarQuery("SELECT * FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_producto']} and id_almacen={$id_almacen} and tipo_inventario='Productos' ORDER BY id_operacion DESC");
			$productoss[$index]=$pd;
			$productoss[$index]['stock_operacion_total'] = 0;
			$productoss[$index]['stock_operacion_almacen'] = 0;
			$productoss[$index]['stock_disponible'] = 0;
			if(count($operacionesInv)>1){
				if($operacionesInv[0]['stock_operacion_almacen']>0){
					$productoss[$index]['stock_operacion_total'] = $operacionesInv[0]['stock_operacion_total'];
					$productoss[$index]['stock_operacion_almacen'] = $operacionesInv[0]['stock_operacion_almacen'];
					$productoss[$index]['stock_disponible'] = $operacionesInv[0]['stock_operacion_almacen'];
				}else{

				}
			}
			$index++;
		} }
	
		$index=0;
		foreach($mercanciaAll as $pd){ if(!empty($pd['id_mercancia'])){
			$operacionesInv = $lider->consultarQuery("SELECT * FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_mercancia']} and id_almacen={$id_almacen} and tipo_inventario='Mercancia' ORDER BY id_operacion DESC");
			$mercancias[$index]=$pd;
			$mercancias[$index]['stock_operacion_total']=0;
			$mercancias[$index]['stock_operacion_almacen']=0;
			$mercancias[$index]['stock_disponible']=0;
			if(count($operacionesInv)>1){
				if($operacionesInv[0]['stock_operacion_almacen']>0){
						$mercancias[$index]['stock_operacion_total'] = $operacionesInv[0]['stock_operacion_total'];
						$mercancias[$index]['stock_operacion_almacen'] = $operacionesInv[0]['stock_operacion_almacen'];
						$mercancias[$index]['stock_disponible'] = $operacionesInv[0]['stock_operacion_almacen'];
				}
			}
			$index++;
		} }
		// print_r($persona);

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
}else{
   require_once 'public/views/error404.php';
}
?>