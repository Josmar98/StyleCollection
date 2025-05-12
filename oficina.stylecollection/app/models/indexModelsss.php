<?php 

	if(is_file('config/database2.php')){
		require_once'config/database2.php';
	}
	else if(is_file('../config/database2.php')){
		require_once'../config/database2.php';
	}


	class Modelsss extends Conexion2{
		private $id_liderazgo;
		private $nombreLiderazgo;
		private $minimaCantidad;
		private $maximaCantidad;
		private $descuentoColeccion;
		private $totalDescuento;

		public function setIdLiderazgo($val){$this->id_liderazgo = $val;}
		public function setNombreLiderazgo($val){$this->nombreLiderazgo = $val;}
		public function setMinimaCantidad($val){$this->minimaCantidad = $val;}
		public function setMaximaCantidad($val){$this->maximaCantidad = $val;}
		public function setDescuentoColeccion($val){$this->descuentoColeccion = $val;}
		public function setTotalDescuento($val){$this->totalDescuento = $val;}

		public function getIdLiderazgo(){ return $this->id_liderazgo;}
		public function getNombreLiderazgo(){ return $this->nombreLiderazgo;}
		public function getMinimaCantidad(){ return $this->minimaCantidad;}
		public function getMaximaCantidad(){ return $this->maximaCantidad;}
		public function getDescuentoColeccion(){ return $this->descuentoColeccion;}
		public function getTotalDescuento(){ return $this->totalDescuento;}

		public function __construct(){Conexion2::realizarConexion();}

		public function registrar($query, $table, $id){
			if(Conexion2::getEstatusConexion()){
				try{
					$strExe = Conexion2::prepare($query);
					$strExe->execute();
					$this->id = Conexion2::getLastId($table,$id);
					return ['ejecucion' => true, 'id'=>$this->id];
				}catch(PDOException $e){
					return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '.$e];
					// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
					// echo "El Error es: ".$e;
				}
			}else{
					return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '.$e];
				// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
			}
		}

		public function consultar($table){
			if(Conexion2::getEstatusConexion()){
				$query = "SELECT * FROM $table WHERE estatus = 1";
				try{
					$strExe = Conexion2::prepare($query);
					$strExe->execute();
					$todo = $strExe->fetchAll();
					$todo += ['ejecucion'=>true];
					if(!empty($todo[0])){
						return $todo;
					}else{
						return ['ejecucion'=>true];
					}

				}catch(PDOException $e){
					return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '.$e];
					// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
					// echo "El Error es: ".$e;
				}
			}else{
					return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>"];
				// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
			}
		}
		public function consultarQuery($query){
			if(Conexion2::getEstatusConexion()){
				try{
					$strExe = Conexion2::prepare($query);
					$strExe->execute();
					$todo = $strExe->fetchAll();
					$todo += ['ejecucion'=>true];
					if(!empty($todo[0])){
						return $todo;
					}else{
						return ['ejecucion'=>true];
					}

				}catch(PDOException $e){
					return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '.$e];
					// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
					// echo "El Error es: ".$e;
				}
			}else{
					return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>"];
				// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
			}
		}

		public function modificar($query){
			if(Conexion2::getEstatusConexion()){
				try{
					$strExe = Conexion2::prepare($query);
					$strExe->execute();
					return ['ejecucion'=>true];
				}catch(PDOException $e){
					return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '.$e];
					// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
					// echo "El Error es: ".$e;
				}
			}else{
					return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>"];
				// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
			}
		}

		public function eliminar($query){
			if(Conexion2::getEstatusConexion()) {
				// $query = "DELETE FROM personas WHERE cedula = :ci";
				try{
					$strExe = Conexion2::prepare($query);
					// $strExe->bindValue(":ci",$this->cedula);
					$strExe->execute();
					return ['ejecucion'=>true];
				}catch(PDOException $e){
					return ['ejecucion'=>false, 'message'=>"Error en la ejecucion de sentencia SQL<br>", 'detalle'=> '<br><br>Error: '.$e];
					// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
					// echo "El Error es: ".$e;
				}
			}else{
					return ['ejecucion'=>false, 'message'=>"Error en la Conexion a la DB, Contacte el Soporte<br>", 'detalle'=> '<br><br>Error: '.$e];
				// echo "Error en la Conexion a la DB, Contacte el Soporte<br>";
			}
		}
		public function formatFecha($val){
			$fecha = $val;
			$year = substr($fecha, 0, 4);
			$month = substr($fecha, 5, 2);
			$day = substr($fecha, 8, 2);
	  		$fecha = $day."-".$month."-".$year;
	  		return $fecha;
		}
		public function formatFechaExtract($val){
			$fecha = $val;
			$year = substr($fecha, 0, 4);
			$month = substr($fecha, 5, 2);
			$day = substr($fecha, 8, 2);
	  		// $fecha = $day."-".$month."-".$year;
	  		$data = ['year'=>$year, 'month'=>$month, 'day'=>$day];
	  		return $data;
		}
		public function formatFechaInver($val){
			$fecha = $val;
			$day = substr($fecha, 0, 2);
            $month = substr($fecha, 3, 2);
            $year = substr($fecha, 6, 4);
	  		$fecha = $year."-".$month."-".$day;
	  		return $fecha;
		}

		public function formatDateExcel($val){
			$excelDate = $val;
            $unixDate = ($excelDate - 25569) * 86400;
            $excelDate = 25569 + ($unixDate / 86400);
            $unixDate = ($excelDate - 25569) * 86400;
            $dateActual = gmdate('d-m-Y', $unixDate);
            return $dateActual;
		}




		// public function LeerExcel($page, $filas, $colum, $opt){

		// 	$reader = IOFactory::createReader($this->format);
		// 	$load = $reader->load($this->file);
			
		// 	if(!empty($page)){
		// 		if(gettype($page) == "integer"){ 	$sheet = $load->getSheet($page);	}
		// 		if(gettype($page) == "string"){	$sheet = $load->getSheetByName($page);	}
		// 	}else{	$sheet = $load->getSheet(0);	}

		// 	if(!empty($opt)){	
		// 		if($opt == 'vector' || $opt == 0){	$tipo = 'vector';	}
		// 		if($opt == 'matriz' || $opt == 1){	$tipo = 'matriz';	}
		// 		if($opt == 'indexado' || $opt == 2){	$tipo = 'indexado';	}
		// 	}else{	$tipo = 'vector';	}


		// 	$i = 1;
		// 	$j = 0;
		// 	$k = 0;
		// 	$datas = ['EstatusExecute'=> true];
		// 	$data = [];
		// 	foreach ($sheet->getRowIterator($filas['filI'], $filas['filF']) as $row) {
		// 		$cellIterator = $row->getCellIterator($colum['colI'], $colum['colF']);
		// 		$cellIterator->setIterateOnlyExistingCells(false);
		// 		$j = 0;
		// 		$dataa = [];
		// 		foreach ($cellIterator as $cell) {
		// 			if(!is_null($cell)){
		// 				// $value = $cell->getValue(); // Resultados que estan visualizados
		// 				$value = $cell->getCalculatedValue(); // Resultados con formulas y todo

		// 				if($tipo == 'vector'){
		// 					$index = $this->cols[$j].$i;
		// 					$data += [$index => $value];
		// 				}
		// 				if($tipo=='matriz'){
		// 					$dataa += [$this->cols[$j] => $value];
		// 				}
		// 				if($tipo == "indexado"){
		// 					$index = $this->cols[$j].$i;
		// 					$dataa += [$j => array("index"=>$index, 'value' =>$value)];
		// 				}
		// 			}
		// 			$j++;
		// 		}
		// 		if($tipo =='matriz'){
		// 			$data += [$i => $dataa];
		// 		}
		// 		if($tipo =='indexado'){
		// 			$data += [$k => $dataa];
		// 		}
		// 		$i++;
		// 		$k++;
		// 	}
		// 	$datas += $data;
		// 	return $datas;


		// }






	}

?>