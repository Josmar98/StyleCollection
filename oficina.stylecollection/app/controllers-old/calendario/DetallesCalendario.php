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
	$input = $lider->formatFechaInver($id);
	$festividades = $lider->consultarQuery("SELECT * FROM calendario, festividades WHERE calendario.fecha_calendario = festividades.fecha_festividad and festividades.fecha_festividad='{$input}'");
	$tasas = $lider->consultarQuery("SELECT * FROM tasa WHERE tasa.estatus = 1 and tasa.fecha_tasa = '{$input}'");

	if(count($festividades)>1 || count($tasas)>1){
		if(count($festividades)>1){
			$festividad = $festividades[0];
			switch ($festividad['mes_calendario']) {
				case '01': $mes = "Enero";
					break;
				case '02': $mes = "Febrero";
					break;
				case '03': $mes = "Marzo";
					break;
				case '04': $mes = "Abril";
					break;
				case '05': $mes = "Mayo";
					break;
				case '06': $mes = "Junio";
					break;
				case '07': $mes = "Julio";
					break;
				case '08': $mes = "Agosto";
					break;
				case '09': $mes = "Septiembre";
					break;
				case '10': $mes = "Octubre";
					break;
				case '11': $mes = "Noviembre";
					break;
				case '12': $mes = "Diciembre";
					break;
			}
		}
		if(count($tasas)>1){
			$tasa = $tasas[0];
			$diaTasa = substr($id, 0, 2);
			$mesTasa = substr($id, 3, 2);
			$yearTasa = substr($id, 6, 4);
			switch ($mesTasa) {
				case '01': $mesTasa = "Enero";
					break;
				case '02': $mesTasa = "Febrero";
					break;
				case '03': $mesTasa = "Marzo";
					break;
				case '04': $mesTasa = "Abril";
					break;
				case '05': $mesTasa = "Mayo";
					break;
				case '06': $mesTasa = "Junio";
					break;
				case '07': $mesTasa = "Julio";
					break;
				case '08': $mesTasa = "Agosto";
					break;
				case '09': $mesTasa = "Septiembre";
					break;
				case '10': $mesTasa = "Octubre";
					break;
				case '11': $mesTasa = "Noviembre";
					break;
				case '12': $mesTasa = "Diciembre";
					break;
			}
		}
		

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