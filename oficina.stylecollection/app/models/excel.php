<?php 
require_once 'config/database.php';

if(is_file('vendor/phpexcel/vendor/autoload.php')){
  require_once 'vendor/phpexcel/vendor/autoload.php';
}
if(is_file('../vendor/phpexcel/vendor/autoload.php')){
  require_once '../vendor/phpexcel/vendor/autoload.php';
}

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Writer;
use PhpOffice\PhpSpreadsheet\Reader;

class Excel{
	private $file;
	private $format;
	public	$cols = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ"];

	public function __construct($ruta, $format){
		$this->file = $ruta;
		$this->format = $format;
	}

	public function exportarPagosExcel($dat, $lider){
		$pagos = $dat['pagos'];


		$pagos_despacho = $dat['pagos_despacho'];
		$pagosRecorridos = $dat['pagosRecorridos'];
		$cantidadPagosDespachos = $dat['cantidadPagosDespachos'];
		$cantidadPagosDespachosFild = $dat['cantidadPagosDespachosFild'];	

		$movimientos = $dat['movimientos'];
		$bancos = $dat['bancos'];
		$despacho = $dat['despachos'];
		$planes = $dat['planes'];
		$nuevoTotal = $dat['nuevoTotal'];

		$numCampana = $despacho['numero_despacho']."_".$despacho['anio_campana'];
		$stringName = "Pago Campaña ".$numCampana;
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0);

		$sheetInicial = $spreadsheet->getActiveSheet()->setTitle('Reporte de Pagos');
		$sheetInicial->getColumnDimension('A')->setAutoSize(true);
		$sheetInicial->getColumnDimension('B')->setAutoSize(true);
		$sheetInicial->getColumnDimension('C')->setAutoSize(true);
		$sheetInicial->getColumnDimension('D')->setAutoSize(true);
		$sheetInicial->getColumnDimension('E')->setAutoSize(true);
		$sheetInicial->getColumnDimension('F')->setAutoSize(true);
		$sheetInicial->getColumnDimension('G')->setAutoSize(true);
		$sheetInicial->getColumnDimension('H')->setAutoSize(true);
		$sheetInicial->getColumnDimension('I')->setAutoSize(true);
		$sheetInicial->getColumnDimension('J')->setAutoSize(true);

		$num2 = 1;
		if(!empty($_GET['lider']) || ($_SESSION['nombre_rol']=="Vendedor")){

			$cliente = $dat['clientes'][0];
			$pedido = $dat['pedido'];
			$bonoscontado = $dat['bonoscontado'];

			$coleccionesContado = 0;
      $varCont = 0;
      foreach ($bonoscontado as $bono) {
				if(!empty($bono['id_bonocontado'])){
					$coleccionesContado += $bono['colecciones_bono'];
				}
			}


			$num = 2;
			$sheetInicial->setCellValue('B'.$num, 'Líder');
			$sheetInicial->setCellValue('C'.$num, $cliente['primer_nombre']." ".$cliente['primer_apellido']);
			$sheetInicial->setCellValue('D'.$num, number_format($cliente['cedula'],0,',','.'));
			$sheetInicial->getStyle('B'.$num.':D'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('D59FD1');
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
			$num++;
			$num++;
			
			$nIndx = 0;
			$acumuladosTotales = [];
			$totalesPagosPagar = [];
			foreach ($cantidadPagosDespachosFild as $key) {
				foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
					if($pagosD['tipo_pago_despacho']==$key['name']){
						if($nIndx < $despacho['cantidad_pagos']-1){

							$num++;
							$sheetInicial->setCellValue('B'.$num, 'Responsabilidad de '.$pagosD['tipo_pago_despacho']);
							$sheetInicial->getStyle('B'.$num.':E'.$num)->getAlignment()->setHorizontal('justify');
							$sheetInicial->getStyle('B'.$num.':E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');

							$num++;
							$sheetInicial->setCellValue('B'.$num, 'Plan');
							$sheetInicial->setCellValue('C'.$num, 'Cantidad');
							$sheetInicial->setCellValue('D'.$num, 'Precio');
							$sheetInicial->setCellValue('E'.$num, 'Total');
							$sheetInicial->getStyle('B'.$num.':E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('9FD1D5');
							$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(13);
							$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
							$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
							$acumTotalPrimerPago = 0;
							$acumuladosTotales[$key['id']] = 0;
							foreach ($planes as $plans) {
								if(!empty($plans)){
									if($plans['cantidad_coleccion_plan']>0){
										$num++;
										$colecciones = $plans['cantidad_coleccion']*$plans['cantidad_coleccion_plan'];
										$costoTotal = $colecciones*$pagosD['pago_precio_coleccion'];
										$acumTotalPrimerPago += $costoTotal;
										$acumuladosTotales[$key['id']]+=$costoTotal;
										
										$sheetInicial->setCellValue('B'.$num, 'Plan '.$plans['nombre_plan']);
										$sheetInicial->setCellValue('C'.$num, $colecciones . ' col. '.  'x ');
										$sheetInicial->setCellValue('D'.$num, '$'.$pagosD['pago_precio_coleccion']. ' = ');
										$sheetInicial->setCellValue('E'.$num, '$'.$costoTotal);
										$sheetInicial->getStyle('B'.$num.':D'.$num)->getAlignment()->setHorizontal('justify');
										$sheetInicial->getStyle('E'.$num)->getAlignment()->setHorizontal('right');
									}
								}
							}
							$num++;

							$sheetInicial->setCellValue('D'.$num, 'Total =');
							$sheetInicial->setCellValue('E'.$num, '$'.$acumuladosTotales[$key['id']]);
							$sheetInicial->getStyle('D'.$num.':E'.$num)->getFont()->setBold(true)->setSize(13);
							$sheetInicial->getStyle('D'.$num.':D'.$num)->getAlignment()->setHorizontal('justify');
							$sheetInicial->getStyle('E'.$num)->getAlignment()->setHorizontal('right');
							$sheetInicial->getStyle('B'.$num.':E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');

							$num++;

							$varCont = $coleccionesContado * $pagosD['pago_precio_coleccion'];
							
							$sheetInicial->setCellValue('B'.$num, '(-) Colecciones de Contado');
							$sheetInicial->setCellValue('C'.$num, $coleccionesContado . ' col. '.  'x ');
							$sheetInicial->setCellValue('D'.$num, '$'.$pagosD['pago_precio_coleccion']. ' = ');
							$sheetInicial->setCellValue('E'.$num, '$'.$varCont);
							$sheetInicial->getStyle('B'.$num.':D'.$num)->getAlignment()->setHorizontal('justify');
							$sheetInicial->getStyle('E'.$num)->getAlignment()->setHorizontal('right');

							$sheetInicial->getStyle('B'.$num)->getAlignment()->setHorizontal('center');
							$sheetInicial->getStyle('B'.$num)->getFont()->setBold(true)->setSize(13);
							$sheetInicial->getStyle('D'.$num.':D'.$num)->getAlignment()->setHorizontal('justify');
							$sheetInicial->getStyle('E'.$num)->getAlignment()->setHorizontal('right');
							// $sheetInicial->getStyle('B'.$num.':E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');

							$num++;
							$totalPagarPrimerPago = $acumTotalPrimerPago-$varCont;

							$sheetInicial->setCellValue('C'.$num, 'Total real a Pagar de');
							$sheetInicial->setCellValue('D'.$num, 'Primer Pago = ');
							$sheetInicial->setCellValue('E'.$num, '$'.$totalPagarPrimerPago);
							$sheetInicial->getStyle('C'.$num.':E'.$num)->getFont()->setBold(true)->setSize(13);
							$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('right');
							$sheetInicial->getStyle('D'.$num.':D'.$num)->getAlignment()->setHorizontal('justify');
							$sheetInicial->getStyle('E'.$num)->getAlignment()->setHorizontal('right');
							$sheetInicial->getStyle('B'.$num.':E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');

							$num++;
							$num++;
							$num++;


							}
						$nIndx++;
					}
				}}
			}



		}else{

			$num = 3;
		}

		$num++;

		$montosPagos = [];
    $equivalenciasPagos = [];
    $equivalenciasAbonadasPagos = [];


    $abonado = 0;
		$diferido = 0;
		$reportado = 0;

    $totalAcumMonto = 0;
		$totalAcumEqv = 0;

    $reportadosPagos = [];
    $diferidosPagos = [];
    $abonadosPagos = [];

    $totalesPagos = [];
    foreach ($pagosRecorridos as $pagosR) {

									$sheetInicial->setCellValue('B'.$num, 'Abonos de '.$pagosR['name']);
									$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(15);
									// $sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
									$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
									
									$num++;
									$sheetInicial->setCellValue('A'.$num, 'N°');
									$sheetInicial->setCellValue('B'.$num, 'Fecha');
									$sheetInicial->setCellValue('C'.$num, 'Forma de Pago');
									$sheetInicial->setCellValue('D'.$num, 'Banco');
									$sheetInicial->setCellValue('E'.$num, 'Referencia');
									$sheetInicial->setCellValue('F'.$num, 'Monto');
									$sheetInicial->setCellValue('G'.$num, 'Tasa');
									$sheetInicial->setCellValue('H'.$num, '');
									$sheetInicial->setCellValue('I'.$num, 'Equivalente');
									$sheetInicial->setCellValue('J'.$num, 'Concepto');
									$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(13);
									$sheetInicial->getStyle('A'.$num.':J'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
									$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
									
									$num++;
									$num2 = 1;
									// $acumMontoContado = 0;
									// $acumEqvContado = 0;
									$montosPagos[$pagosR['id']] = 0;
									$equivalenciasPagos[$pagosR['id']] = 0;
									$reportadosPagos[$pagosR['id']] = 0;
									$diferidosPagos[$pagosR['id']] = 0;
									$abonadosPagos[$pagosR['id']] = 0;
									foreach ($pagos as $pago) {
										if(!empty($pago['id_pago'])){
											// $reportadoContado=0;
											// $diferidoContado=0;
											// $abonadoContado=0;

											if($pago['id_banco']==""){
												if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosR['name']){
													$bank = "";
													foreach ($bancos as $banco) {
														if(!empty($banco['id_banco'])){
															if($banco['id_banco']==$pago['id_banco']){
																$bank = $banco['nombre_banco']." - ".$banco['nombre_propietario'];
															}
														}
													}
													if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosR['name']){
														$restriccion = $despacho['fecha_inicial_senior'];
													}
							            $temporalidad = "";
							            if($pago['fecha_pago'] <= $restriccion){
							              $temporalidad = "Puntual";
							            }else{
							              $temporalidad = "Impuntual";
							            }

													$totalAcumMonto += $pago['monto_pago'];
													$totalAcumEqv += $pago['equivalente_pago'];

													$sheetInicial->setCellValue('A'.$num, $num2);
													$sheetInicial->setCellValue('B'.$num, $lider->formatFecha($pago['fecha_pago'])." - ".$temporalidad);
													$sheetInicial->setCellValue('C'.$num, $pago['forma_pago']);
													$sheetInicial->setCellValue('D'.$num, $bank);
													$sheetInicial->setCellValue('E'.$num, $pago['referencia_pago']);
													$sheetInicial->setCellValue('F'.$num, number_format($pago['monto_pago'],2,',','.'));
													$sheetInicial->setCellValue('G'.$num, $pago['tasa_pago']);
													$sheetInicial->setCellValue('H'.$num, '$');
													$sheetInicial->setCellValue('I'.$num, number_format($pago['equivalente_pago'],2,',','.'));
													$sheetInicial->setCellValue('J'.$num, $pago['tipo_pago']);
													$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
													$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');
													$sheetInicial->getStyle('H'.$num)->getAlignment()->setHorizontal('right');
													$sheetInicial->getStyle('I'.$num)->getAlignment()->setHorizontal('right');
													
													// $acumMontoContado += $pago['monto_pago'];
													// $acumEqvContado += $pago['equivalente_pago'];
													$montosPagos[$pagosR['id']] += $pago['monto_pago'];
													$equivalenciasPagos[$pagosR['id']] += $pago['equivalente_pago'];
													$reportado+=$pago['equivalente_pago'];
													if(ucwords(mb_strtolower($pago['estado']))=="Abonado"){
														$abonado+=$pago['equivalente_pago'];
														$reportadosPagos[$pagosR['id']] += $pago['equivalente_pago'];
														$abonadosPagos[$pagosR['id']] += $pago['equivalente_pago'];
														$sheetInicial->getStyle('A'.$num.':J'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('7744DD44');
													}
													else if(ucwords(mb_strtolower($pago['estado']))=="Diferido"){
														$diferido+=$pago['equivalente_pago'];
														$reportadosPagos[$pagosR['id']] += $pago['equivalente_pago'];
														$diferidosPagos[$pagosR['id']] += $pago['equivalente_pago'];
														$sheetInicial->getStyle('A'.$num.':J'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('77DD4444');
													}else{
														$reportadosPagos[$pagosR['id']] += $pago['equivalente_pago'];
													}
													
													$num++;
													$num2++;
												}
											}
											if($pago['id_banco']!=""){
												foreach ($movimientos as $mov) {
													if(!empty($mov['id_pago'])){
														if($mov['id_pago']==$pago['id_pago']){
															if($mov['fecha_movimiento']==$pago['fecha_pago']){		
												if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosR['name']){
													$bank = "";
													foreach ($bancos as $banco) {
														if(!empty($banco['id_banco'])){
															if($banco['id_banco']==$pago['id_banco']){
																$bank = $banco['nombre_banco']." - ".$banco['nombre_propietario'];
															}
														}
													}
													if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosR['name']){
														$restriccion = $despacho['fecha_inicial_senior'];
													}
													$temporalidad = "";
													if($pago['fecha_pago'] <= $restriccion){
														$temporalidad = "Puntual";
													}else{
														$temporalidad = "Impuntual";
													}
													// $acumMontoContado += $pago['monto_pago'];
													// $acumEqvContado += $pago['equivalente_pago'];
													$montosPagos[$pagosR['id']] += $pago['monto_pago'];
													$equivalenciasPagos[$pagosR['id']] += $pago['equivalente_pago'];
													if(ucwords(mb_strtolower($pago['estado']))=="Abonado"){
														$reportadosPagos[$pagosR['id']] += $pago['equivalente_pago'];
														$abonadosPagos[$pagosR['id']] += $pago['equivalente_pago'];
													}
													else if(ucwords(mb_strtolower($pago['estado']))=="Diferido"){
														$reportadosPagos[$pagosR['id']] += $pago['equivalente_pago'];
														$diferidosPagos[$pagosR['id']] += $pago['equivalente_pago'];
													}else{
														$reportadosPagos[$pagosR['id']] += $pago['equivalente_pago'];
													}

													$totalAcumMonto += $pago['monto_pago'];
													$totalAcumEqv += $pago['equivalente_pago'];

													$sheetInicial->setCellValue('A'.$num, $num2);
													$sheetInicial->setCellValue('B'.$num, $lider->formatFecha($pago['fecha_pago'])." - ".$temporalidad);
													$sheetInicial->setCellValue('C'.$num, $pago['forma_pago']);
													$sheetInicial->setCellValue('D'.$num, $bank);
													$sheetInicial->setCellValue('E'.$num, $pago['referencia_pago']);
													$sheetInicial->setCellValue('F'.$num, number_format($pago['monto_pago'],2,',','.'));
													$sheetInicial->setCellValue('G'.$num, $pago['tasa_pago']);
													$sheetInicial->setCellValue('H'.$num, '$');
													$sheetInicial->setCellValue('I'.$num, number_format($pago['equivalente_pago'],2,',','.'));
													$sheetInicial->setCellValue('J'.$num, $pago['tipo_pago']);
													$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
													$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');
													$sheetInicial->getStyle('H'.$num)->getAlignment()->setHorizontal('right');
													$sheetInicial->getStyle('I'.$num)->getAlignment()->setHorizontal('right');
													$reportado+=$pago['equivalente_pago'];
													if($pago['estado']=="Abonado"){
														$abonado+=$pago['equivalente_pago'];
														$sheetInicial->getStyle('A'.$num.':J'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('7744DD44');
													}
													if($pago['estado']=="Diferido"){
														$diferido+=$pago['equivalente_pago'];
														$sheetInicial->getStyle('A'.$num.':J'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('77DD4444');
													}
													
													$num++;
													$num2++;
												}
															}
														}
													}
												}
											}
										}
									}

									$sheetInicial->setCellValue('E'.$num, 'Monto: ');
									$sheetInicial->setCellValue('F'.$num, number_format($montosPagos[$pagosR['id']],2,',','.'));
									$sheetInicial->setCellValue('G'.$num, 'Eqv: ');
									// $sheetInicial->setCellValue('I'.$num, '$'.number_format($acumEqvContado,2,',','.'));
									$sheetInicial->setCellValue('I'.$num, '$'.number_format($equivalenciasPagos[$pagosR['id']],2,',','.'));
									

									$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(13);
									$sheetInicial->getStyle('A'.$num.':J'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CFCFCF');
									$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
									$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');
									$sheetInicial->getStyle('I'.$num)->getAlignment()->setHorizontal('right');
									$num++;

											
											// foreach ($pagos as $data):
											// 	if(!empty($data['id_pago'])):

											// 		if($data['id_banco']==""){
											// 			if($data['tipo_pago']=="Contado"):
											// 				if($data['estado']=="Abonado"){
											// 					$reportadoContado += $data['equivalente_pago'];
											// 					$abonadoContado += $data['equivalente_pago'];
											// 				}
											// 				else if($data['estado']=="Diferido"){
											// 					$reportadoContado += $data['equivalente_pago'];
											// 					$diferidoContado += $data['equivalente_pago'];
											// 				}else{
											// 					$reportadoContado += $data['equivalente_pago'];
											// 				}
											// 			endif;
											// 		}
											// 		if($data['id_banco']!=""){
											// 			foreach ($movimientos as $mov) {
											// 				if(!empty($mov['id_pago'])){
											// 					if($mov['id_pago']==$data['id_pago']){
											// 						if($mov['fecha_movimiento']==$data['fecha_pago']){
											// 			if($data['tipo_pago']=="Contado"):
											// 				if($data['estado']=="Abonado"){
											// 					$reportadoContado += $data['equivalente_pago'];
											// 					$abonadoContado += $data['equivalente_pago'];
											// 				}
											// 				else if($data['estado']=="Diferido"){
											// 					$reportadoContado += $data['equivalente_pago'];
											// 					$diferidoContado += $data['equivalente_pago'];
											// 				}else{
											// 					$reportadoContado += $data['equivalente_pago'];
											// 				}
											// 			endif;
											// 						}
											// 					}
											// 				}
											// 			}
											// 		}
											// 	endif;
											// endforeach;
										$sheetInicial->setCellValue('B'.$num, 'Reportado de '.$pagosR['name']);
										$sheetInicial->setCellValue('C'.$num, 'Diferido de '.$pagosR['name']);
										$sheetInicial->setCellValue('D'.$num, 'Abonado de '.$pagosR['name']);
										$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(14);
										// $sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
										// $sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
										// $sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');
										$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');

											$sheetInicial->getStyle('B'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCCCFF');
											$sheetInicial->getStyle('C'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCC');
											$sheetInicial->getStyle('D'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFCC');

										$num++;
										$sheetInicial->setCellValue('B'.$num, '$'.number_format($reportadosPagos[$pagosR['id']],2,',','.'));
										$sheetInicial->setCellValue('C'.$num, '$'.number_format($diferidosPagos[$pagosR['id']],2,',','.'));
										$sheetInicial->setCellValue('D'.$num, '$'.number_format($abonadosPagos[$pagosR['id']],2,',','.'));
										$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(15);
										$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
										$sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
										$sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
										$sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');

									$num++;
									$num++;
									$num++;


		}






			$sheetInicial->setCellValue('E'.$num, 'Monto: ');
			$sheetInicial->setCellValue('F'.$num, number_format($totalAcumMonto,2,',','.'));
			$sheetInicial->setCellValue('G'.$num, 'Total: ');
			$sheetInicial->setCellValue('I'.$num, '$'.number_format($totalAcumEqv,2,',','.'));
			$sheetInicial->getStyle('E'.$num)->getFont()->setBold(true)->setSize(12);
			$sheetInicial->getStyle('F'.$num)->getFont()->setBold(true)->setSize(14);
			$sheetInicial->getStyle('G'.$num)->getFont()->setBold(true)->setSize(12);
			$sheetInicial->getStyle('I'.$num)->getFont()->setBold(true)->setSize(14);


			$sheetInicial->getStyle('A'.$num.':J'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('A9A9A9');
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');
			$sheetInicial->getStyle('H'.$num)->getAlignment()->setHorizontal('right');
			$sheetInicial->getStyle('I'.$num)->getAlignment()->setHorizontal('right');

			$num++;

			if(!empty($_GET['lider']) && $_GET['route']=="Pagos"){
				$sheetInicial->setCellValue('E'.$num, 'Responsabilidad: ');
				$sheetInicial->setCellValue('F'.$num, '$'.number_format($nuevoTotal,2,',','.'));
				$sheetInicial->getStyle('E'.$num)->getFont()->setBold(true)->setSize(12);
				$sheetInicial->getStyle('F'.$num)->getFont()->setBold(true)->setSize(14);
				$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
				$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');
			
				$sheetInicial->setCellValue('G'.$num, 'Resta: ');
				$sheetInicial->setCellValue('I'.$num, '$'.number_format($nuevoTotal-$abonado,2,',','.'));
				$sheetInicial->getStyle('G'.$num)->getFont()->setBold(true)->setSize(13);
				$sheetInicial->getStyle('I'.$num)->getFont()->setBold(true)->setSize(15);
				$sheetInicial->getStyle('G'.$num.':I'.$num)->getFont()->getColor()->setRGB('FF0000');
				$sheetInicial->getStyle('I'.$num)->getAlignment()->setHorizontal('right');
			}			

			$num++;

			$sheetInicial->setCellValue('B'.$num, 'Reportado General');
			$sheetInicial->setCellValue('C'.$num, 'Diferido General');
			$sheetInicial->setCellValue('D'.$num, 'Abonado General');
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(15);
			// $sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
			// $sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
			// $sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');

				$sheetInicial->getStyle('B'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCCCFF');
				$sheetInicial->getStyle('C'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCC');
				$sheetInicial->getStyle('D'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFCC');

			$num++;
			$sheetInicial->setCellValue('B'.$num, '$'.number_format($reportado,2,',','.'));
			$sheetInicial->setCellValue('C'.$num, '$'.number_format($diferido,2,',','.'));
			$sheetInicial->setCellValue('D'.$num, '$'.number_format($abonado,2,',','.'));
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
			$sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
			$sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');


		// $sheet->setCellValue('A1','Hola Mundo!');

		//$numCampana

		$write = new Writer\Xlsx($spreadsheet);
		$exec = $write->save($this->file);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Reporte de Pagos Campaña '.$numCampana.'.xlsx"');
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');

	}

	public function exportarReportedePagosExcel($dat, $lider){
		$opcionesPagos = $dat['opcionesPagos'];
		$reporteGeneral = $dat['reporteGeneral'];
		$despacho = $dat['despachos'];
		$mes = $dat['mes'];

		$numCampana = $despacho['numero_campana']."_".$despacho['anio_campana'];
		$numDespacho = $despacho['numero_despacho'];
		$stringName = "Pago Campaña ".$numCampana;
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0);

		$sheetInicial = $spreadsheet->getActiveSheet()->setTitle('Reporte de Pagos');
		$sheetInicial->getColumnDimension('A')->setAutoSize(true);
		$sheetInicial->getColumnDimension('B')->setAutoSize(true);
		$sheetInicial->getColumnDimension('C')->setAutoSize(true);
		$sheetInicial->getColumnDimension('D')->setAutoSize(true);
		$sheetInicial->getColumnDimension('E')->setAutoSize(true);
		$sheetInicial->getColumnDimension('F')->setAutoSize(true);

		
		$num2 = 1;
		$num = 3;
		

		// $sheetInicial->setCellValue('B'.$num, 'Contado');
		// $sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(15);
		// // $sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
		// $sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
		
		// $sheetInicial->setCellValue('A'.$num, 'N°');
		// $sheetInicial->setCellValue('B'.$num, 'Fecha');
		// $sheetInicial->setCellValue('C'.$num, 'Forma de Pago');
		// $sheetInicial->setCellValue('D'.$num, 'Banco');
		// $sheetInicial->setCellValue('E'.$num, 'Referencia');
		// $sheetInicial->setCellValue('F'.$num, 'Monto');
		// 	$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setBold(true)->setSize(13);
		// $sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
		// $sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
		
				

			$num++;
			$sheetInicial->getStyle('B'.$num.':E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
			$sheetInicial->getStyle('B'.$num.':E'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->setCellValue('B'.$num, 'REPORTE DE');
			$sheetInicial->getStyle('B'.$num)->getAlignment()->setHorizontal('right');
			$sheetInicial->setCellValue('C'.$num, 'CONCILIACION');
			$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
				$sheetInicial->setCellValue('E'.$num, mb_strtoupper('Al '.date('d').'-'.$mes.' '.date("h:i a")));
			$sheetInicial->getStyle('E'.$num)->getAlignment()->setHorizontal('center');

			$num++;
			$sheetInicial->setCellValue('B'.$num, 'Reportado General');
			$sheetInicial->setCellValue('C'.$num, 'Diferido General');
			$sheetInicial->setCellValue('D'.$num, 'Abonado General');
			$sheetInicial->setCellValue('E'.$num, 'Pendiente por Coinciliar');
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setBold(true)->setSize(15);
			// $sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
			// $sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
			// $sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');
			// $sheetInicial->getStyle('E'.$num)->getFont()->getColor()->setRGB('5555FF');
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
				$sheetInicial->getStyle('B'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCCCFF');
				$sheetInicial->getStyle('C'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCC');
				$sheetInicial->getStyle('D'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFCC');
				$sheetInicial->getStyle('E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDFF');

			$num++;
			$sheetInicial->setCellValue('B'.$num, '$'.number_format($reporteGeneral['reportado'],2,',','.'));
			$sheetInicial->setCellValue('C'.$num, '$'.number_format($reporteGeneral['diferido'],2,',','.'));
			$sheetInicial->setCellValue('D'.$num, '$'.number_format($reporteGeneral['abonado'],2,',','.'));
			$sheetInicial->setCellValue('E'.$num, '$'.number_format($reporteGeneral['pendiente'],2,',','.'));
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
			$sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
			$sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');
			$sheetInicial->getStyle('E'.$num)->getFont()->getColor()->setRGB('5555FF');



			$num++;
			$num++;
			$num++;
			foreach ($opcionesPagos as $report) { if ($report['condicion']!=""){
				$opcion = $report['titulo'];

				$num++;
				$sheetInicial->getStyle('B'.$num.':E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
				$sheetInicial->getStyle('B'.$num.':E'.$num)->getFont()->setBold(true)->setSize(14);
				$sheetInicial->setCellValue('C'.$num, 'REPORTE');
				$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('right');
				$sheetInicial->setCellValue('E'.$num, mb_strtoupper('Al '.date('d').'-'.$mes.' '.date("h:i a")));
				$sheetInicial->getStyle('E'.$num)->getAlignment()->setHorizontal('center');
				$num++;
				$sheetInicial->mergeCells('B'.$num.':E'.$num);
				$sheetInicial->getStyle('B'.$num.':E'.$num)->getFont()->setBold(true)->setSize(13);
				$sheetInicial->setCellValue('B'.$num, mb_strtoupper($opcion));
				$sheetInicial->getStyle('B'.$num)->getAlignment()->setHorizontal('center');
				$sheetInicial->getStyle('B'.$num.':E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('EEEEEE');
				$num++;
				$sheetInicial->setCellValue('B'.$num, 'Reportado General');
				$sheetInicial->setCellValue('C'.$num, 'Diferido General');
				$sheetInicial->setCellValue('D'.$num, 'Abonado General');
				$sheetInicial->setCellValue('E'.$num, 'Pendiente por Coinciliar');
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setBold(true)->setSize(15);
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
				$sheetInicial->getStyle('B'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCCCFF');
				$sheetInicial->getStyle('C'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCC');
				$sheetInicial->getStyle('D'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFCC');
				$sheetInicial->getStyle('E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDFF');

				$num++;
				$sheetInicial->setCellValue('B'.$num, '$'.number_format($report['reportado'],2,',','.'));
				$sheetInicial->setCellValue('C'.$num, '$'.number_format($report['diferido'],2,',','.'));
				$sheetInicial->setCellValue('D'.$num, '$'.number_format($report['abonado'],2,',','.'));
				$sheetInicial->setCellValue('E'.$num, '$'.number_format($report['pendiente'],2,',','.'));
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setBold(true)->setSize(15);
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
				$sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
				$sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
				$sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');
				$sheetInicial->getStyle('E'.$num)->getFont()->getColor()->setRGB('5555FF');
				// $sheetInicial->getStyle('B'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDFF');
				// $sheetInicial->getStyle('C'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFDDDD');
				// $sheetInicial->getStyle('D'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDFFDD');
				// $sheetInicial->getStyle('E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDFF');

				$num++;
				$num++;
				$num++;
			} }


			$num++;
			$sheetInicial->getStyle('B'.$num.':E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
			$sheetInicial->getStyle('B'.$num.':E'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->setCellValue('B'.$num, 'REPORTE DE');
			$sheetInicial->getStyle('B'.$num)->getAlignment()->setHorizontal('right');
			$sheetInicial->setCellValue('C'.$num, 'CONCILIACION');
			$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
				$sheetInicial->setCellValue('E'.$num, mb_strtoupper('Al '.date('d').'-'.$mes.' '.date("h:i a")));
			$sheetInicial->getStyle('E'.$num)->getAlignment()->setHorizontal('center');
			$num++;
			$sheetInicial->setCellValue('B'.$num, 'Reportado General');
			$sheetInicial->setCellValue('C'.$num, 'Diferido General');
			$sheetInicial->setCellValue('D'.$num, 'Abonado General');
			$sheetInicial->setCellValue('E'.$num, 'Pendiente por Coinciliar');
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
				$sheetInicial->getStyle('B'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCCCFF');
				$sheetInicial->getStyle('C'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCC');
				$sheetInicial->getStyle('D'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFCC');
				$sheetInicial->getStyle('E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDFF');


			$num++;
			$sheetInicial->setCellValue('B'.$num, '$'.number_format($reporteGeneral['reportado'],2,',','.'));
			$sheetInicial->setCellValue('C'.$num, '$'.number_format($reporteGeneral['diferido'],2,',','.'));
			$sheetInicial->setCellValue('D'.$num, '$'.number_format($reporteGeneral['abonado'],2,',','.'));
			$sheetInicial->setCellValue('E'.$num, '$'.number_format($reporteGeneral['pendiente'],2,',','.'));
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
			$sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
			$sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');
			$sheetInicial->getStyle('E'.$num)->getFont()->getColor()->setRGB('5555FF');




		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Reporte de Pagos Despacho '.$numDespacho.'-Campaña '.$numCampana.'.xlsx"');
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');

	}

	public function LeerExcel($page, $filas, $colum, $opt){
		//****************************************************************************************************************************************************
		//LEER
		// $reader = Reader\Xlsx("Xlsx");

		$reader = IOFactory::createReader($this->format);
		$load = $reader->load($this->file);
		
		if(!empty($page)){
			if(gettype($page) == "integer"){ 	$sheet = $load->getSheet($page);	}
			if(gettype($page) == "string"){	$sheet = $load->getSheetByName($page);	}
		}else{	$sheet = $load->getSheet(0);	}

		if(!empty($opt)){	
			if($opt == 'vector' || $opt == 0){	$tipo = 'vector';	}
			if($opt == 'matriz' || $opt == 1){	$tipo = 'matriz';	}
			if($opt == 'indexado' || $opt == 2){	$tipo = 'indexado';	}
			if($opt == 'bd' || $opt == 3){	$tipo = 'bd';	}
		}else{	$tipo = 'vector';	}

		$i = 1;
		$j = 0;
		$k = 0;
		$datas = ['EstatusExecute'=> true];
		$data = [];
		foreach ($sheet->getRowIterator($filas['filI'], $filas['filF']) as $row) {
			$cellIterator = $row->getCellIterator($colum['colI'], $colum['colF']);
			$cellIterator->setIterateOnlyExistingCells(false);
			$j = 0;
			$dataa = [];
			foreach ($cellIterator as $cell) {
				if(!is_null($cell)){
					// $value = $cell->getValue(); // Resultados que estan visualizados
					$value = $cell->getCalculatedValue(); // Resultados con formulas y todo

					if($tipo == 'vector'){
						$index = $this->cols[$j].$i;
						$data += [$index => $value];
					}
					if($tipo=='matriz'){
						$dataa += [$this->cols[$j] => $value];
					}
					if($tipo == "indexado"){
						$index = $this->cols[$j].$i;
						$dataa += [$j => array("index"=>$index, 'value' =>$value)];
					}
					if($tipo=='bd'){
						$dataa += [$j => $value];
					}
				}
				$j++;
			}
			if($tipo =='matriz'){
				$data += [$i => $dataa];
			}
			if($tipo =='bd'){
				$data += [$k => $dataa];
			}
			if($tipo =='indexado'){
				$data += [$k => $dataa];
			}
			$i++;
			$k++;
		}
		$datas += $data;
		return $datas;

		//*****************************************************************************************************************************************************

	}

}
