<?php 

	class Binance{
		
      protected $keyAPI;
   	protected $secretAPI;

      public function __construct(){
         $datos_binance = file_get_contents("sources/file/binance.json");
         $json_binances = json_decode($datos_binance, true);
         $this->keyAPI = $json_binances['api_key'];
         $this->secretAPI = $json_binances['api_secret'];
      }


   	public function getKeyApi(){
   		return $this->keyAPI;
   	}
   	public function getSecretApi(){
   		return $this->secretAPI;
   	}
	}

?>