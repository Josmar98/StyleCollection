<?php 

  $varMinimaColeccionesParaGemas = 30;

  // if(is_file('app/models/indexModels.php')){
  //   require_once'app/models/indexModels.php';
  // }
  // if(is_file('../app/models/indexModels.php')){
  //   require_once'../app/models/indexModels.php';
  // }
  // $lider = new Models();
  $id_campana = $_GET['campaing'];
  $numero_campana = $_GET['n'];
  $anio_campana = $_GET['y'];
  $id_despacho = $_GET['dpid'];
  $num_despacho = $_GET['dp'];
  $menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

  $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho}");

  // if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" ){
  //  $campanas=$lider->consultar("campanas");
  // }else{
  //  $campanas=$lider->consultarQuery("SELECT * FROM campanas WHERE estatus = 1 and visibilidad = 1");
  // }
  


$_SESSION['tomandoEnCuentaLiderazgo'] = "1"; /* TOMAR EN CUENTA O NO LA DISTRIBUCION */
$_SESSION['tomandoEnCuentaDistribucion'] = "0"; /* TOMAR EN CUENTA O NO LA DISTRIBUCION */


if(!empty($_POST['validarData'])){
  if(!empty($_GET['lider'])){
    $id_user = $_GET['lider'];
  }else{
    $id_user = $_SESSION['id_cliente'];
  }
  if(!empty($_GET['admin'])){
    $query = "SELECT * FROM pedidos WHERE id_pedido = $id";
  }else{
    $query = "SELECT * FROM pedidos WHERE id_cliente = $id_user";
  }
  $res1 = $lider->consultarQuery($query);
  if($res1['ejecucion']==true){
    if(Count($res1)>1){
      $response = "1"; //echo "Registro ya guardado.";

      // $res2 = $lider->consultarQuery("SELECT * FROM permisos WHERE nombre_permiso = '$nombre' and estatus = 0");
      // if($res2['ejecucion']==true){
      //   if(Count($res2)>1){
      //     $res3 = $lider->modificar("UPDATE permisos SET estatus = 1 WHERE nombre_permiso = '$nombre'");
      //     if($res3['ejecucion']==true){
      //       $response = "1";
      //     }
      //   }else{
      //     $response = "9"; //echo "Registro ya guardado.";
      //   }
      // }

    }else{
        $response = "9";
    }
  }else{
    $response = "5"; // echo 'Error en la conexion con la bd';
  }
  echo $response;
}

// print_r($_POST);
if(
  // !empty($_POST['cantidad'])
  isset($_POST['cantidad']) && isset($_POST['cantidadSec']) 
  || 
  isset($_POST['cantidadSec']) && isset($_POST['cantidad']) 
  || 
  isset($_POST['devueltas']) && isset($_POST['cantidad']) 
  || 
  isset($_POST['devueltas_sec']) && isset($_POST['cantidadSec']) 
){
  // $id_cliente=5;
  // print_r($_POST);
  // echo "<br><br>";
  // echo "<br>";
  // die();

  $cantidad = $_POST['cantidad'];
  if(!empty($_POST['cantidadSec'])){
    $cantidadSec = $_POST['cantidadSec'];
  }else{
    $cantidadSec = [];
  }
  if(!empty($_POST['idColSec'])){
    $ids = $_POST['idColSec'];
  }else{
    $ids = [];
  }
  $totalCantidadColecciones = $cantidad;
  foreach ($cantidadSec as $cantidad_sec) {
    $totalCantidadColecciones += $cantidad_sec;
  }


  $pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
  $pedido = $pedidos[0];
  
  $fecha_aprobado = date('d-m-Y');
  $hora_aprobado = date('g:ia');
  $campAnt = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");

  $sentencesSecundary = [];
  if(!empty($_GET['admin'])){ //fecha_aprobado = '$fecha_aprobado', hora_aprobado = '$hora_aprobado',
    $query = "UPDATE pedidos SET cantidad_aprobado = {$totalCantidadColecciones}, cantidad_aprobado_individual = {$cantidad}, visto_admin = 1, visto_cliente = 2, estatus = 1 WHERE id_pedido = $id";
    $indexOf = 0;

    $busquedaPedidoSecundario = $lider->consultarQuery("SELECT * FROM pedidos_secundarios WHERE id_pedido={$id}");
    // if(count($busquedaPedidoSecundario)>1){
    //   // foreach ($cantidadSec as $cantidad_sec) {
    //   //   $querySec = "UPDATE pedidos_secundarios SET cantidad_aprobado_sec={$cantidad_sec}, estatus=1 WHERE id_pedido={$id} and id_despacho_sec={$ids[$indexOf]}";
    //   //   $sentencesSecundary[count($sentencesSecundary)]=$querySec;
    //   //   $indexOf++;
    //   // }
    //   $lider->eliminar("DELETE FROM pedidos_secundarios WHERE id_pedido={$id}");
    //   foreach ($cantidadSec as $cantidad_sec) {
    //     $idColeccionSec = $ids[$indexOf];
    //     $querySec = "INSERT INTO pedidos_secundarios (id_pedido_sec, id_pedido, id_cliente, id_despacho, id_despacho_sec, cantidad_pedido_sec, fecha_pedido_sec, hora_pedido_sec, cantidad_aprobado_sec, fecha_aprobado_sec, hora_aprobado_sec, estatus) VALUES (DEFAULT, $id_pedido, $id_user, $id_despacho, $idColeccionSec, $cantidad_sec, '{$fecha_pedido}', '{$hora_pedido}', $cantidad_sec, '{$fecha_pedido}', '{$hora_pedido}', 1)";
    //     $execSec = $lider->registrar($querySec, "pedidos_secundarios", "id_pedido_sec");
    //     if($execSec['ejecucion']==true){
    //     }else{
    //       $erroresSec++;
    //     }
    //     $indexOf++;
    //   }
    // }else{
    //   // echo "No hay pedido Secundario";
    //   // print_r($_POST);
    // }
    $id_user = $pedidos[0]['id_cliente'];
    // print_r($pedidos[0]['id_cliente']);
    $fecha_pedido = date('d-m-Y');
    $hora_pedido = date('g:ia');
    $id_pedido = $id;
    $indexOf = 0;
    $erroresSec = 0;
    // foreach ($cantidadSec as $cantidad_sec) {
    //   $idColeccionSec = $ids[$indexOf];
    //   $querySec = "INSERT INTO pedidos_secundarios (id_pedido_sec, id_pedido, id_cliente, id_despacho, id_despacho_sec, cantidad_pedido_sec, fecha_pedido_sec, hora_pedido_sec, cantidad_aprobado_sec, fecha_aprobado_sec, hora_aprobado_sec, estatus) VALUES (DEFAULT, $id_pedido, $id_user, $id_despacho, $idColeccionSec, 0, '{$fecha_pedido}', '{$hora_pedido}', $cantidad_sec, '{$fecha_pedido}', '{$hora_pedido}', 1)";
    //   // echo "<br><br>".$querySec;
    //   $execSec = $lider->registrar($querySec, "pedidos_secundarios", "id_pedido_sec");
    //   if($execSec['ejecucion']==true){
    //   }else{
    //     $erroresSec++;
    //   }
    //   $sentencesSecundary[count($sentencesSecundary)]=$querySec;
    //   $indexOf++;
    // }
    $lider->eliminar("DELETE FROM pedidos_secundarios WHERE id_pedido={$id}");
    foreach ($cantidadSec as $cantidad_sec) {
      $idColeccionSec = $ids[$indexOf];
      $querySec = "INSERT INTO pedidos_secundarios (id_pedido_sec, id_pedido, id_cliente, id_despacho, id_despacho_sec, cantidad_pedido_sec, fecha_pedido_sec, hora_pedido_sec, cantidad_aprobado_sec, fecha_aprobado_sec, hora_aprobado_sec, estatus) VALUES (DEFAULT, $id_pedido, $id_user, $id_despacho, $idColeccionSec, $cantidad_sec, '{$fecha_pedido}', '{$hora_pedido}', $cantidad_sec, '{$fecha_pedido}', '{$hora_pedido}', 1)";
      $execSec = $lider->registrar($querySec, "pedidos_secundarios", "id_pedido_sec");
      if($execSec['ejecucion']==true){
      }else{
        $erroresSec++;
      }
      $indexOf++;
    }
    // die();
  }else{
    $query = "UPDATE pedidos SET cantidad_pedido = $cantidad, visto_admin = 0, estatus = 1 WHERE id_pedido = $id";
    $indexOf = 0;

    // $busquedaPedidoSecundario = $lider->consultarQuery("SELECT * FROM pedidos_secundarios WHERE id_pedido={$id}");
    // print_r($busquedaPedidoSecundario);
    $busquedaPedidoSecundario = $lider->consultarQuery("SELECT * FROM pedidos_secundarios WHERE id_pedido={$id}");
    // if(count($busquedaPedidoSecundario)>1){
    //   // foreach ($cantidadSec as $cantidad_sec) {
    //   //   $querySec = "UPDATE pedidos_secundarios SET cantidad_pedido_sec={$cantidad_sec}, estatus=1 WHERE id_pedido={$id} and id_despacho_sec={$ids[$indexOf]}";
    //   //   $sentencesSecundary[count($sentencesSecundary)]=$querySec;
    //   //   $indexOf++;
    //   // }
    //   $lider->eliminar("DELETE FROM pedidos_secundarios WHERE id_pedido={$id}");
    //   foreach ($cantidadSec as $cantidad_sec) {
    //     $idColeccionSec = $ids[$indexOf];
    //     $querySec = "INSERT INTO pedidos_secundarios (id_pedido_sec, id_pedido, id_cliente, id_despacho, id_despacho_sec, cantidad_pedido_sec, fecha_pedido_sec, hora_pedido_sec, cantidad_aprobado_sec, estatus) VALUES (DEFAULT, $id_pedido, $id_user, $id_despacho, $idColeccionSec, $cantidad_sec, '{$fecha_pedido}', '{$hora_pedido}', 0, 1)";
    //     $execSec = $lider->registrar($querySec, "pedidos_secundarios", "id_pedido_sec");
    //     if($execSec['ejecucion']==true){
    //     }else{
    //       $erroresSec++;
    //     }
    //     $indexOf++;
    //   }
    // }else{
    //   // echo "NOOO";      
      
    //   // foreach ($sentencesSecundary as $key) {
    //     // echo "<br><br>";
    //     // print_r($key);
    //     // echo "<br><br>";
    //     //   // code...
    //     // }
    // }
    $id_user = $pedidos[0]['id_cliente'];
    // print_r($pedidos[0]['id_cliente']);
    $fecha_pedido = date('d-m-Y');
    $hora_pedido = date('g:ia');
    $id_pedido = $id;
    $indexOf = 0;
    $erroresSec = 0;
    foreach ($cantidadSec as $cantidad_sec) {
      $idColeccionSec = $ids[$indexOf];
      $querySec = "INSERT INTO pedidos_secundarios (id_pedido_sec, id_pedido, id_cliente, id_despacho, id_despacho_sec, cantidad_pedido_sec, fecha_pedido_sec, hora_pedido_sec, cantidad_aprobado_sec, estatus) VALUES (DEFAULT, $id_pedido, $id_user, $id_despacho, $idColeccionSec, $cantidad_sec, '{$fecha_pedido}', '{$hora_pedido}', 0, 1)";
      // echo "<br><br>".$querySec;
      $execSec = $lider->registrar($querySec, "pedidos_secundarios", "id_pedido_sec");
      if($execSec['ejecucion']==true){
      }else{
        $erroresSec++;
      }
      $sentencesSecundary[count($sentencesSecundary)]=$querySec;
      $indexOf++;
    }
    // die();

  }


  // echo "<br><br>";
  // echo $query;
  // echo "<br><br>";
  // foreach ($sentencesSecundary as $querySec) {
  //   echo $querySec;
  //   echo "<br><br>";
  // }

  // die();
  $exec = $lider->modificar($query);
  if($exec['ejecucion']==true){
    $response = "1";
    $cantidad=$totalCantidadColecciones;

    $erroresSec=0;
    foreach ($sentencesSecundary as $querySec) {
      // echo "<br><br>".$querySec;
      $execSec = $lider->modificar($querySec);
      // print_r($execSec);
      // die();
      if($execSec['ejecucion']==true){
      }else{
        $erroresSec++;
      }
    }
    if($erroresSec==0){

    }

    if(!empty($_GET['admin'])){
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      $query2 = "INSERT INTO pedidos_historicos (id_pedidos_historicos, id_despacho, id_pedido, id_usuario, cantidad_aprobado, fecha_aprobado, hora_aprobado, estatus) VALUES (DEFAULT, {$id_despacho}, {$id}, {$_SESSION['id_usuario']}, {$cantidad}, '{$fecha_aprobado}', '{$hora_aprobado}', 1)";
      $exec2 = $lider->registrar($query2, "pedidos_historicos", "id_pedidos_historicos");
      if($exec['ejecucion']==true){
        $execHist = "1";
      }else{
        $execHist = "2";
      }
    }




        //       ABREE BORRAR PLANES Y PREMIOS AL APROBAR
                          if(!empty($_GET['admin'])){
                              $id_cliente = $campAnt[0]['id_cliente'];
                              $planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and pedidos.id_cliente = {$id_cliente}");
                              $existencias = $lider->consultarQuery("SELECT * FROM premios, existencias WHERE existencias.id_premio = premios.id_premio and  existencias.estatus = 1 and existencias.id_campana = {$id_campana}");
                              $g=0; 
                              foreach ($planesCol as $dataPlanes): if(!empty($dataPlanes['id_tipo_coleccion'])):
                                  $id_tipo_coleccionAct = $dataPlanes['id_tipo_coleccion'];
                                  $execc = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana WHERE tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and premio_coleccion.id_tipo_coleccion = {$id_tipo_coleccionAct}");
                                  if($execc['ejecucion']){


                                    foreach ($existencias as $existen) {
                                      if(!empty($existen['id_premio'])){
                                        foreach ($execc as $execExis) {
                                          if(!empty($execExis['id_premio'])){
                                            if($existen['id_premio']==$execExis['id_premio']){
                                              $cantExis = $execExis['cantidad_premios_plan'];
                                              $antExis = $existen['cantidad_existencia'];
                                              $resExist = $cantExis+$antExis;
                                              $query = "UPDATE existencias SET cantidad_existencia = {$resExist} WHERE id_existencia = {$existen['id_existencia']} and id_premio = {$existen['id_premio']} and id_campana = {$id_campana}";
                                              $execActExis = $lider->modificar($query);
                                              if($exec2['ejecucion']==true){
                                                $response = "1";
                                              }else{
                                                $response = "2";
                                              }
                                            }
                                          }
                                        }   
                                      }
                                    }
                                    $exec2 = $lider->eliminar("DELETE FROM premio_coleccion WHERE id_tipo_coleccion = {$id_tipo_coleccionAct}");
                                    if($exec2['ejecucion']==true){
                                      $response = "1";
                                        $exec2 = $lider->eliminar("DELETE FROM tipos_colecciones WHERE id_tipo_coleccion = {$id_tipo_coleccionAct}");
                                        if($exec2['ejecucion']==true){
                                          $response = "1";
                                        }else{
                                          $response = "2";
                                        }
                                    }else{
                                      $response = "2";
                                    }


                                  }

                              endif; endforeach;
                              
                          }
        //       CIERRRE  BORRAR PLANES Y PREMIOS AL APROBAR

    if(!empty($modulo) && !empty($accion)){
              $campAnt = $campAnt[0];
              $elementos = array(
                      "Nombres"=> [0=>"Id", 1=>ucwords("Id Cliente"), 2=> ucwords("Id despacho"), 3=> ucwords("Cantidad de Colecciones"), 4=>ucwords("Estatus")],
                      "Anterior"=> [ 0=> $id, 1=> $campAnt['id_cliente'], 2=> $campAnt['id_despacho'], 3=>$campAnt['cantidad_pedido'], 4=>"1"],
                      "Actual"=> [ 0=> $id, 1=> $campAnt['id_cliente'], 2=> $campAnt['id_despacho'], 3=>$cantidad, 4=>"1"]
                    );
              $elementosJson = json_encode($elementos, JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES);
              $fecha = date('Y-m-d');
              $hora = date('H:i:a');
              if(!empty($_GET['admin'])){
                $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora, elementos) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Pedidos', 'Editar Aprobados', '{$fecha}', '{$hora}', '{$elementosJson}')";
              }else{
                $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora, elementos) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Pedidos', 'Editar Solicitud', '{$fecha}', '{$hora}', '{$elementosJson}')";
              }
              $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
    }

    $id_cliente = $pedido['id_cliente'];
    /* PARA APLICAR LIDERAZGO SEGUN LAS PROPIAS MONTAR AQUI*/

    /* PARA APLICAR LIDERAZGO SEGUN LAS PROPIAS MONTAR AQUI*/
    $clientesBajas = $lider->consultarQuery("SELECT * FROM clientes WHERE id_lider = $id_cliente");
    $cantidadClientesBajos = Count($clientesBajas)-1;
    $cantidad_total = 0;
    $cantidad_total_alcanzada = 0;
    $pedidosAcumulados = $lider->consultarQuery("SELECT * FROM pedidos, despachos WHERE pedidos.id_despacho = despachos.id_despacho and pedidos.estatus = 1 and despachos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = $id_cliente");
    $cantidad_acumulada = 0;

      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
    foreach ($pedidosAcumulados as $keyss) {
      if(!empty($keyss['id_pedido'])){
        $cantidad_acumulada += $keyss['cantidad_aprobado'];
      }
    }
    if($cantidadClientesBajos > 0){

      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      $tot = comprobarVendedoras($clientesBajas, $id_despacho, $lider);
      $cantidad_total = $cantidad+$tot;
      // $cantidad_total = $tot;

      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
        $totAlcanzadas = comprobarAlcanzadas($clientesBajas, $id_campana, $id_despacho, $lider);

        $cantidad_total_alcanzada = $cantidad_acumulada+$totAlcanzadas;
    }else{
      $cantidad_total = $cantidad;
      $cantidad_total_alcanzada = $cantidad_acumulada;
    }


    /* PARA APLICAR LIDERAZGO SEGUN LAS VENDEDORAS MONTAR AQUI*/

      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
    $query = "UPDATE pedidos SET cantidad_total = $cantidad_total WHERE id_pedido = $id";
    $exec = $lider->modificar($query);
    $res = aplicarLiderazgo($id_cliente, $id_despacho, $lider);

    $busqueda = $lider->consultarQuery("SELECT * FROM colecciones_alcanzadas_campana WHERE id_campana = {$id_campana} and id_cliente = {$id_cliente}");
      if(count($busqueda)>1){
        $queryXD = "UPDATE colecciones_alcanzadas_campana SET cantidad_total_alcanzada = {$cantidad_total_alcanzada} WHERE id_campana = {$id_campana} and id_cliente = {$id_cliente}";
        $execXD = $lider->modificar($queryXD);
      }else{
        $queryXD = "INSERT INTO colecciones_alcanzadas_campana (id_CAC, id_campana, id_cliente, cantidad_total_alcanzada, estatus) VALUES (DEFAULT, {$id_campana}, {$id_cliente}, {$cantidad_total_alcanzada}, 1)";
        $execXD = $lider->modificar($queryXD);
      }





    /* PARA APLICAR LIDERAZGO SEGUN LAS VENDEDORAS MONTAR AQUI*/

    $clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_cliente");
    $cliente = $clientes[0];
    $totalActual = $pedido['cantidad_total'];
    $id_lider = $cliente['id_lider'];
    // echo $id_lider;
    if($id_lider > 0 ){

      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS

      $request = comprobarLider($cantidad_total, $id_lider, $id_despacho, $lider);
      $requestXD = comprobarLiderAlcanzadas($cantidad_total, $id_lider, $id_campana, $id_despacho, $lider);
    }

    $request = "1";
    // //Esto Nooo se Descomentara  

  }else{
    $response = "2";
  }

  $pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
  if($pedidos['ejecucion']==1){
    $pedido = $pedidos[0];
    $id_cliente = $pedido['id_cliente'];
    $id_despacho = $pedido['id_despacho'];
    
    $clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_cliente");
    $cliente = $clientes[0];

    $despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id_despacho");
    $despacho = $despachos[0];

    $liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos.id_liderazgo = liderazgos_campana.id_liderazgo and liderazgos_campana.id_campana = {$id_campana} and liderazgos_campana.estatus = 1");

    $despachosSec=$lider->consultarQuery("SELECT * FROM despachos_secundarios WHERE id_despacho = {$id_despacho} and despachos_secundarios.estatus = 1");
    if(count($despachosSec)>1){
      $pedidos_secundarios = $lider->consultarQuery("SELECT * FROM pedidos_secundarios WHERE estatus = 1 and id_pedido = {$id}");
      // print_r($pedidos_secundarios);
    }


    $configgemas = $lider->consultarQuery("SELECT * FROM configgemas WHERE nombreconfiggema = 'Por Colecciones De Factura Directa'");
        $configgema = $configgemas[0];
        $id_configgema = $configgema['id_configgema'];
        $cantidad_gemas_correspondientes = $configgema['cantidad_correspondiente'];
        $cantidad_gemas = 0;
        // if($configgema['condicion']=="Dividir"){

      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
          $cantidad_gemas = $cantidad / $cantidad_gemas_correspondientes;



        // }
        // if($configgema['condicion']=="Multiplicar"){
        //   $cantidad_gemas = $cantidad * $cantidad_gemas_correspondientes;
        // }

        // $lider->eliminar("DELETE FROM gemas WHERE id_campana = {$id_campana} and id_pedido = {$id} and id_cliente = {$id_cliente} and id_configgema = {$id_configgema}");

        // $query = "INSERT INTO gemas (id_gema, id_campana, id_pedido, id_cliente, id_configgema, cantidad_unidades, cantidad_configuracion, cantidad_gemas, activas, inactivas, estado, estatus) VALUES (DEFAULT, {$id_campana}, {$id}, {$id_cliente}, {$id_configgema}, '{$cantidad}', '{$cantidad_gemas_correspondientes}', '{$cantidad_gemas}', 0, '{$cantidad_gemas}', 'Bloqueado', 1)";
        // $lider->registrar($query, "gemas", "id_gema");

        $pedidosAcumulados = $lider->consultarQuery("SELECT * FROM pedidos, despachos WHERE pedidos.id_despacho = despachos.id_despacho and pedidos.estatus = 1 and despachos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = $id_cliente");
        $cantidad_acumulada = 0;

      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
        foreach ($pedidosAcumulados as $keyss) {
          if(!empty($keyss['id_pedido'])){
            $cantidad_acumulada += $keyss['cantidad_aprobado'];
          }
        }
        // echo "Cantidad: ".$cantidad."<br>";
        // echo "Cantidad Acumulada: ".$cantidad_acumulada."<br><br>";

        $cantidad_acumulada_separado = 0;

      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
      // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
        foreach ($pedidosAcumulados as $keyss) {
          if(!empty($keyss['id_pedido'])){
            $cantidad_acumulada_separado = $keyss['cantidad_aprobado'];
            if($cantidad_acumulada >= $varMinimaColeccionesParaGemas){
              // echo "Mayor a 30 Colecciones <br><br>";
              $cantidad_gemas_separado = $cantidad_acumulada_separado / $cantidad_gemas_correspondientes;
            }else{
              // echo "Menos a 30 Colecciones <br>";
              $cantidad_gemas_separado = 0;
            }
            // echo "Separado - Despacho: ".$keyss['id_despacho']."<br>";
            // echo "Separado - Campaña: ".$keyss['id_campana']."<br>";
            // echo "Separado - Factura: ".$keyss['numero_despacho']."<br>";
            // echo "Separado - Cliente: ".$keyss['id_cliente']."<br>";
            // echo "Separado - Pedido: ".$keyss['id_pedido']."<br>";
            // echo "Separado - Cantidad: ".$cantidad_acumulada_separado."<br>";
            // echo "Separado - Gemas: ".$cantidad_gemas_separado."<br>";

            // echo "<br>Clausula: id_campana: {$keyss['id_campana']} | id_pedido: {$keyss['id_pedido']} | id_cliente: {$keyss['id_cliente']} | id_configgema: {$id_configgema} <br>";
            $lider->eliminar("DELETE FROM gemas WHERE id_campana = {$keyss['id_campana']} and id_pedido = {$keyss['id_pedido']} and id_cliente = {$keyss['id_cliente']} and id_configgema = {$id_configgema}");


            // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
            // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS
            // AQUI SE DEBE TOTALIZAR EL TOTAL TOMANDO EN CUENTAS LAS COLECCIONES SECUNDARIAS

            $query = "INSERT INTO gemas (id_gema, id_campana, id_pedido, id_cliente, id_configgema, cantidad_unidades, cantidad_configuracion, cantidad_gemas, activas, inactivas, estado, estatus) VALUES (DEFAULT, {$keyss['id_campana']}, {$keyss['id_pedido']}, {$keyss['id_cliente']}, {$id_configgema}, '{$cantidad_acumulada_separado}', '{$cantidad_gemas_correspondientes}', '{$cantidad_gemas_separado}', 0, '{$cantidad_gemas_separado}', 'Bloqueado', 1)";
            $lider->registrar($query, "gemas", "id_gema");

            // echo $query."<br>";

            // echo "<br>";
          }
        }
        // die();

        // $_POST['devueltas']



        $cant_devueltas=0;
        if(isset($_POST['devueltas'])){
          $cant_devueltas=$_POST['devueltas'];
        }
        $cant_devueltasSec=0;
        if(isset($_POST['devueltas_sec'])){
          $cant_devueltasSec=$_POST['devueltas_sec'];
        }
        $id_col_sec_dev=$_POST['idColSecDev'];
        $observaciones=$_POST['observaciones'];
        $coleccioness=[];
        $coleccioness[0]['cant']=$cant_devueltas;
        $coleccioness[0]['name']="Cosmeticos";
        $coleccioness[0]['id']=0;
        $estructurasDevueltas=[];
        $estructuraColecciones=$lider->consultarQuery("SELECT * FROM colecciones WHERE id_despacho={$id_despacho} and estatus=1");
        foreach ($estructuraColecciones as $struct) {
          if(!empty($struct['id_producto'])){
            $estructurasDevueltas[count($estructurasDevueltas)]=[
              'id_inventario'=>$struct['id_producto'],
              'tipo_inventario'=>$struct['tipo_inventario_coleccion'],
              'cantidad'=>($struct['cantidad_productos']*$cant_devueltas),
              'precio'=>$struct['precio_producto'],
            ];
          }
        }
        // echo "DESPACHO: ".$id_despacho." | ";
        for ($i=0; $i < count($cant_devueltasSec); $i++) { 
          $id_colec_sec = $id_col_sec_dev[$i];
          $cant_sec = $cant_devueltasSec[$i];
          $col_secundarias = $lider->consultarQuery("SELECT * FROM despachos_secundarios WHERE id_despacho_sec = {$id_colec_sec}");
          foreach ($col_secundarias as $colSec) {
            if(!empty($colSec['id_despacho_sec'])){
              $coleccioness[($i+1)]['cant']=$cant_sec;
              $coleccioness[($i+1)]['name']=$colSec['nombre_coleccion_sec'];
              $coleccioness[($i+1)]['id']=$id_colec_sec;
            }
          }
          $estructuraColecciones=$lider->consultarQuery("SELECT * FROM colecciones_secundarios WHERE id_despacho_sec={$id_colec_sec} and estatus=1");
          foreach ($estructuraColecciones as $struct) {
            if(!empty($struct['id_producto'])){
              $estructurasDevueltas[count($estructurasDevueltas)]=[
                'id_inventario'=>$struct['id_producto'],
                'tipo_inventario'=>$struct['tipo_inventario_coleccion_sec'],
                'cantidad'=>($struct['cantidad_productos']*$cant_sec),
                'precio'=>$struct['precio_producto'],
              ];
            }
          }
        }
        $erroresOrden=0;
        
        $fecha_operacion = date('Y-m-d H:i:s');
        $fecha_dev = date('Y-m-d');
        $hora_dev = date('H:i:s');
        foreach ($coleccioness as $listCol) {
          // print_r($listCol);
          $queryDev="INSERT INTO orden_devolucion_colecciones (id_orden_dev_col, fecha_operacion, fecha_devolucion, hora_devolucion, id_despacho, id_pedido, id_coleccion, nombre_coleccion, cantidad_colecciones, observaciones, estatus) VALUES (DEFAULT, '{$fecha_operacion}', '{$fecha_dev}', '{$hora_dev}', {$id_despacho}, {$id}, {$listCol['id']}, '{$listCol['name']}', {$listCol['cant']}, '{$observaciones}', 1)";
          // echo $queryDev;
          // echo "<br><br>";
          $execDev = $lider->registrar($queryDev, "orden_devolucion_colecciones", "id_orden_dev_col");
          if($execDev['ejecucion']==true){
          }else{
            $erroresOrden++;
          }
      
        }
      
        $erroresOp=0;
        $almacenes=$lider->consultarQuery("SELECT id_almacen FROM almacenes WHERE estatus=1");
        $id_almacen = $almacenes[0]['id_almacen'];
        $fecha_operacion = date('Y-m-d H:i:s');
        $fecha_documento = date('Y-m-d');
        $numero_documento = $id;
        $mostrarListaNotas=$estructurasDevueltas;
        foreach ($mostrarListaNotas as $key) {
          $operaciones = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$key['id_inventario']} and tipo_inventario='{$key['tipo_inventario']}' and id_almacen={$id_almacen} ORDER BY id_operacion DESC;");
          $total_operacion = 0;
          $stock_almacen = 0;
          $total_almacen = 0;
          $precio_venta = 0;
          if(!empty($operaciones[0])){
            // $precio_venta = (float) number_format(($operaciones[0]['total_operacion'] / $operaciones[0]['stock_operacion']),2,'.','');
            $precio_venta = (float) $key['precio'];
            $stock_almacen = $operaciones[0]['stock_operacion_almacen'];
            $total_operacion = (float) number_format($precio_venta*$key['cantidad'],2,'.','');
            $stock_almacen = $stock_almacen+$key['cantidad'];
            $total_almacen = (float) number_format($precio_venta*$stock_almacen,2,'.','');
          }
      
          $operaciones = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$key['id_inventario']} and tipo_inventario='{$key['tipo_inventario']}' ORDER BY id_operacion DESC;");
          $stock_total = 0;
          $total_total = 0;
          if(!empty($operaciones[0])){
            $stock_total = $operaciones[0]['stock_operacion_total'];
            $stock_total = $stock_total+$key['cantidad'];
            $total_total = (float) number_format($precio_venta*$stock_total,2,'.','');
          }
          $concepto_factura = $key['precio'];
          $transaccion="Devolucion En Venta";
          $concepto="Devolucion En Venta";

          $buscarCostos=$lider->consultarQuery("SELECT * FROM cartelera_costos WHERE id_inventario={$key['id_inventario']} and tipo_inventario='{$key['tipo_inventario']}' ORDER BY id_cartelera_costo DESC LIMIT 1");
          if(count($buscarCostos)>1){
            $costoHistorico = $buscarCostos[0]['costo_historico'];
            $costoPromedio = $buscarCostos[0]['costo_promedio'];
            $total_operacion=(float) number_format(($key['cantidad']*$costoPromedio),2,'.','');
            $total_almacen=(float) number_format(($stock_almacen*$costoPromedio),2,'.','');
            $total_total=(float) number_format(($stock_total*$costoPromedio),2,'.','');
          }
          $query = "INSERT INTO operaciones (id_operacion, tipo_operacion, transaccion, concepto, leyenda, tipo_persona, id_personal, id_inventario, id_almacen, tipo_inventario, fecha_operacion, fecha_documento, numero_documento, numero_control, stock_operacion, total_operacion, stock_operacion_almacen, total_operacion_almacen, stock_operacion_total, total_operacion_total, precio_venta, modulo_factura, id_factura, concepto_factura, estatus) VALUES (DEFAULT, 'Entrada', '{$transaccion}', '{$concepto}', '', 'Cliente', {$id_cliente}, {$key['id_inventario']}, {$id_almacen}, '{$key['tipo_inventario']}', '{$fecha_operacion}', '{$fecha_documento}', '{$numero_documento}', '{$numero_documento}', {$key['cantidad']}, {$total_operacion}, {$stock_almacen}, {$total_almacen}, {$stock_total}, {$total_total}, {$precio_venta}, 'Pedidos', {$id}, '{$concepto_factura}', 1); ";
          // echo $query."<br><br>";
          $exec = $lider->registrar($query, "operaciones", "id_operacion");
          
          // echo $query."<br>";
          // print_r($exec);
          // echo "<br><br><br><br>";
          
          if($exec['ejecucion']==true){
          }else{
            $erroresOp++;
          }
        }

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



if(empty($_POST)){

  if(!empty($id)){
    if(!empty($_GET['admin']) && ($_SESSION['nombre_rol'] == "Administrador" || $_SESSION['nombre_rol'] == "Superusuario"   || $_SESSION['nombre_rol'] == "Analista Supervisor") ){
      // echo "Admin";
      $clientss = $lider->consultarQuery("SELECT clientes.id_cliente, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, cedula, sexo, fecha_nacimiento, telefono, correo, clientes.estatus FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.estatus = 1 ORDER BY primer_nombre ASC");
      $clientesConPedido = $lider->consultarQuery("SELECT clientes.id_cliente, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, cedula, sexo, fecha_nacimiento, telefono, correo, clientes.estatus FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = $id_despacho and clientes.estatus = 1");
    }
    else if(!empty($_GET['admin']) && ($_SESSION['nombre_rol'] != "Administrador" || $_SESSION['nombre_rol'] != "Superusuario" ) ){
      // echo "Vendedor Intruso";
      require_once 'public/views/error404.php';
      die();
    }
    else if(empty($_GET['admin']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol'] == "Administrador" || $_SESSION['nombre_rol'] == "Analista Supervisor"|| $_SESSION['nombre_rol'] == "Administrativo"|| $_SESSION['nombre_rol'] == "Analista2") ){
      // echo "Vendedor";
      // require_once 'public/views/error404.php';
      // die();    
    }

    $pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE estatus = 1 and id_pedido = {$id}");
    if($pedidos['ejecucion']==1){
        $pedido = $pedidos[0];
        $id_cliente = $pedido['id_cliente'];
        $id_despacho = $pedido['id_despacho'];
        
        $clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_cliente");
        $cliente = $clientes[0];

        $despachos = $lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id_despacho");
        $despacho = $despachos[0];
        if(empty($_GET['admin']) && ($_SESSION['nombre_rol'] != "Administrador" || $_SESSION['nombre_rol'] != "Superusuario" )){
          $limiteexd = date('Y-m-d');
          if($limiteexd > $despacho['limite_pedido']){
            if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol'] == "Administrador" || $_SESSION['nombre_rol'] == "Analista Supervisor"|| $_SESSION['nombre_rol'] == "Administrativo"|| $_SESSION['nombre_rol'] == "Analista2"){}else{
              require_once 'public/views/error404.php';
              die();    
            }
          }
        }

        $liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos.id_liderazgo = liderazgos_campana.id_liderazgo and liderazgos_campana.id_campana = {$id_campana} and liderazgos_campana.estatus = 1");
        $despachosSec=$lider->consultarQuery("SELECT * FROM despachos_secundarios WHERE id_despacho = {$id_despacho} and despachos_secundarios.estatus = 1");
        if(count($despachosSec)>1){
          $pedidos_secundarios = $lider->consultarQuery("SELECT * FROM pedidos_secundarios WHERE estatus = 1 and id_pedido = {$id}");
          // print_r($pedidos_secundarios);
        }
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

  }else{
    require_once 'public/views/error404.php';

  }

}




function comprobarLider($cantidad, $id_lider, $id_despacho, $lider){
  // echo "Mis Colecciones Total: ".$cantidad."<br>";
  $responseRequest = false;
  $pedidosLider = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = $id_lider and id_despacho = $id_despacho");
  $clientesLider = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_lider");
  if(Count($pedidosLider)>1){
    $pedidoLider = $pedidosLider[0];
    $cantidad = $pedidoLider['cantidad_aprobado'];
    $id_pedido = $pedidoLider['id_pedido'];
    // echo "pedido: ".$id_pedido." <br>";
  }

  if(Count($clientesLider)>1){
    $clienteLider = $clientesLider[0];
    $id_cliente = $clienteLider['id_cliente'];
    $clientesBajas = $lider->consultarQuery("SELECT * FROM clientes WHERE id_lider = $id_cliente");

    $cantidadClientesBajos = Count($clientesBajas)-1;
    $cantidad_total = 0;
    if($cantidadClientesBajos > 0){
      $tot = comprobarVendedoras($clientesBajas, $id_despacho, $lider);
      $cantidad_total = $cantidad+$tot;
      // $cantidad_total = $tot;  
    }else{
      $cantidad_total = $cantidad;
    }
    if(Count($pedidosLider)>1){
      $query = "UPDATE pedidos SET cantidad_total = $cantidad_total WHERE id_pedido = $id_pedido";
      $exec = $lider->modificar($query);
    }
    /*  CODIGO PARA ESTABLECER CUAL SERA MI LIDERAZGO  */ 
    $res = aplicarLiderazgo($id_cliente, $id_despacho, $lider);
    $new_id_lider = $clienteLider['id_lider'];
    if($new_id_lider > 0 ){
      $responseRequest = comprobarLider($cantidad, $new_id_lider, $id_despacho, $lider);
    }
  }
  return $responseRequest;
}
function comprobarLiderAlcanzadas($cantidad, $id_lider, $id_campana, $id_despacho, $lider){
  // echo "Mis Colecciones Total: ".$cantidad."<br>";
  $responseRequest = false;
  // $pedidosLider = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = $id_lider and id_despacho = $id_despacho");
  $pedidosLider = $lider->consultarQuery("SELECT * FROM pedidos, despachos WHERE despachos.id_despacho = pedidos.id_despacho and pedidos.id_cliente = $id_lider and despachos.id_campana = $id_campana");
  $clientesLider = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_lider");
  $cantidad = 0;
  if(Count($pedidosLider)>1){
    foreach ($pedidosLider as $keyss) {
      if(!empty($keyss['id_pedido'])){
        // $total += $keyss['cantidad_aprobado'];
        $cantidad += $keyss['cantidad_aprobado'];
        $id_pedido = $keyss['id_pedido'];
        // $pedidoLider = $pedidosLider[0];
        // $id_pedido = $pedidoLider['id_pedido'];
        // echo "pedido: ".$id_pedido." <br>";
        // echo "Cantidad_aprobadas: ".$cantidad." <br>";
      }
    }
  }


  if(Count($clientesLider)>1){
    $clienteLider = $clientesLider[0];
    $id_cliente = $clienteLider['id_cliente'];

    $clientesBajas = $lider->consultarQuery("SELECT * FROM clientes WHERE id_lider = $id_cliente");

    $cantidadClientesBajos = Count($clientesBajas)-1;
    $cantidad_total_alcanzada = 0;
    $pedidosAcumulados = $lider->consultarQuery("SELECT * FROM pedidos, despachos WHERE pedidos.id_despacho = despachos.id_despacho and pedidos.estatus = 1 and despachos.estatus = 1 and despachos.id_campana = {$id_campana} and pedidos.id_cliente = $id_cliente");
      $cantidad_acumulada = 0;
      foreach ($pedidosAcumulados as $keyss) {
        if(!empty($keyss['id_pedido'])){
          $cantidad_acumulada += $keyss['cantidad_aprobado'];
        }
      }
    if($cantidadClientesBajos > 0){
      $totAlcanzadas = comprobarAlcanzadas($clientesBajas, $id_campana, $id_despacho, $lider);
      $cantidad_total_alcanzada = $cantidad_acumulada+$totAlcanzadas;
    }else{
      $cantidad_total_alcanzada = $cantidad_acumulada;
    }
    // echo "LideR: ".$clienteLider['id_cliente']." | ".$clienteLider['primer_nombre']." ".$clienteLider['primer_apellido']."<br>";
    // echo "Cantidad Alcanzada: ".$cantidad_total_alcanzada."<br>";
    if(Count($pedidosLider)>1){
      // echo "Cantidad total: ".$cantidad_total_alcanzada."<br><br>";
      $busqueda = $lider->consultarQuery("SELECT * FROM colecciones_alcanzadas_campana WHERE id_campana = {$id_campana} and id_cliente = {$id_cliente}");
      if(count($busqueda)>1){
        $queryXD = "UPDATE colecciones_alcanzadas_campana SET cantidad_total_alcanzada = {$cantidad_total_alcanzada} WHERE id_campana = {$id_campana} and id_cliente = {$id_cliente}";
        $execXD = $lider->modificar($queryXD);
      }else{
        $queryXD = "INSERT INTO colecciones_alcanzadas_campana (id_CAC, id_campana, id_cliente, cantidad_total_alcanzada, estatus) VALUES (DEFAULT, {$id_campana}, {$id_cliente}, {$cantidad_total_alcanzada}, 1)";
        $execXD = $lider->modificar($queryXD);
      }
      // echo $queryXD;
    }
    // echo "<br><hr><br>";

    /*  CODIGO PARA ESTABLECER CUAL SERA MI LIDERAZGO  */ 
    $new_id_lider = $clienteLider['id_lider'];
    if($new_id_lider > 0 ){
      $responseRequest = comprobarLiderAlcanzadas($cantidad, $new_id_lider, $id_campana, $id_despacho, $lider);
    }
  }
  return $responseRequest;
}
function comprobarAlcanzadas($clientes, $id_campana, $id_despacho, $lider){
  $total = 0;
  $vez = "";
  foreach ($clientes as $client) {
    if(!empty($client['id_cliente'])){
      $id_cliente = $client['id_cliente'];
      $vez = $id_cliente;
      $pedidos = $lider->consultarQuery("SELECT * FROM pedidos, despachos WHERE despachos.id_despacho = pedidos.id_despacho and pedidos.id_cliente = $id_cliente and despachos.id_campana = $id_campana");

      // $pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = $id_cliente and id_despacho = $id_despacho");
      // echo "<br><br>";
      // print_r($pedidos[0]);
      // echo "<br><br>";
      $totalHijo = 0;
      if(Count($pedidos)>1){
        foreach ($pedidos as $keyss) {
          if(!empty($keyss['id_pedido'])){
            $total += $keyss['cantidad_aprobado'];
            $totalHijo += $keyss['cantidad_aprobado'];
          }
        }
      }
      $clientesBajas = $lider->consultarQuery("SELECT * FROM clientes WHERE id_lider = $id_cliente");
      $cantidadClientesBajos = Count($clientesBajas)-1;
      if(count($clientesBajas)>1){
        $total += comprobarAlcanzadas($clientesBajas, $id_campana, $id_despacho, $lider);
        $totAlcanzadas = comprobarAlcanzadas($clientesBajas, $id_campana, $id_despacho, $lider);
        $cantidad_total_alcanzada = $totalHijo+$totAlcanzadas;
      }else{
        $cantidad_total_alcanzada = $totalHijo;
      }
      $busqueda = $lider->consultarQuery("SELECT * FROM colecciones_alcanzadas_campana WHERE id_campana = {$id_campana} and id_cliente = {$id_cliente}");
      if(count($busqueda)>1){
        $queryXD = "UPDATE colecciones_alcanzadas_campana SET cantidad_total_alcanzada = {$cantidad_total_alcanzada} WHERE id_campana = {$id_campana} and id_cliente = {$id_cliente}";
        $execXD = $lider->modificar($queryXD);
      }else{
        $queryXD = "INSERT INTO colecciones_alcanzadas_campana (id_CAC, id_campana, id_cliente, cantidad_total_alcanzada, estatus) VALUES (DEFAULT, {$id_campana}, {$id_cliente}, {$cantidad_total_alcanzada}, 1)";
        $execXD = $lider->modificar($queryXD);
      }
      // echo "ID LIDER: ".$vez." || ";
      // echo "CANTIDAD TOTAL: ".$cantidad_total_alcanzada;
      // if(!empty($totAlcanzadas)){
      //   echo " << ".$totAlcanzadas." >>";
      // }
      // echo "<br><br>";


    }
  }
  // echo "ID: ".$vez." | ";
  // echo "Total aprobadas: ".$total."  ";
  // echo "<br>";
  return $total;
}
function comprobarVendedoras($clientes, $id_despacho, $lider){
  $total = 0;
  $vez = "";
  foreach ($clientes as $client) {
    if(!empty($client['id_cliente'])){
      $id_cliente = $client['id_cliente'];
      $vez = $id_cliente;
      $pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = $id_cliente and id_despacho = $id_despacho");
      if(Count($pedidos)>1){
        $pedido = $pedidos[0];
        $total += $pedido['cantidad_aprobado'];
        // print_r($pedido['cantidad_aprobado']);
      }

      $clientesBajas = $lider->consultarQuery("SELECT * FROM clientes WHERE id_lider = $id_cliente");
      if(Count($clientesBajas)>1){
        $total += comprobarVendedoras($clientesBajas, $id_despacho, $lider);
      }

    }
  }
  // echo "ID: ".$vez." | Total aprobadas: ".$total."<br>";
  return $total;
}
function aplicarLiderazgo($id, $id_despacho, $lider){
  $pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = $id and id_despacho = $id_despacho");
  if(Count($pedidos)>1){
    $pedido = $pedidos[0];
    if($_SESSION['tomandoEnCuentaLiderazgo'] == "1"){
      $total = $pedido['cantidad_total'];
    }
    if($_SESSION['tomandoEnCuentaLiderazgo'] == "0"){
      $total = $pedido['cantidad_aprobado'];
    }
    $query = "SELECT * FROM liderazgos_campana WHERE $total BETWEEN minima_cantidad and maxima_cantidad";
    $liderazgos = $lider->consultarQuery($query);
    if(Count($liderazgos)>1){
      $liderazgo = $liderazgos[0];
      $id_liderazgo = $liderazgo['id_lc'];

      $query = "UPDATE clientes SET id_lc = $id_liderazgo WHERE id_cliente = $id";
      $exec = $lider->modificar($query);
    }
  }
}

?>
