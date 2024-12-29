<?php 

  // if(is_file('app/models/indexModels.php')){
  //   require_once'app/models/indexModels.php';
  // }
  // if(is_file('../app/models/indexModels.php')){
  //   require_once'../app/models/indexModels.php';
  // }
  // $lider = new Models();
if($_SESSION['nombre_rol']!="Vendedor" && $_SESSION['nombre_rol']!="Conciliador"){


  if(!empty($_POST['validarData'])){
    $nombre = ucwords(mb_strtolower($_POST['nombre']));
    $query = "SELECT * FROM rutas WHERE nombre_ruta = '$nombre'";
    $res1 = $lider->consultarQuery($query);
    if($res1['ejecucion']==true){
      if(Count($res1)>1){
        // $response = "9"; //echo "Registro ya guardado.";

        $res2 = $lider->consultarQuery("SELECT * FROM rutas WHERE nombre_ruta = '$nombre' and estatus = 0");
        if($res2['ejecucion']==true){
          if(Count($res2)>1){
            $res3 = $lider->modificar("UPDATE rutas SET estatus = 1 WHERE nombre_ruta = '$nombre'");
            if($res3['ejecucion']==true){
              $response = "1";
            }
          }else{
            $response = "9"; //echo "Registro ya guardado.";
          }
        }

      }else{
          $response = "1";
      }
    }else{
      $response = "5"; // echo 'Error en la conexion con la bd';
    }
    echo $response;
  }


  if(!empty($_POST['nombre']) && empty($_POST['validarData'])){

    // print_r($_POST);
    $nombre = ucwords(mb_strtolower($_POST['nombre']));
    // $descripcion = ucwords(mb_strtolower($_POST['descripcion']));
    
    $query = "INSERT INTO rutas (id_ruta, nombre_ruta, estatus) VALUES (DEFAULT, '$nombre', 1)";
    $exec = $lider->registrar($query, "rutas", "id_ruta");
    // print_r($exec);
    if($exec['ejecucion']==true){
      $response = "1";
    }else{
      $response = "2";
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
    // print_r($exec);
  }
  if(!empty($_POST['ruta']) && !empty($_POST['posiciones']) && !empty($_POST['lideres'])){
    // print_r($_POST);
    $ruta = $_POST['ruta'];
    $posiciones = $_POST['posiciones'];
    $lideres = $_POST['lideres'];
    $i = 0;
    $number = 1;
    $responses = [];
    $exec2 = $lider->eliminar("DELETE FROM rutaslideres WHERE id_ruta = $id and estatus=1");
    if($exec2['ejecucion']==true){
      foreach ($lideres as $id_lider) {
        if($id_lider > 0){
          $query = "INSERT INTO rutaslideres (id_ruta_lider, id_ruta, id_cliente, posicion, estatus) VALUES (DEFAULT, {$ruta}, {$id_lider}, {$number}, 1)";
          $exec = $lider->registrar($query, "rutaslideres", "id_ruta_lider");
          if($exec['ejecucion']==true){
            $responses[$i] = 1;
          }else{
            $responses[$i] = 2;
          }
          // echo "Ruta: ".$ruta." | Lider: ".$id_lider." | Posicion: ".$number." <br>";
          $number++;
          $i++;
        }
      }
      $sum = 0;
      foreach ($responses as $key) {
        $sum += $key;
      }
      if($sum == $i){
        $response = "1";
      }else{
        $response = "2";
      }
    }else{
      $response = "2";
    }


    $lideres = $lider->consultarQuery("SELECT * FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.estatus = 1 and usuarios.estatus = 1 ORDER BY clientes.id_cliente ASC");
    $lideresya = $lider->consultarQuery("SELECT * FROM clientes, rutaslideres, rutas WHERE rutaslideres.id_cliente = clientes.id_cliente and rutaslideres.estatus = 1 and rutas.id_ruta = rutaslideres.id_ruta and rutaslideres.estatus=1 and rutas.estatus=1");


    $rutalider = $lider->consultarQuery("SELECT * FROM clientes, rutaslideres, rutas WHERE rutaslideres.id_cliente = clientes.id_cliente and rutaslideres.estatus = 1 and rutas.id_ruta = rutaslideres.id_ruta and rutaslideres.id_ruta = $id and rutaslideres.estatus=1 and rutas.estatus=1 ORDER BY rutaslideres.posicion ASC");
    $numeros = count($rutalider) - 1;



    $rutasya = $lider->consultarQuery("SELECT DISTINCT rutas.id_ruta, nombre_ruta, rutaslideres.estatus FROM rutaslideres, rutas WHERE rutaslideres.estatus = 1 and rutas.id_ruta = rutaslideres.id_ruta and rutaslideres.estatus=1 and rutas.estatus=1");
    // $rutaactual = $lider->consultarQuery("SELECT DISTINCT rutas.id_ruta, nombre_ruta, rutaslideres.estatus FROM rutaslideres, rutas WHERE rutaslideres.estatus = 1 and rutas.id_ruta = rutaslideres.id_ruta and rutas.id_ruta = $id");
    
    $rutas = $lider->consultarQuery("SELECT * FROM rutas WHERE rutas.estatus = 1");
    $cantidadMaxima = $numeros;
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
    $lideres = $lider->consultarQuery("SELECT * FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.estatus = 1 and usuarios.estatus = 1 ORDER BY clientes.id_cliente ASC");
    $lideresya = $lider->consultarQuery("SELECT * FROM clientes, rutaslideres, rutas WHERE rutaslideres.id_cliente = clientes.id_cliente and rutaslideres.estatus = 1 and rutas.id_ruta = rutaslideres.id_ruta and rutaslideres.estatus=1 and rutas.estatus=1");


    $rutalider = $lider->consultarQuery("SELECT * FROM clientes, rutaslideres, rutas WHERE rutaslideres.id_cliente = clientes.id_cliente and rutaslideres.estatus = 1 and rutas.id_ruta = rutaslideres.id_ruta and rutaslideres.id_ruta = $id and rutaslideres.estatus=1 and rutas.estatus=1 ORDER BY rutaslideres.posicion ASC");
    $numeros = count($rutalider) - 1;



    $rutasya = $lider->consultarQuery("SELECT DISTINCT rutas.id_ruta, nombre_ruta, rutaslideres.estatus FROM rutaslideres, rutas WHERE rutaslideres.estatus = 1 and rutas.id_ruta = rutaslideres.id_ruta and rutaslideres.estatus=1 and rutas.estatus=1");
    // $rutaactual = $lider->consultarQuery("SELECT DISTINCT rutas.id_ruta, nombre_ruta, rutaslideres.estatus FROM rutaslideres, rutas WHERE rutaslideres.estatus = 1 and rutas.id_ruta = rutaslideres.id_ruta and rutas.id_ruta = $id");
    
    $rutas = $lider->consultarQuery("SELECT * FROM rutas WHERE rutas.estatus = 1");
    $cantidadMaxima = 10;
    if($numeros > $cantidadMaxima){
      $cantidadMaxima = $numeros;
    }
    if(!empty($_GET['cant'])){
      $cantidadMaxima = $_GET['cant'];
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
}else{
  require_once 'public/views/error404.php';
}


?>