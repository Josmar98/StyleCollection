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
			$productos = $lider->consultarQuery("SELECT * FROM productos");
			$premios = $lider->consultarQuery("SELECT * FROM premios");

			$opcionesEntregas = $lider->consultarQuery("SELECT * FROM opcionesentregapersonalizada WHERE id_nota_entrega_personalizada = {$id_nota}");
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