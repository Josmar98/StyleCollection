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
  $id_despacho = $_GET['dpid'];
  $num_despacho = $_GET['dp'];
  $menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

  $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and campanas.estatus = 1 and despachos.estatus = 1 and campanas.id_campana = {$id_campana} and campanas.numero_campana = {$numero_campana} and despachos.id_despacho = {$id_despacho} and despachos.numero_despacho = {$num_despacho}");
  $pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1");
  $cantPagos=count($pagos_despacho)-1;
  $despacho = $despachos[0];

  $opInicial = $despacho['opcion_inicial'];
  $pagosObligatorios = $despacho['opcionInicialObligatorio'];
  $inObligatoria = $despacho['opcionOpcionalInicial'];

  $cantidadPagosDespachosFild = [];
  if($pagosObligatorios == "Y"){
    if($opInicial=="Y"){
        $sumAdd = 1;
        $cantidadPagosDespachosFild[0] = ['cantidad'=>0,   'name'=> "Inicial",   'id'=> "inicial"];
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
  $cantidadPagosDespachosFild;
  if($pagosObligatorios == "N"){
    // if($inObligatoria=="N"){
    //  $sumAdd = 1;
    //  $cantidadPagosDespachosFild[0] = ['cantidad'=>0,   'name'=> "Inicial",   'id'=> "inicial"];
    // }else{
      $sumAdd = 0;
    // }
    for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
      $key = $cantidadPagosDespachos[$i];
      if($key['cantidad'] <= $despacho['cantidad_pagos']){
        $cantidadPagosDespachosFild[$i+$sumAdd] = $key;
      }
    }
  }


  $formasPago = [
    0=>['id'=>0, 'name'=>'Transferencia Banco a Banco', 'type'=>'banco'],
    1=>['id'=>1, 'name'=>'Transferencia de Otros Bancos', 'type'=>'banco'],
    2=>['id'=>2, 'name'=>'Pago Movil Banco a Banco', 'type'=>'banco'],
    3=>['id'=>3, 'name'=>'Pago Movil de Otros Bancos', 'type'=>'banco'],

    4=>['id'=>4, 'name'=>'Deposito En Dolares', 'type'=>'banco'],
    5=>['id'=>5, 'name'=>'Divisas Dolares', 'type'=>'fisico'],
    6=>['id'=>6, 'name'=>'Efectivo Bolivares', 'type'=>'fisico'],
    // 5=>['id'=>5, 'name'=>'Deposito En Bolivares', 'type'=>'banco'],
    // 6=>['id'=>6, 'name'=>'Divisas Dolares', 'type'=>'fisico'],
    // 7=>['id'=>7, 'name'=>'Divisas Euros', 'type'=>'fisico'],
    // 8=>['id'=>8, 'name'=>'Efectivo Bolivares', 'type'=>'fisico'],
  ];


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
    // if($inObligatoria=="N"){
    //  $sumAdd = 1;
    //  $cantidadPagosDespachosFild[0] = ['cantidad'=>0,   'name'=> "Inicial",   'id'=> "inicial"];
    // }else{
      $sumAdd = 0;
    // }
    for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
      $key = $cantidadPagosDespachos[$i];
      if($key['cantidad'] <= $despacho['cantidad_pagos']){
        $cantidadPagosDespachosFild[$i+$sumAdd] = $key;
      }
    }
  }
  // print_r($cantidadPagosDespachosFild);

  if(!empty($_POST['validarData'])){
    $nombre_coleccion = $_POST['nombre_coleccion'];
    $query = "SELECT * FROM despachos_secundarios WHERE id_despacho = $id_despacho and nombre_coleccion_sec = '{$nombre_coleccion}'";
    $res1 = $lider->consultarQuery($query);
    if($res1['ejecucion']==true){
      if(Count($res1)>1){
        $response = "1";
      }else{
        $response = "9"; //echo "Registro ya guardado.";
      }
      // if(Count($res1)>1){
      //   // $response = "9"; //echo "Registro ya guardado.";
      //   $res2 = $lider->consultarQuery("SELECT * FROM despachos_secundario WHERE id_despacho = $id_despacho and nombre_coleccion = '{$nombre_coleccion}' and estatus = 0");
      //   if($res2['ejecucion']==true){
      //     if(Count($res2)>1){
      //       $res3 = $lider->modificar("UPDATE despachos_secundario SET estatus = 1 WHERE id_despacho = $id_despacho and nombre_coleccion = '{$nombre_coleccion}'");
      //       if($res3['ejecucion']==true){
      //         $response = "1";
      //       }
      //     }else{
      //       $response = "9"; //echo "Registro ya guardado.";
      //     }
      //   }
      // }else{
      //     $response = "1";
      // }
    }else{
      $response = "5"; // echo 'Error en la conexion con la bd';
      // $response = "1"; // echo 'Error en la conexion con la bd';
    }
    echo $response;
  }


  if(!empty($_POST['nombre_coleccion']) && empty($_POST['validarData'])){
    // print_r($_POST);
    // foreach ($_POST as $key => $value) {
    //   echo $key."<br>";
    //   // print_r($value);
    //   // echo "<br><br>";
    //   echo "<hr>";
    // }
    $nombre_coleccion = $_POST['nombre_coleccion'];
    $precio_coleccion = $_POST['precio_coleccion'];
    $precios_pagos = $_POST['preciosPagos'];


    $cantidad_productos = $_POST['cantidad_productos'];
    $elementosid = $_POST['elementosid'];
    $cheking = $_POST['cheking'];
    $precios = $_POST['precios'];


        
    // die();

    // #############################################################################################################
    // $query = "INSERT INTO despachos_secundarios (id_despacho_sec, id_despacho, nombre_coleccion_sec, precio_coleccion_sec, estatus) VALUES (DEFAULT, $id_despacho, '{$nombre_coleccion}', $precio_coleccion, 1)";
    // echo $query."<br><br>";
    // $id_despacho_sec = 1;
    // foreach ($cantidadPagosDespachosFild as $key) {
    //   $tipo_pago_sec = $key['name'];
    //   $precio_pago_sec = $precios_pagos['precio_'.$key['id']];
    //   $query = "INSERT INTO despachos_secundarios_pagos (id_despacho_sec_pago, id_despacho_sec, tipo_pago_despacho_sec, pago_precio_coleccion_sec, estatus) VALUES (DEFAULT, $id_despacho_sec, '{$tipo_pago_sec}', $precio_pago_sec, 1)";
    //   echo $query."<br>";
    // }
    // echo "<br>";
    // $numIndex = 0;
    //     foreach ($elementosid as $id_producto_key) {
    //       foreach ($cheking as $id_cantidad_key) {
    //         if($id_producto_key == $id_cantidad_key){
    //           $cantidad = $cantidad_productos[$numIndex];
    //           $precio_producto = $precios[$numIndex];
    //           $query = "INSERT INTO colecciones_secundarios (id_coleccion_sec, id_despacho_sec, id_producto, cantidad_productos, precio_producto, estatus) VALUES (DEFAULT, $id_despacho, $id_producto_key, $cantidad, $precio_producto, 1)";
    //           echo $query;
    //           echo "<br>";
    //           // $exec = $lider->registrar($query, "colecciones", "id_coleccion");
    //           // if($exec['ejecucion']==true ){
    //           //   $response = "1";
    //           // }else{
    //           //   $response = "2";
    //           // }
    //         }   
    //       }
    //       $numIndex++;
    //     }
    // // #############################################################################################################
    

    // die();
    $query = "UPDATE despachos_secundarios SET nombre_coleccion_sec='{$nombre_coleccion}', precio_coleccion_sec={$precio_coleccion} WHERE id_despacho_sec={$id}";
    $exec = $lider->modificar($query);
    if($exec['ejecucion']==true){
      $response = "1";
      $queryDP = "DELETE FROM despachos_secundarios_pagos WHERE id_despacho_sec={$id}";
      $execDP = $lider->eliminar($queryDP);
      if($execDP['ejecucion']==true){
        $id_despacho_sec = $id;
        $errorPD=0;
        foreach ($cantidadPagosDespachosFild as $key) {
          $tipo_pago_sec = $key['name'];
          $precio_pago_sec = $precios_pagos['precio_'.$key['id']];
          $queryPD = "INSERT INTO despachos_secundarios_pagos (id_despacho_sec_pago, id_despacho_sec, tipo_pago_despacho_sec, pago_precio_coleccion_sec, estatus) VALUES (DEFAULT, $id_despacho_sec, '{$tipo_pago_sec}', $precio_pago_sec, 1)";
          $exec = $lider->registrar($queryPD, "despachos_secundarios_pagos", "id_despacho_sec_pago");
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
          $queryDC = "DELETE FROM colecciones_secundarios WHERE id_despacho_sec={$id}";
          $execDC = $lider->eliminar($queryDC);
          if($execDC['ejecucion']==true){
            foreach ($elementosid as $id_producto_key) {
              foreach ($cheking as $id_cantidad_key) {
                if($id_producto_key == $id_cantidad_key){
                  $cantidad = $cantidad_productos[$numIndex];
                  $precio_producto = $precios[$numIndex];
                  $query = "INSERT INTO colecciones_secundarios (id_coleccion_sec, id_despacho_sec, id_producto, cantidad_productos, precio_producto, estatus) VALUES (DEFAULT, $id_despacho_sec, $id_producto_key, $cantidad, $precio_producto, 1)";
                  $exec = $lider->registrar($query, "colecciones_secundarios", "id_coleccion_sec");
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
                $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Colecciones', 'Modificar', '{$fecha}', '{$hora}')";
                $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
              }
            }
          }else{
            $response="2";
          }
        }else{
          $response = "2";
        }
      }else{
        $response="2";
      }
    }else{
      $response = "2";
    }
    




    
    $despachosSec = $lider->consultarQuery("SELECT * from despachos_secundarios WHERE estatus = 1 and id_despacho_sec = $id");
    $despachoSec = $despachosSec[0];
    $despachosActual = $lider->consultarQuery("SELECT * from despachos WHERE estatus = 1 and id_campana = $id_campana");
    $despachosActual = Count($despachosActual)-1;
    $productos = $lider->consultarQuery("SELECT * from productos WHERE estatus = 1 ORDER BY producto asc");

    $coleccionesSec = $lider->consultarQuery("SELECT * from colecciones_secundarios WHERE estatus = 1 and id_despacho_sec=$id");
    $despachosSecPagos = $lider->consultarQuery("SELECT * from despachos_secundarios_pagos WHERE estatus = 1 and id_despacho_sec=$id");
    

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
    $despachosSec = $lider->consultarQuery("SELECT * from despachos_secundarios WHERE estatus = 1 and id_despacho_sec = $id");
    if(count($despachosSec)>1){
      $despachoSec = $despachosSec[0];
      $despachosActual = $lider->consultarQuery("SELECT * from despachos WHERE estatus = 1 and id_campana = $id_campana");
      $despachosActual = Count($despachosActual)-1;
      $productos = $lider->consultarQuery("SELECT * from productos WHERE estatus = 1 ORDER BY producto asc");

      $coleccionesSec = $lider->consultarQuery("SELECT * from colecciones_secundarios WHERE estatus = 1 and id_despacho_sec=$id");
      $despachosSecPagos = $lider->consultarQuery("SELECT * from despachos_secundarios_pagos WHERE estatus = 1 and id_despacho_sec=$id");
      
      // print_r($despachoSec);
      // echo "<br><br>";
      // print_r($coleccionesSec);
      // echo "<br><br>";
      // print_r($despachosSecPagos);

      
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