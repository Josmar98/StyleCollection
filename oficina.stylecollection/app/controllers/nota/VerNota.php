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

	$menuPersonalizado = $menu3."route=".$_GET['route']."&action=".$_GET['action']."&nota=".$_GET['nota']."&";

	$limiteElementos=5;
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
$moduloFacturacion="Notas";
$id_nota = $_GET['nota'];

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
		$tipos = $_POST['tipos'];
		$precios_venta = $_POST['precio_venta'];
		$precios_nota = $_POST['precio_nota'];
		// echo "<br>";
		$errores = 0;
		// die();
		for ($i=0; $i < $cantidad_elementos; $i++) {
			if(strlen(strpos($inventarios[$i],'m'))==0){
			}else{
				$inventarios[$i]=substr($inventarios[$i],1);

			}
			$precio_venta=(float) number_format($precios_venta[$i],2,'.','');
			$precio_nota=(float) number_format($precios_nota[$i],2,'.','');
			// echo $id_campana." - ";
			// echo $id_despacho." - ";
			// echo $codigo." - ";
			// echo $stocks[$i]." - ";
			// echo $tipos[$i]." - ";
			// echo $inventarios[$i]." - ";
			// echo $totales[$i]." - ";
			// echo "<br>";

			$query = "INSERT INTO notas_modificada (id_nota_modificada, id_campana, id_despacho, id_nota_entrega, codigo_identificador, stock, tipo_inventario, id_inventario, precio_venta, precio_nota, estatus) VALUES (DEFAULT, {$id_campana}, {$id_despacho}, {$id_nota_entrega}, '{$codigo}', {$stocks[$i]}, '{$tipos[$i]}', {$inventarios[$i]}, {$precio_venta}, {$precio_nota}, 1);";
			// echo "<br>".$query."<br>";
			$exec = $lider->registrar($query, "notas_modificada", "id_nota_modificada");
			if($exec['ejecucion']==true){
			}else{
				$errores++;
			}
		}
		// die();
		if($errores==0){
			$response="11";
			$menuResponse = $menu3."route=".$_GET['route']."&action=".$_GET['action']."&nota=".$_GET['nota'];
			$_GET['e']=[];
		}else{
			$response="2";
		}
	}
	if(!empty($_POST['observaciones'])){
		$observacion = ucwords(mb_strtolower($_POST['observaciones']));
		$execModif = $lider->modificar("UPDATE notasentrega SET observaciones='{$observacion}' WHERE id_nota_entrega={$id_nota}");
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
	$query = "UPDATE notas_modificada SET estatus=0 WHERE id_nota_modificada={$id_delete}";
	$borrar = $lider->eliminar($query);
	if($borrar['ejecucion']==true){
		$response="11";
		$menuResponse = $menu3."route=".$_GET['route']."&action=".$_GET['action']."&nota=".$_GET['nota'];
		$_GET['e']=[];
	}else{
		$response="2";
	}
}


if(!empty($_GET['cerrar'])){
	// die();
	
	// die();
	$query = "UPDATE notasentrega  SET estado_nota=0 WHERE id_nota_entrega={$id_nota}";
	$borrar = $lider->modificar($query);
	$errores = 0;
	if($borrar['ejecucion']==true){
		$notas = $lider->consultarQuery("SELECT * FROM notasentrega WHERE id_nota_entrega={$id_nota}");
		$id_cliente = $notas[0]['id_cliente'];
		$id_almacen = $notas[0]['id_almacen'];
		$fecha_operacion = date('Y-m-d H:i:s');
		$fecha_documento = date('Y-m-d');
		$numero_documento = $notas[0]['numero_nota_entrega'];
		$mostrarListaNotas=$_SESSION['mostrarNotasResumidasNota'.$_GET['nota']];
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
			$concepto_factura = "Premios de ".$key['concepto'];
			$precio_nota = $key['precio_nota'];
			$concepto_operacion = "Venta A Lideres";
			$leyenda = "Factura Cerrada";

			$codigoId=$key['cantidad'].$key['tipo_inventario'].$key['id_inventario'];
			$notasHabilitadasOInhabilitadas=$lider->consultarQuery("SELECT * FROM notas_habilitadas WHERE id_despacho={$id_despacho} and id_nota_entrega={$_GET['nota']} and codigo_identificador='{$codigoId}'");
			$habilitadoOrInhabilitado=true;
			foreach ($notasHabilitadasOInhabilitadas as $habOrInhab) {
				if(!empty($habOrInhab['id_pedido'])){
					if($habOrInhab['estado']==1){
						$habilitadoOrInhabilitado=true;
					}
					if($habOrInhab['estado']==0){
						$habilitadoOrInhabilitado=false;
					}
				}
			}
			// echo "=> ".$habilitadoOrInhabilitado."<br>";
			$buscarRepetido = $lider->consultarQuery("SELECT * FROM operaciones WHERE modulo_factura='{$moduloFacturacion}' and id_factura={$id_nota} and tipo_inventario={$key['tipo_inventario']} and id_inventario={$key['id_inventario']} and concepto_factura='{$concepto_factura}' and precio_nota={$precio_nota} and tipo_operacion='Salida'");
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
			$query = "INSERT INTO operaciones (id_operacion, tipo_operacion, transaccion, concepto, leyenda, tipo_persona, id_personal, id_inventario, id_almacen, tipo_inventario, fecha_operacion, fecha_documento, numero_documento, numero_control, stock_operacion, total_operacion, stock_operacion_almacen, total_operacion_almacen, stock_operacion_total, total_operacion_total, precio_venta, modulo_factura, id_factura, concepto_factura, precio_nota, estatus) VALUES (DEFAULT, 'Salida', 'Venta', '{$concepto_operacion}', '{$leyenda}', 'Cliente', {$id_cliente}, {$key['id_inventario']}, {$id_almacen}, '{$key['tipo_inventario']}', '{$fecha_operacion}', '{$fecha_documento}', {$numero_documento}, {$numero_documento}, {$key['cantidad']}, {$total_operacion}, {$stock_almacen}, {$total_almacen}, {$stock_total}, {$total_total}, {$precio_venta}, '{$moduloFacturacion}', {$id_nota}, '{$concepto_factura}', {$precio_nota}, 1); ";
			// echo $query."<br><br>";
			if($habilitadoOrInhabilitado){
				$exec = $lider->registrar($query, "operaciones", "id_operacion");
				if($exec['ejecucion']==true){
				}else{
					$errores++;
				}
			}
		}
		$_SESSION['mostrarNotasResumidasNota'.$_GET['nota']]=[];
	}else{
		$errores++;
	}
	// die();
	if($errores==0){
		$response="11";
		$menuResponse = $menu3."route=".$_GET['route']."&action=".$_GET['action']."&nota=".$_GET['nota'];
		$_GET['e']=[];
	}else{
		$response="2";
	}
}
if(!empty($_GET['abrir'])){

	$query = "UPDATE notasentrega  SET estado_nota=1 WHERE id_nota_entrega={$id_nota}";
	$borrar = $lider->modificar($query);
	$errores = 0;
	if($borrar['ejecucion']==true){
		$notas = $lider->consultarQuery("SELECT * FROM notasentrega WHERE id_nota_entrega={$id_nota}");
		$id_cliente = $notas[0]['id_cliente'];
		$id_almacen = $notas[0]['id_almacen'];
		$fecha_operacion = date('Y-m-d H:i:s');
		$fecha_documento = date('Y-m-d');
		$numero_documento = $notas[0]['numero_nota_entrega'];
		$mostrarListaNotas=$_SESSION['mostrarNotasResumidasNota'.$_GET['nota']];
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
			$concepto_factura = $key['concepto'];
			$precio_nota = $key['precio_nota'];
			$concepto_operacion = "Factura Abierta";
			$leyenda = "Factura Abierta";

			$codigoId=$key['cantidad'].$key['tipo_inventario'].$key['id_inventario'];
			$notasHabilitadasOInhabilitadas=$lider->consultarQuery("SELECT * FROM notas_habilitadas WHERE id_despacho={$id_despacho} and id_nota_entrega={$_GET['nota']} and codigo_identificador='{$codigoId}'");
			$habilitadoOrInhabilitado=true;
			foreach ($notasHabilitadasOInhabilitadas as $habOrInhab) {
				if(!empty($habOrInhab['id_pedido'])){
					if($habOrInhab['estado']==1){
						$habilitadoOrInhabilitado=true;
					}
					if($habOrInhab['estado']==0){
						$habilitadoOrInhabilitado=false;
					}
				}
			}


			$buscarRepetido = $lider->consultarQuery("SELECT * FROM operaciones WHERE modulo_factura='{$moduloFacturacion}' and id_factura={$id_nota} and tipo_inventario={$key['tipo_inventario']} and id_inventario={$key['id_inventario']} and concepto_factura='{$concepto_factura}' and precio_nota={$precio_nota} and tipo_operacion='Entrada'");
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
			$query = "INSERT INTO operaciones (id_operacion, tipo_operacion, transaccion, concepto, leyenda, tipo_persona, id_personal, id_inventario, id_almacen, tipo_inventario, fecha_operacion, fecha_documento, numero_documento, numero_control, stock_operacion, total_operacion, stock_operacion_almacen, total_operacion_almacen, stock_operacion_total, total_operacion_total, precio_venta, modulo_factura, id_factura, concepto_factura, precio_nota, estatus) VALUES (DEFAULT, 'Entrada', 'Venta', '{$concepto_operacion}', '{$leyenda}', 'Cliente', {$id_cliente}, {$key['id_inventario']}, {$id_almacen}, '{$key['tipo_inventario']}', '{$fecha_operacion}', '{$fecha_documento}', {$numero_documento}, {$numero_documento}, {$key['cantidad']}, {$total_operacion}, {$stock_almacen}, {$total_almacen}, {$stock_total}, {$total_total}, {$precio_venta}, '{$moduloFacturacion}', {$id_nota}, '{$concepto_factura}', {$precio_nota}, 1);";
			// echo $query."<br><br>";
			if($habilitadoOrInhabilitado){
				$exec = $lider->registrar($query, "operaciones", "id_operacion");
				if($exec['ejecucion']==true){
				}else{
					$errores++;
				}
			}
		}
		$_SESSION['mostrarNotasResumidasNota'.$_GET['nota']]=[];
	}else{
		$errores++;
	}
	if($errores==0){
		$response="11";
		$menuResponse = $menu3."route=".$_GET['route']."&action=".$_GET['action']."&nota=".$_GET['nota'];
		$_GET['e']=[];
	}else{
		$response="2";
	}
}
if(!empty($_GET['inhab'])){
	$codigo_identificador = $_GET['inhab'];
	$nota_entrega=$lider->consultarQuery("SELECT * FROM notasentrega WHERE estatus=1 and notasentrega.id_nota_entrega={$id_nota}");
	$id_pedido = $nota_entrega[0]['id_pedido'];
	$query="SELECT * FROM notas_habilitadas WHERE codigo_identificador='{$codigo_identificador}' and id_nota_entrega={$id_nota} and id_pedido={$id_pedido} and estatus=1";
	$buscar=$lider->consultarQuery($query);
	if(count($buscar)>1){
		$query="UPDATE notas_habilitadas SET estado=0 WHERE codigo_identificador='{$codigo_identificador}' and id_nota_entrega={$id_nota} and id_pedido={$id_pedido}";
		$exec = $lider->registrar($query, "notas_habilitadas", "id_nota_habilitada");
	}else{
		$query="INSERT INTO notas_habilitadas (id_nota_habilitada, id_campana, id_despacho, id_pedido, id_nota_entrega, codigo_identificador, estado, estatus) VALUES (DEFAULT, {$id_campana}, {$id_despacho}, {$id_pedido}, {$id_nota}, '{$codigo_identificador}', 0, 1)";
		$exec = $lider->modificar($query);
	}
	if($exec['ejecucion']==true){
		$response="11";
		$menuResponse = $menu3."route=".$_GET['route']."&action=".$_GET['action']."&nota=".$_GET['nota'];
	}else{
		$response="2";
	}
}
if(!empty($_GET['hab'])){
	$codigo_identificador = $_GET['hab'];
	$nota_entrega=$lider->consultarQuery("SELECT * FROM notasentrega WHERE estatus=1 and notasentrega.id_nota_entrega={$id_nota}");
	$id_pedido = $nota_entrega[0]['id_pedido'];
	$query="SELECT * FROM notas_habilitadas WHERE codigo_identificador='{$codigo_identificador}' and id_nota_entrega={$id_nota} and id_pedido={$id_pedido} and estatus=1";
	$buscar=$lider->consultarQuery($query);
	if(count($buscar)>1){
		$query="UPDATE notas_habilitadas SET estado=1 WHERE codigo_identificador='{$codigo_identificador}' and id_nota_entrega={$id_nota} and id_pedido={$id_pedido}";
		$exec = $lider->registrar($query, "notas_habilitadas", "id_nota_habilitada");
	}else{
		$query="INSERT INTO notas_habilitadas (id_nota_habilitada, id_campana, id_despacho, id_pedido, id_nota_entrega, codigo_identificador, estado, estatus) VALUES (DEFAULT, {$id_campana}, {$id_despacho}, {$id_pedido}, {$id_nota}, '{$codigo_identificador}', 0, 1)";
		$exec = $lider->modificar($query);
	}
	if($exec['ejecucion']==true){
		$response="11";
		$menuResponse = $menu3."route=".$_GET['route']."&action=".$_GET['action']."&nota=".$_GET['nota'];
	}else{
		$response="2";
	}
}

// if(empty($_POST)){
	$nota = $_GET['nota'];
	$notaentregas = $lider->consultarQuery("SELECT * FROM notasentrega WHERE id_nota_entrega = $nota");
	if(count($notaentregas)>1){
		$notaentrega = $notaentregas[0];
		$optNotas = $lider->consultarQuery("SELECT * FROM opcionesentrega WHERE id_nota_entrega = $nota");

		$id = $notaentrega['id_cliente'];
		$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
		$pedido = $pedidos[0];
		$id_pedido = $pedido['id_pedido'];
		$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1 ORDER BY id_premio_perdido ASC;");

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
	          default:
	            $numFactura = "".$factura[0]['numero_factura'];
	          	break;
	        }
		}

		// $planesCol = $lider->consultarQuery("SELECT * FROM confignotaentrega, planes, planes_campana, tipos_colecciones, pedidos WHERE confignotaentrega.id_plan = planes.id_plan and confignotaentrega.opcion = 1 and planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and planes_campana.id_campana = {$id_campana}");
		
		$planesCol = $lider->consultarQuery("SELECT * FROM confignotaentrega, planes, planes_campana, tipos_colecciones, pedidos WHERE confignotaentrega.id_plan = planes.id_plan and confignotaentrega.id_campana = {$id_campana} and planes_campana.id_campana = {$id_campana} and planes_campana.id_plan = planes.id_plan and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and tipos_colecciones.id_pedido = {$id_pedido} and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id} and planes_campana.id_despacho = {$id_despacho} and confignotaentrega.id_despacho = {$id_despacho}");

		$premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
		$premios_planes3 = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho}");
		$premios_planes3 = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho}");
		$premios_planes4 = $lider->consultarQuery("SELECT DISTINCT * FROM premios, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_premios_planes_campana.tipo_premio_producto = 'Premios' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
		$premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = 'Standard' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho}");
		// if(count($premios_planes) < 2){
		// 		$pplan_momentaneo = $planesCol[0]['nombre_plan'];
		// 		$premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes.nombre_plan = '{$pplan_momentaneo}'");
		// }

		$retos = $lider->consultarQuery("SELECT * FROM retos, retos_campana, premios WHERE retos.id_reto_campana = retos_campana.id_reto_campana and retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana and retos.id_campana = $id_campana");
        
        $retosCamp = $lider->consultarQuery("SELECT DISTINCT * FROM retos_campana, premios WHERE retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana");

        $canjeos = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and canjeos.estatus = 1 and canjeos.id_campana = {$id_campana} and canjeos.id_despacho = {$id_despacho} and canjeos.id_cliente = {$id}");
        $canjeosUnic = $lider->consultarQuery("SELECT DISTINCT catalogos.id_catalogo, nombre_catalogo, id_premio FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and canjeos.estatus = 1 and canjeos.id_campana = {$id_campana} and canjeos.id_despacho = {$id_despacho}");

        $premios_autorizados = $lider->ConsultarQuery("SELECT * FROM pedidos, clientes, premios_autorizados, premios WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = premios_autorizados.id_cliente and pedidos.id_pedido = premios_autorizados.id_pedido and pedidos.id_despacho = {$id_despacho} and premios.id_premio = premios_autorizados.id_premio and clientes.id_cliente = premios_autorizados.id_cliente and premios_autorizados.estatus = 1 and clientes.estatus = 1 and premios.estatus = 1 and clientes.id_cliente = {$id} and premios_autorizados.descripcion_PA = ''");
        $premios_autorizados_obsequio = $lider->ConsultarQuery("SELECT * FROM pedidos, clientes, premios_autorizados, premios WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = premios_autorizados.id_cliente and pedidos.id_pedido = premios_autorizados.id_pedido and pedidos.id_despacho = {$id_despacho} and premios.id_premio = premios_autorizados.id_premio and clientes.id_cliente = premios_autorizados.id_cliente and premios_autorizados.estatus = 1 and clientes.estatus = 1 and premios.estatus = 1 and clientes.id_cliente = {$id} and premios_autorizados.descripcion_PA <> ''");

        	$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = {$id_despacho}");
			$pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1");
			$despacho = $despachos[0];
			$iterRecor = 0;
			foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
				if($pagosD['tipo_pago_despacho']=="Inicial"){
					// $pagosRecorridos[0]['fecha_pago'] = $pagosD['fecha_pago_despacho_senior'];
					$pagosRecorridos[$iterRecor] = ['name'=> "Inicial",  'id'=> "inicial", 'cod'=>'I', 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior']];
					$iterRecor++;
				}
			} }

			$cantidadPagosDespachosFild = [];

			for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
				$key = $cantidadPagosDespachos[$i];
				if($key['cantidad'] <= $despacho['cantidad_pagos']){
					$cantidadPagosDespachosFild[$i] = $key;
					foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
						if($pagosD['tipo_pago_despacho']==$key['name']){
							if($i < $despacho['cantidad_pagos']-1){
								$pagosRecorridos[$iterRecor] = ['name'=> $key['name'], 'id'=> $key['id'], 'cod'=> $key['cod'], 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior'], 'asignacion'=>$pagosD['asignacion_pago_despacho'], 'calcular'=>1];
								$iterRecor++;
							}
							if($i == $despacho['cantidad_pagos']-1){
								$pagosRecorridos[$iterRecor] = ['name'=> $key['name'], 'id'=> $key['id'], 'cod'=> $key['cod'], 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior'], 'asignacion'=>$pagosD['asignacion_pago_despacho'], 'calcular'=>2];
								$iterRecor++;
							}
						}
					}}
				}
			}

			// ========================== // =============================== // ============================== //
			if(count($premios_planes)<2){
				$premios_planes = [];
				$premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");

				$id_planes_camp = [];
				$nidxp = 0;
				foreach ($pagosRecorridos as $pagosR) {
					if(!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){
					}else{
						$id_planes_camp[$nidxp]['id_tipo'] = $pagosR['name'];
						$id_planes_camp[$nidxp]['id_plan'] = 0;
						$nidxp++;
					}
				}
				for ($i=0; $i < count($id_planes_camp); $i++) { 
					foreach ($premios_planes as $key) {
						if(!empty($key['id_plan_campana'])){
							if($id_planes_camp[$i]['id_tipo']==$key['tipo_premio']){
								if($id_planes_camp[$i]['id_plan']==0){
									$id_planes_camp[$i]['id_plan'] = $key['id_plan_campana'];
								}
							}
						}
					}
				}

				$n1 = 0;
				$premios_planes = [];
				foreach ($id_planes_camp as $keys) {
					$id_plan_camp = $keys['id_plan'];
					$tipo_plan_camp = $keys['id_tipo'];
					$newPlan = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = {$id_plan_camp} and premios_planes_campana.tipo_premio = '{$tipo_plan_camp}' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho}");
					foreach ($newPlan as $nplan) {
						if(!empty($nplan['id_plan_campana'])){
							$premios_planes[$n1] = $nplan;
							$n1++;
						}
					}
				}
			}

			$premiosXplanes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
			$controladorPremios = [];
			$numeroX = 0;
			foreach ($planesCol as $key1) {
				if(!empty($key1['id_plan'])){
					$numeroX2 = 0;
					foreach ($pagosRecorridos as $pagosR) {
						if(!empty($controladorPremios[$numeroX]['plan'])){
							$controladorPremios[$numeroX]['tipos_premios'][$numeroX2] = $pagosR['name'];
							$controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 0;
							foreach ($premiosXplanes as $key2) {
								if(!empty($key2['id_plan'])){
									if($key1['id_plan']==$key2['id_plan']){
										if($key2['tipo_premio']==$pagosR['name']){
											$controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 1;
										}
									}
								}
							}
						}else{
							$controladorPremios[$numeroX]['id_plan'] = $key1['id_plan'];
							$controladorPremios[$numeroX]['plan'] = $key1['nombre_plan'];
							$controladorPremios[$numeroX]['cantidad_colecciones'] = $key1['cantidad_coleccion'];
							$controladorPremios[$numeroX]['tipos_premios'][$numeroX2] = $pagosR['name'];
							$controladorPremios[$key1['nombre_plan']] = [];
							$controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 0;
							foreach ($premiosXplanes as $key2) {
								if(!empty($key2['id_plan'])){
									if($key1['id_plan']==$key2['id_plan']){
										if($key2['tipo_premio']==$pagosR['name']){
											$controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 1;
										}
									}
								}
							}
						}
						$numeroX2++;
					}
					$numeroX++;
				}
			}
			// ========================== // =============================== // ============================== //

			
			# ==================================================================================
				$fechas_promociones = $lider->consultarQuery("SELECT * FROM fechas_promocion WHERE id_campana = {$id_campana}");
				$abonoCantPromo = [];
				if(!empty($fechas_promociones[0])){
					$fechaPromocion = $fechas_promociones[0];
					$promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.estatus = 1 and promociones.id_campana={$id_campana} and promociones.id_despacho = {$id_despacho} and promociones.id_cliente = {$id} and promociones.id_pedido = {$id_pedido}");

					$promosTomarEnCuenta = "";
					$numIndex = 0;
					foreach ($promociones as $keys) {
						if(!empty($keys['id_promociones'])){
							$promosTomarEnCuenta .= "'".$keys['nombre_promocion']."'";
							$abonoCantPromo[$keys['id_promociones']]['id'] = $keys['id_promocion'];
							$abonoCantPromo[$keys['id_promociones']]['ids'] = $keys['id_promociones'];
							$abonoCantPromo[$keys['id_promociones']]['promocion'] = $keys['nombre_promocion'];
							$abonoCantPromo[$keys['id_promociones']]['costo'] = $keys['precio_promocion'];
							$abonoCantPromo[$keys['id_promociones']]['aprobadas'] = $keys['cantidad_aprobada_promocion'];
							$abonoCantPromo[$keys['id_promociones']]['abonado'] = 0;
							$abonoCantPromo[$keys['id_promociones']]['cantidad'] = 0;
							if($numIndex < (count($promociones)-2)){
								$promosTomarEnCuenta .= ", ";
							}
							$numIndex++;
						}
					}
					$fechaPagoPromocion = $fechaPromocion['fecha_pago_promocion'];
					$pagosPromos = $lider->consultarQuery("SELECT * FROM pagos WHERE pagos.estatus = 1 and pagos.id_pedido = {$id_pedido} and pagos.tipo_pago IN ({$promosTomarEnCuenta}) and pagos.fecha_pago <= '{$fechaPagoPromocion}'");
					foreach ($pagosPromos as $pagosP) { if(!empty($pagosP['id_pago'])){
						foreach ($promociones as $keys) { if(!empty($keys['id_promociones'])){
							if($pagosP['tipo_pago']==$keys['nombre_promocion']){
								if($pagosP['estado']=="Abonado"){
									$abonoCantPromo[$keys['id_promociones']]['abonado'] += $pagosP['equivalente_pago'];
								}
							}
						} }
					} }

					foreach ($abonoCantPromo as $promos) {
						$nombrePromos = "";
						$nombrePromos = $abonoCantPromo[$promos['ids']]['promocion'];
						$distribucionPromociones = $lider->consultarQuery("SELECT * FROM distribucion_pagos WHERE id_pedido = {$id_pedido} and distribucion_pagos.estatus = 1 and distribucion_pagos.tipo_distribucion = '{$nombrePromos}'");
						$distribucionPromoActual = 0;
						foreach ($distribucionPromociones as $dist) {
							if(!empty($dist['id_distribucion_pagos'])){
								$distribucionPromoActual += $dist['cantidad_distribucion'];
							}
						}
						$promoAbonado = 0;
						$promoAbonado += $promos['abonado'];
						$promoAbonado += $distribucionPromoActual;
						$cantidad = ($promoAbonado/$promos['costo']);
						$cantidadFormat = number_format($cantidad, 2, ",",".");
						$cantidadVal = intval($cantidadFormat);
						if($cantidadVal > $abonoCantPromo[$promos['ids']]['aprobadas']){
							$cantidadVal = $abonoCantPromo[$promos['ids']]['aprobadas'];
						}
						$abonoCantPromo[$promos['ids']]['cantidad'] = $cantidadVal;
					}
					$premios_promocion = $lider->consultarQuery("SELECT * FROM premios_promocion WHERE premios_promocion.id_campana = {$id_campana}");
					$productos = $lider->consultarQuery("SELECT * FROM productos, premios_promocion WHERE productos.id_producto = premios_promocion.id_premio and premios_promocion.id_campana = {$id_campana} and productos.estatus = 1");
					$premios = $lider->consultarQuery("SELECT * FROM premios, premios_promocion WHERE premios.id_premio = premios_promocion.id_premio and premios_promocion.id_campana = {$id_campana} and premios.estatus = 1");
				}
			# ==================================================================================
			$productosAll = $lider->consultarQuery("SELECT * FROM productos WHERE estatus=1");
			$mercanciaAll = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1");
			$almacenes = $lider->consultarQuery("SELECT * FROM almacenes WHERE estatus=1");
			$productoss = [];
			$mercancias = [];
			
			$id_almacen = $notaentrega['id_almacen'];
		
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

			// foreach ($productoss as $key) {
			// 	print_r($key);
			// 	echo "<br><br><br>";
			// }

			// foreach ($mercancias as $key) {
			// 	print_r($key);
			// 	echo "<br><br><br>";
			// }


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
	// }else{
		    // require_once 'public/views/error404.php';
	// }

// }
?>