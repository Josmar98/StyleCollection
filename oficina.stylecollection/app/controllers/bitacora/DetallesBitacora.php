<?php 
	
$amBitacora = 0;
$amBitacoraC = 0;
foreach ($accesos as $access) {
if(!empty($access['id_acceso'])){
  if($access['nombre_modulo'] == "Bitácora"){
    $amBitacora = 1;
    if($access['nombre_permiso'] == "Ver"){
      $amBitacoraC = 1;
    }
  }
}
}
if($amBitacoraC == 1){

		function separateDatosCuentaTel($num){
			// echo $num[0];
			// echo strlen($num);
			$set = 0;
			$newNum = '';
			for ($i=0; $i < strlen($num); $i++) { 
				if($i==4){
					$newNum .= '-';
				}
				if($i==7){
					$newNum .= '-';
				}
				if($i==9){
					$newNum .= '-';
				}
				$newNum .= $num[$i];
			}
			return $newNum;
		}
		function separateDatosCuenta($num){
			// echo $num[0];
			// echo strlen($num);
			$set = 0;
			$newNum = '';
			for ($i=0; $i < strlen($num); $i++) { 
				if(($i%4)==0 && $i>0){
					$newNum .= '-';
				}
				$newNum .= $num[$i];
			}
			return $newNum;
		}

		if(empty($_POST)){
			$bitacora = $lider->consultarQuery("SELECT * FROM bitacora WHERE id_bitacora = {$id}");
			if($bitacora['ejecucion']){
				$bitacora = $bitacora[0];
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
			}else{
			    require_once 'public/views/error404.php';
			}
		}
}else{
    require_once 'public/views/error404.php';
}


?>