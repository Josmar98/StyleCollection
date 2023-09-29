<?php 
			if(is_file('app/models/indexModels.php')){
				 	require_once'app/models/indexModels.php';
				 }
				 if(is_file('../app/models/indexModels.php')){
				 	require_once'../app/models/indexModels.php';
				 }

			require_once'vendor/dompdf/dompdf/vendor/autoload.php';
			use Dompdf\Dompdf;
			$dompdf = new Dompdf();

			
			$id_campana = $_GET['campaing'];
			$numero_campana = $_GET['n'];
			$anio_campana = $_GET['y'];
			$id_despacho = $_GET['dpid'];
			$num_despacho = $_GET['dp'];
			$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

			// $id_despacho = $_GET['id'];
			// $clientess = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1");
			// $pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_despacho and despachos.id_despacho = pedidos.id_despacho");
			// $nombreCampana = $pedidosClientes[0]['nombre_campana'];
			// $numeroCampana = $pedidosClientes[0]['numero_campana'];
			// $anioCampana = $pedidosClientes[0]['anio_campana'];


	$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE bancos.estatus = 1");
		
		$pagos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} ORDER BY fecha_pago asc");
		$id_cliente = $_SESSION['id_cliente'];


		$liderazgosAll = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos_campana.id_liderazgo = liderazgos.id_liderazgo and liderazgos_campana.id_campana = $id_campana and liderazgos_campana.estatus = 1");
		$pedidos = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos WHERE  campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_cliente = {$id_cliente} and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho}");

		$campanas = $lider->consultarQuery("SELECT * FROM campanas WHERE campanas.id_campana = {$id_campana}");
		$campana = $campanas[0];
	//========================================================================================================== 

				
	//========================================================================================================== 		
		$mostrar = [];
		$n=0;
		foreach ($bancos as $bank) {
			if(!empty($bank['id_banco'])){
				$temp = [];
				$pagoss = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.id_banco = {$bank['id_banco']} ");
				$reportados = 0;
				$diferidos = 0;
				$abonados = 0;
				$pendientes = 0;
				foreach ($pagoss as $pag) {
					if(!empty($pag['id_pago'])){
						if($pag['estado']=="Abonado"){
							$abonados += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else if($pag['estado']=="Diferido"){
							$diferidos += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else {
							$reportados += $pag['equivalente_pago'];
						}
					}
				}
				$pendientes = $reportados - $diferidos - $abonados;
				if(count($pagoss)>1){
					if($bank['tipo_cuenta']=="Divisas"){
						$temp['opcion'] = "(".$bank['codigo_banco'].") ".$bank['nombre_banco']." - ".$bank['nombre_propietario']." (Depositos ".$bank['tipo_cuenta'].")";
					}else{
						$temp['opcion'] = "(".$bank['codigo_banco'].") ".$bank['nombre_banco']." - ".$bank['nombre_propietario']." (Cuenta ".$bank['tipo_cuenta'].")";
					}
					$temp['pagos']['reportados']=$reportados;
					$temp['pagos']['diferidos']=$diferidos;
					$temp['pagos']['abonados']=$abonados;
					$temp['pagos']['pendiente']=$pendientes;
					$mostrar[$n] = $temp;
					$n++;
				}
			}
		}
	//========================================================================================================== 

				
	//========================================================================================================== 
		$pagossDivisas = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Divisas Dolares'");
				$reportados = 0;
				$diferidos = 0;
				$abonados = 0;
				$pendientes = 0;
				foreach ($pagossDivisas as $pag) {
					if(!empty($pag['id_pago'])){
						if($pag['estado']=="Abonado"){
							$abonados += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else if($pag['estado']=="Diferido"){
							$diferidos += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else {
							$reportados += $pag['equivalente_pago'];
						}
					}
				}
				$pendientes = $reportados - $diferidos - $abonados;
				if(count($pagoss)>1){
					$temp['opcion'] = "Divisas Dolares";
					$temp['pagos']['reportados']=$reportados;
					$temp['pagos']['diferidos']=$diferidos;
					$temp['pagos']['abonados']=$abonados;
					$temp['pagos']['pendiente']=$pendientes;
					$mostrar[$n] = $temp;
					$n++;
				}

	//========================================================================================================== 


	//========================================================================================================== 
		$pagossBolivares = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago = 'Efectivo Bolivares'");
				$reportados = 0;
				$diferidos = 0;
				$abonados = 0;
				$pendientes = 0;
				foreach ($pagossBolivares as $pag) {
					if(!empty($pag['id_pago'])){
						if($pag['estado']=="Abonado"){
							$abonados += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else if($pag['estado']=="Diferido"){
							$diferidos += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else {
							$reportados += $pag['equivalente_pago'];
						}
					}
				}
				$pendientes = $reportados - $diferidos - $abonados;
				if(count($pagoss)>1){
					$temp['opcion'] = "Efectivo Bolivares";
					$temp['pagos']['reportados']=$reportados;
					$temp['pagos']['diferidos']=$diferidos;
					$temp['pagos']['abonados']=$abonados;
					$temp['pagos']['pendiente']=$pendientes;
					$mostrar[$n] = $temp;
					$n++;
				}
	//========================================================================================================== 

				
	//========================================================================================================== 
			$pagossAutorizados = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, pagos WHERE campanas.id_campana = despachos.id_despacho and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = pedidos.id_despacho and pedidos.estatus = 1 and pedidos.id_pedido = pagos.id_pedido and pagos.estatus = 1 and campanas.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and pagos.forma_pago LIKE '%Autorizado Por%'");
				$reportados = 0;
				$diferidos = 0;
				$abonados = 0;
				$pendientes = 0;
				foreach ($pagossAutorizados as $pag) {
					if(!empty($pag['id_pago'])){
						if($pag['estado']=="Abonado"){
							$abonados += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else if($pag['estado']=="Diferido"){
							$diferidos += $pag['equivalente_pago'];
							$reportados += $pag['equivalente_pago'];
						}else {
							$reportados += $pag['equivalente_pago'];
						}
					}
				}
				$pendientes = $reportados - $diferidos - $abonados;
				if(count($pagoss)>1){
					$temp['opcion'] = "Autorizado Por Amarilis Rojas";
					$temp['pagos']['reportados']=$reportados;
					$temp['pagos']['diferidos']=$diferidos;
					$temp['pagos']['abonados']=$abonados;
					$temp['pagos']['pendiente']=$pendientes;
					$mostrar[$n] = $temp;
					$n++;
				}




				$reportado = 0;
			$diferido = 0;
			$abonado = 0;
			$pendienteConciliar = 0;
			if(count($pagos)){
              foreach ($pagos as $data) {
                if(!empty($data['id_pago'])){
                  $reportado += $data['equivalente_pago'];
                  if($data['estado']=="Diferido"){
                    $diferido += $data['equivalente_pago'];
                  }
                  if($data['estado']=="Abonado"){
                    $abonado += $data['equivalente_pago'];
                  }
                }
              }
			}
			$pendienteConciliar = $reportado-$diferido-$abonado;

			$mes = date("m");
              switch ($mes) {
                case '01':
                  $mes = "Enero";
                  break;
                case '02':
                  $mes = "Febrero";
                  break;
                case '03':
                  $mes = "Marzo";
                  break;
                case '04':
                  $mes = "Abril";
                  break;
                case '05':
                  $mes = "Mayo";
                  break;
                case '06':
                  $mes = "Junio";
                  break;
                case '07':
                  $mes = "Julio";
                  break;
                case '08':
                  $mes = "Agosto";
                  break;
                case '09':
                  $mes = "Septiembre";
                  break;
                case '10':
                  $mes = "Octubre";
                  break;
                case '11':
                  $mes = "Noviembre";
                  break;
                case '12':
                  $mes = "Diciembre";
                  break;
              }

			$var = dirname(__DIR__, 3);
				$urlCss1 = $var . '/public/vendor/bower_components/bootstrap/dist/css/';
				$urlCss2 = $var . '/public/assets/css/';
				$urlImg = $var . '/public/assets/img/';

			ini_set('date.timezone', 'america/caracas');			//se establece la zona horaria
			date_default_timezone_set('america/caracas');

			$info = "
			<!DOCTYPE html>
			<html>
			<head>
				<link rel='stylesheet' type='text/css' href='public/assets/css/style.css'>
				<link rel='stylesheet' type='text/css' href='public/vendor/bower_components/bootstrap/dist/css/bootstrap.min.css'>
				<link rel='stylesheet' type='text/css' href='public/vendor/dist/css/AdminLTE.min.css'>
				<title>Reporte de pagos de Campaña ".$numero_campana."/".$anio_campana." - StyleCollection</title>
				
			</head>
			<body>
			<style>
              
	        </style>
			<div class='row' style='padding:0;margin:0;'>
				<div class='col-xs-12'  style='width:100%;'>

						<h3 style='text-align:right;float:right;'><small>StyleCollection- ".$campana['nombre_campana']."</small></h3>
						<h2 style='font-size:1em;'> Solicitudes Aprobadas de Pedido - Campaña ".$numero_campana."/".$anio_campana."</h2>
						<br>

					<div class='box-body'>

              <div class='row text-center' style='padding:10px 20px;width:100%;'>
                <div class='col-xs-12' style='font-size:1.1em;padding:5px 0px;background:rgba(190,190,190,.4);border:1px solid #ccc'>
                  <b class='text-xs' style='float:left;margin-left:5%;font-size:1.2em;'>
                    ".mb_strtoupper('Reporte de Conciliacion')."
                  </b>
                  <b class='text-xs' style='float:right;margin-right:5%;font-size:1.1em;'>
                    Al ".date('d')."-".$mes." ".date('h:i a')."
                  </b>
                  <div style='clear:both;'></div>
                </div>
                <br><br>
                <div class='col-xs-3' style='padding:10px 0px;background:;border:1px solid #ccc;width:25%;'>
                    <b style='color:#000 !important'>Reportado General</b>
                    <hr style='margin:0px;padding:0px;border-bottom:1px solid #ccc'>
                    <h4 class='text-xs' style='color:#0000FF !important;font-size:1.2em;'><b>$".number_format($reportado, 2, ',', '.')."</b></h4>
                </div>
                <div class='col-xs-3' style='padding:10px 0px;background:;border:1px solid #ccc;width:25%;margin-left:25%;'>
                    <b style='color:#000 !important'>Diferido General</b>
                    <hr style='margin:0px;padding:0px;border-bottom:1px solid #ccc'>
                    <h4 class='text-xs' style='color:#FF0000 !important;font-size:1.2em;'><b>$".number_format($diferido, 2, ',', '.')."</b></h4>
                </div>
                <div class='col-xs-3' style='padding:10px 0px;background:;border:1px solid #ccc;width:25%;margin-left:50%;'>
                      <b style='color:#000 !important'>Abonado General</b>
                      <hr style='margin:0px;padding:0px;border-bottom:1px solid #ccc'>
                      <h4 class='text-xs' style='color:#00FF00 !important;font-size:1.2em;'><b>$".number_format($abonado, 2, ',', '.')."</b></h4>
                </div>
                <div class='col-xs-3' style='padding:10px 0px;background:;border:1px solid #ccc;width:25%;margin-left:75%;'>
                      <b style='color:#000 !important'>Pendiente Por Coinciliar General</b>
                      <hr style='margin:0px;padding:0px;border-bottom:1px solid #ccc'>
                      <h4 class='text-xs1' style='color:rgba(0,0,255,.6); !important;font-size:1.2em;'><b>$".number_format($pendienteConciliar, 2, ',', '.')."</b></h4>
                </div>
              </div>
              <br><br><br><br><br>
              <hr style='border:1px solid #ccc'>
              <br>";



            foreach ($mostrar as $report):
             
	$info .= "<div class='row text-center' style='padding:10px 20px;'>
                <div style='border:1px solid #767676;'>
                  
                  <div class='col-xs-12' style='font-size:1.1em;padding:5px 0px;background:rgba(190,190,190,.4);border:1px solid #ccc'>
                    <b class='text-xs2'>
                      ".mb_strtoupper('Reporte')."
                    </b>
                    <b class='text-xs3' style='margin-right:10%;'>
                      Al ".date('d')."-".$mes." ".date('h:i a')."
                    </b>
                  </div>
                  
                  <div class='col-xs-12' style='font-size:1.1em;padding:6px 0px;margin-top:35px;margin-bottom:5px;'>
                    <b style='text-align:center;'>
                      ".mb_strtoupper($report['opcion'])."
                    </b>
                  </div>

                <br><br><br>
                  <div class='col-xs-3' style='padding:10px 0px;background:;border:1px solid #ccc;width:25%;'>
                      <b style='color:#000 !important'>Reportado</b>
                      <hr style='margin:0px;padding:0px;border-bottom:1px solid #ccc'>
                      <h4 class='text-xs' style='color:#0000FF !important'><b>$".number_format($report['pagos']['reportados'], 2, ',', '.')."</b></h4>
                  </div>
                  <div class='col-xs-3' style='padding:10px 0px;background:;border:1px solid #ccc;width:25%;margin-left:25%;'>
                      <b style='color:#000 !important'>Diferido</b>
                      <hr style='margin:0px;padding:0px;border-bottom:1px solid #ccc'>
                      <h4 class='text-xs' style='color:#FF0000 !important'><b>$".number_format($report['pagos']['diferidos'], 2, ',', '.')."</b></h4>
                  </div>
                  <div class='col-xs-3' style='padding:10px 0px;background:;border:1px solid #ccc;width:25%;margin-left:50%;'>
                        <b style='color:#000 !important'>Abonado</b>
                        <hr style='margin:0px;padding:0px;border-bottom:1px solid #ccc'>
                        <h4 class='text-xs' style='color:#00FF00 !important'><b>$".number_format($report['pagos']['abonados'], 2, ',', '.')."</b></h4>
                  </div>
                  <div class='col-xs-3' style='padding:10px 0px;background:;border:1px solid #ccc;width:25%;margin-left:75%;'>
                        <b style='color:#000 !important'>Pendiente por Coinciliar</b>
                        <hr style='margin:0px;padding:0px;border-bottom:1px solid #ccc'>
                        <h4 class='text-xs1' style='color:rgba(0,0,255,.6); !important'><b>$".number_format($report['pagos']['pendiente'], 2, ',', '.')."</b></h4>
                  </div>
                  <div style='clear:both;'></div>

                </div>
              </div>
              <br><br>
                <br><br><br>";

            endforeach;



	$info .= "<hr style='border:1px solid #ccc'>

               <div class='row text-center' style='padding:10px 20px;width:100%;'>
                <div class='col-xs-12' style='font-size:1.1em;padding:5px 0px;background:rgba(190,190,190,.4);border:1px solid #ccc'>
                  <b class='text-xs' style='float:left;margin-left:5%;font-size:1.2em;'>
                    ".mb_strtoupper('Reporte de Conciliacion')."
                  </b>
                  <b class='text-xs' style='float:right;margin-right:5%;font-size:1.1em;'>
                    Al ".date('d')."-".$mes." ".date('h:i a')."
                  </b>
                  <div style='clear:both;'></div>
                </div>
                <br><br>
                <div class='col-xs-3' style='padding:10px 0px;background:;border:1px solid #ccc;width:25%;'>
                    <b style='color:#000 !important'>Reportado General</b>
                    <hr style='margin:0px;padding:0px;border-bottom:1px solid #ccc'>
                    <h4 class='text-xs' style='color:#0000FF !important;font-size:1.2em;'><b>$".number_format($reportado, 2, ',', '.')."</b></h4>
                </div>
                <div class='col-xs-3' style='padding:10px 0px;background:;border:1px solid #ccc;width:25%;margin-left:25%;'>
                    <b style='color:#000 !important'>Diferido General</b>
                    <hr style='margin:0px;padding:0px;border-bottom:1px solid #ccc'>
                    <h4 class='text-xs' style='color:#FF0000 !important;font-size:1.2em;'><b>$".number_format($diferido, 2, ',', '.')."</b></h4>
                </div>
                <div class='col-xs-3' style='padding:10px 0px;background:;border:1px solid #ccc;width:25%;margin-left:50%;'>
                      <b style='color:#000 !important'>Abonado General</b>
                      <hr style='margin:0px;padding:0px;border-bottom:1px solid #ccc'>
                      <h4 class='text-xs' style='color:#00FF00 !important;font-size:1.2em;'><b>$".number_format($abonado, 2, ',', '.')."</b></h4>
                </div>
                <div class='col-xs-3' style='padding:10px 0px;background:;border:1px solid #ccc;width:25%;margin-left:75%;'>
                      <b style='color:#000 !important'>Pendiente Por Coinciliar General</b>
                      <hr style='margin:0px;padding:0px;border-bottom:1px solid #ccc'>
                      <h4 class='text-xs1' style='color:rgba(0,0,255,.6); !important;font-size:1.2em;'><b>$".number_format($pendienteConciliar, 2, ',', '.')."</b></h4>
                </div>
              </div>

                <br><br><br>
                <input type='hidden' class='d-none color-button-sweetalert' value='<?php echo $color_btn_sweetalert ?>'>


            </div>







				</div>
			</div><br>
			</body>
			</html>
			";


					// $dompdf->loadHtml( file_get_contents( 'public/views/home.php' ) );
					// $dompdf->loadHtml($file);
					//$dompdf->setPaper('A4', 'landscape'); // para contenido en pagina de lado

					// top:30%;left:33%; || para A4 y para MEDIA CARTA
					// top:35%;left:25%; || para pagina carta normal

					//$ancho = 616.56;
					//$alto = 842.292;

					//$dompdf->setPaper(array(0,0,$ancho,$altoMedio)); // tamaño carta original
					// $dompdf->setPaper(array(0,0,619.56,842.292)); // para contenido en pagina de lado
			$dompdf->loadHtml($info);
			$pgl1 = 96.001;
			$ancho = 528.00;
			$alto = 816.009;
			$altoMedio = $alto / 2;
			$dompdf->render();
			$dompdf->stream("Reporte de Pagos Campaña {$numero_campana}-{$anio_campana} - StyleCollection", array("Attachment" => false));
			// echo $info;

?>