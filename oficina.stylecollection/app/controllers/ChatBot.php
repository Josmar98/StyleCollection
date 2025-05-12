<?php 
	
	if(is_file('app/models/indexModelsss.php')){
		require_once'app/models/indexModelsss.php';
	}
	if(is_file('../app/models/indexModelsss.php')){
		require_once'../app/models/indexModelsss.php';
	}
    $lider2 = new Modelsss();
if(!empty($_POST)){
    $mensaje = $_POST['mensaje'];
    $fecha_operacion = date('Y-m-d H:i:s');
    $img = "";

    $TOKEN = "7518790072:AAEOeX9wIUn0Dzygbqy8dAa-e3jVWisR6IU";
    $webSite = "https://api.telegram.org/bot{$TOKEN}"; 
    $webSiteFile = "https://api.telegram.org/file/bot{$TOKEN}";
    // $url = "https://api.telegram.org/bot{TOKEN}/sendMessage?chat_id={id_chat}&parse_mode=HTML&text={urlencode($ variable_texto)}";
    $contactos = $lider2->consultarQuery("SELECT * FROM contact_bot WHERE estatus=1");
    $query = "INSERT INTO mensajes_bot (id_mensaje, texto_mensaje, img_mensaje, fecha_hora, estatus) VALUES (DEFAULT, '{$mensaje}', '{$img}', '{$fecha_operacion}', 1)";
    // echo $query."<br><br>";
    $registrar = $lider2->consultarQuery($query);
    // print_r($registrar);
    foreach($contactos as $con){
        if(!empty($con['id'])){
            $id_chat = $con['id'];
            $urlEnviar = $webSite."/sendMessage?chat_id={$id_chat}&parse_mode=HTML&text=".urlencode($mensaje);
            // echo "<BR><BR>";
            // echo $url;
            // echo "<BR><BR>";
            $exec = file_get_contents($urlEnviar);
            $result = json_decode($exec);
            if($result->ok==true){
                $response=1;
            }else{
                $response=2;
            }
        }
    }
    

    $chats = $lider2->consultarQuery("SELECT * FROM mensajes_bot");
    if(!empty($action)){
        if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
            require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
        }else{
            require_once 'public/views/error404.php';
        }
    }else{
        if (is_file('public/views/'.$url.'.php')) {
            require_once 'public/views/'.$url.'.php';
        }else{
            require_once 'public/views/error404.php';
        }
    }

}

if(empty($_POST)){
    $chats = $lider2->consultarQuery("SELECT * FROM mensajes_bot");
    if(!empty($action)){
        if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
            require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
        }else{
            require_once 'public/views/error404.php';
        }
    }else{
        if (is_file('public/views/'.$url.'.php')) {
            require_once 'public/views/'.$url.'.php';
        }else{
            require_once 'public/views/error404.php';
        }
    }

}


?>