<?php


if(is_file('../../app/models/modelsIndex.php')){
	require_once '../../app/models/modelsIndex.php';
}

$lider = new Models();

$TOKEN = "7518790072:AAEOeX9wIUn0Dzygbqy8dAa-e3jVWisR6IU";
$webSite = "https://api.telegram.org/bot{$TOKEN}"; 
$webSiteFile = "https://api.telegram.org/file/bot{$TOKEN}";
$url = "https://api.telegram.org/bot{TOKEN}/sendMessage?chat_id={id_chat}&parse_mode=HTML&text={urlencode($ variable_texto)}";
echo $url;
// return file_get_contents($url);

// echo "https://api.telegram.org/bot{$TOKEN}/setwebhook?url=";


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

saveChat($lider, $chatId, $firstName, $lastName, $userName, $language);

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
	// switch (mb_strtolower($command)) {
	// 	case '/start': {
	// 		$response = "Iniciado para {$userName} con id: {$chatId}, nombre: {$firstName} {$lastName}";
	// 		$r = sendMessage($chatId, $response);
	// 		// sendMessage($chatId, $r);
	// 		break;
	// 	}
	// 	case '/stop': {
	// 		$response = "Detenido";
	// 		$r = sendMessage($chatId, $response);
	// 		// sendMessage($chatId, $r);
	// 		break;
	// 	}


	// 	case '/info': {
	// 		$response = "Hola, soy un Bot de ayuda de Josmar, Programador";
	// 		$r = sendMessage($chatId, $response);
	// 		// sendMessage($chatId, $r);
	// 		break;
	// 	}

	// 	case '/help': {
	// 		$response = "Escribe /start : para iniciar el bot. \n";
	// 		$response .= "Escribe /stop : para detener el bot. \n";
	// 		$response .= "Escribe /info : para solicitar informacion del bot. \n";
	// 		$response .= "Escribe /foto : para solicitar una foto. \n";
	// 		$r = sendMessage($chatId, $response);
	// 		// sendMessage($chatId, $r);
	// 		break;
	// 	}

	// 	case '/foto': {
	// 		$response = "Enviando Foto";
	// 		$r = sendMessage($chatId, $response);

	// 		$img = "https://stylecollection.org/public/assets/img/logo.jpg";
	// 		$r = sendPhoto($chatId, $img);
	// 		// sendMessage($chatId, $r);
	// 		break;
	// 	}
		
	// 	default: {
	// 		$response = "No te he entendido, puedes probar a colocar '/help' para ver los comandos que puedes usar.";
	// 		$r = sendMessage($chatId, $response);
	// 		// sendMessage($chatId, $r);
	// 		break;
	// 	}
	// }
}


if($typeCommand=="photo"){
	// if(mb_strtolower($caption) == "/guardar"){
	// 	foreach ($command as $key) {
	// 		$file_id = $key['file_id'];
	// 	}
	// 	$response = getPhoto($file_id);
	// 	$file_path = $response->result->file_path;
	// 	savePhoto($file_path);
	// 	sendMessage($chatId, "Imagen guardada");
	// }
	// else{
	// 	sendMessage($chatId, "Imagen recibida, pero no se hara nada con ella");
	// }
}



function saveChat($lider, $chatId, $firstName, $lastName, $userName, $language){
	$query = "SELECT * FROM contact_bot WHERE id='{$chatId}'";
	$busqueda = $lider->consultarQuery($query);
	if(count($busqueda)>1){}else{
		$lvl = "ST01";
		$query = "INSERT INTO contact_bot (id, first_name, last_name, username, lang, lvl, estatus) VALUES ('{$chatId}','{$firstName}','{$lastName}','{$userName}','{$language}','$lvl', 1)";
		$response = $lider->registrar($query, 'contact_bot', 'id');
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