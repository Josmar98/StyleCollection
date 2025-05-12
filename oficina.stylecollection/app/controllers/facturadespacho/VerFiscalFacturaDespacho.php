<?php 

// $lider = new Models();
$id_campana = $_GET['campaing'];
$numero_campana = $_GET['n'];
$anio_campana = $_GET['y'];
$id_despacho = $_GET['dpid'];
$num_despacho = $_GET['dp'];
$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";
$menuPersonalizado = $menu3."route=".$_GET['route']."&action=".$_GET['action']."&id=".$_GET['id']."&t=".$_GET['t'];

$limiteElementos=5;
$moduloFacturacion="Factura";
$moduloFacturacionn="FacturaP";
$id_factura=$_GET['id'];
if(!empty($_POST)){
	if(!empty($_POST['cantidad_elementos']) && !empty($_POST['stock']) && !empty($_POST['inventario']) && !empty($_POST['tipos']) && !empty($_POST['total']) ){
		// print_r($_POST);
		$codigo = $_POST['codigo_identificador'];
		$limiteElementos = $_POST['limiteElementos'];
		$cantidad_elementos = $_POST['cantidad_elementos'];
		$stocks = $_POST['stock'];
		$inventarios = $_POST['inventario'];
		$tipos = $_POST['tipos'];
		$totales = $_POST['total'];
		// echo "<br>";
		$errores = 0;
		for ($i=0; $i < $cantidad_elementos; $i++) {
			$precio = ($totales[$i]/$stocks[$i]);
			// echo $id_campana." - ";
			// echo $id_despacho." - ";
			// echo $codigo." - ";
			// echo $stocks[$i]." - ";
			// echo $tipos[$i]." - ";
			// echo $inventarios[$i]." - ";
			// echo $totales[$i]." - ";
			
			// echo "<br>";

			$query = "INSERT INTO coleccion_modificada (id_coleccion_modificada, id_campana, id_despacho, id_factura, codigo_identificador, stock, tipo_inventario, id_inventario, precio_venta, total_venta, estatus) VALUES (DEFAULT, {$id_campana}, {$id_despacho}, {$id_factura}, '{$codigo}', {$stocks[$i]}, '{$tipos[$i]}', {$inventarios[$i]}, {$precio}, {$totales[$i]}, 1);";
			// echo "<br>".$query."<br>";
			$exec = $lider->registrar($query, "coleccion_modificada", "id_coleccion_modificada");
			if($exec['ejecucion']==true){

			}else{
				$errores++;
			}
			// echo "<br>";
			// echo "<br>";
			// echo "<br>";
		}
		if($errores==0){
			$response=1;
		}else{
			$response=2;
		}
	}
}
if(!empty($_GET['delete'])){
	$id_delete = $_GET['delete'];
	$query = "UPDATE coleccion_modificada SET estatus=0 WHERE id_coleccion_modificada={$id_delete}";
	$borrar = $lider->eliminar($query);
	if($borrar['ejecucion']==true){
		$response=1;
	}else{
		$response=2;
	}
	// die();
}
if(!empty($_GET['cerrar'])){
	$query = "UPDATE factura_despacho SET estado_factura=0 WHERE id_factura_despacho={$id_factura}";
	$borrar = $lider->modificar($query);
	// $borrar=['ejecucion'=>true];
	$errores = 0;
	if($borrar['ejecucion']==true){
		$notas = $lider->consultarQuery("SELECT * FROM factura_despacho, pedidos WHERE factura_despacho.id_pedido=pedidos.id_pedido and factura_despacho.id_factura_despacho={$id_factura}");
		$id_cliente = $notas[0]['id_cliente'];
		$id_almacen = $notas[0]['id_almacen'];
		$id_pedido = $notas[0]['id_pedido'];
		$fecha_operacion = date('Y-m-d H:i:s');
		$fecha_documento = date('Y-m-d');
		$numero_documento = $notas[0]['numero_control1'];
		$mostrarListaNotas=$_SESSION['mostrarFacturaFinal'.$_GET['id']];
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

			$concepto_factura = $key['precio'];
			$concepto_operacion = "Venta A Lideres";
			$leyenda = "Factura Cerrada";
			$buscarRepetido = $lider->consultarQuery("SELECT * FROM operaciones WHERE modulo_factura='{$moduloFacturacion}' and id_factura={$id_factura} and tipo_inventario={$key['tipo_inventario']} and id_inventario={$key['id_inventario']} and concepto_factura='{$concepto_factura}' and tipo_operacion='Salida'");
			if(count($buscarRepetido)<2){

			}

			$buscarCostos=$lider->consultarQuery("SELECT * FROM cartelera_costos WHERE id_inventario={$key['id_inventario']} and tipo_inventario='{$key['tipo_inventario']}' ORDER BY id_cartelera_costo DESC LIMIT 1");
			if(count($buscarCostos)>1){
				$costoHistorico = $buscarCostos[0]['costo_historico'];
				$costoPromedio = $buscarCostos[0]['costo_promedio'];
				$total_operacion=(float) number_format(($key['cantidad']*$costoPromedio),2,'.','');
				$total_almacen=(float) number_format(($stock_almacen*$costoPromedio),2,'.','');
				$total_total=(float) number_format(($stock_total*$costoPromedio),2,'.','');
			}
			$query = "INSERT INTO operaciones (id_operacion, tipo_operacion, transaccion, concepto, leyenda, tipo_persona, id_personal, id_inventario, id_almacen, tipo_inventario, fecha_operacion, fecha_documento, numero_documento, numero_control, stock_operacion, total_operacion, stock_operacion_almacen, total_operacion_almacen, stock_operacion_total, total_operacion_total, precio_venta, modulo_factura, id_factura, concepto_factura, estatus) VALUES (DEFAULT, 'Salida', 'Venta', '{$concepto_operacion}', '{$leyenda}', 'Cliente', {$id_cliente}, {$key['id_inventario']}, {$id_almacen}, '{$key['tipo_inventario']}', '{$fecha_operacion}', '{$fecha_documento}', '{$numero_documento}', '{$numero_documento}', {$key['cantidad']}, {$total_operacion}, {$stock_almacen}, {$total_almacen}, {$stock_total}, {$total_total}, {$precio_venta}, '{$moduloFacturacion}', {$id_factura}, '{$concepto_factura}', 1); ";
			// echo $query."<br><br>";
			$exec = $lider->registrar($query, "operaciones", "id_operacion");
			if($exec['ejecucion']==true){
			}else{
				$errores++;
			}
		}
		
		$_SESSION['mostrarFacturaFinal'.$_GET['id']]=[];

		// Aqui voy a registrar las colecciones como respaldo
		$listaColecciones = $_SESSION['listaColecciones'.$_GET['id']];
		foreach ($listaColecciones as $listCol) {
			if($listCol['cant']>0){
				$cant_tipo_coleccion = $listCol['cant'];
				$name_tipo_coleccion = ucwords(mb_strtolower($listCol['name']));
	
				$queryCol = "INSERT INTO despachos_facturados (id_despacho_facturado, id_pedido, nombre_coleccion, cantidad_coleccion, modulo_facturado, id_factura, estatus) VALUES (DEFAULT, {$id_pedido}, '{$name_tipo_coleccion}', {$cant_tipo_coleccion}, '{$moduloFacturacion}', {$id_factura}, 1)";
				$execCol = $lider->registrar($queryCol, "despachos_facturados","id_despacho_facturado");
				if($execCol['ejecucion']==true){
				}else{
					$errores++; 
				}
			}
		}
		$_SESSION['listaColecciones'.$_GET['id']]=[];
	}else{
		$errores++;
	}

	// echo $errores;
	if($errores==0){
		$response="1";
		// $menuResponse = $menu3."route=".$_GET['route']."&action=".$_GET['action']."&nota=".$_GET['nota']."&action=".$_GET['action']."&nota=".$_GET['nota'];
	}else{
		$response="2";
	}
	// die();
}
if(!empty($_GET['abrir'])){
	$query = "UPDATE factura_despacho SET estado_factura=1 WHERE id_factura_despacho={$id_factura}";
	$borrar = $lider->modificar($query);
	// $borrar=['ejecucion'=>true];
	$errores = 0;
	if($borrar['ejecucion']==true){
		$notas = $lider->consultarQuery("SELECT * FROM factura_despacho, pedidos WHERE factura_despacho.id_pedido=pedidos.id_pedido and factura_despacho.id_factura_despacho={$id_factura}");
		$id_cliente = $notas[0]['id_cliente'];
		$id_almacen = $notas[0]['id_almacen'];
		$fecha_operacion = date('Y-m-d H:i:s');
		$fecha_documento = date('Y-m-d');
		$numero_documento = $notas[0]['numero_control1'];
		$mostrarListaNotas=$_SESSION['mostrarFacturaFinal'.$_GET['id']];
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
			$concepto_factura = $key['precio'];
			$concepto_operacion = "Factura Abierta";
			$leyenda = "Factura Abierta";
			
			$buscarRepetido = $lider->consultarQuery("SELECT * FROM operaciones WHERE modulo_factura='{$moduloFacturacion}' and id_factura={$id_factura} and tipo_inventario={$key['tipo_inventario']} and id_inventario={$key['id_inventario']} and concepto_factura='{$concepto_factura}' and tipo_operacion='Entrada'");
			if(count($buscarRepetido)<2){
				
			}

			$buscarCostos=$lider->consultarQuery("SELECT * FROM cartelera_costos WHERE id_inventario={$key['id_inventario']} and tipo_inventario='{$key['tipo_inventario']}' ORDER BY id_cartelera_costo DESC LIMIT 1");
			if(count($buscarCostos)>1){
				$costoHistorico = $buscarCostos[0]['costo_historico'];
				$costoPromedio = $buscarCostos[0]['costo_promedio'];
				$total_operacion=(float) number_format(($key['cantidad']*$costoPromedio),2,'.','');
				$total_almacen=(float) number_format(($stock_almacen*$costoPromedio),2,'.','');
				$total_total=(float) number_format(($stock_total*$costoPromedio),2,'.','');
			}
			$query = "INSERT INTO operaciones (id_operacion, tipo_operacion, transaccion, concepto, leyenda, tipo_persona, id_personal, id_inventario, id_almacen, tipo_inventario, fecha_operacion, fecha_documento, numero_documento, numero_control, stock_operacion, total_operacion, stock_operacion_almacen, total_operacion_almacen, stock_operacion_total, total_operacion_total, precio_venta, modulo_factura, id_factura, concepto_factura, estatus) VALUES (DEFAULT, 'Entrada', 'Venta', '{$concepto_operacion}', '{$leyenda}', 'Cliente', {$id_cliente}, {$key['id_inventario']}, {$id_almacen}, '{$key['tipo_inventario']}', '{$fecha_operacion}', '{$fecha_documento}', '{$numero_documento}', '{$numero_documento}', {$key['cantidad']}, {$total_operacion}, {$stock_almacen}, {$total_almacen}, {$stock_total}, {$total_total}, {$precio_venta}, '{$moduloFacturacion}', {$id_factura}, '{$concepto_factura}', 1); ";
			// echo $query."<br><br>";
			$exec = $lider->registrar($query, "operaciones", "id_operacion");
			if($exec['ejecucion']==true){
			}else{
				$errores++;
			}
		}
		
		$_SESSION['mostrarFacturaFinal'.$_GET['id']]=[];

		$queryCol="DELETE FROM despachos_facturados WHERE id_factura={$id_factura} and modulo_facturado='{$moduloFacturacion}'";
		$execCol = $lider->eliminar($queryCol);
		if($execCol['ejecucion']==true){
		}else{
			$errores++; 
		}
	}else{
		$errores++;
	}
	if($errores==0){
		$response="1";
		// $menuResponse = $menu3."route=".$_GET['route']."&action=".$_GET['action']."&nota=".$_GET['nota']."&action=".$_GET['action']."&nota=".$_GET['nota'];
		// $_GET['e']=[];
	}else{
		$response="2";
	}
	// die();
}
// if(empty($_POST)){
	$query = "SELECT * FROM clientes, despachos, pedidos, factura_despacho WHERE despachos.id_despacho = pedidos.id_despacho and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and pedidos.id_pedido = factura_despacho.id_pedido and pedidos.id_despacho = $id_despacho and factura_despacho.id_factura_despacho=$id";
	$facturas = $lider->consultarQuery($query);
	
	$factura = $facturas[0];
	$id_pedido = $factura['id_pedido'];
	$emision = $factura['fecha_emision'];
	// $tasas = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa = '$emision'");
	// $tasa = $tasas[0];
	// $precio_coleccion = $tasa['monto_tasa'] * $factura['precio_coleccion'];
	$query = "SELECT * FROM opcion_factura_despacho WHERE opcion_factura_despacho.id_campana = {$id_campana} and estatus = 1";
	$facturas = $lider->consultarQuery($query);
	// $facturas = $facturas[0];
	// $precio_coleccion = $facturas['precio_coleccion_campana'];
	// $iva = $precio_coleccion/100*16;
	// $precio_coleccion_total = $precio_coleccion * $factura['cantidad_aprobado'];
	// $ivaT = $precio_coleccion_total/100*16;
	// $precio_final_factura = $ivaT+$precio_coleccion_total;
	
	// $numeroFactura = Count($facturas)-1;
	$num_factura2 = $factura['numero_factura'];
	if(strlen($num_factura2)==1){$num_factura = "00000".$num_factura2;}
	else if(strlen($num_factura2)==2){$num_factura = "0000".$num_factura2;}
	else if(strlen($num_factura2)==3){$num_factura = "000".$num_factura2;}
	else if(strlen($num_factura2)==4){$num_factura = "00".$num_factura2;}
	else if(strlen($num_factura2)==5){$num_factura = "0".$num_factura2;}
	else if(strlen($num_factura2)==6){$num_factura = $num_factura2;}
	else{$num_factura = $num_factura2;}
	
	
	// $simbolo="Bss";
	$simbolo="";
	$var = dirname(__DIR__, 3);
	$urlCss1 = $var . '/public/vendor/bower_components/bootstrap/dist/css/';
	$urlCss2 = $var . '/public/assets/css/';
	$urlImg = $var . '/public/assets/img/';
	
	ini_set('date.timezone', 'america/caracas');			//se establece la zona horaria
	date_default_timezone_set('america/caracas');
	
	
	$buscarFacturasVariadas = $lider->consultarQuery("SELECT * FROM factura_despacho_variadas WHERE id_factura_despacho={$factura['id_factura_despacho']} and estatus=1 ORDER BY factura_despacho_variadas.id_pedido_factura ASC");
	$procederVariado = false;
	$colecciones = [];
	$cantAprobadaTotal = 0;
	if(count($buscarFacturasVariadas)>1){
		$procederVariado = true;
		foreach ($buscarFacturasVariadas as $variadas) {
			if(!empty($variadas['id_factura_despacho'])){
				//Buscar despacho
				$idPedidoFactura=$variadas['id_pedido_factura'];
				$buscarDespacho = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido={$idPedidoFactura}");
				$idDespachoFactura = $buscarDespacho[0]['id_despacho'];
				
				$mostrarCantAprobadaTotal = $buscarDespacho[0]['cantidad_aprobado'];
				$mostrarCantAprobadaInd = $buscarDespacho[0]['cantidad_aprobado_individual'];

				$cantidadAprobadoFactura = $buscarDespacho[0]['cantidad_aprobado_individual'];
				$cantAprobadaTotal+=$cantidadAprobadoFactura;
	
				$coleccionesss=$lider->consultarQuery("SELECT id_coleccion, colecciones.id_despacho, colecciones.id_producto, despachos.numero_despacho, colecciones.cantidad_productos, colecciones.tipo_inventario_coleccion as tipo_inventario_col, producto, descripcion, productos.cantidad as cantidad, precio_producto, colecciones.estatus FROM despachos, colecciones, productos WHERE despachos.id_despacho = colecciones.id_despacho and productos.id_producto = colecciones.id_producto and despachos.estatus = 1 and colecciones.estatus = 1 and despachos.id_campana = {$id_campana} and despachos.id_despacho={$idDespachoFactura} ORDER BY colecciones.id_coleccion ASC;");
				foreach ($coleccionesss as $key) {
					if(!empty($key['id_coleccion'])){
						$key['cantidad_aprobado']=$cantidadAprobadoFactura;
						$colecciones[count($colecciones)]=$key;
					}
				}
				// echo "SELECT colecciones_secundarios.id_coleccion_sec as id_coleccion, colecciones_secundarios.id_producto, despachos.numero_despacho, colecciones_secundarios.cantidad_productos, productos.producto, productos.descripcion, productos.cantidad as cantidad, colecciones_secundarios.precio_producto, colecciones_secundarios.estatus, pedidos_secundarios.cantidad_aprobado_sec as cantidad_aprobado FROM despachos, pedidos_secundarios, despachos_secundarios, colecciones_secundarios, productos WHERE despachos.id_despacho and despachos_secundarios.id_despacho and despachos.id_despacho=pedidos_secundarios.id_despacho and pedidos_secundarios.id_despacho_sec=despachos_secundarios.id_despacho_sec and despachos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and pedidos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and productos.id_producto = colecciones_secundarios.id_producto and pedidos_secundarios.id_pedido={$idPedidoFactura} and despachos_secundarios.id_despacho={$idDespachoFactura}";
				$coleccionesSec = $lider->consultarQuery("SELECT colecciones_secundarios.id_coleccion_sec, colecciones_secundarios.id_coleccion_sec as id_coleccion, colecciones_secundarios.id_producto, colecciones_secundarios.tipo_inventario_coleccion_sec as tipo_inventario_col, despachos.numero_despacho, colecciones_secundarios.cantidad_productos, productos.producto, productos.descripcion, productos.cantidad as cantidad, colecciones_secundarios.precio_producto, colecciones_secundarios.estatus, pedidos_secundarios.cantidad_aprobado_sec as cantidad_aprobado FROM despachos, pedidos_secundarios, despachos_secundarios, colecciones_secundarios, productos WHERE despachos.id_despacho and despachos_secundarios.id_despacho and despachos.id_despacho=pedidos_secundarios.id_despacho and pedidos_secundarios.id_despacho_sec=despachos_secundarios.id_despacho_sec and despachos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and pedidos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and productos.id_producto = colecciones_secundarios.id_producto and pedidos_secundarios.id_pedido={$idPedidoFactura} and despachos_secundarios.id_despacho={$idDespachoFactura} ORDER BY colecciones_secundarios.id_coleccion_sec ASC;");
				foreach ($coleccionesSec as $key) {
					if(!empty($key['id_coleccion'])){
						$colecciones[count($colecciones)]=$key;
					}
				}
	
			}
		}
		// echo "<br><br>";
		// echo "APROBADOS: ".$cantAprobadaTotal;
		// foreach ($colecciones as $key) {
		// 	print_r($key);
		// 	echo "<br><br>";
		// }
		$colecciones[count($colecciones)]=['estatus'=>true];
	}else{
		$procederVariado = false;
		$mostrarCantAprobadaTotal = $factura['cantidad_aprobado'];
		$mostrarCantAprobadaInd = $factura['cantidad_aprobado_individual'];
		$cantAprobadaTotal = $factura['cantidad_aprobado_individual'];
		$colecciones=$lider->consultarQuery("SELECT id_coleccion, colecciones.id_despacho, colecciones.id_producto, despachos.numero_despacho, colecciones.cantidad_productos, colecciones.tipo_inventario_coleccion as tipo_inventario_col, producto, descripcion, productos.cantidad as cantidad, precio_producto, colecciones.estatus FROM despachos, colecciones, productos WHERE despachos.id_despacho = colecciones.id_despacho and productos.id_producto = colecciones.id_producto and despachos.estatus = 1 and colecciones.estatus = 1 and despachos.id_campana = {$id_campana} and despachos.id_despacho={$id_despacho} ORDER BY colecciones.id_coleccion ASC;");
	
		for ($i=0; $i < count($colecciones); $i++) {
			if(!empty($colecciones[$i]['id_coleccion'])){
				$colecciones[$i]['cantidad_aprobado']=$cantAprobadaTotal;
			}
		}
		$idPedidoFactura=$factura['id_pedido'];
		$idDespachoFactura = $factura['id_despacho'];
		// echo "Despacho: ".$idPedidoFactura."<br>";
		// echo "Pedido: ".$idDespachoFactura."<br>";
	
		$coleccionesSec = $lider->consultarQuery("SELECT colecciones_secundarios.id_coleccion_sec, colecciones_secundarios.id_coleccion_sec as id_coleccion, colecciones_secundarios.id_producto, colecciones_secundarios.tipo_inventario_coleccion_sec as tipo_inventario_col, despachos.numero_despacho, colecciones_secundarios.cantidad_productos, productos.producto, productos.descripcion, productos.cantidad as cantidad, colecciones_secundarios.precio_producto, colecciones_secundarios.estatus, pedidos_secundarios.cantidad_aprobado_sec as cantidad_aprobado FROM despachos, pedidos_secundarios, despachos_secundarios, colecciones_secundarios, productos WHERE despachos.id_despacho and despachos_secundarios.id_despacho and despachos.id_despacho=pedidos_secundarios.id_despacho and pedidos_secundarios.id_despacho_sec=despachos_secundarios.id_despacho_sec and despachos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and pedidos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and productos.id_producto = colecciones_secundarios.id_producto and pedidos_secundarios.id_pedido={$idPedidoFactura} and despachos_secundarios.id_despacho={$idDespachoFactura} ORDER BY colecciones_secundarios.id_coleccion_sec ASC;");
		// echo "SELECT colecciones_secundarios.id_coleccion_sec, colecciones_secundarios.id_coleccion_sec as id_coleccion, colecciones_secundarios.id_producto, despachos.numero_despacho, colecciones_secundarios.cantidad_productos, productos.producto, productos.descripcion, productos.cantidad as cantidad, colecciones_secundarios.precio_producto, colecciones_secundarios.estatus, pedidos_secundarios.cantidad_aprobado_sec as cantidad_aprobado FROM despachos, pedidos_secundarios, despachos_secundarios, colecciones_secundarios, productos WHERE despachos.id_despacho and despachos_secundarios.id_despacho and despachos.id_despacho=pedidos_secundarios.id_despacho and pedidos_secundarios.id_despacho_sec=despachos_secundarios.id_despacho_sec and despachos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and pedidos_secundarios.id_despacho_sec=colecciones_secundarios.id_despacho_sec and productos.id_producto = colecciones_secundarios.id_producto and pedidos_secundarios.id_pedido={$idPedidoFactura} and despachos_secundarios.id_despacho={$idDespachoFactura}";
	
		$coleccioness = array_pop($colecciones);
		foreach ($coleccionesSec as $key) {
			if(!empty($key['id_coleccion'])){
				$colecciones[count($colecciones)]=$key;
			}
		}
		$colecciones[count($colecciones)]=['estatus'=>true];
	}
	// $listaColecciones=[
	// 	'0'=>['cant'=>$mostrarCantAprobadaInd];
	// ]
// foreach ($colecciones as $key) {
// 	if(!empty($key[0])){
// 		echo $key['tipo_inventario_col']." | ";
// 		// echo $key['tipo_inventario_col']." | ";
// 		print_r($key);
// 		echo "<br><br>";
// 	}
// }

	$listaColecciones=[];
	$listaColecciones[count($listaColecciones)]=['cant'=>$mostrarCantAprobadaInd,'descripcion'=>"Cols. Cosmeticos" ,'name'=>"Cosmeticos"];
	$querySec="SELECT * FROM despachos_secundarios, pedidos_secundarios WHERE despachos_secundarios.id_despacho_sec=pedidos_secundarios.id_despacho_sec and despachos_secundarios.id_despacho={$id_despacho} and pedidos_secundarios.id_despacho={$id_despacho} and pedidos_secundarios.id_pedido={$idPedidoFactura}";
	$secundarios = $lider->consultarQuery($querySec);
	foreach($secundarios as $sec){ 
		if(!empty($sec['nombre_coleccion_sec'])){
			if($sec['cantidad_aprobado_sec']>0){
				$listaColecciones[count($listaColecciones)]=['cant'=>$sec['cantidad_aprobado_sec'],'descripcion'=>"Cols. ".$sec['nombre_coleccion_sec'],'name'=>$sec['nombre_coleccion_sec']];
			}
		}
	}



	$conTotalResumen = false;
	$extrem = 15;
	$topEM=30;
	if(!empty($_GET['t'])){
		$type=$_GET['t'];
		if($type==1){
			$extrem = 15;
			$topEM=30;
		}
		if($type==2){
			$extrem = 43;
			$topEM=75;
		}
	}else{
		$type=1;
	}
	$classMayus="";
	if($type==2){
		$classMayus="mayus";
	}
	if(!$conTotalResumen){ $extrem++; }
		$cifraMultiplo = 1;
		$sumPrecioFinal = 0;
		$nameFactura = "Factura N°";
	
		$countProducts = count($colecciones)-1;
		$countPage = 0;
		if($countProducts <= ($extrem-4)){
			$countPage = 1;
		} else {
			$newExtrem = 0;
			$countPage++;
		while($countProducts > (($extrem-4)+$newExtrem)){
			$countPage++;
			$newExtrem += $extrem-1;
		}
	}
	$numPage=1;
				
	$sumaTotales = 0;
	$sumCantProd = 0;
	$sumPrecioProductos = 0;
	$numero=1;
	$numeroReal=1;
	$numerosCols = count($colecciones);
	
	// echo $numerosCols." | ";
	if($numerosCols >= 1 && $numerosCols <= $extrem){
		$numLim=($extrem-4);
	}else if($numerosCols>$extrem){
		$numLim=($extrem-1);
	}
	
	
	// print_r($factura['id_almacen']);
	$id_almacen = $factura['id_almacen'];
	$productos = $lider->consultarQuery("SELECT * FROM productos");
	for ($i=0; $i < count($productos)-1; $i++) { 
		$operations = $lider->consultarQuery("SELECT * FROM operaciones WHERE estatus=1 and id_almacen={$id_almacen} and tipo_inventario='Productos' and id_inventario={$productos[$i]['id_producto']} ORDER BY id_operacion DESC;");
		if(!empty($operations[0])){
			$productos[$i]['stock_disponible'] = $operations[0]['stock_operacion_almacen'];
		}else{
			$productos[$i]['stock_disponible'] = 0;
		}
		// echo "=> ".$productos[$i]['stock_disponible']." ".$productos[$i]['producto']."<br>";
	}
	$mercancia = $lider->consultarQuery("SELECT * FROM mercancia");
	for ($i=0; $i < count($mercancia)-1; $i++) { 
		$operations = $lider->consultarQuery("SELECT * FROM operaciones WHERE estatus=1 and id_almacen={$id_almacen} and tipo_inventario='Mercancia' and id_inventario={$mercancia[$i]['id_mercancia']} ORDER BY id_operacion DESC;");
		if(!empty($operations[0])){
			$mercancia[$i]['stock_disponible'] = $operations[0]['stock_operacion_almacen'];
		}else{
			$mercancia[$i]['stock_disponible'] = 0;
		}
		// echo "=> ".$mercancia[$i]['stock_disponible']." ".$mercancia[$i]['mercancia']."<br>";

	}

	$productosAll = $lider->consultarQuery("SELECT * FROM productos WHERE estatus=1");
    $mercanciaAll = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1");
    $almacenes = $lider->consultarQuery("SELECT * FROM almacenes WHERE estatus=1");
    $productoss = [];
    $mercancias = [];

	$index=0;
	foreach($productosAll as $pd){ if(!empty($pd['id_producto'])){
	  $operacionesInv = $lider->consultarQuery("SELECT * FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_producto']} and id_almacen={$id_almacen} and tipo_inventario='Productos' ORDER BY id_operacion DESC");
	  if(count($operacionesInv)>1){
		if($operacionesInv[0]['stock_operacion_total']>0){
		  $productoss[$index]=$pd;
		  $productoss[$index]['stock_operacion_total'] = $operacionesInv[0]['stock_operacion_total'];
		  $productoss[$index]['stock_operacion_almacen'] = $operacionesInv[0]['stock_operacion_almacen'];
		  $index++;
		}
	  }
	} }

	$index=0;
	foreach($mercanciaAll as $pd){ if(!empty($pd['id_mercancia'])){
	  $operacionesInv = $lider->consultarQuery("SELECT * FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_mercancia']} and id_almacen={$id_almacen} and tipo_inventario='Mercancia' ORDER BY id_operacion DESC");
	  if(count($operacionesInv)>1){
		if($operacionesInv[0]['stock_operacion_total']>0){
		  $mercancias[$index]=$pd;
		  $mercancias[$index]['stock_operacion_total'] = $operacionesInv[0]['stock_operacion_total'];
		  $mercancias[$index]['stock_operacion_almacen'] = $operacionesInv[0]['stock_operacion_almacen'];
		  // $mercancia[$almacen['id_almacen']][$index]['total_operacion_total'] = $operacionesInv[0]['total_operacion_total'];
		  $index++;
		}
	  }
	} }
	
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
// }
// echo $info;
?>