<?php 
$amPlanesCamp = 0;
$amPlanesCampR = 0;
$amPlanesCampC = 0;
$amPlanesCampE = 0;
$amPlanesCampB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Planes De Campaña"){
      $amPlanesCamp = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amPlanesCampR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amPlanesCampC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amPlanesCampE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amPlanesCampB = 1;
      }
    }
  }
}
if($amPlanesCampE == 1){

        
  $id_campana = $_GET['campaing'];
  $numero_campana = $_GET['n'];
  $anio_campana = $_GET['y'];

  $id_despacho = $_GET['dpid'];
  $num_despacho = $_GET['dp'];
  $menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

  $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and despachos.id_campana = {$id_campana} and despachos.id_despacho = {$id_despacho} and despachos.estatus = 1 and campanas.estatus = 1");
    //$pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.estatus = 1 and pagos_despachos.estatus = 1");
  $despacho = $despachos[0];
  $cantidadPagosDespachosFild = [];
  for ($i=0; $i < count($cantidadPagosDespachos); $i++) {
    $key = $cantidadPagosDespachos[$i];
    if($key['cantidad'] <= $despacho['cantidad_pagos']){
      $cantidadPagosDespachosFild[$i] = $key;
    }
  }

  $planess=$lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas WHERE planes.id_plan = planes_campana.id_plan and campanas.id_campana = planes_campana.id_campana and campanas.id_campana = $id_campana and campanas.estatus = 1 and planes.estatus = 1 and planes_campana.id_despacho = {$id_despacho}");

  if(!empty($_POST['planes']) ){
    // print_r($_POST);

    $planes = $_POST['planes'];
    $color_plan = $_POST['color_plan'];
    $descuento_directo = $_POST['descuento_directo'];
    // $descuento_primer = $_POST['descuento_primer'];
    // $descuento_segundo = $_POST['descuento_segundo'];
    $descuentos = $_POST['descuentos'];
    
    $query = "UPDATE planes_campana SET id_campana=$id_campana, id_plan=$planes, color_plan = '{$color_plan}', descuento_directo=$descuento_directo WHERE id_plan_campana=$id";
    $exec = $lider->modificar($query);
    if($exec['ejecucion']==true ){
      $response = "1";
      $exec = $lider->eliminar("DELETE FROM pagos_planes_campana WHERE id_plan_campana = $id");
      if($exec['ejecucion'] == true){
        $errorPD=0;
        foreach ($cantidadPagosDespachosFild as $keys) {
            $tipo_pago_plan_campana = $keys['name'];
            $descuento_pago_plan_campana = $descuentos[$keys['id']];
            $queryPD = "INSERT INTO pagos_planes_campana (id_pago_plan_campana, id_plan_campana, id_campana, id_despacho, tipo_pago_plan_campana, descuento_pago_plan_campana, estatus) VALUES (DEFAULT, {$id}, {$id_campana}, {$id_despacho}, '{$tipo_pago_plan_campana}', '{$descuento_pago_plan_campana}', 1)";
            $exec = $lider->registrar($queryPD, "pagos_planes_campana", "id_pago_plan_campana");
            if($exec['ejecucion']!=true ){
              $errorPD++;
            }
        }
        if($errorPD==0){
          $response = "1";
          if(!empty($modulo) && !empty($accion)){
            $fecha = date('Y-m-d');
            $hora = date('H:i:a');
            $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Planes De Campaña', 'Editar', '{$fecha}', '{$hora}')";
            $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
          }
        }else{
          $response = "2";
        }
      }else{
        $response = "2";
      }
    }else{
      $response = "2";
    }
    
    $planes_campana = $lider->consultarQuery("SELECT * FROM planes, planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana=$id and planes_campana.estatus = 1 and planes_campana.id_despacho = {$id_despacho}");
    $pagos_planes_campana=$lider->consultarQuery("SELECT * FROM planes_campana, pagos_planes_campana WHERE planes_campana.id_plan_campana = pagos_planes_campana.id_plan_campana and planes_campana.id_campana = pagos_planes_campana.id_campana and planes_campana.id_despacho = pagos_planes_campana.id_despacho and pagos_planes_campana.id_campana = {$id_campana} and pagos_planes_campana.id_despacho = {$id_despacho} and planes_campana.estatus = 1 and pagos_planes_campana.estatus = 1");

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

    // $planes=$lider->consultar("planes");
    $planes_campana = $lider->consultarQuery("SELECT * FROM planes, planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana=$id and planes_campana.estatus = 1 and planes_campana.id_despacho = {$id_despacho}");
    $pagos_planes_campana=$lider->consultarQuery("SELECT * FROM planes_campana, pagos_planes_campana WHERE planes_campana.id_plan_campana = pagos_planes_campana.id_plan_campana and planes_campana.id_campana = pagos_planes_campana.id_campana and planes_campana.id_despacho = pagos_planes_campana.id_despacho and pagos_planes_campana.id_campana = {$id_campana} and pagos_planes_campana.id_despacho = {$id_despacho} and planes_campana.estatus = 1 and pagos_planes_campana.estatus = 1");

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