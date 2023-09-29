<?php 
$amReportes = 0;
$amReportesC = 0;
foreach ($accesos as $access) {
if(!empty($access['id_acceso'])){
  if($access['nombre_modulo'] == "Reportes"){
    $amReportes = 1;
    if($access['nombre_permiso'] == "Ver"){
      $amReportesC = 1;
    }
  }
}
}
if($amReportesC == 1){

    if(!empty($_POST['selectedPedido'])){
      $id_despacho = $_POST['selectedPedido'];
      $pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho");
      $id_campana = $pedidosClientes[50]['id_campana'];
      $premioscol = $lider->consultarQuery("SELECT * FROM pedidos, tipos_colecciones, premio_coleccion, tipos_premios_planes_campana, premios, planes_campana, planes WHERE pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");
      $premios = $lider->consultarQuery("SELECT DISTINCT planes_campana.id_plan_campana, premios.id_premio, nombre_premio FROM pedidos, tipos_colecciones, premio_coleccion, tipos_premios_planes_campana, premios, planes_campana, planes WHERE pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho}");

      $planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho}");
      // $premios = $lider->consultarQuery("SELECT DISTINCT premios.id_premio, premios.nombre_premio FROM premios, tipos_premios_planes_campana, premios_planes_campana, planes_campana, campanas, despachos WHERE despachos.id_despacho = {$id_despacho} and premios.estatus = 1 and despachos.id_campana = campanas.id_campana and campanas.id_campana = planes_campana.id_campana and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.id_premio = premios.id_premio");
      
      $despachos = $lider->consultarQuery("SELECT * FROM campanas, despachos WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = {$id_despacho}");
    
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

}else{
  require_once 'public/views/error404.php';
}
?>