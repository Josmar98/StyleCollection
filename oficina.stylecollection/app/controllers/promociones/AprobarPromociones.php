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
  
  $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho}");

if(!empty($_POST['cantidad']) && empty($_POST['validarData'])){

  // print_r($_POST);
  $promocion = $lider->consultarQuery("SELECT * FROM promociones WHERE promociones.id_promociones = {$id}");
  $promocion = $promocion[0];

  $existencias = $lider->consultarQuery("SELECT * FROM promocion, existencias_promocion WHERE promocion.id_promocion = existencias_promocion.id_promocion and existencias_promocion.id_campana = {$id_campana} and promocion.id_campana = {$id_campana} and promocion.estatus = 1 and existencias_promocion.estatus = 1 and promocion.id_promocion = {$promocion['id_promocion']}");
  $promociones = $lider->consultarQuery("SELECT * FROM usuarios, clientes, pedidos, promocion, promociones WHERE usuarios.id_cliente = clientes.id_cliente and clientes.id_cliente = pedidos.id_cliente and clientes.id_cliente = promociones.id_cliente and pedidos.id_pedido = promociones.id_pedido and promocion.id_promocion = promociones.id_promocion and promociones.estatus = 1 and clientes.estatus = 1 and promocion.estatus = 1 and pedidos.estatus = 1 and promociones.id_despacho = {$id_despacho} and clientes.id_cliente = {$promocion['id_cliente']} and promociones.id_promociones = {$id}");
  $promociones = $promociones[0];
  $existencia = [];
  // if(count($existencias)>1){
    if(count($existencias)>1){
      $existencia = $existencias[0];
    }
    $cantidad = $_POST['cantidad'];
    // echo $id." ".$promocion['id_promocion']." ".$cantidad;
    // echo "<br>";
    // print_r($existencia['existencia_actual']);
    // $existencia['existencia_actual'] = 4;
    $continuar = false;
    if(count($existencia)>0){
      if($existencia['existencia_actual'] > $cantidad){
        $continuar = true;
      }else{
        $continuar = false;
      }
    }else{
      $continuar = true;
    }
    if($continuar == true){
      $fecha = date("d-m-Y");
      $hora = date('h:ia');;
      $query = "UPDATE promociones SET cantidad_aprobada_promocion={$cantidad}, fecha_aprobada_promocion='{$fecha}', hora_aprobada_promocion='{$hora}' WHERE id_promociones={$id}";
      $exec = $lider->modificar($query);
      if($exec['ejecucion']==true){
        if(count($existencia)<1){
          $response = "1";
        }else{
          $promocionesFull = $lider->consultarQuery("SELECT * FROM clientes, pedidos, promocion, promociones WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_pedido = promociones.id_pedido and clientes.id_cliente = promociones.id_cliente and promocion.id_promocion = promociones.id_promocion and promocion.id_campana = {$id_campana} and promociones.id_despacho = {$id_despacho} and promociones.estatus = 1 and promocion.id_promocion = {$promociones['id_promocion']}");
          $promocionesAprobadas = 0;
          foreach ($promocionesFull as $keys) {
            if(!empty($keys['id_promociones'])){
              $promocionesAprobadas += $keys['cantidad_aprobada_promocion'];
            }
          }
          $nuevaExistencia1 = $existencia['existencia_actual']-$cantidad;
          $nuevaExistencia2 = $existencia['existencia_total']-$promocionesAprobadas;
          $query = "UPDATE existencias_promocion SET existencia_actual = {$nuevaExistencia2} WHERE id_existencia_promocion={$existencia['id_existencia_promocion']}";
          $exec2 = $lider->modificar($query);
          if($exec2['ejecucion']==true){
            $response = "1";
          }else{
            $response = "2";
          }
        }
      }else{
        $response = "2";
      }
    }else{
      $response = "77";
    }
  // }else{
  //   $response = "5";
  // }
  // $response = "77";
  // echo "<br><h3>Codigo: ".$response."<h3><br>";
  
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
  $promocion = $lider->consultarQuery("SELECT * FROM promociones WHERE promociones.id_promociones = {$id}");
  if(count($promocion)>1){
    $promocion = $promocion[0];
    $existencias = $lider->consultarQuery("SELECT * FROM promocion, existencias_promocion WHERE promocion.id_promocion = existencias_promocion.id_promocion and existencias_promocion.id_campana = {$id_campana} and promocion.id_campana = {$id_campana} and promocion.estatus = 1 and existencias_promocion.estatus = 1 and promocion.id_promocion = {$promocion['id_promocion']}");
    $promociones = $lider->consultarQuery("SELECT * FROM usuarios, clientes, pedidos, promocion, promociones WHERE usuarios.id_cliente = clientes.id_cliente and clientes.id_cliente = pedidos.id_cliente and clientes.id_cliente = promociones.id_cliente and pedidos.id_pedido = promociones.id_pedido and promocion.id_promocion = promociones.id_promocion and promociones.estatus = 1 and clientes.estatus = 1 and promocion.estatus = 1 and pedidos.estatus = 1 and promociones.id_despacho = {$id_despacho} and clientes.id_cliente = {$promocion['id_cliente']} and promociones.id_promociones = {$id}");
    // print_r($promociones);
    $promociones = $promociones[0];
    $existencia = [];
    if(count($existencias)>1){
      $existencia = $existencias[0];
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

?>