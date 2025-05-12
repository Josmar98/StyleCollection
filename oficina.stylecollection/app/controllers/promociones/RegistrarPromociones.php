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
      $response = "9"; //echo "Registro ya guardado.";

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
  // echo "<br>";
  // // $nombre = ucwords(mb_strtolower($_POST['nombre']));
  $id_promocion = $_POST['promocion'];
  $cantidad = $_POST['cantidad'];
  if(!empty($_POST['cliente']) && !empty($_GET['admin']) && ($_SESSION['nombre_rol'] == "Administrador" || $_SESSION['nombre_rol'] == "Superusuario" || $_SESSION['nombre_rol'] == "Analista Supervisor" || $_SESSION['nombre_rol'] == "Analista" )){
    $id_user = $_POST['cliente'];
  }else{
    $id_user = $_SESSION['id_cliente'];
  }
  // echo $cantidad."<br>";
  // echo $id_user."<br>";
  $fecha_solicitud = date('d-m-Y');
  $hora_solicitud = date('h:ia');
  $pedidos = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = {$id_user} and id_despacho = {$id_despacho}");
  if(count($pedidos)>1){
    $pedido = $pedidos[0];
    // print_r($pedido);
    $id_pedido = $pedido['id_pedido'];
    $buscar = $lider->consultarQuery("SELECT * FROM promociones WHERE id_cliente = {$id_user} and id_promocion = {$id_promocion} and id_despacho = {$id_despacho}");
    if(count($buscar)<2){
      $query = "INSERT INTO promociones (id_promociones, id_cliente, id_pedido, id_promocion, id_despacho, id_campana, cantidad_solicitada_promocion, fecha_solicitada_promocion, hora_solicitada_promocion, cantidad_aprobada_promocion, estatus) VALUES (DEFAULT, {$id_user}, {$id_pedido}, {$id_promocion}, {$id_despacho}, {$id_campana}, {$cantidad}, '{$fecha_solicitud}', '{$hora_solicitud}', 0, 1)";
      // echo $query;
      $exec = $lider->registrar($query, "promociones", "id_promociones");
      if($exec['ejecucion']==true){
        $response = "1";
      }else{
        $response = "2";
      }
    }else{
      $response = "9";
    }
  }else{
    $response = "5";
  }

  if(!empty($_GET['admin']) && ($_SESSION['nombre_rol'] == "Administrador" || $_SESSION['nombre_rol'] == "Superusuario" || $_SESSION['nombre_rol'] == "Analista Supervisor" || $_SESSION['nombre_rol'] == "Analista") ){
    $clientss = $lider->consultarQuery("SELECT * FROM pedidos, clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.estatus = 1 and usuarios.estatus = 1 and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho ORDER BY clientes.primer_nombre ASC");
    $clientesConPromociones = $lider->consultarQuery("SELECT clientes.id_cliente, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, cedula, sexo, fecha_nacimiento, telefono, correo, clientes.estatus FROM clientes, pedidos, promociones WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_pedido = promociones.id_pedido and clientes.id_cliente = promociones.id_cliente and promociones.id_despacho = {$id_despacho} and promociones.estatus = 1");
    if(!empty($_GET['lider'])){
      $id_user = $_GET['lider'];
    }else{
      $id_user = 0;
    }
  }else{
    $id_user = $_SESSION['id_cliente'];
  }
  $promociones = $lider->consultarQuery("SELECT * FROM promocion WHERE id_campana = {$id_campana} and estatus=1");
  $pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = $id_user and pedidos.id_despacho = $id_despacho");
  if(count($pedidos)>1){
    $pedido = $pedidos[0];
  }else{
    $pedido['cantidad_aprobado'] = 0;
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
}


if(empty($_POST)){
  if(!empty($_GET['admin']) && ($_SESSION['nombre_rol'] == "Administrador" || $_SESSION['nombre_rol'] == "Superusuario" || $_SESSION['nombre_rol'] == "Analista Supervisor" || $_SESSION['nombre_rol'] == "Analista") ){
    $clientss = $lider->consultarQuery("SELECT * FROM pedidos, clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.estatus = 1 and usuarios.estatus = 1 and pedidos.id_cliente = clientes.id_cliente and pedidos.id_despacho = $id_despacho ORDER BY clientes.primer_nombre ASC");
    $clientesConPromociones = $lider->consultarQuery("SELECT clientes.id_cliente, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, cedula, sexo, fecha_nacimiento, telefono, correo, clientes.estatus FROM clientes, pedidos, promociones WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_pedido = promociones.id_pedido and clientes.id_cliente = promociones.id_cliente and promociones.id_despacho = {$id_despacho} and promociones.estatus = 1");
    if(!empty($_GET['lider'])){
      $id_user = $_GET['lider'];
    }else{
      $id_user = 0;
    }
  }else{
    $id_user = $_SESSION['id_cliente'];
  }
  $promociones = $lider->consultarQuery("SELECT * FROM promocion WHERE id_campana = {$id_campana} and estatus=1");
  $pedidos = $lider->consultarQuery("SELECT * FROM pedidos, clientes WHERE pedidos.id_cliente = clientes.id_cliente and pedidos.id_cliente = $id_user and pedidos.id_despacho = $id_despacho");
  if(count($pedidos)>1){
    $pedido = $pedidos[0];
  }else{
    $pedido['cantidad_aprobado'] = 0;
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
  // }else{
  //   require_once 'public/views/error404.php';
  // }

}

?>