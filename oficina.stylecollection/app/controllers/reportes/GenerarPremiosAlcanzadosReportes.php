<?php 
	set_time_limit(320);
			require_once'vendor/dompdf/dompdf/vendor/autoload.php';
			use Dompdf\Dompdf;
			$dompdf = new Dompdf();
			if(is_file('app/models/indexModels.php')){
				 	require_once'app/models/indexModels.php';
				 }
				 if(is_file('../app/models/indexModels.php')){
				 	require_once'../app/models/indexModels.php';
				 }

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

	$id_despacho = $_GET['id'];
	$campanas = $lider->consultarQuery("SELECT * FROM despachos, campanas WHERE despachos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_campana");
	$campana = $campanas[0];
	$id_campana = $campana['id_campana'];


	if(!empty($_GET['admin']) && !empty($_GET['lider']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Analista")){
        $id = $_GET['lider'];
        $pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id");
        $pedido = $pedidos[0];
        $id_pedido = $pedido['id_pedido'];
        $premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1 ORDER BY id_premio_perdido ASC;");
	}else{
        $id = $_SESSION['id_cliente'];
        $pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho");
        $premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE estatus = 1 ORDER BY id_premio_perdido ASC;");
	}
      $premios_planes3 = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
      $premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = 'Standard' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
      // if(count($premios_planes)<2){
      //   $premios_planes = [];
      //   $premios_planes2 = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
      //   foreach ($premios_planes2 as $premioplan) {
      //   	if(!empty($premioplan['id_producto'])){
      //       $id_plan_campana_temp = $premioplan['id_plan_campana'];
      //       $premios_planes2 = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_plan_campana = {$id_plan_campana_temp}");
      //       break;
      //     }
      //   }
      //   $premios_planes=$premios_planes2;
      // }

      $planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
      $premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
       $retos = $lider->consultarQuery("SELECT * FROM retos, retos_campana, premios WHERE retos.id_reto_campana = retos_campana.id_reto_campana and retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana and retos.id_campana = $id_campana");
        
        $retosCamp = $lider->consultarQuery("SELECT DISTINCT * FROM retos_campana, premios WHERE retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana");

        $canjeos = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and canjeos.estatus = 1 and catalogos.estatus = 1 and canjeos.id_campana = {$id_campana} and canjeos.id_despacho = {$id_despacho}");

        $canjeosUnic = $lider->consultarQuery("SELECT DISTINCT nombre_catalogo FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and canjeos.estatus = 1 and catalogos.estatus = 1 and canjeos.id_campana = {$id_campana} and canjeos.id_despacho = {$id_despacho}");



        
        $premios_autorizados = $lider->ConsultarQuery("SELECT * FROM pedidos, clientes, premios_autorizados, premios WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = premios_autorizados.id_cliente and pedidos.id_pedido = premios_autorizados.id_pedido and pedidos.id_despacho = {$id_despacho} and premios.id_premio = premios_autorizados.id_premio and clientes.id_cliente = premios_autorizados.id_cliente and premios_autorizados.estatus = 1 and clientes.estatus = 1 and premios.estatus = 1 and premios_autorizados.descripcion_PA = ''");
        $premios_autorizadosUnic = $lider->ConsultarQuery("SELECT DISTINCT premios.id_premio, premios.nombre_premio FROM pedidos, clientes, premios_autorizados, premios WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = premios_autorizados.id_cliente and pedidos.id_pedido = premios_autorizados.id_pedido and pedidos.id_despacho = 5 and premios.id_premio = premios_autorizados.id_premio and clientes.id_cliente = premios_autorizados.id_cliente and premios_autorizados.estatus = 1 and clientes.estatus = 1 and premios.estatus = 1 and premios_autorizados.descripcion_PA = ''");

        $premios_autorizados_obsequio = $lider->ConsultarQuery("SELECT * FROM pedidos, clientes, premios_autorizados, premios WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = premios_autorizados.id_cliente and pedidos.id_pedido = premios_autorizados.id_pedido and pedidos.id_despacho = {$id_despacho} and premios.id_premio = premios_autorizados.id_premio and clientes.id_cliente = premios_autorizados.id_cliente and premios_autorizados.estatus = 1 and clientes.estatus = 1 and premios.estatus = 1 and premios_autorizados.descripcion_PA <> ''");
        $premios_autorizados_obsequioUnic = $lider->ConsultarQuery("SELECT DISTINCT premios.id_premio, premios.nombre_premio FROM pedidos, clientes, premios_autorizados, premios WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = premios_autorizados.id_cliente and pedidos.id_pedido = premios_autorizados.id_pedido and pedidos.id_despacho = {$id_despacho} and premios.id_premio = premios_autorizados.id_premio and clientes.id_cliente = premios_autorizados.id_cliente and premios_autorizados.estatus = 1 and clientes.estatus = 1 and premios.estatus = 1 and premios_autorizados.descripcion_PA <> ''");


        $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and despachos.id_despacho = {$id_despacho}");
	      $pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1");
	      $despacho = $despachos[0];
	      
	      // $pagosRecorridos[0] = ['name'=> "Contado", 'id'=> "contado", 'precio'=>$despacho['contado_precio_coleccion']];
	      $iterRecor = 0;
	      foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
	        if($pagosD['tipo_pago_despacho']=="Inicial"){
	          // $pagosRecorridos[0]['fecha_pago'] = $pagosD['fecha_pago_despacho_senior'];
	          $pagosRecorridos[$iterRecor] = ['name'=> "Inicial",  'id'=> "inicial", 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior']];
	          $iterRecor++;
	        }
	      } }

	      
	      $cantidadPagosDespachosFild = [];

	      for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
	        $key = $cantidadPagosDespachos[$i];
	        if($key['cantidad'] <= $despacho['cantidad_pagos']){
	          $cantidadPagosDespachosFild[$i] = $key;
	          foreach ($pagos_despacho as $pagosD){ if(!empty($pagosD['id_despacho'])){
	            if($pagosD['tipo_pago_despacho']==$key['name']){
	              if($i < $despacho['cantidad_pagos']-1){
	                $pagosRecorridos[$iterRecor] = ['name'=> $key['name'], 'id'=> $key['id'], 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior'], 'asignacion'=>$pagosD['asignacion_pago_despacho'], 'calcular'=>1];
	                $iterRecor++;
	              }
	              if($i == $despacho['cantidad_pagos']-1){
	                $pagosRecorridos[$iterRecor] = ['name'=> $key['name'], 'id'=> $key['id'], 'precio'=>$pagosD['pago_precio_coleccion'], 'fecha_pago'=>$pagosD['fecha_pago_despacho_senior'], 'asignacion'=>$pagosD['asignacion_pago_despacho'], 'calcular'=>2];
	                $iterRecor++;
	              }
	            }
	          }}
	        }
	      }

	    // ========================== // =============================== // ============================== //
	    if(count($premios_planes)<2){
        $premios_planes = [];
        $premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");

        $id_planes_camp = [];
        $nidxp = 0;
        foreach ($pagosRecorridos as $pagosR) {
          if(!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){
          }else{
            $id_planes_camp[$nidxp]['id_tipo'] = $pagosR['name'];
            $id_planes_camp[$nidxp]['id_plan'] = 0;
            $nidxp++;
          }
        }
        for ($i=0; $i < count($id_planes_camp); $i++) { 
          foreach ($premios_planes as $key) {
            if(!empty($key['id_plan_campana'])){
              if($id_planes_camp[$i]['id_tipo']==$key['tipo_premio']){
                if($id_planes_camp[$i]['id_plan']==0){
                  $id_planes_camp[$i]['id_plan'] = $key['id_plan_campana'];
                }
              }
            }
          }
        }

        $n1 = 0;
        $premios_planes = [];
        foreach ($id_planes_camp as $keys) {
          $id_plan_camp = $keys['id_plan'];
          $tipo_plan_camp = $keys['id_tipo'];
          $newPlan = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = {$id_plan_camp} and premios_planes_campana.tipo_premio = '{$tipo_plan_camp}' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
          foreach ($newPlan as $nplan) {
            if(!empty($nplan['id_plan_campana'])){
              $premios_planes[$n1] = $nplan;
              $n1++;
            }
          }
        }
      }

      $premiosXplanes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
      $controladorPremios = [];
      $numeroX = 0;
      foreach ($planesCol as $key1) {
        if(!empty($key1['id_plan'])){
          $numeroX2 = 0;
          foreach ($pagosRecorridos as $pagosR) {
            if(!empty($controladorPremios[$numeroX]['plan'])){
              $controladorPremios[$numeroX]['tipos_premios'][$numeroX2] = $pagosR['name'];
              $controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 0;
              foreach ($premiosXplanes as $key2) {
                if(!empty($key2['id_plan'])){
                  if($key1['id_plan']==$key2['id_plan']){
                    if($key2['tipo_premio']==$pagosR['name']){
                      $controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 1;
                    }
                  }
                }
              }
            }else{
              $controladorPremios[$numeroX]['id_plan'] = $key1['id_plan'];
              $controladorPremios[$numeroX]['plan'] = $key1['nombre_plan'];
              $controladorPremios[$numeroX]['cantidad_colecciones'] = $key1['cantidad_coleccion'];
              $controladorPremios[$numeroX]['tipos_premios'][$numeroX2] = $pagosR['name'];
              $controladorPremios[$key1['nombre_plan']] = [];
              $controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 0;
              foreach ($premiosXplanes as $key2) {
                if(!empty($key2['id_plan'])){
                  if($key1['id_plan']==$key2['id_plan']){
                    if($key2['tipo_premio']==$pagosR['name']){
                      $controladorPremios[$key1['nombre_plan']][$pagosR['name']] = 1;
                    }
                  }
                }
              }
            }
            $numeroX2++;
          }
          $numeroX++;
        }
      }
      // print_r($controladorPremios['Standard']);
      // ========================== // =============================== // ============================== //

	$nombreCampana = $campana['nombre_campana'];
	$numeroCampana = $campana['numero_campana'];
	$anioCampana = $campana['anio_campana'];


	$configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
		$accesoBloqueo = "0";
		$superAnalistaBloqueo="1";
		$analistaBloqueo="1";
		foreach ($configuraciones as $config) {
			if(!empty($config['id_configuracion'])){
				if($config['clausula']=='Analistabloqueolideres'){
					$analistaBloqueo = $config['valor'];
				}
				if($config['clausula']=='Superanalistabloqueolideres'){
					$superAnalistaBloqueo = $config['valor'];
				}
			}
		}
		if($_SESSION['nombre_rol']=="Analista"){$accesoBloqueo = $analistaBloqueo;}
		if($_SESSION['nombre_rol']=="Analista Supervisor"){$accesoBloqueo = $superAnalistaBloqueo;}
		if($accesoBloqueo=="0"){
			// echo "Acceso Abierto";
		}
		if($accesoBloqueo=="1"){
			// echo "Acceso Restringido";
			$accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['id_usuario']}");
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
				<style>*{font-size:0.98em;color:#434343;font-family:'Helvetica';} h2,h3{color:#656565;} th{font-size:0.82em;} .cellTam1{font-size:0.7em;} .cellTam2{font-size:0.8em;}</style>
			<link rel='shortcut icon' type='image/k-icon' href='public/assets/img/icon.jpg' class='img-circle'>
		<title>Premios Alcanzados de Campaña ".$numeroCampana."/".$anioCampana." - StyleCollection</title>
		
	</head>
	<body>
	<style>
	body{
		font-family:'arial';
	}
	</style>
	<div class='row' style='padding:0;margin:0;'>
		<div class='col-xs-12'  style='width:100%;'>
			<h3 style='text-align:right;float:right;'><small>StyleCollection- ".$nombreCampana."</small></h3>
			<h2 style='font-size:1.2em;'> Premios Alcanzados - Campaña ".$numeroCampana."/".$anioCampana."</h2>
			<br>
		";		

		$info .= "<table class='table  text-center' style='font-size:1.2em;width:110%;position:relative;left:-5%;'>
					<thead style='background:#efefef55;font-size:1.05em;'>
						<tr class='text-center'>
							<th style='width:8%;'>Nº</th>
							<th style='width:22%;'>Lider</th>
							<th style='width:20%;'>Colecciones</th>
							<th style='width:20%;'>Planes Seleccionado</th>
							<th style='width:40%;'>Premios Alcanzados</th>
						</tr>
					</thead>
					<tbody> ";
						$planes = $lider->consultarQuery("SELECT planes.id_plan, planes.nombre_plan FROM planes, planes_campana, campanas, despachos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = campanas.id_campana and campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
						$premios = $lider->consultarQuery("SELECT planes_campana.id_plan, planes.nombre_plan, premios.id_premio, premios.nombre_premio FROM premios, tipos_premios_planes_campana, premios_planes_campana, planes_campana, planes, despachos WHERE premios.id_premio = tipos_premios_planes_campana.id_premio and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and tipos_premios_planes_campana.tipo_premio_producto = 'Premios' and planes_campana.id_plan = planes.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
						$num = 1; 
						$acumColecciones = 0;
						$totalesPremios = [];

						$acumRetos = [];
						$numb = 0;
						foreach ($retosCamp as $ret) {
							if(!empty($ret['id_premio'])){
								$acumRetos[$numb]['nombre'] = $ret['nombre_premio'];
								$acumRetos[$numb]['cantidad'] = 0;
								$numb++;
							}
						}

						$acumpremioAutorizados = [];
						$numbPA = 0;
						foreach ($premios_autorizadosUnic as $pa) {
							if(!empty($pa['id_premio'])){
								$acumpremioAutorizados[$numbPA]['nombre'] = $pa['nombre_premio'];
								$acumpremioAutorizados[$numbPA]['cantidad'] = 0;
								$numbPA++;
							}
						}

						$acumpremioAutorizadosOBS = [];
						$numbPAOBS = 0;
						foreach ($premios_autorizados_obsequioUnic as $pa) {
							if(!empty($pa['id_premio'])){
								$acumpremioAutorizadosOBS[$numbPAOBS]['nombre'] = $pa['nombre_premio'];
								$acumpremioAutorizadosOBS[$numbPAOBS]['cantidad'] = 0;
								$numbPAOBS++;
							}
						}

                
							$num = 1;
							foreach ($pedidos as $data){ if(!empty($data['id_pedido'])){
								$permitido = "0";
								if($accesoBloqueo=="1"){
									if(!empty($accesosEstructuras)){
										foreach ($accesosEstructuras as $struct) {
											if(!empty($struct['id_cliente'])){
												if($struct['id_cliente']==$data['id_cliente']){
													$permitido = "1";
												}
											}
										}
									}
								}else if($accesoBloqueo=="0"){
									$permitido = "1";
								}

								if($permitido=="1"){
									if($data['cantidad_aprobado']>0){
										// ========================== // =============================== // ============================== //
										$coleccionesPlanPremioPedido = [];
										// ========================== // =============================== // ============================== //
										$info .= "<tr class='text-center'>
											<td style='width:8%;' class='cellTam1'>".$num."</td>
											<td style='width:22%;' class='cellTam1'>
												".number_format($data['cedula'],0,'','.')."<br>".$data['primer_nombre']." ".$data['primer_apellido']."<br>
												".$data['cantidad_aprobado']." Colecciones<br>Aprobadas"."

											</td>
											<td style='width:70%;text-align:justify;' colspan='3' class='cellTam2'>
												<table class='table' style='width:100%;background:none;'>";
													foreach ($pagosRecorridos as $pagosR){
														if (!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){
															foreach ($planesCol as $data2){ if(!empty($data2['id_cliente'])){
																if ($data['id_cliente'] == $data2['id_cliente']){
																	if ($data2['cantidad_coleccion_plan']>0){
																		$info .= "<tr><td colspan='3' style='border-bottom:1px solid #EEE;box-sizing:border-box;'></td></tr>";
																		$info .= "<tr>
																			<td style='width:30%;text-align:left;'>";
																				$colss = ($data2['cantidad_coleccion']*$data2['cantidad_coleccion_plan']);
																				$acumColecciones += $colss;
																				$info .= $acumColecciones." Colecciones 
																			</td>
																			<td style='width:30%;text-align:left;'>";
																				$info .=$data2['cantidad_coleccion_plan']." Plan ".$data2['nombre_plan']."<br>";
																				if(!empty($totalesPremios[$data2['nombre_plan']]['colecciones'])){
																					$totalesPremios[$data2['nombre_plan']]['colecciones'] += $data2['cantidad_coleccion_plan'];
																				}else{
																					$totalesPremios[$data2['nombre_plan']]['colecciones'] = $data2['cantidad_coleccion_plan'];
																				}
																				// ========================== // =============================== // ============================== //
																				$coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_seleccionada'] = $data2['cantidad_coleccion_plan'];
																				$coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada'] = 0;
																				// ========================== // =============================== // ============================== //
																			$info .= "</td>
																			<td style='width:40%;text-align:left;'>

																				<table class='' style='width:100%;background:none'>
																					<tr>
																						<td style='text-align:left;'>";
																							foreach ($premios_perdidos as $dataperdidos) {
																								if(!empty($dataperdidos['id_premio_perdido'])){
                                                  if($dataperdidos['id_pedido'] == $data['id_pedido']){
                                                    $comparedPlan = "";
                                                    if($dataperdidos['codigo']=="nombre"){
                                                      $comparedPlan = $data2['nombre_plan'];
                                                    }
                                                    if($dataperdidos['codigo']=="nombreid"){
                                                      $comparedPlan = $data2['id_plan'];
                                                    }
  																									// if(($dataperdidos['valor'] == $data2['nombre_plan']) && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
                                                    if( ($dataperdidos['valor'] == $comparedPlan) ){
  																										$alcanzados = $data2['cantidad_coleccion_plan'] - $dataperdidos['cantidad_premios_perdidos'];
  																										// ========================== // =============================== // ============================== //
  																										if(!empty($coleccionesPlanPremioPedido[$data2['nombre_plan']])){
  																											if($coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada']==0){
  																												$coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada'] = $alcanzados;
  																											}
  																										}
  																										// ========================== // =============================== // ============================== //
  																										foreach ($premios_planes3 as $planstandard){
  																											if ($planstandard['id_plan_campana']){
  																												if ($data2['nombre_plan'] == $planstandard['nombre_plan']){
  																													if ($planstandard['tipo_premio']==$pagosR['name']){
  																														$info .= "<table style='width:100%;'>
  																															<tr>
  																																<td style='text-align:left;'>".
  																																	"(".$alcanzados.") ".$planstandard['producto']."
  																																</td>
  																																<td style='text-align:right;'>";
  																																	$porcentSelected = $data2['cantidad_coleccion_plan'];
  																																	$porcentAlcanzados = $alcanzados;
  																																	$porcentResul = ($porcentAlcanzados/$porcentSelected)*100;
  																																	if(!empty($totalesPremios[$data2['nombre_plan']][$planstandard['producto']])){
  																																		$totalesPremios[$data2['nombre_plan']][$planstandard['producto']]['cantidad'] += $alcanzados;
  																																	}else{
  																																		$totalesPremios[$data2['nombre_plan']]['name'] = $data2['nombre_plan'];
  																																		$totalesPremios[$data2['nombre_plan']][$planstandard['producto']] = ['id'=>$data2['nombre_plan'], 'name'=>$data2['nombre_plan'], 'cantidad'=>$alcanzados];
  																																	}
  																																	$info .= "<b>".number_format($porcentResul,2,',','.')."%</b>
  																																</td>
  																															</tr>
  																														</table>";
  																													}
  																												}
  																											}
  																										}
  									                                }
                                                  }
                                                }
									                            }
																						$info .= "</td>
																					</tr>";
																					$nx = 0;
																					// ========================== // =============================== // ============================== //
																					$nuevoTSelected = 0;
																					// ========================== // =============================== // ============================== //
																					foreach ($premioscol as $data3){ if(!empty($data3['id_premio'])){
																						if ($data3['id_plan']==$data2['id_plan']){
																							if ($data['id_pedido']==$data3['id_pedido']){
																								$totalesPremios[$data2['nombre_plan']]['premios'][$nx] = $data3['nombre_premio'];
																								$nx++;
																								if($data3['cantidad_premios_plan']>0){
																									$info.= "<tr>
																										<td style='text-align:left;'>";
																											foreach ($premios_perdidos as $dataperdidos) {
																												if(!empty($dataperdidos['id_premio_perdido'])){
																													if(($dataperdidos['id_tipo_coleccion'] == $data3['id_tipo_coleccion']) && ($dataperdidos['id_tppc'] == $data3['id_tppc'])){
																														$alcanzados = $data3['cantidad_premios_plan'] - $dataperdidos['cantidad_premios_perdidos'];
																														// ========================== // =============================== // ============================== //
																														$nuevoTSelected += $alcanzados;
																														// ========================== // =============================== // ============================== //
																														$info .= "<table style='width:100%;'>
																															<tr>
																																<td style='text-align:left;'>".
																																	"(".$alcanzados.") ".$data3['nombre_premio']."
																																</td>
																																<td style='text-align:right;'>";
																																	$porcentSelected = $data3['cantidad_premios_plan'];
																																	$porcentAlcanzados = $alcanzados;
																																	$porcentResul = ($porcentAlcanzados/$porcentSelected)*100;
																																	if(!empty($totalesPremios[$data2['nombre_plan']][$data3['nombre_premio']])){
																																		$totalesPremios[$data2['nombre_plan']][$data3['nombre_premio']]['cantidad'] += $alcanzados;
																																	}else{
																																		$totalesPremios[$data2['nombre_plan']]['name'] = $data2['nombre_plan'];
																																		$totalesPremios[$data2['nombre_plan']][$data3['nombre_premio']] = ['id'=>$data2['nombre_plan'], 'name'=>$data2['nombre_plan'], 'cantidad'=>$alcanzados];
																																	}
																																	$info .= "<b>".number_format($porcentResul,2,',','.')."%</b>
																																</td>
																															</tr>
																														</table>";
																													}
																												}
																											}
																										$info .= "</td>
																									</tr>";
																								}
																							}
																						}
																					} }
																					// ========================== // =============================== // ============================== //
																					// echo "<b>".$data2['nombre_plan']." ".$nuevoTSelected." ".$coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada']."</b><br>";
																					if(!empty($coleccionesPlanPremioPedido[$data2['nombre_plan']])){
																						if($coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada']==0){
																							$coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada'] = $nuevoTSelected;
																						}
																					}
																					// echo "<b>".$data2['nombre_plan']." ".$nuevoTSelected." ".$coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada']."</b><br>";
																					// ========================== // =============================== // ============================== //
																				$info .= "</table>
																			</td>
																		</tr>";
																	}
																}
															} }
														}else{
															$info .= "<tr><td colspan='3' style='border-bottom:1px solid #EEE;box-sizing:border-box;'></td></tr>";
															$info .= "<tr>
																<td style='text-align:left;'>
																	".$data['cantidad_aprobado']." Colecciones<br>
																</td>
																<td style='text-align:left;'>
																	".$data['cantidad_aprobado']." Premios de ".$pagosR['name']."<br>";
																	if(!empty($totalesPremios[$pagosR['name']]['colecciones'])){
																		$totalesPremios[$pagosR['name']]['colecciones'] += $data['cantidad_aprobado'];
																	}else{
																		$totalesPremios[$pagosR['name']]['colecciones'] = $data['cantidad_aprobado'];
																	}
																	// ========================== // =============================== // ============================== //
																	$maxDisponiblePremiosSeleccion = 0;
																	$opMaxDisp = 0;
																	foreach ($planesCol as $data2){ if(!empty($data2['id_cliente'])){
																		if ($data['id_pedido'] == $data2['id_pedido']){
																			if ($data2['cantidad_coleccion_plan']>0){
																				if(!empty($coleccionesPlanPremioPedido[$data2['nombre_plan']])){
																					$opMaxDisp = 1;
																					$seleccionado = $coleccionesPlanPremioPedido[$data2['nombre_plan']]['cantidad_alcanzada'];
																					$cantidadCols = $data2['cantidad_coleccion'] * $seleccionado;
																					$premiosDispPlanSeleccion = $controladorPremios[$data2['nombre_plan']][$pagosR['name']];
																					$multiDisponiblePremiosSeleccion = ($premiosDispPlanSeleccion*$cantidadCols);
																					$maxDisponiblePremiosSeleccion += $multiDisponiblePremiosSeleccion;
																					// echo $premiosDispPlanSeleccion."*".$cantidadCols." = ".$multiDisponiblePremiosSeleccion." Cols. de Plan ".$data2['nombre_plan']."<br>";
																				}
																			}
																		}
																	} }
																	if($opMaxDisp==0){
																		$maxDisponiblePremiosSeleccion = -1;
																	}
																	// ========================== // =============================== // ============================== //

					                      $info .= "</td>
					                      <td style='width:50%;'>
					                        <table class='' style='width:100%;background:none'> 
				                            <tr>
				                            	<td style='text-align:left;'>";
																					foreach ($premios_perdidos as $dataperdidos) {
																						if(!empty($dataperdidos['id_premio_perdido'])){
                                              // if(($dataperdidos['valor'] == $pagosR['id']) && ($dataperdidos['id_pedido'] == $data['id_pedido'])){
                                              if($dataperdidos['id_pedido'] == $data['id_pedido']){
                                                $posOrigin = strpos($dataperdidos['valor'], "_pago");
                                                $posIDPago = strpos($dataperdidos['valor'], "_pago") + strlen("_pago");
                                                $dataNamePerdido = substr($dataperdidos['valor'], 0, $posIDPago);
                                                $dataNamePerdidoIdPlan = substr($dataperdidos['valor'], $posIDPago);
                                                $dataComparar = "";
                                                if($posOrigin==""){
                                                  $dataComparar = $dataperdidos['valor'];
                                                }else{
                                                  $dataComparar = $dataNamePerdido;
                                                }
                                                if(($dataComparar == $pagosR['id'])){
                                                  if($dataNamePerdidoIdPlan==""){
    																								$alcanzados = $data['cantidad_aprobado'] - $dataperdidos['cantidad_premios_perdidos'];
    																								// ========================== // =============================== // ============================== //
    																								if($maxDisponiblePremiosSeleccion>0){
    																									if($alcanzados>$maxDisponiblePremiosSeleccion){
    																										$alcanzados = $maxDisponiblePremiosSeleccion;
    																									}
    																								}
    																								// ========================== // =============================== // ============================== //
    																								foreach ($premios_planes as $planstandard){
    																									if (!empty($planstandard['id_plan_campana'])){
    																										if ($planstandard['tipo_premio']==$pagosR['name']){
    																											$info .= "<table style='width:100%;'>
    																												<tr>
    																													<td style='text-align:left;'>".
    																														"(".$alcanzados.") ".$planstandard['producto']."
    																													</td>
    																													<td style='text-align:right;'>";
    																														$porcentSelected = $data['cantidad_aprobado'];
    																														$porcentAlcanzados = $alcanzados;
    																														$porcentResul = ($porcentAlcanzados/$porcentSelected)*100;
    																														if(!empty($totalesPremios[$pagosR['name']][$planstandard['producto']])){
    																															$totalesPremios[$pagosR['name']][$planstandard['producto']]['cantidad'] += $alcanzados;
    																														}else{
    																															$totalesPremios[$pagosR['name']]['name'] = $pagosR['name'];
    																															$totalesPremios[$pagosR['name']][$planstandard['producto']] = ['id'=>$pagosR['id'], 'plan'=>$planstandard['nombre_plan'], 'name'=>$pagosR['name'], 'cantidad'=>$alcanzados];
    																														}
    																														$info .= "<b>".number_format($porcentResul,2,',','.')."%</b>
    																													</td>
    																												</tr>
    																											</table>";
    																										}
    																									}
    																								}
                                                  } else {

                                                    foreach ($planesCol as $data2){ if(!empty($data2['id_cliente'])){
                                                      if ($data['id_pedido'] == $data2['id_pedido']){
                                                        if ($data2['cantidad_coleccion_plan']>0){
                                                          if($dataNamePerdidoIdPlan==$data2['id_plan']){
                                                            if(!empty($dataperdidos['id_premio_perdido'])){
                                                              
                                                              $alcanzados = $data2['cantidad_coleccion_plan'] - $dataperdidos['cantidad_premios_perdidos'];
                                                              // ========================== // =============================== // ============================== //
                                                              if($maxDisponiblePremiosSeleccion>0){
                                                                if($alcanzados>$maxDisponiblePremiosSeleccion){
                                                                  $alcanzados = $maxDisponiblePremiosSeleccion;
                                                                }
                                                              }
                                                              // ========================== // =============================== // ============================== //
                                                              foreach ($premios_planes3 as $premiosP) { if(!empty($premiosP['nombre_plan'])){
                                                                if($data2['nombre_plan']==$premiosP['nombre_plan']){
                                                                  if($pagosR['name']==$premiosP['tipo_premio']){
                                                                    $info .= "<table style='width:100%;'>
                                                                      <tr>
                                                                        <td style='width:60%;text-align:left;'>".
                                                                          "(".$alcanzados.") ".$premiosP['producto']."
                                                                        </td>
                                                                        <td style='width:25%;text-align:left;'>".
                                                                          "(".$data2['nombre_plan'].")
                                                                        </td>
                                                                        <td style='width:15%;text-align:right;'>";
                                                                          $porcentSelected = $data['cantidad_aprobado'];
                                                                          $porcentPerdido = $alcanzados;
                                                                          $porcentResul = ($porcentPerdido/$porcentSelected)*100;
                                                                          if(!empty($totalesPremios[$pagosR['name']][$premiosP['producto']])){
                                                                            $totalesPremios[$pagosR['name']][$premiosP['producto']]['cantidad'] += $alcanzados;
                                                                          }else{
                                                                            $totalesPremios[$pagosR['name']]['name'] = $pagosR['name'];
                                                                            $totalesPremios[$pagosR['name']][$premiosP['producto']] = ['id'=>$pagosR['id'], 'plan'=>$data2['nombre_plan'], 'name'=>$pagosR['name'], 'cantidad'=>$alcanzados];
                                                                          }
                                                                          $info .= "<b>".number_format($porcentResul,2,',','.')."%</b>
                                                                        </td>
                                                                      </tr>
                                                                    </table>";
                                                                  }
                                                                }
                                                              } }

                                                            }
                                                          }
                                                        }
                                                      }
                                                    } }


                                                  }
                                                }


																							}
																						}
																					}
																			$info .= "</td>
				                            </tr>
					                        </table>
					                      </td>
					                    </tr>";
														}
													}


													$cantidad_retos_actual = 0;
													foreach ($retos as $reto){
														if (!empty($reto['id_reto'])){
															if ($reto['id_pedido']==$data['id_pedido']){
																if ($reto['cantidad_retos']>0){
																	$cantidad_retos_actual++;
																}
															}
														}
													}

													if ($cantidad_retos_actual>0){
														$info .= "<tr><td colspan='3' style='border-bottom:1px solid #EEE;box-sizing:border-box;'></td></tr>";
														$info .= "<tr>
															<td style='text-align:left;'>
																".$data['cantidad_aprobado']." Colecciones
															</td>
															<td style='text-align:left;'>
																Retos Solicitados
															</td>
															<td style='text-align:left;font-size:0.85em;'>";
																foreach ($retos as $reto){
																	if (!empty($reto['id_reto'])){
																		if ($reto['id_pedido']==$data['id_pedido']){
																			if ($reto['cantidad_retos']>0){
																				$info .= "(".$reto['cantidad_retos'].") ".$reto['nombre_premio']."<br>";
																				for ($i=0; $i < count($acumRetos); $i++) {
																					if($acumRetos[$i]['nombre']==$reto['nombre_premio']){
																						$acumRetos[$i]['cantidad'] += $reto['cantidad_retos'];
																					} 
																				}
																			}
																		}
																	}
																}
															$info .= "</td>
														</tr>";
													}


													$cantidad_PA_actual = 0;
													foreach ($premios_autorizados as $premioAutorizado){
														if (!empty($premioAutorizado['id_PA'])){
															if ($premioAutorizado['id_pedido']==$data['id_pedido']){
																if ($premioAutorizado['cantidad_PA']>0){
																	$cantidad_PA_actual++;
																}
															}
														}
													}

													if($cantidad_PA_actual>0){
														$info .= "<tr><td colspan='3' style='border-bottom:1px solid #EEE;box-sizing:border-box;'></td></tr>";
														$info .= "<tr>
															<td style='text-align:left;'>
															</td>
															<td style='text-align:left;'>
																Premios Autorizados
															</td>
															<td style='text-align:left;font-size:0.85em;'>";
															foreach ($premios_autorizados as $premioAutorizado){
																if (!empty($premioAutorizado['id_PA'])){
																	if ($premioAutorizado['id_pedido']==$data['id_pedido']){
																		if ($premioAutorizado['cantidad_PA']>0){
																			$info .= "(".$premioAutorizado['cantidad_PA'].") ".$premioAutorizado['nombre_premio']."<br>";
																			for ($i=0; $i < count($acumpremioAutorizados); $i++) {
																				if($acumpremioAutorizados[$i]['nombre']==$premioAutorizado['nombre_premio']){
																					$acumpremioAutorizados[$i]['cantidad'] += $premioAutorizado['cantidad_PA'];
																				} 
																			}
																		}
																	}
																}
															}
															$info .= "</td>
														</tr>";
													}


													$cantidad_PAOBS_actual = 0;
													foreach ($premios_autorizados_obsequio as $premioAutorizado){
														if (!empty($premioAutorizado['id_PA'])){
															if ($premioAutorizado['id_pedido']==$data['id_pedido']){
																if ($premioAutorizado['cantidad_PA']>0){
																	$cantidad_PAOBS_actual++;
																}
															}
														}
													}

													if($cantidad_PAOBS_actual>0){
														$info .= "<tr><td colspan='3' style='border-bottom:1px solid #EEE;box-sizing:border-box;'></td></tr>";
														$info .= "<tr>
															<td style='text-align:left;'>
															</td>
															<td style='text-align:left;'>
																Premios Adicionales
															</td>
															<td style='text-align:left;font-size:0.85em;'>";
																foreach ($premios_autorizados_obsequio as $premioAutorizado){
																	if (!empty($premioAutorizado['id_PA'])){
																		if ($premioAutorizado['id_pedido']==$data['id_pedido']){
																			if ($premioAutorizado['cantidad_PA']>0){
																				$info .= "(".$premioAutorizado['cantidad_PA'].") ".$premioAutorizado['nombre_premio']."<br>";
																				for ($i=0; $i < count($acumpremioAutorizadosOBS); $i++) {
																					if($acumpremioAutorizadosOBS[$i]['nombre']==$premioAutorizado['nombre_premio']){
																						$acumpremioAutorizadosOBS[$i]['cantidad'] += $premioAutorizado['cantidad_PA'];
																					} 
																				}
																			}
																		}
																	}
																}
															$info .= "</td>
														</tr>";
													}

													

													$liddd = 0;
													foreach ($canjeos as $canje){
														if (!empty($canje['id_cliente'])){
															if ($canje['id_cliente']==$data['id_cliente']){
																$liddd = 1;
															}
														}
													}
													if ($liddd == "1"){
														$info .= "<tr><td colspan='3' style='border-bottom:1px solid #EEE;box-sizing:border-box;'></td></tr>";
														$info .= "<tr>
                          		<td></td>
                 	         		<td style='text-align:left;'>Premios Canjeados</td>
                          		<td style='text-align:left;font-size:0.85em;'>";
                          			$arrayt = [];
                          			$numCC = 0;
                          			foreach ($canjeosUnic as $canUnic) {
                          				if(!empty($canUnic['nombre_catalogo'])){
                          					$arrayt[$numCC]['nombre'] = $canUnic['nombre_catalogo'];
                          					$arrayt[$numCC]['cantidad'] = 0;
                          					$numCC++;
                          				}
                          			}
                          			foreach ($canjeos as $canje){
                          				if (!empty($canje['id_cliente'])){
                          					if ($canje['id_cliente']==$data['id_cliente']){
                          						for ($i=0; $i < count($arrayt); $i++) { 
                          							if($canje['nombre_catalogo']==$arrayt[$i]['nombre']){
                          								$arrayt[$i]['cantidad']++;
                          							}
                          						}
                          					}
                          				}
                          			}
                          			foreach ($arrayt as $arr) {
                          				if($arr['cantidad']>0){
                          					$info .= "(".$arr['cantidad'].") ".$arr['nombre']."<br>";
                          				}
                          			}
                            	$info .= "</td>
                            </tr>";
						              }
						            $info .= "</table>
						          </td>
										</tr>";
										$info .= "<tr><td colspan='5' style='border-bottom:1px solid #EEE;box-sizing:border-box;'></td></tr>";
									}
								}
								$num++;
						} }


						$info .= " <tr style='background:#EDEDED'>
							<td></td>
							<td></td>
							<td style='text-align:left;' class='cellTam2'>".$acumColecciones." Colecciones</td>
							<td colspan='2' style='text-align:left;width:70%;' class='cellTam2'>
								<table class='table table-hover' style='width:100%;background:none;'>";
									foreach ($pagosRecorridos as $pagosR){
										if (!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){
											foreach ($planes as $plan){
												if (!empty($plan['nombre_plan'])){
													if(!empty($totalesPremios[$plan['nombre_plan']]['colecciones'])){
														if($totalesPremios[$plan['nombre_plan']]['colecciones']>0){
															$info .= "<tr><td colspan='3' style='border-bottom:1px solid #FFF;box-sizing:border-box;'></td></tr>";
															$info .= "<tr>
																<td style='text-align:left;width:35%;'>
																	".$totalesPremios[$plan['nombre_plan']]['colecciones']." Plan ".$plan['nombre_plan']."<br>
																</td>
																<td style='text-align:left;width:65%;'>";
                                  $sql0 = "SELECT DISTINCT * FROM tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes.id_plan={$plan['id_plan']} and premios_planes_campana.tipo_premio='{$pagosR['name']}' ORDER BY planes.id_plan ASC";
                                  $tempPlanes = $lider->consultarQuery($sql0);
                                  $nameTPlanesTemp = $tempPlanes[0]['tipo_premio_producto'];
                                  $namePlanesTemp = $plan['nombre_plan'];
																	// if ($plan['nombre_plan']=='Standard'){
                                  if(mb_strtolower($nameTPlanesTemp)==mb_strtolower("Productos")){
																		foreach ($premios_planes3 as $planstandard){
																			if ($planstandard['id_plan_campana']){
																				if ($plan['nombre_plan'] == $planstandard['nombre_plan']){
																					if ($planstandard['tipo_premio']==$pagosR['name']){
																						foreach ($totalesPremios as $key) {
																							if(!empty($key['name']) && $key['name'] == $plan['nombre_plan']){
																								if(!empty($key[$planstandard['producto']])){
																									$cantidadMostrar = $key[$planstandard['producto']]['cantidad'];
																									//if($cantidadMostrar>0){
																										$info .= "<table style='width:100%;'>
																											<tr>
																												<td style='text-align:left;'>".
																													"(".$cantidadMostrar.") ".$planstandard['producto']."
																												</td>
																												<td style='text-align:right;'>";
																													$totSelected = $totalesPremios[$plan['nombre_plan']]['colecciones'];
																													$totAlcanzado = $cantidadMostrar;
																													$totResul = ($totAlcanzado/$totSelected)*100;
																													$info .= "<b>".number_format($totResul,2,',','.')."%</b>
																												</td>
																											</tr>
																										</table>";
																									//}
																								}
																							}
																						}
																					}
																				}
																			}
																		}
																	}else{
																		foreach ($totalesPremios as $key){
																			if(!empty($key['name']) && $key['name'] == $plan['nombre_plan']){
																				if(!empty($key['premios'])){
																					$premios = $key['premios'];
																					foreach ($premios as $nombrePremio){
																						if(!empty($key[$nombrePremio])){
																							$cantidadMostrar = $key[$nombrePremio]['cantidad'];
																							//if ($cantidadMostrar>0){
																								$info .= "<table style='width:100%;'>
																									<tr>
																										<td style='text-align:left;'>".
																											"(".$cantidadMostrar.") ".$nombrePremio."
																										</td>
																										<td style='text-align:right;'>";
																											$totSelected = $totalesPremios[$plan['nombre_plan']]['colecciones'];
																											$totAlcanzado = $cantidadMostrar;
																											$totResul = ($totAlcanzado/$totSelected)*100;
																											$info .= "<b>".number_format($totResul,2,',','.')."%</b>
																										</td>
																									</tr>
																								</table>";
																							//}
																						}
																					}
																				}
																			}
																		}
						                      }
						                    $info .= "</td>
															</tr>";
														}
													}
	                      }
	                    }
                  	} else {
                  		$info .= "<tr><td colspan='3' style='border-bottom:1px solid #FFF;box-sizing:border-box;'></td></tr>";
											$info .= "<tr>
												<td style='text-align:left;'>
													".$acumColecciones." Premios de ".$pagosR['name']."
												</td>
												<td style='text-align:left;'>";
												
												foreach ($premios_planes3 as $planstandard){
													if ($planstandard['id_plan_campana']){
														if ($planstandard['tipo_premio']==$pagosR['name']){
															foreach ($totalesPremios as $key) {
																if(!empty($key['name']) && $key['name'] == $planstandard['tipo_premio']){
																	if(!empty($key[$planstandard['producto']])){
                                    if($key[$planstandard['producto']]['plan']==$planstandard['nombre_plan']){
  																		$cantidadMostrar = $key[$planstandard['producto']]['cantidad'];
  																		//if($cantidadMostrar>0){
  																			$info .= "<table style='width:100%;'>
  																				<tr>
  																					<td style='width:60%;text-align:left;'>".
                                              "(".$cantidadMostrar.") ".$planstandard['producto']."
                                            </td>
                                            <td style='width:25%;text-align:left;'>".
                                              "(".$key[$planstandard['producto']]['plan'].")
                                            </td>
  																					<td style='width:15%;text-align:right;'>";
  																						$totSelected = $acumColecciones;
  																						$totAlcanzado = $cantidadMostrar;
  																						$totResul = ($totAlcanzado/$totSelected)*100;
  																						$info .= "<b>".number_format($totResul,2,',','.')."%</b>

  																					</td>
  																				</tr>
  																			</table>";
                                      //}
                                    }
																	}
																}
															}
														}
													}
												}
												$info .= "
												</td>
											</tr>";
                  	}
									}

									$info .= "<tr><td colspan='3' style='border-bottom:1px solid #FFF;box-sizing:border-box;'></td></tr>";
									$info .=" <tr>
										<td style='text-align:left;width:35%;'>
											Retos Solicitados
										</td>
										<td style='text-align:left;width:65%;'>";
											foreach ($acumRetos as $key){
												if($key['cantidad']>0){
													$info .= "(".$key['cantidad'].") ".$key['nombre']."<br>";
												}
											}
										$info .= "</td>
									</tr>";

									$info .= "<tr><td colspan='3' style='border-bottom:1px solid #FFF;box-sizing:border-box;'></td></tr>";
									$info .=" <tr>
										<td style='text-align:left;width:35%;'>
											Premios Autorizados
										</td>
										<td style='text-align:left;width:65%;'>";
											foreach ($acumpremioAutorizados as $key){
												if($key['cantidad']>0){
													$info .= "(".$key['cantidad'].") ".$key['nombre']."<br>";
												}
											}
										$info .= "</td>
									</tr>";

									$info .= "<tr><td colspan='3' style='border-bottom:1px solid #FFF;box-sizing:border-box;'></td></tr>";
									$info .=" <tr>
										<td style='text-align:left;width:35%;'>
											Premios Adicionales
										</td>
										<td style='text-align:left;width:65%;'>";
											foreach ($acumpremioAutorizadosOBS as $key){
												if($key['cantidad']>0){
													$info .= "(".$key['cantidad'].") ".$key['nombre']."<br>";
												}
											}
										$info .= "</td>
									</tr>";

									$info .= "<tr><td colspan='3' style='border-bottom:1px solid #FFF;box-sizing:border-box;'></td></tr>";
									$info .=" <tr>
										<td style='text-align:left;'>Premios Canjeados</td>
										<td style='text-align:left;'>";
											$arrayt2 = [];
											$numCC = 0;
											foreach ($canjeosUnic as $canUnic) {
												if(!empty($canUnic['nombre_catalogo'])){
													$arrayt2[$numCC]['nombre'] = $canUnic['nombre_catalogo'];
													$arrayt2[$numCC]['cantidad'] = 0;
													$numCC++;
												}
											}
											foreach ($canjeos as $canje){
												if (!empty($canje['id_cliente'])){
													$permitido2 = "0";
													if($accesoBloqueo=="1"){
														if(!empty($accesosEstructuras)){
															foreach ($accesosEstructuras as $struct) {
																if(!empty($struct['id_cliente'])){
																	if($struct['id_cliente']==$canje['id_cliente']){
																		$permitido2 = "1";
																	}
																}
															}
														}
													}else if($accesoBloqueo=="0"){
														$permitido2 = "1";
													}

													if($permitido2=="1"){
														for ($i=0; $i < count($arrayt2); $i++) { 
															if($canje['nombre_catalogo']==$arrayt2[$i]['nombre']){
																$arrayt2[$i]['cantidad']++;
															}
														}
													}
												}
											}

											foreach ($arrayt2 as $arr) {
												if($arr['cantidad']>0){
													$info .= "(".$arr['cantidad'].") ".$arr['nombre']."<br>";
												}
											}
										$info .= "</td>
									</tr>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
				
			  ";
					// print_r($acumPlanes);
					// print_r($acumPremios);
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

	$pgl1 = 96.001;
	$ancho = 528.00;
	$alto = 816.009;
	// $altoMedio = $alto / 2;
	$dompdf->loadHtml($info);
	$dompdf->render();
	$dompdf->stream("Premios Alcanzados de Campaña {$numeroCampana}-{$anioCampana} - StyleCollection", array("Attachment" => false));
	// echo $info;
}else{
  require_once 'public/views/error404.php';
}
?>