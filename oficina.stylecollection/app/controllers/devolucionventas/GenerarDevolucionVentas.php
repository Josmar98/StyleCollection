<?php 
	set_time_limit(320);
			if(is_file('app/models/indexModels.php')){
				 	require_once'app/models/indexModels.php';
				 }
				 if(is_file('../app/models/indexModels.php')){
				 	require_once'../app/models/indexModels.php';
				 }

			require_once'vendor/dompdf/dompdf/vendor/autoload.php';
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

    $id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

    $id=$_GET['id'];
    $id_pedido_pos=strpos($id,'_');
    $id_pedido=substr($id, 0, $id_pedido_pos);
	
    $coleccionesDevueltas=$lider->consultarQuery("SELECT * FROM orden_devolucion_colecciones WHERE id_despacho={$id_despacho} and id_pedido={$id_pedido}");
    $devoluciones = $lider->consultarQuery("SELECT DISTINCT concat(orden.id_pedido,'_',orden.fecha_devolucion,orden.hora_devolucion) as id_orden, orden.id_despacho, orden.id_pedido, orden.fecha_operacion, orden.fecha_devolucion, orden.hora_devolucion, orden.observaciones, clientes.primer_nombre, clientes.primer_apellido, clientes.cod_cedula, clientes.cedula, clientes.cod_rif, clientes.rif FROM orden_devolucion_colecciones as orden, pedidos, clientes WHERE orden.id_pedido=pedidos.id_pedido and pedidos.id_cliente=clientes.id_cliente and orden.estatus=1 and pedidos.estatus=1 and orden.id_despacho={$id_despacho} and pedidos.id_despacho={$id_despacho} and orden.id_pedido={$id_pedido} and pedidos.id_pedido={$id_pedido}");
    $dev=$devoluciones[0];
    $id_orden=$dev['id_orden'];
    $id_orden=str_replace('-','',$id_orden);
    $id_orden=str_replace(':','',$id_orden);
    $dev['id_orden']=$id_orden;

    $pedidosClientes = $lider->consultarQuery("SELECT * FROM despachos, campanas WHERE despachos.id_despacho = {$id_despacho} and campanas.id_campana = despachos.id_campana");
    $nombreCampana = $pedidosClientes[0]['nombre_campana'];
    $numeroCampana = $pedidosClientes[0]['numero_campana'];
    $anioCampana = $pedidosClientes[0]['anio_campana'];

    // $facturados=$_SESSION['resumenTotalSalidaAlmacenColecciones'];
    // $tipoColecciones=$_SESSION['resumenTotalSalidaAlmacenColeccionestc'];
    // $listaPromociones=$_SESSION['resumenTotalSalidaAlmacenColeccioneslp'];
    $limiteMax=5;
    $indexLimite=0;
    $newFacturado=[];
    $maxPage=1;
    // for ($i=0; $i < 4; $i++) { 
        foreach ($coleccionesDevueltas as $key) {
            if(!empty($key['id_pedido'])){
                $newFacturado[$maxPage][$indexLimite]=$key;
                $indexLimite++;
                if($indexLimite>=$limiteMax){
                    $maxPage++;
                    $indexLimite=0;
                }
            }
        }
    // }
    // echo "maxPage: ".$maxPage."<br>";
    if((count($coleccionesDevueltas)-1)==$limiteMax){
        $maxPage--;
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
				<title>Salida de Almacén Solicitados de Campaña ".$numeroCampana."/".$anioCampana." - StyleCollection</title>
				
			</head>
			<body>
			<style>
			body{
				font-family:'arial';
			}
            .tabledata td, .tabledata th{
                text-align:center !important;
                text-wrap:auto;
            }
            .tableinfofinal td{
                padding-top:5px;
                padding-bottom:5px;
            }
			</style>
            ";
            for ($numPage=1; $numPage <= $maxPage; $numPage++) { 
                $devuelto=$newFacturado[$numPage];
                for ($i=0; $i < count($devuelto); $i++) { 
                    if($devuelto[$i]['id_coleccion']==0){
                        $precio_coleccion = $lider->consultarQuery("SELECT precio_coleccion FROM despachos where id_despacho={$id_despacho}");
                    }else{
                        $precio_coleccion = $lider->consultarQuery("SELECT precio_coleccion_sec as precio_coleccion FROM despachos_secundarios where id_despacho_sec={$devuelto[$i]['id_coleccion']} and id_despacho={$id_despacho}");
                    }
                    $precio_coleccion = $precio_coleccion[0]['precio_coleccion'];
                    $devuelto[$i]['precio']= (float) $precio_coleccion;
                    $devuelto[$i]['total']= (float) ($precio_coleccion*$devuelto[$i]['cantidad_colecciones']);
                }
                if($maxPage>1){
                    // $info.="<b>Pagina: </b>".$numPage."/".$maxPage;
                }
                $info .= "
                <div class='row' style='padding:0;margin:0;'>
                    <div class='col-xs-12' style='width:100%;'>
                    ";		
                        $info .= "

                            <div style='width:25%;display:inline-block;background:;'>
                                <img src='public/assets/img/logoTipo1.png' style='width:100%;'>
                            </div>
                            <div style='width:40%;display:inline-block;background:;text-align:left;font-size:1.2em;'>
                                <span>Inversiones Style Collection C.A.</span>
                                <br>
                                <span>Rif.: J408497786</span>
                                <br>
                                <span style='font-size:0.8em;'>AV. LOS HORCONES ENTRE CALLE 9 Y 10 LOCAL NRO. S/N BARRIO PUEBLO NUEVO BARQUISIMETO EDO. LARA ZONA POSTAL 3001</span>
                            </div>
                            <div style='width:17.5%;display:inline-block;background:;text-align:left;font-size:1.2em;'>
                                <span style='font-size:0.9em;'><b>Lugar de Emisión</b></span>
                                <br>
                                <span>Barquisimeto</span>
                                <br><br><br>
                            </div>
                            <div style='width:17.5%;display:inline-block;background:;text-align:left;font-size:1.2em;'>
                                <span style='font-size:0.9em;'><b>Fecha de Emisión</b></span>
                                <br>
                                <span>".str_replace('-',' / ',$lider->formatFecha($dev['fecha_devolucion']))."</span>
                                <br><br><br>
                            </div>
                            <br>
                            <div style='width:50%;display:inline-block;background:;text-align:left;font-size:1.2em;'>
                                <span>Departamento: <u>Comercialización</u></span>
                            </div>
                            <div style='width:50%;display:inline-block;background:;text-align:right;font-size:1.2em;'>
                                <span><b>N° de Control: <u>".$dev['id_orden']."</u></b></span>
                            </div>
                            
                            <h3 style='width:100%;border-top:2px solid #ccc;border-bottom:2px solid #ccc;text-align:center;padding:3px;'><b>Nota de Devolución</b></h3>
                            
                            <div>
                                <div style='width:30%;display:inline-block;background:;text-align:left;font-size:1.1em;'>
                                    <span>Campaña: <u>".$numero_campana."/".$anio_campana."</u></span>
                                </div>
                                <div style='width:40%;display:inline-block;background:;text-align:center;font-size:1.1em;'>
                                    <span>Analista: ______________________</span>
                                </div>
                                <div style='width:30%;display:inline-block;background:;text-align:right;font-size:1.1em;'>
                                    <span>N° pedido afectado: <u>".$dev['id_pedido']."</u></span>
                                </div>
                            </div>
                            <div>
                                <div style='width:60%;display:inline-block;background:;text-align:left;font-size:1.1em;'>
                                    <span>Líder: <u>".$dev['primer_nombre']." ".$dev['primer_apellido']."</u></span>
                                </div>
                                <div style='width:40%;display:inline-block;background:;text-align:right;font-size:1.1em;'>
                                    <span>C.I./R.I.F.: <u>".$dev['cod_rif'].$dev['rif']."</u></span>
                                </div>
                            </div>
                            
                            <table class='table tabledata' style='font-size:1.2em;width:100% !important;'>
                                <thead style='background:#efefef55;font-size:1.05em;'>
                                    <tr class='text-center' style='text-align:center;font-size:0.8em;'>
                                        <th style=''>Unids.</th>
                                        <th style='text-align:left !important;'>Descripción</th>
                                        <th style=''>CONDICIONES DEL PRODUCTO O MERCANCÍA</th>
                                        <th style='text-align:right !important;'>Precio Unt.</th>
                                        <th style='text-align:right !important;'>Total</th>
                                    </tr>
                                </thead>
                                <tbody style='font-size:0.9em;'> ";
                                    $num=1;
                                    $sumatoria=0;
                                    foreach ($devuelto as $devol) {
                                        $info .= "<tr>";
                                            $info .= "<td class='space' style=''>".$devol['cantidad_colecciones']."</td>";
                                            $info .= "<td class='space' style='font-size:0.9em;text-align:left !important;'>Colección de ".$devol['nombre_coleccion']."</td>";
                                            $info .= "<td class='space' style=''></td>";
                                            $info .= "<td class='space' style='text-align:right !important;'>".number_format($devol['precio'],2,',','.')."</td>";
                                            $info .= "<td class='space' style='text-align:right !important;'>".number_format($devol['total'],2,',','.')."</td>";
                                        $info .= "</tr>";
                                        $sumatoria+=$devol['total'];
                                    }
                                    $info .= "<tr>";
                                        $info .= "<td class='space' style=''></td>";
                                        $info .= "<td class='space' style=''></td>";
                                        $info .= "<td class='space' style=''></td>";
                                        $info .= "<td class='space' style='text-align:right !important;'><b>TOTAL DEVOLUCIÓN</b></td>";
                                        $info .= "<td class='space' style='text-align:right !important;'><b>".number_format($sumatoria,2,',','.')."</b></td>";
                                    $info .= "</tr>";
                                    $info .= "
                                </tbody>
                            </table>
                            <table style='width:100%;font-size:0.95em;' class='tableinfofinal'>
                                <tr>
                                    <td style='padding:4px;width:15%;text-align:center;border:1px solid #CCC;'><b>Líder</b></td>
                                    <td style='padding:4px;width:15%;text-align:center;border:1px solid #CCC;'><b>Dpto. Comercialización</b></td>
                                    <td style='padding:4px;width:15%;text-align:center;border:1px solid #CCC;'><b>Almacen</b></td>
                                    <td style='padding:4px;width:15%;text-align:center;border:1px solid #CCC;'><b>Analista de Inventarios</b></td>
                                    <td style='padding:4px;width:40%;text-align:left;border:1px solid #CCC;'><b>Observaciones</b></td>
                                </tr>
                                <tr>
                                    <td style='padding:4px;width:15%;text-align:center;border:1px solid #CCC;'><div><br><br></div></td>
                                    <td style='padding:4px;width:15%;text-align:center;border:1px solid #CCC;'><div><br><br></div></td>
                                    <td style='padding:4px;width:15%;text-align:center;border:1px solid #CCC;'><div><br><br></div></td>
                                    <td style='padding:4px;width:15%;text-align:center;border:1px solid #CCC;'><div><br><br></div></td>
                                    <td style='padding:4px;width:40%;text-align:left;border-left:1px solid #CCC;border-right:1px solid #CCC;border-top:1px solid #CCC;font-size:0.9em;'><div>".$dev['observaciones']."</div></td>
                                </tr>
                                <tr>
                                    <td style='padding:4px;width:15%;text-align:center;border:1px solid #CCC;'>Firma</td>
                                    <td style='padding:4px;width:15%;text-align:center;border:1px solid #CCC;'>Firma</td>
                                    <td style='padding:4px;width:15%;text-align:center;border:1px solid #CCC;'>Firma</td>
                                    <td style='padding:4px;width:15%;text-align:center;border:1px solid #CCC;'>Firma</td>
                                    <td style='padding:4px;width:40%;text-align:left;border-left:1px solid #CCC;border-right:1px solid #CCC;border-bottom:1px solid #CCC;'></td>
                                </tr>
                            </table>
                            <div class='row'>
                                <div class='col-xs-12'>

                                
                                    

                                </div>
                            </div>
                        ";
                                
                                    //<span class='string'>Copyright &copy; 2021-2022 <b>Style Collection</b>.</span> <span class='string'>Todos los derechos reservados.</span>
                                //<h2>tengo mucha hambre, y sueño, aparte tengo que hacer muchas cosas lol jajaja xd xd xd xd xd xd xd xd hangria </h2>
                    $info .= "</div>
                </div>";
                if($numPage < $maxPage){
                    $info .= "<div style='page-break-after:always;'></div>";
                }
            }
            $info .= "
            <br>
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
			$dompdf->stream("Devolución en Ventas - Líder {$dev['primer_nombre']} {$dev['primer_apellido']} - StyleCollection", array("Attachment" => false));
			// echo $info;/
}else{
    require_once 'public/views/error404.php';
}

?>