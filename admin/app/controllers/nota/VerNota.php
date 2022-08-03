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
// if (!empty($_POST)) {
// 	// print_r($_POST);
// 	$direccion = mb_strtoupper($_POST['direccion_emision']);
// 	$lugar = ucwords(mb_strtolower($_POST['lugar_emision']));
// 	$fecha = $_POST['fecha_emision'];
// 	$num = $_POST['numero'];
// 	$id_lider = $_POST['id_cliente'];
// 	$opts = $_POST['opts'];
// 	$max = count($opts);
// 	$query = "INSERT INTO notasentrega (id_nota_entrega, id_cliente, id_campana, direccion_emision, lugar_emision, fecha_emision, numero_nota_entrega, estatus) VALUES (DEFAULT, {$id_lider}, {$id_campana}, '{$direccion}', '{$lugar}', '{$fecha}', {$num}, 1)";
// 	// echo $query."<br>";
// 	$exec = $lider->registrar($query, "notasentrega", "id_nota_entrega");
// 	// print_r($exec);
// 	$responses2 = [];
// 	if($exec['ejecucion']==true){
// 		$id_nota = $exec['id'];
// 		$nume = 0;
// 		foreach ($opts as $cod => $val) {
// 			$query2 = "INSERT INTO opcionesentrega (id_opcion_entrega, id_nota_entrega, cod, val, estatus) VALUES (DEFAULT, {$id_nota}, '{$cod}', '{$val}', 1)";
// 			$exec2 = $lider->registrar($query2, "opcionesentrega", "id_opcion_entrega");
// 			if($exec2['ejecucion']==true){
// 				$responses2[$nume] = 1;
// 			}else{
// 				$responses2[$nume] = 2;
// 			}
// 			$nume++;
// 		}
// 		$sum = 0;
// 		foreach ($responses2 as $key) {
// 			$sum += $key;
// 		}
// 		if($sum == $max){
// 			$response = "1";
// 		}else{
// 			$response = "2";
// 		}
// 	}else{
// 		$response = "2";
// 	}

// 	// echo $response;
// 	$nota = $_GET['nota'];
// 	$notaentregas = $lider->consultarQuery("SELECT * FROM notasentrega WHERE id_nota_entrega = $nota");
// 	if(count($notaentregas)>1){
// 		$notaentrega = $notaentregas[0];

// 		$id = $notaentrega['id_cliente'];
// 		echo $id;
// 		$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
// 		$pedido = $pedidos[0];
// 		$id_pedido = $pedido['id_pedido'];
// 		$premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1");

// 		$planesCol = $lider->consultarQuery("SELECT * FROM confignotaentrega, planes, planes_campana, tipos_colecciones, pedidos WHERE confignotaentrega.id_plan = planes.id_plan and confignotaentrega.opcion = 1 and planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and planes_campana.id_campana = {$id_campana}");
// 		$premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho}");

// 		$premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = 'Standard' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho");

// 		$retos = $lider->consultarQuery("SELECT * FROM retos, retos_campana, premios WHERE retos.id_reto_campana = retos_campana.id_reto_campana and retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana and retos.id_campana = $id_campana");
        
//         $retosCamp = $lider->consultarQuery("SELECT DISTINCT * FROM retos_campana, premios WHERE retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana");

// 		if(!empty($action)){
// 			if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
// 				require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
// 			}else{
// 			    require_once 'public/views/error404.php';
// 			}
// 		}else{
// 			if (is_file('public/views/'.$url.'.php')) {
// 				require_once 'public/views/'.$url.'.php';
// 			}else{
// 			    require_once 'public/views/error404.php';
// 			}
// 		}
// 	}

// }
if(empty($_POST)){
	$nota = $_GET['nota'];
	$notaentregas = $lider->consultarQuery("SELECT * FROM notasentrega WHERE id_nota_entrega = $nota");
	if(count($notaentregas)>1){
		$notaentrega = $notaentregas[0];

		$optNotas = $lider->consultarQuery("SELECT * FROM opcionesentrega WHERE id_nota_entrega = $nota");

		$id = $notaentrega['id_cliente'];
		$pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
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

		// $planesCol = $lider->consultarQuery("SELECT * FROM confignotaentrega, planes, planes_campana, tipos_colecciones, pedidos WHERE confignotaentrega.id_plan = planes.id_plan and confignotaentrega.opcion = 1 and planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and planes_campana.id_campana = {$id_campana}");
		
		$planesCol = $lider->consultarQuery("SELECT * FROM confignotaentrega, planes, planes_campana, tipos_colecciones, pedidos WHERE confignotaentrega.id_plan = planes.id_plan and confignotaentrega.id_campana = {$id_campana} and confignotaentrega.opcion = 1 and planes_campana.id_campana = {$id_campana} and planes_campana.id_plan = planes.id_plan and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and tipos_colecciones.id_pedido = {$id_pedido} and tipos_colecciones.id_pedido = pedidos.id_pedido and pedidos.id_cliente = {$id}");

		$premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho}");

		$premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = 'Standard' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho");

		$retos = $lider->consultarQuery("SELECT * FROM retos, retos_campana, premios WHERE retos.id_reto_campana = retos_campana.id_reto_campana and retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana and retos.id_campana = $id_campana");
        
        $retosCamp = $lider->consultarQuery("SELECT DISTINCT * FROM retos_campana, premios WHERE retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana");

        $canjeos = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and canjeos.estatus = 1 and catalogos.estatus = 1 and canjeos.id_campana = {$id_campana} and canjeos.id_cliente = {$id}");
        $canjeosUnic = $lider->consultarQuery("SELECT DISTINCT catalogos.id_catalogo, nombre_catalogo FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and canjeos.estatus = 1 and catalogos.estatus = 1 and canjeos.id_campana = {$id_campana}");

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

}
?>