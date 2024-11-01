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
		$_SESSION['cargaTempFactPersonalizada'] = $_POST;
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
		// $pedidoss = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = {$id_lider} and id_despacho = {$id_despacho}");
		// print_r($pedidoss);
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
		// $opts = [];
		// if(!empty($_POST['opts'])){
		// 	$opts = $_POST['opts'];
		// }

		$max = count($cantidades);
		if($max!=$cantidad_registros){
			$max = $cantidad_registros;
		}

		// echo "Cantidad Registros: ".$cantidad_registros."<br>";
		// echo "Num Factura: ".$num_factura."<br>";
		// echo "Num Control: ".$num_control."<br>";
		// echo "Líder N°: ".$lider."<br>";
		// echo "Forma de pago: ".$forma."<br>";
		// echo "Lugar de emision: ".$lugar."<br>";
		// echo "Fecha de emision: ".$fecha1."<br>";
		// echo "Fecha de vencimiento: ".$fecha2."<br>";
		// echo "Cantidades: "; print_r($cantidades); echo"<br>";
		// echo "Tipos: "; print_r($tipos); echo"<br>";
		// echo "Productos: "; print_r($productos); echo"<br>";
		// echo "Premios: "; print_r($premios); echo"<br>";
		// echo "Precios: "; print_r($precios); echo"<br>";
		// echo "Conceptos: "; print_r($conceptos); echo"<br>";

		$query = "INSERT INTO factura_personalizada (id_factura_personalizada, numero_factura, numero_control, id_cliente, forma_pago, lugar_emision, fecha_emision, fecha_vencimiento, estatus) VALUES (DEFAULT, {$num_factura}, {$num_control}, {$id_cliente}, '{$forma}', '{$lugar}', '{$fecha1}', '{$fecha2}', 1);";

		// die();
		$exec = $lider->registrar($query, "factura_personalizada", "id_factura_personalizada");
		if($exec['ejecucion']==true){
			$id_factura_personaliada = $exec['id'];
			// $id_factura_personaliada = 7;
			$sum = 0;
			$errores = 0;
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

		// $id_factura_personaliada = 7;
		// 	$sum = 0;
		// 	$errores = 0;
		// 	for ($i=0; $i < $max; $i++){
		// 		// $premio_producto_act = "";
		// 		$cantidadAct = $cantidades[$i];
		// 		$tipoAct = $tipos[$i];
		// 		$productoAct = $productos[$i]=="" ? 0 : $productos[$i];
		// 		$premioAct = $premios[$i]=="" ? 0 : $premios[$i];
		// 		$precioAct = (float) number_format($precios[$i],2,'.','');
		// 		$conceptoAct = ucwords(mb_strtolower($conceptos[$i]));
				
		// 		$query2 = "INSERT INTO lista_factura_personalizada (id_lista_factura_personalizada, id_factura_personalizada, cantidades, tipos, id_productos, id_premios, precios, conceptos, estatus) VALUES (DEFAULT, {$id_factura_personaliada}, {$cantidadAct}, '{$tipoAct}', {$productoAct}, {$premioAct}, {$precioAct}, '{$conceptoAct}', 1)";
		// 		$exec2 = $lider->registrar($query2, "lista_factura_personalizada", "id_lista_factura_personalizada");
		// 		if($exec2['ejecucion']==true){
		// 			$sum++;
		// 		}else{
		// 			$errores++;
		// 		}
		// 	}
			
		// 	if($errores==0){
		// 		$response = "1";
		// 	}else{
		// 		$response = "2";
		// 	}

		// die();

		$productos = $lider->consultarQuery("SELECT * FROM productos WHERE productos.estatus = 1");
		$premios = $lider->consultarQuery("SELECT * FROM premios WHERE premios.estatus = 1");

		$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

		$notas = $lider->consultarQuery("SELECT * FROM notasentrega WHERE estatus = 1");
		// $nume = 0;
		// $sum = 0;
		$nume = 0;
		if(count($notas)>1){
			foreach ($notas as $key) {
				if(!empty($key['id_nota_entrega'])){
					if($key['numero_nota_entrega'] > $nume){
						$nume = $key['numero_nota_entrega'];
					}
				}
			}
		}
		$nume++;
		
		unset($_SESSION['cargaTempFactPersonalizada']);
		// $nume = $num;
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

		$productos = $lider->consultarQuery("SELECT * FROM productos WHERE productos.estatus = 1");
		$premios = $lider->consultarQuery("SELECT * FROM premios WHERE premios.estatus = 1");

		$lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");

		$notas = $lider->consultarQuery("SELECT * FROM notasentrega WHERE estatus = 1");
		$nume = 0;
		if(count($notas)>1){
			foreach ($notas as $key) {
				if(!empty($key['id_nota_entrega'])){
					if($key['numero_nota_entrega'] > $nume){
						$nume = $key['numero_nota_entrega'];
					}
				}
			}
		}
		$nume++;
		if(empty($_GET['cant'])){
			unset($_SESSION['cargaTempFactPersonalizada']);	
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