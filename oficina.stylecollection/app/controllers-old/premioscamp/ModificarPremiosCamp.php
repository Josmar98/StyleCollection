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

  if(!empty($_GET['plan'])){
    $plan = $_GET['plan'];
  }


  if(!empty($_POST['validarData'])){
    $plan = $_POST['plan'];
    // print_r($plan);
    $query = "SELECT * FROM premios_planes_campana WHERE id_plan_campana = $plan";
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

  if(!empty($_POST['plan']) && empty($_POST['validarData'])){
    
    $plan = ucwords(mb_strtolower($_POST['plan']));
    $tipos_premios_id = $_POST['tipos_premios_id'];
    $tipos_premios = $_POST['tipos_premios'];
    $tipos_premios_productos = $_POST['tipos'];

    // print_r($_POST);
    // echo "<br><br>";
    // $ppc = $lider->consultarQuery("SELECT * FROM premios_planes_campana WHERE id_plan_campana = $plan");
    // $nnIndex2 = 531;
    // foreach ($tipos_premios_id as $key1) {
    //   foreach ($ppc as $id_ppc) { if(!empty($id_ppc['id_ppc']) && !empty($id_ppc['id_plan_campana'])){
    //     if($plan==$id_ppc['id_plan_campana'] && $tipos_premios[$key1]==$id_ppc['tipo_premio']){

    //       $tipo_pp = $tipos_premios_productos[$key1];
    //       $idpp = mb_strtolower($tipo_pp)."_".$key1;

    //       echo "==================================<br>";
    //       echo "ID_PPC: ".$id_ppc['id_ppc']." | ";
    //       echo "Plan: ".$plan." | ";
    //       echo "Tipo Premio: ".$tipos_premios[$key1]." | ";
    //       echo "<br>==================================<br>";
    //       foreach ($_POST[$idpp] as $id_premio) {
    //         echo "ID TPPC: ".$nnIndex2." | ";
    //         echo "ID PPC: ".$id_ppc['id_ppc']." | ";
    //         echo "Id Premios: ".$id_premio." | ";
    //         echo "Tipo Premio Producto: ".$tipo_pp." | <br>";
    //         $nnIndex2++;
    //       }
    //       echo "<br>==================================<br>";
    //     }
    //   } }
    // }

    $success1 = false;
    $success2 = false;
    $errorPPC = 0;
    $errorTPPC = 0;
    $ppc = $lider->consultarQuery("SELECT * FROM premios_planes_campana WHERE id_plan_campana = $plan");
    foreach ($tipos_premios_id as $key1) {
      foreach ($ppc as $id_ppcAct) { if(!empty($id_ppcAct['id_ppc']) && !empty($id_ppcAct['id_plan_campana'])){
        if($plan==$id_ppcAct['id_plan_campana'] && $tipos_premios[$key1]==$id_ppcAct['tipo_premio']){
          $tipo_premioActual = $tipos_premios[$key1];
          $id_ppc = $id_ppcAct['id_ppc'];
          $exec = $lider->eliminar("DELETE FROM tipos_premios_planes_campana WHERE id_ppc = ".$id_ppc);
          if($exec['ejecucion']==true){
            $tipo_pp = $tipos_premios_productos[$key1];
            $idpp = mb_strtolower($tipo_pp)."_".$key1;
            $premiosActual = $_POST[$idpp];
            foreach ($premiosActual as $id_premio) {
              $query2 = "INSERT INTO tipos_premios_planes_campana (id_tppc, id_ppc, id_premio, tipo_premio_producto) VALUES (DEFAULT, $id_ppc, $id_premio, '{$tipo_pp}')";
              $exec = $lider->registrar($query2, "tipos_premios_planes_campana", "id_tppc");
              if($exec['ejecucion']==true){
                $response1 = "1"; 
              }else{
                $response1 = "2";
                $errorTPPC++;
              }
            }
          }else{
            $response = "2";
            $errorPPC++;
          }
        }
      } }
    }
    $success1 = $errorPPC==0 ? true : false; 
    $success2 = $errorTPPC==0 ? true : false; 

    if($success1==true && $success2==true){
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
    if(!empty($_GET['plan'])){
      $plan = $_GET['plan'];
      
      // $planesya = $lider->consultarQuery("SELECT DISTINCT premios_planes_campana.id_plan_campana FROM premios_planes_campana, planes_campana WHERE premios_planes_campana.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_campana = $id_campana and planes_campana.estatus = 1 and planes_campana.id_despacho = {$id_despacho}");

      $planes=$lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas WHERE planes.id_plan = planes_campana.id_plan and campanas.id_campana = planes_campana.id_campana and campanas.estatus = 1 and planes.estatus = 1 and campanas.id_campana = $id_campana and planes_campana.estatus = 1 and planes_campana.id_despacho = {$id_despacho} and planes.id_plan = {$plan} ORDER BY planes.id_plan ASC");

      $tipos_premios = $lider->consultarQuery("SELECT DISTINCT nombre_plan, tipo_premio, tipo_premio_producto FROM planes, planes_campana, premios_planes_campana, tipos_premios_planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_campana = $id_campana and planes.id_plan = $plan and planes_campana.id_despacho = {$id_despacho}");
      
      $tpremios = $lider->consultarQuery("SELECT * FROM planes, planes_campana, premios_planes_campana, tipos_premios_planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_campana = $id_campana and planes.id_plan = $plan and planes_campana.id_despacho = {$id_despacho}");

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
    }else{
      require_once 'public/views/error404.php';
    }

  }
}else{
  require_once 'public/views/error404.php';
}


?>