<?php 
	
	// if(is_file('app/models/indexModels.php')){
	// 	require_once'app/models/indexModels.php';
	// }
	// if(is_file('../app/models/indexModels.php')){
	// 	require_once'../app/models/indexModels.php';
	// }

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

function extraerCedula($banco){
		$n = $banco['cedula_cuenta'][0];
		if($n=="0"||$n=="1"||$n=="2"||$n=="3"||$n=="4"||$n=="5"||$n=="6"||$n=="7"||$n=="8"||$n=="9"){
			$cedula_cuenta = number_format($banco['cedula_cuenta'],0,'','.');
		}else{
			$n1 = str_replace(" ", "-", $banco['cedula_cuenta']);
			$n2 = strpos($banco['cedula_cuenta'], " ");
			$n3 = substr($banco['cedula_cuenta'], ($n2+1));
			$nx3 = substr($banco['cedula_cuenta'], 0, ($n2+1));
			$n4 = strpos($n3, " ");
			$n5 = substr($banco['cedula_cuenta'], ($n2+1),$n4);
			$nx5 = substr($n3, ($n4));
			$nCed = number_format($n5,0,'','.');
			$cedd = $nx3.$nCed.$nx5;
			$cedula_cuenta = str_replace(" ", "-", $cedd);
		}
	return $cedula_cuenta;
}

if(empty($_POST)){
	$banco = $lider->consultarQuery("SELECT * FROM bancos WHERE id_banco = {$id}");
	if($banco['ejecucion']){
		$banco = $banco[0];
		$cedula_cuenta = extraerCedula($banco);

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


?>