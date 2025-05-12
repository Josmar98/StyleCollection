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
    // print_r($_POST);
    // foreach ($_POST as $key => $value) {
    //   echo "<br><br>";
    //   echo $key;
    //   echo "<br>";
    //   print_r($value);
    // }
    // die();
    $plan = ucwords(mb_strtolower($_POST['plan']));
    $tipos_premios_id = $_POST['tipos_premios_id'];
    $tipos_premios = $_POST['tipos_premios'];
    
    $cantidad_opciones = $_POST['cantidad_opciones'];
    $cantidad_elementos = $_POST['cantidad_elementos'];

    $name_opcion = $_POST['name_opcion'];
    $unidades = $_POST['unidades'];
    $inventarios = $_POST['inventarios'];
    $tipos_inventario = $_POST['tipos'];
    

    // foreach($inventarios as $inv){
    //   print_r($inv);
    //   echo "<br><br>";
    // }
    // echo "<br><br><br>";

    // die();
    // $id_pr = 555; /// BORRAR

    $errores = 0;
    foreach($tipos_premios_id as $key1){
      $y=0;
      $tipo_premioActual = $tipos_premios[$key1];
      // echo $key1." - ";
      // echo "<br><br>".$tipo_premioActual."<br>";
      // echo "<u>REGISTRAR PREMIOS DEL PLAN DE CAMPAÑA</u><br>";
      // echo "PLAN: ".$plan."<br>";
      // echo "tipo de Pago: ".$tipo_premioActual."<br>";
      // $ppc = 15512;
      $query = "INSERT INTO premios_planes_campana (id_ppc, id_plan_campana, tipo_premio) VALUES (DEFAULT, {$plan}, '{$tipo_premioActual}')";
      // echo "".$query."<br>"; // BORRAR
      // $execPPC=['ejecucion'=>true, 'id'=>$id_pr++]; // BORRAR
      $execPPC = $lider->registrar($query, "premios_planes_campana", "id_ppc");
      if($execPPC['ejecucion']==true){
        $id_ppc = $execPPC['id'];
        for ($x=0; $x < $cantidad_opciones[$key1]; $x++){
          // echo $cantidad_opciones[$key1]." OPCIONES DE ".$key1."<br>";
          // echo $cantidad_elementos[$key1][$x]." ELEMENTOS DE ".$key1."<br>";
          // echo "<br><u>REGISTRAR PREMIOS Y OBTENER ID</u><br>";
          // echo "Nombre: ".$name_opcion[$key1][$x]."<br>";
          $nombre_premio = ucwords(mb_strtolower($name_opcion[$key1][$x]));
          $query="INSERT INTO premios (id_premio, nombre_premio, precio_premio, descripcion_premio, estatus) VALUES (DEFAULT, '{$nombre_premio}', 0, '{$nombre_premio}', 1)";
          // echo $query."<br>";
          // $execPremio=['ejecucion'=>true, 'id'=>$id_pr++]; // BORRAR
          
          $execPremio = $lider->registrar($query, "premios", "id_premio");
          if($execPremio['ejecucion']==true){
            $id_premio = $execPremio['id'];
            $tipo_premio_producto = "Premios";
            // echo "<br><u>REGISTRAR TIPO DE PREMIOS DE PLANES DE CAMPAÑA</u><br>";
            // echo "id_premio_plan_campaña: ".$ppc."<br>";
            // echo "PREMIO: ".$id_premio."<br>";
            // echo "tipo de Pago: Premios<br>";
            $query = "INSERT INTO tipos_premios_planes_campana (id_tppc, id_ppc, id_premio, tipo_premio_producto) VALUES (DEFAULT, {$id_ppc}, {$id_premio}, '{$tipo_premio_producto}')";
            // echo $query."<br>"; /// BORRAR
            $execTPPC = $lider->registrar($query, "tipos_premios_planes_campana", "id_tppc");
            if($execTPPC['ejecucion']==true){
            }else{
              $errores++;
            }

            for ($z=0; $z < $cantidad_elementos[$key1][$x]; $z++){
              $alfa = $z+$y;
              $id_inventario = $inventarios[$key1][$alfa];
              $posMercancia = strpos($id_inventario,'m');
              if(strlen($posMercancia)==0){
                $id_element = $id_inventario;
              }else{
                $id_element = preg_replace("/[^0-9]/", "", $id_inventario);
              }
              
              $query = "INSERT INTO premios_inventario (id_premio_inventario, id_premio, id_inventario, unidades_inventario, tipo_inventario, estatus) VALUES (DEFAULT, {$id_premio}, {$id_element}, {$unidades[$key1][$alfa]}, '{$tipos_inventario[$key1][$alfa]}', 1)";
              // echo " | Z: ".$z." | Y: ".$y." | ALFA: ".$alfa."<br><br>";
              // echo "<br><u>REGISTRAR PREMIOS DE INVENTARIO</u><br>";
              // echo "Id PREMIO: ".$id_premio."<br>";
              // echo "Id_Inventario: ".$inventarios[$key1][$alfa]."<br>";
              // echo "Cantidad: ".$unidades[$key1][$alfa]."<br>";
              // echo "Tipo de Inventario: ".$tipos_inventario[$key1][$alfa]."<br>";
              // echo $query."<br>";
              $execPI = $lider->registrar($query, "premios_inventario", "id_premio_inventario");
              if($execPI['ejecucion']==true){
              }else{
                $errores++;
              }
            }
            // echo "<br>";
            
          }else{
            $errores++;
          }
          $y+=$limitesElementos;
        }
        // echo "<br>";

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
      $response = "2";    
    }
    // die();
    // $success1 = false;
    // $success2 = false;
    // $errorPPC = 0;
    // $errorTPPC = 0;
    // foreach ($tipos_premios_id as $key1) {
    //   $tipo_premioActual = $tipos_premios[$key1];
    //   $query = "INSERT INTO premios_planes_campana (id_ppc, id_plan_campana, tipo_premio) VALUES (DEFAULT, {$plan}, '{$tipo_premioActual}')";
    //   $exec = $lider->registrar($query, "premios_planes_campana", "id_ppc");
    //   if($exec['ejecucion']==true){
    //     $id_ppc = $exec['id'];
    //     $tipo_pp = $tipos_premios_productos[$key1];
    //     $idpp = mb_strtolower($tipo_pp)."_".$key1;
    //     $premiosActual = $_POST[$idpp];
    //     foreach ($premiosActual as $id_premio) {
    //       $query2 = "INSERT INTO tipos_premios_planes_campana (id_tppc, id_ppc, id_premio, tipo_premio_producto) VALUES (DEFAULT, $id_ppc, $id_premio, '{$tipo_pp}')";
    //       $exec = $lider->registrar($query2, "tipos_premios_planes_campana", "id_tppc");
    //       if($exec['ejecucion']==true){
    //         $response1 = "1"; 
    //       }else{
    //         $response1 = "2";
    //         $errorTPPC++;
    //       }
    //     }
    //   } else {
    //     $response = "2";
    //     $errorPPC++;
    //   }
    // }
    // $success1 = $errorPPC==0 ? true : false; 
    // $success2 = $errorTPPC==0 ? true : false; 

    // if($success1==true && $success2==true){
    //   $response = "1";
    //   if(!empty($modulo) && !empty($accion)){
    //     $fecha = date('Y-m-d');
    //     $hora = date('H:i:a');
    //     $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Premios De Campaña', 'Registrar', '{$fecha}', '{$hora}')";
    //     $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
    //   }
    // }else{
    //   $response = "2";    
    // }


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
    
    $planesss=[];
    foreach($planes as $key){
      if(!empty($key['id_plan'])){
        $planesss[count($planesss)]=$key;
      }
    }
    // $planes_de_campana = $lider->consultarQuery("SELECT * FROM planes_campana WHERE estatus = 1 and id_campana={$id_campana} and id_despacho={$id_despacho} ORDER BY id_plan_campana ASC;");
    // if(count($planes_de_campana)>1){
    //   $id_plan_campana = $planes_de_campana[0]['id_plan_campana'];
    //   if ($despacho['opcion_inicial']=="Y"){
    //     $tppcIns = $lider->consultarQuery("SELECT * FROM premios_planes_campana, tipos_premios_planes_campana, premios WHERE premios.id_premio=tipos_premios_planes_campana.id_premio and premios_planes_campana.id_plan_campana = {$id_plan_campana} and tipos_premios_planes_campana.id_ppc = premios_planes_campana.id_ppc and premios_planes_campana.tipo_premio='Inicial'");
    //     // print_r($tppcIns);
    //     // foreach($tppcIns as $tc){ if(!empty($tc['id_premio'])){
    //       // echo "<br><br><br>";
    //     // } }
    //   }
    //   $tppcs = $lider->consultarQuery("SELECT * FROM premios_planes_campana, tipos_premios_planes_campana, premios WHERE premios.id_premio=tipos_premios_planes_campana.id_premio and premios_planes_campana.id_plan_campana = {$id_plan_campana} and tipos_premios_planes_campana.id_ppc = premios_planes_campana.id_ppc and premios_planes_campana.tipo_premio<>'Inicial'");
    //   print_r($tppcs);
    //   // foreach($tppcs as $tc){ if(!empty($tc['id_premio'])){
    //   //   // print_r($tc);
    //   //   // echo "<br><br><br>";
    //   // } }
    // }

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