<?php 
require_once 'config/database.php';
require_once 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer;
use PhpOffice\PhpSpreadsheet\Reader;

class Excel extends Conexion{
	private $file;
	private $format;
	public	$cols = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "AA", "AB", "AC", "AD", "AE", "AF", "AG", "AH", "AI", "AJ", "AK", "AL", "AM", "AN", "AO", "AP", "AQ", "AR", "AS", "AT", "AU", "AV", "AW", "AX", "AY", "AZ"];

	public function __construct($ruta, $format){
		$this->file = $ruta;
		$this->format = $format;
		parent::realizarConexion();
		// echo "***|". parent::getEstatusConexion() . "|***";
	}

	//**********************************************************************************************************************************************************
	//Escribir
	public function EscribirExcel($page, $file){
		if(parent::getEstatusConexion()){
			try {
				
				$this->file = $file;
				$spreadsheet = new Spreadsheet();

				$filas = ['filI'=> '1', 'filF' => ''];
				$colum = ['colI'=> 'A', 'colF' => ''];

				$data = self::LeerExcel($page, $filas, $colum, "bd");
				if(!empty($data['EstatusExecute'])){
					$x = 0;
					$query = "INSERT INTO clientes (id_c, nombre, apellido, edad, sexo, descripcion) VALUES(DEFAULT,:nom, :ape, :edad, :sex, :des)";
					$strExe = parent::prepare($query);
					foreach ($data as $dat) {
						if(!empty($dat[0])){
								if(!empty($dat[0])){
									$strExe->bindValue(":nom",$dat[0]);
								}else{
									$strExe->bindValue(":nom","");									
								}
								if(!empty($dat[1])){
									$strExe->bindValue(":ape",$dat[1]);
								}else{
									$strExe->bindValue(":ape","");									
								}
								if(!empty($dat[2])){
									$strExe->bindValue(":edad",$dat[2]);
								}else{
									$strExe->bindValue(":edad","");									
								}
								if(!empty($dat[3])){
									$strExe->bindValue(":sex",$dat[3]);
								}else{
									$strExe->bindValue(":sex","");									
								}
								if(!empty($dat[4])){
									$strExe->bindValue(":des",$dat[4]);
								}else{
									$strExe->bindValue(":des","");									
								}
								$strExe->execute();
						}
						$x++;
					}
				}

				echo '<br><br><br>'."Ejecucion Correcta";
			} catch (Exception $e) {
				print_r($e);
			}
		}
	}
	public function mostrarRegistros(){
		if (parent::getEstatusConexion()) {
			$strSql = "SELECT * FROM registro_personas";
			$respuestaArreglo = '';
			try {
				$strExec = Conexion::prepare($strSql);
				$strExec->execute();
				$respuestaArreglo = $strExec->fetchAll();
				$respuestaArreglo += ['estatus' => true];
			} catch (PDOException $e) {
				$errorReturn = ['estatus' => false];
				$errorReturn += ['info' => "error sql:{$e}"];
				return $errorReturn;
			}
			return $respuestaArreglo;
		} else {
			$errorReturn = ['estatus' => false];
			$errorReturn += ['info' => 'error sql: Conexion Cerrada. Contacte al Soporte.'];

			return $errorReturn;
		}
	}
	//**********************************************************************************************************************************************************

	public function ExportarPagosExcel(){
		echo "KAKAKA";
	}

	public function LeerExcel($page, $filas, $colum, $opt){
		//*****************************************************************************************************************************************************
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
