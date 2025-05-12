<?php 
	set_time_limit(320);
    if(is_file('app/models/indexModels.php')){
        require_once 'app/models/indexModels.php';
    }
    if(is_file('../app/models/indexModels.php')){
        require_once '../app/models/indexModels.php';
    }
    
    require_once 'vendor/dompdf/dompdf/vendor/autoload.php';
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();
$amReportes = 0;
$amReportesC = 0;
foreach ($accesos as $access) {
    if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Reportes"){
        $amReportes = 1;
        if($access['nombre_permiso'] == "Ver"){
        $amReportesC = 1;
        }
    }
    }
}
if($amReportesC == 1){
	$fecha_desde = $_GET['fecha_seleccionada']." 00:00:00";
    $fecha_hasta = $_GET['fecha_seleccionada']." 23:59:59";
    // $fechaActualHoy = date('Y-m-d');
    // $numDiaHoy= date('w');
    // $dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
    // $numDiasHabiles = 0;
    // $numDiasMenos = 0;
    // // $diaHoy = $dias[date('w')];
    $estados="Abonado";
    
    $queryEfi="SELECT * FROM eficoin_divisas, clientes WHERE eficoin_divisas.id_cliente=clientes.id_cliente and eficoin_divisas.estatus = 1 and eficoin_divisas.estado_pago='{$estados}' and eficoin_divisas.fecha_registro BETWEEN '{$fecha_desde}' and '{$fecha_hasta}' ORDER BY eficoin_divisas.fecha_registro DESC;";
    $eficoins=$lider->consultarQuery($queryEfi);
    $id_efis="";
    $index=1;
    $cantidades=count($eficoins)-1;
    foreach ($eficoins as $efis) {
        if(!empty($efis['id_eficoin_div'])){
            $id_efis.=$efis['id_eficoin_div'];
            if($index<$cantidades){
                $id_efis.=", ";
            }
            $index++;
        }
    }
    $dptoC=$_GET['comercializacion'];
    $dptoA=$_GET['administracion'];
    // $detalleEficoin=$lider->consultarQuery("SELECT * FROM eficoin_detalle WHERE eficoin_detalle.estatus = 1 and eficoin_detalle.id_eficoin_div IN ($id_efis)");

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
				<title>Recepcion de Eficoin - StyleCollection</title>
				
			</head>
			<body>
			<style>
			body{
				font-family:'arial';
			}
			</style>
			<div class='row' style='padding:0;margin:0;'>
				<div class='col-xs-12'  style='width:100%;'>
                    <div style='background:".$fucsia.";padding:0.1px 30px;color:#FFF;'>
                        <h3 style='text-align:right;float:right;'><b>Fecha: ".$lider->formatFechaSlash($_GET['fecha_seleccionada'])."</b></h3>
                        <h2 style='font-size:1.5em;'><b>Reporte de Recepcion de Eficoin</b></h2>
                    </div>
					<br>
				";		

					$info .= "
                        <table id='' class='table table-bordered' style='text-align:center;width:100%;'>
                            <thead>
                                <tr style='font-size:0.9em;'>
                                    <th>Nro. Control de Recibos</th>
                                    <th>Cantidad</th>
                                    <th>Reportado El</th>
                                    <th>Líder</th>
                                    <th>RIF</th>
                                    <th>Concepto</th>
                                </tr>
                            </thead>
                            <tbody>
                            ";

                                $num = 1;
                                $totalRecibido = 0;
                                foreach ($eficoins as $data){
                                    if(!empty($data['id_eficoin_div'])){ 
                                        $lim = 7;
                                        $falta = $lim-strlen($data['numero_recibo']);
                                        $numero_recibo="";
                                        for ($i=0; $i < $falta; $i++) {
                                            $numero_recibo.="0";
                                        }
                                        $numero_recibo .= $data['numero_recibo'];
                                        $totalRecibido+=(float) number_format($data['equivalente_pago'],2,'.','');
                                        $info .= "
                                        <tr>
                                            <td style='width:13%;'>
                                                <span class='contenido2'>
                                                    00-".$numero_recibo."
                                                </span>
                                            </td>
                                            <td style='width:10%;'>
                                                <span class='contenido2' style='font-size:.9em;'>
                                                    ".number_format($data['equivalente_pago'],2,',','.')."
                                                </span>
                                            </td>
                                            <td style='width:12%;'>
                                                <span class='contenido2' style='font-size:.9em;'>
                                                    ".$lider->formatFechaSlash($data['fecha_pago'])."
                                                </span>
                                            </td>
                                            <td style='width:15%;text-align:left;'>
                                                <span class='contenido2' style='padding:left:10px;'>
                                                    ".$data['primer_nombre']." ".$data['primer_apellido']."
                                                </span>
                                            </td>
                                            <td style='width:10%;text-align:left;'>
                                                <span class='contenido2' style='padding:left:10px;'>
                                                    ".$data['cod_rif'].$data['rif']."
                                                </span>
                                            </td>
                                            <td style='width:40%;text-align:left;'>
                                                <span class='contenido2' style='padding:left:10px;'>
                                                    ";
                                                        $campanas = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana=despachos.id_campana and campanas.id_campana={$data['id_campana']}");
                                                        if(count($campanas)>1){
                                                            $campana=$campanas[0];
                                                            $concepto = "Abono de ".$data['tipo_pago']." - Campaña ".$campana['numero_campana']."/".$campana['anio_campana']." - Pedido ".$campana['numero_despacho']." - N° ".$data['id_pedido'];
                                                            $info .= $concepto;
                                                        }
                                                    $info .= "    
                                                </span>
                                            </td>
                                        </tr>
                                        ";
                                    }
                                }
                            $info .= "
                            </tbody>
                            <tfoot>
                                <tr style='font-size:1.2em;'>
                                    <th style='text-align:right;'>Total</th>
                                    <th style='text-align:center;'>".number_format($totalRecibido,2,',','.')."</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
						<br>
						<table style='width:100%;font-size:1em;' class='tableinfofinal'>
							<tr>
								<td style='padding:4px;width:30%;text-align:center;border:1px solid #CCC;background:".$fucsia.";color:#FFF;'><b>Contado y Entregado Por:</b></td>
								<td style='padding:4px;width:30%;text-align:center;border:1px solid #CCC;background:".$fucsia.";color:#FFF;'><b>Recibido y Contado Por:</b></td>
								<td style='padding:4px;width:40%;text-align:left;border:1px solid #CCC;background:".$fucsia.";color:#FFF;'><b>Observaciones</b></td>
							</tr>
							<tr style=''>
								<td style='padding:4px;width:30%;text-align:left;padding-left:20px;border:1px solid #CCC;'>Dpto. Comercialización - <b>".$_GET['comercializacion']."</b><br><br><br></td>
								<td style='padding:4px;width:30%;text-align:left;padding-left:20px;border:1px solid #CCC;'>Dpto. Administracion - <b>".$_GET['administracion']."<br><br><br></td>
								<td style='padding:4px;width:40%;text-align:left;border-left:1px solid #CCC;border-right:1px solid #CCC;border-top:1px solid #CCC;'><div</div></td>
							</tr>
							<tr>
								<td style='padding:4px;width:30%;text-align:center;border:1px solid #CCC;'>Firma</td>
								<td style='padding:4px;width:30%;text-align:center;border:1px solid #CCC;'>Firma</td>
								<td style='padding:4px;width:40%;text-align:left;border-left:1px solid #CCC;border-right:1px solid #CCC;border-bottom:1px solid #CCC;'></td>
							</tr>
						</table>
					  ";
							
							    //<span class='string'>Copyright &copy; 2021-2022 <b>Style Collection</b>.</span> <span class='string'>Todos los derechos reservados.</span>
							//<h2>tengo mucha hambre, y sueño, aparte tengo que hacer muchas cosas lol jajaja xd xd xd xd xd xd xd xd hangria </h2>
				$info .= "</div>
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
			// $pgl1 = 96.001;
			// $ancho = 528.00;
			// $alto = 816.009;
			// $altoMedio = $alto / 2;



			$dompdf->loadHtml($info);
			$dompdf->render();
			$dompdf->stream("Recepcion de Eficoin - StyleCollection", array("Attachment" => false));
			// echo $info;
}else{
    require_once 'public/views/error404.php';
}

?>