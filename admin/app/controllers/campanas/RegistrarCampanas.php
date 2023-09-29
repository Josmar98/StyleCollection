<?php 


      if(!empty($_POST['validarData'])){
        $nombre_campana = ucwords(mb_strtolower($_POST['nombre_campana']));
        $numero_campana = $_POST['numero_campana'];
        $query = "SELECT * FROM campanas WHERE nombre_campana = '$nombre_campana' and numero_campana = $numero_campana and estatus = 1
        ";
        $res1 = $lider->consultarQuery($query);
        if($res1['ejecucion']==true){
          if(Count($res1)>1){
            $response = "9"; //echo "Registro ya guardado.";
            // $res2 = $lider->consultarQuery("SELECT * FROM campanas WHERE nombre_campana = '$nombre_campana' and numero_campana = $numero_campana and estatus = 0");
            // if($res2['ejecucion']==true){
            //   if(Count($res2)>1){
            //     $res3 = $lider->modificar("UPDATE campanas SET estatus = 1 WHERE nombre_campana = '$nombre_campana' and numero_campana = $numero_campana");
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

      if(!empty($_POST['nombre_campana']) && !empty($_POST['num_campana'])){

        // print_r($_POST);
        $nombre_campana = ucwords(mb_strtolower($_POST['nombre_campana']));
        $num_campana = $_POST['num_campana'];
        $anio = $_POST['anio'];
        
        $query = "INSERT INTO campanas (id_campana, nombre_campana, anio_campana, numero_campana, visibilidad, estatus) VALUES (DEFAULT, '$nombre_campana', '$anio', $num_campana, 0, 1)";

        $exec = $lider->registrar($query, "campanas", "id_campana");
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


?>