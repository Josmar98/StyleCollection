<?php 

require_once'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
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

	//**********************************************************************************************************************************************************
	//Escribir
	public function EscribirExcel($page, $info){

		$spreadsheet = new Spreadsheet();

		$filas = ['filI'=> '1', 'filF' => ''];
		$colum = ['colI'=> 'A', 'colF' => ''];

		$obj = new Excel($this->file, "Xlsx");
		$data = $obj->LeerExcel($page, $filas, $colum, 2);
		if(!empty($data['EstatusExecute'])){
			$x = 0;
			print_r($data);
			foreach ($data as $dat) {
				if(!empty($dat[0])){
					foreach ($dat as $key) {
						$spreadsheet->getActiveSheet()->setCellValue($key['index'], $key['value']);
					}
				}
				$x++;
			}
		}
		foreach ($info as $key) {
			$cell = $key['col'].$x; 
			$spreadsheet->getActiveSheet()->setCellValue($cell, $key['value']);
		}
		$writer = new Writer\Xlsx($spreadsheet);
		$writer->save($this->file);
	}
	//**********************************************************************************************************************************************************


	public function LeerExcel($page, $filas, $colum, $opt){
	//**********************************************************************************************************************************************************
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
				}
				$j++;
			}
			if($tipo =='matriz'){
				$data += [$i => $dataa];
			}
			if($tipo =='indexado'){
				$data += [$k => $dataa];
			}
			$i++;
			$k++;
		}
		$datas += $data;
		return $datas;

	//**********************************************************************************************************************************************************

	}

}
