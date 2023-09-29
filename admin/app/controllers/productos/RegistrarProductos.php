<?php 


      if(!empty($_POST['validarData'])){
        $nombre_producto = ucwords(mb_strtolower($_POST['nombre_producto']));
        $cantidad = mb_strtolower($_POST['cantidad']);
        $query = "SELECT * FROM productos WHERE producto = '$nombre_producto' and cantidad='$cantidad'";
        $res1 = $lider->consultarQuery($query);
          // print_r($res1);
        if($res1['ejecucion']==true){
          if(Count($res1)>1){
            // $response = "9"; //echo "Registro ya guardado.";
            $res2 = $lider->consultarQuery("SELECT * FROM productos WHERE producto = '$nombre_producto' and estatus = 0");
            if($res2['ejecucion']==true){
              if(Count($res2)>1){
                $res3 = $lider->modificar("UPDATE productos SET estatus = 1 WHERE producto = '$nombre_producto'");
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


      if(!empty($_POST['nombre_producto']) && !empty($_POST['cantidad']) && empty($_POST['validarData'])){

        // print_r($_POST);
        $nombre_producto = ucwords(mb_strtolower($_POST['nombre_producto']));
        $descripcion = ucwords(mb_strtolower($_POST['descripcion']));
        $cantidad = mb_strtolower($_POST['cantidad']);
        // $precio = $_POST['precio'];
        
        $query = "INSERT INTO productos (id_producto, producto, descripcion, cantidad, estatus) VALUES (DEFAULT, '$nombre_producto', '$descripcion', '$cantidad', 1)";

        $exec = $lider->registrar($query, "productos", "id_producto");
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
      if(empty($_POST)){
        
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