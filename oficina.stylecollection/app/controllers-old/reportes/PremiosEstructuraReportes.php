<?php 
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

    if(!empty($_GET['P'])){
        $id_despacho = $_GET['P'];
        $id_cliente = $_GET['L'];
        $clientee = $lider->consultarQuery("SELECT * FROM clientes WHERE clientes.id_cliente = {$id_cliente}");
        $_SESSION['ids_general_estructura'] = [];
        if(count($clientee)>1){
          $cliente1 = $clientee[0];
          $clientee2 = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_cliente = {$id_cliente}");
          if(count($clientee2)>1){
            $_SESSION['ids_general_estructura'][] = $cliente1;
          }
          consultarEstructura($id_cliente, $id_despacho, $lider);
        }
        $nuevosClientes = $_SESSION['ids_general_estructura'];
        
      $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho}");

      $pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho");
      $planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
      $premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
      $premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = 'Standard' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
        


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

        // $premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");

        // foreach ($premios_planes as $key) {
        //   if(!empty($key['id_producto'])){
        //     // print_r($key);
        //     echo $key['tipo_premio'];
        //     echo "<br>";
        //   }
        // }

    }

    $clientess = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1");
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

function consultarEstructura($id_c, $id_despacho, $lider){
  $lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE clientes.id_lider = $id_c and clientes.estatus = 1");
  if(Count($lideres)>1){
    foreach ($lideres as $lid) {
      if(!empty($lid['id_cliente'])){
        $lideres2 = $lider->consultarQuery("SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = {$id_despacho} and clientes.id_cliente = {$lid['id_cliente']}");
        if(count($lideres2)>1){
          $lid2 = $lideres2[0];
          $_SESSION['ids_general_estructura'][] = $lid2;
        }
        consultarEstructura($lid['id_cliente'], $id_despacho, $lider);
      }
    }
  }
}

?>