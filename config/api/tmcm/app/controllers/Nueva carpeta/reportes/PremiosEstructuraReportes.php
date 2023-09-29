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

    if(!empty($_GET['P'])){
        $id_despacho = $_GET['P'];
        $id_cliente = $_GET['L'];
        $clientee = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente = {$id_cliente}");
        $cliente1 = $clientee[0];
        $_SESSION['ids_general_estructura'] = [];
        $_SESSION['ids_general_estructura'][] = $cliente1;
        consultarEstructura($id_cliente, $lider);
        $nuevosClientes = $_SESSION['ids_general_estructura'];

      $pedidosClientes = $lider->consultarQuery("SELECT * FROM pedidos, despachos, campanas WHERE pedidos.id_despacho = $id_despacho and campanas.id_campana = despachos.id_despacho and despachos.id_despacho = pedidos.id_despacho");
        $planesCol = $lider->consultarQuery("SELECT * FROM planes, planes_campana, tipos_colecciones, pedidos WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = tipos_colecciones.id_plan_campana and pedidos.id_pedido = tipos_colecciones.id_pedido and pedidos.id_despacho = {$id_despacho}");
        $premioscol = $lider->consultarQuery("SELECT * FROM premio_coleccion, tipos_premios_planes_campana, premios, tipos_colecciones, planes_campana, planes, pedidos WHERE tipos_colecciones.id_tipo_coleccion = premio_coleccion.id_tipo_coleccion and pedidos.id_pedido = tipos_colecciones.id_pedido and tipos_premios_planes_campana.id_tppc = premio_coleccion.id_tppc and tipos_premios_planes_campana.id_premio = premios.id_premio and tipos_colecciones.id_plan_campana = planes_campana.id_plan_campana and planes_campana.id_plan = planes.id_plan and pedidos.id_despacho = {$id_despacho}");
        $premios_planes = $lider->consultarQuery("SELECT DISTINCT * FROM productos, tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE tipos_premios_planes_campana.id_premio = productos.id_producto and tipos_premios_planes_campana.tipo_premio_producto = 'Productos' and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes.nombre_plan = 'Standard' and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho");
    }

    $clientess = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1");
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

function consultarEstructura($id_c, $lider){
  $lideres = $lider->consultarQuery("SELECT * FROM clientes WHERE id_lider = $id_c");
  if(Count($lideres)>1){
    foreach ($lideres as $lid) {
      if(!empty($lid['id_cliente'])){
        $_SESSION['ids_general_estructura'][] = $lid;
        consultarEstructura($lid['id_cliente'], $lider);
      }
    }
  }
}

?>