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
		$bancos = $dat['bancos'];
		$despacho = $dat['despachos'];
		$planes = $dat['planes'];
		$nuevoTotal = $dat['nuevoTotal'];

		$numCampana = $despacho['numero_campana']."_".$despacho['anio_campana'];
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

		$totalAcumMonto = 0;
		$totalAcumEqv = 0;
		$abonado = 0;
		$diferido = 0;
		$reportado = 0;
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
			$varCont = $coleccionesContado * $pedido['primer_precio_coleccion'];


			$num = 2;
			$sheetInicial->setCellValue('B'.$num, 'Líder');
			$sheetInicial->setCellValue('C'.$num, $cliente['primer_nombre']." ".$cliente['primer_apellido']);
			$sheetInicial->setCellValue('D'.$num, number_format($cliente['cedula'],0,',','.'));
			$sheetInicial->getStyle('B'.$num.':D'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('D59FD1');
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
			
			$num++;
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
			foreach ($planes as $plans) {
				if(!empty($plans)){
					if($plans['cantidad_coleccion_plan']>0){
						$num++;
						$colecciones = $plans['cantidad_coleccion']*$plans['cantidad_coleccion_plan'];
						$multi = $colecciones*$plans['primer_precio_coleccion'];
						$acumTotalPrimerPago += $multi;
						
						$sheetInicial->setCellValue('B'.$num, 'Plan '.$plans['nombre_plan']);
						$sheetInicial->setCellValue('C'.$num, $colecciones . ' col. '.  'x ');
						$sheetInicial->setCellValue('D'.$num, '$'.$plans['primer_precio_coleccion']. ' = ');
						$sheetInicial->setCellValue('E'.$num, '$'.$multi);
						$sheetInicial->getStyle('B'.$num.':D'.$num)->getAlignment()->setHorizontal('justify');
						$sheetInicial->getStyle('E'.$num)->getAlignment()->setHorizontal('right');
					}
				}
			}
			$num++;

			$sheetInicial->setCellValue('D'.$num, 'Total =');
			$sheetInicial->setCellValue('E'.$num, '$'.$acumTotalPrimerPago);
			$sheetInicial->getStyle('D'.$num.':E'.$num)->getFont()->setBold(true)->setSize(13);
			$sheetInicial->getStyle('D'.$num.':D'.$num)->getAlignment()->setHorizontal('justify');
			$sheetInicial->getStyle('E'.$num)->getAlignment()->setHorizontal('right');
			$sheetInicial->getStyle('B'.$num.':E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');

			$num++;

			$sheetInicial->setCellValue('B'.$num, '(-) Colecciones de Contado');
			$sheetInicial->setCellValue('C'.$num, $coleccionesContado . ' col. '.  'x ');
			$sheetInicial->setCellValue('D'.$num, '$'.$pedido['primer_precio_coleccion']. ' = ');
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
		}else{

			$num = 3;
		}

		$sheetInicial->setCellValue('B'.$num, 'Contado');
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
		$acumMontoContado = 0;
		$acumEqvContado = 0;
		foreach ($pagos as $pago) {
			if($pago['id_pago']){
				if($pago['tipo_pago']=="Contado"){
					$bank = "";
					foreach ($bancos as $banco) {
						if(!empty($banco['id_banco'])){
							if($banco['id_banco']==$pago['id_banco']){
								$bank = $banco['nombre_banco']." - ".$banco['nombre_propietario'];
							}
						}
					}
					if($pago['tipo_pago']=="Contado"){
                      $restriccion = $despacho['fecha_inicial_senior'];
                    }
					if($pago['tipo_pago']=="Inicial"){
                      $restriccion = $despacho['fecha_inicial_senior'];
                    }
                    if($pago['tipo_pago']=="Primer Pago"){
                      $restriccion = $despacho['fecha_primera_senior'];
                    }
                    if($pago['tipo_pago']=="Segundo Pago"){
                      $restriccion = $despacho['fecha_segunda_senior'];
                    }
                    $temporalidad = "";
                    if($pago['fecha_pago'] <= $restriccion){
                      $temporalidad = "Puntual";
                    }else{
                      $temporalidad = "Impuntual";
                    }
					$acumMontoContado += $pago['monto_pago'];
					$acumEqvContado += $pago['equivalente_pago'];
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

		$sheetInicial->setCellValue('E'.$num, 'Monto: ');
		$sheetInicial->setCellValue('F'.$num, number_format($acumMontoContado,2,',','.'));
		$sheetInicial->setCellValue('G'.$num, 'Eqv: ');
		$sheetInicial->setCellValue('I'.$num, '$'.number_format($acumEqvContado,2,',','.'));

		

		$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(13);
		$sheetInicial->getStyle('A'.$num.':J'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CFCFCF');
		$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
		$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');
		$sheetInicial->getStyle('I'.$num)->getAlignment()->setHorizontal('right');
		$num++;

				$reportadoContado=0;
				$diferidoContado=0;
				$abonadoContado=0;
				foreach ($pagos as $data):
					if(!empty($data['id_pago'])):
						if($data['tipo_pago']=="Contado"):
							if($data['estado']=="Abonado"){
								$reportadoContado += $data['equivalente_pago'];
								$abonadoContado += $data['equivalente_pago'];
							}
							else if($data['estado']=="Diferido"){
								$reportadoContado += $data['equivalente_pago'];
								$diferidoContado += $data['equivalente_pago'];
							}else{
								$reportadoContado += $data['equivalente_pago'];
								}
							endif;
						endif;
				endforeach;
			$sheetInicial->setCellValue('B'.$num, 'Reportado Contado');
			$sheetInicial->setCellValue('C'.$num, 'Diferido Contado');
			$sheetInicial->setCellValue('D'.$num, 'Abonado Contado');
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(14);
			// $sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
			// $sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
			// $sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');

				$sheetInicial->getStyle('B'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCCCFF');
				$sheetInicial->getStyle('C'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCC');
				$sheetInicial->getStyle('D'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFCC');

			$num++;
			$sheetInicial->setCellValue('B'.$num, '$'.number_format($reportadoContado,2,',','.'));
			$sheetInicial->setCellValue('C'.$num, '$'.number_format($diferidoContado,2,',','.'));
			$sheetInicial->setCellValue('D'.$num, '$'.number_format($abonadoContado,2,',','.'));
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
			$sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
			$sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');

		$num++;
		$num++;
		$num++;









		$sheetInicial->setCellValue('B'.$num, 'Inicial');
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
		$acumMontoInicial = 0;
		$acumEqvInicial = 0;
		foreach ($pagos as $pago) {
			if($pago['id_pago']){
				if($pago['tipo_pago']=="Inicial"){
					$bank = "";
					foreach ($bancos as $banco) {
						if(!empty($banco['id_banco'])){
							if($banco['id_banco']==$pago['id_banco']){
								$bank = $banco['nombre_banco']." - ".$banco['nombre_propietario'];
							}
						}
					}
					if($pago['tipo_pago']=="Contado"){
                      $restriccion = $despacho['fecha_inicial_senior'];
                    }
					if($pago['tipo_pago']=="Inicial"){
                      $restriccion = $despacho['fecha_inicial_senior'];
                    }
                    if($pago['tipo_pago']=="Primer Pago"){
                      $restriccion = $despacho['fecha_primera_senior'];
                    }
                    if($pago['tipo_pago']=="Segundo Pago"){
                      $restriccion = $despacho['fecha_segunda_senior'];
                    }
                    $temporalidad = "";
                    if($pago['fecha_pago'] <= $restriccion){
                      $temporalidad = "Puntual";
                    }else{
                      $temporalidad = "Impuntual";
                    }
					$acumMontoInicial += $pago['monto_pago'];
					$acumEqvInicial += $pago['equivalente_pago'];
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

		$sheetInicial->setCellValue('E'.$num, 'Monto: ');
		$sheetInicial->setCellValue('F'.$num, number_format($acumMontoInicial,2,',','.'));
		$sheetInicial->setCellValue('G'.$num, 'Eqv: ');
		$sheetInicial->setCellValue('I'.$num, '$'.number_format($acumEqvInicial,2,',','.'));

		

		$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(13);
		$sheetInicial->getStyle('A'.$num.':J'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CFCFCF');
		$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
		$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');
		$sheetInicial->getStyle('H'.$num)->getAlignment()->setHorizontal('right');
		$sheetInicial->getStyle('I'.$num)->getAlignment()->setHorizontal('right');
		$num++;

				$reportadoInicial=0;
				$diferidoInicial=0;
				$abonadoInicial=0;
				foreach ($pagos as $data):
					if(!empty($data['id_pago'])):
						if($data['tipo_pago']=="Inicial"):
							if($data['estado']=="Abonado"){
								$reportadoInicial += $data['equivalente_pago'];
								$abonadoInicial += $data['equivalente_pago'];
							}
							else if($data['estado']=="Diferido"){
								$reportadoInicial += $data['equivalente_pago'];
								$diferidoInicial += $data['equivalente_pago'];
							}else{
								$reportadoInicial += $data['equivalente_pago'];
								}
							endif;
						endif;
				endforeach;
			$sheetInicial->setCellValue('B'.$num, 'Reportado Inicial');
			$sheetInicial->setCellValue('C'.$num, 'Diferido Inicial');
			$sheetInicial->setCellValue('D'.$num, 'Abonado Inicial');
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(14);
			// $sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
			// $sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
			// $sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');

				$sheetInicial->getStyle('B'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCCCFF');
				$sheetInicial->getStyle('C'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCC');
				$sheetInicial->getStyle('D'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFCC');

			$num++;
			$sheetInicial->setCellValue('B'.$num, '$'.number_format($reportadoInicial,2,',','.'));
			$sheetInicial->setCellValue('C'.$num, '$'.number_format($diferidoInicial,2,',','.'));
			$sheetInicial->setCellValue('D'.$num, '$'.number_format($abonadoInicial,2,',','.'));
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
			$sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
			$sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');
		$num++;
		$num++;
		$num++;










		$sheetInicial->setCellValue('B'.$num, 'Primer Pago');
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
		$num2=1;
		$acumMontoPrimerPago = 0;
		$acumEqvPrimerPago = 0;
		foreach ($pagos as $pago) {
			if($pago['id_pago']){
				if($pago['tipo_pago']=="Primer Pago"){
					$bank = "";
					foreach ($bancos as $banco) {
						if(!empty($banco['id_banco'])){
							if($banco['id_banco']==$pago['id_banco']){
								$bank = $banco['nombre_banco']." - ".$banco['nombre_propietario'];
							}
						}
					}
					if($pago['tipo_pago']=="Contado"){
                      $restriccion = $despacho['fecha_inicial_senior'];
                    }
					if($pago['tipo_pago']=="Inicial"){
                      $restriccion = $despacho['fecha_inicial_senior'];
                    }
                    if($pago['tipo_pago']=="Primer Pago"){
                      $restriccion = $despacho['fecha_primera_senior'];
                    }
                    if($pago['tipo_pago']=="Segundo Pago"){
                      $restriccion = $despacho['fecha_segunda_senior'];
                    }
                    $temporalidad = "";
                    if($pago['fecha_pago'] <= $restriccion){
                      $temporalidad = "Puntual";
                    }else{
                      $temporalidad = "Impuntual";
                    }
					$acumMontoPrimerPago += $pago['monto_pago'];
					$acumEqvPrimerPago += $pago['equivalente_pago'];
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
					$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
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

		$sheetInicial->setCellValue('E'.$num, 'Monto: ');
		$sheetInicial->setCellValue('F'.$num, number_format($acumMontoPrimerPago,2,',','.'));
		$sheetInicial->setCellValue('G'.$num, 'Eqv: ');
		$sheetInicial->setCellValue('I'.$num, '$'.number_format($acumEqvPrimerPago,2,',','.'));

		

		$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(13);
		$sheetInicial->getStyle('A'.$num.':J'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CFCFCF');
		$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
		$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');
		$sheetInicial->getStyle('H'.$num)->getAlignment()->setHorizontal('right');
		$sheetInicial->getStyle('I'.$num)->getAlignment()->setHorizontal('right');
		$num++;

				$reportadoPrimer=0;
				$diferidoPrimer=0;
				$abonadoPrimer=0;
				foreach ($pagos as $data):
					if(!empty($data['id_pago'])):
						if($data['tipo_pago']=="Primer Pago"):
							if($data['estado']=="Abonado"){
								$reportadoPrimer += $data['equivalente_pago'];
								$abonadoPrimer += $data['equivalente_pago'];
							}
							else if($data['estado']=="Diferido"){
								$reportadoPrimer += $data['equivalente_pago'];
								$diferidoPrimer += $data['equivalente_pago'];
							}else{
								$reportadoPrimer += $data['equivalente_pago'];
								}
							endif;
						endif;
				endforeach;
			$sheetInicial->setCellValue('B'.$num, 'Reportado 1er.P.');
			$sheetInicial->setCellValue('C'.$num, 'Diferido 1er.P.');
			$sheetInicial->setCellValue('D'.$num, 'Abonado 1er.P.');
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(14);
			// $sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
			// $sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
			// $sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');

				$sheetInicial->getStyle('B'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCCCFF');
				$sheetInicial->getStyle('C'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCC');
				$sheetInicial->getStyle('D'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFCC');

			$num++;
			$sheetInicial->setCellValue('B'.$num, '$'.number_format($reportadoPrimer,2,',','.'));
			$sheetInicial->setCellValue('C'.$num, '$'.number_format($diferidoPrimer,2,',','.'));
			$sheetInicial->setCellValue('D'.$num, '$'.number_format($abonadoPrimer,2,',','.'));
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
			$sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
			$sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');
		$num++;
		$num++;
		$num++;









		$sheetInicial->setCellValue('B'.$num, 'Segundo Pago');
		$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(15);
		$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
		// $sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
		
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
		$num2=1;
		$acumMontoSegundoPago = 0;
		$acumEqvSegundoPago = 0;
		foreach ($pagos as $pago) {
			if($pago['id_pago']){
				if($pago['tipo_pago']=="Segundo Pago"){
					$bank = "";
					foreach ($bancos as $banco) {
						if(!empty($banco['id_banco'])){
							if($banco['id_banco']==$pago['id_banco']){
								$bank = $banco['nombre_banco']." - ".$banco['nombre_propietario'];
							}
						}
					}
					if($pago['tipo_pago']=="Contado"){
                      $restriccion = $despacho['fecha_inicial_senior'];
                    }
					if($pago['tipo_pago']=="Inicial"){
                      $restriccion = $despacho['fecha_inicial_senior'];
                    }
                    if($pago['tipo_pago']=="Primer Pago"){
                      $restriccion = $despacho['fecha_primera_senior'];
                    }
                    if($pago['tipo_pago']=="Segundo Pago"){
                      $restriccion = $despacho['fecha_segunda_senior'];
                    }
                    $temporalidad = "";
                    if($pago['fecha_pago'] <= $restriccion){
                      $temporalidad = "Puntual";
                    }else{
                      $temporalidad = "Impuntual";
                    }
					$acumMontoSegundoPago += $pago['monto_pago'];
					$acumEqvSegundoPago += $pago['equivalente_pago'];
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
					$reportado+=$pago['equivalente_pago'];
					if($pago['estado']=="Abonado"){
						$abonado+=$pago['equivalente_pago'];
						$sheetInicial->getStyle('A'.$num.':J'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('7744DD44');
					}
					if($pago['estado']=="Diferido"){
						$diferido+=$pago['equivalente_pago'];
						$sheetInicial->getStyle('A'.$num.':J'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('77DD4444');
					}
					$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');
					$sheetInicial->getStyle('H'.$num)->getAlignment()->setHorizontal('right');
					$sheetInicial->getStyle('I'.$num)->getAlignment()->setHorizontal('right');

					$num++;
					$num2++;
				}
			}
		}

			$sheetInicial->setCellValue('E'.$num, 'Monto: ');
			$sheetInicial->setCellValue('F'.$num, number_format($acumMontoSegundoPago,2,',','.'));
			$sheetInicial->setCellValue('G'.$num, 'Eqv: ');
			$sheetInicial->setCellValue('I'.$num, '$'.number_format($acumEqvSegundoPago,2,',','.'));
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(13);
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CFCFCF');
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');
			$sheetInicial->getStyle('H'.$num)->getAlignment()->setHorizontal('right');
			$sheetInicial->getStyle('I'.$num)->getAlignment()->setHorizontal('right');
			$num++;

				$reportadoSegundo=0;
				$diferidoSegundo=0;
				$abonadoSegundo=0;
				foreach ($pagos as $data):
					if(!empty($data['id_pago'])):
						if($data['tipo_pago']=="Segundo Pago"):
							if($data['estado']=="Abonado"){
								$reportadoSegundo += $data['equivalente_pago'];
								$abonadoSegundo += $data['equivalente_pago'];
							}
							else if($data['estado']=="Diferido"){
								$reportadoSegundo += $data['equivalente_pago'];
								$diferidoSegundo += $data['equivalente_pago'];
							}else{
								$reportadoSegundo += $data['equivalente_pago'];
								}
							endif;
						endif;
				endforeach;
			$sheetInicial->setCellValue('B'.$num, 'Reportado 2do.P.');
			$sheetInicial->setCellValue('C'.$num, 'Diferido 2do.P.');
			$sheetInicial->setCellValue('D'.$num, 'Abonado 2do.P.');
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(14);
			// $sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
			// $sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
			// $sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');

				$sheetInicial->getStyle('B'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCCCFF');
				$sheetInicial->getStyle('C'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFCCCC');
				$sheetInicial->getStyle('D'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CCFFCC');

			$num++;
			$sheetInicial->setCellValue('B'.$num, '$'.number_format($reportadoSegundo,2,',','.'));
			$sheetInicial->setCellValue('C'.$num, '$'.number_format($diferidoSegundo,2,',','.'));
			$sheetInicial->setCellValue('D'.$num, '$'.number_format($abonadoSegundo,2,',','.'));
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->getStyle('A'.$num.':J'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
			$sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
			$sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');

			$num++;
			$num++;





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
		// $write = new Writer\Xlsx($spreadsheet);
		// $exec = $write->save($this->file);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Reporte de Pagos Campaña '.$numCampana.'.xlsx"');
		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');

	}

	public function exportarReportedePagosExcel($dat, $lider){
		$mostrar = $dat['mostrar'];
		$general = $dat['general'];
		$despacho = $dat['despachos'];
		$mes = $dat['mes'];

		$numCampana = $despacho['numero_campana']."_".$despacho['anio_campana'];
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
			$sheetInicial->setCellValue('B'.$num, '$'.number_format($general['reportado'],2,',','.'));
			$sheetInicial->setCellValue('C'.$num, '$'.number_format($general['diferido'],2,',','.'));
			$sheetInicial->setCellValue('D'.$num, '$'.number_format($general['abonado'],2,',','.'));
			$sheetInicial->setCellValue('E'.$num, '$'.number_format($general['pendiente'],2,',','.'));
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
			$sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
			$sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');
			$sheetInicial->getStyle('E'.$num)->getFont()->getColor()->setRGB('5555FF');



			$num++;
			$num++;
			$num++;
			foreach ($mostrar as $reportss) {
				$report = $reportss['pagos'];
				$opcion = $reportss['opcion'];

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
				$sheetInicial->setCellValue('B'.$num, '$'.number_format($report['reportados'],2,',','.'));
				$sheetInicial->setCellValue('C'.$num, '$'.number_format($report['diferidos'],2,',','.'));
				$sheetInicial->setCellValue('D'.$num, '$'.number_format($report['abonados'],2,',','.'));
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
			}


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
			$sheetInicial->setCellValue('B'.$num, '$'.number_format($general['reportado'],2,',','.'));
			$sheetInicial->setCellValue('C'.$num, '$'.number_format($general['diferido'],2,',','.'));
			$sheetInicial->setCellValue('D'.$num, '$'.number_format($general['abonado'],2,',','.'));
			$sheetInicial->setCellValue('E'.$num, '$'.number_format($general['pendiente'],2,',','.'));
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->getStyle('A'.$num.':F'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
			$sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
			$sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');
			$sheetInicial->getStyle('E'.$num)->getFont()->getColor()->setRGB('5555FF');




		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Reporte de Pagos Campaña '.$numCampana.'.xlsx"');
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
