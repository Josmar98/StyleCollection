<?php 


    if(!empty($_POST['validarData'])){
      $query = "SELECT * FROM usuarios WHERE id_usuario = $id";
      $res1 = $lider->consultarQuery($query);
      if($res1['ejecucion']==true){
        if(Count($res1)>1){
          $response = "1";
        }else{
          $response = "9"; //echo "Registro ya guardado.";
        }
      }else{
        $response = "5"; // echo 'Error en la conexion con la bd';
      }
      echo $response;
    }

    if(!empty($_POST['nombre_usuario']) && !empty($_POST['password'])){

      // print_r($_POST);
      $nombre_usuario = ucwords(mb_strtolower($_POST['nombre_usuario']));
      $password = $_POST['password'];
      $id_cliente = $_POST['cliente'];
      $campAnt = $lider->consultarQuery("SELECT * FROM usuarios WHERE id_usuario = $id");
      $query = "UPDATE usuarios SET id_cliente=$id_cliente, nombre_usuario='$nombre_usuario', password='$password', estatus = 1 WHERE id_usuario = $id";

      $exec = $lider->modificar($query);
      if($exec['ejecucion']==true){
        $response = "1";
      }else{
        $response = "2";
      }

      $clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1 ORDER BY primer_nombre asc");
      $usuarios = $lider->consultarQuery("SELECT * FROM usuarios, clientes WHERE clientes.id_cliente = usuarios.id_cliente and usuarios.estatus = 1 and usuarios.id_usuario = $id");
      $usuario = $usuarios[0];
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
      $clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1 ORDER BY primer_nombre asc");
      $usuarios = $lider->consultarQuery("SELECT * FROM usuarios, clientes WHERE clientes.id_cliente = usuarios.id_cliente and usuarios.estatus = 1 and usuarios.id_usuario = $id");
      
      if(Count($usuarios)>1){
          $usuario = $usuarios[0];
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
    }


?>