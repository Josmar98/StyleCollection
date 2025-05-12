<?php 


// $amTasas = 0;
// $amTasasR = 0;
// $amTasasC = 0;
// $amTasasE = 0;
// $amTasasB = 0;
// foreach ($accesos as $access) {
//   if(!empty($access['id_acceso'])){
//     if($access['nombre_modulo'] == "Tasas"){
//       $amTasas = 1;
//       if($access['nombre_permiso'] == "Registrar"){
//         $amTasasR = 1;
//       }
//       if($access['nombre_permiso'] == "Ver"){
//         $amTasasC = 1;
//       }
//       if($access['nombre_permiso'] == "Editar"){
//         $amTasasE = 1;
//       }
//       if($access['nombre_permiso'] == "Borrar"){
//         $amTasasB = 1;
//       }
//     }
//   }
// }
// if($amTasasR == 1){
// if($_SESSION['nombre_rol']!="Superusuario"){ die(); }
$id_campana = $_GET['campaing'];
$numero_campana = $_GET['n'];
$anio_campana = $_GET['y'];
$id_despacho = $_GET['dpid'];
$num_despacho = $_GET['dp'];
$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";
$despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and campanas.numero_campana = {$numero_campana} and despachos.id_despacho = {$id_despacho} and despachos.numero_despacho = {$num_despacho}");
	$pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1 ORDER BY pagos_despachos.id_pago_despacho ASC;");
	$despacho = $despachos[0];
	################################################
	// $pagosObligatorios = "Y";
	$opInicial = $despacho['opcion_inicial'];
	$pagosObligatorios = $despacho['opcionInicialObligatorio'];
	$inObligatoria = $despacho['opcionOpcionalInicial'];
	################################################
	// echo "<br>";
	// echo $opInicial;
	// echo "<br>";
	// echo $pagosObligatorios;
	// echo "<br>";
	// echo $inObligatoria;
	// echo "<br>";
	$cantidadPagosDespachosFild = [];
	if($pagosObligatorios == "Y"){
		if($opInicial=="Y"){
			// if($inObligatoria=="N"){
				$sumAdd = 1;
				$cantidadPagosDespachosFild[0] = ['cantidad'=>0,   'name'=> "Inicial",   'id'=> "inicial"];
			// }else{
				// $sumAdd = 0;
			// }

		}else{
			$sumAdd = 0;
		}
		for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
			$key = $cantidadPagosDespachos[$i];
			if($key['cantidad'] <= $despacho['cantidad_pagos']){
				$cantidadPagosDespachosFild[$i+$sumAdd] = $key;
			}
		}
	}
	if($pagosObligatorios == "N"){
    $sumAdd = 0;
		for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
			$key = $cantidadPagosDespachos[$i];
			if($key['cantidad'] <= $despacho['cantidad_pagos']){
				$cantidadPagosDespachosFild[$i+$sumAdd] = $key;
			}
		}
	}
  // foreach ($pagos_despacho as $key) {
  //   print_r($key['tipo_pago_despacho']);
  //   echo "<br><br>";  
  // }

  $rutaRecarga = $menu3."route=".$_GET['route']."&admin=1";
  $rutaRecargaR = $menu3."route=".$_GET['route']."&action=".$_GET['action'];
  if(!empty($_GET['admin']) && !empty($_GET['select'])){
    $rutaRecargaR .= "&admin=".$_GET['admin']."&select=".$_GET['select'];
  }
  if(!empty($_GET['lider'])){
    $rutaRecargaR .= "&lider=".$_GET['lider'];
  }

  $fechaActualHoy = date('Y-m-d');
  // $fechaActualHoy = date('Y-m-d',time()-(1*(24*3600)));
  $horaActual = date('H:i:s');
  $eficoins = $lider->consultarQuery("SELECT * FROM eficoin WHERE fecha_tasa='{$fechaActualHoy}'");
  $tasaDolarBcv = $lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa='{$fechaActualHoy}'");
  $bancosDepositos = $lider->consultarQuery("SELECT * FROM bancos WHERE tipo_cuenta='Divisas' and estatus=1 and disponibilidad='Habilitado'");
  if(!empty($_POST['tasa_eficoin_fecha'])){
    $fecha_pago = $_POST['tasa_eficoin_fecha'];
    // echo $fecha_pago;
    $efis=$lider->consultarQuery("SELECT * FROM eficoin WHERE fecha_tasa='{$fecha_pago}'");
    $bcvv=$lider->consultarQuery("SELECT * FROM tasa WHERE fecha_tasa='{$fecha_pago}'");
    $result=[];
    if(count($efis)>1){
      $result['msj_efi']="1";
      $result['data_efi']=$efis[0];
    }else{
      $result['msj_efi']="2";
    }
    if(count($bcvv)>1){
      $result['msj_bcv']="1";
      $result['data_bcv']=$bcvv[0];
    }else{
      $result['msj_bcv']="2";
    }
    if($result['msj_efi']=="1" || $result['msj_bcv']=="1"){
      $result['msj']="1";
    }
    if($result['msj_efi']=="2" || $result['msj_bcv']=="2"){
      $result['msj']="2";
    }
    echo json_encode($result);
  }
  if(!empty($_POST['fechaPago']) && !empty($_POST['tipoPago']) && !empty($_POST['serial']) && !empty($_POST['equivalente']) && empty($_POST['validarData'])){
    // print_r($_POST);
    if(!empty($_GET['lider'])){
      $id_cliente = $_GET['lider'];
    }else{
      $id_cliente = $_SESSION['id_cliente'];
    }
    $pedidos=$lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente={$id_cliente} and id_despacho={$id_despacho}");
    if(count($pedidos)>1){
      $pedido=$pedidos[0];
      $id_pedido=$pedido['id_pedido'];
      $fechaRegistro=date('Y-m-d H:i:s');
      // $fechaRegistro=date('Y-m-d');
      $fechaPago = $_POST['fechaPago'];
      $uses = $_POST['use'];
      $tasa_bcv= (float) $_POST['precio_bcv'];
      
      $turnos=[];
      foreach ($uses as $nameTurno => $value) {
        if($nameTurno=="ma"){
          if($value=="on"){
            $turnos[count($turnos)]=1;
          }
        }
        if($nameTurno=="ta"){
          if($value=="on"){
            $turnos[count($turnos)]=2;
          }
        }
      }
      $id_numero = 0;
      $eficoinssAll = $lider->consultarQuery("SELECT MAX(eficoin_divisas.numero_recibo) as numero_recibo FROM eficoin_divisas WHERE estado_pago='Abonado'");
      foreach ($eficoinssAll as $efiall) {
        if(!empty($efiall['numero_recibo'])){
          $id_numero=(int) $efiall['numero_recibo'];	
          $id_numero++;	
          // if(mb_strtolower($efiall['estado_pago'])==mb_strtolower("abonado")){
          // }
        }
      }
      $id_numero++;
      // $tasa_eficoin= (float) $_POST['precio_eficoin_total'];
      // $tipoPago = ucwords(mb_strtolower($_POST['tipoPago']));
      // $tipo_eficoin = ucwords(mb_strtolower($_POST['tipo_eficoin']));
      // $serial = mb_strtoupper($_POST['serial']);
      // $equivalente = (float) $_POST['equivalente'];
      // $total_equivalente = (float) $_POST['total_equivalente'];
      $tasa_eficoins= $_POST['precio_eficoin_total'];
      $tipoPagos = $_POST['tipoPago'];
      $tipo_eficoins = $_POST['tipo_eficoin'];
      $serials = $_POST['serial'];
      $equivalentes = $_POST['equivalente'];
      $total_equivalentes = $_POST['total_equivalente'];
      $equivalenteSumatoria = 0;
      $equivalenteTotalSumatoria = 0;
      foreach ($turnos as $turno) {
        $i = ($turno-1);
        $equivalenteSumatoria+=(float) $equivalentes[$i];
        $equivalenteTotalSumatoria+=(float) $total_equivalentes[$i];
      }
      
      $firma = ucwords(mb_strtolower($_POST['firma']));
      $leyenda = ucwords(mb_strtolower($_POST['leyenda']));
      $estado="Abonado";
      // die();
      // echo $equivalenteSumatoria." | ".$equivalenteTotalSumatoria."<br>";
  
      // BUSCAR TASAS BCV Y EFICOIN PARA REPORTAR
      // die();
  
      
      $buscar = $lider->consultarQuery("SELECT * FROM eficoin_divisas WHERE id_campana={$id_campana} and fecha_pago = '{$fechaPago}' and id_cliente={$id_cliente} and equivalente_pago LIKE '%{$equivalenteSumatoria}%' and estado_pago='{$estado}'");
      $repetido=false;
      if(count($buscar)>1){
        $repetido=true;
        $exec['ejecucion']=false;
        $response="9";
      }else{
        $monto="";
        $erroresPago=0;
        for ($i=0; $i < count($turnos); $i++) {
          $serial = mb_strtoupper($serials[$i]);
          $buscar = $lider->consultarQuery("SELECT * FROM pagos WHERE fecha_pago='{$fechaPago}' and id_pedido={$id_pedido} and referencia_pago = '{$serial}' and monto_pago = '{$monto}' and estatus = 1");
          if(count($buscar)>1){
            $erroresPago++;
          }
        }
  
        if($erroresPago==0){
          $continuar=true;
        }else{
          $continuar=false;
        }
        if($continuar==true){
          $query = "INSERT INTO eficoin_divisas (id_eficoin_div, id_campana, id_pedido, id_cliente, fecha_pago, fecha_registro, equivalente_pago, equivalente_pago_extra, numero_recibo, estado_pago, estatus) VALUES (DEFAULT, {$id_campana}, {$id_pedido}, {$id_cliente},'{$fechaPago}', '{$fechaRegistro}', {$equivalenteSumatoria}, {$equivalenteTotalSumatoria}, {$id_numero}, '{$estado}', 1)";
          // echo "<br><br>".$query."<br><br>";
          // $exec=['ejecucion'=>true, 'id'=>4];
          $exec = $lider->registrar($query, "eficoin_divisas", "id_eficoin_div");
          if($exec['ejecucion']==true){
            $id_eficoin=$exec['id'];
            $rutaPdfEficoin = $menu3."route=".$_GET['route']."&action=GenerarRecepcionPago&id=".$id_eficoin;
            foreach ($turnos as $turno) {
              $i = ($turno-1);
              // echo "turno: ".$turno."<br>";
              $tasa_eficoin = (float) $tasa_eficoins[$i];
              $tipoPago = ucwords(mb_strtolower($tipoPagos[$i]));
              $tipo_eficoin = ucwords(mb_strtolower($tipo_eficoins[$i]));
              $name_banco="";
              $id_banco="";
              if($tipo_eficoin=="Deposito"){
                $forma_pago="Deposito En Dolares";
                $forma_pago="Deposito EfiCoin";
                $name_banco=" id_banco,";
                if(!empty($_POST['banco'])){
                  $id_banco=" ".$_POST['banco'][$i].", ";
                }
              }else{
                $forma_pago="Divisas Dolares";
                $forma_pago="EfiCoin";
              }
              $serial = mb_strtoupper($serials[$i]);
              $equivalente = (float) $equivalentes[$i];
              $total_equivalente = (float) $total_equivalentes[$i];
              
              $pagoID = "C".$id_campana."Y".$anio_campana."LDR".$id_cliente."PED".$id_pedido."P";
              $numss = $lider->consultarQuery("SELECT * FROM pagos WHERE id_pago LIKE '%{$pagoID}%'");
              // print_r($numss);
              $numMax = 0;
              if(count($numss)>1){
                $len = strlen($pagoID);
                foreach ($numss as $key) {
                  if(!empty($key['id_pago'])){
                    $n = substr($key['id_pago'], $len);
                    if($n > $numMax){
                      $numMax = $n;
                    }
                  }
                }
              }
              $numero_pago = $numMax+1;
              $pagoID .= $numero_pago;
              
              $query2 = "INSERT INTO eficoin_detalle (id_detalle_eficoin, id_campana, id_eficoin_div,{$name_banco} tipo_pago, turno, referencia_pago, tasa_bcv, tasa_eficoin, equivalente_pago, equivalente_pago_total, id_pago, estatus) VALUES (DEFAULT, {$id_campana}, {$id_eficoin},{$id_banco} '{$tipoPago}', {$turno}, '{$serial}', {$tasa_bcv}, {$tasa_eficoin}, {$equivalente}, {$total_equivalente}, '{$pagoID}', 1)";
              // echo "<br><br>".$query2."<br><br>";
              // $exec2=['ejecucion'=>true, 'id'=>1];
              $exec2 = $lider->registrar($query2, "eficoin_detalle", "id_detalle_eficoin");
              if($exec2['ejecucion']==true){
                $marcaPago = $_SESSION['cuenta']['cedula']." ".$_SESSION['cuenta']['primer_nombre']." ".$_SESSION['cuenta']['primer_apellido'];
                $fecha_registro_pagos = date('Y-m-d');
                $queryPagos = "INSERT INTO pagos (id_pago, id_pedido,{$name_banco} fecha_pago, fecha_registro, forma_pago, tipo_pago, referencia_pago, monto_pago, tasa_pago, equivalente_pago, firma, leyenda, estado, id_campana, marca, estatus) VALUES ('{$pagoID}', $id_pedido,{$id_banco} '{$fechaPago}', '{$fecha_registro_pagos}', '{$forma_pago}', '$tipoPago', '{$serial}', '{$monto}', '', '$total_equivalente', '{$firma}', '{$leyenda}', 'Abonado', {$id_campana}, '{$marcaPago}', 1)";
                // echo "<br>".$queryPagos."<br>";
                // $exec3['ejecucion']=false;
                $exec3 = $lider->registrar($queryPagos, "pagos", "id_pago");
                if($exec3['ejecucion']==true){
                  $response="1";
                }else{
                  $response="2";
                }
              }else{
                $response="2";
              }
    
            }
            
          }else{
            if($repetido==true){
              $response = "9";
            }else{
              $response = "2";
            }
          }
        }else{
          $response = "9";
        }
      }
      // die();
      if($response=="1"){
        
        $id_eficoin=$exec['id'];
        $rutaPdfEficoin = $menu3."route=".$_GET['route']."&action=GenerarRecepcionPago&id=".$id_eficoin;
        
        if(!empty($modulo) && !empty($accion)){
          $fecha = date('Y-m-d');
          $hora = date('H:i:a');
          $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Eficoin Divisas', 'Reportar', '{$fecha}', '{$hora}')";
          $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
        }
      }else{
        if($repetido==true){
          $response = "9";
        }else{
          $response = "2";
        }
      }
    }else{
      $id_pedido=null;
    }
    // die();

    

    // die();
    $promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.id_cliente = {$id_cliente} and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho}");
    $lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
    // print_r($promociones);
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
    // print_r($exec);
  }

  if(empty($_POST)){
    if(!empty($_GET['lider'])){
      $id_cliente = $_GET['lider'];
    }else{
      $id_cliente = $_SESSION['id_cliente'];
    }
    $promociones = $lider->consultarQuery("SELECT * FROM promocion, promociones WHERE promocion.id_promocion = promociones.id_promocion and promociones.id_cliente = {$id_cliente} and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho}");
    $lideres = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and pedidos.estatus = 1 and clientes.estatus = 1 ORDER BY clientes.id_cliente ASC");
    // print_r($promociones);
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
  }

// }else{
//     require_once 'public/views/error404.php';
// }

?>