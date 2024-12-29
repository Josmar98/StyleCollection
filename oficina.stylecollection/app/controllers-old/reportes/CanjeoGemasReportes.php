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
  $lideres = $lider->consultarQuery("SELECT clientes.id_cliente, clientes.cedula, clientes.primer_nombre, clientes.primer_apellido FROM clientes, usuarios WHERE clientes.id_cliente = usuarios.id_cliente and clientes.estatus = 1 and usuarios.estatus = 1 ORDER BY clientes.id_cliente ASC;");
  $newData = [];
  $index = 0;
  foreach ($lideres as $lids) {
    if(!empty($lids['id_cliente'])){
      $id_perso = $lids['id_cliente'];
     
          $historial1 = $lider->consultarQuery("SELECT * FROM canjeos, catalogos WHERE catalogos.id_catalogo = canjeos.id_catalogo and id_cliente = {$id_perso} and canjeos.estatus = 1");
          // $historial2 = $lider->consultarQuery("SELECT * FROM configgemas, gemas, pedidos, despachos, campanas WHERE pedidos.id_despacho = despachos.id_despacho and campanas.id_campana = despachos.id_campana and  pedidos.id_pedido = gemas.id_pedido and configgemas.id_configgema = gemas.id_configgema and gemas.estatus = 1 and configgemas.nombreconfiggema = 'Por Colecciones De Factura Directa' and gemas.id_cliente = {$id_perso}");
          // $historial3 = $lider->consultarQuery("SELECT * FROM configgemas, gemas, campanas, despachos, pedidos WHERE pedidos.id_despacho = despachos.id_despacho and pedidos.id_pedido = gemas.id_pedido and campanas.id_campana and despachos.id_campana and campanas.id_campana = gemas.id_campana and configgemas.id_configgema = gemas.id_configgema and gemas.estatus = 1 and configgemas.nombreconfiggema != 'Por Colecciones De Factura Directa' and gemas.id_cliente = {$id_perso}");
          // $historial4 = $lider->consultarQuery("SELECT * FROM nombramientos, liderazgos, campanas WHERE campanas.id_campana = nombramientos.id_campana and nombramientos.id_liderazgo = liderazgos.id_liderazgo and nombramientos.estatus = 1 and nombramientos.id_cliente = {$id_perso}");
          // $historial5 = $lider->consultarQuery("SELECT * FROM campanas, despachos, pedidos, descuentos_gemas WHERE campanas.id_campana = despachos.id_campana and despachos.id_despacho = pedidos.id_despacho and pedidos.id_pedido = descuentos_gemas.id_pedido and descuentos_gemas.id_cliente = {$id_perso}");
          // $historial6 = $lider->consultarQuery("SELECT * FROM campanas, despachos, canjeos_gemas, clientes WHERE campanas.id_campana = despachos.id_campana and campanas.id_campana = canjeos_gemas.id_campana and despachos.id_despacho = canjeos_gemas.id_despacho and canjeos_gemas.id_cliente = clientes.id_cliente and canjeos_gemas.id_cliente = {$id_perso}");
          // $historial7 = $lider->consultarQuery("SELECT * FROM clientes, obsequiogemas, campanas, despachos WHERE clientes.id_cliente = obsequiogemas.id_cliente and campanas.id_campana = obsequiogemas.id_campana and despachos.id_campana = campanas.id_campana and despachos.id_despacho = obsequiogemas.id_despacho and obsequiogemas.id_cliente = {$id_perso} and clientes.estatus = 1 and obsequiogemas.estatus = 1");

      $historialx = [];
      $num = 0;

      // if($id_perso == 101){
      
      if(!empty($historial1)){
        foreach ($historial1 as $data) {
          if(!empty($data['id_canjeo'])){
            $historialx[$num] = $data;
            $num++;
          }
        }
      }
      // if(!empty($historial2)){
      //   foreach ($historial2 as $data) {
      //     if(!empty($data['id_gema'])){
      //       $historialx[$num] = $data;
      //       $num++;
      //     }
      //   }
      // }
      // if(!empty($historial3)){
      //   foreach ($historial3 as $data) {
      //     if(!empty($data['id_gema'])){
      //       $historialx[$num] = $data;
      //       $num++;
      //     }
      //   }
      // }
      // if(!empty($historial4)){
      //   foreach ($historial4 as $data) {
      //     if(!empty($data['id_nombramiento'])){
      //       $historialx[$num] = $data;
      //       $num++;
      //     }
      //   }
      // }
      // if(!empty($historial5)){
      //   foreach ($historial5 as $data) {
      //     if(!empty($data['id_descuento_gema'])){
      //       $historialx[$num] = $data;
      //       $cantidad_gemas = $data['cantidad_descuento_gemas'];
      //       $historialx[$num]['cantidad_gemas'] = $cantidad_gemas;
      //       $num++;
      //     }
      //   }
      // }
      // if(!empty($historial6)){
      //   foreach ($historial6 as $data) {
      //     if(!empty($data['id_canjeo_gema'])){
      //       $historialx[$num] = $data;
      //       $cantidad_gemas = $data['cantidad'];
      //       $historialx[$num]['cantidad_gemas'] = $cantidad_gemas;
      //       $num++;
      //     }
      //   }
      // }
      // if(!empty($historial7)){
      //   foreach ($historial7 as $data) {
      //     // print_r($data);
      //     if(!empty($data['id_obsequio_gema'])){
      //       $historialx[$num] = $data;
      //       $num++;
      //     }
      //   }
      // }

      $newData[$index]['id_cliente'] = $lids['id_cliente'];
      $newData[$index]['cedula'] = $lids['cedula'];
      $newData[$index]['primer_nombre'] = $lids['primer_nombre'];
      $newData[$index]['primer_apellido'] = $lids['primer_apellido'];
      $newData[$index]['canjeadas'] = 0;
      $newData[$index]['asignadas'] = 0;
      $newData[$index]['noasignadas'] = 0;
      // echo "Historial 2 :".count($historial2)."<br>";
      // echo "Historial 3 :".count($historial3)."<br>";
      // echo "Historial 4 :".count($historial4)."<br>";
      // echo "Historial 5 :".count($historial5)."<br>";
      // echo "Historial 6 :".count($historial6)."<br>";
      // echo "Historial 7 :".count($historial7)."<br>";
      // echo "Registros: ";
      // echo count($historialx);
      // echo "<br>";
      foreach($historialx as $data){
        $gemascanjeadas = 0;
        $gemasAsignadas = 0;
        $gemasNoAsignadas = 0;
        if(!empty($data['fecha_canjeo'])){
          $razon = '-';
          $concepto = "Por Canjeo de premio";
          $gemas = $data['cantidad_gemas'];
          $gemascanjeadas = $data['cantidad_gemas'];
          if($data['estado_canjeo']=="Asignado"){
            $gemasAsignadas += $data['cantidad_gemas']; 
          }
          if($data['estado_canjeo']==""){
            $gemasNoAsignadas += $data['cantidad_gemas']; 
          }
          $newData[$index]['canjeadas']+=$gemascanjeadas;
          $newData[$index]['asignadas']+=$gemasAsignadas;
          $newData[$index]['noasignadas']+=$gemasNoAsignadas;
        }

        // print_r($data['gemas_inactiva']);
        // echo " | ".$razon." ".$gemas." | ".$concepto." | <br>";
      }
      
      // echo "Cliente: ".$lids['id_cliente']." ".$lids['primer_nombre']." ".$lids['primer_apellido']." - ";
      // echo "Historiales: ".count($historialx)."<br>";
      // echo "Canjeadas: ".$newData[$index]['canjeadas']." | ";
      // echo "Asignadas: ".$newData[$index]['asignadas']." | ";
      // echo "NO Asignadas: ".$newData[$index]['noasignadas']." | ";
      // echo "<br>";
      // echo "<br>";


      // }
      $index++;
    }
  }
  // echo "Registros: ".count($newData);
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