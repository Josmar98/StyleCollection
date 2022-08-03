<?php 
	
	if(is_file('sources/model/Binance.php')){ require_once'sources/model/Binance.php';}
	if(is_file('vendor/autoload.php')){require_once'vendor/autoload.php';}
	// if(is_file('Binance.php')){ require_once'Binance.php'; }
	// if(is_file('../Binance.php')){ require_once'../Binance.php'; }
	// if(is_file('../../Binance.php')){ require_once'../../Binance.php'; }
	// if(is_file('model/Binance.php')){require_once'model/Binance.php';}
	// if(is_file('../vendor/autoload.php')){require_once'../vendor/autoload.php';}
	// if(is_file('../../vendor/autoload.php')){require_once'../../vendor/autoload.php';}


	class App{

		private $binance;
		private $api;
		private $telegram;

		public function __construct(){
			$this->binance = new Binance();
			$this->api = new Binance\API($this->binance->getKeyAPI(), $this->binance->getSecretAPI());
		}

		public function run(){
			// $price = $this->api->prices();
			$this->binance->run();
		}


	}

?>