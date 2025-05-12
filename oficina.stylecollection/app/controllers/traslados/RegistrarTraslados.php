<?php 
$amInventario = 0;
$amInventarioR = 0;
$amInventarioC = 0;
$amInventarioE = 0;
$amInventarioB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Productos"){
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
if($amInventarioR == 1){
  $limiteElementos=50;

  if(!empty($_POST['tipoInv']) && !empty($_POST['transaccion']) && empty($_POST['validarData'])){
    // $allTraslados = $lider->consultarQuery("SELECT * FROM operaciones WHERE ")
    // $operaciones = $lider->consultarQuery("SELECT operaciones.numero_documento as numero_documento FROM operaciones WHERE operaciones.transaccion='Traslados';");
    $operaciones = $lider->consultarQuery("SELECT DISTINCT operaciones.numero_documento as numero_documento FROM operaciones WHERE operaciones.transaccion='Traslados' ORDER BY id_operacion DESC LIMIT 1;");
    
    // if(count($operaciones)>1){
    //   $numDoc = substr($operaciones[0]['numero_documento'],3);
    //   $newNumDoc=($numDoc+1);
    //   $numero_traslado = "TR.".$newNumDoc;
    //   // $numero_traslado = ($operaciones[0]['numero_documento'])+1;
    // }else{
    //   $numero_traslado = "TR.1";
    // }
    if(count($operaciones)>1){
      $pos = strpos($operaciones[0]['numero_documento'], 'TR.');
      if(strlen($pos)==0){
        $numDoc = (float) $operaciones[0]['numero_documento'];
      }else{
        $numDoc = (float) substr($operaciones[0]['numero_documento'],3);
      }
      $numero_trasladoN = ($numDoc+1);
      $numero_traslado = "TR.".$numero_trasladoN;
      // echo "<br>";
      // echo "Numero documento: ".$numDoc."<br>";
      // echo "Numero documento: ".$numero_trasladoN."<br>";
      // echo "Numero de Operacion: ".$numero_traslado;
      // die();
    }else{
      $numero_traslado = "TR.1";
    }

    $fecha_operacion = date('Y-m-d H:i:s');
    $tipo_inventario = $_POST['tipoInv'];
    $transaccion = $_POST['transaccion'];
    $concepto_operaciones="Traslados De Almacen";
    $id_persona = 0;
    $tipo_persona = "";
    
    $fecha_documento = $_POST['fecha_documento'];
    $cantidad_elementos = $_POST['cantidad_elementos'];
    
    $stocks = $_POST['stock'];
    $precios = $_POST['precio'];
    // echo "<br><br>";
    $erroresEjecucion = 0;
    for ($i=0; $i < $cantidad_elementos; $i++) { 
      $id_almacen = $_POST['almacen'];
      $id_elementoInvs = $_POST["inventario{$tipo_inventario}{$id_almacen}"];
      $tipo_operacion="Salida";
      // echo "<br><br>".$i.":<br>";
      $stock = $stocks[$i];
      $id_elementoInv = $id_elementoInvs[$i];
      $total = -1;
      $precio_nota = 0;
      if($precios[$i]!="" && $precios[$i] > 0){
        $precio_nota = (float) number_format($precios[$i],2,'.','');
      }
      // echo "Stock: ".$stock."<br>";
      // echo "Inventario: ".$id_elementoInv."<br>";
      // echo "Total: ".$total."<br>";

      $buscar = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$id_elementoInv} and tipo_inventario='{$tipo_inventario}' and estatus=1 ORDER BY id_operacion DESC;");
      $stock_total = 0;
      $total_total = 0;
      if(count($buscar)>1){
        if(!empty($buscar[0])){
          $lasted = $buscar[0];
          // print_r($lasted);
          // echo "<br><br>";
          $stock_total = $lasted['stock_operacion_total'];
          $total_total = $lasted['total_operacion_total'];
          if($total==(-1)){
            $total = ($total_total/$stock_total);
            $total = $total*$stock;
          }
        }
      }
      if($tipo_operacion=="Salida"){
        $stock_total -= $stock;
        $total_total -= $total;
      }
      $buscar = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$id_elementoInv} and id_almacen={$id_almacen} and tipo_inventario='{$tipo_inventario}' and estatus=1 ORDER BY id_operacion DESC;");
      $stock_totalAl = 0;
      $total_totalAl = 0;
      if(count($buscar)>1){
        if(!empty($buscar[0])){
          $lasted = $buscar[0];
          $stock_totalAl = $lasted['stock_operacion_almacen'];
          $total_totalAl = $lasted['total_operacion_almacen'];
        }
      }
      if($tipo_operacion=="Salida"){
        $stock_totalAl -= $stock;
        $total_totalAl -= $total;
      }


      // $total=(float) number_format(($stock*$costoHistorico),2,'.','');
      // $total_totalAl=(float) number_format(($stock_totalAl*$costoHistorico),2,'.','');
      // $total_total=(float) number_format(($stock_total*$costoHistorico),2,'.','');
      $buscarCostos=$lider->consultarQuery("SELECT * FROM cartelera_costos WHERE id_inventario={$id_elementoInv} and tipo_inventario='{$tipo_inventario}' ORDER BY id_cartelera_costo DESC LIMIT 1");
      if(count($buscarCostos)>1){
        $costoHistorico = $buscarCostos[0]['costo_historico'];
        $costoPromedio = $buscarCostos[0]['costo_promedio'];
        $total=(float) number_format(($stock*$costoPromedio),2,'.','');
        $total_totalAl=(float) number_format(($stock_totalAl*$costoPromedio),2,'.','');
        $total_total=(float) number_format(($stock_total*$costoPromedio),2,'.','');
      }
      $query = "INSERT INTO operaciones (id_operacion, tipo_operacion, transaccion, concepto, tipo_persona, id_personal, id_inventario, id_almacen, tipo_inventario, fecha_operacion, fecha_documento, numero_documento, stock_operacion, total_operacion, stock_operacion_almacen, total_operacion_almacen, stock_operacion_total, total_operacion_total, precio_nota, estatus) VALUES (DEFAULT, '$tipo_operacion', '$transaccion', '{$concepto_operaciones}', '$tipo_persona', $id_persona, $id_elementoInv, $id_almacen, '$tipo_inventario', '$fecha_operacion', '$fecha_documento', '$numero_traslado', $stock, $total, $stock_totalAl, $total_totalAl, $stock_total, $total_total, $precio_nota, 1)";
      // echo "<br><br>".$query."<br><br><br>";
      // $exec=['ejecucion'=>true];
      $exec = $lider->registrar($query, "operaciones", "id_operacion");
      if($exec['ejecucion']==true){
        $responseR = "1";
        $fecha_operacion = date('Y-m-d H:i:s', time()+1);
        $tipo_operacion="Entrada";
        $id_almacen=$_POST['almacen2'];
        $buscar = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$id_elementoInv} and tipo_inventario='{$tipo_inventario}' and estatus=1 ORDER BY id_operacion DESC;");
        $stock_total = 0;
        $total_total = 0;
        if(count($buscar)>1){
          if(!empty($buscar[0])){
            $lasted = $buscar[0];
            // print_r($lasted);
            // echo "<br><br>";
            $stock_total = $lasted['stock_operacion_total'];
            $total_total = $lasted['total_operacion_total'];
            if($total==(-1)){
              $total = (float) number_format(($total_total/$stock_total),2,'.','');
              $total = (float) number_format($total*$stock,2,'.','');
            }
          }
        }
        if($tipo_operacion=="Entrada"){
          $stock_total += $stock;
          $total_total += $total;
        }
        $buscar = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_inventario={$id_elementoInv} and id_almacen={$id_almacen} and tipo_inventario='{$tipo_inventario}' and estatus=1 ORDER BY id_operacion DESC;");
        $stock_totalAl = 0;
        $total_totalAl = 0;
        if(count($buscar)>1){
          if(!empty($buscar[0])){
            $lasted = $buscar[0];
            $stock_totalAl = $lasted['stock_operacion_almacen'];
            $total_totalAl = $lasted['total_operacion_almacen'];
          }
        }
        if($tipo_operacion=="Entrada"){
          $stock_totalAl += $stock;
          $total_totalAl += $total;
        }

        
        if(count($buscarCostos)>1){
          $costoHistorico = $buscarCostos[0]['costo_historico'];
          $costoPromedio = $buscarCostos[0]['costo_promedio'];
          $total=(float) number_format(($stock*$costoHistorico),2,'.','');
          $total_totalAl=(float) number_format(($stock_totalAl*$costoHistorico),2,'.','');
          $total_total=(float) number_format(($stock_total*$costoHistorico),2,'.','');
        }
        $query = "INSERT INTO operaciones (id_operacion, tipo_operacion, transaccion, concepto, tipo_persona, id_personal, id_inventario, id_almacen, tipo_inventario, fecha_operacion, fecha_documento, numero_documento, stock_operacion, total_operacion, stock_operacion_almacen, total_operacion_almacen, stock_operacion_total, total_operacion_total, precio_nota, estatus) VALUES (DEFAULT, '$tipo_operacion', '$transaccion', '{$concepto_operaciones}', '$tipo_persona', $id_persona, $id_elementoInv, $id_almacen, '$tipo_inventario', '$fecha_operacion', '$fecha_documento', '$numero_traslado', $stock, $total, $stock_totalAl, $total_totalAl, $stock_total, $total_total, $precio_nota, 1)";
        // echo "<br><br>".$query."<br><br><br>";
        $exec = $lider->registrar($query, "operaciones", "id_operacion");
        if($exec['ejecucion']==true){
          $responseR = "1";
        }else{
          $responseR = "2";
          $erroresEjecucion++;
        }
      }else{
        $responseR = "2";
        $erroresEjecucion++;
      }
      
    }

    // die();
    if($erroresEjecucion==0){
      $response="1";
      if(!empty($modulo) && !empty($accion)){
        $fecha = date('Y-m-d');
        $hora = date('H:i:a');
        $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Operaciones (Traslados)', 'Registrar', '{$fecha}', '{$hora}')";
        $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
      }
    }else{
      $response="2";
    }
    


    foreach($tipoInventarios as $tp){ if(!empty($tp['id'])){
      $proveedoress = $lider->consultarQuery("SELECT * FROM proveedores_inventarios WHERE proveedores_inventarios.tipoInventario LIKE '%{$tp['id']}%' and  proveedores_inventarios.estatus = 1 ORDER BY proveedores_inventarios.nombreProveedor ASC;");
      $proveedores[$tp['id']] = $proveedoress;
    } }
    $clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1");
    $productosAll = $lider->consultarQuery("SELECT * FROM productos WHERE estatus=1");
    $mercanciaAll = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1");
    $almacenes = $lider->consultarQuery("SELECT * FROM almacenes WHERE estatus=1");
    $productos = [];
    $mercancia = [];
    // foreach($almacenes as $almacen){ if(!empty($almacen['id_almacen'])){
    //   $index=0;
    //   foreach($productosAll as $pd){ if(!empty($pd['id_producto'])){
    //     $operacionesInv = $lider->consultarQuery("SELECT * FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_producto']} and id_almacen={$almacen['id_almacen']} and tipo_inventario='Productos' ORDER BY id_operacion DESC");
    //     if(count($operacionesInv)>1){
    //       if($operacionesInv[0]['stock_operacion_total']>0){
    //         $productos[$almacen['id_almacen']][$index]=$pd;
    //         $productos[$almacen['id_almacen']][$index]['stock_operacion_total'] = $operacionesInv[0]['stock_operacion_total'];
    //         $productos[$almacen['id_almacen']][$index]['stock_operacion_almacen'] = $operacionesInv[0]['stock_operacion_almacen'];
    //         $index++;
    //       }
    //     }
    //   } }

    //   $index=0;
    //   foreach($mercanciaAll as $pd){ if(!empty($pd['id_mercancia'])){
    //     $operacionesInv = $lider->consultarQuery("SELECT * FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_mercancia']} and id_almacen={$almacen['id_almacen']} and tipo_inventario='Mercancia' ORDER BY id_operacion DESC");
    //     if(count($operacionesInv)>1){
    //       if($operacionesInv[0]['stock_operacion_total']>0){
    //         $mercancia[$almacen['id_almacen']][$index]=$pd;
    //         $mercancia[$almacen['id_almacen']][$index]['stock_operacion_total'] = $operacionesInv[0]['stock_operacion_total'];
    //         $productos[$almacen['id_almacen']][$index]['stock_operacion_almacen'] = $operacionesInv[0]['stock_operacion_almacen'];
    //         $index++;
    //       }
    //     }
    //   } }


    //   foreach ($productos as $key) {
    //     print_r($key);
    //     echo "<br><br>";
    //   }
      
      
    // } }
    foreach($almacenes as $almacen){ if(!empty($almacen['id_almacen'])){
      $index=0;
      foreach($productosAll as $pd){ if(!empty($pd['id_producto'])){
        $operacionesInv = $lider->consultarQuery("SELECT * FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_producto']} and id_almacen={$almacen['id_almacen']} and tipo_inventario='Productos' ORDER BY id_operacion DESC");
        if(count($operacionesInv)>1){
          if($operacionesInv[0]['stock_operacion_total']>0){
            $productos[$almacen['id_almacen']][$index]=$pd;
            $productos[$almacen['id_almacen']][$index]['stock_operacion_total'] = $operacionesInv[0]['stock_operacion_total'];
            $productos[$almacen['id_almacen']][$index]['stock_operacion_almacen'] = $operacionesInv[0]['stock_operacion_almacen'];
            $index++;
          }
        }
      } }

      $index=0;
      foreach($mercanciaAll as $pd){ if(!empty($pd['id_mercancia'])){
        $operacionesInv = $lider->consultarQuery("SELECT * FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_mercancia']} and id_almacen={$almacen['id_almacen']} and tipo_inventario='Mercancia' ORDER BY id_operacion DESC");
        if(count($operacionesInv)>1){
          if($operacionesInv[0]['stock_operacion_total']>0){
            $mercancia[$almacen['id_almacen']][$index]=$pd;
            $mercancia[$almacen['id_almacen']][$index]['stock_operacion_total'] = $operacionesInv[0]['stock_operacion_total'];
            $mercancia[$almacen['id_almacen']][$index]['stock_operacion_almacen'] = $operacionesInv[0]['stock_operacion_almacen'];
            // $mercancia[$almacen['id_almacen']][$index]['total_operacion_total'] = $operacionesInv[0]['total_operacion_total'];
            $index++;
          }
        }
      } }
      
    } }
    // foreach($productos as $key){
    //   print_r($key);
    //   echo "<br><br>";
    // }

    $rutaPdfTraslados = "route=Traslados&action=GenerarOrden&cod=".$numero_traslado;
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
    // print_r($exec);
  }
  if(empty($_POST)){
    foreach($tipoInventarios as $tp){ if(!empty($tp['id'])){
      $proveedoress = $lider->consultarQuery("SELECT * FROM proveedores_inventarios WHERE proveedores_inventarios.tipoInventario LIKE '%{$tp['id']}%' and  proveedores_inventarios.estatus = 1 ORDER BY proveedores_inventarios.nombreProveedor ASC;");
      $proveedores[$tp['id']] = $proveedoress;
    } }

    $clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE estatus=1");
    $productosAll = $lider->consultarQuery("SELECT * FROM productos WHERE estatus=1");
    $mercanciaAll = $lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1");
    $almacenes = $lider->consultarQuery("SELECT * FROM almacenes WHERE estatus=1");
    $productos = [];
    $mercancia = [];
    // foreach($almacenes as $almacen){ if(!empty($almacen['id_almacen'])){
    //   $index=0;
    //   foreach($productosAll as $pd){ if(!empty($pd['id_producto'])){
    //     $operacionesInv = $lider->consultarQuery("SELECT * FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_producto']} and id_almacen={$almacen['id_almacen']} and tipo_inventario='Productos' ORDER BY id_operacion DESC");
    //     if(count($operacionesInv)>1){
    //       if($operacionesInv[0]['stock_operacion_total']>0){
    //         $productos[$almacen['id_almacen']][$index]=$pd;
    //         $productos[$almacen['id_almacen']][$index]['stock_operacion_total'] = $operacionesInv[0]['stock_operacion_total'];
    //         $productos[$almacen['id_almacen']][$index]['stock_operacion_almacen'] = $operacionesInv[0]['stock_operacion_almacen'];
    //         $index++;
    //       }
    //     }
    //   } }

    //   $index=0;
    //   foreach($mercanciaAll as $pd){ if(!empty($pd['id_mercancia'])){
    //     $operacionesInv = $lider->consultarQuery("SELECT * FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_mercancia']} and id_almacen={$almacen['id_almacen']} and tipo_inventario='Mercancia' ORDER BY id_operacion DESC");
    //     if(count($operacionesInv)>1){
    //       if($operacionesInv[0]['stock_operacion_total']>0){
    //         $mercancia[$almacen['id_almacen']][$index]=$pd;
    //         $mercancia[$almacen['id_almacen']][$index]['stock_operacion_total'] = $operacionesInv[0]['stock_operacion_total'];
    //         $productos[$almacen['id_almacen']][$index]['stock_operacion_almacen'] = $operacionesInv[0]['stock_operacion_almacen'];
    //         $index++;
    //       }
    //     }
    //   } }
      
    // } }

    foreach($almacenes as $almacen){ if(!empty($almacen['id_almacen'])){
      $index=0;
      foreach($productosAll as $pd){ if(!empty($pd['id_producto'])){
        $operacionesInv = $lider->consultarQuery("SELECT * FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_producto']} and id_almacen={$almacen['id_almacen']} and tipo_inventario='Productos' ORDER BY id_operacion DESC");
        if(count($operacionesInv)>1){
          if($operacionesInv[0]['stock_operacion_total']>0){
            $productos[$almacen['id_almacen']][$index]=$pd;
            $productos[$almacen['id_almacen']][$index]['stock_operacion_total'] = $operacionesInv[0]['stock_operacion_total'];
            $productos[$almacen['id_almacen']][$index]['stock_operacion_almacen'] = $operacionesInv[0]['stock_operacion_almacen'];
            $index++;
          }
        }
      } }

      $index=0;
      foreach($mercanciaAll as $pd){ if(!empty($pd['id_mercancia'])){
        $operacionesInv = $lider->consultarQuery("SELECT * FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_mercancia']} and id_almacen={$almacen['id_almacen']} and tipo_inventario='Mercancia' ORDER BY id_operacion DESC");
        if(count($operacionesInv)>1){
          if($operacionesInv[0]['stock_operacion_total']>0){
            $mercancia[$almacen['id_almacen']][$index]=$pd;
            $mercancia[$almacen['id_almacen']][$index]['stock_operacion_total'] = $operacionesInv[0]['stock_operacion_total'];
            $mercancia[$almacen['id_almacen']][$index]['stock_operacion_almacen'] = $operacionesInv[0]['stock_operacion_almacen'];
            // $mercancia[$almacen['id_almacen']][$index]['total_operacion_total'] = $operacionesInv[0]['total_operacion_total'];
            $index++;
          }
        }
      } }
      
    } }

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