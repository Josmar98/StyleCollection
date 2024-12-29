<?php 

if($_SESSION['nombre_rol']!="Vendedor"){	

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";


	if(empty($_POST)){
		$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE bancos.estatus = 1 and bancos.disponibilidad = 'Habilitado'");
		$opcionesPagos = [];
		$nindexB = 0;
		$opcionesPagos[$nindexB] = [
			"tipo"=>"general",
			"condicion"=>"",
			"reportado"=>0,
			"diferido"=>0,
			"abonado"=>0,
			"pendiente"=>0,
		];
		$nindexB++;
		foreach ($bancos as $bank) {
			if(!empty($bank['id_banco'])){
				$tipo_cuenta = "";
				if($bank['tipo_cuenta']=="Divisas"){
					$tipo_cuenta = "Deposito";
				}else{
					$tipo_cuenta = "Cuenta";
				}
				$condicion = " and pagos.id_banco = ".$bank['id_banco'];
				$titulo = "(".$bank['codigo_banco'].") ".$bank['nombre_banco']." - ".$bank['nombre_propietario']." (".$tipo_cuenta." ".$bank['tipo_cuenta'].")";
				$opcionesPagos[$nindexB] = [
					"tipo"=>"banco",
					"condicion"=>$condicion,
					"titulo"=>$titulo,
					"reportado"=>0,
					"diferido"=>0,
					"abonado"=>0,
					"pendiente"=>0,
				];
				$nindexB++;

				// echo $titulo."<br><br>";
			}
		}
		$opcionesPagos[$nindexB] = [
			"tipo"=>"divisas",
			"condicion"=>"and pagos.id_banco IS NULL and pagos.forma_pago = 'Divisas Dolares'",
			"titulo"=>"Divisas Dolares",
			"reportado"=>0,
			"diferido"=>0,
			"abonado"=>0,
			"pendiente"=>0,
		];
		$nindexB++;
		$opcionesPagos[$nindexB] = [
			"tipo"=>"bolivares",
			"condicion"=>"and pagos.id_banco IS NULL and pagos.forma_pago = 'Efectivo Bolivares'",
			"titulo"=>"Efectivo Bolivares",
			"reportado"=>0,
			"diferido"=>0,
			"abonado"=>0,
			"pendiente"=>0,
		];
		$nindexB++;
		$opcionesPagos[$nindexB] = [
			"tipo"=>"autorizados",
			"condicion"=>"and pagos.id_banco IS NULL and pagos.forma_pago LIKE '%Autorizado Por%'",
			"titulo"=>"Autorizado Por Amarilis Rojas",
			"reportado"=>0,
			"diferido"=>0,
			"abonado"=>0,
			"pendiente"=>0,
		];
		$nindexB++;

		for ($i=0; $i < count($opcionesPagos); $i++){
			$key = $opcionesPagos[$i];

			$sql = "SELECT SUM(equivalente_pago) as totalGeneral FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_despacho = {$id_despacho} {$key['condicion']}";
			$pag = $lider->consultarQuery($sql);
			$totalGeneral = $pag[0]['totalGeneral'];

			$sql = "SELECT SUM(equivalente_pago) as totalDiferido FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_despacho = {$id_despacho} and pagos.estado = 'Diferido' {$key['condicion']}";
			$pag = $lider->consultarQuery($sql);
			$totalDiferido = $pag[0]['totalDiferido'];

			$sql = "SELECT SUM(equivalente_pago) as totalAbonado FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and pedidos.id_despacho = {$id_despacho} and pagos.estado = 'Abonado' {$key['condicion']}";
			$pag = $lider->consultarQuery($sql);
			$totalAbonado = $pag[0]['totalAbonado'];

			$totalPendiente = $totalGeneral-$totalDiferido-$totalAbonado;
			$opcionesPagos[$i]['reportado'] += $totalGeneral;
			$opcionesPagos[$i]['diferido'] += $totalDiferido;
			$opcionesPagos[$i]['abonado'] += $totalAbonado;
			$opcionesPagos[$i]['pendiente'] += $totalPendiente;
		}

		// echo "<table style='width:100%;border:1px solid #000' border='1'>";
		// 	if(!empty($key['titulo'])){
		// 		echo "<tr style='text-align:center;'>";
		// 			echo "<td colspan='4'><b>".$key['titulo']."</b></td>";
		// 		echo "</tr>";
		// 	}
		// 	echo "<tr style='text-align:center;'>";
		// 		echo "<td><b>GENERAL</b></td>";
		// 		echo "<td><b>DIFERIDO</b></td>";
		// 		echo "<td><b>ABONADO</b></td>";
		// 		echo "<td><b>PENDIENTE</b></td>";
		// 	echo "</tr>";
		// 	echo "<tr>";
		// 		echo "<td><b>".$totalGeneral."</b></td>";
		// 		echo "<td><b>".$totalDiferido."</b></td>";
		// 		echo "<td><b>".$totalAbonado."</b></td>";
		// 		echo "<td><b>".$totalPendiente."</b></td>";
		// 	echo "</tr>";
		// 	echo "</table>";
		// 	echo "<br><br>";
		

		if(count($opcionesPagos)>1){
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