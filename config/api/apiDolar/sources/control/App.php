<?php 

	class App{
		private $fechaActual;
		private $horaActual;
		private $horaActualSec;

		private $api_user;
		private $api_token;

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
	
				$this->api_user="JOSMAR_200322";
				$this->api_token = "SvdXZdlPfu7gXTIARF7k";
				$countrys=["venezuela"=>"ve", "colombia"=>"co", "argentina"=>"ar"];

				$idsVenezuela = ["bcv", "enparalelovzla", "promedio", "monitor-dolar", "monitor-dolar-vzla", "dolartoday", "dolartoday-btc", "monedero-paypal", "monedero-zinli", "monedero-skrill", "monedero-amazon", "petro", "airtm", "binance", "reserve"];

				$idsArgentina = ["promedio", "dolar-blue", "dolar-oficial", "dolar-mayorista", "dolar-solidario", "dolar-tarjeta", "dolar-bolsa-mep"];

				$idsColombia = ["promedio", "trm", "paxful", "monedero-paypal-nequi", "binance", "airtm", "localbitcoins"];
				// $uri = "https://exchangemonitor.net/api/co?user=JOSMAR_200322&token=SvdXZdlPfu7gXTIARF7k";
				


				// $dolarParalelo = "https://exchangemonitor.net/estadisticas/ve/dolar-enparalelovzla";

				// $monedaParalelo = "paralelo";
				// $dolarBcv = "https://exchangemonitor.net/estadisticas/ve/dolar-bcv";
				// $monedaBcv = "bcv";

				// $dolarPromedioColombia = "https://exchangemonitor.net/estadisticas/divisas/COP";
				// $monedaColombia = "dolarcolombia";

				// $dolarPromedioArgentina = "https://exchangemonitor.net/estadisticas/divisas/ARS";
				// $monedaArgentina = "dolarargentina";

				// $resultVe = $this->ConsultarApi($countrys['venezuela']);
				// $resultVe1 = $this->GuardarApiData($countrys['venezuela'], $resultVe, $idsVenezuela);
				
				$this->GuardarApiData($countrys['venezuela'], $this->ConsultarApi($countrys['venezuela']), $idsVenezuela);

				$this->GuardarApiData($countrys['colombia'], $this->ConsultarApi($countrys['colombia']), $idsColombia);

				$this->GuardarApiData($countrys['argentina'], $this->ConsultarApi($countrys['argentina']), $idsArgentina);
				

			} catch (Exception $e) {
				
			}
		}

		private function ConsultarApi($country){
			$uri = "https://exchangemonitor.net/api/{$country}?user={$this->api_user}&token={$this->api_token}";
			// echo $uri;
			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $uri); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_HEADER, 0);
			$output = curl_exec($ch);
			curl_close($ch); 

			// $uri = "pruebaAPI".$country.".json";
			// $output = file_get_contents($uri);
			return $output;
		}
		private function GuardarApiData($country, $result, $ids){
			$jsonLoad = json_decode($result, true);
			$timeActual = time();
			// $timeActual = time()-(3600*7);
			$horaActual = date('H:i', $timeActual);
			$fechaActual = date("Y-m-d", $timeActual);
			if($horaActual>="00:00" && $horaActual < "09:00"){
				$fechaActual = date("Y-m-d", time()-(3600*9));
			}
			// echo "Fecha Actual: ".$fechaActual."<br>";
			// echo "Hora Actual: ".$horaActual."<br>";
			// echo "Petición N°: ".$jsonLoad['calls']."<br><br>";

			$source = "./sources/file/{$country}/";
			$cantVe = count($jsonLoad['data']);
			
			$cantidadIds = count($ids);
			$cantSuccess = 0;

			$numPeticion = $jsonLoad['calls'];
			foreach ($jsonLoad['data'] as $moneys) {
				foreach($ids as $id){
					if($moneys['id']==$id){

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
							$historialAux = $jsonHist['historial'];
						}else{
							$historialAux = [];
						}

						$infoData['info']['id'] = $moneys['id'];
						$infoData['info']['name'] = $moneys['name'];
						$infoData['info']['origin'] = $moneys['origin'];
						$infoData['info']['icon'] = $moneys['icon'];

						$infoData['actual']['price'] = $moneys['data']['rate'];
						$infoData['actual']['fecha'] = $fechaActual;
						$infoData['actual']['abre'] = "";
						$infoData['actual']['cierra'] = "";
						
						if($horaActual>="09:00" && $horaActual < "13:00"){
							//TURNO DE LA MAÑANA
							$infoData['actual']['abre'] = $moneys['data']['rate'];
							if(empty($infoData['actual']['cierra'])){
								if(!empty($historialAux[$fechaActual])){
									if(!empty($historialAux[$fechaActual]['cierra'])){
										$infoData['actual']['cierra'] = $historialAux[$fechaActual]['cierra'];
									}
								}
							}
						}
						if($horaActual>="13:00" || $horaActual < "09:00"){
							//TURNO DE LA TARDE Y LA NOCHE
							if(empty($infoData['actual']['abre'])){
								// echo "<br><br>A ver<br><br>";
								if(!empty($historialAux[$fechaActual])){
									if(!empty($historialAux[$fechaActual]['abre'])){
										$infoData['actual']['abre'] = $historialAux[$fechaActual]['abre'];
									}
								}
							}
							$infoData['actual']['cierra'] = $moneys['data']['rate'];
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
						// echo "<b>Precio: </b>".$moneys['data']['rate']."<br>";
						// print_r($infoData);

						if($resp>0){
							$cantSuccess++;
						}
					}
				}
			}
			if($cantSuccess==$cantidadIds){
				echo "Peticion N° {$numPeticion} - Registro de Monedas de <b>{$this->monedasIdentific[$country]}</b> Actualizadas";
				$cantBackupSuccess = 0;
				foreach ($jsonLoad['data'] as $moneys) {
					foreach($ids as $id){
						if($moneys['id']==$id){
							$sourceFile = $source.$id.".json";
							$sourceFileDest = $source.$id."-Backup.json";
							$res = copy($sourceFile, $sourceFileDest);
							if($res==1){
								$cantBackupSuccess++;
							}
						}
					}
				}
				
				if($cantBackupSuccess==$cantidadIds){
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
				echo "Peticion N° {$numPeticion} - Ocurrio un error al actualizar las Monedas de <b>{$this->monedasIdentific[$country]}</b>";
				if($this->valBot==1){
					echo "\n";
				}else{
					echo "<br>";
				}
			}
		}
	}

?>