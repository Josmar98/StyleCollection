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
		// parent::realizarConexion();
		// echo "***|". parent::getEstatusConexion() . "|***";
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

		$totalAcumMonto = 0;
		$totalAcumEqv = 0;
		$abonado = 0;
		$diferido = 0;
		$reportado = 0;
		$num2 = 1;
		if(!empty($_GET['lider'])){
			$cliente = $dat['clientes'][0];
			$num = 2;
			$sheetInicial->setCellValue('B'.$num, 'Líder');
			$sheetInicial->setCellValue('C'.$num, $cliente['primer_nombre']." ".$cliente['primer_apellido']);
			$sheetInicial->setCellValue('D'.$num, number_format($cliente['cedula'],0,',','.'));
			$sheetInicial->getStyle('B'.$num.':D'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('D59FD1');
			$sheetInicial->getStyle('A'.$num.':I'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
			
			$num++;
			$num++;
			$sheetInicial->setCellValue('B'.$num, 'Plan');
			$sheetInicial->setCellValue('C'.$num, 'Cantidad');
			$sheetInicial->setCellValue('D'.$num, 'Precio');
			$sheetInicial->setCellValue('E'.$num, 'Total');
			$sheetInicial->getStyle('B'.$num.':E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('9FD1D5');
			$sheetInicial->getStyle('A'.$num.':I'.$num)->getFont()->setBold(true)->setSize(13);
			$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
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
						$sheetInicial->getStyle('B'.$num.':E'.$num)->getAlignment()->setHorizontal('justify');
					}
				}
			}
			$num++;

			$sheetInicial->setCellValue('D'.$num, 'Total =');
			$sheetInicial->setCellValue('E'.$num, '$'.$acumTotalPrimerPago);
			$sheetInicial->getStyle('D'.$num.':E'.$num)->getFont()->setBold(true)->setSize(13);
			$sheetInicial->getStyle('D'.$num.':E'.$num)->getAlignment()->setHorizontal('justify');
			$sheetInicial->getStyle('B'.$num.':E'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');




			$num++;
			$num++;
		}else{

			$num = 3;
		}

		$sheetInicial->setCellValue('B'.$num, 'Inicial');
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getFont()->setBold(true)->setSize(15);
		// $sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
		
		$num++;
		$sheetInicial->setCellValue('A'.$num, 'N°');
		$sheetInicial->setCellValue('B'.$num, 'Fecha');
		$sheetInicial->setCellValue('C'.$num, 'Banco');
		$sheetInicial->setCellValue('D'.$num, 'Forma de Pago');
		$sheetInicial->setCellValue('E'.$num, 'Referencia');
		$sheetInicial->setCellValue('F'.$num, 'Monto');
		$sheetInicial->setCellValue('G'.$num, 'Tasa');
		$sheetInicial->setCellValue('H'.$num, 'Equivalente');
		$sheetInicial->setCellValue('I'.$num, 'Concepto');
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getFont()->setBold(true)->setSize(13);
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
		
		$num++;

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
                      $temporalidad = "Inpuntual";
                    }
					$acumMontoInicial += $pago['monto_pago'];
					$acumEqvInicial += $pago['equivalente_pago'];
					$totalAcumMonto += $pago['monto_pago'];
					$totalAcumEqv += $pago['equivalente_pago'];
					$sheetInicial->setCellValue('A'.$num, $num2);
					$sheetInicial->setCellValue('B'.$num, $lider->formatFecha($pago['fecha_pago'])." - ".$temporalidad);
					$sheetInicial->setCellValue('C'.$num, $bank);
					$sheetInicial->setCellValue('D'.$num, $pago['forma_pago']);
					$sheetInicial->setCellValue('E'.$num, $pago['referencia_pago']);
					$sheetInicial->setCellValue('F'.$num, number_format($pago['monto_pago'],2,',','.'));
					$sheetInicial->setCellValue('G'.$num, $pago['tasa_pago']);
					$sheetInicial->setCellValue('H'.$num, '$'.number_format($pago['equivalente_pago'],2,',','.'));
					$sheetInicial->setCellValue('I'.$num, $pago['tipo_pago']);
					$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
					$sheetInicial->getStyle('H'.$num)->getAlignment()->setHorizontal('right');
					$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');
					$reportado+=$pago['equivalente_pago'];
					if($pago['estado']=="Abonado"){
						$abonado+=$pago['equivalente_pago'];
						$sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('7744DD44');
					}
					if($pago['estado']=="Diferido"){
						$diferido+=$pago['equivalente_pago'];
						$sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('77DD4444');
					}
					
					$num++;
					$num2++;
				}
			}
		}

		$sheetInicial->setCellValue('E'.$num, 'Monto: ');
		$sheetInicial->setCellValue('F'.$num, number_format($acumMontoInicial,2,',','.'));
		$sheetInicial->setCellValue('G'.$num, 'Eqv: ');
		$sheetInicial->setCellValue('H'.$num, '$'.number_format($acumEqvInicial,2,',','.'));

		

		$sheetInicial->getStyle('A'.$num.':I'.$num)->getFont()->setBold(true)->setSize(13);
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CFCFCF');
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
		$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');
		$sheetInicial->getStyle('H'.$num)->getAlignment()->setHorizontal('right');
		$num++;
		$num++;
		$num++;


		$sheetInicial->setCellValue('B'.$num, 'Primer Pago');
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getFont()->setBold(true)->setSize(15);
		// $sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
		
		$num++;
		$sheetInicial->setCellValue('A'.$num, 'N°');
		$sheetInicial->setCellValue('B'.$num, 'Fecha');
		$sheetInicial->setCellValue('C'.$num, 'Banco');
		$sheetInicial->setCellValue('D'.$num, 'Forma de Pago');
		$sheetInicial->setCellValue('E'.$num, 'Referencia');
		$sheetInicial->setCellValue('F'.$num, 'Monto');
		$sheetInicial->setCellValue('G'.$num, 'Tasa');
		$sheetInicial->setCellValue('H'.$num, 'Equivalente');
		$sheetInicial->setCellValue('I'.$num, 'Concepto');
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getFont()->setBold(true)->setSize(13);
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
		
		$num++;

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
                      $temporalidad = "Inpuntual";
                    }
					$acumMontoPrimerPago += $pago['monto_pago'];
					$acumEqvPrimerPago += $pago['equivalente_pago'];
					$totalAcumMonto += $pago['monto_pago'];
					$totalAcumEqv += $pago['equivalente_pago'];
					$sheetInicial->setCellValue('A'.$num, $num2);
					$sheetInicial->setCellValue('B'.$num, $lider->formatFecha($pago['fecha_pago'])." - ".$temporalidad);
					$sheetInicial->setCellValue('C'.$num, $bank);
					$sheetInicial->setCellValue('D'.$num, $pago['forma_pago']);
					$sheetInicial->setCellValue('E'.$num, $pago['referencia_pago']);
					$sheetInicial->setCellValue('F'.$num, number_format($pago['monto_pago'],2,',','.'));
					$sheetInicial->setCellValue('G'.$num, $pago['tasa_pago']);
					$sheetInicial->setCellValue('H'.$num, '$'.number_format($pago['equivalente_pago'],2,',','.'));
					$sheetInicial->setCellValue('I'.$num, $pago['tipo_pago']);
					$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
					$sheetInicial->getStyle('H'.$num)->getAlignment()->setHorizontal('right');
					$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');
					$reportado+=$pago['equivalente_pago'];
					if($pago['estado']=="Abonado"){
						$abonado+=$pago['equivalente_pago'];
						$sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('7744DD44');
					}
					if($pago['estado']=="Diferido"){
						$diferido+=$pago['equivalente_pago'];
						$sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('77DD4444');
					}
					
					$num++;
					$num2++;
				}
			}
		}

		$sheetInicial->setCellValue('E'.$num, 'Monto: ');
		$sheetInicial->setCellValue('F'.$num, number_format($acumMontoPrimerPago,2,',','.'));
		$sheetInicial->setCellValue('G'.$num, 'Eqv: ');
		$sheetInicial->setCellValue('H'.$num, '$'.number_format($acumEqvPrimerPago,2,',','.'));

		

		$sheetInicial->getStyle('A'.$num.':I'.$num)->getFont()->setBold(true)->setSize(13);
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CFCFCF');
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
		$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');
		$sheetInicial->getStyle('H'.$num)->getAlignment()->setHorizontal('right');
		$num++;
		$num++;
		$num++;

		$sheetInicial->setCellValue('B'.$num, 'Segundo Pago');
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getFont()->setBold(true)->setSize(15);
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
		// $sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
		
		$num++;
		$sheetInicial->setCellValue('A'.$num, 'N°');
		$sheetInicial->setCellValue('B'.$num, 'Fecha');
		$sheetInicial->setCellValue('C'.$num, 'Banco');
		$sheetInicial->setCellValue('D'.$num, 'Forma de Pago');
		$sheetInicial->setCellValue('E'.$num, 'Referencia');
		$sheetInicial->setCellValue('F'.$num, 'Monto');
		$sheetInicial->setCellValue('G'.$num, 'Tasa');
		$sheetInicial->setCellValue('H'.$num, 'Equivalente');
		$sheetInicial->setCellValue('I'.$num, 'Concepto');
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getFont()->setBold(true)->setSize(13);
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('9FD5D1');
		$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
		
		$num++;

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
                      $temporalidad = "Inpuntual";
                    }
					$acumMontoSegundoPago += $pago['monto_pago'];
					$acumEqvSegundoPago += $pago['equivalente_pago'];
					$totalAcumMonto += $pago['monto_pago'];
					$totalAcumEqv += $pago['equivalente_pago'];
					$sheetInicial->setCellValue('A'.$num, $num2);
					$sheetInicial->setCellValue('B'.$num, $lider->formatFecha($pago['fecha_pago'])." - ".$temporalidad);
					$sheetInicial->setCellValue('C'.$num, $bank);
					$sheetInicial->setCellValue('D'.$num, $pago['forma_pago']);
					$sheetInicial->setCellValue('E'.$num, $pago['referencia_pago']);
					$sheetInicial->setCellValue('F'.$num, number_format($pago['monto_pago'],2,',','.'));
					$sheetInicial->setCellValue('G'.$num, $pago['tasa_pago']);
					$sheetInicial->setCellValue('H'.$num, '$'.number_format($pago['equivalente_pago'],2,',','.'));
					$sheetInicial->setCellValue('I'.$num, $pago['tipo_pago']);
					$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
					$reportado+=$pago['equivalente_pago'];
					if($pago['estado']=="Abonado"){
						$abonado+=$pago['equivalente_pago'];
						$sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('7744DD44');
					}
					if($pago['estado']=="Diferido"){
						$diferido+=$pago['equivalente_pago'];
						$sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('77DD4444');
					}
					$sheetInicial->getStyle('H'.$num)->getAlignment()->setHorizontal('right');
					$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');

					$num++;
					$num2++;
				}
			}
		}

			$sheetInicial->setCellValue('E'.$num, 'Monto: ');
			$sheetInicial->setCellValue('F'.$num, number_format($acumMontoSegundoPago,2,',','.'));
			$sheetInicial->setCellValue('G'.$num, 'Eqv: ');
			$sheetInicial->setCellValue('H'.$num, '$'.number_format($acumEqvSegundoPago,2,',','.'));
			$sheetInicial->getStyle('A'.$num.':I'.$num)->getFont()->setBold(true)->setSize(13);
			$sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('CFCFCF');
			$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');
			$sheetInicial->getStyle('H'.$num)->getAlignment()->setHorizontal('right');

			$num++;
			$num++;

			$sheetInicial->setCellValue('E'.$num, 'Monto: ');
			$sheetInicial->setCellValue('F'.$num, number_format($totalAcumMonto,2,',','.'));
			$sheetInicial->setCellValue('G'.$num, 'Total: ');
			$sheetInicial->setCellValue('H'.$num, '$'.number_format($totalAcumEqv,2,',','.'));
			$sheetInicial->getStyle('E'.$num)->getFont()->setBold(true)->setSize(12);
			$sheetInicial->getStyle('F'.$num)->getFont()->setBold(true)->setSize(14);
			$sheetInicial->getStyle('G'.$num)->getFont()->setBold(true)->setSize(12);
			$sheetInicial->getStyle('H'.$num)->getFont()->setBold(true)->setSize(14);


			$sheetInicial->getStyle('A'.$num.':I'.$num)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('A9A9A9');
			$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
			$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');
			$sheetInicial->getStyle('H'.$num)->getAlignment()->setHorizontal('right');

			$num++;

			if(!empty($_GET['lider']) && $_GET['route']=="Pagos"){
				$sheetInicial->setCellValue('E'.$num, 'Responsabilidad: ');
				$sheetInicial->setCellValue('F'.$num, '$'.number_format($nuevoTotal,2,',','.'));
				$sheetInicial->getStyle('E'.$num)->getFont()->setBold(true)->setSize(12);
				$sheetInicial->getStyle('F'.$num)->getFont()->setBold(true)->setSize(14);
				$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
				$sheetInicial->getStyle('F'.$num)->getAlignment()->setHorizontal('right');
			
				$sheetInicial->setCellValue('G'.$num, 'Resta: ');
				$sheetInicial->setCellValue('H'.$num, '$'.number_format($nuevoTotal-$abonado,2,',','.'));
				$sheetInicial->getStyle('G'.$num)->getFont()->setBold(true)->setSize(13);
				$sheetInicial->getStyle('H'.$num)->getFont()->setBold(true)->setSize(15);
				$sheetInicial->getStyle('G'.$num.':H'.$num)->getFont()->getColor()->setRGB('FF0000');
				$sheetInicial->getStyle('H'.$num)->getAlignment()->setHorizontal('right');
			}			

			$num++;

			$sheetInicial->setCellValue('B'.$num, 'Reportado');
			$sheetInicial->setCellValue('C'.$num, 'Diferido');
			$sheetInicial->setCellValue('D'.$num, 'Abonado');
			$sheetInicial->getStyle('A'.$num.':I'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->getStyle('B'.$num)->getFont()->getColor()->setRGB('0000FF');
			$sheetInicial->getStyle('C'.$num)->getFont()->getColor()->setRGB('FF0000');
			$sheetInicial->getStyle('D'.$num)->getFont()->getColor()->setRGB('00FF00');
			$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');

			$num++;
			$sheetInicial->setCellValue('B'.$num, '$'.number_format($reportado,2,',','.'));
			$sheetInicial->setCellValue('C'.$num, '$'.number_format($diferido,2,',','.'));
			$sheetInicial->setCellValue('D'.$num, '$'.number_format($abonado,2,',','.'));
			$sheetInicial->getStyle('A'.$num.':I'.$num)->getFont()->setBold(true)->setSize(15);
			$sheetInicial->getStyle('A'.$num.':I'.$num)->getAlignment()->setHorizontal('center');
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

	//**********************************************************************************************************************************************************
	//Escribir
	// public function EscribirExcel($page, $file){
	// 	if(parent::getEstatusConexion()){
	// 		try {
				
	// 			$this->file = $file;
	// 			$spreadsheet = new Spreadsheet();

	// 			$filas = ['filI'=> '1', 'filF' => ''];
	// 			$colum = ['colI'=> 'A', 'colF' => ''];

	// 			$data = self::LeerExcel($page, $filas, $colum, "bd");
	// 			if(!empty($data['EstatusExecute'])){
	// 				$x = 0;
	// 				$query = "INSERT INTO registro_personas (id, nombre, apellido, edad, sexo, descripcion) VALUES(DEFAULT,:nom, :ape, :edad, :sex, :des)";
	// 				$strExe = parent::prepare($query);
	// 				foreach ($data as $dat) {
	// 					if(!empty($dat[0])){
	// 							if(!empty($dat[0])){
	// 								$strExe->bindValue(":nom",$dat[0]);
	// 							}else{
	// 								$strExe->bindValue(":nom","");									
	// 							}
	// 							if(!empty($dat[1])){
	// 								$strExe->bindValue(":ape",$dat[1]);
	// 							}else{
	// 								$strExe->bindValue(":ape","");									
	// 							}
	// 							if(!empty($dat[2])){
	// 								$strExe->bindValue(":edad",$dat[2]);
	// 							}else{
	// 								$strExe->bindValue(":edad","");									
	// 							}
	// 							if(!empty($dat[3])){
	// 								$strExe->bindValue(":sex",$dat[3]);
	// 							}else{
	// 								$strExe->bindValue(":sex","");									
	// 							}
	// 							if(!empty($dat[4])){
	// 								$strExe->bindValue(":des",$dat[4]);
	// 							}else{
	// 								$strExe->bindValue(":des","");									
	// 							}
	// 							$strExe->execute();
	// 					}
	// 					$x++;
	// 				}
	// 			}

	// 			echo '<br><br><br>'."Ejecucion Correcta";
	// 		} catch (Exception $e) {
	// 			print_r($e);
	// 		}
	// 	}
	// }
	// public function mostrarRegistros(){
	// 	if (parent::getEstatusConexion()) {
	// 		$strSql = "SELECT * FROM registro_personas";
	// 		$respuestaArreglo = '';
	// 		try {
	// 			$strExec = Conexion::prepare($strSql);
	// 			$strExec->execute();
	// 			$respuestaArreglo = $strExec->fetchAll();
	// 			$respuestaArreglo += ['estatus' => true];
	// 		} catch (PDOException $e) {
	// 			$errorReturn = ['estatus' => false];
	// 			$errorReturn += ['info' => "error sql:{$e}"];
	// 			return $errorReturn;
	// 		}
	// 		return $respuestaArreglo;
	// 	} else {
	// 		$errorReturn = ['estatus' => false];
	// 		$errorReturn += ['info' => 'error sql: Conexion Cerrada. Contacte al Soporte.'];

	// 		return $errorReturn;
	// 	}
	// }
	//**********************************************************************************************************************************************************


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
