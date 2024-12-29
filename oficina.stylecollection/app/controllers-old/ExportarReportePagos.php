<?php 
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\IOFactory;
    use PhpOffice\PhpSpreadsheet\Writer;
    use PhpOffice\PhpSpreadsheet\Reader;

    if(is_file('app/models/excel.php')){
      require_once'app/models/excel.php';
    }
    if(is_file('../app/models/excel.php')){
      require_once'../app/models/excel.php';
    }

	$file = "./config/temp/pagos.xlsx";

	$id_campana = $_GET['campaing'];
    $numero_campana = $_GET['n'];
    $anio_campana = $_GET['y'];
    $id_despacho = $_GET['dpid'];
    $numero_despacho = $_GET['dp'];
    $admin = "";
    $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho}");
    $despacho = $despachos[0];
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

			$sql = "SELECT SUM(equivalente_pago) as totalGeneral FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pedidos.id_despacho = {$id_despacho} {$key['condicion']}";
			$pag = $lider->consultarQuery($sql);
			$totalGeneral = $pag[0]['totalGeneral'];

			$sql = "SELECT SUM(equivalente_pago) as totalDiferido FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pedidos.id_despacho = {$id_despacho} and pagos.estado = 'Diferido' {$key['condicion']}";
			$pag = $lider->consultarQuery($sql);
			$totalDiferido = $pag[0]['totalDiferido'];


			$sql = "SELECT SUM(equivalente_pago) as totalAbonado FROM pedidos, pagos WHERE pedidos.id_pedido = pagos.id_pedido and pedidos.id_despacho = {$id_despacho} and pagos.estado = 'Abonado' {$key['condicion']}";
			$pag = $lider->consultarQuery($sql);
			$totalAbonado = $pag[0]['totalAbonado'];

			$totalPendiente = $totalGeneral-$totalDiferido-$totalAbonado;
			$opcionesPagos[$i]['reportado'] += $totalGeneral;
			$opcionesPagos[$i]['diferido'] += $totalDiferido;
			$opcionesPagos[$i]['abonado'] += $totalAbonado;
			$opcionesPagos[$i]['pendiente'] += $totalPendiente;

		}

	//========================================================================================================== 
							$mes = date("m");
              switch ($mes) {
                case '01':
                  $mes = "Enero";
                  break;
                case '02':
                  $mes = "Febrero";
                  break;
                case '03':
                  $mes = "Marzo";
                  break;
                case '04':
                  $mes = "Abril";
                  break;
                case '05':
                  $mes = "Mayo";
                  break;
                case '06':
                  $mes = "Junio";
                  break;
                case '07':
                  $mes = "Julio";
                  break;
                case '08':
                  $mes = "Agosto";
                  break;
                case '09':
                  $mes = "Septiembre";
                  break;
                case '10':
                  $mes = "Octubre";
                  break;
                case '11':
                  $mes = "Noviembre";
                  break;
                case '12':
                  $mes = "Diciembre";
                  break;
              }


	// $filas = ['filI'=> '1', 'filF' => ''];
	$colum = ['colI'=> 'A', 'colF' => 'I'];
	$typeResponse = 1;


	$libro = new Excel($file, "Xlsx");
	$dat['opcionesPagos'] = $opcionesPagos;
	$dat['mes'] = $mes;
	$dat['reporteGeneral'] = $opcionesPagos[0];
	$dat['despachos'] = $despacho;
	// $dat['bancos'] = $bancos;
	// $dat['planes'] = $planes;
	// $dat['nuevoTotal'] = $nuevoTotal;
	// print_r($dat);

	$libro->exportarReportedePagosExcel($dat, $lider);

?>