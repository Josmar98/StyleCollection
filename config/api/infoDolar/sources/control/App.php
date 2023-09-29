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

		private $valBot;

		private $monedasIdentific = ["ve"=>"Venezuela", "co"=>"Colombia", "ar"=>"Argentina"];

		public function __construct(){
			$this->fechaActual = date('d/m/Y');
			$this->horaActual = date('H:i');
			$this->horaActualSec = date('H:i:s');
		}


		public function run($bot=0){
			try {
				$this->valBot = $bot;

				$countrys=["venezuela"=>"ve", "colombia"=>"co", "argentina"=>"ar"];
				
				$rutas['ar'] = [
					0 => ['index'=>0, 'id'=>"dolar-blue", 'name'=>"Dólar Blue", 'codigo'=>"ARS", 'origin'=>"https://www.valordolarblue.com.ar/", 'icon'=>"https://exchangemonitor.net/img/ar/cotizacion/dolar-blue.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ar/dolar-blue" ],
					1 => ['index'=>1, 'id'=>"dolar-bolsa-mep", 'name'=>"Dólar Bolsa MEP", 'codigo'=>"ARS", 'origin'=>"https://www.invertironline.com/titulo/cotizacion/BCBA/AL30/BONO-REP.-ARGENTINA-USD-STEP-UP-2030/", 'icon'=>"https://exchangemonitor.net/img/ar/cotizacion/dolar-bolsa-mep.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ar/dolar-bolsa-mep" ],
					2 => ['index'=>2, 'id'=>"dolar-mayorista", 'name'=>"Dólar Mayorista", 'codigo'=>"ARS", 'origin'=>"https://www.bna.com.ar/Personas", 'icon'=>"https://exchangemonitor.net/img/ar/cotizacion/dolar-mayorista.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ar/dolar-mayorista" ],
					3 => ['index'=>3, 'id'=>"dolar-oficial", 'name'=>"Dólar Oficial", 'codigo'=>"ARS", 'origin'=>"https://www.invertironline.com/titulo/cotizacion/BCBA/AL30/BONO-REP.-ARGENTINA-USD-STEP-UP-2030/", 'icon'=>"https://exchangemonitor.net/img/ar/cotizacion/dolar-oficial.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ar/dolar-oficial-en-argentina" ],
					4 => ['index'=>4, 'id'=>"dolar-solidario", 'name'=>"Dólar Solidario", 'codigo'=>"ARS", 'origin'=>"", 'icon'=>"https://exchangemonitor.net/img/ar/cotizacion/dolar-solidario.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ar/dolar-solidario" ],
					5 => ['index'=>5, 'id'=>"dolar-tarjeta", 'name'=>"Dólar Tarjeta", 'codigo'=>"ARS", 'origin'=>"", 'icon'=>"https://exchangemonitor.net/img/ar/cotizacion/dolar-tarjeta.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ar/dolar-tarjeta" ],
					6 => ['index'=>6, 'id'=>"promedio", 'name'=>"Dólar EM", 'codigo'=>"ARS", 'origin'=>"https://exchangemonitor.net/estadisticas/ar/promedio", 'icon'=>"https://exchangemonitor.net/img/ve/exchangemonitor.webp", 'route'=>"https://exchangemonitor.net/dolar-promedio-argentina" ]
				];


				$rutas['co'] = [
					0 => ['index'=>0, 'id'=>"airtm", 'name'=>"AirTM", 'codigo'=>"COP", 'origin'=>"https://rates.airtm.com/", 'icon'=>"https://exchangemonitor.net/img/ve/general/airtm.webp", 'route'=>"https://exchangemonitor.net/estadisticas/co/dolar-airtm" ],
					1 => ['index'=>1, 'id'=>"binance", 'name'=>"Binance", 'codigo'=>"COP", 'origin'=>"https://www.binance.com/es", 'icon'=>"https://exchangemonitor.net/img/ve/general/binance.webp", 'route'=>"https://exchangemonitor.net/estadisticas/co/dolar-binance" ],
					2 => ['index'=>2, 'id'=>"localbitcoins", 'name'=>"LocalBitcoins", 'codigo'=>"COP", 'origin'=>"https://localbitcoins.com/es/", 'icon'=>"https://exchangemonitor.net/img/ve/general/localbitcoins.webp", 'route'=>"https://exchangemonitor.net/estadisticas/co/dolar-localbitcoins" ],
					3 => ['index'=>3, 'id'=>"monedero-paypal-nequi", 'name'=>"PayPal Nequi", 'codigo'=>"COP", 'origin'=>"https://www.nequi.com.co/2018/09/18/nequi-en-alianza-con-paypal/", 'icon'=>"https://exchangemonitor.net/img/co/monedero/paypal-nequi.webp", 'route'=>"https://exchangemonitor.net/estadisticas/co/dolar-paypal-nequi" ],
					4 => ['index'=>4, 'id'=>"paxful", 'name'=>"Paxful", 'codigo'=>"COP", 'origin'=>"https://paxful.com/es/", 'icon'=>"https://exchangemonitor.net/img/ve/general/paxful.webp", 'route'=>"https://exchangemonitor.net/estadisticas/co/dolar-paxful" ],
					5 => ['index'=>5, 'id'=>"promedio", 'name'=>"Dólar EM", 'codigo'=>"COP", 'origin'=>"https://es.tradingview.com/symbols/USDCOP/", 'icon'=>"https://exchangemonitor.net/img/ve/exchangemonitor.webp", 'route'=>"https://exchangemonitor.net/dolar-promedio-colombia" ],
					6 => ['index'=>6, 'id'=>"trm", 'name'=>"TRM", 'codigo'=>"COP", 'origin'=>"https://www.superfinanciera.gov.co/", 'icon'=>"https://exchangemonitor.net/img/co/principal/trm.webp", 'route'=>"https://exchangemonitor.net/estadisticas/co/dolar-trm-en-colombia" ],

					7 => ['index'=>7, 'id'=>"yadio", 'name'=>"Yadio", 'codigo'=>"COP", 'origin'=>"https://yadio.io/", 'icon'=>"https://exchangemonitor.net/img/ve/general/yadio.webp", 'route'=>"https://exchangemonitor.net/estadisticas/co/dolar-yadio" ],
				];

				$rutas['ve'] = [
					0 => ['index'=>0, 'id'=>"airtm", 'name'=>"AirTM", 'codigo'=>"BS", 'origin'=>"https://rates.airtm.com/", 'icon'=>"https://exchangemonitor.net/img/ve/general/airtm.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ve/dolar-airtm" ],
					1 => ['index'=>1, 'id'=>"bcv", 'name'=>"BCV", 'codigo'=>"BS", 'origin'=>"http://www.bcv.org.ve/", 'icon'=>"https://exchangemonitor.net/img/ve/nacional/bcv.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ve/dolar-bcv" ],
					2 => ['index'=>2, 'id'=>"binance", 'name'=>"Binance", 'codigo'=>"BS", 'origin'=>"https://www.binance.com/es", 'icon'=>"https://exchangemonitor.net/img/ve/general/binance.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ve/dolar-binance" ],
					3 => ['index'=>3, 'id'=>"dolartoday-btc", 'name'=>"DolarToday (BTC)", 'codigo'=>"BS", 'origin'=>"https://dolartoday.com/", 'icon'=>"https://exchangemonitor.net/img/ve/general/dolartoday-btc.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ve/dolartoday-btc" ],
					4 => ['index'=>4, 'id'=>"dolartoday", 'name'=>"DolarToday", 'codigo'=>"BS", 'origin'=>"https://dolartoday.com/", 'icon'=>"https://exchangemonitor.net/img/ve/general/dolartoday.webp", 'route'=>"https://exchangemonitor.net/dolartoday-monitor" ],
					5 => ['index'=>5, 'id'=>"enparalelovzla", 'name'=>"EnParaleloVzla", 'codigo'=>"BS", 'origin'=>"https://www.instagram.com/enparalelovzla/", 'icon'=>"https://exchangemonitor.net/img/ve/monitor-dolar.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ve/dolar-enparalelovzla" ],
					6 => ['index'=>6, 'id'=>"monedero-amazon", 'name'=>"Amazon Gift Card", 'codigo'=>"BS", 'origin'=>"https://www.amazon.es/", 'icon'=>"https://exchangemonitor.net/img/ve/monederos/amazon.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ve/dolar-amazon" ],
					7 => ['index'=>7, 'id'=>"monedero-paypal", 'name'=>"PayPal", 'codigo'=>"BS", 'origin'=>"https://www.paypal.com/ve/home", 'icon'=>"https://exchangemonitor.net/img/ve/monederos/paypal.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ve/dolar-paypal" ],
					8 => ['index'=>8, 'id'=>"monedero-skrill", 'name'=>"Skrill", 'codigo'=>"BS", 'origin'=>"https://www.skrill.com/es/", 'icon'=>"https://exchangemonitor.net/img/ve/monederos/skrill.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ve/dolar-skrill" ],
					9 => ['index'=>9, 'id'=>"monedero-zinli", 'name'=>"Zinli", 'codigo'=>"BS", 'origin'=>"https://www.zinli.com/", 'icon'=>"https://exchangemonitor.net/img/ve/monederos/zinli.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ve/dolar-zinli" ],
					10 => ['index'=>10, 'id'=>"monitor-dolar-vzla", 'name'=>"Monitor Dolar Vzla", 'codigo'=>"BS", 'origin'=>"https://monitordolarvzla.com/", 'icon'=>"https://exchangemonitor.net/img/ve/monitor-dolar-vzla.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ve/monitor-dolar-vzla" ],
					11 => ['index'=>11, 'id'=>"monitor-dolar", 'name'=>"Monitor Dolar Venezuela", 'codigo'=>"BS", 'origin'=>"https://exchangemonitor.net/monitor-dolar-venezuela", 'icon'=>"https://exchangemonitor.net/img/ve/monitor-dolar.webp", 'route'=>"https://exchangemonitor.net/monitor-dolar-venezuela" ],
					12 => ['index'=>12, 'id'=>"petro", 'name'=>"Petro", 'codigo'=>"BS", 'origin'=>"https://www.petro.gob.ve/", 'icon'=>"https://exchangemonitor.net/img/ve/nacional/petro.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ve/petro-venezuela" ],
					13 => ['index'=>13, 'id'=>"promedio", 'name'=>"Dólar EM", 'codigo'=>"BS", 'origin'=>"https://exchangemonitor.net/dolar-promedio-venezuela", 'icon'=>"https://exchangemonitor.net/img/ve/exchangemonitor.webp", 'route'=>"https://exchangemonitor.net/dolar-promedio-venezuela" ],
					14 => ['index'=>14, 'id'=>"reserve", 'name'=>"Reserve", 'codigo'=>"BS", 'origin'=>"https://reserve.org/", 'icon'=>"https://exchangemonitor.net/img/ve/general/reserve.webp", 'route'=>"https://exchangemonitor.net/estadisticas/ve/dolar-reserve" ]
				];
					
				$retsAR = 0;
				$countryAR = $countrys['argentina'];
				foreach ($rutas[$countryAR] as $data) {
					$ret = $this->ConsultarPrecio($countryAR, $data['route'], $data['id']);
					if($ret > 0){ $retsAR++; }
					$price = $this->LeerPrecio($countryAR, $data['id'], $data['codigo']);

					$price = str_replace('.','',$price);
					$price = str_replace(',','.',$price);
					$price = (float) $price;

					$rutas[$countryAR][$data['index']]['price'] = $price;
				}

				$retsCO = 0;
				$countryCO = $countrys['colombia'];
				foreach ($rutas[$countryCO] as $data) {
					$ret = $this->ConsultarPrecio($countryCO, $data['route'], $data['id']);
					if($ret > 0){ $retsCO++; }
					$price = $this->LeerPrecio($countryCO, $data['id'], $data['codigo']);
					$rutas[$countryCO][$data['index']]['price'] = $price;
				}

				$retsVE = 0;
				$countryVE = $countrys['venezuela'];
				foreach ($rutas[$countryVE] as $data) {
					$ret = $this->ConsultarPrecio($countryVE, $data['route'], $data['id']);
					if($ret > 0){ $retsVE++; }
					$price = $this->LeerPrecio($countryVE, $data['id'], $data['codigo']);
					$rutas[$countryVE][$data['index']]['price'] = $price; 
				}

				$this->GuardarApiData($countryAR, $rutas[$countryAR]);
				$this->GuardarApiData($countryCO, $rutas[$countryCO]);
				$this->GuardarApiData($countryVE, $rutas[$countryVE]);

			} catch (Exception $e) {
				
			}
		}

		private function GuardarApiData($country, $result){
			$jsonLoad = $result;
			$timeActual = time();
			// $timeActual = time()-(3600*7);
			$horaActual = date('H:i', $timeActual);
			$fechaActual = date("Y-m-d", $timeActual);
			if($horaActual>="00:00" && $horaActual < "07:00"){
				$fechaActual = date("Y-m-d", time()-(3600*9));
			}
			// echo "Fecha Actual: ".$fechaActual."<br>";
			// echo "Hora Actual: ".$horaActual."<br>";

			$source = "./sources/file/{$country}/";
			$cant = count($jsonLoad);			
			$cantSuccess = 0;
			foreach ($jsonLoad as $moneys) {
				$id = $moneys['id'];
				$sourceFile = $source.$id.".json";

				$encontro = 0;
				if(file_exists($sourceFile)){
					$hist = file_get_contents($sourceFile);
					if(strlen($hist) > 0){
						$encontro = 1;
					}
				}
				if($encontro==1){
					$jsonHist = json_decode($hist, true);
					if(!empty($jsonHist['historial'])){
						$historialAux = $jsonHist['historial'];
					}else{
						$historialAux = [];
					}
				}else{
					$historialAux = [];
				}

				$infoData['info']['id'] = $moneys['id'];
				$infoData['info']['name'] = $moneys['name'];
				$infoData['info']['code'] = $moneys['codigo'];
				$infoData['info']['origin'] = $moneys['origin'];
				$infoData['info']['icon'] = $moneys['icon'];

				$infoData['actual']['price'] = $moneys['price'];
				$infoData['actual']['fecha'] = $fechaActual;
				$infoData['actual']['abre'] = "";
				$infoData['actual']['cierra'] = "";
				
				if($horaActual>="07:00" && $horaActual < "13:00"){
					//TURNO DE LA MAÑANA
					$infoData['actual']['abre'] = $moneys['price'];
					if(empty($infoData['actual']['cierra'])){
						if(!empty($historialAux[$fechaActual])){
							if(!empty($historialAux[$fechaActual]['cierra'])){
								$infoData['actual']['cierra'] = $historialAux[$fechaActual]['cierra'];
							}
						}
					}
				}
				if($horaActual>="13:00" || $horaActual < "07:00"){
					//TURNO DE LA TARDE Y LA NOCHE
					if(empty($infoData['actual']['abre'])){
						// echo "<br><br>A ver<br><br>";
						if(!empty($historialAux[$fechaActual])){
							if(!empty($historialAux[$fechaActual]['abre'])){
								$infoData['actual']['abre'] = $historialAux[$fechaActual]['abre'];
							}
						}
					}
					$infoData['actual']['cierra'] = $moneys['price'];
				}

				$historial[$fechaActual]["fecha"] = $fechaActual;
				$historial[$fechaActual]["abre"] = $infoData['actual']['abre'];
				$historial[$fechaActual]["cierra"] = $infoData['actual']['cierra'];

				// $infoData['historial'][$fechaActual]["fecha"] = $fechaActual;
				// $infoData['historial'][$fechaActual]["abre"] = $infoData['actual']['abre'];
				// $infoData['historial'][$fechaActual]["cierra"] = $infoData['actual']['cierra'];

				$historialfinal = $historial + $historialAux;
				$infoData['historial'] = $historialfinal;

				// $resp = file_put_contents($sourceFile, json_encode(["data"=>$moneys['data']]));
				$resp = file_put_contents($sourceFile, json_encode($infoData));

				// echo "<hr>";
				// echo "<b>Logo: </b> <img style='width:25px;height:auto;' src='".$moneys['icon']."'><br>";
				// echo "<b>Nombre: </b>".$moneys['name']."<br>";
				// echo "<b>Precio: </b>".$moneys['price']."<br>";
				// print_r($infoData);

				if($resp>0){
					$cantSuccess++;
				}
			}

			if($cantSuccess==$cant){
				echo "Registro de Monedas de <b>{$this->monedasIdentific[$country]}</b> Actualizadas";
				$cantBackupSuccess = 0;
				foreach ($jsonLoad as $moneys) {
					$id = $moneys['id'];
					$sourceFile = $source.$id.".json";
					$sourceFileDest = $source.$id."-Backup.json";
					$res = copy($sourceFile, $sourceFileDest);
					if($res==1){
						$cantBackupSuccess++;
					}
				}
				
				if($cantBackupSuccess==$cant){
					echo " y Respaldadas";
				}else{
					echo " sin Respaldar";
				}
				if($this->valBot==1){
					echo "\n";
				}else{
					echo "<br>";
				}
			}else{
				echo "Ocurrio un error al actualizar las Monedas de <b>{$this->monedasIdentific[$country]}</b>";
				if($this->valBot==1){
					echo "\n";
				}else{
					echo "<br>";
				}
			}
		}

		private function ConsultarPrecio($country, $url, $moneda){
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_HEADER, 0);
			$output = curl_exec($ch);
			curl_close($ch); 

			$file = "sources/control/".$country."/".$moneda.".php";
			$ret = 0;
			if(file_exists($file)){
				$ret = file_put_contents($file, $output);
			}else{
				$f = fopen($file, 'w');
				fclose($f);
				if(file_exists($file)){
					$ret = file_put_contents($file, $output);
				}
			}
			// echo " / ".$file."<br>";
			return $ret;
		}

		private function LeerPrecio($country, $moneda, $pais){
			$exchange = file_get_contents("sources/control/".$country."/".$moneda.".php");
			$posILen = strlen('<h2>');
			$posI = strpos($exchange, '<h2>');
			$posF = strpos($exchange, '<small>');
			$precio = substr($exchange, ($posI+$posILen), ($posF-$posI)-$posILen);
			$precio = str_replace('.','',$precio);
			$precio = str_replace(',','.',$precio);
			$precio = (float) $precio;
			// $posILen = strlen('<meta name="description" content="');
			// $posI = strpos($exchange, '<meta name="description" content="');
			// $posF = strpos($exchange, '<meta name="keywords"');
			// $string = substr($exchange, ($posI+$posILen), ($posF-$posI)-10);
			// $posI2 = strpos($string, 'es de');
			// $string2 = substr($string, ($posI2+6));
			// $posF2 = strpos($string2, $pais);
			// $precio = substr($string, ($posI2+6), $posF2-1);
			return $precio;
		}
		

	}

?>