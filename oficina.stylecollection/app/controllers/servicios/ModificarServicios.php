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


if(!empty($_POST['validarData'])){
  if(!empty($_GET['admin'])){
    $id_user = $_POST['id_user'];
  }else{
    $id_user = $_SESSION['id_cliente'];
  }
  $id_promo = $_POST['id_promocion'];
  $query = "SELECT * FROM promociones WHERE id_cliente = {$id_user} and id_promocion = {$id_promo} and id_despacho = {$id_despacho}";
  $res1 = $lider->consultarQuery($query);
  // print_r($res1);
  if($res1['ejecucion']==true){
    if(Count($res1)>1){
      if($res1[0]['id_promociones']==$id){
        $response = "1"; //echo "Registro ya guardado.";
      }else{
        $response = "9"; //echo "Registro ya guardado.";
      }
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
        $response = "1";
    }
  }else{
    $response = "5"; // echo 'Error en la conexion con la bd';
  }
  echo $response;
}


if(!empty($_POST['cantidad']) && empty($_POST['validarData'])){
  // print_r($_POST);
  $id_servicio = $_POST['servicio'];
  $cantidad = $_POST['cantidad'];
  if(!empty($_POST['cliente'])){
    $id_user = $_POST['cliente'];
  }else{
    $id_user = $_SESSION['id_cliente'];
  }
  $fecha_solicitud = date('d-m-Y');
  $hora_solicitud = date('h:ia');
  // $buscar = $lider->consultarQuery("SELECT * FROM servicios WHERE id_cliente = {$id_user} and id_servicio = {$id_servicio} and id_despacho = {$id_despacho}");
  $buscar = $lider->consultarQuery("SELECT * FROM servicios WHERE id_servicios = {$id}");
  // print_r($buscar);
  // die();
  if(count($buscar)>1){

    $query = "UPDATE servicios SET cantidad_servicio={$cantidad}, id_servicio={$id_servicio} WHERE id_servicios={$id} and id_cliente={$id_user}";
    // echo "<br>".$query."<br><br>";
    $exec = $lider->modificar($query);
    if($exec['ejecucion']==true){
      $response = "1";
    }else{
      $response = "2";
    }
  }else{
    $response = "9";
  }
  
  // die();
  if(!empty($_GET['lider'])){
    $id_user = $_GET['lider'];
  }else{
    $id_user = $_SESSION['id_cliente'];
  }
  $servicios = $lider->consultarQuery("SELECT * FROM servicio, servicioss WHERE servicio.id_servicioss=servicioss.id_servicioss and servicio.id_campana = {$id_campana} and servicio.estatus=1");
  
  $pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = $id_user and pedidos.id_despacho = $id_despacho");
  $servicio = $lider->consultarQuery("SELECT * FROM servicios WHERE servicios.id_servicios = {$id}");
  if(count($pedidos)>1){
    $pedido = $pedidos[0];
  }else{
    $pedido['cantidad_aprobado'] = 0;
  }
  if(count($servicio)>1){
    $servicio = $servicio[0];
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
  if(!empty($_GET['lider'])){
    $id_user = $_GET['lider'];
  }else{
    $id_user = $_SESSION['id_cliente'];
  }
  $servicios = $lider->consultarQuery("SELECT * FROM servicio, servicioss WHERE servicio.id_servicioss=servicioss.id_servicioss and servicio.id_campana = {$id_campana} and servicio.estatus=1");
  
  $pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = $id_user and pedidos.id_despacho = $id_despacho");
  $servicio = $lider->consultarQuery("SELECT * FROM servicios WHERE servicios.id_servicios = {$id}");
  if(count($pedidos)>1){
    $pedido = $pedidos[0];
  }else{
    $pedido['cantidad_aprobado'] = 0;
  }

  if(count($servicio)>1){
    $servicio = $servicio[0];
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