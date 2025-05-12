<?php 

$amInventario = 0;
$amInventarioR = 0;
$amInventarioC = 0;
$amInventarioE = 0;
$amInventarioB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Inventarios"){
      $amInventario = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amInventarioR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amInventarioC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amInventarioE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amInventarioB = 1;
      }
    }
    
  }
}
if($amInventarioC == 1){
  $limiteElementos=50;

  // if(!empty($_POST['tipoInv']) && !empty($_POST['transaccion']) && empty($_POST['validarData'])){
  //   // print_r($_POST);
  //   // die();
  //   // $numero_traslado = 
  //   $operaciones = $lider->consultarQuery("SELECT * FROM operaciones ORDER BY id_operacion DESC;");
  //   if(count($operaciones)>1){
  //     $numero_traslado = ($operaciones[0]['id_operacion'])+1;
  //   }else{
  //     $numero_traslado = 1;
  //   }

  //   $fecha_operacion = date('Y-m-d H:i:s');
  //   $tipo_operacion="Salida";
  //   $id_almacen = $_POST['almacen'];
  //   $tipo_inventario = $_POST['tipoInv'];
  //   $transaccion = $_POST['transaccion'];
  //   $id_persona = 0;
  //   $tipo_persona = "";
    
  //   $fecha_documento = $_POST['fecha_documento'];
  //   $cantidad_elementos = $_POST['cantidad_elementos'];
    
  //   $stocks = $_POST['stock'];
  //   $id_elementoInvs = $_POST["inventario{$tipo_inventario}{$id_almacen}"];
  //   // echo "<br><br>";
  //   $erroresEjecucion = 0;
  //   for ($i=0; $i < $cantidad_elementos; $i++) { 
  //     // echo "<br><br>".$i.":<br>";
  //     $stock = $stocks[$i];
  //     $id_elementoInv = $id_elementoInvs[$i];
  //     $total = -1;
  //     // echo $stock."<br>";
  //     // echo $id_elementoInv."<br>";
  //     // echo $total."<br>";

  //     $buscar = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$id_elementoInv} and tipo_inventario='{$tipo_inventario}' and estatus=1 ORDER BY id_operacion DESC;");
  //     $stock_total = 0;
  //     $total_total = 0;
  //     if(count($buscar)>1){
  //       if(!empty($buscar[0])){
  //         $lasted = $buscar[0];
  //         // print_r($lasted);
  //         // echo "<br><br>";
  //         $stock_total = $lasted['stock_operacion_total'];
  //         $total_total = $lasted['total_operacion_total'];
  //         if($total==(-1)){
  //           $total = ($total_total/$stock_total);
  //           $total = $total*$stock;
  //         }
  //       }
  //     }
  //     if($tipo_operacion=="Salida"){
  //       $stock_total -= $stock;
  //       $total_total -= $total;
  //     }
  //     $buscar = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$id_elementoInv} and id_almacen={$id_almacen} and tipo_inventario='{$tipo_inventario}' and estatus=1 ORDER BY id_operacion DESC;");
  //     $stock_totalAl = 0;
  //     $total_totalAl = 0;
  //     if(count($buscar)>1){
  //       if(!empty($buscar[0])){
  //         $lasted = $buscar[0];
  //         $stock_totalAl = $lasted['stock_operacion_almacen'];
  //         $total_totalAl = $lasted['total_operacion_almacen'];
  //       }
  //     }
  //     if($tipo_operacion=="Salida"){
  //       $stock_totalAl -= $stock;
  //       $total_totalAl -= $total;
  //     }
  //     $query = "INSERT INTO operaciones (id_operacion, tipo_operacion, transaccion, tipo_persona, id_personal, id_inventario, id_almacen, tipo_inventario, fecha_operacion, fecha_documento, numero_documento, stock_operacion, total_operacion, stock_operacion_almacen, total_operacion_almacen, stock_operacion_total, total_operacion_total, estatus) VALUES (DEFAULT, '$tipo_operacion', '$transaccion', '$tipo_persona', $id_persona, $id_elementoInv, $id_almacen, '$tipo_inventario', '$fecha_operacion', '$fecha_documento', $numero_traslado, $stock, $total, $stock_totalAl, $total_totalAl, $stock_total, $total_total, 1)";
  //     // echo "<br><br>".$query."<br><br><br>";
  //     // $exec=['ejecucion'=>true];
  //     $exec = $lider->registrar($query, "operaciones", "id_operacion");
  //     if($exec['ejecucion']==true){
  //       $responseR = "1";
  //       $fecha_operacion = date('Y-m-d H:i:s', time()+1);
  //       $tipo_operacion="Entrada";
  //       $id_almacen=$_POST['almacen2'];
  //       $buscar = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$id_elementoInv} and tipo_inventario='{$tipo_inventario}' and estatus=1 ORDER BY id_operacion DESC;");
  //       $stock_total = 0;
  //       $total_total = 0;
  //       if(count($buscar)>1){
  //         if(!empty($buscar[0])){
  //           $lasted = $buscar[0];
  //           // print_r($lasted);
  //           // echo "<br><br>";
  //           $stock_total = $lasted['stock_operacion_total'];
  //           $total_total = $lasted['total_operacion_total'];
  //           if($total==(-1)){
  //             $total = ($total_total/$stock_total);
  //             $total = $total*$stock;
  //           }
  //         }
  //       }
  //       if($tipo_operacion=="Entrada"){
  //         $stock_total += $stock;
  //         $total_total += $total;
  //       }
  //       $buscar = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$id_elementoInv} and id_almacen={$id_almacen} and tipo_inventario='{$tipo_inventario}' and estatus=1 ORDER BY id_operacion DESC;");
  //       $stock_totalAl = 0;
  //       $total_totalAl = 0;
  //       if(count($buscar)>1){
  //         if(!empty($buscar[0])){
  //           $lasted = $buscar[0];
  //           $stock_totalAl = $lasted['stock_operacion_almacen'];
  //           $total_totalAl = $lasted['total_operacion_almacen'];
  //         }
  //       }
  //       if($tipo_operacion=="Entrada"){
  //         $stock_totalAl += $stock;
  //         $total_totalAl += $total;
  //       }
  //       $query = "INSERT INTO operaciones (id_operacion, tipo_operacion, transaccion, tipo_persona, id_personal, id_inventario, id_almacen, tipo_inventario, fecha_operacion, fecha_documento, numero_documento, stock_operacion, total_operacion, stock_operacion_almacen, total_operacion_almacen, stock_operacion_total, total_operacion_total, estatus) VALUES (DEFAULT, '$tipo_operacion', '$transaccion', '$tipo_persona', $id_persona, $id_elementoInv, $id_almacen, '$tipo_inventario', '$fecha_operacion', '$fecha_documento', $numero_traslado, $stock, $total, $stock_totalAl, $total_totalAl, $stock_total, $total_total, 1)";
  //       // echo "<br><br>".$query."<br><br><br>";
  //       $exec = $lider->registrar($query, "operaciones", "id_operacion");
  //       if($exec['ejecucion']==true){
  //         $responseR = "1";
  //       }else{
  //         $responseR = "2";
  //         $erroresEjecucion++;
  //       }
  //     }else{
  //       $responseR = "2";
  //       $erroresEjecucion++;
  //     }
      
  //   }

  //   // die();
  //   if($erroresEjecucion==0){
  //     $response="1";
  //     if(!empty($modulo) && !empty($accion)){
  //       $fecha = date('Y-m-d');
  //       $hora = date('H:i:a');
  //       $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Operaciones (Traslados)', 'Registrar', '{$fecha}', '{$hora}')";
  //       $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
  //     }
  //   }else{
  //     $response="2";
  //   }
    


  //   foreach($tipoInventarios as $tp){ if(!empty($tp['id'])){
  //     $proveedoress = $lider->consultarQuery("SELECT * FROM proveedores_inventarios WHERE proveedores_inventarios.tipoInventario LIKE '%{$tp['id']}%' and  proveedores_inventarios.estatus = 1 ORDER BY proveedores_inventarios.nombreProveedor ASC;");
  //     $proveedores[$tp['id']] = $proveedoress;
  //   } }
  //   $clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1");
  //   $productosAll = $lider->consultarQuery("SELECT * FROM productos WHERE estatus=1");
  //   $mercanciaAll = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1");
  //   $almacenes = $lider->consultarQuery("SELECT * FROM almacenes WHERE estatus=1");
  //   $productos = [];
  //   $mercancia = [];
  //   foreach($almacenes as $almacen){ if(!empty($almacen['id_almacen'])){
  //     $index=0;
  //     foreach($productosAll as $pd){ if(!empty($pd['id_producto'])){
  //       $operacionesInv = $lider->consultarQuery("SELECT * FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_producto']} and id_almacen={$almacen['id_almacen']} and tipo_inventario='Productos' ORDER BY id_operacion DESC");
  //       if(count($operacionesInv)>1){
  //         if($operacionesInv[0]['stock_operacion_total']>0){
  //           $productos[$almacen['id_almacen']][$index]=$pd;
  //           $productos[$almacen['id_almacen']][$index]['stock_operacion_total'] = $operacionesInv[0]['stock_operacion_total'];
  //           $productos[$almacen['id_almacen']][$index]['stock_operacion_almacen'] = $operacionesInv[0]['stock_operacion_almacen'];
  //           $index++;
  //         }
  //       }
  //     } }

  //     $index=0;
  //     foreach($mercanciaAll as $pd){ if(!empty($pd['id_mercancia'])){
  //       $operacionesInv = $lider->consultarQuery("SELECT * FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_mercancia']} and id_almacen={$almacen['id_almacen']} and tipo_inventario='Mercancia' ORDER BY id_operacion DESC");
  //       if(count($operacionesInv)>1){
  //         if($operacionesInv[0]['stock_operacion_total']>0){
  //           $mercancia[$almacen['id_almacen']][$index]=$pd;
  //           $mercancia[$almacen['id_almacen']][$index]['stock_operacion_total'] = $operacionesInv[0]['stock_operacion_total'];
  //           $productos[$almacen['id_almacen']][$index]['stock_operacion_almacen'] = $operacionesInv[0]['stock_operacion_almacen'];
  //           $index++;
  //         }
  //       }
  //     } }
      
  //   } }
  //   if(!empty($action)){
  //     if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
  //       require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
  //     }else{
  //         require_once 'public/views/error404.php';
  //     }
  //   }else{
  //     if (is_file('public/views/'.$url.'.php')) {
  //       require_once 'public/views/'.$url.'.php';
  //     }else{
  //         require_once 'public/views/error404.php';
  //     }
  //   } 
  //   // print_r($exec);
  // }
  if(empty($_POST)){
    $filterFechas = "";
    if(!empty($_GET['fechaa']) && !empty($_GET['fechac'])){
      $fechaa=$_GET['fechaa'];
      $fechac=$_GET['fechac'];
      $filterFechas.=" and operaciones.fecha_operacion BETWEEN '{$fechaa} 00:00:00' and '{$fechac} 23:59:59'";
    }
    $controlesSalidas = $lider->consultarQuery("SELECT DISTINCT numero_documento FROM operaciones WHERE operaciones.tipo_operacion='Salida' and operaciones.numero_documento LIKE 'SA.%'{$filterFechas}");
    $ventas = [];
    $index=0;
    foreach ($controlesSalidas as $key) {
      if(!empty($key['numero_documento'])){
        $salidasss = $lider->consultarQuery("SELECT DISTINCT tipo_operacion, transaccion, tipo_persona, id_personal, id_almacen, fecha_documento, numero_documento FROM operaciones WHERE operaciones.tipo_operacion='Salida' and operaciones.transaccion='Venta' and numero_documento='{$key['numero_documento']}'");
        foreach($salidasss as $keys){
          if(!empty($keys['tipo_operacion'])){
            $ventas[$index]['tipo_operacion']=$keys['tipo_operacion'];      
            $ventas[$index]['transaccion']=$keys['transaccion'];      
            $ventas[$index]['tipo_persona']=$keys['tipo_persona'];      
            $ventas[$index]['id_personal']=$keys['id_personal'];      
            $ventas[$index]['id_almacen']=$keys['id_almacen'];      
            $ventas[$index]['fecha_documento']=$keys['fecha_documento'];      
            $ventas[$index]['numero_documento']=$keys['numero_documento'];
            $index++;
          }
        }
      }
    }
    for ($i=0; $i < count($ventas); $i++) {
        $venta = $ventas[$i];
        if($venta['tipo_persona']=="Cliente"){
          $persona = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente={$venta['id_personal']}");
        }
        if($venta['tipo_persona']=="Empleado"){
          $persona = $lider->consultarQuery("SELECT * FROM empleados WHERE id_empleado={$venta['id_personal']}");
        }
        if($venta['tipo_persona']=="Autorizado"){
          $persona[0] = $infoInternos[$venta['id_personal']];
        }
        foreach ($persona as $key) {
          // print_r($ventas[$i]);
          // print_r($key);
          // echo "<br><br>";
          if(!empty($key['primer_nombre'])){
              $ventas[$i]['cod_cedula']=$key['cod_cedula'];
              $ventas[$i]['cedula']=$key['cedula'];
              $ventas[$i]['cod_rif']=$key['cod_rif'];
              $ventas[$i]['rif']=$key['rif'];
              $ventas[$i]['primer_nombre']=$key['primer_nombre'];
              $ventas[$i]['primer_apellido']=$key['primer_apellido'];
            }
        }

        $operacionesss = $lider->consultarQuery("SELECT * FROM operaciones WHERE operaciones.tipo_operacion='Salida' and operaciones.transaccion='Venta' and operaciones.numero_documento='{$ventas[$i]['numero_documento']}' ORDER BY id_operacion DESC;");
        $ventas[$i]['fecha_operacion']=$operacionesss[0]['fecha_operacion'];
        $ventas[$i]['leyenda']=$operacionesss[0]['leyenda'];
        $precioVenta = 0;
        foreach ($operacionesss as $keys) {
          if(!empty($keys['numero_documento'])){
            $precioVenta+=$keys['precio_venta'];
          }
        }
        $ventas[$i]['precioVenta']=$precioVenta;

    }

    // foreach($ventas as $venta){
    //     print_r($venta);
    //     echo "<br><br>";
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