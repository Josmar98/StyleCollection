<?php 

    if(!empty($_POST['validarData'])){
      $nombre_usuario = ucwords(mb_strtolower($_POST['nombre_usuario']));
      $query = "SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario'";
      $res1 = $lider->consultarQuery($query);
      if($res1['ejecucion']==true){
        if(Count($res1)>1){
          // $response = "9"; //echo "Registro ya guardado.";
          $res2 = $lider->consultarQuery("SELECT * FROM usuarios WHERE nombre_usuario = '$nombre_usuario' and estatus = 0");
          if($res2['ejecucion']==true){
            if(Count($res2)>1){
              $res3 = $lider->modificar("UPDATE usuarios SET estatus = 1 WHERE nombre_usuario = '$nombre_usuario'");
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


    if(!empty($_POST['nombre_usuario']) && !empty($_POST['password'])){

      // print_r($_POST);
      $nombre_usuario = ucwords(mb_strtolower($_POST['nombre_usuario']));
      $password = $_POST['password'];
      $id_cliente = $_POST['cliente'];
      $buscar = $lider->consultarQuery("SELECT * FROM usuarios WHERE usuarios.id_cliente = {$id_cliente}");
      if(count($buscar)<2){
          $query = "INSERT INTO usuarios (id_usuario, id_cliente, nombre_usuario, password, estatus) VALUES (DEFAULT, $id_cliente, '$nombre_usuario', '$password', 1)";

          $exec = $lider->registrar($query, "usuarios", "id_usuario");
          if($exec['ejecucion']==true){
            $response = "1";
          }else{
            $response = "2";
          }
      }else{
        $response = "9";
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
    if(empty($_POST)){
      $usuarios = $lider->consultarQuery("SELECT * FROM usuarios");
      $clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus = 1 ORDER BY primer_nombre asc");
      
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