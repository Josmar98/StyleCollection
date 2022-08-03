<?php 


$amDespachos = 0;
$amDespachosR = 0;
$amDespachosC = 0;
$amDespachosE = 0;
$amDespachosB = 0;

foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Despachos"){
      $amDespachos = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amDespachosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amDespachosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amDespachosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amDespachosB = 1;
      }
    }
  }
}
if($amDespachosE == 1){

    $id_campana = $_GET['campaing'];
    $numero_campana = $_GET['n'];
    $anio_campana = $_GET['y'];


    if(!empty($_POST['validarData'])){
      $numero_despacho = $_POST['numero_despacho'];
      // echo 'Numero: '.$numero_despacho;
      // echo 'Id: '.$id_campana;
      $query = "SELECT * FROM despachos WHERE numero_despacho = $numero_despacho and id_campana = $id_campana";
      $res1 = $lider->consultarQuery($query);
      // print_r($res1);
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


    if(!empty($_POST['numero_despacho']) && empty($_POST['validarData'])){
      // print_r($_POST);
      $numero_despacho = $_POST['numero_despacho'];
      $fecha_inicial = $_POST['inicial'];
      $primer_pago = $_POST['primer_pago'];
      $segundo_pago = $_POST['segundo_pago'];
      $limite_pedido = $_POST['limite_pedido'];
      $limite_seleccion_plan = $_POST['limite_seleccion_plan'];
      
      $precio_coleccion = $_POST['precio_coleccion'];
      $primer_precio = $_POST['precio1'];
      $segundo_precio = $_POST['precio2'];
      $inicial_precio = $_POST['precioInn'];
      $precio_contado = $_POST['precioContado'];


      $fecha_inicial_senior = $_POST['inicial_senior'];
      $primer_pago_senior = $_POST['primer_pago_senior'];
      $segundo_pago_senior = $_POST['segundo_pago_senior'];
      
      /*-----------------------------------------------------------*/
      $cantidad_productos = $_POST['cantidad_productos'];
      $elementosid = $_POST['elementosid'];
      $cheking = $_POST['cheking'];
      $precios = $_POST['precios'];
      /*-----------------------------------------------------------*/

      $query = "UPDATE despachos SET numero_despacho=$numero_despacho, fecha_inicial='$fecha_inicial', fecha_primera='$primer_pago', fecha_segunda='$segundo_pago', limite_pedido = '$limite_pedido', limite_seleccion_plan = '$limite_seleccion_plan',  precio_coleccion='$precio_coleccion',  primer_precio_coleccion='$primer_precio', segundo_precio_coleccion='$segundo_precio', inicial_precio_coleccion='$inicial_precio', fecha_inicial_senior = '{$fecha_inicial_senior}', fecha_primera_senior='{$primer_pago_senior}', fecha_segunda_senior='{$segundo_pago_senior}', contado_precio_coleccion='{$precio_contado}', estatus = 1 WHERE id_despacho = $id";

      $exec = $lider->modificar($query);
      if($exec['ejecucion'] == true){
        // $response = "1";
        // $id_despacho = $exec['id'];
        $exec = $lider->eliminar("DELETE FROM colecciones WHERE id_despacho = $id");
        if($exec['ejecucion'] == true){
            $numIndex = 0;
            foreach ($elementosid as $id_producto_key) {
                foreach ($cheking as $id_cantidad_key) {
                    if($id_producto_key == $id_cantidad_key){
                      $cantidad = $cantidad_productos[$numIndex];
                      $precio_producto = $precios[$numIndex];
                      $query = "INSERT INTO colecciones (id_coleccion, id_despacho, id_producto, cantidad_productos, precio_producto, estatus) VALUES (DEFAULT, $id, $id_producto_key, $cantidad, $precio_producto, 1)";
                	  	$exec = $lider->registrar($query, "colecciones", "id_coleccion");
                	  	if($exec['ejecucion']==true ){
                	  		$response = "1";
                	  	}else{
                	  		$response = "2";
                	  	}
                    }   
                }
               $numIndex++;
            }
            if($response=="1"){      
              if(!empty($modulo) && !empty($accion)){
                $fecha = date('Y-m-d');
                $hora = date('H:i:a');
                $query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Pedidos', 'Editar', '{$fecha}', '{$hora}')";
                $exec = $lider->Registrar($query, "bitacora", "id_bitacora");
              }
            }

        }else{
          $response = "2";
        }

      }else{
        $response = "2";
      }

      $productos = $lider->consultarQuery("SELECT * FROM productos, colecciones WHERE productos.id_producto = colecciones.id_producto and colecciones.id_despacho = $id and productos.estatus = 1 ORDER BY producto asc");

      $despachos=$lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id");
      $colecciones=$lider->consultarQuery("SELECT id_coleccion, colecciones.id_despacho, colecciones.id_producto, despachos.numero_despacho, colecciones.cantidad_productos, producto, descripcion, productos.cantidad as cantidad, precio_producto, colecciones.estatus FROM despachos, colecciones, productos WHERE despachos.id_despacho = colecciones.id_despacho and productos.id_producto = colecciones.id_producto and despachos.estatus = 1 and colecciones.estatus = 1 and colecciones.id_despacho = $id");
      $despacho = $despachos[0];
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
      // $despachosActual = $lider->consultarQuery("SELECT * from despachos WHERE estatus = 1 and id_campana = $id_campana");
      // $despachosActual = Count($despachosActual)-1;
      $productos = $lider->consultarQuery("SELECT * FROM productos, colecciones WHERE productos.id_producto = colecciones.id_producto and colecciones.id_despacho = $id and productos.estatus = 1 ORDER BY producto asc");

      $despachos=$lider->consultarQuery("SELECT * FROM despachos WHERE id_despacho = $id");
      $colecciones=$lider->consultarQuery("SELECT id_coleccion, colecciones.id_despacho, colecciones.id_producto, despachos.numero_despacho, colecciones.cantidad_productos, producto, descripcion, productos.cantidad as cantidad, precio_producto, colecciones.estatus FROM despachos, colecciones, productos WHERE despachos.id_despacho = colecciones.id_despacho and productos.id_producto = colecciones.id_producto and despachos.estatus = 1 and colecciones.estatus = 1 and colecciones.id_despacho = $id");
      if(Count($despachos)>1){
          $despacho = $despachos[0];
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