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
  if(!empty($_POST)){
    if(!empty($_POST['precios']) && !empty($_POST['id_operacion'])){
      $precios = $_POST['precios'];
      $operaciones = $_POST['id_operacion'];
      $errores=0;
      for ($i=0; $i < count($precios); $i++) { 
        $precio_nota = (float) number_format($precios[$i],2,'.','');
        $id_operacion = $operaciones[$i];
        $query = "UPDATE operaciones SET precio_nota={$precio_nota} WHERE id_operacion={$id_operacion}";
        $exec = $lider->modificar($query);
        if($exec['ejecucion']==true){
        }else{
          $errores++;
        }
      }
      if($errores==0){
        $response="11";
      }else{
        $response="2";
      }
    }
  }
  // if(empty($_POST)){
    $filterFechas = "";
    if(!empty($_GET['fechaa']) && !empty($_GET['fechac'])){
      $fechaa=$_GET['fechaa'];
      $fechac=$_GET['fechac'];
      $filterFechas.=" and operaciones.fecha_operacion BETWEEN '{$fechaa} 00:00:00' and '{$fechac} 23:59:59'";
    }
    $controlesTraslados = $lider->consultarQuery("SELECT DISTINCT numero_documento FROM operaciones WHERE operaciones.transaccion='Traslados' and operaciones.numero_documento LIKE 'TR.%'{$filterFechas}");
    $traslados = [];
    $index=0;
    foreach ($controlesTraslados as $key) {
        if(!empty($key['numero_documento'])){
            $trasladoss = $lider->consultarQuery("SELECT * FROM operaciones WHERE operaciones.transaccion='Traslados' and numero_documento='{$key['numero_documento']}'");
            foreach($trasladoss as $keys){
                if(!empty($keys['id_operacion'])){
                    // print_r($keys);
                    // echo "<br><br>";
                    $traslados[$index]['stock_operacion']=$keys['stock_operacion'];      
                    $traslados[$index]['total_operacion']=$keys['total_operacion'];      
                    $traslados[$index]['numero_documento']=$keys['numero_documento'];      
                    $traslados[$index]['fecha_documento']=$keys['fecha_documento'];      
                    $traslados[$index]['fecha_operacion']=$keys['fecha_operacion'];      
                    $traslados[$index]['tipo_inventario']=$keys['tipo_inventario'];      
                    $traslados[$index]['id_inventario']=$keys['id_inventario'];      
                    if($keys['tipo_operacion']=="Salida"){
                        $traslados[$index]['id_almacen_salida']=$keys['id_almacen'];
                    }
                    if($keys['tipo_operacion']=="Entrada"){
                        $traslados[$index]['id_almacen_entrada']=$keys['id_almacen'];
                    }
                }
            }
            $index++;
            // echo "<br><br>";
        }
    }
    // print_r($traslados);
    for ($i=0; $i < count($traslados); $i++) {
        $trass = $traslados[$i];
        if($trass['tipo_inventario']=="Productos"){
            $inventario = $lider->consultarQuery("SELECT *, codigo_producto as codigo, producto as elemento FROM productos WHERE id_producto={$trass['id_inventario']}");
        }
        if($trass['tipo_inventario']=="Mercancia"){
            $inventario = $lider->consultarQuery("SELECT *, codigo_mercancia as codigo, mercancia as elemento FROM mercancia WHERE id_mercancia={$trass['id_inventario']}");
        }
        foreach ($inventario as $key) {
            if(!empty($key['elemento'])){
                $traslados[$i]['elemento']=$key['elemento'];
                $traslados[$i]['codigo']=$key['codigo'];
            }
        }
        $almacen = $lider->consultarQuery("SELECT * FROM almacenes WHERE id_almacen={$trass['id_almacen_salida']}");
        foreach ($almacen as $key) {
            if(!empty($key['id_almacen'])){
                $traslados[$i]['nombre_almacen_salida']=$key['nombre_almacen'];
                $traslados[$i]['direccion_almacen_salida']=$key['direccion_almacen'];
            }
        }
        $almacen = $lider->consultarQuery("SELECT * FROM almacenes WHERE id_almacen={$trass['id_almacen_entrada']}");
        foreach ($almacen as $key) {
            if(!empty($key['id_almacen'])){
                $traslados[$i]['nombre_almacen_entrada']=$key['nombre_almacen'];
                $traslados[$i]['direccion_almacen_entrada']=$key['direccion_almacen'];
            }
        }
    }
    $aux=$traslados;
    // print_r($traslados);
    $traslados=[];
    $index=0;
    for ($i=count($aux)-1; $i >= 0; $i--) { 
      $traslados[$index]=$aux[$i];
      $index++;
      // echo ": ".$i." | ";
    }
    // foreach($traslados as $trass){
    //     print_r($trass);
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

// }else{
//     require_once 'public/views/error404.php';
// }


?>