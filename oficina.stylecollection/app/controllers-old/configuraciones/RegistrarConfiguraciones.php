<?php 

if($_SESSION['nombre_rol']=="Superusuario"){
      if(!empty($_POST['validarData'])){
        $clausula = ucwords(mb_strtolower($_POST['clausula']));
        $query = "SELECT * FROM configuraciones WHERE clausula = '$clausula'";
        $res1 = $lider->consultarQuery($query);
        if($res1['ejecucion']==true){
          if(Count($res1)>1){
            // $response = "9"; //echo "Registro ya guardado.";

            $res2 = $lider->consultarQuery("SELECT * FROM configuraciones WHERE clausula = '$clausula' and estatus = 0");
            if($res2['ejecucion']==true){
              if(Count($res2)>1){
                $res3 = $lider->modificar("UPDATE configuraciones SET estatus = 1 WHERE clausula = '$clausula'");
                if($res3['ejecucion']==true){
                  $response = "1";

                  if(!empty($modulo) && !empty($accion)){
                    $fecha = date('Y-m-d');
                    $hora = date('H:i:a');
                    $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Configuraciones', 'Registrar', '{$fecha}', '{$hora}')";
                    $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                  }
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


      if(!empty($_POST['clausula']) && empty($_POST['validarData']) ){
        // print_r($_POST);

        $clausula = ucwords(mb_strtolower($_POST['clausula']));
        $valor_clausula = $_POST['valor_clausula'];
        
        // $query = "INSERT INTO planes (id_plan, nombre_plan, descuento_directo, primer_descuento, segundo_descuento, cantidad_coleccion, estatus) VALUES (DEFAULT, '$nombre_plan', $descuento_directo, $descuento_primer, $descuento_segundo, $cantidad, 1)";
        $query = "INSERT INTO configuraciones (id_configuracion, clausula, valor, estatus) VALUES (DEFAULT, '$clausula', $valor_clausula, 1)";

        $exec = $lider->registrar($query, "configuraciones", "id_configuracion");
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

}else{
    require_once 'public/views/error404.php';
}

?>