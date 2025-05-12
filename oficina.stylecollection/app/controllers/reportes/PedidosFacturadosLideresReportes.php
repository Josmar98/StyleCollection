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
      $clientesss = $_GET['L'];
      $nameProduct = "Cosmeticos";
      $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho}");
      $id_campana=$despachos[0]['id_campana'];
      //Esto no
      $clientess = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1");
      $pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho");
      //Esto no

      $tipoColecciones=[];
      $tipoColecciones[count($tipoColecciones)]=['id'=>"Productos", 'name'=>$nameProduct];
      $despachos_sec = $lider->consultarQuery("SELECT * FROM despachos_secundarios WHERE estatus=1 and id_despacho={$id_despacho}");
      foreach ($despachos_sec as $despsec) {
        if(!empty($despsec['id_despacho_sec'])){
          $tipoColecciones[count($tipoColecciones)]=['id'=>$despsec['id_despacho_sec'], 'name'=>$despsec['nombre_coleccion_sec']];
        }
      }
      // print_r($clientesss);
      // echo "<br><br><br>";
      $filterCLientes = "";
      $index = 0;
      foreach ($clientesss as $id_cliente) {
        $filterCLientes.=$id_cliente;
        $index++;
        if($index < count($clientesss)){
          $filterCLientes.=", ";  
        }
      }
      
      // echo "Filtro: ".$filterCLientes."<br>";
      $queryPedidos="SELECT * FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho={$id_despacho} and clientes.id_cliente IN ({$filterCLientes})";
      $pedidosProductos = $lider->consultarQuery($queryPedidos);
      $facturados = [];
      // $facturados['Productos']=[];
      foreach($pedidosProductos as $key){
        if(!empty($key['cantidad_aprobado'])){
          // echo "===================<br>";
          // print_r($key);
          // echo $key['id_pedido'];
          // echo "<br><br>";
          if(empty($facturados[$key['id_pedido']])){
            $facturados[$key['id_pedido']]['id_cliente']=$key['id_cliente'];
            $facturados[$key['id_pedido']]['cliente']=$key['primer_nombre']." ".$key['primer_apellido'];
          }
          if(!empty($facturados[$key['id_pedido']])){
            $facturados[$key['id_pedido']][$nameProduct]=$key['cantidad_aprobado_individual'];
          }
          }
        }
        
        $querySecundarios="SELECT * FROM clientes, pedidos, pedidos_secundarios WHERE clientes.id_cliente = pedidos.id_cliente and pedidos_secundarios.id_pedido=pedidos.id_pedido and pedidos_secundarios.id_cliente=clientes.id_cliente and pedidos_secundarios.id_despacho={$id_despacho} and pedidos.id_despacho={$id_despacho} and clientes.id_cliente IN ({$filterCLientes})";
        $pedidosSecundarios = $lider->consultarQuery($querySecundarios);
        foreach($pedidosSecundarios as $key){
          if(!empty($key['id_despacho_sec'])){
            // echo "===================<br>";
            // print_r($key);
            // echo $key['id_pedido'];
            // echo "<br><br>";
            foreach ($despachos_sec as $despsec) {
              if(!empty($despsec['id_despacho_sec'])){
                if($key['cantidad_aprobado']>0){
                  if($despsec['id_despacho_sec']==$key['id_despacho_sec']){
                    if(empty($facturados[$key['id_pedido']])){
                      $facturados[$key['id_pedido']]['id_cliente']=$key['id_cliente'];
                      $facturados[$key['id_pedido']]['cliente']=$key['primer_nombre']." ".$key['primer_apellido'];
                    }
                    if(!empty($facturados[$key['id_pedido']])){
                      $facturados[$key['id_pedido']][$despsec['nombre_coleccion_sec']]=$key['cantidad_aprobado_sec'];
                    }
                  }
                }
              }
            }
          // $facturados[$despsec['id_despacho_sec']][count($facturados[$despsec['id_despacho_sec']])]=[
            //   'cantidad'=>$key['cantidad_aprobado_sec'],
            //   'numero_factura'=>$key['numero_factura']
            // ];
        }
      }
      $promosNames = $lider->consultarQuery("SELECT * FROM promocion, promocionesinv WHERE promocionesinv.id_promocioninv=promocion.id_promocioninv and promocion.id_campana={$id_campana} and promocion.estatus=1 and promocionesinv.estatus=1");
      $listaPromociones=[];
      foreach ($promosNames as $key) {
        if(!empty($key['id_promocion'])){
          $nameGeneral = $key['nombre_promocioninv'];
          $namePromo = substr($key['nombre_promocion'], strlen($key['nombre_promocioninv'])+2);
          $namePromo = substr($namePromo, 0, strlen($namePromo)-1);
          // echo "namePromo: ".$namePromo."<br>";
          $listaPromociones[count($listaPromociones)]=['id'=>$key['id_promocion'],'name'=>$namePromo];
        }
      }

      $queryPromociones = "SELECT * FROM promociones, promocion, promocionesinv WHERE promocionesinv.id_promocioninv=promocion.id_promocioninv and promocion.id_promocion=promociones.id_promocion and promocion.id_campana={$id_campana} and promociones.id_cliente IN ({$filterCLientes})";
      $promociones = $lider->consultarQuery($queryPromociones);
      foreach ($listaPromociones as $list) {
        // print_r($list['id']);
        // echo "<br><br>";
        foreach ($promociones as $key) {
          if(!empty($key['id_promociones'])){
            if($list['id']==$key['id_promocion']){
              // print_r($key['id_promocion']);
              // echo "<br><br>";
              $facturados[$key['id_pedido']][$list['name']]=$key['cantidad_aprobada_promocion'];
              // echo $key['nombre_promocion'];
            }
          }
        }
      }



      // $queryPedidos="SELECT * FROM clientes, pedidos, factura_despacho WHERE clientes.id_cliente = pedidos.id_cliente and factura_despacho.id_pedido=pedidos.id_pedido and factura_despacho.estatus=1 and pedidos.id_despacho={$id_despacho} and clientes.id_cliente IN ({$filterCLientes})";
      // $pedidosProductos = $lider->consultarQuery($queryPedidos);
      // $facturados = [];
      // $facturados['Productos']=[];
      // foreach($pedidosProductos as $key){
      //   if(!empty($key['numero_factura'])){
      //     // echo "===================<br>";
      //     // print_r($key);
      //     // echo "<br><br>";
      //     $facturados['Productos'][count($facturados['Productos'])]=[
      //       'cantidad'=>$key['cantidad_aprobado_individual'], 
      //       'numero_factura'=>$key['numero_factura']
      //     ];
      //   }
      // }
      // $queryPedidos="SELECT * FROM clientes, pedidos, factura_despacho_personalizada WHERE clientes.id_cliente = pedidos.id_cliente and factura_despacho_personalizada.id_pedido=pedidos.id_pedido and factura_despacho_personalizada.estatus=1 and pedidos.id_despacho={$id_despacho} and clientes.id_cliente IN ({$filterCLientes})";
      // $pedidosProductos = $lider->consultarQuery($queryPedidos);
      // foreach($pedidosProductos as $key){
      //   if(!empty($key['numero_factura'])){
      //     // echo "===================<br>";
      //     // print_r($key);
      //     // echo "<br><br>";
      //     $facturados['Productos'][count($facturados['Productos'])]=[
      //       'cantidad'=>$key['cantidad_aprobado_individual'], 
      //       'numero_factura'=>$key['numero_factura']
      //     ];
      //   }
      // }
      // $querySecundarios="SELECT * FROM clientes, pedidos, pedidos_secundarios, factura_despacho WHERE clientes.id_cliente = pedidos.id_cliente and factura_despacho.id_pedido=pedidos.id_pedido and factura_despacho.estatus=1 and pedidos_secundarios.id_pedido=pedidos.id_pedido and pedidos_secundarios.id_cliente=clientes.id_cliente and pedidos_secundarios.id_despacho={$id_despacho} and pedidos.id_despacho={$id_despacho} and clientes.id_cliente IN ({$filterCLientes})";
      // $pedidosSecundarios = $lider->consultarQuery($querySecundarios);
      // foreach ($despachos_sec as $despsec) {
      //   if(!empty($despsec['id_despacho_sec'])){
      //     if(empty($facturados[$despsec['id_despacho_sec']])){
      //       $facturados[$despsec['id_despacho_sec']]=[];
      //     }
      //     foreach($pedidosSecundarios as $key){
      //       if(!empty($key['numero_factura'])){
      //         if($despsec['id_despacho_sec']==$key['id_despacho_sec']){
      //           // echo "===================<br>";
      //           // print_r($key);
      //           // echo "<br><br>";
      //           $facturados[$despsec['id_despacho_sec']][count($facturados[$despsec['id_despacho_sec']])]=[
      //             'cantidad'=>$key['cantidad_aprobado_sec'],
      //             'numero_factura'=>$key['numero_factura']
      //           ];
      //         }
      //       }
      //     }
      //   }
      // }
      // $querySecundarios="SELECT * FROM clientes, pedidos, pedidos_secundarios, factura_despacho_personalizada WHERE clientes.id_cliente = pedidos.id_cliente and factura_despacho_personalizada.id_pedido=pedidos.id_pedido and factura_despacho_personalizada.estatus=1 and pedidos_secundarios.id_pedido=pedidos.id_pedido and pedidos_secundarios.id_cliente=clientes.id_cliente and pedidos_secundarios.id_despacho={$id_despacho} and pedidos.id_despacho={$id_despacho} and clientes.id_cliente IN ({$filterCLientes})";
      // $pedidosSecundarios = $lider->consultarQuery($querySecundarios);
      // foreach ($despachos_sec as $despsec) {
      //   if(!empty($despsec['id_despacho_sec'])){
      //     if(empty($facturados[$despsec['id_despacho_sec']])){
      //       $facturados[$despsec['id_despacho_sec']]=[];
      //     }
      //     foreach($pedidosSecundarios as $key){
      //       if(!empty($key['numero_factura'])){
      //         if($despsec['id_despacho_sec']==$key['id_despacho_sec']){
      //           // echo "===================<br>";
      //           // print_r($key);
      //           // echo "<br><br>";
      //           $facturados[$despsec['id_despacho_sec']][count($facturados[$despsec['id_despacho_sec']])]=[
      //             'cantidad'=>$key['cantidad_aprobado_sec'],
      //             'numero_factura'=>$key['numero_factura']
      //           ];
      //         }
      //       }
      //     }
      //   }
      // }
      // print_r($facturados);
      // echo "<br><br>";
      
      
      // foreach($facturados as $key){
      //   print_r($key);
      //   echo "<br>";
      //   echo "<br><br>";
      // }
    }
    
    $lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE clientes.estatus=1 ORDER BY id_cliente ASC;");
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