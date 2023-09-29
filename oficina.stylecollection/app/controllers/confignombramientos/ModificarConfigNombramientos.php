<?php 

if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"){
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


      if(!empty($_POST['liderazgo']) && !empty($_POST['cantidadGemas']) ){

        $liderazgo = $_POST['liderazgo'];
        $cantidad = $_POST['cantidadGemas'];
          
        $query = "UPDATE confignombramientos SET id_liderazgo={$liderazgo}, cantidad_correspondiente='{$cantidad}', estatus=1 WHERE id_confignombramientos = {$id}";
        // $query = "INSERT INTO configuraciones (id_configuracion, clausula, valor, estatus) VALUES (DEFAULT, '$clausula', $valor_clausula, 1)";

        $exec = $lider->modificar($query);
        if($exec['ejecucion']==true){
          $response = "1";
                  if(!empty($modulo) && !empty($accion)){
                    $fecha = date('Y-m-d');
                    $hora = date('H:i:a');
                    $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Configuracion de Nombramiento', 'Editar', '{$fecha}', '{$hora}')";
                    $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                  }
        }else{
          $response = "2";
        }
        echo $response;
        // if(!empty($action)){
        //   if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
        //     require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
        //   }else{
        //       require_once 'public/views/error404.php';
        //   }
        // }else{
        //   if (is_file('public/views/'.$url.'.php')) {
        //     require_once 'public/views/'.$url.'.php';
        //   }else{
        //       require_once 'public/views/error404.php';
        //   }
        // } 

      }

      if(empty($_POST)){

        $confignombramientos = $lider->consultarQuery("SELECT * FROM confignombramientos WHERE id_confignombramientos = {$id}");
        if(count($confignombramientos)>1){
          $confignombramiento=$confignombramientos[0];
          $id_liderazgo = $confignombramiento['id_liderazgo'];
          $liderazgos = $lider->consultarQuery("SELECT * FROM liderazgos WHERE estatus = 1");
          $liderazgosS = $lider->consultarQuery("SELECT * FROM liderazgos WHERE id_liderazgo = {$id_liderazgo} and estatus = 1");
          // print_r($liderazgos);
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