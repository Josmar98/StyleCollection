<?php 


	class Telegram{

		protected $token;
		protected $id;
		protected $url;
		protected $urlMsg;
		protected $msg;

		public function __construct(){
			// $this->token = "1642240807:AAGFgDG4c4SNMR8YeqF9uoHD6j-UJUoT1u8";
			// $this->id = "-1001368376450";
			$datos_telegram = file_get_contents("sources/file/telegram.json");
			$json_telegram = json_decode($datos_telegram, true);
			$this->token = $json_telegram['token'];
			$this->id = $json_telegram['id'];
			
			$this->url = "https://api.telegram.org/bot{$this->token}/";
			$this->urlMsg = "https://api.telegram.org/bot{$this->token}/sendMessage";
			$this->msg = "";
		}

		public function enviarTextTelegram($mensaje){
			$caption = "Mensajes de Prueba";
			$url = $this->url."sendMessage?chat_id=".$this->id;
			$post = $url."&parse_mode=HTML&text=$mensaje";
			// $response = file_get_contents($url."sendMessage?chat_id=".$id."&parse_mode=HTML&text=".$caption);

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_POST, 1); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$output = curl_exec($ch);
			curl_close($ch); 
			return $output;
		}


		public function enviarImgTelegram($img, $caption=""){
			$caption = $caption;
			// $caption = "Texto de Ejemplo";
			$photo = $img;
			// $photo = "./sources/img/image.jpg";
			$url = $this->url."sendPhoto?chat_id=".$this->id;
			$post = array('chat_id'=>$this->id,'photo'=>new CURLFile(realpath($photo)), 'parse_mode'=>"HTML", 'caption' => $caption);

			$ch = curl_init(); 
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:multipart/form-data"));
			curl_setopt($ch, CURLOPT_URL, $url); 
			curl_setopt($ch, CURLOPT_POST, 1); 
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			$output = curl_exec($ch);
			curl_close($ch); 
			return $output;
		}


		public function getToken(){
			return $this->token;
		}
		public function getId(){
			return $this->id;
		}
		public function getUrl(){
			return $this->url;
		}
		public function getUrlMsg(){
			return $this->urlMsg;
		}
		public function getMsg(){
			return $this->msg;
		}
	}


?>