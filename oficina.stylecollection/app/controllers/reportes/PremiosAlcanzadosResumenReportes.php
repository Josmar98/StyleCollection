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
  $clientesss = [];
    if(!empty($_GET['P'])){
      $id_despacho = $_GET['P'];
      $campanas = $lider->consultarQuery("SELECT * FROM despachos, campanas WHERE despachos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_campana");
      $campana = $campanas[0];
      $id_campana = $campana['id_campana'];
      
      $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho}");
        $clientesss = $_GET['L'];
        // $clientesss = [5, 2];
        $strClientes = "";
        $numeros = 1;
        foreach ($clientesss as $idClient) {
          $strClientes.="".$idClient;
          if(($numeros) < count($clientesss)){
            $strClientes.=", ";
          }
          // echo "Numero: ".$idClient."<br>";
          $numeros++;
        }
         // and clientes.id_cliente in ({$strClientes})
        // echo $strClientes;

      if(!empty($_GET['admin']) && !empty($_GET['lider']) && ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Analista")){
        $id = $_GET['lider'];
        $pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente = $id and clientes.id_cliente in ({$strClientes})");
        $pedido = $pedidos[0];
        $id_pedido = $pedido['id_pedido'];
        $premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE id_pedido = $id_pedido and estatus = 1 and premios_perdidos.id_cliente IN ({$strClientes}) ORDER BY id_premio_perdido ASC;");
      }else{
        $id = $_SESSION['id_cliente'];
        $pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho and clientes.id_cliente in ({$strClientes})");
        $premios_perdidos = $lider->consultarQuery("SELECT * FROM premios_perdidos WHERE estatus = 1 and premios_perdidos.id_cliente IN ({$strClientes}) ORDER BY id_premio_perdido ASC;");
      // print_r($pedidos);
      }
    //   echo $strClientes;
    // $planesCol = $lider->consultarQuery("SELECT pedidos.id_cliente, pedidos.id_pedido, cantidad_coleccion_plan, cantidad_coleccion, planes.id_plan, nombre_plan FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho} and pedidos.id_cliente IN ({$strClientes}) ORDER BY planes.id_plan ASC");
    $planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho} and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho} and pedidos.id_cliente IN ({$strClientes}) ORDER BY planes.id_plan ASC");
    // print_r($planesCol);
    // pedidos.id_cliente, pedidos.id_pedido, cantidad_coleccion_plan, cantidad_coleccion, planes.id_plan, nombre_plan
    // foreach($planesCol as $key){
    //     print_r($key);
    //     echo "<br><br><br><br>";
    // }
    $premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and pedidos.id_cliente IN ({$strClientes})");
    // print_r($premioscol);
    // die();
    $premios_planes3 = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
      
    $premios_planes4 = $lider->consultarQuery("SELECT DISTINCT * FROM premios, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_premios_planes_campana.tipo_premio_producto = 'Premios' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
      $premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = 'Standard' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");

      $retos = $lider->consultarQuery("SELECT * FROM retos, retos_campana, premios WHERE retos.id_reto_campana = retos_campana.id_reto_campana and retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana and retos.id_campana = $id_campana");
      
      $retosCamp = $lider->consultarQuery("SELECT DISTINCT * FROM retos_campana, premios WHERE retos_campana.id_premio = premios.id_premio and retos_campana.id_campana = $id_campana");

      $canjeos = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and canjeos.estatus = 1 and catalogos.estatus = 1 and canjeos.id_campana = {$id_campana} and canjeos.id_despacho = {$id_despacho}");

      $canjeosUnic = $lider->consultarQuery("SELECT DISTINCT nombre_catalogo FROM canjeos, catalogos WHERE canjeos.id_catalogo = catalogos.id_catalogo and canjeos.estatus = 1 and catalogos.estatus = 1 and canjeos.id_campana = {$id_campana} and canjeos.id_despacho = {$id_despacho}");

      
      $premios_autorizados = $lider->ConsultarQuery("SELECT * FROM pedidos, clientes, premios_autorizados, premios WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = premios_autorizados.id_cliente and pedidos.id_pedido = premios_autorizados.id_pedido and pedidos.id_despacho = {$id_despacho} and premios.id_premio = premios_autorizados.id_premio and clientes.id_cliente = premios_autorizados.id_cliente and premios_autorizados.estatus = 1 and clientes.estatus = 1 and premios.estatus = 1 and premios_autorizados.descripcion_PA = ''  and pedidos.id_cliente IN ({$strClientes})");
      $premios_autorizadosUnic = $lider->ConsultarQuery("SELECT DISTINCT premios.id_premio, premios.nombre_premio FROM pedidos, clientes, premios_autorizados, premios WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = premios_autorizados.id_cliente and pedidos.id_pedido = premios_autorizados.id_pedido and pedidos.id_despacho = 5 and premios.id_premio = premios_autorizados.id_premio and clientes.id_cliente = premios_autorizados.id_cliente and premios_autorizados.estatus = 1 and clientes.estatus = 1 and premios.estatus = 1 and premios_autorizados.descripcion_PA = '' and pedidos.id_cliente IN ({$strClientes})");

      $premios_autorizados_obsequio = $lider->ConsultarQuery("SELECT * FROM pedidos, clientes, premios_autorizados, premios WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = premios_autorizados.id_cliente and pedidos.id_pedido = premios_autorizados.id_pedido and pedidos.id_despacho = {$id_despacho} and premios.id_premio = premios_autorizados.id_premio and clientes.id_cliente = premios_autorizados.id_cliente and premios_autorizados.estatus = 1 and clientes.estatus = 1 and premios.estatus = 1 and premios_autorizados.descripcion_PA <> '' and pedidos.id_cliente IN ({$strClientes})");
      
      $premios_autorizados_obsequioUnic = $lider->ConsultarQuery("SELECT DISTINCT premios.id_premio, premios.nombre_premio FROM pedidos, clientes, premios_autorizados, premios WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = premios_autorizados.id_cliente and pedidos.id_pedido = premios_autorizados.id_pedido and pedidos.id_despacho = {$id_despacho} and premios.id_premio = premios_autorizados.id_premio and clientes.id_cliente = premios_autorizados.id_cliente and premios_autorizados.estatus = 1 and clientes.estatus = 1 and premios.estatus = 1 and premios_autorizados.descripcion_PA <> '' and pedidos.id_cliente IN ({$strClientes})");
      

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
          $newPlan = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = {$id_plan_camp} and premios_planes_campana.tipo_premio = '{$tipo_plan_camp}' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho}");
          foreach ($newPlan as $nplan) {
            if(!empty($nplan['id_plan_campana'])){
              $premios_planes[$n1] = $nplan;
              $n1++;
            }
          }
        }
      }

      $premiosXplanes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
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

    }
    $lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE clientes.estatus=1 ORDER BY id_cliente ASC;");
    // die();
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

?>