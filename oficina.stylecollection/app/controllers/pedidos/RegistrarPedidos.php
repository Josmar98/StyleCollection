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
  $query = "SELECT * FROM pedidos WHERE id_cliente = $id_user and id_despacho = {$id_despacho}";
  $res1 = $lider->consultarQuery($query);
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
  // $nombre = ucwords(mb_strtolower($_POST['nombre']));
  $cantidad = $_POST['cantidad'];
  if(!empty($_POST['cliente']) && !empty($_GET['admin']) && ($_SESSION['nombre_rol'] == "Administrador" || $_SESSION['nombre_rol'] == "Superusuario" || $_SESSION['nombre_rol'] == "Analista Supervisor" || $_SESSION['nombre_rol'] == "Analista" )){
    $id_user = $_POST['cliente'];
  }else{
    $id_user = $_SESSION['id_cliente'];
  }
  $fecha_pedido = date('d-m-Y');
  $hora_pedido = date('g:ia');
  $buscar = $lider->consultarQuery("SELECT * FROM pedidos WHERE id_cliente = {$id_user} and id_despacho = {$id_despacho}");
  if(count($buscar)<2){

  $query = "INSERT INTO pedidos (id_pedido, id_cliente, id_despacho, cantidad_pedido, fecha_pedido, hora_pedido, cantidad_aprobado, cantidad_total, visto_admin, estatus) VALUES (DEFAULT, $id_user, $id_despacho, $cantidad, '$fecha_pedido', '$hora_pedido', 0, 0, 0, 1)";
  
    $exec = $lider->registrar($query, "pedidos", "id_pedido");
    if($exec['ejecucion']==true){
      $response = "1";
              if(!empty($modulo) && !empty($accion)){
                $id = $exec['id'];
                $elementos = array(
                        "Nombres"=> [0=>"Id", 1=>ucwords("Id Cliente"), 2=> ucwords("Id despacho"), 3=> ucwords("Cantidad de Colecciones"), 4=>ucwords("Estatus")],
                        "Anterior"=> "",
                        "Actual"=> [ 0=> $id, 1=> $id_user, 2=> $id_despacho , 3=>$cantidad, 4=>"1"]
                      );
                  $elementosJson = json_encode($elementos, JSON_UNESCAPED_UNICODE, JSON_UNESCAPED_SLASHES);
                $fecha = date('Y-m-d');
                $hora = date('H:i:a');
                $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora, elementos) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Pedidos', 'Solicitar', '{$fecha}', '{$hora}', '{$elementosJson}')";
                $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
              }
    }else{
      $response = "2";
    }
  }else{
    $response = "9";
  }

  if(!empty($_GET['admin']) && ($_SESSION['nombre_rol'] == "Administrador" || $_SESSION['nombre_rol'] == "Superusuario" || $_SESSION['nombre_rol'] == "Analista Supervisor" || $_SESSION['nombre_rol'] == "Analista") ){
    $clientss = $lider->consultarQuery("SELECT clientes.id_cliente, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, cedula, sexo, fecha_nacimiento, telefono, correo, clientes.estatus FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.estatus = 1 and usuarios.estatus = 1 ORDER BY primer_nombre ASC");
    $clientesConPedido = $lider->consultarQuery("SELECT clientes.id_cliente, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, cedula, sexo, fecha_nacimiento, telefono, correo, clientes.estatus FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = $id_despacho and clientes.estatus = 1");
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
  // print_r($exec);
}


if(empty($_POST)){

  if(!empty($_GET['admin']) && ($_SESSION['nombre_rol'] == "Administrador" || $_SESSION['nombre_rol'] == "Superusuario" || $_SESSION['nombre_rol'] == "Analista Supervisor" || $_SESSION['nombre_rol'] == "Analista") ){
    $clientss = $lider->consultarQuery("SELECT clientes.id_cliente, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, cedula, sexo, fecha_nacimiento, telefono, correo, clientes.estatus FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.estatus = 1 and usuarios.estatus = 1 ORDER BY primer_nombre ASC");
    $clientesConPedido = $lider->consultarQuery("SELECT clientes.id_cliente, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, cedula, sexo, fecha_nacimiento, telefono, correo, clientes.estatus FROM clientes, pedidos WHERE clientes.id_cliente = pedidos.id_cliente and pedidos.id_despacho = $id_despacho and clientes.estatus = 1");
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

}

?>