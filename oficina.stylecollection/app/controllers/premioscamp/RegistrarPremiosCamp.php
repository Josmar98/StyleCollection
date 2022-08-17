<?php 
$amPremioscamp = 0;
$amPremioscampR = 0;
$amPremioscampC = 0;
$amPremioscampE = 0;
$amPremioscampB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Premios De Campaña"){
      $amPremioscamp = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amPremioscampR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amPremioscampC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amPremioscampE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amPremioscampB = 1;
      }
    }
  }
}
if($amPremioscampR == 1){
  
      $id_campana = $_GET['campaing'];
      $numero_campana = $_GET['n'];
      $anio_campana = $_GET['y'];

    if(!empty($_POST['validarData'])){
      $plan = ucwords(mb_strtolower($_POST['plan']));
      $query = "SELECT * FROM premios_planes_campana WHERE id_plan_campana = $plan";
      $res1 = $lider->consultarQuery($query);
      if($res1['ejecucion']==true){
        if(Count($res1)>1){
          // $response = "9"; //echo "Registro ya guardado.";

          $res2 = $lider->consultarQuery("SELECT * FROM premios_planes_campana WHERE id_plan = $plan and id_campana = $id_campana and estatus = 0");
          if($res2['ejecucion']==true){
            if(Count($res2)>1){
              $res3 = $lider->modificar("UPDATE premios_planes_campana SET estatus = 1 WHERE id_plan = $plan and id_campana = $id_campana");
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


      if(!empty($_POST['plan']) && empty($_POST['validarData'])){

        $plan = ucwords(mb_strtolower($_POST['plan']));
        $tipo_inicial = $_POST['tipoInicial'];
        $tipo_premio = ['Inicial', 'Primer', 'Segundo'];
        if($tipo_inicial == "Productos"){
          $premio_inicial = $_POST['productosInicial'];
        }
        if($tipo_inicial == "Premios"){
          $premio_inicial = $_POST['premiosInicial'];
        }

        $tipo_primer = $_POST['tipoPrimer'];
        if($tipo_primer == "Productos"){
          $premio_primer = $_POST['productosPrimer'];
        }
        if($tipo_primer == "Premios"){
          $premio_primer = $_POST['premiosPrimer'];
        }

        $tipo_segundo = $_POST['tipoSegundo'];
        if($tipo_segundo == "Productos"){
          $premio_segundo = $_POST['productosSegundo'];
        }
        if($tipo_segundo == "Premios"){
          $premio_segundo = $_POST['premiosSegundo'];
        }
        // echo $plan;
        // echo "<br>====================================================================================================================================<br>";
        // for ($i=0; $i < Count($tipo_premio); $i++) { 
        //   $id_ppc = ($i+1);
        //   echo "id_ppc: ".$id_ppc." | "."id_plan: ".$plan." | "."id_campana: ".$id_campana." | "."tipo premio: ".$tipo_premio[$i]."<br><br>";
        //   $nume = 0;
        //   foreach ($premio_inicial as $data1) {
        //     $nume++;
        //     if($tipo_premio[$i] == "Inicial"){
        //       echo "id_tppc: ".$nume." | "."id_ppc: ".$id_ppc." | "."id_premio: ".$data1." | "."tipo_premio_producto: ".$tipo_inicial."<br>";    
        //     }
        //   }
        //   foreach ($premio_primer as $data2) {
        //     $nume++;
        //     if($tipo_premio[$i] == "Primer"){
        //       echo "id_tppc: ".$nume." | "."id_ppc: ".$id_ppc." | "."id_premio: ".$data2." | "."tipo_premio_producto: ".$tipo_primer."<br>";    
        //     }
        //   }
        //   foreach ($premio_segundo as $data3) {
        //     $nume++;
        //     if($tipo_premio[$i] == "Segundo"){
        //       echo "id_tppc: ".$nume." | "."id_ppc: ".$id_ppc." | "."id_premio: ".$data3." | "."tipo_premio_producto: ".$tipo_segundo."<br>";    
        //     }
        //   }
        //   echo "<br><br><br><br>";
        // }
        // echo "<br>====================================================================================================================================<br>";


        for ($i=0; $i < Count($tipo_premio); $i++) { 
                $query = "INSERT INTO premios_planes_campana (id_ppc, id_plan_campana, tipo_premio) VALUES (DEFAULT, $plan, '$tipo_premio[$i]')";
                $exec = $lider->registrar($query, "premios_planes_campana", "id_ppc");
                if($exec['ejecucion']==true){
                        $id_ppc = $exec['id'];
                        if($tipo_premio[$i] == "Inicial"){
                            foreach ($premio_inicial as $data1) {

                                  $query = "INSERT INTO tipos_premios_planes_campana (id_tppc, id_ppc, id_premio, tipo_premio_producto) VALUES (DEFAULT, $id_ppc, $data1, '$tipo_inicial')";
                                  $exec = $lider->registrar($query, "tipos_premios_planes_campana", "id_tppc");
                                  if($exec['ejecucion']==true){
                                    $response1 = "1"; 
                                  }else{
                                    $response1 = "2";
                                  }

                            }
                        }
                        if($tipo_premio[$i] == "Primer"){
                            foreach ($premio_primer as $data2) {
                               
                                  $query = "INSERT INTO tipos_premios_planes_campana (id_tppc, id_ppc, id_premio, tipo_premio_producto) VALUES (DEFAULT, $id_ppc, $data2, '$tipo_primer')";
                                  $exec = $lider->registrar($query, "tipos_premios_planes_campana", "id_tppc");
                                  if($exec['ejecucion']==true){
                                    $response2 = "1"; 
                                  }else{
                                    $response2 = "2";
                                  }

                            }
                        }
                        if($tipo_premio[$i] == "Segundo"){   
                            foreach ($premio_segundo as $data3) {

                                  $query = "INSERT INTO tipos_premios_planes_campana (id_tppc, id_ppc, id_premio, tipo_premio_producto) VALUES (DEFAULT, $id_ppc, $data3, '$tipo_segundo')";
                                  $exec = $lider->registrar($query, "tipos_premios_planes_campana", "id_tppc");
                                  if($exec['ejecucion']==true){
                                    $response3 = "1"; 
                                  }else{
                                    $response3 = "2";
                                  }

                            }
                        }

                }else{
                  $response = "2";
                }
        }
        if($response1=="1" && $response2=="1" && $response3=="1"){
          $response = "1";
          if(!empty($modulo) && !empty($accion)){
                    $fecha = date('Y-m-d');
                    $hora = date('H:i:a');
                    $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Premios De Campaña', 'Registrar', '{$fecha}', '{$hora}')";
                    $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
                  }
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
        // echo 'asd';
        $planesya = $lider->consultarQuery("SELECT DISTINCT premios_planes_campana.id_plan_campana FROM premios_planes_campana, planes_campana WHERE premios_planes_campana.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_campana = $id_campana and planes_campana.estatus = 1");

        // print_r($planesya);
        $planes=$lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas WHERE planes.id_plan = planes_campana.id_plan and campanas.id_campana = planes_campana.id_campana and campanas.estatus = 1 and planes.estatus = 1 and campanas.id_campana = $id_campana and planes_campana.estatus = 1");
        $productos=$lider->consultarQuery("SELECT * FROM productos WHERE estatus = 1 ORDER BY producto asc;");
        $premios=$lider->consultarQuery("SELECT * FROM premios WHERE estatus = 1 ORDER BY nombre_premio asc;");

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