<?php


if(is_file('../../app/models/modelsIndex.php')){
	require_once '../../app/models/modelsIndex.php';
}

$lider = new Models();


$TOKEN = "1642240807:AAGFgDG4c4SNMR8YeqF9uoHD6j-UJUoT1u8";
$webSite = "https://api.telegram.org/bot{$TOKEN}"; 
$webSiteFile = "https://api.telegram.org/file/bot{$TOKEN}"; 

// $input = file_get_contents($webSite."/getUpdates");
$input = file_get_contents("php://input");
$update = json_decode($input, TRUE);


#==========================================================================================#
### RECIBE COMANDO O PETICION ###
#==========================================================================================#

$chatId = $update['message']['chat']['id'];
$firstName = $update['message']['chat']['first_name'];
$lastName = $update['message']['chat']['last_name'];
$userName = $update['message']['chat']['username'];
$language = $update['message']['from']['language_code'];

$typeCommand = "";
if(!empty($update['message']['text'])){
	$typeCommand = "text";
	$command = $update['message']['text'];
}
else if(!empty($update['message']['photo'])){
	$typeCommand = "photo";
	$command = $update['message']['photo'];
	$caption = "";
	if(!empty($update['message']['caption'])){
		$caption = $update['message']['caption'];
	}
}

if($typeCommand=="text"){
	switch (mb_strtolower($command)) {
		case '/start': {
			$response = "Iniciado";
			$r = sendMessage($chatId, $response);
			// sendMessage($chatId, $r);
			break;
		}
		case '/stop': {
			$response = "Detenido";
			$r = sendMessage($chatId, $response);
			// sendMessage($chatId, $r);
			break;
		}

		case '/loadapi': {
			$response = "Cargando . . .";
			$r = sendMessage($chatId, $response);
			
			$urlWeb = "https://stylecollection.org/config/api/InfoDolarVzla/index2.php";
			$rsp = file_get_contents($urlWeb);
			$response = "Resultado API : \n".$rsp;
			$r = sendMessage($chatId, $response);

			// sendMessage($chatId, $r);
			break;
		}

		case '/reloadapi': {
			$response = "Cargando . . .";
			$r = sendMessage($chatId, $response);
			
			$urlWeb = "https://stylecollection.org/config/api/infoDolar/index2.php";
			$rsp = file_get_contents($urlWeb);
			$response = "Resultado API : \n".$rsp;
			$r = sendMessage($chatId, $response);

			// sendMessage($chatId, $r);
			break;
		}

		case '/apirefresh': {
			$response = "Cargando . . .";
			$r = sendMessage($chatId, $response);
			
			$urlWeb = "https://stylecollection.org/config/api/apiDolar/index2.php";
			$rsp = file_get_contents($urlWeb);
			$response = "Resultado API : \n".$rsp;
			$r = sendMessage($chatId, $response);

			// sendMessage($chatId, $r);
			break;
		}

		case '/info': {
			$response = "Hola, soy un Bot de ayuda de Josmar, Programador";
			$r = sendMessage($chatId, $response);
			// sendMessage($chatId, $r);
			break;
		}

		case '/help': {
			$response = "Escribe /start : para iniciar el bot. \n";
			$response .= "Escribe /stop : para detener el bot. \n";
			$response .= "Escribe /info : para solicitar informacion del bot. \n";
			$response .= "Escribe /foto : para solicitar una foto. \n";
			if($userName == "AnonymousZonic"){
				$response .= "Escribe /loadApi : para actualizar registro del API. \n";
				$response .= "Escribe /reloadapi : para actualizar registro del API mas completo. \n";
				$response .= "Escribe /apirefresh : para actualizar registro del API con API exchange. \n";
			}
			$r = sendMessage($chatId, $response);
			// sendMessage($chatId, $r);
			break;
		}

		case '/foto': {
			$response = "Enviando Foto";
			$r = sendMessage($chatId, $response);

			$img = "https://stylecollection.org/public/assets/img/logo.jpg";
			$r = sendPhoto($chatId, $img);
			// sendMessage($chatId, $r);
			break;
		}
		
		default: {
			$response = "No te he entendido, puedes probar a colocar '/help' para ver los comandos que puedes usar.";
			$r = sendMessage($chatId, $response);
			// sendMessage($chatId, $r);
			break;
		}
	}
}

if($typeCommand=="photo"){
	if(mb_strtolower($caption) == "/guardar"){
		foreach ($command as $key) {
			$file_id = $key['file_id'];
		}
		$response = getPhoto($file_id);
		$file_path = $response->result->file_path;
		savePhoto($file_path);
		sendMessage($chatId, "Imagen guardada");
	}
	else{
		sendMessage($chatId, "Imagen recibida, pero no se hara nada con ella");
	}
}




#==========================================================================================#
### ENVIAR MENSAJE ###
#==========================================================================================#
function sendMessage($chatId, $text)
{
	global $webSite;
	$url = $webSite."/sendMessage?chat_id=".$chatId."&parse_mode=HTML&text=".urlencode($text)."";
	return file_get_contents($url);
}

#==========================================================================================#
### ENVIAR FOTO ###
#==========================================================================================#
function sendPhoto($chatId, $urlImage, $text="")
{
	global $webSite;
	$url = $webSite."/sendPhoto?chat_id=".$chatId."&photo=".$urlImage;
	if($text!=""){
		$url .= "&caption=".urlencode($text)."";
	}
	return file_get_contents($url);
}


#==========================================================================================#
### ENVIAR VIDEO ###
#==========================================================================================#
function sendVideo($chatId, $urlVideo, $text="")
{
	global $webSite;
	$url = $webSite."/webSite?chat_id=".$chatId."&video=".$urlVideo."&caption=".urlencode($text)."";
	return file_get_contents($url);
}



#==========================================================================================#
### ENVIAR DOCUMENTEO ###
#==========================================================================================#
function sendDocument($chatId, $urlDocument, $text="")
{
	global $webSite;
	$url = $webSite."/sendDocument?chat_id=".$chatId."&document=".$urlDocument."&caption=".urlencode($text)."";
	return file_get_contents($url);
}



#==========================================================================================#
### ENVIAR AUDIO ###
#==========================================================================================#
function sendAudio($chatId, $urlAudio, $text="")
{
	global $webSite;
	$url = $webSite."/sendAudio?chat_id=".$chatId."&audio=".$urlAudio."&caption=".urlencode($text)."";
	return file_get_contents($url);
}


#==========================================================================================#
### OBTENER PHOTO ###
#==========================================================================================#
function getPhoto($file_id)
{
	global $webSite;
	$url = $webSite."/getFile?file_id=".$file_id;
	$response = file_get_contents($url);
	return json_decode($response);
}

function savePhoto($file_path)
{
	global $webSiteFile;
	$file = $webSiteFile."/".$file_path;

	$file_path2 = substr($file_path, 0+7);
	$pos = strpos($file_path2, ".");
	$ext = substr($file_path2, $pos);
	$name = substr($file_path2, 0, $pos);
	
	return copy($file, "./imgapi/".$name.$ext);
}



?>