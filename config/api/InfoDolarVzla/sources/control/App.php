<?php 
	
	// if(is_file('sources/model/Binance.php')){ require_once'sources/model/Binance.php';}
	// if(is_file('sources/model/Telegram.php')){ require_once'sources/model/Telegram.php';}
	// if(is_file('vendor/autoload.php')){require_once'vendor/autoload.php';}

	// if(is_file('Binance.php')){ require_once'Binance.php'; }
	// if(is_file('../Binance.php')){ require_once'../Binance.php'; }
	// if(is_file('../../Binance.php')){ require_once'../../Binance.php'; }
	// if(is_file('model/Binance.php')){require_once'model/Binance.php';}
	// if(is_file('../vendor/autoload.php')){require_once'../vendor/autoload.php';}
	// if(is_file('../../vendor/autoload.php')){require_once'../../vendor/autoload.php';}


	class App{
		private $fechaActual;
		private $horaActual;
		private $horaActualSec;

		public function __construct(){
			$this->fechaActual = date('d/m/Y');
			$this->horaActual = date('H:i');
			$this->horaActualSec = date('H:i:s');
		}


		public function run(){
			try {
				$dolarParalelo = "https://exchangemonitor.net/estadisticas/ve/dolar-enparalelovzla";
				$monedaParalelo = "paralelo";
				$dolarBcv = "https://exchangemonitor.net/estadisticas/ve/dolar-bcv";
				$monedaBcv = "bcv";
				// $dolarPromedioColombia = "https://exchangemonitor.net/dolar-colombia";
				$dolarPromedioColombia = "https://exchangemonitor.net/estadisticas/divisas/COP";
				$monedaColombia = "dolarcolombia";

				$dolarPromedioArgentina = "https://exchangemonitor.net/estadisticas/divisas/ARS";
				$monedaArgentina = "dolarargentina";

				$this->ConsultarPrecio($dolarParalelo, $monedaParalelo);
				$this->ConsultarPrecio($dolarBcv, $monedaBcv);
				$this->ConsultarPrecio($dolarPromedioColombia, $monedaColombia);
				$this->ConsultarPrecio($dolarPromedioArgentina, $monedaArgentina);

				// if($this->horaActual >= "07:00" && $this->horaActual <= "09:30"){
				// 	$this->ConsultarPrecio($dolarParalelo, $monedaParalelo);
				// 	$this->ConsultarPrecio($dolarBcv, $monedaBcv);
				// }
				// if($this->horaActual >= "13:00" && $this->horaActual <= "13:30"){
				// 	$this->ConsultarPrecio($dolarParalelo, $monedaParalelo);
				// 	$this->ConsultarPrecio($dolarBcv, $monedaBcv);
				// }

				// $precioParalelo = ;
				$this->GuardarJsonPrecio($monedaParalelo, $this->LeerPrecio($monedaParalelo, "Venezuela"));
				$this->GuardarJsonPrecio($monedaBcv, $this->LeerPrecio($monedaBcv, "Venezuela"));
				$this->GuardarJsonPrecio($monedaColombia, $this->LeerPrecio($monedaColombia, "Colombia"));
				$this->GuardarJsonPrecio($monedaArgentina, $this->LeerPrecio($monedaArgentina, "Argentina"));
				// echo "<br>Monedas<br>";
				// echo "<br>Paralelo: <br>";
				// echo $this->LeerPrecio($monedaParalelo, "Venezuela");
				// echo "<br>";
				// echo "<br>";
				// echo "<br>BCV: <br>";
				// echo $this->LeerPrecio($monedaBcv, "Venezuela");
				// echo "<br>";
				// echo "<br>";
				// echo "<br>Colombia: <br>";
				// echo $this->LeerPrecio($monedaColombia, "Colombia");
				// echo "<br>";
				// die();
			} catch (Exception $e) {
				
			}
		}

		public function runz(){
			try {
				$dolarParalelo = "https://exchangemonitor.net/estadisticas/ve/dolar-enparalelovzla";
				$monedaParalelo = "paralelo";
				$dolarBcv = "https://exchangemonitor.net/estadisticas/ve/dolar-bcv";
				$monedaBcv = "bcv";
				// $dolarPromedioColombia = "https://exchangemonitor.net/dolar-colombia";
				$dolarPromedioColombia = "https://exchangemonitor.net/estadisticas/divisas/COP";
				$monedaColombia = "dolarcolombia";

				$dolarPromedioArgentina = "https://exchangemonitor.net/estadisticas/divisas/ARS";
				$monedaArgentina = "dolarargentina";

				$this->ConsultarPrecio($dolarParalelo, $monedaParalelo);
				$this->ConsultarPrecio($dolarBcv, $monedaBcv);
				$this->ConsultarPrecio($dolarPromedioColombia, $monedaColombia);
				$this->ConsultarPrecio($dolarPromedioArgentina, $monedaArgentina);

				// if($this->horaActual >= "07:00" && $this->horaActual <= "09:30"){
				// 	$this->ConsultarPrecio($dolarParalelo, $monedaParalelo);
				// 	$this->ConsultarPrecio($dolarBcv, $monedaBcv);
				// }
				// if($this->horaActual >= "13:00" && $this->horaActual <= "13:30"){
				// 	$this->ConsultarPrecio($dolarParalelo, $monedaParalelo);
				// 	$this->ConsultarPrecio($dolarBcv, $monedaBcv);
				// }

				// $precioParalelo = ;
				$this->GuardarJsonPrecioz($monedaParalelo, $this->LeerPrecio($monedaParalelo, "Venezuela"));
				$this->GuardarJsonPrecioz($monedaBcv, $this->LeerPrecio($monedaBcv, "Venezuela"));
				$this->GuardarJsonPrecioz($monedaColombia, $this->LeerPrecio($monedaColombia, "Colombia"));
				$this->GuardarJsonPrecioz($monedaArgentina, $this->LeerPrecio($monedaArgentina, "Argentina"));
				// echo "<br>Monedas<br>";
				// echo "<br>Paralelo: <br>";
				// echo $this->LeerPrecio($monedaParalelo, "Venezuela");
				// echo "<br>";
				// echo "<br>";
				// echo "<br>BCV: <br>";
				// echo $this->LeerPrecio($monedaBcv, "Venezuela");
				// echo "<br>";
				// echo "<br>";
				// echo "<br>Colombia: <br>";
				// echo $this->LeerPrecio($monedaColombia, "Colombia");
				// echo "<br>";
				// die();
			} catch (Exception $e) {
				
			}
		}

		private function GuardarJsonPrecio($moneda, $precio){
			$datos = file_get_contents("sources/file/".$moneda.".json");
			$jsonLoad = json_decode($datos, true);
			$fechaActual = $this->fechaActual;
			$horaActual = $this->horaActual;
			$precio = str_replace('.','',$precio);
			$precio = str_replace(',','.',$precio);
			$precio = (float) $precio;
			// $precio = number_format(floatval($precio),2);
			
			// for ($i=31; $i >= 1; $i--) { 
			// 	if($i<=9){
			// 		$fechaActual = "2021-12-0".$i;
			// 	}else{
			// 		$fechaActual = "2021-12-".$i;
			// 	}	
			// }

			// $fechaActual = "2022-01-02";
			// $horaActual = "19:10";

			if(!empty($jsonLoad['actual']['fecha']) && $jsonLoad['actual']['fecha']!=""){
					if($horaActual >= "07:00" && $horaActual < "13:00"){
						$fecha = $fechaActual;
						$jsonLoad['actual']['fecha'] = $fecha;
						$jsonLoad['actual']['precio']=$precio;
						$jsonLoad['actual']['turno']['dia']=$precio;
						$jsonLoad['actual']['turno']['tarde']="";
			
						$historial[$fecha]['dia']=$precio;
						$historial[$fecha]['tarde']="";

						if(!empty($jsonLoad['historial']) && $jsonLoad['historial']!=""){
							$historial[$fecha]['fecha']=$fecha;
							$historial[$fecha]['dia']=$precio;
							$historial[$fecha]['tarde']="";
							$x = $jsonLoad['historial'];
							$jsonLoad['historial'] = $historial;
							$jsonLoad['historial'] += $x;
						}else{
							$historial[$fecha]['fecha']=$fecha;
							$historial[$fecha]['dia']=$precio;
							$historial[$fecha]['tarde']="";
							$jsonLoad['historial'] = $historial;
						}
						// $jsonLoad['historial'][$fecha]['dia']=$precio;
						// $jsonLoad['historial'][$fecha]['tarde']="";
					}
					if($horaActual >= "13:00" || $horaActual < "07:00"){
						// echo "Aqui";
						$fecha = $jsonLoad['actual']['fecha'];
						$dia = $jsonLoad['actual']['turno']['dia'];
						$jsonLoad['actual']['fecha'] = $fecha;
						$jsonLoad['actual']['precio']=$precio;
						$jsonLoad['actual']['turno']['dia'] = $dia;
						$jsonLoad['actual']['turno']['tarde']=$precio;

						if(!empty($jsonLoad['historial']) && $jsonLoad['historial']!=""){
							$historial[$fecha]['fecha']=$fecha;
							$historial[$fecha]['dia']=$dia;
							$historial[$fecha]['tarde']=$precio;
							$x = $jsonLoad['historial'];
							$jsonLoad['historial'] = $historial;
							$jsonLoad['historial'] += $x;
						}else{
							$historial[$fecha]['fecha']=$fecha;
							$historial[$fecha]['dia']=$dia;
							$historial[$fecha]['tarde']=$precio;
							$jsonLoad['historial'] = $historial;
						}
						// $jsonLoad['historial'][$fecha]['dia']=$dia;
						// $jsonLoad['historial'][$fecha]['tarde']=$precio;
					}
			}
			else{
					// $jsonLoad['actual']['fecha']=$fechaActual;
					if($horaActual >= "07:00" && $horaActual < "13:00"){
						$fecha = $fechaActual;
						$jsonLoad['actual']['fecha'] = $fecha;
						$jsonLoad['actual']['precio']=$precio;
						$jsonLoad['actual']['turno']['dia']=$precio;
						$jsonLoad['actual']['turno']['tarde']="";


						if(!empty($jsonLoad['historial']) && $jsonLoad['historial']!=""){
							$historial[$fecha]['fecha']=$fecha;
							$historial[$fecha]['dia']=$precio;
							$historial[$fecha]['tarde']="";
							$x = $jsonLoad['historial'];
							$jsonLoad['historial'] = $historial;
							$jsonLoad['historial'] += $x;
						}else{
							$historial[$fecha]['fecha']=$fecha;
							$historial[$fecha]['dia']=$precio;
							$historial[$fecha]['tarde']="";
							$jsonLoad['historial'] = $historial;
						}
						// $jsonLoad['historial'][$fecha]['dia']=$precio;
						// $jsonLoad['historial'][$fecha]['tarde']="";
					}
					if($horaActual >= "13:00" || $horaActual < "07:00"){
						$fecha = $fechaActual;
						$dia = $jsonLoad['actual']['turno']['dia'];
						$jsonLoad['actual']['fecha'] = $fecha;
						$jsonLoad['actual']['precio']=$precio;
						$jsonLoad['actual']['turno']['dia'] = $dia;
						$jsonLoad['actual']['turno']['tarde']=$precio;

						if(!empty($jsonLoad['historial']) && $jsonLoad['historial']!=""){
							$historial[$fecha]['fecha']=$fecha;
							$historial[$fecha]['dia']=$dia;
							$historial[$fecha]['tarde']=$precio;
							$x = $jsonLoad['historial'];
							$jsonLoad['historial'] = $historial;
							$jsonLoad['historial'] += $x;
						}else{
							$historial[$fecha]['fecha']=$fecha;
							$historial[$fecha]['dia']=$dia;
							$historial[$fecha]['tarde']=$precio;
							$jsonLoad['historial'] = $historial;
						}
						// $jsonLoad['historial'][$fecha]['dia']=$dia;
						// $jsonLoad['historial'][$fecha]['tarde']=$precio;
					}
			}



			// echo json_encode($jsonLoad);
			$file = 'sources/file/'.$moneda.'.json';
			if(file_exists($file)){
				file_put_contents($file, json_encode($jsonLoad));
			}

			// echo "Guardado Dolar ".mb_strtoupper($moneda)." - Precio: ".$precio."<br>";
			echo "Guardado Dolar ".mb_strtoupper($moneda)."<br>";
		}

		private function GuardarJsonPrecioz($moneda, $precio){
			$datos = file_get_contents("sources/file/".$moneda.".json");
			$jsonLoad = json_decode($datos, true);
			$fechaActual = $this->fechaActual;
			$horaActual = $this->horaActual;
			$precio = str_replace('.','',$precio);
			$precio = str_replace(',','.',$precio);
			$precio = (float) $precio;
			// $precio = number_format(floatval($precio),2);
			
			// for ($i=31; $i >= 1; $i--) { 
			// 	if($i<=9){
			// 		$fechaActual = "2021-12-0".$i;
			// 	}else{
			// 		$fechaActual = "2021-12-".$i;
			// 	}	
			// }

			// $fechaActual = "2022-01-02";
			// $horaActual = "19:10";

			if(!empty($jsonLoad['actual']['fecha']) && $jsonLoad['actual']['fecha']!=""){
					if($horaActual >= "07:00" && $horaActual < "13:00"){
						$fecha = $fechaActual;
						$jsonLoad['actual']['fecha'] = $fecha;
						$jsonLoad['actual']['precio']=$precio;
						$jsonLoad['actual']['turno']['dia']=$precio;
						$jsonLoad['actual']['turno']['tarde']="";
			
						$historial[$fecha]['dia']=$precio;
						$historial[$fecha]['tarde']="";

						if(!empty($jsonLoad['historial']) && $jsonLoad['historial']!=""){
							$historial[$fecha]['fecha']=$fecha;
							$historial[$fecha]['dia']=$precio;
							$historial[$fecha]['tarde']="";
							$x = $jsonLoad['historial'];
							$jsonLoad['historial'] = $historial;
							$jsonLoad['historial'] += $x;
						}else{
							$historial[$fecha]['fecha']=$fecha;
							$historial[$fecha]['dia']=$precio;
							$historial[$fecha]['tarde']="";
							$jsonLoad['historial'] = $historial;
						}
						// $jsonLoad['historial'][$fecha]['dia']=$precio;
						// $jsonLoad['historial'][$fecha]['tarde']="";
					}
					if($horaActual >= "13:00" || $horaActual < "07:00"){
						// echo "Aqui";
						$fecha = $jsonLoad['actual']['fecha'];
						$dia = $jsonLoad['actual']['turno']['dia'];
						$jsonLoad['actual']['fecha'] = $fecha;
						$jsonLoad['actual']['precio']=$precio;
						$jsonLoad['actual']['turno']['dia'] = $dia;
						$jsonLoad['actual']['turno']['tarde']=$precio;

						if(!empty($jsonLoad['historial']) && $jsonLoad['historial']!=""){
							$historial[$fecha]['fecha']=$fecha;
							$historial[$fecha]['dia']=$dia;
							$historial[$fecha]['tarde']=$precio;
							$x = $jsonLoad['historial'];
							$jsonLoad['historial'] = $historial;
							$jsonLoad['historial'] += $x;
						}else{
							$historial[$fecha]['fecha']=$fecha;
							$historial[$fecha]['dia']=$dia;
							$historial[$fecha]['tarde']=$precio;
							$jsonLoad['historial'] = $historial;
						}
						// $jsonLoad['historial'][$fecha]['dia']=$dia;
						// $jsonLoad['historial'][$fecha]['tarde']=$precio;
					}
			}
			else{
					// $jsonLoad['actual']['fecha']=$fechaActual;
					if($horaActual >= "07:00" && $horaActual < "13:00"){
						$fecha = $fechaActual;
						$jsonLoad['actual']['fecha'] = $fecha;
						$jsonLoad['actual']['precio']=$precio;
						$jsonLoad['actual']['turno']['dia']=$precio;
						$jsonLoad['actual']['turno']['tarde']="";


						if(!empty($jsonLoad['historial']) && $jsonLoad['historial']!=""){
							$historial[$fecha]['fecha']=$fecha;
							$historial[$fecha]['dia']=$precio;
							$historial[$fecha]['tarde']="";
							$x = $jsonLoad['historial'];
							$jsonLoad['historial'] = $historial;
							$jsonLoad['historial'] += $x;
						}else{
							$historial[$fecha]['fecha']=$fecha;
							$historial[$fecha]['dia']=$precio;
							$historial[$fecha]['tarde']="";
							$jsonLoad['historial'] = $historial;
						}
						// $jsonLoad['historial'][$fecha]['dia']=$precio;
						// $jsonLoad['historial'][$fecha]['tarde']="";
					}
					if($horaActual >= "13:00" || $horaActual < "07:00"){
						$fecha = $fechaActual;
						$dia = $jsonLoad['actual']['turno']['dia'];
						$jsonLoad['actual']['fecha'] = $fecha;
						$jsonLoad['actual']['precio']=$precio;
						$jsonLoad['actual']['turno']['dia'] = $dia;
						$jsonLoad['actual']['turno']['tarde']=$precio;

						if(!empty($jsonLoad['historial']) && $jsonLoad['historial']!=""){
							$historial[$fecha]['fecha']=$fecha;
							$historial[$fecha]['dia']=$dia;
							$historial[$fecha]['tarde']=$precio;
							$x = $jsonLoad['historial'];
							$jsonLoad['historial'] = $historial;
							$jsonLoad['historial'] += $x;
						}else{
							$historial[$fecha]['fecha']=$fecha;
							$historial[$fecha]['dia']=$dia;
							$historial[$fecha]['tarde']=$precio;
							$jsonLoad['historial'] = $historial;
						}
						// $jsonLoad['historial'][$fecha]['dia']=$dia;
						// $jsonLoad['historial'][$fecha]['tarde']=$precio;
					}
			}



			// echo json_encode($jsonLoad);
			$file = 'sources/file/'.$moneda.'.json';
			if(file_exists($file)){
				file_put_contents($file, json_encode($jsonLoad));
			}

			// echo "Guardado Dolar ".mb_strtoupper($moneda)." - Precio: ".$precio."<br>";
			echo "Guardado Dolar ".mb_strtoupper($moneda)."\n";
		}

		private function ConsultarPrecio($url, $moneda){
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_HEADER, 0);
			$output = curl_exec($ch);
			curl_close($ch);
			$file = "sources/control/".$moneda.".php";
			if(file_exists($file)){
				file_put_contents($file, $output);
			}
		}

		private function LeerPrecio($moneda, $pais){
			$exchange = file_get_contents("sources/control/".$moneda.".php");
			$posILen = strlen('<meta name="description" content="');
			$posI = strpos($exchange, '<meta name="description" content="');
			$posF = strpos($exchange, '<meta name="keywords"');
			$string = substr($exchange, ($posI+$posILen), ($posF-$posI)-10);

			$posI2 = strpos($string, 'es de');
			$string2 = substr($string, ($posI2+6));
			if($pais == "Venezuela"){
				$posF2 = strpos($string2, 'BS');
			}else if($pais == "Colombia"){
				$posF2 = strpos($string2, 'COP');
			}else if($pais == "Argentina"){
				$posF2 = strpos($string2, 'ARS');
			}
			$precio = substr($string, ($posI2+6), $posF2-1);
			return $precio;
		}
		

	}

?>