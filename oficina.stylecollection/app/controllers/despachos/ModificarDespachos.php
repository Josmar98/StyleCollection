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
if($amDespachosE == 1){

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
            $response = "1";
        }else{
          $response = "9"; //echo "Registro ya guardado.";
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

      $nombre_despacho = ucwords(mb_strtolower($_POST['nombre_despacho']));
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
      $inventarios = $_POST['inventario'];
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
      /*-----------------------------------------------------------*/

      // $numero_despacho = $_POST['numero_despacho'];
      // $fecha_inicial = $_POST['inicial'];
      // $primer_pago = $_POST['primer_pago'];
      // $segundo_pago = $_POST['segundo_pago'];
      // $limite_pedido = $_POST['limite_pedido'];
      // $apertura_seleccion_plan = $_POST['apertura_seleccion_plan'];
      // $limite_seleccion_plan = $_POST['limite_seleccion_plan'];
      
      // $precio_coleccion = $_POST['precio_coleccion'];
      // $primer_precio = $_POST['precio1'];
      // $segundo_precio = $_POST['precio2'];
      // $inicial_precio = $_POST['precioInn'];
      // $precio_contado = $_POST['precioContado'];
      // $cantidad_minima_pedido = $_POST['minimasPedido'];
      // $fecha_inicial_senior = $_POST['inicial_senior'];
      // $primer_pago_senior = $_POST['primer_pago_senior'];
      // $segundo_pago_senior = $_POST['segundo_pago_senior'];
      
      // $cantidad_productos = $_POST['cantidad_productos'];
      // $elementosid = $_POST['elementosid'];
      // $cheking = $_POST['cheking'];
      // $precios = $_POST['precios'];
      /*-----------------------------------------------------------*/

      // $query = "UPDATE despachos SET numero_despacho=$numero_despacho, fecha_inicial='$fecha_inicial', fecha_primera='$primer_pago', fecha_segunda='$segundo_pago', limite_pedido = '$limite_pedido', apertura_seleccion_plan = '$apertura_seleccion_plan',  limite_seleccion_plan = '$limite_seleccion_plan',  precio_coleccion='$precio_coleccion',  primer_precio_coleccion='$primer_precio', segundo_precio_coleccion='$segundo_precio', inicial_precio_coleccion='$inicial_precio', fecha_inicial_senior = '{$fecha_inicial_senior}', fecha_primera_senior='{$primer_pago_senior}', fecha_segunda_senior='{$segundo_pago_senior}', contado_precio_coleccion='{$precio_contado}', cantidad_minima_pedido={$cantidad_minima_pedido}, estatus = 1 WHERE id_despacho = $id";
      $query = "UPDATE despachos SET numero_despacho={$numero_despacho}, nombre_despacho='{$nombre_despacho}', limite_pedido = '{$limite_pedido}', apertura_seleccion_plan = '{$apertura_seleccion_plan}',  limite_seleccion_plan = '{$limite_seleccion_plan}',  precio_coleccion='{$precio_coleccion}', contado_precio_coleccion='{$precio_contado}', cantidad_minima_pedido={$cantidad_minima_pedido}, opcion_inicial='{$opInicial}', cantidad_pagos={$cantidad_pagos}, opcionOpcionalInicial='{$opOpcional}', opcionInicialObligatorio='{$inObligatorio}', estatus = 1 WHERE id_despacho = $id";

      $exec = $lider->modificar($query);
      if($exec['ejecucion'] == true){
        // $response = "1";
        // $id_despacho = $exec['id'];
        $exec = $lider->eliminar("DELETE FROM colecciones WHERE id_despacho = $id");
        if($exec['ejecucion'] == true){

            $exec = $lider->eliminar("DELETE FROM pagos_despachos WHERE id_despacho = $id");
            if($exec['ejecucion'] == true){
              $errorPD=0;
              foreach ($pagos_despacho as $iter => $arr) {
                $tipo = $arr['tipo_pago_despacho'];
                $fecha = $arr['fecha_pago_despacho'];
                $fechaSenior = $arr['fecha_pago_despacho_senior'];
                $pagoCol = $arr['pago_precio_colecccion'];
                $asig = $arr['asignacion_pago_despacho'];
                $queryPD = "INSERT INTO pagos_despachos (id_pago_despacho, id_despacho, tipo_pago_despacho, fecha_pago_despacho, fecha_pago_despacho_senior, pago_precio_coleccion, asignacion_pago_despacho, estatus) VALUES (DEFAULT, {$id}, '{$tipo}', '{$fecha}', '{$fechaSenior}', '{$pagoCol}', '{$asig}', 1)";
                $exec = $lider->registrar($queryPD, "pagos_despachos", "id_pago_despacho");
                if($exec['ejecucion']==true ){
                  $responsePD = "1";
                }else{
                  $errorPD++;
                  $responsePD = "2";
                }
              }
            }else{
              $response = "2";
            }

            $numIndex = 0;
            $errorsss = 0;
            foreach ($elementosid as $id_producto_key) {
              foreach ($cheking as $id_cantidad_key) {
                if($id_producto_key == $id_cantidad_key){
                  $cantidad = $cantidad_productos[$numIndex];
                  $precio_producto = $precios[$numIndex];
                  
                  $nameInventario = $inventarios[$numIndex];
                  $posMercancia = strpos($id_cantidad_key,'m');
                  if(strlen($posMercancia)==0){
                    $id_element = $id_producto_key;
                  }else{
                    $id_element = preg_replace("/[^0-9]/", "", $id_cantidad_key);
                  }

                  $query = "INSERT INTO colecciones (id_coleccion, id_despacho, id_producto, cantidad_productos, precio_producto, tipo_inventario_coleccion, estatus) VALUES (DEFAULT, $id, $id_element, $cantidad, $precio_producto, '{$nameInventario}', 1)";
                  $exec = $lider->registrar($query, "colecciones", "id_coleccion");
                  // print_r($exec);
                  if($exec['ejecucion']==true ){
                  }else{
                    $errorsss++;
                  }
                }
              }
              $numIndex++;
            }
            if($errorsss==0){
              $response = "1";
            }else{
              $response = "2";
            }
            if($response=="1"){      
              if(!empty($modulo) && !empty($accion)){
                $fecha = date('Y-m-d');
                $hora = date('H:i:a');
                $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Pedidos', 'Editar', '{$fecha}', '{$hora}')";
                $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
              }
            }

        }else{
          $response = "2";
        }

      }else{
        $response = "2";
      }
      // echo $response;
      // die();
      $productos = $lider->consultarQuery("SELECT * from productos WHERE estatus = 1 ORDER BY producto asc");
      $mercancia = $lider->consultarQuery("SELECT * from mercancia WHERE estatus = 1 ORDER BY mercancia asc");

      $despachos=$lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id");
      $pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id} and despachos.estatus = 1 and pagos_despachos.estatus = 1");
      $colecciones=$lider->consultarQuery("SELECT id_coleccion, colecciones.id_despacho, colecciones.id_producto, despachos.numero_despacho, colecciones.cantidad_productos, producto, descripcion, productos.cantidad as cantidad, precio_producto, colecciones.estatus FROM despachos, colecciones, productos WHERE despachos.id_despacho = colecciones.id_despacho and productos.id_producto = colecciones.id_producto and despachos.estatus = 1 and colecciones.estatus = 1 and colecciones.id_despacho = $id");
      $despacho = $despachos[0];
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
      // $despachosActual = $lider->consultarQuery("SELECT * from despachos WHERE estatus = 1 and id_campana = $id_campana");
      // $despachosActual = Count($despachosActual)-1;
      // $productos = $lider->consultarQuery("SELECT * FROM productos, colecciones WHERE productos.id_producto = colecciones.id_producto and colecciones.id_despacho = $id and productos.estatus = 1 ORDER BY producto asc");
      $productos = $lider->consultarQuery("SELECT * from productos WHERE estatus = 1 ORDER BY producto asc");
      $mercancia = $lider->consultarQuery("SELECT * from mercancia WHERE estatus = 1 ORDER BY mercancia asc");

      $despachos=$lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id");
      $pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id} and despachos.estatus = 1 and pagos_despachos.estatus = 1");

      // SELECT * FROM colecciones WHERE colecciones.id_despacho=21 and colecciones.estatus=1;
      // $colecciones=$lider->consultarQuery("SELECT * FROM despachos, colecciones, productos WHERE despachos.id_despacho = colecciones.id_despacho and productos.id_producto = colecciones.id_producto and despachos.estatus = 1 and colecciones.estatus = 1 and colecciones.id_despacho = {$id}");
      $colecciones=$lider->consultarQuery("SELECT * FROM colecciones WHERE colecciones.estatus = 1 and colecciones.id_despacho = {$id}");
      // foreach ($colecciones as $key) {
      //   print_r($key);
      //   echo "<br><br>";
      // }
      if(Count($despachos)>1){
          $despacho = $despachos[0];
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
}else{
    require_once 'public/views/error404.php';
}

?>