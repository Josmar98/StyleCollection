<?php

session_start();
ini_set('date.timezone', 'america/caracas');
define('SERVERURL', 'StyleCollection');
define('ROOTURL', '/StyleCollection/oficina.stylecollection');
$fucsia = "#ED2A77";
$negro = "#000000";
$blanco = "#FFFFFF";
//"#2B73F7"
// 237
// 42
// 119
// echo "Tiempo: ".$_SESSION['timeLimiteSystem']."<br>";
// echo "ACTUAL: ".time()."<br>";
// echo "RESTO: ".(time() - $_SESSION['timeLimiteSystem'])."<br>";
$holas = "ajajajaja";
$color_btn_sweetalert = "#ED2A77";
if(isset($_SESSION['recuerdame'])){
	if($_SESSION['recuerdame']==0){
		$timeLimiteExits = 60*30;
		if(!isset($_SESSION['timeLimiteSystem'])){
			$_SESSION['timeLimiteSystem'] = time();
		}
		$resTime = time()-$_SESSION['timeLimiteSystem'];
		if($resTime > $timeLimiteExits){
			unset($_SESSION['cuenta']);
			unset($_SESSION['accesos']);
			unset($_SESSION['id_usuario']);
			unset($_SESSION['id_rol']);
			unset($_SESSION['nombre_rol']);
			unset($_SESSION['id_cliente']);
			unset($_SESSION['username']);
			unset($_SESSION['pass']);
			unset($_SESSION['system_style']);
			unset($_SESSION['admin1']);
			unset($_SESSION['recuerdame']);
			unset($_SESSION['timeLimiteSystem']);
			session_unset();
			session_destroy();
			header("location:./");
		}
	}
	$_SESSION['timeLimiteSystem'] = time();
}
// print_r(['arroz'=>'carmen']);
// print_r($_SESSION);
// define('SERVERURL', $_SERVER['REQUEST_URI']);
// $route = $_SERVER['REQUEST_URI'];
// $_SESSION['temaSystem'] = "Oscuro";
// $_SESSION['temaSystem'] = "Claro";

    $cantidadPagosDespachos = [
      0=> ['cantidad'=>1,   'name'=> "Primer Pago",   'id'=> "primer_pago"],
      1=> ['cantidad'=>2,   'name'=> "Segundo Pago",  'id'=> "segundo_pago"],
      2=> ['cantidad'=>3,   'name'=> "Tercer Pago",   'id'=> "tercer_pago"],
      3=> ['cantidad'=>4,   'name'=> "Cuarto Pago",   'id'=> "cuarto_pago"],
      4=> ['cantidad'=>5,   'name'=> "Quinto Pago",   'id'=> "quinto_pago"],
      5=> ['cantidad'=>6,   'name'=> "Sexto Pago",    'id'=> "sexto_pago"],
      6=> ['cantidad'=>7,   'name'=> "Septimo Pago",  'id'=> "septimo_pago"],
      7=> ['cantidad'=>8,   'name'=> "Octavo Pago",   'id'=> "octavo_pago"],
      8=> ['cantidad'=>9,   'name'=> "Noveno Pago",   'id'=> "noveno_pago"],
      9=> ['cantidad'=>10,  'name'=> "Decimo Pago",   'id'=> "decimo_pago"],
      // 10=> ['cantidad'=>11,  'name'=> "Onceavo Pago",   'id'=> "onceavo_pago"],
    ];
    $claveInicial = [
      0=> ['id' => "", 'name' => ""],
      1=> ['id' => "_senior", 'name' => "senior"],
    ];
    // $claveInicial[0] = ['id' => "", 'name' => ""];
    // $claveInicial[1] = ['id' => "_senior", 'name' => "senior"];

if(!empty($_SESSION['id_usuario']) && !empty($_SESSION['cuenta']) && !empty($_SESSION['system_style'])){
	$url = "Home";
	if(!empty($_GET['route'])){
		$url = $_GET['route'];
	}
	if(!empty($_GET['action'])){
		$action = $_GET['action'];
	}
	if(!empty($_GET['cod'])){
		$cod = $_GET['cod'];
	}
	if(!empty($_GET['id'])){
		$id = $_GET['id'];
	}
	$cuenta=$_SESSION['cuenta'];
	$accesos=$_SESSION['accesos'];
	if (is_file(__DIR__.'/app/controllers/index.php')) {
		require_once __DIR__.'/app/controllers/index.php';
    }else{
        require_once __DIR__.'public/views/error404.php';
    }

####En caso de que no exista petición vía GET
} else {
	$url = "login";
	if (is_file(__DIR__.'/app/controllers/index.php')) {
		require_once __DIR__.'/app/controllers/index.php';
    }else{
        require_once __DIR__.'public/views/error404.php';
    }
}


$TOKEN = "5611254788:AAFQ7POeRY3I1CXmiirkgrFwM-e8GsZfPoY";
$webSite = "https://api.telegram.org/bot{$TOKEN}";
$chatId = "-1001849900792";
$chatId = "1849900792";

$nameFile = "libs/backup/stylecollection_stylecollection";
$verificFile = "libs/backup/enviado.txt";
$nameFileC = "https://stylecollection.org/oficina.stylecollection/libs/backup/stylecollection_stylecollection";
	// $verificFile = "https://stylecollection.org/oficina.stylecollection/libs/backup/enviado.txt";
$date = date("d-m-Y");
$nameFileF = $nameFile."_".$date.".sql";
$nameFileFC = $nameFileC."_".$date.".sql";
$opEnviado = 0;
if(file_exists($verificFile)){
	$fp = fopen($verificFile,'r');
	$line = fgets($fp);
	fclose($fp);
	if(strlen($line)==0){
		$opEnviado = 0;
	}else{
		if($line==$date){
			$opEnviado = 1;
		}else{
			$opEnviado = 0;
		}
	}
}else{
	$opEnviado = 0;
}
echo $nameFileF;
echo "*".$opEnviado."*";
if(file_exists($nameFileF)){
echo "<br>";
echo $nameFileF;
echo "*".$opEnviado."*";
	if($opEnviado==0){
		echo "<br>";
		echo "ENVIAR";
		unlink($verificFile);
		$fp = fopen($verificFile,'w');
		fputs($fp, $date);
		fclose($fp);
		echo "asdasd";
		$result = sendDocument($chatId, $nameFileFC, "Probando");
		print_r($result);
	}else{
		// echo "Enviado";
	}
}else{
	// echo "NO EXISTS";
}


#==========================================================================================#
### ENVIAR DOCUMENTEO ###
#==========================================================================================#
function sendDocument($chatId, $urlDocument, $text="")
{
	global $webSite;
	$url = $webSite."/sendDocument?chat_id=".$chatId."&document=".$urlDocument."&caption=".urlencode($text)."";
	echo $url;
	return file_get_contents($url);
}