<?php 

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

  // if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" ){
  //  $campanas=$lider->consultar("campanas");
  // }else{
  //  $campanas=$lider->consultarQuery("SELECT * FROM campanas WHERE estatus = 1 and visibilidad = 1");
  // }
  


$_SESSION['tomandoEnCuentaLiderazgo'] = "1"; /* TOMAR EN CUENTA O NO LA DISTRIBUCION */
$_SESSION['tomandoEnCuentaDistribucion'] = "0"; /* TOMAR EN CUENTA O NO LA DISTRIBUCION */


if(!empty($_POST['validarData'])){
  $id_user = $_SESSION['id_cliente'];
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


if(!empty($_POST['cantidad'])){
  // print_r($_POST);
  $cantidad = $_POST['cantidad'];
  $pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");
  $pedido = $pedidos[0];
  
  $fecha_aprobado = date('d-m-Y');
  $hora_aprobado = date('g:ia');
  $campAnt = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_pedido = $id");


  if(!empty($_GET['admin'])){ //fecha_aprobado = '$fecha_aprobado', hora_aprobado = '$hora_aprobado',
    $query = "UPDATE pedidos SET cantidad_aprobado = $cantidad, visto_admin = 1, visto_cliente = 2, estatus = 1 WHERE id_pedido = $id";
  }else{
    $query = "UPDATE pedidos SET cantidad_pedido = $cantidad, visto_admin = 0, estatus = 1 WHERE id_pedido = $id";
  }

  $exec = $lider->modificar($query);
  if($exec['ejecucion']==true){
    $response = "1";



    //            ABREE BORRAR PLANES Y PREMIOS AL APROBAR
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
    if($cantidadClientesBajos > 0){
      $tot = comprobarVendedoras($clientesBajas, $id_despacho, $lider);
      $cantidad_total = $cantidad+$tot;
      // $cantidad_total = $tot;
    }else{
      $cantidad_total = $cantidad;
    }

    /* PARA APLICAR LIDERAZGO SEGUN LAS VENDEDORAS MONTAR AQUI*/
    $query = "UPDATE pedidos SET cantidad_total = $cantidad_total WHERE id_pedido = $id";
    $exec = $lider->modificar($query);
    $res = aplicarLiderazgo($id_cliente, $id_despacho, $lider);

    /* PARA APLICAR LIDERAZGO SEGUN LAS VENDEDORAS MONTAR AQUI*/

    $clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = $id_cliente");
    $cliente = $clientes[0];
    $totalActual = $pedido['cantidad_total'];
    $id_lider = $cliente['id_lider'];
    // echo $id_lider;
    if($id_lider > 0 ){
      $request = comprobarLider($cantidad_total, $id_lider, $id_despacho, $lider);
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

    $configgemas = $lider->consultarQuery("SELECT * FROM configgemas WHERE nombreconfiggema = 'Por Colecciones De Factura Directa'");
        $configgema = $configgemas[0];
        $id_configgema = $configgema['id_configgema'];
        $cantidad_gemas_correspondientes = $configgema['cantidad_correspondiente'];
        $cantidad_gemas = 0;
        // if($configgema['condicion']=="Dividir"){
          $cantidad_gemas = $cantidad / $cantidad_gemas_correspondientes;
        // }
        // if($configgema['condicion']=="Multiplicar"){
        //   $cantidad_gemas = $cantidad * $cantidad_gemas_correspondientes;
        // }

        $lider->eliminar("DELETE FROM gemas WHERE id_campana = {$id_campana} and id_pedido = {$id} and id_cliente = {$id_cliente} and id_configgema = {$id_configgema}");

        $query = "INSERT INTO gemas (id_gema, id_campana, id_pedido, id_cliente, id_configgema, cantidad_unidades, cantidad_configuracion, cantidad_gemas, activas, inactivas, estado, estatus) VALUES (DEFAULT, {$id_campana}, {$id}, {$id_cliente}, {$id_configgema}, '{$cantidad}', '{$cantidad_gemas_correspondientes}', '{$cantidad_gemas}', 0, '{$cantidad_gemas}', 'Bloqueado', 1)";
        $lider->registrar($query, "gemas", "id_gema");
        

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
    else if(empty($_GET['admin']) && ($_SESSION['nombre_rol'] == "Administrador" || $_SESSION['nombre_rol'] == "Superusuario" ) ){
      // echo "Vendedor";
        require_once 'public/views/error404.php';
        die();    
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
            require_once 'public/views/error404.php';
            die();  
          }
        }

        $liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos, liderazgos_campana WHERE liderazgos.id_liderazgo = liderazgos_campana.id_liderazgo and liderazgos_campana.id_campana = {$id_campana} and liderazgos_campana.estatus = 1");

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