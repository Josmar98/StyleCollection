<?php 
	
	
// $amBitacora = 0;
// $amBitacoraC = 0;
// foreach ($accesos as $access) {
// if(!empty($access['id_acceso'])){
//   if($access['nombre_modulo'] == "Bitácora"){
//     $amBitacora = 1;
//     if($access['nombre_permiso'] == "Ver"){
//       $amBitacoraC = 1;
//     }
//   }
// }
// }
// if($amBitacoraC == 1){


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

	if(!empty($_POST['fechaFestiva'])){
		$resp = [];
		$input = $_POST['input'];
		$resp['fecha'] = $input;
		$input = $lider->formatFechaInver($input);
		$fechas = $lider->consultarQuery("SELECT * FROM calendario, festividades WHERE calendario.fecha_calendario = festividades.fecha_festividad and festividades.fecha_festividad='{$input}'");
		$festividades = $lider->consultarQuery("SELECT * FROM calendario, festividades WHERE calendario.fecha_calendario = festividades.fecha_festividad and festividades.fecha_festividad='{$input}'");
		$tasas = $lider->consultarQuery("SELECT * FROM tasa WHERE tasa.estatus = 1 and tasa.fecha_tasa = '{$input}'");

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
			$resp['execFestividad'] = "1";
			$resp['festividad']['mes'] = $mes;
			$resp['festividad']['evento'] = $festividad;
		}else{
			$resp['execFestividad'] = "2";
		}
		if(count($tasas)>1){
			$tasa = $tasas[0];
			$yearTasa = substr($input, 0, 4);
			$mesTasa = substr($input, 5, 2);
			$diaTasa = substr($input, 8, 2);
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
			$resp['execTasa'] = "1";
			$resp['tasa']['dia'] = $diaTasa;
			$resp['tasa']['mes'] = $mesTasa;
			$resp['tasa']['year'] = $yearTasa;
			$resp['tasa']['evento'] = $tasa;
		}else{
			$resp['execTasa'] = "2";
		}

		if(count($festividades)>1){
			$opres = "1";
		}else{
			$opres = "2";
		}

		if(count($tasas)>1){
			$opres2 = "1";
		}else{
			$opres2 = "2";
		}

		if($opres=="1"&&$opres2=="1"){
			$resp['estatus'] = "1";
		}
		if($opres=="2"&&$opres2=="1"){
			$resp['estatus'] = "1";
		}
		if($opres=="1"&&$opres2=="2"){
			$resp['estatus'] = "1";
		}
		if($opres=="2"&&$opres2=="2"){
			$resp['estatus'] = "2";
		}
		echo json_encode($resp);
	}

			if(empty($_POST)){
				$year = date('Y');
				$meses = ["01"=>"Enero", "02"=>"Febrero", "03"=>"Marzo", "04"=>"Abril", "05"=>"Mayo", "06"=>"Junio", "07"=>"Julio", "08"=>"Agosto", "09"=>"Septiembre", "10"=>"Octubre", "11"=>"Novimiembre", "12"=>"Diciembre"];
				$mes = date('m');
				$mesActual = $meses[$mes];

				$semana = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
				$semanas = [0=>$semana, 1=>$semana, 2=>$semana, 3=>$semana, 4=>$semana];
				$calendario = $lider->consultarQuery("SELECT * FROM calendario WHERE year_calendario = '{$year}'");
				$calendario1 = $lider->consultarQuery("SELECT * FROM calendario WHERE year_calendario = '{$year}' and mes_calendario = '01'");
				$calendario2 = $lider->consultarQuery("SELECT * FROM calendario WHERE year_calendario = '{$year}' and mes_calendario = '02'");
				$calendario3 = $lider->consultarQuery("SELECT * FROM calendario WHERE year_calendario = '{$year}' and mes_calendario = '03'");
				$calendario4 = $lider->consultarQuery("SELECT * FROM calendario WHERE year_calendario = '{$year}' and mes_calendario = '04'");
				$calendario5 = $lider->consultarQuery("SELECT * FROM calendario WHERE year_calendario = '{$year}' and mes_calendario = '05'");
				$calendario6 = $lider->consultarQuery("SELECT * FROM calendario WHERE year_calendario = '{$year}' and mes_calendario = '06'");
				$calendario7 = $lider->consultarQuery("SELECT * FROM calendario WHERE year_calendario = '{$year}' and mes_calendario = '07'");
				$calendario8 = $lider->consultarQuery("SELECT * FROM calendario WHERE year_calendario = '{$year}' and mes_calendario = '08'");
				$calendario9 = $lider->consultarQuery("SELECT * FROM calendario WHERE year_calendario = '{$year}' and mes_calendario = '09'");
				$calendario10 = $lider->consultarQuery("SELECT * FROM calendario WHERE year_calendario = '{$year}' and mes_calendario = '10'");
				$calendario11 = $lider->consultarQuery("SELECT * FROM calendario WHERE year_calendario = '{$year}' and mes_calendario = '11'");
				$calendario12 = $lider->consultarQuery("SELECT * FROM calendario WHERE year_calendario = '{$year}' and mes_calendario = '12'");
				$calendario1 = acomodarCalendario($calendario1, "01");
				$calendario2 = acomodarCalendario($calendario2, "02");
				$calendario3 = acomodarCalendario($calendario3, "03");
				$calendario4 = acomodarCalendario($calendario4, "04");
				$calendario5 = acomodarCalendario($calendario5, "05");
				$calendario6 = acomodarCalendario($calendario6, "06");
				$calendario7 = acomodarCalendario($calendario7, "07");
				$calendario8 = acomodarCalendario($calendario8, "08");
				$calendario9 = acomodarCalendario($calendario9, "09");
				$calendario10 = acomodarCalendario($calendario10, "10");
				$calendario11 = acomodarCalendario($calendario11, "11");
				$calendario12 = acomodarCalendario($calendario12, "12");

				$calendarios = array(0=>['mess'=>'Enero','calendar'=>$calendario1],
				1=>['mess'=>'Febrero','calendar'=>$calendario2],
				2=>['mess'=>'Marzo','calendar'=>$calendario3],
				3=>['mess'=>'Abril','calendar'=>$calendario4],
				4=>['mess'=>'Mayo','calendar'=>$calendario5],
				5=>['mess'=>'Junio','calendar'=>$calendario6],
				6=>['mess'=>'Julio','calendar'=>$calendario7],
				7=>['mess'=>'Agosto','calendar'=>$calendario8],
				8=>['mess'=>'Septiembre','calendar'=>$calendario9],
				9=>['mess'=>'Octubre','calendar'=>$calendario10],
				10=>['mess'=>'Noviembre','calendar'=>$calendario11],
				11=>['mess'=>'Diciembre','calendar'=>$calendario12]);

				if($calendario['ejecucion']==1){
					$festividades = $lider->consultarQuery("SELECT * FROM festividades WHERE estatus = 1");
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
// }else{
//     require_once 'public/views/error404.php';
// }



function acomodarCalendario($calendario, $mes){
	$cal = [];
	for ($i=0; $i < count($calendario)-1; $i++) {					
		if($calendario[0]['diaSemana']=="Domingo"){
			$cal[$i] = $calendario[$i];
		}
		if($calendario[0]['diaSemana']=="Lunes"){ 
			$cal[0]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Domingo', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[$i+1] = $calendario[$i];
		}
		if($calendario[0]['diaSemana']=="Martes"){ 
			$cal[0]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Domingo', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[1]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Lunes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[$i+2] = $calendario[$i];
		}
		if($calendario[0]['diaSemana']=="Miercoles"){ 
			$cal[0]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Domingo', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[1]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Lunes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[2]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Martes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[$i+3] = $calendario[$i];
		}
		if($calendario[0]['diaSemana']=="Jueves"){ 
			$cal[0]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Domingo', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[1]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Lunes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[2]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Martes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[3]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Miercoles', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[$i+4] = $calendario[$i];
		}
		if($calendario[0]['diaSemana']=="Viernes"){ 
			$cal[0]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Domingo', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[1]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Lunes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[2]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Martes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[3]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Miercoles', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[4]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Jueves', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[$i+5] = $calendario[$i];
		}
		if($calendario[0]['diaSemana']=="Sabado"){ 
			$cal[0]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Domingo', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[1]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Lunes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[2]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Martes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[3]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Miercoles', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[4]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Jueves', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[5]=['id_calendario'=>"",'fecha_calendario'=>"0000-00-00", 'diaSemana'=>'Viernes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
			$cal[$i+6] = $calendario[$i];
		}
	}
	$calendario = $cal;
	return $calendario;
}


// function acomodarCalendario($calendario, $mes){
// 	$cal = [];
// 	for ($i=0; $i < count($calendario)-1; $i++) {					
// 		if($calendario[0]['diaSemana']=="Domingo"){}
// 		if($calendario[0]['diaSemana']=="Lunes"){ 
// 			$cal[0]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-001", 'diaSemana'=>'Domingo', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"00"];
// 			$cal[$i+1] = $calendario[$i];
// 		}
// 		if($calendario[0]['diaSemana']=="Martes"){ 
// 			$cal[0]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-001", 'diaSemana'=>'Domingo', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"001"];
// 			$cal[1]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-002", 'diaSemana'=>'Lunes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"002"];
// 			$cal[$i+2] = $calendario[$i];
// 		}
// 		if($calendario[0]['diaSemana']=="Miercoles"){ 
// 			$cal[0]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-001", 'diaSemana'=>'Domingo', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"001"];
// 			$cal[1]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-002", 'diaSemana'=>'Lunes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"002"];
// 			$cal[2]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-002", 'diaSemana'=>'Martes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"003"];
// 			$cal[$i+3] = $calendario[$i];
// 		}
// 		if($calendario[0]['diaSemana']=="Jueves"){ 
// 			$cal[0]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-001", 'diaSemana'=>'Domingo', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"001"];
// 			$cal[1]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-002", 'diaSemana'=>'Lunes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"002"];
// 			$cal[2]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-002", 'diaSemana'=>'Martes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"003"];
// 			$cal[3]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-002", 'diaSemana'=>'Miercoles', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"004"];
// 			$cal[$i+4] = $calendario[$i];
// 		}
// 		if($calendario[0]['diaSemana']=="Viernes"){ 
// 			$cal[0]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-001", 'diaSemana'=>'Domingo', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"001"];
// 			$cal[1]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-002", 'diaSemana'=>'Lunes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"002"];
// 			$cal[2]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-002", 'diaSemana'=>'Martes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"003"];
// 			$cal[3]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-002", 'diaSemana'=>'Miercoles', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"004"];
// 			$cal[4]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-002", 'diaSemana'=>'Jueves', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"005"];
// 			$cal[$i+5] = $calendario[$i];
// 		}
// 		if($calendario[0]['diaSemana']=="Sabado"){ 
// 			$cal[0]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-001", 'diaSemana'=>'Domingo', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"001"];
// 			$cal[1]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-002", 'diaSemana'=>'Lunes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"002"];
// 			$cal[2]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-002", 'diaSemana'=>'Martes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"003"];
// 			$cal[3]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-002", 'diaSemana'=>'Miercoles', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"004"];
// 			$cal[4]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-002", 'diaSemana'=>'Jueves', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"005"];
// 			$cal[5]=['id_calendario'=>"",'fecha_calendario'=>"2022-".$mes."-002", 'diaSemana'=>'Viernes', 'year_calendario'=>"2022", 'mes_calendario'=>$mes, "dia_calendario"=>"006"];
// 			$cal[$i+6] = $calendario[$i];
// 		}
// 	}
// 	$calendario = $cal;
// 	return $calendario;
// }












?>