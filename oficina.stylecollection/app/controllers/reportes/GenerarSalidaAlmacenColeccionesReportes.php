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
    $id_despacho = $_GET['P'];
    $pedidosClientes = $lider->consultarQuery("SELECT * FROM despachos, campanas WHERE despachos.id_despacho = {$id_despacho} and campanas.id_campana = despachos.id_campana");
    $nombreCampana = $pedidosClientes[0]['nombre_campana'];
    $numeroCampana = $pedidosClientes[0]['numero_campana'];
    $anioCampana = $pedidosClientes[0]['anio_campana'];

    $facturados=$_SESSION['resumenTotalSalidaAlmacenColecciones'];
    $tipoColecciones=$_SESSION['resumenTotalSalidaAlmacenColeccionestc'];
    $listaPromociones=$_SESSION['resumenTotalSalidaAlmacenColeccioneslp'];

    $limiteMax=11;
    $indexLimite=0;
    $newFacturado=[];
    $maxPage=1;
    foreach ($facturados as $key) {
        $newFacturado[$maxPage][$indexLimite]=$key;
        $indexLimite++;
        if($indexLimite>=$limiteMax){
            $maxPage++;
            $indexLimite=0;
        }
    }
    if((count($facturados))==$limiteMax){
        $maxPage--;
    }

		// 	$id_despacho = $_GET['id'];
		// 	$clientess = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1");
		// 	$pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho");
		// 	$nombreCampana = $pedidosClientes[0]['nombre_campana'];
		// 	$numeroCampana = $pedidosClientes[0]['numero_campana'];
		// 	$anioCampana = $pedidosClientes[0]['anio_campana'];

		// $configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
		// $accesoBloqueo = "0";
		// $superAnalistaBloqueo="1";
		// $analistaBloqueo="1";
		// foreach ($configuraciones as $config) {
		// 	if(!empty($config['id_configuracion'])){
		// 		if($config['clausula']=='Analistabloqueolideres'){
		// 			$analistaBloqueo = $config['valor'];
		// 		}
		// 		if($config['clausula']=='Superanalistabloqueolideres'){
		// 			$superAnalistaBloqueo = $config['valor'];
		// 		}
		// 	}
		// }
		// if($_SESSION['nombre_rol']=="Analista"){$accesoBloqueo = $analistaBloqueo;}
		// if($_SESSION['nombre_rol']=="Analista Supervisor"){$accesoBloqueo = $superAnalistaBloqueo;}
		// if($accesoBloqueo=="0"){
		// 	// echo "Acceso Abierto";
		// }
		// if($accesoBloqueo=="1"){
		// 	// echo "Acceso Restringido";
		// 	$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['id_usuario']}");
		// }

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
                border:1px solid #000 !important;
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
                $facturarr=$newFacturado[$numPage];
                $info .= "
                <div class='row' style='padding:0;margin:0;'>
                    <div class='col-xs-12' style='width:100%;'>
                    ";		
                        $info .= "
                            <h3 style='width:100%;border:2px solid #ccc;text-align:center;padding:3px;margin-botton:30px;'>Guia de Despacho de colecciones</h3>
                            <br>
                            <div style='width:25%;display:inline-block;background:;'>
                                <img src='public/assets/img/logoTipo1.png' style='width:100%;'>
                            </div>
                            <div style='width:75%;display:inline-block;background:;text-align:left;font-size:1.2em;'>
                                <span>Inversiones Style Collection C.A.</span>
                                <br>
                                <span>Rif.: J408497786</span>
                                <br>
                                <span>AV. LOS HORCONES ENTRE CALLE 9 Y 10 LOCAL NRO. S/N</span>
                                <br>
                                <span>BARRIO PUEBLO NUEVO BARQUISIMETO EDO. LARA ZONA POSTAL 3001</span>
                            </div>
                            <br>
                            <br>
                            <table style='width:100%;font-size:1.2em;'>
                                <tr>
                                    <td style='width:25%;'><b>Conductor: </b></td>
                                    <td style='width:40%;'>".$_GET['conductor']."</td>
                                    <td style='width:35%;'><b>Ruta: </b><u>".$_GET['ruta']."</u></td>
                                </tr>
                                <tr>
                                    <td><b>C.I.: </b></td>
                                    <td>".$_GET['cedula']."</td>
                                    <td>";
                                        if($maxPage>1){
                                            $info.="<b>Pagina: </b>".$numPage."/".$maxPage;
                                        }
                                    $info.="</td>
                                </tr>
                                <tr>
                                    <td><b>Nro. Tlf. Contacto.: </b></td>
                                    <td>".$_GET['tlf']."</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><b>Tipo de Vehiculo: </b></td>
                                    <td>".$_GET['vehiculo']."</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><b>Placa: </b></td>
                                    <td>".$_GET['placa']."</td>
                                    <td></td>
                                </tr>
                            </table>
                            
                            <br>
                            <br>
                        
                            <table class='table tabledata' style='font-size:1.2em;width:100% !important;'>
                                <thead style='background:#efefef55;font-size:1.05em;'>
                                    <tr class='text-center' style='white-space:nowrap;text-align:center;font-size:0.8em;'>
                                        <th style=''></th>
                                        <th style=''></th>
                                        <th style='' colspan='".count($tipoColecciones)."'>Colecciones</th>
                                        <th style='' colspan='".count($listaPromociones)."'>Promociones</th>
                                    </tr>
                                    <tr class='text-center' style='text-align:center;font-size:0.8em;'>
                                        <th style=''>Nombre y Apellido</th>
                                        <th style=''>Zona</th>
                                        ";
                                        foreach ($tipoColecciones as $tipoCol) {
                                            $info .= "<th style=''>".substr($tipoCol['name'],0,15)."</th>";
                                        }
                                        foreach ($listaPromociones as $listPromo) {
                                            $info .= "<th style=''>".substr($listPromo['name'],0,15)."</th>";
                                        }
                                        $info .= "
                                    </tr>
                                </thead>
                                <tbody style='font-size:0.9em;'> ";
                                    $num=1;
                                    foreach ($tipoColecciones as $tipoCol) {
                                        $total_colecciones[$tipoCol['name']]=0;
                                    }
                                    foreach ($listaPromociones as $listPromo) {
                                        $total_colecciones[$listPromo['name']]=0;
                                    }
                                    foreach ($facturarr as $pedido) {
                                        $info .= "<tr>";
                                        $info .= "<td class='space' style='font-size:0.9em;'>".$pedido['cliente']."</td>";
                                        $info .= "<td class='space'>".$pedido['zona']."</td>";
                                        foreach ($tipoColecciones as $tipoCol){
                                                $total_colecciones[$tipoCol['name']]+=$pedido[$tipoCol['name']];
                                                $info .= "<td>".$pedido[$tipoCol['name']]." Cols.</td>";
                                            }
                                            foreach ($listaPromociones as $listPromo) {
                                                $total_colecciones[$listPromo['name']]+=$pedido[$listPromo['name']];
                                                $info .= "<td>".$pedido[$listPromo['name']]." Promo.</td>";
                                            }
                                        $info .= "</tr>";
                                    }
                                    $info .= "
                                    <tr>
                                        <th></th>
                                        <th></th>";
                                        foreach ($tipoColecciones as $tipoCol) {
                                            $info .= "<th>".$total_colecciones[$tipoCol['name']]." Cols."."</th>";
                                        }
                                        foreach ($listaPromociones as $listPromo) {
                                            $info .= "<th>".$total_colecciones[$listPromo['name']]." Promo."."</th>";
                                        }
                                        $info .= "
                                    </tr>
                                </tbody>
                            </table>
                            <table style='width:100%;font-size:1.2em;' class='tableinfofinal'>
                                <tr>
                                    <td style='width:20%;'><b>Despachado Por: </b></td>
                                    <td style='width:30%;'><span style='color:rgba(0,0,0,0);border-bottom:1px solid #878787;'>________________________________</span></td>
                                    <td style='width:20%;'><b>Conductor: </b></td>
                                    <td style='width:30%;'><span style='color:rgba(0,0,0,0);border-bottom:1px solid #878787;'>________________________________</span></td>
                                </tr>
                                <tr>
                                    <td><b>Nombre y Apellido: </b></td>
                                    <td><span style='color:rgba(0,0,0,0);border-bottom:1px solid #878787;'>________________________________</span></td>
                                    <td><b>Nombre y Apellido: </b></td>
                                    <td><span style='color:rgba(0,0,0,0);border-bottom:1px solid #878787;'>________________________________</span></td>
                                </tr>
                                <tr>
                                    <td><b>C.I.: </b></td>
                                    <td><span style='color:rgba(0,0,0,0);border-bottom:1px solid #878787;'>________________________________</span></td>
                                    <td><b>C.I.: </b></td>
                                    <td><span style='color:rgba(0,0,0,0);border-bottom:1px solid #878787;'>________________________________</span></td>
                                </tr>
                                <tr>
                                    <td><b>Firma: </b></td>
                                    <td><span style='color:rgba(0,0,0,0);border-bottom:1px solid #878787;'>________________________________</span></td>
                                    <td><b>Firma: </b></td>
                                    <td><span style='color:rgba(0,0,0,0);border-bottom:1px solid #878787;'>________________________________</span></td>
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
			$dompdf->stream("Salida de Almacén - Colecciones de Campaña {$numeroCampana}-{$anioCampana} - StyleCollection", array("Attachment" => false));
			// echo $info;
}else{
    require_once 'public/views/error404.php';
}

?>