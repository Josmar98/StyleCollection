<?php 

if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){

    if(!empty($_POST['validarData'])){
      $clausula = ucwords(mb_strtolower($_POST['clausula']));
      $query = "SELECT * FROM configuraciones WHERE clausula = '$clausula'";
      $res1 = $lider->consultarQuery($query);
      if($res1['ejecucion']==true){
        if(Count($res1)>1){
          $response = "1"; //echo "Registro ya guardado.";

        }else{
            $response = "9";
        }
      }else{
        $response = "5"; // echo 'Error en la conexion con la bd';
      }
      echo $response;
    }

    if(!empty($_POST['clausula']) && empty($_POST['validarData']) ){

      $clausula = ucwords(mb_strtolower($_POST['clausula']));
      $valor_clausula = $_POST['valor_clausula']; 
      // $query = "INSERT INTO planes (id_plan, nombre_plan, descuento_directo, primer_descuento, segundo_descuento, cantidad_coleccion, estatus) VALUES (DEFAULT, '$nombre_plan', $descuento_directo, $descuento_primer, $descuento_segundo, $cantidad, 1)";
      $query = "UPDATE configuraciones SET clausula='$clausula', valor=$valor_clausula, estatus=1 WHERE id_configuracion=$id";

      $exec = $lider->modificar($query);
      if($exec['ejecucion']==true){
        $response = "1";
      }else{
        $response = "2";
      }

      $configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones WHERE id_configuracion = $id");
       $configuracion = $configuraciones[0];
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
      $configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones WHERE id_configuracion = $id");
      if(count($configuraciones)>1){
          $configuracion = $configuraciones[0];
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
}else{
    require_once 'public/views/error404.php';
}

?>