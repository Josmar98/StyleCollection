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
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer;
use PhpOffice\PhpSpreadsheet\Reader;
use PhpOffice\PhpSpreadsheet\Settings;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

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
														$restriccion = $pagosR['fecha_pago'];
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
													// if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosR['name']){
													// 	$restriccion = $despacho['fecha_inicial_senior'];
													// }
													if(ucwords(mb_strtolower($pago['tipo_pago']))==$pagosR['name']){
														$restriccion = $pagosR['fecha_pago'];
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
													// $sheetInicial->setCellValue('B'.$num, $pago['fecha_pago']." - ".$pagosR['fecha_pago']." - ".$temporalidad);
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


		// // $sheet->setCellValue('A1','Hola Mundo!');

		// //$numCampana
		// 	// echo "asd";

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

	public function exportarReporteExcelLibroIva($dat, $lider){
		Settings::setLocale('es');
		$meses = $dat['meses'];
		$range = $dat['range'];
		$operacionMostrarInformacion = $dat['operacionMostrarInformacion'];
		$nameLibrosComplement = "";
		if(isset($_GET['mes'])){
			$actualMes = $dat['actualMes'];
			$anteriorMes = $dat['anteriorMes'];
			$nameLibrosComplement .= " ".$meses[$actualMes];
		}
		$actualAnio = $dat['actualAnio'];
		$anteriorAnio = $dat['anteriorAnio'];
		$nameLibrosComplement .= " ".$actualAnio;

		$nameLibro1="Libro de Ventas".$nameLibrosComplement;
		$nameLibro2="Libro de Compras".$nameLibrosComplement;
		$nameLibro3="Resumen";
		// echo $nameLibro1."<br>";
		// echo $nameLibro2."<br>";
		// echo $nameLibro3."<br>";


		$digitosParaCodigo = $dat['digitosParaCodigo'];
		$digitosParaCodigo2 = $dat['digitosParaCodigo2'];
		$cantidadIVA = $dat['cantidadIVA'];

		$inicioFecha = $dat['inicioFecha'];
		$finFecha = $dat['finFecha'];

		$compras = $dat['compras'];
		$resumenCompra = $dat['resumenCompra'];
		$facturasFiscales = $dat['facturasFiscales'];
		
		$excedenteCreditosFiscalesPendienteAnterior = $dat['excedenteCreditosFiscalesPendienteAnterior'];
		$debitosFiscalesPendienteAnterior = $dat['debitosFiscalesPendienteAnterior'];


		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0);
		$spreadsheet->getActiveSheet()->setTitle($nameLibro1);
		$sheet = $spreadsheet->getActiveSheet();
		$letra11L1 = "H"; //B=H
		$letra12L1 = "L"; //F=L
		$letra21L1 = "M"; //G=M
		$letra22L1 = "N"; //H=N
		$letra31L1 = "O"; //I=O
		$letra32L1 = "P"; //J=P
		$letra41L1 = "Q"; //K=Q
		$letra42L1 = "R"; //L=R

		// CABECERA PRINCIPAL  LIBRO 1
			$sheet->getColumnDimension('A')->setAutoSize(true);
			$sheet->getColumnDimension('B')->setAutoSize(true);
			$sheet->getColumnDimension('C')->setAutoSize(true);
			$sheet->getColumnDimension('D')->setAutoSize(true);
			$sheet->getColumnDimension('E')->setAutoSize(true);
			$sheet->getColumnDimension('F')->setAutoSize(true);
			$sheet->getColumnDimension('G')->setAutoSize(true);
			$sheet->getColumnDimension('H')->setAutoSize(true);
			$sheet->getColumnDimension('I')->setAutoSize(true);
			$sheet->getColumnDimension('J')->setAutoSize(true);
			$sheet->getColumnDimension('K')->setAutoSize(true);
			$sheet->getColumnDimension('L')->setAutoSize(true);
			$sheet->getColumnDimension('M')->setAutoSize(true);
			$sheet->getColumnDimension('N')->setAutoSize(true);
			$sheet->getColumnDimension('O')->setAutoSize(true);
			$sheet->getColumnDimension('P')->setAutoSize(true);
			$sheet->getColumnDimension('Q')->setAutoSize(true);
			$sheet->getColumnDimension('R')->setAutoSize(true);
			$sheet->getColumnDimension('S')->setAutoSize(true);
			$sheet->getColumnDimension('T')->setAutoSize(true);
			$sheet->getStyle('A1:Z1000')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');

			$num2L2 = 1;
			$numL1 = 1;
			$numL1++;
			// $sheet->getStyle('B'.$numL1.':E'.$numL1)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
			$sheet->getStyle('B'.$numL1.':E'.$numL1)->getFont()->setBold(true)->setSize(18);
			$sheet->mergeCells('B'.$numL1.':E'.$numL1)->setCellValue('B'.$numL1, 'INVERSIONES STYLE COLLECTION, C.A.');

			$numL1++;
			$sheet->getStyle('B'.$numL1.':E'.$numL1)->getFont()->setBold(true)->setSize(18);
			$sheet->mergeCells('B'.$numL1.':E'.$numL1)->setCellValue('B'.$numL1, 'RIF: J-408497786');

			$numL1++;
			$sheet->getStyle('B'.$numL1.':F'.$numL1)->getFont()->setBold(true)->setSize(18)->getUnderline(true);
			$sheet->mergeCells('B'.$numL1.':F'.$numL1)->setCellValue('B'.$numL1, 'LIBRO DE VENTAS DEL '.str_replace("-","/",$lider->formatFecha($inicioFecha)).' HASTA EL '.str_replace("-","/",$lider->formatFecha($finFecha)));

			$numL1++;
			$numL1++;
			$sheet->getStyle('L'.$numL1.':S'.$numL1)->getFont()->setBold(true)->setSize(13);
			$sheet->getStyle('L'.$numL1.':S'.$numL1)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('L'.$numL1.':S'.$numL1)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
			$sheet->mergeCells('L'.$numL1.':S'.($numL1+1))->setCellValue('L'.$numL1, mb_strtoupper('Ventas Gravadas'));
			$sheet->getStyle('L'.$numL1.':S'.($numL1+1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));

			$numL1++;
		// CABECERA PRINCIPAL  LIBRO 1

		// CUADRO PRINCIPAL - TITULO  LIBRO 1
			$numL1++;
			$sheet->getStyle('B'.$numL1.':S'.$numL1)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL1.':S'.$numL1)->getAlignment()->setHorizontal('center')->setWrapText(true);
			$sheet->getStyle('B'.$numL1.':S'.$numL1)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
			$sheet->getStyle('B'.$numL1.':S'.$numL1)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL1, "Oper. \nNro.");
			$sheet->setCellValue('C'.$numL1, "Fecha \nFactura \n/NC/ND/");
			$sheet->setCellValue('D'.$numL1, "Nro.  R.I.F");
			$sheet->setCellValue('E'.$numL1, "Nombre o Razón Social del Cliente");
			$sheet->setCellValue('F'.$numL1, "Tipo de \nTransacción");
			$sheet->setCellValue('G'.$numL1, "Número de \nFactura");
			$sheet->setCellValue('H'.$numL1, "   Número de Control   ");
			$sheet->setCellValue('I'.$numL1, "Número \nNota \nDébito");
			$sheet->setCellValue('J'.$numL1, "Número \nNota \nCrédito");
			$sheet->setCellValue('K'.$numL1, "Número \nde \nFactura \nAfectada");

			$sheet->setCellValue('L'.$numL1, "Total Ventas \nIncluyendo \nel IVA");
			$sheet->setCellValue('M'.$numL1, "Ventas \n Exentas \n Exoneradas o \n No Sujetas");
			$sheet->setCellValue('N'.$numL1, "Auto consumo, \n Retiro, \n Desincorporación \n de Inventario");
			$sheet->setCellValue('O'.$numL1, "Base \nImponible");
			$sheet->setCellValue('P'.$numL1, "% "."Alicuota");
			$sheet->setCellValue('Q'.$numL1, "Impuesto \nIVA \n Alicuota \nGeneral");
			$sheet->setCellValue('R'.$numL1, "IVA \n Retenido \n (por \nComprador)");
			$sheet->setCellValue('S'.$numL1, "Número de \n Comprobante \n (Ret. iva)");
		// CUADRO PRINCIPAL - TITULO  LIBRO 1
		
		// CUADRO PRINCIPAL - CONTENIDO  LIBRO 1
			$cuotaSinIVA=0;
			$precioIVA=0;
			$cuotaConIVA=0;
			$coutasExentasIva=0;
			$autoConsumo=0;
			$retencionIVaVentas=0;

			$totalPrecioIva = 0;
			$totalCoutasExentasIva=0;
			$totalAutoConsumo=0;
			$totalRetencionIVa=0;

			$totalCuotaConIva= "=0";
			$totalCuotaSinIva = "=0";
			$totalPrecioIva = "=0";
			$totalCoutasExentasIva="=0";
			$totalAutoConsumo="=0";
			$totalRetencionIVa="=0";
			$indx=1;
			$numL1++;
			$numInicialL1=$numL1;
			if(count($facturasFiscales)>1){ foreach ($facturasFiscales as $fiscal){ if(!empty($fiscal['fecha_emision'])){
				$estat = false;
				if($fiscal['estado_factura']==1){
					$estat = true;
				}
				$cantidadfactura = $digitosParaCodigo-strlen($fiscal['numero_factura']);
				$numero_facturaL1 = "";
				for ($i=0; $i<$cantidadfactura; $i++){  $numero_facturaL1.="0";}
				$numero_facturaL1 .= "".$fiscal['numero_factura'];

				$cantidadControl1 = $digitosParaCodigo-strlen($fiscal['numero_control1']);
				$numero_control1L1 = "";
				if($cantidadControl1>0){ $numero_control1L1 .= "00-"; }
				for ($i=0; $i<$cantidadControl1; $i++){  $numero_control1L1.="0";}
				$numero_control1L1 .= "".$fiscal['numero_control1'];

				$cantidadControl2 = $digitosParaCodigo-strlen($fiscal['numero_control2']);
				$numero_control2L1 = "";
				if($cantidadControl2>0){ $numero_control2L1 .= "00-"; }
				for ($i=0; $i<$cantidadControl2; $i++){  $numero_control2L1.="0";}
				$numero_control2L1 .= "".$fiscal['numero_control2'];

				$cuotaSinIVA = $fiscal['totalVenta'];
				$precioIVA="=O".$numL1."/100*".$cantidadIVA;
				$cuotaConIVA = "=O".$numL1."+Q".$numL1;
				$coutasExentasIva=0;
				$autoConsumo=0;
				$retencionIVaVentas=0;
				if($estat){
					$totalCuotaConIva.="+L".$numL1;
					$totalCoutasExentasIva.="+M".$numL1;
					$totalAutoConsumo.="+N".$numL1;
					$totalCuotaSinIva.="+O".$numL1;
					$totalPrecioIva.="+Q".$numL1;
					$totalRetencionIVa.="+R".$numL1;
				}


				
				$sheet->getStyle('B'.$numL1.':S'.$numL1)->getFont()->setSize(12);
				$sheet->getStyle('B'.$numL1.':S'.$numL1)->getAlignment()->setHorizontal('center');
				$sheet->getStyle('E'.$numL1)->getAlignment()->setHorizontal('left');
				// $sheet->getStyle('G'.$numL1)->getAlignment()->setHorizontal('right');
				$sheet->getStyle('L'.$numL1.':R'.$numL1)->getAlignment()->setHorizontal('right');
				$sheet->getStyle('L'.$numL1.':O'.$numL1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$sheet->getStyle('P'.$numL1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
				$sheet->getStyle('Q'.$numL1.':R'.$numL1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


				$sheet->setCellValue('B'.$numL1, $indx);
				$sheet->setCellValue('C'.$numL1, str_replace("-","/",$lider->formatFecha($fiscal['fecha_emision'])) );
				if($estat){ $sheet->setCellValue('D'.$numL1, $fiscal['cod_rif'].$fiscal['rif']); }
				if($estat){ $sheet->setCellValue('E'.$numL1, mb_strtoupper($fiscal['primer_nombre']." ".$fiscal['segundo_nombre']." ".$fiscal['primer_apellido']." ".$fiscal['segundo_apellido'])); }
				else{ $sheet->setCellValue('E'.$numL1, "***ANULADO***"); }
				if($estat){ $sheet->setCellValue('F'.$numL1, "01"); }
				if($estat){ $sheet->setCellValue('G'.$numL1, $numero_facturaL1); }
				if( ($numero_control1L1==$numero_control2L1) || (($fiscal['numero_control1']>0) && ($fiscal['numero_control2']==0)) ){ $sheet->setCellValue('H'.$numL1, $numero_control1L1); }
				else{ $sheet->setCellValue('H'.$numL1, $numero_control1L1." / ".$numero_control2L1);}
				$sheet->setCellValue('I'.$numL1, "");
				$sheet->setCellValue('J'.$numL1, "");
				$sheet->setCellValue('K'.$numL1, "");
				if($estat){ $sheet->setCellValue('L'.$numL1, $cuotaConIVA); }
				if($estat){ $sheet->setCellValue('M'.$numL1, $coutasExentasIva); }
				if($estat){ $sheet->setCellValue('N'.$numL1, $autoConsumo); }
				if($estat){ $sheet->setCellValue('O'.$numL1, $cuotaSinIVA); }
				if($estat){ $sheet->setCellValue('P'.$numL1, $cantidadIVA."%"); }
				if($estat){ $sheet->setCellValue('Q'.$numL1, $precioIVA); }
				if($estat){ $sheet->setCellValue('R'.$numL1, $retencionIVaVentas); }
				if($estat){ $sheet->setCellValue('S'.$numL1, ""); }


				$indx++;
				$numL1++;

			} } } else{

				$sheet->getStyle('B'.$numL1.':S'.$numL1)->getFont()->setSize(12);
				$sheet->getStyle('B'.$numL1.':S'.$numL1)->getAlignment()->setHorizontal('center');
				$sheet->getStyle('E'.$numL1)->getAlignment()->setHorizontal('left');
				// $sheet->getStyle('G'.$numL1)->getAlignment()->setHorizontal('right');
				$sheet->getStyle('L'.$numL1.':R'.$numL1)->getAlignment()->setHorizontal('right');

				$sheet->setCellValue('B'.$numL1, $indx);
				$sheet->setCellValue('C'.$numL1, "");
				$sheet->setCellValue('D'.$numL1, ""); 
				$sheet->setCellValue('E'.$numL1, "***NO HUBO VENTAS***");
				$sheet->setCellValue('F'.$numL1, "");
				$sheet->setCellValue('G'.$numL1, "");
				$sheet->setCellValue('H'.$numL1, "");
				$sheet->setCellValue('I'.$numL1, "");
				$sheet->setCellValue('J'.$numL1, "");
				$sheet->setCellValue('K'.$numL1, "");

				$sheet->setCellValue('L'.$numL1, number_format($cuotaConIVA,2,',','.'));
				$sheet->setCellValue('M'.$numL1, number_format($coutasExentasIva,2,',','.'));
				$sheet->setCellValue('N'.$numL1, number_format($autoConsumo,2,',','.'));
				$sheet->setCellValue('O'.$numL1, number_format($cuotaSinIVA,2,',','.'));
				$sheet->setCellValue('P'.$numL1, $cantidadIVA."%");
				$sheet->setCellValue('Q'.$numL1, number_format($precioIVA,2,',','.'));
				$sheet->setCellValue('R'.$numL1, number_format($retencionIVaVentas,2,',','.'));
				$sheet->setCellValue('S'.$numL1, "");
				$indx++;
				$numL1++;
			}
			$sheet->getStyle('B'.$numInicialL1.':S'.($numL1-1))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
		// CUADRO PRINCIPAL - CONTENIDO  LIBRO 1

		// CUADRO PRINCIPAL - TOTALIZADOR  LIBRO 1
			$sheet->getStyle('B'.$numInicialL1.':S'.($numL1))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle('B'.$numL1.':K'.$numL1)->getFont()->setBold(true)->setSize(14);
			$sheet->getStyle('L'.$numL1.':S'.$numL1)->getFont()->setBold(true)->setSize(13);
			$sheet->getStyle('B'.$numL1.':K'.$numL1)->getAlignment()->setHorizontal('center');
			$sheet->mergeCells('B'.$numL1.':K'.$numL1)->setCellValue('B'.$numL1, mb_strtoupper("TOTALES"));
			$sheet->getStyle('L'.$numL1.':S'.$numL1)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('L'.$numL1.':O'.$numL1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('P'.$numL1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
			$sheet->getStyle('Q'.$numL1.':R'.$numL1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->setCellValue('L'.$numL1, $totalCuotaConIva);
			$sheet->setCellValue('M'.$numL1, $totalCoutasExentasIva);
			$sheet->setCellValue('N'.$numL1, $totalAutoConsumo);
			$sheet->setCellValue('O'.$numL1, $totalCuotaSinIva);
			$sheet->setCellValue('P'.$numL1, "");
			$sheet->setCellValue('Q'.$numL1, $totalPrecioIva);
			$sheet->setCellValue('R'.$numL1, $totalRetencionIVa);
			$sheet->setCellValue('S'.$numL1, "");
			
			$sheet->getStyle('S'.$numL1)->getAlignment()->setHorizontal('center');
			// $vAlicuotaGeneralDBaseImponible="=O".$numL1;
			// $vAlicuotaGeneralDDebitoFiscal="=Q".$numL1;
			$numTotalizadorL1 = $numL1;
			$numL1++;
		// CUADRO PRINCIPAL - TOTALIZADOR  LIBRO 1
		
		// CUADRO RESUMEN DE DEBITO  LIBRO 1

			$vAlicuotaGeneralDBaseImponible="=O".$numTotalizadorL1;
			$vAlicuotaGeneralDDebitoFiscal="=Q".$numTotalizadorL1;
			$numL1++;
			$sheet->getStyle($letra11L1.$numL1.':'.$letra42L1.$numL1)->getFont()->setSize(13);
			$sheet->getStyle($letra11L1.$numL1.':'.$letra42L1.$numL1)->getAlignment()->setHorizontal('center');
			if(isset($_GET['mes'])){ $msjTemp = "Mes"; }else{ $msjTemp = "Año"; }
			$sheet->mergeCells($letra11L1.$numL1.':'.$letra12L1.($numL1))->setCellValue($letra11L1.$numL1, "Resumen del {$msjTemp} Base Imponible y Débitos Fiscales");
			$sheet->getStyle($letra11L1.$numL1.':'.$letra12L1.($numL1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->mergeCells($letra21L1.$numL1.':'.$letra22L1.($numL1))->setCellValue($letra21L1.$numL1, "Base Imponible");
			$sheet->getStyle($letra21L1.$numL1.':'.$letra22L1.($numL1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->mergeCells($letra31L1.$numL1.':'.$letra32L1.($numL1))->setCellValue($letra31L1.$numL1, "Débito Fiscal");
			$sheet->getStyle($letra31L1.$numL1.':'.$letra32L1.($numL1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->mergeCells($letra41L1.$numL1.':'.$letra42L1.($numL1))->setCellValue($letra41L1.$numL1, "Retenciones de IVA");
			$sheet->getStyle($letra41L1.$numL1.':'.$letra42L1.($numL1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));

			$numL1++;
			$numInicialL1=$numL1;
			$vtotalDBaseImponible="=0";
			$vtotalDDebitoFiscal="=0";
			$vtotalDRetencion="=0";
			$sheet->getStyle($letra11L1.$numL1.':'.$letra42L1.$numL1)->getFont()->setSize(12);
			$sheet->getStyle($letra21L1.$numL1.':'.$letra42L1.$numL1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle($letra11L1.$numL1.':'.$letra12L1.$numL1)->getAlignment()->setHorizontal('left');
			$sheet->getStyle($letra21L1.$numL1.':'.$letra42L1.$numL1)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra11L1.$numL1.':'.$letra12L1.($numL1))->setCellValue($letra11L1.$numL1, "Ventas Internas No Gravadas");
			$sheet->mergeCells($letra21L1.$numL1.':'.$letra22L1.($numL1))->setCellValue($letra21L1.$numL1, 0);
			$sheet->mergeCells($letra31L1.$numL1.':'.$letra32L1.($numL1))->setCellValue($letra31L1.$numL1, 0);
			$sheet->mergeCells($letra41L1.$numL1.':'.$letra42L1.($numL1))->setCellValue($letra41L1.$numL1, 0);
			$vtotalDBaseImponible.="+".$letra21L1.$numL1;
			$vtotalDDebitoFiscal.="+".$letra31L1.$numL1;
			$vtotalDRetencion.="+".$letra41L1.$numL1;


			$numL1++;
			$sheet->getStyle($letra11L1.$numL1.':'.$letra42L1.$numL1)->getFont()->setSize(12);
			$sheet->getStyle($letra21L1.$numL1.':'.$letra42L1.$numL1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle($letra11L1.$numL1.':'.$letra12L1.$numL1)->getAlignment()->setHorizontal('left');
			$sheet->getStyle($letra21L1.$numL1.':'.$letra42L1.$numL1)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra11L1.$numL1.':'.$letra12L1.($numL1))->setCellValue($letra11L1.$numL1, "Ventas Internas Afectas solo Alicuota General");
			$sheet->mergeCells($letra21L1.$numL1.':'.$letra22L1.($numL1))->setCellValue($letra21L1.$numL1, $vAlicuotaGeneralDBaseImponible);
			$sheet->mergeCells($letra31L1.$numL1.':'.$letra32L1.($numL1))->setCellValue($letra31L1.$numL1, $vAlicuotaGeneralDDebitoFiscal);
			$sheet->mergeCells($letra41L1.$numL1.':'.$letra42L1.($numL1))->setCellValue($letra41L1.$numL1, 0);
			$vtotalDBaseImponible.="+".$letra21L1.$numL1;
			$vtotalDDebitoFiscal.="+".$letra31L1.$numL1;
			$vtotalDRetencion.="+".$letra41L1.$numL1;

			$numL1++;
			$sheet->getStyle($letra11L1.$numL1.':'.$letra42L1.$numL1)->getFont()->setSize(12);
			$sheet->getStyle($letra21L1.$numL1.':'.$letra42L1.$numL1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle($letra11L1.$numL1.':'.$letra12L1.$numL1)->getAlignment()->setHorizontal('left');
			$sheet->getStyle($letra21L1.$numL1.':'.$letra42L1.$numL1)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra11L1.$numL1.':'.$letra12L1.($numL1))->setCellValue($letra11L1.$numL1, "Ventas Internas Afectas Alicuota General + Adicional");
			$sheet->mergeCells($letra21L1.$numL1.':'.$letra22L1.($numL1))->setCellValue($letra21L1.$numL1, 0);
			$sheet->mergeCells($letra31L1.$numL1.':'.$letra32L1.($numL1))->setCellValue($letra31L1.$numL1, 0);
			$sheet->mergeCells($letra41L1.$numL1.':'.$letra42L1.($numL1))->setCellValue($letra41L1.$numL1, 0);
			$vtotalDBaseImponible.="+".$letra21L1.$numL1;
			$vtotalDDebitoFiscal.="+".$letra31L1.$numL1;
			$vtotalDRetencion.="+".$letra41L1.$numL1;

			$numL1++;
			$sheet->getStyle($letra11L1.$numL1.':'.$letra42L1.$numL1)->getFont()->setSize(12);
			$sheet->getStyle($letra21L1.$numL1.':'.$letra42L1.$numL1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle($letra11L1.$numL1.':'.$letra12L1.$numL1)->getAlignment()->setHorizontal('left');
			$sheet->getStyle($letra21L1.$numL1.':'.$letra42L1.$numL1)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra11L1.$numL1.':'.$letra12L1.($numL1))->setCellValue($letra11L1.$numL1, "Ventas Internas Afectas en Alicuota Reducida");
			$sheet->mergeCells($letra21L1.$numL1.':'.$letra22L1.($numL1))->setCellValue($letra21L1.$numL1, 0);
			$sheet->mergeCells($letra31L1.$numL1.':'.$letra32L1.($numL1))->setCellValue($letra31L1.$numL1, 0);
			$sheet->mergeCells($letra41L1.$numL1.':'.$letra42L1.($numL1))->setCellValue($letra41L1.$numL1, 0);
			$vtotalDBaseImponible.="+".$letra21L1.$numL1;
			$vtotalDDebitoFiscal.="+".$letra31L1.$numL1;
			$vtotalDRetencion.="+".$letra41L1.$numL1;

			$sheet->getStyle($letra11L1.$numInicialL1.':'.$letra12L1.($numL1))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle($letra21L1.$numInicialL1.':'.$letra22L1.($numL1))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle($letra31L1.$numInicialL1.':'.$letra32L1.($numL1))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle($letra41L1.$numInicialL1.':'.$letra42L1.($numL1))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));

			$numL1++;
			$sheet->getStyle($letra11L1.$numL1.':'.$letra42L1.$numL1)->getFont()->setBold(true)->setSize(13);
			$sheet->getStyle($letra11L1.$numL1.':'.$letra12L1.$numL1)->getAlignment()->setHorizontal('center');
			$sheet->getStyle($letra11L1.$numL1.':'.$letra42L1.($numL1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle($letra21L1.$numL1.':'.$letra42L1.$numL1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

			$sheet->getStyle($letra11L1.$numL1.':'.$letra12L1.$numL1)->getAlignment()->setHorizontal('left');
			$sheet->mergeCells($letra11L1.$numL1.':'.$letra12L1.($numL1))->setCellValue($letra11L1.$numL1, "Total Ventas y Débitos Fiscales");

			$sheet->getStyle($letra21L1.$numL1.':'.$letra42L1.$numL1)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra21L1.$numL1.':'.$letra22L1.$numL1)->setCellValue($letra21L1.$numL1, $vtotalDBaseImponible);
			$sheet->mergeCells($letra31L1.$numL1.':'.$letra32L1.$numL1)->setCellValue($letra31L1.$numL1, $vtotalDDebitoFiscal);
			$sheet->mergeCells($letra41L1.$numL1.':'.$letra42L1.$numL1)->setCellValue($letra41L1.$numL1, $vtotalDRetencion);
		// CUADRO RESUMEN DE DEBITO  LIBRO 1


		$spreadsheet->createSheet(1);
		$spreadsheet->setActiveSheetIndex(1);
		$spreadsheet->getActiveSheet()->setTitle($nameLibro2);
		$sheet = $spreadsheet->getActiveSheet();
		$letra11L1 = "G"; //B=H
		// CABECERA PRINCIPAL  LIBRO 2
			$sheet->getColumnDimension('A')->setAutoSize(true);
			$sheet->getColumnDimension('B')->setAutoSize(true);
			$sheet->getColumnDimension('C')->setAutoSize(true);
			$sheet->getColumnDimension('D')->setAutoSize(true);
			$sheet->getColumnDimension('E')->setAutoSize(true);
			$sheet->getColumnDimension('F')->setAutoSize(true);
			$sheet->getColumnDimension('G')->setAutoSize(true);
			$sheet->getColumnDimension('H')->setAutoSize(true);
			$sheet->getColumnDimension('I')->setAutoSize(true);
			$sheet->getColumnDimension('J')->setAutoSize(true);
			$sheet->getColumnDimension('K')->setAutoSize(true);
			$sheet->getColumnDimension('L')->setAutoSize(true);
			$sheet->getColumnDimension('M')->setAutoSize(true);
			$sheet->getColumnDimension('N')->setAutoSize(true);
			$sheet->getColumnDimension('O')->setAutoSize(true);
			$sheet->getColumnDimension('P')->setAutoSize(true);
			$sheet->getColumnDimension('Q')->setAutoSize(true);
			$sheet->getColumnDimension('R')->setAutoSize(true);
			$sheet->getColumnDimension('S')->setAutoSize(true);
			$sheet->getColumnDimension('T')->setAutoSize(true);
			$sheet->getStyle('A1:Z1000')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');

			$num2L2 = 1;
			$numL2 = 1;
			$numL2++;
			// $sheet->getStyle('B'.$numL2.':E'.$numL2)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
			$sheet->getStyle('B'.$numL2.':E'.$numL2)->getFont()->setBold(true)->setSize(18);
			$sheet->mergeCells('B'.$numL2.':E'.$numL2)->setCellValue('B'.$numL2, 'INVERSIONES STYLE COLLECTION, C.A.');

			$numL2++;
			$sheet->getStyle('B'.$numL2.':E'.$numL2)->getFont()->setBold(true)->setSize(18);
			$sheet->mergeCells('B'.$numL2.':E'.$numL2)->setCellValue('B'.$numL2, 'RIF: J-408497786');

			$numL2++;
			$sheet->getStyle('B'.$numL2.':F'.$numL2)->getFont()->setBold(true)->setSize(18)->getUnderline(true);
			$sheet->mergeCells('B'.$numL2.':F'.$numL2)->setCellValue('B'.$numL2, 'LIBRO DE COMPRAS DEL '.str_replace("-","/",$lider->formatFecha($inicioFecha)).' HASTA EL '.str_replace("-","/",$lider->formatFecha($finFecha)));

			$numL2++;
			$numL2++;
		// CABECERA PRINCIPAL  LIBRO 2

		// CUADRO PRINCIPAL - TITULO  LIBRO 2
			$numL2++;
			$sheet->getStyle('B'.$numL2.':S'.$numL2)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL2.':S'.$numL2)->getAlignment()->setHorizontal('center')->setWrapText(true);
			$sheet->getStyle('B'.$numL2.':S'.$numL2)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
			$sheet->getStyle('B'.$numL2.':S'.$numL2)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL2, "Oper. \nNro.");
			$sheet->setCellValue('C'.$numL2, "Fecha \nFactura \n/NC/ND/");
			$sheet->setCellValue('D'.$numL2, "Nro.  R.I.F");
			$sheet->setCellValue('E'.$numL2, "Nombre o Razón Social del Cliente");
			$sheet->setCellValue('F'.$numL2, "Número de \nFactura");
			$sheet->setCellValue('G'.$numL2, "Número de \nControl");
			$sheet->setCellValue('H'.$numL2, "Tipo de \nTransacción");
			$sheet->setCellValue('I'.$numL2, "Número \nNota \nDébito");
			$sheet->setCellValue('J'.$numL2, "Número \nNota \nCrédito");
			$sheet->setCellValue('K'.$numL2, "Número \nde \nFactura \nAfectada");

			$sheet->setCellValue('L'.$numL2, "Total Compras\nde Bienes y\nServicios\nIncluyendo \nIVA");
			$sheet->setCellValue('M'.$numL2, "Compras \n Exentas \n Exoneradas o \n No Sujetas");
			$sheet->setCellValue('N'.$numL2, "Compras \nInternas \nGravadas");
			$sheet->setCellValue('O'.$numL2, "% "."Alicuota");
			$sheet->setCellValue('P'.$numL2, "IVA\nAlicuota\nGeneral");
			$sheet->setCellValue('Q'.$numL2, "RET. IVA\nAlicuota\nGeneral");
			$sheet->setCellValue('R'.$numL2, "Número de \nComprobante de\n (Ret. IVA)");
			$sheet->setCellValue('S'.$numL2, "Fecha del \n Comprobante \nde\n Retención");
		// CUADRO PRINCIPAL - TITULO  LIBRO 2

		// CUADRO PRINCIPAL - CONTENIDO  LIBRO 2
			$totalCompra=0;
			$compraExentas=0;
			$comprasInternasGravadas=0;
			$ivaGeneral=0;
			$retencionIVaCompras=0;
			// $totalTotalCompra = 0;
			// $totalCompraExentas=0;
			// $totalComprasInternasGravadas = 0;
			// $totalIvaGeneral = 0;
			// $totalRetencionIVa=0;
			$totalTotalCompra= "=0";
			$totalCompraExentas = "=0";
			$totalComprasInternasGravadas = "=0";
			$totalIvaGeneral="=0";
			$totalRetencionIVa="=0";
			$indx=1;
			$numL2++;
			$numInicialL2=$numL2;
			if(count($compras)>1){ foreach ($compras as $compra){ if(!empty($compra['id_factura_compra'])){
				$opRetencion = $compra['opRetencion'];
				$retencionIVaCompras=0;
				$totalCompra = $compra['totalCompra'];
				$compraExentas = $compra['comprasExentas'];
				// $comprasInternasGravadas = $compra['comprasInternasGravadas'];
				if($totalCompra==0){
					$totalCompra=$compraExentas;
				}
				$comprasInternasGravadas = "=(L".$numL2."-M".$numL2.")/".(($cantidadIVA/100)+1);
				// $precioIVA = $cantidadIVA;
				$precioIVA = $compra['iva'];
				// $ivaGeneral = "=N".$numL2."*O".$numL2;
				$ivaGeneral = "=N".$numL2."*".($cantidadIVA/100);

				if($opRetencion==1){
					$porcentReten=$compra['porcentajeRetencion'];
					// $retencionIVaCompras=$compra['retencionIva'];
					$retencionIVaCompras="=P".$numL2."*".($porcentReten/100);
				}

				// $cuotaSinIVA = $fiscal['totalVenta'];
				// $precioIVA="=O".$numL2."/100*".$cantidadIVA;
				// $cuotaConIVA = "=O".$numL2."+Q".$numL2;
				// $coutasExentasIva=0;
				// $autoConsumo=0;
				// $retencionIVaCompras=0;
				$totalTotalCompra.="+L".$numL2;
				$totalCompraExentas.="+M".$numL2;
				$totalComprasInternasGravadas.="+N".$numL2;
				$totalIvaGeneral.="+P".$numL2;
				$totalRetencionIVa.="+Q".$numL2;


				
				$sheet->getStyle('B'.$numL2.':S'.$numL2)->getFont()->setSize(12);
				$sheet->getStyle('B'.$numL2.':S'.$numL2)->getAlignment()->setHorizontal('center');
				$sheet->getStyle('E'.$numL2)->getAlignment()->setHorizontal('left');
				// $sheet->getStyle('G'.$numL2)->getAlignment()->setHorizontal('right');
				$sheet->getStyle('L'.$numL2.':R'.$numL2)->getAlignment()->setHorizontal('right');
				$sheet->getStyle('L'.$numL2.':N'.$numL2)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$sheet->getStyle('O'.$numL2)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
				$sheet->getStyle('P'.$numL2.':Q'.$numL2)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);


				$sheet->setCellValue('B'.$numL2, $indx);
				$sheet->setCellValue('C'.$numL2, str_replace("-","/",$lider->formatFecha($compra['fechaFactura'])) );
				$sheet->setCellValue('D'.$numL2, $compra['codRif'].$compra['rif']);
				$sheet->setCellValue('E'.$numL2, mb_strtoupper($compra['nombreProveedor']));
				// else{ $sheet->setCellValue('E'.$numL2, "***ANULADO***"); }
				$sheet->setCellValue('F'.$numL2, $compra['numeroFactura']);
				$sheet->setCellValue('G'.$numL2, $compra['numeroControl']);
				$sheet->setCellValue('H'.$numL2, "01");
				$sheet->setCellValue('I'.$numL2, "");
				$sheet->setCellValue('J'.$numL2, "");
				$sheet->setCellValue('K'.$numL2, "");

				$sheet->setCellValue('L'.$numL2, $totalCompra);
				$sheet->setCellValue('M'.$numL2, $compraExentas);
				$sheet->setCellValue('N'.$numL2, $comprasInternasGravadas);
				$sheet->setCellValue('O'.$numL2, $precioIVA."%");
				$sheet->setCellValue('P'.$numL2, $ivaGeneral);
				$sheet->setCellValue('Q'.$numL2, $retencionIVaCompras);
				if($opRetencion==1){ $sheet->setCellValue('R'.$numL2, $compra['comprobante']); } else { $sheet->setCellValue('R'.$numL2, ""); }
				if($opRetencion==1){ $sheet->setCellValue('S'.$numL2, $compra['fechaComprobante']); } else { $sheet->setCellValue('R'.$numL2, ""); }


				$indx++;
				$numL2++;

			} } } else{

				$sheet->getStyle('B'.$numL2.':S'.$numL2)->getFont()->setSize(12);
				$sheet->getStyle('B'.$numL2.':S'.$numL2)->getAlignment()->setHorizontal('center');
				$sheet->getStyle('E'.$numL2)->getAlignment()->setHorizontal('left');
				// $sheet->getStyle('G'.$numL2)->getAlignment()->setHorizontal('right');
				$sheet->getStyle('L'.$numL2.':N'.$numL2)->getAlignment()->setHorizontal('right');
				$sheet->getStyle('P'.$numL2.':Q'.$numL2)->getAlignment()->setHorizontal('right');
				$sheet->getStyle('R'.$numL2.':S'.$numL2)->getAlignment()->setHorizontal('center');

				$sheet->setCellValue('B'.$numL2, $indx);
				$sheet->setCellValue('C'.$numL2, "");
				$sheet->setCellValue('D'.$numL2, ""); 
				$sheet->setCellValue('E'.$numL2, "***NO HUBO COMPRAS***");
				$sheet->setCellValue('F'.$numL2, "");
				$sheet->setCellValue('G'.$numL2, "");
				$sheet->setCellValue('H'.$numL2, "");
				$sheet->setCellValue('I'.$numL2, "");
				$sheet->setCellValue('J'.$numL2, "");
				$sheet->setCellValue('K'.$numL2, "");

				$sheet->setCellValue('L'.$numL2, $totalCompra);
				$sheet->setCellValue('M'.$numL2, $compraExentas);
				$sheet->setCellValue('N'.$numL2, $comprasInternasGravadas);
				$sheet->setCellValue('O'.$numL2, $precioIVA."%");
				$sheet->setCellValue('P'.$numL2, $ivaGeneral);
				$sheet->setCellValue('Q'.$numL2, $retencionIVaCompras);
				$sheet->setCellValue('R'.$numL2, "");
				$sheet->setCellValue('S'.$numL2, "");
				$indx++;
				$numL2++;
			}
			$sheet->getStyle('B'.$numInicialL2.':S'.($numL2-1))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
		// CUADRO PRINCIPAL - CONTENIDO  LIBRO 2

		// CUADRO PRINCIPAL - TOTALIZADOR  LIBRO 2
			$sheet->getStyle('B'.$numInicialL2.':S'.($numL2))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle('B'.$numL2.':K'.$numL2)->getFont()->setBold(true)->setSize(14);
			$sheet->getStyle('L'.$numL2.':S'.$numL2)->getFont()->setBold(true)->setSize(13);
			$sheet->getStyle('B'.$numL2.':K'.$numL2)->getAlignment()->setHorizontal('center');
			$sheet->mergeCells('B'.$numL2.':K'.$numL2)->setCellValue('B'.$numL2, mb_strtoupper("TOTALES"));
			$sheet->getStyle('L'.$numL2.':S'.$numL2)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('L'.$numL2.':N'.$numL2)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('O'.$numL2)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
			$sheet->getStyle('P'.$numL2.':Q'.$numL2)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->setCellValue('L'.$numL2, $totalTotalCompra);
			$sheet->setCellValue('M'.$numL2, $totalCompraExentas);
			$sheet->setCellValue('N'.$numL2, $totalComprasInternasGravadas);
			$sheet->setCellValue('O'.$numL2, "");
			$sheet->setCellValue('P'.$numL2, $totalIvaGeneral);
			$sheet->setCellValue('Q'.$numL2, $totalRetencionIVa);
			$sheet->setCellValue('R'.$numL2, "");
			$sheet->setCellValue('S'.$numL2, "");
			
			$sheet->getStyle('S'.$numL2)->getAlignment()->setHorizontal('center');
			// $vAlicuotaGeneralDBaseImponible="=O".$numL2;
			// $vAlicuotaGeneralDDebitoFiscal="=Q".$numL2;
			$numTotalizadorL2 = $numL2;
			$numL2++;
		// CUADRO PRINCIPAL - TOTALIZADOR  LIBRO 2

		// CUADRO RESUMEN DE CREDITO  LIBRO 2
			$cComprasNoGravadasCBaseImponible="=M".$numTotalizadorL2;
			$cAlicuotaGeneralCBaseImponible="=N".$numTotalizadorL2;
			$cAlicuotaGeneralCCreditoFiscal="=P".$numTotalizadorL2;
			$cAlicuotaGeneralCRetencion="=Q".$numTotalizadorL2;
			$ctotalCBaseImponible = "=0";
			$ctotalCCreditoFiscal = "=0";
			$ctotalCRetencionesIVA="=0";
			$numL2++;
			$sheet->getStyle($letra11L1.$numL2.':'.$letra42L1.$numL2)->getFont()->setSize(13);
			$sheet->getStyle($letra11L1.$numL2.':'.$letra42L1.$numL2)->getAlignment()->setHorizontal('center');
			if(isset($_GET['mes'])){ $msjTemp = "Mes"; }else{ $msjTemp = "Año"; }
			$sheet->mergeCells($letra11L1.$numL2.':'.$letra12L1.($numL2))->setCellValue($letra11L1.$numL2, "Resumen del {$msjTemp} Base Imponible y Créditos Fiscales");
			$sheet->getStyle($letra11L1.$numL2.':'.$letra12L1.($numL2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->mergeCells($letra21L1.$numL2.':'.$letra22L1.($numL2))->setCellValue($letra21L1.$numL2, "Base Imponible");
			$sheet->getStyle($letra21L1.$numL2.':'.$letra22L1.($numL2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->mergeCells($letra31L1.$numL2.':'.$letra32L1.($numL2))->setCellValue($letra31L1.$numL2, "Crédito Fiscal");
			$sheet->getStyle($letra31L1.$numL2.':'.$letra32L1.($numL2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->mergeCells($letra41L1.$numL2.':'.$letra42L1.($numL2))->setCellValue($letra41L1.$numL2, "Retenciones de IVA");
			$sheet->getStyle($letra41L1.$numL2.':'.$letra42L1.($numL2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));

			$numL2++;
			$numInicialL2=$numL2;


			$sheet->getStyle($letra11L1.$numL2.':'.$letra42L1.$numL2)->getFont()->setSize(12);
			$sheet->getStyle($letra21L1.$numL2.':'.$letra42L1.$numL2)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle($letra11L1.$numL2.':'.$letra12L1.$numL2)->getAlignment()->setHorizontal('left');
			$sheet->getStyle($letra21L1.$numL2.':'.$letra42L1.$numL2)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra11L1.$numL2.':'.$letra12L1.($numL2))->setCellValue($letra11L1.$numL2, "Total: Compras no gravadas y/o sin derecho a crédito fiscal");
			$sheet->mergeCells($letra21L1.$numL2.':'.$letra22L1.($numL2))->setCellValue($letra21L1.$numL2, $cComprasNoGravadasCBaseImponible);
			$sheet->mergeCells($letra31L1.$numL2.':'.$letra32L1.($numL2))->setCellValue($letra31L1.$numL2, 0);
			$sheet->mergeCells($letra41L1.$numL2.':'.$letra42L1.($numL2))->setCellValue($letra41L1.$numL2, 0);
			$ctotalCBaseImponible.="+".$letra21L1.$numL2;
			$ctotalCCreditoFiscal.="+".$letra31L1.$numL2;
			$ctotalCRetencionesIVA.="+".$letra41L1.$numL2;



			$numL2++;
			$sheet->getStyle($letra11L1.$numL2.':'.$letra42L1.$numL2)->getFont()->setSize(12);
			$sheet->getStyle($letra21L1.$numL2.':'.$letra42L1.$numL2)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle($letra11L1.$numL2.':'.$letra12L1.$numL2)->getAlignment()->setHorizontal('left');
			$sheet->getStyle($letra21L1.$numL2.':'.$letra22L1.$numL2)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra11L1.$numL2.':'.$letra12L1.($numL2))->setCellValue($letra11L1.$numL2, "Σ de las: Compras Internas gravadas sólo por Alícuota General");
			$sheet->mergeCells($letra21L1.$numL2.':'.$letra22L1.($numL2))->setCellValue($letra21L1.$numL2, $cAlicuotaGeneralCBaseImponible);
			$sheet->mergeCells($letra31L1.$numL2.':'.$letra32L1.($numL2))->setCellValue($letra31L1.$numL2, $cAlicuotaGeneralCCreditoFiscal);
			$sheet->mergeCells($letra41L1.$numL2.':'.$letra42L1.($numL2))->setCellValue($letra41L1.$numL2, $cAlicuotaGeneralCRetencion);
			$ctotalCBaseImponible.="+".$letra21L1.$numL2;
			$ctotalCCreditoFiscal.="+".$letra31L1.$numL2;
			$ctotalCRetencionesIVA.="+".$letra41L1.$numL2;

			$numL2++;
			$sheet->getStyle($letra11L1.$numL2.':'.$letra42L1.$numL2)->getFont()->setSize(12);
			$sheet->getStyle($letra21L1.$numL2.':'.$letra42L1.$numL2)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle($letra11L1.$numL2.':'.$letra12L1.$numL2)->getAlignment()->setHorizontal('left');
			$sheet->getStyle($letra21L1.$numL2.':'.$letra22L1.$numL2)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra11L1.$numL2.':'.$letra12L1.($numL2))->setCellValue($letra11L1.$numL2, "Σ de las: Compras Internas gravadas por Alícuota General + Adicional");
			$sheet->mergeCells($letra21L1.$numL2.':'.$letra22L1.($numL2))->setCellValue($letra21L1.$numL2, 0);
			$sheet->mergeCells($letra31L1.$numL2.':'.$letra32L1.($numL2))->setCellValue($letra31L1.$numL2, 0);
			$sheet->mergeCells($letra41L1.$numL2.':'.$letra42L1.($numL2))->setCellValue($letra41L1.$numL2, 0);
			$ctotalCBaseImponible.="+".$letra21L1.$numL2;
			$ctotalCCreditoFiscal.="+".$letra31L1.$numL2;
			$ctotalCRetencionesIVA.="+".$letra41L1.$numL2;

			$numL2++;
			$sheet->getStyle($letra11L1.$numL2.':'.$letra42L1.$numL2)->getFont()->setSize(12);
			$sheet->getStyle($letra21L1.$numL2.':'.$letra42L1.$numL2)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle($letra11L1.$numL2.':'.$letra12L1.$numL2)->getAlignment()->setHorizontal('left');
			$sheet->getStyle($letra21L1.$numL2.':'.$letra22L1.$numL2)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra11L1.$numL2.':'.$letra12L1.($numL2))->setCellValue($letra11L1.$numL2, "Σ de las: Compras Internas gravadas por Alícuota Reducida");
			$sheet->mergeCells($letra21L1.$numL2.':'.$letra22L1.($numL2))->setCellValue($letra21L1.$numL2, 0);
			$sheet->mergeCells($letra31L1.$numL2.':'.$letra32L1.($numL2))->setCellValue($letra31L1.$numL2, 0);
			$sheet->mergeCells($letra41L1.$numL2.':'.$letra42L1.($numL2))->setCellValue($letra41L1.$numL2, 0);
			$ctotalCBaseImponible.="+".$letra21L1.$numL2;
			$ctotalCCreditoFiscal.="+".$letra31L1.$numL2;
			$ctotalCRetencionesIVA.="+".$letra41L1.$numL2;


			$sheet->getStyle($letra11L1.$numInicialL2.':'.$letra12L1.($numL2))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle($letra21L1.$numInicialL2.':'.$letra22L1.($numL2))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle($letra31L1.$numInicialL2.':'.$letra32L1.($numL2))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle($letra41L1.$numInicialL2.':'.$letra42L1.($numL2))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));

			$numL2++;
			$sheet->getStyle($letra11L1.$numL2.':'.$letra42L1.$numL2)->getFont()->setBold(true)->setSize(13);
			$sheet->getStyle($letra11L1.$numL2.':'.$letra12L1.$numL2)->getAlignment()->setHorizontal('center');
			$sheet->getStyle($letra11L1.$numL2.':'.$letra42L1.($numL2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle($letra21L1.$numL2.':'.$letra42L1.$numL2)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

			$sheet->getStyle($letra11L1.$numL2.':'.$letra12L1.$numL2)->getAlignment()->setHorizontal('left');
			$sheet->mergeCells($letra11L1.$numL2.':'.$letra12L1.($numL2))->setCellValue($letra11L1.$numL2, "Total Compras y Créditos Fiscales del Período");

			$sheet->getStyle($letra21L1.$numL2.':'.$letra42L1.$numL2)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra21L1.$numL2.':'.$letra22L1.$numL2)->setCellValue($letra21L1.$numL2, $ctotalCBaseImponible);
			$sheet->mergeCells($letra31L1.$numL2.':'.$letra32L1.$numL2)->setCellValue($letra31L1.$numL2, $ctotalCCreditoFiscal);
			$sheet->mergeCells($letra41L1.$numL2.':'.$letra42L1.$numL2)->setCellValue($letra41L1.$numL2, $ctotalCRetencionesIVA);
		// CUADRO RESUMEN DE CREDITO  LIBRO 2

		// CUADRO RESUMEN DE DEBITO  LIBRO 2
			$cAlicuotaGeneralDBaseImponible="='".$nameLibro1."'!O".$numTotalizadorL1;
			$cAlicuotaGeneralDDebitoFiscal="='".$nameLibro1."'!Q".$numTotalizadorL1;
			$numL2++;
			$numL2++;
			$sheet->getStyle($letra11L1.$numL2.':'.$letra42L1.$numL2)->getFont()->setSize(13);
			$sheet->getStyle($letra11L1.$numL2.':'.$letra42L1.$numL2)->getAlignment()->setHorizontal('center');
			if(isset($_GET['mes'])){ $msjTemp = "Mes"; }else{ $msjTemp = "Año"; }
			$sheet->mergeCells($letra11L1.$numL2.':'.$letra12L1.($numL2))->setCellValue($letra11L1.$numL2, "Resumen del {$msjTemp} Base Imponible y Débitos Fiscales");
			$sheet->getStyle($letra11L1.$numL2.':'.$letra12L1.($numL2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->mergeCells($letra21L1.$numL2.':'.$letra22L1.($numL2))->setCellValue($letra21L1.$numL2, "Base Imponible");
			$sheet->getStyle($letra21L1.$numL2.':'.$letra22L1.($numL2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->mergeCells($letra31L1.$numL2.':'.$letra32L1.($numL2))->setCellValue($letra31L1.$numL2, "Débito Fiscal");
			$sheet->getStyle($letra31L1.$numL2.':'.$letra32L1.($numL2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->mergeCells($letra41L1.$numL2.':'.$letra42L1.($numL2))->setCellValue($letra41L1.$numL2, "Retenciones de IVA");
			$sheet->getStyle($letra41L1.$numL2.':'.$letra42L1.($numL2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));

			$numL2++;
			$numInicialL1=$numL2;
			$ctotalDBaseImponible="=0";
			$ctotalDDebitoFiscal="=0";
			$ctotalDRetencion="=0";
			$sheet->getStyle($letra11L1.$numL2.':'.$letra42L1.$numL2)->getFont()->setSize(12);
			$sheet->getStyle($letra21L1.$numL2.':'.$letra42L1.$numL2)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle($letra11L1.$numL2.':'.$letra12L1.$numL2)->getAlignment()->setHorizontal('left');
			$sheet->getStyle($letra21L1.$numL2.':'.$letra42L1.$numL2)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra11L1.$numL2.':'.$letra12L1.($numL2))->setCellValue($letra11L1.$numL2, "Ventas Internas No Gravadas");
			$sheet->mergeCells($letra21L1.$numL2.':'.$letra22L1.($numL2))->setCellValue($letra21L1.$numL2, 0);
			$sheet->mergeCells($letra31L1.$numL2.':'.$letra32L1.($numL2))->setCellValue($letra31L1.$numL2, 0);
			$sheet->mergeCells($letra41L1.$numL2.':'.$letra42L1.($numL2))->setCellValue($letra41L1.$numL2, 0);
			$ctotalDBaseImponible.="+".$letra21L1.$numL2;
			$ctotalDDebitoFiscal.="+".$letra31L1.$numL2;
			$ctotalDRetencion.="+".$letra41L1.$numL2;


			$numL2++;
			$sheet->getStyle($letra11L1.$numL2.':'.$letra42L1.$numL2)->getFont()->setSize(12);
			$sheet->getStyle($letra21L1.$numL2.':'.$letra42L1.$numL2)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle($letra11L1.$numL2.':'.$letra12L1.$numL2)->getAlignment()->setHorizontal('left');
			$sheet->getStyle($letra21L1.$numL2.':'.$letra42L1.$numL2)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra11L1.$numL2.':'.$letra12L1.($numL2))->setCellValue($letra11L1.$numL2, "Ventas Internas Afectas solo Alicuota General");
			$sheet->mergeCells($letra21L1.$numL2.':'.$letra22L1.($numL2))->setCellValue($letra21L1.$numL2, $cAlicuotaGeneralDBaseImponible);
			$sheet->mergeCells($letra31L1.$numL2.':'.$letra32L1.($numL2))->setCellValue($letra31L1.$numL2, $cAlicuotaGeneralDDebitoFiscal);
			$sheet->mergeCells($letra41L1.$numL2.':'.$letra42L1.($numL2))->setCellValue($letra41L1.$numL2, 0);
			$ctotalDBaseImponible.="+".$letra21L1.$numL2;
			$ctotalDDebitoFiscal.="+".$letra31L1.$numL2;
			$ctotalDRetencion.="+".$letra41L1.$numL2;

			$numL2++;
			$sheet->getStyle($letra11L1.$numL2.':'.$letra42L1.$numL2)->getFont()->setSize(12);
			$sheet->getStyle($letra21L1.$numL2.':'.$letra42L1.$numL2)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle($letra11L1.$numL2.':'.$letra12L1.$numL2)->getAlignment()->setHorizontal('left');
			$sheet->getStyle($letra21L1.$numL2.':'.$letra42L1.$numL2)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra11L1.$numL2.':'.$letra12L1.($numL2))->setCellValue($letra11L1.$numL2, "Ventas Internas Afectas Alicuota General + Adicional");
			$sheet->mergeCells($letra21L1.$numL2.':'.$letra22L1.($numL2))->setCellValue($letra21L1.$numL2, 0);
			$sheet->mergeCells($letra31L1.$numL2.':'.$letra32L1.($numL2))->setCellValue($letra31L1.$numL2, 0);
			$sheet->mergeCells($letra41L1.$numL2.':'.$letra42L1.($numL2))->setCellValue($letra41L1.$numL2, 0);
			$ctotalDBaseImponible.="+".$letra21L1.$numL2;
			$ctotalDDebitoFiscal.="+".$letra31L1.$numL2;
			$ctotalDRetencion.="+".$letra41L1.$numL2;

			$numL2++;
			$sheet->getStyle($letra11L1.$numL2.':'.$letra42L1.$numL2)->getFont()->setSize(12);
			$sheet->getStyle($letra21L1.$numL2.':'.$letra22L1.$numL2)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle($letra11L1.$numL2.':'.$letra12L1.$numL2)->getAlignment()->setHorizontal('left');
			$sheet->getStyle($letra21L1.$numL2.':'.$letra22L1.$numL2)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra11L1.$numL2.':'.$letra12L1.($numL2))->setCellValue($letra11L1.$numL2, "Ventas Internas Afectas en Alicuota Reducida");
			$sheet->mergeCells($letra21L1.$numL2.':'.$letra22L1.($numL2))->setCellValue($letra21L1.$numL2, 0);
			$sheet->mergeCells($letra31L1.$numL2.':'.$letra32L1.($numL2))->setCellValue($letra31L1.$numL2, 0);
			$sheet->mergeCells($letra41L1.$numL2.':'.$letra42L1.($numL2))->setCellValue($letra41L1.$numL2, 0);
			$ctotalDBaseImponible.="+".$letra21L1.$numL2;
			$ctotalDDebitoFiscal.="+".$letra31L1.$numL2;
			$ctotalDRetencion.="+".$letra41L1.$numL2;

			$sheet->getStyle($letra11L1.$numInicialL1.':'.$letra12L1.($numL2))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle($letra21L1.$numInicialL1.':'.$letra22L1.($numL2))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle($letra31L1.$numInicialL1.':'.$letra32L1.($numL2))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle($letra41L1.$numInicialL1.':'.$letra42L1.($numL2))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));

			$numL2++;
			$sheet->getStyle($letra11L1.$numL2.':'.$letra42L1.$numL2)->getFont()->setBold(true)->setSize(13);
			$sheet->getStyle($letra11L1.$numL2.':'.$letra12L1.$numL2)->getAlignment()->setHorizontal('center');
			$sheet->getStyle($letra11L1.$numL2.':'.$letra42L1.($numL2))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle($letra21L1.$numL2.':'.$letra42L1.$numL2)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

			$sheet->getStyle($letra11L1.$numL2.':'.$letra12L1.$numL2)->getAlignment()->setHorizontal('left');
			$sheet->mergeCells($letra11L1.$numL2.':'.$letra12L1.($numL2))->setCellValue($letra11L1.$numL2, "Total Ventas y Débitos Fiscales");

			$sheet->getStyle($letra21L1.$numL2.':'.$letra42L1.$numL2)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra21L1.$numL2.':'.$letra22L1.$numL2)->setCellValue($letra21L1.$numL2, $ctotalDBaseImponible);
			$sheet->mergeCells($letra31L1.$numL2.':'.$letra32L1.$numL2)->setCellValue($letra31L1.$numL2, $ctotalDDebitoFiscal);
			$sheet->mergeCells($letra41L1.$numL2.':'.$letra42L1.$numL2)->setCellValue($letra41L1.$numL2, $ctotalDRetencion);
		// CUADRO RESUMEN DE DEBITO  LIBRO 2


		$spreadsheet->setActiveSheetIndex(0);
		$spreadsheet->getActiveSheet();
		$sheet = $spreadsheet->getActiveSheet();
		$letra11L1 = "H"; //B=H
		// CUADRO RESUMEN DE CREDITO  LIBRO 1
			$vComprasNoGravadasCBaseImponible="='".$nameLibro2."'!M".$numTotalizadorL2;
			$vAlicuotaGeneralCBaseImponible="='".$nameLibro2."'!N".$numTotalizadorL2;
			$vAlicuotaGeneralCCreditoFiscal="='".$nameLibro2."'!P".$numTotalizadorL2;
			$vAlicuotaGeneralCRetencion="='".$nameLibro2."'!Q".$numTotalizadorL2;
			$vtotalCBaseImponible = "=0";
			$vtotalCCreditoFiscal = "=0";
			$vtotalCRetencionesIVA="=0";
			$numL1++;
			$numL1++;
			$sheet->getStyle($letra11L1.$numL1.':'.$letra42L1.$numL1)->getFont()->setSize(13);
			$sheet->getStyle($letra11L1.$numL1.':'.$letra42L1.$numL1)->getAlignment()->setHorizontal('center');
			if(isset($_GET['mes'])){ $msjTemp = "Mes"; }else{ $msjTemp = "Año"; }
			$sheet->mergeCells($letra11L1.$numL1.':'.$letra12L1.($numL1))->setCellValue($letra11L1.$numL1, "Resumen del {$msjTemp} Base Imponible y Créditos Fiscales");
			$sheet->getStyle($letra11L1.$numL1.':'.$letra12L1.($numL1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->mergeCells($letra21L1.$numL1.':'.$letra22L1.($numL1))->setCellValue($letra21L1.$numL1, "Base Imponible");
			$sheet->getStyle($letra21L1.$numL1.':'.$letra22L1.($numL1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->mergeCells($letra31L1.$numL1.':'.$letra32L1.($numL1))->setCellValue($letra31L1.$numL1, "Crédito Fiscal");
			$sheet->getStyle($letra31L1.$numL1.':'.$letra32L1.($numL1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->mergeCells($letra41L1.$numL1.':'.$letra42L1.($numL1))->setCellValue($letra41L1.$numL1, "Retenciones de IVA");
			$sheet->getStyle($letra41L1.$numL1.':'.$letra42L1.($numL1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));

			$numL1++;
			$numInicialL2=$numL1;


			$sheet->getStyle($letra11L1.$numL1.':'.$letra42L1.$numL1)->getFont()->setSize(12);
			$sheet->getStyle($letra21L1.$numL1.':'.$letra42L1.$numL1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle($letra11L1.$numL1.':'.$letra12L1.$numL1)->getAlignment()->setHorizontal('left');
			$sheet->getStyle($letra21L1.$numL1.':'.$letra41L1.$numL1)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra11L1.$numL1.':'.$letra12L1.($numL1))->setCellValue($letra11L1.$numL1, "Total: Compras no gravadas y/o sin derecho a crédito fiscal");
			$sheet->mergeCells($letra21L1.$numL1.':'.$letra22L1.($numL1))->setCellValue($letra21L1.$numL1, $vComprasNoGravadasCBaseImponible);
			$sheet->mergeCells($letra31L1.$numL1.':'.$letra32L1.($numL1))->setCellValue($letra31L1.$numL1, 0);
			$sheet->mergeCells($letra41L1.$numL1.':'.$letra42L1.($numL1))->setCellValue($letra41L1.$numL1, 0);
			$vtotalCBaseImponible.="+".$letra21L1.$numL1;
			$vtotalCCreditoFiscal.="+".$letra31L1.$numL1;
			$vtotalCRetencionesIVA.="+".$letra41L1.$numL1;



			$numL1++;
			$sheet->getStyle($letra11L1.$numL1.':'.$letra42L1.$numL1)->getFont()->setSize(12);
			$sheet->getStyle($letra21L1.$numL1.':'.$letra42L1.$numL1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle($letra11L1.$numL1.':'.$letra12L1.$numL1)->getAlignment()->setHorizontal('left');
			$sheet->getStyle($letra21L1.$numL1.':'.$letra22L1.$numL1)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra11L1.$numL1.':'.$letra12L1.($numL1))->setCellValue($letra11L1.$numL1, "Σ de las: Compras Internas gravadas sólo por Alícuota General");
			$sheet->mergeCells($letra21L1.$numL1.':'.$letra22L1.($numL1))->setCellValue($letra21L1.$numL1, $vAlicuotaGeneralCBaseImponible);
			$sheet->mergeCells($letra31L1.$numL1.':'.$letra32L1.($numL1))->setCellValue($letra31L1.$numL1, $vAlicuotaGeneralCCreditoFiscal);
			$sheet->mergeCells($letra41L1.$numL1.':'.$letra42L1.($numL1))->setCellValue($letra41L1.$numL1, $vAlicuotaGeneralCRetencion);
			$vtotalCBaseImponible.="+".$letra21L1.$numL1;
			$vtotalCCreditoFiscal.="+".$letra31L1.$numL1;
			$vtotalCRetencionesIVA.="+".$letra41L1.$numL1;

			$numL1++;
			$sheet->getStyle($letra11L1.$numL1.':'.$letra42L1.$numL1)->getFont()->setSize(12);
			$sheet->getStyle($letra21L1.$numL1.':'.$letra42L1.$numL1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle($letra11L1.$numL1.':'.$letra12L1.$numL1)->getAlignment()->setHorizontal('left');
			$sheet->getStyle($letra21L1.$numL1.':'.$letra22L1.$numL1)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra11L1.$numL1.':'.$letra12L1.($numL1))->setCellValue($letra11L1.$numL1, "Σ de las: Compras Internas gravadas por Alícuota General + Adicional");
			$sheet->mergeCells($letra21L1.$numL1.':'.$letra22L1.($numL1))->setCellValue($letra21L1.$numL1, 0);
			$sheet->mergeCells($letra31L1.$numL1.':'.$letra32L1.($numL1))->setCellValue($letra31L1.$numL1, 0);
			$sheet->mergeCells($letra41L1.$numL1.':'.$letra42L1.($numL1))->setCellValue($letra41L1.$numL1, 0);
			$vtotalCBaseImponible.="+".$letra21L1.$numL1;
			$vtotalCCreditoFiscal.="+".$letra31L1.$numL1;
			$vtotalCRetencionesIVA.="+".$letra41L1.$numL1;

			$numL1++;
			$sheet->getStyle($letra11L1.$numL1.':'.$letra42L1.$numL1)->getFont()->setSize(12);
			$sheet->getStyle($letra21L1.$numL1.':'.$letra42L1.$numL1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle($letra11L1.$numL1.':'.$letra12L1.$numL1)->getAlignment()->setHorizontal('left');
			$sheet->getStyle($letra21L1.$numL1.':'.$letra22L1.$numL1)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra11L1.$numL1.':'.$letra12L1.($numL1))->setCellValue($letra11L1.$numL1, "Σ de las: Compras Internas gravadas por Alícuota Reducida");
			$sheet->mergeCells($letra21L1.$numL1.':'.$letra22L1.($numL1))->setCellValue($letra21L1.$numL1, 0);
			$sheet->mergeCells($letra31L1.$numL1.':'.$letra32L1.($numL1))->setCellValue($letra31L1.$numL1, 0);
			$sheet->mergeCells($letra41L1.$numL1.':'.$letra42L1.($numL1))->setCellValue($letra41L1.$numL1, 0);
			$vtotalCBaseImponible.="+".$letra21L1.$numL1;
			$vtotalCCreditoFiscal.="+".$letra31L1.$numL1;
			$vtotalCRetencionesIVA.="+".$letra41L1.$numL1;


			$sheet->getStyle($letra11L1.$numInicialL2.':'.$letra12L1.($numL1))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle($letra21L1.$numInicialL2.':'.$letra22L1.($numL1))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle($letra31L1.$numInicialL2.':'.$letra32L1.($numL1))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle($letra41L1.$numInicialL2.':'.$letra42L1.($numL1))->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));

			$numL1++;
			$sheet->getStyle($letra11L1.$numL1.':'.$letra42L1.$numL1)->getFont()->setBold(true)->setSize(13);
			$sheet->getStyle($letra11L1.$numL1.':'.$letra12L1.$numL1)->getAlignment()->setHorizontal('center');
			$sheet->getStyle($letra11L1.$numL1.':'.$letra42L1.($numL1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle($letra21L1.$numL1.':'.$letra42L1.$numL1)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

			$sheet->getStyle($letra11L1.$numL1.':'.$letra12L1.$numL1)->getAlignment()->setHorizontal('left');
			$sheet->mergeCells($letra11L1.$numL1.':'.$letra12L1.($numL1))->setCellValue($letra11L1.$numL1, "Total Compras y Créditos Fiscales del Período");

			$sheet->getStyle($letra21L1.$numL1.':'.$letra42L1.$numL1)->getAlignment()->setHorizontal('right');
			$sheet->mergeCells($letra21L1.$numL1.':'.$letra22L1.$numL1)->setCellValue($letra21L1.$numL1, $vtotalCBaseImponible);
			$sheet->mergeCells($letra31L1.$numL1.':'.$letra32L1.$numL1)->setCellValue($letra31L1.$numL1, $vtotalCCreditoFiscal);
			$sheet->mergeCells($letra41L1.$numL1.':'.$letra42L1.$numL1)->setCellValue($letra41L1.$numL1, $vtotalCRetencionesIVA);
		// CUADRO RESUMEN DE CREDITO  LIBRO 1






		$spreadsheet->createSheet(2);
		$spreadsheet->setActiveSheetIndex(2);
		$spreadsheet->getActiveSheet()->setTitle($nameLibro3);
		$sheet = $spreadsheet->getActiveSheet();

		// CABECERA PRINCIPAL  LIBRO 3
			$sheet->getColumnDimension('A')->setAutoSize(true);
			$sheet->getColumnDimension('B')->setAutoSize(true);
			$sheet->getColumnDimension('C')->setAutoSize(true);
			$sheet->getColumnDimension('D')->setAutoSize(true);
			$sheet->getColumnDimension('E')->setAutoSize(true);
			$sheet->getColumnDimension('F')->setAutoSize(true);
			// $sheet->getColumnDimension('G')->setAutoSize(true);
			// $sheet->getColumnDimension('H')->setAutoSize(true);
			// $sheet->getColumnDimension('I')->setAutoSize(true);
			// $sheet->getColumnDimension('J')->setAutoSize(true);
			// $sheet->getColumnDimension('K')->setAutoSize(true);
			// $sheet->getColumnDimension('L')->setAutoSize(true);
			// $sheet->getColumnDimension('M')->setAutoSize(true);
			// $sheet->getColumnDimension('N')->setAutoSize(true);
			// $sheet->getColumnDimension('O')->setAutoSize(true);
			// $sheet->getColumnDimension('P')->setAutoSize(true);
			// $sheet->getColumnDimension('Q')->setAutoSize(true);
			// $sheet->getColumnDimension('R')->setAutoSize(true);
			// $sheet->getColumnDimension('S')->setAutoSize(true);
			// $sheet->getColumnDimension('T')->setAutoSize(true);
			$sheet->getStyle('A1:Z1000')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');

			$indexL3 = 1;
			$numL3 = 1;
			$numL3++;
			// $sheet->getStyle('B'.$numL3.':E'.$numL3)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setBold(true)->setSize(13);
			$sheet->mergeCells('B'.$numL3.':C'.$numL3)->setCellValue('B'.$numL3, 'INVERSIONES STYLE COLLECTION, C.A.');

			$numL3++;
			$sheet->getStyle('B'.$numL3.':C'.$numL3)->getFont()->setBold(true)->setSize(13);
			$sheet->mergeCells('B'.$numL3.':C'.$numL3)->setCellValue('B'.$numL3, 'RIF: J-408497786');

			$numL3++;
			$sheet->getStyle('B'.$numL3.':C'.$numL3)->getFont()->setBold(true)->setSize(13)->getUnderline(true);
			// $sheet->mergeCells('C'.$numL3.':F'.$numL3)->setCellValue('C'.$numL3, 'RESUMEN DE LOS DÉBITOS Y CRÉDITOS DESDE EL '.str_replace("-","/",$lider->formatFecha($inicioFecha)).' HASTA EL '.str_replace("-","/",$lider->formatFecha($finFecha)));
			$sheet->mergeCells('B'.$numL3.':E'.$numL3)->setCellValue('B'.$numL3, 'RESUMEN DE LOS DÉBITOS Y CRÉDITOS DESDE EL '.str_replace("-","/",$lider->formatFecha($inicioFecha)).' HASTA EL '.str_replace("-","/",$lider->formatFecha($finFecha)));

			$numL3++;
			$numL3++;
		// CABECERA PRINCIPAL  LIBRO 3

		// CUADRO RESUMEN DE DEBITOS DEL PERIODO  LIBRO 3
			$dpBaseImponibleVentasInternasNoGravadas="=0";
			$dpBaseImponibleVentasExportacion="=0";
			$dpBaseImponibleVentasAlicuotaGeneral="='".$nameLibro1."'!O".$numTotalizadorL1;
			$dpDebitoVentasAlicuotaGeneral="='".$nameLibro1."'!Q".$numTotalizadorL1;
			$dpBaseImponibleVentasAlicuotaGeneralAdicional="=0";
			$dpDebitoVentasAlicuotaGeneralAdicional="=0";
			$dpBaseImponibleVentasAlicuotaReducida="=0";
			$dpDebitoVentasAlicuotaReducida="=0";
			$dpBaseImponibleTotalVentasYDebitos="=0";
			$dpDebitoTotalVentasYDebitos="=0";
			$dpDebitoDebitosFiscalPeriodoAnterior = "=".$debitosFiscalesPendienteAnterior;
			$dpDebitoDebitosFiscalExonerados = "=0";
			$dpDebitoTotalDebidosFiscales="=0";

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setBold(true)->setSize(12);
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, "");
			$sheet->setCellValue('C'.$numL3, "Débitos del periodo");
			$sheet->setCellValue('D'.$numL3, "Base Imponible");
			$sheet->setCellValue('E'.$numL3, "Débito");
			// $indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('E'.$numL3.':E'.$numL3)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Ventas Internas no gravadas");
			$sheet->setCellValue('D'.$numL3, $dpBaseImponibleVentasInternasNoGravadas);
			$sheet->setCellValue('E'.$numL3, "");
			$dpBaseImponibleTotalVentasYDebitos.="+D".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('E'.$numL3.':E'.$numL3)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Ventas de exportacion");
			$sheet->setCellValue('D'.$numL3, $dpBaseImponibleVentasExportacion);
			$sheet->setCellValue('E'.$numL3, "");
			$dpBaseImponibleTotalVentasYDebitos.="+D".$numL3;
			// $dpDebitoTotalVentasYDebitos="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Ventas internas gravadas alícuota general");
			$sheet->setCellValue('D'.$numL3, $dpBaseImponibleVentasAlicuotaGeneral);
			$sheet->setCellValue('E'.$numL3, $dpDebitoVentasAlicuotaGeneral);
			$dpBaseImponibleTotalVentasYDebitos.="+D".$numL3;
			$dpDebitoTotalVentasYDebitos.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Ventas internas gravadas por alícuota general mas adicional");
			$sheet->setCellValue('D'.$numL3, $dpBaseImponibleVentasAlicuotaGeneralAdicional);
			$sheet->setCellValue('E'.$numL3, $dpDebitoVentasAlicuotaGeneralAdicional);
			$dpBaseImponibleTotalVentasYDebitos.="+D".$numL3;
			$dpDebitoTotalVentasYDebitos.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Ventas internas gravadas alícuota reducida");
			$sheet->setCellValue('D'.$numL3, $dpBaseImponibleVentasAlicuotaReducida);
			$sheet->setCellValue('E'.$numL3, $dpDebitoVentasAlicuotaReducida);
			$dpBaseImponibleTotalVentasYDebitos.="+D".$numL3;
			$dpDebitoTotalVentasYDebitos.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Total ventas y débitos fiscales para efectos de determinación");
			$sheet->setCellValue('D'.$numL3, $dpBaseImponibleTotalVentasYDebitos);
			$sheet->setCellValue('E'.$numL3, $dpDebitoTotalVentasYDebitos);
			$dpDebitoTotalDebidosFiscales.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->mergeCells('C'.$numL3.':D'.$numL3)->setCellValue('C'.$numL3, "Ajuste a los débitos fiscales de períodos anteriores");
			$sheet->setCellValue('E'.$numL3, $dpDebitoDebitosFiscalPeriodoAnterior);
			$dpDebitoTotalDebidosFiscales.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->mergeCells('C'.$numL3.':D'.$numL3)->setCellValue('C'.$numL3, "Certificado de Débitos Fiscales Exonerados (recibidos)");
			$sheet->setCellValue('E'.$numL3, $dpDebitoDebitosFiscalExonerados);
			$dpDebitoTotalDebidosFiscales.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('C'.$numL3.':F'.$numL3)->getFont()->setBold(true)->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->mergeCells('C'.$numL3.':D'.$numL3)->setCellValue('C'.$numL3, "Total Débitos Fiscales");
			$sheet->setCellValue('E'.$numL3, $dpDebitoTotalDebidosFiscales);
			$numTotalDebitosPeriodo = $numL3;
			$indexL3++;

			$numL3++;
		// CUADRO RESUMEN DE DEBITOS DEL PERIODO  LIBRO 3

		// CUADRO RESUMEN DE CREDITOS DEL PERIODO  LIBRO 3
			$cpBaseImponibleComprasNoGravadas="='".$nameLibro2."'!M".$numTotalizadorL2;
			$cpBaseImponibleImportAlicuotaGeneral="=0";
			$cpCreditoImportAlicuotaGeneral="=0";
			$cpBaseImponibleImportAlicuotaGeneralAdicional="=0";
			$cpCreditoImportAlicuotaGeneralAdicional="=0";
			$cpBaseImponibleImportAlicuotaReducida="=0";
			$cpCreditoImportAlicuotaReducida="=0";

			$cpBaseImponibleCompraInternaAlicuotaGeneral="='".$nameLibro2."'!N".$numTotalizadorL2;
			$cpCreditoCompraInternaAlicuotaGeneral="='".$nameLibro2."'!P".$numTotalizadorL2;
			$cpBaseImponibleCompraInternaAlicuotaGeneralAdicional="=0";
			$cpCreditoCompraInternaAlicuotaGeneralAdicional="=0";
			$cpBaseImponibleCompraInternaAlicuotaReducida="=0";
			$cpCreditoCompraInternaAlicuotaReducida="=0";

			$cpBaseImponibleTotalComprasYCreditos="=0";
			$cpDebitoTotalComprasYCreditos="=0";

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setBold(true)->setSize(12);
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, "");
			$sheet->setCellValue('C'.$numL3, "Créditos del periodo");
			$sheet->setCellValue('D'.$numL3, "Base Imponible");
			$sheet->setCellValue('E'.$numL3, "Crédito");

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('E'.$numL3.':E'.$numL3)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Compras no gravadas y/o sin derecho a crédito fiscal");
			$sheet->setCellValue('D'.$numL3, $cpBaseImponibleComprasNoGravadas);
			$sheet->setCellValue('E'.$numL3, "");
			$cpBaseImponibleTotalComprasYCreditos.="+D".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Importaciones gravadas por alícuota general");
			$sheet->setCellValue('D'.$numL3, $cpBaseImponibleImportAlicuotaGeneral);
			$sheet->setCellValue('E'.$numL3, $cpCreditoImportAlicuotaGeneral);
			$cpBaseImponibleTotalComprasYCreditos.="+D".$numL3;
			$cpDebitoTotalComprasYCreditos.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Importaciones gravadas por alícuota general mas adicional");
			$sheet->setCellValue('D'.$numL3, $cpBaseImponibleImportAlicuotaGeneralAdicional);
			$sheet->setCellValue('E'.$numL3, $cpCreditoImportAlicuotaGeneralAdicional);
			$cpBaseImponibleTotalComprasYCreditos.="+D".$numL3;
			$cpDebitoTotalComprasYCreditos.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Importaciones gravadas por alícuota reducida");
			$sheet->setCellValue('D'.$numL3, $cpBaseImponibleImportAlicuotaReducida);
			$sheet->setCellValue('E'.$numL3, $cpCreditoImportAlicuotaReducida);
			$cpBaseImponibleTotalComprasYCreditos.="+D".$numL3;
			$cpDebitoTotalComprasYCreditos.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Compras Internas gravadas solo por alícuota general");
			$sheet->setCellValue('D'.$numL3, $cpBaseImponibleCompraInternaAlicuotaGeneral);
			$sheet->setCellValue('E'.$numL3, $cpCreditoCompraInternaAlicuotaGeneral);
			$cpBaseImponibleTotalComprasYCreditos.="+D".$numL3;
			$cpDebitoTotalComprasYCreditos.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Compras Internas gravadas por alícuota general mas adicional");
			$sheet->setCellValue('D'.$numL3, $cpBaseImponibleCompraInternaAlicuotaGeneralAdicional);
			$sheet->setCellValue('E'.$numL3, $cpCreditoCompraInternaAlicuotaGeneralAdicional);
			$cpBaseImponibleTotalComprasYCreditos.="+D".$numL3;
			$cpDebitoTotalComprasYCreditos.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Compras Internas gravadas por alícuota reducida");
			$sheet->setCellValue('D'.$numL3, $cpBaseImponibleCompraInternaAlicuotaReducida);
			$sheet->setCellValue('E'.$numL3, $cpCreditoCompraInternaAlicuotaReducida);
			$cpBaseImponibleTotalComprasYCreditos.="+D".$numL3;
			$cpDebitoTotalComprasYCreditos.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('C'.$numL3.':F'.$numL3)->getFont()->setBold(true)->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Total Compras y Créditos Fiscales del Periodo");
			$sheet->setCellValue('D'.$numL3, $cpBaseImponibleTotalComprasYCreditos);
			$sheet->setCellValue('E'.$numL3, $cpDebitoTotalComprasYCreditos);
			$numTotalCreditosPeriodo = $numL3;
			$indexL3++;

			$numL3++;
		// CUADRO RESUMEN DE CREDITOS DEL PERIODO  LIBRO 3

		// CUADRO RESUMEN DE CALCULOS DE CREDITOS DEDUCIBLES  LIBRO 3
			$ccdCreditoFiscalTotalmenteDeducible="=E".$numTotalCreditosPeriodo;
			$ccdCreditoFiscalProdAplicProrrata="=0";
			$ccdExcedenteCreditoFiscalMesAnterior="=".$excedenteCreditosFiscalesPendienteAnterior;
			$ccdAjustesCreditosFiscalesPeriodosAnt="=0";
			$ccdCertificadoDBExoneradosEmitidos="=E".($numTotalDebitosPeriodo-1);
			$ccdTotalCreditosFiscalesDeducibles="=0";

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setBold(true)->setSize(12);
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, "");
			$sheet->mergeCells('B'.$numL3.':E'.$numL3)->setCellValue('B'.$numL3, "Cálculo del Crédito deducible");

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->mergeCells('C'.$numL3.':D'.$numL3)->setCellValue('C'.$numL3, "Créditos fiscales totalmente deducibles");
			$sheet->setCellValue('E'.$numL3, $ccdCreditoFiscalTotalmenteDeducible);
			$ccdTotalCreditosFiscalesDeducibles.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->mergeCells('C'.$numL3.':D'.$numL3)->setCellValue('C'.$numL3, "Créditos fiscales totalmente deducibles");
			$sheet->setCellValue('E'.$numL3, $ccdCreditoFiscalProdAplicProrrata);
			$ccdTotalCreditosFiscalesDeducibles.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->mergeCells('C'.$numL3.':D'.$numL3)->setCellValue('C'.$numL3, "Total créditos fiscales deducibles");
			$sheet->setCellValue('E'.$numL3, $ccdTotalCreditosFiscalesDeducibles);
			// $ccdTotalCreditosFiscalesDeducibles.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->mergeCells('C'.$numL3.':D'.$numL3)->setCellValue('C'.$numL3, "Excedente créditos fiscales del mes anterior");
			$sheet->setCellValue('E'.$numL3, $ccdExcedenteCreditoFiscalMesAnterior);
			$ccdTotalCreditosFiscalesDeducibles.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->mergeCells('C'.$numL3.':D'.$numL3)->setCellValue('C'.$numL3, "Ajuste a los créditos fiscales de periodos anteriores");
			$sheet->setCellValue('E'.$numL3, $ccdAjustesCreditosFiscalesPeriodosAnt);
			$ccdTotalCreditosFiscalesDeducibles.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->mergeCells('C'.$numL3.':D'.$numL3)->setCellValue('C'.$numL3, "Certificados de Débitos Fiscales Exonerados (emitidos)");
			$sheet->setCellValue('E'.$numL3, $ccdCertificadoDBExoneradosEmitidos);
			$ccdTotalCreditosFiscalesDeducibles.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('C'.$numL3.':F'.$numL3)->getFont()->setBold(true)->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->mergeCells('C'.$numL3.':D'.$numL3)->setCellValue('C'.$numL3, "Total Créditos Fiscales");
			$sheet->setCellValue('E'.$numL3, $ccdTotalCreditosFiscalesDeducibles);
			$numTotalCreditosFiscales = $numL3;
			$indexL3++;
			$numL3++;
		// CUADRO RESUMEN DE CALCULOS DE CREDITOS DEDUCIBLES  LIBRO 3

		// CUADRO RESUMEN DE AUTOLIQUIDACION  LIBRO 3
			$autoTotalCuotaTributaria="=MAX(0,E".$numTotalDebitosPeriodo."-E".$numTotalCreditosFiscales.")";
			$autoExcedentesDeCreditoSigMes="=MAX(0,E".$numTotalCreditosFiscales."-E".$numTotalDebitosPeriodo.")";
			$autoRetencionesAcumuladas="=0";
			$autoRetencionPeriodo="='".$nameLibro1."'!R".$numTotalizadorL1;
			$autoTotalRetenciones = "=0";

			$autoRetencionesSoportadaDescont1="=0";
			$autoRetencionesSoportadaDescont2="=0";

			$autoSaldoRetencionesIvaNoAplic = "=0";
			
			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setBold(true)->setSize(12);
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, "");
			$sheet->mergeCells('B'.$numL3.':E'.$numL3)->setCellValue('B'.$numL3, "Autoliquidación");

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('C'.$numL3.':F'.$numL3)->getFont()->setBold(true)->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->mergeCells('C'.$numL3.':D'.$numL3)->setCellValue('C'.$numL3, "Total Cuota tributaria");
			$sheet->setCellValue('E'.$numL3, $autoTotalCuotaTributaria);
			$numPosTotalCuotaTributaria = $numL3;
			// $ccdTotalCreditosFiscalesDeducibles.="+E".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->mergeCells('C'.$numL3.':D'.$numL3)->setCellValue('C'.$numL3, "Excedente de crédito fiscal para el mes siguiente");
			$sheet->setCellValue('E'.$numL3, $autoExcedentesDeCreditoSigMes);
			$numPosExcedenteCreditoFiscalParaSigMes = $numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Retenciones acumuladas por descontar");
			$sheet->setCellValue('D'.$numL3, $autoRetencionesAcumuladas);
			$sheet->setCellValue('E'.$numL3, "");
			$autoTotalRetenciones.="+D".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Retención del periodo");
			$sheet->setCellValue('D'.$numL3, $autoRetencionPeriodo);
			$sheet->setCellValue('E'.$numL3, "");
			$autoTotalRetenciones.="+D".$numL3;
			$indexL3++;

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Total retenciones");
			$sheet->setCellValue('D'.$numL3, $autoTotalRetenciones);
			$sheet->setCellValue('E'.$numL3, "");
			$numPosTotalRetenciones = $numL3;
			$indexL3++;

			$condicionSoportada1="E{$numPosTotalCuotaTributaria}";
			$condicionSoportada2="D{$numPosTotalRetenciones}";
			$contentAutoSoportada="{$condicionSoportada1} > {$condicionSoportada2}";
			$autoRetencionesSoportadaDescont2="=SI({$contentAutoSoportada} , {$condicionSoportada2} , {$condicionSoportada1})";
			// $autoRetencionesSoportadaDescont2="=SI({$contentAutoSoportada};{$condicionSoportada2};{$condicionSoportada1})";

			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Retenciones soportadas descontadas en esta declaración");
			$sheet->setCellValue('D'.$numL3, $autoRetencionesSoportadaDescont1);
			$sheet->setCellValue('E'.$numL3, $autoRetencionesSoportadaDescont2);
			// $sheet->getCell('E'.$numL3)->setValueExplicit($autoRetencionesSoportadaDescont2, DataType::TYPE_FORMULA);
			$numPosTotalRetencionesSoportadas = $numL3;
			$indexL3++;

			$autoSaldoRetencionesIvaNoAplic="=D".$numPosTotalRetenciones."-E".$numPosTotalRetencionesSoportadas;
			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Saldo de retenciones de IVA no aplicado");
			$sheet->setCellValue('D'.$numL3, $autoSaldoRetencionesIvaNoAplic);
			$sheet->setCellValue('E'.$numL3, "");
			$indexL3++;

			$autoTotalAPagar="=E".$numPosTotalCuotaTributaria."-E".$numPosTotalRetencionesSoportadas;
			$numL3++;
			$sheet->getStyle('B'.$numL3.':F'.$numL3)->getFont()->setSize(12);
			$sheet->getStyle('B'.$numL3)->getAlignment()->setHorizontal('center');
			$sheet->getStyle('C'.$numL3)->getAlignment()->setHorizontal('left');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getAlignment()->setHorizontal('right');
			$sheet->getStyle('D'.$numL3.':E'.$numL3)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheet->getStyle('B'.$numL3.':E'.($numL3))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new Color('000000'));
			$sheet->setCellValue('B'.$numL3, $indexL3);
			$sheet->setCellValue('C'.$numL3, "Total a pagar");
			$sheet->setCellValue('D'.$numL3, "");
			$sheet->setCellValue('E'.$numL3, $autoTotalAPagar);
			$indexL3++;
		// CUADRO RESUMEN DE AUTOLIQUIDACION  LIBRO 3

		// // die();
		$spreadsheet->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Libros de IVA'.$nameLibrosComplement.'.xlsx"');
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->setPreCalculateFormulas(true);
		$writer->save('php://output');
	}
	
	public function exportarResumenGemas($dat, $lider){
		$resumenCuentas = $dat['resumenCuentas'];
		if(!empty($dat['mes'])){
			$mes = $dat['mes'];
		}
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0);

		$sheetInicial = $spreadsheet->getActiveSheet()->setTitle('Reporte de Gemas');
		$sheetInicial->getColumnDimension('A')->setAutoSize(true);
		$sheetInicial->getColumnDimension('B')->setAutoSize(true);
		$sheetInicial->getColumnDimension('C')->setAutoSize(true);
		$sheetInicial->getColumnDimension('D')->setAutoSize(true);
		$sheetInicial->getColumnDimension('E')->setAutoSize(true);
		$sheetInicial->getColumnDimension('F')->setAutoSize(true);
		$sheetInicial->getStyle('A1:Z30')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
		
		$num2 = 1;
		$num = 2;
		

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
		
				
			
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
			$num++;
			$sheetInicial->getStyle('B'.$num.':E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
			$sheetInicial->getStyle('B'.$num.':E'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->getStyle('B'.$num)->getAlignment()->setHorizontal('right');
			$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
			$sheetInicial->getStyle('B'.$num.':E'.$num)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_MEDIUM)->setColor(new Color('000000'));

			if(!empty($mes)){
				$datetitle = "MES ".$mes." DEL ".date('Y');
			}else{
				$datetitle = "AÑO ".date('Y');
			}
			$sheetInicial->setCellValue('B'.$num, 'REPORTE DE');
			$sheetInicial->setCellValue('C'.$num, 'GEMAS DEL');
			$sheetInicial->setCellValue('D'.$num, mb_strtoupper($datetitle));
			$num++;
			
			$sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setSize(13);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
			$num++;

			$inicial = $resumenCuentas['inicial'];
			$formulaDisponible="";
			foreach ($inicial as $key) {
				$sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setBold(true)->setSize(16);
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
				$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
				$sheetInicial->getStyle('B'.$num.':E'.$num)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_MEDIUM)->setColor(new Color('000000'));
				
				$sheetInicial->setCellValue('B'.$num, $key['name1']);
				$sheetInicial->setCellValue('C'.$num, $key['name2']);
				$sheetInicial->setCellValue('D'.$num, $key['cantidad']);
				if($formulaDisponible!=""){
					$formulaDisponible.="+";
				}
				$formulaDisponible.="D".$num;
				
				$num++;
			}

			$sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setSize(13);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
			$num++;


			$sumatoria = $resumenCuentas['sumatoria'];
			$formulaSuma="";
			foreach ($sumatoria as $key) {
				$sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setSize(13);
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
				$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);

				$sheetInicial->setCellValue('B'.$num, $key['name1']);
				$sheetInicial->setCellValue('C'.$num, $key['name2']);
				$sheetInicial->setCellValue('D'.$num, $key['cantidad']);
				if($formulaSuma!=""){
					$formulaSuma.="+";
				}
				$formulaSuma.="D".$num;
				
				$num++;
			}
			
			// $sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			// $sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setSize(13);
			// $sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
			// $sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
			// $sheetInicial->getStyle('A'.$num.':E'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
			// $num++;


			$total_sumatoria = $resumenCuentas['total_sumatoria'];
			foreach ($total_sumatoria as $key) {
				$sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setBold(true)->setSize(14);
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
				$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
				$sheetInicial->getStyle('B'.$num.':E'.$num)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_MEDIUM)->setColor(new Color('000000'));
				
				$sheetInicial->setCellValue('B'.$num, $key['name1']);
				$sheetInicial->setCellValue('C'.$num, $key['name2']);
				$sheetInicial->setCellValue('D'.$num, "={$formulaSuma}");
				$sheetInicial->setCellValue('E'.$num, "(+)");
				if($formulaDisponible!=""){
					$formulaDisponible.="+";
				}
				$formulaDisponible.="D".$num;

				$num++;
			}

			$sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setSize(13);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
			$num++;


			$ganadas = $resumenCuentas['ganadas'];
			foreach ($ganadas as $key) {
				$sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setSize(13);
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
				$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
				
				
				$sheetInicial->setCellValue('B'.$num, $key['name1']);
				$sheetInicial->setCellValue('C'.$num, $key['name2']);
				$sheetInicial->setCellValue('D'.$num, $key['cantidad']);

				$num++;
			}

			$sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setSize(13);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
			$num++;


			$restas = $resumenCuentas['restas'];
			$formulaResta="";
			foreach ($restas as $key) {
				$sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setSize(13);
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
				$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
				
				
				$sheetInicial->setCellValue('B'.$num, $key['name1']);
				$sheetInicial->setCellValue('C'.$num, $key['name2']);
				$sheetInicial->setCellValue('D'.$num, $key['cantidad']);
				if($formulaResta!=""){
					$formulaResta.="+";
				}
				$formulaResta.="D".$num;

				$num++;
			}

			// $sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			// $sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setSize(13);
			// $sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
			// $sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
			// $sheetInicial->getStyle('A'.$num.':E'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
			// $num++;


			$total_resta = $resumenCuentas['total_resta'];
			foreach ($total_resta as $key) {
				$sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setBold(true)->setSize(14);
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
				$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
				$sheetInicial->getStyle('B'.$num.':E'.$num)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_MEDIUM)->setColor(new Color('000000'));
				
				$sheetInicial->setCellValue('B'.$num, $key['name1']);
				$sheetInicial->setCellValue('C'.$num, $key['name2']);
				$sheetInicial->setCellValue('D'.$num, "={$formulaResta}");
				$sheetInicial->setCellValue('E'.$num, "(-)");
				
				if($formulaDisponible!=""){
					$formulaDisponible.="-";
				}
				$formulaDisponible.="D".$num;
				
				$num++;
			}

			$sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setSize(13);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
			$sheetInicial->getStyle('A'.$num.':E'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
			$num++;


			$total_disponible = $resumenCuentas['total_disponible'];
			foreach ($total_disponible as $key) {
				$sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setBold(true)->setSize(16);
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
				$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
				$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
				$sheetInicial->getStyle('B'.$num.':E'.$num)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_MEDIUM)->setColor(new Color('000000'));
				
				$sheetInicial->setCellValue('B'.$num, $key['name1']);
				$sheetInicial->setCellValue('C'.$num, $key['name2']);
				$sheetInicial->setCellValue('D'.$num, "={$formulaDisponible}");
				
				$num++;
			}

			$sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setSize(13);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
			

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Reporte de Gemas.xlsx"');
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');

	}

	public function exportarAlcanzadoFacturadoTotal($dat, $lider){
		$campana = $dat['campana'];
		$despacho = $dat['despacho'];
		$facturado = $dat['facturado'];
		$cantRegistros=count($facturado);

		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0);

		$sheetInicial = $spreadsheet->getActiveSheet()->setTitle('Total Premios Facturados');
		$sheetInicial->getColumnDimension('A')->setAutoSize(true);
		$sheetInicial->getColumnDimension('B')->setAutoSize(true);
		$sheetInicial->getColumnDimension('C')->setAutoSize(true);
		$sheetInicial->getColumnDimension('D')->setAutoSize(true);
		$sheetInicial->getColumnDimension('E')->setAutoSize(true);
		$sheetInicial->getColumnDimension('F')->setAutoSize(true);
		$sheetInicial->getStyle('A1:Z'.($cantRegistros+50))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
		
		$num2 = 1;
		$num = 2;
		
		$sheetInicial->getStyle('B'.$num.':E'.$num)->getFont()->setSize(15);
		$sheetInicial->getStyle('B'.$num)->getAlignment()->setHorizontal('right');
		$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
		$sheetInicial->setCellValue('B'.$num, "RESUMEN");
		$sheetInicial->setCellValue('C'.$num, 'PREMIOS FACTURADOS');
		$sheetInicial->setCellValue('D'.$num, '');
		$sheetInicial->setCellValue('E'.$num, '');
		$num++;

		$num++;
		$sheetInicial->getStyle('B'.$num.':E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
		$sheetInicial->getStyle('B'.$num.':E'.$num)->getFont()->setBold(true)->setSize(15);
		$sheetInicial->getStyle('B'.$num)->getAlignment()->setHorizontal('right');
		$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
		$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
		$sheetInicial->getStyle('B'.$num.':E'.$num)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_MEDIUM)->setColor(new Color('000000'));

		$sheetInicial->setCellValue('B'.$num, "CANTIDAD");
		$sheetInicial->setCellValue('C'.$num, 'DESCRIPCIÓN');
		$sheetInicial->setCellValue('D'.$num, '');
		$sheetInicial->setCellValue('E'.$num, 'FACTURAS');
		$num++;
		
		$sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setSize(13);
		$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
		$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
		$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
		
		$numi=$num;
		foreach ($facturado as $key) {
			$conceptos = [];
			$comparar2=mb_strtolower("premios de");
			foreach ($key['conceptos'] as $con) {
				$comparar1=mb_strtolower($con);
				if(strlen(strpos($comparar1, $comparar2))>0){
					$con=substr($con, strlen(mb_strtolower("premios de"))+1);
				}
				$comparar1=mb_strtolower($con);
				if(strlen(strpos($comparar1, $comparar2)) > 0){
					$con=substr($con, strlen(mb_strtolower("premios de"))+1);
				}
				$conceptos[count($conceptos)]=$con;
			}
			$conceptosNR=[];
			foreach ($conceptos as $conc) {
				if(empty($conceptosNR[$conc])){
					$conceptosNR[$conc]=$conc;
				}
			}
			$limiteConceptos=count($conceptosNR);
			$index=1;
			$key['concepto']="";
			foreach ($conceptosNR as $concep) {
				$key['concepto'].=$concep;
				if($index<$limiteConceptos){
					$key['concepto'].=", ";
				}
				$index++;
			}
			$sheetInicial->getStyle('B'.$num)->getNumberFormat()->setFormatCode('#,##0');
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setSize(13);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('left');
			$sheetInicial->getStyle('B'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
			
			$sheetInicial->setCellValue('B'.$num, $key['cantidad']);
			$sheetInicial->setCellValue('C'.$num, mb_strtoupper($key['descripcion']));
			$sheetInicial->setCellValue('D'.$num, mb_strtoupper("Premios de ".$key['concepto']));
			$sheetInicial->setCellValue('E'.$num, mb_strtoupper("N° Doc: ".$key['id_factura']));
			
			$num++;
		}
		$numf=$num-1;
		$sheetInicial->getStyle('B'.$numi.':E'.$numf)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_MEDIUM)->setColor(new Color('000000'));
			
		$nameDocument = "Reporte de Total Premios Facturados en Pedido {$despacho['numero_despacho']} de Campaña {$campana['numero_campana']}/{$campana['anio_campana']}.xlsx";
		// echo $nameDocument;
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$nameDocument.'"');
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');

	}
	public function exportarInventarioProductos($dat, $lider){
		$almacenes = $dat['almacenes'];
		$productos = $dat['productos'];
		
		$cantRegistros=count($productos)-1;
		// $cantAlmacenes=count($almacenes)-1;
		$letraAlmacenes = [
			'0'=>'G',
			'1'=>'H',
			'2'=>'I',
			'3'=>'J',
			'4'=>'K',
			'5'=>'L',
			'6'=>'M',
			'7'=>'N',
			'8'=>'O',
			'9'=>'P',
			'10'=>'Q',
			'11'=>'R',
			'12'=>'S',
			'13'=>'T',
			'14'=>'U',
			'15'=>'V',
			'16'=>'W',
			'17'=>'X',
			'18'=>'Y',
			'19'=>'Z',
		];
		
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0);
		
		$sheetInicial = $spreadsheet->getActiveSheet()->setTitle('INVENTARIO PRODUCTOS');
		$sheetInicial->getColumnDimension('A')->setAutoSize(true);
		$sheetInicial->getColumnDimension('B')->setAutoSize(true);
		$sheetInicial->getColumnDimension('C')->setAutoSize(true);
		$sheetInicial->getColumnDimension('D')->setAutoSize(true);
		$sheetInicial->getColumnDimension('E')->setAutoSize(true);
		$sheetInicial->getColumnDimension('F')->setAutoSize(true);
		$indexletraAlmacenes=0;
		foreach ($almacenes as $alm) {
			$idLetra=$letraAlmacenes[$indexletraAlmacenes];
			$sheetInicial->getColumnDimension($idLetra)->setAutoSize(true);
			$indexletraAlmacenes++;
		}
		$indexLetraF = $letraAlmacenes[$indexletraAlmacenes-1];
		$sheetInicial->getStyle('A1:Z'.($cantRegistros+50))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
		
		$num2 = 1;
		$num = 2;
		
		$sheetInicial->getStyle('B'.$num.':'.$indexLetraF.$num)->getFont()->setBold(true)->setSize(15);
		$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('right');
		$sheetInicial->getStyle('D'.$num)->getAlignment()->setHorizontal('left');
		$sheetInicial->setCellValue('C'.$num, "RESUMEN INVENTARIO DE");
		$sheetInicial->setCellValue('D'.$num, 'PRODUCTOS');
		$num++;

		$num++;
		$sheetInicial->getStyle('B'.$num.':'.$indexLetraF.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
		$sheetInicial->getStyle('B'.$num.':'.$indexLetraF.$num)->getFont()->setBold(true)->setSize(13);
		$sheetInicial->getStyle('B'.$num.':'.$indexLetraF.$num)->getAlignment()->setHorizontal('left');
		// $sheetInicial->getStyle('B'.$num)->getAlignment()->setHorizontal('right');
		// $sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
		$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
		$sheetInicial->getStyle('B'.$num.':'.$indexLetraF.$num)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_MEDIUM)->setColor(new Color('000000'));

		$sheetInicial->setCellValue('B'.$num, 'CODIGO');
		$sheetInicial->setCellValue('C'.$num, "PRODUCTO");
		$sheetInicial->setCellValue('D'.$num, 'MARCA');
		$sheetInicial->setCellValue('E'.$num, 'DESCRIPCION');
		$sheetInicial->setCellValue('F'.$num, 'STOCK TOTAL');
		$indexletraAlmacenes = 0;
		foreach ($almacenes as $alm) {
			if(!empty($alm['id_almacen'])){
				$idLetra=$letraAlmacenes[$indexletraAlmacenes];
				$sheetInicial->setCellValue($idLetra.$num, mb_strtoupper($alm['nombre_almacen']));
				$indexletraAlmacenes++;
			}
		}
		$num++;
		
		$sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		$sheetInicial->getStyle('A'.$num.':'.$indexLetraF.$num)->getFont()->setSize(13);
		$sheetInicial->getStyle('A'.$num.':'.$indexLetraF.$num)->getAlignment()->setHorizontal('center');
		// $sheetInicial->getStyle('C'.$num.':F'.$num)->getAlignment()->setHorizontal('left');
		$sheetInicial->getStyle('A'.$num.':'.$indexLetraF.$num)->getFill()->setFillType(Fill::FILL_SOLID);

		
		$numi=$num;
		
		$numberRegistros=1;
		foreach ($productos as $key) {
			if(!empty($key['id_producto'])){$colorLine="";
				if(($numberRegistros%2)==0){
					$colorLine="dfdfeb";#dfdfeb
				}else{
					$colorLine="FFFFFF";
				}
				$sheetInicial->getStyle('B'.$num.':'.$indexLetraF.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($colorLine);
				$sheetInicial->getStyle('B'.$num)->getNumberFormat()->setFormatCode('#,##0');
				$sheetInicial->getStyle('F'.$num.':'.$indexLetraF.$num)->getNumberFormat()->setFormatCode('#,##0');
				$sheetInicial->getStyle('A'.$num.':'.$indexLetraF.$num)->getFont()->setSize(13);
				$sheetInicial->getStyle('A'.$num.':'.$indexLetraF.$num)->getAlignment()->setHorizontal('left');
				$sheetInicial->getStyle('F'.$num.':'.$indexLetraF.$num)->getAlignment()->setHorizontal('right');
				// $sheetInicial->getStyle('B'.$num)->getAlignment()->setHorizontal('center');
				$sheetInicial->getStyle('A'.$num.':'.$indexLetraF.$num)->getFill()->setFillType(Fill::FILL_SOLID);
				
				$sheetInicial->setCellValue('B'.$num, mb_strtoupper($key['codigo_producto']));
				$sheetInicial->setCellValue('C'.$num, $key['producto']);
				$sheetInicial->setCellValue('D'.$num, mb_strtoupper($key['marca_producto']));
				$sheetInicial->setCellValue('E'.$num, mb_strtoupper($key['descripcion']));
				$sheetInicial->setCellValue('F'.$num, $key['stock_total']);
				$indexletraAlmacenes = 0;
				foreach ($almacenes as $alm) {
					if(!empty($alm['id_almacen'])){
						$id_cant_almacen = 'stock_almacen'.$alm['id_almacen'];
						$idLetra=$letraAlmacenes[$indexletraAlmacenes];
						// $sheetInicial->setCellValue($idLetra.$num, $id_cant_almacen);
						$sheetInicial->setCellValue($idLetra.$num, $key[$id_cant_almacen]);
						$indexletraAlmacenes++;
					}
				}
				$num++;
				$numberRegistros++;
			}
		}
		$numf=$num-1;
		$sheetInicial->getStyle('B'.$numi.':'.$indexLetraF.$numf)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_MEDIUM)->setColor(new Color('000000'));
			
		$nameDocument = "Reporte de Inventarios - Productos.xlsx";
		// echo $nameDocument;
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$nameDocument.'"');
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');

	}
	public function exportarInventarioMercancia($dat, $lider){
		$almacenes = $dat['almacenes'];
		$mercancia = $dat['mercancia'];
		
		$cantRegistros=count($mercancia)-1;
		// $cantAlmacenes=count($almacenes)-1;
		$letraAlmacenes = [
			'0'=>'G',
			'1'=>'H',
			'2'=>'I',
			'3'=>'J',
			'4'=>'K',
			'5'=>'L',
			'6'=>'M',
			'7'=>'N',
			'8'=>'O',
			'9'=>'P',
			'10'=>'Q',
			'11'=>'R',
			'12'=>'S',
			'13'=>'T',
			'14'=>'U',
			'15'=>'V',
			'16'=>'W',
			'17'=>'X',
			'18'=>'Y',
			'19'=>'Z',
		];
		
		$spreadsheet = new Spreadsheet();
		$spreadsheet->setActiveSheetIndex(0);
		
		$sheetInicial = $spreadsheet->getActiveSheet()->setTitle('INVENTARIO PRODUCTOS');
		$sheetInicial->getColumnDimension('A')->setAutoSize(true);
		$sheetInicial->getColumnDimension('B')->setAutoSize(true);
		$sheetInicial->getColumnDimension('C')->setAutoSize(true);
		$sheetInicial->getColumnDimension('D')->setAutoSize(true);
		$sheetInicial->getColumnDimension('E')->setAutoSize(true);
		$sheetInicial->getColumnDimension('F')->setAutoSize(true);
		$indexletraAlmacenes=0;
		foreach ($almacenes as $alm) {
			$idLetra=$letraAlmacenes[$indexletraAlmacenes];
			$sheetInicial->getColumnDimension($idLetra)->setAutoSize(true);
			$indexletraAlmacenes++;
		}
		$indexLetraF = $letraAlmacenes[$indexletraAlmacenes-1];
		$sheetInicial->getStyle('A1:Z'.($cantRegistros+50))->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
		
		$num2 = 1;
		$num = 2;
		
		$sheetInicial->getStyle('B'.$num.':'.$indexLetraF.$num)->getFont()->setBold(true)->setSize(15);
		$sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('right');
		$sheetInicial->getStyle('D'.$num)->getAlignment()->setHorizontal('left');
		$sheetInicial->setCellValue('C'.$num, "RESUMEN INVENTARIO DE");
		$sheetInicial->setCellValue('D'.$num, 'MERCANCIA');
		$num++;

		$num++;
		$sheetInicial->getStyle('B'.$num.':'.$indexLetraF.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');
		$sheetInicial->getStyle('B'.$num.':'.$indexLetraF.$num)->getFont()->setBold(true)->setSize(13);
		$sheetInicial->getStyle('B'.$num.':'.$indexLetraF.$num)->getAlignment()->setHorizontal('left');
		// $sheetInicial->getStyle('B'.$num)->getAlignment()->setHorizontal('right');
		// $sheetInicial->getStyle('C'.$num)->getAlignment()->setHorizontal('left');
		$sheetInicial->getStyle('A'.$num.':F'.$num)->getFill()->setFillType(Fill::FILL_SOLID);
		$sheetInicial->getStyle('B'.$num.':'.$indexLetraF.$num)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_MEDIUM)->setColor(new Color('000000'));

		$sheetInicial->setCellValue('B'.$num, 'CODIGO');
		$sheetInicial->setCellValue('C'.$num, "MERCANCIA");
		$sheetInicial->setCellValue('D'.$num, 'MARCA');
		$sheetInicial->setCellValue('E'.$num, 'DESCRIPCION');
		$sheetInicial->setCellValue('F'.$num, 'STOCK TOTAL');
		$indexletraAlmacenes = 0;
		foreach ($almacenes as $alm) {
			if(!empty($alm['id_almacen'])){
				$idLetra=$letraAlmacenes[$indexletraAlmacenes];
				$sheetInicial->setCellValue($idLetra.$num, mb_strtoupper($alm['nombre_almacen']));
				$indexletraAlmacenes++;
			}
		}
		$num++;
		
		$sheetInicial->getStyle('D'.$num)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
		$sheetInicial->getStyle('A'.$num.':'.$indexLetraF.$num)->getFont()->setSize(13);
		$sheetInicial->getStyle('A'.$num.':'.$indexLetraF.$num)->getAlignment()->setHorizontal('center');
		// $sheetInicial->getStyle('C'.$num.':F'.$num)->getAlignment()->setHorizontal('left');
		$sheetInicial->getStyle('A'.$num.':'.$indexLetraF.$num)->getFill()->setFillType(Fill::FILL_SOLID);

		
		$numi=$num;
		$numberRegistros=1;
		foreach ($mercancia as $key) {
			if(!empty($key['id_mercancia'])){
				$colorLine="";
				if(($numberRegistros%2)==0){
					$colorLine="dfdfeb";  #dfdfeb
				}else{
					$colorLine="FFFFFF";
				}
				$sheetInicial->getStyle('B'.$num.':'.$indexLetraF.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB($colorLine);
				$sheetInicial->getStyle('B'.$num)->getNumberFormat()->setFormatCode('#,##0');
				$sheetInicial->getStyle('F'.$num.':'.$indexLetraF.$num)->getNumberFormat()->setFormatCode('#,##0');
				$sheetInicial->getStyle('A'.$num.':'.$indexLetraF.$num)->getFont()->setSize(13);
				$sheetInicial->getStyle('A'.$num.':'.$indexLetraF.$num)->getAlignment()->setHorizontal('left');
				$sheetInicial->getStyle('F'.$num.':'.$indexLetraF.$num)->getAlignment()->setHorizontal('right');
				// $sheetInicial->getStyle('B'.$num)->getAlignment()->setHorizontal('center');
				$sheetInicial->getStyle('A'.$num.':'.$indexLetraF.$num)->getFill()->setFillType(Fill::FILL_SOLID);
				
				$sheetInicial->setCellValue('B'.$num, mb_strtoupper($key['codigo_mercancia']));
				$sheetInicial->setCellValue('C'.$num, $key['mercancia']);
				$sheetInicial->setCellValue('D'.$num, mb_strtoupper($key['marca_mercancia']));
				$sheetInicial->setCellValue('E'.$num, mb_strtoupper($key['descripcion_mercancia']));
				$sheetInicial->setCellValue('F'.$num, $key['stock_total']);
				$indexletraAlmacenes = 0;
				foreach ($almacenes as $alm) {
					if(!empty($alm['id_almacen'])){
						$id_cant_almacen = 'stock_almacen'.$alm['id_almacen'];
						$idLetra=$letraAlmacenes[$indexletraAlmacenes];
						// $sheetInicial->setCellValue($idLetra.$num, $id_cant_almacen);
						$sheetInicial->setCellValue($idLetra.$num, $key[$id_cant_almacen]);
						$indexletraAlmacenes++;
					}
				}
				$numberRegistros++;
				$num++;
			}
		}
		$numf=$num-1;
		$sheetInicial->getStyle('B'.$numi.':'.$indexLetraF.$numf)->getBorders()->getOutline()->setBorderStyle(Border::BORDER_MEDIUM)->setColor(new Color('000000'));
			
		$nameDocument = "Reporte de Inventarios - Mercancia.xlsx";
		// echo $nameDocument;
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$nameDocument.'"');
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
