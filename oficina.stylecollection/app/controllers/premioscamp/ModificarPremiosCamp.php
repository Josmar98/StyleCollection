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
if($amPremioscampE == 1){
  $limitesOpciones = 10;
  $limitesElementos = 10;
  $limiteMinimoOpciones=1;
  $adicionalesSoloPagoDeSeleccion = true;


  $id_campana = $_GET['campaing'];
  $numero_campana = $_GET['n'];
  $anio_campana = $_GET['y'];

  $id_despacho = $_GET['dpid'];
  $num_despacho = $_GET['dp'];
  $menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

  $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and campanas.estatus = 1");
  $pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and pagos_despachos.estatus = 1");
  $despacho = $despachos[0];
  $cantidadPagosDespachosFild = [];
  for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
    $key = $cantidadPagosDespachos[$i];
    if($key['cantidad'] <= $despacho['cantidad_pagos']){
      $cantidadPagosDespachosFild[$i] = $key;
    }
  }

  if(!empty($_POST['validarData'])){
    $plan = ucwords(mb_strtolower($_POST['plan']));
    $query = "SELECT * FROM premios_planes_campana WHERE id_plan_campana = $plan";
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

  if(!empty($_POST['plan']) && empty($_POST['validarData'])){
    // print_r($_POST);
    // foreach ($_POST as $key => $value) {
    //   echo "<br><br>".$key."<br>";
    //   print_r($value);
    // }
    $plan = ucwords(mb_strtolower($_POST['plan']));
    $tipos_premios_id = $_POST['tipos_premios_id'];
    $tipos_premios = $_POST['tipos_premios'];
    
    $cantidad_opciones = $_POST['cantidad_opciones'];
    $cantidad_elementos = $_POST['cantidad_elementos'];

    $name_opcion = $_POST['name_opcion'];
    $unidadesAx = $_POST['unidades'];
    $inventariosAx = $_POST['inventarios'];
    $tipos_inventario = $_POST['tipos'];
    $id_opcions = $_POST['id_opcions'];

    $unidades=[];
    $inventarios=[];
    foreach($tipos_premios_id as $key1){
      $unidades[$key1] = [];
      $inventarios[$key1] = [];
      foreach($unidadesAx[$key1] as $key2u){
        if($key2u!=""){
          $unidades[$key1][count($unidades[$key1])]=$key2u;
        }
      }
      foreach($inventariosAx[$key1] as $key2i){
        if($key2i!=""){
          $inventarios[$key1][count($inventarios[$key1])]=$key2i;
        }
      }
    }
    
    // echo "Unidades: ";
    // print_r($unidades);
    // echo "<br><br>";
    // echo "Inventarios: ";
    // print_r($inventarios);
    // echo "<br><br>";
    
    // die();
    $errores = 0;
    foreach($tipos_premios_id as $key1){
      $tipo_premioActual = $tipos_premios[$key1];
      $buscar = $lider->consultarQuery("SELECT * FROM premios_planes_campana WHERE id_plan_campana={$plan} and tipo_premio='{$tipo_premioActual}' ORDER BY id_ppc DESC;");
      // print_r($buscar);
      if(count($buscar)>1){
        $id_ppcB = $buscar[0]['id_ppc'];
        $borrado = $lider->eliminar("DELETE FROM premios_planes_campana WHERE id_ppc={$id_ppcB}");
        // echo "BORRAR PREMIOS de los PLANES DE CAMPAÑA <br>";
        // print_r($borrado);
        // echo "<br><br><br>";
        if($borrado['ejecucion']==true){
          $query = "INSERT INTO premios_planes_campana (id_ppc, id_plan_campana, tipo_premio) VALUES (DEFAULT, {$plan}, '{$tipo_premioActual}')";
          $execPPC = $lider->registrar($query, "premios_planes_campana", "id_ppc");
          // echo "Registrar PREMIOS de los PLANES DE CAMPAÑA <br>";
          // print_r($execPPC);
          // echo "<br><br><br>";
          if($execPPC['ejecucion']==true){
            $id_ppc = $execPPC['id'];
            $y = 0;
            for ($x=0; $x < $cantidad_opciones[$key1]; $x++){
              // echo "<br>ID_PREMIO: ".$id_opcions[$key1][$x];
              $id_premioB = $id_opcions[$key1][$x];
              $borrado = $lider->eliminar("DELETE FROM premios WHERE id_premio={$id_premioB}");
              $borradoxd = $lider->eliminar("DELETE FROM premios_inventario WHERE id_premio={$id_premioB}");
              // echo "BORRAR PREMIOS <br>";
              // print_r($borrado);
              // echo "<br><br><br>";
              if($borrado['ejecucion']==true){
                $nombre_premio = ucwords(mb_strtolower($name_opcion[$key1][$x]));
                $query="INSERT INTO premios (id_premio, nombre_premio, precio_premio, descripcion_premio, estatus) VALUES (DEFAULT, '{$nombre_premio}', 0, '{$nombre_premio}', 1)";
                // echo "Registrar PREMIOS <br>";
                // print_r($execPremio);
                // echo "<br><br><br>";
                $execPremio = $lider->registrar($query, "premios", "id_premio");
                if($execPremio['ejecucion']==true){
                  $id_premio = $execPremio['id'];
                  $borrado = $lider->eliminar("DELETE FROM tipos_premios_planes_campana WHERE id_ppc={$id_ppcB}");
                  // echo "BORRAR PREMIOS de los TIPOS DE LOS PLANES DE CAMPAÑA <br>";
                  // print_r($borrado);
                  // echo "<br><br><br>";
                  if($borrado['ejecucion']==true){
                    $tipo_premio_producto = "Premios";
                    $query = "INSERT INTO tipos_premios_planes_campana (id_tppc, id_ppc, id_premio, tipo_premio_producto) VALUES (DEFAULT, {$id_ppc}, {$id_premio}, '{$tipo_premio_producto}')";
                    $execTPPC = $lider->registrar($query, "tipos_premios_planes_campana", "id_tppc");
                    // echo "Registrar PREMIOS de los TIPOS DE LOS PLANES DE CAMPAÑA <br>";
                    // print_r($execTPPC);
                    // echo "<br><br><br>";
                    if($execTPPC['ejecucion']==true){
                    }else{
                      $errores++;
                    }
                    $borrado = $lider->eliminar("DELETE FROM premios_inventario WHERE id_premio={$id_premioB}");
                    // echo "BORRAR PREMIOS de INVENTARIO <br>";
                    // print_r($borrado);
                    // echo "<br><br><br>";
                    if($borrado['ejecucion']==true){
                      for ($z=0; $z < $cantidad_elementos[$key1][$x]; $z++){
                        // echo "<br><br>";
                        // echo "Y: ".$y;
                        // print_r($inventarios[$key1]);
                        // echo "<br>";
                        $id_inventario = $inventarios[$key1][$y];
                        // echo "id_inventario: ".$id_inventario."<br>";
                        $posMercancia = strpos($id_inventario,'m');
                        if(strlen($posMercancia)==0){
                          $id_element = $id_inventario;
                        }else{
                          $id_element = preg_replace("/[^0-9]/", "", $id_inventario);
                        }
                        $query = "INSERT INTO premios_inventario (id_premio_inventario, id_premio, id_inventario, unidades_inventario, tipo_inventario, estatus) VALUES (DEFAULT, {$id_premio}, {$id_element}, {$unidades[$key1][$z]}, '{$tipos_inventario[$key1][$z]}', 1)";
                        // echo $query."<br>";
                        $execPI = $lider->registrar($query, "premios_inventario", "id_premio_inventario");
                        // echo "Registrar PREMIOS de INVENTARIO <br>";
                        // print_r($execPI);
                        // echo "<br><br><br>";
                        if($execPI['ejecucion']==true){
                        }else{
                          $errores++;
                        }
                        $y++;
                      }
                    }else{
                      $errores++;
                    }
                  }else{
                    $errores++;
                  }
                }else{
                  $errores++;
                }
              }else{
                $errores++;
              }
      
              // $buscar = $lider->consultarQuery("SELECT * FROM premios WHERE id_premio={$id_premioB} and estatus=1 ORDER BY id_premio DESC;");
              // // $buscar = $lider->consultarQuery("SELECT * FROM premios WHERE nombre_premio='{$nombre_premio}' and descripcion_premio='{$nombre_premio}' and estatus=1 ORDER BY id_premio DESC;");
              // if(count($buscar)>1){
              //   $id_premioB = $buscar[0]['id_premio'];
              //   echo $id_premioB."<br>";
              // }else{
              //   $errores++;
              // }
            }
            
          }else{
            $errores++;
          }
        }else{
          $errores++;
        }
      }else{
        $errores++;
      }
    }

    // die();
    if($errores==0){
      $response = "1";
      if(!empty($modulo) && !empty($accion)){
        $fecha = date('Y-m-d');
        $hora = date('H:i:a');
        $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Premios De Campaña', 'Registrar', '{$fecha}', '{$hora}')";
        $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
      }
    }else{
      echo "errores: ".$errores;
      $response = "2";    
    }


    $planesya = $lider->consultarQuery("SELECT DISTINCT premios_planes_campana.id_plan_campana FROM premios_planes_campana, planes_campana WHERE premios_planes_campana.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_campana = $id_campana and planes_campana.estatus = 1 and planes_campana.id_despacho = {$id_despacho}");

    $planes=$lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas WHERE planes.id_plan = planes_campana.id_plan and campanas.id_campana = planes_campana.id_campana and campanas.estatus = 1 and planes.estatus = 1 and campanas.id_campana = $id_campana and planes_campana.estatus = 1 and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
    
    $productos=$lider->consultarQuery("SELECT * FROM productos WHERE estatus=1 ORDER BY producto asc;");
    // $premios=$lider->consultarQuery("SELECT * FROM premios WHERE estatus=1 ORDER BY nombre_premio asc;");
    $mercancia=$lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1 ORDER BY mercancia asc;");



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
    
    $planesya = $lider->consultarQuery("SELECT DISTINCT premios_planes_campana.id_plan_campana FROM premios_planes_campana, planes_campana WHERE premios_planes_campana.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_campana = $id_campana and planes_campana.estatus = 1 and planes_campana.id_despacho = {$id_despacho}");

    $planes=$lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas WHERE planes.id_plan = planes_campana.id_plan and campanas.id_campana = planes_campana.id_campana and campanas.estatus = 1 and planes.estatus = 1 and campanas.id_campana = $id_campana and planes_campana.estatus = 1 and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
    
    $productos=$lider->consultarQuery("SELECT * FROM productos WHERE estatus=1 ORDER BY producto asc;");
    // $premios=$lider->consultarQuery("SELECT * FROM premios WHERE estatus=1 ORDER BY nombre_premio asc;");
    $mercancia=$lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1 ORDER BY mercancia asc;");


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