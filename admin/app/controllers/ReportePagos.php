<?php 

if($_SESSION['nombre_rol']!="Vendedor"){	

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";


	if(empty($_POST)){
		// $lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1");
		// $lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
		$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE bancos.estatus = 1");
		
		$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} ORDER BY fecha_pago asc");
		$id_cliente = $_SESSION['id_cliente'];


		$liderazgosAll = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1");
		$pedidos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos WHERE  campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho}");
	//========================================================================================================== 

				
	//========================================================================================================== 		
		$mostrar = [];
		$n=0;
		foreach ($bancos as $bank) {
			if(!empty($bank['id_banco'])){
				$temp = [];
				$pagoss = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.id_banco = {$bank['id_banco']} ");
				$reportados = 0;
				$diferidos = 0;
				$abonados = 0;
				$pendientes = 0;
				foreach ($pagoss as $pag) {
					if(!empty($pag['id_pago'])){
						if($pag['estado']=="Abonado"){
							$abonados += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else if($pag['estado']=="Diferido"){
							$diferidos += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else {
							$reportados += $pag['equivalente_pago'];
						}
					}
				}
				$pendientes = $reportados - $diferidos - $abonados;
				if(count($pagoss)>1){
					if($bank['tipo_cuenta']=="Divisas"){
						$temp['opcion'] = "(".$bank['codigo_banco'].") ".$bank['nombre_banco']." - ".$bank['nombre_propietario']." (Depositos ".$bank['tipo_cuenta'].")";
					}else{
						$temp['opcion'] = "(".$bank['codigo_banco'].") ".$bank['nombre_banco']." - ".$bank['nombre_propietario']." (Cuenta ".$bank['tipo_cuenta'].")";
					}
					$temp['pagos']['reportados']=$reportados;
					$temp['pagos']['diferidos']=$diferidos;
					$temp['pagos']['abonados']=$abonados;
					$temp['pagos']['pendiente']=$pendientes;
					$mostrar[$n] = $temp;
					$n++;
				}
			}
		}
	//========================================================================================================== 

				
	//========================================================================================================== 
		$pagossDivisas = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Divisas Dolares'");
				$reportados = 0;
				$diferidos = 0;
				$abonados = 0;
				$pendientes = 0;
				foreach ($pagossDivisas as $pag) {
					if(!empty($pag['id_pago'])){
						if($pag['estado']=="Abonado"){
							$abonados += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else if($pag['estado']=="Diferido"){
							$diferidos += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else {
							$reportados += $pag['equivalente_pago'];
						}
					}
				}
				$pendientes = $reportados - $diferidos - $abonados;
				if(count($pagoss)>1){
					$temp['opcion'] = "Divisas Dolares";
					$temp['pagos']['reportados']=$reportados;
					$temp['pagos']['diferidos']=$diferidos;
					$temp['pagos']['abonados']=$abonados;
					$temp['pagos']['pendiente']=$pendientes;
					$mostrar[$n] = $temp;
					$n++;
				}

	//========================================================================================================== 


	//========================================================================================================== 
		$pagossBolivares = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Efectivo Bolivares'");
				$reportados = 0;
				$diferidos = 0;
				$abonados = 0;
				$pendientes = 0;
				foreach ($pagossBolivares as $pag) {
					if(!empty($pag['id_pago'])){
						if($pag['estado']=="Abonado"){
							$abonados += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else if($pag['estado']=="Diferido"){
							$diferidos += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else {
							$reportados += $pag['equivalente_pago'];
						}
					}
				}
				$pendientes = $reportados - $diferidos - $abonados;
				if(count($pagoss)>1){
					$temp['opcion'] = "Efectivo Bolivares";
					$temp['pagos']['reportados']=$reportados;
					$temp['pagos']['diferidos']=$diferidos;
					$temp['pagos']['abonados']=$abonados;
					$temp['pagos']['pendiente']=$pendientes;
					$mostrar[$n] = $temp;
					$n++;
				}
	//========================================================================================================== 

				
	//========================================================================================================== 
			$pagossAutorizados = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago LIKE '%Autorizado Por%'");
				$reportados = 0;
				$diferidos = 0;
				$abonados = 0;
				$pendientes = 0;
				foreach ($pagossAutorizados as $pag) {
					if(!empty($pag['id_pago'])){
						if($pag['estado']=="Abonado"){
							$abonados += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else if($pag['estado']=="Diferido"){
							$diferidos += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else {
							$reportados += $pag['equivalente_pago'];
						}
					}
				}
				$pendientes = $reportados - $diferidos - $abonados;
				if(count($pagoss)>1){
					$temp['opcion'] = "Autorizado Por Amarilis Rojas";
					$temp['pagos']['reportados']=$reportados;
					$temp['pagos']['diferidos']=$diferidos;
					$temp['pagos']['abonados']=$abonados;
					$temp['pagos']['pendiente']=$pendientes;
					$mostrar[$n] = $temp;
					$n++;
				}
	//========================================================================================================== 
				// print_r($temp);
		// print_r($mostrar);

		

		if($pagos['ejecucion']==1){
			$reportado = 0;
			$diferido = 0;
			$abonado = 0;
			$pendienteConciliar = 0;
			if(count($pagos)>1){
              foreach ($pagos as $data) {
                if(!empty($data['id_pago'])){
                  $reportado += $data['equivalente_pago'];
                  if($data['estado']=="Diferido"){
                    $diferido += $data['equivalente_pago'];
                  }
                  if($data['estado']=="Abonado"){
                    $abonado += $data['equivalente_pago'];
                  }
                }
              }
			}
			$pendienteConciliar = $reportado-$diferido-$abonado;

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