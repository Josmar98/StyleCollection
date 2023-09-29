<?php 

$amDespachos = 0;
$amDespachosR = 0;
$amDespachosC = 0;
$amDespachosE = 0;
$amDespachosB = 0;

foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Despachos"){
      $amDespachos = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amDespachosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amDespachosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amDespachosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amDespachosB = 1;
      }
    }
  }
}
if($amDespachosR == 1){

  $id_campana = $_GET['campaing'];
  $numero_campana = $_GET['n'];
  $anio_campana = $_GET['y'];

  if(!empty($_GET['opInicial']) && !empty($_GET['cantPagos'])){
    $cantidadPagosDespachosFild = [];
    if($_GET['cantPagos'] > 0 && $_GET['cantPagos'] <= count($cantidadPagosDespachos)){
      for ($i=0; $i < count($cantidadPagosDespachos); $i++) { 
        $key = $cantidadPagosDespachos[$i];
        if($key['cantidad'] <= $_GET['cantPagos']){
          $cantidadPagosDespachosFild[$i] = $key;
        }
      }
    }
  }



  if(!empty($_POST['validarData'])){
    $numero_despacho = $_POST['numero_despacho'];
    $query = "SELECT * FROM despachos WHERE numero_despacho = $numero_despacho and id_campana = $id_campana";
    $res1 = $lider->consultarQuery($query);
    if($res1['ejecucion']==true){
      if(Count($res1)>1){
        // $response = "9"; //echo "Registro ya guardado.";

        $res2 = $lider->consultarQuery("SELECT * FROM despachos WHERE numero_despacho = $numero_despacho and id_campana = $id_campana and estatus = 0");
        if($res2['ejecucion']==true){
          if(Count($res2)>1){
            $res3 = $lider->modificar("UPDATE despachos SET estatus = 1 WHERE numero_despacho = $numero_despacho and id_campana = $id_campana");
            if($res3['ejecucion']==true){
              $response = "1";

            }
          }else{
            $response = "9"; //echo "Registro ya guardado.";
          }
        }

        
      }else{
          $response = "1";
      }
    }else{
      $response = "5"; // echo 'Error en la conexion con la bd';
    }
    echo $response;
  }


  if(!empty($_POST['numero_despacho']) && empty($_POST['validarData'])){
    // print_r($_POST);
    $opInicial = $_GET['opInicial'];
    $cantidad_pagos = $_GET['cantPagos'];
    $opOpcional = $_GET['opOpt'];
    $inObligatorio = $_GET['opOblig'];

    $numero_despacho = $_POST['numero_despacho'];
    $limite_pedido = $_POST['limite_pedido'];
    $apertura_seleccion_plan = $_POST['apertura_seleccion_plan'];
    $limite_seleccion_plan = $_POST['limite_seleccion_plan'];

    // $plan_seleccion = "primer_pago";
    $plan_seleccion = $_POST['plan_seleccion'];

    $fechasPagos = $_POST['fechasPagos'];
    $precio_coleccion = $_POST['precio_coleccion'];
    $preciosPagos = $_POST['preciosPagos'];
    if($opInicial=="Y"){
      $fechasInicial = $_POST['fechasInicial'];
      $inicial_precio = $_POST['precioInn'];
    }
    $precio_contado = $_POST['precioContado'];
    $cantidad_minima_pedido = $_POST['minimasPedido'];
    /*-----------------------------------------------------------*/
    $cantidad_productos = $_POST['cantidad_productos'];
    $elementosid = $_POST['elementosid'];
    $cheking = $_POST['cheking'];
    $precios = $_POST['precios'];
    /*-----------------------------------------------------------*/

    /*-----------------------------------------------------------*/
    $pagos_despacho = [];
    $numIndex = 0;
    if($opInicial=="Y"){
      $idKey = "inicial";
      $nameKey = "Inicial";
      $tipo = "";
      $tipo = $nameKey;
      $fechas = [];
      $pago_col = $inicial_precio;
      $asignacion = "";
      $nnindex = 0;
      foreach ($claveInicial as $cvInicial) {
        $idI = $cvInicial['id'];
        $nameI = $cvInicial['name'];
        $fecha[$nnindex] = $fechasInicial[$idKey.$idI]; 
        $nnindex++;
      }
      $pagos_despacho[$numIndex]['tipo_pago_despacho'] = $tipo;
      $pagos_despacho[$numIndex]['fecha_pago_despacho'] = $fecha[0];
      $pagos_despacho[$numIndex]['fecha_pago_despacho_senior'] = $fecha[1];
      $pagos_despacho[$numIndex]['pago_precio_colecccion'] = $pago_col;
      $pagos_despacho[$numIndex]['asignacion_pago_despacho'] = $asignacion;
      // echo "Id: ".$numIndex." | ";
      // echo "Despacho: 1 | ";
      // echo "Tipo: ".$tipo." | ";
      // echo "Fecha Pago: ".$fecha[0]." | ";
      // echo "Fecha Pago Senior: ".$fecha[1]." | ";
      // echo "Precio Coleccion: ".$pago_col." | ";
      // echo "Asignacion Pago: ".$asignacion." | ";
      // echo "Estatus: 1 | ";
      // echo "<br>";
      $numIndex++;
    }

    foreach ($cantidadPagosDespachosFild as $cvPagos) {
      $idP = $cvPagos['id'];
      $nameP = $cvPagos['name'];
      $tipo = "";
      $tipo = $nameP;
      $fecha = [];
      $pago_col = $preciosPagos['precio_'.$idP];
      $asignacion = "";
      if($plan_seleccion== $idP){
        $asignacion = "seleccion_premios";
      }
      $nnindex = 0;
      foreach ($claveInicial as $cvInicial) {
        $idI = $cvInicial['id'];
        $nameI = $cvInicial['name'];
        $fecha[$nnindex] = $fechasPagos[$idP.$idI];
        $nnindex++;
      }
      $pagos_despacho[$numIndex]['tipo_pago_despacho'] = $tipo;
      $pagos_despacho[$numIndex]['fecha_pago_despacho'] = $fecha[0];
      $pagos_despacho[$numIndex]['fecha_pago_despacho_senior'] = $fecha[1];
      $pagos_despacho[$numIndex]['pago_precio_colecccion'] = $pago_col;
      $pagos_despacho[$numIndex]['asignacion_pago_despacho'] = $asignacion;

      $numIndex++;
    }
    /*-----------------------------------------------------------*/
    // echo "<br><br>";

    /*-----------------------------------------------------------*/

    // $query = "INSERT INTO despachos (id_despacho, id_campana, numero_despacho, fecha_inicial, fecha_primera, fecha_segunda, limite_pedido, apertura_seleccion_plan, limite_seleccion_plan, precio_coleccion, primer_precio_coleccion, segundo_precio_coleccion, inicial_precio_coleccion, fecha_inicial_senior, fecha_primera_senior, fecha_segunda_senior, contado_precio_coleccion, cantidad_minima_pedido, estatus) VALUES (DEFAULT, $id_campana, $numero_despacho, '$fecha_inicial', '$primer_pago', '$segundo_pago', '$limite_pedido', '$apertura_seleccion_plan', '$limite_seleccion_plan', '$precio_coleccion', '$primer_precio', '$segundo_precio', '$inicial_precio', '$fecha_inicial_senior', '$primer_pago_senior', '$segundo_pago_senior', '$precio_contado', $cantidad_minima_pedido, 1)";


    $query = "INSERT INTO despachos (id_despacho, id_campana, numero_despacho, limite_pedido, apertura_seleccion_plan, limite_seleccion_plan, precio_coleccion, contado_precio_coleccion, cantidad_minima_pedido, opcion_inicial, cantidad_pagos, opcionOpcionalInicial, opcionInicialObligatorio, estatus) VALUES (DEFAULT, $id_campana, $numero_despacho, '$limite_pedido', '$apertura_seleccion_plan', '$limite_seleccion_plan', '$precio_coleccion', '$precio_contado', $cantidad_minima_pedido, '{$opInicial}', {$cantidad_pagos}, '{$opOpcional}', '{$inObligatorio}', 1)";
    $exec = $lider->registrar($query, "despachos", "id_despacho");
    if($exec['ejecucion']==true){
      $response = "1";
      $id_despacho = $exec['id'];
      $errorPD=0;
      foreach ($pagos_despacho as $iter => $arr) {
        $tipo = $arr['tipo_pago_despacho'];
        $fecha = $arr['fecha_pago_despacho'];
        $fechaSenior = $arr['fecha_pago_despacho_senior'];
        $pagoCol = $arr['pago_precio_colecccion'];
        $asig = $arr['asignacion_pago_despacho'];
        $queryPD = "INSERT INTO pagos_despachos (id_pago_despacho, id_despacho, tipo_pago_despacho, fecha_pago_despacho, fecha_pago_despacho_senior, pago_precio_coleccion, asignacion_pago_despacho, estatus) VALUES (DEFAULT, {$id_despacho}, '{$tipo}', '{$fecha}', '{$fechaSenior}', '{$pagoCol}', '{$asig}', 1)";
        $exec = $lider->registrar($queryPD, "pagos_despachos", "id_pago_despacho");
        if($exec['ejecucion']==true ){
          $responsePD = "1";
        }else{
          $errorPD++;
          $responsePD = "2";
        }
      }
      if($errorPD==0){
        $response = "1";
        $numIndex = 0;
        foreach ($elementosid as $id_producto_key) {
          foreach ($cheking as $id_cantidad_key) {
            if($id_producto_key == $id_cantidad_key){
              $cantidad = $cantidad_productos[$numIndex];
              $precio_producto = $precios[$numIndex];
        	  	$query = "INSERT INTO colecciones (id_coleccion, id_despacho, id_producto, cantidad_productos, precio_producto, estatus) VALUES (DEFAULT, $id_despacho, $id_producto_key, $cantidad, $precio_producto, 1)";
        	  	$exec = $lider->registrar($query, "colecciones", "id_coleccion");
        	  	if($exec['ejecucion']==true ){
        	  		$response = "1";
        	  	}else{
        	  		$response = "2";
        	  	}
            }   
          }
          $numIndex++;
        }
        if($response=="1"){
          if(!empty($modulo) && !empty($accion)){
            $fecha = date('Y-m-d');
            $hora = date('H:i:a');
            $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Pedidos', 'Registrar', '{$fecha}', '{$hora}')";
            $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
          }
        }
      }else{
        $response = "2";
      }
    }else{
      $response = "2";
    }

    $despachosActual = $lider->consultarQuery("SELECT * from despachos WHERE estatus = 1 and id_campana = $id_campana");
    $despachosActual = Count($despachosActual)-1;
    $productos = $lider->consultarQuery("SELECT * from productos WHERE estatus = 1");

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


  if(empty($_POST)){
    $despachosActual = $lider->consultarQuery("SELECT * from despachos WHERE estatus = 1 and id_campana = $id_campana");
    $despachosActual = Count($despachosActual)-1;
    $productos = $lider->consultarQuery("SELECT * from productos WHERE estatus = 1 ORDER BY producto asc");
    
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

}else{
    require_once 'public/views/error404.php';
}

?>